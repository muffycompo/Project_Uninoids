<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Author: Mfawa Alfred Onen
* Description: Codeigniter File
* Link: http://www.binghamuni.edu.ng
* Email: systemadmin@binghamuni.edu.ng
*/

class Admin_m extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	public function addCurriculum($curriculum_name, $curriculum_status){
		$curriculum_array = array(
			'curriculum_name' => $curriculum_name,
			'status' => $curriculum_status
		);
				
		if($this->db->select('curriculum_name')->where('curriculum_name', $curriculum_name)->get('curriculums')->num_rows() > 0){
			$this->db->where('curriculum_name', $curriculum_name)->update('curriculums', $curriculum_array);
		} else {
			$this->db->insert('curriculums', $curriculum_array);
		}
		
		if($this->db->affected_rows() > 0){ return TRUE; } else {return FALSE; }	
	}

	public function updateCurriculum($curriculum_name, $curriculum_status, $id){
		$curriculum_array = array(
			'curriculum_name' => $curriculum_name,
			'status' => $curriculum_status
		);
				
		$this->db->where('curriculum_id', $id)->update('curriculums', $curriculum_array);
		
		if($this->db->affected_rows() > 0){ return TRUE; } else {return FALSE; }	
	}
		
	public function listCurriculum($id = ''){
		if(! empty($id)){
			$rs = $this->db->where('curriculum_id', $id)->order_by('curriculum_id','DESC')->get('curriculums');
		} else {
			$rs = $this->db->order_by('curriculum_id','DESC')->get('curriculums');
		}
			if($rs->num_rows() > 0){
				return $rs->result();
			} else {
				return FALSE;
			}
	}
	
	public function deleteCurriculum($id){
		if(! empty($id)){
			$this->db->where('curriculum_id', $id)->delete('curriculums');
			if($this->db->affected_rows() > 0){
				return TRUE;
			}
		}
			return FALSE;
	}
	
	public function addTutor($tutor_email, $curriculum_list){
		if(count($curriculum_list) == 0){
			return FALSE;
		}
		if(empty($tutor_email)){
			return FALSE;
		}
		$role_id = $this->db->select('role_id')->where('email_address',$tutor_email)->limit(1)->get('users')->row(0)->role_id;
		if($role_id == 1){
			$this->db->where('role_id',$role_id)->where('email_address',$tutor_email)->update('users',array('role_id' => 2));
			if($this->db->affected_rows() < 1){ return FALSE; }
		}
		
		foreach($curriculum_list as $key => $value){
			$in_array = array(
				'tutor_email' => $tutor_email,
				'curriculum_id' => $value
			);
			$this->db->insert('tutors', $in_array);
		}
		
		if($this->db->affected_rows() > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function listTutors($id = ''){
		if(! empty($id)){
			$rs = $this->db->where('tutor_email', $id)->get('tutors');
		} else {
			$rs = $this->db->group_by('tutor_email')->get('tutors');
		}
			if($rs->num_rows() > 0){
				return $rs->result();
			} else {
				return FALSE;
			}
	}
	
	public function deleteTutor($id, $tutor_email){
		if(! empty($tutor_email)){
			$this->db->where('email_address', $tutor_email)->update('users', array('role_id' => 1));
			if($this->db->affected_rows() > 0){
                            $this->db->where('tutor_id', $id)->where('tutor_email', $tutor_email)->delete('tutors');
                            if($this->db->affected_rows() > 0){return TRUE; } else { return FALSE;}
			} else {
				return FALSE;
			}
		} else {
				return FALSE;
		}
	}

	public function addStudyMaterials($sm_title, $sm_url, $curriculum_id){
	    $sm_array = array(
	            'sm_title' => $sm_title,
	            'sm_url' => strtolower($sm_url),
	            'curriculum_id' => (int) $curriculum_id
	    );
	
	    $this->db->insert('study_materials', $sm_array);
	
	    if($this->db->affected_rows() > 0){ return TRUE; } else {return FALSE; }
	}
	
	public function listStudyMaterials($id = ''){
	    if(! empty($id)){
	        $rs = $this->db->where('sm_id', $id)->get('study_materials');
	    } else {
	        $rs = $this->db->order_by('sm_id','DESC')->get('study_materials');
	    }
	    if($rs->num_rows() > 0){
	        return $rs->result();
	    } else {
	        return FALSE;
	    }
	}

	public function updateStudyMaterials($sm_title, $sm_url, $curriculum_id, $sm_id){
	    $sm_array = array(
	            'sm_title' => $sm_title,
	            'sm_url' => $sm_url,
	            'curriculum_id' => $curriculum_id
	    );
	
	    $this->db->where('sm_id', $sm_id)->update('study_materials', $sm_array);
	
	    if($this->db->affected_rows() > 0){ return TRUE; } else {return FALSE; }
	}
	
	public function deleteStudyMaterials($sm_id){
	    if(! empty($sm_id)){
	        $this->db->where('sm_id', $sm_id)->delete('study_materials');
	        if($this->db->affected_rows() > 0){
	            return TRUE;
	        } else {
	            return FALSE;
	        }
	    } else {
	        return FALSE;
	    }
	}
	
}