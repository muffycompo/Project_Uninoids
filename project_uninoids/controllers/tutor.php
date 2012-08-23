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
		// Make sure we are logged in
		if(is_logged_in() === FALSE){
		    redirect(base_url());
		}
		if(only_tutor($this->session->userdata('role_id')) === FALSE){
		    redirect('dashboard');
		}
	}
	
    public function manage_lg(){
        $listLgs = $this->Tutor_m->listLg($this->session->userdata('email_address'),'');
        if($listLgs !== FALSE){
            $v_data['learning_groups'] = $listLgs;
        } else {
            $v_data['learning_groups'] = NULL;
        }
        $api_call = gplus_social_activities();
        $v_data['gplus_feeds'] = $api_call['gplus_feeds'];
        $v_data['tweets'] = $api_call['tweets'];
        $v_data['nav'] = 'lg';
        $v_data['layout'] = 'tutor/manage_lg_v';
        $this->load->view('layout/layout', $v_data);
    }

    public function add_lg(){
		if($this->input->post('submit_lg')){
			// TODO: Do some Validation
		    $sl = $this->_remove_email_duplicates($this->input->post('lg_student_list'));
			if($this->input->post('lg_id')){
			    // Check Student list for duplicates		    
				if($this->Tutor_m->updateLg($this->input->post('lg_name'),$sl,$this->input->post('lg_id'))){
					redirect('admin/manage_lg');
				} else {
					die('An error occurred, please check back when we fix this issue or click '. anchor('tutor/manage_tutor','here') .' to try again!');
				}
			} else {
				if($this->Tutor_m->addLg($this->input->post('lg_name'),$this->input->post('lg_curriculum'), $sl)){
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

    public function lg_action($action, $id){
        if($action == 'sl'){
            $details = $this->Tutor_m->listLg($this->session->userdata('email_address'),$id);
            if($details !== FALSE){
                $v_data['student_lists'] = $details;
            } else {
                $v_data['student_lists'] = NULL;
            }
            $api_call = gplus_social_activities();
            $v_data['gplus_feeds'] = $api_call['gplus_feeds'];
            $v_data['tweets'] = $api_call['tweets'];
            $v_data['nav'] = 'lg';
            $v_data['learning_group_id'] = $id;
            $v_data['layout'] = 'tutor/lg_student_list_v';
            $this->load->view('layout/layout', $v_data);
        } else if($action == 'delete') {
            if($this->Tutor_m->deleteLg($id)){
                redirect('tutor/manage_lg');
            } else {
                die('An error occurred, please check back when we fix this issue or click '. anchor('tutor/manage_lg','here') .' to try again!');
            }
        }
    
    }
    
    public function manage_assessments(){
        $assessments = $this->Tutor_m->listAssessments();
        if($assessments !== FALSE){
            $v_data['assessments'] = $assessments;
        } else {
            $v_data['assessments'] = NULL;
        }
        $api_call = gplus_social_activities();
        $v_data['gplus_feeds'] = $api_call['gplus_feeds'];
        $v_data['tweets'] = $api_call['tweets'];
        $v_data['nav'] = 'assessment';
        $v_data['layout'] = 'tutor/manage_assessments_v';
        $this->load->view('layout/layout', $v_data);
    }

    public function add_assessments_html(){
        if($this->input->post('submit_assessment')){
            // TODO: Do some validation
            //2012-08-10
            $due_date = $this->input->post('due_year') .'-'. $this->input->post('due_month') .'-'. $this->input->post('due_day');
            //create Drive File and store id
            $file_content = $this->input->post('a_content');
            if($this->Tutor_m->addAssessment($this->input->post('a_name'), $this->input->post('a_description'), $this->input->post('lg_id'), $due_date, 'txt', $file_content)){
                redirect('tutor/manage_assessments');
            } else {
                die('An error occurred, please check back when we fix this issue or click '. anchor('tutor/add_assessments_html','here') .' to try again!');
            }
        } else {
            $api_call = gplus_social_activities();
            $v_data['gplus_feeds'] = $api_call['gplus_feeds'];
            $v_data['tweets'] = $api_call['tweets'];
            $v_data['nav'] = 'assessment';
            $v_data['layout'] = 'tutor/add_html_assessments_v';
            $this->load->view('layout/layout', $v_data);
        }
    }
    

    public function add_assessments_upload(){
        if($this->input->post('submit_assessment')){
            // TODO: Do some validation
            //2012-08-10
            $due_date = $this->input->post('due_year') .'-'. $this->input->post('due_month') .'-'. $this->input->post('due_day');
            
            $file_extension = $this->input->post('a_ext');
            $file_path = FCPATH . 'assets/uploads/';
            $file_name = clean_title(str_replace(' ', '_', $this->input->post('a_name') .'.'. $file_extension));
            
            // Upload file to server for later reference
            
            $config['upload_path'] = $file_path;
            $config['allowed_types'] = 'doc|docx|pdf';
            $config['remove_spaces'] = TRUE;
            $config['overwrite'] = TRUE;
            $config['file_name'] = $file_name;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('a_upload')){
                $error = array('error' => $this->upload->display_errors());
                die('An error occurred, please check back when we fix this issue or click '. anchor('tutor/add_assessments_upload','here') .' to try again!');
                exit;
            }
            
            //create Drive File and store id
            $file_content = file_get_contents($file_path . $file_name);
            //$a_name, $a_description, $lg_id, $start_date, $due_date, $ext, $content;
            if($this->Tutor_m->addAssessment($this->input->post('a_name'), $this->input->post('a_description'), $this->input->post('lg_id'), $due_date, $file_extension, $file_content)){
                redirect('tutor/manage_assessments');
            } else {
                die('An error occurred, please check back when we fix this issue or click '. anchor('tutor/add_assessments_upload','here') .' to try again!');
            }
        } else {
            $api_call = gplus_social_activities();
            $v_data['gplus_feeds'] = $api_call['gplus_feeds'];
            $v_data['tweets'] = $api_call['tweets'];
            $v_data['nav'] = 'assessment';
            $v_data['layout'] = 'tutor/add_upload_assessments_v';
            $this->load->view('layout/layout', $v_data);
        }
    }

    public function assessment_action($action, $id){
        if($action == 'delete'){
            if($this->Tutor_m->deleteAssessment($id)){
                redirect('tutor/manage_assessments');
            } else {
                die('An error occurred, please check back when we fix this issue or click '. anchor('tutor/manage_assessments','here') .' to try again!');
            }
        }
    }

    
    public function manage_grades(){
        $grades = $this->Tutor_m->listAssessments();
        if($grades !== FALSE){
            $v_data['grades'] = $grades;
        } else {
            $v_data['grades'] = NULL;
        }
        $api_call = gplus_social_activities();
        $v_data['gplus_feeds'] = $api_call['gplus_feeds'];
        $v_data['tweets'] = $api_call['tweets'];
        $v_data['nav'] = 'grade';
        $v_data['layout'] = 'tutor/manage_grades_v';
        $this->load->view('layout/layout', $v_data);
    }
    
    public function add_grade(){
        if($this->input->post('submit_grade')){
            // TODO: Do some Validation
            if($this->Tutor_m->addGrade($this->input->post('a_id'),$this->input->post())){
                redirect('tutor/manage_grades');
             } else {
                die('An error occurred, please check back when we fix this issue or click '. anchor('tutor/manage_grades','here') .' to try again!');
             }
        } else if($this->input->post('submit_grade_edit')){
            // TODO: Do some Validation
            if($this->Tutor_m->updateGrade($this->input->post('a_id'),$this->input->post('score'), $this->input->post('student_email'))){
                redirect('tutor/grade_action/scores/' . expand_lg_id_from_assessment($this->input->post('a_id')));
             } else {
                die('An error occurred, please check back when we fix this issue or click '. anchor('tutor/grade_action/scores/' . expand_lg_id_from_assessment($this->input->post('a_id')),'here') .' to try again!');
             }
        } else {
            $v_data['layout'] = 'tutor/add_grade_v';
            $this->load->view('layout/layout', $v_data);
        }
    
    }
    
    public function grade_action($action, $id){
        if($action == 'scores'){
            $details = $this->Tutor_m->listLg($this->session->userdata('email_address'),$id);
            if($details !== FALSE){
                $v_data['student_lists'] = $details;
            } else {
                $v_data['student_lists'] = NULL;
            }
            $api_call = gplus_social_activities();
            $v_data['gplus_feeds'] = $api_call['gplus_feeds'];
            $v_data['tweets'] = $api_call['tweets'];
            $v_data['nav'] = 'grade';
            $v_data['lg_id'] = $id;
            $v_data['layout'] = 'tutor/grade_score_v';
            $this->load->view('layout/layout', $v_data);
            
        } else if($action == 'edit'){
            $details = $this->Tutor_m->listLg($this->session->userdata('email_address'),$id);
            if($details !== FALSE){
                $v_data['student_lists'] = $details;
            } else {
                $v_data['student_lists'] = NULL;
            }
            $api_call = gplus_social_activities();
            $v_data['gplus_feeds'] = $api_call['gplus_feeds'];
            $v_data['tweets'] = $api_call['tweets'];
            $v_data['nav'] = 'grade';
            $v_data['lg_id'] = $id;
            $v_data['layout'] = 'tutor/grade_score_edit_v';
            $this->load->view('layout/layout', $v_data);
        } else if($action == 'edit_score'){
            $lg_id = substr($id, 0,1);
            $l_id = expand_assessment_id_from_lg($lg_id);
            $l_email = format_uri_email(substr($id, 2), '_');
            $details = $this->Tutor_m->editGradeScoreSingle($l_id, $l_email);
            if($details !== FALSE){
                $v_data['student_lists'] = $details;
            } else {
                $v_data['student_lists'] = NULL;
            }
            $api_call = gplus_social_activities();
            $v_data['gplus_feeds'] = $api_call['gplus_feeds'];
            $v_data['tweets'] = $api_call['tweets'];
            $v_data['nav'] = 'grade';
            $v_data['lg_id'] = $lg_id;
            $v_data['layout'] = 'tutor/grade_score_edit_single_v';
            $this->load->view('layout/layout', $v_data);
        } else if($action == 'grades'){
            $details = $this->Tutor_m->listGrades($id);
            if($details !== FALSE){
                $v_data['student_grade'] = $details;
            } else {
                $v_data['student_grade'] = NULL;
            }
            $api_call = gplus_social_activities();
            $v_data['gplus_feeds'] = $api_call['gplus_feeds'];
            $v_data['tweets'] = $api_call['tweets'];
            $v_data['nav'] = 'grade';
            $v_data['a_id'] = $id;
            $v_data['layout'] = 'tutor/grade_list_v';
            $this->load->view('layout/layout', $v_data);
        } 
    
    }
    
    public function result_visibity($str){

        $status = substr($str, 0,1);
        $a_id = substr($str, 2);
        
        if($this->Tutor_m->resultAvailability($a_id,$status)){
            redirect('tutor/grade_action/grades/' . $a_id);
        } else {
            die('An error occurred, please check back when we fix this issue or click '. anchor('tutor/grade_action/grades/' . $a_id,'here') .' to try again!');
        }
        
    }

    public function manage_certificates(){
        $certs = $this->Tutor_m->listCertificates();
        if($certs !== FALSE){
            $v_data['certs'] = $certs;
        } else {
            $v_data['certs'] = NULL;
        }
        $api_call = gplus_social_activities();
        $v_data['gplus_feeds'] = $api_call['gplus_feeds'];
        $v_data['tweets'] = $api_call['tweets'];
        $v_data['nav'] = 'cert';
        $v_data['layout'] = 'tutor/manage_certificates_v';
        $this->load->view('layout/layout', $v_data);
    }
    
    public function cert_action($action, $id){
        if($action == 'show'){
            if($this->Tutor_m->certificateStatus($id,2)){
                redirect('tutor/manage_certificates');
            } else {
                die('An error occurred, please check back when we fix this issue or click '. anchor('tutor/manage_certificates','here') .' to try again!');
            }  
        
        } else if($action == 'hide'){
            if($this->Tutor_m->certificateStatus($id,1)){
                redirect('tutor/manage_certificates');
            } else {
                die('An error occurred, please check back when we fix this issue or click '. anchor('tutor/manage_certificates','here') .' to try again!');
            }         
        }      
    }
    
    function _remove_email_duplicates($email_str){
        $r = explode(',',$email_str);
        foreach($r as $key => $value){
            $email_address = trim($value);
            if(is_valid_tutor($email_address) === FALSE && is_valid_student($email_address)){
                $tv[] = $email_address;
            }
        }
        // Remove Duplicates and stich back email string
        return implode(',',array_unique($tv));
    }
    
    
}
