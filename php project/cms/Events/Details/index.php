<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/8/15
 * Time: 8:26 PM
 */
if(!class_exists("dbFunction")){ include_once("../../Controller/dbFunction.php"); }
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

<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Parent</title>
    <link rel="shortcut icon" href="/assets/images/logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/fonts/font-awesome/css/font-awesome.min.css">
    <link href="/assets/css/customstyle.css" rel="stylesheet">
    <link href="/assets/css/no-responsive.css" rel="stylesheet">
    <link href="/assets/css/footer-distributed-with-address-and-phones.css" rel="stylesheet">
</head>
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<?php
include_once('../../header.php');
?>
<div class="container">
    <div class="main-content">
        <div class="row">
            <div class="col-xs-8">
                <div class="row">
                    <div class="section-title page-header">
                        <h3><?php echo $result[0]["EventTitle"]; ?></h3>
                    </div>
                </div>
                <div class="row" id="eventsDetail">
                    <div class="thumbnail gallery-thumbnail">
                        <img class="img-responsive fitImg gallery-img" align="left" src="<?php if(isset($result[0]["img"]) && !empty($result[0]["img"])) {
                            echo $result[0]["img"];} else { ?>/assets/images/noimage.png<?php } ?>"
                             alt="<?php echo $result[0]["EventTitle"]; ?>">
                    </div>
                    <p><?php echo nl2br($result[0]["EventDesc"]); ?></p>
                </div>
                <div class="row">
                    <div class="page-header">
                        <h2>Gallery Photos</h2>
                    </div>
                    <?php for($i=0; $i < count($eventPhotos); ){ ?>
                        <div class="row">
                            <?php for($j=$i; $j<($i+3); $j++){ ?>
                                <div class="thumbnail gallery-thumbnail">
                                    <img class="img-responsive fitImg gallery-img" src="<?php echo $eventPhotos[$j]["EventPhotoURL"]; ?>" />
                                </div>
                            <?php } $i = $i + 3; ?>
                        </div>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-4"><?php include_once($_SERVER["DOCUMENT_ROOT"]."/leftsidebar/index.php"); ?></div>
        </div>
    </div>
</div>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/footer.php"); ?>

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
<script>
    $(document).ready(function (){
        $(".navbar-nav").find("li[class='active']").removeClass("active");
        $(".navbar-nav li").find("a[href='/Events/List']").parents("li[class='dropdown']").addClass('active');
    })
</script>
</body>
</html>