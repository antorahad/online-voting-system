-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2023 at 09:43 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinevotingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidate_details`
--

CREATE TABLE `candidate_details` (
  `id` int(11) NOT NULL,
  `election_id` int(11) NOT NULL,
  `candidate_name` varchar(255) NOT NULL,
  `candidate_brand` varchar(255) NOT NULL,
  `candidate_photo` text NOT NULL,
  `inserted_by` varchar(255) NOT NULL,
  `inserted_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidate_details`
--

INSERT INTO `candidate_details` (`id`, `election_id`, `candidate_name`, `candidate_brand`, `candidate_photo`, `inserted_by`, `inserted_on`) VALUES
(33, 33, 'Nur Ahad', 'Nouka', '../candidate_photos/669021551_54255288983PicsArt_22-11-13_22-30-08-388.jpg', 'Nur Ahad', '2023-03-27'),
(34, 33, 'Ahad Munsi', 'Rumal', '../candidate_photos/90662589321_91179595980PicsArt_22-11-13_22-30-08-388.jpg', 'Nur Ahad', '2023-03-27');

-- --------------------------------------------------------

--
-- Table structure for table `elections`
--

CREATE TABLE `elections` (
  `id` int(11) NOT NULL,
  `election_topic` varchar(255) NOT NULL,
  `no_of_candidates` int(11) NOT NULL,
  `starting_date` date NOT NULL,
  `ending_date` date NOT NULL,
  `status` varchar(45) NOT NULL,
  `inserted_by` varchar(255) NOT NULL,
  `inserted_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `elections`
--

INSERT INTO `elections` (`id`, `election_topic`, `no_of_candidates`, `starting_date`, `ending_date`, `status`, `inserted_by`, `inserted_on`) VALUES
(33, 'Chairman_Nirbachon_2023', 2, '2023-03-28', '2023-03-29', 'Expired', 'Nur Ahad', '2023-03-27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `nid_no` varchar(45) NOT NULL,
  `password` text NOT NULL,
  `user_role` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `nid_no`, `password`, `user_role`) VALUES
(11, 'Nur Ahad', '17181103020', '25f849bc0d7c2b8f8594d708b44e63f91d00cf0e', 'Admin'),
(12, 'Kazi Fahim', '17181103021', '32a345f4c6820b9a0878a46be85ce1784ca4503d', 'Voter'),
(14, 'Fatima Khanom', '17181103022', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Voter'),
(15, 'Jubair', '17181103109', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Voter'),
(16, 'Rakibul', '17181103095', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Voter'),
(17, 'Spondon Mallick', '17181103015', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Voter'),
(18, 'Nafisa Khatun', '17181103019', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Voter');

-- --------------------------------------------------------

--
-- Table structure for table `votings`
--

CREATE TABLE `votings` (
  `id` int(11) NOT NULL,
  `election_id` int(11) NOT NULL,
  `voters_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `vote_date` date NOT NULL,
  `vote_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votings`
--

INSERT INTO `votings` (`id`, `election_id`, `voters_id`, `candidate_id`, `vote_date`, `vote_time`) VALUES
(43, 22, 12, 14, '2023-03-06', '06:13:56'),
(44, 22, 15, 15, '2023-03-06', '07:12:31'),
(45, 22, 16, 14, '2023-03-06', '07:14:32'),
(46, 22, 17, 15, '2023-03-07', '03:10:28'),
(47, 23, 12, 16, '2023-03-07', '03:57:45'),
(48, 23, 15, 16, '2023-03-07', '03:58:25'),
(49, 23, 17, 17, '2023-03-07', '04:00:25'),
(50, 27, 17, 24, '2023-03-08', '07:01:45'),
(51, 27, 12, 24, '2023-03-08', '07:02:19'),
(52, 27, 15, 24, '2023-03-08', '07:02:33'),
(53, 27, 16, 25, '2023-03-08', '07:02:52'),
(54, 30, 17, 29, '2023-03-10', '05:16:35'),
(55, 30, 16, 28, '2023-03-10', '03:24:44'),
(56, 30, 15, 28, '2023-03-10', '03:24:56'),
(57, 30, 12, 28, '2023-03-10', '03:25:13'),
(58, 30, 18, 28, '2023-03-10', '03:47:15'),
(59, 32, 17, 30, '2023-03-17', '09:59:54'),
(60, 32, 18, 30, '2023-03-17', '10:00:07'),
(61, 32, 12, 31, '2023-03-17', '10:00:24'),
(62, 32, 16, 32, '2023-03-17', '10:00:31'),
(63, 33, 17, 33, '2023-03-29', '10:07:01'),
(64, 33, 18, 33, '2023-03-29', '10:07:07'),
(65, 33, 12, 33, '2023-03-29', '10:07:14'),
(66, 33, 16, 33, '2023-03-29', '10:07:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidate_details`
--
ALTER TABLE `candidate_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `elections`
--
ALTER TABLE `elections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votings`
--
ALTER TABLE `votings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidate_details`
--
ALTER TABLE `candidate_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `elections`
--
ALTER TABLE `elections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `votings`
--
ALTER TABLE `votings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
