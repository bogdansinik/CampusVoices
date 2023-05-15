-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 15, 2023 at 01:23 PM
-- Server version: 5.7.33-0ubuntu0.16.04.1
-- PHP Version: 7.0.33-0ubuntu0.16.04.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `CV_proj`
--

-- --------------------------------------------------------

--
-- Table structure for table `Accommodation`
--

CREATE TABLE `Accommodation` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Accommodation',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `city` enum('Koper','Izola','Piran','Portorož','Lucija') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Koper',
  `street_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `street_no` int(11) NOT NULL,
  `type` enum('Shared Room','Single Room','Condo','Other','Studio') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Other',
  `rating` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Accommodation`
--

INSERT INTO `Accommodation` (`id`, `name`, `description`, `city`, `street_name`, `street_no`, `type`, `rating`) VALUES
(1, 'Flat 1', '1-bedroom apartment located in the city center, fully furnished.', 'Koper', 'Vojkovo nabrežje', 34, 'Condo', 4.1),
(2, 'Big suburban appartement', 'A room in a 2-bedroom apartment located in the suburbs, with a balcony and parking.', 'Koper', 'Jenkova', 3, 'Shared Room', 3.7),
(3, 'Studio in the city center', 'Studio apartment located near the university, with a kitchenette and air conditioning.', 'Koper', 'Brolo trg', 6, 'Studio', 2.6),
(4, 'Big apartment', '3-bedroom apartment located in a quiet neighborhood, with a garden and barbecue area.', 'Izola', 'Partizanska ulica', 6, 'Shared Room', 4.3);

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `id` int(11) NOT NULL,
  `first_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('student','administrator','guest') COLLATE utf8_unicode_ci DEFAULT 'guest'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Accommodation`
--
ALTER TABLE `Accommodation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Accommodation`
--
ALTER TABLE `Accommodation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
