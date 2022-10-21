<?
class phone Extends Page {

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
        if (!$_GET["order"]) {
			$this->order="PHONE+0";		
			$this->desc = "" ; 
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
		$this->table = "REGISTER";
		foreach($_GET as $_tmp['k'] => $_tmp['v']) {
			${$_tmp['k']} = $_tmp['v'];
		}

		if ($fclass !="") {
				$this->where[] =" CLASS ='$fclass'";
		}
		if ($fpgroup !="") {
				$this->where[] =" PGROUP ='$fpgroup'";
		}
		if ($ftrunk !="") {
				$this->where[] =" TNUMBER ='$ftrunk'";
		}
 	    if (isset($_GET['word'])==true && $_GET['word']!="") {

		  if ($find) {
			  $this->where[] ="  $find like '%$word%'";	
		  } else {
			  //검색조건이 전체일때 통합검색
			  $where[] ="PHONE like '%$word%'";
			  $where[] ="IPADDR  like '%$word%'";
			  $where[] ="VIA_IPADDR  like '%$word%'";
			  $where[] ="CID  like '%$word%'";
			  $where[] ="USER_ID  like '%$word%'";
			  $where[] ="USERNAME  like '%$word%'";
			  $whr=implode(" or ", $where);
              $this->where[] ="($whr)";			
		  }
		}


	}

    ### 리스트 출력
	function get_ListValue() {
		global $msg,$admin_info, $dateType;


		$arrDND = array("0"=>"Setup", "1"=>"Release");
		$arrCForword =array("0"=>"Release","1"=>"Always","2"=>"Busy","3"=>"No Answer") ; 

		$var= getVars('no,chk,rndval');
		$arrChk=explode(",",$_GET['chkvalue']);

		$res = mysqli_query($this->db,$this->query);

		//$num = $this->recode['total'] - ($this->page['now']-1) * $this->page['num'] + 1;
		$num = ($this->page['now']-1)*$this->page['num'];
		
   		$alevel=array("view"=>$admin_info[$this->levelKey.'_view'], "add"=>$admin_info[$this->levelKey.'_add'], "mod"=>$admin_info[$this->levelKey.'_mod'], "del"=>$admin_info[$this->levelKey.'_del']);

		
		//echo "<tr><td colspan=9>".$this->query."</td></tr>";
		while ($data = mysqli_fetch_array($res)){
			//$num--;
			$num++;

			if ($num%2==0) $bg="style='background-color:#f5f5f5'";
			else $bg="style='background-color:#ffffff'";

			//체크여부처리
			$arrChkOk= array_search(trim($data['PHONE']),$arrChk);
			if ($arrChkOk > 0) {
				$checked="checked";
			}else {
				$checked="";		
			}

			if ($data['REC']=="1") {
		        $rec="OK";
			} else if ($data['REC']=="0") {
		         $rec="NOK";
			} else {
		         $rec="";
			}


			echo "<tr id='$data[PHONE]'  $bg >";
			if ($alevel['del']=="Y") {
			   echo "<td class='notList'><input type='checkbox' name='chk[]' value='".$data['PHONE']."' onclick='selchk(this)' $checked></td>";
			}

			if ($data['IPADDR'] && $data['PORT'] !="") $port="<br>( ".$data['PORT']." )";
			else $port=""; 

			if ($data['VIA_IPADDR'] && $data['VIA_PORT'] !="") $port2="<br>( ".$data['VIA_PORT']." )";
			else $port2=""; 

			echo"<td >$num</td>
				<td class='ta_left pl_10'><span class='fc_black'>".$data['PHONE']."</span></td>
				<td >".$data['IPADDR'].$port."</td>				
				<td >".$data['VIA_IPADDR'].$port2."</td>				
				<td class='ta_left pl_10 fc_purple'>".$data['USER_ID']."</td>
				<td class='ta_left pl_10 fc_blue2'>".$data['USERNAME']."</td>
				<td >".$data['CLASS']."</td>
				<td class='ta_left pl_10'>".$data['CID']."</td>
				<td >".$data['PGROUP']."</td>
				<td class='fc_green'>".$arrDND[$data['DND']]."</td>
				<td class='fc_orange2'>".$arrCForword[$data['CFORWORD']]."</td>
				<td class='fc_red2'>$rec</td>
				<td ><img src='../../images/$data[STATUS].gif'></td>
			</tr>";

		}
	}


}
?>