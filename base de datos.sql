-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: localhost    Database: sql_learning_app
-- ------------------------------------------------------
-- Server version	9.4.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `level` enum('Básico','Intermedio') COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theory` text COLLATE utf8mb4_unicode_ci,
  `practice_question` text COLLATE utf8mb4_unicode_ci,
  `expected_query` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,'Básico','Introducción a SQL','SQL (Structured Query Language) es un lenguaje usado para interactuar con bases de datos relacionales.','Selecciona todos los registros de la tabla empleados.','SELECT * FROM empleados;'),(2,'Básico','Filtrado de datos con WHERE','La cláusula WHERE se usa para filtrar registros que cumplen una condición.','Muestra los empleados cuyo salario sea mayor a 3000.','SELECT * FROM empleados WHERE salario > 3000;'),(3,'Básico','Ordenar resultados con ORDER BY','ORDER BY ordena los resultados ascendente o descendente.','Muestra todos los empleados ordenados por nombre.','SELECT * FROM empleados ORDER BY nombre;'),(4,'Intermedio','Uniones (JOIN)','Las uniones permiten combinar datos de múltiples tablas basadas en una relación común.','Combina empleados con sus departamentos.','SELECT e.nombre, d.nombre_departamento FROM empleados e JOIN departamentos d ON e.id_departamento = d.id;'),(5,'Intermedio','Funciones de agregación','Las funciones de agregación permiten calcular valores como SUM, AVG, COUNT, MAX, MIN.','Muestra el promedio de salario de todos los empleados.','SELECT AVG(salario) FROM empleados;'),(6,'Intermedio','Subconsultas','Una subconsulta es una consulta dentro de otra consulta.','Muestra los empleados cuyo salario es mayor al promedio.','SELECT * FROM empleados WHERE salario > (SELECT AVG(salario) FROM empleados);');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_results`
--

DROP TABLE IF EXISTS `exam_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam_results` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `nivel` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nota` decimal(5,2) NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_results`
--

LOCK TABLES `exam_results` WRITE;
/*!40000 ALTER TABLE `exam_results` DISABLE KEYS */;
INSERT INTO `exam_results` VALUES (1,2,'Básico',20.00,'2025-10-09 07:04:27'),(2,2,'Intermedio',0.00,'2025-10-09 07:05:44'),(3,3,'Básico',6.00,'2025-10-09 07:43:55'),(4,5,'Básico',6.00,'2025-10-09 10:30:41'),(5,6,'Básico',8.00,'2025-10-09 11:13:04'),(6,11,'Básico',4.00,'2025-11-25 09:55:17'),(7,15,'Básico',4.00,'2025-11-26 03:27:25');
/*!40000 ALTER TABLE `exam_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,1,'Hola a todos, ¿alguien sabe cómo usar JOIN correctamente?','2025-10-09 11:45:49',NULL),(2,1,'Compartan sus ejercicios de práctica SQL.','2025-10-09 11:45:49',NULL),(3,2,'Hola, soy ilson','2025-10-09 11:46:53',NULL),(4,3,'Hola','2025-10-09 11:51:34',NULL),(5,3,'HOLA','2025-10-09 16:16:01',NULL),(6,3,'necesito ayuda','2025-10-09 18:41:08',NULL),(7,7,':V','2025-10-10 21:35:22',NULL),(8,11,'Pregunta: Diferencia entre JOIN y Subconsultas\r\nTítulo: ¿Cuándo es más eficiente usar JOIN vs Subconsultas en casos prácticos?\r\n\r\nCuerpo:\r\nHola comunidad, estoy practicando SQL y me surgió una duda sobre optimización. Tengo estos dos ejercicios donde obtengo el mismo resultado, pero no sé cuál approach es mejor:\r\n\r\nEjercicio: Obtener los nombres de clientes que han realizado pedidos en el último mes.\r\n\r\nOpción A (con JOIN):\r\n\r\nsql\r\nSELECT DISTINCT c.nombre\r\nFROM clientes c\r\nJOIN pedidos p ON c.id = p.cliente_id\r\nWHERE p.fecha >= DATE_SUB(NOW(), INTERVAL 1 MONTH);\r\nOpción B (con Subconsulta):\r\n\r\nsql\r\nSELECT nombre\r\nFROM clientes\r\nWHERE id IN (\r\n    SELECT cliente_id\r\n    FROM pedidos\r\n    WHERE fecha >= DATE_SUB(NOW(), INTERVAL 1 MONTH)\r\n);\r\n¿Cuál sería más recomendable en términos de rendimiento? ¿Y si la tabla de pedidos tiene millones de registros?','2025-11-25 15:00:32',NULL),(9,11,'Pregunta 1: Diferencia entre JOIN y Subconsultas\r\nTítulo: ¿Cuándo es más eficiente usar JOIN vs Subconsultas en casos prácticos?\r\n\r\nCuerpo:\r\nHola comunidad, estoy practicando SQL y me surgió una duda sobre optimización. Tengo estos dos ejercicios donde obtengo el mismo resultado, pero no sé cuál approach es mejor:\r\n\r\nEjercicio: Obtener los nombres de clientes que han realizado pedidos en el último mes.','2025-11-25 15:00:56',NULL),(10,11,'hola\r\nmundo','2025-11-25 15:01:04',NULL),(11,11,'¿Cuál es la diferencia entre hacer un JOIN en el FROM vs usar WHERE para relacionar tablas? ¿Dan el mismo resultado?','2025-11-25 15:01:22',NULL),(12,11,'1. JOIN vs WHERE\r\n¿Cuál es la diferencia entre hacer un JOIN en el FROM vs usar WHERE para relacionar tablas? ¿Dan el mismo resultado?\r\n\r\nsql\r\n-- Opción A\r\nSELECT * FROM tabla1 t1\r\nJOIN tabla2 t2 ON t1.id = t2.id;\r\n\r\n-- Opción B  \r\nSELECT * FROM tabla1 t1, tabla2 t2\r\nWHERE t1.id = t2.id;','2025-11-25 15:02:46',NULL),(13,11,'¿Por qué COUNT(*) y COUNT(columna) me dan resultados diferentes cuando hay NULLs?','2025-11-25 15:04:00',NULL),(14,11,'GROUP BY con columnas no agrupadas\r\n\r\n¿Por qué necesito poner en GROUP BY todas las columnas que no son agregadas?\r\n\r\n-- Error:\r\nSELECT departamento, nombre, AVG(salario)\r\nFROM empleados\r\nGROUP BY departamento;','2025-11-25 15:04:19',NULL),(15,11,'DELETE con JOIN\r\n\r\n¿Cómo elimino registros de una tabla usando condiciones de otra tabla?\r\nEjemplo: borrar clientes que no tienen pedidos.','2025-11-25 15:04:36',NULL),(16,11,'JOIN vs WHERE\r\n\r\n¿Cuál es la diferencia entre hacer un JOIN en el FROM vs usar WHERE para relacionar tablas? ¿Dan el mismo resultado?\r\n\r\n-- Opción A\r\nSELECT * FROM tabla1 t1\r\nJOIN tabla2 t2 ON t1.id = t2.id;\r\n\r\n-- Opción B  \r\nSELECT * FROM tabla1 t1, tabla2 t2\r\nWHERE t1.id = t2.id;','2025-11-25 15:05:04',NULL),(17,11,'LIMIT en subconsultas\r\n¿Por qué no puedo usar LIMIT en una subconsulta con IN?\r\n\r\n-- Esto da error:\r\nSELECT * FROM usuarios \r\nWHERE id IN (SELECT id FROM pedidos LIMIT 10);','2025-11-25 15:05:23',NULL),(18,11,'Hola','2025-11-25 15:12:44',NULL),(19,14,'HOLAS','2025-11-26 05:30:05',NULL),(20,14,'SPY IOLÑSOMN','2025-11-26 05:30:14','uploads/1764135014_feliz.jpg'),(21,14,'FSDFSD','2025-11-26 05:33:11','uploads/1764135191_istockphoto-1682296067-612x612.jpg'),(22,14,'<b>SDFSDF</b>','2025-11-26 05:33:18','uploads/1764135198_1a676d658fd9b78fdaea59bb1bfeb83d.jpg'),(23,14,'<b>HOLA</b>, <i>SOY</i> <u>HANS.</u>','2025-11-26 05:34:47','uploads/1764135287_feliz.jpg'),(24,14,'<b>Hola,</b> soy <i>hans</i>. <u>Mucho gusto.</u>','2025-11-26 06:02:26','uploads/1764136946_feliz.jpg'),(25,15,'<i style=\"\">Hola</i>, soy <b>Ilson</b>. <u>Encantado</u> de conocerlos.','2025-11-26 06:40:00','uploads/1764139200_encantado-conocerlos-gente-negocios-estrechando-mano-primera-reunion_116547-99662.avif'),(26,15,'I <b>love</b> <u><i>SQL.</i></u>','2025-11-26 06:45:15',NULL),(27,15,'<i>Buenos</i> días colegas.<br><br>¿<b>Libros de <u>SQL</u></b> que puedan recomendarme?','2025-11-26 06:46:18',NULL);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quizzes`
--

DROP TABLE IF EXISTS `quizzes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quizzes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int DEFAULT NULL,
  `question` text COLLATE utf8mb4_unicode_ci,
  `option_a` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_b` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_c` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correct_option` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quizzes`
--

LOCK TABLES `quizzes` WRITE;
/*!40000 ALTER TABLE `quizzes` DISABLE KEYS */;
INSERT INTO `quizzes` VALUES (1,1,'¿Qué significa SQL?','Structured Query Language','Simple Query List','Standard Quick Language','A'),(2,1,'¿Cuál comando se usa para mostrar datos?','SHOW','DISPLAY','SELECT','C'),(3,2,'¿Qué hace WHERE?','Filtra datos','Ordena datos','Elimina datos','A'),(4,3,'¿Qué hace ORDER BY?','Filtra registros','Ordena resultados','Crea tablas','B'),(5,4,'¿Qué tipo de unión devuelve todos los registros comunes entre dos tablas?','INNER JOIN','OUTER JOIN','CROSS JOIN','A'),(6,5,'¿Qué función devuelve el número de filas?','SUM()','COUNT()','AVG()','B');
/*!40000 ALTER TABLE `quizzes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ranking_usuarios`
--

DROP TABLE IF EXISTS `ranking_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ranking_usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `puntos_totales` int DEFAULT '0',
  `actualizado` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ranking_usuarios`
--

LOCK TABLES `ranking_usuarios` WRITE;
/*!40000 ALTER TABLE `ranking_usuarios` DISABLE KEYS */;
INSERT INTO `ranking_usuarios` VALUES (1,1,40,'2025-11-25 14:39:19'),(2,3,30,'2025-11-25 14:39:19'),(3,8,80,'2025-11-25 14:39:19'),(4,2,100,'2025-11-25 14:39:19'),(5,11,300,'2025-11-25 14:39:41'),(6,7,20,'2025-11-25 14:39:19'),(7,10,40,'2025-11-25 14:39:19'),(8,15,400,'2025-11-26 15:30:46'),(9,14,150,'2025-11-20 14:39:19');
/*!40000 ALTER TABLE `ranking_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `replies`
--

DROP TABLE IF EXISTS `replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `replies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  CONSTRAINT `replies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `replies`
--

LOCK TABLES `replies` WRITE;
/*!40000 ALTER TABLE `replies` DISABLE KEYS */;
INSERT INTO `replies` VALUES (1,1,1,'Sí, usa la sintaxis: SELECT * FROM A JOIN B ON A.id = B.id;','2025-10-09 11:45:49'),(2,4,3,'Hola','2025-10-09 11:51:51'),(3,3,3,'Hola','2025-10-09 11:51:56'),(4,3,3,'hola','2025-10-09 18:40:49'),(5,6,3,'dfsfsdfsdf','2025-10-09 18:41:12'),(6,6,3,'dsfsdf','2025-10-09 18:41:14'),(7,6,3,'sdfsdf','2025-10-09 18:41:15'),(8,6,3,'sdfsdf','2025-10-09 18:41:22'),(9,5,7,'HOLA','2025-10-10 21:35:16'),(10,18,12,'Hola compañero. ','2025-11-25 15:12:52'),(11,24,14,'soy yo Xd','2025-11-26 06:08:24'),(12,24,14,'xd','2025-11-26 06:09:40'),(13,24,14,'hola','2025-11-26 06:10:57'),(14,24,14,'sip xd','2025-11-26 06:11:04'),(15,24,15,'HOLA.','2025-11-26 06:44:11'),(16,22,15,'HOLA','2025-11-26 06:44:26'),(17,21,15,'HOLA','2025-11-26 06:44:33');
/*!40000 ALTER TABLE `replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `retos`
--

DROP TABLE IF EXISTS `retos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `retos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `nivel` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resultado` enum('correcto','incorrecto') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `retos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `retos`
--

LOCK TABLES `retos` WRITE;
/*!40000 ALTER TABLE `retos` DISABLE KEYS */;
/*!40000 ALTER TABLE `retos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `retos_completados`
--

DROP TABLE IF EXISTS `retos_completados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `retos_completados` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `nivel` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `puntos` int DEFAULT NULL,
  `fecha_completado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `retos_completados_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `retos_completados`
--

LOCK TABLES `retos_completados` WRITE;
/*!40000 ALTER TABLE `retos_completados` DISABLE KEYS */;
/*!40000 ALTER TABLE `retos_completados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_progress`
--

DROP TABLE IF EXISTS `user_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_progress` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `course_id` int DEFAULT NULL,
  `quiz_id` int DEFAULT NULL,
  `completed` tinyint(1) DEFAULT '1',
  `earned_points` int DEFAULT '0',
  `completed_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `score` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`),
  KEY `quiz_id` (`quiz_id`),
  CONSTRAINT `user_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `user_progress_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  CONSTRAINT `user_progress_ibfk_3` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_progress`
--

LOCK TABLES `user_progress` WRITE;
/*!40000 ALTER TABLE `user_progress` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_progress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('admin','student') COLLATE utf8mb4_unicode_ci DEFAULT 'student',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'default.png',
  `bio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `bg_color` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT '#667eea',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@demo.com','$2y$10$uJ8t7xZC8CGDMyR7kQzDpe6K3b6EZpjNGx7lBBSOAWPyOhsMNeV1u','2025-10-09 11:45:28','admin','default.png','','#667eea'),(2,'ilson','ilson@example.com','$2y$10$QAVaXSQwisfDb5MOYU58FeOEafLiX6kfl3DSOu8WPUeD26guhPFx6','2025-10-09 11:46:17','admin','default.png','','#667eea'),(3,'alison','122@example.com','$2y$10$u4orDlKoifoNs6HfJX.yMeigFyXKuogcqeV3V7DdKpmVAw1kNgymu','2025-10-09 11:51:18','student','default.png','','#667eea'),(7,'yerson1','yerson1@example.com','$2y$10$4RDsUtwS/y.n.wE.2ODzFOoOO3YR4Qzr/DpdfQYo4J9TcuBcxxGgi','2025-10-10 21:34:58','student','default.png','','#667eea'),(8,'daniel','daniel@example.com','$2y$10$jWb.cgeDpZlqETksIV5o.OxktgaThqLbhfJxuTct0rzq4mJhPhX1a','2025-10-29 16:17:31','student','default.png','','#667eea'),(10,'yerson2','yerson@example.com','$2y$10$ofM6e.V.JjisAUHXMB7bjeKO5euu5Gq8bt5p66C0L06pnmUQY1wRO','2025-11-05 16:22:33','student','default.png','','#667eea'),(11,'luffy','luffy@example.com','$2y$10$1HbkP/L1GTr9i09pnzxWyuFe/LSNSX0XBHzKd5MPTufBARc.SVX4K','2025-11-25 14:14:53','student','user_11_1764082068.jpg','Hola, soy Luffy.','#49c7d0'),(12,'ilson7','ilson7@gmail.com','$2y$10$pW0llVNqxeWw.ek0RVi1munNR10VSSTVVcKkZrKGipbDzNz1fTskO','2025-11-25 15:11:08','student','user_12_1764083859.jpg','','#ffff00'),(13,'Tom','tom@ezamole.com','$2y$10$W5yHh8qDGcvbBowaDR/E2eybZGz3QR2NuzE9D4Qag/OdjZCFz3Imy','2025-11-25 15:11:41','student','user_13_1764083819.jpg','','#ffffff'),(14,'hans','hans@example.com','$2y$10$/BtFkjB5nsS57ifR30wVLeNaaHmQGDIMISJUmSfxRvu1bRh67q.ga','2025-11-26 04:54:55','student','user_14_1764138650.jpg','Hola, soy Hans.','#2d3436'),(15,'ilsonesis','ilson@esis.com','$2y$10$3MNcCiuhdWIeqboEvv6hy.cVmDpkeMJhukB5Z4bZzBBT6nv/30MtK','2025-11-26 06:36:19','student','user_15_1764139127.jpg','Maestro de Ajedrez y Estudiante de Ing. de Sistemas en la UNJBG y Arquitectura en la UPT.','#2d3436');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-26 10:41:11
