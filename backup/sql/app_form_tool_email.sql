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

 Date: 12/03/2026 14:06:36
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for app_form_tool_email
-- ----------------------------
DROP TABLE IF EXISTS `app_form_tool_email`;
CREATE TABLE `app_form_tool_email`  (
  `EId` int(11) NOT NULL AUTO_INCREMENT,
  `DId` int(11) NULL DEFAULT 0 COMMENT '关联id',
  `Type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT '' COMMENT 'inquiry - 产品询价 blank - 空白',
  `Title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT '' COMMENT '邮件主题',
  `Content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL COMMENT '邮件内容',
  `Status` tinyint(1) NULL DEFAULT 0 COMMENT '发送状态 0 - 没发送 1 - 成功 2 - 失败',
  `AccTime` int(11) NULL DEFAULT 0 COMMENT '发送时间',
  `SenderEmail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '' COMMENT '发件邮箱',
  `SenderName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '' COMMENT '发件人',
  `ModifyTime` int(11) NULL DEFAULT 0 COMMENT '最后修改时间',
  PRIMARY KEY (`EId`) USING BTREE,
  INDEX `DId`(`DId` ASC) USING BTREE,
  INDEX `ModifyTime`(`ModifyTime` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
