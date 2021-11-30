<?php
//images uploads controllers
session_start();

require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/vehicles-model.php';
require_once '../uploads/uploads-model.php';
require_once '../library/functions.php';

// Build a navigation bar using the $classifications array
$classifications = getClassifications();
$navList = navList($classifications);

// directory and path of image uploads
$image_dir = '/phpmotors/images/vehicles';
$image_dir_path = $_SERVER['DOCUMENT_ROOT'] . $image_dir;

//gets whether a GET or POST
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if ($action == NULL) {
 $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
}

//switch statements from image action
switch ($action) {
    case 'upload':
      
        $invId = filter_input(INPUT_POST, 'invId', FILTER_VALIDATE_INT);
        $imgPrimary = filter_input(INPUT_POST, 'imgPrimary', FILTER_VALIDATE_INT);
        
        // Store the name of the uploaded image
        $imgName = $_FILES['file1']['name'];
            
        $imageCheck = checkExistingImage($imgName);
            
        if($imageCheck){
            $message = '<p class="notice">An image by that name already exists.</p>';
        } elseif (empty($invId) || empty($imgName)) {
            $message = '<p class="notice">You must select a vehicle and image file for the vehicle.</p>';
        } else {
        
        //upload image and insert into database
        $imgPath = uploadFile('file1');
        $result = storeImages($imgPath, $invId, $imgName, $imgPrimary);
            
        // Set a message based on the insert result
        if ($result) {
            $message = '<p class="notice">The upload succeeded.</p>';
        } else {
            $message = '<p class="notice">Sorry, the upload failed.</p>';
        }
        }

        $_SESSION['message'] = $message;
            
        // Redirect to this controller for default action
        header('location: .');
    break;
    case 'delete':
        
        $filename = filter_input(INPUT_GET, 'filename', FILTER_SANITIZE_STRING);
        $imgId = filter_input(INPUT_GET, 'imgId', FILTER_VALIDATE_INT);
          
        // Build the full path to the image to be deleted
        $target = $image_dir_path . '/' . $filename;
           
        // Check that the file exists in that location
        if (file_exists($target)) {
            $result = unlink($target); 
        }
            
        // Remove from database only if physical file deleted
        if ($result) {
            $remove = deleteImage($imgId);
        }
            
        // Set a message based on the delete result
        if ($remove) {
            $message = "<p class='notice'>$filename was successfully deleted.</p>";
        } else {
         $message = "<p class='notice'>$filename was NOT deleted.</p>";
        }
    
        $_SESSION['message'] = $message;
            
        // Redirect to this controller for default action
        header('location: .');
    break;
    default:

        //get image from directory
        $imageArray = getImages();
        
        //get image info in html for display
        if (count($imageArray)) {
            $imageDisplay = buildImageDisplay($imageArray);
        } else {
            $imageDisplay = '<p class="notice">Sorry, no images could be found.</p>';
        }
           
        //get and put vehicle data in a select list
        $vehicles = getVehicles();
        $prodSelect = buildVehiclesSelect($vehicles);
            
        include '../view/image-admin.php';
        exit;
        break;
   }
?>