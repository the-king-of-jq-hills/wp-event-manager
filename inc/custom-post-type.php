<?php
/**
 * Functions to register custom post type
 *
 * @since    1.0.0
 */ 

 /*
* Creating the CPT
*/  
function wp_ec_custom_post_type() {
  
	// Set UI labels for Custom Post Type
		$labels = array(
			'name'                => _x( 'Events', 'Post Type General Name', 'wp-ec' ),
			'singular_name'       => _x( 'Event', 'Post Type Singular Name', 'wp-ec' ),
			'menu_name'           => __( 'Events', 'wp-ec' ),
			'all_items'           => __( 'All Events', 'wp-ec' ),
			'view_item'           => __( 'View Event', 'wp-ec' ),
			'add_new_item'        => __( 'Add New Event', 'wp-ec' ),
			'add_new'             => __( 'Add New', 'wp-ec' ),
			'edit_item'           => __( 'Edit Event', 'wp-ec' ),
			'update_item'         => __( 'Update Event', 'wp-ec' ),
			'search_items'        => __( 'Search Event', 'wp-ec' ),
			'not_found'           => __( 'Not Found', 'wp-ec' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'wp-ec' ),
		);
		  
	// Set other options for Custom Post Type
		  
		$args = array(
			'label'               => __( 'events', 'wp-ec' ),
			'description'         => __( 'Loop Even Calander', 'wp-ec' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'revisions', 'custom-fields', 'tags'),
			'taxonomies'          => array( 'event-category', 'event-tag' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_in_menu'        => true,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => 'events','with_front' => false ),			
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest' 		  => true,
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'rest_base'             => 'events',
	  
		);		  
		register_post_type( 'events', $args );

		// Register Event Category
		register_taxonomy('event-category', 'events', array(
			'hierarchical' => true,
			'labels' => array(
				'name'              => esc_html__( 'Category', 'wp-ec' ),
				'singular_name'     => esc_html__( 'Category', 'wp-ec' ),
				'search_items'      => esc_html__( 'Search category', 'wp-ec' ),
				'all_items'         => esc_html__( 'All categories', 'wp-ec' ),
				'parent_item'       => esc_html__( 'Parent category', 'wp-ec' ),
				'parent_item_colon' => esc_html__( 'Parent category', 'wp-ec' ),
				'edit_item'         => esc_html__( 'Edit category', 'wp-ec' ),
				'update_item'       => esc_html__( 'Update category', 'wp-ec' ),
				'add_new_item'      => esc_html__( 'Add new category', 'wp-ec' ),
				'new_item_name'     => esc_html__( 'New category', 'wp-ec' ),
				'menu_name'         => esc_html__( 'Categories', 'wp-ec' ),
			),
			'rewrite' => array(
				'slug'         => 'event-category',
				'with_front'   => true,
				'hierarchical' => true
			),
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'show_admin_column' => true,
			'show_in_rest'          => true,
			'rest_controller_class' => 'WP_REST_Terms_Controller',
			'rest_base'             => 'event_category',
		));		

	// Register Event Tags
		register_taxonomy('event-tag', 'events', array(
			'hierarchical' => false,
			'labels' => array(
				'name'              => esc_html__( 'Event tags', 'wp-ec' ),
				'singular_name'     => esc_html__( 'Event tag', 'wp-ec' ),
				'search_items'      => esc_html__( 'Search Event tags', 'wp-ec' ),
				'all_items'         => esc_html__( 'All Event tags', 'wp-ec' ),
				'parent_item'       => esc_html__( 'Parent Event tags', 'wp-ec' ),
				'parent_item_colon' => esc_html__( 'Parent Event tag:', 'wp-ec' ),
				'edit_item'         => esc_html__( 'Edit Event tag', 'wp-ec' ),
				'update_item'       => esc_html__( 'Update Event tag', 'wp-ec' ),
				'add_new_item'      => esc_html__( 'Add new Event tag', 'wp-ec' ),
				'new_item_name'     => esc_html__( 'New Event tag', 'wp-ec' ),
				'menu_name'         => esc_html__( 'Tags', 'wp-ec' ),
			),
			'rewrite'          => array(
				'slug'         => 'event-tag',
				'with_front'   => true,
				'hierarchical' => false
			),
			'show_in_rest'          => true,
			'rest_controller_class' => 'WP_REST_Terms_Controller',
			'rest_base'             => 'event_tag',
		));
		
		
}

add_action( 'init', 'wp_ec_custom_post_type', 0 );


// Extending WordPress Rest API to include tags and category for default route
function wp_ec_register_rest_fields(){
 
    register_rest_field('events',
        'event_category_attr',
        array(
            'get_callback'    => 'wp_ec_event_categories',
            'update_callback' => null,
            'schema'          => null
        )
    );
 
    register_rest_field('events',
        'event_tag_attr',
        array(
            'get_callback'    => 'wp_ec_event_tags',
            'update_callback' => null,
            'schema'          => null
        )
    );

}
add_action('rest_api_init','wp_ec_register_rest_fields');



// Callbacks for categories
function wp_ec_event_categories($object,$field_name,$request){
    $terms_result = array();
    $terms =  wp_get_post_terms( $object['id'], 'event-category');
    foreach ($terms as $term) {
        $terms_result[$term->term_id] = array($term->name,get_term_link($term->term_id));
    }
    return $terms_result;
}

// Callback for the tags
function wp_ec_event_tags($object,$field_name,$request){
    $terms_result = array();
    $terms =  wp_get_post_terms( $object['id'], 'event-tag');
    
    foreach ($terms as $term) {
        $terms_result[$term->term_id] = array($term->name,get_term_link($term->term_id));
    }
    return $terms_result;
}

