<?php
/**
 * Created by courtneyspurgeon
 * Date: 6/25/13 4:05 PM
 * http://courtneyspurgeon.com
 */

global $pls_archive_template;
get_header();
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
?>
<div id="primary" class="site-content full-width focus_section">
        <div id="content" role="main">
            <!-- Main Featured Posts -->
            <?php 
            $tags = get_tags( array(
                'name__like' => 'focus', 
                'orderby' => '', 
                'order' => 'DESC',
                'number' => 1,
                ));

            if (count($tags) > 0 ) :
                $tag = $tags[0];
                $tag_slug = $tags[0]->slug;
                $tag_name = $tags[0]->name;
                $focus_topic = str_replace('Focus:','', $tag_name);

                $primary_query = new WP_Query( array(
                'tag' => $tag_slug,
                'section' => 'primary'
                ) );
                if ( $primary_query->have_posts() ) : ?>

                 <h2 class="section-title"><span class="ss-label red">Focus On: <?php echo $focus_topic ?></span> &nbsp;feature articles by our staff<span class="right_link"><a href="#">Browse Previous Features</a></span></h2>
                    <div class="clear primary_posts">
                        <div class="flexslider">
                            <ul class="slides">
                                <?php
                                $count = 1;
                                $fclass = '';
                                $lclass = '';
                                while ( $primary_query->have_posts() ) :
                                    $primary_query->the_post();
                                    $fclass = ( 0 == ( ( $count - 1 ) % 2 ) ) ? ' first-grid' : '';
                                    $lclass = ( 0 == ( $count % 2 ) ) ? ' last-grid' : ''; ?>
                                    <li>
                                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-list clear' ); ?>>
                                        <?php get_template_part( 'formats/list-format', get_post_format() ); ?>
                                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                                        <?php echo ( '<p class="post-excerpt">' . get_the_excerpt() . '</p>' ); ?>
                                        <?php $post_meta = '<span class="entry-meta">';
                                            $post_meta .= coauthors_posts_links(null, null, null, null, false);
                                            $post_meta .= sprintf( ' on <a href="%1$s" title="%2$s"><time class="entry-date" datetime="%3$s">%4$s</time></a> | %5$s%6$s',
                                                esc_url( get_permalink() ),
                                                esc_attr( get_the_time() ),
                                                esc_attr( get_the_date( 'c' ) ),
                                                esc_html( get_the_date() ),
                                                get_the_category_list( ', ' ),
                                                $write_comments );
                                            $post_type = get_post_meta(get_the_ID(), '_cmb_source_type', true);
                                            if ($post_type !== '') {
                                               $post_meta .= ' <span class="post-type ' . $post_type . ' %3$s">' . $post_type .'</span>';
                                            }
                                            $post_meta .= '</span>';
                                            echo $post_meta; ?>
                                            </div><!-- .entry-list-right -->
                                        </article><!-- #post-<?php the_ID(); ?> -->
                                    </li>
                                    <?php $count++;
                                endwhile; ?>
                            </ul> <!-- end .slides -->
                        </div> <!-- flexslider -->
                    </div><!-- .clear -->
                <?php else:
                    // no posts found
                endif; ?>

            <!-- Secondary Featured Posts -->
            <?php $secondary_query = new WP_Query( array(
                'tag' => $tag_slug,
                'section' => 'secondary'
                ) );
            
            if ( $secondary_query->have_posts() ) : ?>
                <div class="clear secondary_posts">
                    <?php //following code taken from newsplus shortcodes posts_carousel
                        $slider_id = 'slider-' . rand( 5, 20000 );
                        $out = '<div class="slider-wrap clear">
                        <script type="text/javascript">
                        jQuery(window).load(function(){
                            parentWidth = jQuery( "#' . $slider_id . '" ).width();
                            bodyFontSize = jQuery("body").css("font-size");
                            bodyFontSizeNum = parseFloat ( bodyFontSize );
                            item_width = Math.floor( ( parentWidth - bodyFontSizeNum * 3 ) / 3 );
                            item_margin = bodyFontSizeNum * 1.5;
                            max_items = 2;
                            if ( parentWidth < 480 ) {
                                item_width = Math.floor( ( parentWidth - bodyFontSizeNum * 1.5 ) / 2 );
                                max_items = 2;
                            }
                            jQuery("#' . $slider_id . '").flexslider({
                                animation: "slide",
                                easing:"swing",
                                animationSpeed: 600,
                                slideshowSpeed:4000,
                                selector: ".slides > .slide",
                                useCSS:false,
                                prevText: "Prev",
                                nextText: "Next",
                                controlsContainer: "#' . $slider_id . '-controls",
                                animationLoop: false,
                                controlNav: true,
                                directionNav: true,
                                itemWidth: item_width,
                                itemMargin: item_margin,
                                minItems: 1,
                                maxItems: max_items,
                                move: 0,
                                start: function(slider) {
                                    jQuery(slider).removeClass("flex-loading");
                                },
                                slideshow: false,
                            });
                        })
                        </script>';
                        $slides = '';
                        while ( $secondary_query->have_posts() ) :
                            $secondary_query->the_post();
                            global $multipage;
                            $multipage = 0;
                            $time = get_the_time( get_option( 'date_format' ) );
                            $permalink = get_permalink();
                            $title = get_the_title();
                            $excerpt = ( $hide_excerpt == 'true' ) ? '' : sprintf( '<p class="post-excerpt">%1$s</p>', short( get_the_excerpt(), 5000 ) );
                            $postID = get_the_ID();
                            $num_comments = get_comments_number();
                            if ( comments_open() ) {
                                if ( $num_comments == 0 ) {
                                    $comments = __( '0 Comments', 'newsplus' );
                                } elseif ( $num_comments > 1 ) {
                                    $comments = $num_comments . __( ' Comments', 'newsplus' );
                                } else {
                                    $comments = __( '1 Comment', 'newsplus' );
                                }
                                $write_comments = sprintf( __( '<span class="sep"> | </span><a href="%1$s" title="Comment on %3$s">%2$s</a>', 'newsplus' ), get_comments_link(), $comments, $title );
                            }
                            else {
                                $write_comments = '';
                            }
                            $post_meta = '<span class="entry-meta">';
                            $post_meta .= coauthors_posts_links(null, null, null, null, false);
                            $post_meta .= sprintf( ' on <a href="%1$s" title="%2$s"><time class="entry-date" datetime="%3$s">%4$s</time></a> | %5$s%6$s',
                                esc_url( get_permalink() ),
                                esc_attr( get_the_time() ),
                                esc_attr( get_the_date( 'c' ) ),
                                esc_html( get_the_date() ),
                                get_the_category_list( ', ' ),
                                $write_comments );
                            $post_type = get_post_meta(get_the_ID(), '_cmb_source_type', true);
                            if ($post_type !== '') {
                               $post_meta .= ' <span class="post-type ' . $post_type . ' %3$s">' . $post_type .'</span>';
                            }
                            $post_meta .= '</span>';
                            if ( has_post_thumbnail() && 'true' !== $hide_image ) {
                                $img_big = wp_get_attachment_image_src( get_post_thumbnail_id( $GLOBALS['post']->ID ), 'three_col_thumb' );
                                $thumbnail = $img_big[0];
                                $thumblink = sprintf( '<div class="post-thumb"><a href="%1$s" title="%2$s"><img src="%3$s" alt="%2$s" title="%2$s"/></a></div>', $permalink, $title, $thumbnail );
                            }
                            else {
                                $thumblink = '';
                            }
                            if ( 'video' == get_post_format() ) {
                                $post_opts = get_post_meta( $GLOBALS['post']->ID, 'post_options', true );
                                $pf_video = ! empty( $post_opts['pf_video'] ) ? $post_opts['pf_video'] : '';
                                global $wp_embed;
                                $post_embed = $wp_embed->run_shortcode( '[embed]' . $pf_video . '[/embed]' );
                                if ( '' != $pf_video ) {
                                    $thumblink = sprintf( '<div class="embed-wrap">%1$s</div>', $post_embed );
                                }
                            }
                            $no_meta_class = ( 'true' == $hide_excerpt && 'true' == $hide_meta ) ? 'no-meta' : '';
                            $format = '<div class="slide post-%1$s">%2$s<div class="entry-content %7$s"><h3><a href="%3$s" title="%4$s">%4$s</a></h3>%5$s%6$s</div></div>';
                            $slides .= sprintf ( $format, $postID, $thumblink, $permalink, $title, $excerpt, $post_meta, $no_meta_class );
                        endwhile;
                        $out .= '<div class="flexslider carousel flex-loading" id="' . $slider_id . '"><div class="slides">' . $slides . '</div></div><div class="flex-controls-container" id="' . $slider_id . '-controls"></div></div>';
                        echo $out;
                    endif; ?>

                </div><!-- .clear -->
                    

                 <?php $tertiary_query = new WP_Query( array(
                    'tag' => $tag_slug,
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'section',
                            'field' => 'id',
                            'terms' =>  628
                        ),
                        array(
                            'taxonomy' => 'section',
                            'field' => 'id',
                            'terms' => array( 677, 678 ),
                            'operator' => 'NOT IN'
                        )
                    )
                    ) );
                    
                    if ( $tertiary_query->have_posts() ) : ?>
                        <h2 class="section-title"><span class="ss-label blue">Focus On: <?php echo $focus_topic ?></span> &nbsp;related content from around the web</h2>
                        <div class="clear">
                            <div class="flexslider">
                                <ul class="slides">
                                    <?php
                                    $count = 1;
                                    $fclass = '';
                                    $lclass = '';
                                    while ( $tertiary_query->have_posts() ) :
                                        $tertiary_query->the_post();
                                        $fclass = ( 0 == ( ( $count - 1 ) % 4 ) ) ? ' first-grid' : '';
                                        $lclass = ( 0 == ( $count % 4 ) ) ? ' last-grid' : ''; ?>
                                        <li>
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
                                    </li>
                                        <?php $count++;
                                    endwhile; ?>
                                    </ul>
                            </div><!-- end flexslider -->
                        </div><!-- .clear -->
                    <?php else:
                        // no posts found
                    endif; ?>
            <?php else : //no tags starting with focus ?>
                <p>Please create a tag starting with 'Focus' to populate this page</p>
            <?php endif; //end if count(tags) ?>

        </div><!-- #content -->
    </div><!-- #primary -->
<?php get_footer(); ?>
<script type="text/javascript">
    jQuery(window).load(function(){
      jQuery('.flexslider').flexslider({
        animation: "slide",
        slideshow: false,
      });
    })
</script>