<?
require_once ("admin-header.php");
if (!(isset($_SESSION['administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
?>
<?
function image_save_file($filepath ,$base64_encoded_img){
	$fp=fopen($filepath ,wb);
	fwrite($fp,base64_decode($base64_encoded_img));
	fclose($fp);
}
require_once ("../include/problem.php");

function submitSolution($pid,$solution,$language)
{
	require ("../include/const.inc.php");

	for($i=0;$i<count($language_name);$i++){
		//echo "$language=$language_name[$i]=".($language==$language_name[$i]);
		if($language==$language_name[$i]){
			$language=$i;
			//echo $language;
			break;
		}
		
	}
	
	$len=mb_strlen($solution,'utf-8');
	$sql="INSERT INTO solution(problem_id,user_id,in_date,language,ip,code_length)
	VALUES('$pid','".$_SESSION['user_id']."',NOW(),'$language','127.0.0.1','$len')";
	
	mysql_query ( $sql );
	$insert_id = mysql_insert_id ();
	$solution=mysql_real_escape_string($solution);
	//echo "submiting$language.....";
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
//		$test_input = getValue ( $searchNode, 'test_input' );
//		$test_output = getValue ( $searchNode, 'test_output' );
		$hint = getValue ( $searchNode, 'hint' );
		$source = getValue ( $searchNode, 'source' );
		$solution = getValue ( $searchNode, 'solution' );
		$language =getAttribute( $searchNode, 'solution','language' );
		$spjcode = getValue ( $searchNode, 'spj' );
		$spj = trim($spjcode)?1:0;
	
		$pid=addproblem ( $title, $time_limit, $memory_limit, $description, $input, $output, $sample_input, $sample_output, $hint, $source, $spj, $OJ_DATA );
	    $basedir = "$OJ_DATA/$pid";
	    mkdir ( $basedir );
		if(strlen($sample_input)) mkdata($pid,"sample.in",$sample_input,$OJ_DATA);
		if(strlen($sample_output)) mkdata($pid,"sample.out",$sample_output,$OJ_DATA);
		$testinputs=$searchNode->getElementsByTagName("test_input");
		$testno=0;
		foreach($testinputs as $testNode){
			if($testNode->nodeValue)
			mkdata($pid,"test".$testno++.".in",$testNode->nodeValue,$OJ_DATA);
		}
		$testinputs=$searchNode->getElementsByTagName("test_output");
		$testno=0;
		foreach($testinputs as $testNode){
			//if($testNode->nodeValue)
			mkdata($pid,"test".$testno++.".out",$testNode->nodeValue,$OJ_DATA);
		}
		$images=($searchNode->getElementsByTagName("img"));
		$testno=0;
		foreach($images as $img){
			$src=getValue($img,"src");
			$base64=getValue($img,"base64");
			$ext=pathinfo($src);
			$ext=$ext['extension'];
			$newpath="../upload/pimg".$pid."_".++$testno.".".$ext;
			image_save_file($newpath,$base64);
			$newpath=dirname($_SERVER['REQUEST_URI'] )."/../upload/pimg".$pid."_".$testno.".".$ext;
			$src=mysql_real_escape_string($src);
			$newpath=mysql_real_escape_string($newpath);
			$sql="update problem set description=replace(description,'$src','$newpath') where problem_id=$pid";  
			mysql_query ( $sql );
			$sql="update problem set input=replace(input,'$src','$newpath') where problem_id=$pid";  
			mysql_query ( $sql );
			$sql="update problem set output=replace(output,'$src','$newpath') where problem_id=$pid";  
			mysql_query ( $sql );
			$sql="update problem set hint=replace(hint,'$src','$newpath') where problem_id=$pid";  
			mysql_query ( $sql );
			
		}
		
		
		if($spj) {
	    	$basedir = "$OJ_DATA/$pid";
	    	$fp=fopen("$basedir/spj.cc","w");
			fputs($fp, $spjcode);
			fclose($fp);
			system( " g++ -o $basedir/spj $basedir/spj.cc  ");
			if(!file_exists("$basedir/spj") ){
	    		$fp=fopen("$basedir/spj.c","w");
				fputs($fp, $spjcode);
				fclose($fp);
				system( " gcc -o $basedir/spj $basedir/spj.c  ");
				if(!file_exists("$basedir/spj")){
					echo "you need to compile $basedir/spj.cc for spj[  g++ -o $basedir/spj $basedir/spj.cc   ]<br> and rejudge $pid";
				
				}else{
					
					unlink("$basedir/spj.cc");
				}
	    	
			
			}
	    }
	    if($solution) submitSolution($pid,$solution,$language);
	    
	}
	unlink ( $tempfile );
}
?>
