<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

class home extends CI_Controller {
	
	public function index(){
		global $client;
		$client->setApplicationName("Project Uninoids");
		$client->setUseObjects(true);
		$limit_to_domain = 'binghamuni.edu.ng';
		
		if ($client->getAccessToken()) {
			// The access token may have been updated lazily.
			$this->session->set_userdata('token',$client->getAccessToken());
			redirect('auth');
		  
		} else {
		  	$v_data['login_url'] = $client->createAuthUrl($limit_to_domain);
			$v_data['layout'] = 'home_v';
			$this->load->view('layout/layout', $v_data);
		}
	}
}