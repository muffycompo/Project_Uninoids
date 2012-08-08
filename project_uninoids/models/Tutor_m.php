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
	
	public function listLg($id = ''){
	    if(! empty($id)){
	        $rs = $this->db->where('lg_id', $id)->order_by('lg_id','DESC')->get('learning_groups');
	    } else {
	        $rs = $this->db->order_by('lg_id','DESC')->get('learning_groups');
	    }
	    if($rs->num_rows() > 0){
	        return $rs->result();
	    } else {
	        return FALSE;
	    }
	}
	
}