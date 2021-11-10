<div class="header">
    <img src="/phpmotors/images/site/logo.png" alt="php motors logo">
    <?php if(isset($_SESSION['loggedin'])){         
            echo "<h1><a href='/phpmotors/accounts/index.php?action=vehicle'>{$_SESSION['clientData']['clientFirstname']}</a> | <a href='/phpmotors/accounts?action=Logout'>Logout</a></h1>";
        } else {
            echo "<h1><a href='/phpmotors/accounts/index.php?action=login'>My Account</a></h1>";
        }            
      ?>     
</div>             