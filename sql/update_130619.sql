DROP TABLE IF EXISTS `weiboapp`.`atten`;
CREATE TABLE  `weiboapp`.`atten` (
	urid varchar(12) not null, #用户ID
	ueid text, #被urid关注的用户列表，以逗号分隔
	PRIMARY KEY (`urid`),
	FOREIGN KEY(`urid`) REFERENCES userlist(`uid`) on delete cascade on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
