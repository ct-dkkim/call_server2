<?php
header('Content-Type: text/html; charset=utf-8 ');
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
    //create the SQL query string
    $key=$_POST['key' ];
    $key2=$_POST['key2' ];
    $sQuery = "Select IPADDR from IPREFIX where IPADDR='$key' and PREFIX='$key2' ";
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