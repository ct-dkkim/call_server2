<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$bbs="TRUNK_NUMBER";
$reg_date=date("Y-m-d H:i:s");
foreach($_POST as $_tmp['k'] => $_tmp['v']) {
	${$_tmp['k']} = trim($_tmp['v']);
}
$tnumber =addslashes(str_replace("ㅤ","",$tnumber));
$tname =addslashes(str_replace("ㅤ","",$tname));

if(getenv("REQUEST_METHOD") == 'GET' ) Error($msg['permit1'],"../outline/blank.php");

$mainSql ="TNUMBER='$tnumber', TNAME='$tname' , TPORT='$tport' , RCODE='$rcode' ";

if ($execution=="add") {
	unset($check);
	$check=mysqli_fetch_array(mysqli_query($db,"select TNUMBER from $bbs where TNUMBER='$tnumber' "));
	if($check[0]) Error($titEtc['dubleTnumber'],"../outline/blank.php");

	if ($tnumber ) {
		$sql1="insert $bbs set  $mainSql" ;
		if (mysqli_query($db,$sql1) ) {
			mysqli_query($db,"insert EVENT_$bbs  set $mainSql, X_ACTION='I'")	;
			regLog($admin_info[user_id], '8','add','Trunk Number - '.$tnumber,'','ENG',$reg_date,'etc_trunk') ;
		}
	}
} else {
	if ($old_key != $tnumber) {
		unset($check);
		$check=mysqli_fetch_array(mysqli_query($db,"select TNUMBER from $bbs where TNUMBER='$tnumber' "));
		if($check[0]) Error($titEtc['dubleTnumber'] ,"../outline/blank.php");

		$logMsg="$old_key -> $tnumber<br>";

	}

	$sql1= "update $bbs set	$mainSql where tnumber='$old_key'";
	if (mysqli_query($db,$sql1)) {
		mysqli_query($db,"insert EVENT_$bbs  set O_TNUMBER='$old_key', $mainSql, X_ACTION='U'")	;
		regLog($admin_info['user_id'], '8','mod','Trunk Number  - '.$tnumber, $logMsg,'ENG',$reg_date,'etc_trunk') ;
	}
}


echo "<script>
	parent.LayerPopup_type2('close')
	window.parent.listRefresh('".$_SESSION['Vars']."');
</script>";

?>

