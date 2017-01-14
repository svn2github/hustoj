#summary 演示和安装一体化的光盘版 a all in one CD is on the way
#labels Featured,LiveCD,Phase-Deploy

Download:
14.04 LTS 版本(OJ管理员admin密码hustoj)
* http://pan.baidu.com/s/1o78D4x0
* http://zjjr.hustoj.com/hustoj2017.iso 第N次打包
* http://zjjr.hustoj.com/hustoj2016.iso 第3次打包
* http://pan.baidu.com/s/1pLyHG6J  第2次打包

12.04 LTS 版本
* http://pan.baidu.com/share/link?shareid=23135&uk=2838456172
* http://pan.baidu.com/netdisk/singlepublic?fid=241719_3088787629


= Introduction =


为了帮助不了解HUSTOJ的用户快速获得使用体验，发布一张LiveCD.


没有刻录机？请看[http://hustoj.5d6d.com/thread-7-1-1.html 虚拟机使用帮助]

In order to help people trying HUSTOJ, here is annoucing a LiveCD

[http://hustoj.googlecode.com/files/HUSTOJ-Live2.0.png]

[http://v.youku.com/v_show/id_XMTk5NTAyOTgw.html]

= Details =
* 本光盘是一张LiveCD，即无需安装、无需硬盘，只需要有光驱、内存大于256的x86-32bit系统即可以光盘启动方式运行。*启动时看到“键盘=人形”提示，按下人任意键进入菜单选

* 虚拟机选第一项-试用，直接进入图形登录界面，以ubuntu用户登录，密码freeproblemset，需要root可以用sudo su切换root。

* 物理机选第二项-安装,按照提示输入Alt+F1进入命令行，startx进入图形界面。

* 进入系统后OJ自动启动，运行Firefox即可看到入口

* 2016版OJ管理员帐号admin密码hustoj

* 2017版直接注册admin账号获得管理员权限。

* 启动后系统包含1道题目，可在官方群共享下载fps文件导入。

* 局域网可以访问和使用OJ，网络地址可用ifconfig在 lxterminal中查询。ubuntu用户有sudo权限。

* administrator of OJ is admin, password admin.

* 在图形终端中运行sudo ubiquity可启动图形化安装界面，将LiveCD安装至硬盘系统，适合不了解Linux的用户进行HUSTOJ的初次安装。请参考[InstallGuide]


*使用时如果已经联网，可以用sudo update-hustoj进行程序更新，获得最新版本。提示sudo密码freeproblemset



最低配置实测：
LiveCD System on k6-2 System
*K6-2-450 320M 1G-CF*

![image](https://github.com/zhblue/hustoj/blob/master/wiki/k6-2-system.jpg)

![image](https://github.com/zhblue/hustoj/blob/master/wiki/k6-2-status.jpg)

![image](https://github.com/zhblue/hustoj/blob/master/wiki/k6-2-HustOJ.jpg)

