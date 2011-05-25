<?require("admin-header.php");

if (!(isset($_SESSION['administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
function writable($path){
	$ret=false;
	$fp=fopen($path."/testifwritable.tst","w");
	$ret=!($fp===false);
	fclose($fp);
	unlink($path."/testifwritable.tst");
	return $ret;
}
?>
<?
if(isset($_POST['do'])){
	require_once("../include/check_post_key.php");
	if (isset($_POST['from'])){
		$from=intval($_POST['from']);
		$to=intval($_POST['to']);
		if(rename("$OJ_DATA/$from","$OJ_DATA/$to")){
			$sql="UPDATE `problem` SET `problem_id`=$to WHERE `problem_id`=".$from;
			if(!mysql_query($sql)){
				 rename("$OJ_DATA/$to","$OJ_DATA/$from");
				 exit(1);
			}
			$sql="UPDATE `solution` SET `problem_id`=$to WHERE `problem_id`=".$from;
			if(!mysql_query($sql)){
				 rename("$OJ_DATA/$to","$OJ_DATA/$from");
				 exit(1);
			}
			$sql="UPDATE `contest_problem` SET `problem_id`=$to WHERE `problem_id`=".$from;
			if(!mysql_query($sql)){
				 rename("$OJ_DATA/$to","$OJ_DATA/$from");
				 exit(1);
			}
			$sql="select max(problem_id) from problem";
			if($result=mysql_query($sql)){
				$f=mysql_fetch_array($result);
				$nextid=$f[0]+1;
				$sql="ALTER TABLE problem AUTO_INCREMENT = $nextid";
				mysql_query($sql);
			}
			
			
		}

	}
}

 $show_form=true;
   if(!isset($OJ_SAE)||!$OJ_SAE){
	   if(!writable($OJ_DATA)){
		   echo " You need to add  $OJ_DATA into your open_basedir setting of php.ini,<br>
					or you need to execute:<br>
					   <b>chmod 775 -R $OJ_DATA && chgrp -R www-data $OJ_DATA</b><br>
					you can't use import function at this time.<br>"; 
			$show_form=false;
	   }
	}	
	if($show_form){
?>
<b>Change ProblemID</b>
	<ol>
	<li>Problem
	<form action='problem_changeid.php' method=post>
		Move<input type=input name='from'>->
		<input type=input name='to'>
		<input type='hidden' name='do' value='do'>
		<input type=submit value=submit>
		<?require_once("../include/set_post_key.php");?>
	</form>
	
<?
	}
?>
