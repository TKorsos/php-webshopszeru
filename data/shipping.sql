-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2024. Már 02. 15:41
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
-- Tábla szerkezet ehhez a táblához `shipping`
--

CREATE TABLE `shipping` (
  `id` int(11) NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `shipping`
--

INSERT INTO `shipping` (`id`, `type`, `status`, `created_at`) VALUES
(1, 'Átvételi pontba kérem', 'process', '2023-12-13 16:17:49'),
(2, 'Házhoz szállítás', 'process', '2023-12-13 16:17:52'),
(3, 'Boltban veszem át', 'process', '2023-12-13 16:18:32');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
