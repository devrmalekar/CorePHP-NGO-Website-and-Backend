<?php
/**
 * Created by PhpStorm.
 * User: rmalekar
 * Date: 10/4/15
 * Time: 1:51 PM
 */
session_start();
define("DiskRoot", $_SERVER['DOCUMENT_ROOT']);


if(!isset($_SESSION["username"]) && empty($_SESSION["username"])) {
    $protocol=(@$_SERVER["HTTPS"] == 'on')? 'https://': 'htpp://';
    $returnUrl = $protocol.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];
    header("location: ../../Auth/index.php?returnurl=".$returnUrl);
}

if(!class_exists("dbFunction")) { include_once(DiskRoot."/Controller/dbFunction.php"); }
if(!class_exists("FileUploadClass")) { include_once(DiskRoot."/Controller/FileUploadClass.php");}
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

<?php
include_once('header.php');
?>

<div class="container"  style="margin: 7%;">
    <div class="row dashboard-row">
        <div class="col-lg-3">
            <div class="thumbnail gallery-thumbnail dashboard">
                    <a href="/cms/Events/New/index.php"><img class="img-responsive fitImg dashboard-img" src="/cms/assets/images/new%20evnets.png" alt="New Activities"/></a>
                    <div class="caption dashboard-caption"><a href="/cms/Events/New/index.php"><span class="label label-info span4">New Activities</a></span></div>
                    <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="thumbnail gallery-thumbnail dashboard">
                <a href="/cms/Events/Update/index.php"><img class="img-responsive fitImg dashboard-img"  src="/cms/assets/images/update%20events.png" alt="Update Activities"/></a>
                <div class="caption dashboard-caption"><a href="/cms/Events/Update/index.php"><span class="label label-info span4">New Activities</a></span></div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="thumbnail gallery-thumbnail dashboard">
                <a href="/cms/slideshow/index.php"><img class="img-responsive fitImg dashboard-img"  src="/cms/assets/images/slideshow.png" alt="Parent Slide Show"/></a>
                <div class="caption dashboard-caption"><a href="/cms/slideshow/index.php"><span class="label label-info span4">Parent SlideShow</a></span></div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="thumbnail gallery-thumbnail dashboard">
                <a href="/cms/slideshow/ech-slideshow-img.php"><img class="img-responsive fitImg dashboard-img"  src="/cms/assets/images/slideshowech.png" alt="Sister Slide Show"/></a>
                <div class="caption dashboard-caption"><a href="/cms/slideshow/ech-slideshow-img.php"><span class="label label-info span4">Sister SlideShow</a></span></div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="row dashboard-row">
        <div class="col-lg-3">
            <div class="thumbnail gallery-thumbnail dashboard">
                <a href="/cms/Events/addGallery.php"><img class="img-responsive fitImg dashboard-img" src="/cms/assets/images/gallery.png" alt="New Gallery"/></a>
                <div class="caption dashboard-caption"><a href="/cms/Events/addGallery.php"><span class="label label-info span4">Edit Gallery</a></span></div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="thumbnail gallery-thumbnail dashboard">
                <a href="/cms/slideshow/ech-slideshow-img.php"><img class="img-responsive fitImg dashboard-img"  src="/cms/assets/images/volunteer.png" alt="Volunteer List"/></a>
                <div class="caption dashboard-caption"><a href="/cms/slideshow/ech-slideshow-img.php"><span class="label label-info span4">Volunteer List</a></span></div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="thumbnail gallery-thumbnail dashboard">
                <a href="/cms/AboutUs/index.php"><img class="img-responsive fitImg dashboard-img"  src="/cms/assets/images/aboutus.png" alt="Edit About US"/></a>
                <div class="caption dashboard-caption"><a href="/cms/AboutUs/index.php"><span class="label label-info span4">Edit About US</a></span></div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/cms/assets/js/vendor/jquery-1.11.3.min.js"><\/script>')</script>
<script type="text/javascript" src="/cms/assets/js/bootstrap.min.js"></script>
<script src="/cms/assets/js/jquery-2.1.4.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="/cms/assets/js/bootstrap-typeahead.js"></script>
<script src="/cms/assets/js/main.js"></script>


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