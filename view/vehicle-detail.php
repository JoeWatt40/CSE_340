<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $vehicles['invMake'] ?>   <?php echo $vehicles['invModel']?></title>
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

            <?php if(isset($message)){
                echo $message; }
            ?>

            <div class="detail">
                <?php if(isset($vehicleDetailDisplay)){
                    echo $vehicleDetailDisplay;}
                ?>

                <h1>Vehicle Reviews Below</h1>
                <h2>Customer Reviews</h2>

                <?php if (isset($_SESSION['loggedin'])) {                        
                    echo '<form action="/phpmotors/reviews/index.php" method="post">
                        <textarea name="review" id="review" rows="10" cols="50" placeholder="Add a review here" required></textarea><br>
                        <input type="hidden" name="reviewId" id="reviewId" value="reviewId">
                        <input type="hidden" name="action" value="add">
                        <input type="submit" value="Submit Review">
                        </form>';
                    } else { 
                        echo "<a href='/phpmotors/reviews/index.php?action=login'>Login to add a review</a>";}          
                ?>
                   
                
            </div>            

        </main>
        
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php';?>
        </footer>
    </div>

</body>
</html>