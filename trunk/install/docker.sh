#!/bin/bash
cd /home/judge/src/install || exit 1；
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

systemctl restart docker

while ! docker build -t hustoj .
do
		echo "Network fail, retry... you might want to make sure https://hub.docker.com/ is available"
done
 
