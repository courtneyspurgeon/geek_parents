<?php
/**
 * Created by rob
 * Date: 6/25/13 4:05 PM
 *
 * Email:   rob@therobbrennan.com
 * Twitter: @therobbrennan
 * Web:     http://www.therobbrennan.com
 */

global $pls_archive_template;
get_header();
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
?>

    <div id="primary" class="site-content">
        <div id="content" role="main">
            <?php show_breadcrumbs();
            if ( have_posts() )
                the_post();
            ?>
            <h1 class="section-title"><?php printf( __( '%s', 'newsplus' ), single_cat_title( $term->name, false ) ); ?></h1>
            <?php
            rewind_posts();
            if ( 'list-style' == $pls_archive_template )
                get_template_part( 'content-list' );
            elseif ( 'grid-style' == $pls_archive_template )
                get_template_part( 'content-grid' );
            else
                get_template_part( 'content-classic' ); ?>
        </div><!-- #content -->
    </div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>