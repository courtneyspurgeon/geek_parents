<?php
/**
 * Template Name: Page - List Staff 
 *
 * Description: List of all staff members
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
            $blogusers = get_users('blog_id=1&orderby=nicename&role=editor&fields=all_with_meta');
            $count = 1;
            $fclass = '';
            $lclass = '';
            foreach ($blogusers as $user) {
            $user_info = get_userdata($user->ID);
            $fclass = ( 0 == ( ( $count - 1 ) % 3 ) ) ? ' first-grid' : '';
            $lclass = ( 0 == ( $count % 3 ) ) ? ' last-grid' : ''; ?>
              <article <?php post_class( 'entry-grid col3'. $fclass . $lclass ); ?>>
                <?php //echo bp_core_get_avatar( $user->ID, 2 ); ?>
                <?php echo get_avatar( $user->ID, 230); ?>

                  <div class="entry-content">
                    <?php //echo print_r($user) ?>
                    <h2 class="entry-title"><?php echo $user_info->display_name . $user->ID ?></a></h2>
                    <p class="post-excerpt"><?php echo $user_info->user_description; ?></p>
                    <?php if ($user_info->user_url !== '') : ?>
                      <p class="author_website">Website: <a href="<?php echo $user_info->user_url; ?>"><?php echo $user_info->user_url; ?></a></p>
                    <?php endif; ?>
                  </div><!-- .entry-content -->
                  </article><!-- #post-<?php the_ID();?> -->
            <?php $count++; 
            } ?>
    </div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>