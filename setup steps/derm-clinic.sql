-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2020 at 05:25 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `derm-clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `phone` text NOT NULL,
  `age` int(11) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `medicalHis` text NOT NULL,
  `visits` int(11) NOT NULL,
  `lastVisit` datetime NOT NULL,
  `registerDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `nextVisit` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `age`, `sex`, `medicalHis`, `visits`, `lastVisit`, `registerDate`, `nextVisit`) VALUES
(1, 'Kosalla', '(012) 345 677', 29, 'Other', 'peanut allergy\r\nLactose intolerant\r\ndiabetes family', 11, '2020-09-13 10:20:54', '2020-09-13 01:59:14', '2020-09-13'),
(2, 'Sophy', '(088) 999 9999', 20, 'F', 'None', 2, '2020-09-13 09:16:49', '2020-09-13 02:01:23', '2020-09-13');

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis`
--

CREATE TABLE `diagnosis` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `diagnosis`
--

INSERT INTO `diagnosis` (`id`, `name`) VALUES
(1, 'nodular acne'),
(3, 'Acne Mechanica');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `code` text NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `stock` int(11) NOT NULL,
  `buyingPrice` float NOT NULL,
  `sellingPrice` float NOT NULL,
  `sales` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `code`, `description`, `image`, `stock`, `buyingPrice`, `sellingPrice`, `sales`, `date`) VALUES
(2, '101', 'test', 'views/img/products/default/anonymous.png', 18, 40, 56, 5, '2020-09-13 03:20:54'),
(3, '100', 'oratane 20 mg', 'views/img/products/100/132.jpg', -1, 10, 14, 5, '2020-09-13 03:13:04');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `diagnosis` text NOT NULL,
  `products` text NOT NULL,
  `images` text NOT NULL,
  `receipt` text NOT NULL,
  `comment` text NOT NULL,
  `totalPrice` float NOT NULL,
  `saledate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `code`, `idCustomer`, `diagnosis`, `products`, `images`, `receipt`, `comment`, `totalPrice`, `saledate`) VALUES
(1, 10001, 1, '3', '[{\"id\":\"3\",\"description\":\"oratane 20 mg\",\"usage\":\"\",\"quantity\":\"3\",\"stock\":\"99\",\"price\":\"14\",\"totalPrice\":\"42\"}]', '', '[{\"id\":\"3\",\"description\":\"oratane 20 mg\",\"usage\":\"\",\"quantity\":\"3\",\"stock\":\"99\",\"price\":\"14\",\"totalPrice\":\"42\"},{\"id\":\"2\",\"description\":\"Cetaphil FaceWash\",\"quantity\":\"3\",\"stock\":\"19\",\"price\":\"60\",\"totalPrice\":\"180\"}]', '', 222, '2020-09-13 02:06:59'),
(3, 10003, 1, '1', '[{\"id\":\"2\",\"description\":\"Cetaphil FaceWash\",\"usage\":\"១ ថ្ងៃ ២​ ដង\",\"quantity\":\"2\",\"stock\":\"18\",\"price\":\"60\",\"totalPrice\":\"120\"}]', '', '[{\"id\":\"2\",\"description\":\"Cetaphil FaceWash\",\"quantity\":\"2\",\"stock\":\"18\",\"price\":\"60\",\"totalPrice\":\"120\"}]', '', 120, '2020-09-13 02:13:58'),
(4, 10004, 2, '1', '[{\"id\":\"3\",\"description\":\"oratane 20 mg\",\"usage\":\"\",\"quantity\":\"1\",\"stock\":\"94\",\"price\":\"14\",\"totalPrice\":\"14\"}]', '', '[]', '', 0, '2020-09-13 02:14:44'),
(5, 10005, 2, '1', '[{\"id\":\"3\",\"description\":\"oratane 20 mg\",\"usage\":\"\",\"quantity\":\"1\",\"stock\":\"92\",\"price\":\"14\",\"totalPrice\":\"14\"}]', '', '[{\"id\":\"3\",\"description\":\"oratane 20 mg\",\"quantity\":\"2\",\"stock\":\"92\",\"price\":\"14\",\"totalPrice\":\"28\"}]', '', 28, '2020-09-13 02:16:49'),
(7, 10007, 1, '1', '[{\"id\":\"3\",\"description\":\"oratane 20 mg\",\"usage\":\"2 គ្រាប់ព្រឹក\",\"quantity\":\"3\",\"stock\":\"-1\",\"price\":\"14\",\"totalPrice\":\"42\"},{\"id\":\"2\",\"description\":\"Cetaphil FaceWash\",\"usage\":\"3 គ្រាប់យប់\",\"quantity\":\"2\",\"stock\":\"-1\",\"price\":\"60\",\"totalPrice\":\"120\"}]', '', '[{\"id\":\"3\",\"description\":\"oratane 20 mg\",\"quantity\":\"3\",\"stock\":\"-1\",\"price\":\"90\",\"totalPrice\":\"270\"},{\"id\":\"2\",\"description\":\"Cetaphil FaceWash\",\"quantity\":\"2\",\"stock\":\"-1\",\"price\":\"56\",\"totalPrice\":\"12\"}]', '', 282, '2020-09-13 02:29:52');

-- --------------------------------------------------------

--
-- Table structure for table `usages`
--

CREATE TABLE `usages` (
  `id` int(11) NOT NULL,
  `usage` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diagnosis`
--
ALTER TABLE `diagnosis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usages`
--
ALTER TABLE `usages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `diagnosis`
--
ALTER TABLE `diagnosis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `usages`
--
ALTER TABLE `usages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
