/**
 * Functionality for WP Event Calander
 */

 jQuery(document).ready(function ($) {
	'use strict';

    $('#import-events').on( 'click', function() {

        $('.event-spinner').css('display', 'block');

        $.post(ajaxurl, {'action': 'wpec_import_events_json'}, function(response) {
            $('.event-spinner').css('display', 'none');
            $('div.import-status').html("Import Status : " + response );

        });
    });


});