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
                    $api_call = gplus_social_activities();
                    $v_data['gplus_feeds'] = $api_call['gplus_feeds'];
                    $v_data['tweets'] = $api_call['tweets'];
                    $v_data['layout'] = 'dashboard_v';
                    $v_data['nav'] = 'dashboard';
                    $this->load->view('layout/layout', $v_data);
                }

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
                // Do some API calls passing the json_decoded callback string
                $api_call = gplus_social_activities();
                $v_data['gplus_feeds'] = $api_call['gplus_feeds'];
                $v_data['tweets'] = $api_call['tweets'];
                $v_data['user_details'] = $this->Users_m->getUserMoreDetails($this->session->userdata('user_id'));
                $v_data['layout'] = 'profile_v';
                $v_data['nav'] = 'profile';
                $this->load->view('layout/layout', $v_data);	
              }
            }
	}
        
        public function update_profile(){
            if($this->input->post('matric_no')){
                $this->form_validation->set_rules('matric_no', 'Matriculation Number', 'required|is_unique[users.regno]|max_length[17]');
                if($this->form_validation->run() === FALSE){
                    $this->session->set_flashdata(array('error'   => validation_errors()));
                    redirect('dashboard/profile');
                }
            }
            
            $user_id = $this->session->userdata('user_id');
            $matric_no = $this->input->post('matric_no');
            $twitter_username = $this->input->post('twitter_username');
            
            if($this->Users_m->updateUserProfile($user_id, $matric_no, $twitter_username)){
              $this->session->set_flashdata(array('success'   => '<strong>Success!</strong> Your Profile has been successfully updated!'));
              redirect('dashboard/profile'); 
            } else {
              $this->session->set_flashdata(array('error'   => '<strong>Error!</strong> Your Profile has not been updated! You might have to actually change something :)'));
              redirect('dashboard/profile'); 
            }
        }

        public function logout(){
            global $client;	

            $client->revokeToken();

            //$this->session->unset_userdata('token');
            $this->session->sess_destroy();
            redirect(base_url());
	}
	
}