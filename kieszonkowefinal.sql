-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 07 Cze 2019, 14:28
-- Wersja serwera: 10.1.38-MariaDB
-- Wersja PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `kieszonkowefinal`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dziecko`
--

CREATE TABLE `dziecko` (
  `ID_dziecko` int(11) NOT NULL,
  `ID_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `dziecko`
--

INSERT INTO `dziecko` (`ID_dziecko`, `ID_user`) VALUES
(1, 31),
(2, 31),
(3, 32),
(4, 32),
(5, 32),
(6, 33),
(7, 33),
(8, 33),
(9, 33),
(10, 33),
(11, 33),
(12, 33),
(13, 33),
(14, 33),
(15, 34),
(16, 34),
(17, 34),
(18, 34),
(19, 34),
(20, 34),
(21, 34),
(22, 34),
(23, 34),
(24, 35),
(25, 35),
(26, 35),
(27, 35),
(28, 35),
(29, 35),
(30, 35),
(31, 35),
(32, 35),
(33, 36),
(34, 36),
(35, 36),
(36, 37),
(37, 37),
(38, 38),
(39, 38),
(40, 39),
(41, 39),
(42, 40),
(43, 40),
(44, 41),
(45, 41),
(46, 41),
(47, 41),
(48, 41),
(49, 42),
(50, 42),
(51, 42),
(52, 43),
(53, 43),
(54, 44),
(55, 44),
(56, 45),
(57, 45);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kwota`
--

CREATE TABLE `kwota` (
  `ID_kwota` int(11) NOT NULL,
  `kwota` int(11) NOT NULL,
  `ID_dziecko` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `kwota`
--

INSERT INTO `kwota` (`ID_kwota`, `kwota`, `ID_dziecko`) VALUES
(1, 10, 1),
(2, 10, 2),
(3, 20, 3),
(4, 40, 4),
(5, 60, 5),
(6, 100, 6),
(7, 10, 7),
(8, 10, 8),
(9, 10, 9),
(10, 0, 10),
(11, 0, 11),
(12, 0, 12),
(13, 0, 13),
(14, 0, 14),
(15, 80, 15),
(16, 10, 16),
(17, 10, 17),
(18, 10, 18),
(19, 0, 19),
(20, 0, 20),
(21, 0, 21),
(22, 0, 22),
(23, 0, 23),
(24, 10, 24),
(25, 10, 25),
(26, 10, 26),
(27, 10, 27),
(28, 10, 28),
(29, 10, 29),
(30, 10, 30),
(31, 10, 31),
(32, 10, 32),
(33, 0, 33),
(34, 0, 34),
(35, 0, 35),
(36, 0, 36),
(37, 0, 37),
(38, 0, 38),
(39, 0, 39),
(40, 0, 40),
(41, 0, 41),
(42, 0, 42),
(43, 0, 43),
(44, 10, 44),
(45, 10, 45),
(46, 10, 46),
(47, 10, 47),
(48, 10, 48),
(49, 40, 49),
(50, 40, 50),
(51, 40, 51),
(52, 0, 52),
(53, 0, 53),
(54, 60, 54),
(55, 0, 55),
(56, 40, 56),
(57, 40, 57);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `szkola`
--

CREATE TABLE `szkola` (
  `ID_szkola` int(11) NOT NULL,
  `ID_dziecko` int(11) NOT NULL,
  `Szkola` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `szkola`
--

INSERT INTO `szkola` (`ID_szkola`, `ID_dziecko`, `Szkola`) VALUES
(1, 1, 'PodstawÃ³wka'),
(2, 2, 'PodstawÃ³wka'),
(3, 3, 'Gimnazjum'),
(4, 4, 'Liceum lub Technikum'),
(5, 5, 'SzkoÅ‚a wyÅ¼sza'),
(6, 6, 'SzkoÅ‚a wyÅ¼sza'),
(7, 7, 'PodstawÃ³wka'),
(8, 8, 'PodstawÃ³wka'),
(9, 9, 'PodstawÃ³wka'),
(10, 10, 'PodstawÃ³wka'),
(11, 11, 'PodstawÃ³wka'),
(12, 12, 'PodstawÃ³wka'),
(13, 13, 'PodstawÃ³wka'),
(14, 14, 'SzkoÅ‚a wyÅ¼sza'),
(15, 15, 'Gimnazjum'),
(16, 16, 'PodstawÃ³wka'),
(17, 17, 'PodstawÃ³wka'),
(18, 18, 'PodstawÃ³wka'),
(19, 19, 'PodstawÃ³wka'),
(20, 20, 'PodstawÃ³wka'),
(21, 21, 'PodstawÃ³wka'),
(22, 22, 'PodstawÃ³wka'),
(23, 23, 'Gimnazjum'),
(24, 24, 'PodstawÃ³wka'),
(25, 25, 'PodstawÃ³wka'),
(26, 26, 'PodstawÃ³wka'),
(27, 27, 'PodstawÃ³wka'),
(28, 28, 'PodstawÃ³wka'),
(29, 29, 'PodstawÃ³wka'),
(30, 30, 'PodstawÃ³wka'),
(31, 31, 'PodstawÃ³wka'),
(32, 32, 'PodstawÃ³wka'),
(33, 33, ''),
(34, 34, ''),
(35, 35, ''),
(36, 36, ''),
(37, 37, ''),
(38, 38, ''),
(39, 39, ''),
(40, 40, ''),
(41, 41, ''),
(42, 42, ''),
(43, 43, ''),
(44, 44, 'Liceum lub Technikum'),
(45, 45, 'Liceum lub Technikum'),
(46, 46, 'Liceum lub Technikum'),
(47, 47, 'Liceum lub Technikum'),
(48, 48, 'Liceum lub Technikum'),
(49, 49, 'Liceum lub Technikum'),
(50, 50, 'Liceum lub Technikum'),
(51, 51, 'Liceum lub Technikum'),
(52, 52, ''),
(53, 53, ''),
(54, 54, 'Liceum lub Technikum'),
(55, 55, ''),
(56, 56, 'SzkoÅ‚a wyÅ¼sza'),
(57, 57, 'SzkoÅ‚a wyÅ¼sza');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `ID_user` int(11) NOT NULL,
  `Nick` text COLLATE utf8_polish_ci NOT NULL,
  `Haslo` text COLLATE utf8_polish_ci NOT NULL,
  `Liczba dzieci` int(11) NOT NULL,
  `ID_woj` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`ID_user`, `Nick`, `Haslo`, `Liczba dzieci`, `ID_woj`) VALUES
(31, 'Tomusidzialac', '$2y$10$wtBKY0Und33k4VdRE0mtQetVMDxkVIuGVmEHJT6PtJ8GxV8gbFSyC', 2, 3),
(32, 'Switch', '$2y$10$Rxjml/t//YGFGArGS6kZv.KLFEbuLCcFDMKCztd7ovn03X4CXy8Xa', 3, 14),
(33, 'kolosalne', '$2y$10$h/KN74EuurIwzAnoywANl.2eSOt0DokdcQnkifwq58wr8aGX/3Ucu', 9, 11),
(34, 'Kokonowiczalfa', '$2y$10$CkToTKZ2slMax7hLwbXHlOgn0hu9ijIsA645OZTL73EOJyHX.Oloy', 9, 13),
(35, 'izipizidd', '$2y$10$pwTSU7pE9ZR6uBFN2bOabOcsDBBvAxZBrBa0lXC7zh.tx/xRIitSG', 9, 11),
(36, 'ProbaMajka', '$2y$10$OQQPkoVUHGPhETp.7khK6.UbcTgIGbCPlPp7Pi1um17eJmxlIFKS6', 3, 10),
(37, 'KokonowiczXYZ', '$2y$10$aHWUruZXjEaqO/9iyPo8e.LfJiFW7v6VwBW.vEuORfXrEXC3s.qz2', 2, 8),
(38, 'kuciapa', '$2y$10$Iih.EBR6Nv9fpJNvc27kIela3lWWf/qkr/1jT/Cr4hMZXCzavipOq', 2, 3),
(39, 'mozemoze', '$2y$10$Rb3BxrRdw.ETVNdhxcAHh.RPiJrQv1kHjLBK7UK/XJ9xywm7pWAiu', 2, 1),
(40, 'mozemozelol', '$2y$10$0dtkEMBUaxc/V4m2gAxfLuxv7d8kCrEwaxRKLzQdISzFmMSVm1CYu', 2, 7),
(41, 'Kokonowiczhfhfhf', '$2y$10$RMk4bG6caLA4KIxcDaw3ZOiK3HxZG4bNls3UI8npLLz2/yXEuZxGG', 5, 13),
(42, 'Przedmikro', '$2y$10$oDbJ1gla.R9XH0nZ7yU2juKG8TauGj5JlR5n39Px3dxCkYjAwDd.i', 3, 9),
(43, 'ciekawecos', '$2y$10$jr54AC7eeDfyDPEI5id4AuN5nNYNcLaMyHBvQSAq6WW5oeOF7yxx.', 2, 1),
(44, 'chybaterazbajgla', '$2y$10$7CrzE7OMi9HWOYLdYaXoyued9QpPsDNNaDiDMieaMv3/XkR.vUcCC', 2, 1),
(45, 'bddobrzeter', '$2y$10$wmMkP.muf0sw1Mnfb4t5r.xCN08sC9VfhaPTy7KWJclZscswD3Q/.', 2, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wojewodztwa`
--

CREATE TABLE `wojewodztwa` (
  `ID_woj` int(11) NOT NULL,
  `Nazwa_Woj` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `wojewodztwa`
--

INSERT INTO `wojewodztwa` (`ID_woj`, `Nazwa_Woj`) VALUES
(1, 'dolnośląskie'),
(2, 'kujawsko-pomorskie\r\n\r\n'),
(3, 'małopolskie'),
(4, 'łódzkie'),
(5, 'wielkopolskie'),
(6, 'lubelskie'),
(7, 'lubuskie'),
(8, 'mazowieckie'),
(9, 'opolskie'),
(10, 'podlaskie'),
(11, 'pomorskie'),
(12, 'śląskie'),
(13, 'podkarpackie'),
(14, 'świętokrzyskie'),
(15, 'warmińsko-mazurskie'),
(16, 'zachodniopomorskie');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `dziecko`
--
ALTER TABLE `dziecko`
  ADD PRIMARY KEY (`ID_dziecko`),
  ADD KEY `ID_dziecko` (`ID_dziecko`),
  ADD KEY `ID_user` (`ID_user`);

--
-- Indeksy dla tabeli `kwota`
--
ALTER TABLE `kwota`
  ADD PRIMARY KEY (`ID_kwota`),
  ADD KEY `ID_kwota` (`ID_kwota`),
  ADD KEY `ID_dziecko` (`ID_dziecko`);

--
-- Indeksy dla tabeli `szkola`
--
ALTER TABLE `szkola`
  ADD PRIMARY KEY (`ID_szkola`),
  ADD KEY `ID_dziecko` (`ID_dziecko`),
  ADD KEY `ID_szkola` (`ID_szkola`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`ID_user`),
  ADD KEY `ID_woj` (`ID_woj`),
  ADD KEY `ID_user` (`ID_user`);

--
-- Indeksy dla tabeli `wojewodztwa`
--
ALTER TABLE `wojewodztwa`
  ADD PRIMARY KEY (`ID_woj`),
  ADD KEY `ID_woj` (`ID_woj`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `dziecko`
--
ALTER TABLE `dziecko`
  MODIFY `ID_dziecko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT dla tabeli `kwota`
--
ALTER TABLE `kwota`
  MODIFY `ID_kwota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT dla tabeli `szkola`
--
ALTER TABLE `szkola`
  MODIFY `ID_szkola` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `ID_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT dla tabeli `wojewodztwa`
--
ALTER TABLE `wojewodztwa`
  MODIFY `ID_woj` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `dziecko`
--
ALTER TABLE `dziecko`
  ADD CONSTRAINT `dziecko_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `uzytkownicy` (`ID_user`);

--
-- Ograniczenia dla tabeli `kwota`
--
ALTER TABLE `kwota`
  ADD CONSTRAINT `kwota_ibfk_1` FOREIGN KEY (`ID_dziecko`) REFERENCES `dziecko` (`ID_dziecko`);

--
-- Ograniczenia dla tabeli `szkola`
--
ALTER TABLE `szkola`
  ADD CONSTRAINT `szkola_ibfk_1` FOREIGN KEY (`ID_dziecko`) REFERENCES `dziecko` (`ID_dziecko`);

--
-- Ograniczenia dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD CONSTRAINT `uzytkownicy_ibfk_1` FOREIGN KEY (`ID_woj`) REFERENCES `wojewodztwa` (`ID_woj`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
