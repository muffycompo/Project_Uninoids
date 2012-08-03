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
				'user_id' => $oauth2_userinfo['id'], 
				'first_name' => $oauth2_userinfo['given_name'], 
				'last_name' => $oauth2_userinfo['family_name'], 
				'email_address' => $oauth2_userinfo['email'], 
				'refresh_token' => $refresh_token, 
				'role_id' => 1
			);
			
			$this->db->insert('users', $insert_array);
			if($this->db->affected_rows() > 0){return TRUE;} else {return FALSE;}
			
		} else {
			return FALSE;
		}
	}
	
	public function updateRefreshToken($user_id, $refresh_token){
		if($this->db->select('refresh_token')->from('users')->where('refresh_token', $refresh_token)->get()->num_rows() == 1){
				return TRUE;
			} else {
				
				$this->db->where('user_id', $user_id)->update('users', array('refresh_token' => $refresh_token));
				if($this->db->affected_rows() > 0){return TRUE;} else {return FALSE;}
			}		
	}
	
	public function getUserDetails($user_id){
		$rs = $this->db->where('user_id', $user_id)->get('users');
		if($rs->num_rows() > 0){
			return $rs->result_array();
		} else {
			return FALSE;
		}
	}
}