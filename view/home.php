<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors Home Page</title>
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
        
            <h1>Welcome to PHP Motors</h1>

            <div class="welcome">            
                <ul>
                    <li>DMC Delorean</li>
                    <li>3 Cup Holders</li>
                    <li>Superman doors</li>
                    <li>Fuzzy Dice!</li>
                </ul>

                <div class="order">
                    <img class="own" src="/phpmotors/images/site/own_today.png" alt="own today image">
                    <img class="car" src="/phpmotors/images/delorean.jpg" alt="delorean image">
                </div>              
            </div>

            <div class="info">                
                <div class="reviews">
                    <h2>DMC Delorean Reviews</h2>                
                    <ul>
                        <li>"So fast its almost like traveling in time." (4/5)</li>
                        <li>"Coolest ride on the road." (4/5)</li>    
                        <li>"I'm feeling Marty Mcfly!" (5/5)</li>
                        <li>"The most futuristic ride of our day." (4.5/5)</li>
                        <li>"80's livin and I love it!" (5/5)</li>
                    </ul>
                </div>                
                           
                <div class="upgrades">
                    <h2>Delorean Upgrades</h2> 
                    <ul>
                        <li><img src="/phpmotors/images/upgrades/flux-cap.png" alt="flux capacitor"><label>Flux Capacitor</label></li>
                        <li><img src="/phpmotors/images/upgrades/flame.jpg" alt="flames"><label>Flame Decals</label></li>
                        <li><img src="/phpmotors/images/upgrades/bumper_sticker.jpg" alt="bumper sticker"><label>Stickers</label></li>
                        <li><img src="/phpmotors/images/upgrades/hub-cap.jpg" alt="hub caps"><label>Caps</label></li>
                    </ul>                
                </div>
            </div>

        </main>
        
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php';?>
        </footer>
    </div>

    <script src="/phpmotors/js/footer.js"></script>
</body>
</html>
