FROM ubuntu:20.04
RUN     sed -i 's/archive.ubuntu/mirrors.163/g' /etc/apt/sources.list &&\
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
        openjdk-14-jdk\
	subversion \
	wget
RUN     apt-get -y install sqlite3
RUN     useradd -m -u 1536 judge
RUN     cd /home/judge/ && \ 
	wget dl.hustoj.com/hustoj.tar.gz && \
        tar xzf hustoj.tar.gz 
#Github update
#RUN	svn up /home/judge/src 
RUN     cd /home/judge/src/core/ && \
	bash make.sh 

# for more compilers, VMs and runtimes , remove # and run "docker build -t hustoj ."

#RUN     DEBIAN_FRONTEND=noninteractive apt-get -y install --no-install-recommends ruby
#RUN     DEBIAN_FRONTEND=noninteractive apt-get -y install --no-install-recommends gobjc
#RUN     DEBIAN_FRONTEND=noninteractive apt-get -y install --no-install-recommends clang
#RUN     DEBIAN_FRONTEND=noninteractive apt-get -y install --no-install-recommends guile-3.0
#RUN     DEBIAN_FRONTEND=noninteractive apt-get -y install --no-install-recommends lua5.3
#RUN     DEBIAN_FRONTEND=noninteractive apt-get -y install --no-install-recommends nodejs
#RUN     DEBIAN_FRONTEND=noninteractive apt-get -y install --no-install-recommends golang
#RUN     DEBIAN_FRONTEND=noninteractive apt-get -y install --no-install-recommends sqlite3
#RUN     DEBIAN_FRONTEND=noninteractive apt-get -y install --no-install-recommends gfortran
#RUN     DEBIAN_FRONTEND=noninteractive apt-get -y install --no-install-recommends octave
	
 

