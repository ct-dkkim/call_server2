<dl class="accessibilityWrap">
  <dt class="blind"><strong> 바로가기  메뉴</strong></dt>
  <dd><a href="#container">컨텐츠바로가기</a></dd>   
  <dd><a href="#lnb">주메뉴바로가기</a></dd>
  <dd><a href="#gnb">회원메뉴바로가기</a></dd>
</dl>

<script type="text/javascript">
(function($){
  var ajaxObjects = new Array();

	$(document).ready(function(){
		$('#lnb>ul>li').each(function(){
           	$(".nowOn").addClass('on');

            $(this).mouseenter(function(){
                var _index = $(this).index();
				//$('#lnb>ul').find("li:not('.nowOn')").removeClass('on');
				$('#lnb>ul>li').removeClass('on');
				$(this).addClass('on');
            });
            
            $(this).mouseleave(function(){
				$(this).removeClass('on');
				$(".nowOn").addClass('on');
            	//$(".nowOn").css('z-index',77);
            	/*
                var _index = $(this).index();
				$(this).removeClass('on');
				if ($('#header #lnb').attr("class") == "lnb_03") {
					$('#lnb .hd_lnb03').addClass('on');
				} else if ($('#header #lnb').attr("class") == "lnb_06") {
					$('#lnb .hd_lnb06').addClass('on');
				}  else if ($('#header #lnb').attr("class") == "lnb_07") {
					$('#lnb .hd_lnb07').addClass('on');
				} else {
					$('#lnb>ul>li').removeClass('on');
				}
				*/
            });
            
        });

	});


})(jQuery);


function logout() {
	 if (confirm('<?=$msg['logout']?>'))   {
		location.href='../../action.login.php?kind=logout'
	 }
}


//#####VIEW GET  
function myInfo() {
	var ajaxIndex = ajaxObjects.length;
	ajaxObjects[ajaxIndex] = new sack();
	ajaxObjects[ajaxIndex].method = "POST";
	ajaxObjects[ajaxIndex].requestFile = "../loginSetup/myInfo.php";	
	ajaxObjects[ajaxIndex].onCompletion = function() { myInfoComplete(ajaxIndex); } ;
	ajaxObjects[ajaxIndex].runAJAX();	
}		
			

function myInfoComplete(index)		{
	var result=ajaxObjects[index].response
	$("#divDataView").html(result)

	LayerPopup_type2('#divDataView',400)
}

</script>
<div id="wrap">
	<div id="header">
		<div class="w_custom">
			<h1><a href="#"><img src="../../images/logo.png" alt="CALL BRIDGE SERVER"/></a></h1>
			<ul id="gnb">
				<li><a href='javascript:logout()'>Logout</a></li>
				<? if ($_SESSION["user_level"] <="2") { ?>				
					<li><a href="../loginSetup/list.php">Administrator</a></li>
				<? }?>
				<? if ($_SESSION["mno"] > 0) {	?>
				<li class="last"><a href="javascript:myInfo()">Modify</a></li>
				<? }?>
			</ul><!-- #gnb -->
			<a href="../session/list.php" class="btn_call"><?=$tit['mainTitle']['session']?></a>
		</div><!-- .w_custom -->
		<div id="lnb">
			<ul class="lnb_wrap">
				<li class="hd_lnb01 lnb_step01 first <?=$memu1?>"><a href="../phone/list.php"><?=$tit['mainTitle']['phone']?><span class="arrow"></span><span class="shadow"></span></a>
					<div class="lnb_layer_wrap">
					</div>
				</li>
				<li class="hd_lnb02 lnb_step01 <?=$memu2?>"><a href="../routingDigit/list.php"><?=$tit['mainTitle']['routing']?><span class="arrow"></span><span class="shadow"></span></a>
					<div class="lnb_layer_wrap">
						<ul class="w_custom">
							<li class="first"><a href="../routingDigit/list.php" class="<?=$subMenu1_1?>"><?=$tit['mainTitle']['rout_prefix']?></a></li>
							<li><a href="../routingIP/list.php" class="<?=$subMenu1_2?>"><?=$tit['mainTitle']['rout_ip']?></a></li>
							<li class="last"><a href="../routingGroup/list.php" class="<?=$subMenu1_3?>"><?=$tit['mainTitle']['rout_group']?></a></li>
						</ul>					
					</div>
				</li>
				<li class="hd_lnb03 lnb_step01 <?=$memu3?>"><a href="../digitConv/list.php"><?=$tit['mainTitle']['digit']?><span class="arrow"></span><span class="shadow"></span></a>
					<div class="lnb_layer_wrap">
						<ul class="w_custom">
							<li class="first"><a href="../digitConv/list.php" class="<?=$subMenu2_1?>"><?=$tit['mainTitle']['digit']?></a></li>
							<li class="last"><a href="../digitGroup/list.php" class="<?=$subMenu2_2?>"><?=$tit['mainTitle']['digit_group']?></a></li>
						</ul>	
					</div>
				</li>
				<li class="hd_lnb04 lnb_step01 <?=$memu4?>"><a href="../priTrunk/list.php"><?=$tit['mainTitle']['pri']?><span class="arrow"></span><span class="shadow"></span></a>
					<div class="lnb_layer_wrap">
					</div>
				</li>
				<li class="hd_lnb05 lnb_step01 <?=$memu5?>"><a href="../class/class.php"><?=$tit['mainTitle']['class']?><span class="arrow"></span><span class="shadow"></span></a>
					<div class="lnb_layer_wrap">
					</div>
				</li>
				<li class="hd_lnb06 lnb_step01 <?=$memu6?>"><a href="#"><?=$tit['mainTitle']['history']?><span class="arrow"></span><span class="shadow"></span></a>

					<div class="lnb_layer_wrap">
						<ul class="w_custom">
							<li class="first"><a href="../history/list.php" class="<?=$subMenu4_1?>"><?=$tit['mainTitle']['history_call']?></a></li>
							<li class="last"><a href="../logList/list.php" class="<?=$subMenu4_2?>"><?=$tit['mainTitle']['history_oper']?></a></li>
						</ul>	
					</div>
				</li>
				<li class="hd_lnb07 lnb_step01 last <?=$memu7?>"><a href="#"><?=$tit['mainTitle']['etc']?><span class="arrow"></span><span class="shadow"></span></a>
					<div class="lnb_layer_wrap">
						<ul class="w_custom">
							<li class="first"><a href="../func_code/write.php" class="<?=$subMenu3_1?>"><?=$tit['mainTitle']['etc_func']?></a></li>
							<li><a href="../pickupGroup/list.php" class="<?=$subMenu3_2?>"><?=$tit['mainTitle']['etc_cpgroup']?></a></li>
							<li><a href="../trunkNumber/list.php" class="<?=$subMenu3_3?>"><?=$tit['mainTitle']['etc_trunk']?></a></li>
							<li ><a href="../ringGroup/list.php" class="<?=$subMenu3_4?>"><?=$tit['mainTitle']['etc_groupRring']?></a></li>
							<li class="last"><a href="../huntGroup/list.php" class="<?=$subMenu3_5?>"><?=$tit['mainTitle']['etc_hunt']?></a></li>
						</ul>
					</div>
				</li>
			</ul>
		</div><!-- #lnb -->
	</div><!-- #header -->
	<div id="contents_wrap">