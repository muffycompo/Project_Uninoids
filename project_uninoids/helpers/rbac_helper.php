<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Author: Mfawa Alfred Onen
* Description: Codeigniter RBAC Helper
* Link: http://www.binghamuni.edu.ng
* Email: systemadmin@binghamuni.edu.ng
*/

function only_admin($role_id){
	if($role_id == 3){return TRUE;} else {return FALSE;}
}

function only_tutor($role_id){
	if($role_id == 2){return TRUE;} else {return FALSE;}
}

function role_based_dashboard_menu($role_id){
	$ci =& get_instance();
	if(! empty($role_id)){
		
		switch($role_id){
			case 1:
				return '
					<p>'.anchor('dashboard/profile','Profile').'</p>
					<p>'.anchor('student/materials','Study Materials').'</p>
					<p>'.anchor('student/assessments','Assessments').'</p>
					<p>'.anchor('student/grades','Grades').'</p>
					<!--<p>'.anchor('student/certificates','Certificates').'</p> -->
					<p>'.anchor('dashboard/logout','Logout').'</p>';
				break;	
			case 2:
				return '
					<p>'.anchor('dashboard/profile','Profile').'</p>
					<p>'.anchor('tutor/manage_lg','Manage Learning Groups').'</p>
					<p>'.anchor('tutor/manage_assessments','Manage Assessments (Skill Based)').'</p>
					<p>'.anchor('tutor/manage_grades','Manage Scores &amp; Grades').'</p>
					<p>'.anchor('tutor/manage_certificates','Manage Certificates').'</p>
					<p>'.anchor('dashboard/logout','Logout').'</p>';
				break;	
			case 3:
				return '
					<p>'.anchor('dashboard/profile','Profile').'</p>
					<p>'.anchor('admin/manage_curriculum','Manage Curriculums').'</p>
					<p>'.anchor('admin/manage_sm','Manage Study Materials').'</p>
					<p>'.anchor('admin/manage_tutors','Manage Tutors').'</p>
					<p>'.anchor('admin/statistics','UNINOIDS Statistics').'</p>
					<p>'.anchor('dashboard/logout','Logout').'</p>';
				break;	
			default:
				return '<p>Invalid Role Specified!</p>';	
		}
	}
}