-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 07, 2012 at 03:37 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rmhreservationdb`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `GetRequestKeyNumber`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetRequestKeyNumber`(IN RequestType VARCHAR(255))
BEGIN 
        DECLARE ID int;
 
        IF RequestType = "RoomReservationRequestID" THEN 
            SELECT @ID := RoomReservationRequestID
            FROM RequestKeyNumber;
            UPDATE RequestKeyNumber SET RoomReservationRequestID = @ID + 1; 
            
            SELECT RoomReservationRequestID
            FROM RequestKeyNumber;
        ELSE    
            SELECT @ID := ProfileActivityRequestID
            FROM RequestKeyNumber;
            UPDATE RequestKeyNumber SET ProfileActivityRequestID = @ID + 1;

             SELECT ProfileActivityRequestID
             FROM RequestKeyNumber;

        END IF;
        
  END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `activation`
--

DROP TABLE IF EXISTS `activation`;
CREATE TABLE IF NOT EXISTS `activation` (
  `ActivationID` int(11) NOT NULL AUTO_INCREMENT,
  `UserProfileID` int(11) NOT NULL,
  `ActivationCode` varchar(255) DEFAULT NULL,
  `ResetTime` datetime DEFAULT NULL,
  `ResetStatus` char(1) DEFAULT NULL,
  PRIMARY KEY (`ActivationID`),
  KEY `UserProfileID` (`UserProfileID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `familyprofile`
--

DROP TABLE IF EXISTS `familyprofile`;
CREATE TABLE IF NOT EXISTS `familyprofile` (
  `FamilyProfileID` int(11) NOT NULL AUTO_INCREMENT,
  `ParentFirstName` varchar(50) NOT NULL,
  `ParentLastName` varchar(50) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Phone1` varchar(20) NOT NULL,
  `Phone2` varchar(20) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `State` varchar(10) DEFAULT NULL,
  `ZipCode` varchar(12) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `PatientFirstName` varchar(50) NOT NULL,
  `PatientLastName` varchar(50) NOT NULL,
  `PatientRelation` varchar(50) DEFAULT NULL,
  `PatientBirthDate` datetime DEFAULT NULL,
  `FormPDF` varchar(255) DEFAULT NULL,
  `Notes` text,
  PRIMARY KEY (`FamilyProfileID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `familyprofile`
--

INSERT INTO `familyprofile` (`FamilyProfileID`, `ParentFirstName`, `ParentLastName`, `Email`, `Phone1`, `Phone2`, `Address`, `City`, `State`, `ZipCode`, `Country`, `PatientFirstName`, `PatientLastName`, `PatientRelation`, `PatientBirthDate`, `FormPDF`, `Notes`) VALUES
(1, 'Jane', 'Smith', 'janesmith@gmail.com', '7181234455', '6465562312', '110-76 76th Avenue', 'White Plains', 'New York', '10601', 'USA', 'Joey', 'Smith', 'Mother', '1998-02-18 00:00:00', 'www.rmhforms.com/family1form.pdf', 'patient is allergic to peaches'),
(2, 'Scott', 'Miller', 'scottmiller@gmail.com', '7188884455', '6465562322', 'Borgartun 34', 'REYKJAV?K', 'N/A', '105', 'Iceland', 'Nate', 'Miller', 'Father', '1997-01-14 00:00:00', 'www.rmhforms.com/family2form.pdf', 'patient is allergic to cats'),
(3, 'Nathalie', 'Alexandrie', 'nathalie.alexandrie@unilim.fr', '1.23.45.67.89', '1.44.24.22.36', '2 avenue de la Soeur Rosalie', 'Paris', 'N/A', '75001', 'France', 'Nate', 'Miller', 'GrandMother', '1995-03-10 00:00:00', 'www.rmhforms.com/family3form.pdf', 'patient is sensitive to bright lights');

-- --------------------------------------------------------

--
-- Table structure for table `profileactivity`
--

DROP TABLE IF EXISTS `profileactivity`;
CREATE TABLE IF NOT EXISTS `profileactivity` (
  `ProfileActivityID` int(11) NOT NULL AUTO_INCREMENT,
  `ProfileActivityRequestID` int(11) NOT NULL,
  `FamilyProfileID` int(11) NOT NULL,
  `SocialWorkerProfileID` int(11) NOT NULL,
  `RMHStaffProfileID` int(11) DEFAULT NULL,
  `SW_DateStatusSubmitted` datetime DEFAULT NULL,
  `RMH_DateStatusSubmitted` datetime DEFAULT NULL,
  `ActivityType` enum('Create','Edit') NOT NULL,
  `Status` enum('Unconfirmed','Confirm','Deny') NOT NULL,
  `Notes` text,
  PRIMARY KEY (`ProfileActivityID`),
  KEY `RMHStaffProfileID` (`RMHStaffProfileID`),
  KEY `SocialWorkerProfileID` (`SocialWorkerProfileID`),
  KEY `FamilyProfileID` (`FamilyProfileID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `profileactivity`
--

INSERT INTO `profileactivity` (`ProfileActivityID`, `ProfileActivityRequestID`, `FamilyProfileID`, `SocialWorkerProfileID`, `RMHStaffProfileID`, `SW_DateStatusSubmitted`, `RMH_DateStatusSubmitted`, `ActivityType`, `Status`, `Notes`) VALUES
(1, 1, 1, 1, 1, '2012-01-10 18:22:43', '2012-01-12 17:22:43', 'Create', 'Confirm', 'New Family Profile'),
(2, 2, 1, 1, 1, '2012-02-19 12:33:19', '2012-02-20 14:23:13', 'Edit', 'Confirm', 'New Address 110-76 76th Avenue'),
(3, 3, 2, 1, 1, '2012-02-21 15:22:43', '2012-02-22 19:22:43', 'Create', 'Confirm', 'New Family Profile'),
(4, 4, 2, 1, 1, '2012-03-02 15:44:22', '2012-03-03 12:43:12', 'Edit', 'Confirm', 'New Address Borgartun 34'),
(5, 5, 3, 1, 1, '2012-04-01 10:22:43', NULL, 'Create', 'Unconfirmed', 'New Family Profile'),
(6, 6, 3, 1, 1, '2012-04-02 10:22:43', '2012-04-03 15:22:33', 'Edit', 'Deny', 'New Family Profile needs to be approved first');

-- --------------------------------------------------------

--
-- Table structure for table `profileactivitychange`
--

DROP TABLE IF EXISTS `profileactivitychange`;
CREATE TABLE IF NOT EXISTS `profileactivitychange` (
  `ChangeIndex` int(11) NOT NULL AUTO_INCREMENT,
  `ProfileActivityID` int(11) NOT NULL,
  `FieldName` varchar(25) NOT NULL,
  `FieldChanges` varchar(255) NOT NULL,
  UNIQUE KEY `ChangeIndex` (`ChangeIndex`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `profileactivitychange`
--

INSERT INTO `profileactivitychange` (`ChangeIndex`, `ProfileActivityID`, `FieldName`, `FieldChanges`) VALUES
(1, 3, 'Address', '110-76 76th Avenue'),
(2, 7, 'Address', 'Borgartun 34'),
(3, 10, 'Address', '4 avenue de la Soeur Rosalie');

-- --------------------------------------------------------

--
-- Table structure for table `requestkeynumber`
--

DROP TABLE IF EXISTS `requestkeynumber`;
CREATE TABLE IF NOT EXISTS `requestkeynumber` (
  `ProfileActivityRequestID` int(11) NOT NULL,
  `RoomReservationRequestID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requestkeynumber`
--

INSERT INTO `requestkeynumber` (`ProfileActivityRequestID`, `RoomReservationRequestID`) VALUES
(7, 6);

-- --------------------------------------------------------

--
-- Table structure for table `rmhstaffprofile`
--

DROP TABLE IF EXISTS `rmhstaffprofile`;
CREATE TABLE IF NOT EXISTS `rmhstaffprofile` (
  `RMHStaffProfileID` int(11) NOT NULL AUTO_INCREMENT,
  `UserProfileID` int(11) NOT NULL,
  `Title` varchar(10) DEFAULT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`RMHStaffProfileID`),
  KEY `UserProfileID` (`UserProfileID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `rmhstaffprofile`
--

INSERT INTO `rmhstaffprofile` (`RMHStaffProfileID`, `UserProfileID`, `Title`, `FirstName`, `LastName`, `Phone`) VALUES
(1, 3, 'Mr.', 'Tom', 'Hansen', '7186562398'),
(2, 1, 'Mr.', 'Frank', 'Petersen', '2126565511'),
(3, 5, 'Mr.', 'Edward', 'Cho', '2122228888');

-- --------------------------------------------------------

--
-- Table structure for table `roomreservationactivity`
--

DROP TABLE IF EXISTS `roomreservationactivity`;
CREATE TABLE IF NOT EXISTS `roomreservationactivity` (
  `RoomReservationActivityID` int(11) NOT NULL AUTO_INCREMENT,
  `RoomReservationRequestID` int(11) NOT NULL,
  `FamilyProfileID` int(11) NOT NULL,
  `SocialWorkerProfileID` int(11) NOT NULL,
  `RMHStaffProfileID` int(11) DEFAULT NULL,
  `SW_DateStatusSubmitted` datetime DEFAULT NULL,
  `RMH_DateStatusSubmitted` datetime DEFAULT NULL,
  `ActivityType` enum('Apply','Modify','Cancel') NOT NULL,
  `Status` enum('Unconfirmed','Confirm','Deny') NOT NULL,
  `BeginDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `PatientDiagnosis` text,
  `Notes` text,
  PRIMARY KEY (`RoomReservationActivityID`),
  KEY `SocialWorkerProfileID` (`SocialWorkerProfileID`),
  KEY `RMHStaffProfileID` (`RMHStaffProfileID`),
  KEY `FamilyProfileID` (`FamilyProfileID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `roomreservationactivity`
--

INSERT INTO `roomreservationactivity` (`RoomReservationActivityID`, `RoomReservationRequestID`, `FamilyProfileID`, `SocialWorkerProfileID`, `RMHStaffProfileID`, `SW_DateStatusSubmitted`, `RMH_DateStatusSubmitted`, `ActivityType`, `Status`, `BeginDate`, `EndDate`, `PatientDiagnosis`, `Notes`) VALUES
(1, 1, 1, 1, 1, '2012-02-17 10:33:28', '2012-02-18 13:22:20', 'Apply', 'Confirm', '2012-03-01 00:00:00', '2012-04-01 00:00:00', 'Pediatric Sarcomas', ''),
(2, 2, 1, 1, 1, '2012-02-19 12:33:19', '2012-02-20 20:24:22', 'Modify', 'Confirm', '2012-03-17 00:00:00', '2012-04-17 00:00:00', 'Pediatric Sarcomas', ''),
(3, 3, 1, 1, 1, '2012-02-21 21:33:11', '2012-02-21 23:44:18', 'Cancel', 'Confirm', '2012-03-17 00:00:00', '2012-04-17 00:00:00', 'Pediatric Sarcomas', ''),
(4, 4, 2, 1, 1, '2012-03-01 23:44:22', '2012-03-01 23:44:44', 'Apply', 'Confirm', '2012-04-15 00:00:00', '2012-04-17 00:00:00', 'Pediatric Leukemias', 'beginning 04/29 avail.'),
(5, 5, 2, 1, 2, '2012-03-02 15:44:22', NULL, '', 'Unconfirmed', '2012-04-29 00:00:00', '2012-05-01 00:00:00', 'Pediatric Leukemias', '');

-- --------------------------------------------------------

--
-- Table structure for table `socialworkerprofile`
--

DROP TABLE IF EXISTS `socialworkerprofile`;
CREATE TABLE IF NOT EXISTS `socialworkerprofile` (
  `SocialWorkerProfileID` int(11) NOT NULL AUTO_INCREMENT,
  `UserProfileID` int(11) NOT NULL,
  `Title` varchar(10) DEFAULT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `HospitalAffiliation` varchar(50) DEFAULT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `EmailNotification` enum('Yes','No') NOT NULL,
  PRIMARY KEY (`SocialWorkerProfileID`),
  KEY `UserProfileID` (`UserProfileID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `socialworkerprofile`
--

INSERT INTO `socialworkerprofile` (`SocialWorkerProfileID`, `UserProfileID`, `Title`, `FirstName`, `LastName`, `HospitalAffiliation`, `Phone`, `EmailNotification`) VALUES
(1, 2, 'Ms.', 'Mary', 'Tove', 'Memorial Sloan-Kettering Cancer Center', '7183334444', 'Yes'),
(2, 4, 'Ms.', 'Lauren', 'Schwan', 'Memorial Sloan-Kettering Cancer Center', '7187773232', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `userprofile`
--

DROP TABLE IF EXISTS `userprofile`;
CREATE TABLE IF NOT EXISTS `userprofile` (
  `UserProfileID` int(11) NOT NULL AUTO_INCREMENT,
  `UsernameID` varchar(50) NOT NULL,
  `UserEmail` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `UserCategory` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`UserProfileID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `userprofile`
--

INSERT INTO `userprofile` (`UserProfileID`, `UsernameID`, `UserEmail`, `Password`, `UserCategory`) VALUES
(1, 'Frank2126565511', 'frank1@gmail.com', 'password3', 'RMH Staff Approver'),
(2, 'Mary789', 'mary1@gmail.com', 'password1', 'Social Worker'),
(3, 'Tom7186562398', 'tom1@gmail.com', 'password2', 'RMH Staff Approver'),
(4, 'Lauren653', 'lauren1@gmail.com', 'password4', 'Social Worker'),
(5, 'Admin', 'housemngr@rmhnewyork.org', 'Admin123', 'RMH Administrator');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activation`
--
ALTER TABLE `activation`
  ADD CONSTRAINT `activation_ibfk_1` FOREIGN KEY (`UserProfileID`) REFERENCES `userprofile` (`UserProfileID`);

--
-- Constraints for table `rmhstaffprofile`
--
ALTER TABLE `rmhstaffprofile`
  ADD CONSTRAINT `rmhstaffprofile_ibfk_1` FOREIGN KEY (`UserProfileID`) REFERENCES `userprofile` (`UserProfileID`);

--
-- Constraints for table `socialworkerprofile`
--
ALTER TABLE `socialworkerprofile`
  ADD CONSTRAINT `socialworkerprofile_ibfk_1` FOREIGN KEY (`UserProfileID`) REFERENCES `userprofile` (`UserProfileID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;