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

	public function addLg($lg_name, $curriculum_id, $lg_student_list){
		$lg_array = array(
			'lg_name' => $lg_name,
			'student_list' => $lg_student_list,
			'tutor_id' => $this->tutor_from_curriculum($curriculum_id, $this->session->userdata('email_address'))
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
	        $rs = $this->db->where('lg_id', $id)->get('learning_groups');
	    } else {
	        $rs = $this->db->order_by('lg_id','DESC')->get('learning_groups');
	    }
	    if($rs->num_rows() > 0){
	        return $rs->result();
	    } else {
	        return FALSE;
	    }
	}
	
	public function deleteLg($id){
	    if(! empty($id)){
	        $this->db->where('lg_id', $id)->delete('learning_groups');
	        if($this->db->affected_rows() > 0){
	            return TRUE;
	        } else {
	            return FALSE;
	        }
	    } else {
	        return FALSE;
	    }
	}
	
	public function tutor_from_curriculum($curriculum_id, $email_address){
    
	  return $this->db->select('tutor_id')
	      ->where('curriculum_id', $curriculum_id)
	      ->where('tutor_email', $email_address)
	      ->get('tutors')
	      ->row(0)->tutor_id;
	    
	}

	public function addAssessment($a_name, $a_description, $lg_id, $start_date, $due_date,  $file_id,$file_url){
	    // Add Each Learning Group Student to file permission
	    $s_date = new DateTime($start_date);
	    $d_date = new DateTime($due_date);
	    $assessments_array = array(
	            'a_name' => $a_name,
	            'a_description' => $a_description,
	            'a_file_id' => $file_id,
	            'a_file_url' => $file_url,
	            'a_start_date' => $s_date->getTimestamp(),
	            'a_due_date' => $d_date->getTimestamp(),
	            'lg_id' => $lg_id
	    );
	
        $this->db->insert('assessments', $assessments_array);
	
	    if($this->db->affected_rows() > 0){ return TRUE; } else {return FALSE; }
	}
	
	public function listAssessments($id = ''){
	    if(! empty($id)){
	        $rs = $this->db->where('a_id', $id)->get('assessments');
	    } else {
	        $rs = $this->db->order_by('a_id','DESC')->get('assessments');
	    }
	    if($rs->num_rows() > 0){
	        return $rs->result();
	    } else {
	        return FALSE;
	    }
	}
	
	public function deleteAssessment($id){
	    if(! empty($id)){
	        $this->db->where('a_id', $id)->delete('assessments');
	        if($this->db->affected_rows() > 0){
	            return TRUE;
	        } else {
	            return FALSE;
	        }
	    } else {
	        return FALSE;
	    }
	}

	public function addGrade($a_id, $post_data){
        
	    $ee = 0;
	    foreach ($post_data as $k => $v){
	        if(preg_match('/sc_/i', $k)){
                $e = substr($k, 3);
                $em = str_ireplace('_', '.', $e);
                $bingham_email = str_ireplace('.binghamuni.edu.ng', '@binghamuni.edu.ng', $em);
                $score_array = array(
                    'a_id' => $a_id,
                    'student_email' => $bingham_email,
                    'score' => (float) $v
                );
	            
	            if($this->db->select('score')->where('a_id',$a_id)->where('student_email',$bingham_email)->limit(1)->get('grades')->num_rows() > 0){
	                $this->db->where('a_id',$a_id)->where('student_email',$bingham_email)->update('grades', $score_array);
	            } else {
	                $this->db->insert('grades', $score_array);
	            }
	            
	            if($this->db->affected_rows() == 0){ $ee++; }
                
	        }
	    }
	
	    if($ee > 0){ return FALSE; } else {return TRUE; }
    }
    
    public function updateGrade($a_id, $score, $student_email){
        $score_array = array('score' => (float) $score );
        $this->db->where('a_id',$a_id)->where('student_email',$student_email)->update('grades', $score_array);
        if($this->db->affected_rows() > 0){ return TRUE; } else {return FALSE; }
    }
	
	public function listGrades($id = ''){
	    if(! empty($id)){
	        $rs = $this->db->where('a_id', $id)->get('grades');
	    } else {
	        $rs = $this->db->order_by('a_id','DESC')->get('grades');
	    }
	    if($rs->num_rows() > 0){
	        return $rs->result();
	    } else {
	        return FALSE;
	    }
	}
	
	public function editGradeScoreSingle($id, $email){
	    if(! empty($id) && ! empty($email)){
	       $rs = $this->db->where('a_id', $id)->where('student_email', $email)->limit(1)->get('grades');
	       if($rs->num_rows() > 0){
	           return $rs->result();
	       } else {
	           return FALSE;
	       }
	    }
	}
	
	public function resultAvailability($a_id, $status){
	    if($status == 1){
	        $this->db->where('a_id',$a_id)->update('grades', array('status' => $status));
	        if($this->db->affected_rows() > 0){
	            $rs = $this->db->select('student_email')->where('a_id', $a_id)->where('score >=', 45)->where('status', 1)->get('grades');
	            if($rs->num_rows() > 0){
	                $t = 0;
	                foreach($rs->result() as $user){
	                    $this->db->insert('certificates', array('a_id' => $a_id, 'user_email' => $user->student_email));
	                    if($this->db->affected_rows() < 1){ $t++;}
	                }
	                if($t == 0){
	                    return TRUE;
	                } else {
	                    return FALSE;
	                }
	            }
	        }	        
	    } else if($status == 2){
	        $this->db->where('a_id',$a_id)->update('grades', array('status' => $status));
	        if($this->db->affected_rows() > 0){
    	        $this->db->where('a_id',$a_id)->delete('certificates');
                if($this->db->affected_rows() > 0){return TRUE;} else { return FALSE;}
	         }	        
	    }
	}

	public function listCertificates($id = ''){
	    if(! empty($id)){
	        $rs = $this->db->where('a_id', $id)->group_by('a_id')->get('certificates');
	    } else {
	        $rs = $this->db->order_by('a_id','DESC')->group_by('a_id')->get('certificates');
	    }
	    if($rs->num_rows() > 0){
	        return $rs->result();
	    } else {
	        return FALSE;
	    }
	}

	public function certificateStatus($a_id, $status){
	    $this->db->where('a_id',$a_id)->update('certificates', array('status' => $status));
	    if($this->db->affected_rows() > 0){ return TRUE; } else {return FALSE; }
	}
	
}