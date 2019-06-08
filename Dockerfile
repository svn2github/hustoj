FROM ubuntu:18.04

COPY trunk /trunk

# Linux: Aliyun Apt Mirrors.
RUN echo "  \
    deb http://mirrors.aliyun.com/ubuntu/ bionic main restricted                                \n\
    deb http://mirrors.aliyun.com/ubuntu/ bionic-updates main restricted                        \n\
    deb http://mirrors.aliyun.com/ubuntu/ bionic universe                                       \n\
    deb http://mirrors.aliyun.com/ubuntu/ bionic-updates universe                               \n\
    deb http://mirrors.aliyun.com/ubuntu/ bionic multiverse                                     \n\
    deb http://mirrors.aliyun.com/ubuntu/ bionic-updates multiverse                             \n\
    deb http://mirrors.aliyun.com/ubuntu/ bionic-backports main restricted universe multiverse  \n\
    deb http://mirrors.aliyun.com/ubuntu/ bionic-security main restricted                       \n\
    deb http://mirrors.aliyun.com/ubuntu/ bionic-security universe                              \n\
    deb http://mirrors.aliyun.com/ubuntu/ bionic-security multiverse                            \n\
    " > /etc/apt/sources.list   \
    && apt-get -y update        \
    && apt-get -y upgrade

# Nginx
RUN apt-get -y install nginx

# Mysql
RUN apt-get -y install                              \
    mysql-server libmysqlclient-dev libmysql++-dev  \
    && mkdir -p /var/run/mysqld                     \
    && chown -R mysql:mysql /var/run/mysqld         \
    && chmod -R 755         /var/run/mysqld         \
    && service mysql start                          \
    && mysql < /trunk/install/db.sql                \
    && mysql -e "insert into jol.privilege values('admin','administrator','N');"

# Php
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install   \
    php-common php-fpm php-mysql php-gd php-zip php-mbstring php-xml

# Hustoj basic file system
RUN useradd -m -u 1536 judge            \
    && mkdir -p /home/judge/etc         \
    && mkdir -p /home/judge/data        \
    && mkdir -p /home/judge/log         \
    && mkdir -p /home/judge/backup      \
    && mv /trunk /home/judge/src        \
    && chmod -R 700 /home/judge/etc     \
    && chmod -R 700 /home/judge/backup  \
    && chmod -R 700 /home/judge/src/web/include/    \
    && chown -R www-data:www-data /home/judge/data  \
    && chown -R www-data:www-data /home/judge/src/web 

# Judge daemon and client
RUN apt-get -y install make flex gcc g++ openjdk-11-jdk                         \
    && make      -C /home/judge/src/core/judged                                 \
    && make      -C /home/judge/src/core/judge_client                           \
    && make exes -C /home/judge/src/core/sim/sim_3_01                           \
    && cp /home/judge/src/core/judged/judged                /usr/bin/judged         \
    && cp /home/judge/src/core/judge_client/judge_client    /usr/bin/judge_client   \ 
    && cp /home/judge/src/core/sim/sim_3_01/sim_c.exe       /usr/bin/sim_c          \
    && cp /home/judge/src/core/sim/sim_3_01/sim_c++.exe     /usr/bin/sim_cc         \
    && cp /home/judge/src/core/sim/sim_3_01/sim_java.exe    /usr/bin/sim_java       \
    && cp /home/judge/src/core/sim/sim.sh                   /usr/bin/sim.sh         \
    && cp /home/judge/src/install/hustoj                    /etc/init.d/hustoj      \
    && chmod +x /home/judge/src/install/ans2out \
    && chmod +x /usr/bin/judged                 \
    && chmod +X /usr/bin/judge_client           \
    && chmod +x /usr/bin/sim_c                  \
    && chmod +X /usr/bin/sim_cc                 \
    && chmod +x /usr/bin/sim_java               \
    && chmod +x /usr/bin/sim.sh

# Adjust system configuration
RUN CPU=`grep "cpu cores" /proc/cpuinfo |head -1|awk '{print $4}'`                      \
    && USERNAME=`cat /etc/mysql/debian.cnf |grep user    |head -1|awk  '{print $3}'`    \
    && PASSWORD=`cat /etc/mysql/debian.cnf |grep password|head -1|awk  '{print $3}'`    \
    && cp /home/judge/src/install/java0.policy  /home/judge/etc/                        \
    && cp /home/judge/src/install/judge.conf    /home/judge/etc/                        \
    && cp /home/judge/src/install/default.conf  /etc/nginx/sites-available/default      \
    && sed -i "s/OJ_USER_NAME=root/OJ_USER_NAME=$USERNAME/g"    /home/judge/etc/judge.conf  \
    && sed -i "s/OJ_PASSWORD=root/OJ_PASSWORD=$PASSWORD/g"      /home/judge/etc/judge.conf  \
    && sed -i "s/OJ_COMPILE_CHROOT=1/OJ_COMPILE_CHROOT=0/g"     /home/judge/etc/judge.conf  \
    && sed -i "s/OJ_RUNNING=1/OJ_RUNNING=$CPU/g"                /home/judge/etc/judge.conf  \
    && sed -i "s/OJ_SHM_RUN=1/OJ_SHM_RUN=0/g"                   /home/judge/etc/judge.conf  \
    && sed -i "s/127.0.0.1:9000/unix:\/var\/run\/php\/php7.2-fpm.sock/g"    /etc/nginx/sites-available/default              \
    && sed -i "s/DB_USER=\"root\"/DB_USER=\"$USERNAME\"/g"                  /home/judge/src/web/include/db_info.inc.php     \
    && sed -i "s/DB_PASS=\"root\"/DB_PASS=\"$PASSWORD\"/g"                  /home/judge/src/web/include/db_info.inc.php     \
    && for i in $(seq 1 ${CPU}); do     \
    mkdir -p    /home/judge/run`expr ${CPU} - 1`;    \
    chown judge /home/judge/run`expr ${CPU} - 1`;    \
    done 

# Install openssh-server
RUN apt-get -y install ssh          \
    && echo "root:root" | chpasswd  \
    && echo "PermitRootLogin yes" >> /etc/ssh/sshd_config

VOLUME /volume

ENTRYPOINT set -xe                                      \
    && if [ ! -d /volume/backup ]; then                 \
    cp -rp /home/judge/backup  /volume/backup;          \
    fi                                                  \
    && if [ ! -d /volume/data ]; then                   \
    cp -rp /home/judge/data /volume/data;               \
    fi                                                  \
    && if [ ! -d /volume/etc ]; then                    \
    cp -rp /home/judge/etc /volume/etc;                 \
    fi                                                  \
    && if [ ! -d /volume/web ]; then                    \
    cp -rp /home/judge/src/web /volume/web;             \
    fi                                                  \
    && if [ ! -d /volume/mysql ]; then                  \
    cp -rp /var/lib/mysql /volume/mysql;                \
    fi                                                  \
    && chmod -R 700 /volume/etc                         \
    && chmod -R 700 /volume/backup                      \
    && chmod -R 700 /volume/web/include/                \
    && chown -R www-data:www-data /volume/data          \
    && chown -R www-data:www-data /volume/web           \
    && chown -R mysql:mysql       /var/lib/mysql        \
    && rm -rf /home/judge/backup                        \
    && rm -rf /home/judge/data                          \
    && rm -rf /home/judge/etc                           \
    && rm -rf /home/judge/src/web                       \
    && rm -rf /var/lib/mysql                            \
    && ln -s /volume/backup /home/judge/backup          \
    && ln -s /volume/data   /home/judge/data            \
    && ln -s /volume/etc    /home/judge/etc             \
    && ln -s /volume/web    /home/judge/src/web         \
    && ln -s /volume/mysql  /var/lib/mysql              \
    && service mysql        start                       \
    && service php7.2-fpm   start                       \
    && service hustoj       start                       \
    && service ssh          start                       \
    && nginx -g "daemon off;"
