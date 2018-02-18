#!/bin/bash
service nginx start
chown -R mysql:mysql /var/lib/mysql

DIRECTORY="/var/lib/mysql"
if [ "`ls -A $DIRECTORY`" = "" ]; then
	cp -R /home/mysql/* /var/lib/mysql/
fi

DIRECTORY="/home/judge/src/web/config"
if [ "`ls -A $DIRECTORY`" = "" ]; then
	cp -R /home/config/* /home/judge/src/web/config 
fi

chown -R mysql:mysql /var/lib/mysql
service mysql start

dir="/var/lib/mysql/jol"
if [ ! -d $dir ]; then
	USER=`cat /etc/mysql/debian.cnf |grep user|head -1|awk  '{print $3}'` 
	PASSWORD=`cat /etc/mysql/debian.cnf |grep password|head -1|awk  '{print $3}'` 
	mysql -h localhost -u$USER -p$PASSWORD< /home/judge/src/install/db.sql
	echo "insert into jol.privilege values('admin','administrator','N');"|mysql -h localhost -u$USER -p$PASSWORD
else
	cp /home/judge/src/web/config/db_info.inc.php /home/judge/src/web/include/db_info.inc.php
fi

if [ -f /home/judge/src/web/config/db_info.inc.php ]; then
	cp /home/judge/src/web/config/db_info.inc.php /home/judge/src/web/include/db_info.inc.php
else
	cp /home/judge/src/web/include/db_info.inc.php /home/judge/src/web/config/db_info.inc.php 
fi

php5-fpm
/usr/bin/judged
chmod 775 -R /home/judge/data && chgrp -R www-data /home/judge/data
chmod 770 -R /home/judge/src/web/upload && chgrp -R www-data /home/judge/src/web/upload
chmod 770 -R /home/judge/src/web/config && chgrp -R /home/judge/src/web/config
/bin/bash  
exit 0 


