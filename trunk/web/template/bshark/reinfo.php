<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>错误信息 - MasterOJ</title>
        <?php require( "./template/bshark/header-files.php");?>
    </head>
    
    <body>
        <?php require( "./template/bshark/nav.php");?>
        <div class="card" style="margin: 3% 8% 5% 8%">
            <div class="card-body">
                <h4>运行信息</h4>
                <div class="card" style="box-shadow:0px 3px 3px #ddd;"><div class="card-body"><pre><code><?php echo $view_reinfo?></code></pre></div></div>
                <span style="display:none" id="errtxt"><?php echo $view_reinfo;?></span><br>
                <button class="btn btn-outline-dark" onclick="explain();this.style.display='none';">显示辅助信息</button>
                <div id='errexp'></div>
                <script>
                    var pats=new Array();
                    var exps=new Array();
                    pats[0]=/A Not allowed system call.* /;
                    exps[0]="<?php echo $MSG_A_NOT_ALLOWED_SYSTEM_CALL ?>";
                    pats[1]=/Segmentation fault/;
                    exps[1]="<?php echo $MSG_SEGMETATION_FAULT ?>";
                    pats[2]=/Floating point exception/;
                    exps[2]="<?php echo $MSG_FLOATING_POINT_EXCEPTION ?>";
                    pats[3]=/buffer overflow detected/;
                    exps[3]="<?php echo $MSG_BUFFER_OVERFLOW_DETECTED ?>";
                    pats[4]=/Killed/;
                    exps[4]="<?php echo $MSG_PROCESS_KILLED ?>";
                    pats[5]=/Alarm clock/;
                    exps[5]="<?php echo $MSG_ALARM_CLOCK ?>";
                    pats[6]=/CALLID:20/;
                    exps[6]="<?php echo $MSG_CALLID_20 ?>";
                    pats[7]=/ArrayIndexOutOfBoundsException/;
                    exps[7]="<?php echo $MSG_ARRAY_INDEX_OUT_OF_BOUNDS_EXCEPTION ?>";
                    pats[8]=/StringIndexOutOfBoundsException/;
                    exps[8]="<?php echo $MSG_STRING_INDEX_OUT_OF_BOUNDS_EXCEPTION ?>";
                    function explain(){
                        var errmsg = $("#errtxt").text();
                        var expmsg = "";
                        for(var i=0; i<pats.length; i++){
                                var pat = pats[i];
                                var exp = exps[i];
                                var ret = pat.exec(errmsg);
                                if(ret){
                                    expmsg += ret+" : "+exp+"<br><hr />";
                                }
                        }
                        document.getElementById("errexp").innerHTML=expmsg;
                    }

                    explain();
                </script>
            </div>
        </div>
        <?php require( "./template/bshark/footer.php");?>
        <?php require( "./template/bshark/footer-files.php");?>
    </body>

</html>