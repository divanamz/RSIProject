-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Nov 2025 pada 21.54
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rsidb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `volunteer`
--

CREATE TABLE `volunteer` (
  `regis_id` int(11) NOT NULL,
  `user_profile_id` int(11) DEFAULT NULL,
  `activity_id` int(11) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `regis_date` date DEFAULT curdate(),
  `confir_status` enum('Pending','Confirmed','Rejected') DEFAULT 'Pending',
  `email` varchar(150) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `address` text NOT NULL,
  `motivation` text NOT NULL,
  `file_support` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `volunteer`
--

INSERT INTO `volunteer` (`regis_id`, `user_profile_id`, `activity_id`, `fullname`, `regis_date`, `confir_status`, `email`, `country`, `phone`, `experience`, `reason`, `address`, `motivation`, `file_support`) VALUES
(1, NULL, 3, 'esa', '2025-11-18', 'Pending', 'muh@sc.x', NULL, '7656789090', NULL, NULL, 'kjhgfd', 'kljhgfd', NULL),
(2, NULL, 3, 'esa', '2025-11-18', 'Pending', 'muh@sc.x', NULL, '7656789090', NULL, NULL, 'kjhgfd', 'kljhgfd', NULL),
(3, NULL, 3, 'esa', '2025-11-18', 'Pending', 'muh@sc.x', NULL, '7656789090', NULL, NULL, 'kjhgfd', 'kljhgfd', NULL),
(4, NULL, 2, 'alis', '2025-11-18', 'Pending', 'alis@d.n', NULL, '98765432456', NULL, NULL, 'lkhgfdsg', 'hgfhjkl', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `volunteer`
--
ALTER TABLE `volunteer`
  ADD PRIMARY KEY (`regis_id`),
  ADD KEY `fk_volunteer_user_profile` (`user_profile_id`),
  ADD KEY `fk_volunteer_program` (`activity_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `volunteer`
--
ALTER TABLE `volunteer`
  MODIFY `regis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `volunteer`
--
ALTER TABLE `volunteer`
  ADD CONSTRAINT `fk_volunteer_program` FOREIGN KEY (`activity_id`) REFERENCES `program` (`activity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_volunteer_user_profile` FOREIGN KEY (`user_profile_id`) REFERENCES `user_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
