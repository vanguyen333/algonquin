
--
-- Database: `assignment2VNDemo` and php web application user
CREATE DATABASE assignment2VNDemo;
GRANT USAGE ON *.* TO 'appuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON assignment2VNDemo.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

USE assignment2VNDemo;


--
-- Table structure for table `petcollection`
--

CREATE TABLE IF NOT EXISTS `petcollection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `birthdate` DATE NOT NULL,
  `image` varchar(255),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4;


