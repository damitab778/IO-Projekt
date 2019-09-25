-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 25 Wrz 2019, 18:28
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
-- Baza danych: `kieszonkowefinal2`
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
(85, 46),
(59, 47),
(60, 48),
(61, 48),
(62, 48),
(63, 48),
(64, 49),
(65, 49),
(87, 50),
(88, 50),
(91, 50),
(92, 50),
(93, 50),
(95, 50);

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
(59, 10, 59),
(60, 100, 60),
(61, 40, 61),
(62, 100, 62),
(63, 40, 63),
(64, 10, 64),
(65, 10, 65),
(85, 10, 85),
(87, 20, 87),
(88, 10, 88),
(91, 10, 91),
(92, 40, 92),
(93, 70, 93),
(95, 60, 95);

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
(59, 59, 'Podstawowka'),
(60, 60, 'Podstawowka'),
(61, 61, 'Gimnazjum'),
(62, 62, 'Liceum lub Technikum'),
(63, 63, 'Szkola wyzsza'),
(64, 64, 'Podstawowka'),
(65, 65, 'Podstawowka'),
(85, 85, 'Podstawowka'),
(87, 87, 'Liceum lub Technikum'),
(88, 88, 'Podstawowka'),
(91, 91, 'Szkola wyzsza'),
(92, 92, 'Szkola wyzsza'),
(93, 93, 'Gimnazjum'),
(95, 95, 'Gimnazjum');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `ID_user` int(11) NOT NULL,
  `Nick` text COLLATE utf8_polish_ci NOT NULL,
  `Haslo` text COLLATE utf8_polish_ci NOT NULL,
  `Liczba_dzieci` int(11) NOT NULL,
  `ID_woj` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`ID_user`, `Nick`, `Haslo`, `Liczba_dzieci`, `ID_woj`) VALUES
(46, 'zoabaczymyco', '$2y$10$zOAj6qc8QWn61/Y1LiJmWOHUcB/1PKs4hYCKcs3QcKddgFB3Z8f8q', 1, 1),
(47, 'powinnobyc', '$2y$10$RAebjLJniaPaahyY1ZCynuTh.5ubD8g/D2EG.QqVpEWElzm5u2Y0.', 1, 1),
(48, 'JozekMrozek', '$2y$10$crAHaqSNxYP35QPfrP9vS.gL34r6Fho0uuFrGAesJFLb4xqO0mugK', 4, 1),
(49, 'Kokonowiczxx', '$2y$10$2KxKeA61m73jlp.pVyU.yOS17FZFqFB1YSJEmUZIveMDaeJuVdire', 2, 4),
(50, 'MalyJack', '$2y$10$y5hW34gnGUWeKLzCpYJv7uG6eQQ3uf34GaAmA8sitiXLwNOTZMTWq', 6, 7);

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
(1, 'dolnoslaskie'),
(2, 'kujawsko-pomorskie\r\n\r\n'),
(3, 'malopolskie'),
(4, 'lodzkie'),
(5, 'wielkopolskie'),
(6, 'lubelskie'),
(7, 'lubuskie'),
(8, 'mazowieckie'),
(9, 'opolskie'),
(10, 'podlaskie'),
(11, 'pomorskie'),
(12, 'slaskie'),
(13, 'podkarpackie'),
(14, 'swietokrzyskie'),
(15, 'warminsko-mazurskie'),
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
  MODIFY `ID_dziecko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT dla tabeli `kwota`
--
ALTER TABLE `kwota`
  MODIFY `ID_kwota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT dla tabeli `szkola`
--
ALTER TABLE `szkola`
  MODIFY `ID_szkola` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `ID_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
