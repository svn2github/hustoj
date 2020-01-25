集成Moodle活动自动给分
----
How to use HUSTOJ with Moodle 
----

Base requirement 基础要求
--
Moodle3.8+ need ubuntu 18.04.

由于Moodle需要新版的PHP和mysql，所以需要安装在Ubuntu18.04以上的机器上。

Preparation 预备工作
--

install hustoj using .sh script, add line before ```location / { ``` in /etc/nginx/sites-enbaled/default for install moodle

首先用脚本安装HUSTOJ，然后在/etc/nginx/sites-enbaled/default文件中```location / { ``` 这一行之前添加下面的内容：

```
        if (!-e $request_filename) {
           rewrite "^(.*\.php)(/)(.*)$" $1?file=/$3 last;
        }

```

read judge.conf to get account for mysql 查阅judge.conf获得数据库账户
```
cat /home/judge/etc/judge.conf
```


reload configure for nginx 重新加载nginx配置文件

```
sudo service nginx reload
```
install moodle 安装moodle
--
download moodle source files from [Moodle Download](https://download.moodle.org/releases/latest/)

从[这里](https://download.moodle.org/releases/latest/)下载最新的moodle源码文件。

unzip/tar -xzf moodle files into /home/judge/src/web/

把下载到的moodle安装文件解压到/home/judge/src/web目录下，得到/home/judge/src/web/moodle目录

fix ownner of src

修改所有目录的属主为www-data

```
chown -R www-data /home/judge/src/

```
refresh OJ web will show the Moodle Link on top left, click to begain install moodle.

刷新OJ页，得到右上角的Moodle入口，点击开始安装流程。

**don't change the moodle default database name: moodle   default table name prefix: mdl_**

**moodle的数据库默认moodle，表前缀mdl_ ，请不要修改**


link two system 关联两个系统
--

let students use same username in both system.

让学生在两个系统中用相同的用户名注册。


add a contest in HUSTOJ for example Contest 1000

在HUSTOJ中添加一个比赛，获得比赛编号1000

add a text-homework in moodle with title [OJ]-C1000 for OJ Contest 1000.

在moodle中添加一个文本作业，标题命名为[OJ]-C1000，其中的1000表示OJ中对应的比赛编号。

add trigger 添加触发器
--
``` 
DELIMITER $$
DROP trigger IF EXISTS `jol`.`tri_moodle` $$
create trigger tri_moodle
after update on solution
for each row
begin
   declare mark int;
   declare total int;
  
   select count(1) into total from contest_problem where contest_id=new.contest_id;
   if total>0 then
       select sum(ac)/total*100 into mark
          from (select max(pass_rate) ac from solution where user_id=new.user_id and contest_id=new.contest_id and problem_id>0 group by problem_id) s;
     
       call update_moodle(new.contest_id,new.user_id,mark);
       
   end if;
end $$
DELIMITER ;
```
add procedure 添加存储过程
--
```
DELIMITER $$
CREATE PROCEDURE `update_moodle`(IN `cid` INT, IN `user_id` VARCHAR(20), IN `mark` INT)
top:BEGIN
   declare as_id int;
  declare u_id int;
  declare nowtime int;
  declare oldid int;
  set nowtime=UNIX_TIMESTAMP(now());
  set as_id=0;
  select m.id into as_id from
        moodle.mdl_assign m
         where m.name = concat('[OJ]-C',cid);
  if as_id=0 then
    leave top;
  end if;
  set u_id =-1;
  select m.id into u_id from moodle.mdl_user m where username=user_id;
  select mag.grade into oldid from moodle.mdl_assign_grades mag
      where assignment=as_id and userid=u_id;

  set oldid=-1;

  select id into oldid from moodle.mdl_assign_submission m
      where assignment=as_id and userid=u_id;
    if oldid =-1 then
 
       insert into moodle.mdl_assign_submission
             (assignment,userid,timecreated,timemodified,status,attemptnumber)
       values( as_id    ,u_id  ,nowtime    ,nowtime     ,'new' ,0);
       insert into  moodle.mdl_assign_grades(assignment,userid,timecreated,timemodified,grader,grade,attemptnumber)
       select ma.id,mas.userid,UNIX_TIMESTAMP( NOW( ) ),UNIX_TIMESTAMP( NOW( ) ),2,mark,0
                from  moodle.mdl_assign ma
                inner join  moodle.mdl_assign_submission mas on
                mas.assignment=ma.id and mas.status='new' 
                where concat(ma.id,',',mas.userid) not in (select  concat(assignment,',',userid)  from moodle.mdl_assign_grades);

   else

   
    update moodle.mdl_assign_grades
       set grade=mark,timemodified=nowtime where
        assignment=as_id and userid=u_id;

  end if;

  
END$$
DELIMITER ;
 
```
Expecting Result 预期效果
--
when students submit solution in hustoj , moodle will show the latest mark for the contest in 0-100.

当学生在hustoj中提交代码，moodle将在作业里同步显示他们的最新成绩。

<img src="https://raw.githubusercontent.com/zhblue/hustoj/master/wiki/moodle.png" >






