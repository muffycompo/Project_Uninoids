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

class Admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		// Make sure we are logged in
		if(is_logged_in() === FALSE){
		    redirect(base_url());
		}
		if(only_admin($this->session->userdata('role_id')) === FALSE){
		    redirect('dashboard');
		}
	}
	
	public function manage_curriculum(){
		$listCurriculums = $this->Admin_m->listCurriculum();
		if($listCurriculums !== FALSE){
			$v_data['curriculums'] = $listCurriculums;
		} else {
			$v_data['curriculums'] = NULL;
		}
                $api_call = gplus_social_activities();
                $v_data['gplus_feeds'] = $api_call['gplus_feeds'];
                $v_data['tweets'] = $api_call['tweets'];
                $v_data['nav'] = 'curriculum';
		$v_data['layout'] = 'admin/manage_curriculum_v';
		$this->load->view('layout/layout', $v_data);
	}
	
	public function add_curriculum(){
		if($this->input->post('submit_curriculum')){
			// TODO: Do some Validation
			if($this->input->post('curriculum_id')){
				if($this->Admin_m->updateCurriculum($this->input->post('curriculum_name'),$this->input->post('curriculum_status'),$this->input->post('curriculum_id'))){
					redirect('admin/manage_curriculum');
				} else {
					die('An error occurred, please check back when we fix this issue or click '. anchor('admin/manage_curriculum','here') .' to try again!');
				}
			} else {
				if($this->Admin_m->addCurriculum($this->input->post('curriculum_name'),$this->input->post('curriculum_status'))){
					redirect('admin/manage_curriculum');
				} else {
					die('An error occurred, please check back when we fix this issue or click '. anchor('admin/add_curriculum','here') .' to try again!');
				}				
			}
		} else {
			$v_data['layout'] = 'admin/add_curriculum_v';
			$this->load->view('layout/layout', $v_data);			
		}
	
	}
	
	public function manage_tutors(){
		$listTutors = $this->Admin_m->listTutors();
		if($listTutors !== FALSE){
			$v_data['tutors'] = $listTutors;
		} else {
			$v_data['tutors'] = NULL;
		}
                $api_call = gplus_social_activities();
                $v_data['gplus_feeds'] = $api_call['gplus_feeds'];
                $v_data['tweets'] = $api_call['tweets'];
                $v_data['nav'] = 'tutor';
		$v_data['layout'] = 'admin/manage_tutors_v';
		$this->load->view('layout/layout', $v_data);		
	}

	public function add_tutors(){
		if($this->input->post('submit_tutor')){
			// TODO: Do some validation
			if($this->Admin_m->addTutor($this->input->post('tutor_email'), $this->input->post('curriculum'))){
				redirect('admin/manage_tutors');
			} else {
				die('An error occurred, please check back when we fix this issue or click '. anchor('admin/add_tutors','here') .' to try again!');
			}			
		} else {
			$curriculum_list = $this->Admin_m->listCurriculum();
			if($curriculum_list !== FALSE) {
				
				$v_data['curriculums'] = $curriculum_list;
			} else {
				$v_data['curriculums'] = NULL;
			}
			$v_data['layout'] = 'admin/add_tutor_v';
			$this->load->view('layout/layout', $v_data);		
		}
	}
	
	public function curriculum_action($action, $id){
		if($action == 'edit'){
			$editable_curriculum = $this->Admin_m->listCurriculum($id);
			if($editable_curriculum !== FALSE){
				$v_data['curriculums'] = $editable_curriculum;
			} else {
				$v_data['curriculums'] = NULL;
			}
			$v_data['layout'] = 'admin/edit_curriculum_v';
			$this->load->view('layout/layout', $v_data);
		} else if($action == 'delete') {
			if($this->Admin_m->deleteCurriculum($id) !== FALSE){
				redirect('admin/manage_curriculum');
			} else {
				die('An error occurred, please check back when we fix this issue or click '. anchor('admin/manage_curriculum','here') .' to try again!');
			}
		}
		
	}

	public function tutor_action($action, $id){
		if($action == 'details'){
			$details = $this->Admin_m->listTutors(format_uri_email($id,'_'));
			if($details !== FALSE){
				$v_data['tutor_details'] = $details;
			} else {
				$v_data['tutor_details'] = NULL;
			}
			$v_data['layout'] = 'admin/tutor_details_v';
			$this->load->view('layout/layout', $v_data);
		} else if($action == 'delete') {
                        $tid = substr($id, 0,1);
                        $t_email = substr($id, 2);
			if($this->Admin_m->deleteTutor($tid, format_uri_email($t_email,'_')) !== FALSE){
				redirect('admin/manage_tutors');
			} else {
				die('An error occurred, please check back when we fix this issue or click '. anchor('admin/manage_tutors','here') .' to try again!');
			}
		}
		
	}
	
	public function manage_sm(){
		$study_materials = $this->Admin_m->listStudyMaterials();
		if($study_materials !== FALSE){
			$v_data['study_materials'] = $study_materials;
		} else {
			$v_data['study_materials'] = NULL;
		}
                $api_call = gplus_social_activities();
                $v_data['gplus_feeds'] = $api_call['gplus_feeds'];
                $v_data['tweets'] = $api_call['tweets'];
                $v_data['nav'] = 'material';
		$v_data['layout'] = 'admin/manage_sm_v';
		$this->load->view('layout/layout', $v_data);		
	}
	
	public function add_sm(){
	    if($this->input->post('submit_sm')){
	        // TODO: Do some Validation
	        if($this->input->post('sm_id')){
	            //$sm_title, $sm_url, $curriculum_id
	            if($this->Admin_m->updateStudyMaterials($this->input->post('sm_title'),$this->input->post('sm_url'),$this->input->post('curriculum_id'),$this->input->post('sm_id'))){
	                redirect('admin/manage_sm');
	            } else {
	                die('An error occurred, please check back when we fix this issue or click '. anchor('admin/manage_sm','here') .' to try again!');
	            }
	        } else {
	            if($this->Admin_m->addStudyMaterials($this->input->post('sm_title'),$this->input->post('sm_url'),$this->input->post('curriculum_id'))){
	                redirect('admin/manage_sm');
	            } else {
	                die('An error occurred, please check back when we fix this issue or click '. anchor('admin/add_sm','here') .' to try again!');
	            }
	        }
	    } else {
	        $v_data['layout'] = 'admin/add_sm_v';
	        $this->load->view('layout/layout', $v_data);
	    }
	
	}

	public function sm_action($action, $id){
	    if($action == 'edit'){
	        $details = $this->Admin_m->listStudyMaterials($id);
	        if($details !== FALSE){
	            $v_data['study_materials'] = $details;
	        } else {
	            $v_data['study_materials'] = NULL;
	        }
	        $v_data['layout'] = 'admin/sm_edit_v';
	        $this->load->view('layout/layout', $v_data);
	    } else if($action == 'delete') {
	        if($this->Admin_m->deleteStudyMaterials($id) !== FALSE){
	            redirect('admin/manage_sm');
	        } else {
	            die('An error occurred, please check back when we fix this issue or click '. anchor('admin/manage_sm','here') .' to try again!');
	        }
	    }
	
	}
	
}