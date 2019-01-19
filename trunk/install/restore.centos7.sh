#!/usr/bin/bash

# Get backup archive file
if [ ${#} > 0 ];then
    archive=${1};
else
    archive=`ls -r /home/judge/backup | head -1`;
fi

# Get database password
OJ_USERNAME=`cat /home/judge/etc/judge.conf | grep OJ_USER_NAME`
OJ_PASSWORD=`cat /home/judge/etc/judge.conf | grep OJ_PASSWORD`
DB_USERNAME=`echo ${OJ_USER_NAME:13}`
DB_PASSWORD=`echo ${OJ_PASSWORD:12}`

if [ -e /home/judge/src/install/backup.centos7.sh ];then
    echo "backup current archive for restoring when interrupted"
    bash /home/judge/src/install/backup.centos7.sh
else
    echo "no backup shell cannot create backup archive"
fi 

# clear old files
rm -rf /home/judge/data
rm -rf /home/judge/etc
rm -rf /home/judge/src/web

# start restore
tar -xvf ${archive} -C /home/judge/backup/temp

# restore database
echo "restore database"
mysql -u${DB_USERNAME} -p${DB_PASSWORD} < /home/judge/backup/temp/jol.sql

# restore data directory
echo "restore data directory"
cp -r /home/judge/backup/temp/data /home/judge/data

# restore config files
echo "restore config files"
cp -r /home/judge/backup/temp/etc /home/judge/etc

# restore web files
cp -r /home/judge/backup/temp/src/web /home/judge/src/web

# adjustment config file
CPU=`cat /proc/cpuinfo| grep "processor"| wc -l`
cdbusername = `cat /home/judge/etc/judge.conf | grep OJ_USER_NAME`
cdbpassword = `cat /home/judge/etc/judge.conf | grep OJ_PASSWORD`
ccpu        = `cat /home/judge/etc/judge.conf | grep OJ_RUNNING`
sed -i "s/${cdbusername}/OJ_USER_NAME=${DB_USERNAME}/g" /home/judge/etc/judge.conf
sed -i "s/${cdbpassword}/OJ_PASSWORD=${DB_PASSWORD}/g"  /home/judge/etc/judge.conf
sed -i "s/${ccpu}/OJ_RUNNING=${CPU}/g"                  /home/judge/etc/judge.conf

chmod 775 -R /home/judge/data
chmod 700 /home/judge/etc/judge.conf
chmod 700 /home/judge/src/web/include/db_info.inc.php
chown -R apache:apache /home/judge/data
chown apache /home/judge/src/web/include/db_info.inc.php
chown apache /home/judge/src/web/upload 