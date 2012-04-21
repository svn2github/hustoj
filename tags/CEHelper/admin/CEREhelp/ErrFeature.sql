SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `ErrFeature`
-- ----------------------------
DROP TABLE IF EXISTS `ErrFeature`;
CREATE TABLE `ErrFeature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `regex` text NOT NULL,
  `info` text NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ErrFeature
-- ----------------------------
INSERT INTO `ErrFeature` VALUES ('18', '/warning.*declaration of \'main\' with no type/', 'C++标准中，main函数必须有返回值', '1');
INSERT INTO `ErrFeature` VALUES ('21', '/\'.*\' was not declared in this scope/', '变量没有声明过，检查下是否拼写错误！', '0');
INSERT INTO `ErrFeature` VALUES ('22', '/main’ must return ‘int’/', '在标准C语言中，main函数返回值类型必须是int，教材和VC中使用void是非标准的用法', '0');
INSERT INTO `ErrFeature` VALUES ('23', '/ .* was not declared in this scope/', '函数或变量没有声明过就进行调用，检查下是否导入了正确的头文件', '0');
INSERT INTO `ErrFeature` VALUES ('24', '/printf.*was not declared in this scope/', '警告：忽略了函数的返回值，可能是函数用错或者没有考虑到返回值异常的情况', '0');
INSERT INTO `ErrFeature` VALUES ('25', '/:.*__int64’ undeclared/', '__int64没有声明，在标准C/C++中不支持微软VC中的__int64,请使用long long来声明64位变量', '0');
INSERT INTO `ErrFeature` VALUES ('26', '/:.*expected ‘;’ before/', '前一行缺少分号', '0');
