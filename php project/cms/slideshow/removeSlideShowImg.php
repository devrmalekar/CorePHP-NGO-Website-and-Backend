<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/8/15
 * Time: 11:53 AM
 */
if(!class_exists("dbFunction")) { include_once("../../Controller/dbFunction.php"); }
$dbFunction = new dbFunction();
$id = filter_input(INPUT_POST, "id");
$imgURL = filter_input(INPUT_POST, "imgURL");

$result = $dbFunction->Insert("SP_RMSlideShowImg", array("id"), array($id));
var_dump($result);
if(count($result) > 0) {
    unlink($_SERVER['DOCUMENT_ROOT'].$imgURL);
    echo "success";
}
echo "not success";