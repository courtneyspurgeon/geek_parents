<?php
/*
 * Template Name: Browse Stories Page
 *
 * A category browsing template with style.
 *
 * @package DLearn-Custom
 */

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts(array( 
  'posts_per_page' => 10,
  'paged' => $paged,
  'orderby' => 'date',
  'order' => 'ASC'
));

get_header(); 
?>

    <div id="content">

        <div class="padder">

        <div id="results"></div>


        <?php do_action( 'bp_before_blog_page' ); ?>

        <div class="page" id="blog-page" role="main">

            <h2>Featured Categories</h2>

            <div id="featured-categories" class="row">
                <div class="span9">
                    <?php $arrCategories = get_top_posts_categories(3); ?>
                    <div class="row">
                    <?php foreach ($arrCategories as $strCatID) { ?>
                    <a href="<?php echo get_category_link($strCatID) ?>">
                        <div class='span3 brthumbnail'>
                            <?php echo get_thumbnails_from_categories($strCatID); ?>
                        </div>
                    </a>
                    <?php } ?>
                    </div>
                    <div class='row'>
                    <?php foreach ($arrCategories as $strCatID) { ?>
                        <div class='span3 brthumbnail'><a href="<?php echo get_category_link($strCatID) ?>"><?php echo get_category($strCatID)->cat_name ?></a></div>
                    <?php } ?>
                    </div>
                </div>
            </div>

            <div id="tag-cloud">
                <?php $arrTags = wp_tag_cloud('smallest=10&largest=21'); ?>
            </div>

            <div id="category-stories">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="row">
                    <div class="story span9">

                        <h3 class="pagetitle"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>

                        <p class="date">
                            <?php printf( __( '%1$s <span>in %2$s</span>', 'buddypress' ), get_the_date(), get_the_category_list( ', ' ) ); ?>
                            <span class="post-utility alignright"><?php edit_post_link( __( 'Edit this entry', 'buddypress' ) ); ?></span>
                        </p>

                        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                            <div class="entry">

                                <?php the_excerpt(); ?>

                                <?php edit_post_link( __( 'Edit this page.', 'buddypress' ), '<p class="edit-link">', '</p>'); ?>

                            </div><!-- .entry -->

                        </div><!-- #post-XX -->
                    </div><!-- .story -->
                </div><!-- row -->
            <?php endwhile; endif; ?>
            <!-- pagination -->
            <?php next_posts_link(); ?>
            <?php previous_posts_link(); ?>
            </div><!-- #category-stories -->
            <?php wp_reset_query(); ?>

        </div><!-- .page -->

        <?php do_action( 'bp_after_blog_page' ); ?>

        </div><!-- .padder -->

    </div><!-- #content -->

    <?php get_sidebar() ?>

<?php get_footer(); ?>
