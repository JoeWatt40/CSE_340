<?php

//brings files into the site
require_once 'library/connections.php';
require_once 'model/main-model.php';
require_once 'library/functions.php';

$classifications = getClassifications();

//navigation list
// $navList = '<ul class="navigation">';
// $navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
// foreach ($classifications as $classification) {
//  $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
// }
// $navList .= '</ul>';
$navList = navList($classifications);

//main site controller
$action = filter_input(INPUT_GET, 'action');
    if ($action == NULL){
    $action = filter_input(INPUT_POST, 'action');
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