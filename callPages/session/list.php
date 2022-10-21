<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";

 ##로그기록
/*
$pageKey="class";
if (strpos($_SESSION['viewLog'],$pageKey) ===false) {
	regLog($admin_info['user_id'], '5','view',$tit['mainTitle']['class'], '' ,'ENG',$reg_date,'') ;
	if (!$_SESSION['viewLog']){
		set_session('viewLog',$pageKey.";");
	} else {
		$_SESSION['viewLog']=$_SESSION['viewLog'].$pageKey.";";
	}
}
*/
//$levelKey ="class";

$vars=$_SESSION['Vars'];
$arrVars=explode("&",$_SESSION['Vars']);
for ($i=0;$i<sizeof($arrVars);$i++) {
	 $arr=explode("=",$arrVars[$i]);
	 ${$arr[0]}=$arr[1];
}
if (!$session_auto) {
	  $session_auto = 1; 
	  $retime = "5";
	  $_SESSION['Vars'] = "session_auto=$session_auto&retime=$retime";
}



$alevel = permit_value("phone");

$aretime=array("5000" =>"5 sec","10000"=>"10 sec", "15000"=>"15 sec", "20000"=>"20 sec", "25000"=>"25 sec", "30000"=>"30 sec");

$aFind =array("TELNO" => $titSession['listTitle']['callNumber'], "CALLED"=>$titSession['listTitle']['reNumber']) ; 

$html_reTime=selectbox("retime",$aretime,$retime,"","getSessionValue()","80");
$html_Find=selectbox("find",$aFind,$find,$msg['allchk'],"","130");
$html_type=selectbox("ftype",$aCType,$ftype,$titSession['listTitle']['callType'],"getSessionValue()","100");
$html_status=selectbox("fstatus",$aCStatus,$fstatus,$titSession['listTitle']['callStauts'],"getSessionValue()","100");



?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <? include_once dirname(__FILE__) . "/../outline/header.php"; ?>
	<!-- 본문 시작 -->

		<script type="text/javascript">
			  var ajaxObjects = new Array();
			  var pageNum='0';
			  var timeid;

			$(document).ready(function(){


			  	

		  	  getSessionValue()

			  //##### 검색
			  $("#BtnSearch").click(function(e){
				 getSessionValue()
			  });

			  $("#BtnReset").click(function(e){

				 var params = [ 'find','word'];
				 for(var i=0; i<params.length;i++) {
				 	$("#"+params[i]).val('')
				 }
 		    	 getSessionValue()
			  });


			})



			function getSessionValue() {
				var ajaxIndex = ajaxObjects.length;
			    var session_auto =$("input:checkbox[id='session_auto']").is(":checked") ;

				ajaxObjects[ajaxIndex] = new sack();
				ajaxObjects[ajaxIndex].method = "GET";
				ajaxObjects[ajaxIndex].setVar("session_auto",session_auto);
				ajaxObjects[ajaxIndex].setVar("retime",$("#retime").val());
				ajaxObjects[ajaxIndex].setVar("fstatus",$("#fstatus").val());
				ajaxObjects[ajaxIndex].setVar("find",$('#find').val());
				ajaxObjects[ajaxIndex].setVar("word", $('#word').val());
				ajaxObjects[ajaxIndex].requestFile = "./list_ajax.php";	
				ajaxObjects[ajaxIndex].onCompletion = function() { getSessionValueComplete(ajaxIndex); } ;
				ajaxObjects[ajaxIndex].runAJAX();


			}


			function getSessionValueComplete(index)
			{
			   var result=ajaxObjects[index].response;	
			   var avalue=result.split("##");

			   var session_auto =$("input:checkbox[id='session_auto']").is(":checked") ;
			   var interval =$("#retime").val()			   
			   ///			   alert(avalue[1])
			   $("#divPageNum").html(avalue[0]) //좌측 그룹리스트
			   $("#divList").html(avalue[1])      //세션 phone list


				if (timeid)	{
					clearTimeout(timeid);
				}

				if (session_auto==true) {
					timeid=window.setTimeout( getSessionValue, interval);	// 1초마다 
				}

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
		<h2 class="sub_head_title fl"><?=$tit['mainTitle']['session']?></h2>
	</div>
	<div class="sub_head2 clear ">
		<div class="fl" id="divPageNum"></div>
		<div class="sub_head_form fr">
				<div class="form_wrap clear">
                    <fieldset>
                        <legend></legend>
						<span class="check_box check_box_right form_element">
							<input name="session_auto" id="session_auto" onclick="getSessionValue()" type="checkbox" checked="" value="1" class="checkbox" <? if ($session_auto=="1") echo "checked" ?>>
							<label for="session_auto" class="check-s">Auto Refresh</label>
						</span>
						<span class="form_element">Refresh Time</span>
						<div class="select_box_wrap form_element" style="margin-right:50px">
							<?=$html_reTime?>
						</div>

						<div class="form_element">
							<button id="BtnReset" class="btn_nor btn_grey fl"><?=$tit['btn']['reset']?></button>
						</div>						

						<div class="select_box_wrap form_element">													
							<?=$html_Find?>
						</div>
						<div class="form_element">
							<input type="text" name="word" id='word' maxlength='16' value="<?=$word?>" class="sch_txt" title="" placeholder="">						
						</div>
						<div class="form_element">
							<button id="BtnSearch" onclick='return false' class="btn_nor btn_blue " style="margin-right:20px"><?=$tit['btn']['search']?></button>

							<?=$html_type?>
						</div>
						<div class="form_element">
							<?=$html_status?>
						</div>						
                    </fieldset>
				</div>
		</div>	
	</div>	





	<!-- 기본형 끝 -->
	<div class="clear">
		<input type=hidden name="vars" id='vars' value="<?=$_SESSION['Vars']?>" size="80">     <!--ajax 리스트 변수-->
	    <input type="hidden" name="keyClass" id="keyClass" value="<?=$keyClass?>"?>
    	<input type=hidden name="fLevelKey" id='fLevelKey' value="<?=$levelKey?>">     <!--접근 레벨 키 -->	

		<div class="session_box code_box_wrap fl" >
			<table class="bbs_table_list bbs_code01" cellpadding="0" cellspacing="0" border="0" >
				<colgroup>
					<col width='15%'>
					<col width='10%'>
					<col width='10%'>
					<col width='15%'>
					<col width='15%'>
					<col width='15%'>
					<col width='8%'>
					<col width='12%'>
				</colgroup>


				<thead>
					<tr>
						<th><?=$titSession['listTitle']['callNumber']?></th>
						<th><?=$titSession['listTitle']['sDate']?></th>
						<th><?=$titSession['listTitle']['sTime']?></th>
						<th><?=$titSession['listTitle']['reNumber']?></th>
						<th><?=$titSession['listTitle']['sendIP']?></th>
						<th><?=$titSession['listTitle']['reIP']?></th>
						<th><?=$titSession['listTitle']['callType']?></th>
						<th><?=$titSession['listTitle']['callStauts']?></th>
					</tr>
				</thead>
			</table>
			<div class="code_box" id="divList" style="height:600px">

			</div><!-- .code_box -->
			<div class="bbs_footer">
			</div>
		</div><!-- .code_box01 -->

	</div>
</div>

<!-- INPUT 레이어 시작 -->
<div class=" popup_layer " id='divDataView'>
</div>
<!-- 본문 끝 -->

<? include "../outline/footer.php" ?>
