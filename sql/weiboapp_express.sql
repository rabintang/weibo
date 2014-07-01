-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 30, 2013 at 08:56 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.6-1ubuntu1.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `weiboapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `abbreviation`
--

CREATE TABLE IF NOT EXISTS `abbreviation` (
  `abrid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kl` varchar(50) NOT NULL,
  `cgid` int(10) unsigned NOT NULL,
  `pt` datetime DEFAULT NULL,
  `vt` int(11) DEFAULT '0',
  `st` int(11) DEFAULT '0',
  `bk` varchar(255) DEFAULT NULL,
  `wk` varchar(255) DEFAULT NULL,
  `bf` text,
  `mt` datetime DEFAULT NULL,
  PRIMARY KEY (`abrid`),
  KEY `cgid` (`cgid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `abbreviation`
--

INSERT INTO `abbreviation` (`abrid`, `kl`, `cgid`, `pt`, `vt`, `st`, `bk`, `wk`, `bf`, `mt`) VALUES
(1, '自然语言处理', 1, '2013-05-07 00:00:00', 20, 45, 'http://baike.baidu.com/view/18784.htm', 'http://zh.wikipedia.org/zh-cn/%D7%D4%C8%BB%D3%EF%D1%D4%B4%A6%C0%ED', '自然语言处理（英语：Natural Language Processing，简称NLP）是人工智能和语言学领域的分支学科。在这此领域中探讨如何处理及运用自然语言；自然语言认知则是指让电脑“懂”人类的语言。', '2013-06-27 02:33:36'),
(2, 'NLP', 1, '2013-05-07 00:00:00', 20, 45, 'http://baike.baidu.com/view/38610.htm#sub7103805', 'http://zh.wikipedia.org/zh-cn/%D7%D4%C8%BB%D3%EF%D1%D4%B4%A6%C0%ED', '自然语言处理（英语：Natural Language Processing，简称NLP）是人工智能和语言学领域的分支学科。在这此领域中探讨如何处理及运用自然语言；自然语言认知则是指让电脑“懂”人类的语言。', NULL),
(3, '机器学习', 2, '2013-05-07 00:00:00', 20, 45, 'http://baike.baidu.com/view/7956.htm', 'http://zh.wikipedia.org/zh-cn/%BB%FA%C6%F7%D1%A7%CF%B0', '机器学习是近20多年兴起的一门多领域交叉学科，涉及概率论、统计学、逼近论、凸分析、算法复杂度理论等多门学科。机器学习理论主要是设计和分析一些让计算机可以自动“学习”的算法。机器学习算法是一类从数据中自动分析获得规律，并利用规律对未知数据进行预测的算法。因为学习算法中涉及了大量的统计学理论，机器学习与统计推断学联系尤为密切，也被称为统计学习理论。算法设计方面，机器学习理论关注可以实现的，行之有效的学习算法。很多推论问题属于无程序可循难度，所以部分的机器学习研究是开发容易处理的近似算法。', NULL),
(4, 'Machine Learning', 2, '2013-05-07 00:00:00', 20, 45, 'http://baike.baidu.com/view/6572.htm#sub9577981', NULL, '机器学习(machine learning)是研究计算机怎样模拟或实现人类的学习行为，以获取新的知识或技能，重新组织已有的知识结构使之不断改善自身的性能。它是人工智能的核心，是使计算机具有智能的根本途径，其应用...', NULL),
(5, '人工智能', 1, '2013-05-07 00:00:00', 20, 45, 'http://baike.baidu.com/view/288190.htm', 'http://zh.wikipedia.org/zh-cn/%C8%CB%B9%A4%D6%C7%C4%DC', '人工智能（英语：Artificial Intelligence, AI）有时也称作机器智能，是指由人工制造出来的系统所表现出来的智能。通常人工智能是指通过普通计算机实现的智能。该词同时也指研究这样的智能系统是否能够实现，以及如何实现的科学领域。', NULL),
(6, 'AI', 1, '2013-05-07 00:00:00', 20, 45, 'http://baike.baidu.com/view/18300.htm#sub10686205', 'http://zh.wikipedia.org/zh-cn/%C3%C0%B9%FA%C5%BC%CF%F1', '《美国偶像》（英语：American Idol）是福斯广播公司从2002年起主办的美国大众歌手选秀赛，英国电视节目《流行偶像》（Pop Idol）的美国版。《美国偶像》的制作方是FremantleMedia，隶属于德国的贝塔斯曼公司；经纪方是19 Entertainment。', NULL),
(7, '隐马尔科夫模型', 2, '2013-05-07 00:00:00', 20, 45, 'http://baike.baidu.com/view/3412654.htm', 'http://zh.wikipedia.org/zh-cn/%D2%FE%C2%ED%B6%FB%BF%C6%B7%F2%C4%A3%D0%CD', '隐马尔可夫模型（Hidden Markov Model，HMM）是统计模型，它用来描述一个含有隐含未知参数的马尔可夫过程。其难点是从可观察的参数中确定该过程的隐含参数。然后利用这些参数来作进一步的分析，例如模式识别。', NULL),
(8, 'HMM', 2, '2013-05-07 00:00:00', 20, 45, 'http://baike.baidu.com/view/1323333.htm', 'http://zh.wikipedia.org/zh-cn/%D6%D8%BD%F0%CA%F4%D2%F4%C0%D6', '重金属音乐（英语：Heavy Metal）是一种应用强烈的旋律与失真（distortion）吉他音效的摇滚乐分类音乐。', NULL),
(9, 'nlpy', 1, '2013-07-10 00:00:00', 5, 5, NULL, NULL, NULL, '2013-07-11 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `abbre_abbre`
--

CREATE TABLE IF NOT EXISTS `abbre_abbre` (
  `oabrid` int(10) unsigned NOT NULL,
  `tabrid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`oabrid`,`tabrid`),
  KEY `tabrid` (`tabrid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `abbre_abbre`
--

INSERT INTO `abbre_abbre` (`oabrid`, `tabrid`) VALUES
(2, 1),
(1, 2),
(4, 3),
(3, 4),
(6, 5),
(5, 6),
(8, 7),
(7, 8);

-- --------------------------------------------------------

--
-- Table structure for table `abbre_outs`
--

CREATE TABLE IF NOT EXISTS `abbre_outs` (
  `osid` int(10) unsigned NOT NULL,
  `abrid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`osid`,`abrid`),
  KEY `abrid` (`abrid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `abbre_outs`
--

INSERT INTO `abbre_outs` (`osid`, `abrid`) VALUES
(1, 1),
(2, 1),
(1, 2),
(2, 2),
(3, 3),
(4, 3),
(3, 4),
(4, 4),
(5, 5),
(6, 5),
(5, 6),
(6, 6),
(7, 7),
(8, 7),
(7, 8),
(8, 8);

-- --------------------------------------------------------

--
-- Table structure for table `abbre_score`
--

CREATE TABLE IF NOT EXISTS `abbre_score` (
  `as_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `uid` varchar(20) NOT NULL COMMENT '用户ID',
  `abrid` int(10) NOT NULL COMMENT '词条ID',
  `score` int(10) NOT NULL DEFAULT '1000' COMMENT '系统打分值',
  `modify_time` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`as_id`),
  UNIQUE KEY `as_item` (`uid`,`abrid`),
  KEY `uid` (`uid`),
  KEY `abrid` (`abrid`),
  KEY `time` (`modify_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `abbre_weibomsg`
--

CREATE TABLE IF NOT EXISTS `abbre_weibomsg` (
  `abrid` int(10) unsigned NOT NULL,
  `mid` varchar(20) NOT NULL,
  PRIMARY KEY (`abrid`,`mid`),
  KEY `mid` (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `abbre_weibomsg`
--

INSERT INTO `abbre_weibomsg` (`abrid`, `mid`) VALUES
(1, '3569628326618641'),
(2, '3569628326618641'),
(3, '3569628326618641'),
(4, '3569628326618641'),
(5, '3569628326618641'),
(6, '3569628326618641'),
(7, '3569628326618641'),
(8, '3569628326618641'),
(1, '3570174365911254'),
(2, '3570174365911254'),
(3, '3570174365911254'),
(4, '3570174365911254'),
(5, '3570174365911254'),
(6, '3570174365911254'),
(7, '3570174365911254'),
(8, '3570174365911254'),
(1, '3570174365912254'),
(2, '3570174365912254'),
(3, '3570174365912254'),
(4, '3570174365912254'),
(5, '3570174365912254'),
(6, '3570174365912254'),
(7, '3570174365912254'),
(8, '3570174365912254'),
(1, '3570174465911254'),
(2, '3570174465911254'),
(3, '3570174465911254'),
(4, '3570174465911254'),
(5, '3570174465911254'),
(6, '3570174465911254'),
(7, '3570174465911254'),
(8, '3570174465911254'),
(1, '3570174765911254'),
(2, '3570174765911254'),
(3, '3570174765911254'),
(4, '3570174765911254'),
(5, '3570174765911254'),
(6, '3570174765911254'),
(7, '3570174765911254'),
(8, '3570174765911254'),
(1, '3574025539106810'),
(2, '3574025539106810'),
(3, '3574025539106810'),
(4, '3574025539106810'),
(6, '3574025539106810'),
(7, '3574025539106810'),
(8, '3574025539106810'),
(1, '3574025739106810'),
(2, '3574025739106810'),
(3, '3574025739106810'),
(4, '3574025739106810'),
(5, '3574025739106810'),
(6, '3574025739106810'),
(7, '3574025739106810'),
(8, '3574025739106810'),
(1, '3574025779106810'),
(2, '3574025779106810'),
(3, '3574025779106810'),
(4, '3574025779106810'),
(5, '3574025779106810'),
(6, '3574025779106810'),
(7, '3574025779106810'),
(8, '3574025779106810');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `cgid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cgn` varchar(20) NOT NULL,
  PRIMARY KEY (`cgid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cgid`, `cgn`) VALUES
(1, '算法'),
(2, '会议');

-- --------------------------------------------------------

--
-- Table structure for table `outsource`
--

CREATE TABLE IF NOT EXISTS `outsource` (
  `osid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `tl` varchar(200) DEFAULT NULL,
  `ct` text,
  PRIMARY KEY (`osid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `outsource`
--

INSERT INTO `outsource` (`osid`, `url`, `tl`, `ct`) VALUES
(1, 'http://zh.wikipedia.org/zh-cn/%E8%87%AA%E7%84%B6%E8%AF%AD%E8%A8%80%E5%A4%84%E7%90%86', '自然语言处理', '自然语言处理（英语：Natural Language Processing，简称NLP）是人工智能和语言学领域的分支学科。在这此领域中探讨如何处理及运用自然语言；自然语言认知则是指让电脑“懂”人类的语言。'),
(2, 'http://baike.baidu.cn/view/18784.htm', '自然语言处理', '自然语言处理是计算机科学领域与人工智能领域中的一个重要方向。它研究能实现人与计算机之间用自然语言进行有效通信的各种理论和方法。自然语言处理是一门融语言学、计算机科学、数学于一体的科学。'),
(3, 'http://zh.wikipedia.org/wiki/%E6%9C%BA%E5%99%A8%E5%AD%A6%E4%B9%A0', '机器学习', '机器学习是近20多年兴起的一门多领域交叉学科，涉及概率论、统计学、逼近论、凸分析、算法复杂度理论等多门学科。机器学习理论主要是设计和分析一些让计算机可以自动“学习”的算法。机器学习算法是一类从数据中自动分析获得规律，并利用规律对未知数据进行预测的算法。'),
(4, 'http://baike.baidu.cn/view/7956.htm', '机器学习', '机器学习(Machine Learning)是一门多领域交叉学科，涉及概率论、统计学、逼近论、凸分析、算法复杂度理论等多门学科。专门研究计算机怎样模拟或实现人类的学习行为，以获取新的知识或技能，重新组织已有的知识结构使之不断改善自身的性能。'),
(5, 'http://zh.wikipedia.org/wiki/%E4%BA%BA%E5%B7%A5%E6%99%BA%E8%83%BD', '人工智能', '人工智能（英语：Artificial Intelligence, AI）有时也称作机器智能，是指由人工制造出来的系统所表现出来的智能。通常人工智能是指通过普通计算机实现的智能。该词同时也指研究这样的智能系统是否能够实现，以及如何实现的科学领域。'),
(6, 'http://baike.baidu.cn/view/2949.htm', '人工智能', '人工智能(Artificial Intelligence) ，英文缩写为AI。它是研究、开发用于模拟、延伸和扩展人的智能的理论、方法、技术及应用系统的一门新的技术科学。 人工智能是计算机科学的一个分支，它企图了解智能的实质，并生产出一种新的能以人类智能相似的方式做出反应的智能机器。'),
(7, 'http://zh.wikipedia.org/wiki/%E9%9A%90%E9%A9%AC%E5%B0%94%E5%8F%AF%E5%A4%AB%E6%A8%A1%E5%9E%8B', '隐马尔可夫模型', '隐马尔可夫模型（Hidden Markov Model，HMM）是统计模型，它用来描述一个含有隐含未知参数的马尔可夫过程。其难点是从可观察的参数中确定该过程的隐含参数。然后利用这些参数来作进一步的分析，例如模式识别。'),
(8, 'http://baike.baidu.cn/view/3412654.htm', '隐式马尔科夫模型', '隐马尔可夫模型（Hidden Markov models，HMM）是马尔可夫链的一种，它的状态不能直接观察到，但能通过观测向量序列观察到，每个观测向量都是通过某些概率密度分布表现为各种状态，每一个观测向量是由一个具有相应概率密度分布的状态序列产生。');

-- --------------------------------------------------------

--
-- Table structure for table `search_log`
--

CREATE TABLE IF NOT EXISTS `search_log` (
  `sl_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `uid` varchar(20) NOT NULL COMMENT '用户ID',
  `keyword` varchar(50) NOT NULL COMMENT '搜索关键词',
  `search_time` datetime NOT NULL COMMENT '搜索时间',
  PRIMARY KEY (`sl_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `userlist`
--

CREATE TABLE IF NOT EXISTS `userlist` (
  `uid` varchar(12) NOT NULL,
  `sn` varchar(50) DEFAULT NULL,
  `sx` char(1) DEFAULT 'n',
  `vi` varchar(300) DEFAULT NULL,
  `dr` tinyint(1) DEFAULT '0',
  `bl` varchar(255) DEFAULT NULL,
  `de` text,
  `ad` varchar(50) DEFAULT NULL,
  `un` varchar(20) DEFAULT NULL,
  `an` int(11) DEFAULT '0',
  `fn` int(11) DEFAULT '0',
  `mn` int(11) DEFAULT '0',
  `ci` text,
  `ei` text,
  `iu` varchar(255) DEFAULT NULL,
  `iv` tinyint(1) DEFAULT '0',
  `tg` varchar(255) DEFAULT NULL,
  `rn` varchar(10) DEFAULT NULL,
  `bd` date DEFAULT NULL,
  `qq` varchar(13) DEFAULT NULL,
  `msn` varchar(30) DEFAULT NULL,
  `email` varchar(90) DEFAULT NULL,
  `at` datetime DEFAULT NULL,
  `ti` datetime DEFAULT NULL,
  `fui` text,
  `last_login` datetime NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userlist`
--

INSERT INTO `userlist` (`uid`, `sn`, `sx`, `vi`, `dr`, `bl`, `de`, `ad`, `un`, `an`, `fn`, `mn`, `ci`, `ei`, `iu`, `iv`, `tg`, `rn`, `bd`, `qq`, `msn`, `email`, `at`, `ti`, `fui`, `last_login`) VALUES
('1803733977', '刘胜宇', '0', NULL, NULL, NULL, NULL, NULL, NULL, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tbin@gmail.com', NULL, NULL, NULL, '0000-00-00 00:00:00'),
('2100610530', 'tbin-jiayou', '0', NULL, NULL, NULL, NULL, NULL, NULL, 22, 34, 542, NULL, NULL, 'http://tp3.sinaimg.cn/2100610530/180/40007603275/1', NULL, NULL, NULL, NULL, NULL, NULL, 'tbin@gmail.com', NULL, NULL, '''1649252577'',''2259079072'',''1832841364'',''1918015782'',''2055144181'',''2208727481'',''2003297057'',''1955826790'',''1831348402'',''1096872440'',''2874453272'',''1096059607'',''1738937441'',''2833534593'',''2609397091'',''1733984585'',''2219088342'',''2641175052'',''1795587493'',''1642482194'',''1649173367'',''1662047260'',''1731200837'',''1784501333'',''2322114464'',''3121700831'',''1970879995'',''1697142574'',''2201405565'',''2804668891'',''2487275163'',''2743258870'',''1188078483'',''1864165950'',''1803733977'',''2392261910'',''1440166180'',''1674276964'',''1136353945'',''2252854824'',''2987093172'',''1869170057'',''1686830902'',''1645518723'',''1915548291'',''1991303247'',''2104931705'',''1657470871'',''3180867267'',''1990168660'',''2029442475'',''3023221911'',''1747898120'',''1806227264'',''2796339365'',''1744635682'',''1765208971'',''2155990282'',''1799197871'',''2797196024'',''1661403285'',''2075688437'',''1705116200'',''2692776591'',''2014195300'',''2107517614'',''1787878953'',''1670756334'',''1972774293'',''1745468157'',''2100569397'',''1648346957'',''1996492895'',''1991527564'',''1967516780'',''1763705067'',''1604920173'',''2534209242'',''1784585163'',''1929507273'',''1987233191'',''1541726154'',''1883552992'',''2134259570'',''1722774895'',''1936526225'',''1144739514'',''2863791373'',''1238867022'',''2150231094'',''1892680923'',''1718792531'',''1763405277'',''1738073254'',''2807283785'',''2296386893'',''1958378960'',''1965560083'',''1668647380'',''1693909073'',''1852500995'',''1912273717'',''2073906491'',''2035263564'',''1904874291'',''2352536394'',''1914597333'',''2410110922'',''1849074197'',''1657882770'',''1929569765'',''2135708652'',''1738690784'',''1902439835'',''1687445053'',''1979455831'',''1882579600'',''2145291155'',''1525396581'',''1670071920'',''1649005320'',''1654619934'',''2211253974'',''1282005885'',''1682352065'',''1182391231'',''1355610915'',''2060750830'',''1749127163'',''1624087025'',''1580904460'',''2174046341'',''1669344701'',''1559539744'',''1697600104'',''1661423564'',''1634367110'',''2704924787'',''1787153117'',''2509401422'',''2134868001'',''1241330914'',''2789168643'',''2843975262'',''1662047260'',''2296386893'',''1793133835'',''3261266513'',''1440166180'',''2100610530'',''1975171585'',''1842031325'',''1922397344'',''1192316092'',''1636166270'',''1748761342'',''1803733977'',''3179520153'',''3157367850'',''1878343061'',''1727651281'',''1843972355'',''2882668690'',''2689473743'',''2472367842'',''2252854824'',''1594954855'',''1624087025'',''2529604532'',''2080860101'',''2024299664'',''1708942053'',''1794315743'',''2132448623'',''1728565101'',''1864200020'',''1199389345'',''2179917353'',''2592104570'',''1940128324'',''1659238053'',''1756582651'',''2608686027'',''2341290892'',''1355610915'',''2045836341'',''1866511825'',''1336307477'',''2012448277'',''2787186967'',''2115287922'',''1935788924'',''2011066572'',''1461892242'',''1808067361'',''2219858775'',''2527625053'',''1742068325'',''1979652665'',''1672272373'',''1182391231'',''1872109493'',''1970879995'',''1497035431'',''1684953923'',''2567464244'',''1649920750'',''2160900895'',''1800268855'',''1937618377'',''1582459022'',''1829948001'',''1464484735'',''1887351955'',''1677425814'',''1497510020'',''1654619934'',''1677746711'',''2050560430'',''1789811857'',''1847592443'',''1494777880'',''2259079072'',''2276578611'',''1847567135'',''1674276964''', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_abbre`
--

CREATE TABLE IF NOT EXISTS `user_abbre` (
  `ua_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `uid` varchar(20) NOT NULL COMMENT '用户ID',
  `abrid` int(10) NOT NULL COMMENT '词条ID',
  `view_time` datetime NOT NULL COMMENT '最后浏览时间',
  `view_count` int(10) NOT NULL DEFAULT '0' COMMENT '浏览次数',
  PRIMARY KEY (`ua_id`),
  UNIQUE KEY `ua_item` (`uid`,`abrid`),
  KEY `uid` (`uid`),
  KEY `abrid` (`abrid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `weibomsg`
--

CREATE TABLE IF NOT EXISTS `weibomsg` (
  `mid` varchar(20) NOT NULL,
  `uid` varchar(12) NOT NULL,
  `un` varchar(50) DEFAULT NULL,
  `sn` varchar(50) DEFAULT NULL,
  `iu` varchar(255) DEFAULT NULL,
  `rmid` varchar(50) DEFAULT NULL,
  `mc` varchar(300) DEFAULT NULL,
  `murl` varchar(200) DEFAULT NULL,
  `srn` varchar(50) DEFAULT NULL,
  `iurl` varchar(255) DEFAULT NULL,
  `aurl` varchar(255) DEFAULT NULL,
  `vurl` varchar(255) DEFAULT NULL,
  `rc` varchar(10) DEFAULT NULL,
  `cc` varchar(10) DEFAULT NULL,
  `pt` datetime DEFAULT NULL,
  `nc` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `weibomsg`
--

INSERT INTO `weibomsg` (`mid`, `uid`, `un`, `sn`, `iu`, `rmid`, `mc`, `murl`, `srn`, `iurl`, `aurl`, `vurl`, `rc`, `cc`, `pt`, `nc`) VALUES
('3569623326618641', '2100610530', NULL, 'tbin-jiayou', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '@ICTCLAS张华平博士:同感，我这个非新闻的理工科几乎同时发布了这个想法。新闻的僵化可见一斑。思想的保守才是真正的悲哀,张力奋,七点央视新闻联播，头条消息居然不是雅安地震赈灾，而是清华大学一奖学金启动仪式! 实在匪夷所思! 是因为习主席、奥巴马总统为奖学金写了贺信吗? 中国的记者编辑怎么做? 新闻学又怎么教?', NULL, '新浪微博', 'http://ww4.sinaimg.cn/bmiddle/68434a35jw1e3xgc29jm4j218g0xcwli.jpg', NULL, NULL, '5', '5', '0000-00-00 00:00:00', NULL),
('3569628326618641', '2100610530', NULL, 'tbin-jiayou', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '@ICTCLAS张华平博士:同感，我这个非新闻的理工科几乎同时发布了这个想法。新闻的僵化可见一斑。思想的保守才是真正的悲哀,张力奋,七点央视新闻联播，头条消息居然不是雅安地震赈灾，而是清华大学一奖学金启动仪式! 实在匪夷所思! 是因为习主席、奥巴马总统为奖学金写了贺信吗? 中国的记者编辑怎么做? 新闻学又怎么教?', NULL, '新浪微博', 'http://ww4.sinaimg.cn/bmiddle/68434a35jw1e3xgc29jm4j218g0xcwli.jpg', NULL, NULL, '5', '5', '0000-00-00 00:00:00', NULL),
('3569628346618641', '2100610530', NULL, 'tbin-jiayou', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '@ICTCLAS张华平博士:同感，我这个非新闻的理工科几乎同时发布了这个想法。新闻的僵化可见一斑。思想的保守才是真正的悲哀,张力奋,七点央视新闻联播，头条消息居然不是雅安地震赈灾，而是清华大学一奖学金启动仪式! 实在匪夷所思! 是因为习主席、奥巴马总统为奖学金写了贺信吗? 中国的记者编辑怎么做? 新闻学又怎么教?', NULL, '新浪微博', 'http://ww4.sinaimg.cn/bmiddle/68434a35jw1e3xgc29jm4j218g0xcwli.jpg', NULL, NULL, '5', '5', '0000-00-00 00:00:00', NULL),
('3569628526618641', '2100610530', NULL, 'tbin-jiayou', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '@ICTCLAS张华平博士:同感，我这个非新闻的理工科几乎同时发布了这个想法。新闻的僵化可见一斑。思想的保守才是真正的悲哀,张力奋,七点央视新闻联播，头条消息居然不是雅安地震赈灾，而是清华大学一奖学金启动仪式! 实在匪夷所思! 是因为习主席、奥巴马总统为奖学金写了贺信吗? 中国的记者编辑怎么做? 新闻学又怎么教?', NULL, '新浪微博', 'http://ww4.sinaimg.cn/bmiddle/68434a35jw1e3xgc29jm4j218g0xcwli.jpg', NULL, NULL, '5', '5', '0000-00-00 00:00:00', NULL),
('3570174265911254', '1803733977', NULL, '刘胜宇', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '首都不适合生活呀//@张栋_机器学习: 我转了一下，已经几个工程师告诉我准备离开北京了; 开复再转发，估计会有更多人思考：离开，还是留下？//@李开复: 有勇气追随你的心！ //@张栋_机器学习:转发,花无影,朋友们，我要离开北京啦！ 工作已辞啦，房子已卖啦！ 别以为我疯了，因为我从没正常过。 下一站，西安！http://t.cn/zTI9C3O', 'http://t.cn/zTI9C3O', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/4b8bd145jw1e3yur1875hj20o70jg759.jpg', NULL, NULL, '5', '5', '0000-00-00 00:00:00', NULL),
('3570174355911254', '1803733977', NULL, '刘胜宇', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '首都不适合生活呀//@张栋_机器学习: 我转了一下，已经几个工程师告诉我准备离开北京了; 开复再转发，估计会有更多人思考：离开，还是留下？//@李开复: 有勇气追随你的心！ //@张栋_机器学习:转发,花无影,朋友们，我要离开北京啦！ 工作已辞啦，房子已卖啦！ 别以为我疯了，因为我从没正常过。 下一站，西安！http://t.cn/zTI9C3O', 'http://t.cn/zTI9C3O', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/4b8bd145jw1e3yur1875hj20o70jg759.jpg', NULL, NULL, '5', '5', '0000-00-00 00:00:00', NULL),
('3570174365911254', '1803733977', NULL, '刘胜宇', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '首都不适合生活呀//@张栋_机器学习: 我转了一下，已经几个工程师告诉我准备离开北京了; 开复再转发，估计会有更多人思考：离开，还是留下？//@李开复: 有勇气追随你的心！ //@张栋_机器学习:转发,花无影,朋友们，我要离开北京啦！ 工作已辞啦，房子已卖啦！ 别以为我疯了，因为我从没正常过。 下一站，西安！http://t.cn/zTI9C3O', 'http://t.cn/zTI9C3O', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/4b8bd145jw1e3yur1875hj20o70jg759.jpg', NULL, NULL, '5', '5', '0000-00-00 00:00:00', NULL),
('3570174365912254', '2100610530', NULL, 'tbin-jiayou', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '@ICTCLAS张华平博士:同感，我这个非新闻的理工科几乎同时发布了这个想法。新闻的僵化可见一斑。思想的保守才是真正的悲哀,张力奋,七点央视新闻联播，头条消息居然不是雅安地震赈灾，而是清华大学一奖学金启动仪式! 实在匪夷所思! 是因为习主席、奥巴马总统为奖学金写了贺信吗? 中国的记者编辑怎么做? 新闻学又怎么教?', NULL, '新浪微博', 'http://ww4.sinaimg.cn/bmiddle/68434a35jw1e3xgc29jm4j218g0xcwli.jpg', NULL, NULL, '5', '5', '0000-00-00 00:00:00', NULL),
('3570174465911254', '1803733977', NULL, '刘胜宇', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '首都不适合生活呀//@张栋_机器学习: 我转了一下，已经几个工程师告诉我准备离开北京了; 开复再转发，估计会有更多人思考：离开，还是留下？//@李开复: 有勇气追随你的心！ //@张栋_机器学习:转发,花无影,朋友们，我要离开北京啦！ 工作已辞啦，房子已卖啦！ 别以为我疯了，因为我从没正常过。 下一站，西安！http://t.cn/zTI9C3O', 'http://t.cn/zTI9C3O', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/4b8bd145jw1e3yur1875hj20o70jg759.jpg', NULL, NULL, '5', '5', '0000-00-00 00:00:00', NULL),
('3570174765210254', '1803733977', NULL, '刘胜宇', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '首都不适合生活呀//@张栋_机器学习: 我转了一下，已经几个工程师告诉我准备离开北京了; 开复再转发，估计会有更多人思考：离开，还是留下？//@李开复: 有勇气追随你的心！ //@张栋_机器学习:转发,花无影,朋友们，我要离开北京啦！ 工作已辞啦，房子已卖啦！ 别以为我疯了，因为我从没正常过。 下一站，西安！http://t.cn/zTI9C3O', 'http://t.cn/zTI9C3O', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/4b8bd145jw1e3yur1875hj20o70jg759.jpg', NULL, NULL, '5', '5', '0000-00-00 00:00:00', NULL),
('3570174765911254', '1803733977', NULL, '刘胜宇', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '首都不适合生活呀//@张栋_机器学习: 我转了一下，已经几个工程师告诉我准备离开北京了; 开复再转发，估计会有更多人思考：离开，还是留下？//@李开复: 有勇气追随你的心！ //@张栋_机器学习:转发,花无影,朋友们，我要离开北京啦！ 工作已辞啦，房子已卖啦！ 别以为我疯了，因为我从没正常过。 下一站，西安！http://t.cn/zTI9C3O', 'http://t.cn/zTI9C3O', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/4b8bd145jw1e3yur1875hj20o70jg759.jpg', NULL, NULL, '5', '5', '0000-00-00 00:00:00', NULL),
('3574025139106810', '1590776853', NULL, 'Karen上善若水', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '介绍一下许心馨老师：波士顿大学MBA, NLP高级培训师，十多年来主要在500强从事高层辅导(Executive Coach)和管理培训课程，曾旅居20多个国家的美籍华人http://t.cn/zTlC4o6 老师从事身心灵探索多年，凝聚高层领导力辅导的经验和智慧，以花精疗愈体系为载体，为人间输送充满慈悲和大爱的正能量。', 'http://t.cn/zTlC4o6', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/5ed15415gw1e4bk8llp3cj20k00f0wjo.jpg', NULL, NULL, '5', '5', '0000-00-00 00:00:00', NULL),
('3574025539106810', '1590776853', NULL, 'Karen上善若水', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '介绍一下许心馨老师：波士顿大学MBA, NLP高级培训师，十多年来主要在500强从事高层辅导(Executive Coach)和管理培训课程，曾旅居20多个国家的美籍华人http://t.cn/zTlC4o6 老师从事身心灵探索多年，凝聚高层领导力辅导的经验和智慧，以花精疗愈体系为载体，为人间输送充满慈悲和大爱的正能量。', 'http://t.cn/zTlC4o6', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/5ed15415gw1e4bk8llp3cj20k00f0wjo.jpg', NULL, NULL, '5', '5', '0000-00-00 00:00:00', NULL),
('3574025739106810', '1590776853', NULL, 'Karen上善若水', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '介绍一下许心馨老师：波士顿大学MBA, NLP高级培训师，十多年来主要在500强从事高层辅导(Executive Coach)和管理培训课程，曾旅居20多个国家的美籍华人http://t.cn/zTlC4o6 老师从事身心灵探索多年，凝聚高层领导力辅导的经验和智慧，以花精疗愈体系为载体，为人间输送充满慈悲和大爱的正能量。', 'http://t.cn/zTlC4o6', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/5ed15415gw1e4bk8llp3cj20k00f0wjo.jpg', NULL, NULL, '5', '5', '0000-00-00 00:00:00', NULL),
('3574025779106810', '1590776853', NULL, 'Karen上善若水', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '介绍一下许心馨老师：波士顿大学MBA, NLP高级培训师，十多年来主要在500强从事高层辅导(Executive Coach)和管理培训课程，曾旅居20多个国家的美籍华人http://t.cn/zTlC4o6 老师从事身心灵探索多年，凝聚高层领导力辅导的经验和智慧，以花精疗愈体系为载体，为人间输送充满慈悲和大爱的正能量。', 'http://t.cn/zTlC4o6', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/5ed15415gw1e4bk8llp3cj20k00f0wjo.jpg', NULL, NULL, '5', '5', '0000-00-00 00:00:00', NULL),
('3574025839106810', '1590776853', NULL, 'Karen上善若水', 'http://tp2.sinaimg.cn/1590776853/50/1299323664/0', NULL, '介绍一下许心馨老师：波士顿大学MBA, NLP高级培训师，十多年来主要在500强从事高层辅导(Executive Coach)和管理培训课程，曾旅居20多个国家的美籍华人http://t.cn/zTlC4o6 老师从事身心灵探索多年，凝聚高层领导力辅导的经验和智慧，以花精疗愈体系为载体，为人间输送充满慈悲和大爱的正能量。', 'http://t.cn/zTlC4o6', '新浪微博', 'http://ww1.sinaimg.cn/bmiddle/5ed15415gw1e4bk8llp3cj20k00f0wjo.jpg', NULL, NULL, '5', '5', '0000-00-00 00:00:00', NULL),
('3593504154464369', '1182391231', '潘石屹', '潘石屹', 'http://tp4.sinaimg.cn/1182391231/50/5602749938/1', '3593492767018521', '转发微博//@SOHO中国在刚刚结束的外滩SOHO项目立面照明供货及安装工程定标会上，富润成、良业、领路人、松耳、新炬机电、中太建设共计6家企业进入最后的竞标。恭喜上海松耳照明工程有限公司中标,我们欢迎更多优秀企业参加SOHO中国工程招标。http://t.cn/zOLx5Ow', NULL, 'iPhone客户端', NULL, NULL, NULL, '24', '24', '2013-06-26 19:06:58', NULL),
('359350415464369', '1182391231', '潘石屹', '潘石屹', 'http://tp4.sinaimg.cn/1182391231/50/5602749938/1', '3593492767018521', '转发微博//@SOHO中国在刚刚结束的外滩SOHO项目立面照明供货及安装工程定标会上，富润成、良业、领路人、松耳、新炬机电、中太建设共计6家企业进入最后的竞标。恭喜上海松耳照明工程有限公司中标,我们欢迎更多优秀企业参加SOHO中国工程招标。http://t.cn/zOLx5Ow', NULL, 'iPhone客户端', NULL, NULL, NULL, '24', '24', '0000-00-00 00:00:00', NULL),
('3593504174464369', '1182391231', '潘石屹', '潘石屹', 'http://tp4.sinaimg.cn/1182391231/50/5602749938/1', '3593492767018521', '转发微博//@SOHO中国在刚刚结束的外滩SOHO项目立面照明供货及安装工程定标会上，富润成、良业、领路人、松耳、新炬机电、中太建设共计6家企业进入最后的竞标。恭喜上海松耳照明工程有限公司中标,我们欢迎更多优秀企业参加SOHO中国工程招标。http://t.cn/zOLx5Ow', NULL, 'iPhone客户端', NULL, NULL, NULL, '26', '27', '0000-00-00 00:00:00', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `abbreviation`
--
ALTER TABLE `abbreviation`
  ADD CONSTRAINT `abbreviation_ibfk_1` FOREIGN KEY (`cgid`) REFERENCES `category` (`cgid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `abbre_abbre`
--
ALTER TABLE `abbre_abbre`
  ADD CONSTRAINT `abbre_abbre_ibfk_1` FOREIGN KEY (`oabrid`) REFERENCES `abbreviation` (`abrid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `abbre_abbre_ibfk_2` FOREIGN KEY (`tabrid`) REFERENCES `abbreviation` (`abrid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `abbre_outs`
--
ALTER TABLE `abbre_outs`
  ADD CONSTRAINT `abbre_outs_ibfk_1` FOREIGN KEY (`osid`) REFERENCES `outsource` (`osid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `abbre_outs_ibfk_2` FOREIGN KEY (`abrid`) REFERENCES `abbreviation` (`abrid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `abbre_weibomsg`
--
ALTER TABLE `abbre_weibomsg`
  ADD CONSTRAINT `abbre_weibomsg_ibfk_1` FOREIGN KEY (`abrid`) REFERENCES `abbreviation` (`abrid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `abbre_weibomsg_ibfk_2` FOREIGN KEY (`mid`) REFERENCES `weibomsg` (`mid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
