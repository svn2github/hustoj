<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $view_title?></title>
	<link rel=stylesheet href='./template/<?php echo $OJ_TEMPLATE?>/mario.css'type='text/css'>
</head>
<style>
button {
     marging:7px;
     background-color: #4169E1;
     border-color: #8DEEEE;
     -moz-border-radius: 10px;  
     -webkit-border-radius: 10px;  
     border-radius: 10px;
     -khtml-border-radius: 10px;
      text-align: center;  
     vertical-align: middle;  
     border: 1px solid transparent;  
     font-weight: 900;  
     font-size:125%;
    font-color:white;
}
a{color:white;}
</style>
<body>
<div id="wrapper">
	<?php
	if(isset($_GET['id']))	require_once("oj-header.php");
	else	require_once("contest-header.php");?>
<div id=main>
  <?php  if($pr_flag){
        echo "<title>$MSG_PROBLEM".$row['problem_id']."--". $row['title']."</title>";
        echo "<center><h1>$id: ".$row['title']."</h1>";
      }else{
        //$PID="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $id=$row['problem_id'];
        echo "<title>$MSG_PROBLEM ".$PID[$pid].": ".$row['title']." </title>";
        echo "<center><h1>$MSG_PROBLEM ".$PID[$pid].": ".$row['title']."</h1>";
      }?>
      <span style='font-size:37px; font-weight:bold'><?php echo $MSG_Time_Limit.':'.$row['time_limit'];?>S</span>
      <span style='font-size:37px; font-weight:bold'><?php echo $MSG_Memory_Limit.':'.$row['memory_limit'];?>MB</span>
      <?php  if($row['spj']) echo "<h1 style='color:red; font-weight:bold'>本题由智能判题机加持哦(*^_^*)</h1>";?>
      <div class="info">
        <span class=green>提交人次:<?php echo $row['submit'];?></span>
        <span class=green>通过人次:<?php echo $row['accepted'];?></span>
        <span class=green>通过率:<?php echo round($row['accepted']*100/$row['submit']);?>%</span>
        <span>得分:<?php echo round(100*$rsmt[0]['pass_rate']);?></span>
      </div>
<?php   if($pr_flag){
        echo "<button><a href='submitpage.php?id=$id'>+$MSG_SUBMIT</a></button>";
      }else{
        echo "<button><a href='submitpage.php?cid=$cid&pid=$pid&langmask=$langmask'>$MSG_SUBMIT</a></button> ";
      }
      echo "<button><a href='problemstatus.php?id=".$row['problem_id']."'>$MSG_STATUS</a></button> ";
      echo "<button><a href='bbs.php?pid=".$row['problem_id']."$ucid'>$MSG_BBS</a></button>";
      echo "$MSG_Creator:<span id='creator'></span>";
      if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])){
        require_once("include/set_get_key.php");
      ?>
      <button><a href="admin/problem_edit.php?id=<?php echo $id?>&getkey=<?php echo $_SESSION[$OJ_NAME.'_'.'getkey']?>" >Edit</a></button>
      <button><a href='javascript:phpfm(<?php echo $row['problem_id'];?>)'>TestData</a></button>
    <?php
    }
    echo "</center>";
    echo "<h2>$MSG_Description</h2><div class=content>".$row['description']."</div><br>";
    if($row['input'])echo "<h2>$MSG_Input</h2><div class=content>".$row['input']."</div><br>";
    if($row['output'])echo "<h2>$MSG_Output</h2><div class=content>".$row['output']."</div><br>";
    $sinput=str_replace("<","&lt;",$row['sample_input']);
    $sinput=str_replace(">","&gt;",$sinput);
    $soutput=str_replace("<","&lt;",$row['sample_output']);
    $soutput=str_replace(">","&gt;",$soutput);
    if(strlen($sinput))
      echo "<h2>$MSG_Sample_Input</h2><div class=content><pre>".($sinput)."</pre></div><br>";
    if(strlen($soutput))
      echo "<h2>$MSG_Sample_Output</h2><div class=content><pre>".($soutput)."</pre></div><br>";
    if($row['hint'])
      echo "<h2>$MSG_HINT</h2><div class='hint content'>".$row['hint']."</div><br>";
    if($pr_flag){
      echo "<h2>$MSG_SOURCE</h2><div class=content>";
      $cats=explode(" ",$row['source']);
      foreach($cats as $cat){
        echo "<a style='color:black' href='problemset.php?search=".urlencode(htmlentities($cat,ENT_QUOTES,'utf-8'))."'>".htmlentities($cat,ENT_QUOTES,'utf-8')."</a>&nbsp;";
      }
      echo "</div><br>";
    }
    echo "<center>";
    if($pr_flag){
        echo "<button><a href='submitpage.php?id=$id'>+$MSG_SUBMIT</a></button>";
      }else{
        echo "<button><a href='submitpage.php?cid=$cid&pid=$pid&langmask=$langmask'>$MSG_SUBMIT</a></button> ";
      }
      echo "<button><a href='problemstatus.php?id=".$row['problem_id']."'>$MSG_STATUS</a></button> ";
      echo "<button><a href='bbs.php?pid=".$row['problem_id']."$ucid'>$MSG_BBS</a></button>";
    if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])){
      require_once("include/set_get_key.php");
    ?>
    <button><a href="admin/problem_edit.php?id=<?php echo $id?>&getkey=<?php echo $_SESSION[$OJ_NAME.'_'.'getkey']?>" >Edit</a></button>
    <button><a href='javascript:phpfm(<?php echo $row['problem_id'];?>)'>TestData</a></button>
  <?php
  }
  echo "</center>";
  ?>
    </div>
  </div> <!-- /container -->
  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <?php include("template/$OJ_TEMPLATE/js.php");?>  
  <script>
  function phpfm(pid){
    //alert(pid);
    $.post("admin/phpfm.php",{'frame':3,'pid':pid,'pass':''},function(data,status){
      if(status=="success"){
        document.location.href="admin/phpfm.php?frame=3&pid="+pid;
      }
    });
  }
  $(document).ready(function(){
    $("#creator").load("problem-ajax.php?pid=<?php echo $id?>");
  });
  </script>
</body>
</html>

