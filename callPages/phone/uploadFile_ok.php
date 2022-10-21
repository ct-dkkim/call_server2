<?
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
	$reg_date=date("Y-m-d H:i:s");
	$levelKey = $_POST['levelKey'];  //접근 레벨키 
	$dbinfo['name2']=decrypt($decryptKey,$dbinfo['name2']);

	$alevel=array("view"=>$admin_info[$levelKey.'_view'], "add"=>$admin_info[$levelKey.'_add'], "mod"=>$admin_info[$levelKey.'_mod'], "del"=>$admin_info[$levelKey.'_del']);

	if ($alevel['del']!="Y" && $alevel['add']!="Y" && $alevel['mod']!="Y") {
		Error($msg['permit'],"../outline/blank.php");
	}

    $attachRoot =  "./files";
				// 디렉토리를 검사함
	if(!is_dir($attachRoot)) {
		mkdir($attachRoot,0777);
	}
	@chmod($attachRoot,0777);

	if($_FILES[attach]) {
		$attach = $_FILES[attach][tmp_name];
		$attach_name = $_FILES[attach][name];
		$attach_size = $_FILES[attach][size];
		$attach_type = $_FILES[attach][type];
	}


    //확장자 검사
	$temp=explode(".",$attach_name);
	$s_point=count($temp)-1;
	$upload_check=$temp[$s_point];
	$newNum=time();
	$count=0;
	$add_count=0;
	$mod_count=0;
	$exe='0';
	$totalCnt=0; 
if ($upload_check=="xls" ){

	// 파일 사이즈를 구한다.
    if ($attach_name) $fileSize = filesize($attach);

	if ($fileSize > 10097152) {
		msg("This file is too large size");
		exit;
	}
	//첨부파일 등록1
	if ($attach_name && $fileSize > 0) {

		$same_file_exist = file_exists("$attachRoot/$attach_name");
		if($same_file_exist) {
			$fileName = substr($attach_name, 0, strpos($attach_name,".")) . "_" . $newNum . strchr($attach_name, ".");
		}else{
			$fileName = $attach_name;
		}
		$fileName=iconv( "UTF-8","EUC-KR",$fileName);
/*
		//파일명 검증
		$aFileName = explode("_",$attach_name);
		//첫구분자가 0이 아닐경우
		if (substr($attach_name,0,13) !="AdminUserList" ) {
			Error($msgLogin['errFileName1'],"../outline/blank.php");
		}
*/

		copy($attach,"$attachRoot/$fileName");
		@chmod("$attachRoot/$fileName",0777);

		if (file_exists("$attachRoot/$fileName")) {

			
            //####POST 변수 처리
		    $set_type=trim($_POST["set_type"]); //add, modify, insert

				
			include_once dirname(__FILE__) . "/../../lib/ExcelReader.php";

			$filename = "$attachRoot/$fileName";
			$data = new Spreadsheet_Excel_Reader();
			//$data->setOutputEncoding('CP949'); 
			$data->setOutputEncoding('UTF-8');
			$data->read($filename);
			$errCnt=0;

		    //####초기화 선택시(기존 삭제 및 이벤트 등록)
		    if ($set_type=="insert"){
			    $sql="select PHONE,USER_ID from REGISTER  ";
			    $result=mysqli_query($db,$sql);
			    while ($row=mysqli_fetch_array($result)) {
					if (mysqli_query($db,"delete from REGISTER where PHONE='$row[PHONE]'")) {
					    mysqli_query($db,"insert into EVENT_REGISTER (O_PHONE, X_ACTION) values ('$row[PHONE]', 'D')")	;

						 if ($config['ptt_server'] == "1") {
							$sql= "delete from ".$dbinfo['name2'].".REGISTER  where PHONE='$row[PHONE]'" ;
							if (mysqli_query($db,$sql)) {
								mysqli_query($db,"insert into ".$dbinfo['name2'].".EVENT_REGISTER ( O_PHONE, X_ACTION) values ('$row[PHONE]','D')")	;
							};
						 }
					    
						regLog($admin_info['user_id'], '2','del',"[".$tit['mainTitle']['phone']."] Phone - ".$row[PHONE] , "File Import(".$tit["upload"]["initialize"].")",'ENG',$reg_date,'') ;

					}

			    }
			}


			for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {


					$phone=trim($data->sheets[0]['cells'][$i][1]); //phone		
					$phone=str_replace("-","",$phone);
					$id=trim($data->sheets[0]['cells'][$i][2]); //id
					$id=addslashes($id);
					$pw=trim($data->sheets[0]['cells'][$i][3]);             //비번
					if ($pw!="") $en_pw=PassEncoding(addslashes($pw));
					$pw=addslashes($pw);
					$name=trim($data->sheets[0]['cells'][$i][4]);   //사용자명
					$name=addslashes($name);
					$mac=trim($data->sheets[0]['cells'][$i][5]); 
					$ip=trim($data->sheets[0]['cells'][$i][6]); 
					$port=trim($data->sheets[0]['cells'][$i][7]); 
					$expires=trim($data->sheets[0]['cells'][$i][8]); 
					$maxDur=trim($data->sheets[0]['cells'][$i][9]); 
					$cid=trim($data->sheets[0]['cells'][$i][10]); 
					$class=trim($data->sheets[0]['cells'][$i][11]); 
					$pgroup=trim($data->sheets[0]['cells'][$i][12]); 
					$trunk=trim($data->sheets[0]['cells'][$i][13]); 
					$rgroup=trim($data->sheets[0]['cells'][$i][14]); 
					$rec=trim($data->sheets[0]['cells'][$i][15]); 

					if ($rec=="Y")  $rec="1";
					else $rec="0";

					


					if(is_numeric($phone)==true) {
						$totalCnt++;
						//전화번호  에러
						if ( $phone !="" && !preg_match("/^[0-9]{4,16}$/",$phone) ) {
								$errCnt++;
								$log.= $errCnt.". ".$phone." : Phone Error<br>";
								regLog($admin_info[user_id], '10',$set_type,"[".$tit['mainTitle']['phone']."] Phone - ".$phone,"error: Phone Error",'ENG',$reg_date,'') ;

								continue;
						} 



						if (!preg_match("/^[a-z0-9_\`\~\!\@\#\$\%\^\&\*\(\)\-\=\+\\\{\}\[\]\;\:\,\.\?\/]{4,16}$/",$id)) {
							$errCnt++;
							$log.= $errCnt.". ".$phone." :  [$id] ".$msgLogin['errId']."<br>";
							regLog($admin_info[user_id], '10',$set_type,"[".$tit['mainTitle']['phone']."] Phone - ".$phone,"error:[$id]".$msgLogin['errId'],'ENG',$reg_date,'') ;

							continue;
						}
					   

						//비밀번호 에러
						if (!preg_match("/^[\S\x21-\x7E]{4,16}$/",$pw)) {
								$errCnt++;
								$log.= $errCnt.". ".$phone." :[$pw] Password Error<br>";
								regLog($admin_info[user_id], '10',$set_type,"[".$tit['mainTitle']['phone']."] Phone - ".$phone,"error:[$pw]  Password Error",'ENG',$reg_date,'') ;

								continue;
						} 

						//이름  에러
						if (!preg_match("/[^\`\~\!\@\#\$\%\^\&\*\(\)\=\+\\\{\}\[\]\'\"\;\:\<\,\>\.\?\/]{2,16}$/",$name)) {
								$errCnt++;
								$log.= $errCnt.". ".$phone." : [$name] Name Error<br>";
								regLog($admin_info[user_id], '10',$set_type,"[".$tit['mainTitle']['phone']."] Phone - ".$phone,"error:[$name] Name Error",'ENG',$reg_date,'') ;

								continue;
						} 

						//ip 에러 
						if ($ip!="" && !preg_match("/^(1|2)?\d?\d([.](1|2)?\d?\d){3}$/",$ip)) {
								$errCnt++;
								$log.= $errCnt.". ".$phone." : [$ip] ".$titPhone['errIp']." <br>";
								regLog($admin_info[user_id], '10',$set_type,"[".$tit['mainTitle']['phone']."] Phone - ".$phone,"error:[$ip] ".$titPhone['errIp'],'ENG',$reg_date,'') ;

								continue;
						} 


							//Divice 중복 유무
						unset($duk);
						if (trim($mac)!="") {
							$sql="select count(PHONE) as cnt from REGISTER where PHONE!='".trim($phone)."' and PNP_MAC='$mac'";
							list($duk)=mysqli_fetch_array(mysqli_query($db,$sql));
							if ($duk > 0 ) {
								$errCnt++;
								$log.= $errCnt." . ".$phone." :[$mac] ".$titPhone['errMac']."<br>";
								regLog($admin_info[user_id], '10',$set_type,"[".$tit['mainTitle']['phone']."] Phone - ".$phone,"error:[$mac]".$titPhone['errMac'],'ENG',$reg_date,'') ;
								continue;
							}

						}
						$mainSql="
						PHONE='$phone',
						IPADDR='$ip',
						PORT='$port',						
						MAXDURATION='$maxDur',
						CID='$cid' ,
						USER_ID='$id', 
						USERNAME='$name',  
						PNP_MAC='$mac',
						CLASS='$class' ,
						TNUMBER='$trunk', 
						RGROUP ='$rgroup' ,
						PGROUP ='$pgroup' ,
						REC='$rec'
						";

						$phoneSql="
						PHONE='$phone',
						IPADDR='$ip',
						PORT='$port',
						EXPIRES='$expires',
						MAXDURATION='$maxDur',
						CID='$cid' ,
						USER_ID='$id', 
						USERNAME='$name',  
						PNP_MAC='$mac',
						D_NO='0',
						PRIORITY='9',
						REG_TIME='$reg_time'
						";




						//I중복 유무
						unset($duk);
						$sql="select count(PHONE) as cnt from REGISTER where PHONE='$phone'";
						list($duk)=mysqli_fetch_array(mysqli_query($db,$sql));
						if ($duk > 0) {
							if ($set_type=="modify"){ //중복시 수정 처리

								$query= "update REGISTER set $mainSql,EXPIRES='$expires',PASSWORD='$en_pw'  where PHONE='$phone'";
								if (mysqli_query($db,$query)){
									mysqli_query($db,"insert EVENT_REGISTER  set O_PHONE='$phone', $mainSql, PASSWORD='$pw', X_ACTION='U'")	;	
									$aModPhone[] = $phone;
									$count++;

									if ($config['ptt_server'] == "1") {
										$sql= "update ".$dbinfo['name2'].".REGISTER  set $phoneSql ,PASSWORD='$en_pw' where PHONE='$phone'" ;
										if (mysqli_query($db,$sql)) {
											mysqli_query($db,"insert ".$dbinfo['name2'].".EVENT_REGISTER  set O_PHONE='$phone', $phoneSql ,PASSWORD='$pw' , X_ACTION='U'" )	;
										};
									}


									regLog($admin_info[user_id], '10',$set_type,"[".$tit['mainTitle']['phone']."] Phone - ".$phone,"Update",'ENG',$reg_date,'') ;

								}

							} else if ($set_type=="new") {
								$errCnt++;
								$log.= $errCnt.". ".$phone." : ".$titPhone['dublePhone']."<br>";
								regLog($admin_info[user_id], '10',$set_type,"[".$tit['mainTitle']['phone']."] Phone - ".$phone,"error: ".$titPhone['dublePhone'],'ENG',$reg_date,'') ;
							}

						} else {

								$query="insert REGISTER set  $mainSql,EXPIRES='$expires', PASSWORD='$en_pw'" ;

								if (mysqli_query($db,$query)){
									mysqli_query($db,"insert EVENT_REGISTER  set $mainSql, PASSWORD='$pw', X_ACTION='I'");

									$aAddPhone[] = $phone;
									$count++;

									if ($config['ptt_server'] == "1") {
										$sql= "insert ".$dbinfo['name2'].".REGISTER  set $phoneSql ,PASSWORD='$en_pw' " ;

										if (mysqli_query($db,$sql)) {
											mysqli_query($db,"insert ".$dbinfo['name2'].".EVENT_REGISTER  set $phoneSql ,PASSWORD='$pw' , X_ACTION='I'" )	;
										};
									 }

									regLog($admin_info[user_id], '10',$set_type,"[".$tit['mainTitle']['phone']."] Phone - ".$phone,"Add",'ENG',$reg_date,'') ;


								} else {
									$errCnt++;
									$log.= $errCnt.". ".$phone." : ".$msg['errIndb']."<br>";
								}
						} 
						
					} else {
						if (strpos("aa".$phone, "Phone") == false && trim($phone) !="") {
							$totalCnt++;
							$errCnt++;
							$log.= $errCnt." . ".$phone." : Phone Number Error<br>";
						}
					}

			} //for


	 } //exsist
	}
	//mysqli_close();
     unlink(dirname(__FILE__)."/files/$fileName");
     $getTime=time() - $stime;
     $showTime =get_time($getTime);   //업로들 시간 체크 



	if ($set_type=="modify"){ 
		$cnt=$count." (Add:".count($aAddPhone).", Modify:".count($aModPhone).")";
	} else {
		$cnt=$count;
	}

	$result= "<li><h3>* ".$titResult['result']['success']." </h3></li>";
	if (count($aAddPhone) > 0) {
		$result.="- New Add : ".implode(", ", $aAddPhone)."<br>";
	}
	if (count($aModPhone) > 0) {
		$result.="- Update :".implode(", ", $aModPhone)."";
	}
		
	$result.="</li><br><br>";
	//다른사용자(Lock) 관련 Error

	if ($errCnt > 0) {
			 $result.="<li><h3>* ".$titResult['result']['error']."</h3></li>";
			 $result.=$log;
	}


	include_once dirname(__FILE__) . "/../outline/header.php";
	
	$headTitle=$tit['mainTitle']['phone'] ." ".$titPhone['uploadTitle'];	

	echo("<script>
		$('#popAtionTitle',parent.document).html('$headTitle');
		$('#popAtion_totalCnt',parent.document).html('$totalCnt');
		$('#popAtion_okCnt',parent.document).html('$cnt');
		$('#popAtion_errCnt',parent.document).html('$errCnt');
		$('#popAtion_result',parent.document).html('$result');
		$('#upfile_end',parent.document).show();
		$('#upfile_input',parent.document).hide();
		</script>
		");
	


} else {

	echo "
	    <script>
		 // alert('txt, xls, csv 파일만 업로드 가능합니다. ')
		alert('".$msg[upFile]."' )

		</script>
	";

}
?>

