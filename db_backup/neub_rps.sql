-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2020 at 08:29 PM
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
  `nr_admin_mobile` varchar(20) NOT NULL,
  `nr_admin_photo` varchar(60) NOT NULL,
  `nr_admin_type` enum('General','Moderator','Admin') NOT NULL,
  `nr_admin_designation` varchar(50) NOT NULL,
  `nr_admin_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Table structure for table `nr_course`
--

CREATE TABLE `nr_course` (
  `nr_course_code` varchar(20) NOT NULL,
  `nr_course_title` varchar(100) NOT NULL,
  `nr_course_credit` float NOT NULL,
  `nr_prog_id` bigint(20) NOT NULL,
  `nr_course_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

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
  `nr_course_code` varchar(20) NOT NULL,
  `nr_result_marks` float NOT NULL,
  `nr_result_grade` varchar(30) NOT NULL,
  `nr_result_grade_point` float NOT NULL,
  `nr_result_semester` enum('Spring','Summer','Fall') NOT NULL,
  `nr_result_year` year(4) NOT NULL,
  `nr_result_remarks` enum('Incomplete','Expelled','Makeup_MS','Makeup_SF','Makeup_MS_SF','Withdraw') NOT NULL,
  `nr_result_status` enum('Active','Inactive') NOT NULL,
  `nr_prog_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

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
  `nr_stud_photo` varchar(60) NOT NULL,
  `nr_prog_id` bigint(20) NOT NULL,
  `nr_prcr_id` bigint(20) NOT NULL,
  `nr_stud_credit_waived` float NOT NULL,
  `nr_stud_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `nr_student`
--

INSERT INTO `nr_student` (`nr_stud_id`, `nr_stud_name`, `nr_stud_dob`, `nr_stud_gender`, `nr_stud_email`, `nr_stud_photo`, `nr_prog_id`, `nr_prcr_id`, `nr_stud_credit_waived`, `nr_stud_status`) VALUES
(140203020002, 'Mir Lutfur Rahman', '1996-07-02', 'Male', 'mirlutfur.rahman@gmail.com', '', 1, 1, 0, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nr_system_component`
--

CREATE TABLE `nr_system_component` (
  `nr_syco_id` bigint(20) NOT NULL,
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

INSERT INTO `nr_system_component` (`nr_syco_id`, `nr_syco_title`, `nr_syco_caption`, `nr_syco_address`, `nr_syco_tel`, `nr_syco_email`, `nr_syco_mobile`, `nr_syco_web`, `nr_syco_contact_email`, `nr_syco_map_link`, `nr_syco_date`, `nr_syco_status`) VALUES
(1, 'NEUB Result Portal', 'Permanent Campus', 'Telihaor, Sheikhghat, Sylhet-3100', '0821 710221-2', 'info@neub.edu.bd', '01755566994', 'www.neub.edu.bd', 'result@neub.edu.bd', 'https://maps.google.com/maps?q=north%20east%20university%20bangladesh&t=&z=15&ie=UTF8&iwloc=&output=embed', '2020-01-25', 'Active');

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
  ADD PRIMARY KEY (`nr_course_code`),
  ADD KEY `nr_prog_id` (`nr_prog_id`);

--
-- Indexes for table `nr_department`
--
ALTER TABLE `nr_department`
  ADD PRIMARY KEY (`nr_dept_id`);

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
  ADD KEY `nr_course_code` (`nr_course_code`),
  ADD KEY `nr_prog_id` (`nr_prog_id`);

--
-- Indexes for table `nr_student`
--
ALTER TABLE `nr_student`
  ADD PRIMARY KEY (`nr_stud_id`),
  ADD KEY `nr_prog_id` (`nr_prog_id`),
  ADD KEY `nr_prcr_id` (`nr_prcr_id`);

--
-- Indexes for table `nr_system_component`
--
ALTER TABLE `nr_system_component`
  ADD PRIMARY KEY (`nr_syco_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nr_admin`
--
ALTER TABLE `nr_admin`
  MODIFY `nr_admin_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nr_department`
--
ALTER TABLE `nr_department`
  MODIFY `nr_dept_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `nr_result_id` bigint(20) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `nr_result_ibfk_2` FOREIGN KEY (`nr_course_code`) REFERENCES `nr_course` (`nr_course_code`),
  ADD CONSTRAINT `nr_result_ibfk_3` FOREIGN KEY (`nr_prog_id`) REFERENCES `nr_program` (`nr_prog_id`);

--
-- Constraints for table `nr_student`
--
ALTER TABLE `nr_student`
  ADD CONSTRAINT `nr_student_ibfk_1` FOREIGN KEY (`nr_prog_id`) REFERENCES `nr_program` (`nr_prog_id`),
  ADD CONSTRAINT `nr_student_ibfk_2` FOREIGN KEY (`nr_prcr_id`) REFERENCES `nr_program_credit` (`nr_prcr_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
