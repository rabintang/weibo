# 增加管理员表,以及系统参数表

# 管理员用户表
DROP TABLE IF EXISTS `weiboapp`.`admin`;
CREATE TABLE  `weiboapp`.`admin` (
	aid int(5) unsigned NOT NULL auto_increment COMMENT '自增主键',
	adminname varchar(20) NOT NULL COMMENT '管理员用户名称',
	password varchar(55) NOT NULL COMMENT '管理员用户密码',
	lastlogin datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次登录时间',
	PRIMARY KEY (`aid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `weiboapp`.`admin` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

# 系统参数表
DROP TABLE IF EXISTS `weiboapp`.`parameter`;
CREATE TABLE  `weiboapp`.`parameter` (
	pid int(10) unsigned NOT NULL auto_increment COMMENT '自增主键',
	pname varchar(20) NOT NULL COMMENT '参数名称',
	pvalue varchar(50) NOT NULL DEFAULT '' COMMENT '参数值',
	ptype int(5) NOT NULL DEFAULT 0 COMMENT '参数类型',
	descption varchar(255) COMMENT '参数描述',
	addtime datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
	PRIMARY KEY (`pid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `weiboapp`.`parameter` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

# 系统参数类型表
DROP TABLE IF EXISTS `weiboapp`.`paramtype`;
CREATE TABLE  `weiboapp`.`paramtype` (
	ptid int(10) unsigned NOT NULL auto_increment COMMENT '自增主键',
	ptname varchar(20) NOT NULL COMMENT '参数类型名称',
	descption varchar(255) COMMENT '参数类型描述',
	addtime datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
	PRIMARY KEY (`ptid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `weiboapp`.`paramtype` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

# 插入管理员
INSERT INTO `weiboapp`.`admin` (`adminname`,`password`) VALUES ('admin', 'hiticrcweibo');