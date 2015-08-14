<?php
App::uses('AppController', 'Controller');

require_once APP.'/../vendor/autoload.php'; // load composer
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

/**
 * Sectors Controller
 *
 * @property Sector $Sector
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SectorsController extends AppController {
/**
 * Models
 *
 * @var array
 */
	public $uses = array('Sector','Excel');
	function beforeFilter() {
		parent::beforeFilter();
		$this->apiUrl = Configure::read('api_key');
	}
	
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session','AdminFunction');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		
		$link =  $this->apiUrl."sectors.json";
		//echo $link; die;
		$httpSocket = new HttpSocket();
		$response = $httpSocket->get($link,$this->request->params);
		//pr($response); die;
		$response = json_decode($response,true);
		$sectors = $response['Sector'];
		$this->params['paging'] = $response['params']['params']['paging'];
		$this->set(compact('sectors'));		
		
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$link =  $this->apiUrl."sectors/view/".$id.".json";
		$httpSocket = new HttpSocket();
		$response = $httpSocket->get($link);
		//pr($response); die;
		$response = json_decode($response,true);
		$sector = $response['Sector'];
		if(!empty($sector['Sector']['image']))
			$src = 'data: '.$sector['Sector']['image_type'].';base64,'.$sector['Sector']['image_code'];
		else
			$src = '';
		$this->set(compact('src'));		
		$this->set(compact('sector'));	
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
		      $link =  $this->apiUrl."sectors/add.json";
         	      if(!empty($this->request->data['Sector']['image']) && $this->chkImageExtension($this->request->data)){
				$type = $this->request->data['Sector']['image']['type'];
				$image = base64_encode(file_get_contents($this->request->data['Sector']['image']['tmp_name']));
				$fileData   = pathinfo($this->request->data['Sector']['image']['name']);
				$ext        = $fileData['extension'];
				$this->request->data['Sector']['file_name'] = str_replace(' ','_',$this->request->data['Sector']['image']['name']);
				$this->request->data['Sector']['image'] = $image;
				$this->request->data['Sector']['ext'] = $ext;
				$this->request->data['Sector']['image_type'] = $type;
			}
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
	public function edit($id=null) {
		if ($this->request->is(array('post', 'put'))) {
			$link =  $this->apiUrl."sectors/add.json"; 
             	     	if(!empty($this->request->data['Sector']['image']) && $this->chkImageExtension($this->request->data)){
				$type = $this->request->data['Sector']['image']['type'];
				$image = base64_encode(file_get_contents($this->request->data['Sector']['image']['tmp_name']));
				$fileData   = pathinfo($this->request->data['Sector']['image']['name']);
				$ext        = $fileData['extension'];
				$this->request->data['Sector']['file_name'] = str_replace(' ','_',$this->request->data['Sector']['image']['name']);
				$this->request->data['Sector']['image'] = $image;
				$this->request->data['Sector']['ext'] = $ext;
				$this->request->data['Sector']['image_type'] = $type;
			}
		        $data = $this->request->data;
		      	$httpSocket = new HttpSocket();
		      	$response = $httpSocket->post($link, $data);
		      	$response = json_decode($response,true);	
			//pr($response); die;
			$this->Session->setFlash(__($response['message']['status']));
			return $this->redirect(array('action' => 'index'));
		} else {
			$link =  $this->apiUrl."sectors/view/".$id.".json";
			$httpSocket = new HttpSocket();
			$response = $httpSocket->get($link);
			$response = json_decode($response,true);
			$this->request->data = $response['Sector'];
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
			$link =  $this->apiUrl."sectors/delete/".$id.".json";
             	     	$data = $this->request->data;
		      	$httpSocket = new HttpSocket();
		      	$response = $httpSocket->delete($link);
		      	$response = json_decode($response,true);	
			$this->Session->setFlash(__($response['message']['status']));
		}
		return $this->redirect(array('action' => 'index'));
	}


	public function chkImageExtension($data) {
		$return = true; 
		if($data['Sector']['image']['name'] != ''){
		    $fileData   = pathinfo($data['Sector']['image']['name']);
		    $ext        = $fileData['extension'];
		    $allowExtension = array('gif', 'jpeg', 'png', 'jpg');

		    if(!in_array($ext, $allowExtension)) {
			$return = false;
		    }
		    if($data['Sector']['image']['size'] > 2097152){
			$return = false;
		    }   
		} else {
		    $return = false; 
		}   

		return $return;
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
		if (!empty($this->request->data['Sector']['UploadExcel']['name'])) {
			$name = $this->request->data['Sector']['UploadExcel']['name'];
			$name_arr = explode('.',$name);
			$ext = end($name_arr);
			if($ext=='csv' && $this->request->data['Sector']['UploadExcel']['type']=='text/csv'){			
				$filePath = $this->request->data['Sector']['UploadExcel']['tmp_name'];
				$fileName = date('Ymdhis').$this->request->data['Sector']['UploadExcel']['name'];
				$path = 'uploads/sectors/input/';		
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
						'sector_name' => $row[0],						
						'id' => preg_replace("/[^0-9]/", "", $row[1]),
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
							'type' => 'Sectors Data'
						     )
					)
				);
				$excelId = $this->Excel->getLastInsertId();
				$c = 0;
				$new_data = array();
				$valid_data = array();
				foreach($data as $k=>$val){
					if(!empty($val)){
						$res = $this->checkSectorsValidations($val);
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
					$this->Sector->create();
					$arr = array('Sector' => $val);
					if($this->Sector->save($arr)){
						$c++;
					}
				}
				$countRejected = $countAll - $c -$countEmpty;
				$path = WWW_ROOT.'uploads/sectors/output/';
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


	

	function checkSectorsValidations($data){
		$flag = 1;
		$msg='';
		if(empty($data['id'])){
			$msg = 'Mandatory Data Missing: Sector Id';
			$flag = 0;
		} else if(empty($data['sector_name'])){
			$msg = 'Mandatory Data Missing: Sector Name';
			$flag = 0;
		} else {
			$sector = $this->AdminFunction->getSectorId($data['sector_name']);
			$sectorId = $this->AdminFunction->getSectorNameById($data['id']);
			if(!empty($sector)){
				$msg = 'Duplicate Entry for Sector Name.';
				$flag = 0;
			} else if(!empty($sectorId)){
				$msg = 'Duplicate Entry for Sector Id.';
				$flag = 0;
			}
		}
		return array($flag,$msg,$data);
	}
}
