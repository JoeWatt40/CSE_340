<?php

    function checkEmail($clientEmail) {
        $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
        return $valEmail;
    }

    function checkPassword($clientPassword){
        $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
        return preg_match($pattern, $clientPassword);
       }

    function navList($classifications) {
        $navList = '<ul class="navigation">';
        $navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
        foreach ($classifications as $classification) {
        $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
        }
        $navList .= '</ul>';
    }
?>