set -xe

sed -i "s#DB_HOST=\"localhost\"#DB_HOST=\"$HOSTNAME\"#g"    /home/judge/src/web/include/db_info.inc.php
sed -i "s#DB_NAME=\"jol\"#DB_NAME=\"$DATABASE\"#g"          /home/judge/src/web/include/db_info.inc.php
sed -i "s#DB_USER=\"root\"#DB_USER=\"$USERNAME\"#g"         /home/judge/src/web/include/db_info.inc.php
sed -i "s#DB_PASS=\"root\"#DB_PASS=\"$PASSWORD\"#g"         /home/judge/src/web/include/db_info.inc.php

chown -R www-data:www-data /home/judge/data

regexp=`cat /home/judge/src/web/template/bs3/js.php | grep http://hustoj.com/wx.jpg | grep http://hustoj.com/alipay.png`;
sed -i "s#$regexp##g" /home/judge/src/web/template/bs3/js.php

service php7.2-fpm start
nginx -g "daemon off;"
