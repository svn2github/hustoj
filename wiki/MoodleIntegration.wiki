#summary Moodle system Integation 集成Moodle线下活动自动给分
#labels Featured

= Introduction =

Teachers want to use HUSTOJ with Moodle 


= Details =

try include/login-moodle.php by change db_info.inc.php

$OJ_LOGIN_MOD="moodle";


----

add homework with title [OJ]-C1000 for OJ Contest 1000

add trigger and procedue
 
DELIMITER $$
DROP trigger IF EXISTS `jol`.`tri_moodle` $$
create trigger tri_moodle
after update on solution
for each row
begin
   declare mark int;
   declare total int;
   declare ac int;
   declare wa int;
   set mark=100;
   select count(1) into total from contest_problem where contest_id=new.contest_id;
   select count(distinct problem_id)into ac
      from solution where result=4 and user_id=new.user_id and contest_id=new.contest_id;
   select count(distinct problem_id)into wa
      from solution where result>4 and user_id=new.user_id and contest_id=new.contest_id;
   set mark=mark/total*ac-wa;
   if new.result=4 then
      call update_moodle(new.contest_id,new.user_id,mark);
   end if;

end $$
DELIMITER ;

  
DELIMITER $$

DROP PROCEDURE IF EXISTS `jol`.`update_moodle` $$
CREATE PROCEDURE `jol`.`update_moodle` (pid int,user_id varchar(20), mark int)
top:BEGIN
  declare as_id int;
  declare u_id int;
  declare nowtime int;
  declare oldmark int;
  set nowtime=UNIX_TIMESTAMP(now());
  set as_id=0;
  select m.id into as_id from
        moodle.mdl_assignment m
         where m.name = concat('[OJ]-C',pid);
  if as_id=0 then
    leave top;
  end if;
  set u_id =0;
  select m.id into u_id from moodle.mdl_user m where username=user_id;

  set oldmark=-1;

  select m.grade into oldmark from moodle.mdl_assignment_submissions m
      where assignment=as_id and userid=u_id;
  -- select oldmark;
  if oldmark =-1 then


       insert into moodle.mdl_assignment_submissions
        (assignment,userid,timecreated,timemodified,numfiles,data1,data2,grade,submissioncomment,`format`,teacher,timemarked,mailed)
       values( as_id,u_id,nowtime,nowtime,0,'','',mark,'',1,1,nowtime,0);

   else

    update moodle.mdl_assignment_submissions
       set grade=mark,timemodified=nowtime where
        assignment=as_id and userid=u_id;

  end if;
  -- select as_id,u_id,oldmark,mark;

END $$

DELIMITER ;
 
