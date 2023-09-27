-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2023. Sze 14. 13:16
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
-- Adatbázis: `gyakorlas`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `about_me` text,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `zip` int(4) NOT NULL,
  `city` varchar(40) DEFAULT NULL,
  `street` varchar(40) DEFAULT NULL,
  `nr` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `about_me`, `email`, `password`, `zip`, `city`, `street`, `nr`, `created_at`) VALUES
(2, 'Kovács', 'János', 'Szeretem a programozást ', 'info@teszt.dev', 'teszt', 5600, 'Békéscsaba', 'Jókai utca ', '444', '2022-03-10 15:26:14'),
(3, 'Nagy', 'Mária', 'Szeretem a webfejlesztést, jelenleg éppen tanulom ', 'info@teszt2.dev', 'teszt2', 6300, 'Kalocsa', 'Teszt utca ', '444', '2022-03-10 15:30:11'),
(4, 'Lakatos', 'Géza', 'Szeretem a természetet', 'lakage@gmail.com', '12121212112', 8127, 'Aba', 'Lakályos utca', '1298', '2022-03-10 15:44:05'),
(5, 'Kováts', 'Kinag', 'Szeretem a fagyit és a jégkrémet', 'kkinga@mail.com', 'lakat', 4400, 'Nyíregyháza', 'Molnár Piroska utca', '721', '2022-05-23 14:44:26'),
(6, 'Lovászi', 'Tekla', 'Szeretem a lovakat', 'lovassi@mail.com', 'lovaslovaslovas', 7130, 'Tolna', 'Petőfi Sándor utca', '129', '2022-05-23 14:50:11'),
(7, 'Kovách', 'Gábor', 'Szeretem a nyulakat és az alpakákat is', 'k.nagy@mail.com', '12345', 6500, 'Baja', 'Petőfi Sándor utca', '321', '2022-05-23 15:35:00'),
(8, 'Lengyel', 'Lilla', 'Szeretem a fát', 'l.lilla@mail.com', '123g4g5', 6500, 'Baja', 'Petőfi Sándor utca', '521', '2022-05-23 14:57:50'),
(9, 'Szegedi', 'János', 'Szeretem a magyaros kajákat', 'szegedij19@gmail.com', '12341121', 6500, 'Baja', 'Szegedi út', '129', '2022-05-23 15:34:48'),
(10, 'Bodnár', 'László', 'Szeretem a hordókat', 'b.laszlo@gmail.com', 'bodnar', 1022, 'Budapest', 'Révész utca', '123', '2022-05-24 14:07:28'),
(11, 'Kiss', 'Evelin', 'Szeretem a hajókat', 'kevelin@gmail.com', 'keve0123', 4400, 'Nyíregyháza', 'Tavasz út', '127', '2022-05-24 14:09:09'),
(12, 'Zenthe', 'József', 'Szeretem a taxikat', 'zenthe.j@mail.com', '123456', 1120, 'Budapest', 'Alajos utca', '12', '2022-05-24 14:15:21'),
(13, 'Tóth', 'Enikő', 'Szeretem az egyszarvúakat', 'teni@gmail.com', 'titkos', 6500, 'Baja', 'Szabad utca', '127', '2022-05-24 14:29:30');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
