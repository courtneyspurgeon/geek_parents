<?php
/**
 * Template Name: Page - Browse Categories
 *
 * Description: A category browse page with right aligned sidebar.
 */

get_header(); ?>
<div id="primary" class="site-content">
    <div id="content" role="main">

        <h1 class="section-title">Browse by Topic</h1>

        <div id="category_list">
            <ul>
                <?php list_cats_desc_thumb(); ?>
            </ul>
        </div><!-- #category_list -->

    </div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>