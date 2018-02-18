FROM ubuntu:trusty-20171117

COPY ./sources.list /etc/apt/sources.list

RUN { \
		echo mysql-community-server mysql-community-server/data-dir select ''; \
		echo mysql-community-server mysql-community-server/root-pass password ''; \
		echo mysql-community-server mysql-community-server/re-root-pass password ''; \
		echo mysql-community-server mysql-community-server/remove-test-db select false; \
	} | debconf-set-selections \
	&& apt-get update	\
	&& apt-get install -y subversion make flex g++ clang libmysqlclient-dev libmysql++-dev php5-fpm php5-memcache memcached nginx mysql-server php5-mysql php5-gd fp-compiler openjdk-7-jdk \
	&& chown -R mysql:mysql /var/lib/mysql \
	&& /usr/sbin/useradd -m -u 1536 judge 
	
	
