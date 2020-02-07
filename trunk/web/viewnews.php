<?php
////////////////////////////Common head
$cache_time = 30;
$OJ_CACHE_SHARE = true;
$news_id=$_GET["id"];
require_once( './include/cache_start.php' );
require_once( './include/db_info.inc.php' );
require_once( './include/memcache.php' );
require_once( './include/setlang.php' );
$view_title = "Welcome To Online Judge";
$result = false;
if ( isset( $OJ_ON_SITE_CONTEST_ID ) ) {
	header( "location:contest.php?cid=" . $OJ_ON_SITE_CONTEST_ID );
	exit();
}
///////////////////////////MAIN	

$view_news = "";
$sql = "select * "
. "FROM `news` "
. "WHERE `defunct`!='Y' && `news_id`='$news_id'"
. "ORDER BY `importance` ASC,`time` DESC "
. "LIMIT 50";
$result = mysql_query_cache( $sql ); //mysql_escape_string($sql));
if ( !$result ) {
	$new_title = $news_content = "公告不存在!";
} else {
	foreach ( $result as $row ) {
		$news_title=$row['title'];
		$news_content=$row['content'];
		$news_writer=$row['user_id'];
		$news_date=$row['time'];
	}
}
$view_apc_info = "";

$sql = "SELECT UNIX_TIMESTAMP(date(in_date))*1000 md,count(1) c FROM (select * from solution order by solution_id desc limit 8000) solution  where result<13 group by md order by md desc limit 200";
$result = mysql_query_cache( $sql ); //mysql_escape_string($sql));
$chart_data_all = array();
//echo $sql;

foreach ( $result as $row ) {
	array_push( $chart_data_all, array( $row[ 'md' ], $row[ 'c' ] ) );
}

$sql = "SELECT UNIX_TIMESTAMP(date(in_date))*1000 md,count(1) c FROM  (select * from solution order by solution_id desc limit 8000) solution where result=4 group by md order by md desc limit 200";
$result = mysql_query_cache( $sql ); //mysql_escape_string($sql));
$chart_data_ac = array();
//echo $sql;

foreach ( $result as $row ) {
	array_push( $chart_data_ac, array( $row[ 'md' ], $row[ 'c' ] ) );
}
if ( isset( $_SESSION[ $OJ_NAME . '_' . 'administrator' ] ) ) {
	$sql = "select avg(sp) sp from (select  avg(1) sp,judgetime from solution where result>3 and judgetime>date_sub(now(),interval 1 hour)  group by (judgetime DIV 60 * 60) order by sp) tt;";
	$result = mysql_query_cache( $sql );
	$speed = ( $result[ 0 ][ 0 ] ? $result[ 0 ][ 0 ] : 0 ) . '/min';
} else {
	$speed = ( $chart_data_all[ 0 ][ 1 ] ? $chart_data_all[ 0 ][ 1 ] : 0 ) . '/day';
}

/////////////////////////Template
require( "template/" . $OJ_TEMPLATE . "/viewnews.php" );
/////////////////////////Common foot
if ( file_exists( './include/cache_end.php' ) )
	require_once( './include/cache_end.php' );
?>
