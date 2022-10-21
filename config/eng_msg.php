<?
########### 공통  ##########################
$msg['permit1']="No right to access.";									//접속권한이 없습니다.
$msg['permit2']="No right to execute";									//실행권한이 없습니다.
$msg['logout']="Do you want to log out?";									//로그아웃하시겠습니까?
$msg['exeOk'] ="Execute the command";										//명령 실행
$msg['errLogin1']="Login Error, Please check up ID and Password again";	//일치하는 아이디/비밀번호 정보가 없습니다.
$msg['errLogin2']="Login Error, This ID is already logged in.";				//해당 아이디는 이미 로그인 중 입니다
$msg['ErrNumber'] = "The range of number is not available.";			//숫자 범위가 유효하지 않습니다.
$msg['session']="Session will be disconnected.";					//세션 연결이 종료됩니다.
$msg['errcharacter']="It is an invalid character.";						//특수문자는 입력하실 수 없습니다.
$msg['errNoData'] ="There is no data to execute" ;					//실행할 데이타가 없습니다.
$msg['delSelected'] ="Please select data you want to delete." ;			//삭제할 데이타를 선택해주세요;
$msg['delResult'] ="Performed result.\\nDeleted Items : " ;				//총 $cnt 건을  삭제하였습니다.
$msg['delete']="Do you want to delete the selected item?";				//선택한 내용을 삭제하시겠습니까?
$msg['onlyNum']="Only numbers can be input.";							//숫자만 입력가능 합니다.
$msg['upFile']="Only  xls files can be uploaded.";				//txt, xls, csv 파일만 업로드 가능합니다. 
$msg['upFileOk']="Registration completed.\\n Total  ";						//등록완료( 몇건)
$msg['selFile']="Please select file you want to upload.";				//업로드할 파일을 선택해 주세요
$msg['downFile']="Do you want download?";								//다운로드를 진행합니다.
$msg['unit']="items";
$msg['errInputValue'] ="Please Input the proper value" ;						//해당 값을 입력해 주세요
$msg['clickNew']="Please Click New button"  ;						// New 버튼을 클릭해 주세요
$msg['errPassword1'] ="Please input your password." ;					//패스워드를 입력해주세요
$msg['errPassword2'] ="Password should be 4~16 alphanumeric or small letter" ;//비밀번호는 4~20자의 유효한 문자 또는 소문자로 입력해주세요
$msg['errPassword3'] ="Password is not correct. Please check it again." ;//비밀번호가 일치하지 않습니다. 확인해주세요
$msg['insIndb'] ="Registration completed.\\nRegistered Items : " ;			//정상적으로 등록되었습니다.;
$msg['errIndb'] ="DB registration error." ;			//DB 등록시 에러가 발생하였습니다.
$msg['errUpdb'] ="DB updating error." ;				//DB 수정시 에러가 발생하였습니다.
$msg['errDeldb'] ="DB deleting error." ;				//DB 삭제시 에러가 발생하였습니다.
$msg['ErrPhone1'] = "Please input the UE number.";						//폰번호를 입력해주세요
$msg['ErrPhone2'] ="This UE number is already registered." ;					 //이미 등록되어 있는 PHONE 번호입니다
$msg['ErrPhone3'] = "This UE number is not registered.";				//등록되지 않은 phone Number 입니다.
$msg['ErrPhone4'] ="The same UE number existed." ;			//중복된 PHONE 번호가 존재합니다.
$msg['allchk']="All";											//전체선택
$msg['doselect'] ="Please select";

################### 메뉴 #################################
$tit['mainTitle']=array("session"=>"Session", "phone"=>"Phone Manage","routing"=>"Routing Manage", "rout_prefix"=>"Routing Manage by prefix","rout_ip"=>"Routing Manage by IP", "rout_group"=>"Routing Manage by group" ,"digit"=>"Called No Conversion","digit_group"=>"Conversion digit by routing group",
	"pri"=>"PRI Trunk G/W", "class"=>"Class Control","etc"=>"Addition Service", "etc_func"=>"Function Code","etc_cpgroup"=>"Call pickup Geroup","etc_trunk"=>"Trunk Management","etc_groupRring"=>"Ring Group","etc_hunt"=>"Hunt Group Management","history"=>"History","loginSetup"=>"Administrator " ,"myInfo"=>"My Info", "history_call"=>"Session History", "history_oper"=>"Operation Info");

$tit['btn'] = array("import" => "Import", "export" => "Export","save" => "Save","modify" => "Modify", "cancle" => "Cancel", "add" => "Add", "del" => "Delete","search" => "Search","reset" => "Reset", "close" => "Close") ; 
 
### Search File | Upload Type | New      | Edit     | Initialize
$tit["upload"]=array("file"=>"File", "type"=>"Upload Type", "new"=>"New", "edit"=>"Merge", "initialize"=>"Overwrite");

########################  session List #######################################
### 호종류 
$aCType=array("TRK" =>"TRK","INC"=>"INC","STN" =>"STN");
###  호상태
$aCStatus=array("Answering" =>"Answering","Calling"=>"Calling","Trying" =>"Trying","Connect"=>"Connect");


$titSession['listTitle']= array("callCnt"=>"Concurrent","callNumber"=>"Calling Number", "sDate"=>"Start Date","sTime"=>"Start Time","sDateTime"=>"Start Date/Time","eDateTime"=>"End Date/Time", "reNumber"=>"Called Number", "sendIP"=>"Calling IP", "reIP"=>"Called IP","callType"=>"Call Type", "callStauts"=>"Call Status", "avType"=>"A/V");
$titSession['noMsg'] ="There is not current calls."; 


### 적용파일: 다운로드 (/history/downFile.php) 
### title : Session Info Download
$titSession['downTitle'] ="Session List Download";
### 항목명 : Session Date
$titSession['downTitle1'] ="Session Date";
### 항목명 : 총건수
$titSession['downTitle2'] ="Total";



######################### 전화번호 관리   ############################
$titPhone['listTitle'] =  array("phone"=>"Phone Number", "userid"=>"User ID","pw"=>"Password","re_pw"=>"Password(Confirm)", "username"=>"User Name","mac"=>"MAC Address","ip"=>"IP Address", "ip2"=>"(P) IP Address", "port"=>"Port","expires"=>"Expires","maxduration"=>"Max Duration", "cid"=>"CID Number" , "class"=>"Class", "pgroup"=>"Pickup Group", "trunk"=>"Trunk Number", "rgroup"=>"Routing Group", "rec"=>"Recording","status" =>"Status" , "dnd"=>"DND" , "cforword"=>"CFORWORD");

$titPhone['dublePhone'] = "This Phone Number is already registered."; 
$titPhone['errMac'] ="The same Mac Address existed." ; //중복된 MAC Adrdress가 존재합니다.
$titPhone['errIp'] ="Please input proper IP address." ;//정확한 IP주소를 입력해주세요


### 적용파일: 다운로드 (/phone/uploadFile.php) 
$titPhone['uploadTitle'] ="Import";

### 적용파일: 다운로드 (/phone/downFile.php) 
### title : Session Info Download
$titPhone['downTitle'] ="Download";
### 항목명 : Session Date
$titPhone['downTitle1'] ="Target";
### 항목명 : 총건수
$titPhone['downTitle2'] ="Total";






######################### 발신 경로 관리  ############################
$arrRouting = array("1"=>"SIP Server", "2"=>"GateKeeper", "3"=>"IP Phone");

$titRouting['listTitle'] =  array("digit"=>"Prefix", "ip"=>"IP Address","port"=>"Port", "routing"=>"Routing-System","rout_ip"=>"Routing IP", "rout_group"=>"Routing Group" ,"group"=>"Group");


$msgRouting['dublePrefix'] = "This Prefix is already registered."; 
$msgRouting['dubleIP'] = "This IP and Prefix is already registered."; 
$msgRouting['dubleGroup'] = "This Group and Prefix is already registered."; 


######################### 디지트 변환관리 ############################

$titDigit['listTitle'] =  array("source"=>"Source Digit", "target"=>"Conversion Digit","phone"=>"Phone Number");


$titDigit['dubleSource'] = "This Source Digit is already registered."; 
$titDigit['dublePhone'] = "This Phone and Source Digit is already registered."; 



######################### 국선관리  ############################
$titPritg['listTitle'] =  array("ipaddr"=>"IP Address", "port"=>"Port","name"=>"User Name","extNo"=>"Start Ext No", "trkNo"=>"Start Trk No","range"=>"Range","cidNum"=>"CID No", "cidType"=>"CID Type","billNum"=>"Billing No","billType"=>"Billing Type","rec"=>"Record" );
$arrCidType = array ("1"=>"Trunk Number", "2"=>"CID Number Fixed" , "3"=>"CID Number Increase") ; 
$arrBillType = array ("1"=>"Trunk Number", "2"=>"Billing Number Fixed" , "3"=>"Billing Number Increase") ; 
$arrCidType2 = array ("1"=>"T/N", "2"=>"C/F" , "3"=>"C/I") ; 
$arrBillType2 = array ("1"=>"T/N", "2"=>"B/F" , "3"=>"B/I") ; 

$titPritg['dubleIP'] = "This IP Address is already registered."; 



######################## 등급 관리  #######################################

$titClass['listTitle'] =  array("no"=>"No","class"=>"Class", "explan"=>"Explanation","useCode"=>"Use Code","limitCode"=>"Limit Code" );
$titClass['dubleClass'] = "This Class is already registered."; 
$titClass['dubleUse'] = "This Use Coe is already registered."; 
$titClass['dubleLimit'] = "This Limit Code is already registered."; 



########################  부가서버스 #######################################
$titEtc['listTitle']= array("gCode"=>"Group Code", "gName"=>"Group Name","tNo"=>"Trunk Number 번호","tName"=>"Trunk Name", "tPort"=>"Trunk Port", "rGroup"=>"Ring Group","rName"=>"Ring Name","rType"=>"Ring Type", "phone"=>"Phone Number","hGroup"=>"Hunt Group", "hPhone"=>"Phone Number" );

$arrRtype = array ("1"=>"All", "2"=>"Alone") ; 


$titEtc['dublePcode'] ="This group code is already registered."; 
$titEtc['dubleTnumber'] ="This Trunk Number is already registered."; 
$titEtc['dubleHgroup'] ="This Hunt Group is already registered."; 






########### Log 관리  ##########################
### 로그 아이템	
$aLogItem=array("1"=>"System","2"=>"Phone Management","3"=>"Routing Management","4"=>"Called No Conversion","5"=>"Class Management","6"=>"PRI Trunk G/W", "7"=>"History", "8"=>"Addition Service", "9"=>"login/admin", "10"=>"Upload","11"=>"Download");


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
	"10"=>array("new"=>"New","modify"=>"Edit","insert"=>"Initilaize"),
	"11"=>array("down"=>"Down")	
);	


$msgLog['selectTitle']="Total";//전체



########### Login Setup (/loginSetup/)  ##########################

$titAdmin['listTitle'] =  array("no"=>"No","level"=>"Level", "id"=>"Admin ID","name"=>"Name","email"=>"Email"  ,"regDate"=>"Registration", "vDate"=>"Last Login Date/Time", "vHit"=>"Visited" );
$titAdmin['dubleID'] = "This Admin ID is already registered."; 



### 관리자 Level
### 1:시스템 관리자 | 2:Tenant | 3:Admin | 4:Unit operator
$aAdminLevel=array("1"=>"System Owner","2"=>"main manager","4"=>"general manager"); 


$msgLogin['errId'] ="Please input 4~16 digits of alphanumeric or small letter" ;//아이디는 영소문/숫자/특수문자 조합으로 4~16자로 입력해주세요";
$msgLogin['errId2'] ="This ID is already registered. " ;//이미 등록되어있는 아이디 입니다.
$msgLogin['errId3'] ="This ID is not allowed to register. " ;//등록할 수 없는 아이디입니다.
$msgLogin['errName'] ="Please input 2~16 digits of alphanumeric except special character." ;//특수문자를 제외하고 2~10자로 입력해주세요";
$msgLogin['errPassword1'] ="Please input the password." ;//패스워드를 입력해주세요
$msgLogin['errPassword2'] ="Please input the 4~8 digits of alphanumeric" ;//비밀번호는 4~16자의 유효한 문자로 입력해주세요
$msgLogin['errPassword3'] ="Password is not correct. Please check it again." ;//비밀번호가 일치하지 않습니다. 확인해주세요
$msgLogin['errPassword4'] ="Password should be 4~16 digits of combined alphabet and number" ;//비밀번호는 숫자와 영문자를 혼용하여야 합니다.
$msgLogin['errPassword5'] ="It is not allowed to input the same character more than 4 times as password" ;//비밀번호에 같은 문자를 4번 이상 사용하실 수 없습니다.
$msgLogin['errPassword6'] ="It is not allowed to input the password including ID character." ;//ID가 포함된 비밀번호는 사용하실 수 없습니다.

$msgLogin['errFileName1'] = "This is not Admin User File";  //Admin User 첨부파일이 아닙니다.
$msgLogin['errFileName2'] = "Tenant is not correct. Please check it again."; //당신의 프로젝트 첨부파일이 아닙니다.
$msgLogin['errEmail'] ="Please input proper email address";      //유효한 이메일 주소를 입력해주세요
$msgLogin['errPhone'] ="Please input proper UE number";				 //유효한 전화번호를 입력해주세요

$msgLogin['errLevel1'] ="The system has only 1 ID for System owner ".$config['numsuper'];   //Supervisor은 더이상 등록하실수 없습니다.
$msgLogin['errLevel2'] ="The system can not register the Tenant ID any more ".$config['numTenant'];      //Tenant은 더이상 등록하실수 없습니다.

$msgLogin['errLevel3'] ="The system can not register the Admin ID any more ".$config['numMaster'];      //Master은 더이상 등록하실수 없습니다.
$msgLogin['errLevel4'] ="The system can not register the Unit operator ID any more ".$config['numAdmin'];      //Adminnistrator은 더이상 등록하실수 없습니다.

$msgLogin['del2'] ="Successfully deleted.\\nDeleted Items : " ;//총 $cnt 건을 삭제하였습니다.




################## Operation Info  (/logList/)  ##########################
### 적용파일: /logList/list.php 
### 리스트 타이틀 : Date/Time |  User | IP | Item | Target | ENG/OPER | Action | Result
$titLog['listTitle'] = array("date"=>"Date/Time","user"=>"User ID","ip"=>"IP","item"=>"Item","target"=>"Target","kind"=>"ENG/OPER","action"=>"Action" ,"result"=>"Result" );


### 적용파일: 다운로드 (/logList/downFile.php) 
### title : Operation Info Download
$titLog['downTitle'] ="Operation Download";
### 항목명 : Operation Date
$titLog['downTitle1'] ="Operation Date";
### 항목명 : 총건수
$titLog['downTitle2'] ="Total";





########### 결과 팝업창 (/outline/popActionResult.php)  ##########################
### Head 타이틀 
$titResult['headTitle'] =array("del"=>"Delete Result", "import"=>"Import Result");

### 타이틀 :전체 대상 건수 | 정상 처리 건수 | 처리 실패 건수
$titResult['title'] =array("total"=>"Total number of objects", "success"=>"Number of success","error"=>"Number of fail");

### 타이틀 :완료 리스트 | 실패 리스트 | 처리 완료 내역이 없습니다.
$titResult['result'] =array("success"=>"Success List", "error"=>"Error List", "noMsg"=>"No processing completed.");




?>