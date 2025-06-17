-- MySQL dump for World database
-- Example database for lab7 Docker exercise

CREATE DATABASE IF NOT EXISTS world;
USE world;

-- Table structure for table `city`
CREATE TABLE IF NOT EXISTS `city` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` char(35) NOT NULL DEFAULT '',
  `CountryCode` char(3) NOT NULL DEFAULT '',
  `District` char(20) NOT NULL DEFAULT '',
  `Population` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `CountryCode` (`CountryCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table `city`
INSERT INTO `city` (`ID`, `Name`, `CountryCode`, `District`, `Population`) VALUES
(1, 'Kabul', 'AFG', 'Kabol', 1780000),
(2, 'Qandahar', 'AFG', 'Qandahar', 237500),
(3, 'Herat', 'AFG', 'Herat', 186800),
(4, 'Mazar-e-Sharif', 'AFG', 'Balkh', 127800),
(5, 'Amsterdam', 'NLD', 'Noord-Holland', 731200),
(6, 'Rotterdam', 'NLD', 'Zuid-Holland', 593321),
(7, 'Haag', 'NLD', 'Zuid-Holland', 440900),
(8, 'Utrecht', 'NLD', 'Utrecht', 234323),
(9, 'Eindhoven', 'NLD', 'Noord-Brabant', 201843),
(10, 'Tilburg', 'NLD', 'Noord-Brabant', 193238),
(11, 'Groningen', 'NLD', 'Groningen', 172701),
(12, 'Breda', 'NLD', 'Noord-Brabant', 160398),
(13, 'Apeldoorn', 'NLD', 'Gelderland', 153491),
(14, 'Nijmegen', 'NLD', 'Gelderland', 152463),
(15, 'Enschede', 'NLD', 'Overijssel', 149544);

-- Table structure for table `country`
CREATE TABLE IF NOT EXISTS `country` (
  `Code` char(3) NOT NULL DEFAULT '',
  `Name` char(52) NOT NULL DEFAULT '',
  `Continent` enum('Asia','Europe','North America','Africa','Oceania','Antarctica','South America') NOT NULL DEFAULT 'Asia',
  `Region` char(26) NOT NULL DEFAULT '',
  `SurfaceArea` float(10,2) NOT NULL DEFAULT '0.00',
  `IndepYear` smallint(6) DEFAULT NULL,
  `Population` int(11) NOT NULL DEFAULT '0',
  `LifeExpectancy` float(3,1) DEFAULT NULL,
  `GNP` float(10,2) DEFAULT NULL,
  `GNPOld` float(10,2) DEFAULT NULL,
  `LocalName` char(45) NOT NULL DEFAULT '',
  `GovernmentForm` char(45) NOT NULL DEFAULT '',
  `HeadOfState` char(60) DEFAULT NULL,
  `Capital` int(11) DEFAULT NULL,
  `Code2` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table `country`
INSERT INTO `country` (`Code`, `Name`, `Continent`, `Region`, `SurfaceArea`, `IndepYear`, `Population`, `LifeExpectancy`, `GNP`, `GNPOld`, `LocalName`, `GovernmentForm`, `HeadOfState`, `Capital`, `Code2`) VALUES
('AFG', 'Afghanistan', 'Asia', 'Southern and Central Asia', 652090.00, 1919, 22720000, 45.9, 5976.00, NULL, 'Afganistan/Afqanestan', 'Islamic Emirate', 'Mohammad Omar', 1, 'AF'),
('NLD', 'Netherlands', 'Europe', 'Western Europe', 41526.00, 1581, 15864000, 78.3, 371362.00, 360478.00, 'Nederland', 'Constitutional Monarchy', 'Beatrix', 5, 'NL'),
('POL', 'Poland', 'Europe', 'Eastern Europe', 323250.00, 1918, 38653600, 73.2, 151697.00, 135636.00, 'Polska', 'Republic', 'Aleksander Kwasniewski', 16, 'PL');

-- Table structure for table `countrylanguage`
CREATE TABLE IF NOT EXISTS `countrylanguage` (
  `CountryCode` char(3) NOT NULL DEFAULT '',
  `Language` char(30) NOT NULL DEFAULT '',
  `IsOfficial` enum('T','F') NOT NULL DEFAULT 'F',
  `Percentage` float(4,1) NOT NULL DEFAULT '0.0',
  PRIMARY KEY (`CountryCode`,`Language`),
  KEY `CountryCode` (`CountryCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table `countrylanguage`
INSERT INTO `countrylanguage` (`CountryCode`, `Language`, `IsOfficial`, `Percentage`) VALUES
('AFG', 'Pashto', 'T', 52.4),
('AFG', 'Dari', 'T', 32.1),
('AFG', 'Uzbek', 'F', 8.8),
('NLD', 'Dutch', 'T', 95.6),
('NLD', 'Frisian', 'F', 3.7),
('POL', 'Polish', 'T', 97.6),
('POL', 'German', 'F', 1.3);
