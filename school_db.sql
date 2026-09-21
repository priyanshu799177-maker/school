-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2026 at 10:25 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.0.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'Priyanshu123', 'Priyanshu@123');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `class` varchar(20) NOT NULL,
  `attendance_date` date NOT NULL,
  `status` enum('Present','Absent') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `student_name`, `class`, `attendance_date`, `status`) VALUES
(1, 1, 'Rahul', '10', '2026-08-04', 'Present'),
(2, 2, '', '', '2026-08-04', 'Absent'),
(3, 3, 'priyanshu', '10', '2026-08-04', 'Present'),
(4, 4, '', '', '2026-08-04', 'Absent'),
(5, 5, '', '', '2026-08-04', 'Absent'),
(6, 6, '', '', '2026-08-04', 'Present'),
(7, 1, 'Rahul', '10', '2026-08-23', 'Present'),
(8, 2, '', '', '2026-08-23', 'Absent'),
(9, 3, 'priyanshu', '10', '2026-08-23', 'Absent'),
(10, 4, '', '', '2026-08-23', 'Present'),
(11, 5, '', '', '2026-08-23', 'Present'),
(12, 6, '', '', '2026-08-23', 'Present'),
(13, 8, 'priyanshu', '2', '2026-08-27', 'Absent'),
(14, 9, 'priyanshu', '2', '2026-08-27', 'Present'),
(15, 8, 'priyanshu', '2', '2026-08-28', 'Present'),
(16, 9, 'priyanshu', '2', '2026-08-28', 'Absent'),
(17, 10, 'vaibhav', '2', '2026-08-28', 'Present'),
(18, 7, 'vaibhav', '7', '2026-09-13', 'Present'),
(19, 13, 'gfhkj', '7', '2026-09-13', 'Present'),
(20, 11, 'amit', '6', '2026-09-13', 'Present'),
(21, 12, 'popopfdasa', '6', '2026-09-13', 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `class` varchar(20) NOT NULL,
  `total_fee` decimal(10,2) NOT NULL,
  `paid_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `remaining_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `student_id`, `student_name`, `class`, `total_fee`, `paid_fee`, `remaining_fee`, `payment_date`) VALUES
(1, 2, '', '', '3452222.00', '2222.00', '3450000.00', '2026-08-29'),
(2, 10, 'vaibhav', '2', '60000.00', '4545.00', '55455.00', '2026-08-29');

-- --------------------------------------------------------

--
-- Table structure for table `fee_payments`
--

CREATE TABLE `fee_payments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fee_payments`
--

INSERT INTO `fee_payments` (`id`, `student_id`, `paid_amount`, `payment_date`) VALUES
(1, 10, '8000.00', '2026-08-29'),
(2, 10, '453.00', '2026-08-29');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL,
  `upload_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `title`, `image`, `upload_date`) VALUES
(1, 'all functio', '1788270250_2885.jpeg', '2026-09-01');

-- --------------------------------------------------------

--
-- Table structure for table `homework`
--

CREATE TABLE `homework` (
  `id` int(11) NOT NULL,
  `class` varchar(20) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` text,
  `last_date` date DEFAULT NULL,
  `teacher_name` varchar(100) DEFAULT NULL,
  `pdf_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `homework`
--

INSERT INTO `homework` (`id`, `class`, `subject`, `title`, `description`, `last_date`, `teacher_name`, `pdf_file`) VALUES
(1, 'UKG', 'english', 'fhgjgkjhgj', 'xnmx', '2026-08-21', '', NULL),
(2, 'UKG', 'english', 'fhgjgkjhgj', 'xnmx', '2026-08-21', '', NULL),
(3, 'UKG', 'english', 'fhgjgkjhgj', 'xnmx', '2026-08-21', '', NULL),
(4, 'UKG', 'english', 'fhgjgkjhgj', 'xnmx', '2026-08-21', '', NULL),
(5, 'Nursery', '', '', '', '0000-00-00', '', ''),
(6, 'Nursery', '', '', '', '0000-00-00', '', ''),
(7, 'Nursery', 'english', 'chapter 1 complete', 'from ', '2026-12-08', 'supriya', ''),
(8, '10', 'english', 'hindi', 'complete', '0026-12-08', 'supriya', ''),
(9, '10', 'hindi ', 'complete', 'dsklafhn', '2026-08-14', 'supriya', ''),
(10, 'Nursery', 'english', 'ythdfhghf', 'trsdfhj', '2026-08-09', 'supriya', ''),
(11, 'Nursery', 'english', 'ythdfhghf', 'trsdfhj', '2026-08-09', 'supriya', ''),
(12, '10', 'english', 'didi', 'dpdk[', '2026-08-21', 'supriya', '1785859038_Profile.pdf'),
(13, '7', 'engish', 'dffgds', 'dsgfds', '2026-10-01', 'Priyanshu Lodhi', ''),
(14, '7', 'engish', 'aegkjjjjjj', 'sadfffffffffffffffff', '2026-09-25', 'Priyanshu Lodhi', ''),
(15, '6', 'engish', 'sssssssssssssss', 'ddddddddddddddd', '2026-09-11', 'Priyanshu Lodhi', ''),
(16, '7', 'engish', 'cxzv', 'czvxxx', '2026-09-25', 'Priyanshu Lodhi', ''),
(17, '2', 'engish', ' complete the copy', 'koi', '2026-09-19', 'Mrs Savitri', ''),
(18, '2', 'hindi', 'complete the home work', 'eglish', '2026-09-12', 'supriya', '1789923229_Profile.pdf'),
(19, '2', 'hindi', 'vey fast', 'sss', '2026-09-25', 'supriya', '');

-- --------------------------------------------------------

--
-- Table structure for table `homework_status`
--

CREATE TABLE `homework_status` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `homework_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `checked_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `homework_status`
--

INSERT INTO `homework_status` (`id`, `student_id`, `homework_id`, `status`, `remark`, `checked_date`) VALUES
(1, 1, NULL, 'Incomplete', 'hkgjhg', '2026-08-04'),
(2, 2, NULL, 'Complete', '', '2026-08-04'),
(3, 3, NULL, 'Complete', '', '2026-08-04'),
(4, 4, NULL, 'Complete', '', '2026-08-04'),
(5, 5, NULL, 'Complete', '', '2026-08-04'),
(6, 6, NULL, 'Complete', '', '2026-08-04');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `notice` text,
  `notice_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `title`, `notice`, `notice_date`) VALUES
(6, 'todayn]', 'kmcbnkjdsbkjdsb', '2026-08-28');

-- --------------------------------------------------------

--
-- Table structure for table `principals`
--

CREATE TABLE `principals` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `principals`
--

INSERT INTO `principals` (`id`, `name`, `username`, `password`) VALUES
(1, 'Sunil Kumar', 'principal', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `remarks`
--

CREATE TABLE `remarks` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `class` varchar(20) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `teacher_name` varchar(100) NOT NULL,
  `remark` text NOT NULL,
  `remark_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `remarks`
--

INSERT INTO `remarks` (`id`, `student_id`, `student_name`, `class`, `subject`, `teacher_name`, `remark`, `remark_date`) VALUES
(1, 10, 'vaibhav', '2', 'hindi', 'supriya', 'good for thiis subject', '2026-08-28');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `class` varchar(20) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `teacher_name` varchar(100) NOT NULL,
  `marks` int(11) NOT NULL,
  `total_marks` int(11) NOT NULL DEFAULT '100',
  `grade` varchar(10) DEFAULT NULL,
  `result_date` date NOT NULL,
  `quarterly_marks` int(11) DEFAULT '0',
  `quarterly_total` int(11) DEFAULT '50',
  `half_yearly_marks` int(11) DEFAULT '0',
  `half_yearly_total` int(11) DEFAULT '50',
  `annual_marks` int(11) DEFAULT '0',
  `annual_total` int(11) DEFAULT '50',
  `approval_status` varchar(20) NOT NULL DEFAULT 'Pending',
  `principal_remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `student_id`, `student_name`, `class`, `subject`, `teacher_name`, `marks`, `total_marks`, `grade`, `result_date`, `quarterly_marks`, `quarterly_total`, `half_yearly_marks`, `half_yearly_total`, `annual_marks`, `annual_total`, `approval_status`, `principal_remarks`) VALUES
(1, 10, 'vaibhav', '2', 'hindi', 'supriya220808@gmail.com', 23, 50, 'C', '2026-09-01', 23, 50, 34, 50, 23, 50, 'Approved', 'goood student'),
(2, 10, 'vaibhav', '2', 'engish', 'supriya220808@gmail.com', 23, 50, '', '2026-09-01', 23, 50, 12, 50, 23, 50, 'Approved', 'goood student'),
(3, 10, 'vaibhav', '2', 'maths', 'supriya220808@gmail.com', 0, 50, '', '2026-09-01', 42, 50, 0, 50, 0, 50, 'Approved', 'goood student'),
(4, 3, 'priyanshu', '10', 'engish', 'supriya220808@gmail.com', 31, 50, '', '2026-09-01', 13, 50, 31, 50, 31, 50, 'Approved', 'good'),
(5, 11, 'amit', '6', 'engish', '', 0, 100, NULL, '0000-00-00', 32, 50, 23, 50, 34, 100, 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `class` varchar(20) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `father_name`, `class`, `mobile`, `address`, `dob`, `username`, `password`) VALUES
(1, 'Rahul', 'Ramesh', '10', '9876543210', 'Lucknow', '2010-01-15', 'rahul10', 'Rahul@123'),
(2, '', '', '', '', '', '0000-00-00', NULL, NULL),
(3, 'priyanshu', 'sunil kumar', '10', '9559180606', 'lko', '2005-02-20', NULL, NULL),
(4, '', '', '', '', '', '0000-00-00', NULL, NULL),
(5, '', '', '', '', '', '0000-00-00', NULL, NULL),
(6, '', '', '', '', '', '0000-00-00', NULL, NULL),
(7, 'vaibhav', 'k;lsdj', '7', '9559180606', 'lko', '2025-07-10', NULL, NULL),
(8, 'priyanshu', 'sunil kumar', '2', '9559180606', 'lko', '2024-06-04', NULL, NULL),
(9, 'priyanshu', 'sunil kumar', '2', '9559180606', 'lko', '2024-06-04', NULL, NULL),
(10, 'vaibhav', 'xxxxxxx', '2', '9559180606', 'vaibhav', '2024-12-05', 'vaibhav', 'Vaibhav@123'),
(11, 'amit', 'rakesh ', '6', '1236547892', 'lko', '2025-04-03', 'amit ', '123456'),
(12, 'popopfdasa', 'adsf', '6', '9559180606', 'fsss', '2026-09-25', 'priyanshu5@gmail.com', '090909'),
(13, 'gfhkj', 'cvbnm,', '7', 'gh', 'hjv', '2026-09-02', 'priyanshu15@gmail.com', '989898'),
(14, 'priyanshu', 'sunil', '2', '9559180606', 'fsss', '2025-07-29', '123654', '456123');

-- --------------------------------------------------------

--
-- Table structure for table `student_fees`
--

CREATE TABLE `student_fees` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `total_fee` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_fees`
--

INSERT INTO `student_fees` (`id`, `student_id`, `total_fee`) VALUES
(1, 10, '20000.00');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(100) DEFAULT NULL,
  `subject_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `subject_code`) VALUES
(2, 'hindi', 'hin102'),
(3, 'engish', 'hin102');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `subject`, `mobile`, `email`, `password`) VALUES
(1, 'supriya', 'english', '9559180606', 'supriya220808@gmail.com', 'Supriya@123'),
(2, 'Priyanshu Lodhi', 'Science', '7355205844', 'priyanshu55517@gmail.com', 'Priyanshu@123'),
(3, 'Mrs Savitri', 'Math', '7991775551', 'savitri12@gmail.com', '123654');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_assignments`
--

CREATE TABLE `teacher_assignments` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class` varchar(20) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `is_class_teacher` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher_assignments`
--

INSERT INTO `teacher_assignments` (`id`, `teacher_id`, `class`, `subject_id`, `is_class_teacher`) VALUES
(1, 1, '2', 2, 0),
(2, 1, 'Nursery', 2, 1),
(3, 2, '7', 3, 1),
(4, 2, '6', 3, 1),
(5, 3, '2', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee_payments`
--
ALTER TABLE `fee_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homework`
--
ALTER TABLE `homework`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homework_status`
--
ALTER TABLE `homework_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `principals`
--
ALTER TABLE `principals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `remarks`
--
ALTER TABLE `remarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_fees`
--
ALTER TABLE `student_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_assignments`
--
ALTER TABLE `teacher_assignments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fee_payments`
--
ALTER TABLE `fee_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `homework`
--
ALTER TABLE `homework`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `homework_status`
--
ALTER TABLE `homework_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `principals`
--
ALTER TABLE `principals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `remarks`
--
ALTER TABLE `remarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `student_fees`
--
ALTER TABLE `student_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teacher_assignments`
--
ALTER TABLE `teacher_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
