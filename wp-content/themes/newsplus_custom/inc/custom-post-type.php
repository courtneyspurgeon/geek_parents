<?php
/* Bones Library Item Type Example
This page walks you through creating 
a library item type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/


// let's create the function for the custom type
// function custom_posts() { 
// 	// creating (registering) the custom type 
// 	register_post_type( 'posts', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
// 	 	// let's now add all the options for this post type
// 		array('labels' => array(
// 			'name' => __('Library Items', 'gp-custom'), /* This is the Title of the Group */
// 			'singular_name' => __('Library Item', 'gp-custom'), /* This is the individual type */
// 			'all_items' => __('All Library Items', 'gp-custom'), /* the all items menu item */
// 			'add_new' => __('Add New', 'gp-custom'), /* The add new menu item */
// 			'add_new_item' => __('Add New Library Item', 'gp-custom'), /* Add New Display Title */
// 			'edit' => __( 'Edit', 'gp-custom' ), /* Edit Dialog */
// 			'edit_item' => __('Edit Library Items', 'gp-custom'), /* Edit Display Title */
// 			'new_item' => __('New Library Item', 'gp-custom'), /* New Display Title */
// 			'view_item' => __('View Library Item', 'gp-custom'), /* View Display Title */
// 			'search_items' => __('Search Library Item', 'gp-custom'), /* Search Library Item Title */ 
// 			'not_found' =>  __('Nothing found in the Database.', 'gp-custom'), /* This displays if there are no entries yet */ 
// 			'not_found_in_trash' => __('Nothing found in Trash', 'gp-custom'), /* This displays if there is nothing in the trash */
// 			'parent_item_colon' => ''
// 			), /* end of arrays */
// 			'description' => __( 'This is the library item type', 'gp-custom' ), /* Library Item Description */
// 			'public' => true,
// 			'publicly_queryable' => true,
// 			'exclude_from_search' => false,
// 			'show_ui' => true,
// 			'query_var' => true,
// 			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
// 			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the library item type menu */
// 			'rewrite'	=> array( 'slug' => 'posts', 'with_front' => false ), /* you can specify its url slug */
// 			'has_archive' => 'posts', /* you can rename the slug here */
// 			'capability_type' => 'post',
// 			'hierarchical' => false,
// 			/* the next one is important, it tells what's enabled in the post editor */
// 			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
// 	 	) /* end of options */
// 	); /* end of register post type */
// 	
// 	/* this adds your post categories to your library item type */
// 	// register_taxonomy_for_object_type('category', 'posts');
// 	/* this adds your post tags to your library item type */
// 	// register_taxonomy_for_object_type('post_tag', 'posts');
// 	
// } 

	// adding the function to the Wordpress init
	// add_action( 'init', 'custom_posts');
	
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	
	// now let's add custom categories (these act like categories)
    // register_taxonomy( 'custom_cat', 
    // 	array('posts'), /* if you change the name of register_post_type( 'posts', then you have to change this */
    // 	array('hierarchical' => true,     /* if this is true, it acts like categories */             
    // 		'labels' => array(
    // 			'name' => __( 'Library Categories', 'gp-custom' ), /* name of the custom taxonomy */
    // 			'singular_name' => __( 'Library Category', 'gp-custom' ), /* single taxonomy name */
    // 			'search_items' =>  __( 'Search Library Categories', 'gp-custom' ), /* search title for taxomony */
    // 			'all_items' => __( 'All Library Categories', 'gp-custom' ), /* all title for taxonomies */
    // 			'parent_item' => __( 'Parent Library Category', 'gp-custom' ), /* parent title for taxonomy */
    // 			'parent_item_colon' => __( 'Parent Library Category:', 'gp-custom' ), /* parent taxonomy title */
    // 			'edit_item' => __( 'Edit Library Category', 'gp-custom' ), /* edit custom taxonomy title */
    // 			'update_item' => __( 'Update Library Category', 'gp-custom' ), /* update title for taxonomy */
    // 			'add_new_item' => __( 'Add New Library Category', 'gp-custom' ), /* add new title for taxonomy */
    // 			'new_item_name' => __( 'New Library Category Name', 'gp-custom' ) /* name title for taxonomy */
    // 		),
    // 		'show_admin_column' => true, 
    // 		'show_ui' => true,
    // 		'query_var' => true,
    // 		'rewrite' => array( 'slug' => 'custom-slug' ),
    // 	)
    // );   
    
	// now let's add custom tags (these act like categories)
    // register_taxonomy( 'custom_tag', 
    // 	array('posts'), /* if you change the name of register_post_type( 'posts', then you have to change this */
    // 	array('hierarchical' => false,    /* if this is false, it acts like tags */                
    // 		'labels' => array(
    // 			'name' => __( 'Library Tags', 'gp-custom' ), /* name of the custom taxonomy */
    // 			'singular_name' => __( 'Library Tag', 'gp-custom' ), /* single taxonomy name */
    // 			'search_items' =>  __( 'Search Library Tags', 'gp-custom' ), /* search title for taxomony */
    // 			'all_items' => __( 'All Library Tags', 'gp-custom' ), /* all title for taxonomies */
    // 			'parent_item' => __( 'Parent Library Tag', 'gp-custom' ), /* parent title for taxonomy */
    // 			'parent_item_colon' => __( 'Parent Library Tag:', 'gp-custom' ), /* parent taxonomy title */
    // 			'edit_item' => __( 'Edit Library Tag', 'gp-custom' ), /* edit custom taxonomy title */
    // 			'update_item' => __( 'Update Library Tag', 'gp-custom' ), /* update title for taxonomy */
    // 			'add_new_item' => __( 'Add New Library Tag', 'gp-custom' ), /* add new title for taxonomy */
    // 			'new_item_name' => __( 'New Library Tag Name', 'gp-custom' ) /* name title for taxonomy */
    // 		),
    // 		'show_admin_column' => true,
    // 		'show_ui' => true,
    // 		'query_var' => true,
    // 	)
    // ); 
    
    /*
    	looking for custom meta boxes?
    	check out this fantastic tool:
    	https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
    */
	
    function be_sample_metaboxes( $meta_boxes ) {
        $prefix = '_cmb_'; // Prefix for all fields
        $meta_boxes[] = array(
            'id' => 'original_article',
            'title' => 'Original Article',
            'pages' => array('post'), // post type
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true, // Show field names on the left
            'fields' => array(
                array(
                    'name' => 'Alternative Title',
                    'desc' => '(optional)',
                    'id' => $prefix . 'alt_title',
                    'type' => 'text'
                ),
                array(
                    'name' => 'Source Url',
                    'desc' => 'Full url of the original article',
                    'id' => $prefix . 'source_url',
                    'type' => 'text'
                ),
                array(
                    'name' => 'Original Publish Date',
                    'desc' => 'Date the original article was published',
                    'id' => $prefix . 'original_publish_date',
                    'type' => 'text'
                ),
                array(
                    'name' => 'Full-Text',
                    'desc' => 'Paste the full text of the content here. This will NOT be shown to users; it is only indexed for searching purposes.',
                    'id' => $prefix . 'full_text',
                    'type' => 'textarea'
                ),
            ),
        );

        $meta_boxes[] = array(
            'id' => 'article_information',
            'title' => 'Article Information',
            'pages' => array('post'), // post type
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true, // Show field names on the left
            'fields' => array(
                array(
                    'name' => 'Creator',
                    'desc' => '(optional)',
                    'id' => $prefix . 'creator',
                    'type' => 'text'
                ),
                array(
                    'name' => 'Contributor',
                    'desc' => '(optional)',
                    'id' => $prefix . 'contributor',
                    'type' => 'text'
                ),
                array(
                    'name' => 'Publisher',
                    'desc' => '(optional)',
                    'id' => $prefix . 'publisher',
                    'type' => 'text'
                ),
                array(
                    'name' => 'Audience',
                    'desc' => '(optional)',
                    'id' => $prefix . 'audience',
                    'type'    => 'multicheck',
                    'options' => array(
                        'parents'   => 'Parents',
                        'students'  => 'Students',
                        'teachers'  => 'Teachers',
                        'gamers'    => 'Gamers',
                    ),
                ),
                array(
                    'name'    => 'Type',
                    'desc'    => 'Source Article Type',
                    'id'      => $prefix . 'source_type',
                    'type'    => 'radio',
                    'options' => array(
                        array( 'name' => 'News',       'value' => 'news', ),
                        array( 'name' => 'Scholarly',  'value' => 'scholarly', ),
                        array( 'name' => 'Blog Post',  'value' => 'blog', ),
                    ),
                ),
            ),
        );

        $meta_boxes[] = array(
            'id' => 'import_details',
            'title' => 'Import Details',
            'pages' => array('post'), // post type
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true, // Show field names on the left
            'fields' => array(
                array(
                    'name' => 'Date Created',
                    'desc' => '(optional)',
                    'id' => $prefix . 'date_created',
                    'type' => 'text_date'
                ),
                array(
                    'name' => 'Accrual Method',
                    'desc' => '(optional)',
                    'id' => $prefix . 'accrual_method',
                    'type'    => 'radio',
                    'options' => array(
                        array( 'name' => 'Manual',     'value' => 'manual', ),
                        array( 'name' => 'Automatic',  'value' => 'automatic', ),
                    ),
                ),
                array(
                    'name' => 'License',
                    'desc' => 'Article License',
                    'id' => $prefix . 'article_license',
                    'type' => 'textarea_small'
                ),
            ),
        );

        return $meta_boxes;
    }
    add_filter( 'cmb_meta_boxes', 'be_sample_metaboxes' );

    add_action( 'init', 'be_initialize_cmb_meta_boxes', 9999 );

    function be_initialize_cmb_meta_boxes() {
        if ( !class_exists( 'cmb_Meta_Box' ) ) {
            require_once( get_stylesheet_directory() . '/inc/metabox/init.php' );
        }
    }
?>
