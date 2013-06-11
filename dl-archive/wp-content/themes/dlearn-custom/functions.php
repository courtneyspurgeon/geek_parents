<?php
/**
 * DLearn-Custom theme functions and definitions
 *
 * @package BuddyPress
 * @subpackage DLearn-Custom
 */

if ( ! function_exists( 'theme_styles' ) ) :

function theme_styles()  
{ 
    $version = '20120210';
    wp_register_style( 'bootstrap-min', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', array(), '2.2.2' );
    wp_register_style( 'bootstrap-responsive', get_stylesheet_directory_uri() . '/css/bootstrap-responsive.min.css', array(), '2.2.2' );
    wp_enqueue_style( 'bootstrap-min' );
    wp_enqueue_style( 'bootstrap-responsive' );
}

add_action('wp_enqueue_scripts', 'theme_styles');
endif;

if ( ! function_exists( 'theme_scripts' ) ) :

function theme_scripts()  
{ 
    $version = '20120212';
    // Let's go ahead and load useful stuff
    wp_deregister_script('jquery'); // Google's CDN below
    wp_enqueue_script( 'jquery','https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js', array(), '1.8.1', true );

    // Rest of stuff and dependencies
    // wp_enqueue_script( 'jquery-bbq', get_stylesheet_directory_uri() . '/js/jquery.ba-bbq.min.js', array( 'jquery' ), '1.2.1', true );
    wp_enqueue_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '2.2.2', true );
    wp_enqueue_script( 'dlearn-custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' ), $version, true );
}

add_action('wp_enqueue_scripts', 'theme_scripts');
endif;

// load in the admin view
function sticky_admin_enqueue($hook) {
    if( 'posts_page_order-sticky-posts' != $hook )
        return;
    wp_enqueue_script( 'jquery-ui-sortable');
}
add_action( 'admin_enqueue_scripts', 'sticky_admin_enqueue' );


function get_post_favorite($post) 
{
    $activity_id = bp_activity_get_activity_id( array(
        'user_id' => $post->post_author,
        'type' => 'new_blog_post',
        'component' => 'blogs',
        'item_id' => 1,
        'secondary_item_id' => $post->ID
    ));

    if ( is_user_logged_in() ) 
    {
        bp_has_activities();
        return my_bp_activity_is_favorite($activity_id) ? true : false;
    }
}

function custom_excerpt_length( $length ) {
	return 70;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function new_excerpt_more( $more ) {
    global $post;
    return ' <a href="'. get_permalink($post->ID) . '">Continue Reading...</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');


if ( !function_exists( 'bp_dtheme_blog_comments' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own bp_dtheme_blog_comments(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @param mixed $comment Comment record from database
 * @param array $args Arguments from wp_list_comments() call
 * @param int $depth Comment nesting level
 * @see wp_list_comments()
 * @since 1.2
 */
function bp_dtheme_blog_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type )
		return false;

	if ( 1 == $depth )
		$avatar_size = 50;
	else
		$avatar_size = 25;
	?>

	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<div class="comment-avatar-box">
			<div class="avb">
				<a href="<?php echo get_comment_author_url(); ?>" rel="nofollow">
					<?php if ( $comment->user_id ) : ?>
						<?php echo bp_core_fetch_avatar( array( 'item_id' => $comment->user_id, 'width' => $avatar_size, 'height' => $avatar_size, 'email' => $comment->comment_author_email ) ); ?>
					<?php else : ?>
						<?php echo get_avatar( $comment, $avatar_size ); ?>
					<?php endif; ?>
				</a>
			</div>
		</div>

		<div class="comment-content">
			<div class="comment-meta">
				<p>
					<?php
						/* translators: 1: comment author url, 2: comment author name, 3: comment permalink, 4: comment date/timestamp*/
						printf( __( '<a href="%1$s" rel="nofollow">%2$s</a> said on <a href="%3$s"><span class="time-since">%4$s</span></a>', 'buddypress' ), get_comment_author_url(), get_comment_author(), get_comment_link(), get_comment_date() );
					?>
				</p>
			</div>

			<div class="comment-entry">
				<?php if ( $comment->comment_approved == '0' ) : ?>
				 	<em class="moderate"><?php _e( 'Your comment is awaiting moderation.', 'buddypress' ); ?></em>
				<?php endif; ?>

				<?php comment_text(); ?>
			</div>

			<div class="comment-options">

                    <a class="comment-reply-link" href="">Move to a Conversation</a>

					<?php if ( comments_open() ) : ?>
						<?php comment_reply_link( array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ); ?>
					<?php endif; ?>

					<?php if ( current_user_can( 'edit_comment', $comment->comment_ID ) ) : ?>
						<?php printf( '<a class="button comment-edit-link bp-secondary-action" href="%1$s" title="%2$s">%3$s</a> ', get_edit_comment_link( $comment->comment_ID ), esc_attr__( 'Edit comment', 'buddypress' ), __( 'Edit', 'buddypress' ) ); ?>
					<?php endif; ?>

			</div>

		</div>

<?php
}
endif;


/* Return posts that are favorited by user*/
function get_my_bp_activity_favorites()
{
  global $wpdb;
  global $current_user;
  get_currentuserinfo();

  if (!$current_user)
    return false;

  // We don't want anonymous users
  if ($current_user->ID == 0)
    return false;

  $arrFavorites = bp_get_user_meta( $current_user->ID, 'bp_favorite_activities', true );

  if (!$arrFavorites)
      return false;

  $arrActivities = bp_activity_get( array( 'in' => $arrFavorites ) );

  $arrActivityIDs = array();

  foreach ( $arrActivities['activities'] as $objActivity ) 
  {
      array_push($arrActivityIDs, $objActivity->id);
  }

  return $arrActivityIDs;

}

function add_theme_url() 
{
  echo '<div id="dlearn_cwd" class="hidden">'.get_stylesheet_directory_uri().'</div>';
  
}
add_action( 'admin_head', 'add_theme_url' ); 


function get_top_posts_categories($strCount = null)
{
    $arrPosts = get_transient('gp_get_recent_posts');

    if (!$arrPosts)
    {
        $arrPosts = wp_get_recent_posts(array('numberposts' => '20', 'post_type' => 'post'));
        set_transient('gp_get_recent_posts',$arrPosts, 60*60*2);
    }

    $arrCategories = array();
    foreach ($arrPosts as $objPost) 
    {
        foreach ( get_the_category($objPost['ID']) as $objCategory )
        {
            if (($objCategory->cat_ID) == '1')
                break;

            if (array_key_exists($objCategory->cat_ID, $arrCategories))
                $arrCategories[$objCategory->cat_ID] += 1;
            else
                $arrCategories[$objCategory->cat_ID] = 1;
        }
    }
    arsort($arrCategories);

    return array_slice(array_keys($arrCategories), 0, $strCount);
}

function get_thumbnails_from_categories($strCategory = null)
{

    $arrPosts = get_transient('gb_get_recent_posts_thumb');
    if (!$arrPosts)
    {
        $arrPosts = wp_get_recent_posts(array('numberposts' => '4', 'category' => $strCategory, 'post_type' => 'post'));
        set_transient('gb_get_recent_posts_thumb',$arrPosts, 60*60*2);
    }

    $strThumbnails = '';

    $strDefaultThumb = '<img width="75" height="75" src="http://dummyimage.com/75x75/000/fff.png" class="attachment-thumbnail wp-post-image" alt="blank image">';
    foreach ($arrPosts as $objPost)
    {
        $strThumbnail = get_the_post_thumbnail($objPost['ID'], array('75','75'));
        $strThumbnails .= $strThumbnail ? $strThumbnail : $strDefaultThumb;
    }

    return $strThumbnails;

}

function get_stories_by_category_callback() 
{
	global $wpdb; // this is how you get access to the database

	$arrCategoryHref = explode('/', $_POST['category_href']);
	array_pop($arrCategoryHref);
	$strCategorySlug = array_pop($arrCategoryHref);

    $objCategory = get_category_by_slug($strCategorySlug);

    $arrPosts = get_transient('gp_stories_by_category-'.$strCategorySlug);
    if (!$arrPosts)
    {
        $arrPosts = get_posts(array('numberposts' => '-1', 'category' => $objCategory->cat_ID));
        set_transient('gp_stories_by_category'.$strCategorySlug, $arrPosts, 60*60*2);
    }

    $strPost = '';

    if ($arrPosts) 
    {
        foreach ($arrPosts as $post)
        {
            $strContent = strip_tags(strip_shortcodes($post->post_content,0,200));
            $strWords = explode(' ', $strContent, 46);
            if (count($strWords) > 45)
            {
                array_pop($strWords);
                array_push($strWords, '...');
                $the_excerpt = implode(' ', $strWords);
            }
            $strPost .= '   <div class="row">';
            $strPost .= '       <div class="story span6">';
            $strPost .= '           <h3 class="pagetitle"><a href="'.$post->guid.'">'. $post->post_title.'</a></h3>';
            $strPost .= '   						<p class="date">';
            $strPost .= '   							'.sprintf( __( '%1$s <span>in %2$s</span>', 'buddypress' ), date('F d, Y' ,strtotime($post->post_date)), get_the_category_list( ', ', '',$post->ID) );
            $strPost .= '   							<span class="post-utility alignright">'.edit_post_link( __( 'Edit this entry', 'buddypress' ) ).'</span>';
            $strPost .= '   						</p>';
            $strPost .= '           <div id="post-'.$post->ID.'">';
            $strPost .= '               <div class="entry">';
            $strPost .= '                   '. ($post->post_excerpt ? $post->post_excerpt : '<p>'.$the_excerpt);
            $strPost .= '   <a href="'.$post->guid.'">Continue Reading</a>'.($post->post_excerpt ? '</p>' : '');
            $strPost .= '               </div><!-- .entry -->';
            $strPost .= '           </div><!-- #post-XX -->';
            $strPost .= '       </div><!-- .story -->';
            $strPost .= '   </div><!-- row -->';
        }
    }


 
    echo $strPost;

	die(); // this is required to return a proper result
}

add_action('wp_ajax_get_stories_by_category', 'get_stories_by_category_callback');
add_action('wp_ajax_nopriv_get_stories_by_category', 'get_stories_by_category_callback');

function dlearn_widgets_init() 
{
	register_sidebar( array(
		'name' => __( 'Homepage Sidebar', 'dlearn-custom' ),
		'id' => 'sidebar-4',
		'description' => __( 'Appears on the homepage', 'dlearn-custom' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	) );

}

add_action( 'widgets_init', 'dlearn_widgets_init' );

// Add in some extra sugar
require( get_stylesheet_directory() . '/inc/custom-widgets.php' );
require( get_stylesheet_directory() . '/inc/sortable-stories.php' );
require( get_stylesheet_directory() . '/inc/favorite-post.php' );

?>
