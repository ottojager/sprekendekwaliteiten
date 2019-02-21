CREATE TABLE cards (
	ID int AUTO_INCREMENT PRIMARY KEY NOT NULL,
	name varchar(30) NOT NULL,
	type INT(1) NOT NULL DEFAULT '1'
);

CREATE TABLE users (
	id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
	username VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	password VARCHAR(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
);

/* Gotta love the different format here */
CREATE TABLE `kwaliteiten`.`config` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(50) NOT NULL , `value` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;