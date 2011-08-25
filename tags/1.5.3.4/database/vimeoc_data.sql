START TRANSACTION;

-- Default password is '12345'
INSERT INTO `user` (`id`, `username`, `password`, `email`, `password_hint`, `account_locked`, `account_enabled`, `full_name`, `website`, `profile_alias`, `creation_date`, `avatar`) 
VALUES(1, 'admin@gpv.com.vn', '1dsat4b3f9cbae58e6420b6c54913196ae26bafc4b200b', 'admin@gpv.com.vn', NULL, b'0', b'1', 'Admin', NULL, 'user1', '2011-07-16 15:05:47', NULL);

--
-- Default roles
--
INSERT INTO `role` (`id`, `name`) VALUES
(-9, 'ROLE_ADMIN'),
(1, 'ROLE_USER');

--
-- Set admin role for admin@gpv.com.vn
--
INSERT INTO `user_role` (`user_id`, `role_id`, `creation_date`) VALUES
(1, -9, '2011-05-24 11:16:48');

--
-- Set configuration default values
--
INSERT INTO configuration(name, value) VALUES ('SHOW_LOGIN_FORM', 1);
INSERT INTO configuration(name, value) VALUES ('SHOW_SIGNUP_FORM', 1);

--
-- Add content category
--
INSERT INTO category(id,name) VALUES (1,'Not show on user menu');
INSERT INTO category(id,name) VALUES (2,'Show on user menu');

--
-- Terms and Conditions content
--
INSERT INTO `content` (`id`, `title`, `alias`, `body`, `keywords`, `modify_date`, `create_date`, `creator_id`, `modifier_id`, `publish`, `category_id`) VALUES
(1, 'Terms & Conditions', 'term-and-condition', 'Terms and conditions', 'term, condition', '2011-07-19 10:16:04', '2011-07-19 10:16:04', 24, 24, 1, 1);

COMMIT;