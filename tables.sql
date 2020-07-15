-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`authors`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`authors` (
                                                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                                                `phone` BIGINT UNSIGNED NOT NULL,
                                                `datetime_first_message` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                                `datetime_last_message` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                                `messages_count` INT UNSIGNED NOT NULL DEFAULT 1,
                                                `is_banned` TINYINT(1) NOT NULL DEFAULT 0,
                                                PRIMARY KEY (`id`)),
                                                CONSTRAINT authors_phone_uindex UNIQUE (phone)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`messages`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`messages` (
                                                 `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                                                 `authors_id` INT UNSIGNED NOT NULL,
                                                 `datetime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                                 `content` TEXT NULL,
                                                 `is_deleted` TINYINT(1) NOT NULL DEFAULT 0,
                                                 PRIMARY KEY (`id`),
                                                 INDEX `fk_messages_authors_idx` (`authors_id` ASC),
                                                 CONSTRAINT `fk_messages_authors`
                                                     FOREIGN KEY (`authors_id`)
                                                         REFERENCES `mydb`.`authors` (`id`)
                                                         ON DELETE NO ACTION
                                                         ON UPDATE NO ACTION)
    ENGINE = InnoDB;
