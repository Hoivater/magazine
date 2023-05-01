-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 01, 2023 at 10:11 PM
-- Server version: 8.0.19
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `magazine`
--

-- --------------------------------------------------------

--
-- Table structure for table `fr3452_menu`
--

CREATE TABLE `fr3452_menu` (
  `id` int UNSIGNED NOT NULL,
  `category` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `subcategory` int NOT NULL,
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `visible` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fr3452_menu`
--

INSERT INTO `fr3452_menu` (`id`, `category`, `subcategory`, `value`, `visible`) VALUES
(1, 'MAGAZIN', 0, 'bolon', 'rect846.png'),
(2, 'Акции', 1, 'bochag', 'rect846.png'),
(3, 'Игрушки', 1, 'morshi', 'rect846.png'),
(4, 'Доставка и оплата', 1, 'mader', 'rect846.png'),
(5, 'Блог', 1, 'blast', 'rect846.png');

-- --------------------------------------------------------

--
-- Table structure for table `fr3452_product`
--

CREATE TABLE `fr3452_product` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `link` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `condition` int NOT NULL,
  `price_start` int NOT NULL,
  `price_end` int NOT NULL,
  `character` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `foto` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `avaibility` tinyint(1) NOT NULL,
  `reserve` int NOT NULL,
  `date_creation` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fr3452_user`
--

CREATE TABLE `fr3452_user` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `access_user` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `code_email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `code` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fr3452_user`
--

INSERT INTO `fr3452_user` (`id`, `name`, `email`, `password`, `access_user`, `code_email`, `code`, `date`) VALUES
(1, 'limb', 'limb@limb.ru', 'b59c67bf196a4758191e42f76670ceba', 'user', 'no', 'dLDIDEZsre87MBuLApPJJVJPCE4sLlc2O', 1682795834);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fr3452_menu`
--
ALTER TABLE `fr3452_menu`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `fr3452_product`
--
ALTER TABLE `fr3452_product`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `fr3452_user`
--
ALTER TABLE `fr3452_user`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fr3452_menu`
--
ALTER TABLE `fr3452_menu`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `fr3452_product`
--
ALTER TABLE `fr3452_product`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fr3452_user`
--
ALTER TABLE `fr3452_user`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
