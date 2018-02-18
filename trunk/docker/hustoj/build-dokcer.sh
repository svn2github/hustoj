docker rm $(docker ps -a -q)
#cd docker\hustoj-base
#cd ../../
#cd core & ./makeForDocker.sh & cd ..
docker build -t hustoj ./

mkdir -p /home/data/
chmod 777 /home/data/

docker rm -f /hustoj
docker run -d \
-it \
-v /home/data/mysql:/var/lib/mysql \
--name hustoj -p 80:80 \
hustoj

