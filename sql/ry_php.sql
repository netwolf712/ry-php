-- MySQL dump 10.13  Distrib 8.0.31, for macos12 (x86_64)
--
-- Host: localhost    Database: ry_php
-- ------------------------------------------------------
-- Server version	5.7.35

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
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ry_php` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `ry_php`;
--
-- Table structure for table `sys_dept`
--

DROP TABLE IF EXISTS `sys_dept`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_dept` (
  `dept_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '部门id',
  `parent_id` bigint(20) DEFAULT '0' COMMENT '父部门id',
  `ancestors` varchar(50) DEFAULT '' COMMENT '祖级列表',
  `dept_name` varchar(30) DEFAULT '' COMMENT '部门名称',
  `order_num` int(4) DEFAULT '0' COMMENT '显示顺序',
  `leader` varchar(20) DEFAULT NULL COMMENT '负责人',
  `phone` varchar(11) DEFAULT NULL COMMENT '联系电话',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `status` char(1) DEFAULT '0' COMMENT '部门状态（0正常 1停用）',
  `del_flag` char(1) DEFAULT '0' COMMENT '删除标志（0代表存在 2代表删除）',
  `create_by` varchar(64) DEFAULT '' COMMENT '创建者',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_by` varchar(64) DEFAULT '' COMMENT '更新者',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `gd_company_id` bigint(20) DEFAULT NULL COMMENT '用于记录这个节点是关联的哪个单位的，方便与老版本兼容',
  PRIMARY KEY (`dept_id`)
) ENGINE=MyISAM AUTO_INCREMENT=190 DEFAULT CHARSET=utf8 COMMENT='部门表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_dept`
--

LOCK TABLES `sys_dept` WRITE;
/*!40000 ALTER TABLE `sys_dept` DISABLE KEYS */;
INSERT INTO `sys_dept` VALUES (100,0,'0','根目录',0,'ry','15888888888','ry@qq.com','0','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00',NULL);
/*!40000 ALTER TABLE `sys_dept` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_dict_data`
--

DROP TABLE IF EXISTS `sys_dict_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_dict_data` (
  `dict_code` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '字典编码',
  `dict_sort` int(4) DEFAULT '0' COMMENT '字典排序',
  `dict_label` varchar(100) DEFAULT '' COMMENT '字典标签',
  `dict_value` varchar(100) DEFAULT '' COMMENT '字典键值',
  `dict_type` varchar(100) DEFAULT '' COMMENT '字典类型',
  `css_class` varchar(100) DEFAULT NULL COMMENT '样式属性（其他样式扩展）',
  `list_class` varchar(100) DEFAULT NULL COMMENT '表格回显样式',
  `is_default` char(1) DEFAULT 'N' COMMENT '是否默认（Y是 N否）',
  `status` char(1) DEFAULT '0' COMMENT '状态（0正常 1停用）',
  `create_by` varchar(64) DEFAULT '' COMMENT '创建者',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_by` varchar(64) DEFAULT '' COMMENT '更新者',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `remark` varchar(500) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`dict_code`),
  KEY `dictTypeIndex` (`dict_type`)
) ENGINE=MyISAM AUTO_INCREMENT=122 DEFAULT CHARSET=utf8 COMMENT='字典数据表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_dict_data`
--

LOCK TABLES `sys_dict_data` WRITE;
/*!40000 ALTER TABLE `sys_dict_data` DISABLE KEYS */;
INSERT INTO `sys_dict_data` VALUES (1,1,'男2','0','sys_user_sex','','','Y','0','netwolf','2022-11-28 17:44:49','ry','2018-03-16 11:33:00','性别男'),(2,2,'女','1','sys_user_sex','','','N','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','性别女'),(3,3,'未知','2','sys_user_sex','','','N','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','性别未知'),(4,1,'显示','0','sys_show_hide','','primary','Y','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','显示菜单'),(5,2,'隐藏','1','sys_show_hide','','danger','N','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','隐藏菜单'),(6,1,'正常','0','sys_normal_disable','','primary','Y','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','正常状态'),(7,2,'停用','1','sys_normal_disable','','danger','N','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','停用状态'),(8,1,'正常','0','sys_job_status','','primary','Y','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','正常状态'),(9,2,'暂停','1','sys_job_status','','danger','N','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','停用状态'),(10,1,'默认','DEFAULT','sys_job_group','','','Y','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','默认分组'),(11,2,'系统','SYSTEM','sys_job_group','','','N','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','系统分组'),(12,1,'是','Y','sys_yes_no','','primary','Y','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','系统默认是'),(13,2,'否','N','sys_yes_no','','danger','N','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','系统默认否'),(14,1,'通知','1','sys_notice_type','','warning','Y','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','通知'),(15,2,'公告','2','sys_notice_type','','success','N','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','公告'),(16,1,'正常','0','sys_notice_status','','primary','Y','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','正常状态'),(17,2,'关闭','1','sys_notice_status','','danger','N','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','关闭状态'),(18,1,'新增','1','sys_oper_type','','info','N','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','新增操作'),(19,2,'修改','2','sys_oper_type','','info','N','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','修改操作'),(20,3,'删除','3','sys_oper_type','','danger','N','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','删除操作'),(21,4,'授权','4','sys_oper_type','','primary','N','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','授权操作'),(22,5,'导出','5','sys_oper_type','','warning','N','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','导出操作'),(23,6,'导入','6','sys_oper_type','','warning','N','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','导入操作'),(24,7,'强退','7','sys_oper_type','','danger','N','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','强退操作'),(25,8,'生成代码','8','sys_oper_type','','warning','N','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','生成操作'),(26,9,'清空数据','9','sys_oper_type','','danger','N','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','清空操作'),(42,0,'成功','0','sys_common_status',NULL,'success',NULL,'0','netwolf','2022-12-09 16:12:22','netwolf','2022-12-14 17:16:10',NULL),(43,0,'失败','1','sys_common_status',NULL,'warning',NULL,'0','netwolf','2022-12-09 16:12:36','',NULL,NULL),(94,0,'1','1',NULL,NULL,NULL,'N','0','netwolf','2023-01-03 15:34:20','',NULL,NULL);
/*!40000 ALTER TABLE `sys_dict_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_dict_type`
--

DROP TABLE IF EXISTS `sys_dict_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_dict_type` (
  `dict_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '字典主键',
  `dict_name` varchar(100) DEFAULT '' COMMENT '字典名称',
  `dict_type` varchar(100) DEFAULT '' COMMENT '字典类型',
  `status` char(1) DEFAULT '0' COMMENT '状态（0正常 1停用）',
  `create_by` varchar(64) DEFAULT '' COMMENT '创建者',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_by` varchar(64) DEFAULT '' COMMENT '更新者',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `remark` varchar(500) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`dict_id`),
  UNIQUE KEY `dict_type` (`dict_type`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='字典类型表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_dict_type`
--

LOCK TABLES `sys_dict_type` WRITE;
/*!40000 ALTER TABLE `sys_dict_type` DISABLE KEYS */;
INSERT INTO `sys_dict_type` VALUES (1,'用户性别','sys_user_sex','0','admin','2018-03-16 11:33:00','netwolf','2022-12-13 18:03:37','用户性别列表'),(2,'菜单状态','sys_show_hide','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','菜单状态列表'),(3,'系统开关','sys_normal_disable','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','系统开关列表'),(4,'任务状态','sys_job_status','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','任务状态列表'),(5,'任务分组','sys_job_group','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','任务分组列表'),(6,'系统是否','sys_yes_no','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','系统是否列表'),(7,'通知类型','sys_notice_type','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','通知类型列表'),(8,'通知状态','sys_notice_status','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','通知状态列表'),(9,'操作类型','sys_oper_type','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','操作类型列表'),(18,'登录状态','sys_common_status','0','netwolf','2022-12-09 16:11:18','admin','2023-06-16 06:55:39','');
/*!40000 ALTER TABLE `sys_dict_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_login_info`
--

DROP TABLE IF EXISTS `sys_login_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_login_info` (
  `info_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '访问ID',
  `user_name` varchar(50) DEFAULT '' COMMENT '用户账号',
  `ipaddr` varchar(128) DEFAULT '' COMMENT '登录IP地址',
  `login_location` varchar(255) DEFAULT '' COMMENT '登录地点',
  `browser` varchar(50) DEFAULT '' COMMENT '浏览器类型',
  `os` varchar(50) DEFAULT '' COMMENT '操作系统',
  `status` char(1) DEFAULT '0' COMMENT '登录状态（0成功 1失败）',
  `msg` varchar(255) DEFAULT '' COMMENT '提示消息',
  `login_time` datetime DEFAULT NULL COMMENT '访问时间',
  PRIMARY KEY (`info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='系统访问记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_login_info`
--

LOCK TABLES `sys_login_info` WRITE;
/*!40000 ALTER TABLE `sys_login_info` DISABLE KEYS */;
INSERT INTO `sys_login_info` VALUES (7,'admin','127.0.0.1','','Chrome(114.0.0.0)','未知操作系统','0','登录成功','2023-06-15 05:39:12'),(8,'admin','127.0.0.1','','Chrome(114.0.0.0)','未知操作系统','0','登录成功','2023-06-15 05:59:43'),(9,'admin','127.0.0.1','','Chrome(114.0.0.0)','未知操作系统','0','登录成功','2023-06-15 06:02:56'),(10,'admin','127.0.0.1','','Chrome(114.0.0.0)','Mac OS','0','登录成功','2023-06-15 06:04:29'),(11,'admin','127.0.0.1','','Chrome(114.0.0.0)','Mac OS','0','登录成功','2023-06-15 07:26:44'),(12,'admin','127.0.0.1','','Chrome(114.0.0.0)','Mac OS','0','登录成功','2023-06-16 01:20:38'),(13,'admin','127.0.0.1','','Chrome(114.0.0.0)','Mac OS','0','登录成功','2023-06-16 06:49:01'),(14,'admin','127.0.0.1','','Chrome(114.0.0.0)','Mac OS','0','登录成功','2023-06-19 05:16:29'),(15,'admin','127.0.0.1','','未知浏览器()','未知操作系统','0','登录成功','2023-06-19 05:43:44'),(16,'admin','127.0.0.1','','Chrome(114.0.0.0)','Mac OS','0','登录成功','2023-06-19 05:45:07'),(17,'admin','127.0.0.1','','未知浏览器()','未知操作系统','0','登录成功','2023-06-19 06:05:48'),(18,'admin','127.0.0.1','','Chrome(114.0.0.0)','Mac OS','0','登录成功','2023-06-19 07:43:49'),(19,'admin','127.0.0.1','','未知浏览器()','未知操作系统','0','登录成功','2023-06-19 07:55:31'),(20,'admin','127.0.0.1','','Chrome(114.0.0.0)','Mac OS','0','登录成功','2023-06-19 08:02:19'),(21,'admin','127.0.0.1','','未知浏览器()','未知操作系统','0','登录成功','2023-06-19 08:09:17'),(22,'admin','127.0.0.1','','Chrome(114.0.0.0)','Mac OS','0','登录成功','2023-06-19 08:19:33'),(23,'admin','127.0.0.1','','未知浏览器()','未知操作系统','0','登录成功','2023-06-19 08:19:37'),(24,'admin','127.0.0.1','','Chrome(114.0.0.0)','Mac OS','0','登录成功','2023-06-19 08:23:41'),(25,'admin','127.0.0.1','','未知浏览器()','未知操作系统','0','登录成功','2023-06-19 08:24:31'),(26,'admin','127.0.0.1','','Chrome(114.0.0.0)','Mac OS','0','登录成功','2023-06-19 08:57:44');
/*!40000 ALTER TABLE `sys_login_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_menu`
--

DROP TABLE IF EXISTS `sys_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_menu` (
  `menu_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `menu_name` varchar(50) NOT NULL COMMENT '菜单名称',
  `parent_id` bigint(20) DEFAULT '0' COMMENT '父菜单ID',
  `order_num` int(4) DEFAULT '0' COMMENT '显示顺序',
  `path` varchar(200) DEFAULT '' COMMENT '路由地址',
  `component` varchar(255) DEFAULT NULL COMMENT '组件路径',
  `is_frame` int(1) DEFAULT '1' COMMENT '是否为外链（0是 1否）',
  `menu_type` char(1) DEFAULT '' COMMENT '菜单类型（0目录 1菜单 2按钮）',
  `visible` char(1) DEFAULT '0' COMMENT '菜单状态（0显示 1隐藏）',
  `perms` varchar(100) DEFAULT NULL COMMENT '权限标识',
  `icon` varchar(100) DEFAULT '#' COMMENT '菜单图标',
  `create_by` varchar(64) DEFAULT '' COMMENT '创建者',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_by` varchar(64) DEFAULT '' COMMENT '更新者',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `remark` varchar(500) DEFAULT '' COMMENT '备注',
  `status` char(1) DEFAULT '0' COMMENT '状态（0正常，1停用）',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1097 DEFAULT CHARSET=utf8 COMMENT='菜单权限表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_menu`
--

LOCK TABLES `sys_menu` WRITE;
/*!40000 ALTER TABLE `sys_menu` DISABLE KEYS */;
INSERT INTO `sys_menu` VALUES (1,'系统管理',0,1,'system','Layout',1,'M','0','','system','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','系统管理目录','0'),(2,'系统监控',0,2,'monitor','Layout',1,'M','0','','monitor','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','系统监控目录','0'),(100,'用户管理',1,1,'user','system/user/index',1,'C','0','system:user:list','user','admin','2018-03-16 11:33:00','netwolf','2022-11-30 15:55:24','用户管理菜单','0'),(101,'角色管理',1,2,'role','system/role/index',1,'C','0','system:role:list','peoples','admin','2018-03-16 11:33:00','netwolf','2023-06-14 09:51:21','角色管理菜单','0'),(102,'菜单管理',1,3,'menu','system/menu/index',1,'C','0','system:menu:list','tree-table','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','菜单管理菜单','0'),(105,'字典管理',1,6,'dict','system/dict/index',1,'C','0','system:dict:list','dict','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','字典管理菜单','0'),(112,'服务监控',2,4,'server','monitor/server/index',1,'C','0','monitor:server:list','server','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','服务监控菜单','0'),(500,'操作日志',1,9,'operlog','monitor/operlog/index',1,'C','0','monitor:operlog:list','form','admin','2018-03-16 11:33:00','admin','2023-06-15 06:01:39','操作日志菜单','0'),(501,'登录日志',1,8,'logininfor','monitor/logininfor/index',1,'C','0','monitor:logininfor:list','logininfor','admin','2018-03-16 11:33:00','admin','2023-06-15 06:01:30','登录日志菜单','0'),(1001,'用户查询',100,1,'','',1,'F','0','system:user:query','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1002,'用户新增',100,2,'','',1,'F','0','system:user:add','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1003,'用户修改',100,3,'','',1,'F','0','system:user:edit','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1004,'用户删除',100,4,'','',1,'F','0','system:user:remove','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1005,'用户导出',100,5,'','',1,'F','0','system:user:export','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1006,'用户导入',100,6,'','',1,'F','0','system:user:import','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1007,'重置密码',100,7,'','',1,'F','0','system:user:resetPwd','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1008,'角色查询',101,1,'','',1,'F','0','system:role:query','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1009,'角色新增',101,2,'','',1,'F','0','system:role:add','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1010,'角色修改',101,3,'','',1,'F','0','system:role:edit','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1011,'角色删除',101,4,'','',1,'F','0','system:role:remove','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1012,'角色导出',101,5,'','',1,'F','0','system:role:export','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1013,'菜单查询',102,1,'','',1,'F','0','system:menu:query','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1014,'菜单新增',102,2,'','',1,'F','0','system:menu:add','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1015,'菜单修改',102,3,'','',1,'F','0','system:menu:edit','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1016,'菜单删除',102,4,'','',1,'F','0','system:menu:remove','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1026,'字典查询',105,1,'#','',1,'F','0','system:dict:query','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1027,'字典新增',105,2,'#','',1,'F','0','system:dict:add','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1028,'字典修改',105,3,'#','',1,'F','0','system:dict:edit','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1029,'字典删除',105,4,'#','',1,'F','0','system:dict:remove','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1030,'字典导出',105,5,'#','',1,'F','0','system:dict:export','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1040,'操作查询',500,1,'#','',1,'F','0','monitor:operlog:query','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1041,'操作删除',500,2,'#','',1,'F','0','monitor:operlog:remove','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1042,'日志导出',500,4,'#','',1,'F','0','monitor:operlog:export','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1043,'登录查询',501,1,'#','',1,'F','0','monitor:logininfor:query','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1044,'登录删除',501,2,'#','',1,'F','0','monitor:logininfor:remove','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1045,'日志导出',501,3,'#','',1,'F','0','monitor:logininfor:export','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0');
/*!40000 ALTER TABLE `sys_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_oper_log`
--

DROP TABLE IF EXISTS `sys_oper_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_oper_log` (
  `oper_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '日志主键',
  `title` varchar(50) DEFAULT '' COMMENT '模块标题',
  `business_type` int(2) DEFAULT '0' COMMENT '业务类型（0其它 1新增 2修改 3删除）',
  `method` varchar(100) DEFAULT '' COMMENT '方法名称',
  `request_method` varchar(10) DEFAULT '' COMMENT '请求方式',
  `operator_type` int(1) DEFAULT '0' COMMENT '操作类别（0其它 1后台用户 2手机端用户）',
  `oper_name` varchar(50) DEFAULT '' COMMENT '操作人员',
  `dept_name` varchar(50) DEFAULT '' COMMENT '部门名称',
  `oper_url` varchar(255) DEFAULT '' COMMENT '请求URL',
  `oper_ip` varchar(128) DEFAULT '' COMMENT '主机地址',
  `oper_location` varchar(255) DEFAULT '' COMMENT '操作地点',
  `oper_param` varchar(2000) DEFAULT '' COMMENT '请求参数',
  `json_result` varchar(2000) DEFAULT '' COMMENT '返回参数',
  `status` int(1) DEFAULT '0' COMMENT '操作状态（0正常 1异常）',
  `error_msg` varchar(2000) DEFAULT '' COMMENT '错误消息',
  `oper_time` datetime DEFAULT NULL COMMENT '操作时间',
  PRIMARY KEY (`oper_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COMMENT='操作日志记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_oper_log`
--

LOCK TABLES `sys_oper_log` WRITE;
/*!40000 ALTER TABLE `sys_oper_log` DISABLE KEYS */;
INSERT INTO `sys_oper_log` VALUES (3,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','','',0,NULL,'2023-06-15 05:54:40'),(4,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-15 05:55:58'),(5,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','{\"menuId\":108,\"menuName\":\"\\u65e5\\u5fd7\\u7ba1\\u7406\",\"parent_id\":\"1\",\"parentId\":1,\"order_num\":\"9\",\"orderNum\":9,\"path\":\"monitor\",\"component\":\"monitor\\/operlog\\/index\",\"isFrame\":\"1\",\"menuType\":\"M\",\"visible\":\"0\",\"perms\":\"\",\"icon\":\"log\",\"createBy\":\"admin\",\"createTime\":\"2018-03-16 11:33:00\",\"updateBy\":\"admin\",\"updateTime\":\"2023-06-15 05:55:58\",\"remark\":\"\\u65e5\\u5fd7\\u7ba1\\u7406\\u83dc\\u5355\",\"status\":\"0\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-15 05:58:34'),(6,'user',2,'','post',0,'admin','','sys_user/logout','127.0.0.1','','','{\"success\":true,\"field\":\"\",\"message\":\"\",\"code\":200}',0,NULL,'2023-06-15 05:59:39'),(7,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','{\"menuId\":500,\"menuName\":\"\\u64cd\\u4f5c\\u65e5\\u5fd7\",\"parent_id\":\"108\",\"parentId\":1,\"order_num\":\"1\",\"orderNum\":1,\"path\":\"operlog\",\"component\":\"monitor\\/operlog\\/index\",\"isFrame\":\"1\",\"menuType\":\"C\",\"visible\":\"0\",\"perms\":\"monitor:operlog:list\",\"icon\":\"form\",\"createBy\":\"admin\",\"createTime\":\"2018-03-16 11:33:00\",\"updateBy\":\"ry\",\"updateTime\":\"2018-03-16 11:33:00\",\"remark\":\"\\u64cd\\u4f5c\\u65e5\\u5fd7\\u83dc\\u5355\",\"status\":\"0\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-15 06:01:00'),(8,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','{\"menuId\":501,\"menuName\":\"\\u767b\\u5f55\\u65e5\\u5fd7\",\"parent_id\":\"108\",\"parentId\":1,\"order_num\":\"2\",\"orderNum\":2,\"path\":\"logininfor\",\"component\":\"monitor\\/logininfor\\/index\",\"isFrame\":\"1\",\"menuType\":\"C\",\"visible\":\"0\",\"perms\":\"monitor:logininfor:list\",\"icon\":\"logininfor\",\"createBy\":\"admin\",\"createTime\":\"2018-03-16 11:33:00\",\"updateBy\":\"ry\",\"updateTime\":\"2018-03-16 11:33:00\",\"remark\":\"\\u767b\\u5f55\\u65e5\\u5fd7\\u83dc\\u5355\",\"status\":\"0\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-15 06:01:07'),(9,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','108','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-15 06:01:11'),(10,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','{\"menuId\":501,\"menuName\":\"\\u767b\\u5f55\\u65e5\\u5fd7\",\"parent_id\":\"1\",\"parentId\":1,\"order_num\":\"2\",\"orderNum\":8,\"path\":\"logininfor\",\"component\":\"monitor\\/logininfor\\/index\",\"isFrame\":\"1\",\"menuType\":\"C\",\"visible\":\"0\",\"perms\":\"monitor:logininfor:list\",\"icon\":\"logininfor\",\"createBy\":\"admin\",\"createTime\":\"2018-03-16 11:33:00\",\"updateBy\":\"admin\",\"updateTime\":\"2023-06-15 06:01:07\",\"remark\":\"\\u767b\\u5f55\\u65e5\\u5fd7\\u83dc\\u5355\",\"status\":\"0\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-15 06:01:30'),(11,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','{\"menuId\":500,\"menuName\":\"\\u64cd\\u4f5c\\u65e5\\u5fd7\",\"parent_id\":\"1\",\"parentId\":1,\"order_num\":\"1\",\"orderNum\":9,\"path\":\"operlog\",\"component\":\"monitor\\/operlog\\/index\",\"isFrame\":\"1\",\"menuType\":\"C\",\"visible\":\"0\",\"perms\":\"monitor:operlog:list\",\"icon\":\"form\",\"createBy\":\"admin\",\"createTime\":\"2018-03-16 11:33:00\",\"updateBy\":\"admin\",\"updateTime\":\"2023-06-15 06:01:00\",\"remark\":\"\\u64cd\\u4f5c\\u65e5\\u5fd7\\u83dc\\u5355\",\"status\":\"0\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-15 06:01:39'),(12,'user',2,'','post',0,'admin','','sys_user/logout','127.0.0.1','','','{\"success\":true,\"field\":\"\",\"message\":\"\",\"code\":200}',0,NULL,'2023-06-15 06:02:54'),(13,'upload',2,'','post',0,'admin','','upload/upload_avatar','127.0.0.1','','{\"file\":{\"name\":\"blob\",\"type\":\"image\\/jpeg\",\"tmp_name\":\"\\/private\\/var\\/tmp\\/phpqMkd2U\",\"error\":0,\"size\":82015}}','{\"success\":false,\"field\":\"file\",\"message\":\"\\u4e0a\\u4f20\\u5931\\u8d25\",\"code\":0}',1,'上传失败','2023-06-15 06:33:51'),(14,'upload',2,'','post',0,'admin','','upload/upload_avatar','127.0.0.1','','{\"file\":{\"name\":\"blob\",\"type\":\"image\\/jpeg\",\"tmp_name\":\"\\/private\\/var\\/tmp\\/phpEjGthc\",\"error\":0,\"size\":82015}}','{\"success\":false,\"field\":\"file\",\"message\":\"\\u4e0a\\u4f20\\u5931\\u8d25\",\"code\":0}',1,'上传失败','2023-06-15 06:34:42'),(15,'upload',2,'','post',0,'admin','','upload/upload_avatar','127.0.0.1','','{\"file\":{\"name\":\"blob\",\"type\":\"image\\/jpeg\",\"tmp_name\":\"\\/private\\/var\\/tmp\\/phpGNJqC7\",\"error\":0,\"size\":82015}}','{\"success\":false,\"field\":\"file\",\"message\":\"\\u4e0a\\u4f20\\u5931\\u8d25\",\"code\":0}',1,'上传失败','2023-06-15 06:35:52'),(16,'upload',2,'','post',0,'admin','','upload/upload_avatar','127.0.0.1','','{\"file\":{\"name\":\"blob\",\"type\":\"image\\/jpeg\",\"tmp_name\":\"\\/private\\/var\\/tmp\\/phpYq3ezR\",\"error\":0,\"size\":82015}}','{\"success\":false,\"field\":\"file\",\"message\":\"\\u4e0a\\u4f20\\u5931\\u8d25\",\"code\":0}',1,'上传失败','2023-06-15 06:38:33'),(17,'upload',2,'','post',0,'admin','','upload/upload_avatar','127.0.0.1','','{\"file\":{\"name\":\"blob\",\"type\":\"image\\/jpeg\",\"tmp_name\":\"\\/private\\/var\\/tmp\\/phpBcWpbp\",\"error\":0,\"size\":82015}}','{\"success\":false,\"field\":\"file\",\"message\":\"\\u4e0a\\u4f20\\u5931\\u8d25\",\"code\":0}',1,'上传失败','2023-06-15 06:43:06'),(18,'upload',2,'','post',0,'admin','','upload/upload_avatar','127.0.0.1','','{\"file\":{\"name\":\"blob\",\"type\":\"image\\/jpeg\",\"tmp_name\":\"\\/private\\/var\\/tmp\\/php20agNM\",\"error\":0,\"size\":82015}}','{\"success\":false,\"field\":\"file\",\"message\":\"\\u4e0a\\u4f20\\u5931\\u8d25\",\"code\":0}',1,'上传失败','2023-06-15 06:44:28'),(19,'upload',2,'','post',0,'admin','','upload/upload_avatar','127.0.0.1','','{\"file\":{\"name\":\"blob\",\"type\":\"image\\/jpeg\",\"tmp_name\":\"\\/private\\/var\\/tmp\\/phpDJHyli\",\"error\":0,\"size\":82015}}','{\"success\":false,\"field\":\"file\",\"message\":\"\\u4e0a\\u4f20\\u5931\\u8d25\",\"code\":0}',1,'上传失败','2023-06-15 06:45:09'),(20,'upload',2,'','post',0,'admin','','upload/upload_avatar','127.0.0.1','','{\"file\":{\"name\":\"blob\",\"type\":\"image\\/jpeg\",\"tmp_name\":\"\\/private\\/var\\/tmp\\/phprZj2Zx\",\"error\":0,\"size\":82015}}','{\"success\":false,\"field\":\"file\",\"message\":\"\\u4e0a\\u4f20\\u5931\\u8d25\",\"code\":0}',1,'上传失败','2023-06-15 06:45:42'),(21,'upload',2,'','post',0,'admin','','upload/upload_avatar','127.0.0.1','','{\"file\":{\"name\":\"blob\",\"type\":\"image\\/jpeg\",\"tmp_name\":\"\\/private\\/var\\/tmp\\/phpSqlAUh\",\"error\":0,\"size\":82015}}','{\"success\":false,\"field\":\"file\",\"message\":\"\\u4e0a\\u4f20\\u5931\\u8d25\",\"code\":0}',1,'上传失败','2023-06-15 06:48:02'),(22,'upload',2,'','post',0,'admin','','upload/upload_avatar','127.0.0.1','','{\"file\":{\"name\":\"blob\",\"type\":\"image\\/jpeg\",\"tmp_name\":\"\\/private\\/var\\/tmp\\/phpNxQV5B\",\"error\":0,\"size\":82015}}','{\"success\":false,\"field\":\"file\",\"message\":\"\\u4e0a\\u4f20\\u5931\\u8d25\",\"code\":0}',1,'上传失败','2023-06-15 06:48:53'),(23,'upload',2,'','post',0,'admin','','upload/upload_avatar','127.0.0.1','','{\"file\":{\"name\":\"blob\",\"type\":\"image\\/jpeg\",\"tmp_name\":\"\\/private\\/var\\/tmp\\/phpJZVHlf\",\"error\":0,\"size\":82015}}','{\"success\":false,\"field\":\"file\",\"message\":\"\\u4e0a\\u4f20\\u5931\\u8d25\",\"code\":0}',1,'上传失败','2023-06-15 06:51:48'),(24,'upload',2,'','post',0,'admin','','upload/upload_avatar','127.0.0.1','','{\"file\":{\"name\":\"blob\",\"type\":\"image\\/jpeg\",\"tmp_name\":\"\\/private\\/var\\/tmp\\/php4JYy4E\",\"error\":0,\"size\":82015}}','{\"success\":false,\"field\":\"file\",\"message\":\"\\u4e0a\\u4f20\\u5931\\u8d25\",\"code\":0}',1,'上传失败','2023-06-15 06:55:35'),(25,'upload',2,'','post',0,'admin','','upload/upload_avatar','127.0.0.1','','{\"file\":{\"name\":\"blob\",\"type\":\"image\\/jpeg\",\"tmp_name\":\"\\/private\\/var\\/tmp\\/phpwLztEo\",\"error\":0,\"size\":82015}}','{\"fileName\":\"upload\\/\\/2023\\/06\\/15\\/20230615065755953896.jpeg\",\"encode_file_path\":\"upload__2023_06_15_20230615065755953896~jpeg\",\"code\":200}',0,NULL,'2023-06-15 06:57:55'),(26,'upload',2,'','post',0,'admin','','upload/upload_avatar','127.0.0.1','','{\"file\":{\"name\":\"blob\",\"type\":\"image\\/jpeg\",\"tmp_name\":\"\\/private\\/var\\/tmp\\/php1RGRNG\",\"error\":0,\"size\":82015}}','{\"fileName\":\"upload\\/2023\\/06\\/15\\/20230615065913348249.jpeg\",\"encode_file_path\":\"upload_2023_06_15_20230615065913348249~jpeg\",\"code\":200}',0,NULL,'2023-06-15 06:59:13'),(27,'user',2,'','post',0,'admin','','sys_user/update_profile_password','127.0.0.1','','','{\"success\":false,\"field\":\"\",\"message\":\"\\u65e0\\u6548\\u7684\\u8bf7\\u6c42\",\"code\":0}',1,'无效的请求','2023-06-15 07:18:33'),(28,'user',2,'','post',0,'admin','','sys_user/update_profile_password','127.0.0.1','','','{\"success\":false,\"field\":\"\",\"message\":\"\\u65e0\\u6548\\u7684\\u8bf7\\u6c42\",\"code\":0}',1,'无效的请求','2023-06-15 07:19:43'),(29,'user',2,'','post',0,'admin','','sys_user/logout','127.0.0.1','','','{\"success\":true,\"field\":\"\",\"message\":\"\",\"code\":200}',0,NULL,'2023-06-15 07:26:42'),(30,'user',2,'','post',0,'admin','','sys_user/update_profile_password','127.0.0.1','','','{\"success\":false,\"field\":\"\",\"message\":\"\\u65e0\\u6548\\u7684\\u8bf7\\u6c42\",\"code\":0}',1,'无效的请求','2023-06-15 07:30:05'),(31,'user',2,'','post',0,'admin','','sys_user/update_profile_password','127.0.0.1','','','{\"success\":false,\"field\":\"\",\"message\":\"\\u65e0\\u6548\\u7684\\u8bf7\\u6c42\",\"code\":0}',1,'无效的请求','2023-06-16 01:20:53'),(32,'user',2,'','post',0,'admin','','sys_user/update_profile_password','127.0.0.1','','{\"oldPassword\":\"123456\",\"newPassword\":\"123456\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u91cd\\u7f6e\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 01:22:21'),(33,'user',2,'','post',0,'admin','','sys_user/update_sys_user','127.0.0.1','','{\"userName\":\"ry\",\"userId\":2,\"nickName\":\"\\u82e5\\u4f9d\",\"email\":\"ry@qq.com\",\"phonenumber\":\"15666666666\",\"status\":\"0\",\"avatar\":\"\",\"loginIp\":\"127.0.0.1\",\"loginDate\":\"2023-06-12 16:25:26\",\"delFlag\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2023-06-12 16:25:26\",\"updateBy\":\"admin\",\"updateTime\":\"2023-06-14 06:50:11\",\"remark\":\"\\u6d4b\\u8bd5\\u5458\",\"admin\":false,\"roleIds\":[2,3],\"postIds\":[2],\"deptIds\":[],\"password\":\"\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 01:43:21'),(34,'user',2,'','post',0,'admin','','sys_user/update_sys_user','127.0.0.1','','{\"userName\":\"ry\",\"userId\":2,\"nickName\":\"\\u82e5\\u4f9d\",\"email\":\"ry@qq.com\",\"phonenumber\":\"15666666666\",\"status\":\"0\",\"avatar\":\"\",\"loginIp\":\"127.0.0.1\",\"loginDate\":\"2023-06-12 16:25:26\",\"delFlag\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2023-06-12 16:25:26\",\"updateBy\":\"admin\",\"updateTime\":\"2023-06-16 01:43:21\",\"remark\":\"\\u6d4b\\u8bd5\\u5458\",\"admin\":false,\"roleIds\":[3],\"postIds\":[2],\"deptIds\":[],\"password\":\"\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 01:51:16'),(35,'user',2,'','post',0,'admin','','sys_user/update_sys_user','127.0.0.1','','{\"deptId\":100,\"userName\":\"testUser\",\"password\":\"123456\",\"status\":\"0\",\"roleIds\":[1],\"postIds\":[],\"deptIds\":[]}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 01:53:29'),(36,'user',2,'','post',0,'admin','','sys_user/update_sys_user','127.0.0.1','','{\"deptId\":100,\"userName\":\"testUser2\",\"password\":\"123456\",\"status\":\"0\",\"roleIds\":[],\"postIds\":[],\"deptIds\":[]}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 01:53:38'),(37,'role',2,'','post',0,'admin','','sys_role/update_role','127.0.0.1','','{\"roleName\":\"\\u6d4b\\u8bd5\\u89d2\\u827233\",\"roleKey\":\"testRole33\",\"roleSort\":0,\"status\":\"0\",\"menuIds\":[1,100,1001,1002,1003,1004,1005,1006,1007,101,1008,1009,1010,1011,1012,102,1013,1014,1015,1016,103,1017,1018,1019,1020,104,1021,1022,1023,1024,1025,105,1026,1027,1028,1029,1030,106,1031,1032,1033,1034,1035,501,1043,1044,1045,500,1040,1041,1042,2,112],\"deptIds\":[],\"menuCheckStrictly\":true,\"deptCheckStrictly\":true,\"dataScope\":1}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 01:54:07'),(38,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','1025','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 01:58:30'),(39,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','1024','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 01:58:32'),(40,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','1023','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 01:58:34'),(41,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','1022','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 01:58:38'),(42,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','1021','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 01:58:40'),(43,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','104','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 01:58:42'),(44,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','1020','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 01:59:27'),(45,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','1019','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 01:59:29'),(46,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','1018','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 01:59:31'),(47,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','1017','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 01:59:33'),(48,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','103','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 01:59:37'),(49,'dict',2,'','post',0,'admin','','sys_dict_type/update_dict_type','127.0.0.1','','{\"dictId\":\"18\",\"dictName\":\"\\u767b\\u5f55\\u72b6\\u6001\",\"dictType\":\"sys_common_status\",\"status\":\"0\",\"createBy\":\"netwolf\",\"createTime\":\"2022-12-09 16:11:18\",\"updateBy\":\"netwolf\",\"updateTime\":\"2022-12-09 16:13:17\",\"remark\":\"\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 06:55:39'),(50,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','1035','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 07:02:46'),(51,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','1034','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 07:02:48'),(52,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','1033','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 07:02:51'),(53,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','1032','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 07:02:54'),(54,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','1031','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 07:02:57'),(55,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','106','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-06-16 07:03:00');
/*!40000 ALTER TABLE `sys_oper_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_post`
--

DROP TABLE IF EXISTS `sys_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_post` (
  `post_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '岗位ID',
  `post_code` varchar(64) NOT NULL COMMENT '岗位编码',
  `post_name` varchar(50) NOT NULL COMMENT '岗位名称',
  `post_sort` int(4) NOT NULL COMMENT '显示顺序',
  `status` char(1) NOT NULL COMMENT '状态（0正常 1停用）',
  `create_by` varchar(64) DEFAULT '' COMMENT '创建者',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_by` varchar(64) DEFAULT '' COMMENT '更新者',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `remark` varchar(500) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='岗位信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_post`
--

LOCK TABLES `sys_post` WRITE;
/*!40000 ALTER TABLE `sys_post` DISABLE KEYS */;
INSERT INTO `sys_post` VALUES (1,'ceo','董事长2',1,'0','netwolf','2022-12-01 13:43:44','ry','2018-03-16 11:33:00',''),(2,'se','项目经理',2,'0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00',''),(3,'hr','人力资源',3,'0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00',''),(4,'user','普通员工',4,'0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','');
/*!40000 ALTER TABLE `sys_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_role`
--

DROP TABLE IF EXISTS `sys_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_role` (
  `role_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `role_name` varchar(30) NOT NULL COMMENT '角色名称',
  `role_key` varchar(100) NOT NULL COMMENT '角色权限字符串',
  `role_sort` int(4) NOT NULL COMMENT '显示顺序',
  `data_scope` char(1) DEFAULT '1' COMMENT '数据范围（1：全部数据权限 2：自定数据权限 3：本部门数据权限 4：本部门及以下数据权限）',
  `status` char(1) NOT NULL COMMENT '角色状态（0正常 1停用）',
  `del_flag` char(1) DEFAULT '0' COMMENT '删除标志（0代表存在 2代表删除）',
  `create_by` varchar(64) DEFAULT '' COMMENT '创建者',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_by` varchar(64) DEFAULT '' COMMENT '更新者',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `remark` varchar(500) DEFAULT NULL COMMENT '备注',
  `menu_check_strictly` tinyint(1) DEFAULT '1' COMMENT '菜单树选项是否关联显示',
  `dept_check_strictly` tinyint(1) DEFAULT '1' COMMENT '部门树选项是否关联显示',
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='角色信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_role`
--

LOCK TABLES `sys_role` WRITE;
/*!40000 ALTER TABLE `sys_role` DISABLE KEYS */;
INSERT INTO `sys_role` VALUES (1,'管理员','admin',1,'1','0','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','管理员',1,1),(2,'客户','customer',2,'2','0','0','admin','2018-03-16 11:33:00','netwolf','2022-12-22 17:31:59',NULL,1,0),(3,'设计师','designer',3,'1','0','0','netwolf','2022-11-29 18:06:02','UC服务·Jesse L','2023-01-05 14:06:54',NULL,1,1),(4,'测试角色','tester',0,'2','0','0','netwolf','2022-12-06 16:43:31','netwolf','2023-06-14 05:41:06',NULL,1,1),(5,'普通管理员','commonAdmin',5,'1','0','0','netwolf','2022-12-15 10:34:17','netwolf','2023-01-05 15:09:24',NULL,1,1),(9,'测试角色33','testRole33',0,'1','0','0','admin','2023-06-16 01:54:07','',NULL,NULL,1,1);
/*!40000 ALTER TABLE `sys_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_role_dept`
--

DROP TABLE IF EXISTS `sys_role_dept`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_role_dept` (
  `role_id` bigint(20) NOT NULL COMMENT '角色ID',
  `dept_id` bigint(20) NOT NULL COMMENT '部门ID',
  PRIMARY KEY (`role_id`,`dept_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色和部门关联表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_role_dept`
--

LOCK TABLES `sys_role_dept` WRITE;
/*!40000 ALTER TABLE `sys_role_dept` DISABLE KEYS */;
INSERT INTO `sys_role_dept` VALUES (2,100),(2,101),(2,105);
/*!40000 ALTER TABLE `sys_role_dept` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_role_menu`
--

DROP TABLE IF EXISTS `sys_role_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_role_menu` (
  `role_id` bigint(20) NOT NULL COMMENT '角色ID',
  `menu_id` bigint(20) NOT NULL COMMENT '菜单ID',
  PRIMARY KEY (`role_id`,`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色和菜单关联表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_role_menu`
--

LOCK TABLES `sys_role_menu` WRITE;
/*!40000 ALTER TABLE `sys_role_menu` DISABLE KEYS */;
INSERT INTO `sys_role_menu` VALUES (2,1070),(2,1071),(2,1075),(2,1076),(2,1080),(2,1081),(2,1085),(2,1093),(3,1065),(3,1066),(3,1067),(3,1068),(3,1069),(3,1075),(3,1076),(3,1077),(3,1078),(3,1079),(3,1080),(3,1081),(3,1082),(3,1083),(3,1084),(3,1085),(3,1086),(3,1088),(3,1089),(3,1090),(3,1091),(3,1093),(3,1094),(5,1),(5,100),(5,101),(5,102),(5,103),(5,105),(5,1001),(5,1002),(5,1003),(5,1004),(5,1005),(5,1006),(5,1007),(5,1008),(5,1009),(5,1010),(5,1011),(5,1012),(5,1013),(5,1014),(5,1015),(5,1016),(5,1017),(5,1018),(5,1019),(5,1020),(5,1026),(5,1027),(5,1028),(5,1029),(5,1030),(5,1060),(5,1061),(5,1062),(5,1063),(5,1064),(5,1065),(5,1066),(5,1067),(5,1068),(5,1069),(5,1075),(5,1076),(5,1077),(5,1078),(5,1079),(5,1080),(5,1081),(5,1082),(5,1083),(5,1084),(5,1085),(5,1086),(5,1088),(5,1089),(5,1090),(5,1091),(5,1093),(5,1094),(9,1),(9,2),(9,100),(9,101),(9,102),(9,103),(9,104),(9,105),(9,106),(9,112),(9,500),(9,501),(9,1001),(9,1002),(9,1003),(9,1004),(9,1005),(9,1006),(9,1007),(9,1008),(9,1009),(9,1010),(9,1011),(9,1012),(9,1013),(9,1014),(9,1015),(9,1016),(9,1017),(9,1018),(9,1019),(9,1020),(9,1021),(9,1022),(9,1023),(9,1024),(9,1025),(9,1026),(9,1027),(9,1028),(9,1029),(9,1030),(9,1031),(9,1032),(9,1033),(9,1034),(9,1035),(9,1040),(9,1041),(9,1042),(9,1043),(9,1044),(9,1045);
/*!40000 ALTER TABLE `sys_role_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_user`
--

DROP TABLE IF EXISTS `sys_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_user` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `dept_id` bigint(20) DEFAULT NULL COMMENT '部门ID',
  `user_name` varchar(30) NOT NULL COMMENT '用户账号',
  `nick_name` varchar(30) NOT NULL COMMENT '用户昵称',
  `user_type` varchar(2) DEFAULT '00' COMMENT '用户类型（00系统用户）',
  `email` varchar(50) DEFAULT '' COMMENT '用户邮箱',
  `phonenumber` varchar(11) DEFAULT '' COMMENT '手机号码',
  `sex` char(1) DEFAULT '0' COMMENT '用户性别（0男 1女 2未知）',
  `avatar` varchar(100) DEFAULT '' COMMENT '头像地址',
  `password` varchar(100) DEFAULT '' COMMENT '密码',
  `status` char(1) DEFAULT '0' COMMENT '帐号状态（0正常 1停用）',
  `del_flag` char(1) DEFAULT '0' COMMENT '删除标志（0代表存在 2代表删除）',
  `login_ip` varchar(128) DEFAULT '' COMMENT '最后登录IP',
  `login_date` datetime DEFAULT NULL COMMENT '最后登录时间',
  `create_by` varchar(64) DEFAULT '' COMMENT '创建者',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_by` varchar(64) DEFAULT '' COMMENT '更新者',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `remark` varchar(500) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='用户信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_user`
--

LOCK TABLES `sys_user` WRITE;
/*!40000 ALTER TABLE `sys_user` DISABLE KEYS */;
INSERT INTO `sys_user` VALUES (1,103,'admin','netwolf','00','ry@163.com','15888888888','1','','9c75c603b8d15d848c03ea3096995ff4','0','0','127.0.0.1','2023-06-19 08:57:44','admin','2023-06-12 16:25:26','admin','2023-06-16 01:22:21','管理员账号'),(2,100,'ry','若依','00','ry@qq.com','15666666666','1','','cb56df0e6fd047133761d85fd21e2f61','0','0','127.0.0.1','2023-06-12 16:25:26','admin','2023-06-12 16:25:26','admin','2023-06-16 01:51:16','测试员'),(3,105,'netwolf1','测试人员','00','123@163.com','13566778877','0','','214ce51a2d0d670e6f7e2f93f28140ce','1','1','',NULL,'admin','2023-06-14 06:32:23','admin','2023-06-14 07:06:50',NULL),(4,100,'testUser','testUser','00','','','0','','ce6cbfff354cc1d10f5d2034872727f9','0','0','',NULL,'admin','2023-06-16 01:53:29','',NULL,NULL),(5,100,'testUser2','testUser2','00','','','0','','3bd01975031db91c1b75b6b733fe8b34','0','0','',NULL,'admin','2023-06-16 01:53:38','',NULL,NULL);
/*!40000 ALTER TABLE `sys_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_user_dept`
--

DROP TABLE IF EXISTS `sys_user_dept`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_user_dept` (
  `user_id` bigint(20) NOT NULL COMMENT '用户id',
  `dept_id` bigint(20) NOT NULL COMMENT '部门id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_user_dept`
--

LOCK TABLES `sys_user_dept` WRITE;
/*!40000 ALTER TABLE `sys_user_dept` DISABLE KEYS */;
INSERT INTO `sys_user_dept` VALUES (71368,100),(71908,100),(24,100),(69607,100),(71909,100),(71910,100),(71926,100),(71927,100),(71928,100),(71985,100),(71986,100),(71990,100),(71994,100),(71995,173),(71986,166),(71908,156),(71993,153),(71991,164),(71992,164),(71989,168),(71988,144),(71987,144),(71984,171),(71982,172),(71983,172),(71981,172),(71980,172),(71979,166),(71978,166),(71977,150),(71975,155),(71976,155),(71974,155),(71973,155),(71972,155),(71971,155),(71970,155),(71969,158),(71968,158),(71966,158),(71967,158),(71965,158),(71964,158),(71963,159),(71960,157),(71933,159),(71961,157),(71959,157),(71957,153),(71958,157),(71956,153),(71925,153),(71955,153),(71954,153),(71953,162),(71930,162),(71952,162),(71951,163),(71950,144),(71949,144),(71948,144),(71947,144),(71946,144),(71945,144),(71944,144),(71943,144),(71942,144),(71941,144),(71940,144),(71939,166),(71938,164),(71937,164),(71936,164),(71935,164),(71934,164),(71932,160),(71962,159),(71931,163),(71925,153),(71930,162),(71920,157),(71924,156),(71920,157),(71923,156),(71914,156),(71922,156),(71920,156),(71921,156),(71920,153),(71918,158),(71916,150),(71915,121),(71920,156),(71913,156),(71914,156),(71919,150),(71911,154),(68346,136),(71905,155),(70482,137),(71144,137),(71108,144),(71002,144),(71023,149),(71001,148),(71000,139),(70999,144),(70736,144),(70788,119),(70786,143),(70787,143),(70784,142),(70785,142),(70783,142),(70782,132),(69641,131),(69660,132),(70781,119),(66976,128),(70780,141),(70777,134),(70775,146),(70534,146),(70773,144),(70774,145),(70495,135),(70722,122),(70735,144),(69896,122),(70655,120),(70618,125),(70620,121),(70617,124),(70616,121),(69637,121),(71985,179),(70614,116),(70613,120),(70612,120),(70610,116),(70609,115),(70608,114),(70606,111),(70605,112),(71986,158),(71908,173),(71985,160),(71996,173),(71997,173),(71998,173),(71998,156),(71986,156),(71986,144),(71985,153),(71985,157),(71908,157),(71994,159),(71985,155),(71368,156),(71994,156),(71985,164),(71908,164),(71368,160),(71986,160),(71908,144),(71985,144),(71908,153),(71994,155),(71368,157),(70220,113),(69590,113),(69607,111),(71922,175),(71990,175),(71926,175),(71943,175),(71985,175),(71908,175),(71986,175),(70220,175),(69607,113),(71985,176),(71987,176),(71908,176),(71986,176),(71908,177),(71955,177),(71994,177),(71990,177),(71926,177),(71985,177),(71956,177),(71954,177),(71993,177),(71986,177),(71368,177),(71932,179),(71368,179),(71986,179),(71985,180),(71990,180),(71908,180),(71368,180),(71994,180),(71986,180),(71961,180),(71926,159),(71928,159),(71368,159),(71985,159),(71908,181),(71986,181),(71985,181),(71995,181),(71908,182),(71934,182),(71985,182),(71986,182),(71994,182),(71908,158),(71990,158),(71985,183),(71970,183),(71976,183),(71994,183),(71908,183),(71986,183),(71971,183),(71908,184),(71990,184),(71994,184),(71913,184),(71985,184),(71926,184),(71985,185),(71926,185),(71977,185),(71916,185),(71368,185),(71994,185),(71986,184),(71999,180),(72000,180),(71959,180),(72001,180),(71974,183),(71975,183),(71972,183),(71919,185),(71986,186),(71979,186),(71908,186),(71990,186),(71908,159),(71986,159),(71908,187),(71985,187),(71986,187),(71986,188),(71908,188),(71925,177);
/*!40000 ALTER TABLE `sys_user_dept` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_user_post`
--

DROP TABLE IF EXISTS `sys_user_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_user_post` (
  `user_id` bigint(20) NOT NULL COMMENT '用户ID',
  `post_id` bigint(20) NOT NULL COMMENT '岗位ID',
  PRIMARY KEY (`user_id`,`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户与岗位关联表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_user_post`
--

LOCK TABLES `sys_user_post` WRITE;
/*!40000 ALTER TABLE `sys_user_post` DISABLE KEYS */;
INSERT INTO `sys_user_post` VALUES (1,1),(2,2),(24,1),(24,2),(31,1),(31,2);
/*!40000 ALTER TABLE `sys_user_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_user_role`
--

DROP TABLE IF EXISTS `sys_user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_user_role` (
  `user_id` bigint(20) NOT NULL COMMENT '用户ID',
  `role_id` bigint(20) NOT NULL COMMENT '角色ID',
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户和角色关联表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_user_role`
--

LOCK TABLES `sys_user_role` WRITE;
/*!40000 ALTER TABLE `sys_user_role` DISABLE KEYS */;
INSERT INTO `sys_user_role` VALUES (2,3),(4,1),(24,3),(66976,2),(68346,2),(69590,2),(69590,3),(69607,2),(69607,3),(69637,2),(69641,2),(69660,2),(69850,2),(69896,2),(70083,2),(70220,5),(70482,2),(70492,2),(70495,2),(70534,2),(70605,2),(70606,2),(70608,2),(70609,2),(70610,2),(70612,2),(70613,2),(70614,2),(70615,2),(70616,2),(70617,2),(70618,2),(70620,2),(70655,2),(70722,2),(70735,2),(70736,2),(70740,2),(70741,2),(70742,2),(70743,2),(70752,2),(70755,2),(70765,2),(70766,2),(70767,2),(70768,2),(70769,2),(70770,2),(70771,2),(70772,2),(70773,2),(70774,2),(70775,2),(70777,2),(70780,2),(70781,2),(70782,2),(70783,2),(70784,2),(70785,2),(70786,2),(70787,2),(70788,2),(70999,2),(71000,2),(71001,2),(71002,2),(71023,2),(71108,2),(71144,2),(71368,3),(71368,5),(71905,2),(71908,2),(71908,3),(71908,5),(71909,3),(71910,3),(71911,2),(71913,2),(71914,2),(71915,2),(71916,2),(71918,2),(71919,2),(71920,2),(71921,2),(71922,2),(71923,2),(71924,2),(71925,2),(71926,3),(71927,3),(71928,3),(71930,2),(71931,2),(71932,2),(71933,2),(71934,2),(71935,2),(71936,2),(71937,2),(71938,2),(71939,2),(71940,2),(71941,2),(71942,2),(71943,2),(71944,2),(71945,2),(71946,2),(71947,2),(71948,2),(71949,2),(71950,2),(71951,2),(71952,2),(71953,2),(71954,2),(71955,2),(71956,2),(71957,2),(71958,2),(71959,2),(71960,2),(71961,2),(71962,2),(71963,2),(71964,2),(71965,2),(71966,2),(71967,2),(71968,2),(71969,2),(71970,2),(71971,2),(71972,2),(71973,2),(71974,2),(71975,2),(71976,2),(71977,2),(71978,2),(71979,2),(71980,2),(71981,2),(71982,2),(71983,2),(71984,2),(71985,3),(71986,3),(71987,2),(71988,2),(71989,2),(71990,3),(71991,2),(71992,2),(71993,2),(71994,3),(71995,2),(71996,2),(71997,2),(71998,2),(71999,2),(72000,2),(72001,2);
/*!40000 ALTER TABLE `sys_user_role` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-06-19 17:09:05