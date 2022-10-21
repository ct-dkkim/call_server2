<? include_once dirname(__FILE__) . "/lib/setConfig.php";


list($cntAdmin)=mysqli_fetch_array(mysqli_query($db,"select count(no) from web_admin where level='1'"));
if ($cntAdmin >= 1) {
  echo "<script>
		  alert('$msg[permit1]')
          location.href='./index.php'
        </script>" ;
}


if ($_POST['kind']=="setting") {
	$bbs="web_admin";
    $time=time();


	$c_user_id = strtolower(str_replace("ㅤ","",$_POST['userID']));
	$c_name =txt_filter(trim($_POST['userName']));
	$password=PassEncoding($_POST['userPW']);


	unset($check);
	$check= array_search($c_user_id,$aNotId);
	if($check > 0) Error("$msgLogin[errId3]","");
	unset($check);
	$check=mysqli_fetch_array(mysqli_query($db,"select no from $bbs where user_id='$c_user_id'"));

	if($check[0]) Error("$msgLogin[errId2]","");
	//if($check[0]) Error("이미 등록되어 있는 ID입니다","");

    if ($c_user_id ) {


   		$query="insert into web_admin (user_id, password, name, level, email, user_view, user_add, user_mod, user_del,  phone_view, phone_add, phone_mod, phone_del, routing_view, routing_add, routing_mod, routing_del,  conversion_view, conversion_add, conversion_mod, conversion_del, class_view, class_add, class_mod, class_del,ptt_view, ptt_add, ptt_mod, ptt_del, reg_date) values ( '$c_user_id', '$password', '$c_name','1', '$email', 'Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','$time')" ;

		if (mysqli_query($db,$query)) {

			regLog($c_user_id, '9','add',$c_user_id, $aLevel[1], 'ENG',$reg_date) ;
		}

	}
	echo "<script>
	alert('ok')
	window.parent.location.href='./index.php'
	</script>";

} else {

?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta name="title" content="PTT_SERVER">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title>LoginPge |  Group Communications </title>
<meta charset="utf-8">
<meta name="viewport" content="width=1024">
<link rel="stylesheet" href="<?=$_home_dir?>/css/common.css" />
<script src="<?=$_home_dir?>/js/jquery-1.9.1.min.js"></script>
<script src="<?=$_home_dir?>/js/jquery.easing.1.3.js"></script>
<script src="<?=$_home_dir?>/js/gibberish-aes.js"></script>
<script src="<?=$_home_dir?>/js/common.js"></script>
<script src="<?=$_home_dir?>/js/common2.js"></script>
<!--<script src="<?=$_home_dir?>/js/fakeselect.js"></script>-->
<!--[if lt IE 9]>
 <link rel="stylesheet" href="<?=$_home_dir?>/css/ie.css" />
 <script src="<?=$_home_dir?>/js/html5.js"></script>
 <script src="<?=$_home_dir?>/js/respond.min.js"></script>
  <![endif]-->


	<script>

			 var RegexName = /[^_\`\~\!\@\#\$\%\^\&\*\(\)\-\=\+\\\{\}\[\]\'\"\;\:\<\,\>\.\?\/]{2,16}$/; //외국어 이름 유효성 검사 2~16자 사이
			 var RegexId = /^[a-z0-9_\`\~\!\@\#\$\%\^\&\*\(\)\-\=\+\\\{\}\[\]\'\"\;\:\<\,\>\.\?\/]{4,16}$/; 
			 var RegexTel = /^[0-9.-]{8,16}$/; //전화번호 유효성 검사
			 var RegexPass	= /^[\S\x21-\x7E]{4,16}$/;  //비번 유효성 검사


			$(document).ready(function(){

			//checkListMotion();
			fnClickCheck2(".inp" , true);

			});


		function submit_chk() {

				if ( !RegexId.test($.trim($("#userID").val())) ) {
					alert("<?=$msgLogin['errId']?>");
					$("#userID").focus();
					return false;
				}

				
				if ( !RegexPass.test($.trim($("#userPW").val())) ) {
					alert("<?=$msgLogin['errPassword2']?>");
					$("#userPW").focus();
					return false;
				} else {
					if (!CheckPassword($.trim($("#userID").val()), $.trim($("#userPW").val()))){
						$("#userPW").focus();
						return false						
					} else {
						if ($('#userPW').val() != $('#re_userPW').val()){				
							   alert("<?=$msgLogin['errPassword3']?>");
							   $('#re_userPW').focus();
							   return false;
						}
					}
				}

				if ( !RegexName.test($.trim($("#userName").val())) ) {
					alert("<?=$msgLogin['errName']?>");
					$("#userName").focus();
					return false;
				}

				$('#settingFrm').submit();
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

</head>


<body style="background-color:#002140">
<dl class="accessibilityWrap">
  <dt class="blind"><strong> 바로가기  메뉴</strong></dt>
  <dd><a href="#container">컨텐츠바로가기</a></dd>   
  <dd><a href="#lnb">주메뉴바로가기</a></dd>
  <dd><a href="#footer">하단메뉴바로가기</a></dd>
</dl>
<div id="wrap">

<div class="super_bg">
	<section id="super_area">
		<form name="settingFrm" id="settingFrm" action="./admin_setting.php" method="post" onSubmit="return submit_chk()" target="hiddenFrm">
		<input type="hidden" name="kind" value="setting" >
		<div class="field">

			<p><input type="text" name="userID" id="userID" maxlength="16" value="" required  label="User Id"  tabindex=1 class="inp fnclick"></p>
			<p class="pw"><input type="password"  name="userPW" id="userPW" maxlength="20" required label="Password" tabindex=2 class="inp"></p>
			<p class="pw2"><input type="password"  name="re_userPW" id="re_userPW" maxlength="20" required label="Password Confirm" tabindex=2 class="inp"></p>
			<p class="name"><input type="text"  name="userName" id="userName" maxlength="20" required label="User Name" tabindex=2 class="inp"></p>
			
			<div class="btn">
				<input type=image src="<?=$_home_dir?>/images/super/super_btn_login.png" alt="로그인">
			</div>


		</div><!-- field -->
		</form>
	</section>
</div>
<iframe name="hiddenFrm"  id='hiddenFrm' border=0 src='./callPages/outline/blank.php' style="display:none;width:100%;height:800px;background:yellow"></iframe>
</div>
</body>
</html>

<? } ?>




