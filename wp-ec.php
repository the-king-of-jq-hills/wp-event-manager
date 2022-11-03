<?php
/*
Plugin Name: WP Event Calander
Plugin URI: https://wp-demos/wp-ec
Description: Creates custom post type loop-events and meta boxes for the attributes
Version: 1.0.0
Author: marsian
Author URI: https://wp-demos.com
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html
Text Domain: wp-ec
Domain Path: /languages
*/

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


//Current Plugin Version 
define( 'WPEC_VERSION', '1.0.0' );

//Enque Admin script
function wp_ec_admin_scripts(){
    wp_enqueue_script('wp-ec-admin-script', plugin_dir_url( __FILE__ ).'/assets/wpec-admin.js', array('jquery'), WPEC_VERSION );
}
add_action( 'admin_enqueue_scripts', 'wp_ec_admin_scripts' );

//Enque Template Style
function wp_ec_events_style() {
    wp_enqueue_script('wp-ec-front-script', plugin_dir_url( __FILE__ ).'/assets/wpec-events.js', array('jquery'), WPEC_VERSION );
    wp_enqueue_style( 'wp-ec-front-style', plugin_dir_url( __FILE__ ).'/assets/wpec-events.css', array(), WPEC_VERSION ); 
}
add_action( 'wp_enqueue_scripts', 'wp_ec_events_style' );


/* Filter the single_template */
add_filter('single_template', 'wp_ec_custom_single_template');

function wp_ec_custom_single_template($single) {

    global $post;

    /* Checks for single template by post type */
    if ( $post->post_type == 'events' ) {
        if ( plugin_dir_path( __FILE__ ) . 'templates/single-event.php' ) {
            return plugin_dir_path( __FILE__ ) . 'templates/single-event.php';
        }
    }

    return $single;
}

/* Filter the archive_template function */
add_filter('archive_template', 'wp_ec_custom_archive_template');

function wp_ec_custom_archive_template($single) {

    global $post;

    /* Checks for single template by post type */
    if ( $post->post_type == 'events' ) {
        if ( plugin_dir_path( __FILE__ ) . 'templates/archive-events.php' ) {
            return plugin_dir_path( __FILE__ ) . 'templates/archive-events.php';
        }
    }

    return $single;
}


// Custom post type and taxonomy
require plugin_dir_path( __FILE__ ) . 'inc/custom-post-type.php';

// Adding The Meta Boxes
require plugin_dir_path( __FILE__ ) . 'inc/meta-boxes.php';

// Import JSON functions
require plugin_dir_path( __FILE__ ) . 'inc/import-event.php';

// Admin Options
require plugin_dir_path( __FILE__ ) . 'inc/options-panel.php';

//Load WO_CLI class if does not exist
if (!class_exists('WP_CLI')) {
	require plugin_dir_path( __FILE__ ) . 'inc/class-wp-cli.php';
}

// custom WordPress CLI Command
require plugin_dir_path( __FILE__ ) . 'inc/custom-wpcli-command.php';

//Custom REST API Route
require plugin_dir_path( __FILE__ ) . 'inc/event-custom-rest-route.php';

