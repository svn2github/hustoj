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
)
 ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;;
