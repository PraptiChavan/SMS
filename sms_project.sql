-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2025 at 05:41 PM
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
-- Database: `sms_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `type`, `name`, `email`, `created_at`, `updated_at`, `password`) VALUES
(1, 'student', 'Student 1', 'student1@example.com', '2025-02-26 02:14:35', '2025-02-26 02:14:35', '$2y$10$8DUnUBhaFYqTB67HfpHT7.TJgULgQIIouF7gbK8e.rCeb/jGlzYHW'),
(2, 'parent', 'Father 1', 'father1@example.com', '2025-02-26 02:14:36', '2025-02-26 02:14:36', '$2y$10$sha5Ep0YoXm0zYezxFrVeuy6G.XCD2ckqspmihRGkm4ROu5J5VONu'),
(3, 'parent', 'Mother 1', 'mother1@example.com', '2025-02-26 02:14:36', '2025-02-26 02:14:36', '$2y$10$DjRypwYxxR.58k/WcBZwjeFUHd1xk7MC2LsavGmromdyb9NcTQope'),
(4, 'student', 'Student 2', 'student2@example.com', '2025-02-26 02:48:02', '2025-02-26 02:48:02', '$2y$12$kKTu0hNF/9jrIhujCLaYBuYvpGFEhmFwSF.ud9qWTHxOpiuL84/Ya'),
(5, 'teacher', 'Teacher 1', 'teacher1@example.com', '2025-02-26 05:25:46', '2025-02-26 05:25:46', '$2y$10$ymmCLhod0Sf/ExujtWqFLeR3bARvsYrgTgf6QTH5QkASXVqCwbDPi');

-- --------------------------------------------------------

--
-- Table structure for table `admitcards`
--

CREATE TABLE `admitcards` (
  `id` int(100) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `fees_paid` enum('Yes','No') NOT NULL,
  `admit_card` varchar(100) NOT NULL,
  `classes` varchar(100) NOT NULL,
  `sections` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admitcards`
--

INSERT INTO `admitcards` (`id`, `student_name`, `fees_paid`, `admit_card`, `classes`, `sections`, `created_at`, `updated_at`) VALUES
(1, 'Student 1', 'Yes', 'admitcards/admit_card_1741347986.pdf', '1', '1', '2025-03-07 06:16:27', '2025-03-07 06:16:27');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(100) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `status` enum('P','A') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `period_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `date`, `status`, `created_at`, `updated_at`, `period_id`) VALUES
(1, 1, '2025-02-01', 'P', '2025-02-27 01:36:54', '2025-02-27 01:36:54', 1),
(2, 1, '2025-02-02', 'A', '2025-02-27 01:36:54', '2025-02-27 01:36:54', 1),
(3, 1, '2025-02-03', 'P', '2025-02-27 01:36:54', '2025-02-27 01:36:54', 1),
(4, 1, '2025-02-04', 'P', '2025-02-27 01:36:54', '2025-02-27 01:36:54', 1),
(5, 1, '2025-02-05', 'P', '2025-02-27 01:36:54', '2025-02-27 01:36:54', 1),
(6, 1, '2025-02-06', 'P', '2025-02-27 01:36:54', '2025-02-27 01:36:54', 1),
(7, 1, '2025-02-07', 'P', '2025-02-27 01:36:54', '2025-02-27 01:36:54', 1),
(8, 1, '2025-02-08', 'P', '2025-02-27 01:36:54', '2025-02-27 01:36:54', 1),
(9, 1, '2025-02-09', 'A', '2025-02-27 01:36:54', '2025-02-27 01:36:54', 1),
(10, 1, '2025-02-10', 'P', '2025-02-27 01:36:54', '2025-02-27 01:36:54', 1),
(11, 1, '2025-02-11', 'P', '2025-02-27 01:36:54', '2025-02-27 01:36:54', 1),
(12, 1, '2025-02-12', 'P', '2025-02-27 01:36:54', '2025-02-27 01:36:54', 1),
(13, 1, '2025-02-13', 'P', '2025-02-27 01:36:55', '2025-02-27 01:36:55', 1),
(14, 1, '2025-02-14', 'P', '2025-02-27 01:36:55', '2025-02-27 01:36:55', 1),
(15, 1, '2025-02-15', 'P', '2025-02-27 01:36:55', '2025-02-27 01:36:55', 1),
(16, 1, '2025-02-16', 'A', '2025-02-27 01:36:55', '2025-02-27 01:36:55', 1),
(17, 1, '2025-02-17', 'P', '2025-02-27 01:36:55', '2025-02-27 01:36:55', 1),
(18, 1, '2025-02-18', 'P', '2025-02-27 01:36:55', '2025-02-27 01:36:55', 1),
(19, 1, '2025-02-19', 'P', '2025-02-27 01:36:55', '2025-02-27 01:36:55', 1),
(20, 1, '2025-02-20', 'P', '2025-02-27 01:36:55', '2025-02-27 01:36:55', 1),
(21, 1, '2025-02-21', 'P', '2025-02-27 01:36:55', '2025-02-27 01:36:55', 1),
(22, 1, '2025-02-22', 'P', '2025-02-27 01:36:55', '2025-02-27 01:36:55', 1),
(23, 1, '2025-02-24', 'P', '2025-02-27 01:36:55', '2025-02-27 01:36:55', 1),
(24, 1, '2025-02-25', 'P', '2025-02-27 01:36:55', '2025-02-27 01:36:55', 1),
(25, 1, '2025-02-23', 'A', '2025-02-27 01:36:55', '2025-02-27 01:36:55', 1),
(26, 1, '2025-02-26', 'P', '2025-02-27 01:36:55', '2025-02-27 01:36:55', 1),
(27, 1, '2025-02-27', 'P', '2025-02-27 01:36:55', '2025-02-27 01:36:55', 1),
(28, 1, '2025-02-28', 'P', '2025-02-27 01:36:55', '2025-02-27 01:36:55', 1),
(29, 1, '2025-02-01', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(30, 1, '2025-02-02', 'A', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(31, 1, '2025-02-03', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(32, 1, '2025-02-04', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(33, 1, '2025-02-05', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(34, 1, '2025-02-06', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(35, 1, '2025-02-07', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(36, 1, '2025-02-08', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(37, 1, '2025-02-09', 'A', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(38, 1, '2025-02-10', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(39, 1, '2025-02-11', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(40, 1, '2025-02-12', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(41, 1, '2025-02-13', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(42, 1, '2025-02-15', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(43, 1, '2025-02-14', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(44, 1, '2025-02-16', 'A', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(45, 1, '2025-02-17', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(46, 1, '2025-02-18', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(47, 1, '2025-02-19', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(48, 1, '2025-02-20', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(49, 1, '2025-02-21', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(50, 1, '2025-02-22', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(51, 1, '2025-02-23', 'A', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(52, 1, '2025-02-24', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(53, 1, '2025-02-25', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(54, 1, '2025-02-26', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(55, 1, '2025-02-27', 'P', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(56, 1, '2025-02-28', 'A', '2025-02-27 01:37:37', '2025-02-27 01:37:37', 2),
(57, 4, '2025-02-01', 'P', '2025-02-27 01:38:23', '2025-02-27 01:38:23', 1),
(58, 4, '2025-02-02', 'A', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(59, 4, '2025-02-03', 'A', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(60, 4, '2025-02-04', 'A', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(61, 4, '2025-02-05', 'A', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(62, 4, '2025-02-06', 'A', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(63, 4, '2025-02-07', 'A', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(64, 4, '2025-02-08', 'P', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(65, 4, '2025-02-09', 'A', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(66, 4, '2025-02-10', 'P', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(67, 4, '2025-02-11', 'P', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(68, 4, '2025-02-12', 'P', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(69, 4, '2025-02-13', 'P', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(70, 4, '2025-02-14', 'P', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(71, 4, '2025-02-15', 'P', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(72, 4, '2025-02-16', 'A', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(73, 4, '2025-02-17', 'P', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(74, 4, '2025-02-18', 'P', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(75, 4, '2025-02-19', 'P', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(76, 4, '2025-02-20', 'P', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(77, 4, '2025-02-21', 'P', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(78, 4, '2025-02-22', 'P', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(79, 4, '2025-02-23', 'A', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(80, 4, '2025-02-24', 'P', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(81, 4, '2025-02-25', 'A', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(82, 4, '2025-02-26', 'A', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(83, 4, '2025-02-27', 'A', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(84, 4, '2025-02-28', 'A', '2025-02-27 01:38:24', '2025-02-27 01:38:24', 1),
(85, 4, '2025-02-01', 'A', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(86, 4, '2025-02-02', 'A', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(87, 4, '2025-02-03', 'A', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(88, 4, '2025-02-04', 'A', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(89, 4, '2025-02-05', 'A', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(90, 4, '2025-02-06', 'P', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(91, 4, '2025-02-07', 'P', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(92, 4, '2025-02-08', 'P', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(93, 4, '2025-02-09', 'P', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(94, 4, '2025-02-10', 'P', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(95, 4, '2025-02-11', 'P', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(96, 4, '2025-02-12', 'A', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(97, 4, '2025-02-13', 'A', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(98, 4, '2025-02-14', 'A', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(99, 4, '2025-02-15', 'A', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(100, 4, '2025-02-16', 'A', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(101, 4, '2025-02-17', 'P', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(102, 4, '2025-02-18', 'P', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(103, 4, '2025-02-19', 'P', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(104, 4, '2025-02-20', 'P', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(105, 4, '2025-02-21', 'P', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(106, 4, '2025-02-22', 'P', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(107, 4, '2025-02-23', 'P', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(108, 4, '2025-02-24', 'P', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(109, 4, '2025-02-25', 'P', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(110, 4, '2025-02-26', 'A', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(111, 4, '2025-02-27', 'A', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2),
(112, 4, '2025-02-28', 'A', '2025-02-27 01:38:54', '2025-02-27 01:38:54', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sections` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `title`, `created_at`, `updated_at`, `sections`) VALUES
(1, 'Class-1', '2025-01-30 11:24:24', '2025-01-30 11:24:24', '1, 2'),
(2, 'Class-2', '2025-01-30 11:30:37', '2025-01-30 11:31:01', '1, 2'),
(3, 'Class-4', '2025-01-31 03:30:21', '2025-03-03 03:44:08', '2');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `date` date NOT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `category`, `duration`, `date`, `image`) VALUES
(1, 'Web Designing', 'web-design-and-development', '7 hrs', '2025-03-03', 'courses/fIjh6Td14Ooj0Pw5vrAjYUwTvsoYErdvqkIzaD6A.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `month` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `date`, `month`) VALUES
(1, 'Science Fair', 'Annual school science fair', '2025-04-10', 'April'),
(2, 'Sports Day', 'Athletics and games', '2025-05-15', 'May'),
(3, 'Art Exhibition', 'Student art showcase', '2025-06-05', 'June'),
(4, 'Music Concert', 'School band and choir performance', '2025-07-20', 'July'),
(5, 'Coding Hackathon', '24-hour coding competition', '2025-08-12', 'August'),
(6, 'Teacher\'s Day', 'Celebration honoring teachers', '2025-09-05', 'September'),
(7, 'Sports Meet Finals', 'Final sports event championship', '2025-10-18', 'October'),
(8, 'Diwali Celebration', 'Festival of lights event', '2025-11-03', 'November'),
(9, 'Christmas Carnival', 'Christmas fun fair and activities', '2025-12-20', 'December'),
(10, 'New Year Bash', 'Welcome the new year event', '2026-01-01', 'January'),
(11, 'Annual Day', 'School\'s annual celebration', '2026-02-15', 'February'),
(12, 'Art & Craft Expo', 'Showcase of student creativity', '2026-03-08', 'March');

-- --------------------------------------------------------

--
-- Table structure for table `examform`
--

CREATE TABLE `examform` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `classes` varchar(100) NOT NULL,
  `subjects` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `total_marks` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examform`
--

INSERT INTO `examform` (`id`, `name`, `classes`, `subjects`, `date`, `start_time`, `end_time`, `total_marks`, `created_at`, `updated_at`) VALUES
(1, 'Class1-Half Yearly Exam', '1', '1', '2025-03-24', '09:30:00', '11:30:00', '60', '2025-02-28 05:51:38', '2025-02-28 07:10:22'),
(3, 'Class1-Half Yearly Exam', '1', '2', '2025-03-25', '09:30:00', '11:30:00', '60', '2025-03-12 00:03:24', '2025-03-12 00:03:24'),
(4, 'Class1-Final Exam', '1', '1', '2025-05-01', '11:30:00', '14:30:00', '100', '2025-03-12 00:42:58', '2025-03-12 00:42:58'),
(5, 'Class2-Final Exam', '2', '1', '2025-04-30', '09:30:00', '12:30:00', '100', '2025-03-12 04:22:57', '2025-03-12 04:22:57');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(5, '2025_01_09_103248_create_courses_table', 3),
(9, '2025_01_11_055920_add_timestamps_to_classes_table', 6),
(10, '2025_01_11_060127_add_timestamps_to_classes_table', 6),
(18, '2025_01_09_065006_create_accounts_table', 7),
(19, '2025_01_09_175329_create_sections_table', 7),
(20, '2025_01_09_180028_create_classes_table', 7),
(21, '2025_01_10_130449_add_timestamps_to_sections_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `parents_meetings`
--

CREATE TABLE `parents_meetings` (
  `id` int(100) NOT NULL,
  `teacher_id` bigint(20) NOT NULL,
  `class_id` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `mode` enum('Online','Offline','','') NOT NULL,
  `agenda` text NOT NULL,
  `status` enum('Pending','Accepted','Declined','Rescheduled') NOT NULL,
  `meeting_link` varchar(100) NOT NULL,
  `status_updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parents_meetings`
--

INSERT INTO `parents_meetings` (`id`, `teacher_id`, `class_id`, `date`, `time`, `mode`, `agenda`, `status`, `meeting_link`, `status_updated_by`, `created_at`, `updated_at`) VALUES
(1, 5, 1, '2025-03-31', '10:37:00', 'Online', 'PTM', 'Pending', 'https://meet.example.com/default', 3, '2025-03-27 23:37:34', '2025-03-28 00:12:08');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `periods`
--

CREATE TABLE `periods` (
  `id` int(100) NOT NULL,
  `title` text NOT NULL,
  `from` time NOT NULL,
  `to` time NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `periods`
--

INSERT INTO `periods` (`id`, `title`, `from`, `to`, `updated_at`, `created_at`) VALUES
(1, 'First Period', '07:00:00', '07:45:00', '2025-03-03 12:37:07', '2025-02-03 01:50:11'),
(2, 'Second Period', '07:45:00', '08:30:00', '2025-02-03 01:51:06', '2025-02-03 01:51:06'),
(3, 'Third Period', '08:30:00', '09:15:00', '2025-02-03 01:51:47', '2025-02-03 01:51:47'),
(4, 'Fourth Period', '09:15:00', '10:00:00', '2025-02-03 01:52:22', '2025-02-03 01:52:22'),
(5, 'Lunch Break', '10:00:00', '10:30:00', '2025-02-03 01:53:15', '2025-02-03 01:53:15'),
(6, 'Fifth Period', '10:30:00', '11:15:00', '2025-02-03 01:54:08', '2025-02-03 01:54:08'),
(7, 'Sixth Period', '11:15:00', '12:00:00', '2025-02-03 01:54:40', '2025-02-03 01:54:40'),
(8, 'Seventh Period', '12:00:00', '12:45:00', '2025-02-03 01:55:05', '2025-02-03 01:55:05'),
(9, 'Eighth Period', '12:45:00', '13:30:00', '2025-02-03 01:55:41', '2025-02-03 01:55:41');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(100) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `classes` varchar(100) NOT NULL,
  `sections` varchar(100) NOT NULL,
  `subjects` varchar(100) NOT NULL,
  `exam_name` varchar(100) NOT NULL,
  `total_marks` varchar(100) NOT NULL,
  `obtained_marks` varchar(100) NOT NULL,
  `percentage` varchar(100) NOT NULL,
  `grade` varchar(100) NOT NULL,
  `results` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `student_name`, `classes`, `sections`, `subjects`, `exam_name`, `total_marks`, `obtained_marks`, `percentage`, `grade`, `results`, `created_at`, `updated_at`) VALUES
(1, 'Student 1', '1', '1', 'Science,English', '1', '60,60', '55,40', '91.67,66.67', 'A+,C', 'results/result_1.pdf', '2025-03-13 09:08:04', '2025-03-20 03:59:44');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Section A', '2025-01-31 06:03:35', '2025-01-31 06:03:35'),
(2, 'Section B', '2025-01-31 06:04:25', '2025-02-28 07:30:13');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('SkMHK622kJJmWKHCCSLMBD52NAFxZnIrj7uDcd4x', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiS1RnMmp4WWdqSVVkVXFXZHZIbXVVa3ZFUDRDN2ZlNGRoQUNLNzBpWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC91c2VyLWFjY291bnRzL2xpYnJhcmlhbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NToibG9naW4iO2I6MTtzOjk6InVzZXJfdHlwZSI7czo1OiJhZG1pbiI7czo3OiJ1c2VyX2lkIjtpOjE7fQ==', 1743155484),
('tM05CJCjP8OQzH0dw9XZYa6NQn7sMnFzetNQukOQ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV2thYjRSRGxzRzBpZnZOVWg1YnZYNUVKZzFrUHNXUkY4aHBoVkVoZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1743155226);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `father_name` varchar(100) NOT NULL,
  `father_mobile` varchar(100) NOT NULL,
  `father_email` varchar(100) NOT NULL,
  `mother_name` varchar(100) NOT NULL,
  `mother_mobile` varchar(100) NOT NULL,
  `mother_email` varchar(100) NOT NULL,
  `parents_address` varchar(100) NOT NULL,
  `parents_country` varchar(100) NOT NULL,
  `parents_state` varchar(100) NOT NULL,
  `parents_zip` varchar(100) NOT NULL,
  `school_name` varchar(100) NOT NULL,
  `previous_class` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `total_marks` varchar(100) NOT NULL,
  `obtain_marks` varchar(100) NOT NULL,
  `previous_percentage` decimal(5,2) DEFAULT NULL,
  `classes` varchar(100) NOT NULL,
  `sections` varchar(100) NOT NULL,
  `stream` varchar(100) NOT NULL,
  `doa` date NOT NULL,
  `payment_method` enum('Online','Offline') NOT NULL,
  `receipt_number` varchar(100) NOT NULL,
  `registration_fee` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `dob`, `mobile`, `email`, `address`, `country`, `state`, `zip`, `created_at`, `updated_at`, `father_name`, `father_mobile`, `father_email`, `mother_name`, `mother_mobile`, `mother_email`, `parents_address`, `parents_country`, `parents_state`, `parents_zip`, `school_name`, `previous_class`, `status`, `total_marks`, `obtain_marks`, `previous_percentage`, `classes`, `sections`, `stream`, `doa`, `payment_method`, `receipt_number`, `registration_fee`) VALUES
(1, 'Student 1', '2025-02-01', '6351145456', 'student1@example.com', 'Siddharth Park,Vadodara', 'India', 'Gujarat', '390022', '2025-02-26 02:14:36', '2025-02-26 02:14:36', 'Father 1', '6351145456', 'father1@example.com', 'Mother 1', '6351145456', 'mother1@example.com', 'Siddharth Park,Vadodara', 'India', 'Gujarat', '390022', 'Convent of Jesus and Mary Girls\' High School', '1', 'passed', '600', '515', 85.83, '1', '1', 'None', '2025-02-26', 'Offline', '27821248', '500'),
(4, 'Student 2', '2025-01-01', '6351145456', 'student2@example.com', 'Siddharth Park,Vadodara', 'India', 'Gujarat', '390022', '2025-02-26 02:48:02', '2025-02-27 00:43:03', 'Father 1', '6351145456', 'father1@example.com', 'Mother 1', '6351145456', 'mother1@example.com', 'Siddharth Park,Vadodara', 'India', 'Gujarat', '390022', 'Convent of Jesus and Mary Girls\' High School', '1', 'passed', '600', '515', 85.83, '2', '2', 'None', '2025-02-26', 'Offline', '1234567890', '500');

-- --------------------------------------------------------

--
-- Table structure for table `studymaterials`
--

CREATE TABLE `studymaterials` (
  `id` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `attachment` varchar(100) NOT NULL,
  `classes` varchar(100) NOT NULL,
  `subjects` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studymaterials`
--

INSERT INTO `studymaterials` (`id`, `title`, `attachment`, `classes`, `subjects`, `date`, `created_at`, `updated_at`, `description`) VALUES
(1, 'MAD Assignment', 'studyMaterial/wR0kjwCMZfY4LoweigMJqZrZyWnTMycKMCrZfoPl.pdf', '1', '1', '2025-03-06', '2025-03-06 02:50:49', '2025-03-06 02:50:49', 'This is a MAD Assignment.');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(50) NOT NULL,
  `name` text NOT NULL,
  `classes` varchar(100) NOT NULL,
  `sections` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `classes`, `sections`, `created_at`, `updated_at`) VALUES
(1, 'Science', '1', '1,2', '2025-02-03 04:22:13', '2025-03-03 12:16:48'),
(2, 'English', '1', '1,2', '2025-02-03 04:44:50', '2025-02-03 04:45:05');

-- --------------------------------------------------------

--
-- Table structure for table `tattendance`
--

CREATE TABLE `tattendance` (
  `id` int(100) NOT NULL,
  `teacher_id` int(100) NOT NULL,
  `date` date NOT NULL,
  `status` enum('P','A') NOT NULL,
  `period_id` int(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tattendance`
--

INSERT INTO `tattendance` (`id`, `teacher_id`, `date`, `status`, `period_id`, `created_at`, `updated_at`) VALUES
(1, 5, '2025-02-01', 'P', 1, '2025-02-28 01:07:30', '2025-02-28 01:07:30'),
(2, 5, '2025-02-01', 'P', 2, '2025-02-28 01:07:30', '2025-02-28 01:07:30'),
(3, 5, '2025-02-01', 'P', 3, '2025-02-28 01:07:30', '2025-02-28 01:07:30'),
(4, 5, '2025-02-01', 'P', 4, '2025-02-28 01:07:30', '2025-02-28 01:07:30'),
(5, 5, '2025-02-01', 'P', 6, '2025-02-28 01:07:30', '2025-02-28 01:07:30'),
(6, 5, '2025-02-01', 'P', 7, '2025-02-28 01:07:30', '2025-02-28 01:07:30'),
(7, 5, '2025-02-01', 'P', 8, '2025-02-28 01:07:30', '2025-02-28 01:07:30'),
(8, 5, '2025-02-01', 'P', 9, '2025-02-28 01:07:30', '2025-02-28 01:07:30'),
(9, 5, '2025-02-02', 'A', 1, '2025-02-28 01:07:30', '2025-02-28 01:07:30'),
(10, 5, '2025-02-02', 'A', 2, '2025-02-28 01:07:30', '2025-02-28 01:07:30'),
(11, 5, '2025-02-02', 'A', 3, '2025-02-28 01:07:30', '2025-02-28 01:07:30'),
(12, 5, '2025-02-02', 'A', 4, '2025-02-28 01:07:30', '2025-02-28 01:07:30'),
(13, 5, '2025-02-02', 'A', 6, '2025-02-28 01:07:30', '2025-02-28 01:07:30'),
(14, 5, '2025-02-02', 'A', 7, '2025-02-28 01:07:30', '2025-02-28 01:07:30'),
(15, 5, '2025-02-02', 'A', 8, '2025-02-28 01:07:30', '2025-02-28 01:07:30'),
(16, 5, '2025-02-02', 'A', 9, '2025-02-28 01:07:30', '2025-02-28 01:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `time`
--

CREATE TABLE `time` (
  `id` int(100) NOT NULL,
  `classes` varchar(100) NOT NULL,
  `sections` varchar(100) NOT NULL,
  `periods` varchar(100) NOT NULL,
  `subjects` varchar(100) NOT NULL,
  `teachers` varchar(100) NOT NULL,
  `weekdays` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time`
--

INSERT INTO `time` (`id`, `classes`, `sections`, `periods`, `subjects`, `teachers`, `weekdays`, `created_at`, `updated_at`) VALUES
(1, '1', '1', '1', '1', '5', '4', '2025-02-26 05:26:21', '2025-03-05 23:57:27'),
(2, '1', '1', '2', '2', '5', '2', '2025-02-26 05:26:42', '2025-02-26 05:26:42'),
(3, '2', '2', '1', '1', '5', '3', '2025-02-26 23:41:21', '2025-02-26 23:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `weekdays`
--

CREATE TABLE `weekdays` (
  `id` int(100) NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weekdays`
--

INSERT INTO `weekdays` (`id`, `title`) VALUES
(1, 'Monday'),
(2, 'Tuesday'),
(3, 'Wednesday'),
(4, 'Thursday'),
(5, 'Friday'),
(6, 'Saturday');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admitcards`
--
ALTER TABLE `admitcards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `examform`
--
ALTER TABLE `examform`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents_meetings`
--
ALTER TABLE `parents_meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `periods`
--
ALTER TABLE `periods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `studymaterials`
--
ALTER TABLE `studymaterials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tattendance`
--
ALTER TABLE `tattendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time`
--
ALTER TABLE `time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `weekdays`
--
ALTER TABLE `weekdays`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `admitcards`
--
ALTER TABLE `admitcards`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `examform`
--
ALTER TABLE `examform`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `parents_meetings`
--
ALTER TABLE `parents_meetings`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `periods`
--
ALTER TABLE `periods`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `studymaterials`
--
ALTER TABLE `studymaterials`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tattendance`
--
ALTER TABLE `tattendance`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `time`
--
ALTER TABLE `time`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weekdays`
--
ALTER TABLE `weekdays`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
