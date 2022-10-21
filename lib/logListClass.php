<?
class statistic Extends Page {

	var $db = null;
	var $order;      //정렬
	var $desc;       //정렬
    var $where ;     // QUERY 조건문
    var $table ;     //접근 테이블
	var $sdType;     //날짜타입 (system, local)
    ### 리스트 출력 준비 
	function _set() {
		global $member,$db,$_SESSION,$admin_info;
		$this->db=$db;
		$this->field=" * ";
		$this->set_where(); 
		$this->setQuery($this->table,$this->where,"REGTIME DESC");//this->query 생성
		$this->exec();

	}

    ### QUERY 생성 전 처리  
	function set_where() {
		global $admin_info ; 
        $this->table = "PTTLOG";
		$st_day=txt_filter(trim($_GET['st_day']));
		$end_day=txt_filter(trim($_GET['end_day']));
		$logtype=txt_filter(trim($_GET['logtype']));   //"1"=>"Login/Modifiy","2"=>"LoginSetup","3"=>"PTT PHONE","4"=>"PTT GROUP","5"=>"Commend Center","6"=>"Recording Server","7"=>"history"
		$logsub=txt_filter(trim($_GET['logsub']));   //add,mod,del ($aLogSub)
		$word=txt_filter(trim($_GET['word']));

		//자기 프로젝트 정보만 



		$st_day.= " 00:00:00";
		$end_day.= " 23:59:59";

		if ($st_day) {
			$this->where[] =" REGTIME >='$st_day'";
		}
		if ($end_day) {

			$this->where[] =" REGTIME <='$end_day '";
		}
		if ($logtype) {
			$this->where[] =" ITEM ='$logtype'";
		}
		if ($logtype && $logsub) {
			$this->where[] =" ACTION ='$logsub'";
		}
		if ($word) {
			$this->where[]=sprintf(" (TARGET like '%s' or RESULT like '%s' )","%$word%","%$word%");
		}

	}

    ### 리스트 출력
	function get_ListValue() {
		global $msg, $aLogItem, $admin_info,$aLogAction,$dateType,$config,$tit;

		$var= getVars('no,chk,rndval');
		$res = mysqli_query($this->db,$this->query);

		//$num = $this->recode['total'] - ($this->page['now']-1) * $this->page['num'] + 1;
		$num = ($this->page['now']-1)*$this->page['num'];
		
		//echo "<tr><td colspan=10>".$this->query."</td></tr>";
		while ($data = mysqli_fetch_array($res)){
			//$num--;
			$num++;
			if ($data['SUB_ITEM']!='')  $title=$tit['mainTitle'][$data['SUB_ITEM']];
			else $title=$aLogItem[$data['ITEM']];

			echo "<tr id='".$data['NO']."'>
			    <td  class='line'>$num</td><td class='fc_blue2'>" ;
			echo date($dateType, strtotime($data['REGTIME']));
			echo "</td>";
            echo "<td class='fc_orange'>".$data['USERID']."</td>
				<td >".$data['USERIP']."</td>
                <td class='ta_left pl_10 '>".$title."</td>
                <td class='ta_left pl_10 fc_black'>". str_replace('<','&lt;',$data['TARGET'])." </td>
                <td class='fc_red2'>".$aLogAction[$data['ITEM']][trim($data['ACTION'])]."</td>
                <td class='ta_left pl_10'>".$data['RESULT']."</td>
			    </tr>";
		}
	}




}
?>