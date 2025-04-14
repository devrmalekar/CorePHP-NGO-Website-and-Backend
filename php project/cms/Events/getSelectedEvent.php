<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/6/15
 * Time: 2:50 PM
 */
if(!class_exists("dbFunction")){ include_once("../../Controller/dbFunction.php"); }
$dbFunction = new dbFunction();

$eventDetailId = filter_input(INPUT_POST, "eventDetailId");

$eventDetail = $dbFunction->Select("SP_ListEventDetails",array("id"), array($eventDetailId));
echo json_encode($eventDetail);

