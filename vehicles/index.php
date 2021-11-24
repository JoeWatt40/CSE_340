<?php
/* vehicles controller */

//starts a session
session_start();

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
$classificationList .= "<option>Choose a Classification</option>";
foreach ($classifications as $classification) {
    $classificationList .= "<option value='$classification[classificationId]'";
    $classificationList .= ">$classification[classificationName]</option>";
}
    $classificationList .= '</select>';

//main site controller
$action = filter_input(INPUT_GET, 'action');
    if ($action == NULL){
    $action = filter_input(INPUT_POST, 'action');
}

//takes input variable to direct site to page
switch ($action){
    case 'manage':
        $classificationList = buildClassificationList($classifications);
        include '../view/vehicle-man.php';
        break;
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
 
    case 'getInventoryItems': 
      
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
        $inventoryArray = getInventoryByClassification($classificationId); 
        echo json_encode($inventoryArray); 
        break;

    case 'mod':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);

        if(count($invInfo) <1 ){
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-update.php';
        exit;
        break;
    case 'updateVehicle':
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        if (empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)) {
        $message = '<p>Please complete all information for the updated item! Double check the classification of the item.</p>';
        include '../view/vehicle-update.php';
        exit;
        }
        $updateResult = updateVehicle($classificationId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $invId );
        if ($updateResult) {
            $message = "<p class='notify'>Congratulations, the $invMake $invModel was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p>Error. The $invMake $invModel was not updated.</p>";
            include '../view/vehicle-update.php';
            exit;
        }
        break;
    case 'del':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if(count($invInfo) < 1){
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-delete.php';
        break;
    case 'deleteVehicle':
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        $deleteResult = deleteVehicle($invId );
        if ($deleteResult) {
            $message = "<p class='notify'>The $invMake $invModel was successfully deleted from the inventory.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class='notify'>THE $invMake $invModel WAS NOT DELTED FROM THE INVENTORY.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        }
        include '../view/vehicle-man.php';
        break;
    case 'vehicle':
        $classificationList = buildClassificationList($classifications);
        include '../view/vehicle-man.php';  
        break;
    case 'classification':
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
        $vehicles = getVehiclesByClassification($classificationName);
        if(!count($vehicles)){
            $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
        } else {
            $vehicleDisplay = buildVehiclesDisplay($vehicles);
        }
    
        include '../view/classification.php';
        break;
    case 'display': 
        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $vehicles = getVehicleById($invId);
        if (!count($vehicles)) {
        $message = "<p class='notice'>Sorry, no vehicle $invMake $invModel could be found.</p>";
        } else {
        $vehicleDetailDisplay = vehicleDetail($vehicles);
        }
        // if (isset($_SESSION['loggedin'])) {
        // if ($_SESSION['loggedin']) {
        //     $screenName = getScreenName($_SESSION['clientData']['clientFirstname'], $_SESSION['clientData']['clientLastname']);
        // }
        // }
        // $reviews = getReviewByInv($vehicle['invId']);
        // $firstReview = '';
        // if (count($reviews) < 1) {
        // $firstReview = '<h3>Be the first to write a review.</h3>';
        // }
        // $reviewsDetailDisplay = '';
        // foreach ($reviews as $key => $review) {
        // $reviewsDetailDisplay .= getReviewsView($review);
        // }
        include '../view/vehicle-detail.php';
        break;
    default:
        $classificationList = buildClassificationList($classifications);
        include '../view/admin.php';        
    break;

}
?>