#summary hustoj simple sandbox
#labels 评测后台的机制
= HUSTOJ评测后台的机制 =

下面的内容主要是讲了OJ后台的安全机制

== 安全 ==
=== 非法调用限制 ===
在UNIX中有上百个[http://www.ibm.com/developerworks/cn/linux/kernel/syscall/part1/appendix.html 系统调用]，有一大部分是在用户程序运行过程中不需要的，比如说mkdir,mount等，还有一部分会对系统造成安全隐患的，比如fork,kill,exec等，还有一些比如socket等会造成敏感信息，比如测试数据的泄漏等。
因为以上情况的存在，所以需要在运行用户程序的时候对用户加以限制，linux下的ptrace在这里是一个非常好用的工具，它可以在用户态和内核态之间切换之前和之后，将进程暂停，以方便控制进程的处理，控制进程通过ptrace可以读取到当前进程想要去做什么，这样就可以在用户程序造成破坏之前将程序中止。
限制非法系统调用，最好的办法是使用白名单机制，只允许程序使用一个小集合里的调用，对于其它调用，即使它是安全的，也不会被允许，比如mkdir。
由于Pascal,Java,C/C++的机制有些区别，因此，三种不同语言的白名单各不相同。

相关代码见[https://github.com/zhblue/hustoj/blob/master/trunk/core/judge_client/okcalls64.h]
-------------
未完待续
