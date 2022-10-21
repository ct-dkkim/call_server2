<? include_once dirname(__FILE__) . "/../../lib/setConfig.php"; 

	$bbs="web_admin";
	$key =$_POST["key"];

  	if ($key) {
		$sql="select * from $bbs where no='$key'";
		$row=mysqli_fetch_array(mysqli_query($db,$sql));
		$old_key=$row['user_id'];
		$mode="mod";
  	} else {
		$exe="insert";
		$row['level'] ="4"; 
		$mode="add";

  	}


	$arrLevel=array("2"=>$aAdminLevel[2],"4"=>$aAdminLevel[4]); 
	$html_level=radiobox("c_level",$arrLevel,$row['level'], "levelChk()"); 

?>
<script>
	var RegexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i; //이메일 요휴성검사
	var RegexName = /[^_\`\~\!\@\#\$\%\^\&\*\(\)\-\=\+\\\{\}\[\]\'\"\;\:\<\,\>\.\?\/]{2,16}$/; //외국어 이름 유효성 검사 2~16자 사이
	var RegexId = /^[a-zA-Z0-9_\`\~\!\@\#\$\%\^\&\*\(\)\-\=\+\\\{\}\[\]\;\:\,\.\?\/]{4,16}$/; 
	var RegexPass	= /^[\S\x21-\x7E]{4,16}$/;  //비번 유효성 검사

	$(document).ready(function(){

			if ($('#execution').val()=="add") {
				levelChk()
			}

		//PHONE 검색시 숫자만 입력 가능
		$(".numOnly").keyup(function (event) {
			regexp = /[^0-9\-\*]/gi;
			var key = event.which;
			v = $(this).val();
			if (regexp.test(v)) {
				alert("<?=$msg['onlyNum']?>");
				$(this).val(v.replace(regexp, ''));
				return false
			}
		});

		$("input").keydown(function(e) { 
			if (e.keyCode == 13) return false; 
		});


		//전체 저장하기

		$("#BtnSubmit").click(function(e){
			 var chkLevel = $(':radio[name="c_level"]:checked').val();

			var f=document.inputForm;
			if (chkForm(f)){
				if ( !RegexId.test($.trim($("#userid").val())) ) {
					alert("<?=$msgLogin['errId']?>");
					$("#userid").focus();
					return false;
				}

				if ( !RegexName.test($.trim($("#c_name").val())) ) {
					alert("<?=$msgLogin['errName']?>");
					$("#c_name").focus();
					return false;
				}

				if ($('#execution').val()=="add" && $('#pw').val()==""){
						alert("<?=$msgLogin['errPassword1']?>");
						$("#pw").focus();
						return false;
				
				}

				if ($('#pw').val() !="")	{
					
					if ( !RegexPass.test($.trim($("#pw").val())) ) {

						alert("<?=$msgLogin['errPassword2']?>");
						$("#pw").focus();
						return false;
					} else {
						if (!CheckPassword($.trim($("#userid").val()), $.trim($("#pw").val()))){
							$("#pw").focus();
							return false						
						} else {
							if ($('#pw').val() != $('#re_pw').val()){				
								   alert("<?=$msgLogin['errPassword3']?>");
								   $('#re_pw').focus();
								   return false;
							}
						}

					}

				}


				if ( $("#email").val()!='' && !RegexEmail.test($.trim($("#email").val())) ) {
					alert("<?=$msgLogin['errEmail']?>");
					$("#email").focus();
					return false;
				}



				$('#inputForm').submit();
			}


		});
	})

	function levelChk() {
 		var chkLevel = $(':radio[name="c_level"]:checked').val();
		
		if (chkLevel=="2") {
			$(".layer_box_wrap input[type='checkbox']").prop('checked',true);

		} else {
			$(".layer_box_wrap input[type='checkbox']").prop('checked',false);
			$(".layer_box_wrap input[name='phone_view']").prop('checked',true);
			$(".layer_box_wrap input[name='user_view']").prop('checked',true);
			$(".layer_box_wrap input[name='routing_view']").prop('checked',true);
			$(".layer_box_wrap input[name='conversion_view']").prop('checked',true);
			$(".layer_box_wrap input[name='class_view']").prop('checked',true);
			$(".layer_box_wrap input[name='ptt_view']").prop('checked',true);

		}
	}

	function requestChkInfo() {
	      var old_key = $("#old_key").val();
	      var key =  $("#userid").val()
		  if (old_key != key) {

			$.ajax({
				url : "./chkData_ajax.php",
				data : {"key" : key },
				type: "POST",
				success: function(data){
					data = $.trim(data)
	                if (data.length > 2) {
						alert("<?=$titAdmin['dubleID'] ?>");
	                    $("#userid").select()
	                    $("#userid").focus()
	        			return false;

					} else {
	                    $("#name").focus()
					}
				}
			});
		  }
	}

	// 비밀번호 유효성 검사
	function CheckPassword(uid, upw){

			var chk_num = upw.search(/[0-9]/g);
			var chk_eng = upw.search(/[a-z]/ig);
			if(chk_num<0 || chk_eng<0){
				alert("<?=$msgLogin['errPassword4']?>");
				return false
			}
			if(/(\w)\1\1\1/.test(upw)){
				alert("<?=$msgLogin['errPassword5']?>");
				return false
			}
			if(upw.search(uid)>-1){
				alert("<?=$msgLogin['errPassword6']?>");
				return false

			}
			return true
	}

</script>
<div class="container_layer" >
<form name="inputForm" id='inputForm' method=post action='./insert.php' target="hiddenFrm">
<input type=hidden name="execution" id='execution' value="<?=trim($mode)?>" >
<input type=hidden name="old_key" id='old_key' value="<?=$old_key?>"  >

	<dl class="layer_box_wrap on">
		<dt><?=$tit['mainTitle']['loginSetup']?><span class="btn_close_container" onclick="LayerPopup_type2('close');return false">닫기</span></dt>
		<dd>
			<table class="bbs_table_vertical2" cellpadding="0" cellspacing="0" border="0">
				<colgroup>
					<col width="29%">
					<col >
				</colgroup>
				<tbody >
				<? if ($admin_info['level']=="1") { ?>
					<tr>
						<th><?=$titAdmin['listTitle']['level']?></th>
						<td>							
							<?=$html_level?>
						</td>
					</tr>	
				<? } else {?>
					<input type=hidden name='c_level' value='4'>
				<? }?>

				<? if ($key) { ?>
					<input type="hidden" id="userid" name="userid" class="input_w170 intbox" value="<?=$row['user_id']?>" >
					<tr>
						<th><?=$titAdmin['listTitle']['id']?></th>
						<td><strong><?=$row['user_id']?></strong></td>
					</tr>


				<? } else {?>
					<tr>
						<th><?=$titAdmin['listTitle']['id']?></th>
						<td><input type="text" id="userid" name="userid" class="input_w170 intbox" value="<?=$row['user_id']?>" onchange="requestChkInfo()" maxlength="16" required label="<?=$titAdmin['listTitle']['id']?>" <?=$disabled?>></td>
					</tr>

				<? } ?>
					<tr>
						<th><?=$titAdmin['listTitle']['name']?></th>
						<td><input type="text" id="c_name" name="c_name" class="input_w170" value="<?=$row['name']?>" required label="<?=$titAdmin['listTitle']['name']?>" maxlength="32" ></td>
					</tr>	

					<tr>
						<th><?=$titPhone['listTitle']['pw']?></th>
						<td><input type="password" id="pw" name="pw" class="input_w170 intbox" value="" maxlength="16" ></td>
					</tr>

					<tr>
						<th><?=$titPhone['listTitle']['re_pw']?></th>
						<td><input type="password" id="re_pw" name="re_pw" class="input_w170 w70 " value="" maxlength="16"></td>
					</tr>


					<tr>
						<th><?=$titAdmin['listTitle']['email']?></th>
						<td><input type="text" id="email" name="email" class="input_w170" value="<?=$row['email']?>"></td>
					</tr>
				<? if ($key) { ?>
					<tr>
						<th><?=$titAdmin['listTitle']['vHit']?></th>
						<td><?=$row['visited']?></td>
					</tr>
					<tr>
						<th><?=$titAdmin['listTitle']['vDate']?></th>
						<td><?=date("Y-m-d H:i:s", $row['v_date'])?></td>
					</tr>
					<tr>
						<th><?=$titAdmin['listTitle']['regDate']?></th>
						<td><?=date("Y-m-d H:i:s", $row['reg_date'])?></td>
					</tr>										
				<? } ?>					
				<tbody>
			</table>


			<div class="code_box02 code_box_wrap " style="width:512px;padding:0 19px ;margin-top:10px">
				<table class="bbs_table_list bbs_code04" cellpadding="0" cellspacing="0" border="0">
					<colgroup>
						<col >
						<col width="13%">
						<col width="13%">
						<col width="13%">
						<col width="13%">
					</colgroup>
					<thead>
						<tr>
							<th>Menu Permission</th>
							<th> View</th>
							<th> Add</th>
							<th> Mod</th>
							<th> Del</th>
						</tr>
					</thead>
					<tbody >
						<tr >
							<td><?=$tit['mainTitle']['phone']?></td>
							<td><input type="checkbox" name="phone_view" value="Y" <? if ($row['phone_view']=="Y") echo "checked" ?>></td>
							<td><input type="checkbox" name="phone_add" value="Y" <? if ($row['phone_add']=="Y") echo "checked" ?>></td>
							<td><input type="checkbox" name="phone_mod" value="Y" <? if ($row['phone_mod']=="Y") echo "checked" ?>></td>
							<td><input type="checkbox" name="phone_del" value="Y" <? if ($row['phone_del']=="Y") echo "checked" ?>></td>
						</tr>

						<tr>
							<td><?=$tit['mainTitle']['routing']?></td>
							<td><input type="checkbox" name="routing_view" value="Y" <? if ($row['routing_view']=="Y") echo "checked" ?>></td>
							<td><input type="checkbox" name="routing_add" value="Y" <? if ($row['routing_add']=="Y") echo "checked" ?>></td>
							<td><input type="checkbox" name="routing_mod" value="Y" <? if ($row['routing_mod']=="Y") echo "checked" ?>></td>
							<td><input type="checkbox" name="routing_del" value="Y" <? if ($row['routing_del']=="Y") echo "checked" ?>></td>
						</tr>	
						<tr>
							<td><?=$tit['mainTitle']['digit']?></td>
							<td><input type="checkbox" name="conversion_view" value="Y" <? if ($row['conversion_view']=="Y") echo "checked" ?>></td>
							<td><input type="checkbox" name="conversion_add" value="Y" <? if ($row['conversion_add']=="Y") echo "checked" ?>></td>
							<td><input type="checkbox" name="conversion_mod" value="Y" <? if ($row['conversion_mod']=="Y") echo "checked" ?>></td>
							<td><input type="checkbox" name="conversion_del" value="Y" <? if ($row['conversion_del']=="Y") echo "checked" ?>></td>
						</tr>						


						<tr>
							<td><?=$tit['mainTitle']['class']?></td>
							<td><input type="checkbox" name="class_view" value="Y" <? if ($row['class_view']=="Y") echo "checked" ?>></td>
							<td><input type="checkbox" name="class_add" value="Y" <? if ($row['class_add']=="Y") echo "checked" ?>></td>
							<td><input type="checkbox" name="class_mod" value="Y" <? if ($row['class_mod']=="Y") echo "checked" ?>></td>
							<td><input type="checkbox" name="class_del" value="Y" <? if ($row['class_del']=="Y") echo "checked" ?>></td>
						</tr>



						<tr>
							<td><?=$tit['mainTitle']['pri']?></td>
							<td><input type="checkbox" name="user_view" value="Y" <? if ($row['user_view']=="Y") echo "checked" ?>></td>
							<td><input type="checkbox" name="user_add" value="Y" <? if ($row['user_add']=="Y") echo "checked" ?>></td>
							<td><input type="checkbox" name="user_mod" value="Y" <? if ($row['user_mod']=="Y") echo "checked" ?>></td>
							<td><input type="checkbox" name="user_del" value="Y" <? if ($row['user_del']=="Y") echo "checked" ?>></td>
						</tr>



						<tr>
							<td><?=$tit['mainTitle']['etc']?></td>
							<td><input type="checkbox" name="ptt_view" value="Y" <? if ($row['ptt_view']=="Y") echo "checked" ?>></td>
							<td><input type="checkbox" name="ptt_add" value="Y" <? if ($row['ptt_add']=="Y") echo "checked" ?>></td>
							<td><input type="checkbox" name="ptt_mod" value="Y" <? if ($row['ptt_mod']=="Y") echo "checked" ?>></td>
							<td><input type="checkbox" name="ptt_del" value="Y" <? if ($row['ptt_del']=="Y") echo "checked" ?>></td>
						</tr>											
					</tbody>
				</table>
			</div>



			<div class="layer_btn ta_center">
				<button id='BtnSubmit' onclick='return false' class="btn_nor btn_point"><?=$tit['btn']['save']?></button>
				<button onclick="LayerPopup_type2('close');return false" class="btn_nor btn_grey"><?=$tit['btn']['cancle']?></button>
			</div>
		</dd>
	</dl>
	<div class="bottom"></div>
	</form>
</div>