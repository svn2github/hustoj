docker rm $(docker ps -a -q)
#cd docker\hustoj-base
cd ../../
#cd core & ./makeForDocker.sh & cd ..
docker build -f docker/hustoj/Dockerfile -t hustoj  ./

mkdir -p /home/data/ /home/data/config
chmod 777 /home/data/ /home/data/config

docker rm -f /hustoj
docker run -d \
-it \
-v /home/data/mysql:/var/lib/mysql \
-v /home/data/data:/home/judge/data \
-v /home/data/config/db_info.inc.php:/home/judge/src/web/include/db_info.inc.php \
-v /home/data/upload:/home/judge/src/web/upload \

--name hustoj -p 80:80 \
hustoj

