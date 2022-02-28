-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2022 at 09:47 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newpayroll`
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
-- Table structure for table `automatic_generated_salary`
--

CREATE TABLE `automatic_generated_salary` (
  `log` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `total_hours` float DEFAULT NULL,
  `standard_pay` float DEFAULT NULL,
  `regular_holiday` int(11) DEFAULT NULL,
  `regular_holiday_pay` float DEFAULT NULL,
  `special_holiday` int(11) DEFAULT NULL,
  `special_holiday_pay` float DEFAULT NULL,
  `thirteenmonth` float DEFAULT NULL,
  `sss` float DEFAULT NULL,
  `pagibig` float DEFAULT NULL,
  `philhealth` float DEFAULT NULL,
  `cashbond` float DEFAULT NULL,
  `vale` float DEFAULT NULL,
  `total_hours_late` int(11) DEFAULT NULL,
  `total_gross` float DEFAULT NULL,
  `total_deduction` float DEFAULT NULL,
  `total_netpay` float DEFAULT NULL,
  `start` varchar(50) DEFAULT NULL,
  `end` varchar(50) DEFAULT NULL,
  `for_release` varchar(20) DEFAULT NULL,
  `date_created` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cashadvance`
--

CREATE TABLE `cashadvance` (
  `id` int(11) NOT NULL,
  `empId` int(11) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `amount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cashadvance`
--

INSERT INTO `cashadvance` (`id`, `empId`, `date`, `amount`) VALUES
(25, 1002, 'February 21, 2022', 3000);

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
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` int(11) NOT NULL,
  `deduction` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `duty` int(11) DEFAULT NULL,
  `cutoff` varchar(50) DEFAULT NULL,
  `amount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`id`, `deduction`, `position`, `duty`, `cutoff`, `amount`) VALUES
(46, 'SSS', 'Security Officer', 8, 'Bi-weekly', 300),
(47, 'SSS', 'Security Officer', 12, 'Bi-weekly', 450),
(48, 'Pagibig', 'Security Officer', 8, 'Bi-weekly', 133),
(49, 'Pagibig', 'Security Officer', 12, 'Bi-weekly', 200),
(50, 'Philhealth', 'Security Officer', 8, 'Bi-weekly', 233),
(51, 'Philhealth', 'Security Officer', 12, 'Bi-weekly', 350),
(52, 'SSS', 'OIC', 8, 'Bi-weekly', 338),
(53, 'SSS', 'OIC', 12, 'Bi-weekly', 507),
(54, 'Pagibig', 'OIC', 8, 'Bi-weekly', 150),
(55, 'Pagibig', 'OIC', 12, 'Bi-weekly', 226),
(56, 'Philhealth', 'OIC', 8, 'Bi-weekly', 263),
(57, 'Philhealth', 'OIC', 12, 'Bi-weekly', 395);

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
  `company` varchar(100) DEFAULT NULL,
  `timeIn` varchar(20) DEFAULT NULL,
  `timeOut` varchar(20) DEFAULT NULL,
  `datetimeIn` varchar(100) DEFAULT NULL,
  `datetimeOut` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `salary_status` varchar(50) NOT NULL,
  `login_session` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp_attendance`
--

INSERT INTO `emp_attendance` (`id`, `empId`, `company`, `timeIn`, `timeOut`, `datetimeIn`, `datetimeOut`, `location`, `status`, `salary_status`, `login_session`) VALUES
(61, '1001', 'Jollibee Sauyo', '07:56:00 AM', '07:56:00 PM', 'January 1, 2022', 'January 1, 2022', 'Sauyo,Quezon City', 'Ontime', 'unpaid', 'true'),
(62, '1002', 'Mcdo Baesa', '08:56:00 AM', '8:00:00 PM', 'January 1, 2021', 'January 1, 2021', 'Baesa, Quezon City', 'Late', 'unpaid', 'true'),
(63, '1001', 'Jollibee Sauyo', '07:59:00 AM', '07:59:00 PM', 'January 2, 2022', 'January 2, 2022', 'Sauyo, Quezon City', 'Ontime', 'unpaid', ''),
(64, '1001', 'Jollibee Sauyo', '08:00:00 AM', '08:00:00 PM', 'January 3, 2022', 'January 3, 2022', 'Sauyo, Quezon City', 'Ontime', 'unpaid', ''),
(65, '1002', 'Mcdo Baesa', '07:56:00 AM', '8:00:00 PM', 'January 2, 2021', 'January 2, 2021', 'Baesa Quezon City', 'Ontime', 'unpaid', 'true'),
(66, '1002', 'Mcdo Baesa', '8:00:00 AM', '8:00:00 PM', 'January 3, 2021', 'January 3, 2021', 'Baesa, Quezon City', 'ontime', 'unpaid', 'true'),
(67, '1001', 'Jollibee Sauyo', '07:56:00 AM', '8:00:00 PM', 'February 1, 2022', 'February 1, 2022', 'Sauyo, Quezon City', 'ontime', 'unpaid', 'true'),
(68, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', 'February 2, 2022', 'February 2, 2022', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(69, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', 'February 3, 2022', 'February 3, 2022', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(70, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', 'February 4, 2022', 'February 4, 2022', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(71, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', 'February 5, 2022', 'February 5, 2022', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(72, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', 'February 6, 2022', 'February 6, 2022', '', 'ontime', 'unpaid', 'true'),
(73, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', 'February 7, 2022', 'February 7, 2022', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(74, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', 'February 8, 2022', 'February 8, 2022', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(75, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', 'February 9, 2022', 'February 9, 2022', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(76, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', 'February 10, 2022', 'February 10, 2022', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(77, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', 'February 11, 2022', 'February 11, 2022', 'Sauyo High', 'ontime', 'unpaid', 'true'),
(78, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', 'February 12, 2022', 'February 12, 2022', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(79, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', 'February 13, 2022', 'February 13, 2022', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(80, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', 'February 14, 2022', 'February 14, 2022', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(81, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', 'February 25, 2022', 'February 25, 2022', 'Sauyo, QC', 'ontime', 'unpaid', 'true');

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
  `rate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp_info`
--

INSERT INTO `emp_info` (`id`, `empId`, `companyId`, `firstname`, `lastname`, `address`, `cpnumber`, `status`, `access`, `position`, `scheduleTimeIn`, `scheduleTimeOut`, `email`, `password`, `timer`, `rate`) VALUES
(7, '1001', '1001', 'Arnel', 'Garcia', 'Sauyo', '09878765654', 'Unavailable', 'Employee', 'Security Officer', '0', '0', 'arnelgarcia@gmail.com', 'arnel123', '', 59.523),
(9, '1002', '1002', 'Salvador', 'Macaraeg', 'Baesa', '09898787654', 'Unavailable', 'Employee', 'Security Officer', '0', '0', 'sm@gmail.com', 'sm123', '', 0),
(10, '1003', '1003', 'Norman', 'Capugan', 'Sangandaan', '09263547812', 'Unavailable', 'Employee', 'Security Officer', '0', '0', 'nc@gmail.com', 'nc123', '', 0),
(11, '1004', '1004', 'Jayson', 'Malones', 'Novaliches', '09878263541', 'Unavailable', 'Employee', 'Security Officer', '0', '0', 'jm@gmail.com', 'jm123', '', 0),
(12, '1005', '1005', 'Guilbert', 'Panes', 'Nagkaisang Nayon', '09878623564', 'Unavailable', 'Employee', 'Security Officer', '0', '0', 'gp@gmail.com', 'gp123', '', 0),
(13, '1006', '1006', 'Gerry', 'Yape', 'Ugong', '09876547635', 'Unavailable', 'Employee', 'Security Officer', '0', '0', 'gy@gmail.com', 'gy123', '', 0),
(14, '1007', '1007', 'Rolando', 'Naciso', 'Gen t', '09988976235', 'Unavailable', 'Employee', 'Security Officer', '0', '0', 'rn@gmail.com', 'rn123', '', 0),
(15, '1008', '1008', 'Joseph', 'Ligsanan', 'Mulawinan', '09878765623', 'Unavailable', 'Employee', 'Security Officer', '0', '0', 'jl@gmail.com', 'jl123', '', 0),
(16, '1009', '1009', 'Rolly', 'Bustarde', 'Malabon', '09123876345', 'Unavailable', 'Employee', 'Security Officer', '', '', 'rb@gmail.com', 'rb123', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `emp_schedule`
--

CREATE TABLE `emp_schedule` (
  `id` int(11) NOT NULL,
  `empId` int(11) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `timeIn_schedule` varchar(255) DEFAULT NULL,
  `timeOut_schedule` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `generated_salary`
--

CREATE TABLE `generated_salary` (
  `log` int(11) NOT NULL,
  `emp_id` varchar(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `rate_hour` float DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `hours_duty` float DEFAULT NULL,
  `regular_holiday` float DEFAULT NULL,
  `special_holiday` float DEFAULT NULL,
  `day_late` float DEFAULT NULL,
  `hrs_late` float DEFAULT NULL,
  `day_absent` float DEFAULT NULL,
  `hours_absent` float DEFAULT NULL,
  `no_of_work` float DEFAULT NULL,
  `sss` float DEFAULT NULL,
  `pagibig` float DEFAULT NULL,
  `philhealth` float DEFAULT NULL,
  `cashbond` float DEFAULT NULL,
  `vale` float DEFAULT NULL,
  `thirteenmonth` float DEFAULT NULL,
  `total_hours` float DEFAULT NULL,
  `regular_pay` float DEFAULT NULL,
  `regular_holiday_pay` float DEFAULT NULL,
  `special_holiday_pay` float DEFAULT NULL,
  `absent_pay` float DEFAULT NULL,
  `total_deduction` float DEFAULT NULL,
  `total_gross` float DEFAULT NULL,
  `total_netpay` float DEFAULT NULL,
  `dateandtime_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `generated_salary`
--

INSERT INTO `generated_salary` (`log`, `emp_id`, `location`, `rate_hour`, `date`, `hours_duty`, `regular_holiday`, `special_holiday`, `day_late`, `hrs_late`, `day_absent`, `hours_absent`, `no_of_work`, `sss`, `pagibig`, `philhealth`, `cashbond`, `vale`, `thirteenmonth`, `total_hours`, `regular_pay`, `regular_holiday_pay`, `special_holiday_pay`, `absent_pay`, `total_deduction`, `total_gross`, `total_netpay`, `dateandtime_created`) VALUES
(106, '1001', 'Jollibee Paso de blas', 59, '2022/02/11', 8, 12, 12, 0, 0, NULL, NULL, 14, 450, NULL, NULL, 50, 500, 0, 112, 6608, 1416, 729.24, NULL, 1000, 8753.24, 7753.24, '12:53:00 PM'),
(107, '1001', 'Jollibee Paso de blas', 59, '2022/02/11', 12, 12, 12, 0, 0, NULL, NULL, 14, 450, 200, 300, 50, 500, 0, 168, 9912, 708, 729.24, NULL, 1500, 11349.2, 9849.24, '01:25:02 PM');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `date_holiday` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `name`, `date_holiday`, `type`) VALUES
(1, 'New Year’s Day ', 'January 1, 2022 ', 'Regular Holiday'),
(2, 'The Day of Valor', 'April 9, 2022', 'Regular Holiday'),
(3, 'Maundy Thursday', 'April 14, 2022', 'Regular Holiday'),
(4, 'Good Friday', 'April 15, 2022', 'Regular Holiday'),
(5, 'Labor Day', 'May 1, 2022', 'Regular Holiday'),
(6, 'Eid’l Fitr', 'May 3, 2022', 'Regular Holiday'),
(7, 'Independence Day', 'June 12, 2022', 'Regular Holiday'),
(8, 'National Heroes’ Day', 'August 29, 2022', 'Regular Holiday'),
(9, 'Bonifacio Day', 'November 30, 2022', 'Regular Holiday'),
(10, 'Christmas Day', 'December 25, 2022', 'Regular Holiday'),
(11, 'Rizal Day', 'December 30, 2022', 'Regular Holiday'),
(12, 'Chinese New Year', 'February 1, 2022', 'Special Holiday'),
(13, 'People Power Revolution', 'February 25, 2022', 'Special Holiday'),
(14, 'Black Saturday', 'April 16, 2022', 'Special Holiday'),
(15, 'Ninoy Aquino Day', 'August 21, 2022', 'Special Holiday'),
(16, 'All Saints’ Day', 'November 1, 2022', 'Special Holiday'),
(17, 'Immaculate Conception of Mary', 'December 8, 2022', 'Special Holiday'),
(18, 'All Souls’ Day', 'November 2, 2022', 'Special Holiday'),
(19, 'Christmas Eve', 'December 24, 2022', 'Special Holiday'),
(20, 'New Year’s Eve', 'December 30, 2022', 'Special Holiday');

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
(8, 'Red', 'minecraft', 'Male', '091234556789', 'Brgy Dimahanap', 'red.jude.villanueva.cadornigara@gmail.com', '3c86ddb270471569a6b02000d54b570c', NULL, 1, 'secretary', NULL);

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
(36, 8, 'Red minecraft', 'login', '12:40:47 PM', '2022/02/06'),
(37, 8, 'Red minecraft', 'Add Salary', '07:55:00 PM', '2022/02/06'),
(38, 8, 'Red minecraft', 'login', '07:58:09 PM', '2022/02/06'),
(39, 8, 'Red minecraft', 'login', '09:38:52 AM', '2022/02/07'),
(40, 8, 'Red minecraft', 'login', '05:27:28 PM', '2022/02/07'),
(41, 8, 'Red minecraft', 'login', '08:02:38 PM', '2022/02/07'),
(42, 8, 'Red minecraft', 'Add Salary', '09:51:50 PM', '2022/02/07'),
(43, 8, 'Red minecraft', 'Add Salary', '09:53:31 PM', '2022/02/07'),
(44, 8, 'Red minecraft', 'login', '09:54:03 PM', '2022/02/07'),
(45, 8, 'Red minecraft', 'Delete Salary', '09:58:04 PM', '2022/02/07'),
(46, 8, 'Red minecraft', 'Delete Salary', '09:58:08 PM', '2022/02/07'),
(47, 8, 'Red minecraft', 'Add Salary', '09:58:34 PM', '2022/02/07'),
(48, 8, 'Red minecraft', 'login', '11:03:57 AM', '2022/02/08'),
(49, 8, 'Red minecraft', 'login', '11:18:47 AM', '2022/02/09'),
(50, 8, 'Red minecraft', 'login', '03:03:29 PM', '2022/02/09'),
(51, 8, 'Red minecraft', 'Delete Deduction', '03:13:22 PM', '2022/02/09'),
(52, 8, 'Red minecraft', 'Delete Deduction', '03:13:25 PM', '2022/02/09'),
(53, 8, 'Red minecraft', 'Delete Deduction', '03:13:28 PM', '2022/02/09'),
(54, 8, 'Red minecraft', 'Delete Deduction', '03:13:30 PM', '2022/02/09'),
(55, 8, 'Red minecraft', 'Delete Deduction', '03:13:32 PM', '2022/02/09'),
(56, 8, 'Red minecraft', 'Delete Deduction', '03:13:33 PM', '2022/02/09'),
(57, 8, 'Red minecraft', 'Delete Deduction', '03:13:35 PM', '2022/02/09'),
(58, 8, 'Red minecraft', 'Delete Deduction', '03:13:37 PM', '2022/02/09'),
(59, 8, 'Red minecraft', 'Delete Deduction', '03:13:39 PM', '2022/02/09'),
(60, 8, 'Red minecraft', 'Delete Deduction', '03:13:41 PM', '2022/02/09'),
(61, 8, 'Red minecraft', 'Delete Deduction', '03:13:43 PM', '2022/02/09'),
(62, 8, 'Red minecraft', 'Delete Deduction', '03:13:45 PM', '2022/02/09'),
(63, 8, 'Red minecraft', 'Delete Deduction', '03:13:47 PM', '2022/02/09'),
(64, 8, 'Red minecraft', 'login', '06:22:17 PM', '2022/02/09'),
(65, 8, 'Red minecraft', 'Delete Salary', '06:30:52 PM', '2022/02/09'),
(66, 8, 'Red minecraft', 'Delete Cash Advance', '06:31:30 PM', '2022/02/09'),
(67, 8, 'Red minecraft', 'Delete Deduction', '07:32:55 PM', '2022/02/09'),
(68, 8, 'Red minecraft', 'Delete Deduction', '07:33:05 PM', '2022/02/09'),
(69, 8, 'Red minecraft', 'Add Automated Salary', '07:36:07 PM', '2022/02/09'),
(70, 8, 'Red minecraft', 'Add Automated Salary', '07:37:21 PM', '2022/02/09'),
(71, 8, 'Red minecraft', 'Add Automated Salary', '07:52:02 PM', '2022/02/09'),
(72, 8, 'Red minecraft', 'Add Automated Salary', '07:52:38 PM', '2022/02/09'),
(73, 8, 'Red minecraft', 'Add Automated Salary', '07:53:03 PM', '2022/02/09'),
(74, 8, 'Red minecraft', 'Add Automated Salary', '07:53:51 PM', '2022/02/09'),
(75, 8, 'Red minecraft', 'Add Automated Salary', '07:53:57 PM', '2022/02/09'),
(76, 8, 'Red minecraft', 'Add Automated Salary', '07:58:09 PM', '2022/02/09'),
(77, 8, 'Red minecraft', 'Add Automated Salary', '07:58:22 PM', '2022/02/09'),
(78, 8, 'Red minecraft', 'Add Automated Salary', '07:59:36 PM', '2022/02/09'),
(79, 8, 'Red minecraft', 'Add Automated Salary', '08:00:28 PM', '2022/02/09'),
(80, 8, 'Red minecraft', 'Add Automated Salary', '08:00:50 PM', '2022/02/09'),
(81, 8, 'Red minecraft', 'Add Automated Salary', '08:05:52 PM', '2022/02/09'),
(82, 8, 'Red minecraft', 'Add Automated Salary', '08:06:00 PM', '2022/02/09'),
(83, 8, 'Red minecraft', 'Add Automated Salary', '08:27:37 PM', '2022/02/09'),
(84, 8, 'Red minecraft', 'Add Automated Salary', '09:14:04 PM', '2022/02/09'),
(85, 8, 'Red minecraft', 'Add Automated Salary', '09:16:51 PM', '2022/02/09'),
(86, 8, 'Red minecraft', 'login', '12:52:18 AM', '2022/02/10'),
(87, 8, 'Red minecraft', 'Delete Automated Salary', '01:05:55 AM', '2022/02/10'),
(88, 8, 'Red minecraft', 'login', '10:44:09 AM', '2022/02/10'),
(89, 8, 'Red minecraft', 'Add Cash Advance', '10:47:40 AM', '2022/02/10'),
(90, 8, 'Red minecraft', 'Add Deduction', '10:48:39 AM', '2022/02/10'),
(91, 8, 'Red minecraft', 'Add Automated Salary', '11:20:06 AM', '2022/02/10'),
(92, 8, 'Red minecraft', 'Add Automated Salary', '11:21:49 AM', '2022/02/10'),
(93, 8, 'Red minecraft', 'Add Automated Salary', '11:24:06 AM', '2022/02/10'),
(94, 8, 'Red minecraft', 'Add Automated Salary', '11:24:54 AM', '2022/02/10'),
(95, 8, 'Red minecraft', 'Add Automated Salary', '11:25:20 AM', '2022/02/10'),
(96, 8, 'Red minecraft', 'Add Automated Salary', '11:26:33 AM', '2022/02/10'),
(97, 8, 'Red minecraft', 'Add Automated Salary', '11:27:33 AM', '2022/02/10'),
(98, 8, 'Red minecraft', 'Add Automated Salary', '11:29:16 AM', '2022/02/10'),
(99, 8, 'Red minecraft', 'Add Automated Salary', '11:29:37 AM', '2022/02/10'),
(100, 8, 'Red minecraft', 'Add Automated Salary', '11:30:12 AM', '2022/02/10'),
(101, 8, 'Red minecraft', 'Add Automated Salary', '11:31:26 AM', '2022/02/10'),
(102, 8, 'Red minecraft', 'Add Automated Salary', '11:32:19 AM', '2022/02/10'),
(103, 8, 'Red minecraft', 'Add Automated Salary', '11:34:48 AM', '2022/02/10'),
(104, 8, 'Red minecraft', 'Add Automated Salary', '11:37:11 AM', '2022/02/10'),
(105, 8, 'Red minecraft', 'Add Automated Salary', '11:37:46 AM', '2022/02/10'),
(106, 8, 'Red minecraft', 'Add Automated Salary', '11:42:19 AM', '2022/02/10'),
(107, 8, 'Red minecraft', 'Add Automated Salary', '11:45:28 AM', '2022/02/10'),
(108, 8, 'Red minecraft', 'Add Automated Salary', '11:46:23 AM', '2022/02/10'),
(109, 8, 'Red minecraft', 'Add Automated Salary', '11:48:47 AM', '2022/02/10'),
(110, 8, 'Red minecraft', 'Add Automated Salary', '11:51:12 AM', '2022/02/10'),
(111, 8, 'Red minecraft', 'Add Automated Salary', '11:53:46 AM', '2022/02/10'),
(112, 8, 'Red minecraft', 'Add Automated Salary', '11:57:03 AM', '2022/02/10'),
(113, 8, 'Red minecraft', 'Add Automated Salary', '11:58:10 AM', '2022/02/10'),
(114, 8, 'Red minecraft', 'Add Automated Salary', '12:00:23 PM', '2022/02/10'),
(115, 8, 'Red minecraft', 'Add Automated Salary', '12:02:34 PM', '2022/02/10'),
(116, 8, 'Red minecraft', 'Add Automated Salary', '12:02:52 PM', '2022/02/10'),
(117, 8, 'Red minecraft', 'Add Automated Salary', '12:05:58 PM', '2022/02/10'),
(118, 8, 'Red minecraft', 'Add Automated Salary', '12:06:14 PM', '2022/02/10'),
(119, 8, 'Red minecraft', 'Add Automated Salary', '12:11:07 PM', '2022/02/10'),
(120, 8, 'Red minecraft', 'Add Automated Salary', '12:17:19 PM', '2022/02/10'),
(121, 8, 'Red minecraft', 'Add Automated Salary', '12:17:45 PM', '2022/02/10'),
(122, 8, 'Red minecraft', 'Add Automated Salary', '12:18:43 PM', '2022/02/10'),
(123, 8, 'Red minecraft', 'Add Automated Salary', '12:46:32 PM', '2022/02/10'),
(124, 8, 'Red minecraft', 'Add Automated Salary', '12:46:49 PM', '2022/02/10'),
(125, 8, 'Red minecraft', 'Add Automated Salary', '12:48:38 PM', '2022/02/10'),
(126, 8, 'Red minecraft', 'Add Automated Salary', '12:48:44 PM', '2022/02/10'),
(127, 8, 'Red minecraft', 'Add Automated Salary', '12:50:18 PM', '2022/02/10'),
(128, 8, 'Red minecraft', 'Add Automated Salary', '12:50:24 PM', '2022/02/10'),
(129, 8, 'Red minecraft', 'Add Automated Salary', '01:06:23 PM', '2022/02/10'),
(130, 8, 'Red minecraft', 'Add Automated Salary', '01:09:49 PM', '2022/02/10'),
(131, 8, 'Red minecraft', 'Add Automated Salary', '01:32:39 PM', '2022/02/10'),
(132, 8, 'Red minecraft', 'Add Automated Salary', '01:37:06 PM', '2022/02/10'),
(133, 8, 'Red minecraft', 'Add Automated Salary', '01:37:26 PM', '2022/02/10'),
(134, 8, 'Red minecraft', 'Add Automated Salary', '01:39:36 PM', '2022/02/10'),
(135, 8, 'Red minecraft', 'Add Automated Salary', '01:45:40 PM', '2022/02/10'),
(136, 8, 'Red minecraft', 'Add Automated Salary', '01:53:34 PM', '2022/02/10'),
(137, 8, 'Red minecraft', 'Add Automated Salary', '01:53:48 PM', '2022/02/10'),
(138, 8, 'Red minecraft', 'Delete Automated Salary', '02:24:05 PM', '2022/02/10'),
(139, 8, 'Red minecraft', 'Delete Cash Advance', '03:30:44 PM', '2022/02/10'),
(140, 8, 'Red minecraft', 'Delete Cash Advance', '03:30:46 PM', '2022/02/10'),
(141, 8, 'Red minecraft', 'Delete Cash Advance', '03:30:48 PM', '2022/02/10'),
(142, 8, 'Red minecraft', 'Add Cash Advance', '03:31:52 PM', '2022/02/10'),
(143, 8, 'Red minecraft', 'Add Cash Advance', '03:32:09 PM', '2022/02/10'),
(144, 8, 'Red minecraft', 'Add Cash Advance', '03:32:39 PM', '2022/02/10'),
(145, 8, 'Red minecraft', 'Delete Cash Advance', '03:32:43 PM', '2022/02/10'),
(146, 8, 'Red minecraft', 'Delete Cash Advance', '03:32:46 PM', '2022/02/10'),
(147, 8, 'Red minecraft', 'Add Cash Advance', '03:35:19 PM', '2022/02/10'),
(148, 8, 'Red minecraft', 'Add Cash Advance', '03:37:25 PM', '2022/02/10'),
(149, 8, 'Red minecraft', 'Delete Cash Advance', '03:37:29 PM', '2022/02/10'),
(150, 8, 'Red minecraft', 'Delete Cash Advance', '03:37:31 PM', '2022/02/10'),
(151, 8, 'Red minecraft', 'Delete Cash Advance', '03:37:33 PM', '2022/02/10'),
(152, 8, 'Red minecraft', 'Delete Cash Advance', '03:37:35 PM', '2022/02/10'),
(153, 8, 'Red minecraft', 'Delete Cash Advance', '03:37:37 PM', '2022/02/10'),
(154, 8, 'Red minecraft', 'Add Cash Advance', '03:37:40 PM', '2022/02/10'),
(155, 8, 'Red minecraft', 'Add Cash Advance', '03:37:43 PM', '2022/02/10'),
(156, 8, 'Red minecraft', 'Add Cash Advance', '03:37:46 PM', '2022/02/10'),
(157, 8, 'Red minecraft', 'Delete Cash Advance', '03:37:49 PM', '2022/02/10'),
(158, 8, 'Red minecraft', 'Delete Cash Advance', '03:37:50 PM', '2022/02/10'),
(159, 8, 'Red minecraft', 'Delete Cash Advance', '03:37:53 PM', '2022/02/10'),
(160, 8, 'Red minecraft', 'Add Deduction', '03:38:03 PM', '2022/02/10'),
(161, 8, 'Red minecraft', 'Delete Deduction', '03:38:09 PM', '2022/02/10'),
(162, 8, 'Red minecraft', 'Add Deduction', '03:39:11 PM', '2022/02/10'),
(163, 8, 'Red minecraft', 'Delete Deduction', '03:39:26 PM', '2022/02/10'),
(164, 8, 'Red minecraft', 'Delete Deduction', '03:39:39 PM', '2022/02/10'),
(165, 8, 'Red minecraft', 'Delete Deduction', '03:39:57 PM', '2022/02/10'),
(166, 8, 'Red minecraft', 'Delete Deduction', '03:40:00 PM', '2022/02/10'),
(167, 8, 'Red minecraft', 'Add Deduction', '03:40:18 PM', '2022/02/10'),
(168, 8, 'Red minecraft', 'Delete Deduction', '03:40:22 PM', '2022/02/10'),
(169, 8, 'Red minecraft', 'login', '08:20:35 AM', '2022/02/11'),
(170, 8, 'Red minecraft', 'Add Automated Salary', '08:24:40 AM', '2022/02/11'),
(171, 8, 'Red minecraft', 'Delete Automated Salary', '08:24:57 AM', '2022/02/11'),
(172, 8, 'Red minecraft', 'Add Automated Salary', '08:25:12 AM', '2022/02/11'),
(173, 8, 'Red minecraft', 'Add Automated Salary', '08:26:10 AM', '2022/02/11'),
(174, 8, 'Red minecraft', 'Add Automated Salary', '08:27:39 AM', '2022/02/11'),
(175, 8, 'Red minecraft', 'Delete Automated Salary', '08:27:43 AM', '2022/02/11'),
(176, 8, 'Red minecraft', 'Delete Automated Salary', '08:27:45 AM', '2022/02/11'),
(177, 8, 'Red minecraft', 'Delete Automated Salary', '08:28:11 AM', '2022/02/11'),
(178, 8, 'Red minecraft', 'Delete Automated Salary', '08:28:14 AM', '2022/02/11'),
(179, 8, 'Red minecraft', 'Add Automated Salary', '08:28:17 AM', '2022/02/11'),
(180, 8, 'Red minecraft', 'Add Cash Advance', '08:28:39 AM', '2022/02/11'),
(181, 8, 'Red minecraft', 'Delete Automated Salary', '08:28:46 AM', '2022/02/11'),
(182, 8, 'Red minecraft', 'Add Automated Salary', '08:28:48 AM', '2022/02/11'),
(183, 8, 'Red minecraft', 'Delete Salary', '08:30:51 AM', '2022/02/11'),
(184, 8, 'Red minecraft', 'Delete Salary', '08:30:54 AM', '2022/02/11'),
(185, 8, 'Red minecraft', 'Delete Salary', '08:30:57 AM', '2022/02/11'),
(186, 8, 'Red minecraft', 'Add Salary', '08:32:31 AM', '2022/02/11'),
(187, 8, 'Red minecraft', 'Edit Salary', '08:44:34 AM', '2022/02/11'),
(188, 8, 'Red minecraft', 'Edit Salary', '08:44:53 AM', '2022/02/11'),
(189, 8, 'Red minecraft', 'Edit Salary', '08:45:16 AM', '2022/02/11'),
(190, 8, 'Red minecraft', 'Edit Salary', '08:46:27 AM', '2022/02/11'),
(191, 8, 'Red minecraft', 'Add Salary', '08:48:42 AM', '2022/02/11'),
(192, 8, 'Red minecraft', 'Delete Salary', '08:49:12 AM', '2022/02/11'),
(193, 8, 'Red minecraft', 'Edit Salary', '08:49:19 AM', '2022/02/11'),
(194, 8, 'Red minecraft', 'Delete Automated Salary', '08:50:32 AM', '2022/02/11'),
(195, 8, 'Red minecraft', 'Add Automated Salary', '08:50:34 AM', '2022/02/11'),
(196, 8, 'Red minecraft', 'Delete Automated Salary', '08:50:38 AM', '2022/02/11'),
(197, 8, 'Red minecraft', 'Delete Salary', '08:53:47 AM', '2022/02/11'),
(198, 8, 'Red minecraft', 'Add Salary', '08:54:14 AM', '2022/02/11'),
(199, 8, 'Red minecraft', 'Edit Salary', '08:54:30 AM', '2022/02/11'),
(200, 8, 'Red minecraft', 'Add Automated Salary', '08:55:20 AM', '2022/02/11'),
(201, 8, 'Red minecraft', 'Delete Automated Salary', '08:55:57 AM', '2022/02/11'),
(202, 8, 'Red minecraft', 'Delete Cash Advance', '08:57:03 AM', '2022/02/11'),
(203, 8, 'Red minecraft', 'Edit Salary', '08:58:00 AM', '2022/02/11'),
(204, 8, 'Red minecraft', 'Add Salary', '08:58:36 AM', '2022/02/11'),
(205, 8, 'Red minecraft', 'Delete Salary', '08:58:44 AM', '2022/02/11'),
(206, 8, 'Red minecraft', 'Delete Salary', '09:00:11 AM', '2022/02/11'),
(207, 8, 'Red minecraft', 'Add Salary', '09:00:38 AM', '2022/02/11'),
(208, 8, 'Red minecraft', 'Add Automated Salary', '09:01:43 AM', '2022/02/11'),
(209, 8, 'Red minecraft', 'Delete Salary', '09:05:36 AM', '2022/02/11'),
(210, 8, 'Red minecraft', 'Add Salary', '09:06:31 AM', '2022/02/11'),
(211, 8, 'Red minecraft', 'Edit Salary', '09:06:57 AM', '2022/02/11'),
(212, 8, 'Red minecraft', 'Delete Automated Salary', '09:07:09 AM', '2022/02/11'),
(213, 8, 'Red minecraft', 'Add Automated Salary', '09:10:03 AM', '2022/02/11'),
(214, 8, 'Red minecraft', 'Add Cash Advance', '09:10:37 AM', '2022/02/11'),
(215, 8, 'Red minecraft', 'Delete Automated Salary', '09:10:41 AM', '2022/02/11'),
(216, 8, 'Red minecraft', 'Add Automated Salary', '09:10:45 AM', '2022/02/11'),
(217, 8, 'Red minecraft', 'Add Automated Salary', '09:16:36 AM', '2022/02/11'),
(218, 8, 'Red minecraft', 'Delete Automated Salary', '09:23:26 AM', '2022/02/11'),
(219, 8, 'Red minecraft', 'Delete Automated Salary', '09:23:28 AM', '2022/02/11'),
(220, 8, 'Red minecraft', 'Add Automated Salary', '09:26:19 AM', '2022/02/11'),
(221, 8, 'Red minecraft', 'Add Automated Salary', '09:46:12 AM', '2022/02/11'),
(222, 8, 'Red minecraft', 'Add Automated Salary', '09:57:43 AM', '2022/02/11'),
(223, 8, 'Red minecraft', 'Delete Automated Salary', '09:59:15 AM', '2022/02/11'),
(224, 8, 'Red minecraft', 'Delete Automated Salary', '09:59:17 AM', '2022/02/11'),
(225, 8, 'Red minecraft', 'Delete Automated Salary', '09:59:20 AM', '2022/02/11'),
(226, 8, 'Red minecraft', 'Add Automated Salary', '09:59:22 AM', '2022/02/11'),
(227, 8, 'Red minecraft', 'Delete Automated Salary', '09:59:47 AM', '2022/02/11'),
(228, 8, 'Red minecraft', 'Delete Cash Advance', '09:59:54 AM', '2022/02/11'),
(229, 8, 'Red minecraft', 'Add Cash Advance', '10:00:25 AM', '2022/02/11'),
(230, 8, 'Red minecraft', 'Add Cash Advance', '10:00:31 AM', '2022/02/11'),
(231, 8, 'Red minecraft', 'Delete Cash Advance', '10:00:44 AM', '2022/02/11'),
(232, 8, 'Red minecraft', 'Delete Cash Advance', '10:00:47 AM', '2022/02/11'),
(233, 8, 'Red minecraft', 'Add Cash Advance', '10:01:42 AM', '2022/02/11'),
(234, 8, 'Red minecraft', 'Add Automated Salary', '10:01:47 AM', '2022/02/11'),
(235, 8, 'Red minecraft', 'Delete Automated Salary', '10:03:25 AM', '2022/02/11'),
(236, 8, 'Red minecraft', 'Add Automated Salary', '10:03:27 AM', '2022/02/11'),
(237, 8, 'Red minecraft', 'Add Automated Salary', '10:05:56 AM', '2022/02/11'),
(238, 8, 'Red minecraft', 'login', '12:32:08 PM', '2022/02/11'),
(239, 8, 'Red minecraft', 'Delete Automated Salary', '12:40:41 PM', '2022/02/11'),
(240, 8, 'Red minecraft', 'Delete Automated Salary', '12:40:43 PM', '2022/02/11'),
(241, 8, 'Red minecraft', 'Add Automated Salary', '12:40:51 PM', '2022/02/11'),
(242, 8, 'Red minecraft', 'Delete Salary', '12:52:19 PM', '2022/02/11'),
(243, 8, 'Red minecraft', 'Add Salary', '12:53:00 PM', '2022/02/11'),
(244, 8, 'Red minecraft', 'Add Salary', '01:25:02 PM', '2022/02/11'),
(245, 8, 'Red minecraft', 'login', '11:44:30 AM', '2022/02/15'),
(246, 8, 'Red minecraft', 'Add Automated Salary', '11:59:23 AM', '2022/02/15'),
(247, 8, 'Red minecraft', 'login', '09:30:12 PM', '2022/02/17'),
(248, 8, 'Red minecraft', 'Add Cash Advance', '01:56:23 AM', '2022/02/18'),
(249, 8, 'Red minecraft', 'Add Automated Salary', '02:15:14 AM', '2022/02/18'),
(250, 8, 'Red minecraft', 'Add Automated Salary', '02:15:15 AM', '2022/02/18'),
(251, 8, 'Red minecraft', 'Add Automated Salary', '02:15:16 AM', '2022/02/18'),
(252, 8, 'Red minecraft', 'Add Automated Salary', '02:15:17 AM', '2022/02/18'),
(253, 8, 'Red minecraft', 'Add Automated Salary', '02:15:18 AM', '2022/02/18'),
(254, 8, 'Red minecraft', 'Add Automated Salary', '02:15:18 AM', '2022/02/18'),
(255, 8, 'Red minecraft', 'Delete Automated Salary', '02:15:22 AM', '2022/02/18'),
(256, 8, 'Red minecraft', 'Delete Automated Salary', '02:15:24 AM', '2022/02/18'),
(257, 8, 'Red minecraft', 'Delete Automated Salary', '02:15:26 AM', '2022/02/18'),
(258, 8, 'Red minecraft', 'Delete Automated Salary', '02:15:28 AM', '2022/02/18'),
(259, 8, 'Red minecraft', 'Delete Automated Salary', '02:15:31 AM', '2022/02/18'),
(260, 8, 'Red minecraft', 'Delete Automated Salary', '02:15:59 AM', '2022/02/18'),
(261, 8, 'Red minecraft', 'Delete Automated Salary', '02:16:01 AM', '2022/02/18'),
(262, 8, 'Red minecraft', 'Delete Automated Salary', '02:16:04 AM', '2022/02/18'),
(263, 8, 'Red minecraft', 'Add Automated Salary', '02:16:10 AM', '2022/02/18'),
(264, 8, 'Red minecraft', 'login', '03:20:13 PM', '2022/02/18'),
(265, 8, 'Red minecraft', 'Delete Automated Salary', '03:22:26 PM', '2022/02/18'),
(266, 8, 'Red minecraft', 'Add Automated Salary', '03:22:45 PM', '2022/02/18'),
(267, 8, 'Red minecraft', 'Add Cash Advance', '03:30:00 PM', '2022/02/18'),
(268, 8, 'Red minecraft', 'Add Automated Salary', '03:30:09 PM', '2022/02/18'),
(269, 8, 'Red minecraft', 'login', '04:47:58 PM', '2022/02/21'),
(270, 8, 'Red minecraft', 'Delete Automated Salary', '04:53:50 PM', '2022/02/21'),
(271, 8, 'Red minecraft', 'Delete Automated Salary', '04:53:52 PM', '2022/02/21'),
(272, 8, 'Red minecraft', 'Add Automated Salary', '04:53:55 PM', '2022/02/21'),
(273, 8, 'Red minecraft', 'Delete Cash Advance', '05:00:19 PM', '2022/02/21'),
(274, 8, 'Red minecraft', 'Delete Cash Advance', '05:00:23 PM', '2022/02/21'),
(275, 8, 'Red minecraft', 'Delete Cash Advance', '05:00:26 PM', '2022/02/21'),
(276, 8, 'Red minecraft', 'Add Cash Advance', '05:00:38 PM', '2022/02/21'),
(277, 8, 'Red minecraft', 'Add Automated Salary', '05:00:49 PM', '2022/02/21'),
(278, 8, 'Red minecraft', 'login', '03:29:34 PM', '2022/02/23'),
(279, 8, 'Red minecraft', 'Add Automated Salary', '03:30:28 PM', '2022/02/23'),
(280, 8, 'Red minecraft', 'Delete Automated Salary', '04:27:19 PM', '2022/02/23'),
(281, 8, 'Red minecraft', 'Add Automated Salary', '04:27:22 PM', '2022/02/23'),
(282, 8, 'Red minecraft', 'Add Automated Salary', '04:33:53 PM', '2022/02/23'),
(283, 8, 'Red minecraft', 'Delete Automated Salary', '04:33:56 PM', '2022/02/23'),
(284, 8, 'Red minecraft', 'Delete Automated Salary', '04:33:58 PM', '2022/02/23'),
(285, 8, 'Red minecraft', 'Delete Automated Salary', '04:34:00 PM', '2022/02/23'),
(286, 8, 'Red minecraft', 'Add Automated Salary', '04:34:04 PM', '2022/02/23'),
(287, 8, 'Red minecraft', 'Add Automated Salary', '04:34:06 PM', '2022/02/23'),
(288, 8, 'Red minecraft', 'Delete Automated Salary', '04:34:15 PM', '2022/02/23'),
(289, 8, 'Red minecraft', 'Delete Automated Salary', '04:34:18 PM', '2022/02/23'),
(290, 8, 'Red minecraft', 'Add Automated Salary', '04:36:09 PM', '2022/02/23'),
(291, 8, 'Red minecraft', 'Delete Automated Salary', '04:36:12 PM', '2022/02/23'),
(292, 8, 'Red minecraft', 'Delete Automated Salary', '04:36:14 PM', '2022/02/23');

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
-- Indexes for table `automatic_generated_salary`
--
ALTER TABLE `automatic_generated_salary`
  ADD PRIMARY KEY (`log`);

--
-- Indexes for table `cashadvance`
--
ALTER TABLE `cashadvance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
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
-- Indexes for table `emp_schedule`
--
ALTER TABLE `emp_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `generated_salary`
--
ALTER TABLE `generated_salary`
  ADD PRIMARY KEY (`log`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `automatic_generated_salary`
--
ALTER TABLE `automatic_generated_salary`
  MODIFY `log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT for table `cashadvance`
--
ALTER TABLE `cashadvance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `emp_info`
--
ALTER TABLE `emp_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `emp_schedule`
--
ALTER TABLE `emp_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `generated_salary`
--
ALTER TABLE `generated_salary`
  MODIFY `log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `secretary`
--
ALTER TABLE `secretary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `secretary_log`
--
ALTER TABLE `secretary_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=293;

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
  ADD CONSTRAINT `emp_attendance_ibfk_1` FOREIGN KEY (`empId`) REFERENCES `emp_info` (`empId`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `generated_salary`
--
ALTER TABLE `generated_salary`
  ADD CONSTRAINT `generated_salary_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `emp_info` (`empId`) ON DELETE NO ACTION ON UPDATE CASCADE;

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
