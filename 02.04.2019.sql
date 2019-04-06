-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 02, 2019 at 02:56 PM
-- Server version: 5.6.41-84.1
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `geoweb_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `shidni_users`
--

CREATE TABLE `shidni_users` (
  `id` int(11) NOT NULL,
  `created_date` int(11) NOT NULL DEFAULT '0',
  `user_type` set('manager','user') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `lastname` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `contact_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `permission_company` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  `permission_buldings` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  `permission_entrance` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  `permission_floor` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  `permission_room` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shidni_users`
--

INSERT INTO `shidni_users` (`id`, `created_date`, `user_type`, `firstname`, `lastname`, `username`, `password`, `contact_email`, `contact_phone`, `permission_company`, `permission_buldings`, `permission_entrance`, `permission_floor`, `permission_room`, `status`) VALUES
(1, 1554234534, 'manager', 'გიორგი', 'გვაზავა', 'administrator', 'e10adc3949ba59abbe56e057f20f883e', 'giorgigvazava87@gmail.com', '995599623555 ', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 0),
(2, 1553874431, 'user', 'პედრო', 'ალმადოვარი', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'pedroalma@gmail.com', '995577595959', 'none', 'none', 'none', 'none', 'none', 1),
(3, 1554040742, 'manager', 'ვაკო', 'აფხაზავა', 'vako', 'e10adc3949ba59abbe56e057f20f883e', 'v.apkhazava@gmail.com', '591224400', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 0),
(4, 1554040588, 'user', 'ჯუმბერ', 'ჯუმბერა', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'jumber@mail.ru', '55355656565', 'none', 'none', 'none', 'none', 'add,edit,delete', 0),
(5, 1554040713, 'user', 'test', 'tesad', 'hjbjhb', '2cd86f8a4f55e48631e56227db84d3a9', 'bjhbhj@sdd.ge', '561265651', 'none', 'none', 'none', 'none', 'add,edit,delete', 1);

-- --------------------------------------------------------

--
-- Table structure for table `shindi_buildings`
--

CREATE TABLE `shindi_buildings` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `map_coordinates` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shindi_buildings`
--

INSERT INTO `shindi_buildings` (`id`, `company_id`, `title`, `address`, `map_coordinates`, `status`) VALUES
(1, 2, 'ლისი პალასი', 'ლისის ტბა #5 ', '42.25975761530563,42.69714703124998', 0),
(2, 4, 'პალასი თაუერი', 'ტესტ მისამართი', '41.750761864993656,44.78565443903972', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shindi_companies`
--

CREATE TABLE `shindi_companies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `identity` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `contact_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shindi_companies`
--

INSERT INTO `shindi_companies` (`id`, `title`, `identity`, `contact_phone`, `contact_email`, `address`, `website`, `status`) VALUES
(1, 'შპს სტუდია 404 x', '406095', '577898989', 'info@404.ge', 'ვარკეთილი', 'ww.404.ge', 1),
(2, 'შინდი', '5215613215', '591224455', 'info@shindi.ge', 'ბათუმი', 'shindi.ge', 0),
(3, 'შერატონ მეტეხი პალასი', '51651651', '56165156', 'sheraton@gmail.com', '300 არაგველი', 'sheraton.ge', 0),
(4, 'შპს აქსის ტაუერსი', '1240616565', '156156165', 'axis@axis.ge', 'ვაკეეეე', 'axis.ge', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shindi_entrance`
--

CREATE TABLE `shindi_entrance` (
  `id` int(11) NOT NULL,
  `building_id` int(1) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shindi_entrance`
--

INSERT INTO `shindi_entrance` (`id`, `building_id`, `title`, `status`) VALUES
(1, 1, 'სადარბაზო #1', 0),
(2, 2, 'სადარბაზო #1', 0),
(3, 2, 'სადარბაზო #2', 0),
(4, 2, 'სადარბაზო #3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shindi_floors`
--

CREATE TABLE `shindi_floors` (
  `id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL DEFAULT '0',
  `entrance_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shindi_floors`
--

INSERT INTO `shindi_floors` (`id`, `building_id`, `entrance_id`, `title`, `status`) VALUES
(1, 2, 4, '1 სართული ', 0),
(2, 2, 4, '2 სართული ', 0),
(3, 2, 4, '3 სართული', 0);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `title`, `type`, `status`) VALUES
(1, 'hi', ' what', 0),
(2, ' hello', 'why', 0),
(3, 'hello 2', 'why', 0),
(4, 'hi 2', ' what', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `shidni_users`
--
ALTER TABLE `shidni_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shindi_buildings`
--
ALTER TABLE `shindi_buildings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shindi_companies`
--
ALTER TABLE `shindi_companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shindi_entrance`
--
ALTER TABLE `shindi_entrance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shindi_floors`
--
ALTER TABLE `shindi_floors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `shidni_users`
--
ALTER TABLE `shidni_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shindi_buildings`
--
ALTER TABLE `shindi_buildings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shindi_companies`
--
ALTER TABLE `shindi_companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shindi_entrance`
--
ALTER TABLE `shindi_entrance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shindi_floors`
--
ALTER TABLE `shindi_floors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
