<?
header('Content-Type: text/html; charset=utf-8 ');

// MySQL 데이타 베이스에 접근
/*
function db_conn() {
	  global $dbinfo,$_home_dir,$decryptKey;

	   if (trim($dbinfo['user'])=="" || trim($dbinfo['pass'])=="" ) {
				echo "<script>
					alert('Connection lost with SQL database, please check connection and reload the page')
					top.location.href='$_home_dir/db_setting.php'
					</script>";
	   } else {
			$dbHost=decrypt($decryptKey,$dbinfo['host']);
			$dbUser=decrypt($decryptKey,$dbinfo['user']);
			$dbPass=decrypt($decryptKey,$dbinfo['pass']);
			$dbName=decrypt($decryptKey,$dbinfo['name']);
			$db = @mysqli_connect($dbHost ,$dbUser,$dbPass,$dbName) ;
			if (!$db || $dbName=="") { 
			    $errNo=mysqli_connect_errno(); 
			    if ($errNo=="0" || ( $errNo >= "1042" && $errNo <= "1046")) {
					echo "<script>
						alert('Connection lost with SQL database, please check connection and reload the page')
						top.location.href='$_home_dir/db_setting.php'
						</script>";
			    } else {
					echo "<script>
						alert('Connection lost with SQL database, please check connection and reload the page')
						top.location.href='$_home_dir/index_blank.php'
						</script>";
				}
			}  else {
				@mysqli_query($db,"set names utf8"); 
				return $db;
			}
	   }
}
*/


function db_conn() {
	  global $dbinfo,$_home_dir,$decryptKey,$_home_path;


	   if (trim($dbinfo['user'])=="" || trim($dbinfo['pass'])=="" || trim($dbinfo['name'])=="") {
				echo "<script>
					alert('Connection lost with SQL database, please check connection and reload the page')
					top.location.href='$_home_dir/db_setting.php'
					</script>";
	   } else {
			$dbHost=decrypt($decryptKey,$dbinfo['host']);
			$dbUser=decrypt($decryptKey,$dbinfo['user']);
			$dbPass=decrypt($decryptKey,$dbinfo['pass']);
			$dbName=decrypt($decryptKey,$dbinfo['name']);

			$db=mysqli_init();
			if (!$db)	  {
			  die("mysqli_init failed");
			}
			//mysqli_ssl_set($db,NULL, NULL,$_home_path.'/lib/PHPExcel/.mysql_ssl/mycacert.pem',NULL,NULL); 


			if (!mysqli_real_connect($db,$dbHost ,$dbUser,$dbPass,$dbName,3306,  false ,MYSQLI_CLIENT_SSL) || $dbName=="")  {
			//if (!mysqli_real_connect($db,$dbHost ,$dbUser,$dbPass,$dbName) || $dbName=="")  {
			  //die("Connect Error: " . mysqli_connect_error());

			    $errNo=mysqli_connect_errno(); 
			    if ($errNo=="0" || ( $errNo >= "1042" && $errNo <= "1046")) {
					echo "<script>
						alert('Connection lost with SQL database, please check connection and reload the page')
						top.location.href='$_home_dir/db_setting.php'
						</script>";
			    } else {
					echo "<script>
						alert('Connection lost with SQL database, please check connection and reload the page')
						top.location.href='$_home_dir/index_blank.php'
						</script>";
				}			  
			} else {

				//$res = mysqli_query($db,"SHOW STATUS LIKE 'ssl_cipher'");
				//var_dump(mysqli_fetch_row($res));

				@mysqli_query($db,"set names utf8"); 
				return $db;
			}


	   }
}




### 초를 시간으로 환산
function get_time($seconds){
	
     $h = sprintf("%02d", intval($seconds) / 3600);
     $tmp = $seconds % 3600;
     $m = sprintf("%02d", $tmp / 60);
     $s = sprintf("%02d", $tmp % 60);

    return $h.':'.$m.':'.$s;

}
// 세션변수 생성
function set_session($session_name, $value){
	if (!$_SESSION[$session_name]){
		$_SESSION["$session_name"] = $value;
	}
}

### 예외 처리
function msg($msg,$code=null,$target='')
{
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
	echo "<script>alert('$msg')</script>";
	switch (getType($code)){
		case "null":
			return false;
			exit;
		case "integer":
			if ($code) echo "<script>history.go($code)</script>";
			exit;
		case "string":
			if ($code=="close") echo "<script>window.close()</script>";
			else echo "<script>window.location.href='$code'</script>";
			exit;
	}
}

// 에러 메세지 출력
function Error($message, $url="") {
	global $setup, $connect, $dir, $config_dir;


		$message=str_replace("<br>","\\n",$message);
		$message=str_replace("\"","\\\"",$message);

		if (!$url) {
		?>
		<script>
			alert("<?=$message?>");
		   history.go(-1) ;

		</script>
		<?
		} else {
             echo "
		  <script>
			alert('$message');
		    location.href='$url' ;
		  </script>	";
		}

	if($db) @mysqli_close($db);
	exit;
}

###   페이지 이동 스크립트
function movepage($url) {
	global $db;
	echo"<meta http-equiv=\"refresh\" content=\"0; url=$url\">";
	if($db) @mysqli_close($db);
	exit;
}



### Xss 및 db injection 필터링
function xss_db_filter($content)
{
 //db injection 공격가능 문자 제거
 $content = str_replace('\\','',$content);
// $content = str_replace(':','',$content);
 $content = str_replace(';','',$content);
 //$content = str_replace('&','&amp;',$content);
 $content = str_replace('<','&lt;',$content);
 $content = str_replace('>','&gt;',$content);
// $content = str_replace('/','',$content);
 $content = str_replace('"','',$content);
//$content = str_replace("'","",$content);
 $content = str_replace('+','',$content);


 // 악성 태그들 모두 제거
 $content = preg_replace('/(<)(|\/)(\!|\?|html|head|title|meta|body|script|style|base|noscript|
  form|input|select|option|optgroup|textarea|button|label|fieldset|legend|iframe|embed|object|param|
  frameset|frame|noframes|basefont|applet| isindex|xmp|plaintext|listing|bgsound|marquee|blink|
  noembed|comment|xml)/i', '&lt;$3', $content);
 
 // 스크립트 핸들러를 모두 제거
 $content = preg_replace_callback("/([^a-z])(o)(n)/i", 
  create_function('$matches', 'if($matches[2]=="o") $matches[2] = "&#111;";
  else $matches[2] = "&#79;"; return $matches[1].$matches[2].$matches[3];'), $content);
 
 return $content;
}

###  문자 필터링
function txt_filter($content)
{
 //공격가능 문자 치환
 //$content = str_replace('\\','',$content);
 //$content = str_replace(':','',$content);
 //$content = str_replace(';','',$content);
 $content = str_replace('&','&amp;',$content);
 $content = str_replace('<','&lt;',$content);
 $content = str_replace('>','&gt;',$content);
 //$content = str_replace('/','',$content);
 //$content = str_replace('"','&quot;',$content);
 //$content = str_replace("'","",$content);
// $content = str_replace(',','',$content);
 $content = str_replace('','',$content);
 $content = str_replace('#','&#35',$content);
 //$content = str_replace('--','',$content);
 $content = str_replace('(','&#40',$content);
 $content = str_replace(')','&#41',$content);
 
  //db injection 공격가능 문자 제거
 $content = preg_replace("/(select|union|update|delete|drop|syscolumns|column.name|script|1=1|\"|\'|\/\*|\*\/|\\\|\;)/i","",$content);

 // 악성 태그들 모두 제거
 /*
 $content = preg_replace('/(<)(|\/)(\!|\?|html|head|title|meta|body|script|style|base|noscript|
  form|input|select|option|optgroup|textarea|button|label|fieldset|legend|iframe|embed|object|param|
  frameset|frame|noframes|basefont|applet| isindex|xmp|plaintext|listing|bgsound|marquee|blink|
  noembed|comment|xml)/i', '&lt;$3', $content);
 */


 return $content;
}

###  문자 필터링
function txt_filter_del($content)
{
 //오류 문자 치환
 $content = str_replace('<','',$content);
 $content = str_replace('>','',$content);
 $content = str_replace('"','',$content);
 $content = str_replace("'","",$content); 
 return $content;
}


### GET/POST변수 자동 병합
function getVars($except='', $request='')
{
	if ($except) $exc = explode(",",$except);
	if ( is_array( $request ) == false ) $request = $_REQUEST;
	foreach ($request as $k=>$v){
		if (isset($_COOKIE[$k])) continue; # 쿠키 제외(..sunny)
		if (!@in_array($k,$exc) && $v!=''){
			//if (!is_array($v)) $ret[] = "$k=".urlencode(stripslashes($v));
			if (!is_array($v)) $ret[] = "$k=".txt_filter(stripslashes($v));
			else {
				$tmp = getVarsSub($k,$v);
				if ($tmp) $ret[] = $tmp;
			}
		}
	}
	if ($ret) return implode("&",$ret);
}

function getVarsSub($key,$value)
{
	foreach ($value as $k2=>$v2){
		if ($v2!='') $ret2[] = $key."[".$k2."]=".urlencode(stripslashes($v2));
	}
	if ($ret2) return implode("&",$ret2);
}

function getArrValue($arrVars, $reg) {
	$arr=explode("&",$arrVars);
	for ($i=0;$i<sizeof($arr);$i++) {
	   if ( strpos("aa".$arr[$i],$reg,0)==true) {
			$value=array_pop(explode("=",$arr[$i]));	
			break;
	   }
	}

	return $value;
}


### Log 기록
function regLog($userid, $item,$action,$target, $msg,$kind, $regtime="",$subitem="") {
	global $db,$_SERVER,$admin_info ;
		
	if ($sub_code=="") $sub_code=$admin_info["SUB_CODE"];

	$que  = "insert into PTTLOG set ITEM='$item', SUB_ITEM='$subitem', ACTION='$action',KIND='$kind',TARGET='$target', RESULT='$msg', USERID='$userid', USERIP='".$_SERVER['REMOTE_ADDR']."'";
	if ($regtime) {
		$que.=", REGTIME='$regtime'";
	} else {
		$que.=",REGTIME=now()";
	}
	mysqli_query($db,$que);
}



//폴더생성
function mkdir_recursive($pathname, $mode)
{
    is_dir(dirname($pathname)) || mkdir_recursive(dirname($pathname), $mode);
    return is_dir($pathname) || mkdir($pathname, $mode);
}
function getPercent($num, $total){
	if($total == 0){
		return "0";
	}else{
		return "" . round($num / $total * 100 , 2) . "";
	}
}


function getLineH($total, $num, $height) {
    if ($num==0) {
		$height="1";
	} else {
		$height=round(($num*$height)/$total, 0);
	}

	return $height;
}





function make_setcookie($name, $value, $expire, $path='/')
{
    if (headers_sent()) {
        $cookie = $name.'='.urlencode($value).';';
        if ($expire) $cookie .= ' expires='.gmdate('D, d M Y H:i:s', $expire).' GMT';
        echo '<script language="javascript">document.cookie="'.$cookie.'";</script>';
    } else {
        setcookie($name, $value, $expire, $path);
    }
}




### 다차원배열 search 
function Multi_Array_Search($theNeedle, $theHaystack, $keyToSearch)     { 

	   if (count($theHaystack) > 0) {
			foreach($theHaystack as $theKey => $theValue)  { 
				$intCurrentKey = $theKey;    
					
				if($theValue[$keyToSearch] == $theNeedle)   {     
					return $intCurrentKey ; 
				}  else  { 
					return 0; 
				} 
		   } 
	   } else {
			return 0;
	   }

} 

### 문자열 끊기 (이상의 길이일때는 ... 로 표시)
function cut_str($msg,$cut_size) {
		if($cut_size<=0) return $msg;
		//if(ereg("\[re\]",$msg)) $cut_size=$cut_size+4;
		for($i=0;$i<$cut_size;$i++) if(ord($msg[$i])>127) $han++; else $eng++;
		$cut_size=$cut_size+(int)$han*0.9;
		$point=1;
		for ($i=0;$i<strlen($msg);$i++) {
			if ($point>$cut_size) return $pointtmp."...";
			if (ord($msg[$i])<=127) {
				$pointtmp.= $msg[$i];
				if ($point%$cut_size==0) return $pointtmp."...";
			} else {
				if ($point%$cut_size==0) return $pointtmp."...";
				$pointtmp.=$msg[$i].$msg[++$i];
				$point++;
			}
			$point++;
		}
		return $pointtmp;
}

### 문자열 끊기
function cut_str_not($msg,$cut_size) {
		if($cut_size<=0) return $msg;
		//if(ereg("\[re\]",$msg)) $cut_size=$cut_size+4;
		for($i=0;$i<$cut_size;$i++) if(ord($msg[$i])>127) $han++; else $eng++;
		$cut_size=$cut_size+(int)$han*0.9;
		$point=1;
		for ($i=0;$i<strlen($msg);$i++) {
			if ($point>$cut_size) return $pointtmp;
			if (ord($msg[$i])<=127) {
				$pointtmp.= $msg[$i];
				if ($point%$cut_size==0) return $pointtmp;
			} else {
				if ($point%$cut_size==0) return $pointtmp;
				$pointtmp.=$msg[$i].$msg[++$i];
				$point++;
			}
			$point++;
		}
		return $pointtmp;
}

//#### 파일
  function LoadFromFile($FileName)
  {
    $Lines = "";
    $IncToken = "<!Include";

    $fp = fopen($FileName, "r");
    while (!feof($fp)) {
      $CurrentLine = fgets($fp, 1024);

      // SSI 기능
      if (strncmp($IncToken, $CurrentLine, strlen($IncToken)) == 0) {
        list($stTemp, $IncName) = explode(" ", $CurrentLine);
        $CurrentLine = "";
        $fpInc = fopen($IncName, "r");
        while (!feof($fpInc)) {
          $CurrentLine .= fgets($fpInc, 1024);
        }
        fclose($fpInc);
      }

      $Lines .= $CurrentLine;
    }
    fclose($fp);

    return $Lines;
  }

$deLicensekey = "everytalk23cybertel59"; 



function ch_special( $str ) {
		$str = str_replace( "'", "&#39;", $str );
		$str = str_replace( "\"", "&#34;", $str );
		return $str;
}

//접속자 정보
function admin_info() {
		global $_SESSION ,$db, $decryptKey;
  	   if($_SESSION["mno"]) {
			$member=mysqli_fetch_array(mysqli_query($db,"select *,level as user_level from web_admin  where no ='".$_SESSION["mno"]."'"));
			if(!$member["no"]) {
				unset($member);
				$member["user_level"] = 10;
			}
		} else {
			$member["user_level"] = 10;
		}

		return $member;
}


function permit_admin() {
	global $msg, $_SESSION, $admin_info,$_home_dir, $db, $IpUse;

	if ($_SESSION["user_level"] != "1") {
		echo "
			<script language='javascript'>
             alert('$msg[permit1]')
			history.go(-1)
			</script>";
	} 
}


function permit_value($key="") {
	global $msg, $_SESSION, $admin_info,$_home_dir, $db, $IpUse, $config;

	if (!$admin_info["user_id"]) {
		session_unset(); // 모든 세션변수를 언레지스터 시켜줌
		session_destroy(); // 세션해제함

		echo "
			<script language='javascript'>
				 alert('$msg[permit1]')
				 top.location.href='$_home_dir/index.php'
			</script>";
	} else {
		if ($key!="") {
			if ($admin_info[$key."_view"] !="Y") {
				echo "
					<script language='javascript'>
					 alert('$msg[permit1]')
			         history.go(-1)
			 		</script>";
			} else {
		  	  	$alevel=array("view"=>$admin_info[$key."_view"], "add"=>$admin_info[$key."_add"], "mod"=>$admin_info[$key."_mod"], "del"=>$admin_info[$key."_del"]);
		  	  	return $alevel; 
	  		}
  		}

	}
}





Function PassEncoding( $cPassword ) {
   $i;
   $cValue="";
   $nCount = 1;
   $cPassword=trim($cPassword);
   for($i=0;$i<strlen($cPassword);$i++) {
	   $cVar=ord( SubStr( $cPassword, $i, 1 ) ) ^ $nCount;
       $cValue .= str_pad(DecHex($cVar),2,"0",STR_PAD_LEFT);
	   $nCount = $nCount + 2;
   }
   Return $cValue ;
}


//---------------------------------------------------------------------------//

Function PassDecoding( $cPassword ) {
  $i;
  $cValue = "";
  $cPassword=trim($cPassword);

   for ($i=0;$i<strlen($cPassword);$i=$i+2 ){
	   $nCount= $i + 1 ;
       $cVar=hexdec( SubStr( $cPassword, $i,2 ) ) ^ $nCount;
       $cValue .= chr($cVar) ;
   }
   Return $cValue;
}



//로그인 암호처리
function encrypt ($key, $value)
{                

	if ($key=="") $key ="aeverytalkcybertelstuvwxyz235912";
    $padSize = 16 - (strlen ($value) % 16) ;
    $value = $value . str_repeat (chr ($padSize), $padSize) ;
    //$output = mcrypt_encrypt (MCRYPT_RIJNDAEL_128, $key, $value, MCRYPT_MODE_CBC, str_repeat(chr(0),16)) ;
    
    $output = openssl_encrypt($value, 'AES-128-CBC', $key, OPENSSL_RAW_DATA,  str_repeat(chr(0),16));
    //$output = openssl_encrypt($value, 'des-ede3-cbc', $key, OPENSSL_RAW_DATA,  str_repeat(chr(0),16));

    return base64_encode ($output) ;        
}

function decrypt ($key, $value)        
{            	    
	if ($key=="") $key ="aeverytalkcybertelstuvwxyz235912";


    $value = base64_decode ($value) ;                
    //$output = mcrypt_decrypt (MCRYPT_RIJNDAEL_128, $key, $value, MCRYPT_MODE_CBC, str_repeat(chr(0),16)) ;           
     $output= openssl_decrypt($value, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, str_repeat(chr(0),16));
    // $output= openssl_decrypt($value, 'des-ede3-cbc', $key, OPENSSL_RAW_DATA, str_repeat(chr(0),16));
    
    $valueLen = strlen ($output) ;
    if ( $valueLen % 16 > 0 )
        $output = "";

    $padSize = ord ($output[$valueLen - 1]) ;
    if ( ($padSize < 1) or ($padSize > 16) )
        $output = "";                // Check padding.                

    for ($i = 0; $i < $padSize; $i++)
    {
        if ( ord ($output[$valueLen - $i - 1]) != $padSize )
            $output = "";
    }
    $output = substr ($output, 0, $valueLen - $padSize) ;

    return $output;        
} 


//바로위 폴더이름 알아내기 
function get_dirname() {
 $dir = getcwd(); // 현재 디렉토리명을 반환하는 PHP 함수이다.
 $temp = explode("/", $dir);
 $dirname = array_pop($temp);

 return $dirname;
}



### 락설정
function setLocking($info, $type) {  //info:table^key^value, type:main,sub;
	global $_SESSION, $db;

		if ( $_SESSION['lock']!='' && $_SESSION['lock']!="undefined") {		
			$mLock=explode("^",$_SESSION['lock']); //table^key^value

			//이전에 걸린 Lock 테이블 내정정보 삭제
			if ($type=="main" ) {		
				$aLock=$mLock;
				//이전 LOCK GET

				if (is_array($aLock)) {
					list($lockValue)=mysqli_fetch_array(mysqli_query($db,"select LOCKINFO from $aLock[0] where 
					$aLock[1]='".$aLock[2]."'"));
					$arrLockValue=explode("|",$lockValue);
					$newLockValue="";
					for ($i=0;$i<sizeof($arrLockValue);$i++) {
						if ($arrLockValue[$i]) {
							if ( strpos("xx|".$arrLockValue[$i],"|".$_SESSION['mno']."^",0)==false) {
								$newLockValue.="|".$arrLockValue[$i];
							}
						}
					}
					//이전 LOCK에서 내정보 삭제
					mysqli_query($db,"update $aLock[0] set LOCKINFO='$newLockValue' where $aLock[1]='".$aLock[2]."'");
				}



			}
		}

		//하위 테이블 내정보 삭제
		if ($_SESSION['lock_sub'] !='' && $_SESSION['lock_sub'] !='undefined') {


				$aLock=explode("^",$_SESSION['lock_sub']);

				if($aLock[0]=="PTTPHONE") {
					$where= "PGROUP='".$aLock[3]."' and ";
				}
				if (is_array($aLock)) {
					list($lockValue)=mysqli_fetch_array(mysqli_query($db,"select LOCKINFO from $aLock[0] where 
					$aLock[1]='".$aLock[2]."'"));
					$arrLockValue=explode("|",$lockValue);
					$newLockValue="";
					for ($i=0;$i<sizeof($arrLockValue);$i++) {
						if ($arrLockValue[$i]) {
							if ( strpos("xx|".$arrLockValue[$i],"|".$_SESSION['mno']."^",0)==false) {
								$newLockValue.="|".$arrLockValue[$i];
							}
						}
					}
					mysqli_query($db,"update $aLock[0] set LOCKINFO='$newLockValue' where $where $aLock[1]='".$aLock[2]."'");
				}
		}

	if ($info !="") {
		$arrToLock=explode("^",$info); // table^key^value(락예정정보)

		if($arrToLock[0]=="PTTPHONE" && $arrToLock[3]) {
					$where= "PGROUP='".$arrToLock[3]."' and ";
		}
		//현재 테이이블 Lock 설정
		$lockInfo="|".$_SESSION['mno']."^".$_SESSION['mname']."^".$_SERVER['REMOTE_ADDR']."^".time();

		mysqli_query($db,"update $arrToLock[0] set LOCKINFO=concat( LOCKINFO, '".$lockInfo."' ) where $where $arrToLock[1]='".$arrToLock[2]."'");

		if ($type=="main") {
			$_SESSION['lock']=$info; //현재 lock중인 정보
			$_SESSION['lock_sub']="";
		} else {
			$_SESSION['lock_sub']=$info; 
		}
	}
}


### 락체크 및 get
function getLocking($info,$item,$type="html") {  //info:table^key^value, item:타이틀항목 ,type:array,html(리턴속성)
		global $_SESSION, $db, $config,$_SERVER;
		$html="";
		$aLock =explode("^", $info);
		list($items_name,$lockinfo)=mysqli_fetch_array(mysqli_query($db,"select $item,LOCKINFO from $aLock[0] where $aLock[1]='".$aLock[2]."'"));

		$arrLockValue=explode("|",$lockinfo);
		$newLockValue="";
		for ($i=0;$i<sizeof($arrLockValue);$i++) {
			if ($arrLockValue[$i]) {
				$arrValue=explode("^", $arrLockValue[$i]);
				$time=array_pop($arrValue);
				$useTIme= time()-$time;
				
				if ($config['lockTime'] - $useTIme > 0) {						
					if ($arrValue[0] == $_SESSION['mno']) {
						$newLockValue.="|".$arrValue[0]."^".$arrValue[1]."^".$_SERVER['REMOTE_ADDR']."^".time();
					//다른 사용자 사용중 Data
					} else {
						$newLockValue.="|".$arrLockValue[$i];
						$html.="<tr><td>$arrValue[1] ($arrValue[2])  </td><td>$items_name</td><td>".get_time($useTIme)." </td></tr>";
						$aLockValue[]="$arrValue[1] ($arrValue[2])";

					}
				}
			}
		}
				
		if ($type=="array") {
			return $aLockValue;
		} else {
			//mysqli_query($db,"update $aLock[0]  set LOCKINFO='$newLockValue' where $aLock[1] ='".$aLock[2] ."'");
			return $html;
		}


}





//셀렉트박스 생성
//$aSmsDate=array("SMS_SEND"=>"송신날짜","SMS_RECEIVE"=>"수신날짜","SMS_READ"=>"읽은날짜");
//$html_smsDate=selectbox("fdate",$aSmsDate,$fdate,"","","85");
function selectbox($options_name,$options_array,$option_value,$title,$action='',$width='')  {
   $select_item = '';
   if ($action!='') $action='onChange="'.$action.'"';
   if ($width!='')  $width="style='width:".$width."px'";

   $select_item .= '<SELECT name="' . $options_name . '" id="' . $options_name . '" '.$action.' '.$width.' class="selectClass">';
   if ($title !="") {
         $select_item .=
         '<OPTION VALUE="" >' . $title."</OPTION>";

   }

   if (is_array($options_array) && count($options_array) > 0) {
		foreach ($options_array as $key=>$value) {
			if ($option_value!="" && $key == $option_value ) {
				  $select_item .=  '<OPTION VALUE="' . $key . '" SELECTED>' . $value;

			} else {
				  $select_item .=  '<OPTION VALUE="' . $key . '" >' . $value;
			}

		}
	}
   $select_item .= '</SELECT>';
   return $select_item;
 }

//레디오박스 생성
//$use_radio=radiobox("use_showreply",array("사용안함","사용함"),array("0","1"),$row['use_showreply'] );
 function radiobox($options_name,$options_array,$option_value, $action='')  {
   $select_item = '';
   if ($action!='') $action='onclick="'.$action.'"';
   if ($option_value=="") $option_value=$options_values[0];

	foreach ($options_array as $key=>$value) {
		if ($option_value!="" && $key == $option_value ) {
         	$select_item .= '<input type="radio"  name="'. $options_name .'" VALUE="' . $key. '" '.$action.' checked> <label>' . $value.'</label>' ;
		} else {
         	$select_item .= '<input type="radio"  name="'. $options_name .'" VALUE="' . $key . '" '.$action.'> <label>' . $value.'</label>' ;
        }

	}

   return trim($select_item,"&nbsp;");
 }


//타이존별 시간 return
function timeZone_to_date($targetDate,$timeZone ) {
		global $dateType,$sys_info;
		$now1 = new DateTime($targetDate);

		if ($timeZone=="") $timeZone=$sys_info['timeZone'];
		$now1->setTimezone(new DateTimeZone($timeZone));
		$date = $now1->format($dateType);		
		return $date;			
}

 function UniqueMachineID($salt = "") {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $temp = sys_get_temp_dir().DIRECTORY_SEPARATOR."diskpartscript.txt";
        if(!file_exists($temp) && !is_file($temp)) file_put_contents($temp, "select disk 0\ndetail disk");
        $output = shell_exec("diskpart /s ".$temp);
        $lines = explode("\n",$output);
        $result = array_filter($lines,function($line) {
            return stripos($line,"ID:")!==false;
        });
        if(count($result)>0) {
            $result = array_shift(array_values($result));
            $result = explode(":",$result);
            $result = trim(end($result));       
        } else $result = $output;       
    } else {
        $result = shell_exec("blkid -o value -s UUID");  
        if(stripos($result,"blkid")!==false) {
            $result = $_SERVER['HTTP_HOST'];
        }
    }   
    return md5($salt.md5($result));

 return $result;
}



//로컬시간을 시스템시간으로  변환
function  LocalTimeToSystemTime($time, $localTimeZone) {
		global $sys_info;
		$time = strtotime($time);
		if ($time > 0) {
			include_once dirname(__FILE__) . "/timeZoneClass.php";
			$timezone = timeZone::timezone_list();
			$systemTimeGap = $timezone[$sys_info['timeZone']]['timeGap'];
			$localTimeGap = $timezone[$localTimeZone]['timeGap'];
			$chg_time = $time + ( $systemTimeGap - $localTimeGap) ;
			$return_time=date("H:i",$chg_time);

			return $return_time;
		} else {
			return "";
		}
}


//시스템시간을 로컬시간으로  변환
function  SystemTimeToLocalTime($date, $localTimeZone,$chgDataType) {
		global $sys_info;

		$time = strtotime($date);
		if ($time > 0) {
			include_once dirname(__FILE__) . "/timeZoneClass.php";
			$timezone = timeZone::timezone_list();
			$systemTimeGap = $timezone[$sys_info['timeZone']]['timeGap'];
			$localTimeGap = $timezone[$localTimeZone]['timeGap'];
			$chg_time = $time + ($systemTimeGap - $localTimeGap) ;
			$return_time=date($chgDataType,$chg_time);

			return $return_time;
		} else {
			return "";
		}
}



//date2-date1의 시간차 구하기 
function getDifferTime($date1, $date2){
		$date1= strtotime($date1);
		$date2= strtotime($date2);

		$result = "";

		if ($date1 > 0 && $date2 > 0) {

			$total_time = $date2 - $date1;
								 
			 
			$days = floor($total_time/86400); 
			$time = $total_time - ($days*86400); 
			$hours = floor($time/3600); 
			$time = $time - ($hours*3600); 
			$min = floor($time/60); 
			$sec = $time - ($min*60); 
			 
			if ($days > 0) {
				$result .= $days." days ";
			}

			if ($hours > 0) {
				$result .= $hours." hours ";
			}

			if ($min > 0) {
				$result .= $min." minutes ";
			}

		}
		return $result;

}


function routing_to_str( $value ) {
  if ($value=="1"){
    $routing="SIP Server";
  } else if ($value=="2") {
    $routing="GateKeeper";
  } else if ($value=="3") {
    $routing="IP Phone";
  }
  return $routing;
}
?>