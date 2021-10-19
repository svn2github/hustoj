#!/bin/bash
cd /home/judge/src/install || exit 1；
while ! apt-get install -y docker.io
do
		echo "Network fail, retry... you might want to make sure docker.io is available in your apt source"
done

while ! docker build -t hustoj .
do
		echo "Network fail, retry... you might want to make sure https://hub.docker.com/ is available"
done
