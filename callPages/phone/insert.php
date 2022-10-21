<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$bbs="REGISTER";
$reg_date=date("Y-m-d H:i:s");
foreach($_POST as $_tmp['k'] => $_tmp['v']) {
	${$_tmp['k']} = trim($_tmp['v']);
}
$name =addslashes(str_replace("ㅤ","",$name));

if(getenv("REQUEST_METHOD") == 'GET' ) Error($msg['permit1'],"../outline/blank.php");
if (!$rec) $rec=0 ; 
$dbinfo['name2']=decrypt($decryptKey,$dbinfo['name2']);
$pw=addslashes($pw);
$en_pw=PassEncoding($pw);
$reg_time=time();

$mainSql="
PHONE='$phone',
IPADDR='$ipaddr',
PORT='$port',
MAXDURATION='$maxduration',
CID='$cid' ,
USER_ID='$userid', 
USERNAME='$name',  
PNP_MAC='$mac',
CLASS='$class' ,
TNUMBER='$trunk', 
RGROUP ='$rgroup' ,
PGROUP ='$pgroup' ,
REC='$rec'
";

$phoneSql="
PHONE='$phone',
IPADDR='$ipaddr',
PORT='$port',
EXPIRES='$expires',
MAXDURATION='$maxduration',
CID='$cid' ,
USER_ID='$userid', 
USERNAME='$name',  
PNP_MAC='$mac',
D_NO='0',
PRIORITY='9',
REG_TIME='$reg_time'
";



if ($execution=="add") {
	unset($check);
	$check=mysqli_fetch_array(mysqli_query($db,"select PHONE from $bbs where PHONE='$phone' "));
	if($check[0]) Error($titPhone['dublePhone'],"../outline/blank.php");

	$check=mysqli_fetch_array(mysqli_query($db,"select PHONE from $bbs where PHONE!='$phone' and PNP_MAC='$mac' "));
	if($check[0]) Error($titPhone['errMac'],"../outline/blank.php");


	if ($phone ) {
		$sql1="insert $bbs set  $mainSql,EXPIRES='$expires', PASSWORD='$en_pw'" ;

		if (mysqli_query($db,$sql1) ) {
			mysqli_query($db,"insert EVENT_$bbs  set $mainSql,PASSWORD='$pw', X_ACTION='I'")	;

			if ($config['ptt_server'] == "1") {
				$sql= "insert ".$dbinfo['name2'].".REGISTER  set $phoneSql ,PASSWORD='$en_pw' " ;
				if (mysqli_query($db,$sql)) {
					mysqli_query($db,"insert ".$dbinfo['name2'].".EVENT_REGISTER  set $phoneSql ,PASSWORD='$pw' , X_ACTION='I'" )	;
				};
			 }

			regLog($admin_info[user_id], '2','add','Phone - '.$phone,'','ENG',$reg_date,'phone') ;
		}
	}
} else {
	if ($old_key != $phone) {
		unset($check);
		$check=mysqli_fetch_array(mysqli_query($db,"select PHONE from $bbs where PHONE='$phone' "));
		if($check[0]) Error($titPhone['dublePhone'],"../outline/blank.php");
		$logMsg="$old_key -> $phone<br>";
	}

	$check=mysqli_fetch_array(mysqli_query($db,"select PHONE from $bbs where PHONE!='$phone' and PNP_MAC='$mac' "));
	if($check[0]) Error($titPhone['errMac'],"../outline/blank.php");



	if ($pw) { 
		$add_query=", PASSWORD='$en_pw'";			
	} else {
		list($en_pw)=mysqli_fetch_array(mysqli_query($db,"select PASSWORD from $bbs where PHONE='$old_key'"));
		$pw=PassDecoding(trim($en_pw));
		$pw=trim($pw);
	}


	$sql1= "update $bbs set	$mainSql, EXPIRES='$expires' $add_query where PHONE='$old_key'";

	if (mysqli_query($db,$sql1)) {
		mysqli_query($db,"insert EVENT_$bbs  set O_PHONE='$old_key', $mainSql, PASSWORD='$pw', X_ACTION='U'")	;

		if ($config['ptt_server'] == "1") {
			$sql= "update ".$dbinfo['name2'].".REGISTER  set $phoneSql ,PASSWORD='$en_pw' where PHONE='$old_key'" ;

			if (mysqli_query($db,$sql)) {
				mysqli_query($db,"insert ".$dbinfo['name2'].".EVENT_REGISTER  set O_PHONE='$phone', $phoneSql ,PASSWORD='$pw' , X_ACTION='U'" )	;
			};
		}

		regLog($admin_info['user_id'], '2','mod','Phone - '.$phone, $logMsg,'ENG',$reg_date,'phone') ;
	}
}


echo "<script>
	parent.LayerPopup_type2('close')
	window.parent.listRefresh('".$_SESSION['Vars']."');
</script>";

?>

