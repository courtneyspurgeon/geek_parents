<?php do_action( 'bp_before_activity_loop' ); ?>
<?php $fav_display = (bp_current_action() === 'favorites') ? true : false; ?>
<?php if ( bp_has_activities( bp_ajax_querystring( 'activity' ) ) || $fav_display ) : ?>

	<?php /* Show pagination if JS is not enabled, since the "Load More" link will do nothing */ ?>
	<noscript>
		<div class="pagination">
			<div class="pag-count"><?php bp_activity_pagination_count(); ?></div>
			<div class="pagination-links"><?php bp_activity_pagination_links(); ?></div>
		</div>
	</noscript>

	<?php if ( $fav_display ) : // courtneyspurgeon: favorites tab displays favorited posts instead of activities ?>
		<?php if (function_exists( 'wp_favorite_posts' )) : ?>
			<?php echo do_shortcode('[wp-favorite-posts]'); ?>
		<?php else: ?>
			<p>The ability to favorite posts is currently offline.</p>
		<?php endif; ?>
		
	<?php else: ?>

		<?php if ( empty( $_POST['page'] ) ) : ?>

			<ul id="activity-stream" class="activity-list item-list">

		<?php endif; ?>

		<?php while ( bp_activities() ) : bp_the_activity(); ?>

			<?php bp_get_template_part( 'activity/entry' ); ?>

		<?php endwhile; ?>

		<?php if ( bp_activity_has_more_items() ) : ?>

			<li class="load-more">
				<a href="#more"><?php _e( 'Load More', 'buddypress' ); ?></a>
			</li>

		<?php endif; ?>

		<?php if ( empty( $_POST['page'] ) ) : ?>

			</ul>

		<?php endif; ?>
	<?php endif; // end if favorite ?>

<?php else : ?>

	<div id="message" class="info">
		<p><?php _e( 'Sorry, there was no activity found. Please try a different filter.', 'buddypress' ); ?></p>
	</div>

<?php endif; ?>

<?php do_action( 'bp_after_activity_loop' ); ?>

<form action="" name="activity-loop-form" id="activity-loop-form" method="post">

	<?php wp_nonce_field( 'activity_filter', '_wpnonce_activity_filter' ); ?>

</form>