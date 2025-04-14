<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/7/15
 * Time: 6:55 PM
 */
if(!class_exists("dbFunction")){ include_once("../../../Controller/dbFunction.php"); }

$eventTitle = filter_input(INPUT_POST, "eventTitle");

$dbFunction = new dbFunction();
$result = $dbFunction->Select("SP_ValidEventTitle", array("eventTitle"), array(trim($eventTitle)));
echo json_encode($result);
