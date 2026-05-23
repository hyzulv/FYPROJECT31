-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: fyproject31
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_username_unique` (`username`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'Admin User','admin','fypkumpulan31@gmail.com','$2y$12$Qc2MOyMARsdtayDz9YhZXOJM62zfI02Gh83KA4IS/AJzfzeDLVso6','+60 11-123 4567','active',NULL,'2026-05-14 07:36:51','2026-05-14 07:36:51');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `feedback` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `feedback_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback`
--

LOCK TABLES `feedback` WRITE;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
INSERT INTO `feedback` VALUES (1,'Ahmad Razali',5,'Ayam goreng kunyit sangat sedap! Sambal yang diberikan juga memang terbaik. Akan datang lagi.','2026-05-03','2026-05-07 03:57:10','2026-05-07 03:57:10'),(2,'Siti Nurhaliza',4,'Makanan enak dan harga berpatutan. Cuma servis agak lambat sedikit pada waktu puncak.','2026-05-02','2026-05-07 03:57:10','2026-05-07 03:57:10'),(3,'Lee Wei Ming',5,'Nasi lemak dia memang power! Sambal pedas just nice. Portion pun besar. Recommended!','2026-05-01','2026-05-07 03:57:10','2026-05-07 03:57:10'),(4,'Priya Nair',3,'Roti canai okay tapi could be better. Teh tarik dia memang kaw. Overall okay lah.','2026-04-30','2026-05-07 03:57:10','2026-05-07 03:57:10'),(5,'Hafiz Ibrahim',5,'Tempat makan terbaik di Skudai! Harga murah, makanan sedap, servis bagus. Five stars!','2026-04-28','2026-05-07 03:57:10','2026-05-07 03:57:10'),(6,'Tan Mei Ling',4,'Char kuey teow sangat sedap, macam Penang punya! Milo dia pun pekat. Good value for money.','2026-04-25','2026-05-07 03:57:10','2026-05-07 03:57:10'),(7,'Muhammad Irfan',4,'Mee goreng dia memang lain dari yang lain. Sedap! Cuma parking agak susah sikit waktu lunch.','2026-04-22','2026-05-07 03:57:10','2026-05-07 03:57:10');
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(8,2) NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('available','unavailable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES (1,'Ayam Goreng Kunyit','Signature turmeric fried chicken with crispy skin, served with rice and sambal',10.90,'ala_carte','available','ayam-goreng-kunyit.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(2,'Daging Goreng Kunyit','Tender beef stir-fried with turmeric spices, served with rice and sambal',13.90,'ala_carte','available','daging-goreng-kunyit.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(3,'Sotong Goreng Kunyit','Fresh squid cooked in turmeric seasoning, served with rice and sambal',15.50,'ala_carte','available','sotong-goreng-kunyit.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(4,'Udang Goreng Kunyit','Juicy prawns fried with turmeric and spices, served with rice and sambal',15.50,'ala_carte','available','udang-goreng-kunyit.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(5,'Combo Set Ayam','Ayam Goreng Kunyit set with rice, drink and sambal',15.00,'combo_set','available','combo-ayam.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(6,'Combo Set Daging','Daging Goreng Kunyit set with rice, drink and sambal',17.00,'combo_set','available','combo-daging.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(7,'Combo Set Udang','Udang Goreng Kunyit set with rice, drink and sambal',19.50,'combo_set','available','combo-udang.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(8,'Combo Set Sotong','Sotong Goreng Kunyit set with rice, drink and sambal',19.50,'combo_set','available','combo-sotong.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(9,'Ayam + Daging Mix','Mix of Ayam Goreng Kunyit and Daging Goreng Kunyit with rice',18.90,'mix','available','ayam-daging-mix.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(10,'Sotong + Udang Mix','Mix of Sotong Goreng Kunyit and Udang Goreng Kunyit with rice',18.90,'mix','available','sotong-udang-mix.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(11,'Ayam + Udang Mix','Mix of Ayam Goreng Kunyit and Udang Goreng Kunyit with rice',18.90,'mix','available','ayam-udang-mix.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(12,'Ayam + Sotong Mix','Mix of Ayam Goreng Kunyit and Sotong Goreng Kunyit with rice',18.90,'mix','available','ayam-sotong-mix.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(13,'Daging + Sotong Mix','Mix of Daging Goreng Kunyit and Sotong Goreng Kunyit with rice',18.90,'mix','available','daging-sotong-mix.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(14,'Daging + Udang Mix','Mix of Daging Goreng Kunyit and Udang Goreng Kunyit with rice',18.90,'mix','available','daging-udang-mix.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(15,'Nasi Lemak Biasa','Fragrant pandan basmati coconut rice with sambal, peanut, anchovies and cucumber',5.00,'nasi_lemak','available','nasi-lemak-biasa.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(16,'Nasi Lemak Telur Mata','Nasi lemak with a sunny-side-up egg, sambal, peanut and anchovies',7.00,'nasi_lemak','available','nasi-lemak-telur.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(17,'Nasi Lemak Ayam Berempah','Nasi lemak with spiced fried chicken, sambal and sides',12.00,'nasi_lemak','available','nasi-lemak-ayam-berempah.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(18,'Nasi Lemak Ayam Kunyit','Nasi lemak with our signature turmeric fried chicken and sambal',13.00,'nasi_lemak','available','nasi-lemak-ayam-kunyit.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(19,'Nasi Lemak Daging Kunyit','Nasi lemak with turmeric beef, sambal and sides',15.00,'nasi_lemak','available','nasi-lemak-daging-kunyit.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(20,'Nasi Lemak Sotong Kunyit','Nasi lemak with turmeric squid, sambal and sides',16.00,'nasi_lemak','available','nasi-lemak-sotong-kunyit.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(21,'Nasi Lemak Udang Kunyit','Nasi lemak with turmeric prawns, sambal and sides',16.00,'nasi_lemak','available','nasi-lemak-udang-kunyit.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(22,'Ayam Kicap','Chicken cooked in sweet soy sauce with aromatic spices',12.00,'kicap','available','ayam-kicap.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(23,'Daging Kicap','Beef braised in sweet soy sauce with traditional spices',14.00,'kicap','available','daging-kicap.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(24,'Set Family','Family set with Ayam, Daging, Sotong, Udang Goreng Kunyit served with rice and sambal for the whole family',55.00,'set_family','available','set-family.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(25,'Milo','Iced Milo chocolate malt drink',4.50,'minuman','available','milo.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(26,'Nescafe','Iced Nescafe coffee',4.50,'minuman','available','nescafe.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(27,'Teh','Iced Malaysian pulled tea with milk',4.50,'minuman','available','teh.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(28,'Teh O','Iced black tea with sugar',3.00,'minuman','available','teh-o.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(29,'Air Kosong','Plain water',1.00,'minuman','available','air-kosong.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(30,'Telur Mata','Sunny-side-up fried egg',2.00,'add_on','available','telur-mata.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(31,'Nasi Putih','Steamed white rice',3.00,'add_on','available','nasi-putih.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(32,'Nasi Tambah','Extra serving of rice',1.00,'add_on','available','nasi-tambah.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26'),(33,'Sambal Extra','Extra serving of our signature sambal',1.00,'add_on','available','sambal.jpg','2026-05-06 19:43:26','2026-05-06 19:43:26');
/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_05_06_000000_add_role_to_users_table',1),(5,'2026_05_06_000001_add_username_to_users_table',1),(6,'2026_05_06_000002_create_menu_items_table',1),(7,'2026_05_06_000003_create_orders_table',1),(8,'2026_05_06_000004_create_feedback_table',1),(9,'2026_05_07_000001_add_image_to_menu_items_table',1),(10,'2026_05_07_000002_create_order_items_table',1),(11,'2026_05_07_000003_change_menu_items_category_to_string',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `menu_item_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `subtotal` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_menu_item_id_foreign` (`menu_item_id`),
  CONSTRAINT `order_items_menu_item_id_foreign` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,11,3,1,15.50,15.50,'2026-05-08 02:05:32','2026-05-08 02:05:32');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `status` enum('preparing','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'preparing',
  `order_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_id_unique` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (2,'#ORD-002','T03','Ayam Goreng Kunyit',12.00,'preparing','10:45:00','2026-05-07 03:57:10','2026-05-08 03:02:08'),(3,'#ORD-003','T01','Mee Goreng, Kopi O',14.50,'completed','11:00:00','2026-05-07 03:57:10','2026-05-07 03:57:10'),(4,'#ORD-004','T08','Roti Canai, Teh Tarik',8.50,'completed','11:15:00','2026-05-07 03:57:10','2026-05-07 03:57:10'),(5,'#ORD-005','T02','Nasi Lemak, Milo',13.00,'preparing','11:30:00','2026-05-07 03:57:10','2026-05-07 03:57:10'),(6,'#ORD-006','T06','Char Kuey Teow',10.00,'preparing','11:45:00','2026-05-07 03:57:10','2026-05-07 03:57:10'),(7,'#ORD-007','T04','Nasi Goreng, Air Kelapa',15.00,'completed','12:00:00','2026-05-07 03:57:10','2026-05-07 03:57:10'),(8,'#ORD-008','T07','Mee Goreng, Teh O',14.00,'completed','12:15:00','2026-05-07 03:57:10','2026-05-07 03:57:10'),(10,'#ORD-010','T10','Roti Canai, Kopi O, Milo',12.50,'completed','12:45:00','2026-05-07 03:57:10','2026-05-07 03:57:10'),(11,'#ORD-SNDO0Y','T10','[{\"key\":\"3-\",\"id\":3,\"name\":\"Sotong Goreng Kunyit\",\"price\":15.5,\"quantity\":1,\"addons\":[]}]',16.43,'preparing','10:05:32','2026-05-08 02:05:32','2026-05-08 03:10:03');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staff` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `staff_username_unique` (`username`),
  UNIQUE KEY `staff_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES (1,'Ahmad Faizal','ahmad','ahmad.faizal@gmail.com','$2y$12$z9aI2Dgn8u24XWheQTPWOuR1YFhEC8NhGOqpbKz1GDLSyajxgvMvy','+60 12-345 6789','active',NULL,'2026-05-14 07:36:51','2026-05-14 07:36:51'),(2,'Nurul Aisyah','nurul','nurul.aisyah@gmail.com','$2y$12$bhYT9oVz/i3ct7BLb39kKOw8lztkZ84qMbxKHtLixTbN5faapN3Ei','+60 13-456 7890','active',NULL,'2026-05-14 07:36:51','2026-05-14 07:36:51'),(4,'Lim Wei Jie','lim','lim.weijie@gmail.com','$2y$12$muaS6mYPvt/YBmYApYdlvO1LDz1s6Wh2h1HpZjEEI7m78Asj2PtF.','+60 16-678 9012','active',NULL,'2026-05-14 07:36:51','2026-05-14 07:36:51'),(5,'Sarah Tan','sarah','sarah.tan@gmail.com','$2y$12$/2vTh1PfW7FwDRgqSIyxFOkzuIej4vJyTP7pDZfu9fmo8ItaE2qtm','+60 17-789 0123','inactive',NULL,'2026-05-14 07:36:51','2026-05-14 07:36:51'),(6,'Zulkifli Hassan','zulkifli','zulkifli.h@gmail.com','$2y$12$IIg.MtvUwHy60YxH2yBIeOhDywnNrgOjw2XXJE6b3oueqwMBzPzT6','+60 18-890 1234','active',NULL,'2026-05-14 07:36:51','2026-05-14 07:36:51'),(7,'Farah Diana','farah','farah.diana@gmail.com','$2y$12$ROTf1aAsTyMg41VpD6Gmge/71tKamlDbGI5Kirm/sJTfxKFD4P7vG','+60 19-901 2345','active',NULL,'2026-05-14 07:36:51','2026-05-14 07:36:51');
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-23 11:59:52
