<?
class session {

	var $db = null;
    var $totalCnt;
    var $query ; 
    var $where ;     // QUERY 조건문

	function _set(){
		global $db,$admin_info;
		$this->db=$db;
		$this->set_where(); 

	}

    ### QUERY 생성 전 처리  
	function set_where() {
		global $admin_info ;
		$table = "CALL_STATUS";

		foreach($_GET as $_tmp['k'] => $_tmp['v']) {
			${$_tmp['k']} = $_tmp['v'];
		}
		
		if ($ftype !="") {
				$this->where[] =" CALLTYPE ='$ftype'";
		}

		if ($fstatus !="") {
				$this->where[] =" CALLSTAT ='$fstatus'";
		}

 	    if (isset($_GET['word'])==true && $_GET['word']!="") {

		  if ($find) {
			  $this->where[] ="  $find like '%$word%'";	
		  } else {
			  //검색조건이 전체일때 통합검색
			  $where[] ="TELNO like '%$word%'";
			  $where[] ="CALLED  like '%$word%'";

			  $whr=implode(" or ", $where);
              $this->where[] ="($whr)";			
		  }
		}

		$where = "";
		if (is_array($this->where)) {
			$where = " where ".implode(" and ",$this->where);
		}

		$this->query="select * from  CALL_STATUS $where order by CALLDATE desc, CALLTIME desc "; 

	}


	function get_sessionList() {
		global $titSession ; 

		$var= getVars('no,chk,rndval');
		$arrChk=explode(",",$_GET['chkvalue1']);

		$result=mysqli_query($this->db, $this->query) ;
		  //$total=mysqli_num_rows($result);
		$cnt=0;
		//$html .="<tr><td colspan=8>".date("Y-m-d H:i:s")."</td></tr>";
		while ($data=mysqli_fetch_array($result))		{
			$html .="<tr >
					<td class='fc_black'>$data[TELNO]</td>
					<td>$data[CALLDATE]</td>
					<td class='fc_blue2'>$data[CALLTIME]</td>
					<td class='fc_red2'>$data[CALLED]</td>
					<td>$data[RECVIP]</td>
					<td>$data[SENDIP]</td>
					<td class='fc_green'>$data[CALLTYPE]</td>
					<td class='fc_orange2'><span class='go_certification'>$data[CALLSTAT]</span></td>
				</tr>

			";
			$cnt++;

		}

		if ($cnt <1) {
			$html ="<tr><td colspan=8 height='50'>".$titSession['noMsg'] ."</td></tr>";
		}

		$this->totalCnt = $cnt; 

		return $html;

	}



}


?>