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
global $client;
global $oauth2Service;

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
	global $client;
	global $oauth2Service;
		$session_token = $this->session->userdata('token');
		if (isset($session_token)) {
			$client->setAccessToken($session_token);
			if($client->getAccessToken()){
				// Do some API calls passing the json_decoded callback string
				
				$v_data['user_details'] = $oauth2Service->userinfo->get();	
			} else {
				$v_data['user_details'] = $session_token;
			}
			 
			$v_data['layout'] = 'dashboard_v';
			$this->load->view('layout/layout', $v_data);
		}
	}
	
	public function profile(){
		global $client;
		global $oauth2Service;
		$session_token = $this->session->userdata('token');
		if (isset($session_token)) {
			$client->setAccessToken($session_token);
			if($client->getAccessToken()){
					// Do some API calls passing the json_decoded callback string
					$v_data['user_profile_details'] = $oauth2Service->userinfo->get();
					$v_data['layout'] = 'profile_v';
					$this->load->view('layout/layout', $v_data);	
				}
		}
	}
	
	public function logout(){
		global $client;	
	
		$client->revokeToken();
		
		$this->session->unset_userdata('token');
		
		redirect('/');
	}
	
}