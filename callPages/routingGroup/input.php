<? include_once dirname(__FILE__) . "/../../lib/setConfig.php"; 

	$bbs="GPREFIX ";
	$key =$_POST["key"];
	$levelKey =$_POST["levelKey"];
	$alevel=array("view"=>$admin_info[$levelKey.'_view'], "add"=>$admin_info[$levelKey.'_add'], "mod"=>$admin_info[$levelKey.'_mod'], "del"=>$admin_info[$levelKey.'_del']);

  	if ($key) {
		$sql="select * from $bbs where CONCAT(RGROUP,':',PREFIX)='$key'";
		$row=mysqli_fetch_array(mysqli_query($db,$sql));
		$old_key=$row['RGROUP'];
		$old_key2=$row['PREFIX'];
		$mode="mod";
  	} else {
		$exe="insert";
		$row['PORT']="0";
		$row['ROUTING']="1";
		$mode="add";
  	}

	$html_routing=selectbox("routing",$arrRouting,$row['ROUTING'],"" ,"","160");

?>
<script>
	var RegexIp = /^(1|2)?\d?\d([.](1|2)?\d?\d){3}$/;
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
				if ( $.trim($("#rout_ip").val()) !="") {
					if (!RegexIp.test($.trim($("#rout_ip").val())) ) {
						alert("<?=$titPhone['errIp']?>");
						$("#rout_ip").focus();
						return false;
					}
				}
				$('#inputForm').submit();
			}

		});
	})

function requestChkInfo() {
      var old_key = $("#old_key").val();
      var key =  $("#rgroup").val()
      var key2 =  $("#prefix").val()
	  if (old_key != key) {

		$.ajax({
			url : "./chkData_ajax.php",
			data : {"key" : key, "key2" : key2 },
			type: "POST",
			success: function(data){
				data = $.trim(data)
                if (data.length > 2) {
					alert("<?=$msgRouting['dubleGroup']?>");
                    $("#prefix").select()
                    $("#prefix").focus()
                    return false
				} else {
                    $("#rout_ip").focus()
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
<input type=hidden name="old_key2" id='old_key2' value="<?=$old_key2?>"  >

	<dl class="layer_box_wrap on">
		<dt><?=$tit['mainTitle']['rout_group']?><span class="btn_close_container" onclick="LayerPopup_type2('close');return false">닫기</span></dt>
		<dd>
			<table class="bbs_table_vertical" cellpadding="0" cellspacing="0" border="0">
				<colgroup>
					<col width="29%">
					<col >
				</colgroup>
				<tbody >
					<tr>
						<th><?=$titRouting['listTitle']['group']?></th>
						<td><input type="text" id="rgroup" name="rgroup" class="input_w170" value="<?=$row['RGROUP']?>"  required label="<?=$titRouting['listTitle']['group']?>"></td>
					</tr>				
					<tr>
						<th><?=$titRouting['listTitle']['digit']?></th>
						<td><input type="text" id="prefix" name="prefix" class="input_w170 intbox" value="<?=$row['PREFIX']?>" required label="<?=$titRouting['listTitle']['digit']?>" onchange="requestChkInfo()"></td>
					</tr>
					<tr>
						<th><?=$titRouting['listTitle']['rout_ip']?></th>
						<td><input type="text" id="rout_ip" name="rout_ip" class="input_w170" value="<?=$row['ROUTING_IP']?>"></td>
					</tr>
					<tr>
						<th><?=$titRouting['listTitle']['port']?></th>
						<td><input type="text" id="port" name="port" class="input_w70 numOnly" value="<?=$row['PORT']?>"></td>
					</tr>
					<tr>
						<th><?=$titRouting['listTitle']['routing']?></th>
						<td>							
							<?=$html_routing?>
						</td>
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