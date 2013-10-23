DROP DATABASE IF EXISTS `weiboapp`;
CREATE DATABASE `weiboapp`
CHARACTER SET 'utf8'
COLLATE 'utf8_general_ci';
USE `weiboapp`;
SET NAMES utf8;
ALTER DATABASE `weiboapp` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `weiboapp`.`userlist`;
CREATE TABLE  `weiboapp`.`userlist` (
uid varchar(12) not null,
sn varchar(50),
sx char(1) DEFAULT 'n', #性别('n'-未知，'m'-男，'f'-女)
vi varchar(300), #VIP认证信息
dr tinyint(1) DEFAULT 0, #是否微博达人（0-不是1-是）
bl varchar(255), #博客地址
de text, #用户自我描述
ad varchar(50), #用户地址
un varchar(20), #用户名
an int DEFAULT 0, #关注数量
fn int DEFAULT 0, #粉丝数量
mn int DEFAULT 0, #微博数量
ci text, #职业信息
ei text, #教育信息
iu varchar(255), #头像URL
iv tinyint(1) DEFAULT 0, #是否VIP（0-不是1-是）
tg varchar(255), #用户标签
rn varchar(10), #用户真实姓名
bd date, #生日
qq varchar(13), #用户QQ
msn varchar(30), #用户MSN
email varchar(90), #用户邮箱
at datetime, #用户创建时间
ti datetime, #爬取时间
fui text, #用户关注人的id列表
last_login datetime, #用户最后一次的登录时间
PRIMARY KEY (`uid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `userlist` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `weiboapp`.`weibomsg`;
CREATE TABLE  `weiboapp`.`weibomsg` (
mid varchar(20) not null,
uid varchar(12) not null,
un varchar(50), #user name	用户名
sn varchar(50), #screen name	用户屏幕名
iu varchar(255), #image url	用户头像URL
rmid varchar(50), #retweet msg id	转发消息ID
mc varchar(300), #message content	微博内容
murl varchar(200), #msg url	微博消息URL
srn varchar(50), #msg source name	微博消息来源
iurl varchar(255), #msg image url	微博消息含图片URL
aurl varchar(255), #msg audio url	微博消息含音频URL
vurl varchar(255), #msg video url	微博消息含视频URL
rc varchar(10), #retweet count	转发数
cc varchar(10), #comment count	评论数
pt datetime, #publish time 发布时间
nc varchar(200), #name card	消息中@到的用户
PRIMARY KEY (`mid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `weibomsg` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `weiboapp`.`outsource`;
CREATE TABLE  `weiboapp`.`outsource` (
osid int(10) unsigned NOT NULL auto_increment,
url varchar(255),
tl varchar(200), #title
ct text, #content
PRIMARY KEY (`osid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `outsource` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `weiboapp`.`category`;
CREATE TABLE  `weiboapp`.`category` (
cgid int(10) unsigned NOT NULL auto_increment,
cgn varchar(20) NOT NULL, #category name
PRIMARY KEY (`cgid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `category` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `weiboapp`.`abbreviation`;
CREATE TABLE  `weiboapp`.`abbreviation` (
abrid int(10) unsigned NOT NULL auto_increment,
kl varchar(50) NOT NULL, #knowledge
cgid int(10) unsigned NOT NULL,
pt datetime, #收入时间
mt datetime, #词条最后修改时间
vt int DEFAULT 0, #浏览次数
st int DEFAULT 0, #分享次数
bk varchar(255), #百科URL
wk varchar(255), #wiki的URL
bf text, #词条的简介
PRIMARY KEY (`abrid`),
FOREIGN KEY(`cgid`) REFERENCES category(`cgid`) on delete cascade on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `abbreviation` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

#词条之间相互关联关系
DROP TABLE IF EXISTS `weiboapp`.`abbre_abbre`;
CREATE TABLE `weiboapp`.`abbre_abbre`(
oabrid int(10) unsigned NOT NULL,
tabrid int(10) unsigned NOT NULL,
PRIMARY KEY(`oabrid`,`tabrid`),
FOREIGN KEY(`oabrid`) REFERENCES abbreviation(`abrid`) on delete cascade on update cascade,
FOREIGN KEY(`tabrid`) REFERENCES abbreviation(`abrid`) on delete cascade on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `abbre_abbre` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

#词条和外部资源间的关联
DROP TABLE IF EXISTS `weiboapp`.`abbre_outs`;
CREATE TABLE `weiboapp`.`abbre_outs`(
osid int(10) unsigned NOT NULL,
abrid int(10) unsigned NOT NULL,
PRIMARY KEY(`osid`,`abrid`),
FOREIGN KEY(`osid`) REFERENCES outsource(`osid`) on delete cascade on update cascade,
FOREIGN KEY(`abrid`) REFERENCES abbreviation(`abrid`) on delete cascade on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `abbre_outs` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `weiboapp`.`abbre_weibomsg`;
CREATE TABLE `weiboapp`.`abbre_weibomsg`(
abrid int(10) unsigned NOT NULL,
mid varchar(20) not null,
PRIMARY KEY (`abrid`,`mid`),
FOREIGN KEY(`abrid`) REFERENCES abbreviation(`abrid`) on delete cascade on update cascade,
FOREIGN KEY(`mid`) REFERENCES weibomsg(`mid`) on delete cascade on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `abbre_weibomsg` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

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