-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2020 at 09:19 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pva_februar2020`
--

-- --------------------------------------------------------

--
-- Table structure for table `kanali`
--

CREATE TABLE `kanali` (
  `id` int(3) UNSIGNED NOT NULL,
  `naziv` varchar(20) NOT NULL,
  `opis` text NOT NULL,
  `cena` int(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kanali`
--

INSERT INTO `kanali` (`id`, `naziv`, `opis`, `cena`) VALUES
(1, 'RTS 1', 'Radio televizija Srbije - Kanal 1', 100),
(2, 'RTS 2', 'Radio televizija Srbije - Kanal 2', 100),
(3, 'HBO HD', 'Televizija sa najnovijim filmovima', 50),
(4, 'Prva Plus', 'Informativne emisije', 50),
(5, 'Sport Klub', 'Sprtski programi, prenosi uživo, NFL', 50),
(6, 'Arena Sport', 'Sportski kanal, NBA, ABA liga', 50),
(7, '24 Kitchen', 'Priče iz kuhinje, kulinarski recepti', 50),
(9, 'Cartoon Network', 'Dečiji kanal, Crtani filmovi za decu i one koji se osećaju tako', 50);

-- --------------------------------------------------------

--
-- Table structure for table `kanalikorisnici`
--

CREATE TABLE `kanalikorisnici` (
  `id` int(3) UNSIGNED NOT NULL,
  `idKanala` int(3) NOT NULL,
  `idKorisnika` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(2) UNSIGNED NOT NULL,
  `ime` varchar(20) NOT NULL,
  `prezime` varchar(30) NOT NULL,
  `korime` varchar(20) NOT NULL,
  `lozinka` varchar(20) NOT NULL,
  `adresa` varchar(50) NOT NULL,
  `status` enum('Administrator','Korisnik') NOT NULL,
  `datum` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `ime`, `prezime`, `korime`, `lozinka`, `adresa`, `status`, `datum`) VALUES
(1, 'Pera', 'Perić', 'pperic', 'pperic', 'Vojvode Stepe 283', 'Administrator', '2020-02-11'),
(2, 'Ivan', 'Ivanić', 'iivanic', 'iivanic', 'Vojvode Stepe 254', 'Korisnik', '2020-02-11'),
(3, 'Mile', 'Milić', 'mmilic', 'mmilic', 'Poštarska 28', 'Korisnik', '2020-02-11'),
(4, 'Jovan', 'Jović', 'jjovic', 'jjovic', 'Ustanička 20', 'Korisnik', '2020-02-11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kanali`
--
ALTER TABLE `kanali`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kanalikorisnici`
--
ALTER TABLE `kanalikorisnici`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korime` (`korime`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kanali`
--
ALTER TABLE `kanali`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `kanalikorisnici`
--
ALTER TABLE `kanalikorisnici`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
