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
$data_eventDetail = $dbFunction->Select("SP_ListEventDetails",array("id"), array(0));
$jsonData_eventDetail = json_encode($data_eventDetail,JSON_HEX_QUOT| JSON_HEX_TAG| JSON_HEX_AMP| JSON_HEX_APOS| JSON_NUMERIC_CHECK| JSON_PRETTY_PRINT| JSON_UNESCAPED_SLASHES| JSON_PRESERVE_ZERO_FRACTION| JSON_UNESCAPED_UNICODE| JSON_PARTIAL_OUTPUT_ON_ERROR); /*Event Detais*/

$EventTitle="";
$EventDesc="";
$EventDate="";
$EventStartTime="";
$EventEndTime="";
$EventPlace="";
$EventType="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $recaptcha=filter_input(INPUT_POST, "g-recaptcha-response");
    $return = $dbFunction->validateReCaptcha($recaptcha);

    $EventTitle=filter_input(INPUT_POST, "EventTitle");
	$EventDesc=filter_input(INPUT_POST, "EventDesc");
	$EventDate=filter_input(INPUT_POST, "EventDate");
	$EventStartTime=filter_input(INPUT_POST, "EventStartTime");
	$EventEndTime=filter_input(INPUT_POST, "EventEndTime");
	$EventPlace=filter_input(INPUT_POST, "EventPlace");
	$EventType=filter_input(INPUT_POST, "EventType");
    $selectedEventId = filter_input(INPUT_POST, "selectedEvent");
    if($return == 'success') {

        $data = $dbFunction->Insert("SP_UpdateEvent", array("EventTitle", "EventDesc", "EventDate", "EventStartTime", "EventEndTime", "EventPlace", "EventType", "eventid"),
            array($EventTitle, $EventDesc, $EventDate, $EventStartTime, $EventEndTime, $EventPlace, $EventType, $selectedEventId));

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
include_once('../../header.php');
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
            <form action="index.php" method="post" novalidate="novalidate" id="newEventForm" enctype="application/x-www-form-urlencoded" role="form" class="form-horizontal">
                <fieldset>
                    <legend><h2>Event Details</h2></legend>
                    <div class="row">
                        <input id="searchEvent" required="true" name="event" type="text" class="col-md-6 form-control" placeholder="Search Event To Edit..." autocomplete="off" />
                        <input id="selectedEvent"  name="selectedEvent" type="hidden"/>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label"><span>Event of :</span></label>
                        <div class="col-sm-8">
                            <div class="col-md-6">
                                <input type="radio" id="mfn" checked="true" required="true" class="radio radio-inline" value="NGO"  name="EventType" tabindex="1"> <label class="control-label">MFN</label></input>
                            </div>
                            <div class="col-md-6">
                                <input type="radio" id="ech" class="radio radio-inline" value="ECH" name="EventType" tabindex="2" /> <label class="control-label">ECH</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label"><span>Event Title :</span></label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" required="true"   class="form-control"  name="EventTitle" tabindex="3" placeholder="Please Input Event Title" value="<?php echo $EventTitle; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label"><span>Event Description :</span></label>
                        <div class="col-sm-8">
                            <textarea type="text"  class="form-control"  required="true"  name="EventDesc" tabindex="4"  placeholder="Please describe about event"><?php echo $EventDesc; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label"><span>Event Date :</span></label>
                        <div class="col-sm-8">
                            <input type="date"   class="form-control"  required="true"  name="EventDate" tabindex="5"  placeholder="Please select event date" value="<?php echo $EventDate; ?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label"><span>Event Start Time :</span></label>
                        <div class="col-sm-8">
                            <input type="text"  class="form-control"  required="true"  name="EventStartTime" tabindex="6"  placeholder="Please select event start time" value="<?php echo $EventStartTime; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label"><span>Event End Time :</span></label>
                        <div class="col-sm-8">
                            <input type="text"  class="form-control"  required="true"  name="EventEndTime" tabindex="7"  placeholder="Please select event end time" value="<?php echo $EventEndTime; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label"><span>Event Place :</span></label>
                        <div class="col-sm-8">
                            <input type="text"  required="true"  class="form-control" name="EventPlace"  tabindex="8" placeholder="Please Input Event Place" value="<?php echo $EventPlace; ?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-5 col-sm-8">
                            <?php include_once("../../../recaptcha.php"); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <div class="col-sm-4">
                                <!-- Trigger the modal with a button -->
                                <button type="button" id="confirmBtn" class="btn btn-info btn-lg" data-toggle="modal" data-target="#confirmSubmit">Update</button>
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
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <input type="submit" class="btn btn-default" name="save" value="Save" id="submitBttn"  tabindex="9" />
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
    var eventTitle="";
    function displayResult(item) {
        $("#selectedEvent").val(item.value);
        $.ajax({
            type: 'POST',
            data: {eventDetailId:item.value},
            url: '../getSelectedEvent.php',
            success: function(data){
                data = $.parseJSON(data);
                eventTitle=data[0]["EventTitle"];
                $("input[name='EventTitle']").val(data[0]["EventTitle"]);
                $("textarea[name='EventDesc']").html(data[0]['EventDesc']);
                $("input[name='EventDate']").val(data[0]['EventDate']);
                $("input[name='EventStartTime']").val(data[0]['EventStartTime']);
                $("input[name='EventEndTime']").val(data[0]['EventEndTime']);
                $("input[name='EventPlace']").val(data[0]['EventPlace']);
                if(data[0]['EventType'] == 'ECH'){
                    $("#ech").attr("checked",'true');
                } else if(data[0]['EventType']=='MFN') {
                    $("#mfn").attr("checked",'true');
                }
            }
        });
    }

    $("input[name='EventTitle']").change(function (){
        if($("input[name='EventTitle']").val() != eventTitle) {
            $.ajax({
                method: 'post',
                data: {eventTitle: $("input[name='EventTitle']").val()},
                url: 'validEventTitle.php',
                success: function (data) {
                    data = $.parseJSON(data);
                    if (data.length == 0) {
                        $("#addon").remove();
                        var correct = '<span id="addon" class="input-group input-group-addon"><i class="glyphicon glyphicon-ok"></i></span>';
                        $(correct).insertAfter($("input[name='EventTitle']"));
                    } else {
                        $("#addon").remove();
                        var wrong = '<span id="addon" class="input-group input-group-addon"><i class="glyphicon glyphicon-remove"></i></span>';
                        $(wrong).insertAfter($("input[name='EventTitle']"));
                    }
                }
            });
        } else if ($("input[name='EventTitle']").val() == eventTitle){
            $("#addon").remove();
            var correct = '<span id="addon" class="input-group input-group-addon"><i class="glyphicon glyphicon-ok"></i></span>';
            $(correct).insertAfter($("input[name='EventTitle']"));
        }
    });

    $('#searchEvent').typeahead({
        source: <?php echo $jsonData_eventDetail; ?> ,
        displayField: "EventTitle",
        valueField: "id",
        onSelect: displayResult
    });

    $('#searchEvent').change(function(){
        if($('#searchEvent').val() == "") {
            $("input[name='EventTitle']").val("");
            $("input[name='EventDesc']").html("");
            $("input[name='EventDate']").val("");
            $("input[name='EventStartTime']").val("");
            $("input[name='EventEndTime']").val("");
            $("input[name='EventPlace']").val("");
        }
    });

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
        $("#EventTitle").html($("input[name='EventTitle']").val());
        $("#EventDesc").html($("textarea[name='EventDesc']").val());
        $("#EventDate").html($("input[name='EventDate']").val());
        $("#EventStartTime").html($("input[name='EventStartTime']").val());
        $("#EventEndTime").html($("input[name='EventEndTime']").val());
        $("#EventPlace").html($("input[name='EventPlace']").val());
    }

</script>

</body>
</html>