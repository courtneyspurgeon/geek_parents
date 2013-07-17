<?php

/**
 * BuddyPress - Users Activity
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<div class="item-list-tabs no-ajax" id="subnav" role="navigation">
	<ul>

		<?php bp_get_options_nav(); ?>
		<?php //removed markup that adds filter by type ?>
	</ul>

</div><!-- .item-list-tabs -->

<?php // removed  'activity/post-form' - text input for status updates, etc ?>

<div class="activity" role="main">

	<?php bp_get_template_part( 'activity/activity-loop' ) ?>

</div><!-- .activity -->

<?php do_action( 'bp_after_member_activity_content' ); ?>
