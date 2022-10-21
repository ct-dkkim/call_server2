<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$bbs="FUNCTION_CODE";
$value=$_POST["c_box"];


	for ($i=0;$i<sizeof($value);$i++) {
		$value[$i]=mysqli_real_escape_string($db, trim($value[$i]));
	}
	
	$result=mysqli_query($db,"select * from $bbs limit 1");
	$row=mysqli_fetch_array($result);

	if ($row[CFAS] || $row[CFBS] || $row[CFNS]) {
		//update
		if ($row[CFAS] != $value[0]) $logMsg .="CFAS : ".$row[CFAS]." -> ".$value[0]."<br>";
		if ($row[CFBS] != $value[1]) $logMsg .="CFBS : ".$row[CFBS]." -> ".$value[1]."<br>";
		if ($row[CFNS] != $value[2]) $logMsg .="CFNS : ".$row[CFNS]." -> ".$value[2]."<br>";
		if ($row[CFR] != $value[3]) $logMsg .="CFR : ".$row[CFR]." -> ".$value[3]."<br>";
		if ($row[CPD] != $value[4]) $logMsg .="CPD : ".$row[CPD]." -> ".$value[4]."<br>";
		if ($row[CPG] != $value[5]) $logMsg .="CPG : ".$row[CPG]." -> ".$value[5]."<br>";
		if ($row[DNDS] != $value[6]) $logMsg .="DNDS : ".$row[DNDS]." -> ".$value[6]."<br>";
		if ($row[DNDR] != $value[7]) $logMsg .="DNDR : ".$row[DNDR]." -> ".$value[7]."<br>";

		$sql5="update $bbs set	CFAS='$value[0]', CFBS='$value[1]', CFNS='$value[2]', CFR='$value[3]',  CPD='$value[4]', CPG='$value[5]',   DNDS='$value[6]',  DNDR='$value[7]' ";
		$act = "mod";
	} else {
		$sql5="insert into $bbs set	CFAS='$value[0]', CFBS='$value[1]', CFNS='$value[2]', CFR='$value[3]',  CPD='$value[4]', CPG='$value[5]',   DNDS='$value[6]',  DNDR='$value[7]' ";
		$act = "add";

	}

    $sql5_sub="insert into EVENT_$bbs (CFAS,CFBS,CFNS,CFR,CPD,CPG,DNDS,DNDR, X_ACTION) values ('$value[0]', '$value[1]', '$value[2]', '$value[3]', '$value[4]', '$value[5]', '$value[6]', '$value[7]',  'U')";

    if(getenv("REQUEST_METHOD") == 'GET' ) Error($msg['permit1'],"../outline/blank.php");


	if (mysqli_query($db,$sql5)) {
		 mysqli_query($db,$sql5_sub)	;
		 echo $sql5_sub; 
	};



regLog($admin_info['user_id'], '8',$act,$tit['mainTitle']['etc_func'], $logMsg,'ENG',$reg_date,'etc_func') ;



echo "<script>
	window.parent.location.href='./write.php';
</script>";

?>

