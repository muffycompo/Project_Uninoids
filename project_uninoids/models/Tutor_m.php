<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Author: Mfawa Alfred Onen
* Description: Codeigniter File
* Link: http://www.binghamuni.edu.ng
* Email: systemadmin@binghamuni.edu.ng
*/

class Tutor_m extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	public function addLg($lg_name, $lg_student_list){
		$lg_array = array(
			'lg_name' => $lg_name,
			'student_list' => $lg_student_list,
			'tutor_id' => $this->session->userdata('email_address')
		);
				
		if($this->db->select('lg_name')->where('lg_name', $lg_name)->get('learning_groups')->num_rows() > 0){
			$this->db->where('lg_name', $lg_name)->update('curriculums', $lg_array);
		} else {
			$this->db->insert('learning_groups', $lg_array);
		}
		
		if($this->db->affected_rows() > 0){ return TRUE; } else {return FALSE; }	
	}

	
	public function listLg($id = ''){
	    if(! empty($id)){
	        $rs = $this->db->where('lg_id', $id)->order_by('lg_id','DESC')->get('learning_groups');
	    } else {
	        $rs = $this->db->order_by('lg_id','DESC')->get('learning_groups');
	    }
	    if($rs->num_rows() > 0){
	        return $rs->result();
	    } else {
	        return FALSE;
	    }
	}
	
}