
		<script type="text/javascript">

			$(document).ready(function(){

			  //내용저장하기
			  $("#BtnDownExe").click(function(e){
	  			 var top=e.pageY 
				  if (confirm("<?=$msg['downFile']?>"))   {
					  $('#divDownLoading').html("<img src='../../intro_images/loading_03.gif'>")
					  LayerPopup_type2('#divDownLoading',top)
					  $('#fmList').attr("target", "hiddenFrm" )
					  $('#fmList').attr("action", "./downFile_ok.php" )
					  $('#fmList').submit();
					  timeid=setTimeout(downResult,1000);						
						 
				  }
			  });

  

			})


		</script>

<div class="container_layer" >

	<dl class="layer_box_wrap on">
		<dt><?=$titPhone['downTitle']?><span class="btn_close_container" onclick="LayerPopup_type2('close');return false">닫기</span></dt>
		<dd>
			<table class="bbs_table_vertical" cellpadding="0" cellspacing="0" border="0">
				<colgroup>
					<col width="29%">
					<col >
				</colgroup>
				<tbody >
							<tr>
								<th ><?=$titPhone['downTitle1']?></th>
								<td >
									<div class="file_input_div" id="DownDate" style='width:100%;word-break:break-all;min-height:25px'><?=$tit['mainTitle']['phone']?>

									</div>
								</td>
							</tr>
							<tr>
								<th ><?=$titPhone['downTitle2']?></th>
								<td >
									
										<span id='downTotal'></span> <?=$titCommend['title']['unit']?>
								</td>
							</tr>

				<tbody>
			</table>
			<div class="layer_btn ta_center">

					<button id='BtnDownExe' onclick="return false" class="btn_nor btn_point">Download</button>

					<button onclick="LayerPopup_type2('close');return false" class="btn_nor btn_grey"><?=$tit['btn']['cancle']?></button>



			</div>
		</dd>
	</dl>
	<div class="bottom"></div>
</div>

