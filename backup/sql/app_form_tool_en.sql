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

 Date: 12/03/2026 14:06:51
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for app_form_tool_en
-- ----------------------------
DROP TABLE IF EXISTS `app_form_tool_en`;
CREATE TABLE `app_form_tool_en`  (
  `FId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT '' COMMENT '表单名称',
  `Title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `SubTitle` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `Type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT '' COMMENT '表单类型 inquiry-询盘 feedback-联系我们 custom-自定义',
  `ProInfo` tinyint(1) NULL DEFAULT 0 COMMENT '获取产品信息',
  `Pages` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL COMMENT '显示页面',
  `ModifyTime` int(11) NULL DEFAULT 0 COMMENT '最后修改时间',
  PRIMARY KEY (`FId`) USING BTREE,
  INDEX `Type`(`Type` ASC) USING BTREE,
  INDEX `ModifyTime`(`ModifyTime` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci COMMENT = '表单工具' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
