#!/bin/bash
cd /home/judge/src/install || exit 1；
dpkg --configure -a
while ! apt-get install -y docker.io containerd
do
		service docker start
		echo "Network fail, retry... you might want to make sure docker.io is available in your apt source"
done

cat > /etc/docker/daemon.json <<EOF
{
	"registry-mirrors": ["https://y0qd3iq.mirror.aliyuncs.com"],
	"live-restore": true,
	"log-opts": {
		"max-size": "512m",
		"max-file": "3"
	}
}
EOF

bash add_dns_to_docker.sh

systemctl restart docker

while ! docker build -t hustoj .
do

		echo "Network fail, retry... you might want to make sure https://hub.docker.com/ is available"
done
 
sed -i "s/OJ_USE_DOCKER=0/OJ_USE_DOCKER=1/g" /home/judge/etc/judge.conf
sed -i "s/OJ_PYTHON_FREE=0/OJ_PYTHON_FREE=1/g" /home/judge/etc/judge.conf
pkill -9 judged
/usr/bin/judged
