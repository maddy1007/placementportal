<?php
/**
 * CourseFixture
 *
 */
class CourseFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'Courses';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'Id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'SectorId' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'CourseName' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'Created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'Modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'Id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_bin', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'Id' => 1,
			'SectorId' => 1,
			'CourseName' => 'Lorem ipsum dolor sit amet',
			'Created' => '2015-07-06 11:56:22',
			'Modified' => '2015-07-06 11:56:22'
		),
	);

}
