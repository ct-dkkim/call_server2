<?
class priTrunk Extends Page {

	var $db = null;
	var $order;      //정렬
	var $desc;       //정렬
	var $temp ;       //group by
    var $where ;     // QUERY 조건문
    var $table ;     //접근 테이블
    var $levelKey;

	function setting(){
		global $db;
		$this->db=$db;

        //항목 링크 정렬
        if (!$_GET['order']) {
			$this->order="IPADDR";		
			$this->desc = "DESC" ; 
		} else {
			$this->order=$_GET['order'];
			$this->desc=$_GET['desc'];

		}
		$this->levelKey =$_GET["fLevelKey"];

	}

    ### 리스트 출력 준비 
	function _set() {
		$this->setting(); 
		$this->field=" * ";
		$this->set_where(); 
		$this->setQuery($this->table,$this->where,$this->order." ".$this->desc, $this->temp);//this->query 생성
		$this->exec();
	}

    ### QUERY 생성 전 처리  
	function set_where() {
		global $admin_info ;
		$this->table = "PRITG";
		foreach($_GET as $_tmp['k'] => $_tmp['v']) {
			${$_tmp['k']} = $_tmp['v'];
		}

		if ($fcType !="") {
				$this->where[] =" CID_NO_TYPE ='$fcType'";
		}
		if ($fbType !="") {
				$this->where[] =" BILL_NO_TYPE ='$fbType'";
		}

 	    if (isset($_GET['word'])==true && $_GET['word']!="") {

		  if ($find) {
			  $this->where[] ="  $find like '%$word%'";	
		  } else {
			  //검색조건이 전체일때 통합검색
			  $where[] ="IPADDR like '%$word%'";
			  $where[] ="USER_NAME  like '%$word%'";
			  $where[] ="START_STN  like '%$word%'";
			  $where[] ="START_TRK  like '%$word%'";
			  $where[] ="CID_NO  like '%$word%'";
			  $where[] ="BILL_NO  like '%$word%'";
			  $whr=implode(" or ", $where);
              $this->where[] ="($whr)";			
		  }
		}


	}

    ### 리스트 출력
	function get_ListValue() {
		global $msg,$admin_info, $dateType,$arrCidType2, $arrBillType2;

		$var= getVars('no,chk,rndval');
		$arrChk=explode(",",$_GET['chkvalue']);

		$res = mysqli_query($this->db,$this->query);

		//$num = $this->recode['total'] - ($this->page['now']-1) * $this->page['num'] + 1;
		$num = ($this->page['now']-1)*$this->page['num'];
		
   		$alevel=array("view"=>$admin_info[$this->levelKey.'_view'], "add"=>$admin_info[$this->levelKey.'_add'], "mod"=>$admin_info[$this->levelKey.'_mod'], "del"=>$admin_info[$this->levelKey.'_del']);

		
		//echo "<tr><td colspan=9>".$alevel[view]."</td></tr>";
		while ($data = mysqli_fetch_array($res)){
			//$num--;
			$num++;

			if ($num%2==0) $bg="style='background-color:#f5f5f5'";
			else $bg="style='background-color:#ffffff'";

			//체크여부처리
			$arrChkOk= array_search(trim($data['IPADDR']),$arrChk);
			if ($arrChkOk > 0) {
				$checked="checked";
			}else {
				$checked="";		
			}

			if ($data['REC']=="1") $rec="V";
			else $rec="";


			echo "<tr id='$data[IPADDR]'  $bg >";
			if ($alevel['del']=="Y") {
			   echo "<td class='notList'><input type='checkbox' name='chk[]' value='".$data['IPADDR']."' onclick='selchk(this)' $checked></td>";
			}

			echo"<td >$num</td>
				<td class='ta_left pl_10'><span class='fc_black'>".$data['IPADDR']."</span></td>
				<td >".$data['PORT']."</td>				
				<td class='ta_left pl_10 fc_blue2'>".$data['USER_NAME']."</td>
				<td class='ta_left pl_10'>".$data['START_STN']."</td>
				<td class='ta_left pl_10'>".$data['START_TRK']."</td>
				<td >".$data['P_RANGE']."</td>
				<td class='ta_left pl_10'>".$data['CID_NO']."</td>
				<td class='fc_orange2'>".$arrCidType2[$data['CID_NO_TYPE']]."</td>
				<td class='ta_left pl_10'>".$data['BILL_NO']."</td>
				<td class='fc_green'>".$arrBillType2[$data['BILL_NO_TYPE']]."</td>
				<td class='fc_red2'>$rec</td>
			</tr>";

		}
	}


}
?>