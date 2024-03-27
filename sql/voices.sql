CREATE DATABASE IF NOT EXISTS `voices`;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS world_location;

CREATE TABLE world_location (
    id int unsigned not null auto_increment primary key,
    locale_name varchar(150) not null,
    country_id int unsigned null default null,
    type_id tinyint unsigned not null,

    constraint unique index world_location_locale_name_type_id_uqidx (locale_name, type_id),
    foreign key world_location_country_id_ibfk (country_id) references world_location(id) on delete cascade on update restrict
);

DROP TABLE IF EXISTS attachment;

CREATE TABLE attachment (
    `id` int unsigned not null auto_increment primary key,
    `name` varchar(255) not null,
    `type` varchar(255) not null,
    `extension` varchar(5) null default null,
    `size` integer unsigned not null default 0,
    `path` varchar(255) not null,
    `datetime_created` datetime not null default CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS job;

CREATE TABLE job (
    id int unsigned not null auto_increment primary key,
    title varchar(150) not null,
    location_id int unsigned not null,
    additional_information text null default null,
    attachment_id int unsigned null default null,
    datetime_created datetime not null default CURRENT_TIMESTAMP,

    foreign key job_location_id_ibfk (location_id) references world_location(id) on delete restrict on update restrict,
    foreign key jon_attachment_id_ibfk (attachment_id) references attachment(id) on delete set null on update restrict
);

INSERT INTO `world_location` (id, locale_name, country_id, type_id)
VALUES (1, 'Canada', null, 1), (2, 'USA', null, 1);

INSERT INTO `world_location` (locale_name, country_id, type_id)
VALUES 
('Alberta', 1, 2),
('British Columbia', 1, 2),
( 'Manitoba', 1, 2),
( 'New Brunswick', 1, 2),
( 'Newfoundland and Labrador', 1, 2),
( 'Northwest Territories', 1, 2),
( 'Nova Scotia', 1, 2),
('Nunavut Territory', 1, 2),
( 'Ontario', 1, 2),
( 'Prince Edward Island', 1, 2),
( 'Québec', 1, 2),
( 'Saskatchewan', 1, 2),
( 'Yukon Territory', 1, 2);

INSERT INTO `world_location` (locale_name, country_id, type_id)
VALUES
('Alabama', 2, 2),
('Alaska', 2, 2),
('Arizona', 2, 2),
('Arkansas', 2, 2),
('California', 2, 2),
('Colorado', 2, 2),
('Connecticut', 2, 2),
('Delaware', 2, 2),
('District of Columbia', 2, 2), -- Not technically a state!
('Florida', 2, 2),
('Georgia', 2, 2),
('Hawaii', 2, 2),
('Idaho', 2, 2),
('Illinois', 2, 2),
('Indiana', 2, 2),
('Iowa', 2, 2),
('Kansas', 2, 2),
('Kentucky', 2, 2),
('Louisiana', 2, 2),
('Maine', 2, 2),
('Maryland', 2, 2),
('Massachusetts', 2, 2),
('Michigan', 2, 2),
('Minnesota', 2, 2),
('Mississippi', 2, 2),
('Missouri', 2, 2),
('Montana', 2, 2),
('Nebraska', 2, 2),
('Nevada', 2, 2),
('New Hampshire', 2, 2),
('New Jersey', 2, 2),
('New Mexico', 2, 2),
('New York', 2, 2),
('North Carolina', 2, 2),
('North Dakota', 2, 2),
('Ohio', 2, 2),
('Oklahoma', 2, 2),
('Oregon', 2, 2),
('Pennsylvania', 2, 2),
('Rhode Island', 2, 2),
('South Carolina', 2, 2),
('South Dakota', 2, 2),
('Tennessee', 2, 2),
('Texas', 2, 2),
('Utah', 2, 2),
('Vermont', 2, 2),
('Virginia', 2, 2),
('Washington', 2, 2),
('West Virginia', 2, 2),
('Wisconsin', 2, 2),
('Wyoming', 2, 2),
('American Samoa', 2, 2), -- Territories
('Federated States of Micronesia', 2, 2),
('Marshall Islands', 2, 2),
('Northern Mariana Islands', 2, 2),
('Palau', 2, 2),
('Puerto Rico', 2, 2),
('Virgin Islands', 2, 2);

SET FOREIGN_KEY_CHECKS = 1;
