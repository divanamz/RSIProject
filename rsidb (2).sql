-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Nov 2025 pada 08.25
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
-- Struktur dari tabel `forum_categories`
--

CREATE TABLE `forum_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `forum_categories`
--

INSERT INTO `forum_categories` (`id`, `name`) VALUES
(1, 'Volunteer'),
(2, 'Konservasi Laut'),
(3, 'Donasi'),
(4, 'Edukasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `forum_comments`
--

CREATE TABLE `forum_comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `forum_posts`
--

CREATE TABLE `forum_posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `views` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `forum_posts`
--

INSERT INTO `forum_posts` (`id`, `user_id`, `category_id`, `title`, `content`, `created_at`, `views`) VALUES
(4, 1, 1, 'Bagaimana cara mengorganisir acara pembersihan pantai yang efektif?', 'Saya ingin mengorganisir acara pembersihan pantai di daerah saya, tapi bingung mulai dari mana. Apakah ada panduan atau tips dari teman-teman yang sudah berpengalaman?', '2025-11-18 17:39:02', 501),
(10, 1, 2, 'Bagaimana cara daftar volunteer terumbu karang', 'asdfghjklk;poiuytrewqazcvbnmjhgfds', '2025-11-19 03:31:06', 5),
(11, 1, 3, 'Bagaimana cara melakukan donasi di komunitas ini', 'aakpsadkasdjsbfasghsdeifebigidsaevbehfbsjcsv', '2025-11-19 03:45:13', 1),
(12, 1, 4, 'Apakah merch dijual terpisah', 'ASDFSVKDGJDSACHOEIDFVGFGHD', '2025-11-19 03:46:37', 11),
(13, 1, 3, 'How to Donate to the event i wanna participate', 'I want to donate to the event i participate but im confused what to do, can someone help me with this', '2025-11-25 13:03:45', 9),
(14, 1, 2, 'Apa aja benefit mengikuti event volunteer?', 'Pengen tau apa aja sih benefit yang kita dapet kalo ikut event ini? aku tertarik tapi masih bimbang karena sendiri jadi agak takut juga', '2025-11-25 13:11:52', 44);

-- --------------------------------------------------------

--
-- Struktur dari tabel `forum_reports`
--

CREATE TABLE `forum_reports` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','reviewed','resolved','dismissed') DEFAULT 'pending',
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `resolved_at` timestamp NULL DEFAULT NULL,
  `resolved_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `forum_reports_detail`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `forum_reports_detail` (
`id` int(11)
,`post_id` int(11)
,`reason` text
,`status` enum('pending','reviewed','resolved','dismissed')
,`admin_notes` text
,`created_at` timestamp
,`resolved_at` timestamp
,`post_title` text
,`post_content` text
,`reporter_name` varchar(100)
,`reporter_email` varchar(100)
,`post_author_name` varchar(100)
,`post_author_email` varchar(100)
,`resolved_by_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `forum_reports_detail`
--
DROP TABLE IF EXISTS `forum_reports_detail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `forum_reports_detail`  AS SELECT `r`.`id` AS `id`, `r`.`post_id` AS `post_id`, `r`.`reason` AS `reason`, `r`.`status` AS `status`, `r`.`admin_notes` AS `admin_notes`, `r`.`created_at` AS `created_at`, `r`.`resolved_at` AS `resolved_at`, `p`.`title` AS `post_title`, `p`.`content` AS `post_content`, `reporter`.`fullname` AS `reporter_name`, `reporter`.`email` AS `reporter_email`, `post_author`.`fullname` AS `post_author_name`, `post_author`.`email` AS `post_author_email`, `resolver`.`fullname` AS `resolved_by_name` FROM ((((`forum_reports` `r` join `forum_posts` `p` on(`r`.`post_id` = `p`.`id`)) join `user_profiles` `reporter` on(`r`.`user_id` = `reporter`.`id`)) join `user_profiles` `post_author` on(`p`.`user_id` = `post_author`.`id`)) left join `user_profiles` `resolver` on(`r`.`resolved_by` = `resolver`.`id`)) ORDER BY `r`.`created_at` DESC ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `forum_categories`
--
ALTER TABLE `forum_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `forum_comments`
--
ALTER TABLE `forum_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeks untuk tabel `forum_reports`
--
ALTER TABLE `forum_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_post_report` (`post_id`,`user_id`),
  ADD KEY `resolved_by` (`resolved_by`),
  ADD KEY `idx_post_id` (`post_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `forum_categories`
--
ALTER TABLE `forum_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `forum_comments`
--
ALTER TABLE `forum_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `forum_posts`
--
ALTER TABLE `forum_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `forum_reports`
--
ALTER TABLE `forum_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `forum_comments`
--
ALTER TABLE `forum_comments`
  ADD CONSTRAINT `forum_comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `forum_posts` (`id`),
  ADD CONSTRAINT `forum_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_profiles` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD CONSTRAINT `forum_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_profiles` (`user_id`),
  ADD CONSTRAINT `forum_posts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `forum_categories` (`id`);

--
-- Ketidakleluasaan untuk tabel `forum_reports`
--
ALTER TABLE `forum_reports`
  ADD CONSTRAINT `forum_reports_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `forum_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forum_reports_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forum_reports_ibfk_3` FOREIGN KEY (`resolved_by`) REFERENCES `user_profiles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
