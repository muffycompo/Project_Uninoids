SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `uninoids` ;
CREATE SCHEMA IF NOT EXISTS `uninoids` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `uninoids` ;

-- -----------------------------------------------------
-- Table `uninoids`.`role`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`role` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`role` (
  `role_id` INT NOT NULL AUTO_INCREMENT ,
  `role_name` VARCHAR(50) NULL ,
  `scope` VARCHAR(255) NULL ,
  PRIMARY KEY (`role_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `uninoids`.`profile`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`profile` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`profile` (
  `profile_id` INT NOT NULL AUTO_INCREMENT ,
  `email_address` VARCHAR(255) NOT NULL ,
  `password` VARCHAR(255) NULL ,
  `surname` VARCHAR(50) NULL ,
  `firstname` VARCHAR(50) NULL ,
  `access_token` VARCHAR(255) NULL ,
  `refresh_token` VARCHAR(255) NULL ,
  `role_id` INT NOT NULL ,
  `regno` VARCHAR(50) NULL ,
  PRIMARY KEY (`profile_id`, `email_address`, `role_id`) ,
  INDEX `fk_profile_role` (`role_id` ASC) ,
  CONSTRAINT `fk_profile_role`
    FOREIGN KEY (`role_id` )
    REFERENCES `uninoids`.`role` (`role_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `uninoids`.`products_services`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`products_services` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`products_services` (
  `ps_id` INT NOT NULL AUTO_INCREMENT ,
  `ps_name` VARCHAR(50) NULL ,
  PRIMARY KEY (`ps_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `uninoids`.`curriculum`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`curriculum` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`curriculum` (
  `curriculum_id` INT NOT NULL AUTO_INCREMENT ,
  `curriculum_name` VARCHAR(128) NULL ,
  `tutor_email` VARCHAR(255) NULL ,
  `curriculum_list` TEXT NULL ,
  PRIMARY KEY (`curriculum_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `uninoids`.`learning_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`learning_group` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`learning_group` (
  `lg_id` INT NOT NULL AUTO_INCREMENT ,
  `lg_name` VARCHAR(128) NULL ,
  `instructor_email` VARCHAR(255) NULL ,
  `students_email_list` TEXT NULL ,
  `curriculum_id` INT NOT NULL ,
  PRIMARY KEY (`lg_id`) ,
  INDEX `fk_learning_group_curriculum1` (`curriculum_id` ASC) ,
  CONSTRAINT `fk_learning_group_curriculum1`
    FOREIGN KEY (`curriculum_id` )
    REFERENCES `uninoids`.`curriculum` (`curriculum_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `uninoids`.`grades`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`grades` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`grades` (
  `grade_id` INT NOT NULL ,
  `score` VARCHAR(10) NULL ,
  `regno` VARCHAR(50) NULL ,
  `a_id` INT NOT NULL ,
  PRIMARY KEY (`grade_id`, `a_id`) ,
  INDEX `fk_grades_assessments1` (`a_id` ASC) ,
  CONSTRAINT `fk_grades_assessments1`
    FOREIGN KEY (`a_id` )
    REFERENCES `uninoids`.`assessments` (`a_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `uninoids`.`assessment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`assessment` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`assessment` (
  `assessment_id` INT NOT NULL AUTO_INCREMENT ,
  `assessment_name` VARCHAR(128) NULL ,
  `assessment_score` DOUBLE NULL ,
  `completion_status` INT NULL ,
  `lg_id` INT NOT NULL ,
  PRIMARY KEY (`assessment_id`, `lg_id`) ,
  INDEX `fk_assessment_learning_group1` (`lg_id` ASC) ,
  CONSTRAINT `fk_assessment_learning_group1`
    FOREIGN KEY (`lg_id` )
    REFERENCES `uninoids`.`learning_group` (`lg_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `uninoids`.`certificates`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`certificates` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`certificates` (
  `certificate_id` INT NOT NULL AUTO_INCREMENT ,
  `certificate_name` VARCHAR(100) NULL ,
  `regno` VARCHAR(50) NULL ,
  `eligibility` VARCHAR(50) NULL ,
  `email_notification` INT NULL ,
  `sms_notification` INT NULL ,
  PRIMARY KEY (`certificate_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `uninoids`.`roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`roles` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`roles` (
  `role_id` INT NOT NULL AUTO_INCREMENT ,
  `role_name` VARCHAR(50) NULL ,
  PRIMARY KEY (`role_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `uninoids`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`users` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`users` (
  `user_id` VARCHAR(100) NOT NULL ,
  `regno` VARCHAR(50) NULL ,
  `first_name` VARCHAR(50) NULL ,
  `last_name` VARCHAR(50) NULL ,
  `email_address` VARCHAR(255) NULL ,
  `role_id` INT NOT NULL ,
  `refresh_token` VARCHAR(200) NULL ,
  PRIMARY KEY (`user_id`, `role_id`) ,
  INDEX `fk_users_roles1` (`role_id` ASC) ,
  CONSTRAINT `fk_users_roles1`
    FOREIGN KEY (`role_id` )
    REFERENCES `uninoids`.`roles` (`role_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `uninoids`.`learning_groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`learning_groups` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`learning_groups` (
  `lg_id` INT NOT NULL AUTO_INCREMENT ,
  `lg_name` VARCHAR(100) NULL ,
  `student_list` TEXT NULL ,
  PRIMARY KEY (`lg_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `uninoids`.`assessments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`assessments` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`assessments` (
  `a_id` INT NOT NULL AUTO_INCREMENT ,
  `a_name` VARCHAR(100) NULL ,
  `a_description` VARCHAR(200) NULL ,
  `a_start_date` TIMESTAMP NULL ,
  `a_due_date` TIMESTAMP NULL ,
  `lg_id` INT NOT NULL ,
  PRIMARY KEY (`a_id`) ,
  INDEX `fk_assessments_learning_groups1` (`lg_id` ASC) ,
  CONSTRAINT `fk_assessments_learning_groups1`
    FOREIGN KEY (`lg_id` )
    REFERENCES `uninoids`.`learning_groups` (`lg_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `uninoids`.`curriculums`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`curriculums` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`curriculums` (
  `curriculum_id` INT NOT NULL AUTO_INCREMENT ,
  `curriculum_name` VARCHAR(128) NULL ,
  PRIMARY KEY (`curriculum_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `uninoids`.`tutors`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`tutors` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`tutors` (
  `user_id` VARCHAR(100) NOT NULL ,
  `role_id` INT NOT NULL ,
  `curriculum_id` INT NOT NULL ,
  PRIMARY KEY (`user_id`, `role_id`, `curriculum_id`) ,
  INDEX `fk_users_has_curriculums_curriculums1` (`curriculum_id` ASC) ,
  INDEX `fk_users_has_curriculums_users1` (`user_id` ASC, `role_id` ASC) ,
  CONSTRAINT `fk_users_has_curriculums_users1`
    FOREIGN KEY (`user_id` , `role_id` )
    REFERENCES `uninoids`.`users` (`user_id` , `role_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_curriculums_curriculums1`
    FOREIGN KEY (`curriculum_id` )
    REFERENCES `uninoids`.`curriculums` (`curriculum_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `uninoids`.`grades`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`grades` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`grades` (
  `grade_id` INT NOT NULL ,
  `score` VARCHAR(10) NULL ,
  `regno` VARCHAR(50) NULL ,
  `a_id` INT NOT NULL ,
  PRIMARY KEY (`grade_id`, `a_id`) ,
  INDEX `fk_grades_assessments1` (`a_id` ASC) ,
  CONSTRAINT `fk_grades_assessments1`
    FOREIGN KEY (`a_id` )
    REFERENCES `uninoids`.`assessments` (`a_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `uninoids`.`certificates`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`certificates` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`certificates` (
  `certificate_id` INT NOT NULL AUTO_INCREMENT ,
  `certificate_name` VARCHAR(100) NULL ,
  `regno` VARCHAR(50) NULL ,
  `eligibility` VARCHAR(50) NULL ,
  `email_notification` INT NULL ,
  `sms_notification` INT NULL ,
  PRIMARY KEY (`certificate_id`) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
