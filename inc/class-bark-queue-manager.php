<?php
/**
 * Bark Queue Manager class file.
 *
 * @package bark
 */

/**
 * Manage the queues bark relies on to add entries to the database.
 */
class Bark_Queue_Manager {
	private static $instance;

	protected $queue;

	public static function get_instance()
	{
		if (null === self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		$this->queue = new Bark_Queue();
	}

	public function get_queue() {
		return $this->queue;
	}

	public function add( $bark ) {
		$this->queue->push_to_queue( $bark );
	}

	public function save() {
		$this->queue->save();
	}

	public function run() {
		$this->queue->dispatch();
	}
}
