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
    <title>PHP Motors Update Account</title>
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
        
            <h1>Update your account information below</h1>

            <?php if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];}?>
    
            <form action="/phpmotors/accounts/index.php" method="POST">
                <fieldset>
                    <legend>Update Account</legend>
                    <label for="clientFirstname">First Name</label><br>
                    <input type="text" id="clientFirstname" name="clientFirstname" required value="<?php echo $_SESSION['clientData']['clientFirstname']; ?>"><br>
                    <label for="clientLastname">Last Name:</label><br>
                    <input type="text" id="clientLastname" name="clientLastname" required value="<?php echo $_SESSION['clientData']['clientLastname']; ?>"><br> 
                    <label for="clientEmail">Email:</label><br>
                    <input type="email" id="clientEmail" name="clientEmail" required value="<?php echo $_SESSION['clientData']['clientEmail']; ?>" ><br>
                    <input type="submit" name="submit" id="updatebtn" value="Update Account Information"> 
                    <input type="hidden" name="action" value="updateAccount">
                    <input type="hidden" name="clientId" value="
                    <?php echo $_SESSION['clientData']['clientId']; ?>">
                </fieldset>
            </form>

            <form action="/phpmotors/accounts/index.php" method="POST">
                <fieldset>
                    <legend>Change Your Current Password</legend>
                    <input type="password" name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                    <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span><br>
                    <input type="submit" name="submit" id="passbtn" value="Change Your Password"> 
                    <input type="hidden" name="action" value="updatePassword">
                    <input type="hidden" name="clientId" value="
                    <?php echo $_SESSION['clientData']['clientId']; ?>">
                </fieldset>
            </form>


        </main>
        
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php';?>
        </footer>
    </div>

</body>
</html>
