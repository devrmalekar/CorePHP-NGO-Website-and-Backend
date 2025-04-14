<?php
/**
 * Created by PhpStorm.
 * User: rmalekar
 * Date: 7/29/15
 * Time: 12:02 PM
 */
if (!class_exists("dbConnectionClass")) { include('dbConnectionClass.php'); }
class AuthenticationController {
    private $username;
    private  $password;

    public function  __construct($username, $password){
        $this ->  username = $username;
        $this -> password = $password;
    }

    function  checkAuthentication()
    {
        try{
            $dbCon = new dbConnectionClass();
            if($dbCon->con_state == true) {
                $dbCon->setParam_name(array('username', 'pwd'));
                $dbCon->setParam_val(array($this->username, $this->password));
                $dbCon->setSp_name("SP_CheckAuth");
                $data = $dbCon->SelectFrom();
                if (in_array("No Username Exists", $data[0])) {
                    return "Username does not exist";
                } else if (in_array("Password Mismatch", $data[0])) {
                    return "Password Incorrect. Please re-check Username and Password, then try again.";
                } else {
                    $_SESSION["UserRole"] = $data[0]["UserRole"];
                    $_SESSION["username"] = $data[0]["username"];
                    $_SESSION["user_id"]=$data[0]["user_id"];
                    $_SESSION["name"] = $data[0]["user_FName"];
                }
            }
            else {
                return "Connection to Database Failed.";
            }
        } catch (Exception $ex){

        }
    }
}