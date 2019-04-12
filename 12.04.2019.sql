-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 12, 2019 at 06:50 AM
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
(1, 1554976088, 'manager', 'გიორგი', 'გვაზავა', 'administrator', 'e10adc3949ba59abbe56e057f20f883e', 'giorgigvazava87@gmail.com', '995599623555', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 0),
(2, 1553874431, 'user', 'პედრო', 'ალმადოვარი', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'pedroalma@gmail.com', '995577595959', 'none', 'none', 'none', 'none', 'none', 1),
(3, 1554976839, 'manager', 'ვაკო', 'აფხაზავა', 'vako', 'e10adc3949ba59abbe56e057f20f883e', 'v.apkhazava@gmail.com', '591224400', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 'add,edit', 0),
(4, 1554040588, 'user', 'ჯუმბერ', 'ჯუმბერა', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'jumber@mail.ru', '55355656565', 'none', 'none', 'none', 'none', 'add,edit,delete', 1),
(5, 1554040713, 'user', 'test', 'tesad', 'hjbjhb', '2cd86f8a4f55e48631e56227db84d3a9', 'bjhbhj@sdd.ge', '561265651', 'none', 'none', 'none', 'none', 'add,edit,delete', 1),
(6, 1554976178, 'user', 'სატესტო', 'სატესტო', 'tester', 'e35cf7b66449df565f93c607d5a81d09', 'test@test.ge', '595656565', 'none', 'none', 'none', 'add,edit,delete', 'add,edit,delete', 0);

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
(2, 4, 'პალასი თაუერი', 'ტესტ მისამართი', '41.750761864993656,44.78565443903972', 0),
(3, 5, 'ჰორტენზია', 'იგივე N76', '41.6739804223535,41.69346441787718', 0),
(4, 2, 'asd', 'hjbhj', '41.7003244,44.87244', 1);

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
(2, 'შინდი', '5215613215', '591224455', 'info@shindi.ge', 'ბათუმიი', 'shindi.ge', 0),
(3, 'შერატონ მეტეხი პალასი', '51651651', '56165156', 'sheraton@gmail.com', '300 არაგველი', 'sheraton.ge', 0),
(4, 'შპს აქსის ტაუერსი', '1240616565', '156156165', 'axis@axis.ge', 'ვაკეეეე', 'axis.ge', 0),
(5, 'მზიური გარდენსი', '4567946131', '591224400', 'vako@mziurigardens.ge', 'მისამართ N75', 'mziurigardens.ge', 0);

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
(4, 2, 'სადარბაზო #3', 0),
(5, 3, 'პირველი', 0),
(6, 3, 'მეორე', 0),
(7, 3, 'მესამე', 0);

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
(3, 2, 4, '3 სართული', 0),
(4, 3, 7, 'პირველი სართული', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shindi_ip`
--

CREATE TABLE `shindi_ip` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shindi_ip`
--

INSERT INTO `shindi_ip` (`id`, `name`, `ip`, `status`) VALUES
(1, 'გიორგი გვაზავა', '94.240.245.46', 0),
(2, 'გიორგი', '94.250.245.46', 1),
(3, 'ვაკო', '12.546.68.3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `shindi_logs`
--

CREATE TABLE `shindi_logs` (
  `id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT ' ',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shindi_logs`
--

INSERT INTO `shindi_logs` (`id`, `date`, `ip`, `type`, `action`, `user_id`) VALUES
(2, 1554976088, '94.240.245.46', 'users', 'edit', 1),
(3, 1554976115, '94.240.245.46', 'users', 'deleteUser', 1),
(4, 1554976178, '94.240.245.46', 'users', 'add', 1),
(5, 1554976218, '94.240.245.46', 'users', 'changePassword', 1),
(6, 1554976245, '94.240.245.46', 'users', 'logged', 1),
(7, 1554976245, '94.240.245.46', 'users', 'updatePassword', 1),
(8, 1554976792, '94.240.245.46', 'users', 'updatePassword', 1),
(9, 1554976815, '94.240.245.46', 'users', 'update', 1),
(10, 1554976840, '94.240.245.46', 'users', 'edit', 1),
(11, 1554976923, '94.240.245.46', 'building', 'edit', 1),
(12, 1554976942, '94.240.245.46', 'building', 'add', 1),
(13, 1554976958, '94.240.245.46', 'building', 'delete', 1),
(14, 1554977298, '94.240.245.46', 'companies', 'edit', 1),
(15, 1554977372, '94.240.245.46', 'users', 'logged', 3),
(16, 1554977399, '94.240.245.46', 'users', 'logged', 1),
(17, 1554977425, '94.240.245.46', 'users', 'update', 1),
(18, 1555052224, '94.240.245.46', 'users', 'logged', 1),
(19, 1555055202, '94.240.245.46', 'users', 'logged', 1),
(20, 1555060584, '94.240.245.46', 'ip', 'add', 1),
(21, 1555061760, '94.240.245.46', 'ip', 'delete', 1),
(22, 1555061765, '94.240.245.46', 'ip', 'delete', 1),
(23, 1555063439, '94.240.245.46', 'ip', 'edit', 1),
(24, 1555063449, '94.240.245.46', 'ip', 'edit', 1);

-- --------------------------------------------------------

--
-- Table structure for table `shindi_photos`
--

CREATE TABLE `shindi_photos` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'rooms',
  `attach_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `mime_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shindi_photos`
--

INSERT INTO `shindi_photos` (`id`, `type`, `attach_id`, `mime_type`, `path`, `size`, `status`) VALUES
(1, 'rooms', '22', 'jpg', 'uploads/22-94c6095917e933f5da4ffd8671e6048d0.jpg', '480325', 0),
(2, 'rooms', '23', 'jpg', 'uploads/23-d1f54d984f518ad231186b6e4db4c5560.jpg', '4645484', 0),
(3, 'rooms', '23', 'jpg', 'uploads/23-d1f54d984f518ad231186b6e4db4c5561.jpg', '4885710', 0),
(4, 'rooms', '24', 'jpg', 'uploads/24-d7a60a818c02131553b41e8f78220cdf0.jpg', '4645484', 0),
(5, 'rooms', '25', 'jpg', 'uploads/25-352f8ecf4a03e6e5e076bc612283fd120.jpg', '4645484', 0),
(6, 'rooms', '25', 'jpg', 'uploads/25-352f8ecf4a03e6e5e076bc612283fd121.jpg', '480325', 0),
(7, 'rooms', '26', 'jpg', 'uploads/26-611a9fac0ec2cd62b3e8eb17c71fa9af0.jpg', '4645484', 0),
(8, 'rooms', '27', 'jpg', 'uploads/27-5130c2a9b2b1874f4324b748086ec60e0.jpg', '4645484', 1),
(9, 'rooms', '27', 'png', 'uploads/0-489b584fe40ba3613071204e18fa7c090.png', '160853', 1),
(10, 'rooms', '27', 'jpg', 'uploads/0-489b584fe40ba3613071204e18fa7c091.jpg', '32130', 1),
(11, 'rooms', '27', 'jpg', 'uploads/27-c13def592bfd6bd410aca55e80ebc0210.jpg', '231189', 1),
(12, 'rooms', '28', 'jpg', 'uploads/28-a23757537bc88e9d3cc52da4708cce270.jpg', '55081', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shindi_rooms`
--

CREATE TABLE `shindi_rooms` (
  `id` int(11) NOT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `building_id` int(11) NOT NULL DEFAULT '0',
  `entrance_id` int(11) NOT NULL DEFAULT '0',
  `floor_id` int(11) NOT NULL DEFAULT '0',
  `rooms` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `bedroom` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `bathrooms` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `square` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ceil_height` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `natural_air` int(1) NOT NULL DEFAULT '0',
  `central_hitting` int(1) NOT NULL DEFAULT '0',
  `tv_cable` int(1) NOT NULL DEFAULT '0',
  `internet` int(1) NOT NULL DEFAULT '0',
  `washing_machine` int(1) NOT NULL DEFAULT '0',
  `verandah` int(1) NOT NULL DEFAULT '0',
  `balcony` int(1) NOT NULL DEFAULT '0',
  `phone` int(1) NOT NULL DEFAULT '0',
  `tv` int(1) NOT NULL DEFAULT '0',
  `parking` int(1) NOT NULL DEFAULT '0',
  `iron_door` int(1) NOT NULL DEFAULT '0',
  `storeroom` int(1) NOT NULL DEFAULT '0',
  `alarms` int(1) NOT NULL DEFAULT '0',
  `furniture` int(1) NOT NULL DEFAULT '0',
  `fridge` int(1) NOT NULL DEFAULT '0',
  `elevator` int(1) NOT NULL DEFAULT '0',
  `totalprice` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `pre_pay` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `paying_start_day` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `payed_months` text COLLATE utf8_unicode_ci NOT NULL,
  `installment_months` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `available_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'available',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shindi_rooms`
--

INSERT INTO `shindi_rooms` (`id`, `number`, `title`, `building_id`, `entrance_id`, `floor_id`, `rooms`, `bedroom`, `bathrooms`, `square`, `ceil_height`, `natural_air`, `central_hitting`, `tv_cable`, `internet`, `washing_machine`, `verandah`, `balcony`, `phone`, `tv`, `parking`, `iron_door`, `storeroom`, `alarms`, `furniture`, `fridge`, `elevator`, `totalprice`, `pre_pay`, `paying_start_day`, `payed_months`, `installment_months`, `available_status`, `description`, `status`) VALUES
(22, '0', 'სატესტო ბინა', 2, 4, 3, '4', '2', '2', '120', '315', 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, '0', '0', '0', '', '0', 'available', 'ტესტ', 0),
(23, '0', 'test', 2, 4, 3, '4', '2', '2', '225', '350', 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0', '0', '0', '', '0', 'available', 'tester', 0),
(24, '0', 'test', 2, 4, 3, '4', '2', '2', '123', '569', 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0', '0', '0', '', '0', 'available', 'askjdaskjd asd jknakds', 0),
(25, '0', 'more test', 2, 4, 3, '4', '5', '5', '123', '564', 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0', '0', '0', '', '0', 'available', 'kasd asd ', 0),
(26, '0', 'asdjasd ხხსდფ', 2, 4, 3, 'jknkj', 'kjnkj', 'kjnkj', 'kjnkjn', 'kjnkj', 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, '0', '0', '0', '', '0', 'available', 'ჯკასდ ნაკსდნ ჯასდ ასჯდ ანჯკსდ აკჯსდ ჯკნ ციო', 0),
(27, '0', 'test dasaxeleba', 2, 4, 3, '4', '2', '2', '120', '315', 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, 0, '0', '0', '0', '', '0', 'available', 'test agwera', 1),
(28, '0', 'test bina', 3, 7, 4, '4', '2', '2', '120', '315', 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 0, 0, 0, '37000', '10000', '2019-04-12', '2019-05-23;2019-06-23;2019-07-23;2019-08-23', '24', 'internal_installment', 'test binaa', 0);

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
-- Indexes for table `shindi_ip`
--
ALTER TABLE `shindi_ip`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shindi_logs`
--
ALTER TABLE `shindi_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shindi_photos`
--
ALTER TABLE `shindi_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shindi_rooms`
--
ALTER TABLE `shindi_rooms`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `shindi_buildings`
--
ALTER TABLE `shindi_buildings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shindi_companies`
--
ALTER TABLE `shindi_companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shindi_entrance`
--
ALTER TABLE `shindi_entrance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `shindi_floors`
--
ALTER TABLE `shindi_floors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shindi_ip`
--
ALTER TABLE `shindi_ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shindi_logs`
--
ALTER TABLE `shindi_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `shindi_photos`
--
ALTER TABLE `shindi_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `shindi_rooms`
--
ALTER TABLE `shindi_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
