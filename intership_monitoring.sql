-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Jan 2025 pada 11.13
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `intership_monitoring`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_fake_students` (IN `count` INT)   BEGIN
    DECLARE i INT DEFAULT 0;
    WHILE i < count DO
        INSERT INTO students (name, student_id, contact_info)
        VALUES (
            CONCAT('Student_', FLOOR(1 + (RAND() * 1000))),
            CONCAT('SID-', FLOOR(1000 + (RAND() * 9000))),
            CONCAT('+62', FLOOR(8000000000 + (RAND() * 999999999)))
        );
        SET i = i + 1;
    END WHILE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_fake_teacher` (IN `count` INT)   BEGIN
    DECLARE i INT DEFAULT 0;
    WHILE i < count DO
        INSERT INTO teachers (name,  contact_info)
        VALUES (
            CONCAT('teacher_', FLOOR(1 + (RAND() * 1000))),
            CONCAT('+62', FLOOR(8000000000 + (RAND() * 999999999)))
        );
        SET i = i + 1;
    END WHILE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_fake_teachers` (IN `count` INT)   BEGIN
    DECLARE i INT DEFAULT 0;
    WHILE i < count DO
        INSERT INTO teacherss (name,  contact_info)
        VALUES (
            CONCAT('teacher_', FLOOR(1 + (RAND() * 1000))),
            CONCAT('+62', FLOOR(8000000000 + (RAND() * 999999999)))
        );
        SET i = i + 1;
    END WHILE;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `contact_info` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `companies`
--

INSERT INTO `companies` (`id`, `name`, `address`, `contact_person`, `contact_info`, `created_at`) VALUES
(4, 'el', 'el\r\nel', '082344', '08568568568544', '2025-01-24 06:33:06'),
(5, 'el2', 'el\r\nel', '082344', '08568568568544', '2025-01-24 06:33:11'),
(6, 'el3', 'el\r\nel', '082344', '08568568568544', '2025-01-24 06:33:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `internships`
--

CREATE TABLE `internships` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `period_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `internships`
--

INSERT INTO `internships` (`id`, `student_id`, `teacher_id`, `company_id`, `period_id`, `created_at`) VALUES
(1, 1, 6, 4, 1, '2025-01-24 09:02:54'),
(4, 6, 6, 5, 1, '2025-01-24 09:18:42'),
(5, 19, 6, 5, 1, '2025-01-24 09:18:56'),
(6, 1, 6, 6, 1, '2025-01-24 09:19:18'),
(7, 21, 20, 4, 4, '2025-01-24 09:30:10'),
(8, 21, 20, 4, 4, '2025-01-24 09:31:44'),
(9, 19, 21, 4, 4, '2025-01-24 09:31:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `internship_periods`
--

CREATE TABLE `internship_periods` (
  `id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `internship_periods`
--

INSERT INTO `internship_periods` (`id`, `start_date`, `end_date`, `description`, `created_at`) VALUES
(1, '2025-01-01', '2025-01-31', 'periode pertama', '2025-01-24 07:44:25'),
(4, '2025-01-10', '2025-01-20', 'kedua', '2025-01-24 07:47:43'),
(5, '2025-01-20', '2025-01-30', 'ketiga', '2025-01-24 07:47:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `monitoring`
--

CREATE TABLE `monitoring` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `monitoring_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `monitoring`
--

INSERT INTO `monitoring` (`id`, `teacher_id`, `student_id`, `company_id`, `monitoring_date`) VALUES
(1, 6, 1, 4, '2025-01-01'),
(2, 6, 6, 5, '2025-01-01'),
(3, 6, 19, 5, '2025-01-01'),
(4, 6, 1, 6, '2025-01-01'),
(5, 6, 1, 4, '2025-01-08'),
(6, 6, 6, 5, '2025-01-08'),
(7, 6, 19, 5, '2025-01-08'),
(8, 6, 1, 6, '2025-01-08'),
(9, 6, 1, 4, '2025-01-15'),
(10, 6, 6, 5, '2025-01-15'),
(11, 6, 19, 5, '2025-01-15'),
(12, 6, 1, 6, '2025-01-15'),
(13, 6, 1, 4, '2025-01-22'),
(14, 6, 6, 5, '2025-01-22'),
(15, 6, 19, 5, '2025-01-22'),
(16, 6, 1, 6, '2025-01-22'),
(17, 6, 1, 4, '2025-01-29'),
(18, 6, 6, 5, '2025-01-29'),
(19, 6, 19, 5, '2025-01-29'),
(20, 6, 1, 6, '2025-01-29'),
(21, 20, 21, 4, '2025-01-10'),
(22, 20, 21, 4, '2025-01-10'),
(23, 21, 19, 4, '2025-01-10'),
(24, 20, 21, 4, '2025-01-17'),
(25, 20, 21, 4, '2025-01-17'),
(26, 21, 19, 4, '2025-01-17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `contact_info` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `students`
--

INSERT INTO `students` (`id`, `name`, `student_id`, `contact_info`, `created_at`) VALUES
(1, 'Brian Russell', '001', '08568568568544', '2025-01-24 03:39:53'),
(4, 'Student_546', 'SID-8560', '+628564757667', '2025-01-24 07:08:37'),
(5, 'Student_304', 'SID-8419', '+628210582496', '2025-01-24 07:08:37'),
(6, 'Student_580', 'SID-3407', '+628598144304', '2025-01-24 07:08:37'),
(7, 'Student_189', 'SID-2314', '+628165818624', '2025-01-24 07:08:38'),
(8, 'Student_392', 'SID-5119', '+628115595297', '2025-01-24 07:08:38'),
(9, 'Student_205', 'SID-7092', '+628770522579', '2025-01-24 07:08:38'),
(10, 'Student_822', 'SID-8174', '+628520734973', '2025-01-24 07:08:38'),
(11, 'Student_213', 'SID-5483', '+628854689828', '2025-01-24 07:08:38'),
(12, 'Student_779', 'SID-3973', '+628315343694', '2025-01-24 07:08:38'),
(13, 'Student_586', 'SID-9833', '+628150871796', '2025-01-24 07:08:38'),
(14, 'Student_810', 'SID-6373', '+628555465565', '2025-01-24 07:08:38'),
(15, 'Student_987', 'SID-3379', '+628363708334', '2025-01-24 07:08:38'),
(16, 'Student_26', 'SID-1314', '+628099098077', '2025-01-24 07:08:38'),
(17, 'Student_391', 'SID-6903', '+628107722815', '2025-01-24 07:08:38'),
(18, 'Student_571', 'SID-5778', '+628942178707', '2025-01-24 07:08:39'),
(19, 'Student_119', 'SID-7876', '+628465782262', '2025-01-24 07:08:39'),
(20, 'Student_37', 'SID-8081', '+628823757494', '2025-01-24 07:08:39'),
(21, 'Student_759', 'SID-3878', '+628324480147', '2025-01-24 07:08:39'),
(22, 'Student_663', 'SID-4070', '+628716961009', '2025-01-24 07:08:39'),
(23, 'Student_562', 'SID-6904', '+628595918425', '2025-01-24 07:08:39'),
(24, 'Student_12', 'SID-3430', '+628315528398', '2025-01-24 07:08:39'),
(25, 'Student_768', 'SID-9019', '+628152475992', '2025-01-24 07:08:39'),
(26, 'Student_90', 'SID-9904', '+628678814222', '2025-01-24 07:08:39'),
(27, 'Student_426', 'SID-1838', '+628188287623', '2025-01-24 07:08:39'),
(28, 'Student_662', 'SID-7696', '+628735027455', '2025-01-24 07:08:39'),
(29, 'Student_443', 'SID-1084', '+628718432278', '2025-01-24 07:08:39'),
(30, 'Student_564', 'SID-6976', '+628628842597', '2025-01-24 07:08:39'),
(31, 'Student_152', 'SID-8857', '+628909737936', '2025-01-24 07:08:39'),
(32, 'Student_930', 'SID-9259', '+628800286405', '2025-01-24 07:08:39'),
(33, 'Student_249', 'SID-8569', '+628459989814', '2025-01-24 07:08:40'),
(34, 'Student_777', 'SID-5539', '+628191453784', '2025-01-24 07:08:40'),
(35, 'Student_445', 'SID-6811', '+628896579395', '2025-01-24 07:08:40'),
(36, 'Student_546', 'SID-1349', '+628557101150', '2025-01-24 07:08:40'),
(37, 'Student_669', 'SID-7061', '+628360450003', '2025-01-24 07:08:40'),
(38, 'Student_782', 'SID-8451', '+628794270797', '2025-01-24 07:08:40'),
(39, 'Student_488', 'SID-1489', '+628809515369', '2025-01-24 07:08:40'),
(40, 'Student_885', 'SID-9944', '+628315919632', '2025-01-24 07:08:40'),
(41, 'Student_598', 'SID-1379', '+628416657201', '2025-01-24 07:08:40'),
(42, 'Student_957', 'SID-5812', '+628802747709', '2025-01-24 07:08:40'),
(43, 'Student_410', 'SID-6757', '+628970073968', '2025-01-24 07:08:40'),
(44, 'Student_932', 'SID-7704', '+628931730941', '2025-01-24 07:08:40'),
(45, 'Student_424', 'SID-3911', '+628346479851', '2025-01-24 07:08:40'),
(46, 'Student_762', 'SID-7924', '+628561654309', '2025-01-24 07:08:40'),
(47, 'Student_501', 'SID-8339', '+628577390412', '2025-01-24 07:08:40'),
(48, 'Student_441', 'SID-5225', '+628026568287', '2025-01-24 07:08:40'),
(49, 'Student_725', 'SID-5875', '+628535923478', '2025-01-24 07:08:40'),
(50, 'Student_55', 'SID-6975', '+628156536117', '2025-01-24 07:08:41'),
(51, 'Student_791', 'SID-5366', '+628052957060', '2025-01-24 07:08:41'),
(52, 'Student_810', 'SID-8988', '+628010091293', '2025-01-24 07:08:41'),
(53, 'Student_388', 'SID-9172', '+628377464445', '2025-01-24 07:08:41'),
(54, 'Student_164', 'SID-7144', '+628924692322', '2025-01-24 07:08:41'),
(55, 'Student_576', 'SID-1916', '+628783847433', '2025-01-24 07:08:41'),
(56, 'Student_614', 'SID-7447', '+628741103606', '2025-01-24 07:08:41'),
(57, 'Student_557', 'SID-6028', '+628124409432', '2025-01-24 07:08:41'),
(58, 'Student_946', 'SID-4205', '+628942958819', '2025-01-24 07:08:41'),
(59, 'Student_647', 'SID-4630', '+628077652561', '2025-01-24 07:08:41'),
(60, 'Student_179', 'SID-6915', '+628752318366', '2025-01-24 07:08:41'),
(61, 'Student_790', 'SID-7224', '+628088851806', '2025-01-24 07:08:41'),
(62, 'Student_370', 'SID-6227', '+628795550228', '2025-01-24 07:08:41'),
(63, 'Student_236', 'SID-8112', '+628245021121', '2025-01-24 07:08:41'),
(64, 'Student_855', 'SID-5833', '+628121835163', '2025-01-24 07:08:41'),
(65, 'Student_999', 'SID-6626', '+628131244421', '2025-01-24 07:08:42'),
(66, 'Student_781', 'SID-5594', '+628210005937', '2025-01-24 07:08:42'),
(67, 'Student_519', 'SID-9662', '+628256877189', '2025-01-24 07:08:42'),
(68, 'Student_397', 'SID-2927', '+628880016468', '2025-01-24 07:08:42'),
(69, 'Student_758', 'SID-2328', '+628465635017', '2025-01-24 07:08:42'),
(70, 'Student_886', 'SID-1262', '+628490358361', '2025-01-24 07:08:42'),
(71, 'Student_365', 'SID-4148', '+628656525033', '2025-01-24 07:08:42'),
(72, 'Student_234', 'SID-2767', '+628282328568', '2025-01-24 07:08:42'),
(73, 'Student_823', 'SID-3389', '+628860111168', '2025-01-24 07:08:42'),
(74, 'Student_504', 'SID-9456', '+628186023795', '2025-01-24 07:08:42'),
(75, 'Student_112', 'SID-9987', '+628658903641', '2025-01-24 07:08:42'),
(76, 'Student_299', 'SID-5654', '+628689650505', '2025-01-24 07:08:42'),
(77, 'Student_897', 'SID-4728', '+628381643771', '2025-01-24 07:08:42'),
(78, 'Student_666', 'SID-2632', '+628910939647', '2025-01-24 07:08:43'),
(79, 'Student_11', 'SID-3885', '+628570791658', '2025-01-24 07:08:43'),
(80, 'Student_893', 'SID-7740', '+628067963842', '2025-01-24 07:08:43'),
(81, 'Student_93', 'SID-3348', '+628025734181', '2025-01-24 07:08:43'),
(82, 'Student_346', 'SID-6870', '+628223712377', '2025-01-24 07:08:43'),
(83, 'Student_162', 'SID-2237', '+628202168893', '2025-01-24 07:08:43'),
(84, 'Student_599', 'SID-4471', '+628133278867', '2025-01-24 07:08:43'),
(85, 'Student_510', 'SID-2316', '+628203750868', '2025-01-24 07:08:43'),
(86, 'Student_580', 'SID-3594', '+628701541660', '2025-01-24 07:08:43'),
(87, 'Student_643', 'SID-1991', '+628622061028', '2025-01-24 07:08:43'),
(88, 'Student_780', 'SID-1292', '+628823259048', '2025-01-24 07:08:43'),
(89, 'Student_19', 'SID-6618', '+628065077736', '2025-01-24 07:08:43'),
(90, 'Student_453', 'SID-1604', '+628978226238', '2025-01-24 07:08:43'),
(91, 'Student_690', 'SID-5626', '+628501001879', '2025-01-24 07:08:43'),
(92, 'Student_963', 'SID-3801', '+628668043526', '2025-01-24 07:08:43'),
(93, 'Student_407', 'SID-1243', '+628916433031', '2025-01-24 07:08:43'),
(94, 'Student_502', 'SID-7805', '+628277468958', '2025-01-24 07:08:43'),
(95, 'Student_119', 'SID-7858', '+628453826449', '2025-01-24 07:08:43'),
(96, 'Student_983', 'SID-5973', '+628814455719', '2025-01-24 07:08:43'),
(97, 'Student_415', 'SID-6664', '+628903145074', '2025-01-24 07:08:44'),
(98, 'Student_628', 'SID-4859', '+628261303201', '2025-01-24 07:08:44'),
(99, 'Student_20', 'SID-3842', '+628519340679', '2025-01-24 07:08:44'),
(100, 'Student_650', 'SID-7191', '+628492069518', '2025-01-24 07:08:44'),
(101, 'Student_397', 'SID-5559', '+628343364742', '2025-01-24 07:08:44'),
(102, 'Student_197', 'SID-9593', '+628183304026', '2025-01-24 07:08:44'),
(103, 'Student_52', 'SID-7388', '+628393475690', '2025-01-24 07:08:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact_info` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `contact_info`, `created_at`) VALUES
(1, 'pak guru', '2352362wrqwrqw', '2025-01-24 06:44:26'),
(2, 'fdhd', 'dfhdfhd', '2025-01-24 06:46:02'),
(4, 'wwetwe', 'wetwe', '2025-01-24 06:47:30'),
(6, 'teacher_211', '+628928420253', '2025-01-24 07:12:08'),
(7, 'teacher_11', '+628266100008', '2025-01-24 07:12:08'),
(8, 'teacher_300', '+628700118165', '2025-01-24 07:12:08'),
(9, 'teacher_602', '+628907345348', '2025-01-24 07:12:08'),
(10, 'teacher_733', '+628938498427', '2025-01-24 07:12:08'),
(11, 'teacher_497', '+628665362260', '2025-01-24 07:12:08'),
(12, 'teacher_839', '+628195397381', '2025-01-24 07:12:08'),
(13, 'teacher_463', '+628724290182', '2025-01-24 07:12:09'),
(14, 'teacher_236', '+628002937326', '2025-01-24 07:12:09'),
(15, 'teacher_310', '+628537197822', '2025-01-24 07:12:09'),
(16, 'teacher_759', '+628180322981', '2025-01-24 07:12:09'),
(17, 'teacher_627', '+628591356517', '2025-01-24 07:12:09'),
(18, 'teacher_78', '+628612867289', '2025-01-24 07:12:09'),
(19, 'teacher_833', '+628322270117', '2025-01-24 07:12:09'),
(20, 'teacher_115', '+628607326909', '2025-01-24 07:12:09'),
(21, 'teacher_693', '+628638780512', '2025-01-24 07:12:09'),
(22, 'teacher_118', '+628670887837', '2025-01-24 07:12:09'),
(23, 'teacher_3', '+628997844573', '2025-01-24 07:12:09'),
(24, 'teacher_983', '+628921056642', '2025-01-24 07:12:09'),
(25, 'teacher_657', '+628519475327', '2025-01-24 07:12:09');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `internships`
--
ALTER TABLE `internships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `period_id` (`period_id`);

--
-- Indeks untuk tabel `internship_periods`
--
ALTER TABLE `internship_periods`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `monitoring`
--
ALTER TABLE `monitoring`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indeks untuk tabel `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indeks untuk tabel `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `internships`
--
ALTER TABLE `internships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `internship_periods`
--
ALTER TABLE `internship_periods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `monitoring`
--
ALTER TABLE `monitoring`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT untuk tabel `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `internships`
--
ALTER TABLE `internships`
  ADD CONSTRAINT `internships_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `internships_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `internships_ibfk_3` FOREIGN KEY (`period_id`) REFERENCES `internship_periods` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `monitoring`
--
ALTER TABLE `monitoring`
  ADD CONSTRAINT `monitoring_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`),
  ADD CONSTRAINT `monitoring_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `monitoring_ibfk_3` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
