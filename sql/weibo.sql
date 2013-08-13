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
sx tinyint DEFAULT 0, #性别(0-未知，1-男，2-女)
vi varchar(300), #VIP认证信息
dr tinyint DEFAULT 0, #是否微博达人（0-不是1-是）
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
iv tinyint DEFAULT 0, #是否VIP（0-不是1-是）
tg varchar(255), #用户标签
rn varchar(10), #用户真实姓名
bd date, #生日
qq varchar(13), #用户QQ
msn varchar(30), #用户MSN
email varchar(90), #用户邮箱
at datetime, #用户创建时间
ti datetime, #爬取时间
fui text, #用户关注人的id列表
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

DROP TABLE IF EXISTS `weiboapp`.`user_atten`;
CREATE TABLE  `weiboapp`.`atten` (
urid varchar(12) not null, #用户ID
ueid varchar(12) not null, #被关注人
PRIMARY KEY (`urid`,`ueid`),
FOREIGN KEY(`urid`) REFERENCES userlist(`uid`) on delete cascade on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `user_atten` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

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

INSERT INTO `weiboapp`.`userlist` (`uid`, `sn`, `sx`, `vi`, `dr`, `bl`, `de`, `ad`, `un`, `an`, `fn`, `mn`, `ci`, `ei`, `iu`, `iv`, `tg`, `rn`, `bd`, `qq`, `msn`, `email`, `at`, `ti`, `fui`) VALUES ('2100610530', 'tbin-jiayou', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `weiboapp`.`userlist` (`uid`, `sn`, `sx`, `vi`, `dr`, `bl`, `de`, `ad`, `un`, `an`, `fn`, `mn`, `ci`, `ei`, `iu`, `iv`, `tg`, `rn`, `bd`, `qq`, `msn`, `email`, `at`, `ti`, `fui`) VALUES ('1803733977', '刘胜宇', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

INSERT INTO `weiboapp`.`atten` (`urid`, `ueid`) VALUES ('2100610530', '1803733977');
INSERT INTO `weiboapp`.`atten` (`urid`, `ueid`) VALUES ('2100610530', '1831348402');
INSERT INTO `weiboapp`.`atten` (`urid`, `ueid`) VALUES ('2100610530', '1096872440');
INSERT INTO `weiboapp`.`atten` (`urid`, `ueid`) VALUES ('2100610530', '2874453272');
INSERT INTO `weiboapp`.`atten` (`urid`, `ueid`) VALUES ('2100610530', '1096059607');
INSERT INTO `weiboapp`.`atten` (`urid`, `ueid`) VALUES ('2100610530', '1738937441');
INSERT INTO `weiboapp`.`atten` (`urid`, `ueid`) VALUES ('2100610530', '2833534593');
INSERT INTO `weiboapp`.`atten` (`urid`, `ueid`) VALUES ('2100610530', '2609397091');
INSERT INTO `weiboapp`.`atten` (`urid`, `ueid`) VALUES ('2100610530', '1733984585');

INSERT INTO `weiboapp`.`category` (`cgid`, `cgn`) VALUES (NULL, '算法');
INSERT INTO `weiboapp`.`category` (`cgid`, `cgn`) VALUES (NULL, '会议');

INSERT INTO `weiboapp`.`abbreviation` (`abrid`, `kl`, `cgid`, `pt`, `vt`, `st`, `bk`, `wk`, `bf`) VALUES (NULL, '自然语言处理', '1', '2013/05/07', '20', '45', 'http://baike.baidu.cn/view/18784.htm', 'http://zh.wikipedia.org/zh-cn/%E8%87%AA%E7%84%B6%E8%AF%AD%E8%A8%80%E5%A4%84%E7%90%86', '自然语言处理（英语：Natural Language Processing，简称NLP）是人工智能和语言学领域的分支学科。在这此领域中探讨如何处理及运用自然语言；自然语言认知则是指让电脑“懂”人类的语言。');
INSERT INTO `weiboapp`.`abbreviation` (`abrid`, `kl`, `cgid`, `pt`, `vt`, `st`, `bk`, `wk`, `bf`) VALUES (NULL, 'NLP', '1', '2013/05/07', '20', '45', 'http://baike.baidu.cn/view/18784.htm', 'http://zh.wikipedia.org/zh-cn/%E8%87%AA%E7%84%B6%E8%AF%AD%E8%A8%80%E5%A4%84%E7%90%86', '自然语言处理（英语：Natural Language Processing，简称NLP）是人工智能和语言学领域的分支学科。在这此领域中探讨如何处理及运用自然语言；自然语言认知则是指让电脑“懂”人类的语言。');
INSERT INTO `weiboapp`.`abbreviation` (`abrid`, `kl`, `cgid`, `pt`, `vt`, `st`, `bk`, `wk`, `bf`) VALUES (NULL, '机器学习', '2', '2013/05/07', '20', '45', 'http://baike.baidu.cn/view/7956.htm', 'http://zh.wikipedia.org/wiki/%E6%9C%BA%E5%99%A8%E5%AD%A6%E4%B9%A0', '机器学习(Machine Learning)是一门多领域交叉学科，涉及概率论、统计学、逼近论、凸分析、算法复杂度理论等多门学科。专门研究计算机怎样模拟或实现人类的学习行为，以获取新的知识或技能，重新组织已有的知识结构使之不断改善自身的性能。');
INSERT INTO `weiboapp`.`abbreviation` (`abrid`, `kl`, `cgid`, `pt`, `vt`, `st`, `bk`, `wk`, `bf`) VALUES (NULL, 'Machine Learning', '2', '2013/05/07', '20', '45', 'http://baike.baidu.cn/view/7956.htm', 'http://zh.wikipedia.org/wiki/%E6%9C%BA%E5%99%A8%E5%AD%A6%E4%B9%A0', '机器学习(Machine Learning)是一门多领域交叉学科，涉及概率论、统计学、逼近论、凸分析、算法复杂度理论等多门学科。专门研究计算机怎样模拟或实现人类的学习行为，以获取新的知识或技能，重新组织已有的知识结构使之不断改善自身的性能。');
INSERT INTO `weiboapp`.`abbreviation` (`abrid`, `kl`, `cgid`, `pt`, `vt`, `st`, `bk`, `wk`, `bf`) VALUES (NULL, '人工智能', '1', '2013/05/07', '20', '45', 'http://baike.baidu.cn/view/2949.htm', 'http://zh.wikipedia.org/wiki/%E4%BA%BA%E5%B7%A5%E6%99%BA%E8%83%BD', '人工智能(Artificial Intelligence) ，英文缩写为AI。它是研究、开发用于模拟、延伸和扩展人的智能的理论、方法、技术及应用系统的一门新的技术科学。 人工智能是计算机科学的一个分支，它企图了解智能的实质，并生产出一种新的能以人类智能相似的方式做出反应的智能机器。');
INSERT INTO `weiboapp`.`abbreviation` (`abrid`, `kl`, `cgid`, `pt`, `vt`, `st`, `bk`, `wk`, `bf`) VALUES (NULL, 'AI', '1', '2013/05/07', '20', '45', 'http://baike.baidu.cn/view/2949.htm', 'http://zh.wikipedia.org/wiki/%E4%BA%BA%E5%B7%A5%E6%99%BA%E8%83%BD', '人工智能(Artificial Intelligence) ，英文缩写为AI。它是研究、开发用于模拟、延伸和扩展人的智能的理论、方法、技术及应用系统的一门新的技术科学。 人工智能是计算机科学的一个分支，它企图了解智能的实质，并生产出一种新的能以人类智能相似的方式做出反应的智能机器。');
INSERT INTO `weiboapp`.`abbreviation` (`abrid`, `kl`, `cgid`, `pt`, `vt`, `st`, `bk`, `wk`, `bf`) VALUES (NULL, '隐马尔科夫模型', '2', '2013/05/07', '20', '45', 'http://baike.baidu.cn/view/3412654.htm', 'http://zh.wikipedia.org/wiki/%E9%9A%90%E9%A9%AC%E5%B0%94%E5%8F%AF%E5%A4%AB%E6%A8%A1%E5%9E%8B', '隐马尔可夫模型（Hidden Markov Model，HMM）是统计模型，它用来描述一个含有隐含未知参数的马尔可夫过程。其难点是从可观察的参数中确定该过程的隐含参数。然后利用这些参数来作进一步的分析，例如模式识别。');
INSERT INTO `weiboapp`.`abbreviation` (`abrid`, `kl`, `cgid`, `pt`, `vt`, `st`, `bk`, `wk`, `bf`) VALUES (NULL, 'HMM', '2', '2013/05/07', '20', '45', 'http://baike.baidu.cn/view/3412654.htm', 'http://zh.wikipedia.org/wiki/%E9%9A%90%E9%A9%AC%E5%B0%94%E5%8F%AF%E5%A4%AB%E6%A8%A1%E5%9E%8B', '隐马尔可夫模型（Hidden Markov Model，HMM）是统计模型，它用来描述一个含有隐含未知参数的马尔可夫过程。其难点是从可观察的参数中确定该过程的隐含参数。然后利用这些参数来作进一步的分析，例如模式识别。');

INSERT INTO `weiboapp`.`outsource` (`osid`, `url`, `tl`, `ct`) VALUES (NULL, 'http://zh.wikipedia.org/zh-cn/%E8%87%AA%E7%84%B6%E8%AF%AD%E8%A8%80%E5%A4%84%E7%90%86', '自然语言处理', '自然语言处理（英语：Natural Language Processing，简称NLP）是人工智能和语言学领域的分支学科。在这此领域中探讨如何处理及运用自然语言；自然语言认知则是指让电脑“懂”人类的语言。');
INSERT INTO `weiboapp`.`outsource` (`osid`, `url`, `tl`, `ct`) VALUES (NULL, 'http://baike.baidu.cn/view/18784.htm', '自然语言处理', '自然语言处理是计算机科学领域与人工智能领域中的一个重要方向。它研究能实现人与计算机之间用自然语言进行有效通信的各种理论和方法。自然语言处理是一门融语言学、计算机科学、数学于一体的科学。');
INSERT INTO `weiboapp`.`outsource` (`osid`, `url`, `tl`, `ct`) VALUES (NULL, 'http://zh.wikipedia.org/wiki/%E6%9C%BA%E5%99%A8%E5%AD%A6%E4%B9%A0', '机器学习', '机器学习是近20多年兴起的一门多领域交叉学科，涉及概率论、统计学、逼近论、凸分析、算法复杂度理论等多门学科。机器学习理论主要是设计和分析一些让计算机可以自动“学习”的算法。机器学习算法是一类从数据中自动分析获得规律，并利用规律对未知数据进行预测的算法。');
INSERT INTO `weiboapp`.`outsource` (`osid`, `url`, `tl`, `ct`) VALUES (NULL, 'http://baike.baidu.cn/view/7956.htm', '机器学习', '机器学习(Machine Learning)是一门多领域交叉学科，涉及概率论、统计学、逼近论、凸分析、算法复杂度理论等多门学科。专门研究计算机怎样模拟或实现人类的学习行为，以获取新的知识或技能，重新组织已有的知识结构使之不断改善自身的性能。');
INSERT INTO `weiboapp`.`outsource` (`osid`, `url`, `tl`, `ct`) VALUES (NULL, 'http://zh.wikipedia.org/wiki/%E4%BA%BA%E5%B7%A5%E6%99%BA%E8%83%BD', '人工智能', '人工智能（英语：Artificial Intelligence, AI）有时也称作机器智能，是指由人工制造出来的系统所表现出来的智能。通常人工智能是指通过普通计算机实现的智能。该词同时也指研究这样的智能系统是否能够实现，以及如何实现的科学领域。');
INSERT INTO `weiboapp`.`outsource` (`osid`, `url`, `tl`, `ct`) VALUES (NULL, 'http://baike.baidu.cn/view/2949.htm', '人工智能', '人工智能(Artificial Intelligence) ，英文缩写为AI。它是研究、开发用于模拟、延伸和扩展人的智能的理论、方法、技术及应用系统的一门新的技术科学。 人工智能是计算机科学的一个分支，它企图了解智能的实质，并生产出一种新的能以人类智能相似的方式做出反应的智能机器。');
INSERT INTO `weiboapp`.`outsource` (`osid`, `url`, `tl`, `ct`) VALUES (NULL, 'http://zh.wikipedia.org/wiki/%E9%9A%90%E9%A9%AC%E5%B0%94%E5%8F%AF%E5%A4%AB%E6%A8%A1%E5%9E%8B', '隐马尔可夫模型', '隐马尔可夫模型（Hidden Markov Model，HMM）是统计模型，它用来描述一个含有隐含未知参数的马尔可夫过程。其难点是从可观察的参数中确定该过程的隐含参数。然后利用这些参数来作进一步的分析，例如模式识别。');
INSERT INTO `weiboapp`.`outsource` (`osid`, `url`, `tl`, `ct`) VALUES (NULL, 'http://baike.baidu.cn/view/3412654.htm', '隐式马尔科夫模型', '隐马尔可夫模型（Hidden Markov models，HMM）是马尔可夫链的一种，它的状态不能直接观察到，但能通过观测向量序列观察到，每个观测向量都是通过某些概率密度分布表现为各种状态，每一个观测向量是由一个具有相应概率密度分布的状态序列产生。');

INSERT INTO `weiboapp`.`abbre_abbre` (`oabrid`, `tabrid`) VALUES ('1', '2');
INSERT INTO `weiboapp`.`abbre_abbre` (`oabrid`, `tabrid`) VALUES ('3', '4');
INSERT INTO `weiboapp`.`abbre_abbre` (`oabrid`, `tabrid`) VALUES ('5', '6');
INSERT INTO `weiboapp`.`abbre_abbre` (`oabrid`, `tabrid`) VALUES ('7', '8');

INSERT INTO `weiboapp`.`abbre_outs` (`osid`, `abrid`) VALUES ('1', '1');
INSERT INTO `weiboapp`.`abbre_outs` (`osid`, `abrid`) VALUES ('1', '2');
INSERT INTO `weiboapp`.`abbre_outs` (`osid`, `abrid`) VALUES ('2', '1');
INSERT INTO `weiboapp`.`abbre_outs` (`osid`, `abrid`) VALUES ('2', '2');
INSERT INTO `weiboapp`.`abbre_outs` (`osid`, `abrid`) VALUES ('3', '3');
INSERT INTO `weiboapp`.`abbre_outs` (`osid`, `abrid`) VALUES ('3', '4');
INSERT INTO `weiboapp`.`abbre_outs` (`osid`, `abrid`) VALUES ('4', '3');
INSERT INTO `weiboapp`.`abbre_outs` (`osid`, `abrid`) VALUES ('4', '4');
INSERT INTO `weiboapp`.`abbre_outs` (`osid`, `abrid`) VALUES ('5', '5');
INSERT INTO `weiboapp`.`abbre_outs` (`osid`, `abrid`) VALUES ('5', '6');
INSERT INTO `weiboapp`.`abbre_outs` (`osid`, `abrid`) VALUES ('6', '5');
INSERT INTO `weiboapp`.`abbre_outs` (`osid`, `abrid`) VALUES ('6', '6');
INSERT INTO `weiboapp`.`abbre_outs` (`osid`, `abrid`) VALUES ('7', '7');
INSERT INTO `weiboapp`.`abbre_outs` (`osid`, `abrid`) VALUES ('7', '8');
INSERT INTO `weiboapp`.`abbre_outs` (`osid`, `abrid`) VALUES ('8', '7');
INSERT INTO `weiboapp`.`abbre_outs` (`osid`, `abrid`) VALUES ('8', '8');

INSERT INTO `weiboapp`.`weibomsg` (`mid`, `uid`, `un`, `sn`, `iu`, `rmid`, `mc`, `murl`, `srn`, `iurl`, `aurl`, `vurl`, `rc`, `cc`, `pt`, `nc`) VALUES ('3574025739106810', '1590776853', NULL, 'Karen上善若水', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '介绍一下许心馨老师：波士顿大学MBA, NLP高级培训师，十多年来主要在500强从事高层辅导(Executive Coach)和管理培训课程，曾旅居20多个国家的美籍华人http://t.cn/zTlC4o6 老师从事身心灵探索多年，凝聚高层领导力辅导的经验和智慧，以花精疗愈体系为载体，为人间输送充满慈悲和大爱的正能量。', 'http://t.cn/zTlC4o6', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/5ed15415gw1e4bk8llp3cj20k00f0wjo.jpg', NULL, NULL, '5', '5', '5月4日00:13', NULL);
INSERT INTO `weiboapp`.`weibomsg` (`mid`, `uid`, `un`, `sn`, `iu`, `rmid`, `mc`, `murl`, `srn`, `iurl`, `aurl`, `vurl`, `rc`, `cc`, `pt`, `nc`) VALUES ('3570174365911254', '1803733977', NULL, '刘胜宇', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '首都不适合生活呀//@张栋_机器学习: 我转了一下，已经几个工程师告诉我准备离开北京了; 开复再转发，估计会有更多人思考：离开，还是留下？//@李开复: 有勇气追随你的心！ //@张栋_机器学习:转发,花无影,朋友们，我要离开北京啦！ 工作已辞啦，房子已卖啦！ 别以为我疯了，因为我从没正常过。 下一站，西安！http://t.cn/zTI9C3O', 'http://t.cn/zTI9C3O', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/4b8bd145jw1e3yur1875hj20o70jg759.jpg', NULL, NULL, '5', '5', '今天 09:09', NULL);
INSERT INTO `weiboapp`.`weibomsg` (`mid`, `uid`, `un`, `sn`, `iu`, `rmid`, `mc`, `murl`, `srn`, `iurl`, `aurl`, `vurl`, `rc`, `cc`, `pt`, `nc`) VALUES ('3569628326618641', '2100610530', NULL, 'tbin-jiayou', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '@ICTCLAS张华平博士:同感，我这个非新闻的理工科几乎同时发布了这个想法。新闻的僵化可见一斑。思想的保守才是真正的悲哀,张力奋,七点央视新闻联播，头条消息居然不是雅安地震赈灾，而是清华大学一奖学金启动仪式! 实在匪夷所思! 是因为习主席、奥巴马总统为奖学金写了贺信吗? 中国的记者编辑怎么做? 新闻学又怎么教?', NULL, '新浪微博', 'http://ww4.sinaimg.cn/bmiddle/68434a35jw1e3xgc29jm4j218g0xcwli.jpg', NULL, NULL, '5', '5', '4月21日 20:59', NULL);
INSERT INTO `weiboapp`.`weibomsg` (`mid`, `uid`, `un`, `sn`, `iu`, `rmid`, `mc`, `murl`, `srn`, `iurl`, `aurl`, `vurl`, `rc`, `cc`, `pt`, `nc`) VALUES ('3574025539106810', '1590776853', NULL, 'Karen上善若水', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '介绍一下许心馨老师：波士顿大学MBA, NLP高级培训师，十多年来主要在500强从事高层辅导(Executive Coach)和管理培训课程，曾旅居20多个国家的美籍华人http://t.cn/zTlC4o6 老师从事身心灵探索多年，凝聚高层领导力辅导的经验和智慧，以花精疗愈体系为载体，为人间输送充满慈悲和大爱的正能量。', 'http://t.cn/zTlC4o6', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/5ed15415gw1e4bk8llp3cj20k00f0wjo.jpg', NULL, NULL, '5', '5', '5月4日00:13', NULL);
INSERT INTO `weiboapp`.`weibomsg` (`mid`, `uid`, `un`, `sn`, `iu`, `rmid`, `mc`, `murl`, `srn`, `iurl`, `aurl`, `vurl`, `rc`, `cc`, `pt`, `nc`) VALUES ('3570174465911254', '1803733977', NULL, '刘胜宇', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '首都不适合生活呀//@张栋_机器学习: 我转了一下，已经几个工程师告诉我准备离开北京了; 开复再转发，估计会有更多人思考：离开，还是留下？//@李开复: 有勇气追随你的心！ //@张栋_机器学习:转发,花无影,朋友们，我要离开北京啦！ 工作已辞啦，房子已卖啦！ 别以为我疯了，因为我从没正常过。 下一站，西安！http://t.cn/zTI9C3O', 'http://t.cn/zTI9C3O', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/4b8bd145jw1e3yur1875hj20o70jg759.jpg', NULL, NULL, '5', '5', '今天 09:09', NULL);
INSERT INTO `weiboapp`.`weibomsg` (`mid`, `uid`, `un`, `sn`, `iu`, `rmid`, `mc`, `murl`, `srn`, `iurl`, `aurl`, `vurl`, `rc`, `cc`, `pt`, `nc`) VALUES ('3569623326618641', '2100610530', NULL, 'tbin-jiayou', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '@ICTCLAS张华平博士:同感，我这个非新闻的理工科几乎同时发布了这个想法。新闻的僵化可见一斑。思想的保守才是真正的悲哀,张力奋,七点央视新闻联播，头条消息居然不是雅安地震赈灾，而是清华大学一奖学金启动仪式! 实在匪夷所思! 是因为习主席、奥巴马总统为奖学金写了贺信吗? 中国的记者编辑怎么做? 新闻学又怎么教?', NULL, '新浪微博', 'http://ww4.sinaimg.cn/bmiddle/68434a35jw1e3xgc29jm4j218g0xcwli.jpg', NULL, NULL, '5', '5', '4月21日 20:59', NULL);
INSERT INTO `weiboapp`.`weibomsg` (`mid`, `uid`, `un`, `sn`, `iu`, `rmid`, `mc`, `murl`, `srn`, `iurl`, `aurl`, `vurl`, `rc`, `cc`, `pt`, `nc`) VALUES ('3574025839106810', '1590776853', NULL, 'Karen上善若水', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '介绍一下许心馨老师：波士顿大学MBA, NLP高级培训师，十多年来主要在500强从事高层辅导(Executive Coach)和管理培训课程，曾旅居20多个国家的美籍华人http://t.cn/zTlC4o6 老师从事身心灵探索多年，凝聚高层领导力辅导的经验和智慧，以花精疗愈体系为载体，为人间输送充满慈悲和大爱的正能量。', 'http://t.cn/zTlC4o6', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/5ed15415gw1e4bk8llp3cj20k00f0wjo.jpg', NULL, NULL, '5', '5', '5月4日00:13', NULL);
INSERT INTO `weiboapp`.`weibomsg` (`mid`, `uid`, `un`, `sn`, `iu`, `rmid`, `mc`, `murl`, `srn`, `iurl`, `aurl`, `vurl`, `rc`, `cc`, `pt`, `nc`) VALUES ('3570174765911254', '1803733977', NULL, '刘胜宇', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '首都不适合生活呀//@张栋_机器学习: 我转了一下，已经几个工程师告诉我准备离开北京了; 开复再转发，估计会有更多人思考：离开，还是留下？//@李开复: 有勇气追随你的心！ //@张栋_机器学习:转发,花无影,朋友们，我要离开北京啦！ 工作已辞啦，房子已卖啦！ 别以为我疯了，因为我从没正常过。 下一站，西安！http://t.cn/zTI9C3O', 'http://t.cn/zTI9C3O', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/4b8bd145jw1e3yur1875hj20o70jg759.jpg', NULL, NULL, '5', '5', '今天 09:09', NULL);
INSERT INTO `weiboapp`.`weibomsg` (`mid`, `uid`, `un`, `sn`, `iu`, `rmid`, `mc`, `murl`, `srn`, `iurl`, `aurl`, `vurl`, `rc`, `cc`, `pt`, `nc`) VALUES ('3569628346618641', '2100610530', NULL, 'tbin-jiayou', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '@ICTCLAS张华平博士:同感，我这个非新闻的理工科几乎同时发布了这个想法。新闻的僵化可见一斑。思想的保守才是真正的悲哀,张力奋,七点央视新闻联播，头条消息居然不是雅安地震赈灾，而是清华大学一奖学金启动仪式! 实在匪夷所思! 是因为习主席、奥巴马总统为奖学金写了贺信吗? 中国的记者编辑怎么做? 新闻学又怎么教?', NULL, '新浪微博', 'http://ww4.sinaimg.cn/bmiddle/68434a35jw1e3xgc29jm4j218g0xcwli.jpg', NULL, NULL, '5', '5', '4月21日 20:59', NULL);
INSERT INTO `weiboapp`.`weibomsg` (`mid`, `uid`, `un`, `sn`, `iu`, `rmid`, `mc`, `murl`, `srn`, `iurl`, `aurl`, `vurl`, `rc`, `cc`, `pt`, `nc`) VALUES ('3574025779106810', '1590776853', NULL, 'Karen上善若水', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '介绍一下许心馨老师：波士顿大学MBA, NLP高级培训师，十多年来主要在500强从事高层辅导(Executive Coach)和管理培训课程，曾旅居20多个国家的美籍华人http://t.cn/zTlC4o6 老师从事身心灵探索多年，凝聚高层领导力辅导的经验和智慧，以花精疗愈体系为载体，为人间输送充满慈悲和大爱的正能量。', 'http://t.cn/zTlC4o6', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/5ed15415gw1e4bk8llp3cj20k00f0wjo.jpg', NULL, NULL, '5', '5', '5月4日00:13', NULL);
INSERT INTO `weiboapp`.`weibomsg` (`mid`, `uid`, `un`, `sn`, `iu`, `rmid`, `mc`, `murl`, `srn`, `iurl`, `aurl`, `vurl`, `rc`, `cc`, `pt`, `nc`) VALUES ('3570174355911254', '1803733977', NULL, '刘胜宇', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '首都不适合生活呀//@张栋_机器学习: 我转了一下，已经几个工程师告诉我准备离开北京了; 开复再转发，估计会有更多人思考：离开，还是留下？//@李开复: 有勇气追随你的心！ //@张栋_机器学习:转发,花无影,朋友们，我要离开北京啦！ 工作已辞啦，房子已卖啦！ 别以为我疯了，因为我从没正常过。 下一站，西安！http://t.cn/zTI9C3O', 'http://t.cn/zTI9C3O', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/4b8bd145jw1e3yur1875hj20o70jg759.jpg', NULL, NULL, '5', '5', '今天 09:09', NULL);
INSERT INTO `weiboapp`.`weibomsg` (`mid`, `uid`, `un`, `sn`, `iu`, `rmid`, `mc`, `murl`, `srn`, `iurl`, `aurl`, `vurl`, `rc`, `cc`, `pt`, `nc`) VALUES ('3570174265911254', '1803733977', NULL, '刘胜宇', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '首都不适合生活呀//@张栋_机器学习: 我转了一下，已经几个工程师告诉我准备离开北京了; 开复再转发，估计会有更多人思考：离开，还是留下？//@李开复: 有勇气追随你的心！ //@张栋_机器学习:转发,花无影,朋友们，我要离开北京啦！ 工作已辞啦，房子已卖啦！ 别以为我疯了，因为我从没正常过。 下一站，西安！http://t.cn/zTI9C3O', 'http://t.cn/zTI9C3O', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/4b8bd145jw1e3yur1875hj20o70jg759.jpg', NULL, NULL, '5', '5', '今天 09:09', NULL);
INSERT INTO `weiboapp`.`weibomsg` (`mid`, `uid`, `un`, `sn`, `iu`, `rmid`, `mc`, `murl`, `srn`, `iurl`, `aurl`, `vurl`, `rc`, `cc`, `pt`, `nc`) VALUES ('3569628526618641', '2100610530', NULL, 'tbin-jiayou', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '@ICTCLAS张华平博士:同感，我这个非新闻的理工科几乎同时发布了这个想法。新闻的僵化可见一斑。思想的保守才是真正的悲哀,张力奋,七点央视新闻联播，头条消息居然不是雅安地震赈灾，而是清华大学一奖学金启动仪式! 实在匪夷所思! 是因为习主席、奥巴马总统为奖学金写了贺信吗? 中国的记者编辑怎么做? 新闻学又怎么教?', NULL, '新浪微博', 'http://ww4.sinaimg.cn/bmiddle/68434a35jw1e3xgc29jm4j218g0xcwli.jpg', NULL, NULL, '5', '5', '4月21日 20:59', NULL);
INSERT INTO `weiboapp`.`weibomsg` (`mid`, `uid`, `un`, `sn`, `iu`, `rmid`, `mc`, `murl`, `srn`, `iurl`, `aurl`, `vurl`, `rc`, `cc`, `pt`, `nc`) VALUES ('3574025139106810', '1590776853', NULL, 'Karen上善若水', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '介绍一下许心馨老师：波士顿大学MBA, NLP高级培训师，十多年来主要在500强从事高层辅导(Executive Coach)和管理培训课程，曾旅居20多个国家的美籍华人http://t.cn/zTlC4o6 老师从事身心灵探索多年，凝聚高层领导力辅导的经验和智慧，以花精疗愈体系为载体，为人间输送充满慈悲和大爱的正能量。', 'http://t.cn/zTlC4o6', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/5ed15415gw1e4bk8llp3cj20k00f0wjo.jpg', NULL, NULL, '5', '5', '5月4日00:13', NULL);
INSERT INTO `weiboapp`.`weibomsg` (`mid`, `uid`, `un`, `sn`, `iu`, `rmid`, `mc`, `murl`, `srn`, `iurl`, `aurl`, `vurl`, `rc`, `cc`, `pt`, `nc`) VALUES ('3570174765210254', '1803733977', NULL, '刘胜宇', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '首都不适合生活呀//@张栋_机器学习: 我转了一下，已经几个工程师告诉我准备离开北京了; 开复再转发，估计会有更多人思考：离开，还是留下？//@李开复: 有勇气追随你的心！ //@张栋_机器学习:转发,花无影,朋友们，我要离开北京啦！ 工作已辞啦，房子已卖啦！ 别以为我疯了，因为我从没正常过。 下一站，西安！http://t.cn/zTI9C3O', 'http://t.cn/zTI9C3O', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/4b8bd145jw1e3yur1875hj20o70jg759.jpg', NULL, NULL, '5', '5', '今天 09:09', NULL);
INSERT INTO `weiboapp`.`weibomsg` (`mid`, `uid`, `un`, `sn`, `iu`, `rmid`, `mc`, `murl`, `srn`, `iurl`, `aurl`, `vurl`, `rc`, `cc`, `pt`, `nc`) VALUES ('3570174365912254', '2100610530', NULL, 'tbin-jiayou', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '@ICTCLAS张华平博士:同感，我这个非新闻的理工科几乎同时发布了这个想法。新闻的僵化可见一斑。思想的保守才是真正的悲哀,张力奋,七点央视新闻联播，头条消息居然不是雅安地震赈灾，而是清华大学一奖学金启动仪式! 实在匪夷所思! 是因为习主席、奥巴马总统为奖学金写了贺信吗? 中国的记者编辑怎么做? 新闻学又怎么教?', NULL, '新浪微博', 'http://ww4.sinaimg.cn/bmiddle/68434a35jw1e3xgc29jm4j218g0xcwli.jpg', NULL, NULL, '5', '5', '4月21日 20:59', NULL);

INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('1', '3574025739106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('1', '3570174365911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('1', '3569628326618641');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('1', '3574025539106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('1', '3570174465911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('1', '3570174365912254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('1', '3574025779106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('1', '3570174765911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('2', '3574025739106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('2', '3570174365911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('2', '3569628326618641');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('2', '3574025539106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('2', '3570174465911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('2', '3570174365912254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('2', '3574025779106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('2', '3570174765911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('3', '3570174365911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('3', '3569628326618641');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('3', '3570174465911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('3', '3570174365912254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('3', '3574025779106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('3', '3574025739106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('3', '3574025539106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('3', '3570174765911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('4', '3570174365911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('4', '3569628326618641');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('4', '3570174465911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('4', '3570174365912254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('4', '3574025779106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('4', '3574025739106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('4', '3574025539106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('4', '3570174765911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('5', '3570174365911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('5', '3569628326618641');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('5', '3570174465911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('5', '3570174365912254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('5', '3574025779106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('5', '3574025739106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('5', '3570174765911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('6', '3570174365911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('6', '3569628326618641');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('6', '3574025539106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('6', '3570174465911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('6', '3570174365912254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('6', '3574025779106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('6', '3574025739106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('6', '3570174765911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('7', '3570174365911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('7', '3569628326618641');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('7', '3570174465911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('7', '3570174365912254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('7', '3574025779106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('7', '3574025739106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('7', '3574025539106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('7', '3570174765911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('8', '3570174365911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('8', '3569628326618641');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('8', '3570174465911254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('8', '3570174365912254');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('8', '3574025779106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('8', '3574025739106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('8', '3574025539106810');
INSERT INTO `weiboapp`.`abbre_weibomsg` (`abrid`, `mid`) VALUES ('8', '3570174765911254');