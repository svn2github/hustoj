set names utf8; 
create database jol;
use jol;


 

CREATE TABLE `compileinfo` (

  `solution_id` int(11) NOT NULL default '0',

  `error` text,

  PRIMARY KEY  (`solution_id`)

) ENGINE=MyISAM DEFAULT CHARSET=utf8;


 

CREATE TABLE `contest` (

  `contest_id` int(11) NOT NULL auto_increment,

  `title` varchar(255) default NULL,

  `start_time` datetime default NULL,

  `end_time` datetime default NULL,

  `defunct` char(1) NOT NULL default 'N',

  `description` text,

  `private` tinyint(4) NOT NULL default '0',

  PRIMARY KEY  (`contest_id`)

) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

 

 

CREATE TABLE `contest_problem` (

  `problem_id` int(11) NOT NULL default '0',

  `contest_id` int(11) default NULL,

  `title` char(200) NOT NULL default '',

  `num` int(11) NOT NULL default '0'

) ENGINE=MyISAM DEFAULT CHARSET=utf8;

 

CREATE TABLE `loginlog` (

  `user_id` varchar(20) NOT NULL default '',

  `password` varchar(40) default NULL,

  `ip` varchar(100) default NULL,

  `time` datetime default NULL

) ENGINE=MyISAM DEFAULT CHARSET=utf8;

 

 

CREATE TABLE `news` (

  `news_id` int(11) NOT NULL auto_increment,

  `user_id` varchar(20) NOT NULL default '',

  `title` varchar(200) NOT NULL default '',

  `content` text NOT NULL,

  `time` datetime NOT NULL default '0000-00-00 00:00:00',

  `importance` tinyint(4) NOT NULL default '0',

  `defunct` char(1) NOT NULL default 'N',

  PRIMARY KEY  (`news_id`)

) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1004 ;

 

 

CREATE TABLE `privilege` (

  `user_id` char(20) NOT NULL default '',

  `rightstr` char(30) NOT NULL default '',

  `defunct` char(1) NOT NULL default 'N'

) ENGINE=MyISAM DEFAULT CHARSET=utf8;

 

CREATE TABLE `problem` (

  `problem_id` int(11) NOT NULL auto_increment,

  `title` varchar(200) NOT NULL default '',

  `description` text,

  `input` text,

  `output` text,

  `sample_input` text,

  `sample_output` text,

  `spj` char(1) NOT NULL default '0',

  `hint` text,

  `source` varchar(100) default NULL,

  `sample_Program` varchar(255) default NULL,

  `in_date` datetime default NULL,

  `time_limit` int(11) NOT NULL default '0',

  `memory_limit` int(11) NOT NULL default '0',

  `defunct` char(1) NOT NULL default 'N',

  `accepted` int(11) default '0',

  `submit` int(11) default '0',

  `ratio` tinyint(4) NOT NULL default '0',

  `error` int(11) default '0',

  `difficulty` tinyint(4) NOT NULL default '0',

  `submit_user` int(11) default '0',

  `solved` int(11) default '0',

  `case_time_limit` int(11) NOT NULL default '0',

  PRIMARY KEY  (`problem_id`)

) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

 
 

CREATE TABLE `solution` (

  `solution_id` int(11) NOT NULL auto_increment,

  `problem_id` int(11) NOT NULL default '0',

  `user_id` varchar(20) NOT NULL default '',

  `time` int(11) NOT NULL default '0',

  `memory` int(11) NOT NULL default '0',

  `in_date` datetime NOT NULL default '0000-00-00 00:00:00',

  `className` varchar(20) NOT NULL default '',

  `result` smallint(6) NOT NULL default '0',

  `language` tinyint(4) NOT NULL default '0',

  `ip` varchar(20) NOT NULL default '',

  `contest_id` int(11) default NULL,

  `valid` tinyint(4) NOT NULL default '1',

  `num` tinyint(4) NOT NULL default '-1',

  `code_length` int(11) NOT NULL default '0',

  `judgetime` datetime default NULL,

  PRIMARY KEY  (`solution_id`),

  KEY `uid` (`user_id`),

  KEY `pid` (`problem_id`),

  KEY `res` (`result`),

  KEY `cid` (`contest_id`)

) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

 
 

CREATE TABLE `source_code` (

  `solution_id` int(11) NOT NULL,

  `source` text NOT NULL,

  PRIMARY KEY  (`solution_id`)

) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE `users` (

  `user_id` varchar(20) NOT NULL default '',

  `email` varchar(100) default NULL,

  `submit` int(11) default '0',

  `solved` int(11) default '0',

  `defunct` char(1) NOT NULL default 'N',

  `ip` varchar(20) NOT NULL default '',

  `accesstime` datetime default NULL,

  `volume` int(11) NOT NULL default '1',

  `language` int(11) NOT NULL default '1',

  `password` varchar(32) default NULL,

  `reg_time` datetime default NULL,

  `nick` varchar(100) NOT NULL default '',

  `school` varchar(100) NOT NULL default '',

  PRIMARY KEY  (`user_id`)

) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `contest` ADD COLUMN `langmask` TINYINT  NOT NULL DEFAULT 0 COMMENT 'bits for LANG to mask' AFTER `private`;



CREATE TABLE `topic` (
  `tid` int(11) NOT NULL auto_increment,
  `title` varbinary(60) NOT NULL,
  `status` int(2) NOT NULL default '0',
  `top_level` int(2) NOT NULL default '0',
  `cid` int(11) default NULL,
  `pid` int(11) NOT NULL,
  `author_id` varchar(20) NOT NULL,
  PRIMARY KEY  (`tid`),
  KEY `cid` (`cid`,`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE `reply` (
 `rid` int(11) NOT NULL auto_increment,
 `author_id` varchar(20) NOT NULL,
 `time` datetime NOT NULL default '0000-00-00 00:00:00',
 `content` text NOT NULL,
 `topic_id` int(11) NOT NULL,
 `status` int(2) NOT NULL default '0',
 `ip` varchar(30) NOT NULL,
 PRIMARY KEY  (`rid`),
 KEY `author_id` (`author_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `online` (
  `hash` varchar(32) collate utf8_unicode_ci NOT NULL,
  `ip` varchar(20) character set utf8 NOT NULL default '',
  `ua` varchar(255) character set utf8 NOT NULL default '',
  `refer` varchar(255) collate utf8_unicode_ci default NULL,
  `lastmove` int(10) NOT NULL,
  `firsttime` int(10) default NULL,
  `uri` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`hash`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `jol`.`online` ENGINE = MEMORY;


ALTER TABLE `jol`.`problem` DROP COLUMN `sample_Program`,
 DROP COLUMN `ratio`,
 DROP COLUMN `error`,
 DROP COLUMN `difficulty`,
 DROP COLUMN `submit_user`,
 DROP COLUMN `case_time_limit`;

CREATE TABLE `solution_sim` (

  `solution_id` int(11) NOT NULL,
  `sim_solution_id` int(11) NULL,
  `sim` int(11) NULL,

  PRIMARY KEY  (`solution_id`)

) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `solution_sim` RENAME TO `sim`,
 CHANGE COLUMN `solution_id` `s_id` INTEGER  NOT NULL,
 CHANGE COLUMN `sim_solution_id` `sim_s_id` INTEGER  DEFAULT NULL,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`s_id`);
