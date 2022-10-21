<?php
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
ini_set('memory_limit', -1);

/** PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/../../lib/PHPExcel/IOFactory.php';


$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("../outline/temp_LogList.xls");

$st_day=txt_filter(trim($_POST['st_day']));
$end_day=txt_filter(trim($_POST['end_day']));
$logtype=txt_filter(trim($_POST['logtype']));   //"1"=>"Login/Modifiy","2"=>"LoginSetup","3"=>"PTT PHONE","4"=>"PTT GROUP","5"=>"Commend Center","6"=>"Recording Server","7"=>"history"
$logsub=txt_filter(trim($_POST['logsub']));   //add,mod,del ($aLogSub)
$word=txt_filter(trim($_POST['word']));

//다운로드 완료여부 설정
if (!$_SESSION['downResult']){
	set_session('downResult',false);
} else {
	$_SESSION['downResult'] = false;
}

$table = "PTTLOG";
$order ="REGTIME DESC";



$where[]=" (Project_ID = '".$admin_info['Project_ID']."' or USERID ='$admin_info[user_id]') ";



if ($admin_info['SUB_CODE']+0 > 0) {
	$where[] = " SUB_CODE='".$admin_info['SUB_CODE']."'";
}


if ($st_day !="") {
	$where[] =" REGTIME >='$st_day 00:00:00'";

}
if ($end_day !="") {
	$where[] =" REGTIME <='$end_day 23:59:59'";

}
if ($logtype) {
	$where[] =" ITEM ='$logtype'";

}
if ($logtype && $logsub) {
	$where[] =" ACTION ='$logsub'";

}

if ($word) {
	$where[]=sprintf(" (TITLE like '%s' or CONTENT like '%s')","%$word%","%$word%");

}


if (!$where) {
	$whr = "1";
} else {
	$whr=implode(" and ", $where) ; 
}
if ($_SESSION["ptt_forder"]=="eng") $query="DATE_FORMAT(REGTIME, '%m-%d-%Y %H:%i:%s') as reg_date";
else $query="REGTIME as reg_date";

$sql="select *, $query from $table where $whr order by $order "  ;
$result=mysqli_query($db,$sql);
$line=2;


while ($row = mysqli_fetch_array($result)){
    $sub = $aLogAction[$row['ITEM']][$row['ACTION']];
	$aProject=getProjectInfo($row["Project_ID"]);
	$myTimeZone=$aProject["timeZone"];

	if ($_POST['viewDateType']=="local" && strlen($row["Project_ID"]) =="10" ) {
		$rdate = timeZone_to_date($row["REGTIME"],$myTimeZone );
	} else {
		$rdate= $row['reg_date'];
	}
    $Pid =substr($row["Project_ID"],-3) ; 
    if (!is_numeric($Pid)) $Pid = $row["Project_ID"]; 


	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$line, '['.$Pid.'] '.$rdate)
				->setCellValue('B'.$line, $aProject['Project_Name'])
				->setCellValue('C'.$line, " ".$row['SUB_CODE'])
				->setCellValue('D'.$line, $row['USERID'])
				->setCellValue('E'.$line, $row['USERIP'])
				->setCellValue('F'.$line, $aLogItem[$row['ITEM']])
				->setCellValue('G'.$line, $row['TARGET'])
				->setCellValue('H'.$line, $row['KIND'])
				->setCellValue('I'.$line, $sub)
				->setCellValue('J'.$line, $row['RESULT']);

	$line++;
};

//로그기록
$memo="Date:$st_day ~ $end_day ";
regLog($admin_info['Project_ID'],$admin_info['user_id'], '10','down',$tit['subMenuHistory']['log']." (".$memo.")", "Total : ".($line-2) ,'ENG',$reg_date) ;



// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="LogList('.$st_day.'-'.$end_day.').xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
ob_clean();
flush();
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
$_SESSION['downResult'] = true;

exit;

?>