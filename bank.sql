-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20221125.2e001c186a
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2022. Dec 05. 19:36
-- Kiszolgáló verziója: 10.4.24-MariaDB
-- PHP verzió: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `bank`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalo`
--

CREATE TABLE `felhasznalo` (
  `szig_szam` varchar(8) COLLATE utf8_hungarian_ci NOT NULL,
  `jelszo` varchar(100) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'felhasználó jelszó',
  `vezeteknev` varchar(50) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'felhasználó vezetékneve',
  `keresztnev` varchar(50) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'felhasználó keresztneve',
  `iranyitoszam` int(4) DEFAULT NULL,
  `utca/hazszam` varchar(50) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'utca és házszám, a felhasználó címe',
  `email` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `telefonszam` varchar(11) COLLATE utf8_hungarian_ci NOT NULL,
  `profilkep` text COLLATE utf8_hungarian_ci NOT NULL DEFAULT '\'\\\'../profilkep/default.jpg\\\'\''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `felhasznalo`
--

INSERT INTO `felhasznalo` (`szig_szam`, `jelszo`, `vezeteknev`, `keresztnev`, `iranyitoszam`, `utca/hazszam`, `email`, `telefonszam`, `profilkep`) VALUES
('teszt', 'teszt', 'Teszt', 'Katalin', 6723, 'Etelka sor 2.', 'tesztkatalin@gmail.com', '06305556385', '../profilkep/default.jpg');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `folyoszamla`
--

CREATE TABLE `folyoszamla` (
  `id` int(6) NOT NULL COMMENT 'folyószámla id',
  `szamlaszam` varchar(26) COLLATE utf8_hungarian_ci NOT NULL COMMENT 'folyószámla számlaszáma',
  `egyenleg` int(20) NOT NULL COMMENT 'folyószámla egyenlege',
  `felhasznalo` varchar(8) COLLATE utf8_hungarian_ci DEFAULT NULL COMMENT 'felhasználó személyi igazolvány száma',
  `hitelszamla` int(11) DEFAULT 0 COMMENT 'a számla hitelszámla-e',
  `hitelkeret` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `folyoszamla`
--

INSERT INTO `folyoszamla` (`id`, `szamlaszam`, `egyenleg`, `felhasznalo`, `hitelszamla`, `hitelkeret`) VALUES
(1, '55236912-22536697-12400098', 537326, 'teszt', 1, 0),
(2, '36966500-54412798-03560987', 0, 'teszt', 0, 500000);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `husegprogram`
--

CREATE TABLE `husegprogram` (
  `bevalthato_pontok` int(11) NOT NULL,
  `felhasznalt_pontok` int(11) NOT NULL,
  `folyoszamla_id` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `husegprogram`
--

INSERT INTO `husegprogram` (`bevalthato_pontok`, `felhasznalt_pontok`, `folyoszamla_id`) VALUES
(140, 0, 2),
(280, 0, 2),
(395, 0, 2),
(165, 0, 2),
(2740, 0, 2),
(1590, 0, 2),
(0, -5000, 2),
(5000, 0, 2);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `idopont_foglalas`
--

CREATE TABLE `idopont_foglalas` (
  `idopont` varchar(5) COLLATE utf8_hungarian_ci NOT NULL,
  `datum` date NOT NULL,
  `ugytipus` int(3) DEFAULT NULL,
  `felhasznalo` varchar(8) COLLATE utf8_hungarian_ci DEFAULT NULL COMMENT 'felhasználó szig.szám'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `idopont_foglalas`
--

INSERT INTO `idopont_foglalas` (`idopont`, `datum`, `ugytipus`, `felhasznalo`) VALUES
('8-10', '2022-01-11', 2, 'teszt'),
('10-12', '2022-02-23', 3, 'teszt'),
('8-10', '2022-02-28', 5, 'teszt'),
('14-16', '2022-04-07', 4, 'teszt'),
('10-12', '2022-05-23', 1, 'teszt'),
('8-10', '2022-04-21', 2, 'teszt'),
('10-12', '2022-12-05', 2, 'teszt');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kolcson`
--

CREATE TABLE `kolcson` (
  `id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `thm` float NOT NULL,
  `futamido` int(3) NOT NULL,
  `felvett_osszeg` int(20) DEFAULT NULL,
  `felhasznalo` varchar(8) COLLATE utf8_hungarian_ci DEFAULT NULL COMMENT 'felhasználó személyi igazolvány száma',
  `visszafizetendo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `kolcson`
--

INSERT INTO `kolcson` (`id`, `datum`, `thm`, `futamido`, `felvett_osszeg`, `felhasznalo`, `visszafizetendo`) VALUES
(1, '2022-01-10', 0.08, 24, 250000, 'teszt', 270000),
(2, '2022-09-12', 0.08, 24, 150000, 'teszt', 162000);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `partner`
--

CREATE TABLE `partner` (
  `partner_szamlaszam` varchar(26) COLLATE utf8_hungarian_ci NOT NULL,
  `partner_neve` varchar(30) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `partner`
--

INSERT INTO `partner` (`partner_szamlaszam`, `partner_neve`) VALUES
('11123552-00638859-00002569', 'Tóth Krisztina'),
('11223556-99523302-44778513', 'INETON Kft.'),
('11252298-12579900-35846988', 'Kiss Nóra'),
('12345678-00000000-00000000', 'Bank '),
('22263587-99685663-00002584', 'MVM Next Energiakereskedelmi '),
('22357796-77458793-11458978', 'rEVOLUTION SOFTWARE Kft.'),
('22635897-22254339-22314778', 'Sári Bernadett'),
('23335879-11125778-96335478', 'Tri-Mix Bt.'),
('26335987-00002114-03699654', 'Somogyi Sámuel'),
('33325684-22220214-33651996', 'TOPdesk Magyarország Kft.'),
('36966500-54412798-03560987', 'Teszt Katalin'),
('51341258-00002578-99663589', 'Realtech Kft'),
('55236912-22536697-12400098', 'Teszt Katalin'),
('55263384-00223589-03996554', 'BitKnights Kft.'),
('55986635-00253321-00587448', 'Szegedi Vízmű Zrt.'),
('66558412-33226774-22018799', 'SPAR szupermarket'),
('66635598-33200014-05523879', 'DIGI Kft'),
('66635998-11224235-00225403', 'Kiss Áron E.V.'),
('88566235-00005829-21003985', 'Nagy Gabriella'),
('99655347-00598766-88953478', 'Szegedi Távfűtő Kft.');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `ugytipus`
--

CREATE TABLE `ugytipus` (
  `id` int(11) NOT NULL,
  `ugytipus_megnevezes` varchar(100) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `ugytipus`
--

INSERT INTO `ugytipus` (`id`, `ugytipus_megnevezes`) VALUES
(1, 'Folyószámlával kapcsolatos ügyek'),
(2, 'Adat módosítás'),
(3, 'Kölcsönnel kapcsolatos ügyintézés'),
(4, 'Hűségpontokkal kapcsolatos ügyintézés'),
(5, 'Egyéb');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `utalas`
--

CREATE TABLE `utalas` (
  `id` int(11) NOT NULL,
  `partner_szamlaszam` varchar(26) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `datum` date NOT NULL,
  `kozlemeny` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `osszeg` int(20) NOT NULL,
  `folyoszamla` int(11) DEFAULT NULL,
  `jovairas` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `utalas`
--

INSERT INTO `utalas` (`id`, `partner_szamlaszam`, `datum`, `kozlemeny`, `osszeg`, `folyoszamla`, `jovairas`) VALUES
(1, '11252298-12579900-35846988', '2022-01-03', 'XA-2022-00152 szla. kiegy.', 38000, 1, 1),
(2, '88566235-00005829-21003985', '2022-01-05', '2022-625SZA', 15000, 1, 1),
(3, '22263587-99685663-00002584', '2022-01-03', 'MVM-2020-01-00036', 7800, 1, 1),
(4, '22263587-99685663-00002584', '2022-02-02', 'MVM-2022-0185', 25000, 1, 1),
(5, '11252298-12579900-35846988', '2022-02-02', 'kölcsön', 100000, 1, 1),
(6, '11252298-12579900-35846988', '2022-02-21', 'közös ktg.', 12000, 1, 1),
(7, '11123552-00638859-00002569', '2022-02-24', 'XA-0335987 szla. ', 13999, 2, 1),
(8, '11123552-00638859-00002569', '2022-03-09', 'XA-0335962 szla. ', 13995, 2, 1),
(9, '26335987-00002114-03699654', '2022-03-13', '2. törlesztő', 25500, 2, 1),
(10, '66635998-11224235-00225403', '2022-03-30', 'eszközök bérlése', 2500, 2, 1),
(11, '11223556-99523302-44778513', '2022-04-17', 'szl20220265', 52600, 1, 1),
(12, '33325684-22220214-33651996', '2022-04-21', 'szoftver bérlés 2021/256 szerződés szám', 12300, 1, 1),
(13, '55263384-00223589-03996554', '2022-04-25', 'Számítógépes programozás', 12000, 1, 1),
(14, '22357796-77458793-11458978', '2022-02-04', 'munkabér 01.hó', 290150, 1, 0),
(15, '22357796-77458793-11458978', '2022-03-04', 'munkabér 02.hó', 290150, 1, 0),
(16, '22357796-77458793-11458978', '2022-04-07', 'munkabér 03.hó', 290150, 1, 0),
(17, '22357796-77458793-11458978', '2022-05-06', 'munkabér 04.hó', 290150, 1, 0),
(18, '22357796-77458793-11458978', '2022-06-03', 'munkabér 05.hó', 290150, 1, 0),
(19, '22357796-77458793-11458978', '2022-07-01', 'munkabér 06.hó', 290150, 1, 0),
(20, '22357796-77458793-11458978', '2022-08-05', 'munkabér 07.hó', 290150, 1, 0),
(21, '22357796-77458793-11458978', '2022-09-02', 'munkabér 08.hó', 290150, 1, 0),
(22, '22357796-77458793-11458978', '2022-10-03', 'munkabér 09.hó', 290150, 1, 0),
(23, '22357796-77458793-11458978', '2022-11-04', 'munkabér 10.hó', 290150, 1, 0),
(24, '22357796-77458793-11458978', '2022-12-02', 'munkabér 11.hó', 290150, 1, 0),
(25, '12345678-00000000-00000000', '2022-01-03', 'bankköltség', 560, 1, 1),
(26, '12345678-00000000-00000000', '2022-02-06', 'bankköltség', 560, 1, 1),
(27, '12345678-00000000-00000000', '2022-03-04', 'bankköltség', 560, 1, 1),
(28, '12345678-00000000-00000000', '2022-04-11', 'bankköltség', 560, 1, 1),
(29, '12345678-00000000-00000000', '2022-05-09', 'bankköltség', 560, 1, 1),
(30, '12345678-00000000-00000000', '2022-06-08', 'bankköltség', 560, 1, 1),
(31, '12345678-00000000-00000000', '2022-07-07', 'bankköltség', 560, 1, 1),
(32, '12345678-00000000-00000000', '2022-08-08', 'bankköltség', 560, 1, 1),
(33, '12345678-00000000-00000000', '2022-09-02', 'bankköltség', 560, 1, 1),
(34, '66558412-33226774-22018799', '2022-04-12', '65416532', 2682, 1, 1),
(35, '66558412-33226774-22018799', '2022-05-24', '65415414', 8593, 1, 1),
(36, '66558412-33226774-22018799', '2022-06-08', '54132631', 5662, 1, 1),
(37, '66558412-33226774-22018799', '2022-09-11', '65498233', 3205, 1, 1),
(38, '66558412-33226774-22018799', '2022-09-16', '65615787', 7633, 1, 1),
(39, '22263587-99685663-00002584', '2022-02-11', 'MVM-2020-01-00063', 7800, 1, 1),
(40, '22263587-99685663-00002584', '2022-03-14', 'MVM-2020-01-00079', 7800, 1, 1),
(41, '22263587-99685663-00002584', '2022-04-14', 'MVM-2020-01-00126', 7800, 1, 1),
(42, '22263587-99685663-00002584', '2022-05-16', 'MVM-2020-01-00212', 7800, 1, 1),
(43, '22263587-99685663-00002584', '2022-06-17', 'MVM-2020-01-00352', 7800, 1, 1),
(44, '12345678-00000000-00000000', '2022-10-10', 'bankköltség', 560, 1, 1),
(45, '12345678-00000000-00000000', '2022-11-07', 'bankköltség', 560, 1, 1),
(46, '12345678-00000000-00000000', '2022-12-05', 'bankköltség', 560, 1, 1),
(47, '36966500-54412798-03560987', '2022-12-05', 'törlesztő', 55994, 1, 1),
(48, '55236912-22536697-12400098', '2022-12-05', 'törlesztő', 55994, 2, 0),
(49, '51341258-00002578-99663589', '2022-12-05', 'számitástechnikai eszközök', 260000, 2, 1),
(50, '23335879-11125778-96335478', '2022-12-05', '6. havi könyvelési dij', 145000, 2, 1),
(51, '36966500-54412798-03560987', '2022-12-05', 'kölcsön visszafizetés', 405000, 1, 1),
(52, '55236912-22536697-12400098', '2022-12-05', 'kölcsön visszafizetés', 405000, 2, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `varos`
--

CREATE TABLE `varos` (
  `iranyitoszam` int(4) NOT NULL,
  `varos` varchar(11) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `varos`
--

INSERT INTO `varos` (`iranyitoszam`, `varos`) VALUES
(1173, 'Budapest XV'),
(4002, 'Debrecen'),
(6723, 'Szeged'),
(7632, 'Pécs'),
(9025, 'Győr');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `felhasznalo`
--
ALTER TABLE `felhasznalo`
  ADD PRIMARY KEY (`szig_szam`),
  ADD KEY `iranyitoszam` (`iranyitoszam`);

--
-- A tábla indexei `folyoszamla`
--
ALTER TABLE `folyoszamla`
  ADD PRIMARY KEY (`id`),
  ADD KEY `felhasznalo` (`felhasznalo`);

--
-- A tábla indexei `husegprogram`
--
ALTER TABLE `husegprogram`
  ADD KEY `folyoszamla_id` (`folyoszamla_id`);

--
-- A tábla indexei `idopont_foglalas`
--
ALTER TABLE `idopont_foglalas`
  ADD KEY `felhasznalo` (`felhasznalo`),
  ADD KEY `ugytipus` (`ugytipus`);

--
-- A tábla indexei `kolcson`
--
ALTER TABLE `kolcson`
  ADD PRIMARY KEY (`id`),
  ADD KEY `felhasznalo` (`felhasznalo`);

--
-- A tábla indexei `partner`
--
ALTER TABLE `partner`
  ADD PRIMARY KEY (`partner_szamlaszam`);

--
-- A tábla indexei `ugytipus`
--
ALTER TABLE `ugytipus`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `utalas`
--
ALTER TABLE `utalas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partner_szamlaszam` (`partner_szamlaszam`),
  ADD KEY `folyoszamla` (`folyoszamla`);

--
-- A tábla indexei `varos`
--
ALTER TABLE `varos`
  ADD PRIMARY KEY (`iranyitoszam`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `folyoszamla`
--
ALTER TABLE `folyoszamla`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT COMMENT 'folyószámla id', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `kolcson`
--
ALTER TABLE `kolcson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `utalas`
--
ALTER TABLE `utalas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `felhasznalo`
--
ALTER TABLE `felhasznalo`
  ADD CONSTRAINT `felhasznalo_ibfk_1` FOREIGN KEY (`iranyitoszam`) REFERENCES `varos` (`iranyitoszam`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Megkötések a táblához `folyoszamla`
--
ALTER TABLE `folyoszamla`
  ADD CONSTRAINT `folyoszamla_ibfk_1` FOREIGN KEY (`felhasznalo`) REFERENCES `felhasznalo` (`szig_szam`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Megkötések a táblához `husegprogram`
--
ALTER TABLE `husegprogram`
  ADD CONSTRAINT `husegprogram_ibfk_1` FOREIGN KEY (`folyoszamla_id`) REFERENCES `folyoszamla` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Megkötések a táblához `idopont_foglalas`
--
ALTER TABLE `idopont_foglalas`
  ADD CONSTRAINT `idopont_foglalas_ibfk_1` FOREIGN KEY (`felhasznalo`) REFERENCES `felhasznalo` (`szig_szam`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `idopont_foglalas_ibfk_2` FOREIGN KEY (`ugytipus`) REFERENCES `ugytipus` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Megkötések a táblához `kolcson`
--
ALTER TABLE `kolcson`
  ADD CONSTRAINT `kolcson_ibfk_1` FOREIGN KEY (`felhasznalo`) REFERENCES `felhasznalo` (`szig_szam`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Megkötések a táblához `utalas`
--
ALTER TABLE `utalas`
  ADD CONSTRAINT `utalas_ibfk_1` FOREIGN KEY (`folyoszamla`) REFERENCES `folyoszamla` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `utalas_ibfk_2` FOREIGN KEY (`partner_szamlaszam`) REFERENCES `partner` (`partner_szamlaszam`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
