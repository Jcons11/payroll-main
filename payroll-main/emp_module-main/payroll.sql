-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2022 at 07:55 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `payroll`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_log`
--

CREATE TABLE `admin_log` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `columnName` varchar(100) DEFAULT NULL,
  `beforeValue` varchar(255) DEFAULT NULL,
  `afterValue` varchar(255) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_log`
--

INSERT INTO `admin_log` (`id`, `name`, `action`, `columnName`, `beforeValue`, `afterValue`, `time`, `date`) VALUES
(19, 'Francis Ilacad', 'Add Secretary', NULL, NULL, NULL, '03:10:22am', '2022/01/29'),
(20, 'Francis Ilacad', 'Add Secretary', NULL, NULL, NULL, '03:19:49am', '2022/01/29'),
(21, 'Francis Ilacad', 'login', NULL, NULL, NULL, '02:06:40pm', '2022/01/29'),
(22, 'Francis Ilacad', 'login', NULL, NULL, NULL, '03:45:29pm', '2022/01/29'),
(23, 'Francis Ilacad', 'Add Secretary', NULL, NULL, NULL, '03:45:58pm', '2022/01/29'),
(24, 'Francis Ilacad', 'Add Secretary', NULL, NULL, NULL, '03:48:28pm', '2022/01/29'),
(25, 'Francis Ilacad', 'Add Secretary', NULL, NULL, NULL, '03:51:05pm', '2022/01/29'),
(26, 'Francis Ilacad', 'login', NULL, NULL, NULL, '05:53:33am', '2022/01/30'),
(27, 'Francis Ilacad', 'login', NULL, NULL, NULL, '06:23:49am', '2022/01/30'),
(28, 'Francis Ilacad', 'Add Secretary', NULL, NULL, NULL, '06:24:32am', '2022/01/30'),
(29, 'Francis Ilacad', 'login', NULL, NULL, NULL, '07:56:57am', '2022/01/30'),
(30, 'Francis Ilacad', 'login', NULL, NULL, NULL, '09:16:38am', '2022/01/30'),
(31, 'Francis Ilacad', 'login', NULL, NULL, NULL, '10:19:01am', '2022/01/30'),
(32, 'Francis Ilacad', 'login', NULL, NULL, NULL, '03:05:20 PM', '2022/01/30'),
(33, 'cho ureta', 'login', NULL, NULL, NULL, '03:13:34 PM', '2022/01/30'),
(34, 'Francis Ilacad', 'login', NULL, NULL, NULL, '10:59:07 AM', '2022/01/31');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `hired_guards` varchar(100) NOT NULL,
  `cpnumber` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `comp_location` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `position0` varchar(100) NOT NULL,
  `price0` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `shifts` varchar(100) NOT NULL,
  `shifts_span` varchar(100) NOT NULL,
  `day_start` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `hired_guards`, `cpnumber`, `email`, `comp_location`, `longitude`, `latitude`, `type`, `position0`, `price0`, `date`, `shifts`, `shifts_span`, `day_start`) VALUES
(1, 'Mcdo', '', '09123456789', 'mcdo@gmail.com', 'Tandang Sora', '123', '123', 'Manual', 'Officer in Chief', '56.0', 'February 4, 2022', 'Day', '8', '6:00:00 AM');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `cpnumber` varchar(255) NOT NULL,
  `emp_address` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `shift` varchar(255) NOT NULL,
  `day_start` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL,
  `availability` varchar(255) NOT NULL,
  `timer` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `firstname`, `lastname`, `cpnumber`, `emp_address`, `position`, `type`, `email`, `password`, `shift`, `day_start`, `access`, `availability`, `timer`, `date`) VALUES
(1, 'Pedro', 'Pandecoco', '09123456789', 'SM North Edsa', 'Officer in Charge', 'Manual', 'von39gaming@gmail.com', 'fd15a131bf160018b870503a99d374a2', 'Day', '6:00:00 AM', 'employee', 'Unavailable', '', 'Feb-4-2022');

-- --------------------------------------------------------

--
-- Table structure for table `employee_info`
--

CREATE TABLE `employee_info` (
  `acc_id` int(11) NOT NULL,
  `emp_id` varchar(20) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `contact` bigint(12) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee_info`
--

INSERT INTO `employee_info` (`acc_id`, `emp_id`, `firstname`, `lastname`, `contact`, `email`, `address`) VALUES
(1, '1', 'Roel', 'Cortez', 9195660525, 'rc@gmail.com', 'kahitsaan'),
(2, '2', 'Daniel', 'Padilla', 9205887012, 'dp@gmail.com', 'satabitabi'),
(3, '3', 'Junior', 'Devera', 9097546928, 'jk@gmail.com', 'gedli'),
(4, '4', 'Roberto', 'Kalat', 9876543213, 'rk@gmail.com', 'tabitabi'),
(5, '5', 'Red Jude', 'Cadornigara', 9878767654, 'rr@gmail.com', 'sabile'),
(6, '123456', 'Joshua', 'Minecraft', 9878752452, 'owshi@gmail.com', 'di sapat village, pinagpalit city');

-- --------------------------------------------------------

--
-- Table structure for table `emp_attendance`
--

CREATE TABLE `emp_attendance` (
  `id` int(11) NOT NULL,
  `empId` varchar(255) NOT NULL,
  `company` varchar(100) NOT NULL,
  `timeIn` varchar(255) NOT NULL,
  `timeOut` varchar(255) DEFAULT NULL,
  `datetimeIn` varchar(100) NOT NULL,
  `datetimeOut` varchar(100) DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `login_session` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp_attendance`
--

INSERT INTO `emp_attendance` (`id`, `empId`, `company`, `timeIn`, `timeOut`, `datetimeIn`, `datetimeOut`, `location`, `status`, `login_session`) VALUES
(60, '123456', 'Mcdo sa Kanto', '11:24:06 AM', NULL, '2022/02/05', '2022/02/05', 'No location right now :)', 'Late', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `emp_info`
--

CREATE TABLE `emp_info` (
  `id` int(11) NOT NULL,
  `empId` varchar(255) NOT NULL,
  `companyId` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `cpnumber` varchar(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL,
  `position` varchar(100) NOT NULL,
  `scheduleTimeIn` varchar(100) NOT NULL,
  `scheduleTimeOut` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `timer` varchar(255) NOT NULL,
  `ratesperDay` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp_info`
--

INSERT INTO `emp_info` (`id`, `empId`, `companyId`, `firstname`, `lastname`, `address`, `cpnumber`, `status`, `access`, `position`, `scheduleTimeIn`, `scheduleTimeOut`, `email`, `password`, `timer`, `ratesperDay`) VALUES
(1, '123456', '', 'Pedro', 'Pandecoco', '', '', '', 'Employee', 'Officer in Chief', '11:00:00 PM', '5:00:00 AM', 'von39gaming@gmail.com', 'fd15a131bf160018b870503a99d374a2', '', 0),
(2, '2020-0001', '', 'Kirito', 'Kun', '', '0', '', 'Employee', 'Officer in Chief', '6:00:00 AM', '5:00:00 PM', 'von39gamingx@gmail.com', 'fd15a131bf160018b870503a99d374a2', '', 0),
(5, '1231234', '1231234', 'Aether', 'Kun', '123123123123123213', '09123456789', 'Unavailable', 'Employee', 'Officer in Chief', '9:00:00 PM', '6:00:00 AM', 'vonnedewsalig@gmail.com', 'fd15a131bf160018b870503a99d374a2', '', 0),
(6, '101010', 'Hotdog Factory', 'Asuna', 'Chan', 'Dyan lang sa tabi tabi', '', '', 'Employee', 'Officer in Chief', '9:00:00 PM', '3:00:00 AM', 'kirito@gmail.com', 'fd15a131bf160018b870503a99d374a2', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `generated_salary`
--

CREATE TABLE `generated_salary` (
  `log` int(11) NOT NULL,
  `emp_id` varchar(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `rate_hour` int(11) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `hours_duty` int(11) DEFAULT NULL,
  `regular_holiday` int(11) DEFAULT NULL,
  `special_holiday` int(11) DEFAULT NULL,
  `day_late` int(11) DEFAULT NULL,
  `min_late` int(11) DEFAULT NULL,
  `day_absent` int(11) DEFAULT NULL,
  `hours_absent` int(11) DEFAULT NULL,
  `no_of_work` int(11) DEFAULT NULL,
  `sss` int(11) DEFAULT NULL,
  `cashbond` int(11) DEFAULT NULL,
  `vale` int(11) DEFAULT NULL,
  `thirteenmonth` int(11) DEFAULT NULL,
  `total_hours` int(11) DEFAULT NULL,
  `regular_pay` int(11) DEFAULT NULL,
  `regular_holiday_pay` int(11) DEFAULT NULL,
  `special_holiday_pay` int(11) DEFAULT NULL,
  `absent_pay` int(11) DEFAULT NULL,
  `total_deduction` int(11) DEFAULT NULL,
  `total_gross` int(11) DEFAULT NULL,
  `total_netpay` int(11) DEFAULT NULL,
  `dateandtime_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `generated_salary`
--

INSERT INTO `generated_salary` (`log`, `emp_id`, `location`, `rate_hour`, `date`, `hours_duty`, `regular_holiday`, `special_holiday`, `day_late`, `min_late`, `day_absent`, `hours_absent`, `no_of_work`, `sss`, `cashbond`, `vale`, `thirteenmonth`, `total_hours`, `regular_pay`, `regular_holiday_pay`, `special_holiday_pay`, `absent_pay`, `total_deduction`, `total_gross`, `total_netpay`, `dateandtime_created`) VALUES
(78, '1', 'Jollibee Paso de blas', 59, '2022/02/04', 12, 2, 2, 2, 30, 5, 60, 14, 300, 50, 5000, 13000, 168, 9912, 2832, 1458, 3540, 8920, 27202, 18283, '04:39:38am'),
(79, '2', 'Mcdo Makati', 59, '2022/02/04', 12, 2, 1, 2, 30, 2, 24, 14, 300, 50, 0, 0, 168, 9912, 2832, 729, 1416, 1796, 13473, 11677, '08:52:41am'),
(81, '3', 'Taguig', 59, '2022/02/04', 12, 0, 0, 2, 30, 0, 0, 14, 300, 50, 0, 0, 168, 9912, 0, 0, 0, 380, 9912, 9532, '01:40:35pm');

-- --------------------------------------------------------

--
-- Table structure for table `secretary`
--

CREATE TABLE `secretary` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `cpnumber` varchar(13) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `timer` varchar(50) DEFAULT NULL,
  `admin_id` int(11) NOT NULL,
  `access` varchar(100) DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `secretary`
--

INSERT INTO `secretary` (`id`, `firstname`, `lastname`, `gender`, `cpnumber`, `address`, `email`, `password`, `timer`, `admin_id`, `access`, `isDeleted`) VALUES
(2, 'megumi', 'chan', 'Male', '09097065121', 'Minecraft World', 'owshi@minecraft.com', 'fd15a131bf160018b870503a99d374a2', NULL, 1, 'secretary', NULL),
(3, 'pandesal', 'munggo', 'Female', '09060766219', 'Sauyo lang', 'herrerafrancismarianne@gmail.com', 'ad1354a5a5f27885657bd46843ddb69e', NULL, 1, 'secretary', NULL),
(6, 'itlog', 'pechay', 'Male', '09123456789', 'asd', 'johnrafaelconstantino01@gmail.com', '0b6d3310b371aa4e4122c67d7a62abf2', NULL, 1, 'secretary', NULL),
(8, 'Red', 'Padilla', 'Male', '091234556789', 'Brgy Dimahanap', 'red.jude.villanueva.cadornigara@gmail.com', '3c86ddb270471569a6b02000d54b570c', NULL, 1, 'secretary', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `secretary_log`
--

CREATE TABLE `secretary_log` (
  `id` int(11) NOT NULL,
  `sec_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `secretary_log`
--

INSERT INTO `secretary_log` (`id`, `sec_id`, `name`, `action`, `time`, `date`) VALUES
(10, 8, 'Red Padilla', 'Edit Salary', '02:45:54 PM', '2022/02/05');

-- --------------------------------------------------------

--
-- Table structure for table `super_admin`
--

CREATE TABLE `super_admin` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `timer` varchar(100) DEFAULT NULL,
  `access` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `super_admin`
--

INSERT INTO `super_admin` (`id`, `firstname`, `lastname`, `username`, `password`, `timer`, `access`) VALUES
(1, 'Francis', 'Ilacad', 'DammiDoe123@gmail.com', '172eee54aa664e9dd0536b063796e54e', 'NULL', 'super administrator'),
(2, 'cho', 'ureta', 'uretamarycho@gmail.com', 'a9e09a27007f8e8bad58d68c3f2fa4de', 'NULL', 'super administrator');

-- --------------------------------------------------------

--
-- Table structure for table `unavailable_guards`
--

CREATE TABLE `unavailable_guards` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `year` varchar(50) NOT NULL,
  `month` varchar(50) NOT NULL,
  `day` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unavailable_guards`
--

INSERT INTO `unavailable_guards` (`id`, `employee_id`, `company_id`, `year`, `month`, `day`, `date`) VALUES
(1, 1, 1, '', '', '', 'February 4, 2022');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_log`
--
ALTER TABLE `admin_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_info`
--
ALTER TABLE `employee_info`
  ADD PRIMARY KEY (`acc_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `emp_attendance`
--
ALTER TABLE `emp_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empId` (`empId`);

--
-- Indexes for table `emp_info`
--
ALTER TABLE `emp_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`empId`);

--
-- Indexes for table `generated_salary`
--
ALTER TABLE `generated_salary`
  ADD PRIMARY KEY (`log`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `secretary`
--
ALTER TABLE `secretary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `secretary_log`
--
ALTER TABLE `secretary_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sec_id` (`sec_id`);

--
-- Indexes for table `super_admin`
--
ALTER TABLE `super_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unavailable_guards`
--
ALTER TABLE `unavailable_guards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `company_id` (`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_log`
--
ALTER TABLE `admin_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_info`
--
ALTER TABLE `employee_info`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `emp_attendance`
--
ALTER TABLE `emp_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `emp_info`
--
ALTER TABLE `emp_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `generated_salary`
--
ALTER TABLE `generated_salary`
  MODIFY `log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `secretary`
--
ALTER TABLE `secretary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `secretary_log`
--
ALTER TABLE `secretary_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `super_admin`
--
ALTER TABLE `super_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `unavailable_guards`
--
ALTER TABLE `unavailable_guards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `emp_attendance`
--
ALTER TABLE `emp_attendance`
  ADD CONSTRAINT `emp_attendance_ibfk_1` FOREIGN KEY (`empId`) REFERENCES `emp_info` (`empId`);

--
-- Constraints for table `generated_salary`
--
ALTER TABLE `generated_salary`
  ADD CONSTRAINT `generated_salary_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employee_info` (`emp_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `secretary`
--
ALTER TABLE `secretary`
  ADD CONSTRAINT `secretary_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `super_admin` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `secretary_log`
--
ALTER TABLE `secretary_log`
  ADD CONSTRAINT `secretary_log_ibfk_1` FOREIGN KEY (`sec_id`) REFERENCES `secretary` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `unavailable_guards`
--
ALTER TABLE `unavailable_guards`
  ADD CONSTRAINT `unavailable_guards_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`),
  ADD CONSTRAINT `unavailable_guards_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `time_in_ID_2_DATE_2022_02_05` ON SCHEDULE AT '2022-02-05 17:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `emp_attendance`
                                               SET `login_session` = 'false',
                                               `timeOut` = '5:00:00 PM',
                                               `datetimeOut` = '2022/02/05'
                                               WHERE `empid` = '2020-0001'$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
