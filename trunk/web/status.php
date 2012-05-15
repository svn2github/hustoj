<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

////////////////////////////Common head
	$cache_time=2;
	$OJ_CACHE_SHARE=false;
	require_once('./include/cache_start.php');
    require_once('./include/db_info.inc.php');
	require_once('./include/setlang.php');
	$view_title= "$MSG_STATUS";
	

        
require_once("./include/my_func.inc.php");

if(isset($OJ_LANG)){
                require_once("./lang/$OJ_LANG.php");
        }
require_once("./include/const.inc.php");

$str2="";

$sql="SELECT * FROM `solution` WHERE 1 ";
if (isset($_GET['cid'])){
        $cid=intval($_GET['cid']);
        $sql=$sql." AND `contest_id`='$cid' and num>=0 ";
        $str2=$str2."&cid=$cid";
        //require_once("contest-header.php");
}else{
        //require_once("oj-header.php");
}
$start_first=true;
$order_str=" ORDER BY `solution_id` DESC ";



// check the top arg
if (isset($_GET['top'])){
        $top=strval(intval($_GET['top']));
        if ($top!=-1) $sql=$sql."AND `solution_id`<='".$top."' ";
}

// check the problem arg
$problem_id="";
if (isset($_GET['problem_id'])&&$_GET['problem_id']!=""){
	
	if(isset($_GET['cid'])){
		$problem_id=$_GET['problem_id'];
		$num=strpos($PID,$problem_id);
		$sql=$sql."AND `num`='".$num."' ";
        $str2=$str2."&problem_id=".$problem_id;
        
	}else{
        $problem_id=strval(intval($_GET['problem_id']));
        if ($problem_id!='0'){
                $sql=$sql."AND `problem_id`='".$problem_id."' ";
                $str2=$str2."&problem_id=".$problem_id;
        }
        else $problem_id="";
	}
}
// check the user_id arg
$user_id="";
if (isset($_GET['user_id'])){
        $user_id=trim($_GET['user_id']);
        if (is_valid_user_name($user_id) && $user_id!=""){
                $sql=$sql."AND `user_id`='".$user_id."' ";
                if ($str2!="") $str2=$str2."&";
                $str2=$str2."user_id=".$user_id;
        }else $user_id="";
}
if (isset($_GET['language'])) $language=intval($_GET['language']);
else $language=-1;

if ($language>9 || $language<0) $language=-1;
if ($language!=-1){
        $sql=$sql."AND `language`='".strval($language)."' ";
        $str2=$str2."&language=".$language;
}
if (isset($_GET['jresult'])) $result=intval($_GET['jresult']);
else $result=-1;

if ($result>12 || $language<0) $language=-1;
if ($result!=-1){
        $sql=$sql."AND `result`='".strval($result)."' ";
        $str2=$str2."&jresult=".$result;
}



if($OJ_SIM){
        $old=$sql;
        $sql="select * from ($sql order by solution_id desc limit 20) solution left join `sim` on solution.solution_id=sim.s_id WHERE 1 ";
        if(isset($_GET['showsim'])&&intval($_GET['showsim'])>0){
                $showsim=intval($_GET['showsim']);
                $sql="select * from ($old ) solution 
                     left join `sim` on solution.solution_id=sim.s_id WHERE result=4 and sim>=$showsim";
                $sql="SELECT * FROM ($sql) `solution`
                        left join(select solution_id old_s_id,user_id old_user_id from solution) old
                        on old.old_s_id=sim_s_id WHERE  old_user_id!=user_id and sim_s_id!=solution_id ";
                $str2.="&showsim=$showsim";
        }
        //$sql=$sql.$order_str." LIMIT 20";
}






$sql=$sql.$order_str." LIMIT 20";
//echo $sql;




if($OJ_MEMCACHE){
	require("./include/memcache.php");
	$result = mysql_query_cache($sql);// or die("Error! ".mysql_error());
	if($result) $rows_cnt=count($result);
	else $rows_cnt=0;
}else{
		
	$result = mysql_query($sql);// or die("Error! ".mysql_error());
	if($result) $rows_cnt=mysql_num_rows($result);
	else $rows_cnt=0;
}
$top=$bottom=-1;
$cnt=0;
if ($start_first){
        $row_start=0;
        $row_add=1;
}else{
        $row_start=$rows_cnt-1;
        $row_add=-1;
}

$view_status=Array();

for ($i=0;$i<$rows_cnt;$i++){
if($OJ_MEMCACHE)
	$row=$result[$i];
else
	$row=mysql_fetch_array($result);
	//$view_status[$i]=$row;
	
		if ($top==-1) $top=$row['solution_id'];
        $bottom=$row['solution_id'];
		$flag=(!is_running(intval($row['contest_id']))) ||
                        isset($_SESSION['source_browser']) ||
                        isset($_SESSION['administrator']) || 
                        (isset($_SESSION['user_id'])&&!strcmp($row['user_id'],$_SESSION['user_id']));

        $cnt=1-$cnt;
	

        $view_status[$i][0]=$row['solution_id'];
       
        
        $view_status[$i][1]= "<a href='userinfo.php?user=".$row['user_id']."'>".$row['user_id']."</a>";


       if ($row['contest_id']>0) {
                $view_status[$i][2]= "<div class=center><a href='problem.php?cid=".$row['contest_id']."&pid=".$row['num']."'>";
                if(isset($cid)){
                        $view_status[$i][2].= $PID[$row['num']];
                }else{
                        $view_status[$i][2].= $row['problem_id'];
                }
				$view_status[$i][2].="</div></a>";
        }else{
                $view_status[$i][2]= "<div class=center><a href='problem.php?id=".$row['problem_id']."'>".$row['problem_id']."</a></div>";
        }

       
        if (intval($row['result'])==11 && ((isset($_SESSION['user_id'])&&$row['user_id']==$_SESSION['user_id']) || isset($_SESSION['source_browser']))){
                $view_status[$i][3]= "<a href='ceinfo.php?sid=".$row['solution_id']."' class=".$judge_color[$row['result']].">".$judge_result[$row['result']]."</a>";
        }else if (intval($row['result'])==10 && ((isset($_SESSION['user_id'])&&$row['user_id']==$_SESSION['user_id']) || isset($_SESSION['source_browser']))){
                $view_status[$i][3]= "<a href='reinfo.php?sid=".$row['solution_id']."' class=".$judge_color[$row['result']].">".$judge_result[$row['result']]."</a>";

        }else{

                if($OJ_SIM&&$row['sim']>80&&$row['sim_s_id']!=$row['s_id']) {
                        $view_status[$i][3]= "<span class=".$judge_color[$row['result']].">*".$judge_result[$row['result']]."</span>-<span class=red>";
                       
                        if( isset($_SESSION['source_browser'])){

                                        $view_status[$i][3].= "<a href=showsource.php?id=".$row['sim_s_id']." target=original>".$row['sim_s_id']."(".$row['sim']."%)</a>";
                        }else{

                                        $view_status[$i][3].= $row['sim_s_id'];

                        }
                        if(isset($_GET['showsim'])&&isset($row[13])){
                                        $view_status[$i][3].= "$row[13]";
                                
                        }
                        $view_status[$i][3].="</span>";
                }else{

                        $view_status[$i][3]= "<span class=".$judge_color[$row['result']].">".$judge_result[$row['result']];
                }
                
        }
        if (isset($row['pass_rate'])&&$row['pass_rate']>0&&$row['pass_rate']<.98) 
				$view_status[$i][3].= (100-$row['pass_rate']*100)."%";
        if ($flag){


                if ($row['result']>=4){
                        $view_status[$i][4]= "<div id=center class=red>".$row['memory']."</div>";
                        $view_status[$i][5]= "<div id=center class=red>".$row['time']."</div>";
						//echo "=========".$row['memory']."========";
                }else{
                        $view_status[$i][4]= "---";
                        $view_status[$i][5]= "---";
						
                }
				//echo $row['result'];
                if (!(isset($_SESSION['user_id'])&&strtolower($row['user_id'])==strtolower($_SESSION['user_id']) || isset($_SESSION['source_browser']))){
                        $view_status[$i][6]=$language_name[$row['language']];
                }else{

                        $view_status[$i][6]= "<a target=_blank href=showsource.php?id=".$row['solution_id'].">".$language_name[$row['language']]."</a>/";

                        if (isset($cid)) {
                                $view_status[$i][6].= "<a target=_self href=\"submitpage.php?cid=".$cid."&pid=".$row['num']."&sid=".$row['solution_id']."\">Edit</a>";
                        }else{
                                $view_status[$i][6].= "<a target=_self href=\"submitpage.php?id=".$row['problem_id']."&sid=".$row['solution_id']."\">Edit</a>";
                        }
                }
                $view_status[$i][7]= $row['code_length']." B";
				
        }else
		{
			$view_status[$i][4]="----";
			$view_status[$i][5]="----";
			$view_status[$i][6]="----";
			$view_status[$i][7]="----";
		}
        $view_status[$i][8]= $row['in_date'];
        
   
   

}
if(!$OJ_MEMCACHE)mysql_free_result($result);








?>

<?php
/////////////////////////Template
if (isset($_GET['cid']))
	require("template/".$OJ_TEMPLATE."/conteststatus.php");
else
	require("template/".$OJ_TEMPLATE."/status.php");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>

