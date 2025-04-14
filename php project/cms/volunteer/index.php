<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/3/15
 * Time: 2:31 PM
 */
session_start();
define("DiskRoot", $_SERVER['DOCUMENT_ROOT']);

if(!isset($_SESSION["username"]) && empty($_SESSION["username"])) {
    $protocol=(@$_SERVER["HTTPS"] == 'on')? 'https://': 'htpp://';
    $returnUrl = $protocol.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];
    header("location: ../../Auth/index.php?returnurl=".$returnUrl);
}

if(!class_exists("dbFunction")) { include_once(DiskRoot."/Controller/dbFunction.php"); }
$dbFunction = new dbFunction();
$allVolunteerList= $dbFunction->Select("SP_allVolunteerList", null, null);
$show="all";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $volunteerID = filter_input(INPUT_POST, "volunteerid");
    $action = filter_input(INPUT_POST, "action");
    $dbFunction->Insert("SP_VolunteerApproval", array("volunteerid", "sstatus"), array($volunteerID, $action));
    header("location:index.php");
}

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $show=filter_input(INPUT_GET, "show");
    switch($show){
        case ("approved"):
            $allVolunteerList= $dbFunction->Select("SP_VolunteerList", array("sstatus"), array("Approved"));
            break;
        case ("not approved"):
            $allVolunteerList= $dbFunction->Select("SP_VolunteerList", array("sstatus"), array("Not Approved"));
            break;
        case ("rejected"):
            $allVolunteerList= $dbFunction->Select("SP_VolunteerList", array("sstatus"), array("Rejected"));
            break;
        case ("all"):
            $allVolunteerList= $dbFunction->Select("SP_allVolunteerList", null, null);
            break;
        default:
            $allVolunteerList= $dbFunction->Select("SP_allVolunteerList", null, null);
            break;
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


<div id="container" style="margin: 7%;">
    <div class="row">
        <div id="volunterhead">
            <h2>Volunteer Application List</h2>
        </div>
        <div id="showoption">
                <select name="options" onclick="listvolunteer();">
                    <option value="all" <?php if($show=="all") { ?>selected="selected"<?php } ?>>All</option>
                    <option value="approved" <?php if($show=="approved") { ?> selected="selected" <?php  } ?>>Approved</option>
                    <option value='not approved' <?php if($show=="not approved") { ?> selected <?php }?>>Not Approved</option>
                    <option value='rejected' <?php if($show=="rejected") { ?> selected <?php } ?>>Rejected</option>
                </select>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Fist Name</th>
                    <th>Last name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Appliled Date</th>
                    <?php // foreach($allVolunteerList[0] as $key=>$val) echo "<th>$key</th>";?>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($allVolunteerList as $person) {
                     if($person["status"] == "Approved"){ echo "<tr class='success'>"; }
                     else if($person["status"] == "Not Approved"){ echo "<tr class='info'>"; }
                     else if($person["status"] == "Rejected"){ echo "<tr class='danger'>"; }
                     foreach($person as $key=>$val){
                         if($key!="id") {
                         if($key=="reason"){ $data_target = "reason-".$person["sn"];echo "<td><a href='javascript:void(0);' data-toggle='modal' data-target='#$data_target'>Open Modal</a>
                            <!-- Modal -->
                            <div id='$data_target' class='modal fade' role='dialog'>
                                <div class='modal-dialog'>
                                    <!-- Modal content-->
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            <h4 class='modal-title'>Reason</h4>
                                        </div>
                                        <div class='modal-body'>
                                            <div class='row modalRow'>
                                                <label for='reason' class='col-sm-4 control-label'><span>Reason :</span></label>
                                                <label type='text' id='reason' class=' col-sm-8'>$val</label>
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-default' data-dismiss='modal'>OK</button>
                                        </div>
                                    </div>

                                </div>
                            </div></td>";
                         } else  { echo "<td>$val</td>";}
                         }
                     }
                    ?>
                    <?php //if($person["status"] != "Approved") { ?>
                        <td><form action="index.php" method="post" name='<?php echo "volunteer-".$person['sn']; ?>'><input type='hidden' name='volunteerid' value='<?php echo $person["id"];?>'/>
                            <select onchange="submitVolForm('<?php echo "volunteer-".$person['sn']; ?>');" name='action'>
                                <option value=''>Select an Action</option>
                                <option value='approved'>Approve</option>
                                <option value='not approved'>Not Approve</option>
                                <option value='rejected'>Rejected</option>
                        </select></form></td>
                    <?php //} ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
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
    var $default=$("select[name='options']").val();
    (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='https://www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
    ga('create','UA-XXXXX-X','auto');ga('send','pageview');
</script>

<script>
    function submitVolForm(name){
        if($("select[name='action']").val() != "") {
            $("form[name='" + name + "']").submit();
        }
    }

    function listvolunteer(){
        if($("select[name='options']").val() != $default) {
            window.location.replace("index.php?show=" + $("select[name='options']").val());
        }
    }
</script>

</body>
</html>