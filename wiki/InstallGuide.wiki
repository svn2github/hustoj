#summary 安装 指南
#labels Featured,Phase-Deploy,Phase-Implementation

= Introduction =

安装这个OJ系统需要GNU/Linux的一个较新的发行版，推荐ubuntu10.04 [http://www.ubuntu.com]


= Details =
请下载install.227.tar.gz 或 根据README操作，您在安装过程中需要一个互联网连接，以下载源代码。

对于没有连接到互联网的主机，也可以用svn从其他的主机上下载好源码后复制到磁盘上进行安装。

另外，对于Linux系统不熟悉的用户可以选择使用LiveCD系统进行图形化安装。

 * 下载[HUSTOJ_LiveCD]系统，并刻录为光盘。
 * 在服务器上用光盘启动，以ubuntu用户登录,密码freeproblemset。
 * 从开始菜单->附件启动LXTerminal
 * 输入 
{{{
sudo ubiquity
}}}
  就可以进入图形化安装程序。
 * 按照提示，只需要7步简单的操作就能够将LiveCD完整安装到服务器上了。
 * 安装成功后注意
   # 安装中建立的帐号无效，请使用ubuntu/freeprblemset登录。
   # 登录时输入密码前选择会话（Session）为LXDE
     如果会话不可选，可以按下alt+f1用控制台登录，然后安装完整lubuntu桌面：
{{{
sudo apt-get install lubuntu-desktop
}}}
     提示lxdm配置时先确定，然后选择gdm.
     安装完成sudo reboot重启，即可看到新的图形登录界面。
   # 如果图形界面无法登陆，或用于专用服务器，平时不使用图形界面，建议删除图形登录界面。
{{{
sudo apt-get remove gdm lxdm
}}}
这样系统启动后不会启动图形界面，有效节约系统资源，如果偶尔需要使用图形化界面，可在登录后使用startx命令。
   # 修改judge和root账号口令，以及mysql账号口令,修改judge.conf和db_info.inc.php。
   # 修改系统管理员admin密码
   # 如需远程控制，请安装sshd,命令
{{{
sudo apt-get install openssh-server
}}}
   

* 手动安装参考 [README] *