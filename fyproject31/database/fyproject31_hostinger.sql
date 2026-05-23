-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 23, 2026 at 06:34 AM
-- Server version: 9.7.0
-- PHP Version: 8.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u725120533_fyproject31`
--

USE `u725120533_fyproject31`;

-- Drop old tables if they exist
DROP TABLE IF EXISTS `users`, `password_reset_tokens`, `order_items`, `orders`, `menu_items`, `migrations`, `jobs`, `job_batches`, `feedback`, `failed_jobs`, `cache_locks`, `cache`, `staff`, `admins`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `email`, `password`, `phone`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin', 'fypkumpulan31@gmail.com', '$2y$12$Qc2MOyMARsdtayDz9YhZXOJM62zfI02Gh83KA4IS/AJzfzeDLVso6', '+601151410237', 'active', NULL, '2026-05-15 06:13:49', '2026-05-14 22:45:48');

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
(7, 'Muhammad Irfan', 4, 'Mee goreng dia memang lain dari yang lain. Sedap! Cuma parking agak susah sikit waktu lunch.', '2026-04-22', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(9, 'Danial', 5, 'Terbaik lah nas ayam dia anjay', '2026-05-16', '2026-05-16 01:17:02', '2026-05-16 01:17:12');

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
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `applies_to` json DEFAULT NULL,
  `selection_type` enum('single','multiple') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'multiple',
  `group_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exclude_for` json DEFAULT NULL,
  `status` enum('available','unavailable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `name`, `description`, `price`, `category`, `applies_to`, `selection_type`, `group_name`, `exclude_for`, `status`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Ayam Goreng Kunyit', 'Signature turmeric fried chicken with crispy skin, served with rice and sambal', 10.90, 'ala_carte', NULL, 'multiple', NULL, NULL, 'available', 'ayam-goreng-kunyit.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(2, 'Daging Goreng Kunyit', 'Tender beef stir-fried with turmeric spices, served with rice and sambal', 13.90, 'ala_carte', NULL, 'multiple', NULL, NULL, 'available', 'daging-goreng-kunyit.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(3, 'Sotong Goreng Kunyit', 'Fresh squid cooked in turmeric seasoning, served with rice and sambal', 15.50, 'ala_carte', NULL, 'multiple', NULL, NULL, 'available', 'sotong-goreng-kunyit.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(4, 'Udang Goreng Kunyit', 'Juicy prawns fried with turmeric and spices, served with rice and sambal', 15.50, 'ala_carte', NULL, 'multiple', NULL, NULL, 'available', 'udang-goreng-kunyit.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(5, 'Combo Set Ayam', 'Ayam Goreng Kunyit set with rice, drink and sambal', 15.00, 'combo_set', NULL, 'multiple', NULL, NULL, 'available', 'combo-ayam.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(6, 'Combo Set Daging', 'Daging Goreng Kunyit set with rice, drink and sambal', 17.00, 'combo_set', NULL, 'multiple', NULL, NULL, 'available', 'combo-daging.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(7, 'Combo Set Udang', 'Udang Goreng Kunyit set with rice, drink and sambal', 19.50, 'combo_set', NULL, 'multiple', NULL, NULL, 'available', 'combo-udang.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(8, 'Combo Set Sotong', 'Sotong Goreng Kunyit set with rice, drink and sambal', 19.50, 'combo_set', NULL, 'multiple', NULL, NULL, 'available', 'combo-sotong.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(9, 'Ayam + Daging Mix', 'Mix of Ayam Goreng Kunyit and Daging Goreng Kunyit with rice', 18.90, 'mix', NULL, 'multiple', NULL, NULL, 'available', 'ayam-daging-mix.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(10, 'Sotong + Udang Mix', 'Mix of Sotong Goreng Kunyit and Udang Goreng Kunyit with rice', 18.90, 'mix', NULL, 'multiple', NULL, NULL, 'available', 'sotong-udang-mix.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(11, 'Ayam + Udang Mix', 'Mix of Ayam Goreng Kunyit and Udang Goreng Kunyit with rice', 18.90, 'mix', NULL, 'multiple', NULL, NULL, 'available', 'ayam-udang-mix.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(12, 'Ayam + Sotong Mix', 'Mix of Ayam Goreng Kunyit and Sotong Goreng Kunyit with rice', 18.90, 'mix', NULL, 'multiple', NULL, NULL, 'available', 'ayam-sotong-mix.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(13, 'Daging + Sotong Mix', 'Mix of Daging Goreng Kunyit and Sotong Goreng Kunyit with rice', 18.90, 'mix', NULL, 'multiple', NULL, NULL, 'available', 'daging-sotong-mix.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(14, 'Daging + Udang Mix', 'Mix of Daging Goreng Kunyit and Udang Goreng Kunyit with rice', 18.90, 'mix', NULL, 'multiple', NULL, NULL, 'available', 'daging-udang-mix.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(15, 'Nasi Lemak Biasa', 'Fragrant pandan basmati coconut rice with sambal, peanut, anchovies and cucumber', 5.00, 'nasi_lemak', NULL, 'multiple', NULL, NULL, 'available', 'nasi-lemak-biasa.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(16, 'Nasi Lemak Telur Mata', 'Nasi lemak with a sunny-side-up egg, sambal, peanut and anchovies', 7.00, 'nasi_lemak', NULL, 'multiple', NULL, NULL, 'available', 'nasi-lemak-telur.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(17, 'Nasi Lemak Ayam Berempah', 'Nasi lemak with spiced fried chicken, sambal and sides', 12.00, 'nasi_lemak', NULL, 'multiple', NULL, NULL, 'available', 'nasi-lemak-ayam-berempah.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(18, 'Nasi Lemak Ayam Kunyit', 'Nasi lemak with our signature turmeric fried chicken and sambal', 13.00, 'nasi_lemak', NULL, 'multiple', NULL, NULL, 'available', 'nasi-lemak-ayam-kunyit.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(19, 'Nasi Lemak Daging Kunyit', 'Nasi lemak with turmeric beef, sambal and sides', 15.00, 'nasi_lemak', NULL, 'multiple', NULL, NULL, 'available', 'nasi-lemak-daging-kunyit.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(20, 'Nasi Lemak Sotong Kunyit', 'Nasi lemak with turmeric squid, sambal and sides', 16.00, 'nasi_lemak', NULL, 'multiple', NULL, NULL, 'available', 'nasi-lemak-sotong-kunyit.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(21, 'Nasi Lemak Udang Kunyit', 'Nasi lemak with turmeric prawns, sambal and sides', 16.00, 'nasi_lemak', NULL, 'multiple', NULL, NULL, 'available', 'nasi-lemak-udang-kunyit.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(22, 'Ayam Kicap', 'Chicken cooked in sweet soy sauce with aromatic spices', 12.00, 'kicap', NULL, 'multiple', NULL, NULL, 'available', 'ayam-kicap.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(23, 'Daging Kicap', 'Beef braised in sweet soy sauce with traditional spices', 14.00, 'kicap', NULL, 'multiple', NULL, NULL, 'available', 'daging-kicap.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(24, 'Set Family', 'Family set with Ayam, Daging, Sotong, Udang Goreng Kunyit served with rice and sambal for the whole family', 55.00, 'set_family', NULL, 'multiple', NULL, NULL, 'available', 'set-family.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(25, 'Milo', 'Iced Milo chocolate malt drink', 4.50, 'minuman', NULL, 'multiple', NULL, NULL, 'available', 'milo.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(26, 'Nescafe', 'Iced Nescafe coffee', 4.50, 'minuman', NULL, 'multiple', NULL, NULL, 'available', 'nescafe.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(27, 'Teh', 'Iced Malaysian pulled tea with milk', 4.50, 'minuman', NULL, 'multiple', NULL, NULL, 'available', 'teh.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(28, 'Teh O', 'Iced black tea with sugar', 3.00, 'minuman', NULL, 'multiple', NULL, NULL, 'available', 'teh-o.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(29, 'Ais Kosong', 'Plain water with ice', 1.00, 'minuman', NULL, 'multiple', NULL, NULL, 'available', 'ais-kosong.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(30, 'Telur Mata', 'Sunny-side-up fried egg', 2.00, 'add_on', '[\"ala_carte\", \"combo_set\", \"mix\", \"nasi_lemak\", \"kicap\", \"set_family\"]', 'multiple', NULL, NULL, 'available', 'telur-mata.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(31, 'Nasi Putih', 'Steamed white rice', 3.00, 'add_on', '[\"ala_carte\", \"combo_set\", \"mix\", \"kicap\"]', 'multiple', NULL, NULL, 'available', 'nasi-putih.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(32, 'Sambal Extra', 'Extra serving of our signature sambal', 1.00, 'add_on', '[\"ala_carte\", \"combo_set\", \"mix\", \"nasi_lemak\", \"kicap\", \"set_family\"]', 'multiple', NULL, NULL, 'available', 'sambal.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(33, 'Ice', 'Cold with ice', 0.50, 'add_on', '[\"minuman\"]', 'multiple', NULL, '[\"Ais Kosong\"]', 'available', 'ice.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(34, 'Kurang Manis', 'Less sweet', 0.00, 'add_on', '[\"minuman\"]', 'single', 'Sweetness', '[\"Ais Kosong\"]', 'available', 'kurang-manis.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(35, 'Normal Manis', 'Normal sweetness', 0.00, 'add_on', '[\"minuman\"]', 'single', 'Sweetness', '[\"Ais Kosong\"]', 'available', 'normal-manis.jpg', '2026-05-08 16:06:25', '2026-05-08 16:06:25'),
(36, 'Extra Manis', 'Extra sweet', 0.50, 'add_on', '[\"minuman\"]', 'single', 'Sweetness', '[\"Ais Kosong\"]', 'available', 'extra-manis.jpg', '2026-05-08 16:06:25', '2026-05-14 22:30:32'),
(38, 'nasi ayam berlemak', 'nasi ayam,mmmmm', 8.00, 'kicap', NULL, 'multiple', NULL, NULL, 'available', '1778827040_1200x1200bf-60.jpg', '2026-05-14 22:37:20', '2026-05-14 22:37:20');

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
(8, '2026_05_06_000004_create_feedback_table', 1),
(9, '2026_05_07_000001_add_image_to_menu_items_table', 2),
(10, '2026_05_07_000002_create_order_items_table', 2),
(11, '2026_05_07_000003_change_menu_items_category_to_string', 2),
(12, '2026_05_07_000004_add_addon_fields_to_menu_items_table', 2),
(13, '2026_05_07_000005_add_exclude_for_to_menu_items_table', 2),
(14, '2026_05_13_000000_fix_orders_status_enum', 3),
(15, '2026_05_15_000001_add_payment_fields_to_orders_table', 4),
(16, '2026_05_14_000001_create_admins_table', 4),
(17, '2026_05_14_000002_create_staff_table', 4),
(18, '2026_05_14_000003_migrate_users_to_admins_staff', 4);

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
  `status` enum('pending','preparing','ready') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` enum('unpaid','paid','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `bill_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `order_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `table_number`, `items`, `total`, `status`, `payment_status`, `bill_code`, `transaction_id`, `paid_at`, `order_time`, `created_at`, `updated_at`) VALUES
(1, '#ORD-001', 'T05', 'Nasi Goreng, Teh O', 13.00, 'pending', 'unpaid', NULL, NULL, NULL, '10:30:00', '2026-05-06 03:15:17', '2026-05-18 13:58:50'),
(2, '#ORD-002', 'T03', 'Ayam Goreng Kunyit', 12.00, 'preparing', 'unpaid', NULL, NULL, NULL, '10:45:00', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(3, '#ORD-003', 'T01', 'Mee Goreng, Kopi O', 14.50, 'ready', 'unpaid', NULL, NULL, NULL, '11:00:00', '2026-05-06 03:15:17', '2026-05-18 13:59:00'),
(4, '#ORD-004', 'T08', 'Roti Canai, Teh Tarik', 8.50, 'ready', 'unpaid', NULL, NULL, NULL, '11:15:00', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(5, '#ORD-005', 'T02', 'Nasi Lemak, Milo', 13.00, 'preparing', 'unpaid', NULL, NULL, NULL, '11:30:00', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(6, '#ORD-006', 'T06', 'Char Kuey Teow', 10.00, 'preparing', 'unpaid', NULL, NULL, NULL, '11:45:00', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(7, '#ORD-007', 'T04', 'Nasi Goreng, Air Kelapa', 15.00, 'ready', 'unpaid', NULL, NULL, NULL, '12:00:00', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(8, '#ORD-008', 'T07', 'Mee Goreng, Teh O', 14.00, 'ready', 'unpaid', NULL, NULL, NULL, '12:15:00', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(9, '#ORD-009', 'T09', 'Ayam Goreng Kunyit, Nasi Lemak', 21.00, 'ready', 'unpaid', NULL, NULL, NULL, '12:30:00', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(10, '#ORD-010', 'T10', 'Roti Canai, Kopi O, Milo', 12.50, 'ready', 'unpaid', NULL, NULL, NULL, '12:45:00', '2026-05-06 03:15:17', '2026-05-06 03:15:17'),
(11, '#ORD-YQER0X', 'T10', '[{\"key\":\"1-\",\"id\":1,\"name\":\"Ayam Goreng Kunyit\",\"price\":10.9,\"quantity\":1,\"addons\":[]}]', 11.55, 'ready', 'unpaid', NULL, NULL, NULL, '00:39:23', '2026-05-12 16:39:23', '2026-05-18 13:58:56'),
(12, '#MR-0000', 'T87', '[{\"key\":\"2-\",\"id\":2,\"name\":\"Daging Goreng Kunyit\",\"price\":13.9,\"quantity\":1,\"addons\":[]}]', 14.73, 'pending', 'paid', 'sknjucuo', 'TP2605222922504028', '2026-05-22 01:13:55', '09:13:25', '2026-05-22 01:13:25', '2026-05-22 01:13:55'),
(13, '#MR-0001', 'T23', '[{\"key\":\"29-\",\"id\":29,\"name\":\"Ais Kosong\",\"price\":1,\"quantity\":1,\"addons\":[]}]', 1.06, 'pending', 'failed', '48bo8v8f', NULL, NULL, '15:08:22', '2026-05-22 07:08:22', '2026-05-22 07:09:40'),
(14, '#MR-0002', 'T67', '[{\"key\":\"29-\",\"id\":29,\"name\":\"Ais Kosong\",\"price\":1,\"quantity\":1,\"addons\":[]}]', 1.06, 'pending', 'paid', '96joeejt', 'TP2605224058532836', '2026-05-22 07:10:59', '15:10:11', '2026-05-22 07:10:11', '2026-05-22 07:10:59');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `menu_item_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `subtotal` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `menu_item_id`, `quantity`, `price`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 11, 1, 1, 10.90, 10.90, '2026-05-12 16:39:23', '2026-05-12 16:39:23'),
(2, 12, 2, 1, 13.90, 13.90, '2026-05-22 01:13:25', '2026-05-22 01:13:25'),
(3, 13, 29, 1, 1.00, 1.00, '2026-05-22 07:08:22', '2026-05-22 07:08:22'),
(4, 14, 29, 1, 1.00, 1.00, '2026-05-22 07:10:11', '2026-05-22 07:10:11');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('danialhakim256@gmail.com', '$2y$12$LoN9BkswMg9Vc69YRjbmQuLFnruAWrF1LELnH28G6WJeUCPr9yZYO', '2026-05-13 18:47:18');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `username`, `email`, `password`, `phone`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ahmad Faizal', 'ahmad', 'ahmad.faizal@gmail.com', '$2y$12$z9aI2Dgn8u24XWheQTPWOuR1YFhEC8NhGOqpbKz1GDLSyajxgvMvy', '+60 12-345 6789', 'active', NULL, '2026-05-15 06:13:49', '2026-05-15 06:13:49'),
(2, 'Nurul Aisyah', 'nurul', 'nurul.aisyah@gmail.com', '$2y$12$bhYT9oVz/i3ct7BLb39kKOw8lztkZ84qMbxKHtLixTbN5faapN3Ei', '+60 13-456 7890', 'active', NULL, '2026-05-15 06:13:49', '2026-05-15 06:13:49'),
(3, 'Raj Kumar', 'raj', 'raj.kumar@gmail.com', '$2y$12$SVvczyJk3Ui1YCTh9JqdUuweziq8kQtgvukaJtDxZRKISZY0pb1Pq', '+60 14-567 8901', 'active', NULL, '2026-05-15 06:13:49', '2026-05-15 06:13:49'),
(4, 'Lim Wei Jie', 'lim', 'lim.weijie@gmail.com', '$2y$12$muaS6mYPvt/YBmYApYdlvO1LDz1s6Wh2h1HpZjEEI7m78Asj2PtF.', '+60 16-678 9012', 'active', NULL, '2026-05-15 06:13:49', '2026-05-15 06:13:49'),
(5, 'Sarah Tan', 'sarah', 'sarah.tan@gmail.com', '$2y$12$/2vTh1PfW7FwDRgqSIyxFOkzuIej4vJyTP7pDZfu9fmo8ItaE2qtm', '+60 17-789 0123', 'inactive', NULL, '2026-05-15 06:13:49', '2026-05-15 06:13:49'),
(6, 'Zulkifli Hassan', 'zulkifli', 'zulkifli.h@gmail.com', '$2y$12$IIg.MtvUwHy60YxH2yBIeOhDywnNrgOjw2XXJE6b3oueqwMBzPzT6', '+60 18-890 1234', 'active', NULL, '2026-05-15 06:13:49', '2026-05-15 06:13:49'),
(7, 'Farah Diana', 'farah', 'farah.diana@gmail.com', '$2y$12$ROTf1aAsTyMg41VpD6Gmge/71tKamlDbGI5Kirm/sJTfxKFD4P7vG', '+60 19-901 2345', 'active', NULL, '2026-05-15 06:13:49', '2026-05-15 06:13:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

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
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_menu_item_id_foreign` (`menu_item_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_username_unique` (`username`),
  ADD UNIQUE KEY `staff_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_menu_item_id_foreign` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
