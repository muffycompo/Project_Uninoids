SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `uninoids` ;
CREATE SCHEMA IF NOT EXISTS `uninoids` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci ;
USE `uninoids` ;

-- -----------------------------------------------------
-- Table `uninoids`.`roles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uninoids`.`roles` (
  `role_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `role_name` VARCHAR(50) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  PRIMARY KEY (`role_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `uninoids`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uninoids`.`users` (
  `user_id` VARCHAR(100) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NOT NULL ,
  `regno` VARCHAR(50) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  `first_name` VARCHAR(50) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  `last_name` VARCHAR(50) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  `email_address` VARCHAR(255) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NOT NULL ,
  `twitter_username` VARCHAR(100) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  `gender` VARCHAR(10) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  `user_image_path` TEXT CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  `refresh_token` VARCHAR(200) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  `role_id` INT(11) NOT NULL ,
  PRIMARY KEY (`user_id`, `role_id`) ,
  UNIQUE INDEX `email_address_UNIQUE` (`email_address` ASC) ,
  INDEX `fk_users_roles` (`role_id` ASC) ,
  CONSTRAINT `fk_users_roles`
    FOREIGN KEY (`role_id` )
    REFERENCES `uninoids`.`roles` (`role_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `uninoids`.`curriculums`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uninoids`.`curriculums` (
  `curriculum_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `curriculum_name` VARCHAR(128) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  `status` ENUM('1','2') CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NOT NULL DEFAULT '1' ,
  PRIMARY KEY (`curriculum_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `uninoids`.`tutors`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uninoids`.`tutors` (
  `tutor_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `curriculum_id` INT(11) NOT NULL ,
  `tutor_email` VARCHAR(255) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NOT NULL ,
  PRIMARY KEY (`tutor_id`, `curriculum_id`) ,
  INDEX `fk_users_has_curriculums_curriculums` (`curriculum_id` ASC) ,
  INDEX `fk_tutors_users` (`tutor_email` ASC) ,
  CONSTRAINT `fk_tutors_users`
    FOREIGN KEY (`tutor_email` )
    REFERENCES `uninoids`.`users` (`email_address` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_curriculums_curriculums`
    FOREIGN KEY (`curriculum_id` )
    REFERENCES `uninoids`.`curriculums` (`curriculum_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `uninoids`.`learning_groups`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uninoids`.`learning_groups` (
  `lg_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `lg_name` VARCHAR(100) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  `student_list` TEXT CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  `lg_folder_reference` VARCHAR(200) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NOT NULL ,
  `lg_email` VARCHAR(255) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NOT NULL ,
  `tutor_id` INT(11) NOT NULL ,
  PRIMARY KEY (`lg_id`, `tutor_id`) ,
  INDEX `fk_learning_groups_tutors` (`tutor_id` ASC) ,
  CONSTRAINT `fk_learning_groups_tutors`
    FOREIGN KEY (`tutor_id` )
    REFERENCES `uninoids`.`tutors` (`tutor_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `uninoids`.`assessments`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uninoids`.`assessments` (
  `a_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `a_name` VARCHAR(100) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  `a_description` VARCHAR(200) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  `a_file_id` VARCHAR(200) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  `a_file_url` TEXT CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  `a_due_date` BIGINT(20) NULL DEFAULT NULL ,
  `lg_id` INT(11) NOT NULL ,
  PRIMARY KEY (`a_id`, `lg_id`) ,
  INDEX `fk_assessments_learning_groups` (`lg_id` ASC) ,
  CONSTRAINT `fk_assessments_learning_groups`
    FOREIGN KEY (`lg_id` )
    REFERENCES `uninoids`.`learning_groups` (`lg_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `uninoids`.`certificates`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uninoids`.`certificates` (
  `certificate_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `email_notification` INT(11) NULL DEFAULT '0' ,
  `sms_notification` INT(11) NULL DEFAULT '0' ,
  `a_id` INT(11) NOT NULL ,
  `status` INT(11) NOT NULL DEFAULT '1' ,
  `user_email` VARCHAR(255) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NOT NULL ,
  PRIMARY KEY (`certificate_id`) ,
  INDEX `fk_certificates_users` (`user_email` ASC) ,
  CONSTRAINT `fk_certificates_users`
    FOREIGN KEY (`user_email` )
    REFERENCES `uninoids`.`users` (`email_address` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `uninoids`.`ci_sessions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uninoids`.`ci_sessions` (
  `session_id` VARCHAR(40) NOT NULL DEFAULT '0' ,
  `ip_address` VARCHAR(45) NOT NULL DEFAULT '0' ,
  `user_agent` VARCHAR(120) NOT NULL ,
  `last_activity` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
  `user_data` TEXT NOT NULL ,
  PRIMARY KEY (`session_id`) ,
  INDEX `last_activity_idx` (`last_activity` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `uninoids`.`grades`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uninoids`.`grades` (
  `grade_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `score` FLOAT NULL DEFAULT NULL ,
  `regno` VARCHAR(50) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  `student_email` VARCHAR(255) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  `status` INT(3) NOT NULL DEFAULT '2' ,
  `a_id` INT(11) NOT NULL ,
  PRIMARY KEY (`grade_id`, `a_id`) ,
  INDEX `fk_grades_assessments` (`a_id` ASC) ,
  CONSTRAINT `fk_grades_assessments1`
    FOREIGN KEY (`a_id` )
    REFERENCES `uninoids`.`assessments` (`a_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;


-- -----------------------------------------------------
-- Table `uninoids`.`study_materials`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `uninoids`.`study_materials` (
  `sm_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `sm_title` VARCHAR(255) CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  `sm_url` TEXT CHARACTER SET 'latin1' COLLATE 'latin1_general_ci' NULL DEFAULT NULL ,
  `curriculum_id` INT(11) NOT NULL ,
  PRIMARY KEY (`sm_id`, `curriculum_id`) ,
  INDEX `fk_study_materials_curriculums` (`curriculum_id` ASC) ,
  CONSTRAINT `fk_study_materials_curriculums`
    FOREIGN KEY (`curriculum_id` )
    REFERENCES `uninoids`.`curriculums` (`curriculum_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `uninoids`.`roles`
-- -----------------------------------------------------
START TRANSACTION;
USE `uninoids`;
INSERT INTO `uninoids`.`roles` (`role_id`, `role_name`) VALUES (1, 'Student');
INSERT INTO `uninoids`.`roles` (`role_id`, `role_name`) VALUES (2, 'Tutor');
INSERT INTO `uninoids`.`roles` (`role_id`, `role_name`) VALUES (3, 'Administrator');

COMMIT;
