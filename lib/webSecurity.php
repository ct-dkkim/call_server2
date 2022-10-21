<?
$aVoidPattern=array(
"delete[[:space:]]+from",
"drop[[:space:]]+database",
"drop[[:space:]]+table",
"drop[[:space:]]+column",
"drop[[:space:]]+procedure",
"create[[:space:]]+table",
"update[[:space:]]+.*set",
"insert[[:space:]]+into.*values",
"select[[:space:]]+.*from",
"bulk[[:space:]]+insert",
"union[[:space:]]+select",
"or[[:space:]]+['\"[[:space:]]]*[[:alnum:]]+['\"[[:space:]]]*[[:space:]]*=[[:space:]]*['\"[[:space:]]]*[[:alnum:]]+",
"or[[:space:]]+[[:alnum:]]+[[:space:]]*=[[:space:]]*[[:alnum:]]+",
"and[[:space:]]+['\"[[:space:]]]*[[:alnum:]]+['\"[[:space:]]]*[[:space:]]*=[[:space:]]*['\"[[:space:]]]*[[:alnum:]]+",
"and[[:space:]]+[[:alnum:]]+[[:space:]]*=[[:space:]]*[[:alnum:]]+",
"alter[[:space:]]+table",
"into[[:space:]]+outfile",
"load[[:space:]]+data",
"declare.+varchar.+set",
"<script",
"script[[:space:]]+.?src[[:space:]]*=",
"%3cscript",
"<script",
"javascript:",
"expression[[:space:]]*\(",
"xss:[[:space:]].*\(",
"document\.cookie",
"document\.location",
"document\.write",
"onAbort[[:space:]]*=",
"onBlur[[:space:]]*=",
"onChange[[:space:]]*=",
"onClick[[:space:]]*=",
"onDblClick[[:space:]]*=",
"onDragDrop[[:space:]]*=",
"onError[[:space:]]*=",
"onFocus[[:space:]]*=",
"onKeyDown[[:space:]]*=",
"onKeyPress[[:space:]]*=",
"onKeyUp[[:space:]]*=",
"onLoad[[:space:]]*=",
"onMouseDown[[:space:]]*=",
"onMouseMove[[:space:]]*=",
"onMouseOut[[:space:]]*=",
"onMouseOver[[:space:]]*=",
"onMouseUp[[:space:]]*=",
"onMove[[:space:]]*=",
"onReset[[:space:]]*=",
"onResize[[:space:]]*=",
"onSelect[[:space:]]*=",
"onSubmit[[:space:]]*=",
"onUnload[[:space:]]*=",
"location.href[[:space:]]*=",
"<iframe[[:space:]]*",
"<meta[[:space:]]*",
"\.\./");


function webSecurity_check() {
	global $_CASTLE_POLICY, $_SERVER;
		foreach ($_REQUEST as $key => $value) 	{
				// SQL_INJECTION 탐지, XSS 탐지,  TAG 탐지
			if (preg_match("/[\`\~\!\@\#\$\%\&\*\(\)\=\+\{\}\\\'\\\"\;\:\<\,\>\.\?]|script|iframe|embed|column.name/i",$key) ) {
				webSecurity_error_handler( "Parameter Error", $key, $key);
			} else {
				if (!is_array($value)) {
					if (trim($value) !=""){
						$pattern = webSecurity_detect_sql_injection($value);
						if ($pattern)
							webSecurity_error_handler( $pattern, $key, $value);
					}
				}  else {
					foreach ($value as $k2=>$v2){
						if (trim($v2) !=""){
							$pattern = webSecurity_detect_sql_injection($v2);
							if ($pattern)
								webSecurity_error_handler( $pattern, $k2, $v2);
						}
					}
				}
			}
		}		
}

function webSecurity_detect_sql_injection($string)
{
	global $aVoidPattern;


	$policy['sql_injection_list'] = $aVoidPattern;

		// 정규표현식으로 탐지
	foreach ($policy['sql_injection_list'] as $regexp)
	{
		//$regexp = base64_decode($regexp);
		$regexp = webSecurity_eregi($regexp, $string);
		if ($regexp) {
			return $regexp;
		
		}
	}

	return FALSE;
}



function webSecurity_eregi($regexp, $str)
{

	$regexp = trim($regexp);
	$str = trim($str);

		// 예외사항
	if (!strlen($regexp) || !strlen($str))
		return NULL;

		// 입력값 디코딩
	$str = webSecurity_urldecode($str);
	//$str = webSecurity_htmldecode($str);

		// slashes 덧붙임 제거
	//if (get_magic_quotes_gpc())
	//	$str = stripslashes($str);

		// %00, %0a 문자 제거
	$str = webSecurity_delete_special_characters($str);

	// 정규표현식 체크
	$esc_regexp = str_replace("/", "\/", $regexp);


	/* 서버 설정이 eucKR인 경우 */
	//if (preg_match("/$esc_regexp/", iconv("eucKR", "UTF-8", $str))) 
	//	return $regexp;


	/* 서버 설정이 UTF-8인 경우 */
	if (preg_match("/".$esc_regexp."/i", $str)) 
		return $regexp;

	return NULL;
}


function webSecurity_urldecode($str)
{
	/* HTTP URL Decoding */
	// ULl Decoding  ex., '+' -> ' '
	$str = urldecode($str);	

	// RAW ULl Decoding  ex., "%20"' -> ' '
	$str = rawurldecode($str);	

	return $str;
}


function webSecurity_htmldecode($str){
	/* ASCII Entities Decoding */
	while (preg_match('~&#x([0-9a-f]+);~ei', $str))
		$str = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $str);

		// Hex encoding without semicolons '&#x20' -> ' '
	while (preg_match('~&#x([0-9a-f]+)~ei', $str))
		$str = @preg_replace('~&#x([0-9a-f]+)~ei', 'chr(hexdec("\\1"))', $str);

		// UTF-8 Unicode encoding '&#32;' -> ' '
	while (preg_match('~&#([0-9]+);~e', $str))
		$str = @preg_replace('~&#([0-9]+);~e', 'chr("\\1")', $str);

		// UTF-8 Unicode encoding without semicolons '&#32' -> ' '
	while (preg_match('~&#([0-9]+)~e', $str))
		$str = @preg_replace('~&#([0-9]+)~e', 'chr("\\1")', $str);

	return $str;
}


function webSecurity_delete_special_characters($str){
	while (preg_match('/\x00/', $str))
		$str = @preg_replace('/\x00/', '', $str);

	while (preg_match('/\x0a/', $str))
		$str = @preg_replace('/\x0a/', '', $str);

	return $str;
}

function webSecurity_error_handler($rule, $key, $value){
	global  $_SERVER;
	 $msg="Attack pattern detection ($rule)";
	 $log['simple']  = $_SERVER['REMOTE_ADDR'] . " - [" . date("d/M/Y:H:i:s O") . "] ";
	 $log['simple'] .= $_SERVER['PHP_SELF'] . ": ";
	 $log['simple'] .= $key . " = " . substr($value, 0, 84) . ": ";
	 $log['simple'] .= iconv("UTF-8", "eucKR", $msg . "\n");

		/* 서버 설정이 eucKR인 경우 */
		//$log['simple'] .= iconv("UTF-8", "eucKR", $_SERVER['PHP_SELF'] . ": ");
		//$log['simple'] .= iconv("UTF-8", "eucKR", $key . " = " . substr($value, 0, 64) . ": ");
		//$log['simple'] .= iconv("UTF-8", "eucKR", $msg . "\n");

		webSecurity_logger($log['simple']);
		webSecurity_alert($msg.": ".$key);


}

function webSecurity_logger($msg){
	global $_home_path;
	$msg = str_replace('<','&lt;',$msg);
	$msg = str_replace('>','&gt;',$msg);
	/* 로그 남김 */
	$log['filename'] = $_home_path."/log/" . date("Ymd") . "-attactLog.txt" ;

	if(!is_dir($_home_path."/log")) {
		mkdir($_home_path."/log",0707);
	}

	if (!file_exists($log['filename']))
		$log['openmode'] = "w";
	else
		$log['openmode'] = "a+";

	$fd = fopen($log['filename'], $log['openmode']);
	if ($fd) {
		fwrite($fd, $msg, strlen($msg));
		fclose($fd);
	}

	return;
}

function webSecurity_alert($msg)
{
	global $_SERVER,$_home_dir,$_home_path;

	$page = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];

	

	/*
 	echo "
			<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
			<html>
			<head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
			</head>
			<body bgcolor=\"#FFFFFF\">
				<center> <h1><font color=red>위험 경고!!</font></h1><br>웹 공격패턴이 감지되어 접근이 차단되었습니다. <br><br>특별한 사유 없이 위의 에러가 반복되면 관리자에게 문의하십시오.<br><br>위의 결과는 모두 별도의 로그에 기록됩니다.</center>
			</body>
			</html>";
				alert('위험 경고!! \n 웹 공격패턴이 감지되어 접근이 차단되었습니다. \n 특별한 사유 없이 위의 에러가 반복되면 관리자에게 문의하십시오.\n 위의 결과는 모두 별도의 로그에 기록됩니다.')

*/

     echo "
			<script>
				alert(' Risk Warning\! \\n\\n Web access is blocked because the attack pattern is detected.  \\n If the above error repeatedly\, without special reason\, \\n please contact your administrator\. \\n The above results are both recorded in a separate log')
				top.location.href='".$_home_dir."/action.login.php?kind=logout'
			</script>

	 ";
		exit;

}

/* 보안체크 */
webSecurity_check();
?>