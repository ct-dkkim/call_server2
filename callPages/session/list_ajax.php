<?
header('Content-Type: text/html; charset=utf-8 ');
if (strpos($_SERVER['HTTP_REFERER'],'list.php') ===false) {
	die('error');
}
include_once dirname(__FILE__) . '/../../lib/setConfig.php';
include_once dirname(__FILE__) . '/../../lib/sessionClass.php';

$vars= getVars('phone,rndval,first');
if (!$_SESSION['Vars']){
	set_session('nMenu',get_dirname());
	set_session('Vars',$vars);
} else {
	$_SESSION['nMenu']=get_dirname();
	$_SESSION['Vars']=$vars;
}
$setClass=new session();
$setClass->_set();
$sessionList = $setClass->get_sessionList();



echo "<strong>".$titSession['listTitle']['callCnt']."</strong> : ".$setClass->totalCnt;
echo "##";
echo "	<table class='bbs_table_list bbs_code01' cellpadding='0' cellspacing='0' border='0'>
		<colgroup>
					<col width='15%'>
					<col width='10%'>
					<col width='10%'>
					<col width='15%'>
					<col width='15%'>
					<col width='15%'>
					<col width='10%'>
					<col width='10%'>
		</colgroup>
		<tbody>";
echo	$sessionList ;
echo "	<tbody>
	</table>"; 


?>








