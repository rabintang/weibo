# 增加了用于推荐的数据结构

# 推荐算法表
DROP TABLE IF EXISTS `weiboapp`.`recalgo`;
CREATE TABLE  `weiboapp`.`recalgo` (
	rlid int(10) unsigned NOT NULL auto_increment COMMENT '自增主键',
	name varchar(20) NOT NULL COMMENT '算法名称',
	desc text COMMENT '算法描述',
	time datetime DEFAULT '0000-00-00 00:00:00' COMMENT '算法实现时间',
	PRIMARY KEY (`rlid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `weiboapp`.`recalgo` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

# 推荐项目表
DROP TABLE IF EXISTS `weiboapp`.`recommd`;
CREATE TABLE  `weiboapp`.`recommd` (
	rid bigint(20) unsigned NOT NULL auto_increment COMMENT '自增主键',
	abrid int(10) unsigned NOT NULL COMMENT '推荐的词条ID',
	uid varchar(12) NOT NULL COMMENT '推荐的用户ID',
	reason text COMMENT '推荐理由',
	scount int(5) DEFAULT 0 COMMENT '展示数',
	ccount int(5) DEFAULT 0 COMMENT '点击数',
	gtime datetime DEFAULT '0000-00-00 00:00:00' COMMENT '生成时间',
	rlid int(10) unsigned NOT NULL COMMENT '所属推荐算法',
	PRIMARY KEY (`rid`),
	KEY `uid` (`uid`),
	KEY `rlid` (`rlid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `weiboapp`.`recommd` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;