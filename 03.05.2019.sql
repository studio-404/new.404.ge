-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 02, 2019 at 11:48 PM
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
-- Table structure for table `shidni_oweners`
--

CREATE TABLE `shidni_oweners` (
  `created_time` int(11) NOT NULL,
  `insert_admin` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'administrator',
  `id` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `owners_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `owners_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `owners_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `owners_birthday` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '01-01-1979',
  `owners_gender` enum('male','female') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'male',
  `owners_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `owners_phone2` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `owners_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shidni_users`
--

CREATE TABLE `shidni_users` (
  `id` int(11) NOT NULL,
  `created_date` int(11) NOT NULL DEFAULT '0',
  `user_type` set('manager','user') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `own_company` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `lastname` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `contact_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `permission_company` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  `permission_owner` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  `permission_buldings` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  `permission_entrance` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  `permission_floor` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  `permission_room` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shidni_users`
--

INSERT INTO `shidni_users` (`id`, `created_date`, `user_type`, `own_company`, `firstname`, `lastname`, `username`, `password`, `contact_email`, `contact_phone`, `permission_company`, `permission_owner`, `permission_buldings`, `permission_entrance`, `permission_floor`, `permission_room`, `status`) VALUES
(1, 1556533794, 'manager', '', 'გიორგი', 'გვაზავა', 'administrator', 'e10adc3949ba59abbe56e057f20f883e', 'giorgigvazava87@gmail.com', '995599623555', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 0),
(3, 1556711626, 'manager', '', 'ვაკო', 'აფხაზავა', 'vako', 'e10adc3949ba59abbe56e057f20f883e', 'v.apkhazava@gmail.com', '591224400', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 'add,edit', 0),
(12, 1556724120, 'user', '6', 'დავითი', 'დავითოვი', 'david', 'e10adc3949ba59abbe56e057f20f883e', 'david@david.ge', '599889988', 'none', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 0),
(10, 1556716203, 'user', '2', 'გუჯა', 'გუჯაბიძე', 'gujuna', 'e10adc3949ba59abbe56e057f20f883e', 'gujuna@404.ge', '599656565', 'none', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 'add,edit,delete', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shindi_buildings`
--

CREATE TABLE `shindi_buildings` (
  `insert_admin` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'administrator',
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

INSERT INTO `shindi_buildings` (`insert_admin`, `id`, `company_id`, `title`, `address`, `map_coordinates`, `status`) VALUES
('gujuna', 6, 2, 'შინდი რეზიდენსი', 'ავლაბრის აღმართი', '41.693870767370605,44.8113506133152', 0),
('david', 5, 6, 'მაყვალა რეზიდენსი', 'კოსტავას 31', '41.723036436567206,44.77726438199102', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shindi_companies`
--

CREATE TABLE `shindi_companies` (
  `insert_admin` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'administrator',
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

INSERT INTO `shindi_companies` (`insert_admin`, `id`, `title`, `identity`, `contact_phone`, `contact_email`, `address`, `website`, `status`) VALUES
('administrator', 2, 'შინდი', '5215613215', '591224455', 'info@shindi.ge', 'ბათუმიი', 'shindi.ge', 0),
('administrator', 6, 'მაყვალი', '01020506', '599656565', 'makvala@gmail.com', 'makvlis qucha 12', 'makvali.ge', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shindi_entrance`
--

CREATE TABLE `shindi_entrance` (
  `insert_admin` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'administrator',
  `id` int(11) NOT NULL,
  `building_id` int(1) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shindi_entrance`
--

INSERT INTO `shindi_entrance` (`insert_admin`, `id`, `building_id`, `title`, `status`) VALUES
('gujuna', 10, 6, 'პადიეზდი 1', 0),
('david', 9, 5, 'სადარბაზო 1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shindi_floors`
--

CREATE TABLE `shindi_floors` (
  `insert_admin` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'administrator',
  `id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL DEFAULT '0',
  `entrance_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shindi_floors`
--

INSERT INTO `shindi_floors` (`insert_admin`, `id`, `building_id`, `entrance_id`, `title`, `status`) VALUES
('gujuna', 8, 6, 10, 'მეორე სართული', 0),
('gujuna', 7, 6, 10, 'პირველი სართული', 0),
('david', 6, 5, 9, '1 სართული', 0);

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
(4, 'ვალერიან აფხაზავა', '212.58.119.85', 0);

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
(1, 1556723106, '94.240.245.46', 'users', 'logged', 1),
(2, 1556723258, '94.240.245.46', 'companies', 'add', 1),
(3, 1556723335, '94.240.245.46', 'users', 'add', 1),
(4, 1556723673, '94.240.245.46', 'users', 'logged', 12),
(5, 1556724068, '94.240.245.46', 'users', 'edit', 1),
(6, 1556724095, '94.240.245.46', 'users', 'logged', 12),
(7, 1556724120, '94.240.245.46', 'users', 'edit', 1),
(8, 1556724137, '94.240.245.46', 'users', 'logged', 12),
(9, 1556725023, '94.240.245.46', 'building', 'add', 12),
(10, 1556725077, '94.240.245.46', 'users', 'logged', 10),
(11, 1556725203, '94.240.245.46', 'building', 'add', 10),
(12, 1556725342, '94.240.245.46', 'building', 'delete', 10),
(13, 1556725389, '94.240.245.46', 'building', 'edit', 10),
(14, 1556725395, '94.240.245.46', 'building', 'edit', 10),
(15, 1556725529, '94.240.245.46', 'users', 'logged', 10),
(16, 1556725570, '94.240.245.46', 'entrance', 'add', 10),
(17, 1556779263, '94.240.245.46', 'users', 'logged', 1),
(18, 1556779398, '94.240.245.46', 'users', 'logged', 12),
(19, 1556784584, '94.240.245.46', 'users', 'logged', 1),
(20, 1556784616, '94.240.245.46', 'users', 'logged', 12),
(21, 1556785110, '94.240.245.46', 'users', 'logged', 12),
(22, 1556785222, '94.240.245.46', 'entrance', 'add', 12),
(23, 1556785267, '94.240.245.46', 'users', 'logged', 10),
(24, 1556785374, '94.240.245.46', 'entrance', 'add', 10),
(25, 1556785989, '94.240.245.46', 'entrance', 'edit', 10),
(26, 1556786000, '94.240.245.46', 'entrance', 'edit', 10),
(27, 1556788361, '94.240.245.46', 'users', 'logged', 1),
(28, 1556788871, '94.240.245.46', 'users', 'logged', 12),
(29, 1556790675, '94.240.245.46', 'users', 'logged', 1),
(30, 1556790911, '94.240.245.46', 'entrance', 'delete', 12),
(31, 1556794349, '94.240.245.46', 'users', 'logged', 12),
(32, 1556798354, '94.240.245.46', 'users', 'logged', 1),
(33, 1556856872, '94.240.245.46', 'users', 'logged', 12),
(34, 1556856972, '94.240.245.46', 'floor', 'add', 12),
(35, 1556856994, '94.240.245.46', 'users', 'logged', 1),
(36, 1556857029, '94.240.245.46', 'users', 'logged', 10),
(37, 1556857049, '94.240.245.46', 'floor', 'add', 10),
(38, 1556857072, '94.240.245.46', 'users', 'logged', 12),
(39, 1556857264, '94.240.245.46', 'users', 'logged', 10),
(40, 1556857449, '94.240.245.46', 'floor', 'edit', 10),
(41, 1556857475, '94.240.245.46', 'users', 'logged', 12),
(42, 1556857515, '94.240.245.46', 'users', 'logged', 10),
(43, 1556857561, '94.240.245.46', 'floor', 'delete', 10),
(44, 1556857583, '94.240.245.46', 'users', 'logged', 10),
(45, 1556857611, '94.240.245.46', 'users', 'logged', 12),
(46, 1556857943, '94.240.245.46', 'room', 'add', 12),
(47, 1556857946, '94.240.245.46', 'photos', 'add', 12),
(48, 1556857977, '94.240.245.46', 'users', 'logged', 10),
(49, 1556858034, '94.240.245.46', 'room', 'add', 10),
(50, 1556858034, '94.240.245.46', 'photos', 'add', 10),
(51, 1556858279, '94.240.245.46', 'floor', 'add', 10),
(52, 1556858292, '94.240.245.46', 'floor', 'edit', 10),
(53, 1556858412, '94.240.245.46', 'floor', 'delete', 10),
(54, 1556858447, '94.240.245.46', 'users', 'logged', 10),
(55, 1556858525, '94.240.245.46', 'room', 'delete', 10),
(56, 1556858556, '94.240.245.46', 'users', 'logged', 12);

-- --------------------------------------------------------

--
-- Table structure for table `shindi_photos`
--

CREATE TABLE `shindi_photos` (
  `insert_admin` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'administrator',
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

INSERT INTO `shindi_photos` (`insert_admin`, `id`, `type`, `attach_id`, `mime_type`, `path`, `size`, `status`) VALUES
('administrator', 15, 'rooms', '31', 'jpeg', 'uploads/31-75719344755eba3539a4724c7938cb220.jpeg', '9595', 0),
('administrator', 14, 'rooms', '30', 'jpg', 'uploads/30-c04185b20c91a124f1632a575eda489d0.jpg', '226940', 1);

-- --------------------------------------------------------

--
-- Table structure for table `shindi_rooms`
--

CREATE TABLE `shindi_rooms` (
  `insert_admin` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'administrator',
  `id` int(11) NOT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ',
  `building_id` int(11) NOT NULL DEFAULT '0',
  `entrance_id` int(11) NOT NULL DEFAULT '0',
  `floor_id` int(11) NOT NULL DEFAULT '0',
  `owner_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
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

INSERT INTO `shindi_rooms` (`insert_admin`, `id`, `number`, `title`, `building_id`, `entrance_id`, `floor_id`, `owner_id`, `rooms`, `bedroom`, `bathrooms`, `square`, `ceil_height`, `natural_air`, `central_hitting`, `tv_cable`, `internet`, `washing_machine`, `verandah`, `balcony`, `phone`, `tv`, `parking`, `iron_door`, `storeroom`, `alarms`, `furniture`, `fridge`, `elevator`, `totalprice`, `pre_pay`, `paying_start_day`, `payed_months`, `installment_months`, `available_status`, `description`, `status`) VALUES
('gujuna', 31, '0', 'ბინა 1 გუჯუნა', 6, 10, 7, '0', '2', '1', '1', '135', '325', 0, 0, 0, 0, 0, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0, 0, '46000', '0', '2019-05-03', '', '0', 'sold', 'ტესტ ტესტ', 0),
('david', 30, '0', 'ბინა 1 დავითი', 5, 9, 6, '0', '2', '1', '1', '120', '310', 1, 1, 0, 1, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, '35000', '0', '2019-05-03', '', '0', 'avaliable', 'ტესტ ტესტ', 0);

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
-- Indexes for table `shidni_oweners`
--
ALTER TABLE `shidni_oweners`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `shidni_oweners`
--
ALTER TABLE `shidni_oweners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `shidni_users`
--
ALTER TABLE `shidni_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `shindi_buildings`
--
ALTER TABLE `shindi_buildings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `shindi_companies`
--
ALTER TABLE `shindi_companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `shindi_entrance`
--
ALTER TABLE `shindi_entrance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `shindi_floors`
--
ALTER TABLE `shindi_floors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `shindi_ip`
--
ALTER TABLE `shindi_ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shindi_logs`
--
ALTER TABLE `shindi_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `shindi_photos`
--
ALTER TABLE `shindi_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `shindi_rooms`
--
ALTER TABLE `shindi_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
