#!/bin/bash
service nginx start
chown -R mysql:mysql /var/lib/mysql
service mysql start
php5-fpm
/usr/bin/judged
/bin/bash  
exit 0 
