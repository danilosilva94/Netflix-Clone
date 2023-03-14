<?php
    require_once("PayPal-PHP-SDK/autoload.php");

    //Api Context
    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'AY_cE-kWy-1T6tONMRjvDpJqf80C-WQiRscrWJr8RrUDxjkE2kDE4pCrd1qGck2Spl4Ce72eashxsdCJ',     // ClientID
            'EGoqg7i73RGRj4IXib6ofIDkGFp6w1u2b6Y9vOBfB6l64lNy6Ju9eAjcZpGnIuHGqtqGDOH1Q-yvwUdN'  // ClientSecret
        )
    );
?>