-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: localhost    Database: medical
-- ------------------------------------------------------
-- Server version	5.7.18

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
-- Table structure for table `medicine`
--

DROP TABLE IF EXISTS `medicine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicine` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `std` varchar(45) NOT NULL DEFAULT '' COMMENT '药品编码，随机生成，可根据id来编写',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '药品名称',
  `spell` varchar(45) NOT NULL DEFAULT '' COMMENT '名称首字母拼音',
  `desc` varchar(500) DEFAULT '' COMMENT '描述',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `price` decimal(6,1) DEFAULT '0.0' COMMENT '价格（元/克）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='药品表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT '病人姓名',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别，0未知 1女 2男',
  `age` int(4) DEFAULT '0' COMMENT '年龄，存出生年份，展示根据当前年份减去出生年份',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `created_by` int(11) NOT NULL DEFAULT '0' COMMENT '创建人',
  `address` varchar(255) DEFAULT '' COMMENT '家庭地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='病人信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prescription`
--

DROP TABLE IF EXISTS `prescription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prescription` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应病人表的id',
  `etiology` varchar(500) NOT NULL DEFAULT '' COMMENT '病因',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '开单时间',
  `created_by` int(11) NOT NULL DEFAULT '0' COMMENT '开单人',
  `way` varchar(255) DEFAULT '' COMMENT '服用方式',
  `totalMoney` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '开单总金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COMMENT='病例表（药方表）';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prescription_detail`
--

DROP TABLE IF EXISTS `prescription_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prescription_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prescription_id` int(11) NOT NULL DEFAULT '0' COMMENT '药方表的id',
  `medicine_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应药品名称表id',
  `medicine_name` varchar(45) NOT NULL DEFAULT '' COMMENT '药品名称',
  `weight` decimal(6,1) NOT NULL DEFAULT '0.0' COMMENT '重量g',
  `amount` int(11) NOT NULL DEFAULT '0' COMMENT '份数',
  `price` decimal(6,1) NOT NULL DEFAULT '0.0' COMMENT '单价',
  `total` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '总价',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COMMENT='药方详情表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `prescription_view`
--

DROP TABLE IF EXISTS `prescription_view`;
/*!50001 DROP VIEW IF EXISTS `prescription_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `prescription_view` AS SELECT 
 1 AS `id`,
 1 AS `pid`,
 1 AS `pname`,
 1 AS `etiology`,
 1 AS `main_id`,
 1 AS `sex`,
 1 AS `age`,
 1 AS `address`,
 1 AS `mname`,
 1 AS `spell`,
 1 AS `mid`,
 1 AS `weight`,
 1 AS `amount`,
 1 AS `way`,
 1 AS `pdprice`,
 1 AS `mprice`,
 1 AS `total`,
 1 AS `totalMoney`,
 1 AS `created_at`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `prescription_view`
--

/*!50001 DROP VIEW IF EXISTS `prescription_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `prescription_view` AS select `pd`.`id` AS `id`,`pa`.`id` AS `pid`,`pa`.`name` AS `pname`,`p`.`etiology` AS `etiology`,`p`.`id` AS `main_id`,`pa`.`sex` AS `sex`,`pa`.`age` AS `age`,`pa`.`address` AS `address`,`m`.`name` AS `mname`,`m`.`spell` AS `spell`,`m`.`id` AS `mid`,`pd`.`weight` AS `weight`,`pd`.`amount` AS `amount`,`p`.`way` AS `way`,`pd`.`price` AS `pdprice`,`m`.`price` AS `mprice`,`pd`.`total` AS `total`,`p`.`totalMoney` AS `totalMoney`,`p`.`created_at` AS `created_at` from (((`prescription_detail` `pd` left join `prescription` `p` on((`pd`.`prescription_id` = `p`.`id`))) left join `patient` `pa` on((`p`.`patient_id` = `pa`.`id`))) left join `medicine` `m` on((`m`.`id` = `pd`.`medicine_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-06 16:14:28
