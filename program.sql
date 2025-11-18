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
-- Struktur dari tabel `program`
--

CREATE TABLE `program` (
  `activity_id` int(11) NOT NULL,
  `program_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(150) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `program_img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `program`
--

INSERT INTO `program` (`activity_id`, `program_name`, `description`, `location`, `date`, `time`, `updated_at`, `program_img`) VALUES
(1, 'Beach Cleanup Day', 'Acara bersih-bersih pantai untuk meningkatkan kepedulian lingkungan dan menjaga kebersihan area wisata. Relawan akan bekerja sama mengumpulkan sampah, memilah plastik, dan mengedukasi pengunjung.', 'Pantai Kuta, Bali', '2025-01-15', '08:00:00', '2025-11-14 16:54:44', NULL),
(2, 'Coral Reef Restoration', 'Kegiatan restorasi terumbu karang untuk memulihkan ekosistem bawah laut. Relawan membantu penanaman karang, pembersihan substrat, dan edukasi konservasi.', 'Pulau Menjangan, Bali', '2025-04-12', '08:00:00', '2025-11-14 17:49:52', NULL),
(3, 'Beach Wildlife Rescue', 'Relawan membantu penyelamatan hewan laut seperti penyu dan burung pantai yang terluka akibat sampah. Termasuk pembersihan habitat pesisir.', 'Pangumbahan Turtle Sanctuary, Sukabumi', '2025-06-20', '07:30:00', '2025-11-14 17:49:52', NULL),
(4, 'Coastal Mangrove Restoration', 'Penanaman mangrove untuk mencegah abrasi dan melindungi ekosistem laut. Relawan juga diberikan pelatihan identifikasi jenis mangrove.', 'Mangrove Center, Surabaya', '2025-07-14', '08:30:00', '2025-11-14 17:51:39', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`activity_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `program`
--
ALTER TABLE `program`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
