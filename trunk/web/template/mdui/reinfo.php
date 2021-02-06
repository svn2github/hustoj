<!DOCTYPE html>
<html lang="en">

<head>
    <?php $page_title = "$id 记录详情"; ?>
    <?php include('_includes/head.php') ?>
</head>

<body class="mdui-drawer-body-left mdui-theme-primary-indigo mdui-theme-accent-indigo mdui-appbar-with-toolbar">
    <?php include('_includes/header.php'); ?>
    <?php include('_includes/sidebar.php'); ?>
    <div class="mdui-container">
        <div class="jumbotron">

            <pre id="errtxt" class="alert alert-error"><?php echo $view_reinfo; ?></pre>
            <div id="errexp">
                <!--Explain:-->
            </div>
        </div>
    </div>
    <script>
    var pats = new Array();
    var exps = new Array();
    pats[0] = /A Not allowed system call.*/;
    exps[0] = "使用了系统禁止的操作系统调用，看看是否越权访问了文件或进程等资源,如果你是系统管理员，而且确认提交的答案没有问题，测试数据没有问题，可以发送'RE'到微信公众号onlinejudge，查看解决方案。";
    pats[1] = /Segmentation fault/;
    exps[1] = "段错误，检查是否有数组越界，指针异常，访问到不应该访问的内存区域";
    pats[2] = /Floating point exception/;
    exps[2] = "浮点错误，检查是否有除以零的情况";
    pats[3] = /buffer overflow detected/;
    exps[3] = "缓冲区溢出，检查是否有字符串长度超出数组的情况";
    pats[4] = /Killed/;
    exps[4] = "进程因为内存或时间原因被杀死，检查是否有死循环";
    pats[5] = /Alarm clock/;
    exps[5] = "进程因为时间原因被杀死，检查是否有死循环，本错误等价于超时TLE";
    pats[6] = /CALLID:20/;
    exps[6] = "可能存在数组越界，检查题目描述的数据量与所申请数组大小关系";
    pats[7] = /ArrayIndexOutOfBoundsException/;
    exps[7] = "检查数组越界的情况";
    pats[8] = /StringIndexOutOfBoundsException/;
    exps[8] = "字符串的字符下标越界，检查 subString, charAt 等方法的参数";

    function explain() {
        //alert("asdf");
        var errmsg = $("#errtxt").text();
        var expmsg = ""; //"辅助解释：<br><hr>";
        for (var i = 0; i < pats.length; i++) {
            var pat = pats[i];
            var exp = exps[i];
            var ret = pat.exec(errmsg);
            if (ret) {
                expmsg += ret + ":" + exp + "<br><hr />";
            }
        }
        document.getElementById("errexp").innerHTML = expmsg;
        //alert(expmsg);
    }

    function showDownload() {
        var errmsg = $("#errtxt").html();
        errmsg = errmsg.replace(/========\[(.*)\]=========/g,
            "<a href='download.php?sid=<?php echo $id?>&name=$1'>$1</a>");
        $("#errtxt").html(errmsg);
    }

    explain();

    <?php if(isset($OJ_DOWNLOAD)&&$OJ_DOWNLOAD) echo  "showDownload();" ?>
    </script>
</body>

</html>