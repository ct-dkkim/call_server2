<?
########### 공통  ##########################
$msg['permit1']="접속권한이 없습니다.";									//접속권한이 없습니다.
$msg['permit2']="실행권한이 없습니다.";									//실행권한이 없습니다.
$msg['logout']="로그아웃하시겠습니까?";									//로그아웃하시겠습니까?
$msg['exeOk'] ="명령 실행";										//명령 실행
$msg['errLogin1']="일치하는 아이디/비밀번호 정보가 없습니다.";	//일치하는 아이디/비밀번호 정보가 없습니다.
$msg['errLogin2']="해당 아이디는 이미 로그인 중 입니다";				//해당 아이디는 이미 로그인 중 입니다
$msg['ErrNumber'] = "숫자 범위가 유효하지 않습니다.";			//숫자 범위가 유효하지 않습니다.
$msg['session']="세션 연결이 종료됩니다.";					//세션 연결이 종료됩니다.
$msg['errcharacter']="특수문자는 입력하실 수 없습니다.";						//특수문자는 입력하실 수 없습니다.
$msg['errNoData'] ="실행할 데이타가 없습니다." ;					//실행할 데이타가 없습니다.
$msg['delSelected'] ="삭제할 데이타를 선택해주세요;" ;			//삭제할 데이타를 선택해주세요;
$msg['delResult'] ="실행결과 \\n삭제건수 : " ;				//총 $cnt 건을  삭제하였습니다.
$msg['delete']="선택한 내용을 삭제하시겠습니까?";						//선택한 내용을 삭제하시겠습니까?
$msg['onlyNum']="숫자만 입력가능 합니다.";							//숫자만 입력가능 합니다.
$msg['upFile']="txt, xls, csv 파일만 업로드 가능합니다. ";				//txt, xls, csv 파일만 업로드 가능합니다. 
$msg['upFileOk']="실행결과 \\n 등록건수  ";						//등록완료( 몇건)
$msg['selFile']="업로드할 파일을 선택해 주세요";				//업로드할 파일을 선택해 주세요
$msg['downFile']="다운로드를 진행합니다.";								//다운로드를 진행합니다.
$msg['unit']="건";
$msg['errInputValue'] ="해당 값을 입력해 주세요" ;						//해당 값을 입력해 주세요
$msg['clickNew']="New 버튼을 클릭해 주세요"  ;						// New 버튼을 클릭해 주세요
$msg['errPassword1'] ="패스워드를 입력해주세요" ;					//패스워드를 입력해주세요
$msg['errPassword2'] ="비밀번호는 4~16자의 유효한 문자로 입력해주세요" ;//비밀번호는 4~20자의 유효한 문자로 입력해주세요
$msg['errPassword3'] ="비밀번호가 일치하지 않습니다. 확인해주세요" ;//비밀번호가 일치하지 않습니다. 확인해주세요
$msg['insIndb'] ="실행결과 \\n 등록건수 : " ;			//정상적으로 등록되었습니다.;
$msg['errIndb'] ="DB 등록시 에러가 발생하였습니다." ;			//DB 등록시 에러가 발생하였습니다.
$msg['errUpdb'] ="DB 수정시 에러가 발생하였습니다." ;				//DB 수정시 에러가 발생하였습니다.
$msg['errDeldb'] ="DB 삭제시 에러가 발생하였습니다." ;				//DB 수정시 에러가 발생하였습니다.
$msg['ErrPhone1'] = "UE 번호를 입력해주세요";						//폰번호를 입력해주세요
$msg['ErrPhone2'] ="이미 등록되어 있는 UE 번호입니다" ;					 //이미 등록되어 있는 PHONE 번호입니다
$msg['ErrPhone3'] = "등록되지 않은 UE 번호 입니다.";				//등록되지 않은 phone Number 입니다.
$msg['ErrPhone4'] ="중복된 UE 번호가 존재합니다." ;			//중복된 PHONE 번호가 존재합니다.
$msg['allchk']="전체";											//전체선택
$msg['doselect'] ="선택하세요";




################### 메뉴 #################################
$tit['mainTitle']=array("session"=>"통화리스트", "phone"=>"전화번호관리","routing"=>"발신경로관리", "rout_prefix"=>"PREFIX별 발신경로관리","rout_ip"=>"IP별 발신경로관리", "rout_group"=>"라우팅그룹별 발신경로관리" ,"digit"=>"디지트변환관리","digit_group"=>"라우팅그룹별 변환관리", "pri"=>"PRI 국선관리", "class"=>"등급코드관리","etc"=>"부가서비스","etc_func"=>"기능코드 설정","etc_cpgroup"=>"당겨받기그룹","etc_trunk"=>"국선번호관리","etc_groupRring"=>"그룹링","etc_hunt"=>"헌트그룹관리" ,"history"=>"History","loginSetup"=>"관리자 관리 ","myInfo"=>"내정보 수정", "history_call"=>"통화내역 리스트", "history_oper"=>"운영조작내역");


$tit['btn'] = array("import" => "업로드", "export" => "다운로드","save" => "저장", "modify" => "수정", "cancle" => "취소", "add" => "추가", "del" => "삭제","search" => "검색","reset" => "초기화", "close" => "닫기") ; 


### Search File | Upload Type | New      | Edit     | Initialize
$tit["upload"]=array("file"=>"파일선택", "type"=>"업로드형식", "new"=>"자료추가", "edit"=>"자료수정", "initialize"=>"초기화");


########################  session List #######################################
### 호종류 
$aCType=array("TRK" =>"TRK","INC"=>"INC","STN" =>"STN");
###  호상태
$aCStatus=array("Answering" =>"Answering","Calling"=>"Calling","Trying" =>"Trying","Connect"=>"Connect");


$titSession['listTitle']= array("callCnt"=>"동시콜수","callNumber"=>"발신전화번호", "sDate"=>"시화일자","sTime"=>"시화시간","sDateTime"=>"시화일지","eDateTime"=>"종료일시","reNumber"=>"상대방번화번호", "sendIP"=>"발신IP", "reIP"=>"상대방IP","callType"=>"호종류", "callStauts"=>"호상태", "avType"=>"영상/음성");

$titSession['noMsg'] ="현재 통화량이 없습니다.";


### 적용파일: 다운로드 (/history/downFile.php) 
### title : Session Info Download
$titSession['downTitle'] ="통화내역 다운로드";
### 항목명 : Session Date
$titSession['downTitle1'] ="대상 일시";
### 항목명 : 총건수
$titSession['downTitle2'] ="전체";


######################### 전화번호 관리   ############################
$titPhone['listTitle'] =  array("phone"=>"전화번호", "userid"=>"인증 ID","pw"=>"인증암호","re_pw"=>"인증암호 확인 ", "username"=>"고객명","mac"=>"MAC 주소","ip"=>"IP 주소","ip2"=>"장비 IP", "port"=>"포트","expires"=>"등록주기","maxduration"=>"통화제한시간", "cid"=>"발신자표시번호" , "class"=>"전화사용등급", "pgroup"=>"당겨받기 그룹", "trunk"=>"트렁크 번호", "rgroup"=>"라우팅 그룹", "rec"=>"녹취" ,"status" =>"Status"  , "dnd"=>"DND", "cforword"=>"CFORWORD" );

$titPhone['dublePhone'] = "이미 등록된 전화번호입니다."; 
$titPhone['errMac'] ="중복된 MAC Adrdress가 존재합니다." ; //중복된 MAC Adrdress가 존재합니다.
$titPhone['errIp'] ="정확한 IP주소를 입력해주세요" ;//정확한 IP주소를 입력해주세요


### 적용파일: 다운로드 (/phone/uploadFile.php) 
$titPhone['uploadTitle'] ="업로드";


### 적용파일: 다운로드 (/phone/downFile.php) 
### title : Session Info Download
$titPhone['downTitle'] ="다운로드";
### 항목명 : Session Date
$titPhone['downTitle1'] ="대상";
### 항목명 : 총건수
$titPhone['downTitle2'] ="전체";


######################### 발신 경로 관리  ############################
$arrRouting = array("1"=>"SIP Server", "2"=>"GateKeeper", "3"=>"IP Phone");

$titRouting['listTitle'] =  array("digit"=>"디지트", "ip"=>"IP 주소","port"=>"포트", "routing"=>"라우팅장비","rout_ip"=>"라우팅 IP", "rout_group"=>"라우팅 그룹" ,"group"=>"그룹");


$msgRouting['dublePrefix'] = "이미 등록된 디지트 입니다."; 
$msgRouting['dubleIP'] = "이미 등록된 아이피 와 디지트 입니다."; 
$msgRouting['dubleGroup'] = "이미 등록된 그룹과 디지트 입니다."; 


######################### 디지트 변환관리 ############################

$titDigit['listTitle'] =  array("source"=>"원시 디지트", "target"=>"변환 디지트","phone"=>"전화번호");

$titDigit['dubleSource'] = "이미 등록된 원시 디지트 입니다."; 
$titDigit['dublePhone'] = "이미 등록된 전화번호와 원시 디지트 입니다."; 

######################### 국선관리  ############################
$titPritg['listTitle'] =  array("ipaddr"=>"IP 주소", "port"=>"Port","name"=>"사용자명","extNo"=>"Start Ext No", "trkNo"=>"Start Trk No","range"=>"Range","cidNum"=>"CID No", "cidType"=>"CID Type","billNum"=>"Billing No","billType"=>"Billing Type","rec"=>"녹취" );

$arrCidType = array ("1"=>"Trunk Number", "2"=>"CID Number Fixed" , "3"=>"CID Number Increase") ; 
$arrBillType = array ("1"=>"Trunk Number", "2"=>"Billing Number Fixed" , "3"=>"Billing Number Increase") ; 

$arrCidType2 = array ("1"=>"T/N", "2"=>"C/F" , "3"=>"C/I") ; 
$arrBillType2 = array ("1"=>"T/N", "2"=>"B/F" , "3"=>"B/I") ; 

$titPritg['dubleIP'] = "이미 등록된 아이피 입니다."; 


######################## 등급 관리  #######################################

$titClass['listTitle'] =  array("no"=>"번호","class"=>"등급", "explan"=>"등급내용","useCode"=>"허용코드","limitCode"=>"제한코드" );
$titClass['dubleClass'] = "이미 등록된 등급코드 입니다."; 
$titClass['dubleUse'] = "이미 등록된 허용코드 입니다."; 
$titClass['dubleLimit'] = "이미 등록된 제한코드 입니다."; 



########################  부가서버스 #######################################
$titEtc['listTitle']= array("gCode"=>"그룹코드", "gName"=>"그룹명","tNo"=>"트렁크 번호","tName"=>"트렁크 이름", "tPort"=>"트렁크 포트", "rGroup"=>"링그룹","rName"=>"링그룹명","rType"=>"링타입", "phone"=>"전화번호","hGroup"=>"헌트 그룹", "hPhone"=>"전화번호");

$arrRtype = array ("1"=>"전체", "2"=>"단독") ; 

$titEtc['dublePcode'] ="이미 등록된 그룹코드입니다. "; 
$titEtc['dubleTnumber'] ="이미 등록된 트렁크 번호입니다. "; 
$titEtc['dubleHgroup'] ="이미 등록된 헌트그룹 입니다. "; 




########### Log 관리  ##########################
### 로그 아이템	
$aLogItem=array("1"=>"시스템","2"=>"전화번호관리","3"=>"발신경로관리","4"=>"디지트변환관리","5"=>"등급코드관리","6"=>"PRI국선관리","7"=>"History",  "8"=>"부가서비스", "9"=>"로그인/관리자관리", "10"=>"업로드","11"=>"다운로드");




$aLogAction= array(
	"1"=>array("mod"=>"Server Update"),
	"2"=>array("view"=>"View","add"=>"New","mod"=>"Update","del"=>"Delete","down"=>"Down","upload"=>"Import"),
	"3"=>array("view"=>"View","add"=>"New","mod"=>"Update","del"=>"Delete"),
	"4"=>array("view"=>"View","add"=>"New","mod"=>"Update","del"=>"Delete"),
	"5"=>array("view"=>"View","add"=>"New","mod"=>"Update","del"=>"Delete"),
	"6"=>array("view"=>"View","add"=>"New","mod"=>"Update","del"=>"Delete"),
	"7"=>array("view"=>"View","del"=>"Delete","mod"=>"Update","down"=>"Down"),
	"8"=>array("view"=>"View","add"=>"New","del"=>"Delete","mod"=>"Update"),
	"9"=>array("view"=>"View","add"=>"New","mod"=>"Update","mymod"=>"My Info","del"=>"Delete","login"=>"Login","logout"=>"Logout","import"=>"Admin User Import","export"=>"Admin User  Export"),
	"10"=>array("new"=>"자료추가","modify"=>"자료수정","insert"=>"초기화"),
	"11"=>array("down"=>"Down")	
);	

$msgLog['selectTitle']="전체";//전체



########### Login Setup (/loginSetup/)  ##########################

$titAdmin['listTitle'] =  array("no"=>"번호","level"=>"등급", "id"=>"관리자 ID","name"=>"관리자명","email"=>"이메일 주소" ,"regDate"=>"등록일", "vDate"=>"마지막 방문일", "vHit"=>"방문횟수" );


$titAdmin['dubleID'] = "이미 등록된 아이디 입니다."; 


### 관리자 Level
### 1:시스템 관리자 | 2:프로젝트 마스터 | 3:관리자 | 4:운영자 | 5:모니터 요원
$aAdminLevel=array("1"=>"시스템 관리자","2"=>"마스터","4"=>"일반관리자"); 

$msgLogin['errId'] ="아이디는 영소문/숫자/특수문자 조합으로 4~16자로 입력해주세요" ;//아이디는 영소문/숫자/특수문자 조합으로 4~16자로 입력해주세요";
$msgLogin['errId2'] ="이미 등록되어있는 아이디 입니다." ;//이미 등록되어있는 아이디 입니다.
$msgLogin['errId3'] ="등록할 수 없는 아이디입니다." ;//등록할 수 없는 아이디입니다.
$msgLogin['errName'] ="특수문자를 제외하고 2~10자로 입력해주세요";" ;//특수문자를 제외하고 2~10자로 입력해주세요";
$msgLogin['errPassword1'] ="패스워드를 입력해주세요" ;//패스워드를 입력해주세요
$msgLogin['errPassword2'] ="비밀번호는 4~16자의 유효한 문자로 입력해주세요" ;//비밀번호는 4~16자의 유효한 문자로 입력해주세요
$msgLogin['errPassword3'] ="비밀번호가 일치하지 않습니다. 확인해주세요" ;//비밀번호가 일치하지 않습니다. 확인해주세요
$msgLogin['errPassword4'] ="비밀번호는 숫자와 영문자를 혼용하여야 합니다." ;//비밀번호는 숫자와 영문자를 혼용하여야 합니다.
$msgLogin['errPassword5'] ="비밀번호에 같은 문자를 4번 이상 사용하실 수 없습니다." ;//비밀번호에 같은 문자를 4번 이상 사용하실 수 없습니다.
$msgLogin['errPassword6'] ="ID가 포함된 비밀번호는 사용하실 수 없습니다." ;//ID가 포함된 비밀번호는 사용하실 수 없습니다.

$msgLogin['errFileName1'] = "Admin User 첨부파일이 아닙니다.";  //Admin User 첨부파일이 아닙니다.
$msgLogin['errFileName2'] = "접근가능한 프로젝트 첨부파일이 아닙니다."; //당신의 프로젝트 첨부파일이 아닙니다.
$msgLogin['errEmail'] ="유효한 이메일 주소를 입력해주세요";      //유효한 이메일 주소를 입력해주세요
$msgLogin['errPhone'] ="유효한 전화번호를 입력해주세요";				 //유효한 전화번호를 입력해주세요

$msgLogin['errLevel1'] ="시스템 관리자 관리자는  ".$config['numsuper']." 이상 등록하실 수 없습니다.";   //Supervisor은 더이상 등록하실수 없습니다.
$msgLogin['errLevel2'] ="프로젝트 마스터는 ".$config['numTenant']." 이상 등록하실 수 없습니다.";      //Tenant은 더이상 등록하실수 없습니다.

$msgLogin['errLevel3'] ="관리자는 ".$config['numMaster']." 이상 등록하실 수 없습니다.";      //Master은 더이상 등록하실수 없습니다.
$msgLogin['errLevel4'] ="운영자는 ".$config['numAdmin']." 이상 등록하실 수 없습니다.";      //Adminnistrator은 더이상 등록하실수 없습니다.
$msgLogin['errLevel5'] ="모니터 요원은 ".$config['numMonitor']." 이상 등록하실 수 없습니다.";    //Monitor은 더이상 등록하실수 없습니다.

$msgLogin['del2'] ="삭제 완료 .\\n 삭제 건수 : " ;//총 $cnt 건을 삭제하였습니다.







################## Operation Info  (/logList/)  ##########################
### 적용파일: /logList/list.php 
### 리스트 타이틀 : Date/Time | User | IP | Item | Target | ENG/OPER | Action | Result
$titLog['listTitle'] = array("date"=>"날짜/시간","user"=>"ID","ip"=>"IP","item"=>"Item","target"=>"Target","kind"=>"ENG/OPER","action"=>"Action" ,"result"=>"Result" );

### 적용파일: 다운로드 (/logList/downFile.php) 
### title : Operation Info Download
$titLog['downTitle'] ="운영조작 다운로드";
### 항목명 : Operation Date
$titLog['downTitle1'] ="운영조작 일자";
### 항목명 : 총건수
$titLog['downTitle2'] ="총건수";





########### 결과 팝업창 (/outline/popActionResult.php)  ##########################
### Head 타이틀 
$titResult['headTitle'] =array("del"=>"삭제 결과", "import"=>"업로드 결과" );

### 타이틀 :전체 대상 건수 | 정상 처리 건수 | 처리 실패 건수
$titResult['title'] =array("total"=>"전체 대상 건수", "success"=>"정상 처리 건수","error"=>"처리 실패 건수");

### 타이틀 :완료 리스트 | 실패 리스트 | 처리 완료 내역이 없습니다.
$titResult['result'] =array("success"=>"처리 완료 내역", "error"=>"실패 내역","noMsg"=>"처리 완료 내역이 없습니다.");




?>