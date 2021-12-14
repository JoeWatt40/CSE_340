<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $vehicles['invMake'] ?>   <?php echo $vehicles['invModel']?></title>
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

        <?php if(isset($message)){
                echo $message; }
            ?>
            
        <main>
            
            <form>
                <textarea name="reviewText" id="reviewText" rows="10" cols="50"><?php if(isset($reviewText)) { echo $reviewText;}?></textarea>
                <input type="hidden" name="action" value="edit"><br>
                <input type="submit" value="Update Review">
            </form>
        </main>
        
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php';?>
        </footer>
    </div>

</body>
</html>