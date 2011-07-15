CREATE TABLE user_setting(
	user_id bigint( 20 ),
	name varchar(255),
    value varchar(255),
	PRIMARY KEY (`user_id`,`name`)
);