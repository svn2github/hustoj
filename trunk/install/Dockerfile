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
RUN	svn up /home/judge/src 
RUN     cd /home/judge/src/core/ && \
	bash make.sh 

# for more compilers, remove # and run "docker build -t hustoj ."

#RUN     apt-get -y install ruby
#RUN     apt-get -y install gobjc
#RUN     apt-get -y install clang
#RUN     apt-get -y install guile-3.0
#RUN     apt-get -y install lua5.3
#RUN     apt-get -y install nodejs
#RUN     apt-get -y install golang
#RUN     apt-get -y install sqlite3
#RUN     apt-get -y install gfortran
#RUN     apt-get -y install octave
	
 

