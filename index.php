<?php

//brings files into the site
require_once 'library/connections.php';
require_once 'model/main-model.php';
require_once 'library/functions.php';

$classifications = getClassifications();

//navigation list
$navList = navList($classifications);

//main site controller
$action = filter_input(INPUT_GET, 'action');
    if ($action == NULL){
    $action = filter_input(INPUT_POST, 'action');
}

if(isset($_COOKIE['firstname'])) {
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
}

//takes input variable to direct site to page
switch ($action){
    case 'login':
        include './view/login.php';        
        break;
    case 'register':
        include './view/registration.php';
        break;
    default:
        include './view/home.php';        
    break;
}
?>