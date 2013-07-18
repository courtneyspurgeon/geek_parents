<?php
/**
 * Template Name: Page - Browse Categories
 *
 * Description: A category browse page with right aligned sidebar.
 */

/* 2013.07.18   =>  This was originally declared in our theme's custom functions.php file */
// 2013.06.26   =>  Originally added by Courtney Spurgeon to list categories with descriptions
// code found online and adjusted to our needs
// source: http://www.wplover.com/1016/category-based-navigation-with-description-a-la-grid-focus/
function list_cats_desc_thumb() {
    $base = wp_list_categories('echo=0&title_li=&show_count=1');

    // wp_list_categories adds a "cat-item-[category_id]" class to the <li> so let's make use of that!
    $get_cat_id = '/cat-item-[0-9]+/';
    preg_match_all($get_cat_id, $base, $cat_id);

    // Let's prepare our category descriptions to be injected.
    $inject_desc = array();

    $i = 0;
    foreach($cat_id[0] as $id) {
        $id = trim($id,'cat-item-');
        $id = trim($id,'"');
        $cat = get_category($id);

        $desc = trim(strip_tags($cat->category_description),"\n");   // For some reason, category_description returns the
        // description wrapped in an unwanted paragraph tag which
        // we remove with strip_tags. It also adds a newline
        // which we promptly trim out.
        $thumbs = get_thumbnails_from_categories($cat->term_id);

        $inject_desc[$i] = '<div class="cat_thumbnails">' . $thumbs . '</div>' .
            '<p class="cat-desc">' . $desc . '</p></li>';
        $i++;
    }

    // Now we inject our descriptions
    $base_arr = explode("\n", $base);

    $base_i = 0;
    foreach($inject_desc as $desc) {

        // We check whether there's an occurence of "</a>"
        while(strpos($base_arr[$base_i], "</a>") === false) {
            $base_i++;
        }

        // replace ([count]), with (View all [count] articles), and make it part of the link
        $base_arr[$base_i] = str_replace('</a>', '', $base_arr[$base_i]);
        $pattern = '/\([0-9]+\)/';
        preg_match($pattern, $base_arr[$base_i], $matches);
        $count_text = $matches[0];
        preg_match('/[0-9]+/', $count_text, $number_match);
        $number = $number_match[0];
        $base_arr[$base_i] = str_replace($count_text, '(View all '.$number.')</a>', $base_arr[$base_i]);
        $base_arr[$base_i] .= $desc;
        $base_i++;
    }

    $base = implode("\n", $base_arr);
    echo $base;
}

get_header(); ?>
<div id="primary" class="site-content">
    <div id="content" role="main">

        <h1 class="section-title">Browse by Topic</h1>

        <div id="category_list">
            <ul>
                <?php
                if (function_exists('list_cats_desc_thumb')) {
                    list_cats_desc_thumb();
                } else {
                    echo "list_cats_desc_thumb is not available.<br>";
                }
                ?>
            </ul>
        </div><!-- #category_list -->

    </div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>