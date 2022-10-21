<?

// 클래스

class Page{

	var $page	= array();
	/*
	$page[now]		현재 페이지
	$page[num]		한 페이지에 출력되는 레코드 개수
	$page[total]	전체 페이지 수
	$page[url]		페이지 링크 URL
	$page[navi]		페이지 네비게이션
	$page[prev]		이전페이지 아이콘
	$page[next]		다음페이지 아이콘
	*/
	var $recode	= array();
	/*
	$recode[start]	시작 레코드 번호
	$recode[total]	전체 레코드 수 (전체 글수)
	*/

	var $vars		= array();
	var $field		= "*";			// 가져올 필드
	var $cntQuery	= "";			// 전체 레코드 개수 가져올 쿼리문 (조인시 성능 향상을 위해)
	var $nolimit	= false;		// 참일 경우 전체 데이타 추출
	var $idx		= 0;			// 해당페이지 첫번쩨 레코드 번호값

	var $foo = null;

	function __construct($page=1,$page_num=20)
	{

		$this->vars["page"]= getVars('no,chk,page,password,mode,allchk,chkvalue,ordvalue,x,y');
		$this->page["now"] = ($page<1) ? 1 : $page;
		$this->page["num"] = ($page_num<1) ? 20 : $page_num;
		$this->page["url"] = $_SERVER['PHP_SELF'];
		$this->recode["start"] = ($this->page["now"]-1) * $this->page["num"];
		$this->page["prev"] = "<img src='../../images/btn/btn_prev1.jpg' alt='prev' class='tooltipBox' title='10 pages prev'/>";
		$this->page["next"] = "<img src='../../images/btn/btn_next1.jpg' alt='next' class='tooltipBox' title='10 pages next'/>";
	}

	function getTotal()
	{
		if (!$this->cntQuery){
			//$cnt = (!preg_match("/distinct/i",$this->field)) ? "count(*)" : "count($this->field)";

			if(!preg_match("/distinct/i",$this->field)) $cnt = "count(*)";
			else {
				$temp = explode( ",", $this->field );
				$cnt = "count($temp[0])";
			}
			$this->cntQuery = "select $cnt from $this->db_table $this->where $this->tmpQry";

		}
		//list($this->recode[total]) = $GLOBALS[db]->fetch($this->cntQuery);

		//echo $this->cntQuery."<br>";

		list($this->recode["total"]) = mysqli_fetch_array(mysqli_query($this->db,$this->cntQuery));
	}

	function setTotal()
	{
		$limited = ($this->recode["start"]+$this->page["num"]<$this->recode["total"]) ? $this->page["num"] : $this->recode["total"] - $this->recode["start"];
		if (!$this->nolimit) $this->limit = "limit {$this->recode["start"]},$limited";
		$this->query = "select $this->field from $this->db_table $this->where $this->tmpQry $this->orderby $this->limit";
		$this->idx = $this->recode["total"] - $this->recode["start"];
	}

	function setQuery($db_table,$where='',$orderby='',$tmp='',$totalCnt='')
	{
		$this->db_table = $db_table;
		$this->tmpQry = $tmp;
		if ($where) $this->where = "where ".implode(" and ",$where);
		if (trim($orderby)) $this->orderby = "order by ".$orderby;
		if ($totalCnt=='') {		
			if (!isset($this->recode["total"])) $this->getTotal();
		} else {
			$this->recode["total"] = $totalCnt;
		}
	}

	function exec()
	{
		global $bbs;
		if ($this->foo === null) $this->setTotal();

		$this->page["total"]	= @ceil($this->recode["total"]/$this->page["num"]);
		if ($this->page["total"] && $this->page["now"]>$this->page["total"]) $this->page["now"] = $this->page["total"];
		$page["start"]		= (ceil($this->page["now"]/10)-1)*10;

		$navi .=" <a href='javascript://' onclick=\"javascript:listRefresh('{$this->vars['page']}&page=1{$this->flag}','{$this->listAjax}');allchkNull()\" class='btn'><img src='../../images/btn/btn_prev2.jpg' alt='처음페이지' /></a> ";


		if($this->page["now"]>10){
			$navi .= " <a href='javascript://' onclick=\"javascript:listRefresh('".$this->vars['page']."&page=$page[start]{$this->flag}','{$this->listAjax}');allchkNull()\" class='btn prev'>".$this->page['prev']."</a> ";

		}else {
			$navi .= " <a class='btn prev'>".$this->page['prev']."</a> ";

		}

		while($i+$page["start"]<$this->page["total"]&&$i<10){
			$i++;
			$page["move"] = $i+$page["start"];
			$navi .= ($this->page["now"]==$page["move"]) ? "<a class='num on'>$page[move]</a>" : " <a href='javascript://' onclick=\"javascript:listRefresh('".$this->vars['page']."&page=$page[move]{$this->flag}','{$this->listAjax}');allchkNull()\" class='num'>$page[move]</a> ";
		}

		if($this->page["total"]>$page["move"]){
			$page["next"] = $page["move"]+1;
			$navi .= "	<a href='javascript://' onclick=\"javascript:listRefresh('".$this->vars['page']."&page=$page[next]{$this->flag}','{$this->listAjax}');allchkNull()\" class='btn next'>{$this->page[next]}</a> ";
		} else {
			$navi .= " <a  class='btn next'>{$this->page['next']}</a> ";

		}

		$navi.=" <a href='javascript://' onclick=\"javascript:listRefresh('".$this->vars['page']."&page=".$this->page['total']."{$this->flag}','{$this->listAjax}');allchkNull()\" class='btn'><img src='../../images/btn/btn_next2.jpg' alt='마지막페이지' /></a> ";


		if ($this->recode["total"] && !$this->nolimit) $this->page["navi"] = &$navi;
		if ($this->page["total"]==0) $this->page['now'] = 0; 

	}

	function getNavi($total) {

		$this->recode[total] = $total;
		$this->foo = true;
		$this->exec();

		return $this->page['navi'];

	}

}

?>