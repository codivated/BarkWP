<?php
/**
 * Misc functions for Bark.
 *
 * @package bark
 */

function bark_get_barks( $args ) {
	$args = wp_parse_args( $args, array(
		'posts_per_page' => 10,
	) );
	$args['post_type'] = 'cdv8_bark';

	$bark_query = new WP_Query( $args );
	return $bark_query->posts;
}

function bark_get_total() {
	$count = wp_count_posts( 'cdv8_bark' );
	return $count->publish;
}
