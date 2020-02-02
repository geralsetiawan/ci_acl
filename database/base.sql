-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 29, 2018 at 02:45 PM
-- Server version: 10.3.7-MariaDB-1:10.3.7+maria~bionic-log
-- PHP Version: 5.6.36-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `base`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id_category`, `name`) VALUES
(1, 'MOUSE'),
(2, 'KEYBOARD'),
(3, 'FLASHDISK'),
(4, 'TESTS'),
(5, 'QWERTY'),
(6, 'GG'),
(7, 'KOREK'),
(8, 'GGWP'),
(9, 'QWERTYYY'),
(10, 'ABCDF');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT 'Max 4 menu  (3 child)',
  `title` varchar(50) DEFAULT NULL,
  `url` varchar(70) DEFAULT NULL COMMENT 'Controller',
  `icon` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `name`, `title`, `url`, `icon`) VALUES
(1, 'setting', 'Setting', '#', 'fa fa-cogs'),
(2, 'setting.item', 'Item', '#', 'fa fa-circle-o'),
(3, 'user', 'User', 'user', 'fa fa-user'),
(4, 'setting.role', 'Role', 'role', 'fa fa-circle-o'),
(5, 'setting.item.produk.category', 'Category', 'category', 'fa fa-circle-o'),
(6, 'setting.item.produk', 'Produk', 'produk', 'fa fa-circle-o'),
(10, 'setting.master', 'Master', '#', 'fa fa-circle-o'),
(11, 'setting.master.group', 'Group', 'group', 'fa fa-circle-o');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `id_user_group` varchar(30) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `created_user` varchar(40) DEFAULT NULL,
  `is_delete` char(1) NOT NULL DEFAULT 'f'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `id_user_group`, `name`, `username`, `password`, `created_date`, `updated_date`, `created_user`, `is_delete`) VALUES
(1, '1,2,3', 'GERAL', 'geral', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '2018-07-29 14:43:03', NULL, 'f'),
(2, '1', 'BUDI', 'budi', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', '2018-07-29 11:26:12', NULL, 'f'),
(3, '3', 'FANI', 'fani', 'd8578edf8458ce06fbc5bb76a58c5ca4', '2018-06-11 20:00:47', '2018-07-28 19:06:12', NULL, 'f'),
(4, '1', 'GANI', 'geral', 'd8578edf8458ce06fbc5bb76a58c5ca4', '2018-07-29 09:53:40', '2018-07-29 11:23:10', NULL, 'f'),
(5, '1,3', 'HADI', 'hadi', 'e10adc3949ba59abbe56e057f20f883e', '2018-07-29 09:54:40', '2018-07-29 11:23:03', NULL, 'f');

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE `user_group` (
  `id_user_group` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `description` varchar(40) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `is_delete` char(1) NOT NULL DEFAULT 'f'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`id_user_group`, `name`, `description`, `created_date`, `updated_date`, `is_delete`) VALUES
(1, 'CS ADMIN', 'Hello world', NULL, NULL, 'f'),
(2, 'OPERATOR', 'Hello world', NULL, NULL, 'f'),
(3, 'MANAGER', 'qwerty', '2018-06-13 19:00:29', '2018-07-29 12:50:40', 'f');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id_user_role` int(11) NOT NULL,
  `id_user_group` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `read` char(1) NOT NULL,
  `create` char(1) NOT NULL,
  `update` char(1) NOT NULL,
  `delete` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id_user_role`, `id_user_group`, `id_menu`, `read`, `create`, `update`, `delete`) VALUES
(1, 1, 2, '1', '1', '1', '1'),
(2, 1, 4, '1', '1', '1', '1'),
(3, 1, 3, '1', '1', '1', '0'),
(4, 2, 4, '1', '1', '1', '1'),
(5, 1, 1, '1', '0', '0', '1'),
(6, 3, 2, '1', '1', '1', '1'),
(7, 3, 4, '1', '1', '1', '1'),
(8, 3, 1, '1', '1', '1', '1'),
(9, 3, 3, '0', '1', '1', '1'),
(10, 2, 2, '1', '1', '1', '1'),
(11, 2, 1, '1', '1', '1', '1'),
(12, 2, 3, '1', '1', '1', '1'),
(13, 1, 5, '1', '1', '1', ''),
(14, 1, 6, '1', '', '', ''),
(15, 2, 5, '1', '', '', ''),
(16, 3, 5, '1', '1', '', ''),
(17, 1, 9, '1', '', '', ''),
(18, 3, 6, '1', '', '', ''),
(19, 1, 10, '1', '', '', ''),
(20, 1, 11, '1', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id_user_group`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id_user_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id_user_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id_user_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
