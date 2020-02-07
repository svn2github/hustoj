<?php 
function make($str) {
    $newstr = $str;
    $newstr = preg_replace("/<p.*?>|<\/p>/is","", $newstr);
    $newstr = preg_replace("/<div.*?>|<\/div>/is","", $newstr);
    /*$newstr = preg_replace("/<span.*?>|<\/span>/is","", $newstr);*/
    return $newstr;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>问题 - MasterOJ</title>
        <?php require("./template/bshark/header-files.php");?>
    </head>
    
    <body>
        <?php require("./template/bshark/nav.php");?>
        <div class="card" style="margin: 3% 10% 5% 10%">
  <div class="card-body">
    <?php
				if ( $pr_flag ) {
					echo "<h3>P$id: " . $row[ 'title' ] . "</h3>";
				} else {
					//$PID="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
					$id = $row[ 'problem_id' ];
					echo "<h3>$MSG_PROBLEM " . $PID[ $pid ] . ": " . $row[ 'title' ] . "</h3>";
				}
				echo "评测方式:";
				if ( $row[ 'spj' ] )echo "Special Judge";
				else echo "Normal";
	?>
	&nbsp;时空限制:<?php echo $row['time_limit'];?>s/<?php echo $row['memory_limit'];?>MB
	<ul class="pagination" style="float:right">
  <li class="page-item"><a class="page-link" href="<?php if ( $pr_flag ) { echo "submitpage.php?id=$id";} else { echo "submitpage.php?cid=$cid&pid=$pid&langmask=$langmask";}?>">提交</a></li>
  <li class="page-item"><a class="page-link" href="<?php echo "status.php?problem_id=" . $row[ 'problem_id' ];?>">状态</a></li>
  <li class="page-item"><a class="page-link" href="#" onclick="alert('论坛开发中，敬请期待')">讨论</a></li>
  <?php 
  if ( isset( $_SESSION[ $OJ_NAME . '_' . 'administrator' ] ) ) {
					require_once( "include/set_get_key.php" );
  ?>
  <li class="page-item"><a class="page-link" href="bsadmin/problem_edit.php?id=<?php echo $id?>&getkey=<?php echo $_SESSION[$OJ_NAME.'_'.'getkey']?>">编辑</a></li>
				<li class="page-item"><a class="page-link" href='javascript:phpfm(<?php echo $row['problem_id'];?>)'>数据</a></li>
  <?php } ?>
</ul>
	<?php 
	if ($row['description']) {
	    ?><h4>题目描述</h4><?php
	    echo make($row['description']);
	}
	?>
	<?php 
	if ($row['input']) {
	    ?><h4>输入格式</h4><?php
	    echo $row['input'];
	}
	?>
	<?php 
	if ($row['output']) {
	    ?><h4>输出格式</h4><?php
	    echo $row['output'];
	}
	$sinput=str_replace("<","&lt;",$row['sample_input']);
    $sinput=str_replace(">","&gt;",$sinput);
    $soutput=str_replace("<","&lt;",$row['sample_output']);
    $soutput=str_replace(">","&gt;",$soutput);
	?>
	<?php 
	if (strlen($sinput)) {
	    ?><h4>样例输入</h4><blockquote><pre><?php
	    echo $sinput."</pre></blockquote>";
	}
	?>
	<?php 
	if (strlen($soutput)) {
	    ?><h4>样例输出</h4><blockquote><pre><?php
	    echo $soutput.'</pre></blockquote>';
	}
	?>
	<?php 
	if ($row['hint']) {
	    ?><h4>提示</h4><?php
	    echo $row['hint'];
	}
	?>
	<?php 
	if ($pr_flag) {
	    echo "<h4>来源</h4>";
              $cats=explode(" ",$row['source']);
              foreach($cats as $cat){
                echo "<a href='problemset.php?search=".urlencode(htmlentities($cat,ENT_QUOTES,'utf-8'))."'>".htmlentities($cat,ENT_QUOTES,'utf-8')."</a>&nbsp;";
            }
	}
	?>
    </div>
</div>
<?php require("./template/bshark/footer.php");?>
<?php require("./template/bshark/footer-files.php");?>
    </body>
</html>
