<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/8/15
 * Time: 11:44 PM
 */
$msg='';
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $recaptcha=filter_input(INPUT_POST, "g-recaptcha-response");
    if(!empty($recaptcha))
    {
        include("getCurlData.php");
        $google_url="https://www.google.com/recaptcha/api/siteverify";
        $secret='6LcgbA4TAAAAAPKCgxMmIYWiec3LFXuXQgyIq6s9';
        $ip=$_SERVER['REMOTE_ADDR'];
        $url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
        print_r($url);
        $res=getCurlData($url);
        $res= json_decode($res, true); print_r($res);
//reCaptcha success check
        if($res['success'])
        {
//Include login check code
        }
        else
        {
            $msg="Please re-enter your reCAPTCHA.";
        }

    }
    else
    {
        $msg="Please re-enter your reCAPTCHA.";
    }
    echo $msg;
} else {
    header("location: index.php");
}