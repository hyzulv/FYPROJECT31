-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 06, 2026 at 03:05 PM
-- Server version: 9.7.0
-- PHP Version: 8.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fyproject31`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `feedback_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `customer_name`, `rating`, `message`, `feedback_date`, `created_at`, `updated_at`) VALUES
(1, 'Ahmad Razali', 5, 'Ayam goreng kunyit sangat sedap! Sambal yang diberikan juga memang terbaik. Akan datang lagi.', '2026-05-03', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(2, 'Siti Nurhaliza', 4, 'Makanan enak dan harga berpatutan. Cuma servis agak lambat sedikit pada waktu puncak.', '2026-05-02', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(3, 'Lee Wei Ming', 5, 'Nasi lemak dia memang power! Sambal pedas just nice. Portion pun besar. Recommended!', '2026-05-01', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(4, 'Priya Nair', 3, 'Roti canai okay tapi could be better. Teh tarik dia memang kaw. Overall okay lah.', '2026-04-30', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(5, 'Hafiz Ibrahim', 5, 'Tempat makan terbaik di Skudai! Harga murah, makanan sedap, servis bagus. Five stars!', '2026-04-28', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(6, 'Tan Mei Ling', 4, 'Char kuey teow sangat sedap, macamPenang punya! Milo dia pun pekat. Good value for money.', '2026-04-25', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(7, 'Muhammad Irfan', 4, 'Mee goreng dia memang lain dari yang lain. Sedap! Cuma parking agak susah sikit waktu lunch.', '2026-04-22', '2026-05-06 03:15:17', '2026-05-06 03:15:17');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(8,2) NOT NULL,
  `category` enum('food','drink') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('available','unavailable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `name`, `description`, `price`, `category`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Ayam Goreng Kunyit', 'Turmeric fried chicken served with rice and sambal', 12.00, 'food', 'available', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(2, 'Nasi Goreng', 'Fried rice with egg and vegetables', 10.00, 'food', 'available', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(3, 'Mee Goreng', 'Stir-fried noodles with prawns and vegetables', 11.00, 'food', 'available', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(4, 'Roti Canai', 'Crispy flatbread served with dhal curry', 5.00, 'food', 'available', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(5, 'Nasi Lemak', 'Coconut rice with sambal, egg, and anchovies', 9.00, 'food', 'available', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(6, 'Char Kuey Teow', 'Stir-fried rice noodles with dark soy sauce', 10.00, 'food', 'available', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(7, 'Kopi O', 'Black coffee with sugar', 3.50, 'drink', 'available', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(8, 'Teh Tarik', 'Pulled milk tea', 3.50, 'drink', 'available', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(9, 'Teh O', 'Black tea with sugar', 3.00, 'drink', 'available', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(10, 'Milo', 'Malted chocolate drink', 4.00, 'drink', 'available', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(11, 'Air Kosong', 'Plain water', 1.00, 'drink', 'available', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(12, 'Air Kelapa', 'Fresh coconut water', 5.00, 'drink', 'available', '2026-05-06 03:15:17', '2026-05-06 03:15:17');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_06_000000_add_role_to_users_table', 1),
(5, '2026_05_06_000001_add_username_to_users_table', 1),
(6, '2026_05_06_000002_create_menu_items_table', 1),
(7, '2026_05_06_000003_create_orders_table', 1),
(8, '2026_05_06_000004_create_feedback_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `order_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `table_number`, `items`, `total`, `status`, `order_time`, `created_at`, `updated_at`) VALUES
(1, '#ORD-001', 'T05', 'Nasi Goreng, Teh O', 13.00, 'pending', '10:30:00', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(2, '#ORD-002', 'T03', 'Ayam Goreng Kunyit', 12.00, 'processing', '10:45:00', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(3, '#ORD-003', 'T01', 'Mee Goreng, Kopi O', 14.50, 'completed', '11:00:00', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(4, '#ORD-004', 'T08', 'Roti Canai, Teh Tarik', 8.50, 'completed', '11:15:00', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(5, '#ORD-005', 'T02', 'Nasi Lemak, Milo', 13.00, 'pending', '11:30:00', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(6, '#ORD-006', 'T06', 'Char Kuey Teow', 10.00, 'processing', '11:45:00', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(7, '#ORD-007', 'T04', 'Nasi Goreng, Air Kelapa', 15.00, 'completed', '12:00:00', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(8, '#ORD-008', 'T07', 'Mee Goreng, Teh O', 14.00, 'completed', '12:15:00', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(9, '#ORD-009', 'T09', 'Ayam Goreng Kunyit, Nasi Lemak', 21.00, 'cancelled', '12:30:00', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(10, '#ORD-010', 'T10', 'Roti Canai, Kopi O, Milo', 12.50, 'completed', '12:45:00', '2026-05-06 03:15:17', '2026-05-06 03:15:17');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'staff',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `role`, `phone`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin', 'matrock.admin@gmail.com', 'admin', '+60 11-123 4567', 'active', NULL, '$2y$12$TOvGyhVckt5vzrWQzyOZW.d0jUjMyWj7Eb6ozBPlYBloOZMk8vCSO', NULL, '2026-05-06 03:15:15', '2026-05-06 06:54:24'),
(2, 'Ahmad Faizal', 'ahmad', 'ahmad.faizal@gmail.com', 'staff', '+60 12-345 6789', 'active', NULL, '$2y$12$z9aI2Dgn8u24XWheQTPWOuR1YFhEC8NhGOqpbKz1GDLSyajxgvMvy', NULL, '2026-05-06 03:15:15', '2026-05-06 06:54:24'),
(3, 'Nurul Aisyah', 'nurul', 'nurul.aisyah@gmail.com', 'staff', '+60 13-456 7890', 'active', NULL, '$2y$12$bhYT9oVz/i3ct7BLb39kKOw8lztkZ84qMbxKHtLixTbN5faapN3Ei', NULL, '2026-05-06 03:15:16', '2026-05-06 06:54:24'),
(4, 'Raj Kumar', 'raj', 'raj.kumar@gmail.com', 'staff', '+60 14-567 8901', 'active', NULL, '$2y$12$SVvczyJk3Ui1YCTh9JqdUuweziq8kQtgvukaJtDxZRKISZY0pb1Pq', NULL, '2026-05-06 03:15:16', '2026-05-06 06:54:24'),
(5, 'Lim Wei Jie', 'lim', 'lim.weijie@gmail.com', 'staff', '+60 16-678 9012', 'active', NULL, '$2y$12$muaS6mYPvt/YBmYApYdlvO1LDz1s6Wh2h1HpZjEEI7m78Asj2PtF.', NULL, '2026-05-06 03:15:16', '2026-05-06 06:54:24'),
(6, 'Sarah Tan', 'sarah', 'sarah.tan@gmail.com', 'staff', '+60 17-789 0123', 'inactive', NULL, '$2y$12$/2vTh1PfW7FwDRgqSIyxFOkzuIej4vJyTP7pDZfu9fmo8ItaE2qtm', NULL, '2026-05-06 03:15:16', '2026-05-06 06:54:25'),
(7, 'Zulkifli Hassan', 'zulkifli', 'zulkifli.h@gmail.com', 'staff', '+60 18-890 1234', 'active', NULL, '$2y$12$IIg.MtvUwHy60YxH2yBIeOhDywnNrgOjw2XXJE6b3oueqwMBzPzT6', NULL, '2026-05-06 03:15:16', '2026-05-06 06:54:25'),
(8, 'Farah Diana', 'farah', 'farah.diana@gmail.com', 'staff', '+60 19-901 2345', 'active', NULL, '$2y$12$ROTf1aAsTyMg41VpD6Gmge/71tKamlDbGI5Kirm/sJTfxKFD4P7vG', NULL, '2026-05-06 03:15:17', '2026-05-06 06:54:25'),
(9, 'Ali alala', 'Ali', 'fypkumpulan31@gmail.com', 'staff', '+60 19-901 2342', 'active', NULL, '$2y$12$ZcQ/HDGnp6kpmpGO328UBu3Surrpj/WYtHkuTt6nIAku2Bj3VWgaG', 'B33PXYT8DO03VQ0dfqNFBNA4HaRIdORT3sQ4EpzLtNJS6ALIUcUkuKCNJnS2', '2026-05-06 03:15:17', '2026-05-06 06:49:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_id_unique` (`order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
