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
    
require_once("../include/set_get_key.php");
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
                                    <li><?php echo $MSG_SYSTEM;?></li>
                                    <li class="active"><?php echo $MSG_HELP_UPDATE_DATABASE?></li>
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
									<h4><?php echo $MSG_HELP_UPDATE_DATABASE?></h4>
									<div class="card-header-right-icon">
										<ul>
											<li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li> 
										</ul>
									</div>
								</div>
								<div class="card-body">
								    <?php $tsql=Array();
$csql=Array();
$tsql[0]="select 1 from topic limit 1";
$csql[0]="
CREATE TABLE `topic` (
  `tid` int(11) NOT NULL auto_increment,
  `title` varbinary(60) NOT NULL,
  `status` int(2) NOT NULL default '0',
  `top_level` int(2) NOT NULL default '0',
  `cid` int(11) default NULL,
  `pid` int(11) NOT NULL,
  `author_id` varchar(20) NOT NULL,
  PRIMARY KEY  (`tid`),
  KEY `cid` (`cid`,`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
$tsql[1]="select 1 from reply limit 1";
$csql[1]="
CREATE TABLE `reply` (
 `rid` int(11) NOT NULL auto_increment,
 `author_id` varchar(20) NOT NULL,
 `time` datetime NOT NULL default '2000-01-01 00:00:01',
 `content` text NOT NULL,
 `topic_id` int(11) NOT NULL,
 `status` int(2) NOT NULL default '0',
 `ip` varchar(30) NOT NULL,
 PRIMARY KEY  (`rid`),
 KEY `author_id` (`author_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
$tsql[2]="
ALTER TABLE `problem` DROP COLUMN `sample_Program`,
 DROP COLUMN `ratio`,
 DROP COLUMN `error`,
 DROP COLUMN `difficulty`,
 DROP COLUMN `submit_user`,
 DROP COLUMN `case_time_limit`;
 ";
$csql[2]="";
$tsql[3]="select 1 from sim limit 1";
$csql[3]="
CREATE TABLE `sim` (
  `s_id` int(11) NOT NULL,
  `sim_s_id` int(11) NULL,
  `sim` int(11) NULL,
  PRIMARY KEY  (`s_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$tsql[4]="select 1 from mail limit 1";
$csql[4]="
CREATE TABLE `mail` (

  `mail_id` int(11) NOT NULL auto_increment,
  `to_user` varchar(20) NOT NULL default '',
  `from_user` varchar(20) NOT NULL default '',
  `title` varchar(200) NOT NULL default '',
  `content` text,
  `new_mail` tinyint(1) NOT NULL default '1',
  `reply` tinyint(4) default '0',
  `in_date` datetime default NULL,
  `defunct` char(1) NOT NULL default 'N',
  PRIMARY KEY  (`mail_id`),
  KEY `uid` (`to_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;";
$tsql[5]="ALTER TABLE `solution` MODIFY COLUMN `user_id` CHAR(48)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,	DROP COLUMN `className`,MODIFY COLUMN `ip` CHAR(15)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
$csql[5]="";

$tsql[6]="select langmask from contest limit 1;";
$csql[6]="ALTER TABLE `contest` ADD COLUMN `langmask` TINYINT  NOT NULL DEFAULT 0 COMMENT 'bits for LANG to mask' AFTER `private`;";

$csql[7]="";
$tsql[7]="optimize table `compileinfo`,`contest` ,`contest_problem` ,`loginlog`,`news`,`privilege`,`problem` ,`solution`,`source_code`,`users`,`topic`,`reply`,`online`,`sim`,`mail`;";

$csql[8]="";
$tsql[8]="ALTER TABLE `contest` MODIFY COLUMN `langmask` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'bits for LANG to mask';";
$tsql[9]="select 1 from runtimeinfo limit 1";
$csql[9]="CREATE TABLE  `runtimeinfo` (
  `solution_id` int(11) NOT NULL DEFAULT '0',
  `error` text,
  PRIMARY KEY (`solution_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
$tsql[10]="select pass_rate from solution";
$csql[10]="ALTER TABLE `solution` ADD COLUMN `pass_rate` DECIMAL(3,2) UNSIGNED NOT NULL DEFAULT 0 AFTER `judgetime`;";

$csql[11]="";
$tsql[11]="ALTER TABLE `users` MODIFY COLUMN `user_id` varchar(48) NOT NULL DEFAULT ''  COMMENT 'user_id';";

$csql[12]="";
$tsql[12]="ALTER TABLE `topic` MODIFY COLUMN `author_id` varchar(48) NOT NULL DEFAULT ''  COMMENT 'user_id';";

$csql[13]="";
$tsql[13]="ALTER TABLE `mail` MODIFY COLUMN `to_user` varchar(48) NOT NULL DEFAULT ''  COMMENT 'user_id',MODIFY COLUMN `from_user` varchar(48) NOT NULL DEFAULT ''  COMMENT 'user_id';";

$csql[14]="";
$tsql[14]="ALTER TABLE `reply` MODIFY COLUMN `author_id` varchar(48) NOT NULL DEFAULT ''  COMMENT 'user_id';";

$csql[15]="";
$tsql[15]="ALTER TABLE `privilege` MODIFY COLUMN `user_id` varchar(48) NOT NULL DEFAULT ''  COMMENT 'user_id';";

$csql[15]="";
$tsql[15]="ALTER TABLE `loginlog` MODIFY COLUMN `user_id` varchar(48) NOT NULL DEFAULT ''  COMMENT 'user_id';";

$csql[15]="";
$tsql[15]="ALTER TABLE `news` MODIFY COLUMN `user_id` varchar(48) NOT NULL DEFAULT ''  COMMENT 'user_id';";
$tsql[16]="ALTER TABLE `sim` ADD INDEX `Index_sim_id`(`sim_s_id`);";
$csql[16]="";
$tsql[17]="ALTER TABLE `contest_problem` ADD INDEX `Index_contest_id`(`contest_id`);";
$csql[17]="";
$tsql[18]="ALTER TABLE `contest_problem` ADD INDEX `Index_problem_id`(`problem_id`);";
$csql[18]="";

$tsql[18]="select 1 from custominput limit 1;";
$csql[18]="CREATE TABLE  `custominput` (  `solution_id` int(11) NOT NULL DEFAULT '0',  `input_text` text,  PRIMARY KEY (`solution_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$tsql[19]="ALTER TABLE `loginlog` ADD INDEX `user_time_index`(`user_id`, `time`);";
$csql[19]="";
$tsql[20]="ALTER TABLE `contest` ADD `password` CHAR( 16 ) NOT NULL DEFAULT '' AFTER `langmask` ";
$csql[20]="";
$tsql[21]="create TABLE `source_code_user` like source_code";
$csql[21]="";

$tsql[22]="insert into source_code_user select * from source_code where solution_id not in (select solution_id from source_code_user)  ";
$csql[22]="";

$tsql[23]="select judger from solution limit 1 ";
$csql[23]="ALTER TABLE `solution` ADD `judger` CHAR(16) NOT NULL DEFAULT 'LOCAL' ;  ";

$csql[24]="";
$tsql[24]="alter table solution modify column pass_rate decimal(3,2) NOT NULL DEFAULT 0;";

$csql[25]="";
$tsql[25]="ALTER TABLE  `solution` CHANGE  `ip`  `ip` CHAR( 46 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '';";
$csql[26]="select 1 from printer";
$tsql[26]="CREATE TABLE  `printer` (
  `printer_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` char(48) NOT NULL,
  `in_date` datetime NOT NULL DEFAULT '2018-03-13 19:38:00',
  `status` smallint(6) NOT NULL DEFAULT '0',
  `worktime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `printer` CHAR(16) NOT NULL DEFAULT 'LOCAL',
  `content` text NOT NULL ,
  PRIMARY KEY (`printer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
$csql[27]="select 1 from balloon";
$tsql[27]="CREATE TABLE  `balloon` (
  `balloon_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` char(48) NOT NULL,
  `sid` int(11) NOT NULL ,
  `cid` int(11) NOT NULL ,
  `pid` int(11) NOT NULL ,
  `status` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`balloon_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

if(isset($_POST['do'])){
	require_once("../include/check_post_key.php");
	echo "Executing...<br>";
	for($i=0;isset($tsql[$i]);$i++){
		if(pdo_query($tsql[$i])){
				echo $csql[$i]."<br>";
				pdo_query($csql[$i]);
		}else{
				echo $tsql[$i]."<br>";
		}
		
	}
}
?><b>Update DataBase</b>
	Create New Tables ,drop useless columes.
	<b>Necessary for using plagiarism detection.</b>
	<form action='update_db.php' method=post>
		<?php require_once("../include/set_post_key.php");?>
		<input type='hidden' name='do' value='do'>
		<input type=submit value=Update>
	</form>
	
<?php if (file_exists("update_pw.php")) {	?>
   <a href="update_pw.php">Upgrade all users password storage form to get more security.</a>
   * only do once !
<?php }?>
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
