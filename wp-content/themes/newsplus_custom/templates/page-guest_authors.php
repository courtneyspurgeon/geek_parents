<?php
/**
 * Template Name: Page - List Guest Authors 
 *
 * Description: List of all guest authors
 */

get_header(); ?>
<div id="primary" class="site-content full-width">
    <div id="content" role="main">
    <?php show_breadcrumbs();
      if ( have_posts() ) :
      while ( have_posts() ) :
      the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="entry-content">
          <?php the_content(); ?>
          <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'newsplus' ), 'after' => '</div>' ) ); ?>
        </div><!-- .entry-content -->
      </article><!-- #post -->
    <?php endwhile;
        else : ?>
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

    <?php
      $args=array(
        'post_type' => 'guest-author',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'caller_get_posts'=> 1
      );
      $author_query = null;
      $author_query = new WP_Query($args);
      wp_reset_query();  // Restore global post data stomped by the_post().

      $count = 1;
      $fclass = '';
      $lclass = '';
      while ( $author_query->have_posts() ) :
        $author_query->the_post();
        $meta = get_post_meta( get_the_ID() );
        $fclass = ( 0 == ( ( $count - 1 ) % 3 ) ) ? ' first-grid' : '';
        $lclass = ( 0 == ( $count % 3 ) ) ? ' last-grid' : ''; ?>
        <article id="post-<?php the_ID();?>" <?php post_class( 'entry-grid col3' . $fclass . $lclass ); ?>>
        <?php get_template_part( 'formats/format', get_post_format() ); ?>
        <div class="entry-content">
          <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
          <p class="post-excerpt"><?php echo $meta['cap-description'][0]; ?></p>
        </div><!-- .entry-content -->
        </article><!-- #post-<?php the_ID();?> -->
        <?php $count++;
      endwhile; ?>
    </div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>