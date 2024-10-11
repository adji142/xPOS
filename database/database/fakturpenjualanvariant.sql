/*
 Navicat Premium Data Transfer

 Source Server         : AISServer
 Source Server Type    : MySQL
 Source Server Version : 100240
 Source Host           : localhost:3306
 Source Schema         : xpos

 Target Server Type    : MySQL
 Target Server Version : 100240
 File Encoding         : 65001

 Date: 09/10/2024 15:21:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for fakturpenjualanvariant
-- ----------------------------
DROP TABLE IF EXISTS `fakturpenjualanvariant`;
CREATE TABLE `fakturpenjualanvariant`  (
  `NoTransaksi` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `KodeItem` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `NoUrut` int(6) NULL DEFAULT NULL,
  `VariantGrupID` int(6) NULL DEFAULT NULL,
  `VariantID` int(6) NULL DEFAULT NULL,
  `AddonMenuID` int(11) NULL DEFAULT NULL,
  `NamaGroupVariant` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `NamaVariant` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ExtraQty` decimal(10, 2) NULL DEFAULT NULL,
  `ExtraPrice` decimal(10, 2) NULL DEFAULT NULL,
  `RecordOwnerID` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(6) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
