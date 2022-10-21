<?
include_once dirname(__FILE__) . "/lib/setConfig.php";

($_POST["kind"])? $kind=$_POST["kind"] : $kind=$_GET["kind"] ;
 $reg_date=date("Y-m-d H:i:s");

if($kind == "login") {
				$engkor=$_POST["engkor"];			
				$xid = trim($_POST["xid"]);
				$xpw = trim($_POST["xpw"]);
				if ($config['useSecurity']=="1") {
					//암호해독
					$id=decrypt($decryptKey,$xid);
					$pw=decrypt($decryptKey,$xpw);
				} else {
					$id=$xid;
					$pw=$xpw;
				}




				$pw=PassEncoding($pw);


				//=====유저정보찾기
				$query=sprintf("select * from web_admin where binary(user_id)='%s' and password='%s' ",
						mysqli_real_escape_string($db,$id),
						mysqli_real_escape_string($db,$pw));

				$result23=mysqli_query($db,$query);
				$row = mysqli_fetch_array($result23);

				if(!$row['user_id']){

					echo "
					<script language='javascript'>
						alert('$msg[errLogin1]');
					</script>";
				} else {
					$log_ip = trim($_SERVER['REMOTE_ADDR']);		
					$log_time = time();
					if ($_SESSION["log_time"] < 1) $login_time =  $row['Login_Time'];
					else $login_time =  $_SESSION["log_time"];
					$loginTimeGap = $log_time - $login_time ;



					 //###중복 로그인 체크
					 //로그인상태, 로그인아이피다름, 로그이시간 24간 이내 => 중복로그인 처리
					/*
					 if ($row['Login_status']=="1" && $row['Login_IP'] != $log_ip && $loginTimeGap < $config['loginTimeGap']) {
							echo "
							<script language='javascript'>
								alert('$msg[errLogin2]');
							</script>";
							exit;

					 }
					 */


					  $mno=$row['no'];
					  $user_id = $row['user_id'];
					  $mname = $row['name'];
					  $level = $row['level'];
					  $log_time = time();
					  
				
					  set_session('mno', $mno);
					  set_session('user_id', $user_id);
					  set_session('mname', $mname);
					  set_session('user_level', $level);
					  set_session('log_time', $log_time);
					  set_session('log_ip', $log_ip);

					  if (strtotime($row['Login_System_Time']) < 0) {
							$addSql=", Login_System_Time='$reg_date'";
					  }
					  mysqli_query($db,"update web_admin set v_date='$log_time', visited=visited+1  where no='$row[no]'");


					  ##로그기록

					  regLog($user_id, '9','login',$mname, "IP:".$log_ip ,'OPER',$reg_date,'') ;

					  if ($engkor !="") {
						   $ptt_forder=$engkor;
					  } else {
						   $ptt_forder="eng";
					  }

					  make_setcookie("cook_engkor",$ptt_forder, time()+60*60*24*365,"/");


					  $url="./callPages/session/list.php";

					  set_session('ptt_forder', $ptt_forder);
						echo "
							<script language='javascript'>
							parent.document.location.href='$url'
							</script>";
			}
	  } elseif ($kind=="logout") {


		    if ($_SESSION["mno"]) {
				    ##로그기록
					regLog($admin_info['user_id'], '9','logout',$_SESSION['mname'], "",'OPER',$reg_date) ;

					/*

				   mysqli_query($db,"update PTT_ADMIN set Login_status='0' where no='".$_SESSION["mno"]."'");
				   mysqli_query($db,"update IP_APPROACH set Access_Status='0'  where Access_IP='".$_SESSION['log_ip']."' and Access_Login_User='".$admin_info['user_id']."'");
				   */

					//=====회원정보 세션종료
					$_SESSION["mno"]="";
					$_SESSION["mname"]="";
					$_SESSION["user_id"]="";
					$_SESSION["user_level"]="";
					$_SESSION["log_time"]="";
					$_SESSION["log_ip"]="";
					$_SESSION["ptt_forder"]="";
					session_unset(); 
					session_destroy(); 

					 echo "
							<script language='javascript'>
								document.location.href='".$_home_dir."/index.php';
							</script>";
			 }

	  }



?>

