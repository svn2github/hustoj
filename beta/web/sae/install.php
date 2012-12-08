<?php
	$lvyi_db = new SaeMysql();

	//install
	$sql = file_get_contents( './db.sql' );
	//do
	runquery( $sql );	
	//report
	if( $lvyi_db->errno() != 0 )
	{
	    die( "Error:" . $lvyi_db->errmsg() );
	}
	$lvyi_db->closeDb();

	//include success template
	file_put_contents("saestor://web/msg.txt","Welcome!");

function runquery($sql) {
	global $lvyi_db;
	$sql = str_replace("\r", "\n", $sql );
	$ret = array ();
	$num = 0;
	foreach (explode(";\n", trim($sql)) as $query) {
		$queries = explode("\n", trim($query));
		foreach ($queries as $query) {
			$ret[$num] .= $query[0] == '#' || $query[0] . $query[1] == '--' ? '' : $query;
		}
		$num++;
	}
	unset ($sql);
	$strtip = "";
	foreach ($ret as $query) {
		$query = trim($query);
		if ($query) {
			if (substr($query, 0, 12) == 'CREATE TABLE') {
				$name = preg_replace("/CREATE TABLE\s*([a-z0-9_]+)\s*.*/is", "\\1", $query);
				$res = $lvyi_db->runSql(createtable($query, 'utf8'));
				$tablenum++;
			} else {
				$res = $lvyi_db->runSql($query);
			}
		}
	}
	return true;
}

function createtable($sql, $dbcharset) {
	$type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
	$type = in_array($type, array (
		'MYISAM',
		'HEAP'
	)) ? $type : 'MYISAM';
	return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql) .
	 " ENGINE=$type DEFAULT CHARSET='utf8'";
}


?>
数据库初始化完成，请到<a href=/>首页</a>注册admin并登录，自动取得管理员权限，完成后请删除此页面。
