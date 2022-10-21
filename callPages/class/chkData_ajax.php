<?php
header('Content-Type: text/html; charset=utf-8 ');
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
    //create the SQL query string
    $gubun=$_POST['gubun'];
    $class=$_POST['class'];
    $key=$_POST['key'];


    if ($gubun=="class") {
        $sQuery = "Select CLASS from CLASS where CLASS='$key' ";
    } else if ($gubun=="use") {
        $sQuery = "Select USECODE from USECLASS where CLASS='$class' and  USECODE='$key'";
    } else if ($gubun=="limit") {
        $sQuery = "Select LIMITCODE from LIMITCLASS where CLASS='$class' and  LIMITCODE='$key'";

    }

    
    $oResult = mysqli_query($db,$sQuery);
    $noNumber= mysqli_num_rows($oResult) ;
    $sInfo = '';
    if($oResult and $noNumber > 0) {
        $sInfo = "bad_data";
    } else {
          $sInfo = "";
    }
    
    echo $sInfo;

?>