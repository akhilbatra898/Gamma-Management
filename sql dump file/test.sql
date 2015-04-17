-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2014 at 12:46 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `EmployeeSr` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `contact_number` int(10) NOT NULL DEFAULT '0',
  `bank_account_number` varchar(40) NOT NULL DEFAULT '',
  `date_of_joining` date DEFAULT NULL,
  `salary` mediumint(8) DEFAULT '0',
  `loan_amount_allowed` mediumint(8) DEFAULT '0',
  `bonus` mediumint(6) DEFAULT '0',
  `Password` varchar(60) NOT NULL DEFAULT 'iiit123',
  `AccessLevel` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`EmployeeSr`),
  UNIQUE KEY `EmployeeSr` (`EmployeeSr`),
  UNIQUE KEY `AccessLevel` (`AccessLevel`),
  UNIQUE KEY `employee_id` (`employee_id`),
  KEY `AccessLevel_2` (`AccessLevel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=991 ;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`EmployeeSr`, `employee_id`, `name`, `contact_number`, `bank_account_number`, `date_of_joining`, `salary`, `loan_amount_allowed`, `bonus`, `Password`, `AccessLevel`) VALUES
(2, 'Admin', 'Admin', 2147483647, '45645644', NULL, 0, 0, 0, 'iiit123', 3),
(5, 'MR22', 'Manufacturer', 4578958, 'gdsgf', '0000-00-00', 0, 0, 0, 'iiit123', 1),
(990, 'F', 'Finance', 123456789, '11234', '2014-11-17', 70000, 1000000, 45000, 'iiit123', 2);

-- --------------------------------------------------------

--
-- Table structure for table `expenditure`
--

CREATE TABLE IF NOT EXISTS `expenditure` (
  `ExpSR` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `purpose` text NOT NULL,
  `amount` float NOT NULL DEFAULT '0',
  `date_of_payment` date NOT NULL,
  `signee` varchar(100) NOT NULL,
  PRIMARY KEY (`ExpSR`),
  UNIQUE KEY `ExpSR` (`ExpSR`),
  KEY `signee` (`signee`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `expenditure`
--

INSERT INTO `expenditure` (`ExpSR`, `purpose`, `amount`, `date_of_payment`, `signee`) VALUES
(1, 'Travel to Cologne for WEF', 200000, '2014-11-04', 'MR22');

-- --------------------------------------------------------

--
-- Table structure for table `input`
--

CREATE TABLE IF NOT EXISTS `input` (
  `InpSR` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product` varchar(50) NOT NULL,
  `raw_inputs` text NOT NULL,
  `weight` int(11) NOT NULL,
  `volume` mediumtext NOT NULL,
  `initial_temp` int(11) NOT NULL,
  PRIMARY KEY (`InpSR`),
  UNIQUE KEY `product` (`product`),
  UNIQUE KEY `InpSR` (`InpSR`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `input`
--

INSERT INTO `input` (`InpSR`, `product`, `raw_inputs`, `weight`, `volume`, `initial_temp`) VALUES
(1, 'Toluene', 'Methyl Iso Cyanate', 1, '10 Tonnes', 80),
(2, 'Xylene', 'Anilene, Fern Oil', 230, '223', 112),
(3, 'Alyne', 'Alline', 23, '90', 89),
(4, 'kyles', '1', 22, '12', 890);

-- --------------------------------------------------------

--
-- Table structure for table `intermediate`
--

CREATE TABLE IF NOT EXISTS `intermediate` (
  `MediateSR` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product` varchar(50) DEFAULT NULL,
  `concentration` float NOT NULL,
  `temp` float NOT NULL,
  `transfer_rate` float NOT NULL,
  `time_taken` float NOT NULL,
  `amount` float NOT NULL,
  PRIMARY KEY (`MediateSR`),
  UNIQUE KEY `MediateSR` (`MediateSR`),
  KEY `product` (`product`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `intermediate`
--

INSERT INTO `intermediate` (`MediateSR`, `product`, `concentration`, `temp`, `transfer_rate`, `time_taken`, `amount`) VALUES
(1, 'Xylene', 123, 112, 11, 24, 1123),
(3, 'Toluene', 90, 70, 45, 2.5, 900),
(4, 'kyles', 123, 112, 11, 23, 1123);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `OrderSR` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `org_paid` varchar(75) NOT NULL,
  `mode_of_shipment` enum('air','sea','road','rail') DEFAULT NULL,
  `date_of_delivery` date DEFAULT NULL,
  `amount_paid` float NOT NULL,
  PRIMARY KEY (`OrderSR`),
  UNIQUE KEY `OrderSR` (`OrderSR`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderSR`, `org_paid`, `mode_of_shipment`, `date_of_delivery`, `amount_paid`) VALUES
(1, 'Bayer India', 'sea', '2014-11-26', 2500);

-- --------------------------------------------------------

--
-- Table structure for table `output`
--

CREATE TABLE IF NOT EXISTS `output` (
  `OutputSR` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product` varchar(50) NOT NULL,
  `volume` float NOT NULL,
  `temp` float NOT NULL,
  `storage_needed` float DEFAULT NULL,
  `curr_market_val` float NOT NULL,
  PRIMARY KEY (`OutputSR`),
  UNIQUE KEY `OutputSR` (`OutputSR`),
  KEY `product` (`product`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `output`
--

INSERT INTO `output` (`OutputSR`, `product`, `volume`, `temp`, `storage_needed`, `curr_market_val`) VALUES
(1, 'Toluene', 234, 112, 2.6, 2456),
(10, 'Xylene', 234, 6, 89, 90);

-- --------------------------------------------------------

--
-- Table structure for table `preorder`
--

CREATE TABLE IF NOT EXISTS `preorder` (
  `PreSR` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `good_name` varchar(50) NOT NULL,
  `transacting_org` varchar(75) NOT NULL,
  `country` varchar(75) NOT NULL,
  `currency` enum('USD','INR','EUR','POUND') DEFAULT NULL,
  `currency_rate` float DEFAULT NULL,
  `import_duty` float NOT NULL,
  `availability` int(11) DEFAULT NULL,
  PRIMARY KEY (`PreSR`),
  UNIQUE KEY `PreSR` (`PreSR`),
  KEY `currency` (`currency`),
  KEY `good_name` (`good_name`,`transacting_org`,`country`,`currency`,`currency_rate`,`import_duty`,`availability`),
  KEY `good_name_2` (`good_name`,`transacting_org`,`country`,`currency`,`currency_rate`,`import_duty`,`availability`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `preorder`
--

INSERT INTO `preorder` (`PreSR`, `good_name`, `transacting_org`, `country`, `currency`, `currency_rate`, `import_duty`, `availability`) VALUES
(1, 'Anilene', 'Max Plank Inc', 'UK', 'POUND', 78, 45, 90),
(2, 'Xylene', 'Bayer', 'Germany', 'EUR', 98, 23.5, 68);

-- --------------------------------------------------------

--
-- Table structure for table `raw_material`
--

CREATE TABLE IF NOT EXISTS `raw_material` (
  `RawSR` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `material` varchar(50) NOT NULL,
  `market_rate` int(11) NOT NULL,
  `volume` float NOT NULL,
  `expected_use` varchar(50) NOT NULL,
  `final_use` varchar(50) NOT NULL,
  `date_of_next_order` date DEFAULT NULL,
  `expiry` date NOT NULL,
  PRIMARY KEY (`RawSR`),
  UNIQUE KEY `RawSR` (`RawSR`),
  KEY `expected_use` (`expected_use`),
  KEY `final_use` (`final_use`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `raw_material`
--

INSERT INTO `raw_material` (`RawSR`, `material`, `market_rate`, `volume`, `expected_use`, `final_use`, `date_of_next_order`, `expiry`) VALUES
(1, 'Anilyne', 34, 5667, 'Toluene', 'Toluene', '2014-11-26', '2015-03-06');

-- --------------------------------------------------------

--
-- Table structure for table `resale`
--

CREATE TABLE IF NOT EXISTS `resale` (
  `ResaleSR` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `available` float NOT NULL,
  `tax` float DEFAULT '0',
  `market_rate` float NOT NULL,
  `cost_price` float NOT NULL,
  PRIMARY KEY (`ResaleSR`),
  UNIQUE KEY `ResaleSR` (`ResaleSR`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `resale`
--

INSERT INTO `resale` (`ResaleSR`, `available`, `tax`, `market_rate`, `cost_price`) VALUES
(2, 234, 23, 243, 225);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
  `StockSR` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product` varchar(50) NOT NULL,
  `market_rate` int(11) NOT NULL,
  `shelf_life` int(11) NOT NULL,
  PRIMARY KEY (`StockSR`),
  UNIQUE KEY `StockSR` (`StockSR`),
  KEY `product` (`product`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`StockSR`, `product`, `market_rate`, `shelf_life`) VALUES
(1, 'Toluene', 17, 38),
(5, 'Xylene', 12, 90);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `TaskSR` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `task_name` varchar(255) NOT NULL,
  `assigned_to` varchar(10) NOT NULL,
  `role` varchar(100) NOT NULL,
  `tasks` text,
  `due_date` date DEFAULT NULL,
  PRIMARY KEY (`TaskSR`),
  UNIQUE KEY `TaskSR` (`TaskSR`),
  KEY `assigned_to` (`assigned_to`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`TaskSR`, `task_name`, `assigned_to`, `role`, `tasks`, `due_date`) VALUES
(1, 'Revaluation of Office Assts', 'MR22', 'Work with CA', 'Get Assets and Liabilities calculated', '2014-11-30'),
(3, 'Assign Work', 'MR22', 'Receive the CEO', 'Arrange Car', '2014-09-09');

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE IF NOT EXISTS `tax` (
  `TaxSR` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `authority` varchar(200) DEFAULT NULL,
  `tax_slab` mediumtext,
  `tax_rate` int(11) NOT NULL,
  `commodity_name` varchar(100) NOT NULL,
  PRIMARY KEY (`TaxSR`),
  UNIQUE KEY `TaxSR` (`TaxSR`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`TaxSR`, `authority`, `tax_slab`, `tax_rate`, `commodity_name`) VALUES
(1, 'Central Excise', '12.5% on VAT', 12, 'Oil Paint');

-- --------------------------------------------------------

--
-- Table structure for table `transit`
--

CREATE TABLE IF NOT EXISTS `transit` (
  `TranSR` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `carrier` varchar(50) NOT NULL,
  `route` varchar(150) NOT NULL,
  `documents_required` text,
  `place_of_delivery` varchar(50) NOT NULL,
  PRIMARY KEY (`TranSR`),
  UNIQUE KEY `TranSR` (`TranSR`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `transit`
--

INSERT INTO `transit` (`TranSR`, `carrier`, `route`, `documents_required`, `place_of_delivery`) VALUES
(1, 'Goldman Sachs', 'Srilanka', 'Customs Clearance, Import Permit', 'Mumbai'),
(3, 'Gati', 'Srilanka', 'Import Permit', 'Chennai');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `expenditure`
--
ALTER TABLE `expenditure`
  ADD CONSTRAINT `expenditure_ibfk_1` FOREIGN KEY (`signee`) REFERENCES `employees` (`employee_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `intermediate`
--
ALTER TABLE `intermediate`
  ADD CONSTRAINT `intermediate_ibfk_1` FOREIGN KEY (`product`) REFERENCES `input` (`product`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `output`
--
ALTER TABLE `output`
  ADD CONSTRAINT `output_ibfk_1` FOREIGN KEY (`product`) REFERENCES `input` (`product`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `raw_material`
--
ALTER TABLE `raw_material`
  ADD CONSTRAINT `raw_material_ibfk_1` FOREIGN KEY (`expected_use`) REFERENCES `input` (`product`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `raw_material_ibfk_2` FOREIGN KEY (`final_use`) REFERENCES `input` (`product`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`product`) REFERENCES `input` (`product`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
