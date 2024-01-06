-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2024. Jan 06. 15:43
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
-- Tábla szerkezet ehhez a táblához `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_json` text COLLATE utf8mb4_general_ci,
  `shipping_json` text COLLATE utf8mb4_general_ci,
  `products_json` text COLLATE utf8mb4_general_ci,
  `total` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `payment_json`, `shipping_json`, `products_json`, `total`, `created_at`) VALUES
(1, 2, '{\"id\":\"3\",\"type\":\"acceptance payment\",\"created_at\":\"2023-12-13 16:34:00\"}', '{\"id\":\"1\",\"type\":\"pickup point delivery\",\"status\":\"process\",\"created_at\":\"2023-12-13 17:17:49\"}', '{\"id\":\"11\",\"name\":\"ASUS Vivobook\",\"sku\":\"00011\",\"price\":\"375000\",\"special_price\":\"\",\"description\":\"ASUS Vivobook\",\"manufacturer_id\":\"2\",\"visit_count\":\"0\",\"order_count\":\"0\",\"main_signed\":\"0\",\"week_offer\":\"0\",\"season_offer\":\"0\",\"top_brand_asus\":\"1\",\"top_brand_apple\":\"0\",\"top_brand_dell\":\"0\",\"top_brand_hp\":\"0\",\"top_brand_lenovo\":\"0\",\"slug\":\"asus_vivobook\",\"created_at\":\"\",\"updated_at\":\"\"}', '375000', '2024-01-06 12:17:56'),
(2, 8, '{\"id\":\"1\",\"type\":\"Online fizetés\",\"created_at\":\"2023-12-13 16:33:17\"}', '{\"id\":\"1\",\"type\":\"Átvételi pontba kérem\",\"status\":\"process\",\"created_at\":\"2023-12-13 17:17:49\"}', '{\"id\":\"1\",\"name\":\"PC ház\",\"sku\":\"00001\",\"price\":\"20000\",\"special_price\":\"15000\",\"description\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Velit, rem atque? Fugit eaque laudantium fuga aspernatur, quae ipsa, assumenda, recusandae reiciendis odit amet error facilis quibusdam est quidem vero! Temporibus.\",\"manufacturer_id\":\"\",\"visit_count\":\"0\",\"order_count\":\"0\",\"main_signed\":\"1\",\"week_offer\":\"1\",\"season_offer\":\"1\",\"top_brand_asus\":\"0\",\"top_brand_apple\":\"0\",\"top_brand_dell\":\"0\",\"top_brand_hp\":\"0\",\"top_brand_lenovo\":\"0\",\"slug\":\"pc-haz\",\"created_at\":\"\",\"updated_at\":\"\"}{\"id\":\"2\",\"name\":\"Gamer monitor\",\"sku\":\"00002\",\"price\":\"50000\",\"special_price\":\"\",\"description\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Velit, rem atque? Fugit eaque laudantium fuga aspernatur, quae ipsa, assumenda, recusandae reiciendis odit amet error facilis quibusdam est quidem vero! Temporibus.\",\"manufacturer_id\":\"\",\"visit_count\":\"0\",\"order_count\":\"0\",\"main_signed\":\"1\",\"week_offer\":\"1\",\"season_offer\":\"1\",\"top_brand_asus\":\"0\",\"top_brand_apple\":\"0\",\"top_brand_dell\":\"0\",\"top_brand_hp\":\"0\",\"top_brand_lenovo\":\"0\",\"slug\":\"gamer-monitor\",\"created_at\":\"\",\"updated_at\":\"\"}{\"id\":\"5\",\"name\":\"Tablet\",\"sku\":\"00005\",\"price\":\"100000\",\"special_price\":\"85000\",\"description\":\"tablet\",\"manufacturer_id\":\"\",\"visit_count\":\"0\",\"order_count\":\"0\",\"main_signed\":\"1\",\"week_offer\":\"0\",\"season_offer\":\"1\",\"top_brand_asus\":\"0\",\"top_brand_apple\":\"0\",\"top_brand_dell\":\"0\",\"top_brand_hp\":\"0\",\"top_brand_lenovo\":\"0\",\"slug\":\"tablet\",\"created_at\":\"\",\"updated_at\":\"\"}', '2135000', '2024-01-06 15:32:58'),
(3, 20, '{\"id\":\"3\",\"type\":\"Átvételkor fizetek\",\"created_at\":\"2023-12-13 16:34:00\"}', '{\"id\":\"3\",\"type\":\"Boltban veszem át\",\"status\":\"process\",\"created_at\":\"2023-12-13 17:18:32\"}', '{\"id\":\"8\",\"name\":\"Apple Macbook Air\",\"sku\":\"00008\",\"price\":\"530000\",\"special_price\":\"\",\"description\":\"Apple Macbook Air\",\"manufacturer_id\":\"1\",\"visit_count\":\"0\",\"order_count\":\"0\",\"main_signed\":\"0\",\"week_offer\":\"0\",\"season_offer\":\"0\",\"top_brand_asus\":\"0\",\"top_brand_apple\":\"1\",\"top_brand_dell\":\"0\",\"top_brand_hp\":\"0\",\"top_brand_lenovo\":\"0\",\"slug\":\"apple_macbook_air_2\",\"created_at\":\"\",\"updated_at\":\"\"}{\"id\":\"1\",\"name\":\"PC ház\",\"sku\":\"00001\",\"price\":\"20000\",\"special_price\":\"15000\",\"description\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Velit, rem atque? Fugit eaque laudantium fuga aspernatur, quae ipsa, assumenda, recusandae reiciendis odit amet error facilis quibusdam est quidem vero! Temporibus.\",\"manufacturer_id\":\"\",\"visit_count\":\"0\",\"order_count\":\"0\",\"main_signed\":\"1\",\"week_offer\":\"1\",\"season_offer\":\"1\",\"top_brand_asus\":\"0\",\"top_brand_apple\":\"0\",\"top_brand_dell\":\"0\",\"top_brand_hp\":\"0\",\"top_brand_lenovo\":\"0\",\"slug\":\"pc-haz\",\"created_at\":\"\",\"updated_at\":\"\"}{\"id\":\"11\",\"name\":\"ASUS Vivobook\",\"sku\":\"00011\",\"price\":\"375000\",\"special_price\":\"\",\"description\":\"ASUS Vivobook\",\"manufacturer_id\":\"2\",\"visit_count\":\"0\",\"order_count\":\"0\",\"main_signed\":\"0\",\"week_offer\":\"0\",\"season_offer\":\"0\",\"top_brand_asus\":\"1\",\"top_brand_apple\":\"0\",\"top_brand_dell\":\"0\",\"top_brand_hp\":\"0\",\"top_brand_lenovo\":\"0\",\"slug\":\"asus_vivobook\",\"created_at\":\"\",\"updated_at\":\"\"}', '995000', '2024-01-06 15:36:06');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
