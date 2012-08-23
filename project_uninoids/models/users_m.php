<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Author: Mfawa Alfred Onen
* Description: Codeigniter File
* Link: http://www.binghamuni.edu.ng
* Email: systemadmin@binghamuni.edu.ng
*/

class Users_m extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
	
	public function verifyUser($user_id){
		if($this->db->where('user_id', $user_id)->get('users')->num_rows() == 1){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function createUser($refresh_token, $oauth2_userinfo){
		if(isset($refresh_token)){
					
			$insert_array = array(
				'user_id' => $oauth2_userinfo->id, 
				'first_name' => $oauth2_userinfo->given_name, 
				'last_name' => $oauth2_userinfo->family_name, 
				'email_address' => $oauth2_userinfo->email, 
				'gender' => $oauth2_userinfo->gender, 
				'user_image_path' => $oauth2_userinfo->picture, 
				'refresh_token' => $refresh_token, 
				'role_id' => 1
			);
			
			$this->db->insert('users', $insert_array);
			if($this->db->affected_rows() > 0){return TRUE;} else {return FALSE;}
			
		} else {
			return FALSE;
		}
	}
	
	public function updateRefreshToken($user_id, $refresh_token, $user_picture = ''){
		if($this->db->select('refresh_token')->from('users')->where('refresh_token', $refresh_token)->get()->num_rows() == 1){
				return TRUE;
			} else {
				
				$this->db->where('user_id', $user_id)->update('users', array('refresh_token' => $refresh_token, 'user_image_path' => $user_picture));
				if($this->db->affected_rows() > 0){return TRUE;} else {return FALSE;}
			}		
	}
	
	public function getUserDetails($user_id){
		$rs = $this->db->select('user_id,email_address,refresh_token,role_id')->where('user_id', $user_id)->limit(1)->get('users');
		if($rs->num_rows() > 0){
			$user = array();
			return $rs->row_array();
		} else {
			return FALSE;
		}
	}
	
	public function getUserMoreDetails($user_id){
		$rs = $this->db->where('user_id', $user_id)->limit(1)->get('users');
		if($rs->num_rows() > 0){
			$user = array();
			return $rs->row_array();
		} else {
			return FALSE;
		}
	}
        
        public function updateUserProfile($user_id, $matric_no = '',$twitter_username = ''){
            if(!empty($matric_no) && !empty($twitter_username)){
                $profile_array = array('regno' => $matric_no, 'twitter_username' => $twitter_username);
            } elseif(!empty($matric_no)){
                $profile_array = array('regno' => $matric_no);
            } elseif(!empty($twitter_username)){
                $profile_array = array('twitter_username' => $twitter_username);
            } else { return FALSE; }
            $this->db->where('user_id',$user_id)->update('users',$profile_array);
            if($this->db->affected_rows() > 0){return TRUE;} else {return FALSE;}
        }
        
        public function getTwitterUsername($user_id){
            if(!empty($user_id)){
                $rs = $this->db->select('twitter_username')->where('user_id', $user_id)->get('users');
                if($rs->num_rows() > 0){ return $rs->row(0)->twitter_username;} else {return '';}
            }
        }
}