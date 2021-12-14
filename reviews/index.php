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
            $message = "<p>Thank you so much for the reviewing the $invMake  $invModel</p>";
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
        $reviewText = trim(filter_input(INPUT_GET, 'reviewText', FILTER_SANITIZE_STRING));
                
        if (empty($reviewText)) {
            $message = '<h2>Please choose a review to edit.</h2>';
            include '/phpmotors/vehicles?action=admin';
        } else {
            $message = '<h2>Enter your changes below</h2>';
            $updateReview = editReview($reviewText);
            include '../view/review-edit.php';
            exit;
        }
       
        include '../view/review-edit.php';        
        break; 
    case 'delete': 
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        
        $deleteResult = deleteReview($reviewId);
        if ($deleteResult) {
            $message = "<p class='notify'>The review was successfully deleted.</p>";
            $_SESSION['message'] = $message;
            include '../view/admin.php';
            exit;
        } else {
            $message = "<p class='notify'>THE REVIEW WAS NOT DELTED!!</p>";
            $_SESSION['message'] = $message;
            include '../view/vehicle-detail.php';
            exit;
        }
        
        include '../view/vehicle-detail.php';
        break;
    
    default:

        if(isset($_SESSION['loggedin'])) {
            include '../view/admin.php';
        } else {
            include '../view/home.php';  
        }    
        break;
}
?>