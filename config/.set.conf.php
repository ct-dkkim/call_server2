<?
$dbinfo['host']="Y28ZxFWSk0i5GBL6LKUTaRmI4vVB0H+JQZ30WtxpmVU=";
$dbinfo['port']="3dT6qsyLz+6JjwR/HlrQ4SGuJ27Vq4LSKYqFfhDdwIg=";
$dbinfo['user']="US/CySeHRuLZ98gnLkqRAJAYF+4S0XgXIaCdw1xspvI=";
$dbinfo['pass']="CHBehZAcI2tELCPW1xUXXsgBfqRx87wuN77iUvBb3mZ/TvfexmFBVntaY6y/gc89";
$dbinfo['name']="2R95Hi6fHE4lvhZRsyyof6DvZZysSegKYTdrwXjR/c4=";
$dbinfo['name2']="O8lnqXUfBxTm1uiiyL4cSrCJWoK53dwjeihMRrC6gts=";

$config['useHttps'] = "0" ; 			// SSL 접속 허용 
$config['ptt_server']="0";				//ptt_Server db연동 여부
$config['loginTimeGap']="14400";		//로그인유지시간 (단위:SECOND)
$config['keepMonth']="24";				//LOG 데이타 보존 기간 (단위:MONTH)
/*
$config['lockTime']="1200";				//락유지 유효시간 (접속후 20분 이후 LOCK 불용 처리)(단위:SECOND)
$config['keepMonth']="24";				//PTTBILL,LOG,SMS 데이타 보존 기간 (단위:MONTH)
$config['sleepTime']="3";				//PTTPHONE import->Initialize 시 sleep time설정 (단위:SECOND)
$config['loginTimeGap']="14400";		//로그인유지시간 (단위:SECOND)
$config['pwMonth']="5";					//비밀번호 변경 기간(단위:MONTH)


*/
#### 허용 불가 아이디
$aNotId=array("","abcd","admin", "administrator", "manager", "guest", "test", "scott", "tomcat", "root", "user", "operator", "anonymous", "aaaa","server");

$decryptKey = "aeverytalkcybertelstuvwxyz235912";	

//$arrLanguage=array("eng"=>"English","kor"=>"Korea","jap"=>"Japan");
$arrLanguage=array("eng"=>"English","kor"=>"Korean");

//system 명




$CLKpath ="/PHPExcel/Reader/";
?>
