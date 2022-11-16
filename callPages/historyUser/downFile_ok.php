<?php
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
ini_set('memory_limit', -1);

/** PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/../../lib/PHPExcel/IOFactory.php';

 //변수처리
$arrVars=explode("&",$_SESSION['Vars']);
 for ($i=0;$i<sizeof($arrVars);$i++) {
	 $arr=explode("=",$arrVars[$i]);
	 ${$arr[0]}=$arr[1];
 }

//다운로드 완료여부 설정
if (!$_SESSION['downResult']){
	set_session('downResult',false);
} else {
	$_SESSION['downResult'] = false;
}


$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("../outline/temp_historyuser.xls");

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX PTT_SERVER Document")
							 ->setSubject("Office 2007 XLSX PTT_SERVER Document")
							 ->setDescription("PTT_SERVER document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("PTT_SERVER Phone Number result file");



$table = "CALL_HISTORY";
$order =" TELNO ";
		$st_date=$st_day.$st_time;
		$end_date=$end_day.$end_time;


		if ($st_day) {
			$where[] =" CONCAT(CALLDATE,CALLTIME)  >='$st_date'";

		}
		if ($end_day) {
			$where[] =" CONCAT(CALLDATE,CALLTIME)  <='$end_date'";
		}



		if ($ftype !="") {
			$where[] =" CALLTYPE ='$ftype'";
		}

		if ($fstatus !="") {
			$where[] =" CALLSTAT ='$fstatus'";
		}

 	    if (isset($word)==true && $word!="") {

		  if ($find) {
			  $where[] ="  $find like '%$word%'";	
		  } else {
			  //검색조건이 전체일때 통합검색
			  $wh[] ="TELNO like '%$word%'";
			  $w=implode(" or ", $wh);
              $where[] ="($w)";			
		  }
		}

if (!$where) {
	$whr = "1";
} else {
	$whr=implode(" and ", $where) ; 
}


$sql="select TELNO,
COUNT(TELNO) as totalCnt,
COALESCE(
	SUM(
		TIME_TO_SEC(TIMEDIFF(CONCAT(ENDDATE,' ',ENDTIME),CONCAT(CALLDATE,' ',CALLTIME)))
	)
,0)	AS totalDuration,
count(case when CALLTYPE ='TRK' then TELNO end) as trkCnt,	
COALESCE(
	SUM(
		case when CALLTYPE ='TRK' then 
		TIME_TO_SEC(TIMEDIFF(CONCAT(ENDDATE,' ',ENDTIME),CONCAT(CALLDATE,' ',CALLTIME)))
		end
	)	
,0)	AS trkDuration,
count(case when CALLTYPE ='INC' then TELNO end) as incCnt,	
COALESCE(
	SUM(
		case when CALLTYPE ='INC' then 
		TIME_TO_SEC(TIMEDIFF(CONCAT(ENDDATE,' ',ENDTIME),CONCAT(CALLDATE,' ',CALLTIME)))
		end
	)	
,0)	AS incDuration,
count(case when CALLTYPE ='STN' then TELNO end) as stnCnt,	
COALESCE(
	SUM(
		case when CALLTYPE ='STN' then 
		TIME_TO_SEC(TIMEDIFF(CONCAT(ENDDATE,' ',ENDTIME),CONCAT(CALLDATE,' ',CALLTIME)))
		end
	)	
,0)	AS stnDuration 
from $table where $whr GROUP BY TELNO  order by $order "  ;
$result=mysqli_query($db,$sql);
$line=2;

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('J1', $sql);


while ($row = mysqli_fetch_array($result)){
		$st_date =  date($dateType, strtotime($row["CALLDATE"]." ".$row['CALLTIME']));
		if (strtotime($row["ENDDATE"]) > 0) {
			$end_date =  date($dateType, strtotime($row["ENDDATE"]." ".$row['ENDTIME']));
		}  else {
			$end_date="";
		}	

		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$line, " ".$row['TELNO'])
					->setCellValue('B'.$line, $row['trkCnt'])
					->setCellValue('C'.$line, get_time($row['trkDuration']))
					->setCellValue('D'.$line, $row['incCnt'])
					->setCellValue('E'.$line, get_time($row['incDuration']))
					->setCellValue('F'.$line, $row['stnCnt'])
					->setCellValue('G'.$line, get_time($row['stnDuration']))
					->setCellValue('H'.$line, $row['totalCnt'])
					->setCellValue('I'.$line, get_time($row['totalDuration']));
			$line++;
		};


$reg_date=date("Y-m-d H:i:s");


regLog($admin_info['user_id'], '11','down',$tit['mainTitle']['history_user'], ($line-2)." ".$msg['unit'] ,'ENG',$reg_date,'') ;

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle( );

$fileName='Session('.$st_day.'-'.$end_day.')';

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$fileName.'.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
ob_clean();
flush();
// If you're serving to IE over SSL, then the following may be needed
/*
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
*/
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
$_SESSION['downResult'] = true;

exit;


?>
