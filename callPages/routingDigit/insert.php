<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$bbs="PREFIX";
$reg_date=date("Y-m-d H:i:s");
foreach($_POST as $_tmp['k'] => $_tmp['v']) {
	${$_tmp['k']} = trim($_tmp['v']);
}
$prefix =addslashes(str_replace("ㅤ","",$prefix));
if(getenv("REQUEST_METHOD") == 'GET' ) Error($msg['permit1'],"../outline/blank.php");

$mainSql ="PREFIX='$prefix', IPADDR='$ipaddr', PORT='$port', ROUTING='$routing'";

if ($execution=="add") {
	unset($check);
	$check=mysqli_fetch_array(mysqli_query($db,"select PREFIX from $bbs where PREFIX='$prefix' "));
	if($check[0]) Error($msgRouting['dublePrefix'],"../outline/blank.php");

	if ($prefix ) {
		$sql1="insert $bbs set  $mainSql" ;
		if (mysqli_query($db,$sql1) ) {
			mysqli_query($db,"insert EVENT_$bbs  set $mainSql, X_ACTION='I'")	;
			regLog($admin_info[user_id], '3','add',$prefix,'','ENG',$reg_date,'rout_prefix') ;
		}
	}
} else {
	if ($old_key != $prefix) {
		unset($check);
		$check=mysqli_fetch_array(mysqli_query($db,"select PREFIX from $bbs where PREFIX='$prefix'"));
		if($check[0]) Error($msgRouting['dublePrefix'],"../outline/blank.php");

		$logMsg="$old_key -> $prefix<br>";

	}

	$sql1= "update $bbs set	$mainSql where PREFIX='$old_key'";
	if (mysqli_query($db,$sql1)) {
		mysqli_query($db,"insert EVENT_$bbs  set O_PREFIX='$old_key', $mainSql, X_ACTION='U'")	;
		regLog($admin_info['user_id'], '3','mod',$prefix, $logMsg,'ENG',$reg_date,'rout_prefix') ;
	}
}


echo "<script>
	parent.LayerPopup_type2('close')
	window.parent.listRefresh('".$_SESSION['Vars']."');
</script>";

?>

