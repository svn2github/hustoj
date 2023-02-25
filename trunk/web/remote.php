<?php session_start();
     require_once "include/db_info.inc.php";
     require_once "include/init.php";
        $remote_ojs=array(
                "pku"
        );
foreach($remote_ojs as $remote_oj){
        $file="include/remote_$remote_oj.php";
        if(file_exists($file)){
                echo "<iframe src='$file?check' ></iframe>";
        }

}
