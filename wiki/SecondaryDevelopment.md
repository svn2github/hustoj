二次开发
----

界面美化
--
web根目录的默认位置/home/judge/src/web
根目录下的文件用于处理逻辑，处理完成后，数据以变量存储，在文件末尾进行跳转或包含操作(require/include)，包含的目标为template/[模板名]下的同名文件。

针对界面进行美化，可以先在template目录下执行
```
sudo cp -a bs3 newgui
```
然后修改db_info.inc.php，设置$OJ_TEMPLATE="newgui";

之后随意修改newgui目录下的文件，来进行美化处理。


重新开发Web
--
待续
