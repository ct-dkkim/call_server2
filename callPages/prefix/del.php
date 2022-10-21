<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";



//처리결과 
$result= "<li>* ".$titResult['result']['success']." : 삭제된 리스트 </li><br>";  //성공시
//mysqli_query($db,"UNLOCK TABLES");
$headTitle=$titResult['headTitle']['del'];	
include "../outline/popActionResult.php"; 
 


?>