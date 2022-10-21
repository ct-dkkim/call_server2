<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";

$levelKey = $_POST['levelKey'];  //접근 레벨키 
$alevel=array("view"=>$admin_info[$levelKey.'_view'], "add"=>$admin_info[$levelKey.'_add'], "mod"=>$admin_info[$levelKey.'_mod'], "del"=>$admin_info[$levelKey.'_del']);

if ($alevel['del']=="Y" || $alevel['add']=="Y" || $alevel['mod']=="Y") {


?>
		<script type="text/javascript">
			$(document).ready(function(){
			  //내용저장하기
			  $("#BtnUpfileExe").click(function(e){
					   if ($('#attach').val()=="") {
						  
						   alert("<?=$msg['selFile']?>")
						   $('#attach').focus()
							return false
					   }
					   //$("#chg_ing").show();
					   $('#fmUpload').submit();
			  }); 

			  $(".btnActionResultClose").click(function(e){
				getTree("<?=$DSeqNo?>");
				hideTextBox()

			  }); 

			})

			function uploadClose() {
				var vars=$('#vars').val()
				var exe=$('#exe').val()  //1:부서추가 0:없음

				if (exe=="1"){
					window.location.reload();	
				} else {
					listRefresh(vars);
					LayerPopup_type2('close')
				}
			}

/*
			function uploadResult(log) {
				alert(log)
				$("#divInput").html(log)
				LayerPopup_type2('#divInput',500)

			}
*/
		</script>
<div class="container_layer" id="upfile_input">

	<dl class="layer_box_wrap on">
		<dt><?=$tit['mainTitle']['phone'] ." ".$titPhone['uploadTitle']?><span class="btn_close_container" onclick="LayerPopup_type2('close');return false">닫기</span></dt>
		<dd>
<form name="fmUpload" id='fmUpload' method="POST" target='hiddenFrm' action="uploadFile_ok.php" enctype="multipart/form-data" >

<input type="hidden" name="levelKey" id="levelKey" value="<?=$levelKey ?>" />    <!--현재부서key-->
<input type="hidden" name="exe" id="exe" value="0" />   <!--업로드실행-->



					<table class="bbs_table_vertical" cellpadding="0" cellspacing="0" border="0">
						<caption>PTT Phone</caption>		
						<colgroup>
							<col width="25%">
							<col >
						</colgroup>
						<tbody>
							<tr>
								<th ><?=$tit["upload"]["type"]?></th>
								<td colspan="2">
									<div class="lst_check radio">
										<? if ($alevel['del']=="Y" || $alevel['add']=="Y" || $alevel['mod']=="Y") { ?>
										<span class="radio2">
											<input type="radio" name="set_type" value="new" id="new" checked="checked">
											<label for="new"><?=$tit["upload"]["new"]?></label>
										</span>
										<? } ?>
										<? if ($alevel['del']=="Y" ||  $alevel['mod']=="Y") { ?>									
										<span class="radio2">
											<input type="radio" name="set_type" value="modify" id="modify" >
											<label for="modify"><?=$tit["upload"]["edit"]?></label>
										</span>
										<? }?>
										<? if ($alevel['del']=="Y" ) { ?>		
										<span class="radio2">
											<input type="radio"  name="set_type" value="insert" id="Initialize ">
											<label for="Initialize "><?=$tit["upload"]["initialize"]?></label>
										</span>
										<? }?>
									</div>
								</td>
							</tr>

							<tr>
								<th ><?=$tit["upload"]["file"]?></th>
								<td colspan="2">
									<input type="text" id="fileName" class="file_input_textbox" readonly="readonly" style="width:230px"> 
									<div class="file_input_div ">
										<input type="button" value="Search" class="file_input_button" />
										<input type="file" name='attach'id="attach" class="file_input_hidden" onchange="javascript: document.getElementById('fileName').value = this.value" />
									</div>
								</td>
							</tr>
							
						</tbody>

					</table>
					<div  id='divLog' >	</div>
  					<div class="popup_type15" id='chg_ing' style=';background:#ffcc00;display:none'>
						<div style='margin:15px auto'>
							<strong>진행상태 : 작업중입니다.......</strong>
						</div>
					</div>    
</form>
			<div class="layer_btn ta_center">

					<button id='BtnUpfileExe' onclick="return false" class="btn_nor btn_point"><?=$tit['btn']['import']?></button>

					<button onclick="uploadClose();return false" class="btn_nor btn_grey"><?=$tit['btn']['cancle']?></button>

			</div>
		</dd>
	</dl>
	<div class="bottom"></div>
</div>
<div id="upfile_end" style="display:none">
<? 	include "../outline/popActionResult.php";  ?>

</div>
<? } else {
	echo $msg['permit2'] ; 
 } 

 ?>
