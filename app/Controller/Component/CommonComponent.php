<?php
App::uses('Component', 'Controller');
App::uses('HttpSocket', 'Network/Http');
class  CommonComponent extends Component  {

	public $uses = array();
	

	public function __construct(ComponentCollection $collection,
		$settings = array()) {
		parent::__construct($collection, $settings);
	}
	public function initialize(Controller $controller) {
		//load required for component models
		if ($this->uses !== false) {
		    foreach ($this->uses as $modelClass) {
			$controller->loadModel($modelClass);
			$this->$modelClass = $controller->$modelClass;
		    }
		}
		$this->apiUrl = Configure::read('api_key');
	}
	
	public function getStateList(){
		$link =  $this->apiUrl."states/getStateList.json"; 
     	     	$httpSocket = new HttpSocket();
	      	$response = $httpSocket->get($link);
	      	$response = json_decode($response,true);	
		return $response['States'];
	}

	public function getSectorList(){
		$link =  $this->apiUrl."sectors/getSectorList.json"; 
     	     	$httpSocket = new HttpSocket();
	      	$response = $httpSocket->get($link);
	      	$response = json_decode($response,true);	
		return $response['Sector'];
	}

	public function getEducationLevelList(){
		$link =  $this->apiUrl."education_level/getEducationLevelList.json"; 
     	     	$httpSocket = new HttpSocket();
	      	$response = $httpSocket->get($link);
	      	$response = json_decode($response,true);	
		return $response['EducationLevel'];
	}

	public function getDistrictList($stateId){
		$link =  $this->apiUrl."districts/getDistrictList/$stateId.json"; 
     	     	$httpSocket = new HttpSocket();
	      	$response = $httpSocket->get($link);
	      	$response = json_decode($response,true);	
		return $response['District'];
	}
}
