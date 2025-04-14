<?php
/**
 * Created by PhpStorm.
 * User: rmalekar
 * Date: 10/4/15
 * Time: 1:51 PM
 */
    session_start();
    define("DiskRoot", $_SERVER['DOCUMENT_ROOT']);
    $error = null;
if(!isset($_SESSION["username"]) && empty($_SESSION["username"])) {
    $protocol=(@$_SERVER["HTTPS"] == 'on')? 'https://': 'htpp://';
    $returnUrl = $protocol.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];
    header("location: ../../Auth/index.php?returnurl=".$returnUrl);
}

    if(!class_exists("dbFunction")){ include_once(DiskRoot."/Controller/dbFunction.php"); }
    if(!class_exists("FileUploadClass")) { include_once(DiskRoot."/Controller/FileUploadClass.php");}
    try{
        $dbFunction = new dbFunction();
        $data_eventDetail = $dbFunction->Select("SP_ListEventDetails",array("id"), array(0));
        $jsonData_eventDetail = json_encode($data_eventDetail,JSON_HEX_QUOT| JSON_HEX_TAG| JSON_HEX_AMP| JSON_HEX_APOS| JSON_NUMERIC_CHECK| JSON_PRETTY_PRINT| JSON_UNESCAPED_SLASHES| JSON_PRESERVE_ZERO_FRACTION| JSON_UNESCAPED_UNICODE| JSON_PARTIAL_OUTPUT_ON_ERROR); /*Event Detais*/
    } catch (Exception $ex){
        print_r("Somethine went wrong. Sorry For inoc"); exit;
    }

    /*List of Events Title*/
    $eventTitleArr =array();
    $countEvent = 0;
    foreach($data_eventDetail as $mainData){
        $eventTitleArr[$countEvent++] = $mainData["EventTitle"];
    }
    $eventTitleArr = json_encode($eventTitleArr);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $recaptcha=filter_input(INPUT_POST, "g-recaptcha-response");
        $return = $dbFunction->validateReCaptcha($recaptcha);
        $return = 'success';
        if($return == 'success') {
            try {
                $photoCount = filter_input(INPUT_POST, "photoCount");

                $target_path = "/assets/images/".$_POST["selectedEvent"]."/";
                $dir = "../.." . $target_path;
                $dbFunction->uploadImg($dir, $target_path, $photoCount,"SP_NewEventPhoto", array("EventPhotoURL", "EventId"));

                $videoCount = filter_input(INPUT_POST, "videoCount");
                do {
                    $videoURL = filter_input(INPUT_POST, "Video-" . $videoCount);
                    if (isset($videoURL) && !empty($videoURL)) {
                        $dbFunction->Insert("SP_NewEventVideo", array("EventVideoURL", "EventId"), array($videoURL, $eventId));
                    }
                    $videoCount--;
                } while ($videoCount > 0);
                header("location:addGallery.php");
            } catch (Exception $ex) {
               // $error = $ex->getMessage();
            }
        } else {
            $error=$return;
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

<div class="container">
    <?php if(isset($error) && !empty($error)) { ?>
        <div class="alert alert-danger main-content" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            <?php echo $error; ?>
        </div>
    <?php } ?>
    <div class="row main-content">
        <div class="col-sm-3 col-md-4">
            <legend><h2>Event Details</h2></legend>
            <div class="row modalRow">
                <label for="EventTitle" class="col-sm-4 control-label"><span>Title :</span></label>
                <label type="text" class="label-info col-sm-8" id="EventTitle" ></label>
            </div>

            <div class="row modalRow">
                <label for="EventDesc" class="col-sm-4 control-label"><span>Description :</span></label>
                <label type="text" class="label-info col-sm-8" id="EventDesc"></label>

            </div>

            <div class="row modalRow">
                <label for="EventDate" class="col-sm-4 control-label"><span>Date :</span></label>
                <label type="date" class="label-info col-sm-8" id="EventDate"></label>
            </div>

            <div class="row modalRow">
                <label for="EventStartTime" class="col-sm-4 control-label"><span>Start Time :</span></label>
                <label type="text" class="label-info col-sm-8" id="EventStartTime"></label>
            </div>

            <div class="row modalRow">
                <label for="EventEndTime" class="col-sm-4 control-label"><span>End Time :</span></label>
                <label type="text" class="label-info col-sm-8" id="EventEndTime"></label>
            </div>

            <div class="row modalRow">
                <label for="EventPlace" class="col-sm-4 control-label"><span>Place :</span></label>
                <label type="text" class="label-info col-sm-8" id="EventPlace"></label>
            </div>


        </div>

        <div class="col-sm-6 col-sm-offset-2 col-md-7 col-md-offset-0" style="margin-left: 2%;">
            <form action="#" method="post" id="newEventGalleryForm" enctype="multipart/form-data" role="form" class="form-horizontal">
                <fieldset>
                    <legend><h2>Event Gallery</h2></legend>
                    <div class="row">
                        <div class="col-md-6"></div>
                        <input id="searchEvent" required="true" name="event" type="text" class="col-md-6 form-control" placeholder="Search Event To Edit..." autocomplete="off" />
                        <input id="selectedEvent"  name="selectedEvent" type="hidden"/>
                    </div> <br />
                    <div id="photos" class="form-group" style="border: 1px solid #000;">
                        <label for="" class="col-sm-2 control-label"><span>Photo :</span></label>
                        <div class="col-sm-10">
                            <input type="hidden" name="photoCount" value="1"/>
                            <div class="row" id="photo-1">
                                <input type="file"  onchange="readImg(this, this.id);" id="1" required="true" class="form-control addPhoto" name="Photo-1"  tabindex="7" placeholder="Please upload photos." accept="image/gif, image/jpg, image/jpeg, image/png"/>
                                <img class="img-responsive" id="img-1" src="" />
                                <button type="button" id="addMorePhoto" onclick="addPhoto()" class="btn btn-default removePhoto"><span class="fa fa-plus"></span></button>
                            </div>
                        </div>
                    </div>

                    <div id="videos" class="form-group" style="border: 1px solid #000;">
                        <label for="" class="col-sm-2 control-label"><span>Video :</span></label>
                        <input type="hidden" value="1" name="videoCount" />
                        <div class="col-sm-10">
                            <div class="row" id="video-1">
                                <input type="text"   id="vid-1" class="form-control addVideo" name="Video-1"  tabindex="8" placeholder="Please input video url." />
                                <!-- <div class="embed-responsive embed-responsive-4by3" id="embed-1">
                                 </div>  -->
                                <button type="button" id="addMoreVideo" onclick="addVideo()" class="btn btn-default removeVideo"><span class="fa fa-plus"></span></button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-8">
                            <?php //include_once("../../recaptcha.php"); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <div class="col-sm-4">
                                <!-- Trigger the modal with a button -->
                                <button type="button" id="confirmBtn" class="btn btn-info btn-lg" data-toggle="modal" data-target="#confirmSubmit">Open Modal</button>
                                <!-- Modal -->
                                <div id="confirmSubmit" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Inputed photos and videos are going to be upload for following event details. Please Make Sure. </h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row modalRow">
                                                    <label for="ConfirmEventTitle" class="col-sm-4 control-label"><span>Title :</span></label>
                                                    <label type="text" class="label-info col-sm-8" id="ConfirmEventTitle" ></label>
                                                </div>

                                                <div class="row modalRow">
                                                    <label for="ConfirmEventDesc" class="col-sm-4 control-label"><span>Description :</span></label>
                                                    <label type="text" class="label-info col-sm-8" id="ConfirmEventDesc"></label>

                                                </div>

                                                <div class="row modalRow">
                                                    <label for="ConfirmEventDate" class="col-sm-4 control-label"><span>Date :</span></label>
                                                    <label type="date" class="label-info col-sm-8" id="ConfirmEventDate"></label>
                                                </div>

                                                <div class="row modalRow">
                                                    <label for="ConfirmEventStartTime" class="col-sm-4 control-label"><span>Start Time :</span></label>
                                                    <label type="text" class="label-info col-sm-8" id="ConfirmEventStartTime"></label>
                                                </div>

                                                <div class="row modalRow">
                                                    <label for="ConfirmEventEndTime" class="col-sm-4 control-label"><span>End Time :</span></label>
                                                    <label type="text" class="label-info col-sm-8" id="ConfirmEventEndTime"></label>
                                                </div>

                                                <div class="row modalRow">
                                                    <label for="ConfirmEventPlace" class="col-sm-4 control-label"><span>Place :</span></label>
                                                    <label type="text" class="label-info col-sm-8" id="ConfirmEventPlace"></label>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <input type="submit" class="btn btn-default" name="save" value="Save" id="submitBttn"   tabindex="9" />
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-4">
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
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="/cms/assets/js/main.js"></script>
<script src="/cms/assets/js/bootstrap-typeahead.js"></script>
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
    function displayResult(item) {
        $("#selectedEvent").val(item.value);
        $.ajax({
            type: 'POST',
            data: {eventDetailId:item.value},
            url: 'getSelectedEvent.php',
            success: function(data){
                data = $.parseJSON(data);
                $("#EventTitle").html(data[0]["EventTitle"]);
                $("#EventDesc").html(data[0]['EventDesc']);
                $("#EventDate").html(data[0]['EventDate']);
                $("#EventStartTime").html(data[0]['EventStartTime']);
                $("#EventEndTime").html(data[0]['EventEndTime']);
                $("#EventPlace").html(data[0]['EventPlace']);
            }
        });
    }

    $('#searchEvent').typeahead({
        source: <?php echo $jsonData_eventDetail; ?> ,
        displayField: "EventTitle",
        valueField: "id",
        onSelect: displayResult
    });

    $('#searchEvent').change(function(){
        if($('#searchLyrics').val() == "") {
            $("#EventTitle").html("");
            $("#EventDesc").html("");
            $("#EventDate").html("");
            $("#EventStartTime").html("");
            $("#EventEndTime").html("");
            $("#EventPlace").html("");
        }
    })

    function fillModalVal(){
        $("#ConfirmEventTitle").html($("#EventTitle").val());
        $("#ConfirmEventDesc").html($("EventDesc").val());
        $("#ConfirmEventDate").html($("#EventDate").val());
        $("#ConfirmEventStartTime").html($("#EventStartTime").val());
        $("#ConfirmEventEndTime").html($("#EventEndTime").val());
        $("#ConfirmEventPlace").html($("#EventPlace").val());
    }
</script>
</body>
</html>