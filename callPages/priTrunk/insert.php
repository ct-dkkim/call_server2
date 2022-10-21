<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$bbs="PRITG";
$reg_date=date("Y-m-d H:i:s");
foreach($_POST as $_tmp['k'] => $_tmp['v']) {
	${$_tmp['k']} = trim($_tmp['v']);
}
$name =addslashes(str_replace("ㅤ","",$name));

if(getenv("REQUEST_METHOD") == 'GET' ) Error($msg['permit1'],"../outline/blank.php");
if (!$rec) $rec=0 ; 
if (!$port) $port='5060';
$mainSql="
IPADDR='$ipaddr',
PORT='$port',
USER_NAME='$name', 
START_STN='$extNo',
START_TRK='$trkNo',
P_RANGE='$range', 
CID_NO='$cidNum' ,
CID_NO_TYPE='$cidType' ,
BILL_NO ='$billNum' ,
BILL_NO_TYPE='$billType' ,
REC='$rec'
";


if ($execution=="add") {
	unset($check);
	$check=mysqli_fetch_array(mysqli_query($db,"select IPADDR from $bbs where IPADDR='$ipaddr' "));
	if($check[0]) Error($titPritg['dubleIP'],"../outline/blank.php");

	if ($ipaddr ) {
		$sql1="insert $bbs set  $mainSql" ;
		if (mysqli_query($db,$sql1) ) {
			mysqli_query($db,"insert EVENT_$bbs  set $mainSql, X_ACTION='I'")	;
			regLog($admin_info[user_id], '6','add','IP Address - '.$ipaddr,'','ENG',$reg_date,'pri') ;
		}
	}
} else {
	if ($old_key != $ipaddr) {
		unset($check);
		$check=mysqli_fetch_array(mysqli_query($db,"select IPADDR from $bbs where IPADDR='$ipaddr' "));
		if($check[0]) Error($titPritg['dubleIP'],"../outline/blank.php");

		$logMsg="$old_key -> $ipaddr<br>";

	}

	$sql1= "update $bbs set	$mainSql where IPADDR='$old_key'";
	if (mysqli_query($db,$sql1)) {
		mysqli_query($db,"insert EVENT_$bbs  set O_IPADDR='$old_key', $mainSql, X_ACTION='U'")	;
		regLog($admin_info['user_id'], '6','mod','IP Address - '.$ipaddr, $logMsg,'ENG',$reg_date,'pri') ;
	}
}


echo "<script>
	parent.LayerPopup_type2('close')
	window.parent.listRefresh('".$_SESSION['Vars']."');
</script>";

?>

