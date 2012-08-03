SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `uninoids` ;
CREATE SCHEMA IF NOT EXISTS `uninoids` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci ;
USE `uninoids` ;

-- -----------------------------------------------------
-- Table `uninoids`.`roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`roles` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`roles` (
  `role_id` INT NOT NULL AUTO_INCREMENT ,
  `role_name` VARCHAR(50) NULL ,
  `scope` VARCHAR(255) NULL ,
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
  `refresh_token` VARCHAR(200) NULL ,
  `role_id` INT NOT NULL ,
  PRIMARY KEY (`user_id`, `role_id`) ,
  INDEX `fk_users_roles` (`role_id` ASC) ,
  CONSTRAINT `fk_users_roles`
    FOREIGN KEY (`role_id` )
    REFERENCES `uninoids`.`roles` (`role_id` )
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
  `curriculum_id` INT NOT NULL ,
  `tutor_id` INT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`tutor_id`, `user_id`, `curriculum_id`) ,
  INDEX `fk_users_has_curriculums_curriculums1` (`curriculum_id` ASC) ,
  INDEX `fk_users_has_curriculums_users1` (`user_id` ASC) ,
  CONSTRAINT `fk_users_has_curriculums_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `uninoids`.`users` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_curriculums_curriculums1`
    FOREIGN KEY (`curriculum_id` )
    REFERENCES `uninoids`.`curriculums` (`curriculum_id` )
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
  `tutor_id` INT NOT NULL ,
  PRIMARY KEY (`lg_id`, `tutor_id`) ,
  INDEX `fk_learning_groups_tutors1` (`tutor_id` ASC) ,
  CONSTRAINT `fk_learning_groups_tutors1`
    FOREIGN KEY (`tutor_id` )
    REFERENCES `uninoids`.`tutors` (`tutor_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
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
  PRIMARY KEY (`a_id`, `lg_id`) ,
  INDEX `fk_assessments_learning_groups1` (`lg_id` ASC) ,
  CONSTRAINT `fk_assessments_learning_groups1`
    FOREIGN KEY (`lg_id` )
    REFERENCES `uninoids`.`learning_groups` (`lg_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `uninoids`.`grades`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`grades` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`grades` (
  `grade_id` INT NOT NULL AUTO_INCREMENT ,
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
  `eligibilty` VARCHAR(50) NULL ,
  `email_notification` INT NULL ,
  `sms_notification` INT NULL ,
  `user_id` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`certificate_id`, `user_id`) ,
  INDEX `fk_certificates_users1` (`user_id` ASC) ,
  CONSTRAINT `fk_certificates_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `uninoids`.`users` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `uninoids`.`ci_sessions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uninoids`.`ci_sessions` ;

CREATE  TABLE IF NOT EXISTS `uninoids`.`ci_sessions` (
  `session_id` VARCHAR(40) NOT NULL DEFAULT '0' ,
  `ip_address` VARCHAR(45) NOT NULL DEFAULT '0' ,
  `user_agent` VARCHAR(120) NOT NULL ,
  `last_activity` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
  `user_data` TEXT NOT NULL ,
  PRIMARY KEY (`session_id`) ,
  INDEX `last_activity_idx` (`last_activity` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `uninoids`.`roles`
-- -----------------------------------------------------
START TRANSACTION;
USE `uninoids`;
INSERT INTO `uninoids`.`roles` (`role_id`, `role_name`, `scope`) VALUES (1, 'Students', 'student_access');
INSERT INTO `uninoids`.`roles` (`role_id`, `role_name`, `scope`) VALUES (2, 'Tutors', 'tutor_access');
INSERT INTO `uninoids`.`roles` (`role_id`, `role_name`, `scope`) VALUES (3, 'Administrators', 'admin_access');

COMMIT;
