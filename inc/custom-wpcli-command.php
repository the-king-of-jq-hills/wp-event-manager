<?php
/**
 * Functions custom WP CLI command
 *
 * @since    1.0.0
 */ 


function wpec_import_events () {

    $response = 2;

    WP_CLI::line( 'Importing Data...' );
    try {

        $import_events = new wpecImportEvents();
        $response = $import_events->wpec_get_event_data($response);

    } catch ( \Throwable $e ) {
        WP_CLI::error( $e->getMessage() );
        throw $e;
    }

    WP_CLI::success( "Done!..!  " . $response );
}

//Creating custom CLI command
function process_cli_command () {
    WP_CLI::add_command( 'importevents', 'wpec_import_events' );
}
add_action( 'init', 'process_cli_command' );
