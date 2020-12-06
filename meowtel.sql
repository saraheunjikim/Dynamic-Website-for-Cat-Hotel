-- MySQL dump 10.13  Distrib 8.0.21, for macos10.15 (x86_64)
--
-- Host: 127.0.0.1    Database: meowtel3
-- ------------------------------------------------------
-- Server version	8.0.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_level`
--

DROP TABLE IF EXISTS `activity_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_level` (
  `activityLevelId` int NOT NULL AUTO_INCREMENT,
  `activityDescription` varchar(45) NOT NULL,
  PRIMARY KEY (`activityLevelId`),
  UNIQUE KEY `activityLevelId_UNIQUE` (`activityLevelId`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_level`
--

LOCK TABLES `activity_level` WRITE;
/*!40000 ALTER TABLE `activity_level` DISABLE KEYS */;
INSERT INTO `activity_level` VALUES (101,'Low Activity'),(102,'Moderate Activity'),(103,'High Activity');
/*!40000 ALTER TABLE `activity_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `adminId` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY (`adminId`),
  UNIQUE KEY `adminId_UNIQUE` (`adminId`)
) ENGINE=InnoDB AUTO_INCREMENT=100000 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','admin');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat`
--

DROP TABLE IF EXISTS `cat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cat` (
  `catId` int NOT NULL AUTO_INCREMENT,
  `catName` varchar(45) NOT NULL,
  `catAge` int NOT NULL,
  `catGender` varchar(1) NOT NULL,
  `activityLevelId` int NOT NULL,
  `coatLengthId` int NOT NULL,
  `catSizeId` int NOT NULL,
  `catStatusId` int NOT NULL,
  `goodWithKids` tinyint NOT NULL,
  `image` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`catId`),
  UNIQUE KEY `catId_UNIQUE` (`catId`),
  KEY `fk-activityLevel_idx` (`activityLevelId`),
  KEY `fk-catSize_idx` (`catSizeId`),
  KEY `fk-coatLength_idx` (`coatLengthId`),
  KEY `fk-catStatus_idx` (`catStatusId`),
  CONSTRAINT `fk-activityLevel` FOREIGN KEY (`activityLevelId`) REFERENCES `activity_level` (`activityLevelId`),
  CONSTRAINT `fk-catSize` FOREIGN KEY (`catSizeId`) REFERENCES `cat_size` (`catSizeId`),
  CONSTRAINT `fk-catStatus` FOREIGN KEY (`catStatusId`) REFERENCES `cat_status` (`catStatusId`),
  CONSTRAINT `fk-coatLength` FOREIGN KEY (`coatLengthId`) REFERENCES `coat_length` (`coatLengthId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat`
--

LOCK TABLES `cat` WRITE;
/*!40000 ALTER TABLE `cat` DISABLE KEYS */;
INSERT INTO `cat` VALUES (1,'Athena',1,'F',101,108,104,111,0,'athena'),(2,'Bock',2,'M',102,108,104,112,1,'bock'),(3,'Bowie',3,'F',102,108,104,112,1,'bowie'),(4,'Alfredo',3,'M',103,109,104,112,1,'alfredo'),(5,'Elora',3,'F',102,108,106,112,1,'elora'),(6,'Gala',8,'F',101,109,104,111,0,'gala'),(7,'Chewie',6,'M',103,109,105,112,0,'chewie'),(8,'Jellybean',5,'F',102,108,104,112,1,'jellybean'),(9,'Nola',9,'F',101,108,104,112,1,'nola'),(10,'Sugar',12,'F',101,109,104,111,0,'sugar'),(11,'Pony',4,'F',101,108,104,112,1,'pony'),(12,'Ginger',7,'F',101,108,105,112,1,'ginger');
/*!40000 ALTER TABLE `cat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_assignment`
--

DROP TABLE IF EXISTS `cat_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cat_assignment` (
  `reservationId` int NOT NULL,
  `catId` int NOT NULL,
  PRIMARY KEY (`reservationId`,`catId`),
  UNIQUE KEY `reservationId_UNIQUE` (`reservationId`),
  KEY `fk-cat_idx` (`catId`),
  CONSTRAINT `fk-cat` FOREIGN KEY (`catId`) REFERENCES `cat` (`catId`),
  CONSTRAINT `fk-reservation-cat` FOREIGN KEY (`reservationId`) REFERENCES `reservation` (`reservationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_assignment`
--

LOCK TABLES `cat_assignment` WRITE;
/*!40000 ALTER TABLE `cat_assignment` DISABLE KEYS */;
INSERT INTO `cat_assignment` VALUES (20,6),(21,10);
/*!40000 ALTER TABLE `cat_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_size`
--

DROP TABLE IF EXISTS `cat_size`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cat_size` (
  `catSizeId` int NOT NULL AUTO_INCREMENT,
  `catSizeDescription` varchar(45) NOT NULL,
  PRIMARY KEY (`catSizeId`),
  UNIQUE KEY `catSizeId_UNIQUE` (`catSizeId`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_size`
--

LOCK TABLES `cat_size` WRITE;
/*!40000 ALTER TABLE `cat_size` DISABLE KEYS */;
INSERT INTO `cat_size` VALUES (104,'Small'),(105,'Medium'),(106,'Large');
/*!40000 ALTER TABLE `cat_size` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_status`
--

DROP TABLE IF EXISTS `cat_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cat_status` (
  `catStatusId` int NOT NULL AUTO_INCREMENT,
  `catStatusDescription` varchar(45) NOT NULL,
  PRIMARY KEY (`catStatusId`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_status`
--

LOCK TABLES `cat_status` WRITE;
/*!40000 ALTER TABLE `cat_status` DISABLE KEYS */;
INSERT INTO `cat_status` VALUES (111,'Assigned'),(112,'Free');
/*!40000 ALTER TABLE `cat_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coat_length`
--

DROP TABLE IF EXISTS `coat_length`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coat_length` (
  `coatLengthId` int NOT NULL AUTO_INCREMENT,
  `coatLengthDescription` varchar(45) NOT NULL,
  PRIMARY KEY (`coatLengthId`),
  UNIQUE KEY `coatLengthId_UNIQUE` (`coatLengthId`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coat_length`
--

LOCK TABLES `coat_length` WRITE;
/*!40000 ALTER TABLE `coat_length` DISABLE KEYS */;
INSERT INTO `coat_length` VALUES (108,'Short'),(109,'Long');
/*!40000 ALTER TABLE `coat_length` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guest`
--

DROP TABLE IF EXISTS `guest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guest` (
  `guestId` int NOT NULL AUTO_INCREMENT,
  `guestFirstName` varchar(45) NOT NULL,
  `guestLastName` varchar(45) NOT NULL,
  `guestPhone` varchar(45) NOT NULL,
  `guestEmail` varchar(45) NOT NULL,
  `addressStreet` varchar(45) NOT NULL,
  `addressCity` varchar(45) NOT NULL,
  `addressState` varchar(2) NOT NULL,
  `addressZip` varchar(5) NOT NULL,
  `loyaltyCardNumber` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`guestId`),
  UNIQUE KEY `guestId_UNIQUE` (`guestId`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guest`
--

LOCK TABLES `guest` WRITE;
/*!40000 ALTER TABLE `guest` DISABLE KEYS */;
INSERT INTO `guest` VALUES (31,'Jiyu','Lu','765-586-2495','jl10237@nyu.edu','1 River Ct','Jersey City','33','07310',''),(32,'Jiyu','Lu','7655862495','jl10237@nyu.edu','1 River Ct','Jersey City','33','07310',''),(33,'Jiyu','Lu','765-586-2495','jl10237@nyu.edu','1 River Ct','Jersey City','33','07310',''),(34,'Jiyu','Lu','765-586-2495','jl10237@nyu.edu','1 River Ct','Jersey City','33','07310',''),(35,'Jiyu','Lu','765-586-2495','jl10237@nyu.edu','1 River Ct','Jersey City','33','07310',''),(36,'Jiyu','Lu','765-586-2495','jl10237@nyu.edu','1 River Ct','Jersey City','33','07310','');
/*!40000 ALTER TABLE `guest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loyalty_card`
--

DROP TABLE IF EXISTS `loyalty_card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `loyalty_card` (
  `loyaltyCardId` int NOT NULL AUTO_INCREMENT,
  `memberLastName` varchar(45) NOT NULL,
  `memberFirstName` varchar(45) NOT NULL,
  PRIMARY KEY (`loyaltyCardId`),
  UNIQUE KEY `loyaltyCardId_UNIQUE` (`loyaltyCardId`)
) ENGINE=InnoDB AUTO_INCREMENT=330033 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loyalty_card`
--

LOCK TABLES `loyalty_card` WRITE;
/*!40000 ALTER TABLE `loyalty_card` DISABLE KEYS */;
INSERT INTO `loyalty_card` VALUES (330001,'Rangel','Nana'),(330002,'Wong','Kofi'),(330003,'Stanley','Madina'),(330004,'Cottrell','Yu'),(330005,'Roman','Faith'),(330006,'Vega','Mario'),(330007,'Holman','Andre'),(330008,'Booth','Tyler'),(330009,'Tyson','Ethan'),(330010,'Holman','Chelsey'),(330011,'Porter','Raisa'),(330012,'Fellows','Greyson'),(330013,'Bourne','Katerina'),(330014,'Morse','Sami'),(330015,'Neal','Jamie'),(330016,'Cherry','Randy'),(330017,'Wood','Ronny'),(330018,'Downs','Mariyah'),(330019,'Wallis','Damon'),(330020,'Ramos','Paul'),(330032,'Jiyu','Lu');
/*!40000 ALTER TABLE `loyalty_card` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment` (
  `paymentId` int NOT NULL AUTO_INCREMENT,
  `guestId` int NOT NULL,
  `paymentDate` date NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `cardNumber` varchar(16) NOT NULL,
  PRIMARY KEY (`paymentId`),
  UNIQUE KEY `paymentId_UNIQUE` (`paymentId`),
  KEY `fk-guest_idx` (`guestId`),
  CONSTRAINT `fk-guest-payment` FOREIGN KEY (`guestId`) REFERENCES `guest` (`guestId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservation` (
  `reservationId` int NOT NULL AUTO_INCREMENT,
  `guestId` int NOT NULL,
  `reservationDate` date NOT NULL,
  `checkInDate` date NOT NULL,
  `checkOutDate` date NOT NULL,
  `guestNo` int NOT NULL,
  `children` tinyint NOT NULL,
  `catInRoom` tinyint NOT NULL,
  `wantBreakfast` tinyint NOT NULL,
  `smokingPreference` tinyint NOT NULL,
  PRIMARY KEY (`reservationId`),
  UNIQUE KEY `reservationId_UNIQUE` (`reservationId`),
  KEY `fk-guest_idx` (`guestId`),
  CONSTRAINT `fk-guest` FOREIGN KEY (`guestId`) REFERENCES `guest` (`guestId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation`
--

LOCK TABLES `reservation` WRITE;
/*!40000 ALTER TABLE `reservation` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `room` (
  `roomId` int NOT NULL AUTO_INCREMENT,
  `roomTypeId` int NOT NULL,
  `allowedSmoking` tinyint NOT NULL,
  `bedType` varchar(45) NOT NULL,
  `floorNumber` varchar(45) NOT NULL,
  PRIMARY KEY (`roomId`),
  UNIQUE KEY `roomId_UNIQUE` (`roomId`),
  KEY `fk-roomType_idx` (`roomTypeId`),
  CONSTRAINT `fk-roomType` FOREIGN KEY (`roomTypeId`) REFERENCES `room_type` (`roomTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=506 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room`
--

LOCK TABLES `room` WRITE;
/*!40000 ALTER TABLE `room` DISABLE KEYS */;
INSERT INTO `room` VALUES (201,100001,0,'1 King Bed','2'),(202,100001,0,'1 King Bed','2'),(203,100001,0,'2 Queen Beds','2'),(204,100003,0,'2 Queen Beds','2'),(205,100001,0,'2 Queen Beds','2'),(301,100001,0,'2 Queen Beds','3'),(302,100001,0,'2 Queen Beds','3'),(303,100001,0,'1 King Bed','3'),(304,100001,0,'1 King Bed','3'),(305,100004,0,'2 Queen Beds','3'),(401,100002,0,'2 Queen Beds','4'),(402,100002,0,'1 King Bed','4'),(403,100002,0,'1 King Bed','4'),(404,100003,0,'1 King Bed','4'),(405,100002,0,'2 Queen Beds','4'),(501,100002,1,'2 Queen Beds','5'),(502,100002,1,'2 Queen Beds','5'),(503,100002,1,'1 King Bed','5'),(504,100002,1,'1 King Bed','5'),(505,100004,1,'1 King Bed','5');
/*!40000 ALTER TABLE `room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_booked_dates`
--

DROP TABLE IF EXISTS `room_booked_dates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `room_booked_dates` (
  `roomBookedDateId` int NOT NULL AUTO_INCREMENT,
  `reservationId` int NOT NULL,
  `roomId` int NOT NULL,
  `bookedDate` date NOT NULL,
  PRIMARY KEY (`roomBookedDateId`),
  UNIQUE KEY `roomBookedId_UNIQUE` (`roomBookedDateId`),
  KEY `fk-reservation-booked_idx` (`reservationId`),
  KEY `fk-room-booked_idx` (`roomId`),
  CONSTRAINT `fk-reservation-booked` FOREIGN KEY (`reservationId`) REFERENCES `reservation` (`reservationId`),
  CONSTRAINT `fk-room-booked` FOREIGN KEY (`roomId`) REFERENCES `room` (`roomId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_booked_dates`
--

LOCK TABLES `room_booked_dates` WRITE;
/*!40000 ALTER TABLE `room_booked_dates` DISABLE KEYS */;
/*!40000 ALTER TABLE `room_booked_dates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_type`
--

DROP TABLE IF EXISTS `room_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `room_type` (
  `roomTypeId` int NOT NULL AUTO_INCREMENT,
  `roomDescription` varchar(45) NOT NULL,
  `roomPrice` decimal(10,2) NOT NULL,
  PRIMARY KEY (`roomTypeId`),
  UNIQUE KEY `roomTypeId_UNIQUE` (`roomTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=100005 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_type`
--

LOCK TABLES `room_type` WRITE;
/*!40000 ALTER TABLE `room_type` DISABLE KEYS */;
INSERT INTO `room_type` VALUES (100001,'Superior',250.00),(100002,'Deluxe',350.00),(100003,'Suite 1',500.00),(100004,'Suite 2',500.00);
/*!40000 ALTER TABLE `room_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `states` (
  `stateId` int NOT NULL,
  `stateDescription` varchar(45) NOT NULL,
  `stateAbbreviation` varchar(2) NOT NULL,
  PRIMARY KEY (`stateId`),
  UNIQUE KEY `stateId_UNIQUE` (`stateId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` VALUES (1,'ALABAMA','AL'),(2,'ALASKA','AK'),(3,'AMERICAN SAMOA','AS'),(4,'ARIZONA','AZ'),(5,'ARKANSAS','AR'),(6,'CALIFORNIA	','CA'),(7,'COLORADO','CO'),(8,'CONNECTICUT','CT'),(9,'DELAWARE','DE'),(10,'DISTRICT OF COLUMBIA	','DC'),(11,'FLORIDA','FL'),(12,'GEORGIA','GA'),(13,'GUAM','GU'),(14,'HAWAII','HI'),(15,'IDAHO','ID'),(16,'ILLINOIS	','IL'),(17,'INDIANA','IN'),(18,'IOWA','IA'),(19,'KANSAS','KS'),(20,'KENTUCKY','KY'),(21,'LOUISIANA','LA'),(22,'MAINE','ME'),(23,'MARYLAND','MD'),(24,'MASSACHUSETTS','MA'),(25,'MICHIGAN','MI'),(26,'MINNESOTA','MN'),(27,'MISSISSIPPI','MS'),(28,'MISSOURI','MO'),(29,'MONTANA','MT'),(30,'NEBRASKA','NE'),(31,'NEVADA','NV'),(32,'NEW HAMPSHIRE','NH'),(33,'NEW JERSEY','NJ'),(34,'NEW MEXICO','NM'),(35,'NEW YORK','NY'),(36,'NORTH CAROLINA','NC'),(37,'NORTH DAKOTA','ND'),(38,'NORTHERN MARIANA IS','MP'),(39,'OHIO','OH'),(40,'OKLAHOMA','OK'),(41,'OREGON','OR'),(42,'PENNSYLVANIA','PA'),(43,'PUERTO RICO','PR'),(44,'RHODE ISLAND	','RI'),(45,'SOUTH CAROLINA','SC'),(46,'SOUTH DAKOTA','SD'),(47,'TENNESSEE','TN'),(48,'TEXAS','TX'),(49,'UTAH','UT'),(50,'VERMONT','VT'),(51,'VIRGINIA','VA'),(52,'VIRGIN ISLANDS','VI'),(53,'WASHINGTON','WA'),(54,'WEST VIRGINIA	','WV'),(55,'WISCONSIN','WI'),(56,'WYOMING','WY');
/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-04 21:11:22
