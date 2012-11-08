set names utf8; 

CREATE TABLE  `compileinfo` (
  `solution_id` int(11) NOT NULL DEFAULT '0',
  `error` text,
  PRIMARY KEY (`solution_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE  `contest` (
  `contest_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `defunct` char(1) NOT NULL DEFAULT 'N',
  `description` text,
  `private` tinyint(4) NOT NULL DEFAULT '0',
  `langmask` int NOT NULL DEFAULT '0' COMMENT 'bits for LANG to mask',
  PRIMARY KEY (`contest_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

CREATE TABLE  `contest_problem` (
  `problem_id` int(11) NOT NULL DEFAULT '0',
  `contest_id` int(11) DEFAULT NULL,
  `title` char(200) NOT NULL DEFAULT '',
  `num` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE  `loginlog` (
  `user_id` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(40) DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `time` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE  `mail` (
  `mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `to_user` varchar(20) NOT NULL DEFAULT '',
  `from_user` varchar(20) NOT NULL DEFAULT '',
  `title` varchar(200) NOT NULL DEFAULT '',
  `content` text,
  `new_mail` tinyint(1) NOT NULL DEFAULT '1',
  `reply` tinyint(4) DEFAULT '0',
  `in_date` datetime DEFAULT NULL,
  `defunct` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`mail_id`),
  KEY `uid` (`to_user`)
) ENGINE=MyISAM AUTO_INCREMENT=1013 DEFAULT CHARSET=utf8;

CREATE TABLE  `news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) NOT NULL DEFAULT '',
  `title` varchar(200) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `importance` tinyint(4) NOT NULL DEFAULT '0',
  `defunct` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1004 DEFAULT CHARSET=utf8;


CREATE TABLE  `privilege` (
  `user_id` char(20) NOT NULL DEFAULT '',
  `rightstr` char(30) NOT NULL DEFAULT '',
  `defunct` char(1) NOT NULL DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE  `problem` (
  `problem_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL DEFAULT '',
  `description` text,
  `input` text,
  `output` text,
  `sample_input` text,
  `sample_output` text,
  `spj` char(1) NOT NULL DEFAULT '0',
  `hint` text,
  `source` varchar(100) DEFAULT NULL,
  `in_date` datetime DEFAULT NULL,
  `time_limit` int(11) NOT NULL DEFAULT '0',
  `memory_limit` int(11) NOT NULL DEFAULT '0',
  `defunct` char(1) NOT NULL DEFAULT 'N',
  `accepted` int(11) DEFAULT '0',
  `submit` int(11) DEFAULT '0',
  `solved` int(11) DEFAULT '0',
  PRIMARY KEY (`problem_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8;

CREATE TABLE  `reply` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` varchar(20) NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content` text NOT NULL,
  `topic_id` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `ip` varchar(30) NOT NULL,
  PRIMARY KEY (`rid`),
  KEY `author_id` (`author_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE  `sim` (
  `s_id` int(11) NOT NULL,
  `sim_s_id` int(11) DEFAULT NULL,
  `sim` int(11) DEFAULT NULL,
  PRIMARY KEY (`s_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE  `solution` (
  `solution_id` int(11) NOT NULL AUTO_INCREMENT,
  `problem_id` int(11) NOT NULL DEFAULT '0',
  `user_id` char(20) NOT NULL,
  `time` int(11) NOT NULL DEFAULT '0',
  `memory` int(11) NOT NULL DEFAULT '0',
  `in_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `result` smallint(6) NOT NULL DEFAULT '0',
  `language` INT UNSIGNED NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL,
  `contest_id` int(11) DEFAULT NULL,
  `valid` tinyint(4) NOT NULL DEFAULT '1',
  `num` tinyint(4) NOT NULL DEFAULT '-1',
  `code_length` int(11) NOT NULL DEFAULT '0',
  `judgetime` datetime DEFAULT NULL,
  `pass_rate` DECIMAL(2,2) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`solution_id`),
  KEY `uid` (`user_id`),
  KEY `pid` (`problem_id`),
  KEY `res` (`result`),
  KEY `cid` (`contest_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8;

CREATE TABLE  `source_code` (
  `solution_id` int(11) NOT NULL,
  `source` text NOT NULL,
  PRIMARY KEY (`solution_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE  `topic` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varbinary(60) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `top_level` int(2) NOT NULL DEFAULT '0',
  `cid` int(11) DEFAULT NULL,
  `pid` int(11) NOT NULL,
  `author_id` varchar(20) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `cid` (`cid`,`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE  `users` (
  `user_id` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(100) DEFAULT NULL,
  `submit` int(11) DEFAULT '0',
  `solved` int(11) DEFAULT '0',
  `defunct` char(1) NOT NULL DEFAULT 'N',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `accesstime` datetime DEFAULT NULL,
  `volume` int(11) NOT NULL DEFAULT '1',
  `language` int(11) NOT NULL DEFAULT '1',
  `password` varchar(32) DEFAULT NULL,
  `reg_time` datetime DEFAULT NULL,
  `nick` varchar(100) NOT NULL DEFAULT '',
  `school` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE  `runtimeinfo` (
  `solution_id` int(11) NOT NULL DEFAULT '0',
  `error` text,
  PRIMARY KEY (`solution_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


insert into privilege values('admin','administrator','N');
 INSERT INTO `problem` (`problem_id`, `title`, `description`, `input`, `output`, `sample_input`, `sample_output`, `spj`, `hint`, `source`, `in_date`, `time_limit`, `memory_limit`, `defunct`,  `accepted`, `submit`, `solved`) VALUES (1000, '送分题-A+B Problem', '<p>Calculate a+b</p>', '<p>Two integer a,b (0&lt;=a,b&lt;=10)</p>', '<p>Output a+b</p>', '1 2', '3', '0', '<p>Q: Where are the input and the output? A: Your program shall always <font color="#ff0000">read input from stdin (Standard Input) and write output to stdout (Standard Output)</font>. For example, you can use ''scanf'' in C or ''cin'' in C++ to read from stdin, and use ''printf'' in C or ''cout'' in C++ to write to stdout. You <font color="#ff0000">shall not output any extra data</font> to standard output other than that required by the problem, otherwise you will get a &quot;Wrong Answer&quot;. User programs are not allowed to open and read from/write to files. You will get a &quot;Runtime Error&quot; or a &quot;Wrong Answer&quot; if you try to do so. Here is a sample solution for problem 1000 using C++/G++:</p>\r\n<pre>\r\n#include &lt;iostream&gt;\r\nusing namespace std;\r\nint  main()\r\n{\r\n    int a,b;\r\n    cin &gt;&gt; a &gt;&gt; b;\r\n    cout &lt;&lt; a+b &lt;&lt; endl;\r\n    return 0;\r\n}</pre>\r\n<p>It''s important that the return type of main() must be int when you use G++/GCC,or you may get compile error. Here is a sample solution for problem 1000 using C/GCC:</p>\r\n<pre>\r\n#include &lt;stdio.h&gt;\r\n\r\nint main()\r\n{\r\n    int a,b;\r\n    scanf(&quot;%d %d&quot;,&amp;a, &amp;b);\r\n    printf(&quot;%d\\n&quot;,a+b);\r\n    return 0;\r\n}</pre>\r\n<p>Here is a sample solution for problem 1000 using PASCAL:</p>\r\n<pre>\r\nprogram p1000(Input,Output); \r\nvar \r\n  a,b:Integer; \r\nbegin \r\n   Readln(a,b); \r\n   Writeln(a+b); \r\nend.</pre>\r\n<p>Here is a sample solution for problem 1000 using JAVA: Now java compiler is jdk 1.5, next is program for 1000</p>\r\n<pre>\r\nimport java.io.*;\r\nimport java.util.*;\r\npublic class Main\r\n{\r\n            public static void main(String args[]) throws Exception\r\n            {\r\n                    Scanner cin=new Scanner(System.in);\r\n                    int a=cin.nextInt();\r\n                    int b=cin.nextInt();\r\n                    System.out.println(a+b);\r\n            }\r\n}</pre>\r\n<p>Old program for jdk 1.4</p>\r\n<pre>\r\nimport java.io.*;\r\nimport java.util.*;\r\n\r\npublic class Main\r\n{\r\n    public static void main (String args[]) throws Exception\r\n    {\r\n        BufferedReader stdin = \r\n            new BufferedReader(\r\n                new InputStreamReader(System.in));\r\n\r\n        String line = stdin.readLine();\r\n        StringTokenizer st = new StringTokenizer(line);\r\n        int a = Integer.parseInt(st.nextToken());\r\n        int b = Integer.parseInt(st.nextToken());\r\n        System.out.println(a+b);\r\n    }\r\n}</pre>', 'POJ', '2012-10-07 18:53:38', 5, 32, 'N', 0, 0, 0); 
