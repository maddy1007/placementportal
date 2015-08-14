<?php
App::uses('AppModel', 'Model');
/**
 * District Model
 *
 */
class SdmsData extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'sdms_data';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'id';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'candidate_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'account_name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
		),
		'candidate_name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
		),
		'gender' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
		),
		'contact_no' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
		),
		'dob' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
		),
		'candidate_state_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
		),
		'candidate_district_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
		),
		'centre_state_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
		),
		'centre_district_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
		),
		'education_level' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
		)
	);
	public $hasOne = array(
			'CandidateState' => array(
				'className' => 'State',
				'foreignKey' => false,
				'dependent' => false,
				'conditions' => array('SdmsData.candidate_state_id=CandidateState.id'),
				'fields' => 'state_name',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			),
			'CandidateDistrict' => array(
				'className' => 'District',
				'foreignKey' => false,
				'dependent' => false,
				'conditions' => array('SdmsData.candidate_district_id=CandidateDistrict.id'),
				'fields' => 'district_name'
			),
			'CentreState' => array(
				'className' => 'State',
				'foreignKey' => false,
				'dependent' => false,
				'conditions' => 'SdmsData.centre_state_id=CentreState.id',
				'fields' => 'state_name'
			),
			'CentreDistrict' => array(
				'className' => 'District',
				'foreignKey' => false,
				'dependent' => false,
				'conditions' => array('SdmsData.centre_district_id=CentreDistrict.id'),
				'fields' => 'district_name'
			),
			'EducationLevel' => array(
				'className' => 'EducationLevel',
				'foreignKey' => false,
				'dependent' => false,
				'conditions' =>  array('SdmsData.education_level=EducationLevel.id'),
				'fields' => 'education_level_name'
			),
			'Sector' => array(
				'className' => 'Sector',
				'foreignKey' => false,
				'dependent' => false,
				'conditions' =>  array('SdmsData.sector_id=Sector.id'),
				'fields' => 'sector_name'
			), 
			'Skill1' => array(
				'className' => 'Skill',
				'foreignKey' => false,
				'dependent' => false,
				'conditions' =>  array('SdmsData.skill_flag1=Skill1.id'),
				'fields' => 'skill_name'
			),
			'Skill2' => array(
				'className' => 'Skill',
				'foreignKey' => false,
				'dependent' => false,
				'conditions' =>  array('SdmsData.skill_flag2=Skill2.id'),
				'fields' => 'skill_name'
			),
			'Skill3' => array(
				'className' => 'Skill',
				'foreignKey' => false,
				'dependent' => false,
				'conditions' =>  array('SdmsData.skill_flag3=Skill3.id'),
				'fields' => 'skill_name'
			)


		);

}
