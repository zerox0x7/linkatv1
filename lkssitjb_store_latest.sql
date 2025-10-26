-- MySQL dump 10.13  Distrib 8.0.43, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: lkssitjb_store
-- ------------------------------------------------------
-- Server version	8.0.43-0ubuntu0.24.04.1

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
-- Table structure for table `account_digetal`
--

DROP TABLE IF EXISTS `account_digetal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_digetal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `status` enum('available','sold','pending') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `order_id` bigint unsigned DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account_digetal_product_id_foreign` (`product_id`),
  CONSTRAINT `account_digetal_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `account_digetal_chk_1` CHECK (json_valid(`meta`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_digetal`
--

/*!40000 ALTER TABLE `account_digetal` DISABLE KEYS */;
/*!40000 ALTER TABLE `account_digetal` ENABLE KEYS */;

--
-- Table structure for table `blog_comments`
--

DROP TABLE IF EXISTS `blog_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) DEFAULT '0',
  `parent_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_comments_post_id_foreign` (`post_id`),
  KEY `blog_comments_user_id_foreign` (`user_id`),
  KEY `blog_comments_parent_id_foreign` (`parent_id`),
  CONSTRAINT `blog_comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `blog_comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blog_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blog_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_comments`
--

/*!40000 ALTER TABLE `blog_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_comments` ENABLE KEYS */;

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` bigint unsigned NOT NULL,
  `is_published` tinyint(1) DEFAULT '1',
  `published_at` timestamp NULL DEFAULT NULL,
  `views_count` int DEFAULT '0',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  KEY `blog_posts_author_id_foreign` (`author_id`),
  CONSTRAINT `blog_posts_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_posts`
--

/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;

--
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` bigint unsigned NOT NULL,
  `cartable_id` bigint unsigned NOT NULL,
  `cartable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int DEFAULT '1',
  `price` decimal(10,2) NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_items_cart_id_foreign` (`cart_id`),
  KEY `cart_items_cartable_type_cartable_id_index` (`cartable_type`,`cartable_id`),
  CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_chk_1` CHECK (json_valid(`options`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items`
--

/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_user_id_foreign` (`user_id`),
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) DEFAULT '1',
  `is_featured` tinyint(1) DEFAULT '0',
  `sort_order` int DEFAULT '0',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'account',
  `parent_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `show_in_homepage` tinyint(1) DEFAULT '0',
  `homepage_order` int DEFAULT NULL,
  `order` int DEFAULT '0',
  `text_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bg_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

--
-- Table structure for table `coupon_page_settings`
--

DROP TABLE IF EXISTS `coupon_page_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupon_page_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned NOT NULL,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupon_page_settings_store_id_unique` (`store_id`),
  CONSTRAINT `coupon_page_settings_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `coupon_page_settings_chk_1` CHECK (json_valid(`settings`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupon_page_settings`
--

/*!40000 ALTER TABLE `coupon_page_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupon_page_settings` ENABLE KEYS */;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `style_id` bigint unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `starts_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `max_uses` int DEFAULT NULL,
  `used_times` int DEFAULT '0',
  `min_order_amount` decimal(10,2) DEFAULT NULL,
  `max_discount_amount` decimal(10,2) DEFAULT NULL,
  `user_limit` int DEFAULT NULL,
  `priority` int NOT NULL DEFAULT '0',
  `auto_apply` tinyint(1) NOT NULL DEFAULT '0',
  `stackable` tinyint(1) NOT NULL DEFAULT '0',
  `email_notifications` tinyint(1) NOT NULL DEFAULT '0',
  `show_on_homepage` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `product_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `category_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_code_unique` (`code`),
  CONSTRAINT `coupons_chk_1` CHECK (json_valid(`product_ids`)),
  CONSTRAINT `coupons_chk_2` CHECK (json_valid(`category_ids`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;

--
-- Table structure for table `custom_order_messages`
--

DROP TABLE IF EXISTS `custom_order_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `custom_order_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `custom_order_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `custom_order_messages_custom_order_id_foreign` (`custom_order_id`),
  KEY `custom_order_messages_user_id_foreign` (`user_id`),
  CONSTRAINT `custom_order_messages_custom_order_id_foreign` FOREIGN KEY (`custom_order_id`) REFERENCES `custom_orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `custom_order_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_order_messages`
--

/*!40000 ALTER TABLE `custom_order_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_order_messages` ENABLE KEYS */;

--
-- Table structure for table `custom_orders`
--

DROP TABLE IF EXISTS `custom_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `custom_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `deadline` date DEFAULT NULL,
  `final_price` decimal(10,2) DEFAULT NULL,
  `assigned_to` bigint unsigned DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `custom_orders_user_id_foreign` (`user_id`),
  KEY `custom_orders_assigned_to_foreign` (`assigned_to`),
  KEY `custom_orders_store_id_index` (`store_id`),
  CONSTRAINT `custom_orders_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`),
  CONSTRAINT `custom_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_orders`
--

/*!40000 ALTER TABLE `custom_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_orders` ENABLE KEYS */;

--
-- Table structure for table `development_features`
--

DROP TABLE IF EXISTS `development_features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `development_features` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('planned','in_progress','testing','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'planned',
  `priority` enum('low','medium','high','critical') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `technologies` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estimated_hours` decimal(8,2) DEFAULT NULL,
  `actual_hours` decimal(8,2) DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `development_features_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `development_features`
--

/*!40000 ALTER TABLE `development_features` DISABLE KEYS */;
INSERT INTO `development_features` VALUES (1,'Development Tracker System','A comprehensive system to track development features, their progress, and generate documentation. This system allows developers to maintain a record of all features developed with AI assistance, including implementation details, time tracking, and markdown documentation generation.','completed','high','Backend','Laravel, Blade, Tailwind CSS, AlpineJS',8.00,6.50,'This feature includes a complete CRUD system for tracking development features, with dashboard-style cards, forms for creating/editing features, and markdown generation for documentation. The system follows the existing admin panel design patterns.','development-tracker-system','2025-10-25 14:49:31','2025-10-25 14:49:31'),(2,'User Authentication System','Implemented secure user authentication with login, registration, password reset, and role-based access control. Includes email verification and session management.','completed','critical','Backend','Laravel Sanctum, Laravel Auth, Mail',12.00,10.00,'Standard Laravel authentication with custom middleware for admin access. Includes password reset functionality and email verification.','user-authentication-system','2025-10-25 14:49:32','2025-10-25 14:49:32'),(3,'Product Management System','Complete product management with CRUD operations, image uploads, category management, and inventory tracking. Supports both digital and physical products.','completed','high','Backend','Laravel, MySQL, File Storage',15.00,18.00,'Includes product variants, digital codes management, and bulk operations. Features advanced filtering and search capabilities.','product-management-system','2025-10-25 14:49:32','2025-10-25 14:49:32'),(4,'Payment Gateway Integration','Integrated multiple payment gateways including PayPal, Stripe, and local payment methods. Includes webhook handling and transaction logging.','completed','critical','Backend','PayPal SDK, Stripe API, Webhooks',20.00,22.00,'Supports multiple currencies and includes comprehensive error handling. Features automatic retry mechanisms for failed transactions.','payment-gateway-integration','2025-10-25 14:49:33','2025-10-25 14:49:33'),(5,'Admin Dashboard Analytics','Comprehensive analytics dashboard with sales reports, user statistics, and performance metrics. Includes charts and data visualization.','completed','medium','Frontend','Chart.js, Laravel, Blade',10.00,8.50,'Real-time dashboard with interactive charts showing sales trends, user growth, and product performance.','admin-dashboard-analytics','2025-10-25 14:49:33','2025-10-25 14:49:33'),(6,'Theme Customization System','Advanced theme customization system allowing users to modify colors, layouts, and styling through an admin interface.','in_progress','medium','Frontend','CSS Variables, JavaScript, Livewire',16.00,12.00,'Currently working on the color picker interface and real-time preview functionality. Need to implement save/load functionality.','theme-customization-system','2025-10-25 14:49:33','2025-10-25 14:49:33'),(7,'Mobile App API','RESTful API for mobile application with authentication, product listing, order management, and push notifications.','testing','high','API','Laravel API Resources, JWT, Firebase',25.00,28.00,'API is complete and currently being tested. Includes comprehensive documentation and rate limiting.','mobile-app-api','2025-10-25 14:49:33','2025-10-25 14:49:33'),(8,'Advanced Search & Filtering','Enhanced search functionality with filters, sorting options, and search suggestions. Includes Elasticsearch integration.','planned','medium','Backend','Elasticsearch, Laravel Scout',14.00,NULL,'Planned for next sprint. Will include faceted search and auto-complete functionality.','advanced-search-filtering','2025-10-25 14:49:33','2025-10-25 14:49:33'),(9,'Email Marketing Integration','Integration with email marketing platforms for automated campaigns, newsletters, and customer segmentation.','planned','low','Backend','Mailchimp API, Laravel Queues',18.00,NULL,'Will include automated email sequences and customer behavior tracking.','email-marketing-integration','2025-10-25 14:49:33','2025-10-25 14:49:33'),(10,'Multi-language Support','Complete internationalization system supporting multiple languages with RTL support and dynamic content translation.','planned','low','Frontend','Laravel Localization, Vue.js i18n',20.00,NULL,'Will support Arabic, English, and French initially. Includes RTL layout support.','multi-language-support','2025-10-25 14:49:34','2025-10-25 14:49:34');
/*!40000 ALTER TABLE `development_features` ENABLE KEYS */;

--
-- Table structure for table `digital_card_codes`
--

DROP TABLE IF EXISTS `digital_card_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `digital_card_codes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `digital_card_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'available',
  `expiry_date` datetime DEFAULT NULL,
  `sold_at` datetime DEFAULT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `digital_card_codes_order_id_code_unique` (`order_id`,`code`),
  KEY `digital_card_codes_digital_card_id_foreign` (`digital_card_id`),
  KEY `digital_card_codes_order_id_foreign` (`order_id`),
  KEY `digital_card_codes_user_id_foreign` (`user_id`),
  KEY `digital_card_codes_product_id_foreign` (`product_id`),
  CONSTRAINT `digital_card_codes_digital_card_id_foreign` FOREIGN KEY (`digital_card_id`) REFERENCES `digital_cards` (`id`) ON DELETE CASCADE,
  CONSTRAINT `digital_card_codes_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  CONSTRAINT `digital_card_codes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `digital_card_codes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `digital_card_codes`
--

/*!40000 ALTER TABLE `digital_card_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `digital_card_codes` ENABLE KEYS */;

--
-- Table structure for table `digital_cards`
--

DROP TABLE IF EXISTS `digital_cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `digital_cards` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'USD',
  `description` text COLLATE utf8mb4_unicode_ci,
  `how_to_use` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock_quantity` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `is_featured` tinyint(1) DEFAULT '0',
  `regions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `digital_cards_slug_unique` (`slug`),
  KEY `digital_cards_category_id_foreign` (`category_id`),
  CONSTRAINT `digital_cards_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `digital_cards_chk_1` CHECK (json_valid(`regions`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `digital_cards`
--

/*!40000 ALTER TABLE `digital_cards` DISABLE KEYS */;
/*!40000 ALTER TABLE `digital_cards` ENABLE KEYS */;

--
-- Table structure for table `dms_feature_dependencies`
--

DROP TABLE IF EXISTS `dms_feature_dependencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dms_feature_dependencies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `feature_id` bigint unsigned NOT NULL,
  `depends_on_feature_id` bigint unsigned NOT NULL,
  `type` enum('blocks','requires','relates_to') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'requires',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_dependency` (`feature_id`,`depends_on_feature_id`),
  KEY `dms_feature_dependencies_feature_id_index` (`feature_id`),
  KEY `dms_feature_dependencies_depends_on_feature_id_index` (`depends_on_feature_id`),
  CONSTRAINT `dms_feature_dependencies_depends_on_feature_id_foreign` FOREIGN KEY (`depends_on_feature_id`) REFERENCES `dms_features` (`id`) ON DELETE CASCADE,
  CONSTRAINT `dms_feature_dependencies_feature_id_foreign` FOREIGN KEY (`feature_id`) REFERENCES `dms_features` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dms_feature_dependencies`
--

/*!40000 ALTER TABLE `dms_feature_dependencies` DISABLE KEYS */;
/*!40000 ALTER TABLE `dms_feature_dependencies` ENABLE KEYS */;

--
-- Table structure for table `dms_feature_files`
--

DROP TABLE IF EXISTS `dms_feature_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dms_feature_files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `feature_id` bigint unsigned NOT NULL,
  `owner_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('backend','frontend','doc','test','config') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'backend',
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lines_of_code` int NOT NULL DEFAULT '0',
  `progress` decimal(5,2) NOT NULL DEFAULT '0.00',
  `test_coverage` decimal(5,2) DEFAULT NULL,
  `status` enum('not_started','in_progress','completed','needs_review') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not_started',
  `weight` int NOT NULL DEFAULT '1',
  `last_updated` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dms_feature_files_feature_id_index` (`feature_id`),
  KEY `dms_feature_files_type_index` (`type`),
  KEY `dms_feature_files_status_index` (`status`),
  KEY `dms_feature_files_owner_id_index` (`owner_id`),
  CONSTRAINT `dms_feature_files_feature_id_foreign` FOREIGN KEY (`feature_id`) REFERENCES `dms_features` (`id`) ON DELETE CASCADE,
  CONSTRAINT `dms_feature_files_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dms_feature_files`
--

/*!40000 ALTER TABLE `dms_feature_files` DISABLE KEYS */;
INSERT INTO `dms_feature_files` VALUES (1,2,2,'AuthController.php','app/Http/Controllers/AuthController.php','backend','php',250,100.00,95.00,'completed',3,'2025-08-25 16:25:35',NULL,'2025-10-25 16:25:35','2025-10-25 16:25:35',NULL),(2,2,2,'User.php','app/Models/User.php','backend','php',180,100.00,90.00,'completed',2,'2025-08-25 16:25:36',NULL,'2025-10-25 16:25:36','2025-10-25 16:25:36',NULL),(3,4,3,'ProductController.php','app/Http/Controllers/ProductController.php','backend','php',420,75.00,70.00,'in_progress',5,'2025-10-23 16:25:36',NULL,'2025-10-25 16:25:36','2025-10-25 16:25:36',NULL),(4,4,3,'Product.php','app/Models/Product.php','backend','php',320,90.00,85.00,'in_progress',4,'2025-10-24 16:25:37',NULL,'2025-10-25 16:25:37','2025-10-25 16:25:37',NULL),(5,5,4,'CartService.php','app/Services/CartService.php','backend','php',280,95.00,92.00,'needs_review',4,'2025-10-25 16:25:37',NULL,'2025-10-25 16:25:37','2025-10-25 16:46:34','2025-10-25 16:46:34'),(6,7,2,'ApiController.php','app/Http/Controllers/Api/ApiController.php','backend','php',500,60.00,75.00,'in_progress',5,'2025-10-25 10:25:38',NULL,'2025-10-25 16:25:38','2025-10-25 16:25:38',NULL),(7,11,2,'DashboardComponent.vue','resources/js/components/Dashboard.vue','frontend','javascript',350,65.00,60.00,'in_progress',4,'2025-10-24 16:25:39',NULL,'2025-10-25 16:25:39','2025-10-25 16:25:39',NULL),(8,12,3,'DataProcessor.php','app/Services/DataProcessor.php','backend','php',450,90.00,88.00,'needs_review',5,'2025-10-25 04:25:43',NULL,'2025-10-25 16:25:43','2025-10-25 16:25:43',NULL),(9,1,NULL,'servs','/servs/sd.php','frontend','javascript',0,0.00,NULL,'not_started',1,NULL,NULL,'2025-10-25 16:45:37','2025-10-25 16:45:45','2025-10-25 16:45:45'),(10,1,NULL,'adfd','dsdf','frontend','safd',48,0.00,NULL,'not_started',1,NULL,NULL,'2025-10-25 16:46:06','2025-10-25 16:46:06',NULL),(11,5,NULL,'ghnhv','vbh','backend','php',4,0.00,NULL,'not_started',1,NULL,NULL,'2025-10-25 16:47:28','2025-10-25 16:47:28',NULL),(12,5,NULL,'gjhgj','bhjhjg','frontend','javascript',3,0.00,NULL,'not_started',1,NULL,NULL,'2025-10-25 16:47:40','2025-10-25 16:47:40',NULL),(13,5,NULL,'ghjghj','ghjghj','frontend','markdown',1,0.00,NULL,'not_started',1,NULL,NULL,'2025-10-25 16:47:55','2025-10-25 16:47:55',NULL),(14,14,NULL,'ResponsiveImageService.php','app/Services/ResponsiveImageService.php','backend','php',250,100.00,85.00,'completed',5,'2025-10-25 17:10:21','Main service handling image resizing logic with multiple breakpoints','2025-10-25 17:10:21','2025-10-25 17:10:21',NULL),(15,14,NULL,'ResponsiveImage.php','app/View/Components/ResponsiveImage.php','backend','php',180,100.00,90.00,'completed',4,'2025-10-25 17:10:21','Blade component for rendering responsive images','2025-10-25 17:10:21','2025-10-25 17:10:21',NULL),(16,14,NULL,'ImageHelper.php','app/Helpers/ImageHelper.php','backend','php',120,100.00,95.00,'completed',3,'2025-10-25 17:10:22','Helper functions for image manipulation','2025-10-25 17:10:22','2025-10-25 17:10:22',NULL),(17,14,NULL,'responsive-image.blade.php','resources/views/components/responsive-image.blade.php','frontend','blade',120,100.00,NULL,'completed',3,'2025-10-25 17:10:22','Blade template with srcset and sizes attributes','2025-10-25 17:10:22','2025-10-25 17:10:22',NULL),(18,14,NULL,'hero-customizer.blade.php','resources/views/admin/hero-customizer.blade.php','frontend','blade',280,100.00,NULL,'completed',4,'2025-10-25 17:10:23','Admin interface for managing hero images with responsive options','2025-10-25 17:10:23','2025-10-25 17:10:23',NULL),(19,14,NULL,'image-preview.js','public/js/image-preview.js','frontend','javascript',150,100.00,NULL,'completed',2,'2025-10-25 17:10:23','JavaScript for live image preview in admin','2025-10-25 17:10:23','2025-10-25 17:10:23',NULL),(20,14,NULL,'RESPONSIVE_IMAGES_USAGE.md','RESPONSIVE_IMAGES_USAGE.md','doc','markdown',200,100.00,NULL,'completed',2,'2025-10-25 17:10:23','User guide for using responsive images','2025-10-25 17:10:23','2025-10-25 17:10:23',NULL),(21,14,NULL,'RESPONSIVE_IMAGES_IMPLEMENTATION.md','RESPONSIVE_IMAGES_IMPLEMENTATION.md','doc','markdown',350,100.00,NULL,'completed',2,'2025-10-25 17:10:24','Technical implementation guide','2025-10-25 17:10:24','2025-10-25 17:10:24',NULL),(22,14,NULL,'README_RESPONSIVE_IMAGES.md','README_RESPONSIVE_IMAGES.md','doc','markdown',180,100.00,NULL,'completed',1,'2025-10-25 17:10:24','Quick start guide','2025-10-25 17:10:24','2025-10-25 17:10:24',NULL);
/*!40000 ALTER TABLE `dms_feature_files` ENABLE KEYS */;

--
-- Table structure for table `dms_feature_progress`
--

DROP TABLE IF EXISTS `dms_feature_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dms_feature_progress` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `feature_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `progress_percentage` decimal(5,2) NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dms_feature_progress_feature_id_index` (`feature_id`),
  KEY `dms_feature_progress_user_id_index` (`user_id`),
  KEY `dms_feature_progress_created_at_index` (`created_at`),
  CONSTRAINT `dms_feature_progress_feature_id_foreign` FOREIGN KEY (`feature_id`) REFERENCES `dms_features` (`id`) ON DELETE CASCADE,
  CONSTRAINT `dms_feature_progress_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dms_feature_progress`
--

/*!40000 ALTER TABLE `dms_feature_progress` DISABLE KEYS */;
/*!40000 ALTER TABLE `dms_feature_progress` ENABLE KEYS */;

--
-- Table structure for table `dms_features`
--

DROP TABLE IF EXISTS `dms_features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dms_features` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `owner_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` enum('feature','backend','frontend','structure','task') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'feature',
  `status` enum('backlog','planned','in_progress','review','testing','done','blocked') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'backlog',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `priority` int NOT NULL DEFAULT '0',
  `risk` enum('low','medium','high','critical') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `progress` decimal(5,2) NOT NULL DEFAULT '0.00',
  `estimated_hours` int DEFAULT NULL,
  `actual_hours` int DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `health` enum('healthy','at_risk','critical') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'healthy',
  `start_date` date DEFAULT NULL,
  `target_date` date DEFAULT NULL,
  `completed_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dms_features_project_id_index` (`project_id`),
  KEY `dms_features_parent_id_index` (`parent_id`),
  KEY `dms_features_status_index` (`status`),
  KEY `dms_features_type_index` (`type`),
  KEY `dms_features_owner_id_index` (`owner_id`),
  KEY `dms_features_order_index` (`order`),
  CONSTRAINT `dms_features_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `dms_features_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `dms_features` (`id`) ON DELETE CASCADE,
  CONSTRAINT `dms_features_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `dms_projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dms_features`
--

/*!40000 ALTER TABLE `dms_features` DISABLE KEYS */;
INSERT INTO `dms_features` VALUES (1,1,NULL,2,'User Authentication System','user-authentication','Complete authentication system with social login','feature','done','ri-lock-line','#10B981',NULL,10,'low',100.00,40,38,0,'healthy','2025-07-25','2025-08-25','2025-08-30','2025-10-25 16:25:35','2025-10-25 16:25:46',NULL),(2,1,1,2,'Authentication Backend','auth-backend',NULL,'backend','done','ri-server-line',NULL,NULL,10,'low',100.00,20,18,0,'healthy',NULL,NULL,NULL,'2025-10-25 16:25:35','2025-10-25 16:25:45',NULL),(3,1,NULL,3,'Product Management','product-management','Complete product CRUD with categories and variants','feature','in_progress','ri-product-hunt-line','#3B82F6',NULL,9,'medium',81.67,80,45,1,'healthy','2025-08-25','2025-11-08',NULL,'2025-10-25 16:25:36','2025-10-25 16:25:47',NULL),(4,1,3,3,'Product Backend API','product-backend',NULL,'backend','in_progress','ri-server-line',NULL,NULL,9,'medium',81.67,40,25,0,'healthy',NULL,NULL,NULL,'2025-10-25 16:25:36','2025-10-25 16:25:46',NULL),(5,1,NULL,4,'Shopping Cart','shopping-cart','Shopping cart with session and database persistence','feature','review','ri-shopping-bag-line','#F59E0B',NULL,8,'low',95.00,30,28,2,'healthy','2025-09-25','2025-10-30',NULL,'2025-10-25 16:25:37','2025-10-25 16:25:48',NULL),(6,1,NULL,5,'Payment Integration','payment-integration','Multiple payment gateway integration','feature','backlog','ri-bank-card-line','#EF4444',NULL,10,'high',0.00,60,NULL,3,'healthy','2025-11-01','2025-11-25',NULL,'2025-10-25 16:25:38','2025-10-25 16:25:38',NULL),(7,2,NULL,2,'REST API Development','rest-api','RESTful API for mobile app','backend','in_progress','ri-code-box-line',NULL,NULL,10,'medium',60.00,100,60,0,'healthy',NULL,NULL,NULL,'2025-10-25 16:25:38','2025-10-25 16:25:48',NULL),(8,2,NULL,3,'Mobile UI Components','mobile-ui','Reusable UI components for mobile app','frontend','planned','ri-smartphone-line',NULL,NULL,8,'low',0.00,80,NULL,1,'healthy',NULL,NULL,NULL,'2025-10-25 16:25:38','2025-10-25 16:25:38',NULL),(9,3,NULL,4,'Contact Management','contact-management','Manage customer contacts and interactions','feature','planned','ri-contacts-line',NULL,NULL,9,'medium',0.00,50,NULL,0,'healthy',NULL,NULL,NULL,'2025-10-25 16:25:38','2025-10-25 16:25:38',NULL),(10,3,NULL,5,'Sales Reports','sales-reports','Comprehensive sales reporting and analytics','feature','backlog','ri-bar-chart-line',NULL,NULL,7,'low',0.00,40,NULL,1,'healthy',NULL,NULL,NULL,'2025-10-25 16:25:39','2025-10-25 16:25:39',NULL),(11,4,NULL,2,'Dashboard Widgets','dashboard-widgets','Interactive dashboard widgets and charts','frontend','in_progress','ri-dashboard-3-line',NULL,NULL,9,'medium',65.00,60,35,0,'healthy',NULL,NULL,NULL,'2025-10-25 16:25:39','2025-10-25 16:25:49',NULL),(12,4,NULL,3,'Data Processing Pipeline','data-pipeline','Real-time data processing and aggregation','backend','testing','ri-database-line',NULL,NULL,10,'high',90.00,80,75,1,'healthy',NULL,NULL,NULL,'2025-10-25 16:25:40','2025-10-25 16:25:49',NULL),(13,1,NULL,NULL,'test','test',NULL,'feature','backlog','ri-shield-line','#3B82F6',NULL,5,'medium',0.00,NULL,NULL,4,'healthy',NULL,NULL,NULL,'2025-10-25 16:48:26','2025-10-25 16:48:26',NULL),(14,1,NULL,NULL,'Responsive Image System','responsive-image-system','Dynamic image resizing for hero sections with multiple breakpoints and automatic optimization','feature','done','ri-image-line','#10B981',NULL,9,'low',100.00,12,10,0,'healthy','2025-10-15','2025-10-23','2025-10-24','2025-10-25 17:10:20','2025-10-25 17:10:20',NULL);
/*!40000 ALTER TABLE `dms_features` ENABLE KEYS */;

--
-- Table structure for table `dms_organizations`
--

DROP TABLE IF EXISTS `dms_organizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dms_organizations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `settings` json DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#3B82F6',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dms_organizations_slug_unique` (`slug`),
  KEY `dms_organizations_slug_index` (`slug`),
  KEY `dms_organizations_is_active_index` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dms_organizations`
--

/*!40000 ALTER TABLE `dms_organizations` DISABLE KEYS */;
INSERT INTO `dms_organizations` VALUES (1,'Tech Solutions Inc','tech-solutions','Leading software development company','{\"timezone\": \"UTC\", \"working_hours\": \"9-17\"}','#3B82F6','ri-building-line',1,'2025-10-25 16:25:32','2025-10-25 16:25:32',NULL),(2,'Digital Innovations Ltd','digital-innovations','Innovative digital products and services','{\"timezone\": \"UTC\", \"working_hours\": \"8-16\"}','#10B981','ri-lightbulb-line',1,'2025-10-25 16:25:32','2025-10-25 16:25:32',NULL);
/*!40000 ALTER TABLE `dms_organizations` ENABLE KEYS */;

--
-- Table structure for table `dms_projects`
--

DROP TABLE IF EXISTS `dms_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dms_projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `organization_id` bigint unsigned NOT NULL,
  `owner_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('planning','active','on_hold','completed','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'planning',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#10B981',
  `tags` json DEFAULT NULL,
  `priority` int NOT NULL DEFAULT '0',
  `progress` decimal(5,2) NOT NULL DEFAULT '0.00',
  `start_date` date DEFAULT NULL,
  `target_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dms_projects_organization_id_slug_unique` (`organization_id`,`slug`),
  KEY `dms_projects_status_index` (`status`),
  KEY `dms_projects_owner_id_index` (`owner_id`),
  CONSTRAINT `dms_projects_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `dms_organizations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `dms_projects_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dms_projects`
--

/*!40000 ALTER TABLE `dms_projects` DISABLE KEYS */;
INSERT INTO `dms_projects` VALUES (1,1,2,'E-Commerce Platform','ecommerce-platform','Full-featured e-commerce platform with multi-vendor support','active','ri-shopping-cart-line','#3B82F6','[\"ecommerce\", \"laravel\", \"vue\"]',9,63.73,'2025-07-25','2026-01-25','2025-10-25 16:25:33','2025-10-25 16:25:48',NULL),(2,1,3,'Mobile App Development','mobile-app','Cross-platform mobile application for iOS and Android','active','ri-smartphone-line','#8B5CF6','[\"mobile\", \"react-native\", \"api\"]',8,33.33,'2025-08-25','2026-02-25','2025-10-25 16:25:34','2025-10-25 16:25:48',NULL),(3,2,4,'CRM System','crm-system','Customer relationship management system with analytics','planning','ri-customer-service-line','#10B981','[\"crm\", \"saas\", \"analytics\"]',7,0.00,'2025-11-08','2026-04-25','2025-10-25 16:25:34','2025-10-25 16:25:49',NULL),(4,2,5,'Analytics Dashboard','analytics-dashboard','Real-time analytics and reporting dashboard','active','ri-dashboard-line','#F59E0B','[\"analytics\", \"dashboard\", \"charts\"]',8,79.29,'2025-09-25','2025-12-25','2025-10-25 16:25:35','2025-10-25 16:25:50',NULL);
/*!40000 ALTER TABLE `dms_projects` ENABLE KEYS */;

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

/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'general',
  `is_published` tinyint(1) DEFAULT '1',
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs`
--

/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;

--
-- Table structure for table `header_settings`
--

DROP TABLE IF EXISTS `header_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `header_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `header_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `header_font` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tajawal',
  `header_sticky` tinyint(1) NOT NULL DEFAULT '1',
  `header_shadow` tinyint(1) NOT NULL DEFAULT '1',
  `header_scroll_effects` tinyint(1) NOT NULL DEFAULT '1',
  `header_smooth_transitions` tinyint(1) NOT NULL DEFAULT '1',
  `header_custom_css` text COLLATE utf8mb4_unicode_ci,
  `header_layout` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `header_height` int NOT NULL DEFAULT '80',
  `logo_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `logo_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_svg` text COLLATE utf8mb4_unicode_ci,
  `logo_width` int NOT NULL DEFAULT '150',
  `logo_height` int NOT NULL DEFAULT '50',
  `logo_position` enum('left','center','right') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'left',
  `logo_border_radius` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'rounded-lg',
  `logo_shadow_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `logo_shadow_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_shadow_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'gray-500',
  `logo_shadow_opacity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '50',
  `navigation_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `main_menus_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `main_menus_number` int NOT NULL DEFAULT '5',
  `show_home_link` tinyint(1) NOT NULL DEFAULT '1',
  `show_categories_in_menu` tinyint(1) NOT NULL DEFAULT '1',
  `categories_count` int NOT NULL DEFAULT '5',
  `menu_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `search_bar_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `user_menu_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `shopping_cart_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `wishlist_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `language_switcher_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `currency_switcher_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `header_contact_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `header_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_position` enum('top','main','right') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'top',
  `mobile_menu_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `mobile_search_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `mobile_cart_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `header_settings_store_id_index` (`store_id`),
  CONSTRAINT `header_settings_chk_1` CHECK (json_valid(`menu_items`))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `header_settings`
--

/*!40000 ALTER TABLE `header_settings` DISABLE KEYS */;
INSERT INTO `header_settings` VALUES (1,1,1,'Tajawal',1,1,1,1,NULL,'default',80,1,NULL,NULL,150,50,'left','rounded-lg',0,NULL,'gray-500','50',1,1,5,1,1,5,NULL,1,1,0,0,0,0,0,NULL,NULL,'top',1,1,1,'2025-10-24 09:04:44','2025-10-24 09:04:44');
/*!40000 ALTER TABLE `header_settings` ENABLE KEYS */;

--
-- Table structure for table `home_page`
--

DROP TABLE IF EXISTS `home_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_page` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_description` text COLLATE utf8mb4_unicode_ci,
  `store_logo` json DEFAULT NULL,
  `hero_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `hero_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_button1_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_button1_link` text COLLATE utf8mb4_unicode_ci,
  `hero_button2_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_button2_link` text COLLATE utf8mb4_unicode_ci,
  `hero_background_image` json DEFAULT NULL,
  `categories_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `categories_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `categories_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `featured_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `featured_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured_count` int NOT NULL DEFAULT '4',
  `featured_products` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `brand_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `brand_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_count` int NOT NULL DEFAULT '6',
  `brand_products` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `services_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `services_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `services_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `reviews_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `reviews_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reviews_count` int NOT NULL DEFAULT '3',
  `reviews_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `location_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `location_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_hours` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_map_image` json DEFAULT NULL,
  `footer_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `footer_description` text COLLATE utf8mb4_unicode_ci,
  `footer_quick_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `footer_payment_methods` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `footer_social_media` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `footer_copyright` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_background_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#1e293b',
  `footer_text_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#d1d5db',
  `footer_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_address` text COLLATE utf8mb4_unicode_ci,
  `footer_social_media_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `footer_payment_methods_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `footer_categories_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `primary_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#00e5bb',
  `background_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#0f172a',
  `text_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#ffffff',
  `secondary_text_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#94a3b8',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `home_page_store_id_index` (`store_id`),
  CONSTRAINT `home_page_chk_1` CHECK (json_valid(`categories_data`)),
  CONSTRAINT `home_page_chk_2` CHECK (json_valid(`featured_products`)),
  CONSTRAINT `home_page_chk_3` CHECK (json_valid(`brand_products`)),
  CONSTRAINT `home_page_chk_4` CHECK (json_valid(`services_data`)),
  CONSTRAINT `home_page_chk_5` CHECK (json_valid(`reviews_data`)),
  CONSTRAINT `home_page_chk_6` CHECK (json_valid(`footer_quick_links`)),
  CONSTRAINT `home_page_chk_7` CHECK (json_valid(`footer_payment_methods`)),
  CONSTRAINT `home_page_chk_8` CHECK (json_valid(`footer_social_media`))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_page`
--

/*!40000 ALTER TABLE `home_page` DISABLE KEYS */;
INSERT INTO `home_page` VALUES (1,1,'متجر إلكتروني','متجرك الإلكتروني المتخصص في بيع أحدث المنتجات التقنية والإلكترونية',NULL,1,'اكتشف أحدث المنتجات التقنية','تسوق من مجموعة واسعة من الهواتف الذكية والأجهزة الإلكترونية بأفضل الأسعار','تسوق الآن','/products','تصفح الفئات','/categories',NULL,1,'تصفح حسب الفئة','[{\"id\":null,\"name\":\"\\u0627\\u0644\\u0647\\u0648\\u0627\\u062a\\u0641 \\u0627\\u0644\\u0630\\u0643\\u064a\\u0629\",\"icon\":\"ri-smartphone-line\",\"count\":0},{\"id\":null,\"name\":\"\\u0623\\u062c\\u0647\\u0632\\u0629 \\u0627\\u0644\\u0643\\u0645\\u0628\\u064a\\u0648\\u062a\\u0631\",\"icon\":\"ri-computer-line\",\"count\":0},{\"id\":null,\"name\":\"\\u0627\\u0644\\u0633\\u0627\\u0639\\u0627\\u062a \\u0627\\u0644\\u0630\\u0643\\u064a\\u0629\",\"icon\":\"ri-watch-line\",\"count\":0},{\"id\":null,\"name\":\"\\u0627\\u0644\\u0633\\u0645\\u0627\\u0639\\u0627\\u062a\",\"icon\":\"ri-headphone-line\",\"count\":0}]',1,'المنتجات المميزة',4,'[]',1,'المنتجات المميزة',4,'[]',1,'خدماتنا','[{\"title\":\"\\u0634\\u062d\\u0646 \\u0633\\u0631\\u064a\\u0639\",\"description\":\"\\u062a\\u0648\\u0635\\u064a\\u0644 \\u0633\\u0631\\u064a\\u0639 \\u062e\\u0644\\u0627\\u0644 24 \\u0633\\u0627\\u0639\\u0629\",\"icon\":\"ri-truck-line\"},{\"title\":\"\\u0636\\u0645\\u0627\\u0646 \\u0634\\u0627\\u0645\\u0644\",\"description\":\"\\u0636\\u0645\\u0627\\u0646 \\u0639\\u0644\\u0649 \\u062c\\u0645\\u064a\\u0639 \\u0627\\u0644\\u0645\\u0646\\u062a\\u062c\\u0627\\u062a\",\"icon\":\"ri-shield-check-line\"},{\"title\":\"\\u062f\\u0639\\u0645 \\u0641\\u0646\\u064a\",\"description\":\"\\u062f\\u0639\\u0645 \\u0641\\u0646\\u064a \\u0645\\u062a\\u0627\\u062d 24\\/7\",\"icon\":\"ri-customer-service-line\"},{\"title\":\"\\u062f\\u0641\\u0639 \\u0622\\u0645\\u0646\",\"description\":\"\\u0637\\u0631\\u0642 \\u062f\\u0641\\u0639 \\u0645\\u062a\\u0639\\u062f\\u062f\\u0629 \\u0648\\u0622\\u0645\\u0646\\u0629\",\"icon\":\"ri-money-dollar-circle-line\"}]',1,'آراء العملاء',3,'[{\"name\":\"\\u0623\\u062d\\u0645\\u062f \\u0645\\u062d\\u0645\\u062f\",\"city\":\"\\u0627\\u0644\\u0631\\u064a\\u0627\\u0636\",\"text\":\"\\u062e\\u062f\\u0645\\u0629 \\u0645\\u0645\\u062a\\u0627\\u0632\\u0629 \\u0648\\u0645\\u0646\\u062a\\u062c\\u0627\\u062a \\u0639\\u0627\\u0644\\u064a\\u0629 \\u0627\\u0644\\u062c\\u0648\\u062f\\u0629. \\u0623\\u0646\\u0635\\u062d \\u0628\\u0627\\u0644\\u062a\\u0639\\u0627\\u0645\\u0644 \\u0645\\u0639 \\u0647\\u0630\\u0627 \\u0627\\u0644\\u0645\\u062a\\u062c\\u0631.\",\"rating\":5},{\"name\":\"\\u0641\\u0627\\u0637\\u0645\\u0629 \\u0639\\u0644\\u064a\",\"city\":\"\\u062c\\u062f\\u0629\",\"text\":\"\\u062a\\u062c\\u0631\\u0628\\u0629 \\u062a\\u0633\\u0648\\u0642 \\u0631\\u0627\\u0626\\u0639\\u0629 \\u0648\\u062a\\u0648\\u0635\\u064a\\u0644 \\u0633\\u0631\\u064a\\u0639. \\u0634\\u0643\\u0631\\u0627\\u064b \\u0644\\u0643\\u0645.\",\"rating\":5},{\"name\":\"\\u0645\\u062d\\u0645\\u062f \\u0627\\u0644\\u0633\\u0639\\u064a\\u062f\",\"city\":\"\\u0627\\u0644\\u062f\\u0645\\u0627\\u0645\",\"text\":\"\\u0623\\u0633\\u0639\\u0627\\u0631 \\u0645\\u0646\\u0627\\u0641\\u0633\\u0629 \\u0648\\u062c\\u0648\\u062f\\u0629 \\u0639\\u0627\\u0644\\u064a\\u0629. \\u0633\\u0623\\u0639\\u0648\\u062f \\u0644\\u0644\\u0634\\u0631\\u0627\\u0621 \\u0645\\u0631\\u0629 \\u0623\\u062e\\u0631\\u0649.\",\"rating\":4}]',1,'موقعنا','الرياض، المملكة العربية السعودية','+966 50 123 4567','info@store.com','السبت - الخميس: 9:00 ص - 10:00 م',NULL,1,'متجرك الإلكتروني الموثوق للحصول على أحدث المنتجات التقنية بأفضل الأسعار وأعلى جودة.','[{\"name\":\"\\u0645\\u0646 \\u0646\\u062d\\u0646\",\"url\":\"\\/about\"},{\"name\":\"\\u0627\\u062a\\u0635\\u0644 \\u0628\\u0646\\u0627\",\"url\":\"\\/contact\"},{\"name\":\"\\u0633\\u064a\\u0627\\u0633\\u0629 \\u0627\\u0644\\u062e\\u0635\\u0648\\u0635\\u064a\\u0629\",\"url\":\"\\/privacy\"},{\"name\":\"\\u0634\\u0631\\u0648\\u0637 \\u0627\\u0644\\u0627\\u0633\\u062a\\u062e\\u062f\\u0627\\u0645\",\"url\":\"\\/terms\"}]','[\"ri-visa-fill\",\"ri-mastercard-fill\",\"ri-paypal-fill\",\"ri-apple-fill\"]','[{\"icon\":\"ri-twitter-fill\",\"url\":\"#\"},{\"icon\":\"ri-facebook-fill\",\"url\":\"#\"},{\"icon\":\"ri-instagram-fill\",\"url\":\"#\"},{\"icon\":\"ri-youtube-fill\",\"url\":\"#\"}]','© 2024 جميع الحقوق محفوظة','#1e293b','#d1d5db',NULL,NULL,NULL,1,0,0,'#00e5bb','#0f172a','#ffffff','#94a3b8','2025-10-24 09:04:44','2025-10-24 09:04:44');
/*!40000 ALTER TABLE `home_page` ENABLE KEYS */;

--
-- Table structure for table `home_section_settings`
--

DROP TABLE IF EXISTS `home_section_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_section_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `home_section_settings_key_unique` (`key`),
  CONSTRAINT `home_section_settings_chk_1` CHECK (json_valid(`content`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_section_settings`
--

/*!40000 ALTER TABLE `home_section_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `home_section_settings` ENABLE KEYS */;

--
-- Table structure for table `home_sections`
--

DROP TABLE IF EXISTS `home_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned NOT NULL DEFAULT '1',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `home_sections_category_id_foreign` (`category_id`),
  KEY `home_sections_store_id_is_active_index` (`store_id`,`is_active`),
  CONSTRAINT `home_sections_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `home_sections_chk_1` CHECK (json_valid(`settings`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_sections`
--

/*!40000 ALTER TABLE `home_sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `home_sections` ENABLE KEYS */;

--
-- Table structure for table `home_sliders`
--

DROP TABLE IF EXISTS `home_sliders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_sliders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_button_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_sliders`
--

/*!40000 ALTER TABLE `home_sliders` DISABLE KEYS */;
/*!40000 ALTER TABLE `home_sliders` ENABLE KEYS */;

--
-- Table structure for table `menu_links`
--

DROP TABLE IF EXISTS `menu_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_links` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'quick_links',
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_links`
--

/*!40000 ALTER TABLE `menu_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu_links` ENABLE KEYS */;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `svg` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `tailwind_code` text COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2025_05_07_100257_add_type_and_digital_codes_to_products_table',1),(2,'2025_05_07_101904_add_price_options_to_products_table',2),(3,'2025_05_07_141858_add_seo_fields_to_products_table',3),(4,'2025_05_07_144517_change_meta_keywords_column_type_to_text',4),(5,'2025_05_08_022627_add_credentials_and_settings_to_payment_methods_table',5),(6,'2023_06_01_update_clickpay_credentials',6),(7,'2025_05_08_030000_add_mode_column_to_payment_methods_table',7),(8,'2025_05_08_031949_add_fee_fields_to_payment_methods',8),(9,'2024_06_01_create_home_sections_table',9),(10,'2023_06_01_rename_whats_app_templates_table',10),(11,'2025_05_10_125524_create_menu_links_table',11),(12,'2025_05_11_000001_add_is_rated_to_order_items_table',12),(13,'2024_07_01_000000_create_site_reviews_table',13),(14,'2024_01_01_000000_create_home_sections_table',14),(16,'2025_05_11_140315_rename_section_key_to_key',15),(17,'2024_XX_XX_XXXXXX_add_product_note_to_products_table',16),(18,'2023_01_01_create_whats_app_templates_table',17),(19,'2024_01_01_000000_create_coupon_page_settings_table',18),(20,'2024_03_19_000001_add_user_journey_to_online_users',19),(21,'2025_01_16_100000_add_missing_columns_to_categories_table',20),(22,'2025_01_16_100001_add_missing_columns_to_products_table',21),(23,'2025_01_16_100002_add_missing_columns_to_users_table',22),(24,'2025_01_16_100003_add_missing_columns_to_orders_table',23),(25,'2025_01_16_100004_add_missing_columns_to_coupons_table',24),(26,'2025_01_16_100005_add_missing_columns_to_reviews_table',25),(27,'2025_01_16_100006_add_missing_columns_to_site_reviews_table',26),(28,'2025_01_18_000000_fix_categories_table_schema',27),(29,'2025_05_07_135928_allow_null_digital_card_id',28),(30,'2025_05_09_154324_add_phone_to_users_table',29),(31,'2025_05_10_000002_add_unique_constraint_to_sku',30),(32,'2025_05_15_135604_add_order_token_to_orders_table',31),(33,'2025_05_16_000001_add_unique_constraint_to_digital_card_codes_table',32),(34,'2025_05_25_154253_create_theme_settings_table',33),(35,'2025_06_10_105844_create_zain_theme_settings_table',34),(36,'2025_06_10_105853_create_zain_theme_colors_table',35),(37,'2025_06_10_110023_create_zain_theme_sections_table',36),(38,'2025_06_10_110041_create_zain_theme_products_table',37),(39,'2025_06_10_110051_create_zain_theme_media_table',38),(40,'2025_06_13_130945_add_coupon_columns_to_products_table',39),(41,'2025_06_13_134716_add_category_to_coupons_table',40),(42,'2025_06_10_123935_create_home_page_table',41),(43,'2025_06_15_113411_add_missing_footer_columns_to_home_page_table',42),(44,'2025_06_15_130922_create_theme_links_table',43),(45,'2025_06_15_155556_add_footer_section_toggles_to_home_page_table',44),(46,'2025_06_18_143604_create_header_settings_table',45),(47,'2025_06_18_144837_add_store_id_to_header_settings_table',46),(48,'2025_06_18_170918_update_header_settings_shadow_colors',47),(49,'2025_06_12_141157_create_menus_table',48),(50,'2025_06_18_181358_modify_menus_table_svg_column',49),(51,'2025_06_18_184555_add_categories_count_to_header_settings_table',50),(52,'2025_06_22_134711_create_top_header_settings_table',51),(53,'2025_06_22_093151_add_header_closed_column_to_top_header_settings_table',52),(54,'2025_06_22_143536_update_top_header_settings_table_add_missing_columns',53),(55,'2025_06_23_072822_add_page_sections_to_products_page_table',54),(56,'2025_06_23_075721_add_store_id_to_products_page_table',55),(57,'2025_06_23_163440_add_main_menus_columns_to_header_settings_table',56),(58,'2025_06_23_195056_create_sessions_table',57),(59,'2025_06_10_124721_update_home_page_table_column_sizes',58),(60,'2025_06_10_142039_add_brand_section_to_home_page_table',59),(61,'2025_05_09_020411_remove_extra_columns_from_payment_methods',60),(62,'2025_05_09_111731_rename_order_to_sort_order_in_home_sections',61),(63,'2025_05_09_122534_add_default_sections_to_home_sections_table',62),(64,'2025_05_09_122545_insert_missing_sections_to_home_sections',63),(65,'2025_05_09_015002_add_credentials_to_payment_methods_table',64),(66,'2025_05_08_185526_create_payment_attempts_table',65),(67,'2025_05_08_215526_drop_payment_attempts_table',66),(69,'2025_09_21_191651_add_store_id_to_home_sections_table',67),(70,'2025_09_24_171156_add_store_id_to_custom_orders_table',68),(71,'2025_01_21_000000_create_themes_info_table',69),(72,'2025_10_25_174546_create_development_features_table',70),(73,'2024_10_25_000001_create_dms_organizations_table',71),(74,'2024_10_25_000002_create_dms_projects_table',72),(75,'2024_10_25_000003_create_dms_features_table',73),(76,'2024_10_25_000004_create_dms_feature_files_table',74),(77,'2024_10_25_000005_create_dms_feature_progress_table',75),(78,'2024_10_25_000006_create_dms_feature_dependencies_table',76);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
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

/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;

--
-- Table structure for table `online_users`
--

DROP TABLE IF EXISTS `online_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `online_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_journey` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'guest',
  `user_id` bigint unsigned DEFAULT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_id` (`session_id`),
  KEY `online_users_user_id_foreign` (`user_id`),
  CONSTRAINT `online_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `online_users_chk_1` CHECK (json_valid(`user_journey`))
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `online_users`
--

/*!40000 ALTER TABLE `online_users` DISABLE KEYS */;
INSERT INTO `online_users` VALUES (1,'izEKzRAbgo7ua5zJXNflWRpX1aIxibSpb4I07YSa','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','http://custom.com:8000/login',NULL,'guest',NULL,'2025-10-24 08:58:50','2025-10-24 08:30:53','2025-10-24 08:58:50'),(2,'OhNCf1VG4aJUUERsGM5PVYMOkhvXVrFnwysDIZSW','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','http://127.0.0.1:8000/login',NULL,'guest',NULL,'2025-10-24 08:54:52','2025-10-24 08:32:19','2025-10-24 08:54:52'),(3,'ZxlYJNwSnzetTEc4Y53CUoaItw4FzC50FCFcf8KB','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','http://127.0.0.1:8000/subscriptions/payment/12',NULL,'user',1,'2025-10-24 08:57:07','2025-10-24 08:54:55','2025-10-24 08:57:07'),(4,'Vzk19oM8YyHHuZGZq9E0KmoAmBoQatVt5GoF6R35','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','http://custom.com:8000/livewire/update',NULL,'admin',1,'2025-10-24 17:40:12','2025-10-24 08:58:52','2025-10-24 17:40:12'),(5,'NMHKnoTnXz4sUra9F6r7h2UacC9n8d8b0blPa6GW','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','http://127.0.0.1:8000/subscriptions/payment/12',NULL,'admin',1,'2025-10-24 15:42:14','2025-10-24 14:19:11','2025-10-24 15:42:14'),(6,'K3RDo5ggcFXikdmqcrmJAlOlEaQ9qtnMHVl33jUi','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','http://custom.com:8000/livewire/update',NULL,'admin',1,'2025-10-25 14:56:17','2025-10-25 14:51:34','2025-10-25 14:56:17'),(7,'PWq8YLTUCBjocdc7neJ2kazxj1RX9YJWDTYqis05','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','http://127.0.0.1:8000',NULL,'admin',1,'2025-10-25 16:14:46','2025-10-25 16:14:46','2025-10-25 16:14:46'),(8,'DjjR6NuYapPJU0iKAdNGjnJLukFfssNMnD3aeQ48','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','http://127.0.0.1:8000/dms/feature/14/graph',NULL,'admin',1,'2025-10-25 17:20:01','2025-10-25 16:14:52','2025-10-25 17:20:01'),(9,'j3DllbwWaiyBG7782YEhqXu1MppBHU7uswjTwGPk','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','http://custom.com:8000',NULL,'admin',1,'2025-10-25 17:31:12','2025-10-25 17:30:26','2025-10-25 17:31:12');
/*!40000 ALTER TABLE `online_users` ENABLE KEYS */;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `orderable_id` bigint unsigned NOT NULL,
  `orderable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int DEFAULT '1',
  `total` decimal(10,2) NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `is_rated` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_orderable_type_orderable_id_index` (`orderable_type`,`orderable_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_chk_1` CHECK (json_valid(`options`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `total` decimal(10,2) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) DEFAULT '0.00',
  `discount` decimal(10,2) DEFAULT '0.00',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `paid_at` timestamp NULL DEFAULT NULL,
  `fulfilled_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `custom_data` text COLLATE utf8mb4_unicode_ci,
  `has_custom_products` tinyint(1) DEFAULT '0',
  `order_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_published` tinyint(1) DEFAULT '1',
  `sort_order` int DEFAULT '0',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `show_in_menu` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;

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

/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_methods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `instructions` text COLLATE utf8mb4_unicode_ci,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `is_active` tinyint(1) DEFAULT '1',
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fee_percentage` decimal(10,2) DEFAULT '0.00',
  `fee_fixed` decimal(10,2) NOT NULL DEFAULT '0.00',
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `credentials` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'test',
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_methods_code_unique` (`code`),
  CONSTRAINT `payment_methods_chk_1` CHECK (json_valid(`config`)),
  CONSTRAINT `payment_methods_chk_2` CHECK (json_valid(`settings`)),
  CONSTRAINT `payment_methods_chk_3` CHECK (json_valid(`credentials`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payer_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'SAR',
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_order_id_foreign` (`order_id`),
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_chk_1` CHECK (json_valid(`payment_data`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
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

/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `has_discounts` tinyint(1) NOT NULL DEFAULT '0',
  `has_discount` tinyint(1) NOT NULL DEFAULT '0',
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `product_note` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `focus_keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` text COLLATE utf8mb4_unicode_ci,
  `seo_score` tinyint DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `stock` int DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'available',
  `is_featured` tinyint(1) DEFAULT '0',
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'account',
  `warranty_days` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `custom_fields` text COLLATE utf8mb4_unicode_ci,
  `price_options` text COLLATE utf8mb4_unicode_ci,
  `rating` float(3,1) DEFAULT NULL,
  `sales_count` int DEFAULT '0',
  `views_count` int DEFAULT '0',
  `coupon_eligible` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'يحدد ما إذا كان المنتج مؤهل لتطبيق الكوبونات عليه أم لا',
  `min_coupon_order_value` decimal(10,2) DEFAULT NULL COMMENT 'الحد الأدنى لقيمة الطلب المطلوبة لتطبيق الكوبون على هذا المنتج',
  `max_coupon_discount_amount` decimal(10,2) DEFAULT NULL COMMENT 'الحد الأقصى لمبلغ الخصم الذي يمكن تطبيقه على المنتج',
  `max_coupon_discount_percentage` decimal(5,2) DEFAULT NULL COMMENT 'أقصى نسبة خصم مسموحة على المنتج',
  `coupon_categories` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin COMMENT 'فئات الكوبونات المسموح تطبيقها على هذا المنتج',
  `allow_coupon_stacking` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'يسمح باستخدام أكثر من كوبون واحد على نفس المنتج',
  `excluded_coupon_types` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin COMMENT 'أنواع الكوبونات المستثناة من التطبيق على هذا المنتج',
  `coupon_start_date` datetime DEFAULT NULL COMMENT 'تاريخ بداية فترة استحقاق المنتج للكوبونات',
  `coupon_end_date` datetime DEFAULT NULL COMMENT 'تاريخ نهاية فترة استحقاق المنتج للكوبونات',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `share_slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_sku_index` (`sku`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_chk_1` CHECK (json_valid(`features`)),
  CONSTRAINT `products_chk_2` CHECK (json_valid(`gallery`)),
  CONSTRAINT `products_chk_3` CHECK (json_valid(`coupon_categories`)),
  CONSTRAINT `products_chk_4` CHECK (json_valid(`excluded_coupon_types`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

--
-- Table structure for table `products_page`
--

DROP TABLE IF EXISTS `products_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_page` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned NOT NULL,
  `page_header_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_image` text COLLATE utf8mb4_unicode_ci,
  `discount_timer_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `discount_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_end_date` datetime DEFAULT NULL,
  `timer_style` enum('modern','classic','minimal','bold') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'modern',
  `coupon_banner_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_background_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#ff4444',
  `layout_style` enum('grid','list') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'grid',
  `products_per_row` int NOT NULL DEFAULT '3',
  `sidebar_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `sidebar_position` enum('left','right') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'right',
  `search_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `search_placeholder` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_filter_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `category_filter_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `brand_filter_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `rating_filter_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `sort_options_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `default_sort` enum('latest','oldest','price_low','price_high','name_asc','name_desc','rating') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'latest',
  `product_card_style` enum('modern','classic','minimal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'modern',
  `product_rating_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `product_badges_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `quick_view_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `wishlist_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `products_per_page` int NOT NULL DEFAULT '12',
  `pagination_style` enum('numbers','loadmore') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'numbers',
  `primary_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#3b82f6',
  `secondary_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#6b7280',
  `accent_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#f59e0b',
  `background_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#ffffff',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_page`
--

/*!40000 ALTER TABLE `products_page` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_page` ENABLE KEYS */;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `reviewable_id` bigint unsigned NOT NULL,
  `reviewable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `is_approved` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `review` text COLLATE utf8mb4_unicode_ci,
  `order_item_id` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  KEY `reviews_reviewable_type_reviewable_id_index` (`reviewable_type`,`reviewable_id`),
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;

--
-- Table structure for table `reviews_section`
--

DROP TABLE IF EXISTS `reviews_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews_section` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'آراء العملاء',
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `display_count` int NOT NULL DEFAULT '3',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_section_store_id_index` (`store_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews_section`
--

/*!40000 ALTER TABLE `reviews_section` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews_section` ENABLE KEYS */;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'active_theme','torganic','general','2025-10-24 09:07:59','2025-10-24 09:07:59');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

--
-- Table structure for table `site_reviews`
--

DROP TABLE IF EXISTS `site_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site_reviews_user_id_foreign` (`user_id`),
  CONSTRAINT `site_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_reviews`
--

/*!40000 ALTER TABLE `site_reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `site_reviews` ENABLE KEYS */;

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sliders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sliders`
--

/*!40000 ALTER TABLE `sliders` DISABLE KEYS */;
/*!40000 ALTER TABLE `sliders` ENABLE KEYS */;

--
-- Table structure for table `static_pages`
--

DROP TABLE IF EXISTS `static_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `static_pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `static_pages_slug_unique` (`slug`),
  KEY `static_pages_store_id_foreign` (`store_id`),
  CONSTRAINT `static_pages_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `static_pages`
--

/*!40000 ALTER TABLE `static_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `static_pages` ENABLE KEYS */;

--
-- Table structure for table `subscription_plans`
--

DROP TABLE IF EXISTS `subscription_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscription_plans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration_days` int NOT NULL,
  `duration_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `max_products` int DEFAULT NULL,
  `max_orders` int DEFAULT NULL,
  `commission_rate` decimal(5,2) NOT NULL DEFAULT '0.00',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscription_plans_slug_unique` (`slug`),
  CONSTRAINT `subscription_plans_chk_1` CHECK (json_valid(`features`))
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription_plans`
--

/*!40000 ALTER TABLE `subscription_plans` DISABLE KEYS */;
INSERT INTO `subscription_plans` VALUES (4,'الخطة الشهرية','monthly-plan','خطة مثالية للمتاجر الصغيرة والمتوسطة مع جميع المميزات الأساسية',99.00,30,'monthly','[\"\\u0644\\u0648\\u062d\\u0629 \\u062a\\u062d\\u0643\\u0645 \\u0645\\u062a\\u0643\\u0627\\u0645\\u0644\\u0629\",\"\\u062f\\u0639\\u0645 \\u0641\\u0646\\u064a \\u0639\\u0644\\u0649 \\u0645\\u062f\\u0627\\u0631 \\u0627\\u0644\\u0633\\u0627\\u0639\\u0629\",\"\\u0625\\u062d\\u0635\\u0627\\u0626\\u064a\\u0627\\u062a \\u0645\\u0641\\u0635\\u0644\\u0629\",\"\\u062a\\u062e\\u0635\\u064a\\u0635 \\u0627\\u0644\\u0623\\u0644\\u0648\\u0627\\u0646 \\u0648\\u0627\\u0644\\u0634\\u0639\\u0627\\u0631\",\"\\u062d\\u062a\\u0649 5 \\u0637\\u0631\\u0642 \\u062f\\u0641\\u0639\",\"\\u0646\\u0633\\u062e \\u0627\\u062d\\u062a\\u064a\\u0627\\u0637\\u064a \\u064a\\u0648\\u0645\\u064a\"]',100,500,2.50,1,0,1,'2025-10-22 13:35:57','2025-10-22 13:35:57'),(5,'خطة 6 أشهر','semi-annual-plan','خطة اقتصادية للمتاجر الطموحة مع خصم 15% وميزات إضافية',499.00,180,'semi_annual','[\"\\u062c\\u0645\\u064a\\u0639 \\u0645\\u0645\\u064a\\u0632\\u0627\\u062a \\u0627\\u0644\\u062e\\u0637\\u0629 \\u0627\\u0644\\u0634\\u0647\\u0631\\u064a\\u0629\",\"\\u062e\\u0635\\u0645 15% \\u0639\\u0644\\u0649 \\u0627\\u0644\\u0633\\u0639\\u0631 \\u0627\\u0644\\u0625\\u062c\\u0645\\u0627\\u0644\\u064a\",\"\\u062a\\u0637\\u0628\\u064a\\u0642 \\u062c\\u0648\\u0627\\u0644 \\u0645\\u062e\\u0635\\u0635\",\"\\u062a\\u0642\\u0627\\u0631\\u064a\\u0631 \\u0645\\u062a\\u0642\\u062f\\u0645\\u0629\",\"\\u062f\\u0639\\u0645 \\u0639\\u0628\\u0631 \\u0648\\u0627\\u062a\\u0633\\u0627\\u0628\",\"\\u062a\\u062f\\u0631\\u064a\\u0628 \\u0645\\u062c\\u0627\\u0646\\u064a \\u0639\\u0644\\u0649 \\u0627\\u0644\\u0646\\u0638\\u0627\\u0645\",\"\\u0637\\u0631\\u0642 \\u062f\\u0641\\u0639 \\u063a\\u064a\\u0631 \\u0645\\u062d\\u062f\\u0648\\u062f\\u0629\",\"\\u062f\\u0648\\u0645\\u064a\\u0646 \\u0641\\u0631\\u0639\\u064a \\u0645\\u062c\\u0627\\u0646\\u064a\"]',500,2000,2.00,1,1,2,'2025-10-22 13:35:57','2025-10-22 13:35:57'),(6,'الخطة السنوية','annual-plan','الخيار الأمثل للمتاجر الكبيرة مع خصم 25% وجميع المميزات المتقدمة',899.00,365,'annual','[\"\\u062c\\u0645\\u064a\\u0639 \\u0645\\u0645\\u064a\\u0632\\u0627\\u062a \\u0627\\u0644\\u062e\\u0637\\u0637 \\u0627\\u0644\\u0633\\u0627\\u0628\\u0642\\u0629\",\"\\u062e\\u0635\\u0645 25% \\u0639\\u0644\\u0649 \\u0627\\u0644\\u0633\\u0639\\u0631 \\u0627\\u0644\\u0625\\u062c\\u0645\\u0627\\u0644\\u064a\",\"\\u062f\\u0648\\u0645\\u064a\\u0646 \\u0645\\u062e\\u0635\\u0635 \\u0645\\u062c\\u0627\\u0646\\u064a\",\"\\u0645\\u062f\\u064a\\u0631 \\u062d\\u0633\\u0627\\u0628 \\u0645\\u062e\\u0635\\u0635\",\"\\u062a\\u0635\\u0645\\u064a\\u0645 \\u0645\\u062a\\u062c\\u0631 \\u0645\\u062e\\u0635\\u0635\",\"\\u062a\\u0643\\u0627\\u0645\\u0644 \\u0645\\u0639 \\u0623\\u0646\\u0638\\u0645\\u0629 \\u0627\\u0644\\u0645\\u062d\\u0627\\u0633\\u0628\\u0629\",\"API \\u0645\\u062a\\u0642\\u062f\\u0645 \\u0644\\u0644\\u062a\\u0643\\u0627\\u0645\\u0644\",\"\\u0623\\u0648\\u0644\\u0648\\u064a\\u0629 \\u0641\\u064a \\u0627\\u0644\\u062f\\u0639\\u0645 \\u0627\\u0644\\u0641\\u0646\\u064a\",\"\\u0627\\u0633\\u062a\\u0634\\u0627\\u0631\\u0629 \\u062a\\u0633\\u0648\\u064a\\u0642\\u064a\\u0629 \\u0645\\u062c\\u0627\\u0646\\u064a\\u0629\"]',NULL,NULL,1.50,1,0,3,'2025-10-22 13:35:57','2025-10-22 13:35:57'),(7,'الخطة المجانية','free-plan','خطة مجانية للبدء مع مميزات أساسية محدودة',0.00,30,'monthly','[\"\\u0644\\u0648\\u062d\\u0629 \\u062a\\u062d\\u0643\\u0645 \\u0623\\u0633\\u0627\\u0633\\u064a\\u0629\",\"\\u062f\\u0639\\u0645 \\u0641\\u0646\\u064a \\u0639\\u0628\\u0631 \\u0627\\u0644\\u0628\\u0631\\u064a\\u062f \\u0627\\u0644\\u0625\\u0644\\u0643\\u062a\\u0631\\u0648\\u0646\\u064a\",\"\\u0625\\u062d\\u0635\\u0627\\u0626\\u064a\\u0627\\u062a \\u0623\\u0633\\u0627\\u0633\\u064a\\u0629\",\"\\u062a\\u062e\\u0635\\u064a\\u0635 \\u0627\\u0644\\u0623\\u0644\\u0648\\u0627\\u0646 \\u0627\\u0644\\u0623\\u0633\\u0627\\u0633\\u064a\\u0629\",\"\\u0637\\u0631\\u064a\\u0642\\u0629 \\u062f\\u0641\\u0639 \\u0648\\u0627\\u062d\\u062f\\u0629\",\"\\u0646\\u0633\\u062e \\u0627\\u062d\\u062a\\u064a\\u0627\\u0637\\u064a \\u0623\\u0633\\u0628\\u0648\\u0639\\u064a\"]',10,50,5.00,1,0,0,'2025-10-22 13:35:58','2025-10-22 13:35:58'),(8,'خطة الشركات','enterprise-plan','خطة متقدمة للشركات الكبيرة مع جميع المميزات المتقدمة والدعم المخصص',1999.00,365,'annual','[\"\\u062c\\u0645\\u064a\\u0639 \\u0645\\u0645\\u064a\\u0632\\u0627\\u062a \\u0627\\u0644\\u062e\\u0637\\u0629 \\u0627\\u0644\\u0633\\u0646\\u0648\\u064a\\u0629\",\"\\u062f\\u0639\\u0645 \\u0641\\u0646\\u064a \\u0645\\u062e\\u0635\\u0635 24\\/7\",\"\\u0645\\u062f\\u064a\\u0631 \\u0645\\u0634\\u0631\\u0648\\u0639 \\u0645\\u062e\\u0635\\u0635\",\"\\u062a\\u0643\\u0627\\u0645\\u0644 \\u0645\\u0639 \\u0623\\u0646\\u0638\\u0645\\u0629 ERP\",\"API \\u063a\\u064a\\u0631 \\u0645\\u062d\\u062f\\u0648\\u062f\",\"\\u062a\\u0642\\u0627\\u0631\\u064a\\u0631 \\u0645\\u062e\\u0635\\u0635\\u0629\",\"\\u062a\\u062f\\u0631\\u064a\\u0628 \\u0641\\u0631\\u064a\\u0642 \\u0643\\u0627\\u0645\\u0644\",\"\\u0636\\u0645\\u0627\\u0646 SLA 99.9%\",\"\\u0646\\u0633\\u062e \\u0627\\u062d\\u062a\\u064a\\u0627\\u0637\\u064a \\u0643\\u0644 \\u0633\\u0627\\u0639\\u0629\",\"\\u0623\\u0645\\u0627\\u0646 \\u0645\\u062a\\u0642\\u062f\\u0645\",\"\\u062f\\u0639\\u0645 \\u0645\\u062a\\u0639\\u062f\\u062f \\u0627\\u0644\\u0644\\u063a\\u0627\\u062a\"]',NULL,NULL,1.00,1,1,4,'2025-10-22 13:35:58','2025-10-22 13:35:58'),(9,'خطة المطورين','developer-plan','خطة مخصصة للمطورين والوكالات مع أدوات التطوير المتقدمة',299.00,30,'monthly','[\"\\u062c\\u0645\\u064a\\u0639 \\u0645\\u0645\\u064a\\u0632\\u0627\\u062a \\u0627\\u0644\\u062e\\u0637\\u0629 \\u0627\\u0644\\u0634\\u0647\\u0631\\u064a\\u0629\",\"API \\u0645\\u062a\\u0642\\u062f\\u0645 \\u0644\\u0644\\u062a\\u0637\\u0648\\u064a\\u0631\",\"\\u0623\\u062f\\u0648\\u0627\\u062a \\u0627\\u0644\\u062a\\u0637\\u0648\\u064a\\u0631 \\u0648\\u0627\\u0644\\u062a\\u0634\\u062e\\u064a\\u0635\",\"\\u062f\\u0639\\u0645 \\u062a\\u0642\\u0646\\u064a \\u0645\\u062a\\u062e\\u0635\\u0635\",\"\\u0648\\u0635\\u0648\\u0644 \\u0625\\u0644\\u0649 \\u0627\\u0644\\u0643\\u0648\\u062f \\u0627\\u0644\\u0645\\u0635\\u062f\\u0631\\u064a\",\"\\u062a\\u0643\\u0627\\u0645\\u0644 \\u0645\\u0639 Git\",\"\\u0627\\u062e\\u062a\\u0628\\u0627\\u0631\\u0627\\u062a \\u0622\\u0644\\u064a\\u0629\",\"\\u062a\\u0648\\u062b\\u064a\\u0642 API \\u0634\\u0627\\u0645\\u0644\",\"\\u0623\\u062f\\u0648\\u0627\\u062a \\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639\",\"\\u062f\\u0639\\u0645 \\u0645\\u062a\\u0639\\u062f\\u062f \\u0627\\u0644\\u0639\\u0645\\u0644\\u0627\\u0621\"]',1000,5000,2.00,1,0,5,'2025-10-22 13:35:58','2025-10-22 13:35:58'),(10,'خطة التجريبية','trial-plan','خطة تجريبية لمدة أسبوعين لاختبار جميع المميزات',0.00,14,'trial','[\"\\u062c\\u0645\\u064a\\u0639 \\u0645\\u0645\\u064a\\u0632\\u0627\\u062a \\u0627\\u0644\\u062e\\u0637\\u0629 \\u0627\\u0644\\u0634\\u0647\\u0631\\u064a\\u0629\",\"\\u062f\\u0639\\u0645 \\u0641\\u0646\\u064a \\u0643\\u0627\\u0645\\u0644\",\"\\u0648\\u0635\\u0648\\u0644 \\u0625\\u0644\\u0649 \\u062c\\u0645\\u064a\\u0639 \\u0627\\u0644\\u0623\\u062f\\u0648\\u0627\\u062a\",\"\\u0644\\u0627 \\u062a\\u0648\\u062c\\u062f \\u0642\\u064a\\u0648\\u062f \\u0639\\u0644\\u0649 \\u0627\\u0644\\u0645\\u0646\\u062a\\u062c\\u0627\\u062a\",\"\\u0644\\u0627 \\u062a\\u0648\\u062c\\u062f \\u0642\\u064a\\u0648\\u062f \\u0639\\u0644\\u0649 \\u0627\\u0644\\u0637\\u0644\\u0628\\u0627\\u062a\",\"\\u0625\\u0645\\u0643\\u0627\\u0646\\u064a\\u0629 \\u0627\\u0644\\u062a\\u0631\\u0642\\u064a\\u0629 \\u0641\\u064a \\u0623\\u064a \\u0648\\u0642\\u062a\"]',NULL,NULL,0.00,1,0,6,'2025-10-22 13:35:58','2025-10-22 13:35:58');
/*!40000 ALTER TABLE `subscription_plans` ENABLE KEYS */;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `subscription_plan_id` bigint unsigned NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subscription_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `starts_at` timestamp NOT NULL,
  `ends_at` timestamp NOT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_subscription_plan_id_foreign` (`subscription_plan_id`),
  KEY `subscriptions_user_id_status_index` (`user_id`,`status`),
  KEY `subscriptions_ends_at_status_index` (`ends_at`,`status`),
  KEY `subscriptions_subscription_token_index` (`subscription_token`),
  CONSTRAINT `subscriptions_subscription_plan_id_foreign` FOREIGN KEY (`subscription_plan_id`) REFERENCES `subscription_plans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subscriptions_chk_1` CHECK (json_valid(`metadata`))
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
INSERT INTO `subscriptions` VALUES (9,37,10,'pending',0.00,NULL,NULL,NULL,'2025-10-22 13:45:02','2025-11-05 13:45:02',NULL,NULL,NULL,'2025-10-22 13:45:02','2025-10-22 13:45:02'),(10,37,10,'pending',0.00,NULL,NULL,NULL,'2025-10-22 13:45:44','2025-11-05 13:45:44',NULL,NULL,NULL,'2025-10-22 13:45:44','2025-10-22 13:45:44'),(11,1,8,'pending',1999.00,NULL,NULL,NULL,'2025-10-24 08:55:09','2026-10-24 08:55:09',NULL,NULL,NULL,'2025-10-24 08:55:09','2025-10-24 08:55:09'),(12,1,8,'pending',1999.00,NULL,NULL,NULL,'2025-10-24 08:56:33','2026-10-24 08:56:33',NULL,NULL,NULL,'2025-10-24 08:56:33','2025-10-24 08:56:33');
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;

--
-- Table structure for table `support_ticket_replies`
--

DROP TABLE IF EXISTS `support_ticket_replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_ticket_replies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `support_ticket_replies_ticket_id_foreign` (`ticket_id`),
  KEY `support_ticket_replies_user_id_foreign` (`user_id`),
  CONSTRAINT `support_ticket_replies_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `support_tickets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `support_ticket_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_ticket_replies`
--

/*!40000 ALTER TABLE `support_ticket_replies` DISABLE KEYS */;
/*!40000 ALTER TABLE `support_ticket_replies` ENABLE KEYS */;

--
-- Table structure for table `support_tickets`
--

DROP TABLE IF EXISTS `support_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_tickets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'medium',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'open',
  `closed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `support_tickets_user_id_foreign` (`user_id`),
  CONSTRAINT `support_tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_tickets`
--

/*!40000 ALTER TABLE `support_tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `support_tickets` ENABLE KEYS */;

--
-- Table structure for table `theme_links`
--

DROP TABLE IF EXISTS `theme_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `theme_links` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Theme name identifier',
  `links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'JSON object containing all theme links with their icons and routes',
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Whether this theme is currently active',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT 'Optional description of the theme',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `theme_links_name_unique` (`name`),
  KEY `theme_links_name_index` (`name`),
  KEY `theme_links_is_active_index` (`is_active`),
  CONSTRAINT `theme_links_chk_1` CHECK (json_valid(`links`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `theme_links`
--

/*!40000 ALTER TABLE `theme_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `theme_links` ENABLE KEYS */;

--
-- Table structure for table `theme_settings`
--

DROP TABLE IF EXISTS `theme_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `theme_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `theme_settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `theme_settings`
--

/*!40000 ALTER TABLE `theme_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `theme_settings` ENABLE KEYS */;

--
-- Table structure for table `themes_data`
--

DROP TABLE IF EXISTS `themes_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `themes_data` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `theme_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hero_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin COMMENT 'Hero section images and data',
  `banner_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin COMMENT 'Banner images and data',
  `feature_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin COMMENT 'Feature section data',
  `sections_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin COMMENT 'All theme sections data (banners, features, etc.)',
  `extra_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin COMMENT 'Additional theme images',
  `custom_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin COMMENT 'Other custom theme data',
  `custom_css` text COLLATE utf8mb4_unicode_ci COMMENT 'Custom CSS for this theme',
  `custom_js` text COLLATE utf8mb4_unicode_ci COMMENT 'Custom JS for this theme',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `themes_data_store_id_theme_name_unique` (`store_id`,`theme_name`),
  KEY `themes_data_store_id_index` (`store_id`),
  KEY `themes_data_theme_name_index` (`theme_name`),
  KEY `themes_data_store_id_theme_name_index` (`store_id`,`theme_name`),
  CONSTRAINT `themes_data_chk_1` CHECK (json_valid(`hero_data`)),
  CONSTRAINT `themes_data_chk_2` CHECK (json_valid(`banner_data`)),
  CONSTRAINT `themes_data_chk_3` CHECK (json_valid(`feature_data`)),
  CONSTRAINT `themes_data_chk_4` CHECK (json_valid(`sections_data`)),
  CONSTRAINT `themes_data_chk_5` CHECK (json_valid(`extra_images`)),
  CONSTRAINT `themes_data_chk_6` CHECK (json_valid(`custom_data`))
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `themes_data`
--

/*!40000 ALTER TABLE `themes_data` DISABLE KEYS */;
INSERT INTO `themes_data` VALUES (15,36,'torganic','{\"slides\":[]}','{\"title\":\"\",\"description\":\"\",\"link\":\"\"}',NULL,'{\"section1\":{\"name\":\"firstSection\",\"is_active\":true},\"section2\":{\"name\":\"secondSection\",\"is_active\":true},\"section3\":{\"name\":\"thirdSection\",\"is_active\":true},\"section4\":{\"name\":\"fourthSection\",\"is_active\":true},\"section5\":{\"name\":\"fifthSection\",\"is_active\":true},\"section6\":{\"name\":\"sixthSection\",\"is_active\":true},\"section7\":{\"name\":\"seventhSection\",\"is_active\":true},\"section8\":{\"name\":\"eighthSection\",\"is_active\":true},\"section9\":{\"name\":\"ninthSection\",\"is_active\":true},\"section10\":{\"name\":\"tenthSection\",\"is_active\":true}}',NULL,'[]','','',1,'2025-10-23 11:23:31','2025-10-24 17:40:12'),(16,36,'greenGame',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-10-23 12:49:40','2025-10-24 09:07:59');
/*!40000 ALTER TABLE `themes_data` ENABLE KEYS */;

--
-- Table structure for table `themes_info`
--

DROP TABLE IF EXISTS `themes_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `themes_info` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Theme name',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Theme slug for URLs',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT 'Theme description',
  `price` decimal(10,2) DEFAULT NULL COMMENT 'Theme price',
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD' COMMENT 'Currency code',
  `screenshot_image` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Main screenshot image path',
  `links` json DEFAULT NULL COMMENT 'Theme links (demo, download, documentation, etc.)',
  `images` json DEFAULT NULL COMMENT 'Array of up to 30 images with order, size, and metadata',
  `version` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Theme version',
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Theme author/developer',
  `features` text COLLATE utf8mb4_unicode_ci COMMENT 'Theme features list',
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Theme category',
  `tags` json DEFAULT NULL COMMENT 'Theme tags',
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active' COMMENT 'Theme status (active, inactive, draft)',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Is featured theme',
  `is_premium` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Is premium theme',
  `downloads_count` int NOT NULL DEFAULT '0' COMMENT 'Number of downloads',
  `views_count` int NOT NULL DEFAULT '0' COMMENT 'Number of views',
  `rating` double(3,1) DEFAULT NULL COMMENT 'Theme rating',
  `reviews_count` int NOT NULL DEFAULT '0' COMMENT 'Number of reviews',
  `release_date` date DEFAULT NULL COMMENT 'Theme release date',
  `last_updated` date DEFAULT NULL COMMENT 'Last update date',
  `requirements` text COLLATE utf8mb4_unicode_ci COMMENT 'System requirements',
  `installation_notes` text COLLATE utf8mb4_unicode_ci COMMENT 'Installation instructions',
  `custom_data` json DEFAULT NULL COMMENT 'Additional custom data',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `themes_info_slug_unique` (`slug`),
  KEY `themes_info_name_index` (`name`),
  KEY `themes_info_slug_index` (`slug`),
  KEY `themes_info_category_index` (`category`),
  KEY `themes_info_status_index` (`status`),
  KEY `themes_info_is_featured_index` (`is_featured`),
  KEY `themes_info_is_premium_index` (`is_premium`),
  KEY `themes_info_author_index` (`author`),
  KEY `themes_info_release_date_index` (`release_date`),
  KEY `themes_info_status_is_featured_index` (`status`,`is_featured`),
  KEY `themes_info_category_status_index` (`category`,`status`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `themes_info`
--

/*!40000 ALTER TABLE `themes_info` DISABLE KEYS */;
INSERT INTO `themes_info` VALUES (1,'Torganic','torganic','A modern, responsive e-commerce theme designed for organic and natural product stores. Features clean design, mobile-first approach, and optimized for conversions.',89.99,'USD','/themes/torganic/screenshot.jpg','{\"demo\": \"https://demo.torganic.com\", \"support\": \"https://support.torganic.com\", \"download\": \"https://themeforest.net/item/torganic/12345678\", \"changelog\": \"https://torganic.com/changelog\", \"documentation\": \"https://docs.torganic.com\"}','[{\"alt\": \"Torganic Homepage Desktop View\", \"path\": \"/themes/torganic/images/homepage-desktop.jpg\", \"size\": \"385x400\", \"type\": \"desktop\", \"order\": 1, \"description\": \"Main homepage layout on desktop\"}, {\"alt\": \"Torganic Homepage Mobile View\", \"path\": \"/themes/torganic/images/homepage-mobile.jpg\", \"size\": \"374x200\", \"type\": \"mobile\", \"order\": 2, \"description\": \"Responsive mobile homepage design\"}, {\"alt\": \"Product Page Layout\", \"path\": \"/themes/torganic/images/product-page.jpg\", \"size\": \"374x220\", \"type\": \"product\", \"order\": 3, \"description\": \"Product detail page with gallery\"}, {\"alt\": \"Shop Grid Layout\", \"path\": \"/themes/torganic/images/shop-grid.jpg\", \"size\": \"225x167\", \"type\": \"shop\", \"order\": 4, \"description\": \"Product grid layout with filters\"}, {\"alt\": \"Blog Layout\", \"path\": \"/themes/torganic/images/blog-layout.jpg\", \"size\": \"272x188\", \"type\": \"blog\", \"order\": 5, \"description\": \"Blog listing and single post layout\"}, {\"alt\": \"Cart and Checkout\", \"path\": \"/themes/torganic/images/cart-checkout.jpg\", \"size\": \"225x167\", \"type\": \"checkout\", \"order\": 6, \"description\": \"Shopping cart and checkout process\"}, {\"alt\": \"About Page\", \"path\": \"/themes/torganic/images/about-page.jpg\", \"size\": \"254x172\", \"type\": \"about\", \"order\": 7, \"description\": \"About us page with team section\"}, {\"alt\": \"Contact Page\", \"path\": \"/themes/torganic/images/contact-page.jpg\", \"size\": \"168x214\", \"type\": \"contact\", \"order\": 8, \"description\": \"Contact page with form and map\"}, {\"alt\": \"Theme Customizer\", \"path\": \"/themes/torganic/images/customizer-panel.jpg\", \"size\": \"510x324\", \"type\": \"customizer\", \"order\": 9, \"description\": \"WordPress customizer panel\"}, {\"alt\": \"Admin Dashboard\", \"path\": \"/themes/torganic/images/admin-dashboard.jpg\", \"size\": \"1440x900\", \"type\": \"admin\", \"order\": 10, \"description\": \"Theme options and settings panel\"}]','2.1.0','ThemeForest','Responsive Design, Mobile-First, SEO Optimized, Fast Loading, WooCommerce Ready, Customizable Colors, Multiple Layouts, Blog Integration, Contact Forms, Social Media Integration','E-commerce','[\"ecommerce\", \"responsive\", \"organic\", \"modern\", \"woocommerce\", \"mobile-first\", \"seo\", \"fast\"]','active',1,1,15420,89450,4.8,324,'2024-03-15','2024-12-01','WordPress 5.0+, PHP 7.4+, WooCommerce 5.0+, MySQL 5.6+','1. Upload theme files via WordPress admin. 2. Activate the theme. 3. Install required plugins. 4. Import demo content. 5. Customize settings.','{\"color_schemes\": [\"green\", \"blue\", \"purple\", \"orange\"], \"footer_styles\": [\"default\", \"minimal\", \"extended\", \"widget-heavy\"], \"header_styles\": [\"default\", \"centered\", \"minimal\", \"sticky\"], \"layout_options\": [\"boxed\", \"full-width\", \"left-sidebar\", \"right-sidebar\"], \"supported_plugins\": [\"woocommerce\", \"elementor\", \"contact-form-7\", \"yoast-seo\"]}','2025-10-24 12:06:19','2025-10-24 15:44:44'),(2,'Test Theme','test-theme',NULL,NULL,'USD',NULL,NULL,'[{\"alt\": \"Hero Image\", \"path\": \"/test/hero.jpg\", \"size\": \"1920x1080\", \"order\": 0}, {\"alt\": \"Center Image\", \"path\": \"/test/center.jpg\", \"size\": \"1200x800\", \"order\": 4}, {\"alt\": \"Small Image\", \"path\": \"/test/small.jpg\", \"size\": \"400x300\", \"order\": 8}]',NULL,NULL,NULL,NULL,NULL,'active',0,0,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,'2025-10-24 13:58:39','2025-10-24 13:58:39'),(6,'Test Organic','test-organic-1761325189',NULL,NULL,'USD',NULL,NULL,'[{\"alt\": \"Hero Image\", \"path\": \"/test/hero.jpg\", \"size\": \"1920x1080\", \"order\": 0}, {\"alt\": \"Center Image\", \"path\": \"/test/center.jpg\", \"size\": \"500x700\", \"order\": 4}, {\"alt\": \"Small Image\", \"path\": \"/test/small.jpg\", \"size\": \"400x300\", \"order\": 8}]',NULL,NULL,NULL,NULL,NULL,'active',0,0,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,'2025-10-24 13:59:49','2025-10-24 13:59:49'),(7,'Test Organic Resize','test-organic-resize-1761325191',NULL,NULL,'USD',NULL,NULL,'[{\"alt\": \"Center Image\", \"path\": \"/test/center.jpg\", \"size\": \"500x700\", \"order\": 4}]',NULL,NULL,NULL,NULL,NULL,'active',0,0,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,'2025-10-24 13:59:51','2025-10-24 13:59:51'),(8,'Test Theme Order','test-theme-order-1761325224',NULL,NULL,'USD',NULL,NULL,'[{\"alt\": \"Hero Image\", \"path\": \"/test/hero.jpg\", \"size\": \"1920x1080\", \"order\": 0}, {\"alt\": \"Center Image\", \"path\": \"/test/center.jpg\", \"size\": \"1200x800\", \"order\": 4}, {\"alt\": \"Small Image\", \"path\": \"/test/small.jpg\", \"size\": \"400x300\", \"order\": 8}]',NULL,NULL,NULL,NULL,NULL,'active',0,0,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,'2025-10-24 14:00:24','2025-10-24 14:00:24'),(9,'Test Organic','test-organic-1761325225',NULL,NULL,'USD',NULL,NULL,'[{\"alt\": \"Hero Image\", \"path\": \"/test/hero.jpg\", \"size\": \"1920x1080\", \"order\": 0}, {\"alt\": \"Center Image\", \"path\": \"/test/center.jpg\", \"size\": \"500x700\", \"order\": 4}, {\"alt\": \"Small Image\", \"path\": \"/test/small.jpg\", \"size\": \"400x300\", \"order\": 8}]',NULL,NULL,NULL,NULL,NULL,'active',0,0,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,'2025-10-24 14:00:25','2025-10-24 14:00:25'),(10,'Test Organic Resize','test-organic-resize-1761325229',NULL,NULL,'USD',NULL,NULL,'[{\"alt\": \"Center Image\", \"path\": \"/test/center.jpg\", \"size\": \"500x700\", \"order\": 4}]',NULL,NULL,NULL,NULL,NULL,'active',0,0,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,'2025-10-24 14:00:29','2025-10-24 14:00:29');
/*!40000 ALTER TABLE `themes_info` ENABLE KEYS */;

--
-- Table structure for table `top_header_settings`
--

DROP TABLE IF EXISTS `top_header_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `top_header_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `top_header_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `top_header_position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'top',
  `top_header_height` int NOT NULL DEFAULT '40',
  `top_header_sticky` tinyint(1) NOT NULL DEFAULT '0',
  `background_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#1e293b',
  `text_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#d1d5db',
  `border_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#374151',
  `opacity` int NOT NULL DEFAULT '100',
  `contact_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `quick_links_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `quick_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `social_media_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `social_media` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `language_switcher_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `currency_switcher_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `announcement_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `announcement_text` text COLLATE utf8mb4_unicode_ci,
  `announcement_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `announcement_bg_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#6366f1',
  `announcement_text_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#ffffff',
  `announcement_scrolling` tinyint(1) NOT NULL DEFAULT '0',
  `auth_links_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `show_login_link` tinyint(1) NOT NULL DEFAULT '1',
  `show_register_link` tinyint(1) NOT NULL DEFAULT '1',
  `login_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'تسجيل الدخول',
  `register_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'إنشاء حساب',
  `working_hours_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `working_hours` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `movement_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'scroll',
  `movement_direction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'rtl',
  `animation_speed` int NOT NULL DEFAULT '20',
  `pause_on_hover` tinyint(1) NOT NULL DEFAULT '0',
  `infinite_loop` tinyint(1) NOT NULL DEFAULT '1',
  `header_text` text COLLATE utf8mb4_unicode_ci,
  `header_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `font_size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '14px',
  `font_weight` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '400',
  `background_gradient` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `enable_shadow` tinyint(1) NOT NULL DEFAULT '0',
  `enable_opacity` tinyint(1) NOT NULL DEFAULT '0',
  `show_contact_info` tinyint(1) NOT NULL DEFAULT '0',
  `contact_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_social_icons` tinyint(1) NOT NULL DEFAULT '0',
  `show_close_button` tinyint(1) NOT NULL DEFAULT '0',
  `show_countdown` tinyint(1) NOT NULL DEFAULT '0',
  `text_only` tinyint(1) NOT NULL DEFAULT '0',
  `countdown_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `top_header_settings_store_id_unique` (`store_id`),
  KEY `top_header_settings_store_id_index` (`store_id`),
  CONSTRAINT `top_header_settings_chk_1` CHECK (json_valid(`quick_links`)),
  CONSTRAINT `top_header_settings_chk_2` CHECK (json_valid(`social_media`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `top_header_settings`
--

/*!40000 ALTER TABLE `top_header_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `top_header_settings` ENABLE KEYS */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `client_to_store` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `is_active` tinyint(1) DEFAULT '1',
  `vip` tinyint(1) NOT NULL DEFAULT '0',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT '0.00',
  `orders_count` int DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_theme` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_domain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,36,NULL,'Test User','testuser@example.com',NULL,NULL,'admin',1,0,'2025-10-24 08:58:51',0.00,0,'2025-10-24 08:53:47','$2y$12$AJ6nQCWveubOnkGEm8tCHeNWrIB.CG0M2aGPtPlPMxT6DxxPg3C/2','7DHaWkWBalbPTbTcVitfa4rfEZsxyyaPRPXI93tDdXmVLZHTOvO6rGJc7SFY','torganic','custom.com','2025-10-24 08:53:47','2025-10-24 08:58:51'),(2,NULL,NULL,'Ahmed Ali','ahmed-ali@example.com',NULL,NULL,'user',1,0,NULL,0.00,0,NULL,'$2y$12$UizIGkB6qrs1yZ3H3DfR9OzjeViyCOtPAmdB8j3hl5pSSvf7JVmIu',NULL,NULL,NULL,'2025-10-25 16:25:26','2025-10-25 16:25:26'),(3,NULL,NULL,'Sara Mohammed','sara-mohammed@example.com',NULL,NULL,'user',1,0,NULL,0.00,0,NULL,'$2y$12$jqM46amUgEE//YmVzlZGY.PZEXBeuS1Hzm9PuYZlbmxRec7lxw8hi',NULL,NULL,NULL,'2025-10-25 16:25:28','2025-10-25 16:25:28'),(4,NULL,NULL,'Omar Hassan','omar-hassan@example.com',NULL,NULL,'user',1,0,NULL,0.00,0,NULL,'$2y$12$NQm1Af4CqmIn3Hdsk7qQ7eohES57q/VvKNWCgvxIF30g2QbDiy1ky',NULL,NULL,NULL,'2025-10-25 16:25:29','2025-10-25 16:25:29'),(5,NULL,NULL,'Fatima Ibrahim','fatima-ibrahim@example.com',NULL,NULL,'user',1,0,NULL,0.00,0,NULL,'$2y$12$c4Zq3e/5LLWnnbyc9YuEO.0ssk9ULqZ8e3F5em02CjQqwV0mYzH/2',NULL,NULL,NULL,'2025-10-25 16:25:31','2025-10-25 16:25:31');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

--
-- Table structure for table `visits`
--

DROP TABLE IF EXISTS `visits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `visits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `visitable_id` bigint unsigned NOT NULL,
  `visitable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visits_visitable_type_visitable_id_index` (`visitable_type`,`visitable_id`),
  KEY `visits_user_id_foreign` (`user_id`),
  CONSTRAINT `visits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visits`
--

/*!40000 ALTER TABLE `visits` DISABLE KEYS */;
/*!40000 ALTER TABLE `visits` ENABLE KEYS */;

--
-- Table structure for table `whats_app_templates`
--

DROP TABLE IF EXISTS `whats_app_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `whats_app_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `whats_app_templates_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `whats_app_templates`
--

/*!40000 ALTER TABLE `whats_app_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `whats_app_templates` ENABLE KEYS */;

--
-- Table structure for table `whatsapp_logs`
--

DROP TABLE IF EXISTS `whatsapp_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `whatsapp_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_id` bigint unsigned DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `external_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error` text COLLATE utf8mb4_unicode_ci,
  `related_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `related_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `whatsapp_logs_user_id_foreign` (`user_id`),
  KEY `whatsapp_logs_template_id_foreign` (`template_id`),
  KEY `whatsapp_logs_related_type_related_id_index` (`related_type`,`related_id`),
  CONSTRAINT `whatsapp_logs_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `whatsapp_templates` (`id`) ON DELETE SET NULL,
  CONSTRAINT `whatsapp_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `whatsapp_logs_chk_1` CHECK (json_valid(`parameters`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `whatsapp_logs`
--

/*!40000 ALTER TABLE `whatsapp_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `whatsapp_logs` ENABLE KEYS */;

--
-- Table structure for table `whatsapp_templates`
--

DROP TABLE IF EXISTS `whatsapp_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `whatsapp_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `whatsapp_templates_chk_1` CHECK (json_valid(`parameters`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `whatsapp_templates`
--

/*!40000 ALTER TABLE `whatsapp_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `whatsapp_templates` ENABLE KEYS */;

--
-- Table structure for table `zain_theme_colors`
--

DROP TABLE IF EXISTS `zain_theme_colors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zain_theme_colors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zain_theme_colors`
--

/*!40000 ALTER TABLE `zain_theme_colors` DISABLE KEYS */;
/*!40000 ALTER TABLE `zain_theme_colors` ENABLE KEYS */;

--
-- Table structure for table `zain_theme_media`
--

DROP TABLE IF EXISTS `zain_theme_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zain_theme_media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zain_theme_media`
--

/*!40000 ALTER TABLE `zain_theme_media` DISABLE KEYS */;
/*!40000 ALTER TABLE `zain_theme_media` ENABLE KEYS */;

--
-- Table structure for table `zain_theme_products`
--

DROP TABLE IF EXISTS `zain_theme_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zain_theme_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zain_theme_products`
--

/*!40000 ALTER TABLE `zain_theme_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `zain_theme_products` ENABLE KEYS */;

--
-- Table structure for table `zain_theme_sections`
--

DROP TABLE IF EXISTS `zain_theme_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zain_theme_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zain_theme_sections`
--

/*!40000 ALTER TABLE `zain_theme_sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `zain_theme_sections` ENABLE KEYS */;

--
-- Table structure for table `zain_theme_settings`
--

DROP TABLE IF EXISTS `zain_theme_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zain_theme_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zain_theme_settings`
--

/*!40000 ALTER TABLE `zain_theme_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `zain_theme_settings` ENABLE KEYS */;

--
-- Dumping routines for database 'lkssitjb_store'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-26 14:30:59
