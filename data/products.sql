-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2023. Dec 11. 22:39
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
-- Tábla szerkezet ehhez a táblához `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `special_price` int(11) DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `manufacturer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `visit_count` int(11) NOT NULL DEFAULT '0',
  `order_count` int(11) NOT NULL DEFAULT '0',
  `main_signed` tinyint(1) NOT NULL DEFAULT '0',
  `week_offer` tinyint(1) NOT NULL DEFAULT '0',
  `season_offer` tinyint(1) NOT NULL DEFAULT '0',
  `top_brand_asus` tinyint(1) NOT NULL DEFAULT '0',
  `top_brand_apple` tinyint(1) NOT NULL DEFAULT '0',
  `top_brand_dell` tinyint(1) NOT NULL DEFAULT '0',
  `top_brand_hp` tinyint(1) NOT NULL DEFAULT '0',
  `top_brand_lenovo` tinyint(1) NOT NULL DEFAULT '0',
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `products`
--

INSERT INTO `products` (`id`, `name`, `sku`, `price`, `special_price`, `description`, `manufacturer_id`, `visit_count`, `order_count`, `main_signed`, `week_offer`, `season_offer`, `top_brand_asus`, `top_brand_apple`, `top_brand_dell`, `top_brand_hp`, `top_brand_lenovo`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'PC ház', '00001', 20000, 15000, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Velit, rem atque? Fugit eaque laudantium fuga aspernatur, quae ipsa, assumenda, recusandae reiciendis odit amet error facilis quibusdam est quidem vero! Temporibus.', NULL, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 'pc-haz', NULL, NULL),
(2, 'Gamer monitor', '00002', 50000, NULL, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Velit, rem atque? Fugit eaque laudantium fuga aspernatur, quae ipsa, assumenda, recusandae reiciendis odit amet error facilis quibusdam est quidem vero! Temporibus.', NULL, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 'gamer-monitor', NULL, NULL),
(3, 'Gamer egérpad', '00003', 4000, 3300, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Velit, rem atque? Fugit eaque laudantium fuga aspernatur, quae ipsa, assumenda, recusandae reiciendis odit amet error facilis quibusdam est quidem vero! Temporibus.', NULL, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 'gamer-egerpad', NULL, NULL),
(4, 'Laptop', '00004', 350000, 325000, 'laptop', NULL, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 'laptop', NULL, NULL),
(5, 'Tablet', '00005', 100000, 85000, 'tablet', NULL, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 'tablet', NULL, NULL),
(6, 'Hálózati adapter', '00006', 3000, 2500, 'Hálózati adapter', NULL, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 'halozati_adapter', NULL, NULL),
(7, 'Apple Macbook Air', '00007', 55000, NULL, 'Apple Macbook Air', 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 'apple_macbook_air', NULL, NULL),
(8, 'Apple Macbook Air', '00008', 530000, NULL, 'Apple Macbook Air', 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 'apple_macbook_air_2', NULL, NULL),
(9, 'Apple Macbook Pro', '00009', 650000, NULL, 'Apple Macbook Pro', 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 'apple_macbook_pro', NULL, NULL),
(10, 'ASUS Notebook', '00010', 350000, 310000, 'ASUS Notebook', 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 'asus_notebook', NULL, NULL),
(11, 'ASUS Vivobook', '00011', 375000, NULL, 'ASUS Vivobook', 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 'asus_vivobook', NULL, NULL),
(12, 'ASUS Zenbook', '00012', 450000, 375000, 'ASUS Zenbook', 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 'asus_zenbook', NULL, NULL),
(13, 'Dell Inspiration', '00013', 300000, 280000, 'Dell Inspiration', 3, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 'dell_inspiration', NULL, NULL),
(14, 'Dell Latitude', '00014', 310000, NULL, 'Dell Latitude', 3, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 'dell_latitude', NULL, NULL),
(15, 'Dell Vostro', '00015', 250000, NULL, 'Dell Vostro', 3, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 'dell_vostro', NULL, NULL),
(16, 'HP 15s', '00016', 290000, 285000, 'HP 15s', 4, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'hp_15s', NULL, NULL),
(17, 'HP Pavilon', '00017', 325000, NULL, 'HP Pavilon', 4, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'hp_pavilon', NULL, NULL),
(18, 'HP Probook', '00018', 275000, NULL, 'HP Probook', 4, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'hp_probook', NULL, NULL),
(19, 'Lenovo Legion', '00019', 450000, 425000, 'Lenovo Legion', 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 'lenovo_legion', NULL, NULL),
(20, 'Lenovo Thinkbook', '00020', 315000, NULL, 'Lenovo Thinkbook', 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 'lenovo_thinkbook', NULL, NULL),
(21, 'Lenovo Yoga', '00021', 570000, 535000, 'Lenovo Yoga', 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 'lenovo_yoga', NULL, NULL);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_manufacturer_id_foreign` (`manufacturer_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_manufacturer_id_foreign` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
