<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
	    echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
	    elseif(isset($invMake) && isset($invModel)) { 
		echo "Modify $invMake $invModel"; }?> | PHP Motors</title>
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
                <input type="text" name="invMake" id="invMake" required <?php if(isset($invMake)){ echo "value='$invMake'"; } elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>><br>
                <label for="invModel">Model:</label><br>
                <input type="text" id="invModel" name="invModel" required <?php if(isset($invModel)){echo "value='$invModel'";}  ?>><br>
                <label for="invDescription">Description:</label><br>
                <textarea id="invDescription" name="invDescription" required>
                    <?php if(isset($invDescription)){ echo $invDescription; } elseif(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }?></textarea><br>
                <label for="invImage">Image:</label><br>
                <input type="text" id="invImage" name="invImage" value="/images/no-image.png" required <?php if(isset($invImage)){echo "value='$invImage'";}  ?>><br>
                <label for="invThumbnail">Image Thumbnail:</label><br>
                <input type="text" id="invThumbnail" name="invThumbnail" value="/images/no-image.png" required <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";}  ?>><br>
                <label for="invPrice">Price:</label><br>
                <input type="number" id="invPrice" name="invPrice" required <?php if(isset($invPrice)){echo "value='$invPrice'";}  ?>><br>
                <label for="invStock">Stock:</label><br>
                <input type="number" id="invStock" name="invStock" required <?php if(isset($invStock)){echo "value='$invStock'";}  ?>><br>
                <label for="invColor">Color:</label><br>
                <input type="text" id="invColor" name="invColor" required <?php if(isset($invColor)){echo "value='$invColor'";}  ?>><br>
                <input type="submit" value="Update Vehicle">
                <input type="hidden" name="action" value="updateVehicle">

            </form>
        </main>
        
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php';?>
        </footer>
    </div>

</body>
</html>