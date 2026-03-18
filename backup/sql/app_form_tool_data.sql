/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80012 (8.0.12)
 Source Host           : 127.0.0.1:3306
 Source Schema         : upbh754

 Target Server Type    : MySQL
 Target Server Version : 80012 (8.0.12)
 File Encoding         : 65001

 Date: 12/03/2026 14:06:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for app_form_tool_data
-- ----------------------------
DROP TABLE IF EXISTS `app_form_tool_data`;
CREATE TABLE `app_form_tool_data`  (
  `DId` int(11) NOT NULL AUTO_INCREMENT,
  `FId` int(11) NULL DEFAULT 0 COMMENT '关联表单id',
  `Number` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '询盘单号',
  `UserId` int(11) NOT NULL DEFAULT 0 COMMENT '会员Id',
  `FormFieldData` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL COMMENT '表单字段数据',
  `RelatedInformation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL COMMENT '关联信息',
  `IsRead` tinyint(1) NOT NULL DEFAULT 0 COMMENT '未读/已读',
  `AccTime` int(11) NULL DEFAULT 0 COMMENT '添加时间',
  `IP` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT '',
  `Source` tinyint(1) NOT NULL DEFAULT 0,
  `RefererId` tinyint(1) NOT NULL DEFAULT 0 COMMENT '来源ID',
  `RefererName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '' COMMENT '来源地址名称简称',
  `Referer` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '' COMMENT '来源',
  `IsReply` tinyint(1) NULL DEFAULT 0 COMMENT '是否回复',
  `SalesId` mediumint(9) NULL DEFAULT 0,
  `RequestLink` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL COMMENT '记录当前链接',
  `CountryAcronym` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT '' COMMENT 'IP国家',
  `EventExecute` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否已执行GA事件',
  `ModifyTime` int(11) NULL DEFAULT 0 COMMENT '最后修改时间',
  PRIMARY KEY (`DId`) USING BTREE,
  INDEX `IsRead`(`IsRead` ASC) USING BTREE,
  INDEX `AccTime`(`AccTime` ASC) USING BTREE,
  INDEX `Number_IP`(`Number` ASC, `IP` ASC) USING BTREE,
  INDEX `FId`(`FId` ASC) USING BTREE,
  INDEX `UserId`(`UserId` ASC) USING BTREE,
  INDEX `RefererId`(`RefererId` ASC) USING BTREE,
  INDEX `SalesId`(`SalesId` ASC) USING BTREE,
  INDEX `ModifyTime`(`ModifyTime` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci COMMENT = '表单数据' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
