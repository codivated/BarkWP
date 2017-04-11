<?php
/**
 * Handle crons for Bark.
 *
 * @package bark
 */

if ( ! wp_next_scheduled( 'bark_process_queue' ) ) {
	wp_schedule_event( time(), '5min', 'bark_process_queue' );
}

function bark_process_queue() {
	Bark_Queue_Manager::get_instance()->run();
}
add_action( 'bark_process_queue', 'bark_process_queue', 10 );

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
