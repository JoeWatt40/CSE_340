<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors Vehicle Management</title>
    <link rel="stylesheet" href="/phpmotors/css/main.css" media="screen">
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
        
            <h1>Vehicle Management</h1>

            <ul>
                <li><a href="/phpmotors/vehicles/index.php?action=addClassification">Add Classification</a></li>
                <li><a href="/phpmotors/vehicles/index.php?action=addVehicle">Add Vehicle</a></li>
            </ul>

        </main>
        
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php';?>
        </footer>
    </div>

</body>
</html>