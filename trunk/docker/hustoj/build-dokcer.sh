
docker build -f Dockerfile -t hustoj-dev  ./

docker rm -f /hustoj-dev

#rm -R /home/test/
#mkdir -p /home/test
#chmod -R 777 /home/test/

#docker run -d -it --privileged --name hustoj-dev -p 80:80 hustoj-dev
docker run -d -it --privileged --name hustoj-dev -p 80:80 -v /home/test/:/data hustoj-dev
#docker run -d -it --name hustoj-dev -p 80:80 hustoj-dev
docker exec -i -t hustoj-dev /bin/bash