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
//global $drive;

require_once APPPATH . "third_party/GoogleAPIClient/src/apiClient.php";
require_once APPPATH . "third_party/GoogleAPIClient/src/contrib/apiOauth2Service.php";
require_once APPPATH . "third_party/GoogleAPIClient/src/contrib/apiDriveService.php";
//require_once APPPATH . "third_party/GoogleAPIClient/src/contrib/apiGanService.php";

$client = new apiClient();
$oauth2Service = new apiOauth2Service($client);
$drive = new apiDriveService($client);