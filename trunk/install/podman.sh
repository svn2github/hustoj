#!/bin/bash
cd /home/judge/src/install || exit 1；
while ! apt-get install -y podman containerd
do
		echo "Network fail, retry... you might want to make sure podman is available in your apt source"
done

while ! podman build -t hustoj .
do
		echo "Network fail, retry... you might want to make sure podman image source is available"
done
 
