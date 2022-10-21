<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
   $memu1 ="nowOn";

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <? include_once dirname(__FILE__) . "/../outline/header.php"; ?>
	<script type="text/javascript">
	(function($){
		$(document).ready(function(){
			$('#lnb').addClass('lnb_03');
			$('#lnb .hd_lnb03').addClass('on');

			$(".go_certification").click(function(e) {
				$("#contents_wrap .bg_back").addClass("on");
				$("#contents_wrap .container_layer").addClass("on");
				return false
			});

			$(".btn_close_container").click(function(e) {
				$("#contents_wrap .bg_back").removeClass("on");
				$("#contents_wrap .container_layer").removeClass("on");
				return false
			});

		});
	})(jQuery);
	</script>
</head>
<body>

<? include "../outline/top.php" ?>

<!-- 본문 시작 -->


<form name="" method="post" action="">

<div id="container" class="w_custom">
	<!-- 기본형 시작 -->
	<div class="sub_head clear ">
		<h2 class="sub_head_title fl">디지트별 발신경로관리</h2>
		<div class="sub_head_search fr ta_right">
			<form name="" id="" action="" method="get">
				<fieldset>
					<legend>검색폼</legend>
					<div class="clear">
						<span class="btn_xs btn_wh fl">검색</span>
						<input type="text" id="" name="keyword" class="sch_txt" title="" placeholder="">
						<button type="submit" class="btn_nor btn_blue">실행</button>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
	<!-- 기본형 끝 -->
	<!-- 셀렉트박스형 시작 -->
	<div class="sub_head clear ">
		<a href="#" class="btn_call fl">통화리스트</a>
		<div class="sub_head_form fr">
			<form name="" id="" method="get">
				<div class="form_wrap clear">
                    <fieldset>
                        <legend></legend>
						<span class="check_box check_box_right form_element">
							<input name="session_auto" id="session_auto" onclick="chkbox_atc()" type="checkbox" checked="" value="1" class="checkbox">
							<label for="session_auto" class="check-s">Auto Refresh</label>
						</span>
						<span class="form_element">Refresh Time</span>
						<div class="select_box_wrap form_element">
							<select name="" class="select_box">
								<option value="">5sec</option>
								<option value="">10sec</option>
							</select>
						</div>
						<span class="form_element">View</span>
						<div class="select_box_wrap form_element">
							<select name="" class="select_box">
								<option value="">All</option>
								<option value="">상품코드</option>
							</select>
						</div>
						<div class="form_element">
							<input type="text" id="" name="" class="select_price price1" value="">
							<span class="bar"></span>
							<input type="text" id="" name="" class="select_price price2" value="">
						</div>
						<div class="form_element">
							<button type="submit" class="btn_nor btn_blue">Apply</button>
						</div>
                    </fieldset>
				</div>
            </form>
		</div>
	</div>
	<!-- 셀렉트박스형 끝 -->
	<table class="bbs_table_list" cellpadding="0" cellspacing="0" border="0">
		<colgroup>
			<col width="7%">
			<col width="8.7%">
			<col width="12%">
			<col width="14.3%">
			<col width="29%">
			<col >
		</colgroup>
		<thead>
			<tr>
				<th>
					<span class="check_box">
						<input type="checkbox" id="all" name="all" onclick="selectall()" class="checkbox" value="0">
						<label for="all" class="check-s fs_0">전체선택</label>
					</span>
				</th>
				<th>번호</th>
				<th>인증 ID</th>
				<th>인증암호</th>
				<th>고객명</th>
				<th>MAC Address</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<span class="check_box">
						<input name="chk[]" id="chk[]" onclick="selchk(this)" type="checkbox" value="5~" class="checkbox">
						<label for="chk[]" class="check-s fs_0">선택</label>
					</span>
				</td>
				<td>1</td>
				<td>1482</td>
				<td><span class="go_certification">1*****</span></td>
				<td class="ta_left pl_30">김포도시철도</td>
				<td class="ta_left pl_30">354878738786877387</td>
			</tr>
			<tr>
				<td>
					<span class="check_box">
						<input name="chk[]" id="chk[]" onclick="selchk(this)" type="checkbox" value="5~" class="checkbox">
						<label for="chk[]" class="check-s fs_0">선택</label>
					</span>
				</td>
				<td>2</td>
				<td>1481</td>
				<td><span class="go_certification">1*****</span></td>
				<td class="ta_left pl_30">김포도시철도</td>
				<td class="ta_left pl_30">45678538738754348522</td>
			</tr>
		<tbody>
	</table>
	<div class="bbs_footer clear">
		<div class="bbs_page">
			<ol class="page_wrap">
				<li class="page_first"><a href="#" class="btn_sm btn_grey btn_prev">prev</a></li>
				<li><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li><a href="#">6</a></li>
				<li><a href="#">7</a></li>
				<li><a href="#">8</a></li>
				<li><a href="#">9</a></li>
				<li><a href="#">10</a></li>
				<li class="page_last"><a href="#" class="btn_sm btn_grey btn_next">next</a></li>
			</ol>
		</div>
		<div class="bbs_btn ta_right fr">
			<button onclick="" class="btn_nor btn_point">추가</button>
			<button onclick="" class="btn_nor btn_grey">삭제</button>
		</div>
	</div>
</div>
<!-- 고객인증관리 레이어 시작 -->
<div class="container_layer">
	<dl class="layer_box_wrap">
		<dt>고객인증관리<span class="btn_close_container">닫기</span></dt>
		<dd>
			<table class="bbs_table_vertical" cellpadding="0" cellspacing="0" border="0">
				<colgroup>
					<col width="29%">
					<col >
				</colgroup>
				<tbody>
					<tr>
						<th>인증 ID</th>
						<td><input type="text" id="" name="" class="input_w170" value="1003"></td>
					</tr>
					<tr>
						<th>인증암호</th>
						<td><input type="text" id="" name="" class="input_w170" value=""></td>
					</tr>
					<tr>
						<th>인증암호확인</th>
						<td><input type="text" id="" name="" class="input_w170" value=""></td>
					</tr>
					<tr>
						<th>고객명</th>
						<td><input type="text" id="" name="" class="input_w290" value=""></td>
					</tr>
					<tr>
						<th>MAC Address</th>
						<td><input type="text" id="" name="" class="input_w290" value=""></td>
					</tr>
				<tbody>
			</table>
			<div class="layer_btn ta_center">
				<button onclick="" class="btn_nor btn_point">저장</button>
				<button onclick="" class="btn_nor btn_grey">취소</button>
			</div>
		</dd>
	</dl>
</div>
<!-- 고객인증관리 레이어 끝 -->
</form>
<!-- 본문 끝 -->

<? include "../outline/footer.php" ?>
