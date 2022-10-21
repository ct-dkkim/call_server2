<?
//header('Content-Type: text/html; charset=euc-kr ');
include_once dirname(__FILE__) . "/../../lib/setConfig.php";
$key=$_POST['key'];

echo $_SESSION[$key];
?>