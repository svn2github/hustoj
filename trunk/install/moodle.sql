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
