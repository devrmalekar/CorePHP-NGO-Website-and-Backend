<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/8/15
 * Time: 8:26 PM
 */
if(!class_exists("dbFunction")){ include_once($_SERVER['DOCUMENT_ROOT'] ."/Controller/dbFunction.php"); }
$dbFunction = new dbFunction();
$eventID="";
if($_SERVER["REQUEST_METHOD"]=="POST") {
    $eventID = filter_input(INPUT_POST, "eventId");
} else if ($_SERVER["REQUEST_METHOD"]=="GET"){
    $eventID = filter_input(INPUT_GET, "eventId");
}
else {
    header("location:../List");
}
$result = $dbFunction->Select("SP_EventDetails", array("eventID"), array($eventID));
$eventPhotos= $dbFunction->Select("SP_EventPhotos", array("eventID"), array($eventID));
if(count($result) <= 0){
    header("location:../List");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
      <title>parent organization Nepal | <?php echo $result[0]["EventTitle"]; ?></title>
<link rel="shortcut icon" href="/assets/images/logo.png" />
    
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
    <script src="/assets/js/this_main.js"></script>
    <script src="/assets/js/mainslider.js"></script>
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
<?php  require($_SERVER['DOCUMENT_ROOT'] . '/ECH/header.php'); ?>
<div class="white">
    <div class="center">
        <div class="row">
            <div class="heading"><p class="text6"><?php echo $result[0]["EventTitle"]; ?></p></div>
        </div>
<?php if(count($eventPhotos) > 0) { ?>
        <div id="jssor_1">
            <!-- Loading Screen -->
            <div id="loading" data-u="loading">
                <div id="loading1"></div>
                <div id="loading2"></div>
            </div>
            <div id="mainslide" data-u="slides">
                <?php foreach($eventPhotos as $img) { ?>
                    <div data-p="112.50" style="display: none;">
                        <img data-u="image" src="<?php echo $img['EventPhotoURL']; ?>" />
                    </div>
                <?php } ?>

                <!-- Bullet Navigator -->
                <div data-u="navigator" class="jssorb01" style="bottom:16px;right:10px;">
                    <div data-u="prototype" style="width:12px;height:12px;"></div>
                </div>
                <!-- Arrow Navigator -->
                <span data-u="arrowleft" class="jssora02l" style="top:123px;left:8px;width:55px;height:55px;" data-autocenter="2"></span>
                <span data-u="arrowright" class="jssora02r" style="top:123px;right:8px;width:55px;height:55px;" data-autocenter="2"></span>
                <a href="http://www.jssor.com" style="display:none">Jssor Slider</a>
            </div>
        </div>
<?php } ?>
        <div class="eventdetails">
            <div class="details" >
                <p class="text7"><?php echo nl2br($result[0]["EventDesc"]); ?></p></div>
        </div>

    </div>
    <?php require($_SERVER['DOCUMENT_ROOT'].'/sidebar.php'); include_once($_SERVER['DOCUMENT_ROOT'].'/footer.php');?>
</div>
</body>
</html>