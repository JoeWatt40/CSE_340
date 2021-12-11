<?php
//reviews controller

//starts a session
session_start();

//index file in accounts folder
require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/accounts-model.php';
require_once '../model/vehicles-model.php';
require_once '../library/functions.php';

$classifications = getClassifications();

//navigation list
$navList = navList($classifications);

//main site controller
$action = filter_input(INPUT_GET, 'action');
    if ($action == NULL){
    $action = filter_input(INPUT_POST, 'action');
}

if(isset($_COOKIE['firstname'])){
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
}

//takes input variable to direct site to page
switch ($action){
    case 'login':
        if ($_SESSION['loggedin'] = TRUE)
            include '../view/admin.php';
        else    
            include '../view/login.php';
        break;
    case 'add':
        include '';
        break;
    case 'edit':
        include 'update';        
        break; 
    case 'delete': 
        include '';
        break;
    
    default:
        include '../view/admin.php';        
    break;
}
?>