-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2020 at 09:10 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `neub_rps`
--

-- --------------------------------------------------------

--
-- Table structure for table `nr_admin`
--

CREATE TABLE `nr_admin` (
  `nr_admin_id` bigint(20) NOT NULL,
  `nr_admin_name` varchar(100) NOT NULL,
  `nr_admin_email` varchar(60) NOT NULL,
  `nr_admin_password` varchar(60) NOT NULL,
  `nr_admin_cell_no` varchar(20) NOT NULL,
  `nr_admin_photo` varchar(60) NOT NULL,
  `nr_admin_type` enum('Moderator','Admin') NOT NULL,
  `nr_admin_designation` varchar(50) NOT NULL,
  `nr_admin_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_admin`
--

INSERT INTO `nr_admin` (`nr_admin_id`, `nr_admin_name`, `nr_admin_email`, `nr_admin_password`, `nr_admin_cell_no`, `nr_admin_photo`, `nr_admin_type`, `nr_admin_designation`, `nr_admin_status`) VALUES
(1, 'Shams Elahi Rasel', 'ser@gmail.com', '', '', '', 'Admin', 'Controller of Examination, NEUB', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_course`
--

CREATE TABLE `nr_course` (
  `nr_course_id` bigint(20) NOT NULL,
  `nr_course_code` varchar(20) NOT NULL,
  `nr_course_title` varchar(100) NOT NULL,
  `nr_course_credit` float NOT NULL,
  `nr_prog_id` bigint(20) NOT NULL,
  `nr_course_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_course`
--

INSERT INTO `nr_course` (`nr_course_id`, `nr_course_code`, `nr_course_title`, `nr_course_credit`, `nr_prog_id`, `nr_course_status`) VALUES
(1, 'CSE 111', 'Fundamentals of Computers', 3, 1, 'Active'),
(2, 'CSE 113', 'Structured Programming Language', 3, 1, 'Active'),
(3, 'CSE 114', 'Structured Programming Language Lab', 1.5, 1, 'Active'),
(4, 'CSE 311', 'Computer Architecture', 3, 1, 'Active'),
(5, 'CSE 313', 'Database System', 3, 1, 'Active'),
(6, 'CSE 314', 'Database System Lab', 1.5, 1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_department`
--

CREATE TABLE `nr_department` (
  `nr_dept_id` bigint(20) NOT NULL,
  `nr_dept_title` varchar(100) NOT NULL,
  `nr_dept_code` bigint(20) NOT NULL,
  `nr_dept_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_department`
--

INSERT INTO `nr_department` (`nr_dept_id`, `nr_dept_title`, `nr_dept_code`, `nr_dept_status`) VALUES
(1, 'Computer Science & Engineering', 3, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_faculty`
--

CREATE TABLE `nr_faculty` (
  `nr_faculty_id` bigint(20) NOT NULL,
  `nr_faculty_name` varchar(100) NOT NULL,
  `nr_faculty_designation` varchar(150) NOT NULL,
  `nr_faculty_join_date` varchar(20) NOT NULL,
  `nr_faculty_resign_date` varchar(20) NOT NULL,
  `nr_faculty_type` enum('Permanent','Guest','Adjunct') NOT NULL,
  `nr_dept_id` bigint(20) NOT NULL,
  `nr_faculty_password` varchar(100) NOT NULL,
  `nr_faculty_email` varchar(100) NOT NULL,
  `nr_faculty_cell_no` varchar(20) NOT NULL,
  `nr_faculty_photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_faculty`
--

INSERT INTO `nr_faculty` (`nr_faculty_id`, `nr_faculty_name`, `nr_faculty_designation`, `nr_faculty_join_date`, `nr_faculty_resign_date`, `nr_faculty_type`, `nr_dept_id`, `nr_faculty_password`, `nr_faculty_email`, `nr_faculty_cell_no`, `nr_faculty_photo`) VALUES
(1, 'Noushad Sojib', 'Assistant Professor', '2016-04-20', '', 'Permanent', 1, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `nr_program`
--

CREATE TABLE `nr_program` (
  `nr_prog_id` bigint(20) NOT NULL,
  `nr_prog_title` varchar(100) NOT NULL,
  `nr_prog_code` bigint(20) NOT NULL,
  `nr_dept_id` bigint(20) NOT NULL,
  `nr_prog_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_program`
--

INSERT INTO `nr_program` (`nr_prog_id`, `nr_prog_title`, `nr_prog_code`, `nr_dept_id`, `nr_prog_status`) VALUES
(1, 'B.Sc. (Engg.) in CSE', 2, 1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_program_credit`
--

CREATE TABLE `nr_program_credit` (
  `nr_prcr_id` bigint(20) NOT NULL,
  `nr_prog_id` bigint(20) NOT NULL,
  `nr_prcr_total` float NOT NULL,
  `nr_prcr_date` varchar(20) NOT NULL,
  `nr_prcr_ex_date` varchar(20) NOT NULL,
  `nr_prcr_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_program_credit`
--

INSERT INTO `nr_program_credit` (`nr_prcr_id`, `nr_prog_id`, `nr_prcr_total`, `nr_prcr_date`, `nr_prcr_ex_date`, `nr_prcr_status`) VALUES
(1, 1, 160, '2012-01-01', '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_result`
--

CREATE TABLE `nr_result` (
  `nr_result_id` bigint(20) NOT NULL,
  `nr_stud_id` bigint(20) NOT NULL,
  `nr_course_id` bigint(20) NOT NULL,
  `nr_result_marks` double NOT NULL,
  `nr_result_grade` varchar(200) NOT NULL,
  `nr_result_grade_point` double NOT NULL,
  `nr_result_semester` enum('Spring','Summer','Fall') NOT NULL,
  `nr_result_year` year(4) NOT NULL,
  `nr_result_remarks` enum('Incomplete','Expelled','Makeup_MS','Makeup_SF','Makeup_MS_SF','Withdraw') NOT NULL,
  `nr_result_status` enum('Active','Inactive') NOT NULL,
  `nr_prog_id` bigint(20) NOT NULL,
  `nr_result_publish_date` varchar(100) NOT NULL,
  `nr_faculty_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_result`
--

INSERT INTO `nr_result` (`nr_result_id`, `nr_stud_id`, `nr_course_id`, `nr_result_marks`, `nr_result_grade`, `nr_result_grade_point`, `nr_result_semester`, `nr_result_year`, `nr_result_remarks`, `nr_result_status`, `nr_prog_id`, `nr_result_publish_date`, `nr_faculty_id`) VALUES
(1, 140203020002, 3, 140203029312.5, '89f276cc01d4af01fa8cee48af8ee962bac42500', 140203026062.5, 'Spring', 2015, '', 'Active', 1, '2020-01-27', 1),
(2, 140203020002, 4, 140203029812.5, '500910d02d287a8c898c406ea348043c050d31ca', 140203026312.5, 'Spring', 2015, '', 'Active', 1, '2020-01-27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nr_result_check_transaction`
--

CREATE TABLE `nr_result_check_transaction` (
  `nr_stud_id` bigint(20) NOT NULL,
  `nr_rechtr_ip_address` varchar(20) NOT NULL,
  `nr_rechtr_country` varchar(50) NOT NULL,
  `nr_rechtr_city` varchar(50) NOT NULL,
  `nr_rechtr_lat` varchar(100) NOT NULL,
  `nr_rechtr_lng` varchar(100) NOT NULL,
  `nr_rechtr_timezone` varchar(100) NOT NULL,
  `nr_rechtr_date` varchar(100) NOT NULL,
  `nr_rechtr_time` varchar(100) NOT NULL,
  `nr_rechtr_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_result_check_transaction`
--

INSERT INTO `nr_result_check_transaction` (`nr_stud_id`, `nr_rechtr_ip_address`, `nr_rechtr_country`, `nr_rechtr_city`, `nr_rechtr_lat`, `nr_rechtr_lng`, `nr_rechtr_timezone`, `nr_rechtr_date`, `nr_rechtr_time`, `nr_rechtr_status`) VALUES
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '05:11 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '05:11 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '05:12 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '05:16 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '05:17 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '05:18 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '05:29 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '05:31 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '05:33 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '05:34 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '05:36 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '05:38 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '05:47 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '05:49 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '06:16 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '06:47 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '06:47 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:19 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:21 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:22 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:23 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:26 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:27 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:28 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:33 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:36 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:36 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:38 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:39 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:41 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:44 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:45 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:46 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:53 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:54 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:54 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:55 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:56 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:56 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:57 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:57 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '07:58 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:00 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:00 PM', 'Active'),
(140203020002, '192.168.0.101', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:01 PM', 'Active'),
(140203020002, '192.168.0.101', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:01 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:07 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:08 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:09 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:09 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:10 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:10 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:11 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:11 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:12 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:12 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:13 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:13 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:14 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:14 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:14 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:14 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:15 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:15 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:15 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:16 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:16 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:18 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:19 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:19 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:20 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:20 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:21 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:21 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:23 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:24 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:25 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:25 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:25 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:26 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:26 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:26 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:26 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:27 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:27 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:27 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:27 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:28 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:31 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:31 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:39 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:40 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:45 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:46 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:46 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:47 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:47 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:47 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:48 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:48 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:49 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:49 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:50 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:51 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:55 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:55 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:56 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:56 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:57 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:57 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:57 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '08:58 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '09:05 PM', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_student`
--

CREATE TABLE `nr_student` (
  `nr_stud_id` bigint(20) NOT NULL,
  `nr_stud_name` varchar(100) NOT NULL,
  `nr_stud_dob` varchar(20) NOT NULL,
  `nr_stud_gender` enum('Male','Female','Other') NOT NULL,
  `nr_stud_email` varchar(60) NOT NULL,
  `nr_stud_cell_no` varchar(20) NOT NULL,
  `nr_stud_photo` varchar(60) NOT NULL,
  `nr_prog_id` bigint(20) NOT NULL,
  `nr_prcr_id` bigint(20) NOT NULL,
  `nr_stud_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_student`
--

INSERT INTO `nr_student` (`nr_stud_id`, `nr_stud_name`, `nr_stud_dob`, `nr_stud_gender`, `nr_stud_email`, `nr_stud_cell_no`, `nr_stud_photo`, `nr_prog_id`, `nr_prcr_id`, `nr_stud_status`) VALUES
(140203020002, 'Mir Lutfur Rahman', '1996-07-02', 'Male', 'mlrahman@gmail.com', '', '', 1, 1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_student_waived_credit`
--

CREATE TABLE `nr_student_waived_credit` (
  `nr_stwacr_id` bigint(20) NOT NULL,
  `nr_stud_id` bigint(20) NOT NULL,
  `nr_course_id` bigint(20) NOT NULL,
  `nr_stwacr_date` varchar(20) NOT NULL,
  `nr_stwacr_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_student_waived_credit`
--

INSERT INTO `nr_student_waived_credit` (`nr_stwacr_id`, `nr_stud_id`, `nr_course_id`, `nr_stwacr_date`, `nr_stwacr_status`) VALUES
(1, 140203020002, 1, '2020-01-26', 'Active'),
(2, 140203020002, 2, '2020-01-26', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_system_component`
--

CREATE TABLE `nr_system_component` (
  `nr_syco_id` bigint(20) NOT NULL,
  `nr_admin_id` bigint(20) NOT NULL,
  `nr_syco_title` varchar(50) NOT NULL,
  `nr_syco_caption` varchar(50) NOT NULL,
  `nr_syco_address` varchar(150) NOT NULL,
  `nr_syco_tel` varchar(20) NOT NULL,
  `nr_syco_email` varchar(50) NOT NULL,
  `nr_syco_mobile` varchar(50) NOT NULL,
  `nr_syco_web` varchar(50) NOT NULL,
  `nr_syco_contact_email` varchar(50) NOT NULL,
  `nr_syco_map_link` varchar(200) NOT NULL,
  `nr_syco_date` varchar(20) NOT NULL,
  `nr_syco_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_system_component`
--

INSERT INTO `nr_system_component` (`nr_syco_id`, `nr_admin_id`, `nr_syco_title`, `nr_syco_caption`, `nr_syco_address`, `nr_syco_tel`, `nr_syco_email`, `nr_syco_mobile`, `nr_syco_web`, `nr_syco_contact_email`, `nr_syco_map_link`, `nr_syco_date`, `nr_syco_status`) VALUES
(1, 1, 'NEUB Result Portal', 'Permanent Campus', 'Telihaor, Sheikhghat, Sylhet-3100', '0821 710221-2', 'info@neub.edu.bd', '01755566994', 'www.neub.edu.bd', 'result@neub.edu.bd', 'https://maps.google.com/maps?q=north%20east%20university%20bangladesh&t=&z=15&ie=UTF8&iwloc=&output=embed', '2020-01-25', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nr_admin`
--
ALTER TABLE `nr_admin`
  ADD PRIMARY KEY (`nr_admin_id`);

--
-- Indexes for table `nr_course`
--
ALTER TABLE `nr_course`
  ADD PRIMARY KEY (`nr_course_id`),
  ADD KEY `nr_prog_id` (`nr_prog_id`);

--
-- Indexes for table `nr_department`
--
ALTER TABLE `nr_department`
  ADD PRIMARY KEY (`nr_dept_id`);

--
-- Indexes for table `nr_faculty`
--
ALTER TABLE `nr_faculty`
  ADD PRIMARY KEY (`nr_faculty_id`),
  ADD KEY `nr_dept_id` (`nr_dept_id`);

--
-- Indexes for table `nr_program`
--
ALTER TABLE `nr_program`
  ADD PRIMARY KEY (`nr_prog_id`),
  ADD KEY `nr_dept_id` (`nr_dept_id`);

--
-- Indexes for table `nr_program_credit`
--
ALTER TABLE `nr_program_credit`
  ADD PRIMARY KEY (`nr_prcr_id`),
  ADD KEY `nr_prog_id` (`nr_prog_id`);

--
-- Indexes for table `nr_result`
--
ALTER TABLE `nr_result`
  ADD PRIMARY KEY (`nr_result_id`),
  ADD KEY `nr_stud_id` (`nr_stud_id`),
  ADD KEY `nr_prog_id` (`nr_prog_id`),
  ADD KEY `nr_course_id` (`nr_course_id`),
  ADD KEY `nr_faculty_id` (`nr_faculty_id`);

--
-- Indexes for table `nr_result_check_transaction`
--
ALTER TABLE `nr_result_check_transaction`
  ADD KEY `nr_stud_id` (`nr_stud_id`);

--
-- Indexes for table `nr_student`
--
ALTER TABLE `nr_student`
  ADD PRIMARY KEY (`nr_stud_id`),
  ADD KEY `nr_prog_id` (`nr_prog_id`),
  ADD KEY `nr_prcr_id` (`nr_prcr_id`);

--
-- Indexes for table `nr_student_waived_credit`
--
ALTER TABLE `nr_student_waived_credit`
  ADD PRIMARY KEY (`nr_stwacr_id`),
  ADD KEY `nr_stud_id` (`nr_stud_id`),
  ADD KEY `nr_course_id` (`nr_course_id`);

--
-- Indexes for table `nr_system_component`
--
ALTER TABLE `nr_system_component`
  ADD PRIMARY KEY (`nr_syco_id`),
  ADD KEY `nr_admin_id` (`nr_admin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nr_admin`
--
ALTER TABLE `nr_admin`
  MODIFY `nr_admin_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nr_course`
--
ALTER TABLE `nr_course`
  MODIFY `nr_course_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nr_department`
--
ALTER TABLE `nr_department`
  MODIFY `nr_dept_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nr_faculty`
--
ALTER TABLE `nr_faculty`
  MODIFY `nr_faculty_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nr_program`
--
ALTER TABLE `nr_program`
  MODIFY `nr_prog_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nr_program_credit`
--
ALTER TABLE `nr_program_credit`
  MODIFY `nr_prcr_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nr_result`
--
ALTER TABLE `nr_result`
  MODIFY `nr_result_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nr_student_waived_credit`
--
ALTER TABLE `nr_student_waived_credit`
  MODIFY `nr_stwacr_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nr_system_component`
--
ALTER TABLE `nr_system_component`
  MODIFY `nr_syco_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nr_course`
--
ALTER TABLE `nr_course`
  ADD CONSTRAINT `nr_course_ibfk_1` FOREIGN KEY (`nr_prog_id`) REFERENCES `nr_program` (`nr_prog_id`);

--
-- Constraints for table `nr_faculty`
--
ALTER TABLE `nr_faculty`
  ADD CONSTRAINT `nr_faculty_ibfk_1` FOREIGN KEY (`nr_dept_id`) REFERENCES `nr_department` (`nr_dept_id`);

--
-- Constraints for table `nr_program`
--
ALTER TABLE `nr_program`
  ADD CONSTRAINT `nr_program_ibfk_1` FOREIGN KEY (`nr_dept_id`) REFERENCES `nr_department` (`nr_dept_id`);

--
-- Constraints for table `nr_program_credit`
--
ALTER TABLE `nr_program_credit`
  ADD CONSTRAINT `nr_program_credit_ibfk_1` FOREIGN KEY (`nr_prog_id`) REFERENCES `nr_program` (`nr_prog_id`);

--
-- Constraints for table `nr_result`
--
ALTER TABLE `nr_result`
  ADD CONSTRAINT `nr_result_ibfk_1` FOREIGN KEY (`nr_stud_id`) REFERENCES `nr_student` (`nr_stud_id`),
  ADD CONSTRAINT `nr_result_ibfk_3` FOREIGN KEY (`nr_prog_id`) REFERENCES `nr_program` (`nr_prog_id`),
  ADD CONSTRAINT `nr_result_ibfk_4` FOREIGN KEY (`nr_course_id`) REFERENCES `nr_course` (`nr_course_id`),
  ADD CONSTRAINT `nr_result_ibfk_5` FOREIGN KEY (`nr_faculty_id`) REFERENCES `nr_faculty` (`nr_faculty_id`);

--
-- Constraints for table `nr_result_check_transaction`
--
ALTER TABLE `nr_result_check_transaction`
  ADD CONSTRAINT `nr_result_check_transaction_ibfk_1` FOREIGN KEY (`nr_stud_id`) REFERENCES `nr_student` (`nr_stud_id`);

--
-- Constraints for table `nr_student`
--
ALTER TABLE `nr_student`
  ADD CONSTRAINT `nr_student_ibfk_1` FOREIGN KEY (`nr_prog_id`) REFERENCES `nr_program` (`nr_prog_id`),
  ADD CONSTRAINT `nr_student_ibfk_2` FOREIGN KEY (`nr_prcr_id`) REFERENCES `nr_program_credit` (`nr_prcr_id`);

--
-- Constraints for table `nr_student_waived_credit`
--
ALTER TABLE `nr_student_waived_credit`
  ADD CONSTRAINT `nr_student_waived_credit_ibfk_1` FOREIGN KEY (`nr_stud_id`) REFERENCES `nr_student` (`nr_stud_id`),
  ADD CONSTRAINT `nr_student_waived_credit_ibfk_2` FOREIGN KEY (`nr_course_id`) REFERENCES `nr_course` (`nr_course_id`);

--
-- Constraints for table `nr_system_component`
--
ALTER TABLE `nr_system_component`
  ADD CONSTRAINT `nr_system_component_ibfk_1` FOREIGN KEY (`nr_admin_id`) REFERENCES `nr_admin` (`nr_admin_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
