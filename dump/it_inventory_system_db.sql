-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2023 at 08:24 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `it_inventory_system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_dd`
--

CREATE TABLE `category_dd` (
  `categoryId` int(11) NOT NULL,
  `category_select` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_dd`
--

INSERT INTO `category_dd` (`categoryId`, `category_select`) VALUES
(1, 'Consumable'),
(2, 'Spare Part'),
(3, 'Hardware');

-- --------------------------------------------------------

--
-- Table structure for table `history_table`
--

CREATE TABLE `history_table` (
  `history_id` int(11) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `item` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `history_remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itinventorysystem_table`
--

CREATE TABLE `itinventorysystem_table` (
  `id` int(11) NOT NULL,
  `item` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `model_part_no` varchar(255) NOT NULL,
  `specifications` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `max_stock` int(11) NOT NULL,
  `ordering_point` int(11) NOT NULL,
  `min_stock` int(11) NOT NULL,
  `unit_price` float NOT NULL,
  `initial_stock` int(11) NOT NULL,
  `actual_stock` float NOT NULL,
  `actual_amount` float NOT NULL,
  `received` int(11) NOT NULL,
  `issued` int(11) NOT NULL,
  `for_purchase` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `location_dd`
--

CREATE TABLE `location_dd` (
  `id` int(11) NOT NULL,
  `location_select` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `location_dd`
--

INSERT INTO `location_dd` (`id`, `location_select`) VALUES
(26, 'Server Room 1'),
(41, 'Server Room 2');

-- --------------------------------------------------------

--
-- Table structure for table `unit_dd`
--

CREATE TABLE `unit_dd` (
  `id` int(11) NOT NULL,
  `unit_select` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `unit_dd`
--

INSERT INTO `unit_dd` (`id`, `unit_select`) VALUES
(19, 'PC'),
(20, 'UNIT'),
(21, 'PACK'),
(22, 'ROLL'),
(23, 'RIBBON'),
(24, 'LITER'),
(30, 'SET'),
(31, 'PAIR');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_dd`
--
ALTER TABLE `category_dd`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `history_table`
--
ALTER TABLE `history_table`
  ADD PRIMARY KEY (`history_id`);

--
-- Indexes for table `itinventorysystem_table`
--
ALTER TABLE `itinventorysystem_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location_dd`
--
ALTER TABLE `location_dd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_dd`
--
ALTER TABLE `unit_dd`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_dd`
--
ALTER TABLE `category_dd`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `history_table`
--
ALTER TABLE `history_table`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `itinventorysystem_table`
--
ALTER TABLE `itinventorysystem_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `location_dd`
--
ALTER TABLE `location_dd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `unit_dd`
--
ALTER TABLE `unit_dd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
