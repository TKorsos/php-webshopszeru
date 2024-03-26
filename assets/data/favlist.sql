-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2024. Már 26. 11:26
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
-- Tábla szerkezet ehhez a táblához `favlist`
--

CREATE TABLE `favlist` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `favlist`
--

INSERT INTO `favlist` (`id`, `userid`, `productid`, `created_at`) VALUES
(1, 5, 1, '2024-03-25 14:13:51'),
(3, 28, 1, '2024-03-25 14:27:39'),
(4, 28, 5, '2024-03-25 14:27:51'),
(5, 2, 21, '2024-03-25 14:44:36'),
(6, 2, 1, '2024-03-25 14:44:46'),
(7, 28, 21, '2024-03-25 14:54:10'),
(8, 28, 12, '2024-03-25 18:51:36'),
(9, 2, 13, '2024-03-25 18:51:46'),
(10, 28, 2, '2024-03-26 10:33:56'),
(11, 28, 4, '2024-03-26 10:42:36'),
(12, 5, 2, '2024-03-26 10:43:57'),
(13, 10, 11, '2024-03-26 10:46:40'),
(14, 10, 16, '2024-03-26 10:46:55'),
(16, 28, 6, '2024-03-26 11:11:38'),
(17, 28, 7, '2024-03-26 11:18:29'),
(18, 24, 2, '2024-03-26 11:19:47'),
(19, 24, 18, '2024-03-26 11:19:58'),
(20, 24, 21, '2024-03-26 11:20:21');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `favlist`
--
ALTER TABLE `favlist`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `favlist`
--
ALTER TABLE `favlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
