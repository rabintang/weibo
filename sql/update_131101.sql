# 添加了用户行为日志记录,并删除搜索表

DROP TABLE IF EXISTS `weiboapp`.`search_log`;


DROP TABLE IF EXISTS `weiboapp`.`user_log`;
CREATE TABLE  `weiboapp`.`user_log` (
	ulid bigint(20) unsigned NOT NULL auto_increment COMMENT '自增主键',
	uid varchar(20) NOT NULL COMMENT '用户ID',
	ip varchar(15) NOT NULL DEFAULT '0.0.0.0' COMMENT '用户IP地址',
	useragent varchar(255) COMMENT '用户浏览器Agent信息',
	actiontime datetime NOT NULL DEFAULT '0000:00:00 00:00:00' COMMENT '浏览时间',
	url varchar(255) NOT NULL DEFAULT '' COMMENT '浏览的网址',
	postdata varchar(255) COMMENT 'post数据,格式为 key:value#...,并对#转义',
	PRIMARY KEY (`ul_id`),
	KEY `uid` (`uid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `weiboapp`.`user_log` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;