<?php
    if(!class_exists("dbFunction")) { include_once($_SERVER['DOCUMENT_ROOT']."/Controller/dbFunction.php"); }
    header("Content-Type:text/html; charset=utf-8");
    $dbFunction = new dbFunction();
    $album = $dbFunction->Select("SP_GalleryAlbumCol", array("eventType"), array("ECH"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>parent organization Nepal | Gallery</title>
    <meta charset="utf-8" />
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
        <div class="row">
            <div class="heading"><p class="text6">Memory We Shared</p></div>
            <div class="galleryAlbum">
                <div class="yellow">
                    <?php $countSection=0; $totalEvent=count($album); for($i=0; $i<$totalEvent; ){ if($i % 6 == 0) {
                        if ($i==0) { echo '<section id="section-'.$countSection++.'" class="galleryList active">'; } else { echo '<section id="section-'.$countSection++.'" class="galleryList">'; }} ?>
                        <div class="left">
                            <div class="galleryAlbum album">
                                <div class="gallerythump">
                                    <div class="thumbnail">
                                        <a href="javascript:void(0)" onclick="redirectMemory(<?php echo $album[$i]["id"]; ?>);"><img class="thumbnailimg"  src="<?php if(isset($album[$i]["EventPhotoURL"]) && !empty($album[$i]["EventPhotoURL"])) {
                                                echo $album[$i]["EventPhotoURL"];} else { ?>/assets/images/noimage.png<?php } ?>"
                                                        allign="left" alt="<?php echo $album[$i]["EventTitle"]; ?>"></a>
                                        <form action="memory.php" method="POST" id="<?php echo "memory-".$album[$i]["id"]; ?>">
                                            <input type="hidden" name="eventID" value="<?php echo $album[$i]["id"]; ?>" />
                                            <input type="hidden" name="eventName" value="<?php echo $album[$i]["EventTitle"]; ?>" />
                                        </form>
                                    </div>
                                </div>
                                <div class="heading"><p class="text7"><?php echo $album[$i++]["EventTitle"]; ?></p></div>
                            </div>
                        </div>
                        <?php if($i % 6 == 0) {  echo '</section>'; } } ?>
                </div>
            </div>

            <?php if($countSection > 0) { ?>
                <div id="page-selection">
                    <ul class="pagination bootpag">
                        <li data-lp="1" class="first disabled"><a href="javascript:void(0);"><span aria-hidden="true">←</span></a></li>
                        <li data-lp="1" class="prev disabled"><a href="javascript:void(0);">«</a></li>
                        <?php for($i=0; $i <= $countSection; $i++){ ?>
                            <li data-lp="<?php echo $i; ?>" class="<?php if($i==0) echo 'active'; else echo ''; ?>"><a href="javascript:void(0);"><?php echo $i; ?></a></li>
                        <?php } ?>
                        <li data-lp="6" class="next"><a href="javascript:void(0);">»</a></li>
                        <li data-lp="50" class="last"><a href="javascript:void(0);"><span aria-hidden="true">→</span></a></li>
                    </ul>
                </div>
            <?php } ?>
        </div>
        <div class="clear"></div>
        <div class="linr"></div>
        <div class="clear"></div>
        <div class="footer">
            <div class="copy">parent organization Nepal © 2015  |  Privacy Policy </div>
            <div class="vlinks"><a href="">Idyllic Cloud</a></div>
        </div>

    </div></div>

<script>
    // init bootpag
    initBootPag(<?php echo $countSection; ?>);
</script>
</body>
</html>
