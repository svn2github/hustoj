#summary 多重启动 调试模式
#labels Featured,Phase-Support

    单个主机运行多个judged，分别负责不同的OJ判题。
    judged 可以接受一个参数作为自己的主目录，默认是/home/judge/。
    如：sudo judged /home/judge/local  
    不指定参数将自动以单进程运行。
    当指定的参数不为/home/judge时，就会有多个进程出现。
    每个主目录可以有自己的etc/judge.conf 数据目录可以共享，runX目录需要独立。
# judged调试模式。
   
judged 接受参数指定目录的情况下，还可以再接受一个debug作为调试模式开关。

     如：sudo judged /home/judge/local debug
     调试模式的judged将不会进入后台，并且将输出大量调试信息，其调用的judge_client也工作在debug模式。

# judge_client调试模式
judge_client接受参数

 judge_client <solution_id> <run目录id> [工作主目录] [调试]

    如：judge_client  2001 5 /home/judge/demo debug
    将在/home/judge/demo/run5目录中对2001号提交进行重判，并打开调试模式，输出大量调试信息，运行后不删除中间结果。
    这个模式可以帮助调试题目数据，发现数据问题和了解提交RE的详细错误原因。
