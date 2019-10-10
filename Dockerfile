FROM ubuntu:18.04

COPY docker/sources.list /etc/apt/sources.list

# Linux: Aliyun Apt Mirrors.
RUN apt-get -y update  && \
    apt-get -y upgrade && \
    DEBIAN_FRONTEND=noninteractive \
    apt-get -y install --no-install-recommends \
        nginx \
        mysql-server \
        libmysqlclient-dev \
        libmysql++-dev \
        php-common \
        php-fpm \
        php-mysql \
        php-gd \
        php-zip \
        php-mbstring \
        php-xml \
        make \
        flex \
        gcc \
        g++ \
        openjdk-11-jdk

COPY trunk /trunk

COPY docker/ /opt/docker/

RUN bash /opt/docker/setup.sh

# VOLUME [ "/volume", "/home/judge/backup", "/home/judge/data", "/home/judge/etc", "/home/judge/web", "/var/lib/mysql" ]
VOLUME [ "/volume" ]

ENTRYPOINT [ "/bin/bash", "/opt/docker/entrypoint.sh" ]
