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
	$rs = $c->db->select('role_id')->where('email_address',$tutor_email)->limit(1)->get('users');
	if($rs->num_rows() > 0){
	    if($rs->row(0)->role_id == 2){return TRUE;} else { return FALSE;}
	} else {
		return FALSE;
	}
}


function is_valid_student($student_email){
    $c =& get_instance();
    $rs = $c->db->select('role_id')->where('email_address',$student_email)->limit(1)->get('users');
    if($rs->num_rows() > 0){
        if($rs->row(0)->role_id == 1){return TRUE;} else { return FALSE;}
    } else {
        return FALSE;
    }
}

function curriculum_dropdown($name='lg_curiculum', $tutor_email = '', $selected=NULL, $extra = ''){
	$c =& get_instance();
	
	if($c->session->userdata('role_id') == 3){
		if(!empty($tutor_email)){
	    $rs = $c->db->select('curriculums.curriculum_id,curriculums.curriculum_name')
	        ->join('tutors','curriculums.curriculum_id=tutors.curriculum_id','inner')
	        ->where('tutor_email', $tutor_email)
            ->get('curriculums');
		} else {
		    $rs = $c->db->select('curriculum_id,curriculum_name')->get('curriculums');
		}
	} else {
		if(!empty($tutor_email)){
	    $rs = $c->db->select('curriculums.curriculum_id,curriculums.curriculum_name')
	        ->join('tutors','curriculums.curriculum_id=tutors.curriculum_id','inner')
	        ->where('tutor_email', $tutor_email)
	        ->where('curriculums.status', 2)
                ->get('curriculums');
		} else {
		    $rs = $c->db->select('curriculum_id,curriculum_name')->where('status', 2)->get('curriculums');
		}
	}
	$options = array('' => 'Select Curriculum');
	if($rs->num_rows() > 0){
		foreach($rs->result() as $option){
			$options[$option->curriculum_id] = $option->curriculum_name;
		}
                return form_dropdown($name, $options, $selected, $extra);
	} else {
            return form_dropdown($name, $options, $selected, $extra);
        }
	
}

function lg_dropdown($name='lg', $tutor_email = '', $selected=NULL, $extra=''){
    $c =& get_instance();

    if(!empty($tutor_email)){
        $rs = $c->db->select('learning_groups.lg_id,learning_groups.lg_name')
        ->join('tutors','learning_groups.tutor_id=tutors.tutor_id','inner')
        ->where('tutor_email', $tutor_email)->get('learning_groups');
    } else {
        $rs = $c->db->select('lg_id,lg_name')->get('learning_groups');
    }
    $options = array('' => 'Select Learning Group');
    if($rs->num_rows() > 0){
        foreach($rs->result() as $option){
            $options[$option->lg_id] = $option->lg_name;
        } 
          return form_dropdown($name, $options, $selected, $extra);  
    } else {
          return form_dropdown($name, $options, $selected, $extra);  
    }
}

function student_list($student_list_str){
    $student_list = explode(',',$student_list_str);
    $out_str = '';
    foreach ($student_list as $key => $value) {
        $out_str .= '
                <tr>
                    <td>'.expand_tutor_name_from_email(trim(strtolower($value))).'</td>
                    <td>'.strtolower($value).'</td>
                </tr>
    	    ';
    }
    return $out_str;
}

function student_grade_list($student_list_str, $lg_id){
    $student_list = explode(',',$student_list_str);
    $out_str = '';
    foreach ($student_list as $key => $value) {
        $out_str .= '
                <tr>
                    <td>'.expand_tutor_name_from_email(trim(strtolower($value))).'</td>
                    <td>'.strtolower($value).'</td>
                    <td>'.form_input('sc_' . format_uri_email(strtolower($value),'@'),'','class="uninoids_score_input"').'</td>
                    <td>'.anchor('tutor/grade_action/edit_score/' .$lg_id . '_' . format_uri_email(strtolower($value),'@'),'Edit','class="small"').'</td>
                </tr>
    	    ';
    }
    return $out_str;
}

function tutor_email_from_id($tutor_id){
    $c =& get_instance();
    if(! empty($tutor_id)){
        return $c->db->select('tutor_email')->where('tutor_id', $tutor_id)->limit(1)->get('tutors')->row(0)->tutor_email;
    } else {
        return '';
    }
}


function dropdown_datepicker($day='day', $month='month', $year='year', $extra = ''){
    $options_day = array(
            '01'=>'01',
            '02'=>'02',
            '03'=>'03',
            '04'=>'04',
            '05'=>'05',
            '06'=>'06',
            '07'=>'07',
            '08'=>'08',
            '09'=>'09',
            '10'=>'10',
            '11'=>'11',
            '12'=>'12',
            '13'=>'13',
            '14'=>'14',
            '15'=>'15',
            '16'=>'16',
            '17'=>'17',
            '18'=>'18',
            '19'=>'19',
            '20'=>'20',
            '21'=>'21',
            '22'=>'22',
            '23'=>'23',
            '24'=>'24',
            '25'=>'25',
            '26'=>'26',
            '27'=>'27',
            '28'=>'28',
            '29'=>'29',
            '30'=>'30',
            '31'=>'31'
    );

    $options_month = array(
            '01'=>'01',
            '02'=>'02',
            '03'=>'03',
            '04'=>'04',
            '05'=>'05',
            '06'=>'06',
            '07'=>'07',
            '08'=>'08',
            '09'=>'09',
            '10'=>'10',
            '11'=>'11',
            '12'=>'12'
    );

    $options_year = array(
            '2012'=>'2012',
            '2013'=>'2013',
            '2014'=>'2014'
    );

    $calender_dropdown = form_dropdown($day, $options_day, NULL, $extra) . form_dropdown($month, $options_month, NULL, $extra) . form_dropdown($year, $options_year, NULL, $extra);
    return $calender_dropdown;
}

function grade_from_score($score, $letter_grade = FALSE){
    if($letter_grade){
        if($score <= 44.99){return 'strong>F</strong>';}
        elseif ($score >= 45 && $score <= 49){return '<strong>D</strong>';}
        elseif ($score >= 50 && $score <= 59){return '<strong>C</strong>';}
        elseif ($score >= 60 && $score <= 69){return '<strong>B</strong>';}
        elseif ($score >= 70 && $score <= 100){return '<strong>A</strong>';}
        else {return '<strong>Out of range!</strong>';}        
    } else {
        if($score <= 44.99){return $score .'% (<strong>F</strong>)';}
        elseif ($score >= 45 && $score <= 49){return $score .'% (<strong>D</strong>)';}
        elseif ($score >= 50 && $score <= 59){return $score .'% (<strong>C</strong>)';}
        elseif ($score >= 60 && $score <= 69){return $score .'% (<strong>B</strong>)';}
        elseif ($score >= 70 && $score <= 100){return $score .'% (<strong>A</strong>)';}
        else {return '<strong>Out of range!</strong>';}
    }
}

function result_status($a_id){
    $c =& get_instance();
    if(! empty($a_id)){
        $r = $c->db->select('status')
            ->where('a_id', $a_id)
            ->limit(1)
            ->get('grades');
            
        if($r->num_rows() > 0){return $r->row(0)->status;} else {return '';}
    }
}

function uninoids_date($timestamp){
    if(! empty($timestamp)){
        return date('d/m/Y', $timestamp);
    } else {
        return '';
    }    
}

function certificate_status($a_id, $student_email){
    $c =& get_instance();
    if(! empty($a_id)){
        $r = $c->db->where('a_id',$a_id)->where('user_email',$student_email)->limit(1)->get('certificates');
        if($r->num_rows() == 1){
            return anchor('#','Print','class="small_btn"');
        } else {
            return 'N/A';
        }
    }
}

function is_logged_in(){
    $c =& get_instance();
    if($c->session->userdata('logged_in')){
        return TRUE; 
    } else {
        return FALSE;
    }
}

function delete_dir($path){
    $traversal = is_file($path) ? @unlink($path) : array_map(__FUNCTION__, glob($path.'/*')) == @rmdir($path);
    if(!is_dir($path)){mkdir($path);}
    return $traversal;
}

function clean_title($string){  
    // Replace other special chars  
    return str_replace( array( '\'', '"', ',' , ';', '<', '>','+','=','`','~','/','%','@','*','!','(',')','&' ), '', $string);
}

function gplus_social_activities(){
    // Include Gooogle API Client Initializer
    require_once APPPATH . "third_party/api_init.php";
    // Global Various
    global $client;
    global $plus;
    $c =& get_instance();
    $session_token = $c->session->userdata('token');
    if (isset($session_token)) {
        $client->setAccessToken($session_token);
        if($client->getAccessToken()){
            // Do some API calls passing the json_decoded callback string

                try {
                    //$me = $plus->people->get($c->session->userdata('user_id'));
                } catch (Google_ServiceException $e){
                    $me = '';
                }
                if(! empty($me)){
                    // Check if we have activities in Cache
                    if ($c->cache->file->get('gplus_activity_'.$c->session->userdata('user_id'))){
                        $activities = $c->cache->file->get('gplus_activity_'.$c->session->userdata('user_id'));
                    } else {
                        try {
                            $optParams = array('maxResults' => 5);
                            //$activities = $plus->activities->listActivities('me', 'public', $optParams);
                            if($activities){
                                // Save to Cache
                                $c->cache->file->save('gplus_activity_'.$c->session->userdata('user_id'), $activities, $c->config->item('gplus_cache_ttl'));                                                                    
                            }
                        } catch (Exception $e) {
                         $activities = '';   
                        }

                    }                        
                }
                
            try {
                $twitter_username = $c->Users_m->getTwitterUsername($c->session->userdata('user_id'));
                $tusername = empty($twitter_username) ? 'googledevs' : $twitter_username;
                //$tweets = $c->twitter->timeline($tusername, 5);
            } catch (Exception $e) {
                $tweets = '';
            }

            $ra = array(
                'gplus_feeds' => $activities,
                'tweets' => $tweets);
            
            return $ra;
          }
        }
}

function name_from_email($email_address){
    $c =& get_instance();
    $rs = $c->db->select('first_name,last_name')->where('email_address',$email_address)->get('users');
    if($rs->num_rows() > 0){
        return $rs->row(0)->first_name . ' ' . $rs->row(0)->last_name;
    } else {
        return '';
    }
}

function check_student_regno($user_id){
    $c =& get_instance();
    if(! empty($user_id)){
        $r = $c->db->select('regno')->where('user_id',$user_id)->get('users');
        if($r->num_rows() > 0){ return $r->row(0)->regno;} else {return FALSE;} 
    }
}

function days_left($due_date){
	date_default_timezone_set('Africa/Lagos');
	$start_date = strtotime(date('Y-m-d')); // Today's Date
	$end_date = $due_date; // Due date
	
	$days = floor(abs($end_date - $start_date) / 86400);
	
	return $days;
}