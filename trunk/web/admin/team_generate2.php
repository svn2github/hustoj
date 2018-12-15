<?php require("admin-header.php");
if (!(isset($_SESSION[$OJ_NAME.'_'.'administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}?>
<?php

if(isset($_POST['idlist']) && isset($_POST['pwdlist']) && isset($_POST['nicklist']))
{
	require_once("../include/check_post_key.php");
	require_once("../include/my_func.inc.php");
	
    $idPieces = explode("\n", trim($_POST['idlist']));
    $pwdPieces = explode("\n", trim($_POST['pwdlist']));
	$nickPieces = explode("\n", trim($_POST['nicklist']));

	$teamnumber=count($idPieces);

	if($teamnumber==count($pwdPieces) && $teamnumber==count($nickPieces))
	{
		$ok=true;
		for($i=0;$i<$teamnumber;$i++)
		{
			$idPieces[$i]=trim($idPieces[$i]);
			$pwdPieces[$i]=trim($pwdPieces[$i]);
			$nickPieces[$i]=trim($nickPieces[$i]);

			if(strlen($idPieces[$i])==0)
			{
				echo "<h3>one empty line existed in user id field. all of the users is not inserted.</h3>";
				$ok=false;
			}
			if(strlen($pwdPieces[$i])==0)
			{
				echo "<h3>one empty line existed in password field. all of the users is not inserted.</h3>";
				$ok=false;
			}
			if(strlen($nickPieces[$i])==0)
			{
				echo "<h3>one empty line existed in nickname field. all of the users is not inserted.</h3>";
				$ok=false;
			}
			if (!is_valid_user_name($idPieces[$i])){
				echo "<h3>user id \"".$idPieces[$i]."\" is not valid. all of the users is not inserted.</h3>";
				$ok=false;				
			}
		}

		if($ok)
		{
			echo "<table border=1>";
			echo "<tr><td colspan=3>Copy these accounts to distribute</td></tr>";
			echo "<tr><td>team_name<td>login_id</td><td>password</td></tr>";

			/*
				由于user表使用的是MyISLAM无法使用优雅的事务处理
				由于userid字段不是主键自增，现有的 pdo_query(...) 对于insert操作返回的lastInsertId无法判断数据是否正确添加入数据库
				为了不修改大框架，我只能copy pdo.php部分代码，改用返回值rowCount检查账号是否成功添加
			*/
			if(isset($OJ_SAE)&&$OJ_SAE)	{
				$OJ_DATA="saestor://data/";
				$DB_NAME=SAE_MYSQL_DB;
				$dbh=new PDO("mysql:host=".SAE_MYSQL_HOST_M.';dbname='.SAE_MYSQL_DB, SAE_MYSQL_USER, SAE_MYSQL_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
			}else{
				$dbh=new PDO("mysql:host=".$DB_HOST.';dbname='.$DB_NAME, $DB_USER, $DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
			}
			
			$sql="INSERT INTO `users`("."`user_id`,`email`,`ip`,`accesstime`,`password`,`reg_time`,`nick`,`school`)".
			"VALUES(?,?,?,NOW(),?,NOW(),?,?)on DUPLICATE KEY UPDATE `email`=?,`ip`=?,`accesstime`=NOW(),`password`=?,`reg_time`=now(),nick=?,`school`=?";
			$sth = $dbh->prepare($sql);

			for($i=0;$i<$teamnumber;$i++){
				$user_id=$idPieces[$i];
				$nick=$nickPieces[$i];
				
				$password=pwGen($pwdPieces[$i]);

				$email="your_own_email@internet";
				$school="your_own_school";
				
				$ip = ($_SERVER['REMOTE_ADDR']);
				if( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ){
					$REMOTE_ADDR = $_SERVER['HTTP_X_FORWARDED_FOR'];
					$tmp_ip=explode(',',$REMOTE_ADDR);
					$ip =(htmlentities($tmp_ip[0],ENT_QUOTES,"UTF-8"));
				}

				$rowCount=$sth->execute([$user_id,$email,$ip,$password,$nick,$school,$email,$ip,$password,$nick,$school]);

				if($rowCount==0)
				{
					//数据有误，无法插入数据库
					echo "<tr><td>$nick</td><td>$user_id</td><td>".$pwdPieces[$i]."</td><td><h3>ADD ERROR,MAYBE NICK TOO LONG.</h3></td>";
				}else{
					echo "<tr><td>$nick<td>$user_id</td><td>".$pwdPieces[$i]."</td></tr>";
				}
				
			}
		}

		echo  "</table><br/>";
		
	}else{
		echo "<h3>sorry,the sum of user id is not equal to the sum of Password or Nickname</h3>";
	}
	
	
}

?>
<div class="container">
<b>TeamGenerator2:</b>
<p>the account will be replaced if Login ID exists.</p>
	<form action='team_generate2.php' method=post>
		<div class="row">
			<div class="col-md-4">
			Login ID:<textarea name="idlist" rows="12" cols="40" placeholder="Preset ID of the teams. One ID per line."></textarea>
			</div>
			<div class="col-md-4">
			Password:<textarea name="pwdlist" rows="12" cols="40" placeholder="Preset password of the teams. One password per line."></textarea>
			</div>
			<div class="col-md-4">
			Nickname:<textarea name="nicklist" rows="12" cols="40" placeholder="Preset nicknames of the teams. One name per line."></textarea>
			</div>
		</div>
		<div class="row">
		<br/>
		<?php require_once("../include/set_post_key.php");?>
		<input type=submit value=Generate><br>
		</div>
	</form>

</div>
