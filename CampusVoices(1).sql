-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 17, 2023 at 09:37 PM
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
  `images` varchar(255) NOT NULL,
  `number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Accommodation`
--

INSERT INTO `Accommodation` (`id`, `name`, `description`, `city`, `address`, `type`, `images`, `number`) VALUES
(1, 'Flat 1', '1-bedroom apartment located in the city center, fully furnished.', 'Koper', 'Vojkovo Nabrezje 20', 'Condo', 'https://www.collegiate-ac.com/propeller/uploads/sites/2/2020/08/DWS-Premiun-Plus-Studio-PJSPhotography-04-08-21-DSC_0401-1024x683.jpg', '070-377-566'),
(2, 'Big suburban appartement', 'A room in a 2-bedroom apartment located in the suburbs, with a balcony and parking.', 'Koper', 'Jenkova Ulica 2', 'Shared Room', 'https://i.pinimg.com/originals/de/0c/a7/de0ca782d62d8c13cf00b32755306b12.jpg', '070-123-353'),
(3, 'Studio in the city center', 'Studio apartment located near the university, with a kitchenette and air conditioning.', 'Koper', 'Cevljarska 33', 'Studio', 'https://cairnestateagency.com/wp-content/uploads/2019/09/VibeStudentLiving-ClusterFlat-May17.jpg.jpg', '069-999-343'),
(4, 'Big apartment', '3-bedroom apartment located in a quiet neighborhood, with a garden and barbecue area.', 'Izola', 'Ljubljanska 1', 'Shared Room', 'https://cdn.student-it.com/wp-content/uploads/2022/08/7871600.jpg', '069-123-665');

-- --------------------------------------------------------

--
-- Table structure for table `AccommodationReview`
--

CREATE TABLE `AccommodationReview` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `accommodation_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `stars` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `AccommodationReview`
--

INSERT INTO `AccommodationReview` (`id`, `user_id`, `accommodation_id`, `body`, `stars`, `date`) VALUES
(6, 36, 1, 'It is good', 5, '2023-05-17'),
(7, 36, 2, 'WOW', 4, '2023-05-17'),
(8, 36, 3, 'Too expensive', 2, '2023-05-17'),
(9, 37, 1, 'Miki Maus is layingg.', 2, '2023-05-17');

-- --------------------------------------------------------

--
-- Table structure for table `Ad`
--

CREATE TABLE `Ad` (
  `id` int(11) NOT NULL,
  `title` varchar(40) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `people` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Ad`
--

INSERT INTO `Ad` (`id`, `title`, `user_id`, `description`, `location`, `date`, `people`, `phone`) VALUES
(78, 'asfghdfgfssafdsgf', 37, 'asfgsfhdgfasf', 'asfdghfgfasf', '2023-05-17 18:59:40', 12, '1245657123'),
(80, 'asfghdfgfssafdsgf', 37, 'asfgsfhdgfasf', 'asfdghfgfasf', '2023-05-17 18:59:40', 12, '1245657123'),
(82, 'Veliko okupljanje', 36, 'Veliko okuopljanje na plaziiiiiii sviramo pjevamo plesemo', 'Koper - Mokra Macka', '2023-05-17 19:24:28', 30, '069847262'),
(83, 'Belveder 8', 36, 'Depression room', 'Belveder 8', '2023-05-17 19:29:43', 4, '696969696969');

-- --------------------------------------------------------

--
-- Table structure for table `Courses`
--

CREATE TABLE `Courses` (
  `id` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `ects` int(11) NOT NULL DEFAULT 6,
  `semester` enum('Spring','Winter') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Courses`
--

INSERT INTO `Courses` (`id`, `professor_id`, `description`, `name`, `link`, `ects`, `semester`) VALUES
(1, 1, 'This course provides an introduction to programming concepts and techniques. Students will learn the fundamentals of programming languages, basic algorithms, and problem-solving strategies. The course aims to develop students programming skills and their ability to design and implement simple software applications.', 'Introduction to Programming', 'https://www.famnit.upr.si/en/education/undergraduate/cs-first/', 6, 'Spring'),
(2, 2, 'This course focuses on the study of data structures and algorithms. Students will learn various data structures such as arrays, linked lists, stacks, queues, trees, and graphs, and analyze their efficiency in terms of time and space complexity. Additionally, students will gain knowledge of algorithm design and analysis techniques. The course aims to equip students with the necessary skills to develop efficient algorithms for solving computational problems. ', 'Data Structures and Algorithms', 'https://www.famnit.upr.si/en/education/master/computer-science/', 6, 'Spring'),
(3, 3, 'This course explores the fundamental concepts and principles of database systems. Students will learn about data modeling, relational database design, SQL (Structured Query Language) programming, and database management systems. The course covers topics such as normalization, indexing, query optimization, and transaction processing. Students will also gain hands-on experience in designing and implementing databases. ', 'Database Systems', 'https://www.famnit.upr.si/en/education/master/computer-science/', 6, 'Winter'),
(4, 1, 'This course introduces the field of artificial intelligence (AI) and its applications. Students will learn about AI techniques such as problem-solving, knowledge representation, machine learning, and natural language processing. The course covers both theoretical foundations and practical implementations of AI algorithms. Students will have the opportunity to work on AI projects and explore cutting-edge developments in the field. ', 'Artificial Intelligence', 'https://www.coursera.org/browse/computer-science', 6, 'Winter');

-- --------------------------------------------------------

--
-- Table structure for table `CoursesReview`
--

CREATE TABLE `CoursesReview` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `body` varchar(255) NOT NULL,
  `stars` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT CURRENT_DATE()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `CoursesReview`
--

INSERT INTO `CoursesReview` (`id`, `user_id`, `course_id`, `body`, `stars`, `date`) VALUES
(2, 36, 2, 'Hard course. WOuld not recommend.....very hard', 2, '2023-05-17'),
(4, 36, 1, 'Nice course', 5, '2023-05-17'),
(5, 36, 3, 'Boring', 3, '2023-05-17'),
(6, 36, 4, 'It is not so useful', 4, '2023-05-17');

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

--
-- Dumping data for table `Professor`
--

INSERT INTO `Professor` (`id`, `name`, `surname`, `email`, `department`) VALUES
(1, 'John', 'Doe', 'johndoe@famnit.upr.si', 'Computer Science'),
(2, 'Jane', 'Johnson', 'janejohnson@famnit.upr.si', 'Computer Science'),
(3, 'Mark', 'Ball', 'markball@famnit.upr.si', 'Computer Science');

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

--
-- Dumping data for table `ProfessorReview`
--

INSERT INTO `ProfessorReview` (`id`, `user_id`, `professor_id`, `body`, `stars`) VALUES
(2, 37, 1, 'Good...', 3),
(3, 37, 2, '', 1),
(4, 36, 3, 'Too hard but fair', 4);

-- --------------------------------------------------------

--
-- Table structure for table `Restaurants`
--

CREATE TABLE `Restaurants` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `price` float NOT NULL,
  `image` varchar(255) NOT NULL,
  `city` enum('Koper','Izola','Piran','Portoroz') NOT NULL DEFAULT 'Koper'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Restaurants`
--

INSERT INTO `Restaurants` (`id`, `name`, `address`, `phone`, `price`, `image`, `city`) VALUES
(1, 'Atrij', 'Čevljarska ulica 8', '(05) 627 22 55', 4, 'https://www.malcajt.com/upload/restaurant_gallery/restaurant_gallery1475493256208.jpg', 'Koper'),
(2, 'Villa Domus', 'Vojkovo Nabrezje 12', '070 500 866', 4, 'https://villa-domus.si/storage/image/201705/standardCrop/cu0a8630-2.jpg', 'Koper'),
(3, 'Fast Food Magic', 'Pristaniška ulica 2', '031 477 222', 2.14, 'https://visitkoper.si/wp-content/uploads/2020/02/fast-food-magic.jpg', 'Koper');

-- --------------------------------------------------------

--
-- Table structure for table `RestaurantsReview`
--

CREATE TABLE `RestaurantsReview` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `body` varchar(255) NOT NULL,
  `stars` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `RestaurantsReview`
--

INSERT INTO `RestaurantsReview` (`id`, `user_id`, `restaurant_id`, `body`, `stars`, `date`) VALUES
(4, 37, 3, 'Cheap', 4, '2023-05-17'),
(8, 37, 1, 'Good pizza', 4, '2023-05-17'),
(9, 37, 2, 'Solid', 3, '2023-05-17');

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
(34, '1', '1', '1', '1', '1@1.1', 'admin'),
(35, '2', '2', '2', '2', '2@2.2', 'admin'),
(36, 'Miki', 'Maus', 'maus', 'miki', 'miki123@gmai.com', 'student'),
(37, 'Paja', 'Patak', 'patak', 'paja', 'paja@123.com', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Accommodation`
--
ALTER TABLE `Accommodation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `AccommodationReview`
--
ALTER TABLE `AccommodationReview`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `accomodation_id` (`accommodation_id`);

--
-- Indexes for table `Ad`
--
ALTER TABLE `Ad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- Indexes for table `Restaurants`
--
ALTER TABLE `Restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `RestaurantsReview`
--
ALTER TABLE `RestaurantsReview`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `AccommodationReview`
--
ALTER TABLE `AccommodationReview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Ad`
--
ALTER TABLE `Ad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `Courses`
--
ALTER TABLE `Courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `CoursesReview`
--
ALTER TABLE `CoursesReview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Professor`
--
ALTER TABLE `Professor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ProfessorReview`
--
ALTER TABLE `ProfessorReview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Restaurants`
--
ALTER TABLE `Restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `RestaurantsReview`
--
ALTER TABLE `RestaurantsReview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `AccommodationReview`
--
ALTER TABLE `AccommodationReview`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`accommodation_id`) REFERENCES `accommodation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Ad`
--
ALTER TABLE `Ad`
  ADD CONSTRAINT `ad_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `RestaurantsReview`
--
ALTER TABLE `RestaurantsReview`
  ADD CONSTRAINT `restaurantsreview_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `Restaurants` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `restaurantsreview_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
