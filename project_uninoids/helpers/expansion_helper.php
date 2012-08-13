<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Author: Mfawa Alfred Onen
* Description: Codeigniter Expansion Helper
* Link: http://www.binghamuni.edu.ng
* Email: systemadmin@binghamuni.edu.ng
*/

function expand_curriculum_status($status_code){
	switch($status_code){
		case 0:
			return 'Inactive';
			break;
		case 1:
			return 'Active';
			break;
	}
}

function _expand_curriculum_name($curriculum_id){
	$c =& get_instance();
	return $c->db->select('curriculum_name')
		->where('curriculum_id', $curriculum_id)
		->get('curriculums')
		->row(0)
		->curriculum_name;
}

function expand_lg_name($lg_id){
    $c =& get_instance();
    return $c->db->select('lg_name')
    ->where('lg_id', $lg_id)
    ->get('learning_groups')
    ->row(0)
    ->lg_name;
}

function expand_assessment_name($a_id){
    $c =& get_instance();
    return $c->db->select('a_name')
    ->where('a_id', $a_id)
    ->get('assessments')
    ->row(0)
    ->a_name;
}

function expand_tutor_curriculum_list($tutor_email){
	$c =& get_instance();
	$rs = $c->db->select('curriculum_id')->where('tutor_email', $tutor_email)->get('tutors');
	if($rs->num_rows() > 0){
		$t = $rs->result();
		$list = array();
		foreach($t as $l){
			$list[] = _expand_curriculum_name($l->curriculum_id);
		}
		if(count($list) == 0){
			return 'N/A';
		} else {
			$tL = implode(', ', $list);			
			return $tL;
		}

	} else {
		return 'N/A';
	}
}

function expand_tutor_name_from_email($tutor_email){
	$c =& get_instance();
	$rs = $c->db->select('first_name,last_name')->where('email_address', $tutor_email)->limit(1)->get('users');
	if($rs->num_rows() > 0){
		$name = ucfirst($rs->row(0)->first_name) .' '.strtoupper($rs->row(0)->last_name);
		return $name;
	} else {
		return '';
	}
}

function expand_lg_id_from_assessment($assessment_id){
	$c =& get_instance();
	if(! empty($assessment_id)){
		return $c->db->select('lg_id')->where('a_id', $assessment_id)->limit(1)->get('assessments')->row(0)->lg_id;
	} else {
		return '';
	}
}

function expand_assessment_id_from_lg($lg_id){
	$c =& get_instance();
	if(! empty($lg_id)){
		return $c->db->select('a_id')->where('lg_id', $lg_id)->limit(1)->get('assessments')->row(0)->a_id;
	} else {
		return '';
	}
}

function expand_tutor_id_from_lg($lg_id){
	$c =& get_instance();
	if(! empty($lg_id)){
		return $c->db->select('tutor_id')->where('lg_id', $lg_id)->limit(1)->get('learning_groups')->row(0)->tutor_id;
	} else {
		return '';
	}
}

function expand_curriculum_from_id($tutor_id){
    $c =& get_instance();
    $rs = $c->db->select('tutors.curriculum_id')
            ->from('tutors')
            ->join('learning_groups','tutors.tutor_id=learning_groups.tutor_id')
            ->where('learning_groups.tutor_id', $tutor_id)
            ->get();
    if($rs->num_rows() > 0){
        return strtolower($rs->row(0)->curriculum_id);
    } else {
        return '';
    }
}