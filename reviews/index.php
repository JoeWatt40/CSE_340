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
require_once '../model/reviews-model.php';

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
        include '../view/login.php';
        break;
    case 'add':
        $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING));
        $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT));
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING));
        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));

        if (empty($reviewText) || empty($invId) || empty($clientId)) {
            $_SESSION['message'] = '<p class="red">Please provide information for all empty form fields.</p>';
            header("Location: /phpmotors/vehicles?action=vehicle&invMake=" . $invMake . "&invModel=" . $invModel);
            exit;
        }

        $regOutcome = addReview($reviewText, $clientId, $invId);

        $vehicleReviews = getReviewByInvId($invId);        
        $reviewDisplay = reviewDisplay($vehicleReviews);

        if($regOutcome === 1){
            $message = "<p>Thank you so much for the reviewing the $invMake $invModel</p>";
            include '../view/vehicle-detail.php';
            exit;
        } else {
            $message = "<p>Sorry your review for the $invMake $invModel was not entered, please try again.</p>";
            include '../view/vehicle-detail.php';
            exit;
        }
        include '../view/vehicle-detail.php';
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