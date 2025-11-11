-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Nov 2025 pada 19.34
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
-- Struktur dari tabel `merchandise`
--

CREATE TABLE `merchandise` (
  `merch_id` int(11) NOT NULL,
  `merch_name` varchar(100) DEFAULT NULL,
  `merch_pict` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` enum('Tersedia','Habis') DEFAULT 'Tersedia',
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `merchandise`
--

INSERT INTO `merchandise` (`merch_id`, `merch_name`, `merch_pict`, `price`, `status`, `description`) VALUES
(3, 'Gelang Ombak Biru', 'merch.png', 75000.00, 'Tersedia', 'Terinspirasi dari warna laut dalam, gelang ini terbuat dari tali daur ulang jaring nelayan yang tersapu ombak. Setiap pembelian membantu program pembersihan pantai di pesisir Malang.'),
(5, 'Gelang Nautica Soul', 'merch3.png', 90000.00, 'Habis', 'Dirangkai dari tali biodegradable dengan gantungan berbentuk jangkar perak daur ulang. Melambangkan semangat pelestarian laut dan kekuatan untuk menjaga alam.'),
(6, 'Gelang Samudra Hijau', 'merch4.png', 70000.00, 'Tersedia', 'Warna hijau toska pada gelang ini merepresentasikan hutan mangrove. Terbuat dari serat alami dan plastik laut yang telah dibersihkan. Setiap pembelian mendukung penanaman mangrove baru.'),
(7, 'Gelang Pearl of Hope', 'merch5.png', 95000.00, 'Tersedia', 'Menampilkan manik-manik menyerupai mutiara yang dibuat dari limbah mikroplastik hasil daur ulang. Simbol harapan akan laut yang bersih dan sehat.'),
(8, 'Gelang Tide Harmony', 'merch7.png', 80000.00, 'Tersedia', 'Gelang ganda dengan warna gradasi biru-putih, menggambarkan ombak yang selaras. Terbuat dari tali PET daur ulang. Sebagian hasil penjualan untuk edukasi lingkungan laut di sekolah pesisir.'),
(9, 'Gelang Blue Guardian', 'merch6.png', 100000.00, 'Tersedia', 'Didesain elegan dengan charm kecil berbentuk kura-kura laut. Setiap pembelian berkontribusi pada penyelamatan dan pelepasan tukik ke habitat aslinya'),
(10, 'Gelang Coral Spirit', 'merch8.png', 85000.00, 'Tersedia', 'Gelang berwarna coral orange dan pasir putih ini dibuat dari serat rami alami dan pasir laut yang sudah disterilisasi. Menggambarkan semangat menjaga keindahan bawah laut.'),
(11, 'Gelang Karang Lestari', 'merch2.png', 85000.00, 'Tersedia', 'Setiap gelang mengandung serpihan kaca laut (sea glass) hasil daur ulang dari limbah botol yang ditemukan di sekitar terumbu karang. Hasil penjualan disumbangkan untuk rehabilitasi terumbu karang.');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `merchandise`
--
ALTER TABLE `merchandise`
  ADD PRIMARY KEY (`merch_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `merchandise`
--
ALTER TABLE `merchandise`
  MODIFY `merch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
