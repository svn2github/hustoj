<?php
        require_once("./include/db_info.inc.php");
        //cache head start
        $cache_time=2;
        $file="cache/".$_SERVER["REQUEST_URI"]."index.html";
        $sid="";
        if (isset($_SESSION['user_id'])){
                $sid=session_id().$_SERVER['REMOTE_ADDR'];
        }
        if (isset($_SERVER['QUERY_STRING'])){
                $sid.=$_SERVER['QUERY_STRING'];
        }
        $sid=md5($sid);
        $file = "cache/status_$sid.html";
        
        if($OJ_MEMCACHE ){
                $mem = new Memcache;
                if($OJ_SAE)
                        $mem=memcache_init();
                else{
                        $mem->connect($OJ_MEMSERVER,  $OJ_MEMPORT);
                }
                $content=$mem->get($file);
                if($content){
                         echo $content;
                         exit();
                }else{
                        $use_cache=false;
                        $write_cache=true;
                }
        }else{
                
                if (file_exists ( $file ))
                        $last = filemtime ( $file );
                else
                        $last =0;
                $write_cache=$_SERVER['QUERY_STRING']==""||
                                         (isset($_GET['cid'])&&$_SERVER['QUERY_STRING']==("cid=".$_GET['cid']));
                $use_cache=(time () - $last < $cache_time)&&$write_cache;
                $write_cache=(!$use_cache)&&$write_cache;
        }
        if ($use_cache) {
                //header ( "Location: $file" );
                include ($file);
                exit ();
        } else if($write_cache){
                ob_start ();
        }
//cache head stop
?>
