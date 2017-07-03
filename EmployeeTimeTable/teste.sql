-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 09, 2017 at 07:07 PM
-- Server version: 5.5.54-0+deb8u1
-- PHP Version: 5.6.29-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `teste`
--
CREATE DATABASE IF NOT EXISTS `teste` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `teste`;

-- --------------------------------------------------------

--
-- Table structure for table `Funcionario`
--

CREATE TABLE IF NOT EXISTS `Funcionario` (
`id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `morada` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tag` varchar(15) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Funcionario`
--

INSERT INTO `Funcionario` (`id`, `nome`, `data_nascimento`, `morada`, `email`, `tag`) VALUES
(19, 'Carlos Jose Pascoal', '1963-07-31', 'Rua Santa Helena', NULL, '695517279'),
(21, 'Manuel Pascoal', '1961-06-19', 'Avenida do aeroporto', NULL, '10118117379'),
(23, 'Emilia Silva', '1955-09-01', '', NULL, '5413018245'),
(24, 'Ana Oliveira', '1968-12-11', '', NULL, '1982521246'),
(25, 'Conceicao Silva', '1965-05-12', '', NULL, '23021017745'),
(26, 'Conceicao Pascoal\r\n\r\n\r\n', '1962-10-27', '', NULL, '24510711780');

-- --------------------------------------------------------

--
-- Table structure for table `registo`
--

CREATE TABLE IF NOT EXISTS `registo` (
`id` int(11) NOT NULL,
  `data` date NOT NULL,
  `entrada` time DEFAULT NULL,
  `saida` time DEFAULT NULL,
  `Funcionario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Funcionario`
--
ALTER TABLE `Funcionario`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registo`
--
ALTER TABLE `registo`
 ADD PRIMARY KEY (`id`), ADD KEY `Funcionario_id` (`Funcionario_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Funcionario`
--
ALTER TABLE `Funcionario`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `registo`
--
ALTER TABLE `registo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `registo`
--
ALTER TABLE `registo`
ADD CONSTRAINT `registo_ibfk_1` FOREIGN KEY (`Funcionario_id`) REFERENCES `Funcionario` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
