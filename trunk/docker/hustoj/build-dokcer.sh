#docker rm $(docker ps -a -q)
#cd docker\hustoj-base
cd ../../
#cd core & ./makeForDocker.sh & cd ..

#docker build -f Dockerfile -t hustoj  ./

docker stop /hustoj
docker rm -f /hustoj
#rm -R /home/data/
mkdir -p /home/data/ /home/data/config
chmod 777 /home/data/ /home/data/config


docker run -d -it \
-v /home/data/data:/home/judge/data \
-v /home/data/mysql:/var/lib/mysql \
-v /home/data/upload:/home/judge/src/web/upload \
-v /home/data/config:/home/judge/src/web/config \
--name hustoj -p 80:80 hustoj

#docker run -d -it \ 
#-v /home/data/data:/home/judge/data \
#-v /home/data/upload:/home/judge/src/web/upload \
#-v /home/data/mysql:/var/lib/mysql  \
#--name hustoj -p 80:80 hustoj

#
#docker run -d -it --name hustoj -p 80:80 hustoj
#docker exec -i -t hustoj /bin/bash