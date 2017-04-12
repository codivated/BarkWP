<?php
/**
 * Handle crons for Bark.
 *
 * @package bark
 */

function bark_schedule_dispatch_event() {
	if ( wp_next_scheduled( 'bark_dispatch_queue' ) ) {
		return;
	}

	wp_schedule_event( time(), '30sec', 'bark_dispatch_queue' );
}
add_action( 'init', 'bark_schedule_dispatch_event' );

function bark_dispatch_queue() {
	Bark_Queue_Manager::get_instance()->run();
}
add_action( 'bark_dispatch_queue', 'bark_dispatch_queue', 10 );

function bark_cron_schedules( $schedules ) {
	if ( ! isset( $schedules['30sec'] ) ) {
		$schedules['30sec'] = array(
			'interval' => 30,
			'display'  => __( 'Every 30s', 'bark' ),
		);
	}

	return $schedules;
}
add_filter( 'cron_schedules', 'bark_cron_schedules' );
