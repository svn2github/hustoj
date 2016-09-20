<?php
 require_once("admin-header.php");
ini_set("display_errors","On");
require_once("../include/check_get_key.php");
if (!(isset($_SESSION['administrator']))){
        echo "<a href='../loginpage.php'>Please Login First!</a>";
        exit(1);
}
?> 
<?php
  if($OJ_SAE||function_exists('system')){
        $id=intval($_GET['id']);
        
        $basedir = "$OJ_DATA/$id";
        if($OJ_SAE)
			;//need more code to delete files
		else
			system("rm -rf $basedir");
        $sql="delete FROM `problem` WHERE `problem_id`=$id";
        mysqli_query($mysqli,$sql) or die(mysqli_error());
        $sql="select max(problem_id) FROM `problem`" ;
        $result=mysqli_query($mysqli,$sql);
        $row=mysqli_fetch_row($result);
        $max_id=$row[0];
        $max_id++;
        if($max_id<1000)$max_id=1000;
        mysqli_free_result($result);
        $sql="ALTER TABLE problem AUTO_INCREMENT = $max_id;";
        mysqli_query($mysqli,$sql);
        ?>
        <script language=javascript>
                history.go(-1);
        </script>
<?php 
  }else{
  
  
  ?>
        <script language=javascript>
                alert("Nees enable system() in php.ini");
                history.go(-1);
        </script>
  <?php 
  
  }

?>
