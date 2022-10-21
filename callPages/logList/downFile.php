
		<script type="text/javascript">

			$(document).ready(function(){

			  //내용저장하기
			  $("#BtnDownExe").click(function(e){
	  			 var top=e.pageY - 100
				  if (confirm("<?=$msg['downFile']?>"))   {
					  $('#divDownLoading').html("<img src='../../intro_images/loading_03.gif'>")
					  LayerPopup_type2('#divDownLoading',top)
					  $('#fmList').attr("target", "hiddenFrm" )
					  $('#fmList').attr("action", "./down_ok.php" )
					  $('#fmList').submit();
					  timeid=setTimeout(downResult,1000);						
						 
				  }
			  });

  

			})



		</script>
		<header class="h">
			<h1><span>
					<?=$titLog['downTitle']?> 
			</span></h1>
			<button class="close" onclick="LayerPopup_type2('close');"><img src="<?=$imagesFolder?>/popup/btn_close.png" alt="닫기"></button>
		</header>
		<article>
			<div class="inner">
				<div class="table_type2 mb20">
				   <div  id='divContent' >
					<table summary="Login Setup">
						<caption>PTT Phone</caption>		
						<colgroup>
							<col width="35%">
							<col >
						</colgroup>
						<tbody>
							<tr>
								<th scope="row"><span class="ico1"><?=$titLog['downTitle1']?></span></th>
								<td colspan="2">
									<div id="DownDate">		</div>
								</td>
							</tr>
							<tr>
								<th scope="row"><span class="ico1"><?=$titLog['downTitle2']?></span></th>
								<td colspan="2">
									
									<div class="file_input_div ">
										<span id='downTotal'></span> <?=$titCommend['title']['unit']?>
									</div>
								</td>
							</tr>
							
						</tbody>

					</table>


					</div>
 
				</div><!-- table_type2 -->
				<div class="bot">
					<button id='BtnDownExe' onclick="return false" class="btn blue">Download</button>
					<button onclick="LayerPopup_type2('close');return false"  class="btn white">Cancel</button>
				</div>


			</div><!-- inner -->
		</article>
