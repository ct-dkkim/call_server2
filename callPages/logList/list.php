<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";


 ##로그기록
   $memu6 ="nowOn";
   $subMenu4_2 ="on";

   $bbs="PTTLOG";

	//데이타 보존기간 처리
	if ($admin_info['user_level'] == "1") {

		$keep_date= date("Y-m-d", strtotime(date('Y-m-d H:i:s').' -'.$config['keepMonth'].'month')); 
		if (mysqli_query($db,"delete from $bbs where REGTIME  < '".$keep_date."'")) {
				$reg_date=date("Y-m-d H:i:s");
				$count =mysqli_affected_rows($db);
				if ($count > 0) {
					regLog($admin_info['user_id'], '7','del',$tit['mainTitle']['history_oper']." < ".$keep_date, $msg['delResult'].$count ,'ENG',$reg_date) ;
				}

		}
	}

   //변수처리
   $arrVars=explode("&",$_SESSION['Vars']);
   for ($i=0;$i<sizeof($arrVars);$i++) {
		 $arr=explode("=",$arrVars[$i]);
		 ${$arr[0]}=$arr[1];
   }

   $today= date("Y-m-d");
   if (!$st_day) {	  
	  $st_day=$end_day=$today ; 
	  $_SESSION['Vars'] = "st_day=$st_day&end_day=$end_day";
   }
   //permit_admin();

	$alevel = permit_value();


	//일반그룹 셀렉트박스 생성


	//$pageName = "logList";

	$html_page=selectbox("page_num",$aPageNum,$page_num,"","findSelect('')","70");

?>
<!DOCTYPE html>
<html lang="ko">
<head>
      <? include_once dirname(__FILE__) . "/../outline/header.php"; ?>
	  <script type="text/javascript" src='../../js/calendar-eraser_lim.js'></script>
	  <link rel='stylesheet' href='../../js/calendar-eraser_lim.css' type='text/css'>
	  <script type="text/javascript">
			var ajaxObjects = new Array();
			var timeid;

			$(document).ready(function(){
			  listRefresh("<?=$_SESSION['Vars']?>");
			  $(".popup_layer").draggable();


			  //##### 검색
			  $("#BtnSearch").click(function(e){
				 var params = [ 'st_day', 'end_day','word','page_num'];
 		    	 var delparams = [ 'page' ];
				  if ($('#st_day').val()==""){
					 alert("<?=$msgStat['errDate']?>")
					 $('#st_day').focus()
					  return false
				  }
				  if ($('#end_day').val()==""){
					 alert("<?=$msgStat['errDate']?>")
					 $('#end_day').focus()
					  return false
				  }					 

				 chgListVars(params,delparams);
			  });

			  //##### 엑셀파일다운로드
			  $("#BtnFileDown").click(function(e){
	  			  var top=e.pageY - 100
				  var pageTotal=$('#divPageNum').html().split("(")
				  var total=pageTotal[0].split(":")


				  $('#DownDate').html($('#st_day').val() + " ~ " +$('#end_day').val())
				  $('#downTotal').html(total[1])
				  LayerPopup_type2('#divDown',top)
			  });

			  //##### 페이지 출력량 변경
			  $("#page_num").change(function(e){
				 var params = [ 'page_num'];
 		    	 var delparams = ['page'];	 
				 chgListVars(params,delparams);
			  });

			  $("#BtnReset").click(function(e){
				 var params = [ 'find','logtype','logsub','page_num'];

				 $("#st_day").val('<?=$today?>')
				 $("#end_day").val('<?=$today?>')
 
				 for(var i=0; i<params.length;i++) {
				 	$("#"+params[i]).val('')
				 }
 		    	 var delparams = [ 'page' ];
				 chgListVars(params,delparams);
			  });			  
			})

			//#####검색 셀렉트 적용
			function findSelect(item) {
 		    	 var delparams = ['page',];	
				 var params = [ 'page_num'];
				  if ($('#st_day').val()==""){
					 alert("<?=$msgStat['errDate']?>")
					 $('#st_day').focus()
					  return false
				  }
				  if ($('#end_day').val()==""){
					 alert("<?=$msgStat['errDate']?>")
					 $('#end_day').focus()
					  return false
				  }			


				 if (item){
					params[1]= item
				 }
				if (item=="logtype"){
					delparams[1]= 'logsub'
				}

				 chgListVars(params,delparams);
			}

			function typeSelect(type) {
				var form= document.fmList;
/*
				 while(form.logsub.options.length > 0) {
				 	alert(form.logsub.options.length)
				 		form.logsub.options.remove(0);
				 }
*/

				 var subValue="";

				 switch (type){
					  case "1":					
						subValue="<?
							echo "<option value=''>$msgLog[selectTitle]</option>";
							foreach ($aLogAction[1] as $key=>$value) {
							  if ($logSub==$key) $sel="selected";
							  else $sel="";
								  echo "<option value='$key' $sel>$value</option>";
							}						
						
						?>"
					  break;				 	
					  case "2":					
						subValue="<?
							echo "<option value=''>$msgLog[selectTitle]</option>";
							foreach ($aLogAction[2] as $key=>$value) {
							  if ($logSub==$key) $sel="selected";
							  else $sel="";
								  echo "<option value='$key' $sel>$value</option>";
							}						
						
						?>"
					  break;
					  case "3":					
						subValue="<?
							echo "<option value=''>$msgLog[selectTitle]</option>";
							foreach ($aLogAction[3] as $key=>$value) {
							  if ($logSub==$key) $sel="selected";
							  else $sel="";
								  echo "<option value='$key' $sel>$value</option>";
							}						
						
						?>"
					  break;
					  case "4":					
						subValue="<?
							echo "<option value=''>$msgLog[selectTitle]</option>";
							foreach ($aLogAction[4] as $key=>$value) {
							  if ($logSub==$key) $sel="selected";
							  else $sel="";
								  echo "<option value='$key' $sel>$value</option>";
							}						
						
						?>"
					  break;
					  case "5":					
						subValue="<?
							echo "<option value=''>$msgLog[selectTitle]</option>";
							foreach ($aLogAction[5] as $key=>$value) {
							  if ($logSub==$key) $sel="selected";
							  else $sel="";
								  echo "<option value='$key' $sel>$value</option>";
							}						
						
						?>"
					  break;
					  case "6":					
						subValue="<?
							echo "<option value=''>$msgLog[selectTitle]</option>";
							foreach ($aLogAction[6] as $key=>$value) {
							  if ($logSub==$key) $sel="selected";
							  else $sel="";
								  echo "<option value='$key' $sel>$value</option>";
							}						
						
						?>"
					  break;
					  case "7":					
						subValue="<?
							echo "<option value=''>$msgLog[selectTitle]</option>";
							foreach ($aLogAction[7] as $key=>$value) {
							  if ($logSub==$key) $sel="selected";
							  else $sel="";
								  echo "<option value='$key' $sel>$value</option>";
							}						
						
						?>"
					  break;	
					  case "8":					
						subValue="<?
							echo "<option value=''>$msgLog[selectTitle]</option>";
							foreach ($aLogAction[8] as $key=>$value) {
							  if ($logSub==$key) $sel="selected";
							  else $sel="";
								  echo "<option value='$key' $sel>$value</option>";
							}						
						
						?>"
					  break;	

					  case "9":					
						subValue="<?
							echo "<option value=''>$msgLog[selectTitle]</option>";
							foreach ($aLogAction[9] as $key=>$value) {
							  if ($logSub==$key) $sel="selected";
							  else $sel="";
								  echo "<option value='$key' $sel>$value</option>";
							}						
						
						?>"
					  break;	
					  case "10":					
						subValue="<?
							echo "<option value=''>$msgLog[selectTitle]</option>";
							foreach ($aLogAction[10] as $key=>$value) {
							  if ($logSub==$key) $sel="selected";
							  else $sel="";
								  echo "<option value='$key' $sel>$value</option>";
							}						
						
						?>"
					  break;	
					  case "11":					
						subValue="<?
							echo "<option value=''>$msgLog[selectTitle]</option>";
							foreach ($aLogAction[11] as $key=>$value) {
							  if ($logSub==$key) $sel="selected";
							  else $sel="";
								  echo "<option value='$key' $sel>$value</option>";
							}						
						
						?>"
					  break;						  					  				  				  				  
					 default:
						subValue="<?
							echo "<option value=''>$msgLog[selectTitle]</option>";
							?>"
					   break;

				}
				$('#logsub').html(subValue)
				//var tg=document.getElementById('logsub'); 				
				//	tg.reset()

			    findSelect('logtype')
			}


	  </script>
</head>

<body >

<? include "../outline/top.php" ?>

<!-- 본문 시작 -->



<div id="container" class="w_custom">
	<!-- 기본형 시작 -->
	<div class="sub_head1 clear ">
		<h2 class="sub_head_title fl"><?=$tit['mainTitle']['history_oper']?></h2>
	</div>
	<div class="sub_head2 clear ">
		<div class="fl" id="divPageNum"></div>
		<div class="sub_head_search fr ta_right">
				<fieldset>
					<legend>검색폼</legend>
					<div class="clear">
						<button id="BtnReset" class="btn_nor btn_grey fl"><?=$tit['btn']['reset']?></button>						

						<input type="text" name="st_day"  id="st_day" maxlength="10" value="<?=$st_day?>" onfocus='showCalendarControl(this)' class="sch_txt" style="width:90px"><span>~</span>
						<input type="text"  name="end_day"  id="end_day" maxlength="10" value="<?=$end_day?>" onfocus='showCalendarControl(this)' class="sch_txt fl5" style="width:90px">

						

						<input type="text" name="word" id='word' maxlength='16' value="<?=$word?>" class="sch_txt " title="" placeholder="">
						<button id="BtnSearch" onclick='return false' class="btn_nor btn_blue Rmargin"><?=$tit['btn']['search']?></button>
						<select name="logtype" id="logtype" value="<?=$logtype?>" class="selectClass " onChange="typeSelect(this.value)" style="width:150px">
						 <option value=""><?=$msgLog['selectTitle']?></option>
						 <? foreach ($aLogItem as $key=>$value) {
							  if ($logtype==$key) $sel="selected";
							  else $sel="";
								  echo "<option value='$key' $sel>$value</option>";
							}
						 ?>
						 </select>

						<select name="logsub" id='logsub' class="selectClass " onChange="findSelect('logsub')" style="width:100px">
						 <option value=""><?=$msgLog['selectTitle']?></option>
						 <?
						 if ($logtype) {
							 foreach ($aLogAction[$logtype] as $key=>$value) {
								  if ($logsub==$key) $sel="selected";
								  else $sel="";
									  echo "<option value='$key' $sel>$value</option>";
							 }
						}
						 ?>
						</select>

						<?=$html_page?>
					</div>

				</fieldset>
		</div>
	</div>	
	<form name="fmList" id='fmList' method="post" >
	<input type=hidden name="vars" id='vars' value="<?=$_SESSION['Vars']?>" size="80">     <!--ajax 리스트 변수-->
	<input type=hidden name="page" id='page' value="<?=$page?>">
	<input type=hidden name="allchk" id='allchk' value='<?=$allchk?>' >
	<input type=hidden name="chkvalue" id="chkvalue" value="<?=$chkvalue?>">



	<table class="bbs_table_list" cellpadding="0" cellspacing="0" border="0">
		<colgroup>
			<col width="40">
			<col width="150">
			<col width="130">
			<col width="100">
			<col width="180">
			<col width="300">
			<col width="70">
			<col >

		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th><?=$titLog['listTitle']['date']?></th>
				<th><?=$titLog['listTitle']['user']?></th>
				<th><?=$titLog['listTitle']['ip']?></th>
				<th><?=$titLog['listTitle']['item']?></th>
				<th><?=$titLog['listTitle']['target']?></th>
				<th><?=$titLog['listTitle']['action']?></th>
				<th><?=$titLog['listTitle']['result']?></th>
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

		</div>
	</div>
</div>

<!-- 고객인증관리 레이어 끝 -->
<!-- 본문 끝 -->




<? include "../outline/footer.php" ?>



