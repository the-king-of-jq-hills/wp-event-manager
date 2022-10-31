<?php

/**
 * Functions for the metaboxes
 *
 * @since    1.0.0
 */ 

 // Adding Metabox Organizer
function event_organizer_meta_box() {

	add_meta_box(
		'organizer',
		__( 'Organizer', 'wp-ec' ),
		'organizer_meta_box_callback',
		'events'
	);
}
	
add_action( 'add_meta_boxes', 'event_organizer_meta_box' );

// Adding the text field in editor screen for organizer
// WITHOUT THE SAVE FUNCTION
function organizer_meta_box_callback( $post ) {

	wp_nonce_field( 'organizer_nonce', 'organizer_nonce' );	
    $value = get_post_meta( $post->ID, 'organizer', true );	
	echo '<input type="text" style="width:100%" id="organizer" name="organizer" value="' . esc_attr( $value ) . '" />';

}

function save_organizer_meta_box_data( $post_id ) {

    // Check if our nonce is set.
    if ( ! isset( $_POST['organizer_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['organizer_nonce'], 'organizer_nonce' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Make sure that it is set.
    if ( ! isset( $_POST['organizer'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['organizer'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, 'organizer', $my_data );
}

add_action( 'save_post', 'save_organizer_meta_box_data' );


// Adding Metabox email
function event_email_meta_box() {

	add_meta_box(
		'email',
		__( 'Email', 'wp-ec' ),
		'email_meta_box_callback',
		'events'
	);
}
		
add_action( 'add_meta_boxes', 'event_email_meta_box' );
	
// Adding the text field in editor screen for email
// WITHOUT THE SAVE FUNCTION
function email_meta_box_callback( $post ) {
	
	wp_nonce_field( 'email_nonce', 'email_nonce' );	
	$value = get_post_meta( $post->ID, 'email', true );	
	echo '<input type="text" style="width:100%" id="email" name="email" value="' . esc_attr( $value ) . '" />';
	
}

function save_email_meta_box_data( $post_id ) {

    // Check if our nonce is set.
    if ( ! isset( $_POST['email_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['email_nonce'], 'email_nonce' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Make sure that it is set.
    if ( ! isset( $_POST['email'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data = sanitize_email( $_POST['email'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, 'email', $my_data );
}

add_action( 'save_post', 'save_email_meta_box_data' );


// Adding Metabox Address
function event_address_meta_box() {

	add_meta_box(
		'address',
		__( 'Address', 'wp-ec' ),
		'address_meta_box_callback',
		'events'
	);
}
	
add_action( 'add_meta_boxes', 'event_address_meta_box' );


// Adding the text field in editor screen for address
// WITHOUT THE SAVE FUNCTION
function address_meta_box_callback( $post ) {

	wp_nonce_field( 'address_nonce', 'address_nonce' );	
	$value = get_post_meta( $post->ID, 'address', true );	
	echo '<input type="text" style="width:100%" id="address" name="address" value="' . esc_attr( $value ) . '" />';

}


// Adding Metabox Latitude
function event_latitude_meta_box() {

	add_meta_box(
		'latitude',
		__( 'Latitude', 'wp-ec' ),
		'latitude_meta_box_callback',
		'events'
	);
}
	
add_action( 'add_meta_boxes', 'event_latitude_meta_box' );

// Adding the text field in editor screen for latitude
// WITHOUT THE SAVE FUNCTION
function latitude_meta_box_callback( $post ) {

	wp_nonce_field( 'latitude_nonce', 'latitude_nonce' );	
	$value = get_post_meta( $post->ID, 'latitude', true );	
	echo '<input type="text" style="width:100%" id="latitude" name="latitude" value="' . esc_attr( $value ) . '" />';

}


// Adding Metabox Longitude
function event_longitude_meta_box() {

	add_meta_box(
		'longitude',
		__( 'Longitude', 'wp-ec' ),
		'longitude_meta_box_callback',
		'events'
	);
}
	
add_action( 'add_meta_boxes', 'event_longitude_meta_box' );

// Adding the text field in editor screen for longitude
// WITHOUT THE SAVE FUNCTION
function longitude_meta_box_callback( $post ) {

	wp_nonce_field( 'longitude_nonce', 'longitude_nonce' );	
	$value = get_post_meta( $post->ID, 'longitude', true );	
	echo '<input type="text" style="width:100%" id="longitude" name="longitude" value="' . esc_attr( $value ) . '" />';

}

// Adding Metabox Event Time
function event_time_meta_box() {

	add_meta_box(
		'event_time',
		__( 'Event Time', 'wp-ec' ),
		'event_time_meta_box_callback',
		'events'
	);
}
	
add_action( 'add_meta_boxes', 'event_time_meta_box' );

// Adding the text field in editor screen for event_time
function event_time_meta_box_callback( $post ) {

	wp_nonce_field( 'event_time_nonce', 'event_time_nonce' );	
	$value = get_post_meta( $post->ID, 'event_time', true );	
	echo '<input type="text" style="width:100%" id="event_time" name="event_time" value="' . esc_attr( $value ) . '" />';

}

function save_event_time_meta_box_data( $post_id ) {

    // Check if our nonce is set.
    if ( ! isset( $_POST['event_time_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['event_time_nonce'], 'event_time_nonce' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Make sure that it is set.
    if ( ! isset( $_POST['event_time'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['event_time'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, 'event_time', $my_data );
}

add_action( 'save_post', 'save_event_time_meta_box_data' );


// Register The Meta Fields For REST API
//, address, latitude, longitude, event_time

add_action( 'rest_api_init', 'register_event_meta_fields');
function register_event_meta_fields(){

    register_meta( 'post', 'organizer', array(
        'type' => 'string',
        'description' => 'organizer name',
        'single' => true,
        'show_in_rest' => true
    ));

    register_meta( 'post', 'email', array(
        'type' => 'string',
        'description' => 'event email',
        'single' => true,
        'show_in_rest' => true
    ));
    
    register_meta( 'post', 'address', array(
        'type' => 'string',
        'description' => 'event address',
        'single' => true,
        'show_in_rest' => true
    ));
    
    register_meta( 'post', 'latitude', array(
        'type' => 'string',
        'description' => 'event latitude',
        'single' => true,
        'show_in_rest' => true
    ));
    
    register_meta( 'post', 'longitude', array(
        'type' => 'string',
        'description' => 'event longitude',
        'single' => true,
        'show_in_rest' => true
    ));
    
    register_meta( 'post', 'event_time', array(
        'type' => 'string',
        'description' => 'event timastamp',
        'single' => true,
        'show_in_rest' => true
    ));    

}