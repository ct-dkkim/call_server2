<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";

 ##로그기록
$pageKey="phone";
if (strpos($_SESSION['viewLog'],$pageKey) ===false) {
	regLog($admin_info['user_id'], '2','view','', '' ,'ENG',$reg_date,'phone') ;
	if (!$_SESSION['viewLog']){
		set_session('viewLog',$pageKey.";");
	} else {
		$_SESSION['viewLog']=$_SESSION['viewLog'].$pageKey.";";
	}
}

$levelKey ="phone";
$memu1 ="nowOn";

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


$aFind =array("PHONE" => $titPhone['listTitle']['phone'], "IPADDR" => $titPhone['listTitle']['ip'], "VIA_IPADDR" => $titPhone['listTitle']['ip2'],  "USERNAME"=>$titPhone['listTitle']['username'] ,  "USER_ID"=>$titPhone['listTitle']['userid'] ,  "CID"=>$titPhone['listTitle']['cid'] ) ; 
$html_page=selectbox("page_num",$aPageNum,$page_num,"","findSelect('')","70");
$html_Find=selectbox("find",$aFind,$find,$msg['allchk'],"","130");

$query="select * from CLASS order by CLASS";
$rs=mysqli_query($db,$query);
while ($temp=mysqli_fetch_array($rs)) {
	$arrClass[$temp['CLASS']] = $temp['CLASS'];
}
$html_class=selectbox("fclass",$arrClass,$fclass,$titPhone['listTitle']['class'] ,"findSelect('fclass')","120");

$query="select * from PICKUPGROUP order by PCODE";
$rs=mysqli_query($db,$query);
while ($temp=mysqli_fetch_array($rs)) {
	$arrPgroup[$temp['PCODE']] = $temp['PCODE'] ;
}
$html_pgroup=selectbox("fpgroup",$arrPgroup,$fpgroup,$titPhone['listTitle']['pgroup'] ,"findSelect('fpgroup')","120");


$query="select TNUMBER ,TNAME from TRUNK_NUMBER order by TNUMBER";
$rs=mysqli_query($db,$query);
while ($temp=mysqli_fetch_array($rs)) {
	$arrTrunk[$temp['TNUMBER']] = $temp['TNUMBER'] ;
}
$html_trunk=selectbox("ftrunk",$arrTrunk,$ftrunk,$titPhone['listTitle']['trunk'] ,"findSelect('ftrunk')","120");

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


			  //##### upload
			  $("#BtnUpload").click(function(e){
	  			  var top=e.pageY - 100
					var ajaxIndex = ajaxObjects.length;
					ajaxObjects[ajaxIndex] = new sack();
					ajaxObjects[ajaxIndex].method = "POST";
					ajaxObjects[ajaxIndex].setVar("levelKey", $("#fLevelKey").val());
					ajaxObjects[ajaxIndex].requestFile = "./uploadFile.php";	
					ajaxObjects[ajaxIndex].onCompletion = function() { viewGetValueComplete(ajaxIndex,top); } ;
					ajaxObjects[ajaxIndex].runAJAX();

			  });

			  //##### 엑셀파일다운로드
			  $("#BtnXlsDown").click(function(e){

	  			  var top=e.pageY - 100
				  var pageTotal=$('#divPageNum').html().split("(")
				  var total=pageTotal[0].split(":")
				  $('#DownDivision').html($('#DshotName').val())

				  $('#downTotal').html(total[1])
				  LayerPopup_type2('#divDown',top)
			  });


			  //##### 검색
			  $("#BtnSearch").click(function(e){
				 var params = [ 'find','word','page_num'];
 		    	 var delparams = [ 'page' ];
				 chgListVars(params,delparams);
			  });

			  $("#BtnReset").click(function(e){

				 var params = [ 'find','word','fpgroup','fclass','ftrunk','page_num'];
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

				LayerPopup_type2('#divDataView',top-100)

			}
	</script>


</head>
<body>

<? include "../outline/top.php" ?>

<!-- 본문 시작 -->



<div id="container" class="w_custom">
	<!-- 기본형 시작 -->
	<div class="sub_head1 clear ">
		<h2 class="sub_head_title fl"><?=$tit['mainTitle']['phone']?></h2>
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
						<?=$html_class?>
						<?=$html_pgroup?>
						<?=$html_trunk?>
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
			<col width="3%">
			<? }?>
			<col width="4%">
			<col width="10%">
			<col width="9%">
			<col width="9%">
			<col width="9%">
			<col >
			<col width="7%">
			<col width="10%">
			<col width="7%">
			<col width="6%">
			<col width="7%">
			<col width="3%">
			<col width="4%">
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
				<th><?=$titPhone['listTitle']['phone']?> </th>
				<th><?=$titPhone['listTitle']['ip']?></th>
				<th><?=$titPhone['listTitle']['ip2']?></th>
				<th><?=$titPhone['listTitle']['userid']?></th>
				<th><?=$titPhone['listTitle']['username']?></th>
				<th><?=$titPhone['listTitle']['class']?></th>
				<th><?=$titPhone['listTitle']['cid']?></th>
				<th><?=$titPhone['listTitle']['pgroup']?></th>
				<th><?=$titPhone['listTitle']['dnd']?></th>
				<th><?=$titPhone['listTitle']['cforword']?></th>
				<th><?=$titPhone['listTitle']['rec']?></th>
				<th><?=$titPhone['listTitle']['status']?></th>
			</tr>
		</thead>
		<tbody id='divList'>
		<tbody>
	</table>
	</form>
	<div class="bbs_footer clear">
		<div class="bbs_btn ta_right fl">
			<? if ($alevel['add']=="Y" && $alevel['mod']=="Y" && $alevel['del']=="Y") { ?>
				<button onclick="return false" id="BtnUpload" class="btn_nor btn_point"><?=$tit['btn']['import']?></button>
			<? } ?>
			<? if ($alevel['view']=="Y") { ?>
				<button onclick="return false" id="BtnXlsDown" class="btn_nor btn_grey"><?=$tit['btn']['export']?></button>
			<? }?>		
		</div>
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


<!--##### 데이터Down #####-->
<div id='divDown' class='popup_layer'>
	<? include_once dirname(__FILE__) . "/downFile.php";?>

</div>

<!--##### 데이터 DownLoad 로딩 #####-->
<div id='divDownLoading' class='popup_layer'>
</div>


<? include "../outline/footer.php" ?>
