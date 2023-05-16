-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 16, 2023 at 07:39 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `CampusVoices`
--

-- --------------------------------------------------------

--
-- Table structure for table `Accommodation`
--

CREATE TABLE `Accommodation` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL DEFAULT 'Accommodation',
  `description` text NOT NULL,
  `city` enum('Koper','Izola','Piran','Portorož','Lucija') NOT NULL DEFAULT 'Koper',
  `address` varchar(255) NOT NULL,
  `type` enum('Shared Room','Single Room','Condo','Other','Studio') NOT NULL DEFAULT 'Other',
  `images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Accommodation`
--

INSERT INTO `Accommodation` (`id`, `name`, `description`, `city`, `address`, `type`, `images`) VALUES
(1, 'Flat 1', '1-bedroom apartment located in the city center, fully furnished.', 'Koper', 'Vojkovo Nabrezje 20', 'Condo', ''),
(2, 'Big suburban appartement', 'A room in a 2-bedroom apartment located in the suburbs, with a balcony and parking.', 'Koper', 'Jenkova Ulica 2', 'Shared Room', ''),
(3, 'Studio in the city center', 'Studio apartment located near the university, with a kitchenette and air conditioning.', 'Koper', 'Cevljarska 33', 'Studio', ''),
(4, 'Big apartment', '3-bedroom apartment located in a quiet neighborhood, with a garden and barbecue area.', 'Izola', 'Ljubljanska 1', 'Shared Room', '');

-- --------------------------------------------------------

--
-- Table structure for table `AccomodationReview`
--

CREATE TABLE `AccomodationReview` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `accomodation_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `stars` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Ad`
--

CREATE TABLE `Ad` (
  `id` int(11) NOT NULL,
  `title` varchar(40) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `instrument` enum('guitar','piano','drums','ukulele','voice') NOT NULL,
  `skill` enum('beginner','medium','advanced','pro') NOT NULL,
  `date_of_posting` timestamp NOT NULL DEFAULT current_timestamp(),
  `genre` enum('rock','pop','folk','rap','country') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Courses`
--

CREATE TABLE `Courses` (
  `id` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `CoursesReview`
--

CREATE TABLE `CoursesReview` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `body` varchar(255) NOT NULL,
  `stars` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Professor`
--

CREATE TABLE `Professor` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ProfessorReview`
--

CREATE TABLE `ProfessorReview` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `body` varchar(1000) NOT NULL,
  `stars` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Restourants`
--

CREATE TABLE `Restourants` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `RestourantsReview`
--

CREATE TABLE `RestourantsReview` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `body` varchar(1000) NOT NULL,
  `stars` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `surname` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('student','professor','admin') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `name`, `surname`, `password`, `username`, `email`, `role`) VALUES
(34, '1', '1', '1', '1', '1@1.1', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Accommodation`
--
ALTER TABLE `Accommodation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `AccomodationReview`
--
ALTER TABLE `AccomodationReview`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `accomodation_id` (`accomodation_id`);

--
-- Indexes for table `Ad`
--
ALTER TABLE `Ad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`owner_id`);

--
-- Indexes for table `Courses`
--
ALTER TABLE `Courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `CoursesReview`
--
ALTER TABLE `CoursesReview`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `Professor`
--
ALTER TABLE `Professor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ProfessorReview`
--
ALTER TABLE `ProfessorReview`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`professor_id`),
  ADD KEY `professor_id` (`professor_id`);

--
-- Indexes for table `Restourants`
--
ALTER TABLE `Restourants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `RestourantsReview`
--
ALTER TABLE `RestourantsReview`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restourantsreview_ibfk_1` (`restaurant_id`),
  ADD KEY `user_id` (`user_id`) USING BTREE;

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
-- AUTO_INCREMENT for table `AccomodationReview`
--
ALTER TABLE `AccomodationReview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Ad`
--
ALTER TABLE `Ad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `Courses`
--
ALTER TABLE `Courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `CoursesReview`
--
ALTER TABLE `CoursesReview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Professor`
--
ALTER TABLE `Professor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ProfessorReview`
--
ALTER TABLE `ProfessorReview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Restourants`
--
ALTER TABLE `Restourants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `RestourantsReview`
--
ALTER TABLE `RestourantsReview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `AccomodationReview`
--
ALTER TABLE `AccomodationReview`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`accomodation_id`) REFERENCES `accommodation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Ad`
--
ALTER TABLE `Ad`
  ADD CONSTRAINT `Ad_ibfk_3` FOREIGN KEY (`owner_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `CoursesReview`
--
ALTER TABLE `CoursesReview`
  ADD CONSTRAINT `coursesreview_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `Courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coursesreview_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ProfessorReview`
--
ALTER TABLE `ProfessorReview`
  ADD CONSTRAINT `professorreview_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `Professor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `professorreview_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `RestourantsReview`
--
ALTER TABLE `RestourantsReview`
  ADD CONSTRAINT `restourantsreview_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `Restourants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `restourantsreview_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
