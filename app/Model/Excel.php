<?php
App::uses('AppModel', 'Model');
/**
 * Excel Model
 *
 */
class Excel extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'excels';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'id';

	
}
