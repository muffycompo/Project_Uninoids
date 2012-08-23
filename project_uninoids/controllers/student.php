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

class Student extends CI_Controller {

	public function __construct(){
		parent::__construct();
		// Make sure we are logged in
		if(is_logged_in() === FALSE){
		   redirect(base_url());
		}
	}

	public function materials(){
	    $materials = $this->Student_m->listMaterials($this->session->userdata('email_address'));
	    if($materials !== FALSE){
	        $v_data['materials'] = $materials;
	    } else {
	        $v_data['materials'] = NULL;
	    }
            $v_data['nav'] = 'material';
	    $v_data['layout'] = 'student/materials_v';
	    $this->load->view('layout/layout', $v_data);	    
	}

	public function assessments(){
	    $assessments = $this->Student_m->listAssessments($this->session->userdata('email_address'));
	    if($assessments !== FALSE){
	        $v_data['assessments'] = $assessments;
	    } else {
	        $v_data['assessments'] = NULL;
	    }
            $api_call = gplus_social_activities();
            $v_data['gplus_feeds'] = $api_call['gplus_feeds'];
            $v_data['tweets'] = $api_call['tweets'];
            $v_data['nav'] = 'assessment';
	    $v_data['layout'] = 'student/assessments_v';
	    $this->load->view('layout/layout', $v_data);	    
	}

	public function grades(){
	    $grades = $this->Student_m->listGrades($this->session->userdata('email_address'));
	    if($grades !== FALSE){
	        $v_data['grades'] = $grades;
	    } else {
	        $v_data['grades'] = NULL;
	    }
            $api_call = gplus_social_activities();
            $v_data['gplus_feeds'] = $api_call['gplus_feeds'];
            $v_data['tweets'] = $api_call['tweets'];
            $v_data['nav'] = 'grade';
	    $v_data['layout'] = 'student/grades_v';
	    $this->load->view('layout/layout', $v_data);
	}

}