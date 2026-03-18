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

 Date: 12/03/2026 14:07:00
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for app_form_tool_field_en
-- ----------------------------
DROP TABLE IF EXISTS `app_form_tool_field_en`;
CREATE TABLE `app_form_tool_field_en`  (
  `FieldId` int(11) NOT NULL AUTO_INCREMENT,
  `FId` int(11) NULL DEFAULT 0 COMMENT '关联表单Id',
  `FormType` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT '' COMMENT '表单类型 inquiry-询盘 feedback-联系我们',
  `Name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '字段名称',
  `Type` int(11) NULL DEFAULT 0 COMMENT '类型',
  `FieldSetting` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL COMMENT '字段设置选项',
  `MyOrder` int(11) NULL DEFAULT 0 COMMENT '排序',
  `BMyOrder` int(11) NULL DEFAULT 0 COMMENT 'B端排序',
  `IsShow` tinyint(1) NULL DEFAULT 1 COMMENT '是否显示 B端显示',
  `ModifyTime` int(11) NULL DEFAULT 0 COMMENT '最后修改时间',
  PRIMARY KEY (`FieldId`) USING BTREE,
  INDEX `FId`(`FId` ASC) USING BTREE,
  INDEX `ModifyTime`(`ModifyTime` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci COMMENT = '表单字段' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
