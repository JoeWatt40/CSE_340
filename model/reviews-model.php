<?php 

function addReview($reviewText, $clientId, $invId) {
    $db = phpmotorsConnect();
    $sql = 'INSERT INTO reviews (reviewText, clientId, invId) VALUES (:reviewText, :clientId, :invId)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    // Return the indication of success
    return $rowsChanged;
}

function getReviewByInvId($invId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT reviewId, reviewText, reviewDate, invId FROM reviews WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $vehicleReview = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $vehicleReview;
}

function getReviewByClientId() {

}

function updateReview() {

}

function deleteReview($reviewId) {
    
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);    
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}


?>