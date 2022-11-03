<?php
/**
 * The template for displaying EventsArchive pages
 *
 * @since wp-ec 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$temp = $wp_query; 
$wp_query = null; 

$wp_query = new WP_Query([
	'post_type' 		=> 'events',
    'meta_key' 			=> 'event_time',
    'orderby' 			=> 'meta_value',
    'order' 			=> 'ASC',
	'posts_per_page'    => 10,
	'paged' 			=> $paged,
]);

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content event-archive" role="main">

		<?php if ( $wp_query->have_posts() ) : ?>
			<?php /* The loop */ ?>
			<?php while ($wp_query->have_posts()) :  $wp_query->the_post() ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
					<div role="Countdown Timer" class="countdown" data-timestamp="<?php echo strtotime( get_post_meta($post->ID, 'event_time', true) ); ?>">
						<?php esc_html_e('Event Countdown ..'); ?>
					</div>					
					<div class="entry-content"><?php the_content(); ?></div>
					<div class="event-item-meta">
						<span class="event-item-meta-fragment">
							<?php esc_html_e('Organizer : ', 'wp-ec');?>
							<strong><?php esc_html_e(get_post_meta($post->ID, 'organizer', true)); ?></strong>
						</span>
						<span class="event-item-meta-fragment">
							<?php esc_html_e('Time : ', 'wp-ec');?>
							<strong><?php echo date( 'l jS \of F Y h:i A', strtotime( get_post_meta($post->ID, 'event_time', true) ) ); ?></strong>
						</span>
					</div>
				</article>
			<?php endwhile; ?>
		
			<nav aria-label="Pagination">
				<ul class="event-archive-pagination">
					<li aria-label="Previus Page Link"><?php previous_posts_link( esc_html('&laquo; PREV'), $wp_query->max_num_pages) ?></li> 
					<li aria-label="Next Page Link"><?php next_posts_link( esc_html('NEXT &raquo;'), $wp_query->max_num_pages) ?></li>
				</ul>
			</nav>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>

		<?php 
			$wp_query = null; 
			$wp_query = $temp;  // Reset
		?>		
		

		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>