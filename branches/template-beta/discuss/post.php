<?php
        session_start();
        require_once("../include/db_info.inc.php");
        if (!isset($_SESSION['user_id'])){
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
                                $pid=$_REQUEST['pid'];
                        else
                                $pid=0;
                        if(array_key_exists('cid',$_REQUEST)&&$_REQUEST['cid']!='')
                                $cid="'".mysql_real_escape_string($_REQUEST['cid'])."'";
                        else
                                $cid='NULL';
                        $sql="INSERT INTO `topic` (`title`, `author_id`, `cid`, `pid`) SELECT '".mysql_real_escape_string($_POST['title'])."', '".mysql_real_escape_string($_SESSION['user_id'])."', $cid, '".mysql_real_escape_string($pid)."'";
                        if($pid!=0)
                                if($cid!='NULL')
                                        $sql.=" FROM `contest_problem` WHERE `contest_id` = $cid AND `problem_id` = '".mysql_real_escape_string($pid)."'";
                                else
                                        $sql.=" FROM `problem` WHERE `problem_id` = '".mysql_real_escape_string($pid)."'";
                        else if($cid!='NULL')
                                $sql.=" FROM `contest` WHERE `contest_id` = $cid";
                        $sql.=" LIMIT 1";
                        mysql_query($sql) or die (mysql_error());
                        if(mysql_affected_rows()<=0)
                                echo('Unable to post.');
                        else
                                $tid=mysql_insert_id();
                }
                else
                        echo('Error!');
        }
        if ($_REQUEST['action']=='reply' || !is_null($tid)){
                if(is_null($tid)) $tid=$_POST['tid'];
                if (!is_null($tid) && array_key_exists('content', $_POST) && $_POST['content']!=''){
                        $sql="INSERT INTO `reply` (`author_id`, `time`, `content`, `topic_id`,`ip`) SELECT '".mysql_real_escape_string($_SESSION['user_id'])."', NOW(), '".mysql_real_escape_string($_POST['content'])."', '".mysql_real_escape_string($tid)."','".$_SERVER['REMOTE_ADDR']."' FROM `topic` WHERE `tid` = '".mysql_real_escape_string($tid)."' AND `status` = 0 ";
                        
                        mysql_query($sql) or die (mysql_error());
                        if(mysql_affected_rows()>0)
                        {
                                header('Location: thread.php?tid='.$tid);
                                exit(0);
                        }
                        else
                                echo('Unable to post.');
                } else echo('Error!');
        }
        require_once("../oj-footer.php");
?>