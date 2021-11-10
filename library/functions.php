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
        $navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
        foreach ($classifications as $classification) {
        $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
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
?>