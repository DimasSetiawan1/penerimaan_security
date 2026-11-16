-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: localhost    Database: penerimaan_security
-- ------------------------------------------------------
-- Server version	8.0.46-0ubuntu0.22.04.5

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calculation_results`
--

DROP TABLE IF EXISTS `calculation_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calculation_results` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `candidate_id` bigint unsigned NOT NULL,
  `smart_score` double NOT NULL DEFAULT '0',
  `swot_score` double NOT NULL DEFAULT '0',
  `final_score` double NOT NULL DEFAULT '0',
  `rank` int NOT NULL DEFAULT '0',
  `recommendation_status` enum('Diterima','Pertimbangan','Ditolak') NOT NULL DEFAULT 'Pertimbangan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `calculation_results_candidate_id_foreign` (`candidate_id`),
  CONSTRAINT `calculation_results_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calculation_results`
--

LOCK TABLES `calculation_results` WRITE;
/*!40000 ALTER TABLE `calculation_results` DISABLE KEYS */;
INSERT INTO `calculation_results` VALUES (1,1,0.9375,0.867,0.9164,1,'Diterima','2026-07-24 14:12:33','2026-08-02 08:55:55'),(2,2,0.8125,0.733,0.7887,2,'Diterima','2026-07-24 14:12:33','2026-08-02 08:55:55'),(3,3,0.625,0.633,0.6274,4,'Pertimbangan','2026-07-24 14:12:33','2026-08-19 09:15:30'),(4,4,0.5,0.5,0.5,5,'Ditolak','2026-07-24 14:12:33','2026-08-19 09:15:30'),(5,5,0.1875,0.267,0.2114,8,'Ditolak','2026-07-24 14:12:33','2026-08-19 11:05:03'),(6,6,0.375,0.367,0.3726,6,'Ditolak','2026-08-02 08:57:59','2026-08-19 09:15:30'),(7,7,0.75,0.7,0.735,3,'Pertimbangan','2026-08-19 09:15:30','2026-08-19 09:15:30'),(8,8,0.2625,0.233,0.2537,7,'Ditolak','2026-08-19 11:05:03','2026-08-19 11:05:03');
/*!40000 ALTER TABLE `calculation_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `candidate_scores`
--

DROP TABLE IF EXISTS `candidate_scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `candidate_scores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `candidate_id` bigint unsigned NOT NULL,
  `criteria_id` bigint unsigned NOT NULL,
  `score_val` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `candidate_scores_candidate_id_foreign` (`candidate_id`),
  KEY `candidate_scores_criteria_id_foreign` (`criteria_id`),
  CONSTRAINT `candidate_scores_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE,
  CONSTRAINT `candidate_scores_criteria_id_foreign` FOREIGN KEY (`criteria_id`) REFERENCES `criterias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `candidate_scores`
--

LOCK TABLES `candidate_scores` WRITE;
/*!40000 ALTER TABLE `candidate_scores` DISABLE KEYS */;
INSERT INTO `candidate_scores` VALUES (1,1,1,5,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(2,1,2,5,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(3,1,3,4,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(4,1,4,5,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(5,2,1,4,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(6,2,2,4,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(7,2,3,5,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(8,2,4,4,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(9,3,1,4,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(10,3,2,3,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(11,3,3,3,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(12,3,4,4,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(13,4,1,3,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(14,4,2,4,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(15,4,3,2,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(16,4,4,3,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(17,5,1,2,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(18,5,2,2,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(19,5,3,1,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(20,5,4,2,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(21,6,1,2,'2026-08-02 08:57:58','2026-08-02 08:57:58'),(22,6,2,4,'2026-08-02 08:57:58','2026-08-02 08:57:58'),(23,6,3,2,'2026-08-02 08:57:58','2026-08-02 08:57:58'),(24,6,4,2,'2026-08-02 08:57:58','2026-08-02 08:57:58'),(25,7,1,4,'2026-08-19 09:15:30','2026-08-19 09:15:30'),(26,7,2,4,'2026-08-19 09:15:30','2026-08-19 09:15:30'),(27,7,3,4,'2026-08-19 09:15:30','2026-08-19 09:15:30'),(28,7,4,4,'2026-08-19 09:15:30','2026-08-19 09:15:30'),(29,8,1,2,'2026-08-19 11:05:02','2026-08-19 11:05:02'),(30,8,2,4,'2026-08-19 11:05:02','2026-08-19 11:05:02'),(31,8,3,1,'2026-08-19 11:05:02','2026-08-19 11:05:02'),(32,8,4,1,'2026-08-19 11:05:02','2026-08-19 11:05:02');
/*!40000 ALTER TABLE `candidate_scores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `candidates`
--

DROP TABLE IF EXISTS `candidates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `candidates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `gender` enum('L','P') NOT NULL DEFAULT 'L',
  `phone` varchar(255) DEFAULT NULL,
  `address` text,
  `status` enum('Draft','Evaluated') NOT NULL DEFAULT 'Draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `candidates_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `candidates`
--

LOCK TABLES `candidates` WRITE;
/*!40000 ALTER TABLE `candidates` DISABLE KEYS */;
INSERT INTO `candidates` VALUES (1,'K01','3275011204950001','Ahmad Rifai','L','081234567891','Jl. Ahmad Yani No. 12, Bekasi Selatan','Evaluated','2026-07-24 14:12:33','2026-09-19 13:46:19'),(2,'K02','3275012508960002','Budi Santoso','L','081234567892','Jl. Hasibuan No. 45, Bekasi Timur','Evaluated','2026-07-24 14:12:33','2026-09-19 13:46:19'),(3,'K03','3275011902940003','Candra Wijaya','L','081234567893','Jl. Cut Mutia No. 88, Rawalumbu, Bekasi','Evaluated','2026-07-24 14:12:33','2026-09-19 13:46:19'),(4,'K04','3275010811970004','Dedi Kurniawan','L','081234567894','Jl. Joyo Martono No. 10, Tambun, Bekasi','Evaluated','2026-07-24 14:12:33','2026-09-19 13:46:19'),(5,'K05','3275011406980005','Eko Prasetyo','L','081234567895','Jl. Sultan Agung No. 5, Medansatria, Bekasi','Evaluated','2026-07-24 14:12:33','2026-09-19 13:46:19'),(6,'K06','3201010000000002','Agus','L','081234567890','Bekasi','Evaluated','2026-08-02 08:57:58','2026-09-19 13:46:19'),(7,'K07','1234567891234567','wahyu sutisna','L','0895123456789','bekasi timur','Evaluated','2026-08-19 09:15:30','2026-09-19 13:46:19'),(8,'K08','1234567891234567','suryono','L','089512345678','Bekasi timur','Evaluated','2026-08-19 11:05:02','2026-09-19 13:46:19');
/*!40000 ALTER TABLE `candidates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `criterias`
--

DROP TABLE IF EXISTS `criterias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `criterias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('benefit','cost') NOT NULL DEFAULT 'benefit',
  `weight` double NOT NULL,
  `min_val` double NOT NULL DEFAULT '1',
  `max_val` double NOT NULL DEFAULT '5',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `criterias_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `criterias`
--

LOCK TABLES `criterias` WRITE;
/*!40000 ALTER TABLE `criterias` DISABLE KEYS */;
INSERT INTO `criterias` VALUES (1,'C1','Integritas (Catatan Kriminal)','benefit',30,1,5,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(2,'C2','Kesehatan Fisik','benefit',25,1,5,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(3,'C3','Pengalaman Kerja','benefit',25,1,5,'2026-07-24 14:12:33','2026-07-24 14:12:33'),(4,'C4','Kesiapan Shift','benefit',20,1,5,'2026-07-24 14:12:33','2026-07-24 14:12:33');
/*!40000 ALTER TABLE `criterias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_07_23_000001_create_spk_tables',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('2EYEarzTUhkULGMkABQyW6fYVKVuWXsd5vJWD0JE',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.107 Safari/537.36 (compatible; +https://developers.cloudflare.com/security-center/)','YToyOntzOjY6Il90b2tlbiI7czo0MDoiYTJ6UVNaczlPQ24xcXJZcUVxVFRjNDlYOXRaUkFBckRSTEIyNzJ1ZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1791525341),('3y4pbDfRWiC3RG09Bm7mcOa4WkcYzYJhX8OBpASQ',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.107 Safari/537.36 (compatible; +https://developers.cloudflare.com/security-center/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWHBRd2NpcXVKWm1uN3Y0SjdxU2ZYMFVVQWMwbWNyRkN1NWM2dHRaQSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MjoiaHR0cHM6Ly9wZW5lcmltYWFuLXNlY3VyaXR5LmRpbXNrdXkud2ViLmlkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1791525337),('d4adKpWxumzIsz7uIq1oi1wG5VFfgNe5iqLp4XZV',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.107 Safari/537.36 (compatible; +https://developers.cloudflare.com/security-center/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQzJncXhRWFRwZ2p0V05lRUppYUExT2NxbmlBdmRQTXdnU3hjdkp0bSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MjoiaHR0cHM6Ly9wZW5lcmltYWFuLXNlY3VyaXR5LmRpbXNrdXkud2ViLmlkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1791525337),('Nirs7InJYpgcVwsCCfVTODcqCw8FQbCOvpbdSMlL',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.107 Safari/537.36 (compatible; +https://developers.cloudflare.com/security-center/)','YToyOntzOjY6Il90b2tlbiI7czo0MDoiUTdjQkZ6OTdCbWdoZVF4VE5DRk5zcVNndk5acVRqbmNLamZmSXVZWSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1792130547),('QAon6LDmeJI6KAzsbIFzY06FYtzlKWRHusMcxRYa',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.107 Safari/537.36 (compatible; +https://developers.cloudflare.com/security-center/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiOWRxRUtCUEQwamcybWR0cGREQmo3YjhYQzM1aG51dmdGRjVTT1ZTOCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MjoiaHR0cHM6Ly9wZW5lcmltYWFuLXNlY3VyaXR5LmRpbXNrdXkud2ViLmlkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1792130545),('VOwgmN4i5y0ZnuTjhDk4jlrnhxYr2wHPbKhtcHCS',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.107 Safari/537.36 (compatible; +https://developers.cloudflare.com/security-center/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiY3FzdnJTOUxoSDlDQ3JSRzRaQTBJYmhLa01IZnlqSkp1RUw1a0RCSiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MjoiaHR0cHM6Ly9wZW5lcmltYWFuLXNlY3VyaXR5LmRpbXNrdXkud2ViLmlkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1792130545);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_criterias`
--

DROP TABLE IF EXISTS `sub_criterias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_criterias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `criteria_id` bigint unsigned NOT NULL,
  `value` int NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sub_criterias_criteria_id_foreign` (`criteria_id`),
  CONSTRAINT `sub_criterias_criteria_id_foreign` FOREIGN KEY (`criteria_id`) REFERENCES `criterias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_criterias`
--

LOCK TABLES `sub_criterias` WRITE;
/*!40000 ALTER TABLE `sub_criterias` DISABLE KEYS */;
INSERT INTO `sub_criterias` VALUES (1,1,1,'Pernah terlibat kasus kriminal berat','2026-07-24 14:12:33','2026-07-24 14:12:33'),(2,1,2,'Pernah terlibat kasus ringan / pelanggaran','2026-07-24 14:12:33','2026-07-24 14:12:33'),(3,1,3,'Tidak ada catatan, belum ada SKCK','2026-07-24 14:12:33','2026-07-24 14:12:33'),(4,1,4,'Memiliki SKCK bersih','2026-07-24 14:12:33','2026-07-24 14:12:33'),(5,1,5,'SKCK bersih + referensi karakter dari institusi','2026-07-24 14:12:33','2026-07-24 14:12:33'),(6,2,1,'Ada penyakit berat / tidak layak tugas lapangan','2026-07-24 14:12:33','2026-07-24 14:12:33'),(7,2,2,'Kondisi kurang prima, ada keterbatasan fisik','2026-07-24 14:12:33','2026-07-24 14:12:33'),(8,2,3,'Sehat, belum ada hasil medical check-up','2026-07-24 14:12:33','2026-07-24 14:12:33'),(9,2,4,'Sehat berdasarkan medical check-up','2026-07-24 14:12:33','2026-07-24 14:12:33'),(10,2,5,'Sehat prima + lulus tes fisik (lari, push-up, dll)','2026-07-24 14:12:33','2026-07-24 14:12:33'),(11,3,1,'Tidak ada pengalaman sama sekali','2026-07-24 14:12:33','2026-07-24 14:12:33'),(12,3,2,'< 1 tahun pengalaman security','2026-07-24 14:12:33','2026-07-24 14:12:33'),(13,3,3,'1–2 tahun pengalaman security','2026-07-24 14:12:33','2026-07-24 14:12:33'),(14,3,4,'3–5 tahun pengalaman security','2026-07-24 14:12:33','2026-07-24 14:12:33'),(15,3,5,'> 5 tahun atau pernah di lingkungan perkantoran/mal','2026-07-24 14:12:33','2026-07-24 14:12:33'),(16,4,1,'Hanya bisa shift tertentu, tidak fleksibel','2026-07-24 14:12:33','2026-07-24 14:12:33'),(17,4,2,'Bisa 2 shift, ada kendala transportasi','2026-07-24 14:12:33','2026-07-24 14:12:33'),(18,4,3,'Bisa semua shift tapi belum terbukti','2026-07-24 14:12:33','2026-07-24 14:12:33'),(19,4,4,'Bisa semua shift, domisili dekat lokasi','2026-07-24 14:12:33','2026-07-24 14:12:33'),(20,4,5,'Siap semua shift + pengalaman shift malam sebelumnya','2026-07-24 14:12:33','2026-07-24 14:12:33');
/*!40000 ALTER TABLE `sub_criterias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `swot_evaluations`
--

DROP TABLE IF EXISTS `swot_evaluations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `swot_evaluations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `candidate_id` bigint unsigned NOT NULL,
  `strengths_score` double NOT NULL DEFAULT '3',
  `weaknesses_score` double NOT NULL DEFAULT '2',
  `opportunities_score` double NOT NULL DEFAULT '4',
  `threats_score` double NOT NULL DEFAULT '2',
  `ifas_score` double NOT NULL DEFAULT '0',
  `efas_score` double NOT NULL DEFAULT '0',
  `quadrant` enum('SO','ST','WO','WT') NOT NULL DEFAULT 'SO',
  `strategy_recommendation` varchar(255) DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `swot_evaluations_candidate_id_foreign` (`candidate_id`),
  CONSTRAINT `swot_evaluations_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `swot_evaluations`
--

LOCK TABLES `swot_evaluations` WRITE;
/*!40000 ALTER TABLE `swot_evaluations` DISABLE KEYS */;
INSERT INTO `swot_evaluations` VALUES (1,1,4.67,1.33,5,1,3.34,4,'SO','Kualifikasi Sangat Layak: Memiliki integritas tinggi, fisik prima, serta tingkat fleksibilitas operasional yang sangat baik.',NULL,'2026-07-24 14:12:33','2026-08-02 08:55:55'),(2,2,4.33,1.67,4,2,2.66,2,'SO','Kualifikasi Sangat Layak: Memiliki integritas tinggi, fisik prima, serta tingkat fleksibilitas operasional yang sangat baik.',NULL,'2026-07-24 14:12:33','2026-08-02 08:55:55'),(3,3,3.33,2.67,4,2,0.66,2,'SO','Kualifikasi Sangat Layak: Memiliki integritas tinggi, fisik prima, serta tingkat fleksibilitas operasional yang sangat baik.',NULL,'2026-07-24 14:12:33','2026-08-02 08:55:55'),(4,4,3,3,3,3,0,0,'SO','Kualifikasi Sangat Layak: Memiliki integritas tinggi, fisik prima, serta tingkat fleksibilitas operasional yang sangat baik.',NULL,'2026-07-24 14:12:33','2026-08-02 08:55:55'),(5,5,1.67,4.33,2,4,-2.66,-2,'WT','Kualifikasi Tidak Layak: Profil kandidat belum memenuhi standar kualifikasi & fleksibilitas kerja minimal.',NULL,'2026-07-24 14:12:33','2026-08-02 08:55:55'),(6,6,2.67,3.33,2,4,-0.66,-2,'WT','Kualifikasi Tidak Layak: Profil kandidat belum memenuhi standar kualifikasi & fleksibilitas kerja minimal.',NULL,'2026-08-02 08:57:58','2026-08-02 08:57:58'),(7,7,4,2,4,2,2,2,'SO','Kualifikasi Sangat Layak: Memiliki integritas tinggi, fisik prima, serta tingkat fleksibilitas operasional yang sangat baik.',NULL,'2026-08-19 09:15:30','2026-08-19 09:15:30'),(8,8,2.33,3.67,1,5,-1.34,-4,'WT','Kualifikasi Tidak Layak: Profil kandidat belum memenuhi standar kualifikasi & fleksibilitas kerja minimal.',NULL,'2026-08-19 11:05:02','2026-08-19 11:05:02');
/*!40000 ALTER TABLE `swot_evaluations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator SPK','admin@sentraniaga.com',NULL,'$2y$12$v4WiAkTGBiRd3ZoyeDEQp.QfeC29ksKBpRbTBi37m/uxXpm1ck0SS','admin','A5geYrKjlVnx1o2EUIOi7EMjOD3Wt4OtJEhBWM4X4owWVUstUx6SIBZZVUQn','2026-07-24 14:12:32','2026-07-24 14:12:32'),(2,'Tim HRD Sentra Niaga','hrd@sentraniaga.com',NULL,'$2y$12$cMhaP0l4K71yzYuBnHs8jujvFTGI7mLOMcBLT4GhynBOJLC/mvHmW','hrd','TiLWYiYo2FirHmn6Q9t58osubLmYu732MZNSCU9sKMh97vmwm1JyeE2ItvrH','2026-07-24 14:12:33','2026-07-24 14:12:33');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-16  3:49:33
