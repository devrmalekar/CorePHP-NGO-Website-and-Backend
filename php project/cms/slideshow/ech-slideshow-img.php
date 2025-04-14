<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/7/15
 * Time: 9:43 PM
 */
session_start();

if(!isset($_SESSION["username"]) && empty($_SESSION["username"])) {
    $protocol=(@$_SERVER["HTTPS"] == 'on')? 'https://': 'htpp://';
    $returnUrl = $protocol.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];
    header("location: ../../Auth/index.php?returnurl=".$returnUrl);
}
if(!class_exists("dbFunction")){ include_once($_SERVER["DOCUMENT_ROOT"]."/Controller/dbFunction.php"); }
$dbFunction = new dbFunction();
$result = $dbFunction->Select("SP_ListSlideShowImg",  array("eventType"), array("Sister") );

$isFormSubmit = filter_input(INPUT_POST, "save");

if(isset($isFormSubmit) && !empty($isFormSubmit)) {
    //$caption =filter_input(INPUT_POST, "");
    $target_path = "/assets/images/SlideShowIMg/Sister/";
    $dir = "../.." . $target_path;
    $dbFunction->setEventType("Sister");
    $dbFunction->uploadImg($dir, $target_path, 5,"SP_NewSlideShowImg", array("imgUrl", "caption", "eventType"));
    header("location:sister-slideshow-img.php");
}
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

<div class="container">
    <?php if(isset($error) && !empty($error)) { ?>
        <div class="alert alert-danger main-content" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            <?php echo $error; ?>
        </div>
    <?php } ?>
    <div class="row main-content">
            <form action="#" method="post" id="newEventGalleryForm" enctype="multipart/form-data" role="form" class="form-horizontal">
                <fieldset>
                    <legend><h2>MFN Slide Show Images</h2></legend>

                    <label for="" class="col-sm-2 control-label"><span>Photo :</span></label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-6"  id="div-Photo-1">
                                <?php if(count($result) >= 1) { ?>
                                    <div class="col-md-6"><img id="img-Photo-1" class="img-responsive fitImg" src="<?php echo $result[0]["slideshowImgUrl"]; ?>" alt="slideshow Img1" /></div>
                                    <div class="col-md-6">
                                        <textarea rows=3 name="caption-Photo-1"><?php echo $result[0]["caption"]; ?></textarea>
                                        <button type="button" id="<?php echo $result[0]["id"]; ?>" onclick="removeImg(this,'Photo-1')" style="margin: auto;" class="input-group">Remove Photo <span class="glyphicon glyphicon-remove"></span></button>
                                    </div>
                                <?php } else { ?>
                                    <input type="file"  onchange="displayImg(this)" required="true" class="form-control addPhoto" name="Photo-1"  tabindex="1" placeholder="Please upload photos." accept="image/gif, image/jpg, image/jpeg, img/png"/>
                                <?php } ?>
                            </div>

                            <div class="col-md-6"  id="div-Photo-2">
                                <?php if(count($result) >= 2) { ?>
                                    <div class="col-md-6"><img id="img-Photo-2" class="img-responsive fitImg" src="<?php echo $result[1]["slideshowImgUrl"]; ?>" alt="slideshow Img2" /></div>
                                    <div class="col-md-6">
                                        <textarea rows=3 name="caption-Photo-2"><?php echo $result[1]["caption"]; ?></textarea>
                                        <button type="button" id="<?php echo $result[1]["id"]; ?>" onclick="removeImg(this,'Photo-2')" style="margin: auto;" class="input-group">Remove Photo <span class="glyphicon glyphicon-remove"></span></button>
                                    </div>
                                <?php } else { ?>
                                    <input type="file" onchange="displayImg(this)"  class="form-control addPhoto" name="Photo-2"  tabindex="2" placeholder="Please upload photos." accept="image/gif, image/jpg, image/jpeg, img/png"/>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row" >
                            <div class="col-md-6"  id="div-Photo-3">
                                <?php if(count($result) >= 3) { ?>
                                    <div class="col-md-6"><img id="img-Photo-3" class="img-responsive fitImg" src="<?php echo $result[2]["slideshowImgUrl"]; ?>" alt="slideshow Img3" /></div>
                                    <div class="col-md-6">
                                        <textarea rows=3 name="caption-Photo-3"><?php echo $result[2]["caption"]; ?></textarea>
                                        <button type="button" id="<?php echo $result[2]["id"]; ?>" onclick="removeImg(this,'Photo-3')" style="margin: auto;" class="input-group">Remove Photo <span class="glyphicon glyphicon-remove"></span></button>
                                    </div>
                                <?php } else { ?>
                                    <input type="file" onchange="displayImg(this)"  class="form-control addPhoto" name="Photo-3"  tabindex="3" placeholder="Please upload photos." accept="image/gif, image/jpg, image/jpeg, img/png"/>
                                <?php } ?>
                            </div>
                            <div class="col-md-6"  id="div-Photo-4">
                                <?php if(count($result) >= 4) { ?>
                                    <div class="col-md-6"><img id="img-Photo-4" class="img-responsive fitImg" src="<?php echo $result[3]["slideshowImgUrl"]; ?>" alt="slideshow Img4" /></div>
                                    <div class="col-md-6">
                                        <textarea rows=3 name="caption-Photo-4"><?php echo $result[3]["caption"]; ?></textarea>
                                        <button type="button" id="<?php echo $result[3]["id"]; ?>" onclick="removeImg(this,'Photo-4')" style="margin: auto;" class="input-group">Remove Photo <span class="glyphicon glyphicon-remove"></span></button>
                                    </div>
                                <?php } else { ?>
                                    <input type="file" onchange="displayImg(this)"  class="form-control addPhoto" name="Photo-4"  tabindex="4" placeholder="Please upload photos." accept="image/gif, image/jpg, image/jpeg, img/png"/>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row"  id="div-Photo-5">
                            <div class="col-md-6"  id="div-Photo-5">
                                <?php if(count($result) == 5) { ?>
                                    <div class="col-md-6"><img id="img-Photo-5" class="img-responsive fitImg" src="<?php echo $result[4]["slideshowImgUrl"]; ?>" alt="slideshow Img5" /></div>
                                    <div class="col-md-6">
                                        <textarea rows=3 name="caption-Photo-5"><?php echo $result[4]["caption"]; ?></textarea>
                                        <button type="button" id="<?php echo $result[4]["id"]; ?>" onclick="removeImg(this,'Photo-4')" style="margin: auto;" class="input-group">Remove Photo <span class="glyphicon glyphicon-remove"></span></button>
                                    </div>
                                <?php } else { ?>
                                    <input type="file" onchange="displayImg(this)"  class="form-control addPhoto" name="Photo-5"  tabindex="5" placeholder="Please upload photos." accept="image/gif, image/jpg, image/jpeg, img/png"/>
                                <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <input type="submit" name="save" value="save" />
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>

    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/cms/assets/js/vendor/jquery-1.11.3.min.js"><\/script>')</script>
<script type="text/javascript" src="/cms/assets/js/bootstrap.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="/cms/assets/js/main.js"></script>
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
    function displayImg(input){
       var img = '<div class="col-md-6"><img id="img-'+input.name+'" class="img-responsive fitImg" src="" alt="slideshow Img1" /></div>';
        var caption = '<textarea rows=3 name="caption-'+input.name+'"></textarea>';
        var right_sec = '<div class="col-md-6">'+caption+'<button type="button" id="remove-'+input.name+'" onclick="removeImg(this,\''+input.name+'\')" style="margin: auto;" class="input-group">Remove Photo <span class="glyphicon glyphicon-remove"></span></button></div>'
        var display = img+right_sec;
        readImg(input, input.name);
        $(display).insertAfter($("input[name='"+input.name+"']"));
        $("input[name='"+input.name+"']").css("display", "none");
    }

    function removeImg(img, name){
        var $id =parseInt(img.id);
        if(!isNaN($id)){
            $.ajax({
                method: 'post',
                data: {id: $id, imgURL: $("#img-"+name).attr("src")},
                url: "removeSlideShowImg.php",
                success: function(data){
                    alert(data);
                }
            });
        }
        var input ='<input type="file" onchange="displayImg(this)" required="true" class="form-control addPhoto" name="'+name+'"  placeholder="Please upload photos." accept="image/gif, image/jpg, image/jpeg, img/png"/>';
        $("#div-"+name).html("");
        $(input).appendTo( $("#div-"+name));
    }
</script>
</body>
</html>