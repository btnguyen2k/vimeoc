START TRANSACTION;

CREATE TABLE content(
	id bigint( 20 ) NOT NULL AUTO_INCREMENT ,
	title varchar( 255 ) ,
	alias varchar( 255 ) ,
	body longtext,
	keywords varchar( 255 ) ,
	modify_date timestamp,
	create_date timestamp,
	creator_id bigint( 20 ) ,
	modifier_id bigint( 20 ) ,
	publish int( 1 ),
	PRIMARY KEY (`id`)
);

CREATE TABLE user_setting(
	user_id bigint( 20 ),
	name varchar(255),
    value varchar(255),
	PRIMARY KEY (`user_id`,`name`)
);

COMMIT;