<?php
/**
 * Bark Queue background process class.
 *
 * @package bark
 */

class Bark_Queue extends WP_Background_Process {
	protected $action = 'bark';

	protected function task( $bark ) {
		$logger = new Bark_Logger();
		$logger->log( $bark['message'], $bark['level'], $bark['context'] );
		return false;
	}

	protected function complete() {
		parent::complete();
	}
}
