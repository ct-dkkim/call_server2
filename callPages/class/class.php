<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";

 ##로그기록
$pageKey="class";
if (strpos($_SESSION['viewLog'],$pageKey) ===false) {
	regLog($admin_info['user_id'], '5','view','', '' ,'ENG',$reg_date,'') ;
	if (!$_SESSION['viewLog']){
		set_session('viewLog',$pageKey.";");
	} else {
		$_SESSION['viewLog']=$_SESSION['viewLog'].$pageKey.";";
	}
}

$levelKey ="class";
$memu5 ="nowOn";

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



?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <? include_once dirname(__FILE__) . "/../outline/header.php"; ?>
	<!-- 본문 시작 -->

		<script type="text/javascript">
			  var ajaxObjects = new Array();
			  var pageNum='0';

			$(document).ready(function(){


			  getClassList("<?=$_SESSION['Vars']?>","")
			  $(".popup_layer").draggable({
					'handle' : 'dt'
			  });
			  


			})

			function delAction(gubun,id) {
				 if ( $('#chkvalue'+id).val() !='') {
					 if (confirm("<?=$msg['delete']?>"))   {
						var ajaxIndex = ajaxObjects.length;
						ajaxObjects[ajaxIndex] = new sack();
						ajaxObjects[ajaxIndex].method = "POST";
						ajaxObjects[ajaxIndex].setVar("gubun", gubun);
						ajaxObjects[ajaxIndex].setVar("chkValue", $("#chkvalue"+id).val());	
						ajaxObjects[ajaxIndex].setVar("keyClass", $("#keyClass").val());	
						ajaxObjects[ajaxIndex].requestFile = "./del.php";	
						ajaxObjects[ajaxIndex].onCompletion = function() { viewGetValueComplete(ajaxIndex,top); } ;
						ajaxObjects[ajaxIndex].runAJAX();	
					 }
				} else {
				  alert("<?=$msg['delSelected']?>")
				}

			}

			//#####VIEW GET  
			function viewGetValue(gubun,key,top) {
				var ajaxIndex = ajaxObjects.length;
				ajaxObjects[ajaxIndex] = new sack();
				ajaxObjects[ajaxIndex].method = "POST";
				ajaxObjects[ajaxIndex].setVar("gubun", gubun);
				ajaxObjects[ajaxIndex].setVar("keyClass", $("#keyClass").val());
				ajaxObjects[ajaxIndex].setVar("key", key);
				ajaxObjects[ajaxIndex].setVar("levelKey", $("#fLevelKey").val());
				ajaxObjects[ajaxIndex].requestFile = "./input.php";	
				ajaxObjects[ajaxIndex].onCompletion = function() { viewGetValueComplete(ajaxIndex,top); } ;			ajaxObjects[ajaxIndex].runAJAX();	

			}		
			

			function viewGetValueComplete(index,top)		{
				var result=ajaxObjects[index].response
				$("#divDataView").html(result)

				LayerPopup_type2('#divDataView',550)

			}


     //리스트 갱신

		function getClassList(Vars,keyClass) {
			var ajaxIndex = ajaxObjects.length;
			var parameter = Vars.split('&');

			ajaxObjects[ajaxIndex] = new sack();
			ajaxObjects[ajaxIndex].method = "GET";
			for(var i=0;i<parameter.length;i++){
			   var aVars = parameter[i].split('=');
			   if (aVars[1] !="" && aVars[0]!="keyClass") {
					  ajaxObjects[ajaxIndex].setVar(aVars[0],aVars[1]);
			   }
			}
			ajaxObjects[ajaxIndex].setVar("keyClass",keyClass);
			ajaxObjects[ajaxIndex].requestFile = "./list_ajax.php";	
			ajaxObjects[ajaxIndex].onCompletion = function() { getClassListComplete(ajaxIndex); } ;
			ajaxObjects[ajaxIndex].runAJAX();
		}

		//리스트 갱신완료
		function getClassListComplete(index){
		   var result=ajaxObjects[index].response;	
		   var avalue=result.split("##");
		   $("#keyClass").val($.trim(avalue[0]))
		   $("#classTitle").html($.trim(avalue[1]))
		   $("#divClass").html(avalue[2])
		   $("#divUse").html(avalue[3])
		   $("#divLimit").html(avalue[4])
		   $("#divScript").html(avalue[5])
		   //$('input[name="all2"]').attr("checked",false)
		 
		}

		function selectall9(id) {
		    var total =0;
			var element=$('input:checkbox[name="chk'+id+'[]"]')
			var allChk=$('input[name="all'+id+'"]').is(":checked")
		    var chkvalue=""
			for( var i=0; i<element.length; i++) {  
				 if (allChk==true){ //전체선택
					 if (element[i].disabled==false){
						 total++;
						 element[i].checked	= true;
						
						 chkvalue += "," +element[i].value

					 }
				  } else {
					 element[i].checked	= false;
				  }
			}
			$("#chkvalue"+id).val(chkvalue)

			if (allChk==true){
				 $('input[name="allchk'+id+'"]').val('1')
			} else {
				 $('input[name="allchk'+id+'"]').val('0')
			}

		}


		function selchk9( obj,id) {
		    var total =0;
			var element=$('input:checkbox[name="chk'+id+'[]"]')
		    var chkvalue=""
			for( var i=0; i<element.length; i++) {  
				 if (element[i].checked	== true){ 			 
					 chkvalue += "," +element[i].value
				 }
			}
			$("#chkvalue"+id).val(chkvalue)
		}


	</script>
</head>
<body>

<? include "../outline/top.php" ?>

<div id='divScript'>
</div>

<div id="container" class="w_custom">
	<!-- 기본형 시작 -->
	<div class="sub_head1 clear ">
		<h2 class="sub_head_title fl"><?=$tit['mainTitle']['class']?></h2>
		<h2 class="sub_head_title " style="margin-left:652px" id='classTitle'></h2>

	</div>
	<!-- 기본형 끝 -->
	<div class="clear">
		<input type=hidden name="vars" id='vars' value="<?=$_SESSION['Vars']?>" size="80">     <!--ajax 리스트 변수-->
	    <input type="hidden" name="keyClass" id="keyClass" value="<?=$keyClass?>"?>
    	<input type=hidden name="fLevelKey" id='fLevelKey' value="<?=$levelKey?>">     <!--접근 레벨 키 -->	

		<div class="code_box01 code_box_wrap fl">
			<input type=hidden name="allchk1" id='allchk1' value='' >
			<input type=hidden name="chkvalue1" id="chkvalue1" value="" style="width:110px">

			<table class="bbs_table_list bbs_code01" cellpadding="0" cellspacing="0" border="0">
				<colgroup>
				<? if ($alevel['del']=="Y") { ?>	
					<col width="10.6%">
				<? }?>
					<col width="14%">
					<col width="22%">
					<col >
				</colgroup>
				<thead>
					<tr>
					<? if ($alevel['del']=="Y") { ?>	
						<th>
							<span class="check_box">
								<input type="checkbox" name='all1' id='all1' value='1' onclick="selectall9('1')" >
								
							</span>
						</th>
					<?} ?>
						<th><?=$titClass['listTitle']['no']?></th>
						<th><?=$titClass['listTitle']['class']?></th>
						<th><?=$titClass['listTitle']['explan']?></th>
					</tr>
				</thead>
			</table>
			<div class="code_box" id="divClass">

			</div><!-- .code_box -->
			<div class="bbs_footer">
				<div class="bbs_btn ta_center">
					<? if ($alevel['add']=="Y") { ?>
						<button onclick="viewGetValue('class','',400);return false"  class="btn_nor btn_point"><?=$tit['btn']['add']?></button>
					<? } ?>
					<? if ($alevel['del']=="Y") { ?>
						<button onclick="delAction('class','1');return false" id="BtnDelete" class="btn_nor btn_grey"><?=$tit['btn']['del']?></button>
					<? }?>
				</div>
			</div>
		</div><!-- .code_box01 -->
		<div class="code_box02 code_box_wrap fl">
			<input type=hidden name="allchk2" id='allchk2' value='' >
			<input type=hidden name="chkvalue2" id="chkvalue2" value="" style="width:110px">

			<table class="bbs_table_list bbs_code02" cellpadding="0" cellspacing="0" border="0">
				<colgroup>
				<? if ($alevel['del']=="Y") { ?>	
					<col width="22%">
				<? }?>
					<col width="26%">
					<col >
				</colgroup>
				<thead>
					<tr>
					<? if ($alevel['del']=="Y") { ?>	
						<th>							
							<input type="checkbox" name='all2' id='all2' value='1' onclick="selectall9('2')" >	
						</th>
					<? }?>
						<th><?=$titClass['listTitle']['no']?></th>
						<th><?=$titClass['listTitle']['useCode']?></th>
					</tr>
				</thead>
			</table>
			<div class="code_box" id="divUse">
				
			</div><!-- .code_box -->
			<div class="bbs_footer">
				<div class="bbs_btn ta_center">
					<? if ($alevel['add']=="Y") { ?>
						<button onclick="viewGetValue('use','',400);return false"  class="btn_nor btn_point"><?=$tit['btn']['add']?></button>
					<? } ?>
					<? if ($alevel['del']=="Y") { ?>
						<button onclick="delAction('use','2');return false" id="BtnDelete" class="btn_nor btn_grey"><?=$tit['btn']['del']?></button>
					<? }?>
				</div>
			</div>
		</div><!-- .code_box02 -->
		<div class="code_box03 code_box_wrap fr">
			<input type=hidden name="allchk3" id='allchk3' value='' >
			<input type=hidden name="chkvalue3" id="chkvalue3" value="" style="width:110px">

			<table class="bbs_table_list bbs_code02" cellpadding="0" cellspacing="0" border="0">
				<colgroup>
				<? if ($alevel['del']=="Y") { ?>	
					<col width="22%">
				<? }?>
					<col width="26%">
					<col >
				</colgroup>
				<thead>
					<tr>
					<? if ($alevel['del']=="Y") { ?>	
						<th>							
							<input type="checkbox" name='all3' id='all3' value='1' onclick="selectall9('3')"  >	
						</th>
					<? }?>
						<th><?=$titClass['listTitle']['no']?></th>
						<th><?=$titClass['listTitle']['limitCode']?></th>
					</tr>
				</thead>
			</table>
			<div class="code_box" id="divLimit">
				
			</div><!-- .code_box -->
			<div class="bbs_footer">
				<div class="bbs_btn ta_center">
					<? if ($alevel['add']=="Y") { ?>
						<button onclick="viewGetValue('limit','',400);return false"  class="btn_nor btn_point"><?=$tit['btn']['add']?></button>
					<? } ?>
					<? if ($alevel['del']=="Y") { ?>
						<button onclick="delAction('limit','3');return false" id="BtnDelete" class="btn_nor btn_grey"><?=$tit['btn']['del']?></button>
					<? }?>
				</div>
			</div>
		</div><!-- .code_box03 -->
	</div>
</div>


<!-- 본문 끝 -->

<? include "../outline/footer.php" ?>
