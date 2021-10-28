<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors Login Page</title>
    <link rel="stylesheet" href="/phpmotors/css/main.css" media="screen">
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
        
            <h1>Sign In</h1>

            <?php
                if (isset($message)) {
                echo $message;
                }
            ?>

            <form action="/phpmotors/accounts/index.php" method="post">
                <label for="clientEmail">Email:</label><br>
                <input type="email" id="clientEmail" name="clientEmail" required autofocus <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?>><br>
                <label for="clientPassword">Password:</label><br>
                <input type="text" id="clientPassword" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"> 
                <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span><br>
                <input type="hidden" name="action" value="Login">
                <input type="submit" value="Login">         
            </form>

            <a href="/phpmotors/accounts/index.php?action=Register">Not registered yet??</a>
           
        </main>
        
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php';?>
        </footer>
    </div>

    <script src="../js/footer.js"></script>
</body>
</html>