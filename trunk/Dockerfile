FROM ubuntu:trusty-20171117

#COPY ./docker/hustoj/sources.list /etc/apt/sources.list
	
RUN apt-get update && apt-get install -y make flex g++ clang libmysqlclient-dev libmysql++-dev php5-fpm php5-memcache memcached nginx php5-mysql php5-gd \
	&& rm -rf /var/lib/apt/lists/* 
	
RUN \
	echo 'mysql-server-5.5 mysql-server/root_password password ""' | sudo debconf-set-selections \
	&& echo 'mysql-server-5.5 mysql-server/root_password_again password ""' | sudo debconf-set-selections \
	&& apt-get update && apt-get install -y mysql-server \
	&& rm -rf /var/lib/apt/lists/* \
	&& /usr/sbin/useradd -m -u 1536 judge 

COPY . /home/judge/src

RUN  \
	USER=`cat /etc/mysql/debian.cnf |grep user|head -1|awk  '{print $3}'` \
	&& PASSWORD=`cat /etc/mysql/debian.cnf |grep password|head -1|awk  '{print $3}'` \
	&& CPU=`grep "cpu cores" /proc/cpuinfo |head -1|awk '{print $4}'`   \	
	&& cd /home/judge/                  \
	&& mkdir etc data log   \
	&& cp src/install/java0.policy  /home/judge/etc   \
	&& cp src/install/judge.conf  /home/judge/etc   \
	&& mkdir run0 run1 run2 run3   \
	&& chown judge run0 run1 run2 run3   \
	&& sed -i "s/OJ_USER_NAME=root/OJ_USER_NAME=$USER/g" etc/judge.conf   \
	&& sed -i "s/OJ_PASSWORD=root/OJ_PASSWORD=$PASSWORD/g" etc/judge.conf   \
	&& sed -i "s/OJ_RUNNING=1/OJ_RUNNING=$CPU/g" etc/judge.conf   \
	&& sed -i "s/DB_USER=\"root\"/DB_USER=\"$USER\"/g" src/web/config/db_info.inc.php   \
	&& sed -i "s/DB_PASS=\"root\"/DB_PASS=\"$PASSWORD\"/g" src/web/config/db_info.inc.php   \
	&& chown www-data src/web/upload data   \
	&& sed -i "s:include /etc/nginx/mime.types;:client_max_body_size    80m;\n\tinclude /etc/nginx/mime.types;:g" /etc/nginx/nginx.conf   \
	&& chown -R mysql:mysql /var/lib/mysql \
	&& sed -i "s:root /usr/share/nginx/html;:root /home/judge/src/web;:g" /etc/nginx/sites-enabled/default   \
	&& sed -i "s:index index.html:index index.php:g" /etc/nginx/sites-enabled/default   \
	&& sed -i "s:#location ~ \\\.php\\$:location ~ \\\.php\\$:g" /etc/nginx/sites-enabled/default   \
	&& sed -i "s:#\tfastcgi_split_path_info:\tfastcgi_split_path_info:g" /etc/nginx/sites-enabled/default   \
	&& sed -i "s:#\tfastcgi_pass unix:\tfastcgi_pass unix:g" /etc/nginx/sites-enabled/default   \
	&& sed -i "s:#\tfastcgi_index:\tfastcgi_index:g" /etc/nginx/sites-enabled/default   \
	&& sed -i "s:#\tinclude fastcgi_params;:\tinclude fastcgi_params;\n\t}:g" /etc/nginx/sites-enabled/default   \
	&& sed -i "s/post_max_size = 8M/post_max_size = 80M/g" /etc/php5/fpm/php.ini     \
	&& sed -i "s/upload_max_filesize = 2M/upload_max_filesize = 80M/g" /etc/php5/fpm/php.ini   
	
WORKDIR /home/judge/src/core
RUN pwd && chmod +x make.sh && ./make.sh

WORKDIR /home/judge/
EXPOSE 80
VOLUME ["/home/judge/data","/home/judge/src/web/upload","/var/lib/mysql"]

COPY ./docker/hustoj/docker-entrypoint.sh /usr/local/bin/
RUN  chmod +x /usr/local/bin/docker-entrypoint.sh

RUN cp -R /var/lib/mysql/ /home/ \
	&& cp -R /home/judge/src/web/config/ /home/

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

