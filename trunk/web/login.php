<?php
require_once( "./include/db_info.inc.php" );
require_once( './include/setlang.php' );
$use_cookie=false;
$login=false;
if($OJ_COOKIE_LOGIN=true&&isset($_COOKIE[$OJ_NAME."_user"])&&isset($_COOKIE[$OJ_NAME."_check"])){
	$C_check=$_COOKIE[$OJ_NAME."_check"]; 
	$C_user=$_COOKIE[$OJ_NAME."_user"];
	$use_cookie=true;
	$C_num=strlen($C_check)-1;
	$C_num=($C_num*$C_num)%7;
	if($C_check[strlen($C_check)-1]!=$C_num){
		setcookie($OJ_NAME."_check","",0);
		setcookie($OJ_NAME."_user","",0);
		echo "<script>\n alert('Cookie失效或错误!(-1)'); \n history.go(-1); \n </script>";
		exit(0);
	} 
	$C_info=pdo_query("SELECT `password`,`accesstime` FROM `users` WHERE `user_id`=? and defunct='N'",$C_user)[0];
	$C_len=strlen($C_info[1]);
	for($i=0;$i<strlen($C_info[0]);$i++){
		$tp=ord($C_info[0][$i]);
		$C_res.=chr(39+($tp*$tp+ord($C_info[1][$i % $C_len])*$tp)%88);
	}
	if(substr($C_check,0,-1)==sha1($C_res))
		$login=$C_user;
	else{   
		setcookie($OJ_NAME."_check","",0);
		setcookie($OJ_NAME."_user","",0);
		echo "<script>\n alert('Cookie失效或错误!(-2)'); \n history.go(-1); \n </script>";
		exit(0);
	}
}
$vcode="";
if(!$use_cookie){
  if(isset($_POST[ 'vcode' ]))$vcode=trim($_POST['vcode']);
  if($OJ_VCODE&&( $vcode != $_SESSION[ $OJ_NAME . '_' . "vcode" ] || $vcode == "" || $vcode == null ) ) {
	echo "<script language='javascript'>\n";
	echo "alert('Verify Code Wrong!');\n";
	echo "history.go(-1);\n";
	echo "</script>";
	exit( 0 );
  }
  $view_errors = "";
  require_once( "./include/login-" . $OJ_LOGIN_MOD . ".php" );
  $user_id = $_POST[ 'user_id' ];
  $password = $_POST[ 'password' ];
  if ( get_magic_quotes_gpc() ) {
	$user_id = stripslashes( $user_id );
	$password = stripslashes( $password );
  }
  $sql = "SELECT * FROM `privilege` WHERE `user_id`=?";
  $login = check_login( $user_id, $password );
}
if($login){
	$_SESSION[ $OJ_NAME . '_' . 'user_id' ] = $login;
	$result = pdo_query( $sql, $login );

	foreach ( $result as $row ){
		if(isset($row[ 'valuestr' ]))
                        $_SESSION[ $OJ_NAME . '_' . $row[ 'rightstr' ] ] = $row[ 'valuestr' ];
                else
                        $_SESSION[ $OJ_NAME . '_' . $row[ 'rightstr' ] ] = true;
	}
		
	$sql="update users set accesstime=now() where user_id=?";
        $result = pdo_query( $sql, $login );

	if($OJ_LONG_LOGIN){
		$C_info=pdo_query("SELECT `password` , `accesstime` FROM`users` WHERE`user_id`=? and defunct='N'",$login)[0];
		$C_len=strlen($C_info[1]);
		$C_res="";
		for($i=0;$i<strlen($C_info[0]);$i++){
			$tp=ord($C_info[0][$i]);
			$C_res.=chr(39+($tp*$tp+ord($C_info[1][$i % $C_len])*$tp)%88);
		}
		$C_res=sha1($C_res);
		$C_time=time()+86400*$OJ_KEEP_TIME;
		setcookie($OJ_NAME."_user",$login,time()+$C_time);
		setcookie($OJ_NAME."_check",$C_res.(strlen($C_res)*strlen($C_res))%7,$C_time);
	}
	echo "<script language='javascript'>\n";
	if ($OJ_NEED_LOGIN)
		echo "window.location.href='index.php';\n";
	else
		echo "setTimeout('history.go(-2)',500);\n";
	echo "</script>";
} else {
	if ( $view_errors ) {
		require( "template/" . $OJ_TEMPLATE . "/error.php" );
	} else {
		echo "<script language='javascript'>\n";
		echo "alert('UserName or Password Wrong!');\n";
		echo "history.go(-1);\n";
		echo "</script>";
	}
}
?>
