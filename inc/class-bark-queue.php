<?php

class Bark_Queue extends WP_Background_Process {
	protected $action = 'bark';

	protected function task( $bark ) {
		$logger = new Bark_Logger();
		$logger->log( $bark['message'], $bark['level'], $bark['context'] );
		return false;
	}

	protected function is_running() {
		if ( get_site_transient( $this->identifier . '_process_lock' ) ) {
			// Process already running.
			return true;
		}

		return false;
	}

	protected function complete() {
		parent::complete();
	}
}
