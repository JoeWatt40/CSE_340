<?php
/* vehicles controller */

//brings files into the site
require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/vehicles-model.php';
require_once '../library/functions.php';

$classifications = getClassifications();
$classNames = getClass();

//navigation list
// $navList = '<ul class="navigation">';
// $navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
// foreach ($classifications as $classification) {
//  $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
// }
// $navList .= '</ul>';
$navList = navList($classifications);

$classificationList = '<select name="classificationId">';
foreach($classifications as $classification) {
    $classificationList .= "<option value='$classification[classificationId]'>
    $classification[classificationName]</option>";
}
$classificationList .= '</select>';

//main site controller
$action = filter_input(INPUT_GET, 'action');
    if ($action == NULL){
    $action = filter_input(INPUT_POST, 'action');
}

//takes input variable to direct site to page
switch ($action){
    case 'addClassification':
        include '../view/add-classification.php';        
        break;
    case 'addClass':
        $classificationName = filter_input(INPUT_POST, 'classificationName');
        
        if(empty($classificationName)) {
            $message = '<p>Please provide a new car classification name.</p>';
            include '../view/add-classification.php';
            exit; 
        } 

        $regOutcome = newClassification($classificationName);
        if($regOutcome === 1){
            $message = "<p>Thanks for entering $classificationName. It has been added to the database.</p>";
            include '../view/add-classification.php';
            exit;
        } else {
            $message = "<p>Sorry $classificationName, was not entered. Please try again.</p>";
            include '../view/add-classification.php';
            exit;
        }
        include '../view/vehicle-man.php';
        break;
    case 'addVehicle':
        include '../view/add-vehicle.php';        
        break;
    case 'addCar':
        $invMake = filter_input(INPUT_POST, 'invMake');
        $invModel = filter_input(INPUT_POST, 'invModel');
        $invDescription = filter_input(INPUT_POST, 'invDescription');
        $invImage = filter_input(INPUT_POST, 'invImage');
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail');
        $invPrice = filter_input(INPUT_POST, 'invPrice');
        $invStock = filter_input(INPUT_POST, 'invStock');
        $invColor = filter_input(INPUT_POST, 'invColor');
        $classificationId = filter_input(INPUT_POST, 'classificationId');
        echo ($classificationId);
        if(empty($invMake) || empty($invModel) || empty($invDescription ) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)) {
            $message = '<p>Please provide information for all empty form fields.</p>';
            include '../view/add-vehicle.php';
            exit; 
        }

        $regOutcome = addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);
        if($regOutcome === 1){
            $message = "<p>Thanks for entering a new vehicle data. It has been added to the database.</p>";
            include '../view/add-vehicle.php';
            exit;
        } else {
            $message = "<p>Sorry your vehicle data was not entered. Please try again.</p>";
            include '../view/add-vehicle.php';
            exit;
        }
        include '../view/login.php';
        break;
    default:
        include '../view/vehicle-man.php';        
    break;
}
?>