<?php

/**
 * Function to import JSON data
 *
 * @since    1.0.0
 */ 

function event_import_panel(){
    add_submenu_page( 'edit.php?post_type=events', 'Import Events', 'Import Events', 'manage_options', 'import-events', 'wp_ec_import_jason', 7 );
}
add_action('admin_menu', 'event_import_panel');

function wp_ec_import_jason(){

    // General check for user permissions.
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have permission to access this page.', 'wp-ec')    );
    }

    $import_function = plugin_dir_path( __FILE__ ) . 'inc/import-event.php'
    ?>
        <div class="wrapp">
            <h1><?php esc_html_e( 'Events Import', 'wp-ec' ) ?></h1>
            <p>&nbsp;</p>
            <div class="import-status">&nbsp;</div>
            <p>&nbsp;</p>
            <button id="import-events" name="importevents" type="submit" class="button button-primary button-hero import-events-button">
                <?php esc_html_e( 'Import Events', 'wp-ec' ) ?>
            </button>
        </div>
    <?php

    return;
}


