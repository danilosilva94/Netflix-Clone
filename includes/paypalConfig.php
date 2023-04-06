<?php
    require_once("PayPal-PHP-SDK/autoload.php");

    //Api Context
    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            '',     // ClientID
            ''  // ClientSecret
        )
    );
?>
