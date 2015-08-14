<?php
App::uses('AppController', 'Controller');
require_once APP.'/../vendor/autoload.php'; // load composer
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

/**
 * SdmsData Controller
 *
 * @property SdmsData $SdmsData
 * @property PaginatorComponent $Paginator
 */
class SdmsDataController extends AppController {

/**
 * Models
 *
 * @var array
 */
	public $uses = array('SdmsData','State','Excel','EducationLevel','District','Sector','Skill');
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','AdminFunction','Common');

	
	function beforeFilter() {
		parent::beforeFilter();
		$this->set('gender',array('M'=>'Male','F'=>'Female'));
		$this->apiUrl = Configure::read('api_key');
	}

	public function index(){
		$link =  $this->apiUrl."sdms_data.json";
		$httpSocket = new HttpSocket();
		$response = $httpSocket->get($link,$this->request->params);
		//pr($response); die;
		$response = json_decode($response,true);
		$sdmsDatas = $response['SdmsData'];
		$this->params['paging'] = $response['params']['params']['paging'];
		$this->set(compact('sdmsDatas'));	
	}	

	public function view($id = null) {
		$link =  $this->apiUrl."sdms_data/view/".$id.".json";
		$httpSocket = new HttpSocket();
		$response = $httpSocket->get($link);
		//pr($response); die;
		$response = json_decode($response,true);
		$sdmsData = $response['SdmsData'];
		$this->set(compact('sdmsData'));	
	}
/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->set('states',$this->Common->getStateList());
		$this->set('educationLevels',$this->Common->getEducationLevelList());
		$this->set('sectors',$this->Common->getSectorList());
		if ($this->request->is('post')) {
		      $link =  $this->apiUrl."sdms_data/add.json";
         	      $data = $this->request->data;
		      $httpSocket = new HttpSocket();
		      $response = $httpSocket->post($link, $data );
		      $response = json_decode($response,true);
		      $this->Session->setFlash(__($response['message']['status']));
		      return $this->redirect(array('action' => 'index'));
		}
	}


/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		
		if ($this->request->is(array('post', 'put'))) {
			$link =  $this->apiUrl."sdms_data/add.json"; 
             	     	$data = $this->request->data;
		      	$httpSocket = new HttpSocket();
		      	$response = $httpSocket->post($link, $data);
		      	$response = json_decode($response,true);	
			//pr($response); die;
			$this->Session->setFlash(__($response['message']['status']));
			return $this->redirect(array('action' => 'index'));
		} else {
			$link =  $this->apiUrl."sdms_data/view/".$id.".json";
			$httpSocket = new HttpSocket();
			$response = $httpSocket->get($link);
			$response = json_decode($response,true);
			$this->set('states',$this->Common->getStateList());
			$this->set('educationLevels',$this->Common->getEducationLevelList());
			$this->set('candidateDistrict',$this->Common->getDistrictList($response['SdmsData']['SdmsData']['candidate_state_id']));
			$this->set('centreDistrict',$this->Common->getDistrictList($response['SdmsData']['SdmsData']['centre_state_id']));
			$this->set('sectors',$this->Common->getSectorList());
			$this->request->data = $response['SdmsData'];
		}
	}

	public function uploadExcel($id = null) {
	    if ($this->request->is(array('post', 'put'))) {
		if (!empty($this->request->data['SdmsData']['UploadExcel']['name'])) {
			$name = $this->request->data['SdmsData']['UploadExcel']['name'];
			$name_arr = explode('.',$name);
			$ext = end($name_arr);
			if($ext=='csv' && $this->request->data['SdmsData']['UploadExcel']['type']=='text/csv'){			
				$filePath = $this->request->data['SdmsData']['UploadExcel']['tmp_name'];
				$fileName = date('Ymdhis').$this->request->data['SdmsData']['UploadExcel']['name'];
				$path = 'uploads/sdms/input/';		
				$fileName = str_replace(' ','_',$fileName);
				$destination = WWW_ROOT.$path.$fileName;				
				move_uploaded_file($filePath,$destination);
				$config = new LexerConfig();
				$lexer = new Lexer($config);
				$data = [];
				$header = [];
				$i = 1;
				$interpreter = new Interpreter();
				$interpreter->addObserver(function(array $row) use (&$data, &$i, &$header) {
				   if($i===1){
					$header[] = preg_replace("/[^a-zA-Z 0-9]+/", "", $row);
				    }
				    else { 
					    $data[] = array(
						'candidate_id' => $row[0],
						'certified' => $row[1],
						'account_name' => $row[2],
						'candidate_name' => $row[3],
						'gender' => $row[4],
						'dob' => $row[5],
						'exp_year' => $row[6],
						'exp_month' => $row[7],
						'contact_no' => $row[8],
						'education_level' => $row[9],
						'candidate_state_id' => $row[10],
						'candidate_district_id' => $row[11],
						'sector_id' => $row[12],
						'skill_flag1' => $row[13],
						'skill_flag2' => $row[14],
						'skill_flag3' => $row[15],
						'nsqf_level' => $row[16],
						'centre_state_id' => $row[17],
						'centre_district_id' => $row[18],
						'dummy_field1' => $row[19],
						'dummy_field2' => $row[20],
						'msg' => ''
					    );
				   }
				   $i++;
				});	
				
				$lexer->parse($destination, $interpreter);	
				$countAll = count($data);
				$this->Excel->save(
					array( 
						'Excel' => 
						     array(
							'excel_name' => $name,
							'created' => date('Y-m-d h:i:s'),
							'csv_path' => $path.$fileName,
							'total_rows' => $countAll,
							'created_by' => 'Administrator',
							'type' => 'SDMS Data'
						     )
					)
				);
				$excelId = $this->Excel->getLastInsertId();
				$new_data = array();
				$valid_data = array();
				foreach($data as $k=>$val){
					if(!empty($val)){
						$res = $this->checkSdmsValidations($val);
						if($res[0]==0){
							$val['msg'] = $res[1];
							$new_data[] = $val;
						} else {
							$new_data[] = $val;
							$res[2]['excel_id'] = $excelId;
							$valid_data[] = $res[2];	
						}					
					}
				}
				//pr($new_data); die;
				$header[0][] = 'Message';
				$c = 0;
				$countEmpty = count($data)-count($new_data);
				$countValid = count($valid_data); 
				foreach($valid_data as $k=>$val){
					$this->SdmsData->create();
					$arr = array('SdmsData' => $val);
					if($this->SdmsData->save($arr)){
						$c++;
					}
				}
				$countRejected = $countAll - $c -$countEmpty;
				$path = WWW_ROOT.'uploads/sdms/output/';		
	
				$error_path = $this->AdminFunction->convert_to_csv($new_data,$header[0],$fileName,',',$path);
				$this->Excel->updateAll(
					array(
						'total_upload' => $c,
						'total_rejected' => $countRejected,
						'total_empty' => $countEmpty,
						'error_csv_path' => '"'.$error_path.'"'
					     ),
					array('id'=> $excelId)
				
				);
				$this->Session->setFlash('Data Import Successfull.');
				$this->redirect('/excels/upload_results/'.base64_encode($excelId));
			}
			else {
				$this->Session->setFlash('Invalid File Format. Upload only CSV file.');
			}
		} else {
			$this->Session->setFlash('No file found. Please upload CSV file.');
		}
	    }
	}


	
	

	function downloadFile($id){
		$id = base64_decode($id);
		$res = $this->Excel->read(null,$id);
		$file = $res['Excel']['error_csv_path'];
		$this->AdminFunction->downloadFile($file);
		exit;
	}

	function checkSdmsValidations($data){
		$flag = 1;
		$msg='';
		$yesNo = array('Y','N');
		$gender = array('M','F');
		$mandatory = array('candidate_id'=>'Candidate Id', 'account_name'=>'Account Name/Name of Training Partner', 'candidate_name' => 'Candidate Name', 'gender' => 'Gender', 'dob' => 'Date of Birth', 'contact_no' => 'Contact Number', 'education_level' => 'Education Level', 'candidate_state_id' => 'Candidate State', 'candidate_district_id' => 'Candidate District', 'sector_id' => 'Sector', 'skill_flag1' => 'Skill Flag 1', 'centre_state_id' => 'Centre State', 'centre_district_id' => 'Centre District');
		$numeric = array('exp_year' => 'Experience Years', 'exp_month' => 'Experience Month', 'contact_no' => 'Contact Number', 'nsqf_level' => 'NSQF Level', 'dummy_field1' => 'Dummy Field 1','dummy_field2' => 'Dummy Field 2');
		foreach($data as $key=>$val){
			if(array_key_exists($key,$mandatory) && empty($val)){
				$msg = 'Mandatory Data Missing: '.$mandatory[$key];
				$flag = 0;
				return array($flag,$msg,$data);
			}  else if(array_key_exists($key,$numeric) && !preg_match("/^[0-9]*$/",$val)){
				$key = Inflector::humanize($key);
				$msg = 'Only Numeric data allowed for '.$numeric[$key];
				$flag = 0;
				return array($flag,$msg,$data);
			}
		}
		/*if(empty($data['candidate_id'])){
			$msg = 'Mandatory Data Missing: Candidate Id';
			$flag = 0;
		} else if(empty($data['account_name'])){
			$msg = 'Mandatory Data Missing: Account Name/Name of Training Partner';
			$flag = 0;
		} else if(empty($data['candidate_name'])){
			$msg = 'Mandatory Data Missing: Candidate Name';
			$flag = 0;
		} else if(empty($data['gender'])){
			$msg = 'Mandatory Data Missing: Gender';
			$flag = 0;
		} else if(empty($data['dob'])){
			$msg = 'Mandatory Data Missing: Candidate Date of Birth';
			$flag = 0;
		} else if(empty($data['contact_no'])){
			$msg = 'Mandatory Data Missing: Contact No';
			$flag = 0;
		} else if(empty($data['education_level'])){
			$msg = 'Mandatory Data Missing: Education Level';
			$flag = 0;
		} else if(empty($data['candidate_state_id'])){
			$msg = 'Mandatory Data Missing: Candidate State';
			$flag = 0;
		} else if(empty($data['candidate_district_id'])){
			$msg = 'Mandatory Data Missing: Candidate District';
			$flag = 0;
		} else if(empty($data['sector_id'])){
			$msg = 'Mandatory Data Missing: Sector';
			$flag = 0;
		} else if(empty($data['skill_flag1'])){
			$msg = 'Mandatory Data Missing: Skill Flag 1';
			$flag = 0;
		} else if(empty($data['centre_state_id'])){
			$msg = 'Mandatory Data Missing: Centre State';
			$flag = 0;
		} else if(empty($data['centre_district_id'])){
			$msg = 'Mandatory Data Missing: Centre District';
			$flag = 0;
		} else if(!empty($data['exp_year']) && !preg_match("/^[0-9]*$/",$data['exp_year'])){
			$msg = 'Only Numeric data allowed for years';
			$flag = 0;
		} else if(!empty($data['exp_month']) && !preg_match("/^[0-9]*$/",$data['exp_month'])){
			$msg = 'Only Numeric data allowed for months';
			$flag = 0;
		}  else if(!preg_match("/^[0-9]*$/",$data['contact_no'])){
			$msg = 'Only Numeric data allowed for Contact Number';
			$flag = 0;
		} else if(!empty($data['nsqf_level']) && !preg_match("/^[0-9]*$/",$data['nsqf_level'])){
			$msg = 'Only Numeric data allowed for NSQF Level';
			$flag = 0;
		} else if(!empty($data['dummy_field1']) && !preg_match("/^[0-9]*$/",$data['dummy_field1'])){
			$msg = 'Only Numeric data allowed for Dummy Field 1';
			$flag = 0;
		} else if(!empty($data['dummy_field2']) && !preg_match("/^[0-9]*$/",$data['dummy_field2'])){
			$msg = 'Only Numeric data allowed for Dummy Field 2';
			$flag = 0;
		}*/ 
		if(!empty($data['certified']) && !in_array($data['certified'],$yesNo)){
			$msg = 'Invalid Value for Certified Column only Yes, No or Blank allowed.';
			$flag = 0;
		} else if(!in_array($data['gender'],$gender)){
			$msg = 'Invalid Value for Gender Column only M or F allowed.';
			$flag = 0;
		} else if(empty(strtotime($data['dob']))){
			$msg = 'Incorrect Date Format for Date of Birth';
			$flag = 0;
		} else if(strlen($data['contact_no'])>10 || strlen($data['contact_no'])<10){
			$msg = 'Contact Number Length Should be 10 digits.';
			$flag = 0;
		} else {
			
			$candidateIdCheck = $this->SdmsData->find('first',array(
							'conditions'=>array('candidate_id'=>$data['candidate_id'])
						));
			$eduLevelId       = $this->AdminFunction->getLevelId($data['education_level']);
			$canStateId       = $this->AdminFunction->getStateId($data['candidate_state_id']);
			$canDistrictId    = $this->AdminFunction->getDistrictId($data['candidate_district_id']);
			$centreStateId    = $this->AdminFunction->getStateId($data['centre_state_id']);
			$centreDistrictId = $this->AdminFunction->getDistrictId($data['centre_district_id']);
			$sectorId         = $this->AdminFunction->getSectorId($data['sector_id']);
			if(!empty($candidateIdCheck)){
				$msg = 'Duplicate Candidate ID';
				$flag = 0;
			} else if(empty($eduLevelId)){
				$msg = 'Education Level not found in Database.';
				$flag = 0;
			} else if(empty($canStateId)){
				$msg = 'Candidate State not found in Database.';
				$flag = 0;
			} else if(empty($canDistrictId['id'])){
				$msg = 'Candidate District not found in Database.';
				$flag = 0;
			} else if($canDistrictId['state_id'] != $canStateId){
				$msg = 'Candidate State and Candidate District mapping not found.';
				$flag = 0;
			} else if(empty($sectorId)){
				$msg = 'Sector not found in Database.';
				$flag = 0;
			} else if(empty($centreStateId)){
				$msg = 'Centre State not found in Database.';
				$flag = 0;
			} else if(empty($centreDistrictId['id'])){
				$msg = 'Centre District not found in Database.';
				$flag = 0;
			} else if($centreDistrictId['state_id'] != $centreStateId){
				$msg = 'Centre State and Centre District mapping not found.';
				$flag = 0;
			} else {
				$data['education_level'] = $eduLevelId;
				$data['candidate_state_id'] = $canStateId;
				$data['candidate_district_id'] = $canDistrictId['id'];
				$data['centre_state_id'] = $centreStateId;
				$data['centre_district_id'] = $centreDistrictId['id'];
				$data['sector_id'] = $sectorId;
				$data['dob'] = date('Y-m-d',strtotime($data['dob']));
				//$data['dob'] = strtotime($data['dob']);				
				if($data['exp_month']>11){
					$temp_year = floor($data['exp_month']/12);
					$data['exp_year'] += $temp_year;
					$data['exp_month'] = $data['exp_month'] - ($temp_year*12);
				}
				
				for($i=1;$i<4;$i++){
					$skill_chk = $this->Skill->find('first',array('conditions'=>array('sector_id'=>$sectorId,'skill_name'=>$data['skill_flag'.$i])));
					if(!empty($data['skill_flag'.$i]) && !empty($skill_chk)){
						$data['skill_flag'.$i] = $skill_chk['Skill']['id']; 
					} else if(!empty($data['skill_flag'.$i])) {
						$this->Skill->create();
						$this->Skill->save(
							array( 'Skill' => array(
								'sector_id' => $sectorId,
								'skill_name' => $data['skill_flag'.$i]
							))
						);
						$skill_id=$this->Skill->getLastInsertID();
						$data['skill_flag'.$i] = $skill_id;
					}
				}
				if($data['skill_flag1']==$data['skill_flag2'])
					$data['skill_flag2'] = '';
				if($data['skill_flag1']==$data['skill_flag3'])
					$data['skill_flag3'] = '';
				if($data['skill_flag2']==$data['skill_flag3'])
					$data['skill_flag3'] = '';

			}
		}
		
		return array($flag,$msg,$data);
	}

}
