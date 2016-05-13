<?php

function addproblem($title, $time_limit, $memory_limit, $description, $input, $output, $sample_input, $sample_output, $hint, $source, $spj,$OJ_DATA) {
	$mysqli=$GLOBALS['mysqli'];
	$title=mysqli_real_escape_string($mysqli,$title);
	$time_limit=mysqli_real_escape_string($mysqli,$time_limit);
	$memory_limit=mysqli_real_escape_string($mysqli,$memory_limit);
	$description=mysqli_real_escape_string($mysqli,$description);
	$input=mysqli_real_escape_string($mysqli,$input);
	$output=mysqli_real_escape_string($mysqli,$output);
	$sample_input=mysqli_real_escape_string($mysqli,$sample_input);
	$sample_output=mysqli_real_escape_string($mysqli,$sample_output);
//	$test_input=($test_input);
//	$test_output=($test_output);
	$hint=mysqli_real_escape_string($mysqli,$hint);
	$source=mysqli_real_escape_string($mysqli,$source);
//	$spj=($spj);
	
	$sql = "INSERT into `problem` (`title`,`time_limit`,`memory_limit`,
	`description`,`input`,`output`,`sample_input`,`sample_output`,`hint`,`source`,`spj`,`in_date`,`defunct`)
	VALUES('$title','$time_limit','$memory_limit','$description','$input','$output',
			'$sample_input','$sample_output','$hint','$source','$spj',NOW(),'Y')";
	//echo $sql;
	@mysqli_query($mysqli, $sql ) or die ( mysqli_error ($mysqli) );
	$pid = mysqli_insert_id ($mysqli);
	echo "<br>Add $pid  ";
	if (isset ( $_POST ['contest_id'] )) {
		$sql = "select count(*) FROM `contest_problem` WHERE `contest_id`=" . strval ( intval ( $_POST ['contest_id'] ) );
		$result = @mysqli_query($mysqli, $sql ) or die ( mysqli_error($mysqli) );
		$row = mysqli_fetch_row ( $result );
		$cid = $_POST ['contest_id'];
		$num = $row [0];
		echo "Num=" . $num . ":";
		$sql = "INSERT INTO `contest_problem` (`problem_id`,`contest_id`,`num`) VALUES('$pid','$cid','$num')";
		mysqli_free_result ($result);
		mysqli_query($mysqli, $sql );
	}
	$basedir = "$OJ_DATA/$pid";
	if(!isset($OJ_SAE)||!$OJ_SAE){
			echo "[$title]data in $basedir";
	}
	return $pid;
}
function mkdata($pid,$filename,$input,$OJ_DATA){
	
	$basedir = "$OJ_DATA/$pid";
	
	$fp = @fopen ( $basedir . "/$filename", "w" );
	if($fp){
		fputs ( $fp, preg_replace ( "(\r\n)", "\n", $input ) );
		fclose ( $fp );
	}else{
		echo "Error while opening".$basedir . "/$filename ,try [chgrp -R www-data $OJ_DATA] and [chmod -R 771 $OJ_DATA ] ";
		
	}
	
	
	
}

?>
