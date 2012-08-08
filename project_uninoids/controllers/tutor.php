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

class Tutor extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	
    public function manage_lg(){
        $listLgs = $this->Tutor_m->listLg();
        if($listLgs !== FALSE){
            $v_data['learning_groups'] = $listLgs;
        } else {
            $v_data['learning_groups'] = NULL;
        }
        $v_data['layout'] = 'tutor/manage_lg_v';
        $this->load->view('layout/layout', $v_data);
    }

	public function add_lg(){
		if($this->input->post('submit_lg')){
			// TODO: Do some Validation
			if($this->input->post('lg_id')){
				if($this->Tutor_m->updateLg($this->input->post('lg_name'),$this->input->post('lg_student_list'),$this->input->post('lg_id'))){
					redirect('admin/manage_lg');
				} else {
					die('An error occurred, please check back when we fix this issue or click '. anchor('tutor/manage_tutor','here') .' to try again!');
				}
			} else {
				if($this->Tutor_m->addLg($this->input->post('lg_name'),$this->input->post('lg_student_list'))){
					redirect('tutor/manage_lg');
				} else {
					die('An error occurred, please check back when we fix this issue or click '. anchor('tutor/add_lg','here') .' to try again!');
				}				
			}
		} else {
			$v_data['layout'] = 'tutor/add_lg_v';
			$this->load->view('layout/layout', $v_data);			
		}
	
	}

}