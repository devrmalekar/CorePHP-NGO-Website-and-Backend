<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/9/15
 * Time: 6:33 PM
 */

if(!class_exists("dbFunction")){ include_once("../../Controller/dbFunction.php"); }
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $fname = filter_input(INPUT_POST, "fname");
    $lname = filter_input(INPUT_POST, "lname");
    $addr = filter_input(INPUT_POST, "contactaddr");
    $email = filter_input(INPUT_POST, "email");
    $phone = filter_input(INPUT_POST, "phone");
    $reason = filter_input(INPUT_POST, "reason");

    $dbFunction = new dbFunction();
    $dbFunction->Insert("SP_NewVolunteer", array("fname","lname","addr","phone","email","reason","sstatus"),
        array($fname, $lname, $addr, $email, $phone, $reason, "Not Approved"));
    $_POST=array();
    $_SERVER["REQUEST_METHOD"] = null;
    header("location:index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head lang="en"><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    
    <title>parent organization Nepal | Get Involved as a Volunter</title>
    <link rel="shortcut icon" href="/assets/images/logo.png" />
    <title>parent organization Nepal | Volunteer</title>
    
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/reset.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/style.css" />
    <link href='http://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/grid_12.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/slider.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/form.css" />
    <script type="text/javascript" src="/assets/js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="/assets/js/tabs.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Condiment' rel='stylesheet' type='text/css' />
    <link href='http://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css' />
    <script src="/assets/js/jquery-1.7.min.js"></script>
    <script src="/assets/js/jquery.easing.1.3.js"></script>
    <script src="/assets/js/tms-0.4.x.js"></script>
    <script src="assets/js/this_main.js"></script>

    <!--[if lt IE 8]>
    <div style=' clear: both; text-align:center; position: relative;'>
        <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
            <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
        </a>
    </div>
    <![endif]-->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/assets/js/html5.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/ie.css">
    <![endif]-->

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/fonts/font-awesome/css/font-awesome.min.css">
</head>
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/header.php');
?>
<div class="white">
<div class="center">
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/GetInvolved/Volunter/form.php"); ?>
</div>
<?php require($_SERVER['DOCUMENT_ROOT'].'/sidebar.php'); include_once($_SERVER['DOCUMENT_ROOT'].'/footer.php');?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/assets/js/vendor/jquery-1.11.3.min.js"><\/script>')</script>
<script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/js/main.js"></script>
<script src="/assets/js/bootstrap-typeahead.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>

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