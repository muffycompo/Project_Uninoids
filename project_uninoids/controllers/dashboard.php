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
				
				$v_data['user_details'] = $this->session->userdata('user_sess');	
			} else {
				$v_data['user_details'] = array();
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
	
	public function study(){
		global $client;
		//global $oauth2Service;
		global $drive;
		$session_token = $this->session->userdata('token');
		if (isset($session_token)) {
			$client->setAccessToken($session_token);
			if($client->getAccessToken()){
					// Do some API calls passing the json_decoded callback string
					$v_data['google_drive'] = $drive;
					$v_data['layout'] = 'study_v';
					$this->load->view('layout/layout', $v_data);	
				}
		}
	}
	
	
	// Drive Stuff
	public function create_file(){
		global $client;
		$session_token = $this->session->userdata('token');
		if (isset($session_token)) {
			$client->setAccessToken($session_token);
			if($client->getAccessToken()){
					$v_data['layout'] = 'create_file_v';
					$this->load->view('layout/layout', $v_data);	
				}
		}		
	}
	
	public function new_file(){
		global $client;
		global $drive;
		$session_token = $this->session->userdata('token');
		if (isset($session_token)) {
			$client->setAccessToken($session_token);
			if($client->getAccessToken()){
					// Create File
					$file_details = array(
						'title' => $this->input->post('file_name') . '.' . $this->input->post('file_ext'),
						'description' => $this->input->post('file_description'),
						'content' => $this->input->post('file_body'),
						'parentId' => NULL
					);
				
					$new_file = $this->_save_file($file_details);
					
					echo '<pre>';
					var_dump($new_file);
					echo '</pre>';
					
				}
		}	
	}
	
	public function _save_file($inputFile){
		global $client;
		global $oauth2Service;
		global $drive;
		
		try {
		    $mimeType = 'text/plain';
		    //$mimeType = 'application/vnd.google-apps.document';
		    $newfile = new DriveFile();
		    $newfile->setTitle($inputFile['title']);
		    $newfile->setDescription($inputFile['description']);
		    $newfile->setMimeType($mimeType);
			
		    // Set the parent folder.
		    if ($inputFile['parentId'] != null) {
		      	$parent = new ParentReference();
			    $parent->setId($inputFile['parentId']);
			    $newfile->setParents(array($parent));
		    }

		    $createdFile = $drive->files->insert($newfile, array(
		        'data' => $inputFile['content'],
		        'mimeType' => $mimeType,
		    ));
			
			/*$createdFile = $drive->files->get('0B4UhGn_nBQFlNWYyZm94LUJvRTQ');*/
			
			/*$createdFile = $drive->files->update('0B4UhGn_nBQFlNWYyZm94LUJvRTQ',$newfile, array(
		        'data' => $inputFile['content'],
		        'mimeType' => $mimeType,
		    ));*/
			
		    return $createdFile;
		  } catch (apiServiceException $e) {
		    error_log('Error creating a new file on Drive: ' . $e->getMessage(), 0);
		    throw $e;
		  }	
	}
	
	public function groups_demo(){
		global $client;
		
		$session_token = $this->session->userdata('token');
		if (isset($session_token)) {
			$client->setAccessToken($session_token);
			if($client->getAccessToken()){
				// Retrieving a Single User in a Domain:
				$domain = "binghamuni.edu.ng";
				$user = rawurlencode("systemadmin");
				//$req = new apiHttpRequest("https://apps-apis.google.com/a/feeds/$domain/user/2.0/");
				$req = new apiHttpRequest("https://apps-apis.google.com/a/feeds/group/2.0/$domain",'POST', 
				array('Content-Type' => 'text/plain'),
				array(
					'groupId' => 'unii',
					'groupName' => 'Uninoids',
					'description' => 'Testing Uninoids Groups'
				));
				$resp = $client::getIo()->authenticatedRequest($req);
				echo "<h1>Single User</h1>";
				echo print_r($resp->getResponseBody(), TRUE);				
					
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