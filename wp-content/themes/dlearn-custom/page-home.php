<?php
/*
 * Template Name: Homepage
 *
 * A homepage template with style.
 *
 * @package DLearn-Custom
 */

query_posts(array( 
  'posts_per_page' => 7,
  'post__in' => get_option( 'sticky_posts' ),
  'ignore_sticky_posts' => 1,
  'meta_key' => '_top_tile_position',
  'orderby' => 'meta_value',
  'order' => 'ASC'
));

get_header(); 
?>

<div class="row">

    <div id="main-content" class="span12">


        <?php do_action( 'bp_before_blog_page' ); ?>

        <div class="page" id="blog-page" role="main">

            <div id="topic-stories">
            <?php $intCount = 0; ?>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php if ($wp_query->current_post == 0) : ?>

                <div class="row">
                    <div id="main-topic-story" class="topic-story span12">

                        <article id="post-<?php the_ID(); ?>" role="article" itemscope itemtype="http://schema.org/BlogPosting">
                            <?php if ( has_post_thumbnail() ) {
                                the_post_thumbnail(array(750,400));
                            } else { ?>
                                <img class="featured" src="http://dummyimage.com/750x400/000000/fff.png" alt="Dummy Image" />
                            <?php } ?>

                        <header class="article-header">
                            <h2 class="pagetitle"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>

                            <p class="date">
                                <?php printf( __( '%1$s <span>in %2$s</span>', 'buddypress' ), get_the_date(), get_the_category_list( ', ' ) ); ?>
                                <span class="post-utility alignright"><?php edit_post_link( __( 'Edit this entry', 'buddypress' ) ); ?></span>
                            </p>
                        </header> <!-- end article header -->

                        <section class="entry-content">
                            <div <?php post_class(); ?>>

                                <div class="entry">

                                    <?php the_excerpt(); ?>

                                    <?php edit_post_link( __( 'Edit this page.', 'buddypress' ), '<p class="edit-link">', '</p>'); ?>

                                </div><!-- .entry -->
                            </div><!-- #post-XX -->
                        </section>

                        </article>
                    </div><!-- #main-topic-story -->
                </div><!-- row -->

                <?php else : ?>

                <?php echo ($intCount == 0 ? '<div class="row">' : '' ); ?>

                    <div class="topic-story span4">

                    <?php get_template_part('single','card'); ?>

                    </div><!-- .topic-story -->

                <?php echo ($intCount == 2 ? '</div><!-- row -->' : '' ); ?>

            <?php if ($intCount == 2) { $intCount = 0; } else { $intCount++; } ?>

            <?php endif; ?>

            <?php endwhile; endif; ?>
            </div><!-- #topic-stories -->
        <?php wp_reset_query(); ?>

        </div><!-- .page -->

        <?php do_action( 'bp_after_blog_page' ); ?>

    </div><!-- #content -->

    <?php get_sidebar('front') ?>

</div>

<?php get_footer(); ?>
