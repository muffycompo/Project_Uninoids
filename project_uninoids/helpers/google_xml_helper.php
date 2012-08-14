<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Author: Mfawa Alfred Onen
* Description: Codeigniter File
* Link: http://www.binghamuni.edu.ng
* Email: systemadmin@binghamuni.edu.ng
*/

function new_google_group($group_id, $group_name){
    $atomXml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
    <atom:entry xmlns:atom='http://www.w3.org/2005/Atom' 
            xmlns:apps='http://schemas.google.com/apps/2006'>
            <apps:property name='groupId' value='".$group_id."'/>
            <apps:property name='groupName' value='".$group_name."'/>
            <apps:property name='description' value='Uninoids Learning Group for ".$group_name."'/>
    </atom:entry>";
    
    return $atomXml;
}

function add_member_to_google_group($group_id, $username){
    $atomXml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
    <atom:entry xmlns:atom='http://www.w3.org/2005/Atom' 
            xmlns:apps='http://schemas.google.com/apps/2006'>
            <apps:property name='groupId' value='".$group_id."'/>
            <apps:property name='memberId' value='".$username."'/>
    </atom:entry>";
    
    return $atomXml;
}