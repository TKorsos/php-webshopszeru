-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2024. Már 05. 16:12
-- Kiszolgáló verziója: 8.0.17
-- PHP verzió: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `pcshop`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `termek_id` int(11) DEFAULT NULL,
  `comment_name` varchar(60) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `comment_email` varchar(60) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `comment_message` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `comment`
--

INSERT INTO `comment` (`id`, `termek_id`, `comment_name`, `comment_email`, `comment_message`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kovács János', 'info@teszt.dev', 'Ez egy igen jó termék.', '2024-01-12 10:53:40', NULL),
(2, 1, 'Nagy József', 'njozsef@mail.com', 'Ez egy egész jó termék.', '2024-01-12 10:54:27', NULL),
(3, 3, 'Kiss Péter', 'kissp@mail.com', 'Ez nekem nem annyira tetszik.', '2024-01-12 11:06:41', NULL),
(4, 2, 'Molnár István', 'imolnar@mail.com', 'Ez a termék pont jó nekem.', '2024-01-12 11:54:58', NULL),
(5, 1, 'Kincses József', 'kjoseph@mail.com', 'Sajnos a kapott termék hibás volt.', '2024-01-12 11:56:33', NULL),
(6, 2, 'Kovács János', 'kjanos@mail.com', 'Ez az amit szerettem volna megvásárolni.', '2024-01-12 12:18:08', NULL),
(7, 3, 'Vörös Mihály', 'vmihaly@mail.com', 'Tetszik a színválaszték bősége és megfelelő a munkámhoz.', '2024-01-12 13:21:33', NULL),
(8, 1, 'Teszt Elek', 'teszt@elek.hu', 'Teszt üzenet!', '2024-01-12 19:22:03', NULL),
(9, 3, 'Nagy János', 'njanos@mail.com', 'Teszt üzenet2!', '2024-02-16 14:54:07', NULL),
(10, 4, 'Gipsz Jakab', 'gjakab@gmail.com', 'Teszt üzenet3!', '2024-02-16 14:59:30', NULL),
(11, 2, 'Nagy Mária', 'mary@gmail.com', 'Teszt üzenet4!', '2024-02-16 15:01:52', NULL),
(12, 5, 'Nagy László', 'nlaci@email.hu', 'Teszt üzenet xy.', '2024-02-16 18:55:42', NULL),
(13, 5, 'Hajós Nóra', 'hnora@mail.com', 'Teszt üzenet xyz.', '2024-02-16 19:09:00', NULL),
(14, 5, 'Pintér Ákos', 'pakos@gmail.com', 'Teszt üzenet folytatása.', '2024-02-16 19:13:33', NULL),
(15, 5, 'Molnár Péter', 'pmolnar@email.hu', 'Teszt üzenet.', '2024-02-16 19:24:05', NULL),
(16, 6, 'Bagó Ilona', 'bilona@mail.com', 'Teszt üzenet.', '2024-02-16 19:24:50', NULL),
(17, 1, 'Váradi Bence', 'vbence@gmail.com', 'Teszt üzenet folytatása 2.', '2024-02-18 11:34:45', NULL),
(18, 2, 'Pici Mici', 'pmici@gmail.com', 'Ez egy teszt üzenet Picitől!', '2024-02-18 22:40:30', NULL),
(19, 7, 'Teszt Elek', 'tesztelek@info.hu', 'Nagyon meg vagyok vele elégedve.', '2024-02-19 14:45:55', NULL),
(20, 3, 'Hajnal Ivett', 'hajnal@info.hu', 'Ez egy igazán kíváló termék.', '2024-03-05 16:09:09', NULL);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
