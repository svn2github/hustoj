# 升级

### 使用脚本安装的用户

可以使用 `install` 目录中的 `update-hustoj` 进行升级。

```bash
sudo bash /home/judge/src/install/update-hustoj
```

升级脚本执行后，可能需要登陆 web 端管理后台，执行一次更新数据库。

### 通过 SVN 方式安装的

检出最新 `web` ，复制原 `upload` 目录到新目录，测试后切换

```bash
sudo svn checkout https://github.com/zhblue/hustoj/trunk/trunk/web /var/www/new/
sudo cp -a /var/www/JudgeOnline/include/db_info.inc.php /var/www/new/include/
sudo cp -a /var/www/JudgeOnline/upload /var/www/new/
```

#### 检出最新 `core` `./make.sh`

```bash
sudo svn checkout https://github.com/zhblue/hustoj/trunk/trunk/core core
cd core
sudo pkill -9 judged
sudo ./make.sh
sudo judged
```

#### 管理员登陆后台，更新数据库

访问 `http://原 OJ 地址/new` -> 登陆后台，更新数据库。 -> 测试无误后执行下面命令：

```bash
sudo mv /var/www/JudgeOnline /var/www/oldOJ
sudo mv /var/www/new /var/www/JudgeOnline
```

### 通过 `.tar.gz` 源码安装的

1．到安装文件目录找到 `hustoj-read-only` 目录。

2．执行命令

```bash
sudo svn up hustoj-read-only
cd hustoj-read-only/core
sudo ./make.sh
sudo svn up /var/www/JudgeOnline
```



