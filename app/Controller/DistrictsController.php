<?php
App::uses('AppController', 'Controller');
require_once APP.'/../vendor/autoload.php'; // load composer
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

/**
 * Districts Controller
 *
 * @property District $District
 * @property PaginatorComponent $Paginator
 */
class DistrictsController extends AppController {

/**
 * Models
 *
 * @var array
 */
	public $uses = array('District','State','Excel');
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','AdminFunction','Common');

	function beforeFilter() {
		parent::beforeFilter();
		$this->apiUrl = Configure::read('api_key');
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$link =  $this->apiUrl."districts.json";
		$httpSocket = new HttpSocket();
		$response = $httpSocket->get($link,$this->request->params);
		$response = json_decode($response,true);
		$districts = $response['District'];
		$this->params['paging'] = $response['params']['params']['paging'];
		$this->set(compact('districts'));		
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$link =  $this->apiUrl."districts/view/".$id.".json";
		$httpSocket = new HttpSocket();
		$response = $httpSocket->get($link);
		$response = json_decode($response,true);
		$district = $response['District'];
		$this->set(compact('district'));	
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->set('states',$this->Common->getStateList());
		if ($this->request->is('post')) {
		      $link =  $this->apiUrl."districts/add.json";
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
		$this->set('states',$this->Common->getStateList());
		if ($this->request->is(array('post', 'put'))) {
			$link =  $this->apiUrl."districts/add.json"; 
             	     	$data = $this->request->data;
		      	$httpSocket = new HttpSocket();
		      	$response = $httpSocket->post($link, $data);
		      	$response = json_decode($response,true);	
			//pr($response); die;
			$this->Session->setFlash(__($response['message']['status']));
			return $this->redirect(array('action' => 'index'));
		} else {
			$link =  $this->apiUrl."districts/view/".$id.".json";
			$httpSocket = new HttpSocket();
			$response = $httpSocket->get($link);
			$response = json_decode($response,true);
			$this->request->data = $response['District'];
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if(!empty($id)){
			$link =  $this->apiUrl."districts/delete/".$id.".json";
             	     	$data = $this->request->data;
		      	$httpSocket = new HttpSocket();
		      	$response = $httpSocket->delete($link);
		      	$response = json_decode($response,true);	
			$this->Session->setFlash(__($response['message']['status']));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * uploadExcel method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function uploadExcel($id = null) {
	    if ($this->request->is(array('post', 'put'))) {
		if (!empty($this->request->data['District']['UploadExcel']['name'])) {
			$name = $this->request->data['District']['UploadExcel']['name'];
			$name_arr = explode('.',$name);
			$ext = end($name_arr);
			if($ext=='csv' && $this->request->data['District']['UploadExcel']['type']=='text/csv'){			
				$filePath = $this->request->data['District']['UploadExcel']['tmp_name'];
				$fileName = date('Ymdhis').$this->request->data['District']['UploadExcel']['name'];
				$path = 'uploads/districts/input/';		
				$fileName = str_replace(' ','_',$fileName);
				$destination = WWW_ROOT.$path.$fileName;				
				move_uploaded_file($filePath,$destination);
				$config = new LexerConfig();
				$lexer = new Lexer($config);
				$data = [];
				$emptyData = [];
				$header = [];
				$i = 1;
				$interpreter = new Interpreter();
				$interpreter->addObserver(function(array $row) use (&$data, &$i, &$emptyData,&$header) {
			        	if($i===1){
						$header[] = preg_replace("/[^a-zA-Z 0-9]+/", "", $row);
					}
				        else {
					    $data[] = array(
						'state_id' => preg_replace("/[^a-zA-Z 0-9]+/", "", $row[0]),
						'district_name' => preg_replace("/[^a-zA-Z 0-9]+/", "", $row[1])
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
							'type' => 'Districts Data'
						     )
					)
				);
				$excelId = $this->Excel->getLastInsertId();
				$c = 0;
				$new_data = array();
				$valid_data = array();
				foreach($data as $k=>$val){
					if(!empty($val)){
						$res = $this->checkDistrictValidations($val);
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
				$header[0][] = 'Message';
				$c = 0;
				$countEmpty = count($data)-count($new_data);
				$countValid = count($valid_data); 
				foreach($valid_data as $k=>$val){
					$this->District->create();
					$arr = array('District' => $val);
					if($this->District->save($arr)){
						$c++;
					}
				}
				$countRejected = $countAll - $c -$countEmpty;
				$path = WWW_ROOT.'uploads/districts/output/';
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

	


	function checkDistrictValidations($data){
		$flag = 1;
		$msg='';
		if(empty($data['state_id'])){
			$msg = 'Mandatory Data Missing: State Name';
			$flag = 0;
		}  else if(empty($data['district_name'])){
			$msg = 'Mandatory Data Missing: District Name';
			$flag = 0;
		} else {
			
			$StateId = $this->AdminFunction->getStateId($data['state_id']);
			if(empty($StateId)){
				$msg = 'State not found in Database.';
				$flag = 0;
			} else {
				$data['state_id'] = $StateId;
			}
		}
		return array($flag,$msg,$data);
	}
}
