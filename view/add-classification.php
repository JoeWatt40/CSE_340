<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors Add Classification</title>
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
        
            <h1>Add Vehicle Classification</h1>

            <?php
                if (isset($message)) {
                echo $message;
                }
            ?>

            <form action="/phpmotors/vehicles/index.php" method="POST">
                <label for="classificationName">New Classification Name:</label><br>
                <p>(Max size: 30)</p>
                <input type="text" id="classificationName" name="classificationName" maxlength="30" focus required><br>                
                <input type="submit" name="submit" id="regbtn" value="Add Classification"> 
                <input type="hidden" name="action" value="addClass">
            </form>

        </main>
        
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php';?>
        </footer>
    </div>

</body>
</html>