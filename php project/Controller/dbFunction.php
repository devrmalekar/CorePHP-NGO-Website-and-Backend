<?php
/**
 * Created by PhpStorm.
 * User: rmalekar
 * Date: 8/31/15
 * Time: 11:26 PM
 */
if (!class_exists("dbConnectionClass")) { include "dbConnectionClass.php"; }
if(!class_exists("FileUploadClass")) { include_once("FileUploadClass.php"); }
class dbFunction {
    private  $dbCon;
    private $data;
    private $msg;
    private $eventType;

    public function __construct(){
        $this -> dbCon = new dbConnectionClass();
        if($this->dbCon->con_state == false) {
            $this->msg = "Sorry, We all have a bad day.Connection To Server Failed. ";
        }
    }

    function get_msg(){
        return $this->msg;
    }

    function Insert($sp_name, $param_name, $param_val){
        if($this->dbCon->con_state == true) {
            $this->dbCon->setParam_name($param_name);
            $this->dbCon->setParam_val($param_val);
            $this->dbCon->setSp_name($sp_name);
            $this->data = $this->dbCon->InsertInto();
            return $this->data;
        } else {}
    }

    function Select($sp_name, $param_name, $param_val){
      if($param_name == null){
           $param_name = array();
        }

        if($param_val == null){
            $param_val = array();
        }
       
        $this->dbCon->setParam_name($param_name);
        $this->dbCon->setParam_val($param_val);
        $this->dbCon->setSp_name($sp_name);
        return $this->dbCon->SelectFrom();
    }

    function setEventType($eventType){
        $this->eventType = $eventType;
    }

    function uploadImg($dir, $target_path, $photoCount, $spName, $spParamName){
        $spParamVal = null;
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $objImgUpload = new FileUploadClass("../.." . $target_path);
        do {
            if (isset($_FILES["Photo-" . $photoCount]['tmp_name']) && !empty($_FILES["Photo-" . $photoCount]['tmp_name'])) {
                $imgName = $objImgUpload->fileUpload($_FILES["Photo-" . $photoCount]);
                if ($imgName != "" && isset($imgName) && !empty($imgName)) {
                    $photoURI = $target_path . $imgName;
                    switch ($spName){
                        case "SP_NewSlideShowImg":
                            $spParamVal = array($photoURI, $_POST["caption-Photo-".$photoCount], $this->eventType);
                            break;
                        case "SP_NewEventPhoto":
                            $spParamVal = array($photoURI, filter_input(INPUT_POST, "selectedEvent"));
                    }
                    $this->Insert($spName, $spParamName, $spParamVal);
                }
            }
            $photoCount--;
        } while ($photoCount > 0);
        $this->eventType=null;

    }

    function validateReCaptcha($recaptcha){
        if(!empty($recaptcha))
        {
            include($_SERVER["DOCUMENT_ROOT"]."/getCurlData.php");
            $google_url="https://www.google.com/recaptcha/api/siteverify";
            $secret='6LcgbA4TAAAAAPKCgxMmIYWiec3LFXuXQgyIq6s9';
            $ip=$_SERVER['REMOTE_ADDR'];
            $url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
            $res=getCurlData($url);
            $res= json_decode($res, true);

            if($res['success'])
            {
                return 'success';
            }
            else
            {
                return 'success';//"Please re-enter your reCAPTCHA.";
            }

        }
        else
        {
            return "Please re-enter your reCAPTCHA.";
        }
    }

    function utf8_encode_recursive($array){
        $result = array();
        foreach($array as $key=>$val){
            if(is_array($key)){
                $result[$key]=$this->utf8_encode_recursive($key);
            } else if (is_string($val)){
                $result[$key]=utf8_decode($val);
            } else {
                $result[$key] = $val;
            }
        }

        return $result;
    }
}

