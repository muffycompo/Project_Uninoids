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

function role_based_dashboard_menu($role_id, $nav = ''){
	$ci =& get_instance();
	if(! empty($role_id)){
		$prof = $nav == 'profile'? 'class="active"' : '';
		$material = $nav == 'material'? 'class="active"' : '';
		$assessment = $nav == 'assessment'? 'class="active"' : '';
		$grade = $nav == 'grade'? 'class="active"' : '';
		$cert = $nav == 'cert'? 'class="active"' : '';
		$curriculum = $nav == 'curriculum'? 'class="active"' : '';
		$lg = $nav == 'lg'? 'class="active"' : '';
		$tutor = $nav == 'tutor'? 'class="active"' : '';
		$stat = $nav == 'stat'? 'class="active"' : '';
		switch($role_id){
			case 1:
				return '
                                        <ul>
                                            <li '.$prof.'>'.anchor('dashboard/profile','Profile').'</li>
                                            <li '.$material.'>'.anchor('student/materials','Study Materials').'</li>
                                            <li '.$assessment.'>'.anchor('student/assessments','Assessments').'</li>
                                            <li '.$grade.'>'.anchor('student/grades','Grades').'</li>
                                            <li>'.anchor('dashboard/logout','Logout').'</li>
					</ul>';
				break;	
			case 2:
				return '
                                        <ul>
                                            <li '.$prof.'>'.anchor('dashboard/profile','Profile').'</li>
                                            <li '.$lg.'>'.anchor('tutor/manage_lg','Manage Learning Groups').'</li>
                                            <li '.$assessment.'>'.anchor('tutor/manage_assessments','Manage Assessments').'</li>
                                            <li '.$grade.'>'.anchor('tutor/manage_grades','Manage Scores &amp; Grades').'</li>
                                            <li '.$cert.'>'.anchor('tutor/manage_certificates','Manage Certificates').'</li>
                                            <li>'.anchor('dashboard/logout','Logout').'</li>
					</ul>';
				break;	
			case 3:
				return '
                                        <ul>
                                            <li '.$prof.'>'.anchor('dashboard/profile','Profile').'</li>
                                            <li '.$curriculum.'>'.anchor('admin/manage_curriculum','Manage Curriculums').'</li>
                                            <li '.$material.'>'.anchor('admin/manage_sm','Manage Study Materials').'</li>
                                            <li '.$tutor.'>'.anchor('admin/manage_tutors','Manage Tutors').'</li>
                                            <li '.$stat.'>'.anchor('admin/statistics','UNINOIDS Statistics (Exp)').'</li>
                                            <li>'.anchor('dashboard/logout','Logout').'</li>
					</ul>';
				break;	
			default:
				return '<p>Invalid Role Specified!</p>';	
		}
	}
}