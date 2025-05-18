-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 18 mai 2025 à 08:48
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `chat_app`
--

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `content` text NOT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `content`, `timestamp`) VALUES
(1, 1, 'f', '2025-02-14 13:21:03'),
(2, 1, 'fff', '2025-02-14 13:21:17'),
(3, 10, 'aa', '2025-02-14 13:21:54'),
(4, 4, 'f', '2025-02-14 13:25:07'),
(5, 1, 'f', '2025-02-14 13:25:14'),
(6, 1, 'd', '2025-02-14 13:30:02'),
(7, 10, 'd', '2025-02-14 13:30:26'),
(8, 10, 'h', '2025-02-14 13:31:04'),
(9, 1, 'test', '2025-02-14 13:33:00'),
(10, 10, 'c', '2025-02-14 13:33:53'),
(11, 1, 'c', '2025-02-14 13:34:06'),
(12, 10, 'c', '2025-02-14 13:34:12'),
(13, 1, 'f', '2025-02-14 13:34:17'),
(14, 10, 'c', '2025-02-14 13:34:46'),
(15, 1, 'c', '2025-02-14 13:37:26'),
(16, 1, 'c', '2025-02-14 13:37:31'),
(17, 1, 'g', '2025-02-14 13:37:57'),
(18, 1, 'c', '2025-02-14 13:38:20'),
(19, 1, 'x', '2025-02-14 13:44:24'),
(20, 1, 'x', '2025-02-14 13:44:34'),
(21, 10, 'd', '2025-02-14 13:44:53'),
(22, 1, 'd', '2025-02-14 13:44:58'),
(23, 1, 'f', '2025-02-14 13:45:40'),
(24, 10, 'fg', '2025-02-14 13:45:59'),
(25, 1, 'g', '2025-02-14 13:46:05'),
(26, 10, 'df', '2025-02-14 13:47:39'),
(27, 10, 'fd', '2025-02-14 13:47:44'),
(28, 1, 'f', '2025-02-14 13:48:34'),
(29, 1, 'f', '2025-02-14 13:48:36'),
(30, 10, 'f', '2025-02-14 13:48:41'),
(31, 10, 'f', '2025-02-14 13:48:44'),
(32, 1, 'd', '2025-02-14 13:49:12'),
(33, 10, 'c', '2025-02-14 13:49:21'),
(34, 10, 'd', '2025-02-14 13:53:19'),
(35, 1, 'z', '2025-02-14 13:53:26'),
(36, 1, 'd', '2025-02-16 15:42:27'),
(37, 1, 'd', '2025-02-16 15:42:30'),
(38, 1, 'f', '2025-02-16 15:54:44'),
(39, 1, 'f', '2025-02-16 15:54:54'),
(40, 1, 'dd', '2025-02-16 16:00:03'),
(41, 1, 'fff', '2025-02-16 16:01:25'),
(42, 1, 'gggg', '2025-02-16 16:01:37'),
(43, 1, 'c', '2025-02-16 16:02:03'),
(44, 1, 'c', '2025-02-16 16:02:25'),
(45, 1, 'f', '2025-02-16 16:04:25'),
(47, 1, 'b', '2025-02-16 17:14:17'),
(48, 1, 'd', '2025-02-16 17:50:40'),
(49, 1, 'fg', '2025-02-16 17:51:18'),
(50, 1, 'f', '2025-02-16 17:51:54'),
(51, 1, 'f', '2025-02-16 17:54:41'),
(52, 36, 'f', '2025-02-16 17:55:08'),
(53, 36, 'ff', '2025-02-16 17:55:21'),
(54, 36, 'ff', '2025-02-16 17:58:48'),
(55, 1, 'ze', '2025-02-16 17:59:09'),
(56, 36, 'zertzet', '2025-02-16 17:59:14'),
(57, 1, 'qsdq', '2025-02-16 17:59:45'),
(58, 36, 'dqsd', '2025-02-16 17:59:51'),
(59, 36, 'd', '2025-02-16 17:59:55'),
(60, 36, 'g', '2025-02-16 18:06:28'),
(61, 36, 'v', '2025-03-03 13:24:56'),
(62, 36, 'd', '2025-03-06 14:14:55'),
(63, 36, 'dd', '2025-03-06 14:15:00'),
(64, 36, 'd', '2025-03-06 14:15:51'),
(65, 36, 's', '2025-03-06 14:16:16'),
(66, 1, 'g', '2025-03-06 14:18:11'),
(67, 1, 'f', '2025-03-06 14:18:54'),
(68, 36, 'c', '2025-03-06 14:19:32'),
(69, 1, 'f', '2025-03-06 14:19:43'),
(70, 1, 'g', '2025-03-06 14:21:03'),
(71, 36, 'd', '2025-03-06 14:36:38'),
(72, 36, 'f', '2025-03-06 14:49:16'),
(73, 37, 'f', '2025-03-06 14:49:24'),
(74, 36, 'f', '2025-03-06 14:49:28'),
(75, 37, 'f', '2025-03-06 14:49:36'),
(76, 37, 'qsdf', '2025-03-13 20:42:40'),
(77, 36, 'qsdfqsd', '2025-03-13 20:42:59'),
(78, 37, 'f', '2025-03-13 20:59:10'),
(79, 36, 'fsdg', '2025-03-13 20:59:35'),
(80, 37, 'hjgfuhktgfhgkfkh', '2025-03-15 12:25:18'),
(81, 37, 'fff', '2025-05-18 10:46:47'),
(82, 36, 'ff', '2025-05-18 10:46:53');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT '../../uploads/default.png',
  `last_login` datetime DEFAULT NULL,
  `last_logout` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `profile_picture`, `last_login`, `last_logout`) VALUES
(37, 'test', '$2y$10$5Bubp2X7iudl5brgMJA.buKiPX1rC9NyBV/AYud/gy/JgxHkf3Vna', '../../uploads/default.png', '2025-05-18 10:46:36', '2025-05-18 10:47:09'),
(36, 'admin', '$2y$10$8g.bD7zKZ/lmY9fEd0LajOBRGtTwiHk.iKJbESZH2LeEo07wsgOCW', '../../uploads/default.png', '2025-05-18 10:45:57', '2025-05-18 10:47:08');

-- --------------------------------------------------------

--
-- Structure de la table `user_status`
--

DROP TABLE IF EXISTS `user_status`;
CREATE TABLE IF NOT EXISTS `user_status` (
  `user_id` int NOT NULL,
  `is_online` tinyint(1) NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user_status`
--

INSERT INTO `user_status` (`user_id`, `is_online`, `updated_at`) VALUES
(38, 0, '2025-03-06 13:58:51'),
(36, 0, '2025-05-18 08:47:08'),
(37, 0, '2025-05-18 08:47:09');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
