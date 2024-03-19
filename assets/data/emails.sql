-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2024. Már 19. 13:23
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
-- Tábla szerkezet ehhez a táblához `emails`
--

CREATE TABLE `emails` (
  `id` int(11) NOT NULL,
  `contact_name` varchar(60) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_email` varchar(60) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_subject` varchar(60) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_message` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `emails`
--

INSERT INTO `emails` (`id`, `contact_name`, `contact_email`, `contact_subject`, `contact_message`, `created_at`) VALUES
(1, 'Tóbiás János', 'tobias@mail.hu', 'Kérdés', 'Üdv! Azt szeretném kérdezni hogy hétvégén hogy vannak nyitva?', '2024-03-19 11:21:07'),
(2, 'Nagy Éva', 'neva@info.hu', 'Kérdés', 'Üdv! Milyen egérpad kapható önöknél?', '2024-03-19 11:22:51'),
(3, 'Pici Mici', 'picimici@pici.hu', 'Kérdés', 'Üdv! Egér lesz-e kapható majd az üzletükben?', '2024-03-19 11:23:38');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
