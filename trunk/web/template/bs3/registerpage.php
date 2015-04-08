<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title><?php echo $OJ_NAME?></title>  
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
      <div class="jumbotron">
<form action="register.php" method="post">
<br><br>
<center><table>
<tr><td colspan=2 height=40 width=500>&nbsp;&nbsp;&nbsp;<?php echo $MSG_REG_INFO?></td></tr>
<tr><td width=25%><?php echo $MSG_USER_ID?>:</td>
<td width=75%><input name="user_id" size=20 type=text placeholder="*"></td>
</tr>
<tr><td><?php echo $MSG_NICK?>:</td>
<td><input name="nick" size=50 type=text></td>
</tr>
<tr><td><?php echo $MSG_PASSWORD?>:</td>
<td><input name="password" size=20 type=password placeholder="*"></td>
</tr>
<tr><td><?php echo $MSG_REPEAT_PASSWORD?>:</td>
<td><input name="rptpassword" size=20 type=password placeholder="*"></td>
</tr>
<tr><td><?php echo $MSG_SCHOOL?>:</td>
<td><input name="school" size=30 type=text></td>
</tr>
<tr><td><?php echo $MSG_EMAIL?>:</td>
<td><input name="email" size=30 type=text></td>
</tr>
<?php if($OJ_VCODE){?>
<tr><td><?php echo $MSG_VCODE?>:</td>
<td><input name="vcode" size=4 type=text><img alt="click to change" src="vcode.php" onclick="this.src='vcode.php?'+Math.random()">*</td>
</tr>
<?php }?>
<tr><td></td>
<td><input value="Submit" name="submit" type="submit"><input value="Reset" name="reset" type="reset"></td>
</tr>
</table></center>
<br><br>
</form>

      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php include("template/$OJ_TEMPLATE/js.php");?>	    
   <script>
         $("input").attr("class","form-control");
   </script>
  </body>
</html>
