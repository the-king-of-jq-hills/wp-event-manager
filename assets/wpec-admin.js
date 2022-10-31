/**
 * Functionality for WP Event Calander
 */

 jQuery(document).ready(function ($) {
	'use strict';


    $('#import-events').on( 'click', function() {

        $.post(ajaxurl, {'action': 'wpec_import_events_json'}, function(response) {

            $("div.import-status").append("Import Status : " + response );

        });
    });


});