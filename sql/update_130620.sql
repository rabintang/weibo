USE weiboapp;
DROP TABLE IF EXISTS `weiboapp`.`atten`;

ALTER TABLE `userlist` MODIFY sx char(1) DEFAULT 'n';
ALTER TABLE `userlist` MODIFY dr tinyint(1) DEFAULT 0;
ALTER TABLE `userlist` MODIFY iv tinyint(1) DEFAULT 0;
