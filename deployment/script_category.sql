CREATE TABLE category(
	id bigint( 20 ),
	name varchar(255),
	PRIMARY KEY (`id`)
);
ALTER TABLE `content` ADD `category_id` bigint(20) NULL;
INSERT INTO category(name) VALUES ('system');
INSERT INTO category(name) VALUES ('user');

ALTER TABLE content
ADD FOREIGN KEY (category_id)
REFERENCES category(id)