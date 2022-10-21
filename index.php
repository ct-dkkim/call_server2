
<? include_once dirname(__FILE__) . "/lib/setConfig.php";


list($cntAdmin)=mysqli_fetch_array(mysqli_query($db,"select count(no) from web_admin where level='1'"));
if ($cntAdmin < 1) {
  echo "<script>
          location.href='./admin_setting.php'
        </script>" ;
}

//로그인된 상태시 처리
if($admin_info["user_id"]){
    $main_page=$admin_info["main_page"];
	if ($main_page=="") $main_page="phone";
	echo "
		<script language='javascript'>
		location.href='./callPages/digitConv/list.php'
		</script>";
}


?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta name="title" content="PTT_SERVER">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title>LoginPage |  Group Communications </title>
<meta charset="utf-8">
<meta name="viewport" content="width=1024">
<link rel="stylesheet" href="<?=$_home_dir?>/css/common.css" /><!-- 추후 경로 변경하고 사용 -->

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
			$(document).ready(function(){

			//checkListMotion();
			fnClickCheck2(".inp" , true);

			});


		function submit_chk() {
			var f=document.loginform;
			var useSecurity="<?=$config['useSecurity']?>" //보안접속 사용유무
			if (chkForm(f)){
				
				if (useSecurity=="1")	{
					f.xid.value=AES_Encode(f.userID.value);
					f.xpw.value=AES_Encode(f.userPW.value);
				} else {			
					f.xid.value=f.userID.value;
					f.xpw.value=f.userPW.value;
				}

				f.userID.value="";
				f.userPW.value="";
				f.submit();
			}
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

<div class="login_bg">
	<section id="login_area">
		<form name="loginform" action="./action.login.php" method="post" onSubmit="return submit_chk()" target="hiddenFrm">
		<input type="hidden" name="kind" value="login" >
		<input type="hidden" name="xid" value="" />
		<input type="hidden" name="xpw" value="" />
		<div class="field">

			<p><input type="text" name="userID" id="userID" maxlength="16" value="" required  label="USER ID"  tabindex=1 class="inp fnclick"></p>
			<p class="pw"><input type="password"  name="userPW" id="userPW" maxlength="20" required label="PASSWORD" tabindex=2 class="inp" ></p>


			<!-- 언어선택-->
			<div class="lang_check">
				 <span>&nbsp;Language </span>
				 <p>
					<select name="engkor" id="engkor">
					<? foreach ($arrLanguage as $key=>$value) {
							if ($_COOKIE["cook_engkor"] == $key) $sel="selected";
							else $sel="";
							echo "<option value='$key' $sel>&nbsp;&nbsp;$value </option >";
						}
					?>
					</select>
				 </p>
			</div>
			<div class="btn">
				<input type=image src="./images/login/btn_login.jpg" alt="로그인"><!-- 추후 경로 변경하고 사용 -->
			</div>


		</div><!-- field -->
		</form>
	</section>
</div>
<iframe name="hiddenFrm"  id='hiddenFrm' border=0 src='./callPages/outline/blank.php' style="display:none;width:100%;height:800px;background:yellow"></iframe>
</div>

</body>
</html>






