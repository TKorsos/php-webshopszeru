-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2024. Jan 12. 13:24
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
(7, 3, 'Vörös Mihály', 'vmihaly@mail.com', 'Tetszik a színválaszték bősége és megfelelő a munkámhoz.', '2024-01-12 13:21:33', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
