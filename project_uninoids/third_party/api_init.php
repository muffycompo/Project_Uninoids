<?php
/*
* Author: Mfawa Alfred Onen
* Description: Codeigniter File
* Link: http://www.binghamuni.edu.ng
* Email: systemadmin@binghamuni.edu.ng
*/
global $apiConfig;
global $client;
global $oauth2Service;

require_once APPPATH . "third_party/GoogleAPIClient/src/apiClient.php";
require_once APPPATH . "third_party/GoogleAPIClient/src/contrib/apiOauth2Service.php";

$client = new apiClient();
$oauth2Service = new apiOauth2Service($client);