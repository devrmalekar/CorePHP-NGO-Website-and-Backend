-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2025 at 05:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ngo`
--
CREATE DATABASE IF NOT EXISTS `ngo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ngo`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `SP_allVolunteerList`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_allVolunteerList` ()   BEGIN
	set @sn=0;
	SELECT (@sn:=@sn+1) as sn,
    `tbl_Volunteer`.`id`,
    `tbl_Volunteer`.`fname`,
    `tbl_Volunteer`.`lname`,
    `tbl_Volunteer`.`addr`,
    `tbl_Volunteer`.`phone`,
    `tbl_Volunteer`.`email`,
    `tbl_Volunteer`.`reason`,
    `tbl_Volunteer`.`status`,
    `tbl_Volunteer`.`applied_date`
	FROM `tbl_Volunteer`
	order by  applied_date desc;
END$$

DROP PROCEDURE IF EXISTS `SP_ChangePwd`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ChangePwd` (IN `pwd` VARCHAR(50), IN `user_id` INT)   BEGIN
UPDATE `namastelyrics`.`tbl_logininfo`
SET
`Password` = pwd,
`TempPassword` = ''
WHERE `LogInInfo_FK_UserID` = user_id;
END$$

DROP PROCEDURE IF EXISTS `SP_CheckAuth`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CheckAuth` (IN `username` VARCHAR(50), IN `pwd` VARCHAR(500))   BEGIN
	IF EXISTS (SELECT * FROM tbl_logininfo tl WHERE tl.UserName=username) THEN
    BEGIN
		IF EXISTS (SELECT * FROM tbl_logininfo tl WHERE tl.UserName=username and tl.Password =pwd) THEN
			BEGIN
				SELECT 
					li.UserName as username, up.FName, up.id, li.UserRole
				FROM
					tbl_logininfo li
				INNER JOIN
					tbl_userprofile up ON up.id = li.FK_UserID
                WHERE li.UserName='rmalekar' and li.Password = pwd;
			END;
		ELSE 
			BEGIN
				SELECT "Password Mismatch" as Error;
			END;
		END IF;
    END;
    ELSE
    BEGIN
		SELECT "No Username Exists" as Error;
    END;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_EventDetails`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EventDetails` (IN `eventID` INT)   BEGIN
	SET NAMES utf8;
	SELECT te.`id`,`EventTitle`,`EventDesc`,`EventDate`,`EventStartTime`,`EventEndTime`,
    `EventPlace`,`EventType`, tep.`EventPhotoURL` as img FROM tbl_EventsDetail te 
    LEFT JOIN (SELECT DISTINCT(FK_EventID), EventPhotoURL FROM tbl_EventPhoto GROUP BY FK_EventID ORDER BY rand() ) as tep 
    on tep.FK_EventID = te.id
    WHERE (tep.EventPhotoURL IS Null OR tep.EventPhotoURL IS NOT NULL) 
    AND te.`id` = eventID;
    
    
    SELECT EventVideoURL FROM tbl_EventVideo WHERE FK_EventId = eventID;
END$$

DROP PROCEDURE IF EXISTS `SP_EventPhotos`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EventPhotos` (IN `eventID` INT)   BEGIN
	SET NAMES utf8;
	SELECT EventPhotoURL FROM tbl_EventPhoto WHERE FK_EventID=eventID;
END$$

DROP PROCEDURE IF EXISTS `SP_GalleryAlbumCol`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_GalleryAlbumCol` (IN `eventType` VARCHAR(10))   BEGIN
	SET NAMES utf8;
		SELECT te.EventTitle,tp.EventPhotoURL, te.id  FROM tbl_EventsDetail te 
	INNER JOIN (SELECT FK_EventID, EventPhotoURL FROM tbl_EventPhoto 
    ORDER BY rand()) tp
	ON tp.FK_EventID=te.id
    WHERE te.EventType = eventType 
    Group By tp.FK_EventID ;
END$$

DROP PROCEDURE IF EXISTS `SP_GetEchDetail`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_GetEchDetail` ()   BEGIN
	SET NAMES utf8;
	SELECT * FROM tbl_ech WHERE id=1;
END$$

DROP PROCEDURE IF EXISTS `SP_ListAllEvents`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ListAllEvents` (IN `eventType` VARCHAR(10))   BEGIN
	SET NAMES utf8;
	SELECT te.`id`,`EventTitle`,`EventDesc`,`EventDate`,`EventStartTime`,`EventEndTime`,
    `EventPlace`,`EventType`, tep.`EventPhotoURL` as img FROM tbl_EventsDetail te 
    LEFT JOIN (SELECT DISTINCT(FK_EventID), EventPhotoURL FROM tbl_EventPhoto GROUP BY FK_EventID ORDER BY rand() ) as tep 
    on tep.FK_EventID = te.id
    WHERE (tep.EventPhotoURL IS Null OR tep.EventPhotoURL IS NOT NULL)
    AND te.`EventDate` < now() AND te.EventType = eventType
    ORDER BY te.`EventDate` DESC;	
END$$

DROP PROCEDURE IF EXISTS `SP_ListBlog`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ListBlog` ()   BEGIN
	SELECT `tbl_blog`.`id`,
		`tbl_blog`.`blogTitle`,
		`tbl_blog`.`blogMsg`,
		`tbl_blog`.`blogWrittenBy`,
		`tbl_blog`.`blogPostedDate`
	FROM `tbl_blog`;

END$$

DROP PROCEDURE IF EXISTS `SP_ListEventDetails`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ListEventDetails` (IN `id` INT)   BEGIN
	SET NAMES utf8;
	IF(id=0) THEN
    BEGIN
		SELECT * FROM tbl_EventsDetail te 
        WHERE te.IsCancelled = 0;
    END ;
    ELSE
    BEGIN
		SELECT * FROM tbl_EventsDetail te
		WHERE te.IsCancelled = 0 AND te.id=id;
    END;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_ListScholarshipHolder`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ListScholarshipHolder` ()   BEGIN
	SET NAMES utf8;
	SELECT * FROM tbl_scholarshipHolder;
END$$

DROP PROCEDURE IF EXISTS `SP_ListSlideShowImg`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ListSlideShowImg` (IN `eventType` SET('ECH','MFN'))   BEGIN
	SET NAMES utf8;
	SELECT * FROM tbl_slideshow WHERE tbl_slideshow.EventType = eventType;
END$$

DROP PROCEDURE IF EXISTS `SP_NewBlog`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_NewBlog` (IN `blogTitle` VARCHAR(1000), IN `blogMsg` TEXT, IN `blogWrittenBy` VARCHAR(200))   BEGIN
	INSERT INTO `tbl_blog`
	(`blogTitle`,
	`blogMsg`,
	`blogWrittenBy`,
	`blogPostedDate`)
	VALUES
	(blogTitle ,
	 blogMsg,
	 blogWrittenBy,
	 curdate());
END$$

DROP PROCEDURE IF EXISTS `SP_NewDonation`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_NewDonation` (IN `amt` DOUBLE, IN `invoice` VARCHAR(300), IN `transaction_id` VARCHAR(600), IN `payer_fname` VARCHAR(300), IN `payer_lname` VARCHAR(300), IN `payer_address` VARCHAR(300), IN `payer_city` VARCHAR(300), IN `payer_state` VARCHAR(300), IN `payer_zip` VARCHAR(300), IN `payer_country` VARCHAR(300), IN `payer_email` TEXT, IN `payment_status` VARCHAR(300))   BEGIN
    INSERT INTO `tbl_donation`(`invoice`, `trasaction_id`, `payer_fname`, `payer_lname`,
    `payer_address`, `payer_city`, `payer_state`, `payer_zip`, `payer_country`, `payer_email`,
    `payment_status`, `posted_date`, `amt`) 
    VALUES (invoice, transaction_id, payer_fname, payer_lname,payer_address, payer_city,
    payer_state, payer_zip, payer_country, payer_email, "completed",	now() , amt);
END$$

DROP PROCEDURE IF EXISTS `SP_NewEvent`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_NewEvent` (IN `EventTitle` VARCHAR(2000), IN `EventDesc` TEXT, IN `EventDate` DATE, IN `EventStartTime` TIME, IN `EventEndTime` TIME, IN `EventPlace` VARCHAR(100), IN `EventType` VARCHAR(3))   BEGIN
	INSERT INTO `tbl_EventsDetail`
	(`EventTitle`,
	`EventDesc`,
	`EventDate`,
	`EventStartTime`,
	`EventEndTime`,
	`EventPlace`,
	`EventType`)
	VALUES
	(EventTitle,
	EventDesc,
	EventDate,
	EventStartTime,
	EventEndTime,
	EventPlace,
	EventType);
    
    SELECT Last_Insert_Id() as id;

END$$

DROP PROCEDURE IF EXISTS `SP_NewEventPhoto`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_NewEventPhoto` (IN `EventPhotoURL` VARCHAR(200), IN `EventId` INT)   BEGIN
	INSERT INTO `tbl_EventPhoto`
	(`EventPhotoURL`,
	`FK_EventID`)
	VALUES
	(EventPhotoURL,
	EventId);
END$$

DROP PROCEDURE IF EXISTS `SP_NewEventVideo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_NewEventVideo` (IN `EventVideoURL` VARCHAR(200), IN `EventId` INT)   BEGIN
INSERT INTO `tbl_EventVideo`
	(`EventVideoURL`,
	`FK_EventId`)
	VALUES
	(EventVideoURL,
	EventId);
END$$

DROP PROCEDURE IF EXISTS `SP_NewSlideShowImg`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_NewSlideShowImg` (IN `imgUrl` VARCHAR(2000), IN `caption` VARCHAR(450), IN `eventType` SET('ECH','MFN'))   BEGIN
	INSERT INTO `tbl_slideshow` (`slideshowImgUrl`,`caption`,
                                        `EventType`)
	VALUES (imgUrl, caption, eventType);
END$$

DROP PROCEDURE IF EXISTS `SP_NewUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_NewUser` (IN `firstname` VARCHAR(50), IN `middlename` VARCHAR(50), IN `lastname` VARCHAR(50), IN `address` VARCHAR(100), IN `email` VARCHAR(50), IN `username` VARCHAR(50), IN `pwd` VARCHAR(500))   BEGIN
	DECLARE userProfileID INT default 0;
	INSERT INTO `namastelyrics`.`tbl_userprofile`
	(`FName`,
	`MName`,
	`LName`,
	`Address`,
	`Email`,
	`RegisteredDate`)
	VALUES
	(firstname,
	middlename,
	lastname,
	address,
	email,
	Now());
    
    SET userProfileID = LAST_INSERT_ID();
    
    INSERT INTO `namastelyrics`.`tbl_logininfo`
	(`UserName`,
	`Password`,
	`FK_UserID`)
	VALUES
	(username,
	pwd,
	userProfileID);
END$$

DROP PROCEDURE IF EXISTS `SP_NewVolunteer`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_NewVolunteer` (IN `fname` VARCHAR(45), IN `lname` VARCHAR(45), IN `addr` VARCHAR(100), IN `phone` VARCHAR(15), IN `email` VARCHAR(100), IN `reason` VARCHAR(500), IN `sstatus` VARCHAR(25))   BEGIN
	INSERT INTO `tbl_Volunteer`
	(`fname`,
	`lname`,
	`addr`,
	`phone`,
	`email`,
	`reason`,
	`status`,
    `applied_date`)
	VALUES
	(fname,
	lname,
	addr,
	phone,
	email,
	reason,
	sstatus,
    current_date());
 
END$$

DROP PROCEDURE IF EXISTS `SP_OurObjectives`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_OurObjectives` (IN `otype` VARCHAR(10))   BEGIN
	SELECT objective FROM tbl_ourobj WHERE tbl_ourobj.type=otype;
END$$

DROP PROCEDURE IF EXISTS `SP_RecentEvent`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RecentEvent` (IN `eventType` VARCHAR(10))   BEGIN
	SET NAMES utf8;

    SELECT te.`id`,`EventTitle`,`EventDesc`,`EventDate`,`EventStartTime`,`EventEndTime`,
    `EventPlace`,`EventType`, tep.EventPhotoURL as img FROM tbl_EventsDetail te 
    LEFT JOIN (SELECT DISTINCT(FK_EventID), EventPhotoURL FROM tbl_EventPhoto GROUP BY FK_EventID ORDER BY rand() ) as tep 
    on tep.FK_EventID = te.id
    WHERE te.EventType = eventType 
    ORDER BY te.`EventDate` DESC LIMIT 10;
END$$

DROP PROCEDURE IF EXISTS `SP_RMSlideShowImg`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RMSlideShowImg` (IN `id` INT)   BEGIN
	DELETE  FROM tbl_slideshow WHERE tbl_slideshow.id = id;
    SELECT "SUCCESS" as result;
END$$

DROP PROCEDURE IF EXISTS `SP_SelectAbout`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_SelectAbout` (IN `id` INT)   BEGIN
SET NAMES utf8;
SELECT `tbl_AboutUs`.`id`,
    `tbl_AboutUs`.`WhoWeAre`,
    `tbl_AboutUs`.`PostalAddress`,
    `tbl_AboutUs`.`TelePhone`,
    `tbl_AboutUs`.`FacebookPage`,
    `tbl_AboutUs`.`TwitterPage`,
    `tbl_AboutUs`.`YoutubeVideo`,
    `tbl_AboutUs`.`GooglePlus`,
    `tbl_AboutUs`.`Logo`,
    `tbl_AboutUs`.`Email`
FROM `tbl_AboutUs`
WHERE `id` = id;
END$$

DROP PROCEDURE IF EXISTS `SP_SpecificBlog`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_SpecificBlog` (IN `id` INT)   BEGIN
	SELECT `tbl_blog`.`id`,
		`tbl_blog`.`blogTitle`,
		`tbl_blog`.`blogMsg`,
		`tbl_blog`.`blogWrittenBy`,
		`tbl_blog`.`blogPostedDate`
	FROM `tbl_blog` WHERE `tbl_blog`.`id` = id;

END$$

DROP PROCEDURE IF EXISTS `SP_UpcomingEvent`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_UpcomingEvent` (IN `eventType` VARCHAR(10))   BEGIN
	SET NAMES utf8;
    SELECT te.`id`,`EventTitle`,`EventDesc`,`EventDate`,`EventStartTime`,`EventEndTime`,
    `EventPlace`,`EventType` FROM tbl_EventsDetail te 
    WHERE DateDiff(te.`EventDate`, now()) > 1 and DateDiff(te.`EventDate`, now()) < 61
    AND te.EventType = eventType
    ORDER BY te.`EventDate` DESC;
END$$

DROP PROCEDURE IF EXISTS `SP_UpdateAbout`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_UpdateAbout` (IN `WhoWeAre` VARCHAR(1000), IN `WhatWeDo` VARCHAR(1000), IN `PostalAddress` VARCHAR(200), IN `TelePhone` VARCHAR(10), IN `FacebookPage` VARCHAR(300), IN `TwitterPage` VARCHAR(300), IN `YoutubeVideo` VARCHAR(300), IN `GooglePlus` VARCHAR(300), IN `Logo` VARCHAR(150), IN `Email` VARCHAR(50), IN `id` INT)   BEGIN
	UPDATE `tbl_AboutUs`
	SET
	`WhoWeAre` = WhoWeAre,
	`PostalAddress` = PostalAddress,
	`TelePhone` = TelePhone,
	`FacebookPage` = FacebookPage,
	`TwitterPage` = TwitterPage,
	`YoutubeVideo` = YoutubeVideo,
	`GooglePlus` = GooglePlus,
	`Logo` = Logo,
	`Email` = Email
	WHERE `id` = id;
END$$

DROP PROCEDURE IF EXISTS `SP_UpdateECH`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_UpdateECH` (IN `id` INT, IN `intro` TEXT, IN `pro` TEXT, IN `ourchildren` TEXT)   BEGIN
	UPDATE tbl_ech SET 
	`intro`=intro, `pro`=pro, `ourchildren`=ourchildren
    WHERE `id`= id;
END$$

DROP PROCEDURE IF EXISTS `SP_UpdateEvent`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_UpdateEvent` (IN `EventTitle` VARCHAR(2000), IN `EventDesc` TEXT, IN `EventDate` DATE, IN `EventStartTime` TIME, IN `EventEndTime` TIME, IN `EventPlace` VARCHAR(100), IN `EventType` VARCHAR(3), IN `eventid` INT)   BEGIN
	UPDATE tbl_EventsDetail SET
	`EventTitle` = EventTitle,
	`EventDesc` = EventDesc,
	`EventDate` = EventDate,
	`EventStartTime` = EventStartTime,
	`EventEndTime` = EventEndTime,
	`EventPlace` = EventPlace,
	`EventType` = EventType
	WHERE `id` = eventid;

END$$

DROP PROCEDURE IF EXISTS `SP_UpdateUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_UpdateUser` (IN `firstname` VARCHAR(50), IN `middlename` VARCHAR(50), IN `lastname` VARCHAR(50), IN `address` VARCHAR(100), IN `email` VARCHAR(50), IN `id` INT)   BEGIN
	UPDATE `namastelyrics`.`tbl_userprofile`
	SET
	`FName` = firstname,
	`MName` = middlename,
	`LName` = lastname,
	`Address` = address,
	`Email` = email
	WHERE `tbl_userprofile`.`id` = id;
END$$

DROP PROCEDURE IF EXISTS `SP_ValidEventTitle`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ValidEventTitle` (IN `eventTitle` VARCHAR(100))   BEGIN
	SET NAMES utf8;
	SELECT te.EventTitle from tbl_EventsDetail te WHERE 
    te.EventTitle = eventTitle;
END$$

DROP PROCEDURE IF EXISTS `SP_VolunteerApproval`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_VolunteerApproval` (IN `volunteerid` INT, IN `sstatus` SET('Approved','Not Approved','Rejected'))   BEGIN
	UPDATE tbl_Volunteer SET `status` = sstatus WHERE `id`=volunteerid;
END$$

DROP PROCEDURE IF EXISTS `SP_VolunteerList`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_VolunteerList` (IN `sstatus` VARCHAR(50))   BEGIN
	set @sn=0;
	SELECT (@sn:=@sn+1) as sn,
    `tbl_Volunteer`.`id`,
    `tbl_Volunteer`.`fname`,
    `tbl_Volunteer`.`lname`,
    `tbl_Volunteer`.`addr`,
    `tbl_Volunteer`.`phone`,
    `tbl_Volunteer`.`email`,
    `tbl_Volunteer`.`reason`,
    `tbl_Volunteer`.`status`,
    `tbl_Volunteer`.`applied_date`
	FROM `tbl_Volunteer` WHERE `status`= sstatus
    order by  applied_date desc;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_aboutus`
--

DROP TABLE IF EXISTS `tbl_aboutus`;
CREATE TABLE IF NOT EXISTS `tbl_aboutus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `WhoWeAre` text NOT NULL,
  `PostalAddress` varchar(200) NOT NULL,
  `TelePhone` varchar(10) DEFAULT NULL,
  `FacebookPage` varchar(300) DEFAULT NULL,
  `TwitterPage` varchar(300) DEFAULT NULL,
  `YoutubeVideo` varchar(300) DEFAULT NULL,
  `GooglePlus` varchar(300) DEFAULT NULL,
  `Logo` varchar(150) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 CHECKSUM=1 COLLATE=utf8_general_ci MAX_ROWS=1;

--
-- Truncate table before insert `tbl_aboutus`
--

TRUNCATE TABLE `tbl_aboutus`;
--
-- Dumping data for table `tbl_aboutus`
--

INSERT INTO `tbl_aboutus` (`id`, `WhoWeAre`, `PostalAddress`, `TelePhone`, `FacebookPage`, `TwitterPage`, `YoutubeVideo`, `GooglePlus`, `Logo`, `Email`) VALUES
(1, 'We are a non-governmental organization (NGO) based in Nepal, dedicated to uplifting communities through education, health, environment, and sustainable development initiatives. Our mission is to empower marginalized groups, support rural development, and create lasting impact through inclusive and community-driven projects.', 'Kathmandu,Nepal', '9999999', 'www.facebook.com', 'www.twitter.com', '', '', '', 'email@email.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog`
--

DROP TABLE IF EXISTS `tbl_blog`;
CREATE TABLE IF NOT EXISTS `tbl_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blogTitle` varchar(1000) NOT NULL,
  `blogMsg` text NOT NULL,
  `blogWrittenBy` varchar(200) NOT NULL,
  `blogPostedDate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncate table before insert `tbl_blog`
--

TRUNCATE TABLE `tbl_blog`;
-- --------------------------------------------------------

--
-- Table structure for table `tbl_donation`
--

DROP TABLE IF EXISTS `tbl_donation`;
CREATE TABLE IF NOT EXISTS `tbl_donation` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `invoice` varchar(300) NOT NULL,
  `trasaction_id` varchar(600) NOT NULL,
  `payer_fname` varchar(300) NOT NULL,
  `payer_lname` varchar(300) NOT NULL,
  `payer_address` varchar(300) NOT NULL,
  `payer_city` varchar(300) NOT NULL,
  `payer_state` varchar(300) NOT NULL,
  `payer_zip` varchar(300) NOT NULL,
  `payer_country` varchar(300) NOT NULL,
  `payer_email` text NOT NULL,
  `payment_status` varchar(300) NOT NULL,
  `posted_date` datetime NOT NULL,
  `amt` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncate table before insert `tbl_donation`
--

TRUNCATE TABLE `tbl_donation`;
--
-- Dumping data for table `tbl_donation`
--

INSERT INTO `tbl_donation` (`id`, `invoice`, `trasaction_id`, `payer_fname`, `payer_lname`, `payer_address`, `payer_city`, `payer_state`, `payer_zip`, `payer_country`, `payer_email`, `payment_status`, `posted_date`, `amt`) VALUES
(1, '56344ddef196e', '5CR93604GT173851G', 'Rehman', 'Malekar', 'calle VilamarÃƒÂ­ 76993- 17469', 'Albacete', 'Albacete', '02001', 'ES', 'rehman@gmail.com', 'completed', '2015-10-31 10:58:36', 670),
(2, '5634501f9be88', '1MH72225VN1679212', 'Rehman', 'Malekar', 'calle VilamarÃƒÂ­ 76993- 17469', 'Albacete', 'Albacete', '02001', 'ES', 'rehman@gmail.com', 'completed', '2015-10-31 11:08:13', 56),
(3, '563451ad03277', '9RF870598A8248327', 'Rehman', 'Malekar', 'calle VilamarÃƒÂ­ 76993- 17469', 'Albacete', 'Albacete', '02001', 'ES', 'rehman@gmail.com', 'completed', '2015-10-31 11:14:46', 3242),
(4, '56345bc43b91f', '0HJ4023476378383U', 'Rehman', 'Malekar', 'Chochhen-09', 'Bhaktapur', 'Bagmati', '44800', 'NP', 'rehman@gmail.com', 'completed', '2015-10-31 11:57:26', 15);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ech`
--

DROP TABLE IF EXISTS `tbl_ech`;
CREATE TABLE IF NOT EXISTS `tbl_ech` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intro` text NOT NULL,
  `pro` text NOT NULL,
  `ourchildren` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncate table before insert `tbl_ech`
--

TRUNCATE TABLE `tbl_ech`;
--
-- Dumping data for table `tbl_ech`
--

INSERT INTO `tbl_ech` (`id`, `intro`, `pro`, `ourchildren`) VALUES
(1, 'This is our sister company.We are a non-governmental organization (NGO) based in Nepal, dedicated to uplifting communities through education, health, environment, and sustainable development initiatives. Our mission is to empower marginalized groups, support rural development, and create lasting impact through inclusive and community-driven projects.', 'Innaguartion program detail here', 'detail about childrain welfare');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_eventphoto`
--

DROP TABLE IF EXISTS `tbl_eventphoto`;
CREATE TABLE IF NOT EXISTS `tbl_eventphoto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `EventPhotoURL` varchar(200) DEFAULT NULL,
  `FK_EventID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tbl_EventGallery_1_idx` (`FK_EventID`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncate table before insert `tbl_eventphoto`
--

TRUNCATE TABLE `tbl_eventphoto`;
--
-- Dumping data for table `tbl_eventphoto`
--

INSERT INTO `tbl_eventphoto` (`id`, `EventPhotoURL`, `FK_EventID`) VALUES
(31, '/assets/images/1/bb852b25afde53e9480fe3703888a11354bbbfad.jpg', 1),
(32, '/assets/images/1/86935a8aa1b71cb866486d9166e844d39cec7c2e.jpg', 1),
(33, '/assets/images/1/90c588a646894c78df958bd6d9661c1d81dc69cc.jpg', 1),
(34, '/assets/images/1/879a834e2c9b28f320be6a361067d483efea9a64.jpg', 1),
(35, '/assets/images/1/8d063cc6d7af441b77d16b90ce33b0fff1632bba.jpg', 1),
(36, '/assets/images/2/d237c6479fa75951c831acff2d8e1dd85981d3fc.png', 2),
(37, '/assets/images/2/edbec8a04a26b454de9ef69011c05dc90f191520.png', 2),
(38, '/assets/images/2/21762493b92ff58e6897daa56a4c04b655851ffc.png', 2),
(39, '/assets/images/2/23ce7e94efa3fe188375a3656e47a5cb3a3ffcb8.png', 2),
(40, '/assets/images/2/55f56db43e811150d3377bb0d38a9c54805b46c8.png', 2),
(41, '/assets/images/2/fc3dde4eca965e5678797313afe807014f6ec2c1.png', 2),
(42, '/assets/images/2/3698ca2414b37bd809bc56b4f49876b74c962959.png', 2),
(43, '/assets/images/3/a3e942be67c4d419f55e9d4160aace1dda0beb11.jpg', 3),
(44, '/assets/images/3/4d0934340fc572f962a57594106b4f731a24d1fe.jpg', 3),
(45, '/assets/images/3/4ea5d710b70bb03c27ede73d5ea01c32afa8797a.jpg', 3),
(46, '/assets/images/3/4ea5d710b70bb03c27ede73d5ea01c32afa8797a.jpg', 3),
(47, '/assets/images/3/0e365b1529c7b0edb587bb6b6c90ec51162b4a6e.jpg', 3),
(48, '/assets/images/3/ca7a3365b53d8da557d1ff1dceb4312ba4b361fa.jpg', 3),
(49, '/assets/images/3/b7afb2c6efeed3d31357021f05591af5334e6f4b.jpg', 3),
(56, '/assets/images/4/f27ce43cd96cc7dd9f4f12bc132aa4227251c659.jpg', 4),
(57, '/assets/images/4/bd7745cb35585221f6ff20ff0dca0d40b168d683.jpg', 4),
(58, '/assets/images/4/87f9856cbe5eaff05595e6b7895781d829832d0e.jpg', 4),
(59, '/assets/images/4/134e77da0749b68c2c2480b8600cb1b413fcd060.jpg', 4),
(60, '/assets/images/4/55c331cf7a536d8ff30b5221620ad0ace493979b.jpg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_eventsdetail`
--

DROP TABLE IF EXISTS `tbl_eventsdetail`;
CREATE TABLE IF NOT EXISTS `tbl_eventsdetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '	',
  `EventTitle` varchar(2000) NOT NULL,
  `EventDesc` text NOT NULL,
  `EventDate` date NOT NULL,
  `EventStartTime` time NOT NULL,
  `EventEndTime` time NOT NULL,
  `EventPlace` varchar(100) NOT NULL,
  `EventType` set('Parent','Children') NOT NULL,
  `IsCancelled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncate table before insert `tbl_eventsdetail`
--

TRUNCATE TABLE `tbl_eventsdetail`;
--
-- Dumping data for table `tbl_eventsdetail`
--

INSERT INTO `tbl_eventsdetail` (`id`, `EventTitle`, `EventDesc`, `EventDate`, `EventStartTime`, `EventEndTime`, `EventPlace`, `EventType`, `IsCancelled`) VALUES
(1, 'Event1:Child welfare', 'Helth check up for children', '2015-07-18', '10:00:00', '05:00:00', 'Kathmandu', 'Parent', b'0'),
(2, 'Event 2', 'event 2 desc', '2015-05-22', '10:00:00', '05:00:00', 'Kathmandu', 'Parent', b'0'),
(3, 'Event 3', 'desc', '2015-05-05', '10:00:00', '05:00:00', 'Kathmandu', 'Parent', b'0'),
(4, 'event 4', 'desc', '2014-09-11', '10:00:00', '05:00:00', 'Kathmandu', 'Parent', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_eventvideo`
--

DROP TABLE IF EXISTS `tbl_eventvideo`;
CREATE TABLE IF NOT EXISTS `tbl_eventvideo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `EventVideoURL` varchar(200) NOT NULL,
  `FK_EventId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_EventId_idx` (`FK_EventId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncate table before insert `tbl_eventvideo`
--

TRUNCATE TABLE `tbl_eventvideo`;
-- --------------------------------------------------------

--
-- Table structure for table `tbl_logininfo`
--

DROP TABLE IF EXISTS `tbl_logininfo`;
CREATE TABLE IF NOT EXISTS `tbl_logininfo` (
  `id` int(11) UNSIGNED NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(500) NOT NULL,
  `TempPassword` varchar(50) DEFAULT NULL,
  `FK_UserID` int(11) UNSIGNED NOT NULL,
  `UserRole` varchar(45) NOT NULL DEFAULT 'User',
  `isAuthenticated` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `UserName_UNIQUE` (`UserName`),
  KEY `tbl_LogInInfo` (`FK_UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncate table before insert `tbl_logininfo`
--

TRUNCATE TABLE `tbl_logininfo`;
--
-- Dumping data for table `tbl_logininfo`
--

INSERT INTO `tbl_logininfo` (`id`, `UserName`, `Password`, `TempPassword`, `FK_UserID`, `UserRole`, `isAuthenticated`) VALUES
(1, 'rmalekar', 'P@$$w0rd', '', 1, 'admin', b'1'),
(2, 'admin', 'P@$$w0rd', '', 2, 'admin', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ourobj`
--

DROP TABLE IF EXISTS `tbl_ourobj`;
CREATE TABLE IF NOT EXISTS `tbl_ourobj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `objective` varchar(2000) NOT NULL,
  `type` set('Parent','Sister') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncate table before insert `tbl_ourobj`
--

TRUNCATE TABLE `tbl_ourobj`;
--
-- Dumping data for table `tbl_ourobj`
--

INSERT INTO `tbl_ourobj` (`id`, `objective`, `type`) VALUES
(1, 'We collaborate with governmental and non-governmental agencies and suitably intervene in policy development for children’s welfare.', 'Parent'),
(2, 'We run  children’s home for orphan and helpless children with prior permission from Nepal government to provide family environment, love, respect and security to orphaned and     abandoned children.', 'Parent'),
(3, 'We intend to bring the street children to our children’s home and help to secure their future.', 'Parent'),
(4, 'We create a means for providing medical assistance to the helpless and orphan children with diseases with the establishment of a medical fund.', 'Sister'),
(5, 'We create a scholarship fund and provide scholarship to poor and genius students.', 'Sister'),
(6, 'We run the awareness program to end child labor.', 'Sister'),
(7, 'We run education programs for parents and teachers about children’s right.', 'Sister'),
(8, 'We organize educational programs for promoting immunization, breast feeding and nutrition.', 'Parent'),
(9, 'We organize the awareness campaign for the social security of disabled, widows and elderly people.', 'Sister');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_scholarshipholder`
--

DROP TABLE IF EXISTS `tbl_scholarshipholder`;
CREATE TABLE IF NOT EXISTS `tbl_scholarshipholder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `Class` varchar(45) NOT NULL,
  `School` varchar(150) NOT NULL,
  `age` tinyint(4) NOT NULL,
  `familyBackground` varchar(200) NOT NULL,
  `providedDate` date NOT NULL,
  `imgURL` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncate table before insert `tbl_scholarshipholder`
--

TRUNCATE TABLE `tbl_scholarshipholder`;
--
-- Dumping data for table `tbl_scholarshipholder`
--

INSERT INTO `tbl_scholarshipholder` (`id`, `FirstName`, `LastName`, `Class`, `School`, `age`, `familyBackground`, `providedDate`, `imgURL`) VALUES
(1, 'Ram', 'Hari', 'LKG', 'Saraswoti English Secondary School', 5, 'handicapped father and mother working as a laborer.', '0000-00-00', '/assets/images/scholarshipholder/subodh-shrestha.jpg'),
(2, 'Hari ', 'Shyam', '5', 'Saraswoti English Secondary School', 12, 'father died a year ago in a road traffic accident. Mother works as a laborer, two other siblings in the family', '0000-00-00', '/assets/images/scholarshipholder/saru-lama.jpg'),
(3, 'Gita', 'Sita', '6', 'Saraswoti English Secondary School', 14, 'Family member 4,father laborer, Mother physically disabled.\n\n', '0000-00-00', '/assets/images/scholarshipholder/nani-maya.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slideshow`
--

DROP TABLE IF EXISTS `tbl_slideshow`;
CREATE TABLE IF NOT EXISTS `tbl_slideshow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slideshowImgUrl` varchar(200) NOT NULL,
  `caption` varchar(45) DEFAULT NULL,
  `EventType` set('ECH','MFN') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slideshowImgUrl_UNIQUE` (`slideshowImgUrl`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 CHECKSUM=1 COLLATE=utf8_general_ci MAX_ROWS=5;

--
-- Truncate table before insert `tbl_slideshow`
--

TRUNCATE TABLE `tbl_slideshow`;
--
-- Dumping data for table `tbl_slideshow`
--

INSERT INTO `tbl_slideshow` (`id`, `slideshowImgUrl`, `caption`, `EventType`) VALUES
(11, '/assets/images/SlideShowIMg/MFN/4d0934340fc572f962a57594106b4f731a24d1fe.jpg', '', 'MFN'),
(12, '/assets/images/SlideShowIMg/MFN/0e365b1529c7b0edb587bb6b6c90ec51162b4a6e.jpg', '', 'MFN'),
(14, '/assets/images/SlideShowIMg/MFN/ece8b86c92f0053970bf7cb52f9d23da13517272.jpg', '', 'MFN'),
(15, '/assets/images/SlideShowIMg/MFN/b5efc7b25b2b33c956c522d512122c32472a3cdb.jpg', '', 'MFN');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_userprofile`
--

DROP TABLE IF EXISTS `tbl_userprofile`;
CREATE TABLE IF NOT EXISTS `tbl_userprofile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FName` varchar(50) NOT NULL,
  `MName` varchar(50) DEFAULT NULL,
  `LName` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `RegisteredDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Email_UNIQUE` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncate table before insert `tbl_userprofile`
--

TRUNCATE TABLE `tbl_userprofile`;
--
-- Dumping data for table `tbl_userprofile`
--

INSERT INTO `tbl_userprofile` (`id`, `FName`, `MName`, `LName`, `Address`, `Email`, `RegisteredDate`) VALUES
(1, 'Rehman', '', 'Malekar', 'Bhaktapur', 'rmalekar@email.com', '2015-02-01 00:00:00'),
(2, 'Ram', '', 'Malekar', 'Bhaktapur', 'ram@email.com', '2015-03-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_volunteer`
--

DROP TABLE IF EXISTS `tbl_volunteer`;
CREATE TABLE IF NOT EXISTS `tbl_volunteer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(45) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `addr` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `reason` varchar(500) NOT NULL,
  `status` set('Approved','Not Approved','Rejected') NOT NULL,
  `applied_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Truncate table before insert `tbl_volunteer`
--

TRUNCATE TABLE `tbl_volunteer`;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_eventphoto`
--
ALTER TABLE `tbl_eventphoto`
  ADD CONSTRAINT `fk_eventId` FOREIGN KEY (`FK_EventID`) REFERENCES `tbl_eventsdetail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_eventvideo`
--
ALTER TABLE `tbl_eventvideo`
  ADD CONSTRAINT `fk_EventIDVideo` FOREIGN KEY (`FK_EventId`) REFERENCES `tbl_eventsdetail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
