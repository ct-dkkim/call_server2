<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";

 ##로그기록
$pageKey="routingDigit";
if (strpos($_SESSION['viewLog'],$pageKey) ===false) {
	regLog($admin_info['user_id'], '3','view','', '' ,'ENG',$reg_date,'rout_prefix') ;
	if (!$_SESSION['viewLog']){
		set_session('viewLog',$pageKey.";");
	} else {
		$_SESSION['viewLog']=$_SESSION['viewLog'].$pageKey.";";
	}
}

$levelKey ="routing";
$memu2 ="nowOn";
$subMenu1_1 ="on";

$vars=$_SESSION['Vars'];
$arrVars=explode("&",$_SESSION['Vars']);
for ($i=0;$i<sizeof($arrVars);$i++) {
	 $arr=explode("=",$arrVars[$i]);
	 ${$arr[0]}=$arr[1];
}

if (!$fLevelKey) {
	  $_SESSION['Vars'] = "fLevelKey=$levelKey";
}


if ($allchk=="1"){
	$allchecked="checked";
} 

//해당 메뉴 사용권한
$alevel = permit_value($levelKey);


$aFind =array("PREFIX" => $titRouting['listTitle']['digit'], "IPADDR"=>$titRouting['listTitle']['ip']) ; 
$html_page=selectbox("page_num",$aPageNum,$page_num,"","findSelect('')","70");
$html_Find=selectbox("find",$aFind,$find,$msg['allchk'],"","100");
$html_routing=selectbox("frouting",$arrRouting,$frouting,$titRouting['listTitle']['routing'] ,"findSelect('frouting')","110");


?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <? include_once dirname(__FILE__) . "/../outline/header.php"; ?>


		<script type="text/javascript">
			  var ajaxObjects = new Array();
			  var pageNum='0';

			$(document).ready(function(){


			  listRefresh("<?=$_SESSION['Vars']?>","");
			  
			  $(".popup_layer").draggable({
					'handle' : 'dt'
			  });
			  
			  //선택삭제
			  $("#BtnDelete").click(function(e){

			  });


			  //신규등록
			  $("#BtnAdd").click(function(e){

			  });	

			  //##### 검색
			  $("#BtnSearch").click(function(e){
			  });


			  // reset
			  $("#BtnReset").click(function(e){
			  });


			})


			//#####검색 셀렉트 적용
			function findSelect(item) {
				 var delparams = ['page',];	
				 var params = [ 'page_num'];
				 if (item){
					params[1]= item
				 }

				 chgListVars(params,delparams);
			}


			//#####VIEW GET  
			function viewGetValue(key,top) {
				var ajaxIndex = ajaxObjects.length;
				ajaxObjects[ajaxIndex] = new sack();
				ajaxObjects[ajaxIndex].method = "POST";
				ajaxObjects[ajaxIndex].setVar("key", key);
				ajaxObjects[ajaxIndex].setVar("levelKey", $("#fLevelKey").val());
				ajaxObjects[ajaxIndex].requestFile = "./input.php";	
				ajaxObjects[ajaxIndex].onCompletion = function() { viewGetValueComplete(ajaxIndex,top); } ;			
				ajaxObjects[ajaxIndex].runAJAX();	

			}		
			

			function viewGetValueComplete(index,top)		{
				var result=ajaxObjects[index].response
				$("#divDataView").html(result)
				LayerPopup_type2('#divDataView',top)

			}
	</script>


</head>
<body>

<? include "../outline/top.php" ?>

<!-- 본문 시작 -->



<div id="container" class="w_custom">
	<!-- 기본형 시작 -->
	<div class="sub_head1 clear ">
		<h2 class="sub_head_title fl">Title</h2>
	</div>
	<div class="sub_head2 clear ">
		<div class="fl" id="divPageNum"></div>
		<div class="sub_head_search fr ta_right">
				<fieldset>
					<legend>검색폼</legend>
					<div class="clear">
						<button id="BtnReset" class="btn_nor btn_grey fl"><?=$tit['btn']['reset']?></button>						
						<?=$html_Find?>
						<input type="text" name="word" id='word' maxlength='16' value="<?=$word?>" class="sch_txt" title="" placeholder="">
						<button id="BtnSearch" onclick='return false' class="btn_nor btn_blue Rmargin"><?=$tit['btn']['search']?></button>
						<?=$html_routing?>
						<?=$html_page?>
					</div>

				</fieldset>
		</div>
	</div>	
	<form name="fmList" id='fmList' method="post" >

	<table class="bbs_table_list" cellpadding="0" cellspacing="0" border="0">
		<colgroup>
			<col width="7%">
			<col width="8%">
			<col width="25%">
			<col width="22%">
			<col width="13%">
			<col >
		</colgroup>
		<thead>
			<tr>
				<th>
					<span >
						<input type="checkbox" name='all' id='all' value='1' onclick='selectall()' <?=$allchecked?>>	
					</span>
				</th>
				<th>No</th>
				<th><?=$titRouting['listTitle']['digit']?> </th>
				<th><?=$titRouting['listTitle']['ip']?></th>
				<th><?=$titRouting['listTitle']['port']?></th>
				<th><?=$titRouting['listTitle']['routing']?></th>
			</tr>
		</thead>
		<tbody id='divList'>
		<tbody>
	</table>
	</form>
	<div class="bbs_footer clear">
		<div class="paginate" id='divPage'>
		</div>
		<div class="bbs_btn ta_right fr">
				<button onclick="return false" id="BtnAdd" class="btn_nor btn_point"><?=$tit['btn']['add']?></button>
				<button onclick="return false" id="BtnDelete" class="btn_nor btn_grey"><?=$tit['btn']['del']?></button>
		</div>
	</div>
</div>
<!-- 본문 끝 -->
<? include "../outline/footer.php" ?>
