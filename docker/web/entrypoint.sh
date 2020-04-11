set -xe

setpropertiy(){
  if [ $# -ge 1 ];then
    key=$1
    value=`printenv $key || true`
    if [ $# -ge 2 ];then
      quate=$2
    fi
    if [ -n "$value" ];then
      oldvalue=`cat /home/judge/src/web/include/db_info.inc.php | grep $key | awk -F '=' '{print $2}' | awk -F ';' '{print $1}' | awk -F '"' '{print $2}'`
      if [ $quate == "quate" ] || [$quate == "true"];then
        sed -i "s#$key=\"$oldvalue\"#$key=\"$value\"#g"   /home/judge/src/web/include/db_info.inc.php
      else
        sed -i "s#$key=$oldvalue#$key=$value#g"           /home/judge/src/web/include/db_info.inc.php
      fi
    fi
  fi
}

setpropertiy DB_HOST quate
setpropertiy DB_NAME quate
setpropertiy DB_USER quate
setpropertiy DB_PASS quate

chown -R www-data:www-data /home/judge/data

regexp=`cat /home/judge/src/web/template/bs3/js.php | grep http://hustoj.com/wx.jpg | grep http://hustoj.com/alipay.png`;
sed -i "s#$regexp##g" /home/judge/src/web/template/bs3/js.php

ln -sf /dev/stdout /var/log/nginx/access.log
ln -sf /dev/stderr /var/log/nginx/error.log

service php7.2-fpm start
nginx -g "daemon off;"
