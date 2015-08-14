<?php
App::uses('Sector', 'Model');

/**
 * Sector Test Case
 *
 */
class SectorTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sector',
		'app.course'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Sector = ClassRegistry::init('Sector');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Sector);

		parent::tearDown();
	}

}
