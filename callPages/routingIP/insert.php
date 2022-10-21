<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$bbs="IPREFIX";
$reg_date=date("Y-m-d H:i:s");
foreach($_POST as $_tmp['k'] => $_tmp['v']) {
	${$_tmp['k']} = trim($_tmp['v']);
}
$prefix =addslashes(str_replace("ㅤ","",$prefix));
if(getenv("REQUEST_METHOD") == 'GET' ) Error($msg['permit1'],"../outline/blank.php");

$mainSql ="IPADDR='$ipaddr', PREFIX='$prefix', ROUTING_IP='$rout_ip', PORT='$port', ROUTING='$routing'";

if ($execution=="add") {
	unset($check);
	$check=mysqli_fetch_array(mysqli_query($db,"select IPADDR from $bbs where IPADDR='$ipaddr' and PREFIX='$prefix' "));
	if($check[0]) Error($msgRouting['dubleIP'],"../outline/blank.php");

	if ($prefix ) {
		$sql1="insert $bbs set  $mainSql" ;
		if (mysqli_query($db,$sql1) ) {
			mysqli_query($db,"insert EVENT_$bbs  set $mainSql, X_ACTION='I'")	;
			regLog($admin_info[user_id], '3','add',"IP-".$ipaddr." : ".$prefix,'','ENG',$reg_date,'rout_ip') ;
		}
	}
} else {
	if ($old_key != $ipaddr || $old_key2 != $prefix) {
		unset($check);
		$check=mysqli_fetch_array(mysqli_query($db,"select IPADDR from $bbs where IPADDR='$ipaddr' and PREFIX='$prefix' "));
		if($check[0]) Error($msgRouting['dubleIP'],"../outline/blank.php");

		if ($old_key != $ipaddr) {
			$logMsg="IP:$old_key -> $ipaddr<br>";
		}
		if ($old_key2 != $prefix) {
			$logMsg.="PREFIX:$old_key2 -> $prefix<br>";
		}

	}

	$sql1= "update $bbs set	$mainSql where IPADDR='$old_key' and PREFIX='$old_key2'";
	if (mysqli_query($db,$sql1)) {
		mysqli_query($db,"insert EVENT_$bbs  set O_IPADDR='$old_key',O_PREFIX='$old_key2', $mainSql, X_ACTION='U'")	;
		regLog($admin_info['user_id'], '3','mod',"IP-".$ipaddr." : ".$prefix, $logMsg,'ENG',$reg_date,'rout_ip') ;
	}
}


echo "<script>
	parent.LayerPopup_type2('close')
	window.parent.listRefresh('".$_SESSION['Vars']."');
</script>";

?>

