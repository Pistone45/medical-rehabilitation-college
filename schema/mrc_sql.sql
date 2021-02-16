-- MariaDB dump 10.17  Distrib 10.4.13-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: medical-rehabilitation
-- ------------------------------------------------------
-- Server version	10.4.13-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accountants`
--

DROP TABLE IF EXISTS `accountants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accountants` (
  `staff_id` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `phone` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `qualification` varchar(255) NOT NULL,
  `experience` int(10) NOT NULL,
  `gender` varchar(45) NOT NULL,
  `date_added` date NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) NOT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accountants`
--

LOCK TABLES `accountants` WRITE;
/*!40000 ALTER TABLE `accountants` DISABLE KEYS */;
INSERT INTO `accountants` VALUES ('AA1','Pistone',NULL,'Sanjama','2020-10-07','+265882550227','pistonsanjama45@gmail.com','Degree',5,'Female','2020-10-08','../images/accountants/unnamed.jpg','Malawian');
/*!40000 ALTER TABLE `accountants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `username` varchar(255) NOT NULL,
  `date_added` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES (7,'Fees Balance','All fees balances should be cleared within two weeks','admin','2021-02-10');
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (5,'North'),(6,'West');
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes_has_modules`
--

DROP TABLE IF EXISTS `classes_has_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classes_has_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classes_id` int(11) NOT NULL,
  `modules_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_classes_has_modules_modules1_idx` (`modules_id`),
  KEY `fk_classes_has_modules_classes1_idx` (`classes_id`),
  CONSTRAINT `fk_classes_has_modules_classes1` FOREIGN KEY (`classes_id`) REFERENCES `classes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_classes_has_modules_modules1` FOREIGN KEY (`modules_id`) REFERENCES `modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes_has_modules`
--

LOCK TABLES `classes_has_modules` WRITE;
/*!40000 ALTER TABLE `classes_has_modules` DISABLE KEYS */;
INSERT INTO `classes_has_modules` VALUES (12,5,12),(13,6,13);
/*!40000 ALTER TABLE `classes_has_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_calendar`
--

DROP TABLE IF EXISTS `exam_calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `exam_date` date NOT NULL,
  `modules_id` int(11) NOT NULL,
  `classes_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`modules_id`),
  KEY `fk_exam_calendar_modules1_idx` (`modules_id`),
  KEY `fk_exam_calendar_classes1_idx` (`classes_id`),
  CONSTRAINT `fk_exam_calendar_classes1` FOREIGN KEY (`classes_id`) REFERENCES `classes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_exam_calendar_modules1` FOREIGN KEY (`modules_id`) REFERENCES `modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_calendar`
--

LOCK TABLES `exam_calendar` WRITE;
/*!40000 ALTER TABLE `exam_calendar` DISABLE KEYS */;
INSERT INTO `exam_calendar` VALUES (1,'08:31:00','10:30:00','2021-02-11',13,6);
/*!40000 ALTER TABLE `exam_calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fees`
--

DROP TABLE IF EXISTS `fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fees_type` varchar(45) DEFAULT NULL,
  `fees_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_fees_fees_type1_idx1` (`fees_type_id`),
  CONSTRAINT `fk_fees_fees_type1` FOREIGN KEY (`fees_type_id`) REFERENCES `fees_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fees`
--

LOCK TABLES `fees` WRITE;
/*!40000 ALTER TABLE `fees` DISABLE KEYS */;
/*!40000 ALTER TABLE `fees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fees_balances`
--

DROP TABLE IF EXISTS `fees_balances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fees_balances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `students_student_no` varchar(255) NOT NULL,
  `balance` decimal(50,2) NOT NULL,
  `remarks` text DEFAULT NULL,
  `date_recorded` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `fk_fees_balances_students1_idx1` (`students_student_no`),
  CONSTRAINT `fk_fees_balances_students1` FOREIGN KEY (`students_student_no`) REFERENCES `students` (`student_no`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fees_balances`
--

LOCK TABLES `fees_balances` WRITE;
/*!40000 ALTER TABLE `fees_balances` DISABLE KEYS */;
INSERT INTO `fees_balances` VALUES (1,'MRC/S/1',20000.00,'Outstanding balance','2021-02-10',0);
/*!40000 ALTER TABLE `fees_balances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fees_type`
--

DROP TABLE IF EXISTS `fees_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fees_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fees_type`
--

LOCK TABLES `fees_type` WRITE;
/*!40000 ALTER TABLE `fees_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `fees_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `students_student_no` varchar(255) NOT NULL,
  `grade` decimal(10,2) NOT NULL,
  `comments` text DEFAULT NULL,
  `year` year(4) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `date_recorded` date NOT NULL,
  `modules_id` int(11) NOT NULL,
  `classes_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`modules_id`),
  KEY `fk_grades_students1_idx` (`students_student_no`),
  KEY `fk_grades_modules1_idx` (`modules_id`),
  KEY `fk_grades_classes1_idx` (`classes_id`),
  CONSTRAINT `fk_grades_classes1` FOREIGN KEY (`classes_id`) REFERENCES `classes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_grades_modules1` FOREIGN KEY (`modules_id`) REFERENCES `modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_grades_students1` FOREIGN KEY (`students_student_no`) REFERENCES `students` (`student_no`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grades`
--

LOCK TABLES `grades` WRITE;
/*!40000 ALTER TABLE `grades` DISABLE KEYS */;
INSERT INTO `grades` VALUES (10,'MRC/S/1',75.00,NULL,2020,2,'2020-10-08',12,5),(11,'MRC/S/1',55.00,NULL,2020,2,'2020-10-10',13,6),(12,'MRC/S/1',50.00,NULL,2021,1,'2021-02-10',13,6);
/*!40000 ALTER TABLE `grades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materials`
--

DROP TABLE IF EXISTS `materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `material` varchar(255) NOT NULL,
  `modules_id` int(11) NOT NULL,
  `classes_id` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `date_added` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_materials_modules1_idx` (`modules_id`),
  KEY `fk_materials_classes1_idx` (`classes_id`),
  CONSTRAINT `fk_materials_classes1` FOREIGN KEY (`classes_id`) REFERENCES `classes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_materials_modules1` FOREIGN KEY (`modules_id`) REFERENCES `modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materials`
--

LOCK TABLES `materials` WRITE;
/*!40000 ALTER TABLE `materials` DISABLE KEYS */;
INSERT INTO `materials` VALUES (3,'Irrigation','../materials/test.docx',12,5,2020,2,'2020-10-08'),(4,'Photosynthesis','../materials/EMPLOYMENT APPLICATION FORM.docx',13,6,2020,2,'2020-10-10');
/*!40000 ALTER TABLE `materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_sent` date NOT NULL,
  `username` varchar(255) NOT NULL,
  `students_student_no` varchar(255) NOT NULL,
  `status` int(5) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_notifications_students1_idx` (`students_student_no`),
  CONSTRAINT `fk_notifications_students10` FOREIGN KEY (`students_student_no`) REFERENCES `students` (`student_no`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (12,'Networks'),(13,'BIology');
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notification` text NOT NULL,
  `date_sent` date NOT NULL,
  `username` varchar(255) NOT NULL,
  `students_student_no` varchar(255) NOT NULL,
  `status` int(5) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_notifications_students1_idx` (`students_student_no`),
  CONSTRAINT `fk_notifications_students1` FOREIGN KEY (`students_student_no`) REFERENCES `students` (`student_no`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin'),(2,'Teacher'),(3,'Student'),(4,'Accountant');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `semester`
--

DROP TABLE IF EXISTS `semester`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `semester` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `semester`
--

LOCK TABLES `semester` WRITE;
/*!40000 ALTER TABLE `semester` DISABLE KEYS */;
INSERT INTO `semester` VALUES (1,'First Semester'),(2,'Second Semester');
/*!40000 ALTER TABLE `semester` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` year(4) NOT NULL,
  `semester_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_settings_semester1_idx` (`semester_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,2021,1);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_old`
--

DROP TABLE IF EXISTS `settings_old`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_old` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` year(4) NOT NULL,
  `semester_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_settings_semester1_idx` (`semester_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_old`
--

LOCK TABLES `settings_old` WRITE;
/*!40000 ALTER TABLE `settings_old` DISABLE KEYS */;
INSERT INTO `settings_old` VALUES (1,2020,1),(2,2020,2),(3,2021,1);
/*!40000 ALTER TABLE `settings_old` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `student_no` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(45) NOT NULL,
  `nationality` varchar(45) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `classes_id` int(11) NOT NULL,
  PRIMARY KEY (`student_no`),
  KEY `fk_students_classes_idx` (`classes_id`),
  CONSTRAINT `fk_students_classes` FOREIGN KEY (`classes_id`) REFERENCES `classes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES ('MRC/S/1','Pistone',NULL,'Sanjama','2020-11-07','Male','Malawian','../images/students/logo.png','1','pistonsanjama45@gmail.com','2020-10-08','+265882550227',6);
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `qualification` varchar(255) NOT NULL,
  `experience` int(10) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `gender` varchar(45) NOT NULL,
  `date_added` date NOT NULL,
  `nationality` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
INSERT INTO `teachers` VALUES (5,'TT1','Pistone',NULL,'Sanjama','2020-10-07',NULL,'pistonsanjama45@gmail.com','Degree',1,'../images/teachers/undraw_Login_re_4vu2.png','Male','2020-10-08','Malawian');
/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(255) NOT NULL,
  `date_added` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team`
--

LOCK TABLES `team` WRITE;
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
/*!40000 ALTER TABLE `team` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timetable`
--

DROP TABLE IF EXISTS `timetable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `timetable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `timetable_date` date NOT NULL,
  `modules_id` int(11) NOT NULL,
  `classes_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_timetable_modules1_idx` (`modules_id`),
  KEY `fk_timetable_classes1_idx` (`classes_id`),
  CONSTRAINT `fk_timetable_classes1` FOREIGN KEY (`classes_id`) REFERENCES `classes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_timetable_modules1` FOREIGN KEY (`modules_id`) REFERENCES `modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timetable`
--

LOCK TABLES `timetable` WRITE;
/*!40000 ALTER TABLE `timetable` DISABLE KEYS */;
INSERT INTO `timetable` VALUES (1,'02:00:00','03:00:00','2021-02-10',12,5),(2,'13:00:00','14:00:00','2021-02-12',13,6);
/*!40000 ALTER TABLE `timetable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `status` varchar(45) NOT NULL DEFAULT '1',
  `password` varchar(255) NOT NULL,
  `date_added` date NOT NULL COMMENT 'This table will store information of all the Users in the system',
  `picture` varchar(255) DEFAULT NULL,
  `roles_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`roles_id`),
  KEY `fk_users_roles1_idx` (`roles_id`),
  CONSTRAINT `fk_users_roles1` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin','','admin','1','$2y$10$H/gqvUtrii6BR14NCbmS6.dFd.AQP3niPLMQrTHpwea6fXoDVsvk6','2020-06-22',NULL,1),(19,'MRC/S/1','Pistone',NULL,'Sanjama','1','$2y$10$0EcyCXBfa7EVfXGDya239.kki0vvQhvzg0mCXxcgxaQoz3Q8awyBG','2020-10-08','',3),(20,'TT1','Pistone',NULL,'Sanjama','1','$2y$10$zIva/22.ahTqJWuzSP4cZO3Dy6AZ325wCq5bCDCCeIxJOcEFcCBqm','2020-10-08','',2),(21,'AA1','Pistone',NULL,'Sanjama','1','$2y$10$bUXAAHZFpMX7pJrMtw8.HesHA8Y8aLY7RmgANzXGq5XZAWPuMYy3O','2020-10-08','../images/accountants/unnamed.jpg',4);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-02-10 19:48:53
