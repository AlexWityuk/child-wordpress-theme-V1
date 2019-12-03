<?php 
/*
*  add columns "Binded to Guida" to custom post tables guida-items
*
*/
add_filter('manage_guida_item_posts_columns','filter_toplegal_cpt_columns');

function filter_toplegal_cpt_columns( $columns ) {
    // this will add the column to the end of the array
    $columns['binded_guida'] = 'Bound to Guida';
    //add more columns as needed

    // as with all filters, we need to return the passed content/variable
    return $columns;
}
add_action( 'manage_posts_custom_column','action_custom_columns_content', 10, 2 );
function action_custom_columns_content ( $column_id, $post_id ) {
    //run a switch statement for all of the custom columns created
    switch( $column_id ) { 
        case 'binded_guida':
            echo ($value = get_post_meta( $post_id, 'bind-to-guida-slug', true ) ) ? $value : 'No First Guida slug Given';
        break;

        //add more items here as needed, just make sure to use the column_id in the filter for each new item.

   }
}
/*----------------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------------*/

function register_toplegal_post_type() {
	/*----------------------------------------------------------------------------------------------------*/
	/*  Top legal: Implement Guide Top legal - The admin part
	/*  Create the post_type called "guida_item" 'show_in_menu' => false
	/*----------------------------------------------------------------------------------------------------*/
	$slug = 'guida_item';
	register_post_type($slug,
		array(
			'labels' => array(
				'name' => esc_html__( 'Guida Item', 'tecnavia' ),
				'singular_name' => esc_html__( 'Guida Item', 'tecnavia' )
			),
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'capability_type' => 'post',
			'query_var' => true,
			'show_ui' => true,
			'show_in_menu' => true, //true
			'show_in_admin_bar' => true,
			'has_archive' => true,
			//	'menu_icon' => 'dashicons-sticky',
			'menu_icon' => 'dashicons-calendar-alt',
			'menu_position' => 8,

			'rewrite' => array(
				'slug' => $slug,
			),
			'supports'     => array(
				'title',
				'editor'
			),
		)
	);
	$labels = array(
			'name'              => _x( 'Ranking', 'taxonomy general name', 'tecnavia' ),
			'singular_name'     => _x( 'Ranking', 'taxonomy singular name', 'tecnavia' ),
			'search_items'      => __( 'Search Ranking', 'tecnavia' ),
			'all_items'         => __( 'All Ranking', 'tecnavia' ),
			'parent_item'       => __( 'Parent Ranking', 'tecnavia' ),
			'parent_item_colon' => __( 'Parent Ranking:', 'tecnavia' ),
			'edit_item'         => __( 'Edit Ranking', 'tecnavia' ),
			'update_item'       => __( 'Update Ranking', 'tecnavia' ),
			'add_new_item'      => __( 'Add New Ranking', 'tecnavia' ),
			'new_item_name'     => __( 'New Ranking Name', 'tecnavia' ),
			'menu_name'         => __( 'Ranking', 'tecnavia' ),
	);
	
	$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'ranking' ),
	);
	
	register_taxonomy( 'ranking', array( $slug ), $args );

	$labels = array(
			'name'              => _x( 'Settore', 'taxonomy general name', 'tecnavia' ),
			'singular_name'     => _x( 'Settore', 'taxonomy singular name', 'tecnavia' ),
			'search_items'      => __( 'Search Settore', 'tecnavia' ),
			'all_items'         => __( 'All Settore', 'tecnavia' ),
			'parent_item'       => __( 'Parent Settore', 'tecnavia' ),
			'parent_item_colon' => __( 'Parent Settore:', 'tecnavia' ),
			'edit_item'         => __( 'Edit Settore', 'tecnavia' ),
			'update_item'       => __( 'Update Settore', 'tecnavia' ),
			'add_new_item'      => __( 'Add New Settore', 'tecnavia' ),
			'new_item_name'     => __( 'New Settore Name', 'tecnavia' ),
			'menu_name'         => __( 'Settore', 'tecnavia' ),
	);
	
	$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'settore' ),
	);
	
	register_taxonomy( 'settore', array( $slug ), $args );
	/*----------------------------------------------------------------------------------------------------*/
	/*  Top legal: Implement Guide Top legal - The admin part
	/*  Create the post_type called "guida" 
	/*----------------------------------------------------------------------------------------------------*/
	$slug = 'guida';
	register_post_type($slug,
		array(
			'labels' => array(
				'name' => esc_html__( 'Guida', 'tecnavia' ),
				'singular_name' => esc_html__( 'Guida', 'tecnavia' )
			),
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'capability_type' => 'post',
			'query_var' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_admin_bar' => true,
			'has_archive' => true,
			//	'menu_icon' => 'dashicons-sticky',
			'menu_icon' => 'dashicons-calendar-alt',
			'menu_position' => 8,

			'rewrite' => array(
				'slug' => $slug,
			),
			'supports'     => array(
				'title',
				'editor',
				'thumbnail',
				'excerpt'
			),
		)
	);
	
	$labels = array(
			'name'              => _x( 'Aree Attività', 'taxonomy general name', 'tecnavia' ),
			'singular_name'     => _x( 'Aree Attività', 'taxonomy singular name', 'tecnavia' ),
			'search_items'      => __( 'Search Aree Attività', 'tecnavia' ),
			'all_items'         => __( 'All Aree Attività', 'tecnavia' ),
			'parent_item'       => __( 'Parent Aree Attività', 'tecnavia' ),
			'parent_item_colon' => __( 'Parent Aree Attività:', 'tecnavia' ),
			'edit_item'         => __( 'Edit Aree Attività', 'tecnavia' ),
			'update_item'       => __( 'Update Aree Attività', 'tecnavia' ),
			'add_new_item'      => __( 'Add New Aree Attività', 'tecnavia' ),
			'new_item_name'     => __( 'New Aree Attività Name', 'tecnavia' ),
			'menu_name'         => __( 'Aree Attività', 'tecnavia' ),
	);
	
	$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'aree-attività' ),
	);
	
	register_taxonomy( 'aree-attività', array( $slug ), $args );

	$args = array(
			'public' => true,
			'label'  => 'Company',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'company' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);
	register_post_type( 'company', $args );
	$args = array(
			'public' => true,
			'label'  => 'Professionist',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'professionist' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);
	register_post_type( 'professionist', $args );
	$args = array(
			'public' => true,
			'label'  => 'Agenda',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'agenda' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);
	register_post_type( 'agenda', $args );
	
	$args = array(
			'hierarchical'      => true,
			'label'            =>  "Tipo",
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'agenda-type' ),
	);
	
	register_taxonomy( 'agenda-type', array( 'agenda' ), $args );
	
	$args = array(
			'public' => true,
			'label'  => 'Osservatori',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'osservatori' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);
	register_post_type( 'osservatori', $args );

	/*--------------------------------------------------------------------------*/
	/* Register this new post type Whitepaper with its categories
	/*---------------------------------------------------------------------------*/
	$slug = 'white_paper';//'diritto_az';
	register_post_type($slug,
		array(
			'labels' => array(
				'name' => esc_html__( 'White papers', 'tecnavia' ),
				'singular_name' => esc_html__( 'White papers', 'tecnavia' )
			),
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'capability_type' => 'post',
			'query_var' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_admin_bar' => true,
			'has_archive' => true,
			'menu_position' => null,

			'rewrite' => array(
				'slug' => $slug,
			),
			'supports'     => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
			),
		)
	);
	$labels = array(
		'name'              => _x( 'White paper Categories', 'taxonomy general name', 'tecnavia' ),
		'singular_name'     => _x( 'White paper Category', 'taxonomy singular name', 'tecnavia' ),
		'search_items'      => __( 'Search Category', 'tecnavia' ),
		'all_items'         => __( 'All Categories', 'tecnavia' ),
		'parent_item'       => __( 'Parent Category', 'tecnavia' ),
		'parent_item_colon' => __( 'Parent Category:', 'tecnavia' ),
		'edit_item'         => __( 'Edit Category', 'tecnavia' ),
		'update_item'       => __( 'Update Category', 'tecnavia' ),
		'add_new_item'      => __( 'Add New Category', 'tecnavia' ),
		'new_item_name'     => __( 'New Category Name', 'tecnavia' ),
		'menu_name'         => __( 'Categories', 'tecnavia' ),
	);
	
	$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'white-paper-category' ),
	);
	
	register_taxonomy( 'white-paper-category', array( $slug ), $args );
	
	$labels = array(
			'name'              => _x( 'Whitepaper Categories', 'taxonomy general name', 'tecnavia' ),
			'singular_name'     => _x( 'Whitepaper Category', 'taxonomy singular name', 'tecnavia' ),
			'search_items'      => __( 'Search Category', 'tecnavia' ),
			'all_items'         => __( 'All Categories', 'tecnavia' ),
			'parent_item'       => __( 'Parent Category', 'tecnavia' ),
			'parent_item_colon' => __( 'Parent Category:', 'tecnavia' ),
			'edit_item'         => __( 'Edit Category', 'tecnavia' ),
			'update_item'       => __( 'Update Category', 'tecnavia' ),
			'add_new_item'      => __( 'Add New Category', 'tecnavia' ),
			'new_item_name'     => __( 'New Category Name', 'tecnavia' ),
			'menu_name'         => __( 'Categories', 'tecnavia' ),
	);
	
	$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'whitepaper-category' ),
	);
	
	register_taxonomy( 'whitepaper-category', array( $slug ), $args );
}
add_action( 'init', 'register_toplegal_post_type' );

?>