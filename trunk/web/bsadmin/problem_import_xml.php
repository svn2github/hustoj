<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MasterOJ - Admin</title>
	
	<!-- Styles -->
	<?php require("./header-files.php");?>


</head>

<body>

    <?php require("./nav.php");?>
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>后台主页</h1>
                            </div>
                        </div>
                    </div><!-- /# column -->
                    <div class="col-lg-4 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li>题目</li>
                                    <li class="active">导入题目</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /# column -->
                </div><!-- /# row -->
                <div class="main-content">
					<div class="row"> 
						<div class="col-lg-12">
							<div class="card alert">
								<div class="card-header">
									<h4>导入问题</h4>
									<div class="card-header-right-icon">
										<ul>
											<li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li> 
										</ul>
									</div>
								</div>
								<div class="card-body">
								<?php 
require_once("../include/check_post_key.php");
    if ($mod=='hacker') {
        header("Location:index.php");
    }
if(isset($OJ_LANG)){
		require_once("../lang/$OJ_LANG.php");
	}	
	require_once ("../include/const.inc.php");
?>
<?php function image_save_file($filepath ,$base64_encoded_img){
	$fp=fopen($filepath ,"wb");
	fwrite($fp,base64_decode($base64_encoded_img));
	fclose($fp);
}
require_once ("../include/problem.php");
require_once ("../include/db_info.inc.php");
function getLang($language){
	$language_name=$GLOBALS['language_name'];
	
	for($i=0;$i<count($language_name);$i++){
		//echo "$language=$language_name[$i]=".($language==$language_name[$i]);
		if($language==$language_name[$i]){
			//$language=$i;
			//echo $language;
			return $i;
		}
	}
	return $i;
}
function submitSolution($pid,$solution,$language)
{
	global $OJ_NAME;
	$language=getLang($language);
	$len=mb_strlen($solution,'utf-8');
	$sql="INSERT INTO solution(problem_id,user_id,in_date,language,ip,code_length,result)
						VALUES(?,?,NOW(),?,'127.0.0.1',?,14)";
	$insert_id = pdo_query( $sql,$pid,$_SESSION[$OJ_NAME.'_'.'user_id'],$language,$len );
	//echo "submiting$language.....";
	$sql = "INSERT INTO `source_code`(`solution_id`,`source`)VALUES(?,?)";
	pdo_query( $sql ,$insert_id,$solution);
	$sql = "INSERT INTO `source_code_user`(`solution_id`,`source`)VALUES(?,?)";
	pdo_query( $sql,$insert_id,$solution );
    pdo_query("update solution set result=1 where solution_id=?",$insert_id);
}
?>
Import Free Problem Set ... <br>

<?php
function getValue($Node, $TagName) {
	
	return $Node->$TagName;
}
function getAttribute($Node, $TagName,$attribute) {
	return $Node->children()->$TagName->attributes()->$attribute;
}
function hasProblem($title){
//return false;	
	$md5=md5($title);
	$sql="select 1 from problem where md5(title)=?";  
	$result=pdo_query( $sql,$md5 );
	$rows_cnt=count($result);		
	
	//echo "row->$rows_cnt";			
	return  ($rows_cnt>0);

}
function mkpta($pid,$prepends,$node){
	$language_ext=$GLOBALS['language_ext'];
        $OJ_DATA=$GLOBALS['OJ_DATA'];	
	foreach($prepends as $prepend) {
		$language =$prepend->attributes()->language;
		$lang=getLang($language);
		$file_ext=$language_ext[$lang];
		$basedir = "$OJ_DATA/$pid";
		$file_name="$basedir/$node.$file_ext";
		file_put_contents($file_name,$prepend);
	}
}
function get_extension($file){
	$info = pathinfo($file);
	return $info['extension'];
}
function import_fps($tempfile){
	global $OJ_DATA,$OJ_SAE,$OJ_REDIS,$OJ_REDISSERVER,$OJ_REDISPORT,$OJ_REDISQNAME;
	$xmlDoc=simplexml_load_file($tempfile, 'SimpleXMLElement', LIBXML_PARSEHUGE);
	$searchNodes = $xmlDoc->xpath ( "/fps/item" );
	$spid=0;
	foreach($searchNodes as $searchNode) {
		//echo $searchNode->title,"\n";

		$title =$searchNode->title;
		
		$time_limit = $searchNode->time_limit;
    	$unit=getAttribute($searchNode,'time_limit','unit');
    	//echo $unit;
		if($unit=='ms') $time_limit/=1000;
		
		$memory_limit = getValue ( $searchNode, 'memory_limit' );
		$unit=getAttribute($searchNode,'memory_limit','unit');
		if($unit=='kb') $memory_limit/=1024;
		
		$description = getValue ( $searchNode, 'description' );
		$input = getValue ( $searchNode, 'input' );
		$output = getValue ( $searchNode, 'output' );
		$sample_input = getValue ( $searchNode, 'sample_input' );
		$sample_output = getValue ( $searchNode, 'sample_output' );
//		$test_input = getValue ( $searchNode, 'test_input' );
//		$test_output = getValue ( $searchNode, 'test_output' );
		$hint = getValue ( $searchNode, 'hint' );
		$source = getValue ( $searchNode, 'source' );
		
		
		$spjcode = getValue ( $searchNode, 'spj' );
		$spj = trim($spjcode)?1:0;
		if(!hasProblem($title )){
			$pid=addproblem ( $title, $time_limit, $memory_limit, $description, $input, $output, $sample_input, $sample_output, $hint, $source, $spj, $OJ_DATA );
			if($spid==0) $spid=$pid;
			$basedir = "$OJ_DATA/$pid";
			mkdir ( $basedir );
			if(strlen($sample_input)) mkdata($pid,"sample.in",$sample_input,$OJ_DATA);
			if(strlen($sample_output)) mkdata($pid,"sample.out",$sample_output,$OJ_DATA);
        //  	if(!isset($OJ_SAE)||!$OJ_SAE){
				$testinputs=$searchNode->children()->test_input;
				$testno=0;
			
				foreach($testinputs as $testNode){
					//if($testNode->nodeValue)
					mkdata($pid,"test".$testno++.".in",$testNode,$OJ_DATA);
				}
				unset($testinputs);
				$testinputs=$searchNode->children()->test_output;
				$testno=0;
				foreach($testinputs as $testNode){
					//if($testNode->nodeValue)
					mkdata($pid,"test".$testno++.".out",$testNode,$OJ_DATA);
				}
				unset($testinputs);
       // }
			$images=($searchNode->children()->img);
			$did=array();
			$testno=0;
			foreach($images as $img){
			//	
				$src=getValue($img,"src");
				if(!in_array($src,$did)){
						$base64=getValue($img,"base64");
						$ext=pathinfo($src);
						$ext=strtolower($ext['extension']);
						if(!stristr(",jpeg,jpg,svg,png,gif,bmp",$ext)){
							$ext="bad";
							exit(1);
						}
						$testno++;
						$newpath="../upload/pimg".$pid."_".$testno.".".$ext;
						if($OJ_SAE) $newpath="saestor://web/upload/pimg".$pid."_".$testno.".".$ext;
						 
						image_save_file($newpath,$base64);
						$newpath=dirname($_SERVER['REQUEST_URI'] )."/../upload/pimg".$pid."_".$testno.".".$ext;
						if($OJ_SAE) $newpath=$SAE_STORAGE_ROOT."upload/pimg".$pid."_".$testno.".".$ext;
						
						$sql="update problem set description=replace(description,?,?) where problem_id=?";  
						pdo_query( $sql,$src,$newpath,$pid);
						$sql="update problem set input=replace(input,?,?) where problem_id=?";  
						pdo_query( $sql,$src,$newpath,$pid);
						$sql="update problem set output=replace(output,?,?) where problem_id=?";  
						pdo_query( $sql,$src,$newpath,$pid);
						$sql="update problem set hint=replace(hint,?,?) where problem_id=?";  
						pdo_query( $sql,$src,$newpath,$pid);
						array_push($did,$src);
				}
				
			}
			
			if(!isset($OJ_SAE)||!$OJ_SAE){
				if($spj) {
					$basedir = "$OJ_DATA/$pid";
					$fp=fopen("$basedir/spj.cc","w");
					fputs($fp, $spjcode);
					fclose($fp);
					////system( " g++ -o $basedir/spj $basedir/spj.cc  ");
					if(!file_exists("$basedir/spj") ){
						$fp=fopen("$basedir/spj.c","w");
						fputs($fp, $spjcode);
						fclose($fp);
						////system( " gcc -o $basedir/spj $basedir/spj.c  ");
						if(!file_exists("$basedir/spj")){
							echo "you need to compile $basedir/spj.cc for spj[  g++ -o $basedir/spj $basedir/spj.cc   ]<br> and rejudge $pid";
						
						}else{
							
							unlink("$basedir/spj.cc");
						}
					
					
					}
				}
			}
			
			$solutions = $searchNode->children()->solution;
			foreach($solutions as $solution) {
				$language =$solution->attributes()->language;
				submitSolution($pid,$solution,$language);
			}
			unset($solutions);
			$prepends = $searchNode->children()->prepend;
			mkpta($pid,$prepends,"prepend");
			$prepends = $searchNode->children()->template;
			mkpta($pid,$prepends,"template");
			$prepends = $searchNode->children()->append;
			mkpta($pid,$prepends,"append");
			
			
		}else{
			echo "<br><span class=red>$title is already in this OJ</span>";		
		}
		
	}
	unlink ( $tempfile );
	if(isset($OJ_REDIS)&&$OJ_REDIS){
           $redis = new Redis();
           $redis->connect($OJ_REDISSERVER, $OJ_REDISPORT);
                $sql="select solution_id from solution where result=0 and problem_id>0";
                 $result=pdo_query($sql);
                 foreach($result as $row){
                        echo $row['solution_id']."\n";
                        $redis->lpush($OJ_REDISQNAME,$row['solution_id']);
                }
                
        }

	if($spid>0){
		require_once("../include/set_get_key.php");
		echo "<br><a class=blue href=contest_add.php?spid=$spid&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey'].">Use these problems to create a contest.</a>";
	 }
}

if ($_FILES ["fps"] ["error"] > 0) {
	echo "Error: " . $_FILES ["fps"] ["error"] . "File size is too big, change in PHP.ini<br />";
} else {
	$tempfile = $_FILES ["fps"] ["tmp_name"];
	if(get_extension( $_FILES ["fps"] ["name"])=="zip"){
	   echo "zip file , only fps/xml files in root dir are supported";
		 $resource = zip_open($tempfile);
		  $i = 1;
	   $tempfile=tempnam("/tmp", "fps");
	   while ($dir_resource = zip_read($resource)) {
		  if (zip_entry_open($resource,$dir_resource)) {
		   $file_name = $path.zip_entry_name($dir_resource);
		   $file_path = substr($file_name,0,strrpos($file_name, "/"));
		   if(!is_dir($file_name)){
		    $file_size = zip_entry_filesize($dir_resource);
		     $file_content = zip_entry_read($dir_resource,$file_size);
		     file_put_contents($tempfile,$file_content);
		     import_fps($tempfile);
		   }
		   zip_entry_close($dir_resource);
		  }
	  }
	  zip_close($resource);
	  unlink ( $_FILES ["fps"] ["tmp_name"] );
	}else{
		import_fps($tempfile);
	}
//	echo "Upload: " . $_FILES ["fps"] ["name"] . "<br />";
//	echo "Type: " . $_FILES ["fps"] ["type"] . "<br />";
//	echo "Size: " . ($_FILES ["fps"] ["size"] / 1024) . " Kb<br />";
//	echo "Stored in: " . $tempfile;
	
	//$xmlDoc = new DOMDocument ();
	//$xmlDoc->load ( $tempfile );
	//$xmlcontent=file_get_contents($tempfile );
}
?>

</div>
							</div>
						</div>
                    </div><!-- /# row -->
					 </div>
     <!-- /# main content -->
     CopyRight &copy; 1999-<?php echo date('Y');?> MasterOJ.All rights reserved
            </div><!-- /# container-fluid -->
        </div><!-- /# main -->
    </div><!-- /# content wrap -->
	
	
	
    <script src="assets/js/lib/jquery.min.js"></script><!-- jquery vendor -->
    <script src="assets/js/lib/jquery.nanoscroller.min.js"></script><!-- nano scroller -->    
    <script src="assets/js/lib/sidebar.js"></script><!-- sidebar -->
    <script src="assets/js/lib/bootstrap.min.js"></script><!-- bootstrap -->
    <script src="assets/js/lib/mmc-common.js"></script>
    <script src="assets/js/lib/mmc-chat.js"></script>
	<!--  Chart js -->
	<script src="assets/js/lib/chart-js/Chart.bundle.js"></script>
	<script src="assets/js/lib/chart-js/chartjs-init.js"></script>
	<!-- // Chart js -->


    <script src="assets/js/lib/sparklinechart/jquery.sparkline.min.js"></script><!-- scripit init-->
    <script src="assets/js/lib/sparklinechart/sparkline.init.js"></script><!-- scripit init-->
	
	<!--  Datamap -->
    <script src="assets/js/lib/datamap/d3.min.js"></script>
    <script src="assets/js/lib/datamap/topojson.js"></script>
    <script src="assets/js/lib/datamap/datamaps.world.min.js"></script>
    <script src="assets/js/lib/datamap/datamap-init.js"></script>
	<!-- // Datamap -->-->
    <script src="assets/js/lib/weather/jquery.simpleWeather.min.js"></script>	
    <script src="assets/js/lib/weather/weather-init.js"></script>
    <script src="assets/js/lib/owl-carousel/owl.carousel.min.js"></script>
    <script src="assets/js/lib/owl-carousel/owl.carousel-init.js"></script>
    <script src="assets/js/scripts.js"></script><!-- scripit init-->
</body>
</html>