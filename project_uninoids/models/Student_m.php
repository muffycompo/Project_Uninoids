<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Author: Mfawa Alfred Onen
* Description: Codeigniter File
* Link: http://www.binghamuni.edu.ng
* Email: systemadmin@binghamuni.edu.ng
*/

class Student_m extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	public function listMaterials($email){
	    if(! empty($email)){
	        if($this->db->like('student_list',$email,'both')->get('learning_groups')->num_rows() > 0){
                $rs = $this->db->select('sm_title,sm_url,study_materials.curriculum_id,learning_groups.tutor_id')
                               ->from('study_materials')
                               ->join('tutors','study_materials.curriculum_id=tutors.curriculum_id','inner')
                               ->join('learning_groups','learning_groups.tutor_id=tutors.tutor_id','inner')
                               ->like('learning_groups.student_list',$email,'both')
                               ->group_by('sm_title')
                               ->get();
	            if($rs->num_rows() > 0){
	                return $rs->result();
	            } else { return FALSE;}
	             
	        } else { return FALSE;}
    	    
	    } else { return FALSE;}
    }

	public function listAssessments($email){
	    if(! empty($email)){
	        if($this->db->like('student_list',$email,'both')->get('learning_groups')->num_rows() > 0){
                $rs = $this->db->select('a_id,a_name,a_description,a_file_url,a_due_date')
                               ->from('assessments')
                               ->join('learning_groups','assessments.lg_id=learning_groups.lg_id','inner')
                               ->like('learning_groups.student_list',$email,'both')
                               ->get();
	            if($rs->num_rows() > 0){
	                return $rs->result();
	            } else { return FALSE;}
	             
	        } else { return FALSE;}
    	    
	    } else { return FALSE;}
    }

	public function listGrades($email){
	    if(! empty($email)){
            $rs = $this->db->where('student_email',$email)->where('status',1)->get('grades');
            if($rs->num_rows() > 0){
                return $rs->result();
            } else {
                return FALSE;
            }
	    }
    }


}