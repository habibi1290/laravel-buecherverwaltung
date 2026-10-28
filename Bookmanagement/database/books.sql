/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.14-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: db    Database: db
-- ------------------------------------------------------
-- Server version	10.11.14-MariaDB-ubu2204-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` (`id`, `title`, `author`, `category`, `isbn`, `cover`, `description`, `created_at`, `updated_at`) VALUES (15,'der junge mit gestreiften pyjama','john boyne','Kinder- und Jugendroman','9783733605704','http://books.google.com/books/content?id=f9CVEAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api','Die Geschichte von »Der Junge im gestreiften Pyjama« ist schwer zu beschreiben. Normalerweise geben wir an dieser Stelle ein paar Hinweise auf den Inhalt, aber bei diesem Buch - so glauben wir - ist es besser, wenn man vorher nicht weiß, worum es geht. Wer zu lesen beginnt, begibt sich auf eine Reise mit einem neunjährigen Jungen namens Bruno. (Und doch ist es kein Buch für Neunjährige.) Früher oder später kommt er mit Bruno an einen Zaun. Zäune wie dieser existieren auf der ganzen Welt. Preise und Auszeichnungen für »Der Junge im gestreiften Pyjama«: - Nominiert für den Deutschen Jugendliteraturpreis 2008 (Jugendjury) - Buch des Monats Dezember 2007 der Deutschen Akademie für Kinder- und Jugendliteratur e.V., Volkach - Empfehlungsliste des Katholischen Kinder- und Jugendbuchpreises 2008 - Ausgezeichnet als Penguin Orange Readers\' Group Book of the Year 2009 - Ausgezeichnet mit dem Irish Book Award: Bestes Kinderbuch des Jahres - Ausgezeichnet mit dem Listener\'s Choice Book of the Year: Bestes Hörbuch des Jahres (UK) - Nominiert für die Carnegie Medal (UK) - Nominiert für den Ottakar\'s Book Prize (UK) - Nominiert für den Paolo Ungari Prize (Italien)','2026-05-11 11:42:11','2026-05-11 11:42:11'),
(18,'Finanzen ganz einfach','Saidi Sulilatu','Wirtschaft','9783426563021','http://books.google.com/books/content?id=pdFUEQAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api','Zu Finanzen gibt es schon genug Märchen. Zeit für ein unabhängiges Sachbuch. Wie du deine Finanzen souverän in den Griff kriegst und gelassen für dich, deine Familie und deine Zukunft vorsorgst: Saidi Sulilatu zeigt dir, wie Finanzen ganz einfach gehen. Umfassend, unabhängig und leicht umzusetzen. »Wie baue ich Vermögen auf, wenn die Rente unsicher ist? Kann ich mir jemals eine Immobilie leisten? Wie behalte ich bei all den Finanzprodukten noch den Überblick?« Die finanzielle Zukunft ist komplizierter geworden. Saidi Sulilatu weiß aus eigener Erfahrung, welche teuren Fehler Menschen bei diesen Themen machen. Als Chefredakteur von Finanztip folgt er einer Mission: Finanzen einfach machen, damit jeder seine Geldangelegenheiten selbst regeln kann. In diesem Buch lernst du, wie du mit dem Finanztip-Prinzip deine Finanzen effektiv strukturierst und unkompliziert Rücklagen schaffst. Das Finanztip-Prinzip basiert auf dem Motto »Weniger ist mehr« und sorgt dafür, dass du keine unnötigen Verträge oder Anlagen hast. Stattdessen schaffst du es, durch kluges und gelassenes Investieren deine Altersvorsorge zu sichern und langfristig Vermögen aufzubauen. Saidi Sulilatu zeigt kenntnisreich und zugänglich: Wie du dein Sparen automatisierst Wie du es schaffst, dass dir dafür jeden Monat mehr übrigbleibt Wie du mit ETFs langfristig Vermögen aufbaust und deine Altersvorsorge sicherst Ob Investments wie Gold oder Krypto empfehlenswert sind Ob ein Immobilienkauf heute noch sinnvoll ist oder man lieber mieten sollte Welche Versicherungen du wirklich brauchst Wie du dich von finanziellen Altlasten befreist »Ein Buch für alle, die Finanzen nicht studieren möchten. Einfach loslegen – ohne komplizierte Sprache und Formeln.« Prof. Dr. Christine Laudenbach, Professorin für Finance, Goethe-Universität Frankfurt »Saidi Sulilatu und Finanztip stehen für Finanzbildung mit dem Konsumentenwohl im Fokus. Die Finanzfibel für deine finanzielle Zukunft.« Philipp Klöckner, Tech-Experte, Investor und Host des »Doppelgänger«-Podcasts','2026-05-11 11:50:58','2026-05-11 11:50:58'),
(21,'elf minuten 2','paulo coelho','Roman','9783257602579','http://books.google.com/books/content?id=lt9tAgAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api','Wie berührt man die Seele? Durch Liebe oder durch Lust? Kann man die Seele wie einen Körper berühren und umgekehrt? Ein provozierendes modernes Märchen über die Alchemie der Liebe.','2026-07-27 11:12:07','2026-07-27 11:12:55'),
(22,'der alchimist','paulo coelho','Roman','nicht vorhanden','http://books.google.com/books/content?id=o4MtAAAAYAAJ&printsec=frontcover&img=1&zoom=1&source=gbs_api','Santiago, ein andalusischer Hirte, hat einen wiederkehrenden Traum: Am Fuß der Pyramiden liege ein Schatz für ihn bereit. Soll er das Vertraute für möglichen Reichtum aufgeben? Santiago ist mutig genug, seinem Traum zu folgen. Er begibt sich auf eine Reise die ihn über die Souks in Tanger bis nach Ägypten führt, er findet in der Stille der Wüste auch zu sich selbst und erkennt, dass das Leben Schätze bereithält, die nicht mit Gold aufzuwiegen sind.','2026-10-27 17:26:36','2026-10-27 17:26:36');
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-28  8:54:43
