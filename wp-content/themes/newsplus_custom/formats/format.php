<?php
/* Post Format - Standard */

$title = get_the_title();
$permalink = get_permalink();
if ( has_post_thumbnail() ) {
	$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'two_col_thumb' );
	$img = $img_src[0];
  $out = '<div class="post-thumb"><a href="' . $permalink . '" title="' . $title . '"><img src="' . $img . '" alt="' . $title . '" title="' . $title . '"/></a>';

  //Customization: June 2013 by cspurgeon
  // If the article was posted in the last 15 days (for dev site), add a new-tag div
  if (get_post_time('U', true) > strtotime('-15 days')) {
    $out .= '<div class="new-tag">New</div>';
  } 
  // close the post-thumb div    
  $out .= '</div>';
  // end customization

  echo $out;
} ?>