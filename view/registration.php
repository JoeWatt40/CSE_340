<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors Registration Page</title>
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
            
            <h1>Please enter information below to register!</h1>

            <?php
                if (isset($message)) {
                echo $message;
                }
            ?>

            <form action="/phpmotors/accounts/index.php" method="POST">
                <label for="clientFirstname">First Name:</label><br>
                <input type="text" id="clientFirstname" name="clientFirstname" autofocus required <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";}  ?> ><br>
                <label for="clientLastname">Last Name:</label><br>
                <input type="text" id="clientLastname" name="clientLastname" required <?php if(isset($clientLastname)){echo "value='$clientLastname'";}  ?>><br> 
                <label for="clientEmail">Email:</label><br>
                <input type="email" id="clientEmail" name="clientEmail" required placeholder="Enter a valid email address" <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?> ><br>
                <label for="clientPassword">Password:</label><br>                
                <input type="password" name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span><br>
                <input type="submit" name="submit" id="regbtn" value="Register"> 
                <input type="hidden" name="action" value="register">       
            </form>
           
        </main>
        
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php';?>
        </footer>
    </div>

</body>
</html>