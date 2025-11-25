-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2025 at 06:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blog_id` int(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title_blog` varchar(255) NOT NULL,
  `content_blog` text NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_path` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`blog_id`, `user_id`, `title_blog`, `content_blog`, `date_posted`, `image_path`) VALUES
(1, 3, 'titel2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vel urna quam. Mauris sed lorem eget elit maximus egestas. Phasellus dolor sem, rhoncus ultrices ex ut, gravida maximus mi. Quisque aliquet velit ac urna dapibus, ut accumsan est ullamcorper. Praesent feugiat lacus at velit tempor, eget euismod ex elementum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam eleifend luctus urna ac condimentum. Mauris eu dui ante. Vivamus justo mi, hendrerit sed magna vitae, aliquet vulputate metus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed velit neque, malesuada eget ornare eget, vehicula vel dui.\r\n\r\nClass aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Suspendisse rutrum aliquet orci quis elementum. Nullam sem massa, lacinia ut viverra non, posuere et velit. Nulla quam est, molestie a ipsum quis, malesuada bibendum tortor. Donec ac ultrices nunc. Integer laoreet varius elit, sed porttitor libero efficitur a. Nulla id nisl id massa iaculis feugiat. Nullam efficitur quam felis, ut bibendum elit ultrices ut. Suspendisse potenti. Fusce fringilla sed lectus ut ornare. Proin molestie pulvinar ligula, quis imperdiet orci. Curabitur gravida magna tellus, a cursus quam pretium quis. Quisque in mollis ante, a aliquam felis. In pretium, erat id aliquam convallis, lorem risus porta elit, vitae faucibus ex augue sit amet diam. Maecenas ut risus congue, mollis sem non, tempor elit.\r\n\r\nQuisque vitae nunc sit amet felis pellentesque ultricies. Integer viverra ullamcorper orci. Etiam urna risus, semper ut accumsan accumsan, ornare vel justo. Vivamus eu purus a lorem finibus consequat. Donec sollicitudin ligula in odio pulvinar tempus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi porta ipsum a est ultricies, vel tincidunt nulla lobortis. Praesent vitae tincidunt tellus. Duis ornare condimentum ligula in auctor. Duis facilisis purus et enim feugiat pellentesque.', '2025-11-25 02:16:20', 'uploads/blog_images/blog_69251174bd4a35.54337439.jpeg'),
(5, 3, 'HAP 3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut lobortis, nisl et accumsan porttitor, tellus diam fringilla turpis, vehicula porta purus quam id dui. Maecenas consectetur nisl non diam dapibus consectetur. Integer elit lacus, molestie gravida dui in, pretium dapibus erat. Donec iaculis dictum nunc quis viverra. Curabitur tempus turpis non luctus laoreet. Vivamus vulputate sagittis placerat. Etiam sagittis metus vitae elit ullamcorper, vel posuere dui venenatis. Donec fringilla erat at tristique finibus. Cras a elit eget purus lobortis ultricies vel vel metus. Nam cursus ante elit, vitae dignissim neque sagittis non. Pellentesque neque orci, ullamcorper vel nisi eu, imperdiet pretium sapien. Aenean ac mauris felis. Aliquam vel nisl vitae lorem viverra sollicitudin.\r\n\r\nAliquam lorem dolor, dictum at nunc quis, tempor tincidunt ipsum. In accumsan, neque non consectetur malesuada, lorem nisl facilisis dolor, id dictum elit magna sed justo. Aenean ullamcorper lacus et odio feugiat, eu mollis est gravida. Nam dapibus, turpis eget malesuada pulvinar, magna ante molestie turpis, ac sollicitudin odio lorem nec lacus. Proin rutrum dui eu ante varius, vel lobortis justo elementum. Nunc non odio tristique, aliquam risus vel, pretium nisl. Vestibulum nec commodo lacus. Etiam mattis justo et nisl pharetra, vel accumsan augue interdum. Praesent tempor sem nibh, et semper arcu laoreet ut. Nunc a dui in lorem consectetur mollis. In in molestie diam. Pellentesque risus turpis, feugiat eget tristique vitae, laoreet accumsan odio.\r\n\r\nSuspendisse egestas neque a nulla commodo, at molestie magna fringilla. Mauris tincidunt odio eu leo dignissim, et scelerisque sapien scelerisque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer aliquam dui sed nisl pharetra, id porttitor eros fringilla. Nullam nisi lacus, interdum eget dictum eu, ultricies at dui. Nulla varius mollis congue. Nulla facilisi. Morbi a pulvinar est. Quisque purus eros, sagittis ac rutrum vitae, faucibus eget mi. Aliquam erat volutpat. Vestibulum pretium et est id euismod. Donec sodales varius pulvinar. Nulla ac lacus vehicula, accumsan ante eu, aliquet turpis.', '2025-11-25 11:20:49', 'uploads/blog_images/blog_69259111b85a31.89902704.jpg'),
(6, 3, 'capekbnget', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fermentum gravida sem, non accumsan metus hendrerit eget. Pellentesque vitae cursus magna. Etiam consequat iaculis ante, eu lobortis purus vestibulum sit amet. Curabitur purus ex, fermentum ut rhoncus vitae, pellentesque nec risus. Quisque porttitor venenatis eros condimentum accumsan. Vivamus odio nulla, viverra consectetur dignissim sed, molestie at purus. Pellentesque vel facilisis metus. Nam cursus et ligula vel vulputate. Nam vel ultrices turpis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;\r\n\r\nNunc et nibh vel libero egestas rhoncus at non risus. Nullam scelerisque, erat ac faucibus lacinia, erat sem dictum eros, at eleifend lectus velit vel erat. Etiam sit amet elit at est gravida tempus in eu mi. Sed quis fermentum ligula, eleifend blandit lorem. Donec a varius est. Morbi nec ante nec tortor pulvinar ultrices. Vivamus mollis purus ac commodo rutrum. Pellentesque dignissim auctor sem, consequat vehicula augue sollicitudin sit amet. Cras volutpat tempus eros, in faucibus turpis vehicula a. Nullam ante orci, hendrerit non congue egestas, porta tincidunt odio. Integer rhoncus luctus efficitur. Proin malesuada eros dui. Nunc non eros at augue tempus commodo in et justo. Quisque aliquet sem eu neque tincidunt feugiat.\r\n\r\nDuis porta ex at placerat bibendum. Duis volutpat eros nec tincidunt vestibulum. Morbi rutrum eros quis augue posuere tincidunt. Sed sagittis sit amet arcu eget luctus. Integer sodales fermentum ante a ultricies. Nulla condimentum dignissim urna, in sollicitudin quam porta sed. Cras blandit in lectus sed vestibulum. Morbi ut pretium tortor. Nulla scelerisque lacus nec enim vehicula sodales.', '2025-11-25 15:10:24', 'uploads/blog_images/blog_6925c6e0b1d484.22647132.png');

-- --------------------------------------------------------

--
-- Table structure for table `blog_fav`
--

CREATE TABLE `blog_fav` (
  `fav_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_fav`
--

INSERT INTO `blog_fav` (`fav_id`, `user_id`, `blog_id`, `created_at`) VALUES
(16, 3, 1, '2025-11-25 11:15:07');

-- --------------------------------------------------------

--
-- Table structure for table `blog_report`
--

CREATE TABLE `blog_report` (
  `report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blog_id` int(11) DEFAULT NULL,
  `admin_note` text DEFAULT NULL,
  `report_issue` text NOT NULL,
  `date_reported` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_report`
--

INSERT INTO `blog_report` (`report_id`, `user_id`, `blog_id`, `admin_note`, `report_issue`, `date_reported`) VALUES
(1, 3, 5, NULL, 'ga suka', '2025-11-25 19:48:04'),
(2, 3, 5, NULL, 'ga suka', '2025-11-25 19:54:08');

-- --------------------------------------------------------

--
-- Table structure for table `blog_tag`
--

CREATE TABLE `blog_tag` (
  `blog_id` int(20) NOT NULL,
  `tag_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_tag`
--

INSERT INTO `blog_tag` (`blog_id`, `tag_id`) VALUES
(1, 1),
(5, 14),
(5, 15),
(5, 16),
(6, 18),
(6, 19);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `merch_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `merch_id`, `quantity`, `subtotal`) VALUES
(1, 3, 5, 2, 240000.00),
(2, 3, 1, 1, 120000.00);

-- --------------------------------------------------------

--
-- Table structure for table `merchandise`
--

CREATE TABLE `merchandise` (
  `merch_id` int(11) NOT NULL,
  `merch_name` varchar(100) DEFAULT NULL,
  `merch_pict` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` enum('Tersedia','Habis') DEFAULT 'Tersedia',
  `description` text DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merchandise`
--

INSERT INTO `merchandise` (`merch_id`, `merch_name`, `merch_pict`, `price`, `status`, `description`, `admin_id`) VALUES
(1, 'gelang1', 'merch.png', 120000.00, 'Tersedia', 'lorem gelang ajkdhadhf', 1),
(3, 'gelang3', 'merch2.png', 120000.00, 'Tersedia', 'lorem gelang ajkdhadhf', 1),
(4, 'gelang4', 'merch3.png', 120000.00, 'Tersedia', 'lorem gelang ajkdhadhf', 1),
(5, 'gelang5', 'merch4.png', 120000.00, 'Tersedia', 'lorem gelang ajkdhadhf', 1),
(6, 'gelang6', 'merch5.png', 120000.00, 'Tersedia', 'lorem gelang ajkdhadhf', 1),
(7, 'gelang7', 'merch6.png', 120000.00, 'Tersedia', 'lorem gelang ajkdhadhf', 1),
(8, 'gelang8', 'merch7.png', 120000.00, 'Tersedia', 'lorem gelang ajkdhadhf', 1),
(9, 'gelang9', 'merch8.png', 120000.00, 'Tersedia', 'lorem gelang ajkdhadhf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `program`
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
-- Dumping data for table `program`
--

INSERT INTO `program` (`activity_id`, `program_name`, `description`, `location`, `date`, `time`, `updated_at`, `program_img`) VALUES
(1, 'Beach Cleanup Day', 'Acara bersih-bersih pantai untuk meningkatkan kepedulian lingkungan dan menjaga kebersihan area wisata. Relawan akan bekerja sama mengumpulkan sampah, memilah plastik, dan mengedukasi pengunjung.', 'Pantai Kuta, Bali', '2025-01-15', '08:00:00', '2025-11-14 09:54:44', NULL),
(2, 'Coral Reef Restoration', 'Kegiatan restorasi terumbu karang untuk memulihkan ekosistem bawah laut. Relawan membantu penanaman karang, pembersihan substrat, dan edukasi konservasi.', 'Pulau Menjangan, Bali', '2025-04-12', '08:00:00', '2025-11-14 10:49:52', NULL),
(3, 'Beach Wildlife Rescue', 'Relawan membantu penyelamatan hewan laut seperti penyu dan burung pantai yang terluka akibat sampah. Termasuk pembersihan habitat pesisir.', 'Pangumbahan Turtle Sanctuary, Sukabumi', '2025-06-20', '07:30:00', '2025-11-14 10:49:52', NULL),
(4, 'Coastal Mangrove Restoration', 'Penanaman mangrove untuk mencegah abrasi dan melindungi ekosistem laut. Relawan juga diberikan pelatihan identifikasi jenis mangrove.', 'Mangrove Center, Surabaya', '2025-07-14', '08:30:00', '2025-11-14 10:51:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `tag_id` int(20) NOT NULL,
  `tag_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_name`) VALUES
(1, '12'),
(2, 'ocean'),
(3, 'laut'),
(4, 'ha'),
(5, 'biru'),
(6, 'tua'),
(7, 'gasd'),
(8, 'him'),
(9, 'ey'),
(10, 'uh'),
(11, 'AY'),
(12, 'SAD'),
(13, 'UH'),
(14, 'LIM'),
(15, 'LIME'),
(16, 'R'),
(17, 'wth. demi'),
(18, 'wth'),
(19, 'demi');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `transaction_date` datetime DEFAULT current_timestamp(),
  `total_price` decimal(10,2) DEFAULT NULL,
  `transaction_status` enum('Pending','Paid','Shipped','Completed','Cancelled') DEFAULT 'Pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `shipping_courier` varchar(50) DEFAULT NULL,
  `tracking_number` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `user_id`, `cart_id`, `transaction_date`, `total_price`, `transaction_status`, `payment_method`, `shipping_address`, `shipping_courier`, `tracking_number`) VALUES
(1, 3, NULL, '2025-11-25 23:48:56', 135000.00, 'Pending', 'QRIS', 'haf, ajfdnadnf, jkdnfkjnad, DKI Jakarta, 235345', 'JNE', NULL),
(2, 3, NULL, '2025-11-26 00:25:23', 375000.00, 'Pending', 'QRIS', 'FHGF, MJHJB, NJH, Jawa Barat, HKH', 'JNE', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `volunteer`
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
-- Dumping data for table `volunteer`
--

INSERT INTO `volunteer` (`regis_id`, `user_profile_id`, `activity_id`, `fullname`, `regis_date`, `confir_status`, `email`, `country`, `phone`, `experience`, `reason`, `address`, `motivation`, `file_support`) VALUES
(1, NULL, 3, 'esa', '2025-11-18', 'Pending', 'muh@sc.x', NULL, '7656789090', NULL, NULL, 'kjhgfd', 'kljhgfd', NULL),
(2, NULL, 3, 'esa', '2025-11-18', 'Pending', 'muh@sc.x', NULL, '7656789090', NULL, NULL, 'kjhgfd', 'kljhgfd', NULL),
(3, NULL, 3, 'esa', '2025-11-18', 'Pending', 'muh@sc.x', NULL, '7656789090', NULL, NULL, 'kjhgfd', 'kljhgfd', NULL),
(4, NULL, 2, 'alis', '2025-11-18', 'Pending', 'alis@d.n', NULL, '98765432456', NULL, NULL, 'lkhgfdsg', 'hgfhjkl', NULL),
(5, NULL, 3, 'NNNN', '2025-11-26', 'Pending', 'user@mal.com', NULL, 'BCB', NULL, NULL, 'DFGH', 'HGHG', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `blog_fav`
--
ALTER TABLE `blog_fav`
  ADD PRIMARY KEY (`fav_id`),
  ADD UNIQUE KEY `unique_favorite` (`user_id`,`blog_id`),
  ADD KEY `blog_id` (`blog_id`);

--
-- Indexes for table `blog_report`
--
ALTER TABLE `blog_report`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `blog_report_ibfk_2` (`blog_id`);

--
-- Indexes for table `blog_tag`
--
ALTER TABLE `blog_tag`
  ADD PRIMARY KEY (`blog_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `merch_id` (`merch_id`);

--
-- Indexes for table `merchandise`
--
ALTER TABLE `merchandise`
  ADD PRIMARY KEY (`merch_id`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cart_id` (`cart_id`);

--
-- Indexes for table `volunteer`
--
ALTER TABLE `volunteer`
  ADD PRIMARY KEY (`regis_id`),
  ADD KEY `fk_volunteer_user_profile` (`user_profile_id`),
  ADD KEY `fk_volunteer_program` (`activity_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blog_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blog_fav`
--
ALTER TABLE `blog_fav`
  MODIFY `fav_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `blog_report`
--
ALTER TABLE `blog_report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `merchandise`
--
ALTER TABLE `merchandise`
  MODIFY `merch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `volunteer`
--
ALTER TABLE `volunteer`
  MODIFY `regis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_fav`
--
ALTER TABLE `blog_fav`
  ADD CONSTRAINT `blog_fav_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_fav_ibfk_2` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`blog_id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_report`
--
ALTER TABLE `blog_report`
  ADD CONSTRAINT `blog_report_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `blog_report_ibfk_2` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`blog_id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_tag`
--
ALTER TABLE `blog_tag`
  ADD CONSTRAINT `blog_tag_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`blog_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`tag_id`) ON DELETE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`merch_id`) REFERENCES `merchandise` (`merch_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
