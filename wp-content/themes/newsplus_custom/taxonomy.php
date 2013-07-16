<?php
/**
 * Created by rob
 * Date: 6/25/13 4:05 PM
 *
 * Email:   rob@therobbrennan.com
 * Twitter: @therobbrennan
 * Web:     http://www.therobbrennan.com
 */

global $pls_archive_template;
get_header();
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
?>
    <div id="primary" class="site-content full-width">
        <div id="content" role="main">
            <?php //show_breadcrumbs();
            if ( have_posts() )
                the_post();
            ?>
            <h1 class="section-title header-title"><?php printf( __( '%s', 'newsplus' ), single_cat_title( $term->name, false ) ); ?></h1>
            <?php rewind_posts(); ?>

            <?php 

$temp = $wp_query;  // assign orginal query to temp variable for later use
// $wp_query = null;

            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $original_content = new WP_Query
                (
                    array
                    (
                        'post_status'  => 'publish',
                        'section'          => $term->slug,
                        'paged'         => $paged,
                        //'posts_per_page'=> 5,
                        'meta_query'   => array
                        (
                            array
                            (
                                'key'     => '_cmb_source_url',
                                'value'   => NULL,
                                'type'    => 'CHAR',
                                'compare' => 'NOT EXISTS'
                            )
                        ),
                        'order' => 'DESC'
                    )
                );

            while ($original_content->have_posts()) : $original_content->the_post();

                // The Post
                echo '<a href="' . get_permalink() . '">';
                the_title();
                echo '</a>';
                echo '<br>';
                the_category(' ');
                the_excerpt();
                echo '<hr>';

            endwhile; ?>

        <h1>Abstracts</h1>

        <?php 
        $wp_query = new WP_Query
        (
            array
            (
                'post_status'   => 'publish',
                'section'       => $term->slug,
                'paged'         => $paged,
                //'posts_per_page'=> 1,
                'meta_query'    => array
                (
                    array
                    (
                        'key'     => '_cmb_source_url',
                        'value'   => NULL,
                        'type'    => 'CHAR',
                        'compare' => 'EXISTS'
                    )
                ),
                'order' => 'DESC'
            )
        ); ?>


        
            <div class="clear">
            <?php
            $count = 1;
            $fclass = '';
            $lclass = '';
            while ( $wp_query->have_posts() ) :
                $wp_query->the_post();
                $fclass = ( 0 == ( ( $count - 1 ) % 4 ) ) ? ' first-grid' : '';
                $lclass = ( 0 == ( $count % 4 ) ) ? ' last-grid' : ''; ?>
                <article id="post-<?php the_ID();?>" <?php post_class( 'entry-grid col4'. $fclass . $lclass ); ?>>
                <?php get_template_part( 'formats/format', get_post_format() ); ?>
                <div class="entry-content">
                    <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                    <p class="post-excerpt"><?php echo short( get_the_excerpt(), 150 ); ?></p>
                    <?php if( 'true' != $pls_hide_post_meta ) { ?>
                    <aside id="meta-<?php the_ID();?>" class="entry-meta"><?php newsplus_small_meta(); ?></aside>
                    <?php } ?>
                </div><!-- .entry-content -->
                </article><!-- #post-<?php the_ID();?> -->
                <?php $count++;
            endwhile; ?>
            </div><!-- .clear -->

        <?php newsplus_content_nav( 'nav-below' ); ?>

        </div><!-- #content -->
    </div><!-- #primary -->
<?php get_footer(); ?>