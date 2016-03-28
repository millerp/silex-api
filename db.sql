/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.10 : Database - silex-api
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`silex-api` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `silex-api`;

/*Table structure for table `estoque` */

DROP TABLE IF EXISTS `estoque`;

CREATE TABLE `estoque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filial_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `estoque_ibfk_1` (`filial_id`),
  KEY `estoque_ibfk_2` (`produto_id`),
  CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`filial_id`) REFERENCES `filial` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `estoque_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

/*Data for the table `estoque` */

insert  into `estoque`(`id`,`filial_id`,`produto_id`,`quantidade`) values (37,1,44,20),(38,1,5,21655),(39,1,6,12),(40,3,7,15);

/*Table structure for table `fabricante` */

DROP TABLE IF EXISTS `fabricante`;

CREATE TABLE `fabricante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `fabricante` */

insert  into `fabricante`(`id`,`nome`) values (3,'Fabricante 1'),(4,'Fabricante 2'),(5,'Fabricante 3'),(6,'Fabricante 4'),(17,'Fabricante 6');

/*Table structure for table `filial` */

DROP TABLE IF EXISTS `filial`;

CREATE TABLE `filial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `filial` */

insert  into `filial`(`id`,`nome`) values (1,'Filial 1'),(2,'Filial 2'),(3,'Filial 3'),(4,'Filial 4');

/*Table structure for table `produto` */

DROP TABLE IF EXISTS `produto`;

CREATE TABLE `produto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `fabricante_id` int(11) NOT NULL,
  `garantia` varchar(30) DEFAULT NULL,
  `grade` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fabricante_id` (`fabricante_id`),
  CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`fabricante_id`) REFERENCES `fabricante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

/*Data for the table `produto` */

insert  into `produto`(`id`,`nome`,`fabricante_id`,`garantia`,`grade`) values (5,'Produto 5',5,'1 ano','0'),(6,'Produto 6',5,'1 ano','0'),(7,'Produto 7',5,'1 ano','0'),(8,'Produto 4',6,'6 meses','0'),(44,'Produto Xablau',5,'asodpfkas','0');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
