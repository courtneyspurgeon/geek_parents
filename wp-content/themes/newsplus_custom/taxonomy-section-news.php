<?php
/**
 * Created by courtneyspurgeon
 * Date: 7/2013 
 * http://courtneyspurgeon.com
 */

global $pls_archive_template;
get_header();
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
?>
    <div id="primary" class="site-content full-width">
        <div id="content" role="main">
            <?php
            if ( have_posts() )
                the_post();
            ?>
            <h1 class="section-title header-title"><span class="ss-label red"><?php printf( __( '%s', 'newsplus' ), single_cat_title( $term->name, false ) ); ?></span></h1>
            <?php
            rewind_posts();
            if ( 'list-style' == $pls_archive_template )
                get_template_part( 'content-list' );
            elseif ( 'grid-style' == $pls_archive_template )
                get_template_part( 'templates/content-grid-news' );
            else
                get_template_part( 'content-classic' ); ?>
        </div><!-- #content -->
    </div><!-- #primary -->
<?php get_footer(); ?>