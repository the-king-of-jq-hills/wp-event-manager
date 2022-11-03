/**
 * Functionality for WP Event Front-end
 */

 jQuery(document).ready(function ($) {
	'use strict';

    var EventTime = $('.countdown').data('timestamp');

    var seconds = EventTime;

    var nowTime = Math.floor(Date.now() / 1000);
    var timeToEvent = EventTime - nowTime;    

    function timer() {

        var days        = Math.floor(timeToEvent/24/60/60);
        var hoursLeft   = Math.floor((timeToEvent) - (days*86400));
        var hours       = Math.floor(hoursLeft/3600);
        var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
        var minutes     = Math.floor(minutesLeft/60);
        var remainingSeconds = timeToEvent % 60;
      
        //Add '0' before single digit
        function pad(n) {
            return (n < 10 ? "0" + n : n);
        }

        $('.countdown').html( "<span class='green-text'>" 
            + pad(days) + " Days : " 
            + pad(hours) + " Hours : " 
            + pad(minutes) + " Minutes : " 
            + pad(remainingSeconds) 
            + " Seconds </span>" 
        );
      
        if (timeToEvent <= 0 ) {
            clearInterval(countdownTimer);
            $('.countdown').html( "<span class='red-text'>Event Completed!</span>" );
        } else {
            timeToEvent--;
        }
    }
    var countdownTimer = setInterval( timer, 1000);

});