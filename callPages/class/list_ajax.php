<?
header('Content-Type: text/html; charset=utf-8 ');
if (strpos($_SERVER['HTTP_REFERER'],'class.php') ===false) {
	die('error');
}
include_once dirname(__FILE__) . '/../../lib/setConfig.php';
include_once dirname(__FILE__) . '/../../lib/classCodeClass.php';

$levelKey=$_GET['fLevelKey'];
$alevel=array("view"=>$admin_info[$levelKey.'_view'], "add"=>$admin_info[$levelKey.'_add'], "mod"=>$admin_info[$levelKey.'_mod'], "del"=>$admin_info[$levelKey.'_del']);


$vars= getVars('phone,rndval,first');
if (!$_SESSION['Vars']){
	set_session('nMenu',get_dirname());
	set_session('Vars',$vars);
} else {
	$_SESSION['nMenu']=get_dirname();
	$_SESSION['Vars']=$vars;
}
$setClass=new classCode();
$setClass->keyClass = trim($_GET['keyClass']);
$setClass->_set();
$classList = $setClass->get_classList();
echo $setClass->keyClass;
echo "##";
echo $setClass->keyClassTitle;
echo "##";
echo "	<table class='bbs_table_list bbs_code01' cellpadding='0' cellspacing='0' border='0'>
		<colgroup>";
	if ($alevel['del']=="Y") { 		
			echo "<col width='10.6%'>";
	}
echo"		<col width='14%'>
			<col width='22%'>
			<col >
		</colgroup>
		<tbody>";
echo	$classList ;
echo "	<tbody>
	</table>"; 

echo '##';
echo "	<table class='bbs_table_list bbs_code02' cellpadding='0' cellspacing='0' border='0'>
		<colgroup>";
	if ($alevel['del']=="Y") { 		
			echo "<col width='22%'>";
	}		
echo "		<col width='26%'>
			<col >
		</colgroup>
		<tbody>";
echo	$setClass->get_useClassList();
echo "	<tbody>
	</table>"; 
echo '##';
echo "	<table class='bbs_table_list bbs_code03' cellpadding='0' cellspacing='0' border='0'>
		<colgroup>";
	if ($alevel['del']=="Y") { 		
			echo "<col width='22%'>";
	}			
echo "		
			<col width='26%'>
			<col >
		</colgroup>
		<tbody>";
echo	$setClass->get_limitClassList();
echo "	<tbody>
	</table>"; 

echo "##";
?>
<script type='text/javascript'>

	$('.bbs_table_list tbody tr').on('mouseenter mouseleave' , function(e){
		if(e.type == 'mouseenter'){
			$(this).addClass('ovr');
		}else{
			$(this).removeClass('ovr');
		}
	});

	$('.bbs_code01 tbody tr').each(function(e){
		var key= $(this).attr('id')		
		$(this).css('cursor','pointer')
		$(this).find("td:not('.notList')").click(function(e){
			var top=e.pageY ;
			getClassList("<?=$_SESSION['Vars']?>",key)

		});
		$(this).find("td:not('.notList')").dblclick(function(e){
			var top=e.pageY ;
			viewGetValue('class',key,top)

		});

	})

	$('.bbs_code02 tbody tr').each(function(e){
		var key= $(this).attr('id')		
		$(this).css('cursor','pointer')		
		$(this).find("td:not('.notList')").dblclick(function(e){
			var top=e.pageY ;
			viewGetValue('use',key,top)
		});
	})
	$('.bbs_code03 tbody tr').each(function(e){
		var key= $(this).attr('id')		
		$(this).css('cursor','pointer')
		$(this).find("td:not('.notList')").dblclick(function(e){
			var top=e.pageY ;
			viewGetValue('limit',key,top)
		});
	})


</script>








