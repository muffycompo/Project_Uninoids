<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Author: Mfawa Alfred Onen
* Description: Codeigniter File
* Link: http://www.binghamuni.edu.ng
* Email: systemadmin@binghamuni.edu.ng
*/
// Google API Client Includes
require_once APPPATH . "third_party/api_init.php";
global $apiConfig;
global $client;
global $oauth2Service;

class Tutor_m extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	public function addLg($lg_name, $curriculum_id, $lg_student_list, $domain = 'binghamuni.edu.ng'){
            global $client;
            global $drive;
            $session_token = $this->session->userdata('token');
            if (isset($session_token)) {
                $client->setAccessToken($session_token);
                if($client->getAccessToken()){
                   // Pre API Call
                   $group_id = strtolower(str_replace(" ", "_", $lg_name));
                   
                   // Make API Call to Google Provisioning API and Create a Group
                   // Tutor must have "Uninoids Groups Role" to make this API Call
                   $group_req = new Google_HttpRequest("https://apps-apis.google.com/a/feeds/group/2.0/$domain",'POST', array('Content-Type' => 'application/atom+xml'), new_google_group($group_id, $lg_name));
//		   $group_resp = $client::getIo()->authenticatedRequest($group_req);
		   $group_resp = $client->getIo()->authenticatedRequest($group_req);
                   
                   // Check if we were successfull creating the Group
                   if($group_resp->getResponseHttpCode() == 201){
                        // Pre API Call
                        $e = explode(',',$lg_student_list);
                        $y = 0;
                        foreach ($e as $key => $email_id) {
                             // Make API Call to Google Provisioning API and add users to Group
                             // Tutor must have "Uninoids Groups Role" to make this API Call
                             $member_req = new Google_HttpRequest("https://apps-apis.google.com/a/feeds/group/2.0/$domain/$group_id/member",'POST', array('Content-Type' => 'application/atom+xml'), add_member_to_google_group($group_id, $email_id));
//                             $member_resp = $client::getIo()->authenticatedRequest($member_req);
                             $member_resp = $client->getIo()->authenticatedRequest($member_req);
                             if($member_resp->getResponseHttpCode() == 201){$y++;}
                        }
                        if($y > 0){
                            
                            try {
                                // Try Creating a Folder for the Learning Group
                                $mimeType = 'application/vnd.google-apps.folder';
                                $newfolder = new Google_DriveFile();
                                $newfolder->setTitle($lg_name);
                                $newfolder->setMimeType($mimeType);
                      
                                $createdFolder = $drive->files->insert($newfolder);
                                $lg_folder_reference = $createdFolder->getId();
                                
                            } catch (Exception $e){ return NULL;}
                           $lg_array = array(
                                'lg_name' => $lg_name,
                                'student_list' => $lg_student_list,
                                'lg_email' => $group_id . '@' . $domain,
                                'lg_folder_reference' => $lg_folder_reference,
                                'tutor_id' => $this->tutor_from_curriculum($curriculum_id, $this->session->userdata('email_address'))
                            ); 
                           $this->db->insert('learning_groups', $lg_array);
                           if($this->db->affected_rows() > 0){ return TRUE; } else {return FALSE; }
                        } else {return FALSE;}
                   } else { return FALSE;}
                } else { return FALSE;}
            } else {return FALSE;}
	}

	
	public function listLg($tutor_email, $id = ''){
	    if(! empty($id)){
//	        $rs = $this->db->where('lg_id', $id)->get('learning_groups');
                $rs = $this->db->select('lg_id,lg_name,student_list,tutors.tutor_id')
                            ->from('learning_groups')
                            ->join('tutors','learning_groups.tutor_id=tutors.tutor_id','inner')
                            ->where('tutor_email',$tutor_email)
                            ->where('lg_id',$id)
                            ->order_by('lg_id','DESC')
                            ->get();
	    } else {
	        $rs = $this->db->select('lg_id,lg_name,student_list,tutors.tutor_id')
                            ->from('learning_groups')
                            ->join('tutors','learning_groups.tutor_id=tutors.tutor_id','inner')
                            ->where('tutor_email',$tutor_email)
                            ->order_by('lg_id','DESC')
                            ->get();
	    }
	    if($rs->num_rows() > 0){
	        return $rs->result();
	    } else {
	        return FALSE;
	    }
	}
	
	public function deleteLg($id){
	    if(! empty($id)){
                global $client;
                global $drive;
                $session_token = $this->session->userdata('token');
                if (isset($session_token)) {
                $client->setAccessToken($session_token);
                    if($client->getAccessToken()){
                            // Pre API Call
                            $d_e = $this->db->select('lg_email')->where('lg_id',$id)->limit(1)->get('learning_groups')->row(0)->lg_email;
                            $folder_id = $this->db->select('lg_folder_reference')->where('lg_id',$id)->limit(1)->get('learning_groups')->row(0)->lg_folder_reference;
                            $domain_email = explode('@',$d_e);
                            $domain = $domain_email[1];
                            $group_id = $domain_email[0];

                            // Make API Call to Google Provisioning API and Delete a Group
                            // Tutor must have "Uninoids Groups Role" to make this API Call
                            $group_req = new Google_HttpRequest("https://apps-apis.google.com/a/feeds/group/2.0/$domain/$group_id",'DELETE');
//                            $group_resp = $client::getIo()->authenticatedRequest($group_req);
                            $group_resp = $client->getIo()->authenticatedRequest($group_req);
                            
                            if($group_resp->getResponseHttpCode() == 200){
                                try {
                                    // Try Deleting the Learning Group Folder
                                    $drive->files->delete($folder_id);
                                  } catch (Exception $e) {
                                      return NULL;
                                  }
                                $this->db->where('lg_id', $id)->delete('learning_groups');
                                if($this->db->affected_rows() > 0){return TRUE;} else {return FALSE;}                                
                            } else {return FALSE;}
                     } else {return FALSE;}
                } else {return FALSE;}
            } else {return FALSE;}
	}
	
	public function tutor_from_curriculum($curriculum_id, $email_address){
    
	  return $this->db->select('tutor_id')
	      ->where('curriculum_id', $curriculum_id)
	      ->where('tutor_email', $email_address)
	      ->get('tutors')
	      ->row(0)->tutor_id;
	    
	}

	public function addAssessment($a_name, $a_description, $lg_id, $due_date, $ext, $content){
	    // Add Each Learning Group Student to file permission
            global $client;
            global $drive;
            $session_token = $this->session->userdata('token');
            if (isset($session_token)) {
            $client->setAccessToken($session_token);
                if($client->getAccessToken()){
                    $folder_id = $this->db->select('lg_folder_reference')->where('lg_id',$lg_id)->limit(1)->get('learning_groups')->row(0)->lg_folder_reference;
                    $group_id = $this->db->select('lg_email')->where('lg_id',$lg_id)->limit(1)->get('learning_groups')->row(0)->lg_email;
                    try {
                        // Try Deleting the Learning Group Folder
                        if($ext == 'doc'){$mimeType = 'application/msword';} 
                        else if($ext == 'docx'){$mimeType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';} 
                        else if($ext == 'pdf'){$mimeType = 'application/pdf';} 
                        else {$mimeType = 'text/plain';}
//                        $dName = urlencode(str_replace(' ', '_', $a_name));
                        $dName = str_replace(' ', '_', $a_name);
                        $drive_file_name =  clean_title($dName). '.' .$ext;
                        $newfile = new Google_DriveFile();
                        $newfile->setTitle($drive_file_name);
                        $newfile->setDescription($a_description);
                        $newfile->setMimeType($mimeType);
                        
                        // Set the parent folder.
                        if ($folder_id != null) {
                            $parent = new Google_ParentReference();
                            $parent->setId($folder_id);
                            $newfile->setParents(array($parent));
                        }
                        
                        //var_dump($content);
                        //exit;
                        // Create File Inside Learning Group Folder
                        $theFile = $drive->files->insert($newfile, array('data' => $content));
                        $file_id = $theFile->getId();
                        $file_url = $theFile->getAlternateLink();
                        
                        // Set File Permission and Sharing
                        $permission = new Google_Permission();
			$permission->setValue($group_id); // The email address or domain name for the entity
			$permission->setType('group'); // "user", "group", "domain" or "default"
			$permission->setRole('reader'); // "owner", "writer" or "reader"
			$permission->setAdditionalRoles(array('commenter')); // array('commenter')

                        // Set Permission and Notify Group with Email
//                        $t_permission = $drive->permissions->insert($file_id, $permission, array('sendNotificationEmails' => TRUE));
                        $drive->permissions->insert($file_id, $permission, array('sendNotificationEmails' => TRUE));
                        
//                        var_dump($t_permission);
//                        exit;
                       
                        
                     } catch (Exception $e) {
                         $file_id = NULL;
                         $file_url = NULL;
//                         var_dump($e->getMessage());
//                         exit;
                     }
                    
                    $d_date = new DateTime($due_date);
                    $assessments_array = array(
                            'a_name' => clean_title($a_name),
                            'a_description' => $a_description,
                            'a_file_id' => $file_id,
                            'a_file_url' => $file_url,
                            'a_due_date' => $d_date->getTimestamp(),
                            'lg_id' => $lg_id);
                    $this->db->insert('assessments', $assessments_array);
                    if($this->db->affected_rows() > 0){ return TRUE; } else {return FALSE; }
                } else {return FALSE;}
            } else {return FALSE;}
            
            
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
                    // Add Each Learning Group Student to file permission
                    global $client;
                    global $drive;
                    $session_token = $this->session->userdata('token');
                    if (isset($session_token)) {
                    $client->setAccessToken($session_token);
                        if($client->getAccessToken()){
//                            $lg_id = $this->db->select('lg_id')->where('a_id',$id)->limit(1)->get('assessments')->row(0)->lg_id;
                            $folder_id = $this->db->select('learning_groups.lg_folder_reference')
                                    ->join('assessments', 'learning_groups.lg_id=assessments.lg_id', 'inner')
                                    ->where('assessments.a_id',$id)
                                    ->limit(1)
                                    ->get('learning_groups')
                                    ->row(0)->lg_folder_reference;
                            
                            $file_id = $this->db->select('a_file_id')->where('a_id',$id)->limit(1)->get('assessments')->row(0)->a_file_id;
                            $dir_name = FCPATH . 'assets/uploads/';                            
                            
                            // Delete Physical Uploaded File
                            // TODO: Find a way to get the file extension
//                            if(is_dir($dir_name)){
//                                rmdir($dir_name); // Delete Directory
//                                mkdir($dir_name); // Create Directory
//                            }

                            try {
                                // Delete the assessment file from Learning Group Folder
                                $drive->children->delete($folder_id, $file_id);
                             } catch (Exception $e) {
                                 return NULL;
                             }
                                $this->db->where('a_id', $id)->delete('assessments');
                                if($this->db->affected_rows() > 0){return TRUE;} else {return FALSE;}
                            } else {return FALSE;}
                        } else {return FALSE;}
                    } else {return FALSE;}
                
	        
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