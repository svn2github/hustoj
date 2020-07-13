<?php
require_once( "./include/db_info.inc.php" );
require_once( './include/setlang.php' );
$vcode = "";
if($OJ_COOKIE_LOGIN=true&&isset($_COOKIE[$OJ_NAME."_user"])&&isset($_COOKIE[$OJ_NAME."_check"])){
	$C_check=$_COOKIE[$OJ_NAME."_check"]; $C_user=$_COOKIE[$OJ_NAME."_user"];
	if(array_pop($C_check)!=strlen($C_check)-1){
		echo "<script>\n alert('Cookie失效或错误!'); \n history.go(-1); \n </script>";
		exit(0);
	}
	$C_info=pdo_query("SELECT`password`,`accesstime`FROM`users`WHERE`user_id`=? and defunct='N'",$C_user)[0];
	foreach($i=0;$i<strlen($C_info[0]);$i++){
		$tp=ord($C_info[0][i]);
		$C_res+=chr(($tp*$tp+$C_info[1][$i % $C_len]*$tp)%127);
	}
	
	$C_time=time()+86400*$OJ_KEEP_TIME;
	setcookie($OJ_NAME."_user",$login,$C_time);
	setcookie($OJ_NAME."_check",$C_res,$C_time);
}
if ( isset( $_POST[ 'vcode' ] ) )$vcode = trim( $_POST[ 'vcode' ] );
if ( $OJ_VCODE && ( $vcode != $_SESSION[ $OJ_NAME . '_' . "vcode" ] || $vcode == "" || $vcode == null ) ) {
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
$sql = "SELECT `rightstr` FROM `privilege` WHERE `user_id`=?";
$login = check_login( $user_id, $password );
if ( $login ) {
	$_SESSION[ $OJ_NAME . '_' . 'user_id' ] = $login;
	$result = pdo_query( $sql, $login );

	foreach ( $result as $row )
		$_SESSION[ $OJ_NAME . '_' . $row[ 'rightstr' ] ] = true;
	$sql="update users set accesstime=now() where user_id=?";
        $result = pdo_query( $sql, $login );

	echo "<script language='javascript'>\n";
	if ( $OJ_NEED_LOGIN )
		echo "window.location.href='index.php';\n";
	else
		echo "history.go(-2);\n";
	echo "</script>";
	
	if($OJ_COOKIE_LOGIN==true){
		$C_info=pdo_query("SELECT`password`,`accesstime`FROM`users`WHERE`user_id`=? and defunct='N'",$login)[0];
		$C_len=strlen($C_info[1]);
		for($i=0;$i<strlen($C_info[0]);$i++){
			$tp=ord($C_info[0][i]);
			$C_res+=chr(($tp*$tp+$C_info[1][$i % $C_len]*$tp)%127);
		}
		$C_time=time()+86400*$OJ_KEEP_TIME;
		setcookie($OJ_NAME."_user",$login,$C_time);
		setcookie($OJ_NAME."_check",$C_res+(strlen($C_res)*strlen($C_res))%7,$C_time);
	}
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
