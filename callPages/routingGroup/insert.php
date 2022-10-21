<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$bbs="GPREFIX ";
$reg_date=date("Y-m-d H:i:s");
foreach($_POST as $_tmp['k'] => $_tmp['v']) {
	${$_tmp['k']} = trim($_tmp['v']);
}
$prefix =addslashes(str_replace("ㅤ","",$prefix));
if(getenv("REQUEST_METHOD") == 'GET' ) Error($msg['permit1'],"../outline/blank.php");

$mainSql ="RGROUP='$rgroup', PREFIX='$prefix', ROUTING_IP='$rout_ip', PORT='$port', ROUTING='$routing'";

if ($execution=="add") {
	unset($check);
	$check=mysqli_fetch_array(mysqli_query($db,"select RGROUP from $bbs where RGROUP='$rgroup' and PREFIX='$prefix' "));
	if($check[0]) Error($msgRouting['dubleGroup'],"../outline/blank.php");

	if ($prefix ) {
		$sql1="insert $bbs set  $mainSql" ;
		if (mysqli_query($db,$sql1) ) {
			mysqli_query($db,"insert EVENT_$bbs  set $mainSql, X_ACTION='I'")	;
			//echo "insert EVENT_$bbs  set $mainSql, X_ACTION='I'" ; 
			regLog($admin_info[user_id], '3','add','Group-'.$rgroup." : ".$prefix,'','ENG',$reg_date,'rout_group') ;
		}
	}
} else {
	if ($old_key != $rgroup || $old_key2 != $prefix) {
		unset($check);
		$check=mysqli_fetch_array(mysqli_query($db,"select RGROUP from $bbs where RGROUP='$rgroup' and PREFIX='$prefix' "));
		if($check[0]) Error($msgRouting['dubleGroup'],"../outline/blank.php");

		if ($old_key != $ipaddr) {
			$logMsg="Group : $old_key -> $rgroup<br>";
		}
		if ($old_key2 != $prefix) {
			$logMsg.="PREFIX : $old_key2 -> $prefix<br>";
		}

	}

	$sql1= "update $bbs set	$mainSql where RGROUP='$old_key' and PREFIX='$old_key2'";
	if (mysqli_query($db,$sql1)) {
		mysqli_query($db,"insert EVENT_$bbs  set O_RGROUP='$old_key',O_PREFIX='$old_key2', $mainSql, X_ACTION='U'")	;
		//echo "insert EVENT_$bbs  set O_RGROUP='$old_key',O_PREFIX='$old_key2', $mainSql, X_ACTION='U'"; 
		regLog($admin_info['user_id'], '3','mod','Group-'.$rgroup." : ".$prefix, $logMsg,'ENG',$reg_date,'rout_group') ;
	}
}


echo "<script>
	parent.LayerPopup_type2('close')
	window.parent.listRefresh('".$_SESSION['Vars']."');
</script>";

?>

