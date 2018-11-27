<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../../favicon.ico">

	<title>
		<?php echo $OJ_NAME?>
	</title>

	<?php include("template/$OJ_TEMPLATE/css.php");?>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body>
	<div class="container">
		<?php include("template/$OJ_TEMPLATE/nav.php");?>

		<!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron"></div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<?php
				if ( $pr_flag ) {
					echo "<title>$MSG_PROBLEM" . $row[ 'problem_id' ] . "--" . $row[ 'title' ] . "</title>";
					echo "<center><h3>$id: " . $row[ 'title' ] . "</h3>";
				} else {
					//$PID="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
					$id = $row[ 'problem_id' ];
					echo "<title>$MSG_PROBLEM " . $PID[ $pid ] . ": " . $row[ 'title' ] . " </title>";
					echo "<center><h3>$MSG_PROBLEM " . $PID[ $pid ] . ": " . $row[ 'title' ] . "</h3>";
				}

				echo "<span class=green>$MSG_Time_Limit: </span>" . $row[ 'time_limit' ] . " Sec&nbsp;&nbsp;";
				echo "<span class=green>$MSG_Memory_Limit: </span>" . $row[ 'memory_limit' ] . " MB";

				if ( $row[ 'spj' ] )echo "&nbsp;&nbsp;<span class=red>Special Judge</span>";
				echo "<br><span class=green>$MSG_SUBMIT: </span>" . $row[ 'submit' ] . "&nbsp;&nbsp;";
				echo "<span class=green>$MSG_SOVLED: </span>" . $row[ 'accepted' ] . "<br>";

				if ( $pr_flag ) {
					echo "[<a href='submitpage.php?id=$id'>$MSG_SUBMIT</a>] ";
				} else {
					echo "[<a href='submitpage.php?cid=$cid&pid=$pid&langmask=$langmask'>$MSG_SUBMIT</a>] ";
				}

				echo "[<a href='problemstatus.php?id=" . $row[ 'problem_id' ] . "'>$MSG_STATUS</a>] ";
				echo "[<a href='bbs.php?pid=" . $row[ 'problem_id' ] . "$ucid'>$MSG_BBS</a>] ";
				echo "[$MSG_Creator:<span id='creator'></span>]";

				if ( isset( $_SESSION[ $OJ_NAME . '_' . 'administrator' ] ) ) {
					require_once( "include/set_get_key.php" );
					?> [

				<a href="admin/problem_edit.php?id=<?php echo $id?>&getkey=<?php echo $_SESSION[$OJ_NAME.'_'.'getkey']?>">Edit</a>] [
				<a href='javascript:phpfm(<?php echo $row['problem_id'];?>)'>TestData</a>]

				<?php
				}

				echo "</center>";
				# end of head
				echo "</div>";
				echo "<!--StartMarkForVirtualJudge-->";
				?>

				<div class="panel panel-body">
					<div class='panel panel-default'>
						<div class='panel-heading'>
							<h4>
								<?php echo $MSG_Description?>
							</h4>
						</div>
						<div class='panel-body content'>
							<?php echo $row['description']?>
						</div>
					</div>

					<?php 
        if($row['input']){?>
					<div class='panel panel-default'>
						<div class='panel-heading'>
							<h4>
								<?php echo $MSG_Input?>
							</h4>
						</div>
						<div class='panel-body content'>
							<?php echo $row['input']?>
						</div>
					</div>
					<?php }
        if($row['output']){?>
					<div class='panel panel-default'>
						<div class='panel-heading'>
							<h4>
								<?php echo $MSG_Output?>
							</h4>
						</div>
						<div class='panel-body content'>
							<?php echo $row['output']?>
						</div>
					</div>
					<?php }    
    $sinput=str_replace("<","&lt;",$row['sample_input']);
    $sinput=str_replace(">","&gt;",$sinput);
    $soutput=str_replace("<","&lt;",$row['sample_output']);
    $soutput=str_replace(">","&gt;",$soutput);

        if(strlen($sinput)){?>
					<div class='panel panel-default'>
						<div class='panel-heading'>
							<h4>
								<?php echo $MSG_Sample_Input?>
							</h4>
						</div>
						<div class='panel-body'><pre class=content><span class=sampledata><?php echo $sinput?></span></pre>
						</div>
					</div>
					<?php }

        if(strlen($soutput)){?>
					<div class='panel panel-default'>
						<div class='panel-heading'>
							<h4>
								<?php echo $MSG_Sample_Output?>
							</h4>
						</div>
						<div class='panel-body'><pre class=content><span class=sampledata><?php echo $soutput?></span></pre>
						</div>
					</div>
					<?php }

        if($row['hint']){?>
					<div class='panel panel-default'>
						<div class='panel-heading'>
							<h4>
								<?php echo $MSG_HINT?>
							</h4>
						</div>
						<div class='panel-body content'>
							<?php echo $row['hint']?>
						</div>
					</div>
					<?php }

        if($pr_flag){?>
					<div class='panel panel-default'>
						<div class='panel-heading'>
							<h4>
								<?php echo $MSG_SOURCE?>
							</h4>
						</div>
						<div class='panel-body content'>
							<?php 
              $cats=explode(" ",$row['source']);
              foreach($cats as $cat){
                echo "<a href='problemset.php?search=".htmlentities($cat,ENT_QUOTES,'utf-8')."'>".htmlentities($cat,ENT_QUOTES,'utf-8')."</a>&nbsp;";
            }?>
						</div>
					</div>
					<?php }?>

				</div>
			<center>
				<!--EndMarkForVirtualJudge-->
				<div class='panel-footer'>
					<?php 
        if($pr_flag){
          echo "[<a href='submitpage.php?id=$id'>$MSG_SUBMIT</a>] ";
        }else{
          echo "[<a href='submitpage.php?cid=$cid&pid=$pid&langmask=$langmask'>$MSG_SUBMIT</a>]";
        }
        echo "[<a href='problemstatus.php?id=".$row['problem_id']."'>$MSG_STATUS</a>]";
        //echo "[<a href='bbs.php?pid=".$row['problem_id']."$ucid'>$MSG_BBS</a>]";

        if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])){
          require_once("include/set_get_key.php");
        ?> [

					<a href="admin/problem_edit.php?id=<?php echo $id?>&getkey=<?php echo $_SESSION[$OJ_NAME.'_'.'getkey']?>">Edit</a>] [
					<a href='javascript:phpfm(<?php echo $row['problem_id'];?>)'>TestData</a>]
					<?php } ?>
				</div>
			</center>
		</div>
	</div>
	<!-- /container -->


	<!-- Bootstrap core JavaScript
  ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<?php include("template/$OJ_TEMPLATE/js.php");?>
	<script>
		function phpfm( pid ) {
			//alert(pid);
			$.post( "admin/phpfm.php", {
				'frame': 3,
				'pid': pid,
				'pass': ''
			}, function ( data, status ) {
				if ( status == "success" ) {
					document.location.href = "admin/phpfm.php?frame=3&pid=" + pid;
				}
			} );
		}

		$( document ).ready( function () {
			$( "#creator" ).load( "problem-ajax.php?pid=<?php echo $id?>" );
		} );
	</script>

</body>
</html>