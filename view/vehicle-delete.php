<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /phpmotors/');
 exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
	    echo "Delete $invInfo[invMake] $invInfo[invModel]";} 
	    elseif(isset($invMake) && isset($invModel)) { 
		echo "Delete $invMake $invModel"; }?> | PHP Motors</title>
    <link rel="stylesheet" href="/phpmotors/css/main.css" media="screen">
    <link rel="stylesheet" href="/phpmotors/css/vehicle.css" media="screen">
</head>

<body>
    
    <div class="content">
        <header> 
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/header.php';?>
        </header>            
            
        <nav>
            <?php echo $navList; ?>
        </nav>

        <main>
        
        <h1><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
            echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
            elseif(isset($invMake) && isset($invModel)) { 
            echo "Modify$invMake $invModel"; }?>
        </h1>

            <?php
                if (isset($message)) {
                echo $message;
                }
            ?>

            <form action="/phpmotors/vehicles/index.php" method="POST">
            
                <label>Classification:</label><br>
                <?php echo $classificationList ?><br>
                <label for="invMake">Make:</label><br>
                <input type="text" name="invMake" id="invMake" readonly<?php if(isset($invMake)){ echo "value='$invMake'"; } elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>><br>
                <label for="invModel">Model:</label><br>
                <input type="text" name="invModel" id="invModel"  readonlu<?php if(isset($invModel)){ echo "value='$invModel'"; } elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?>><br>
                <label for="invDescription">Description:</label><br>
                <textarea id="invDescription" name="invDescription" readonly>
                    <?php if(isset($invDescription)){ echo $invDescription; } elseif(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }?></textarea><br>
                <input type="submit" value="Delete Vehicle">
                <input type="hidden" name="action" value="deleteVehicle">
                <input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])){
                    echo $invInfo['invId'];} ?>">  
            </form>
        </main>
        
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php';?>
        </footer>
    </div>

</body>
</html>