-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Feb 02, 2022 at 12:01 PM
-- Server version: 8.0.18
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amrak`
--

-- --------------------------------------------------------

--
-- Table structure for table `availability_hours`
--

DROP TABLE IF EXISTS `availability_hours`;
CREATE TABLE IF NOT EXISTS `availability_hours` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `start_at` time NOT NULL,
  `end_at` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `availability_hours`
--

INSERT INTO `availability_hours` (`id`, `service_id`, `day_id`, `start_at`, `end_at`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '07:00:00', '10:00:00', NULL, NULL),
(2, 1, 1, '14:36:00', '15:36:00', '2022-01-31 09:36:58', '2022-01-31 09:36:58');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `booking_state_id` int(11) DEFAULT '1',
  `payment_state_id` int(11) DEFAULT NULL,
  `payment_method_id` int(11) NOT NULL,
  `coupon_id` double DEFAULT NULL,
  `total` double NOT NULL,
  `accept` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `service_id`, `customer_id`, `address`, `provider_id`, `booking_state_id`, `payment_state_id`, `payment_method_id`, `coupon_id`, `total`, `accept`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'sadi/sy/add/tar', '1', 4, NULL, 2, NULL, 7757, 1, '2022-01-31 08:22:10', '2022-02-02 09:41:19'),
(2, 1, 1, 'sadi/sy/add/tar', '1', 3, NULL, 1, NULL, 7757, 0, '2022-02-01 11:18:49', '2022-02-02 06:08:36'),
(3, 1, 1, 'syrie/homs/tal/akari', '1', 4, 1, 2, NULL, 15750, 1, '2022-02-01 11:20:28', '2022-02-02 06:07:49');

-- --------------------------------------------------------

--
-- Table structure for table `booking_states`
--

DROP TABLE IF EXISTS `booking_states`;
CREATE TABLE IF NOT EXISTS `booking_states` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trans_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `booking_states`
--

INSERT INTO `booking_states` (`id`, `name`, `lang`, `trans_id`, `created_at`, `updated_at`) VALUES
(1, 'accept', 'en', 1, '2022-01-31 08:23:01', '2022-01-31 08:23:01'),
(2, 'in the way', 'en', 2, '2022-01-31 08:23:15', '2022-01-31 08:23:15'),
(3, 'delivered', 'en', 3, '2022-01-31 08:23:37', '2022-01-31 08:23:37'),
(4, 'تم التوصيل', 'ar', 3, '2022-02-02 04:58:08', '2022-02-02 04:58:08'),
(8, 'على الطريق', 'ar', 2, '2022-02-02 05:11:00', '2022-02-02 05:11:00'),
(9, 'تم القبول', 'ar', 1, '2022-02-02 05:13:13', '2022-02-02 05:13:13');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ar',
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trans_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `order_id`, `color_id`, `parent_id`, `lang`, `icon`, `trans_id`, `created_at`, `updated_at`) VALUES
(1, 'ales', 0, 1, 0, 'en', 'categories/uploads/cat61f4fc201e5b8_366739.jpg', 1, '2022-01-29 06:34:41', '2022-01-29 06:34:41'),
(10, 'اليس', 0, 3, 0, 'ar', 'categories/uploads/cat61fa33509796e_219899.jpg', 1, '2022-02-02 05:31:30', '2022-02-02 05:31:30'),
(7, 'details', 0, 0, 1, 'ar', 'categories/uploads/cat61f7d40772232_84198.png', 7, '2022-01-31 10:20:25', '2022-01-31 10:20:25'),
(6, 'code chvh', 0, 1, 1, 'en', 'categories/uploads/cat61f5095728eb9_363052.png', 6, '2022-01-29 07:31:04', '2022-01-29 07:31:04'),
(9, 'sub cat', 0, 2, 0, 'en', 'categories/uploads/cat61fa362ac3e1f_894332.png', 9, '2022-02-02 04:23:52', '2022-02-02 05:43:40'),
(11, 'test', 0, 2, 0, 'en', 'categories/uploads/cat61fa37a785348_549076.png', 11, '2022-02-02 05:50:01', '2022-02-02 05:50:01'),
(12, 'accept', 0, 0, 0, 'en', 'categories/uploads/cat61fa387e1dee4_704966.png', 12, '2022-02-02 05:53:36', '2022-02-02 05:53:36'),
(13, 'test test', 0, 3, 0, 'en', 'categories/uploads/cat61fa39b17bd54_809611.png', 13, '2022-02-02 05:58:44', '2022-02-02 05:58:44');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

DROP TABLE IF EXISTS `colors`;
CREATE TABLE IF NOT EXISTS `colors` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'ales', '#34CE41', '2022-01-29 06:34:15', '2022-01-29 06:34:15'),
(2, 'blue', '#24A1AA', '2022-02-01 13:19:55', '2022-02-01 13:19:55'),
(3, 'red', '#FF3C22', '2022-02-02 05:52:00', '2022-02-02 05:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `condition_roles`
--

DROP TABLE IF EXISTS `condition_roles`;
CREATE TABLE IF NOT EXISTS `condition_roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trans_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `condition_roles`
--

INSERT INTO `condition_roles` (`id`, `title`, `content`, `lang`, `trans_id`, `created_at`, `updated_at`) VALUES
(1, 'role', 'f nfjnfjndfjf', 'en', 1, NULL, NULL),
(5, 'ترجمة 1 تيست', 'سميبىمسى[تىسيب', 'ar', 5, '2022-02-02 05:09:48', '2022-02-02 05:09:48'),
(3, 'edit', 'elements will be converted into data objects using the following rules:', 'en', 3, '2022-02-02 04:51:03', '2022-02-02 04:51:03'),
(4, 'تعديل', 'سىبتاتسبا 3', 'ar', 3, '2022-02-02 04:51:30', '2022-02-02 04:51:30');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
CREATE TABLE IF NOT EXISTS `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` text COLLATE utf8_unicode_ci NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount` int(11) NOT NULL,
  `discount_type` int(11) NOT NULL,
  `is_used` int(11) DEFAULT NULL,
  `enable` int(11) NOT NULL DEFAULT '1',
  `expire_at` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `service_id`, `user_id`, `discount`, `discount_type`, `is_used`, `enable`, `expire_at`, `created_at`, `updated_at`) VALUES
(1, 'AM_asdfg', 1, NULL, 10, 0, NULL, 1, '2022-01-01', '2022-01-30 07:37:58', '2022-01-30 07:37:58');

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

DROP TABLE IF EXISTS `days`;
CREATE TABLE IF NOT EXISTS `days` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `days`
--

INSERT INTO `days` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'monday', NULL, NULL),
(2, 'sunday', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_01_10_092032_create_services_table', 1),
(6, '2022_01_11_061745_create_providers_table', 1),
(7, '2022_01_11_064551_create_availability_hours_table', 1),
(8, '2022_01_11_070237_create_roles_table', 1),
(9, '2022_01_11_070603_create_languages_table', 1),
(10, '2022_01_11_070830_create_service_reviews_table', 1),
(11, '2022_01_11_071206_create_booking_states_table', 1),
(12, '2022_01_11_071703_create_bookings_table', 1),
(13, '2022_01_11_072911_create_payment_states_table', 1),
(14, '2022_01_11_073000_create_payment_methods_table', 1),
(15, '2022_01_11_073744_create-table-days', 1),
(16, '2022_01_11_110315_create_categories_table', 1),
(17, '2022_01_11_125524_create_sliders_table', 1),
(18, '2022_01_13_072343_create_user_favs_table', 1),
(19, '2022_01_13_114156_creat-table-terms-privacies', 1),
(20, '2022_01_13_123604_creat-table-condition-roles', 1),
(21, '2022_01_15_063034_create_colors_table', 1),
(22, '2022_01_16_091857_create_provider_typs_table', 1),
(23, '2022_01_17_103946_create_user_addresses_table', 1),
(24, '2022_01_17_121748_create_coupons_table', 1),
(25, '2022_01_18_082408_create_notifications_table', 1),
(26, '2022_01_31_091007_create_book_notifies_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `unsent` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `provider_id`, `title`, `details`, `unsent`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'test', 'kmsdfkkdsf', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE IF NOT EXISTS `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enable` int(11) NOT NULL,
  `lang` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `trans_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `enable`, `lang`, `trans_id`, `created_at`, `updated_at`) VALUES
(1, 'code', 1, 'en', 1, '2022-01-29 06:02:34', '2022-02-02 05:24:00'),
(2, 'كاش', 0, 'ar', 2, '2022-02-02 05:20:08', '2022-02-02 05:20:08'),
(3, 'cache', 1, 'en', NULL, '2022-02-02 05:24:52', '2022-02-02 05:24:52');

-- --------------------------------------------------------

--
-- Table structure for table `payment_states`
--

DROP TABLE IF EXISTS `payment_states`;
CREATE TABLE IF NOT EXISTS `payment_states` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trans_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_states`
--

INSERT INTO `payment_states` (`id`, `name`, `lang`, `trans_id`, `created_at`, `updated_at`) VALUES
(1, 'تم الدفع', 'ar', 1, '2022-02-02 05:14:24', '2022-02-02 05:14:24'),
(2, 'paid', 'en', 1, '2022-02-02 05:15:50', '2022-02-02 05:15:50');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `providers`
--

DROP TABLE IF EXISTS `providers`;
CREATE TABLE IF NOT EXISTS `providers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `accept` int(11) NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` int(11) NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `available` int(11) NOT NULL,
  `availability_rang` int(11) NOT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trans_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `providers`
--

INSERT INTO `providers` (`id`, `name`, `email`, `accept`, `password`, `phone`, `icon`, `address`, `available`, `availability_rang`, `lang`, `trans_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'shaza', 'shaza@mail.com', 1, '123456', 123456789, '', 'hhome/homs', 1, 12, 'en', 1, NULL, NULL, '2022-02-02 04:35:36');

-- --------------------------------------------------------

--
-- Table structure for table `provider_typs`
--

DROP TABLE IF EXISTS `provider_typs`;
CREATE TABLE IF NOT EXISTS `provider_typs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guard` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `duration` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `discount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `tax` int(11) NOT NULL,
  `price_unit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `available` int(11) NOT NULL DEFAULT '1',
  `featured_id` int(11) DEFAULT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trans_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `icon`, `provider_id`, `cat_id`, `duration`, `discount`, `price`, `tax`, `price_unit`, `available`, `featured_id`, `lang`, `trans_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'smart', 'services/uploads/services61f65bfe79580_602814.png', 1, 1, '01:36', '30', 12000, 50, 'dol', 1, 1, 'en', 1, NULL, '2022-01-30 07:36:27', '2022-01-30 07:36:27'),
(2, 'car services', 'services/uploads/services61f661545cf3b_704093.png', 1, 2, '11:01', '10', 1000000, 30, 'do', 1, NULL, 'ar', 2, '2022-01-30 07:59:29', '2022-01-30 07:58:49', '2022-01-30 07:59:29'),
(3, 'diamond', 'services/uploads/services61f7d42ac4600_328140.png', 1, 7, '13:15', '1000', 150000, 10, 'da', 1, NULL, 'en', 3, NULL, '2022-01-31 10:21:28', '2022-01-31 10:21:28');

-- --------------------------------------------------------

--
-- Table structure for table `service_reviews`
--

DROP TABLE IF EXISTS `service_reviews`;
CREATE TABLE IF NOT EXISTS `service_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `review` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rate` int(11) DEFAULT '0',
  `accept` int(11) NOT NULL DEFAULT '0',
  `lang` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trans_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `service_reviews`
--

INSERT INTO `service_reviews` (`id`, `service_id`, `customer_id`, `review`, `rate`, `accept`, `lang`, `trans_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'this is test comment', 0, 1, NULL, NULL, '2022-01-30 13:57:22', '2022-01-31 09:28:15'),
(2, 1, 1, NULL, 3, 1, NULL, NULL, '2022-01-30 13:58:04', '2022-01-31 09:28:20'),
(3, 2, 1, 'this is test comment teset test', 0, 0, NULL, NULL, '2022-02-01 10:41:31', '2022-02-01 10:41:31'),
(4, 2, 1, NULL, 5, 0, NULL, NULL, '2022-02-01 10:41:45', '2022-02-01 10:41:45');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `btn` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text_color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `btn_color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `background_color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `indicator_color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_service` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enable` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `text`, `btn`, `text_color`, `btn_color`, `background_color`, `indicator_color`, `image_service`, `enable`, `created_at`, `updated_at`) VALUES
(1, 'كورسات مختصة باللغة الانكليزية', 'opop', '#788EFF', '#57E2FF', '#AF51FF', '#6083FF', 'sliders/uploads/slide61f4ee51935d7_701047.png', 0, '2022-01-29 05:36:03', '2022-01-29 05:36:03');

-- --------------------------------------------------------

--
-- Table structure for table `terms_privacies`
--

DROP TABLE IF EXISTS `terms_privacies`;
CREATE TABLE IF NOT EXISTS `terms_privacies` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trans_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `terms_privacies`
--

INSERT INTO `terms_privacies` (`id`, `title`, `text`, `lang`, `trans_id`, `created_at`, `updated_at`) VALUES
(1, 'term', 'dasndjasnd', 'en', 1, NULL, NULL),
(5, 'ترجمة تيست', 'كسبوبر كسيريس', 'ar', 1, '2022-02-02 05:02:59', '2022-02-02 05:02:59'),
(3, 'سيلساة', 'سبسينتىب ىستب2', 'ar', 3, '2022-02-02 04:53:05', '2022-02-02 04:53:05'),
(4, 'termr2', 'elements will be converted into data objects using the following rules', 'en', 3, '2022-02-02 04:53:25', '2022-02-02 04:53:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `accept` int(11) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `icon`, `mobile`, `role_id`, `email_verified_at`, `password`, `accept`, `deleted_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@admin.com', NULL, '123456789', '1', NULL, '$2y$10$b3v46JHN/yG7miSUX2aXu.BVtk6MtKlAknqJTzTVIFE77wtzgngOe', 1, NULL, NULL, '2022-01-29 05:56:28', '2022-01-31 14:01:38');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

DROP TABLE IF EXISTS `user_addresses`;
CREATE TABLE IF NOT EXISTS `user_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` double(8,2) NOT NULL,
  `longitude` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `user_id`, `name`, `address`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 1, 'work', 'tartous/sy/sadi/sy/add/tar', 17.50, 33.50, '2022-01-29 05:57:00', '2022-01-29 05:57:00'),
(2, 1, 'home', 'homs/sy/akaree', 17.50, 33.50, '2022-01-30 14:10:10', '2022-01-30 14:10:10');

-- --------------------------------------------------------

--
-- Table structure for table `user_favs`
--

DROP TABLE IF EXISTS `user_favs`;
CREATE TABLE IF NOT EXISTS `user_favs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_favs`
--

INSERT INTO `user_favs` (`id`, `user_id`, `service_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
