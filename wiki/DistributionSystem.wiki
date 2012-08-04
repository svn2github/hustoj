#summary 分布式系统搭建
#labels Featured

= Introduction =


[http://hustoj.5d6d.com/forum-4-1.html]

= Details =



建立分布式判题系统
HUSTOJ 支持一台数据库服务器，多台web服务器和多台判题服务器，以承担较高的访问负荷。

首先，需要创建用于从远程连接数据库的帐号。
{{{
GRANT ALL PRIVILEGES ON jol.* TO 'judge'@'%'
IDENTIFIED BY 'judge_pass' WITH GRANT OPTION;
}}}

* 对于网络原因无法远程mysql的，请参考[HTTPJudge]

其中jol为数据库，judge为帐号，judge_pass为密码。
注意：
检查/etc/mysql/my.cnf 确保
{{{
bind-address        = 0.0.0.0
}}}

 * 为了提高性能，可以适当增大 *
{{{
key_buffer              = 128M
query_cache_limit       = 4M
query_cache_size        = 128M
}}}



其次，配置各web程序连接到数据库。
修改include/db_info.inc.php
{{{
   static  $DB_HOST="数据库服务器ip";
   static  $DB_NAME="jol";
   static  $DB_USER="judge";
   static  $DB_PASS="judge_pass";
}}}



第三，配置各判题程序连接到数据库，分配任务。
{{{
   OJ_HOST_NAME=数据库服务器ip
   OJ_USER_NAME=judge
   OJ_PASSWORD=judge_pass
   OJ_DB_NAME=jol
   ...
   OJ_TOTAL=判题机总数
   OJ_MOD=本机编号，从0开始
   ...
}}}

~~其中OJ_TOTAL=判题机总数,OJ_MOD=本机编号，从0开始，例如
有3台机器判题，分别编号0，1，2
OJ_TOTAL都设为3，OJ_MOD分别设为0,1,2~~

*从r784开始不必设置OJ_TOTAL和OJ_MOD,所有judged会自动分配任务。*

~~第四，复制测试数据目录到各判题机。~~

*从r1520开始，使用HTTP_JUDGE方式不必单独复制数据，数据将从web服务器按需下载。

从主机向判题机复制
{{{
   scp -r /home/judge/data  root@判题机ip:/home/judge/
}}}

或用同步命令。
{{{
   rsync -vzrtopg --progress --delete /home/judge/data root@判题机ip:/home/judge/
}}}

判题机从主机复制
{{{
   scp -r root@主机ip:/home/judge/data  /home/judge/
}}}

或用同步命令。
{{{
   rsync -vzrtopg --progress --delete root@主机ip:/home/judge/data /home/judge/
}}}

最后，在各判题机重启判题程序。
{{{
   sudo pkill judged&&sudo judged
}}}