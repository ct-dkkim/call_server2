<? include_once dirname(__FILE__) . "/../../lib/setConfig.php";
	$gubun =$_POST["gubun"];
	$keyClass =$_POST["keyClass"];
	$key =$_POST["key"];
	$levelKey =$_POST["levelKey"];
	$alevel=array("view"=>$admin_info[$levelKey.'_view'], "add"=>$admin_info[$levelKey.'_add'], "mod"=>$admin_info[$levelKey.'_mod'], "del"=>$admin_info[$levelKey.'_del']);

  	if ($key) {

		if ($gubun=="class") {
			$sql="select * from CLASS where CLASS='$key'";
			$row=mysqli_fetch_array(mysqli_query($db,$sql));
			$old_key=$row['CLASS'];
			$mode="mod";
			$disabled="";

		} else if ($gubun=="use") {
			$sql="select * from USECLASS where CLASS='$keyClass' and USECODE='$key'";
			$row=mysqli_fetch_array(mysqli_query($db,$sql));
			$old_key=$row['USECODE'];
			$mode="mod";
			$disabled="disabled";
		} else if ($gubun=="limit"){
			$sql="select * from LIMITCLASS where CLASS='$keyClass' and LIMITCODE='$key'";
			$row=mysqli_fetch_array(mysqli_query($db,$sql));
			$old_key=$row['LIMITCODE'];
			$mode="mod";
			$disabled="disabled";
		}

	} else {
		if ($gubun!="class") {
			$row['CLASS'] = $keyClass;
			$disabled="disabled";
		}
		$exe="insert";
		$mode="add";
	}



?>
<script>
	var RegexIp = /^(1|2)?\d?\d([.](1|2)?\d?\d){3}$/;
	var levelMod = "<?=$alevel['mod']?>"
	$(document).ready(function(){


		if (levelMod !="Y" && $('#execution').val()=="mod") {
			$(".layer_box_wrap input[type='text']").addClass('onlyread')
			$('.onlyread').attr('readonly',true);

		} else {
			$(".layer_box_wrap input[type='text']").removeClass('onlyread')
			$('.layer_box_wrap .onlyread').attr('readonly',false);
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
				$('#inputForm').submit();
			}

		});
	})

function requestChkInfo(target) {
      var old_key = $("#old_key").val();
      var old_class =  $("#old_class").val()
      var gubun =  $("#gubun").val()
      var key =  $("#"+target).val()
	  if (old_key != key) {

		$.ajax({
			url : "./chkData_ajax.php",
			data : {"gubun" : gubun , "key" : key , "class" : old_class },
			type: "POST",
			success: function(data){
				data = $.trim(data)
                if (data.length > 2) {
                	if (gubun=="class") {
                		alert("<?=$titClass['dubleClass'] ?>");
                	} else if (gubun=="use") {
                		alert("<?=$titClass['dubleUse'] ?>");
                	} else if (gubun=="limit") {
						alert("<?=$titClass['dubleLimit'] ?>");
                	}
					
                    $("#"+target).select()
                    $("#"+target).focus()
        			return false;


				}
			}
		});
	  }
}

</script>
<div class="container_layer" >
<form name="inputForm" id='inputForm' method=post action='./insert.php' target="hiddenFrm">
<input type=hidden name="execution" id='execution' value="<?=trim($mode)?>" >
<input type=hidden name="gubun" id='gubun' value="<?=$gubun?>"  >
<input type=hidden name="old_class" id='old_class' value="<?=$keyClass?>"  >
<input type=hidden name="old_key" id='old_key' value="<?=$old_key?>"  >

	<dl class="layer_box_wrap on">
		<dt><?=$tit['mainTitle']['class']?><span class="btn_close_container" onclick="LayerPopup_type2('close');return false">닫기</span></dt>
		<dd>
			<table class="bbs_table_vertical" cellpadding="0" cellspacing="0" border="0">
				<colgroup>
					<col width="29%">
					<col >
				</colgroup>
				<tbody >
					<tr>
						<th><?=$titClass['listTitle']['class']?></th>
						<td><input type="text" id="class" name="class" class="input_w70 intbox numOnly" value="<?=$row['CLASS']?>" maxlength='3' onchange="requestChkInfo('class')" required label="<?=$titClass['listTitle']['class']?>" <?=$disabled?>></td>
					</tr>
					<? if ($gubun=="class") {?>
						<tr>
							<th><?=$titClass['listTitle']['explan']?></th>
							<td><input type="text" id="explan" name="explan" class="input_w170" value="<?=$row['EXPLAN']?>" maxlength="16" required label="<?=$titClass['listTitle']['explan']?>"></td>
						</tr>
					<? } else if ($gubun=="use") { ?>
						<tr>
							<th><?=$titClass['listTitle']['useCode']?></th>
							<td><input type="text" id="useCode" name="useCode" class="input_w170" value="<?=$row['USECODE']?>" maxlength="12" required label="<?=$titClass['listTitle']['useCode']?>" onchange="requestChkInfo('useCode')"></td>
						</tr>
					<? } else if ($gubun=="limit") { ?>
						<tr>
							<th><?=$titClass['listTitle']['limitCode']?></th>
							<td><input type="text" id="limitCode" name="limitCode" class="input_w170" value="<?=$row['LIMITCODE']?>" maxlength="12" required label="<?=$titClass['listTitle']['limitCode']?>" onchange="requestChkInfo('limitCode')"></td>
						</tr>
					<? } ?>

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