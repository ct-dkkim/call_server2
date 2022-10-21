<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$bbs="web_admin";
$reg_date=date("Y-m-d H:i:s");
foreach($_POST as $_tmp['k'] => $_tmp['v']) {
	${$_tmp['k']} = trim($_tmp['v']);
}
if(getenv("REQUEST_METHOD") == 'GET' ) Error($msg['permit1'],"../outline/blank.php");
$date=time();

$password= PassEncoding($pw);


$mainSql ="name='$c_name',";
if ($pw)  $mainSql.= " password='$password'," ;
$mainSql .=" email='$email', ";



$sql1= "update $bbs set	$mainSql modi_date='$date' where no='$mno'";
if (mysqli_query($db,$sql1)) {
	regLog($admin_info['user_id'], '9','mymod',"Admin ID-".$userid, $logMsg,'ENG',$reg_date,'') ;
}



echo "<script>
	alert('ok')
	parent.LayerPopup_type2('close')	
</script>";

?>

