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
		global $oauth2Service;
		$code = $this->input->get('code');
		if (isset($code)) {
			$client->authenticate();
			$this->session->set_userdata('token', $client->getAccessToken());
		}
		
		$session_token = $this->session->userdata('token');

		if (isset($session_token)) {
			$client->setAccessToken($session_token);
			$user = $oauth2Service->userinfo->get();
			// Check if User Exist
			$token_string = json_decode($session_token);
			if($this->Users_m->verifyUser($user->id)){
				if($this->Users_m->updateRefreshToken($user->id, $token_string->refresh_token)){
					$user_sess = $this->Users_m->getUserDetails($user->id);
					
					// Set Session data
					$this->session->set_userdata($user_sess);
				} else {
					// Log the User out and redirect to login
					$client->revokeToken();
					$this->session->unset_userdata('token');
					redirect('/');
				}
				
			} else {
				// Create New Entry
				if($this->Users_m->createUser($token_string->refresh_token, $user)){
					$user_sess = $this->Users_m->getUserDetails($user->id);
					
					// Set Session data
					$this->session->set_userdata($user_sess);
				} else {
					// Log the User out and redirect to login
					$client->revokeToken();
					$this->session->unset_userdata('token');
					redirect('/');					
				}
			}
			
			redirect('dashboard');
		}

	}
	
}