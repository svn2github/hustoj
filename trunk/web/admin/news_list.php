<?php
require("admin-header.php");
require_once("../include/set_get_key.php");

if(!isset($_SESSION[$OJ_NAME.'_'.'administrator'])){
  echo "<a href='../loginpage.php'>Please Login First!</a>";
  exit(1);
}

if(isset($OJ_LANG)){
  require_once("../lang/$OJ_LANG.php");
}
?>

<title>News List</title>
<hr>
<center><h3><?php echo $MSG_NEWS.$MSG_LIST ?></h3></center>

<div class='container'>

<?php
$sql = "SELECT COUNT('news_id') AS ids FROM `news`";
$result = pdo_query($sql);
$row = $result[0];

$ids = intval($row['ids']);

$idsperpage = 25;
$pages = intval(ceil($ids/$idsperpage));

if(isset($_GET['page'])){ $page = intval($_GET['page']);}
else{ $page = 1;}

$pagesperframe = 5;
$frame = intval(ceil($page/$pagesperframe));

$spage = ($frame-1)*$pagesperframe+1;
$epage = min($spage+$pagesperframe-1, $pages);

$sid = ($page-1)*$idsperpage;

$sql = "";
if(isset($_GET['keyword']) && $_GET['keyword']!=""){
  $keyword = $_GET['keyword'];
  $keyword = "%$keyword%";
  $sql = "SELECT `news_id`,`user_id`,`title`,`time`,`defunct` FROM `news` WHERE (title LIKE ?) OR (content LIKE ?) ORDER BY `news_id` DESC";
  $result = pdo_query($sql,$keyword,$keyword);
}else{
  $sql = "SELECT `news_id`,`user_id`,`title`,`time`,`defunct` FROM `news` ORDER BY `news_id` DESC LIMIT $sid, $idsperpage";
  $result = pdo_query($sql);
}
?>

<form action=news_list.php class="center">
  <input name=keyword><input type=submit value="<?php echo $MSG_SEARCH?>">
</form>

<center>
  <table width=100% border=1 style="text-align:center;">
    <tr style='height:22px;'>
      <td>ID</td>
      <td>TITLE</td>
      <td>UPDATE</td>
      <td>NOW</td>
      <td>COPY</td>
    </tr>
    <?php
    foreach($result as $row){
      echo "<tr style='height:22px;'>";
        echo "<td>".$row['news_id']."</td>";
        echo "<td><a href='news_edit.php?id=".$row['news_id']."'>".$row['title']."</a>"."</td>";
        echo "<td>".$row['time']."</td>";
        echo "<td><a href=news_df_change.php?id=".$row['news_id']."&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey'].">".($row['defunct']=="N"?"<span class=green>On</span>":"<span class=red>Off</span>")."</a>"."</td>";
        echo "<td><a href=news_add_page.php?cid=".$row['news_id'].">Copy</a></td>";
      echo "</tr>";
    }
    ?>
    </form>
  </table>
</center>

<?php
if(!(isset($_GET['keyword']) && $_GET['keyword']!=""))
{
  echo "<div style='display:inline;'>";
  echo "<nav class='center'>";
  echo "<ul class='pagination pagination-sm'>";
  echo "<li class='page-item'><a href='news_list.php?page=".(strval(1))."'>&lt;&lt;</a></li>";
  echo "<li class='page-item'><a href='news_list.php?page=".($page==1?strval(1):strval($page-1))."'>&lt;</a></li>";
  for($i=$spage; $i<=$epage; $i++){
    echo "<li class='".($page==$i?"active ":"")."page-item'><a title='go to page' href='news_list.php?page=".$i.(isset($_GET['my'])?"&my":"")."'>".$i."</a></li>";
  }
  echo "<li class='page-item'><a href='news_list.php?page=".($page==$pages?strval($page):strval($page+1))."'>&gt;</a></li>";
  echo "<li class='page-item'><a href='news_list.php?page=".(strval($pages))."'>&gt;&gt;</a></li>";
  echo "</ul>";
  echo "</nav>";
  echo "</div>";
}
?>

</div>
