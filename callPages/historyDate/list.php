<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";


 ##로그기록
    $memu6 ="nowOn";
    $subMenu4_4 ="on";

    $bbs="HISTORY BY DATE";


	$pageKey="history_by_date";
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
	
	list($firstYear) = mysqli_fetch_array(mysqli_query($db,"select min(left(CALLDATE,4)) from call_history")) ; 


	//변수처리
	$arrVars=explode("&",$_SESSION['Vars']);
	for ($i=0;$i<sizeof($arrVars);$i++) {
			$arr=explode("=",$arrVars[$i]);
			${$arr[0]}=$arr[1];
	}


	if (!$fyear) {
		$search_type="day";
		$fyear=date('Y');
		$fmonth=date('m');

		$_SESSION['Vars'] = "search_type=$search_type&fyear=$fyear&fmonth=$fmonth";
	}

	if ($search_type) {
		$checked['search_type'][$search_type]="checked";
	}



   //permit_admin();

	$alevel = permit_value();


	//일반그룹 셀렉트박스 생성


	//$pageName = "logList";


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
			  $('#divPageNum').hide();


			  //##### 검색
			  $("#BtnSearch").click(function(e){
				 var search_type=$('input:radio[name="rsearch_type"]:checked').val()
				 $('#search_type').val(search_type)
				 var params = [ 'search_type','fyear','fmonth','page_num'];
 		    	 var delparams = [ 'page' ];

				 chgListVars(params,delparams);
			  });

			  //##### 엑셀파일다운로드
			  $("#BtnXlsDown").click(function(e){
	  			  var top=e.pageY - 100
				  var pageTotal=$('#divPageNum').html().split("(")
				  var total=pageTotal[0].split(":")
				  if($('input:radio[id=month]').is(':checked')){
					$('#DownDate').html($('#fyear').val())
					}else{
					$('#DownDate').html($('#fyear').val() + " - " +$('#fmonth').val())
					}
				  
				  $('#downTotal').html(total[1])
				  LayerPopup_type2('#divDown',top)
			  });

			  //##### 페이지 출력량 변경
			  $("#page_num").change(function(e){
				 var params = [ 'page_num'];
 		    	 var delparams = ['page'];	 
				 chgListVars(params,delparams);
			  });


			  searchtype_chk()

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

			function searchtype_chk() {
				if($('input:radio[id=month]').is(':checked')){
					$('#DivMonthSelect').hide();
				}else{
					$('#DivMonthSelect').show();
				}
			}

	  </script>
</head>

<body >

<? include "../outline/top.php" ?>

<!-- 본문 시작 -->



<div id="container" class="w_custom">
	<!-- 기본형 시작 -->
	<div class="sub_head1 clear ">
		<h2 class="sub_head_title fl"><?=$tit['mainTitle']['history_date']?></h2>
	</div>
	
	<div class="sub_head2 clear ">
	<div class="fl" id="divPageNum"></div>
		<div class="sub_head_search_tot fr ta_right">
				<fieldset>
					<legend>검색폼</legend>					
					
					<div class="option">						
						<stong class="sch_tot_title" ><!--통계기준--><?=$titSession['listTitle']['dateFomat']?></stong>
						<input type="radio" name="rsearch_type" id="day" value="day"  <?=$checked['search_type']['day']?> onclick='searchtype_chk()'>
						<label for="PTTGroup" class="mr5"><!--일별--><?=strtoupper($schTime['day'])?></label>

						<input type="radio" name="rsearch_type" id="month" value="month"  <?=$checked['search_type']['month']?> onclick='searchtype_chk()'>
						<label for="PTTGroup2" class="mr5"><!--월별--><?=strtoupper($schTime['month'])?></label>


					</div>
					
					<div class="option">
					  <select name=fyear id="fyear" class="selectClass w80">
						 <? for ($i=$firstYear;$i<=date('Y');$i++){
							   if ($fyear == $i ) {
								 echo "<option value='$i' selected >$i ".$titHistory['dateUnit']['year']."</option>" ;
							   } else {
								  echo "<option value='$i' >$i ".$titHistory['dateUnit']['year']."</option>" ;
							   }
							}
						?>
					  </select>&nbsp;&nbsp;	
					  
					  <span id='DivMonthSelect'>
					  <select name=fmonth id="fmonth" class="selectClass w70">

						<? for ($i=1;$i<=12;$i++) {
							if ($i < 10) {
								$mon= "0".$i ;
							} else {
								$mon= $i ;
							}

							if ($fmonth==$mon) {
								 echo "<option value='$mon' selected >$mon ".$titHistory['dateUnit']['month']."</option>" ;
							 } else {
								  echo "<option value='$mon' >$mon ".$titHistory['dateUnit']['month']."</option>" ;
							 }
						}
						?>
						</select>
						</span>
						&nbsp;
						<!--## 검색항목-->
						<button id="BtnSearch" onclick='return false' class="btn_nor btn_blue Rmargin"><?=$tit['btn']['search']?></button>
					</div>

				</fieldset>
		</div>
	</div>	
	<form name="fmList" id='fmList' method="post" >
	<input type=hidden name="vars" id='vars' value="<?=$_SESSION['Vars']?>" size="80">     <!--ajax 리스트 변수-->
	<input type=hidden name="page" id='page' value="<?=$page?>">
	<input type=hidden name="allchk" id='allchk' value='<?=$allchk?>' >
	<input type=hidden name="chkvalue" id="chkvalue" value="<?=$chkvalue?>">
	<input type=hidden name="search_type" id='search_type' value="<?=$search_type?>">
	<input type=hidden name="page_num" id='page_num' value="31">


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
			<tr id='totcont'>
				<th rowspan=2>No</th>
				<th rowspan=2><?=$titSession['listTitle']['date']?></th>
				<th colspan=2><?=$titSession['listTitle']['trk']?></th>
				<th colspan=2><?=$titSession['listTitle']['inc']?></th>
				<th colspan=2><?=$titSession['listTitle']['stn']?></th>
				<th colspan=2><?=$titSession['listTitle']['total']?></th>
			</tr>
			<tr id='totcont'>
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



