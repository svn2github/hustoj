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
        <title><?php echo $MSG_PROBLEM;?> - <?php echo $OJ_NAME;?></title>
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
				if ( $row[ 'spj' ] )echo $MSG_SPJ.'/';
	?>
	<?php echo $MSG_Time_Limit.':'.$row['time_limit'].'s '.$MSG_Memory_Limit.':'.$row['memory_limit'];?>MB
	<ul class="pagination" style="float:right">
  <li class="page-item"><a class="page-link" href="<?php if ( $pr_flag ) { echo "submitpage.php?id=$id";} else { echo "submitpage.php?cid=$cid&pid=$pid&langmask=$langmask";}?>"><?php echo $MSG_SUBMIT;?></a></li>
  <li class="page-item"><a class="page-link" href="<?php echo "status.php?problem_id=" . $row[ 'problem_id' ];?>"><?php echo $MSG_STATUS;?></a></li>
  <?php 
  if ( isset( $_SESSION[ $OJ_NAME . '_' . 'administrator' ] ) ) {
					require_once( "include/set_get_key.php" );
  ?>
  <li class="page-item"><a class="page-link" href="bsadmin/problem_edit.php?id=<?php echo $id?>&getkey=<?php echo $_SESSION[$OJ_NAME.'_'.'getkey']?>">Edit</a></li>
				<li class="page-item"><a class="page-link" href='javascript:phpfm(<?php echo $row['problem_id'];?>)'>Test Data</a></li>
  <?php } ?>
</ul>
	<?php 
	if ($row['description']) {
	    ?><h4><?php echo $MSG_Description;?></h4><?php
	    echo make($row['description']);
	}
	?>
	<?php 
	if ($row['input']) {
	    ?><h4><?php echo $MSG_Input;?></h4><?php
	    echo $row['input'];
	}
	?>
	<?php 
	if ($row['output']) {
	    ?><h4><?php echo $MSG_Output;?></h4><?php
	    echo $row['output'];
	}
	$sinput=str_replace("<","&lt;",$row['sample_input']);
    $sinput=str_replace(">","&gt;",$sinput);
    $soutput=str_replace("<","&lt;",$row['sample_output']);
    $soutput=str_replace(">","&gt;",$soutput);
	?>
	<?php 
	if (strlen($sinput)) {
	    ?><h4><?php echo $MSG_Sample_Input;?></h4><blockquote><pre><?php
	    echo $sinput."</pre></blockquote>";
	}
	?>
	<?php 
	if (strlen($soutput)) {
	    ?><h4><?php echo $MSG_Sample_Output;?></h4><blockquote><pre><?php
	    echo $soutput.'</pre></blockquote>';
	}
	?>
	<?php 
	if ($row['hint']) {
	    ?><h4><?php echo $MSG_HINT;?></h4><?php
	    echo $row['hint'];
	}
	?>
	<?php 
	if ($pr_flag) {
	    echo "<h4>$MSG_Source</h4>";
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
