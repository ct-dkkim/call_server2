<?
class classCode {

	var $db = null;
	var $keyClass ; 
	var $keyClassTitle ; 
    var $levelKey;
    var $alevel;

	function _set(){
		global $db,$admin_info;
		$this->db=$db;
		$this->levelKey =$_GET["fLevelKey"];

   		$this->alevel=array("view"=>$admin_info[$this->levelKey.'_view'], "add"=>$admin_info[$this->levelKey.'_add'], "mod"=>$admin_info[$this->levelKey.'_mod'], "del"=>$admin_info[$this->levelKey.'_del']);

	}



	function get_classList() {

		$var= getVars('no,chk,rndval');
		$arrChk=explode(",",$_GET['chkvalue1']);

		$sql="select * from CLASS $where order by CLASS ";
		$result=mysqli_query($this->db, $sql) ;
		  //$total=mysqli_num_rows($result);
		$cnt=1;
		while ($data=mysqli_fetch_array($result))		{

			//체크여부처리
			$arrChkOk= array_search(trim($data['CLASS']),$arrChk);
			if ($arrChkOk > 0) {
				$checked="checked";
			}else {
				$checked="";		
			}

			if ($this->keyClass=="" && $cnt==1) {
				$this->keyClass = $data['CLASS']; 
				$this->keyClassTitle = "[".$data['CLASS'] ."] ". $data['EXPLAN']; 
			}

			if ($this->keyClass==trim($data['CLASS'])) {
				$bg="bgcolor='#83c5da'";
				$this->keyClassTitle = "[".$data['CLASS'] ."] ". $data['EXPLAN']; 
			} else {
				$bg="";
			}

			$html .="<tr id='".trim($data['CLASS'])."'  $bg>";
			if ($this->alevel['del']=="Y") {
				$html .="	<td class='notList'>
					 <input type='checkbox' name='chk1[]' value='".$data['CLASS']."' onclick='selchk9(this,1)' $checked ></td>";
			}

			$html.="
					<td>$cnt</td>
					<td class='fc_black'>$data[CLASS]</td>
					<td class='ta_left pl_30 fc_red2'><span class='go_certification'>$data[EXPLAN]</span></td>
				</tr>

			";
			$cnt++;

		}

		return $html;

	}


	function get_useClassList() {

		$var= getVars('no,chk,rndval');
		$arrChk=explode(",",$_GET['chkvalue2']);

		$sql="select * from USECLASS where CLASS='".$this->keyClass."' order by USECODE  ";
		$result=mysqli_query($this->db, $sql) ;
		  //$total=mysqli_num_rows($result);
		$cnt=1;

		//echo "<tr><td colspan=2>".$_GET['keyClass']."//". $sql."</td></tr>";
		while ($data=mysqli_fetch_array($result))		{

			//체크여부처리
			$arrChkOk= array_search(trim($data['USECODE']),$arrChk);
			if ($arrChkOk > 0) {
				$checked="checked";
			}else {
				$checked="";		
			}



			$html .="<tr id='$data[USECODE]'>";

			if ($this->alevel['del']=="Y") {
				$html .="	<td class='notList'>					
					<input type='checkbox' name='chk2[]' value='".$data['USECODE']."' onclick='selchk9(this,2)' $checked  >						
					</td>";
			}

			$html.="					
					<td>$cnt</td>
					<td class='ta_left pl_30 fc_blue2'><span class='go_certification'>$data[USECODE]</span></td>
				</tr>

			";
			$cnt++;

		}

		return $html;

	}





	function get_limitClassList() {

		$var= getVars('no,chk,rndval');
		$arrChk=explode(",",$_GET['chkvalue3']);

		$sql="select * from LIMITCLASS where CLASS='".$this->keyClass."' order by LIMITCODE  ";
		$result=mysqli_query($this->db, $sql) ;
		  //$total=mysqli_num_rows($result);
		$cnt=1;
		while ($data=mysqli_fetch_array($result))		{

			//체크여부처리
			$arrChkOk= array_search(trim($data['LIMITCODE']),$arrChk);
			if ($arrChkOk > 0) {
				$checked="checked";
			}else {
				$checked="";		
			}



			$html .="
				<tr id='$data[LIMITCODE]'>";

			if ($this->alevel['del']=="Y") {
				$html .="						<td class='notList'>
						<input type='checkbox' name='chk3[]' value='".$data['LIMITCODE']."' onclick='selchk9(this,3)' $checked  >

					</td>";
			}

			$html.="						

					<td>$cnt</td>
					<td class='ta_left pl_30 fc_orange2'><span class='go_certification'>$data[LIMITCODE]</span></td>
				</tr>

			";
			$cnt++;

		}

		return $html;

	}	

}


?>