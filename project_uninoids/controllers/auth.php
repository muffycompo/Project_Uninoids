<?php
/*
* Author: Mfawa Alfred Onen
* Description: Codeigniter File
* Link: http://www.binghamuni.edu.ng
* Email: systemadmin@binghamuni.edu.ng
*/

// Google API Client Includes
require_once APPPATH . "third_party/api_init.php";
global $apiConfig;
global $oauth2Service;

class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		global $client;
		$code = $this->input->get('code');
		if (isset($code)) {
			$client->authenticate();
			$this->session->set_userdata('token', $client->getAccessToken());
		}
		
		$session_token = $this->session->userdata('token');
		if (isset($session_token)) {
			$client->setAccessToken($session_token);
			redirect('dashboard');
		}

	}
	
}