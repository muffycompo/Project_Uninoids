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

function curriculum_dropdown($name='lg_curiculum', $selected=NULL)
{
	$c =& get_instance();
	$rs = $c->db->select('curriculum_id,curriculum_name')->get('curriculums');
	if($rs->num_rows() > 0){
		foreach($rs->result() as $option){
			$options[$option->curriculum_id] = $option->curriculum_name;
		}
	}
	return form_dropdown($name, $options, $selected);
}

/*function expand_tutor_id_from_email($email_address){
	$c =& get_instance();
	return $c->db->select('tutor_id')
		->where('curriculum_id', $curriculum_id)
		->get('curriculums')
		->row(0)
		->curriculum_name;
}*/ 