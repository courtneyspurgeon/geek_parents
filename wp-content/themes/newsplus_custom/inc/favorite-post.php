<?php
/* Based on the work of 
 *
 * http://www.dnxpert.com/2010/06/11/mark-blog-post-as-favorite-in-buddypress/
 */

function my_bp_activity_is_favorite($activity_id) 
{
  global $bp, $activities_template;
  return apply_filters( 'bp_get_activity_is_favorite', in_array( $activity_id, (array)$activities_template->my_favs ) );
}

function my_bp_activity_favorite_link($activity_id) 
{
  global $activities_template;
  echo apply_filters( 'bp_get_activity_favorite_link', wp_nonce_url( site_url( BP_ACTIVITY_SLUG . '/favorite/' . $activity_id . '/' ), 'mark_favorite' ) );
}

function my_bp_activity_unfavorite_link($activity_id) 
{
  global $activities_template;
  echo apply_filters( 'bp_get_activity_unfavorite_link', wp_nonce_url( site_url( BP_ACTIVITY_SLUG . '/unfavorite/' . $activity_id . '/' ), 'unmark_favorite' ) );
}


/* Add a new activity stream item for when people read a post */
function read_articles_post_activity() 
{
  global $wpdb;
  global $current_user;
  get_currentuserinfo();

  $post_id = url_to_postid( "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] );

  if ( !function_exists( 'bp_activity_add' ) )
    return false;

  if ((!$current_user) or (!$post_id))
    return false;

  // We don't want anonymous users
  if ($current_user->ID == 0)
    return false;

  $post = get_post($post_id);

  // TODO: Switch to bp_activity_get_user_favorites()
  // $favs = bp_activity_get_user_favorites( $current_user->ID );
  $count = $wpdb->get_var( $wpdb->prepare("select count(*) from ".$wpdb->prefix."bp_activity where type='blog_post_read' and user_id='%s' and secondary_item_id='%s';", 
      $current_user->ID, $post_id ));

  if ($count == 0)
  {
      bp_activity_add(array( 
          'action'              => sprintf( __( '%s read the article %s' ), $current_user->first_name,$post->post_title ),
          'component'           => 'blogs',
          'type'                => 'blog_post_read',
          'user_id'             => $current_user->ID,
          'item_id'             => 1,
          'secondary_item_id'   => $post_id,
          'recorded_time'       => date('Y-m-d H:i:s'),
      ));
  }

}

add_action( 'get_footer', 'read_articles_post_activity' );

?>
