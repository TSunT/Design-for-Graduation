-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 17, 2020 at 09:12 AM
-- Server version: 5.7.26
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `MyClinic`
--
CREATE SCHEMA MyClinic
-- --------------------------------------------------------

--
-- Table structure for table `table_dep`
--

CREATE TABLE `table_dep` (
  `dep_id` int(11) NOT NULL,
  `dep_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_dep`
--

INSERT INTO `table_dep` (`dep_id`, `dep_name`) VALUES
(1, '心内科'),
(2, '呼吸科'),
(3, '血液科'),
(4, '消化科'),
(5, '内分泌科'),
(6, '免疫科'),
(7, '眼科'),
(8, '耳鼻喉科'),
(9, '口腔科'),
(10, '皮肤科'),
(11, '外科'),
(12, '收费处'),
(13, '药物管理处'),
(14, '信息化处'),
(15, '其它');

-- --------------------------------------------------------

--
-- Table structure for table `table_medicine`
--

CREATE TABLE `table_medicine` (
  `medicine_id` int(11) NOT NULL,
  `medicine_name` varchar(20) NOT NULL,
  `medicine_type` varchar(20) DEFAULT NULL,
  `cost` int(10) UNSIGNED NOT NULL,
  `rest` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_medicine`
--

INSERT INTO `table_medicine` (`medicine_id`, `medicine_name`, `medicine_type`, `cost`, `rest`) VALUES
(1, '阿莫西林', '抗生素', 30, 96),
(2, '青霉素钠', '抗生素', 20, 100),
(3, '头孢拉定胶囊', '抗生素', 40, 96),
(4, '头孢他啶', '抗菌消炎类', 40, 194),
(5, '红霉素片', '抗菌消炎类', 20, 110),
(6, '利巴韦林', '抗病毒药', 40, 100),
(7, '阿昔洛韦', '抗病毒药', 40, 100),
(8, '阿苯达唑片', '抗寄生虫药', 45, 98),
(9, '左旋咪唑片', '抗寄生虫药', 46, 100),
(10, '卡马西平', '抗痢疾药', 30, 100),
(11, '新斯的明', '抗菌消炎类', 33, 8),
(12, '苯巴比妥注射液', '抗痢疾药', 60, 100),
(13, '琥珀胆碱', '抗胆碱药', 30, 100);

-- --------------------------------------------------------

--
-- Table structure for table `table_notice`
--

CREATE TABLE `table_notice` (
  `patient_id` int(11) NOT NULL,
  `register_time` int(11) NOT NULL,
  `doctor_id` char(10) DEFAULT NULL,
  `dep_id` int(11) DEFAULT NULL,
  `status` char(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_notice`
--

INSERT INTO `table_notice` (`patient_id`, `register_time`, `doctor_id`, `dep_id`, `status`) VALUES
(83, 1589531801, 'b00003', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `table_patients`
--

CREATE TABLE `table_patients` (
  `patient_id` int(11) NOT NULL COMMENT '病号',
  `patient_identity` char(18) NOT NULL COMMENT '病人身份证号',
  `patient_name` varchar(20) NOT NULL,
  `patient_birthyear` int(10) UNSIGNED DEFAULT NULL,
  `patient_gender` enum('男','女') DEFAULT '男',
  `patient_tel` char(11) NOT NULL,
  `allergy` varchar(100) DEFAULT NULL,
  `input_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='病人表';

--
-- Dumping data for table `table_patients`
--

INSERT INTO `table_patients` (`patient_id`, `patient_identity`, `patient_name`, `patient_birthyear`, `patient_gender`, `patient_tel`, `allergy`, `input_time`) VALUES
(59, '320101198103052315', '张小华', 1981, '男', '13813775231', '头孢', '2020-03-16'),
(60, '32010219810514256X', '李芳', 1981, '女', '13613277234', '青霉素,头孢', '2020-03-16'),
(61, '320103198406072538', '赵俊', 1984, '男', '13701578231', '无', '2020-03-16'),
(62, '320102198209124517', '张帆', 1982, '男', '18905182345', '无', '2020-03-16'),
(63, '320104197611062564', '程陈', 1976, '女', '13951958001', '青霉素', '2020-03-16'),
(65, '320104197608262564', '李清', 1976, '女', '13951954800', '无', '2020-03-16'),
(66, '320106198701052315', '王晓宇', 1987, '男', '13367902318', '无', '2020-03-16'),
(67, '320103200104072458', '刘敏', 2001, '男', '13952614792', '青霉素', '2020-03-16'),
(68, '320104198604232168', '李燕', 1986, '女', '13814267365', '无', '2020-03-16'),
(69, '320107200302153246', '王敏', 2003, '女', '13224568213', '青霉素,头孢', '2020-03-16'),
(70, '320105196705085168', '王梅', 1967, '女', '13951082315', '无', '2020-03-17'),
(71, '320101198805182364', '王红', 1988, '女', '13213523154', '无', '2020-03-18'),
(72, '320105198709182146', '高爱福', 1987, '女', '13715323146', '青霉素', '2020-03-18'),
(73, '320102198703013146', '王小芳', 1987, '女', '13714623156', '青霉素', '2020-03-18'),
(74, '320102198209124587', '王芳', 1982, '女', '13951954802', '无', '2020-03-18'),
(75, '32010219870301314x', '刘宇芳', 1987, '女', '13714623156', '青霉素', '2020-03-18'),
(76, '320102198703013157', '刘宇', 1987, '男', '13714623156', '无', '2020-03-18'),
(80, '320101199402062315', '方小华', 1994, '男', '13813931258', '无', '2020-03-18'),
(81, '320102199301312657', '谭建强', 1993, '男', '13919445189', '无', '2020-03-18'),
(82, '320102195704232016', '李建华', 1957, '男', '13951954897', '无', '2020-03-18'),
(83, '320105198903023417', '杨少华', 1989, '男', '18945667365', '无', '2020-03-18'),
(84, '320105196807592574', '王国强', 1968, '男', '13717634512', '头孢', '2020-03-23'),
(85, '320103196907152375', '康建华', 1969, '男', '13614289230', '无', '2020-03-23'),
(86, '320101196702062315', '王大国', 1967, '男', '13951954896', '头孢', '2020-04-07'),
(87, '320102198603152368', '李涛', 1986, '男', '13615797800', '无', '2020-04-09'),
(88, '320104197708262568', '韩墨', 1977, '女', '13366902908', '青霉素', '2020-04-09'),
(89, '320102198207024258', '孙科文', 1982, '男', '13978954892', '无', '2020-04-09'),
(90, '320101199402112365', '王文芳', 1994, '女', '13523654805', '无', '2020-04-09'),
(91, '320101199209194517', '李志国', 1992, '男', '13951564823', '无', '2020-04-09'),
(92, '320102199209224218', '孙胡一', 1992, '男', '13951753715', '无', '2020-04-09'),
(93, '320104198908162564', '王建国', 1989, '女', '13951954808', '无', '2020-04-15'),
(94, '320101198702132315', '方少华', 1987, '男', '13951954899', '无', '2020-04-15'),
(95, '320104196608262934', '王建强', 1966, '男', '13451254801', '无', '2020-04-15'),
(96, '320105197508093271', '王建强', 1975, '男', '13515823415', '青霉素', '2020-04-15'),
(97, '320104198706044217', '王达康', 1987, '男', '13713933412', '无', '2020-04-15'),
(98, '320105199701083537', '李少波', 1997, '男', '13952734152', '无', '2020-04-15'),
(99, '320108198905034528', '王小清', 1989, '女', '13984357483', '青霉素', '2020-04-15');

-- --------------------------------------------------------

--
-- Table structure for table `table_payment`
--

CREATE TABLE `table_payment` (
  `patient_id` int(11) NOT NULL,
  `doctor_id` char(10) NOT NULL,
  `creat_time` int(11) NOT NULL,
  `total_cost` int(11) DEFAULT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_payment`
--

INSERT INTO `table_payment` (`patient_id`, `doctor_id`, `creat_time`, `total_cost`, `paid`) VALUES
(59, 'a00001', 1586429085, 30, 0),
(68, 'a00001', 1586226405, 105, 1),
(71, 'a00001', 1587023182, 3366, 1),
(73, 'a00001', 1586428935, 40, 0),
(86, 'a00001', 1586429018, 50, 0),
(89, 'b00002', 1586930351, 80, 0),
(95, 'b00001', 1586922702, 80, 0),
(96, 'a00002', 1588315437, 30, 0),
(96, 'b00001', 1586924043, 80, 1),
(96, 'b00003', 1588582975, 80, 1),
(98, 'b00002', 1586931076, 40, 0),
(99, 'b00002', 1586931465, 120, 1);

-- --------------------------------------------------------

--
-- Table structure for table `table_prescription`
--

CREATE TABLE `table_prescription` (
  `doctor_id` char(10) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `creat_time` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `number` int(10) UNSIGNED NOT NULL,
  `take` tinyint(1) DEFAULT '0',
  `paid` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_prescription`
--

INSERT INTO `table_prescription` (`doctor_id`, `patient_id`, `creat_time`, `medicine_id`, `number`, `take`, `paid`) VALUES
('a00001', 59, 1586429085, 1, 1, 0, 0),
('a00001', 68, 1586226405, 1, 2, 1, 1),
('a00001', 68, 1586226405, 8, 1, 1, 1),
('a00001', 71, 1587023182, 11, 102, 1, 1),
('a00001', 73, 1586428935, 6, 1, 0, 0),
('a00001', 86, 1586429018, 5, 1, 0, 0),
('a00001', 86, 1586429018, 10, 1, 0, 0),
('a00002', 96, 1588315437, 13, 1, 0, 0),
('b00001', 95, 1586922702, 3, 2, 0, 0),
('b00001', 96, 1586924043, 3, 2, 1, 1),
('b00002', 89, 1586930351, 4, 2, 0, 0),
('b00002', 98, 1586931076, 4, 1, 0, 0),
('b00002', 99, 1586931465, 4, 3, 1, 1),
('b00003', 96, 1588582975, 4, 2, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `table_register`
--

CREATE TABLE `table_register` (
  `patient_id` int(11) NOT NULL,
  `dep_id` int(11) NOT NULL,
  `register_time` int(11) NOT NULL,
  `status` enum('未过号','过号','叫号中','已就诊') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='挂号表';

--
-- Dumping data for table `table_register`
--

INSERT INTO `table_register` (`patient_id`, `dep_id`, `register_time`, `status`) VALUES
(63, 1, 1588311912, '已就诊'),
(63, 1, 1589608513, '未过号'),
(65, 2, 1589608497, '叫号中'),
(67, 2, 1589608477, '已就诊'),
(68, 1, 1588310068, '已就诊'),
(68, 2, 1589608451, '已就诊'),
(69, 1, 1588310083, '已就诊'),
(69, 2, 1588902498, '已就诊'),
(70, 1, 1588310097, '已就诊'),
(70, 1, 1588311937, '已就诊'),
(73, 1, 1588311965, '已就诊'),
(74, 1, 1588311977, '已就诊'),
(75, 1, 1588311989, '已就诊'),
(76, 1, 1588312003, '已就诊'),
(82, 2, 1588902473, '已就诊'),
(83, 2, 1589531801, '叫号中'),
(85, 2, 1588902437, '已就诊'),
(86, 1, 1588069190, '已就诊'),
(87, 1, 1588315415, '已就诊'),
(88, 1, 1588315385, '已就诊'),
(88, 2, 1588902455, '过号'),
(93, 2, 1588587171, '已就诊'),
(94, 2, 1588902241, '已就诊'),
(96, 1, 1588315365, '已就诊'),
(96, 2, 1588582949, '已就诊'),
(97, 1, 1588069171, '已就诊');

-- --------------------------------------------------------

--
-- Table structure for table `table_staffs`
--

CREATE TABLE `table_staffs` (
  `staff_id` char(10) NOT NULL,
  `staff_name` varchar(20) NOT NULL,
  `staff_title` enum('主任医师','副主任医师','主治医师','医师','医士','管理员','其它') DEFAULT NULL,
  `staff_salary` int(10) UNSIGNED NOT NULL,
  `staff_gender` enum('男','女') DEFAULT '男',
  `staff_tel` varchar(30) DEFAULT NULL,
  `staff_dep` int(11) DEFAULT NULL,
  `staff_office` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_staffs`
--

INSERT INTO `table_staffs` (`staff_id`, `staff_name`, `staff_title`, `staff_salary`, `staff_gender`, `staff_tel`, `staff_dep`, `staff_office`) VALUES
('A00001', '周伟', '主任医师', 48000, '男', '13813968448', 1, 'a区g01'),
('A00002', '王红', '副主任医师', 32000, '女', '13613934152', 1, 'a区f02'),
('A00003', '王平', '主治医师', 24000, '男', '13815734169', 1, 'a区c01'),
('A00004', '姜华', '主治医师', 23000, '男', '13376890715', 1, 'a区c02'),
('B00001', '李天冬', '主任医师', 48000, '男', '18905132458', 2, 'b区g01'),
('B00002', '李芳', '副主任医师', 38000, '女', '17802570998', 2, 'b区f03'),
('b00003', '方强', '副主任医师', 38000, '男', '13958835766', 2, 'b区f01'),
('b00004', '刘铭', '主治医师', 22000, '男', '13967189024', 2, 'b区d01'),
('c00001', '王强林', '主治医师', 20000, '男', '13913953789', 3, 'c区d03室'),
('c00002', '方强明', '主治医师', 20000, '男', '13415377846', 3, 'c区d03'),
('F00001', '张斌', '其它', 22000, '男', '13613875468', 14, 'f区b03'),
('F00002', '刘强', '其它', 22000, '男', '13951745333', 14, 'f区b02'),
('f00003', '孙强', '其它', 22000, '男', '13372009290', 14, 'h区'),
('g00001', '程松', '其它', 6000, '男', '13723166739', 15, 'a区等候区'),
('m00001', '何建华', '其它', 8000, '男', '13635278930', 12, '大厅'),
('p00001', '刘星', '其它', 5000, '男', '139671889132', 13, '一楼药房');

-- --------------------------------------------------------

--
-- Table structure for table `table_treatment`
--

CREATE TABLE `table_treatment` (
  `patient_id` int(11) NOT NULL,
  `doctor_id` char(10) NOT NULL,
  `add_time` int(11) NOT NULL,
  `heart_rate` int(10) UNSIGNED DEFAULT NULL,
  `blood_pressure` int(10) UNSIGNED DEFAULT NULL,
  `temperature` int(10) UNSIGNED DEFAULT NULL,
  `patient_symptoms` text,
  `present_illness` text,
  `past_illness` text,
  `diagnose` text,
  `prescription` text,
  `completed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_treatment`
--

INSERT INTO `table_treatment` (`patient_id`, `doctor_id`, `add_time`, `heart_rate`, `blood_pressure`, `temperature`, `patient_symptoms`, `present_illness`, `past_illness`, `diagnose`, `prescription`, `completed`) VALUES
(59, 'a00001', 1586429085, 64, 54, 37, '胸痛', '平时体质较差,易患感冒。无肝炎及结核病史。未作预防接种已近30 年。 系统回顾:无眼痛、视力障碍，无耳流脓、耳痛、重听，无经常鼻阻塞、流脓 涕，无牙痛史。', '平时体质较差,易患感冒。无肝炎及结核病史。未作预防接种已近30 年。 系统回顾:无眼痛、视力障碍，无耳流脓、耳痛、重听，无经常鼻阻塞、流脓 涕，无牙痛史。', '风湿性心脏病；心源性肝硬化', '阿莫西林', 1),
(65, 'a00001', 1586081998, 64, 54, 37, '患者缘反复发作劳累后心悸、气急、浮肿22年余，加重2月余', '一月下旬再次出现胸闷、气急、心悸加重，夜间不能平卧，阵发性心前区隐痛，轻度咳嗽，咯白色粘痰，自觉无发热，无咯血。', '平时体质较差,易患感冒。无肝炎及结核病史。未作预防接种已近30 年，无眼痛、视力障碍，无耳流脓、耳痛、重听，无经常鼻阻塞、流脓 涕，无牙痛史。', '', '未开处方', 1),
(66, 'a00001', 1586084569, 64, 54, 36, '反复胸闷，胸痛3年，双下肢水肿半月，再发胸痛8小时', '自诉3年前于劳累后出现胸闷，偶有胸痛，为隐痛，持续时 间约3-5分钟，无放射痛，每于活动后加重 ,于爬坡，上楼梯后为甚，休息后可自行缓解，无咳嗽，咳痰，胸痛，呼吸困难，乏力等不适，一直未予以重视', '既往体质一般,否认“糖尿病”“高血压”病史，否认“结核”、“肝炎”、“伤寒”等传染病史', '冠心病 ', '未开处方', 1),
(68, 'a00001', 1586226405, 64, 54, 37, '患者缘反复发作劳累后心悸、气急、浮肿22年余，加重2月余', '一月下旬再次出现胸闷、气急、心悸加重，夜间不能平卧，阵发性心前区隐痛，轻度咳嗽，咯白色粘痰，自觉无发热，无咯血。', '平时体质较差,易患感冒。无肝炎及结核病史。未作预防接种已近30 年。 系统回顾:无眼痛、视力障碍，无耳流脓、耳痛、重听，无经常鼻阻塞、流脓 涕，无牙痛史。', '风湿性心脏病；心源性肝硬化', '阿莫西林,阿苯达唑片', 1),
(69, 'a00001', 1586334863, 64, 54, 37, '胸痛', '平时体质较差,易患感冒。无肝炎及结核病史。未作预防接种已近30 年。 系统回顾:无眼痛、视力障碍，无耳流脓、耳痛、重听，无经常鼻阻塞、流脓 涕，无牙痛史。', '平时体质较差,易患感冒。无肝炎及结核病史。未作预防接种已近30 年。 系统回顾:无眼痛、视力障碍，无耳流脓、耳痛、重听，无经常鼻阻塞、流脓 涕，无牙痛史。', '冠心病 ', '未开处方', 1),
(70, 'a00002', 1588314282, 77, 89, 36, '心悸、呼吸困难', '心悸、呼吸困难', '无风湿热、心肌炎、高血压、慢性支气管炎、甲状腺功能亢进、糖尿病、高脂血症、动脉粥样硬化等病史。', '心律失常、心肾阳虚', '未开处方', 1),
(71, 'a00001', 1587023182, 64, 54, 37, '患者缘反复发作劳累后心悸、气急、浮肿22年余，加重2月余', '一月下旬再次出现胸闷、气急、心悸加重，夜间不能平卧，阵发性心前区隐痛，轻度咳嗽，咯白色粘痰，自觉无发热，无咯血。', '无耳流脓、耳痛、重听，无经常鼻阻塞、流脓 涕，无牙痛史。', '风湿性心脏病', '新斯的明', 1),
(73, 'a00001', 1586428935, 64, 54, 37, '患者缘反复发作劳累后心悸、气急、浮肿22年余，加重2月余', '一月下旬再次出现胸闷、气急、心悸加重，夜间不能平卧，阵发性心前区隐痛，轻度咳嗽，咯白色粘痰，自觉无发热，无咯血。', '平时体质较差,易患感冒。无肝炎及结核病史。未作预防接种已近30 年，无眼痛、视力障碍，无耳流脓、耳痛、重听，无经常鼻阻塞、流脓 涕，无牙痛史。', '风湿性心脏病；心源性肝硬化', '利巴韦林', 1),
(85, 'b00003', 1589626702, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(86, 'a00001', 1586429018, 64, 54, 37, '胸痛', '平时体质较差,易患感冒。无肝炎及结核病史。未作预防接种已近30 年。 系统回顾:无眼痛、视力障碍，无耳流脓、耳痛、重听，无经常鼻阻塞、流脓 涕，无牙痛史。', '平时体质较差,易患感冒。无肝炎及结核病史。未作预防接种已近30 年，无眼痛、视力障碍，无耳流脓、耳痛、重听，无经常鼻阻塞、流脓 涕，无牙痛史。', '冠心病 ', '红霉素片,卡马西平', 1),
(87, 'a00002', 1588348636, 69, 53, 37, '胸闷不适，时而感觉没有力气，头晕', '四肢无力，头晕', '无严重的疾病', '房颤', '未开处方', 1),
(88, 'a00002', 1588315489, 89, 186, 35, '患者于13日上午9时许在工地干活时，突发左侧肢体无力，不能站立，左手不能持物，伴有头痛、恶心，但未吐出。', '行头颅ct检查，示右侧基底节区出血（急性期）。', '有高血压史', '脑出血', '未开处方', 1),
(89, 'b00002', 1586930351, 70, 56, 38, '嗓子疼痛3天', '轻度咳嗽，咯白色粘痰，发热，四肢无力', '无耳流脓、耳痛、重听，无经常鼻阻塞、流脓 涕，无牙痛史。', '咽喉炎', '头孢他啶', 1),
(95, 'b00001', 1586922702, 64, 54, 37, '嗓子疼痛3天', '轻度咳嗽，咯白色粘痰，发热，无咯血。', '无耳流脓、耳痛、重听，无经常鼻阻塞、流脓 涕，无牙痛史。', '咽炎', '头孢拉定胶囊', 1),
(96, 'a00002', 1588315437, 56, 86, 23, '胸痛', '一月下旬再次出现胸闷、气急、心悸加重，夜间不能平卧，阵发性心前区隐痛，轻度咳嗽，咯白色粘痰，自觉无发热，无咯血。', '平时体质较差,易患感冒。无肝炎及结核病史。未作预防接种已近30 年。 系统回顾:无眼痛、视力障碍，无耳流脓、耳痛、重听，无经常鼻阻塞、流脓 涕，无牙痛史。', '风湿性心脏病', '琥珀胆碱', 1),
(96, 'b00001', 1586924043, 64, 54, 37, '嗓子疼痛3天', '轻度咳嗽，咯白色粘痰，发热', '无耳流脓、耳痛、重听，无经常鼻阻塞、流脓 涕，无牙痛史。', '咽喉炎', '头孢拉定胶囊', 1),
(96, 'b00003', 1588582975, 87, 64, 38, '发热，喉咙疼痛讲不出话来，四肢无力', '发热，喉咙红肿，肺部无异常', '有心脏病史', '咽炎', '头孢他啶', 1),
(98, 'b00002', 1586931076, 64, 54, 37, '嗓子疼痛3天', '轻度咳嗽，咯白色粘痰，发热，无咯血。', '无耳流脓、耳痛、重听，无经常鼻阻塞、流脓 涕，无牙痛史。', '咽炎', '头孢他啶', 1),
(99, 'b00002', 1586931465, 77, 60, 38, '咳嗽3天，今天早起来发热，四肢无力', '轻度咳嗽，咯白色粘痰，发热，无咯血。', '无耳流脓、耳痛、重听，无经常鼻阻塞、流脓 涕，无牙痛史。', '慢性咽喉炎', '头孢他啶', 1);

-- --------------------------------------------------------

--
-- Table structure for table `table_user`
--

CREATE TABLE `table_user` (
  `staff_id` char(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `user_pwd` char(32) NOT NULL,
  `last_login_ip` char(15) DEFAULT NULL,
  `last_login_time` int(10) DEFAULT NULL,
  `login_times` int(11) NOT NULL DEFAULT '0',
  `feasible` tinyint(1) NOT NULL DEFAULT '1',
  `role` int(11) NOT NULL,
  `register_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_user`
--

INSERT INTO `table_user` (`staff_id`, `username`, `user_pwd`, `last_login_ip`, `last_login_time`, `login_times`, `feasible`, `role`, `register_date`) VALUES
('a00001', '周伟', 'e2010f5e094d7e1dfb42da036f90883f', '192.168.124.8', 1589646201, 41, 1, 1, '2020-03-21'),
('a00002', '王红', '78728bca9451b3ac00d3a5d641192d66', '::1', 1589608212, 30, 1, 1, '2020-03-21'),
('a00003', '王平', '55ba18efa60b22b46dabf681c180617c', NULL, NULL, 0, 1, 1, '2020-03-21'),
('a00004', '姜华', '07d1d22a7b638156c1369429c9c76b07', '::1', 1586094952, 3, 1, 1, '2020-03-21'),
('b00001', '李天冬', '7d272edb936b146e6aba44c23b381891', '::1', 1589627599, 5, 1, 2, '2020-03-22'),
('b00002', '李芳', '8f8bed8008a95001fdec421d8e2cbef3', '::1', 1588902758, 4, 1, 2, '2020-03-22'),
('b00003', '方强', '7bf7d38db91a6dbbc5434d7cafb381e8', '::1', 1589627275, 7, 1, 2, '2020-04-15'),
('c00001', '王强林', 'bcfa3cca71e9ff0a586e5d909f2b2d7d', '::1', 1586932013, 1, 1, 3, '2020-04-15'),
('c00002', '方强明', '8d977141b15c31c1e1448b38755fdef8', '192.168.124.7', 1589645350, 1, 1, 3, '2020-05-16'),
('F00001', '张斌', 'ed2b1f468c5f915f3f1cf75d7068baae', '192.168.124.7', 1589531996, 4, 1, 14, '2020-03-19'),
('F00002', '刘强', 'ed2b1f468c5f915f3f1cf75d7068baae', NULL, NULL, 0, 1, 14, '2020-03-19'),
('f00003', '孙强', 'ed2b1f468c5f915f3f1cf75d7068baae', '::1', 1589641307, 29, 1, 14, '2020-03-22'),
('g00001', '称松', '6b93b53f4b35d0a9e0aa5d7c94746c94', '::1', 1588902657, 12, 1, 15, '2020-04-08'),
('m00001', '何建华', '7db3d96b0f76480d94a7ded5f234fb96', '::1', 1589627216, 48, 1, 12, '2020-03-22'),
('p00001', '刘星', '37091b211bff8b5ee8dab03311219ea7', '::1', 1589592542, 12, 1, 13, '2020-04-14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_dep`
--
ALTER TABLE `table_dep`
  ADD PRIMARY KEY (`dep_id`);

--
-- Indexes for table `table_medicine`
--
ALTER TABLE `table_medicine`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indexes for table `table_notice`
--
ALTER TABLE `table_notice`
  ADD PRIMARY KEY (`patient_id`,`register_time`),
  ADD KEY `table_notice_table_staffs_staff_id_fk` (`doctor_id`),
  ADD KEY `table_notice_table_dep_dep_id_fk` (`dep_id`);

--
-- Indexes for table `table_patients`
--
ALTER TABLE `table_patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `table_patients_patient_identy_uindex` (`patient_identity`),
  ADD KEY `table_patients_input_time_index` (`input_time`);

--
-- Indexes for table `table_payment`
--
ALTER TABLE `table_payment`
  ADD PRIMARY KEY (`patient_id`,`doctor_id`,`creat_time`),
  ADD KEY `table_payment_table_staffs_staff_id_fk` (`doctor_id`);

--
-- Indexes for table `table_prescription`
--
ALTER TABLE `table_prescription`
  ADD PRIMARY KEY (`doctor_id`,`patient_id`,`creat_time`,`medicine_id`),
  ADD KEY `table_prescription_table_medicine_medicine_id_fk` (`medicine_id`),
  ADD KEY `table_prescription_table_patients_patient_id_fk` (`patient_id`);

--
-- Indexes for table `table_register`
--
ALTER TABLE `table_register`
  ADD PRIMARY KEY (`patient_id`,`register_time`),
  ADD KEY `table_register_dep_id_register_time_index` (`dep_id`,`register_time`);

--
-- Indexes for table `table_staffs`
--
ALTER TABLE `table_staffs`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `table_staffs_table_dep_dep_id_fk` (`staff_dep`);

--
-- Indexes for table `table_treatment`
--
ALTER TABLE `table_treatment`
  ADD PRIMARY KEY (`patient_id`,`doctor_id`,`add_time`),
  ADD KEY `table_treatment_doctor_id_add_time_index` (`doctor_id`,`add_time`);

--
-- Indexes for table `table_user`
--
ALTER TABLE `table_user`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `table_user_table_dep_dep_id_fk` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_medicine`
--
ALTER TABLE `table_medicine`
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `table_patients`
--
ALTER TABLE `table_patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '病号', AUTO_INCREMENT=100;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `table_notice`
--
ALTER TABLE `table_notice`
  ADD CONSTRAINT `table_notice_table_dep_dep_id_fk` FOREIGN KEY (`dep_id`) REFERENCES `table_dep` (`dep_id`),
  ADD CONSTRAINT `table_notice_table_patients_patient_id_fk` FOREIGN KEY (`patient_id`) REFERENCES `table_patients` (`patient_id`),
  ADD CONSTRAINT `table_notice_table_staffs_staff_id_fk` FOREIGN KEY (`doctor_id`) REFERENCES `table_staffs` (`staff_id`);

--
-- Constraints for table `table_payment`
--
ALTER TABLE `table_payment`
  ADD CONSTRAINT `table_payment_table_patients_patient_id_fk` FOREIGN KEY (`patient_id`) REFERENCES `table_patients` (`patient_id`),
  ADD CONSTRAINT `table_payment_table_staffs_staff_id_fk` FOREIGN KEY (`doctor_id`) REFERENCES `table_staffs` (`staff_id`);

--
-- Constraints for table `table_prescription`
--
ALTER TABLE `table_prescription`
  ADD CONSTRAINT `table_prescription_table_medicine_medicine_id_fk` FOREIGN KEY (`medicine_id`) REFERENCES `table_medicine` (`medicine_id`),
  ADD CONSTRAINT `table_prescription_table_patients_patient_id_fk` FOREIGN KEY (`patient_id`) REFERENCES `table_patients` (`patient_id`),
  ADD CONSTRAINT `table_prescription_table_staffs_staff_id_fk` FOREIGN KEY (`doctor_id`) REFERENCES `table_staffs` (`staff_id`);

--
-- Constraints for table `table_register`
--
ALTER TABLE `table_register`
  ADD CONSTRAINT `table_register_table_dep_dep_id_fk` FOREIGN KEY (`dep_id`) REFERENCES `table_dep` (`dep_id`),
  ADD CONSTRAINT `table_register_table_patients_patient_id_fk` FOREIGN KEY (`patient_id`) REFERENCES `table_patients` (`patient_id`);

--
-- Constraints for table `table_staffs`
--
ALTER TABLE `table_staffs`
  ADD CONSTRAINT `table_staffs_table_dep_dep_id_fk` FOREIGN KEY (`staff_dep`) REFERENCES `table_dep` (`dep_id`);

--
-- Constraints for table `table_treatment`
--
ALTER TABLE `table_treatment`
  ADD CONSTRAINT `table_treatment_table_patients_patient_id_fk` FOREIGN KEY (`patient_id`) REFERENCES `table_patients` (`patient_id`),
  ADD CONSTRAINT `table_treatment_table_staffs_staff_id_fk` FOREIGN KEY (`doctor_id`) REFERENCES `table_staffs` (`staff_id`);

--
-- Constraints for table `table_user`
--
ALTER TABLE `table_user`
  ADD CONSTRAINT `table_user_table_dep_dep_id_fk` FOREIGN KEY (`role`) REFERENCES `table_dep` (`dep_id`),
  ADD CONSTRAINT `table_user_table_staffs_staff_id_fk` FOREIGN KEY (`staff_id`) REFERENCES `table_staffs` (`staff_id`);
