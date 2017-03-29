SET foreign_key_checks = 0;

delete from groups where admin_group_id is not null;
delete from groups;
alter table groups AUTO_INCREMENT = 1;
delete from resources;
alter table resources AUTO_INCREMENT = 1;
delete from accessories;
alter table accessories AUTO_INCREMENT = 1;
delete from users;
alter table users AUTO_INCREMENT = 1;

insert into groups (group_id, name) values (1, 'Group Administrators'), (2, 'Application Administrators'), (3, 'Resource Administrators'), (4, 'Schedule Administrators');

insert into group_roles values (1, 1);
insert into group_roles values (2, 2);
insert into group_roles values (4, 4);

insert into users (fname, lname, email, username, password, salt, timezone, lastlogin, status_id, date_created, language, organization)
	values ('User', 'User', 'user@example.com', 'user', '7b6aec38ff9b7650d64d0374194307bdde711425', '3b3dbb9b', 'America/Chicago', '2008-09-16 01:59:00', 1, now(), 'en_us', 'XYZ Org Inc.');
insert into users (fname, lname, email, username, password, salt, timezone, lastlogin, status_id, date_created, language, organization)
	values ('Admin', 'Admin', 'admin@example.com', 'admin', '70f3e748c6801656e4aae9dca6ee98ab137d952c', '4a04db87', 'America/Chicago', '2010-03-26 12:44:00', 1, now(), 'en_us', 'ABC Org Inc.');

insert into user_groups values (2,2);	
	
insert into resources (`resource_id`, `name`, `location`, `contact_info`, `description`, `notes`, `min_duration`, `min_increment`, `max_duration`, `unit_cost`, `autoassign`, `requires_approval`, `allow_multiday_reservations`, `max_participants`, `min_notice_time`, `max_notice_time`, `image_name`, `legacyid`, `schedule_id`) VALUES
(1, 'Conference Room 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 'resource1.jpg', NULL, 1),
(2, 'Conference Room 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 'resource2.jpg', NULL, 1);

insert into accessories (`accessory_id`, `accessory_name`, `accessory_quantity`) values
(1, 'accessory limited to 10', 10),
(2, 'accessory limited to 2', 2),
(3, 'unlimited accessory', NULL);

truncate table user_resource_permissions;
insert into user_resource_permissions values (1,1,1),(1,2,1),(2,1,1),(2,2,1);

truncate table custom_attributes;
insert into custom_attributes(`custom_attribute_id`,`display_label`,`display_type`,`attribute_category`,`validation_regex`,`is_required`,`possible_values`) VALUES
(1, 'Test Number', 1, 1, null, false, null),
(2, 'Test String', 1, 1, null, false, null),
(3, 'Test Number', 1, 4, null, false, null),
(4, 'Test String', 1, 4, null, false, null);

SET foreign_key_checks = 1;