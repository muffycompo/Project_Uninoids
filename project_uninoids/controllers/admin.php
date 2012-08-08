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
	}

	public function manage_curriculum(){
		$listCurriculums = $this->Admin_m->listCurriculum();
		if($listCurriculums !== FALSE){
			$v_data['curriculums'] = $listCurriculums;
		} else {
			$v_data['curriculums'] = NULL;
		}
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
			if($this->Admin_m->deleteTutor(format_uri_email($id,'_')) !== FALSE){
				redirect('admin/manage_tutor');
			} else {
				die('An error occurred, please check back when we fix this issue or click '. anchor('admin/manage_tutors','here') .' to try again!');
			}
		}
		
	}

}