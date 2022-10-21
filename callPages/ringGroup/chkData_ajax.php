<?php
header('Content-Type: text/html; charset=utf-8 ');
include_once dirname(__FILE__) . "/../../lib/setConfig.php";



list($lastID)=mysqli_fetch_array(mysqli_query($db,"select RCODE from RING_GROUP  where RCODE >'199'  order by RCODE desc limit 1"));
if ($lastID >="999") {
    //마지막코드 998일때  빈코드 출력
    $sql=" SELECT min(RCODE+1) 
           FROM RING_GROUP
           WHERE RCODE >'199' and (RCODE+1) NOT IN (SELECT RCODE FROM  RING_GROUP)";
    list($code)=mysqli_fetch_array(mysqli_query($db,$sql));
    if (!$code) {
        $rcode ="err";
    } else {
       $rcode=sprintf('%03d',$code);
    }
} else {
    if (!$lastID) {
        $rcode="200";
    } else {
        $rcode=sprintf('%03d',$lastID +1);    
    }
}


echo  $rcode;



?>