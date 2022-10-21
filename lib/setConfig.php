<?
//PTT_SERVER 개발 (2016/08/) 개발자:경's
//*****************************************************************************
//프로 그램 세션 처리 및 공통 처리
//*****************************************************************************

@header("Cache-Control: no-store, no-cache, must-revalidate"); //캐쉬 비움
ini_set('display_errors', '1'); 
ini_set('error_reporting', E_ALL & ~E_NOTICE); 

include_once dirname(__FILE__) . "/../config/.set.conf.php";

if ($config['useHttps']=="1" && $_SERVER['HTTPS'] != "on") {
	$ssl_url ="https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; 
	echo"<meta http-equiv=\"refresh\" content=\"0; url=$ssl_url\">";
	exit;
}
$_home_dir="/call_server/";                 //사용할 폴더명
$_home_path= getenv('DOCUMENT_ROOT').$_home_dir;
$session_path=$_home_path."/.data_session/";


if(!is_dir($session_path)) {
	mkdir($session_path, 0777);
	chmod($session_path, 0777);
}

### 세션
@session_save_path($session_path);
@session_cache_limiter('nocache, must_revalidate');
@session_start();

//에러메세지 출력여부
//error_reporting(0); 

if(defined("_func_included")) return;
define("_func_included",true);

date_default_timezone_set('Asia/Seoul'); 

//언어 txt include
if($_SESSION["ptt_forder"] ||   $_POST['engkor'] !="") {
	$language = $_SESSION["ptt_forder"];
	if ($language=="") $language=$_POST['engkor'];
	include_once  dirname(__FILE__) . "/../config/".$language."_msg.php";	
} else {
	$language = "eng";	
	include_once  dirname(__FILE__) . "/../config/eng_msg.php";
}

if ($language=="eng") $dateType="d-m-Y H:i:s";
else $dateType="Y-m-d H:i:s";

//$imagesFolder = $_home_dir."/".$language."_images";
$imagesFolder = $_home_dir."/images";

include_once dirname(__FILE__) . "/func.php";
include_once dirname(__FILE__) . "/webSecurity.php";  //웹,DB 공격패턴 감시



$db=db_conn(); //db 접속


$admin_info=admin_info(); //접속자정보


$reg_date=date("Y-m-d H:i:s");

if($_SESSION["user_id"] ) {
			if ($_SESSION['user_level']=="1") {
			   $logout_time= 3600;  //1시간 설정 
			} else {
			   $logout_time= $config['loginTimeGap']; //4시간 설정
			}

			$timeGap= time()-$_SESSION["log_time"];

      	    if($timeGap >$logout_time || trim($_SESSION["log_ip"])!=trim($_SERVER['REMOTE_ADDR'])) {
				regLog($admin_info['user_id'], '8','logout',$admin_info['user_name'].' ['.$admin_info['user_id'].']', "Expired session",'OPER',$reg_date) ;
					//mysqli_query($db,"update PTT_ADMIN set Login_status='0' where no='".$admin_info["no"]."'");


					//=====회원정보 세션종료
					$_SESSION["mno"]="";
					$_SESSION["mname"]="";
					$_SESSION["main_page"]="";
					$_SESSION["user_id"]="";
					$_SESSION["user_level"]="";
					$_SESSION["log_time"]="";
					$_SESSION["log_ip"]="";
					$_SESSION["ptt_forder"]="";
					session_unset(); 
					session_destroy(); 
				echo " <script>
					alert('$msg[session]');  
					top.location.href='".$_home_dir."/index.php' ;
				  </script>	";	
			} else {
				//유효할 경우 로그인 시간을 다시 설정
				$log_time=time();
				$_SESSION["log_time"]=$log_time;
			}
}



## List 페이지 출력수
$aPageNum=array("20"=>"20","50"=>"50","80"=>"80","100"=>"100");

## Photo List 페이지 출력수
$aPhotoPageNum=array("100"=>"100","200"=>"200","300"=>"300","400"=>"400");


//처음 접근시 ajax 변수 초기화
$nowMenu=get_dirname();
$preMenu=$_SESSION['nMenu'];
if ($_SESSION['nMenu'] && ($nowMenu != $_SESSION['nMenu'] && $nowMenu !="outline") ) {
	$_SESSION['nMenu']=$nowMenu;
	$_SESSION['Vars']="";
	setLocking("", 'main');  //Lock 해제
}


/*
//비밀번호 변경 Limit Day
if (strtotime($admin_info["Change_PW_Time"]) > 0) {
	$pwLastDay =  date("Y-m-d H:i:s", strtotime($admin_info["Change_PW_Time"]." $config[pwMonth] month"));
	if ($pwLastDay < $reg_date && $_SESSION['pwChangeChk']!=true) {
		$pwChangeTarget =true;
	} else {
		$pwChangeTarget =false;
	}
}
*/


?>


