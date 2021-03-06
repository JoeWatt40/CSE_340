<?php 
//main PHP Motors model

function getClass(){

    // Create a connection object from the phpmotors connection function
    $db = phpmotorsConnect(); 
    $sql = 'SELECT classificationId, classificationName FROM carclassification ORDER BY classificationId, classificationName ASC';     
    $stmt = $db->prepare($sql);
    $stmt->execute(); 
    $classifications = $stmt->fetchAll(); 
    $stmt->closeCursor(); 
    
    // returns array of classification name 
    return $classifications;
   }
   
function newClassification($classificationName) {

    $db = phpmotorsConnect();
    $sql = 'INSERT INTO carclassification (classificationName) VALUES (:classificationName)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    // Return the indication of success
    return $rowsChanged;
}

function addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId) {

    $db = phpmotorsConnect();
    $sql = 'INSERT INTO inventory (invMake, invModel, invDescription, invImage, invThumbnail, invPrice, invStock, invColor, classificationId) VALUES (:invMake, :invModel, :invDescription, :invImage, :invThumbnail, :invPrice, :invStock, :invColor, :classificationId)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_STR);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    // Return the indication of success
    return $rowsChanged;
}

//selects vehicle by since id
function getInvItemInfo($invId){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
   }

//funciton to update vehicle data
function updateVehicle($invId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId) {

    $db = phpmotorsConnect();
    $sql = 'UPDATE inventory SET invMake = :invMake, invModel = :invModel, 
        invDescription = :invDescription, invImage = :invImage, 
        invThumbnail = :invThumbnail, invPrice = :invPrice, 
        invStock = :invStock, invColor = :invColor, 
        classificationId = :classificationId WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_STR);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_STR);
    
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

//funciton to delete vehicle from the inventory
function deleteVehicle($invId) {

    $db = phpmotorsConnect();
    $sql = 'DELETE FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);    
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

//create a list of vehicles by classifications
function getVehiclesByClassification($classificationName){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);    
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $vehicles;
   }

function getVehicleById($invId){
    $db = phpmotorsConnect();
    $sql = 'SELECT i.invId, i.invMake, i.invModel, i.invDescription, i.invImage, i.invThumbnail,
    i.invPrice, i.invStock, i.invColor, im.imgName, im.imgPath, im.imgPrimary    
    FROM inventory i INNER JOIN images im ON i.invId = im.invId
    WHERE im.imgPath NOT LIKE "%-tn.%"
    AND im.imgPrimary = 1
    AND i.invId = :invId';
    $stmt = $db->prepare($sql);    
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);    
    $stmt->execute();
    $vehicles = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $vehicles;
}

// Get information for all vehicles
function getVehicles(){
    $db = phpmotorsConnect();
    $sql = 'SELECT invId, invMake, invModel FROM inventory';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
}	
?>