-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2022 at 01:53 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_feature`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_account`
--

CREATE TABLE `table_account` (
  `id` int(100) NOT NULL,
  `name` varchar(500) NOT NULL,
  `role` int(100) NOT NULL DEFAULT 0,
  `pkg_id` varchar(100) DEFAULT NULL,
  `user_id` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `active` int(100) NOT NULL DEFAULT 1,
  `validity` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_account`
--

INSERT INTO `table_account` (`id`, `name`, `role`, `pkg_id`, `user_id`, `password`, `active`, `validity`) VALUES
(1, 'Admin', 1, 'com.appsfeature', 'admin', '123', 1, '2024-01-31 19:15:44'),
(3, 'Amit Jain', 0, 'com.appsfeature.bizwiz', 'amit', 'amit@123', 1, '2023-05-17 19:16:26'),
(4, 'Katyayan School', 0, 'com.katyayanschool.katyayanschool', 'school', 'school@123', 1, '2023-02-14 07:20:53');

-- --------------------------------------------------------

--
-- Table structure for table `table_app`
--

CREATE TABLE `table_app` (
  `app_id` int(100) NOT NULL,
  `pkg_id` varchar(500) NOT NULL,
  `app_name` varchar(500) NOT NULL,
  `visibility` int(100) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_app`
--

INSERT INTO `table_app` (`app_id`, `pkg_id`, `app_name`, `visibility`) VALUES
(1, 'com.appsfeature', 'Appsfeature', 1),
(2, 'com.appsfeature.bizwiz', 'BizWiz', 1),
(3, 'com.katyayanschool.katyayanschool', 'Katyayan School', 1);

-- --------------------------------------------------------

--
-- Table structure for table `table_category`
--

CREATE TABLE `table_category` (
  `pkg_id` varchar(100) NOT NULL,
  `cat_id` int(100) NOT NULL,
  `sub_cat_id` int(100) NOT NULL DEFAULT 0,
  `title` varchar(1000) NOT NULL,
  `item_type` int(100) DEFAULT 0,
  `image` varchar(1000) DEFAULT NULL,
  `ranking` int(100) NOT NULL DEFAULT 0,
  `visibility` int(100) NOT NULL DEFAULT 1,
  `json_data` varchar(5000) DEFAULT NULL,
  `other_property` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_category`
--

INSERT INTO `table_category` (`pkg_id`, `cat_id`, `sub_cat_id`, `title`, `item_type`, `image`, `ranking`, `visibility`, `json_data`, `other_property`, `updated_at`, `created_at`) VALUES
('com.appsfeature', 108, 0, 'Dashboard', 0, NULL, 0, 1, '', '', NULL, '2022-02-03 17:12:07'),
('com.appsfeature', 109, 108, 'Mobile Shop', 1, NULL, 0, 1, '', '', NULL, '2022-02-03 17:15:17'),
('com.appsfeature', 110, 108, 'Cloth Shop', 1, NULL, 0, 1, '', '', NULL, '2022-02-03 17:15:33'),
('com.appsfeature', 111, 108, 'Electronics', 0, NULL, 0, 1, '', '', NULL, '2022-02-03 19:20:14'),
('com.appsfeature', 112, 111, 'Laptops', 0, '5bc19555e3a6ddae1a318f0f486cf092.png', 0, 1, '', '', NULL, '2022-02-03 19:20:57'),
('com.appsfeature', 113, 108, 'Qwerty', 0, NULL, 0, 1, '', '', NULL, '2022-02-05 18:07:16'),
('com.appsfeature.bizwiz', 114, 0, 'Home Slider', 0, NULL, 0, 1, '', '', NULL, '2022-02-05 18:41:48'),
('com.katyayanschool.katyayanschool', 115, 0, 'Dashboard', 0, NULL, 0, 1, '', '', NULL, '2022-02-14 06:46:16'),
('com.katyayanschool.katyayanschool', 116, 115, 'Home Menu', 3, NULL, 0, 1, '', '{\"random_icon_color\": true}', NULL, '2022-02-14 06:58:47'),
('com.katyayanschool.katyayanschool', 121, 115, 'Home Slider', 6, '5324853ebc38baa76df534044924f7a3.jpeg', 0, 1, '', '{\"hide_title\": true}', NULL, '2022-02-14 11:01:10'),
('com.katyayanschool.katyayanschool', 122, 116, 'PDF Books', 10, NULL, 0, 1, '', '', NULL, '2022-02-16 10:56:57');

-- --------------------------------------------------------

--
-- Table structure for table `table_category_master`
--

CREATE TABLE `table_category_master` (
  `pkg_id` varchar(100) NOT NULL,
  `id` int(11) NOT NULL,
  `cat_id` int(100) NOT NULL,
  `sub_cat_id` int(100) NOT NULL,
  `sub_cat_name` varchar(100) DEFAULT NULL,
  `visibility` int(100) DEFAULT 1,
  `ranking` int(100) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_category_master`
--

INSERT INTO `table_category_master` (`pkg_id`, `id`, `cat_id`, `sub_cat_id`, `sub_cat_name`, `visibility`, `ranking`, `created_at`) VALUES
('com.appsfeature', 1, 108, 0, NULL, 1, 0, '2022-02-03 17:12:07'),
('com.appsfeature', 2, 109, 108, 'Dashboard', 1, 0, '2022-02-03 17:15:17'),
('com.appsfeature', 3, 110, 108, 'Dashboard', 1, 0, '2022-02-03 17:15:33'),
('com.appsfeature', 4, 111, 108, 'Dashboard', 1, 0, '2022-02-03 19:20:14'),
('com.appsfeature', 5, 112, 111, 'Electronics', 1, 0, '2022-02-03 19:20:57'),
('com.appsfeature', 6, 113, 108, 'Dashboard', 1, 0, '2022-02-05 18:07:16'),
('com.appsfeature.bizwiz', 7, 114, 0, NULL, 1, 0, '2022-02-05 18:41:48'),
('com.katyayanschool.katyayanschool', 8, 115, 0, NULL, 1, 0, '2022-02-14 06:46:16'),
('com.katyayanschool.katyayanschool', 9, 116, 115, 'Dashboard', 1, 0, '2022-02-14 06:58:47'),
('com.katyayanschool.katyayanschool', 10, 121, 115, 'Dashboard', 1, 0, '2022-02-14 11:01:10'),
('com.katyayanschool.katyayanschool', 11, 122, 116, 'Home Menu', 1, 0, '2022-02-16 10:56:57');

-- --------------------------------------------------------

--
-- Table structure for table `table_content`
--

CREATE TABLE `table_content` (
  `pkg_id` varchar(100) NOT NULL,
  `id` int(100) NOT NULL,
  `cat_id` int(100) NOT NULL DEFAULT 0,
  `sub_cat_id` int(100) NOT NULL DEFAULT 0,
  `title` varchar(1000) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `item_type` int(100) DEFAULT 0,
  `image` varchar(100) DEFAULT NULL,
  `link` varchar(1000) DEFAULT NULL,
  `visibility` int(100) NOT NULL DEFAULT 1,
  `ranking` int(100) DEFAULT 0,
  `json_data` varchar(5000) DEFAULT NULL,
  `other_property` varchar(1000) DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_content`
--

INSERT INTO `table_content` (`pkg_id`, `id`, `cat_id`, `sub_cat_id`, `title`, `description`, `item_type`, `image`, `link`, `visibility`, `ranking`, `json_data`, `other_property`, `updated_at`, `created_at`) VALUES
('com.appsfeature', 39, 0, 109, 'Android Phones', '', 0, NULL, '', 1, 0, '', '', NULL, '2022-02-03 18:21:14'),
('com.appsfeature', 40, 0, 109, 'Apple Phones', '', 0, NULL, '', 1, 0, '', '', NULL, '2022-02-03 18:21:35'),
('com.appsfeature', 41, 0, 110, 'Womens Cloth', '', 0, NULL, '', 1, 0, '', '', NULL, '2022-02-03 18:23:39'),
('com.appsfeature', 42, 0, 110, 'Mens Cloth', '', 101, NULL, '', 1, 0, '', '', NULL, '2022-02-03 18:23:51'),
('com.appsfeature', 43, 0, 112, 'Dell Laptop', '', 150, NULL, '', 1, 0, '', '', NULL, '2022-02-03 19:24:25'),
('com.katyayanschool.katyayanschool', 45, 0, 116, 'Live Classes', '', 107, 'f88d3e71037eded195690054bdc3cda7.png', '', 1, 0, '', '', NULL, '2022-02-14 09:33:34'),
('com.katyayanschool.katyayanschool', 46, 0, 116, 'Test Series', '', 102, '9e67fd16f5ad2e3f0fcea3bda0d2e0e4.png', 'https://www.katyayangroups.com/erp/index.php/Stu_app_exam/test/', 1, 0, '', '', NULL, '2022-02-14 09:33:59'),
('com.katyayanschool.katyayanschool', 47, 0, 116, 'My Profile', '', 108, 'd60b2444fe7e286fd2b8b35c18214cfe.png', '', 1, 0, '', '', NULL, '2022-02-14 09:37:13'),
('com.katyayanschool.katyayanschool', 48, 0, 116, 'Previous Classes', '', 106, '247f356e5f8c978a03d6388ba5e9fcdb.png', '', 1, 0, '', '', NULL, '2022-02-14 09:37:55'),
('com.katyayanschool.katyayanschool', 49, 0, 121, 'Slider 1', '', 100, '8f8ecd2ff351223233a0ae8c08d9d4e0.jpg', '', 1, 0, '', '', NULL, '2022-02-14 11:02:33'),
('com.katyayanschool.katyayanschool', 50, 0, 121, 'Slider 2', '', 100, '2e5a09673bb7aa5d8fc9363bc8bbe561.jpg', '', 1, 0, '', '', NULL, '2022-02-16 05:16:38'),
('com.katyayanschool.katyayanschool', 51, 0, 121, 'dfg', '', 100, NULL, '', 1, 0, '', '', NULL, '2022-02-16 10:33:07'),
('com.katyayanschool.katyayanschool', 52, 0, 122, 'Mathematics 1st', '', 101, NULL, '', 1, 0, '', '', NULL, '2022-02-16 11:56:04'),
('com.katyayanschool.katyayanschool', 53, 0, 122, 'Mathematics 2nd', '', 101, NULL, '', 1, 0, '', '', NULL, '2022-02-16 11:56:16'),
('com.katyayanschool.katyayanschool', 54, 0, 122, 'Chemistry 1', '', 101, NULL, '', 1, 0, '', '', NULL, '2022-02-16 14:29:53'),
('com.katyayanschool.katyayanschool', 55, 0, 122, 'Chemistry 2', '', 101, NULL, '', 1, 0, '', '', NULL, '2022-02-16 14:30:15');

-- --------------------------------------------------------

--
-- Table structure for table `table_content_master`
--

CREATE TABLE `table_content_master` (
  `pkg_id` varchar(100) NOT NULL,
  `id` int(11) NOT NULL,
  `content_id` int(100) NOT NULL,
  `sub_cat_id` int(100) NOT NULL,
  `sub_cat_name` varchar(100) DEFAULT NULL,
  `visibility` int(100) DEFAULT 1,
  `ranking` int(100) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_content_master`
--

INSERT INTO `table_content_master` (`pkg_id`, `id`, `content_id`, `sub_cat_id`, `sub_cat_name`, `visibility`, `ranking`, `created_at`) VALUES
('com.appsfeature', 1, 39, 109, 'Mobile Shop', 1, 0, '2022-02-03 18:21:14'),
('com.appsfeature', 2, 40, 109, 'Mobile Shop', 1, 0, '2022-02-03 18:21:35'),
('com.appsfeature', 3, 41, 110, 'Cloth Shop', 1, 0, '2022-02-03 18:23:39'),
('com.appsfeature', 4, 42, 110, 'Cloth Shop', 1, 0, '2022-02-03 18:23:51'),
('com.appsfeature', 5, 43, 112, 'Laptops', 1, 0, '2022-02-03 19:24:25'),
('com.katyayanschool.katyayanschool', 6, 45, 116, 'Home Menu', 1, 0, '2022-02-14 09:33:34'),
('com.katyayanschool.katyayanschool', 7, 46, 116, 'Home Menu', 1, 0, '2022-02-14 09:33:59'),
('com.katyayanschool.katyayanschool', 8, 47, 116, 'Home Menu', 1, 0, '2022-02-14 09:37:13'),
('com.katyayanschool.katyayanschool', 9, 48, 116, 'Home Menu', 1, 0, '2022-02-14 09:37:55'),
('com.katyayanschool.katyayanschool', 10, 49, 121, 'Home Slider', 1, 0, '2022-02-14 11:02:33'),
('com.katyayanschool.katyayanschool', 11, 50, 121, 'Home Slider', 1, 0, '2022-02-16 05:16:38'),
('com.katyayanschool.katyayanschool', 12, 51, 121, 'Home Slider', 1, 0, '2022-02-16 10:33:07'),
('com.katyayanschool.katyayanschool', 13, 52, 122, 'PDF Books', 1, 0, '2022-02-16 11:56:04'),
('com.katyayanschool.katyayanschool', 14, 53, 122, 'PDF Books', 1, 0, '2022-02-16 11:56:16'),
('com.katyayanschool.katyayanschool', 15, 54, 122, 'PDF Books', 1, 0, '2022-02-16 14:29:53'),
('com.katyayanschool.katyayanschool', 16, 55, 122, 'PDF Books', 1, 0, '2022-02-16 14:30:15');

-- --------------------------------------------------------

--
-- Table structure for table `table_flavour`
--

CREATE TABLE `table_flavour` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `ranking` int(10) DEFAULT 0,
  `visibility` int(10) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_flavour`
--

INSERT INTO `table_flavour` (`id`, `title`, `ranking`, `visibility`) VALUES
(0, 'Category', 0, 1),
(1, 'Content', 0, 1),
(2, 'Json', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `table_item_type`
--

CREATE TABLE `table_item_type` (
  `pkg_id` varchar(100) NOT NULL,
  `id` int(11) NOT NULL,
  `flavour` int(100) DEFAULT 0,
  `item_type` int(100) NOT NULL,
  `title` varchar(500) NOT NULL,
  `ranking` int(10) DEFAULT 0,
  `visibility` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_item_type`
--

INSERT INTO `table_item_type` (`pkg_id`, `id`, `flavour`, `item_type`, `title`, `ranking`, `visibility`) VALUES
('common', 2, 0, 0, 'List', 0, 1),
('common', 3, 0, 1, 'Grid', 0, 1),
('common', 4, 0, 4, 'Horizontal Card Scroll', 0, 1),
('com.appsfeature.bizwiz', 5, 1, 2, 'Slider', 0, 1),
('common', 7, 0, 5, 'ViewPager Auto Slider', 0, 1),
('common', 8, 0, 7, 'List Card', 0, 1),
('common', 9, 0, 8, 'Grid Card', 0, 1),
('common', 10, 1, 101, 'PDF', 0, 1),
('common', 11, 1, 102, 'Link', 0, 1),
('common', 12, 1, 103, 'Html View', 0, 1),
('common', 13, 1, 104, 'Test', 0, 1),
('common', 14, 1, 105, 'Quiz', 0, 1),
('common', 15, 1, 106, 'Videos', 0, 1),
('com.appsfeature', 16, 1, 150, 'Browser', 0, 0),
('com.katyayanschool.katyayanschool', 19, 1, 107, 'Live Classes', 0, 1),
('com.katyayanschool.katyayanschool', 20, 1, 108, 'Profile', 0, 1),
('common', 21, 0, 3, 'Grid Horizontal', 0, 1),
('common', 22, 0, 6, 'ViewPager Auto Slider No Title', 0, 1),
('common', 23, 1, 100, 'No Action', 0, 1),
('common', 24, 0, 9, 'Title Only', 0, 1),
('common', 25, 0, 10, 'Title With Count', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `table_json`
--

CREATE TABLE `table_json` (
  `pkg_id` varchar(100) NOT NULL,
  `id` int(11) NOT NULL,
  `cat_id` int(100) DEFAULT 0,
  `json_data` text NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_json`
--

INSERT INTO `table_json` (`pkg_id`, `id`, `cat_id`, `json_data`, `updated_at`) VALUES
('com.appsfeature', 3, 113, 'ghj', '2022-02-11 17:10:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_account`
--
ALTER TABLE `table_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_app`
--
ALTER TABLE `table_app`
  ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `table_category`
--
ALTER TABLE `table_category`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_id` (`cat_id`);

--
-- Indexes for table `table_category_master`
--
ALTER TABLE `table_category_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_content`
--
ALTER TABLE `table_content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `table_content_master`
--
ALTER TABLE `table_content_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_flavour`
--
ALTER TABLE `table_flavour`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_item_type`
--
ALTER TABLE `table_item_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_json`
--
ALTER TABLE `table_json`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_account`
--
ALTER TABLE `table_account`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `table_app`
--
ALTER TABLE `table_app`
  MODIFY `app_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `table_category`
--
ALTER TABLE `table_category`
  MODIFY `cat_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `table_category_master`
--
ALTER TABLE `table_category_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `table_content`
--
ALTER TABLE `table_content`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `table_content_master`
--
ALTER TABLE `table_content_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `table_flavour`
--
ALTER TABLE `table_flavour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `table_item_type`
--
ALTER TABLE `table_item_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `table_json`
--
ALTER TABLE `table_json`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
