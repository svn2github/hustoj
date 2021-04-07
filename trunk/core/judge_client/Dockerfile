FROM ubuntu:20.04
RUN     apt-get update && \
	DEBIAN_FRONTEND=noninteractive \
    	apt-get -y install --no-install-recommends \
        libmysqlclient-dev \
        libmysql++-dev \
        make \
        flex \
        gcc \
        g++ \
        python \
        python3 \
	wget

RUN     useradd -m -u 1536 judge
RUN     cd /home/judge/ && \ 
	wget dl.hustoj.com/hustoj.tar.gz && \
        tar xzf hustoj.tar.gz && \
	cd src/core/judge_client && \
	make && \
	cp judge_client /usr/bin/


