ALTER TABLE `video` ADD `pre_roll` INT AFTER `video_title` ;
ALTER TABLE `video` ADD `post_roll` INT AFTER `pre_roll` ;