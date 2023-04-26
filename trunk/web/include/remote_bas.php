<?php
require_once(realpath(dirname(__FILE__)."/..")."/include/db_info.inc.php");
require_once(realpath(dirname(__FILE__)."/..")."/include/init.php");
require_once(dirname(__FILE__)."/curl.php");
function is_login($remote_site){
	$html=curl_get($remote_site.'/mail_index.php');
	if (str_contains($html,"Please login first.")) return false; 
	else return true;
}
function show_vcode($remote_site){
	$url = $remote_site.'/login_xx.php'; 
	$imgData=curl_get($url);
	$imgBase64 = base64_encode($imgData);
	return '<img width=200px src="data:image/jpg;base64,'.$imgBase64.'" />';
}
function do_login($remote_site,$username,$password,$vcode){
	$form= array(
    		'username' => $username,
    		'password' => $password,
		'auth' => $vcode
	);
	 $data=curl_post($remote_site.'/login.php',$form);
	if(str_contains($data,"验证码错误")) return false;
	else return true;
}
function do_submit_one($remote_site,$username,$password,$sid){
	
	$langMap= array(
    		0 => 7, //C
    		1 => 7, //C++
//		3 => 3, //Java
//		2 => 4, //Pascal
		6 => 5  //Python
	);
	$problem_id=3001;
	$language=7;
	$source="";
	
	$sql="select * from solution where solution_id=?";
 	$data=pdo_query($sql,$sid);	
	if(count($data)>0){
		$row=$data[0];
	        if(isset($langMap[ $row['language']])) $language=$langMap[ $row['language']];
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
		if(strlen($source)>20000){
                          $source=substr($source,0,19999);
                }
	}
	$form=array(
		'user_id' => $username,
		'password' => $password,
		'problem_id' => $problem_id, 
		'language' => "$language",
		'data_id' => "bas",
		'source' => $source,
		'submit' => '提交'
	);
	$data=curl_post($remote_site."/acx.php",$form);
	if(str_contains($data,"-2")) {
		$sid=0;
		echo "too frequently";
	}else{
	       	$sid=explode("\n",$data);
	       	$sid=intval($sid[1]);
		echo htmlentities($data)."--".$sid;	
	}
	return $sid;
}
function do_submit($remote_site,$remote_user,$remote_pass){ 
	global $remote_oj;
	$sql="select solution_id from solution where result=16 and remote_oj=? order by solution_id";
	$tasks=pdo_query($sql,$remote_oj);
	foreach($tasks as $task){
		//echo $task[0]."<br>";
		$sid=$task[0];	
		$rid=do_submit_one($remote_site,$remote_user,$remote_pass,$sid); 
		if($rid>0){
			$sql="update solution set remote_oj=?,remote_id=?,result=17 where solution_id=?";
			pdo_query($sql,$remote_oj,$rid,$sid);
		}else{
			break;
		}
		//50ms once
		usleep(150000);
	}
}
function getResult($short){
	//echo "short:$short<br>";
	$map=array(
		"AC" => 4,
		"RE" => 10,
		"CE" => 11,
		"WA" => 6,
		"PE" => 5,
		"TLE" => 7,
		"MLE" => 8,
		"OLE" => 9,
		"RF" => 10,
	);
	return $map[$short];
}
function do_result_one($remote_site,$username,$password,$sid,$rid){
	$form=array(
		'user_id' => $username,
		'password' => $password,
		'runid' => $rid,
		'submit' => '提交'
	);
	$html=curl_post($remote_site."/stux.php",$form);
	$data=explode("\n",$html);
	if ( intval($data[0])<0) return  intval($data[0]);
	$reinfo="";
	$ac=0;
	$result=5;
	$time=0;
	$memory=0;
	echo "<br>==".htmlentities($html)."==";
	if($data[2]=="Waiting"){
		$sql="update solution set result=17,judgetime=now()  where solution_id=?";
		pdo_query($sql,$sid);
		return -1;
	}else if($data[2]=="Compile Error"){
		$reinfo=$html;
		$sql="insert into compileinfo(solution_id,error) values(?,?) on duplicate key update error=? ";
		pdo_query($sql,$sid,$reinfo,$reinfo);
		$result=11;
		$sql="update solution set result=?,pass_rate=?,time=?,memory=?,judgetime=now()  where solution_id=?";
		pdo_query($sql,$result,0,$time,$memory,$sid);
		return $result;	
	}
	//echo "<br>";
	$summary=explode(":",$data[2]);
	$detail=explode(",",$summary[1]);
	$total=count($detail)-1;
	$i=0;
	foreach($detail as $line){
		if ($line=="") continue;
		$i++;
		$re=explode("|",$line);
		echo $re[0]."<br>";
		if($re[0]=="AC") $ac++;
		else $result=getResult($re[0]);
		$m_t=explode("_",$re[1]);
		$memory+=intval($m_t[0]);
		$time+=intval($m_t[1]);
		$reinfo.= $i.":   ". $re[0]." ".intval($m_t[0])."kb  ".intval($m_t[1])."ms \n";
	}
	//echo "[$ac==$i]";
	if($ac==$i) {
		$result=4;
	}
	$sql="insert into runtimeinfo(solution_id,error) values(?,?) on duplicate key update error=? ";
	pdo_query($sql,$sid,$reinfo,$reinfo);
	if($total>0)
	    $pass_rate=floatval($ac)/$total;
	else if ($result==4)
		$pass_rate=1;
	else $pass_rate=0;
	//echo "$sid : $pass_rate<br>";
	$sql="update solution set result=?,pass_rate=?,time=?,memory=?,judger=?,judgetime=now()  where solution_id=?";
	pdo_query($sql,$result,$pass_rate,$time,$memory,get_domain($remote_site),$sid);
	//echo "$sql,$result,$pass_rate,$time,$memory,$sid";
	if($result==4){
                $pc=pdo_query("select problem_id,contest_id from solution where solution_id=?",$sid)[0];
                $pid=$pc[0];
                $cid=$pc[1];
                $sql="update problem set accepted=(select count(1) from solution where result=4 and problem_id=?) where problem_id=?";
                pdo_query($sql,$pid,$pid);
                if($cid>0){
                     $sql="UPDATE `contest_problem` SET `c_accepted`=(SELECT count(*) FROM `solution` WHERE `problem_id`=? AND `result`=4 and contest_id=?) WHERE `problem_id`=? and contest_id=?";
                     pdo_query($sql,$pid,$cid, $pid,$cid);
                }

	}
	return $result;
}
function do_result($remote_site,$remote_user,$remote_pass){
	global $remote_oj;
	$sql="select solution_id,remote_id from solution where remote_oj=? and result=17 order by solution_id ";
	$data=pdo_query($sql,$remote_oj);
	foreach($data as $row){
		$sid=$row['solution_id'];
		$rid=$row['remote_id'];
		echo "$sid=>$rid";
		$ret=do_result_one($remote_site,$remote_user,$remote_pass,$sid,$rid);
		if($ret<0) {
			echo "error code:".$ret;
			break;
		}else{
			usleep(150000);
		}
	}
}
// 本组件由一本通系列教材作者董永建老师委托开发，以GPL v2形式开源，参考本组件的代码进行二次开发，请注意遵守开源协议。
// 判题API由一本通系列OJ开发维护者文仲友老师提供，使用时请遵守基本的互联网礼仪，若出现访问频率过快，提交恶意程序，可能会禁用相关测试账号，敬请谅解。
$remote_oj="bas";
$remote_site="http://www.ssoier.cn:18087/pubtest/";
$remote_user='用户名';    //测试期到2024-8-1结束，一个机构一个账号，请勿外借。
$remote_pass='密码';      //账号、密码加群23361372，找群主登记： 学校或机构	email	手机  后可以申请。
$remote_cookie=$OJ_DATA.'/'.get_domain($remote_site).'.cookie';
$remote_delay=1;
if(isset($_POST['vcode'])){
	do_login($remote_site,$remote_user,$remote_pass,$_POST['vcode']);
	header("location:".$_SESSION[$OJ_NAME.'_refer']);
	unset($_SESSION[$OJ_NAME.'_refer']);
}else{
	if(time()-fileatime($remote_cookie.".sub")>$remote_delay){
		touch($remote_cookie.".sub");
		do_submit($remote_site,$remote_user,$remote_pass);	
	}
	//echo (htmlentities(curl_get($remote_site."/login0.php")));
	if ( false && !is_login($remote_site)){
		$view_errors="$MSG_VCODE".show_vcode($remote_site);
		$view_errors.="	<form method='post' ><input name=vcode ><input type=submit> </form>";
		require(dirname(__FILE__)."/../template/$OJ_TEMPLATE/error.php");
	}else if(isset($_SESSION[$OJ_NAME.'_refer'])){
		header("location:".$_SESSION[$OJ_NAME.'_refer']);
		unset($_SESSION[$OJ_NAME.'_refer']);
	}
}
if(time()-fileatime(__FILE__)>$remote_delay){
	touch(__FILE__);
	do_result($remote_site,$remote_user,$remote_pass);
}
if(isset($_GET['check'])){
	$remote_delay*=2;
	echo "<meta http-equiv='refresh' content='$remote_delay'>";
	echo "$remote_oj<br>";
}

chmod($remote_cookie,0600);
