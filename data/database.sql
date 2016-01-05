-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema fab
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema fab
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `fab` DEFAULT CHARACTER SET utf8 ;
USE `fab` ;

-- -----------------------------------------------------
-- Table `fab`.`location`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fab`.`location` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `lat` INT NOT NULL,
  `lng` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fab`.`adress`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fab`.`adress` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `street` VARCHAR(80) NULL,
  `number` INT NULL,
  `city` VARCHAR(80) NULL,
  `postalCode` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  `location_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_adress_location1_idx` (`location_id` ASC),
  CONSTRAINT `fk_adress_location1`
    FOREIGN KEY (`location_id`)
    REFERENCES `fab`.`location` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fab`.`creation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fab`.`creation` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fab`.`group`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fab`.`group` (
  `id` INT NOT NULL,
  `name` VARCHAR(80) NULL,
  `active` TINYINT(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fab`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fab`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `email` VARCHAR(80) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  `firstName` VARCHAR(60) NULL,
  `lastName` VARCHAR(60) NULL,
  `adress_id` INT NOT NULL,
  `creation_id` INT NOT NULL,
  `group_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  INDEX `fk_users_adress_idx` (`adress_id` ASC),
  INDEX `fk_user_creation1_idx` (`creation_id` ASC),
  INDEX `fk_user_group1_idx` (`group_id` ASC),
  CONSTRAINT `fk_users_adress`
    FOREIGN KEY (`adress_id`)
    REFERENCES `fab`.`adress` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_creation1`
    FOREIGN KEY (`creation_id`)
    REFERENCES `fab`.`creation` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_group1`
    FOREIGN KEY (`group_id`)
    REFERENCES `fab`.`group` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fab`.`fab`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fab`.`fab` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `imgURL` VARCHAR(255) NULL,
  `adress_id` INT NOT NULL,
  `location_id` INT NOT NULL,
  `creation_id` INT NOT NULL,
  `group_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_fab_adress1_idx` (`adress_id` ASC),
  INDEX `fk_fab_location1_idx` (`location_id` ASC),
  INDEX `fk_fab_creation1_idx` (`creation_id` ASC),
  INDEX `fk_fab_group1_idx` (`group_id` ASC),
  CONSTRAINT `fk_fab_adress1`
    FOREIGN KEY (`adress_id`)
    REFERENCES `fab`.`adress` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_fab_location1`
    FOREIGN KEY (`location_id`)
    REFERENCES `fab`.`location` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_fab_creation1`
    FOREIGN KEY (`creation_id`)
    REFERENCES `fab`.`creation` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_fab_group1`
    FOREIGN KEY (`group_id`)
    REFERENCES `fab`.`group` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fab`.`role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fab`.`role` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fab`.`users_has_role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fab`.`users_has_role` (
  `users_id` INT NOT NULL,
  `role_id` INT NOT NULL,
  PRIMARY KEY (`users_id`, `role_id`),
  INDEX `fk_users_has_role_role1_idx` (`role_id` ASC),
  INDEX `fk_users_has_role_users1_idx` (`users_id` ASC),
  CONSTRAINT `fk_users_has_role_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `fab`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_role_role1`
    FOREIGN KEY (`role_id`)
    REFERENCES `fab`.`role` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fab`.`result`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fab`.`result` (
  `id` INT NOT NULL,
  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fab`.`status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fab`.`status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fab`.`result_has_status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fab`.`result_has_status` (
  `results_id` INT NOT NULL,
  `status_id` INT NOT NULL,
  PRIMARY KEY (`results_id`, `status_id`),
  INDEX `fk_results_has_status_status1_idx` (`status_id` ASC),
  INDEX `fk_results_has_status_results1_idx` (`results_id` ASC),
  CONSTRAINT `fk_results_has_status_results1`
    FOREIGN KEY (`results_id`)
    REFERENCES `fab`.`result` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_results_has_status_status1`
    FOREIGN KEY (`status_id`)
    REFERENCES `fab`.`status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fab`.`fab_has_result`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fab`.`fab_has_result` (
  `fab_id` INT NOT NULL,
  `results_id` INT NOT NULL,
  PRIMARY KEY (`fab_id`, `results_id`),
  INDEX `fk_fab_has_results_results1_idx` (`results_id` ASC),
  INDEX `fk_fab_has_results_fab1_idx` (`fab_id` ASC),
  CONSTRAINT `fk_fab_has_results_fab1`
    FOREIGN KEY (`fab_id`)
    REFERENCES `fab`.`fab` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_fab_has_results_results1`
    FOREIGN KEY (`results_id`)
    REFERENCES `fab`.`result` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fab`.`type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fab`.`type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  `color` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fab`.`userLog`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fab`.`userLog` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `text` MEDIUMTEXT NOT NULL,
  `user_id` INT NOT NULL,
  `date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `type_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_userLog_user1_idx` (`user_id` ASC),
  INDEX `fk_userLog_type1_idx` (`type_id` ASC),
  CONSTRAINT `fk_userLog_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `fab`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_userLog_type1`
    FOREIGN KEY (`type_id`)
    REFERENCES `fab`.`type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fab`.`fabLog`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fab`.`fabLog` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `text` MEDIUMTEXT NOT NULL,
  `fab_id` INT NOT NULL,
  `date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `type_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_fabLog_fab1_idx` (`fab_id` ASC),
  INDEX `fk_fabLog_type1_idx` (`type_id` ASC),
  CONSTRAINT `fk_fabLog_fab1`
    FOREIGN KEY (`fab_id`)
    REFERENCES `fab`.`fab` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_fabLog_type1`
    FOREIGN KEY (`type_id`)
    REFERENCES `fab`.`type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
