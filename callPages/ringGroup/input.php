<? include_once dirname(__FILE__) . "/../../lib/setConfig.php"; 

	$bbs="RING_GROUP";
	$key =$_POST["key"];
	$levelKey =$_POST["levelKey"];
	$alevel=array("view"=>$admin_info[$levelKey.'_view'], "add"=>$admin_info[$levelKey.'_add'], "mod"=>$admin_info[$levelKey.'_mod'], "del"=>$admin_info[$levelKey.'_del']);





  	if ($key) {
		$sql="select * from $bbs where RCODE='$key'";
		$row=mysqli_fetch_array(mysqli_query($db,$sql));
		$old_key=$row['RCODE'];
		$mode="mod";
		$addQuery =" or a.RCODE='$old_key'" ; 
  	} else {
		$exe="insert";
		$row['RTYPE']="1";
		$mode="add";
  	}


	$query="select a.RCODE, a.TNAME from TRUNK_NUMBER a left join RING_GROUP b on a.RCODE=b.RCODE where (b.RCODE is NULL and a.RCODE !='') $addQuery  order by a.RCODE";
	$rs=mysqli_query($db,$query);
	$arrRcode["add"] = "추가 등록" ; 
	while ($temp=mysqli_fetch_array($rs)) {
		$arrRcode[$temp['RCODE']] = $temp['RCODE'] ."-". $temp['TNAME'] ;
	}
	if ($row['RCODE'] > "199") {
		$rcodeValue="add";
		$rcode2 =$row['RCODE'];
		$rcodeValue2 ="Code : ". $row['RCODE'] ; 
	} else {
		$rcodeValue=$row['RCODE'];
		$rcode2 = "";
		$rcodeValue2 ="" ; 

	} 
	$html_rCode=selectbox("rcode",$arrRcode,$rcodeValue,$msg['doselect']  ,"selRcode()","170");


	if (trim($row['PNUMBERS']) !="") $row['PNUMBERS']= $row['PNUMBERS'].",";
	$html_rtype=radiobox("rtype",$arrRtype,$row['RTYPE'], "makeMacList()"); 
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
			$(".layer_box_wrap textarea").attr('disabled',true);
			$(".layer_box_wrap input[type='radio']").attr('disabled',true);

		} else {
			if ($('#execution').val()=="mod") {
				$('.layer_box_wrap .selectClass').addClass('onlyread')
				$('.layer_box_wrap .selectClass').attr('disabled',true);		
			} else {
				$('.layer_box_wrap .selectClass').removeClass('onlyread')			
				$('.layer_box_wrap .selectClass').attr('disabled',false);						
			}
			$(".layer_box_wrap input[type='text']").removeClass('onlyread')
			$('.layer_box_wrap .onlyread').attr('readonly',false);
			$(".layer_box_wrap textarea").attr('disabled',false);
			$(".layer_box_wrap input[type='radio']").attr('disabled',false);
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
		makeMacList()

		//전체 저장하기

		$("#BtnSubmit").click(function(e){
			// var chkLevel = $(':radio[name="c_level"]:checked').val();

			var f=document.inputForm;

			if ($("#rcode").val()=="") {
				alert("<?=$msg['errInputValue']?>")
				$("#rcode").focus()
				return false
			}

			if ( $("#addMacList").val() == "") {
				alert("<?=$msg['ErrPhone1']?>")
				$("#pnp_mac").focus()
				return false				
			}
			if (chkForm(f)){


				$('#inputForm').submit();
			}

		});


		//mac add
		$("#BtnMacAdd").click(function(e){
			var addMacList =$("#addMacList").val()
			var delMacList =$("#delMacList").val()
			var mac=$.trim($("#pnp_mac").val())
			if (levelMod !="Y") {
				alert("<?=$msg['permit2']?>")
			} else {

				if (mac =="") {
					$("#pnp_mac").focus()
					alert("<?=$msg['ErrPhone1']?>")
					return false
				} else {
						var listValue =","+addMacList
						if (listValue.indexOf(","+mac+",") != -1) {
						   alert("<?=$msg['ErrPhone4']?>");

						} else {
						   delMacList = delMacList.replace(mac+",", "");
						   addMacList += mac+",";
						   $("#addMacList").val(addMacList)
						   $("#delMacList").val(delMacList)
						   makeMacList()
						   $("#pnp_mac").val("")
						}		

				}
			}
		});

		//mac delete
		$("#BtnMacDelete").click(function(e){
			   var chkList= $("#chkvalue1").val()
			var addMacList =$("#addMacList").val()
			var delMacList =$("#delMacList").val()
			var arrChkList=chkList.split(",")

			if (levelMod !="Y") {
				alert("<?=$msg['permit2']?>")
			} else {


			 	if ( chkList !='') {

					for (i = 0; i < arrChkList.length; i++) {
						var mac = $.trim(arrChkList[i]) 
						if ( mac != "") {
							addMacList = addMacList.replace(mac+",", "");
							if (delMacList.indexOf(mac) < 0) {
							   delMacList += mac+",";
							}							
						}
					}
					$("#addMacList").val(addMacList)
					$("#delMacList").val(delMacList)
					$("#chkvalue1").val('')
					makeMacList()	
				} else {
			  		alert("<?=$msg['delSelected']?>")

				}	
			}			 
		});			  

	})


	function selRcode() {
		var rcode = $("#rcode").val()
		$("#rcode1").val(rcode)
		if (rcode=="add") {
			$.ajax({
				url : "./chkData_ajax.php",
				data : {"key" : rcode },
				type: "POST",
				success: function(data){
					data = $.trim(data)
					if (data == "err") {
						alert("더 이상 추가 등록 하실 수 없습니다.")
					} else {
						$("#rcode2").val(data)
						$("#rcode_add").html( "Code : " +data)
				    }

				}
			});
		} else {
			$("#rcode2").val("")
			$("#rcode_add").html("")
	
		}
	}
/*
function requestChkInfo() {
      var old_key = $("#old_key").val();
      var key =  $("#prefix").val()
	  if (old_key != key) {

		$.ajax({
			url : "./chkData_ajax.php",
			data : {"key" : key },
			type: "POST",
			success: function(data){
				data = $.trim(data)
                if (data.length > 2) {
					alert("<?=$msgRouting['dublePrefix']?>");
                    $("#prefix").select()
                    $("#prefix").focus()
        			return false;

				} else {
                    $("#ipaddr").focus()
				}
			}
		});
	  }
}
*/



			function makeMacList() {
			  	var addMacList =$("#addMacList").val()
			  	var arrList=addMacList.split(",")
			  	var result=""
			  	var css=""
				for (i = 0; i < arrList.length; i++) {
					if ($.trim(arrList[i]) != "") {

						if (i==0 &&  $('input:radio[name="rtype"]:checked').val() =="1" ) css=" class='fc_red'"
						else css="";

						result += "<tr ><td><input type='checkbox' name='chk1[]' value='"+arrList[i]+"' onclick='selchk9(this,1)' ></td><td " +  css +">"+arrList[i]+"</td></tr>";
					}
				}
				$('input[name="all1"]').prop("checked",false)

				$("#divList1").html(result)

			}

			function macReset() {
				$("#pnp_mac").val("")
			}


			function selectall9(id) {
			    var total =0;
				var element=$('input:checkbox[name="chk'+id+'[]"]')
				var allChk=$('input[name="all'+id+'"]').is(":checked")
			    var chkvalue=""
				for( var i=0; i<element.length; i++) {  
					 if (allChk==true){ //전체선택
						 if (element[i].disabled==false){
							 total++;
							 element[i].checked	= true;
							
							 chkvalue += "," +element[i].value

						 }
					  } else {
						 element[i].checked	= false;
					  }
				}
				$("#chkvalue"+id).val(chkvalue)

				if (allChk==true){
					 $('input[name="allchk'+id+'"]').val('1')
				} else {
					 $('input[name="allchk'+id+'"]').val('0')
				}

			}
			function selchk9( obj,id) {
			    var total =0;
				var element=$('input:checkbox[name="chk'+id+'[]"]')
			    var chkvalue=""
			    var RoIPchk=0
			    var phoneType =""

				for( var i=0; i<element.length; i++) {  
					 if (element[i].checked	== true){ 			 
						 chkvalue += "," +element[i].value
					 }
				}
				$("#chkvalue"+id).val(chkvalue)

			}
</script>
<div class="container_layer" >
<form name="inputForm" id='inputForm' method=post action='./insert.php' target="hiddenFrm">
<input type=hidden name="execution" id='execution' value="<?=trim($mode)?>" >
<input type=hidden name="old_key" id='old_key' value="<?=$old_key?>"  >
<input type="hidden" name="rcode1" id="rcode1" value="<?=$rcodeValue?>" >
<input type="hidden" name="rcode2" id="rcode2" value="<?=$rcode2?>" >
<input type="hidden" name="delMacList" id="delMacList" value="" class="w230">
<input type="hidden" name="addMacList" id="addMacList" value="<?=$row['PNUMBERS']?>"  class="w230">
	<dl class="layer_box_wrap on">
		<dt><?=$tit['mainTitle']['etc_groupRring']?><span class="btn_close_container" onclick="LayerPopup_type2('close');return false">닫기</span></dt>
		<dd>
			<table class="bbs_table_vertical" cellpadding="0" cellspacing="0" border="0">
				<colgroup>
					<col width="29%">
					<col >
				</colgroup>
				<tbody >
					<tr>
						<th><?=$titEtc['listTitle']['rGroup']?></th>
						<td><?=$html_rCode?>   <span id="rcode_add" class="rcodeStyle"><?=$rcodeValue2?></span></td>
					</tr>

					<tr>
						<th><?=$titEtc['listTitle']['rName']?></th>
						<td><input type="text" id="name" name="name" class="input_w170" value="<?=$row['RNAME']?>"  maxlength="18"></td>
					</tr>	
					<tr>
						<th><?=$titEtc['listTitle']['rType']?></th>
						<td>							
							<?=$html_rtype?>
						</td>
					</tr>
					<tr ><th colspan="2"> 전화번호 리스트  등록</th></tr>

					<tr>
						<td colspan="2" >
							
								
							<div class="setupMacBox" >
								<div class="box1">
									<table >
										<colgroup>
											<col>					
										</colgroup>
										<tbody>
											<tr>
												<th scope="row"><?=$titEtc['listTitle']['phone']?></th>					
											</tr>
							
											<tr>
												<td>
													<input type="text" name="pnp_mac" id='pnp_mac'  value="" maxlength="16" class="inp_txt numOnly" style="width:128px" >

													<button id='BtnReset' onclick='macReset();return false' class='modShow'><img  src="../../images/btn/bg_arr2.gif" height=18 alt=""/></button>
												</td>
											</tr>

										</tbody>
									</table>
								</div>


								<div  class="box2">
									
									<p>
										<button id="BtnMacAdd" onClick="return false" class="btn_arrows on"></button>
									</p>
									<p>
										<button id="BtnMacDelete" onClick="return false" class="btn_arrows del"></button>	
									</p>		
											
								</div>



								<div class="mlist_table">
									<input type=hidden name="allchk1" id='allchk1' value='' >
									<input type=hidden name="chkvalue1" id="chkvalue1" value="" >
									<table>
										<colgroup>
											<col width="10%">
											<col>
										</colgroup>
										<thead>
											<tr>
												<th><INPUT type='checkbox' name='all1' id='all1' value='1' onclick="selectall9('1')"  > </th>
												<th><?=$titEtc['listTitle']['phone']?></th>
											</tr>
										</thead>
										<tbody  id='divList1'>
										</tbody>
									</table>
								</div>							
							</div>



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