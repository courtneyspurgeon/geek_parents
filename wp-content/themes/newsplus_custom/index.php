<?php
/**
 * The main template file.
 */

global $pls_archive_template;
get_header(); ?>

<!-- featured post section added June 2013: cspurgeon -->
<?php  
if(is_home() && !is_paged()) {
/* Setting up the featured cateogry and how many are displayed */  
$featured_cat = "615";    
$featured_num = "4";
?>  
    <h2 class="section-title"><span class="ss-label red">
        <a href="http://labs.saurabh-sharma.net/themes/newsplus/wp/blog/" title="View all recent News">Featured Content</a>
    </span> chosen by our staff</h2>
    <div id="featured_content">


      <!-- Show x Posts from Breaking News -->  
      <?php query_posts('showposts='.$featured_num.'&cat='.$featured_cat.''); 
        $counter = 0;  
        while (have_posts()) : the_post();
        $counter++;
      ?>
      <?php if ($counter==1) { /* first featured post */ ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-classic clear large-feature' ); ?>>
          <div class="post-content">
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
            <?php if ( 'true' != $pls_hide_post_meta ) { ?>
            <aside id="meta-<?php the_ID();?>" class="entry-meta"><?php newsplus_post_meta(); ?></aside>
            <?php } // hide post meta
            echo( '<p class="post-excerpt">' . get_the_excerpt() . '</p>' ); ?>
            <p><a class="more-link" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php _e( 'Read More', 'newsplus' ); ?></a></p>
          </div>
          <?php the_post_thumbnail( 'bones-thumb-600' ); ?>
            
        </article><!-- #post-<?php the_ID(); ?> -->

      <?php } else { /* all other featured posts */ ?>
        <article id="post-<?php the_ID();?>" <?php post_class( 'entry-grid col3'); ?>>
          <?php the_post_thumbnail( 'bones-thumb-302' ); ?>
          <div class="entry-content">
                      <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                      <p class="post-excerpt"><?php echo short( get_the_excerpt(), 160 ); ?></p>
                      <?php if( 'true' != $pls_hide_post_meta ) { ?>
                      <aside id="meta-<?php the_ID();?>" class="entry-meta"><?php newsplus_small_meta(); ?></aside>
                      <?php } ?>
          </div><!-- .entry-content -->
          </article><!-- #post-<?php the_ID();?> -->

      <?php } ?>
  
    <?php endwhile; ?> 
    
    <?php wp_reset_query(); ?>
    </div> <!--end featured content -->
<?php } /* end if is_home and !is_paged() */?>

<!-- end featured post section -->

<div id="primary" class="site-content">
    <div id="content" role="main">
      
		<?php show_breadcrumbs(); ?>
    <h2 class="section-title"><span class="ss-label blue">
        <a href="http://labs.saurabh-sharma.net/themes/newsplus/wp/blog/" title="View all recent News">Recent Articles</a></span></h2>
    <?php
		if ( 'list-style' == $pls_archive_template )
			get_template_part( 'content-list' );
		elseif ( 'grid-style' == $pls_archive_template )
			get_template_part( 'content-grid' );
		else
			get_template_part( 'content-classic' ); ?>
    </div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>