-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2017 at 09:55 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `asset`
--

-- --------------------------------------------------------

--
-- Table structure for table `activations`
--

CREATE TABLE IF NOT EXISTS `activations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=187 ;

--
-- Dumping data for table `activations`
--

INSERT INTO `activations` (`id`, `user_id`, `code`, `completed`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'RCsr7Qt1bBMqFwlW4bBVvtu02UBBQ0hr', 1, '2015-07-10 17:39:31', '2015-07-10 17:39:31', '2015-07-10 17:39:31'),
(8, 10, 'Bs5wlBYLO997Z8lcLpO19pj40fx2qVuV', 1, '2016-01-07 04:50:38', '2016-01-07 04:50:38', '2016-01-07 04:50:38'),
(10, 12, 'yfD7K4mMa3eend4vvBBPNVbyFeX3UGZF', 1, '2016-01-07 05:27:38', '2016-01-07 05:27:38', '2016-01-07 05:27:38'),
(17, 4, 'XLzIPInm9PRL8uochDR9uc6MB68u6Ou4', 1, '2017-04-17 05:53:07', '2017-04-17 05:53:07', '2017-04-17 05:53:07'),
(20, 7, '3fR1nsrzXfCrolo6eL8UUjsPI96lZ396', 1, '2017-04-19 21:42:27', '2017-04-19 21:42:27', '2017-04-19 21:42:27'),
(21, 8, 'ibrWjkEUYrjCazA2z24K3Dr4SpZ73YMk', 1, '2017-04-19 21:53:13', '2017-04-19 21:53:13', '2017-04-19 21:53:13'),
(23, 10, 'hBXpruGB1gaecQPtd0G1rfC7DHiKLpU0', 1, '2017-04-19 21:56:58', '2017-04-19 21:56:58', '2017-04-19 21:56:58'),
(24, 11, 'uKTbpxxIoYE6jfmw2ITdEhlXetjCylOp', 1, '2017-04-20 14:42:42', '2017-04-20 14:42:42', '2017-04-20 14:42:42'),
(25, 12, '2fp4ymmygCg0wrWKekksYYXDmMY4SJvP', 1, '2017-04-20 14:48:43', '2017-04-20 14:48:43', '2017-04-20 14:48:43'),
(26, 13, '0Oj96679qaFZyAtJqpDSBdd8uqm291NT', 1, '2017-04-20 14:52:09', '2017-04-20 14:52:09', '2017-04-20 14:52:09'),
(31, 17, 'g7AQP33uyBZUoUdbXUPTJISXujR0Kmfi', 1, '2017-05-12 15:28:09', '2017-05-12 15:28:09', '2017-05-12 15:28:09'),
(33, 5, '2USS4rWT2OtQYSda8pSBqkFeDQRmr1gX', 1, '2017-05-14 15:28:23', '2017-05-14 15:28:23', '2017-05-14 15:28:23'),
(35, 7, 'tRad8xSLpMMO2vT9u9bVVtlmHj6BNQXT', 1, '2017-05-14 15:43:00', '2017-05-14 15:43:00', '2017-05-14 15:43:00'),
(36, 2, 'DcUWg9u7LHBz6dx2MX5Ks38vnIl6Rqn1', 1, '2017-05-15 03:32:45', '2017-05-15 03:32:45', '2017-05-15 03:32:45'),
(38, 4, 'SmqYyRUAB2eAyFKiuAQlqChlNAOC9W9t', 1, '2017-05-15 04:26:49', '2017-05-15 04:26:49', '2017-05-15 04:26:49'),
(39, 5, '4o0jemDVe8dy74LkmFNITHJoclOMTDYP', 1, '2017-05-15 04:28:41', '2017-05-15 04:28:41', '2017-05-15 04:28:41'),
(41, 7, 'NwlZV9ZhzM3IVLr5QhoJubPAeet1C3ET', 1, '2017-05-15 04:37:10', '2017-05-15 04:37:10', '2017-05-15 04:37:10'),
(42, 8, 'ZCVdCB2FGLMoYTySWgImJIxfiMqcH8N0', 1, '2017-05-15 04:38:01', '2017-05-15 04:38:01', '2017-05-15 04:38:01'),
(44, 10, 'KWpJ90qmGrYUej2HuM4sxJp8sr1t9kwl', 1, '2017-05-15 04:40:47', '2017-05-15 04:40:47', '2017-05-15 04:40:47'),
(45, 11, '92ZGGC1YTZUQF5qWoBV1wsqT21sHvySa', 1, '2017-05-15 04:41:31', '2017-05-15 04:41:31', '2017-05-15 04:41:31'),
(46, 12, 'y6QcNZnq0bUyAVPEo80Puf425ishYeCt', 1, '2017-05-15 04:42:18', '2017-05-15 04:42:18', '2017-05-15 04:42:18'),
(47, 13, 'fgADR1hS9ZAtYKbXPltlSWRxfEseNTG6', 1, '2017-05-15 04:43:05', '2017-05-15 04:43:05', '2017-05-15 04:43:05'),
(49, 15, 'wnBPhUG3N0pi3VrxiZBloRwGoq4JiIoQ', 1, '2017-05-16 20:52:32', '2017-05-16 20:52:32', '2017-05-16 20:52:32'),
(51, 17, 'kFwU0jjb3qIW3IrSBRRoNVGTJis9jY5Y', 1, '2017-05-18 19:03:21', '2017-05-18 19:03:21', '2017-05-18 19:03:21'),
(52, 18, '7NxPAOakqc74Dxzfa4mg03sIzUqAFP8O', 1, '2017-05-18 19:04:39', '2017-05-18 19:04:39', '2017-05-18 19:04:39'),
(53, 19, 'BvmLLWlHxG8dkUhBwxCp2Ww2PaslLZrc', 1, '2017-05-18 19:05:51', '2017-05-18 19:05:51', '2017-05-18 19:05:51'),
(54, 20, '0JqUSmeCLJWdSzHnsFvW5G1y8HyWEcFb', 1, '2017-05-18 19:09:37', '2017-05-18 19:09:37', '2017-05-18 19:09:37'),
(56, 22, 'caNaZ12vSGoAPuhhvF5GnHQ6QXFMq4K0', 1, '2017-05-18 19:26:01', '2017-05-18 19:26:01', '2017-05-18 19:26:01'),
(58, 24, 'BXHgQU6sAtiw8PGD2GH4i3qbjHx64jSg', 1, '2017-05-18 19:28:34', '2017-05-18 19:28:34', '2017-05-18 19:28:34'),
(59, 25, 'AMMygNFHnWsV4ktToF8RKVwDvY8uhVzy', 1, '2017-05-18 19:29:55', '2017-05-18 19:29:55', '2017-05-18 19:29:55'),
(60, 26, 'E4A4V3q9jkirhX7qNCwClmOEzBvlJtFK', 1, '2017-05-18 19:31:33', '2017-05-18 19:31:33', '2017-05-18 19:31:33'),
(61, 27, 'wwxVmZddYjbZcSMAtl82oJUPvQnbgcHW', 1, '2017-05-18 19:34:19', '2017-05-18 19:34:19', '2017-05-18 19:34:19'),
(62, 28, 'Kl51ovvOXQerARldRcPQP4Noqr05ruUn', 1, '2017-05-18 19:35:35', '2017-05-18 19:35:35', '2017-05-18 19:35:35'),
(64, 30, '51myf9HDsDtua8IA7ewsfJKm1SyiUvDA', 1, '2017-05-26 17:16:38', '2017-05-26 17:16:38', '2017-05-26 17:16:38'),
(65, 31, 'JRkkr6B3wwoynaWCRsV8UMxSKqnK7AAS', 1, '2017-05-28 15:51:42', '2017-05-28 15:51:42', '2017-05-28 15:51:42'),
(67, 29, 't7DDkCH452N43tL2JsfVBHbekTpfY1Lp', 1, '2017-05-28 15:54:47', '2017-05-28 15:54:47', '2017-05-28 15:54:47'),
(69, 33, 'LAzUoOyTunOwBjt1wNMyolVBh8wGHQBy', 1, '2017-05-28 17:18:35', '2017-05-28 17:18:35', '2017-05-28 17:18:35'),
(70, 31, 'LLYuayG8mpOoNwIouSGhZfCENzqHpTPL', 1, '2017-05-28 18:20:27', '2017-05-28 18:20:27', '2017-05-28 18:20:27'),
(71, 34, '05GYhYrXohhE9Sw2p60dEyIvUKdtCtLb', 1, '2017-05-28 18:22:21', '2017-05-28 18:22:21', '2017-05-28 18:22:21'),
(76, 39, 'lYPfZIWfxHDrqdJIAiDKNbcvjCVxDkW7', 1, '2017-05-31 15:22:15', '2017-05-31 15:22:15', '2017-05-31 15:22:15'),
(77, 40, 'vqicpx7ywSveA99Ax8ve1WACtROl4fKv', 1, '2017-05-31 21:22:17', '2017-05-31 21:22:17', '2017-05-31 21:22:17'),
(80, 41, 'lRIyPB3ixmjVV3W1JXzTk5XjKV25g6GL', 1, '2017-06-04 17:30:01', '2017-06-04 17:30:01', '2017-06-04 17:30:01'),
(81, 42, 'TywB8sMUCoUsrI37AKg1EwjXmAdTgrho', 1, '2017-06-05 05:59:30', '2017-06-05 05:59:30', '2017-06-05 05:59:30'),
(82, 3, 'w1BbV4A1uvPtvD4NeBhvI80IKxEEK7dX', 1, '2017-06-12 16:56:55', '2017-06-12 16:56:55', '2017-06-12 16:56:55'),
(83, 3, 'i9FyOKGqZptO5dx0gPmgEkgF6rZ2fe9S', 1, '2017-06-13 09:13:59', '2017-06-13 09:13:59', '2017-06-13 09:13:59'),
(84, 2, 't5AmcPmjEy2pBZvmXWiCDq1hO6n3QDqU', 1, '2017-06-14 01:46:26', '2017-06-14 01:46:26', '2017-06-14 01:46:26'),
(85, 3, 'Nz4FsFIO5S0EkJQ40M131RXpDr46VOyW', 1, '2017-06-14 04:00:31', '2017-06-14 04:00:31', '2017-06-14 04:00:31'),
(86, 4, 'MGFjGk90WyDesgXmhkLU7eLboM7smPAu', 1, '2017-06-14 04:17:48', '2017-06-14 04:17:48', '2017-06-14 04:17:48'),
(87, 5, '4ApXqEINSZH8g3rJ3aluSyCsI73fAIAp', 1, '2017-06-14 04:18:12', '2017-06-14 04:18:12', '2017-06-14 04:18:12'),
(89, 7, '9ix8YEaASu55XYzaVQyhEJlHORSysNQG', 1, '2017-06-14 04:19:21', '2017-06-14 04:19:21', '2017-06-14 04:19:21'),
(90, 8, 'OHOzvdAtrqoAD5v9cd7QxTwteynHXgiJ', 1, '2017-06-14 04:20:23', '2017-06-14 04:20:23', '2017-06-14 04:20:23'),
(92, 5, 'F41ht7a6PN8MAWKnYoZt528BD9PO5k0q', 1, '2017-06-14 08:12:46', '2017-06-14 08:12:46', '2017-06-14 08:12:46'),
(93, 5, '9NCYQTbhVIhCgBpwTKmO80yrZMwBFIH4', 1, '2017-06-15 20:03:00', '2017-06-15 20:03:00', '2017-06-15 20:03:00'),
(94, 2, '7KC5guD0kcKI8YS15XTcwkIPATVtA1ld', 1, '2017-06-22 16:55:32', '2017-06-22 16:55:32', '2017-06-22 16:55:32'),
(95, 3, 'N2PNLMsv6jYiHwnj3YE9iRjfiLoQHPYm', 1, '2017-06-22 17:13:04', '2017-06-22 17:13:04', '2017-06-22 17:13:04'),
(96, 4, 'qZc0UEKP5arClHiadofPIPYu92s4vncz', 1, '2017-06-22 17:28:57', '2017-06-22 17:28:57', '2017-06-22 17:28:57'),
(97, 5, 'DCrlk2b52xzUMjwlNM4mZLNl2ijQbr6a', 1, '2017-06-22 17:33:39', '2017-06-22 17:33:39', '2017-06-22 17:33:39'),
(98, 6, 'Nyu42bP4zEyrCUoNXGkany61qF8eCvs5', 1, '2017-06-22 18:46:51', '2017-06-22 18:46:51', '2017-06-22 18:46:51'),
(99, 7, 'vSFL9fPKYWlDlSBEnxuu2LkvasdBu3cU', 1, '2017-06-22 21:54:19', '2017-06-22 21:54:19', '2017-06-22 21:54:19'),
(100, 8, 'QcKcToP6TMsgbpBQAi4zqqjvj8FOgsaJ', 1, '2017-06-22 21:54:50', '2017-06-22 21:54:50', '2017-06-22 21:54:50'),
(101, 9, 'fYs2ZIDPF5sl43RGNqmcxdEqTcksiCFr', 1, '2017-06-22 21:55:20', '2017-06-22 21:55:20', '2017-06-22 21:55:20'),
(102, 10, '5KWQRVVnDSPcPmZKAWVJzG1ECRzbUUWq', 1, '2017-06-22 21:56:36', '2017-06-22 21:56:36', '2017-06-22 21:56:36'),
(103, 11, '5C28XZWD2pPQLO1PXjLhdcEEdDJUjkEm', 1, '2017-06-22 21:56:58', '2017-06-22 21:56:58', '2017-06-22 21:56:58'),
(104, 12, '0xSqjCnHxU2DA1Dc6goGKv4125tmP2sO', 1, '2017-06-22 21:57:19', '2017-06-22 21:57:19', '2017-06-22 21:57:19'),
(105, 13, 'mEBuvRRtekrazZbJY6I4ES0eZG1RBXfP', 1, '2017-06-22 22:01:16', '2017-06-22 22:01:16', '2017-06-22 22:01:16'),
(106, 9, 'DT1gczgOCen2UFaqoaLBo8TIgocf3cWC', 1, '2017-06-22 22:12:34', '2017-06-22 22:12:34', '2017-06-22 22:12:34'),
(107, 14, 'ejdXKDArATaz4uh1lJldRrFHFaf2pnl6', 1, '2017-06-22 22:20:24', '2017-06-22 22:20:24', '2017-06-22 22:20:24'),
(108, 15, 'WbgD9IsptLsLaUGvaidt6N8XqaQlYkXH', 1, '2017-06-22 22:20:46', '2017-06-22 22:20:46', '2017-06-22 22:20:46'),
(109, 16, 'rV2mn9chpckkdVzMiz4JXxks8F08zouY', 1, '2017-06-22 22:21:11', '2017-06-22 22:21:11', '2017-06-22 22:21:11'),
(110, 17, 'YtIAKVJCKBO9Q6l9u5HP1dgyQSG1VxIz', 1, '2017-06-22 22:21:53', '2017-06-22 22:21:53', '2017-06-22 22:21:53'),
(111, 18, 'FUSpF9GSScupknc5sbCV3Ty9h2PD42gH', 1, '2017-06-22 22:22:11', '2017-06-22 22:22:11', '2017-06-22 22:22:11'),
(112, 15, 'TPMgxWFeOC8RgTmB9ynerGa7kOz6BRQj', 1, '2017-06-23 17:40:41', '2017-06-23 17:40:41', '2017-06-23 17:40:41'),
(113, 14, 'VB68ZasmdpbcmNhCYNHgUtcaZ2e8awvR', 1, '2017-06-23 17:42:05', '2017-06-23 17:42:05', '2017-06-23 17:42:05'),
(114, 14, 't5AESauXonGefv0po5HgwG17CIdsbMAI', 1, '2017-06-23 17:47:39', '2017-06-23 17:47:39', '2017-06-23 17:47:39'),
(115, 3, 'Du0uzS27URhCh29pYqtQgcncmVMV8uJU', 1, '2017-06-30 17:04:32', '2017-06-30 17:04:32', '2017-06-30 17:04:32'),
(116, 4, 'JyJPM7VicCsny65kLxg7KKeFIAHzDct5', 1, '2017-06-30 17:43:27', '2017-06-30 17:43:27', '2017-06-30 17:43:27'),
(117, 19, 'RatOVztFxp3KMsfQAMCwtIiWH3aInEaG', 1, '2017-06-30 18:30:57', '2017-06-30 18:30:57', '2017-06-30 18:30:57'),
(118, 9, 'DZ8yttwlp5907I7d15z4RLbBTVOOXZsW', 1, '2017-06-30 20:11:52', '2017-06-30 20:11:52', '2017-06-30 20:11:52'),
(119, 9, 'qUFY9rKEpeedz2KyqvIyF3pxqUd4UkIl', 1, '2017-06-30 20:13:25', '2017-06-30 20:13:25', '2017-06-30 20:13:25'),
(120, 5, '2rjLKff4tJbEahPgw0ZHtzVdurhmhhL4', 1, '2017-06-30 20:25:47', '2017-06-30 20:25:47', '2017-06-30 20:25:47'),
(121, 3, '9cEaHSkC0gJndWLQZm02dmBkW32m8oAP', 1, '2017-06-30 20:33:40', '2017-06-30 20:33:40', '2017-06-30 20:33:40'),
(122, 2, 'HP09NLgUr55KaFF3z6cX83HrtJ67jKtQ', 1, '2017-07-11 18:00:25', '2017-07-11 18:00:25', '2017-07-11 18:00:25'),
(123, 3, 'LY4afUIDWqWNGDaBufv5v5EOslIAR3WQ', 1, '2017-07-11 18:21:57', '2017-07-11 18:21:57', '2017-07-11 18:21:57'),
(124, 4, 'uYn5egMpMr3ANhy0cqCgsbB6WhYJPbW4', 1, '2017-07-11 18:39:51', '2017-07-11 18:39:51', '2017-07-11 18:39:51'),
(125, 5, 'HrUD1aSFBWKH8R2wN8FpKDAh3XsQTw0D', 1, '2017-07-11 18:47:40', '2017-07-11 18:47:40', '2017-07-11 18:47:40'),
(126, 6, 'NTOVbyFUPDa0sGOFqGC7le1E7QXbMKOv', 1, '2017-07-11 19:56:49', '2017-07-11 19:56:49', '2017-07-11 19:56:49'),
(127, 7, 'vaksQZ5RbyDckxjbBx9ykOh50UPT8lcr', 1, '2017-07-11 20:02:59', '2017-07-11 20:02:59', '2017-07-11 20:02:59'),
(128, 7, 'b9txRbqiXRuH29tnge4YzYauNTLrfQVC', 1, '2017-07-11 20:07:47', '2017-07-11 20:07:47', '2017-07-11 20:07:47'),
(129, 8, 'Fg0KfmZGGIYsTTFK9du8fnEynRk2ep5i', 1, '2017-07-11 20:08:19', '2017-07-11 20:08:19', '2017-07-11 20:08:19'),
(130, 8, 'UFRdh3zWDhf3EP7SgeTeSrP0uEWRihBZ', 1, '2017-07-11 22:19:55', '2017-07-11 22:19:55', '2017-07-11 22:19:55'),
(131, 9, 'VpQQBXy0oe9dd32pwSOt6tI2r9X4P3AD', 1, '2017-07-11 22:44:27', '2017-07-11 22:44:27', '2017-07-11 22:44:27'),
(132, 10, 'znmRGyXsOdFWNisrTiIBvJYjzMW2ackZ', 1, '2017-07-12 13:45:03', '2017-07-12 13:45:03', '2017-07-12 13:45:03'),
(133, 11, 'VUpGuASHq9TiWKR7eFsI2qodZ8BUBJIV', 1, '2017-07-12 13:45:26', '2017-07-12 13:45:26', '2017-07-12 13:45:26'),
(134, 12, '79Z8bDDTaycJSUfPBxww7FDazRcaOao1', 1, '2017-07-12 15:03:13', '2017-07-12 15:03:13', '2017-07-12 15:03:13'),
(135, 13, 'KWLT9sOxORAROqWszITjfoTbLkwYRMwg', 1, '2017-07-12 16:38:23', '2017-07-12 16:38:23', '2017-07-12 16:38:23'),
(136, 11, '2vP4zWq3FEKkjZJswyxjHRrLLOpPJnyR', 1, '2017-07-12 16:43:41', '2017-07-12 16:43:41', '2017-07-12 16:43:41'),
(137, 3, 'RQNZ6lkxYXo5OR3ulDNIfSDDQpBU2VPR', 1, '2017-07-18 06:01:30', '2017-07-18 06:01:30', '2017-07-18 06:01:30'),
(138, 4, 'Ha5em3bzGRlFaE27bPJBY9vzvUzdcdRB', 1, '2017-07-18 18:54:41', '2017-07-18 18:54:41', '2017-07-18 18:54:41'),
(139, 5, 'XFmYCm5IfY3R09kLdYLAVVEfiCZvuZPM', 1, '2017-07-18 20:28:02', '2017-07-18 20:28:02', '2017-07-18 20:28:02'),
(140, 6, '7qPO8TgBmCipxg3z1GTh2bgzRvBZn3zG', 1, '2017-07-18 20:28:28', '2017-07-18 20:28:28', '2017-07-18 20:28:28'),
(141, 7, '1wyNKBBm5pf5xN9PbSp4X6wE9fQFVL12', 1, '2017-07-18 20:28:46', '2017-07-18 20:28:46', '2017-07-18 20:28:46'),
(142, 6, 'KJCAb9y13r6Tl0BCjZF2UBv4KPzP3CAX', 1, '2017-07-18 22:40:45', '2017-07-18 22:40:45', '2017-07-18 22:40:45'),
(143, 2, 'LQnPiuuA3BfVgZ42tS6WVVb5aVBXIaQA', 1, '2017-07-19 14:58:10', '2017-07-19 14:58:10', '2017-07-19 14:58:10'),
(144, 2, 'idFwfBWWcukWBODFRFWzv88vJPEAK8FS', 1, '2017-07-19 14:58:19', '2017-07-19 14:58:19', '2017-07-19 14:58:19'),
(145, 2, 'lTRELYGBhV4NeoPzn5j7fmdPXDXv8i8M', 1, '2017-07-21 15:29:02', '2017-07-21 15:29:02', '2017-07-21 15:29:02'),
(146, 3, 'XCG1ErSABY0krdKPeie3e33sPYbEN3aF', 1, '2017-07-21 16:42:44', '2017-07-21 16:42:44', '2017-07-21 16:42:44'),
(147, 4, 'Ap6Hp0bWPhHcrQEJfHKq1OE5JoEqE1Ux', 1, '2017-07-21 16:43:29', '2017-07-21 16:43:29', '2017-07-21 16:43:29'),
(148, 5, 's9rijMY5CKEi4Teem5d4T87s2UHvhGb2', 1, '2017-07-21 16:43:52', '2017-07-21 16:43:52', '2017-07-21 16:43:52'),
(149, 6, 'DCm7XzcKZDFRcd558f7Kb4qQokw827GC', 1, '2017-07-21 17:56:50', '2017-07-21 17:56:50', '2017-07-21 17:56:50'),
(150, 7, 'HlR402aCpKulLinNEQdUmXfgnzEmKI4e', 1, '2017-07-21 18:01:38', '2017-07-21 18:01:38', '2017-07-21 18:01:38'),
(151, 8, 'cJxnkKMIU3dRuL71Wk9l725bOb1s69Vw', 1, '2017-07-21 18:20:01', '2017-07-21 18:20:01', '2017-07-21 18:20:01'),
(152, 9, 'FsDMzdSm1tbecUXfY3OwZehKgk8Kc41C', 1, '2017-07-21 18:20:41', '2017-07-21 18:20:41', '2017-07-21 18:20:41'),
(153, 10, '1zvsX0qLW7fu299UEfei3KRD3h2jfZvq', 1, '2017-07-21 18:21:06', '2017-07-21 18:21:06', '2017-07-21 18:21:06'),
(154, 11, 'cuAzgAPrYFDHKIIJIeG752ORwp8Yvsnl', 1, '2017-07-21 18:21:26', '2017-07-21 18:21:26', '2017-07-21 18:21:26'),
(155, 12, 'XKl1MzAL7nNDX9PWqStVIpHXwDm1CKZz', 1, '2017-07-21 18:22:43', '2017-07-21 18:22:43', '2017-07-21 18:22:43'),
(156, 13, 'EhFuJJGdGtCmrNdLWJn1P8bHIElOp5w8', 1, '2017-07-21 18:24:01', '2017-07-21 18:24:01', '2017-07-21 18:24:01'),
(157, 14, 'aD0GnxoEtwNe1AyMzlyIQFw7VlkrYZwy', 1, '2017-07-21 18:24:19', '2017-07-21 18:24:19', '2017-07-21 18:24:19'),
(158, 15, 'ljrVmoW1KJGMSr1PRbncKDQxC7TRijEm', 1, '2017-07-21 18:24:42', '2017-07-21 18:24:42', '2017-07-21 18:24:42'),
(159, 16, 'VJ16mrzK4OuX8RYLd8tAErDyd0ka6eEy', 1, '2017-07-21 18:24:59', '2017-07-21 18:24:59', '2017-07-21 18:24:59'),
(160, 17, 'kU10r5tIJ5meNZ4HxOWCjFZjChiee7FW', 1, '2017-07-21 18:25:15', '2017-07-21 18:25:15', '2017-07-21 18:25:15'),
(161, 18, 'F867qwgPrfwnGk5ynLtWsQE5GoJivaiV', 1, '2017-07-21 18:25:35', '2017-07-21 18:25:35', '2017-07-21 18:25:35'),
(162, 19, 'A6PLwshnY9Y9jR05hsAX1P3ryeT9O7ro', 1, '2017-07-21 18:25:53', '2017-07-21 18:25:53', '2017-07-21 18:25:53'),
(163, 20, 'VcSC2FoSdjzUdEtDnJp9MghXZwCrugTw', 1, '2017-07-21 18:26:07', '2017-07-21 18:26:07', '2017-07-21 18:26:07'),
(164, 21, 'SR8OTJ9csdzBfWpyi7F2f5iIElORIgXp', 1, '2017-07-21 18:26:24', '2017-07-21 18:26:24', '2017-07-21 18:26:24'),
(165, 22, 'G4xUXFy2XPlROfCeQGKYRY2hqVlb3OPv', 1, '2017-07-21 18:26:45', '2017-07-21 18:26:45', '2017-07-21 18:26:45'),
(166, 23, 'fdPbJULuEo1il5BPJO5z6O7Olxg7Xx18', 1, '2017-07-21 18:27:20', '2017-07-21 18:27:20', '2017-07-21 18:27:20'),
(167, 24, 'zPC4qTeNc2HTQEaCWGE91FuG99gNPIh8', 1, '2017-07-21 18:27:46', '2017-07-21 18:27:46', '2017-07-21 18:27:46'),
(168, 25, 'ND8Mcozbt6Fj2fT4KksM3vvzz61aDjw7', 1, '2017-07-21 18:51:36', '2017-07-21 18:51:36', '2017-07-21 18:51:36'),
(169, 26, 'zuLUSxQ3ZOTzO1n9BXBBryXO6GJvN9uA', 1, '2017-07-21 18:51:56', '2017-07-21 18:51:56', '2017-07-21 18:51:56'),
(170, 27, 'fw4zB4xq8GFJCcK5n0KGAlkMuafl9iXz', 1, '2017-07-21 18:52:21', '2017-07-21 18:52:21', '2017-07-21 18:52:21'),
(171, 28, 'D1pot5M1su1bjkyijKQIY47oKJIrjYwz', 1, '2017-07-21 18:52:24', '2017-07-21 18:52:24', '2017-07-21 18:52:24'),
(172, 29, 'DJYDyHuH76lw5F6lMOujEX9b6OWloTsY', 1, '2017-07-21 18:52:50', '2017-07-21 18:52:50', '2017-07-21 18:52:50'),
(173, 30, 'Z2iSKx8RyxnfyqnKIzpYHXWsRb2rHkzV', 1, '2017-07-21 18:53:09', '2017-07-21 18:53:09', '2017-07-21 18:53:09'),
(174, 31, 'pWNcjus8Cd7BojEkPAMeh0OQbU8KgQrU', 1, '2017-07-21 18:53:24', '2017-07-21 18:53:24', '2017-07-21 18:53:24'),
(175, 32, '7c8eMG3zwvaez7DOQGQYkcYWJU4GxMaj', 1, '2017-07-21 18:53:52', '2017-07-21 18:53:52', '2017-07-21 18:53:52'),
(176, 33, 'jhONTKkzsKS8tQVm5OgvKfpR8n8yAqYI', 1, '2017-07-21 18:54:17', '2017-07-21 18:54:17', '2017-07-21 18:54:17'),
(177, 34, 'A1JLMJV73wOv1k4E1vDWW0Oj6iHsEroD', 1, '2017-07-21 18:54:37', '2017-07-21 18:54:37', '2017-07-21 18:54:37'),
(178, 35, 'y1GZtzjEED9ky7PEFv8xEhirPqlcTtBH', 1, '2017-07-22 15:19:29', '2017-07-22 15:19:29', '2017-07-22 15:19:29'),
(179, 3, '2c6rD0aIa5JS1CRYSlCCKs5bdt0pjcfn', 1, '2017-07-31 20:11:10', '2017-07-31 20:11:10', '2017-07-31 20:11:10'),
(180, 4, 'oKaW4TDCypOIvtPRl8ikbSPlI6N6TQMX', 1, '2017-07-31 20:12:39', '2017-07-31 20:12:39', '2017-07-31 20:12:39'),
(181, 5, 'ltZSWuYr73Jes8djWt1ABTyN4qkUPI50', 1, '2017-07-31 20:12:58', '2017-07-31 20:12:58', '2017-07-31 20:12:58'),
(182, 6, 'nfS6ojiYmxV3yXzFvEc0ofKViElqzuoN', 1, '2017-07-31 20:13:19', '2017-07-31 20:13:19', '2017-07-31 20:13:19'),
(183, 7, 'QAWwSpeGCahTiePp921xvTnZhWa1w1Bg', 1, '2017-07-31 20:13:37', '2017-07-31 20:13:37', '2017-07-31 20:13:37'),
(184, 8, 'jo5JpXRka9oB1mYqWzOd2Z7QXDns51ph', 1, '2017-08-01 02:58:50', '2017-08-01 02:58:50', '2017-08-01 02:58:50'),
(185, 6, 'fYqrj10GUVmlEQPR7aRbVaARQCGivXWj', 1, '2017-08-01 03:42:40', '2017-08-01 03:42:40', '2017-08-01 03:42:40'),
(186, 6, 'KtjnzSb0D76T039zw7xMUSpTUXtsD9UV', 1, '2017-08-01 04:52:21', '2017-08-01 04:52:21', '2017-08-01 04:52:21');

-- --------------------------------------------------------

--
-- Table structure for table `asset`
--

CREATE TABLE IF NOT EXISTS `asset` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `inventory_no` text,
  `description` varchar(100) DEFAULT NULL,
  `make` int(11) DEFAULT NULL,
  `model` text,
  `asset_no` varchar(50) DEFAULT NULL,
  `asset_model_id` int(10) DEFAULT NULL,
  `supplier_id` int(10) DEFAULT NULL,
  `remark` varchar(200) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `account_code` varchar(50) DEFAULT NULL,
  `po_number` varchar(50) DEFAULT NULL,
  `scrap_value` decimal(30,2) DEFAULT NULL,
  `purchased_date` date DEFAULT NULL,
  `purchased_value` decimal(30,2) DEFAULT NULL,
  `warranty_period` int(11) DEFAULT NULL,
  `warranty_from` date DEFAULT NULL,
  `warranty_to` date DEFAULT NULL,
  `recovery_period` int(10) DEFAULT NULL,
  `depreciation_id` int(1) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `manual_no` text,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `asset`
--

INSERT INTO `asset` (`id`, `inventory_no`, `description`, `make`, `model`, `asset_no`, `asset_model_id`, `supplier_id`, `remark`, `image`, `account_code`, `po_number`, `scrap_value`, `purchased_date`, `purchased_value`, `warranty_period`, `warranty_from`, `warranty_to`, `recovery_period`, `depreciation_id`, `user_id`, `manual_no`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'RDB/ComDsk/000001', '', 5, 'Inspiron 3521', '55688500', 1, 18, NULL, NULL, '', '', '0.00', '2017-08-03', '265000.00', NULL, '2017-08-03', '2020-08-03', 36, 1, 2, '', '2017-08-03 06:54:28', '2017-08-03 06:54:28', NULL),
(2, 'RDB/ComDsk/000002', '', 5, 'Inspiron 3522', '55688500', 1, 18, NULL, NULL, '', '', '0.00', '2017-08-03', '265000.00', NULL, '2017-08-03', '2020-08-03', 36, 1, 2, '', '2017-08-03 06:54:29', '2017-08-03 06:54:29', NULL),
(3, 'RDB/ComDsk/000003', '', 5, 'Inspiron 3523', '55688500', 1, 18, NULL, NULL, '', '', '0.00', '2017-08-03', '265000.00', NULL, '2017-08-03', '2020-08-03', 36, 1, 2, '', '2017-08-03 06:54:29', '2017-08-03 06:54:29', NULL),
(4, 'RDB/ComDsk/000004', '', 5, 'Inspiron 3524', '55688500', 1, 18, NULL, NULL, '', '', '0.00', '2017-08-03', '265000.00', NULL, '2017-08-03', '2020-08-03', 36, 1, 2, '', '2017-08-03 06:54:29', '2017-08-03 06:54:29', NULL),
(5, 'RDB/ComDsk/000005', '', 5, 'Inspiron 3525', '55688500', 1, 18, NULL, NULL, '', '', '0.00', '2017-08-03', '265000.00', NULL, '2017-08-03', '2020-08-03', 36, 1, 2, '', '2017-08-03 06:54:29', '2017-08-03 06:54:29', NULL),
(6, 'RDB/ComDsk/000006', '', 5, 'Inspiron 3526', '55688500', 1, 18, NULL, NULL, '', '', '0.00', '2017-08-03', '265000.00', NULL, '2017-08-03', '2020-08-03', 36, 1, 2, '', '2017-08-03 06:54:29', '2017-08-03 06:54:29', NULL),
(7, 'RDB/ComDsk/000007', '', 5, 'Inspiron 3527', '55688500', 1, 18, NULL, NULL, '', '', '0.00', '2017-08-03', '265000.00', NULL, '2017-08-03', '2020-08-03', 36, 1, 2, '', '2017-08-03 06:54:29', '2017-08-03 06:54:29', NULL),
(8, 'RDB/ComDsk/000008', '', 5, 'Inspiron 3528', '55688500', 1, 18, NULL, NULL, '', '', '0.00', '2017-08-03', '265000.00', NULL, '2017-08-03', '2020-08-03', 36, 1, 2, '', '2017-08-03 06:54:29', '2017-08-03 06:54:29', NULL),
(9, 'RDB/ComDsk/000009', '', 5, 'Inspiron 3529', '55688500', 1, 18, NULL, NULL, '', '', '0.00', '2017-08-03', '265000.00', NULL, '2017-08-03', '2020-08-03', 36, 1, 2, '', '2017-08-03 06:54:29', '2017-08-03 06:54:29', NULL),
(10, 'RDB/ComDsk/000010', '', 5, 'Inspiron 3530', '55688500', 1, 18, NULL, NULL, '', '', '0.00', '2017-08-03', '265000.00', NULL, '2017-08-03', '2020-08-03', 36, 1, 2, '', '2017-08-03 06:54:29', '2017-08-03 06:54:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `asset_barcode`
--

CREATE TABLE IF NOT EXISTS `asset_barcode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `barcode_type_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `asset_barcode`
--

INSERT INTO `asset_barcode` (`id`, `asset_id`, `status`, `remarks`, `user_id`, `barcode_type_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, NULL, 2, 3, '2017-08-03 06:54:28', '2017-08-03 12:24:28', NULL),
(2, 2, 1, NULL, 2, 3, '2017-08-03 06:54:29', '2017-08-03 12:24:29', NULL),
(3, 3, 1, NULL, 2, 3, '2017-08-03 06:54:29', '2017-08-03 12:24:29', NULL),
(4, 4, 1, NULL, 2, 3, '2017-08-03 06:54:29', '2017-08-03 12:24:29', NULL),
(5, 5, 1, NULL, 2, 3, '2017-08-03 06:54:29', '2017-08-03 12:24:29', NULL),
(6, 6, 1, NULL, 2, 3, '2017-08-03 06:54:29', '2017-08-03 12:24:29', NULL),
(7, 7, 1, NULL, 2, 3, '2017-08-03 06:54:29', '2017-08-03 12:24:29', NULL),
(8, 8, 1, NULL, 2, 3, '2017-08-03 06:54:29', '2017-08-03 12:24:29', NULL),
(9, 9, 1, NULL, 2, 3, '2017-08-03 06:54:29', '2017-08-03 12:24:29', NULL),
(10, 10, 1, NULL, 2, 3, '2017-08-03 06:54:29', '2017-08-03 12:24:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `asset_modal`
--

CREATE TABLE IF NOT EXISTS `asset_modal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `id_3` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `asset_modal`
--

INSERT INTO `asset_modal` (`id`, `category_id`, `name`, `code`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Desktop Computer', 'ComDsk', 1, '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(2, 1, 'Thin Client Computer', 'ComThn', 1, '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(3, 1, 'Laptop Computer', 'ComLap', 1, '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(4, 1, 'CRT Monitor', 'MonCrt', 1, '2017-07-31 19:45:43', '2017-07-31 19:45:43', NULL),
(5, 1, 'LCD Monitor', 'MonLcd', 1, '2017-07-31 19:46:08', '2017-07-31 19:46:08', NULL),
(6, 1, 'LED Monitor', 'MonLed', 1, '2017-07-31 19:46:36', '2017-07-31 19:46:36', NULL),
(7, 3, 'Pass book Printers', 'PrnPbk', 1, '2017-07-31 19:48:12', '2017-07-31 19:48:12', NULL),
(8, 3, 'Dotmetrix Printers', 'PrnDot', 1, '2017-07-31 19:49:11', '2017-07-31 19:49:11', NULL),
(9, 3, 'Laser Printers', 'PrnLsr', 1, '2017-07-31 19:50:45', '2017-07-31 19:50:45', NULL),
(10, 3, 'Inkjet Printers', 'PrnInj', 1, '2017-07-31 19:52:34', '2017-07-31 19:52:34', NULL),
(11, 3, 'Mobile Printers', 'PrnMob', 1, '2017-07-31 19:53:00', '2017-07-31 19:53:00', NULL),
(12, 1, 'UPS', 'UpsPsn', 1, '2017-07-31 19:55:21', '2017-07-31 19:55:21', NULL),
(13, 5, 'Mobile Phone', 'MobPhn', 1, '2017-07-31 19:56:16', '2017-07-31 19:56:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `asset_transaction`
--

CREATE TABLE IF NOT EXISTS `asset_transaction` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) DEFAULT NULL,
  `status_id` int(100) DEFAULT NULL,
  `location_type` enum('location','employee') NOT NULL DEFAULT 'location',
  `location_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` enum('Upload To','Acknowledge To','Assign To','Un-Deploy To','Check-Out To','Check-In To','Disposed At','To Service From') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `asset_transaction`
--

INSERT INTO `asset_transaction` (`id`, `asset_id`, `status_id`, `location_type`, `location_id`, `employee_id`, `user_id`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'location', 8, NULL, 2, 'Upload To', '2017-08-03 06:54:28', '2017-08-03 06:55:46', '2017-08-03 06:55:46'),
(2, 2, 1, 'location', 8, NULL, 2, 'Upload To', '2017-08-03 06:54:29', '2017-08-03 06:55:46', '2017-08-03 06:55:46'),
(3, 3, 1, 'location', 8, NULL, 2, 'Upload To', '2017-08-03 06:54:29', '2017-08-03 06:55:46', '2017-08-03 06:55:46'),
(4, 4, 1, 'location', 8, NULL, 2, 'Upload To', '2017-08-03 06:54:29', '2017-08-03 06:55:46', '2017-08-03 06:55:46'),
(5, 5, 1, 'location', 8, NULL, 2, 'Upload To', '2017-08-03 06:54:29', '2017-08-03 06:55:46', '2017-08-03 06:55:46'),
(6, 6, 1, 'location', 8, NULL, 2, 'Upload To', '2017-08-03 06:54:29', '2017-08-03 06:55:46', '2017-08-03 06:55:46'),
(7, 7, 1, 'location', 8, NULL, 2, 'Upload To', '2017-08-03 06:54:29', '2017-08-03 06:55:46', '2017-08-03 06:55:46'),
(8, 8, 1, 'location', 8, NULL, 2, 'Upload To', '2017-08-03 06:54:29', '2017-08-03 06:55:46', '2017-08-03 06:55:46'),
(9, 9, 1, 'location', 8, NULL, 2, 'Upload To', '2017-08-03 06:54:29', '2017-08-03 06:55:46', '2017-08-03 06:55:46'),
(10, 10, 1, 'location', 8, NULL, 2, 'Upload To', '2017-08-03 06:54:29', '2017-08-03 06:55:46', '2017-08-03 06:55:46'),
(11, 1, 1, 'location', 8, NULL, 7, 'Check-In To', '2017-08-03 06:55:46', '2017-08-03 06:55:46', NULL),
(12, 2, 1, 'location', 8, NULL, 7, 'Check-In To', '2017-08-03 06:55:46', '2017-08-03 06:55:46', NULL),
(13, 3, 1, 'location', 8, NULL, 7, 'Check-In To', '2017-08-03 06:55:46', '2017-08-03 06:55:46', NULL),
(14, 4, 1, 'location', 8, NULL, 7, 'Check-In To', '2017-08-03 06:55:46', '2017-08-03 06:55:46', NULL),
(15, 5, 1, 'location', 8, NULL, 7, 'Check-In To', '2017-08-03 06:55:46', '2017-08-03 06:55:46', NULL),
(16, 6, 1, 'location', 8, NULL, 7, 'Check-In To', '2017-08-03 06:55:46', '2017-08-03 06:55:46', NULL),
(17, 7, 1, 'location', 8, NULL, 7, 'Check-In To', '2017-08-03 06:55:46', '2017-08-03 06:55:46', NULL),
(18, 8, 1, 'location', 8, NULL, 7, 'Check-In To', '2017-08-03 06:55:46', '2017-08-03 06:55:46', NULL),
(19, 9, 1, 'location', 8, NULL, 7, 'Check-In To', '2017-08-03 06:55:46', '2017-08-03 06:55:46', NULL),
(20, 10, 1, 'location', 8, NULL, 7, 'Check-In To', '2017-08-03 06:55:46', '2017-08-03 06:55:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `asset_upgrade`
--

CREATE TABLE IF NOT EXISTS `asset_upgrade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) DEFAULT NULL,
  `upgrade_asset_id` int(11) NOT NULL,
  `upgrade_at` datetime DEFAULT NULL,
  `ended_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `barcode_types`
--

CREATE TABLE IF NOT EXISTS `barcode_types` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `barcode_types`
--

INSERT INTO `barcode_types` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'C128', '2017-03-25 07:08:20', NULL, NULL),
(2, 'C128A', '2017-03-25 07:08:20', NULL, NULL),
(3, 'C128B', '2017-03-25 07:08:20', NULL, NULL),
(4, 'C128C', '2017-03-25 07:08:20', NULL, NULL),
(5, 'C39', '2017-03-25 07:08:20', NULL, NULL),
(6, 'C39+', '2017-03-25 07:08:20', NULL, NULL),
(7, 'C39E', '2017-03-25 07:08:20', NULL, NULL),
(8, 'C39E+', '2017-03-25 07:08:20', NULL, NULL),
(9, 'C93', '2017-03-25 07:08:20', NULL, NULL),
(10, 'S25', '2017-03-25 07:08:20', NULL, NULL),
(11, 'S25+', '2017-03-25 07:08:20', NULL, NULL),
(12, 'I25', '2017-03-25 07:08:20', NULL, NULL),
(13, 'I25+', '2017-03-25 07:08:20', NULL, NULL),
(14, 'EAN2', '2017-03-25 07:08:20', NULL, NULL),
(15, 'EAN5', '2017-03-25 07:08:20', NULL, NULL),
(16, 'EAN8', '2017-03-25 07:08:20', NULL, NULL),
(17, 'EAN13', '2017-03-25 07:08:20', NULL, NULL),
(18, 'UPCA', '2017-03-25 07:08:20', NULL, NULL),
(19, 'UPCE', '2017-03-25 07:08:20', NULL, NULL),
(20, 'MSI', '2017-03-25 07:08:20', NULL, NULL),
(21, 'MSI+', '2017-03-25 07:08:20', NULL, NULL),
(22, 'POSTNET', '2017-03-25 07:08:20', NULL, NULL),
(23, 'PLANET', '2017-03-25 07:08:20', NULL, NULL),
(24, 'RMS4CC', '2017-03-25 07:08:20', NULL, NULL),
(25, 'KIX', '2017-03-25 07:08:20', NULL, NULL),
(26, 'IMB', '2017-03-25 07:08:20', NULL, NULL),
(27, 'CODABAR', '2017-03-25 07:08:20', NULL, NULL),
(28, 'CODE11', '2017-03-25 07:08:20', NULL, NULL),
(29, 'PHARMA', '2017-03-25 07:08:20', NULL, NULL),
(30, 'PHARMA2T', '2017-03-25 07:08:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Computer', 1, '2017-07-21 15:30:27', '2017-07-21 15:30:27', NULL),
(2, 'Monitor', 1, '2017-07-21 20:16:55', '2017-07-21 20:16:55', NULL),
(3, 'Printers', 1, '2017-07-21 20:25:28', '2017-07-21 20:25:28', NULL),
(4, 'UPS', 1, '2017-07-21 20:26:03', '2017-07-21 20:26:03', NULL),
(5, 'Mobile Devicess', 1, '2017-07-31 19:55:41', '2017-07-31 19:55:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category_model`
--

CREATE TABLE IF NOT EXISTS `category_model` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `category_model`
--

INSERT INTO `category_model` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Asset', '2016-03-19 06:50:21', NULL, NULL),
(2, 'Consumable', '2016-03-19 06:50:24', NULL, NULL),
(3, 'Accessory', '2016-03-19 06:53:14', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Galle', '2015-11-18 17:44:06', NULL, NULL),
(2, 'Colombo', '2015-11-18 17:44:06', NULL, NULL),
(3, 'Maharagama', '2015-11-18 17:44:22', NULL, NULL),
(4, 'Kaluthara', '2015-11-18 17:44:22', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `depreciation_types`
--

CREATE TABLE IF NOT EXISTS `depreciation_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `depreciation_types`
--

INSERT INTO `depreciation_types` (`id`, `name`, `rate`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Straight-Line Depreciation', NULL, '2016-03-20 18:07:08', NULL, NULL),
(2, 'Declining Balance Depreciation', '1.50', '2016-03-20 18:07:26', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE IF NOT EXISTS `devices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) DEFAULT NULL,
  `device_model_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `asset_id`, `device_model_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2017-08-03 06:54:28', '2017-08-03 06:54:28', NULL),
(2, 2, 1, '2017-08-03 06:54:29', '2017-08-03 06:54:29', NULL),
(3, 3, 1, '2017-08-03 06:54:29', '2017-08-03 06:54:29', NULL),
(4, 4, 1, '2017-08-03 06:54:29', '2017-08-03 06:54:29', NULL),
(5, 5, 1, '2017-08-03 06:54:29', '2017-08-03 06:54:29', NULL),
(6, 6, 1, '2017-08-03 06:54:29', '2017-08-03 06:54:29', NULL),
(7, 7, 1, '2017-08-03 06:54:29', '2017-08-03 06:54:29', NULL),
(8, 8, 1, '2017-08-03 06:54:29', '2017-08-03 06:54:29', NULL),
(9, 9, 1, '2017-08-03 06:54:29', '2017-08-03 06:54:29', NULL),
(10, 10, 1, '2017-08-03 06:54:29', '2017-08-03 06:54:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `device_fieldset_values`
--

CREATE TABLE IF NOT EXISTS `device_fieldset_values` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `device_id` int(10) DEFAULT NULL,
  `fieldset_id` varchar(255) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=161 ;

--
-- Dumping data for table `device_fieldset_values`
--

INSERT INTO `device_fieldset_values` (`id`, `device_id`, `fieldset_id`, `value`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '1', '', '2017-08-03 06:54:28', NULL, NULL),
(2, 1, '2', '2.7GHz', '2017-08-03 06:54:28', NULL, NULL),
(3, 1, '3', '', '2017-08-03 06:54:28', NULL, NULL),
(4, 1, '4', '', '2017-08-03 06:54:28', NULL, NULL),
(5, 1, '5', '', '2017-08-03 06:54:28', NULL, NULL),
(6, 1, '6', '', '2017-08-03 06:54:28', NULL, NULL),
(7, 1, '7', '', '2017-08-03 06:54:28', NULL, NULL),
(8, 1, '8', '', '2017-08-03 06:54:28', NULL, NULL),
(9, 1, '9', '', '2017-08-03 06:54:28', NULL, NULL),
(10, 1, '10', '', '2017-08-03 06:54:28', NULL, NULL),
(11, 1, '11', '', '2017-08-03 06:54:28', NULL, NULL),
(12, 1, '12', '', '2017-08-03 06:54:28', NULL, NULL),
(13, 1, '13', 'Windows 10', '2017-08-03 06:54:28', NULL, NULL),
(14, 1, '14', '', '2017-08-03 06:54:28', NULL, NULL),
(15, 1, '15', '', '2017-08-03 06:54:28', NULL, NULL),
(16, 1, '16', '', '2017-08-03 06:54:28', NULL, NULL),
(17, 2, '1', '', '2017-08-03 06:54:29', NULL, NULL),
(18, 2, '2', '2.7GHz', '2017-08-03 06:54:29', NULL, NULL),
(19, 2, '3', '', '2017-08-03 06:54:29', NULL, NULL),
(20, 2, '4', '', '2017-08-03 06:54:29', NULL, NULL),
(21, 2, '5', '', '2017-08-03 06:54:29', NULL, NULL),
(22, 2, '6', '', '2017-08-03 06:54:29', NULL, NULL),
(23, 2, '7', '', '2017-08-03 06:54:29', NULL, NULL),
(24, 2, '8', '', '2017-08-03 06:54:29', NULL, NULL),
(25, 2, '9', '', '2017-08-03 06:54:29', NULL, NULL),
(26, 2, '10', '', '2017-08-03 06:54:29', NULL, NULL),
(27, 2, '11', '', '2017-08-03 06:54:29', NULL, NULL),
(28, 2, '12', '', '2017-08-03 06:54:29', NULL, NULL),
(29, 2, '13', 'Windows 10', '2017-08-03 06:54:29', NULL, NULL),
(30, 2, '14', '', '2017-08-03 06:54:29', NULL, NULL),
(31, 2, '15', '', '2017-08-03 06:54:29', NULL, NULL),
(32, 2, '16', '', '2017-08-03 06:54:29', NULL, NULL),
(33, 3, '1', '', '2017-08-03 06:54:29', NULL, NULL),
(34, 3, '2', '2.7GHz', '2017-08-03 06:54:29', NULL, NULL),
(35, 3, '3', '', '2017-08-03 06:54:29', NULL, NULL),
(36, 3, '4', '', '2017-08-03 06:54:29', NULL, NULL),
(37, 3, '5', '', '2017-08-03 06:54:29', NULL, NULL),
(38, 3, '6', '', '2017-08-03 06:54:29', NULL, NULL),
(39, 3, '7', '', '2017-08-03 06:54:29', NULL, NULL),
(40, 3, '8', '', '2017-08-03 06:54:29', NULL, NULL),
(41, 3, '9', '', '2017-08-03 06:54:29', NULL, NULL),
(42, 3, '10', '', '2017-08-03 06:54:29', NULL, NULL),
(43, 3, '11', '', '2017-08-03 06:54:29', NULL, NULL),
(44, 3, '12', '', '2017-08-03 06:54:29', NULL, NULL),
(45, 3, '13', 'Windows 10', '2017-08-03 06:54:29', NULL, NULL),
(46, 3, '14', '', '2017-08-03 06:54:29', NULL, NULL),
(47, 3, '15', '', '2017-08-03 06:54:29', NULL, NULL),
(48, 3, '16', '', '2017-08-03 06:54:29', NULL, NULL),
(49, 4, '1', '', '2017-08-03 06:54:29', NULL, NULL),
(50, 4, '2', '2.7GHz', '2017-08-03 06:54:29', NULL, NULL),
(51, 4, '3', '', '2017-08-03 06:54:29', NULL, NULL),
(52, 4, '4', '', '2017-08-03 06:54:29', NULL, NULL),
(53, 4, '5', '', '2017-08-03 06:54:29', NULL, NULL),
(54, 4, '6', '', '2017-08-03 06:54:29', NULL, NULL),
(55, 4, '7', '', '2017-08-03 06:54:29', NULL, NULL),
(56, 4, '8', '', '2017-08-03 06:54:29', NULL, NULL),
(57, 4, '9', '', '2017-08-03 06:54:29', NULL, NULL),
(58, 4, '10', '', '2017-08-03 06:54:29', NULL, NULL),
(59, 4, '11', '', '2017-08-03 06:54:29', NULL, NULL),
(60, 4, '12', '', '2017-08-03 06:54:29', NULL, NULL),
(61, 4, '13', 'Windows 10', '2017-08-03 06:54:29', NULL, NULL),
(62, 4, '14', '', '2017-08-03 06:54:29', NULL, NULL),
(63, 4, '15', '', '2017-08-03 06:54:29', NULL, NULL),
(64, 4, '16', '', '2017-08-03 06:54:29', NULL, NULL),
(65, 5, '1', '', '2017-08-03 06:54:29', NULL, NULL),
(66, 5, '2', '2.7GHz', '2017-08-03 06:54:29', NULL, NULL),
(67, 5, '3', '', '2017-08-03 06:54:29', NULL, NULL),
(68, 5, '4', '', '2017-08-03 06:54:29', NULL, NULL),
(69, 5, '5', '', '2017-08-03 06:54:29', NULL, NULL),
(70, 5, '6', '', '2017-08-03 06:54:29', NULL, NULL),
(71, 5, '7', '', '2017-08-03 06:54:29', NULL, NULL),
(72, 5, '8', '', '2017-08-03 06:54:29', NULL, NULL),
(73, 5, '9', '', '2017-08-03 06:54:29', NULL, NULL),
(74, 5, '10', '', '2017-08-03 06:54:29', NULL, NULL),
(75, 5, '11', '', '2017-08-03 06:54:29', NULL, NULL),
(76, 5, '12', '', '2017-08-03 06:54:29', NULL, NULL),
(77, 5, '13', 'Windows 10', '2017-08-03 06:54:29', NULL, NULL),
(78, 5, '14', '', '2017-08-03 06:54:29', NULL, NULL),
(79, 5, '15', '', '2017-08-03 06:54:29', NULL, NULL),
(80, 5, '16', '', '2017-08-03 06:54:29', NULL, NULL),
(81, 6, '1', '', '2017-08-03 06:54:29', NULL, NULL),
(82, 6, '2', '2.7GHz', '2017-08-03 06:54:29', NULL, NULL),
(83, 6, '3', '', '2017-08-03 06:54:29', NULL, NULL),
(84, 6, '4', '', '2017-08-03 06:54:29', NULL, NULL),
(85, 6, '5', '', '2017-08-03 06:54:29', NULL, NULL),
(86, 6, '6', '', '2017-08-03 06:54:29', NULL, NULL),
(87, 6, '7', '', '2017-08-03 06:54:29', NULL, NULL),
(88, 6, '8', '', '2017-08-03 06:54:29', NULL, NULL),
(89, 6, '9', '', '2017-08-03 06:54:29', NULL, NULL),
(90, 6, '10', '', '2017-08-03 06:54:29', NULL, NULL),
(91, 6, '11', '', '2017-08-03 06:54:29', NULL, NULL),
(92, 6, '12', '', '2017-08-03 06:54:29', NULL, NULL),
(93, 6, '13', 'Windows 10', '2017-08-03 06:54:29', NULL, NULL),
(94, 6, '14', '', '2017-08-03 06:54:29', NULL, NULL),
(95, 6, '15', '', '2017-08-03 06:54:29', NULL, NULL),
(96, 6, '16', '', '2017-08-03 06:54:29', NULL, NULL),
(97, 7, '1', '', '2017-08-03 06:54:29', NULL, NULL),
(98, 7, '2', '2.7GHz', '2017-08-03 06:54:29', NULL, NULL),
(99, 7, '3', '', '2017-08-03 06:54:29', NULL, NULL),
(100, 7, '4', '', '2017-08-03 06:54:29', NULL, NULL),
(101, 7, '5', '', '2017-08-03 06:54:29', NULL, NULL),
(102, 7, '6', '', '2017-08-03 06:54:29', NULL, NULL),
(103, 7, '7', '', '2017-08-03 06:54:29', NULL, NULL),
(104, 7, '8', '', '2017-08-03 06:54:29', NULL, NULL),
(105, 7, '9', '', '2017-08-03 06:54:29', NULL, NULL),
(106, 7, '10', '', '2017-08-03 06:54:29', NULL, NULL),
(107, 7, '11', '', '2017-08-03 06:54:29', NULL, NULL),
(108, 7, '12', '', '2017-08-03 06:54:29', NULL, NULL),
(109, 7, '13', 'Windows 10', '2017-08-03 06:54:29', NULL, NULL),
(110, 7, '14', '', '2017-08-03 06:54:29', NULL, NULL),
(111, 7, '15', '', '2017-08-03 06:54:29', NULL, NULL),
(112, 7, '16', '', '2017-08-03 06:54:29', NULL, NULL),
(113, 8, '1', '', '2017-08-03 06:54:29', NULL, NULL),
(114, 8, '2', '2.7GHz', '2017-08-03 06:54:29', NULL, NULL),
(115, 8, '3', '', '2017-08-03 06:54:29', NULL, NULL),
(116, 8, '4', '', '2017-08-03 06:54:29', NULL, NULL),
(117, 8, '5', '', '2017-08-03 06:54:29', NULL, NULL),
(118, 8, '6', '', '2017-08-03 06:54:29', NULL, NULL),
(119, 8, '7', '', '2017-08-03 06:54:29', NULL, NULL),
(120, 8, '8', '', '2017-08-03 06:54:29', NULL, NULL),
(121, 8, '9', '', '2017-08-03 06:54:29', NULL, NULL),
(122, 8, '10', '', '2017-08-03 06:54:29', NULL, NULL),
(123, 8, '11', '', '2017-08-03 06:54:29', NULL, NULL),
(124, 8, '12', '', '2017-08-03 06:54:29', NULL, NULL),
(125, 8, '13', 'Windows 10', '2017-08-03 06:54:29', NULL, NULL),
(126, 8, '14', '', '2017-08-03 06:54:29', NULL, NULL),
(127, 8, '15', '', '2017-08-03 06:54:29', NULL, NULL),
(128, 8, '16', '', '2017-08-03 06:54:29', NULL, NULL),
(129, 9, '1', '', '2017-08-03 06:54:29', NULL, NULL),
(130, 9, '2', '2.7GHz', '2017-08-03 06:54:29', NULL, NULL),
(131, 9, '3', '', '2017-08-03 06:54:29', NULL, NULL),
(132, 9, '4', '', '2017-08-03 06:54:29', NULL, NULL),
(133, 9, '5', '', '2017-08-03 06:54:29', NULL, NULL),
(134, 9, '6', '', '2017-08-03 06:54:29', NULL, NULL),
(135, 9, '7', '', '2017-08-03 06:54:29', NULL, NULL),
(136, 9, '8', '', '2017-08-03 06:54:29', NULL, NULL),
(137, 9, '9', '', '2017-08-03 06:54:29', NULL, NULL),
(138, 9, '10', '', '2017-08-03 06:54:29', NULL, NULL),
(139, 9, '11', '', '2017-08-03 06:54:29', NULL, NULL),
(140, 9, '12', '', '2017-08-03 06:54:29', NULL, NULL),
(141, 9, '13', 'Windows 10', '2017-08-03 06:54:29', NULL, NULL),
(142, 9, '14', '', '2017-08-03 06:54:29', NULL, NULL),
(143, 9, '15', '', '2017-08-03 06:54:29', NULL, NULL),
(144, 9, '16', '', '2017-08-03 06:54:29', NULL, NULL),
(145, 10, '1', '', '2017-08-03 06:54:29', NULL, NULL),
(146, 10, '2', '2.7GHz', '2017-08-03 06:54:29', NULL, NULL),
(147, 10, '3', '', '2017-08-03 06:54:29', NULL, NULL),
(148, 10, '4', '', '2017-08-03 06:54:29', NULL, NULL),
(149, 10, '5', '', '2017-08-03 06:54:29', NULL, NULL),
(150, 10, '6', '', '2017-08-03 06:54:29', NULL, NULL),
(151, 10, '7', '', '2017-08-03 06:54:29', NULL, NULL),
(152, 10, '8', '', '2017-08-03 06:54:29', NULL, NULL),
(153, 10, '9', '', '2017-08-03 06:54:29', NULL, NULL),
(154, 10, '10', '', '2017-08-03 06:54:29', NULL, NULL),
(155, 10, '11', '', '2017-08-03 06:54:29', NULL, NULL),
(156, 10, '12', '', '2017-08-03 06:54:29', NULL, NULL),
(157, 10, '13', 'Windows 10', '2017-08-03 06:54:29', NULL, NULL),
(158, 10, '14', '', '2017-08-03 06:54:29', NULL, NULL),
(159, 10, '15', '', '2017-08-03 06:54:29', NULL, NULL),
(160, 10, '16', '', '2017-08-03 06:54:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `device_modal`
--

CREATE TABLE IF NOT EXISTS `device_modal` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_modal_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=70 ;

--
-- Dumping data for table `device_modal`
--

INSERT INTO `device_modal` (`id`, `asset_modal_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Processor	', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(2, 1, 'Mother Board	', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(3, 1, 'RAM	', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(4, 1, 'VGA	', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(5, 1, 'Hard Disk	', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(6, 1, 'Optical Media', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(7, 1, 'USB Ports', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(8, 1, 'Operating System', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(9, 1, 'Optical Media', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(10, 1, 'Ports	', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(11, 2, 'Processor	', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(12, 2, 'Mother Board	', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(13, 2, 'RAM	', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(14, 2, 'VGA	', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(15, 2, 'Hard Disk	', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(16, 2, 'Optical Media', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(17, 2, 'USB Ports', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(18, 2, 'Operating System', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(19, 2, 'Optical Media', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(20, 2, 'Ports	', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(21, 3, 'Processor	', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(22, 3, 'Mother Board	', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(23, 3, 'RAM	', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(24, 3, 'VGA	', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(25, 3, 'Hard Disk	', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(26, 3, 'Optical Media', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(27, 3, 'No of USB Ports', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(28, 3, 'Operating System', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(29, 3, 'Optical Media', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(30, 3, 'Ports	', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(31, 3, 'Accerios			', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(32, 4, 'Screen ', '2017-07-31 19:45:43', '2017-07-31 19:45:43', NULL),
(33, 5, 'Screen ', '2017-07-31 19:46:08', '2017-07-31 19:46:08', NULL),
(34, 6, 'Screen ', '2017-07-31 19:46:36', '2017-07-31 19:46:36', NULL),
(35, 7, 'Printer Media Size', '2017-07-31 19:48:12', '2017-07-31 19:48:12', NULL),
(36, 7, 'Print Type', '2017-07-31 19:48:12', '2017-07-31 19:48:12', NULL),
(37, 7, 'Interface', '2017-07-31 19:48:12', '2017-07-31 19:48:12', NULL),
(38, 7, 'Ribbon', '2017-07-31 19:48:12', '2017-07-31 19:48:12', NULL),
(39, 8, 'Printer Media Size', '2017-07-31 19:49:11', '2017-07-31 19:49:11', NULL),
(40, 8, 'Print Type', '2017-07-31 19:49:11', '2017-07-31 19:49:11', NULL),
(41, 8, 'Interface', '2017-07-31 19:49:11', '2017-07-31 19:49:11', NULL),
(42, 8, 'Ribbon', '2017-07-31 19:49:11', '2017-07-31 19:49:11', NULL),
(43, 9, 'Printer Media Size', '2017-07-31 19:50:45', '2017-07-31 19:50:45', NULL),
(44, 9, 'Print Type', '2017-07-31 19:50:45', '2017-07-31 19:50:45', NULL),
(45, 9, 'Interface', '2017-07-31 19:50:45', '2017-07-31 19:50:45', NULL),
(46, 9, 'Ribbon', '2017-07-31 19:50:45', '2017-07-31 19:50:45', NULL),
(47, 9, 'Memmory', '2017-07-31 19:50:45', '2017-07-31 19:50:45', NULL),
(48, 9, 'Color', '2017-07-31 19:50:45', '2017-07-31 19:50:45', NULL),
(49, 10, 'Printer Media Size', '2017-07-31 19:52:34', '2017-07-31 19:52:34', NULL),
(50, 10, 'Print Type', '2017-07-31 19:52:34', '2017-07-31 19:52:34', NULL),
(51, 10, 'Interface', '2017-07-31 19:52:34', '2017-07-31 19:52:34', NULL),
(52, 10, 'Ribbon', '2017-07-31 19:52:34', '2017-07-31 19:52:34', NULL),
(53, 10, 'Memmory', '2017-07-31 19:52:34', '2017-07-31 19:52:34', NULL),
(54, 10, 'Color', '2017-07-31 19:52:34', '2017-07-31 19:52:34', NULL),
(55, 11, 'Printer Media Size', '2017-07-31 19:53:00', '2017-07-31 19:53:00', NULL),
(56, 11, 'Print Type', '2017-07-31 19:54:04', '2017-07-31 19:54:04', NULL),
(57, 11, 'Interface', '2017-07-31 19:54:04', '2017-07-31 19:54:04', NULL),
(58, 11, 'Ribbon', '2017-07-31 19:54:04', '2017-07-31 19:54:04', NULL),
(59, 12, 'UPS Capacity', '2017-07-31 19:55:21', '2017-07-31 19:55:21', NULL),
(60, 12, 'Power Outlets	', '2017-07-31 19:55:21', '2017-07-31 19:55:21', NULL),
(61, 13, 'SIM', '2017-07-31 19:56:16', '2017-07-31 19:56:16', NULL),
(62, 13, 'Screen', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(63, 13, 'Operating System', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(64, 13, 'CPU ', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(65, 13, 'Memory	', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(66, 13, 'Cammera	', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(67, 13, 'Battery', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(68, 13, 'Color', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(69, 13, 'Accessries', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(40) DEFAULT NULL,
  `first_name` varchar(90) NOT NULL,
  `last_name` varchar(90) NOT NULL,
  `nic` varchar(10) DEFAULT NULL,
  `address` text,
  `mobile` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `depth` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `employee_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dsi_employee_dsi_employee_type1_idx` (`employee_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `code`, `first_name`, `last_name`, `nic`, `address`, `mobile`, `email`, `parent`, `lft`, `rgt`, `depth`, `status`, `created_at`, `updated_at`, `deleted_at`, `employee_type_id`) VALUES
(1, NULL, 'super', 'admin', NULL, NULL, NULL, '', NULL, 1, 268, 0, 1, '2017-02-06 00:00:00', '2017-08-01 08:31:54', NULL, 1),
(2, 'Admin001', 'Admin', 'Master', '923632964V', '', '0758054772', '', 1, 150, 261, 1, 1, '2017-07-21 10:26:32', '2017-08-01 08:31:54', NULL, 1),
(3, '012036', 'Vajira ', 'Jayasingha', '632810059V', 'No: 40 B, Kandy Rd Nittambuwa', '0777960190', 'vajiraj@rdb.lk', 2, 245, 260, 2, 1, '2017-07-31 15:03:48', '2017-08-01 08:31:54', NULL, 11),
(4, '011846', 'Suravinda ', 'Karunathilake', '782871242V', 'Stage 1, Bandaranayake Mw, Anurdhapura', '0714463563', 'suravindak@rdb.lk', 3, 246, 259, 3, 1, '2017-07-31 15:05:08', '2017-08-01 08:31:54', NULL, 12),
(5, '011786', 'Sampath', 'Champika', '813224160V', 'No : 54/14, Bowala, Kandy.', '0774410963', 'sampathj@rdb.lk', 4, 247, 248, 4, 1, '2017-07-31 15:07:42', '2017-07-31 15:07:42', NULL, 13),
(6, '012113', 'Amith', 'Eranga', '873390735V', 'No: 305/22, Magammana, Homagama', '0727407332', 'amithj@rdb.lk', 4, 249, 254, 4, 1, '2017-07-31 15:08:52', '2017-07-31 16:30:07', NULL, 13),
(7, '010010', 'Yakupitiyage', 'Kumarasingha', '582270864V', 'Thuththiripitiya, Halthota.', '0342264276', '', 6, 250, 253, 5, 1, '2017-07-31 15:10:04', '2017-08-01 10:22:21', NULL, 14),
(8, 'B001', 'Branch', 'User', '1111111111', 'Millaniya', '0342252351', '', 7, 251, 252, 6, 1, '2017-07-31 16:30:07', '2017-07-31 16:30:07', NULL, 15),
(9, '011527', 'Nishantha ', 'Bandara', '833312553V', 'Kadiharaya, Bamunukotuwa', '0714461916', 'nishanthab@rdb.lk', 4, 255, 256, 4, 1, '2017-08-01 08:28:12', '2017-08-01 08:28:12', NULL, 13),
(10, '011865', 'Dhammika ', 'Amarapala', '820840690V', 'No.41/32A, Isurupura Anuradhapura', '0777003988', '', 4, 257, 258, 4, 1, '2017-08-01 08:31:54', '2017-08-01 08:31:54', NULL, 13);

-- --------------------------------------------------------

--
-- Table structure for table `employee_designation`
--

CREATE TABLE IF NOT EXISTS `employee_designation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employee_type`
--

CREATE TABLE IF NOT EXISTS `employee_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `status` int(11) DEFAULT '1',
  `parent` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `employee_type`
--

INSERT INTO `employee_type` (`id`, `name`, `status`, `parent`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 1, 1, '2017-02-14 00:00:00', '2017-04-21 18:06:11', NULL),
(11, 'Head Of IT', 1, 1, '2017-07-21 11:28:05', '2017-07-21 11:28:05', NULL),
(12, 'Senior Manager', 1, 11, '2017-07-21 11:28:23', '2017-07-21 11:28:23', NULL),
(13, 'IT Officer', 1, 12, '2017-07-21 11:28:35', '2017-07-21 11:28:35', NULL),
(14, 'Branch Manager', 1, 13, '2017-07-21 11:28:53', '2017-07-21 12:45:48', NULL),
(15, 'Asset Owner', 1, 14, '2017-07-21 13:30:30', '2017-07-21 13:30:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fieldset`
--

CREATE TABLE IF NOT EXISTS `fieldset` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_modal_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=97 ;

--
-- Dumping data for table `fieldset`
--

INSERT INTO `fieldset` (`id`, `device_modal_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Processor Type ', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(2, 1, 'Clock Speed', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(3, 2, 'Mother Board Type ', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(4, 2, 'Cash Memory ', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(5, 3, 'RAM Type ', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(6, 3, 'RAM Capacity ', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(7, 4, 'VGA Type ', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(8, 4, 'VGA Capacity ', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(9, 5, 'Hard Disk Type ', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(10, 5, 'Hard Disk Capacity', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(11, 6, 'Optical Media Type', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(12, 7, 'No of USB Ports', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(13, 8, 'OS Version', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(14, 9, 'Working Condition ', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(15, 10, 'VGA Port ', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(16, 10, 'HDMI Ports ', '2017-07-31 19:35:44', '2017-07-31 19:35:44', NULL),
(17, 11, 'Processor Type ', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(18, 11, 'Clock Speed', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(19, 12, 'Mother Board Type', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(20, 12, 'Cash Memory', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(21, 13, 'RAM Type', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(22, 13, 'RAM Capacity', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(23, 14, 'VGA Type ', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(24, 14, 'VGA Capacity', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(25, 15, 'Hard Disk Type ', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(26, 15, 'Hard Disk Capacity', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(27, 16, 'Optical Media Type', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(28, 17, 'No of USB Ports', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(29, 18, 'OS Version ', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(30, 19, 'Working Condition', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(31, 20, 'VGA Port ', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(32, 20, 'HDMI Ports ', '2017-07-31 19:39:45', '2017-07-31 19:39:45', NULL),
(33, 21, 'Processor Type ', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(34, 21, 'Clock Speed', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(35, 22, 'Mother Board Type', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(36, 22, 'Cash Memory ', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(37, 23, 'RAM Type ', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(38, 23, 'RAM Capacity ', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(39, 24, 'VGA Type ', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(40, 24, 'VGA Capacity', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(41, 25, 'Hard Disk Type ', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(42, 25, 'Hard Disk Capacity', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(43, 26, 'Optical Media Type', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(44, 27, 'Number of USB Ports', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(45, 28, 'OS Version ', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(46, 29, 'Working Condition', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(47, 30, 'VGA Port', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(48, 30, 'HDMI Ports', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(49, 31, 'Back Pack ', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(50, 31, 'Carry Case ', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(51, 31, 'Power Adapter', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(52, 31, 'HDMI Convertor', '2017-07-31 19:45:00', '2017-07-31 19:45:00', NULL),
(53, 32, 'Screen Size', '2017-07-31 19:45:43', '2017-07-31 19:45:43', NULL),
(54, 33, 'Screen Size', '2017-07-31 19:46:08', '2017-07-31 19:46:08', NULL),
(55, 34, 'Screen Size', '2017-07-31 19:46:36', '2017-07-31 19:46:36', NULL),
(56, 35, 'Media Size', '2017-07-31 19:48:12', '2017-07-31 19:48:12', NULL),
(57, 36, 'Print Type', '2017-07-31 19:48:12', '2017-07-31 19:48:12', NULL),
(58, 37, 'USB / Ethernet / Com', '2017-07-31 19:48:12', '2017-07-31 19:48:12', NULL),
(59, 38, 'Ribbon Model', '2017-07-31 19:48:12', '2017-07-31 19:48:12', NULL),
(60, 39, 'Media Size ', '2017-07-31 19:49:11', '2017-07-31 19:49:11', NULL),
(61, 40, 'Print Type ', '2017-07-31 19:49:11', '2017-07-31 19:49:11', NULL),
(62, 41, 'USB / Ethernet / Com', '2017-07-31 19:49:11', '2017-07-31 19:49:11', NULL),
(63, 42, 'Ribbon Model', '2017-07-31 19:49:11', '2017-07-31 19:49:11', NULL),
(64, 43, 'Media Size ', '2017-07-31 19:50:45', '2017-07-31 19:50:45', NULL),
(65, 44, 'Print Type', '2017-07-31 19:50:45', '2017-07-31 19:50:45', NULL),
(66, 45, 'USB / Ethernet / Wirless', '2017-07-31 19:50:45', '2017-07-31 19:50:45', NULL),
(67, 46, 'Ribbon Model', '2017-07-31 19:50:45', '2017-07-31 19:50:45', NULL),
(68, 47, 'Buffer Memmory', '2017-07-31 19:50:45', '2017-07-31 19:50:45', NULL),
(69, 48, 'Printer Color', '2017-07-31 19:50:45', '2017-07-31 19:50:45', NULL),
(70, 49, 'Media Size', '2017-07-31 19:52:34', '2017-07-31 19:52:34', NULL),
(71, 50, 'Print Type', '2017-07-31 19:52:34', '2017-07-31 19:52:34', NULL),
(72, 51, 'USB / Ethernet / Wirless', '2017-07-31 19:52:34', '2017-07-31 19:52:34', NULL),
(73, 52, 'Cardridge Model', '2017-07-31 19:52:34', '2017-07-31 19:52:34', NULL),
(74, 53, 'Buffer Memmory ', '2017-07-31 19:52:34', '2017-07-31 19:52:34', NULL),
(75, 54, 'Printer Color', '2017-07-31 19:52:34', '2017-07-31 19:52:34', NULL),
(76, 55, 'Media Size', '2017-07-31 19:53:00', '2017-07-31 19:53:00', NULL),
(77, 56, 'Print Type', '2017-07-31 19:54:04', '2017-07-31 19:54:04', NULL),
(78, 57, 'USB / Ethernet / Wirless', '2017-07-31 19:54:04', '2017-07-31 19:54:04', NULL),
(79, 58, 'Cardridge Model', '2017-07-31 19:54:04', '2017-07-31 19:54:04', NULL),
(80, 59, 'Volltage Capacity', '2017-07-31 19:55:21', '2017-07-31 19:55:21', NULL),
(81, 60, 'Number of Male Power Outlets ', '2017-07-31 19:55:21', '2017-07-31 19:55:21', NULL),
(82, 60, 'Number of Female Power Outlets', '2017-07-31 19:55:21', '2017-07-31 19:55:21', NULL),
(83, 61, 'No of SIM Solt', '2017-07-31 19:56:16', '2017-07-31 19:56:16', NULL),
(84, 62, 'Screen Size', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(85, 63, 'OS Version', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(86, 64, 'CPU Type', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(87, 65, 'Internal', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(88, 65, 'External', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(89, 66, 'Primary', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(90, 66, 'Secondary', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(91, 67, 'Battery Details', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(92, 68, 'Phone Color', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(93, 69, 'Charger ', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(94, 69, 'Headset ', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(95, 69, 'Pouch', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL),
(96, 69, 'Data Cable', '2017-07-31 19:58:33', '2017-07-31 19:58:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fonts-list`
--

CREATE TABLE IF NOT EXISTS `fonts-list` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) DEFAULT NULL,
  `icon` varchar(30) DEFAULT NULL,
  `unicode` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=594 ;

--
-- Dumping data for table `fonts-list`
--

INSERT INTO `fonts-list` (`id`, `type`, `icon`, `unicode`) VALUES
(1, 'fa', 'fa-adjust', '&#xf042;'),
(2, 'fa', 'fa-adn', '&#xf170;'),
(3, 'fa', 'fa-align-center', '&#xf037;'),
(4, 'fa', 'fa-align-justify', '&#xf039;'),
(5, 'fa', 'fa-align-left', '&#xf036;'),
(6, 'fa', 'fa-align-right', '&#xf038;'),
(7, 'fa', 'fa-ambulance', '&#xf0f9;'),
(8, 'fa', 'fa-anchor', '&#xf13d;'),
(9, 'fa', 'fa-android', '&#xf17b;'),
(10, 'fa', 'fa-angellist', '&#xf209;'),
(11, 'fa', 'fa-angle-double-down', '&#xf103;'),
(12, 'fa', 'fa-angle-double-left', '&#xf100;'),
(13, 'fa', 'fa-angle-double-right', '&#xf101;'),
(14, 'fa', 'fa-angle-double-up', '&#xf102;'),
(15, 'fa', 'fa-angle-down', '&#xf107;'),
(16, 'fa', 'fa-angle-left', '&#xf104;'),
(17, 'fa', 'fa-angle-right', '&#xf105;'),
(18, 'fa', 'fa-angle-up', '&#xf106;'),
(19, 'fa', 'fa-apple', '&#xf179;'),
(20, 'fa', 'fa-archive', '&#xf187;'),
(21, 'fa', 'fa-area-chart', '&#xf1fe;'),
(22, 'fa', 'fa-arrow-circle-down', '&#xf0ab;'),
(23, 'fa', 'fa-arrow-circle-left', '&#xf0a8;'),
(24, 'fa', 'fa-arrow-circle-o-down', '&#xf01a;'),
(25, 'fa', 'fa-arrow-circle-o-left', '&#xf190;'),
(26, 'fa', 'fa-arrow-circle-o-right', '&#xf18e;'),
(27, 'fa', 'fa-arrow-circle-o-up', '&#xf01b;'),
(28, 'fa', 'fa-arrow-circle-right', '&#xf0a9;'),
(29, 'fa', 'fa-arrow-circle-up', '&#xf0aa;'),
(30, 'fa', 'fa-arrow-down', '&#xf063;'),
(31, 'fa', 'fa-arrow-left', '&#xf060;'),
(32, 'fa', 'fa-arrow-right', '&#xf061;'),
(33, 'fa', 'fa-arrow-up', '&#xf062;'),
(34, 'fa', 'fa-arrows', '&#xf047;'),
(35, 'fa', 'fa-arrows-alt', '&#xf0b2;'),
(36, 'fa', 'fa-arrows-h', '&#xf07e;'),
(37, 'fa', 'fa-arrows-v', '&#xf07d;'),
(38, 'fa', 'fa-asterisk', '&#xf069;'),
(39, 'fa', 'fa-at', '&#xf1fa;'),
(40, 'fa', 'fa-automobile(alias)', '&#xf1b9;'),
(41, 'fa', 'fa-backward', '&#xf04a;'),
(42, 'fa', 'fa-ban', '&#xf05e;'),
(43, 'fa', 'fa-bank(alias)', '&#xf19c;'),
(44, 'fa', 'fa-bar-chart', '&#xf080;'),
(45, 'fa', 'fa-bar-chart-o(alias)', '&#xf080;'),
(46, 'fa', 'fa-barcode', '&#xf02a;'),
(47, 'fa', 'fa-bars', '&#xf0c9;'),
(48, 'fa', 'fa-bed', '&#xf236;'),
(49, 'fa', 'fa-beer', '&#xf0fc;'),
(50, 'fa', 'fa-behance', '&#xf1b4;'),
(51, 'fa', 'fa-behance-square', '&#xf1b5;'),
(52, 'fa', 'fa-bell', '&#xf0f3;'),
(53, 'fa', 'fa-bell-o', '&#xf0a2;'),
(54, 'fa', 'fa-bell-slash', '&#xf1f6;'),
(55, 'fa', 'fa-bell-slash-o', '&#xf1f7;'),
(56, 'fa', 'fa-bicycle', '&#xf206;'),
(57, 'fa', 'fa-binoculars', '&#xf1e5;'),
(58, 'fa', 'fa-birthday-cake', '&#xf1fd;'),
(59, 'fa', 'fa-bitbucket', '&#xf171;'),
(60, 'fa', 'fa-bitbucket-square', '&#xf172;'),
(61, 'fa', 'fa-bitcoin(alias)', '&#xf15a;'),
(62, 'fa', 'fa-bold', '&#xf032;'),
(63, 'fa', 'fa-bolt', '&#xf0e7;'),
(64, 'fa', 'fa-bomb', '&#xf1e2;'),
(65, 'fa', 'fa-book', '&#xf02d;'),
(66, 'fa', 'fa-bookmark', '&#xf02e;'),
(67, 'fa', 'fa-bookmark-o', '&#xf097;'),
(68, 'fa', 'fa-briefcase', '&#xf0b1;'),
(69, 'fa', 'fa-btc', '&#xf15a;'),
(70, 'fa', 'fa-bug', '&#xf188;'),
(71, 'fa', 'fa-building', '&#xf1ad;'),
(72, 'fa', 'fa-building-o', '&#xf0f7;'),
(73, 'fa', 'fa-bullhorn', '&#xf0a1;'),
(74, 'fa', 'fa-bullseye', '&#xf140;'),
(75, 'fa', 'fa-bus', '&#xf207;'),
(76, 'fa', 'fa-buysellads', NULL),
(77, 'fa', 'fa-cab(alias)', NULL),
(78, 'fa', 'fa-calculator', NULL),
(79, 'fa', 'fa-calendar', NULL),
(80, 'fa', 'fa-calendar-o', NULL),
(81, 'fa', 'fa-camera', NULL),
(82, 'fa', 'fa-camera-retro', NULL),
(83, 'fa', 'fa-car', NULL),
(84, 'fa', 'fa-caret-down', NULL),
(85, 'fa', 'fa-caret-left', NULL),
(86, 'fa', 'fa-caret-right', NULL),
(87, 'fa', 'fa-caret-square-o-down', NULL),
(88, 'fa', 'fa-caret-square-o-left', NULL),
(89, 'fa', 'fa-caret-square-o-right', NULL),
(90, 'fa', 'fa-caret-square-o-up', NULL),
(91, 'fa', 'fa-caret-up', NULL),
(92, 'fa', 'fa-cart-arrow-down', NULL),
(93, 'fa', 'fa-cart-plus', NULL),
(94, 'fa', 'fa-cc', NULL),
(95, 'fa', 'fa-cc-amex', NULL),
(96, 'fa', 'fa-cc-discover', NULL),
(97, 'fa', 'fa-cc-mastercard', NULL),
(98, 'fa', 'fa-cc-paypal', NULL),
(99, 'fa', 'fa-cc-stripe', NULL),
(100, 'fa', 'fa-cc-visa', NULL),
(101, 'fa', 'fa-certificate', NULL),
(102, 'fa', 'fa-chain(alias)', NULL),
(103, 'fa', 'fa-chain-broken', NULL),
(104, 'fa', 'fa-check', NULL),
(105, 'fa', 'fa-check-circle', NULL),
(106, 'fa', 'fa-check-circle-o', NULL),
(107, 'fa', 'fa-check-square', NULL),
(108, 'fa', 'fa-check-square-o', NULL),
(109, 'fa', 'fa-chevron-circle-down', NULL),
(110, 'fa', 'fa-chevron-circle-left', NULL),
(111, 'fa', 'fa-chevron-circle-right', NULL),
(112, 'fa', 'fa-chevron-circle-up', NULL),
(113, 'fa', 'fa-chevron-down', NULL),
(114, 'fa', 'fa-chevron-left', NULL),
(115, 'fa', 'fa-chevron-right', NULL),
(116, 'fa', 'fa-chevron-up', NULL),
(117, 'fa', 'fa-child', NULL),
(118, 'fa', 'fa-circle', NULL),
(119, 'fa', 'fa-circle-o', NULL),
(120, 'fa', 'fa-circle-o-notch', NULL),
(121, 'fa', 'fa-circle-thin', NULL),
(122, 'fa', 'fa-clipboard', NULL),
(123, 'fa', 'fa-clock-o', NULL),
(124, 'fa', 'fa-close(alias)', NULL),
(125, 'fa', 'fa-cloud', NULL),
(126, 'fa', 'fa-cloud-download', NULL),
(127, 'fa', 'fa-cloud-upload', NULL),
(128, 'fa', 'fa-cny(alias)', NULL),
(129, 'fa', 'fa-code', NULL),
(130, 'fa', 'fa-code-fork', NULL),
(131, 'fa', 'fa-codepen', NULL),
(132, 'fa', 'fa-coffee', NULL),
(133, 'fa', 'fa-cog', NULL),
(134, 'fa', 'fa-cogs', NULL),
(135, 'fa', 'fa-columns', NULL),
(136, 'fa', 'fa-comment', NULL),
(137, 'fa', 'fa-comment-o', NULL),
(138, 'fa', 'fa-comments', NULL),
(139, 'fa', 'fa-comments-o', NULL),
(140, 'fa', 'fa-compass', NULL),
(141, 'fa', 'fa-compress', NULL),
(142, 'fa', 'fa-connectdevelop', NULL),
(143, 'fa', 'fa-copy(alias)', NULL),
(144, 'fa', 'fa-copyright', NULL),
(145, 'fa', 'fa-credit-card', NULL),
(146, 'fa', 'fa-crop', NULL),
(147, 'fa', 'fa-crosshairs', NULL),
(148, 'fa', 'fa-css3', NULL),
(149, 'fa', 'fa-cube', NULL),
(150, 'fa', 'fa-cubes', NULL),
(151, 'fa', 'fa-cut(alias)', NULL),
(152, 'fa', 'fa-cutlery', NULL),
(153, 'fa', 'fa-dashboard(alias)', NULL),
(154, 'fa', 'fa-dashcube', NULL),
(155, 'fa', 'fa-database', NULL),
(156, 'fa', 'fa-dedent(alias)', NULL),
(157, 'fa', 'fa-delicious', NULL),
(158, 'fa', 'fa-desktop', NULL),
(159, 'fa', 'fa-deviantart', NULL),
(160, 'fa', 'fa-diamond', NULL),
(161, 'fa', 'fa-digg', NULL),
(162, 'fa', 'fa-dollar(alias)', NULL),
(163, 'fa', 'fa-dot-circle-o', NULL),
(164, 'fa', 'fa-download', NULL),
(165, 'fa', 'fa-dribbble', NULL),
(166, 'fa', 'fa-dropbox', NULL),
(167, 'fa', 'fa-drupal', NULL),
(168, 'fa', 'fa-edit(alias)', NULL),
(169, 'fa', 'fa-eject', NULL),
(170, 'fa', 'fa-ellipsis-h', NULL),
(171, 'fa', 'fa-ellipsis-v', NULL),
(172, 'fa', 'fa-empire', NULL),
(173, 'fa', 'fa-envelope', NULL),
(174, 'fa', 'fa-envelope-o', NULL),
(175, 'fa', 'fa-envelope-square', NULL),
(176, 'fa', 'fa-eraser', NULL),
(177, 'fa', 'fa-eur', NULL),
(178, 'fa', 'fa-euro(alias)', NULL),
(179, 'fa', 'fa-exchange', NULL),
(180, 'fa', 'fa-exclamation', NULL),
(181, 'fa', 'fa-exclamation-circle', NULL),
(182, 'fa', 'fa-exclamation-triangle', NULL),
(183, 'fa', 'fa-expand', NULL),
(184, 'fa', 'fa-external-link', NULL),
(185, 'fa', 'fa-external-link-square', NULL),
(186, 'fa', 'fa-eye', NULL),
(187, 'fa', 'fa-eye-slash', NULL),
(188, 'fa', 'fa-eyedropper', NULL),
(189, 'fa', 'fa-facebook', NULL),
(190, 'fa', 'fa-facebook-f(alias)', NULL),
(191, 'fa', 'fa-facebook-official', NULL),
(192, 'fa', 'fa-facebook-square', NULL),
(193, 'fa', 'fa-fast-backward', NULL),
(194, 'fa', 'fa-fast-forward', NULL),
(195, 'fa', 'fa-fax', NULL),
(196, 'fa', 'fa-female', NULL),
(197, 'fa', 'fa-fighter-jet', NULL),
(198, 'fa', 'fa-file', NULL),
(199, 'fa', 'fa-file-archive-o', NULL),
(200, 'fa', 'fa-file-audio-o', NULL),
(201, 'fa', 'fa-file-code-o', NULL),
(202, 'fa', 'fa-file-excel-o', NULL),
(203, 'fa', 'fa-file-image-o', NULL),
(204, 'fa', 'fa-file-movie-o(alias)', NULL),
(205, 'fa', 'fa-file-o', NULL),
(206, 'fa', 'fa-file-pdf-o', NULL),
(207, 'fa', 'fa-file-photo-o(alias)', NULL),
(208, 'fa', 'fa-file-picture-o(alias)', NULL),
(209, 'fa', 'fa-file-powerpoint-o', NULL),
(210, 'fa', 'fa-file-sound-o(alias)', NULL),
(211, 'fa', 'fa-file-text', NULL),
(212, 'fa', 'fa-file-text-o', NULL),
(213, 'fa', 'fa-file-video-o', NULL),
(214, 'fa', 'fa-file-word-o', NULL),
(215, 'fa', 'fa-file-zip-o(alias)', NULL),
(216, 'fa', 'fa-files-o', NULL),
(217, 'fa', 'fa-film', NULL),
(218, 'fa', 'fa-filter', NULL),
(219, 'fa', 'fa-fire', NULL),
(220, 'fa', 'fa-fire-extinguisher', NULL),
(221, 'fa', 'fa-flag', NULL),
(222, 'fa', 'fa-flag-checkered', NULL),
(223, 'fa', 'fa-flag-o', NULL),
(224, 'fa', 'fa-flash(alias)', NULL),
(225, 'fa', 'fa-flask', NULL),
(226, 'fa', 'fa-flickr', NULL),
(227, 'fa', 'fa-floppy-o', NULL),
(228, 'fa', 'fa-folder', NULL),
(229, 'fa', 'fa-folder-o', NULL),
(230, 'fa', 'fa-folder-open', NULL),
(231, 'fa', 'fa-folder-open-o', NULL),
(232, 'fa', 'fa-font', NULL),
(233, 'fa', 'fa-forumbee', NULL),
(234, 'fa', 'fa-forward', NULL),
(235, 'fa', 'fa-foursquare', NULL),
(236, 'fa', 'fa-frown-o', NULL),
(237, 'fa', 'fa-futbol-o', NULL),
(238, 'fa', 'fa-gamepad', NULL),
(239, 'fa', 'fa-gavel', NULL),
(240, 'fa', 'fa-gbp', NULL),
(241, 'fa', 'fa-ge(alias)', NULL),
(242, 'fa', 'fa-gear(alias)', NULL),
(243, 'fa', 'fa-gears(alias)', NULL),
(244, 'fa', 'fa-genderless(alias)', NULL),
(245, 'fa', 'fa-gift', NULL),
(246, 'fa', 'fa-git', NULL),
(247, 'fa', 'fa-git-square', NULL),
(248, 'fa', 'fa-github', NULL),
(249, 'fa', 'fa-github-alt', NULL),
(250, 'fa', 'fa-github-square', NULL),
(251, 'fa', 'fa-gittip(alias)', NULL),
(252, 'fa', 'fa-glass', NULL),
(253, 'fa', 'fa-globe', NULL),
(254, 'fa', 'fa-google', NULL),
(255, 'fa', 'fa-google-plus', NULL),
(256, 'fa', 'fa-google-plus-square', NULL),
(257, 'fa', 'fa-google-wallet', NULL),
(258, 'fa', 'fa-graduation-cap', NULL),
(259, 'fa', 'fa-gratipay', NULL),
(260, 'fa', 'fa-group(alias)', NULL),
(261, 'fa', 'fa-h-square', NULL),
(262, 'fa', 'fa-hacker-news', NULL),
(263, 'fa', 'fa-hand-o-down', NULL),
(264, 'fa', 'fa-hand-o-left', NULL),
(265, 'fa', 'fa-hand-o-right', NULL),
(266, 'fa', 'fa-hand-o-up', NULL),
(267, 'fa', 'fa-hdd-o', NULL),
(268, 'fa', 'fa-header', NULL),
(269, 'fa', 'fa-headphones', NULL),
(270, 'fa', 'fa-heart', NULL),
(271, 'fa', 'fa-heart-o', NULL),
(272, 'fa', 'fa-heartbeat', NULL),
(273, 'fa', 'fa-history', NULL),
(274, 'fa', 'fa-home', NULL),
(275, 'fa', 'fa-hospital-o', NULL),
(276, 'fa', 'fa-hotel(alias)', NULL),
(277, 'fa', 'fa-html5', NULL),
(278, 'fa', 'fa-ils', NULL),
(279, 'fa', 'fa-image(alias)', NULL),
(280, 'fa', 'fa-inbox', NULL),
(281, 'fa', 'fa-indent', NULL),
(282, 'fa', 'fa-info', NULL),
(283, 'fa', 'fa-info-circle', NULL),
(284, 'fa', 'fa-inr', NULL),
(285, 'fa', 'fa-instagram', NULL),
(286, 'fa', 'fa-institution(alias)', NULL),
(287, 'fa', 'fa-ioxhost', NULL),
(288, 'fa', 'fa-italic', NULL),
(289, 'fa', 'fa-joomla', NULL),
(290, 'fa', 'fa-jpy', NULL),
(291, 'fa', 'fa-jsfiddle', NULL),
(292, 'fa', 'fa-key', NULL),
(293, 'fa', 'fa-keyboard-o', NULL),
(294, 'fa', 'fa-krw', NULL),
(295, 'fa', 'fa-language', NULL),
(296, 'fa', 'fa-laptop', NULL),
(297, 'fa', 'fa-lastfm', NULL),
(298, 'fa', 'fa-lastfm-square', NULL),
(299, 'fa', 'fa-leaf', NULL),
(300, 'fa', 'fa-leanpub', NULL),
(301, 'fa', 'fa-legal(alias)', NULL),
(302, 'fa', 'fa-lemon-o', NULL),
(303, 'fa', 'fa-level-down', NULL),
(304, 'fa', 'fa-level-up', NULL),
(305, 'fa', 'fa-life-bouy(alias)', NULL),
(306, 'fa', 'fa-life-buoy(alias)', NULL),
(307, 'fa', 'fa-life-ring', NULL),
(308, 'fa', 'fa-life-saver(alias)', NULL),
(309, 'fa', 'fa-lightbulb-o', NULL),
(310, 'fa', 'fa-line-chart', NULL),
(311, 'fa', 'fa-link', NULL),
(312, 'fa', 'fa-linkedin', NULL),
(313, 'fa', 'fa-linkedin-square', NULL),
(314, 'fa', 'fa-linux', NULL),
(315, 'fa', 'fa-list', NULL),
(316, 'fa', 'fa-list-alt', NULL),
(317, 'fa', 'fa-list-ol', NULL),
(318, 'fa', 'fa-list-ul', NULL),
(319, 'fa', 'fa-location-arrow', NULL),
(320, 'fa', 'fa-lock', NULL),
(321, 'fa', 'fa-long-arrow-down', NULL),
(322, 'fa', 'fa-long-arrow-left', NULL),
(323, 'fa', 'fa-long-arrow-right', NULL),
(324, 'fa', 'fa-long-arrow-up', NULL),
(325, 'fa', 'fa-magic', NULL),
(326, 'fa', 'fa-magnet', NULL),
(327, 'fa', 'fa-mail-forward(alias)', NULL),
(328, 'fa', 'fa-mail-reply(alias)', NULL),
(329, 'fa', 'fa-mail-reply-all(alias)', NULL),
(330, 'fa', 'fa-male', NULL),
(331, 'fa', 'fa-map-marker', NULL),
(332, 'fa', 'fa-mars', NULL),
(333, 'fa', 'fa-mars-double', NULL),
(334, 'fa', 'fa-mars-stroke', NULL),
(335, 'fa', 'fa-mars-stroke-h', NULL),
(336, 'fa', 'fa-mars-stroke-v', NULL),
(337, 'fa', 'fa-maxcdn', NULL),
(338, 'fa', 'fa-meanpath', NULL),
(339, 'fa', 'fa-medium', NULL),
(340, 'fa', 'fa-medkit', NULL),
(341, 'fa', 'fa-meh-o', NULL),
(342, 'fa', 'fa-mercury', NULL),
(343, 'fa', 'fa-microphone', NULL),
(344, 'fa', 'fa-microphone-slash', NULL),
(345, 'fa', 'fa-minus', NULL),
(346, 'fa', 'fa-minus-circle', NULL),
(347, 'fa', 'fa-minus-square', NULL),
(348, 'fa', 'fa-minus-square-o', NULL),
(349, 'fa', 'fa-mobile', NULL),
(350, 'fa', 'fa-mobile-phone(alias)', NULL),
(351, 'fa', 'fa-money', NULL),
(352, 'fa', 'fa-moon-o', NULL),
(353, 'fa', 'fa-mortar-board(alias)', NULL),
(354, 'fa', 'fa-motorcycle', NULL),
(355, 'fa', 'fa-music', NULL),
(356, 'fa', 'fa-navicon(alias)', NULL),
(357, 'fa', 'fa-neuter', NULL),
(358, 'fa', 'fa-newspaper-o', NULL),
(359, 'fa', 'fa-openid', NULL),
(360, 'fa', 'fa-outdent', NULL),
(361, 'fa', 'fa-pagelines', NULL),
(362, 'fa', 'fa-paint-brush', NULL),
(363, 'fa', 'fa-paper-plane', NULL),
(364, 'fa', 'fa-paper-plane-o', NULL),
(365, 'fa', 'fa-paperclip', NULL),
(366, 'fa', 'fa-paragraph', NULL),
(367, 'fa', 'fa-paste(alias)', NULL),
(368, 'fa', 'fa-pause', NULL),
(369, 'fa', 'fa-paw', NULL),
(370, 'fa', 'fa-paypal', NULL),
(371, 'fa', 'fa-pencil', NULL),
(372, 'fa', 'fa-pencil-square', NULL),
(373, 'fa', 'fa-pencil-square-o', NULL),
(374, 'fa', 'fa-phone', NULL),
(375, 'fa', 'fa-phone-square', NULL),
(376, 'fa', 'fa-photo(alias)', NULL),
(377, 'fa', 'fa-picture-o', NULL),
(378, 'fa', 'fa-pie-chart', NULL),
(379, 'fa', 'fa-pied-piper', NULL),
(380, 'fa', 'fa-pied-piper-alt', NULL),
(381, 'fa', 'fa-pinterest', NULL),
(382, 'fa', 'fa-pinterest-p', NULL),
(383, 'fa', 'fa-pinterest-square', NULL),
(384, 'fa', 'fa-plane', NULL),
(385, 'fa', 'fa-play', NULL),
(386, 'fa', 'fa-play-circle', NULL),
(387, 'fa', 'fa-play-circle-o', NULL),
(388, 'fa', 'fa-plug', NULL),
(389, 'fa', 'fa-plus', NULL),
(390, 'fa', 'fa-plus-circle', NULL),
(391, 'fa', 'fa-plus-square', NULL),
(392, 'fa', 'fa-plus-square-o', NULL),
(393, 'fa', 'fa-power-off', NULL),
(394, 'fa', 'fa-print', NULL),
(395, 'fa', 'fa-puzzle-piece', NULL),
(396, 'fa', 'fa-qq', NULL),
(397, 'fa', 'fa-qrcode', NULL),
(398, 'fa', 'fa-question', NULL),
(399, 'fa', 'fa-question-circle', NULL),
(400, 'fa', 'fa-quote-left', NULL),
(401, 'fa', 'fa-quote-right', NULL),
(402, 'fa', 'fa-ra(alias)', NULL),
(403, 'fa', 'fa-random', NULL),
(404, 'fa', 'fa-rebel', NULL),
(405, 'fa', 'fa-recycle', NULL),
(406, 'fa', 'fa-reddit', NULL),
(407, 'fa', 'fa-reddit-square', NULL),
(408, 'fa', 'fa-refresh', NULL),
(409, 'fa', 'fa-remove(alias)', NULL),
(410, 'fa', 'fa-renren', NULL),
(411, 'fa', 'fa-reorder(alias)', NULL),
(412, 'fa', 'fa-repeat', NULL),
(413, 'fa', 'fa-reply', NULL),
(414, 'fa', 'fa-reply-all', NULL),
(415, 'fa', 'fa-retweet', NULL),
(416, 'fa', 'fa-rmb(alias)', NULL),
(417, 'fa', 'fa-road', NULL),
(418, 'fa', 'fa-rocket', NULL),
(419, 'fa', 'fa-rotate-left(alias)', NULL),
(420, 'fa', 'fa-rotate-right(alias)', NULL),
(421, 'fa', 'fa-rouble(alias)', NULL),
(422, 'fa', 'fa-rss', NULL),
(423, 'fa', 'fa-rss-square', NULL),
(424, 'fa', 'fa-rub', NULL),
(425, 'fa', 'fa-ruble(alias)', NULL),
(426, 'fa', 'fa-rupee(alias)', NULL),
(427, 'fa', 'fa-save(alias)', NULL),
(428, 'fa', 'fa-scissors', NULL),
(429, 'fa', 'fa-search', NULL),
(430, 'fa', 'fa-search-minus', NULL),
(431, 'fa', 'fa-search-plus', NULL),
(432, 'fa', 'fa-sellsy', NULL),
(433, 'fa', 'fa-send(alias)', NULL),
(434, 'fa', 'fa-send-o(alias)', NULL),
(435, 'fa', 'fa-server', NULL),
(436, 'fa', 'fa-share', NULL),
(437, 'fa', 'fa-share-alt', NULL),
(438, 'fa', 'fa-share-alt-square', NULL),
(439, 'fa', 'fa-share-square', NULL),
(440, 'fa', 'fa-share-square-o', NULL),
(441, 'fa', 'fa-shekel(alias)', NULL),
(442, 'fa', 'fa-sheqel(alias)', NULL),
(443, 'fa', 'fa-shield', NULL),
(444, 'fa', 'fa-ship', NULL),
(445, 'fa', 'fa-shirtsinbulk', NULL),
(446, 'fa', 'fa-shopping-cart', NULL),
(447, 'fa', 'fa-sign-in', NULL),
(448, 'fa', 'fa-sign-out', NULL),
(449, 'fa', 'fa-signal', NULL),
(450, 'fa', 'fa-simplybuilt', NULL),
(451, 'fa', 'fa-sitemap', NULL),
(452, 'fa', 'fa-skyatlas', NULL),
(453, 'fa', 'fa-skype', NULL),
(454, 'fa', 'fa-slack', NULL),
(455, 'fa', 'fa-sliders', NULL),
(456, 'fa', 'fa-slideshare', NULL),
(457, 'fa', 'fa-smile-o', NULL),
(458, 'fa', 'fa-soccer-ball-o(alias)', NULL),
(459, 'fa', 'fa-sort', NULL),
(460, 'fa', 'fa-sort-alpha-asc', NULL),
(461, 'fa', 'fa-sort-alpha-desc', NULL),
(462, 'fa', 'fa-sort-amount-asc', NULL),
(463, 'fa', 'fa-sort-amount-desc', NULL),
(464, 'fa', 'fa-sort-asc', NULL),
(465, 'fa', 'fa-sort-desc', NULL),
(466, 'fa', 'fa-sort-down(alias)', NULL),
(467, 'fa', 'fa-sort-numeric-asc', NULL),
(468, 'fa', 'fa-sort-numeric-desc', NULL),
(469, 'fa', 'fa-sort-up(alias)', NULL),
(470, 'fa', 'fa-soundcloud', NULL),
(471, 'fa', 'fa-space-shuttle', NULL),
(472, 'fa', 'fa-spinner', NULL),
(473, 'fa', 'fa-spoon', NULL),
(474, 'fa', 'fa-spotify', NULL),
(475, 'fa', 'fa-square', NULL),
(476, 'fa', 'fa-square-o', NULL),
(477, 'fa', 'fa-stack-exchange', NULL),
(478, 'fa', 'fa-stack-overflow', NULL),
(479, 'fa', 'fa-star', NULL),
(480, 'fa', 'fa-star-half', NULL),
(481, 'fa', 'fa-star-half-empty(alias)', NULL),
(482, 'fa', 'fa-star-half-full(alias)', NULL),
(483, 'fa', 'fa-star-half-o', NULL),
(484, 'fa', 'fa-star-o', NULL),
(485, 'fa', 'fa-steam', NULL),
(486, 'fa', 'fa-steam-square', NULL),
(487, 'fa', 'fa-step-backward', NULL),
(488, 'fa', 'fa-step-forward', NULL),
(489, 'fa', 'fa-stethoscope', NULL),
(490, 'fa', 'fa-stop', NULL),
(491, 'fa', 'fa-street-view', NULL),
(492, 'fa', 'fa-strikethrough', NULL),
(493, 'fa', 'fa-stumbleupon', NULL),
(494, 'fa', 'fa-stumbleupon-circle', NULL),
(495, 'fa', 'fa-subscript', NULL),
(496, 'fa', 'fa-subway', NULL),
(497, 'fa', 'fa-suitcase', NULL),
(498, 'fa', 'fa-sun-o', NULL),
(499, 'fa', 'fa-superscript', NULL),
(500, 'fa', 'fa-support(alias)', NULL),
(501, 'fa', 'fa-table', NULL),
(502, 'fa', 'fa-tablet', NULL),
(503, 'fa', 'fa-tachometer', NULL),
(504, 'fa', 'fa-tag', NULL),
(505, 'fa', 'fa-tags', NULL),
(506, 'fa', 'fa-tasks', NULL),
(507, 'fa', 'fa-taxi', NULL),
(508, 'fa', 'fa-tencent-weibo', NULL),
(509, 'fa', 'fa-terminal', NULL),
(510, 'fa', 'fa-text-height', NULL),
(511, 'fa', 'fa-text-width', NULL),
(512, 'fa', 'fa-th', NULL),
(513, 'fa', 'fa-th-large', NULL),
(514, 'fa', 'fa-th-list', NULL),
(515, 'fa', 'fa-thumb-tack', NULL),
(516, 'fa', 'fa-thumbs-down', NULL),
(517, 'fa', 'fa-thumbs-o-down', NULL),
(518, 'fa', 'fa-thumbs-o-up', NULL),
(519, 'fa', 'fa-thumbs-up', NULL),
(520, 'fa', 'fa-ticket', NULL),
(521, 'fa', 'fa-times', NULL),
(522, 'fa', 'fa-times-circle', NULL),
(523, 'fa', 'fa-times-circle-o', NULL),
(524, 'fa', 'fa-tint', NULL),
(525, 'fa', 'fa-toggle-down(alias)', NULL),
(526, 'fa', 'fa-toggle-left(alias)', NULL),
(527, 'fa', 'fa-toggle-off', NULL),
(528, 'fa', 'fa-toggle-on', NULL),
(529, 'fa', 'fa-toggle-right(alias)', NULL),
(530, 'fa', 'fa-toggle-up(alias)', NULL),
(531, 'fa', 'fa-train', NULL),
(532, 'fa', 'fa-transgender', NULL),
(533, 'fa', 'fa-transgender-alt', NULL),
(534, 'fa', 'fa-trash', NULL),
(535, 'fa', 'fa-trash-o', NULL),
(536, 'fa', 'fa-tree', NULL),
(537, 'fa', 'fa-trello', NULL),
(538, 'fa', 'fa-trophy', NULL),
(539, 'fa', 'fa-truck', NULL),
(540, 'fa', 'fa-try', NULL),
(541, 'fa', 'fa-tty', NULL),
(542, 'fa', 'fa-tumblr', NULL),
(543, 'fa', 'fa-tumblr-square', NULL),
(544, 'fa', 'fa-turkish-lira(alias)', NULL),
(545, 'fa', 'fa-twitch', NULL),
(546, 'fa', 'fa-twitter', NULL),
(547, 'fa', 'fa-twitter-square', NULL),
(548, 'fa', 'fa-umbrella', NULL),
(549, 'fa', 'fa-underline', NULL),
(550, 'fa', 'fa-undo', NULL),
(551, 'fa', 'fa-university', NULL),
(552, 'fa', 'fa-unlink(alias)', NULL),
(553, 'fa', 'fa-unlock', NULL),
(554, 'fa', 'fa-unlock-alt', NULL),
(555, 'fa', 'fa-unsorted(alias)', NULL),
(556, 'fa', 'fa-upload', NULL),
(557, 'fa', 'fa-usd', NULL),
(558, 'fa', 'fa-user', NULL),
(559, 'fa', 'fa-user-md', NULL),
(560, 'fa', 'fa-user-plus', NULL),
(561, 'fa', 'fa-user-secret', NULL),
(562, 'fa', 'fa-user-times', NULL),
(563, 'fa', 'fa-users', NULL),
(564, 'fa', 'fa-venus', NULL),
(565, 'fa', 'fa-venus-double', NULL),
(566, 'fa', 'fa-venus-mars', NULL),
(567, 'fa', 'fa-viacoin', NULL),
(568, 'fa', 'fa-video-camera', NULL),
(569, 'fa', 'fa-vimeo-square', NULL),
(570, 'fa', 'fa-vine', NULL),
(571, 'fa', 'fa-vk', NULL),
(572, 'fa', 'fa-volume-down', NULL),
(573, 'fa', 'fa-volume-off', NULL),
(574, 'fa', 'fa-volume-up', NULL),
(575, 'fa', 'fa-warning(alias)', NULL),
(576, 'fa', 'fa-wechat(alias)', NULL),
(577, 'fa', 'fa-weibo', NULL),
(578, 'fa', 'fa-weixin', NULL),
(579, 'fa', 'fa-whatsapp', NULL),
(580, 'fa', 'fa-wheelchair', NULL),
(581, 'fa', 'fa-wifi', NULL),
(582, 'fa', 'fa-windows', NULL),
(583, 'fa', 'fa-won(alias)', NULL),
(584, 'fa', 'fa-wordpress', NULL),
(585, 'fa', 'fa-wrench', NULL),
(586, 'fa', 'fa-xing', NULL),
(587, 'fa', 'fa-xing-square', NULL),
(588, 'fa', 'fa-yahoo', NULL),
(589, 'fa', 'fa-yelp', NULL),
(590, 'fa', 'fa-yen(alias)', NULL),
(591, 'fa', 'fa-youtube', NULL),
(592, 'fa', 'fa-youtube-play', NULL),
(593, 'fa', 'fa-youtube-square', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grn`
--

CREATE TABLE IF NOT EXISTS `grn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_note_id` int(1) NOT NULL,
  `from_location_id` int(1) NOT NULL,
  `to_location_id` int(1) NOT NULL,
  `user_id` int(1) NOT NULL,
  `grn_no` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `grn`
--

INSERT INTO `grn` (`id`, `issue_note_id`, `from_location_id`, `to_location_id`, `user_id`, `grn_no`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 8, 7, 'GRN_1_7_8', 0, '2017-08-03 06:55:46', '2017-08-03 12:25:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grn_details`
--

CREATE TABLE IF NOT EXISTS `grn_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(1) NOT NULL,
  `grn_id` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `grn_details`
--

INSERT INTO `grn_details` (`id`, `asset_id`, `grn_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2017-08-03 06:55:46', '2017-08-03 12:25:46', NULL),
(2, 2, 1, '2017-08-03 06:55:46', '2017-08-03 12:25:46', NULL),
(3, 3, 1, '2017-08-03 06:55:46', '2017-08-03 12:25:46', NULL),
(4, 4, 1, '2017-08-03 06:55:46', '2017-08-03 12:25:46', NULL),
(5, 5, 1, '2017-08-03 06:55:46', '2017-08-03 12:25:46', NULL),
(6, 6, 1, '2017-08-03 06:55:46', '2017-08-03 12:25:46', NULL),
(7, 7, 1, '2017-08-03 06:55:46', '2017-08-03 12:25:46', NULL),
(8, 8, 1, '2017-08-03 06:55:46', '2017-08-03 12:25:46', NULL),
(9, 9, 1, '2017-08-03 06:55:46', '2017-08-03 12:25:46', NULL),
(10, 10, 1, '2017-08-03 06:55:46', '2017-08-03 12:25:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `issue_notes`
--

CREATE TABLE IF NOT EXISTS `issue_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_location_id` int(1) NOT NULL,
  `to_location_id` int(1) NOT NULL,
  `user_id` int(1) NOT NULL,
  `issue_note_no` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `issue_notes`
--

INSERT INTO `issue_notes` (`id`, `from_location_id`, `to_location_id`, `user_id`, `issue_note_no`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 8, 2, 'ISN1_2_8', 0, '2017-08-03 06:54:28', '2017-08-03 12:24:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `issue_note_details`
--

CREATE TABLE IF NOT EXISTS `issue_note_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(1) NOT NULL,
  `issue_note_id` int(1) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `issue_note_details`
--

INSERT INTO `issue_note_details` (`id`, `asset_id`, `issue_note_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, '2017-08-03 06:54:28', '2017-08-03 12:25:46', NULL),
(2, 2, 1, 1, '2017-08-03 06:54:29', '2017-08-03 12:25:46', NULL),
(3, 3, 1, 1, '2017-08-03 06:54:29', '2017-08-03 12:25:46', NULL),
(4, 4, 1, 1, '2017-08-03 06:54:29', '2017-08-03 12:25:47', NULL),
(5, 5, 1, 1, '2017-08-03 06:54:29', '2017-08-03 12:25:47', NULL),
(6, 6, 1, 1, '2017-08-03 06:54:29', '2017-08-03 12:25:47', NULL),
(7, 7, 1, 1, '2017-08-03 06:54:29', '2017-08-03 12:25:47', NULL),
(8, 8, 1, 1, '2017-08-03 06:54:29', '2017-08-03 12:25:47', NULL),
(9, 9, 1, 1, '2017-08-03 06:54:29', '2017-08-03 12:25:47', NULL),
(10, 10, 1, 1, '2017-08-03 06:54:29', '2017-08-03 12:25:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `type` int(11) NOT NULL,
  `code` text,
  `address` text,
  `email` text,
  `contact` varchar(15) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `depth` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `name`, `type`, `code`, `address`, `email`, `contact`, `parent`, `lft`, `rgt`, `depth`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Head Office', 1, '10', 'No 933, Wedamulla, kelaniya', '', '0112035454', NULL, 1, 86, 0, 1, '2017-07-18 07:47:36', '2017-08-01 03:00:19', NULL),
(2, 'North Western Regional Office', 6, '7900', 'No. 155, Negambo Rd, Kurunegala\r\n', '', '0372231880', 1, 84, 85, 1, 0, '2017-07-31 19:15:39', '2017-08-01 03:00:19', NULL),
(3, 'Central Regional Office', 6, '4900', 'No. 15\r\nDharmashoka Mw\r\nKandy', '', '0812214115', 1, 78, 83, 1, 1, '2017-07-31 19:16:44', '2017-08-01 03:00:19', NULL),
(4, 'Western Provincial Office', 6, '1900', 'No. 36,\r\nMiriswaththa\r\nGampaha', '', '0332248731', 1, 64, 75, 1, 1, '2017-07-31 19:17:46', '2017-07-31 19:27:48', NULL),
(5, 'Kandy District Office', 7, '4990', 'Kandy', '', '0812214115', 3, 79, 82, 2, 1, '2017-07-31 19:22:35', '2017-08-01 03:00:19', NULL),
(6, 'Kalutara District Office', 7, '1990', 'No.48\r\nPadukkaRd\r\nHorana', 'dokalutara@rdb.lk', '0342264276', 4, 69, 74, 2, 1, '2017-07-31 19:24:33', '2017-07-31 19:27:48', NULL),
(7, 'Gampaha District Office', 7, '1980', 'No: 36\r\nMiriswattha\r\nGampaha.', 'dogampaha@rdb.lk', '0332222343', 4, 65, 68, 2, 1, '2017-07-31 19:25:29', '2017-07-31 19:27:48', NULL),
(8, 'Millaniya', 8, '1040', 'MoronthuduwaRoad\r\nMillaniya.', 'millaniya@rdb.lk', '0342252351', 6, 72, 73, 3, 1, '2017-07-31 19:26:13', '2017-07-31 19:27:48', NULL),
(9, 'Bulathsinhala', 8, '1010', 'No.153\r\nMainStreet\r\nBulathsinhala.', 'dobulathsinhala@rdb.lk', '0342283166', 6, 70, 71, 3, 1, '2017-07-31 19:27:03', '2017-07-31 19:27:48', NULL),
(10, 'Mawaramandiya', 8, '1170', 'No : 454/2/C\r\nMawaramandiya\r\nSiyambalpe.', 'mawaramandiya@rdb.lk', '0112977316', 7, 66, 67, 3, 1, '2017-07-31 19:27:48', '2017-07-31 19:27:48', NULL),
(11, 'Kandy', 8, '4320', 'No.14\r\n16\r\nColomboStreet\r\nKandy\r\n', 'kandy@rdb.lk', '0812201114', 5, 80, 81, 3, 1, '2017-07-31 19:28:39', '2017-08-01 03:00:19', NULL),
(12, 'North Central Regional Office', 6, '8900', 'No.65 D, 4 Lane\r\nAbaya Place\r\nAnuradhapura', '', '0252223080', 1, 76, 77, 1, 1, '2017-08-01 03:00:19', '2017-08-01 03:00:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `location_type`
--

CREATE TABLE IF NOT EXISTS `location_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `location_type`
--

INSERT INTO `location_type` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Head Office', 1, '2017-06-12 13:13:14', NULL, NULL),
(6, 'Regional Office', 1, '2017-07-21 16:20:33', '2017-07-21 16:20:33', NULL),
(7, 'District Office', 1, '2017-07-21 16:20:47', '2017-07-21 16:20:47', NULL),
(8, 'Branch', 1, '2017-07-21 16:21:00', '2017-07-21 16:21:00', NULL),
(9, 'Department', 1, '2017-07-21 06:27:49', '2017-07-21 16:57:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE IF NOT EXISTS `manufacturers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `user_id` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`id`, `name`, `status`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'HP', 1, 2, '2017-07-31 20:45:32', '2017-07-31 20:45:32', NULL),
(2, 'Acer', 1, 2, '2017-07-31 20:45:32', '2017-07-31 20:45:32', NULL),
(3, 'Centerm', 1, 2, '2017-07-31 10:19:42', '2017-07-31 20:49:42', NULL),
(4, 'DCP', 1, 5, '2017-08-01 11:08:11', '2017-08-01 11:08:11', NULL),
(5, 'DELL', 1, 1, '2017-08-03 06:08:23', '2017-08-03 06:08:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `lft` int(11) NOT NULL,
  `rgt` int(11) DEFAULT NULL,
  `depth` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=122 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `label`, `link`, `icon`, `parent`, `permissions`, `lft`, `rgt`, `depth`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Root Menu', '', NULL, NULL, NULL, 1, 152, 0, 1, '2015-10-15 11:30:50', '2017-05-14 09:08:32'),
(3, 'Menu Management', '#', 'fa fa-bars', 1, '["menu.add","menu.list","menu.edit","menu.status","menu.delete","admin"]', 32, 37, 1, 1, '2015-10-15 11:47:17', '2017-05-11 14:43:01'),
(4, 'Add Menu', 'menu/add', '', 3, '["menu.add","admin"]', 33, 34, 2, 1, '2015-10-15 11:48:19', '2017-05-11 14:43:01'),
(5, 'Menu List', 'menu/list', '', 3, '["menu.list","menu.edit","menu.status","menu.delete","admin"]', 35, 36, 2, 1, '2015-10-15 11:48:46', '2017-05-11 14:43:01'),
(6, 'User Management', '#', 'fa fa-users', 1, '["user.add","user.edit","user.delete","user.list","user.role.add","user.role.edit","user.role.list","user.role.delete","permission.add","permission.edit","permission.delete","permission.list","permission.group.add","permission.group.edit","permission.group.list","permission.group.delete","user.status","admin"]', 18, 31, 1, 1, '2015-10-15 17:16:32', '2017-05-11 14:43:01'),
(7, 'Permissions', '#', 'fa fa-angle-double-right', 116, '["permission.add","permission.edit","permission.delete","permission.list","permission.group.add","permission.group.edit","permission.group.list","permission.group.delete","admin"]', 39, 42, 2, 1, '2015-10-15 17:17:46', '2017-05-11 15:36:43'),
(9, 'Permissions List', 'permission/list', '', 7, '["permission.edit","permission.delete","permission.list","admin"]', 40, 41, 3, 1, '2015-10-15 17:43:36', '2017-05-11 15:36:43'),
(10, 'User Roles', '#', '', 6, '["user.role.add","user.role.edit","user.role.list","user.role.delete","admin"]', 19, 24, 2, 1, '2015-10-15 17:44:21', '2017-05-11 14:43:01'),
(11, 'Add Role', 'user/role/add', '', 10, '["user.role.add","admin"]', 20, 21, 3, 1, '2015-10-15 17:45:20', '2017-05-11 14:43:01'),
(12, 'Users', '#', '', 6, '["user.add","user.edit","user.delete","user.list","admin"]', 25, 30, 2, 1, '2015-10-15 17:48:40', '2017-05-11 14:43:01'),
(13, 'Add User', 'user/add', '', 12, '["user.add","admin"]', 26, 27, 3, 1, '2015-10-15 17:49:46', '2017-05-11 14:43:01'),
(14, 'User List', 'user/list', '', 12, '["user.edit","user.delete","user.list","admin"]', 28, 29, 3, 1, '2015-10-15 17:50:48', '2017-05-11 14:43:01'),
(15, 'Permission Groups', '#', 'fa fa-angle-double-right', 116, '["permission.group.add","permission.group.edit","permission.group.list","permission.group.delete","permission.groups.add","permission.groups.list","admin"]', 43, 48, 2, 1, '2015-10-16 13:01:10', '2017-05-11 15:36:43'),
(16, 'Roles List', 'user/role/list', '', 10, '["user.role.edit","user.role.list","user.role.delete","admin"]', 22, 23, 3, 1, '2015-10-16 13:13:52', '2017-05-11 14:43:01'),
(55, 'Dashboard', '', 'fa fa-tachometer', 1, '["index","admin"]', 2, 3, 1, 1, '2015-12-18 03:45:46', '2015-12-18 03:46:02'),
(60, 'Manufacturers', '#', 'fa fa-bank', 68, '["manufacturer.add","manufacturer.list","manufacturer.status","manufacturer.edit","manufacturer.delete","admin"]', 77, 84, 2, 1, '2016-03-18 10:19:49', '2017-05-11 15:36:43'),
(61, 'Add Manufacturer', 'manufacturer/add', '', 60, '["manufacturer.add","admin"]', 78, 79, 3, 1, '2016-03-18 10:21:18', '2017-05-11 15:36:43'),
(62, 'Manufacturer List', 'manufacturer/list', '', 60, '["manufacturer.list","manufacturer.status","manufacturer.delete","admin"]', 80, 81, 3, 1, '2016-03-18 10:22:26', '2017-05-11 15:36:43'),
(63, 'Service Management', '#', 'fa fa-cogs', 1, '["service_type.add","service_type.edit","service_type.list","service_type.delete","service.add","service.edit","service.list","service.delete","admin"]', 50, 63, 1, 1, '2016-03-19 04:24:21', '2017-05-11 15:36:43'),
(64, 'Service Type', '#', '', 63, '["service_type.add","service_type.edit","service_type.list","service_type.delete","admin"]', 51, 56, 2, 1, '2016-03-19 04:26:33', '2017-05-11 15:36:43'),
(65, 'Add Type', 'service/type/add', '', 64, '["service_type.add","admin"]', 52, 53, 3, 1, '2016-03-19 04:27:25', '2017-05-11 15:36:43'),
(67, 'Type List', 'service/type/list', '', 64, '["service_type.list","service_type.delete","admin"]', 54, 55, 3, 1, '2016-03-19 04:28:49', '2017-05-11 15:36:43'),
(68, 'Master Data', '#', 'fa fa-archive', 1, '["manufacturer.add","manufacturer.list","manufacturer.status","manufacturer.edit","manufacturer.delete","supplier.add","supplier.edit","supplier.delete","supplier.list","asset-modal.add","asset-modal.edit","asset-modal.list","Location.add","Location.edit","Location.get-location","Location.get-ground-location","Location.list","Location.main-location","Location.location-hierachy","manufacturer.trash","admin"]', 64, 103, 1, 1, '2016-03-19 05:12:09', '2017-05-11 15:36:43'),
(69, 'Location', '#', 'fa fa-arrows', 68, '["location.add","location.edit","location.get-location","location.get-ground-location","location.list","location.main-location","location.location-hierachy","admin"]', 85, 96, 2, 1, '2016-03-19 05:13:44', '2017-05-11 15:36:43'),
(70, 'Add', 'location/add', '', 69, '["location.add","location.get-location","location.get-ground-location","location.main-location","location.location-hierachy","admin"]', 86, 87, 3, 1, '2016-03-19 05:15:24', '2017-05-11 15:36:43'),
(71, 'List', 'location/list', '', 69, '["location.edit","location.list","admin"]', 88, 89, 3, 1, '2016-03-19 05:17:12', '2017-05-11 15:36:43'),
(72, 'Asset Model', '#', 'fa fa-database', 68, '["asset-modal.add","asset-modal.edit","asset-modal.list","admin"]', 97, 102, 2, 1, '2016-03-19 05:52:46', '2017-05-11 15:36:43'),
(73, 'Add', 'asset-modal/add', '', 72, '["user","asset-modal.add","admin"]', 98, 99, 3, 1, '2016-03-19 05:54:30', '2017-05-11 15:36:43'),
(74, 'List', 'asset-modal/list', '', 72, '["asset-modal.edit","asset-modal.list","admin"]', 100, 101, 3, 1, '2016-03-19 05:57:42', '2017-05-11 15:36:43'),
(75, 'Category', '#', 'fa fa-anchor', 68, '["category.add ","category.edit","category.delete","category.list","admin"]', 65, 70, 2, 1, '2016-03-19 06:49:26', '2017-05-11 15:36:43'),
(76, 'Category Add', 'category/add', '', 75, '["category.add ","admin"]', 66, 67, 3, 1, '2016-03-19 06:50:30', '2017-05-11 15:36:43'),
(77, 'Category List', 'category/list', '', 75, '["category.delete","category.list","admin"]', 68, 69, 3, 1, '2016-03-19 06:50:55', '2017-05-11 15:36:43'),
(78, 'Supplier ', '#', 'fa fa-ambulance', 68, '["supplier.add","supplier.edit","supplier.delete","supplier.list","admin"]', 71, 76, 2, 1, '2016-03-19 08:41:05', '2017-05-11 15:36:43'),
(79, 'Add Supplier', 'supplier/add', '', 78, '["supplier.add","admin"]', 72, 73, 3, 1, '2016-03-19 08:41:40', '2017-05-11 15:36:43'),
(80, 'Supplier List', 'supplier/list', '', 78, '["supplier.delete","supplier.list","admin"]', 74, 75, 3, 1, '2016-03-19 08:42:11', '2017-05-11 15:36:43'),
(81, 'Asset Management', '#', 'fa fa-barcode', 1, '["asset.add","asset.edit","asset.delete","asset.list","admin"]', 104, 113, 1, 1, '2016-03-19 09:11:21', '2017-05-14 09:08:32'),
(82, 'Add Asset', 'asset/add', '', 81, '["asset.add","admin"]', 105, 106, 2, 1, '2016-03-19 09:11:47', '2017-05-11 15:36:43'),
(83, 'Asset List', 'asset/list', '', 81, '["asset.delete","asset.list","admin"]', 107, 108, 2, 1, '2016-03-19 09:12:07', '2017-05-11 15:36:43'),
(84, 'Chek-In/Check-Out', '#', 'fa fa-check', 1, '["CheckInout.grn.list","CheckInout.grn.details","CheckInout.checkin","CheckInout.checkout","CheckInout.get-device","CheckInout.load-bucket-data","CheckInout.asset-list","CheckInout.checkit","CheckInout.get-pending-assets","admin"]', 114, 123, 1, 1, '2016-03-20 07:29:54', '2017-05-14 09:08:32'),
(85, 'Check-In', 'check-inout/checkin', '', 84, '["CheckInout.checkin","CheckInout.get-device","CheckInout.load-bucket-data","CheckInout.asset-list","CheckInout.get-pending-assets","admin"]', 115, 116, 2, 1, '2016-03-20 07:30:55', '2017-05-14 09:08:32'),
(86, 'Check-Out', 'check-inout/checkout', '', 84, '["CheckInout.checkout","CheckInout.get-device","CheckInout.load-bucket-data","CheckInout.asset-list","CheckInout.get-pending-assets","admin"]', 117, 118, 2, 1, '2016-03-20 07:32:00', '2017-05-14 09:08:32'),
(87, 'Reports', '#', 'fa fa-area-chart', 1, '["report.depreciation","admin"]', 130, 135, 1, 1, '2016-03-20 07:46:30', '2017-05-14 09:08:32'),
(88, 'Depreciation', 'reports/depreciation/asset/list', '', 87, '["report.depreciation","admin"]', 131, 132, 2, 1, '2016-03-20 07:47:30', '2017-05-14 09:08:32'),
(89, 'Asset In Location', 'reports/asset_location', '', 87, '["report.location_asset","admin"]', 133, 134, 2, 1, '2016-03-20 13:45:38', '2017-05-14 09:08:32'),
(90, 'Services', '#', 'fa fa-asterisk', 63, '["service.add","service.edit","service.list","service.delete","admin"]', 57, 62, 2, 1, '2016-03-20 14:29:01', '2017-05-11 15:36:43'),
(91, 'Add Service', 'service/add', '', 90, '["service.add","admin"]', 58, 59, 3, 1, '2016-03-20 14:32:12', '2017-05-11 15:36:43'),
(92, 'Service List', 'service/list', '', 90, '["service.edit","service.delete","service.list","admin"]', 60, 61, 3, 1, '2016-03-20 15:37:23', '2017-05-11 15:36:43'),
(93, 'GRN List', 'check-inout/grn/list', '', 84, '["CheckInout.grn.list","CheckInout.grn.details","admin"]', 119, 120, 2, 1, '2017-03-26 01:46:16', '2017-05-14 09:08:32'),
(95, 'Barcode Management', '#', 'fa fa-barcode', 1, '["barcode.list.print","barcode.print","barcode.list","admin"]', 136, 141, 1, 1, '2017-03-26 01:50:37', '2017-05-14 09:08:32'),
(96, 'list', 'barcode/list', '', 95, '["barcode.list.print","barcode.print","barcode.list","admin"]', 137, 138, 2, 1, '2017-03-26 01:51:23', '2017-05-14 09:08:32'),
(97, 'Bulk Print', 'barcode/bulk/print', '', 95, '["barcode.bulk.print","admin"]', 139, 140, 2, 1, '2017-03-26 01:52:02', '2017-05-14 09:08:32'),
(98, 'Asset Upload', 'asset/upload', '', 81, '["asset.upload","admin"]', 109, 110, 2, 1, '2017-03-26 02:12:00', '2017-05-11 15:36:43'),
(99, 'Employee Management', '#', 'fa fa-user', 1, '["employee.type.add","employee.type.list","employee.type.edit","employee.type.delete","employee.type.status","employee.add","employee.list","employee.edit","employee.delete","employee.status","employee.reset.reset-password","admin"]', 4, 17, 1, 1, '2017-03-26 02:15:34', '2017-03-26 02:25:02'),
(100, 'Employee Type', '#', 'fa fa-angle-double-right', 99, '["employee.type.add","employee.type.list","employee.type.edit","employee.type.delete","employee.type.status","admin"]', 5, 10, 2, 1, '2017-03-26 02:16:53', '2017-03-26 02:19:27'),
(101, 'List', 'employee/type/list', '', 100, '["employee.type.list","employee.type.edit","employee.type.delete","employee.type.status","admin"]', 6, 7, 3, 1, '2017-03-26 02:18:26', '2017-03-26 02:18:42'),
(102, 'Add', 'employee/type/add', '', 100, '["employee.type.add","admin"]', 8, 9, 3, 1, '2017-03-26 02:19:27', '2017-03-26 02:19:27'),
(103, 'List Employee', 'employee/list', 'fa fa-angle-double-right', 99, '["employee.list","employee.edit","employee.delete","employee.status","admin"]', 11, 12, 2, 1, '2017-03-26 02:20:26', '2017-03-26 02:20:26'),
(104, 'Add Employee', 'employee/add', 'fa fa-angle-double-right', 99, '["employee.add","admin"]', 13, 14, 2, 1, '2017-03-26 02:22:03', '2017-03-26 02:22:03'),
(105, 'Reset Authantication', 'employee/reset/reset-password', 'fa fa-user-secret', 99, '["employee.reset.reset-password","admin"]', 15, 16, 2, 1, '2017-03-26 02:25:02', '2017-03-26 02:25:03'),
(106, 'Audit Management', '#', 'fa fa-ambulance', 1, '["audit.asset.list","admin"]', 142, 145, 1, 1, '2017-03-26 06:33:32', '2017-05-14 09:08:32'),
(107, 'Asset in location', 'audit/asset/list', '', 106, '["audit.asset.list","admin"]', 143, 144, 2, 1, '2017-03-26 06:34:03', '2017-05-14 09:08:32'),
(108, 'Request Management', '#', 'fa fa-envelope', 1, '["request.add","request.edit","request.list","request.sent-to-service","admin"]', 124, 129, 1, 1, '2017-04-15 21:15:42', '2017-05-14 09:08:32'),
(109, 'Add', 'request/add', '', 108, '["request.add","admin"]', 125, 126, 2, 1, '2017-04-15 21:16:58', '2017-05-14 09:08:32'),
(110, 'List', 'request/list', '', 108, '["request.edit","request.list","request.sent-to-service","admin"]', 127, 128, 2, 1, '2017-04-15 21:19:57', '2017-05-14 09:08:32'),
(111, 'Location Type', '#', 'fa fa-angle-double-right', 69, '["location.type.add","location.type.list","location.type.edit","admin"]', 90, 95, 3, 1, '2017-04-22 08:24:24', '2017-05-11 15:36:43'),
(112, 'Add', 'location/type/add', '', 111, '["location.type.add","admin"]', 91, 92, 4, 1, '2017-04-22 08:30:40', '2017-05-11 15:36:43'),
(113, 'List', 'location/type/list', '', 111, '["location.type.add","location.type.list","location.type.edit","admin"]', 93, 94, 4, 1, '2017-04-22 08:34:14', '2017-05-11 15:36:43'),
(114, 'add group', 'permission/groups/add', '', 15, '["permission.groups.add","admin"]', 44, 45, 3, 1, '2017-04-29 23:39:20', '2017-05-11 15:36:43'),
(115, 'list groups', 'permission/groups/list', '', 15, '["permission.groups.list","admin"]', 46, 47, 3, 1, '2017-04-29 23:39:41', '2017-05-11 15:36:43'),
(116, 'Permission Management', '#', 'fa fa-align-center', 1, '["permission.add","permission.edit","permission.delete","permission.list","permission.group.add","permission.group.edit","permission.group.list","permission.group.delete","permission.groups.add","permission.groups.list","admin"]', 38, 49, 1, 1, '2017-05-11 14:42:35', '2017-05-11 15:36:43'),
(117, 'Software Assets ', '#', 'fa fa-adn', 1, '["license.add","license.list","license.assign","admin"]', 146, 151, 1, 1, '2017-05-11 16:59:35', '2017-05-14 09:08:32'),
(118, 'add license', 'software/license/add', '', 117, '["license.add","license.assign","admin"]', 147, 148, 2, 1, '2017-05-11 17:00:37', '2017-05-14 09:08:32'),
(119, 'list licenses', 'software/license/list', '', 117, '["license.list","license.assign","admin"]', 149, 150, 2, 1, '2017-05-11 17:01:15', '2017-05-14 09:08:32'),
(120, 'Issue Notes', 'check-inout/issuenote/list', '', 84, '["issuenote.list","admin"]', 121, 122, 2, 1, '2017-05-11 17:30:58', '2017-05-14 09:08:32'),
(121, 'Assign / Unassing', 'asset/user/assign', '', 81, '["asset.user.assign","asset.user.unAssign","","admin"]', 111, 112, 2, 1, '2017-05-14 09:08:32', '2017-05-14 09:08:32');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2012_12_06_225921_migration_cartalyst_sentry_install_users', 1),
('2012_12_06_225929_migration_cartalyst_sentry_install_groups', 1),
('2012_12_06_225945_migration_cartalyst_sentry_install_users_groups_pivot', 1),
('2012_12_06_225988_migration_cartalyst_sentry_install_throttle', 1),
('2015_05_16_172701_create_tables', 1),
('2015_05_16_180134_alter_users_table', 2),
('2015_05_25_211027_create_menu_table', 3),
('2015_05_26_103954_alter_menu_table', 4),
('2015_05_26_114356_alter_menu_table', 5),
('2014_07_02_230147_migration_cartalyst_sentinel', 6);

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE IF NOT EXISTS `models` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `end_of_life` int(11) DEFAULT '0',
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=183 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `description`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'user', 'Normal Registered User', 1, 1, '2015-07-24 06:00:00', '2017-05-28 18:18:59'),
(2, 'menu.add', NULL, 1, 1, '2015-07-24 06:00:00', '2015-12-02 13:02:41'),
(3, 'menu.list', NULL, 1, 1, '2015-07-24 06:00:00', '2015-12-01 09:54:54'),
(4, 'menu.edit', NULL, 1, 1, '2015-07-24 06:00:00', '2015-12-01 09:54:57'),
(5, 'menu.status', NULL, 1, 1, '2015-07-24 06:00:00', '2015-12-01 09:55:01'),
(6, 'admin', 'Super Admin Permission', 1, 1, '2015-07-24 06:00:00', '2015-07-24 06:00:00'),
(7, 'index', 'Home Page Permission', 1, 1, '2015-07-24 06:00:00', '2015-12-01 09:55:03'),
(8, 'menu.delete', NULL, 1, 1, '2015-09-05 20:30:06', '2015-09-05 20:30:09'),
(9, 'user.add', NULL, 1, 1, '2015-10-15 06:00:00', '2015-10-15 06:00:00'),
(10, 'user.edit', NULL, 1, 1, '2015-10-15 06:00:00', '2015-10-15 06:00:00'),
(11, 'user.delete', NULL, 1, 1, '2015-10-15 06:00:00', '2015-10-15 06:00:00'),
(12, 'user.list', NULL, 1, 1, '2015-10-19 06:00:00', '2015-10-20 02:01:57'),
(13, 'user.role.add', NULL, 1, 1, '2015-10-21 06:00:00', '2015-10-21 06:00:00'),
(14, 'user.role.edit', NULL, 1, 1, '2015-10-21 06:00:00', '2015-10-21 06:00:00'),
(15, 'user.role.list', NULL, 1, 1, '2015-10-21 06:00:00', '2015-10-21 06:00:00'),
(16, 'user.role.delete', NULL, 1, 1, '2015-10-21 06:00:00', '2015-10-21 06:00:00'),
(17, 'permission.add', NULL, 1, 1, '2015-10-21 06:00:00', '2015-10-21 06:00:00'),
(18, 'permission.edit', NULL, 1, 1, '2015-10-21 06:00:00', '2015-10-21 06:00:00'),
(19, 'permission.delete', NULL, 1, 1, '2015-10-21 06:00:00', '2015-10-21 06:00:00'),
(20, 'permission.list', NULL, 1, 1, '2015-10-21 06:00:00', '2017-05-28 18:20:32'),
(21, 'permission.group.add', NULL, 1, 1, '2015-10-21 06:00:00', '2015-10-21 06:00:00'),
(22, 'permission.group.edit', NULL, 1, 1, '2015-10-21 06:00:00', '2015-10-21 06:00:00'),
(23, 'permission.group.list', NULL, 1, 1, '2015-10-21 06:00:00', '2015-10-21 06:00:00'),
(24, 'permission.group.delete', NULL, 1, 1, '2015-10-21 06:00:00', '2015-10-21 06:00:00'),
(28, 'followup_type.add', NULL, 1, 1, '2015-11-17 18:30:00', '2015-11-17 18:30:00'),
(29, 'followup_type.edit', NULL, 1, 1, '2015-11-17 18:30:00', '2015-11-17 23:46:00'),
(30, 'followup_type.delete', NULL, 1, 1, '2015-11-17 18:30:00', '2015-11-17 23:46:00'),
(31, 'followup_type.list', NULL, 1, 1, '2015-11-17 18:30:00', '2015-11-17 23:46:00'),
(32, 'followup_reason.add', NULL, 1, 1, '2015-11-23 18:30:00', '2015-11-23 18:30:00'),
(33, 'followup_reason.edit', NULL, 1, 1, '2015-11-23 18:30:00', '2015-11-23 18:30:00'),
(34, 'followup_reason.delete', NULL, 1, 1, '2015-11-23 18:30:00', '2015-11-23 18:30:00'),
(35, 'followup_reason.list', NULL, 1, 1, '2015-11-23 18:30:00', '2015-11-23 18:30:00'),
(36, 'inquiry_stage.add', NULL, 1, 1, '2015-11-23 18:30:00', '2015-11-23 18:30:00'),
(37, 'inquiry_stage.edit', NULL, 1, 1, '2015-11-23 18:30:00', '2015-11-23 18:30:00'),
(38, 'inquiry_stage.delete', NULL, 1, 1, '2015-11-23 18:30:00', '2015-11-23 18:30:00'),
(39, 'inquiry_stage.list', NULL, 1, 1, '2015-11-23 18:30:00', '2015-11-23 18:30:00'),
(40, 'contact_type.add', NULL, 1, 1, '2015-11-23 18:30:00', '2015-11-23 18:30:00'),
(41, 'contact_type.edit', NULL, 1, 1, '2015-11-23 18:30:00', '2015-11-23 18:30:00'),
(42, 'contact_type.delete', NULL, 1, 1, '2015-11-23 18:30:00', '2015-11-23 18:30:00'),
(43, 'contact_type.list', NULL, 1, 1, '2015-11-23 18:30:00', '2015-11-23 18:30:00'),
(53, 'product.add', NULL, 1, 1, '2015-12-18 05:00:47', '2015-12-18 05:00:47'),
(54, 'product.edit', NULL, 1, 1, '2015-12-18 05:00:47', '2015-12-18 05:00:47'),
(55, 'product.list', NULL, 1, 1, '2015-12-18 05:00:47', '2015-12-18 05:00:47'),
(56, 'product.status', NULL, 1, 1, '2015-12-18 05:00:47', '2015-12-18 05:00:47'),
(57, 'product.delete', NULL, 1, 1, '2015-12-18 05:00:47', '2015-12-18 05:00:47'),
(58, 'customer.add', NULL, 1, 1, '2015-12-18 05:00:47', '2015-12-18 05:00:47'),
(59, 'customer.edit', NULL, 1, 1, '2015-12-18 05:00:47', '2015-12-18 05:00:47'),
(60, 'customer.list', NULL, 1, 1, '2015-12-18 05:00:47', '2015-12-18 05:00:47'),
(61, 'customer.delete', NULL, 1, 1, '2015-12-18 05:00:47', '2015-12-18 05:00:47'),
(62, 'user.status', NULL, 1, 1, '2015-12-18 05:00:47', '2015-12-18 05:00:47'),
(63, 'call_center.add', NULL, 1, 1, '2015-12-18 05:00:47', '2015-12-18 05:00:47'),
(64, 'call_center.list', NULL, 1, 1, '2015-12-18 05:00:47', '2015-12-18 05:00:47'),
(65, 'call_center.inquiry', NULL, 1, 1, '2015-12-18 05:00:47', '2015-12-18 05:00:47'),
(66, 'call_center.search', NULL, 1, 1, '2015-12-18 05:00:47', '2015-12-18 05:00:47'),
(67, 'call_center.profile', NULL, 1, 1, '2015-12-18 05:00:47', '2015-12-18 05:00:47'),
(68, 'manufacturer.add', NULL, 1, 1, '2016-03-18 15:48:46', '2016-03-18 15:48:46'),
(69, 'manufacturer.list', NULL, 1, 1, '2016-03-18 15:48:46', '2016-03-18 15:48:46'),
(70, 'manufacturer.status', NULL, 1, 1, '2016-03-18 15:48:46', '2016-03-18 15:48:46'),
(71, 'manufacturer.edit', NULL, 1, 1, '2016-03-18 15:48:46', '2016-03-18 15:48:46'),
(72, 'manufacturer.delete', NULL, 1, 1, '2016-03-18 15:48:46', '2016-03-18 15:48:46'),
(73, 'service_type.add', NULL, 1, 1, '2016-03-19 09:53:28', '2016-03-19 09:53:28'),
(74, 'service_type.edit', NULL, 1, 1, '2016-03-19 09:53:28', '2016-03-19 09:53:28'),
(75, 'service_type.list', NULL, 1, 1, '2016-03-19 09:53:28', '2016-03-19 09:53:28'),
(76, 'service_type.delete', NULL, 1, 1, '2016-03-19 09:53:28', '2016-03-19 09:53:28'),
(77, 'category.add ', NULL, 1, 1, '2016-03-19 12:18:44', '2016-03-19 12:18:44'),
(78, 'category.edit', NULL, 1, 1, '2016-03-19 12:18:44', '2016-03-19 12:18:44'),
(79, 'category.delete', NULL, 1, 1, '2016-03-19 12:18:44', '2016-03-19 12:18:44'),
(80, 'category.list', NULL, 1, 1, '2016-03-19 12:18:44', '2016-03-19 12:18:44'),
(81, 'supplier.add', NULL, 1, 1, '2016-03-19 14:10:33', '2016-03-19 14:10:33'),
(82, 'supplier.edit', NULL, 1, 1, '2016-03-19 14:10:33', '2016-03-19 14:10:33'),
(83, 'supplier.delete', NULL, 1, 1, '2016-03-19 14:10:33', '2016-03-19 14:10:33'),
(84, 'supplier.list', NULL, 1, 1, '2016-03-19 14:10:33', '2016-03-19 14:10:33'),
(85, 'asset.add', NULL, 1, 1, '2016-03-19 14:40:51', '2016-03-19 14:40:51'),
(86, 'asset.edit', NULL, 1, 1, '2016-03-19 14:40:51', '2016-03-19 14:40:51'),
(87, 'asset.delete', NULL, 1, 1, '2016-03-19 14:40:51', '2016-03-19 14:40:51'),
(88, 'asset.list', NULL, 1, 1, '2016-03-19 14:40:51', '2016-03-19 14:40:51'),
(89, 'report.view', NULL, 1, 1, '2016-03-20 13:16:12', '2016-03-20 13:16:12'),
(90, 'report.depreciation', NULL, 1, 1, '2016-03-20 13:17:09', '2016-03-20 13:17:09'),
(91, 'report.location_asset', NULL, 1, 1, '2016-03-20 19:14:39', '2016-03-20 19:14:39'),
(92, 'service.add', NULL, 1, 1, '2016-03-20 20:01:36', '2016-03-20 20:01:36'),
(93, 'service.edit', NULL, 1, 1, '2016-03-20 20:01:36', '2016-03-20 20:01:36'),
(94, 'service.delete', NULL, 1, 1, '2016-03-20 20:01:36', '2016-03-20 20:01:36'),
(95, 'service.list', NULL, 1, 1, '2016-03-20 20:01:36', '2016-03-20 20:01:36'),
(96, 'asset.barcode_genarate', NULL, 1, 1, '2016-03-20 20:46:52', '2016-03-20 20:46:52'),
(97, 'employee.type.add', NULL, 1, 1, '2017-03-26 07:05:34', NULL),
(98, 'employee.type.list', NULL, 1, 1, '2017-03-26 07:08:26', NULL),
(99, 'employee.type.edit', NULL, 1, 1, '2017-03-26 07:08:26', NULL),
(100, 'employee.type.delete', NULL, 1, 1, '2017-03-26 07:08:26', NULL),
(101, 'employee.type.status', NULL, 1, 1, '2017-03-26 07:08:26', NULL),
(102, 'employee.add', NULL, 1, 1, '2017-03-26 07:08:26', NULL),
(103, 'employee.list', NULL, 1, 1, '2017-03-26 07:08:26', NULL),
(104, 'employee.edit', NULL, 1, 1, '2017-03-26 07:08:26', NULL),
(105, 'employee.delete', NULL, 1, 1, '2017-03-26 07:08:26', NULL),
(106, 'employee.status', NULL, 1, 1, '2017-03-26 07:08:26', NULL),
(107, 'CheckInout.grn.list', NULL, 1, 1, '2017-03-26 07:15:33', '2017-03-26 07:15:33'),
(108, 'CheckInout.grn.details', NULL, 1, 1, '2017-03-26 07:15:33', '2017-03-26 07:15:33'),
(109, 'asset.view', NULL, 1, 1, '2017-03-26 07:15:34', NULL),
(110, 'asset.upload', NULL, 1, 1, '2017-03-26 07:16:11', NULL),
(111, 'asset.damage', NULL, 1, 1, '2017-03-26 07:16:37', NULL),
(112, 'config.barcode.type', NULL, 1, 1, '2017-03-26 07:18:05', '2017-03-26 07:18:05'),
(113, 'asset-modal.add', NULL, 1, 1, '2017-03-26 07:18:20', NULL),
(114, 'asset-modal.edit', NULL, 1, 1, '2017-03-26 07:18:38', NULL),
(115, 'asset-modal.list', NULL, 1, 1, '2017-03-26 07:18:50', NULL),
(117, 'barcode.list.print', NULL, 1, 1, '2017-03-26 07:20:02', '2017-03-26 07:20:02'),
(118, 'barcode.print', NULL, 1, 1, '2017-03-26 07:20:02', '2017-03-26 07:20:02'),
(119, 'barcode.list', NULL, 1, 1, '2017-03-26 07:20:02', '2017-03-26 07:20:02'),
(120, 'CheckInout.checkin', NULL, 1, 1, '2017-03-26 07:20:12', NULL),
(121, 'CheckInout.checkout', NULL, 1, 1, '2017-03-26 07:20:55', NULL),
(122, 'barcode.bulk.print', NULL, 1, 1, '2017-03-26 07:21:02', '2017-03-26 07:21:02'),
(123, 'CheckInout.get-device', NULL, 1, 1, '2017-03-26 07:21:09', NULL),
(124, 'CheckInout.load-bucket-data', NULL, 1, 1, '2017-03-26 07:21:30', NULL),
(125, 'CheckInout.asset-list', NULL, 1, 1, '2017-03-26 07:21:44', NULL),
(126, 'CheckInout.checkit', NULL, 1, 1, '2017-03-26 07:21:59', NULL),
(127, 'CheckInout.get-pending-assets', NULL, 1, 1, '2017-03-26 07:22:14', NULL),
(128, 'location.add', NULL, 1, 1, '2017-03-26 07:23:17', NULL),
(129, 'location.edit', NULL, 1, 1, '2017-03-26 07:23:34', NULL),
(130, 'location.get-location', NULL, 1, 1, '2017-03-26 07:23:48', NULL),
(131, 'location.get-ground-location', NULL, 1, 1, '2017-03-26 07:23:59', NULL),
(132, 'location.list', NULL, 1, 1, '2017-03-26 07:24:11', NULL),
(133, 'location.main-location', NULL, 1, 1, '2017-03-26 07:24:24', NULL),
(134, 'location.location-hierachy', NULL, 1, 1, '2017-03-26 07:24:37', NULL),
(135, 'manufacturer.trash', NULL, 1, 1, '2017-03-26 07:25:54', NULL),
(136, 'employee.reset.reset-password', NULL, 1, 1, '2017-03-26 07:53:43', NULL),
(137, 'audit.asset.list', NULL, 1, 1, '2017-03-26 12:03:25', '2017-03-26 12:03:25'),
(138, 'request.reject', NULL, 1, 1, '2017-03-26 16:14:57', NULL),
(139, 'request.approve', NULL, 1, 1, '2017-03-26 16:14:57', NULL),
(140, 'request.set-service', NULL, 1, 1, '2017-03-26 16:15:04', NULL),
(141, 'license.add', NULL, 1, 1, '2017-04-15 19:18:28', NULL),
(142, 'license.list', NULL, 1, 1, '2017-04-15 19:19:02', NULL),
(143, 'license.assign', NULL, 1, 1, '2017-04-15 19:19:42', NULL),
(144, 'barcode.add', NULL, 1, 1, '2017-04-15 19:20:24', NULL),
(145, 'barcode.print', NULL, 1, 1, '2017-04-15 19:20:59', NULL),
(146, 'barcode.bulk.print', NULL, 1, 1, '2017-04-15 19:20:59', NULL),
(147, 'barcode.genarate', NULL, 1, 1, '2017-04-15 19:25:16', NULL),
(148, 'config.add', NULL, 1, 1, '2017-04-15 19:30:46', NULL),
(151, 'request.add', NULL, 1, 1, '2017-04-16 02:39:14', NULL),
(152, 'request.edit', NULL, 1, 1, '2017-04-16 02:39:14', NULL),
(153, 'request.list', NULL, 1, 1, '2017-04-16 02:39:14', NULL),
(154, 'request.sent-to-service', NULL, 1, 1, '2017-04-16 02:39:14', NULL),
(155, 'location.type.add', NULL, 1, 1, '2017-04-22 13:53:20', NULL),
(156, 'location.type.list', NULL, 1, 1, '2017-04-22 13:53:20', NULL),
(157, 'location.type.edit', NULL, 1, 1, '2017-04-22 13:53:32', NULL),
(158, 'permission.groups.add', NULL, 1, NULL, '2017-04-30 05:06:59', NULL),
(159, 'permission.groups.list', NULL, 1, NULL, '2017-04-30 05:06:59', NULL),
(160, 'service.start', NULL, 1, NULL, '2017-05-11 16:21:12', NULL),
(161, 'service.complete', NULL, 1, NULL, '2017-05-11 16:21:12', NULL),
(162, 'issuenote.list', NULL, 1, NULL, '2017-05-11 16:28:49', NULL),
(163, 'issuenote.print', NULL, 1, NULL, '2017-05-11 16:28:49', NULL),
(164, 'license.add', NULL, 1, NULL, '2017-05-11 16:58:43', NULL),
(165, 'license.list', NULL, 1, NULL, '2017-05-11 16:58:49', NULL),
(166, 'license.assign', NULL, 1, NULL, '2017-05-11 16:58:55', NULL),
(167, 'service.print', NULL, 1, NULL, '2017-05-11 18:45:38', NULL),
(168, 'CheckInout.grn.print', NULL, 1, NULL, '2017-05-11 19:51:59', NULL),
(169, 'asset.user.assign', NULL, 1, 1, '2017-05-14 09:00:35', NULL),
(170, 'asset.user.unassign', NULL, 1, NULL, '2017-05-14 09:02:50', NULL),
(172, 'CheckInout.issuenote.print', NULL, 1, NULL, '2017-05-14 18:44:48', NULL),
(173, 'service.details', NULL, 1, NULL, '2017-05-14 21:24:09', NULL),
(174, 'supplier.status', NULL, 1, 1, '2017-06-12 15:35:13', NULL),
(175, 'service_type.status', NULL, 1, 1, '2017-06-12 15:36:21', NULL),
(176, 'location.type.status', NULL, 1, 1, '2017-06-12 15:37:54', NULL),
(177, 'location.status', NULL, 1, 1, '2017-06-12 15:38:43', NULL),
(178, 'asset-modal.status', NULL, 1, 1, '2017-06-12 15:41:20', NULL),
(179, 'category.status', NULL, 1, 1, '2017-06-13 14:42:44', NULL),
(180, 'asset.upgrade.unassign', NULL, 1, 1, '2017-06-13 22:04:29', NULL),
(181, 'asset.upgrade.add', NULL, 1, 1, '2017-06-13 22:04:46', NULL),
(182, 'asset.upgrade.list', NULL, 1, 1, '2017-06-13 22:05:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_groups`
--

CREATE TABLE IF NOT EXISTS `permission_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `permissions` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `permission_groups`
--

INSERT INTO `permission_groups` (`id`, `name`, `permissions`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'dashboard', '{"index":true}', '2017-05-11 14:34:01', '2017-05-11 17:32:15', NULL),
(2, 'Asset Add, Asset List and Asset Edit', '{"asset.add":true,"asset.edit":true,"asset.list":true}', '2017-05-11 15:37:56', '2017-05-11 21:07:56', NULL),
(3, 'User Add, User Edit and User list', '{"user.add":true,"user.edit":true,"user.list":true}', '2017-05-11 15:39:06', '2017-05-11 21:09:06', NULL),
(4, 'User Role Add, User Role Edit and User Role list', '{"user.role.add":true,"user.role.edit":true,"user.role.list":true}', '2017-05-11 15:39:28', '2017-05-11 21:09:28', NULL),
(5, 'User Delete', '{"user.delete":true}', '2017-05-11 15:40:07', '2017-05-11 21:10:07', NULL),
(6, 'User Role Delete', '{"user.role.delete":true}', '2017-05-11 15:40:19', '2017-05-11 21:10:19', NULL),
(7, 'Employee Type Add,List,Activate Deactivate and Edit', '{"employee.type.add":true,"employee.type.list":true,"employee.type.edit":true,"employee.type.status":true}', '2017-05-11 16:15:26', '2017-05-11 21:45:26', NULL),
(8, 'Employee Type Delete', '{"employee.type.delete":true}', '2017-05-11 16:15:38', '2017-05-11 21:45:38', NULL),
(9, 'Employee Add,List,Activate Deactivate and Edit', '{"employee.add":true,"employee.list":true,"employee.status":true,"employee.edit":true}', '2017-05-16 06:09:13', '2017-05-11 21:46:13', NULL),
(10, 'Employee Delete', '{"employee.delete":true}', '2017-05-11 16:16:30', '2017-05-11 21:46:30', NULL),
(11, 'Employee Reset authentication (Password reset)', '{"employee.reset.reset-password":true}', '2017-05-11 16:17:11', '2017-05-11 21:47:11', NULL),
(12, 'Service Type Add,List and Edit', '{"service_type.add":true,"service_type.edit":true,"service_type.list":true}', '2017-05-11 16:18:49', '2017-05-11 21:48:49', NULL),
(13, 'Service Type Delete', '{"service_type.delete":true}', '2017-05-11 16:19:01', '2017-05-11 21:49:01', NULL),
(14, 'Service Add,List,Print,Start Service and Complete Service', '{"service.add":true,"service.edit":true,"service.delete":true,"service.list":true,"service.start":true,"service.complete":true}', '2017-05-11 16:21:32', '2017-05-11 21:51:32', NULL),
(15, 'Master Data Category Add,list,edit and delete', '{"category.add ":true,"category.edit":true,"category.delete":true,"category.list":true}', '2017-05-11 16:22:17', '2017-05-11 21:52:17', NULL),
(16, 'Master Data Supplier Add,list,edit and delete', '{"supplier.add":true,"supplier.edit":true,"supplier.delete":true,"supplier.list":true}', '2017-05-11 16:22:34', '2017-05-11 21:52:34', NULL),
(17, 'Master Data Manufacturers Add,list,edit and delete', '{"manufacturer.add":true,"manufacturer.list":true,"manufacturer.status":true,"manufacturer.edit":true,"manufacturer.delete":true,"manufacturer.trash":true}', '2017-05-11 16:23:21', '2017-05-11 21:53:21', NULL),
(18, 'Master Data Location Add,list,edit and delete', '{"location.add":true,"location.edit":true,"location.get-location":true,"location.get-ground-location":true,"location.list":true,"location.main-location":true,"location.location-hierachy":true}', '2017-05-11 16:23:51', '2017-05-11 21:53:51', NULL),
(19, 'Master Data Location Type Add,list,edit and delete', '{"location.type.add":true,"location.type.list":true,"location.type.edit":true}', '2017-05-11 16:24:10', '2017-05-11 21:54:10', NULL),
(20, 'Master Data Asset Model Add,list,edit and delete', '{"assetModal.add":true,"assetModal.edit":true,"assetModal.list":true}', '2017-05-11 16:25:07', '2017-05-11 21:55:07', NULL),
(21, 'All Master Data', '{"category.add ":true,"category.edit":true,"category.delete":true,"category.list":true,"supplier.add":true,"supplier.edit":true,"supplier.delete":true,"supplier.list":true,"manufacturer.add":true,"manufacturer.list":true,"manufacturer.status":true,"manufacturer.edit":true,"manufacturer.delete":true,"manufacturer.trash":true,"location.add":true,"location.edit":true,"location.get-location":true,"location.get-ground-location":true,"location.list":true,"location.main-location":true,"location.location-hierachy":true,"location.type.add":true,"location.type.list":true,"location.type.edit":true,"assetModal.edit":true,"assetModal.add":true,"assetModal.list":true}', '2017-05-11 16:25:56', '2017-05-11 21:55:56', NULL),
(22, 'Asset Management Upload Assets', '{"asset.upload":true}', '2017-05-11 16:27:06', '2017-05-11 21:57:06', NULL),
(23, 'Check in and check out', '{"CheckInout.checkin":true,"CheckInout.checkout":true,"CheckInout.checkit":true,"CheckInout.load-bucket-data":true,"CheckInout.get-device":true,"CheckInout.asset-list":true,"CheckInout.get-pending-assets":true}', '2017-05-11 16:27:50', '2017-05-11 21:57:50', NULL),
(24, 'Good Received Note List', '{"CheckInout.grn.list":true,"CheckInout.grn.details":true}', '2017-05-11 16:29:09', '2017-05-11 21:59:09', NULL),
(25, 'Request Management add request', '{"request.add":true}', '2017-05-11 16:29:47', '2017-05-11 21:59:47', NULL),
(26, 'Request Management List request', '{"request.list":true}', '2017-05-11 16:30:05', '2017-05-11 22:00:05', NULL),
(27, 'Request Management Sent to service approval and reject', '{"request.reject":true,"request.approve":true,"request.set-service":true,"request.sent-to-service":true}', '2017-05-11 16:30:26', '2017-05-11 22:00:26', NULL),
(28, 'Barcode List', '{"asset.barcode_genarate":true,"barcode.list":true,"barcode.add":true,"barcode.genarate":true,"barcode.list.print":true,"barcode.print":true,"config.barcode.type":true}', '2017-05-11 16:32:02', '2017-05-11 22:02:02', NULL),
(29, 'Barcode Print', '{"barcode.print":true,"barcode.bulk.print":true,"barcode.list.print":true}', '2017-05-11 16:32:22', '2017-05-11 22:02:22', NULL),
(30, 'Audit Management', '{"audit.asset.list":true}', '2017-05-11 16:32:43', '2017-05-11 22:02:43', NULL),
(31, 'Software Asset Add And List', '{"license.add":true,"license.list":true}', '2017-05-11 17:04:25', '2017-05-11 22:34:25', NULL),
(32, 'Software Asset Assign', '{"license.assign":true}', '2017-05-11 17:04:38', '2017-05-11 22:34:38', NULL),
(33, 'Issue Note list and print', '{"issuenote.list":true,"issuenote.print":true}', '2017-05-11 18:07:30', '2017-05-11 23:37:30', NULL),
(34, 'Service note print', '{"service.print":true}', '2017-05-11 18:45:54', '2017-05-12 00:15:54', NULL),
(35, 'Good Received Note Print', '{"CheckInout.grn.print":true}', '2017-05-11 19:52:21', '2017-05-12 01:22:21', NULL),
(36, 'Asset Management Details, Timeline', '{"asset.view":true,"asset.barcode_genarate":true,"asset.damage":true}', '2017-05-11 20:31:03', '2017-05-12 02:01:03', NULL),
(37, 'Asset Management Assign Unassign', '{"asset.user.assign": true,"asset.user.unassign":true}', '2017-05-14 09:06:05', NULL, NULL),
(38, 'Asset Model add,edit and list', '{"asset-modal.add":true,"asset-modal.edit":true,"asset-modal.list":true}', '2017-06-15 04:05:30', '2017-05-14 23:51:34', NULL),
(39, 'Asset Model Edit', '{"asset-modal.edit":true}', '2017-06-15 04:05:42', '2017-05-14 23:51:59', NULL),
(40, 'Issue Note print', '{"issuenote.print":true}', '2017-05-15 05:04:34', '2017-05-15 00:04:34', NULL),
(41, 'Asset View', '{"asset.view":true}', '2017-05-15 05:09:14', '2017-05-15 00:09:14', NULL),
(42, 'Issue Note print', '{"issuenote.print":true}', '2017-05-15 05:12:15', '2017-05-15 00:12:15', NULL),
(43, 'Issue Note print (WORKING)', '{"CheckInout.issuenote.print":true}', '2017-05-15 05:15:32', '2017-05-15 00:15:32', NULL),
(44, 'Service Details View', '{"service.details":true}', '2017-05-15 07:58:55', '2017-05-15 02:58:55', NULL),
(45, 'Asset List', '{"asset.list":true}', '2017-05-15 08:30:06', '2017-05-15 03:30:06', NULL),
(46, 'Service and Maintaines', '{"service.add":true,"service.edit":true,"service.delete":true,"service.list":true,"request.sent-to-service":true,"request.set-service":true,"service.start":true,"service.complete":true,"service.print":true,"service.details":true}', '2017-05-26 17:46:02', '2017-05-26 12:46:02', NULL),
(47, 'Asset Upgrade', '{"asset.upgrade.unassign":true,"asset.upgrade.add":true,"asset.upgrade.list":true}', '2017-06-14 08:35:41', '2017-06-14 03:35:41', NULL),
(48, 'Reports', '{"report.view":true,"report.depreciation":true,"report.location_asset":true}', '2017-06-14 08:39:35', '2017-06-14 03:39:35', NULL),
(50, 'Category Enable/Disable', '{"category.status":true}', '2017-06-15 14:16:25', '2017-06-15 09:16:25', NULL),
(51, 'Supplier Enable/Disable', '{"supplier.status":true}', '2017-06-15 14:16:51', '2017-06-15 09:16:51', NULL),
(52, 'Manufacturer Enable/Disable', '{"manufacturer.status":true}', '2017-06-15 14:17:26', '2017-06-15 09:17:26', NULL),
(53, 'Location Type Enable/Disable', '{"location.type.status":true}', '2017-06-15 14:19:07', '2017-06-15 09:19:07', NULL),
(54, 'Location Enable/Disable', '{"location.status":true}', '2017-06-15 14:20:18', '2017-06-15 09:20:18', NULL),
(55, 'Asset Modal Enable/Disable', '{"asset-modal.status":true}', '2017-06-15 14:21:07', '2017-06-15 09:21:07', NULL),
(56, 'Service Type Enable/Disable', '{"service_type.status":true}', '2017-06-15 14:21:52', '2017-06-15 09:21:52', NULL),
(57, 'Print Issue Note', '{"CheckInout.issuenote.print":true}', '2017-08-03 07:14:31', '2017-08-03 12:44:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `persistences`
--

CREATE TABLE IF NOT EXISTS `persistences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `persistences_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1443 ;

--
-- Dumping data for table `persistences`
--

INSERT INTO `persistences` (`id`, `user_id`, `code`, `created_at`, `updated_at`) VALUES
(415, 17, 'qaiepDDg0NmTspoa0aHlcQiX5krPOIYN', '2017-05-12 15:28:44', '2017-05-12 15:28:44'),
(594, 34, 'axtGsBILTrdBHySpi8wpUW5ErGr5Jggy', '2017-05-28 18:28:04', '2017-05-28 18:28:04'),
(616, 18, 'UhLdc1lu3kEsgf9Zu1IlZipFrZjjEelO', '2017-05-30 17:11:41', '2017-05-30 17:11:41'),
(626, 18, 'BfwA9Zd8Ig79oPQGqzc8DxIOSW4BmRtb', '2017-05-30 22:32:20', '2017-05-30 22:32:20'),
(629, 18, '4xsYtMYDBdE2TNiXsxJVcANtew4eYURs', '2017-05-31 15:15:45', '2017-05-31 15:15:45'),
(630, 18, 'tKUesXalUZaaepSP1eBG4QZVliUu6y4q', '2017-05-31 19:52:32', '2017-05-31 19:52:32'),
(810, 16, 's7HfRR9aqRy4xt26GLK5G0c7T7XOoY8B', '2017-06-23 18:37:04', '2017-06-23 18:37:04'),
(870, 19, 'HQlm7sQU1By00Rvhfk4Z00XP8ed3jnjy', '2017-06-30 18:31:22', '2017-06-30 18:31:22'),
(939, 19, 'Mr1nOyYepIAg34nEk0HV9HGQCSG151qm', '2017-07-04 17:42:06', '2017-07-04 17:42:06'),
(1274, 4, 'nlBGUre5T7YRw0IZN6jDUq7rtoxJza6F', '2017-07-21 22:45:09', '2017-07-21 22:45:09'),
(1306, 7, 'TbOz2JkFmGRQksSAC52oyoRDd8ZQeNco', '2017-07-24 11:36:37', '2017-07-24 11:36:37'),
(1308, 13, 'BMartDqnRMov4jfiFeAfWmV36vOCeYjj', '2017-07-25 04:20:55', '2017-07-25 04:20:55'),
(1318, 11, 'Lyn0sBRDCfNtQ9h3DZqp6xvNV1xQDQ2j', '2017-07-26 10:41:53', '2017-07-26 10:41:53'),
(1438, 3, 'PiLk1hhZS6NvLrfIkmAAsMm3n1ObwQRf', '2017-08-03 06:12:42', '2017-08-03 06:12:42'),
(1439, 2, 'BHZ8Pibekye4XRCKZpd2YgPzbTEKqHV2', '2017-08-03 06:51:21', '2017-08-03 06:51:21'),
(1441, 6, 'CqFCl1yE4mwKbUCBCm7tGImhi31HMiSC', '2017-08-03 06:54:35', '2017-08-03 06:54:35'),
(1442, 1, '3mPNi3nGoFDRkd3h86IQbRsRmtpoyFno', '2017-08-03 07:13:12', '2017-08-03 07:13:12');

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE IF NOT EXISTS `reminders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32 ;

--
-- Dumping data for table `reminders`
--

INSERT INTO `reminders` (`id`, `user_id`, `code`, `completed`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 7, '3DCyvO7QdgzXzO36J97HpQEksyJwqjYb', 1, '2017-03-26 18:13:19', '2017-03-26 18:13:19', '2017-03-26 18:13:19'),
(2, 7, 'iiOvUhAKYpUEBXdy4j106LxLwakOPi56', 1, '2017-03-26 18:14:19', '2017-03-26 18:14:19', '2017-03-26 18:14:19'),
(3, 7, 'NDNnC3oPtxousBfPXidU1HFMdE2NjNcC', 1, '2017-03-26 18:15:03', '2017-03-26 18:15:03', '2017-03-26 18:15:03'),
(4, 7, 'dLzCHh9Y0wJ0aVMwleiR63uHdGTGTpif', 1, '2017-05-15 05:08:48', '2017-05-15 05:08:48', '2017-05-15 05:08:48'),
(5, 8, 'JDYlqxrrWvARJzNOzfd5DudP0xTaVXDy', 1, '2017-05-15 05:10:19', '2017-05-15 05:10:19', '2017-05-15 05:10:19'),
(6, 9, 'KRK1Za5MuTvtDb2mvk9MbDBKMbkpJVVP', 1, '2017-05-15 05:10:49', '2017-05-15 05:10:49', '2017-05-15 05:10:49'),
(7, 12, 'nz6SHB8Aptk6D8IL7Ngr6LUhh3OEkews', 1, '2017-05-15 07:20:55', '2017-05-15 07:20:55', '2017-05-15 07:20:55'),
(12, 28, 'SIB312adjtdDNtMQoICl2CPPiZIVsnDi', 1, '2017-05-30 21:11:44', '2017-05-30 21:11:44', '2017-05-30 21:11:44'),
(13, 4, 'KMsfDUHJWq75U3SsBwbrxZHrwYrcLnzG', 1, '2017-05-31 15:25:51', '2017-05-31 15:25:51', '2017-05-31 15:25:51'),
(14, 4, 'AzigeAxjCe4r2NgTjIxu2YTm3uUsnSjr', 1, '2017-06-15 16:20:17', '2017-06-15 16:20:17', '2017-06-15 16:20:17'),
(15, 9, 'hy7eUFsr8U9QTa15KScDViHmJmzRCLyj', 1, '2017-06-22 22:17:00', '2017-06-22 22:17:00', '2017-06-22 22:17:00'),
(16, 9, 'C2NhFq6HbBfe6Iez4AVV2OuGFoUdUj6j', 1, '2017-06-22 22:18:38', '2017-06-22 22:18:38', '2017-06-22 22:18:38'),
(17, 9, 'UCwv1BUtcWdE1DZF1owIDDTJ5uekqKs8', 1, '2017-06-22 22:19:30', '2017-06-22 22:19:30', '2017-06-22 22:19:30'),
(18, 9, 'qZScniBMnQQBbG36iexePCi42QFTIRRt', 1, '2017-06-22 22:20:20', '2017-06-22 22:20:20', '2017-06-22 22:20:20'),
(19, 16, 'B8rQP6ouLp4ILqeBcnlpBKDEpDFd4Cuz', 1, '2017-06-22 22:24:30', '2017-06-22 22:24:30', '2017-06-22 22:24:30'),
(20, 2, 'oKq49dLK19seynThPloTmjO5RfWGelpU', 1, '2017-07-11 16:31:24', '2017-07-11 16:31:24', '2017-07-11 16:31:24'),
(21, 3, '3g6IGnmbWEo5O9P60raA19QAXPP5jgP9', 1, '2017-07-11 18:50:47', '2017-07-11 18:50:46', '2017-07-11 18:50:47'),
(22, 3, 'QpBlCvlDAuQGTHn1wOP8ndiWuIi5WpX8', 1, '2017-07-11 18:51:50', '2017-07-11 18:51:50', '2017-07-11 18:51:50'),
(23, 3, 'oVTqqg8LPBSdDmw9l8OhMmIkwaOUiRxs', 1, '2017-07-11 18:53:51', '2017-07-11 18:53:50', '2017-07-11 18:53:51'),
(24, 6, 'oy3hHwQINGjztbAlziboGFuTuNvzePp8', 1, '2017-07-11 20:06:08', '2017-07-11 20:06:07', '2017-07-11 20:06:08'),
(25, 11, 'nOrjiGeEPUUHNSymDIo97PfsEjKdD2Rg', 1, '2017-07-12 15:49:35', '2017-07-12 15:49:35', '2017-07-12 15:49:35'),
(26, 11, 'ROEs9AKTXlxeArbU8MfFlHXankxkJUqG', 1, '2017-07-12 16:46:32', '2017-07-12 16:46:32', '2017-07-12 16:46:32'),
(27, 12, 'Q9HgeuaWXAForr42i06OY1fw936JSQ92', 1, '2017-07-12 16:47:12', '2017-07-12 16:47:12', '2017-07-12 16:47:12'),
(28, 5, 'aMSoA6OY9aUQWYXvPRiv8zkLIxSFOqwl', 1, '2017-07-21 17:04:33', '2017-07-21 17:04:33', '2017-07-21 17:04:33'),
(29, 23, 'tq2N3dT5oiCHb44CAvdwTH5GoB7que3i', 1, '2017-07-27 04:50:01', '2017-07-27 04:50:00', '2017-07-27 04:50:01'),
(30, 6, 'BSpj10rUrT6OkHgeytvRzYL4dKel9DCd', 1, '2017-08-01 04:53:07', '2017-08-01 04:53:06', '2017-08-01 04:53:07'),
(31, 6, 'RlOr8wF4s4fmWY3R4GHU2PeNczH9eOZw', 1, '2017-08-01 04:55:11', '2017-08-01 04:55:11', '2017-08-01 04:55:11');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE IF NOT EXISTS `request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `send_by` int(11) NOT NULL,
  `request_type_id` int(11) NOT NULL,
  `asset_type_id` int(11) DEFAULT NULL,
  `quantity` int(3) DEFAULT NULL,
  `approved_quantity` int(11) DEFAULT NULL,
  `asset_no` text,
  `remark` text,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `request_details`
--

CREATE TABLE IF NOT EXISTS `request_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `approved_employee_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `approved_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `request_status`
--

CREATE TABLE IF NOT EXISTS `request_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `request_status`
--

INSERT INTO `request_status` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Pending', '2017-03-27 00:01:37', NULL, NULL),
(2, 'Approved', '2017-03-27 00:01:55', NULL, NULL),
(3, 'Rejected', '2017-03-27 00:01:55', NULL, NULL),
(4, 'Sent to service', '2017-03-27 00:03:55', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `request_type`
--

CREATE TABLE IF NOT EXISTS `request_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `request_type`
--

INSERT INTO `request_type` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Asset Request', '2017-03-26 18:31:59', NULL, NULL),
(2, 'Service Request', '2017-03-26 18:31:59', NULL, NULL),
(3, 'Dispose Request', '2017-03-26 18:32:13', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_by` int(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `slug`, `name`, `permissions`, `created_by`, `created_at`, `updated_at`) VALUES
(3, 'it-officer', 'IT-OFFICER', '{"index":true,"asset.add":true,"asset.edit":true,"asset.list":true,"service.add":true,"service.edit":true,"service.delete":true,"service.list":true,"service.start":true,"service.complete":true,"asset.upload":true,"CheckInout.checkin":true,"CheckInout.checkout":true,"CheckInout.checkit":true,"CheckInout.load-bucket-data":true,"CheckInout.get-device":true,"CheckInout.asset-list":true,"CheckInout.get-pending-assets":true,"CheckInout.grn.list":true,"CheckInout.grn.details":true,"request.add":true,"request.list":true,"request.reject":true,"request.approve":true,"request.set-service":true,"request.sent-to-service":true,"asset.barcode_genarate":true,"barcode.list":true,"barcode.add":true,"barcode.genarate":true,"barcode.list.print":true,"barcode.print":true,"config.barcode.type":true,"barcode.bulk.print":true,"audit.asset.list":true,"issuenote.list":true,"issuenote.print":true,"service.print":true,"CheckInout.grn.print":true,"asset.view":true,"asset.damage":true,"asset.user.assign":true,"asset.user.unassign":true,"CheckInout.issuenote.print":true,"service.details":true,"employee.reset.reset-password":true,"service_type.add":true,"service_type.edit":true,"service_type.list":true,"service_type.delete":true,"license.add":true,"license.list":true,"license.assign":true,"asset.upgrade.unassign":true,"asset.upgrade.add":true,"asset.upgrade.list":true,"report.view":true,"report.depreciation":true,"report.location_asset":true}', 2, '2017-05-11 12:07:21', '2017-06-15 15:11:56'),
(5, 'sm-hardware', 'SM HARDWARE', '{"index":true,"asset.barcode_genarate":true,"asset.upload":true,"asset.add":true,"asset.edit":true,"asset.list":true,"user.add":true,"user.edit":true,"user.list":true,"user.status":true,"user.role.add":true,"user.role.edit":true,"user.role.list":true,"user.delete":true,"user.role.delete":true,"employee.type.add":true,"employee.type.list":true,"employee.type.edit":true,"employee.type.status":true,"employee.type.delete":true,"employee.add":true,"employee.list":true,"employee.status":true,"employee.delete":true,"employee.reset.reset-password":true,"supplier.add":true,"supplier.edit":true,"supplier.delete":true,"supplier.list":true,"supplier.status":true,"location.add":true,"location.edit":true,"location.get-location":true,"location.get-ground-location":true,"location.list":true,"location.status":true,"location.main-location":true,"location.location-hierachy":true,"manufacturer.add":true,"manufacturer.list":true,"manufacturer.status":true,"manufacturer.edit":true,"manufacturer.delete":true,"manufacturer.trash":true,"category.add ":true,"category.edit":true,"category.delete":true,"category.list":true,"category.status":true,"service_type.delete":true,"service_type.status":true,"service_type.add":true,"service_type.edit":true,"service_type.list":true,"service.add":true,"service.edit":true,"service.delete":true,"service.list":true,"service.start":true,"service.complete":true,"asset-modal.add":true,"asset-modal.edit":true,"asset-modal.list":true,"asset-modal.status":true,"location.type.add":true,"location.type.list":true,"location.type.edit":true,"location.type.status":true,"CheckInout.grn.list":true,"CheckInout.grn.details":true,"CheckInout.checkin":true,"CheckInout.checkout":true,"CheckInout.checkit":true,"CheckInout.load-bucket-data":true,"CheckInout.get-device":true,"CheckInout.asset-list":true,"CheckInout.get-pending-assets":true,"request.list":true,"request.reject":true,"request.approve":true,"request.set-service":true,"request.sent-to-service":true,"barcode.print":true,"barcode.bulk.print":true,"barcode.list.print":true,"barcode.list":true,"barcode.add":true,"barcode.genarate":true,"config.barcode.type":true,"license.add":true,"license.list":true,"audit.asset.list":true,"issuenote.list":true,"issuenote.print":true,"service.print":true,"CheckInout.grn.print":true,"asset.view":true,"asset.damage":true,"asset.user.assign":true,"asset.user.unassign":true,"CheckInout.issuenote.print":true,"license.assign":true,"service.details":true,"request.add":true}', 2, '2017-05-11 14:52:43', '2017-05-15 21:10:30'),
(6, 'admin', 'Admin', '{"index":true,"asset.add":true,"asset.edit":true,"asset.list":true,"user.add":true,"user.edit":true,"user.list":true,"user.role.add":true,"user.role.edit":true,"user.role.list":true,"user.delete":true,"user.role.delete":true,"employee.type.add":true,"employee.type.list":true,"employee.type.edit":true,"employee.type.status":true,"employee.type.delete":true,"employee.add":true,"employee.list":true,"employee.status":true,"employee.edit":true,"employee.delete":true,"employee.reset.reset-password":true,"service_type.add":true,"service_type.edit":true,"service_type.list":true,"service_type.delete":true,"service.add":true,"service.edit":true,"service.delete":true,"service.list":true,"service.start":true,"service.complete":true,"category.add ":true,"category.edit":true,"category.delete":true,"category.list":true,"supplier.add":true,"supplier.edit":true,"supplier.delete":true,"supplier.list":true,"manufacturer.add":true,"manufacturer.list":true,"manufacturer.status":true,"manufacturer.edit":true,"manufacturer.delete":true,"manufacturer.trash":true,"location.add":true,"location.edit":true,"location.get-location":true,"location.get-ground-location":true,"location.list":true,"location.main-location":true,"location.location-hierachy":true,"location.type.add":true,"location.type.list":true,"location.type.edit":true,"assetModal.add":true,"assetModal.edit":true,"assetModal.list":true,"asset.upload":true,"CheckInout.checkin":true,"CheckInout.checkout":true,"CheckInout.checkit":true,"CheckInout.load-bucket-data":true,"CheckInout.get-device":true,"CheckInout.asset-list":true,"CheckInout.get-pending-assets":true,"CheckInout.grn.list":true,"CheckInout.grn.details":true,"request.add":true,"request.list":true,"request.reject":true,"request.approve":true,"request.set-service":true,"request.sent-to-service":true,"asset.barcode_genarate":true,"barcode.list":true,"barcode.add":true,"barcode.genarate":true,"barcode.list.print":true,"barcode.print":true,"config.barcode.type":true,"barcode.bulk.print":true,"audit.asset.list":true,"license.add":true,"license.list":true,"license.assign":true,"issuenote.list":true,"issuenote.print":true,"service.print":true,"CheckInout.grn.print":true,"asset.view":true,"asset.damage":true,"asset.user.assign":true,"asset.user.unassign":true,"asset-modal.add":true,"asset-modal.edit":true,"asset-modal.list":true,"CheckInout.issuenote.print":true,"service.details":true,"asset.upgrade.unassign":true,"asset.upgrade.add":true,"asset.upgrade.list":true,"report.view":true,"report.depreciation":true,"report.location_asset":true,"category.status":true,"supplier.status":true,"location.type.status":true,"location.status":true,"asset-modal.status":true,"service_type.status":true}', 1, '2017-05-11 15:40:40', '2017-06-15 14:45:09'),
(7, 'branch-manager', 'Branch Manager', '{"index":true,"asset.add":true,"asset.edit":true,"asset.list":true,"employee.reset.reset-password":true,"service_type.add":true,"service_type.edit":true,"service_type.list":true,"CheckInout.checkin":true,"CheckInout.checkout":true,"CheckInout.checkit":true,"CheckInout.load-bucket-data":true,"CheckInout.get-device":true,"CheckInout.asset-list":true,"CheckInout.get-pending-assets":true,"CheckInout.grn.list":true,"CheckInout.grn.details":true,"request.add":true,"request.list":true,"request.reject":true,"request.approve":true,"request.set-service":true,"request.sent-to-service":true,"asset.barcode_genarate":true,"barcode.list":true,"barcode.add":true,"barcode.genarate":true,"barcode.list.print":true,"barcode.print":true,"config.barcode.type":true,"barcode.bulk.print":true,"license.add":true,"license.list":true,"license.assign":true,"issuenote.list":true,"issuenote.print":true,"service.print":true,"CheckInout.grn.print":true,"asset.view":true,"asset.damage":true,"asset.user.assign":true,"asset.user.unassign":true,"CheckInout.issuenote.print":true}', 1, '2017-05-15 04:24:00', '2017-08-03 07:38:49'),
(8, 'head-of-it', 'Head of IT', '{"index":true,"CheckInout.checkin":true,"CheckInout.checkout":true,"CheckInout.checkit":true,"CheckInout.load-bucket-data":true,"CheckInout.get-device":true,"CheckInout.asset-list":true,"CheckInout.get-pending-assets":true,"CheckInout.grn.list":true,"CheckInout.grn.details":true,"request.add":true,"request.list":true,"request.reject":true,"request.approve":true,"request.set-service":true,"request.sent-to-service":true,"asset.barcode_genarate":true,"barcode.list":true,"barcode.add":true,"barcode.genarate":true,"barcode.list.print":true,"barcode.print":true,"config.barcode.type":true,"barcode.bulk.print":true,"audit.asset.list":true,"license.add":true,"license.list":true,"license.assign":true,"issuenote.list":true,"issuenote.print":true,"service.print":true,"CheckInout.grn.print":true,"asset.view":true,"asset.damage":true,"asset.user.assign":true,"asset.user.unassign":true,"employee.reset.reset-password":true}', 1, '2017-05-15 04:31:04', '2017-06-15 14:30:16'),
(9, 'auditor', 'Auditor', '{"index":true,"employee.reset.reset-password":true,"audit.asset.list":true,"asset.view":true,"asset.list":true}', 1, '2017-05-15 08:11:34', '2017-06-15 14:37:38'),
(10, 'master', 'Master', '{"index":true,"asset.add":true,"asset.edit":true,"asset.list":true,"user.add":true,"user.edit":true,"user.list":true,"user.role.add":true,"user.role.edit":true,"user.role.list":true,"user.delete":true,"user.role.delete":true,"employee.type.add":true,"employee.type.list":true,"employee.type.edit":true,"employee.type.status":true,"employee.type.delete":true,"employee.add":true,"employee.list":true,"employee.status":true,"employee.edit":true,"employee.delete":true,"employee.reset.reset-password":true,"service_type.add":true,"service_type.edit":true,"service_type.list":true,"service_type.delete":true,"service.add":true,"service.edit":true,"service.delete":true,"service.list":true,"service.start":true,"service.complete":true,"category.add ":true,"category.edit":true,"category.delete":true,"category.list":true,"supplier.add":true,"supplier.edit":true,"supplier.delete":true,"supplier.list":true,"manufacturer.add":true,"manufacturer.list":true,"manufacturer.status":true,"manufacturer.edit":true,"manufacturer.delete":true,"manufacturer.trash":true,"location.add":true,"location.edit":true,"location.get-location":true,"location.get-ground-location":true,"location.list":true,"location.main-location":true,"location.location-hierachy":true,"location.type.add":true,"location.type.list":true,"location.type.edit":true,"assetModal.add":true,"assetModal.edit":true,"assetModal.list":true,"asset.upload":true,"CheckInout.checkin":true,"CheckInout.checkout":true,"CheckInout.checkit":true,"CheckInout.load-bucket-data":true,"CheckInout.get-device":true,"CheckInout.asset-list":true,"CheckInout.get-pending-assets":true,"CheckInout.grn.list":true,"CheckInout.grn.details":true,"request.add":true,"request.list":true,"request.reject":true,"request.approve":true,"request.set-service":true,"request.sent-to-service":true,"asset.barcode_genarate":true,"barcode.list":true,"barcode.add":true,"barcode.genarate":true,"barcode.list.print":true,"barcode.print":true,"config.barcode.type":true,"barcode.bulk.print":true,"audit.asset.list":true,"license.add":true,"license.list":true,"license.assign":true,"issuenote.list":true,"issuenote.print":true,"service.print":true,"CheckInout.grn.print":true,"asset.view":true,"asset.damage":true,"asset.user.assign":true,"asset.user.unassign":true,"asset-modal.add":true,"asset-modal.edit":true,"asset-modal.list":true,"CheckInout.issuenote.print":true,"service.details":true,"supplier.status":true,"category.status":true,"report.view":true,"report.depreciation":true,"report.location_asset":true,"asset.upgrade.unassign":true,"asset.upgrade.add":true,"asset.upgrade.list":true,"location.type.status":true,"location.status":true,"asset-modal.status":true,"service_type.status":true}', 1, '2017-05-16 20:47:06', '2017-06-15 14:42:09'),
(11, 'branch-user', 'Branch User', '{"index":true}', 3, '2017-06-22 23:40:49', '2017-06-22 23:46:13');

-- --------------------------------------------------------

--
-- Table structure for table `role_groups`
--

CREATE TABLE IF NOT EXISTS `role_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_group_id` int(11) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=949 ;

--
-- Dumping data for table `role_groups`
--

INSERT INTO `role_groups` (`id`, `permission_group_id`, `user_role_id`) VALUES
(236, 1, 5),
(237, 2, 5),
(238, 3, 5),
(239, 4, 5),
(240, 5, 5),
(241, 6, 5),
(242, 7, 5),
(243, 8, 5),
(244, 9, 5),
(245, 10, 5),
(246, 11, 5),
(247, 13, 5),
(248, 14, 5),
(249, 16, 5),
(250, 18, 5),
(251, 17, 5),
(252, 15, 5),
(253, 12, 5),
(254, 20, 5),
(255, 19, 5),
(256, 22, 5),
(257, 21, 5),
(258, 24, 5),
(259, 23, 5),
(260, 26, 5),
(261, 27, 5),
(262, 29, 5),
(263, 28, 5),
(264, 31, 5),
(265, 30, 5),
(266, 33, 5),
(267, 34, 5),
(268, 35, 5),
(269, 36, 5),
(270, 37, 5),
(271, 38, 5),
(272, 39, 5),
(273, 40, 5),
(274, 41, 5),
(275, 42, 5),
(276, 43, 5),
(277, 32, 5),
(278, 45, 5),
(279, 44, 5),
(280, 25, 5),
(699, 1, 8),
(700, 23, 8),
(701, 24, 8),
(702, 25, 8),
(703, 26, 8),
(704, 27, 8),
(705, 28, 8),
(706, 29, 8),
(707, 30, 8),
(708, 31, 8),
(709, 32, 8),
(710, 33, 8),
(711, 34, 8),
(712, 35, 8),
(713, 36, 8),
(714, 37, 8),
(715, 11, 8),
(721, 1, 9),
(722, 11, 9),
(723, 30, 9),
(724, 41, 9),
(725, 45, 9),
(726, 1, 10),
(727, 2, 10),
(728, 3, 10),
(729, 4, 10),
(730, 5, 10),
(731, 6, 10),
(732, 7, 10),
(733, 8, 10),
(734, 9, 10),
(735, 10, 10),
(736, 11, 10),
(737, 12, 10),
(738, 13, 10),
(739, 14, 10),
(740, 15, 10),
(741, 16, 10),
(742, 17, 10),
(743, 18, 10),
(744, 19, 10),
(745, 20, 10),
(746, 21, 10),
(747, 22, 10),
(748, 23, 10),
(749, 24, 10),
(750, 25, 10),
(751, 26, 10),
(752, 27, 10),
(753, 28, 10),
(754, 29, 10),
(755, 30, 10),
(756, 31, 10),
(757, 32, 10),
(758, 33, 10),
(759, 34, 10),
(760, 35, 10),
(761, 36, 10),
(762, 37, 10),
(763, 38, 10),
(764, 39, 10),
(765, 40, 10),
(766, 41, 10),
(767, 42, 10),
(768, 43, 10),
(769, 44, 10),
(770, 45, 10),
(771, 51, 10),
(772, 50, 10),
(773, 48, 10),
(774, 47, 10),
(775, 52, 10),
(776, 53, 10),
(777, 54, 10),
(778, 55, 10),
(779, 56, 10),
(780, 46, 10),
(781, 1, 6),
(782, 2, 6),
(783, 3, 6),
(784, 4, 6),
(785, 5, 6),
(786, 6, 6),
(787, 7, 6),
(788, 8, 6),
(789, 9, 6),
(790, 10, 6),
(791, 11, 6),
(792, 12, 6),
(793, 13, 6),
(794, 14, 6),
(795, 15, 6),
(796, 16, 6),
(797, 17, 6),
(798, 18, 6),
(799, 19, 6),
(800, 20, 6),
(801, 21, 6),
(802, 22, 6),
(803, 23, 6),
(804, 24, 6),
(805, 25, 6),
(806, 26, 6),
(807, 27, 6),
(808, 28, 6),
(809, 29, 6),
(810, 30, 6),
(811, 31, 6),
(812, 32, 6),
(813, 33, 6),
(814, 34, 6),
(815, 35, 6),
(816, 36, 6),
(817, 37, 6),
(818, 38, 6),
(819, 39, 6),
(820, 40, 6),
(821, 41, 6),
(822, 42, 6),
(823, 43, 6),
(824, 44, 6),
(825, 45, 6),
(826, 46, 6),
(827, 47, 6),
(828, 48, 6),
(829, 50, 6),
(830, 51, 6),
(831, 52, 6),
(832, 53, 6),
(833, 54, 6),
(834, 55, 6),
(835, 56, 6),
(836, 1, 3),
(837, 2, 3),
(838, 14, 3),
(839, 22, 3),
(840, 23, 3),
(841, 24, 3),
(842, 25, 3),
(843, 26, 3),
(844, 27, 3),
(845, 28, 3),
(846, 29, 3),
(847, 30, 3),
(848, 33, 3),
(849, 34, 3),
(850, 35, 3),
(851, 36, 3),
(852, 37, 3),
(853, 40, 3),
(854, 41, 3),
(855, 42, 3),
(856, 43, 3),
(857, 44, 3),
(858, 46, 3),
(859, 11, 3),
(860, 12, 3),
(861, 13, 3),
(862, 31, 3),
(863, 32, 3),
(864, 45, 3),
(865, 47, 3),
(866, 48, 3),
(875, 1, 11),
(930, 1, 7),
(931, 2, 7),
(932, 11, 7),
(933, 12, 7),
(934, 23, 7),
(935, 24, 7),
(936, 25, 7),
(937, 26, 7),
(938, 27, 7),
(939, 28, 7),
(940, 29, 7),
(941, 31, 7),
(942, 32, 7),
(943, 33, 7),
(944, 34, 7),
(945, 35, 7),
(946, 36, 7),
(947, 37, 7),
(948, 57, 7);

-- --------------------------------------------------------

--
-- Table structure for table `role_users`
--

CREATE TABLE IF NOT EXISTS `role_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_users`
--

INSERT INTO `role_users` (`user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(2, 6, '2017-07-21 15:29:02', '2017-07-21 15:29:02'),
(3, 3, '2017-07-31 20:11:10', '2017-07-31 20:11:10'),
(4, 6, '2017-07-31 20:12:39', '2017-07-31 20:12:39'),
(5, 3, '2017-07-31 20:12:58', '2017-07-31 20:12:58'),
(6, 7, '2017-07-31 20:13:19', '2017-07-31 20:13:19'),
(7, 8, '2017-07-31 20:13:37', '2017-07-31 20:13:37'),
(8, 6, '2017-08-01 02:58:50', '2017-08-01 02:58:50');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) DEFAULT NULL,
  `service_no` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `service_type_id` int(10) DEFAULT NULL,
  `cost` double(50,2) DEFAULT '0.00',
  `completed_date` date DEFAULT NULL,
  `service_in_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `serviced_by` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `user_id` int(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `service_type`
--

CREATE TABLE IF NOT EXISTS `service_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `service_type`
--

INSERT INTO `service_type` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Factory Maintaince', 1, '2017-07-21 19:40:49', '2017-07-21 19:40:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `software_license`
--

CREATE TABLE IF NOT EXISTS `software_license` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `asset_no` varchar(50) DEFAULT NULL,
  `license_to` date DEFAULT NULL,
  `license_from` date NOT NULL,
  `manufacture_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `category` varchar(80) NOT NULL,
  `description` text NOT NULL,
  `max_users` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `software_license_assign`
--

CREATE TABLE IF NOT EXISTS `software_license_assign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `software_license_id` int(11) NOT NULL,
  `mac_address` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reference_no` varchar(50) NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Un-Deploy', '2016-03-20 17:43:56', NULL, NULL),
(2, 'Deploy', '2016-03-20 17:43:56', NULL, NULL),
(3, 'Pending', '2016-03-20 17:44:18', NULL, NULL),
(4, 'Damage', '2016-03-20 23:07:19', NULL, NULL),
(5, 'In-Service', '2017-03-21 20:38:18', NULL, NULL),
(6, 'Disposed', '2017-03-21 20:38:31', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`created_at`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `address`, `city`, `country`, `phone`, `fax`, `email`, `remark`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'STC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-07-21 21:05:12', '2017-07-21 21:05:12', NULL),
(4, 'Sampath IT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-07-21 21:05:12', '2017-07-21 21:05:12', NULL),
(5, 'Debug', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-07-21 22:08:56', '2017-07-21 22:08:56', NULL),
(10, 'Metropolitan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-07-21 22:16:50', '2017-07-21 22:16:50', NULL),
(11, 'E-wis', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-07-21 22:16:50', '2017-07-21 22:16:50', NULL),
(12, 'Vs Information Systems (Pvt) Ltd.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-07-21 22:16:50', '2017-07-21 22:16:50', NULL),
(13, 'Softlogic Computers (Pvt) Ltd.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-07-21 22:16:50', '2017-07-21 22:16:50', NULL),
(14, 'Soft Logic', 'Colombo', 'Colombo', 'Sri Lanka', '0112035454', '0112035454', '0112035454@rdb.lk', '', 1, '2017-07-21 22:17:15', '2017-07-21 22:17:15', NULL),
(15, 'VSIS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-07-21 22:41:03', '2017-07-21 22:41:03', NULL),
(16, 'Sri Lanka State Trading', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-07-21 22:52:47', '2017-07-21 22:52:47', NULL),
(17, 'Metropoliton Computers', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-07-21 23:10:07', '2017-07-21 23:10:07', NULL),
(18, 'Tulip PVT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-07-24 04:01:15', '2017-07-24 04:01:15', NULL),
(19, 'NA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-08-01 11:08:11', '2017-08-01 11:08:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `throttle`
--

CREATE TABLE IF NOT EXISTS `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `throttle_user_id_index` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=533 ;

--
-- Dumping data for table `throttle`
--

INSERT INTO `throttle` (`id`, `user_id`, `type`, `ip`, `created_at`, `updated_at`) VALUES
(1, NULL, 'global', NULL, '2017-05-15 05:07:43', '2017-05-15 05:07:43'),
(2, NULL, 'ip', '220.247.202.227', '2017-05-15 05:07:43', '2017-05-15 05:07:43'),
(3, 7, 'user', NULL, '2017-05-15 05:07:43', '2017-05-15 05:07:43'),
(4, NULL, 'global', NULL, '2017-05-15 07:19:36', '2017-05-15 07:19:36'),
(5, NULL, 'ip', '220.247.202.227', '2017-05-15 07:19:36', '2017-05-15 07:19:36'),
(6, 12, 'user', NULL, '2017-05-15 07:19:36', '2017-05-15 07:19:36'),
(7, NULL, 'global', NULL, '2017-05-16 16:40:02', '2017-05-16 16:40:02'),
(8, NULL, 'ip', '217.151.98.13', '2017-05-16 16:40:02', '2017-05-16 16:40:02'),
(9, 2, 'user', NULL, '2017-05-16 16:40:02', '2017-05-16 16:40:02'),
(10, NULL, 'global', NULL, '2017-05-17 19:54:14', '2017-05-17 19:54:14'),
(11, NULL, 'ip', '220.247.202.227', '2017-05-17 19:54:14', '2017-05-17 19:54:14'),
(12, 1, 'user', NULL, '2017-05-17 19:54:14', '2017-05-17 19:54:14'),
(13, NULL, 'global', NULL, '2017-05-17 21:56:14', '2017-05-17 21:56:14'),
(14, NULL, 'ip', '220.247.236.118', '2017-05-17 21:56:14', '2017-05-17 21:56:14'),
(15, NULL, 'global', NULL, '2017-05-17 21:56:28', '2017-05-17 21:56:28'),
(16, NULL, 'ip', '220.247.236.118', '2017-05-17 21:56:28', '2017-05-17 21:56:28'),
(17, NULL, 'global', NULL, '2017-05-18 17:39:45', '2017-05-18 17:39:45'),
(18, NULL, 'ip', '220.247.236.118', '2017-05-18 17:39:45', '2017-05-18 17:39:45'),
(19, NULL, 'global', NULL, '2017-05-18 19:56:27', '2017-05-18 19:56:27'),
(20, NULL, 'ip', '220.247.236.118', '2017-05-18 19:56:27', '2017-05-18 19:56:27'),
(21, NULL, 'global', NULL, '2017-05-18 19:56:35', '2017-05-18 19:56:35'),
(22, NULL, 'ip', '220.247.236.118', '2017-05-18 19:56:35', '2017-05-18 19:56:35'),
(23, NULL, 'global', NULL, '2017-05-19 14:18:47', '2017-05-19 14:18:47'),
(24, NULL, 'ip', '5.101.142.235', '2017-05-19 14:18:47', '2017-05-19 14:18:47'),
(25, 1, 'user', NULL, '2017-05-19 14:18:47', '2017-05-19 14:18:47'),
(26, NULL, 'global', NULL, '2017-05-19 16:18:24', '2017-05-19 16:18:24'),
(27, NULL, 'ip', '112.134.39.231', '2017-05-19 16:18:24', '2017-05-19 16:18:24'),
(28, 20, 'user', NULL, '2017-05-19 16:18:24', '2017-05-19 16:18:24'),
(29, NULL, 'global', NULL, '2017-05-19 16:18:44', '2017-05-19 16:18:44'),
(30, NULL, 'ip', '112.134.39.231', '2017-05-19 16:18:44', '2017-05-19 16:18:44'),
(31, 20, 'user', NULL, '2017-05-19 16:18:44', '2017-05-19 16:18:44'),
(32, NULL, 'global', NULL, '2017-05-19 16:19:40', '2017-05-19 16:19:40'),
(33, NULL, 'ip', '112.134.39.231', '2017-05-19 16:19:40', '2017-05-19 16:19:40'),
(34, 27, 'user', NULL, '2017-05-19 16:19:40', '2017-05-19 16:19:40'),
(35, NULL, 'global', NULL, '2017-05-19 16:23:53', '2017-05-19 16:23:53'),
(36, NULL, 'ip', '162.244.81.238', '2017-05-19 16:23:53', '2017-05-19 16:23:53'),
(37, NULL, 'global', NULL, '2017-05-19 21:13:26', '2017-05-19 21:13:26'),
(38, NULL, 'ip', '220.247.202.227', '2017-05-19 21:13:26', '2017-05-19 21:13:26'),
(39, 2, 'user', NULL, '2017-05-19 21:13:26', '2017-05-19 21:13:26'),
(40, NULL, 'global', NULL, '2017-05-19 21:13:36', '2017-05-19 21:13:36'),
(41, NULL, 'ip', '220.247.202.227', '2017-05-19 21:13:36', '2017-05-19 21:13:36'),
(42, 2, 'user', NULL, '2017-05-19 21:13:36', '2017-05-19 21:13:36'),
(43, NULL, 'global', NULL, '2017-05-23 14:18:27', '2017-05-23 14:18:27'),
(44, NULL, 'ip', '220.247.236.118', '2017-05-23 14:18:27', '2017-05-23 14:18:27'),
(45, 17, 'user', NULL, '2017-05-23 14:18:27', '2017-05-23 14:18:27'),
(46, NULL, 'global', NULL, '2017-05-23 14:18:34', '2017-05-23 14:18:34'),
(47, NULL, 'ip', '220.247.236.118', '2017-05-23 14:18:34', '2017-05-23 14:18:34'),
(48, 17, 'user', NULL, '2017-05-23 14:18:34', '2017-05-23 14:18:34'),
(49, NULL, 'global', NULL, '2017-05-23 14:19:00', '2017-05-23 14:19:00'),
(50, NULL, 'ip', '220.247.236.118', '2017-05-23 14:19:00', '2017-05-23 14:19:00'),
(51, 17, 'user', NULL, '2017-05-23 14:19:00', '2017-05-23 14:19:00'),
(52, NULL, 'global', NULL, '2017-05-23 19:43:29', '2017-05-23 19:43:29'),
(53, NULL, 'ip', '220.247.236.118', '2017-05-23 19:43:29', '2017-05-23 19:43:29'),
(54, 17, 'user', NULL, '2017-05-23 19:43:29', '2017-05-23 19:43:29'),
(55, NULL, 'global', NULL, '2017-05-24 15:14:42', '2017-05-24 15:14:42'),
(56, NULL, 'ip', '112.134.48.128', '2017-05-24 15:14:42', '2017-05-24 15:14:42'),
(57, 3, 'user', NULL, '2017-05-24 15:14:42', '2017-05-24 15:14:42'),
(58, NULL, 'global', NULL, '2017-05-26 17:19:43', '2017-05-26 17:19:43'),
(59, NULL, 'ip', '220.247.236.118', '2017-05-26 17:19:43', '2017-05-26 17:19:43'),
(60, 30, 'user', NULL, '2017-05-26 17:19:43', '2017-05-26 17:19:43'),
(61, NULL, 'global', NULL, '2017-05-26 17:25:09', '2017-05-26 17:25:09'),
(62, NULL, 'ip', '220.247.236.118', '2017-05-26 17:25:09', '2017-05-26 17:25:09'),
(63, NULL, 'global', NULL, '2017-05-26 17:50:26', '2017-05-26 17:50:26'),
(64, NULL, 'ip', '220.247.236.118', '2017-05-26 17:50:26', '2017-05-26 17:50:26'),
(66, NULL, 'global', NULL, '2017-05-28 14:14:19', '2017-05-28 14:14:19'),
(67, NULL, 'ip', '220.247.236.118', '2017-05-28 14:14:19', '2017-05-28 14:14:19'),
(68, NULL, 'global', NULL, '2017-05-28 15:06:06', '2017-05-28 15:06:06'),
(69, NULL, 'ip', '220.247.236.118', '2017-05-28 15:06:06', '2017-05-28 15:06:06'),
(71, NULL, 'global', NULL, '2017-05-28 15:07:47', '2017-05-28 15:07:47'),
(72, NULL, 'ip', '220.247.236.118', '2017-05-28 15:07:47', '2017-05-28 15:07:47'),
(73, NULL, 'global', NULL, '2017-05-28 17:42:30', '2017-05-28 17:42:30'),
(74, NULL, 'ip', '220.247.236.118', '2017-05-28 17:42:30', '2017-05-28 17:42:30'),
(75, 1, 'user', NULL, '2017-05-28 17:42:30', '2017-05-28 17:42:30'),
(76, NULL, 'global', NULL, '2017-05-28 18:05:06', '2017-05-28 18:05:06'),
(77, NULL, 'ip', '220.247.236.118', '2017-05-28 18:05:06', '2017-05-28 18:05:06'),
(78, 1, 'user', NULL, '2017-05-28 18:05:06', '2017-05-28 18:05:06'),
(79, NULL, 'global', NULL, '2017-05-30 16:40:02', '2017-05-30 16:40:02'),
(80, NULL, 'ip', '38.132.117.195', '2017-05-30 16:40:02', '2017-05-30 16:40:02'),
(81, 1, 'user', NULL, '2017-05-30 16:40:02', '2017-05-30 16:40:02'),
(82, NULL, 'global', NULL, '2017-05-30 17:04:35', '2017-05-30 17:04:35'),
(83, NULL, 'ip', '220.247.236.118', '2017-05-30 17:04:35', '2017-05-30 17:04:35'),
(84, 14, 'user', NULL, '2017-05-30 17:04:35', '2017-05-30 17:04:35'),
(85, NULL, 'global', NULL, '2017-05-30 21:05:45', '2017-05-30 21:05:45'),
(86, NULL, 'ip', '220.247.236.118', '2017-05-30 21:05:45', '2017-05-30 21:05:45'),
(87, 26, 'user', NULL, '2017-05-30 21:05:45', '2017-05-30 21:05:45'),
(88, NULL, 'global', NULL, '2017-05-30 21:21:58', '2017-05-30 21:21:58'),
(89, NULL, 'ip', '220.247.236.118', '2017-05-30 21:21:58', '2017-05-30 21:21:58'),
(90, NULL, 'global', NULL, '2017-05-31 20:17:41', '2017-05-31 20:17:41'),
(91, NULL, 'ip', '220.247.236.118', '2017-05-31 20:17:41', '2017-05-31 20:17:41'),
(92, NULL, 'global', NULL, '2017-05-31 20:17:53', '2017-05-31 20:17:53'),
(93, NULL, 'ip', '220.247.236.118', '2017-05-31 20:17:53', '2017-05-31 20:17:53'),
(94, NULL, 'global', NULL, '2017-05-31 20:17:59', '2017-05-31 20:17:59'),
(95, NULL, 'ip', '220.247.236.118', '2017-05-31 20:17:59', '2017-05-31 20:17:59'),
(96, NULL, 'global', NULL, '2017-05-31 20:18:05', '2017-05-31 20:18:05'),
(97, NULL, 'ip', '220.247.236.118', '2017-05-31 20:18:05', '2017-05-31 20:18:05'),
(98, NULL, 'global', NULL, '2017-05-31 21:53:44', '2017-05-31 21:53:44'),
(99, NULL, 'ip', '220.247.202.227', '2017-05-31 21:53:44', '2017-05-31 21:53:44'),
(100, 1, 'user', NULL, '2017-05-31 21:53:44', '2017-05-31 21:53:44'),
(101, NULL, 'global', NULL, '2017-06-04 16:51:43', '2017-06-04 16:51:43'),
(102, NULL, 'ip', '127.0.0.1', '2017-06-04 16:51:43', '2017-06-04 16:51:43'),
(103, 1, 'user', NULL, '2017-06-04 16:51:43', '2017-06-04 16:51:43'),
(104, NULL, 'global', NULL, '2017-06-14 01:49:34', '2017-06-14 01:49:34'),
(105, NULL, 'ip', '220.247.202.227', '2017-06-14 01:49:34', '2017-06-14 01:49:34'),
(106, 2, 'user', NULL, '2017-06-14 01:49:34', '2017-06-14 01:49:34'),
(107, NULL, 'global', NULL, '2017-06-14 08:22:36', '2017-06-14 08:22:36'),
(108, NULL, 'ip', '220.247.202.227', '2017-06-14 08:22:36', '2017-06-14 08:22:36'),
(109, 1, 'user', NULL, '2017-06-14 08:22:36', '2017-06-14 08:22:36'),
(110, NULL, 'global', NULL, '2017-06-14 08:26:05', '2017-06-14 08:26:05'),
(111, NULL, 'ip', '217.64.113.202', '2017-06-14 08:26:05', '2017-06-14 08:26:05'),
(112, 4, 'user', NULL, '2017-06-14 08:26:05', '2017-06-14 08:26:05'),
(113, NULL, 'global', NULL, '2017-06-14 08:53:17', '2017-06-14 08:53:17'),
(114, NULL, 'ip', '217.64.113.202', '2017-06-14 08:53:17', '2017-06-14 08:53:17'),
(115, 2, 'user', NULL, '2017-06-14 08:53:17', '2017-06-14 08:53:17'),
(116, NULL, 'global', NULL, '2017-06-15 15:05:55', '2017-06-15 15:05:55'),
(117, NULL, 'ip', '61.245.170.245', '2017-06-15 15:05:55', '2017-06-15 15:05:55'),
(118, 2, 'user', NULL, '2017-06-15 15:05:55', '2017-06-15 15:05:55'),
(119, NULL, 'global', NULL, '2017-06-15 16:20:38', '2017-06-15 16:20:38'),
(120, NULL, 'ip', '185.156.173.58', '2017-06-15 16:20:38', '2017-06-15 16:20:38'),
(121, 4, 'user', NULL, '2017-06-15 16:20:38', '2017-06-15 16:20:38'),
(122, NULL, 'global', NULL, '2017-06-15 17:50:23', '2017-06-15 17:50:23'),
(123, NULL, 'ip', '61.245.168.131', '2017-06-15 17:50:23', '2017-06-15 17:50:23'),
(124, 4, 'user', NULL, '2017-06-15 17:50:23', '2017-06-15 17:50:23'),
(125, NULL, 'global', NULL, '2017-06-15 20:15:38', '2017-06-15 20:15:38'),
(126, NULL, 'ip', '61.245.168.131', '2017-06-15 20:15:38', '2017-06-15 20:15:38'),
(127, 2, 'user', NULL, '2017-06-15 20:15:38', '2017-06-15 20:15:38'),
(128, NULL, 'global', NULL, '2017-06-15 20:16:24', '2017-06-15 20:16:24'),
(129, NULL, 'ip', '61.245.168.131', '2017-06-15 20:16:24', '2017-06-15 20:16:24'),
(130, 4, 'user', NULL, '2017-06-15 20:16:24', '2017-06-15 20:16:24'),
(131, NULL, 'global', NULL, '2017-06-16 22:14:00', '2017-06-16 22:14:00'),
(132, NULL, 'ip', '220.247.236.118', '2017-06-16 22:14:00', '2017-06-16 22:14:00'),
(133, 2, 'user', NULL, '2017-06-16 22:14:00', '2017-06-16 22:14:00'),
(134, NULL, 'global', NULL, '2017-06-22 17:35:16', '2017-06-22 17:35:16'),
(135, NULL, 'ip', '220.247.236.118', '2017-06-22 17:35:16', '2017-06-22 17:35:16'),
(136, 4, 'user', NULL, '2017-06-22 17:35:16', '2017-06-22 17:35:16'),
(137, NULL, 'global', NULL, '2017-06-22 17:40:06', '2017-06-22 17:40:06'),
(138, NULL, 'ip', '220.247.236.118', '2017-06-22 17:40:06', '2017-06-22 17:40:06'),
(139, 3, 'user', NULL, '2017-06-22 17:40:06', '2017-06-22 17:40:06'),
(140, NULL, 'global', NULL, '2017-06-22 17:40:08', '2017-06-22 17:40:08'),
(141, NULL, 'ip', '220.247.236.118', '2017-06-22 17:40:08', '2017-06-22 17:40:08'),
(142, 3, 'user', NULL, '2017-06-22 17:40:08', '2017-06-22 17:40:08'),
(143, NULL, 'global', NULL, '2017-06-22 21:09:32', '2017-06-22 21:09:32'),
(144, NULL, 'ip', '220.247.236.118', '2017-06-22 21:09:32', '2017-06-22 21:09:32'),
(145, 3, 'user', NULL, '2017-06-22 21:09:32', '2017-06-22 21:09:32'),
(146, NULL, 'global', NULL, '2017-06-22 21:09:44', '2017-06-22 21:09:44'),
(147, NULL, 'ip', '220.247.236.118', '2017-06-22 21:09:44', '2017-06-22 21:09:44'),
(148, 3, 'user', NULL, '2017-06-22 21:09:44', '2017-06-22 21:09:44'),
(149, NULL, 'global', NULL, '2017-06-22 21:56:09', '2017-06-22 21:56:09'),
(150, NULL, 'ip', '220.247.236.118', '2017-06-22 21:56:09', '2017-06-22 21:56:09'),
(151, 9, 'user', NULL, '2017-06-22 21:56:09', '2017-06-22 21:56:09'),
(152, NULL, 'global', NULL, '2017-06-22 21:56:10', '2017-06-22 21:56:10'),
(153, NULL, 'ip', '220.247.236.118', '2017-06-22 21:56:10', '2017-06-22 21:56:10'),
(154, 9, 'user', NULL, '2017-06-22 21:56:10', '2017-06-22 21:56:10'),
(155, NULL, 'global', NULL, '2017-06-22 22:43:06', '2017-06-22 22:43:06'),
(156, NULL, 'ip', '220.247.236.118', '2017-06-22 22:43:06', '2017-06-22 22:43:06'),
(157, 8, 'user', NULL, '2017-06-22 22:43:06', '2017-06-22 22:43:06'),
(158, NULL, 'global', NULL, '2017-06-22 22:48:53', '2017-06-22 22:48:53'),
(159, NULL, 'ip', '220.247.236.118', '2017-06-22 22:48:53', '2017-06-22 22:48:53'),
(160, 3, 'user', NULL, '2017-06-22 22:48:53', '2017-06-22 22:48:53'),
(161, NULL, 'global', NULL, '2017-06-22 23:46:35', '2017-06-22 23:46:35'),
(162, NULL, 'ip', '220.247.236.118', '2017-06-22 23:46:35', '2017-06-22 23:46:35'),
(163, 17, 'user', NULL, '2017-06-22 23:46:35', '2017-06-22 23:46:35'),
(164, NULL, 'global', NULL, '2017-06-23 00:04:02', '2017-06-23 00:04:02'),
(165, NULL, 'ip', '220.247.236.118', '2017-06-23 00:04:02', '2017-06-23 00:04:02'),
(166, 4, 'user', NULL, '2017-06-23 00:04:02', '2017-06-23 00:04:02'),
(167, NULL, 'global', NULL, '2017-06-23 16:48:04', '2017-06-23 16:48:04'),
(168, NULL, 'ip', '220.247.236.118', '2017-06-23 16:48:04', '2017-06-23 16:48:04'),
(169, 4, 'user', NULL, '2017-06-23 16:48:04', '2017-06-23 16:48:04'),
(170, NULL, 'global', NULL, '2017-06-23 16:48:09', '2017-06-23 16:48:09'),
(171, NULL, 'ip', '220.247.236.118', '2017-06-23 16:48:09', '2017-06-23 16:48:09'),
(172, 4, 'user', NULL, '2017-06-23 16:48:09', '2017-06-23 16:48:09'),
(173, NULL, 'global', NULL, '2017-06-23 16:48:39', '2017-06-23 16:48:39'),
(174, NULL, 'ip', '220.247.236.118', '2017-06-23 16:48:39', '2017-06-23 16:48:39'),
(175, 4, 'user', NULL, '2017-06-23 16:48:39', '2017-06-23 16:48:39'),
(176, NULL, 'global', NULL, '2017-06-23 17:06:22', '2017-06-23 17:06:22'),
(177, NULL, 'ip', '220.247.236.118', '2017-06-23 17:06:22', '2017-06-23 17:06:22'),
(178, 3, 'user', NULL, '2017-06-23 17:06:22', '2017-06-23 17:06:22'),
(179, NULL, 'global', NULL, '2017-06-23 18:35:47', '2017-06-23 18:35:47'),
(180, NULL, 'ip', '220.247.236.118', '2017-06-23 18:35:47', '2017-06-23 18:35:47'),
(181, 16, 'user', NULL, '2017-06-23 18:35:47', '2017-06-23 18:35:47'),
(182, NULL, 'global', NULL, '2017-06-23 18:35:56', '2017-06-23 18:35:56'),
(183, NULL, 'ip', '220.247.236.118', '2017-06-23 18:35:56', '2017-06-23 18:35:56'),
(184, 16, 'user', NULL, '2017-06-23 18:35:56', '2017-06-23 18:35:56'),
(185, NULL, 'global', NULL, '2017-06-23 19:17:59', '2017-06-23 19:17:59'),
(186, NULL, 'ip', '220.247.236.118', '2017-06-23 19:17:59', '2017-06-23 19:17:59'),
(187, 8, 'user', NULL, '2017-06-23 19:17:59', '2017-06-23 19:17:59'),
(188, NULL, 'global', NULL, '2017-06-23 20:14:05', '2017-06-23 20:14:05'),
(189, NULL, 'ip', '220.247.236.118', '2017-06-23 20:14:05', '2017-06-23 20:14:05'),
(190, 14, 'user', NULL, '2017-06-23 20:14:05', '2017-06-23 20:14:05'),
(191, NULL, 'global', NULL, '2017-06-23 20:55:24', '2017-06-23 20:55:24'),
(192, NULL, 'ip', '220.247.236.118', '2017-06-23 20:55:24', '2017-06-23 20:55:24'),
(193, 3, 'user', NULL, '2017-06-23 20:55:24', '2017-06-23 20:55:24'),
(194, NULL, 'global', NULL, '2017-06-28 16:07:32', '2017-06-28 16:07:32'),
(195, NULL, 'ip', '220.247.236.118', '2017-06-28 16:07:32', '2017-06-28 16:07:32'),
(196, 3, 'user', NULL, '2017-06-28 16:07:32', '2017-06-28 16:07:32'),
(197, NULL, 'global', NULL, '2017-06-28 16:07:40', '2017-06-28 16:07:40'),
(198, NULL, 'ip', '220.247.236.118', '2017-06-28 16:07:40', '2017-06-28 16:07:40'),
(199, 3, 'user', NULL, '2017-06-28 16:07:40', '2017-06-28 16:07:40'),
(200, NULL, 'global', NULL, '2017-06-28 16:07:54', '2017-06-28 16:07:54'),
(201, NULL, 'ip', '220.247.236.118', '2017-06-28 16:07:54', '2017-06-28 16:07:54'),
(202, 3, 'user', NULL, '2017-06-28 16:07:54', '2017-06-28 16:07:54'),
(203, NULL, 'global', NULL, '2017-06-28 16:08:02', '2017-06-28 16:08:02'),
(204, NULL, 'ip', '220.247.236.118', '2017-06-28 16:08:02', '2017-06-28 16:08:02'),
(205, 3, 'user', NULL, '2017-06-28 16:08:02', '2017-06-28 16:08:02'),
(206, NULL, 'global', NULL, '2017-06-28 16:08:13', '2017-06-28 16:08:13'),
(207, NULL, 'ip', '220.247.236.118', '2017-06-28 16:08:13', '2017-06-28 16:08:13'),
(208, 3, 'user', NULL, '2017-06-28 16:08:13', '2017-06-28 16:08:13'),
(209, NULL, 'global', NULL, '2017-06-28 16:43:17', '2017-06-28 16:43:17'),
(210, NULL, 'ip', '123.231.124.15', '2017-06-28 16:43:17', '2017-06-28 16:43:17'),
(211, 1, 'user', NULL, '2017-06-28 16:43:17', '2017-06-28 16:43:17'),
(212, NULL, 'global', NULL, '2017-06-29 15:04:53', '2017-06-29 15:04:53'),
(213, NULL, 'ip', '61.245.161.47', '2017-06-29 15:04:53', '2017-06-29 15:04:53'),
(214, 1, 'user', NULL, '2017-06-29 15:04:53', '2017-06-29 15:04:53'),
(215, NULL, 'global', NULL, '2017-06-29 16:56:47', '2017-06-29 16:56:47'),
(216, NULL, 'ip', '220.247.236.118', '2017-06-29 16:56:47', '2017-06-29 16:56:47'),
(217, 3, 'user', NULL, '2017-06-29 16:56:47', '2017-06-29 16:56:47'),
(218, NULL, 'global', NULL, '2017-06-29 18:39:52', '2017-06-29 18:39:52'),
(219, NULL, 'ip', '220.247.236.118', '2017-06-29 18:39:52', '2017-06-29 18:39:52'),
(220, 3, 'user', NULL, '2017-06-29 18:39:52', '2017-06-29 18:39:52'),
(221, NULL, 'global', NULL, '2017-06-29 20:06:45', '2017-06-29 20:06:45'),
(222, NULL, 'ip', '220.247.236.118', '2017-06-29 20:06:45', '2017-06-29 20:06:45'),
(223, 3, 'user', NULL, '2017-06-29 20:06:45', '2017-06-29 20:06:45'),
(224, NULL, 'global', NULL, '2017-06-29 20:06:53', '2017-06-29 20:06:53'),
(225, NULL, 'ip', '220.247.236.118', '2017-06-29 20:06:53', '2017-06-29 20:06:53'),
(226, 3, 'user', NULL, '2017-06-29 20:06:53', '2017-06-29 20:06:53'),
(227, NULL, 'global', NULL, '2017-06-29 20:07:01', '2017-06-29 20:07:01'),
(228, NULL, 'ip', '220.247.236.118', '2017-06-29 20:07:01', '2017-06-29 20:07:01'),
(229, 3, 'user', NULL, '2017-06-29 20:07:01', '2017-06-29 20:07:01'),
(230, NULL, 'global', NULL, '2017-06-29 20:30:22', '2017-06-29 20:30:22'),
(231, NULL, 'ip', '220.247.236.118', '2017-06-29 20:30:22', '2017-06-29 20:30:22'),
(232, 3, 'user', NULL, '2017-06-29 20:30:22', '2017-06-29 20:30:22'),
(233, NULL, 'global', NULL, '2017-06-29 21:36:17', '2017-06-29 21:36:17'),
(234, NULL, 'ip', '220.247.236.118', '2017-06-29 21:36:17', '2017-06-29 21:36:17'),
(235, 3, 'user', NULL, '2017-06-29 21:36:17', '2017-06-29 21:36:17'),
(236, NULL, 'global', NULL, '2017-06-30 14:35:28', '2017-06-30 14:35:28'),
(237, NULL, 'ip', '220.247.236.118', '2017-06-30 14:35:28', '2017-06-30 14:35:28'),
(238, 3, 'user', NULL, '2017-06-30 14:35:28', '2017-06-30 14:35:28'),
(239, NULL, 'global', NULL, '2017-06-30 14:35:35', '2017-06-30 14:35:35'),
(240, NULL, 'ip', '220.247.236.118', '2017-06-30 14:35:35', '2017-06-30 14:35:35'),
(241, 3, 'user', NULL, '2017-06-30 14:35:35', '2017-06-30 14:35:35'),
(242, NULL, 'global', NULL, '2017-06-30 15:40:43', '2017-06-30 15:40:43'),
(243, NULL, 'ip', '220.247.236.118', '2017-06-30 15:40:43', '2017-06-30 15:40:43'),
(244, 8, 'user', NULL, '2017-06-30 15:40:43', '2017-06-30 15:40:43'),
(245, NULL, 'global', NULL, '2017-06-30 16:05:17', '2017-06-30 16:05:17'),
(246, NULL, 'ip', '220.247.236.118', '2017-06-30 16:05:17', '2017-06-30 16:05:17'),
(247, 3, 'user', NULL, '2017-06-30 16:05:17', '2017-06-30 16:05:17'),
(248, NULL, 'global', NULL, '2017-06-30 16:15:51', '2017-06-30 16:15:51'),
(249, NULL, 'ip', '220.247.236.118', '2017-06-30 16:15:51', '2017-06-30 16:15:51'),
(250, 8, 'user', NULL, '2017-06-30 16:15:51', '2017-06-30 16:15:51'),
(251, NULL, 'global', NULL, '2017-06-30 16:16:44', '2017-06-30 16:16:44'),
(252, NULL, 'ip', '220.247.236.118', '2017-06-30 16:16:44', '2017-06-30 16:16:44'),
(253, 3, 'user', NULL, '2017-06-30 16:16:44', '2017-06-30 16:16:44'),
(254, NULL, 'global', NULL, '2017-06-30 16:31:48', '2017-06-30 16:31:48'),
(255, NULL, 'ip', '220.247.236.118', '2017-06-30 16:31:48', '2017-06-30 16:31:48'),
(256, 3, 'user', NULL, '2017-06-30 16:31:48', '2017-06-30 16:31:48'),
(257, NULL, 'global', NULL, '2017-06-30 18:07:25', '2017-06-30 18:07:25'),
(258, NULL, 'ip', '220.247.236.118', '2017-06-30 18:07:25', '2017-06-30 18:07:25'),
(259, 3, 'user', NULL, '2017-06-30 18:07:25', '2017-06-30 18:07:25'),
(260, NULL, 'global', NULL, '2017-06-30 18:07:32', '2017-06-30 18:07:32'),
(261, NULL, 'ip', '220.247.236.118', '2017-06-30 18:07:32', '2017-06-30 18:07:32'),
(262, 3, 'user', NULL, '2017-06-30 18:07:32', '2017-06-30 18:07:32'),
(263, NULL, 'global', NULL, '2017-06-30 18:13:45', '2017-06-30 18:13:45'),
(264, NULL, 'ip', '220.247.236.118', '2017-06-30 18:13:45', '2017-06-30 18:13:45'),
(265, 3, 'user', NULL, '2017-06-30 18:13:45', '2017-06-30 18:13:45'),
(266, NULL, 'global', NULL, '2017-06-30 18:13:53', '2017-06-30 18:13:53'),
(267, NULL, 'ip', '220.247.236.118', '2017-06-30 18:13:53', '2017-06-30 18:13:53'),
(268, 3, 'user', NULL, '2017-06-30 18:13:53', '2017-06-30 18:13:53'),
(269, NULL, 'global', NULL, '2017-06-30 18:31:14', '2017-06-30 18:31:14'),
(270, NULL, 'ip', '220.247.236.118', '2017-06-30 18:31:14', '2017-06-30 18:31:14'),
(271, 19, 'user', NULL, '2017-06-30 18:31:14', '2017-06-30 18:31:14'),
(272, NULL, 'global', NULL, '2017-06-30 19:06:58', '2017-06-30 19:06:58'),
(273, NULL, 'ip', '112.134.49.247', '2017-06-30 19:06:58', '2017-06-30 19:06:58'),
(274, 3, 'user', NULL, '2017-06-30 19:06:58', '2017-06-30 19:06:58'),
(275, NULL, 'global', NULL, '2017-06-30 22:15:09', '2017-06-30 22:15:09'),
(276, NULL, 'ip', '220.247.236.118', '2017-06-30 22:15:09', '2017-06-30 22:15:09'),
(277, 3, 'user', NULL, '2017-06-30 22:15:09', '2017-06-30 22:15:09'),
(278, NULL, 'global', NULL, '2017-06-30 22:15:18', '2017-06-30 22:15:18'),
(279, NULL, 'ip', '220.247.236.118', '2017-06-30 22:15:18', '2017-06-30 22:15:18'),
(280, 3, 'user', NULL, '2017-06-30 22:15:18', '2017-06-30 22:15:18'),
(281, NULL, 'global', NULL, '2017-06-30 22:22:57', '2017-06-30 22:22:57'),
(282, NULL, 'ip', '220.247.236.118', '2017-06-30 22:22:57', '2017-06-30 22:22:57'),
(283, 3, 'user', NULL, '2017-06-30 22:22:57', '2017-06-30 22:22:57'),
(284, NULL, 'global', NULL, '2017-07-03 14:56:10', '2017-07-03 14:56:10'),
(285, NULL, 'ip', '220.247.236.118', '2017-07-03 14:56:10', '2017-07-03 14:56:10'),
(286, 7, 'user', NULL, '2017-07-03 14:56:10', '2017-07-03 14:56:10'),
(287, NULL, 'global', NULL, '2017-07-03 15:05:38', '2017-07-03 15:05:38'),
(288, NULL, 'ip', '220.247.236.118', '2017-07-03 15:05:38', '2017-07-03 15:05:38'),
(289, 12, 'user', NULL, '2017-07-03 15:05:38', '2017-07-03 15:05:38'),
(290, NULL, 'global', NULL, '2017-07-03 15:05:46', '2017-07-03 15:05:46'),
(291, NULL, 'ip', '220.247.236.118', '2017-07-03 15:05:46', '2017-07-03 15:05:46'),
(292, 12, 'user', NULL, '2017-07-03 15:05:46', '2017-07-03 15:05:46'),
(293, NULL, 'global', NULL, '2017-07-03 15:22:00', '2017-07-03 15:22:00'),
(294, NULL, 'ip', '220.247.236.118', '2017-07-03 15:22:00', '2017-07-03 15:22:00'),
(295, 8, 'user', NULL, '2017-07-03 15:22:00', '2017-07-03 15:22:00'),
(296, NULL, 'global', NULL, '2017-07-03 16:33:14', '2017-07-03 16:33:14'),
(297, NULL, 'ip', '220.247.236.118', '2017-07-03 16:33:14', '2017-07-03 16:33:14'),
(298, 7, 'user', NULL, '2017-07-03 16:33:14', '2017-07-03 16:33:14'),
(299, NULL, 'global', NULL, '2017-07-03 16:33:22', '2017-07-03 16:33:22'),
(300, NULL, 'ip', '220.247.236.118', '2017-07-03 16:33:22', '2017-07-03 16:33:22'),
(301, 7, 'user', NULL, '2017-07-03 16:33:22', '2017-07-03 16:33:22'),
(302, NULL, 'global', NULL, '2017-07-03 16:33:30', '2017-07-03 16:33:30'),
(303, NULL, 'ip', '220.247.236.118', '2017-07-03 16:33:30', '2017-07-03 16:33:30'),
(304, 7, 'user', NULL, '2017-07-03 16:33:30', '2017-07-03 16:33:30'),
(305, NULL, 'global', NULL, '2017-07-03 16:33:47', '2017-07-03 16:33:47'),
(306, NULL, 'ip', '220.247.236.118', '2017-07-03 16:33:47', '2017-07-03 16:33:47'),
(307, 3, 'user', NULL, '2017-07-03 16:33:47', '2017-07-03 16:33:47'),
(308, NULL, 'global', NULL, '2017-07-03 16:33:56', '2017-07-03 16:33:56'),
(309, NULL, 'ip', '220.247.236.118', '2017-07-03 16:33:56', '2017-07-03 16:33:56'),
(310, 3, 'user', NULL, '2017-07-03 16:33:56', '2017-07-03 16:33:56'),
(311, NULL, 'global', NULL, '2017-07-03 19:39:13', '2017-07-03 19:39:13'),
(312, NULL, 'ip', '220.247.236.118', '2017-07-03 19:39:13', '2017-07-03 19:39:13'),
(313, 3, 'user', NULL, '2017-07-03 19:39:13', '2017-07-03 19:39:13'),
(314, NULL, 'global', NULL, '2017-07-07 14:10:59', '2017-07-07 14:10:59'),
(315, NULL, 'ip', '220.247.236.118', '2017-07-07 14:10:59', '2017-07-07 14:10:59'),
(316, 3, 'user', NULL, '2017-07-07 14:10:59', '2017-07-07 14:10:59'),
(317, NULL, 'global', NULL, '2017-07-11 15:58:35', '2017-07-11 15:58:35'),
(318, NULL, 'ip', '220.247.202.227', '2017-07-11 15:58:35', '2017-07-11 15:58:35'),
(319, 3, 'user', NULL, '2017-07-11 15:58:35', '2017-07-11 15:58:35'),
(320, NULL, 'global', NULL, '2017-07-11 15:58:49', '2017-07-11 15:58:49'),
(321, NULL, 'ip', '220.247.202.227', '2017-07-11 15:58:49', '2017-07-11 15:58:49'),
(322, 3, 'user', NULL, '2017-07-11 15:58:49', '2017-07-11 15:58:49'),
(323, NULL, 'global', NULL, '2017-07-11 15:59:28', '2017-07-11 15:59:28'),
(324, NULL, 'ip', '220.247.202.227', '2017-07-11 15:59:28', '2017-07-11 15:59:28'),
(325, 3, 'user', NULL, '2017-07-11 15:59:28', '2017-07-11 15:59:28'),
(326, NULL, 'global', NULL, '2017-07-11 16:00:49', '2017-07-11 16:00:49'),
(327, NULL, 'ip', '162.244.81.106', '2017-07-11 16:00:49', '2017-07-11 16:00:49'),
(328, 2, 'user', NULL, '2017-07-11 16:00:49', '2017-07-11 16:00:49'),
(329, NULL, 'global', NULL, '2017-07-11 16:00:54', '2017-07-11 16:00:54'),
(330, NULL, 'ip', '162.244.81.106', '2017-07-11 16:00:54', '2017-07-11 16:00:54'),
(331, 2, 'user', NULL, '2017-07-11 16:00:54', '2017-07-11 16:00:54'),
(332, NULL, 'global', NULL, '2017-07-11 16:00:58', '2017-07-11 16:00:58'),
(333, NULL, 'ip', '162.244.81.106', '2017-07-11 16:00:58', '2017-07-11 16:00:58'),
(334, 2, 'user', NULL, '2017-07-11 16:00:58', '2017-07-11 16:00:58'),
(335, NULL, 'global', NULL, '2017-07-11 16:20:47', '2017-07-11 16:20:47'),
(336, NULL, 'ip', '220.247.236.118', '2017-07-11 16:20:47', '2017-07-11 16:20:47'),
(337, 8, 'user', NULL, '2017-07-11 16:20:47', '2017-07-11 16:20:47'),
(338, NULL, 'global', NULL, '2017-07-11 18:01:02', '2017-07-11 18:01:02'),
(339, NULL, 'ip', '220.247.202.227', '2017-07-11 18:01:02', '2017-07-11 18:01:02'),
(340, 2, 'user', NULL, '2017-07-11 18:01:02', '2017-07-11 18:01:02'),
(341, NULL, 'global', NULL, '2017-07-11 20:05:04', '2017-07-11 20:05:04'),
(342, NULL, 'ip', '220.247.236.118', '2017-07-11 20:05:04', '2017-07-11 20:05:04'),
(343, 6, 'user', NULL, '2017-07-11 20:05:04', '2017-07-11 20:05:04'),
(344, NULL, 'global', NULL, '2017-07-11 20:05:18', '2017-07-11 20:05:18'),
(345, NULL, 'ip', '220.247.236.118', '2017-07-11 20:05:18', '2017-07-11 20:05:18'),
(346, 3, 'user', NULL, '2017-07-11 20:05:18', '2017-07-11 20:05:18'),
(347, NULL, 'global', NULL, '2017-07-11 20:22:49', '2017-07-11 20:22:49'),
(348, NULL, 'ip', '220.247.236.118', '2017-07-11 20:22:49', '2017-07-11 20:22:49'),
(349, 3, 'user', NULL, '2017-07-11 20:22:49', '2017-07-11 20:22:49'),
(350, NULL, 'global', NULL, '2017-07-11 20:54:10', '2017-07-11 20:54:10'),
(351, NULL, 'ip', '220.247.236.118', '2017-07-11 20:54:10', '2017-07-11 20:54:10'),
(352, 7, 'user', NULL, '2017-07-11 20:54:10', '2017-07-11 20:54:10'),
(353, NULL, 'global', NULL, '2017-07-11 21:07:19', '2017-07-11 21:07:19'),
(354, NULL, 'ip', '220.247.236.118', '2017-07-11 21:07:19', '2017-07-11 21:07:19'),
(355, 3, 'user', NULL, '2017-07-11 21:07:19', '2017-07-11 21:07:19'),
(356, NULL, 'global', NULL, '2017-07-11 21:32:55', '2017-07-11 21:32:55'),
(357, NULL, 'ip', '220.247.236.118', '2017-07-11 21:32:55', '2017-07-11 21:32:55'),
(358, 8, 'user', NULL, '2017-07-11 21:32:55', '2017-07-11 21:32:55'),
(359, NULL, 'global', NULL, '2017-07-11 21:41:06', '2017-07-11 21:41:06'),
(360, NULL, 'ip', '220.247.236.118', '2017-07-11 21:41:06', '2017-07-11 21:41:06'),
(361, 3, 'user', NULL, '2017-07-11 21:41:06', '2017-07-11 21:41:06'),
(362, NULL, 'global', NULL, '2017-07-11 21:58:42', '2017-07-11 21:58:42'),
(363, NULL, 'ip', '220.247.236.118', '2017-07-11 21:58:42', '2017-07-11 21:58:42'),
(364, 3, 'user', NULL, '2017-07-11 21:58:42', '2017-07-11 21:58:42'),
(365, NULL, 'global', NULL, '2017-07-11 22:47:56', '2017-07-11 22:47:56'),
(366, NULL, 'ip', '220.247.236.118', '2017-07-11 22:47:56', '2017-07-11 22:47:56'),
(367, 3, 'user', NULL, '2017-07-11 22:47:56', '2017-07-11 22:47:56'),
(368, NULL, 'global', NULL, '2017-07-11 22:49:22', '2017-07-11 22:49:22'),
(369, NULL, 'ip', '220.247.236.118', '2017-07-11 22:49:22', '2017-07-11 22:49:22'),
(370, 9, 'user', NULL, '2017-07-11 22:49:22', '2017-07-11 22:49:22'),
(371, NULL, 'global', NULL, '2017-07-11 22:52:53', '2017-07-11 22:52:53'),
(372, NULL, 'ip', '220.247.236.118', '2017-07-11 22:52:53', '2017-07-11 22:52:53'),
(373, 3, 'user', NULL, '2017-07-11 22:52:53', '2017-07-11 22:52:53'),
(374, NULL, 'global', NULL, '2017-07-11 22:53:01', '2017-07-11 22:53:01'),
(375, NULL, 'ip', '220.247.236.118', '2017-07-11 22:53:01', '2017-07-11 22:53:01'),
(376, 3, 'user', NULL, '2017-07-11 22:53:01', '2017-07-11 22:53:01'),
(377, NULL, 'global', NULL, '2017-07-12 13:23:14', '2017-07-12 13:23:14'),
(378, NULL, 'ip', '220.247.236.118', '2017-07-12 13:23:14', '2017-07-12 13:23:14'),
(379, 3, 'user', NULL, '2017-07-12 13:23:14', '2017-07-12 13:23:14'),
(380, NULL, 'global', NULL, '2017-07-12 14:28:32', '2017-07-12 14:28:32'),
(381, NULL, 'ip', '220.247.236.118', '2017-07-12 14:28:32', '2017-07-12 14:28:32'),
(382, 10, 'user', NULL, '2017-07-12 14:28:32', '2017-07-12 14:28:32'),
(383, NULL, 'global', NULL, '2017-07-12 15:54:12', '2017-07-12 15:54:12'),
(384, NULL, 'ip', '220.247.236.118', '2017-07-12 15:54:12', '2017-07-12 15:54:12'),
(385, 11, 'user', NULL, '2017-07-12 15:54:12', '2017-07-12 15:54:12'),
(386, NULL, 'global', NULL, '2017-07-12 16:03:41', '2017-07-12 16:03:41'),
(387, NULL, 'ip', '220.247.236.118', '2017-07-12 16:03:41', '2017-07-12 16:03:41'),
(388, 3, 'user', NULL, '2017-07-12 16:03:41', '2017-07-12 16:03:41'),
(389, NULL, 'global', NULL, '2017-07-12 16:13:15', '2017-07-12 16:13:15'),
(390, NULL, 'ip', '220.247.236.118', '2017-07-12 16:13:15', '2017-07-12 16:13:15'),
(391, 11, 'user', NULL, '2017-07-12 16:13:15', '2017-07-12 16:13:15'),
(392, NULL, 'global', NULL, '2017-07-12 16:13:28', '2017-07-12 16:13:28'),
(393, NULL, 'ip', '220.247.236.118', '2017-07-12 16:13:28', '2017-07-12 16:13:28'),
(394, 11, 'user', NULL, '2017-07-12 16:13:28', '2017-07-12 16:13:28'),
(395, NULL, 'global', NULL, '2017-07-12 16:32:30', '2017-07-12 16:32:30'),
(396, NULL, 'ip', '220.247.236.118', '2017-07-12 16:32:30', '2017-07-12 16:32:30'),
(397, 3, 'user', NULL, '2017-07-12 16:32:30', '2017-07-12 16:32:30'),
(398, NULL, 'global', NULL, '2017-07-12 16:41:30', '2017-07-12 16:41:30'),
(399, NULL, 'ip', '220.247.236.118', '2017-07-12 16:41:30', '2017-07-12 16:41:30'),
(400, 3, 'user', NULL, '2017-07-12 16:41:30', '2017-07-12 16:41:30'),
(401, NULL, 'global', NULL, '2017-07-12 16:41:37', '2017-07-12 16:41:37'),
(402, NULL, 'ip', '220.247.236.118', '2017-07-12 16:41:37', '2017-07-12 16:41:37'),
(403, 3, 'user', NULL, '2017-07-12 16:41:37', '2017-07-12 16:41:37'),
(404, NULL, 'global', NULL, '2017-07-12 16:41:49', '2017-07-12 16:41:49'),
(405, NULL, 'ip', '220.247.236.118', '2017-07-12 16:41:49', '2017-07-12 16:41:49'),
(406, 3, 'user', NULL, '2017-07-12 16:41:49', '2017-07-12 16:41:49'),
(407, NULL, 'global', NULL, '2017-07-12 16:48:28', '2017-07-12 16:48:28'),
(408, NULL, 'ip', '220.247.236.118', '2017-07-12 16:48:28', '2017-07-12 16:48:28'),
(409, 13, 'user', NULL, '2017-07-12 16:48:28', '2017-07-12 16:48:28'),
(410, NULL, 'global', NULL, '2017-07-12 16:49:38', '2017-07-12 16:49:38'),
(411, NULL, 'ip', '220.247.236.118', '2017-07-12 16:49:38', '2017-07-12 16:49:38'),
(412, 12, 'user', NULL, '2017-07-12 16:49:38', '2017-07-12 16:49:38'),
(413, NULL, 'global', NULL, '2017-07-12 18:54:09', '2017-07-12 18:54:09'),
(414, NULL, 'ip', '220.247.236.118', '2017-07-12 18:54:09', '2017-07-12 18:54:09'),
(415, 13, 'user', NULL, '2017-07-12 18:54:09', '2017-07-12 18:54:09'),
(416, NULL, 'global', NULL, '2017-07-12 11:36:33', '2017-07-12 11:36:33'),
(417, NULL, 'ip', '::1', '2017-07-12 11:36:33', '2017-07-12 11:36:33'),
(418, 2, 'user', NULL, '2017-07-12 11:36:33', '2017-07-12 11:36:33'),
(419, NULL, 'global', NULL, '2017-07-12 11:44:26', '2017-07-12 11:44:26'),
(420, NULL, 'ip', '::1', '2017-07-12 11:44:26', '2017-07-12 11:44:26'),
(421, 2, 'user', NULL, '2017-07-12 11:44:26', '2017-07-12 11:44:26'),
(422, NULL, 'global', NULL, '2017-07-12 12:20:10', '2017-07-12 12:20:10'),
(423, NULL, 'ip', '::1', '2017-07-12 12:20:11', '2017-07-12 12:20:11'),
(424, 1, 'user', NULL, '2017-07-12 12:20:11', '2017-07-12 12:20:11'),
(425, NULL, 'global', NULL, '2017-07-13 17:12:41', '2017-07-13 17:12:41'),
(426, NULL, 'ip', '127.0.0.1', '2017-07-13 17:12:41', '2017-07-13 17:12:41'),
(427, 2, 'user', NULL, '2017-07-13 17:12:41', '2017-07-13 17:12:41'),
(428, NULL, 'global', NULL, '2017-07-17 04:37:00', '2017-07-17 04:37:00'),
(429, NULL, 'ip', '127.0.0.1', '2017-07-17 04:37:00', '2017-07-17 04:37:00'),
(430, 2, 'user', NULL, '2017-07-17 04:37:00', '2017-07-17 04:37:00'),
(431, NULL, 'global', NULL, '2017-07-17 07:38:38', '2017-07-17 07:38:38'),
(432, NULL, 'ip', '127.0.0.1', '2017-07-17 07:38:38', '2017-07-17 07:38:38'),
(433, 2, 'user', NULL, '2017-07-17 07:38:38', '2017-07-17 07:38:38'),
(434, NULL, 'global', NULL, '2017-07-18 21:10:14', '2017-07-18 21:10:14'),
(435, NULL, 'ip', '220.247.202.227', '2017-07-18 21:10:14', '2017-07-18 21:10:14'),
(436, 2, 'user', NULL, '2017-07-18 21:10:14', '2017-07-18 21:10:14'),
(437, NULL, 'global', NULL, '2017-07-18 21:19:22', '2017-07-18 21:19:22'),
(438, NULL, 'ip', '220.247.236.118', '2017-07-18 21:19:22', '2017-07-18 21:19:22'),
(439, 4, 'user', NULL, '2017-07-18 21:19:22', '2017-07-18 21:19:22'),
(440, NULL, 'global', NULL, '2017-07-18 21:39:47', '2017-07-18 21:39:47'),
(441, NULL, 'ip', '175.157.182.61', '2017-07-18 21:39:47', '2017-07-18 21:39:47'),
(442, 5, 'user', NULL, '2017-07-18 21:39:47', '2017-07-18 21:39:47'),
(443, NULL, 'global', NULL, '2017-07-19 15:28:19', '2017-07-19 15:28:19'),
(444, NULL, 'ip', '175.157.23.194', '2017-07-19 15:28:19', '2017-07-19 15:28:19'),
(445, 4, 'user', NULL, '2017-07-19 15:28:19', '2017-07-19 15:28:19'),
(446, NULL, 'global', NULL, '2017-07-19 16:06:51', '2017-07-19 16:06:51'),
(447, NULL, 'ip', '175.157.162.16', '2017-07-19 16:06:51', '2017-07-19 16:06:51'),
(448, 1, 'user', NULL, '2017-07-19 16:06:51', '2017-07-19 16:06:51'),
(449, NULL, 'global', NULL, '2017-07-20 22:46:58', '2017-07-20 22:46:58'),
(450, NULL, 'ip', '220.247.236.118', '2017-07-20 22:46:58', '2017-07-20 22:46:58'),
(451, 4, 'user', NULL, '2017-07-20 22:46:58', '2017-07-20 22:46:58'),
(452, NULL, 'global', NULL, '2017-07-21 16:50:49', '2017-07-21 16:50:49'),
(453, NULL, 'ip', '112.134.7.109', '2017-07-21 16:50:49', '2017-07-21 16:50:49'),
(454, 3, 'user', NULL, '2017-07-21 16:50:49', '2017-07-21 16:50:49'),
(455, NULL, 'global', NULL, '2017-07-21 16:51:00', '2017-07-21 16:51:00'),
(456, NULL, 'ip', '112.134.7.109', '2017-07-21 16:51:00', '2017-07-21 16:51:00'),
(457, 3, 'user', NULL, '2017-07-21 16:51:00', '2017-07-21 16:51:00'),
(458, NULL, 'global', NULL, '2017-07-21 16:53:46', '2017-07-21 16:53:46'),
(459, NULL, 'ip', '112.134.7.109', '2017-07-21 16:53:46', '2017-07-21 16:53:46'),
(460, 3, 'user', NULL, '2017-07-21 16:53:46', '2017-07-21 16:53:46'),
(461, NULL, 'global', NULL, '2017-07-21 17:00:11', '2017-07-21 17:00:11'),
(462, NULL, 'ip', '112.134.7.109', '2017-07-21 17:00:11', '2017-07-21 17:00:11'),
(463, 4, 'user', NULL, '2017-07-21 17:00:11', '2017-07-21 17:00:11'),
(464, NULL, 'global', NULL, '2017-07-21 17:46:32', '2017-07-21 17:46:32'),
(465, NULL, 'ip', '112.134.7.109', '2017-07-21 17:46:32', '2017-07-21 17:46:32'),
(466, 3, 'user', NULL, '2017-07-21 17:46:32', '2017-07-21 17:46:32'),
(467, NULL, 'global', NULL, '2017-07-21 19:31:05', '2017-07-21 19:31:05'),
(468, NULL, 'ip', '112.134.7.109', '2017-07-21 19:31:05', '2017-07-21 19:31:05'),
(469, 3, 'user', NULL, '2017-07-21 19:31:05', '2017-07-21 19:31:05'),
(470, NULL, 'global', NULL, '2017-07-21 19:56:43', '2017-07-21 19:56:43'),
(471, NULL, 'ip', '112.134.7.109', '2017-07-21 19:56:43', '2017-07-21 19:56:43'),
(472, 4, 'user', NULL, '2017-07-21 19:56:43', '2017-07-21 19:56:43'),
(473, NULL, 'global', NULL, '2017-07-21 21:31:25', '2017-07-21 21:31:25'),
(474, NULL, 'ip', '112.134.7.109', '2017-07-21 21:31:25', '2017-07-21 21:31:25'),
(475, 5, 'user', NULL, '2017-07-21 21:31:25', '2017-07-21 21:31:25'),
(476, NULL, 'global', NULL, '2017-07-21 23:24:04', '2017-07-21 23:24:04'),
(477, NULL, 'ip', '112.134.7.109', '2017-07-21 23:24:04', '2017-07-21 23:24:04'),
(478, 3, 'user', NULL, '2017-07-21 23:24:04', '2017-07-21 23:24:04'),
(479, NULL, 'global', NULL, '2017-07-22 15:19:45', '2017-07-22 15:19:45'),
(480, NULL, 'ip', '112.134.7.231', '2017-07-22 15:19:45', '2017-07-22 15:19:45'),
(481, 35, 'user', NULL, '2017-07-22 15:19:45', '2017-07-22 15:19:45'),
(482, NULL, 'global', NULL, '2017-07-22 06:14:03', '2017-07-22 06:14:03'),
(483, NULL, 'ip', '127.0.0.1', '2017-07-22 06:14:03', '2017-07-22 06:14:03'),
(484, 12, 'user', NULL, '2017-07-22 06:14:03', '2017-07-22 06:14:03'),
(485, NULL, 'global', NULL, '2017-07-31 19:12:05', '2017-07-31 19:12:05'),
(486, NULL, 'ip', '23.247.147.5', '2017-07-31 19:12:05', '2017-07-31 19:12:05'),
(487, 2, 'user', NULL, '2017-07-31 19:12:05', '2017-07-31 19:12:05'),
(488, NULL, 'global', NULL, '2017-07-31 21:29:04', '2017-07-31 21:29:04'),
(489, NULL, 'ip', '220.247.236.118', '2017-07-31 21:29:04', '2017-07-31 21:29:04'),
(490, 2, 'user', NULL, '2017-07-31 21:29:04', '2017-07-31 21:29:04'),
(491, NULL, 'global', NULL, '2017-07-31 21:51:46', '2017-07-31 21:51:46'),
(492, NULL, 'ip', '220.247.202.227', '2017-07-31 21:51:46', '2017-07-31 21:51:46'),
(493, 6, 'user', NULL, '2017-07-31 21:51:46', '2017-07-31 21:51:46'),
(494, NULL, 'global', NULL, '2017-08-01 03:41:45', '2017-08-01 03:41:45'),
(495, NULL, 'ip', '172.16.1.223', '2017-08-01 03:41:45', '2017-08-01 03:41:45'),
(496, 2, 'user', NULL, '2017-08-01 03:41:45', '2017-08-01 03:41:45'),
(497, NULL, 'global', NULL, '2017-08-01 03:41:51', '2017-08-01 03:41:51'),
(498, NULL, 'ip', '172.16.1.223', '2017-08-01 03:41:51', '2017-08-01 03:41:51'),
(499, 2, 'user', NULL, '2017-08-01 03:41:51', '2017-08-01 03:41:51'),
(500, NULL, 'global', NULL, '2017-08-01 03:59:26', '2017-08-01 03:59:26'),
(501, NULL, 'ip', '172.16.1.223', '2017-08-01 03:59:26', '2017-08-01 03:59:26'),
(502, 3, 'user', NULL, '2017-08-01 03:59:26', '2017-08-01 03:59:26'),
(503, NULL, 'global', NULL, '2017-08-01 04:42:06', '2017-08-01 04:42:06'),
(504, NULL, 'ip', '172.16.1.223', '2017-08-01 04:42:06', '2017-08-01 04:42:06'),
(505, 2, 'user', NULL, '2017-08-01 04:42:06', '2017-08-01 04:42:06'),
(506, NULL, 'global', NULL, '2017-08-01 04:53:17', '2017-08-01 04:53:17'),
(507, NULL, 'ip', '172.16.1.223', '2017-08-01 04:53:17', '2017-08-01 04:53:17'),
(508, 6, 'user', NULL, '2017-08-01 04:53:17', '2017-08-01 04:53:17'),
(509, NULL, 'global', NULL, '2017-08-01 05:10:13', '2017-08-01 05:10:13'),
(510, NULL, 'ip', '172.16.1.223', '2017-08-01 05:10:13', '2017-08-01 05:10:13'),
(511, 2, 'user', NULL, '2017-08-01 05:10:13', '2017-08-01 05:10:13'),
(512, NULL, 'global', NULL, '2017-08-01 05:34:29', '2017-08-01 05:34:29'),
(513, NULL, 'ip', '172.16.1.223', '2017-08-01 05:34:29', '2017-08-01 05:34:29'),
(514, 3, 'user', NULL, '2017-08-01 05:34:29', '2017-08-01 05:34:29'),
(515, NULL, 'global', NULL, '2017-08-01 06:29:49', '2017-08-01 06:29:49'),
(516, NULL, 'ip', '172.16.1.223', '2017-08-01 06:29:49', '2017-08-01 06:29:49'),
(517, 2, 'user', NULL, '2017-08-01 06:29:49', '2017-08-01 06:29:49'),
(518, NULL, 'global', NULL, '2017-08-01 08:44:25', '2017-08-01 08:44:25'),
(519, NULL, 'ip', '172.16.1.223', '2017-08-01 08:44:25', '2017-08-01 08:44:25'),
(520, 2, 'user', NULL, '2017-08-01 08:44:25', '2017-08-01 08:44:25'),
(521, NULL, 'global', NULL, '2017-08-01 10:48:21', '2017-08-01 10:48:21'),
(522, NULL, 'ip', '172.16.1.138', '2017-08-01 10:48:22', '2017-08-01 10:48:22'),
(523, 1, 'user', NULL, '2017-08-01 10:48:22', '2017-08-01 10:48:22'),
(524, NULL, 'global', NULL, '2017-08-01 11:35:06', '2017-08-01 11:35:06'),
(525, NULL, 'ip', '172.16.1.223', '2017-08-01 11:35:06', '2017-08-01 11:35:06'),
(526, 2, 'user', NULL, '2017-08-01 11:35:06', '2017-08-01 11:35:06'),
(527, NULL, 'global', NULL, '2017-08-03 05:54:34', '2017-08-03 05:54:34'),
(528, NULL, 'ip', '127.0.0.1', '2017-08-03 05:54:34', '2017-08-03 05:54:34'),
(529, 2, 'user', NULL, '2017-08-03 05:54:34', '2017-08-03 05:54:34'),
(530, NULL, 'global', NULL, '2017-08-03 05:54:42', '2017-08-03 05:54:42'),
(531, NULL, 'ip', '127.0.0.1', '2017-08-03 05:54:42', '2017-08-03 05:54:42'),
(532, 2, 'user', NULL, '2017-08-03 05:54:42', '2017-08-03 05:54:42');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `permissions` text NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `employee_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_employee1_idx` (`employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `permissions`, `last_login`, `status`, `created_at`, `updated_at`, `deleted_at`, `employee_id`) VALUES
(1, 'super.admin', '$2y$10$3zFnSkntqIBEFwf4/eSDvuOhSkWRKTpKnaVRoG6KLTpO4SJ7eSVW2', '{"admin":true,"index":true}', '2017-08-03 12:43:12', 1, '2017-02-06 06:00:00', '2017-08-03 12:43:12', NULL, 1),
(2, 'Admin001', '$2y$10$l35ykfdPav63R41CJapZ1eov6NPbAbfdKJsTOwVkP.A2kFhRPOJjy', '', '2017-08-03 12:21:21', 1, '2017-07-21 15:29:02', '2017-08-03 12:21:21', NULL, 2),
(3, '012113', '$2y$10$TCToYa0YaobAwa994hATAeiN72AgJUS702tUPOW6inq8erEAn4E1y', '', '2017-08-03 11:42:42', 1, '2017-07-31 20:11:10', '2017-08-03 11:42:42', NULL, 6),
(4, '011846', '$2y$10$88Z1/5Ouejyk.f/d3wXs5eMFOLTe67xz0C9CHwqYanAVdmWuO37Ia', '', NULL, 1, '2017-07-31 20:12:39', '2017-07-31 15:12:39', NULL, 4),
(5, '011786', '$2y$10$7bkCn94JXfMg5mtGfzrFDOxFeObHXYD2tdUitbSSstJkJMRF5BS0G', '', '2017-08-01 16:58:30', 1, '2017-07-31 20:12:58', '2017-08-01 16:58:30', NULL, 5),
(6, '010010', '$2y$10$pwxoXUUWcARgehIWdIUO2u0i7eANnspOf8QLBd9r1UO2Eo8kZXXnK', '', '2017-08-03 12:24:35', 1, '2017-07-31 20:13:19', '2017-08-03 12:24:35', NULL, 7),
(7, '012036', '$2y$10$BJND9t9nDmd/6xk9Opy5duPTm8YLd9DATXpgcYsS2DaZjSVKLUCLa', '', NULL, 1, '2017-07-31 20:13:37', '2017-07-31 15:13:37', NULL, 3),
(8, '011527', '$2y$10$R7R9TdzTrE71xGij2KCvQ.Mvc7Xwmo1oKtj.Gt.9a1FC1BLI6eHGm', '', '2017-08-01 15:33:03', 1, '2017-08-01 02:58:50', '2017-08-01 15:33:03', NULL, 9);

-- --------------------------------------------------------

--
-- Table structure for table `user_location`
--

CREATE TABLE IF NOT EXISTS `user_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `user_location`
--

INSERT INTO `user_location` (`id`, `location_id`, `employee_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, '2017-07-31 08:41:05', NULL, NULL),
(2, 1, 3, '2017-07-31 20:03:48', '2017-07-31 15:03:48', NULL),
(3, 1, 4, '2017-07-31 20:05:08', '2017-07-31 15:05:08', NULL),
(4, 4, 5, '2017-07-31 20:07:42', '2017-07-31 15:07:42', NULL),
(5, 6, 6, '2017-07-31 20:08:52', '2017-07-31 15:08:52', NULL),
(6, 8, 7, '2017-07-31 20:10:04', '2017-07-31 15:10:04', NULL),
(7, 8, 8, '2017-07-31 21:30:07', '2017-07-31 16:30:07', NULL),
(8, 2, 9, '2017-08-01 02:58:12', '2017-08-01 08:28:12', NULL),
(9, 12, 10, '2017-08-01 03:01:54', '2017-08-01 08:31:54', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
