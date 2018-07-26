<?php
require("admin-header.php");
require_once("../include/set_get_key.php");

if(!(isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'.'contest_creator'])||isset($_SESSION[$OJ_NAME.'_'.'problem_editor']))){
  echo "<a href='../loginpage.php'>Please Login First!</a>";
  exit(1);
}

if(isset($OJ_LANG)){
  require_once("../lang/$OJ_LANG.php");
}
?>

<title>Problem List</title>
<hr>
<center><h3><?php echo $MSG_PROBLEM.$MSG_LIST?></h3></center>

<div class='container'>

<?php
$sql = "SELECT COUNT('problem_id') AS ids FROM `problem`";
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
  $sql = "SELECT `problem_id`,`title`,`accepted`,`in_date`,`defunct` FROM `problem` WHERE (problem_id LIKE ?) OR (title LIKE ?) OR (description LIKE ?) OR (source LIKE ?)";
  $result = pdo_query($sql,$keyword,$keyword,$keyword,$keyword);
}else{
  $sql = "SELECT `problem_id`,`title`,`accepted`,`in_date`,`defunct` FROM `problem` ORDER BY `problem_id` DESC LIMIT $sid, $idsperpage";
  $result = pdo_query($sql);
}
?>

<form action=problem_list.php class="center">
  <input name=keyword><input type=submit value="<?php echo $MSG_SEARCH?>">
</form>

<?php
/*
echo "<select class='input-mini' onchange=\"location.href='problem_list.php?page='+this.value;\">";
for ($i=1;$i<=$cnt;$i++){
        if ($i>1) echo '&nbsp;';
        if ($i==$page) echo "<option value='$i' selected>";
        else  echo "<option value='$i'>";
        echo $i+9;
        echo "**</option>";
}
echo "</select>";
*/
?>

<center>
<table width=100% border=1 style="text-align:center;">
  <form method=post action=contest_add.php>
    <tr>
      <td width=60px>ID <input type=checkbox style='vertical-align:2px;' onchange='$("input[type=checkbox]").prop("checked", this.checked)'></td>
      <td>TITLE</td>
      <td>AC</td>
      <td>UPDATE</td>
      <?php
      if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'.'problem_editor'])){
        if(isset($_SESSION[$OJ_NAME.'_'.'administrator']))
          echo "<td>STATUS</td><td>DELETE</td>";
        echo "<td>EDIT</td><td>TESTDATA</td>";
      }
      ?>
    </tr>
    <?php
    foreach($result as $row){
      echo "<tr>";
        echo "<td>".$row['problem_id']." <input type=checkbox style='vertical-align:2px;' name='pid[]' value='".$row['problem_id']."'></td>";
        echo "<td><a href='../problem.php?id=".$row['problem_id']."'>".$row['title']."</a></td>";
        echo "<td>".$row['accepted']."</td>";
        echo "<td>".$row['in_date']."</td>";
        if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'.'problem_editor'])){
          if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])){
            echo "<td><a href=problem_df_change.php?id=".$row['problem_id']."&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey'].">".($row['defunct']=="N"?"<span titlc='click to reserve it' class=green>Available</span>":"<span class=red title='click to be available'>Reserved</span>")."</a><td>";
            if($OJ_SAE||function_exists("system")){
    ?>
              <a href=# onclick='javascript:if(confirm("Delete?")) location.href="problem_del.php?id=<?php echo $row['problem_id']?>&getkey=<?php echo $_SESSION[$OJ_NAME.'_'.'getkey']?>"'>Delete</a>
        <?php
        }
      }
      if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'."p".$row['problem_id']])){
        echo "<td><a href=problem_edit.php?id=".$row['problem_id']."&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey'].">Edit</a>";
        echo "<td><a href='javascript:phpfm(".$row['problem_id'].");'>TestData</a>";
      }
    }
    echo "</tr>";
  }
?>
    <tr>
      <td colspan=2 style="height:40px;">Checked to</td>
      <td colspan=6>
        <input type=submit name='problem2contest' value='New Contest'>
        <input type=submit name='enable' value='Available' onclick='$("form").attr("action","problem_df_change.php")'>
        <input type=submit name='disable' value='Reserved' onclick='$("form").attr("action","problem_df_change.php")'>
      </td>
    </tr>
  </form>
</table>
</center>

<script src='../template/bs3/jquery.min.js' ></script>

<script>
function phpfm(pid){
  //alert(pid);
  $.post("phpfm.php",{'frame':3,'pid':pid,'pass':''},function(data,status){
    if(status=="success"){
      document.location.href="phpfm.php?frame=3&pid="+pid;
    }
  });
}
</script>
</div>

<?php
if(!(isset($_GET['keyword']) && $_GET['keyword']!=""))
{
  echo "<div style='display:inline;'>";
  echo "<nav class='center'>";
  echo "<ul class='pagination pagination-sm'>";
  echo "<li class='page-item'><a href='problem_list.php?page=".(strval(1))."'>&lt;&lt;</a></li>";
  echo "<li class='page-item'><a href='problem_list.php?page=".($page==1?strval(1):strval($page-1))."'>&lt;</a></li>";
  for($i=$spage; $i<=$epage; $i++){
    echo "<li class='".($page==$i?"active ":"")."page-item'><a title='go to page' href='problem_list.php?page=".$i.(isset($_GET['my'])?"&my":"")."'>".$i."</a></li>";
  }
  echo "<li class='page-item'><a href='problem_list.php?page=".($page==$pages?strval($page):strval($page+1))."'>&gt;</a></li>";
  echo "<li class='page-item'><a href='problem_list.php?page=".(strval($pages))."'>&gt;&gt;</a></li>";
  echo "</ul>";
  echo "</nav>";
  echo "</div>";
}
?>

</div>
