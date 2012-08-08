-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 08, 2012 at 10:10 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `uninoids`
--

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE IF NOT EXISTS `assessments` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_name` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `a_description` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `a_start_date` timestamp NULL DEFAULT NULL,
  `a_due_date` timestamp NULL DEFAULT NULL,
  `lg_id` int(11) NOT NULL,
  PRIMARY KEY (`a_id`,`lg_id`),
  KEY `fk_assessments_learning_groups1` (`lg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE IF NOT EXISTS `certificates` (
  `certificate_id` int(11) NOT NULL AUTO_INCREMENT,
  `certificate_name` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `eligibilty` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `email_notification` int(11) DEFAULT NULL,
  `sms_notification` int(11) DEFAULT NULL,
  `user_id` varchar(100) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`certificate_id`,`user_id`),
  KEY `fk_certificates_users1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('5408708d5ba024b4c39e5da465584c4f', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.60 Safari/537.1', 1344463264, 'a:5:{s:5:"token";s:832:"{"access_token":"ya29.AHES6ZTmRZpLvt3jnyjJhIVx_-K98H68sF6eLKxxeLOm3I4","token_type":"Bearer","expires_in":3600,"id_token":"eyJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJhY2NvdW50cy5nb29nbGUuY29tIiwiYXVkIjoiNTA0NjkzODU4MzcyLmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwiY2lkIjoiNTA0NjkzODU4MzcyLmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwiaWQiOiIxMDkzNjY4NDYzMjM4MjM4MzA5NjgiLCJlbWFpbCI6InN5c3RlbWFkbWluQGJpbmdoYW11bmkuZWR1Lm5nIiwidmVyaWZpZWRfZW1haWwiOiJ0cnVlIiwidG9rZW5faGFzaCI6Ind0RElFcERXMFNUUkJBeUdGMnUwTkEiLCJoZCI6ImJpbmdoYW11bmkuZWR1Lm5nIiwiaWF0IjoxMzQ0NDYxMjM2LCJleHAiOjEzNDQ0NjUxMzZ9.T040GQJ67WmSHeQ81wP5wt6OXvechAOUGWFqTFKAc04Y_ONTbAabpqXJEX-LXT21JJaTSrwgZjCpvPU0asV9sbFsj_k2ZVMnYFS2rs1jKge1Q-SGVgR44N0kEau6qm9V9KpQ-0xrIKRREJOfe4hsePF4eTGrG6w2sUs6hBMlY98","refresh_token":"1{{slash}}/fQcKt4FOvPtSwh9YFqpTQ2ePkA_YrDfVGXuGeJcLE38","created":1344461529}";s:7:"user_id";s:21:"109366846323823830968";s:13:"email_address";s:29:"systemadmin@binghamuni.edu.ng";s:13:"refresh_token";s:45:"1/fQcKt4FOvPtSwh9YFqpTQ2ePkA_YrDfVGXuGeJcLE38";s:7:"role_id";s:1:"2";}');

-- --------------------------------------------------------

--
-- Table structure for table `curriculums`
--

CREATE TABLE IF NOT EXISTS `curriculums` (
  `curriculum_id` int(11) NOT NULL AUTO_INCREMENT,
  `curriculum_name` varchar(128) COLLATE latin1_general_ci DEFAULT NULL,
  `status` enum('0','1') COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`curriculum_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `curriculums`
--

INSERT INTO `curriculums` (`curriculum_id`, `curriculum_name`, `status`) VALUES
(1, 'Google+', '1'),
(4, 'Drive', '1'),
(5, 'GMail', '1');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE IF NOT EXISTS `grades` (
  `grade_id` int(11) NOT NULL AUTO_INCREMENT,
  `score` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `regno` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `a_id` int(11) NOT NULL,
  PRIMARY KEY (`grade_id`,`a_id`),
  KEY `fk_grades_assessments1` (`a_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `learning_groups`
--

CREATE TABLE IF NOT EXISTS `learning_groups` (
  `lg_id` int(11) NOT NULL AUTO_INCREMENT,
  `lg_name` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `student_list` text COLLATE latin1_general_ci,
  `tutor_id` int(11) NOT NULL,
  PRIMARY KEY (`lg_id`,`tutor_id`),
  KEY `fk_learning_groups_tutors1` (`tutor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `scope` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `scope`) VALUES
(1, 'Students', 'student_access'),
(2, 'Tutors', 'tutor_access'),
(3, 'Administrator', 'admin_access');

-- --------------------------------------------------------

--
-- Table structure for table `tutors`
--

CREATE TABLE IF NOT EXISTS `tutors` (
  `tutor_id` int(11) NOT NULL AUTO_INCREMENT,
  `curriculum_id` int(11) NOT NULL,
  `tutor_email` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`tutor_id`,`curriculum_id`),
  KEY `fk_users_has_curriculums_curriculums1` (`curriculum_id`),
  KEY `fk_tutors_users1` (`tutor_email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`tutor_id`, `curriculum_id`, `tutor_email`) VALUES
(4, 1, 'systemadmin@binghamuni.edu.ng'),
(1, 5, 'uninoids@binghamuni.edu.ng'),
(2, 4, 'uninoids@binghamuni.edu.ng'),
(3, 1, 'uninoids@binghamuni.edu.ng');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `regno` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `first_name` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `email_address` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `gender` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `user_image_path` text COLLATE latin1_general_ci,
  `refresh_token` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  UNIQUE KEY `email_address_UNIQUE` (`email_address`),
  KEY `fk_users_roles` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `regno`, `first_name`, `last_name`, `email_address`, `gender`, `user_image_path`, `refresh_token`, `role_id`) VALUES
('108079731096436720499', NULL, 'Project', 'Uninoids', 'uninoids@binghamuni.edu.ng', NULL, '', '1/FBffidjsw8wELf8c71FP-WgtcdBgx-sI5cALFVekpx4', 3),
('109366846323823830968', NULL, 'Mfawa', 'Alfred Onen', 'systemadmin@binghamuni.edu.ng', 'male', 'https://lh3.googleusercontent.com/-q91PLPjtNCQ/AAAAAAAAAAI/AAAAAAAAACI/IRn8vEMDuj4/photo.jpg', '1/fQcKt4FOvPtSwh9YFqpTQ2ePkA_YrDfVGXuGeJcLE38', 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assessments`
--
ALTER TABLE `assessments`
  ADD CONSTRAINT `fk_assessments_learning_groups1` FOREIGN KEY (`lg_id`) REFERENCES `learning_groups` (`lg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `fk_certificates_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `fk_grades_assessments1` FOREIGN KEY (`a_id`) REFERENCES `assessments` (`a_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `learning_groups`
--
ALTER TABLE `learning_groups`
  ADD CONSTRAINT `fk_learning_groups_tutors1` FOREIGN KEY (`tutor_id`) REFERENCES `tutors` (`tutor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tutors`
--
ALTER TABLE `tutors`
  ADD CONSTRAINT `fk_tutors_users1` FOREIGN KEY (`tutor_email`) REFERENCES `users` (`email_address`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_has_curriculums_curriculums1` FOREIGN KEY (`curriculum_id`) REFERENCES `curriculums` (`curriculum_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
