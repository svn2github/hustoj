<?
	require_once("oj-header.php");
	require_once("./include/db_info.inc.php");
	echo "<title>Welcome To Online Judge</title>";
	$sql=	"SELECT * "
			."FROM `news` "
			."WHERE `defunct`!='Y'"
			."ORDER BY `importance` ASC,`time` DESC "
			."LIMIT ".strval($_GET['pageid']*5).",5";
	$result=mysql_query($sql);//mysql_escape_string($sql));
	if (!$result){
		echo "<h3>No News Now!</h3>";
		echo mysql_error();
	}else{
		echo "<table width=96%><tr><td width=20%><td><font size=16 color=blue>News...</font></tr>";
		while ($row=mysql_fetch_object($result)){
			echo "<tr><td><td><font color=red><b>".$row->user_id."</b>:".$row->title."</font></tr>";
			echo "<tr><td><td>".$row->content."</tr>";
		}
		echo "</table>";
	}
	require("oj-footer.php");
?>
