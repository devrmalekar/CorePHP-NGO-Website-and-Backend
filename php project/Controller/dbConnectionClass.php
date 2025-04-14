<?php
/**
 * Created by PhpStorm.
 * User: rmalekar
 * Date: 7/29/15
 * Time: 2:25 PM
 */

class dbConnectionClass {

    public $con = null;
    public $con_state = false;
    private $sp_name="";
    private $param_name=null;
    private $param_val =null;

    function __construct() {
        try {
            /** @var For live server
            $server_name = "localhost";
            $user_name = "root";
            $password = "password";
            $db_name = "ngo";

            /** @var for local server*/
            $server_name = "localhost";
            $user_name = "root";
            $password = "password";
            $db_name = "ngo";
            $this->con = new PDO("mysql:host=$server_name;dbname=$db_name", $user_name, $password);
            // set the PDO error mode to exception
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->con->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
            $this -> con_state = true;

        }
        catch(PDOException $e) {
          //  $this -> con = false;
          //  print_r("Sorry, We all have a bad day.Connection To Server Failed. \n"+$e); exit;
throw $e;
        }
    }

    function setParam_name($param_name){
        $this->param_name = $param_name;
    }

    function setParam_val($param_val){
        $this->param_val= $param_val;
    }

    function setSp_name($sp_name){
        $this->sp_name= $sp_name;
    }

    function clearAll(){
        $this->sp_name=null;
        $this->param_name=null;
        $this->param_val=null;
    }

    function InsertInto(){
        try {
            $sql = $this->prepareStatement();
            $stmt = $this->con->prepare($sql);
            $this->bindParameter($stmt);
            $this->clearAll();
            $data = array();
            $i = 0;
            // $data = $stmt->fetchAll();
            try {
                while ($row = $stmt->fetchObject()) {
                    $data[$i++] = (array)$row;
                }
                //$stmt->closeCursor();
                return $data;
            } catch (PDOException $ex) {
            }
        } catch (Exception $ex){
            print_r("Somethine went wrong. Sorry For inoc"); exit;
        }
    }

    private  function prepareStatement(){
        $param = "";
        $param_name=$this->param_name;
        for($i = 0; $i < count($param_name); $i++){
            $param .= ":".$param_name[$i];
            if($i < count($param_name) - 1){
                $param .= ", ";
            }
        }
        $prepareStatement = 'CALL '.$this->sp_name.'('.$param.')';
        return $prepareStatement;
    }

    private function bindParameter($stmt){
        for($i = 0; $i < count($this->param_name); $i++){
            $stmt -> bindParam($this->param_name[$i], $this->param_val[$i]);
        }
        try{
            $stmt -> execute();
        } catch (Exception $ex){
            //print_r($ex); exit;
        }
    }

    function SelectFrom(){
        try {
            $sql = $this->prepareStatement();
            $stmt = $this->con->prepare($sql);
            if ($this->param_name != null) {
                $this->bindParameter($stmt);
            }
            else{
                $stmt->execute();
            }
            $this->clearAll();
            $data = array();
            $i = 0;
           // $data = $stmt->fetchAll();
         //   var_dump($stmt->fetchAll()); exit;
            while($row =  $stmt -> fetchObject()) {
                $data[$i++] = (array)$row;
            }
            $stmt->closeCursor();
            return $data;
        }
        catch(PDOException  $e){
            print_r("Somethine went wrong. Sorry For inoc"); exit;
        }
    }

    function loadSelectOption($so_name, $sp_name, $valuemember,$displaymember){
        $this->setSp_name($sp_name);
        $data_col = $this->SelectFrom();
        echo '<select id='.$so_name.' required="true" class="form-control" name='.$so_name.'>';
        foreach($data_col as $data)
            echo '<option value= '.$data[$valuemember].'>'.$data[$displaymember].' </option>';
        echo '</select>';
    }

    function sendEmail($to, $subject, $message){
        $headers = 'From: webmaster@example.com' ;
        mail($to, $subject, $message, $headers);
    }
}




