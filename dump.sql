# create table
CREATE TABLE IF NOT EXISTS `visitors`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `hash` VARCHAR(32) NOT NULL,
    `visited_at` TIMESTAMP,
    `visits` INT DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# retrieve specific user's today's visits
SELECT * FROM visitors WHERE hash='hash' and DATE(visited_at)=CURDATE()

# insert visitor's data
INSERT INTO visitors(hash, visited_at) VALUES('hash', '1970-01-01 00:00');

# update visitor's visits count
UPDATE visitors SET visits=visits + 1 WHERE hash='somehash';

# get specified day's visitors
SELECT hash, visited_at, visits FROM visitors WHERE DATE(visited_at)='1970-01-01 00:00';