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
        $this->table = "CALL_HISTORY";

		$this->field=" * ";
		$this->set_where(); 
		$this->setQuery($this->table,$this->where,"CALLDATE, CALLTIME DESC");//this->query 생성
		$this->exec();

	}

    ### QUERY 생성 전 처리  
	function set_where() {
		global $admin_info ; 
		foreach($_GET as $_tmp['k'] => $_tmp['v']) {
			${$_tmp['k']} = $_tmp['v'];
		}
		

		$st_date=$st_day.$st_time;
		$end_date=$end_day.$end_time;


		if ($st_day) {
			$this->where[] =" CONCAT(CALLDATE,CALLTIME)  >='$st_date'";

		}
		if ($end_day) {
			$this->where[] =" CONCAT(CALLDATE,CALLTIME)  <='$end_date'";
		}



		if ($ftype !="") {
			$this->where[] =" CALLTYPE ='$ftype'";
		}



 	    if (isset($_GET['word'])==true && $_GET['word']!="") {

		  if ($find) {
			  $this->where[] ="  $find like '%$word%'";	
		  } else {
			  //검색조건이 전체일때 통합검색
			  $wh[] ="TELNO like '%$word%'";
			  $wh[] ="CALLED  like '%$word%'";

			  $whr=implode(" or ", $wh);
              $this->where[] ="($whr)";			
		  }
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
			$st_date =  date($dateType, strtotime($data["CALLDATE"]." ".$data['CALLTIME']));
			if (strtotime($data["ENDDATE"]) > 0) {
				$end_date =  date($dateType, strtotime($data["ENDDATE"]." ".$data['ENDTIME']));
			}  else {
				$end_date="";
			}			

			echo"<tr>
					<td >$num</td>
					<td class='ta_left pl_30'>$data[TELNO]</td>
					<td>$st_date</td>
					<td>$end_date</td>
					<td class='ta_left pl_30'>$data[CALLED]</td>
					<td>$data[RECVIP]</td>
					<td>$data[SENDIP]</td>
					<td>$data[CALLTYPE]</td>
					<td class='ta_left pl_30'><span class='go_certification'>$data[CALLSTAT]</span></td>
					<td class='ta_left pl_30'><span class='go_certification'>$data[AVTYPE]</span></td>

				</tr>";
		}
	}




}
?>