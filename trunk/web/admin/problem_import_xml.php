<?
require_once ("admin-header.php");
?>
<?

require_once ("../include/problem.php");
?>
Import Function is On the way.

<?php
function getValue($Node,$TagName){
	
	return $Node->getElementsByTagName($TagName)->item(0)->nodeValue;
	if ($children.length>0)
		return $children->item ( 0 )->nodeValue;
	else
	    return ""; 
}

if ($_FILES ["fps"] ["error"] > 0) {
	echo "Error: " . $_FILES ["fps"] ["error"] . "File size is too big, change in PHP.ini<br />";
} else {
	$tempfile = $_FILES ["fps"] ["tmp_name"];
	echo "Upload: " . $_FILES ["fps"] ["name"] . "<br />";
	echo "Type: " . $_FILES ["fps"] ["type"] . "<br />";
	echo "Size: " . ($_FILES ["fps"] ["size"] / 1024) . " Kb<br />";
	echo "Stored in: " . $tempfile;
	
	$xmlDoc = new DOMDocument ( );
	$xmlDoc->load ( $tempfile );
	
	$searchNodes = $xmlDoc->getElementsByTagName ( "item" );
	
	foreach ( $searchNodes as $searchNode ) {
		$title = getValue($searchNode,'title');
		$time_limit = getValue($searchNode,'time_limit');
		$memory_limit = getValue($searchNode,'memory_limit');
		$description = getValue($searchNode,'description');
		$input = getValue($searchNode,'input');
		$output = getValue($searchNode,'output');
		$sample_input = getValue($searchNode,'sample_input');
		$sample_output = getValue($searchNode,'sample_output');
		$test_input = getValue($searchNode,'test_input');
		$test_output = getValue($searchNode,'test_output');
		$hint = getValue($searchNode,'hint');
		$source = getValue($searchNode,'source');
		$solution = getValue($searchNode,'$solution');
		$spj = getValue($searchNode,'spj')==""?0:1;
//		
//      $valueID = $searchNode->getAttribute ( 'ID' );
		
		
		echo "$title<br>\n";
		echo "$time_limit<br>\n";
		echo "$memory_limit<br>\n";
		echo "$description<br>\n";
		echo "$input<br>\n";
		echo "$output<br>\n";
		echo "$sample_input<br>\n";
		echo "$sample_output<br>\n";
		addproblem ( $title, $time_limit, $memory_limit, $description, $input, $output, $sample_input, $sample_output, $test_input, $test_output, $hint, $source, $spj );
		
		
	}
	unlink ( $tempfile );
}
?>