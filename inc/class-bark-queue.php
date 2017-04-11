<?php

class Bark_Queue {
	private static $instance;

	public static function get_instance()
	{
		if (null === self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		$this->add_barks = new Add_Barks();
	}

	public function add( $bark ) {
		$this->add_barks->push_to_queue( $bark );
		$this->add_barks->save();
	}

	public function run() {
		$this->add_barks->dispatch();
	}
}
