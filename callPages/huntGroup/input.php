<? include_once dirname(__FILE__) . "/../../lib/setConfig.php";
	$bbs="HUNTGROUP";
	$key =$_POST["key"];
	$levelKey =$_POST["levelKey"];
	$alevel=array("view"=>$admin_info[$levelKey.'_view'], "add"=>$admin_info[$levelKey.'_add'], "mod"=>$admin_info[$levelKey.'_mod'], "del"=>$admin_info[$levelKey.'_del']);
  	if ($key) {
		$sql="select * from $bbs where HGROUP='$key'";
		$row=mysqli_fetch_array(mysqli_query($db,$sql));
		$old_key=$row['HGROUP'];
		$mode="mod";
  	} else {
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
			$(".layer_box_wrap textarea").attr('disabled',true);

		} else {
			$(".layer_box_wrap input[type='text']").removeClass('onlyread')
			$('.layer_box_wrap .onlyread').attr('readonly',false);
			$(".layer_box_wrap textarea").attr('disabled',false);
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

function requestChkInfo() {
      var old_key = $("#old_key").val();
      var key =  $("#hgroup").val()
	  if (old_key != key) {

		$.ajax({
			url : "./chkData_ajax.php",
			data : {"key" : key },
			type: "POST",
			success: function(data){
				data = $.trim(data)
                if (data.length > 2) {
					alert("<?=$titEtc['dubleHgroup'] ?>");
                    $("#hgroup").select()
                    $("#hgroup").focus()
        			return false;

				} else {
                    $("#phone").focus()
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

	<dl class="layer_box_wrap on">
		<dt><?=$tit['mainTitle']['etc_hunt']?><span class="btn_close_container" onclick="LayerPopup_type2('close');return false">닫기</span></dt>
		<dd>
			<table class="bbs_table_vertical" cellpadding="0" cellspacing="0" border="0">
				<colgroup>
					<col width="29%">
					<col >
				</colgroup>
				<tbody >
					<tr>
						<th><?=$titEtc['listTitle']['hGroup']?></th>
						<td><input type="text" id="hgroup" name="hgroup" class="input_w70 intbox numOnly" value="<?=$row['HGROUP']?>" onchange="requestChkInfo()" required label="<?=$titEtc['listTitle']['hgroup']?>" maxlength="3"></td>
					</tr>
					<tr>
						<th><?=$titEtc['listTitle']['hPhone']?></th>
						<td>
							<textarea  style="width:320px;height:90px" id="phone" name="phone" maxlength="195"  required label="<?=$titEtc['listTitle']['hPhone']?>"><?=$row['TELNO']?></textarea></td>
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