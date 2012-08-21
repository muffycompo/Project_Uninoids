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
global $drive;
global $plus;

require_once APPPATH . "third_party/GoogleAPIClient/src/Google_Client.php";
require_once APPPATH . "third_party/GoogleAPIClient/src/contrib/Google_Oauth2Service.php";
require_once APPPATH . "third_party/GoogleAPIClient/src/contrib/Google_DriveService.php";
require_once APPPATH . "third_party/GoogleAPIClient/src/contrib/Google_PlusService.php";

$client = new Google_Client();
$oauth2Service = new Google_Oauth2Service($client);
$drive = new Google_DriveService($client);
$plus = new Google_PlusService($client);
