-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Jan 2025 pada 07.59
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
(5, 'el', 'el\r\nel', '082344', '08568568568544', '2025-01-24 06:33:11'),
(6, 'el', 'el\r\nel', '082344', '08568568568544', '2025-01-24 06:33:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `internships`
--

CREATE TABLE `internships` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `period_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 1, 1, 4, '2025-01-29'),
(2, 2, 1, 4, '2025-01-30');

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
(1, 'Brian Russell', '001', '08568568568544', '2025-01-24 03:39:53');

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
(5, '082344', '444', '2025-01-24 06:47:35');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `internship_periods`
--
ALTER TABLE `internship_periods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `monitoring`
--
ALTER TABLE `monitoring`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
