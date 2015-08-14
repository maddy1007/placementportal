<?php
App::uses('AppController', 'Controller');
require_once APP.'/../vendor/autoload.php'; // load composer
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

/**
 * States Controller
 *
 * @property State $State
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class StatesController extends AppController {
/**
 * Models
 *
 * @var array
 */
	public $uses = array('State','Excel');
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session','AdminFunction');
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
		$link =  $this->apiUrl."states.json";
		$httpSocket = new HttpSocket();
		$response = $httpSocket->get($link,$this->request->params);
		$response = json_decode($response,true);
		$states = $response['State'];
		$this->params['paging'] = $response['params']['params']['paging'];
		$this->set(compact('states'));	
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$link =  $this->apiUrl."states/view/".$id.".json";
		$httpSocket = new HttpSocket();
		$response = $httpSocket->get($link);
		//pr($response); die;
		$response = json_decode($response,true);
		$state = $response['State'];
		$this->set(compact('state'));	
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
		      $link =  $this->apiUrl."states/add.json";
         	      $data = $this->request->data;
		      $httpSocket = new HttpSocket();
		      $response = $httpSocket->post($link, $data );
		      //pr($response); die;
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
			$link =  $this->apiUrl."states/add.json"; 
             	     	$data = $this->request->data;
		      	$httpSocket = new HttpSocket();
		      	$response = $httpSocket->post($link, $data);
		      	$response = json_decode($response,true);	
			//pr($response); die;
			$this->Session->setFlash(__($response['message']['status']));
			return $this->redirect(array('action' => 'index'));
		} else {
			$link =  $this->apiUrl."states/view/".$id.".json";
			$httpSocket = new HttpSocket();
			$response = $httpSocket->get($link);
			$response = json_decode($response,true);
			$this->request->data = $response['State'];
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
			$link =  $this->apiUrl."states/delete/".$id.".json";
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
		if (!empty($this->request->data['State']['UploadExcel']['name'])) {
			$name = $this->request->data['State']['UploadExcel']['name'];
			$name_arr = explode('.',$name);
			$ext = end($name_arr);
			if($ext=='csv' && $this->request->data['State']['UploadExcel']['type']=='text/csv'){			
				$filePath = $this->request->data['State']['UploadExcel']['tmp_name'];
				$fileName = date('Ymdhis').$this->request->data['State']['UploadExcel']['name'];
				$path = 'uploads/states/input/';		
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
						'state_name' => preg_replace("/[^a-zA-Z 0-9]+/", "", $row[0]),
						
					    );
				   }
				    
				    $i++;
				});	
				$lexer->parse($destination, $interpreter);	
				$this->Excel->save(
					array( 
						'Excel' => 
						     array(
							'excel_name' => $name,
							'created' => date('Y-m-d h:i:s')
						     )
					)
				);
				$excelId = $this->Excel->getLastInsertId();
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
							'type' => 'States Data'
						     )
					)
				);
				$excelId = $this->Excel->getLastInsertId();
				$c = 0;
				$new_data = array();
				$valid_data = array();
				foreach($data as $k=>$val){
					if(!empty($val)){
						$res = $this->checkStatesValidations($val);
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
					$this->State->create();
					$arr = array('State' => $val);
					if($this->State->save($arr)){
						$c++;
					}
				}
				$countRejected = $countAll - $c -$countEmpty;
				$path = WWW_ROOT.'uploads/states/output/';
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

	
	function checkStatesValidations($data){
		$flag = 1;
		$msg='';
		
		if(empty($data['state_name'])){
			$msg = 'Mandatory Data Missing: State Name';
			$flag = 0;
		} else{
			$state = $this->AdminFunction->getStateId($data['state_name']);
			 if(!empty($state)){
				$msg = 'Duplicate Entry for State Name.';
				$flag = 0;
			}
		} 
		return array($flag,$msg,$data);
	}
}
