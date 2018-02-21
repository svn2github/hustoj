
docker build -f Dockerfile -t hustoj-cpp  ./

docker rm -f -v /hustoj-dev & docker run -d -it --privileged --name hustoj-dev -p 8080:80 hustoj-dev
#docker run -d -it --privileged --name hustoj-dev -p 80:80 -v /home/test/:/data hustoj-dev
#docker exec -i -t hustoj-dev /bin/bash
