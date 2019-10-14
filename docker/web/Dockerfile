FROM ubuntu:18.04

COPY docker/sources.list /etc/apt/sources.list

# Linux: Aliyun Apt Mirrors.
RUN apt-get -y update  && \
    apt-get -y upgrade && \
    DEBIAN_FRONTEND=noninteractive \
    apt-get -y install --no-install-recommends \
        nginx \
        php-common \
        php-fpm \
        php-mysql \
        php-gd \
        php-zip \
        php-mbstring \
        php-xml

COPY trunk/ /trunk/

COPY docker/ /opt/docker/

RUN bash /opt/docker/web/setup.sh

# sharing data volume with judge container
VOLUME [ "/home/judge/data" ]

ENV HOSTNAME=localhost

ENV DATABASE=jol

ENV USERNAME=root

ENV PASSWORD=root

ENTRYPOINT [ "/bin/bash", "/opt/docker/web/entrypoint.sh" ]