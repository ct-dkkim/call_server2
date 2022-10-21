<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$reg_date=date("Y-m-d H:i:s");
foreach($_POST as $_tmp['k'] => $_tmp['v']) {
	${$_tmp['k']} = trim($_tmp['v']);
}
$source =addslashes(str_replace("ㅤ","",$source));
$target =addslashes(str_replace("ㅤ","",$target));

if(getenv("REQUEST_METHOD") == 'GET' ) Error($msg['permit1'],"../outline/blank.php");



if ($gubun=="class") {
	$bbs="CLASS";
	$mainSql ="CLASS='$class', EXPLAN='$explan'";
	$main_key = $class; 

	if ($execution=="add") {
		unset($check);
		$check=mysqli_fetch_array(mysqli_query($db,"select CLASS from $bbs where CLASS='$main_key' "));
		if($check[0]) Error($titClass['dubleClass'],"../outline/blank.php");

		if ($main_key ) {
			$sql1="insert $bbs set  $mainSql" ;
			if (mysqli_query($db,$sql1) ) {
				mysqli_query($db,"insert EVENT_$bbs  set $mainSql, X_ACTION='I'")	;
				regLog($admin_info[user_id], '5','add','Class - '.$main_key,'','ENG',$reg_date,'class') ;
			}
		}
	} else {
		if ($old_key != $main_key) {
			unset($check);
			$check=mysqli_fetch_array(mysqli_query($db,"select CLASS from $bbs where CLASS='$main_key' "));
			if($check[0]) Error($titClass['dubleClass'] ,"../outline/blank.php");
			$logMsg="$old_key -> $main_key<br>";
		}

		$sql1= "update $bbs set	$mainSql where CLASS='$old_key'";
		if (mysqli_query($db,$sql1)) {
			mysqli_query($db,"insert EVENT_$bbs  set O_CLASS='$old_key', $mainSql, X_ACTION='U'")	;
			regLog($admin_info['user_id'], '5','mod','Class - '.$main_key, $logMsg,'ENG',$reg_date,'class') ;
		}
	}

	$old_class =$class; 

} else if ($gubun=="use") {
	$bbs="USECLASS";
	$mainSql ="CLASS='$old_class', USECODE='$useCode'";
	$main_key = $useCode; 

	if ($execution=="add") {
		unset($check);
		$check=mysqli_fetch_array(mysqli_query($db,"select USECODE from $bbs where CLASS='$old_class' and USECODE='$main_key' "));
		if($check[0]) Error($titClass['dubleUse'],"../outline/blank.php");

		if ($main_key ) {
			$sql1="insert $bbs set  $mainSql" ;
			if (mysqli_query($db,$sql1) ) {
				mysqli_query($db,"insert EVENT_USECODE  set $mainSql, X_ACTION='I'")	;
				regLog($admin_info[user_id], '5','add','Class - '.$old_class.', Use Code - '.$main_key,'','ENG',$reg_date,'class') ;
			}
		}
	} else {
		if ($old_key != $main_key) {
			unset($check);
			$check=mysqli_fetch_array(mysqli_query($db,"select USECODE from $bbs where CLASS='$old_class' and  USECODE='$main_key' "));
			if($check[0]) Error($titClass['dubleUse'] ,"../outline/blank.php");
			$logMsg="$old_key -> $main_key<br>";
		}

		$sql1= "update $bbs set	$mainSql where CLASS='$old_class' and  USECODE='$old_key'";
		if (mysqli_query($db,$sql1)) {
			mysqli_query($db,"insert EVENT_USECODE  set O_CLASS='$old_class',O_USECODE='$old_key', $mainSql, X_ACTION='U'")	;
			regLog($admin_info['user_id'], '5','mod','Class - '.$old_class.', Use Code - '.$main_key, $logMsg,'ENG',$reg_date,'class') ;
		}
	}

} else if ($gubun=="limit"){
	$bbs="LIMITCLASS";
	$mainSql ="CLASS='$old_class', LIMITCODE='$limitCode'";
	$main_key = $limitCode; 

	if ($execution=="add") {
		unset($check);
		$check=mysqli_fetch_array(mysqli_query($db,"select LIMITCODE from $bbs where CLASS='$old_class' and LIMITCODE='$main_key' "));
		if($check[0]) Error($titClass['dubleLimit'],"../outline/blank.php");

		if ($main_key ) {
			$sql1="insert $bbs set  $mainSql" ;
			if (mysqli_query($db,$sql1) ) {
				mysqli_query($db,"insert EVENT_LIMITCODE  set $mainSql, X_ACTION='I'")	;
				regLog($admin_info[user_id], '5','add','Class - '.$old_class.', Limit Code - '.$main_key,'','ENG',$reg_date,'class') ;
			}
		}
	} else {
		if ($old_key != $main_key) {
			unset($check);
			$check=mysqli_fetch_array(mysqli_query($db,"select LIMITCODE from $bbs where CLASS='$old_class' and  LIMITCODE='$main_key' "));
			if($check[0]) Error($titClass['dubleLimit'] ,"../outline/blank.php");
			$logMsg="$old_key -> $main_key<br>";
		}

		$sql1= "update $bbs set	$mainSql where CLASS='$old_class' and  LIMITCODE='$old_key'";
		if (mysqli_query($db,$sql1)) {
			mysqli_query($db,"insert EVENT_LIMITCODE  set O_CLASS='$old_class',O_LIMITCODE='$old_key', $mainSql, X_ACTION='U'")	;
			regLog($admin_info['user_id'], '5','mod','Class - '.$old_class.', Limit Code - '.$main_key, $logMsg,'ENG',$reg_date,'class') ;
		}
	}
}






echo "<script>
	parent.LayerPopup_type2('close')

	window.parent.getClassList('".$_SESSION['Vars']."', '$old_class');
</script>";

?>

