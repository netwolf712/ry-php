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

--
-- Table structure for table `sys_config`
--

DROP TABLE IF EXISTS `sys_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_config` (
  `config_id` int(5) NOT NULL AUTO_INCREMENT COMMENT '参数主键',
  `config_name` varchar(100) DEFAULT '' COMMENT '参数名称',
  `config_key` varchar(100) DEFAULT '' COMMENT '参数键名',
  `config_value` varchar(500) DEFAULT '' COMMENT '参数键值',
  `config_type` char(1) DEFAULT 'N' COMMENT '系统内置（Y是 N否）',
  `create_by` varchar(64) DEFAULT '' COMMENT '创建者',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_by` varchar(64) DEFAULT '' COMMENT '更新者',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `remark` varchar(500) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 COMMENT='参数配置表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_config`
--

LOCK TABLES `sys_config` WRITE;
/*!40000 ALTER TABLE `sys_config` DISABLE KEYS */;
INSERT INTO `sys_config` VALUES (1,'主框架页-默认皮肤样式名称','sys.index.skinName','skin-blue','Y','admin','2023-09-26 13:43:59','',NULL,'蓝色 skin-blue、绿色 skin-green、紫色 skin-purple、红色 skin-red、黄色 skin-yellow'),(2,'用户管理-账号初始密码','sys.user.initPassword','123456','Y','admin','2023-09-26 13:43:59','',NULL,'初始化密码 123456'),(3,'主框架页-侧边栏主题','sys.index.sideTheme','theme-dark','Y','admin','2023-09-26 13:43:59','',NULL,'深色主题theme-dark，浅色主题theme-light'),(4,'账号自助-验证码开关','sys.account.captchaEnabled','true','Y','admin','2023-09-26 13:43:59','',NULL,'是否开启验证码功能（true开启，false关闭）'),(5,'账号自助-是否开启用户注册功能','sys.account.registerUser','false','Y','admin','2023-09-26 13:43:59','',NULL,'是否开启注册用户功能（true开启，false关闭）'),(6,'用户登录-黑名单列表','sys.login.blackIPList','','Y','admin','2023-09-26 13:44:00','',NULL,'设置登录IP黑名单限制，多个匹配项以;分隔，支持匹配（*通配、网段）');
/*!40000 ALTER TABLE `sys_config` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`dept_id`)
) ENGINE=MyISAM AUTO_INCREMENT=197 DEFAULT CHARSET=utf8 COMMENT='部门表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_dept`
--

LOCK TABLES `sys_dept` WRITE;
/*!40000 ALTER TABLE `sys_dept` DISABLE KEYS */;
INSERT INTO `sys_dept` VALUES (100,0,'0','根目录',0,'ry','15888888888','ry@qq.com','0','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00'),(190,100,',0','研发部门',1,'老王','15566667777','123@123.com','0','0','admin','2023-09-26 15:02:12','admin','2023-09-26 15:24:41'),(191,100,',1','技术部门',2,'老张','15566667776','122@123.com','1','0','admin','2023-09-26 15:03:54','admin','2023-09-26 15:25:11'),(192,100,'0,100','测试部门',3,NULL,NULL,NULL,'0','0','admin','2023-09-26 15:25:30','',NULL),(193,190,',0,190','硬件研发',0,NULL,NULL,NULL,'0','0','admin','2023-09-26 15:25:56','',NULL),(194,190,',0,190','软件研发',1,NULL,NULL,NULL,'0','0','admin','2023-09-26 15:26:06','',NULL),(196,192,'0,100,192','测试1部',1,NULL,NULL,NULL,'0','0','admin','2023-09-26 15:26:55','',NULL);
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
) ENGINE=MyISAM AUTO_INCREMENT=133 DEFAULT CHARSET=utf8 COMMENT='字典数据表';
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
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='字典类型表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_dict_type`
--

LOCK TABLES `sys_dict_type` WRITE;
/*!40000 ALTER TABLE `sys_dict_type` DISABLE KEYS */;
INSERT INTO `sys_dict_type` VALUES (1,'用户性别','sys_user_sex','0','admin','2018-03-16 11:33:00','netwolf','2022-12-13 18:03:37','用户性别列表'),(2,'菜单状态','sys_show_hide','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','菜单状态列表'),(3,'系统开关','sys_normal_disable','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','系统开关列表'),(4,'任务状态','sys_job_status','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','任务状态列表'),(5,'任务分组','sys_job_group','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','任务分组列表'),(6,'系统是否','sys_yes_no','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','系统是否列表'),(7,'通知类型','sys_notice_type','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','通知类型列表'),(8,'通知状态','sys_notice_status','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','通知状态列表'),(9,'操作类型','sys_oper_type','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','操作类型列表'),(18,'登录状态','sys_common_status','0','netwolf','2022-12-09 16:11:18','admin','2023-06-16 06:55:39',''),(28,'测试字典','sys_dict_test','0','admin','2023-09-26 14:55:23','admin','2023-09-26 14:55:37','这是一条测试数据111');
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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='系统访问记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_login_info`
--

LOCK TABLES `sys_login_info` WRITE;
/*!40000 ALTER TABLE `sys_login_info` DISABLE KEYS */;
INSERT INTO `sys_login_info` VALUES (29,'admin','127.0.0.1','','Chrome(116.0.0.0)','Mac OS','0','登录成功','2023-09-26 15:08:55'),(30,'admin','127.0.0.1','','Chrome(116.0.0.0)','Mac OS','0','登录成功','2023-09-26 15:51:55'),(31,'admin','127.0.0.1','','Chrome(116.0.0.0)','Mac OS','0','登录成功','2023-09-26 16:24:27');
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
) ENGINE=MyISAM AUTO_INCREMENT=1108 DEFAULT CHARSET=utf8 COMMENT='菜单权限表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_menu`
--

LOCK TABLES `sys_menu` WRITE;
/*!40000 ALTER TABLE `sys_menu` DISABLE KEYS */;
INSERT INTO `sys_menu` VALUES (1,'系统管理',0,1,'system','Layout',1,'M','0','','system','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','系统管理目录','0'),(2,'系统监控',0,2,'monitor','Layout',1,'M','0','','monitor','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','系统监控目录','0'),(100,'用户管理',1,1,'user','system/user/index',1,'C','0','system:user:list','user','admin','2018-03-16 11:33:00','netwolf','2022-11-30 15:55:24','用户管理菜单','0'),(101,'角色管理',1,2,'role','system/role/index',1,'C','0','system:role:list','peoples','admin','2018-03-16 11:33:00','netwolf','2023-06-14 09:51:21','角色管理菜单','0'),(102,'菜单管理',1,3,'menu','system/menu/index',1,'C','0','system:menu:list','tree-table','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','菜单管理菜单','0'),(105,'字典管理',1,6,'dict','system/dict/index',1,'C','0','system:dict:list','dict','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','字典管理菜单','0'),(112,'服务监控',2,4,'server','monitor/server/index',1,'C','0','monitor:server:list','server','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','服务监控菜单','0'),(500,'操作日志',1,9,'operlog','monitor/operlog/index',1,'C','0','monitor:operlog:list','form','admin','2018-03-16 11:33:00','admin','2023-06-15 06:01:39','操作日志菜单','0'),(501,'登录日志',1,8,'logininfor','monitor/logininfor/index',1,'C','0','monitor:logininfor:list','logininfor','admin','2018-03-16 11:33:00','admin','2023-06-15 06:01:30','登录日志菜单','0'),(1001,'用户查询',100,1,'','',1,'F','0','system:user:query','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1002,'用户新增',100,2,'','',1,'F','0','system:user:add','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1003,'用户修改',100,3,'','',1,'F','0','system:user:edit','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1004,'用户删除',100,4,'','',1,'F','0','system:user:remove','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1005,'用户导出',100,5,'','',1,'F','0','system:user:export','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1006,'用户导入',100,6,'','',1,'F','0','system:user:import','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1007,'重置密码',100,7,'','',1,'F','0','system:user:resetPwd','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1008,'角色查询',101,1,'','',1,'F','0','system:role:query','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1009,'角色新增',101,2,'','',1,'F','0','system:role:add','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1010,'角色修改',101,3,'','',1,'F','0','system:role:edit','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1011,'角色删除',101,4,'','',1,'F','0','system:role:remove','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1012,'角色导出',101,5,'','',1,'F','0','system:role:export','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1013,'菜单查询',102,1,'','',1,'F','0','system:menu:query','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1014,'菜单新增',102,2,'','',1,'F','0','system:menu:add','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1015,'菜单修改',102,3,'','',1,'F','0','system:menu:edit','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1016,'菜单删除',102,4,'','',1,'F','0','system:menu:remove','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1026,'字典查询',105,1,'#','',1,'F','0','system:dict:query','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1027,'字典新增',105,2,'#','',1,'F','0','system:dict:add','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1028,'字典修改',105,3,'#','',1,'F','0','system:dict:edit','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1029,'字典删除',105,4,'#','',1,'F','0','system:dict:remove','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1030,'字典导出',105,5,'#','',1,'F','0','system:dict:export','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1040,'操作查询',500,1,'#','',1,'F','0','monitor:operlog:query','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1041,'操作删除',500,2,'#','',1,'F','0','monitor:operlog:remove','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1042,'日志导出',500,4,'#','',1,'F','0','monitor:operlog:export','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1043,'登录查询',501,1,'#','',1,'F','0','monitor:logininfor:query','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1044,'登录删除',501,2,'#','',1,'F','0','monitor:logininfor:remove','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1045,'日志导出',501,3,'#','',1,'F','0','monitor:logininfor:export','#','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','','0'),(1097,'参数配置',1,7,'config','system/config/index',1,'C','0','system:config:list','component','admin','2023-09-26 15:09:35','',NULL,'','0'),(1098,'参数查询',1097,0,'',NULL,1,'F','0','system:config:query','#','admin','2023-09-26 15:10:11','',NULL,'','0'),(1099,'参数新增',1097,1,'',NULL,1,'F','0','system:config:add','#','admin','2023-09-26 15:10:33','',NULL,'','0'),(1100,'参数修改',1097,2,'',NULL,1,'F','0','system:config:edit','#','admin','2023-09-26 15:10:54','',NULL,'','0'),(1101,'参数删除',1097,4,'',NULL,1,'F','0','system:config:remove','#','admin','2023-09-26 15:11:16','',NULL,'','0'),(1103,'部门管理',1,4,'dept','system/dept/index',1,'C','0','system:dept:list','list','admin','2023-09-26 15:17:58','',NULL,'','0'),(1104,'部门查询',1103,0,'',NULL,1,'F','0','system:dept:query','#','admin','2023-09-26 15:18:20','',NULL,'','0'),(1105,'部门新增',1103,1,'',NULL,1,'F','0','system:dept:add','#','admin','2023-09-26 15:18:39','',NULL,'','0'),(1106,'部门修改',1103,2,'',NULL,1,'F','0','system:dept:edit','#','admin','2023-09-26 15:18:57','',NULL,'','0'),(1107,'部门删除',1103,4,'',NULL,1,'F','0','system:dept:remove','#','admin','2023-09-26 15:19:18','',NULL,'','0');
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
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 COMMENT='操作日志记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_oper_log`
--

LOCK TABLES `sys_oper_log` WRITE;
/*!40000 ALTER TABLE `sys_oper_log` DISABLE KEYS */;
INSERT INTO `sys_oper_log` VALUES (60,'dict',2,'','post',0,'admin','','sys_dict_type/update_dict_type','127.0.0.1','','{\"dictName\":\"\\u6d4b\\u8bd5\\u5b57\\u5178\",\"dictType\":\"sys_dict_test\",\"status\":\"0\",\"remark\":\"\\u8fd9\\u662f\\u4e00\\u6761\\u6d4b\\u8bd5\\u6570\\u636e\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 14:55:23'),(61,'dict',2,'','post',0,'admin','','sys_dict_type/update_dict_type','127.0.0.1','','{\"dictId\":\"28\",\"dictName\":\"\\u6d4b\\u8bd5\\u5b57\\u5178\",\"dictType\":\"sys_dict_test\",\"status\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2023-09-26 14:55:23\",\"updateBy\":\"\",\"updateTime\":null,\"remark\":\"\\u8fd9\\u662f\\u4e00\\u6761\\u6d4b\\u8bd5\\u6570\\u636e111\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 14:55:37'),(62,'dict',2,'','post',0,'admin','','sys_dict_type/update_dict_data','127.0.0.1','','{\"dictLabel\":\"\\u6d4b\\u8bd51\",\"dictValue\":\"test_1\",\"listClass\":\"default\",\"dictSort\":0,\"status\":\"0\",\"dictType\":\"sys_dict_test\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 14:56:09'),(63,'dict',2,'','post',0,'admin','','sys_dict_type/update_dict_data','127.0.0.1','','{\"dictLabel\":\"test_2\",\"dictValue\":\"\\u6d4b\\u8bd52\",\"listClass\":\"default\",\"dictSort\":1,\"status\":\"0\",\"dictType\":\"sys_dict_test\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 14:56:23'),(64,'dict',2,'','post',0,'admin','','sys_dict_type/update_dict_data','127.0.0.1','','{\"dictLabel\":\"test_3\",\"dictValue\":\"\\u6d4b\\u8bd53\",\"cssClass\":\"11\",\"listClass\":\"default\",\"dictSort\":2,\"status\":\"0\",\"dictType\":\"sys_dict_test\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 14:56:43'),(65,'dict',2,'','post',0,'admin','','sys_dict_type/update_dict_data','127.0.0.1','','{\"dictLabel\":\"test_4\",\"dictValue\":\"\\u6d4b\\u8bd54\",\"listClass\":\"warning\",\"dictSort\":3,\"status\":\"0\",\"dictType\":\"sys_dict_test\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 14:57:04'),(66,'dict',2,'','post',0,'admin','','sys_dict_type/update_dict_data','127.0.0.1','','{\"dictLabel\":\"5\",\"dictValue\":\"5\",\"listClass\":\"default\",\"dictSort\":0,\"status\":\"1\",\"dictType\":\"sys_dict_test\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 14:57:12'),(67,'dict',2,'','post',0,'admin','','sys_dict_type/update_dict_data','127.0.0.1','','{\"dictLabel\":\"6\",\"dictValue\":\"6\",\"cssClass\":\"6\",\"listClass\":\"default\",\"dictSort\":0,\"status\":\"0\",\"remark\":\"6\",\"dictType\":\"sys_dict_test\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 14:57:26'),(68,'dict',2,'','post',0,'admin','','sys_dict_type/update_dict_data','127.0.0.1','','{\"dictLabel\":\"7\",\"dictValue\":\"7\",\"listClass\":\"default\",\"dictSort\":0,\"status\":\"0\",\"remark\":\"7\",\"dictType\":\"sys_dict_test\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 14:57:33'),(69,'dict',2,'','post',0,'admin','','sys_dict_type/update_dict_data','127.0.0.1','','{\"dictLabel\":\"8\",\"dictValue\":\"8\",\"cssClass\":\"8\",\"listClass\":\"default\",\"dictSort\":0,\"status\":\"0\",\"remark\":\"8\",\"dictType\":\"sys_dict_test\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 14:57:41'),(70,'dict',2,'','post',0,'admin','','sys_dict_type/update_dict_data','127.0.0.1','','{\"dictLabel\":\"9\",\"dictValue\":\"9\",\"cssClass\":\"9\",\"listClass\":\"default\",\"dictSort\":0,\"status\":\"0\",\"dictType\":\"sys_dict_test\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 14:57:49'),(71,'dict',2,'','post',0,'admin','','sys_dict_type/update_dict_data','127.0.0.1','','{\"dictLabel\":\"11\",\"dictValue\":\"11\",\"cssClass\":\"11\",\"listClass\":\"default\",\"dictSort\":0,\"status\":\"1\",\"remark\":\"11\",\"dictType\":\"sys_dict_test\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 14:57:58'),(72,'dict',2,'','post',0,'admin','','sys_dict_type/update_dict_data','127.0.0.1','','{\"dictLabel\":\"12\",\"dictValue\":\"12\",\"cssClass\":\"12\",\"listClass\":\"default\",\"dictSort\":0,\"status\":\"1\",\"remark\":\"12\",\"dictType\":\"sys_dict_test\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 14:58:08'),(73,'dict',2,'','post',0,'admin','','sys_dict_type/delete_dict_data','127.0.0.1','','125','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 14:58:16'),(74,'dict',2,'','post',0,'admin','','sys_dict_type/delete_dict_data','127.0.0.1','','122,126,127,128,129,130,131,132,123,124','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 14:58:26'),(75,'dept',2,'','post',0,'admin','','sys_dept/update_dept','127.0.0.1','','{\"parentId\":0,\"menuName\":\"\\u53c2\\u6570\\u8bbe\\u7f6e\",\"icon\":\"color\",\"menuType\":\"C\",\"orderNum\":7,\"isFrame\":\"1\",\"isCache\":\"0\",\"visible\":\"0\",\"status\":\"0\",\"path\":\"system\\/config\\/index\",\"component\":\"config\",\"perms\":\"system:config:list\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:02:12'),(76,'dept',2,'','post',0,'admin','','sys_dept/update_dept','127.0.0.1','','{\"parentId\":1,\"menuName\":\"\\u53c2\\u6570\\u8bbe\\u7f6e\",\"icon\":\"component\",\"menuType\":\"C\",\"orderNum\":7,\"isFrame\":\"1\",\"isCache\":\"0\",\"visible\":\"0\",\"status\":\"0\",\"path\":\"config\",\"component\":\"system\\/config\\/index\",\"perms\":\"system:config:list\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:03:54'),(77,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','{\"parentId\":1,\"menuName\":\"\\u53c2\\u6570\\u914d\\u7f6e\",\"icon\":\"component\",\"menuType\":\"C\",\"orderNum\":7,\"isFrame\":\"1\",\"isCache\":\"0\",\"visible\":\"0\",\"status\":\"0\",\"path\":\"config\",\"perms\":\"system:config:list\",\"component\":\"system\\/config\\/index\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:09:35'),(78,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','{\"parentId\":1097,\"menuName\":\"\\u53c2\\u6570\\u67e5\\u8be2\",\"menuType\":\"F\",\"orderNum\":0,\"isFrame\":\"1\",\"isCache\":\"0\",\"visible\":\"0\",\"status\":\"0\",\"perms\":\"system:config:query\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:10:11'),(79,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','{\"parentId\":1097,\"menuName\":\"\\u53c2\\u6570\\u65b0\\u589e\",\"menuType\":\"F\",\"orderNum\":1,\"isFrame\":\"1\",\"isCache\":\"0\",\"visible\":\"0\",\"status\":\"0\",\"perms\":\"system:config:add\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:10:33'),(80,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','{\"parentId\":1097,\"menuName\":\"\\u53c2\\u6570\\u4fee\\u6539\",\"menuType\":\"F\",\"orderNum\":2,\"isFrame\":\"1\",\"isCache\":\"0\",\"visible\":\"0\",\"status\":\"0\",\"perms\":\"system:config:edit\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:10:54'),(81,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','{\"parentId\":1097,\"menuName\":\"\\u53c2\\u6570\\u5220\\u9664\",\"menuType\":\"F\",\"orderNum\":4,\"isFrame\":\"1\",\"isCache\":\"0\",\"visible\":\"0\",\"status\":\"0\",\"perms\":\"system:config:remove\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:11:16'),(82,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','{\"parentId\":1097,\"menuName\":\"\\u53c2\\u6570\\u5bfc\\u51fa\",\"menuType\":\"F\",\"orderNum\":5,\"isFrame\":\"1\",\"isCache\":\"0\",\"visible\":\"0\",\"status\":\"0\",\"perms\":\"system:config:export\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:11:34'),(83,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','{\"menuId\":1102,\"menuName\":\"\\u53c2\\u6570\\u5bfc\\u51fa1\",\"parent_id\":\"1097\",\"parentId\":1097,\"order_num\":\"5\",\"orderNum\":5,\"path\":\"\",\"component\":null,\"isFrame\":\"1\",\"menuType\":\"F\",\"visible\":\"0\",\"perms\":\"system:config:export1\",\"icon\":\"#\",\"createBy\":\"admin\",\"createTime\":\"2023-09-26 15:11:34\",\"updateBy\":\"\",\"updateTime\":null,\"remark\":\"\",\"status\":\"0\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:11:52'),(84,'menu',2,'','post',0,'admin','','sys_menu/delete_menu','127.0.0.1','','1102','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:11:56'),(85,'config',2,'','post',0,'admin','','sys_config/update_config','127.0.0.1','','{\"configName\":\" \\u53c2\\u6570\\u914d\\u7f6e\\u6d4b\\u8bd5\",\"configKey\":\"config.test\",\"configValue\":\"1\",\"configType\":\"Y\",\"remark\":\"1\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:12:37'),(86,'config',2,'','post',0,'admin','','sys_config/update_config','127.0.0.1','','{\"configId\":\"101\",\"configName\":\" \\u53c2\\u6570\\u914d\\u7f6e\\u6d4b\\u8bd5\",\"configKey\":\"config.test\",\"configValue\":\"1\",\"configType\":\"N\",\"createBy\":\"admin\",\"createTime\":\"2023-09-26 15:12:37\",\"updateBy\":\"\",\"updateTime\":null,\"remark\":\"2\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:12:42'),(87,'config',2,'','post',0,'admin','','sys_config/delete_config','127.0.0.1','','101','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:12:45'),(88,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','{\"parentId\":1,\"menuName\":\"\\u90e8\\u95e8\\u7ba1\\u7406\",\"icon\":\"list\",\"menuType\":\"C\",\"orderNum\":4,\"isFrame\":\"1\",\"isCache\":\"0\",\"visible\":\"0\",\"status\":\"0\",\"path\":\"dept\",\"component\":\"system\\/dept\\/index\",\"perms\":\"system:dept:list\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:17:58'),(89,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','{\"parentId\":1103,\"menuName\":\"\\u90e8\\u95e8\\u67e5\\u8be2\",\"menuType\":\"F\",\"orderNum\":0,\"isFrame\":\"1\",\"isCache\":\"0\",\"visible\":\"0\",\"status\":\"0\",\"perms\":\"system:dept:query\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:18:20'),(90,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','{\"parentId\":1103,\"menuName\":\"\\u90e8\\u95e8\\u65b0\\u589e\",\"menuType\":\"F\",\"orderNum\":1,\"isFrame\":\"1\",\"isCache\":\"0\",\"visible\":\"0\",\"status\":\"0\",\"perms\":\"system:dept:add\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:18:39'),(91,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','{\"parentId\":1103,\"menuName\":\"\\u90e8\\u95e8\\u4fee\\u6539\",\"menuType\":\"F\",\"orderNum\":2,\"isFrame\":\"1\",\"isCache\":\"0\",\"visible\":\"0\",\"status\":\"0\",\"perms\":\"system:dept:edit\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:18:57'),(92,'menu',2,'','post',0,'admin','','sys_menu/update_menu','127.0.0.1','','{\"parentId\":1103,\"menuName\":\"\\u90e8\\u95e8\\u5220\\u9664\",\"menuType\":\"F\",\"orderNum\":4,\"isFrame\":\"1\",\"isCache\":\"0\",\"visible\":\"0\",\"status\":\"0\",\"perms\":\"system:dept:remove\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:19:18'),(93,'dept',2,'','post',0,'admin','','sys_dept/update_dept','127.0.0.1','','{\"deptId\":\"190\",\"parentId\":100,\"ancestors\":\",0\",\"deptName\":\"\\u7814\\u53d1\\u90e8\\u95e8\",\"orderNum\":7,\"leader\":\"\\u8001\\u738b\",\"phone\":\"15566667777\",\"email\":\"123@123.com\",\"delFlag\":\"0\",\"status\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2023-09-26 15:02:12\",\"updateBy\":\"\",\"updateTime\":null}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:20:19'),(94,'dept',2,'','post',0,'admin','','sys_dept/update_dept','127.0.0.1','','{\"deptId\":\"191\",\"parentId\":100,\"ancestors\":\",1\",\"deptName\":\"\\u6280\\u672f\\u90e8\\u95e8\",\"orderNum\":7,\"leader\":\"\\u8001\\u5f20\",\"phone\":null,\"email\":null,\"delFlag\":\"0\",\"status\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2023-09-26 15:03:54\",\"updateBy\":\"\",\"updateTime\":null}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:20:43'),(95,'dept',2,'','post',0,'admin','','sys_dept/update_dept','127.0.0.1','','{\"deptId\":\"190\",\"parentId\":\"100\",\"ancestors\":\",0\",\"deptName\":\"\\u7814\\u53d1\\u90e8\\u95e8\",\"orderNum\":1,\"leader\":\"\\u8001\\u738b\",\"phone\":\"15566667777\",\"email\":\"123@123.com\",\"delFlag\":\"0\",\"status\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2023-09-26 15:02:12\",\"updateBy\":\"admin\",\"updateTime\":\"2023-09-26 15:20:19\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:24:41'),(96,'dept',2,'','post',0,'admin','','sys_dept/update_dept','127.0.0.1','','{\"deptId\":\"191\",\"parentId\":\"100\",\"ancestors\":\",1\",\"deptName\":\"\\u6280\\u672f\\u90e8\\u95e8\",\"orderNum\":2,\"leader\":\"\\u8001\\u5f20\",\"phone\":\"15566667776\",\"email\":\"122@123.com\",\"delFlag\":\"0\",\"status\":\"1\",\"createBy\":\"admin\",\"createTime\":\"2023-09-26 15:03:54\",\"updateBy\":\"admin\",\"updateTime\":\"2023-09-26 15:20:43\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:25:11'),(97,'dept',2,'','post',0,'admin','','sys_dept/update_dept','127.0.0.1','','{\"parentId\":100,\"deptName\":\"\\u6d4b\\u8bd5\\u90e8\\u95e8\",\"orderNum\":3,\"status\":\"0\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:25:30'),(98,'dept',2,'','post',0,'admin','','sys_dept/update_dept','127.0.0.1','','{\"parentId\":190,\"deptName\":\"\\u786c\\u4ef6\\u7814\\u53d1\",\"orderNum\":0,\"status\":\"0\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:25:56'),(99,'dept',2,'','post',0,'admin','','sys_dept/update_dept','127.0.0.1','','{\"parentId\":190,\"deptName\":\"\\u8f6f\\u4ef6\\u7814\\u53d1\",\"orderNum\":1,\"status\":\"0\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:26:06'),(100,'dept',2,'','post',0,'admin','','sys_dept/update_dept','127.0.0.1','','{\"parentId\":192,\"deptName\":\"\\u6d4b\\u8bd51\\u90e8\",\"orderNum\":0,\"status\":\"0\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:26:25'),(101,'dept',2,'','post',0,'admin','','sys_dept/update_dept','127.0.0.1','','{\"deptId\":\"195\",\"parentId\":\"192\",\"ancestors\":\"0,100,192\",\"deptName\":\"\\u6d4b\\u8bd51\\u90e81\",\"orderNum\":0,\"leader\":null,\"phone\":null,\"email\":null,\"delFlag\":\"0\",\"status\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2023-09-26 15:26:25\",\"updateBy\":\"\",\"updateTime\":null}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:26:35'),(102,'dept',2,'','post',0,'admin','','sys_dept/delete_dept','127.0.0.1','','195','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:26:38'),(103,'dept',2,'','post',0,'admin','','sys_dept/update_dept','127.0.0.1','','{\"parentId\":192,\"deptName\":\"\\u6d4b\\u8bd51\\u90e8\",\"orderNum\":1,\"status\":\"0\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:26:55'),(104,'role',2,'','post',0,'admin','','sys_role/update_role','127.0.0.1','','{\"roleId\":4,\"roleName\":\"\\u6d4b\\u8bd5\\u89d2\\u8272\",\"roleKey\":\"tester\",\"roleSort\":0,\"dataScope\":\"2\",\"delFlag\":\"0\",\"menuCheckStrictly\":true,\"deptCheckStrictly\":true,\"status\":\"0\",\"createBy\":\"netwolf\",\"createTime\":\"2022-12-06 16:43:31\",\"updateBy\":\"netwolf\",\"updateTime\":\"2023-06-14 05:41:06\",\"remark\":null,\"admin\":false,\"flag\":false,\"menuIds\":[1,100,1001,1002,1003,1004,1005,1006,1007,101,1008,1009,1010,1011,1012,102,1013,1014,1015,1016,1103,1104,1105,1106,1107,105,1026,1027,1028,1029,1030,1097,1098,1099,1100,1101,501,1043,1044,1045,500,1040,1041,1042,2,112]}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:27:09'),(105,'role',2,'','post',0,'admin','','sys_role/delete_role','127.0.0.1','','9','{\"success\":true,\"field\":\"\",\"message\":\"\\u5220\\u9664\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:27:48'),(106,'role',2,'','post',0,'admin','','sys_role/update_role','127.0.0.1','','{\"roleName\":\"\\u6d4b\\u8bd5\\u89d2\\u82722\",\"roleKey\":\"test2\",\"roleSort\":99,\"status\":\"0\",\"menuIds\":[1,100,1001,1002,1003,1004,1005,1006,1007,101,1008,1009,1010,1011,1012,102,1013,1014,1015,1016,1103,1104,1105,1106,1107,105,1026,1027,1028,1029,1030,1097,1098,1099,1100,1101,501,1043,1044,1045,500,1040,1041,1042],\"deptIds\":[],\"menuCheckStrictly\":true,\"deptCheckStrictly\":true,\"remark\":\"\\u6d4b\\u8bd5\\u89d2\\u82722\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u6dfb\\u52a0\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:28:19'),(107,'role',2,'','post',0,'admin','','sys_role/update_role','127.0.0.1','','{\"roleId\":10,\"roleName\":\"\\u6d4b\\u8bd5\\u89d2\\u82722\",\"roleKey\":\"test2\",\"roleSort\":99,\"dataScope\":null,\"delFlag\":\"0\",\"menuCheckStrictly\":true,\"deptCheckStrictly\":true,\"status\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2023-09-26 15:28:19\",\"updateBy\":\"\",\"updateTime\":null,\"remark\":\"\\u6d4b\\u8bd5\\u89d2\\u82722\",\"admin\":false,\"flag\":false,\"menuIds\":[1,100,1001,1002,1003,1004,1005,1006,1007,101,1008,1009,1010,1011,1012,102,1013,1014,1015,1016,1103,1104,1105,1106,1107,105,1026,1027,1028,1029,1030,1097,1098,1099,1100,1101,501,1043,1044,1045,500,1040,1041,1042]}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:29:41'),(108,'role',2,'','post',0,'admin','','sys_role/update_role','127.0.0.1','','{\"roleId\":10,\"roleName\":\"\\u6d4b\\u8bd5\\u89d2\\u82722\",\"roleKey\":\"test3\",\"roleSort\":98,\"dataScope\":null,\"delFlag\":\"0\",\"menuCheckStrictly\":true,\"deptCheckStrictly\":true,\"status\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2023-09-26 15:28:19\",\"updateBy\":\"admin\",\"updateTime\":\"2023-09-26 15:29:41\",\"remark\":\"\\u6d4b\\u8bd5\\u89d2\\u82722\",\"admin\":false,\"flag\":false,\"menuIds\":[1,100,1001,1002,1003,1004,1005,1006,1007,101,1008,1009,1010,1011,1012,102,1013,1014,1015,1016,1103,1104,1105,1106,1107,105,1026,1027,1028,1029,1030,1097,1098,1099,1100,1101,501,1043,1044,1045,500,1040,1041,1042]}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:30:00'),(109,'role',2,'','post',0,'admin','','sys_role/update_role_data_scope','127.0.0.1','','{\"roleId\":2,\"roleName\":\"\\u5ba2\\u6237\",\"roleKey\":\"customer\",\"roleSort\":\"2\",\"dataScope\":\"2\",\"delFlag\":\"0\",\"menuCheckStrictly\":true,\"deptCheckStrictly\":true,\"status\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2018-03-16 11:33:00\",\"updateBy\":\"netwolf\",\"updateTime\":\"2022-12-22 17:31:59\",\"remark\":null,\"admin\":false,\"flag\":false,\"deptIds\":[192,196]}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:56:19'),(110,'role',2,'','post',0,'admin','','sys_role/update_role_data_scope','127.0.0.1','','{\"roleId\":2,\"roleName\":\"\\u5ba2\\u6237\",\"roleKey\":\"customer\",\"roleSort\":\"2\",\"dataScope\":\"2\",\"delFlag\":\"0\",\"menuCheckStrictly\":true,\"deptCheckStrictly\":true,\"status\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2018-03-16 11:33:00\",\"updateBy\":\"admin\",\"updateTime\":\"2023-09-26 15:56:19\",\"remark\":null,\"admin\":false,\"flag\":false,\"deptIds\":[192,196]}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 15:56:52'),(111,'role',2,'','post',0,'admin','','sys_role/update_role_data_scope','127.0.0.1','','{\"roleId\":2,\"roleName\":\"\\u5ba2\\u6237\",\"roleKey\":\"customer\",\"roleSort\":\"2\",\"dataScope\":\"2\",\"delFlag\":\"0\",\"menuCheckStrictly\":true,\"deptCheckStrictly\":true,\"status\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2018-03-16 11:33:00\",\"updateBy\":\"admin\",\"updateTime\":\"2023-09-26 15:56:52\",\"remark\":null,\"admin\":false,\"flag\":false,\"deptIds\":[192,196]}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 16:06:55'),(112,'role',2,'','post',0,'admin','','sys_role/update_role_data_scope','127.0.0.1','','{\"roleId\":2,\"roleName\":\"\\u5ba2\\u6237\",\"roleKey\":\"customer\",\"roleSort\":\"2\",\"dataScope\":\"2\",\"delFlag\":\"0\",\"menuCheckStrictly\":true,\"deptCheckStrictly\":true,\"status\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2018-03-16 11:33:00\",\"updateBy\":\"admin\",\"updateTime\":\"2023-09-26 16:06:55\",\"remark\":null,\"admin\":false,\"flag\":false,\"deptIds\":[192,196]}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 16:07:22'),(113,'role',2,'','post',0,'admin','','sys_role/update_role','127.0.0.1','','{\"roleId\":2,\"roleName\":\"\\u5ba2\\u6237\",\"roleKey\":\"customer\",\"roleSort\":2,\"dataScope\":\"2\",\"delFlag\":\"0\",\"menuCheckStrictly\":true,\"deptCheckStrictly\":true,\"status\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2018-03-16 11:33:00\",\"updateBy\":\"admin\",\"updateTime\":\"2023-09-26 16:07:22\",\"remark\":null,\"admin\":false,\"flag\":false,\"menuIds\":[1,100,1001,1002,1003,1004,1005,1006,1007,101,1008,1009,1010,1011,1012,102,1013,1014,1015,1016,1103,1104,1105,1106,1107,105,1026,1027,1028,1029,1030,1097,1098,1099,1100,1101,501,1043,1044,1045,500,1040,1041,1042]}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 16:24:47'),(114,'role',2,'','post',0,'admin','','sys_role/update_role','127.0.0.1','','{\"roleId\":2,\"roleName\":\"\\u5ba2\\u6237\",\"roleKey\":\"customer\",\"roleSort\":2,\"dataScope\":\"2\",\"delFlag\":\"0\",\"menuCheckStrictly\":false,\"deptCheckStrictly\":true,\"status\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2018-03-16 11:33:00\",\"updateBy\":\"admin\",\"updateTime\":\"2023-09-26 16:24:47\",\"remark\":null,\"admin\":false,\"flag\":false,\"menuIds\":[1,100,1001,1002,1003,1004,1005,1006,1007,101,1008,1009,1010,1011,1012,102,1013,1014,1015,1016,1103,1104,1105,1106,1107,105,1026,1027,1028,1029,1030,1097,1098,1099,1100,1101,501,1043,1044,1045,500,1040,1041,1042]}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 16:24:57'),(115,'role',2,'','post',0,'admin','','sys_role/update_role','127.0.0.1','','{\"roleId\":2,\"roleName\":\"\\u5ba2\\u6237\",\"roleKey\":\"customer\",\"roleSort\":2,\"dataScope\":\"2\",\"delFlag\":\"0\",\"menuCheckStrictly\":true,\"deptCheckStrictly\":true,\"status\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2018-03-16 11:33:00\",\"updateBy\":\"admin\",\"updateTime\":\"2023-09-26 16:24:57\",\"remark\":null,\"admin\":false,\"flag\":false,\"menuIds\":[1,100,1001,1002,1003,1004,1005,1006,1007,101,1008,1009,1010,1011,1012,102,1013,1014,1015,1016,1103,1104,1105,1106,1107,105,1026,1027,1028,1029,1030,1097,1098,1099,1100,1101,501,1043,1044,1045,500,1040,1041,1042]}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 16:25:02'),(116,'user',2,'','post',0,'admin','','sys_user/update_sys_user','127.0.0.1','','{\"userName\":\"testUser2\",\"userId\":5,\"nickName\":\"testUser2\",\"email\":\"111@123.com\",\"phonenumber\":\"13566667775\",\"status\":\"0\",\"avatar\":\"\",\"loginIp\":\"\",\"loginDate\":null,\"delFlag\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2023-06-16 01:53:38\",\"updateBy\":\"\",\"updateTime\":null,\"remark\":\"123\",\"admin\":false,\"roleIds\":[2],\"postIds\":[4],\"deptIds\":[],\"password\":\"\",\"deptId\":190,\"sex\":\"0\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 16:27:43'),(117,'user',2,'','post',0,'admin','','sys_user/update_sys_user','127.0.0.1','','{\"userName\":\"testUser2\",\"userId\":5,\"nickName\":\"testUser2\",\"email\":\"111@123.com\",\"phonenumber\":\"13566667775\",\"status\":\"0\",\"avatar\":\"\",\"loginIp\":\"\",\"loginDate\":null,\"delFlag\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2023-06-16 01:53:38\",\"updateBy\":\"admin\",\"updateTime\":\"2023-09-26 16:27:43\",\"remark\":\"123\",\"admin\":false,\"roleIds\":[2],\"postIds\":[4],\"deptIds\":[],\"password\":\"\",\"deptId\":191,\"sex\":\"0\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 16:30:12'),(118,'user',2,'','post',0,'admin','','sys_user/update_sys_user','127.0.0.1','','{\"userName\":\"testUser2\",\"userId\":5,\"nickName\":\"testUser2\",\"email\":\"111@123.com\",\"phonenumber\":\"13566667775\",\"status\":\"1\",\"avatar\":\"\",\"deptId\":\"191\",\"sex\":\"0\",\"loginIp\":\"\",\"loginDate\":null,\"delFlag\":\"0\",\"createBy\":\"admin\",\"createTime\":\"2023-06-16 01:53:38\",\"updateBy\":\"admin\",\"updateTime\":\"2023-09-26 16:30:12\",\"remark\":\"123\",\"admin\":false,\"roleIds\":[2],\"postIds\":[4],\"deptIds\":[],\"password\":\"\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 16:31:53'),(119,'user',2,'','post',0,'admin','','sys_user/update_user_status','127.0.0.1','','{\"userId\":5,\"status\":\"0\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u4fee\\u6539\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 16:31:57'),(120,'user',2,'','post',0,'admin','','sys_user/update_user_role','127.0.0.1','','','{\"success\":false,\"field\":\"userId\",\"message\":\"\\u7528\\u6237\\u4fe1\\u606f\\u9519\\u8bef\",\"msg\":\"\\u7528\\u6237\\u4fe1\\u606f\\u9519\\u8bef\",\"code\":1}',1,'用户信息错误','2023-09-26 16:32:08'),(121,'user',2,'','post',0,'admin','','sys_user/update_user_role','127.0.0.1','','','{\"success\":false,\"field\":\"userId\",\"message\":\"\\u7528\\u6237\\u4fe1\\u606f\\u9519\\u8bef\",\"msg\":\"\\u7528\\u6237\\u4fe1\\u606f\\u9519\\u8bef\",\"code\":1}',1,'用户信息错误','2023-09-26 16:35:48'),(122,'user',2,'','post',0,'admin','','sys_user/reset_user_password','127.0.0.1','','{\"userId\":5,\"password\":\"123456\"}','{\"success\":true,\"field\":\"\",\"message\":\"\\u91cd\\u7f6e\\u6210\\u529f\",\"code\":200}',0,NULL,'2023-09-26 16:37:38');
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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='角色信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_role`
--

LOCK TABLES `sys_role` WRITE;
/*!40000 ALTER TABLE `sys_role` DISABLE KEYS */;
INSERT INTO `sys_role` VALUES (1,'管理员','admin',1,'1','0','0','admin','2018-03-16 11:33:00','ry','2018-03-16 11:33:00','管理员',1,1),(2,'客户','customer',2,'2','0','0','admin','2018-03-16 11:33:00','admin','2023-09-26 16:25:02',NULL,1,1),(3,'设计师','designer',3,'1','0','0','netwolf','2022-11-29 18:06:02','UC服务·Jesse L','2023-01-05 14:06:54',NULL,1,1),(4,'测试角色','tester',0,'2','0','0','netwolf','2022-12-06 16:43:31','admin','2023-09-26 15:27:09',NULL,1,1),(5,'普通管理员','commonAdmin',5,'1','0','0','netwolf','2022-12-15 10:34:17','netwolf','2023-01-05 15:09:24',NULL,1,1),(10,'测试角色2','test3',98,NULL,'0','0','admin','2023-09-26 15:28:19','admin','2023-09-26 15:30:00','测试角色2',1,1);
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
INSERT INTO `sys_role_dept` VALUES (2,192),(2,196);
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
INSERT INTO `sys_role_menu` VALUES (2,1),(2,100),(2,101),(2,102),(2,105),(2,500),(2,501),(2,1001),(2,1002),(2,1003),(2,1004),(2,1005),(2,1006),(2,1007),(2,1008),(2,1009),(2,1010),(2,1011),(2,1012),(2,1013),(2,1014),(2,1015),(2,1016),(2,1026),(2,1027),(2,1028),(2,1029),(2,1030),(2,1040),(2,1041),(2,1042),(2,1043),(2,1044),(2,1045),(2,1097),(2,1098),(2,1099),(2,1100),(2,1101),(2,1103),(2,1104),(2,1105),(2,1106),(2,1107),(3,1065),(3,1066),(3,1067),(3,1068),(3,1069),(3,1075),(3,1076),(3,1077),(3,1078),(3,1079),(3,1080),(3,1081),(3,1082),(3,1083),(3,1084),(3,1085),(3,1086),(3,1088),(3,1089),(3,1090),(3,1091),(3,1093),(3,1094),(4,1),(4,2),(4,100),(4,101),(4,102),(4,105),(4,112),(4,500),(4,501),(4,1001),(4,1002),(4,1003),(4,1004),(4,1005),(4,1006),(4,1007),(4,1008),(4,1009),(4,1010),(4,1011),(4,1012),(4,1013),(4,1014),(4,1015),(4,1016),(4,1026),(4,1027),(4,1028),(4,1029),(4,1030),(4,1040),(4,1041),(4,1042),(4,1043),(4,1044),(4,1045),(4,1097),(4,1098),(4,1099),(4,1100),(4,1101),(4,1103),(4,1104),(4,1105),(4,1106),(4,1107),(5,1),(5,100),(5,101),(5,102),(5,103),(5,105),(5,1001),(5,1002),(5,1003),(5,1004),(5,1005),(5,1006),(5,1007),(5,1008),(5,1009),(5,1010),(5,1011),(5,1012),(5,1013),(5,1014),(5,1015),(5,1016),(5,1017),(5,1018),(5,1019),(5,1020),(5,1026),(5,1027),(5,1028),(5,1029),(5,1030),(5,1060),(5,1061),(5,1062),(5,1063),(5,1064),(5,1065),(5,1066),(5,1067),(5,1068),(5,1069),(5,1075),(5,1076),(5,1077),(5,1078),(5,1079),(5,1080),(5,1081),(5,1082),(5,1083),(5,1084),(5,1085),(5,1086),(5,1088),(5,1089),(5,1090),(5,1091),(5,1093),(5,1094),(9,1),(9,2),(9,100),(9,101),(9,102),(9,103),(9,104),(9,105),(9,106),(9,112),(9,500),(9,501),(9,1001),(9,1002),(9,1003),(9,1004),(9,1005),(9,1006),(9,1007),(9,1008),(9,1009),(9,1010),(9,1011),(9,1012),(9,1013),(9,1014),(9,1015),(9,1016),(9,1017),(9,1018),(9,1019),(9,1020),(9,1021),(9,1022),(9,1023),(9,1024),(9,1025),(9,1026),(9,1027),(9,1028),(9,1029),(9,1030),(9,1031),(9,1032),(9,1033),(9,1034),(9,1035),(9,1040),(9,1041),(9,1042),(9,1043),(9,1044),(9,1045),(10,1),(10,100),(10,101),(10,102),(10,105),(10,500),(10,501),(10,1001),(10,1002),(10,1003),(10,1004),(10,1005),(10,1006),(10,1007),(10,1008),(10,1009),(10,1010),(10,1011),(10,1012),(10,1013),(10,1014),(10,1015),(10,1016),(10,1026),(10,1027),(10,1028),(10,1029),(10,1030),(10,1040),(10,1041),(10,1042),(10,1043),(10,1044),(10,1045),(10,1097),(10,1098),(10,1099),(10,1100),(10,1101),(10,1103),(10,1104),(10,1105),(10,1106),(10,1107);
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
INSERT INTO `sys_user` VALUES (1,103,'admin','netwolf','00','ry@163.com','15888888888','1','','9c75c603b8d15d848c03ea3096995ff4','0','0','127.0.0.1','2023-09-26 16:24:27','admin','2023-06-12 16:25:26','admin','2023-06-16 01:22:21','管理员账号'),(2,100,'ry','若依','00','ry@qq.com','15666666666','1','','cb56df0e6fd047133761d85fd21e2f61','0','0','127.0.0.1','2023-06-12 16:25:26','admin','2023-06-12 16:25:26','admin','2023-06-16 01:51:16','测试员'),(3,105,'netwolf1','测试人员','00','123@163.com','13566778877','0','','214ce51a2d0d670e6f7e2f93f28140ce','1','1','',NULL,'admin','2023-06-14 06:32:23','admin','2023-06-14 07:06:50',NULL),(4,100,'testUser','testUser','00','','','0','','ce6cbfff354cc1d10f5d2034872727f9','0','0','',NULL,'admin','2023-06-16 01:53:29','',NULL,NULL),(5,191,'testUser2','testUser2','00','111@123.com','13566667775','0','','29ea4faf7ef2dbf328865fcbde1676ed','0','0','',NULL,'admin','2023-06-16 01:53:38','admin','2023-09-26 16:37:38','123');
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
INSERT INTO `sys_user_post` VALUES (1,1),(2,2),(5,4),(24,1),(24,2),(31,1),(31,2);
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
INSERT INTO `sys_user_role` VALUES (2,3),(4,1),(5,2),(5,3),(5,5),(24,3),(66976,2),(68346,2),(69590,2),(69590,3),(69607,2),(69607,3),(69637,2),(69641,2),(69660,2),(69850,2),(69896,2),(70083,2),(70220,5),(70482,2),(70492,2),(70495,2),(70534,2),(70605,2),(70606,2),(70608,2),(70609,2),(70610,2),(70612,2),(70613,2),(70614,2),(70615,2),(70616,2),(70617,2),(70618,2),(70620,2),(70655,2),(70722,2),(70735,2),(70736,2),(70740,2),(70741,2),(70742,2),(70743,2),(70752,2),(70755,2),(70765,2),(70766,2),(70767,2),(70768,2),(70769,2),(70770,2),(70771,2),(70772,2),(70773,2),(70774,2),(70775,2),(70777,2),(70780,2),(70781,2),(70782,2),(70783,2),(70784,2),(70785,2),(70786,2),(70787,2),(70788,2),(70999,2),(71000,2),(71001,2),(71002,2),(71023,2),(71108,2),(71144,2),(71368,3),(71368,5),(71905,2),(71908,2),(71908,3),(71908,5),(71909,3),(71910,3),(71911,2),(71913,2),(71914,2),(71915,2),(71916,2),(71918,2),(71919,2),(71920,2),(71921,2),(71922,2),(71923,2),(71924,2),(71925,2),(71926,3),(71927,3),(71928,3),(71930,2),(71931,2),(71932,2),(71933,2),(71934,2),(71935,2),(71936,2),(71937,2),(71938,2),(71939,2),(71940,2),(71941,2),(71942,2),(71943,2),(71944,2),(71945,2),(71946,2),(71947,2),(71948,2),(71949,2),(71950,2),(71951,2),(71952,2),(71953,2),(71954,2),(71955,2),(71956,2),(71957,2),(71958,2),(71959,2),(71960,2),(71961,2),(71962,2),(71963,2),(71964,2),(71965,2),(71966,2),(71967,2),(71968,2),(71969,2),(71970,2),(71971,2),(71972,2),(71973,2),(71974,2),(71975,2),(71976,2),(71977,2),(71978,2),(71979,2),(71980,2),(71981,2),(71982,2),(71983,2),(71984,2),(71985,3),(71986,3),(71987,2),(71988,2),(71989,2),(71990,3),(71991,2),(71992,2),(71993,2),(71994,3),(71995,2),(71996,2),(71997,2),(71998,2),(71999,2),(72000,2),(72001,2);
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

-- Dump completed on 2023-09-26 16:42:55
