Judge Hub
----
a.k.a Judge Farm Keeper 
--


背景: 
--

随着服务器性能的不断提升,一台高性能物理机或者云服务器的判题能力已经足以满足多个独立OJ系统的需求。传统的judged多进程启动模式就是为这种情景设计的。但是多进程模式在大规模SaaS平台中存在一个问题,就是大量（数百个）同时启动的judged可能在50％以上的时间里都是闲置状态中消耗着服务器宝贵的内存资源和奢侈的数据库长链接，定期轮询数据库也构成了不小的压力。

解决方案:
--

一个显而易见的解决方案,就是设置类似早期unix系统中inetd进程的轻量级守护程序，在必要时启动负责对应系统的judged，judged完成一定量的判题任务后自动退出。这样既能保证判题的响应速度，又能减少judged并发数量，在同等级硬件设施的基础上提供更高的系统总容量。

代码实现：
--

实现上述方案的代码即为[judgehub](https://github.com/zhblue/hustoj/blob/master/trunk/core/judged/judgehub.cc)，它的命令行参数如下：
judgehub [farmbase] [udpport] [debug]

farmbase：
--
在虚拟主机系统中，虚拟主机往往集中存放在特定目录下，如常见的/home/saas，judgehub要为所有的虚拟主机提供判题服务，自然需要知道这个基础路径。而具体是哪个子目录下存在hustoj的主目录，则作为消息的内容发送到udp端口上。

udpport：
--
judgehub监听的udp端口，因为udp是无连接的，因此资源消耗少，适合单端口接受多个消息源，代码容易实现。

debug：
--
当第三个参数存在时，不管内容是什么，开启debug模式，judgehub不自动进入后台，并输出调试信息。

php方面的适配：
--
之前php代码发送给judged的消息内容是新增提交的编号，实际上judged并未直接使用该编号，而是主动去数据库查询最新的任务编号，这为适配judgehub留下了方便之处。只需将消息内容修改为从farmpath到hustoj主目录的相对路径，即可完成适配。

新的提交运行流程：
--
* submit.php接受到提交，插入数据库
* submit.php发送hustoj子路径到UDP端口
* 监听UDP端口的judgehub接受到消息，拼接计算出启动judged所需参数，启动judged
* judged根据judge.conf配置的方式完成判题任务后退出
* judgehub等待下一个消息触发

可能存在的问题与处理：
--
当提交频繁时，judged可能被重复启动，但是因为启动judged时有锁文件操作，后续进程将自动退出。

管理员重判需要补充发送消息给judgehub。

其他人可能向UDP端口发送未经授权的消息，可能导致缓冲区溢出。因此judgehub仅可在回环地址127.0.0.1上监听，或在可信网络内使用。通过简单的校验代码，如判断judge.conf文件是否存在，来决定是否启动judged进程。

版权声明
--
* 任何人或组织，若依据本文内容实现类似的功能或编写论文，请在源码参考文献中引用本文的URL以及 [基于开放式云平台的开源在线评测系统设计与实现](http://kns.cnki.net/KCMS/detail/detail.aspx?dbcode=CJFQ&dbname=CJFD2012&filename=JSJA2012S3088) ，并认真履行GPL协议。

