<?php

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
    case 'Register':
        include '../view/registration.php';
        break;
    case 'login':
        include '../view/login.php';        
        break; 
    case 'admin': 
        include '../view/admin.php';
        break;
    case 'Login':
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));

        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);
        
        $clientData = getClient($clientEmail);

        if(empty($clientEmail) || empty($checkPassword)){
            $message = '<p>Please provide information for all empty form fields.</p>';
            include '../view/login.php';
            exit; 
        }
                
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        if(!$hashCheck) {
        $message = '<p class="notice">Please check your password and try again.</p>';
        include '../view/login.php';
        exit;
        }
       
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['message'] = '<h2 class="notice">Thank you for logging in.</h2>';
       
        //remove password from the array
        array_pop($clientData);

        // Store the array into the session
        $_SESSION['clientData'] = $clientData;
       
        include '../view/admin.php';        
        break; 
    case 'register':
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));

        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        //checking for existing email address
        $existingEmail = checkExistingEmail($clientEmail);

        // Check for existing email address in the table
        if($existingEmail){
            $message = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
            include '../view/login.php';
            exit;
        }

        if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
            $message = '<p>Please provide information for all empty form fields.</p>';
            include '../view/registration.php';
            exit; 
        }

        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
        if($regOutcome === 1){
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            $_SESSION['message'] = "Thanks for registering $clientFirstname. Please use your email and password to login.";
            header('Location: /phpmotors/accounts/?action=login');
            exit;
        } else {
            $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include '../view/registration.php';
            exit;
        }
        include '../view/registration.php';
        break;
    case 'email':
        include './teach.php';
        break;
    case 'vehicle':
        include '../view/vehicle-man.php';
        break;
    case 'Logout':
        unset($_SESSION['loggedin']);
        unset($_SESSION['clientData']);
        unset($_SESSION['message']);
        unset($_SESSION['messageVehicle']);
        session_destroy();
        header('Location: /phpmotors/');
        break;
    case 'updateAccount':
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));
        
        $clientEmail = checkEmail($clientEmail);
      
        if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)){
            $_SESSION['message'] = '<p>Please provide information for all empty form fields.</p>';
            include '../view/client-update.php';
            exit; 
        }

        $regOutcome = updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId);
        if($regOutcome === 1){
            $clientData = getClient($clientEmail);
            $_SESSION['clientData'] = $clientData;
            $_SESSION['message'] = "Your account information has been updated.";
            include '../view/admin.php';
            exit;
        } else {
            $message = "<p>Sorry $clientFirstname, but the update failed. Please try again.</p>";
            include '../view/client-update.php';
            exit;
        }

        $clientData = getClient($clientEmail);
  
        $_SESSION['clientData'] = $clientData;

        include '../view/client-update.php';
        break;
    default:
        include '../view/admin.php';        
    break;
}
?>