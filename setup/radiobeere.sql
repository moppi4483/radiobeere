CREATE USER 'radiobeere'@'localhost' IDENTIFIED BY 'password';
REVOKE ALL PRIVILEGES ON * . * FROM  'radiobeere'@'localhost';
REVOKE GRANT OPTION ON * . * FROM  'radiobeere'@'localhost';
GRANT SELECT , 
INSERT ,
UPDATE ,
DELETE ,
CREATE ,
DROP ,
FILE ,
INDEX ,
ALTER ,
CREATE TEMPORARY TABLES ,
CREATE VIEW ,
EVENT ,
TRIGGER ,
SHOW VIEW ,
CREATE ROUTINE ,
ALTER ROUTINE ,
EXECUTE ON * . * TO  'radiobeere'@'localhost' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;

create database radiobeere;
use radiobeere;

CREATE TABLE  `aufnahmen` (
 `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
 `datum` DATE NOT NULL ,
 `uhrzeit` TIME NOT NULL ,
 `sender` VARCHAR( 50 ) CHARACTER SET utf8 NOT NULL ,
 `datei` VARCHAR( 100 ) CHARACTER SET utf8 NOT NULL ,
 `zeitstempel` INT( 20 ) NOT NULL ,
 `laenge` VARCHAR( 8 ) CHARACTER SET utf8 NOT NULL ,
 `bytes` INT( 20 ) NOT NULL ,
 `pubdate` VARCHAR( 40 ) CHARACTER SET utf8 NOT NULL ,
PRIMARY KEY (  `id` )
) ENGINE = INNODB DEFAULT CHARSET = latin1;

CREATE TABLE  `sender` (
 `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
 `alias` VARCHAR( 50 ) CHARACTER SET utf8 NOT NULL ,
 `name` VARCHAR( 50 ) CHARACTER SET utf8 NOT NULL ,
 `url` VARCHAR( 500 ) CHARACTER SET utf8 NOT NULL ,
PRIMARY KEY (  `id` )
) ENGINE = INNODB DEFAULT CHARSET = latin1;

CREATE TABLE  `settings` (
 `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
 `name` VARCHAR( 50 ) CHARACTER SET utf8 NOT NULL ,
 `wert` VARCHAR( 500 ) CHARACTER SET utf8 NOT NULL ,
PRIMARY KEY (  `id` )
) ENGINE = INNODB DEFAULT CHARSET = latin1;

CREATE TABLE  `timer` (
 `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
 `sender` VARCHAR( 50 ) CHARACTER SET utf8 NOT NULL ,
 `alias` VARCHAR( 50 ) CHARACTER SET utf8 NOT NULL ,
 `stunde` VARCHAR( 2 ) CHARACTER SET utf8 NOT NULL ,
 `minute` VARCHAR( 2 ) CHARACTER SET utf8 NOT NULL ,
 `wochentage` VARCHAR( 20 ) CHARACTER SET utf8 NOT NULL ,
 `dauer` VARCHAR( 10 ) CHARACTER SET utf8 NOT NULL ,
 `tag` VARCHAR( 2 ) CHARACTER SET utf8 NOT NULL ,
 `monat` VARCHAR( 2 ) CHARACTER SET utf8 NOT NULL ,
 `zeitstempel` INT( 20 ) NOT NULL ,
PRIMARY KEY (  `id` )
) ENGINE = INNODB DEFAULT CHARSET = latin1;
