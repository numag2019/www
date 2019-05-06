-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Jeu 27 Septembre 2007 à 21:40
-- Version du serveur: 5.0.41
-- Version de PHP: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de données: `tuto_jp_graph`
-- 
DROP DATABASE `tuto_jp_graph`;
CREATE DATABASE `tuto_jp_graph` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `tuto_jp_graph`;

-- --------------------------------------------------------

-- 
-- Structure de la table `ventes`
-- 

CREATE TABLE IF NOT EXISTS `ventes` (
  `ID` int(11) NOT NULL auto_increment,
  `DTHR_VENTE` date NOT NULL,
  `TYPE_PRODUIT` enum('logiciel','materiel','service') NOT NULL,
  `PRIX` int(11) NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `DTHR_VENTE` (`DTHR_VENTE`,`TYPE_PRODUIT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=110 ;

-- 
-- Contenu de la table `ventes`
-- 

INSERT INTO `ventes` (`ID`, `DTHR_VENTE`, `TYPE_PRODUIT`, `PRIX`) VALUES 
(1, '2004-01-12', 'logiciel', 1200),
(2, '2004-03-15', 'logiciel', 2500),
(3, '2004-05-17', 'materiel', 600),
(4, '2004-06-05', 'service', 200),
(5, '2004-07-15', 'materiel', 170),
(6, '2004-11-15', 'service', 2500),
(7, '2004-12-15', 'logiciel', 1000),
(8, '2005-01-02', 'logiciel', 1300),
(9, '2005-01-15', 'materiel', 250),
(10, '2005-03-23', 'service', 300),
(11, '2005-02-15', 'logiciel', 600),
(12, '2005-04-12', 'service', 250),
(13, '2005-05-06', 'materiel', 1600),
(14, '2005-04-13', 'logiciel', 1700),
(15, '2005-04-23', 'materiel', 1000),
(16, '2005-05-12', 'service', 240),
(17, '2005-05-23', 'logiciel', 2400),
(18, '2005-05-25', 'logiciel', 1500),
(19, '2005-06-01', 'service', 170),
(20, '2005-06-06', 'service', 140),
(21, '2005-06-23', 'service', 2000),
(22, '2005-06-25', 'service', 270),
(23, '2005-07-01', 'materiel', 1500),
(24, '2005-08-13', 'logiciel', 1200),
(25, '2005-09-01', 'materiel', 1000),
(26, '2005-09-10', 'service', 2700),
(27, '2005-09-19', 'materiel', 500),
(28, '2005-09-25', 'service', 300),
(29, '2005-10-14', 'materiel', 300),
(30, '2005-10-19', 'materiel', 300),
(31, '2005-10-27', 'service', 300),
(32, '2005-11-23', 'service', 250),
(33, '2005-11-24', 'logiciel', 500),
(34, '2005-11-27', 'materiel', 360),
(35, '2005-12-01', 'logiciel', 500),
(36, '2005-12-05', 'service', 500),
(37, '2005-12-15', 'service', 3000),
(38, '2005-12-17', 'logiciel', 1600),
(39, '2005-12-20', 'materiel', 300),
(40, '2005-12-24', 'materiel', 1200),
(41, '2005-12-24', 'materiel', 300),
(42, '2006-01-01', 'logiciel', 500),
(43, '2006-01-05', 'service', 290),
(44, '2006-01-25', 'materiel', 1600),
(45, '2006-02-01', 'materiel', 300),
(46, '2006-02-05', 'logiciel', 1400),
(47, '2006-02-10', 'service', 2000),
(48, '2006-02-13', 'service', 390),
(49, '2006-02-23', 'materiel', 400),
(50, '2006-02-23', 'materiel', 1500),
(51, '2006-03-02', 'service', 200),
(52, '2006-03-05', 'materiel', 300),
(53, '2006-03-15', 'logiciel', 400),
(54, '2006-03-22', 'service', 2000),
(55, '2006-03-27', 'materiel', 300),
(56, '2006-04-01', 'service', 400),
(57, '2006-04-02', 'logiciel', 1600),
(58, '2006-04-10', 'service', 3000),
(59, '2006-04-02', 'materiel', 2000),
(60, '2006-04-20', 'materiel', 300),
(61, '2006-04-25', 'logiciel', 1700),
(62, '2006-04-27', 'materiel', 300),
(63, '2006-05-01', 'materiel', 1500),
(64, '2006-05-07', 'service', 300),
(65, '2006-04-11', 'logiciel', 1000),
(66, '2006-05-13', 'service', 300),
(67, '2006-05-15', 'service', 400),
(68, '2006-05-17', 'service', 3000),
(69, '2006-06-10', 'materiel', 380),
(70, '2006-06-14', 'service', 480),
(71, '2006-06-20', 'service', 3700),
(72, '2006-06-27', 'materiel', 340),
(73, '2006-07-10', 'materiel', 360),
(74, '2006-07-23', 'logiciel', 500),
(75, '2006-07-28', 'service', 3800),
(76, '2006-08-16', 'service', 3000),
(77, '2006-09-02', 'materiel', 1700),
(78, '2006-09-04', 'service', 3000),
(79, '2006-09-10', 'service', 400),
(80, '2006-09-10', 'materiel', 300),
(81, '2006-09-15', 'service', 400),
(82, '2006-09-20', 'logiciel', 1000),
(83, '2006-09-02', 'materiel', 1800),
(84, '2006-09-27', 'materiel', 300),
(85, '2006-10-01', 'service', 3700),
(86, '2006-10-02', 'logiciel', 400),
(87, '2006-10-10', 'service', 3200),
(88, '2006-10-19', 'service', 1600),
(89, '2006-10-23', 'service', 400),
(90, '2006-10-27', 'materiel', 300),
(91, '2006-10-28', 'materiel', 300),
(92, '2006-11-03', 'service', 3900),
(93, '2006-11-10', 'materiel', 1400),
(94, '2006-11-14', 'materiel', 300),
(95, '2006-11-15', 'service', 2000),
(96, '2006-11-15', 'service', 400),
(97, '2006-11-20', 'logiciel', 1400),
(98, '2006-11-23', 'materiel', 390),
(99, '2006-12-02', 'service', 3000),
(100, '2006-12-05', 'materiel', 300),
(101, '2006-12-10', 'materiel', 300),
(102, '2006-12-18', 'materiel', 1400),
(103, '2006-12-19', 'materiel', 1500),
(104, '2006-12-22', 'materiel', 400),
(105, '2006-12-23', 'materiel', 490),
(106, '2006-12-24', 'materiel', 2000),
(107, '2006-12-11', 'service', 2500),
(108, '2006-01-17', 'service', 2000),
(109, '2006-08-24', 'materiel', 500);

