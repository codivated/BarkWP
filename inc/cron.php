<?php
/**
 * Handle crons for Bark.
 *
 * @package bark
 */

if ( ! wp_get_schedule( 'schedule_bark_process' ) ) {
	add_action( 'init', 'schedule_bark_process', 10 );
}

function schedule_bark_process() {
	wp_schedule_event( time(), '5min', 'bark_process_queue', $args );
}

function bark_process_queue() {
	Bark_Queue_Manager::get_instance()->run();
}

function bark_cron_schedules( $schedules ) {
	if ( ! isset( $schedules['5min'] ) ) {
		$schedules['5min'] = array(
			'interval' => (5*60),
			'display'  => __( 'Once every 5 minutes', 'bark' ),
		);
	}

	return $schedules;
}
add_filter( 'cron_schedules', 'bark_cron_schedules' );
