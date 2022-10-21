<? include_once dirname(__FILE__) . "/../../lib/setConfig.php";
	$bbs="REGISTER";
	$key =$_POST["key"];
	$levelKey =$_POST["levelKey"];
	$alevel=array("view"=>$admin_info[$levelKey.'_view'], "add"=>$admin_info[$levelKey.'_add'], "mod"=>$admin_info[$levelKey.'_mod'], "del"=>$admin_info[$levelKey.'_del']);

  	if ($key) {
		$sql="select * from $bbs where PHONE='$key'";
		$row=mysqli_fetch_array(mysqli_query($db,$sql));
		$old_key=$row['PHONE'];
		$mode="mod";
  	} else {
		$mode="add";
		$row['PORT']="5060";
		$row['EXPIRES']="3600";
		$row['MAXDURATION']="0";
  	}

  	//전화사용등급 SELECT 생성 
	$query="select * from CLASS order by CLASS";
	$rs=mysqli_query($db,$query);
	while ($temp=mysqli_fetch_array($rs)) {
		$arrClass[$temp['CLASS']] = $temp['CLASS'] ."-". $temp['EXPLAN'] ;
	}
	$html_class=selectbox("class",$arrClass,$row['CLASS'],"Select" ,"","230");

  	//당겨답기 그룹  SELECT 생성 
	$query="select * from PICKUPGROUP order by PCODE";
	$rs=mysqli_query($db,$query);
	while ($temp=mysqli_fetch_array($rs)) {
		$arrPgroup[$temp['PCODE']] = $temp['PCODE'] ."-". $temp['PNAME'] ;
	}
	$html_pgroup=selectbox("pgroup",$arrPgroup,$row['PGROUP'],"Select" ,"","230");

  	//트렁크번호  SELECT 생성 
	$query="select TNUMBER ,TNAME from TRUNK_NUMBER order by TNUMBER";
	$rs=mysqli_query($db,$query);
	$arrTrunk=array();
	while ($temp=mysqli_fetch_array($rs)) {
		$arrTrunk[$temp['TNUMBER']] = $temp['TNUMBER'] ."-". $temp['TNAME'] ;
	}
	$html_trunk=selectbox("trunk",$arrTrunk,$row['TNUMBER'],"Select" ,"","230");

?>
<script>
	var RegexIp = /^(1|2)?\d?\d([.](1|2)?\d?\d){3}$/;
    var RegexName = /[^_\`\~\!\@\#\$\%\^\&\*\(\)\-\=\+\\\{\}\[\]\'\"\;\:\<\,\>\.\?\/]{2,16}$/; //외국어 이름 유효성 검사 2~16자 사이
	var RegexId = /^[a-z0-9_\`\~\!\@\#\$\%\^\&\*\(\)\-\=\+\\\{\}\[\]\;\:\,\.\?\/]{4,16}$/; 
	var RegexPass	= /^[\S\x21-\x7E]{4,16}$/;  //비번 유효성 검사

	var levelMod = "<?=$alevel['mod']?>"
	$(document).ready(function(){


		if (levelMod !="Y" && $('#execution').val()=="mod") {
			$(".layer_box_wrap input[type='text']").addClass('onlyread')
			$('.onlyread').attr('readonly',true);
			$('.layer_box_wrap .selectClass').addClass('onlyread')
			$('.layer_box_wrap .selectClass').attr('disabled',true);
			$(".layer_box_wrap input[type='checkbox']").attr('disabled',true);

		} else {
			$(".layer_box_wrap input[type='text']").removeClass('onlyread')
			$('.layer_box_wrap .onlyread').attr('readonly',false);
			$('.layer_box_wrap .selectClass').removeClass('onlyread')			
			$('.layer_box_wrap .selectClass').attr('disabled',false);
			$(".layer_box_wrap input[type='checkbox']").attr('disabled',false);
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
			var f=document.inputForm;
			if (chkForm(f)){
				if ( !RegexId.test($.trim($("#userid").val())) ) {
					alert("<?=$msgLogin['errId']?>");
					$("#userid").focus();
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

						if ($('#pw').val() != $('#re_pw').val()){				
							alert("<?=$msgLogin['errPassword3']?>");
							$('#re_pw').focus();
							return false;
						}
					}

				}
				if ( !RegexName.test($.trim($("#name").val())) ) {
					alert("<?=$msgLogin['errName']?>");
					$("#name").focus();
					return false;
				}

				if ( $.trim($("#ipaddr").val()) !="") {
					if (!RegexIp.test($.trim($("#ipaddr").val())) ) {
						alert("<?=$titPhone['errIp']?>");
						$("#ipaddr").focus();
						return false;
					}
				}

				$('#inputForm').submit();
			}

		});
	})

function requestChkInfo() {
      var old_key = $("#old_key").val();
      var key =  $("#phone").val()
	  if (old_key != key) {

		$.ajax({
			url : "./chkData_ajax.php",
			data : {"key" : key },
			type: "POST",
			success: function(data){
				data = $.trim(data)
                if (data.length > 2) {
					alert("<?=$titPhone['dublePhone']?>");
                    $("#phone").select()
                    $("#phone").focus()
        			return false;
				} else {
                    $("#userid").focus()
                    return false
				}
			}
		});
	  }
}


function requestChkInfo2() {
      var old_user = $("#old_user").val();
      var user_id =  $("#userid").val();

	  if (old_user != user_id) {

		$.ajax({
			url : "./chkData_id.php",
			data : {"user_id" : user_id },
			type: "POST",
			success: function(data){
				data = $.trim(data)				
                 if (data.length > 2) {
					 alert("이미 존재하는 ID 입니다.");
                     $("#userid").select()
                     $("#userid").focus()
                     return false
				  } else {
                     $("#pw").focus()
                     return false
				  }
			}
		});
	  }
}

</script>
<div class="container_layer" >
<form name="inputForm" id='inputForm' method=post action='./insert.php' target="hiddenFrm">
<input type=hidden name="execution" id='execution' value="<?=trim($mode)?>" >
<input type=hidden name="old_key" id='old_key' value="<?=$old_key?>"  >
  <input type=hidden name="old_user" id="old_user" value="<?=$row['USER_ID']?>">


	<dl class="layer_box_wrap on">
		<dt><?=$tit['mainTitle']['phone']?><span class="btn_close_container" onclick="LayerPopup_type2('close');return false">닫기</span></dt>
		<dd>
			<table class="bbs_table_vertical2" cellpadding="0" cellspacing="0" border="0">
				<colgroup>
					<col width="29%">
					<col >
				</colgroup>



				<tbody >
					<tr>
						<th><?=$titPhone['listTitle']['phone']?></th>
						<td><input type="text" id="phone" name="phone" class="input_w170 intbox numOnly" value="<?=$row['PHONE']?>" onchange="requestChkInfo()" required label="<?=$titPhone['listTitle']['phone']?>" maxlength="16"></td>
					</tr>				
					<tr>
						<th><?=$titPhone['listTitle']['userid']?></th>
						<td><input type="text" id="userid" name="userid" class="input_w170 intbox" value="<?=$row['USER_ID']?>" onchange="requestChkInfo2()" maxlength="16" required label="<?=$titPhone['listTitle']['userid']?>" ></td>
					</tr>

					<tr>
						<th><?=$titPhone['listTitle']['pw']?></th>
						<td><input type="text" id="pw" name="pw" class="input_w170 intbox" value="" maxlength="16" ></td>
					</tr>

					<tr>
						<th><?=$titPhone['listTitle']['re_pw']?></th>
						<td><input type="text" id="re_pw" name="re_pw" class="input_w170 w70 " value="" maxlength="16"></td>
					</tr>
					<tr>
						<th><?=$titPhone['listTitle']['username']?></th>
						<td><input type="text" id="name" name="name" class="input_w170" value="<?=$row['USERNAME']?>" required label="<?=$titPhone['listTitle']['username']?>" maxlength="32"></td>
					</tr>			

					<tr>
						<th><?=$titPhone['listTitle']['mac']?></th>
						<td><input type="text" id="mac" name="mac" class="input_w170 " value="<?=$row['PNP_MAC']?>" maxlength="32"></td>
					</tr>			
					<tr>
						<th><?=$titPhone['listTitle']['ip']?></th>
						<td><input type="text" id="ipaddr" name="ipaddr" class="input_w170 intbox" value="<?=$row['IPADDR']?>" maxlength="15"></td>
					</tr>

					<tr>
						<th><?=$titPhone['listTitle']['port']?></th>
						<td><input type="text" id="port" name="port" class="input_w70 numOnly" value="<?=$row['PORT']?>" maxlength="5"></td>
					</tr>
					<tr>
						<th><?=$titPhone['listTitle']['expires']?></th>
						<td><input type="text" id="expires" name="expires" class="input_w70 numOnly" value="<?=$row['EXPIRES']?>" maxlength="5"></td>
					</tr>
					<tr>
						<th><?=$titPhone['listTitle']['maxduration']?></th>
						<td><input type="text" id="maxduration" name="maxduration" class="input_w70 w70 numOnly" value="<?=$row['MAXDURATION']?>" maxlength="5"></td>
					</tr>															
					<tr>
						<th><?=$titPhone['listTitle']['cid']?></th>
						<td><input type="text" id="cid" name="cid" class="input_w170 numOnly" value="<?=$row['CID']?>" maxlength="16"></td>
					</tr>	

					<tr>
						<th><?=$titPhone['listTitle']['class']?></th>
						<td><?=$html_class ?> </td>
					</tr>	

					<tr>
						<th><?=$titPhone['listTitle']['pgroup']?></th>
						<td><?=$html_pgroup ?> </td>
					</tr>	

					<tr>
						<th><?=$titPhone['listTitle']['trunk']?></th>
						<td><?=$html_trunk ?> </td>
					</tr>	
					<tr>
						<th><?=$titPhone['listTitle']['rgroup']?></th>
						<td><input type="text" id="rgroup" name="rgroup" class="input_w70 numOnly" value="<?=$row['RGROUP']?>" maxlength="3"></td>
					</tr>	
					<tr>
						<th><?=$titPhone['listTitle']['rec']?></th>
						<td> <input type="checkbox" name="rec" value="1" <? if ($row['REC']=="1") echo "checked" ?>></td>
					</tr>	
				<tbody>
			</table>
			<div class="layer_btn ta_center">
				<? if ($alevel["mod"]=="Y") {?>
					<button id='BtnSubmit' onclick='return false' class="btn_nor btn_point"><?=$tit['btn']['save']?></button>
				<? }?>
				<button onclick="LayerPopup_type2('close');return false" class="btn_nor btn_grey"><?=$tit['btn']['cancle']?></button>
			</div>
		</dd>
	</dl>
	<div class="bottom"></div>
	</form>
</div>