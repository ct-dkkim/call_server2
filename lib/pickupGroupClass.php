<?
class pickupGroup Extends Page {

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
			$this->order="PCODE+0";		
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
		$this->table = "PICKUPGROUP";
		foreach($_GET as $_tmp['k'] => $_tmp['v']) {
			${$_tmp['k']} = $_tmp['v'];
		}



 	    if (isset($_GET['word'])==true && $_GET['word']!="") {

		  if ($find) {
			  $this->where[] ="  $find like '%$word%'";	
		  } else {
			  //검색조건이 전체일때 통합검색
			  $where[] ="PCODE like '%$word%'";
			  $where[] ="PNAME  like '%$word%'";
			  $whr=implode(" or ", $where);
              $this->where[] ="($whr)";			
		  }
		}


	}

    ### 리스트 출력
	function get_ListValue() {
		global $msg,$admin_info, $dateType,$arrRouting;

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
			$arrChkOk= array_search(trim($data['PCODE']),$arrChk);
			if ($arrChkOk > 0) {
				$checked="checked";
			}else {
				$checked="";		
			}


			echo "<tr id='$data[PCODE]'  $bg >";
			if ($alevel['del']=="Y") {
			   echo "<td class='notList'><input type='checkbox' name='chk[]' value='".$data['PCODE']."' onclick='selchk(this)' $checked></td>";
			}

			echo"<td >$num</td>
				<td ><span class='fc_black'>".$data['PCODE']."</span></td>
				<td class='ta_left pl_30 fc_blue2'>".$data['PNAME']."</td>
			</tr>";

		}
	}


}
?>