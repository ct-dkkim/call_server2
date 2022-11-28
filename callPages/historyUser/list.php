<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";


 ##로그기록
    $memu6 ="nowOn";
    $subMenu4_3 ="on";

    $bbs="HISTORY BY CALLNUMBER";


	$pageKey="history_by_callnum";
	if (strpos($_SESSION['viewLog'],$pageKey) ===false) {
		regLog($admin_info['user_id'], '7','view','', '' ,'ENG',$reg_date,'') ;
		if (!$_SESSION['viewLog']){
			set_session('viewLog',$pageKey.";");
		} else {
			$_SESSION['viewLog']=$_SESSION['viewLog'].$pageKey.";";
		}
	}



	//데이타 보존기간 처리
	if ($admin_info['user_level'] == "1") {
		$keep_date= date("Y-m-d", strtotime(date('Y-m-d H:i:s').' -'.$config['keepMonth'].'month')); 
		if (mysqli_query($db,"delete from $bbs where CALLDATE  < '".$keep_date."'")) {
			$reg_date=date("Y-m-d H:i:s");
			$count =mysqli_affected_rows($db);
			if ($count > 0) {
				regLog($admin_info['user_id'], '7','del',$tit['mainTitle']['history_call']." < ".$keep_date, $msg['delResult'].$count ,'ENG',$reg_date) ;
			}
		}
	}

   //변수처리
   $arrVars=explode("&",$_SESSION['Vars']);
   for ($i=0;$i<sizeof($arrVars);$i++) {
		 $arr=explode("=",$arrVars[$i]);
		 ${$arr[0]}=$arr[1];
   }


	$today=date("Y-m-d");
   if (!$st_day) {
	  $st_day=$end_day=$today;
	  $st_time="00:00:00";
	  $end_time="23:59:59";
	  $_SESSION['Vars'] = "st_day=$st_day&end_day=$end_day&st_time=$st_time&end_time=$end_time";
   }



   //permit_admin();

	$alevel = permit_value();


	//일반그룹 셀렉트박스 생성


	//$pageName = "logList";
$aFind =array("TELNO" => $titSession['listTitle']['callNumber']) ; 

$html_page=selectbox("page_num",$aPageNum,$page_num,"","findSelect('')","70");
$html_Find=selectbox("find",$aFind,$find,$msg['allchk'],"","130");

?>
<!DOCTYPE html>
<html lang="ko">
<head>
      <? include_once dirname(__FILE__) . "/../outline/header.php"; ?>
	  <script type="text/javascript" src='../../js/calendar-eraser_lim.js'></script>
	  <link rel='stylesheet' href='../../js/calendar-eraser_lim.css' type='text/css'>
	  <script type="text/javascript" src="../../js/jquery.timeentry.js"></script>
	  <script type="text/javascript">
			var ajaxObjects = new Array();
			var timeid;
			var RegexTime =/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/; //시간정규식

			$(document).ready(function(){
			  listRefresh("<?=$_SESSION['Vars']?>");
			  $(".popup_layer").draggable();

			  $('#st_time').timeEntry({
					show24Hours: true,
					showSeconds: true,
					defaultTime: "<?=$st_time?>"
			  });

			  $('#end_time').timeEntry({
					show24Hours: true,
					showSeconds: true,
					defaultTime: "<?=$end_time?>"
			  });
			  //##### 검색
			  $("#BtnSearch").click(function(e){
				 var params = [ 'st_day', 'st_time','end_day','end_time','find','word','page_num'];
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
			  $("#BtnXlsDown").click(function(e){
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
				 var params = [ 'st_day', 'st_time','end_day','end_time','find','word','page_num'];

 
				 for(var i=4; i<params.length;i++) {
				 	$("#"+params[i]).val('')
				 }


				 $("#st_day").val('<?=$today?>')
				 $("#end_day").val('<?=$today?>')
				 $("#st_time").val('00:00:00')
				 $("#end_time").val('23:59:59')

 		    	 var delparams = [ 'page'];
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


				 chgListVars(params,delparams);
			}




	  </script>
</head>

<body >

<? include "../outline/top.php" ?>

<!-- 본문 시작 -->



<div id="container" class="w_custom">
	<!-- 기본형 시작 -->
	<div class="sub_head1 clear ">
		<h2 class="sub_head_title fl"><?=$tit['mainTitle']['history_user']?></h2>
	</div>
	<div class="sub_head2 clear ">
		<div class="fl" id="divPageNum"></div>
		<div class="sub_head_search fr ta_right">
				<fieldset>
					<legend>검색폼</legend>
					<div class="clear">
						<button id="BtnReset" class="btn_nor btn_grey fl"><?=$tit['btn']['reset']?></button>

						<input type="text" name="st_day"  id="st_day" maxlength="10" value="<?=$st_day?>" onfocus='showCalendarControl(this)' class="sch_txt" style="width:90px"> <input type="text" name="st_time"  id="st_time" maxlength="8" value="<?=$st_time?>"  class="sch_txt" style="width:70px"><span>~</span>
						<input type="text"  name="end_day"  id="end_day" maxlength="10" value="<?=$end_day?>" onfocus='showCalendarControl(this)' class="sch_txt fl5" style="width:90px"> <input type="text" name="end_time"  id="end_time" maxlength="8" value="<?=$end_time?>"  class="sch_txt" style="width:70px;margin-right:20px">

						<?=$html_Find?>
						<input type="text" name="word" id='word' maxlength='16' value="<?=$word?>" class="sch_txt" title="" placeholder="" style="width:120px">
						<button id="BtnSearch" onclick='return false' class="btn_nor btn_blue Rmargin"><?=$tit['btn']['search']?></button>
						
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
			<col width='5%'>
			<col width='10%'>
			<col width='5%'>
			<col width='10%'>
			<col width='5%'>
			<col width='10%'>
			<col width='5%'>
			<col width='10%'>
			<col width='5%'>
			<col width='10%'>
		</colgroup>
		<thead>
			<tr id='tothead'>
				<th rowspan=2>No</th>
				<th rowspan=2><?=$titSession['listTitle']['callNumber']?></th>
				<th colspan=2><?=$titSession['listTitle']['trk']?></th>
				<th colspan=2><?=$titSession['listTitle']['inc']?></th>
				<th colspan=2><?=$titSession['listTitle']['stn']?></th>
				<th colspan=2><?=$titSession['listTitle']['total']?></th>
			</tr>
			<tr id='tothead'>
				<th><?=$titSession['listTitle']['callCount']?></th>
				<th><?=$titSession['listTitle']['duration']?></th>
				<th><?=$titSession['listTitle']['callCount']?></th>
				<th><?=$titSession['listTitle']['duration']?></th>
				<th><?=$titSession['listTitle']['callCount']?></th>
				<th><?=$titSession['listTitle']['duration']?></th>
				<th><?=$titSession['listTitle']['callCount']?></th>
				<th><?=$titSession['listTitle']['duration']?></th>
			</tr>
		</thead>
		<tbody id='divList'>
		<tbody>
	</table>
	</form>
	<div class="bbs_footer clear">
		<div class="bbs_btn ta_right fl">
			<button onclick="return false" id="BtnXlsDown" class="btn_nor btn_grey"><?=$tit['btn']['export']?></button>
		</div>	
		<div class="paginate" id='divPage'>
		</div>
		<div class="bbs_btn ta_right fr">

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



