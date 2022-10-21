<? 
include_once  dirname(__FILE__) . "/config/.set.conf.php";
include_once  dirname(__FILE__) . "/lib/func.php";
include_once  dirname(__FILE__) . "/config/eng_msg.php";


$dbHost=decrypt($decryptKey,$dbinfo['host']);
$dbUser=decrypt($decryptKey,$dbinfo['user']);
$dbPass=decrypt($decryptKey,$dbinfo['pass']);
$dbName=decrypt($decryptKey,$dbinfo['name']);
$dbs1=mysqli_init();
$conn = @mysqli_real_connect($dbs1,$dbHost ,$dbUser,$dbPass,$dbName,3306,  false ,MYSQLI_CLIENT_SSL) ; 

//if (trim($dbinfo['user'])=="" || trim($dbinfo['pass'])=="") {
if (!$conn || $dbName=="" ) {
if ($_POST['kind']=="setting") {
	
	$dbHost=trim($_POST['host']);
	$dbPort=trim($_POST['port']);
	$dbUser=trim($_POST['user']);
	$dbPass=trim($_POST['pass']);
	$dbName=trim($_POST['name']);



	if ($dbUser!="" && $dbPass!="") {

		    //## DB 접속정보로 접속 확인 

			$db2=mysqli_init();
			if (!$db2)	  {
			  die("mysqli_init failed");
			}
			//mysqli_ssl_set($db,NULL, NULL,$_home_path.'/lib/PHPExcel/.mysql_ssl/mycacert.pem',NULL,NULL); 


			if (!mysqli_real_connect($db2,$dbHost ,$dbUser,$dbPass,$dbName,3306,  false ,MYSQLI_CLIENT_SSL) || $dbName=="")  {
				echo  "<script>
					alert('".encrypt($decryptKey,$dbHost)."/". encrypt($decryptKey,$dbUser)."/". encrypt($decryptKey,$dbPass)." $dbUser Connection lost with SQL database, please check Call server DB connection information')
					</script>";		  
			}  else {


						// Config 파일 수정

				$El	= array(
						"host",			
						"port",		
						"user",		
						"pass",		
						"name"
					//	"name2"    
				);


				$fp = fopen("./config/.set.conf.php","r");
				$buffer=""; 
				while(!feof($fp)) 		{ 
					  $line=fgets($fp,4096); 
					  for ($i=0;$i<count($El);$i++) {
							if (strpos($line, "dbinfo['".$El[$i]."']") > 0 )  { 
								echo $line."<br>";
								$line ="\$dbinfo['".$El[$i]."']=\"".encrypt($decryptKey,$_POST[$El[$i]])."\";".chr(13).chr(10) ;
							} 
					  }
					  $buffer .= $line; //.chr(13).chr(10);  


				} 
				fclose($fp); 

				$fp = fopen("./config/.set.conf.php","w");
				fwrite($fp,$buffer); 
				fclose($fp); 
				echo "<script>
				parent.window.location.href='./index.php'
				</script>";
			}

			regLog($c_user_id, '1','mod',"DB setting", "START",'OPER',$reg_date) ;
		}





} else {

?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta name="title" content="PTT_SERVER">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title>DB Setting |  Group Communications </title>
<meta charset="utf-8">
<meta name="viewport" content="width=1024">
<link rel="stylesheet" href="./css/common.css" />
<script src="./js/jquery-1.9.1.min.js"></script>
<script src="./js/jquery.easing.1.3.js"></script>
<script src="./js/gibberish-aes.js"></script>
<script src="./js/common.js"></script>
<script src="./js/common2.js"></script>
<!--<script src="./js/fakeselect.js"></script>-->
<!--[if lt IE 9]>
 <link rel="stylesheet" href="./css/ie.css" />
 <script src="./js/html5.js"></script>
 <script src="./js/respond.min.js"></script>
  <![endif]-->


	<script>


		$(document).ready(function(){

		 //checkListMotion();
		 fnClickCheck2(".inp" , true);


		});


		function submit_chk() {
				$('#hiddenFrm').submit();
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
		<div id="login_setup">
			<!--<div class="setupBg_top"><img src="./intro_images/setupBg_top.png" alt=""></div>-->
			
			<form name="settingFrm" id="settingFrm" action="./db_setting.php" method="post" onSubmit="return submit_chk()" target="hiddenFrm">
			<input type="hidden" name="kind" value="setting" >
				<div class="setup_cont">
					<h1><img src="./images/login/tit_setup.png" alt=""></h1>
					<dl class="setup_box">
						<dt>DB setting</dt>
						<dd>
							<span>Host</span>
							<p><input type="text" name="host" id="host" maxlength="20" value="localhost" required  label="Host"  tabindex=9 class="inp fnclick"></p>
						</dd>
						<dd>
							<span>Port</span>
							<p><input type="text"  name="port" id="port" maxlength="5" value="3306" required label="Port" tabindex=10 class="inp"></p>
						</dd>
						<dd>
							<span>User</span>
							<p><input type="text"  name="user" id="user" maxlength="30" required label="DB User" tabindex=11 class="inp"></p>
						</dd>
						<dd>
							<span>Password</span>
							<p><input type="password"  name="pass" id="pass" maxlength="50" required label="DB Password" tabindex=12 class="inp"></p>
						</dd>
						<dd>
							<span>Call Server DB</span>
							<p><input type="text"  name="name" id="name" maxlength="20" required label="Database1" tabindex=13 class="inp"></p>
						</dd>
						<!--
						<dd>
							<span>PTT SERVER DB</span>
							<p><input type="text"  name="name2" id="name2" maxlength="20" required label="Database2" tabindex=13 class="inp"></p>
						</dd>						
							-->
					</dl><!--tit_setup-->

					<h2><input type=image src="./intro_images/btn_submit.gif" alt="로그인">
				</div><!--setup_cont-->
			</form>

			<!--<div class="setupBg_bottom"><img src="./intro_images/setupBg_bottom.png" alt=""></div>-->
		</div><!--login_setup-->
	</div><!--login_bg-->

</div><!--wrap-->

</body>

</html>

<? } ?>

<iframe name="hiddenFrm"  id='hiddenFrm' border=0 src='./callPages/outline/blank.php' style="display:inline;width:100%:height:500px"></iframe>


<? } else {

  echo "<script>
		  alert('error')
          location.href='./index.php'
        </script>" ;

}
?>