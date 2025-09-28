-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2025 at 12:01 PM
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
(1, 'Learn More About Our Work And Our Cultural Activities', 'Hello World Hello World Hello World Hello World Hello World ', 'Hello World Hello World Hello World Hello World ', 'Sign Up ', 'Abdul Qudoos', 'CEO & Founder', 'uploads/pp - Copy.jpeg', 'uploads/about_us/1759052339_img1_about-1.jpg', 'uploads/about_us/1759052339_img2_about-2.jpg', 'uploads/about_us/1759052339_img3_about-3.jpg');

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
(1, 'School Principal', 'Myself Abdul Qudoos Principal of the School', 'My aim is to become every student get success on his dream.', 'Get Started', 'Abdul Qudoos', 'Head of Department', 'uploads/principal/1759044251_principal_user.jpg', 'uploads/principal/1759044269_img1_user.jpg', 'uploads/principal/1759044269_img2_user.jpg', 'uploads/principal/1759044269_img3_user.jpg');

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
(1, 'Drawing class school nawabshah', 'John Smith', 'uploads/teachers/1759052450_team-3.jpg', '$100', '5-10 years', '10:00 AM - 11:30 AM', '20', 'uploads/classes/1759052450_classes-5.jpg'),
(2, 'Music Class', 'Jane Doe', 'uploads/teachers/1759052434_testimonial-3.jpg', '$150', '7-12 years', '1:00 PM - 2:30 PM', '15', 'uploads/classes/1759052434_classes-3.jpg'),
(3, 'hilo', 'nawabshah', 'uploads/teachers/1759052416_user.jpg', '900', '8-15', '9-10', '9', 'uploads/classes/1759052416_classes-2.jpg'),
(7, 'abc 7', 'abd', 'uploads/teachers/1759052400_team-1.jpg', '$500', '12-15', '10:00 AM - 11:30 AM', '20', 'uploads/classes/1759052400_classes-1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `newsletter_text` text DEFAULT NULL,
  `map_url` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`id`, `address`, `phone`, `email`, `newsletter_text`, `map_url`, `created_at`) VALUES
(1, 'Nawabshah', '123456789', 'info@gmail.com', 'Subscribe to our newsletter for latest updates.', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d57257.09145893177!2d68.36184059719353!3d26.243215811355594!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x394a4cb563f028e5%3A0x93d25e06c0ec002d!2sNawabshah%2C%20Pakistan!5e0!3m2!1sen!2s!4v1759047218368!5m2!1sen!2s', '2025-09-28 04:51:17');

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
(2, 'Hello', 'xxncnscs', 'fab fa-facebook', 'warning'),
(3, 'Ground', 'snccscccs', 'fab fa-instagram', 'secondary'),
(4, 'hshds', 'asjksdd ajxbs ioshswwjd', 'fas fa-code', 'info'),
(5, 'Hello World', 'hy helllo kids', 'fas fa-chalkboard-teacher', 'danger');

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
(6, 'abdul', 'professor', 'uploads/faculty/1758971689_pp - Copy.jpeg', 'http://localhost/admin_1/kider-1.0.0/faculty.php', 'http://localhost/admin_1/kider-1.0.0/faculty.php', 'http://localhost/admin_1/kider-1.0.0/faculty.php', '2025-08-21 19:59:42'),
(8, 'king y', 'pmi', 'uploads/faculty/1759052699_team-3.jpg', 'http://localhost/admin_1/kider-1.0.0/faculty.php', 'http://localhost/admin_1/kider-1.0.0/faculty.php', 'http://localhost/admin_1/kider-1.0.0/faculty.php', '2025-08-21 20:38:17'),
(10, 'Dr. MUHAMMAD AYUB', 'CEO', 'uploads/faculty/1759052690_team-2.jpg', 'http://localhost/admin_1/kider-1.0.0/faculty.php', 'http://localhost/admin_1/kider-1.0.0/faculty.php', 'http://localhost/admin_1/kider-1.0.0/faculty.php', '2025-08-23 19:19:29'),
(11, 'Abdul Khaliq', 'Computer Teacher', 'uploads/faculty/1759052680_team-1.jpg', 'https://www.facebook.com/', 'https://www.twitter.com/', 'https://www.instagram.com/', '2025-09-28 05:44:05');

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
(1, 'Housing Society Nawabshah Sindg Pakistan', '03123456789', 'info@school.com', 'Home|About Us|Faculty|Contact Us|Website', 'subscribe for more updated.');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `title`, `image`, `description`, `created_at`) VALUES
(2, 'dsnfk', 'uploads/gallery/1759052934_classes-6.jpg', 'ndkdf', '2025-09-28 08:25:55'),
(3, 'dknfkd', 'uploads/gallery/1759052924_classes-5.jpg', 'nnsdd;dsf', '2025-09-28 08:27:15'),
(4, 'dkf.sd  skjdfl', 'uploads/gallery/1759052915_classes-4.jpg', 'ndsf ', '2025-09-28 08:27:38'),
(5, 'snnk', 'uploads/gallery/1759052905_classes-3.jpg', 'sdn.', '2025-09-28 08:27:49'),
(6, 'nf.dsn', 'uploads/gallery/1759052898_classes-2.jpg', 'skdn.w', '2025-09-28 08:28:00'),
(7, 'cskd', 'uploads/gallery/1759052884_classes-1.jpg', 'knkc', '2025-09-28 09:31:49');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `subject`, `message`, `status`, `created_at`) VALUES
(1, 'Abdu', 'abdul@gmail.com', 'Hello', 'hello hello', 'read', '2025-09-28 09:19:34'),
(2, 'Abdu', 'abdul@gmail.com', 'Hello', 'hello hello', 'read', '2025-09-28 09:19:57'),
(3, 'Abdul ', 'abdulkhaliq@gmail.com', 'Hello i want to admission my child in you school', 'which i will come to you for information ', 'read', '2025-09-28 09:34:11');

-- --------------------------------------------------------

--
-- Table structure for table `quicklinks`
--

CREATE TABLE `quicklinks` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quicklinks`
--

INSERT INTO `quicklinks` (`id`, `title`, `url`) VALUES
(1, 'Home', 'index.php'),
(2, 'About Us', 'about.php'),
(3, 'Faculty', 'faculty.php'),
(4, 'Facilities', 'facilities.php'),
(5, 'Gallery', 'gallery.php'),
(6, 'Contact Us', 'contact.php');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `site_icon` varchar(100) DEFAULT 'fa-book-reader',
  `site_logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `site_icon`, `site_logo`, `created_at`) VALUES
(1, 'School', 'fa-cloud', 'uploads/settings/1759050091_team-3.jpg', '2025-09-28 08:38:12');

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
(1, 1, 'uploads/slider/1759043868_carousel-1.jpg', 'Welcome to school website', 'This is slide 1 text', 'Learn More', 'http://localhost/admin_1/dashboard.php?page=edit_slider', 'Contact Us', 'http://localhost/admin_1/dashboard.php?page=edit_slider'),
(2, 2, 'uploads/slider/1759043886_carousel-2.jpg', 'Our Services', 'This is slide 2 text', 'See More', 'http://localhost/admin_1/dashboard.php?page=edit_slider', 'Get Started', 'http://localhost/admin_1/dashboard.php?page=edit_slider');

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
(1, 'Message', 'Tommorrow is school open and surprise function', 'uploads/events/1759052562_team-1.jpg');

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
(2, 'Sara Ahmed', 'Graphic Designer', 'Amazing experience, highly recommended!', 'uploads/testimonials/1759052193_testimonial-2.jpg'),
(3, 'John Doe', 'Businessman', 'Professional team and great work ethic.', 'uploads/testimonials/1759052251_testimonial-1.jpg'),
(6, 'ABDUL', 'BSCS ', 'VERY GOOD SCHOOL FOR EDUCATE YOUR CHILDREN ', 'uploads/testimonials/1759053017_testimonial-1.jpg'),
(7, 'abdul malik', 'student', 'good school', 'uploads/testimonials/1759053005_testimonial-2.jpg');

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
(1, 'Admin School', 'admin@example.com', '$2y$10$jP3URLbEoNPefJ2YpR5eHu8gTazb/GPBAGWMOuS7rDTEWQvbwbMJ.'),
(2, 'abdul qudoos', 'aq@gmail.com', '$2y$10$46873ZVpwQB34ntpcQNlFec6wIzcShgmOiehvJVzXHyHFClSqUAby');

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
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
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
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quicklinks`
--
ALTER TABLE `quicklinks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `footer`
--
ALTER TABLE `footer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quicklinks`
--
ALTER TABLE `quicklinks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
