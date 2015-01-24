<?php $url=basename($_SERVER['REQUEST_URI']);?>
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
            <a class="navbar-brand" href="<?php echo $OJ_HOME?>"><?php echo $OJ_NAME?></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
	      <?php $ACTIVE="class='active'"?>
<!--              <li <?php if ($url=="discus.php") echo " $ACTIVE";?>><a href="bbs.php"><?php echo $MSG_BBS?></a></li>
-->
              <li <?php if ($url=="problemset.php") echo " $ACTIVE";?>><a href="problemset.php"><?php echo $MSG_PROBLEMS?></a></li>
              <li <?php if ($url=="status.php") echo " $ACTIVE";?>><a href="status.php"><?php echo $MSG_STATUS?></a></li>
              <li <?php if ($url=="ranklist.php") echo " $ACTIVE";?>><a href="ranklist.php"><?php echo $MSG_RANKLIST?></a></li>
              <li <?php if ($url=="contest.php") echo " $ACTIVE";?>><a href="contest.php"><?php echo $MSG_CONTEST?></a></li>
<?php if(isset($_GET['cid'])){
	$cid=intval($_GET['cid']);
?>
	      <li><a>[</a></li>
              <li class="active" ><a href="contest.php?cid=<?php echo $cid?>">
			<?php echo $MSG_PROBLEMS?>
	      </a></li>
               <li  class="active" ><a href="status.php?cid=<?php echo $cid?>">
			<?php echo $MSG_STATUS?>
	      </a></li>
              <li  class="active" ><a href="contestrank.php?cid=<?php echo $cid?>">
			<?php echo $MSG_RANKLIST?>
	      </a></li>
              <li  class="active" ><a href="conteststatistics.php?cid=<?php echo $cid?>">
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
<script src="<?php echo "template/$OJ_TEMPLATE/profile.php?".rand();?>" ></script>
              <!--<li><a href="../navbar-fixed-top/">Fixed top</a></li>-->
	    </ul>
	    </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>


