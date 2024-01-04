-- MySQL dump 10.13  Distrib 5.7.23, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: mpmepe_api
-- ------------------------------------------------------
-- Server version	5.7.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_code_fichier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_event` datetime NOT NULL,
  `visibility` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publication_date` datetime NOT NULL,
  `is_mention` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_flashinfo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` int(11) NOT NULL,
  `nb_liaison` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_23A0E663E5713E` (`user_ajout_id`),
  KEY `IDX_23A0E6633B55E82` (`user_modif_id`),
  CONSTRAINT `FK_23A0E6633B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_23A0E663E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_galerie`
--

DROP TABLE IF EXISTS `article_galerie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_galerie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `galerie_id` int(11) NOT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_73AF51277294869C` (`article_id`),
  KEY `IDX_73AF5127825396CB` (`galerie_id`),
  KEY `IDX_73AF51273E5713E` (`user_ajout_id`),
  KEY `IDX_73AF512733B55E82` (`user_modif_id`),
  CONSTRAINT `FK_73AF512733B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_73AF51273E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_73AF51277294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  CONSTRAINT `FK_73AF5127825396CB` FOREIGN KEY (`galerie_id`) REFERENCES `galerie` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_galerie`
--

LOCK TABLES `article_galerie` WRITE;
/*!40000 ALTER TABLE `article_galerie` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_galerie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_tag`
--

DROP TABLE IF EXISTS `article_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_919694F97294869C` (`article_id`),
  KEY `IDX_919694F9BAD26311` (`tag_id`),
  KEY `IDX_919694F93E5713E` (`user_ajout_id`),
  KEY `IDX_919694F933B55E82` (`user_modif_id`),
  CONSTRAINT `FK_919694F933B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_919694F93E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_919694F97294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  CONSTRAINT `FK_919694F9BAD26311` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_tag`
--

LOCK TABLES `article_tag` WRITE;
/*!40000 ALTER TABLE `article_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorie_document`
--

DROP TABLE IF EXISTS `categorie_document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorie_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_liaison` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E0EECB1C3E5713E` (`user_ajout_id`),
  KEY `IDX_E0EECB1C33B55E82` (`user_modif_id`),
  CONSTRAINT `FK_E0EECB1C33B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_E0EECB1C3E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie_document`
--

LOCK TABLES `categorie_document` WRITE;
/*!40000 ALTER TABLE `categorie_document` DISABLE KEYS */;
/*!40000 ALTER TABLE `categorie_document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_prenom` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `objet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_liaison` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_valeur_demande`
--

DROP TABLE IF EXISTS `contact_valeur_demande`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_valeur_demande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `valeur_demande_id` int(11) NOT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_969E5BE2E7A1254A` (`contact_id`),
  KEY `IDX_969E5BE2757C56E3` (`valeur_demande_id`),
  CONSTRAINT `FK_969E5BE2757C56E3` FOREIGN KEY (`valeur_demande_id`) REFERENCES `valeur_demande` (`id`),
  CONSTRAINT `FK_969E5BE2E7A1254A` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_valeur_demande`
--

LOCK TABLES `contact_valeur_demande` WRITE;
/*!40000 ALTER TABLE `contact_valeur_demande` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_valeur_demande` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `copyright`
--

DROP TABLE IF EXISTS `copyright`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `copyright` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `texte` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mention_legale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_388115F33E5713E` (`user_ajout_id`),
  KEY `IDX_388115F333B55E82` (`user_modif_id`),
  CONSTRAINT `FK_388115F333B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_388115F33E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `copyright`
--

LOCK TABLES `copyright` WRITE;
/*!40000 ALTER TABLE `copyright` DISABLE KEYS */;
/*!40000 ALTER TABLE `copyright` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demande`
--

DROP TABLE IF EXISTS `demande`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_liaison` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2694D7A53E5713E` (`user_ajout_id`),
  KEY `IDX_2694D7A533B55E82` (`user_modif_id`),
  CONSTRAINT `FK_2694D7A533B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_2694D7A53E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demande`
--

LOCK TABLES `demande` WRITE;
/*!40000 ALTER TABLE `demande` DISABLE KEYS */;
/*!40000 ALTER TABLE `demande` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `direction`
--

DROP TABLE IF EXISTS `direction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `direction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sigle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_liaison` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3E4AD1B33E5713E` (`user_ajout_id`),
  KEY `IDX_3E4AD1B333B55E82` (`user_modif_id`),
  CONSTRAINT `FK_3E4AD1B333B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_3E4AD1B33E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direction`
--

LOCK TABLES `direction` WRITE;
/*!40000 ALTER TABLE `direction` DISABLE KEYS */;
/*!40000 ALTER TABLE `direction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dirigeant`
--

DROP TABLE IF EXISTS `dirigeant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dirigeant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ministere_id` int(11) NOT NULL,
  `direction_id` int(11) NOT NULL,
  `nom_prenoms` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `debut_fonction` datetime NOT NULL,
  `fin_fonction` datetime NOT NULL,
  `biographie` longtext COLLATE utf8mb4_unicode_ci,
  `lien_decret` longtext COLLATE utf8mb4_unicode_ci,
  `intitule` longtext COLLATE utf8mb4_unicode_ci,
  `is_ministre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_ministre_actuel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_directeur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_directeur_actuel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BEC71E71AD745416` (`ministere_id`),
  KEY `IDX_BEC71E71AF73D997` (`direction_id`),
  KEY `IDX_BEC71E713E5713E` (`user_ajout_id`),
  KEY `IDX_BEC71E7133B55E82` (`user_modif_id`),
  CONSTRAINT `FK_BEC71E7133B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_BEC71E713E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_BEC71E71AD745416` FOREIGN KEY (`ministere_id`) REFERENCES `ministere` (`id`),
  CONSTRAINT `FK_BEC71E71AF73D997` FOREIGN KEY (`direction_id`) REFERENCES `direction` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dirigeant`
--

LOCK TABLES `dirigeant` WRITE;
/*!40000 ALTER TABLE `dirigeant` DISABLE KEYS */;
/*!40000 ALTER TABLE `dirigeant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document`
--

DROP TABLE IF EXISTS `document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_code_fichier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titre` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `visibility` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publication_date` datetime NOT NULL,
  `nb_liaison` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nb_lecture` double DEFAULT NULL,
  `nb_telechargement` double DEFAULT NULL,
  `taille_fichier` double DEFAULT NULL,
  `extension_fichier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D8698A763E5713E` (`user_ajout_id`),
  KEY `IDX_D8698A7633B55E82` (`user_modif_id`),
  CONSTRAINT `FK_D8698A7633B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_D8698A763E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document`
--

LOCK TABLES `document` WRITE;
/*!40000 ALTER TABLE `document` DISABLE KEYS */;
/*!40000 ALTER TABLE `document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document_categorie_document`
--

DROP TABLE IF EXISTS `document_categorie_document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document_categorie_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `categorie_document_id` int(11) NOT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EC306CF5C33F7837` (`document_id`),
  KEY `IDX_EC306CF51CC15E3E` (`categorie_document_id`),
  CONSTRAINT `FK_EC306CF51CC15E3E` FOREIGN KEY (`categorie_document_id`) REFERENCES `categorie_document` (`id`),
  CONSTRAINT `FK_EC306CF5C33F7837` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document_categorie_document`
--

LOCK TABLES `document_categorie_document` WRITE;
/*!40000 ALTER TABLE `document_categorie_document` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_categorie_document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:ulid)',
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` double NOT NULL,
  `reference_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `temp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galerie`
--

DROP TABLE IF EXISTS `galerie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galerie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `code_fichier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titre` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `visibility` tinyint(1) NOT NULL,
  `publication_date` datetime DEFAULT NULL,
  `nb_liaison` int(11) DEFAULT NULL,
  `nb_telechargement` double DEFAULT NULL,
  `taille_fichier` double DEFAULT NULL,
  `extension_fichier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9E7D15903E5713E` (`user_ajout_id`),
  KEY `IDX_9E7D159033B55E82` (`user_modif_id`),
  CONSTRAINT `FK_9E7D159033B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_9E7D15903E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galerie`
--

LOCK TABLES `galerie` WRITE;
/*!40000 ALTER TABLE `galerie` DISABLE KEYS */;
/*!40000 ALTER TABLE `galerie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `header`
--

DROP TABLE IF EXISTS `header`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `affichage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slog` longtext COLLATE utf8mb4_unicode_ci,
  `nb_liaison` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6E72A8C13E5713E` (`user_ajout_id`),
  KEY `IDX_6E72A8C133B55E82` (`user_modif_id`),
  CONSTRAINT `FK_6E72A8C133B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_6E72A8C13E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `header`
--

LOCK TABLES `header` WRITE;
/*!40000 ALTER TABLE `header` DISABLE KEYS */;
/*!40000 ALTER TABLE `header` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historique`
--

DROP TABLE IF EXISTS `historique`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operation` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_table` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_table` int(11) NOT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EDBFD5ECA76ED395` (`user_id`),
  CONSTRAINT `FK_EDBFD5ECA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historique`
--

LOCK TABLES `historique` WRITE;
/*!40000 ALTER TABLE `historique` DISABLE KEYS */;
/*!40000 ALTER TABLE `historique` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_liaison` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `image_code_fichier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `lien` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7D053A932EF91FD8` (`header_id`),
  KEY `IDX_7D053A933E5713E` (`user_ajout_id`),
  KEY `IDX_7D053A9333B55E82` (`user_modif_id`),
  CONSTRAINT `FK_7D053A932EF91FD8` FOREIGN KEY (`header_id`) REFERENCES `header` (`id`),
  CONSTRAINT `FK_7D053A9333B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_7D053A933E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ministere`
--

DROP TABLE IF EXISTS `ministere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ministere` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo_code_fichier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom_site` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` longtext COLLATE utf8mb4_unicode_ci,
  `longitude` double DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_liaison` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_44118A5B3E5713E` (`user_ajout_id`),
  KEY `IDX_44118A5B33B55E82` (`user_modif_id`),
  CONSTRAINT `FK_44118A5B33B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_44118A5B3E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ministere`
--

LOCK TABLES `ministere` WRITE;
/*!40000 ALTER TABLE `ministere` DISABLE KEYS */;
/*!40000 ALTER TABLE `ministere` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_code_fichier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_liaison` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_140AB6203E5713E` (`user_ajout_id`),
  KEY `IDX_140AB62033B55E82` (`user_modif_id`),
  CONSTRAINT `FK_140AB62033B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_140AB6203E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page`
--

LOCK TABLES `page` WRITE;
/*!40000 ALTER TABLE `page` DISABLE KEYS */;
/*!40000 ALTER TABLE `page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_header`
--

DROP TABLE IF EXISTS `page_header`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `header_id` int(11) NOT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1A45EDFC4663E4` (`page_id`),
  KEY `IDX_1A45EDF2EF91FD8` (`header_id`),
  CONSTRAINT `FK_1A45EDF2EF91FD8` FOREIGN KEY (`header_id`) REFERENCES `header` (`id`),
  CONSTRAINT `FK_1A45EDFC4663E4` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_header`
--

LOCK TABLES `page_header` WRITE;
/*!40000 ALTER TABLE `page_header` DISABLE KEYS */;
/*!40000 ALTER TABLE `page_header` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refresh_tokens`
--

DROP TABLE IF EXISTS `refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refresh_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `refresh_token` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9BACE7E1C74F2195` (`refresh_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refresh_tokens`
--

LOCK TABLES `refresh_tokens` WRITE;
/*!40000 ALTER TABLE `refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `nb_liaison` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_57698A6A3E5713E` (`user_ajout_id`),
  KEY `IDX_57698A6A33B55E82` (`user_modif_id`),
  CONSTRAINT `FK_57698A6A33B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_57698A6A3E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_network`
--

DROP TABLE IF EXISTS `social_network`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_network` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_code_fichier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lien` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `affichage` int(11) NOT NULL,
  `header_is_select` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_is_select` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_is_select` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EFFF52213E5713E` (`user_ajout_id`),
  KEY `IDX_EFFF522133B55E82` (`user_modif_id`),
  CONSTRAINT `FK_EFFF522133B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_EFFF52213E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_network`
--

LOCK TABLES `social_network` WRITE;
/*!40000 ALTER TABLE `social_network` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_network` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sous_menu`
--

DROP TABLE IF EXISTS `sous_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sous_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `name` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F30864DFCCD7E912` (`menu_id`),
  KEY `IDX_F30864DF3E5713E` (`user_ajout_id`),
  KEY `IDX_F30864DF33B55E82` (`user_modif_id`),
  CONSTRAINT `FK_F30864DF33B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_F30864DF3E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_F30864DFCCD7E912` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sous_menu`
--

LOCK TABLES `sous_menu` WRITE;
/*!40000 ALTER TABLE `sous_menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `sous_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_389B7833E5713E` (`user_ajout_id`),
  KEY `IDX_389B78333B55E82` (`user_modif_id`),
  CONSTRAINT `FK_389B78333B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_389B7833E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_liaison` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  KEY `IDX_8D93D6493E5713E` (`user_ajout_id`),
  KEY `IDX_8D93D64933B55E82` (`user_modif_id`),
  CONSTRAINT `FK_8D93D64933B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_8D93D6493E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2DE8C6A3A76ED395` (`user_id`),
  KEY `IDX_2DE8C6A3D60322AC` (`role_id`),
  KEY `IDX_2DE8C6A33E5713E` (`user_ajout_id`),
  KEY `IDX_2DE8C6A333B55E82` (`user_modif_id`),
  CONSTRAINT `FK_2DE8C6A333B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_2DE8C6A33E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_2DE8C6A3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_2DE8C6A3D60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valeur_demande`
--

DROP TABLE IF EXISTS `valeur_demande`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valeur_demande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `demande_id` int(11) NOT NULL,
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_liaison` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E563D52280E95E18` (`demande_id`),
  KEY `IDX_E563D5223E5713E` (`user_ajout_id`),
  KEY `IDX_E563D52233B55E82` (`user_modif_id`),
  CONSTRAINT `FK_E563D52233B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_E563D5223E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_E563D52280E95E18` FOREIGN KEY (`demande_id`) REFERENCES `demande` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valeur_demande`
--

LOCK TABLES `valeur_demande` WRITE;
/*!40000 ALTER TABLE `valeur_demande` DISABLE KEYS */;
/*!40000 ALTER TABLE `valeur_demande` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-30 18:46:58
