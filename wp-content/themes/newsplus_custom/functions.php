<?php
/**
 * Geek Parents theme functions and definitions
 *
 * @package BuddyPress
 * @subpackage DLearn-Custom
 */

/*

/************* INCLUDE NEEDED FILES ***************/

/*
1. inc/bones.php
    - head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
    - custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once('inc/bones.php'); // if you remove this, bones will break
/*
2. inc/custom-post-type.php
    - an example custom post type
    - example custom taxonomy (like categories)
    - example custom taxonomy (like tags)
*/
require_once('inc/custom-post-type.php'); // you can disable this if you like
/*
3. inc/admin.php
    - removing some default WordPress dashboard widgets
    - an example custom dashboard widget
    - adding custom login css
    - changing text in footer of admin
*/
// require_once('inc/admin.php'); // this comes turned off by default
/*
4. inc/translation/translation.php
    - adding support for other languages
*/
// require_once('inc/translation/translation.php'); // this comes turned off by default

/* 2013.06.17   Custom post meta display created by Rob Brennan */
function newsplus_post_meta() {
    // Styled to reflect meta display in original theme
    printf( __( '%1$s | %2$s <span>in %3$s</span>', 'buddypress' ), get_the_author(), get_the_date(), get_the_category_list( ' ' ) );

}

function newsplus_small_meta() {
    // Styled to reflect meta display in original theme
    $post_type = get_post_meta(get_the_ID(), '_cmb_source_type', true);
    printf( __( '%1$s <span>in %2$s</span> <span class="post-type %3$s">%3$s</span>', 'buddypress' ), get_the_date(), get_the_category_list( ' ' ), $post_type, ucwords($post_type) );

}

/* 2013.06.25   Custom taxonomies created by Rob Brennan
    Tutorial => Introducing WordPress 3 Custom Taxonomies   (thanks, Courtney!)
    http://net.tutsplus.com/tutorials/wordpress/introducing-wordpress-3-custom-taxonomies/
*/
function build_taxonomies(){
    register_taxonomy( 'section', 'post', array( 'hierarchical' => true, 'label' => 'Section', 'query_var' => true, 'rewrite' => true ) );
}
add_action( 'init', 'build_taxonomies', 0 );

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-680', 680, 320, true );
/* Currently not using additional custom sizes
//add_image_size( 'bones-thumb-300', 300, 250, true );
*/

/* 
to add more sizes, simply copy a line from above 
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image, 
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
    register_sidebar(array(
    	'id' => 'sidebar-homepage',
    	'name' => __('Homepage Sidebar', 'gp-custom'),
    	'description' => __('Sidebar for the Homepage', 'gp-custom'),
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'id' => 'sidebar-posts',
        'name' => __('Post Page Sidebar'),
        'description' => __('Sidebar for post pages'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widgettitle">',
        'after_title' => '</h4>',
    ));
    
    /* 
    to add more sidebars or widgetized areas, just copy
    and edit the above sidebar code. In order to call 
    your new sidebar just use the following code:
    
    Just change the name to whatever your new
    sidebar's id is, for example:
    
    register_sidebar(array(
    	'id' => 'sidebar2',
    	'name' => __('Sidebar 2', 'gp-custom'),
    	'description' => __('The second (secondary) sidebar.', 'gp-custom'),
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));
    
    To call the sidebar in your template, you can just copy
    the sidebar.php file and rename it to your sidebar's name.
    So using the above example, it would be:
    sidebar-sidebar2.php
    
    */
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/
		
// Comment Layout
function bones_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
			    <?php 
			    /*
			        this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
			        echo get_avatar($comment,$size='32',$default='<path_to_url>' );
			    */ 
			    ?>
			    <!-- custom gravatar call -->
			    <?php
			    	// create variable
			    	$bgauthemail = get_comment_author_email();
			    ?>
			    <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/img/nothing.gif" />
			    <!-- end custom gravatar call -->
				<?php printf(__('<cite class="fn">%s</cite>', 'gp-custom'), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__('F jS, Y', 'gp-custom')); ?> </a></time>
				<?php edit_comment_link(__('(Edit)', 'gp-custom'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
       			<div class="alert info">
          			<p><?php _e('Your comment is awaiting moderation.', 'gp-custom') ?></p>
          		</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
    <!-- </li> is added by WordPress automatically -->
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bones_wpsearch($form) {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <label class="screen-reader-text" for="s">' . __('Search for:', 'gp-custom') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search the Site...','gp-custom').'" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
    </form>';
    return $form;
} // don't remove this bracket!

if ( ! function_exists( 'theme_styles' ) ) :

function theme_styles()  
{ 
    $version = '20120210';
    wp_register_style( 'bootstrap-min', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', array(), '2.2.2' );
    wp_register_style( 'bootstrap-responsive', get_stylesheet_directory_uri() . '/css/bootstrap-responsive.min.css', array('bootstrap-min'), '2.2.2' );
    wp_register_style( 'google-font', 'http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic,700italic', array('bootstrap-responsive'), $version );

    wp_enqueue_style( 'bootstrap-min' );
    wp_enqueue_style( 'bootstrap-responsive' );
    wp_enqueue_style( 'google-font' );
}

add_action('wp_enqueue_scripts', 'theme_styles');
endif;

if ( ! function_exists( 'theme_scripts' ) ) :

function theme_scripts()  
{ 
    $version = '20120212';
    // Rest of stuff and dependencies
    // wp_enqueue_script( 'jquery-bbq', get_stylesheet_directory_uri() . '/js/jquery.ba-bbq.min.js', array( 'jquery' ), '1.2.1', true );
    wp_enqueue_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '2.2.2', true );
    wp_enqueue_script( 'gp-custom-custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' ), $version, true );
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

function new_excerpt_more( $more ) {
    global $post;
    return '';
}
add_filter('excerpt_more', 'new_excerpt_more');

function excerpt_read_more_link($output) {
    global $post;
    return $output . ' <p><a href="'. get_post_meta($post->ID, '_cmb_source_url', true) . '">read more &raquo;</a></p>';
}
add_filter('the_excerpt', 'excerpt_read_more_link');


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


function remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
    // $wp_admin_bar->remove_menu('updates');
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

function add_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->add_menu(array(
            'id' => 'gp-home',
            'title' => __('Home'),
            'href' => get_site_url())
    );
    $wp_admin_bar->add_menu(array(
            'id' => 'gp-browse',
            'title' => __('Browse'),
            'href' => get_page_link( get_page_by_title('Browse')->ID ))
    );
}
add_action('admin_bar_menu', 'add_admin_bar_links');

// function init_sessions() {
//     if (!session_id())
//         session_start();
// }
// add_action('init', 'init_sessions');

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
  echo '<div id="gp-custom_cwd" class="hidden">'.get_stylesheet_directory_uri().'</div>';
  
}
add_action( 'admin_head', 'add_theme_url' ); 


function get_tags_in_category($intCategory)
{
    $arrTags = get_transient('gp_tags_in_cat-'.$intCategory);

    if (!$arrTags)
    {

        $arrPosts = get_posts(array('category' => $intCategory));

        $arrTags = array();
        foreach ($arrPosts as $objPost)
        {
            foreach (wp_get_post_tags($objPost->ID) as $objTag)
            {
                $arrTags[$objTag->slug] = $objTag;
            }
        }
        set_transient('gp_tags_in_cat-'.$intCategory, $arrTags, 60*60*2);
    }

    asort($arrTags);
    return $arrTags;
}


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

    $arrPosts = get_transient('gb_get_recent_posts_thumb'.$strCategory);
    if (!$arrPosts)
    {
        $arrPosts = wp_get_recent_posts(array('numberposts' => '4', 'category' => $strCategory, 'post_type' => 'post'));
        set_transient('gb_get_recent_posts_thumb'.$strCategory,$arrPosts, 60*60*2);
    }

    $arrThumb = array('g','');

    $strThumbnails = '';
    foreach ($arrPosts as $objPost)
    {
        $strDefaultThumb = '<img width="90" height="90" src="http://dummyimage.com/90x90/000/fff.png" class="attachment-thumbnail wp-post-image" alt="blank image">';
        $strThumbnail = get_the_post_thumbnail($objPost['ID'], array('90','90'));
        $strThumbnails .= $strThumbnail ? $strThumbnail : $strDefaultThumb;
    }

    return $strThumbnails;

}

// Replace contents of single-card with different type of
// Information depending on type
function get_social_card_callback()
{
	global $wpdb; // this is how you get access to the database
    $objPost = get_post($_POST['post_id']);
    
    $social_sharing_toolkit = new MR_Social_Sharing_Toolkit();
    echo $social_sharing_toolkit->create_bookmarks(get_post_meta($objPost->ID,'_cmb_source_url','single'), $objPost->post_title);

	die(); // this is required to return a proper result
}

add_action('wp_ajax_get_social_card', 'get_social_card_callback');
add_action('wp_ajax_nopriv_get_social_card', 'get_social_card_callback');

// Add in some extra sugar
require( get_stylesheet_directory() . '/inc/custom-widgets.php' );
require( get_stylesheet_directory() . '/inc/sortable-stories.php' );
require( get_stylesheet_directory() . '/inc/favorite-post.php' );

function custom_excerpt_length( $length ) {
	// Change the length of the excerpt
    // 2013.06.20 => Updated default length to be 80 words per 6/19/13 meeting where the team will keep abstracts around 75 words or less
	    // 2013.06.11 => Updated default length of 20 words to accommodate larger abstracts by Rob Brennan
	return 80;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// 2013.06.20 => Original method of hiding the admin bar needed to be replaced. A custom function was created to allow checking if a user has a specific role
/**
 * Checks if a particular user has a role.
 * Returns true if a match was found.
 *
 * @param string $role Role name.
 * @param int $user_id (Optional) The ID of a user. Defaults to the current user.
 * @return bool
 */
function check_user_role( $role, $user_id = null ) {

    if ( is_numeric( $user_id ) )
        $user = get_userdata( $user_id );
    else
        $user = wp_get_current_user();

    if ( empty( $user ) )
        return false;

    return in_array( $role, (array) $user->roles );
}
// 2013.06.20 => Hide the admin bar unless the user is an administrative user or editor added by Rob Brennan
$displayAdminBar = '__return_false';
if (check_user_role('administrator') || check_user_role('editor')){
    $displayAdminBar = '__return_true';
}
add_filter('show_admin_bar', $displayAdminBar);
//

function exclude_featured_category( $query ) {
    if ( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'cat', '-615' );
    }
}
add_action( 'pre_get_posts', 'exclude_featured_category' );

// 2013.06.21 => Added by Rob Brennan to display additional age verification info if need be
function bp_after_signup_profile_fields(){
    //echo "<div id='after-profile-details-section'>Here's some more text; yippee.</div>";
}
add_action('bp_after_signup_profile_fields','bp_after_signup_profile_fields');


// 2013.06.26 added by Courtney Spurgeon - otherwise wp_list_categories causes formatting
// errors when category descriptions have non alphabetic characters, ex: ()
function wp_list_categories_remove_title_attributes($output) {
    $output = preg_replace('` title="(.+)"`', '', $output);
    return $output;
}
add_filter('wp_list_categories', 'wp_list_categories_remove_title_attributes');

// 2013.06.26 added by Courtney Spurgeon to list categories with descriptions
// code found online and adjusted to our needs
// source: http://www.wplover.com/1016/category-based-navigation-with-description-a-la-grid-focus/
function list_cats_with_desc() {
  $base = wp_list_categories('echo=0&title_li=&show_count=1');
 
  // wp_list_categories adds a "cat-item-[category_id]" class to the <li> so let's make use of that! 
  $get_cat_id = '/cat-item-[0-9]+/';
  preg_match_all($get_cat_id, $base, $cat_id);
 
  // Let's prepare our category descriptions to be injected.
  $inject_desc = array();
 
  $i = 0;
  foreach($cat_id[0] as $id) {
    $id = trim($id,'cat-item-');
    $id = trim($id,'"');
 
    $desc = trim(strip_tags(category_description($id)),"\n");   // For some reason, category_description returns the
                                                                // description wrapped in an unwanted paragraph tag which
                                                                // we remove with strip_tags. It also adds a newline
                                                                // which we promptly trim out.
    if($desc=="") $desc = "Add Description";
 
    $inject_desc[$i] = '</a><p class="cat-desc">' . $desc . '</p>';
    $i++;
  }
 
  // Now we inject our descriptions
  $base_arr = explode("\n", $base);
 
  $base_i = 0;
  foreach($inject_desc as $desc) {
 
    // We check whether there's an occurence of "</a>"
    while(strpos($base_arr[$base_i], "</a>") === false) {
      $base_i++;
    }
 
    // If we find one, ad our description <p>
    $base_arr[$base_i] .= $desc;
    $base_i++;
  }
 
  $base = implode("\n", $base_arr);
  echo $base;
}
?>