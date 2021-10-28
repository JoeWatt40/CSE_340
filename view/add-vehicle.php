<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors Add Vehicle</title>
    <link rel="stylesheet" href="/phpmotors/css/main.css" media="screen">
    <link rel="stylesheet" href="/phpmotors/css/vehicle.css" media="screen">
</head>

<body>
    
    <div class="content">
        <header>

            <div class="header">
                <img src="/phpmotors/images/site/logo.png" alt="php motors logo">
                <h1><a href="/phpmotors/accounts/index.php?action=login">My Account</a></h1>
            </div>             
            
            <nav>
                <?php echo $navList; ?>
            </nav>

        </header>

        <main>
        
            <h1>Add Vehicle</h1>

            <?php
                if (isset($message)) {
                echo $message;
                }
            ?>

            <form action="/phpmotors/vehicles/index.php" method="POST">
            
                <label>Classification:</label><br>
                <?php echo $classificationList ?><br>
                <label for="invMake">Make:</label><br>
                <input type="text" id="invMake" name="invMake"><br>
                <label for="invModel">Model:</label><br>
                <input type="text" id="invModel" name="invModel"><br>
                <label for="invDescription">Description:</label><br>
                <textarea id="invDescription" name="invDescription"></textarea><br>
                <label for="invImage">Image:</label><br>
                <input type="text" id="invImage" name="invImage" value="/images/no-image.png"><br>
                <label for="invThumbnail">Image Thumbnail:</label><br>
                <input type="text" id="invThumbnail" name="invThumbnail" value="/images/no-image.png"><br>
                <label for="invPrice">Price:</label><br>
                <input type="number" id="invPrice" name="invPrice"><br>
                <label for="invStock">Stock:</label><br>
                <input type="number" id="invStock" name="invStock"><br>
                <label for="invColor">Color:</label><br>
                <input type="text" id="invColor" name="invColor"><br>
                <input type="submit" value="Add Vehicle">
                <input type="hidden" name="action" value="addCar">

            </form>
        </main>
        
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php';?>
        </footer>
    </div>

    <script src="../js/footer.js"></script>
</body>
</html>