<?php 
	$url=basename($_SERVER['REQUEST_URI']);
	$dir=basename(getcwd());
	if($dir=="discuss3") $path_fix="../";
	else $path_fix="";
 	if(isset($OJ_NEED_LOGIN)&&$OJ_NEED_LOGIN&&(
                  $url!='loginpage.php'&&
                  $url!='lostpassword.php'&&
                  $url!='lostpassword2.php'&&
                  $url!='registerpage.php'
                  ) && !isset($_SESSION[$OJ_NAME.'_'.'user_id'])){
 
           header("location:".$path_fix."loginpage.php");
           exit();
        }

	if($OJ_ONLINE){
		require_once($path_fix.'include/online.php');
		$on = new online();
	}
?>
      <!-- Static navbar -->
      <nav class="navbar navbar-default" role="navigation" >
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $OJ_HOME?>"><i class="icon-home"></i><?php echo $OJ_NAME?></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
	      <?php $ACTIVE="class='active'"?>
	      <?php if(!isset($OJ_ON_SITE_CONTEST_ID)){?>
              <li <?php if ($url=="faqs.php") echo " $ACTIVE";?>><a href="<?php echo $path_fix?>faqs.php">
			<span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> <?php echo $MSG_FAQ?></a></li>
		      <?php if ($OJ_BBS){?>
			      <li <?php if ($dir=="discuss3") echo " $ACTIVE";?>><a href="<?php echo $path_fix?>bbs.php<?php if (isset($_GET['cid'])) echo "?cid=".intval($_GET['cid']); ?>"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> <?php echo $MSG_BBS?></a></li>
			      <?php }
		}else{
			if($OJ_BBS){?>
		      <li <?php if ($dir=="discuss3") echo " $ACTIVE";?>><a href="<?php echo $path_fix?>bbs.php<?php echo "?cid=".intval($OJ_ON_SITE_CONTEST_ID); ?>">
				<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span><?php echo $MSG_BBS?></a></li>
		      <?php }
		}
		?>

	      <?php if (isset($OJ_PRINTER)&& $OJ_PRINTER){ ?>
              <li <?php if ($url=="printer.php") echo " $ACTIVE";?>><a href="<?php echo $path_fix?>printer.php"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> <?php echo $MSG_PRINTER?></a></li>
	      <?php }?>
	      <?php if(!isset($OJ_ON_SITE_CONTEST_ID)){?>
              <li <?php if ($url=="problemset.php") echo " $ACTIVE";?>><a href="<?php echo $path_fix?>problemset.php" ><span class="glyphicon glyphicon-book" aria-hidden="true"></span> <?php echo $MSG_PROBLEMS?></a></li>
              <li <?php if ($url=="category.php") echo " $ACTIVE";?>> <a href="<?php echo $path_fix?>category.php"><span class="glyphicon glyphicon-th" aria-hidden="true"></span> <?php echo $MSG_SOURCE?></a></li>
              <li <?php if ($url=="status.php") echo " $ACTIVE";?>><a href="<?php echo $path_fix?>status.php"><span class="glyphicon glyphicon-play-circle" aria-hidden="true"></span> <?php echo $MSG_STATUS?></a></li>
	<?php if(isset($OJ_OI_MODE)&&$OJ_OI_MODE){ 


		}else{?>
              <li <?php if ($url=="ranklist.php") echo " $ACTIVE";?>><a href="<?php echo $path_fix?>ranklist.php"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> <?php echo $MSG_RANKLIST?></a></li>
		<?php } ?>
              <li <?php if ($url=="contest.php") echo " $ACTIVE";?>><a href="<?php echo $path_fix?>contest.php"><span class="glyphicon glyphicon-fire" aria-hidden="true"></span> <?php echo $MSG_CONTEST?></a></li>
		    <?php if(isset($OJ_RECENT_CONTEST)&&$OJ_RECENT_CONTEST){?>
	      		<li <?php if ($url=="recent-contest.php") echo " $ACTIVE";?>><a href="<?php echo $path_fix?>recent-contest.php"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> <?php echo $MSG_RECENT_CONTEST?></a></li>
		    <?php }?>
	      <?php }else{?>
              <li <?php if ($url=="contest.php") echo " $ACTIVE";?>><a href="<?php echo $path_fix?>contest.php<?php echo "?cid=".intval($OJ_ON_SITE_CONTEST_ID); ?>"><span class="glyphicon glyphicon-fire" aria-hidden="true"></span> <?php echo $MSG_CONTEST?></a></li>
	      <?php }?>
<?php if(isset($_GET['cid'])){
	$cid=intval($_GET['cid']);
?>
	      <li><a>[</a></li>
              <li class="active" ><a href="<?php echo $path_fix?>contest.php?cid=<?php echo $cid?>">
			<?php echo $MSG_PROBLEMS?>
	      </a></li>
               <li  class="active" ><a href="<?php echo $path_fix?>status.php?cid=<?php echo $cid?>">
			<?php echo $MSG_STATUS?>
	      </a></li>
              <li  class="active" ><a href="<?php echo $path_fix?>contestrank.php?cid=<?php echo $cid?>">
			<?php echo $MSG_RANKLIST?>
	      </a></li>
              <li  class="active" ><a href="<?php echo $path_fix?>contestrank-oi.php?cid=<?php echo $cid?>">OI
			<?php echo $MSG_RANKLIST?>
	      </a></li>
              <li  class="active" ><a href="<?php echo $path_fix?>conteststatistics.php?cid=<?php echo $cid?>">
			<?php echo $MSG_STATISTICS?>
	      </a></li>
	      <li><a>]</a></li>
<?php }?>
	    
              <!--<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
	-->
            </ul>
	    <ul class="nav navbar-nav navbar-right">
	    <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span id="profile">Login</span><span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
<script src="<?php echo $path_fix."template/$OJ_TEMPLATE/profile.php?".rand();?>" ></script>
              <!--<li><a href="../navbar-fixed-top/">Fixed top</a></li>-->
	    </ul>
	    </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>


