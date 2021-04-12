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
        tar xzf hustoj.tar.gz && \
	svn up src &&\
	cd src/core/judge_client && \
	make && \
	cp judge_client /usr/bin/ && \
	cd ../sim/sim_3_01 && \
	make fresh                        && \
	make exes                         && \
	chmod +x sim*                     && \
	cp sim_c.exe /usr/bin/sim_c       && \
	cp sim_c++.exe /usr/bin/sim_cc    && \
	cp sim_java.exe /usr/bin/sim_java && \
	cp sim_pasc.exe /usr/bin/sim_pas  && \
	cp sim_text.exe /usr/bin/sim_text && \
	cp sim_lisp.exe /usr/bin/sim_scm  && \
	cd ..                             && \
	cp sim.sh /usr/bin                && \
	chmod +x /usr/bin/sim.sh          
 

