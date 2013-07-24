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

if ( get_query_var( 'paged' ) )
    $paged = get_query_var( 'paged' );
elseif ( get_query_var( 'page' ) )
    $paged = get_query_var( 'page' );
else
    $paged = 1;

$original_content = new WP_Query
(
    array
    (
        'post_status'  => 'publish',
        'section'          => $term->slug,
        'paged'         => $paged,
        'posts_per_page'=> 9,
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
$abstracts = new WP_Query
(
    array
    (
        'post_status'   => 'publish',
        'section'       => $term->slug,
        'paged'         => $paged,
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
);
$wp_query = $abstracts;
$original_posts_exist = ($original_content->have_posts() ) ? true : false;
?>
    <div id="primary" class="site-content full-width">
        <div id="content" role="main">
            <?php newsplus_content_nav( 'nav-above' ); ?>

            <?php if ( $original_posts_exist) : ?>
            <h1 class="section-title header-title"><span class="ss-label red"><?php echo single_cat_title( $term->name, false ); ?></span> <span>Exclusive Content</span></h1>

            <div class="clear">
                <div class="flexslider">
                    <ul class="slides">
                    <?php
                    $count = 1;
                    $fclass = '';
                    $lclass = '';
                    while ($original_content->have_posts()) : $original_content->the_post();
                        $fclass = ( 0 == ( ( $count - 1 ) % 3 ) ) ? ' first-grid' : '';
                        $lclass = ( 0 == ( $count % 3 ) ) ? ' last-grid' : ''; 
                        if ($fclass) echo '<li>'; ?>
                        <article id="post-<?php the_ID();?>" <?php post_class( 'entry-grid col3' . $fclass . $lclass ); ?>>
                        <?php if ( has_post_thumbnail() ) {
                            $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumb-320' );
                            $img = $img_src[0];
                            $title = get_the_title();
                            $out = '<div class="post-thumb"><a href="' . get_permalink() . '" title="' . $title . '">';
                            $out .= '<img src="' . $img . '" alt="' . $title . '" title="' . $title . '"/>';
                            if (has_term( 'hi-five-kids', 'section' ) ) {
                                $out .= '<div class="banner-tag hi-five">Hi Five, Kid!</div>';
                            }
                            $out .= '</a></div>';
                            echo $out;
                        } ?>
                        <div class="entry-content">
                            <h2 class="entry-title">
                                <?php if (get_post_time('U', true) > strtotime('-5 days')) { ?><span class="new-tag">New</span><?php } ?>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                            </h2>                            <p class="post-excerpt"><?php echo short( get_the_excerpt(), 160 ); ?></p>
                            <?php if( 'true' != $pls_hide_post_meta ) { ?>
                            <aside id="meta-<?php the_ID();?>" class="entry-meta"><?php newsplus_small_meta(); ?></aside>
                            <?php } ?>
                        </div><!-- .entry-content -->
                        </article><!-- #post-<?php the_ID();?> -->
                        <?php $count++;
                        if ($lclass) echo '</li>'; 
                    endwhile; ?>
                    </ul>
                    <script type="text/javascript">
                        jQuery(window).load(function(){
                          jQuery('.flexslider').flexslider({
                            animation: "slide",
                            slideshow: false,
                            minItems: 2,
                          });
                        })
                    </script>
                </div> <!-- end flexslider -->
            </div><!-- .clear -->
        <?php else : //no original posts ?>
            <h1 class="section-title header-title"><span class="ss-label red"><?php echo single_cat_title( $term->name, false ); ?></span> <span>Content from around the web</span></h1>
        <?php endif; ?>

        <?php if ( $original_posts_exist ): ?>
            <h1 class="section-title header-title sub-section"><span>Content from around the web</span></h1>
        <?php endif;  ?>

            <div class="clear">
            <?php
            $abstract_count = 1;
            $fclass = '';
            $lclass = '';
            while ( $abstracts->have_posts() ) :
                $abstracts->the_post();
                $fclass = ( 0 == ( ( $abstract_count - 1 ) % 4 ) ) ? ' first-grid' : '';
                $lclass = ( 0 == ( $abstract_count % 4 ) ) ? ' last-grid' : ''; ?>
                <article id="post-<?php the_ID();?>" <?php post_class( 'entry-grid col4'. $fclass . $lclass ); ?>>
                <?php get_template_part( 'formats/format', get_post_format() ); ?>
                <div class="entry-content">
                    <h2 class="entry-title">
                        <?php if (get_post_time('U', true) > strtotime('-5 days')) { ?><span class="new-tag">New</span><?php } ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <p class="post-excerpt"><?php echo short( get_the_excerpt(), 150 ); ?></p>
                    <?php if( 'true' != $pls_hide_post_meta ) { ?>
                    <aside id="meta-<?php the_ID();?>" class="entry-meta"><?php newsplus_small_meta(); ?></aside>
                    <?php } ?>
                </div><!-- .entry-content -->
                </article><!-- #post-<?php the_ID();?> -->
                <?php $abstract_count++;
            endwhile; ?>
            </div><!-- .clear -->
            <?php newsplus_content_nav( 'nav-below' ); ?>

        </div><!-- #content -->
    </div><!-- #primary -->
<?php get_footer(); ?>