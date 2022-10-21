<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$bbs="EDIGIT ";
$reg_date=date("Y-m-d H:i:s");
foreach($_POST as $_tmp['k'] => $_tmp['v']) {
	${$_tmp['k']} = trim($_tmp['v']);
}
$source =addslashes(str_replace("ㅤ","",$source));
$target =addslashes(str_replace("ㅤ","",$target));
if(getenv("REQUEST_METHOD") == 'GET' ) Error($msg['permit1'],"../outline/blank.php");

$mainSql ="	PHONE='$phone', SOURCE='$source', TARGET='$target'";

if ($execution=="add") {
	unset($check);
	$check=mysqli_fetch_array(mysqli_query($db,"select PHONE from $bbs where PHONE='$phone' and SOURCE='$source' "));
	if($check[0]) Error($titDigit['dublePhone'],"../outline/blank.php");
	if ($phone!="") {
		$sql1="insert $bbs set  $mainSql" ;
		if (mysqli_query($db,$sql1) ) {
			mysqli_query($db,"insert EVENT_$bbs  set $mainSql, X_ACTION='I'")	;
			regLog($admin_info[user_id], '4','add','Phone - '.$phone." : ".$source,'','ENG',$reg_date,'digit_group') ;
		}
	}
} else {
	if ($old_key != $phone || $old_key2 != $source) {
		unset($check);
		$check=mysqli_fetch_array(mysqli_query($db,"select PHONE from $bbs where PHONE='$phone' and SOURCE='$source' "));
		if($check[0]) Error($titDigit['dublePhone'],"../outline/blank.php");

		if ($old_key != $phone) {
			$logMsg="Phone : $old_key -> $phone<br>";
		}
		if ($old_key2 != $source) {
			$logMsg.="Source : $old_key2 -> $source<br>";
		}

	}

	$sql1= "update $bbs set	$mainSql where PHONE='$old_key' and SOURCE='$old_key2'";
	if (mysqli_query($db,$sql1)) {
		mysqli_query($db,"insert EVENT_$bbs  set O_PHONE='$old_key',O_SOURCE='$old_key2', $mainSql, X_ACTION='U'")	;
		regLog($admin_info['user_id'], '4','mod','Phone - '.$phone." : ".$source, $logMsg,'ENG',$reg_date,'digit_group') ;
	}
}


echo "<script>
	parent.LayerPopup_type2('close')
	window.parent.listRefresh('".$_SESSION['Vars']."');
</script>";

?>

