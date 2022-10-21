<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$bbs="HUNTGROUP";
$reg_date=date("Y-m-d H:i:s");
foreach($_POST as $_tmp['k'] => $_tmp['v']) {
	${$_tmp['k']} = trim($_tmp['v']);
}
$hgroup =addslashes(str_replace("ㅤ","",$hgroup));
$phone =addslashes(str_replace("ㅤ","",$phone));

if(getenv("REQUEST_METHOD") == 'GET' ) Error($msg['permit1'],"../outline/blank.php");

$mainSql ="HGROUP='$hgroup', TELNO='$phone'";

if ($execution=="add") {
	unset($check);
	$check=mysqli_fetch_array(mysqli_query($db,"select HGROUP from $bbs where HGROUP='$hgroup' "));
	if($check[0]) Error($titEtc['dubleHgroup'],"../outline/blank.php");

	if ($hgroup ) {
		$sql1="insert $bbs set  $mainSql" ;
		if (mysqli_query($db,$sql1) ) {
			mysqli_query($db,"insert EVENT_$bbs  set $mainSql, X_ACTION='I'")	;
			regLog($admin_info[user_id], '8','add','Hunt Group - '.$hgroup,'','ENG',$reg_date,'etc_hunt') ;
		}
	}
} else {
	if ($old_key != $hgroup) {
		unset($check);
		$check=mysqli_fetch_array(mysqli_query($db,"select HGROUP from $bbs where HGROUP='$hgroup' "));
		if($check[0]) Error($titEtc['dubleHgroup'] ,"../outline/blank.php");

		$logMsg="$old_key -> $hgroup<br>";

	}

	$sql1= "update $bbs set	$mainSql where hgroup='$old_key'";
	if (mysqli_query($db,$sql1)) {
		mysqli_query($db,"insert EVENT_$bbs  set O_HGROUP='$old_key', $mainSql, X_ACTION='U'")	;
		regLog($admin_info['user_id'], '8','mod','Hunt Group - '.$hgroup, $logMsg,'ENG',$reg_date,'etc_hunt') ;
	}
}


echo "<script>
	parent.LayerPopup_type2('close')
	window.parent.listRefresh('".$_SESSION['Vars']."');
</script>";

?>

