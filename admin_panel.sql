-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2025 at 11:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_panel`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description1` text NOT NULL,
  `description2` text NOT NULL,
  `button_text` varchar(100) DEFAULT 'Read More',
  `person_name` varchar(100) DEFAULT 'Jhon Doe',
  `designation` varchar(100) DEFAULT 'CEO & Founder',
  `person_image` varchar(255) DEFAULT 'img/user.jpg',
  `img1` varchar(255) DEFAULT 'img/about-1.jpg',
  `img2` varchar(255) DEFAULT 'img/about-2.jpg',
  `img3` varchar(255) DEFAULT 'img/about-3.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`id`, `title`, `description1`, `description2`, `button_text`, `person_name`, `designation`, `person_image`, `img1`, `img2`, `img3`) VALUES
(1, 'Learn More About Our Work And Our Cultural Activities', 'Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et eos...', 'Stet no et lorem dolor et diam, amet duo ut dolore vero eos...', 'Sign Up ', 'Abdul Qudoos', 'CEO & Founder', 'img/user.jpg', 'img/about-1.jpg', 'img/about-2.jpg', 'img/about-3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description1` text NOT NULL,
  `description2` text NOT NULL,
  `button_text` varchar(100) DEFAULT 'Read More',
  `principal_name` varchar(100) DEFAULT NULL,
  `principal_designation` varchar(100) DEFAULT NULL,
  `principal_image` varchar(255) DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `card`
--

INSERT INTO `card` (`id`, `title`, `description1`, `description2`, `button_text`, `principal_name`, `principal_designation`, `principal_image`, `image1`, `image2`, `image3`) VALUES
(1, 'School Principal', 'Myself Abdul Qudoos Principal of the School', 'My aim is to become every student get success on his dream.', 'Get Started', 'Abdul Qudoos', 'Principal', 'uploads/abdulqudoos.jfif', 'uploads/IMG_1669.JPG', 'uploads/IMG_1669.JPG', 'uploads/IMG-20250205-WA0094.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `teacher_name` varchar(255) NOT NULL,
  `teacher_image` varchar(255) DEFAULT 'img/user.jpg',
  `price` varchar(100) NOT NULL,
  `age_range` varchar(50) NOT NULL,
  `time` varchar(100) NOT NULL,
  `capacity` varchar(50) NOT NULL,
  `class_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `title`, `teacher_name`, `teacher_image`, `price`, `age_range`, `time`, `capacity`, `class_image`) VALUES
(1, 'Drawing class school', 'John Smith', 'UPLOADS/classes/1758901190_teacher_abdulqudoos.jfif', '$100', '5-10 years', '10:00 AM - 11:30 AM', '20', 'UPLOADS/classes/1758901638_class_1758901174_class_classes-3.jpg'),
(2, 'Music Class', 'Jane Doe', 'UPLOADS/classes/1758901583_teacher_carousel-2-1754892764.jpg', '$150', '7-12 years', '1:00 PM - 2:30 PM', '15', 'UPLOADS/classes/1758901638_class_1758901174_class_classes-3.jpg'),
(3, 'hilo', 'nawabshah', 'UPLOADS/classes/1758901638_teacher_abdulqudoos.jfif', '900', '8-15', '9-10', '9', 'UPLOADS/classes/1758901638_class_1758901174_class_classes-3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(100) DEFAULT 'fa fa-home',
  `color` varchar(50) DEFAULT 'primary'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `title`, `description`, `icon`, `color`) VALUES
(1, 'Play', 'palypalypalypalypalypalypaly', 'fas fa-server', 'success');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `name`, `designation`, `image`, `facebook`, `twitter`, `instagram`, `created_at`) VALUES
(6, 'abdul', 'professor', 'uploads/carousel-1-1754897774.jpg', 'http://localhost/admin_1/kider-1.0.0/faculty.php', 'http://localhost/admin_1/kider-1.0.0/faculty.php', 'http://localhost/admin_1/kider-1.0.0/faculty.php', '2025-08-21 19:59:42'),
(8, 'king y', 'pmi', 'uploads/faculty/1755808697_team-1.jpg', 'http://localhost/admin_1/kider-1.0.0/faculty.php', 'http://localhost/admin_1/kider-1.0.0/faculty.php', 'http://localhost/admin_1/kider-1.0.0/faculty.php', '2025-08-21 20:38:17'),
(10, 'Dr. MUHAMMAD AYUB', 'CEO', 'uploads/faculty/1755976838_NEW LOGO.jpg', 'http://localhost/admin_1/kider-1.0.0/faculty.php', 'http://localhost/admin_1/kider-1.0.0/faculty.php', 'http://localhost/admin_1/kider-1.0.0/faculty.php', '2025-08-23 19:19:29');

-- --------------------------------------------------------

--
-- Table structure for table `footer`
--

CREATE TABLE `footer` (
  `id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `quick_links` text DEFAULT NULL,
  `newsletter_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `footer`
--

INSERT INTO `footer` (`id`, `address`, `phone`, `email`, `quick_links`, `newsletter_text`) VALUES
(1, 'Housing Society Nawabshah', '03123456789', 'info@school.com', 'Home|About Us|Faculty|Contact Us', 'subscribe for more updated.');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `slide_number` int(2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `paragraph` text DEFAULT NULL,
  `btn1_text` varchar(100) DEFAULT NULL,
  `btn1_url` varchar(255) DEFAULT NULL,
  `btn2_text` varchar(100) DEFAULT NULL,
  `btn2_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `slide_number`, `image`, `heading`, `paragraph`, `btn1_text`, `btn1_url`, `btn2_text`, `btn2_url`) VALUES
(1, 1, 'carousel-1-1755357486.jpg', 'Welcome to school website', 'This is slide 1 text', 'Learn More', 'http://localhost/admin_1/dashboard.php?page=edit_slider', 'Contact Us', 'http://localhost/admin_1/dashboard.php?page=edit_slider'),
(2, 2, 'carousel-2-1755357486.jpg', 'Our Services', 'This is slide 2 text', 'See More', 'http://localhost/admin_1/dashboard.php?page=edit_slider', 'Get Started', 'http://localhost/admin_1/dashboard.php?page=edit_slider');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_section`
--

CREATE TABLE `teacher_section` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT 'img/call-to-action.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_section`
--

INSERT INTO `teacher_section` (`id`, `title`, `description`, `image`) VALUES
(1, 'PRINCIPLE MESSAGE', 'Tomorrow is the leave of the school', 'uploads/Gemini_Generated_Image_zfciehzfciehzfci.png');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `profession` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `image` varchar(255) DEFAULT 'img/default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `client_name`, `profession`, `comment`, `image`) VALUES
(2, 'Sara Ahmed', 'Graphic Designer', 'Amazing experience, highly recommended!', 'img/1758963781_pexels-samer-alhusseini-540227434-17340981.jpg'),
(3, 'John Doe', 'Businessman', 'Professional team and great work ethic.', 'img/1758963758_profile-pic (1).png'),
(6, 'ABDUL', 'BSCS ', 'VERY GOOD SCHOOL FOR EDUCATE YOUR CHILDREN ', 'img/1758963708_IMG_1814.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'John Doe', 'admin@example.com', 'e10adc3949ba59abbe56e057f20f883e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer`
--
ALTER TABLE `footer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slide_number` (`slide_number`);

--
-- Indexes for table `teacher_section`
--
ALTER TABLE `teacher_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `footer`
--
ALTER TABLE `footer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teacher_section`
--
ALTER TABLE `teacher_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
