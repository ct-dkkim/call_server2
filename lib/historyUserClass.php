<?
class statistic Extends Page {

	var $db = null;
	var $order;      //정렬
	var $desc;       //정렬
	var $temp ;       //group by
    var $where ;     // QUERY 조건문
    var $table ;     //접근 테이블
	var $sdType;     //날짜타입 (system, local)
    ### 리스트 출력 준비 
	function _set() {
		global $member,$db,$_SESSION,$admin_info;
		$this->db=$db;
        $this->table = "CALL_HISTORY";

		$this->field=" TELNO,
		COUNT(TELNO) as totalCnt,
		COALESCE(
			SUM(
				TIME_TO_SEC(TIMEDIFF(CONCAT(ENDDATE,' ',ENDTIME),CONCAT(CALLDATE,' ',CALLTIME)))
			)
		,0)	AS totalDuration,
		count(case when CALLTYPE ='TRK' then TELNO end) as trkCnt,	
		COALESCE(
			SUM(
				case when CALLTYPE ='TRK' then 
				TIME_TO_SEC(TIMEDIFF(CONCAT(ENDDATE,' ',ENDTIME),CONCAT(CALLDATE,' ',CALLTIME)))
				end
			)	
		,0)	AS trkDuration,
		count(case when CALLTYPE ='INC' then TELNO end) as incCnt,	
		COALESCE(
			SUM(
				case when CALLTYPE ='INC' then 
				TIME_TO_SEC(TIMEDIFF(CONCAT(ENDDATE,' ',ENDTIME),CONCAT(CALLDATE,' ',CALLTIME)))
				end
			)	
		,0)	AS incDuration,
		count(case when CALLTYPE ='STN' then TELNO end) as stnCnt,	
		COALESCE(
			SUM(
				case when CALLTYPE ='STN' then 
				TIME_TO_SEC(TIMEDIFF(CONCAT(ENDDATE,' ',ENDTIME),CONCAT(CALLDATE,' ',CALLTIME)))
				end
			)	
		,0)	AS stnDuration";
		$this->temp="GROUP BY TELNO ";
		
		$this->set_where(); 
		$this->setQuery($this->table,$this->where,"TELNO",$this->temp);//this->query 생성
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


 	    if (isset($_GET['word'])==true && $_GET['word']!="") {

		  if ($find) {
			  $this->where[] ="  $find like '%$word%'";	
		  } else {
			  //검색조건이 전체일때 통합검색
			  $wh[] ="TELNO like '%$word%'";

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

			$trkDurationTime = get_time($data['trkDuration']);
			$incDurationTime = get_time($data['incDuration']);
			$stnDurationTime = get_time($data['stnDuration']);
			$totalDurationTime = get_time($data['totalDuration']);

			echo"<tr>
					<td >$num</td>
					<td class='ta_left pl_30'>$data[TELNO]</td>
					<td>$data[trkCnt]</td>
					<td>$trkDurationTime</td>					
					<td>$data[incCnt]</td>
					<td>$incDurationTime</td>
					<td>$data[stnCnt]</td>
					<td>$stnDurationTime</td>
					<td>$data[totalCnt]</td>
					<td>$stnDurationTime</td>
				</tr>";
		}
	}




}
?>