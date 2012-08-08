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

class Tutor extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	
    public function manage_lg(){
        $listLgs = $this->Tutor_m->listLg();
        if($listLgs !== FALSE){
            $v_data['learning_groups'] = $listLgs;
        } else {
            $v_data['learning_groups'] = NULL;
        }
        $v_data['layout'] = 'tutor/manage_lg_v';
        $this->load->view('layout/layout', $v_data);
    }


}