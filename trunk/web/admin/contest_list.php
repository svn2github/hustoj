<?php require("admin-header.php");

        if(isset($OJ_LANG)){
                require_once("../lang/$OJ_LANG.php");
        }


echo "<title>Problem List</title>";
echo "<div class=\"container\">";
require_once("../include/set_get_key.php");
$sql="SELECT max(`contest_id`) as upid, min(`contest_id`) as btid  FROM `contest`";
$page_cnt=50;
$result=pdo_query($sql);
$row=$result[0];
$base=intval($row['btid']);
$cnt=intval($row['upid'])-$base;
$cnt=intval($cnt/$page_cnt)+(($cnt%$page_cnt)>0?1:0);
if (isset($_GET['page'])){
        $page=intval($_GET['page']);
}else $page=$cnt;
$pstart=$base+$page_cnt*intval($page-1);
$pend=$pstart+$page_cnt;
/*
for ($i=1;$i<=$cnt;$i++){
        if ($i>1) echo '&nbsp;';
        if ($i==$page) echo "<span class=red>$i</span>";
        else echo "<a href='contest_list.php?page=".$i."'>".$i."</a>";
}
*/
$sql="";
if(isset($_GET['keyword'])){
	$keyword=$_GET['keyword'];
	$keyword="%$keyword%";
	 $sql="select `contest_id`,`title`,`start_time`,`end_time`,`private`,`defunct` FROM `contest` where title like ? ";
	 $result=pdo_query($sql,$keyword);
}else{
     $sql="select `contest_id`,`title`,`start_time`,`end_time`,`private`,`defunct` FROM `contest` where contest_id>=? and contest_id <=? order by `contest_id` desc";
	 $result=pdo_query($sql,$pstart,$pend);
}
?>
<div style="float:left;">
<form action=contest_list.php class="pagination" ><input name=keyword><input type=submit value="<?php echo $MSG_SEARCH?>" ></form>
</div><div style="display:inline;">
<nav class="center"><ul class="pagination">
<li class="page-item"><a href="contest_list.php?page=1">&lt;&lt;</a></li>
<?php
if(!isset($page)) $page=1;
$page=intval($page);
$section=3;
$start=$page>$section?$page-$section:1;
$end=$page+$section>$cnt?$cnt:$page+$section;
for ($i=$start;$i<=$end;$i++){
 echo "<li class='".($page==$i?"active ":"")."page-item'>
            <a title='go to page' href='contest_list.php?page=".$i.(isset($_GET['my'])?"&my":"")."'>".$i."</a></li>";
}
?>
<li class="page-item"><a href="contest_list.php?page=<?php echo $cnt?>">&gt;&gt;</a></li>
</ul>
</nav>
</div>
<?php
echo "<center><table class='table table-striped' width=90% border=1>";
echo "<tr><td>ContestID<td>Title<td>StartTime<td>EndTime<td>Private<td>Status<td>Edit<td>Copy<td>Export<td>Logs";
echo "</tr>";
foreach($result as $row){
        echo "<tr>";
        echo "<td>".$row['contest_id'];
        echo "<td><a href='../contest.php?cid=".$row['contest_id']."'>".$row['title']."</a>";
        echo "<td>".$row['start_time'];
        echo "<td>".$row['end_time'];
        $cid=$row['contest_id'];
        if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'."m$cid"])){
                echo "<td><a href=contest_pr_change.php?cid=".$row['contest_id']."&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey'].">".($row['private']=="0"?"<span class=green>Public</span>":"<span class=red>Private<span>")."</a>";
                echo "<td><a href=contest_df_change.php?cid=".$row['contest_id']."&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey'].">".($row['defunct']=="N"?"<span class=green>Available</span>":"<span class=red>Reserved</span>")."</a>";
                echo "<td><a href=contest_edit.php?cid=".$row['contest_id'].">Edit</a>";
                echo "<td><a href=contest_add.php?cid=".$row['contest_id'].">Copy</a>";
                if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])){
                        echo "<td><a href=\"problem_export_xml.php?cid=".$row['contest_id']."&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey']."\">Export</a>";
                }else{
                  echo "<td>";
                }
     echo "<td> <a href=\"../export_contest_code.php?cid=".$row['contest_id']."&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey']."\">Logs</a>";
        }else{
                echo "<td colspan=5 align=right><a href=contest_add.php?cid=".$row['contest_id'].">Copy</a><td>";

        }

        echo "</tr>";
}
echo "</table></center></div>";
require("../oj-footer.php");
?>
