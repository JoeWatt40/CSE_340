<?php
// ALTER TABLE `clients`
// MODIFY `clientId` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

    function checkEmail($clientEmail) {
        $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
        return $valEmail;
    }

    function checkPassword($clientPassword){
        $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
        return preg_match($pattern, $clientPassword);
       }

    function navList($classifications) {
        $navList = '<ul class="navigation">';
        $navList .= "<li><a href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";
        foreach ($classifications as $classification) {
        $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
        }
        $navList .= '</ul>';
        return $navList;
    }

    function buildClassificationList($classifications){ 
        $classificationList = '<select name="classificationId" id="classificationList">'; 
        $classificationList .= "<option>Choose a Classification</option>"; 
        foreach ($classifications as $classification) { 
         $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
        } 
        $classificationList .= '</select>';
        return $classificationList; 
    }
    
    function getInventoryByClassification($classificationId){ 
        $db = phpmotorsConnect(); 
        $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId'; 
        $stmt = $db->prepare($sql); 
        $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT); 
        $stmt->execute(); 
        $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        $stmt->closeCursor(); 
        return $inventory; 
    }

    //display of the vehicles in a list
    function buildVehiclesDisplay($vehicles){
        
        $dv = '<ul id="inv-display">';
        foreach ($vehicles as $vehicle) {
            $value = number_format($vehicle['invPrice']);
            $dv .= '<li>';
            $dv .= "<a href='/phpmotors/vehicles?action=display&invId=".urlencode($vehicle['invId']) ."'>";
            $dv .= "<img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
            $dv .= '</a>';
            $dv .= '<hr>';
            $dv .= "<a href='/phpmotors/vehicles?action=display&invId=" . urlencode($vehicle['invId']) . "'>";
            $dv .= "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
            $dv .= '</a>';
            $dv .= "<span>$$value</span>";
            $dv .= '</li>';
        }
        $dv .= '</ul>';
        return $dv;
    }

    function vehicleDetail($vehicles, $imageThumb){
        $value = number_format($vehicles['invPrice']);
        $dv = '<ul id="inv-display">';           
        $dv .= '<li>';
        foreach ($imageThumb as $imageThumbs) {
            $dv .= "<img src='$imageThumbs[imgPath]' alt='Thumbnail image of $vehicles[invMake] $vehicles[invModel]'>"; 
        } 
        $dv .= '</li>'; 
        $dv .= '<li>';                  
        $dv .= "<img src='$vehicles[imgPath]' alt='Image of $vehicles[invMake] $vehicles[invModel]'>";
        $dv .= "<p>$$value</p>";
        $dv .= '</li>'; 
        $dv .= '<li>';     
        $dv .= "<h2>$vehicles[invMake] $vehicles[invModel]</h2>"; 
        $dv .= "<p>In Stock: $vehicles[invStock]</p>";
        $dv .= "<p>Color Available: $vehicles[invColor]</p>";       
        $dv .= "<p>$vehicles[invDescription]</p>";
        $dv .= '</li>';    
        $dv .= '</ul>';
        return $dv;
    }

//Functions for working with images

// Adds "-tn" designation to file name
function makeThumbnailName($image) {
    $i = strrpos($image, '.');
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    $image = $image_name . '-tn' . $ext;
    return $image;
   }

// Build images display for image management view
function buildImageDisplay($imageArray) {
    $id = '<ul id="image-display">';
    foreach ($imageArray as $image) {
     $id .= '<li>';
     $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'>";
     $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
     $id .= '</li>';
   }
    $id .= '</ul>';
    return $id;
   }

// Build the vehicles select list
function buildVehiclesSelect($vehicles) {
    $prodList = '<select name="invId" id="invId">';
    $prodList .= "<option>Choose a Vehicle</option>";
    foreach ($vehicles as $vehicle) {
     $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
   }

// Handles the file upload process and returns the path of database
function uploadFile($name) {
    
    global $image_dir, $image_dir_path;

    if (isset($_FILES[$name])) {     
        $filename = $_FILES[$name]['name'];
        if (empty($filename)) {
            return;
        }   
        $source = $_FILES[$name]['tmp_name'];  
        //path for file to upload to
        $target = $image_dir_path . '/' . $filename;   
        move_uploaded_file($source, $target); 
        processImage($image_dir_path, $filename); 
        $filepath = $image_dir . '/' . $filename;   
        return $filepath;
        }
   }

// Processes images and creating smaller versions of the image
function processImage($dir, $filename) {
    $dir = $dir . '/';
    $image_path = $dir . $filename;
    $image_path_tn = $dir.makeThumbnailName($filename);
    resizeImage($image_path, $image_path_tn, 200, 200);
    resizeImage($image_path, $image_path, 500, 500);
   }

// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {

    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];
   
    // Set up the function names
    switch ($image_type) {
    case IMAGETYPE_JPEG:
        $image_from_file = 'imagecreatefromjpeg';
        $image_to_file = 'imagejpeg';
    break;
    case IMAGETYPE_GIF:
        $image_from_file = 'imagecreatefromgif';
        $image_to_file = 'imagegif';
    break;
    case IMAGETYPE_PNG:
        $image_from_file = 'imagecreatefrompng';
        $image_to_file = 'imagepng';
    break;
    default:
    return;
   } 
   
    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);
   
    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;
   
    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {
   
        // Calculate height and width for the new image
        $ratio = max($width_ratio, $height_ratio);
        $new_height = round($old_height / $ratio);
        $new_width = round($old_width / $ratio);
   
        // Create the new image
        $new_image = imagecreatetruecolor($new_width, $new_height);
   
        // Set transparency according to image type
        if ($image_type == IMAGETYPE_GIF) {
            $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagecolortransparent($new_image, $alpha);
        }

        if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
        }

        // Copy old image to new image - this resizes the image
        $new_x = 0;
        $new_y = 0;
        $old_x = 0;
        $old_y = 0;
        imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

        // Write the new image to a new file
        $image_to_file($new_image, $new_image_path);
        // Free any memory associated with the new image
        imagedestroy($new_image);
     } else {
         // Write the old image to a new file
         $image_to_file($old_image, $new_image_path);
     }
     // Free any memory associated with the old image
     imagedestroy($old_image);
   } 
?>