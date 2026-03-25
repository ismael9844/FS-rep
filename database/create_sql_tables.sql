-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 08 sep. 2025 à 21:02
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `food_donation`
--

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contributions`
--

CREATE TABLE IF NOT EXISTS `contributions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `partner_id` bigint(20) UNSIGNED NOT NULL,
  `food_request_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contributions`
--

INSERT IGNORE INTO `contributions` (`id`, `partner_id`, `food_request_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 500.00, '2025-07-18 04:24:50', '2025-07-18 04:24:50'),
(2, 5, 1, 500.00, '2025-07-18 04:26:20', '2025-07-18 04:26:20'),
(3, 6, 1, 100.00, '2025-07-18 04:52:48', '2025-07-18 04:52:48'),
(4, 1, 1, 50.00, '2025-07-18 05:50:57', '2025-07-18 05:50:57'),
(6, 6, 3, 6500.00, '2025-07-18 07:34:23', '2025-07-18 07:34:23'),
(7, 5, 1, 67.00, '2025-07-20 14:34:36', '2025-07-20 14:34:36'),
(8, 5, 1, 34.00, '2025-07-21 03:13:33', '2025-07-21 03:13:33'),
(9, 5, 1, 4567.00, '2025-07-21 03:13:53', '2025-07-21 03:13:53'),
(10, 5, 1, 1.00, '2025-07-21 03:17:15', '2025-07-21 03:17:15'),
(11, 8, 7, 22202.07, '2025-08-13 08:04:21', '2025-08-13 08:04:21'),
(12, 1, 7, 1.00, '2025-08-14 03:51:04', '2025-08-14 03:51:04');

-- --------------------------------------------------------

--
-- Structure de la table `distributions`
--

CREATE TABLE IF NOT EXISTS `distributions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `donation_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_distributed` int(11) NOT NULL,
  `distribution_date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `distributions`
--

INSERT IGNORE INTO `distributions` (`id`, `donation_id`, `user_id`, `quantity_distributed`, `distribution_date`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, '2025-07-03', 'pending', 'Remis au centre social de quartier', '2025-07-03 08:44:11', '2025-07-03 08:44:11');

-- --------------------------------------------------------

--
-- Structure de la table `donations`
--

CREATE TABLE IF NOT EXISTS `donations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `food_request_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL DEFAULT 'portion',
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `available_until` timestamp NULL DEFAULT NULL,
  `status` enum('available','reserved','completed','cancelled') NOT NULL DEFAULT 'available',
  `expiration_date` date DEFAULT NULL,
  `need_volunteers` int(11) NOT NULL DEFAULT 0,
  `volunteer_note` text DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `min_quantity` int(11) NOT NULL DEFAULT 1,
  `donor_type` enum('individual','organization') NOT NULL DEFAULT 'individual',
  `available_from` datetime DEFAULT NULL,
  `available_to` time DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `partner_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `donations`
--

INSERT IGNORE INTO `donations` (`id`, `food_request_id`, `user_id`, `title`, `description`, `image`, `quantity`, `unit`, `latitude`, `longitude`, `available_until`, `status`, `expiration_date`, `need_volunteers`, `volunteer_note`, `category`, `min_quantity`, `donor_type`, `available_from`, `available_to`, `city`, `postal_code`, `created_at`, `updated_at`, `partner_id`) VALUES
(1, NULL, 5, 'Pizza', '2 full peperonni pizza', NULL, 20, 'portion', 48.8566000, 2.3522000, '2025-08-14 11:00:00', 'available', '2025-08-20', 1, NULL, 'Pizza', 1, 'individual', '2025-07-23 09:00:00', '14:00:00', 'Kyrenia', '75001', '2025-06-05 04:07:42', '2025-07-03 04:07:42', NULL),
(2, NULL, 1, 'Lunch Sandwiches', 'Paninis et wraps left over, végan-friendly', NULL, 15, 'portion', 48.8566000, 2.3522000, '2025-08-14 11:00:00', 'available', '2025-08-14', 1, 'We need a volunteer.', 'Sandwiches', 2, 'individual', '2025-07-23 11:52:00', '14:00:00', 'Kyrenia', '75001', '2025-05-13 04:44:33', '2025-07-11 03:33:57', NULL),
(3, NULL, 5, 'Fruits', 'Apples and Bananas', NULL, 15, 'portion', 48.8566000, 2.3522000, '2025-09-10 16:00:00', 'available', '2025-08-15', 0, NULL, 'Fruit', 10, 'organization', '2025-07-23 13:17:00', '23:00:00', 'Monaco', '75001', '2025-07-03 05:15:36', '2025-07-16 04:09:45', 6),
(5, NULL, 1, 'potato', '5kg of potato', NULL, 5, 'kg', 47.8566000, 2.3522000, '2025-07-17 06:00:00', 'available', '2025-08-17', 3, 'Urgently need volunteer', 'Vegtables', 1, 'individual', '2025-07-23 11:53:00', '23:00:00', 'Grenoble', '9348', '2025-07-01 07:42:07', '2025-07-11 03:34:22', NULL),
(6, NULL, 5, 'Fruits', 'Watermelon', NULL, 25, 'portion', 51.5074000, -0.1278000, '2025-09-10 16:00:00', 'available', '2025-07-20', 0, NULL, 'Fruit', 10, 'organization', '2025-07-23 07:00:00', '23:00:00', 'Lefkosa', '75001', '2025-04-23 03:28:25', '2025-07-07 03:28:25', 5),
(7, NULL, 1, 'Apple pie', '36 fresh Apple pie', NULL, 36, 'slices', 69.0000000, 59.0000000, '2025-07-17 14:23:00', 'available', '2025-07-12', 6, 'come on time pls', 'Dessert', 1, 'individual', '2025-07-23 15:00:00', '21:00:00', 'Paris', '76007', '2025-07-08 09:24:16', '2025-08-14 04:57:09', NULL),
(8, NULL, 5, 'Cake', 'Pie etc ...', NULL, 34, 'slices', 40.7128000, -74.0060000, '2025-09-12 10:13:00', 'available', '2025-07-13', 5, 'Need 5 volunteer', 'Dessert', 1, 'individual', '2025-07-23 11:51:00', '19:00:00', 'Agios Epiktitos', '99370', '2025-05-21 03:14:26', '2025-05-07 03:18:41', 5),
(10, NULL, 5, 'Grilled Chicken Portions', 'Surplus grilled chicken portions from today\'s lunch service. Packaged and refrigerated.', NULL, 5, 'Portion', 34.0522000, -118.2437000, '2025-08-14 07:30:00', 'available', '2025-07-22', 0, NULL, 'Meat', 1, 'organization', '2025-07-23 08:30:00', NULL, 'Kazafani', '99320', '2025-07-17 04:28:50', '2025-07-17 04:28:50', 5),
(11, NULL, 5, 'Unsold Pasta Dishes', 'Spaghetti Bolognese and Penne Alfredo meals not served during dinner rush.', NULL, 3, 'Portion', 35.6895000, 139.6917000, '2025-09-10 22:44:00', 'available', '2025-07-24', 0, NULL, 'Meal', 1, 'organization', '2025-07-23 10:43:00', NULL, 'Kazafani', '99320', '2025-07-17 04:44:02', '2025-07-17 04:44:02', 5),
(12, NULL, 5, 'Assorted Sandwiches from Lunch Menu', 'Club sandwiches, turkey wraps, and veggie paninis prepared today but unsold.', NULL, 12, 'Sandwiches', 14.6928000, -17.4467000, '2025-08-20 08:54:00', 'available', '2025-07-19', 0, NULL, 'Sandwiches', 1, 'organization', '2025-07-23 12:54:00', NULL, 'Kazafani', '99320', '2025-07-17 04:52:41', '2025-07-17 04:52:41', 5),
(13, NULL, 5, 'Freshly Baked Bread Loaves', 'Wholegrain and white bread loaves baked this morning. Not used during service.', NULL, 8, 'Portions', 48.8566000, 2.3522000, '2025-08-12 08:54:00', 'available', '2025-08-22', 0, NULL, 'Dessert', 1, 'organization', '2025-07-23 12:54:00', NULL, 'Kazafani', '99320', '2025-07-17 04:59:16', '2025-07-17 04:59:16', 5),
(14, NULL, 5, 'Excess Cooked Rice and Beans', 'Large batch of rice and black beans from a catered event. Ready for distribution.', NULL, 5, 'Portion', 51.5074000, -0.1278000, '2025-08-13 00:03:00', 'available', '2025-08-22', 0, NULL, 'Meal', 1, 'organization', '2025-07-23 14:02:00', NULL, 'Kazafani', '99320', '2025-07-17 05:00:59', '2025-07-17 05:00:59', 5),
(19, NULL, 1, 'Assorted Desserts – Cakes and Pastries', 'Slices of cheesecake, chocolate cake, and mini fruit tarts. Not served today.', NULL, 6, 'Portion', 40.7128000, -74.0060000, '2025-08-12 12:46:00', 'available', '2025-08-26', 0, NULL, 'Dessert', 1, 'organization', '2025-07-23 06:50:00', NULL, 'Kazafani', '99320', '2025-07-17 05:46:41', '2025-07-17 05:46:41', NULL),
(20, NULL, 5, 'Overstocked Bottled Drinks', 'Soft drinks, bottled iced teas, and sparkling water not used during service', NULL, 16, 'Drinks', 34.0522000, -118.2437000, '2025-08-13 09:52:00', 'available', '2027-09-17', 0, NULL, 'Drinks', 1, 'organization', '2025-07-23 14:50:00', NULL, 'Kazafani', '99320', '2025-07-17 05:50:39', '2025-07-17 05:50:39', 6),
(21, NULL, 5, 'Event Leftovers – Buffet Style Dishes', 'Mixed buffet trays from a private event. Stored safely and available for pickup.', NULL, 7, 'Portion', 35.6895000, 139.6917000, '2025-08-14 08:52:00', 'available', '2025-08-25', 0, NULL, 'Meal', 1, 'organization', '2025-07-23 07:00:00', NULL, 'Kazafani', '99320', '2025-07-17 05:53:09', '2025-07-17 05:53:09', 6),
(49, NULL, 6, 'tre', 'qreg', NULL, 1, 'kg', 14.6928000, -17.4467000, '2025-08-01 12:03:00', 'available', '2025-07-27', 0, NULL, NULL, 1, 'organization', '2025-07-23 17:05:00', NULL, 'Kyrenia', '99300', '2025-07-19 09:03:54', '2025-07-19 09:03:54', 6),
(50, NULL, 5, 'yyyyyyyyyy', 'ttttttttttttttt', NULL, 1, 'litres', 35.3399283, 33.3329638, '2025-07-21 02:52:00', 'available', '2025-07-21', 0, NULL, NULL, 1, 'individual', '2025-07-23 23:52:00', NULL, 'Kyrenia', '99300', '2025-07-20 14:52:45', '2025-07-20 14:52:45', 5),
(51, NULL, 1, 'testing', 'test from tomorow', NULL, 9, 'boxes', 35.3298740, 33.3613359, '2025-07-24 13:04:00', 'available', '2025-07-24', 0, NULL, NULL, 1, 'individual', '2025-07-23 18:07:00', NULL, 'Kazafani', '99320', '2025-07-21 10:06:30', '2025-07-21 10:06:30', NULL),
(52, NULL, 5, 'AERwefwdq', 'rwEFWDAS', NULL, 1, 'slices', 35.3402784, 33.2874799, '2025-07-25 06:17:00', 'available', NULL, 0, NULL, NULL, 1, 'individual', '2025-07-23 09:33:00', NULL, 'Templos', '99320', '2025-07-22 03:33:32', '2025-07-22 03:33:32', 5),
(53, NULL, 5, 'dfghj', 'sdfgh', NULL, 1, 'litres', 35.3303448, 33.3613789, '2025-07-25 06:52:00', 'available', '2025-07-25', 0, NULL, NULL, 1, 'individual', '2025-07-23 09:52:00', NULL, 'Kazafani', '99320', '2025-07-22 03:52:59', '2025-07-22 03:52:59', 5),
(54, NULL, 5, 'lkjhg', 'kjhgtfr', NULL, 1, 'litres', 35.2191463, 33.3244114, '2025-07-25 07:04:00', 'available', '2025-07-24', 0, NULL, NULL, 1, 'individual', '2025-07-23 10:04:00', NULL, 'Kızılbaş', '99138', '2025-07-22 04:04:50', '2025-07-22 04:04:50', 5),
(55, NULL, 5, 'hgfdsa', 'hgfdsa', NULL, 1, 'pieces', 35.1904202, 33.0308140, '2025-07-24 07:07:00', 'available', '2025-07-24', 0, NULL, NULL, 1, 'individual', '2025-07-23 10:07:00', NULL, 'Argaki', NULL, '2025-07-22 04:08:06', '2025-07-22 04:08:06', 5),
(57, NULL, 1, 'trying my best', 'or not', NULL, 1, 'boxes', 35.3347821, 33.3184433, '2025-09-06 10:43:00', 'available', '2025-09-04', 0, NULL, 'Desserts', 1, 'individual', '2025-08-13 13:43:00', NULL, 'Kyrenia', '99300', '2025-08-13 07:44:25', '2025-08-13 07:44:25', NULL),
(58, NULL, 1, 'Apple pie', 'leftover', NULL, 24, 'pieces', 35.0841429, 32.2902298, '2025-08-16 06:50:00', 'available', '2025-08-30', 0, NULL, NULL, 1, 'individual', '2025-08-15 09:50:00', NULL, 'Néo Chorió', NULL, '2025-08-14 03:50:26', '2025-08-14 03:50:26', NULL),
(59, NULL, 1, 'oranges', '10 boxes of oranges', NULL, 18, 'boxes', 35.3303041, 33.3613730, '2025-08-31 07:52:00', 'available', '2025-08-24', 0, NULL, 'Fruits', 1, 'individual', '2025-08-15 10:51:00', NULL, 'Kazafani', '99320', '2025-08-14 04:52:36', '2025-08-14 04:52:36', NULL),
(60, NULL, 8, 'yogurt', 'almost expired but still good', NULL, 15, 'packs', 12.6481418, -7.9488981, '2025-08-30 06:46:00', 'available', '2025-08-31', 0, NULL, 'dessert', 1, 'individual', '2025-08-24 09:46:00', NULL, 'Bamako', NULL, '2025-08-24 03:48:03', '2025-08-24 03:48:03', 7),
(61, NULL, 8, 'testing', 'work ?', NULL, 8, 'slices', 35.3347103, 33.3183441, '2025-09-07 06:57:00', 'available', '2025-09-06', 0, NULL, 'Desserts', 1, 'individual', '2025-08-29 09:57:00', NULL, 'Kyrenia', '99300', '2025-08-24 03:57:35', '2025-08-24 03:57:35', 7);

-- --------------------------------------------------------

--
-- Structure de la table `donation_volunteer`
--

CREATE TABLE IF NOT EXISTS `donation_volunteer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `donation_id` bigint(20) UNSIGNED NOT NULL,
  `volunteer_id` bigint(20) UNSIGNED NOT NULL,
  `volunteered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `donation_volunteer`
--

INSERT IGNORE INTO `donation_volunteer` (`id`, `donation_id`, `volunteer_id`, `volunteered_at`) VALUES
(15, 8, 5, '2025-07-16 11:34:40'),
(17, 5, 5, '2025-07-16 11:56:22');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `food_requests`
--

CREATE TABLE IF NOT EXISTS `food_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `target_amount` decimal(10,2) DEFAULT NULL,
  `needed_before` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `paypal_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `food_requests`
--

INSERT IGNORE INTO `food_requests` (`id`, `organization_id`, `title`, `description`, `quantity`, `target_amount`, `needed_before`, `created_at`, `updated_at`, `paypal_link`) VALUES
(1, 5, 'Rice', 'Need rice for a distribution', 10, 2000.00, '2025-08-31 06:29:00', '2025-07-18 04:07:40', '2025-07-18 04:07:40', NULL),
(3, 1, 'Meat', 'Need meat for distribution meal', 10, 10000.00, '2025-09-04 10:30:00', '2025-07-18 07:30:50', '2025-07-18 07:30:50', NULL),
(7, 8, 'It\'s Food For Thought ! - Food Donation Project', 'oiuytr', 59, 325000.00, '2025-09-18 06:47:34', '2025-08-13 08:02:19', '2025-08-13 08:02:19', NULL),
(9, 1, 'etst', 'ater', 453, 453456.00, '2025-09-06 08:03:00', '2025-08-29 05:05:47', '2025-08-29 05:05:47', 'https://www.youtube.com/shorts/SXHMnicI6Pg');

-- --------------------------------------------------------

--
-- Structure de la table `food_request_donations`
--

CREATE TABLE IF NOT EXISTS `food_request_donations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `food_request_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL DEFAULT 'servings',
  `available_until` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `food_request_donations`
--

INSERT IGNORE INTO `food_request_donations` (`id`, `food_request_id`, `user_id`, `quantity`, `unit`, `available_until`, `created_at`, `updated_at`) VALUES
(2, 3, 5, 7, 'servings', '2025-07-18 12:51:25', '2025-07-18 07:34:14', '2025-07-18 07:34:14'),
(3, 3, 6, 3, 'servings', '2025-07-21 12:05:00', '2025-07-19 09:05:58', '2025-07-19 09:05:58'),
(4, 1, 5, 3, 'servings', '2025-07-22 17:34:00', '2025-07-20 14:34:30', '2025-07-20 14:34:30'),
(5, 1, 5, 45, 'servings', '2025-07-23 13:19:00', '2025-07-21 10:19:18', '2025-07-21 10:19:18'),
(7, 7, 8, 10, 'servings', '2025-08-23 11:06:00', '2025-08-13 08:06:17', '2025-08-13 08:06:17'),
(8, 7, 1, 1, 'servings', '2025-08-16 06:49:00', '2025-08-14 03:49:17', '2025-08-14 03:49:17');

-- --------------------------------------------------------

--
-- Structure de la table `food_waste_reports`
--

CREATE TABLE IF NOT EXISTS `food_waste_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `reported_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `food_waste_reports`
--

INSERT IGNORE INTO `food_waste_reports` (`id`, `user_id`, `category`, `quantity`, `description`, `latitude`, `longitude`, `reported_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Fruits', 10, 'Fruits pourris dans le frigo', 48.8566000, 2.3522000, '2025-07-03 04:45:11', '2025-07-03 04:45:11', '2025-07-03 04:45:11');

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT IGNORE INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_02_095241_create_personal_access_tokens_table', 1),
(5, '2025_07_02_123557_create_donations_table', 1),
(6, '2025_07_03_071657_create_food_waste_reports_table', 2),
(8, '2025_07_03_085000_create_user_preferences_table', 3),
(10, '2025_07_03_112737_create_distributions_table', 4),
(11, '2025_07_03_121716_create_pickups_table', 5),
(12, '2025_07_04_072234_add_expiration_date_to_donations_table', 6),
(13, '2025_07_04_115801_create_volunteers_table', 7),
(16, '2025_07_07_054920_create_partners_table', 8),
(17, '2025_07_07_055403_add_partner_id_to_donations_table', 8),
(18, '2025_07_08_083841_create_donation_volunteer_table', 9),
(19, '2025_07_08_085019_create_notifications_table', 10),
(20, '2025_07_10_123113_add_volunteer_fields_to_donations_table', 11),
(21, '2025_07_11_110246_create_permission_tables', 12),
(23, '2025_07_11_120611_add_role_to_users_table', 13),
(24, '2025_07_15_071046_add_user_id_to_partners_table', 14),
(25, '2025_07_18_060808_create_food_requests_table', 14),
(26, '2025_07_18_061044_create_contributions_table', 14),
(27, '2025_07_18_072248_add_food_request_id_to_donations_table', 15),
(28, '2025_07_18_073748_make_location_nullable_on_donations', 16),
(29, '2025_07_18_085814_create_food_request_donations_table', 17),
(30, '2025_07_19_103745_add_profile_image_to_users_table', 18),
(31, '2025_07_19_103756_add_document_path_to_partners_table', 18),
(33, '2025_07_19_173023_add_status_to_donations_table', 19),
(34, '2025_07_20_121000_add_linked_partner_id_to_partners_table', 20),
(35, '2025_07_20_125535_create_partner_requests_table', 21),
(36, '2025_07_20_153012_add_role_to_partners_table', 22),
(37, '2025_07_22_071517_create_sponsorship_tiers_table', 23),
(38, '2025_07_22_071521_create_sponsorships_table', 23),
(39, '2025_07_22_084243_create_tiers_table', 24),
(40, '2025_07_22_084645_add_images_to_sponsorships_table', 25),
(41, '2025_07_22_101525_add_sponsor_level_to_partners_table', 26),
(42, '2025_08_24_094548_add_real_name_to_users_table', 27),
(43, '2025_08_25_085346_add_document_path_to_users_table', 28),
(44, '2025_08_25_120635_add_document_request_token_to_partners_table', 29),
(45, '2025_08_25_123656_add_document_request_token_to_users_and_partners', 30),
(46, '2025_08_29_075141_add_paypal_link_to_food_requests_table', 31),
(47, '2025_08_29_083113_add_verification_fields_to_volunteers_table', 32),
(48, '2025_08_31_114931_create_places_table', 33),
(49, '2025_08_31_115001_create_place_photos_table', 33),
(50, '2025_08_31_115017_create_place_requests_table', 33);

-- --------------------------------------------------------

--
-- Structure de la table `model_has_permissions`
--

CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `model_has_roles`
--

CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `notifications`
--

INSERT IGNORE INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0008234e-2ea0-4246-a53b-65b60ee19ed4', 'App\\Notifications\\PartnerLevelUp', 'App\\Models\\User', 5, '{\"message\":\"You\\u2019ve reached 2! Thank you for your generosity.\",\"level\":2}', NULL, '2025-07-17 05:53:12', '2025-07-17 05:53:12'),
('00dc5f67-08dc-4525-a33a-6eda8c6145ab', 'App\\Notifications\\DocumentUploaded', 'App\\Models\\User', 1, '{\"user_id\":1,\"user_name\":\"Anonymous\",\"document_path\":\"documents\\/HE3EXbL6kUTrlZ8jcUV7ce6ds6DWj8yzyzpalr3d.jpg\",\"message\":\"Anonymous uploaded a new document.\"}', NULL, '2025-08-26 05:22:28', '2025-08-26 05:22:28'),
('04947eae-2f32-4471-b165-43c12be88d56', 'App\\Notifications\\PickupScheduled', 'App\\Models\\User', 1, '{\"volunteer_id\":1,\"volunteer_name\":\"Anonymous\",\"donation_id\":57,\"scheduled_at\":\"2025-08-29 18:00:00\",\"notes\":null,\"message\":\"Anonymous scheduled a pickup for donation #57.\"}', NULL, '2025-08-24 13:04:25', '2025-08-24 13:04:25'),
('075ae860-dc9e-458d-881c-1af7d55be129', 'App\\Notifications\\DocumentUploaded', 'App\\Models\\User', 1, '{\"user_id\":1,\"user_name\":\"Anonymous\",\"document_path\":\"documents\\/6K7StCOpAZTj6M2DO19ruuGZf1GgPbVHRbC5mtnU.jpg\",\"message\":\"Anonymous uploaded a new document.\"}', NULL, '2025-08-25 08:05:21', '2025-08-25 08:05:21'),
('0987fbb9-fcc5-4474-8fcd-3396a80d1b04', 'App\\Notifications\\DocumentUploaded', 'App\\Models\\User', 1, '{\"user_id\":1,\"user_name\":\"Anonymous\",\"document_path\":\"documents\\/mq7MtgMwK3XFArVVhBc5dblU6NgP9kYM549rB9Bm.png\",\"message\":\"Anonymous uploaded a new document.\"}', NULL, '2025-08-25 07:40:13', '2025-08-25 07:40:13'),
('09be5ace-96c5-4129-96fa-38e24911950a', 'App\\Notifications\\PartnerLevelUp', 'App\\Models\\User', 5, '{\"message\":\"You\\u2019ve reached 1! Thank you for your generosity.\",\"level\":1}', NULL, '2025-07-20 14:53:07', '2025-07-20 14:53:07'),
('0ff206e1-f284-4e8b-99c5-f035adcf63fc', 'App\\Notifications\\VolunteerSignedUp', 'App\\Models\\User', 1, '{\"volunteer_id\":1,\"volunteer_name\":\"alice\",\"donation_id\":8,\"donation_category\":null,\"message\":\"alice volunteered for your donation.\"}', NULL, '2025-07-14 06:02:49', '2025-07-14 06:02:49'),
('1a32526f-1b43-495a-9212-b18e3c3ad774', 'App\\Notifications\\PartnerRequestReceived', 'App\\Models\\User', 6, '{\"message\":\"You have received a new partner request from Turkcell manager\",\"request_id\":5}', NULL, '2025-07-20 11:40:08', '2025-07-20 11:40:08'),
('1a756e45-8590-45d7-9916-b81b11b3a2e6', 'App\\Notifications\\PickupScheduled', 'App\\Models\\User', 2, '{\"volunteer_id\":1,\"volunteer_name\":\"alice\",\"donation_id\":1,\"scheduled_at\":\"2025-07-08 14:50:00\",\"notes\":\"awdf\",\"message\":\"alice scheduled a pickup for donation #1.\"}', NULL, '2025-07-08 08:48:31', '2025-07-08 08:48:31'),
('24b6a55a-df34-4649-8b09-c6287e3999fe', 'App\\Notifications\\DocumentUploaded', 'App\\Models\\User', 1, '{\"user_id\":1,\"user_name\":\"Anonymous\",\"document_path\":\"documents\\/kT9eaxvK4TcbNwUnsZZ7JoJRaz4XL2ZVwEgU1jF8.pdf\",\"message\":\"Anonymous uploaded a new document.\"}', NULL, '2025-08-26 05:13:08', '2025-08-26 05:13:08'),
('252def82-f4d2-42ef-bb76-b1c7e7c5808d', 'App\\Notifications\\DocumentUploaded', 'App\\Models\\User', 2, '{\"user_id\":1,\"user_name\":\"Anonymous\",\"document_path\":\"documents\\/kT9eaxvK4TcbNwUnsZZ7JoJRaz4XL2ZVwEgU1jF8.pdf\",\"message\":\"Anonymous uploaded a new document.\"}', NULL, '2025-08-26 05:13:09', '2025-08-26 05:13:09'),
('25e3b892-f9f3-49e2-976e-fc23c6684e2c', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 5, '{\"note\":\"trds\",\"message\":\"Admin requested additional documents.\"}', NULL, '2025-08-25 08:04:40', '2025-08-25 08:04:40'),
('2b6f205b-b325-4b79-bff0-5b3705049461', 'App\\Notifications\\VolunteerSignedUp', 'App\\Models\\User', 1, '{\"volunteer_id\":5,\"volunteer_name\":\"Abba\",\"donation_id\":5,\"donation_category\":\"Vegtables\",\"message\":\"Abba volunteered for your donation.\"}', NULL, '2025-07-16 08:31:06', '2025-07-16 08:31:06'),
('2be074f5-2bb8-414c-963e-35be00de822c', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 5, '{\"message\":\"Document request sent\",\"token\":\"V72BVlznSEoy9rcFhx5pZY5vBQSUNeDmxQ3nJMNwmqYIq4Sy\"}', NULL, '2025-08-25 09:59:32', '2025-08-25 09:59:32'),
('2be3b6d5-3aa7-4298-a830-8496d6712287', 'App\\Notifications\\VolunteerSignedUp', 'App\\Models\\User', 2, '{\"volunteer_id\":1,\"volunteer_name\":\"alice\",\"donation_id\":1,\"donation_category\":\"Pizza\",\"message\":\"alice volunteered for your donation.\"}', NULL, '2025-07-08 08:48:11', '2025-07-08 08:48:11'),
('305e9507-cc0d-43db-ab89-93913ee0b05f', 'App\\Notifications\\PartnerRequestReceived', 'App\\Models\\User', 6, '{\"message\":\"You have received a new partner request from Abba\",\"request_id\":7}', NULL, '2025-07-20 13:41:37', '2025-07-20 13:41:37'),
('32e49ceb-225b-4633-b28e-8f1197f390a7', 'App\\Notifications\\FoodRequestReceived', 'App\\Models\\User', 6, '{\"message\":\"You received a new food request from Abba\",\"food_request_id\":5}', NULL, '2025-07-20 09:27:38', '2025-07-20 09:27:38'),
('364bc675-78d5-4674-8411-e6a7f163522d', 'App\\Notifications\\PartnerRequestReceived', 'App\\Models\\User', 6, '{\"message\":\"You have received a new partner request from Turkcell manager\",\"request_id\":4}', NULL, '2025-07-20 10:15:35', '2025-07-20 10:15:35'),
('3731d0a3-5507-4931-bdde-427b1d092cb9', 'App\\Notifications\\VolunteerSignedUp', 'App\\Models\\User', 1, '{\"volunteer_id\":5,\"volunteer_name\":\"Abba\",\"donation_id\":5,\"donation_category\":\"Vegtables\",\"message\":\"Abba volunteered for your donation.\"}', NULL, '2025-07-16 05:30:27', '2025-07-16 05:30:27'),
('376d9227-eb54-4039-8123-49aa32fe7d22', 'App\\Notifications\\PickupScheduled', 'App\\Models\\User', 1, '{\"volunteer_id\":1,\"volunteer_name\":\"Anonymous\",\"donation_id\":57,\"scheduled_at\":\"2025-08-26 17:00:00\",\"notes\":\"oijuh\",\"message\":\"Anonymous scheduled a pickup for donation #57.\"}', NULL, '2025-08-24 12:47:59', '2025-08-24 12:47:59'),
('3be09445-7444-4b94-abec-102b6875015e', 'App\\Notifications\\VolunteerSignedUp', 'App\\Models\\User', 1, '{\"volunteer_id\":5,\"volunteer_phone\":\"+90 533 822 28 28\",\"volunteer_skills\":\"Manager\",\"volunteer_availability\":\"Everyday\",\"donation_id\":5,\"donation_category\":\"Vegtables\",\"message\":\"Abba (phone: +90 533 822 28 28) volunteered for your donation.\"}', NULL, '2025-07-16 08:56:27', '2025-07-16 08:56:27'),
('3ced6223-e1a1-492f-949a-a4d9cdee9337', 'App\\Notifications\\DocumentUploaded', 'App\\Models\\User', 2, '{\"user_id\":1,\"user_name\":\"Anonymous\",\"document_path\":\"documents\\/HE3EXbL6kUTrlZ8jcUV7ce6ds6DWj8yzyzpalr3d.jpg\",\"message\":\"Anonymous uploaded a new document.\"}', NULL, '2025-08-26 05:22:29', '2025-08-26 05:22:29'),
('3fff6e78-c4f6-4900-9205-964027ee354d', 'App\\Notifications\\VolunteerSignedUp', 'App\\Models\\User', 1, '{\"volunteer_id\":5,\"volunteer_phone\":\"+90 533 822 28 28\",\"volunteer_skills\":\"Manager\",\"volunteer_availability\":\"Everyday\",\"donation_id\":5,\"donation_category\":\"Vegtables\",\"message\":\"Abba (phone: +90 533 822 28 28) volunteered for your donation.\"}', NULL, '2025-07-16 08:54:21', '2025-07-16 08:54:21'),
('43c50d1f-0bb2-42c5-8f4a-f353c88c747e', 'App\\Notifications\\PickupScheduled', 'App\\Models\\User', 5, '{\"volunteer_id\":8,\"volunteer_name\":\"Samsung Manager\",\"donation_id\":54,\"scheduled_at\":\"2025-07-26 08:00:00\",\"notes\":null,\"message\":\"Samsung Manager scheduled a pickup for donation #54.\"}', NULL, '2025-07-25 03:46:02', '2025-07-25 03:46:02'),
('47bb7901-bf6e-4a3e-9d75-c5f824005ce5', 'App\\Notifications\\PartnerLevelUp', 'App\\Models\\User', 6, '{\"message\":\"You\\u2019ve reached 1! Thank you for your generosity.\",\"level\":1}', NULL, '2025-07-19 09:04:27', '2025-07-19 09:04:27'),
('49ba41f8-fee3-4788-82ae-bb411c6ff35a', 'App\\Notifications\\PickupScheduled', 'App\\Models\\User', 5, '{\"volunteer_id\":5,\"volunteer_name\":\"Abba\",\"donation_id\":12,\"scheduled_at\":\"2025-07-28 20:00:00\",\"notes\":\"hhh\",\"message\":\"Abba scheduled a pickup for donation #12.\"}', NULL, '2025-07-20 15:46:02', '2025-07-20 15:46:02'),
('4cb529b2-5758-437d-b9e0-6dec095e870f', 'App\\Notifications\\PickupScheduled', 'App\\Models\\User', 5, '{\"volunteer_id\":8,\"volunteer_name\":\"Samsung Manager\",\"donation_id\":53,\"scheduled_at\":\"2025-07-26 08:00:00\",\"notes\":\"fds\",\"message\":\"Samsung Manager scheduled a pickup for donation #53.\"}', NULL, '2025-07-25 03:42:59', '2025-07-25 03:42:59'),
('4dfbbc6a-ac14-452a-9f62-8c18ac05b6e3', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 1, '{\"note\":\"fghjk\",\"message\":\"Admin requested additional documents.\"}', NULL, '2025-08-25 05:48:15', '2025-08-25 05:48:15'),
('50052829-a39c-4a4c-895a-18947c08a3fd', 'App\\Notifications\\VolunteerSignedUp', 'App\\Models\\User', 1, '{\"volunteer_id\":5,\"volunteer_name\":\"Abba\",\"donation_id\":5,\"donation_category\":\"Vegtables\",\"message\":\"Abba volunteered for your donation.\"}', NULL, '2025-07-16 08:23:30', '2025-07-16 08:23:30'),
('5025d3d9-ee09-4b4d-94f7-67b44958ead9', 'App\\Notifications\\PartnerStatusUpdated', 'App\\Models\\User', 5, '{\"partner_id\":5,\"status\":\"pending\",\"message\":\"Your organization status was updated to \'pending\'.\"}', NULL, '2025-07-20 12:45:23', '2025-07-20 12:45:23'),
('51bec880-2f6b-4d7c-9341-1f0d1c3124d3', 'App\\Notifications\\VolunteerSignedUp', 'App\\Models\\User', 1, '{\"volunteer_id\":1,\"volunteer_name\":\"alice\",\"donation_id\":8,\"donation_category\":null,\"message\":\"alice volunteered for your donation.\"}', NULL, '2025-07-11 03:32:43', '2025-07-11 03:32:43'),
('59f24a80-27c2-433f-9dd4-90c568d490fe', 'App\\Notifications\\PartnerRequestReceived', 'App\\Models\\User', 8, '{\"message\":\"You have received a new partner request from Samsung Manager\",\"request_id\":9}', NULL, '2025-08-06 08:27:07', '2025-08-06 08:27:07'),
('5a668937-cc4a-4abe-a6ff-2d11f1fce2bd', 'App\\Notifications\\PickupScheduled', 'App\\Models\\User', 1, '{\"volunteer_id\":1,\"volunteer_name\":\"Anonymous\",\"donation_id\":57,\"scheduled_at\":\"2025-08-31 18:00:00\",\"notes\":null,\"message\":\"Anonymous scheduled a pickup for donation #57.\"}', NULL, '2025-08-24 13:15:24', '2025-08-24 13:15:24'),
('5e35a085-96a9-4303-98f4-6b5cfe26b25a', 'App\\Notifications\\PartnerLevelUp', 'App\\Models\\User', 8, '{\"message\":\"You\\u2019ve reached 1! Thank you for your generosity.\",\"level\":1}', NULL, '2025-08-24 03:57:39', '2025-08-24 03:57:39'),
('61d69201-8112-4b05-a356-fbd2422abc92', 'App\\Notifications\\PartnerLevelUp', 'App\\Models\\User', 8, '{\"message\":\"You\\u2019ve reached 1! Thank you for your generosity.\",\"level\":1}', NULL, '2025-08-24 03:48:42', '2025-08-24 03:48:42'),
('663d3803-6e9a-4615-b79d-60bcfdd63ee4', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 5, '{\"note\":\"fds\",\"message\":\"Admin requested additional documents.\"}', NULL, '2025-08-25 08:29:06', '2025-08-25 08:29:06'),
('6c3544f1-cdaa-4cf5-bb30-c900c00ca7c4', 'App\\Notifications\\PickupScheduled', 'App\\Models\\User', 1, '{\"volunteer_id\":1,\"volunteer_name\":\"Anonymous\",\"donation_id\":57,\"scheduled_at\":\"2025-08-30 18:00:00\",\"notes\":\"kjhgfd\",\"message\":\"Anonymous scheduled a pickup for donation #57.\"}', NULL, '2025-08-24 13:02:13', '2025-08-24 13:02:13'),
('6f93af92-07ce-4fda-a3c1-096a04ea6a48', 'App\\Notifications\\PickupScheduled', 'App\\Models\\User', 1, '{\"volunteer_id\":1,\"volunteer_name\":\"Anonymous\",\"donation_id\":57,\"scheduled_at\":\"2025-08-24 19:00:00\",\"notes\":\"iugtfhydgf\",\"message\":\"Anonymous scheduled a pickup for donation #57.\"}', NULL, '2025-08-24 13:00:20', '2025-08-24 13:00:20'),
('726c9625-b95b-42c7-94e0-0c29ac72b5b1', 'App\\Notifications\\PartnerStatusUpdated', 'App\\Models\\User', 1, '{\"partner_id\":1,\"status\":\"pending\",\"message\":\"Your organization status was updated to \'pending\'.\"}', NULL, '2025-07-15 04:31:44', '2025-07-15 04:31:44'),
('73557a23-e8b8-45ec-9e2b-53453d69ba1a', 'App\\Notifications\\VolunteerConfirmation', 'App\\Models\\User', 1, '{\"donation_id\":7,\"title\":\"Apple pie\",\"city\":\"Paris\",\"available_from\":\"2025-07-23 15:00:00\",\"available_to\":\"2025-08-14 21:00:00\",\"volunteer_note\":\"come on time pls\",\"donor_name\":\"alice\",\"donor_email\":\"alice@gmail.com\",\"message\":\"You\\u2019ve volunteered for \\u201cApple pie\\u201d in Paris.\\nDistribution will take place from 2025-07-23 15:00:00 to 21:00:00.\\nDonor: alice can be contacted at (alice@gmail.com)\\nNote from the donor: come on time pls\"}', NULL, '2025-08-14 04:58:38', '2025-08-14 04:58:38'),
('746ad8b3-941e-48f3-8401-314760b029b8', 'App\\Notifications\\VolunteerSignedUp', 'App\\Models\\User', 1, '{\"volunteer_id\":5,\"volunteer_name\":\"Abba\",\"donation_id\":5,\"donation_category\":\"Vegtables\",\"message\":\"Abba volunteered for your donation.\"}', NULL, '2025-07-16 05:20:38', '2025-07-16 05:20:38'),
('75abb220-62fe-49ee-8704-7d389904f25e', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 5, '{\"note\":\"docu\",\"message\":\"Admin requested additional documents.\"}', NULL, '2025-08-25 08:03:16', '2025-08-25 08:03:16'),
('7b43d773-e541-4e78-bef7-9ab09d262a03', 'App\\Notifications\\VolunteerConfirmation', 'App\\Models\\User', 1, '{\"donation_id\":2,\"title\":\"Lunch Sandwiches\",\"city\":\"Kyrenia\",\"available_from\":\"2025-07-23 11:52:00\",\"available_to\":\"2025-08-14 14:00:00\",\"volunteer_note\":\"We need a volunteer.\",\"donor_name\":\"alice\",\"donor_email\":\"alice@gmail.com\",\"message\":\"You\\u2019ve volunteered for \\u201cLunch Sandwiches\\u201d in Kyrenia.\\nDistribution will take place from 2025-07-23 11:52:00 to 14:00:00.\\nDonor: alice can be contacted at (alice@gmail.com)\\nNote from the donor: We need a volunteer.\"}', NULL, '2025-08-14 05:04:18', '2025-08-14 05:04:18'),
('7cc7d1c3-4acd-4414-9476-f6110b5c08fb', 'App\\Notifications\\PartnerRequestReceived', 'App\\Models\\User', 6, '{\"message\":\"You have received a new partner request from Turkcell manager\",\"request_id\":3}', NULL, '2025-07-20 10:04:13', '2025-07-20 10:04:13'),
('7f25916a-2f32-4848-9c40-5a4b4c143f2e', 'App\\Notifications\\PickupScheduled', 'App\\Models\\User', 1, '{\"volunteer_id\":1,\"volunteer_name\":\"Anonymous\",\"donation_id\":57,\"scheduled_at\":\"2025-08-24 21:03:00\",\"notes\":null,\"message\":\"Anonymous scheduled a pickup for donation #57.\"}', NULL, '2025-08-24 13:05:50', '2025-08-24 13:05:50'),
('7f6bd052-7a27-4e48-a1ad-96136efef2e1', 'App\\Notifications\\PickupScheduled', 'App\\Models\\User', 1, '{\"volunteer_id\":1,\"volunteer_name\":\"alice\",\"donation_id\":5,\"scheduled_at\":\"2025-07-08 13:39:00\",\"notes\":\"Need 3 portions\",\"message\":\"alice scheduled a pickup for donation #5.\"}', NULL, '2025-07-08 07:39:21', '2025-07-08 07:39:21'),
('83c5b1e5-dd4a-4399-9391-b1f8ef2d5129', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 5, '{\"message\":\"Document request sent\",\"token\":\"G6QYrGkAY2iDRpv2VcgXe1tX8KpXT672ysOx5GZb385Pmv6e\"}', NULL, '2025-08-25 11:04:09', '2025-08-25 11:04:09'),
('84f1b309-a77f-4ae3-84a1-9b758987a77d', 'App\\Notifications\\PartnerStatusUpdated', 'App\\Models\\User', 6, '{\"partner_id\":6,\"status\":\"suspended\",\"message\":\"Your organization status was updated to \'suspended\'.\"}', NULL, '2025-08-14 05:31:15', '2025-08-14 05:31:15'),
('86c5d8df-adce-4032-a2a5-d6052e25ce05', 'App\\Notifications\\DocumentUploaded', 'App\\Models\\User', 2, '{\"user_id\":1,\"user_name\":\"Anonymous\",\"document_path\":\"documents\\/6K7StCOpAZTj6M2DO19ruuGZf1GgPbVHRbC5mtnU.jpg\",\"message\":\"Anonymous uploaded a new document.\"}', NULL, '2025-08-25 08:05:22', '2025-08-25 08:05:22'),
('881f3ffa-cd86-4cdf-8cd8-60cf3a112298', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 5, '{\"note\":\"bngj\",\"message\":\"Admin requested additional documents.\"}', NULL, '2025-08-25 08:37:49', '2025-08-25 08:37:49'),
('916f05e9-1bf1-49a1-877f-729aaef29442', 'App\\Notifications\\PartnerLevelUp', 'App\\Models\\User', 5, '{\"message\":\"You\\u2019ve reached 1! Thank you for your generosity.\",\"level\":1}', NULL, '2025-07-17 05:50:43', '2025-07-17 05:50:43'),
('96937f2c-a6ac-4d6d-8350-e4f8ae3a829d', 'App\\Notifications\\PickupScheduled', 'App\\Models\\User', 1, '{\"volunteer_id\":1,\"volunteer_name\":\"Anonymous\",\"donation_id\":57,\"scheduled_at\":\"2025-08-30 18:00:00\",\"notes\":null,\"message\":\"Anonymous scheduled a pickup for donation #57.\"}', NULL, '2025-08-24 13:14:32', '2025-08-24 13:14:32'),
('97ab4fe4-2d3c-424f-aab8-7156440aa3fc', 'App\\Notifications\\PartnerStatusUpdated', 'App\\Models\\User', 8, '{\"partner_id\":7,\"status\":\"approved\",\"message\":\"Your organization status was updated to \'approved\'.\"}', NULL, '2025-07-22 09:45:27', '2025-07-22 09:45:27'),
('987be115-3506-4339-b052-bcce5df139e4', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 1, '{\"note\":\"vbnm,\",\"message\":\"Admin requested additional documents.\"}', NULL, '2025-08-25 07:39:55', '2025-08-25 07:39:55'),
('99f1d20f-9ce4-4224-bcf6-1c8509caba58', 'App\\Notifications\\PartnerLevelUp', 'App\\Models\\User', 1, '{\"message\":\"You\\u2019ve reached 1! Thank you for your generosity.\",\"level\":1}', NULL, '2025-07-17 05:47:08', '2025-07-17 05:47:08'),
('9dd5abb0-0f9f-41c2-a7d9-d24437af8cb7', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 1, '{\"message\":\"Document request sent\",\"token\":\"tE62K19OIxZfGy2FL3TXmk13NUP23wxfnyfFxQSQaGXr91Ws\"}', NULL, '2025-08-26 05:16:47', '2025-08-26 05:16:47'),
('9e446862-8397-4288-ba22-757aeb989cb5', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 1, '{\"note\":\"gfd\",\"message\":\"Admin requested additional documents.\"}', NULL, '2025-08-25 07:37:29', '2025-08-25 07:37:29'),
('a496c715-63d3-4c83-86c4-01e75cae6a1c', 'App\\Notifications\\PickupScheduled', 'App\\Models\\User', 5, '{\"volunteer_id\":8,\"volunteer_name\":\"Samsung Manager\",\"donation_id\":8,\"scheduled_at\":\"2025-08-08 13:00:00\",\"notes\":\"jh\",\"message\":\"Samsung Manager scheduled a pickup for donation #8.\"}', NULL, '2025-08-06 08:33:05', '2025-08-06 08:33:05'),
('a5b44682-20fc-4340-8ca0-2d58f0a8891a', 'App\\Notifications\\DocumentUploaded', 'App\\Models\\User', 2, '{\"user_id\":1,\"user_name\":\"Anonymous\",\"document_path\":\"documents\\/mq7MtgMwK3XFArVVhBc5dblU6NgP9kYM549rB9Bm.png\",\"message\":\"Anonymous uploaded a new document.\"}', NULL, '2025-08-25 07:40:15', '2025-08-25 07:40:15'),
('a5d332bf-6f00-402b-8d00-6add06599199', 'App\\Notifications\\PartnerRequestReceived', 'App\\Models\\User', 6, '{\"message\":\"You have received a new partner request from Samsung Manager\",\"request_id\":8}', NULL, '2025-08-06 08:26:33', '2025-08-06 08:26:33'),
('a762f489-e2c4-4b8a-85ea-9b06497f7107', 'App\\Notifications\\PartnerLevelUp', 'App\\Models\\User', 5, '{\"message\":\"You\\u2019ve reached 2! Thank you for your generosity.\",\"level\":2}', NULL, '2025-07-22 04:08:07', '2025-07-22 04:08:07'),
('a8c35d05-4986-42a9-9ae5-6b79680ff095', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 1, '{\"message\":\"Document request sent\",\"token\":\"puH0sU24VGG25XSIcJ7BDjqLNfgVQFSGoEyv5ubVueJmjkxg\"}', NULL, '2025-08-26 05:21:15', '2025-08-26 05:21:15'),
('ab284f03-0bd5-4db6-925c-d99995e42d8c', 'App\\Notifications\\VolunteerSignedUp', 'App\\Models\\User', 1, '{\"volunteer_id\":1,\"volunteer_phone\":\"+90 533 853 10 63\",\"volunteer_skills\":\"driving\",\"volunteer_availability\":\"everyday\",\"donation_id\":2,\"donation_category\":\"Sandwiches\",\"message\":\"alice (phone: +90 533 853 10 63) volunteered for your donation.\"}', NULL, '2025-08-14 05:04:17', '2025-08-14 05:04:17'),
('af3f4b6d-cba6-492b-9ccd-b2cddfcbd792', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 1, '{\"message\":\"Document request sent\",\"token\":\"Lcjxqff2Np9gs2syRdUyQp6kQ7ZkS3bBNK6pQ9xzWRiQgoGf\"}', NULL, '2025-08-25 10:52:09', '2025-08-25 10:52:09'),
('b231b471-1183-40ab-b5d3-a8a5cbbb8f95', 'App\\Notifications\\PartnerStatusUpdated', 'App\\Models\\User', 6, '{\"partner_id\":6,\"status\":\"approved\",\"message\":\"Your organization status was updated to \'approved\'.\"}', NULL, '2025-07-20 09:22:50', '2025-07-20 09:22:50'),
('b274e6cf-fe24-42aa-87cf-2b9a13d691e2', 'App\\Notifications\\PartnerStatusUpdated', 'App\\Models\\User', 1, '{\"partner_id\":1,\"status\":\"approved\",\"message\":\"Your organization status was updated to \'approved\'.\"}', NULL, '2025-07-15 04:31:55', '2025-07-15 04:31:55'),
('b4283f45-3131-462f-bacf-e0b32e11c4bd', 'App\\Notifications\\VolunteerSignedUp', 'App\\Models\\User', 1, '{\"volunteer_id\":1,\"volunteer_name\":\"alice\",\"donation_id\":2,\"donation_category\":\"Sandwiches\",\"message\":\"alice volunteered for your donation.\"}', NULL, '2025-07-11 03:37:02', '2025-07-11 03:37:02'),
('b70211a4-f6cb-4afd-ae5b-3395d9659c89', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 1, '{\"note\":\"gfhdjs\",\"message\":\"Admin requested additional documents.\"}', NULL, '2025-08-25 05:58:55', '2025-08-25 05:58:55'),
('b7b472a5-67cc-4c26-bc8e-505f4ce523b5', 'App\\Notifications\\PartnerLevelUp', 'App\\Models\\User', 8, '{\"message\":\"You\\u2019ve reached 1! Thank you for your generosity.\",\"level\":1}', NULL, '2025-07-23 05:19:40', '2025-07-23 05:19:40'),
('bb29ee9a-8624-4b19-bab2-0fb17d2f8e5f', 'App\\Notifications\\PickupScheduled', 'App\\Models\\User', 1, '{\"volunteer_id\":1,\"volunteer_name\":\"Anonymous\",\"donation_id\":57,\"scheduled_at\":\"2025-08-29 18:00:00\",\"notes\":null,\"message\":\"Anonymous scheduled a pickup for donation #57.\"}', NULL, '2025-08-24 13:06:43', '2025-08-24 13:06:43'),
('bc89c24c-a548-4469-9360-17514c4328df', 'App\\Notifications\\PickupScheduled', 'App\\Models\\User', 1, '{\"volunteer_id\":1,\"volunteer_name\":\"Anonymous\",\"donation_id\":57,\"scheduled_at\":\"2025-08-30 18:00:00\",\"notes\":null,\"message\":\"Anonymous scheduled a pickup for donation #57.\"}', NULL, '2025-08-24 13:10:00', '2025-08-24 13:10:00'),
('c66b1c66-3e1d-49b7-ad1e-5c9addf8392f', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 1, '{\"message\":\"Document request sent\",\"token\":\"xTbzBx8e8kj2p9GdtJdEHEGmwMx2DWK9OdxnvS2StFwUxWbz\"}', NULL, '2025-08-26 05:06:57', '2025-08-26 05:06:57'),
('cd5ddfab-20cd-4bf8-9c58-026cca1cdbb1', 'App\\Notifications\\VolunteerSignedUp', 'App\\Models\\User', 1, '{\"volunteer_id\":5,\"volunteer_name\":\"Abba\",\"donation_id\":2,\"donation_category\":\"Sandwiches\",\"message\":\"Abba volunteered for your donation.\"}', NULL, '2025-07-15 09:13:46', '2025-07-15 09:13:46'),
('ce092931-292a-4c9a-be82-5432c7cb047a', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 1, '{\"message\":\"Document request sent\",\"token\":\"G2JFfexXuEzkPngwNMr1hCXtPYB0J8HBJFGtZN7sixZjGd2u\"}', NULL, '2025-08-25 10:55:16', '2025-08-25 10:55:16'),
('d5095ee1-d90e-44ae-9e5c-45409c515320', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 1, '{\"message\":\"Document request sent\",\"token\":\"l21dt0Aaul07Q3lqcZG2MWZ5j5rst6P6Z1nHW2ogPac6bZMC\"}', NULL, '2025-08-26 05:12:44', '2025-08-26 05:12:44'),
('d5d6f39f-625b-4a7a-8e51-e1897ae156b3', 'App\\Notifications\\VolunteerSignedUp', 'App\\Models\\User', 1, '{\"volunteer_id\":1,\"volunteer_name\":\"alice\",\"donation_id\":8,\"donation_category\":null,\"message\":\"alice volunteered for your donation.\"}', NULL, '2025-07-11 03:18:08', '2025-07-11 03:18:08'),
('df060986-4f98-4128-a84e-42a28c58c629', 'App\\Notifications\\PartnerRequestReceived', 'App\\Models\\User', 6, '{\"message\":\"You have received a new partner request from alice\",\"request_id\":6}', NULL, '2025-07-20 11:45:31', '2025-07-20 11:45:31'),
('e4b573fa-b514-42a7-b0ca-efee7a47404b', 'App\\Notifications\\VolunteerSignedUp', 'App\\Models\\User', 1, '{\"volunteer_id\":1,\"volunteer_phone\":\"+33612345678\",\"volunteer_skills\":\"Driving, organizing\",\"volunteer_availability\":\"Weekends\",\"donation_id\":7,\"donation_category\":\"Dessert\",\"message\":\"alice (phone: +33612345678) volunteered for your donation.\"}', NULL, '2025-08-14 04:58:36', '2025-08-14 04:58:36'),
('e54bc24c-767d-4ab3-b1b7-b69d6fe5e4fa', 'App\\Notifications\\PartnerLevelUp', 'App\\Models\\User', 5, '{\"message\":\"You\\u2019ve reached 2! Thank you for your generosity.\",\"level\":2}', NULL, '2025-07-22 04:04:53', '2025-07-22 04:04:53'),
('e934c360-bf29-45be-b1a6-ab84c4400876', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 5, '{\"message\":\"Document request sent\",\"token\":\"M17aFIv0HF6UcM4ngyAW4GMjRwBVImuYruV9ukcyvLbi9bau\"}', NULL, '2025-08-25 11:05:23', '2025-08-25 11:05:23'),
('ea6356a8-6da8-49f6-ac11-7011fe08f9b7', 'App\\Notifications\\VolunteerSignedUp', 'App\\Models\\User', 1, '{\"volunteer_id\":1,\"volunteer_name\":\"alice\",\"donation_id\":6,\"donation_category\":\"Fruit\",\"message\":\"alice volunteered for your donation.\"}', NULL, '2025-07-08 05:51:08', '2025-07-08 05:51:08'),
('f0417ad9-6e22-4c82-86e3-7fdec14cb4c9', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 1, '{\"note\":\"passport\",\"message\":\"Admin requested additional documents.\"}', NULL, '2025-08-25 07:30:14', '2025-08-25 07:30:14'),
('ff004df3-79e5-4d05-b582-22652315a062', 'App\\Notifications\\DocumentRequestMail', 'App\\Models\\User', 5, '{\"note\":\"tfrde\",\"message\":\"Admin requested additional documents.\"}', NULL, '2025-08-25 08:16:01', '2025-08-25 08:16:01');

-- --------------------------------------------------------

--
-- Structure de la table `organization_partner_requests`
--

CREATE TABLE IF NOT EXISTS `organization_partner_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `partner_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `partners`
--

CREATE TABLE IF NOT EXISTS `partners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `document_path` varchar(255) DEFAULT NULL,
  `document_request_token` varchar(255) DEFAULT NULL,
  `document_request_expires_at` timestamp NULL DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('pending','approved','suspended') NOT NULL DEFAULT 'pending',
  `sponsor_level` enum('platinum','gold','silver','bronze') DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `linked_partner_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `partners`
--

INSERT IGNORE INTO `partners` (`id`, `name`, `type`, `document_path`, `document_request_token`, `document_request_expires_at`, `contact_email`, `contact_phone`, `address`, `status`, `sponsor_level`, `level`, `created_at`, `updated_at`, `user_id`, `role`, `linked_partner_id`) VALUES
(5, 'Steak House', 'Restaurant', 'documents/PBQ9QwMVf6JoEL8lUmiYaHC2IL6iDPRTL1dLJKUk.jpg', NULL, '2025-09-01 11:05:17', 'ismael.diakite@final.edu.tr', '+22383314849', 'Bamako , route 26', 'pending', NULL, 2, '2025-07-15 03:54:06', '2025-08-25 11:06:01', 5, 'organization', NULL),
(6, 'Turkcell', 'Company', 'documents/0z2kzjX3sKMdyOfUlglsxCFzBkIizZknBnaFatGv.pdf', NULL, NULL, 'turkcell-management@gmail.com', '+90 83314849', 'karakum , road 66', 'suspended', NULL, 1, '2025-07-19 08:09:23', '2025-08-14 05:31:12', 6, 'partner', NULL),
(7, 'Samsung', 'Company', 'documents/S7XEHNLiK4faBPha2gh70YydYhP6GDo6CfHw3Tra.pdf', NULL, NULL, 'samsung-managment@gmail.com', '+90 83456849', 'Korea , road 66', 'approved', NULL, 1, '2025-07-22 09:34:24', '2025-07-22 09:45:14', 8, 'partner', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `partner_requests`
--

CREATE TABLE IF NOT EXISTS `partner_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `partner_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `partner_requests`
--

INSERT IGNORE INTO `partner_requests` (`id`, `partner_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(4, 6, 6, 'accepted', '2025-07-20 10:15:32', '2025-07-20 12:11:05'),
(6, 6, 1, 'rejected', '2025-07-20 11:45:27', '2025-07-20 12:12:04'),
(7, 6, 5, 'accepted', '2025-07-20 13:41:28', '2025-07-20 13:43:48'),
(8, 6, 8, 'pending', '2025-08-06 08:26:26', '2025-08-06 08:26:26'),
(9, 7, 8, 'accepted', '2025-08-06 08:27:03', '2025-08-06 08:27:27');

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `password_reset_tokens`
--

INSERT IGNORE INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('isadiak98@gmail.com', '$2y$12$dtBLlV8vxAZumhLEOhJNLexC/mSXgJJveHDuVklHNSnJzzqmz8fni', '2025-07-21 04:18:04');

-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `personal_access_tokens`
--

INSERT IGNORE INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'main', 'e4a8187cee2418340422ce443eb7cd9940261f3bb565645af6508930958e6a22', '[\"*\"]', NULL, NULL, '2025-07-03 04:07:13', '2025-07-03 04:07:13'),
(2, 'App\\Models\\User', 1, 'main', '5c84e4d04b8862ce02b905938e86efaf82f8a54eb0ed917540b2a2d9d2c5b5e0', '[\"*\"]', '2025-07-03 04:07:42', NULL, '2025-07-03 04:07:18', '2025-07-03 04:07:42'),
(3, 'App\\Models\\User', 1, 'main', '4a0d54b5e23ad28b31937d1bc4e99b0941e0837308dd47483a728a582fc60d26', '[\"*\"]', '2025-07-03 04:49:13', NULL, '2025-07-03 04:21:29', '2025-07-03 04:49:13'),
(4, 'App\\Models\\User', 1, 'main', '0b111913bf98313305314e8ed57d6ff6c82c996e9ccc364965bbfb635ea0e823', '[\"*\"]', '2025-07-03 04:45:11', NULL, '2025-07-03 04:38:58', '2025-07-03 04:45:11'),
(5, 'App\\Models\\User', 1, 'main', '1b60a878cd091ba04853d933fce87f2f85d8955eb255146f199b4b8a1cd0c93b', '[\"*\"]', '2025-07-07 03:28:25', NULL, '2025-07-03 05:12:13', '2025-07-07 03:28:25'),
(6, 'App\\Models\\User', 1, 'main', 'a1b3af0f91acbeaea4b3e7f2437bba3dc061de723a42f3e18f3b2142c6698882', '[\"*\"]', '2025-07-04 07:30:01', NULL, '2025-07-03 05:18:24', '2025-07-04 07:30:01'),
(7, 'App\\Models\\User', 1, 'main', '5c217c4b0d7cba3d5b8fc407fb627744beabfd517464056d84b475190fa7d93b', '[\"*\"]', '2025-07-04 09:09:02', NULL, '2025-07-03 07:08:15', '2025-07-04 09:09:02'),
(8, 'App\\Models\\User', 1, 'main', '2af898713ceb1602b4fe8c1743d36587688580df09d47294ce74d19392618686', '[\"*\"]', '2025-07-03 08:44:20', NULL, '2025-07-03 08:36:26', '2025-07-03 08:44:20'),
(9, 'App\\Models\\User', 1, 'main', '36a7eb2e3fb29b5b42a5dae8104e106c5cf61318f59fcac8e3a146ce4911b662', '[\"*\"]', '2025-07-03 09:31:18', NULL, '2025-07-03 09:23:25', '2025-07-03 09:31:18'),
(10, 'App\\Models\\User', 1, 'main', 'a08a6a8b8da42bf37c7473188612a3675f5624338864f18cc96399065c55201e', '[\"*\"]', '2025-07-04 07:42:07', NULL, '2025-07-04 05:02:57', '2025-07-04 07:42:07'),
(11, 'App\\Models\\User', 1, 'main', 'd0074bd267e879ae0236b68a4bceca7ec96e612d9b9ed7d08f90ab025bf49ffb', '[\"*\"]', '2025-07-07 03:33:51', NULL, '2025-07-07 03:04:42', '2025-07-07 03:33:51'),
(12, 'App\\Models\\User', 1, 'main', '7a876bfb2720950fbc9e23ed7ac42a24b5e93ca7f7367cd1b8b78d1b558d88e9', '[\"*\"]', NULL, NULL, '2025-07-07 07:06:35', '2025-07-07 07:06:35'),
(13, 'App\\Models\\User', 1, 'main', '668c5332375bf1d927d0ce92cfec46eda22cafa0bf9693842bfea8bea575f410', '[\"*\"]', '2025-07-07 08:23:00', NULL, '2025-07-07 08:22:40', '2025-07-07 08:23:00'),
(14, 'App\\Models\\User', 1, 'main', '4ce41f7581ac9d5fadea3f48e9aaa27c42462fc9b59ab6da98330a7a35324675', '[\"*\"]', '2025-07-08 04:55:56', NULL, '2025-07-08 04:54:41', '2025-07-08 04:55:56');

-- --------------------------------------------------------

--
-- Structure de la table `pickups`
--

CREATE TABLE IF NOT EXISTS `pickups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `donation_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `scheduled_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pickups`
--

INSERT IGNORE INTO `pickups` (`id`, `donation_id`, `user_id`, `scheduled_at`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(2, 3, 1, '2025-07-04 16:00:00', 'pending', 'I will bring a bag', '2025-07-03 09:31:14', '2025-07-03 09:31:14'),
(3, 5, 1, '2025-07-09 10:30:00', 'pending', 'Need 3 portions', '2025-07-08 07:31:15', '2025-07-08 07:31:15'),
(4, 5, 1, '2025-07-09 10:32:00', 'pending', 'Need 3 portions', '2025-07-08 07:32:42', '2025-07-08 07:32:42'),
(5, 5, 1, '2025-07-08 10:39:00', 'pending', 'Need 3 portions', '2025-07-08 07:39:21', '2025-07-08 07:39:21'),
(6, 1, 1, '2025-07-08 11:50:00', 'pending', 'awdf', '2025-07-08 08:48:28', '2025-07-08 08:48:28'),
(7, 12, 5, '2025-07-28 17:00:00', 'pending', 'hhh', '2025-07-20 15:45:45', '2025-07-20 15:45:45'),
(8, 53, 8, '2025-07-26 05:00:00', 'pending', 'fds', '2025-07-25 03:42:58', '2025-07-25 03:42:58'),
(9, 54, 8, '2025-07-26 05:00:00', 'pending', NULL, '2025-07-25 03:45:45', '2025-07-25 03:45:45'),
(10, 8, 8, '2025-08-08 10:00:00', 'pending', 'jh', '2025-08-06 08:33:01', '2025-08-06 08:33:01'),
(11, 57, 1, '2025-08-26 14:00:00', 'pending', 'oijuh', '2025-08-24 12:47:54', '2025-08-24 12:47:54'),
(12, 57, 1, '2025-08-24 16:00:00', 'pending', 'iugtfhydgf', '2025-08-24 13:00:16', '2025-08-24 13:00:16'),
(13, 57, 1, '2025-08-30 15:00:00', 'pending', 'kjhgfd', '2025-08-24 13:02:11', '2025-08-24 13:02:11'),
(14, 57, 1, '2025-08-29 15:00:00', 'pending', NULL, '2025-08-24 13:04:21', '2025-08-24 13:04:21'),
(15, 57, 1, '2025-08-24 18:03:00', 'pending', NULL, '2025-08-24 13:05:46', '2025-08-24 13:05:46'),
(16, 57, 1, '2025-08-29 15:00:00', 'pending', NULL, '2025-08-24 13:06:41', '2025-08-24 13:06:41'),
(17, 57, 1, '2025-08-30 15:00:00', 'pending', NULL, '2025-08-24 13:09:58', '2025-08-24 13:09:58'),
(18, 57, 1, '2025-08-30 15:00:00', 'pending', NULL, '2025-08-24 13:14:29', '2025-08-24 13:14:29'),
(19, 57, 1, '2025-08-31 15:00:00', 'pending', NULL, '2025-08-24 13:15:22', '2025-08-24 13:15:22');

-- --------------------------------------------------------

--
-- Structure de la table `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `google_maps_link` varchar(255) DEFAULT NULL,
  `contact_info` varchar(255) NOT NULL,
  `availability` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `places`
--

INSERT IGNORE INTO `places` (`id`, `user_id`, `title`, `description`, `address`, `google_maps_link`, `contact_info`, `availability`, `created_at`, `updated_at`) VALUES
(2, 1, 'Large Warehouse', 'Lot of place available for stockage', 'Vinewood next to Diamond Casino', 'https://maps.app.goo.gl/5nvHQzR5SLnvhR2w6', '+555 31 9655 21', '2025-09-01', '2025-08-31 11:16:14', '2025-08-31 11:16:14'),
(3, 1, 'Stockage place', 'We have free place to stock your stuff', 'Blaine County', 'https://maps.app.goo.gl/RK3bu7inTYdg6oVn7', 'Space-Invaders@gmail.com', '2025-09-02', '2025-08-31 11:20:29', '2025-08-31 11:20:29');

-- --------------------------------------------------------

--
-- Structure de la table `place_photos`
--

CREATE TABLE IF NOT EXISTS `place_photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `place_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `place_photos`
--

INSERT IGNORE INTO `place_photos` (`id`, `place_id`, `path`, `created_at`, `updated_at`) VALUES
(4, 2, 'places/Jlg4iW50mrjYVxJRssIAXe7xTfK8hkyXx50ulyNd.webp', '2025-08-31 11:16:15', '2025-08-31 11:16:15'),
(6, 3, 'places/C0xhwXL8NqHMAURQSP1aKe6r3IAAIiF1DJHpjoDO.webp', '2025-08-31 11:20:30', '2025-08-31 11:20:30'),
(8, 3, 'places/shF1X7SLryQfEFNguJxK9h2td8uFnkkIZdFtpHYr.webp', '2025-08-31 12:47:53', '2025-08-31 12:47:53');

-- --------------------------------------------------------

--
-- Structure de la table `place_requests`
--

CREATE TABLE IF NOT EXISTS `place_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `place_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT IGNORE INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-07-11 08:07:56', '2025-07-11 08:07:56'),
(2, 'partner', 'web', '2025-07-11 08:07:56', '2025-07-11 08:07:56'),
(3, 'donor', 'web', '2025-07-11 08:07:56', '2025-07-11 08:07:56'),
(4, 'receiver', 'web', '2025-07-11 08:07:56', '2025-07-11 08:07:56');

-- --------------------------------------------------------

--
-- Structure de la table `role_has_permissions`
--

CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT IGNORE INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3WspnnNWNn0BgSbR4b0PDCgjcrfWzJZZgJAuVn8H', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYnhnRUdYNUNqenVnaWx5eW9zVU9HSUFVZWJrM1lXWmdMUXJxY1FSTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC92b2x1bnRlZXIvbmVlZHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1756657061),
('kzyzAnrLGC7v8QgAqaheDBvq9Kosw1eqt25UX10t', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidG5OVG5scmJWUmxZbUNRMXFHVVpHM1RFTmdGQ1UwTmZBRFgwTGVvUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756980002),
('vPpbw6OdWAB7HEVR7ZzLdGOtaVhadIjhxhlhwQJa', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYzF6dTdzUVRldFJ6TjE2VENQdGJGcHRQNVRObzVQRmhHcDZldUVxQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756980004),
('WHvqPBJtbPb6zbv5iKTlyRKiuaMWdqSnUZxy9Cju', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSlVvRlBCOTVrRVozQlZYR2RnZ1NVZ005Q1B2Vkd4SWxFbTZuRlJ1ViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1757344448);

-- --------------------------------------------------------

--
-- Structure de la table `sponsorships`
--

CREATE TABLE IF NOT EXISTS `sponsorships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `partner_id` bigint(20) UNSIGNED NOT NULL,
  `tier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `start_at` timestamp NULL DEFAULT NULL,
  `end_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','active','expired','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sponsorship_tiers`
--

CREATE TABLE IF NOT EXISTS `sponsorship_tiers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration_days` int(10) UNSIGNED NOT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sponsorship_tiers`
--

INSERT IGNORE INTO `sponsorship_tiers` (`id`, `name`, `price`, `duration_days`, `features`, `created_at`, `updated_at`) VALUES
(1, 'Bronze', 100.00, 30, '\"[\\\"logo_small\\\",\\\"link\\\"]\"', '2025-07-22 04:39:42', '2025-07-22 04:39:42'),
(2, 'Silver', 250.00, 90, '\"[\\\"logo_medium\\\",\\\"banner\\\"]\"', '2025-07-22 04:39:42', '2025-07-22 04:39:42'),
(3, 'Gold', 500.00, 180, '\"[\\\"logo_large\\\",\\\"popup\\\"]\"', '2025-07-22 04:39:42', '2025-07-22 04:39:42');

-- --------------------------------------------------------

--
-- Structure de la table `tiers`
--

CREATE TABLE IF NOT EXISTS `tiers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `duration_days` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `document_path` varchar(255) DEFAULT NULL,
  `document_request_token` varchar(255) DEFAULT NULL,
  `document_request_expires_at` timestamp NULL DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'receiver',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `real_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT IGNORE INTO `users` (`id`, `name`, `email`, `document_path`, `document_request_token`, `document_request_expires_at`, `profile_image`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `real_name`) VALUES
(1, 'Anonymous', 'isadiak98us@gmail.com', 'documents/HE3EXbL6kUTrlZ8jcUV7ce6ds6DWj8yzyzpalr3d.jpg', NULL, NULL, 'profile_images/0D5QZnZBlTcSvnkspc9s02QeagMPwLYh5e4jP0bt.webp', 'admin', NULL, '$2y$12$9UxiKVYPOFtC6I.0eUL48uZ51qYV46BWsPt18qFqL3ZeIXfzT/ifS', 'lfEQKGuKSnT2te5jujNeU9T3FIc1rIpoFIHqKQF1waJ62cvZCxwB5qmSn6ia', '2025-07-03 04:07:13', '2025-08-26 05:26:44', 'Anonymous'),
(2, 'ismael', 'isadiak98@gmail.com', NULL, NULL, NULL, NULL, 'admin', NULL, '$2y$12$CQjuPs3FMUF1l2fEY8BiCOEeJ0wz7BeONk1VTJ22bmOwkbagGCgR6', 'BC6DNAE4gX7xHhyqCrHGUQCkg9Vfpbtmsx1Jgrj7DYHcvFosJ1jEx83Hk6Kp', '2025-07-08 07:46:52', '2025-07-08 07:46:52', NULL),
(5, 'Abba', 'ismael.diakite@final.edu.tr', NULL, NULL, NULL, 'profile_images/g1CeKSZe8t9dxOw7ArkxS4VDWtalDD8yKsUz2Mtv.jpg', 'organization', NULL, '$2y$12$XIQL95YiHU4Rppc.SENwdOAqyzSywlzY1n67wBL8uB3QBBQ5y/0eu', NULL, '2025-07-15 03:54:05', '2025-07-21 10:17:19', NULL),
(6, 'Turkcell manager', 'turkcell@gmail.com', NULL, NULL, NULL, 'profile_images/krOSB3OGR0HVimxaknOnJlgXMkVjJuTymru0ckLa.jpg', 'partner', NULL, '$2y$12$9GjBHnmKhGk5vK0t6bWWJ.BU3La0ioo8r8wek2MoY4EIMSX1SboSW', NULL, '2025-07-19 08:09:22', '2025-07-20 13:26:40', NULL),
(7, 'Test User', 'test@example.com', NULL, NULL, NULL, NULL, 'receiver', '2025-07-22 04:39:45', '$2y$12$kcMeukpPpYMgk6yXNj9MEOLf8lqcLIFHvH4HgxgzcLW93YFf8RKQi', '5lKhAYO9VY', '2025-07-22 04:39:45', '2025-07-22 04:39:45', NULL),
(8, 'Samsung Manager', 'isadiak99@gmail.com', NULL, NULL, NULL, 'profile_images/Pqoe9ockc4xwnt20dClRdBr9NVTmlUb2bZEZgnao.jpg', 'partner', NULL, '$2y$12$Qirw3fjue2xI23RJQj2auO5Qq.Nju610f25TYPl6Rz7WClHns1zk6', NULL, '2025-07-22 09:34:23', '2025-08-14 05:14:07', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_preferences`
--

CREATE TABLE IF NOT EXISTS `user_preferences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `preferred_categories` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`preferred_categories`)),
  `min_quantity` int(11) NOT NULL DEFAULT 1,
  `max_distance` int(11) NOT NULL DEFAULT 10,
  `available_from` time DEFAULT NULL,
  `available_until` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_preferences`
--

INSERT IGNORE INTO `user_preferences` (`id`, `user_id`, `preferred_categories`, `min_quantity`, `max_distance`, `available_from`, `available_until`, `created_at`, `updated_at`) VALUES
(14, 2, '[\"Fruits\"]', 16, 10, NULL, NULL, '2025-07-08 08:28:42', '2025-07-08 08:29:10'),
(16, 8, '[\"Desserts\"]', 1, 10, NULL, NULL, '2025-08-06 08:25:04', '2025-08-24 04:32:26'),
(21, 1, '[\"Fruits\"]', 1, 10, NULL, NULL, '2025-08-24 04:57:04', '2025-08-24 05:04:53');

-- --------------------------------------------------------

--
-- Structure de la table `volunteers`
--

CREATE TABLE IF NOT EXISTS `volunteers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `availability` text DEFAULT NULL,
  `document_path` varchar(255) DEFAULT NULL,
  `verification_status` enum('pending','approved','declined','suspended') NOT NULL DEFAULT 'pending',
  `verification_note` text DEFAULT NULL,
  `verification_requested_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `volunteers`
--

INSERT IGNORE INTO `volunteers` (`id`, `user_id`, `phone`, `skills`, `availability`, `document_path`, `verification_status`, `verification_note`, `verification_requested_at`, `created_at`, `updated_at`) VALUES
(5, 5, '+90 533 822 28 28', 'Manager', 'Everyday', NULL, 'declined', NULL, NULL, '2025-07-16 07:55:42', '2025-08-31 08:44:12'),
(8, 8, NULL, NULL, NULL, NULL, 'declined', NULL, NULL, '2025-08-15 09:58:52', '2025-08-31 08:23:10'),
(11, 1, 'ckvl.ufl', 'cfli.cfklfi', 'fvl,fcyuvl', NULL, 'pending', NULL, NULL, '2025-08-29 09:31:01', '2025-08-31 08:22:40');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `contributions`
--
ALTER TABLE `contributions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contributions_partner_id_foreign` (`partner_id`),
  ADD KEY `contributions_food_request_id_foreign` (`food_request_id`);

--
-- Index pour la table `distributions`
--
ALTER TABLE `distributions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `distributions_donation_id_foreign` (`donation_id`),
  ADD KEY `distributions_user_id_foreign` (`user_id`);

--
-- Index pour la table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donations_user_id_foreign` (`user_id`),
  ADD KEY `donations_partner_id_foreign` (`partner_id`),
  ADD KEY `donations_food_request_id_foreign` (`food_request_id`);

--
-- Index pour la table `donation_volunteer`
--
ALTER TABLE `donation_volunteer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donation_volunteer_donation_id_foreign` (`donation_id`),
  ADD KEY `donation_volunteer_volunteer_id_foreign` (`volunteer_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `food_requests`
--
ALTER TABLE `food_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_requests_organization_id_foreign` (`organization_id`);

--
-- Index pour la table `food_request_donations`
--
ALTER TABLE `food_request_donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_request_donations_food_request_id_foreign` (`food_request_id`),
  ADD KEY `food_request_donations_user_id_foreign` (`user_id`);

--
-- Index pour la table `food_waste_reports`
--
ALTER TABLE `food_waste_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_waste_reports_user_id_foreign` (`user_id`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Index pour la table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Index pour la table `organization_partner_requests`
--
ALTER TABLE `organization_partner_requests`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partners_linked_partner_id_foreign` (`linked_partner_id`);

--
-- Index pour la table `partner_requests`
--
ALTER TABLE `partner_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partner_requests_partner_id_foreign` (`partner_id`),
  ADD KEY `partner_requests_user_id_foreign` (`user_id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `pickups`
--
ALTER TABLE `pickups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pickups_donation_id_foreign` (`donation_id`),
  ADD KEY `pickups_user_id_foreign` (`user_id`);

--
-- Index pour la table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`),
  ADD KEY `places_user_id_foreign` (`user_id`);

--
-- Index pour la table `place_photos`
--
ALTER TABLE `place_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_photos_place_id_foreign` (`place_id`);

--
-- Index pour la table `place_requests`
--
ALTER TABLE `place_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_requests_place_id_foreign` (`place_id`),
  ADD KEY `place_requests_user_id_foreign` (`user_id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Index pour la table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `sponsorships`
--
ALTER TABLE `sponsorships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sponsorships_partner_id_foreign` (`partner_id`),
  ADD KEY `sponsorships_tier_id_foreign` (`tier_id`),
  ADD KEY `sponsorships_admin_id_foreign` (`admin_id`);

--
-- Index pour la table `sponsorship_tiers`
--
ALTER TABLE `sponsorship_tiers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sponsorship_tiers_name_unique` (`name`);

--
-- Index pour la table `tiers`
--
ALTER TABLE `tiers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `user_preferences`
--
ALTER TABLE `user_preferences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_preferences_user_id_foreign` (`user_id`);

--
-- Index pour la table `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `volunteers_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `contributions`
--
ALTER TABLE `contributions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `distributions`
--
ALTER TABLE `distributions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT pour la table `donation_volunteer`
--
ALTER TABLE `donation_volunteer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `food_requests`
--
ALTER TABLE `food_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `food_request_donations`
--
ALTER TABLE `food_request_donations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `food_waste_reports`
--
ALTER TABLE `food_waste_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `organization_partner_requests`
--
ALTER TABLE `organization_partner_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `partner_requests`
--
ALTER TABLE `partner_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `pickups`
--
ALTER TABLE `pickups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `places`
--
ALTER TABLE `places`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `place_photos`
--
ALTER TABLE `place_photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `place_requests`
--
ALTER TABLE `place_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `sponsorships`
--
ALTER TABLE `sponsorships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `sponsorship_tiers`
--
ALTER TABLE `sponsorship_tiers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `tiers`
--
ALTER TABLE `tiers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `user_preferences`
--
ALTER TABLE `user_preferences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contributions`
--
ALTER TABLE `contributions`
  ADD CONSTRAINT `contributions_food_request_id_foreign` FOREIGN KEY (`food_request_id`) REFERENCES `food_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contributions_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `distributions`
--
ALTER TABLE `distributions`
  ADD CONSTRAINT `distributions_donation_id_foreign` FOREIGN KEY (`donation_id`) REFERENCES `donations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `distributions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_food_request_id_foreign` FOREIGN KEY (`food_request_id`) REFERENCES `food_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `donations_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `donations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `donation_volunteer`
--
ALTER TABLE `donation_volunteer`
  ADD CONSTRAINT `donation_volunteer_donation_id_foreign` FOREIGN KEY (`donation_id`) REFERENCES `donations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `donation_volunteer_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `food_requests`
--
ALTER TABLE `food_requests`
  ADD CONSTRAINT `food_requests_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `food_request_donations`
--
ALTER TABLE `food_request_donations`
  ADD CONSTRAINT `food_request_donations_food_request_id_foreign` FOREIGN KEY (`food_request_id`) REFERENCES `food_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `food_request_donations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `food_waste_reports`
--
ALTER TABLE `food_waste_reports`
  ADD CONSTRAINT `food_waste_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `partners`
--
ALTER TABLE `partners`
  ADD CONSTRAINT `partners_linked_partner_id_foreign` FOREIGN KEY (`linked_partner_id`) REFERENCES `partners` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `partner_requests`
--
ALTER TABLE `partner_requests`
  ADD CONSTRAINT `partner_requests_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `partner_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `pickups`
--
ALTER TABLE `pickups`
  ADD CONSTRAINT `pickups_donation_id_foreign` FOREIGN KEY (`donation_id`) REFERENCES `donations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pickups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `places`
--
ALTER TABLE `places`
  ADD CONSTRAINT `places_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `place_photos`
--
ALTER TABLE `place_photos`
  ADD CONSTRAINT `place_photos_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `place_requests`
--
ALTER TABLE `place_requests`
  ADD CONSTRAINT `place_requests_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `place_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sponsorships`
--
ALTER TABLE `sponsorships`
  ADD CONSTRAINT `sponsorships_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sponsorships_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sponsorships_tier_id_foreign` FOREIGN KEY (`tier_id`) REFERENCES `sponsorship_tiers` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `user_preferences`
--
ALTER TABLE `user_preferences`
  ADD CONSTRAINT `user_preferences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `volunteers`
--
ALTER TABLE `volunteers`
  ADD CONSTRAINT `volunteers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
