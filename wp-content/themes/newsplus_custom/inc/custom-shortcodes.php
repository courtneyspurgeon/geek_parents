<?php
/**
 * Newsplus Custom Theme short codes
 */

// Register and initialize custom short codes
function newsplus_custom_add_shortcodes() {
	add_shortcode( 'insert_homepage_section_posts', 'insert_homepage_section_posts' );
}
add_action( 'init', 'newsplus_custom_add_shortcodes' );


// This is an altered version of insert_posts from the newsplus theme
// with added functionality for inserting posts by section and making sure
// posts are also in the 'homepage' category
function insert_homepage_section_posts( $atts ) {
	extract( shortcode_atts( array(
		'posts'				=> '',
		'pages'				=> '',
		'tags'				=> '',
		'section'			=> '',
		'post_type'			=> '',
		'terms'				=> '',
		'operator'			=> 'IN',
		'order'				=> 'desc',
		'orderby'			=> 'date',
		'num'				=> '4',
		'display_style'		=> 'one-col',
		'offset'			=> '0',
		'excerpt_length'	=> '140',
		'hide_excerpt'		=> 'false',
		'hide_meta'			=> 'false',
		'hide_image'		=> 'false'
	), $atts ) );

	error_log("section: ".$section);
	$custom_args = array(
		'tax_query' => array(
			'relation' => 'AND',
				array(
					'taxonomy' => 'section',
					'field' => 'slug',
					'terms' => array( 'homepage')
				),
				array(
					'taxonomy' => 'section',
					'field' => 'slug',
					'terms' => array( $section ),
				)
			), //end tax_query array
		//'section'           => $section,
		'posts_per_page' 		=> $num,
		'order' 				=> $order,
		'orderby' 				=> $orderby,
		'offset' 				=> $offset,
		'post_status'			=> 'publish',
		'ignore_sticky_posts'	=> 1
	);

	$custom_query = new WP_Query( $custom_args );
    if ( $custom_query->have_posts() ) :
		$count = 1;
		$fclass = '';
		$lclass = '';
		if( $display_style == 'two-col' ) {
			$out = '<ul class="two-col clear">';
		}
		elseif ( $display_style == 'three-col' ) {
			$out = '<ul class="three-col clear">';
		}
		elseif ( $display_style == 'list-small' || $display_style == 'list-plain' ) {
			$out = '<ul class="post-list">';
		}
		else
			$out = '';

		while ( $custom_query->have_posts() ) :
			$custom_query->the_post();
			global $multipage;
			$multipage = 0;
			$time = get_the_time( get_option( 'date_format' ) );
			$permalink = get_permalink();
			$title = get_the_title();
			$excerpt = ( $hide_excerpt == 'true' ) ? '' : sprintf( '<p class="post-excerpt">%1$s</p>', short( get_the_excerpt(), $excerpt_length ) );
			$postID = get_the_ID();
			$num_comments = get_comments_number();
			if ( comments_open() ) {
				if ( $num_comments == 0 ) {
					$comments = __( '0 Comments', 'newsplus' );
				}
				elseif ( $num_comments > 1 ) {
					$comments = $num_comments . __( ' Comments', 'newsplus' );
				}
				else {
					$comments = __( '1 Comment', 'newsplus' );
				}
				$write_comments = sprintf( __( '<span class="sep"> | </span><a href="%1$s" title="Comment on %3$s">%2$s</a>', 'newsplus' ), get_comments_link(), $comments, $title );
			}
			else {
				$write_comments = '';
			}
			$post_meta = ( $hide_meta == 'true' ) ? '' : sprintf( '<span class="entry-meta">%7$s on <a href="%1$s" title="%2$s"><time class="entry-date" datetime="%3$s">%4$s</time></a>%5$s</span>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			$write_comments,
			coauthors_posts_links(null, null, null, null, false) );
			
			$post_meta_big = ( $hide_meta == 'true' ) ? '' : sprintf( '<span class="entry-meta">%7$s on <a href="%1$s" title="%2$s"><time class="entry-date" datetime="%3$s">%4$s</time></a> | %5$s%6$s</span>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			get_the_category_list( ', ' ),
			$write_comments,
			coauthors_posts_links(null, null, null, null, false) );
			
			$no_meta_class = ( 'true' == $hide_excerpt && 'true' == $hide_meta ) ? 'no-meta' : '';

			if ( has_post_thumbnail() && 'true' !== $hide_image ) {
				if ( $display_style == 'list-small' ) {
					$img = wp_get_attachment_image_src( get_post_thumbnail_id( $GLOBALS['post']->ID ), 'list_small_thumb' );
				}
				elseif ( $display_style == 'list-big' ) {
					$img = wp_get_attachment_image_src( get_post_thumbnail_id( $GLOBALS['post']->ID ), 'list_big_thumb' );
				}
				elseif ( $display_style == 'two-col' ) {
					$img = wp_get_attachment_image_src( get_post_thumbnail_id( $GLOBALS['post']->ID ), 'two_col_thumb' );
				}
				elseif ( $display_style == 'three-col' ) {
					$img = wp_get_attachment_image_src( get_post_thumbnail_id( $GLOBALS['post']->ID ), 'three_col_thumb' );
				}
				else {
					$img = wp_get_attachment_image_src( get_post_thumbnail_id( $GLOBALS['post']->ID ), 'size_max' );
				}
				$thumbnail = $img[0];
				$thumbclass = '';
				if ( $display_style == 'list-big') {
					$thumblink = sprintf( '<div class="entry-list-left"><div class="entry-thumb"><a href="%1$s" title="%2$s"><img src="%3$s" alt="%2$s" title="%2$s"/></a></div></div>', $permalink, $title, $thumbnail );
				}
				else {
					$thumblink = sprintf( '<div class="post-thumb"><a href="%1$s" title="%2$s"><img src="%3$s" alt="%2$s" title="%2$s"/></a></div>', $permalink, $title, $thumbnail );
				}
			}
			else {
				$thumblink = '';
				if ( $display_style == 'list-big' || $display_style == 'list-small' )
					$thumbclass = 'no-image';
			}
			if ( 'video' == get_post_format() && $display_style != 'list-small' ) {
				$post_opts = get_post_meta( $GLOBALS['post']->ID, 'post_options', true );
				$pf_video = ! empty( $post_opts['pf_video'] ) ? $post_opts['pf_video'] : '';
				global $wp_embed;
				$post_embed = $wp_embed->run_shortcode( '[embed]' . $pf_video . '[/embed]' );
				if ( '' != $pf_video ) {
					if ( $display_style == 'list-big' ) {
						$thumblink = sprintf( '<div class="entry-list-left"><div class="embed-wrap">%1$s</div></div>', $post_embed );
						$thumbclass = '';
					}
					else
						$thumblink = sprintf( '<div class="embed-wrap">%1$s</div>', $post_embed );
				}
			}
			if ( $display_style == 'two-col' ) {
				$fclass = ( 0 == ( ( $count - 1 ) % 2 ) ) ? ' first-grid' : '';
				$lclass = ( 0 == ( $count % 2 ) ) ? ' last-grid' : '';
				$format = '<li class="post-%1$s entry-grid %2$s%3$s">%4$s<div class="entry-content %9$s"><h3><a href="%5$s" title="%6$s">%6$s</a></h3>%7$s%8$s</div></li>';
				$out .= sprintf ( $format, $postID, $fclass, $lclass, $thumblink, $permalink, $title, $excerpt, $post_meta_big, $no_meta_class );
				$count++;
			}
			elseif ( $display_style == 'three-col' ) {
				$fclass = ( 0 == ( ( $count - 1 ) % 3 ) ) ? ' first-grid' : '';
				$lclass = ( 0 == ( $count % 3 ) ) ? ' last-grid' : '';
				$format = '<li class="post-%1$s entry-grid %2$s%3$s">%4$s<div class="entry-content %9$s"><h3><a href="%5$s" title="%6$s">%6$s</a></h3>%7$s%8$s</div></li>';
				$out .= sprintf ( $format, $postID, $fclass, $lclass, $thumblink, $permalink, $title, $excerpt, $post_meta, $no_meta_class );
				$count++;
			}
			elseif ( $display_style == 'list-big' ) {
				$format = '<div class="post-%1$s entry-list clear">%2$s<div class="entry-list-right %3$s"><h3><a href="%4$s" title="%5$s">%5$s</a></h3>%6$s%7$s</div></div>';
				$out .= sprintf ( $format, $postID, $thumblink, $thumbclass, $permalink, $title, $excerpt, $post_meta_big );
			}
			elseif ( $display_style == 'list-small' ) {
				$format = '<li>%1$s<div class="post-content %2$s"><h3><a href="%3$s" title="%4$s">%4$s</a></h3>%5$s</div></li>';
				$out .= sprintf ( $format, $thumblink, $thumbclass, $permalink, $title, $post_meta );
			}
			elseif ( $display_style == 'list-plain' ) {
				$format = '<li><h4><a href="%1$s" title="%2$s">%2$s</a></h4>%3$s</li>';
				$out .= sprintf ( $format, $permalink, $title, $post_meta );
			}
			else {
				$format = '<div class="one-col post-%1$s entry-grid">%2$s<div class="entry-content %7$s"><h3><a href="%3$s" title="%4$s">%4$s</a></h3>%5$s%6$s</div></div>';
				$out .= sprintf ( $format, $postID, $thumblink, $permalink, $title, $excerpt, $post_meta_big, $no_meta_class );
			}
		endwhile;
		if ( $display_style != 'one-col' && $display_style != 'list-big' )
			$out .= '</ul>';
		return $out;
	endif;
	wp_reset_query();
	wp_reset_postdata(); // Restore global post data
} ?>