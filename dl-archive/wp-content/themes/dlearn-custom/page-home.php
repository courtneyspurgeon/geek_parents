<?php
/*
 * Template Name: Homepage
 *
 * A homepage template with style.
 *
 * @package DLearn-Custom
 */

query_posts(array( 
  'posts_per_page' => 3,
  'post__in' => get_option( 'sticky_posts' ),
  'ignore_sticky_posts' => 1,
  'meta_key' => '_top_tile_position',
  'orderby' => 'meta_value',
  'order' => 'ASC'
));


get_header(); 
?>

    <div id="content" class="container">
        <div class="padder">

        <?php do_action( 'bp_before_blog_page' ); ?>

        <div class="page" id="blog-page" role="main">

            <div id="topic-stories">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php echo ($wp_query->current_post == 0 or $wp_query->current_post % 2) ? '<div class="row">' : '' ?>
                    <div class="topic-story <?php echo $wp_query->current_post == 0 ? 'span9' : 'span4' ?>">

                        <?php if ( has_post_thumbnail() ) {
                            if ($wp_query->current_post == 0) {
                                the_post_thumbnail(array(700,500));
                            } else {
                                the_post_thumbnail(array(300,250));
                            }
                        } else { ?>
                            <?php $strHW = $wp_query->current_post == 0 ? '700x500' : '300x250' ?>
                            <img class="featured" src="http://dummyimage.com/<?php echo $strHW ?>/000000/fff.png" alt="Dummy Image" />
                        <?php } ?>

                        <h2 class="pagetitle"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>

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
                    </div><!-- .topic-story -->

                <?php echo ($wp_query->current_post == 0 or ($wp_query->current_post % 2) == 0) ? '</div><!-- row -->' : '' ?>
            <?php endwhile; endif; ?>
            </div><!-- #topic-stories -->
        <?php wp_reset_query(); ?>

        </div><!-- .page -->

        <?php do_action( 'bp_after_blog_page' ); ?>

        </div><!-- .padder -->
    </div><!-- #content -->

    <?php get_sidebar('front') ?>

<?php get_footer(); ?>
