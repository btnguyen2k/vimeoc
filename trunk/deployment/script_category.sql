CREATE TABLE category(
	id bigint( 20 ) NOT NULL AUTO_INCREMENT,
	name varchar(255),
	PRIMARY KEY (`id`)
);
ALTER TABLE `content` ADD `category_id` bigint(20) NULL;
INSERT INTO category(id,name) VALUES (1,'system');
INSERT INTO category(id,name) VALUES (2,'user');

ALTER TABLE content
ADD FOREIGN KEY (category_id)
REFERENCES category(id)