/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.3.2-MariaDB, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: certchain
-- ------------------------------------------------------
-- Server version	12.3.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `blockchain_records`
--

DROP TABLE IF EXISTS `blockchain_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `blockchain_records` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `certificate_id` bigint(20) unsigned NOT NULL,
  `tx_hash` varchar(255) NOT NULL,
  `block_number` varchar(255) NOT NULL,
  `network` varchar(255) NOT NULL,
  `smart_contract` varchar(255) NOT NULL,
  `committed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `blockchain_records_tx_hash_unique` (`tx_hash`),
  KEY `blockchain_records_certificate_id_foreign` (`certificate_id`),
  CONSTRAINT `blockchain_records_certificate_id_foreign` FOREIGN KEY (`certificate_id`) REFERENCES `certificates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blockchain_records`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `blockchain_records` WRITE;
/*!40000 ALTER TABLE `blockchain_records` DISABLE KEYS */;
INSERT INTO `blockchain_records` VALUES
(1,1,'local-d0d27d9d-31c7-4fb4-ab4a-9f6771a78cf5','local-dev','sepolia','local-dev','2026-06-26 11:19:01'),
(2,2,'local-26a17d8a-4595-415a-bbe2-b019db047956','local-dev','sepolia','0x5e437860fcfe1e038d354241ed6008a534d014a3','2026-06-26 13:26:30'),
(3,3,'0x5f92d93f18e1301b06f8395350a9f638965622c3932991a3d25c9921d51d1cdf','11144574','sepolia','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','2026-06-26 14:42:03'),
(4,4,'0x9f0126a65c70bcb6967e0b64b9cbfcf952bb4705f54c2d7e32505a15040309b1','11144575','sepolia','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','2026-06-26 14:42:13'),
(5,5,'0x061589adf6cbae76549579eb05923309322fb88e39a7361469f1c7a6baf9982d','11144576','sepolia','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','2026-06-26 14:42:27'),
(6,6,'0xebf9b14d6c1e2d9a171d29eacdd4d3af52b109eb53c8b72807368223d9f29c44','11144577','sepolia','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','2026-06-26 14:42:37'),
(7,7,'0xe193fc2bf2d18bb2913702b9b84ad5f1216adb199e63ff42858fe6a43b3f9b57','11144578','sepolia','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','2026-06-26 14:42:51'),
(8,8,'0xc2d5f5c632ba9a06da64e89d7937195101e8f877bd6d2816a6cf4472e9755e8e','11144579','sepolia','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','2026-06-26 14:43:05'),
(9,9,'0xbabf8bb9aa7941a1437339323de9a6b611f229c2bca1674c641d8ef61ef5fa77','11144580','sepolia','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','2026-06-26 14:43:14'),
(10,10,'0x49f072b3ad23d21ad2b7db6efd7d4f176e3a2b2a4b948bfa6784525fc7c1530c','11144581','sepolia','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','2026-06-26 14:43:28'),
(11,11,'0x6456faadf3ae1f70bbc16dcc31da60358e9ef07206e22346ddd81787db9a3cfe','11144582','sepolia','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','2026-06-26 14:43:38'),
(12,12,'0x061363b6d3e7c144321e538d29e5db09f6b00588abb5e0f552ec11bb07ee4299','11144583','sepolia','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','2026-06-26 14:43:52'),
(13,13,'0x78abb2c2e27819b0e4709d6c4d71b7b251f26d5d72605b8ced0ba4ff4ff9ee85','11144584','sepolia','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','2026-06-26 14:44:02'),
(14,14,'0x3b064b976c5fc1d94b7b06dc77fdcf668b1539e5d010a34d2a73562fffc4a02a','11144585','sepolia','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','2026-06-26 14:44:16'),
(15,15,'0x5ff93a8a62eb6d00e75d294ebb90e92a7610bdf015a963635ed76d7a334cf935','11144586','sepolia','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','2026-06-26 14:44:25'),
(16,16,'0x4e008acf45c63791850482861fb25e29675452f515717356ce49b75cd3b64ffe','11144587','sepolia','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','2026-06-26 14:44:40'),
(17,17,'0x0610efc9a08c9281bfa7a79273278cd158f075c68adfe4cb5efef4b1723c9ccb','11144600','sepolia','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','2026-06-26 14:47:14'),
(18,18,'0x067340f43e642bc73af6b24b9569b459c96fa359e8a505d949646960c4be6b1c','11144725','sepolia','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','2026-06-26 15:12:13'),
(19,19,'0xbd60e454d54d8e91483c9ea02e19ad5126a722563e0f32f7f36c43091baa4a45','11144745','sepolia','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','2026-06-26 15:16:14');
/*!40000 ALTER TABLE `blockchain_records` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `certificates`
--

DROP TABLE IF EXISTS `certificates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `certificates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) unsigned NOT NULL,
  `issued_by` bigint(20) unsigned NOT NULL,
  `certificate_id` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `qr_path` varchar(255) DEFAULT NULL,
  `keccak256_hash` varchar(255) NOT NULL,
  `tx_hash` varchar(255) NOT NULL,
  `contract_address` varchar(255) NOT NULL,
  `status` enum('pending','issued','revoked') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `certificates_certificate_id_unique` (`certificate_id`),
  UNIQUE KEY `certificates_keccak256_hash_unique` (`keccak256_hash`),
  UNIQUE KEY `certificates_tx_hash_unique` (`tx_hash`),
  KEY `certificates_student_id_foreign` (`student_id`),
  KEY `certificates_issued_by_foreign` (`issued_by`),
  CONSTRAINT `certificates_issued_by_foreign` FOREIGN KEY (`issued_by`) REFERENCES `universities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `certificates_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certificates`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `certificates` WRITE;
/*!40000 ALTER TABLE `certificates` DISABLE KEYS */;
INSERT INTO `certificates` VALUES
(1,1,1,'UCAS-2026-TGHGHPNM','certificates/uIgNuNxASHSqziEVtYhfk4i8fHGla9wtG3vrMRgv.pdf','qrcodes/UCAS-2026-TGHGHPNM.svg','0xeec34bde07300a7f9b26065c4964d4c8934e608c4a57697df771c210de553a26','local-d0d27d9d-31c7-4fb4-ab4a-9f6771a78cf5','local-dev','issued','2026-06-26 08:19:01','2026-06-26 08:19:01'),
(2,2,1,'UCAS-2026-HAWAKWFX','certificates/AsXAdpE1K0WAfIc3RatsF5gwcEqCyPUlp3X06vFQ.pdf','qrcodes/UCAS-2026-HAWAKWFX.svg','0x27d4657ba9a2af999cc8b6afcf4600b8a9a3294772106d5b21370b6ca3b358ae','local-26a17d8a-4595-415a-bbe2-b019db047956','0x5e437860fcfe1e038d354241ed6008a534d014a3','issued','2026-06-26 10:26:30','2026-06-26 10:26:30'),
(3,3,1,'UCAS-2026-MZSR51WW','certificates/D0fIGXO86VzoCAxm5Yx6Bz8LosEY4KJGjXmNTPen.pdf','qrcodes/UCAS-2026-MZSR51WW.svg','0x36977b7da6917ef8fe7c5e71f1673e2f986f6f7d7415a8fd94731b75e2dd3c50','0x5f92d93f18e1301b06f8395350a9f638965622c3932991a3d25c9921d51d1cdf','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','issued','2026-06-26 11:42:03','2026-06-26 11:42:03'),
(4,3,1,'UCAS-2026-ICGBSNV8','certificates/GApshgzw1c7OyEPHnh80lyZeFufh5Qx6k5UN4CRl.pdf','qrcodes/UCAS-2026-ICGBSNV8.svg','0xaefdf8960c5c97ecc2ae9e226c6fb51f80b5bc92e304845df1fe0900254c7154','0x9f0126a65c70bcb6967e0b64b9cbfcf952bb4705f54c2d7e32505a15040309b1','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','issued','2026-06-26 11:42:13','2026-06-26 11:42:13'),
(5,3,1,'UCAS-2026-IIAHINIH','certificates/tX6UGFUlGkIEvn45oJFK6eYlOVQ7HCgHKDspdLGu.pdf','qrcodes/UCAS-2026-IIAHINIH.svg','0xe691eda611d18fcd2356f436b1ddc174571dc66655ffef5ef721c337c7985385','0x061589adf6cbae76549579eb05923309322fb88e39a7361469f1c7a6baf9982d','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','issued','2026-06-26 11:42:27','2026-06-26 11:42:27'),
(6,3,1,'UCAS-2026-D31AZ9Z7','certificates/a0dBGAt6cwRpyP8gGt09wQBg3NVtl7zbcqDS0Rxh.pdf','qrcodes/UCAS-2026-D31AZ9Z7.svg','0x4f8bd06c9eddb2672c72d0813590986001918ea81e7160cb82684307acfb7753','0xebf9b14d6c1e2d9a171d29eacdd4d3af52b109eb53c8b72807368223d9f29c44','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','issued','2026-06-26 11:42:37','2026-06-26 11:42:37'),
(7,3,1,'UCAS-2026-K7ET21YB','certificates/EJZDKi5CQbY7QXNcr5Kzjq7fFIkizUWHRH0fF2yf.pdf','qrcodes/UCAS-2026-K7ET21YB.svg','0x659c996cb73f562b184b0859d6765916e9eed16874eff2b897c2f95720134b41','0xe193fc2bf2d18bb2913702b9b84ad5f1216adb199e63ff42858fe6a43b3f9b57','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','issued','2026-06-26 11:42:51','2026-06-26 11:42:51'),
(8,3,1,'UCAS-2026-YJU5XMYH','certificates/tp3qxm6dQqU9XmXiZOm67h3ZjKwdY1yWCiFTzJLI.pdf','qrcodes/UCAS-2026-YJU5XMYH.svg','0x037e0103d5e53db502154276c32c771ff20298407007db11b6c414d5c74672d5','0xc2d5f5c632ba9a06da64e89d7937195101e8f877bd6d2816a6cf4472e9755e8e','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','issued','2026-06-26 11:43:05','2026-06-26 11:43:05'),
(9,3,1,'UCAS-2026-E054XGTE','certificates/nqOwJxUwZdoFjLIhruZLFyXkzHaQUadMHBQHUYZI.pdf','qrcodes/UCAS-2026-E054XGTE.svg','0x851670ff829d8c52fc285f4669474e8a500ade1f270fd76b685afe60acc8ba54','0xbabf8bb9aa7941a1437339323de9a6b611f229c2bca1674c641d8ef61ef5fa77','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','issued','2026-06-26 11:43:14','2026-06-26 11:43:14'),
(10,3,1,'UCAS-2026-BCUNSXZC','certificates/hyzcOhZSDrDWtDkZKliq1op9Q3Toy0o2phlFs5QF.pdf','qrcodes/UCAS-2026-BCUNSXZC.svg','0x94aa6828cc0ce90c807e823a34725947a89731eec65b4954d22cc50348dde2d5','0x49f072b3ad23d21ad2b7db6efd7d4f176e3a2b2a4b948bfa6784525fc7c1530c','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','issued','2026-06-26 11:43:28','2026-06-26 11:43:28'),
(11,3,1,'UCAS-2026-6LJGIBCE','certificates/rJmBYjwuaykSVOWJKDeU0aJQWnapCGmwW8k66qg9.pdf','qrcodes/UCAS-2026-6LJGIBCE.svg','0x3e8e08431d4f613204ccd0a7715370620b1ef7d0b83fcdccb9008a34fcd82ff1','0x6456faadf3ae1f70bbc16dcc31da60358e9ef07206e22346ddd81787db9a3cfe','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','issued','2026-06-26 11:43:38','2026-06-26 11:43:38'),
(12,3,1,'UCAS-2026-YZ5EI5BT','certificates/n71VV9SEBkAhXatBmdUUbl2ZUSn8MqYx02yUpZWK.pdf','qrcodes/UCAS-2026-YZ5EI5BT.svg','0x225ef39813bfc88f267c0c236853f15beeefbf6890150f33325e78bc21e4abec','0x061363b6d3e7c144321e538d29e5db09f6b00588abb5e0f552ec11bb07ee4299','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','issued','2026-06-26 11:43:52','2026-06-26 11:43:52'),
(13,3,1,'UCAS-2026-MX0RZ4XP','certificates/UMt4bhtxjgCEuaCt4dwU0plUPaIDKEAmosTI8cU0.pdf','qrcodes/UCAS-2026-MX0RZ4XP.svg','0x86717e160c0f09ed2f5141c83a08fe9c67f6328c2d4a172d3bcfb2d42919d735','0x78abb2c2e27819b0e4709d6c4d71b7b251f26d5d72605b8ced0ba4ff4ff9ee85','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','issued','2026-06-26 11:44:02','2026-06-26 11:44:02'),
(14,3,1,'UCAS-2026-HOU5EG8H','certificates/CV9Bui1mm3ZQjyhHx8ORBl5fcqkqGRqdy33Z6bw9.pdf','qrcodes/UCAS-2026-HOU5EG8H.svg','0x6e0a7ada82c91457e2c2a7189904a2ae9f00d76ed33671aa03d405dcfa75daad','0x3b064b976c5fc1d94b7b06dc77fdcf668b1539e5d010a34d2a73562fffc4a02a','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','issued','2026-06-26 11:44:16','2026-06-26 11:44:16'),
(15,3,1,'UCAS-2026-KSVT9VD2','certificates/Dyg2hvBcaYZaZ1kuVlfUhBXpiSkGxoDyixjsjGVb.pdf','qrcodes/UCAS-2026-KSVT9VD2.svg','0xf8031023dd4c74b516b1da727e445b7bc1d42e0bcdc9c71410d2f2d2e530190d','0x5ff93a8a62eb6d00e75d294ebb90e92a7610bdf015a963635ed76d7a334cf935','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','issued','2026-06-26 11:44:25','2026-06-26 11:44:25'),
(16,3,1,'UCAS-2026-69Z0HCCG','certificates/F1QTxThFPVBnPe9eenlqfeEqZobKfByJOGVBVm5C.pdf','qrcodes/UCAS-2026-69Z0HCCG.svg','0x0bcb269a9a25e598daecd9d5dbe90f56f49f1508ab08f08e64cf852303ad2680','0x4e008acf45c63791850482861fb25e29675452f515717356ce49b75cd3b64ffe','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','issued','2026-06-26 11:44:40','2026-06-26 11:44:40'),
(17,4,1,'UCAS-2026-8KYWMEI7','certificates/Q19c7IhP1N1o6EWfHpLM77S9qDkCecfWov58EtlI.pdf','qrcodes/UCAS-2026-8KYWMEI7.svg','0x0b2dba9c77d398d81d99482163fc6fce7f6109e995b83cf85217c3ec222d0aa9','0x0610efc9a08c9281bfa7a79273278cd158f075c68adfe4cb5efef4b1723c9ccb','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','issued','2026-06-26 11:47:14','2026-06-26 11:47:14'),
(18,5,1,'UCAS-2026-FY6XS9QG','certificates/UKWB3S4j7zt3aNWjPwrCtnG6Znp4CiPes97Tjq7Z.pdf','qrcodes/UCAS-2026-FY6XS9QG.svg','0xfaec0444bdc4f08048410ec98a1f11f273f9f02c4e135421e104cea591444c31','0x067340f43e642bc73af6b24b9569b459c96fa359e8a505d949646960c4be6b1c','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','issued','2026-06-26 12:12:13','2026-06-26 12:12:13'),
(19,4,1,'UCAS-2026-AZIGMDMD','certificates/dt2LD9j4F19a5FMk92OVXUP2OEA5ikXQRS230DkJ.pdf','qrcodes/UCAS-2026-AZIGMDMD.svg','0xb438865d9becc78a2d6520bff01ed420f93d1b3d0434b71162606d9369b2d636','0xbd60e454d54d8e91483c9ea02e19ad5126a722563e0f32f7f36c43091baa4a45','0xc5c4c60d88dd5ffef94afc4fde4250a092e1cb7b','issued','2026-06-26 12:16:14','2026-06-26 12:16:14');
/*!40000 ALTER TABLE `certificates` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_05_08_214421_create_universities_table',1),
(5,'2026_05_08_214600_create_students_table',1),
(6,'2026_05_08_214700_create_certificates_table',1),
(7,'2026_05_08_220231_create_blockchain_records_table',1),
(8,'2026_05_08_220518_create_verification_logs_table',1),
(9,'2026_06_03_071317_add_two_factor_columns_to_users_table',1),
(10,'2026_06_03_071318_create_passkeys_table',1),
(11,'2026_06_09_000000_create_role_requests_table',1),
(12,'2026_06_09_000001_create_notifications_table',1),
(13,'2026_06_09_000002_add_institution_to_users_table',1),
(14,'2026_06_24_122842_add_qr_path_to_certificates_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `passkeys`
--

DROP TABLE IF EXISTS `passkeys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `passkeys` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `credential_id` varchar(255) NOT NULL,
  `credential` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`credential`)),
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `passkeys_credential_id_unique` (`credential_id`),
  KEY `passkeys_user_id_index` (`user_id`),
  CONSTRAINT `passkeys_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `passkeys`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `passkeys` WRITE;
/*!40000 ALTER TABLE `passkeys` DISABLE KEYS */;
/*!40000 ALTER TABLE `passkeys` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `role_requests`
--

DROP TABLE IF EXISTS `role_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `requested_role` varchar(255) NOT NULL DEFAULT 'verifier',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `decided_at` timestamp NULL DEFAULT NULL,
  `decided_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_requests_user_id_foreign` (`user_id`),
  KEY `role_requests_decided_by_foreign` (`decided_by`),
  CONSTRAINT `role_requests_decided_by_foreign` FOREIGN KEY (`decided_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `role_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_requests`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `role_requests` WRITE;
/*!40000 ALTER TABLE `role_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_requests` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('PiyBPVJJxWBY7o4phu9gkAdbJlAKPkyWHLj3KVLK',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:152.0) Gecko/20100101 Firefox/152.0','eyJfdG9rZW4iOiJTUWtNTGJqakZMSm14UFc1YkpkbGNZdllwSlpVaHJaUzdkdGJQZ3pkIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC92ZXJpZnlcL1VDQVMtMjAyNi1JSUFISU5JSCIsInJvdXRlIjoicHVibGljLnZlcmlmeS5zaG93In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1782485504),
('PmVJaLdrObIUot0jShXhRxn4FuvrgO2Eip8VzNfB',1,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ6YVBFWkU2a1Y2OW0xUkxjTG93SDdQNGlpcTZyWm1DRUROcDJmUXFTIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImRhc2hib2FyZC5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==',1782486997);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `university_id` bigint(20) unsigned NOT NULL,
  `student_number` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `national_id` varchar(255) NOT NULL,
  `major` varchar(255) DEFAULT NULL,
  `degree_level` varchar(255) NOT NULL,
  `graduation_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_student_number_unique` (`student_number`),
  UNIQUE KEY `students_national_id_unique` (`national_id`),
  KEY `students_university_id_foreign` (`university_id`),
  CONSTRAINT `students_university_id_foreign` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES
(1,1,'120201111','sadeem','nadel','120201111','Cyber Security','Cyber Security','2026-06-22','2026-06-26 08:19:01','2026-06-26 08:19:01'),
(2,1,'220201122','feras','dahalan','220201122','Cyber Security','Cyber Security','2026-06-22','2026-06-26 10:26:30','2026-06-26 10:26:30'),
(3,1,'12020221122','sadeem','nadel','12020221122','Cyber Security','Cyber Security','2026-06-22','2026-06-26 11:42:03','2026-06-26 11:42:03'),
(4,1,'120202020','ali','shaat','120202020','art','art','2026-06-21','2026-06-26 11:47:14','2026-06-26 12:16:14'),
(5,1,'120203322','wajeeh','shaat','120203322','B.Sc. Computer Science','B.Sc. Computer Science','2026-06-12','2026-06-26 12:12:13','2026-06-26 12:12:13');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `universities`
--

DROP TABLE IF EXISTS `universities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `universities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `universities_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `universities`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `universities` WRITE;
/*!40000 ALTER TABLE `universities` DISABLE KEYS */;
INSERT INTO `universities` VALUES
(1,'University College of Applied Sciences (UCAS)',NULL,NULL,NULL,NULL,1,'2026-06-26 08:19:01','2026-06-26 08:19:01');
/*!40000 ALTER TABLE `universities` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `institution` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Test User','test@example.com',NULL,'$2y$12$71sJidK7B1jv7burcbFS5u5zUjhSIpdxgyTvxld2r2.hd0Sp92gvK',NULL,NULL,NULL,'admin',NULL,1,'h6u6m3Y2CwIQWqeC6f8W4w6ikJTLNKRzBKBIdHiadhcQiqk6ubTS6gcrRWi6','2026-06-26 06:46:38','2026-06-26 06:46:38');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `verification_logs`
--

DROP TABLE IF EXISTS `verification_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `verification_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `certificate_id` bigint(20) unsigned NOT NULL,
  `verifier_name` varchar(255) NOT NULL,
  `verifier_org` varchar(255) NOT NULL,
  `verifier_email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `is_valid` tinyint(1) NOT NULL DEFAULT 0,
  `verified_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `verification_logs_certificate_id_foreign` (`certificate_id`),
  CONSTRAINT `verification_logs_certificate_id_foreign` FOREIGN KEY (`certificate_id`) REFERENCES `certificates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verification_logs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `verification_logs` WRITE;
/*!40000 ALTER TABLE `verification_logs` DISABLE KEYS */;
INSERT INTO `verification_logs` VALUES
(1,1,'Test User','CertChain','test@example.com','127.0.0.1',1,'2026-06-26 08:19:21'),
(2,2,'Test User','CertChain','test@example.com','127.0.0.1',0,'2026-06-26 11:18:22'),
(3,16,'Test User','CertChain','test@example.com','127.0.0.1',1,'2026-06-26 11:45:38'),
(4,17,'Test User','CertChain','test@example.com','127.0.0.1',1,'2026-06-26 11:47:39'),
(5,17,'Test User','CertChain','test@example.com','127.0.0.1',1,'2026-06-26 11:47:46'),
(6,17,'Test User','CertChain','test@example.com','127.0.0.1',1,'2026-06-26 12:10:05');
/*!40000 ALTER TABLE `verification_logs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-06-26 18:17:16
