<?
header('Content-Type: text/html; charset=utf-8 ');
if (strpos($_SERVER['HTTP_REFERER'],"list.php") ===false) {
	die("error");
}
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
include_once dirname(__FILE__) . "/../../lib/pageClass.php";
include_once dirname(__FILE__) . "/../../lib/trunkNumberClass.php";



$vars= getVars('phone,rndval,first');
if (!$_SESSION['Vars']){
	set_session('nMenu',get_dirname());
	set_session('Vars',$vars);
} else {
	$_SESSION['nMenu']=get_dirname();
	$_SESSION['Vars']=$vars;
}
if (!$_GET['page_num']) $_GET['page_num']="20";
$setClass=new trunkNumber($_GET['page'],$_GET['page_num']);
$setClass->_set();


echo "Total Count: <strong>".number_format($setClass->recode['total'])."</strong> ( ";
echo number_format($setClass->page['now']) ."/". number_format($setClass->page['total']) ." Pages )";

echo "##";
$setClass->get_ListValue();
?>
<script type="text/javascript">
	$(".bbs_table_list tbody tr").on("mouseenter mouseleave" , function(e){
		if(e.type == "mouseenter"){
			$(this).addClass("ovr");
		}else{
			$(this).removeClass("ovr");
		}
	});

	$('.bbs_table_list tbody tr').each(function(e){
		var key= $(this).attr("id")		
		$(this).css("cursor","pointer")
		$(this).find("td:not('.notList')").click(function(e){
			var top=e.pageY ;
			viewGetValue(key,top)
		});
	})



</script>
<?
echo "##";
echo $setClass->page['navi'];
?>








