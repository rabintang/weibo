ALTER TABLE `userlist` ADD last_login datetime; #用户最后一次的登录时间

# 记录用户查看过的词条
DROP TABLE IF EXISTS `weiboapp`.`user_abbre`;
CREATE TABLE  `weiboapp`.`user_abbre` (
	ua_id bigint(20) unsigned NOT NULL auto_increment COMMENT '自增主键',
	uid varchar(20) NOT NULL COMMENT '用户ID',
	abrid int(10) NOT NULL COMMENT '词条ID',
	view_time datetime NOT NULL COMMENT '最后浏览时间',
	view_count int(10) NOT NULL DEFAULT 0 COMMENT '浏览次数',
	PRIMARY KEY (`ua_id`),
	UNIQUE KEY `ua_item` (`uid`, `abrid`),
	KEY `uid` (`uid`),
	KEY `abrid` (`abrid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `weiboapp`.`user_abbre` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

# 搜索栏的历史记录
DROP TABLE IF EXISTS `weiboapp`.`search_log`;
CREATE TABLE  `weiboapp`.`search_log` (
	sl_id int(10) unsigned NOT NULL auto_increment COMMENT '自增主键',
	uid varchar(20) NOT NULL COMMENT '用户ID',
	keyword varchar(50) NOT NULL COMMENT '搜索关键词',
	search_time datetime NOT NULL COMMENT '搜索时间',
	PRIMARY KEY (`sl_id`),
	KEY `uid` (`uid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `weiboapp`.`search_log` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

# 针对每个用户系统对词条的评分
DROP TABLE IF EXISTS `weiboapp`.`abbre_score`;
CREATE TABLE  `weiboapp`.`abbre_score` (
	as_id bigint(20) unsigned NOT NULL auto_increment COMMENT '自增主键',
	uid varchar(20) NOT NULL COMMENT '用户ID',
	abrid int(10) NOT NULL COMMENT '词条ID',
	score int(10) NOT NULL DEFAULT 1000 COMMENT '系统打分值',
	modify_time datetime NOT NULL COMMENT '修改时间',
	PRIMARY KEY (`as_id`),
	UNIQUE KEY `as_item` (`uid`, `abrid`),
	KEY `uid` (`uid`),
	KEY `abrid` (`abrid`),
	KEY `time` (`modify_time`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `weiboapp`.`abbre_score` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

