<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$bbs="web_admin";
$reg_date=date("Y-m-d H:i:s");
foreach($_POST as $_tmp['k'] => $_tmp['v']) {
	${$_tmp['k']} = trim($_tmp['v']);
}
$userid =addslashes(str_replace("ㅤ","",$userid));
if(getenv("REQUEST_METHOD") == 'GET' ) Error($msg['permit1'],"../outline/blank.php");
$date=time();

$password= PassEncoding($pw);


$mainSql ="name='$c_name', level='$c_level',";
if ($pw)  $mainSql.= " password='$password'," ;
$mainSql .=" email='$email', user_view='$user_view', user_add='$user_add', user_mod='$user_mod', user_del='$user_del', phone_view='$phone_view', phone_add='$phone_add', phone_mod='$phone_mod', phone_del='$phone_del', routing_view='$routing_view', routing_add='$routing_add', routing_mod='$routing_mod', routing_del='$routing_del', conversion_view='$conversion_view', conversion_add='$conversion_add', conversion_mod='$conversion_mod', conversion_del='$conversion_del', class_view='$class_view', class_add='$class_add', class_mod='$class_mod', class_del='$class_del', ptt_view='$ptt_view', ptt_add='$ptt_add', ptt_mod='$ptt_mod', ptt_del='$ptt_del'";

if ($execution=="add") {
	unset($check);
	$check=mysqli_fetch_array(mysqli_query($db,"select user_id from $bbs where user_id='$userid' "));
	if($check[0]) Error($titAdmin['dubleID'],"../outline/blank.php");

	if ($userid ) {
		$sql1="insert $bbs set  user_id='$userid', $mainSql ,reg_date='$date'" ;
		if (mysqli_query($db,$sql1) ) {
			regLog($admin_info[user_id], '9','add',"Admin ID-".$userid,'','ENG',$reg_date,'') ;
		}
	}
} else {
	if ($old_key != $userid) {
		unset($check);
		$check=mysqli_fetch_array(mysqli_query($db,"select user_id from $bbs where user_id='$userid'"));
		if($check[0]) Error($titAdmin['dubleID'],"../outline/blank.php");

		$logMsg="$old_key -> $userid<br>";

	}

	$sql1= "update $bbs set	$mainSql ,modi_date='$date' where user_id='$old_key'";
	if (mysqli_query($db,$sql1)) {
		regLog($admin_info['user_id'], '9','mod',"Admin ID-".$userid, $logMsg,'ENG',$reg_date,'') ;
	}
}



echo "<script>
	parent.LayerPopup_type2('close')
	window.parent.listRefresh('".$_SESSION['Vars']."');
</script>";

?>

