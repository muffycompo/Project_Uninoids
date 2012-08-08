<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Author: Mfawa Alfred Onen
* Description: Codeigniter File
* Link: http://www.binghamuni.edu.ng
* Email: systemadmin@binghamuni.edu.ng
*/

function format_uri_email($email_address, $separator){
	switch($separator){
		case '@':
			return str_ireplace($separator, '_', $email_address);
		
		case '_':
			return str_ireplace($separator, '@', $email_address);
		case '/':
			return str_ireplace($separator, '_', $email_address);
		default:
			return $email_address;
	}	
}

function is_valid_tutor($tutor_email){
	$c =& get_instance();
	if($c->db->select('role_id')->where('email_address',$tutor_email)->limit(1)->get('users')->row(0)->role_id == 2){
		return TRUE;
	} else {
		return FALSE;
	}
}