-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 04, 2024 alle 17:18
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cineverse`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `commento`
--

CREATE TABLE `commento` (
  `Corpo` text NOT NULL,
  `IDcommento` int(11) NOT NULL,
  `IDpost` int(11) NOT NULL,
  `Username_Utente` varchar(30) NOT NULL,
  `IDcommento_Padre` int(11) DEFAULT NULL,
  `Date_time` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `foto_video`
--

CREATE TABLE `foto_video` (
  `IDpost_foto_video` int(11) NOT NULL,
  `IDpost` int(11) NOT NULL,
  `Foto_Video` varchar(500) NOT NULL,
  `Descrizione` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `like_commento`
--

CREATE TABLE `like_commento` (
  `IDcommento` int(11) NOT NULL,
  `Username_Utente` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `like_post`
--

CREATE TABLE `like_post` (
  `IDpost` int(11) NOT NULL,
  `Username_Utente` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `opzione`
--

CREATE TABLE `opzione` (
  `IDpost` int(11) NOT NULL,
  `Testo` varchar(30) NOT NULL,
  `TipoOpzione` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `post`
--

CREATE TABLE `post` (
  `Titolo` varchar(50) NOT NULL,
  `IDpost` int(11) NOT NULL,
  `Archiviato` tinyint(1) NOT NULL,
  `Username_Utente` varchar(30) NOT NULL,
  `Nome_tag_Topic` varchar(30) DEFAULT NULL,
  `Date_time` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `relazione`
--

CREATE TABLE `relazione` (
  `Username_Seguito` varchar(30) NOT NULL,
  `Username_Segue` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `testo`
--

CREATE TABLE `testo` (
  `IDpost_testo` int(11) NOT NULL,
  `IDpost` int(11) NOT NULL,
  `Corpo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `tfa_auth`
--

CREATE TABLE `tfa_auth` (
  `username` char(50) NOT NULL,
  `code` char(10) DEFAULT NULL,
  `token` char(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `topic`
--

CREATE TABLE `topic` (
  `Nome_tag` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `topic_utente`
--

CREATE TABLE `topic_utente` (
  `Username_Utente` varchar(30) NOT NULL,
  `Nome_tag_Topic` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `Nome` varchar(30) NOT NULL,
  `Cognome` varchar(30) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Data_nascita` date NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(70) NOT NULL,
  `Foto_profilo` varchar(500) DEFAULT NULL,
  `Sesso` varchar(30) DEFAULT NULL,
  `Descrizione` varchar(100) DEFAULT NULL,
  `Foto_background` varchar(500) DEFAULT NULL,
  `2FA` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `voto`
--

CREATE TABLE `voto` (
  `Username_Utente` varchar(30) NOT NULL,
  `IDpost` int(11) NOT NULL,
  `Testo_Opzione` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `commento`
--
ALTER TABLE `commento`
  ADD PRIMARY KEY (`IDcommento`),
  ADD UNIQUE KEY `ID_COMMENTO_IND` (`IDcommento`),
  ADD KEY `REF_COMME_POST_IND` (`IDpost`),
  ADD KEY `REF_COMME_UTENT_IND` (`Username_Utente`),
  ADD KEY `REF_COMME_COMME_IND` (`IDcommento_Padre`);

--
-- Indici per le tabelle `foto_video`
--
ALTER TABLE `foto_video`
  ADD PRIMARY KEY (`IDpost_foto_video`),
  ADD UNIQUE KEY `SID_FOTO__POST_ID` (`IDpost`),
  ADD UNIQUE KEY `ID_FOTO_VIDEO_IND` (`IDpost_foto_video`),
  ADD UNIQUE KEY `SID_FOTO__POST_IND` (`IDpost`);

--
-- Indici per le tabelle `like_commento`
--
ALTER TABLE `like_commento`
  ADD PRIMARY KEY (`IDcommento`,`Username_Utente`),
  ADD UNIQUE KEY `ID_LIKE_COMMENTO_IND` (`IDcommento`,`Username_Utente`),
  ADD KEY `REF_LIKE__UTENT_1_IND` (`Username_Utente`);

--
-- Indici per le tabelle `like_post`
--
ALTER TABLE `like_post`
  ADD PRIMARY KEY (`IDpost`,`Username_Utente`),
  ADD UNIQUE KEY `ID_LIKE_POST_IND` (`IDpost`,`Username_Utente`),
  ADD KEY `REF_LIKE__UTENT_IND` (`Username_Utente`);

--
-- Indici per le tabelle `opzione`
--
ALTER TABLE `opzione`
  ADD PRIMARY KEY (`IDpost`,`Testo`),
  ADD UNIQUE KEY `ID_OPZIONE_IND` (`IDpost`,`Testo`);

--
-- Indici per le tabelle `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`IDpost`),
  ADD UNIQUE KEY `ID_POST_IND` (`IDpost`),
  ADD KEY `REF_POST_UTENT_IND` (`Username_Utente`),
  ADD KEY `REF_POST_TOPIC_IND` (`Nome_tag_Topic`);

--
-- Indici per le tabelle `relazione`
--
ALTER TABLE `relazione`
  ADD PRIMARY KEY (`Username_Seguito`,`Username_Segue`),
  ADD UNIQUE KEY `ID_RELAZIONE_IND` (`Username_Seguito`,`Username_Segue`),
  ADD KEY `REF_RELAZ_UTENT_IND` (`Username_Segue`);

--
-- Indici per le tabelle `testo`
--
ALTER TABLE `testo`
  ADD PRIMARY KEY (`IDpost_testo`),
  ADD UNIQUE KEY `SID_TESTO_POST_ID` (`IDpost`),
  ADD UNIQUE KEY `ID_TESTO_IND` (`IDpost_testo`),
  ADD UNIQUE KEY `SID_TESTO_POST_IND` (`IDpost`);

--
-- Indici per le tabelle `tfa_auth`
--
ALTER TABLE `tfa_auth`
  ADD PRIMARY KEY (`username`);

--
-- Indici per le tabelle `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`Nome_tag`),
  ADD UNIQUE KEY `ID_TOPIC_IND` (`Nome_tag`);

--
-- Indici per le tabelle `topic_utente`
--
ALTER TABLE `topic_utente`
  ADD PRIMARY KEY (`Username_Utente`,`Nome_tag_Topic`),
  ADD UNIQUE KEY `ID_TOPIC_UTENTE_IND` (`Username_Utente`,`Nome_tag_Topic`),
  ADD KEY `REF_TOPIC_TOPIC_IND` (`Nome_tag_Topic`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`Username`),
  ADD UNIQUE KEY `ID_UTENTE_IND` (`Username`);

--
-- Indici per le tabelle `voto`
--
ALTER TABLE `voto`
  ADD PRIMARY KEY (`Username_Utente`,`IDpost`,`Testo_Opzione`),
  ADD UNIQUE KEY `ID_VOTO_IND` (`Username_Utente`,`IDpost`,`Testo_Opzione`),
  ADD KEY `REF_VOTO_OPZIO_IND` (`IDpost`,`Testo_Opzione`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `commento`
--
ALTER TABLE `commento`
  MODIFY `IDcommento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `foto_video`
--
ALTER TABLE `foto_video`
  MODIFY `IDpost_foto_video` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `post`
--
ALTER TABLE `post`
  MODIFY `IDpost` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `testo`
--
ALTER TABLE `testo`
  MODIFY `IDpost_testo` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `commento`
--
ALTER TABLE `commento`
  ADD CONSTRAINT `REF_COMME_COMME_FK` FOREIGN KEY (`IDcommento_Padre`) REFERENCES `commento` (`IDcommento`),
  ADD CONSTRAINT `REF_COMME_POST_FK` FOREIGN KEY (`IDpost`) REFERENCES `post` (`IDpost`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `REF_COMME_UTENT_FK` FOREIGN KEY (`Username_Utente`) REFERENCES `utente` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `foto_video`
--
ALTER TABLE `foto_video`
  ADD CONSTRAINT `SID_FOTO__POST_FK` FOREIGN KEY (`IDpost`) REFERENCES `post` (`IDpost`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `like_commento`
--
ALTER TABLE `like_commento`
  ADD CONSTRAINT `REF_LIKE__COMME` FOREIGN KEY (`IDcommento`) REFERENCES `commento` (`IDcommento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `REF_LIKE__UTENT_1_FK` FOREIGN KEY (`Username_Utente`) REFERENCES `utente` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `like_post`
--
ALTER TABLE `like_post`
  ADD CONSTRAINT `REF_LIKE__POST` FOREIGN KEY (`IDpost`) REFERENCES `post` (`IDpost`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `REF_LIKE__UTENT_FK` FOREIGN KEY (`Username_Utente`) REFERENCES `utente` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `opzione`
--
ALTER TABLE `opzione`
  ADD CONSTRAINT `REF_OPZIO_POST` FOREIGN KEY (`IDpost`) REFERENCES `post` (`IDpost`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `REF_POST_TOPIC_FK` FOREIGN KEY (`Nome_tag_Topic`) REFERENCES `topic` (`Nome_tag`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `REF_POST_UTENT_FK` FOREIGN KEY (`Username_Utente`) REFERENCES `utente` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `relazione`
--
ALTER TABLE `relazione`
  ADD CONSTRAINT `REF_RELAZ_UTENT_1` FOREIGN KEY (`Username_Seguito`) REFERENCES `utente` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `REF_RELAZ_UTENT_FK` FOREIGN KEY (`Username_Segue`) REFERENCES `utente` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `testo`
--
ALTER TABLE `testo`
  ADD CONSTRAINT `SID_TESTO_POST_FK` FOREIGN KEY (`IDpost`) REFERENCES `post` (`IDpost`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `topic_utente`
--
ALTER TABLE `topic_utente`
  ADD CONSTRAINT `EQU_TOPIC_UTENT` FOREIGN KEY (`Username_Utente`) REFERENCES `utente` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `REF_TOPIC_TOPIC_FK` FOREIGN KEY (`Nome_tag_Topic`) REFERENCES `topic` (`Nome_tag`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `voto`
--
ALTER TABLE `voto`
  ADD CONSTRAINT `REF_VOTO_OPZIO_FK` FOREIGN KEY (`IDpost`,`Testo_Opzione`) REFERENCES `opzione` (`IDpost`, `Testo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `REF_VOTO_UTENT` FOREIGN KEY (`Username_Utente`) REFERENCES `utente` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
