-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2020 at 02:01 PM
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
  `nr_admin_type` enum('Moderator','Admin','Super Admin') NOT NULL,
  `nr_admin_designation` varchar(50) NOT NULL,
  `nr_admin_status` enum('Active','Inactive') NOT NULL,
  `nr_admin_two_factor` int(11) NOT NULL,
  `nr_admin_resign_date` varchar(20) NOT NULL,
  `nr_admin_gender` enum('Male','Female','Other') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_admin`
--

INSERT INTO `nr_admin` (`nr_admin_id`, `nr_admin_name`, `nr_admin_email`, `nr_admin_password`, `nr_admin_cell_no`, `nr_admin_photo`, `nr_admin_type`, `nr_admin_designation`, `nr_admin_status`, `nr_admin_two_factor`, `nr_admin_resign_date`, `nr_admin_gender`) VALUES
(1, 'Shams Elahi Rasel', 'mirlutfur.rahman@gmail.com', 'rps95d71c0c3e667dcc7b3e0a5b8f368c3aceb6ef42rps', '', '', 'Super Admin', 'Controller of Examination, NEUB', 'Active', 0, '', 'Male'),
(2, 'Fahad Ahmed', 'mlrahman@neub.edu.bd', 'rps95d71c0c3e667dcc7b3e0a5b8f368c3aceb6ef42rps', '', '', 'Moderator', 'Assistant Controller of NEUB', 'Active', 0, '', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `nr_admin_link_token`
--

CREATE TABLE `nr_admin_link_token` (
  `nr_admin_id` bigint(20) NOT NULL,
  `nr_suadlito_token` varchar(100) NOT NULL,
  `nr_suadlito_type` enum('Two Factor','Forget Password') NOT NULL,
  `nr_suadlito_date` varchar(20) NOT NULL,
  `nr_suadlito_time` varchar(20) NOT NULL,
  `nr_suadlito_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Table structure for table `nr_admin_login_transaction`
--

CREATE TABLE `nr_admin_login_transaction` (
  `nr_admin_id` bigint(20) NOT NULL,
  `nr_suadlotr_ip_address` varchar(100) NOT NULL,
  `nr_suadlotr_country` varchar(50) NOT NULL,
  `nr_suadlotr_city` varchar(50) NOT NULL,
  `nr_suadlotr_lat` varchar(100) NOT NULL,
  `nr_suadlotr_lng` varchar(100) NOT NULL,
  `nr_suadlotr_timezone` varchar(100) NOT NULL,
  `nr_suadlotr_date` varchar(100) NOT NULL,
  `nr_suadlotr_time` varchar(100) NOT NULL,
  `nr_suadlotr_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_admin_login_transaction`
--

INSERT INTO `nr_admin_login_transaction` (`nr_admin_id`, `nr_suadlotr_ip_address`, `nr_suadlotr_country`, `nr_suadlotr_city`, `nr_suadlotr_lat`, `nr_suadlotr_lng`, `nr_suadlotr_timezone`, `nr_suadlotr_date`, `nr_suadlotr_time`, `nr_suadlotr_status`) VALUES
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-13', '06:42 PM', 'Active'),
(2, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:22 PM', 'Active'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:24 PM', 'Active'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '06:32 PM', 'Active'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '10:05 PM', 'Active'),
(1, '192.168.0.102', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '11:35 PM', 'Active'),
(2, '192.168.0.102', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '11:37 PM', 'Active'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-15', '01:21 PM', 'Active'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-15', '05:43 PM', 'Active'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-15', '06:26 PM', 'Active'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '03:20 PM', 'Active');

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
(6, 'CSE 314', 'Database System Lab', 1.5, 1, 'Active'),
(7, 'CSE 123', 'Discrete Mathematics', 3, 1, 'Active'),
(8, 'CSE 211', 'Object Oriented Programming Language', 3, 1, 'Active'),
(9, 'CSE 212', 'Object Oriented Programming Language Lab', 1.5, 1, 'Active'),
(10, 'CSE 455', 'Bioinformatics', 3, 1, 'Active'),
(11, 'BBA 201', 'Cost Management and Accounting', 3, 3, 'Active');

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
(1, 'Computer Science & Engineering', 3, 'Active'),
(2, 'Business Administration', 2, 'Active'),
(3, 'English', 1, 'Active'),
(4, 'Law and Justice', 4, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_drop`
--

CREATE TABLE `nr_drop` (
  `nr_drop_id` bigint(20) NOT NULL,
  `nr_prcr_id` bigint(20) NOT NULL,
  `nr_prog_id` bigint(20) NOT NULL,
  `nr_course_id` bigint(20) NOT NULL,
  `nr_drop_semester` enum('1','2','3','4','5','6','7','8','9','10','11','12') NOT NULL,
  `nr_drop_remarks` enum('Compulsory','Optional I','Optional II','Optional III','Optional IV','Optional V') NOT NULL,
  `nr_drop_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nr_drop`
--

INSERT INTO `nr_drop` (`nr_drop_id`, `nr_prcr_id`, `nr_prog_id`, `nr_course_id`, `nr_drop_semester`, `nr_drop_remarks`, `nr_drop_status`) VALUES
(1, 1, 1, 1, '1', 'Compulsory', 'Active'),
(2, 1, 1, 7, '1', 'Compulsory', 'Active'),
(3, 1, 1, 2, '2', 'Compulsory', 'Active'),
(4, 1, 1, 3, '2', 'Compulsory', 'Active'),
(5, 1, 1, 8, '4', 'Compulsory', 'Active'),
(6, 1, 1, 9, '4', 'Compulsory', 'Active'),
(7, 1, 1, 5, '5', 'Compulsory', 'Active'),
(8, 1, 1, 6, '5', 'Compulsory', 'Active'),
(9, 1, 1, 4, '3', 'Optional I', 'Active'),
(10, 1, 1, 10, '3', 'Optional I', 'Active');

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
  `nr_faculty_photo` varchar(100) NOT NULL,
  `nr_faculty_status` enum('Active','Inactive') NOT NULL,
  `nr_faculty_two_factor` int(11) NOT NULL,
  `nr_faculty_gender` enum('Male','Female','Other') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_faculty`
--

INSERT INTO `nr_faculty` (`nr_faculty_id`, `nr_faculty_name`, `nr_faculty_designation`, `nr_faculty_join_date`, `nr_faculty_resign_date`, `nr_faculty_type`, `nr_dept_id`, `nr_faculty_password`, `nr_faculty_email`, `nr_faculty_cell_no`, `nr_faculty_photo`, `nr_faculty_status`, `nr_faculty_two_factor`, `nr_faculty_gender`) VALUES
(1, 'Noushad Sojib', 'Assistant Professor', '2016-04-20', '', 'Permanent', 1, 'rps95d71c0c3e667dcc7b3e0a5b8f368c3aceb6ef42rps', 'mlrahman@neub.edu.bd', '01739213886', '158677029315867702938237.jpg', 'Active', 0, 'Male'),
(2, 'Al Mehdi Saadat Chowdhury', 'Assistant Professor', '2013-01-15', '', 'Permanent', 1, 'rps95d71c0c3e667dcc7b3e0a5b8f368c3aceb6ef42rps', 'amsc@yoo.com', '01711224455', '', 'Active', 0, 'Male'),
(3, 'Tasnim Zahan Tithi', 'Assistant Professor', '2014-01-15', '', 'Permanent', 1, 'rps95d71c0c3e667dcc7b3e0a5b8f368c3aceb6ef42rps', 'tithi@gml.com', '01711224455', '', 'Active', 0, 'Female'),
(4, 'Mir Lutfur Rahman', 'Lecturer', '2018-05-26', '', 'Permanent', 1, 'rps95d71c0c3e667dcc7b3e0a5b8f368c3aceb6ef42rps', 'raihan.testing@gmial.com', '017139213886', '', 'Active', 0, 'Male'),
(5, 'Pranta Sarker', 'Lecturer', '2018-05-26', '', 'Permanent', 1, 'rps95d71c0c3e667dcc7b3e0a5b8f368c3aceb6ef42rps', 'ps@ne', '01680929776', '', 'Active', 0, 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `nr_faculty_link_token`
--

CREATE TABLE `nr_faculty_link_token` (
  `nr_faculty_id` bigint(20) NOT NULL,
  `nr_falito_token` varchar(100) NOT NULL,
  `nr_falito_type` enum('Two Factor','Forget Password') NOT NULL,
  `nr_falito_date` varchar(20) NOT NULL,
  `nr_falito_time` varchar(20) NOT NULL,
  `nr_falito_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Table structure for table `nr_faculty_login_transaction`
--

CREATE TABLE `nr_faculty_login_transaction` (
  `nr_faculty_id` bigint(20) NOT NULL,
  `nr_falotr_ip_address` varchar(100) NOT NULL,
  `nr_falotr_country` varchar(50) NOT NULL,
  `nr_falotr_city` varchar(50) NOT NULL,
  `nr_falotr_lat` varchar(100) NOT NULL,
  `nr_falotr_lng` varchar(100) NOT NULL,
  `nr_falotr_timezone` varchar(100) NOT NULL,
  `nr_falotr_date` varchar(100) NOT NULL,
  `nr_falotr_time` varchar(100) NOT NULL,
  `nr_falotr_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_faculty_login_transaction`
--

INSERT INTO `nr_faculty_login_transaction` (`nr_faculty_id`, `nr_falotr_ip_address`, `nr_falotr_country`, `nr_falotr_city`, `nr_falotr_lat`, `nr_falotr_lng`, `nr_falotr_timezone`, `nr_falotr_date`, `nr_falotr_time`, `nr_falotr_status`) VALUES
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:03 PM', 'Active'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:08 PM', 'Active'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:15 PM', 'Active'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:26 PM', 'Active'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '07:08 PM', 'Active'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '07:10 PM', 'Active'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '07:11 PM', 'Active'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '08:27 PM', 'Active'),
(1, '192.168.0.102', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '11:38 PM', 'Active'),
(2, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '04:39 PM', 'Active'),
(2, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '04:40 PM', 'Active'),
(3, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '04:40 PM', 'Active'),
(4, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '04:41 PM', 'Active'),
(5, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '04:42 PM', 'Active'),
(4, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '04:42 PM', 'Active'),
(5, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '04:43 PM', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_faculty_result_check_transaction`
--

CREATE TABLE `nr_faculty_result_check_transaction` (
  `nr_stud_id` bigint(20) NOT NULL,
  `nr_faculty_id` bigint(20) NOT NULL,
  `nr_rechtr_ip_address` varchar(100) NOT NULL,
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
-- Dumping data for table `nr_faculty_result_check_transaction`
--

INSERT INTO `nr_faculty_result_check_transaction` (`nr_stud_id`, `nr_faculty_id`, `nr_rechtr_ip_address`, `nr_rechtr_country`, `nr_rechtr_city`, `nr_rechtr_lat`, `nr_rechtr_lng`, `nr_rechtr_timezone`, `nr_rechtr_date`, `nr_rechtr_time`, `nr_rechtr_status`) VALUES
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '05:29 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '05:30 PM', 'Active'),
(140203020006, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '05:31 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '05:32 PM', 'Active'),
(140203020006, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '05:36 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '05:36 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '05:37 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '05:38 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '05:57 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '05:59 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '05:59 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:03 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:07 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:09 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:15 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:16 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:18 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:20 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:22 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:25 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:25 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:47 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:50 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:34 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:41 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:41 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:46 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:48 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:51 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:51 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:51 PM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:51 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:51 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:55 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:56 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:57 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:58 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:59 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:59 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '08:07 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '08:11 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '08:14 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '08:15 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '08:21 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '08:23 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '08:24 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '08:25 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '08:25 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '08:35 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:02 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:05 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:06 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:11 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:11 PM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:12 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:12 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:16 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:30 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:36 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:37 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:37 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:45 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:49 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:50 PM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:51 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:51 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:52 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:53 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:55 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '10:02 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '10:03 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '08:49 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '08:49 PM', 'Active'),
(140203020006, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '08:49 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '09:00 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '09:05 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '09:16 PM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '09:16 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '09:19 PM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '09:19 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '09:20 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '09:23 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '09:24 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '09:28 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '09:31 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '09:33 PM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '09:43 PM', 'Active'),
(140203020004, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '09:44 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '09:59 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '10:11 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '10:11 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '10:12 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '10:16 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '10:31 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '10:32 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '10:34 PM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '10:34 PM', 'Active'),
(140203020004, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '10:35 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:36 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:37 PM', 'Active'),
(140203020006, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:37 PM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:37 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:37 PM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:37 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:38 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:42 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:42 PM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:43 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:43 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:47 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:47 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:51 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:51 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:56 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:57 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '02:02 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '02:21 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '02:22 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '02:48 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '05:13 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '05:15 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '05:15 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '05:35 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '06:52 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '07:56 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '09:33 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-11', '06:10 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:23 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '11:49 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:05 PM', 'Active'),
(140203020004, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:05 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:16 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:27 PM', 'Active');

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
(1, 'B.Sc. (Engg.) in CSE', 2, 1, 'Active'),
(2, 'M.Sc. (Engg.) in CSE', 3, 1, 'Active'),
(3, 'BBA', 4, 2, 'Active');

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
(1, 1, 160, '2012-01-01', '', 'Active'),
(2, 2, 36, '2020-03-26', '', 'Active'),
(3, 3, 127, '2020-04-11', '', 'Active');

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
  `nr_result_remarks` enum('Incomplete','Expelled_Mid','MakeUp_MS','MakeUp_SF','MakeUp_MS_SF','Expelled_SF','MakeUp_MS, Expelled_SF','MakeUp_MS, Incomplete','Improvement','Retake','') NOT NULL,
  `nr_result_status` enum('Active','Inactive') NOT NULL,
  `nr_prog_id` bigint(20) NOT NULL,
  `nr_result_publish_date` varchar(100) NOT NULL,
  `nr_faculty_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_result`
--

INSERT INTO `nr_result` (`nr_result_id`, `nr_stud_id`, `nr_course_id`, `nr_result_marks`, `nr_result_grade`, `nr_result_grade_point`, `nr_result_semester`, `nr_result_year`, `nr_result_remarks`, `nr_result_status`, `nr_prog_id`, `nr_result_publish_date`, `nr_faculty_id`) VALUES
(1, 140203020002, 3, 140203029312.5, '89f276cc01d4af01fa8cee48af8ee962bac42500', 140203026062.5, 'Fall', 2016, 'MakeUp_MS', 'Active', 1, '2020-01-27', 1),
(2, 140203020002, 4, 140203029812.5, '500910d02d287a8c898c406ea348043c050d31ca', 140203026312.5, 'Fall', 2015, '', 'Active', 1, '2020-01-27', 1),
(3, 140203020002, 1, 140203022812.5, '264c6dfec271ba9a2a1526fa29b7754ef7eb0fd8', 140203022812.5, 'Spring', 2015, '', 'Active', 1, '2020-01-29', 1),
(4, 140203020002, 2, 140203028812.5, '5177875dc921885677fcc6e571bca2fb1146eaaa', 140203025812.5, 'Spring', 2015, '', 'Active', 1, '2020-01-29', 1),
(5, 140203020002, 5, 140203022812.5, '264c6dfec271ba9a2a1526fa29b7754ef7eb0fd8', 140203022812.5, 'Summer', 2014, '', 'Active', 1, '2020-01-29', 1),
(6, 140203020002, 7, 140203029812.5, '500910d02d287a8c898c406ea348043c050d31ca', 140203026312.5, 'Fall', 2014, '', 'Active', 1, '2020-01-29', 1),
(7, 140203020002, 1, 140203022812.5, '264c6dfec271ba9a2a1526fa29b7754ef7eb0fd8', 140203022812.5, 'Fall', 2016, '', 'Active', 1, '2020-01-29', 1),
(8, 140203020002, 3, 140203030812.5, '1858411229d78def5b8862e672cb210208e69afd', 140203026812.5, 'Summer', 2015, '', 'Active', 1, '2020-01-30', 1),
(9, 140203020002, 5, 140203026812.5, 'd7f53c387a852879c393673564ff1bd45666d0ab', 140203024812.5, 'Summer', 2016, '', 'Active', 1, '2020-01-30', 1),
(10, 140203020002, 7, 140203022812.5, '264c6dfec271ba9a2a1526fa29b7754ef7eb0fd8', 140203022812.5, 'Summer', 2014, '', 'Active', 1, '2020-01-30', 1),
(11, 140203020002, 2, 140203025812.5, '264c6dfec271ba9a2a1526fa29b7754ef7eb0fd8', 140203022812.5, 'Summer', 2015, '', 'Active', 1, '2020-01-30', 1),
(12, 140203020004, 1, 140203029814.5, '4ebc27a8251909faa082444ff8bfb1b68ab051e1', 140203026314.5, 'Spring', 2015, '', 'Active', 1, '2020-03-27', 1),
(13, 140203020004, 10, 140203025814.5, 'd46b42d101ffeddecfdc21efea570b4d17fe65a2', 140203022814.5, 'Spring', 2016, 'Incomplete', 'Active', 1, '2020-03-31', 1),
(14, 150102040001, 11, 150102049811.5, '48f31fa4724d90fe2fa9edaf7f95a5acbdba471a', 150102046311.5, 'Summer', 2015, 'MakeUp_SF', 'Active', 3, '2020-04-11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nr_result_check_transaction`
--

CREATE TABLE `nr_result_check_transaction` (
  `nr_stud_id` bigint(20) NOT NULL,
  `nr_rechtr_ip_address` varchar(100) NOT NULL,
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
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-28', '09:05 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:22 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:22 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:55 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:56 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:58 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '08:06 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '08:08 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '02:58 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '02:58 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '03:00 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '03:07 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '03:07 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '03:08 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '03:09 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '03:09 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '03:10 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '03:10 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '03:10 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '03:12 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '03:13 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '03:14 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '03:16 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '03:18 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '03:22 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '03:23 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '03:24 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '05:45 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '05:45 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '05:47 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '05:50 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '05:50 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '05:50 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '05:52 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '05:56 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '05:57 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '05:57 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '05:57 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '05:59 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '05:59 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:01 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:01 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:01 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:07 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:07 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:08 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:10 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:13 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:23 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:28 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:28 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:31 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:31 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:34 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:34 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:42 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:50 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:52 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:52 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '06:53 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:01 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:04 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:04 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:05 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:05 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:06 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:06 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:07 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:07 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:08 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:09 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:09 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:10 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:17 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:18 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:19 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:20 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:20 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:23 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:25 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:28 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:32 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:34 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:37 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:38 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:40 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:43 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:45 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:47 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:49 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:50 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:53 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:55 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:55 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:56 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:56 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:56 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '07:58 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '08:00 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '08:09 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '08:21 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '08:22 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '08:24 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '08:27 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '08:30 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '08:32 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '08:35 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '08:35 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '08:50 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '08:50 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '08:53 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '08:56 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:04 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:07 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:08 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:09 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:13 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:15 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:19 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:21 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:26 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:27 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:30 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:34 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:41 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:42 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:48 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:49 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:49 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:50 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:52 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '09:58 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '10:00 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '10:01 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '10:02 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '10:10 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '10:10 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '10:12 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '10:13 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '10:13 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '10:13 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '10:14 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '10:15 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-29', '10:17 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '08:32 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '08:43 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '09:23 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '09:24 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '09:24 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '09:27 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '09:50 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '09:51 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '09:58 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:02 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:03 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:09 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:09 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:11 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:14 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:16 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:18 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:19 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:21 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:22 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:25 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:26 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:28 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:30 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:31 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:32 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:35 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:36 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:37 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:41 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:43 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:43 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:44 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:45 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:46 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:46 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:47 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:48 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:49 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:49 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:55 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '10:56 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:01 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:03 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:06 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:07 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:07 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:08 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:20 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:21 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:22 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:36 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:37 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:39 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:40 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:41 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:42 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:45 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:50 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:51 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:54 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:56 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:57 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:59 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '11:59 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:01 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:06 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:08 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:09 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:21 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:23 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:25 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:26 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:27 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:28 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:28 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:29 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:30 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:32 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:33 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:34 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:34 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:35 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:36 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:37 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:39 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:41 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:41 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:42 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:46 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:47 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:47 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:49 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:51 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:53 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:54 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:56 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:56 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '12:57 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:01 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:04 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:05 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:09 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:09 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:10 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:10 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:14 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:14 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:15 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:16 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:16 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:18 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:20 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:21 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:23 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:23 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:25 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:26 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:28 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:28 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:29 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:47 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '01:47 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '02:01 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '02:03 PM', 'Active'),
(140203020002, '192.168.0.101', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '02:05 PM', 'Active'),
(140203020002, '192.168.0.101', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '02:05 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '02:16 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '02:21 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '02:24 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:00 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:01 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:01 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:03 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:03 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:03 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:04 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:04 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:06 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:06 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:06 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:08 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:10 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:12 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:13 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:13 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:14 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:17 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:18 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:22 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:24 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:24 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:27 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:28 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:28 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:28 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:28 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:29 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:30 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:30 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:31 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:31 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:32 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:34 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:36 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:36 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:45 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:46 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:46 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:47 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:49 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:50 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:50 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:50 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:51 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:51 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:52 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:53 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '03:53 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '04:18 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '04:20 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '04:21 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '04:22 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '04:26 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '04:34 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '04:35 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '04:36 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '04:40 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '04:48 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '04:53 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '05:00 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '05:00 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '05:06 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '05:13 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '05:13 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '05:20 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '05:24 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '05:26 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '05:28 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '05:30 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '05:31 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '05:31 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '05:36 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '05:36 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '05:51 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '05:52 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '05:55 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-30', '05:56 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-31', '12:21 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-01-31', '12:21 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-02-01', '10:40 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-02-01', '10:41 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-02-02', '02:13 PM', 'Active'),
(140203020002, '192.168.0.104', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-02-02', '02:13 PM', 'Active'),
(140203020002, '192.168.0.120', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-02-02', '02:14 PM', 'Active'),
(140203020002, '192.168.0.120', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-02-02', '02:15 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-02-05', '10:39 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-02-05', '10:39 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-02-05', '10:41 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-02-05', '10:41 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-02-05', '10:45 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-02-06', '01:08 AM', 'Active'),
(140203020002, '192.168.0.101', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-02-06', '01:12 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-21', '03:31 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-21', '08:20 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-21', '08:20 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-22', '12:16 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-22', '12:17 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-24', '01:28 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-24', '02:43 PM', 'Active'),
(140203020002, '192.168.0.100', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-24', '08:13 PM', 'Active'),
(140203020002, '192.168.0.100', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-24', '08:14 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-25', '12:40 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-25', '12:48 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-25', '12:51 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-25', '12:54 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-25', '12:58 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-25', '12:59 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-25', '01:00 AM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-25', '05:46 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-25', '06:24 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-25', '06:25 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-25', '06:25 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-25', '08:57 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-25', '08:58 PM', 'Active'),
(140203020002, '192.168.0.101', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-26', '03:39 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-26', '05:54 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-26', '05:55 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-26', '07:09 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-26', '07:15 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-26', '07:15 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-26', '07:17 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-26', '07:17 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-26', '07:19 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-26', '07:20 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-26', '10:09 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '05:17 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '05:32 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '05:33 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '05:35 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '05:37 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '05:39 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '05:41 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '05:44 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '05:45 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '05:48 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '05:51 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '05:51 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '05:52 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '05:53 PM', 'Active');
INSERT INTO `nr_result_check_transaction` (`nr_stud_id`, `nr_rechtr_ip_address`, `nr_rechtr_country`, `nr_rechtr_city`, `nr_rechtr_lat`, `nr_rechtr_lng`, `nr_rechtr_timezone`, `nr_rechtr_date`, `nr_rechtr_time`, `nr_rechtr_status`) VALUES
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '05:54 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '05:55 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '05:56 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '06:44 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '07:32 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:12 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:12 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:15 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:16 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:16 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:16 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:17 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:19 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:19 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:19 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:19 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:20 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:20 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:18 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:20 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:22 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:47 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:47 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:49 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:50 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:50 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:51 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:52 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:52 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:53 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:54 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:55 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:55 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:56 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:56 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:57 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:57 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '06:58 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:00 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:00 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:01 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:32 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:57 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:57 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '10:12 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '10:14 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '10:16 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '10:17 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '10:18 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '10:19 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '10:20 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '10:37 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '10:41 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '10:42 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:52 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:53 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:54 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:56 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:58 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '02:00 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '02:01 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '02:01 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '07:56 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-09', '09:38 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:04 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:06 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:09 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:12 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:27 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:30 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:31 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:35 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:35 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:36 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:45 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:46 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:49 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:50 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:51 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:57 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:01 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:06 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:08 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:14 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:27 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:31 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:51 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:51 PM', 'Active'),
(140203020002, '192.168.0.102', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '11:39 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-15', '05:42 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-15', '05:51 PM', 'Active'),
(140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-15', '05:59 PM', 'Active');

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
(140203020002, 'Mir Lutfur Rahman', '1996-07-02', 'Male', 'mlrahman@gmail.com', '', '', 1, 1, 'Active'),
(140203020003, 'Rocksar Sultana Smriti', '1990-07-02', 'Female', '', '', '', 1, 1, 'Active'),
(140203020004, 'Pranta Sarkar', '1990-07-02', 'Male', 'psarkar@gmail.com', '', '', 1, 1, 'Active'),
(140203020005, 'Topu Dash Roy', '1994-12-31', 'Male', 'topucse05@gmail.com', '', '', 1, 1, 'Active'),
(140203020006, 'Shamima Khatun', '1990-07-02', 'Female', '', '', '', 1, 1, 'Active'),
(140203020009, 'Nusrat Hoque', '1990-07-02', 'Female', '', '', '', 1, 1, 'Active'),
(150102040001, 'Rahat Mahmud', '1994-07-02', 'Male', '', '', '', 3, 3, 'Active');

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
(3, 140203020009, 1, '2020-01-01', 'Active');

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
  `nr_syco_map_link` text NOT NULL,
  `nr_syco_date` varchar(20) NOT NULL,
  `nr_syco_status` enum('Active','Inactive') NOT NULL,
  `nr_syco_logo` varchar(150) NOT NULL,
  `nr_syco_video_alt` varchar(150) NOT NULL,
  `nr_syco_video` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_system_component`
--

INSERT INTO `nr_system_component` (`nr_syco_id`, `nr_admin_id`, `nr_syco_title`, `nr_syco_caption`, `nr_syco_address`, `nr_syco_tel`, `nr_syco_email`, `nr_syco_mobile`, `nr_syco_web`, `nr_syco_contact_email`, `nr_syco_map_link`, `nr_syco_date`, `nr_syco_status`, `nr_syco_logo`, `nr_syco_video_alt`, `nr_syco_video`) VALUES
(1, 1, 'NEUB Result Portal', 'Permanent Campus', 'Telihaor, Sheikhghat, Sylhet-3100', '0821 710221-2', 'info@neub.edu.bd', '01755566994', 'www.neub.edu.bd', 'mirlutfur.rahman@gmail.com', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3619.2310196389903!2d91.85876681464518!3d24.89010035019967!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3751aacd70cd7665:0xc8ae330ad72490dd!2z4Kao4Kaw4KeN4KalIOCmh-CmuOCnjeCmnyDgpofgpongpqjgpr_gpq3gpr7gprDgp43gprjgpr_gpp_gpr8g4Kas4Ka-4KaC4Kay4Ka-4Kam4KeH4Ka2!5e0!3m2!1sbn!2sbd!4v1586958839029!5m2!1sbn!2sbd', '2020-04-15', 'Active', '158695222115869522214968.png', '158694047915869404792493.jpg', '158695895215869589522023.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `nr_transcript_print_reference`
--

CREATE TABLE `nr_transcript_print_reference` (
  `nr_stud_id` bigint(20) NOT NULL,
  `nr_trprre_printed_by` enum('Student','Faculty','Moderator','Admin') NOT NULL,
  `nr_trprre_user_id` bigint(20) NOT NULL,
  `nr_trprre_ip_address` varchar(100) NOT NULL,
  `nr_trprre_country` varchar(50) NOT NULL,
  `nr_trprre_city` varchar(50) NOT NULL,
  `nr_trprre_lat` varchar(100) NOT NULL,
  `nr_trprre_lng` varchar(100) NOT NULL,
  `nr_trprre_timezone` varchar(100) NOT NULL,
  `nr_trprre_date` varchar(100) NOT NULL,
  `nr_trprre_time` varchar(100) NOT NULL,
  `nr_trprre_reference` varchar(100) NOT NULL,
  `nr_trprre_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nr_transcript_print_reference`
--

INSERT INTO `nr_transcript_print_reference` (`nr_stud_id`, `nr_trprre_printed_by`, `nr_trprre_user_id`, `nr_trprre_ip_address`, `nr_trprre_country`, `nr_trprre_city`, `nr_trprre_lat`, `nr_trprre_lng`, `nr_trprre_timezone`, `nr_trprre_date`, `nr_trprre_time`, `nr_trprre_reference`, `nr_trprre_status`) VALUES
(150102040001, 'Student', 150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:48 PM', '0110201408485592', 'Active'),
(150102040001, 'Student', 150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:12 PM', '0131201210123742', 'Active'),
(150102040001, 'Student', 150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:50 PM', '0143201408500047', 'Active'),
(150102040001, 'Student', 150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:46 PM', '0184201408464963', 'Active'),
(150102040001, 'Student', 150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:46 PM', '0196201408465420', 'Active'),
(140203020002, 'Student', 140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:07 PM', '0211201409072838', 'Active'),
(140203020002, 'Student', 140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-15', '05:50 PM', '0214201501504338', 'Active'),
(140203020002, 'Student', 140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-15', '05:56 PM', '0222201501562928', 'Active'),
(140203020002, 'Student', 140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:27 PM', '0225201409271714', 'Active'),
(140203020002, 'Student', 140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-15', '05:42 PM', '0227201501425111', 'Active'),
(140203020002, 'Student', 140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-15', '05:59 PM', '0230201501595372', 'Active'),
(140203020002, 'Student', 140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-09', '09:39 PM', '0234200905393013', 'Active'),
(140203020002, 'Student', 140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-15', '05:51 PM', '0236201501512567', 'Active'),
(140203020002, 'Faculty', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:34 PM', '0236202903340580', 'Active'),
(140203020002, 'Student', 140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:37 PM', '0241201210371642', 'Active'),
(140203020002, 'Student', 140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:14 PM', '0245201409145364', 'Active'),
(140203020002, 'Student', 140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '07:56 PM', '0248203103563025', 'Active'),
(140203020002, 'Faculty', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:40 PM', '0250202903405318', 'Active'),
(140203020002, 'Student', 140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-15', '05:56 PM', '0254201501561830', 'Active'),
(140203020002, 'Faculty', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '02:48 PM', '0254203110482865', 'Active'),
(140203020002, 'Faculty', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:56 PM', '0263203109565166', 'Active'),
(140203020002, 'Student', 140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:32 PM', '0264202903321638', 'Active'),
(140203020002, 'Student', 140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:08 PM', '0272201409081999', 'Active'),
(140203020002, 'Faculty', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '07:57 PM', '0279203103571149', 'Active'),
(140203020002, 'Faculty', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:57 PM', '0283203109572421', 'Active'),
(140203020002, 'Student', 140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-15', '05:45 PM', '0289201501455226', 'Active'),
(140203020002, 'Student', 140203020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '03:39 PM', '0296201611391419', 'Active'),
(140203020002, 'Faculty', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '06:52 PM', '0299203102523693', 'Active'),
(140203020004, 'Student', 140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:51 PM', '0445201408512649', 'Active'),
(140203020004, 'Student', 140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:52 PM', '0451201408523243', 'Active'),
(140203020004, 'Student', 140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:51 PM', '0454201409515965', 'Active'),
(140203020004, 'Faculty', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:05 PM', '0467201409053793', 'Active'),
(140203020009, 'Student', 140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:58 PM', '0983203109585812', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nr_admin`
--
ALTER TABLE `nr_admin`
  ADD PRIMARY KEY (`nr_admin_id`);

--
-- Indexes for table `nr_admin_link_token`
--
ALTER TABLE `nr_admin_link_token`
  ADD KEY `nr_admin_link_token_ibfk_1` (`nr_admin_id`);

--
-- Indexes for table `nr_admin_login_transaction`
--
ALTER TABLE `nr_admin_login_transaction`
  ADD KEY `nr_admin_login_transaction_ibfk_1` (`nr_admin_id`);

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
-- Indexes for table `nr_drop`
--
ALTER TABLE `nr_drop`
  ADD PRIMARY KEY (`nr_drop_id`),
  ADD KEY `nr_prcr_id` (`nr_prcr_id`),
  ADD KEY `nr_prog_id` (`nr_prog_id`),
  ADD KEY `nr_course_id` (`nr_course_id`);

--
-- Indexes for table `nr_faculty`
--
ALTER TABLE `nr_faculty`
  ADD PRIMARY KEY (`nr_faculty_id`),
  ADD KEY `nr_dept_id` (`nr_dept_id`);

--
-- Indexes for table `nr_faculty_link_token`
--
ALTER TABLE `nr_faculty_link_token`
  ADD KEY `nr_faculty_id` (`nr_faculty_id`);

--
-- Indexes for table `nr_faculty_login_transaction`
--
ALTER TABLE `nr_faculty_login_transaction`
  ADD KEY `nr_faculty_id` (`nr_faculty_id`);

--
-- Indexes for table `nr_faculty_result_check_transaction`
--
ALTER TABLE `nr_faculty_result_check_transaction`
  ADD KEY `nr_stud_id` (`nr_stud_id`),
  ADD KEY `nr_faculty_id` (`nr_faculty_id`);

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
-- Indexes for table `nr_transcript_print_reference`
--
ALTER TABLE `nr_transcript_print_reference`
  ADD UNIQUE KEY `nr_trprre_ref` (`nr_trprre_reference`),
  ADD KEY `nr_stud_id` (`nr_stud_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nr_admin`
--
ALTER TABLE `nr_admin`
  MODIFY `nr_admin_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nr_course`
--
ALTER TABLE `nr_course`
  MODIFY `nr_course_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `nr_department`
--
ALTER TABLE `nr_department`
  MODIFY `nr_dept_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `nr_drop`
--
ALTER TABLE `nr_drop`
  MODIFY `nr_drop_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `nr_faculty`
--
ALTER TABLE `nr_faculty`
  MODIFY `nr_faculty_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nr_program`
--
ALTER TABLE `nr_program`
  MODIFY `nr_prog_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nr_program_credit`
--
ALTER TABLE `nr_program_credit`
  MODIFY `nr_prcr_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nr_result`
--
ALTER TABLE `nr_result`
  MODIFY `nr_result_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `nr_student_waived_credit`
--
ALTER TABLE `nr_student_waived_credit`
  MODIFY `nr_stwacr_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nr_system_component`
--
ALTER TABLE `nr_system_component`
  MODIFY `nr_syco_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nr_admin_link_token`
--
ALTER TABLE `nr_admin_link_token`
  ADD CONSTRAINT `nr_admin_link_token_ibfk_1` FOREIGN KEY (`nr_admin_id`) REFERENCES `nr_admin` (`nr_admin_id`);

--
-- Constraints for table `nr_admin_login_transaction`
--
ALTER TABLE `nr_admin_login_transaction`
  ADD CONSTRAINT `nr_admin_login_transaction_ibfk_1` FOREIGN KEY (`nr_admin_id`) REFERENCES `nr_admin` (`nr_admin_id`);

--
-- Constraints for table `nr_course`
--
ALTER TABLE `nr_course`
  ADD CONSTRAINT `nr_course_ibfk_1` FOREIGN KEY (`nr_prog_id`) REFERENCES `nr_program` (`nr_prog_id`);

--
-- Constraints for table `nr_drop`
--
ALTER TABLE `nr_drop`
  ADD CONSTRAINT `nr_drop_ibfk_1` FOREIGN KEY (`nr_prcr_id`) REFERENCES `nr_program_credit` (`nr_prcr_id`),
  ADD CONSTRAINT `nr_drop_ibfk_2` FOREIGN KEY (`nr_prog_id`) REFERENCES `nr_program` (`nr_prog_id`),
  ADD CONSTRAINT `nr_drop_ibfk_3` FOREIGN KEY (`nr_course_id`) REFERENCES `nr_course` (`nr_course_id`);

--
-- Constraints for table `nr_faculty`
--
ALTER TABLE `nr_faculty`
  ADD CONSTRAINT `nr_faculty_ibfk_1` FOREIGN KEY (`nr_dept_id`) REFERENCES `nr_department` (`nr_dept_id`);

--
-- Constraints for table `nr_faculty_link_token`
--
ALTER TABLE `nr_faculty_link_token`
  ADD CONSTRAINT `nr_faculty_link_token_ibfk_1` FOREIGN KEY (`nr_faculty_id`) REFERENCES `nr_faculty` (`nr_faculty_id`);

--
-- Constraints for table `nr_faculty_login_transaction`
--
ALTER TABLE `nr_faculty_login_transaction`
  ADD CONSTRAINT `nr_faculty_login_transaction_ibfk_1` FOREIGN KEY (`nr_faculty_id`) REFERENCES `nr_faculty` (`nr_faculty_id`);

--
-- Constraints for table `nr_faculty_result_check_transaction`
--
ALTER TABLE `nr_faculty_result_check_transaction`
  ADD CONSTRAINT `nr_faculty_result_check_transaction_ibfk_1` FOREIGN KEY (`nr_stud_id`) REFERENCES `nr_student` (`nr_stud_id`),
  ADD CONSTRAINT `nr_faculty_result_check_transaction_ibfk_2` FOREIGN KEY (`nr_faculty_id`) REFERENCES `nr_faculty` (`nr_faculty_id`);

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

--
-- Constraints for table `nr_transcript_print_reference`
--
ALTER TABLE `nr_transcript_print_reference`
  ADD CONSTRAINT `nr_transcript_print_reference_ibfk_1` FOREIGN KEY (`nr_stud_id`) REFERENCES `nr_student` (`nr_stud_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
