<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/26/15
 * Time: 11:00 AM
 */

require __DIR__.'/PayPal-PHP-SDK/autoload.php';


$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'auth token',
        'auth secret'
    )
);

$apiContext->setConfig(
    array(
        'log.LogEnabled'=>true,
        'log.FileName'=>'Paypal.log',
        'log.LogLevel'=>'FINE'
    )
);