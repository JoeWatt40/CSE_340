<?php 
    if(!isset($_SESSION['loggedin'])){
        header('Location: /phpmotors/');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors Admin View</title>
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
        
            <h1>Welcome to PHP Motors</h1>

            <?php if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];}?>

            <h3><a href="/phpmotors/accounts/index.php?action=update">Update Account Information</a></h3>
            
            <?php 
                if($_SESSION['clientData']['clientLevel'] > 1 ) {
                    echo "<h3>Click on the link below to manage vehicle inventory.</h3>";
                    echo "<p><a href='/phpmotors/vehicles/index.php?action=vehicle'>Vehicle Management</a></p>"; 
                }
            ?>
           
        </main>
        
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php';?>
        </footer>
    </div>

</body>
</html>
