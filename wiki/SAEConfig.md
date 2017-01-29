#summary Config HUSTOJ on SAE

= Introduction =

SAE is Sina App Engine


= Details =

enable storage service
  * add public storage domain "web" in your app
  * add dir "upload" in "web" domain
  * add private storage domain "data" in your app

edit web/include/db_info.inc.php :
  * $OJ_SAE=true;
  * $SAE_STORAGE_ROOT="http://hustoj-web.stor.sinaapp.com/"; replace "http://hustoj-web.stor.sinaapp.com/" with your storage web root

edit /web/fckeditor/editor/filemanager/connectors/php/config.php
  * $OJ_SAE=true;
  * $SAE_STORAGE_ROOT="http://hustoj-web.stor.sinaapp.com/"; replace "http://hustoj-web.stor.sinaapp.com/" with your storage web root