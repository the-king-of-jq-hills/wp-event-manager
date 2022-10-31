<?php
/**
 * Template to display event
 *
 * @package i-design
 * @since wp-ec 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header(); 
global $post;
$post_meta = array();

//get Event Tags
$event_terms = get_the_terms($post->ID, 'event-tag');
$event_tags = wp_list_pluck($event_terms, 'name');
$event_tags = implode(', ', $event_tags);


?>

<div id="primary" class="content-area">
	<div id="content" class="site-content event-single" role="main">

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h3><?php esc_html_e('Event ID : ', 'wp-ec'); the_ID(); ?></h3>
            <h1 class="entry-title"><?php the_title(); ?></h1>

            <div class = "event-time-left"> <?php echo wp_ec_format_event_timestamp ( get_post_meta($post->ID, 'event_time', true)); ?> </div>

            <div class="entry-content"><?php the_content(); ?></div>

            <div class="event-meta">
                <span class="event-meta-key"><?php esc_html_e('Organizer : ', 'wp-ec'); ?></span>
                <span class="event-meta-value"><?php esc_html_e(get_post_meta($post->ID, 'organizer', true)); ?></span>
            </div>
            <div class="event-meta">
                <span class="event-meta-key"><?php esc_html_e('Tags : ', 'wp-ec'); ?></span>
                <span class="event-meta-value"><?php esc_html_e($event_tags); ?></span>
            </div>
            <div class="event-meta">
                <span class="event-meta-key"><?php esc_html_e('Email : ', 'wp-ec'); ?></span>
                <span class="event-meta-value"><?php esc_html_e(get_post_meta($post->ID, 'email', true)); ?></span>
            </div>
            <div class="event-meta">
                <span class="event-meta-key"><?php esc_html_e('Address : ', 'wp-ec'); ?></span>
                <span class="event-meta-value"><?php esc_html_e(get_post_meta($post->ID, 'address', true)); ?></span>
            </div>
            <div class="event-meta">
                <span class="event-meta-key"><?php esc_html_e('Latitude : ', 'wp-ec'); ?></span>
                <span class="event-meta-value"><?php esc_html_e(get_post_meta($post->ID, 'latitude', true)); ?></span>
            </div>
            <div class="event-meta">
                <span class="event-meta-key"><?php esc_html_e('Longitude : ', 'wp-ec'); ?></span>
                <span class="event-meta-value"><?php esc_html_e(get_post_meta($post->ID, 'longitude', true)); ?></span>
            </div>
            <div class="spacer-32 clr clear"></div>
        </article>

    </div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>    

<?php

function wp_ec_format_event_timestamp ( $tstamp )
{
    $date = strtotime( $tstamp );
    $timeleft = '';

    $diff = $date - time();
    $days=floor($diff/(60*60*24));
    $hours=round(($diff-$days*60*60*24)/(60*60));

    if( $days > 0 )
    {
        $timeleft = '<span class="green-text">' . esc_html($days) . esc_html__(' days and ', 'wp-ec') . esc_html($hours) . esc_html(' hours remaining.', 'wp-ec') . '</span>';
    } else {
        $timeleft = '<span class="red-text">' . esc_html__('Event is over by ', 'wp-ec') . esc_html($days) . esc_html(' days.', 'wp-ec') . '</span>';
    }    

    return $timeleft;
}