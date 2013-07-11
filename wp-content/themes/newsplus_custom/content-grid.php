<?php
/**
 * Content Loop for archives - Grid Style.
 */

global $pls_hide_post_meta;
if ( ! have_posts() ) : ?>
    <article id="post-0" class="post no-results not-found">
        <header class="entry-header">
            <h1 class="entry-title"><?php _e( 'Nothing Found', 'newsplus' ); ?></h1>
        </header>
        <div class="entry-content">
            <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'newsplus' ); ?></p>
            <?php get_search_form(); ?>
        </div><!-- .entry-content -->
    </article><!-- #post-0 -->
<?php endif; ?>
<div class="clear">
<?php /* Initialize counter and class variables */
	$count = 1;
	$thumbclass = '';
	$fclass = '';
	$lclass = '';
	while ( $wp_query->have_posts() ) :
                $wp_query->the_post();
                $fclass = ( 0 == ( ( $count - 1 ) % 3 ) ) ? ' first-grid' : '';
                $lclass = ( 0 == ( $count % 3 ) ) ? ' last-grid' : ''; ?>
                <article id="post-<?php the_ID();?>" <?php post_class( 'entry-grid col3' . $fclass . $lclass ); ?>>
                <?php get_template_part( 'formats/format', get_post_format() ); ?>
                <div class="entry-content">
                    <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                    <p class="post-excerpt"><?php echo short( get_the_excerpt(), 160 ); ?></p>
                    <?php if( 'true' != $pls_hide_post_meta ) { ?>
                    <aside id="meta-<?php the_ID();?>" class="entry-meta"><?php newsplus_post_meta(); ?></aside>
                    <?php } ?>
                </div><!-- .entry-content -->
                </article><!-- #post-<?php the_ID();?> -->
                <?php $count++;
            endwhile; ?>
    </div><!-- .clear -->
	<?php newsplus_content_nav( 'nav-below' ); ?>