<?php
require_once(realpath(dirname(__FILE__)."/..")."/include/db_info.inc.php");
require_once(realpath(dirname(__FILE__)."/..")."/include/init.php");
require_once(dirname(__FILE__)."/curl.php");

function is_login($remote_site){
	$html=curl_get($remote_site.'/login');
	//echo $html;
	if (str_contains($html,">Log Out</a>")) return true; 
	else return false;
}
function show_vcode($remote_site){
	$url = $remote_site.'/submit'; 
	$imgData=curl_get($url);
	//$pos=mb_strpos($imgData,"lighttpd/1.4.35")+19;
	//$imgBase64 = base64_encode(mb_substr($imgData,$pos,mb_strlen($imgData)-$pos));
	$imgBase64 = base64_encode($imgData);
	return '<img width=200px src="data:image/jpg;base64,'.$imgBase64.'" />';
}
function do_login($remote_site,$username,$password){
	$form= array(
    		'user_id1' => $username,
    		'password1' => $password,
		'B1' => 'login',
		'url' => '/'
	);
	//echo "try login...";
	$data=curl_post_urlencoded($remote_site.'/login',$form);
	//echo htmlentities($remote_site.'/login');
	if(str_contains($data,"Password")) return false;
	else return true;
}
function do_submit_one($remote_site,$username,$sid){
	
	$langMap= array(
    		0 => 1, //C
    		1 => 0, //C++
		3 => 2, //Java
		2 => 3, //Pascal
	);
	$problem_id=1000;
	$language=1;
	$source="";
	
	$sql="select * from solution where solution_id=?";
 	$data=pdo_query($sql,$sid);	
	if(count($data)>0){
		$row=$data[0];
	        $language=$langMap[ $row['language']];
	        $problem_id=$row['problem_id'];
		$sql="select remote_oj,remote_id from problem where problem_id=?";
		$data=pdo_query($sql,$problem_id);
		if(count($data)>0){
			$row=$data[0];
			$problem_id=$row['remote_id'];
		}
	}
	$sql="select * from source_code where solution_id=?";
 	$data=pdo_query($sql,$sid);	
	if(count($data)>0){
		$row=$data[0];
		$source=$row['source'];
	}
	$form=array(
		'problem_id' => $problem_id, 
		'language' => $language,
		'source' => ($source),
		'encoded' => '0'
	);
	//var_dump($form);
	$data=curl_post_urlencoded($remote_site."/submit",$form);
	if(str_contains($data,"Error Occurred")) {
		$sid=0;
	}else{
		$data=curl_get($remote_site."/status?user_id=".$username);
		//echo ($data);
	       	$sid=getPartByMark($data,"Submit Time</td></tr>\n<tr align=center><td>","</td><td><a href=userstatus");
	}
		echo intval($sid);	
	return $sid;
}
function do_submit($remote_site,$remote_user){ 
	global $remote_oj;
	//$sid=4496;
	$sql="select solution_id from solution where result=16 and remote_oj=? order by solution_id";
	$tasks=pdo_query($sql,$remote_oj);
	foreach($tasks as $task){
		//echo $task[0]."<br>";
		$sid=$task[0];	
		$rid=do_submit_one($remote_site,$remote_user,$sid); 
		if($rid>0){
			$sql="update solution set remote_oj=?,remote_id=?,result=17 where solution_id=?";
			pdo_query($sql,$remote_oj,$rid,$sid);
		}
		//40s once
		break;
	}

}
function getResult($short){
	//echo "short:$short<br>";
	$map=array(
		"Accepted" => 4,
		"Runtime Error" => 10,
		"Compile Error" => 11,
		"Wrong Answer" => 6,
		"Presentation Error" => 5,
		"Time Limit Exceeded" => 7,
		"Memory Limit Exceeded" => 8,
		"Output Limit Exceeded" => 9,
		"System Error" => 10,
		"Validator Error" => 10,
	
	);
	return $map[$short];
}
function do_result_one($remote_site,$sid,$rid){
	$html=curl_get($remote_site."/showsource?solution_id=".$rid);
	$data=getPartByMark($html,"User","Source Code");
	$reinfo="";
	$ac=0;
	$result=getPartByMark($data,"Result:</b>","</td>");
	$result=getPartByMark($result,"<font","/font>");
	$result=getPartByMark($result,">","<");
	$result=getResult($result);
	$time=intval(getPartByMark($data,"<b>Time:</b>","MS"));
	$memory=intval(getPartByMark($data,"<b>Memory:</b>","K"));
	echo "$sid : $result<br>";
	if($result==11) {
			$reinfo=curl_get($remote_site."/showcompileinfo?solution_id=".$rid);
			$reinfo=getPartByMark($reinfo,"<pre>","</pre>");
			$sql="insert into compileinfo(solution_id,error) values(?,?) on duplicate key update error=? ";
			pdo_query($sql,$sid,$reinfo,$reinfo);
			$sql="update solution set result=?,pass_rate=?,time=?,memory=? where solution_id=?";
			pdo_query($sql,$result,0,$time,$memory,$sid);
			return $result;	
	}
	if($result==4) $pass_rate=1;else $pass_rate=0;
	$sql="update solution set result=?,pass_rate=?,time=?,memory=?,judger=? where solution_id=?";
	pdo_query($sql,$result,$pass_rate,$time,$memory,get_domain($remote_site),$sid);
	echo $sql,$result,$pass_rate,$time,$memory,get_domain($remote_site),$sid;

	return $result;
}
function do_result($remote_site){
	global $remote_oj;
	$sql="select solution_id,remote_id from solution where remote_oj=? and result=17 order by solution_id ";
	$data=pdo_query($sql,$remote_oj);
	foreach($data as $row){
		$sid=$row['solution_id'];
		$rid=$row['remote_id'];
	//	echo "$sid=>$rid";
		do_result_one($remote_site,$sid,$rid);
	}

}

$remote_oj="pku";
$remote_site="http://poj.org";
$remote_user='hustoj';                // 请修改为你在poj.org注册的机器人账号
$remote_pass='freeproblemset';         // 请修改为你在poj.org注册的机器人账号的密码
$remote_cookie=$OJ_DATA.'/'.get_domain($remote_site).'.cookie';
$remote_delay=3;
if(isset($_POST[$OJ_NAME.'_refer'])){
	header("location:".$_SESSION[$OJ_NAME.'_refer']);
	unset($_SESSION[$OJ_NAME.'_refer']);
}else{
	if(time()-filemtime($remote_cookie.".sub")>$remote_delay){
		do_submit($remote_site,$remote_user);
		touch($remote_cookie.".sub");
	}

	if (!is_login($remote_site)){
		var_dump(do_login($remote_site,$remote_user,$remote_pass));
	}else if(isset($_SESSION[$OJ_NAME.'_refer'])){
		header("location:".$_SESSION[$OJ_NAME.'_refer']);
		unset($_SESSION[$OJ_NAME.'_refer']);
	}
}
do_result($remote_site);
if(isset($_GET['check'])){
	echo "<meta http-equiv='refresh' content='$remote_delay'>";
	echo "$remote_oj<br>";
}
chmod($remote_cookie,0600);
