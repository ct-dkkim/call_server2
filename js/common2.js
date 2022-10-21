String.prototype.trim = function() 
{
return this.replace(/(^ *)|( *$)/g, "");
}
String.prototype.ltrim = function() 
{
return this.replace(/(^ *)/g, "");
}
String.prototype.rtrim = function() 
{
return this.replace(/( *$)/g, "");
}

String.prototype.toComma = function(){
	return Number(String(this).replace(/\..*|[^\d]/g,"")).toLocaleString().slice(0,-3); 
}

String.prototype.replaceAll = function(oldWord,newWord){
    return this.split(oldWord).join(newWord);  
}

function replaceAll(src,oldWord,newWord){
    return src.split(oldWord).join(newWord);  
}

function checkCharacter(obj){
    var strobj = obj;     
    re = /[\{\}\[\],;|\)*~`^_┼<>\#$&\'\"\\\(\=]/gi; //정규식 구문
    // 허용 특수 문자 : !@+-?.:/%
    //re = /[ \{\}\[\]\/?.,;:|\)*~`!^\-_+┼<>@\#$%&\'\"\\\(\=]/gi;
    
    if(re.test(strobj.value)) {
	  $.prn.alert("!@+-?.:/% 를 제외한 특수 문자는 입력하실수 없습니다.");
       strobj.value = strobj.value.replace(re,"");
	   return false
    }
   }


function chkForm(f)
{
	var reschk = 0;

	var cnt=f.elements.length;
	
	for (i=0;i<cnt;i++){
		currEl = f.elements[i];
		if (currEl.disabled) continue;

		if (currEl.getAttribute("required")!=null){
			if (currEl.type=="checkbox" || currEl.type=="radio"){
				if (!chkSelect(f,currEl,currEl.getAttribute("msgR"))) return false;
			} else {
				if (!chkText(currEl,currEl.value,currEl.getAttribute("msgR"))) return false;
			}
		}

		if (currEl.getAttribute("option")!=null && currEl.value.length>0){
			if (!chkPatten(currEl,currEl.getAttribute("option"),currEl.getAttribute("msgR"))) return false;
		}
		if (currEl.getAttribute("minlength")!=null){
			if (!chkLength(currEl,currEl.getAttribute("minlength"))) return false;
		}
	}


	//if (f.chkSpamKey) f.chkSpamKey.value = 1;
	//if (document.getElementById('avoidDbl')) document.getElementById('avoidDbl').innerHTML = "--- 데이타 입력중입니다 ---";
	return true;
}

function chkLength(field,len)
{
	text = field.value;
	if (text.trim().length<len){
		alert(len + "자 이상 입력하셔야 합니다");
		field.focus();
		return false;
	}
	return true;
}

function chkText(field,txt,msg)
{
	txt = txt.trim();
	if (txt==""){
		var caption = field.parentNode.parentNode.firstChild.innerText;
		if (!field.getAttribute("label")) field.setAttribute("label",(caption)?caption:field.name);
		if (!msg) msg = "[" + field.getAttribute("label") + "] Required fields";
		//if (!msg) msg = "[" + field.getAttribute("label") + "] 필수입력사항";
		//if (msg) msg2 += "\n\n" + msg;
		alert(msg);
		if (field.tagName!="SELECT") field.value = "";
		if (field.type!="hidden" && field.style.display!="none") field.focus();
		return false;
	}
	return true;
}

function chkSelect(form,field,msg)
{
	var ret = false;
	fieldname = eval("form.elements['"+field.name+"']");
	if (fieldname.length){
		for (j=0;j<fieldname.length;j++) if (fieldname[j].checked) ret = true;
	} else {
		if (fieldname.checked) ret = true;
	}
	if (!ret){
		if (!field.getAttribute("label")) field.getAttribute("label") = field.name;
		var msg2 = "[" + field.getAttribute("label") + "] 필수선택사항";
		if (msg) msg2 += "\n\n" + msg;
		alert(msg2);
		field.focus();
		return false;
	}
	return true;
}

function chkPatten(field,patten,msg)
{
	var regNum			= /^[0-9]+$/;
	var regTel			= /^[0-9]{4,12}$/;
	var regEmail		= /^[^"'@]+@[._a-zA-Z0-9-]+\.[a-zA-Z]+$/;
	var regUrl			= /^(http\:\/\/)*[.a-zA-Z0-9-]+\.[a-zA-Z]+$/;
	var regAlpha		= /^[a-zA-Z]+$/;
	var regHangul		= /[\uAC00-\uD7A3]/;
	var regHangulEng	= /[\uAC00-\uD7A3a-zA-Z]/;
	var regHangulOnly	= /^[\uAC00-\uD7A3]*$/;
	//var regId			= /^[a-z0-9]{1}[^"']{3,16}$/;
	var regId			= /^[\x21-\x7E]{3,16}$/;
	var regPass			= /^[\x21-\x7E]{4,20}$/;
	var regData			= /^[2]{1}[0-9]{1,3}[-][0,1]{1}[0-9]{1}[-][0-3]{1}[0-9]{1}$/;
	var regIP			= /^(1|2)?\d?\d([.](1|2)?\d?\d){3}$/;
	var regTime			= /^[0-9]{2}:[0-9]{2}$/;
    //var regHandPH = /^01([0|1|6|7|8|9]?)-?([0-9]{3,4})-?([0-9]{4})$/;  //핸드폰
    //var regPH = /^\d{2,3}-\d{3,4}-\d{4}$/;  //일반전화



	patten = eval(patten);
	if (!patten.test(field.value)){
		var caption = field.parentNode.parentNode.firstChild.innerText;
		if (!field.getAttribute("label")) field.setAttribute("label",(caption)?caption:field.name);
		var msg2 = "[" + field.getAttribute("label") + "] 입력형식오류";
		if (msg) msg2 += "\n\n" + msg;
		alert(msg2);
		field.focus();
		return false;
	}
	return true;
}

function chkRadioSelect(form,field,val,msg)
{
	var ret = false;
	fieldname = eval("form.elements['"+field+"']");
	if (fieldname.length){
		for (j=0;j<fieldname.length;j++){
			if (fieldname[j].checked) ret = fieldname[j].value;
		}
	} else {
		if (fieldname.checked) ret = true;
	}
	if (val != ret){
		alert(msg);
		return false;
	}
	return true;
}



function win_popup(name, url, left, top, width, height, toolbar, menubar, statusbar, scrollbar, resizable)
{
  toolbar_str = toolbar ? 'yes' : 'no';
  menubar_str = menubar ? 'yes' : 'no';
  statusbar_str = statusbar ? 'yes' : 'no';
  scrollbar_str = scrollbar ? 'yes' : 'no';
  resizable_str = resizable ? 'yes' : 'no';

  window.open(url, name, 'left='+left+',top='+top+',width='+width+',height='+height+',toolbar='+toolbar_str+',menubar='+menubar_str+',status='+statusbar_str+',scrollbars='+scrollbar_str+',resizable='+resizable_str+", location=no");
}



function getRef(id)
{
	if (isDOM) return document.getElementById(id);
	if (isIE4) return document.all[id];
	if (isNS4) return document.layers[id];
}




/*
// 0~9 - , 만 입력가능
function OnlyInputTelNum(obj)
{	
	var r = RegExp('[^0-9,]');

	//var r = new RegExp(/\D/);
	if( r.test(obj.value))
	{
		//event.returnValue = false; 
		alert("0-9, 콤마(,)만 입력할 수 있습니다.");
		obj.value = "";
		obj.focus();
	}
}

function OnlyInputNum()
{
	var code = 0;
	code = event.keyCode;
	if(code != 96 && code != 97 && code != 98 && code !=99 && code != 100 && code != 101 && code != 102 && code !=103 && code != 104 && code !=105 && code != 8 && code != 46 && code != 32 && code != 9 && code != 37 && code != 38 && code != 39 && code != 48 && code != 49 && code != 50 && code != 51 && code != 52 && code != 53 && code != 54 && code != 55 && code != 56 && code != 57 && code != 13 && code != 16 && code != 17 && code != 18 && code != 188)
	{
		event.returnValue = false; 
	}
	else
	{
		event.returnValue = true;
	}
}

function Only_Number(obj)
{
	var msg;
	var r = new RegExp(/\D/);
	if( r.test(obj.value))
	{
		//alert("숫자만 입력해 주세요.");
		alert("Input only number")

		obj.value = "";
		obj.focus();
			return false;

	}

	return true;
}


//##########숫자만 입력
function IsNumber(form) {

	for(var i = 0; i < form.value.length; i++) {
		var chr = form.value.substr(i,1);

		if(chr < '0' || chr > '9') {  
			alert("Input with number")
			//alert("숫자로 입력해 주세요")
		    form.value="";
			form.focus();
			return false;
		}
	}

	return true;
}


//##########숫자입력이벤트
function IsNumberKey( argEvent ) 
{
	if ( !(argEvent.keyCode>=48 && argEvent.keyCode<=57 || argEvent.keyCode>=96 && argEvent.keyCode<=105 || argEvent.keyCode==8 || argEvent.keyCode==9 || argEvent.keyCode==37 || argEvent.keyCode==39 || argEvent.keyCode==46 ) ) 
	{
		argEvent.returnValue=false;
	}
}

//문자포함여부 반환
function containsChars(input,chars) 
{
	for (var inx = 0; inx < input.length; inx++)
	{
		if (chars.indexOf(input.charAt(inx)) != -1)
			return true;
	}
	return false;
}

//input이 숫자만 포함하고 있는지 반환
function ValidOnlyNum(input) 
{
	for (var inx = 0; inx < input.length; inx++)
	{
		if(input.charAt(inx) != 96 && input.charAt(inx) != 97 && input.charAt(inx) != 98 && input.charAt(inx) !=99 && input.charAt(inx) != 100 && input.charAt(inx) != 101 && input.charAt(inx) != 102 && input.charAt(inx) !=103 && input.charAt(inx) != 104 && input.charAt(inx) !=105 && input.charAt(inx) != 188 && input.charAt(inx) != 8 && input.charAt(inx) != 46 && input.charAt(inx) != 32 && input.charAt(inx) != 9 && input.charAt(inx) != 37 && input.charAt(inx) != 38 && input.charAt(inx) != 39 && input.charAt(inx) != 48 && input.charAt(inx) != 49 && input.charAt(inx) != 50 && input.charAt(inx) != 51 && input.charAt(inx) != 52 && input.charAt(inx) != 53 && input.charAt(inx) != 54 && input.charAt(inx) != 55 && input.charAt(inx) != 56 && input.charAt(inx) != 57 && input.charAt(inx) != 13 && input.charAt(inx) != 16 && input.charAt(inx) != 17 && input.charAt(inx) != 18)
			return false;			
	}
	return true;
}

//특수문자 제한
function ExceptEtcChar()
{
	/ * 키값
	.(오른쪽) = 110
	/(오른쪽) = 111
	*(오른쪽) = 106
	+(오른쪽) = 107
	-(오른쪽) = 109
	=(중간) = 187
	-(중간) = 189
	`(왼쪽콤마) = 192
	\(중간) = 220 
	SHIFT = 16
	'(왼쪽) = 222
	/(왼쪽) = 191
	.(왼쪽) = 190
	,(왼쪽) = 188
	; = 186
	* /
	
	var code = 0;
	code = event.keyCode;			
	
	//alert(code);
	if(code == 111 || code == 106 || code == 107 || code == 109 || code == 187 || code == 189 || code == 192 || code == 220 || code == 16 || code == 222 || code == 191 || code == 188 || code == 186)
	{				
		event.returnValue = false; 
	}
	else
	{
		event.returnValue = true;
	}
}

function autobtn(str1,str2){
	document.write("<span id=btn_bg style='height:18px;font-size:11px;font-family:돋움; FONT-WEIGHT: bold;background-image:url(../images/btn_bg.gif);'><img src='../images/btn_left.gif' align='absmiddle'>&nbsp;<a href=\""+str2+"\"><font color=ffffff>"+str1+"</font></a>&nbsp;<img src='../images/btn_right.gif' align='absmiddle'></span>");
}

function whitebtn(str1,str2){
	document.write("<span id=btn_bg style='height:20px;font-size:11px;font-family:돋움; background-image:url(../images/white_btn_bg.gif)'><img src='../images/white_btn_left.gif' align='absmiddle'>&nbsp;<a href=\""+str2+"\"><font color=000000>"+str1+"</font></a>&nbsp;<img src='../images/white_btn_right.gif' align='absmiddle'></span>");
}


function blackbtn(str1,str2){
	document.write("<span id=btn_bg style='height:22px;font-size:11px;font-family:돋움; FONT-WEIGHT: bold;background-image:url(../images/black_btn_bg.gif);'><img src='../images/black_btn_left.gif' align='absmiddle'>&nbsp;<a href=\""+str2+"\"><font color=ffffff>"+str1+"</font></a>&nbsp;<img src='../images/black_btn_right.gif' align='absmiddle'></span>");
}

function smallbtn(str1,str2){
	document.write("<span id=btn_bg style='height:14px;font-size:11px;font-family:돋움;background-image:url(../images/small_btn_bg.gif);'><img src='../images/small_btn_left.gif' align='absmiddle'><a href=\""+str2+"\"><font color=686868>"+str1+"</font></a><img src='../images/small_btn_right.gif' align='absmiddle'></span>");
}

function getWhiteBtn(str1, str2){
	return "<span id=btn_bg style='height:20px;font-size:11px;font-family:돋움; background-image:url(../images/white_btn_bg.gif)'><img src='../images/white_btn_left.gif' align='absmiddle'>&nbsp;<a href=\""+str2+"\"><font color=000000>"+str1+"</font></a>&nbsp;<img src='../images/white_btn_right.gif' align='absmiddle'></span>";
}

*/
// 전체선택여부
function all_check(chkbox,lblname,f)
{		

	var isCheck = false; 

	if(chkbox.checked){ 
		isCheck = true; 
		lblname.innerText = "선택취소";
	} 
	else{
		isCheck = false; 
		lblname.innerText = "전체선택";
	}

	var tot_cnt = f.elements.length;

	for(var i = 0; i < tot_cnt; i++){ 
		if(f.elements[i].name.substring(0,7) == "del_chk"){
			if(isCheck){ 
					f.elements[i].checked = true; 
			} else { 
					f.elements[i].checked = false; 
			} 
		}
	} 
}

// 특정 폼의 지정한 체크박스가 선택되었는지의 여부
function isChecked(formName, checkboxName){
	var frm = document.forms[formName];
	var eles = frm.elements;
	for(var i = 0; i < eles.length; i++){
		var ele = eles[i];
		if(ele.name.substring(0,checkboxName.length) == checkboxName){
			if(ele.checked) return true;
		}
	}
	return false;
}




function chk_comma(commaCheck){

	if(commaCheck == 'Y' && event.keyCode == 188){
		alert('콤마는 입력 할 수 없습니다.');
		//event.returnValue = false;
		return false;
	}

}


////////////////////////////////////////////////////////
//날짜 체크
/////////////////////////////////////////////////////////
function chkDate(y, m, d) {
	var er = 0; // 에러 변수
	var daa = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	if (y%1000 != 0 && y%4 == 0) daa[1] = 29; // 윤년
	if (d > daa[m-1] || d < 1) er = 1; // 날짜 체크
	if (m < 1 || m > 12) er = 1; // 월 체크
	if (m%1 != 0 || y%1 != 0 || d%1 != 0) er = 1; // 정수 체크
	if (er == 1) return false;//날짜가 없다
	else return true;//있다
}

/////////////////////////////////////////////////////////
//시간형식 체크
/////////////////////////////////////////////////////////
function isTime(val) {
	var ret = false;
	var nHour, nMinute, nSecond;
	nHour = Number(val.substring(0,2));
	nMinute = Number(val.substring(2,4));
	nSecond = Number(val.substring(4,6));
	if (nHour >= 0 && nHour <= 23 && nMinute >= 0 && nMinute <= 59 && nSecond >= 0 && nSecond <= 59) ret = true;
	return ret;
}

function changeSimpleTime(value) {
	var arr = value.split(":");
	var ret = "";
	if (value.replace(" ","") == "") return value;
	if (arr.length <= 0) {
		ret = value;
	}else {
		ret  = ("00" + arr[0]).substring(arr[0].length);
		ret += ("00" + arr[1]).substring(arr[1].length);
	}
	return ret;
}




// 배열 arr에서 value 를 검색하여 일치하는 값의 index 를 반환한다.
// ignoreCase : 대소문자를 무시할 것인가? true : false
function getIndexByValue(arr, value, ignoreCase){
	for(var i = 0; i < arr.length; i++){
		var compareVal = arr[i];
		if(ignoreCase){
			compareVal = compareVal.toLowerCase();
			value = value.toLowerCase();
		}
		if(compareVal == value) return i;
	}
	return -1;
}

// 위의 getIndexByValue 와 같은 역할을 한다.
// prototype 으로 선언되어 있으므로 모든 배열데이터에서 사용가능하다.
Array.prototype.getIndex = function(value, ignoreCase){
	for(var i = 0; i < this.length; i++){
		var compareVal = this[i];
		if(ignoreCase){
			compareVal = compareVal.toLowerCase();
			value = value.toLowerCase();
		}
		if(compareVal == value) return i;
	}
	return -1;
}

// Array Remove - By John Resig (MIT Licensed)
Array.prototype.remove = function(from, to) {
  var rest = this.slice((to || from) + 1 || this.length);
  this.length = from < 0 ? this.length + from : from;
  return this.push.apply(this, rest);
}


function secToTime(sec){
	var  H  =  0; 
	var  M  =  0; 
	var  S  =  0; 

	H  = parseInt(sec / 3600); 
	if(escape(H).length < 2) H = "0" + H; 

	M  = parseInt(parseInt(sec / 60) % 60); 
	if(escape(M).length  <  2) M = "0" +  M; 

	S  = parseInt(sec % 60); 
	if(escape(S).length < 2) S = "0" + S; 

	return H + "시간 " + M + "분 " + S + '초'; 
}

// 지정한 id 를 disable 시킨다.
function disabled(id, flag){
	var obj = document.getElementById(id);
	obj.disabled = flag;

	if(obj.type == 'text' || obj.type == 'password' || obj.type == 'textarea'){
		if(flag){
			obj.style.backgroundColor = '#c0c0c0';
		}else{
			obj.style.backgroundColor = '#ffffff';
		}
	}
}

// user name 을 가져온다.
function getUserName(s_code, user_id){
	var url = '../loadAjax/load_user_name.php';
	var param = 'S_Code=' + s_code + '&User_ID=' + user_id;
	var xmlHttp = createRequest();
	var result = '';
	xmlHttp.onreadystatechange = function(){
		if(xmlHttp.readyState == 4){
			result = xmlHttp.responseText;
		}
	};
	xmlHttp.open("get", url + '?' + param, false); // 동기식전송
	xmlHttp.send(param);
	return result;
}

// server name 을 가져온다.
function getServerName(s_code){
	var url = '../loadAjax/load_server_name.php';
	var param = 'S_Code=' + s_code;
	var xmlHttp = createRequest();
	var result = '';
	xmlHttp.onreadystatechange = function(){
		if(xmlHttp.readyState == 4){
			result = xmlHttp.responseText;
		}
	};
	xmlHttp.open("get", url + '?' + param, false); // 동기식전송
	xmlHttp.send(param);
	return result;
}


function go_print(p_type)
{
	
	if(p_type == "2")
	{
		var loc_left = (window.screen.width - 315) / 2;
		var loc_top = (window.screen.height - 330) / 2;
		
		w = window.open("../popup/print.php","인쇄설정","toolbar=no, scrollbars=no, location=no, menu=no, status=no, resizable=1, width=315 , height=330 ,top="+loc_top+", left="+loc_left);
		w.focus();
	}
	else
	{
		var msg; 

		if(p_type == "1") msg = "미리보기하시겠습니까?";
		else msg = "인쇄하시겠습니까?";

		if(confirm(msg) == true){
			document.form2.target= "iflist";
			document.form2.P_Type.value=p_type;
			document.form2.action="";
			document.form2.submit();	
		}
	}
	
}

// list에서  체크박스 전체선택 또는 선택해제
function selectall() {
    var total =0;
	var element=$('input:checkbox[name="chk[]"]')
	var allChk=$('input[name="all"]').is(":checked")
    var chkvalue=""
	for( var i=0; i<element.length; i++) {  
		 if (allChk==true){ //전체선택
			 if (element[i].disabled==false){
				 total++;
				// element[i].checked	= true;
				
				 chkvalue += "," +element[i].value

			 }
		  } else {
			// element[i].checked	= false;
		  }
	}
	if ($('input[name="all"]').is(":checked")){
		 document.fmList.allchk.value= "1";
	} else {
		 document.fmList.allchk.value= "0";
	}
	document.fmList.chkvalue.value=chkvalue;	
    chkChg()

}
// list에서  체크박스 전체선택 또는 선택해제
function selectall2() {
    var total =0;
	var element=$('input:checkbox[name="chk[]"]')
	var allChk=$('input[name="all2"]').is(":checked")
    var chkvalue=""
	for( var i=0; i<element.length; i++) {  
		 if (allChk==true){ //전체선택
			 if (element[i].disabled==false){
				 total++;
				// element[i].checked	= true;
				
				 chkvalue += "," +element[i].value

			 }
		  } else {
			// element[i].checked	= false;
		  }
	}
	if ($('input[name="all2"]').is(":checked")){
		 document.fmList.allchk.value= "1";
	} else {
		 document.fmList.allchk.value= "0";
	}
	document.fmList.chkvalue.value=chkvalue;	
    chkChg()


/*
    var total =0;
	var element=$('input:checkbox[name="chk[]"]')
    var chkvalue=""
	for( var i=0; i<element.length; i++) {  
		 if ($('input[name="all2"]').is(":checked")==true){ //전체선택
			 total++;
			 element[i].checked	= true;
			
			 chkvalue += "," +element[i].value
		  } else {
			 element[i].checked	= false;
		  }
	}
	if ($('input[name="all2"]').is(":checked")){
		 document.fmList.allchk.value= "1";
	} else {
		 document.fmList.allchk.value= "0";
	}
	document.fmList.chkvalue.value=chkvalue;	
	chkChg()
*/
}

// list에서  체크박스 선택해제 (cancle버튼)
function chkCancel() {
    var total =0;
	var element=$('input:checkbox[name="chk[]"]')
	for( var i=0; i<element.length; i++) {  
			 element[i].checked	= false;
	}
	document.fmList.allchk.value= "0";
	document.fmList.chkvalue.value='';	
	chkChg()

}

function selchk( obj) {
    var total =0;
	var element=$('input:checkbox[name="chk[]"]')
    var chkvalue=""
	for( var i=0; i<element.length; i++) {  
		 if (element[i].checked	== true){ 			 
			 chkvalue += "," +element[i].value
		 }
	}

	document.fmList.chkvalue.value=chkvalue;	
	chkChg()

	/*
	chkvalue = ($("input[name='chk[]']:checkbox:checked").length);
	document.fmList.chkvalue.value=chkvalue ;
	*/
}

function selchk2( obj) {
    var total =0;
	var element=$('input:checkbox[name="chk[]"]')
    var chkvalue=""
	for( var i=0; i<element.length; i++) {  
		 if (element[i].checked	== true){ 			 
			 chkvalue += "," +element[i].value
		 }
	}

	document.fmList.chkvalue.value=chkvalue;	
	chkChg()
	if($("#tool").is(":checked")==false) {
		hideTextBox()
	}
	$(obj).parents('div').off('click')
	/*
	chkvalue = ($("input[name='chk[]']:checkbox:checked").length);
	document.fmList.chkvalue.value=chkvalue ;
	*/
}


function selchk3( obj) {
    var total =0;
	var element=$('input:checkbox[name="chk[]"]')
    var chkvalue=""
	for( var i=0; i<element.length; i++) {  
		 if (element[i].checked	== true){ 			 
			 chkvalue += "," +element[i].value
		 }
	}

	document.fmList.chkvalue.value=chkvalue;	

	/*
	chkvalue = ($("input[name='chk[]']:checkbox:checked").length);
	document.fmList.chkvalue.value=chkvalue ;
	*/
}


    //파일명체크
	function chkFileName(file) {
		var ls_str = file;
		var li_str_len = ls_str.length; 
		var Is_one_char;
		var ch;
		for(var i=0; i< li_str_len; i++){
			// 한글자추출
			Is_one_char = ls_str.charAt(i);
			ch = Is_one_char.charCodeAt();
			if(ch == 39 || ch == 92 || ch == 47 || ch == 58 || ch == 42 || ch == 63 || ch == 34 || ch == 60 || ch == 62 || ch == 124 || ch == 32 || ch==46){
				alert( "\\ / : * ? \" < > | \' . 공백문자 는 파일명에 입력할 수 없습니다.");
				$('#MFullName').focus()
				return false
			}
		}
		return true
	}



     //리스트 갱신
		function listRefresh(Vars,aLock) {
			var ajaxIndex = ajaxObjects.length;
			var parameter = Vars.split('&');

			//var now = new Date();
           //document.getElementById("time_div").innerHTML = now;

			link='list_ajax';
			
			$('#vars').val(Vars)
			ajaxObjects[ajaxIndex] = new sack();
			ajaxObjects[ajaxIndex].method = "GET";
			ajaxObjects[ajaxIndex].setVar("link",link);
			for(var i=0;i<parameter.length;i++){
			   var aVars = parameter[i].split('=');
			   if (aVars[1] !="") {
					  ajaxObjects[ajaxIndex].setVar(aVars[0],aVars[1]);
			   }
			}
			//Lock처리할 정보 table^key^value 
			if (aLock!=""){
				ajaxObjects[ajaxIndex].setVar("toLock",aLock);
			}

			ajaxObjects[ajaxIndex].requestFile = "./" + link +".php";	
			ajaxObjects[ajaxIndex].onCompletion = function() { listRefreshComplete(ajaxIndex); } ;
			ajaxObjects[ajaxIndex].runAJAX();
		}

		//리스트 갱신완료
		function listRefreshComplete(index){
		   var result=ajaxObjects[index].response;	
		   var avalue=result.split("##");
		   if (avalue[0])  {
				 $("#divPageNum").html(avalue[0])
		   }
		   $("#divList").html(avalue[1])
		   $("#divPage").html(avalue[2])
		   $("#rightBlank").css( "height", document.body.scrollHeight )
			wwsize = $("#container").outerHeight();
			$("#side").css("height",wwsize).find(">.bg_inner").css("height",wwsize-30);


		}

		function chgListVars( params,delparams,aLock) {
				var Vars=$('#vars').val()
				var Rvars=""
				var isok=""
				var chkParams=params.concat(delparams);

				if (Vars != "")	{
					var parameter = Vars.split('&');
					
					for(var i=0;i<parameter.length;i++){
//						alert(parameter[i].indexOf('undefined'));
						if ( parameter[i] !="undefined"){
							for(var j=0;j<chkParams.length;j++){
								//alert(parameter[i].indexOf(params[j]))
								if (parameter[i].indexOf(chkParams[j]) >= 0 ) {
									isok="1"	
									break;
								}
							}


							if (isok !="1"){
							    Rvars +=  parameter[i] +"&"
							}
							isok="";

						}
					}

				}

				for(var j=0;j<delparams.length;j++){
					if (delparams[j] == 'allchk'){
						  $('*[name^=all]').attr('checked',false)
					}
				    $('#'+delparams[j]).val('')
				}

				for(var j=0;j<params.length;j++){
					Rvars += params[j] +"=" + $('#'+params[j]).val()
					if (j < (params.length - 1 )){
						Rvars += "&"
					}
				}

				listRefresh(Rvars,aLock);

		}

//리스트 검색처리
function search_chg() {
	var value=$('#find').val()

	if (value=="")
	{
		$('#word').val('')
	}
}

//리스트정렬변경
function chg_order(item) {
	 var params = [ 'order', 'desc' ];
   	 var delparams = [ 'chkvalue','allchk','ordvalue'];


	 var order=$('#order').val()
	 var desc=$('#desc').val()
	 if (order==item) {
		 if (desc=="desc") {
			 desc=""
		 } else {
			 desc="desc"
		 }
	 } else {
			 desc=""
	 }
	 $('#desc').val(desc)
	 $('#order').val(item)

	 chgListVars(params,delparams);

}
//리스트 체크박스
function chkChg() {
		var params = [ 'chkvalue','allchk'];
		 chgListVars(params,[]);

}

/*
		$('.article_table_b td').live('mouseover', function() {
			if($(this).parent().css('background-color') == "rgb(255, 255, 255)") {
				$(this).parent().children('td').addClass('m_over_bg');
			}
		});

		$('.article_table_b td').live('mouseout', function() {
			$(this).parent().children('td').removeClass('m_over_bg');
		});


		$('a').live('click', function() {
			var link =$(this).attr("href");

		   if (!link || link=='#') {
			alert('작업준비중입니다.')
			return false
			}
		});

*/

function AES_Encode(plain_text)	{
	var key = "aeverytalkcybertelstuvwxyz235912";
	GibberishAES.size(256);	
	return GibberishAES.aesEncrypt(plain_text, key);
}

function AES_Decode(base64_text){
	var key = "abcdefghijklmnopqrstuvwxyz123456";
	GibberishAES.size(256);	
	return GibberishAES.aesDecrypt(base64_text, key);
}


 function input_check(strobj)  {
                //특수기호
	  re = /[~!@\#$%^&*\<>,.?{}`\=+']/gi;
	  if(re.test(strobj.value)){
		//alert("특수문자는 입력하실수 없습니다.");
		alert("It is an invalid character.");
		strobj.value=strobj.value.replace(re,"");
	  }
 }

//##########id 유효성 검사
function IsID(form) {

	if(form.value.length < 3 || form.value.length > 16) { 
		alert("Make User between 3 and 12 letter.")
		//alert("ID는 3자리 이상 12자리 이하로 입력해 주세요")
		return false;					

	}
	for(var i = 0; i < form.value.length; i++) {
		var chr = form.value.substr(i,1);         
		
		if((chr < '0' || chr > '9') && (chr < 'a' || chr > 'z')) {
			alert("Input with number or small letter.")
			//alert("숫자나 영문 소문자로 입력해 주세요..")
			return false;
		} else {
		  return true ;
		} 
	}
	return true;   
}
//##########패스워드 유효성검사
function IsPW(form) {
	if(form.value.length < 4 || form.value.length > 16) {
		alert("Input Password between 4 and 12 letter.")
		//alert("패스워드는 4자리 이상 12자리 이하로 입력해 주세요")
		//form.focus()
		return false;
	}
	for(var i = 0; i < form.value.length; i++) {
		var chr = form.value.substr(i,1);         

		if((chr < '0' || chr > '9') && (chr < 'a' || chr > 'z') && (chr < 'A' || chr > 'Z')) {
			alert("Input password with number or small letter.")
			//alert("패스워드는 영문과 숫자로만 입력해 주세요")
		    // form.focus()
			return false;
		}
	}
	return true;   
}

function LockDivClose() {
 $('#DivAlert').hide();

}

//모달 팝업창
function LayerPopup_type2(obj,top){
    var id_Motion = $(".popup_layer");
    var objHeight = $(obj).outerHeight();
    var winHeight = document.body.scrollHeight//$(window).height();
	var winOuterHeight = 800;
	if(document.documentElement.scrollHight  >0 ){
		winOuterHeight = document.documentElement.scrollHeight 
	}
	if(document.body.scrollHeight  >0 ){
		winOuterHeight = document.body.scrollHeight 
	}

	if (winOuterHeight < 900) winOuterHeight = 900
	if (top <= 0){
		top =(winHeight -  objHeight ) / 2;
	}
    id_Motion.hide()
    $("#cover").remove();
	

  if(obj !="close"){
     var backgound = $("<div>").attr({
         "id": "cover"
       }).css({
         "height": winOuterHeight 
       });
      $("#wrap").append(backgound);

     $(obj).css({
       "display":"block",
       "z-index":150,
       "top":top - 250 ,
       "left":"50%",
       "margin-left":-( $(obj).outerWidth() / 2)
     });
	   /*
     backgound.off().on("click",function(){
        id_Motion.css("display","none");
        backgound.remove();
        backgound.off("click");
     });
*/
  }//if    
 
  
}//LayerPopup_type

function downEnd() {
    LayerPopup_type2('close')
    window.onfocus = null;//이벤트 리스터 제거
}

//시간멈춤 pause(1000)
function pause(numberMillis) {
	 var now = new Date();
	 var exitTime = now.getTime() + numberMillis;


	 while (true) {
		  now = new Date();
		  if (now.getTime() > exitTime)
			  return;
	}
}

function popclose(){
  $('#divDownLoading').hide()
}


function LayerPopup_type3(obj,top,action){
    var id_Motion = $(".popup_layer");
    var objHeight = $(obj).outerHeight();
    var winHeight = document.body.scrollHeight//$(window).height();
	var winOuterHeight = 800;
	if(document.documentElement.scrollHight  >0 ){
		winOuterHeight = document.documentElement.scrollHeight 
	}
	if(document.body.scrollHeight  >0 ){
		winOuterHeight = document.body.scrollHeight 
	}

	if (top <= 0){
		top =(winHeight -  objHeight ) / 2;
	}
	

  if(action !="close"){
     $(obj).css({
       "display":"block",
       "z-index":150,
       "top":top - 250 ,
       "left":"72%",
       "margin-left":-( $(obj).outerWidth() / 2)
     });
  } else {
	 $(obj).hide()
  }
  
}//LayerPopup_type


//###### 다운로드 완료여부체크
function downResult() {
		var ajaxIndex = ajaxObjects.length;
		ajaxObjects[ajaxIndex] = new sack();
		ajaxObjects[ajaxIndex].method = "POST";
		ajaxObjects[ajaxIndex].setVar("key", "downResult");
		ajaxObjects[ajaxIndex].requestFile = "../outline/downChk_ajax.php";	
		ajaxObjects[ajaxIndex].onCompletion = function() { downResultComplete(ajaxIndex); } ;
		ajaxObjects[ajaxIndex].runAJAX();
}

function downResultComplete(index) {
	var result=ajaxObjects[index].response
	if ($.trim(result) ==true)	{
		LayerPopup_type2('close')
	} else {
		 if (timeid)	{
			clearTimeout(timeid);
		 }
		timeid=setTimeout(downResult,2000);						
		}
}


function noSpaceForm(obj) { // 공백사용못하게
    var str_space = /\s/;  // 공백체크
    if(str_space.exec(obj.value)) { //공백 체크
        alert("Space Error");
        obj.focus();
        obj.value = obj.value.replace(' ',''); // 공백제거
        return false;
    }
 // onkeyup="noSpaceForm(this);" onchange="noSpaceForm(this);"
}

//all chkbox  Null 처리
function allchkNull() {
	if(typeof(document.fmList.all) != "undefined") {
	document.fmList.all.checked=false
	}

}


//채우기 함수
function str_pad(num,value,len) {
				while(num.toString().length < len) {
					num = value + num;
				}
				return num;
}


//systemTime, Local Time  선택변경
function timeTypeChg() {
	var timeType=$('input:radio[name="rDateType"]:checked').val()
	$("#viewDateType").val(timeType)
	var params = ['viewDateType'];
    var delparams = [ 'page_num' ];
	chgListVars(params,delparams);
}

//그룹 Phone 옵션 체크 처리
function optGroupPhoneCheck(target) {		
	if (target=="pttsend"){
		if ($("input:checkbox[id='pttsend']").is(":checked") == true )	{
			$("input:checkbox[id='incoming']").prop("checked", false); 
		} else {
			if ($("input:checkbox[id='incoming']").is(":checked") == false )	{
				$("input:checkbox[id='incoming']").prop("checked", true); 
			}	
		}
	}
	if (target=="incoming"){
		if ($("input:checkbox[id='incoming']").is(":checked") == true )	{
			$("input:checkbox[id='pttsend']").prop("checked", false); 
		} else {
			if ($("input:checkbox[id='pttsend']").is(":checked") == false )	{
				$("input:checkbox[id='pttsend']").prop("checked", true); 
			}	
		}
	}
}

//그룹 Phone 옵션 체크 처리 Enforce
function optGroupPhoneCheck2(target) {		
	if (target=="enforce"){
		if ($("input:checkbox[id='enforce']").is(":checked") == true )	{
			$("input:checkbox[id='enforceLock']").prop("checked", false); 
		}
	}
	if (target=="enforceLock"){
		if ($("input:checkbox[id='enforceLock']").is(":checked") == true )	{
			$("input:checkbox[id='enforce']").prop("checked", false); 
			$("input:checkbox[id='enforce']").prop("disabled", false); 
		}
	}
}

// 번호체계 변경 (00100212345 => 001-002-12345)
function pttNumber_replace(str, len, addstr) {
		var result=""
		if (len.indexOf(",") > 0) {		
			var aLen=len.split(",")
		} else {
			var aLen= Array (len)
		}

		for (var i=0;i <aLen.length ;i++ )	{
			result +=str.substring(0,aLen[i])+addstr
			str = str.substring(aLen[i])
		}
		result += str

		return result

}

 function caps_lock(e) {


	   var targetID = e.target.id
	   var pos=$("#"+targetID).offset();
	   var top=pos.top +60 ;
	   var left=pos.left ;

       var myKeyCode=0;
       var myShiftKey=false;
       $("#CapsMsgDiv").remove();

      // Internet Explorer 4+
      if ( document.all ) {
             myKeyCode=e.keyCode;
             myShiftKey=e.shiftKey;

      // Netscape 4
       } else if ( document.layers ) {
             myKeyCode=e.which;
             myShiftKey=( myKeyCode == 16 ) ? true : false;

      // Netscape 6
       } else if ( document.getElementById ) {
             myKeyCode=e.which;
             myShiftKey=( myKeyCode == 16 ) ? true : false;

      }

      
       if ( ( myKeyCode >= 65 && myKeyCode <= 90 ) && !myShiftKey ) {
            //alert( myMsg );
			CapsLockMsg(top,left)
             return false;

      
       } else if ( ( myKeyCode >= 97 && myKeyCode <= 122 ) && myShiftKey ) {
             //alert( myMsg );
			 CapsLockMsg(top,left)
             return false;
       }

}

function CapsLockMsg(top, left){
     var myMsg='  Caps Lock is On';
     var newDiv = $("<div>").attr({
         "id": "CapsMsgDiv"
       }).css({
		  "position":"absolute",
		  "display":"block",
		  "z-index":999,
         "width": 220,
         "top": top,
         "left": left,
         "padding-left": 15,
         "background": "#ffff66",
         "border": "2px solid #666",
         "height": 35,
		 "line-height": "33px",
		 "font-weight": "bold",
		 "font-size": "16px"
       }).html(myMsg)
       $("#wrap").append(newDiv);

	  newDiv.off().on("click",function(){
        newDiv.remove();
        newDiv.off("click");
     });
}

//득수부호입력체크
function input_check_del(obj)  {
	  re = /[<>`\"\']/gi;
	  if(re.test(obj.value)){
		//alert("특수문자는 입력하실수 없습니다.");
		alert("It is an invalid character.");
		obj.value=obj.value.replace(re,"");
	  }
}

//숫자 체크
function isNumber(s) {
  s += ''; // 문자열로 변환
  s = s.replace(/^\s*|\s*$/g, ''); // 좌우 공백 제거
  if (s == '' || isNaN(s)) return false;
  return true;
}

