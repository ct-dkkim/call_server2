<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$bbs="PICKUPGROUP";
$reg_date=date("Y-m-d H:i:s");
foreach($_POST as $_tmp['k'] => $_tmp['v']) {
	${$_tmp['k']} = trim($_tmp['v']);
}
$pcode =addslashes(str_replace("ㅤ","",$pcode));
$pname =addslashes(str_replace("ㅤ","",$pname));

if(getenv("REQUEST_METHOD") == 'GET' ) Error($msg['permit1'],"../outline/blank.php");

$mainSql ="PCODE='$pcode', PNAME='$pname'";

if ($execution=="add") {
	unset($check);
	$check=mysqli_fetch_array(mysqli_query($db,"select PCODE from $bbs where PCODE='$pcode' "));
	if($check[0]) Error($titEtc['dublePcode'],"../outline/blank.php");

	if ($pcode ) {
		$sql1="insert $bbs set  $mainSql" ;
		if (mysqli_query($db,$sql1) ) {
			mysqli_query($db,"insert EVENT_$bbs  set $mainSql, X_ACTION='I'")	;
			regLog($admin_info[user_id], '8','add','Group - '.$pcode,'','ENG',$reg_date,'etc_cpgroup') ;
		}
	}
} else {
	if ($old_key != $pcode) {
		unset($check);
		$check=mysqli_fetch_array(mysqli_query($db,"select PCODE from $bbs where PCODE='$pcode' "));
		if($check[0]) Error($titEtc['dublePcode'] ,"../outline/blank.php");

		$logMsg="$old_key -> $pcode<br>";

	}

	$sql1= "update $bbs set	$mainSql where PCODE='$old_key'";
	if (mysqli_query($db,$sql1)) {
		mysqli_query($db,"insert EVENT_$bbs  set O_PCODE='$old_key', $mainSql, X_ACTION='U'")	;
		regLog($admin_info['user_id'], '8','mod','Group - '.$pcode, $logMsg,'ENG',$reg_date,'etc_cpgroup') ;
	}
}


echo "<script>
	parent.LayerPopup_type2('close')
	window.parent.listRefresh('".$_SESSION['Vars']."');
</script>";

?>

