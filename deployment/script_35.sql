ALTER TABLE `user` ADD `avatar` VARCHAR( 255 ) NULL;
ALTER TABLE `video` ADD `video_title` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `video` ADD `pre_roll` INT AFTER `video_title` ;
ALTER TABLE `video` ADD `post_roll` INT AFTER `pre_roll` ;