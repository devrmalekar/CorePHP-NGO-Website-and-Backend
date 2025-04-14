<?php
session_start();

if(!isset($_SESSION["username"]) && empty($_SESSION["username"])) {
    $protocol=(@$_SERVER["HTTPS"] == 'on')? 'https://': 'htpp://';
    $returnUrl = $protocol.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];
    header("location: ../../Auth/index.php?returnurl=".$returnUrl);
}

include_once("../../Controller/dbFunction.php");
$save = filter_input(INPUT_POST, "save");
$dbFunction = new dbFunction();

if(isset($save) && !empty($save)){
    $WhoWeAre =filter_input(INPUT_POST, "WhoWeAre");
    $WhatWeDo = filter_input(INPUT_POST, "WhatWeDo");
    $PostalAddress =filter_input(INPUT_POST, "PostalAddress");
    $TelePhone =filter_input(INPUT_POST, "TelePhone");
    $Email =filter_input(INPUT_POST, "Email");
    $FacebookPage =filter_input(INPUT_POST, "FacebookPage");
    $YoutubeVideo =filter_input(INPUT_POST, "YoutubeVideo");
    $GooglePlus =filter_input(INPUT_POST, "GooglePlus");
    $TwitterPage =filter_input(INPUT_POST, "TwitterPage");
   // $logo = filter_input(INPUT_POST, "logo");

    $id=1; $Logo = "";
    $dbFunction->Insert("SP_UpdateAbout",array("WhoWeAre", "WhatWeDo", "PostalAddress", "TelePhone", "FacebookPage", "TwitterPage",
        "YoutubeVideo", "GooglePlus", "Logo", "Email", "id"),
        array($WhoWeAre, $WhatWeDo, $PostalAddress, $TelePhone, $FacebookPage, $TwitterPage, $YoutubeVideo, $GooglePlus, $Logo, $Email, $id));

    header("location:index.php");
}
$data = $dbFunction->Select("SP_SelectAbout", array("id"), array(1));

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
include_once('../header.php');
?>

<div id="container" style="margin: 20px;">
    <?php if(isset($error_con) && !empty($error_con)) { ?>
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            <?php echo $error_con; ?>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 form-box">
            <form action="#" method="post" enctype="application/x-www-form-urlencoded" role="form" class="form-horizontal">
            <fieldset>
                <legend><h2>Detail Information</h2></legend>
                <div class="form-group">
                    <label for="" class="col-sm-4 control-label"><span>Who We Are :</span></label>
                    <div class="col-sm-8">
                        <textarea  class="form-control"  name="WhoWeAre" tabindex="1" rows="7" placeholder="Please introduce about your organization"><?php echo $data[0]["WhoWeAre"]; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-4 control-label"><span>What We DO :</span></label>
                    <div class="col-sm-8">
                        <input type="text"  class="form-control" required="true"  name="WhatWeDo" tabindex="2"  placeholder="Please tell us what you do" value="<?php echo $data[0]["WhatWeDo"]; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-4 control-label"><span>TelePhone :</span></label>
                    <div class="col-sm-8">
                        <input type="number" maxlength="10"  class="form-control" required="true"  name="TelePhone" tabindex="3"  placeholder="Please input your telephone" value="<?php echo $data[0]["TelePhone"]; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-4 control-label"><span>Postal Address :</span></label>
                    <div class="col-sm-8">
                        <input type="text"  class="form-control" required="true"  name="PostalAddress" tabindex="4"  placeholder="Please input your postal address" value="<?php echo $data[0]["PostalAddress"]; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-4 control-label"><span>Email :</span></label>
                    <div class="col-sm-8">
                        <input type="email"  class="form-control" required="true"  name="Email" tabindex="5"  placeholder="Please input your postal address" value="<?php echo $data[0]["Email"]; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-4 control-label"><span>Fb page :</span></label>
                    <div class="col-sm-8">
                        <input type="text"  class="form-control" name="FacebookPage"  tabindex="6" value="<?php echo $data[0]["FacebookPage"]; ?>" placeholder="Please Input FB Page"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-4 control-label"><span>Twitter page :</span></label>
                    <div class="col-sm-8">
                        <input type="text"  class="form-control"   name="TwitterPage"  tabindex="7" value="<?php echo $data[0]["TwitterPage"]; ?>" placeholder="Please Input Twitter Page"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-4 control-label"><span>Instagram page :</span></label>
                    <div class="col-sm-8">
                        <input type="text"  class="form-control"   name="GooglePlus"  tabindex="8" value="<?php echo $data[0]["GooglePlus"]; ?>" placeholder="Please Input Instagram Page"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-4 control-label"><span>Youtube page :</span></label>
                    <div class="col-sm-8">
                        <input type="text"  class="form-control"   name="YoutubeVideo"  tabindex="9" value="<?php echo $data[0]["YoutubeVideo"]; ?>" placeholder="Please Input Youtube Page"/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                        <div class="col-sm-4">

                        </div>
                        <div class="col-sm-4">
                        <input type="submit" class="btn btn-default" name="save" value="Save" id="submitBttn"   tabindex="6" />
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-1.11.3.min.js"><\/script>')</script>
<script type="text/javascript" src="/cms/assets/js/bootstrap.min.js"></script>

<script src="/cms/assets/js/jquery-2.1.4.min.js"></script>

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