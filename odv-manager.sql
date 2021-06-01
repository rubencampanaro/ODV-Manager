CREATE TABLE `amministrazione` (
  `codice` int(11) UNSIGNED NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `luogo_nascita` varchar(255) NOT NULL,
  `data_nascita` date NOT NULL,
  `sesso` char(1) NOT NULL,
  `codice_fiscale` char(16) NOT NULL,
  `residenza` varchar(255) NOT NULL,
  `telefono_abitazione` varchar(30) DEFAULT NULL,
  `cellulare` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ruolo` smallint(5) UNSIGNED NOT NULL,
  `squadra` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `azioni_volontariato` (
  `codice` smallint(5) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descrizione` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `benemerenze` (
  `codice` smallint(5) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descrizione` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `campi_azioni_volontariato` (
  `codice` smallint(5) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `predefinito` tinyint(1) NOT NULL,
  `obbligatorio` tinyint(1) NOT NULL,
  `azione_volontariato` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `campi_dati_utenti` (
  `codice` smallint(5) UNSIGNED NOT NULL,
  `tabella` varchar(255) NOT NULL,
  `campo` varchar(255) NOT NULL,
  `predefinito` tinyint(1) NOT NULL,
  `obbligatorio` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `campi_dati_utenti` (`codice`, `tabella`, `campo`, `predefinito`, `obbligatorio`) VALUES
(1, 'amministrazione', 'codice', 1, 1),
(2, 'amministrazione', 'cognome', 1, 1),
(3, 'amministrazione', 'nome', 1, 1),
(4, 'amministrazione', 'luogo_nascita', 1, 1),
(5, 'amministrazione', 'data_nascita', 1, 1),
(6, 'amministrazione', 'sesso', 1, 1),
(7, 'amministrazione', 'codice_fiscale', 1, 1),
(8, 'amministrazione', 'residenza', 1, 1),
(9, 'amministrazione', 'telefono_abitazione', 1, 0),
(10, 'amministrazione', 'cellulare', 1, 1),
(11, 'amministrazione', 'email', 1, 1),
(12, 'amministrazione', 'password', 1, 1),
(13, 'amministrazione', 'ruolo', 1, 1),
(14, 'volontari', 'codice', 1, 1),
(15, 'volontari', 'cognome', 1, 1),
(16, 'volontari', 'nome', 1, 1),
(17, 'volontari', 'luogo_nascita', 1, 1),
(18, 'volontari', 'data_nascita', 1, 1),
(19, 'volontari', 'sesso', 1, 1),
(20, 'volontari', 'codice_fiscale', 1, 1),
(21, 'volontari', 'residenza', 1, 1),
(22, 'volontari', 'telefono_abitazione', 1, 0),
(23, 'volontari', 'cellulare', 1, 1),
(24, 'volontari', 'email', 1, 1),
(25, 'volontari', 'password', 1, 1),
(26, 'volontari', 'ruolo', 1, 1),
(27, 'volontari', 'stato', 1, 1),
(28, 'volontari', 'data_iscrizione', 1, 1),
(29, 'volontari', 'note', 1, 0),
(30, 'volontari', 'tessera', 1, 0);

CREATE TABLE `ruoli` (
  `codice` smallint(5) UNSIGNED NOT NULL,
  `descrizione` varchar(255) NOT NULL,
  `predefinito` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ruoli` (`codice`, `descrizione`, `predefinito`) VALUES
(1, 'Amministratore', 1),
(2, 'Presidente', 1),
(3, 'Socio', 1),
(4, 'Volontario', 1);

CREATE TABLE `stati` (
  `codice` smallint(5) UNSIGNED NOT NULL,
  `descrizione` varchar(255) NOT NULL,
  `predefinito` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `stati` (`codice`, `descrizione`, `predefinito`) VALUES
(1, 'Attivo', 1),
(2, 'Inattivo', 1);

CREATE TABLE `volontari` (
  `codice` int(11) UNSIGNED NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `luogo_nascita` varchar(255) NOT NULL,
  `data_nascita` date NOT NULL,
  `sesso` char(1) NOT NULL,
  `codice_fiscale` char(16) NOT NULL,
  `residenza` varchar(255) NOT NULL,
  `telefono_abitazione` varchar(30) DEFAULT NULL,
  `cellulare` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ruolo` smallint(5) UNSIGNED NOT NULL,
  `stato` smallint(5) UNSIGNED NOT NULL,
  `data_iscrizione` date NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `tessera` varchar(255) DEFAULT NULL,
  `squadra` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `volontari_azioni` (
  `codice` int(11) UNSIGNED NOT NULL,
  `volontario` int(11) UNSIGNED NOT NULL,
  `tabella` varchar(15) NOT NULL,
  `azione_volontariato` smallint(5) UNSIGNED NOT NULL,
  `data_inizio` date NOT NULL,
  `data_fine` date NOT NULL,
  `ora_inizio` time NOT NULL,
  `ora_fine` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `volontari_azioni_dettagli` (
  `azione_volontariato` int(11) UNSIGNED NOT NULL,
  `campo` smallint(5) UNSIGNED NOT NULL,
  `valore` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `volontari_benemerenze` (
  `codice` int(11) NOT NULL,
  `volontario` int(11) UNSIGNED NOT NULL,
  `tabella` varchar(15) NOT NULL,
  `benemerenza` smallint(5) UNSIGNED NOT NULL,
  `data_conferimento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `amministrazione`
  ADD PRIMARY KEY (`codice`),
  ADD KEY `FK_ruolo_a` (`ruolo`);

ALTER TABLE `azioni_volontariato`
  ADD PRIMARY KEY (`codice`);

ALTER TABLE `benemerenze`
  ADD PRIMARY KEY (`codice`);

ALTER TABLE `campi_azioni_volontariato`
  ADD PRIMARY KEY (`codice`),
  ADD KEY `FK_azione_volontariato_cav` (`azione_volontariato`);

ALTER TABLE `campi_dati_utenti`
  ADD PRIMARY KEY (`codice`);

ALTER TABLE `ruoli`
  ADD PRIMARY KEY (`codice`);

ALTER TABLE `stati`
  ADD PRIMARY KEY (`codice`);

ALTER TABLE `volontari`
  ADD PRIMARY KEY (`codice`),
  ADD UNIQUE KEY `UC_tessera` (`tessera`),
  ADD KEY `FK_ruolo_v` (`ruolo`),
  ADD KEY `FK_stato_v` (`stato`);

ALTER TABLE `volontari_azioni`
  ADD PRIMARY KEY (`codice`),
  ADD KEY `FK_azione_volontariato_va` (`azione_volontariato`);

ALTER TABLE `volontari_azioni_dettagli`
  ADD PRIMARY KEY (`azione_volontariato`,`campo`),
  ADD KEY `FK_azione_volontariato_vad` (`azione_volontariato`),
  ADD KEY `FK_campo_vad` (`campo`);

ALTER TABLE `volontari_benemerenze`
  ADD PRIMARY KEY (`codice`),
  ADD KEY `FK_benemerenza_vb` (`benemerenza`);

ALTER TABLE `amministrazione`
  MODIFY `codice` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

ALTER TABLE `azioni_volontariato`
  MODIFY `codice` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `benemerenze`
  MODIFY `codice` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `campi_azioni_volontariato`
  MODIFY `codice` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `campi_dati_utenti`
  MODIFY `codice` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

ALTER TABLE `ruoli`
  MODIFY `codice` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `stati`
  MODIFY `codice` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `volontari`
  MODIFY `codice` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `volontari_azioni`
  MODIFY `codice` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `volontari_benemerenze`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `amministrazione`
  ADD CONSTRAINT `FK_ruolo_a` FOREIGN KEY (`ruolo`) REFERENCES `ruoli` (`codice`);

ALTER TABLE `campi_azioni_volontariato`
  ADD CONSTRAINT `FK_azione_volontariato_cav` FOREIGN KEY (`azione_volontariato`) REFERENCES `azioni_volontariato` (`codice`);

ALTER TABLE `volontari`
  ADD CONSTRAINT `FK_ruolo_v` FOREIGN KEY (`ruolo`) REFERENCES `ruoli` (`codice`),
  ADD CONSTRAINT `FK_stato_v` FOREIGN KEY (`stato`) REFERENCES `stati` (`codice`);

ALTER TABLE `volontari_azioni`
  ADD CONSTRAINT `FK_azione_volontariato_va` FOREIGN KEY (`azione_volontariato`) REFERENCES `azioni_volontariato` (`codice`);

ALTER TABLE `volontari_azioni_dettagli`
  ADD CONSTRAINT `FK_azione_volontariato_vad` FOREIGN KEY (`azione_volontariato`) REFERENCES `volontari_azioni` (`codice`),
  ADD CONSTRAINT `FK_campo_vad` FOREIGN KEY (`campo`) REFERENCES `campi_azioni_volontariato` (`codice`);

ALTER TABLE `volontari_benemerenze`
  ADD CONSTRAINT `FK_benemerenza_vb` FOREIGN KEY (`benemerenza`) REFERENCES `benemerenze` (`codice`);
COMMIT;
