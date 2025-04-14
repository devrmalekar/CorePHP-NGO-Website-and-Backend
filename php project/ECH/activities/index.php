<?php
    if(!class_exists("dbFunction")) { include_once($_SERVER['DOCUMENT_ROOT']."/Controller/dbFunction.php"); }
    header("Content-Type:text/html; charset=utf-8");
    $dbFunction = new dbFunction();
    $allEventData = $dbFunction->Select("SP_ListAllEvents", array("eventType"), array("ECH"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>parent organization Nepal | Activities</title>
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
    <script src="/assets/js/jquery.bootpag.min.js"></script>
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
<?php  require($_SERVER['DOCUMENT_ROOT'] . '/ECH/header.php'); ?>
<div class="white"><div class="center">
        <?php include_once("listactivities.php"); ?>
    </div>
    <?php require($_SERVER['DOCUMENT_ROOT'].'/sidebar.php'); include_once($_SERVER['DOCUMENT_ROOT'].'/footer.php');?>
</div>

<script>
    // init bootpag
    initBootPag(<?php echo $countSection; ?>);
</script>
</body>
</html>
