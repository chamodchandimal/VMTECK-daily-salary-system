-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2023 at 04:43 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uws`
--

-- --------------------------------------------------------

--
-- Table structure for table `att`
--

CREATE TABLE `att` (
  `id` int(11) NOT NULL,
  `eid` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `timetocome` varchar(20) NOT NULL,
  `timetogo` varchar(20) NOT NULL,
  `bywhom` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emp`
--

CREATE TABLE `emp` (
  `id` int(11) NOT NULL,
  `eid` varchar(20) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `address` varchar(200) NOT NULL,
  `position` varchar(20) NOT NULL,
  `dateofjoining` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emp`
--

INSERT INTO `emp` (`id`, `eid`, `fname`, `lname`, `email`, `mobile`, `address`, `position`, `dateofjoining`, `status`) VALUES
(1, 'E10000', 'Kavindra', 'Pabasara', 'kavi@vmteck.com', '0766666666', '', 'Owner', '2022-07-20', 'yes'),
(5, 'E10001', 'Chamod', 'Chandimal', 'chamod@vmteck.com', '0717954268', 'New bus stand, Anuradhapura', 'DMS', '2022-07-20', 'yes'),
(21, 'E10002', 'Thathsarani', 'Venuri', 'venuri@vmteck.com', '0781523478', '3rd stage, Anuradhapura', 'Rep', '2023-07-09', 'yes'),
(22, 'E10003', 'Methsara', 'Dissanayake', 'methsara@vmteck.com', '0719541285', 'Pandulagama, Anuradhapura', 'Driver', '2023-07-09', 'yes'),
(23, 'E10004', 'Nelum', 'Bandara', 'nelum@vmteck.com', '0714587632', 'Madawachchiya, Anuradhapura', 'Cash', '2023-08-02', 'yes'),
(24, 'E10005', 'Thasmi', 'Rathnayake', 'thashmi@vmteck.com', '0704965751', 'Nochchiyagama, Anuradhapura', 'Rep', '2023-08-15', 'yes'),
(25, 'E10006', 'Eranda', 'Dissanayake', 'eranda@vmteck.com', '0774953125', 'Thisawewa, Anuradhapura', 'Cash', '2023-08-29', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `sal`
--

CREATE TABLE `sal` (
  `no` int(11) NOT NULL,
  `eid` varchar(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `payday` date DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `Collection` decimal(10,2) NOT NULL DEFAULT 0.00,
  `Bonus` decimal(10,2) NOT NULL DEFAULT 0.00,
  `Expenses` decimal(10,2) NOT NULL DEFAULT 0.00,
  `Advance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `month` varchar(20) DEFAULT NULL,
  `year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tot`
--

CREATE TABLE `tot` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `eid` varchar(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(20) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `type`) VALUES
(1, 'E10000', 'E10000', 'sadmin'),
(5, 'E10001', 'E10001', 'admin'),
(23, 'E10002', 'E10002', 'emp'),
(24, 'E10003', 'E10003', 'emp'),
(25, 'E10004', 'E10004', 'emp'),
(26, 'E10005', 'E10005', 'emp'),
(27, 'E10006', 'E10006', 'emp');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `att`
--
ALTER TABLE `att`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp`
--
ALTER TABLE `emp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `eid` (`eid`);

--
-- Indexes for table `sal`
--
ALTER TABLE `sal`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `tot`
--
ALTER TABLE `tot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `att`
--
ALTER TABLE `att`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `emp`
--
ALTER TABLE `emp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `sal`
--
ALTER TABLE `sal`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `tot`
--
ALTER TABLE `tot`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
