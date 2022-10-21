<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";

 ##로그기록
$pageKey="huntGroup";
if (strpos($_SESSION['viewLog'],$pageKey) ===false) {
	regLog($admin_info['user_id'], '8','view','', '' ,'ENG',$reg_date,'etc_hunt') ;
	if (!$_SESSION['viewLog']){
		set_session('viewLog',$pageKey.";");
	} else {
		$_SESSION['viewLog']=$_SESSION['viewLog'].$pageKey.";";
	}
}

$levelKey ="ptt";
$memu7 ="nowOn";
$subMenu3_5 ="on";

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

$alevel = permit_value($levelKey);


$aFind =array("HGROUP" => $titEtc['listTitle']['hGroup'], "TELNO"=>$titEtc['listTitle']['hPhone']) ; 
$html_page=selectbox("page_num",$aPageNum,$page_num,"","findSelect('')","70");
$html_Find=selectbox("find",$aFind,$find,$msg['allchk'],"","130");


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
			  	 var top=e.pageY - 100

				 if ( $('#chkvalue').val() !='') {
					 if (confirm("<?=$msg['delete']?>"))   {
						var ajaxIndex = ajaxObjects.length;
						ajaxObjects[ajaxIndex] = new sack();
						ajaxObjects[ajaxIndex].method = "POST";
						ajaxObjects[ajaxIndex].requestFile = "./del.php";	
						ajaxObjects[ajaxIndex].onCompletion = function() { viewGetValueComplete(ajaxIndex,top); } ;
						ajaxObjects[ajaxIndex].runAJAX();	
					 }
				} else {
				  alert("<?=$msg['delSelected']?>")
				}
			  });


			  //신규등록
			  $("#BtnAdd").click(function(e){
			  	 var top=e.pageY - 100
				 viewGetValue('',top)

			  });	
			  /*
			  //##### upload
			  $("#BtnUpload").click(function(e){
	  			  var top=e.pageY
			      $('#divLog').hide();
				  $('#attach').val('')
				  $('#exe').val('0')
				  $("#BtnUpfileExe").show()

				  LayerPopup_type2('#divUpfile',top)
			  });

			  //##### 엑셀파일다운로드
			  $("#BtnXlsDown").click(function(e){
	  			  var top=e.pageY - 50
				  var userLevel="<?=$admin_info['user_level']?>";   //My Level

				  $('#downTotal').html($('#divPageNum').html())
				  if (userLevel=="1") {
					  $('#DownDate').html("<?=$aLevel[2] .", ".$aLevel[3].", ".$aLevel[4].", ".$aLevel[5]?>")

				  } else if (userLevel=="2")  {
					  $('#DownDate').html("<?=$aLevel[3].", ".$aLevel[4].", ".$aLevel[5]?>")

				  }
				  $('#DownDate').html()
				  LayerPopup_type2('#divDown',top)
			  });
*/



			  //##### 검색
			  $("#BtnSearch").click(function(e){
				 var params = [ 'find','word','page_num'];
 		    	 var delparams = [ 'page' ];
				 chgListVars(params,delparams);
			  });

			  $("#BtnReset").click(function(e){

				 var params = [ 'find','word','page_num'];
				 for(var i=0; i<params.length;i++) {
				 	$("#"+params[i]).val('')
				 }
 		    	 var delparams = [ 'page' ];
				 chgListVars(params,delparams);
			  });


			})

			function submitSerch() {
				$("#BtnSearch").trigger('click');
			}


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
				ajaxObjects[ajaxIndex].onCompletion = function() { viewGetValueComplete(ajaxIndex,top); } ;			ajaxObjects[ajaxIndex].runAJAX();	

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
		<h2 class="sub_head_title fl"><?=$tit['mainTitle']['etc_hunt']?></h2>
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
	<input type=hidden name="vars" id='vars' value="<?=$_SESSION['Vars']?>" size="80">     <!--ajax 리스트 변수-->
	<input type=hidden name="fLevelKey" id='fLevelKey' value="<?=$levelKey?>">     <!--접근 레벨 키 -->	
	<input type=hidden name="page" id='page' value="<?=$page?>">
	<input type=hidden name="allchk" id='allchk' value='<?=$allchk?>' >
	<input type=hidden name="chkvalue" id="chkvalue" value="<?=$chkvalue?>">
	<table class="bbs_table_list" cellpadding="0" cellspacing="0" border="0">
		<colgroup>
			<? if ($alevel['del']=="Y") { ?>
			<col width="7%">
			<? }?>
			<col width="8%">
			<col width="15%">
			<col >
		</colgroup>
		<thead>
			<tr>
			<? if ($alevel['del']=="Y") { ?>			
				<th>
					<span >
						<input type="checkbox" name='all' id='all' value='1' onclick='selectall()' <?=$allchecked?>>	
					</span>
				</th>
			<?} ?>
				<th>No</th>
				<th><?=$titEtc['listTitle']['hGroup']?> </th>
				<th><?=$titEtc['listTitle']['hPhone']?></th>

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
			<? if ($alevel['add']=="Y") { ?>
				<button onclick="return false" id="BtnAdd" class="btn_nor btn_point"><?=$tit['btn']['add']?></button>
			<? } ?>
			<? if ($alevel['del']=="Y") { ?>
				<button onclick="return false" id="BtnDelete" class="btn_nor btn_grey"><?=$tit['btn']['del']?></button>
			<? }?>
		</div>
	</div>
</div>

<!-- 고객인증관리 레이어 끝 -->
<!-- 본문 끝 -->




<? include "../outline/footer.php" ?>
