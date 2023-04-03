<?php  	
  $now = time();
  $cid = intval($_GET['cid']);
	$view_cid = $cid;
	//print $cid;
	//check contest valid
	$sql = "SELECT * FROM `contest` WHERE `contest_id`=?";
	$result = pdo_query($sql,$cid);
	$rows_cnt = count($result);
	
	if($rows_cnt>0){
		$row = $result[0];
		$start_time = strtotime($row['start_time']);
		$end_time = strtotime($row['end_time']);
		$view_description = $row['description'];
		$view_title = $row['title'];
		$view_start_time = $row['start_time'];
		$view_end_time = $row['end_time'];
	}
	$contest_ok = true;
	$password = "";

	if (isset($_POST['password']))
		$password = $_POST['password'];

	if (false) {
		$password = stripslashes($password);
	}


	if ($rows_cnt==0) {
		$view_title = "比赛已经关闭!";
	}
	else{
		
		$view_private = $row['private'];
 		$view_contest_creator= $row['user_id'];
		if ($password!="" && $password==$row['password'])
			$_SESSION[$OJ_NAME.'_'.'c'.$cid] = true;

		if ($row['private'] && !isset($_SESSION[$OJ_NAME.'_'.'c'.$cid]))
			$contest_ok = false;

//		if($row['defunct']=='Y')  //defunct problem not in contest/exam list
//			$contest_ok = false;

		if (isset($_SESSION[$OJ_NAME.'_'.'administrator']) || isset($_SESSION[$OJ_NAME.'_'.'contest_creator']))
			$contest_ok = true;

		if (!isset($_SESSION[$OJ_NAME.'_'.'administrator']) && $now<$start_time) {
			$view_errors = "<center>";
			$view_errors .= "<h3>$MSG_CONTEST_ID : $view_cid - $view_title</h3>";
			$view_errors .= "<p>$view_description</p>";
			$view_errors .= "<br>";
			$view_errors .= "<span class=text-success>$MSG_TIME_WARNING</span>";
			$view_errors .= "</center>";
			$view_errors .= "<br><br>";

			require("template/".$OJ_TEMPLATE."/error.php");
			exit(0);
		}
	}

	if (!$contest_ok) {
		$view_errors = "<center>";
		$view_errors .= "<h3>$MSG_CONTEST_ID : $view_cid - $view_title</h3>";
		$view_errors .= "<p>$view_description</p>";
		$view_errors .= "<span class=text-danger>$MSG_PRIVATE_WARNING</span>";

		$view_errors .= "<br><br>";

		$view_errors .= "<div class='btn-group'>";
		$view_errors .= "<a href=contestrank.php?cid=$view_cid class='btn btn-primary'>$MSG_STANDING</a>";
		$view_errors .= "<a href=contestrank-oi.php?cid=$view_cid class='btn btn-primary'>OI$MSG_STANDING</a>";
		$view_errors .= "<a href=conteststatistics.php?cid=$view_cid class='btn btn-primary'>$MSG_STATISTICS</a>";
		$view_errors .= "</div>";

		$view_errors .= "<br><br>";
		$view_errors .= "<table align=center width=80%>";
		$view_errors .= "<tr align='center'>";
		$view_errors .= "<td>";
		$view_errors .= "<form class=form-inline method=post action=contest.php?cid=$cid>";
		$view_errors .= "<input class=input-mini type=password name=password value='' placeholder=$MSG_CONTEST-$MSG_PASSWORD>";
		$view_errors .= "<button class='form-control'>$MSG_SUBMIT</button>";
		$view_errors .= "</form>";
		$view_errors .= "</td>";
		$view_errors .= "</tr>";
		$view_errors .= "</table>";
		$view_errors .= "<br>";

		require("template/".$OJ_TEMPLATE."/error.php");
		exit(0);
	}
