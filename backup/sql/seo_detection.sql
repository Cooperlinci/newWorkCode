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

 Date: 17/03/2026 17:15:19
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for seo_detection
-- ----------------------------
DROP TABLE IF EXISTS `seo_detection`;
CREATE TABLE `seo_detection`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '' COMMENT '类型',
  `Language` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '' COMMENT '语言',
  `ReleId` int(11) NOT NULL DEFAULT 0 COMMENT '关联ID',
  `Category` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '' COMMENT '分类 (SeoTitle:元标题 SeoDescription:元描述 Link:链接 Pic:图片)',
  `Effect` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'good' COMMENT '效果 (good:良好 less:小于 more:大于 lack:缺少)',
  `LastTime` int(11) NOT NULL DEFAULT 0 COMMENT '最后修改时间',
  `ModifyTime` int(11) NULL DEFAULT 0 COMMENT '最后修改时间',
  PRIMARY KEY (`Id`) USING BTREE,
  INDEX `ReleId`(`ReleId` ASC) USING BTREE,
  INDEX `ModifyTime`(`ModifyTime` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci COMMENT = 'SEO检测总表' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
