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
            <!-- Main Featured Posts -->
            <?php 
            // link at bottom to a custom page that gets all Focus tags and lists them
            $tags = get_tags( array(
                'name__like' => 'focus', 
                'orderby' => '', 
                'order' => 'DESC',
                'number' => 1,
                ));
            $tag = $tags[0];
            $tag_slug = $tags[0]->slug;
            $tag_name = $tags[0]->name;

            $primary_query = new WP_Query( array(
            'tag' => $tag_slug,
            'section' => 'primary'
            ) );
    
            if ( $primary_query->have_posts() ) : ?>
             <h1>Have Primary Posts</h1>
                    <div class="clear">
                    <?php
                    $count = 1;
                    $fclass = '';
                    $lclass = '';
                    while ( $primary_query->have_posts() ) :
                        $primary_query->the_post();
                        $fclass = ( 0 == ( ( $count - 1 ) % 2 ) ) ? ' first-grid' : '';
                        $lclass = ( 0 == ( $count % 2 ) ) ? ' last-grid' : ''; ?>
                        <article id="post-<?php the_ID();?>" <?php post_class( 'entry-grid' . $fclass . $lclass ); ?>>
                        <?php get_template_part( 'formats/format', get_post_format() ); ?>
                        <div class="entry-content">
                            <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                            <p class="post-excerpt"><?php echo short( get_the_excerpt(), 160 ); ?></p>
                            <?php if( 'true' != $pls_hide_post_meta ) { ?>
                            <aside id="meta-<?php the_ID();?>" class="entry-meta"><?php newsplus_small_meta(); ?></aside>
                            <?php } ?>
                        </div><!-- .entry-content -->
                        </article><!-- #post-<?php the_ID();?> -->
                        <?php $count++;
                    endwhile; ?>
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
         <h1>Have Posts?</h1>
                <div class="clear">
                <?php
                $count = 1;
                $fclass = '';
                $lclass = '';
                while ( $secondary_query->have_posts() ) :
                    $secondary_query->the_post();
                    $fclass = ( 0 == ( ( $count - 1 ) % 2 ) ) ? ' first-grid' : '';
                    $lclass = ( 0 == ( $count % 2 ) ) ? ' last-grid' : ''; ?>
                    <article id="post-<?php the_ID();?>" <?php post_class( 'entry-grid' . $fclass . $lclass ); ?>>
                    <?php get_template_part( 'formats/format', get_post_format() ); ?>
                    <div class="entry-content">
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                        <p class="post-excerpt"><?php echo short( get_the_excerpt(), 160 ); ?></p>
                        <?php if( 'true' != $pls_hide_post_meta ) { ?>
                        <aside id="meta-<?php the_ID();?>" class="entry-meta"><?php newsplus_small_meta(); ?></aside>
                        <?php } ?>
                    </div><!-- .entry-content -->
                    </article><!-- #post-<?php the_ID();?> -->
                    <?php $count++;
                endwhile; ?>
                </div><!-- .clear -->
            <?php else:
                // no posts found
            endif; ?>

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
                 <h1>Have Tertiary Posts?</h1>
                        <div class="clear">
                        <?php
                        $count = 1;
                        $fclass = '';
                        $lclass = '';
                        while ( $tertiary_query->have_posts() ) :
                            $tertiary_query->the_post();
                            $fclass = ( 0 == ( ( $count - 1 ) % 2 ) ) ? ' first-grid' : '';
                            $lclass = ( 0 == ( $count % 2 ) ) ? ' last-grid' : ''; ?>
                            <article id="post-<?php the_ID();?>" <?php post_class( 'entry-grid' . $fclass . $lclass ); ?>>
                            <?php get_template_part( 'formats/format', get_post_format() ); ?>
                            <div class="entry-content">
                                <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                                <p class="post-excerpt"><?php echo short( get_the_excerpt(), 160 ); ?></p>
                                <?php if( 'true' != $pls_hide_post_meta ) { ?>
                                <aside id="meta-<?php the_ID();?>" class="entry-meta"><?php newsplus_small_meta(); ?></aside>
                                <?php } ?>
                            </div><!-- .entry-content -->
                            </article><!-- #post-<?php the_ID();?> -->
                            <?php $count++;
                        endwhile; ?>
                        </div><!-- .clear -->
            <?php else:
                // no posts found
            endif; ?>

        </div><!-- #content -->
    </div><!-- #primary -->
<?php get_footer(); ?>