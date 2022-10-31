<?php

/**
 * Custom REST Rout
 *
 * @since    1.0.0
 */ 

 //Register REST route for the events
//url would be https://www.example.com/wp-json/wpevents/v1/events
function register_wpec_rest_route()
{
    register_rest_route('wpevents/v1', 'events', [
        'methods'  => 'GET',
        'callback' => 'wpec_event_list',
        'permission_callback' => '__return_true',
    ]);
}
add_action('rest_api_init', 'register_wpec_rest_route');


function wpec_event_list()
{

	$results = [];

    $events_query = new WP_Query([
        'post_type' => 'events',
    ]);

 
    // proceed to database query
    while ($events_query->have_posts()) {
        $events_query->the_post();

		$event_terms = get_the_terms(get_the_ID(), 'event-tag');
		$event_tags = wp_list_pluck($event_terms, 'name'); 
 
        array_push($results, [
			'ID'        => get_the_ID(),
            'title'     => get_the_title(),
            'about'     => get_the_content(),			
            'organizer' => get_post_meta(get_the_ID(), 'organizer', true),
            'timestamp' => get_post_meta(get_the_ID(), 'event_time', true),
            'email'     => get_post_meta(get_the_ID(), 'email', true),
            'address'   => get_post_meta(get_the_ID(), 'address', true),
            'latitude'  => get_post_meta(get_the_ID(), 'latitude', true),	
            'longitude' => get_post_meta(get_the_ID(), 'longitude', true),
			'tags'		=> $event_tags,

        ]);
    }
 
    wp_reset_postdata(); 
    return $results;
}
