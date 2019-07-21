<?php
function pdo_query($sql){
    $num_args = func_num_args();
    $args = func_get_args();       //获得传入的所有参数的数组
    $args=array_slice($args,1,--$num_args);
    
    global $DB_HOST,$DB_NAME,$DB_USER,$DB_PASS,$dbh,$OJ_SAE,$OJ_TEMPLATE;
    try{
	    if(!$dbh){
				
			if(isset($OJ_SAE)&&$OJ_SAE)	{
				$OJ_DATA="saestor://data/";
			//  for sae.sina.com.cn
				$DB_NAME=SAE_MYSQL_DB;
				$dbh=new PDO("mysql:host=".SAE_MYSQL_HOST_M.';dbname='.SAE_MYSQL_DB, SAE_MYSQL_USER, SAE_MYSQL_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
			}else{
				$dbh=new PDO("mysql:host=".$DB_HOST.';dbname='.$DB_NAME, $DB_USER, $DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
			}
			
	    }
	    $sth = $dbh->prepare($sql);
	    $sth->execute($args);
	    $result=array();
	    if(stripos($sql,"select") === 0){
		$result=$sth->fetchAll();
	    }else if(stripos($sql,"insert") === 0){
		$result=$dbh->lastInsertId();
	    }else{
		$result=$sth->rowCount();
	    }
	    //print($sql);
	    $sth->closeCursor();
	    return $result;
    }catch(PDOException $e){
	if(stristr($e->getMessage(),"Access denied")) 
		$view_errors="Database account/password fail, check db_info.inc.php<br>\n数据库账户密码错误，请检查配置文件db_info.inc.php";
	else
		$view_errors="SQL error,check your sql and /var/log/nginx/error.log !";
	require("template/".$OJ_TEMPLATE."/error.php");
	exit(0);
    }
}
?>
