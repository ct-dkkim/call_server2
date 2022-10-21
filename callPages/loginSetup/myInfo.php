<? include_once dirname(__FILE__) . "/../../lib/setConfig.php"; 

	$bbs="web_admin";
	if (!$_SESSION["mno"] ) {
		echo "<script>history.go(-1)</script>";
	} else {
		$sql="select * from $bbs where no='".$_SESSION["mno"]."'";
		$row=mysqli_fetch_array(mysqli_query($db,$sql));
		$mode="myInfo";

	}	


?>
<script>
	var RegexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i; //이메일 요휴성검사
	var RegexName = /[^_\`\~\!\@\#\$\%\^\&\*\(\)\-\=\+\\\{\}\[\]\'\"\;\:\<\,\>\.\?\/]{2,16}$/; //외국어 이름 유효성 검사 2~16자 사이
	var RegexId = /^[a-zA-Z0-9_\`\~\!\@\#\$\%\^\&\*\(\)\-\=\+\\\{\}\[\]\;\:\,\.\?\/]{4,16}$/; 
	var RegexPass	= /^[\S\x21-\x7E]{4,16}$/;  //비번 유효성 검사

	$(document).ready(function(){


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

			var f=document.inputForm;
			if (chkForm(f)){

				if ( !RegexName.test($.trim($("#c_name").val())) ) {
					alert("<?=$msgLogin['errName']?>");
					$("#c_name").focus();
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
<form name="inputForm" id='inputForm' method=post action='../loginSetup/insert.myInfo.php' target="hiddenFrm">
<input type=hidden name="mno" id='mno' value="<?=$row['no']?>"  >

	<dl class="layer_box_wrap on">
		<dt><?=$tit['mainTitle']['myInfo']?><span class="btn_close_container" onclick="LayerPopup_type2('close');return false">닫기</span></dt>
		<dd>
			<table class="bbs_table_vertical" cellpadding="0" cellspacing="0" border="0">
				<colgroup>
					<col width="29%">
					<col >
				</colgroup>
				<tbody >
					<tr>
						<th><?=$titAdmin['listTitle']['level']?></th>
						<td>							
							<?=$aAdminLevel[$row['level']]?>
						</td>
					</tr>	


					<input type="hidden" id="userid" name="userid" class="input_w170 intbox" value="<?=$row['user_id']?>" >
					<tr>
						<th><?=$titAdmin['listTitle']['id']?></th>
						<td><strong><?=$row['user_id']?></strong></td>
					</tr>



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

					
				<tbody>
			</table>



			<div class="layer_btn ta_center">
				<button id='BtnSubmit' onclick='return false' class="btn_nor btn_point"><?=$tit['btn']['save']?></button>
				<button onclick="LayerPopup_type2('close');return false" class="btn_nor btn_grey"><?=$tit['btn']['cancle']?></button>
			</div>
		</dd>
	</dl>
	<div class="bottom"></div>
	</form>
</div>