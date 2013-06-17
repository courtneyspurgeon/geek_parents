<?php
/**
 * Template Name: Page - Browse Categories
 *
 * Description: A category browse page with right aligned sidebar.
 */

get_header(); ?>
<div id="primary" class="site-content">
    <div id="content" role="main">
    <?php show_breadcrumbs(); ?>

      <h2 style='display:none;'>Featured Categories</h2>

            <?php $intCount = 0; ?>

            <div id="featured-categories" style='display:none;'>
                <?php $arrCategories = get_top_posts_categories(4); ?>

                <?php foreach ($arrCategories as $strCatID) : ?>
                        <div class='span3'>
                            <a href="<?php echo get_category_link($strCatID) ?>">
                                <div class="cat-name"><?php echo get_category($strCatID)->cat_name ?></div>
                                <div class="brthumbnail"><?php //echo get_thumbnails_from_categories($strCatID); ?></div>
                            </a>
                            <div class="cat-description"><?php echo get_category($strCatID)->description ?></div>
                        </div>
                <?php endforeach; ?>

            </div><!-- #featured-categories -->

            <h2>All Categories</h2>

            <div id="all-categories">

                <?php $arrCategories = get_categories(array(
                    'parent'                   => 0,
                    'orderby'                  => 'name',
                    'order'                    => 'ASC',
                    'hide_empty'               => 1,
                    'exclude'                  => '6,1,17',
                    'hierarchical'             => 0,
                    'pad_counts'               => true ));?>

                <?php $intCount = 0; ?>

                <?php foreach ($arrCategories as $objCategory) { ?>
                        <div class='span3'>
                            <a href="<?php echo get_category_link($objCategory->cat_ID) ?>">
                                <div class="cat-name"><?php echo $objCategory->cat_name ?></div>
                                <div class="brthumbnail"><?php // echo get_thumbnails_from_categories($objCategory->cat_ID); ?></div>
                            </a>
                            <div class="cat-description"><?php echo $objCategory->description ?></div>
                        </div>
                <?php } ?>

            </div><!-- #all-categories -->

    </div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>