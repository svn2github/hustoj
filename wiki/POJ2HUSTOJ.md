#summary 很多学校在使用POJ免费版，并且积累了一定的题目数据，不舍得抛弃，这里解决数据迁移问题。
#labels Featured,系统迁移

= Introduction =

如何从POJ免费版进行迁移。


= Details =

  * 数据库迁移
    利用mysql工具备份一个judgeonline数据库的备份，并在上面运行
     https://github.com/zhblue/hustoj/blob/master/wiki/poj2hustoj.sql ，可以转换为HUSTOJ兼容的数据库。
  * 中文乱码问题
    从Windows的POJ导出的数据库sql脚本很有可能是GBK/GB2312编码的，使用编码转换工具iconv -f gbk -t utf8进行转换后再在Linux系统进行还原，就可以解决乱码问题。具体可以参考：


 # mysqldump -uroot -proot --hex-blob --complete-insert=true --default-character-set=latin1 judgeonline>gbk.sql
 # iconv -c -f gbk -t utf8 gbk.sql >utf8.sql 
 # sed 's/latin1/utf8/g' utf8.sql >newjol.sql 



  * 测试数据迁移
    从windows的d:\data复制所有数据到/home/judge/data/
    执行
    
before 9.10 
```
 apt-get install tofrodos
 find . -name *.in -exec dos2unix {} \;
 find . -name *.out -exec dos2unix {} \;
```
after 10.04  
```
 apt-get install tofrodos
 find . -name *.in -exec fromdos -d {} \;
 find . -name *.out -exec fromdos -d {} \;
```
  * 配置
```
  /var/www/JudgeOnline/include/db_info.inc.php 
  /home/judge/etc/judge.conf
```
  连接到转换后的judgeonline数据库

  * 进行简单测试
  * 注意：因为HUSTOJ在编译时使用更严格的参数，因此void main(){}的声明是不能使用的，必须遵守C的iso标准,使用int main(){return 0;}这一原型。参考 http://www.vcworld.net/bbs/archiver/tid-587.html
