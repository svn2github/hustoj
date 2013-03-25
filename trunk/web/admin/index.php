<?php require_once("admin-header.php");
	if(isset($OJ_LANG)){
		require_once("../lang/$OJ_LANG.php");
	}
?>

<html>
<head>
<title>OJ Administration</title>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel=stylesheet href='admin.css' type='text/css'>
</head>
<body>



<div class="container-fluid">
<div class="navbar">
 	<div class="navbar-inner navbar-fixed-top" style="visibility: visible; position: fixed;">
 		<a  class='brand'  href="<?php echo $OJ_HOME?>">
			ADMIN PANEL					
		</a>
</div>
</div>
	<div class="row-fluid top-space">
		<div class="span2">
			<div class="menu-group">
				<?php require_once("menu.php") ?>
			</div>
		</div>
		<div class="span10">
			<?php if (isset($_SESSION['administrator'])){
				if(isset($_POST['news_add'])){
					require("news_add_page.php");
				}
				if(isset($_POST['news_list'])){
					require("news_list.php");
				}
				if(isset($_POST['problem_add_page'])){
					require("problem_add_page.php");
				}
				if(isset($_POST['problem_list'])){
					require("problem_list.php");
				}	
				if(isset($_POST['contest_add'])){
					require("contest_add.php");
				}	
				if(isset($_POST['contest_list'])){
					require("contest_list.php");
				}	
				if(isset($_POST['team_generate'])){
					require("team_generate.php");
				}	
				if(isset($_POST['setmsg'])){
					require("setmsg.php");
				}	
				if(isset($_POST['changepass'])){
					require("changepass.php");
				}	
				if(isset($_POST['rejudge'])){
					require("rejudge.php");
				}	
				if(isset($_POST['privilege_add'])){
					require("privilege_add.php");
				}	
				if(isset($_POST['privilege_list'])){
					require("privilege_list.php");
				}	
				if(isset($_POST['source_give'])){
					require("source_give.php");
				}	
				if(isset($_POST['problem_export'])){
					require("problem_export.php");
				}	
				if(isset($_POST['problem_import'])){
					require("problem_import.php");
				}	
				if(isset($_POST['update_db'])){
					require("update_db.php");
				}	
				if(isset($_POST['online'])){
					require("../online.php");
				}	
				if(isset($_POST['problem_copy'])){
					require("problem_copy.php");
				}	
				if(isset($_POST['problem_changeid'])){
					require("problem_changeid.php");
				}	

			}
			?>
		</div>

</body>
</html>