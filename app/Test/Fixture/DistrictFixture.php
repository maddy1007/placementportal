<?php
/**
 * DistrictFixture
 *
 */
class DistrictFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'Districts';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'Id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'StateId' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'DistrictName' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8_bin', 'charset' => 'utf8'),
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
			'StateId' => 1,
			'DistrictName' => 'Lorem ipsum dolor sit amet',
			'Created' => '2015-07-06 12:00:37',
			'Modified' => '2015-07-06 12:00:37'
		),
	);

}
