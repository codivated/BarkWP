<?php
/**
 * Unit tests for Bark class.
 *
 * @package Bark
 */

class BarkClassTest extends BarkTestCase {
	public function setUp() {
		parent::setUp();
		$this->addDefaultLevels();
	}

	// todo: acceptance test for all default levels working

	/**
	 * @test
	 * @group Bark::assign_level_to_bark
	 */
	public function assignLevelCorrectlySucceedsWhenExistingSlugAndBarkIdArePassed() {
		$bark = $this->createBark();
		$assignLevel = $this->bark->assign_level_to_bark( 'error', $bark );

		$this->assertNotFalse( $assignLevel );
		$this->assertNotTrue( is_wp_error( $assignLevel ) );

		$term = get_term( $assignLevel[0] );
		$this->assertEquals( $term->slug, 'error' );
	}

	/**
	 * @test
	 * @group Bark::assign_level_to_bark
	 */
	public function assignLevelReturnsErrorIfRequestedLevelDoesntExist() {
		$bark = $this->createBark();
		$assignLevel = $this->bark->assign_level_to_bark( 'doesntExist', $bark );

		$this->assertFalse( $assignLevel );
	}
}
