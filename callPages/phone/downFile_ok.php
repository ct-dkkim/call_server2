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
$objPHPExcel = $objReader->load("../outline/temp_phone.xls");

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX PTT_SERVER Document")
							 ->setSubject("Office 2007 XLSX PTT_SERVER Document")
							 ->setDescription("PTT_SERVER document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("PTT_SERVER Phone Number result file");



$table = "REGISTER";
$order ="PHONE+0";
if ($fclass !="") {
		$where[] =" CLASS ='$fclass'";
}
if ($fpgroup !="") {
		$where[] =" PGROUP ='$fpgroup'";
}
if ($ftrunk !="") {
		$where[] =" TNUMBER ='$ftrunk'";
}
if (isset($word)==true && $word!="") {

  if ($find) {
	  $where[] ="  $find like '%$word%'";	
  } else {
	  //검색조건이 전체일때 통합검색
	  $w[] ="PHONE like '%$word%'";
	  $w[] ="IPADDR  like '%$word%'";
	  $w[] ="VIA_IPADDR  like '%$word%'";
	  $w[] ="CID  like '%$word%'";
	  $w[] ="USER_ID  like '%$word%'";
	  $w[] ="USERNAME  like '%$word%'";
	  $whr=implode(" or ", $w);
      $where[] ="($whr)";			
  }
}
if (!$where) {
	$whr = "1";
} else {
	$whr=implode(" and ", $where) ; 
}


$sql="select * from $table where $whr order by $order "  ;
$result=mysqli_query($db,$sql);
$line=2;

		$arrDND = array("0"=>"Setup", "1"=>"Release");
		$arrCForword =array("0"=>"Release","1"=>"Always","2"=>"Busy","3"=>"No Answer") ; 



while ($row = mysqli_fetch_array($result)){

	if ($row[REC]=="1") $rec="Y";
	else $rec="";
	$pw=PassDecoding($row['PASSWORD']);

	if ($row['REG_TIME'] > 0) {
		 $reg_date = date("Y-m-d H:i:s",$row['REG_TIME']);
	} else {
		$reg_date=""; 
	}

	$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$line, " ".$row['PHONE'])
					->setCellValue('B'.$line, " ".$row['USER_ID'])
					->setCellValue('C'.$line, $pw)
					->setCellValue('D'.$line, " ".$row['USERNAME'])
					->setCellValue('E'.$line, " ".$row['PNP_MAC'])
					->setCellValue('F'.$line, " ".$row['IPADDR'])
					->setCellValue('G'.$line, " ".$row['PORT'])
					->setCellValue('H'.$line, " ".$row['EXPIRES'])
					->setCellValue('I'.$line, " ".$row['MAXDURATION'])
					->setCellValue('J'.$line, " ".$row['CID'])
					->setCellValue('K'.$line, " ".$row['CLASS'])
					->setCellValue('L'.$line, " ".$row['PGROUP'])
					->setCellValue('M'.$line, " ".$row['TNUMBER'])
					->setCellValue('N'.$line, " ".$row['RGROUP'])
					->setCellValue('O'.$line, $rec)
					->setCellValue('P'.$line, " ".$row['VIA_IPADDR'])
					->setCellValue('Q'.$line, " ".$row['VIA_PORT'])
					->setCellValue('R'.$line, $arrCForword[$row['CFORWORD']])
					->setCellValue('S'.$line, $arrDND[$row['DND']])
					->setCellValue('T'.$line," ".$row['STATUS'])
					->setCellValue('U'.$line,$reg_date);
		$line++;
	};


$reg_date=date("Y-m-d H:i:s");


regLog($admin_info['user_id'], '11','down', $tit['mainTitle']['phone'], ($line-2)." ".$msg['unit'] ,'ENG',$reg_date,'') ;

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle( );

$fileName='Phone-'.date('Y-m-d');

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
