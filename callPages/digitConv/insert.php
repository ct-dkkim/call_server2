<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$bbs="CDIGIT";
$reg_date=date("Y-m-d H:i:s");
foreach($_POST as $_tmp['k'] => $_tmp['v']) {
	${$_tmp['k']} = trim($_tmp['v']);
}
$source =addslashes(str_replace("ㅤ","",$source));
$target =addslashes(str_replace("ㅤ","",$target));

if(getenv("REQUEST_METHOD") == 'GET' ) Error($msg['permit1'],"../outline/blank.php");

$mainSql ="SOURCE='$source', TARGET='$target'";

if ($execution=="add") {
	unset($check);
	$check=mysqli_fetch_array(mysqli_query($db,"select SOURCE from $bbs where SOURCE='$source' "));
	if($check[0]) Error($titDigit['dubleSource'],"../outline/blank.php");

	if ($source ) {
		$sql1="insert $bbs set  $mainSql" ;
		if (mysqli_query($db,$sql1) ) {
			mysqli_query($db,"insert EVENT_$bbs  set $mainSql, X_ACTION='I'")	;
			regLog($admin_info[user_id], '4','add','Source - '.$source,'','ENG',$reg_date,'digit') ;
		}
	}
} else {
	if ($old_key != $source) {
		unset($check);
		$check=mysqli_fetch_array(mysqli_query($db,"select SOURCE from $bbs where SOURCE='$source' "));
		if($check[0]) Error($titDigit['dubleSource'] ,"../outline/blank.php");

		$logMsg="$old_key -> $source<br>";

	}

	$sql1= "update $bbs set	$mainSql where source='$old_key'";
	if (mysqli_query($db,$sql1)) {
		mysqli_query($db,"insert EVENT_$bbs  set O_SOURCE='$old_key', $mainSql, X_ACTION='U'")	;
		regLog($admin_info['user_id'], '4','mod','Source - '.$source, $logMsg,'ENG',$reg_date,'digit') ;
	}
}


echo "<script>
	parent.LayerPopup_type2('close')
	window.parent.listRefresh('".$_SESSION['Vars']."');
</script>";

?>

