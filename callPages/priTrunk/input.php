<? include_once dirname(__FILE__) . "/../../lib/setConfig.php";
	$bbs="PRITG";
	$key =$_POST["key"];
	$levelKey =$_POST["levelKey"];
	$alevel=array("view"=>$admin_info[$levelKey.'_view'], "add"=>$admin_info[$levelKey.'_add'], "mod"=>$admin_info[$levelKey.'_mod'], "del"=>$admin_info[$levelKey.'_del']);
	

  	if ($key) {
		$sql="select * from $bbs where IPADDR='$key'";
		$row=mysqli_fetch_array(mysqli_query($db,$sql));
		$old_key=$row['IPADDR'];
		$mode="mod";
  	} else {
		$exe="insert";
		$mode="add";
		$row['CID_NO_TYPE'] = "1";
		$row['BILL_NO_TYPE'] = "1";
  	}

$html_cidType=selectbox("cidType",$arrCidType,$row['CID_NO_TYPE'],"" ,"","170");
$html_billType=selectbox("billType",$arrBillType,$row['BILL_NO_TYPE'],"" ,"","170");

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
				if (!RegexIp.test($.trim($("#ipaddr").val())) ) {
					alert("<?=$titPhone['errIp']?>");
					$("#ipaddr").focus();
					return false;
				}

				$('#inputForm').submit();
			}

		});
	})

	function requestChkInfo() {
	      var old_key = $("#old_key").val();
	      var key =  $("#ipaddr").val()
		  if (old_key != key) {

			$.ajax({
				url : "./chkData_ajax.php",
				data : {"key" : key },
				type: "POST",
				success: function(data){
					data = $.trim(data)
	                if (data.length > 2) {
						alert("<?=$titPritg['dubleIP']?>");
	                    $("#ipaddr").select()
	                    $("#ipaddr").focus()
	        			return false;
					} else {
	                    $("#port").focus()
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
		<dt><?=$tit['mainTitle']['pri']?><span class="btn_close_container" onclick="LayerPopup_type2('close');return false">닫기</span></dt>
		<dd>
			<table class="bbs_table_vertical2" cellpadding="0" cellspacing="0" border="0">
				<colgroup>
					<col width="29%">
					<col >
				</colgroup>



				<tbody >
					<tr>
						<th><?=$titPritg['listTitle']['ipaddr']?></th>
						<td><input type="text" id="ipaddr" name="ipaddr" class="input_w170 intbox" value="<?=$row['IPADDR']?>" onchange="requestChkInfo()" required label="<?=$titPritg['listTitle']['ipaddr']?>" maxlength="15"></td>
					</tr>

					<tr>
						<th><?=$titPritg['listTitle']['port']?></th>
						<td><input type="text" id="port" name="port" class="input_w70 numOnly" value="<?=$row['PORT']?>" maxlength="4"></td>
					</tr>
					<tr>
						<th><?=$titPritg['listTitle']['name']?></th>
						<td><input type="text" id="name" name="name" class="input_w170" value="<?=$row['USER_NAME']?>" required label="<?=$titPritg['listTitle']['name']?>" maxlength="32"></td>
					</tr>					
					<tr>
						<th><?=$titPritg['listTitle']['extNo']?></th>
						<td><input type="text" id="extNo" name="extNo" class="input_w170 numOnly" value="<?=$row['START_STN']?>" maxlength="11"></td>
					</tr>			
					<tr>
						<th><?=$titPritg['listTitle']['trkNo']?></th>
						<td><input type="text" id="trkNo" name="trkNo" class="input_w170 numOnly" value="<?=$row['START_TRK']?>" maxlength="11"></td>
					</tr>	

					<tr>
						<th><?=$titPritg['listTitle']['range']?></th>
						<td><input type="text" id="range" name="range" class="input_w170 numOnly" value="<?=$row['P_RANGE']?>" maxlength="4"></td>
					</tr>													
					<tr>
						<th><?=$titPritg['listTitle']['cidNum']?></th>
						<td><input type="text" id="cidNum" name="cidNum" class="input_w170 numOnly" value="<?=$row['CID_NO']?>" maxlength="11"></td>
					</tr>	
					<tr>
						<th><?=$titPritg['listTitle']['cidType']?></th>
						<td><?=$html_cidType?></td>
					</tr>	
					<tr>
						<th><?=$titPritg['listTitle']['billNum']?></th>
						<td><input type="text" id="billNum" name="billNum" class="input_w170 numOnly" value="<?=$row['BILL_NO']?>" maxlength="11"></td>
					</tr>	
					<tr>
						<th><?=$titPritg['listTitle']['billType']?></th>
						<td><?=$html_billType?></td>
					</tr>	
					<tr>
						<th><?=$titPritg['listTitle']['rec']?></th>
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