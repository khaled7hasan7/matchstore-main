-- MariaDB dump 10.19  Distrib 10.11.14-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: matchstore
-- ------------------------------------------------------
-- Server version	10.11.14-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `attribute_value_translations`
--

DROP TABLE IF EXISTS `attribute_value_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `attribute_value_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `attribute_value_id` bigint(20) unsigned NOT NULL,
  `language_code` varchar(5) NOT NULL,
  `translated_value` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `av_trans_lang_unique` (`attribute_value_id`,`language_code`),
  CONSTRAINT `av_trans_value_fk` FOREIGN KEY (`attribute_value_id`) REFERENCES `attribute_values` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attribute_value_translations`
--

LOCK TABLES `attribute_value_translations` WRITE;
/*!40000 ALTER TABLE `attribute_value_translations` DISABLE KEYS */;
INSERT INTO `attribute_value_translations` VALUES
(1,1,'en','Small','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(2,1,'de','Klein','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(3,1,'es','Pequeño','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(4,1,'fr','Small','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(5,2,'en','Medium','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(6,2,'de','Mittel','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(7,2,'es','Mediano','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(8,2,'fr','Medium','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(9,3,'en','Large','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(10,3,'de','Groß','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(11,3,'es','Grande','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(12,3,'fr','Large','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(13,4,'en','Red','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(14,4,'de','Rot','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(15,4,'es','Rojo','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(16,4,'fr','Red','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(17,5,'en','Blue','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(18,5,'de','Blau','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(19,5,'es','Azul','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(20,5,'fr','Blue','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(21,6,'en','Black','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(22,6,'de','Schwarz','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(23,6,'es','Negro','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(24,6,'fr','Black','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(37,1,'ar','صغير','2025-12-28 20:57:44','2025-12-28 20:57:44'),
(38,2,'ar','متوسط','2025-12-28 20:57:44','2025-12-28 20:57:44'),
(39,3,'ar','كبير','2025-12-28 20:57:44','2025-12-28 20:57:44'),
(40,4,'ar','أحمر','2025-12-28 20:57:44','2025-12-28 20:57:44'),
(41,5,'ar','أزرق','2025-12-28 20:57:44','2025-12-28 20:57:44'),
(42,6,'ar','أسود','2025-12-28 20:57:44','2025-12-28 20:57:44');
/*!40000 ALTER TABLE `attribute_value_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attribute_values`
--

DROP TABLE IF EXISTS `attribute_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `attribute_values` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `attribute_id` bigint(20) unsigned NOT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attribute_values_attribute_id_foreign` (`attribute_id`),
  CONSTRAINT `attribute_values_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attribute_values`
--

LOCK TABLES `attribute_values` WRITE;
/*!40000 ALTER TABLE `attribute_values` DISABLE KEYS */;
INSERT INTO `attribute_values` VALUES
(1,1,'Small','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(2,1,'Medium','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(3,1,'Large','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(4,2,'Red','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(5,2,'Blue','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(6,2,'Black','2025-12-28 20:16:44','2025-12-28 20:16:44');
/*!40000 ALTER TABLE `attribute_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attributes`
--

DROP TABLE IF EXISTS `attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `attributes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attributes`
--

LOCK TABLES `attributes` WRITE;
/*!40000 ALTER TABLE `attributes` DISABLE KEYS */;
INSERT INTO `attributes` VALUES
(1,'Size','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(2,'Color','2025-12-28 20:16:44','2025-12-28 20:16:44');
/*!40000 ALTER TABLE `attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banner_translations`
--

DROP TABLE IF EXISTS `banner_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `banner_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `banner_id` bigint(20) unsigned NOT NULL,
  `language_code` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `banner_translations_banner_id_language_code_unique` (`banner_id`,`language_code`),
  CONSTRAINT `banner_translations_banner_id_foreign` FOREIGN KEY (`banner_id`) REFERENCES `banners` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banner_translations`
--

LOCK TABLES `banner_translations` WRITE;
/*!40000 ALTER TABLE `banner_translations` DISABLE KEYS */;
INSERT INTO `banner_translations` VALUES
(1,1,'en','Ready to Shop','<p>Your one-stop shop for everything you need.</p>','public/banner_images/qSyPrATwl8i1o8xpiaPRuXJxWyVKvWofRKIMHX5b.jpg','2025-12-28 20:16:47','2026-01-12 11:32:11'),
(2,1,'de','Bereit zum Einkaufen','Ihr One-Stop-Shop für alles, was Sie brauchen.','banners/shoes-ready.png','2025-12-28 20:16:47','2025-12-28 20:16:47'),
(3,1,'es','Listo para comprar','Tu tienda única para todo lo que necesitas.','banners/shoes-ready.png','2025-12-28 20:16:48','2025-12-28 20:16:48'),
(4,1,'fr','Ready to Shop','Your one-stop shop for everything you need.','banners/shoes-ready.png','2025-12-28 20:16:48','2025-12-28 20:16:48'),
(5,2,'en','New Year 2026','<p>Your one-stop shop for everything you need.</p>','banner_images/G2YGO0XarRboKB6MmyTxEc4QI8sWZyxoGt77iAXd.jpg','2025-12-28 20:50:37','2026-01-07 21:18:45'),
(6,2,'ar','عروض السنة الجديدة 2026','<p>تصفح آخر العروض الآن</p>','public/banner_images/Roq52GgOAJMITZmBcZFSI1dfWy9DtcvYuT5Z6aFc.jpg','2025-12-28 20:50:37','2026-01-12 11:30:52'),
(7,2,'de','Bereit zum Einkaufen','<p>Ihr One-Stop-Shop für alles, was Sie brauchen.</p>','banners/shoes-ready.png','2025-12-28 20:50:38','2025-12-31 13:41:23'),
(8,2,'es','Listo para comprar','<p>Tu tienda única para todo lo que necesitas.</p>','banners/shoes-ready.png','2025-12-28 20:50:38','2025-12-31 13:41:23'),
(9,2,'fr','Ready to Shop','<p>Your one-stop shop for everything you need.</p>','banners/shoes-ready.png','2025-12-28 20:50:39','2025-12-31 13:41:23'),
(10,1,'ar','جاهز للتسوق','<p>المتجر الذي ستجد فيه كل ما تحتاجه</p>','public/banner_images/P2LnWztVvwjfLhY2lnn6aBxZyyvYWSAnZxUR2RO8.jpg','2026-01-12 11:31:57','2026-01-12 11:31:57');
/*!40000 ALTER TABLE `banner_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `banners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `type` enum('promotion','sale','seasonal','featured','announcement') NOT NULL DEFAULT 'promotion',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES
(1,NULL,1,'promotion','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(2,NULL,1,'promotion','2025-12-28 20:50:36','2026-01-03 16:38:03');
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brand_translations`
--

DROP TABLE IF EXISTS `brand_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `brand_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brand_translations_brand_id_locale_unique` (`brand_id`,`locale`),
  CONSTRAINT `brand_translations_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brand_translations`
--

LOCK TABLES `brand_translations` WRITE;
/*!40000 ALTER TABLE `brand_translations` DISABLE KEYS */;
INSERT INTO `brand_translations` VALUES
(1,1,'en','Awesome Brand','A high-quality brand known for its awesome products.','2025-12-28 20:53:30','2025-12-28 20:53:30'),
(2,1,'de','Großartige Marke','Eine hochwertige Marke, bekannt für ihre großartigen Produkte.','2025-12-28 20:53:30','2025-12-28 20:53:30'),
(3,1,'es','Marca Asombrosa','Una marca de alta calidad conocida por sus productos asombrosos.','2025-12-28 20:53:30','2025-12-28 20:53:30'),
(4,1,'fr','Awesome Brand','A high-quality brand known for its awesome products.','2025-12-28 20:53:30','2025-12-28 20:53:30'),
(5,1,'ar','علامة تجارية رائعة','علامة تجارية عالية الجودة معروفة بمنتجاتها الرائعة.','2025-12-28 20:53:30','2025-12-28 20:53:30');
/*!40000 ALTER TABLE `brand_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','discontinued') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brands_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES
(1,'awesome-brand','brands/logo-ready.png','active','2025-12-28 20:16:42','2025-12-28 20:16:42');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `parent_category_id` bigint(20) unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_parent_category_id_foreign` (`parent_category_id`),
  CONSTRAINT `categories_parent_category_id_foreign` FOREIGN KEY (`parent_category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES
(1,'electronics',NULL,1,'2025-12-28 20:16:42','2026-01-03 17:58:40'),
(2,'fashion',NULL,1,'2025-12-28 20:16:43','2025-12-28 20:16:43'),
(3,'smartphones',1,1,'2025-12-28 20:16:43','2025-12-28 20:16:43'),
(4,'t-shirts',2,1,'2025-12-28 20:16:43','2025-12-28 20:16:43');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_translations`
--

DROP TABLE IF EXISTS `category_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `language_code` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_translations_category_id_language_code_unique` (`category_id`,`language_code`),
  CONSTRAINT `category_translations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_translations`
--

LOCK TABLES `category_translations` WRITE;
/*!40000 ALTER TABLE `category_translations` DISABLE KEYS */;
INSERT INTO `category_translations` VALUES
(1,1,'en','Electronics','<p>Electronic devices</p>','categories/07-300x300-1-1-removebg-preview.png','2025-12-28 20:16:43','2025-12-31 11:58:56'),
(2,1,'de','Electronics','<p>Electronic devices</p>','categories/07-300x300-1-1-removebg-preview.png','2025-12-28 20:16:43','2025-12-31 11:58:56'),
(3,1,'es','Electrónica','<p>Dispositivos electrónicos</p>','categories/07-300x300-1-1-removebg-preview.png','2025-12-28 20:16:43','2025-12-31 11:58:56'),
(4,1,'fr','Électronique','<p>Appareils électroniques</p>','categories/07-300x300-1-1-removebg-preview.png','2025-12-28 20:16:43','2025-12-31 11:58:56'),
(5,2,'en','Fashion','Clothing and accessories','categories/cat7-removebg-preview.png','2025-12-28 20:16:43','2025-12-28 20:16:43'),
(6,2,'de','Fashion','Clothing and accessories','categories/cat7-removebg-preview.png','2025-12-28 20:16:43','2025-12-28 20:16:43'),
(7,2,'es','Moda','Ropa y accesorios','categories/cat7-removebg-preview.png','2025-12-28 20:16:43','2025-12-28 20:16:43'),
(8,2,'fr','Mode','Vêtements et accessoires','categories/cat7-removebg-preview.png','2025-12-28 20:16:43','2025-12-28 20:16:43'),
(9,3,'en','Smartphones','Latest mobile phones','categories/cat1-removebg-preview.png','2025-12-28 20:16:43','2025-12-28 20:16:43'),
(10,3,'de','Smartphones','Latest mobile phones','categories/cat1-removebg-preview.png','2025-12-28 20:16:43','2025-12-28 20:16:43'),
(11,3,'es','Smartphones','Últimos teléfonos móviles','categories/cat1-removebg-preview.png','2025-12-28 20:16:43','2025-12-28 20:16:43'),
(12,3,'fr','Smartphones','Derniers téléphones mobiles','categories/cat1-removebg-preview.png','2025-12-28 20:16:43','2025-12-28 20:16:43'),
(13,4,'en','T-Shirts','Casual wear t-shirts','categories/cat2-removebg-preview.png','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(14,4,'de','T-Shirts','Casual wear t-shirts','categories/cat2-removebg-preview.png','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(15,4,'es','Camisetas','Camisetas informales','categories/cat2-removebg-preview.png','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(16,4,'fr','T-shirts','T-shirts décontractés','categories/cat2-removebg-preview.png','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(17,1,'ar','إلكترونيات','<p>أجهزة إلكترونية</p>','categories/07-300x300-1-1-removebg-preview.png','2025-12-28 20:49:53','2025-12-31 11:58:56'),
(18,2,'ar','أزياء','ملابس وإكسسوارات','categories/cat7-removebg-preview.png','2025-12-28 20:49:53','2025-12-28 20:49:53'),
(19,3,'ar','هواتف ذكية','أحدث الهواتف المحمولة','categories/cat1-removebg-preview.png','2025-12-28 20:49:53','2025-12-28 20:49:53'),
(20,4,'ar','تي شيرتات','تي شيرتات كاجوال','categories/cat2-removebg-preview.png','2025-12-28 20:49:54','2025-12-28 20:49:54');
/*!40000 ALTER TABLE `category_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `type` enum('percentage','fixed') NOT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` VALUES
(1,'NEWYEAR2026',100.00,'fixed','2026-01-14 14:26:00','2026-01-03 12:26:48','2026-01-13 15:42:20'),
(2,'FLASHSALE2026',25.00,'percentage','2026-01-04 19:53:00','2026-01-03 17:54:03','2026-01-03 17:54:03'),
(3,'TAREQ2026',100.00,'fixed','2026-01-05 19:55:00','2026-01-03 17:55:44','2026-01-03 17:55:44');
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `currencies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `exchange_rate` decimal(10,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `currencies_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currencies`
--

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` VALUES
(1,'US Dollar','USD','$',1.0000,'2025-12-28 20:16:41','2025-12-28 20:16:41'),
(4,'Israeli New Shekel','NIS','₪',3.6500,'2025-12-30 18:35:51','2025-12-30 18:35:51'),
(5,'Jordanian Dinar','JOD','د.ا',0.7090,'2026-01-03 11:25:38','2026-01-03 11:25:38');
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_addresses`
--

DROP TABLE IF EXISTS `customer_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `street_address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `additional_info` text DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_addresses_customer_id_is_default_index` (`customer_id`,`is_default`),
  CONSTRAINT `customer_addresses_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_addresses`
--

LOCK TABLES `customer_addresses` WRITE;
/*!40000 ALTER TABLE `customer_addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES
(1,'Osama Jarrar','ojscofield720@gmail.com','$2y$12$jfZ4NMwX4d/ggYtJO.8EcudvMQ/wQit2DOx/AmIkXzO6UIZdmQ7SW',NULL,'customer_profiles/KZLpqdLD3qHeimLbntO2ii2gRDa8NcWNimBR1boy.jpg',NULL,'active','2025-12-29 17:27:00','2026-01-03 12:21:20','NRuygua0fnnvSA55ShOvCAeMawYkXuRkcedtcF3oFVAwffGFQd2TjaAZn1nl'),
(2,'Tareq Khanfar','tareqkh2016@gmail.com','$2y$12$yPpmHWqAZaFTOvvNmkSN9eTaApAAtWRDh1SCG87wn8.7bErddVDPy',NULL,NULL,NULL,'active','2026-01-13 15:41:00','2026-01-13 15:41:00',NULL);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

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

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

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
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `languages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `translated_text` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `languages_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES
(1,'en','English','English',1,'2025-12-28 20:16:41','2026-01-03 14:02:18'),
(2,'ar','Arabic','العربية',1,'2025-12-28 20:16:41','2026-01-03 14:02:18');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_item_translations`
--

DROP TABLE IF EXISTS `menu_item_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_item_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `menu_item_id` bigint(20) unsigned NOT NULL,
  `language_code` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_item_translations_menu_item_id_foreign` (`menu_item_id`),
  CONSTRAINT `menu_item_translations_menu_item_id_foreign` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_item_translations`
--

LOCK TABLES `menu_item_translations` WRITE;
/*!40000 ALTER TABLE `menu_item_translations` DISABLE KEYS */;
INSERT INTO `menu_item_translations` VALUES
(1,1,'en','Home','2025-12-28 20:57:46','2025-12-28 20:57:46'),
(2,1,'de','Home','2025-12-28 20:57:46','2025-12-28 20:57:46'),
(3,1,'es','Inicio','2025-12-28 20:57:46','2025-12-28 20:57:46'),
(4,1,'fr','Accueil','2025-12-28 20:57:46','2025-12-28 20:57:46'),
(5,2,'en','About Us','2025-12-28 20:57:46','2025-12-28 20:57:46'),
(9,3,'en','Our Services','2025-12-28 20:57:46','2025-12-28 20:57:46'),
(13,4,'en','Blog','2025-12-28 20:57:46','2025-12-28 20:57:46'),
(14,4,'de','Blog','2025-12-28 20:57:46','2025-12-28 20:57:46'),
(15,4,'es','Blog','2025-12-28 20:57:46','2025-12-28 20:57:46'),
(16,4,'fr','Blog','2025-12-28 20:57:46','2025-12-28 20:57:46'),
(17,5,'en','Contact Us','2025-12-28 20:57:46','2025-12-28 20:57:46'),
(18,5,'de','Contact Us','2025-12-28 20:57:46','2025-12-28 20:57:46'),
(19,5,'es','Contacto','2025-12-28 20:57:46','2025-12-28 20:57:46'),
(20,5,'fr','Contact','2025-12-28 20:57:46','2025-12-28 20:57:46'),
(21,1,'ar','الرئيسية','2025-12-28 20:57:46','2025-12-28 20:57:46'),
(22,2,'ar','من نحن','2025-12-28 20:57:46','2025-12-28 20:57:46'),
(23,3,'ar','خدماتنا','2025-12-28 20:57:46','2025-12-28 20:57:46'),
(24,4,'ar','المدونة','2025-12-28 20:57:46','2025-12-28 20:57:46'),
(25,5,'ar','اتصل بنا','2025-12-28 20:57:46','2025-12-28 20:57:46');
/*!40000 ALTER TABLE `menu_item_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint(20) unsigned NOT NULL,
  `slug` varchar(255) NOT NULL,
  `order_number` int(11) NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menu_items_slug_unique` (`slug`),
  KEY `menu_items_menu_id_foreign` (`menu_id`),
  KEY `menu_items_parent_id_foreign` (`parent_id`),
  CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `menu_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES
(1,1,'home',1,NULL,'2025-12-28 20:57:46','2025-12-28 20:57:46'),
(2,1,'about-us',2,NULL,'2025-12-28 20:57:46','2026-01-12 13:20:12'),
(3,1,'our-services',3,NULL,'2025-12-28 20:57:46','2026-01-12 13:20:18'),
(4,1,'blog',4,NULL,'2025-12-28 20:57:46','2025-12-28 20:57:46'),
(5,1,'contact',5,NULL,'2025-12-28 20:57:46','2025-12-28 20:57:46');
/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES
(1,'Main Menu',1,'2025-12-28 20:16:41','2025-12-28 20:16:41','2025-12-28 20:16:41'),
(2,'Main Menu',1,'2025-12-28 20:50:47','2025-12-28 20:50:47','2025-12-28 20:50:47'),
(3,'Main Menu',1,'2025-12-28 20:53:41','2025-12-28 20:53:41','2025-12-28 20:53:41');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_reset_tokens_table',1),
(3,'2014_10_12_100000_create_password_resets_table',1),
(4,'2019_08_19_000000_create_failed_jobs_table',1),
(5,'2019_12_14_000001_create_personal_access_tokens_table',1),
(6,'2025_01_18_165323_create_languages_table',1),
(7,'2025_01_24_064245_create_site_settings_table',1),
(8,'2025_01_26_105930_create_categories_table',1),
(9,'2025_01_26_110154_create_brands_table',1),
(10,'2025_01_26_110546_create_category_translations_table',1),
(11,'2025_01_26_110739_create_brand_translations_table',1),
(12,'2025_02_06_123525_create_banners_table',1),
(13,'2025_02_06_123926_create_banner_translations_table',1),
(14,'2025_02_12_123941_create_social_media_links_table',1),
(15,'2025_02_12_124118_create_social_media_link_translations_table',1),
(16,'2025_02_16_065528_create_menus_table',1),
(17,'2025_02_16_065802_create_menu_items_table',1),
(18,'2025_02_16_065921_create_menu_item_translations_table',1),
(19,'2025_03_16_084022_create_vendors_table',1),
(20,'2025_03_16_084048_create_shops_table',1),
(21,'2025_03_16_084108_create_customers_table',1),
(22,'2025_03_16_084130_create_currencies_table',1),
(23,'2025_03_16_084156_create_coupons_table',1),
(24,'2025_03_16_084254_create_products_table',1),
(25,'2025_03_16_084326_create_wishlists_table',1),
(26,'2025_03_16_084341_create_orders_table',1),
(27,'2025_03_16_084359_create_order_details_table',1),
(28,'2025_03_16_084502_create_shipping_addresses_table',1),
(29,'2025_03_16_085620_create_product_translations_table',1),
(30,'2025_03_16_102116_create_product_variants_table',1),
(31,'2025_03_16_102341_create_product_variant_translations_table',1),
(32,'2025_03_16_103136_create_product_reviews_table',1),
(33,'2025_03_18_191106_create_store_settings_table',1),
(34,'2025_03_29_115548_create_attributes_table',1),
(35,'2025_03_29_115612_create_attribute_values_table',1),
(36,'2025_03_29_115648_create_attribute_value_translations_table',1),
(37,'2025_03_29_115733_create_product_attribute_values_table',1),
(38,'2025_03_31_170450_create_product_images_table',1),
(39,'2025_04_05_071654_create_product_variant_attribute_values_table',1),
(40,'2025_05_29_084501_create_pages_table',1),
(41,'2025_05_29_084747_create_page_translations_table',1),
(42,'2025_09_01_041746_create_payment_gateways_table',1),
(43,'2025_09_01_041758_create_payment_gateway_configs_table',1),
(44,'2025_09_01_043045_create_payment_methods_table',1),
(45,'2025_09_01_043405_create_payments_table',1),
(46,'2025_09_01_043632_create_refunds_table',1),
(47,'2025_12_30_000001_add_nis_currency',2),
(48,'2025_12_30_000002_add_phone_numbers_to_site_settings',2),
(49,'2025_12_30_000003_create_shipping_zones_table',2),
(50,'2025_12_31_185724_make_site_settings_columns_nullable',3),
(51,'2025_12_31_192031_add_remember_token_to_customers_table',4),
(52,'2025_12_31_195528_create_shipping_regions_table',5),
(53,'2026_01_03_132510_update_currencies_remove_eur_gbp_add_jod',6),
(54,'2026_01_05_135955_add_checkout_fields_to_orders_table',7),
(55,'2026_01_05_140324_add_variant_and_attributes_to_order_details_table',8),
(56,'2026_01_12_142306_create_promo_cards_table',9),
(57,'2026_01_13_210952_create_contacts_table',10),
(58,'2026_01_13_211640_create_subscribers_table',11),
(59,'2026_01_14_155404_create_jobs_table',12),
(60,'2026_01_14_190312_create_customer_addresses_table',13),
(61,'2026_01_27_214257_add_default_currency_and_language_to_site_settings',14);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `variant_id` bigint(20) unsigned DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `attributes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_details_order_id_foreign` (`order_id`),
  KEY `order_details_product_id_foreign` (`product_id`),
  CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_details`
--

LOCK TABLES `order_details` WRITE;
/*!40000 ALTER TABLE `order_details` DISABLE KEYS */;
INSERT INTO `order_details` VALUES
(3,4,27,64,1,299.99,'[]','2026-01-12 16:13:17','2026-01-12 16:13:17'),
(4,5,20,57,1,24.99,'[]','2026-01-13 15:43:34','2026-01-13 15:43:34'),
(5,6,28,65,1,39.99,'[]','2026-01-23 17:21:18','2026-01-23 17:21:18'),
(6,6,26,63,1,169.99,'[]','2026-01-23 17:21:18','2026-01-23 17:21:18'),
(7,6,25,62,1,199.99,'[]','2026-01-23 17:21:18','2026-01-23 17:21:18'),
(8,7,28,65,2,39.99,'[]','2026-01-24 20:05:59','2026-01-24 20:05:59');
/*!40000 ALTER TABLE `order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vendor_id` bigint(20) unsigned DEFAULT NULL,
  `customer_id` bigint(20) unsigned DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(500) NOT NULL,
  `suite` varchar(100) DEFAULT NULL,
  `country` varchar(100) NOT NULL,
  `region_id` bigint(20) unsigned DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `zipcode` varchar(20) NOT NULL,
  `use_as_billing` tinyint(1) NOT NULL DEFAULT 1,
  `billing_address` varchar(500) DEFAULT NULL,
  `billing_suite` varchar(100) DEFAULT NULL,
  `billing_city` varchar(100) DEFAULT NULL,
  `billing_zipcode` varchar(20) DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_status` enum('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(255) DEFAULT NULL,
  `guest_email` varchar(255) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','canceled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_vendor_id_foreign` (`vendor_id`),
  KEY `orders_customer_id_foreign` (`customer_id`),
  CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES
(4,NULL,1,'Osama','Jarrar','ojscofield720@gmail.com','0594358876','Birzeit Street, Ramallah','5','palestine',13,'Ramallah','41232',1,NULL,NULL,NULL,NULL,'cod','pending',NULL,NULL,299.99,'pending','2026-01-12 16:13:17','2026-01-12 16:13:17'),
(5,NULL,2,'Tareq','Khanfar','tareqkh2016@gmail.com','0594628213','Marj Street, Birzeit, Ramallah','5','palestine',13,'Ramallah','41232',1,NULL,NULL,NULL,NULL,'cod','pending',NULL,NULL,24.99,'pending','2026-01-13 15:43:34','2026-01-13 15:43:34'),
(6,NULL,1,'Osama','Jarrar','ojscofield720@gmail.com','0594358876','Birzeit Street, Ramallah','5','palestine',17,'Jenin','41232',1,NULL,NULL,NULL,NULL,'cod','pending',NULL,NULL,409.97,'pending','2026-01-23 17:21:18','2026-01-23 17:21:18'),
(7,NULL,1,'Osama','Jarrar','ojscofield720@gmail.com','0594358876','Birzeit Street','5','palestine',17,'جنين','11523',1,NULL,NULL,NULL,NULL,'cod','pending',NULL,NULL,79.98,'pending','2026-01-24 20:05:59','2026-01-24 20:05:59');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_translations`
--

DROP TABLE IF EXISTS `page_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `page_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` bigint(20) unsigned NOT NULL,
  `language_code` varchar(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_translations_page_id_language_code_unique` (`page_id`,`language_code`),
  CONSTRAINT `page_translations_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_translations`
--

LOCK TABLES `page_translations` WRITE;
/*!40000 ALTER TABLE `page_translations` DISABLE KEYS */;
INSERT INTO `page_translations` VALUES
(1,1,'en','About Us','<div class=\"about-us-content\">\n    <h2>Welcome to VelStore by Match Systems</h2>\n    <p>VelStore is your premier online shopping destination, offering a curated selection of high-quality products across multiple categories. Powered by Match Systems, we combine cutting-edge technology with exceptional customer service to deliver an unparalleled shopping experience.</p>\n\n    <h3>Our Story</h3>\n    <p>Founded with a vision to revolutionize online retail, VelStore emerged from Match Systems\' commitment to innovation and customer satisfaction. We understand that modern consumers demand convenience, quality, and reliability – and we\'re here to deliver all three.</p>\n\n    <h3>What We Offer</h3>\n    <ul>\n        <li><strong>Wide Product Selection:</strong> From electronics to fashion, home goods to lifestyle products, we offer an extensive range carefully selected to meet your needs.</li>\n        <li><strong>Quality Assurance:</strong> Every product in our catalog undergoes rigorous quality checks to ensure you receive only the best.</li>\n        <li><strong>Competitive Pricing:</strong> We work directly with manufacturers and trusted suppliers to bring you competitive prices without compromising on quality.</li>\n        <li><strong>Fast & Reliable Shipping:</strong> With our strategic shipping network covering Jordan and Palestine, we ensure your orders arrive quickly and safely.</li>\n        <li><strong>Secure Shopping:</strong> Your privacy and security are our top priorities. We use industry-leading encryption and security measures to protect your data.</li>\n    </ul>\n\n    <h3>Our Commitment</h3>\n    <p>At VelStore, customer satisfaction isn\'t just a goal – it\'s our foundation. We\'re committed to:</p>\n    <ul>\n        <li>Providing exceptional 24/7 customer support</li>\n        <li>Maintaining transparent pricing with no hidden fees</li>\n        <li>Offering hassle-free returns and exchanges</li>\n        <li>Continuously improving our platform based on your feedback</li>\n        <li>Supporting local communities in Jordan and Palestine</li>\n    </ul>\n\n    <h3>Match Systems Technology</h3>\n    <p>Powered by Match Systems, VelStore leverages advanced e-commerce technology to provide you with a seamless shopping experience. Our platform features intelligent search, personalized recommendations, secure payment processing, and real-time order tracking – all designed to make your shopping journey effortless.</p>\n\n    <h3>Our Vision</h3>\n    <p>We envision a future where online shopping is not just convenient, but truly delightful. By combining technology, quality products, and genuine care for our customers, we\'re building more than just a store – we\'re creating a shopping community you can trust.</p>\n\n    <h3>Contact Us</h3>\n    <p>Have questions or feedback? We\'d love to hear from you! Our customer support team is available 24/7 to assist you with any inquiries, concerns, or suggestions.</p>\n\n    <p class=\"text-center mt-5\"><strong>Thank you for choosing VelStore – Where Quality Meets Convenience</strong></p>\n</div>',NULL,'2025-12-31 18:09:18','2025-12-31 18:09:18'),
(2,1,'ar','من نحن','<div class=\"about-us-content\">\n    <h2>مرحباً بك في VelStore من Match Systems</h2>\n    <p>VelStore هي وجهتك الأولى للتسوق عبر الإنترنت، حيث نقدم مجموعة مختارة من المنتجات عالية الجودة عبر فئات متعددة. بدعم من Match Systems، نجمع بين التكنولوجيا المتطورة وخدمة العملاء الاستثنائية لتقديم تجربة تسوق لا مثيل لها.</p>\n\n    <h3>قصتنا</h3>\n    <p>تأسست VelStore برؤية ثورية لتجارة التجزئة عبر الإنترنت، وانبثقت من التزام Match Systems بالابتكار ورضا العملاء. نحن ندرك أن المستهلكين العصريين يطالبون بالراحة والجودة والموثوقية – ونحن هنا لتقديم الثلاثة جميعاً.</p>\n\n    <h3>ما نقدمه</h3>\n    <ul>\n        <li><strong>تشكيلة واسعة من المنتجات:</strong> من الإلكترونيات إلى الأزياء، من المنتجات المنزلية إلى منتجات نمط الحياة، نقدم مجموعة واسعة تم اختيارها بعناية لتلبية احتياجاتك.</li>\n        <li><strong>ضمان الجودة:</strong> كل منتج في كتالوجنا يخضع لفحوصات جودة صارمة لضمان حصولك على الأفضل فقط.</li>\n        <li><strong>أسعار تنافسية:</strong> نعمل مباشرة مع الشركات المصنعة والموردين الموثوقين لنقدم لك أسعاراً تنافسية دون المساس بالجودة.</li>\n        <li><strong>شحن سريع وموثوق:</strong> مع شبكة الشحن الاستراتيجية التي تغطي الأردن وفلسطين، نضمن وصول طلباتك بسرعة وأمان.</li>\n        <li><strong>تسوق آمن:</strong> خصوصيتك وأمانك هما أولوياتنا القصوى. نستخدم تشفيراً وإجراءات أمنية رائدة في الصناعة لحماية بياناتك.</li>\n    </ul>\n\n    <h3>التزامنا</h3>\n    <p>في VelStore، رضا العملاء ليس مجرد هدف – إنه أساسنا. نحن ملتزمون بـ:</p>\n    <ul>\n        <li>تقديم دعم عملاء استثنائي على مدار الساعة طوال أيام الأسبوع</li>\n        <li>الحفاظ على تسعير شفاف بدون رسوم مخفية</li>\n        <li>تقديم عمليات إرجاع واستبدال خالية من المتاعب</li>\n        <li>التحسين المستمر لمنصتنا بناءً على ملاحظاتك</li>\n        <li>دعم المجتمعات المحلية في الأردن وفلسطين</li>\n    </ul>\n\n    <h3>تكنولوجيا Match Systems</h3>\n    <p>بدعم من Match Systems، تستفيد VelStore من تكنولوجيا التجارة الإلكترونية المتقدمة لتزويدك بتجربة تسوق سلسة. تتميز منصتنا بالبحث الذكي والتوصيات الشخصية ومعالجة الدفع الآمنة وتتبع الطلبات في الوقت الفعلي – كل ذلك مصمم لجعل رحلة التسوق الخاصة بك سهلة.</p>\n\n    <h3>رؤيتنا</h3>\n    <p>نتصور مستقبلاً حيث لا يكون التسوق عبر الإنترنت مريحاً فحسب، بل ممتعاً حقاً. من خلال الجمع بين التكنولوجيا والمنتجات عالية الجودة والاهتمام الحقيقي بعملائنا، نبني أكثر من مجرد متجر – نحن نخلق مجتمع تسوق يمكنك الوثوق به.</p>\n\n    <h3>اتصل بنا</h3>\n    <p>لديك أسئلة أو ملاحظات؟ نود أن نسمع منك! فريق دعم العملاء لدينا متاح على مدار الساعة طوال أيام الأسبوع لمساعدتك في أي استفسارات أو مخاوف أو اقتراحات.</p>\n\n    <p class=\"text-center mt-5\"><strong>شكراً لاختيارك VelStore – حيث تلتقي الجودة بالراحة</strong></p>\n</div>',NULL,'2025-12-31 18:09:18','2025-12-31 18:09:18'),
(3,2,'en','Privacy Policy','<div class=\"privacy-policy-content\">\n    <p><em>Last Updated: December 31, 2025</em></p>\n\n    <h2>Privacy Policy</h2>\n    <p>At VelStore, operated by Match Systems, we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website and use our services.</p>\n\n    <h3>1. Information We Collect</h3>\n\n    <h4>1.1 Personal Information</h4>\n    <p>We collect information that you provide directly to us, including:</p>\n    <ul>\n        <li>Name and contact information (email address, phone number, shipping address)</li>\n        <li>Account credentials (username and password)</li>\n        <li>Payment information (credit card details, billing address)</li>\n        <li>Purchase history and preferences</li>\n        <li>Communication preferences</li>\n        <li>Customer service correspondence</li>\n    </ul>\n\n    <h4>1.2 Automatically Collected Information</h4>\n    <p>When you access our website, we automatically collect certain information, including:</p>\n    <ul>\n        <li>Device information (IP address, browser type, operating system)</li>\n        <li>Usage data (pages visited, time spent, links clicked)</li>\n        <li>Cookies and similar tracking technologies</li>\n        <li>Location data (with your permission)</li>\n    </ul>\n\n    <h3>2. How We Use Your Information</h3>\n    <p>We use the collected information for various purposes:</p>\n    <ul>\n        <li>Processing and fulfilling your orders</li>\n        <li>Managing your account and providing customer support</li>\n        <li>Sending order confirmations and shipping updates</li>\n        <li>Personalizing your shopping experience</li>\n        <li>Improving our website and services</li>\n        <li>Sending marketing communications (with your consent)</li>\n        <li>Preventing fraud and ensuring security</li>\n        <li>Complying with legal obligations</li>\n    </ul>\n\n    <h3>3. Information Sharing and Disclosure</h3>\n    <p>We do not sell your personal information. We may share your information with:</p>\n    <ul>\n        <li><strong>Service Providers:</strong> Third-party vendors who assist with payment processing, shipping, email delivery, and analytics</li>\n        <li><strong>Business Partners:</strong> Trusted partners who help us operate our business</li>\n        <li><strong>Legal Requirements:</strong> When required by law or to protect our rights</li>\n        <li><strong>Business Transfers:</strong> In connection with a merger, acquisition, or sale of assets</li>\n    </ul>\n\n    <h3>4. Data Security</h3>\n    <p>We implement industry-standard security measures to protect your personal information:</p>\n    <ul>\n        <li>SSL/TLS encryption for data transmission</li>\n        <li>Secure payment processing through trusted providers</li>\n        <li>Regular security audits and updates</li>\n        <li>Access controls and authentication measures</li>\n        <li>Employee training on data protection</li>\n    </ul>\n\n    <h3>5. Your Rights and Choices</h3>\n    <p>You have the following rights regarding your personal information:</p>\n    <ul>\n        <li><strong>Access:</strong> Request access to your personal data</li>\n        <li><strong>Correction:</strong> Update or correct inaccurate information</li>\n        <li><strong>Deletion:</strong> Request deletion of your personal data</li>\n        <li><strong>Opt-out:</strong> Unsubscribe from marketing communications</li>\n        <li><strong>Data Portability:</strong> Request a copy of your data in a portable format</li>\n    </ul>\n\n    <h3>6. Cookies and Tracking Technologies</h3>\n    <p>We use cookies and similar technologies to enhance your experience. You can control cookie preferences through your browser settings. Note that disabling cookies may affect website functionality.</p>\n\n    <h3>7. Children\'s Privacy</h3>\n    <p>Our services are not directed to individuals under the age of 18. We do not knowingly collect personal information from children. If you believe we have collected information from a child, please contact us immediately.</p>\n\n    <h3>8. International Data Transfers</h3>\n    <p>Your information may be transferred to and processed in countries other than your country of residence. We ensure appropriate safeguards are in place to protect your data during such transfers.</p>\n\n    <h3>9. Data Retention</h3>\n    <p>We retain your personal information for as long as necessary to fulfill the purposes outlined in this policy, comply with legal obligations, resolve disputes, and enforce our agreements.</p>\n\n    <h3>10. Changes to This Privacy Policy</h3>\n    <p>We may update this Privacy Policy periodically. We will notify you of any material changes by posting the new policy on our website and updating the \"Last Updated\" date.</p>\n\n    <h3>11. Contact Us</h3>\n    <p>If you have questions or concerns about this Privacy Policy or our data practices, please contact us:</p>\n    <ul>\n        <li>Email: privacy@velstore.com</li>\n        <li>Phone: Available 24/7 through our customer support</li>\n    </ul>\n\n    <p class=\"mt-4\"><strong>By using VelStore, you acknowledge that you have read and understood this Privacy Policy and agree to its terms.</strong></p>\n</div>',NULL,'2025-12-31 18:09:18','2025-12-31 18:09:18'),
(4,2,'ar','سياسة الخصوصية','<div class=\"privacy-policy-content\">\n    <p><em>آخر تحديث: 31 ديسمبر 2025</em></p>\n\n    <h2>سياسة الخصوصية</h2>\n    <p>في VelStore، التي تديرها Match Systems، نلتزم بحماية خصوصيتك وضمان أمان معلوماتك الشخصية. توضح سياسة الخصوصية هذه كيفية جمع معلوماتك واستخدامها والإفصاح عنها وحمايتها عند زيارة موقعنا واستخدام خدماتنا.</p>\n\n    <h3>1. المعلومات التي نجمعها</h3>\n\n    <h4>1.1 المعلومات الشخصية</h4>\n    <p>نجمع المعلومات التي تقدمها لنا مباشرةً، بما في ذلك:</p>\n    <ul>\n        <li>الاسم ومعلومات الاتصال (عنوان البريد الإلكتروني، رقم الهاتف، عنوان الشحن)</li>\n        <li>بيانات اعتماد الحساب (اسم المستخدم وكلمة المرور)</li>\n        <li>معلومات الدفع (تفاصيل بطاقة الائتمان، عنوان الفواتير)</li>\n        <li>سجل الشراء والتفضيلات</li>\n        <li>تفضيلات الاتصال</li>\n        <li>مراسلات خدمة العملاء</li>\n    </ul>\n\n    <h4>1.2 المعلومات المجمعة تلقائياً</h4>\n    <p>عند دخولك إلى موقعنا، نجمع تلقائياً معلومات معينة، بما في ذلك:</p>\n    <ul>\n        <li>معلومات الجهاز (عنوان IP، نوع المتصفح، نظام التشغيل)</li>\n        <li>بيانات الاستخدام (الصفحات التي تمت زيارتها، الوقت المستغرق، الروابط المنقر عليها)</li>\n        <li>ملفات تعريف الارتباط وتقنيات التتبع المماثلة</li>\n        <li>بيانات الموقع (بإذنك)</li>\n    </ul>\n\n    <h3>2. كيف نستخدم معلوماتك</h3>\n    <p>نستخدم المعلومات المجمعة لأغراض مختلفة:</p>\n    <ul>\n        <li>معالجة وتنفيذ طلباتك</li>\n        <li>إدارة حسابك وتقديم دعم العملاء</li>\n        <li>إرسال تأكيدات الطلب وتحديثات الشحن</li>\n        <li>تخصيص تجربة التسوق الخاصة بك</li>\n        <li>تحسين موقعنا وخدماتنا</li>\n        <li>إرسال اتصالات تسويقية (بموافقتك)</li>\n        <li>منع الاحتيال وضمان الأمان</li>\n        <li>الامتثال للالتزامات القانونية</li>\n    </ul>\n\n    <h3>3. مشاركة المعلومات والإفصاح عنها</h3>\n    <p>نحن لا نبيع معلوماتك الشخصية. قد نشارك معلوماتك مع:</p>\n    <ul>\n        <li><strong>مقدمو الخدمات:</strong> البائعون الخارجيون الذين يساعدون في معالجة الدفع والشحن وتسليم البريد الإلكتروني والتحليلات</li>\n        <li><strong>شركاء الأعمال:</strong> الشركاء الموثوقون الذين يساعدوننا في تشغيل أعمالنا</li>\n        <li><strong>المتطلبات القانونية:</strong> عندما يتطلب القانون ذلك أو لحماية حقوقنا</li>\n        <li><strong>عمليات نقل الأعمال:</strong> فيما يتعلق بالاندماج أو الاستحواذ أو بيع الأصول</li>\n    </ul>\n\n    <h3>4. أمان البيانات</h3>\n    <p>نطبق إجراءات أمنية متوافقة مع معايير الصناعة لحماية معلوماتك الشخصية:</p>\n    <ul>\n        <li>تشفير SSL/TLS لنقل البيانات</li>\n        <li>معالجة الدفع الآمنة من خلال مزودي خدمة موثوقين</li>\n        <li>عمليات تدقيق وتحديثات أمنية منتظمة</li>\n        <li>ضوابط الوصول وإجراءات المصادقة</li>\n        <li>تدريب الموظفين على حماية البيانات</li>\n    </ul>\n\n    <h3>5. حقوقك وخياراتك</h3>\n    <p>لديك الحقوق التالية فيما يتعلق بمعلوماتك الشخصية:</p>\n    <ul>\n        <li><strong>الوصول:</strong> طلب الوصول إلى بياناتك الشخصية</li>\n        <li><strong>التصحيح:</strong> تحديث أو تصحيح المعلومات غير الدقيقة</li>\n        <li><strong>الحذف:</strong> طلب حذف بياناتك الشخصية</li>\n        <li><strong>إلغاء الاشتراك:</strong> إلغاء الاشتراك في الاتصالات التسويقية</li>\n        <li><strong>قابلية نقل البيانات:</strong> طلب نسخة من بياناتك بتنسيق قابل للنقل</li>\n    </ul>\n\n    <h3>6. ملفات تعريف الارتباط وتقنيات التتبع</h3>\n    <p>نستخدم ملفات تعريف الارتباط وتقنيات مماثلة لتحسين تجربتك. يمكنك التحكم في تفضيلات ملفات تعريف الارتباط من خلال إعدادات المتصفح. لاحظ أن تعطيل ملفات تعريف الارتباط قد يؤثر على وظائف الموقع.</p>\n\n    <h3>7. خصوصية الأطفال</h3>\n    <p>خدماتنا غير موجهة للأفراد الذين تقل أعمارهم عن 18 عاماً. نحن لا نجمع عن قصد معلومات شخصية من الأطفال. إذا كنت تعتقد أننا جمعنا معلومات من طفل، فيرجى الاتصال بنا فوراً.</p>\n\n    <h3>8. نقل البيانات الدولية</h3>\n    <p>قد يتم نقل معلوماتك ومعالجتها في بلدان غير بلد إقامتك. نضمن وجود ضمانات مناسبة لحماية بياناتك أثناء هذه النقل.</p>\n\n    <h3>9. الاحتفاظ بالبيانات</h3>\n    <p>نحتفظ بمعلوماتك الشخصية طالما كان ذلك ضرورياً لتحقيق الأغراض الموضحة في هذه السياسة، والامتثال للالتزامات القانونية، وحل النزاعات، وإنفاذ اتفاقياتنا.</p>\n\n    <h3>10. التغييرات على سياسة الخصوصية هذه</h3>\n    <p>قد نقوم بتحديث سياسة الخصوصية هذه بشكل دوري. سنخطرك بأي تغييرات جوهرية عن طريق نشر السياسة الجديدة على موقعنا وتحديث تاريخ \"آخر تحديث\".</p>\n\n    <h3>11. اتصل بنا</h3>\n    <p>إذا كانت لديك أسئلة أو مخاوف بشأن سياسة الخصوصية هذه أو ممارسات البيانات لدينا، يرجى الاتصال بنا:</p>\n    <ul>\n        <li>البريد الإلكتروني: privacy@velstore.com</li>\n        <li>الهاتف: متاح على مدار الساعة طوال أيام الأسبوع من خلال دعم العملاء لدينا</li>\n    </ul>\n\n    <p class=\"mt-4\"><strong>باستخدام VelStore، فإنك تقر بأنك قرأت وفهمت سياسة الخصوصية هذه وتوافق على شروطها.</strong></p>\n</div>',NULL,'2025-12-31 18:09:18','2025-12-31 18:09:18'),
(5,3,'en','Terms of Service','<div class=\"terms-of-service-content\">\n    <p><em>Last Updated: December 31, 2025</em></p>\n\n    <h2>Terms of Service</h2>\n    <p>Welcome to VelStore, operated by Match Systems. By accessing or using our website and services, you agree to be bound by these Terms of Service. Please read them carefully.</p>\n\n    <h3>1. Acceptance of Terms</h3>\n    <p>By creating an account, placing an order, or using any part of our services, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service and our Privacy Policy. If you do not agree, please do not use our services.</p>\n\n    <h3>2. Eligibility</h3>\n    <p>You must be at least 18 years old to use our services. By using VelStore, you represent and warrant that you meet this age requirement and have the legal capacity to enter into binding contracts.</p>\n\n    <h3>3. Account Registration</h3>\n    <ul>\n        <li>You must provide accurate, current, and complete information during registration</li>\n        <li>You are responsible for maintaining the confidentiality of your account credentials</li>\n        <li>You are responsible for all activities that occur under your account</li>\n        <li>You must notify us immediately of any unauthorized use of your account</li>\n        <li>We reserve the right to suspend or terminate accounts that violate these terms</li>\n    </ul>\n\n    <h3>4. Products and Pricing</h3>\n    <ul>\n        <li>All products are subject to availability</li>\n        <li>We reserve the right to limit quantities purchased per person or order</li>\n        <li>Prices are displayed in USD and are subject to change without notice</li>\n        <li>We strive for accuracy in product descriptions and pricing, but errors may occur</li>\n        <li>We reserve the right to refuse or cancel orders for products with pricing errors</li>\n        <li>Promotional offers are subject to specific terms and conditions</li>\n    </ul>\n\n    <h3>5. Orders and Payment</h3>\n    <ul>\n        <li>Placing an order constitutes an offer to purchase products</li>\n        <li>We reserve the right to accept or decline your order</li>\n        <li>Payment must be received before order processing</li>\n        <li>We accept major credit cards and approved payment methods</li>\n        <li>All payments are processed securely through trusted payment gateways</li>\n        <li>You are responsible for any applicable taxes and fees</li>\n    </ul>\n\n    <h3>6. Shipping and Delivery</h3>\n    <ul>\n        <li>We currently ship to Jordan and Palestine</li>\n        <li>Delivery times are estimates and not guaranteed</li>\n        <li>Shipping costs are calculated based on destination and weight</li>\n        <li>Risk of loss and title pass to you upon delivery to the carrier</li>\n        <li>You must inspect shipments upon receipt and report damages within 48 hours</li>\n        <li>Delays due to customs, weather, or carrier issues are beyond our control</li>\n    </ul>\n\n    <h3>7. Returns and Refunds</h3>\n    <ul>\n        <li>We offer a 30-day return policy for most products</li>\n        <li>Products must be unused, in original packaging, and in resalable condition</li>\n        <li>Certain items (personal care, intimate items, custom products) are non-returnable</li>\n        <li>Return shipping costs are the customer\'s responsibility unless the item is defective</li>\n        <li>Refunds are processed within 7-10 business days after receiving returned items</li>\n        <li>Original shipping charges are non-refundable</li>\n    </ul>\n\n    <h3>8. Warranties and Disclaimers</h3>\n    <p>Products are covered by manufacturer warranties where applicable. VelStore makes no additional warranties beyond those provided by manufacturers. TO THE FULLEST EXTENT PERMITTED BY LAW, OUR SERVICES ARE PROVIDED \"AS IS\" WITHOUT WARRANTIES OF ANY KIND, EXPRESS OR IMPLIED.</p>\n\n    <h3>9. Limitation of Liability</h3>\n    <p>TO THE MAXIMUM EXTENT PERMITTED BY LAW, VELSTORE AND MATCH SYSTEMS SHALL NOT BE LIABLE FOR ANY INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES, OR ANY LOSS OF PROFITS OR REVENUES, WHETHER INCURRED DIRECTLY OR INDIRECTLY.</p>\n\n    <h3>10. Intellectual Property</h3>\n    <ul>\n        <li>All content on VelStore (logos, text, images, graphics) is owned by Match Systems or its licensors</li>\n        <li>You may not copy, reproduce, distribute, or create derivative works without permission</li>\n        <li>Product images and descriptions are protected by copyright and trademark laws</li>\n        <li>Unauthorized use of our intellectual property may result in legal action</li>\n    </ul>\n\n    <h3>11. User Conduct</h3>\n    <p>You agree not to:</p>\n    <ul>\n        <li>Use our services for any illegal or unauthorized purpose</li>\n        <li>Violate any local, national, or international laws</li>\n        <li>Infringe upon the rights of others</li>\n        <li>Transmit viruses, malware, or harmful code</li>\n        <li>Attempt to gain unauthorized access to our systems</li>\n        <li>Interfere with the proper functioning of our website</li>\n        <li>Engage in fraudulent activities or impersonate others</li>\n    </ul>\n\n    <h3>12. Reviews and User Content</h3>\n    <ul>\n        <li>You may submit product reviews and ratings</li>\n        <li>Content must be truthful, relevant, and not offensive</li>\n        <li>By submitting content, you grant us a perpetual, royalty-free license to use it</li>\n        <li>We reserve the right to remove content that violates our policies</li>\n        <li>We are not responsible for user-generated content</li>\n    </ul>\n\n    <h3>13. Privacy and Data Protection</h3>\n    <p>Your use of our services is also governed by our Privacy Policy, which is incorporated into these Terms by reference. Please review our Privacy Policy to understand our data practices.</p>\n\n    <h3>14. Modifications to Terms</h3>\n    <p>We reserve the right to modify these Terms of Service at any time. Changes will be effective immediately upon posting. Your continued use of our services after changes constitutes acceptance of the modified terms.</p>\n\n    <h3>15. Termination</h3>\n    <p>We may terminate or suspend your access to our services at any time, without prior notice, for any reason, including breach of these Terms. Upon termination, your right to use our services will immediately cease.</p>\n\n    <h3>16. Governing Law and Dispute Resolution</h3>\n    <p>These Terms shall be governed by and construed in accordance with the laws of Jordan. Any disputes arising from these Terms or your use of our services shall be resolved through binding arbitration or in the competent courts of Jordan.</p>\n\n    <h3>17. Severability</h3>\n    <p>If any provision of these Terms is found to be invalid or unenforceable, the remaining provisions shall continue in full force and effect.</p>\n\n    <h3>18. Contact Information</h3>\n    <p>For questions about these Terms of Service, please contact us:</p>\n    <ul>\n        <li>Email: legal@velstore.com</li>\n        <li>Customer Support: Available 24/7</li>\n    </ul>\n\n    <p class=\"mt-4\"><strong>By using VelStore, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service.</strong></p>\n</div>',NULL,'2025-12-31 18:09:19','2025-12-31 18:09:19'),
(6,3,'ar','شروط الخدمة','<div class=\"terms-of-service-content\">\n    <p><em>آخر تحديث: 31 ديسمبر 2025</em></p>\n\n    <h2>شروط الخدمة</h2>\n    <p>مرحباً بك في VelStore، التي تديرها Match Systems. من خلال الوصول إلى موقعنا أو استخدام خدماتنا، فإنك توافق على الالتزام بشروط الخدمة هذه. يرجى قراءتها بعناية.</p>\n\n    <h3>1. قبول الشروط</h3>\n    <p>من خلال إنشاء حساب، أو تقديم طلب، أو استخدام أي جزء من خدماتنا، فإنك تقر بأنك قرأت وفهمت ووافقت على الالتزام بشروط الخدمة هذه وسياسة الخصوصية الخاصة بنا. إذا كنت لا توافق، فيرجى عدم استخدام خدماتنا.</p>\n\n    <h3>2. الأهلية</h3>\n    <p>يجب أن يكون عمرك 18 عاماً على الأقل لاستخدام خدماتنا. باستخدام VelStore، فإنك تقر وتضمن أنك تستوفي متطلبات العمر هذه ولديك الأهلية القانونية للدخول في عقود ملزمة.</p>\n\n    <h3>3. تسجيل الحساب</h3>\n    <ul>\n        <li>يجب عليك تقديم معلومات دقيقة وحالية وكاملة أثناء التسجيل</li>\n        <li>أنت مسؤول عن الحفاظ على سرية بيانات اعتماد حسابك</li>\n        <li>أنت مسؤول عن جميع الأنشطة التي تحدث تحت حسابك</li>\n        <li>يجب عليك إخطارنا فوراً بأي استخدام غير مصرح به لحسابك</li>\n        <li>نحتفظ بالحق في تعليق أو إنهاء الحسابات التي تنتهك هذه الشروط</li>\n    </ul>\n\n    <h3>4. المنتجات والأسعار</h3>\n    <ul>\n        <li>جميع المنتجات خاضعة للتوافر</li>\n        <li>نحتفظ بالحق في تحديد الكميات المشتراة لكل شخص أو طلب</li>\n        <li>الأسعار معروضة بالدولار الأمريكي وقابلة للتغيير دون إشعار</li>\n        <li>نسعى للدقة في أوصاف المنتجات والأسعار، لكن قد تحدث أخطاء</li>\n        <li>نحتفظ بالحق في رفض أو إلغاء الطلبات للمنتجات ذات أخطاء التسعير</li>\n        <li>العروض الترويجية تخضع لشروط وأحكام محددة</li>\n    </ul>\n\n    <h3>5. الطلبات والدفع</h3>\n    <ul>\n        <li>يشكل تقديم طلب عرضاً لشراء المنتجات</li>\n        <li>نحتفظ بالحق في قبول أو رفض طلبك</li>\n        <li>يجب استلام الدفع قبل معالجة الطلب</li>\n        <li>نقبل بطاقات الائتمان الرئيسية وطرق الدفع المعتمدة</li>\n        <li>تتم معالجة جميع المدفوعات بشكل آمن من خلال بوابات دفع موثوقة</li>\n        <li>أنت مسؤول عن أي ضرائب ورسوم قابلة للتطبيق</li>\n    </ul>\n\n    <h3>6. الشحن والتوصيل</h3>\n    <ul>\n        <li>نشحن حالياً إلى الأردن وفلسطين</li>\n        <li>أوقات التسليم تقديرية وغير مضمونة</li>\n        <li>يتم حساب تكاليف الشحن بناءً على الوجهة والوزن</li>\n        <li>تنتقل مخاطر الخسارة والملكية إليك عند التسليم للناقل</li>\n        <li>يجب عليك فحص الشحنات عند الاستلام والإبلاغ عن الأضرار في غضون 48 ساعة</li>\n        <li>التأخيرات الناتجة عن الجمارك أو الطقس أو مشاكل الناقل خارجة عن سيطرتنا</li>\n    </ul>\n\n    <h3>7. الإرجاع والاسترداد</h3>\n    <ul>\n        <li>نقدم سياسة إرجاع لمدة 30 يوماً لمعظم المنتجات</li>\n        <li>يجب أن تكون المنتجات غير مستخدمة، في عبوتها الأصلية، وفي حالة قابلة لإعادة البيع</li>\n        <li>بعض العناصر (العناية الشخصية، العناصر الحميمية، المنتجات المخصصة) غير قابلة للإرجاع</li>\n        <li>تكاليف شحن الإرجاع هي مسؤولية العميل ما لم يكن المنتج معيباً</li>\n        <li>يتم معالجة المبالغ المستردة في غضون 7-10 أيام عمل بعد استلام العناصر المرتجعة</li>\n        <li>رسوم الشحن الأصلية غير قابلة للاسترداد</li>\n    </ul>\n\n    <h3>8. الضمانات وإخلاء المسؤولية</h3>\n    <p>المنتجات مشمولة بضمانات الشركة المصنعة حيثما ينطبق ذلك. لا تقدم VelStore ضمانات إضافية تتجاوز تلك التي يقدمها المصنعون. إلى أقصى حد يسمح به القانون، يتم توفير خدماتنا \"كما هي\" دون ضمانات من أي نوع، صريحة أو ضمنية.</p>\n\n    <h3>9. تحديد المسؤولية</h3>\n    <p>إلى الحد الأقصى الذي يسمح به القانون، لن تكون VELSTORE و MATCH SYSTEMS مسؤولتين عن أي أضرار غير مباشرة أو عرضية أو خاصة أو تبعية أو عقابية، أو أي خسارة في الأرباح أو الإيرادات، سواء تم تكبدها مباشرة أو بشكل غير مباشر.</p>\n\n    <h3>10. الملكية الفكرية</h3>\n    <ul>\n        <li>جميع المحتويات على VelStore (الشعارات، النصوص، الصور، الرسومات) مملوكة لـ Match Systems أو مرخصيها</li>\n        <li>لا يجوز لك نسخ أو إعادة إنتاج أو توزيع أو إنشاء أعمال مشتقة دون إذن</li>\n        <li>صور المنتجات وأوصافها محمية بموجب قوانين حقوق النشر والعلامات التجارية</li>\n        <li>الاستخدام غير المصرح به لملكيتنا الفكرية قد يؤدي إلى اتخاذ إجراءات قانونية</li>\n    </ul>\n\n    <h3>11. سلوك المستخدم</h3>\n    <p>توافق على عدم:</p>\n    <ul>\n        <li>استخدام خدماتنا لأي غرض غير قانوني أو غير مصرح به</li>\n        <li>انتهاك أي قوانين محلية أو وطنية أو دولية</li>\n        <li>التعدي على حقوق الآخرين</li>\n        <li>إرسال فيروسات أو برامج ضارة أو رموز ضارة</li>\n        <li>محاولة الوصول غير المصرح به إلى أنظمتنا</li>\n        <li>التدخل في الأداء السليم لموقعنا</li>\n        <li>الانخراط في أنشطة احتيالية أو انتحال شخصية الآخرين</li>\n    </ul>\n\n    <h3>12. المراجعات ومحتوى المستخدم</h3>\n    <ul>\n        <li>يمكنك تقديم مراجعات وتقييمات للمنتجات</li>\n        <li>يجب أن يكون المحتوى صادقاً وذا صلة وغير مسيء</li>\n        <li>من خلال تقديم المحتوى، فإنك تمنحنا ترخيصاً دائماً وخالياً من حقوق الملكية لاستخدامه</li>\n        <li>نحتفظ بالحق في إزالة المحتوى الذي يخالف سياساتنا</li>\n        <li>نحن غير مسؤولين عن المحتوى الذي ينشئه المستخدمون</li>\n    </ul>\n\n    <h3>13. الخصوصية وحماية البيانات</h3>\n    <p>يخضع استخدامك لخدماتنا أيضاً لسياسة الخصوصية الخاصة بنا، والتي تم دمجها في هذه الشروط بالإشارة. يرجى مراجعة سياسة الخصوصية لفهم ممارسات البيانات لدينا.</p>\n\n    <h3>14. التعديلات على الشروط</h3>\n    <p>نحتفظ بالحق في تعديل شروط الخدمة هذه في أي وقت. ستكون التغييرات سارية فوراً عند النشر. يشكل استمرارك في استخدام خدماتنا بعد التغييرات قبولاً للشروط المعدلة.</p>\n\n    <h3>15. الإنهاء</h3>\n    <p>يجوز لنا إنهاء أو تعليق وصولك إلى خدماتنا في أي وقت، دون إشعار مسبق، لأي سبب، بما في ذلك انتهاك هذه الشروط. عند الإنهاء، سينتهي حقك في استخدام خدماتنا فوراً.</p>\n\n    <h3>16. القانون الحاكم وحل النزاعات</h3>\n    <p>تخضع هذه الشروط وتفسر وفقاً لقوانين الأردن. يتم حل أي نزاعات ناشئة عن هذه الشروط أو استخدامك لخدماتنا من خلال التحكيم الملزم أو في المحاكم المختصة في الأردن.</p>\n\n    <h3>17. الانفصال</h3>\n    <p>إذا تبين أن أي حكم من هذه الشروط غير صالح أو غير قابل للتنفيذ، فستستمر الأحكام المتبقية سارية المفعول بالكامل.</p>\n\n    <h3>18. معلومات الاتصال</h3>\n    <p>للأسئلة حول شروط الخدمة هذه، يرجى الاتصال بنا:</p>\n    <ul>\n        <li>البريد الإلكتروني: legal@velstore.com</li>\n        <li>دعم العملاء: متاح على مدار الساعة طوال أيام الأسبوع</li>\n    </ul>\n\n    <p class=\"mt-4\"><strong>باستخدام VelStore، فإنك تقر بأنك قرأت وفهمت ووافقت على الالتزام بشروط الخدمة هذه.</strong></p>\n</div>',NULL,'2025-12-31 18:09:19','2025-12-31 18:09:19');
/*!40000 ALTER TABLE `page_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES
(1,'about-us',1,'2025-12-31 18:09:18','2025-12-31 18:09:18'),
(2,'privacy-policy',1,'2025-12-31 18:09:18','2025-12-31 18:09:18'),
(3,'terms-of-service',1,'2025-12-31 18:09:19','2025-12-31 18:09:19');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

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

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_gateway_configs`
--

DROP TABLE IF EXISTS `payment_gateway_configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_gateway_configs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gateway_id` bigint(20) unsigned NOT NULL,
  `key_name` varchar(100) NOT NULL,
  `key_value` text NOT NULL,
  `is_encrypted` tinyint(1) NOT NULL DEFAULT 0,
  `environment` varchar(255) NOT NULL DEFAULT 'sandbox',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_gateway_configs_gateway_id_foreign` (`gateway_id`),
  CONSTRAINT `payment_gateway_configs_gateway_id_foreign` FOREIGN KEY (`gateway_id`) REFERENCES `payment_gateways` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_gateway_configs`
--

LOCK TABLES `payment_gateway_configs` WRITE;
/*!40000 ALTER TABLE `payment_gateway_configs` DISABLE KEYS */;
INSERT INTO `payment_gateway_configs` VALUES
(1,1,'client_id','your-paypal-client-id',1,'sandbox','2026-01-05 11:44:21','2026-01-05 11:44:21'),
(2,1,'client_secret','your-paypal-client-secret',1,'sandbox','2026-01-05 11:44:21','2026-01-05 11:44:21'),
(3,2,'public_key','your-stripe-public-key',0,'sandbox','2026-01-05 11:44:21','2026-01-05 11:44:21'),
(4,2,'secret_key','your-stripe-secret-key',1,'sandbox','2026-01-05 11:44:21','2026-01-05 11:44:21');
/*!40000 ALTER TABLE `payment_gateway_configs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_gateways`
--

DROP TABLE IF EXISTS `payment_gateways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_gateways` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_gateways_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_gateways`
--

LOCK TABLES `payment_gateways` WRITE;
/*!40000 ALTER TABLE `payment_gateways` DISABLE KEYS */;
INSERT INTO `payment_gateways` VALUES
(1,'PayPal','paypal','PayPal payment gateway',1,'2026-01-05 11:44:21','2026-01-05 11:44:21'),
(2,'Stripe','stripe','Stripe payment gateway',1,'2026-01-05 11:44:21','2026-01-05 11:44:21'),
(3,'Cash on Delivery','cod','Pay with cash when your order is delivered',1,'2026-01-05 11:44:21','2026-01-05 11:44:21');
/*!40000 ALTER TABLE `payment_gateways` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_methods` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `gateway_id` bigint(20) unsigned NOT NULL,
  `type` enum('card','bank','wallet','upi','paypal','crypto','cod','bnpl','other') NOT NULL DEFAULT 'card',
  `token` varchar(255) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_methods_user_id_foreign` (`user_id`),
  KEY `payment_methods_gateway_id_foreign` (`gateway_id`),
  CONSTRAINT `payment_methods_gateway_id_foreign` FOREIGN KEY (`gateway_id`) REFERENCES `payment_gateways` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payment_methods_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `gateway_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'USD',
  `status` enum('pending','processing','completed','failed','refunded') NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(255) DEFAULT NULL,
  `response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`response`)),
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_order_id_foreign` (`order_id`),
  KEY `payments_user_id_foreign` (`user_id`),
  KEY `payments_gateway_id_foreign` (`gateway_id`),
  CONSTRAINT `payments_gateway_id_foreign` FOREIGN KEY (`gateway_id`) REFERENCES `payment_gateways` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_attribute_values`
--

DROP TABLE IF EXISTS `product_attribute_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_attribute_values` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `attribute_value_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_attribute_values_product_id_foreign` (`product_id`),
  KEY `product_attribute_values_attribute_value_id_foreign` (`attribute_value_id`),
  CONSTRAINT `product_attribute_values_attribute_value_id_foreign` FOREIGN KEY (`attribute_value_id`) REFERENCES `attribute_values` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_attribute_values_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_attribute_values`
--

LOCK TABLES `product_attribute_values` WRITE;
/*!40000 ALTER TABLE `product_attribute_values` DISABLE KEYS */;
INSERT INTO `product_attribute_values` VALUES
(1,1,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(2,1,4,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(3,1,5,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(4,1,6,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(5,1,2,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(6,1,3,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(7,2,1,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(8,2,4,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(9,2,5,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(10,2,6,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(11,2,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(12,2,3,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(13,3,1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(14,3,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(15,3,5,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(16,3,6,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(17,3,2,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(18,3,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(19,4,1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(20,4,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(21,4,5,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(22,4,6,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(23,4,2,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(24,4,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(25,24,1,'2026-01-03 18:39:04','2026-01-03 18:39:04'),
(26,24,4,'2026-01-03 18:39:04','2026-01-03 18:39:04');
/*!40000 ALTER TABLE `product_attribute_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `type` enum('thumb','slide') NOT NULL DEFAULT 'thumb',
  `product_id` bigint(20) unsigned NOT NULL,
  `variant_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_index` (`product_id`),
  KEY `product_images_variant_id_index` (`variant_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_images_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES
(1,'T-Shirt-removebg-preview.png','products/T-Shirt-removebg-preview.png','thumb',1,NULL,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(2,'images-removebg-preview.png','products/images-removebg-preview.png','thumb',2,NULL,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(3,'images-1-removebg-preview-2.png','products/images-1-removebg-preview-2.png','thumb',3,NULL,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(4,'images-2-removebg-preview-1.png','products/images-2-removebg-preview-1.png','thumb',4,NULL,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(6,'wireless-bluetooth-headphones-thumb','https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80','thumb',6,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(7,'wireless-bluetooth-headphones-slide','https://images.unsplash.com/photo-1484704849700-f032a568e944?w=800&q=80','slide',6,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(8,'4k-smart-tv-55-inch-thumb','https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=800&q=80','thumb',7,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(9,'4k-smart-tv-55-inch-slide','https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=800&q=80','slide',7,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(10,'gaming-laptop-rtx-3060-thumb','https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=800&q=80','thumb',8,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(11,'gaming-laptop-rtx-3060-slide','https://images.unsplash.com/photo-1587202372634-32705e3bf49c?w=800&q=80','slide',8,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(12,'mechanical-gaming-keyboard-rgb-thumb','https://images.unsplash.com/photo-1595225476474-87563907a212?w=800&q=80','thumb',9,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(13,'mechanical-gaming-keyboard-rgb-slide','https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=800&q=80','slide',9,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(14,'wireless-gaming-mouse-thumb','https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800&q=80','thumb',10,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(15,'wireless-gaming-mouse-slide','https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=800&q=80','slide',10,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(16,'flagship-smartphone-pro-max-thumb','https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800&q=80','thumb',11,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(17,'flagship-smartphone-pro-max-slide','https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?w=800&q=80','slide',11,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(18,'mid-range-5g-smartphone-thumb','https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=800&q=80','thumb',12,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(19,'mid-range-5g-smartphone-slide','https://images.unsplash.com/photo-1591122947157-26bad3a117d2?w=800&q=80','slide',12,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(20,'budget-smartphone-dual-sim-thumb','https://images.unsplash.com/photo-1585060544812-6b45742d762f?w=800&q=80','thumb',13,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(21,'budget-smartphone-dual-sim-slide','https://images.unsplash.com/photo-1574944985070-8f3ebc6b79d2?w=800&q=80','slide',13,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(22,'mens-leather-jacket-black-thumb','https://images.unsplash.com/photo-1551028719-00167b16eac5?w=800&q=80','thumb',14,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(23,'mens-leather-jacket-black-slide','https://images.unsplash.com/photo-1520975954732-35dd22299614?w=800&q=80','slide',14,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(24,'womens-summer-dress-floral-thumb','https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=800&q=80','thumb',15,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(25,'womens-summer-dress-floral-slide','https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=800&q=80','slide',15,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(26,'mens-slim-fit-jeans-blue-thumb','https://images.unsplash.com/photo-1542272604-787c3835535d?w=800&q=80','thumb',16,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(27,'mens-slim-fit-jeans-blue-slide','https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=800&q=80','slide',16,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(28,'womens-designer-handbag-thumb','https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=800&q=80','thumb',17,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(29,'womens-designer-handbag-slide','https://images.unsplash.com/photo-1564422170194-896b89110ef8?w=800&q=80','slide',17,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(30,'mens-running-sneakers-thumb','https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&q=80','thumb',18,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(31,'mens-running-sneakers-slide','https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=800&q=80','slide',18,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(32,'basic-cotton-tshirt-white-thumb','https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80','thumb',19,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(33,'basic-cotton-tshirt-white-slide','https://images.unsplash.com/photo-1562157873-818bc0726f68?w=800&q=80','slide',19,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(34,'graphic-print-tshirt-black-thumb','https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=800&q=80','thumb',20,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(35,'graphic-print-tshirt-black-slide','https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=800&q=80','slide',20,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(36,'v-neck-tshirt-navy-blue-thumb','https://images.unsplash.com/photo-1503341504253-dff4815485f1?w=800&q=80','thumb',21,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(37,'v-neck-tshirt-navy-blue-slide','https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=800&q=80','slide',21,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(38,'polo-tshirt-red-thumb','https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?w=800&q=80','thumb',22,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(39,'polo-tshirt-red-slide','https://images.unsplash.com/photo-1581655353564-df123a1eb820?w=800&q=80','slide',22,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(40,'long-sleeve-tshirt-gray-thumb','https://images.unsplash.com/photo-1618517351616-38fb9c5210c6?w=800&q=80','thumb',23,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(41,'long-sleeve-tshirt-gray-slide','https://images.unsplash.com/photo-1620799140188-3b2a02fd9a77?w=800&q=80','slide',23,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(42,'portable-bluetooth-speaker-thumb','https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=800&q=80','thumb',24,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(43,'portable-bluetooth-speaker-slide','https://images.unsplash.com/photo-1545454675-3531b543be5d?w=800&q=80','slide',24,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(44,'smart-watch-fitness-tracker-thumb','https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=800&q=80','thumb',25,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(45,'smart-watch-fitness-tracker-slide','https://images.unsplash.com/photo-1523395243481-163f8f6155ab?w=800&q=80','slide',25,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(46,'wireless-earbuds-pro-thumb','https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=800&q=80','thumb',26,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(47,'wireless-earbuds-pro-slide','https://images.unsplash.com/photo-1606220838315-056192d5e927?w=800&q=80','slide',26,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(48,'tablet-10-inch-android-thumb','https://images.unsplash.com/photo-1561154464-82e9adf32764?w=800&q=80','thumb',27,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(49,'tablet-10-inch-android-slide','https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=800&q=80','slide',27,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(50,'portable-power-bank-20000mah-thumb','https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=800&q=80','thumb',28,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(51,'portable-power-bank-20000mah-slide','https://images.unsplash.com/photo-1625948515291-69613efd103f?w=800&q=80','slide',28,NULL,'2025-12-31 19:06:46','2025-12-31 19:06:46');
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_reviews`
--

DROP TABLE IF EXISTS `product_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `rating` int(10) unsigned NOT NULL DEFAULT 1,
  `review` text DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_reviews_customer_id_foreign` (`customer_id`),
  KEY `product_reviews_product_id_foreign` (`product_id`),
  CONSTRAINT `product_reviews_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_reviews`
--

LOCK TABLES `product_reviews` WRITE;
/*!40000 ALTER TABLE `product_reviews` DISABLE KEYS */;
INSERT INTO `product_reviews` VALUES
(1,1,28,5,'This product is amazing.',1,'2026-01-03 12:42:40','2026-01-03 12:42:40'),
(2,1,27,5,'This product is amazing.',1,'2026-01-03 18:00:57','2026-01-03 18:00:57');
/*!40000 ALTER TABLE `product_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_translations`
--

DROP TABLE IF EXISTS `product_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `language_code` varchar(5) NOT NULL DEFAULT 'en',
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_translations_product_id_language_code_unique` (`product_id`,`language_code`),
  KEY `product_translations_product_id_index` (`product_id`),
  CONSTRAINT `product_translations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_translations`
--

LOCK TABLES `product_translations` WRITE;
/*!40000 ALTER TABLE `product_translations` DISABLE KEYS */;
INSERT INTO `product_translations` VALUES
(1,1,'en','Cool T-Shirt','Trendy T-Shirt available in multiple sizes and colors.',NULL,NULL,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(2,1,'de','Cooles T-Shirt','Trendiges T-Shirt in verschiedenen Größen und Farben erhältlich.',NULL,NULL,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(3,1,'es','Camiseta genial','Camiseta moderna disponible en varios tamaños y colores.',NULL,NULL,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(4,1,'fr','Cool T-Shirt','Trendy T-Shirt available in multiple sizes and colors.',NULL,NULL,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(5,2,'en','Sport Shoes','Comfortable sport shoes for daily use.',NULL,NULL,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(6,2,'de','Sportschuhe','Bequeme Sportschuhe für den täglichen Gebrauch.',NULL,NULL,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(7,2,'es','Zapatillas deportivas','Zapatillas deportivas cómodas para uso diario.',NULL,NULL,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(8,2,'fr','Sport Shoes','Comfortable sport shoes for daily use.',NULL,NULL,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(9,3,'en','Wireless Headphones','Noise-cancelling wireless headphones with long battery life.',NULL,NULL,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(10,3,'de','Kabellose Kopfhörer','Kabellose Kopfhörer mit Geräuschunterdrückung und langer Akkulaufzeit.',NULL,NULL,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(11,3,'es','Auriculares inalámbricos','Auriculares inalámbricos con cancelación de ruido y batería de larga duración.',NULL,NULL,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(12,3,'fr','Wireless Headphones','Noise-cancelling wireless headphones with long battery life.',NULL,NULL,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(13,4,'en','Travel Backpack','Durable backpack for travel and outdoor activities.',NULL,NULL,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(14,4,'de','Reiserucksack','Robuster Rucksack für Reisen und Outdoor-Aktivitäten.',NULL,NULL,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(15,4,'es','Mochila de viaje','Mochila duradera para viajes y actividades al aire libre.',NULL,NULL,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(16,4,'fr','Travel Backpack','Durable backpack for travel and outdoor activities.',NULL,NULL,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(18,1,'ar','تي شيرت رائع','تي شيرت عصري متوفر بعدة أحجام وألوان.',NULL,NULL,'2025-12-28 20:57:44','2025-12-28 20:57:44'),
(19,2,'ar','أحذية رياضية','أحذية رياضية مريحة للاستخدام اليومي.',NULL,NULL,'2025-12-28 20:57:44','2025-12-28 20:57:44'),
(20,3,'ar','سماعات لاسلكية','سماعات لاسلكية مع ميزة إلغاء الضوضاء وبطارية طويلة الأمد.',NULL,NULL,'2025-12-28 20:57:44','2025-12-28 20:57:44'),
(21,4,'ar','حقيبة ظهر للسفر','حقيبة ظهر متينة للسفر والأنشطة الخارجية.',NULL,NULL,'2025-12-28 20:57:44','2025-12-28 20:57:44'),
(22,6,'en','Wireless Bluetooth Headphones','Premium wireless headphones with active noise cancellation, 30-hour battery life, and crystal-clear sound quality. Perfect for music lovers and professionals.','Premium wireless headphones with ANC','headphones, wireless, bluetooth, audio','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(23,6,'ar','سماعات رأس بلوتوث لاسلكية','سماعات لاسلكية متميزة مع إلغاء الضوضاء النشط، وعمر بطارية 30 ساعة، وجودة صوت واضحة تمامًا. مثالية لمحبي الموسيقى والمحترفين.','سماعات لاسلكية متميزة مع إلغاء الضوضاء','سماعات، لاسلكي، بلوتوث، صوت','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(24,7,'en','55\" 4K Ultra HD Smart TV','Experience stunning 4K resolution with HDR support, built-in streaming apps, and voice control. Transform your living room into a home theater.','55\" 4K Smart TV with HDR','tv, 4k, smart tv, electronics','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(25,7,'ar','تلفزيون ذكي 55 بوصة بدقة 4K','استمتع بدقة 4K المذهلة مع دعم HDR وتطبيقات البث المدمجة والتحكم الصوتي. حوّل غرفة معيشتك إلى مسرح منزلي.','تلفزيون ذكي 55 بوصة بدقة 4K مع HDR','تلفزيون، 4k، تلفزيون ذكي، إلكترونيات','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(26,8,'en','Gaming Laptop RTX 3060','High-performance gaming laptop with NVIDIA RTX 3060, Intel i7 processor, 16GB RAM, and 512GB SSD. Dominate every game with stunning graphics.','Gaming laptop with RTX 3060 graphics','laptop, gaming, rtx, computer','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(27,8,'ar','لابتوب ألعاب RTX 3060','لابتوب ألعاب عالي الأداء مع NVIDIA RTX 3060 ومعالج Intel i7 وذاكرة 16 جيجابايت وقرص SSD 512 جيجابايت. سيطر على كل لعبة برسومات مذهلة.','لابتوب ألعاب مع بطاقة RTX 3060','لابتوب، ألعاب، rtx، كمبيوتر','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(28,9,'en','Mechanical Gaming Keyboard RGB','Professional mechanical keyboard with customizable RGB lighting, tactile switches, and programmable keys. Built for gamers and typists who demand precision.','RGB mechanical keyboard for gaming','keyboard, gaming, mechanical, rgb','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(29,9,'ar','لوحة مفاتيح ألعاب ميكانيكية RGB','لوحة مفاتيح ميكانيكية احترافية مع إضاءة RGB قابلة للتخصيص ومفاتيح لمسية ومفاتيح قابلة للبرمجة. مصممة للاعبين والكتاب الذين يطلبون الدقة.','لوحة مفاتيح ميكانيكية RGB للألعاب','لوحة مفاتيح، ألعاب، ميكانيكية، rgb','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(30,10,'en','Wireless Gaming Mouse','Ultra-responsive wireless gaming mouse with 16000 DPI sensor, customizable buttons, and 80-hour battery life. Zero lag, maximum performance.','Wireless gaming mouse 16000 DPI','mouse, gaming, wireless, accessories','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(31,10,'ar','ماوس ألعاب لاسلكي','ماوس ألعاب لاسلكي فائق الاستجابة مع مستشعر 16000 DPI وأزرار قابلة للتخصيص وعمر بطارية 80 ساعة. بدون تأخير، أقصى أداء.','ماوس ألعاب لاسلكي 16000 DPI','ماوس، ألعاب، لاسلكي، إكسسوارات','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(32,11,'en','Flagship Smartphone Pro Max','Latest flagship smartphone with 6.7\" AMOLED display, triple camera system, 5G connectivity, and all-day battery life. The ultimate smartphone experience.','Flagship phone with triple camera','smartphone, 5g, camera, flagship','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(33,11,'ar','هاتف ذكي رائد برو ماكس','أحدث هاتف ذكي رائد بشاشة AMOLED 6.7 بوصة ونظام كاميرا ثلاثي واتصال 5G وبطارية تدوم طوال اليوم. تجربة الهاتف الذكي المثالية.','هاتف رائد مع كاميرا ثلاثية','هاتف ذكي، 5g، كاميرا، رائد','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(34,12,'en','Mid-Range 5G Smartphone','Affordable 5G smartphone with excellent camera, fast processor, and long battery life. Premium features without the premium price.','Affordable 5G smartphone','smartphone, 5g, mid-range, affordable','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(35,12,'ar','هاتف ذكي 5G متوسط المدى','هاتف ذكي 5G بأسعار معقولة مع كاميرا ممتازة ومعالج سريع وعمر بطارية طويل. ميزات متميزة بدون سعر متميز.','هاتف ذكي 5G بأسعار معقولة','هاتف ذكي، 5g، متوسط المدى، معقول','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(36,13,'en','Budget Smartphone Dual SIM','Great value smartphone with dual SIM support, HD+ display, and reliable performance for everyday tasks. Perfect for your first smartphone.','Budget dual SIM smartphone','smartphone, budget, dual sim, affordable','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(37,13,'ar','هاتف ذكي اقتصادي بشريحتين','هاتف ذكي بقيمة رائعة مع دعم شريحتين وشاشة HD+ وأداء موثوق للمهام اليومية. مثالي لهاتفك الذكي الأول.','هاتف ذكي اقتصادي بشريحتين','هاتف ذكي، اقتصادي، شريحتين، معقول','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(38,14,'en','Men\'s Leather Jacket - Black','Classic genuine leather jacket with modern fit. Soft, durable, and stylish. Perfect for any season and occasion.','Genuine leather jacket for men','jacket, leather, mens fashion, outerwear','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(39,14,'ar','سترة جلدية رجالية - أسود','سترة جلدية أصلية كلاسيكية بقصة عصرية. ناعمة ومتينة وأنيقة. مثالية لأي موسم ومناسبة.','سترة جلدية أصلية للرجال','سترة، جلد، أزياء رجالية، ملابس خارجية','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(40,15,'en','Women\'s Summer Dress - Floral','Beautiful floral print summer dress in lightweight, breathable fabric. Comfortable and elegant for warm weather.','Floral summer dress for women','dress, summer, floral, womens fashion','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(41,15,'ar','فستان صيفي نسائي - زهور','فستان صيفي جميل بطبعة زهور في قماش خفيف الوزن وقابل للتنفس. مريح وأنيق للطقس الدافئ.','فستان صيفي بطبعة زهور للنساء','فستان، صيف، زهور، أزياء نسائية','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(42,16,'en','Men\'s Slim Fit Jeans - Blue','Classic slim fit jeans in premium denim. Comfortable stretch fabric with modern styling. A wardrobe essential.','Slim fit denim jeans for men','jeans, denim, mens fashion, pants','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(43,16,'ar','جينز رجالي ضيق - أزرق','جينز ضيق كلاسيكي في الدنيم الفاخر. قماش مرن ومريح مع تصميم عصري. ضروري لخزانة الملابس.','جينز دنيم ضيق للرجال','جينز، دنيم، أزياء رجالية، بناطيل','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(44,17,'en','Women\'s Designer Handbag','Elegant designer handbag in premium leather with gold hardware. Spacious interior with multiple compartments. Luxury meets functionality.','Premium designer leather handbag','handbag, designer, leather, accessories','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(45,17,'ar','حقيبة يد نسائية من المصمم','حقيبة يد أنيقة من المصمم في الجلد الفاخر مع إكسسوارات ذهبية. داخلية واسعة مع أقسام متعددة. الفخامة تلتقي بالوظيفة.','حقيبة يد جلدية فاخرة من المصمم','حقيبة يد، مصمم، جلد، إكسسوارات','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(46,18,'en','Men\'s Running Sneakers','High-performance running shoes with advanced cushioning and breathable mesh upper. Lightweight design for maximum comfort and speed.','Performance running shoes','sneakers, running, athletic, footwear','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(47,18,'ar','حذاء رياضي رجالي للجري','أحذية جري عالية الأداء مع توسيد متقدم وجزء علوي شبكي قابل للتنفس. تصميم خفيف الوزن لأقصى راحة وسرعة.','أحذية جري عالية الأداء','حذاء رياضي، جري، رياضي، أحذية','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(48,19,'en','Basic Cotton T-Shirt - White','Essential 100% cotton t-shirt in classic white. Soft, comfortable, and versatile. Perfect for layering or wearing on its own.','100% cotton basic white tee','t-shirt, cotton, basic, casual','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(49,19,'ar','تيشرت قطني أساسي - أبيض','تيشرت قطني 100٪ أساسي باللون الأبيض الكلاسيكي. ناعم ومريح ومتعدد الاستخدامات. مثالي للطبقات أو ارتدائه بمفرده.','تيشرت أبيض أساسي قطني 100٪','تيشرت، قطن، أساسي، كاجوال','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(50,20,'en','Graphic Print T-Shirt - Black','Stylish graphic print t-shirt with unique design. Made from soft cotton blend. Express yourself with bold graphics.','Graphic print cotton blend tee','t-shirt, graphic, print, streetwear','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(51,20,'ar','تيشرت بطبعة رسومية - أسود','تيشرت أنيق بطبعة رسومية بتصميم فريد. مصنوع من مزيج القطن الناعم. عبر عن نفسك برسومات جريئة.','تيشرت بطبعة رسومية من مزيج القطن','تيشرت، رسومي، طباعة، ستريت وير','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(52,21,'en','V-Neck T-Shirt - Navy Blue','Classic v-neck t-shirt in navy blue. Premium cotton with a flattering fit. A wardrobe staple for any occasion.','Navy blue v-neck cotton tee','t-shirt, v-neck, cotton, casual','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(53,21,'ar','تيشرت رقبة V - أزرق داكن','تيشرت كلاسيكي برقبة V باللون الأزرق الداكن. قطن فاخر بقصة جذابة. عنصر أساسي في خزانة الملابس لأي مناسبة.','تيشرت قطني برقبة V أزرق داكن','تيشرت، رقبة V، قطن، كاجوال','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(54,22,'en','Polo T-Shirt - Red','Smart casual polo t-shirt in vibrant red. Breathable pique fabric with classic collar. Perfect for semi-formal occasions.','Red polo shirt with collar','t-shirt, polo, smart casual, collared','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(55,22,'ar','تيشرت بولو - أحمر','تيشرت بولو كاجوال ذكي باللون الأحمر الحيوي. قماش بيكيه قابل للتنفس مع ياقة كلاسيكية. مثالي للمناسبات شبه الرسمية.','قميص بولو أحمر بياقة','تيشرت، بولو، كاجوال ذكي، بياقة','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(56,23,'en','Long Sleeve T-Shirt - Gray','Comfortable long sleeve t-shirt in heather gray. Perfect for layering or wearing alone. Soft fabric that gets better with every wash.','Gray long sleeve cotton tee','t-shirt, long sleeve, gray, layering','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(57,23,'ar','تيشرت بأكمام طويلة - رمادي','تيشرت مريح بأكمام طويلة باللون الرمادي الداكن. مثالي للطبقات أو ارتدائه بمفرده. قماش ناعم يتحسن مع كل غسلة.','تيشرت قطني رمادي بأكمام طويلة','تيشرت، أكمام طويلة، رمادي، طبقات','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(58,24,'en','Portable Bluetooth Speaker','<p>Waterproof portable speaker with 360° sound, 20-hour battery life, and deep bass. Perfect for outdoor adventures and parties.</p>',NULL,NULL,'2025-12-31 19:06:46','2026-01-03 18:39:04'),
(59,24,'ar','سماعة بلوتوث محمولة','<p>سماعة محمولة مقاومة للماء مع صوت 360 درجة وعمر بطارية 20 ساعة وصوت جهير عميق. مثالية للمغامرات الخارجية والحفلات.</p>',NULL,NULL,'2025-12-31 19:06:46','2026-01-03 18:39:04'),
(60,25,'en','Smart Watch Fitness Tracker','Advanced fitness smartwatch with heart rate monitor, GPS, sleep tracking, and 7-day battery life. Your health companion on your wrist.','Fitness smartwatch with GPS','smartwatch, fitness, tracker, wearable','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(61,25,'ar','ساعة ذكية لتتبع اللياقة البدنية','ساعة ذكية للياقة البدنية متقدمة مع مراقب معدل ضربات القلب و GPS وتتبع النوم وعمر بطارية 7 أيام. رفيق صحتك على معصمك.','ساعة ذكية للياقة مع GPS','ساعة ذكية، لياقة، تتبع، يمكن ارتداؤها','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(62,26,'en','Wireless Earbuds Pro','Premium wireless earbuds with active noise cancellation, transparency mode, and 24-hour battery with charging case. Exceptional sound quality.','Premium earbuds with ANC','earbuds, wireless, audio, anc','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(63,26,'ar','سماعات أذن لاسلكية برو','سماعات أذن لاسلكية متميزة مع إلغاء الضوضاء النشط ووضع الشفافية وبطارية 24 ساعة مع علبة الشحن. جودة صوت استثنائية.','سماعات أذن متميزة مع إلغاء الضوضاء','سماعات أذن، لاسلكي، صوت، إلغاء ضوضاء','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(64,27,'en','10\" Android Tablet','Powerful 10-inch Android tablet with high-resolution display, 6GB RAM, and 128GB storage. Perfect for entertainment and productivity.','10\" tablet with 128GB storage','tablet, android, electronics, productivity','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(65,27,'ar','تابلت أندرويد 10 بوصة','تابلت أندرويد قوي 10 بوصة بشاشة عالية الدقة و 6 جيجابايت رام و 128 جيجابايت تخزين. مثالي للترفيه والإنتاجية.','تابلت 10 بوصة بسعة 128 جيجابايت','تابلت، أندرويد، إلكترونيات، إنتاجية','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(66,28,'en','Portable Power Bank 20000mAh','High-capacity power bank with 20000mAh battery, dual USB ports, and fast charging. Never run out of battery again.','20000mAh fast charging power bank','power bank, charger, portable, battery','2025-12-31 19:06:46','2025-12-31 19:06:46'),
(67,28,'ar','بنك طاقة محمول 20000 ملي أمبير','بنك طاقة عالي السعة مع بطارية 20000 ملي أمبير ومنفذي USB والشحن السريع. لا تنفد بطاريتك أبدًا مرة أخرى.','بنك طاقة شحن سريع 20000 ملي أمبير','بنك طاقة، شاحن، محمول، بطارية','2025-12-31 19:06:46','2025-12-31 19:06:46');
/*!40000 ALTER TABLE `product_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_variant_attribute_values`
--

DROP TABLE IF EXISTS `product_variant_attribute_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_variant_attribute_values` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_variant_id` bigint(20) unsigned NOT NULL,
  `attribute_value_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_variant_attribute_values_product_variant_id_foreign` (`product_variant_id`),
  KEY `product_variant_attribute_values_attribute_value_id_foreign` (`attribute_value_id`),
  KEY `product_variant_attribute_values_product_id_foreign` (`product_id`),
  CONSTRAINT `product_variant_attribute_values_attribute_value_id_foreign` FOREIGN KEY (`attribute_value_id`) REFERENCES `attribute_values` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_variant_attribute_values_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_variant_attribute_values_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_variant_attribute_values`
--

LOCK TABLES `product_variant_attribute_values` WRITE;
/*!40000 ALTER TABLE `product_variant_attribute_values` DISABLE KEYS */;
INSERT INTO `product_variant_attribute_values` VALUES
(1,1,1,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(2,1,4,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(3,2,1,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(4,2,5,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(5,3,1,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(6,3,6,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(7,4,2,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(8,4,4,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(9,5,2,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(10,5,5,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(11,6,2,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(12,6,6,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(13,7,3,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(14,7,4,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(15,8,3,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(16,8,5,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(17,9,3,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(18,9,6,1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(19,10,1,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(20,10,4,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(21,11,1,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(22,11,5,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(23,12,1,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(24,12,6,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(25,13,2,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(26,13,4,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(27,14,2,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(28,14,5,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(29,15,2,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(30,15,6,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(31,16,3,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(32,16,4,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(33,17,3,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(34,17,5,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(35,18,3,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(36,18,6,2,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(37,19,1,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(38,19,4,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(39,20,1,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(40,20,5,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(41,21,1,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(42,21,6,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(43,22,2,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(44,22,4,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(45,23,2,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(46,23,5,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(47,24,2,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(48,24,6,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(49,25,3,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(50,25,4,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(51,26,3,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(52,26,5,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(53,27,3,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(54,27,6,3,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(55,28,1,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(56,28,4,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(57,29,1,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(58,29,5,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(59,30,1,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(60,30,6,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(61,31,2,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(62,31,4,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(63,32,2,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(64,32,5,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(65,33,2,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(66,33,6,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(67,34,3,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(68,34,4,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(69,35,3,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(70,35,5,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(71,36,3,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(72,36,6,4,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(85,67,1,24,'2026-01-03 18:39:53','2026-01-03 18:39:53'),
(86,67,4,24,'2026-01-03 18:39:53','2026-01-03 18:39:53');
/*!40000 ALTER TABLE `product_variant_attribute_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_variant_translations`
--

DROP TABLE IF EXISTS `product_variant_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_variant_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_variant_id` bigint(20) unsigned NOT NULL,
  `language_code` varchar(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pv_translations_lang_unique` (`product_variant_id`,`language_code`),
  KEY `product_variant_translations_language_code_index` (`language_code`),
  CONSTRAINT `product_variant_translations_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_variant_translations`
--

LOCK TABLES `product_variant_translations` WRITE;
/*!40000 ALTER TABLE `product_variant_translations` DISABLE KEYS */;
INSERT INTO `product_variant_translations` VALUES
(1,1,'en','Small - Red','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(2,1,'de','Small - Red','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(3,1,'es','Small - Red','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(4,1,'fr','Small - Red','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(5,2,'en','Small - Blue','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(6,2,'de','Small - Blue','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(7,2,'es','Small - Blue','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(8,2,'fr','Small - Blue','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(9,3,'en','Small - Black','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(10,3,'de','Small - Black','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(11,3,'es','Small - Black','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(12,3,'fr','Small - Black','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(13,4,'en','Medium - Red','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(14,4,'de','Medium - Red','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(15,4,'es','Medium - Red','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(16,4,'fr','Medium - Red','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(17,5,'en','Medium - Blue','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(18,5,'de','Medium - Blue','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(19,5,'es','Medium - Blue','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(20,5,'fr','Medium - Blue','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(21,6,'en','Medium - Black','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(22,6,'de','Medium - Black','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(23,6,'es','Medium - Black','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(24,6,'fr','Medium - Black','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(25,7,'en','Large - Red','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(26,7,'de','Large - Red','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(27,7,'es','Large - Red','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(28,7,'fr','Large - Red','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(29,8,'en','Large - Blue','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(30,8,'de','Large - Blue','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(31,8,'es','Large - Blue','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(32,8,'fr','Large - Blue','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(33,9,'en','Large - Black','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(34,9,'de','Large - Black','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(35,9,'es','Large - Black','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(36,9,'fr','Large - Black','2025-12-28 20:16:44','2025-12-28 20:16:44'),
(37,10,'en','Small - Red','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(38,10,'de','Small - Red','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(39,10,'es','Small - Red','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(40,10,'fr','Small - Red','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(41,11,'en','Small - Blue','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(42,11,'de','Small - Blue','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(43,11,'es','Small - Blue','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(44,11,'fr','Small - Blue','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(45,12,'en','Small - Black','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(46,12,'de','Small - Black','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(47,12,'es','Small - Black','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(48,12,'fr','Small - Black','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(49,13,'en','Medium - Red','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(50,13,'de','Medium - Red','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(51,13,'es','Medium - Red','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(52,13,'fr','Medium - Red','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(53,14,'en','Medium - Blue','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(54,14,'de','Medium - Blue','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(55,14,'es','Medium - Blue','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(56,14,'fr','Medium - Blue','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(57,15,'en','Medium - Black','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(58,15,'de','Medium - Black','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(59,15,'es','Medium - Black','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(60,15,'fr','Medium - Black','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(61,16,'en','Large - Red','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(62,16,'de','Large - Red','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(63,16,'es','Large - Red','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(64,16,'fr','Large - Red','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(65,17,'en','Large - Blue','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(66,17,'de','Large - Blue','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(67,17,'es','Large - Blue','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(68,17,'fr','Large - Blue','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(69,18,'en','Large - Black','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(70,18,'de','Large - Black','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(71,18,'es','Large - Black','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(72,18,'fr','Large - Black','2025-12-28 20:16:45','2025-12-28 20:16:45'),
(73,19,'en','Small - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(74,19,'de','Small - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(75,19,'es','Small - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(76,19,'fr','Small - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(77,20,'en','Small - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(78,20,'de','Small - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(79,20,'es','Small - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(80,20,'fr','Small - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(81,21,'en','Small - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(82,21,'de','Small - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(83,21,'es','Small - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(84,21,'fr','Small - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(85,22,'en','Medium - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(86,22,'de','Medium - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(87,22,'es','Medium - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(88,22,'fr','Medium - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(89,23,'en','Medium - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(90,23,'de','Medium - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(91,23,'es','Medium - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(92,23,'fr','Medium - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(93,24,'en','Medium - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(94,24,'de','Medium - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(95,24,'es','Medium - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(96,24,'fr','Medium - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(97,25,'en','Large - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(98,25,'de','Large - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(99,25,'es','Large - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(100,25,'fr','Large - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(101,26,'en','Large - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(102,26,'de','Large - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(103,26,'es','Large - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(104,26,'fr','Large - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(105,27,'en','Large - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(106,27,'de','Large - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(107,27,'es','Large - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(108,27,'fr','Large - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(109,28,'en','Small - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(110,28,'de','Small - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(111,28,'es','Small - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(112,28,'fr','Small - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(113,29,'en','Small - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(114,29,'de','Small - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(115,29,'es','Small - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(116,29,'fr','Small - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(117,30,'en','Small - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(118,30,'de','Small - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(119,30,'es','Small - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(120,30,'fr','Small - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(121,31,'en','Medium - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(122,31,'de','Medium - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(123,31,'es','Medium - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(124,31,'fr','Medium - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(125,32,'en','Medium - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(126,32,'de','Medium - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(127,32,'es','Medium - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(128,32,'fr','Medium - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(129,33,'en','Medium - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(130,33,'de','Medium - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(131,33,'es','Medium - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(132,33,'fr','Medium - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(133,34,'en','Large - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(134,34,'de','Large - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(135,34,'es','Large - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(136,34,'fr','Large - Red','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(137,35,'en','Large - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(138,35,'de','Large - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(139,35,'es','Large - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(140,35,'fr','Large - Blue','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(141,36,'en','Large - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(142,36,'de','Large - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(143,36,'es','Large - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(144,36,'fr','Large - Black','2025-12-28 20:16:46','2025-12-28 20:16:46'),
(171,67,'en','Portable Bluetooth Speaker','2026-01-03 18:39:53','2026-01-03 18:39:53');
/*!40000 ALTER TABLE `product_variant_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_variants`
--

DROP TABLE IF EXISTS `product_variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_variants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `variant_slug` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `SKU` varchar(255) NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `dimensions` varchar(255) DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_variants_variant_slug_unique` (`variant_slug`),
  UNIQUE KEY `product_variants_sku_unique` (`SKU`),
  KEY `product_variants_product_id_foreign` (`product_id`),
  CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_variants`
--

LOCK TABLES `product_variants` WRITE;
/*!40000 ALTER TABLE `product_variants` DISABLE KEYS */;
INSERT INTO `product_variants` VALUES
(1,1,'cool-t-shirt-small-red-6951ac4caf35e',26.00,23.00,66,'SRe239',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(2,1,'cool-t-shirt-small-blue-6951ac4cb606e',41.00,14.00,85,'SBl982',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(3,1,'cool-t-shirt-small-black-6951ac4cb836d',58.00,17.00,82,'SBl670',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(4,1,'cool-t-shirt-medium-red-6951ac4cb939e',29.00,21.00,110,'MRe583',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(5,1,'cool-t-shirt-medium-blue-6951ac4cbbb80',27.00,15.00,151,'MBl285',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(6,1,'cool-t-shirt-medium-black-6951ac4cbc467',46.00,42.00,94,'MBl140',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(7,1,'cool-t-shirt-large-red-6951ac4cbda1d',31.00,10.00,139,'LRe418',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(8,1,'cool-t-shirt-large-blue-6951ac4cbf2f5',24.00,14.00,177,'LBl497',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(9,1,'cool-t-shirt-large-black-6951ac4cbfd4e',59.00,17.00,65,'LBl578',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(10,2,'sport-shoes-small-red-6951ac4d3baed',43.00,31.00,82,'SRe805',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(11,2,'sport-shoes-small-blue-6951ac4d3f97b',29.00,11.00,61,'SBl860',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(12,2,'sport-shoes-small-black-6951ac4d41b86',57.00,47.00,54,'SBl391',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(13,2,'sport-shoes-medium-red-6951ac4d456f0',30.00,12.00,179,'MRe150',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(14,2,'sport-shoes-medium-blue-6951ac4d46db3',33.00,10.00,142,'MBl413',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(15,2,'sport-shoes-medium-black-6951ac4d48d63',47.00,34.00,159,'MBl174',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(16,2,'sport-shoes-large-red-6951ac4d4a841',33.00,31.00,192,'LRe153',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(17,2,'sport-shoes-large-blue-6951ac4d4de15',38.00,28.00,113,'LBl262',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(18,2,'sport-shoes-large-black-6951ac4d535cf',56.00,38.00,191,'LBl964',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(19,3,'wireless-headphones-small-red-6951ac4e0e403',53.00,27.00,102,'SRe719',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(20,3,'wireless-headphones-small-blue-6951ac4e11b31',56.00,24.00,138,'SBl745',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(21,3,'wireless-headphones-small-black-6951ac4e16697',53.00,23.00,55,'SBl940',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(22,3,'wireless-headphones-medium-red-6951ac4e1867f',48.00,36.00,179,'MRe334',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(23,3,'wireless-headphones-medium-blue-6951ac4e1b47e',47.00,14.00,181,'MBl965',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(24,3,'wireless-headphones-medium-black-6951ac4e1d983',40.00,27.00,150,'MBl242',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(25,3,'wireless-headphones-large-red-6951ac4e227b9',41.00,21.00,66,'LRe334',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(26,3,'wireless-headphones-large-blue-6951ac4e253e3',40.00,30.00,163,'LBl426',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(27,3,'wireless-headphones-large-black-6951ac4e26ebb',42.00,13.00,68,'LBl379',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(28,4,'travel-backpack-small-red-6951ac4e7d607',47.00,38.00,76,'SRe798',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(29,4,'travel-backpack-small-blue-6951ac4e803cd',20.00,17.00,142,'SBl164',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(30,4,'travel-backpack-small-black-6951ac4e85fea',54.00,24.00,93,'SBl179',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(31,4,'travel-backpack-medium-red-6951ac4e8869b',33.00,28.00,182,'MRe303',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(32,4,'travel-backpack-medium-blue-6951ac4e8dece',24.00,13.00,132,'MBl962',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(33,4,'travel-backpack-medium-black-6951ac4e92ff8',50.00,39.00,109,'MBl478',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(34,4,'travel-backpack-large-red-6951ac4e96c3a',39.00,13.00,105,'LRe231',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(35,4,'travel-backpack-large-blue-6951ac4e98d74',49.00,22.00,106,'LBl448',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(36,4,'travel-backpack-large-black-6951ac4e9eff1',55.00,37.00,112,'LBl244',NULL,0.50,'10x10x2 cm',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(43,6,'wireless-bluetooth-headphones-variant-EQ46',299.99,249.99,50,'WBH-001-BLK',NULL,0.25,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(44,7,'4k-smart-tv-55-inch-variant-MZBG',799.99,699.99,25,'TV-55-4K-001',NULL,15.50,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(45,8,'gaming-laptop-rtx-3060-variant-5mDn',1499.99,1299.99,15,'LAP-GAM-RTX3060',NULL,2.50,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(46,9,'mechanical-gaming-keyboard-rgb-variant-3BvI',129.99,99.99,40,'KB-MECH-RGB-001',NULL,1.20,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(47,10,'wireless-gaming-mouse-variant-Hz9x',89.99,69.99,60,'MOUSE-WL-GAM-001',NULL,0.15,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(48,11,'flagship-smartphone-pro-max-variant-lK5K',1199.99,1099.99,30,'PHONE-FLAGSHIP-001',NULL,0.22,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(49,12,'mid-range-5g-smartphone-variant-Uqx2',499.99,449.99,50,'PHONE-MID-5G-001',NULL,0.19,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(50,13,'budget-smartphone-dual-sim-variant-bwU8',199.99,179.99,70,'PHONE-BUDGET-DS-001',NULL,0.17,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(51,14,'mens-leather-jacket-black-variant-9t5N',349.99,279.99,35,'JACKET-LEAT-MEN-BLK',NULL,1.50,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(52,15,'womens-summer-dress-floral-variant-nDHt',79.99,59.99,45,'DRESS-SUM-WOM-FLR',NULL,0.30,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(53,16,'mens-slim-fit-jeans-blue-variant-4crf',89.99,69.99,55,'JEANS-SLIM-MEN-BLU',NULL,0.60,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(54,17,'womens-designer-handbag-variant-2zy0',449.99,379.99,20,'BAG-DES-WOM-001',NULL,0.80,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(55,18,'mens-running-sneakers-variant-sFpV',149.99,119.99,40,'SHOE-RUN-MEN-001',NULL,0.50,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(56,19,'basic-cotton-tshirt-white-variant-Vrjj',19.99,14.99,100,'TSHIRT-COT-WHT-001',NULL,0.20,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(57,20,'graphic-print-tshirt-black-variant-Rnht',29.99,24.99,75,'TSHIRT-GRA-BLK-001',NULL,0.22,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(58,21,'v-neck-tshirt-navy-blue-variant-uciR',24.99,19.99,85,'TSHIRT-VNECK-NAV-001',NULL,0.21,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(59,22,'polo-tshirt-red-variant-LW30',39.99,34.99,50,'TSHIRT-POLO-RED-001',NULL,0.25,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(60,23,'long-sleeve-tshirt-gray-variant-GQdK',34.99,29.99,60,'TSHIRT-LS-GRAY-001',NULL,0.28,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(62,25,'smart-watch-fitness-tracker-variant-x8vh',249.99,199.99,30,'WATCH-SMART-FIT-001',NULL,0.08,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(63,26,'wireless-earbuds-pro-variant-UqKR',199.99,169.99,55,'EARB-WL-PRO-001',NULL,0.05,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(64,27,'tablet-10-inch-android-variant-oBy3',349.99,299.99,35,'TAB-AND-10-128',NULL,0.50,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(65,28,'portable-power-bank-20000mah-variant-s9Q3',49.99,39.99,80,'PWR-BNK-20K-001',NULL,0.40,NULL,1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(67,24,'portable-bluetooth-speaker-69597e99506e7',79.99,NULL,45,'SPEAK-BT-PORT-001',NULL,0.60,NULL,1,'2026-01-03 18:39:53','2026-01-03 18:39:53');
/*!40000 ALTER TABLE `product_variants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` bigint(20) unsigned NOT NULL,
  `vendor_id` bigint(20) unsigned NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `brand_id` bigint(20) unsigned DEFAULT NULL,
  `product_type` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_shop_id_foreign` (`shop_id`),
  KEY `products_vendor_id_foreign` (`vendor_id`),
  CONSTRAINT `products_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES
(1,1,1,'cool-tshirt',1,1,'variable',1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(2,1,1,'sport-shoes',1,1,'variable',1,'2025-12-28 20:16:44','2025-12-28 20:16:44'),
(3,1,1,'wireless-headphones',1,1,'variable',1,'2025-12-28 20:16:45','2025-12-28 20:16:45'),
(4,1,1,'travel-backpack',1,1,'variable',1,'2025-12-28 20:16:46','2025-12-28 20:16:46'),
(6,1,1,'wireless-bluetooth-headphones',1,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(7,1,1,'4k-smart-tv-55-inch',1,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(8,1,1,'gaming-laptop-rtx-3060',1,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(9,1,1,'mechanical-gaming-keyboard-rgb',1,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(10,1,1,'wireless-gaming-mouse',1,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(11,1,1,'flagship-smartphone-pro-max',3,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(12,1,1,'mid-range-5g-smartphone',3,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(13,1,1,'budget-smartphone-dual-sim',3,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(14,1,1,'mens-leather-jacket-black',2,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(15,1,1,'womens-summer-dress-floral',2,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(16,1,1,'mens-slim-fit-jeans-blue',2,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(17,1,1,'womens-designer-handbag',2,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(18,1,1,'mens-running-sneakers',2,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(19,1,1,'basic-cotton-tshirt-white',4,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(20,1,1,'graphic-print-tshirt-black',4,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(21,1,1,'v-neck-tshirt-navy-blue',4,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(22,1,1,'polo-tshirt-red',4,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(23,1,1,'long-sleeve-tshirt-gray',4,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(24,1,1,'portable-bluetooth-speaker',1,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(25,1,1,'smart-watch-fitness-tracker',1,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(26,1,1,'wireless-earbuds-pro',1,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(27,1,1,'tablet-10-inch-android',1,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46'),
(28,1,1,'portable-power-bank-20000mah',1,1,'physical',1,'2025-12-31 19:06:46','2025-12-31 19:06:46');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promo_card_translations`
--

DROP TABLE IF EXISTS `promo_card_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `promo_card_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `promo_card_id` bigint(20) unsigned NOT NULL,
  `language_code` varchar(10) NOT NULL,
  `badge_text` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `button_url` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `promo_card_translations_promo_card_id_language_code_unique` (`promo_card_id`,`language_code`),
  CONSTRAINT `promo_card_translations_promo_card_id_foreign` FOREIGN KEY (`promo_card_id`) REFERENCES `promo_cards` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promo_card_translations`
--

LOCK TABLES `promo_card_translations` WRITE;
/*!40000 ALTER TABLE `promo_card_translations` DISABLE KEYS */;
INSERT INTO `promo_card_translations` VALUES
(1,1,'en','Summer Sale','Up to 50% Off','Shop Now','/shop','https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=800','2026-01-12 12:25:52','2026-01-12 12:25:52'),
(2,1,'ar','تخفيضات الصيف','خصم يصل إلى 50%','تسوق الآن','/shop','https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=800','2026-01-12 12:25:52','2026-01-12 12:25:52'),
(3,2,'en','New Arrivals','Latest Collection','Discover','/shop','https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800','2026-01-12 12:25:52','2026-01-12 12:25:52'),
(4,2,'ar','وصل حديثاً','أحدث المجموعات','اكتشف','/shop','https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800','2026-01-12 12:25:52','2026-01-12 12:25:52'),
(5,3,'en','Trending','Best Sellers','Explore','/shop','https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800','2026-01-12 12:25:52','2026-01-12 12:25:52'),
(6,3,'ar','رائج','الأكثر مبيعاً','استكشف','/shop','https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800','2026-01-12 12:25:52','2026-01-12 12:25:52');
/*!40000 ALTER TABLE `promo_card_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promo_cards`
--

DROP TABLE IF EXISTS `promo_cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `promo_cards` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `size` varchar(255) NOT NULL DEFAULT 'large',
  `order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promo_cards`
--

LOCK TABLES `promo_cards` WRITE;
/*!40000 ALTER TABLE `promo_cards` DISABLE KEYS */;
INSERT INTO `promo_cards` VALUES
(1,'large',1,1,'2026-01-12 12:25:52','2026-01-13 15:38:24'),
(2,'small',3,1,'2026-01-12 12:25:52','2026-01-12 16:17:48'),
(3,'small',2,1,'2026-01-12 12:25:52','2026-01-13 15:38:38');
/*!40000 ALTER TABLE `promo_cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refunds`
--

DROP TABLE IF EXISTS `refunds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `refunds` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'USD',
  `status` enum('requested','approved','rejected','completed','failed') NOT NULL DEFAULT 'requested',
  `refund_id` varchar(255) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`response`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `refunds_payment_id_foreign` (`payment_id`),
  CONSTRAINT `refunds_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refunds`
--

LOCK TABLES `refunds` WRITE;
/*!40000 ALTER TABLE `refunds` DISABLE KEYS */;
/*!40000 ALTER TABLE `refunds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipping_addresses`
--

DROP TABLE IF EXISTS `shipping_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipping_addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `customer_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipping_addresses_order_id_foreign` (`order_id`),
  KEY `shipping_addresses_customer_id_foreign` (`customer_id`),
  CONSTRAINT `shipping_addresses_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `shipping_addresses_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipping_addresses`
--

LOCK TABLES `shipping_addresses` WRITE;
/*!40000 ALTER TABLE `shipping_addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `shipping_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipping_regions`
--

DROP TABLE IF EXISTS `shipping_regions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipping_regions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `country` enum('jordan','palestine') NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `region_type` varchar(255) NOT NULL DEFAULT 'city',
  `base_cost` decimal(8,2) NOT NULL DEFAULT 0.00,
  `per_kg_cost` decimal(8,2) DEFAULT NULL,
  `delivery_days` int(11) NOT NULL DEFAULT 3,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shipping_regions_code_unique` (`code`),
  KEY `shipping_regions_country_index` (`country`),
  KEY `shipping_regions_code_index` (`code`),
  KEY `shipping_regions_is_active_index` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipping_regions`
--

LOCK TABLES `shipping_regions` WRITE;
/*!40000 ALTER TABLE `shipping_regions` DISABLE KEYS */;
INSERT INTO `shipping_regions` VALUES
(1,'jordan','Amman','عمّان','JO_AMMAN','governorate',3.00,0.50,2,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(2,'jordan','Irbid','إربد','JO_IRBID','governorate',4.00,0.60,3,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(3,'jordan','Zarqa','الزرقاء','JO_ZARQA','governorate',3.50,0.50,2,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(4,'jordan','Aqaba','العقبة','JO_AQABA','governorate',6.00,1.00,4,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(5,'jordan','Mafraq','المفرق','JO_MAFRAQ','governorate',4.50,0.70,3,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(6,'jordan','Jerash','جرش','JO_JERASH','governorate',4.00,0.60,3,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(7,'jordan','Ajloun','عجلون','JO_AJLOUN','governorate',4.00,0.60,3,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(8,'jordan','Karak','الكرك','JO_KARAK','governorate',5.00,0.80,3,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(9,'jordan','Tafilah','الطفيلة','JO_TAFILAH','governorate',5.50,0.90,4,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(10,'jordan','Ma\'an','معان','JO_MAAN','governorate',6.00,1.00,4,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(11,'jordan','Madaba','مادبا','JO_MADABA','governorate',3.50,0.50,2,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(12,'jordan','Balqa','البلقاء','JO_BALQA','governorate',3.50,0.50,2,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(13,'palestine','Ramallah','رام الله','PS_RAMALLAH','city',5.00,0.80,5,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(14,'palestine','Nablus','نابلس','PS_NABLUS','city',5.50,0.90,5,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(15,'palestine','Hebron','الخليل','PS_HEBRON','city',5.50,0.90,5,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(16,'palestine','Bethlehem','بيت لحم','PS_BETHLEHEM','city',5.00,0.80,5,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(17,'palestine','Jenin','جنين','PS_JENIN','city',6.00,1.00,6,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(18,'palestine','Tulkarm','طولكرم','PS_TULKARM','city',5.50,0.90,5,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(19,'palestine','Qalqilya','قلقيلية','PS_QALQILYA','city',5.50,0.90,5,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(20,'palestine','Jericho','أريحا','PS_JERICHO','city',5.00,0.80,5,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(21,'palestine','Salfit','سلفيت','PS_SALFIT','city',5.50,0.90,5,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(22,'palestine','Tubas','طوباس','PS_TUBAS','city',6.00,1.00,6,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(23,'palestine','Gaza','غزة','PS_GAZA','city',7.00,1.20,7,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(24,'palestine','Khan Yunis','خان يونس','PS_KHAN_YUNIS','city',7.50,1.30,7,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(25,'palestine','Rafah','رفح','PS_RAFAH','city',8.00,1.40,7,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(26,'palestine','Deir al-Balah','دير البلح','PS_DEIR_AL_BALAH','city',7.50,1.30,7,1,'2025-12-31 18:01:40','2025-12-31 18:01:40'),
(27,'palestine','North Gaza','شمال غزة','PS_NORTH_GAZA','city',7.00,1.20,7,1,'2025-12-31 18:01:40','2025-12-31 18:01:40');
/*!40000 ALTER TABLE `shipping_regions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipping_zones`
--

DROP TABLE IF EXISTS `shipping_zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipping_zones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `countries` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`countries`)),
  `base_cost` decimal(8,2) NOT NULL,
  `per_kg_cost` decimal(8,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipping_zones`
--

LOCK TABLES `shipping_zones` WRITE;
/*!40000 ALTER TABLE `shipping_zones` DISABLE KEYS */;
INSERT INTO `shipping_zones` VALUES
(1,'Jordan','[\"JO\"]',5.00,2.00,1,'2025-12-30 18:49:47','2025-12-30 18:49:47'),
(2,'Palestine','[\"PS\"]',7.00,2.50,1,'2025-12-30 18:49:47','2025-12-30 18:49:47'),
(3,'Other Countries','[\"*\"]',15.00,5.00,1,'2025-12-30 18:49:47','2025-12-30 18:49:47');
/*!40000 ALTER TABLE `shipping_zones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shops`
--

DROP TABLE IF EXISTS `shops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shops` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vendor_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shops_slug_unique` (`slug`),
  KEY `shops_vendor_id_foreign` (`vendor_id`),
  CONSTRAINT `shops_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shops`
--

LOCK TABLES `shops` WRITE;
/*!40000 ALTER TABLE `shops` DISABLE KEYS */;
INSERT INTO `shops` VALUES
(1,1,'Soft Shoes','soft-shoes','N/A','Luxurious comfort in every step. Crafted with premium materials for a soft, stylish, and effortless walking experience. ','active','2025-12-28 20:16:41','2025-12-28 20:16:41');
/*!40000 ALTER TABLE `shops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `site_name` varchar(255) NOT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `contact_phone_2` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `footer_text` text DEFAULT NULL,
  `default_currency` varchar(3) NOT NULL DEFAULT 'USD',
  `default_language` varchar(5) NOT NULL DEFAULT 'en',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES
(1,'MatchStore',NULL,NULL,NULL,NULL,'site-assets/BmSkitY4gsCo6Z05yoyXWAfUOB0E7yQgyGQbMsFX.png','site-assets/JCQpWuZq2XJqPIiWmNqxW67stgedqt0r4S9GEoKN.png','matchprosys@gmail.com','+970 593 081 003','+970 593 081 003',NULL,NULL,'NIS','ar','2025-12-31 17:03:31','2026-01-27 19:49:25');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_media_link_translations`
--

DROP TABLE IF EXISTS `social_media_link_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `social_media_link_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `social_media_link_id` bigint(20) unsigned NOT NULL,
  `language_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `social_media_link_translations_unique` (`social_media_link_id`,`language_code`),
  CONSTRAINT `social_media_link_translations_social_media_link_id_foreign` FOREIGN KEY (`social_media_link_id`) REFERENCES `social_media_links` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_media_link_translations`
--

LOCK TABLES `social_media_link_translations` WRITE;
/*!40000 ALTER TABLE `social_media_link_translations` DISABLE KEYS */;
INSERT INTO `social_media_link_translations` VALUES
(1,1,'en','Instagram','2026-01-03 18:06:09','2026-01-03 18:06:09'),
(2,1,'ar','انستاجرام','2026-01-03 18:06:09','2026-01-03 18:06:09'),
(3,2,'en','Facebook','2026-01-03 18:25:29','2026-01-03 18:25:29'),
(4,2,'ar','فيسبوك','2026-01-03 18:25:29','2026-01-03 18:25:29');
/*!40000 ALTER TABLE `social_media_link_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_media_links`
--

DROP TABLE IF EXISTS `social_media_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `social_media_links` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('facebook','instagram','tiktok','youtube','x') NOT NULL,
  `platform` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_media_links`
--

LOCK TABLES `social_media_links` WRITE;
/*!40000 ALTER TABLE `social_media_links` DISABLE KEYS */;
INSERT INTO `social_media_links` VALUES
(1,'instagram','Instagram','https://instagram.com/match.systems','2026-01-03 18:06:09','2026-01-03 18:06:09'),
(2,'facebook','Facebook','https://instagram.com/match.systems','2026-01-03 18:25:29','2026-01-03 18:25:29');
/*!40000 ALTER TABLE `social_media_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `store_settings`
--

DROP TABLE IF EXISTS `store_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `store_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_settings`
--

LOCK TABLES `store_settings` WRITE;
/*!40000 ALTER TABLE `store_settings` DISABLE KEYS */;
INSERT INTO `store_settings` VALUES
(1,'default_currency','USD',NULL,NULL),
(2,'meta_title','Welcome to Velstore - Your Laravel eCommerce Journey Begins!',NULL,NULL),
(3,'meta_description','Welcome to Velstore! You have successfully installed the ultimate Laravel eCommerce boilerplate. Set up your store, configure settings, and start selling with a powerful multi-vendor, multilingual platform.',NULL,NULL),
(4,'phone_number','+1 234 567 890',NULL,NULL),
(5,'theme_preset','matchsystems',NULL,NULL),
(6,'theme_custom_enabled','0',NULL,NULL),
(7,'theme_primary_color','#ff0000',NULL,NULL),
(8,'theme_primary_light_color','#ff0000',NULL,NULL),
(9,'theme_secondary_color','#ff0000',NULL,NULL),
(10,'theme_background_color','#ff0000',NULL,NULL),
(11,'theme_card_background_color','#ff0000',NULL,NULL),
(12,'theme_text_color','#ff0000',NULL,NULL),
(13,'theme_border_color','#ff0000',NULL,NULL);
/*!40000 ALTER TABLE `store_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscribers`
--

DROP TABLE IF EXISTS `subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscribers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscribers_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscribers`
--

LOCK TABLES `subscribers` WRITE;
/*!40000 ALTER TABLE `subscribers` DISABLE KEYS */;
INSERT INTO `subscribers` VALUES
(2,'accesspro82@gmail.com','unsubscribed','2026-01-14 14:40:56','2026-01-14 14:42:22');
/*!40000 ALTER TABLE `subscribers` ENABLE KEYS */;
UNLOCK TABLES;

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
  `phone` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
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

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'MatchStore Admin','matchprosys@gmail.com',NULL,'$2y$12$hd9fFabsFTcqapB6L8SShO7L.Flhh0s/CSGHkRkxJK4SDugbxsDqa',NULL,'admin_profiles/42p7ztOJ3QzxQldMnzV2vu3K1XQ4vvHhXRpq1OiV.png','yBTzLraKtpC6VqCiK79ETp2X1ky9fxiP8xQiO8R71CLeblW6tEB2JfGdDBwi','2025-12-28 20:16:37','2026-01-03 16:16:49');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendors`
--

DROP TABLE IF EXISTS `vendors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `vendors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','banned') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vendors_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendors`
--

LOCK TABLES `vendors` WRITE;
/*!40000 ALTER TABLE `vendors` DISABLE KEYS */;
INSERT INTO `vendors` VALUES
(1,'Seller','seller@example.com','$2y$12$ULbAPkE8/fYNyakB.PD8WOZmJNgKn.UI.2KIWn2E4vXOgZjkhFiiq','+923001234567','https://i.postimg.cc/FHxQs4Br/images-10.jpg','active','2025-12-28 20:16:41','2025-12-28 20:16:41');
/*!40000 ALTER TABLE `vendors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlists`
--

DROP TABLE IF EXISTS `wishlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wishlists_customer_id_foreign` (`customer_id`),
  KEY `wishlists_product_id_foreign` (`product_id`),
  CONSTRAINT `wishlists_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlists`
--

LOCK TABLES `wishlists` WRITE;
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'matchstore'
--

--
-- Dumping routines for database 'matchstore'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-27 23:54:25
