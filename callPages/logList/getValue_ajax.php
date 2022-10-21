<?
//header('Content-Type: text/html; charset=euc-kr ');
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
if(getenv("REQUEST_METHOD") == 'GET' ) Error("Wrong approach","");

$bbs="PTTLOG";
$key=xss_db_filter($_POST['key']);


if ($key !="" && is_numeric($key)) {
    //mysqli_query($db,'set names euckr'); //한글깨짐 방지를 위해.. ㅜ.ㅜ
    $sql="select * from $bbs where NO = '".$key."'";
	$row=mysqli_fetch_array(mysqli_query($db,$sql));

    $sub = $aLogSub[$row['LOGMENU']][$row['LOGTYPE']];
    $row['CONTENT'] = str_replace("<br>","\n",$row['CONTENT']);
    $row['CONTENT'] = str_replace("<BR>","\n",$row['CONTENT']);
	$row['LOGMENU'] = $aLogType[$row['LOGMENU']];
	$row['TITLE'].= " ".$sub;

	echo json_encode($row);

}

?>