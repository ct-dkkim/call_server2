<?php
header('Content-Type: text/html; charset=utf-8 ');
test
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
    //create the SQL query string
    $user=$_POST[ user_id ];

    $sQuery = "Select USER_ID from REGISTER where USER_ID='$user' ";
    $oResult = mysqli_query($db,$sQuery);
    $noNumber= mysqli_num_rows($oResult) ;
    if($sInfo == '') {
        if($oResult and $noNumber > 0) {
            $sInfo = "bad_data";
        } else {
            $sInfo = "";
        }
    }
    echo $sInfo;

?>