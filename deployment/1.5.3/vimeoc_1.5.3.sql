START TRANSACTION;

CREATE TABLE category(
	id bigint( 20 ) NOT NULL AUTO_INCREMENT,
	name varchar(255),
	PRIMARY KEY (`id`)
);

INSERT INTO category(id,name) VALUES (1,'system');
INSERT INTO category(id,name) VALUES (2,'user');

ALTER TABLE `content` ADD `category_id` bigint(20) NULL;

ALTER TABLE content
ADD FOREIGN KEY (category_id)
REFERENCES category(id);

UPDATE `content` SET `category_id` = '2' WHERE `content`.`alias` = 'term-and-condition';

COMMIT;