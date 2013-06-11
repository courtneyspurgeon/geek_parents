<?php get_header(); ?>

<?php $arrTags = get_tags_in_category($wp_query->get_queried_object_id()) ?>

<div id="category-tags">
<?php foreach ($arrTags as $strTagSlug=>$objTag) : ?>
    <a href="<?php echo get_site_url().'?cat='.$wp_query->get_queried_object_id().'&tag='.$objTag->slug ?>"> <?php echo $objTag->slug ?> (<?php echo $objTag->count ?>)</a>
<?php endforeach; ?>
</div>

	<div id="main-content">

		<?php do_action( 'bp_before_archive' ); ?>

		<div class="page" id="blog-archives" role="main">

            <h3 class="pagetitle"><a href="<?php echo get_site_url().'/category/'.$wp_query->get_queried_object()->slug ?>"><?php printf( __( 'You are browsing %1$s.', 'buddypress' ), wp_title( false, false ) ); ?></a></h3>

			<?php if ( have_posts() ) : ?>

				<?php bp_dtheme_content_nav( 'nav-above' ); ?>

                <?php $intCount = 0; ?>

				<?php while (have_posts()) : the_post(); ?>

					<?php do_action( 'bp_before_blog_post' ); ?>

                    <?php echo ($intCount == 0 ? '<div class="row-fluid">' : '' ); ?>
                        <div class="topic-story span3">
                            <?php get_template_part('single','card'); ?>
                        </div><!-- span3 -->
                    <?php echo ($intCount == 3 ? '</div><!-- row-fluid -->' : '' ); ?>

                    <?php if ($intCount == 3) { $intCount = 0; } else { $intCount++; } ?>

					<?php do_action( 'bp_after_blog_post' ); ?>

				<?php endwhile; ?>

				<?php bp_dtheme_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<h2 class="center"><?php _e( 'Not Found', 'buddypress' ); ?></h2>
				<?php get_search_form(); ?>

			<?php endif; ?>

		</div>

		<?php do_action( 'bp_after_archive' ); ?>

	</div><!-- #main-content -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
