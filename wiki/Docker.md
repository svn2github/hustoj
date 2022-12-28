用Docker进行部署可以参考下面的内容
==


Dockerfile
--
```
FROM ubuntu:22.04
ENV DEBIAN_FRONTEND noninteractive
RUN     sed -i 's/archive.ubuntu/mirrors.aliyun/g' /etc/apt/sources.list &&\
        apt-get update && apt-get -y upgrade
RUN     DEBIAN_FRONTEND=noninteractive  apt-get -y install --no-install-recommends        wget w3m

# make Chinese Character works in Docker
RUN apt-get install -y locales locales-all
RUN locale-gen zh_CN.UTF-8 && dpkg-reconfigure locales && /usr/sbin/update-locale LANG=zh_CN.UTF-8
ENV LANG zh_CN.UTF-8
ENV LANGUAGE zh_CN:zh
ENV LC_ALL zh_CN.UTF-8

RUN wget dl.hustoj.com/install-ubuntu22.04.sh
RUN bash install-ubuntu22.04.sh
RUN sed -i 's|DB_HOST="localhost"|DB_HOST="127.0.0.1"|g' /home/judge/src/web/include/db_info.inc.php
# override endl not to flush the io buffer
RUN  echo "std::ostream& endl(std::ostream& s) { \
s<<'\\\\n'; \
return s; \
}" >> `find /usr/include/c++/ -name iostream`
RUN usermod -d /var/lib/mysql mysql
RUN set -ex \
        && chown -R mysql:mysql /var/lib/mysql
# RUN  sed -i 's/80 default_server;/8080 default_server;/g' /etc/nginx/sites-enabled/default
RUN echo "#!/bin/bash\n service mysql start\nservice php8.1-fpm start \n judged \n nginx -g \"daemon off;\"">/start.sh
RUN chmod +x /start.sh
#EXPOSE 8080
ENTRYPOINT ["/start.sh"]
```

linux install cmd lines
--
```
mkdir hustoj
cd hustoj
wget -O Dockerfile http://dl.hustoj.com/Dockerfile.worker
docker build . -t worker
docker run -d -p8080:80 --name hustojcontainer worker
docker ps 
```

linux restart cmd line
--
```
docker start hustojcontainer
```
