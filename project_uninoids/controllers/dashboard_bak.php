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
            // Make sure we are logged in
            if(is_logged_in() === FALSE){
                redirect(base_url());
            }
	}
	
	public function index(){
            global $client;
            global $oauth2Service;
            global $plus;
            $session_token = $this->session->userdata('token');
            if (isset($session_token)) {
                $client->setAccessToken($session_token);
                if($client->getAccessToken()){
                        // Do some API calls passing the json_decoded callback string
                        $v_data['user_details'] = $this->Users_m->getUserMoreDetails($this->session->userdata('user_id'));	
                }

                try {
//                           $optParams = array('maxResults' => 5);
//                           $activities = $plus->activities->listActivities('me', 'public', $optParams);
                    $activities = '';
                } catch (Exception $exc) {
                   $activities = '';
                }

//                        try {
//                            $tweets = $this->twitter->timeline('muffycompo', 5);
//                        } catch (Exception $exc) {
//                            $tweets = '';
//                        }
                  $tweets = '';
//                        $tweets = $this->twitterfetcher->getTweets(array(
//                            'twitterID' => 'muffycompo',
//                            'usecache' => false,
//                            'count' => 0,
//                            'numdays' => 30
//                        ));

                $v_data['gplus_feeds'] = $activities;
                $v_data['tweets'] = $tweets;
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
                //$v_data['user_profile_details'] = $oauth2Service->userinfo->get();

                $tweets = '';
                $activities = '';

                $v_data['gplus_feeds'] = $activities;
                $v_data['tweets'] = $tweets;

                $v_data['user_profile_details'] = $this->Users_m->getUserMoreDetails($this->session->userdata('user_id'));
                $v_data['layout'] = 'profile_v';
                $this->load->view('layout/layout', $v_data);	
              }
            }
	}
        
        public function update_profile(){
            
        }
	
	public function study(){
            global $client;
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
			//==============================
			// (1) Used for Creating a File from Drive by Id
			//================================
		    $mimeType = 'text/plain';
		    //$mimeType = 'application/vnd.google-apps.document';
		    $newfile = new Google_DriveFile();
		    $newfile->setTitle($inputFile['title']);
		    $newfile->setDescription($inputFile['description']);
		    $newfile->setMimeType($mimeType);
			
		    // Set the parent folder.
		    if ($inputFile['parentId'] != null) {
		      	$parent = new Google_ParentReference();
                        $parent->setId($inputFile['parentId']);
                        $newfile->setParents(array($parent));
		    }
			
			// files.insert
		    /*$createdFile = $drive->files->insert($newfile, array(
		        'data' => $inputFile['content'],
		        'mimeType' => $mimeType,
		    ));*/
			
			//==============================
			// (2) Used for Creating a File Permission from Drive by Id
			//================================
			/*$createdFileId = $createdFile['id'];
			$filePermission = new Permission();
			$filePermission->setValue('puone@binghamuni.edu.ng'); // The email address or domain name for the entity
			$filePermission->setType('group'); // "user", "group", "domain" or "default"
			$filePermission->setRole('writer'); // "owner", "writer" or "reader"
			$filePermission->setAdditionalRoles(array('additionalRoles' => 'commenter')); // "commenter"
			
			// permissions.insert
			$permissionFile = $drive->permissions->insert($createdFileId, $filePermission, array(
				'sendNotificationEmails' => TRUE
			));*/
			
			//==============================
			// Used for Retrieving a File from Drive by Id
			//================================
			/*$createdFile = $drive->files->get('0B4UhGn_nBQFlNWYyZm94LUJvRTQ');*/
			
			//==============================
			// Used for Updating a File from Drive by Id
			//================================
			/*$createdFile = $drive->files->update('0B4UhGn_nBQFlNWYyZm94LUJvRTQ',$newfile, array(
		        'data' => $inputFile['content'],
		        'mimeType' => $mimeType,
		    ));*/
			
			//==============================
			// Used for Retrieving a User Files from Drive by Id
			//================================
			/*$parameters = array('q' => "title contains 'Muffy'");
			$createdFile = $drive->files->listFiles($parameters);*/
			$createdFile = $drive->files->listFiles();
			
		    // Return Created File Response
			return $createdFile;
		    
			// Return Permission Response
			/*return $permissionFile;*/
			
		  } catch (Exception $e) {
		    print 'An error occurred: ' . $e->getMessage();
		  }	
	}

	public function _list_files($inputFile = ''){
		global $client;
		global $oauth2Service;
		global $drive;
		
		try {
			//==============================
			// Used for Retrieving a User Files from Drive by Id
			//================================
			$createdFile = $drive->files->listFiles();
			
		    // Return Created File Response
			return $createdFile;
		    			
		  } catch (Exception $e) {
		    error_log('Error creating a retrieving file on Drive: ' . $e->getMessage(), 0);
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
				
				//==============================
				// Used for Creating New Group
				//================================
				/*$atomXml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
				<atom:entry xmlns:atom='http://www.w3.org/2005/Atom' 
					xmlns:apps='http://schemas.google.com/apps/2006'>
					<apps:property name='groupId' value='puone'/>
					<apps:property name='groupName' value='Uninoids'/>
					<apps:property name='description' value='Testing Project Uninoids Groups'/>
				</atom:entry>";
				
				$req = new apiHttpRequest("https://apps-apis.google.com/a/feeds/group/2.0/$domain",'POST', 
				array('Content-Type' => 'application/atom+xml'), $atomXml
				);
				$resp = $client::getIo()->authenticatedRequest($req);
				echo "<h1>Creating New Group</h1>";
				echo print_r($resp->getResponseBody(), TRUE);*/				
				
				
				//==============================
				// Used for Adding a member to a Group
				//================================
				/*$groupId = 'puone';
				$username = 'systemadmin';
				
				$atomXml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
				<atom:entry xmlns:atom='http://www.w3.org/2005/Atom' 
					xmlns:apps='http://schemas.google.com/apps/2006'>
					<apps:property name='groupId' value='$groupId'/>
					<apps:property name='memberId' value='$username'/>
				</atom:entry>";
				
				$req = new apiHttpRequest("https://apps-apis.google.com/a/feeds/group/2.0/$domain/$groupId/member",'POST', 
				array('Content-Type' => 'application/atom+xml'), $atomXml
				);
				
				$resp = $client::getIo()->authenticatedRequest($req);
				echo "<h1>Adding a Member to a Group</h1>";
				var_dump($resp->getResponseBody());*/
			
			
				//==============================
				// Used for Deleting a Group
				//================================
				/*$groupId = 'puone';
				$req = new apiHttpRequest("https://apps-apis.google.com/a/feeds/group/2.0/$domain/$groupId",'DELETE');
				$resp = $client::getIo()->authenticatedRequest($req);
				echo "<h1>Deleting a Group</h1>";
				var_dump($resp->getResponseBody());*/
				
				
				//==============================
				// Used for Deleting a Member from a Group
				//================================
				/*$groupId = 'puone';
				$username = 'uninoids';
				$req = new apiHttpRequest("https://apps-apis.google.com/a/feeds/group/2.0/$domain/$groupId/member/$username",'DELETE');
				$resp = $client::getIo()->authenticatedRequest($req);
				echo "<h1>Deleting a Member from a Group</h1>";
				var_dump($resp->getResponseBody());*/
					
				}
		}
		
		
	}
	
	function study_materials(){
		/*$v_data['google_drive'] = $drive;*/
		$v_data['layout'] = 'study_materials_v';
		$this->load->view('layout/layout', $v_data);
	}
	
	function sba(){
	global $client;
		$session_token = $this->session->userdata('token');
		if (isset($session_token)) {
			$client->setAccessToken($session_token);
			if($client->getAccessToken()){
			
				$v_data['layout'] = 'sba_v';
				$v_data['drive_files'] = ($this->_list_files() != NULL)? $this->_list_files() : '';
				$this->load->view('layout/layout', $v_data);	
			}
		}	
	}
	
	public function logout(){
		global $client;	
	
		$client->revokeToken();
		
		//$this->session->unset_userdata('token');
		$this->session->sess_destroy();
		redirect('/');
	}
	
}