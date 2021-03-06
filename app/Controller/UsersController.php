<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class UsersController extends AppController {
 
    public $paginate = array(
	'limit' => 25,
	'conditions' => array('status' => '1'),
	'order' => array('User.username' => 'asc' ) 
    );
    
    
    
    public function beforeFilter() {
	$this->apiUrl = Configure::read('api_key');
	parent::beforeFilter();
	$this->Auth->allow('login'); 
    }
     
 
 
    public function login() {
	 
	//if already logged-in, redirect
	if($this->Session->check('Auth.User')){
	    $this->redirect(array('action' => 'index'));      
	}
	 
	// if we get the post information, try to authenticate
	if ($this->request->is('post')) {
	      $link =  $this->apiUrl."users/login.json";
         
              $data = $this->request->data;
              $httpSocket = new HttpSocket();
              $response = $httpSocket->post($link, $data );
	      $response = json_decode($response,true);
	      if (!empty($response['message']['User']) && $response['message']['status']==200) {
		$this->Session->write('Auth.User',$response['message']['User']);
		$status = $this->Auth->user('status');
		$this->Session->setFlash(__('Welcome, '. $this->Auth->user('username')));
		$this->redirect($this->Auth->redirectUrl());
		
	    } else {
	        $this->Session->setFlash(__($response['message']['status']));
		$this->redirect($this->Auth->logout());
	    }
	} 
    }
 
    public function logout() {
	$this->redirect($this->Auth->logout());
    }
 
    public function index() {
	
    }
 
 
    
 
}

