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

    function vehicleDetail($vehicles){
        $value = number_format($vehicles['invPrice']);
        $dv = "<h1>$vehicles[invMake] $vehicles[invModel]</h1>";
        $dv .= '<ul id="inv-display">';        
        $dv .= '<li>';        
        $dv .= "<img src='$vehicles[invImage]' alt='Image of $vehicles[invMake] $vehicles[invModel] on phpmotors.com'>";
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
?>