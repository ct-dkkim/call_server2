<? if (!$popType) $popType="1"?>
<div class="container_layer" >
	<dl class="layer_box_wrap on">
		<dt><span id="popAtionTitle"><?=$headTitle?>&nbsp;</span><span class="btn_close_container" onclick="delPopupClose('<?=$popType?>');return false">닫기</span></dt>
		<dd>
			<div class="inner">
				<div class="table_type2 mb20">
					<ul class="bg">
						<li style="display:none;"><input name='rphone'><input name='rphone'></li>
						<li>
							<div class="titleLine floatnone"><span class="ico1"><?=$titResult['title']['total'] ?>  : </span> <span id="popAtion_totalCnt"><?=$totalCnt?></span></div>
						</li>
						<li>
							<div class="titleLine floatnone"><span class="ico1"><?=$titResult['title']['success'] ?> : </span> <span id="popAtion_okCnt"><?=$cnt?></span></div>
						</li>
						<li>
							<div class="titleLine floatnone"><span class="ico1"><?=$titResult['title']['error'] ?> : </span> <span id="popAtion_errCnt"><?=$errCnt?></span></div>
						</li>
						<li>
							<h4 class="result_btn">
								<img src="<?=$imagesFolder?>/btn/btn_detailview.gif" alt="detailview" onclick="showDetail('1')" id='resultOpen'>
								<img src="<?=$imagesFolder?>/btn/btn_resultclose.gif" alt="close" id='resultClose' onclick="showDetail('2')" style="display:none">
							</h4>
						</li>
					</ul>
					<div class="result_area" style="display:none">
						<h2 style="color:#fff">Detail Value</h2>
						<div >
							<ul id="popAtion_result">
							<?=$result?>
							</ul>
						</div>
					</div><!--result_area-->
				</div><!-- table_type2 -->
				<div class="bot" style="clear:both">
					<button class="btn_nor btn_grey" onclick="delPopupClose('<?=$popType?>');return false"><?=$tit['btn']['close']?></button>
				</div>
			</div><!-- inner -->
		</dd>
	</dl>
	<div class="bottom"></div>
</div>
<script>
	function showDetail(type){
		if (type=="1")	{
		
		$('.result_area').show()
		$('#resultOpen').hide()
		$('#resultClose').show()
		} else {
		$('.result_area').hide()
		$('#resultOpen').show()
		$('#resultClose').hide()

		}
	}
	function delPopupClose(type) {

		if (type=="2") 	{
			LayerPopup_type3('#DivResult','0','close')
		}  else if (type=="3") {
			getClassList('<?=$_SESSION['Vars']?>', '<?=$keyClass?>');
			LayerPopup_type2('close');

		} else {
			var params = ['page_num'];
			var delparams = ['allchk','chkvalue'];	
			document.getElementById('all').checked=false;
			chgListVars(params,delparams);
			LayerPopup_type2('close');
		}
	}

</script>
