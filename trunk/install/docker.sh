#!/bin/bash
cd /home/judge/src/install || exit 1；
while ! apt-get install -y docker.io containerd
do
		service docker start
		echo "Network fail, retry... you might want to make sure docker.io is available in your apt source"
done

echo "{
    \"registry-mirrors\": [\"https://y0qd3iq.mirror.aliyuncs.com\"]
    \"live-restore\":true,
}" > /etc/docker/daemon.json

systemctl restart docker

while ! docker build -t hustoj .
do
		echo "Network fail, retry... you might want to make sure https://hub.docker.com/ is available"
done
