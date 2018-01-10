<?php
        session_start();
        require_once("../include/db_info.inc.php");
        if (!isset($_SESSION[$OJ_NAME.'_'.'user_id'])){
                require_once("oj-header.php");
                echo "<a href=loginpage.php>Please Login First</a>";
                require_once("../oj-footer.php");
                exit(0);
        }
        
        if (strlen($_POST['content'])>5000){
                require_once("oj-header.php");
                echo "Your contents is too long!";
                require_once("../oj-footer.php");
                exit(0);
        }
        
        if (strlen($_POST['title'])>60){
                require_once("oj-header.php");
                echo "Your title is too long!";
                require_once("../oj-footer.php");
                exit(0);
        }
        
        $tid=null;
        if ($_REQUEST['action']=='new'){
                if (array_key_exists('title',$_POST) && array_key_exists('content', $_POST) && $_POST['title']!='' && $_POST['content']!=''){
                        if(array_key_exists('pid',$_REQUEST)&&$_REQUEST['pid']!='')
                                $pid=intval($_REQUEST['pid']);
                        else
                                $pid=0;
                        if(array_key_exists('cid',$_REQUEST)&&$_REQUEST['cid']!='')
                                $cid=intval($_REQUEST['cid']);
                        else
                                $cid=0;
                        $sql="INSERT INTO `topic` (`title`, `author_id`, `cid`, `pid`) values(?,?,?,?)";
						//echo $sql;
                        $rows=pdo_query($sql,$_POST['title'],$_SESSION[$OJ_NAME.'_'.'user_id'],$cid,$pid);
                        if(!$rows){
				//echo $sql;
                                echo('Unable to post new.');
                        }else{
                                $tid=$rows;
			}
                }
                else
                        echo('Error!');
        }
        if ($_REQUEST['action']=='reply' || !is_null($tid)){
                if(is_null($tid)) $tid=intval($_POST['tid']);
                if (!is_null($tid) && array_key_exists('content', $_POST) && $_POST['content']!=''){
			$rows=pdo_query("select tid from topic where tid=?",$tid);
			if(isset($rows[0])){
				$ip = ($_SERVER['REMOTE_ADDR']);
				if( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ){
				    $REMOTE_ADDR = $_SERVER['HTTP_X_FORWARDED_FOR'];
				    $tmp_ip=explode(',',$REMOTE_ADDR);
				    $ip =(htmlentities($tmp_ip[0],ENT_QUOTES,"UTF-8"));
				}
				$sql="insert INTO `reply` (`author_id`, `time`, `content`, `topic_id`,`ip`) values(?,NOW(),?,?,?)";
				if(pdo_query($sql, $_SESSION[$OJ_NAME.'_'.'user_id'],$_POST['content'],$tid,$ip)){
					header('Location: thread.php?tid='.$tid);
					exit(0);
				}else{
					echo('Unable to post.');
				}
			}else{
				echo "reply non-exists topic";
			}
                } else echo('Error!');
        }
        require_once("../oj-footer.php");
?>
