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
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_liaison` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `slug` longtext COLLATE utf8mb4_unicode_ci,
  `sous_menu_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_23A0E663E5713E` (`user_ajout_id`),
  KEY `IDX_23A0E6633B55E82` (`user_modif_id`),
  KEY `IDX_23A0E66EFDE915F` (`sous_menu_id`),
  CONSTRAINT `FK_23A0E6633B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_23A0E663E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_23A0E66EFDE915F` FOREIGN KEY (`sous_menu_id`) REFERENCES `sous_menu` (`id`)
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
-- Table structure for table `benin_revele`
--

DROP TABLE IF EXISTS `benin_revele`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `benin_revele` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `titre` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `liens` longtext COLLATE utf8mb4_unicode_ci,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grand_titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_52CD35693E5713E` (`user_ajout_id`),
  KEY `IDX_52CD356933B55E82` (`user_modif_id`),
  CONSTRAINT `FK_52CD356933B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_52CD35693E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `benin_revele`
--

LOCK TABLES `benin_revele` WRITE;
/*!40000 ALTER TABLE `benin_revele` DISABLE KEYS */;
/*!40000 ALTER TABLE `benin_revele` ENABLE KEYS */;
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
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `type_direction_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3E4AD1B33E5713E` (`user_ajout_id`),
  KEY `IDX_3E4AD1B333B55E82` (`user_modif_id`),
  KEY `IDX_3E4AD1B328306392` (`type_direction_id`),
  CONSTRAINT `FK_3E4AD1B328306392` FOREIGN KEY (`type_direction_id`) REFERENCES `type_direction` (`id`),
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
  `biographie` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `lien_decret` longtext COLLATE utf8mb4_unicode_ci,
  `intitule` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_ministre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_ministre_actuel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_directeur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_directeur_actuel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `image_code_fichier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `nb_lecture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nb_telechargement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `taille_fichier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `nb_liaison` int(11) DEFAULT NULL,
  `nb_telechargement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `taille_fichier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `affichage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` longtext COLLATE utf8mb4_unicode_ci,
  `nb_liaison` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `format_page` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `user_id` int(11) DEFAULT NULL,
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
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` longtext COLLATE utf8mb4_unicode_ci,
  `format_page` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
INSERT INTO `messenger_messages` VALUES (1,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:28:\\\"Symfony\\\\Component\\\\Mime\\\\Email\\\":6:{i:0;s:6:\\\"933847\\\";i:1;s:5:\\\"utf-8\\\";i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:16:\\\"admin1@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:19:\\\"Authentication Code\\\";}}s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:30:\\\"solution@solutechcorporate.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:16:\\\"Automatic Emails\\\";}}}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}','[]','default','2024-02-01 00:44:24','2024-02-01 00:44:24',NULL),(2,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:28:\\\"Symfony\\\\Component\\\\Mime\\\\Email\\\":6:{i:0;s:6:\\\"229498\\\";i:1;s:5:\\\"utf-8\\\";i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:16:\\\"admin1@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:19:\\\"Authentication Code\\\";}}s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:30:\\\"solution@solutechcorporate.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:16:\\\"Automatic Emails\\\";}}}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}','[]','default','2024-02-01 00:55:02','2024-02-01 00:55:02',NULL),(3,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:28:\\\"Symfony\\\\Component\\\\Mime\\\\Email\\\":6:{i:0;s:6:\\\"162784\\\";i:1;s:5:\\\"utf-8\\\";i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:16:\\\"admin1@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:19:\\\"Authentication Code\\\";}}s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:30:\\\"solution@solutechcorporate.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:16:\\\"Automatic Emails\\\";}}}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}','[]','default','2024-02-01 01:00:41','2024-02-01 01:00:41',NULL),(4,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:28:\\\"Symfony\\\\Component\\\\Mime\\\\Email\\\":6:{i:0;s:6:\\\"179670\\\";i:1;s:5:\\\"utf-8\\\";i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:16:\\\"admin1@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:19:\\\"Authentication Code\\\";}}s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:30:\\\"solution@solutechcorporate.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:16:\\\"Automatic Emails\\\";}}}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}','[]','default','2024-02-01 11:41:43','2024-02-01 11:41:43',NULL);
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
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_liaison` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `logo_armoirie` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
-- Table structure for table `multimedia`
--

DROP TABLE IF EXISTS `multimedia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `multimedia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lien` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_lien` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_613128633E5713E` (`user_ajout_id`),
  KEY `IDX_6131286333B55E82` (`user_modif_id`),
  CONSTRAINT `FK_6131286333B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_613128633E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multimedia`
--

LOCK TABLES `multimedia` WRITE;
/*!40000 ALTER TABLE `multimedia` DISABLE KEYS */;
/*!40000 ALTER TABLE `multimedia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_code_fichier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_liaison` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `sous_menu_id` int(11) DEFAULT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_140AB620CCD7E912` (`menu_id`),
  UNIQUE KEY `UNIQ_140AB620EFDE915F` (`sous_menu_id`),
  KEY `IDX_140AB6203E5713E` (`user_ajout_id`),
  KEY `IDX_140AB62033B55E82` (`user_modif_id`),
  CONSTRAINT `FK_140AB62033B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_140AB6203E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_140AB620CCD7E912` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`),
  CONSTRAINT `FK_140AB620EFDE915F` FOREIGN KEY (`sous_menu_id`) REFERENCES `sous_menu` (`id`)
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
-- Table structure for table `prestation`
--

DROP TABLE IF EXISTS `prestation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prestation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_51C88FAD3E5713E` (`user_ajout_id`),
  KEY `IDX_51C88FAD33B55E82` (`user_modif_id`),
  CONSTRAINT `FK_51C88FAD33B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_51C88FAD3E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestation`
--

LOCK TABLES `prestation` WRITE;
/*!40000 ALTER TABLE `prestation` DISABLE KEYS */;
/*!40000 ALTER TABLE `prestation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestation_detail`
--

DROP TABLE IF EXISTS `prestation_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prestation_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lien` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `description_detail` longtext COLLATE utf8mb4_unicode_ci,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B47B476E3E5713E` (`user_ajout_id`),
  KEY `IDX_B47B476E33B55E82` (`user_modif_id`),
  CONSTRAINT `FK_B47B476E33B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_B47B476E3E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestation_detail`
--

LOCK TABLES `prestation_detail` WRITE;
/*!40000 ALTER TABLE `prestation_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `prestation_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programme`
--

DROP TABLE IF EXISTS `programme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3DDCB9FF3E5713E` (`user_ajout_id`),
  KEY `IDX_3DDCB9FF33B55E82` (`user_modif_id`),
  CONSTRAINT `FK_3DDCB9FF33B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_3DDCB9FF3E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programme`
--

LOCK TABLES `programme` WRITE;
/*!40000 ALTER TABLE `programme` DISABLE KEYS */;
/*!40000 ALTER TABLE `programme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programme_detail`
--

DROP TABLE IF EXISTS `programme_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programme_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lien` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `description_detail` longtext COLLATE utf8mb4_unicode_ci,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_368222B93E5713E` (`user_ajout_id`),
  KEY `IDX_368222B933B55E82` (`user_modif_id`),
  CONSTRAINT `FK_368222B933B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_368222B93E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programme_detail`
--

LOCK TABLES `programme_detail` WRITE;
/*!40000 ALTER TABLE `programme_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `programme_detail` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refresh_tokens`
--

LOCK TABLES `refresh_tokens` WRITE;
/*!40000 ALTER TABLE `refresh_tokens` DISABLE KEYS */;
INSERT INTO `refresh_tokens` VALUES (1,'83740757246b8859db0cf4ee0cf2281f778b15d225a8272d36a5d053bd90488ea6e2764ad92333ba3863e1b618b260b1b48540921493ac4055d996b0c234e6c8','admin1@gmail.com','2024-01-12 23:47:58'),(2,'32f7d7dee22539321e8d200be6e4ac3576fbb6eefd79d5cb1d51e7cb485870bdcdcef89b18ea2cb912754edbabaf7eef3c8cb40554f75111ddc7dd0f9102b2a6','admin1@gmail.com','2024-01-13 00:00:41'),(3,'abf404048e7e1a08f127b24c2a3ed7b3716c8fb3b1f5da276ecbdf5f14cd58309411c12605a6c5ff087486dc967bdc08ddd3e169f19d80fe50cb7b9156416a5a','admin1@gmail.com','2024-01-13 00:22:08'),(4,'86dc6fb9d0751942e9b4a82642315dcd9b5a3bfcfd972c68f9178d804f47856b386d4f1a56c15534cc294402b459103e270c2014028313f8a78f002fbf864176','admin1@gmail.com','2024-01-27 10:01:45'),(5,'275615774a787e7bd1d820299404302fe67d312a652dce0b0125c2df9e32332c78311a2d473f9c114d1c10728f368b7596bf365306801412ef2aeea8d61021fd','admin1@gmail.com','2024-01-27 11:03:22'),(6,'dc251e1a3a36ae1c724102a99fa0f1a33f868f365d34d1685d24a95e3a948b1095bb0e3737aa83362417746c59363e3c74d430ae522a0ccbae1e6654047ecdb9','admin1@gmail.com','2024-01-27 17:37:40'),(7,'acd3817278040a24d542a9297321f82ab4f8df9d9653f5b6e863ee1ec9286d54a43adb93586494b820ee6c7f81b6f339cae55f4e3c36a2d5c7bc6a44fdc1ed26','admin1@gmail.com','2024-02-08 00:52:57'),(8,'5795efa400a0e5e4d5af68946984b82b39194f3153d6dfafaf163e8f8dd0013725e279036056fbdfb97a5ec9d85c3caea365e9accf0ff15ae25ea8be9228583b','admin1@gmail.com','2024-02-08 00:59:42'),(9,'b953197a87020ca9f7189504284472ab0b82efb076c68c514fd51a9f961e6d8e308ea5b64a6dfb55bdc6e84ad908285f26cfb22903b5c0ebe283167fe05df283','admin1@gmail.com','2024-02-08 01:01:24'),(10,'7915c2ba336763b8f91bbd039a23ed229c8ce358db691d1293968b1ec634626575054724b113b947e1b4038e06dd01059123b3777086e21a9c67573349480d20','admin1@gmail.com','2024-02-08 11:43:22');
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
  `affichage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` longtext COLLATE utf8mb4_unicode_ci,
  `format_page` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `nb_liaison` int(11) DEFAULT NULL,
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
-- Table structure for table `type_direction`
--

DROP TABLE IF EXISTS `type_direction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_direction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `lien` longtext COLLATE utf8mb4_unicode_ci,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8A8C90A33E5713E` (`user_ajout_id`),
  KEY `IDX_8A8C90A333B55E82` (`user_modif_id`),
  CONSTRAINT `FK_8A8C90A333B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_8A8C90A33E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_direction`
--

LOCK TABLES `type_direction` WRITE;
/*!40000 ALTER TABLE `type_direction` DISABLE KEYS */;
/*!40000 ALTER TABLE `type_direction` ENABLE KEYS */;
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
  `nb_liaison` int(11) DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modif` datetime DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_ajout_id` int(11) DEFAULT NULL,
  `user_modif_id` int(11) DEFAULT NULL,
  `auth_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  KEY `IDX_8D93D6493E5713E` (`user_ajout_id`),
  KEY `IDX_8D93D64933B55E82` (`user_modif_id`),
  CONSTRAINT `FK_8D93D64933B55E82` FOREIGN KEY (`user_modif_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_8D93D6493E5713E` FOREIGN KEY (`user_ajout_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin1@gmail.com','[\"ROLE_ADMIN\"]','$2y$13$8ni8mIDPltlmdbrOHcsbv.6./odrAmlU7KD42HqG/cfhnkQulYSLi',6,'2024-01-05 23:45:57','2024-01-06 00:00:00','0',NULL,NULL,'179670');
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

-- Dump completed on 2024-02-04 20:30:11
