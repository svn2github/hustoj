<?php 
	$OJ_CACHE_SHARE=false;
	$cache_time=60;
	require_once('./include/db_info.inc.php');
	require_once('./include/cache_start.php');
	require_once('./include/setlang.php');
    $view_title= "Problem Set";
    
$sql="SELECT max(`problem_id`) as upid FROM `problem`";
$page_cnt=100;
$result=mysql_query($sql);
echo mysql_error();
$row=mysql_fetch_object($result);
$cnt=intval($row->upid)-1000;
$cnt=$cnt/$page_cnt;

  //remember page
  $page="1";
if (isset($_GET['page'])){
    $page=intval($_GET['page']);
    if(isset($_SESSION['user_id'])){
         $sql="update users set volume=$page where user_id='".$_SESSION['user_id']."'";
         mysql_query($sql);
    }
}else{
    if(isset($_SESSION['user_id'])){
            $sql="select volume from users where user_id='".$_SESSION['user_id']."'";
            $result=@mysql_query($sql);
            $row=mysql_fetch_array($result);
            $page=intval($row[0]);
    }
    if(!is_numeric($page))
        $page='1';
}
  //end of remember page



$pstart=1000+$page_cnt*intval($page)-$page_cnt;
$pend=$pstart+$page_cnt;

$sub_arr=Array();
// submit
if (isset($_SESSION['user_id'])){
$sql="SELECT `problem_id` FROM `solution` WHERE `user_id`='".$_SESSION['user_id']."'".
                                                                       //  " AND `problem_id`>='$pstart'".
                                                                       // " AND `problem_id`<'$pend'".
	" group by `problem_id`";
$result=@mysql_query($sql) or die(mysql_error());
while ($row=mysql_fetch_array($result))
	$sub_arr[$row[0]]=true;
}

$acc_arr=Array();
// ac
if (isset($_SESSION['user_id'])){
$sql="SELECT `problem_id` FROM `solution` WHERE `user_id`='".$_SESSION['user_id']."'".
                                                                       //  " AND `problem_id`>='$pstart'".
                                                                       //  " AND `problem_id`<'$pend'".
	" AND `result`=4".
	" group by `problem_id`";
$result=@mysql_query($sql) or die(mysql_error());
while ($row=mysql_fetch_array($result))
	$acc_arr[$row[0]]=true;
}

if(isset($_GET['search'])&&trim($_GET['search'])!=""){
	$search=mysql_real_escape_string($_GET['search']);
    $filter_sql=" ( title like '%$search%' or source like '%$search%')";
    
}else{
     $filter_sql="  `problem_id`>='".strval($pstart)."' AND `problem_id`<'".strval($pend)."' ";
}

if (isset($_SESSION['administrator'])){
	
	$sql="SELECT `problem_id`,`title`,`source`,`submit`,`accepted` FROM `problem` WHERE $filter_sql ";
	
}
else{
	$sql="SELECT `problem_id`,`title`,`source`,`submit`,`accepted` FROM `problem` ".
	"WHERE `defunct`='N' and $filter_sql AND `problem_id` NOT IN(
		SELECT `problem_id` FROM `contest_problem` WHERE `contest_id` IN (
			SELECT `contest_id` FROM `contest` WHERE 
			(`end_time`>NOW() or private=1)and `defunct`='N'
			
		)
	) ";

}
$sql.=" ORDER BY `problem_id`";


$result=mysql_query($sql) or die(mysql_error());

$view_total_page=$cnt+1;

$cnt=0;
$view_problemset=Array();
$i=0;
while ($row=mysql_fetch_object($result)){
	
	
	$view_problemset[$i]=Array();
	if (isset($sub_arr[$row->problem_id])){
		if (isset($acc_arr[$row->problem_id])) 
			$view_problemset[$i][0]="<span class=yes>Y</span>";
		else 
			$view_problemset[$i][0]= "<span class=no>N</span>";
	}else{
		$view_problemset[$i][0]= "<span class=none> </span>";
	}
	$view_problemset[$i][1]="<span class='center'>".$row->problem_id."</span>";;
	$view_problemset[$i][2]="<span class='left'><a href='problem.php?id=".$row->problem_id."'>".$row->title."</a></span>";;
	$view_problemset[$i][3]="<span class='center'><nobr>".mb_substr($row->source,0,8,'utf8')."</nobr></span>";
	$view_problemset[$i][4]="<span class='center'><a href='status.php?problem_id=".$row->problem_id."&jresult=4'>".$row->accepted."</a></span>";
	$view_problemset[$i][5]="<span class='center'><a href='status.php?problem_id=".$row->problem_id."'>".$row->submit."</a></span>";
	
	
	$i++;
}
mysql_free_result($result);


require("template/".$OJ_TEMPLATE."/problemset.html");
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>
