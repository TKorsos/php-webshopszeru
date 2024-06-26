-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2024. Ápr 05. 09:10
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
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `billing_name` varchar(60) DEFAULT NULL,
  `country` varchar(60) DEFAULT NULL,
  `zip` int(4) NOT NULL,
  `city` varchar(40) DEFAULT NULL,
  `street` varchar(40) DEFAULT NULL,
  `nr` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `billing_name`, `country`, `zip`, `city`, `street`, `nr`, `created_at`, `updated_at`) VALUES
(2, 'Kovács', 'János', 'info@teszt.dev', 'teszt', '+36101234568', 'Kovács János', 'Magyarország', 5600, 'Békéscsaba', 'Jókai utca ', '444', '2022-03-10 15:26:14', '2023-12-11 21:12:36'),
(3, 'Nagy', 'Mária', 'info@teszt2.dev', 'teszt2', '+36124567896', 'Nagy Mária', 'Magyarország', 6300, 'Kalocsa', 'Teszt utca ', '444', '2022-03-10 15:30:11', '2023-12-11 21:12:16'),
(4, 'Lakatos', 'Géza', 'lakage@gmail.com', '12121212112', '+36105557896', 'Lakatos Géza', 'Magyarország', 8127, 'Aba', 'Lakályos utca', '1298', '2022-03-10 15:44:05', '2023-12-11 21:34:17'),
(5, 'Kováts', 'Kinga', 'kkinga@mail.com', 'lakat', '+36101214569', 'Kováts Kinga', 'Magyarország', 4400, 'Nyíregyháza', 'Molnár Piroska utca', '721', '2022-05-23 14:44:26', '2023-12-11 21:15:03'),
(6, 'Lovászi', 'Tekla', 'lovassi@mail.com', 'lovaslovaslovas', '+36127573265', 'Lovászi Tekla', 'Magyarország', 7130, 'Tolna', 'Petőfi Sándor utca', '129', '2022-05-23 14:50:11', '2023-12-11 21:16:12'),
(7, 'Kovách', 'Gábor', 'k.nagy@mail.com', '12345', '+36104475588', 'Kovách Gábor', 'Magyarország', 6500, 'Baja', 'Petőfi Sándor utca', '321', '2022-05-23 15:35:00', '2024-01-05 15:12:59'),
(8, 'Lengyel', 'Lilla', 'l.lilla@mail.com', '123g4g5', '+36125549986', 'Lengyel Lilla', 'Magyarország', 6500, 'Baja', 'Petőfi Sándor utca', '521', '2022-05-23 14:57:50', '2023-12-11 21:17:26'),
(9, 'Szegedi', 'János', 'szegedij19@gmail.com', '12341121', '+36105597788', 'Szegedi János', 'Magyarország', 6500, 'Baja', 'Szegedi út', '129', '2022-05-23 15:34:48', '2024-01-05 15:13:25'),
(10, 'Bodnár', 'László', 'b.laszlo@gmail.com', 'bodnar', '+36104781125', 'Bodnár László', 'Magyarország', 1022, 'Budapest', 'Révész utca', '123', '2022-05-24 14:07:28', '2023-12-11 21:19:19'),
(11, 'Kiss', 'Evelin', 'kevelin@gmail.com', 'keve0123', '+36122007845', 'Kiss Evelin', 'Magyarország', 4400, 'Nyíregyháza', 'Tavasz út', '127', '2022-05-24 14:09:09', '2023-12-11 21:20:11'),
(12, 'Zenthe', 'József', 'zenthe.j@mail.com', '123456', '+36100107849', 'Zenthe József', 'Magyarország', 1120, 'Budapest', 'Alajos utca', '12', '2022-05-24 14:15:21', '2023-12-11 21:30:01'),
(13, 'Tóth', 'Enikő', 'teni@gmail.com', 'titkos', '+36127981412', 'Tóth Enikő', 'Magyarország', 6500, 'Baja', 'Szabad utca', '127', '2022-05-24 14:29:30', '2024-01-05 15:13:35'),
(16, 'Gipsz', 'Jakab', 'gjakab@mail.com', '12345678', '+36121105937', 'Gipsz Jakab', 'Magyarország', 1022, 'Budapest', 'Tavasz utca', '77', '2023-12-12 17:36:04', NULL),
(17, 'Debreceni', 'László', 'dlaszlo@mail.hu', 'huzat000', '+36105491128', 'Debreceni László', 'Magyarország', 3200, 'Gyöngyös', 'Petőfi utca', '17', '2023-12-12 17:43:15', NULL),
(18, 'Takács', 'Péter', 'ptakacs@gmail.com', '12344321', '+36102156987', 'Takács Péter', 'Magyarország', 9000, 'Győr', 'Nyugat utca', '19', '2023-12-12 17:51:00', NULL),
(19, 'Vörös', 'János', 'vjanos@gmail.com', 'vjani1212', '+36124967712', 'Vörös János', 'Magyarország', 8243, 'Balatonakali', 'Balaton utca', '5', '2023-12-12 17:55:26', NULL),
(20, 'Nagy', 'Zita', 'nzita@mail.com', 'nzita123', '+36105557846', 'Nagy Zita', 'Magyarország', 3348, 'Szilvásvárad', 'Hegyi utca', '10', '2023-12-12 17:58:19', NULL),
(22, 'Magyar', 'Péter', 'mpeter@teszt.dev', 'teszt222', '+36105551271', 'Magyar Péter', 'Magyarország', 1044, 'Budapest', 'Tésztaszűrő utca', '77', '2024-01-06 12:25:49', NULL),
(23, 'Harang', 'Virág', 'haravirag@teszt.dev', 'harangvirag', '+36121794578', 'Harang Virág', 'Magyarország', 1022, 'Budapest', 'Ibolya utca', '17', '2024-01-06 12:52:55', NULL),
(24, 'Ügyet', 'Lenke', 'ugyet@lenke.hu', 'ablakzsiraf', '+36105498789', 'Ügyet Lenke Irén', 'Magyarország', 1044, 'Budapest', 'Bécsi utca', '135', '2024-01-08 12:57:48', '2024-01-10 13:39:36'),
(25, 'Admin', 'Admin', 'admin@info.hu', 'admin', '+36121231234', 'Admin Admin', 'Magyarország', 1022, 'Budapest', 'Tököl utca', '19', '2024-02-15 23:56:23', NULL),
(26, 'Magyar', 'József', 'mjozsef@info.hu', 'jelszo12', '+36124445555', 'Magyar József', 'Magyarország', 6000, 'Kecskemét', 'József Attila utca', '39', '2024-02-16 12:42:43', NULL),
(27, 'Halasi', 'Dóra', 'dora@email.hu', '11223344', '+36124445454', 'Halasi Dóra', 'Magyarország', 1022, 'Budapest', 'Tiszta utca', '121', '2024-02-16 14:37:14', NULL),
(28, 'Teszt', 'Elek', 'tesztelek@info.hu', '11223344', '+36124567892', 'Teszt Elek', 'Magyarország', 1023, 'Budapest', 'Szent Isvtán király utca', '19', '2024-02-16 15:16:23', '2024-03-22 11:42:50'),
(29, 'Szabadi', 'Éva', 'szeva@gmail.com', '1234512345', '+36105497878', 'Szabadi Éva', 'Magyarország', 1024, 'Budapest', 'Titkos utca', '1', '2024-02-16 18:01:43', '2024-02-16 18:36:02'),
(30, 'Havas', 'Mihály', 'hmisi@email.com', '111222333', '+36121256541', 'Havas Mihály', 'Magyarország', 1023, 'Budapest', 'Zöldellő utca', '127', '2024-02-16 18:44:20', NULL),
(31, 'Tiszta', 'Tibor', 'titi@gmail.com', '123123123', '+36105469878', 'Tiszta Tibor', 'Magyarország', 1024, 'Budapest', 'Lánchíd utca', '12', '2024-02-16 18:50:15', NULL),
(32, 'Minta', 'Polgár', 'mpolgar@mail.hu', '123321123', '+36104976523', 'Minta Polgár', 'Magyarország', 1022, 'Budapest', 'Kiss László utca', '1', '2024-02-16 18:52:59', NULL),
(33, 'Tóth', 'Tamás', 'ttom@mail.com', '22112211', '+36120014510', 'Tóth Tamás', 'Magyarország', 1024, 'Budapest', 'Tóth Mike utca', '27', '2024-02-16 19:07:44', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
