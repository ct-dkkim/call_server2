<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";

 ##로그기록
$pageKey="etc_func";
if (strpos($_SESSION['viewLog'],$pageKey) ===false) {
	regLog($admin_info['user_id'], '8','view',$tit['mainTitle']['etc_func'], '' ,'ENG',$reg_date,'etc_func') ;
	if (!$_SESSION['viewLog']){
		set_session('viewLog',$pageKey.";");
	} else {
		$_SESSION['viewLog']=$_SESSION['viewLog'].$pageKey.";";
	}
}

$levelKey ="ptt";
$memu7 ="nowOn";
$subMenu3_1 ="on";

$vars=$_SESSION['Vars'];
$arrVars=explode("&",$_SESSION['Vars']);
for ($i=0;$i<sizeof($arrVars);$i++) {
	 $arr=explode("=",$arrVars[$i]);
	 ${$arr[0]}=$arr[1];
}

if (!$fLevelKey) {
	  $_SESSION['Vars'] = "fLevelKey=$levelKey";
}


if ($allchk=="1"){
	$allchecked="checked";
} 

$alevel = permit_value($levelKey);



		$sql="select * from FUNCTION_CODE limit 1";
		$result=mysqli_query($db,$sql);
		$row=mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <? include_once dirname(__FILE__) . "/../outline/header.php"; ?>


		<script type="text/javascript">
			  var ajaxObjects = new Array();
			  var pageNum='0';

			$(document).ready(function(){
				$("input[type='text']").addClass('onlyread')
				$('.onlyread').attr('readonly',true);
				$('#BtnCancle').attr('disabled',true);
				$('#BtnSubmit').attr('disabled',true);


				$("input").keydown(function(e) { 
					if (e.keyCode == 13) return false; 
				});

				$("#BtnModify").click(function(e){
					$('.onlyread').attr('readonly',false);

					$("input[type='text']").removeClass('onlyread')
					$('#BtnCancle').attr('disabled',false);
					$('#BtnSubmit').attr('disabled',false);					
					$('#BtnModify').attr('disabled',true);		


					$('#BtnCancle').removeClass('btn_grey');
					$('#BtnSubmit').removeClass('btn_grey');										
					$('#BtnModify').removeClass('btn_point');		

					$('#BtnCancle').addClass('btn_point');
					$('#BtnSubmit').addClass('btn_point');										
					$('#BtnModify').addClass('btn_grey');
					document.fmList['c_box[]'][0].focus()
				});

				$("#BtnCancle").click(function(e){
					$("input[type='text']").addClass('onlyread')
					$('.onlyread').attr('readonly',true);
					$('#BtnCancle').attr('disabled',true);
					$('#BtnSubmit').attr('disabled',true);					
					$('#BtnModify').attr('disabled',false);		


					$('#BtnCancle').removeClass('btn_point');
					$('#BtnSubmit').removeClass('btn_point');										
					$('#BtnModify').removeClass('btn_grey');		

					$('#BtnCancle').addClass('btn_grey');
					$('#BtnSubmit').addClass('btn_grey');										
					$('#BtnModify').addClass('btn_point');						
				});
				//전체 저장하기
				$("#BtnSubmit").click(function(e){
					$('#fmList').submit();
				});
			})


		</script>


</head>
<body>

<? include "../outline/top.php" ?>

<!-- 본문 시작 -->



<div id="container" class="w_custom">
	<!-- 기본형 시작 -->
	<div class="sub_head1 clear ">
		<h2 class="sub_head_title fl"><?=$tit['mainTitle']['etc_func']?></h2>
	</div>

	<form name="fmList" id='fmList' method="post"  method=post action='./insert.php' target="hiddenFrm">
	<input type=hidden name="fLevelKey" id='fLevelKey' value="<?=$levelKey?>">     <!--접근 레벨 키 -->	




	
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px">
        <tr>
          <td>

          	<table width="100%" border="0" cellspacing="0" cellpadding="0" >
              <tr>
                <td bgcolor="#D7D7D7" ></td>
                   <td align="center" bgcolor="#D7D7D7" style="padding:30px 0 30px 0 ; border-radius:9px;">
							
					<table width="969" border="0" cellspacing="0" cellpadding="0"  >
                       <tr>
                         <td>
					  <table width="975" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="center">
							  <table width="975" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td colspan=3 ><!-- FUNCTION CODE--> </td>
                                </tr>
                                <tr>
                                  <td height="7" colspan="3"></td>
                                </tr>
                                <tr>
                                  <td></td>
								   <td>
								   <table width="100%" class="table_func">
                                    <tr>
									  <td rowspan=4 width=30% bgcolor="#C6C6C6" align=center>
									  <div > 
									  착신전환
									  </div>
									  </td>
									  <td width=15% bgcolor="#D4D4D4">
									  착신전환
									  </td>
									  <td width=15% bgcolor="#D4D4D4"> 항상</td>
									  <td bgcolor="#E3E3E3" height="30"><input type=text name="c_box[]" class="input_w170" maxlength=3  value="<?=$row['CFAS']?>"></td>
									</tr>
                                    <tr>
									  <td  bgcolor="#D4D4D4"> 통화중</td>
									  <td  bgcolor="#D4D4D4"> 설정</td>
									  <td bgcolor="#E3E3E3"><input type=text name="c_box[]" class="input_w170" maxlength=3  value="<?=$row['CFBS']?>"></td>
									</tr>
                                    <tr>
									  <td  bgcolor="#D4D4D4">무응답시</td>
									  <td  bgcolor="#D4D4D4">설정</td>
									  <td bgcolor="#E3E3E3"><input type=text name="c_box[]" class="input_w170" maxlength=3  value="<?=$row['CFNS']?>"></td>
									</tr>
                                    <tr>
									  <td bgcolor="#D4D4D4" colspan=2>해제</td>
									  <td bgcolor="#E3E3E3"><input type=text name="c_box[]" class="input_w170" maxlength=3  value="<?=$row['CFR']?>"></td>
									</tr>
                                    <tr>
									  <td rowspan=2  bgcolor="#C6C6C6" align=center><div > 당겨받기</div></td>
									  <td bgcolor="#D4D4D4" colspan=2>직접</td>
									  <td bgcolor="#E3E3E3"><input type=text name="c_box[]" class="input_w170" maxlength=3  value="<?=$row['CPD']?>"></td>
									</tr>
                                    <tr>
									  <td bgcolor="#D4D4D4" colspan=2>그룹</td>
									  <td bgcolor="#E3E3E3"><input type=text name="c_box[]" class="input_w170" maxlength=3  value="<?=$row['CPG']?>"></td>
									</tr>
                                    <tr>
									  <td rowspan=2 bgcolor="#C6C6C6" align=center><div >통화거부</div></td>
									  <td bgcolor="#D4D4D4" colspan=2>설정</td>
									  <td bgcolor="#E3E3E3"><input type=text name="c_box[]" class="input_w170" maxlength=3  value="<?=$row['DNDS']?>"></td>
									</tr>
                                    <tr>
									  <td bgcolor="#D4D4D4" colspan=2>해제</td>
									  <td bgcolor="#E3E3E3"><input type=text name="c_box[]" class="input_w170" maxlength=3  value="<?=$row['DNDR']?>"></td>
									</tr>

                                   </table>
								  </td>
                                  <td></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table>
						</td>
                      </tr>
                     </table>
				 </td>
                <td bgcolor="#D7D7D7"></td>
              </tr>
            </table>
        </td>
    </tr>
</table>
			
			<!--
                      <tr>
                          <td style="padding:11px" align=right height=30>

									<input type=button value=""  style="width:60;height:20;border:0;background-color:#FFFFFF;background-image:url('../images/main_modify.jpg')"  id="img_mod" <?=$btn_mod?> style="cursor:hand;">

									<input type=button value=""  style="width:60;height:20;border:0;background-color:#FFFFFF;background-image:url('../images/save_r.jpg')" id="img_save"  onclick="save_action()" style="cursor:hand;">

									<input type=reset value=""  style="width:60;height:20;border:0;background-color:#FFFFFF;background-image:url('../images/cancel_r.jpg')" id="img_cancle"  onclick="cancle_action()" style="cursor:hand;">								  



						  </td>
                      </tr>-->			


	</form>
	<div class="bbs_footer clear">
		<div class="paginate" id='divPage'>
		</div>
		<div class="bbs_btn ta_right fr">
			<? if ($alevel['add']=="Y") { ?>
				<button onclick="return false" id="BtnModify" class="btn_nor btn_point"><?=$tit['btn']['modify']?></button>
				<button onclick="return false" id="BtnSubmit" class="btn_nor btn_grey"><?=$tit['btn']['save']?></button>

				<button onclick="return false" id="BtnCancle" class="btn_nor btn_grey"><?=$tit['btn']['cancle']?></button>
			<? }?>
		</div>
	</div>
</div>
<!-- INPUT 레이어 시작 -->
<div class=" popup_layer " id='divDataView'>
</div>
<!-- 고객인증관리 레이어 끝 -->
<!-- 본문 끝 -->




<? include "../outline/footer.php" ?>
