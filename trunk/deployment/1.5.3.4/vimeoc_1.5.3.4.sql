START TRANSACTION;

ALTER TABLE `user` ADD `reset_key` varchar(225) after full_name;

update `user_setting` set `value`='2' where `name`='album_list_sort' and `value`>3;
update `user_setting` set `value`='2' where `name`='channel_list_sort' and `value`>3;

COMMIT;