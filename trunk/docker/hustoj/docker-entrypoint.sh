#!/bin/bash
service nginx start
#chown -R mysql:mysql /var/lib/mysql
service mysql start
mysql -h localhost -uroot < src/install/db.sql
echo "insert into jol.privilege values('admin','administrator','N');"|mysql -h localhost -uroot 
php5-fpm
/usr/bin/judged
/bin/bash  
exit 0 
