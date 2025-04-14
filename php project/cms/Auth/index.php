<?php
/**
 * Created by PhpStorm.
 * User: rmalekar
 * Date: 7/29/15
 * Time: 11:42 AM
 */
//error_reporting(0);
session_start();

if(isset($_SESSION["username"]) && !empty($_SESSION["username"])){
    header("location:../index.php");
}


if (!class_exists("AuthenticationController")) { include('../../Controller/AuthenticationController.php'); }

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $recaptcha=filter_input(INPUT_POST, "g-recaptcha-response");
    include_once("../../Controller/dbFunction.php");
    $dbFunction = new dbFunction();
    $return = $dbFunction->validateReCaptcha($recaptcha);

    if($return == 'success') {
        $username = filter_input(INPUT_POST, "form-username");
        $password = filter_input(INPUT_POST, "form-password");

       /* $options = [
            'cost' => 11,
            'salt' => sha1($password),
        ];
        $password = password_hash($password, PASSWORD_BCRYPT, $options);*/
        $auth = new AuthenticationController($username, $password);
        $error_msg = $auth->checkAuthentication();

        $return_url = urldecode(filter_input(INPUT_GET, "returnurl", FILTER_DEFAULT));
        if(is_null($error_msg)){
            if(isset($return_url) && !empty($return_url)){
                $return_url = "location:".$return_url;//.".php";
                header($return_url);
            }
            else {
                header("location: ../index.php");
            }

        }
    } else {
        $error_msg=$return;
    }

}
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>

    <link href="/cms/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/cms/assets/fonts/font-awesome/css/font-awesome.min.css">
    <link href="/cms/assets/css/customstyle.css" rel="stylesheet">
</head>
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Top content -->
<div class="top-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1><label style="color: #030303">Welcome to Content Mangement System.<br />parent organization Nepal</label></h1>
                    <div class="description">
                        <p>
                            <label style="color: #030303">
                            Please Log in using your <strong>Parent CMS </strong> Username and Password</label>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3>Login to our site</h3>
                            <p>Enter your username and password to log on:</p>
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-key"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <form role="form" action="#" method="post" class="login-form">
                            <?php if(isset($error_msg) && !empty($error_msg)) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error:</span>
                                    <?php echo $error_msg; ?>
                                </div>
                            <?php } ?>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input type="text" required="true" name="form-username" placeholder="Username..." class="form-username form-control" id="form-username">
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input type="password" required="true" name="form-password" placeholder="Password..." class="form-password form-control" id="form-password">
                            </div>
                            <div class="row">
                                <div class="col-sm-offset-2 col-sm-8">
                                    <?php include_once($_SERVER['DOCUMENT_ROOT']."/recaptcha.php"); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-offset-5 col-sm-8">
                                    <input type="submit" name="login" class="btn btn-success" value="Sign in!" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.3.min.js"><\/script>')</script>
<script type="text/javascript" src="/cms/assets/cms/assets/js/bootstrap.min.js"></script>

<script src="/cms/assets/assets/js/jquery-2.1.4.min.js"></script>

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
    (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='https://www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
    ga('create','UA-XXXXX-X','auto');ga('send','pageview');
</script>
</body>
</html>