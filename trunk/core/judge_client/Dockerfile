FROM ubuntu:20.04
RUN     sed -i 's/archive.ubuntu/mirrors.aliyun/g' /etc/apt/sources.list &&\
	apt-get update && \
	DEBIAN_FRONTEND=noninteractive \
    	apt-get -y install --no-install-recommends \
        libmysqlclient-dev \
        libmysql++-dev \
        make \
        flex \
        gcc \
        g++ \
        iptables \
        python \
        python3 \
	fp-compiler \
	mono-devel \
	busybox \
	dos2unix \
        openjdk-11-jdk\
	subversion \
	wget
RUN     useradd -m -u 1536 judge
RUN     cd /home/judge/ && \ 
	wget dl.hustoj.com/hustoj.tar.gz && \
        tar xzf hustoj.tar.gz 
RUN	svn up /home/judge/src 
RUN     cd /home/judge/src/core/ && \
	bash make.sh 
	
 

