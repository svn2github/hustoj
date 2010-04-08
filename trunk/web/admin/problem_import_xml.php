<?
require_once ("admin-header.php");
?>
<?

require_once ("../include/problem.php");

function submitSolution($pid,$solution,$language)
{
	require ("../include/const.inc.php");

	for($i=0;$i<count($language_name);$i++){
		echo "$language=$language_name[$i]=".($language==$language_name[$i]);
		if($language==$language_name[$i]){
			$language=$i;
			echo $language;
			break;
		}
		
	}
	
	$len=mb_strlen($solution,'utf-8');
	$sql="INSERT INTO solution(problem_id,user_id,in_date,language,ip,code_length)
	VALUES('$pid','".$_SESSION['user_id']."',NOW(),'$language','127.0.0.1','$len')";
	
	mysql_query ( $sql );
	$insert_id = mysql_insert_id ();
	$solution=mysql_real_escape_string($solution);
	echo "submiting$language.....";
	$sql = "INSERT INTO `source_code`(`solution_id`,`source`)VALUES('$insert_id','$solution')";
	mysql_query ( $sql );

}
?>
Import Function is On the way.

<?php
function getValue($Node, $TagName) {
	
	$children = $Node->getElementsByTagName ( $TagName );
	if ($children->length > 0)
		$ret = $children->item ( 0 )->nodeValue;
	else
		$ret = "";
	return $ret;
}
function getAttribute($Node, $TagName,$attribute) {
	
	$children = $Node->getElementsByTagName ( $TagName );
	if ($children->length > 0)
		$ret = $children->item ( 0 )->getAttribute($attribute);
	else
		$ret = "";
	return $ret;
}

if ($_FILES ["fps"] ["error"] > 0) {
	echo "Error: " . $_FILES ["fps"] ["error"] . "File size is too big, change in PHP.ini<br />";
} else {
	$tempfile = $_FILES ["fps"] ["tmp_name"];
	echo "Upload: " . $_FILES ["fps"] ["name"] . "<br />";
	echo "Type: " . $_FILES ["fps"] ["type"] . "<br />";
	echo "Size: " . ($_FILES ["fps"] ["size"] / 1024) . " Kb<br />";
	echo "Stored in: " . $tempfile;
	
	$xmlDoc = new DOMDocument ();
	$xmlDoc->load ( $tempfile );
	
	$searchNodes = $xmlDoc->getElementsByTagName ( "item" );
	
	foreach ( $searchNodes as $searchNode ) {
		$title = getValue ( $searchNode, 'title' );
		$time_limit = getValue ( $searchNode, 'time_limit' );
		$memory_limit = getValue ( $searchNode, 'memory_limit' );
		$description = getValue ( $searchNode, 'description' );
		$input = getValue ( $searchNode, 'input' );
		$output = getValue ( $searchNode, 'output' );
		$sample_input = getValue ( $searchNode, 'sample_input' );
		$sample_output = getValue ( $searchNode, 'sample_output' );
		$test_input = getValue ( $searchNode, 'test_input' );
		$test_output = getValue ( $searchNode, 'test_output' );
		$hint = getValue ( $searchNode, 'hint' );
		$source = getValue ( $searchNode, 'source' );
		$solution = getValue ( $searchNode, 'solution' );
		$language =getAttribute( $searchNode, 'solution','language' );
		$spjcode = getValue ( $searchNode, 'spj' );
		$spj = $spjcode?0:1;
		//		
		//      $valueID = $searchNode->getAttribute ( 'ID' );
		

		//		
		//		echo "->$title<br>\n";
		//		echo "->$time_limit<br>\n";
		//		echo "->$memory_limit<br>\n";
		//		echo "->$description<br>\n";
		//		echo "->$input<br>\n";
		//		echo "->$output<br>\n";
		//		echo "->$sample_input<br>\n";
		//		echo "->$sample_output<br>\n";
		//		echo "->$test_input<br>\n";
		//		echo "->$test_output<br>\n";
		//		echo "->$spj<br>\n";
//				echo "->$solution<-<br>\n";
//				echo "->$language<-<br>\n";
		$pid=addproblem ( $title, $time_limit, $memory_limit, $description, $input, $output, $sample_input, $sample_output, $test_input, $test_output, $hint, $source, $spj, $OJ_DATA );
	    if($solution) submitSolution($pid,$solution,$language);
	    if($spj) {
	    	$basedir = "$OJ_DATA/$pid";
	    	$fp=fopen("$basedir/spj.cc","w");
			fputs($fp, $spjcode);
			fclose($fp);
	    	echo "you need to complie $basedir/spj.cc for spj[g++ -o spj spj.cc]";
	    }
	}
	unlink ( $tempfile );
}
?>