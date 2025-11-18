-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Nov 2025 pada 21.24
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
-- Struktur dari tabel `donasi`
--

CREATE TABLE `donasi` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `country` varchar(50) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `donation_amount` decimal(12,2) NOT NULL,
  `payment_method` enum('Qris') NOT NULL,
  `anonymous_donation` tinyint(1) DEFAULT 0,
  `status` enum('pending','paid') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `donasi`
--

INSERT INTO `donasi` (`id`, `firstname`, `lastname`, `email`, `country`, `phone`, `donation_amount`, `payment_method`, `anonymous_donation`, `status`, `created_at`) VALUES
(1, 'kus', 'rs', 'khkhk@gmail.sc', 'tuban', '1234446432231', 10.00, 'Qris', 0, 'pending', '2025-11-18 14:49:41'),
(23, 'kh', 'jh', 'muh@sc.x', 'jh', '11111111111111', 90.00, 'Qris', 0, 'pending', '2025-11-18 16:48:19'),
(28, 'hjj', 'jk', 'muh@sc.x', 'tuban', '22222222222', 111.00, 'Qris', 0, 'pending', '2025-11-18 19:35:53'),
(29, 'hjj', 'jk', 'muh@sc.x', 'tuban', '22222222222', 111.00, 'Qris', 0, 'pending', '2025-11-18 19:36:15'),
(30, 'ds', 'ds', 'dino@d.n', 'tuban', '11111111111111', 123.00, 'Qris', 0, 'pending', '2025-11-18 19:37:56'),
(31, 'sadf', 'asdf', 'dino@d.n', 'fsad', '12345678345', 2356.00, 'Qris', 0, 'pending', '2025-11-18 19:41:24');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `donasi`
--
ALTER TABLE `donasi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `donasi`
--
ALTER TABLE `donasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
