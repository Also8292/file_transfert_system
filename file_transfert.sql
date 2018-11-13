-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.19 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Export de la structure de la base pour file_transfert
CREATE DATABASE IF NOT EXISTS `file_transfert` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `file_transfert`;

-- Export de la structure de la table file_transfert. emetteurs
CREATE TABLE IF NOT EXISTS `emetteurs` (
  `id_emetteur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `email_emetteur` varchar(255) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id_emetteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Export de données de la table file_transfert.emetteurs : ~0 rows (environ)
/*!40000 ALTER TABLE `emetteurs` DISABLE KEYS */;
/*!40000 ALTER TABLE `emetteurs` ENABLE KEYS */;

-- Export de la structure de la table file_transfert. fichiers
CREATE TABLE IF NOT EXISTS `fichiers` (
  `id_fichier` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `date_transfert` datetime NOT NULL,
  PRIMARY KEY (`id_fichier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Export de données de la table file_transfert.fichiers : ~0 rows (environ)
/*!40000 ALTER TABLE `fichiers` DISABLE KEYS */;
/*!40000 ALTER TABLE `fichiers` ENABLE KEYS */;

-- Export de la structure de la table file_transfert. fichier_recepteur
CREATE TABLE IF NOT EXISTS `fichier_recepteur` (
  `id_fichier` int(11) NOT NULL,
  `id_recepteur` int(11) NOT NULL,
  PRIMARY KEY (`id_fichier`,`id_recepteur`),
  KEY `FK_recepteur` (`id_recepteur`),
  CONSTRAINT `FK_fichier` FOREIGN KEY (`id_fichier`) REFERENCES `fichiers` (`id_fichier`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_recepteur` FOREIGN KEY (`id_recepteur`) REFERENCES `recepteurs` (`id_recepteur`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Export de données de la table file_transfert.fichier_recepteur : ~0 rows (environ)
/*!40000 ALTER TABLE `fichier_recepteur` DISABLE KEYS */;
/*!40000 ALTER TABLE `fichier_recepteur` ENABLE KEYS */;

-- Export de la structure de la table file_transfert. recepteurs
CREATE TABLE IF NOT EXISTS `recepteurs` (
  `id_recepteur` int(11) NOT NULL AUTO_INCREMENT,
  `email_recepteur` varchar(255) NOT NULL,
  PRIMARY KEY (`id_recepteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Export de données de la table file_transfert.recepteurs : ~0 rows (environ)
/*!40000 ALTER TABLE `recepteurs` DISABLE KEYS */;
/*!40000 ALTER TABLE `recepteurs` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
