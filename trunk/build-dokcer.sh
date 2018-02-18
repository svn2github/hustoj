docker rm $(docker ps -a -q)
cd docker\hustoj-base
cd ../../
docker rm -f /hustoj
cd core
./makeForDocker.sh
cd ..
docker build -t hustoj ./
docker run --name hustoj -p 80:80 -i -t -d hustoj
#docker exec -i -t hustoj /bin/bash

