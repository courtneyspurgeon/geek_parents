<?php
/**
 * Template Name: Page - Team Profiles
 *
 * Description: A full width page template listing the team members
 */

get_header(); ?>
<div id="primary" class="site-content full-width staff">
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
        <h3>Staff</h3>
        <?php
            $blogusers = get_users('blog_id=1&orderby=nicename&role=editor');
            $count = 1;
            $fclass = '';
            $lclass = '';
            foreach ($blogusers as $user) {
            $fclass = ( 0 == ( ( $count - 1 ) % 4 ) ) ? ' first-grid' : '';
            $lclass = ( 0 == ( $count % 4 ) ) ? ' last-grid' : ''; ?>
              <article <?php post_class( 'entry-grid col4'. $fclass . $lclass ); ?>>
                <?php //echo bp_core_get_avatar( $user->ID, 2 ); ?>
                <?php echo get_avatar( $user->ID, 230); ?> 
                  <div class="entry-content">
                    <h2 class="entry-title"><?php echo $user->display_name . $user->ID ?></a></h2>
                    <p class="post-excerpt"><?php echo get_user_meta( $user->ID, 'description', true );  ?></p>
                  </div><!-- .entry-content -->
                  </article><!-- #post-<?php the_ID();?> -->
            <?php $count++; 
            } ?>
            <div class="clear"></div>
        
        <?php
            $blogusers = get_users('blog_id=1&orderby=nicename&role=contributor');
            $count = 1;
            $fclass = '';
            $lclass = ''; ?>
        <?php if ($blogusers) : ?>
        <h3>Contributing Authors</h3>
        <?php foreach ($blogusers as $user) {
            $fclass = ( 0 == ( ( $count - 1 ) % 4 ) ) ? ' first-grid' : '';
            $lclass = ( 0 == ( $count % 4 ) ) ? ' last-grid' : ''; ?>
              <article <?php post_class( 'entry-grid col4'. $fclass . $lclass ); ?>>
                <?php //echo bp_core_get_avatar( $user->ID, 2 ); ?>
                <?php echo get_avatar( $user->ID, 230); ?> 
                  <div class="entry-content">
                    <h2 class="entry-title"><?php echo $user->display_name . $user->ID ?></a></h2>
                    <p class="post-excerpt"><?php echo get_user_meta( $user->ID, 'description', true );  ?></p>
                  </div><!-- .entry-content -->
                  </article><!-- #post-<?php the_ID();?> -->
            <?php $count++; 
            } ?>
        <?php endif; ?>
    </div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>