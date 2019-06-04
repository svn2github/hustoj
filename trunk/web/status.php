<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

////////////////////////////Common head
	$cache_time=2;
	$OJ_CACHE_SHARE=false;
	require_once('./include/cache_start.php');
    require_once('./include/db_info.inc.php');
    require_once('./include/memcache.php');
	require_once('./include/setlang.php');
	$view_title= "$MSG_STATUS";
	

        
require_once("./include/my_func.inc.php");
if(isset($OJ_LANG)){
                require_once("./lang/$OJ_LANG.php");
        }
require_once("./include/const.inc.php");

if($OJ_TEMPLATE!="classic") 
	$judge_color=Array("label gray","label label-info","label label-warning","label label-warning","label label-success","label label-danger","label label-danger","label label-warning","label label-warning","label label-warning","label label-warning","label label-warning","label label-warning","label label-info");

$str2="";
$lock=false;
$lock_time=date("Y-m-d H:i:s",time());
$sql="WHERE problem_id>0 ";
if (isset($_GET['cid'])){
        $cid=intval($_GET['cid']);
        $sql=$sql." AND `contest_id`='$cid' and num>=0 ";
        $str2=$str2."&cid=$cid";
        $sql_lock="SELECT `start_time`,`title`,`end_time` FROM `contest` WHERE `contest_id`=?";
        $result=pdo_query($sql_lock,$cid) ;
        $rows_cnt=count($result);
        $start_time=0;
        $end_time=0;
        if ($rows_cnt>0){
                 $row=$result[0];
                $start_time=strtotime($row[0]);
                $title=$row[1];
                $end_time=strtotime($row[2]);       
        }
        $lock_time=$end_time-($end_time-$start_time)*$OJ_RANK_LOCK_PERCENT;
  //$lock_time=date("Y-m-d H:i:s",$lock_time);
        $time_sql="";
        //echo $lock.'-'.date("Y-m-d H:i:s",$lock);
        if(time()>$lock_time&&time()<$end_time){
          //$lock_time=date("Y-m-d H:i:s",$lock_time);
          //echo $time_sql;
           $lock=true;
        }else{
           $lock=false;
        }
        
        //require_once("contest-header.php");
}else{
        //require_once("oj-header.php");
  if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])
	||isset($_SESSION[$OJ_NAME.'_'.'source_browser'])
	||(isset($_SESSION[$OJ_NAME.'_'.'user_id'])
	&&(isset($_GET['user_id'])&&$_GET['user_id']==$_SESSION[$OJ_NAME.'_'.'user_id']))
  ){
      if ($_SESSION[$OJ_NAME.'_'.'user_id']!="guest")
      		$sql="WHERE 1 ";
  }else{
      $sql="WHERE problem_id>0 ";
  }
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
		$problem_id=htmlentities($_GET['problem_id'],ENT_QUOTES,'UTF-8');
		$num=strpos($PID,$problem_id);
		$problem_id=$PID[$num];
		$sql=$sql."AND `num`='".$num."' ";
        $str2=$str2."&problem_id=".trim($problem_id);
        
	}else{
        $problem_id=strval(intval($_GET['problem_id']));
        if ($problem_id!='0'){
                $sql=$sql."AND `problem_id`='".$problem_id."' ";
                $str2=$str2."&problem_id=".trim($problem_id);
        }
        else $problem_id="";
	}
}
// check the user_id arg
$user_id="";
if(isset($OJ_ON_SITE_CONTEST_ID)&&$OJ_ON_SITE_CONTEST_ID>0&&!isset($_SESSION[$OJ_NAME.'_'.'administrator'])){		
 	$_GET['user_id']=$_SESSION[$OJ_NAME.'_'.'user_id'];		
}
if (isset($_GET['user_id'])){
        $user_id=trim($_GET['user_id']);
        if (is_valid_user_name($user_id) && $user_id!=""){
			if($OJ_MEMCACHE){
                $sql=$sql."AND `user_id`='".addslashes($user_id) ."' ";
			}else{
                $sql=$sql."AND `user_id`=? ";
			}
                if ($str2!="") $str2=$str2."&";
                $str2=$str2."user_id=".urlencode($user_id);
        }else $user_id="";
}
if (isset($_GET['language'])) $language=intval($_GET['language']);
else $language=-1;

if ($language>count($language_ext) || $language<0) $language=-1;
if ($language!=-1){
        $sql=$sql."AND `language`='".($language)."' ";
        $str2=$str2."&language=".$language;
}
if (isset($_GET['jresult'])) $result=intval($_GET['jresult']);
else $result=-1;

if ($result>12 || $result<0) $result=-1;
if ($result!=-1&&!$lock){
        $sql=$sql."AND `result`='".($result)."' ";
        $str2=$str2."&jresult=".$result;
}



if($OJ_SIM){
       // $old=$sql;
        $sql="select * from solution solution left join `sim` sim on solution.solution_id=sim.s_id ".$sql;
        if(isset($_GET['showsim'])&&intval($_GET['showsim'])>0){
                $showsim=intval($_GET['showsim']);
        	$sql.=" and sim.sim>=$showsim";
                $str2.="&showsim=$showsim";
        }
	
        //$sql=$sql.$order_str." LIMIT 20";
}else{
 	$sql="select * from `solution` ".$sql;
}
	//echo $sql;






$sql=$sql.$order_str." LIMIT 20";
//echo $sql;




	if (isset($_GET['user_id'])){
		$result = pdo_query($sql,$user_id);
	}else{
		$result = mysql_query_cache($sql);
	}
	
	if($result) $rows_cnt=count($result);
	else $rows_cnt=0;
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

$last=0;
for ($i=0;$i<$rows_cnt;$i++){

        $row=$result[$i];
        //$view_status[$i]=$row;
        if($i==0&&$row['result']<4) $last=$row['solution_id'];

	
		if ($top==-1) $top=$row['solution_id'];
        $bottom=$row['solution_id'];
		$flag=(!is_running(intval($row['contest_id']))) ||
                        isset($_SESSION[$OJ_NAME.'_'.'source_browser']) ||
                        isset($_SESSION[$OJ_NAME.'_'.'administrator']) || 
                        (isset($_SESSION[$OJ_NAME.'_'.'user_id'])&&!strcmp($row['user_id'],$_SESSION[$OJ_NAME.'_'.'user_id']));

        $cnt=1-$cnt;
	

        $view_status[$i][0]=$row['solution_id'];
       
        if ($row['contest_id']>0) {
		
                if (isset($_SESSION[$OJ_NAME.'_'.'administrator']))
                	$view_status[$i][1]= "<a href='contestrank.php?cid=".$row['contest_id']."&user_id=".$row['user_id']."#".$row['user_id']."' title='".$row['ip']."'>".$row['user_id']."</a>";
		else
                	$view_status[$i][1]= "<a href='contestrank.php?cid=".$row['contest_id']."&user_id=".$row['user_id']."#".$row['user_id']."'>".$row['user_id']."</a>";
        }else{
                if (isset($_SESSION[$OJ_NAME.'_'.'administrator']))
			$view_status[$i][1]= "<a href='userinfo.php?user=".$row['user_id']."' title='".$row['ip']."'>".$row['user_id']."</a>";
		else
                	$view_status[$i][1]= "<a href='userinfo.php?user=".$row['user_id']."'>".$row['user_id']."</a>";
        }

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
	switch($row['result']){
		case 4:
			$MSG_Tips=$MSG_HELP_AC;break;
		case 5:
			$MSG_Tips=$MSG_HELP_PE;break;
		case 6:
			$MSG_Tips=$MSG_HELP_WA;break;
		case 7:
			$MSG_Tips=$MSG_HELP_TLE;break;
		case 8:
			$MSG_Tips=$MSG_HELP_MLE;break;
		case 9:
			$MSG_Tips=$MSG_HELP_OLE;break;
		case 10:
			$MSG_Tips=$MSG_HELP_RE;break;
		case 11:
			$MSG_Tips=$MSG_HELP_CE;break;
		default: $MSG_Tips="";

	}
       
	$view_status[$i][3]="<span class='hidden' style='display:none' result='".$row['result']."' ></span>";
        if (intval($row['result'])==11 && ((isset($_SESSION[$OJ_NAME.'_'.'user_id'])&&$row['user_id']==$_SESSION[$OJ_NAME.'_'.'user_id']) || isset($_SESSION[$OJ_NAME.'_'.'source_browser']))){
                $view_status[$i][3].= "<a href='ceinfo.php?sid=".$row['solution_id']."' class='".$judge_color[$row['result']]."'  title='$MSG_Tips'>".$MSG_Compile_Error."";

        	if ($row['result']!=4&&isset($row['pass_rate'])&&$row['pass_rate']>0&&$row['pass_rate']<.98)
                                $view_status[$i][3].= (100-$row['pass_rate']*100)."%</a>";
		else
	      			$view_status[$i][3].="</a>";
				
        }else if ((((intval($row['result'])==8||intval($row['result'])==7||intval($row['result'])==5||intval($row['result'])==6)&&($OJ_SHOW_DIFF||isset($_SESSION[$OJ_NAME.'_'.'source_browser'])))||$row['result']==10||$row['result']==13) && ((isset($_SESSION[$OJ_NAME.'_'.'user_id'])&&$row['user_id']==$_SESSION[$OJ_NAME.'_'.'user_id']) || isset($_SESSION[$OJ_NAME.'_'.'source_browser']))){
                $view_status[$i][3].= "<a href='reinfo.php?sid=".$row['solution_id']
					."' class='".$judge_color[$row['result']]."' title='$MSG_Tips'>".$judge_result[$row['result']]."";
        	if ($row['result']!=4&&isset($row['pass_rate'])&&$row['pass_rate']>0&&$row['pass_rate']<.98)
                                $view_status[$i][3].= (100-$row['pass_rate']*100)."%</a>";
		else
				 $view_status[$i][3].= "</a>";

        }else{
              if(!$lock||$lock_time>$row['in_date']||$row['user_id']==$_SESSION[$OJ_NAME.'_'.'user_id']){
                if($OJ_SIM&&$row['sim']>80&&$row['sim_s_id']!=$row['s_id']) {
                        $view_status[$i][3].= "<span class='".$judge_color[$row['result']]."'  title='$MSG_Tips'>*".$judge_result[$row['result']]."";
        		if ($row['result']!=4&&isset($row['pass_rate'])&&$row['pass_rate']>0&&$row['pass_rate']<.98)
                                $view_status[$i][3].= (100-$row['pass_rate']*100)."%</span>";
			else
				$view_status[$i][3].="</span>";

                        if( isset($_SESSION[$OJ_NAME.'_'.'source_browser'])){

                                        $view_status[$i][3].= "<a href=comparesource.php?left=".$row['sim_s_id']."&right=".$row['solution_id']."  class='label label-info'  target=original>".$row['sim_s_id']."(".$row['sim']."%)</a>";
                        }else{

                                        $view_status[$i][3].= "<span class='label label-info'>".$row['sim_s_id']."</span>";

                        }
                        if(isset($_GET['showsim'])&&isset($row['sim_s_id'])){
                                        $view_status[$i][3].= "<span sid='".$row['sim_s_id']."' class='original'></span>";

                        }
                }else{

                        $view_status[$i][3].= "<a href='reinfo.php?sid=".$row['solution_id']."' class='".$judge_color[$row['result']]."'  title='$MSG_Tips'>".$judge_result[$row['result']]."";
        		if ($row['result']!=4&&isset($row['pass_rate'])&&$row['pass_rate']>0&&$row['pass_rate']<.98)
                                $view_status[$i][3].= (100-$row['pass_rate']*100)."%</a>";
			else
				$view_status[$i][3].="</a>";
                }
          }else{
               $view_status[$i][3]="----";
          }
	  

        }
        if(isset($_SESSION[$OJ_NAME.'_'.'http_judge'])) {
		 $view_status[$i][3].="<form class='http_judge_form form-inline' >
					<input type=hidden name=sid value='".$row['solution_id']."'>";
                 $view_status[$i][3].="</form>";
	}
	            

       
       
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
                if (!(isset($_SESSION[$OJ_NAME.'_'.'user_id'])&&strtolower($row['user_id'])==strtolower($_SESSION[$OJ_NAME.'_'.'user_id']) || isset($_SESSION[$OJ_NAME.'_'.'source_browser']))){
                        $view_status[$i][6]=$language_name[$row['language']];
                }else{

                        $view_status[$i][6]= "<a target=_blank href=showsource.php?id=".$row['solution_id'].">".$language_name[$row['language']]."</a>";
			if($row["problem_id"]>0){
                        	if ($row['contest_id']>0) {
                                	$view_status[$i][6].= "/<a target=_self href=\"submitpage.php?cid=".$row['contest_id']."&pid=".$row['num']."&sid=".$row['solution_id']."\">Edit</a>";
                        	}else{
                                	$view_status[$i][6].= "/<a target=_self href=\"submitpage.php?id=".$row['problem_id']."&sid=".$row['solution_id']."\">Edit</a>";
                        	}
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
        $view_status[$i][9]= $row['judger'];
        
   
   

}

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

