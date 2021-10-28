<?php
 
if (isset($_GET["email"])) {
    if (!filter_input(INPUT_GET, "email", FILTER_VALIDATE_EMAIL) === false) {
        echo("Valid Email");
    } else {
        echo("Invalid Email");
    }
}

?>

<form action="teach.php" method="GET">
    <input type="text" name="email" id="email">
    <input type="submit" value="Submit">
</form>
