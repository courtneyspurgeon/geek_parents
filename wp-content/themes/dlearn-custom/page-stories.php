<?php
/*
 * Template Name: Stories Page
 *
 * A homepage template with style.
 *
 * @package DLearn-Custom
 */

query_posts(array( 
  'posts_per_page' => -1,
  'orderby' => 'date',
  'order' => 'ASC'
));

get_header(); 
?>

    <div id="content" class="container">
        <div class="no-padder">

        <?php do_action( 'bp_before_blog_page' ); ?>

        <div class="page" id="blog-page" role="main">

            <div id="topic-stories">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="row">
                    <div class="topic-story span3">

                        <?php if ( has_post_thumbnail() ) {
                            if ($wp_query->current_post == 0) {
                                the_post_thumbnail(array(640,551));
                            } else {
                                the_post_thumbnail(array(317,350));
                            }
                        } else { ?>
                            <img class="featured" src="http://dummyimage.com/200x200/000000/fff.png" alt="Dummy Image" />
                        <?php } ?>

                    </div>
                    <div class="topic-story span6">

                        <h2 class="pagetitle"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>

                        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                            <div class="entry">

                                <?php the_excerpt(); ?>

                                <?php edit_post_link( __( 'Edit this page.', 'buddypress' ), '<p class="edit-link">', '</p>'); ?>

                            </div><!-- .entry -->

                        </div><!-- #post-XX -->
                    </div><!-- .topic-story -->

                </div><!-- row -->
            <?php endwhile; endif; ?>
            </div><!-- #topic-stories -->
        <?php wp_reset_query(); ?>

        </div><!-- .page -->

        <?php do_action( 'bp_after_blog_page' ); ?>

        </div><!-- .padder -->
    </div><!-- #content -->

    <?php get_sidebar('front') ?>

<?php get_footer(); ?>
