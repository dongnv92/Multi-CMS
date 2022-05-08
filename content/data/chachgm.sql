-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th1 11, 2022 lúc 08:46 AM
-- Phiên bản máy phục vụ: 10.3.32-MariaDB-log-cll-lve
-- Phiên bản PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `tanphichachcf_checkscam`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quannguyen_caidat`
--

CREATE TABLE `quannguyen_caidat` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `chatfacebook` text NOT NULL,
  `facebook` text NOT NULL,
  `thongbao` text NOT NULL,
  `sdtad` int(11) NOT NULL,
  `iconweb` text NOT NULL,
  `hopqua` int(11) NOT NULL,
  `tenad` text NOT NULL,
  `logo` text NOT NULL,
  `keynap` varchar(100) NOT NULL,
  `idnap` int(11) NOT NULL,
  `tkwhm` text NOT NULL,
  `mkwhm` text NOT NULL,
  `ipwhm` text NOT NULL,
  `autologincp` text NOT NULL,
  `ns1` text NOT NULL,
  `ns2` text NOT NULL,
  `noidungnaptienauto` text NOT NULL,
  `sodienthoainaptienauto` text NOT NULL,
  `linkanhmaqrmomo` text NOT NULL,
  `tokenmomo` text NOT NULL,
  `passmomo` text NOT NULL,
  `partner_id` text NOT NULL,
  `partner_key` text NOT NULL,
  `cknapthe` int(11) NOT NULL,
  `tongtiennap` int(11) NOT NULL,
  `tktsr` text NOT NULL,
  `mktsr` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quannguyen_codedamua`
--

CREATE TABLE `quannguyen_codedamua` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loaicode` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `linkdow` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `nguoimua` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `nguoiban` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quannguyen_cpanel`
--

CREATE TABLE `quannguyen_cpanel` (
  `id` int(11) NOT NULL,
  `nguoimua` text COLLATE utf8_unicode_ci NOT NULL,
  `goi` text COLLATE utf8_unicode_ci NOT NULL,
  `tenmien` text COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `timehethan` int(11) NOT NULL,
  `gia` int(11) NOT NULL,
  `gialandau` int(11) NOT NULL,
  `tinhtrang` int(11) NOT NULL,
  `tk` text COLLATE utf8_unicode_ci NOT NULL,
  `mk` text COLLATE utf8_unicode_ci NOT NULL,
  `ip` text COLLATE utf8_unicode_ci NOT NULL,
  `lidokhoa` text COLLATE utf8_unicode_ci NOT NULL,
  `tkwhm` text COLLATE utf8_unicode_ci NOT NULL,
  `mkwhm` text COLLATE utf8_unicode_ci NOT NULL,
  `ipwhm` text COLLATE utf8_unicode_ci NOT NULL,
  `loginautocp` text COLLATE utf8_unicode_ci NOT NULL,
  `ns1` text COLLATE utf8_unicode_ci NOT NULL,
  `ns2` text COLLATE utf8_unicode_ci NOT NULL,
  `goiddd` int(11) NOT NULL,
  `severh` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quannguyen_dscodeweb`
--

CREATE TABLE `quannguyen_dscodeweb` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `urlcodeweb` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `tieude` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `giatien` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `linktai` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `thongtin` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `trangthai` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `nguoimua` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` int(11) NOT NULL,
  `anh1` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quannguyen_goicpanel`
--

CREATE TABLE `quannguyen_goicpanel` (
  `id` bigint(20) NOT NULL,
  `goi` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `gia` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `disk` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `bangthong` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `urlgoihost` text COLLATE utf8_unicode_ci NOT NULL,
  `mienkhac` text COLLATE utf8_unicode_ci NOT NULL,
  `mienbidanh` text COLLATE utf8_unicode_ci NOT NULL,
  `goiddd` text COLLATE utf8_unicode_ci NOT NULL,
  `severh` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `quannguyen_goicpanel`
--

INSERT INTO `quannguyen_goicpanel` (`id`, `goi`, `gia`, `disk`, `bangthong`, `urlgoihost`, `mienkhac`, `mienbidanh`, `goiddd`, `severh`) VALUES
(6, 'DV1', '5000', '230', 'on', 'dv1', 'on', 'on', '1', 'VN'),
(7, 'DV2', '7000', '370', 'on', 'dv2', 'on', 'on', '2', 'VN'),
(8, 'DV3', '11000', '600', 'on', 'dv3', 'on', 'on', '3', 'VN'),
(9, 'DV4', '17000', '900', 'on', 'dv4', 'on', 'on', '4', 'VN'),
(10, 'DV5', '25000', '1400', 'on', 'dv5', 'on', 'on', '5', 'VN'),
(11, 'DV6', '31000', '2000', 'on', 'dv6', 'on', 'on', '6', 'VN'),
(12, 'DV7', '36000', '2600', 'on', 'dv7', 'on', 'on', '7', 'VN'),
(13, 'DV8', '43000', '3200', 'on', 'dv8', 'on', 'on', '8', 'VN'),
(14, 'DV8', '60000', '5000', 'on', 'dv9', 'on', 'on', '9', 'VN'),
(15, 'SG1', '2000', '200', 'on', 'sg1', 'on', 'on', 'on', 'SG'),
(16, 'SG2', '4000', '400', 'on', 'sg2', 'on', 'on', 'on', 'SG'),
(17, 'SG3', '6000', '600', 'on', 'sg3', 'on', 'on', 'on', 'SG'),
(18, 'SG4', '8000', '800', 'on', 'sg4', 'on', 'on', 'on', 'SG'),
(19, 'SG5', '10000', '1000', 'on', 'sg5', 'on', 'on', 'on', 'SG'),
(20, 'SG6', '12000', '1200', 'on', 'sg6', 'on', 'on', 'on', 'SG');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quannguyen_goihostdirectadmin`
--

CREATE TABLE `quannguyen_goihostdirectadmin` (
  `id` bigint(20) NOT NULL,
  `goi` varchar(32) NOT NULL,
  `gia` int(11) NOT NULL,
  `disk` varchar(32) DEFAULT NULL,
  `bangthong` text NOT NULL,
  `mien` varchar(32) NOT NULL,
  `inode` int(11) NOT NULL DEFAULT 50,
  `tinhtrang` varchar(100) DEFAULT NULL,
  `urlgoihost` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quannguyen_hostdirectadmin`
--

CREATE TABLE `quannguyen_hostdirectadmin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nguoimua` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `goi` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tenmien` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` int(20) DEFAULT 0,
  `timehethan` int(20) DEFAULT 0,
  `gia` int(11) NOT NULL DEFAULT 0,
  `tinhtrang` int(1) NOT NULL DEFAULT 0,
  `tk` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mk` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quannguyen_napatm`
--

CREATE TABLE `quannguyen_napatm` (
  `ID` bigint(20) NOT NULL,
  `noidungnap` varchar(900) NOT NULL,
  `sotien` int(11) NOT NULL,
  `seri` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `loaithe` varchar(32) NOT NULL,
  `time` varchar(32) NOT NULL,
  `noidung` text NOT NULL,
  `tinhtrang` int(11) NOT NULL,
  `thucnhan` int(11) NOT NULL,
  `cuphap` text NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `quannguyen_napatm`
--

INSERT INTO `quannguyen_napatm` (`ID`, `noidungnap`, `sotien`, `seri`, `code`, `loaithe`, `time`, `noidung`, `tinhtrang`, `thucnhan`, `cuphap`, `uid`) VALUES
(1, 'Dichvudark', 500, 'Nạp từ Momo', '18576748497', 'MOMO', '1638115324', 'Nạp momo', 1, 0, 'Dichvudark', 0),
(2, 'Dichvudark', 500, 'Nạp từ Momo', '18764084977', 'MOMO', '1638115607', 'Nạp momo', 1, 0, 'Dichvudark', 0),
(4, 'Naptien', 100, 'Nạp từ Momo', '18773638071', 'MOMO', '1638167162', 'Nạp momo', 1, 0, 'Naptien', 0),
(5, 'dichvudark', 1000, 'Nạp từ Momo', '18818760467', 'MOMO', '1638354422', 'Nạp momo', 1, 0, 'dichvudark', 0),
(6, 'Ok', 2000, 'Nạp từ Momo', '18868732506', 'MOMO', '1638545522', 'Nạp momo', 1, 0, 'Ok', 0),
(7, 'minhtri', 1000, 'Nạp từ Momo', '18888503242', 'MOMO', '1638621843', 'Nạp momo', 1, 0, 'minhtri', 0),
(8, 'Minhtri', 1000, 'Nạp từ Momo', '18888524693', 'MOMO', '1638622503', 'Nạp momo', 1, 0, 'Minhtri', 0),
(9, 'blackcode407', 3000, 'Nạp từ Momo', '18906163905', 'MOMO', '1638715322', 'Nạp momo', 1, 0, 'blackcode407', 0),
(10, 'dichvudark', 100, 'Nạp từ Momo', '18908880094', 'MOMO', '1638719587', 'Nạp momo', 1, 0, 'dichvudark', 0),
(11, 'tiendz', 1000, 'Nạp từ Momo', '18946559703', 'MOMO', '1638884883', 'Nạp momo', 1, 0, 'tiendz', 0),
(13, '1', 11, '1', '1', '1', '1', '11', 1, 1, '1', 0),
(18, '1', 18200, 'Nạp từ thesieure', 'T61B05F76558BB', 'THESIEURE', '1638948928', 'Nạp thesieure', 1, 0, '1', 1),
(20, '1', 25700, 'Nạp từ thesieure', 'T61B0664C5F161', 'THESIEURE', '1638950514', 'Nạp thesieure', 1, 0, '1', 1),
(24, '1', 25300, 'Nạp từ thesieure', 'T61B06B014760B', 'THESIEURE', '1638951759', 'Nạp thesieure', 1, 0, '1', 1),
(25, 'tienlovelinh', 1000, 'Nạp từ Momo', '18964107475', 'MOMO', '1638968581', 'Nạp momo', 1, 0, 'tienlovelinh', 0),
(26, 'tienlovelinh', 2000, 'Nạp từ Momo', '18965889782', 'MOMO', '1638970020', 'Nạp momo', 1, 0, 'tienlovelinh', 0),
(27, 'blackcode407', 1000, 'Nạp từ Momo', '18966687647', 'MOMO', '1638973921', 'Nạp momo', 1, 0, 'blackcode407', 0),
(33, 'blackcode407', 100, 'Nạp từ Momo', '18967230865', 'MOMO', '1638976005', 'Nạp momo', 1, 0, 'blackcode407', 0),
(35, 'blackcode407', 100, 'Nạp từ Momo', '18967121318', 'MOMO', '1638976152', 'Nạp momo', 1, 0, 'blackcode407', 0),
(38, 'dichvudark', 100, 'Nạp từ Momo', '18967653114', 'MOMO', '1638978096', 'Nạp momo', 1, 0, 'dichvudark', 0),
(43, 'dichvudark', 100, 'Nạp từ Momo', '18976620274', 'MOMO', '1639027323', 'Nạp momo', 1, 0, 'dichvudark', 0),
(44, 'dichvudark', 100, 'Nạp từ Momo', '18976620274', 'MOMO', '1639027326', 'Nạp momo', 1, 0, 'dichvudark', 0),
(45, 'trithin', 5000, 'Nạp từ Momo', '18981986957', 'MOMO', '1639045321', 'Nạp momo', 1, 0, 'trithin', 0),
(46, 'blackcode407', 500, 'Nạp từ Momo', '18996065389', 'MOMO', '1639108443', 'Nạp momo', 1, 0, 'blackcode407', 0),
(47, 'VCL', 2000, 'Nạp từ Momo', '19002187603', 'MOMO', '1639125663', 'Nạp momo', 1, 0, 'VCL', 0),
(48, 'Nguyen', 1000, 'Nạp từ Momo', '19009737569', 'MOMO', '1639143123', 'Nạp momo', 1, 0, 'Nguyen', 0),
(49, 'Nguyen', 2000, 'Nạp từ Momo', '19010167755', 'MOMO', '1639143903', 'Nạp momo', 1, 0, 'Nguyen', 0),
(50, 'Nguyen', 2000, 'Nạp từ Momo', '19010476364', 'MOMO', '1639144743', 'Nạp momo', 1, 0, 'Nguyen', 0),
(51, 'LENHAT03', 6500, 'Nạp từ Momo', '19014011900', 'MOMO', '1639153503', 'Nạp momo', 1, 0, 'LENHAT03', 0),
(52, '1', 25100, 'Nạp từ thesieure', 'T61B44C33EBBC2', 'THESIEURE', '1639206309', 'Nạp thesieure', 1, 0, '1', 1),
(53, '1', 24700, 'Nạp từ thesieure', 'T61B44FB11C9FE', 'THESIEURE', '1639206975', 'Nạp thesieure', 1, 0, '1', 1),
(54, 'blackcode407', 10027, 'Nạp từ Momo', '19058692316', 'MOMO', '1639304043', 'Nạp momo', 1, 0, 'blackcode407', 0),
(55, 'truong190607', 2000, 'Nạp từ Momo', '19059119067', 'MOMO', '1639304989', 'Nạp momo', 1, 0, 'truong190607', 0),
(56, 'truong190607', 1000, 'Nạp từ Momo', '19058953939', 'MOMO', '1639305303', 'Nạp momo', 1, 0, 'truong190607', 0),
(57, 'blackcode407', 10000, 'Nạp từ Momo', '19060886174', 'MOMO', '1639311003', 'Nạp momo', 1, 0, 'blackcode407', 0),
(58, 'ok', 150000, 'Nạp từ Momo', '19069934412', 'MOMO', '1639352103', 'Nạp momo', 1, 0, 'ok', 0),
(59, 'VCL', 9000, 'Nạp từ Momo', '19082425200', 'MOMO', '1639388164', 'Nạp momo', 1, 0, 'VCL', 0),
(60, 'VCL', 2000, 'Nạp từ Momo', '19089626402', 'MOMO', '1639405683', 'Nạp momo', 1, 0, 'VCL', 0),
(61, 'h1b11k7', 5000, 'Nạp từ Momo', '19148756442', 'MOMO', '1639636923', 'Nạp momo', 1, 0, 'h1b11k7', 0),
(62, 'shopapann', 11000, 'Nạp từ Momo', '19155752828', 'MOMO', '1639658463', 'Nạp momo', 1, 0, 'shopapann', 0),
(63, 'banklua', 5000, 'Nạp từ Momo', '19192112905', 'MOMO', '1639805882', 'Nạp momo', 1, 0, 'banklua', 0),
(64, 'LENHAT03', 4000, 'Nạp từ Momo', '19192852361', 'MOMO', '1639808403', 'Nạp momo', 1, 0, 'LENHAT03', 0),
(65, 'LENHAT03', 2000, 'Nạp từ Momo', '19192727162', 'MOMO', '1639808524', 'Nạp momo', 1, 0, 'LENHAT03', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quannguyen_napthe`
--

CREATE TABLE `quannguyen_napthe` (
  `ID` bigint(20) NOT NULL,
  `uid` varchar(32) NOT NULL,
  `sotien` int(11) NOT NULL,
  `seri` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `loaithe` varchar(32) NOT NULL,
  `time` varchar(32) NOT NULL,
  `noidung` text NOT NULL,
  `tinhtrang` int(11) NOT NULL,
  `thucnhan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `quannguyen_napthe`
--

INSERT INTO `quannguyen_napthe` (`ID`, `uid`, `sotien`, `seri`, `code`, `loaithe`, `time`, `noidung`, `tinhtrang`, `thucnhan`) VALUES
(83, '1', 10000, '57476467356', '5735785356456', 'VIETTEL', '1638196249', 'b469bfd9d2a32cf0650eb5e6d15dac84 nạp thẻ  ', 2, 0),
(84, '1', 10000, '57357545735', '8546434567534', 'VIETTEL', '1638196585', 'c1d28814608b937778412e32e2760d1e nạp thẻ  ', 2, 0),
(85, '1', 10000, '75855475846', '6845783465473', 'VIETTEL', '1638344939', 'd257069d3f0e3647ba5d07924ca81602 nạp thẻ  ', 2, 0),
(86, '1', 10000, '57345823543', '7634235734325', 'VIETTEL', '1638442605', 'ecfb84a59b80f28b8552efa3b96ea94c nạp thẻ  ', 2, 0),
(87, '1', 10000, '65346845345', '7534689534535', 'VIETTEL', '1638442809', '4fd929c321afd0854ee84855dfa88daf nạp thẻ  ', 2, 0),
(88, '1', 10000, '57346724356', '4362356734246', 'VIETTEL', '1638445208', 'ac51d3653e10ea4d0efca06c6da67872 nạp thẻ  ', 2, 0),
(89, '1', 10000, '83746583743', '8473625185647', 'VIETTEL', '1638445457', '2706103a6d163e8e7260119c8244c034 nạp thẻ  ', 2, 0),
(90, '1', 10000, '83759285732', '8294738274628', 'VIETTEL', '1638445791', '52e90f0771ae1664924ae116a488f496 nạp thẻ  ', 2, 0),
(91, '1', 10000, '48736485938', '9284756475647', 'VIETTEL', '1638447563', '3568ff9227c2ea82aaa416c7c006fe16 nạp thẻ  ', 2, 0),
(92, '1', 10000, '45637437534', '5673464363687', 'VIETTEL', '1638447900', '2aa90c41d8f0a2253d546a2d04a2f7d1 nạp thẻ  ', 2, 0),
(93, '1', 10000, '83759684637', '3456745323523', 'VIETTEL', '1638448242', '8191d7c43de3d8f94aeeaa43d081b2a6 nạp thẻ  ', 2, 0),
(94, '1', 10000, '87687654687', '7898767876767', 'VIETTEL', '1638448581', '4f14666d1aabf9fb552496e9dd48ce23 nạp thẻ  ', 2, 0),
(95, '4', 10000, '76567567656', '3557543579765', 'VIETTEL', '1638452717', '03accd35ac3eeae16cdc5f980473feab nạp thẻ  ', 2, 0),
(96, '1', 10000, '938576938534', '3857293857384', 'VIETTEL', '1638506044', 'c67c06158a1975f4d713231f3b8cf9f2 nạp thẻ  ', 2, 0),
(97, '1', 10000, '83958736485', '8275637465372', 'VIETTEL', '1638603935', '586949e603a9a8b040a56061d4d38da9 nạp thẻ  ', 2, 0),
(98, '1', 10000, '849586748395', '8395736285749', 'VIETTEL', '1638604759', 'ae59a4b66d152be2d5f6b65880c68248 nạp thẻ  ', 2, 0),
(99, '1', 10000, '84756364756', '7365837463726', 'VIETTEL', '1638604866', 'da28671da8dc9e9b73e54a90c40ae7a5 nạp thẻ  ', 2, 0),
(100, '1', 10000, '74859385764', '7486938473627', 'VIETTEL', '1638604994', '0dc5a7d7ba4cbc98380ca64252669ee0 nạp thẻ  ', 2, 0),
(101, '56', 200000, '101010192828181', '999998989202818', 'VIETTEL', '1638968402', 'b093d4eb9e26eb932f66cab3416d6d0e nạp thẻ  ', 2, 0),
(102, '56', 500000, '101010192828189', '999998989202811', 'VIETTEL', '1638978751', 'b05914c0487786893554103bbac8a200 nạp thẻ  ', 2, 0),
(103, '24', 20000, '1000965742211', '722627171612626', 'VIETTEL', '1639113980', '5406cc4323a63aafb16adfd3cdabfbad nạp thẻ  ', 2, 0),
(104, '64', 10000, '59000018854959', '81261434830995', 'VINAPHONE', '1639140156', 'f49aacd12e7482ed149745de685b63d2 nạp thẻ  ', 1, 8200);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quannguyen_rutmomo`
--

CREATE TABLE `quannguyen_rutmomo` (
  `id` int(11) NOT NULL,
  `tienrut` int(11) NOT NULL,
  `thanhtien` int(11) NOT NULL,
  `sdt` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `noidung` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `nguoimua` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `quannguyen_rutmomo`
--

INSERT INTO `quannguyen_rutmomo` (`id`, `tienrut`, `thanhtien`, `sdt`, `noidung`, `time`, `nguoimua`) VALUES
(8, 100, 100, '0987469359', 'ruttien 1', 1638166723, 1),
(7, 100, 100, '0979036923', 'ruttien 4', 1638158866, 4),
(6, 100, 10100, '0399056507', 'ruttien 1', 1638113716, 1),
(4, 100, 10100, '0399056507', 'ruttien1', 1638110438, 1),
(5, 100, 10100, '0399056507', 'ruttien1', 1638112686, 1),
(9, 100, 1100, '0987469359', 'ruttien 51', 1638336897, 1),
(10, 1000, 2000, '0987469359', 'ruttien 400498', 1638337591, 1),
(11, 1000, 2000, '0987469359', 'ruttien 383797', 1638353699, 1),
(12, 1000, 2000, '0987469359', 'ruttien 163549', 1638362454, 1),
(13, 1000, 2000, '0987469359', 'ruttien 637988', 1638419490, 1),
(14, 59000, 60000, '0336391850', 'ruttien 163913', 1638969440, 56),
(15, 40000, 41000, '0336391850', 'ruttien 310917', 1638969723, 56),
(16, 40000, 41000, '0336391850', 'ruttien 359177', 1638969858, 56),
(17, 40000, 41000, '0336391850', 'ruttien 263838', 1638969872, 56),
(18, 99000, 100000, '0336391850', 'ruttien 631840', 1638969890, 56),
(19, 100000, 101000, '0336391850', 'ruttien 367378', 1638970090, 56),
(20, 20000, 21000, '0336391850', 'ruttien 194626', 1638970206, 56),
(21, 39000, 40000, '0336391850', 'ruttien 378239', 1638970242, 56);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quannguyen_setting`
--

CREATE TABLE `quannguyen_setting` (
  `id` int(11) NOT NULL,
  `key` text NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `quannguyen_setting`
--

INSERT INTO `quannguyen_setting` (`id`, `key`, `value`) VALUES
(1, 'tkwhm', '123'),
(2, 'mkwhm', ''),
(3, 'ipwhm', ''),
(4, 'tkwhm2', 'tneldailysite'),
(5, 'mkwhm2', 'Az9Daily384787739'),
(6, 'ipwhm2', '194.233.81.124'),
(7, 'ns1SG', 'ns1sg.resellercpan.club'),
(8, 'ns2SG', 'ns2sg.resellercpan.club'),
(9, 'loginSG', 'sg112.resellercpan.club:2083'),
(10, 'trangthaisg', '1'),
(11, 'trangthaivn', '2'),
(12, 'loginvn', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quannguyen_user`
--

CREATE TABLE `quannguyen_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `matkhau` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `taikhoan` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vongquay` varchar(100) COLLATE utf8_unicode_ci DEFAULT '0',
  `nhanqua` varchar(100) COLLATE utf8_unicode_ci DEFAULT '0',
  `vnd` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cam` int(11) NOT NULL DEFAULT 0,
  `code` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` bigint(20) DEFAULT NULL,
  `callback` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `callback2` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `cuphap` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cuphap2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hsd` bigint(20) NOT NULL DEFAULT 0,
  `api_key` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `api_key2` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `quenmk` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expmk` bigint(20) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `quannguyen_user`
--

INSERT INTO `quannguyen_user` (`id`, `matkhau`, `taikhoan`, `email`, `admin`, `vongquay`, `nhanqua`, `vnd`, `cam`, `code`, `ip`, `time`, `callback`, `callback2`, `cuphap`, `cuphap2`, `hsd`, `api_key`, `api_key2`, `quenmk`, `expmk`) VALUES
(104, 'e3b5cece651493c081b584125d0f05ef', 'Lương tấn phi', 'Chachgaming8@gmail.com', '1', '0', '10000000', '100000000', 0, NULL, '113.185.40.28', 1641861734, NULL, NULL, '', NULL, 1641865334, '4c268ffccd078dcb297c673e672209fb', 'e76d721ba4c471fc9cd3c7015b622aed', NULL, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quannguyen_user2`
--

CREATE TABLE `quannguyen_user2` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `matkhau` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `taikhoan` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vongquay` varchar(100) COLLATE utf8_unicode_ci DEFAULT '0',
  `nhanqua` varchar(100) COLLATE utf8_unicode_ci DEFAULT '0',
  `vnd` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cam` int(11) NOT NULL DEFAULT 0,
  `code` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` bigint(20) DEFAULT NULL,
  `callback` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `cuphap` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hsd` bigint(20) NOT NULL DEFAULT 0,
  `api_key` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `quenmk` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expmk` bigint(20) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `quannguyen_user2`
--

INSERT INTO `quannguyen_user2` (`id`, `matkhau`, `taikhoan`, `email`, `admin`, `vongquay`, `nhanqua`, `vnd`, `cam`, `code`, `ip`, `time`, `callback`, `cuphap`, `hsd`, `api_key`, `quenmk`, `expmk`) VALUES
(1, '100680', 'quanngueyn', 'anhyasoudz@gmail.com', '1', '0', '0', '108000', 0, NULL, '2402:800:61e2:f2e1:a58e:fcb9:91f', 1637855897, 'https://dichvudark.com/callback.php', 'dichvudark', 1636792063, '45043d703a6b062f4146aadffa0212e4', NULL, 0),
(2, '100680', 'Nguyễn Minh Quân', 'thannameqb@gmail.com', '0', '0', '0', '800', 0, NULL, '2402:800:61e2:f2e1:2cca:8d1e:fff', 1637395506, 'websitecuatoi/callback.php', 'naptiendv', 1637399106, '085a686e67a80200f185dda715418c36', NULL, 0),
(3, '12345678', 'Nguyễn Xuân Trường', 'nt789477@gmail.com', '0', '0', '0', '0', 0, NULL, '113.171.94.115', 1638014135, NULL, 'truong190607', 1638017735, '3f6348336577649ce4eee5997908a299', NULL, 0),
(4, 'Huychuvangia', 'Huychuvangia', 'anhchuleha@gmail.com', '0', '0', '0', '1', 0, NULL, '115.72.32.8', 1638016706, 'https://dichvudark.com/test.php', 'GTV', 1638020306, '9062bf6b680139521e71c39c60f80761', NULL, 0),
(5, '123456a', 'konkac123', 'konkac123@gmail.com', '0', '0', '0', '0', 0, NULL, '113.189.28.216', 1638016980, NULL, 'konkac', 1638020580, '3c44a32ff0bf736818156b5cf05cc3a8', NULL, 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `quannguyen_caidat`
--
ALTER TABLE `quannguyen_caidat`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `quannguyen_codedamua`
--
ALTER TABLE `quannguyen_codedamua`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `quannguyen_cpanel`
--
ALTER TABLE `quannguyen_cpanel`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `quannguyen_dscodeweb`
--
ALTER TABLE `quannguyen_dscodeweb`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `quannguyen_goicpanel`
--
ALTER TABLE `quannguyen_goicpanel`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `quannguyen_goihostdirectadmin`
--
ALTER TABLE `quannguyen_goihostdirectadmin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `quannguyen_hostdirectadmin`
--
ALTER TABLE `quannguyen_hostdirectadmin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `quannguyen_napatm`
--
ALTER TABLE `quannguyen_napatm`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `quannguyen_napthe`
--
ALTER TABLE `quannguyen_napthe`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `quannguyen_rutmomo`
--
ALTER TABLE `quannguyen_rutmomo`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `quannguyen_setting`
--
ALTER TABLE `quannguyen_setting`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `quannguyen_user`
--
ALTER TABLE `quannguyen_user`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `quannguyen_user2`
--
ALTER TABLE `quannguyen_user2`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `quannguyen_caidat`
--
ALTER TABLE `quannguyen_caidat`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `quannguyen_codedamua`
--
ALTER TABLE `quannguyen_codedamua`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `quannguyen_cpanel`
--
ALTER TABLE `quannguyen_cpanel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT cho bảng `quannguyen_dscodeweb`
--
ALTER TABLE `quannguyen_dscodeweb`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `quannguyen_goicpanel`
--
ALTER TABLE `quannguyen_goicpanel`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `quannguyen_goihostdirectadmin`
--
ALTER TABLE `quannguyen_goihostdirectadmin`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `quannguyen_hostdirectadmin`
--
ALTER TABLE `quannguyen_hostdirectadmin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `quannguyen_napatm`
--
ALTER TABLE `quannguyen_napatm`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT cho bảng `quannguyen_napthe`
--
ALTER TABLE `quannguyen_napthe`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT cho bảng `quannguyen_rutmomo`
--
ALTER TABLE `quannguyen_rutmomo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `quannguyen_setting`
--
ALTER TABLE `quannguyen_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `quannguyen_user`
--
ALTER TABLE `quannguyen_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT cho bảng `quannguyen_user2`
--
ALTER TABLE `quannguyen_user2`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;