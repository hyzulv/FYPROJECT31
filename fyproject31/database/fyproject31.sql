-- =============================================
-- Database: fyproject31
-- Restaurant Ordering System - MAT ROCK
-- Import this file in phpMyAdmin
-- All passwords: password123
-- =============================================

CREATE DATABASE IF NOT EXISTS `fyproject31` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `fyproject31`;

-- =============================================
-- Users Table
-- =============================================
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'staff',
  `phone` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Password Reset Tokens
-- =============================================
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Sessions Table
-- =============================================
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Cache Tables
-- =============================================
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Job Tables
-- =============================================
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Menu Items Table
-- =============================================
DROP TABLE IF EXISTS `menu_items`;
CREATE TABLE `menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `category` enum('food','drink') NOT NULL,
  `status` enum('available','unavailable') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Orders Table
-- =============================================
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) NOT NULL,
  `table_number` varchar(255) NOT NULL,
  `items` text NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `order_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_id_unique` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Feedback Table
-- =============================================
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `message` text NOT NULL,
  `feedback_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Migrations Table
-- =============================================
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- SEED DATA - Users (Password: password123)
-- =============================================

INSERT INTO `users` (`name`, `username`, `email`, `password`, `role`, `phone`, `status`, `created_at`, `updated_at`) VALUES
('Admin User', 'admin', 'matrock.admin@gmail.com', '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa', 'admin', '+60 11-123 4567', 'active', NOW(), NOW()),
('Ahmad Faizal', 'ahmad', 'ahmad.faizal@gmail.com', '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa', 'staff', '+60 12-345 6789', 'active', NOW(), NOW()),
('Nurul Aisyah', 'nurul', 'nurul.aisyah@gmail.com', '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa', 'staff', '+60 13-456 7890', 'active', NOW(), NOW()),
('Raj Kumar', 'raj', 'raj.kumar@gmail.com', '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa', 'staff', '+60 14-567 8901', 'active', NOW(), NOW()),
('Lim Wei Jie', 'lim', 'lim.weijie@gmail.com', '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa', 'staff', '+60 16-678 9012', 'active', NOW(), NOW()),
('Sarah Tan', 'sarah', 'sarah.tan@gmail.com', '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa', 'staff', '+60 17-789 0123', 'inactive', NOW(), NOW()),
('Zulkifli Hassan', 'zulkifli', 'zulkifli.h@gmail.com', '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa', 'staff', '+60 18-890 1234', 'active', NOW(), NOW()),
('Farah Diana', 'farah', 'farah.diana@gmail.com', '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa', 'staff', '+60 19-901 2345', 'active', NOW(), NOW());

-- =============================================
-- SEED DATA - Menu Items
-- =============================================

INSERT INTO `menu_items` (`name`, `description`, `price`, `category`, `status`, `created_at`, `updated_at`) VALUES
('Ayam Goreng Kunyit', 'Turmeric fried chicken served with rice and sambal', 12.00, 'food', 'available', NOW(), NOW()),
('Nasi Goreng', 'Fried rice with egg and vegetables', 10.00, 'food', 'available', NOW(), NOW()),
('Mee Goreng', 'Stir-fried noodles with prawns and vegetables', 11.00, 'food', 'available', NOW(), NOW()),
('Roti Canai', 'Crispy flatbread served with dhal curry', 5.00, 'food', 'available', NOW(), NOW()),
('Nasi Lemak', 'Coconut rice with sambal, egg, and anchovies', 9.00, 'food', 'available', NOW(), NOW()),
('Char Kuey Teow', 'Stir-fried rice noodles with dark soy sauce', 10.00, 'food', 'available', NOW(), NOW()),
('Kopi O', 'Black coffee with sugar', 3.50, 'drink', 'available', NOW(), NOW()),
('Teh Tarik', 'Pulled milk tea', 3.50, 'drink', 'available', NOW(), NOW()),
('Teh O', 'Black tea with sugar', 3.00, 'drink', 'available', NOW(), NOW()),
('Milo', 'Malted chocolate drink', 4.00, 'drink', 'available', NOW(), NOW()),
('Air Kosong', 'Plain water', 1.00, 'drink', 'available', NOW(), NOW()),
('Air Kelapa', 'Fresh coconut water', 5.00, 'drink', 'available', NOW(), NOW());

-- =============================================
-- SEED DATA - Orders
-- =============================================

INSERT INTO `orders` (`order_id`, `table_number`, `items`, `total`, `status`, `order_time`, `created_at`, `updated_at`) VALUES
('#ORD-001', 'T05', 'Nasi Goreng, Teh O', 13.00, 'pending', '10:30:00', NOW(), NOW()),
('#ORD-002', 'T03', 'Ayam Goreng Kunyit', 12.00, 'processing', '10:45:00', NOW(), NOW()),
('#ORD-003', 'T01', 'Mee Goreng, Kopi O', 14.50, 'completed', '11:00:00', NOW(), NOW()),
('#ORD-004', 'T08', 'Roti Canai, Teh Tarik', 8.50, 'completed', '11:15:00', NOW(), NOW()),
('#ORD-005', 'T02', 'Nasi Lemak, Milo', 13.00, 'pending', '11:30:00', NOW(), NOW()),
('#ORD-006', 'T06', 'Char Kuey Teow', 10.00, 'processing', '11:45:00', NOW(), NOW()),
('#ORD-007', 'T04', 'Nasi Goreng, Air Kelapa', 15.00, 'completed', '12:00:00', NOW(), NOW()),
('#ORD-008', 'T07', 'Mee Goreng, Teh O', 14.00, 'completed', '12:15:00', NOW(), NOW()),
('#ORD-009', 'T09', 'Ayam Goreng Kunyit, Nasi Lemak', 21.00, 'cancelled', '12:30:00', NOW(), NOW()),
('#ORD-010', 'T10', 'Roti Canai, Kopi O, Milo', 12.50, 'completed', '12:45:00', NOW(), NOW());

-- =============================================
-- SEED DATA - Feedback
-- =============================================

INSERT INTO `feedback` (`customer_name`, `rating`, `message`, `feedback_date`, `created_at`, `updated_at`) VALUES
('Ahmad Razali', 5, 'Ayam goreng kunyit sangat sedap! Sambal yang diberikan juga memang terbaik. Akan datang lagi.', '2026-05-03', NOW(), NOW()),
('Siti Nurhaliza', 4, 'Makanan enak dan harga berpatutan. Cuma servis agak lambat sedikit pada waktu puncak.', '2026-05-02', NOW(), NOW()),
('Lee Wei Ming', 5, 'Nasi lemak dia memang power! Sambal pedas just nice. Portion pun besar. Recommended!', '2026-05-01', NOW(), NOW()),
('Priya Nair', 3, 'Roti canai okay tapi could be better. Teh tarik dia memang kaw. Overall okay lah.', '2026-04-30', NOW(), NOW()),
('Hafiz Ibrahim', 5, 'Tempat makan terbaik di Skudai! Harga murah, makanan sedap, servis bagus. Five stars!', '2026-04-28', NOW(), NOW()),
('Tan Mei Ling', 4, 'Char kuey teow sangat sedap, macam Penang punya! Milo dia pun pekat. Good value for money.', '2026-04-25', NOW(), NOW()),
('Muhammad Irfan', 4, 'Mee goreng dia memang lain dari yang lain. Sedap! Cuma parking agak susah sikit waktu lunch.', '2026-04-22', NOW(), NOW());

-- =============================================
-- Migrations Records
-- =============================================

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2026_05_06_000000_add_role_to_users_table', 1),
('2026_05_06_000001_add_username_to_users_table', 1),
('2026_05_06_000002_create_menu_items_table', 1),
('2026_05_06_000003_create_orders_table', 1),
('2026_05_06_000004_create_feedback_table', 1);
