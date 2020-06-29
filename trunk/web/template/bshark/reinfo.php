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
var i=0;
var pats=new Array();
var exps=new Array();
pats[0]=/A Not allowed system call.* /;
exps[0]="使用了系统禁止的操作系统调用，看看是否越权访问了文件或进程等资源,如果你是系统管理员，而且确认提交的答案没有问题，测试数据没有问题，可以发送'RE'到微信公众号onlinejudge，查看解决方案。";
pats[1]=/Segmentation fault/;
exps[1]="段错误，检查是否有数组越界，指针异常，访问到不应该访问的内存区域";
pats[2]=/Floating point exception/;
exps[2]="浮点错误，检查是否有除以零的情况";
pats[3]=/buffer overflow detected/;
exps[3]="缓冲区溢出，检查是否有字符串长度超出数组的情况";
pats[4]=/Killed/;
exps[4]="进程因为内存或时间原因被杀死，检查是否有死循环";
pats[5]=/Alarm clock/;
exps[5]="进程因为时间原因被杀死，检查是否有死循环，本错误等价于超时TLE";
pats[6]=/CALLID:20/;
exps[6]="可能存在数组越界，检查题目描述的数据量与所申请数组大小关系";
function explain(){
//alert("asdf");
//var errmsg=$("#errtxt").text();
var errmsg = document.getElementById("errtxt").innerHTML;
//var errmsg='';
var expmsg="<h5>辅助解释</h5><hr>";
for(var i=0;i<pats.length;i++){
var pat=pats[i];
var exp=exps[i];
var ret=pat.exec(errmsg);
if(ret){
expmsg+=ret+":"+exp+"<br><br>";
}
}
document.getElementById("errexp").innerHTML=expmsg;
//alert(expmsg);
}
</script>
            </div>
        </div>
        <?php require( "./template/bshark/footer.php");?>
        <?php require( "./template/bshark/footer-files.php");?>
    </body>

</html>