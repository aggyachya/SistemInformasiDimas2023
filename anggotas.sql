-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2023 at 06:39 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dimas_2023`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggotas`
--

CREATE TABLE `anggotas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jurusan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `angkatan` varchar(255) NOT NULL,
  `posisi` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `motor` enum('yes','no') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggotas`
--

INSERT INTO `anggotas` (`id`, `nama_lengkap`, `jurusan_id`, `angkatan`, `posisi`, `jabatan`, `nickname`, `jenis_kelamin`, `tanggal_lahir`, `motor`, `created_at`, `updated_at`) VALUES
(1, 'Muhammad Windu Fathoni', 1, '2020', 'Fungsio', 'Korbid', 'Windu', 'Laki-laki', '2002-10-18', 'yes', '2023-10-04 04:38:54', '2023-10-04 04:38:54'),
(2, 'Rafli Anang Pangestu', 4, '2020', 'Fungsio', 'Kabid', 'Anang', 'Laki-laki', '2002-01-20', 'yes', NULL, '2023-10-03 05:32:56'),
(3, 'Aggy Achya Fadhlika', 7, '2020', 'Fungsio', 'Wakabid', 'Aggy', 'Laki-laki', '2003-03-05', 'yes', '2023-10-03 07:12:53', '2023-10-03 07:12:53'),
(4, 'Fathya Salshabilla', 6, '2021', 'Fungsio', 'Sekretaris', 'Caca', 'Perempuan', '2002-09-15', 'no', NULL, '2023-10-03 05:33:10'),
(5, 'Rifendha Lulu Qolbie Kinanti', 6, '2021', 'Fungsio', 'Bendahara', 'Rifen', 'Perempuan', '2003-02-28', 'no', NULL, '2023-10-03 05:33:21'),
(6, 'Rayhan Wildan Manaf', 6, '2021', 'Fungsio', 'Kadiv', 'Raymen', 'Laki-laki', '2002-05-17', 'yes', NULL, '2023-10-03 05:33:34'),
(7, 'Rahima Aida Zakiyya', 2, '2021', 'Fungsio', 'Kadiv', 'Rahima', 'Perempuan', '2003-06-25', 'no', NULL, '2023-10-03 05:33:48'),
(8, 'Nayla Izza Azhari', 9, '2021', 'Fungsio', 'Staf Ahli', 'Nayla', 'Perempuan', '2003-08-30', 'no', NULL, '2023-10-03 05:34:00'),
(9, 'Ayeshia Putri Ichsanti', 2, '2022', 'Desbin', 'Staf Muda', 'Yeshi', 'Perempuan', '2004-07-15', 'yes', NULL, '2023-10-03 05:34:08'),
(10, 'Iqbal Pahlevi', 4, '2022', 'Desbin', 'Staf Muda', 'Iqbal', 'Laki-laki', '2003-11-03', 'yes', NULL, '2023-10-03 05:34:17'),
(11, 'Gilang Putra Perdana', 6, '2022', 'Desbin', 'Staf Muda', 'Gilang', 'Laki-laki', '2004-07-16', 'yes', NULL, '2023-10-03 05:34:30'),
(12, 'Mohammad Husen Afansyah', 11, '2022', 'RBT', 'Staf Muda', 'Husen', 'Laki-laki', '2003-10-02', 'yes', NULL, '2023-10-03 05:35:09'),
(13, 'Anandintya Madya Maharani', 6, '2022', 'RBT', 'Staf Muda', 'Andin', 'Perempuan', '2004-08-16', 'yes', NULL, '2023-10-03 05:35:26'),
(14, 'Almafadia Jauzaa', 6, '2022', 'TPL', 'Staf Muda', 'Alma', 'Perempuan', '2004-05-10', 'yes', NULL, '2023-10-03 05:50:42'),
(15, 'Naufal Mulya Andzaka', 10, '2021', 'TPL', 'Staf Muda', 'Opang', 'Laki-laki', '2002-04-23', 'yes', NULL, '2023-10-03 05:55:14'),
(16, 'Farrel Ghaisan Attari', 3, '2022', 'Ankas', 'Staf Muda', 'Farrel', 'Laki-laki', '2004-05-26', 'yes', NULL, '2023-10-03 05:53:03'),
(17, 'Diva Annisa Putri Najwa', 4, '2022', 'Ankas', 'Staf Muda', 'Dipoy', 'Perempuan', '2004-07-30', 'no', NULL, '2023-10-03 05:53:14'),
(18, 'Alayya Fitriasti', 3, '2022', 'Ankas', 'Staf Muda', 'Ayya', 'Perempuan', '2003-11-26', 'no', NULL, '2023-10-03 05:53:27'),
(19, 'Zakly Rachmad Tanjung', 6, '2022', 'Fordimas', 'Staf Muda', 'Zakly', 'Laki-laki', '2003-08-16', 'yes', NULL, '2023-10-03 05:53:44'),
(20, 'Redina Dwi Muryana', 4, '2022', 'Fordimas', 'Staf Muda', 'Redina', 'Perempuan', '2003-12-12', 'no', NULL, '2023-10-03 05:53:52'),
(21, 'Dita Aditama Dewi', 6, '2022', 'Fungsio', 'Supervisi PMO', 'Dita', 'Perempuan', '2003-12-06', 'yes', '2023-10-03 05:28:41', '2023-10-03 05:28:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggotas`
--
ALTER TABLE `anggotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anggotas_jurusan_id_foreign` (`jurusan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggotas`
--
ALTER TABLE `anggotas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggotas`
--
ALTER TABLE `anggotas`
  ADD CONSTRAINT `anggotas_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusans` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
