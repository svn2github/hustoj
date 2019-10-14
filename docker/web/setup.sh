set -xe

# Hustoj basic file system
useradd -m -u 1536 judge
mkdir -p /home/judge/data
mv /trunk/ /home/judge/src/
chmod -R 700 /home/judge/src/web/include/
chown -R www-data:www-data /home/judge/data
chown -R www-data:www-data /home/judge/src/web

# Adjust system configuration
cp /home/judge/src/install/default.conf  /etc/nginx/sites-available/default
sed -i "s#127.0.0.1:9000#unix:/var/run/php/php7.2-fpm.sock#g"    /etc/nginx/sites-available/default
