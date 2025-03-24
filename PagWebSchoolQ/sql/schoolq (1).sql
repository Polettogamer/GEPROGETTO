-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mar 24, 2025 alle 20:01
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schoolq`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE `categorie` (
  `IDCategoria` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `descrizione` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`IDCategoria`, `nome`, `descrizione`) VALUES
(1, 'Italiano', 'Tutte le domande inerenti alla lingua e la letteratura italiana'),
(2, 'Storia', 'Tutte le domande inerenti alla storia'),
(3, 'Geografia', 'Tutte le domande inerenti alla geografia'),
(4, 'Diritto ed Economia', 'Tutte le domande inerenti al diritto e all\'economia'),
(5, 'Matematica', 'Tutte le domande inerenti alla matematica'),
(6, 'Fisica', 'Tutte le domande inerenti alla fisica'),
(7, 'Chimica', 'Tutte le domande inerenti alla chimica'),
(8, 'Scienze della terra', 'Tutte le domande inerenti alle scienze della terra e biologia'),
(9, 'Tecnologie informatiche', 'Tutte le domande facenti parte la materia Tecnologie Informatiche'),
(10, 'TRG', 'Tutte le domande inerenti alle tecnologie e tecniche di rappresentazione grafica'),
(11, 'Educazione fisica', 'domande dedicate allo sport e alle discipline motorie'),
(12, 'Scienze e tecnologie applicate', 'domande dedicate alle scienze e tecnologie applicate'),
(13, 'Informatica', 'Tutte le domande relative al programma di Informatica del triennio'),
(14, 'Sistemi e Reti', 'Tutte le domande relative sistemi e reti del programma del triennio'),
(15, 'TPSIT', 'Domande inerenti alle tecnologie e progettazione di sistemi informatici e delle telecomunicazioni'),
(16, 'Telecomunicazioni', 'Tutte le domande relative la materia Telecomunicazioni'),
(17, 'GEPRO', 'Tutte le domande relative la Gestione di Progetto, organizzazione e impresa'),
(18, 'Elettrotecnica', 'Tutte le domande riguardanti l\'elettronica e l\'elettrotecnica'),
(19, 'Sistemi', 'Tutte le domande relative sistemi triennio di elettrotecnica'),
(20, 'TPSEE', 'Tutte le domande relative TPSEE');

-- --------------------------------------------------------

--
-- Struttura della tabella `domande`
--

CREATE TABLE `domande` (
  `questionID` int(11) NOT NULL,
  `dataPubbl` datetime NOT NULL,
  `QuestionText` varchar(1000) NOT NULL,
  `nLike` int(11) NOT NULL DEFAULT 0,
  `categoriaID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `domande`
--

INSERT INTO `domande` (`questionID`, `dataPubbl`, `QuestionText`, `nLike`, `categoriaID`, `userID`) VALUES
(1, '2025-02-12 12:48:08', 'Perché D\'Annunzio era ossessionato dal Lusso?\nQualcuno mi può spiegare meglio il Decadentismo perché ho capito poco?\nGrazie mille per la disponibilità', 14, 1, 28),
(2, '2025-02-13 15:36:06', 'L’energia potenziale relativa alle forze intermolecolari può assumere valori positivi?\r\nperchè?', 3, 6, 24),
(3, '2025-02-16 12:37:12', 'Qual\'è la composizione chimica dell\'Acqua?', 0, 7, 24),
(4, '2025-02-16 12:40:43', 'perche html non è un linguaggio di programmazione?', 0, 13, 24),
(5, '2025-03-08 19:39:52', 'l\'accelerazione di gravita e la forza peso come sono in relazione tra di loro?', 0, 6, 29),
(6, '2025-03-08 19:48:45', 'Chi era Pascoli?', 0, 1, 29);

-- --------------------------------------------------------

--
-- Struttura della tabella `risposte`
--

CREATE TABLE `risposte` (
  `IDRisposta` int(11) NOT NULL,
  `dataPubbl` datetime NOT NULL,
  `testoRisposta` varchar(1000) NOT NULL,
  `nLike` int(11) NOT NULL,
  `questionID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `risposte`
--

INSERT INTO `risposte` (`IDRisposta`, `dataPubbl`, `testoRisposta`, `nLike`, `questionID`, `userID`) VALUES
(1, '2025-02-13 10:09:04', 'Gabriele D\'Annunzio era profondamente influenzato dall\'estetismo e dal Decadentismo, movimenti che esaltavano la bellezza, l\'arte e il lusso come valori supremi. Per lui, il lusso non era solo una questione materiale, ma un mezzo per distinguersi e trasformare la propria vita in un\'opera d\'arte. Abitava in residenze sontuose, collezionava oggetti preziosi e curava ogni dettaglio della sua immagine pubblica. Inoltre, il lusso rappresentava il suo desiderio di dominio e seduzione, sia sulle persone che sulla realtà stessa. Il Vittoriale degli Italiani, sua ultima dimora, è l’emblema della sua visione estetizzante della vita: un luogo ricco di simbolismi, eccessi e raffinatezze. Per D\'Annunzio, la bellezza e il lusso erano un’affermazione di sé, un modo per sfuggire alla banalità e imporsi come figura carismatica e superiore.', 0, 1, 29),
(2, '2025-02-13 10:09:04', 'Il Decadentismo è un movimento letterario nato tra la fine dell’800 e l’inizio del ‘900 come reazione al Positivismo e al Realismo. I suoi autori rifiutavano la visione razionale della realtà e cercavano rifugio nell’arte, nella bellezza e nelle esperienze sensoriali. Il poeta decadente si sentiva un essere superiore, un dandy o un esteta, in contrasto con la mediocrità della società borghese. Il linguaggio delle opere decadenti è ricco di simboli, musicalità e immagini suggestive, spesso ispirate al sogno, al mistero e all’irrazionale. Tra i principali esponenti ci sono Charles Baudelaire, Gabriele D\'Annunzio e Oscar Wilde. Il Decadentismo esprime una visione del mondo pessimistica e disillusa, ma al tempo stesso esalta il piacere e l’eccesso come forme di ribellione contro la monotonia della vita quotidiana.\r\n\r\n', 3, 1, 27),
(3, '2025-02-27 21:29:56', 'H2O: 2 atomi di idrogeno ed uno di ossigeno.', 0, 3, 29);

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `userID` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `classe` varchar(4) NOT NULL,
  `indirizzo` enum('nessuno','elettrotecnica','informatica') NOT NULL DEFAULT 'nessuno',
  `bio` varchar(500) DEFAULT NULL,
  `immagine` varchar(100) NOT NULL DEFAULT 'default.png',
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `privilegio` enum('USER','MODER','ADMIN') NOT NULL DEFAULT 'USER'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`userID`, `nome`, `cognome`, `classe`, `indirizzo`, `bio`, `immagine`, `email`, `password`, `privilegio`) VALUES
(13, 'Maurissio', 'paiasso', '1A', 'nessuno', NULL, 'default.png', 'mario.macaco@iisvittorioveneto.it', '$2y$10$t1.KS23HXHs7UPnwN/NSp.Fp.aVCt5bOtORnlMk3RSTpuu3N1mBE.', 'USER'),
(22, 'Mario', 'Rigoni Stern', '1B', 'nessuno', NULL, 'default.png', 'mario.rigoni@iisvittorioveneto.it', '$2y$10$g4cNBlui0JflcSesPq8Zme.b3vrqVe.DQTdXOuSxvcNW9jr5zFc1G', 'USER'),
(24, 'Toni', 'Sugaman', '3A', 'nessuno', NULL, 'default.png', 'toni.sugaman@iisvittorioveneto.it', '$2y$10$ddRgj/43bgdqkXsIfnGxIewxgL3cK9Xj.rsR.0/gNYJ6C7cHoXEF6', 'USER'),
(27, 'Mario', 'Rigoni Stern', '3B', 'nessuno', NULL, 'default.png', 'mario.rigonistern@iisvittorioveneto.it', '$2y$10$QHSpoe/Q/QM2gbashuQWOO26tYXBTuQgiBcmVINQ177Q6YRhuolV.', 'USER'),
(28, 'Andrea', 'Mondelli', '5C', 'informatica', 'mondei un dei pi bei\r\n', 'img_28_1742842688.jpg', 'andrea.mondelli@iisvittorioveneto.it', '$2y$10$MIx0I/SIaFzB3SNNNBvCl.S1JRetLXfesx84Dmvu7z9lxDkDnLndq', 'USER'),
(29, 'Francesco', 'Poletto', '5C', 'nessuno', 'IL PRESIDENTE', 'default.png', 'francesco.poletto@iisvittorioveneto.it', '$2y$10$0/EQBp0vRfQy7LddXLmmo.7LL8P3o1GjSVsNa5zkWBjmN1zHvjNma', 'ADMIN'),
(30, 'Gianni', 'Luise', '4C', 'nessuno', NULL, 'default.png', 'gianni.luise@iisvittorioveneto.it', '$2y$10$4NwuMqIC2ZHQXZSDZWj7xegvnMnPhxRSjuCr2EdXwuCPSsr0GMA.K', 'USER');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`IDCategoria`);

--
-- Indici per le tabelle `domande`
--
ALTER TABLE `domande`
  ADD PRIMARY KEY (`questionID`),
  ADD KEY `categoriaID` (`categoriaID`),
  ADD KEY `userID` (`userID`);

--
-- Indici per le tabelle `risposte`
--
ALTER TABLE `risposte`
  ADD PRIMARY KEY (`IDRisposta`),
  ADD KEY `questionID` (`questionID`),
  ADD KEY `userID` (`userID`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `categorie`
--
ALTER TABLE `categorie`
  MODIFY `IDCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT per la tabella `domande`
--
ALTER TABLE `domande`
  MODIFY `questionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `risposte`
--
ALTER TABLE `risposte`
  MODIFY `IDRisposta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `domande`
--
ALTER TABLE `domande`
  ADD CONSTRAINT `domande_ibfk_1` FOREIGN KEY (`categoriaID`) REFERENCES `categorie` (`IDCategoria`),
  ADD CONSTRAINT `domande_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `utenti` (`userID`);

--
-- Limiti per la tabella `risposte`
--
ALTER TABLE `risposte`
  ADD CONSTRAINT `risposte_ibfk_1` FOREIGN KEY (`questionID`) REFERENCES `domande` (`questionID`),
  ADD CONSTRAINT `risposte_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `utenti` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
