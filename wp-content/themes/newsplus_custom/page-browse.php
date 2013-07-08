<?php
/**
 * Template Name: Page - Browse Categories
 *
 * Description: A category browse page with right aligned sidebar.
 */

get_header(); ?>
<div id="primary" class="site-content">
    <div id="content" role="main">

        <h2>Browse by Topic</h2>

        <div id="category_list">
            <ul>
                <?php list_cats_desc_thumb(); ?>
            </ul>
        </div><!-- #category_list -->

    </div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>