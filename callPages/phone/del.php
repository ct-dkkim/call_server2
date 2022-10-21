<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$bbs="REGISTER";
$reg_date=date("Y-m-d H:i:s");


$dbinfo['name2']=decrypt($decryptKey,$dbinfo['name2']);

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
		$delsql="delete from $bbs where PHONE='$nPhone'" ;
		if (mysqli_query($db,$delsql)) {
		   $aDelPhone[]=$nPhone;
		   $eventSql="insert into EVENT_$bbs (O_PHONE , X_ACTION) values ('$nPhone', 'D')";
		    mysqli_query($db,$eventSql) ;	

			 if ($config['ptt_server'] == "1") {
				$sql= "delete from ".$dbinfo['name2'].".REGISTER  where PHONE='$nPhone'" ;
				if (mysqli_query($db,$sql)) {
					mysqli_query($db,"insert into ".$dbinfo['name2'].".EVENT_REGISTER ( O_PHONE, X_ACTION) values ('$nPhone','D')")	;
				};
			 }


		    
			$cnt++;
			regLog($admin_info['user_id'], '2','del','Phone - '.$nPhone , '','ENG',$reg_date,'phone') ;
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