<!--<section id="history1_popup" class="popup_layer" style="display: none;">-->
<script type="text/javascript">

			$(document).ready(function(){
			  //취소
			  $("#BtnClose").click(function(e){
				$("#divDataView").hide()

			  });
			})

			//#####VIEW GET  
			function viewGetValue(key,top) {
				var ajaxIndex = ajaxObjects.length;
				ajaxObjects[ajaxIndex] = new sack();
				ajaxObjects[ajaxIndex].method = "POST";
				ajaxObjects[ajaxIndex].setVar("key", key);
				ajaxObjects[ajaxIndex].requestFile = "./getValue_ajax.php";	
				ajaxObjects[ajaxIndex].onCompletion = function() { viewGetValueComplete(ajaxIndex,key,top); } ;		ajaxObjects[ajaxIndex].runAJAX();	

			}
			function viewGetValueComplete(index,key,top)		{
				var result=ajaxObjects[index].response
			    var arr = jQuery.parseJSON(result);
				$("#regdate").val(arr.REGTIME);
				$("#userid").val(arr.USERID);
				$("#logtype2").val(arr.LOGMENU);
				$("#title").val(arr.TITLE);
				$("#content").val(arr.CONTENT);
				LayerPopup_type2('#divDataView',top+100)
			}
</script>

		<header class="h">
			<h1><span><img src="<?=$imagesFolder?>/popup/h_loglist.png" alt="Login Setup"></span></h1>
			<button class="close" onclick="LayerPopup_type2('close');return false"><img src="<?=$imagesFolder?>/popup/btn_close.png" alt="닫기"></button>
		</header>
		<article>
			<div class="inner">
				<div class="table_type2 mb30">
					<table summary="Login Setup">
						<caption>Log List</caption>		
						<colgroup>
							<col width="170">
							<col>
						</colgroup>
						<tbody>
							<tr>
								<th scope="row"><span class="ico1">Date</span></th>
								<td><input type="text" name="regdate" id='regdate'  value="" class="inp_txt"></td>
							</tr>
							<tr>
								<th scope="row"><span class="ico1">ID</span></th>
								<td><input type="text" name='userid' id='userid' value=""  class="inp_txt" readonly></td>
							</tr>
							<tr>
								<th scope="row"><span class="ico1">Type</span></th>
								<td><input type="text"  name="logtype2" id='logtype2'   value="" class="inp_txt" readonly> </td>
							</tr>
							<tr>
								<th scope="row"><span class="ico1">Title</span></th>
								<td><input type="text" name="title" id='title'  class="inp_txt w350" readonly></td>
							</tr>

						</tbody>
					</table>
					
				</div><!-- table_type2 -->

				<div class="table_type2 ">
					<table summary="Login Setup2">
						<caption>Login Setup2</caption>		
						<colgroup>
							<col width="180">
							<col>
						</colgroup>
						<tbody>
							<tr>
								<th scope="row"><span class="ico1">Content</span></th>
								<td><textarea id='content', name='content' rows=8 cols=50 readonly></textarea></td>
							</tr>

						</tbody>
					</table>
				</div><!-- table_type2 -->
				<div class="bot">
					<button onclick="LayerPopup_type2('close');return false"><img src="<?=$imagesFolder?>/btn/btn_cancel.jpg" alt="Cancel"></button>
				</div>
				<script type="text/javascript">
					$(".table_type2 > table >  tbody tr:nth-child(even) > *").css("background-color","#f6fbff")
				</script>

			</div><!-- inner -->
		</article>
