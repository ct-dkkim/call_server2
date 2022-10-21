<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$reg_date=date("Y-m-d H:i:s");

$gubun=$_POST['gubun'];
$keyClass=$_POST['keyClass'];

$cnt=0;
$chkList=$_POST['chkValue'];
$ArrDelGroup=explode(",", trim($chkList,",")); 


//mysqli_query($db,"LOCK TABLES $bbs WRITE, EVENT_$bbs WRITE");
$html="";
$lockchk=false;
$totalCnt=0;
$aMainAdmin[]="";
$total=count($ArrDelGroup);


if ($gubun=="class") {

	for ($i=0;$i<$total;$i++){
		$nPhone=$ArrDelGroup[$i];
		$lockInfo ="";
		unset($aLockValue);
		if ($nPhone != ""){
			$totalCnt++;
			$delsql="delete from CLASS where CLASS='$nPhone'" ;
			if (mysqli_query($db,$delsql)) {
			   $aDelPhone[]=$nPhone;
			   $eventSql="insert into EVENT_CLASS (O_CLASS , X_ACTION) values ('$nPhone', 'D')";
			    mysqli_query($db,$eventSql) ;	

			    $usesql="delete from USECLASS where CLASS='$nPhone'" ;
			    mysqli_query($db,$usesql);

			    $limitsql="delete from LIMITCLASS where CLASS='$nPhone'" ;
			    mysqli_query($db,$limitsql);


				$cnt++;
				regLog($admin_info['user_id'], '5','del','Class - '.$nPhone , '','ENG',$reg_date,'class') ;
			} else {
				$aErrStaus[]=$nPhone;
			}
		}
	}
	$keyClass ="";
} else if ($gubun=="use") {

	for ($i=0;$i<$total;$i++){
		$nPhone=$ArrDelGroup[$i];
		$lockInfo ="";
		unset($aLockValue);
		if ($nPhone != ""){
			$totalCnt++;
			$delsql="delete from USECLASS where CLASS='$keyClass' and USECODE='$nPhone' " ;

			if (mysqli_query($db,$delsql)) {
			   $aDelPhone[]=$nPhone;
			   $eventSql="insert into EVENT_USECODE (O_CLASS ,O_USECODE, X_ACTION) values ('$keyClass','$nPhone', 'D')";
			    mysqli_query($db,$eventSql) ;	
				$cnt++;
				regLog($admin_info['user_id'], '5','del','Class - '.$keyClass.', Use Code - '.$nPhone , '','ENG',$reg_date,'class') ;
			} else {
				$aErrStaus[]=$nPhone;
			}
		}
	}
} else if ($gubun=="limit") {
	for ($i=0;$i<$total;$i++){
		$nPhone=$ArrDelGroup[$i];
		$lockInfo ="";
		unset($aLockValue);
		if ($nPhone != ""){
			$totalCnt++;
			$delsql="delete from LIMITCLASS where CLASS='$keyClass' and LIMITCODE='$nPhone' " ;

			if (mysqli_query($db,$delsql)) {
			   $aDelPhone[]=$nPhone;
			   $eventSql="insert into EVENT_LIMITCODE (O_CLASS ,O_LIMITCODE, X_ACTION) values ('$keyClass','$nPhone', 'D')";
			    mysqli_query($db,$eventSql) ;	
				$cnt++;
				regLog($admin_info['user_id'], '5','del','Class - '.$keyClass.', Limit Code - '.$nPhone , '','ENG',$reg_date,'class') ;
			} else {
				$aErrStaus[]=$nPhone;
			}
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

$popType = "3" ; 
$headTitle=$titResult['headTitle']['del'];	
include "../outline/popActionResult.php"; 
 


?>