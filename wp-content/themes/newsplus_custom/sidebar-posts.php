<?php
/**
 * The sidebar for post pages
 */
global $post, $pls_ss_sharing, $pls_ss_sharing_heading, $pls_author, $pls_rp, $pls_rp_taxonomy, $pls_rp_style, $pls_rp_num, $pls_ad_below;
// Check if an exclusive widget area is registered from page or post options
if ( is_page() ) :
  $page_opts = get_post_meta( $posts[0]->ID, 'page_options', true );
  $sb_usage = ( isset( $page_opts['sb_usage'] ) ) ? $page_opts['sb_usage'] : 'default-sidebar';
elseif ( is_single() ) :
  $post_opts = get_post_meta( $posts[0]->ID, 'post_options', true );
  $sb_usage = ( isset( $post_opts['sb_usage'] ) ) ? $post_opts['sb_usage'] : 'default-sidebar';
endif; ?>

<div id="sidebar" class="widget-area" role="complementary">

  <?php if ( is_user_logged_in() && function_exists( 'wp_favorite_posts' ) ) : ?>
    <?php wpfp_link(); ?> 
  <?php endif;?>

  <?php if ( 'true' == $pls_ss_sharing ) : ?>
    <h3 class="sb-title">Share this Article</h3>
    <div class="ss-sharing-container clear">
        <?php if ( ! empty( $pls_ss_sharing_heading ) )
          echo stripslashes( '<h4>' . $pls_ss_sharing_heading . '</h4>' );
        ss_sharing(); ?>
    </div><!-- .ss-sharing-container -->
  <?php endif; // Social Sharing ?>


  <h3 class="sb-title">Start a Conversation</h3>
  <p>Wanna talk further about something related to this article (or anything else)? Start a conversation!</p>
  <?php echo do_shortcode('[bbp-topic-form]'); ?>


  <?php if (!dynamic_sidebar('sidebar-posts') ) : // pull in the custom sidebar-posts widget?>
    <?php if ( 'true' == $pls_rp )
        newsplus_related_posts( $pls_rp_taxonomy, $pls_rp_style, $pls_rp_num ); ?>
  <?php endif; ?>

</div><!-- #sidebar -->