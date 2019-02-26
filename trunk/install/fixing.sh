#!/bin/bash
DATE=`date +%Y%m%d%H%M`
if [ `whoami` = "root" ];then
	cd /home/judge/
	svn co https://github.com/zhblue/hustoj/trunk/trunk new
	cp src/web/include/db_info.inc.php new/web/include/
	cp -a src/web/upload/* new/web/upload/
	mv src "old.$DATE"
	mv new src
else
	echo "usage: sudo $0"
fi
