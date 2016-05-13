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
                                $cid="'".mysqli_real_escape_string($mysqli,$_REQUEST['cid'])."'";
                        else
                                $cid='NULL';
                        $sql="INSERT INTO `topic` (`title`, `author_id`, `cid`, `pid`) SELECT '".mysqli_real_escape_string($mysqli,$_POST['title'])."', '".mysqli_real_escape_string($mysqli,$_SESSION['user_id'])."', $cid, '".mysqli_real_escape_string($mysqli,$pid)."'";
                        if($pid!=0)
                                if($cid!='NULL')
                                        $sql.=" FROM `contest_problem` WHERE `contest_id` = $cid AND `problem_id` = '".mysqli_real_escape_string($mysqli,$pid)."'";
                                else
                                        $sql.=" FROM `problem` WHERE `problem_id` = '".mysqli_real_escape_string($mysqli,$pid)."'";
                        else if($cid!='NULL')
                                $sql.=" FROM `contest` WHERE `contest_id` = $cid";
                        $sql.=" LIMIT 1";
                        mysqli_query($mysqli,$sql) or die (mysqli_error());
                        if(mysqli_affected_rows($mysqli)<=0)
                                echo('Unable to post.');
                        else
                                $tid=mysqli_insert_id($mysqli);
                }
                else
                        echo('Error!');
        }
        if ($_REQUEST['action']=='reply' || !is_null($tid)){
                if(is_null($tid)) $tid=$_POST['tid'];
                if (!is_null($tid) && array_key_exists('content', $_POST) && $_POST['content']!=''){
                        $sql="INSERT INTO `reply` (`author_id`, `time`, `content`, `topic_id`,`ip`) SELECT '".mysqli_real_escape_string($mysqli,$_SESSION['user_id'])."', NOW(), '".mysqli_real_escape_string($mysqli,$_POST['content'])."', '".mysqli_real_escape_string($mysqli,$tid)."','".$_SERVER['REMOTE_ADDR']."' FROM `topic` WHERE `tid` = '".mysqli_real_escape_string($mysqli,$tid)."' AND `status` = 0 ";
                        
                        mysqli_query($mysqli,$sql) or die (mysqli_error());
                        if(mysqli_affected_rows($mysqli)>0)
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
