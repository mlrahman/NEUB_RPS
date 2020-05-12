-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2020 at 01:14 PM
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
  `nr_admin_gender` enum('Male','Female','Other') NOT NULL,
  `nr_admin_join_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_admin`
--

INSERT INTO `nr_admin` (`nr_admin_id`, `nr_admin_name`, `nr_admin_email`, `nr_admin_password`, `nr_admin_cell_no`, `nr_admin_photo`, `nr_admin_type`, `nr_admin_designation`, `nr_admin_status`, `nr_admin_two_factor`, `nr_admin_resign_date`, `nr_admin_gender`, `nr_admin_join_date`) VALUES
(1, 'Shams Elahi Rasel', 'mirlutfur.rahman@gmail.com', 'rps95d71c0c3e667dcc7b3e0a5b8f368c3aceb6ef42rps', '', '158677029315867702938237.jpg', 'Super Admin', 'Controller of Examination, NEUB', 'Active', 0, '', 'Male', '2012-11-03'),
(6, 'Fahad Ahmed', 'mlrahman@neub.edu.bd', 'rps95d71c0c3e667dcc7b3e0a5b8f368c3aceb6ef42rps', '01739213886', '158928186715892818677563.jpg', 'Moderator', 'Moderator of Controller of Exam, NEUB', 'Active', 0, '', 'Male', '2013-05-01');

-- --------------------------------------------------------

--
-- Table structure for table `nr_admin_history`
--

CREATE TABLE `nr_admin_history` (
  `nr_admin_member_id` bigint(20) NOT NULL,
  `nr_admin_id` bigint(20) NOT NULL,
  `nr_adminh_task` mediumtext NOT NULL,
  `nr_adminh_date` varchar(20) NOT NULL,
  `nr_adminh_time` varchar(20) NOT NULL,
  `nr_adminh_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nr_admin_history`
--

INSERT INTO `nr_admin_history` (`nr_admin_member_id`, `nr_admin_id`, `nr_adminh_task`, `nr_adminh_date`, `nr_adminh_time`, `nr_adminh_status`) VALUES
(6, 1, 'Edited Admin Name: Fahad Ahmed, Admin Designation: Assistant Controller of NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: , Admin Type: Moderator, Admin Email: , Admin Mobile: , Admin Status: Inactive', '2020-04-28', '11:17 PM', 'Active'),
(6, 1, 'Edited Admin Name: Fahad Ahmed, Admin Designation: Assistant Controller of NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: , Admin Type: Moderator, Admin Email: mlrahman@neub.edu.bd, Admin Mobile: , Admin Status: Active', '2020-04-28', '11:18 PM', 'Active'),
(6, 1, 'Edited Admin Name: Fahad Ahmed, Admin Designation: Moderator of Controller of Exam, NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: , Admin Type: Admin, Admin Email: mlrahman@neub.edu.bd, Admin Mobile: , Admin Status: Active', '2020-04-28', '11:20 PM', 'Active'),
(6, 1, 'Edited Admin Name: Fahad Ahmed, Admin Designation: Moderator of Controller of Exam, NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: , Admin Type: Moderator, Admin Email: mlrahman@neub.edu.bd, Admin Mobile: , Admin Status: Active', '2020-04-28', '11:28 PM', 'Active'),
(6, 1, 'Edited Admin Name: Fahad Ahmed, Admin Designation: Moderator of Controller of Exam, NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: , Admin Type: Admin, Admin Email: mlrahman@neub.edu.bd, Admin Mobile: , Admin Status: Active', '2020-05-10', '12:49 PM', 'Active'),
(6, 1, 'Edited Admin Name: Fahad Ahmed, Admin Designation: Moderator of Controller of Exam, NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: , Admin Type: Moderator, Admin Email: mlrahman@neub.edu.bd, Admin Mobile: , Admin Status: Active', '2020-05-10', '01:01 PM', 'Active'),
(6, 1, 'Edited Admin Name: Fahad Ahmed, Admin Designation: Moderator of Controller of Exam, NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: , Admin Type: Admin, Admin Email: mlrahman@neub.edu.bd, Admin Mobile: , Admin Status: Active', '2020-05-10', '01:03 PM', 'Active'),
(6, 1, 'Edited Admin Name: Fahad Ahmed, Admin Designation: Moderator of Controller of Exam, NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: , Admin Type: Moderator, Admin Email: mlrahman@neub.edu.bd, Admin Mobile: , Admin Status: Active', '2020-05-10', '01:05 PM', 'Active'),
(6, 1, 'Edited Admin Name: Fahad Ahmed, Admin Designation: Moderator of Controller of Exam, NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: , Admin Type: Admin, Admin Email: mlrahman@neub.edu.bd, Admin Mobile: , Admin Status: Active', '2020-05-10', '01:09 PM', 'Active'),
(6, 1, 'Edited Admin Name: Fahad Ahmed, Admin Designation: Moderator of Controller of Exam, NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: , Admin Type: Moderator, Admin Email: mlrahman@neub.edu.bd, Admin Mobile: , Admin Status: Active', '2020-05-10', '01:12 PM', 'Active'),
(6, 1, 'Edited Admin Name: Fahad Ahmed, Admin Designation: Moderator of Controller of Exam, NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: , Admin Type: Admin, Admin Email: mlrahman@neub.edu.bd, Admin Mobile: , Admin Status: Active', '2020-05-10', '01:12 PM', 'Active'),
(6, 1, 'Edited Admin Name: Fahad Ahmed, Admin Designation: Moderator of Controller of Exam, NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: , Admin Type: Moderator, Admin Email: mlrahman@neub.edu.bd, Admin Mobile: , Admin Status: Active', '2020-05-10', '01:13 PM', 'Active'),
(6, 1, 'Edited Admin Name: Fahad Ahmed, Admin Designation: Moderator of Controller of Exam, NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: , Admin Type: Admin, Admin Email: mlrahman@neub.edu.bd, Admin Mobile: , Admin Status: Active', '2020-05-10', '04:59 PM', 'Active'),
(6, 1, 'Edited Admin Name: Fahad Ahmed, Admin Designation: Moderator of Controller of Exam, NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: , Admin Type: Moderator, Admin Email: mlrahman@neub.edu.bd, Admin Mobile: , Admin Status: Active', '2020-05-10', '05:00 PM', 'Active'),
(6, 1, 'Edited Admin Name: Fahad Ahmed, Admin Designation: Moderator of Controller of Exam, NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: , Admin Type: Moderator, Admin Email: mlrahman@neub.edu.bd, Admin Mobile: , Admin Status: Inactive', '2020-05-10', '05:01 PM', 'Active'),
(6, 1, 'Edited Admin Name: Fahad Ahmed, Admin Designation: Moderator of Controller of Exam, NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: , Admin Type: Moderator, Admin Email: mlrahman@neub.edu.bd, Admin Mobile: , Admin Status: Active', '2020-05-10', '05:01 PM', 'Active'),
(6, 1, 'Edited Admin Name: Fahad Ahmed, Admin Designation: Moderator of Controller of Exam, NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: , Admin Type: Moderator, Admin Email: mlrahman@neub.edu.bd, Admin Mobile: , Admin Status: Inactive', '2020-05-10', '05:03 PM', 'Active'),
(6, 1, 'Edited Admin Name: Fahad Ahmed, Admin Designation: Moderator of Controller of Exam, NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: , Admin Type: Moderator, Admin Email: mlrahman@neub.edu.bd, Admin Mobile: , Admin Status: Active', '2020-05-10', '05:04 PM', 'Active');

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
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-13', '06:42 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:24 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '06:32 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '10:05 PM', 'Inactive'),
(1, '192.168.0.102', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '11:35 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-15', '01:21 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-15', '05:43 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-15', '06:26 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '03:20 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '10:34 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '10:46 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '11:47 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-17', '03:39 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-17', '09:50 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-19', '10:38 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-20', '04:32 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-20', '08:09 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-20', '09:39 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-21', '01:40 AM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-21', '11:52 AM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-21', '09:10 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-22', '03:11 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-22', '04:14 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-23', '02:26 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-23', '09:05 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-24', '03:40 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-24', '06:21 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-24', '06:24 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-24', '06:41 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-25', '02:26 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-26', '04:00 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-27', '12:25 AM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-27', '04:06 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-27', '09:02 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-28', '03:41 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-29', '07:31 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-30', '03:57 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-01', '02:25 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-01', '09:59 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '02:27 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '10:37 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '01:49 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '09:54 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '11:34 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '04:20 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '10:32 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:11 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-05', '04:08 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:09 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-07', '03:16 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '02:23 AM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '01:32 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-09', '05:22 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-09', '09:31 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-09', '11:09 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '12:33 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '04:07 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '04:59 PM', 'Inactive'),
(6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '05:00 PM', 'Inactive'),
(6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '05:01 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '05:09 PM', 'Inactive'),
(6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '07:40 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '08:09 PM', 'Inactive'),
(6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-12', '02:40 PM', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `nr_admin_result_check_transaction`
--

CREATE TABLE `nr_admin_result_check_transaction` (
  `nr_stud_id` bigint(20) NOT NULL,
  `nr_admin_id` bigint(20) NOT NULL,
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
-- Dumping data for table `nr_admin_result_check_transaction`
--

INSERT INTO `nr_admin_result_check_transaction` (`nr_stud_id`, `nr_admin_id`, `nr_rechtr_ip_address`, `nr_rechtr_country`, `nr_rechtr_city`, `nr_rechtr_lat`, `nr_rechtr_lng`, `nr_rechtr_timezone`, `nr_rechtr_date`, `nr_rechtr_time`, `nr_rechtr_status`) VALUES
(140203020004, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-30', '05:08 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-30', '05:08 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-30', '05:08 PM', 'Active'),
(140203020004, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-01', '02:47 PM', 'Active'),
(140203020005, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-01', '03:14 PM', 'Active'),
(140203020005, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-01', '07:00 PM', 'Active'),
(140203020004, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-01', '07:02 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-01', '07:06 PM', 'Active'),
(140203020004, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-01', '07:19 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-01', '07:19 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-01', '07:21 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-01', '07:24 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-01', '07:24 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-01', '07:28 PM', 'Active'),
(140203020005, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-01', '10:13 PM', 'Active'),
(140203020004, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-01', '10:25 PM', 'Active'),
(140203020004, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '02:27 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '05:27 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '10:38 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '10:56 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '10:57 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '10:57 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:03 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:04 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:06 PM', 'Active'),
(140203020004, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:06 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:07 PM', 'Active'),
(140203020004, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:07 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:10 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:13 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:14 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:16 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:16 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:20 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:22 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:38 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:38 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:39 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:39 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:40 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:40 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:41 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:42 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:50 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:51 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-02', '11:51 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '12:14 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '12:16 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '12:21 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '12:24 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '12:27 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '12:29 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '12:31 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '12:32 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '12:34 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '12:35 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '12:35 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '12:37 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '01:09 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '01:17 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '01:18 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '01:19 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '01:19 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '01:20 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '01:22 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '01:22 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '01:25 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '01:26 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '01:50 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '01:50 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '02:55 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '02:56 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '02:56 PM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '03:20 PM', 'Active'),
(130103020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '11:12 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-03', '11:12 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '06:57 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '06:59 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '07:46 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '07:47 PM', 'Active'),
(140203020004, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '07:50 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '07:50 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '07:55 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '07:56 PM', 'Active'),
(130103020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '07:57 PM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '07:57 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '07:58 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '07:59 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '08:01 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '08:02 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '08:04 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '08:08 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '08:08 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '08:11 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '08:12 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '08:13 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '10:32 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:29 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-05', '04:08 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:09 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:27 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:27 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:30 PM', 'Active'),
(140203020004, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '05:22 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '07:52 PM', 'Active'),
(150102040001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '11:21 PM', 'Active'),
(130103020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-07', '04:01 PM', 'Active'),
(130103020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-07', '04:18 PM', 'Active'),
(130103020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-07', '04:18 PM', 'Active'),
(130103020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-07', '04:19 PM', 'Active'),
(130103020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-07', '04:20 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-07', '07:19 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-07', '07:19 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-07', '11:11 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-07', '11:16 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-07', '11:17 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-07', '11:17 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:01 AM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:03 AM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:04 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:04 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:06 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:06 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:08 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:12 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:12 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:14 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:17 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:18 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:39 AM', 'Active'),
(130103020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:48 AM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:48 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:49 AM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:50 AM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:54 AM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:56 AM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:56 AM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '01:03 AM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '01:08 AM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '01:20 AM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '02:05 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '02:05 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '02:35 PM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '03:18 PM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '03:20 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '04:56 PM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '04:56 PM', 'Active'),
(140203020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '04:57 PM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-09', '11:09 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '12:34 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '12:34 PM', 'Active'),
(130103020001, 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '01:53 PM', 'Active'),
(130103020001, 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '01:54 PM', 'Active'),
(130103020001, 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '01:54 PM', 'Active'),
(130103020002, 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '01:59 PM', 'Active'),
(130103020002, 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '02:03 PM', 'Active'),
(130103020001, 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '02:07 PM', 'Active'),
(130103020002, 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '02:10 PM', 'Active'),
(130103020002, 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '02:10 PM', 'Active'),
(130103020002, 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '02:14 PM', 'Active'),
(130103020002, 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '02:15 PM', 'Active'),
(130103020002, 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '02:15 PM', 'Active'),
(130103020002, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '02:16 PM', 'Active'),
(130103020001, 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '04:05 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '04:12 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '04:12 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '04:12 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '04:14 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '04:15 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '04:15 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '04:15 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '04:15 PM', 'Active'),
(130103020001, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '04:16 PM', 'Active'),
(130103020001, 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '04:24 PM', 'Active'),
(130103020001, 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '04:25 PM', 'Active'),
(140303020008, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '05:00 PM', 'Active'),
(130103020002, 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-12', '05:07 PM', 'Active');

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
(4, 'CSE 311', 'Computer Architecture', 3, 1, 'Inactive'),
(5, 'CSE 313', 'Database System', 3, 1, 'Active'),
(6, 'CSE 314', 'Database System Lab', 1.5, 1, 'Active'),
(7, 'CSE 123', 'Discrete Mathematics', 3, 1, 'Active'),
(8, 'CSE 211', 'Object Oriented Programming Language', 3, 1, 'Active'),
(9, 'CSE 212', 'Object Oriented Programming Language Lab', 1.5, 1, 'Active'),
(10, 'CSE 455', 'Bioinformatics', 3, 1, 'Active'),
(11, 'BBA 201', 'Cost Management and Accounting', 3, 3, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_course_history`
--

CREATE TABLE `nr_course_history` (
  `nr_course_id` bigint(20) NOT NULL,
  `nr_admin_id` bigint(20) NOT NULL,
  `nr_courseh_task` text NOT NULL,
  `nr_courseh_date` varchar(20) NOT NULL,
  `nr_courseh_time` varchar(20) NOT NULL,
  `nr_courseh_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nr_course_history`
--

INSERT INTO `nr_course_history` (`nr_course_id`, `nr_admin_id`, `nr_courseh_task`, `nr_courseh_date`, `nr_courseh_time`, `nr_courseh_status`) VALUES
(10, 1, 'Edited Course Title: Bioinformatics, Course Code: CSE 455, Course Credit: 3, Course Program: B.Sc. (Engg.) in CSE, Course Status: Inactive', '2020-04-24', '12:26 AM', 'Active'),
(10, 1, 'Edited Course Title: Bioinformatics, Course Code: CSE 455, Course Credit: 3, Course Program: B.Sc. (Engg.) in CSE, Course Status: Active', '2020-04-24', '12:27 AM', 'Active'),
(1, 1, 'Edited Course Title: Fundamentals of Computers, Course Code: CSE 111, Course Credit: 3.00, Course Program: B.Sc. (Engg.) in CSE, Course Status: Inactive', '2020-04-28', '03:44 PM', 'Active'),
(1, 1, 'Edited Course Title: Fundamentals of Computers, Course Code: CSE 111, Course Credit: 3.00, Course Program: B.Sc. (Engg.) in CSE, Course Status: Active', '2020-05-02', '11:51 PM', 'Active'),
(4, 1, 'Edited Course Title: Computer Architecture, Course Code: CSE 311, Course Credit: 3.00, Course Program: B.Sc. (Engg.) in CSE, Course Status: Inactive', '2020-05-04', '07:49 PM', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_delete_history`
--

CREATE TABLE `nr_delete_history` (
  `nr_admin_id` bigint(20) NOT NULL,
  `nr_deleteh_task` mediumtext NOT NULL,
  `nr_deleteh_date` varchar(20) NOT NULL,
  `nr_deleteh_time` varchar(20) NOT NULL,
  `nr_deleteh_status` enum('Active','Inactive') NOT NULL,
  `nr_deleteh_type` enum('Department','Program','Course List','Course Offer List','Admin','Faculty','Moderator','Student','Result') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nr_delete_history`
--

INSERT INTO `nr_delete_history` (`nr_admin_id`, `nr_deleteh_task`, `nr_deleteh_date`, `nr_deleteh_time`, `nr_deleteh_status`, `nr_deleteh_type`) VALUES
(1, 'Deleted Department Title: Applied Sociology and Social Work, Department Code: 5, Department Status: Inactive', '2020-04-24', '04:22 PM', 'Active', 'Department'),
(1, 'Deleted Program Title: M.Sc. (Engg.) in CSE, Program Code: 3, Department Title: Computer Science and Engineering, Program Status: Active', '2020-04-24', '04:40 PM', 'Active', 'Program'),
(1, 'Deleted Department Title: yvgbhkn, Department Code: 0, Department Status: Active', '2020-04-24', '04:44 PM', 'Active', 'Department'),
(1, 'Deleted Program Title: cfghgv, Program Code: dtrfygu, Department Title: Business Administration, Program Status: Active', '2020-04-24', '04:57 PM', 'Active', 'Program'),
(1, 'Deleted Course Title: dcf, Course Code: 4, Course Credit: 4, Course Program: Active, Course Status: Active', '2020-04-24', '04:59 PM', 'Active', 'Course List'),
(1, 'Deleted Offer Course Title: Database System, Course Code: CSE 313, Course Credit: 3, Course Type: Compulsory, Offer Semester: 5, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 160, Offer Status: Active', '2020-04-25', '12:10 AM', 'Active', 'Course Offer List'),
(1, 'Deleted Offer Course Title: Cost Management and Accounting, Course Code: BBA 201, Course Credit: 3.00, Course Type: Compulsory, Offer Semester: 2nd, Offer Program: BBA, Program Credit: 127, Offer Status: Active', '2020-04-25', '04:38 PM', 'Active', 'Course Offer List'),
(1, 'Deleted Offer Course Title: Cost Management and Accounting, Course Code: BBA 201, Course Credit: 3.00, Course Type: Compulsory, Offer Semester: 2nd, Offer Program: BBA, Program Credit: 127, Offer Status: Active', '2020-04-25', '04:41 PM', 'Active', 'Course Offer List'),
(1, 'Deleted Offer Course Title: Cost Management and Accounting, Course Code: BBA 201, Course Credit: 3.00, Course Type: Compulsory, Offer Semester: 3rd, Offer Program: BBA, Program Credit: 127, Offer Status: Active', '2020-04-25', '04:44 PM', 'Active', 'Course Offer List'),
(1, 'Deleted Offer Course Title: Fundamentals of Computers, Course Code: CSE 111, Course Credit: 3.00, Course Type: Optional IV, Offer Semester: 4th, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 157, Offer Status: Active', '2020-04-25', '04:49 PM', 'Active', 'Course Offer List'),
(1, 'Deleted Offer Course Title: Algorithm Design and Analysis, Course Code: CSE 221, Course Credit: 3.00, Course Type: Optional II, Offer Semester: 3rd, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 122, Offer Status: Active', '2020-04-25', '09:24 PM', 'Active', 'Course Offer List'),
(1, 'Deleted Offer Course Title: Algorithm Design and Analysis Lab, Course Code: CSE 222, Course Credit: 1.50, Course Type: Compulsory, Offer Semester: 3rd, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 122, Offer Status: Active', '2020-04-25', '09:25 PM', 'Active', 'Course Offer List'),
(1, 'Deleted Offer Course Title: Database System, Course Code: CSE 313, Course Credit: 3.00, Course Type: Compulsory, Offer Semester: 7th, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 122, Offer Status: Inactive', '2020-04-25', '09:25 PM', 'Active', 'Course Offer List'),
(1, 'Deleted Offer Course Title: Fundamentals of Computers, Course Code: CSE 111, Course Credit: 3.00, Course Type: Compulsory, Offer Semester: 1st, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 122, Offer Status: Active', '2020-04-25', '09:25 PM', 'Active', 'Course Offer List'),
(1, 'Deleted Offer Course Title: Structured Programming Language, Course Code: CSE 113, Course Credit: 3.00, Course Type: Optional I, Offer Semester: 3rd, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 122, Offer Status: Active', '2020-04-25', '09:27 PM', 'Active', 'Course Offer List'),
(1, 'Deleted Faculty Name: Al Mehdi Saadat Chowdhury, Faculty Designation: Assistant Professor, Faculty Gender: Male, Faculty Join Date: 2013-01-15, Faculty Resign Date: N/A, Faculty Department: Computer Science and Engineering, Faculty Type: Permanent, Faculty Email: amsc@yoo.com, Faculty Mobile: 01711224455, Faculty Status: Active', '2020-04-26', '08:41 PM', 'Active', 'Faculty'),
(1, 'Deleted Faculty Name: Al Mehdi Saadat Chowdhury, Faculty Designation: Assistant Professor, Faculty Gender: Male, Faculty Join Date: 2013-04-16, Faculty Resign Date: N/A, Faculty Department: Computer Science and Engineering, Faculty Type: Permanent, Faculty Email: amsc@yahoo.com, Faculty Mobile: N/A, Faculty Status: Active', '2020-04-27', '05:59 PM', 'Active', 'Faculty'),
(1, 'Deleted Faculty Name: Al Mehdi Saadat Chowdhury, Faculty Designation: Assistant Professor, Faculty Gender: Male, Faculty Join Date: 2013-04-17, Faculty Resign Date: N/A, Faculty Department: Computer Science and Engineering, Faculty Type: Permanent, Faculty Email: mirlutfur.rahman@gmail.com, Faculty Mobile: N/A, Faculty Status: Active', '2020-04-27', '06:06 PM', 'Active', 'Faculty'),
(1, 'Deleted Faculty Name: Al Mehdi Saadat Chowdhury, Faculty Designation: Assistant Professor, Faculty Gender: Male, Faculty Join Date: 2013-11-24, Faculty Resign Date: N/A, Faculty Department: Computer Science and Engineering, Faculty Type: Permanent, Faculty Email: mirlutfur.rahman@gmail.com, Faculty Mobile: N/A, Faculty Status: Active', '2020-04-27', '07:56 PM', 'Active', 'Faculty'),
(1, 'Deleted Faculty Name: gj, Faculty Designation: ghjhb, Faculty Gender: Female, Faculty Join Date: 2020-04-02, Faculty Resign Date: N/A, Faculty Department: Business Administration, Faculty Type: Permanent, Faculty Email: kj, Faculty Mobile: N/A, Faculty Status: Active', '2020-04-27', '07:57 PM', 'Active', 'Faculty'),
(1, 'Deleted Faculty Name: kjkj, Faculty Designation: knjn, Faculty Gender: Male, Faculty Join Date: 2020-02-02, Faculty Resign Date: N/A, Faculty Department: Business Administration, Faculty Type: Adjunct, Faculty Email: sdfsdf, Faculty Mobile: N/A, Faculty Status: Active', '2020-04-27', '07:57 PM', 'Active', 'Faculty'),
(1, 'Deleted Admin Name: Fahad Ahmed, Admin Designation: Assistant Controller of NEUB, Admin Gender: 15867702931586770293823.jpg, Admin Join Date: 2013-01-01, Admin Resign Date: N/A, Admin Type: Moderator, Admin Email: Active, Admin Mobile: N/A, Admin Status: Male', '2020-04-28', '10:11 PM', 'Active', 'Admin'),
(1, 'Deleted Admin Name: Fahad Ahmed, Admin Designation: Assistant Controller of NEUB, Admin Gender: 15867702931586770293823.jpg, Admin Join Date: 2013-05-01, Admin Resign Date: N/A, Admin Type: Moderator, Admin Email: Active, Admin Mobile: N/A, Admin Status: Male', '2020-04-28', '10:20 PM', 'Active', 'Admin'),
(1, 'Deleted Admin Name: Fahad Ahmed, Admin Designation: Assistant Controller of NEUB, Admin Gender: Male, Admin Join Date: 2013-05-01, Admin Resign Date: N/A, Admin Type: Moderator, Admin Email: mlrahman@neub.edu.bd, Admin Mobile: N/A, Admin Status: Active', '2020-04-28', '10:23 PM', 'Active', 'Admin'),
(1, 'Deleted Admin Name: Sonjoy Roy, Admin Designation: Associate Controller of Examination, Admin Gender: Male, Admin Join Date: 2019-11-10, Admin Resign Date: N/A, Admin Type: Admin, Admin Email: sr@sr.sr, Admin Mobile: N/A, Admin Status: Active', '2020-04-28', '10:34 PM', 'Active', 'Admin'),
(1, 'Deleted Admin Name: Sonjoy Roy, Admin Designation: Assistant Controller of Examination, Admin Gender: Male, Admin Join Date: 2018-03-02, Admin Resign Date: N/A, Admin Type: , Admin Email: raihan.testing@gmail.com, Admin Mobile: N/A, Admin Status: Active', '2020-04-29', '10:02 PM', 'Active', 'Admin'),
(1, 'Deleted Admin Name: Sonjoy Roy, Admin Designation: Assistant Controller of Examination, Admin Gender: Male, Admin Join Date: 2018-03-02, Admin Resign Date: N/A, Admin Type: Admin, Admin Email: raihan.testing@gmail.com, Admin Mobile: N/A, Admin Status: Active', '2020-04-29', '10:03 PM', 'Active', 'Admin'),
(1, 'Deleted Admin Name: Sonjoy Roy, Admin Designation: Assistant Controller of Examination, Admin Gender: Male, Admin Join Date: 2018-03-02, Admin Resign Date: N/A, Admin Type: Admin, Admin Email: raihan.testing@gmail.com, Admin Mobile: N/A, Admin Status: Active', '2020-04-29', '10:05 PM', 'Active', 'Admin'),
(1, 'Deleted Admin Name: Sonjoy Roy, Admin Designation: Assistant Controller of Examination, Admin Gender: Male, Admin Join Date: 2018-03-02, Admin Resign Date: N/A, Admin Type: Admin, Admin Email: raihan.testing@gmail.com, Admin Mobile: N/A, Admin Status: Active', '2020-04-29', '10:07 PM', 'Active', 'Admin'),
(1, 'Deleted Admin Name: ctvygbh, Admin Designation: fr6tgu, Admin Gender: Male, Admin Join Date: 2020-04-10, Admin Resign Date: N/A, Admin Type: Moderator, Admin Email: N/A, Admin Mobile: N/A, Admin Status: Inactive', '2020-04-29', '10:10 PM', 'Active', 'Admin'),
(1, 'Deleted Admin Name: b, Admin Designation: ccc, Admin Gender: Female, Admin Join Date: 2020-01-02, Admin Resign Date: N/A, Admin Type: Moderator, Admin Email: N/A, Admin Mobile: N/A, Admin Status: Inactive', '2020-04-29', '10:41 PM', 'Active', 'Admin'),
(1, 'Deleted Admin Name: c, Admin Designation: ddd, Admin Gender: Male, Admin Join Date: 2020-02-02, Admin Resign Date: N/A, Admin Type: Admin, Admin Email: raihan.testing@gmail.com, Admin Mobile: N/A, Admin Status: Active', '2020-04-29', '10:41 PM', 'Active', 'Admin'),
(1, 'Deleted Admin Name: a, Admin Designation: bbb, Admin Gender: Male, Admin Join Date: 2020-01-01, Admin Resign Date: N/A, Admin Type: Admin, Admin Email: N/A, Admin Mobile: N/A, Admin Status: Active', '2020-04-29', '10:41 PM', 'Active', 'Admin'),
(1, 'Deleted Offer Course Title: Algorithm Design and Analysis, Course Code: CSE 221, Course Credit: 3.00, Course Type: Optional II, Offer Semester: 3rd, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 160, Offer Status: Active', '2020-05-01', '08:20 PM', 'Active', 'Course Offer List'),
(1, 'Deleted Course Title: CSE 221, Course Code: 3, Course Credit: 3.00, Course Program: Active, Course Status: Active', '2020-05-01', '08:21 PM', 'Active', 'Course List'),
(1, 'Deleted Offer Course Title: Algorithm Design and Analysis Lab, Course Code: CSE 222, Course Credit: 1.50, Course Type: Compulsory, Offer Semester: 3rd, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 160, Offer Status: Active', '2020-05-01', '08:23 PM', 'Active', 'Course Offer List'),
(1, 'Deleted Course Title: Algorithm Design and Analysis Lab, Course Code: CSE 222, Course Credit: 1.50, Course Program: B.Sc. (Engg.) in CSE, Course Status: Inactive', '2020-05-01', '08:23 PM', 'Active', 'Course List'),
(1, 'Deleted Student Name: Rocksar Sultana Smriti, Student DOB: 1990-07-02, Student Gender: Female, Student Email: N/A, Student Mobile: N/A, Earned Credit: 0, Waived Credit: 0, Student Status: Active', '2020-05-01', '08:38 PM', 'Active', 'Student'),
(1, 'Deleted Student Name: Shamima Khatun, Student DOB: 1990-07-02, Student Gender: Female, Student Email: N/A, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0, Waived Credit: 0, Student Status: Active', '2020-05-02', '04:54 PM', 'Active', 'Student'),
(1, 'Deleted Admin Name: Kuddus, Admin Designation: kuddus, Admin Gender: Male, Admin Join Date: 2020-05-06, Admin Resign Date: N/A, Admin Type: Admin, Admin Email: kkr@kkr.kkr, Admin Mobile: N/A, Admin Status: Active', '2020-05-03', '11:35 PM', 'Active', 'Admin'),
(1, 'Deleted Admin Name: teyj, Admin Designation: erty, Admin Gender: Female, Admin Join Date: 2020-05-04, Admin Resign Date: N/A, Admin Type: Moderator, Admin Email: N/A, Admin Mobile: N/A, Admin Status: Inactive', '2020-05-03', '11:35 PM', 'Active', 'Admin'),
(1, 'Deleted Faculty Name: lihukgjy, Faculty Designation: drjvhbkj, Faculty Gender: Male, Faculty Join Date: 2020-05-04, Faculty Resign Date: N/A, Faculty Department: Law and Justice, Faculty Type: Permanent, Faculty Email: N/A, Faculty Mobile: N/A, Faculty Status: Active', '2020-05-03', '11:38 PM', 'Active', 'Faculty'),
(1, 'Deleted Offer Course Title: Discrete Mathematics, Course Code: CSE 123, Course Credit: 3.00, Course Type: Compulsory, Offer Semester: 1st, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 160, Offer Status: Active', '2020-05-04', '05:18 PM', 'Active', 'Course Offer List'),
(1, 'Deleted Admin Name: tghkj, Admin Designation: jyghbkj, Admin Gender: Male, Admin Join Date: 2020-05-07, Admin Resign Date: N/A, Admin Type: Admin, Admin Email: tguyhk@tgjhbkj.df, Admin Mobile: N/A, Admin Status: Active', '2020-05-05', '05:09 PM', 'Active', 'Admin'),
(1, 'Deleted Result Student ID: 140203020004, Student Name: Pranta Sarkar, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 455, Course Title: Bioinformatics, Semester: Spring 2016, Marks: 30, Grade: F, Grade Point: 0, Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering', '2020-05-06', '08:55 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 140203020004, Student Name: Pranta Sarkar, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 111, Course Title: Fundamentals of Computers, Semester: Spring 2015, Marks: 70, Grade: A-, Grade Point: 3.5, Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering', '2020-05-06', '10:06 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 140203020002, Student Name: Mir Lutfur Rahman, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 211, Course Title: Object Oriented Programming Language, Semester: Spring 2015, Marks: 87, Grade: A+, Grade Point: 4.00, Remarks: , Course Instructor: Al Mehdi Saadat Chowdhury, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-07', '09:49 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 140203020002, Student Name: Mir Lutfur Rahman, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 211, Course Title: Object Oriented Programming Language, Semester: Spring 2015, Marks: 87, Grade: A+, Grade Point: 4.00, Remarks: , Course Instructor: Al Mehdi Saadat Chowdhury, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-07', '10:00 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 140203020002, Student Name: Mir Lutfur Rahman, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 211, Course Title: Object Oriented Programming Language, Semester: Spring 2015, Marks: 87, Grade: A+, Grade Point: 4.00, Remarks: , Course Instructor: Al Mehdi Saadat Chowdhury, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-07', '10:07 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 140203020002, Student Name: Mir Lutfur Rahman, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 211, Course Title: Object Oriented Programming Language, Semester: Spring 2015, Marks: 87, Grade: A+, Grade Point: 4.00, Remarks: , Course Instructor: Al Mehdi Saadat Chowdhury, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-07', '10:22 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 140203020002, Student Name: Mir Lutfur Rahman, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 211, Course Title: Object Oriented Programming Language, Semester: Spring 2015, Marks: 87, Grade: A+, Grade Point: 4.00, Remarks: , Course Instructor: Al Mehdi Saadat Chowdhury, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-07', '10:25 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 140203020002, Student Name: Mir Lutfur Rahman, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 211, Course Title: Object Oriented Programming Language, Semester: Spring 2015, Marks: 87, Grade: A+, Grade Point: 4.00, Remarks: , Course Instructor: Al Mehdi Saadat Chowdhury, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-07', '11:07 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 140203020003, Student Name: Rocksar Sultana Smriti, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 211, Course Title: Object Oriented Programming Language, Semester: Spring 2015, Marks: 65, Grade: B+, Grade Point: 3.25, Remarks: , Course Instructor: Al Mehdi Saadat Chowdhury, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-07', '11:07 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 140203020002, Student Name: Mir Lutfur Rahman, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 113, Course Title: Structured Programming Language, Semester: Summer 2014, Marks: 97, Grade: A+, Grade Point: 4.00, Remarks: MakeUp_MS, Course Instructor: Tasnim Zahan Tithi, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-08', '02:21 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 140203020002, Student Name: Mir Lutfur Rahman, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 211, Course Title: Object Oriented Programming Language, Semester: Spring 2015, Marks: 76, Grade: A, Grade Point: 3.75, Remarks: , Course Instructor: Al Mehdi Saadat Chowdhury, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-08', '08:39 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 140203020003, Student Name: Rocksar Sultana Smriti, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 211, Course Title: Object Oriented Programming Language, Semester: Spring 2015, Marks: 63, Grade: B, Grade Point: 3.00, Remarks: , Course Instructor: Al Mehdi Saadat Chowdhury, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-08', '08:39 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 140203020004, Student Name: Pranta Sarkar, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 211, Course Title: Object Oriented Programming Language, Semester: Spring 2015, Marks: 32, Grade: F, Grade Point: 0.00, Remarks: Incomplete, Course Instructor: Al Mehdi Saadat Chowdhury, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-08', '08:39 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 140203020005, Student Name: Topu Dash Roy, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 211, Course Title: Object Oriented Programming Language, Semester: Spring 2015, Marks: 65, Grade: B+, Grade Point: 3.25, Remarks: , Course Instructor: Al Mehdi Saadat Chowdhury, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-08', '08:40 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 130103020001, Student Name: Muhith Miah, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 313, Course Title: Database System, Semester: Fall 2015, Marks: 30, Grade: F, Grade Point: 0.00, Remarks: , Course Instructor: Mir Lutfur Rahman, Instructor Designation: Lecturer, Department of Computer Science and Engineering, Result Status: Active', '2020-05-08', '08:42 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 140203020002, Student Name: Mir Lutfur Rahman, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 113, Course Title: Structured Programming Language, Semester: Summer 2014, Marks: 97, Grade: A+, Grade Point: 4.00, Remarks: , Course Instructor: Tasnim Zahan Tithi, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-08', '08:49 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 140203020003, Student Name: Rocksar Sultana Smriti, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 314, Course Title: Database System Lab, Semester: Summer 2017, Marks: 45, Grade: C, Grade Point: 2.25, Remarks: MakeUp_MS, Course Instructor: Al Mehdi Saadat Chowdhury, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-08', '08:58 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 140203020004, Student Name: Pranta Sarkar, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 314, Course Title: Database System Lab, Semester: Summer 2017, Marks: 32, Grade: F, Grade Point: 0.00, Remarks: Incomplete, Course Instructor: Al Mehdi Saadat Chowdhury, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-08', '08:58 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 140203020005, Student Name: Topu Dash Roy, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 314, Course Title: Database System Lab, Semester: Summer 2017, Marks: 65, Grade: B+, Grade Point: 3.25, Remarks: , Course Instructor: Al Mehdi Saadat Chowdhury, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Inactive', '2020-05-08', '08:58 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 140203020003, Student Name: Rocksar Sultana Smriti, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 211, Course Title: Object Oriented Programming Language, Semester: Spring 2016, Marks: 75, Grade: A, Grade Point: 3.75, Remarks: Improvement, Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-08', '09:00 PM', 'Active', 'Result'),
(1, 'Deleted Result Student ID: 130103020001, Student Name: Muhith Miah, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 313, Course Title: Database System, Semester: Fall 2016, Marks: 72, Grade: A-, Grade Point: 3.50, Remarks: , Course Instructor: Mir Lutfur Rahman, Instructor Designation: Lecturer, Department of Computer Science and Engineering, Result Status: Active', '2020-05-09', '09:58 PM', 'Active', 'Result');

-- --------------------------------------------------------

--
-- Table structure for table `nr_department`
--

CREATE TABLE `nr_department` (
  `nr_dept_id` bigint(20) NOT NULL,
  `nr_dept_title` varchar(100) NOT NULL,
  `nr_dept_code` varchar(20) NOT NULL,
  `nr_dept_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_department`
--

INSERT INTO `nr_department` (`nr_dept_id`, `nr_dept_title`, `nr_dept_code`, `nr_dept_status`) VALUES
(8, 'Computer Science and Engineering', '3', 'Active'),
(9, 'Business Administration', '2', 'Active'),
(17, 'English', '1', 'Inactive'),
(18, 'Law and Justice', '4', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_department_history`
--

CREATE TABLE `nr_department_history` (
  `nr_dept_id` bigint(20) NOT NULL,
  `nr_admin_id` bigint(20) NOT NULL,
  `nr_depth_task` text NOT NULL,
  `nr_depth_date` varchar(20) NOT NULL,
  `nr_depth_time` varchar(20) NOT NULL,
  `nr_depth_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nr_department_history`
--

INSERT INTO `nr_department_history` (`nr_dept_id`, `nr_admin_id`, `nr_depth_task`, `nr_depth_date`, `nr_depth_time`, `nr_depth_status`) VALUES
(8, 1, 'Added Department Title: Computer Science and Engineering, Department Code: 3, Department Status: Active', '2020-04-21', '06:15 PM', 'Active'),
(9, 1, 'Added Department Title: Business Administration, Department Code: 2, Department Status: Active', '2020-04-21', '06:17 PM', 'Active'),
(9, 1, 'Edited Department Title: Business Administration, Department Code: 2, Department Status: Inactive', '2020-04-21', '06:18 PM', 'Active'),
(9, 1, 'Edited Department Title: Business Administration, Department Code: 2, Department Status: Active', '2020-04-21', '06:22 PM', 'Active'),
(8, 1, 'Edited Department Title: Computer Science and Engineering, Department Code: 3, Department Status: Inactive', '2020-04-21', '06:35 PM', 'Active'),
(8, 1, 'Edited Department Title: Computer Science and Engineering, Department Code: 3, Department Status: Active', '2020-04-21', '06:35 PM', 'Active'),
(17, 1, 'Added Department Title: English, Department Code: 1, Department Status: Inactive', '2020-04-22', '06:25 PM', 'Active'),
(18, 1, 'Added Department Title: Law and Justice, Department Code: 4, Department Status: Active', '2020-04-22', '06:25 PM', 'Active'),
(17, 1, 'Edited Department Title: English P, Department Code: 1, Department Status: Inactive', '2020-04-24', '07:40 PM', 'Active'),
(17, 1, 'Edited Department Title: English, Department Code: 1, Department Status: Inactive', '2020-04-24', '07:44 PM', 'Active'),
(18, 1, 'Edited Department Title: Law and Justice, Department Code: 4, Department Status: Inactive', '2020-04-24', '10:34 PM', 'Active'),
(18, 1, 'Edited Department Title: Law and Justice, Department Code: 4, Department Status: Active', '2020-04-24', '10:35 PM', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_drop`
--

CREATE TABLE `nr_drop` (
  `nr_drop_id` bigint(20) NOT NULL,
  `nr_prcr_id` bigint(20) NOT NULL,
  `nr_prog_id` bigint(20) NOT NULL,
  `nr_course_id` bigint(20) NOT NULL,
  `nr_drop_semester` int(11) NOT NULL,
  `nr_drop_remarks` enum('Compulsory','Optional I','Optional II','Optional III','Optional IV','Optional V') NOT NULL,
  `nr_drop_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nr_drop`
--

INSERT INTO `nr_drop` (`nr_drop_id`, `nr_prcr_id`, `nr_prog_id`, `nr_course_id`, `nr_drop_semester`, `nr_drop_remarks`, `nr_drop_status`) VALUES
(1, 1, 1, 1, 1, 'Compulsory', 'Active'),
(3, 1, 1, 2, 2, 'Compulsory', 'Active'),
(4, 1, 1, 3, 2, 'Compulsory', 'Active'),
(5, 1, 1, 8, 4, 'Compulsory', 'Active'),
(6, 1, 1, 9, 4, 'Compulsory', 'Inactive'),
(8, 1, 1, 6, 5, 'Compulsory', 'Active'),
(9, 1, 1, 4, 3, 'Optional I', 'Active'),
(10, 1, 1, 10, 3, 'Optional I', 'Active'),
(14, 3, 3, 11, 5, 'Compulsory', 'Active'),
(16, 1, 1, 5, 7, 'Compulsory', 'Inactive'),
(24, 1, 1, 7, 1, 'Compulsory', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_drop_history`
--

CREATE TABLE `nr_drop_history` (
  `nr_drop_id` bigint(20) NOT NULL,
  `nr_admin_id` bigint(20) NOT NULL,
  `nr_droph_task` mediumtext NOT NULL,
  `nr_droph_date` varchar(20) NOT NULL,
  `nr_droph_time` varchar(20) NOT NULL,
  `nr_droph_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nr_drop_history`
--

INSERT INTO `nr_drop_history` (`nr_drop_id`, `nr_admin_id`, `nr_droph_task`, `nr_droph_date`, `nr_droph_time`, `nr_droph_status`) VALUES
(10, 1, 'Edited Offer Course Title: Bioinformatics, Course Code: CSE 455, Course Credit: 3.00, Course Type: Optional I, Offer Semester: 3rd, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 160, Offer Status: Inactive', '2020-04-25', '12:40 AM', 'Active'),
(9, 1, 'Edited Offer Course Title: Computer Architecture, Course Code: CSE 311, Course Credit: 3.00, Course Type: Optional I, Offer Semester: 3rd, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 160, Offer Status: Inactive', '2020-04-25', '12:42 AM', 'Active'),
(10, 1, 'Edited Offer Course Title: Bioinformatics, Course Code: CSE 455, Course Credit: 3.00, Course Type: Optional I, Offer Semester: 3rd, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 160, Offer Status: Active', '2020-04-25', '12:43 AM', 'Active'),
(9, 1, 'Edited Offer Course Title: Computer Architecture, Course Code: CSE 311, Course Credit: 3.00, Course Type: Optional I, Offer Semester: 3rd, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 160, Offer Status: Active', '2020-04-25', '12:44 AM', 'Active'),
(5, 1, 'Edited Offer Course Title: Object Oriented Programming Language, Course Code: CSE 211, Course Credit: 3.00, Course Type: Compulsory, Offer Semester: 4th, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 160, Offer Status: Inactive', '2020-04-25', '12:45 AM', 'Active'),
(5, 1, 'Edited Offer Course Title: Object Oriented Programming Language, Course Code: CSE 211, Course Credit: 3.00, Course Type: Compulsory, Offer Semester: 12th, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 160, Offer Status: Active', '2020-04-25', '12:47 AM', 'Active'),
(5, 1, 'Edited Offer Course Title: Object Oriented Programming Language, Course Code: CSE 211, Course Credit: 3.00, Course Type: Optional II, Offer Semester: 12th, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 160, Offer Status: Active', '2020-04-25', '12:47 AM', 'Active'),
(5, 1, 'Edited Offer Course Title: Object Oriented Programming Language, Course Code: CSE 211, Course Credit: 3.00, Course Type: Compulsory, Offer Semester: 4th, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 160, Offer Status: Active', '2020-04-25', '12:48 AM', 'Active'),
(14, 1, 'Added Course Title: Cost Management and Accounting, Course Code: BBA 201, Course Credit: 3.00, Course Type: Compulsory, Offer Semester: 5, Offer Program: BBA, Program Credit: 127, Offer Status: Active', '2020-04-25', '04:45 PM', 'Active'),
(16, 1, 'Added Course Title: Database System, Course Code: CSE 313, Course Credit: 3.00, Course Type: Compulsory, Offer Semester: 7, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 160, Offer Status: Inactive', '2020-04-25', '09:01 PM', 'Active'),
(6, 1, 'Edited Offer Course Title: Object Oriented Programming Language Lab, Course Code: CSE 212, Course Credit: 1.50, Course Type: Compulsory, Offer Semester: 4th, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 160, Offer Status: Inactive', '2020-04-28', '03:42 PM', 'Active'),
(24, 1, 'Added Course Title: Discrete Mathematics, Course Code: CSE 123, Course Credit: 3.00, Course Type: Compulsory, Offer Semester: 1, Offer Program: B.Sc. (Engg.) in CSE, Program Credit: 160, Offer Status: Active', '2020-05-04', '08:12 PM', 'Active');

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
(1, 'Noushad Sojib', 'Assistant Professor', '2016-04-20', '', 'Permanent', 8, 'rps95d71c0c3e667dcc7b3e0a5b8f368c3aceb6ef42rps', 'mlrahman@neub.edu.bd', '01739213886', '158677029315867702938237.jpg', 'Active', 0, 'Male'),
(3, 'Tasnim Zahan Tithi', 'Assistant Professor', '2014-01-15', '', 'Permanent', 8, 'rps95d71c0c3e667dcc7b3e0a5b8f368c3aceb6ef42rps', 'tithi@gml.com', '01711224455', '', 'Active', 0, 'Female'),
(4, 'Mir Lutfur Rahman', 'Lecturer', '2018-05-26', '', 'Adjunct', 8, 'rps95d71c0c3e667dcc7b3e0a5b8f368c3aceb6ef42rps', 'raihan.testing@gmial.com', '01739213886', '', 'Active', 0, 'Male'),
(5, 'Pranta Sarker', 'Lecturer', '2018-05-26', '', 'Permanent', 8, 'rps95d71c0c3e667dcc7b3e0a5b8f368c3aceb6ef42rps', 'ps@ne', '01680929776', '', 'Active', 0, 'Male'),
(9, 'Al Mehdi Saadat Chowdhury', 'Assistant Professor', '2013-11-24', '', 'Permanent', 8, '', 'mirlutfur.rahman@gmail.com', '', '', 'Active', 0, 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `nr_faculty_history`
--

CREATE TABLE `nr_faculty_history` (
  `nr_faculty_id` bigint(20) NOT NULL,
  `nr_admin_id` bigint(20) NOT NULL,
  `nr_facultyh_task` mediumtext NOT NULL,
  `nr_facultyh_date` varchar(20) NOT NULL,
  `nr_facultyh_time` varchar(20) NOT NULL,
  `nr_facultyh_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nr_faculty_history`
--

INSERT INTO `nr_faculty_history` (`nr_faculty_id`, `nr_admin_id`, `nr_facultyh_task`, `nr_facultyh_date`, `nr_facultyh_time`, `nr_facultyh_status`) VALUES
(4, 1, 'Edited Faculty Name: Mir Lutfur Rahman, Faculty Designation: Lecturer, Faculty Gender: Male, Faculty Join Date: 2018-05-26, Faculty Resign Date: , Faculty Department: Computer Science and Engineering, Faculty Type: Permanent, Faculty Email: raihan.testing@gmial.com, Faculty Mobile: 01739213886, Faculty Status: Active', '2020-04-27', '12:47 AM', 'Active'),
(4, 1, 'Edited Faculty Name: Mir Lutfur Rahman, Faculty Designation: Lecturer, Faculty Gender: Male, Faculty Join Date: 2018-05-26, Faculty Resign Date: , Faculty Department: Computer Science and Engineering, Faculty Type: Adjunct, Faculty Email: raihan.testing@gmial.com, Faculty Mobile: 01739213886, Faculty Status: Active', '2020-04-27', '12:47 AM', 'Active'),
(3, 1, 'Edited Faculty Name: Tasnim Zahan Tithi, Faculty Designation: Assistant Professor, Faculty Gender: Female, Faculty Join Date: 2014-01-15, Faculty Resign Date: , Faculty Department: Computer Science and Engineering, Faculty Type: Permanent, Faculty Email: tithi@gml.com, Faculty Mobile: 01711224455, Faculty Status: Inactive', '2020-04-27', '12:48 AM', 'Active'),
(5, 1, 'Edited Faculty Name: Pranta Sarker, Faculty Designation: Lecturer, Faculty Gender: Male, Faculty Join Date: 2018-05-26, Faculty Resign Date: , Faculty Department: Computer Science and Engineering, Faculty Type: Permanent, Faculty Email: ps@ne, Faculty Mobile: 01680929776, Faculty Status: Active', '2020-04-27', '04:07 PM', 'Active'),
(1, 1, 'Edited Faculty Name: Noushad Sojib, Faculty Designation: Assistant Professor, Faculty Gender: Male, Faculty Join Date: 2016-04-20, Faculty Resign Date: , Faculty Department: Computer Science and Engineering, Faculty Type: Permanent, Faculty Email: mirlutfur.rahman@gmail.com, Faculty Mobile: 01739213886, Faculty Status: Active', '2020-04-27', '05:47 PM', 'Active'),
(1, 1, 'Edited Faculty Name: Noushad Sojib, Faculty Designation: Assistant Professor, Faculty Gender: Male, Faculty Join Date: 2016-04-20, Faculty Resign Date: , Faculty Department: Computer Science and Engineering, Faculty Type: Permanent, Faculty Email: mlrahman@neub.edu.bd, Faculty Mobile: 01739213886, Faculty Status: Active', '2020-04-27', '05:49 PM', 'Active'),
(1, 1, 'Edited Faculty Name: Noushad Sojib, Faculty Designation: Assistant Professor, Faculty Gender: Male, Faculty Join Date: 2016-04-20, Faculty Resign Date: , Faculty Department: Computer Science and Engineering, Faculty Type: Permanent, Faculty Email: mirlutfur.rahman@gmail.com, Faculty Mobile: 01739213886, Faculty Status: Active', '2020-04-27', '05:52 PM', 'Active'),
(1, 1, 'Edited Faculty Name: Noushad Sojib, Faculty Designation: Assistant Professor, Faculty Gender: Male, Faculty Join Date: 2016-04-20, Faculty Resign Date: , Faculty Department: Computer Science and Engineering, Faculty Type: Permanent, Faculty Email: mlrahman@neub.edu.bd, Faculty Mobile: 01739213886, Faculty Status: Active', '2020-04-27', '05:57 PM', 'Active'),
(3, 1, 'Edited Faculty Name: Tasnim Zahan Tithi, Faculty Designation: Assistant Professor, Faculty Gender: Female, Faculty Join Date: 2014-01-15, Faculty Resign Date: , Faculty Department: Computer Science and Engineering, Faculty Type: Permanent, Faculty Email: tithi@gml.com, Faculty Mobile: 01711224455, Faculty Status: Active', '2020-04-27', '06:11 PM', 'Active'),
(1, 1, 'Edited Faculty Name: Noushad Sojib, Faculty Designation: Assistant Professor, Faculty Gender: Male, Faculty Join Date: 2016-04-20, Faculty Resign Date: , Faculty Department: Computer Science and Engineering, Faculty Type: Permanent, Faculty Email: mlrahman@neub.edu.bd, Faculty Mobile: 01739213886, Faculty Status: Inactive', '2020-04-27', '06:11 PM', 'Active'),
(1, 1, 'Edited Faculty Name: Noushad Sojib, Faculty Designation: Assistant Professor, Faculty Gender: Male, Faculty Join Date: 2016-04-20, Faculty Resign Date: , Faculty Department: Computer Science and Engineering, Faculty Type: Permanent, Faculty Email: mlrahman@neub.edu.bd, Faculty Mobile: 01739213886, Faculty Status: Active', '2020-04-27', '06:11 PM', 'Active'),
(9, 1, 'Added Faculty Name: Al Mehdi Saadat Chowdhury, Faculty Designation: Assistant Professor, Faculty Gender: Male, Faculty Join Date: 2013-11-24, Faculty Resign Date: , Faculty Department: Business Administration, Faculty Type: Permanent, Faculty Email: mirlutfur.rahman@gmail.com, Faculty Mobile: , Faculty Status: Active', '2020-04-27', '07:56 PM', 'Active'),
(9, 1, 'Edited Faculty Name: Al Mehdi Saadat Chowdhury, Faculty Designation: Assistant Professor, Faculty Gender: Male, Faculty Join Date: 2013-11-24, Faculty Resign Date: , Faculty Department: Computer Science and Engineering, Faculty Type: Permanent, Faculty Email: mirlutfur.rahman@gmail.com, Faculty Mobile: , Faculty Status: Active', '2020-04-27', '07:58 PM', 'Active'),
(1, 1, 'Edited Faculty Name: Noushad Sojib, Faculty Designation: Assistant Professor, Faculty Gender: Male, Faculty Join Date: 2016-04-20, Faculty Resign Date: , Faculty Department: Computer Science and Engineering, Faculty Type: Permanent, Faculty Email: mlrahman@neub.edu.bd, Faculty Mobile: 01739213886, Faculty Status: Inactive', '2020-05-10', '05:12 PM', 'Active'),
(1, 1, 'Edited Faculty Name: Noushad Sojib, Faculty Designation: Assistant Professor, Faculty Gender: Male, Faculty Join Date: 2016-04-20, Faculty Resign Date: , Faculty Department: Computer Science and Engineering, Faculty Type: Permanent, Faculty Email: mlrahman@neub.edu.bd, Faculty Mobile: 01739213886, Faculty Status: Active', '2020-05-10', '05:12 PM', 'Active');

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

--
-- Dumping data for table `nr_faculty_link_token`
--

INSERT INTO `nr_faculty_link_token` (`nr_faculty_id`, `nr_falito_token`, `nr_falito_type`, `nr_falito_date`, `nr_falito_time`, `nr_falito_status`) VALUES
(9, 'e3f9005ebd2c8acceda5cd259132213f6d8841e5', 'Forget Password', '2020-04-27', '07:56 PM', 'Active');

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
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:03 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:08 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:15 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:26 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '07:08 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '07:10 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '07:11 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '08:27 PM', 'Inactive'),
(1, '192.168.0.102', 'Bangladesh', 'Sylhet', '24.896670', '91.871670', 'N/A', '2020-04-14', '11:38 PM', 'Inactive'),
(3, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '04:40 PM', 'Inactive'),
(4, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '04:41 PM', 'Inactive'),
(5, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '04:42 PM', 'Inactive'),
(4, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '04:42 PM', 'Inactive'),
(5, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '04:43 PM', 'Inactive'),
(4, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '06:29 PM', 'Inactive'),
(4, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '07:56 PM', 'Inactive'),
(4, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-16', '08:28 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-19', '09:16 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-19', '09:29 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-20', '03:46 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-21', '09:35 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-22', '11:51 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-23', '03:16 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-24', '05:00 PM', 'Inactive'),
(5, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-24', '05:07 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-24', '06:00 PM', 'Inactive'),
(5, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-24', '06:17 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-24', '06:18 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-24', '06:25 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-25', '09:26 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-26', '04:00 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-30', '04:10 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:40 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '03:07 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '11:32 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '01:09 AM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '01:37 AM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-09', '06:06 PM', 'Inactive'),
(1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '05:10 PM', 'Active');

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
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:48 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:51 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:51 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '07:55 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '08:25 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:16 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '09:37 PM', 'Active'),
(140203020004, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '09:44 PM', 'Active'),
(140203020004, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '10:35 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:36 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:42 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:47 PM', 'Active'),
(140203020009, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:51 PM', 'Active'),
(140203020004, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:05 PM', 'Active'),
(140203020004, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-25', '09:26 PM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '01:09 AM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '01:13 AM', 'Active'),
(140203020003, 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '01:16 AM', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_program`
--

CREATE TABLE `nr_program` (
  `nr_prog_id` bigint(20) NOT NULL,
  `nr_prog_title` varchar(100) NOT NULL,
  `nr_prog_code` varchar(20) NOT NULL,
  `nr_dept_id` bigint(20) NOT NULL,
  `nr_prog_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_program`
--

INSERT INTO `nr_program` (`nr_prog_id`, `nr_prog_title`, `nr_prog_code`, `nr_dept_id`, `nr_prog_status`) VALUES
(1, 'B.Sc. (Engg.) in CSE', '2', 8, 'Active'),
(3, 'BBA', '4', 9, 'Active'),
(11, 'LLB', '5', 18, 'Active'),
(12, 'LLM', '6', 18, 'Inactive');

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
(3, 3, 127, '2020-04-11', '', 'Active'),
(13, 11, 117, '2020-04-23', '', 'Active'),
(14, 12, 28, '2020-04-23', '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_program_history`
--

CREATE TABLE `nr_program_history` (
  `nr_prog_id` bigint(20) NOT NULL,
  `nr_admin_id` bigint(20) NOT NULL,
  `nr_progh_task` text NOT NULL,
  `nr_progh_date` varchar(20) NOT NULL,
  `nr_progh_time` varchar(20) NOT NULL,
  `nr_progh_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nr_program_history`
--

INSERT INTO `nr_program_history` (`nr_prog_id`, `nr_admin_id`, `nr_progh_task`, `nr_progh_date`, `nr_progh_time`, `nr_progh_status`) VALUES
(1, 1, 'Edited Program Title: B.Sc. (Engg.) in CSE, Program Code: 2, Program Credit: 160, Program Department: Computer Science and Engineering, Program Status: Active', '2020-04-23', '03:21 PM', 'Active'),
(1, 1, 'Edited Program Title: B.Sc. (Engg.) in CSE, Program Code: 2, Program Credit: 13.5, Program Department: Computer Science and Engineering, Program Status: Active', '2020-04-23', '03:26 PM', 'Active'),
(1, 1, 'Edited Program Title: B.Sc. (Engg.) in CSE, Program Code: 2, Program Credit: 160, Program Department: Computer Science and Engineering, Program Status: Active', '2020-04-23', '03:28 PM', 'Active'),
(11, 1, 'Added program Title: LLB, program Code: 5, Program Credit: 117, Program Department: Law and Justice, program Status: Active', '2020-04-23', '04:35 PM', 'Active'),
(12, 1, 'Added program Title: LLM, program Code: 6, Program Credit: 28, Program Department: Law and Justice, program Status: Inactive', '2020-04-23', '04:35 PM', 'Active');

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
(14, 150102040001, 11, 150102050811.5, '7ef3e0319886c4c2e914979903461b0e24eb9685', 150102046811.5, 'Summer', 2015, '', 'Inactive', 3, '2020-04-11', 1),
(29, 140203020003, 5, 140203029013.5, '2b604cffbcab0643173c2aaceeb57e147d272c96', 140203025813.5, 'Summer', 2017, '', 'Active', 1, '2020-05-08', 1),
(35, 140203020003, 6, 140203029813.5, 'd0ccd6b615a4424e4058ef8cc0e167be09f6a2e0', 140203026313.5, 'Summer', 2017, '', 'Active', 1, '2020-05-09', 4),
(36, 140303020001, 5, 140303030011.5, '1525d714a8983cba6b0df8026b554e01e4e299be', 140303026311.5, 'Spring', 2016, '', 'Active', 1, '2020-05-10', 9),
(37, 140303020008, 5, 140303028218.5, 'ebadc959a62bd4ed8a1639b1b6c4001a5896bb39', 140303025318.5, 'Spring', 2016, '', 'Active', 1, '2020-05-10', 9);

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
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:12 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:12 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:15 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:16 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:16 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:19 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:19 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:20 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-27', '10:20 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-29', '10:17 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-30', '10:42 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:52 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:53 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:54 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:56 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '01:58 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '02:00 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '02:01 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-03-31', '02:01 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:06 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:09 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:12 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:27 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:30 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:31 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-12', '02:35 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:45 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:46 PM', 'Active'),
(150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:49 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:50 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:51 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:57 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:01 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:51 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:51 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-17', '03:24 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-17', '03:49 PM', 'Active'),
(140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-17', '03:49 PM', 'Active'),
(140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-25', '09:26 PM', 'Active'),
(130103020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-07', '04:02 PM', 'Active'),
(130103020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-07', '04:05 PM', 'Active'),
(130103020002, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-07', '04:06 PM', 'Active'),
(140203020003, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '01:20 AM', 'Active'),
(140203020003, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '01:24 AM', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_result_history`
--

CREATE TABLE `nr_result_history` (
  `nr_result_id` bigint(20) NOT NULL,
  `nr_admin_id` bigint(20) NOT NULL,
  `nr_resulth_task` mediumtext NOT NULL,
  `nr_resulth_date` varchar(20) NOT NULL,
  `nr_resulth_time` varchar(20) NOT NULL,
  `nr_resulth_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nr_result_history`
--

INSERT INTO `nr_result_history` (`nr_result_id`, `nr_admin_id`, `nr_resulth_task`, `nr_resulth_date`, `nr_resulth_time`, `nr_resulth_status`) VALUES
(14, 1, 'Updated Result Student ID: 150102040001, Student Name: Rahat Mahmud, Program: BBA, Course Code: BBA 201, Course Title: Cost Management and Accounting, Semester: Summer 2015, Marks: 70, Grade: A-, Grade Point: -150252144.85431, Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Inactive', '2020-05-06', '11:14 PM', 'Active'),
(14, 1, 'Updated Result Student ID: 150102040001, Student Name: Rahat Mahmud, Program: BBA, Course Code: BBA 201, Course Title: Cost Management and Accounting, Semester: Summer 2015, Marks: 70, Grade: A-, Grade Point: 3.5, Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-06', '11:33 PM', 'Active'),
(14, 1, 'Updated Result Student ID: 150102040001, Student Name: Rahat Mahmud, Program: BBA, Course Code: BBA 201, Course Title: Cost Management and Accounting, Semester: Summer 2015, Marks: 70, Grade: A-, Grade Point: 3.5, Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-06', '11:44 PM', 'Active'),
(14, 1, 'Updated Result Student ID: 150102040001, Student Name: Rahat Mahmud, Program: BBA, Course Code: BBA 201, Course Title: Cost Management and Accounting, Semester: Summer 2015, Marks: 70, Grade: A-, Grade Point: 3.5, Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-06', '11:46 PM', 'Active'),
(14, 1, 'Updated Result Student ID: 150102040001, Student Name: Rahat Mahmud, Program: BBA, Course Code: BBA 201, Course Title: Cost Management and Accounting, Semester: Summer 2015, Marks: 70, Grade: A-, Grade Point: 3.5, Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-06', '11:48 PM', 'Active'),
(14, 1, 'Updated Result Student ID: 150102040001, Student Name: Rahat Mahmud, Program: BBA, Course Code: BBA 201, Course Title: Cost Management and Accounting, Semester: Summer 2015, Marks: 70, Grade: A-, Grade Point: 3.5, Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-06', '11:49 PM', 'Active'),
(14, 1, 'Updated Result Student ID: 150102040001, Student Name: Rahat Mahmud, Program: BBA, Course Code: BBA 201, Course Title: Cost Management and Accounting, Semester: Summer 2015, Marks: 70, Grade: A-, Grade Point: 3.5, Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-06', '11:53 PM', 'Active'),
(14, 1, 'Updated Result Student ID: 150102040001, Student Name: Rahat Mahmud, Program: BBA, Course Code: BBA 201, Course Title: Cost Management and Accounting, Semester: Summer 2015, Marks: 90, Grade: A+, Grade Point: 4, Remarks: , Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-07', '12:04 AM', 'Active'),
(14, 1, 'Updated Result Student ID: 150102040001, Student Name: Rahat Mahmud, Program: BBA, Course Code: BBA 201, Course Title: Cost Management and Accounting, Semester: Summer 2015, Marks: 69, Grade: B+, Grade Point: 3.25, Remarks: , Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-07', '03:56 PM', 'Active'),
(29, 1, 'Added Result Student ID: 140203020003, Student Name: Rocksar Sultana Smriti, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 313, Course Title: Database System, Semester: Summer 2017, Marks: 32, Grade: F, Grade Point: 0.00, Remarks: Incomplete, Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-08', '03:19 PM', 'Active'),
(29, 1, 'Updated Result Student ID: 140203020003, Student Name: , Program: B.Sc. (Engg.) in CSE, Course Code: CSE 313, Course Title: Database System, Semester: Summer 2017, Marks: 55, Grade: B-, Grade Point: 2.75, Remarks: MakeUp_MS_SF, Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-09', '09:45 PM', 'Active'),
(14, 1, 'Updated Result Student ID: 150102040001, Student Name: , Program: BBA, Course Code: BBA 201, Course Title: Cost Management and Accounting, Semester: Summer 2015, Marks: 80, Grade: A+, Grade Point: 4.00, Remarks: , Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Inactive', '2020-05-09', '09:45 PM', 'Active'),
(29, 1, 'Updated Result Student ID: 140203020003, Student Name: Rocksar Sultana Smriti, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 313, Course Title: Database System, Semester: Summer 2017, Marks: 47, Grade: C, Grade Point: 2.25, Remarks: MakeUp_MS_SF, Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-09', '09:53 PM', 'Active'),
(35, 1, 'Added Result Student ID: 140203020003, Student Name: Rocksar Sultana Smriti, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 314, Course Title: Database System Lab, Semester: Summer 2017, Marks: 56, Grade: B-, Grade Point: 2.75, Remarks: , Course Instructor: Mir Lutfur Rahman, Instructor Designation: Lecturer, Department of Computer Science and Engineering, Result Status: Active', '2020-05-09', '11:10 PM', 'Active'),
(29, 1, 'Updated Result Student ID: 140203020003, Student Name: Rocksar Sultana Smriti, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 313, Course Title: Database System, Semester: Summer 2017, Marks: 72, Grade: A-, Grade Point: 3.50, Remarks: MakeUp_MS, Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-09', '11:14 PM', 'Active'),
(35, 1, 'Updated Result Student ID: 140203020003, Student Name: Rocksar Sultana Smriti, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 314, Course Title: Database System Lab, Semester: Summer 2017, Marks: 61, Grade: B, Grade Point: 3.00, Remarks: MakeUp_SF, Course Instructor: Mir Lutfur Rahman, Instructor Designation: Lecturer, Department of Computer Science and Engineering, Result Status: Active', '2020-05-09', '11:14 PM', 'Active'),
(29, 1, 'Updated Result Student ID: 140203020003, Student Name: Rocksar Sultana Smriti, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 313, Course Title: Database System, Semester: Summer 2017, Marks: 30, Grade: F, Grade Point: 0.00, Remarks: , Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-09', '11:18 PM', 'Active'),
(35, 1, 'Updated Result Student ID: 140203020003, Student Name: Rocksar Sultana Smriti, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 314, Course Title: Database System Lab, Semester: Summer 2017, Marks: 40, Grade: D, Grade Point: 2.00, Remarks: , Course Instructor: Mir Lutfur Rahman, Instructor Designation: Lecturer, Department of Computer Science and Engineering, Result Status: Active', '2020-05-09', '11:18 PM', 'Active'),
(29, 1, 'Updated Result Student ID: 140203020003, Student Name: Rocksar Sultana Smriti, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 313, Course Title: Database System, Semester: Summer 2017, Marks: 62, Grade: B, Grade Point: 3.00, Remarks: , Course Instructor: Noushad Sojib, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-09', '11:24 PM', 'Active'),
(35, 1, 'Updated Result Student ID: 140203020003, Student Name: Rocksar Sultana Smriti, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 314, Course Title: Database System Lab, Semester: Summer 2017, Marks: 70, Grade: A-, Grade Point: 3.50, Remarks: , Course Instructor: Mir Lutfur Rahman, Instructor Designation: Lecturer, Department of Computer Science and Engineering, Result Status: Active', '2020-05-09', '11:24 PM', 'Active'),
(36, 6, 'Added Result Student ID: 140303020001, Student Name: Syed Ahsan Sirat, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 313, Course Title: Database System, Semester: Spring 2016, Marks: 72, Grade: A-, Grade Point: 3.50, Remarks: , Course Instructor: Al Mehdi Saadat Chowdhury, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-10', '08:08 PM', 'Active'),
(37, 6, 'Added Result Student ID: 140303020008, Student Name: Abad Khan, Program: B.Sc. (Engg.) in CSE, Course Code: CSE 313, Course Title: Database System, Semester: Spring 2016, Marks: 54, Grade: C+, Grade Point: 2.50, Remarks: , Course Instructor: Al Mehdi Saadat Chowdhury, Instructor Designation: Assistant Professor, Department of Computer Science and Engineering, Result Status: Active', '2020-05-10', '08:12 PM', 'Active');

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
(130103020001, 'Muhith Miah', '1993-01-01', 'Male', '', '01712345611', '', 1, 1, 'Inactive'),
(130103020002, 'Farjana Rahman', '1994-01-01', 'Female', 'fkk@hj.kk', '', '', 1, 1, 'Active'),
(140203020001, 'Humaira Ahmed Joti', '1990-01-01', 'Female', '', '', '', 1, 1, 'Active'),
(140203020002, 'Mir Lutfur Rahman', '1996-07-04', 'Male', 'mlrahman@neub.edu.bd', '', '158841812715884181276265.jpg', 1, 1, 'Active'),
(140203020003, 'Rocksar Sultana Smriti', '1995-01-09', 'Female', 'mirlutfur.rahman@gmail.com', '', '', 1, 1, 'Active'),
(140203020004, 'Pranta Sarkar', '1990-07-02', 'Male', 'mirlutfur.rahman@gmail.com', '', '', 1, 1, 'Active'),
(140203020005, 'Topu Dash Roy', '1994-12-31', 'Male', 'topucse05@gmail.com', '', '', 1, 1, 'Active'),
(140203020009, 'Nusrat Hoque', '1990-07-02', 'Female', '', '', '', 1, 1, 'Active'),
(140303020001, 'Syed Ahsan Sirat', '1990-01-01', 'Male', '', '', '', 1, 1, 'Active'),
(140303020008, 'Abad Khan', '1992-01-01', 'Male', '', '', '', 1, 1, 'Active'),
(150102040001, 'Rahat Mahmud', '1994-07-02', 'Male', 'mirlutfur.rahman@gmail.com', '', '', 3, 3, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_student_history`
--

CREATE TABLE `nr_student_history` (
  `nr_stud_id` bigint(20) NOT NULL,
  `nr_admin_id` bigint(20) NOT NULL,
  `nr_studh_task` mediumtext NOT NULL,
  `nr_studh_date` varchar(20) NOT NULL,
  `nr_studh_time` varchar(20) NOT NULL,
  `nr_studh_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nr_student_history`
--

INSERT INTO `nr_student_history` (`nr_stud_id`, `nr_admin_id`, `nr_studh_task`, `nr_studh_date`, `nr_studh_time`, `nr_studh_status`) VALUES
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: , Student Gender: Male, Student Email: , Student Mobile: , Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 3.11, Earned Credit: 13.50, Waived Credit: 0.00, Student Status: Active', '2020-05-02', '04:08 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: , Student Mobile: , Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 3.11, Earned Credit: 13.50, Waived Credit: 0.00, Student Status: Active', '2020-05-02', '04:25 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: , Student Mobile: , Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 3.11, Earned Credit: 13.50, Waived Credit: 0.00, Student Status: Active', '2020-05-02', '04:41 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: N/A, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 3.11, Earned Credit: 13.50, Waived Credit: 0.00, Student Status: Active', '2020-05-02', '04:47 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mirlutfur.rahman@gmail.com, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 3.11, Earned Credit: 13.50, Waived Credit: 0.00, Student Status: Active', '2020-05-02', '04:57 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mirlutfur.rahman@gmail.com, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 3.11, Earned Credit: 13.50, Waived Credit: 0.00, Student Status: Active', '2020-05-02', '05:01 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mirlutfur.rahman@gmail.com, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 3.11, Earned Credit: 13.50, Waived Credit: 0.00, Student Status: Active', '2020-05-02', '05:03 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mirlutfur.rahman@gmail.com, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 3.11, Earned Credit: 13.50, Waived Credit: 0.00, Student Status: Active', '2020-05-02', '05:04 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mirlutfur.rahman@gmail.com, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Active', '2020-05-02', '05:06 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: BBA, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Active', '2020-05-02', '05:12 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: BBA, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Active', '2020-05-02', '05:13 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: BBA, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Active', '2020-05-02', '05:13 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Active', '2020-05-02', '05:15 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Inactive', '2020-05-02', '05:15 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Active', '2020-05-02', '05:18 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Inactive', '2020-05-02', '05:19 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: BBA, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Active', '2020-05-02', '05:27 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Active', '2020-05-02', '05:27 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Inactive', '2020-05-02', '11:38 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Active', '2020-05-02', '11:39 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Inactive', '2020-05-02', '11:40 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Active', '2020-05-02', '11:41 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: , Student DOB: , Student Gender: , Student Email: N/A, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 3.00, Student Status: ', '2020-05-03', '12:24 AM', 'Active'),
(140203020002, 1, 'Edited Student Name: , Student DOB: Mir Lutfur Rahman, Student Gender: 1996-07-02, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 4.50, Student Status: Active', '2020-05-03', '12:28 AM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Active, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 7.50, Student Status: ', '2020-05-03', '12:30 AM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 10.50, Student Status: Active', '2020-05-03', '12:32 AM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 13.50, Student Status: Active', '2020-05-03', '12:33 AM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 16.50, Student Status: Active', '2020-05-03', '12:34 AM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 15.00, Student Status: Active', '2020-05-03', '01:22 AM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 12.00, Student Status: Active', '2020-05-03', '01:25 AM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 9.00, Student Status: Active', '2020-05-03', '01:26 AM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-02, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 6.00, Student Status: Active', '2020-05-03', '01:50 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-04, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 6.00, Student Status: Active', '2020-05-03', '02:56 PM', 'Active'),
(140203020003, 1, 'Added Student Name: Rocksar Sultana Smriti, Student DOB: 1995-01-09, Student Gender: Female, Student Email: mirlutfur.rahman@gmail.com, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Active', '2020-05-03', '03:20 PM', 'Active'),
(130103020001, 1, 'Added Student Name: Muhith Miah, Student DOB: 1993-01-01, Student Gender: Male, Student Email: N/A, Student Mobile: 01712345611, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Inactive', '2020-05-03', '11:11 PM', 'Active'),
(130103020002, 1, 'Added Student Name: Farjana Rahman, Student DOB: 1994-01-01, Student Gender: Female, Student Email: N/A, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Active', '2020-05-03', '11:11 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-04, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 9.00, Student Status: Active', '2020-05-04', '06:58 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-04, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 12.00, Student Status: Active', '2020-05-04', '07:54 PM', 'Active'),
(130103020002, 1, 'Edited Student Name: Farjana Rahman, Student DOB: 1994-01-01, Student Gender: Female, Student Email: fkk@hj.kk, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Active', '2020-05-07', '04:20 PM', 'Active'),
(130103020001, 1, 'Edited Student Name: Muhith Miah, Student DOB: 1993-01-01, Student Gender: Male, Student Email: N/A, Student Mobile: 01712345611, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 3.00, Student Status: Inactive', '2020-05-07', '07:19 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-04, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 9.00, Student Status: Active', '2020-05-07', '11:17 PM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-04, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 4.00, Earned Credit: 3.00, Waived Credit: 10.50, Student Status: Active', '2020-05-08', '12:06 AM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-04, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 4.00, Earned Credit: 3.00, Waived Credit: 9.00, Student Status: Active', '2020-05-08', '12:08 AM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-04, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 4.00, Earned Credit: 3.00, Waived Credit: 10.50, Student Status: Active', '2020-05-08', '12:12 AM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-04, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 4.00, Earned Credit: 3.00, Waived Credit: 9.00, Student Status: Active', '2020-05-08', '12:14 AM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-04, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 4.00, Earned Credit: 3.00, Waived Credit: 12.00, Student Status: Active', '2020-05-08', '12:15 AM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-04, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 4.00, Earned Credit: 3.00, Waived Credit: 9.00, Student Status: Active', '2020-05-08', '12:18 AM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-04, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 4.00, Earned Credit: 3.00, Waived Credit: 12.00, Student Status: Active', '2020-05-08', '12:39 AM', 'Active'),
(140203020003, 1, 'Edited Student Name: Rocksar Sultana Smriti, Student DOB: 1995-01-09, Student Gender: Female, Student Email: mirlutfur.rahman@gmail.com, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 3.75, Earned Credit: 3.00, Waived Credit: 3.00, Student Status: Active', '2020-05-08', '12:52 AM', 'Active'),
(140203020003, 1, 'Edited Student Name: Rocksar Sultana Smriti, Student DOB: 1995-01-09, Student Gender: Female, Student Email: mirlutfur.rahman@gmail.com, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 3.75, Earned Credit: 3.00, Waived Credit: 6.00, Student Status: Active', '2020-05-08', '12:52 AM', 'Active'),
(140203020003, 1, 'Edited Student Name: Rocksar Sultana Smriti, Student DOB: 1995-01-09, Student Gender: Female, Student Email: mirlutfur.rahman@gmail.com, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 3.75, Earned Credit: 3.00, Waived Credit: 7.50, Student Status: Active', '2020-05-08', '12:52 AM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-04, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 4.00, Earned Credit: 3.00, Waived Credit: 13.50, Student Status: Active', '2020-05-08', '12:52 AM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-04, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 4.00, Earned Credit: 3.00, Waived Credit: 15.00, Student Status: Active', '2020-05-08', '12:52 AM', 'Active'),
(140203020002, 1, 'Edited Student Name: Mir Lutfur Rahman, Student DOB: 1996-07-04, Student Gender: Male, Student Email: mlrahman@neub.edu.bd, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 3.75, Earned Credit: 3.00, Waived Credit: 12.00, Student Status: Active', '2020-05-08', '02:05 PM', 'Active'),
(130103020002, 6, 'Edited Student Name: Farjana Rahman, Student DOB: 1994-01-01, Student Gender: Female, Student Email: fkk@hj.kk, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 3.00, Student Status: Active', '2020-05-10', '02:15 PM', 'Active'),
(130103020001, 1, 'Edited Student Name: Muhith Miah, Student DOB: 1993-01-01, Student Gender: Male, Student Email: N/A, Student Mobile: 01712345611, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 4.50, Student Status: Inactive', '2020-05-10', '04:12 PM', 'Active'),
(130103020001, 1, 'Edited Student Name: Muhith Miah, Student DOB: 1993-01-01, Student Gender: Male, Student Email: N/A, Student Mobile: 01712345611, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 6.00, Student Status: Inactive', '2020-05-10', '04:13 PM', 'Active'),
(130103020001, 1, 'Edited Student Name: Muhith Miah, Student DOB: 1993-01-01, Student Gender: Male, Student Email: N/A, Student Mobile: 01712345611, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 3.00, Student Status: Inactive', '2020-05-10', '04:15 PM', 'Active'),
(130103020001, 1, 'Edited Student Name: Muhith Miah, Student DOB: 1993-01-01, Student Gender: Male, Student Email: N/A, Student Mobile: 01712345611, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 1.50, Student Status: Inactive', '2020-05-10', '04:15 PM', 'Active'),
(130103020001, 1, 'Edited Student Name: Muhith Miah, Student DOB: 1993-01-01, Student Gender: Male, Student Email: N/A, Student Mobile: 01712345611, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Inactive', '2020-05-10', '04:15 PM', 'Active'),
(130103020001, 1, 'Edited Student Name: Muhith Miah, Student DOB: 1993-01-01, Student Gender: Male, Student Email: N/A, Student Mobile: 01712345611, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 1.50, Student Status: Inactive', '2020-05-10', '04:17 PM', 'Active'),
(130103020001, 1, 'Edited Student Name: Muhith Miah, Student DOB: 1993-01-01, Student Gender: Male, Student Email: N/A, Student Mobile: 01712345611, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 4.50, Student Status: Inactive', '2020-05-10', '04:20 PM', 'Active'),
(140203020001, 1, 'Added Student Name: Humaira Ahmed Joti, Student DOB: 1990-01-01, Student Gender: Female, Student Email: N/A, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Active', '2020-05-10', '04:21 PM', 'Active'),
(130103020001, 6, 'Edited Student Name: Muhith Miah, Student DOB: 1993-01-01, Student Gender: Male, Student Email: N/A, Student Mobile: 01712345611, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 7.50, Student Status: Inactive', '2020-05-10', '04:25 PM', 'Active'),
(140303020001, 6, 'Added Student Name: Syed Ahsan Sirat, Student DOB: 1990-01-01, Student Gender: Male, Student Email: N/A, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Active', '2020-05-10', '04:40 PM', 'Active'),
(140303020001, 6, 'Edited Student Name: Syed Ahsan Sirat, Student DOB: 1990-01-01, Student Gender: Male, Student Email: N/A, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 3.00, Student Status: Active', '2020-05-10', '04:41 PM', 'Active'),
(140303020008, 6, 'Added Student Name: Abad Khan, Student DOB: 1992-01-01, Student Gender: Male, Student Email: N/A, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 0.00, Student Status: Active', '2020-05-10', '04:48 PM', 'Active'),
(140303020001, 6, 'Edited Student Name: Syed Ahsan Sirat, Student DOB: 1990-01-01, Student Gender: Male, Student Email: N/A, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 6.00, Student Status: Active', '2020-05-10', '04:49 PM', 'Active'),
(140303020008, 6, 'Edited Student Name: Abad Khan, Student DOB: 1992-01-01, Student Gender: Male, Student Email: N/A, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 3.00, Student Status: Active', '2020-05-10', '04:49 PM', 'Active'),
(130103020002, 6, 'Edited Student Name: Farjana Rahman, Student DOB: 1994-01-01, Student Gender: Female, Student Email: fkk@hj.kk, Student Mobile: N/A, Student Program: B.Sc. (Engg.) in CSE, Student CGPA: 0.00, Earned Credit: 0.00, Waived Credit: 6.00, Student Status: Active', '2020-05-12', '05:07 PM', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_student_info`
--

CREATE TABLE `nr_student_info` (
  `nr_stud_id` bigint(20) NOT NULL,
  `nr_studi_dropout` int(11) NOT NULL,
  `nr_studi_graduated` int(11) NOT NULL,
  `nr_studi_cgpa` float NOT NULL,
  `nr_studi_last_semester` enum('Spring','Summer','Fall') NOT NULL,
  `nr_studi_last_year` year(4) NOT NULL,
  `nr_studi_publish_date` varchar(20) NOT NULL,
  `nr_studi_status` enum('Active','Inactive') NOT NULL,
  `nr_studi_drop_semester` enum('Spring','Summer','Fall') NOT NULL,
  `nr_studi_drop_year` year(4) NOT NULL,
  `nr_studi_earned_credit` float NOT NULL,
  `nr_studi_waived_credit` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nr_student_info`
--

INSERT INTO `nr_student_info` (`nr_stud_id`, `nr_studi_dropout`, `nr_studi_graduated`, `nr_studi_cgpa`, `nr_studi_last_semester`, `nr_studi_last_year`, `nr_studi_publish_date`, `nr_studi_status`, `nr_studi_drop_semester`, `nr_studi_drop_year`, `nr_studi_earned_credit`, `nr_studi_waived_credit`) VALUES
(130103020001, 1, 0, 0, 'Spring', 2013, '2020-05-10', 'Active', 'Fall', 2013, 0, 7.5),
(130103020002, 1, 0, 0, 'Spring', 2013, '2020-05-12', 'Active', 'Fall', 2013, 0, 6),
(140203020001, 1, 0, 0, 'Summer', 2014, '2020-05-10', 'Active', 'Spring', 2015, 0, 0),
(140203020002, 1, 0, 0, 'Summer', 2014, '2020-05-09', 'Active', 'Spring', 2015, 0, 12),
(140203020003, 1, 0, 3.17, 'Summer', 2017, '2020-05-09', 'Active', 'Spring', 2018, 4.5, 7.5),
(140203020004, 1, 0, 0, 'Summer', 2014, '2020-05-09', 'Active', 'Spring', 2015, 0, 0),
(140203020005, 1, 0, 0, 'Summer', 2014, '2020-05-09', 'Active', 'Spring', 2015, 0, 0),
(140203020009, 1, 0, 0, 'Summer', 2014, '2020-05-09', 'Active', 'Spring', 2015, 0, 3),
(140303020001, 1, 0, 3.5, 'Spring', 2016, '2020-05-10', 'Active', 'Fall', 2016, 3, 6),
(140303020008, 1, 0, 2.5, 'Spring', 2016, '2020-05-10', 'Active', 'Fall', 2016, 3, 3),
(150102040001, 1, 0, 0, 'Spring', 2015, '2020-05-09', 'Active', 'Fall', 2015, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `nr_student_semester_cgpa`
--

CREATE TABLE `nr_student_semester_cgpa` (
  `nr_stud_id` bigint(20) NOT NULL,
  `nr_studsc_semester` enum('Spring','Summer','Fall') NOT NULL,
  `nr_studsc_year` year(4) NOT NULL,
  `nr_studsc_cgpa` float NOT NULL,
  `nr_studsc_status` enum('Active','Inactive') NOT NULL,
  `nr_studsc_publish_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nr_student_semester_cgpa`
--

INSERT INTO `nr_student_semester_cgpa` (`nr_stud_id`, `nr_studsc_semester`, `nr_studsc_year`, `nr_studsc_cgpa`, `nr_studsc_status`, `nr_studsc_publish_date`) VALUES
(140203020003, 'Summer', 2017, 3.17, 'Active', '2020-05-09'),
(140303020001, 'Spring', 2016, 3.5, 'Active', '2020-05-10'),
(140303020008, 'Spring', 2016, 2.5, 'Active', '2020-05-10'),
(150102040001, 'Summer', 2015, 0, 'Active', '2020-05-09');

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
(3, 140203020009, 1, '2020-01-01', 'Active'),
(9, 140203020002, 5, '2020-05-03', 'Active'),
(13, 140203020002, 1, '2020-05-04', 'Active'),
(18, 140203020002, 7, '2020-05-08', 'Active'),
(19, 140203020003, 1, '2020-05-08', 'Active'),
(20, 140203020003, 2, '2020-05-08', 'Active'),
(21, 140203020003, 3, '2020-05-08', 'Active'),
(22, 140203020002, 3, '2020-05-08', 'Active'),
(23, 140203020002, 6, '2020-05-08', 'Active'),
(24, 130103020002, 1, '2020-05-10', 'Active'),
(27, 130103020001, 6, '2020-05-10', 'Active'),
(28, 130103020001, 10, '2020-05-10', 'Active'),
(29, 130103020001, 7, '2020-05-10', 'Active'),
(30, 140303020001, 1, '2020-05-10', 'Active'),
(31, 140303020001, 8, '2020-05-10', 'Active'),
(32, 140303020008, 8, '2020-05-10', 'Active'),
(33, 130103020002, 7, '2020-05-12', 'Active');

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
(1, 1, 'NEUB Result Portal', 'Permanent Campus', 'Telihaor, Sheikhghat, Sylhet-3100', '0821 710221-2', 'info@neub.edu.bd', '01755566994', 'www.neub.edu.bd', 'mirlutfur.rahman@gmail.com', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3619.2310196389903!2d91.85876681464518!3d24.89010035019967!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3751aacd70cd7665:0xc8ae330ad72490dd!2z4Kao4Kaw4KeN4KalIOCmh-CmuOCnjeCmnyDgpofgpongpqjgpr_gpq3gpr7gprDgp43gprjgpr_gpp_gpr8g4Kas4Ka-4KaC4Kay4Ka-4Kam4KeH4Ka2!5e0!3m2!1sbn!2sbd!4v1586958839029!5m2!1sbn!2sbd', '2020-04-15', 'Active', '158715436115871543616948.png', '158694047915869404792493.jpg', '158695895215869589522023.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `nr_transcript_print_reference`
--

CREATE TABLE `nr_transcript_print_reference` (
  `nr_stud_id` bigint(20) NOT NULL,
  `nr_trprre_printed_by` enum('Student','Faculty','Moderator','Admin','Super Admin') NOT NULL,
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
(130103020001, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '02:35 PM', '0140200810350717', 'Active'),
(150102040001, 'Student', 150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:50 PM', '0143201408500047', 'Active'),
(130103020001, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-05', '04:08 PM', '0164200512084381', 'Active'),
(130103020001, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-05', '04:08 PM', '0177200512085225', 'Active'),
(130103020001, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:29 PM', '0182200407293562', 'Active'),
(150102040001, 'Student', 150102040001, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:46 PM', '0184201408464963', 'Active'),
(130103020001, 'Moderator', 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '07:52 PM', '0189200603524618', 'Active'),
(130103020001, 'Moderator', 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:27 PM', '0195200610272455', 'Active'),
(140203020002, 'Moderator', 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '08:14 PM', '0210200404143853', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:12 PM', '0211200407122641', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '10:35 PM', '0212200406353844', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:11 PM', '0212200407114060', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:25 PM', '0231200610251386', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:28 PM', '0231200610282794', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:09 PM', '0233200407092087', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:10 PM', '0237200610104018', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:33 PM', '0237200610334191', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '10:33 PM', '0239200406335821', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:30 PM', '0239200610303230', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:03 PM', '0242200407031198', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:29 PM', '0242200610291933', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:13 PM', '0245200407131881', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:31 PM', '0251200610311576', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:12 PM', '0252200610123698', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:20 PM', '0252200610200980', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:21 PM', '0253200407215957', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:29 PM', '0254200407291044', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:00 PM', '0255200407000845', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:33 PM', '0255200610330818', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:18 PM', '0256200610180680', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '10:33 PM', '0257200406330668', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '10:39 PM', '0259200406392816', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:35 PM', '0259200610352029', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:17 PM', '0261200407171838', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:27 PM', '0262200407275480', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:19 PM', '0263200407192617', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:21 PM', '0263200407210892', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '10:38 PM', '0265200406384385', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:20 PM', '0265200610203016', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:16 PM', '0268200407162557', 'Active'),
(130103020002, 'Moderator', 6, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-10', '01:59 PM', '0268201009592375', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:08 PM', '0270200407082186', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:10 PM', '0270200407101027', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:09 PM', '0270200610093636', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:01 PM', '0271200407014831', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:06 PM', '0271200407063976', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:04 PM', '0273200407041973', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '10:41 PM', '0275200406410362', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:04 PM', '0277200407045280', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:17 PM', '0278200407175838', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:23 PM', '0278200610231597', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:07 PM', '0279200407070394', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:14 PM', '0280200407140148', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:24 PM', '0281200610241289', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:14 PM', '0282200610141460', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:13 PM', '0284200610132855', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:03 PM', '0286200407033144', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:21 PM', '0289200610214743', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:25 PM', '0291200407251568', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:18 PM', '0294200407184688', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:09 PM', '0295200610092762', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-06', '02:27 PM', '0298200610273889', 'Active'),
(140203020002, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-04', '11:23 PM', '0299200407234226', 'Active'),
(140203020003, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '12:04 AM', '0315200708043564', 'Active'),
(140203020003, 'Student', 140203020003, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '01:25 AM', '0324200709254489', 'Active'),
(140203020003, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '01:08 AM', '0326200709083750', 'Active'),
(140203020003, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '03:20 PM', '0330200811203222', 'Active'),
(140203020003, 'Faculty', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '01:16 AM', '0366200709163978', 'Active'),
(140203020003, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '01:08 AM', '0368200709083095', 'Active'),
(140203020003, 'Faculty', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-08', '01:16 AM', '0369200709165165', 'Active'),
(140203020004, 'Student', 140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:51 PM', '0445201408512649', 'Active'),
(140203020004, 'Student', 140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '12:52 PM', '0451201408523243', 'Active'),
(140203020004, 'Student', 140203020004, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:51 PM', '0454201409515965', 'Active'),
(140203020004, 'Faculty', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-14', '01:05 PM', '0467201409053793', 'Active'),
(140203020004, 'Super Admin', 1, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-05-01', '02:47 PM', '0496200110473118', 'Active'),
(140203020009, 'Student', 140203020009, '::1', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2020-04-17', '03:49 PM', '0939201711494370', 'Active'),
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
-- Indexes for table `nr_admin_history`
--
ALTER TABLE `nr_admin_history`
  ADD KEY `nr_admin_member_id` (`nr_admin_member_id`),
  ADD KEY `nr_admin_id` (`nr_admin_id`);

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
-- Indexes for table `nr_admin_result_check_transaction`
--
ALTER TABLE `nr_admin_result_check_transaction`
  ADD KEY `nr_stud_id` (`nr_stud_id`),
  ADD KEY `nr_admin_id` (`nr_admin_id`);

--
-- Indexes for table `nr_course`
--
ALTER TABLE `nr_course`
  ADD PRIMARY KEY (`nr_course_id`),
  ADD KEY `nr_prog_id` (`nr_prog_id`);

--
-- Indexes for table `nr_course_history`
--
ALTER TABLE `nr_course_history`
  ADD KEY `nr_course_id` (`nr_course_id`),
  ADD KEY `nr_admin_id` (`nr_admin_id`);

--
-- Indexes for table `nr_delete_history`
--
ALTER TABLE `nr_delete_history`
  ADD KEY `nr_admin_id` (`nr_admin_id`);

--
-- Indexes for table `nr_department`
--
ALTER TABLE `nr_department`
  ADD PRIMARY KEY (`nr_dept_id`);

--
-- Indexes for table `nr_department_history`
--
ALTER TABLE `nr_department_history`
  ADD KEY `nr_dept_id` (`nr_dept_id`),
  ADD KEY `nr_admin_id` (`nr_admin_id`);

--
-- Indexes for table `nr_drop`
--
ALTER TABLE `nr_drop`
  ADD PRIMARY KEY (`nr_drop_id`),
  ADD KEY `nr_prcr_id` (`nr_prcr_id`),
  ADD KEY `nr_prog_id` (`nr_prog_id`),
  ADD KEY `nr_course_id` (`nr_course_id`);

--
-- Indexes for table `nr_drop_history`
--
ALTER TABLE `nr_drop_history`
  ADD KEY `nr_drop_id` (`nr_drop_id`),
  ADD KEY `nr_admin_id` (`nr_admin_id`);

--
-- Indexes for table `nr_faculty`
--
ALTER TABLE `nr_faculty`
  ADD PRIMARY KEY (`nr_faculty_id`),
  ADD KEY `nr_dept_id` (`nr_dept_id`);

--
-- Indexes for table `nr_faculty_history`
--
ALTER TABLE `nr_faculty_history`
  ADD KEY `nr_faculty_id` (`nr_faculty_id`),
  ADD KEY `nr_admin_id` (`nr_admin_id`);

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
-- Indexes for table `nr_program_history`
--
ALTER TABLE `nr_program_history`
  ADD KEY `nr_prog_id` (`nr_prog_id`),
  ADD KEY `nr_admin_id` (`nr_admin_id`);

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
-- Indexes for table `nr_result_history`
--
ALTER TABLE `nr_result_history`
  ADD KEY `nr_admin_id` (`nr_admin_id`),
  ADD KEY `nr_result_id` (`nr_result_id`);

--
-- Indexes for table `nr_student`
--
ALTER TABLE `nr_student`
  ADD PRIMARY KEY (`nr_stud_id`),
  ADD KEY `nr_prog_id` (`nr_prog_id`),
  ADD KEY `nr_prcr_id` (`nr_prcr_id`);

--
-- Indexes for table `nr_student_history`
--
ALTER TABLE `nr_student_history`
  ADD KEY `nr_admin_id` (`nr_admin_id`),
  ADD KEY `nr_stud_id` (`nr_stud_id`);

--
-- Indexes for table `nr_student_info`
--
ALTER TABLE `nr_student_info`
  ADD PRIMARY KEY (`nr_stud_id`);

--
-- Indexes for table `nr_student_semester_cgpa`
--
ALTER TABLE `nr_student_semester_cgpa`
  ADD PRIMARY KEY (`nr_stud_id`,`nr_studsc_semester`,`nr_studsc_year`);

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
  MODIFY `nr_admin_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `nr_course`
--
ALTER TABLE `nr_course`
  MODIFY `nr_course_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `nr_department`
--
ALTER TABLE `nr_department`
  MODIFY `nr_dept_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `nr_drop`
--
ALTER TABLE `nr_drop`
  MODIFY `nr_drop_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `nr_faculty`
--
ALTER TABLE `nr_faculty`
  MODIFY `nr_faculty_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `nr_program`
--
ALTER TABLE `nr_program`
  MODIFY `nr_prog_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `nr_program_credit`
--
ALTER TABLE `nr_program_credit`
  MODIFY `nr_prcr_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `nr_result`
--
ALTER TABLE `nr_result`
  MODIFY `nr_result_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `nr_student_waived_credit`
--
ALTER TABLE `nr_student_waived_credit`
  MODIFY `nr_stwacr_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `nr_system_component`
--
ALTER TABLE `nr_system_component`
  MODIFY `nr_syco_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nr_admin_history`
--
ALTER TABLE `nr_admin_history`
  ADD CONSTRAINT `nr_admin_history_ibfk_1` FOREIGN KEY (`nr_admin_member_id`) REFERENCES `nr_admin` (`nr_admin_id`),
  ADD CONSTRAINT `nr_admin_history_ibfk_2` FOREIGN KEY (`nr_admin_id`) REFERENCES `nr_admin` (`nr_admin_id`);

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
-- Constraints for table `nr_admin_result_check_transaction`
--
ALTER TABLE `nr_admin_result_check_transaction`
  ADD CONSTRAINT `nr_admin_result_check_transaction_ibfk_1` FOREIGN KEY (`nr_stud_id`) REFERENCES `nr_student` (`nr_stud_id`),
  ADD CONSTRAINT `nr_admin_result_check_transaction_ibfk_2` FOREIGN KEY (`nr_admin_id`) REFERENCES `nr_admin` (`nr_admin_id`);

--
-- Constraints for table `nr_course`
--
ALTER TABLE `nr_course`
  ADD CONSTRAINT `nr_course_ibfk_1` FOREIGN KEY (`nr_prog_id`) REFERENCES `nr_program` (`nr_prog_id`);

--
-- Constraints for table `nr_course_history`
--
ALTER TABLE `nr_course_history`
  ADD CONSTRAINT `nr_course_history_ibfk_1` FOREIGN KEY (`nr_course_id`) REFERENCES `nr_course` (`nr_course_id`),
  ADD CONSTRAINT `nr_course_history_ibfk_2` FOREIGN KEY (`nr_admin_id`) REFERENCES `nr_admin` (`nr_admin_id`);

--
-- Constraints for table `nr_delete_history`
--
ALTER TABLE `nr_delete_history`
  ADD CONSTRAINT `nr_delete_history_ibfk_1` FOREIGN KEY (`nr_admin_id`) REFERENCES `nr_admin` (`nr_admin_id`);

--
-- Constraints for table `nr_department_history`
--
ALTER TABLE `nr_department_history`
  ADD CONSTRAINT `nr_department_history_ibfk_1` FOREIGN KEY (`nr_dept_id`) REFERENCES `nr_department` (`nr_dept_id`),
  ADD CONSTRAINT `nr_department_history_ibfk_2` FOREIGN KEY (`nr_admin_id`) REFERENCES `nr_admin` (`nr_admin_id`);

--
-- Constraints for table `nr_drop`
--
ALTER TABLE `nr_drop`
  ADD CONSTRAINT `nr_drop_ibfk_1` FOREIGN KEY (`nr_prcr_id`) REFERENCES `nr_program_credit` (`nr_prcr_id`),
  ADD CONSTRAINT `nr_drop_ibfk_2` FOREIGN KEY (`nr_prog_id`) REFERENCES `nr_program` (`nr_prog_id`),
  ADD CONSTRAINT `nr_drop_ibfk_3` FOREIGN KEY (`nr_course_id`) REFERENCES `nr_course` (`nr_course_id`);

--
-- Constraints for table `nr_drop_history`
--
ALTER TABLE `nr_drop_history`
  ADD CONSTRAINT `nr_drop_history_ibfk_1` FOREIGN KEY (`nr_drop_id`) REFERENCES `nr_drop` (`nr_drop_id`),
  ADD CONSTRAINT `nr_drop_history_ibfk_2` FOREIGN KEY (`nr_admin_id`) REFERENCES `nr_admin` (`nr_admin_id`);

--
-- Constraints for table `nr_faculty`
--
ALTER TABLE `nr_faculty`
  ADD CONSTRAINT `nr_faculty_ibfk_1` FOREIGN KEY (`nr_dept_id`) REFERENCES `nr_department` (`nr_dept_id`);

--
-- Constraints for table `nr_faculty_history`
--
ALTER TABLE `nr_faculty_history`
  ADD CONSTRAINT `nr_faculty_history_ibfk_1` FOREIGN KEY (`nr_faculty_id`) REFERENCES `nr_faculty` (`nr_faculty_id`),
  ADD CONSTRAINT `nr_faculty_history_ibfk_2` FOREIGN KEY (`nr_admin_id`) REFERENCES `nr_admin` (`nr_admin_id`);

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
-- Constraints for table `nr_program_history`
--
ALTER TABLE `nr_program_history`
  ADD CONSTRAINT `nr_program_history_ibfk_1` FOREIGN KEY (`nr_prog_id`) REFERENCES `nr_program` (`nr_prog_id`),
  ADD CONSTRAINT `nr_program_history_ibfk_2` FOREIGN KEY (`nr_admin_id`) REFERENCES `nr_admin` (`nr_admin_id`);

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
-- Constraints for table `nr_result_history`
--
ALTER TABLE `nr_result_history`
  ADD CONSTRAINT `nr_result_history_ibfk_1` FOREIGN KEY (`nr_admin_id`) REFERENCES `nr_admin` (`nr_admin_id`),
  ADD CONSTRAINT `nr_result_history_ibfk_2` FOREIGN KEY (`nr_result_id`) REFERENCES `nr_result` (`nr_result_id`);

--
-- Constraints for table `nr_student`
--
ALTER TABLE `nr_student`
  ADD CONSTRAINT `nr_student_ibfk_1` FOREIGN KEY (`nr_prog_id`) REFERENCES `nr_program` (`nr_prog_id`),
  ADD CONSTRAINT `nr_student_ibfk_2` FOREIGN KEY (`nr_prcr_id`) REFERENCES `nr_program_credit` (`nr_prcr_id`);

--
-- Constraints for table `nr_student_history`
--
ALTER TABLE `nr_student_history`
  ADD CONSTRAINT `nr_student_history_ibfk_1` FOREIGN KEY (`nr_admin_id`) REFERENCES `nr_admin` (`nr_admin_id`),
  ADD CONSTRAINT `nr_student_history_ibfk_2` FOREIGN KEY (`nr_stud_id`) REFERENCES `nr_student` (`nr_stud_id`);

--
-- Constraints for table `nr_student_info`
--
ALTER TABLE `nr_student_info`
  ADD CONSTRAINT `nr_student_info_ibfk_1` FOREIGN KEY (`nr_stud_id`) REFERENCES `nr_student` (`nr_stud_id`);

--
-- Constraints for table `nr_student_semester_cgpa`
--
ALTER TABLE `nr_student_semester_cgpa`
  ADD CONSTRAINT `nr_student_semester_cgpa_ibfk_1` FOREIGN KEY (`nr_stud_id`) REFERENCES `nr_student` (`nr_stud_id`);

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
