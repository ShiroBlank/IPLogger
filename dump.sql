-- Adminer 4.7.9 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `iplogger` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `iplogger`;

CREATE TABLE `rejectedua` (
  `UAString` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `users` (
  `ip` varchar(20) NOT NULL,
  `country` varchar(30) NOT NULL,
  `logtime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 2021-02-09 17:20:10
