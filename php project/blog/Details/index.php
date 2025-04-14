<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/8/15
 * Time: 8:26 PM
 */
if(!class_exists("dbFunction")){ include_once("../../Controller/dbFunction.php"); }
$dbFunction = new dbFunction();
$blogID="";
if($_SERVER["REQUEST_METHOD"]=="POST") {
    $blogID = filter_input(INPUT_POST, "blogId");
} else if ($_SERVER["REQUEST_METHOD"]=="GET"){
    $blogID = filter_input(INPUT_GET, "blogId");
}
else {
    header("location:../List");
}
if(!class_exists("dbFunction")) { include_once($_SERVER['DOCUMENT_ROOT']."/Controller/dbFunction.php"); }
header("Content-Type:text/html; charset=utf-8");
$dbFunction = new dbFunction();
$specificBlog = $dbFunction->Select("SP_SpecificBlog", array('id'), array($blogID));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>parent organization Nepal | <?php echo $specificBlog[0]["blogTitle"]; ?></title>
<link rel="shortcut icon" href="/assets/images/logo.png" />
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/reset.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/style.css" />
    <link href='http://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/grid_12.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/slider.css" />
    <script type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="/js/tabs.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Condiment' rel='stylesheet' type='text/css' />
    <link href='http://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css' />
    <script src="/assets/js/jquery-1.7.min.js"></script>
    <script src="/assets/js/jquery.easing.1.3.js"></script>
    <script src="/assets/js/tms-0.4.x.js"></script>
    <script src="/assets/js/this_main.js"></script>
    <!--[if lt IE 8]>
    <div style=' clear: both; text-align:center; position: relative;'>
        <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
            <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
        </a>
    </div>
    <![endif]-->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="js/html5.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="css/ie.css">
    <![endif]-->
</head>
<body>
<?php  require($_SERVER['DOCUMENT_ROOT'] . '/header.php'); ?>
<div class="white">
    <div class="center">
        <div class="heading blogTitleHeading">
            <p class="text2"><?php echo $specificBlog[0]["blogTitle"]; ?></p>
        </div>
        <div class="blogdetails">
            <div class="details" >
                <p class="text7"><?php echo nl2br(substr($specificBlog[0]["blogMsg"], 0, 120)); ?></p></div>
        </div>
        <div class="blogFooter">
            <span class="text1"><?php echo "Posted By: ".$specificBlog[0]['blogWrittenBy']. "on ".$specificBlog[0]['blogPostedDate']; ?> </span>
        </div>
        <div class="clear"></div>
        <div class="linr"></div>
        <div class="clear"></div>
        <div class="footer">
            <div class="copy">parent organization Nepal � 2015   </div>
            <div class="vlinks">Designed & Developed by<a target="_blank" href="https://www.facebook.com/IdyllicCloud/">Idyllic Cloud</a></div>
        </div>

    </div>
</div>
</body>
</html>