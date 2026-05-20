
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `dept_number` int(11) NOT NULL,
  `dept_name` varchar(50) NOT NULL,
  `manager_ssn` varchar(9) DEFAULT NULL,
  `manager_start` date DEFAULT NULL,
  PRIMARY KEY (`dept_number`),
  KEY `fk_manager` (`manager_ssn`),
  CONSTRAINT `fk_manager` FOREIGN KEY (`manager_ssn`) REFERENCES `employee` (`ssn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'Research','333445555','1988-05-22'),(2,'Administration','987654321','1995-01-01'),(3,'Headquarters','888665555','1981-06-19');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `dependent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dependent` (
  `emp_ssn` varchar(9) NOT NULL,
  `dep_name` varchar(50) NOT NULL,
  `sex` char(1) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `relationship` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`emp_ssn`,`dep_name`),
  CONSTRAINT `dependent_ibfk_1` FOREIGN KEY (`emp_ssn`) REFERENCES `employee` (`ssn`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `dependent` WRITE;
/*!40000 ALTER TABLE `dependent` DISABLE KEYS */;
INSERT INTO `dependent` VALUES ('123456789','Alice','F','1988-12-30','Daughter'),('123456789','Elizabeth','F','1967-05-05','Spouse'),('123456789','Michael','M','1988-01-04','Son'),('333445555','Alice','F','1986-04-05','Daughter'),('333445555','Joy','F','1958-05-03','Spouse'),('333445555','Theodore','M','1983-10-25','Son'),('453453453','dzd','M','2003-06-30','Spouse'),('636259863','Anand','M','2009-02-14','Sibling'),('636259863','sujan','F','2006-10-29','Spouse'),('987654321','Abner','M','1942-02-28','Spouse');
/*!40000 ALTER TABLE `dependent` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `dept_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dept_locations` (
  `dept_number` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  PRIMARY KEY (`dept_number`,`location`),
  CONSTRAINT `dept_locations_ibfk_1` FOREIGN KEY (`dept_number`) REFERENCES `department` (`dept_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `dept_locations` WRITE;
/*!40000 ALTER TABLE `dept_locations` DISABLE KEYS */;
INSERT INTO `dept_locations` VALUES (1,'Bellaire'),(1,'Houston'),(1,'Sugarland'),(2,'Stafford'),(3,'Houston');
/*!40000 ALTER TABLE `dept_locations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee` (
  `ssn` varchar(9) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `minit` char(1) DEFAULT NULL,
  `lname` varchar(30) NOT NULL,
  `bdate` date DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `sex` char(1) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `dept_number` int(11) DEFAULT NULL,
  `supervisor_ssn` varchar(9) DEFAULT NULL,
  PRIMARY KEY (`ssn`),
  KEY `dept_number` (`dept_number`),
  KEY `supervisor_ssn` (`supervisor_ssn`),
  CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`dept_number`) REFERENCES `department` (`dept_number`),
  CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`supervisor_ssn`) REFERENCES `employee` (`ssn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES ('123456789','John','B','Smith','1965-01-09','731 Fondren, Houston TX','M',30000.00,1,'333445555'),('333445555','Franklin','T','Wong','1955-12-08','638 Voss, Houston TX','M',40000.00,1,'888665555'),('453453453','Joyce','A','English','1972-07-31','5631 Rice, Houston TX','F',25000.00,1,'333445555'),('543210987','Joyce','A','English','1972-07-31','5631 Rice, Houston TX','F',25000.00,2,'987654321'),('636259863','Aditya','','Goure','2006-09-30','LA','M',99999999.99,3,NULL),('666884444','Ramesh','K','Narayan','1962-09-15','975 Fire Oak, Humble TX','M',38000.00,1,'333445555'),('888665555','James','E','Borg','1937-11-10','450 Stone, Houston TX','M',55000.00,3,NULL),('987654321','Jennifer','S','Wallace','1941-06-20','291 Berry, Bellaire TX','F',43000.00,2,'888665555'),('987987987','Ahmad','V','Jabbar','1969-03-29','980 Dallas, Houston TX','M',25000.00,2,'987654321');
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project` (
  `proj_number` int(11) NOT NULL,
  `proj_name` varchar(50) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `dept_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`proj_number`),
  KEY `dept_number` (`dept_number`),
  CONSTRAINT `project_ibfk_1` FOREIGN KEY (`dept_number`) REFERENCES `department` (`dept_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (1,'ProductX','Bellaire',1),(2,'ProductY','Sugarland',1),(3,'ProductZ','Houston',1),(10,'Computerization','Stafford',2),(11,'lisa','cuddy',2),(20,'Reorganization','Houston',2),(30,'Newbenefits','Stafford',2),(99,'TestProject','TestCity',1),(100,'Project100','City100',1);
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `works_on`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `works_on` (
  `emp_ssn` varchar(9) NOT NULL,
  `proj_number` int(11) NOT NULL,
  `hours` decimal(5,1) DEFAULT NULL,
  PRIMARY KEY (`emp_ssn`,`proj_number`),
  KEY `proj_number` (`proj_number`),
  CONSTRAINT `works_on_ibfk_1` FOREIGN KEY (`emp_ssn`) REFERENCES `employee` (`ssn`),
  CONSTRAINT `works_on_ibfk_2` FOREIGN KEY (`proj_number`) REFERENCES `project` (`proj_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `works_on` WRITE;
/*!40000 ALTER TABLE `works_on` DISABLE KEYS */;
INSERT INTO `works_on` VALUES ('123456789',1,32.5),('123456789',2,7.5),('123456789',99,0.0),('123456789',100,0.0),('333445555',2,10.0),('333445555',3,10.0),('333445555',10,10.0),('333445555',20,10.0),('453453453',1,20.0),('453453453',2,20.0),('543210987',10,10.0),('543210987',30,30.0),('636259863',30,10.0),('666884444',3,40.0),('888665555',20,NULL),('987654321',20,15.0),('987654321',30,20.0),('987987987',10,35.0),('987987987',30,5.0);
/*!40000 ALTER TABLE `works_on` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

