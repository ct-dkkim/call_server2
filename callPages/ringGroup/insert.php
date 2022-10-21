<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$bbs="RING_GROUP";
$reg_date=date("Y-m-d H:i:s");
foreach($_POST as $_tmp['k'] => $_tmp['v']) {
	${$_tmp['k']} = txt_filter_del(trim($_tmp['v']));
}

$name =addslashes(str_replace("ㅤ","",$name));

$phone =trim($addMacList,",");
$phone =addslashes(str_replace("ㅤ","",$phone));
if(getenv("REQUEST_METHOD") == 'GET' ) Error($msg['permit1'],"../outline/blank.php");

if ($rcode1=="add") $rcode1 =$rcode2; 


$mainSql ="RCODE='$rcode1',RNAME='$name', RTYPE='$rtype', PNUMBERS='$phone'";

if ($execution=="add") {
	unset($check);
	$check=mysqli_fetch_array(mysqli_query($db,"select RCODE from $bbs where RCODE='$rcode' "));
	if($check[0]) Error($msgRouting['dublePrefix'],"../outline/blank.php");

	if ($rcode1 ) {
		$sql1="insert $bbs set  $mainSql" ;
		if (mysqli_query($db,$sql1) ) {
			mysqli_query($db,"insert EVENT_$bbs  set $mainSql, X_ACTION='I'")	;
			regLog($admin_info[user_id], '8','add', "Ring Group - ".$rcode1,'','ENG',$reg_date,'etc_groupRring') ;
		}
	}
} else {
	if ($old_key != $rcode1) {
		unset($check);
		$check=mysqli_fetch_array(mysqli_query($db,"select RCODE from $bbs where RCODE='$rcode1'"));
		if($check[0]) Error($msgRouting['dublePrefix'],"../outline/blank.php");

		$logMsg="$old_key -> $rcode1<br>";

	}

	$sql1= "update $bbs set	$mainSql where RCODE='$old_key'";
	if (mysqli_query($db,$sql1)) {
		mysqli_query($db,"insert EVENT_$bbs  set O_RCODE='$old_key', $mainSql, X_ACTION='U'")	;
		regLog($admin_info['user_id'], '8','mod',"Ring Group - ".$rcode1, $logMsg,'ENG',$reg_date,'etc_groupRring') ;
	}
}


echo "<script>
	parent.LayerPopup_type2('close')
	window.parent.listRefresh('".$_SESSION['Vars']."');
</script>";

?>

