<?php
/**
 * Created by PhpStorm.
 * User: devrem@email.com
 * Date: 1/10/15
 * Time: 8:15 AM
 */
if(!class_exists("dbFunction")) { include_once($_SERVER['DOCUMENT_ROOT']."/Controller/dbFunction.php"); }
header("Content-Type:text/html; charset=utf-8");
$dbFunction = new dbFunction();

$aboutMFN = $dbFunction->Select("SP_SelectAbout", array("id"), array(1));
$ourobj = $dbFunction->Select("SP_OurObjectives", array("otype"), array('MFN'));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Munda Foundation Nepal | About Us</title>
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
<div class="white"><div class="center">
        <div class="row"><p class="text6">Who We Are</p><br />
            <p class="text7"><?php echo $aboutMFN[0]["WhoWeAre"]; ?>
            </p><br />
        </div>
        <div class="row">
            <div class="heading"><p class="text6">What We Do</p></div>
            <ul class="yellow">
                <?php foreach($ourobj as $objective) {
                    echo '<li><p class="text7">'.$objective["objective"].'</p></li><br />';
                }?>
            </ul>
            </p>
        </div>
    </div>
<?php require($_SERVER['DOCUMENT_ROOT'].'/sidebar.php'); include_once($_SERVER['DOCUMENT_ROOT'].'/footer.php');?>



</div>
</body>
</html>