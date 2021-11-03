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
        $classificationName = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_STRING));
        
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
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING));
        $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING));
        $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING));
        $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING));
        $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_INT));
        $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
        $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING));
        $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_STRING));
        
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