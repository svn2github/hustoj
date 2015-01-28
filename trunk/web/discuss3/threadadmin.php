<?php
        session_start();
        require_once("../include/db_info.inc.php");
        require_once("discuss_func.inc.php");
        if ($_REQUEST['target']=='reply'){
                $rid = $_REQUEST['rid']; $tid = $_REQUEST['tid'];
                $stat = -1;
                if ($_REQUEST['action']=='resume') $stat = 0;
                if ($_REQUEST['action']=='disable') $stat = 1;
                if ($_REQUEST['action']=='delete') $stat = 2;
                if ($stat == -1) err_msg("Wrong action.");
                $rid = mysql_escape_string($rid);
                $sql = "UPDATE reply SET status = $stat WHERE `rid` = '$rid'";
                if (!isset($_SESSION['administrator']))
                        if ($stat!=2) err_msg("<a href=\"../loginpage.php\">Please Login First</a>");
                        else $sql.=" AND author_id='".mysql_escape_string($_SESSION['user_id'])."'";
                mysql_query($sql) or die(mysql_error());
                if (mysql_affected_rows()>0) header('Location: thread.php?tid='.$tid);
                else err_msg("Reply not exist or no permission.");
        }
        if ($_REQUEST['target']=='thread'){
                $tid = $_REQUEST['tid'];
                $toplevel = -1; $stat = -1;
                if ($_REQUEST['action']=='sticky') 
                        if(array_key_exists('level',$_REQUEST)&&is_numeric($_REQUEST['level']) &&$_REQUEST['level']>=0 &&$_REQUEST['level']<4)
                                $toplevel = $_REQUEST['level'];
                        else
                                err_msg("Invalid sticky level.");
                if ($_REQUEST['action']=='resume') $stat = 0;
                if ($_REQUEST['action']=='lock') $stat = 1;
                if ($_REQUEST['action']=='delete') $stat = 2;
                if (!isset($_SESSION['administrator']))
                        errmsg("<a href=./loginpage.php>Please Login First</a>");
                if ($toplevel == -1 && $stat == -1)
                        errmsg("Wrong action.");
                $tid = mysql_escape_string($tid);
                if ($stat == -1) 
                        $sql = "UPDATE topic SET top_level = $toplevel WHERE `tid` = '$tid'";
                else $sql = "UPDATE topic SET status = $stat WHERE `tid` = '$tid'";
                mysql_query($sql) or die(mysql_error());
                if (mysql_affected_rows()>0) {
                        if ($stat!=2) header('Location: thread.php?tid='.$tid);
                        else header('Location: discuss.php');
                }
                else {
                        require_once("./oj-header.php");
                        echo "The thread does not exist.";
                        require_once("../oj-footer.php");
                        exit(0);
                }
        }
?>
