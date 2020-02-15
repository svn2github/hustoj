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
                                <h1><?php echo $MSG_ADMIN.$MSG_HOME;?></h1>
                            </div>
                        </div>
                    </div><!-- /# column -->
                    <div class="col-lg-4 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><?php echo $MSG_CONTEST;?></li>
                                    <li class="active"><?php echo $MSG_CONTEST.$MSG_EDIT;?></li>
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
									<h4><?php echo $MSG_CONTEST.$MSG_EDIT;?> C<?php echo $_GET['cid'];?></h4>
									<div class="card-header-right-icon">
										<ul>
											<li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li> 
										</ul>
									</div>
								</div>
								<div class="card-body">
								    <?php
if(isset($_POST['startdate'])){
  require_once("../include/check_post_key.php");

  $starttime = $_POST['startdate']." ".intval($_POST['shour']).":".intval($_POST['sminute']).":00";
  $endtime = $_POST['enddate']." ".intval($_POST['ehour']).":".intval($_POST['eminute']).":00";
  //echo $starttime;
  //echo $endtime;
 
  $title = $_POST['title'];
  $private = $_POST['private'];
  $password = $_POST['password'];
  $description = $_POST['description'];
 
  if(get_magic_quotes_gpc()){
    $title = stripslashes($title);
    $private = stripslashes($private);    
    $password = stripslashes($password);
    $description = stripslashes($description);
  }

  $lang = $_POST['lang'];
  $langmask=0;
  foreach($lang as $t){
    $langmask += 1<<$t;
  } 

  $langmask = ((1<<count($language_ext))-1)&(~$langmask);
  //echo $langmask; 

  $cid=intval($_POST['cid']);

  if(!(isset($_SESSION[$OJ_NAME.'_'."m$cid"])||isset($_SESSION[$OJ_NAME.'_'.'administrator']))) exit();

  $description = str_replace("<p>", "", $description); 
  $description = str_replace("</p>", "<br />", $description);
  $description = str_replace(",", "&#44;", $description);


  $sql = "UPDATE `contest` SET `title`=?,`description`=?,`start_time`=?,`end_time`=?,`private`=?,`langmask`=?,`password`=? WHERE `contest_id`=?";
  //echo $sql;
  pdo_query($sql,$title,$description,$starttime,$endtime,$private,$langmask,$password,$cid);

  $sql = "DELETE FROM `contest_problem` WHERE `contest_id`=?";
  pdo_query($sql,$cid);
  $plist=trim($_POST['cproblem']);
  $pieces = explode(',', $plist);

  if(count($pieces)>0 && strlen($pieces[0])>0){
    $sql_1 = "INSERT INTO `contest_problem`(`contest_id`,`problem_id`,`num`) VALUES (?,?,?)";
    for($i=0; $i<count($pieces); $i++){
      pdo_query($sql_1,$cid,intval($pieces[$i]),$i);
  }
  
    pdo_query("update solution set num=-1 where contest_id=?",$cid);
  
    $plist="";
    for($i=0; $i<count($pieces); $i++){
      if($plist) $plist.=",";
      $plist .= $pieces[$i];
      $sql_2 = "update solution set num=? where contest_id=? and problem_id=?;";
      pdo_query($sql_2,$i,$cid,$pieces[$i]);
    }

    $sql = "update `problem` set defunct='N' where `problem_id` in ($plist)";
    pdo_query($sql) ;
  }

  $sql = "DELETE FROM `privilege` WHERE `rightstr`=?";
  pdo_query($sql,"c$cid");
  $pieces = explode("\n", trim($_POST['ulist']));
  
  if(count($pieces)>0 && strlen($pieces[0])>0){
    $sql_1 = "INSERT INTO `privilege`(`user_id`,`rightstr`) VALUES (?,?)";
    for($i=0; $i<count($pieces); $i++){
      pdo_query($sql_1,trim($pieces[$i]),"c$cid") ;
    }
  }

  echo "<script>window.location.href=\"contest_list.php\";</script>";
  exit();
}else{
  $cid = intval($_GET['cid']);
  $sql = "SELECT * FROM `contest` WHERE `contest_id`=?";
  $result = pdo_query($sql,$cid);

  if(count($result)!=1){
    echo "No such Contest!";
    exit(0);
  }

  $row = $result[0];
  $starttime = $row['start_time'];
  $endtime = $row['end_time'];
  $private = $row['private'];
  $password = $row['password'];
  $langmask = $row['langmask'];
  $description = $row['description'];
  $title = htmlentities($row['title'],ENT_QUOTES,"UTF-8");

  $plist = "";
  $sql = "SELECT `problem_id` FROM `contest_problem` WHERE `contest_id`=? ORDER BY `num`";
  $result=pdo_query($sql,$cid);

  foreach($result as $row){
    if($plist) $plist .= ",";
    $plist.=$row[0];
  }

  $ulist = "";
  $sql = "SELECT `user_id` FROM `privilege` WHERE `rightstr`=? order by user_id";
  $result = pdo_query($sql,"c$cid");

  foreach($result as $row){
    if($ulist) $ulist .= "\n";
    $ulist .= $row[0];
  } 
}
?>
<form method=POST>
    <?php require_once("../include/set_post_key.php");?>
    <input type=hidden name='cid' value=<?php echo $cid?>>
      <label><?php echo $MSG_CONTEST.$MSG_TITLE;?></label>
      <input class="form-control" style="width:100%;" type=text name=title value="<?php echo $title?>">
      <label><?php echo $MSG_START_TIME;?></label>
      <p>
      <input class="form-control" style="display:inline;width:auto" type=date name='startdate' value='<?php echo substr($starttime,0,10)?>' size=4 >
      <input class="form-control" style="display:inline;width:auto" type=text name=shour size=2 value='<?php echo substr($starttime,11,2)?>'>时
      <input class="form-control" style="display:inline;width:auto" type=text name=sminute value='<?php echo substr($starttime,14,2)?>' size=2 >分
      </p><p>
      <label><?php echo $MSG_END_TIME;?></label><br>
      <input class="form-control" style="display:inline;width:auto" type=date name='enddate' value='<?php echo substr($endtime,0,10)?>' size=4 >
      <input class="form-control" style="display:inline;width:auto" type=text name=ehour size=2 value='<?php echo substr($endtime,11,2)?>'>时
      <input class="form-control" style="display:inline;width:auto" type=text name=eminute value='<?php echo substr($endtime,14,2)?>' size=2 >分
      </p><p>
      <?php echo $MSG_CONTEST."-".$MSG_PROBLEM_ID?>
      <?php echo "( Add problemIDs with coma , )"?>
      <input class=form-control type=text style="width:100%" name=cproblem value='<?php echo $plist?>'>

      </p><p>
      <?php echo $MSG_CONTEST.$MSG_Description;?>
      <textarea class=kindeditor rows=13 name=description cols=80>
        <?php echo htmlentities($description,ENT_QUOTES,'UTF-8')?>
      </textarea>

      </p>
      <table width="100%" class="table">
        <tr>
          <td rowspan=2>
            <p>
              <?php echo $MSG_CONTEST."-".$MSG_LANG?>
              <?php echo "( Add PLs with Ctrl+click )"?><br>
              <?php echo $MSG_PLS_ADD?>
              <select name="lang[]" class="form-control" multiple="multiple" style="height:220px">
              <?php
              $lang_count = count($language_ext);
              $lang = (~((int)$langmask))&((1<<$lang_count)-1);

              if(isset($_COOKIE['lastlang'])) $lastlang=$_COOKIE['lastlang'];
              else $lastlang = 0;

              for($i=0; $i<$lang_count; $i++){
                echo "<option value=$i ".( $lang&(1<<$i)?"selected":"").">".$language_name[$i]."</option>";
              }
              ?>
              </select>
            </p>
          </td>

          <td height="10px">
            <p align=left>
              <?php echo $MSG_CONTEST."-".$MSG_Public?>:
              <select class="form-control" name=private style="display:inline;width:150px;">
                <option value=0 <?php echo $private=='0'?'selected=selected':''?>><?php echo $MSG_Public;?></option>
                <option value=1 <?php echo $private=='1'?'selected=selected':''?>><?php echo $MSG_Private;?></option>
              </select>
              <?php echo $MSG_CONTEST."-".$MSG_PASSWORD?>:
              <input type=text class=form-control name=password style="display:inline;width:150px;" value='<?php echo htmlentities($password,ENT_QUOTES,'utf-8')?>'>
            </p>
          </td>
        </tr>
        <tr>
          <td height="*">
            <p>
              <?php echo $MSG_CONTEST."-".$MSG_USER?>
              <?php echo "( Add private contest's userIDs with newline &#47;n )"?>
              <br>
              <textarea name="ulist" rows="10" class=form-control style="width:100%;" placeholder="user1<?php echo "\n"?>user2<?php echo "\n"?>user3<?php echo "\n"?>*可以将学生学号从Excel整列复制过来，然后要求他们用学号做UserID注册,就能进入Private的比赛作为作业和测验。"><?php if(isset($ulist)){ echo $ulist;}?></textarea>
            </p>
          </td>
        </tr>
      </table>

        <?php require_once("../include/set_post_key.php");?>
        <input type=submit value=Submit name=submit class="btn btn-info"><input type=reset value=Reset name=reset class="btn btn-primary">
    </p>
  </form>
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
