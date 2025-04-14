<?php
/**
 * Created by PhpStorm.
 * User: devrem@email.com
 * Date: 1/10/15
 * Time: 8:15 AM
 */
if(!class_exists("dbFunction")) { include_once("Controller/dbFunction.php"); }
header("Content-Type:text/html; charset=utf-8");
$dbFunction = new dbFunction();
$RecentActivities = $dbFunction->Select("SP_RecentEvent", array("eventType"), array("Parent"));

$slideshow = $dbFunction->Select("SP_ListSlideShowImg",  array("eventType"), array("Parent"));

$aboutParent = $dbFunction->Select("SP_SelectAbout", array("id"), array(1));

$address = $aboutParent[0]["PostalAddress"];
$phone = $aboutParent[0]["TelePhone"];
$email =$aboutParent[0]["Email"];

$aboutSister = $dbFunction->Select("SP_GetEchDetail", array(), array());
$ourobj = $dbFunction->Select("SP_OurObjectives", array("otype"), array('Parent'));

$album = $dbFunction->Select("SP_GalleryAlbumCol", array("eventType"), array("Parent"));

try{
    $data_eventDetail = $dbFunction->Select("SP_ListEventDetails",array("id"), array(0));
    $jsonData_eventDetail = json_encode($data_eventDetail,JSON_HEX_QUOT| JSON_HEX_TAG| JSON_HEX_AMP| JSON_HEX_APOS| JSON_NUMERIC_CHECK| JSON_PRETTY_PRINT| JSON_UNESCAPED_SLASHES| JSON_PRESERVE_ZERO_FRACTION| JSON_UNESCAPED_UNICODE| JSON_PARTIAL_OUTPUT_ON_ERROR); /*Event Detais*/
} catch (Exception $ex){
    print_r("Somethine went wrong. Sorry For inoc"); exit;
}
//print_r($galleryAlbum); exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title>parent organization | Home</title>
    
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/reset.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/style.css" />
    <link href='http://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/grid_12.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/slider.css" />
    <script type="text/javascript" src="/assets/js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="/assets/js/tabs.js"></script>
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
    <script type="text/javascript" src="/assets/js/html5.js"></script>
    
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/ie.css">
    <![endif]-->
</head>
<body>
<?php  require($_SERVER['DOCUMENT_ROOT'] . '/header.php'); ?>
 <div class="white">
     <div class="center home-center">
         <div class="vision">
         </div>
         <div id="jssor_1">
             <!-- Loading Screen -->
             <div id="loading" data-u="loading">
                 <div id="loading1"></div>
                 <div id="loading2"></div>
             </div>
             <div id="mainslide" data-u="slides">
                 <?php foreach($slideshow as $img) { ?>
                     <div data-p="112.50" style="display: none;">
                         <img data-u="image" src="<?php echo $img['slideshowImgUrl']; ?>" />
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
             
             <div class="main">
            <div class="one">
                <p class="text2">Donate Money!</p><br />
                <p class="text3">Even You Are Away From Us You Can Always Help Us Donating For Our Social Activities. </p><br />
                <p class="text4" style="text-align: left;"><a href="/donate/index.php">Learn More</a></p>

            </div>
            <div class="two">
                <iframe width="290" height="200" src="https://www.youtube.com/embed/exy">
                </iframe>
                <p class="text4">Story 2</p>
            </div>
            <div class="three">
                <p class="text5">Get Involved!</p><br />
                <p class="text3">&nbsp; &nbsp;&nbsp;Together We Can Do Something!</p>
                <br /><br/>
                <p class="text4"><a target="_blank" href="">Apply For Volunter</a></p>
            </div>
        </div>
        <div class="clear"></div>
        <div class="line">
            <div class="one1"></div>
            <div class="two2"></div>
            <div class="three3"></div>
        </div>
        <div class="content">
            <div class="who">
                <p class="text6">Who We Are</p><br />
                <p class="text7"><?php echo substr($aboutParent[0]["WhoWeAre"],0,450)."..."; ?>
                </p><br />
                <p><a  href="/aboutus/" ><img src="/assets/images/03.png" alt="" /></a></p>
            </div>
            <div class="what"><p class="text6">What We Do</p><br />
                <ul class="yellow">
                    <?php $count=1; foreach($ourobj as $objective) { if($count++>2) { break; }
                        echo '<li><p class="text7"> '.$objective["objective"].'</p></li><br />';
                    }?>
                </ul><br />
                <p><a href="/activities/index.php"><img src="/assets/images/03.png" alt="" /></a></p>
            </div>
            <div class="where">
                <p class="text6">Gallery</p><br />
                <p class="text7">Some Of The Moments Of Parent Org.</p>
                <p><img src="<?php echo $album[rand(0, count($album)-1)]['EventPhotoURL']; ?>" style="width: 299px; height: 158px;" alt="" /></p><br />
                <p class="text9"></p><br /><br />
                <p><a  href="/Gallery/index.php"><img src="/assets/images/03.png" alt="" /></a></p>
            </div>
        </div>
        <div class="clear"></div>
         <div class="linr"></div>

         <div id="recentActivities">
             <div class="heading"><p class="text6">Recent Activities</p></div>
             <nav>
                 <ul class="yellow">
                     <?php $countSection=0; $totalEvent=count($RecentActivities); for($i=0; $i<4; ){ if($i % 4 == 0) {
                         if ($i==0) { echo '<section id="section-'.$countSection++.'" class="eventList active">'; } else { echo '<section id="section-'.$countSection++.'" class="eventList">'; }} ?>
                         <div class="left">
                             <li>
                                 <div class="heading"><p class="text7"><?php echo $RecentActivities[$i]["EventTitle"]; ?></p></div>
                                 <div class="eventthump">
                                     <div class="thumbnail">
                                         <a href=""><img class="thumbnailimg"  src="<?php if(isset($RecentActivities[$i]["img"]) && !empty($RecentActivities[$i]["img"])) {
                                                 echo $RecentActivities[$i]["img"];} else { ?>/assets/images/noimage.png<?php } ?>"
                                                         allign="left" alt="<?php echo $allEventData[$i]["EventTitle"]; ?>"></a>
                                     </div>
                                 </div>
                                 <div class="eventdetails">
                                     <div class="details" >
                                         <p class="text7"><?php echo nl2br(substr($RecentActivities[$i++]["EventDesc"], 0, 120)); ?></p></div>
                                     <!--<p><a target="_blank" href="" class="readmore"><img src="/assets/images/03.png" alt=""></a></p>-->
                                     <form action="/activities/Details/" method="post"><input type="hidden" name="eventId" value="<?php echo $RecentActivities[$i]['id']; ?>" /><button type="submit"  style="background-image: url('/assets/images/03.png')"/> </form>
                                 </div>
                             </li>
                         </div>
                         <?php if($i % 4 == 0) {  echo '</section>'; } } ?>
                 </ul>
                 <div class="viewmore"><a href="/activities/recent.php">View More</a> </div>
             </nav>
         </div>

        <div class="clear"></div>
         <div class="linr"></div>
        <div class="footer">
            <div class="copy">Parent ORg Nepal   </div>
            <div class="vlinks">Designed & Developed by<a target="_blank" href="https://www.facebook.com/IdyllicCloud/">devrem</a></div>
        </div>
     </div>
 </div>
</body>
</html>