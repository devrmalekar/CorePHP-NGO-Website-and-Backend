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

//$save = filter_input(INPUT_POST, "save");
$dbFunction = new dbFunction();

$blogTitle="";
$blogMsg="";
$blogWrittenBy="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $recaptcha=filter_input(INPUT_POST, "g-recaptcha-response");
    $return = $dbFunction->validateReCaptcha($recaptcha);

    $blogTitle=filter_input(INPUT_POST, "BlogTitle");
    $blogMsg=filter_input(INPUT_POST, "BlogMsg");
    $blogWrittenBy=filter_input(INPUT_POST, "BlogWrittenBy");

    if($return == 'success') {
        $data = $dbFunction->Insert("SP_NewBlog", array( "blogTitle","blogMsg","blogWrittenBy"),
            array($blogTitle, $blogMsg, $blogWrittenBy));
        header("location:index.php");
    } else {
        $error_con=$return;
    }
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
            <form action="#" method="post" novalidate="novalidate" id="newEventForm" enctype="application/x-www-form-urlencoded" role="form" class="form-horizontal">
                <fieldset>
                    <legend><h2>New Blog</h2></legend>

                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label"><span> Title :</span></label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" required="true"  class="form-control"  name="BlogTitle" tabindex="3" placeholder="Please Input Event Title" value="<?php echo $blogTitle; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label"><span> Message :</span></label>
                        <div class="col-sm-8">
                            <textarea type="text" rows="10" class="form-control" required="true"  name="BlogMsg" tabindex="4"  placeholder="Please describe about event"><?php echo $blogMsg; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label"><span> Written By :</span></label>
                        <div class="col-sm-8">
                            <input type="text"   class="form-control" required="true"  name="BlogWrittenBy" tabindex="5"  placeholder="Please select event date" value="<?php echo $blogWrittenBy; ?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-5 col-sm-8">
                            <?php include_once($_SERVER['DOCUMENT_ROOT']."/recaptcha.php"); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <div class="col-sm-4">
                                <!-- Trigger the modal with a button -->
                                <button type="button" id="confirmBtn" class="btn btn-info btn-lg" data-toggle="modal" data-target="#confirmSubmit">Post</button>
                                <!-- Modal -->
                                <div id="confirmSubmit" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Please Review Event Details Before Submit</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row modalRow">
                                                    <label for="EventTitle" class="col-sm-4 control-label"><span>Title :</span></label>
                                                    <label type="text" class="label-info col-sm-8" id="EventTitle" ></label>
                                                </div>

                                                <div class="row modalRow">
                                                    <label for="EventDesc" class="col-sm-4 control-label"><span>Message :</span></label>
                                                    <label type="text" class="label-info col-sm-8" id="EventDesc"></label>

                                                </div>

                                                <div class="row modalRow">
                                                    <label for="EventDate" class="col-sm-4 control-label"><span>Written By :</span></label>
                                                    <label type="date" class="label-info col-sm-8" id="EventDate"></label>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <input type="submit" class="btn btn-default" name="save" value="Post" id="submitBttn"  tabindex="9" />
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
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

<script>
    var isFormValid = true;
    $("#confirmBtn").click(function (){
        fillModalVal();
        if($("#addon").children(".glyphicon-remove").length){
            $("input[name='EventTitle']").css("border-color", "#B90707");
            return false;
        } else {
            $("input[name='EventTitle']").css("border-color", "#ccc");
        }
        return $("#newEventForm").valid();
    });

    function fillModalVal(){
        $("#EventTitle").html($("input[name='BlogTitle']").val());
        $("#EventDesc").html($("textarea[name='BlogMsg']").val());
        $("#EventDate").html($("input[name='BlogWrittenBy']").val());

    }

    $("input[name='EventTitle']").change(function (){
        $.ajax({
            method: 'post',
            data: {eventTitle: $("input[name='EventTitle']").val()},
            url: 'validEventTitle.php',
            success: function(data){
                data = $.parseJSON(data);
                if(data.length == 0){
                    $("#addon").remove();
                    var correct = '<span id="addon" class="input-group input-group-addon"><i class="glyphicon glyphicon-ok"></i></span>';
                    $(correct).insertAfter($("input[name='EventTitle']"));
                } else {
                    $("#addon").remove();
                    var wrong = '<span id="addon" class="input-group input-group-addon"><i class="glyphicon glyphicon-remove"></i></span>';
                    $(wrong).insertAfter($("input[name='EventTitle']"));
                }
            }
        }) ;
    });
</script>

</body>
</html>