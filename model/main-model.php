<?php //main PHP Motors model

function getClassifications(){

    // Create a connection object from the phpmotors connection function
    $db = phpmotorsConnect(); 
    $sql = 'SELECT * FROM carclassification ORDER BY classificationName ASC';     
    $stmt = $db->prepare($sql);
    $stmt->execute(); 
    $classifications = $stmt->fetchAll(); 
    $stmt->closeCursor(); 
    
    // returns array of classification name 
    return $classifications;
   }

?>
