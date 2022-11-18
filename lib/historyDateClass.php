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

		$this->field=" CALLDATE, 
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
		$this->temp="GROUP BY CALLDATE ";
		
		$this->set_where(); 
		$this->setQuery($this->table,$this->where,"CALLDATE",$this->temp);//this->query 생성
		$this->exec();


	}

    ### QUERY 생성 전 처리  
	function set_where() {
		global $admin_info ; 
		foreach($_GET as $_tmp['k'] => $_tmp['v']) {
			${$_tmp['k']} = $_tmp['v'];
		}
		

		$

		$st_date=$fyear.'-'.$fmonth;
		

		if ($st_day) {
			$this->where[] =" left(CALLDATE,7) ='$st_date'";

		}

	}

    ### 리스트 출력
	function get_ListValue() {
		global $msg, $aLogItem, $admin_info,$aLogAction,$dateType,$config,$tit;

		$var= getVars('no,chk,rndval');
		$res = mysqli_query($this->db,$this->query);

		//$num = $this->recode['total'] - ($this->page['now']-1) * $this->page['num'] + 1;
		$num = ($this->page['now']-1)*$this->page['num'];


		$totCnt=0;
		$totCnt1=0;
		$totCnt4=0;
		$totCnt8=0;
		$totTime=0;
		$totTime1=0;
		$totTime4=0;
		$totTime8=0;
		
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
					<td class='ta_left pl_30'>$data[CALLDATE]</td>
					<td>$data[trkCnt]</td>
					<td>$trkDurationTime</td>					
					<td>$data[incCnt]</td>
					<td>$incDurationTime</td>
					<td>$data[stnCnt]</td>
					<td>$stnDurationTime</td>
					<td>$data[totalCnt]</td>
					<td>$stnDurationTime</td>
				</tr>";

				$totCnt += $data['totalCnt'];
				$totCnt1 += $data['trkCnt'];
				$totCnt4 += $data['incCnt'];
				$totCnt8 += $data['stnCnt'];
				$totTime += $data['totalDuration'];
				$totTime1 += $data['trkDuration'];
				$totTime4 += $data['incDuration'];
				$totTime8 += $data['stnDuration'];
		}

		$totTime1HMS = get_time($totTime1);
		$totTime4HMS = get_time($totTime4);
		$totTime8HMS = get_time($totTime8);
		$totTimeHMS = get_time($totTime);



		
		echo"<tr>
					<td colspan=2 >Total</td>
					<td>$totCnt1</td>
					<td>$totTime1HMS</td>					
					<td>$totCnt4</td>
					<td>$totTime4HMS</td>
					<td>$totCnt8</td>
					<td>$totTime8HMS</td>
					<td>$totCnt</td>
					<td>$totTimeHMS</td>
		</tr>";

	}




}
?>