<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$bbs="TRUNK_NUMBER";
$reg_date=date("Y-m-d H:i:s");



$cnt=0;
$chkList=getArrValue($_SESSION['Vars'], "chkvalue");
$ArrDelGroup=explode(",", trim($chkList,",")); 


//mysqli_query($db,"LOCK TABLES $bbs WRITE, EVENT_$bbs WRITE");
$html="";
$lockchk=false;
$totalCnt=0;
$total=count($ArrDelGroup);
$aMainAdmin[]="";
for ($i=0;$i<$total;$i++){
	$nPhone=$ArrDelGroup[$i];
	$lockInfo ="";
	unset($aLockValue);
	if ($nPhone != ""){
		$totalCnt++;
		$delsql="delete from $bbs where TNUMBER='$nPhone'" ;
		if (mysqli_query($db,$delsql)) {
		   $aDelPhone[]=$nPhone;
		   $eventSql="insert into EVENT_$bbs (O_TNUMBER , X_ACTION) values ('$nPhone', 'D')";
		    mysqli_query($db,$eventSql) ;	
			$cnt++;
			regLog($admin_info['user_id'], '8','del','Trunk Number  - '.$nPhone , '','ENG',$reg_date,'etc_trunk') ;
		} else {
			$aErrStaus[]=$nPhone;
		}
	}
}



$errCnt=0;
$result= "<li>* ".$titResult['result']['success']." :";
if (count($aDelPhone) <1){
	$result.=$titResult['result']['noMsg']."</li><br>";
} else {
	$result.=implode(", ", $aDelPhone)."</li><br>";
} 

//DB 에러 
if (is_array($aErrStaus)){
	$errSatusCnt=count($aErrStaus);
	for($i=0;$i<$errSatusCnt;$i++) {
		$errCnt++;
		$result.= "<li>$errCnt. <b>".$aErrStaus[$i]."</b> : ".$msg['errDeldb']." </li>";
	}
}

//$result.="<li>".$eventSql."</li>";

//mysqli_query($db,"UNLOCK TABLES");


$headTitle=$titResult['headTitle']['del'];	
include "../outline/popActionResult.php"; 
 


?>