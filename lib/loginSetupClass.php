<?
class loginSetup Extends Page {

	var $db = null;
	var $order;      //정렬
	var $desc;       //정렬
	var $temp ;       //group by
    var $where ;     // QUERY 조건문
    var $table ;     //접근 테이블

	function setting(){
		global $db;
		$this->db=$db;

        //항목 링크 정렬
        if (!$_GET['order']) {
			$this->order="v_date";		
			$this->desc = "DESC" ; 
		} else {
			$this->order=$_GET['order'];
			$this->desc=$_GET['desc'];

		}

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
		$this->table = "web_admin";
		foreach($_GET as $_tmp['k'] => $_tmp['v']) {
			${$_tmp['k']} = $_tmp['v'];
		}

		if ($flevel !="") {
				$this->where[] =" level ='$flevel'";
		}


 	    if (isset($_GET['word'])==true && $_GET['word']!="") {

		  if ($find) {
			  $this->where[] ="  $find like '%$word%'";	
		  } else {
			  //검색조건이 전체일때 통합검색
			  $where[] ="user_id like '%$word%'";
			  $where[] ="name  like '%$word%'";
			  $where[] ="email  like '%$word%'";
			  $whr=implode(" or ", $where);
              $this->where[] ="($whr)";			
		  }
		}


	}

    ### 리스트 출력
	function get_ListValue() {
		global $msg,$admin_info, $dateType,$aAdminLevel;

		$var= getVars('no,chk,rndval');
		$arrChk=explode(",",$_GET['chkvalue']);

		$res = mysqli_query($this->db,$this->query);

		//$num = $this->recode['total'] - ($this->page['now']-1) * $this->page['num'] + 1;
		$num = ($this->page['now']-1)*$this->page['num'];
		
		
		//echo "<tr><td colspan=9>".$alevel[view]."</td></tr>";
		while ($data = mysqli_fetch_array($res)){
			//$num--;
			$num++;

			if ($num%2==0) $bg="style='background-color:#f5f5f5'";
			else $bg="style='background-color:#ffffff'";

			//체크여부처리
			$arrChkOk= array_search(trim($data['user_id']),$arrChk);
			if ($arrChkOk > 0) {
				$checked="checked";
			}else {
				$checked="";		
			}


			echo "<tr id='$data[no]'  $bg >";
			if ($admin_info['user_level']=="1") {
			   echo "<td class='notList'><input type='checkbox' name='chk[]' value='".$data['user_id']."' onclick='selchk(this)' $checked></td>";
			}

			echo"<td >$num</td>
				<td class='fc_red2'>".$aAdminLevel[$data['level']]."</td>
				<td ><span class='fc_black'>".$data['user_id']."</span></td>
				<td class='fc_blue2'>".$data['name']."</td>

			    <td class='fc_orange2'>".$data['phone_view']."</td>
			    <td class='fc_orange2'>".$data['phone_add']."</td>
			    <td class='fc_orange2'>".$data['phone_mod']."</td>
			    <td class='fc_orange2'>".$data['phone_del']."</td>

			    <td >".$data['routing_view']."</td>
			    <td >".$data['routing_add']."</td>
			    <td >".$data['routing_mod']."</td>
			    <td >".$data['routing_del']."</td>

			    <td class='fc_green'>".$data['conversion_view']."</td>
			    <td class='fc_green'>".$data['conversion_add']."</td>
			    <td class='fc_green'>".$data['conversion_mod']."</td>
			    <td class='fc_green'>".$data['conversion_del']."</td>		
			    
			    <td class='fc_orange2'>".$data['class_view']."</td>
			    <td class='fc_orange2'>".$data['class_add']."</td>
			    <td class='fc_orange2'>".$data['class_mod']."</td>
			    <td class='fc_orange2'>".$data['class_del']."</td>				    

			    <td >".$data['user_view']."</td>
			    <td >".$data['user_add']."</td>
			    <td >".$data['user_mod']."</td>
			    <td >".$data['user_del']."</td>	

			    <td class='fc_green'>".$data['ptt_view']."</td>
			    <td class='fc_green'>".$data['ptt_add']."</td>
			    <td class='fc_green'>".$data['ptt_mod']."</td>
			    <td class='fc_green'>".$data['ptt_del']."</td>				    
			</tr>";

		}
	}


}
?>