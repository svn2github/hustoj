#summary Convert database from NOJ-OpenSource to HUSTOJ

= Introduction =

Convert database from NOJ-OpenSource to HUSTOJ


= Details =
设NOJ数据库为acmhome，HUSTOJ数据库为jol
{{{
insert into jol.problem(problem_id,title,description,input,output,sample_input,sample_output,spj,hint,source,defunct) 
select id,title,description,input,output,sample_input,sample_output,'N',hint,source,defunct from acmhome.problem;
}}}