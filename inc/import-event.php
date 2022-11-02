<?php

/**
 * Function to import JSON data
 *
 * @since    1.0.0
 */ 

if ( !class_exists('wpecImportEvents') ) :
    class wpecImportEvents {

        public $events_created;
        public $events_updated;
        public $event_status;
        public $cli_response;

        public function __construct() {
            $this->events_created = 0;
            $this->events_updated = 0;
            $this->event_status = -1;
            $this->cli_response = 0;
        }        
       
        function wpec_create_new_event( $event ) {

            $event_status = -1;
            $post_type = 'events';
            
            // if called from admin option Panel via AJAX
            if( $this->cli_response != 2 )
            {
                //check permission
                if (!current_user_can('publish_posts')) {
                    // return -1 if no permission
                    return $event_status;
                }
            
                // check author id
                $author_id = get_current_user_id();
                if (!$author_id) {
                    return $event_status;
                }
            }
        
            // Sanitize the contents/event attributes
            $event_id = sanitize_key($event->id);
           
            $event_title = $this->wpec_sanitize_text_field($event->title); 
        
            if ( isset( $event->about ) ) {
                $event_about = sanitize_textarea_field($event->about); 
            } else {
                $event_about = '';
            }
            
            $event_organizer = $this->wpec_sanitize_text_field($event->organizer); 
            
            if ( isset( $event->email ) ) {
                $event_email = sanitize_email($event->email);  
            } else {
                $event_email = '';
            }
            
            $event_address = $this->wpec_sanitize_text_field($event->address); 
            $event_latitude = $this->wpec_sanitize_text_field($event->latitude); 
            $event_longitude = $this->wpec_sanitize_text_field($event->longitude); 
            $event_time = $this->wpec_sanitize_text_field($event->timestamp); 
         
            if ( isset( $event->tags ) && is_array( $event->tags ) ) {
                $event_tags = $this->wpec_sanitize_array( $event->tags ); 
            } else {
                $event_tags = array();
            } 
        
            $slug = sanitize_title_with_dashes($event_title);
        
         
            // Check the event doesn't already exist by ID
            if ( null == get_post($event_id) ) {
            
                // Set the post ID so that we know the post was created successfully
                $event_status = wp_insert_post(
                    array(
                        'import_id'=> $event_id,
                        'post_name' => $slug,
                        'post_title' => $event_title,
                        'post_content' => $event_about,
                        'post_type' => 'events',
                        'meta_input' => array(
                            'organizer' => $event_organizer,
                            'email' => $event_email,
                            'address' => $event_address,
                            'latitude' => $event_latitude,
                            'longitude' => $event_longitude,
                            'event_time' => $event_time,
                        ),
                        'tags_input' => $event_tags,                                     
                        'comment_status' => 'closed',
                        'ping_status' => 'closed',
                        'post_status' => 'publish',
                    )
                );
                // inserting/setting event term tags with correct taxonomy
                wp_set_object_terms( $event_id, $event_tags, 'event-tag', true);
                $this->events_created++;
        
            } else {
                // Update The Event
                $event_status = wp_update_post(
                    array(
                        'ID' => $event_id,
                        'post_name' => $slug,
                        'post_title' => $event_title,
                        'post_content' => $event_about,
                        'post_type' => 'events',
                        'meta_input' => array(
                            'organizer' => $event_organizer,
                            'email' => $event_email,
                            'address' => $event_address,
                            'latitude' => $event_latitude,
                            'longitude' => $event_longitude,
                            'event_time' => $event_time,
                        ),
                        'tags_input' => $event_tags,                                     
                        'comment_status' => 'closed',
                        'ping_status' => 'closed',
                        'post_status' => 'publish',                                 
                    )
                );
                // inserting/setting event term tags with correct taxonomy
                wp_set_object_terms( $event_id, $event_tags, 'event-tag', true);
                $this->events_updated++;

            }
            
            /*
            if( $this->cli_response != 2 )
            {
                // AJAX Response
                echo $event_status;
            }
            */ 
            
        } 

        //Fetch the JSON data
        function wpec_get_event_data( $cli_response ) {
            
            $this->cli_response = $cli_response;

            //JSON URL
            $events_file_url = plugin_dir_url( __FILE__ ) . 'events.json';
            
            //retrieve and parse JSON data
            $response = wp_remote_get( $events_file_url );
        
            // Exit if error.
            if ( is_wp_error( $response ) ) {
                return;
            }
        
            // Get the body.
            $events = json_decode( wp_remote_retrieve_body( $response ) );
        
            // Exit if nothing is returned.
            if ( empty( $events ) ) {
                return;
            }
        
            // If there are events
            if ( ! empty( $events ) ) {
        
                foreach ( $events as $event ) {
                    $this->wpec_create_new_event( $event );
                }
              
            }
            if( $this->cli_response == 2 ) //CLI Response
            {
                $this->cli_response = esc_html__('Event Created : ', 'wp-ec') . esc_html($this->events_created) . '  ';
                $this->cli_response .= esc_html__('Event Updated : ', 'wp-ec') . esc_html($this->events_updated);

                //mail import report
                $this->wpec_mail_import_report();                

                return $this->cli_response;

            } else { //AJAX Response
                echo '<h3>' .  esc_html__('Event Created : ', 'wp-ec') . esc_html($this->events_created) .'</h3>';
                echo '<h3>' .  esc_html__('Event Updated : ', 'wp-ec') . esc_html($this->events_updated) . '</h3>';
            }
        }        

        // Sanitize Array
        function wpec_sanitize_array( $field ) {

            if ( is_array( $field ) ) {
                $value = array_map( 'sanitize_text_field', $field );
            } elseif ( !empty( $field ) ) {
                $value = sanitize_text_field( $field );
            } else {
                $value = array();
            }
        
            return $value;
        } 
        
        // Sanitize string
        function wpec_sanitize_text_field( $field ) {

            if ( isset( $field ) ) {
                $value = sanitize_text_field( $field ); 
            } else {
                $value = '';
            } 
        
            return $value;
        }

        // report mailer
        function wpec_mail_import_report() {
            
            $message = esc_html__('Event Created : ', 'wp-ec') . esc_html($this->events_created);
            $message .= esc_html__('Event Updated : ', 'wp-ec') . esc_html($this->events_updated);

            $to = sanitize_email('logging@agentur-loop.com');
            $from = sanitize_email('report@agentur-loop.com');
            $subject = esc_html('Event Import Report');
            $headers = array('Content-Type: text/html; charset=UTF-8');

            $sent = wp_mail($to, $subject, strip_tags($message), $headers);

            if ($sent) {
                $this->cli_response .= '  Confirmation mail sent';
            } else
            {
                $this->cli_response .= '  Confirmation mail NOT sent';
            }

        }

    } //wpecImportEvents
endif; 

//import_events_json AJAX call response
add_action( 'wp_ajax_wpec_import_events_json', 'wpec_import_events_json' );

function wpec_import_events_json() {

    $ajax_response = 1;
    $import_events = new wpecImportEvents();
    $import_events->wpec_get_event_data($ajax_response);

    // Respond to AJAX and die
	wp_die(); 
}
