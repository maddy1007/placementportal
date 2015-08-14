<?php
App::uses('EducationLevel', 'Model');

/**
 * EducationLevel Test Case
 *
 */
class EducationLevelTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.education_level'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->EducationLevel = ClassRegistry::init('EducationLevel');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->EducationLevel);

		parent::tearDown();
	}

}
