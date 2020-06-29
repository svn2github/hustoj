<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


	<!-- Styles -->
	<?php require("./header-files.php");
	require_once("../include/my_func.inc.php");
	
  require_once("../include/const.inc.php");
include_once("kindeditor.php");
?>
    <title><?php echo $OJ_NAME;?> - Admin</title>


</head>

<body>

    <?php require("./nav.php");?>
    <?php 
    if ($mod=='hacker') {
        header("Location:index.php");
    }
?>
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
                                    <li>问题</li>
                                    <li class="active">编辑问题</li>
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
									<h4>编辑问题 P<?php echo $_GET['id']?$_GET['id']:$_POST["problem_id"];?></h4>
									<div class="card-header-right-icon">
										<ul>
											<li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li> 
										</ul>
									</div>
								</div>
								<div class="card-body">
								        <?php
    if(isset($_GET['id'])){
      ;//require_once("../include/check_get_key.php");
    ?>
  <form action=problem_edit.php method='post'>
      <?php
      $sql="SELECT * FROM `problem` WHERE `problem_id`=?";
      $result=pdo_query($sql,intval($_GET['id']));
      $row=$result[0];
      ?>
    <?php require_once("../include/set_post_key.php");?>
      <input type=hidden name=problem_id value='<?php echo $row['problem_id']?>'>
    <label for=title>标题</label><input type="text" name="title" class="form-control" value="<?php echo htmlentities($row['title'],ENT_QUOTES,"UTF-8")?>">
    <label for=limit>时空限制</label>
    <div><input type="number" name="time_limit" class="form-control" style="width:40%;display:inline" size=20 value="<?php echo $row['time_limit'];?>">秒
    <input type="number" name="memory_limit" class="form-control" style="width:40%;display:inline" size=20 value="<?php echo $row['memory_limit'];?>">MB</div>
    <lable for=description>题目描述</lable>
    <textarea name='description' rows=15 class="kindeditor" ><?php echo htmlentities($row['description'],ENT_QUOTES,"UTF-8")?></textarea><br>
    <lable for=input>输入格式</lable>
    <textarea name='input' rows=15 class="kindeditor" ><?php echo htmlentities($row['input'],ENT_QUOTES,"UTF-8")?></textarea><br>
    <lable for=output>输出格式</lable>
    <textarea name='output' rows=15 class="kindeditor" ><?php echo htmlentities($row['output'],ENT_QUOTES,"UTF-8")?></textarea><br>
    <lable for=sample_input>样例输入</lable>
    <textarea name='sample_input' rows=15  class='form-control'><?php echo htmlentities($row['sample_input'],ENT_QUOTES,"UTF-8")?></textarea><br>
    <lable for=sample_output>样例输出</lable>
    <textarea name='sample_output' rows=15  class='form-control'><?php echo htmlentities($row['sample_output'],ENT_QUOTES,"UTF-8")?></textarea><br>
    <lable for=hint>提示</lable>
    <textarea name='hint' rows=15 class="kindeditor" ><?php echo htmlentities($row['hint'],ENT_QUOTES,"UTF-8")?></textarea><br>
    <lable for=source>来源</lable>
    <textarea name='source' rows=1 class="form-control"><?php echo htmlentities($row['source'],ENT_QUOTES,"UTF-8")?></textarea><br>
     <label for=spj>Special Judge：</label>
          <?php echo "No "?><input type=radio name=spj value='0' <?php echo $row['spj']=="0"?"checked":""?>><?php echo "/ Yes "?><input type=radio name=spj value='1' <?php echo $row['spj']=="1"?"checked":""?>><br><br>
    <button type='submit' class="btn btn-info btn-addon i"><i class="fa fa-edit"></i>编辑</button>
  </form>
  <?php
    }else{
      require_once("../include/check_post_key.php");
      $id=intval($_POST['problem_id']);
      if(!(isset($_SESSION[$OJ_NAME.'_'."p$id"])||isset($_SESSION[$OJ_NAME.'_'.'administrator']))) exit();  

      $title=$_POST['title'];
      $title = str_replace(",", "&#44;", $title);
      $time_limit=$_POST['time_limit'];
      $memory_limit=$_POST['memory_limit'];
      $description=$_POST['description'];
      $description = str_replace("<p>", "", $description); 
      $description = str_replace("</p>", "<br />", $description);
      $description = str_replace(",", "&#44;", $description);
      
      $input=$_POST['input'];
      $input = str_replace("<p>", "", $input); 
      $input = str_replace("</p>", "<br />", $input);
      $input = str_replace(",", "&#44;", $input);
      
      $output=$_POST['output'];
      $output = str_replace("<p>", "", $output); 
      $output = str_replace("</p>", "<br />", $output); 
      $output = str_replace(",", "&#44;", $output);

      $sample_input=$_POST['sample_input'];
      $sample_output=$_POST['sample_output'];
      $hint=$_POST['hint'];
      $hint = str_replace("<p>", "", $hint); 
      $hint = str_replace("</p>", "<br />", $hint);
      $hint = str_replace(",", "&#44;", $hint);

      $source=$_POST['source'];
      $spj=$_POST['spj'];

      if(get_magic_quotes_gpc()){
        $title = stripslashes($title);
        $time_limit = stripslashes($time_limit);
        $memory_limit = stripslashes($memory_limit);
        $description = stripslashes($description);
        $input = stripslashes($input);
        $output = stripslashes($output);
        $sample_input = stripslashes($sample_input);
        $sample_output = stripslashes($sample_output);
        //$test_input = stripslashes($test_input);
        //$test_output = stripslashes($test_output);
        $hint = stripslashes($hint);
        $source = stripslashes($source); 
        $spj = stripslashes($spj);
        $source = stripslashes($source);
      }

      $title=($title);
      $description=RemoveXSS($description);
      $input=RemoveXSS($input);
      $output=RemoveXSS($output);
      $hint=RemoveXSS($hint);
      $basedir=$OJ_DATA."/$id";

      echo "样例数据文件已经更新！！<br>";

      if($sample_input&&file_exists($basedir."/sample.in")){
        //mkdir($basedir);
        $fp=fopen($basedir."/sample.in","w");
        fputs($fp,preg_replace("(\r\n)","\n",$sample_input));
        fclose($fp);

        $fp=fopen($basedir."/sample.out","w");
        fputs($fp,preg_replace("(\r\n)","\n",$sample_output));
        fclose($fp);
      }

      $spj=intval($spj);
  
      $sql="UPDATE `problem` set `title`=?,`time_limit`=?,`memory_limit`=?,
                   `description`=?,`input`=?,`output`=?,`sample_input`=?,`sample_output`=?,`hint`=?,`source`=?,`spj`=?,`in_date`=NOW()
            WHERE `problem_id`=?";

      @pdo_query($sql,$title,$time_limit,$memory_limit,$description,$input,$output,$sample_input,$sample_output,$hint,$source,$spj,$id) ;
      echo "编辑成功!";
      echo "<a href='../problem.php?id=$id'>查看问题</a>";
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
