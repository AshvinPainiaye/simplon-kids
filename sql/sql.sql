
CREATE TABLE IF NOT EXISTS `public_age` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `start` INT(3) NOT NULL,
  `end` INT(3) NOT NULL)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `address` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `address` VARCHAR(255) NOT NULL,
  `complement` VARCHAR(255) NULL,
  `city` VARCHAR(255) NOT NULL,
  `zipcode` VARCHAR(5) NOT NULL)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `establishment` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `address_id` INT NOT NULL,
  CONSTRAINT `fk_establishment_address1`
    FOREIGN KEY (`address_id`)
    REFERENCES `address` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `workshop_category` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `workshop` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `price` DECIMAL(5,2) NOT NULL,
  `max_kids` INT(3) NOT NULL,
  `image` VARCHAR(255) NULL,
  `visible` TINYINT NULL,
  `public_age_id` INT NOT NULL,
  `establishment_id` INT NOT NULL,
  `workshop_category_id` INT NOT NULL,
  CONSTRAINT `fk_workshop_public_age`
    FOREIGN KEY (`public_age_id`)
    REFERENCES `public_age` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_workshop_establishment1`
    FOREIGN KEY (`establishment_id`)
    REFERENCES `establishment` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_workshop_workshop_category1`
    FOREIGN KEY (`workshop_category_id`)
    REFERENCES `workshop_category` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `timetable` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `startAt` DATETIME NOT NULL,
  `endAt` DATETIME NOT NULL,
  `enable` TINYINT NULL,
  `workshop_id` INT NOT NULL,
  CONSTRAINT `fk_timetable_workshop1`
    FOREIGN KEY (`workshop_id`)
    REFERENCES `workshop` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `parent` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `firstname` VARCHAR(255) NOT NULL,
  `lastname` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `address_id` INT NOT NULL,
  `phone` VARCHAR(20) NULL,
  CONSTRAINT `fk_parent_address1`
    FOREIGN KEY (`address_id`)
    REFERENCES `address` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `kid` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `firstname` VARCHAR(255) NOT NULL,
  `lastname` VARCHAR(255) NOT NULL,
  `birthday` DATE NOT NULL,
  `classroom` VARCHAR(255) NULL)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `workshop_has_kid` (
  `workshop_id` INT NOT NULL,
  `kid_id` INT NOT NULL,
  `has_participated` TINYINT NULL,
  `validated` TINYINT NULL,
  PRIMARY KEY (`workshop_id`, `kid_id`),
  CONSTRAINT `fk_workshop_has_kid_workshop1`
    FOREIGN KEY (`workshop_id`)
    REFERENCES `workshop` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_workshop_has_kid_kid1`
    FOREIGN KEY (`kid_id`)
    REFERENCES `kid` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `kid_has_parent` (
  `kid_id` INT NOT NULL,
  `parent_id` INT NOT NULL,
  PRIMARY KEY (`kid_id`, `parent_id`),
  CONSTRAINT `fk_kid_has_parent_kid1`
    FOREIGN KEY (`kid_id`)
    REFERENCES `kid` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_kid_has_parent_parent1`
    FOREIGN KEY (`parent_id`)
    REFERENCES `parent` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `admin` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL)
ENGINE = InnoDB;






INSERT INTO `public_age` (`start`, `end`) VALUES
(1, 18),(10, 18),(8, 13),(4, 9),(10, 15);


INSERT INTO `address` (`address`,`complement`,`city`,`zipcode`) VALUES
('15 rue des saphirs','', 'Sainte-Suzanne', 97441),('10 rue des goyave','', 'Saint-Denis', 97400),('Avenue des letchi','', 'Saint-Pierre', 97410), ('Rue des kebab','chemin 4', 'Saint-André', 97490);


INSERT INTO `establishment` (`name`,`address_id`) VALUES
('College Quartier Francais', 2), ('College Lucet', 3), ('Ecole 2 canon', 4);


INSERT INTO `workshop_category` (`name`) VALUES
('ART'), ('Jeux video'), ('Detente'), ('Logique');

INSERT INTO `workshop` (`title`, `description`, `price`, `max_kids`, `image`, `visible`, `public_age_id`, `establishment_id`, `workshop_category_id`) VALUES
('HTML', 'Debuter en html', 10, 18, '1.jpg', true, 1, 1, 1);


INSERT INTO `timetable` (`startAt`,`endAt`,`enable`,`workshop_id`) VALUES
('2017-05-09 08:30', '2017-05-09 16:30', true, 1);


INSERT INTO `parent` (`firstname`,`lastname`,`email`,`address_id`, `phone`) VALUES
('Jane', 'Doe', 'jane@doe.com', 1, '+262692123456');


INSERT INTO `kid` (`firstname`, `lastname`, `birthday`,`classroom`) VALUES
('John', 'Doe', '2008-02-19', 'CM2');


INSERT INTO `workshop_has_kid` (`workshop_id`,`kid_id`, `has_participated`, `validated`) VALUES
(1, 1, null, null);


INSERT INTO `kid_has_parent` (`kid_id`,`parent_id`) VALUES
(1, 1);

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', SHA1('test'));
