-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th4 18, 2022 lúc 12:48 AM
-- Phiên bản máy phục vụ: 10.3.34-MariaDB-log-cll-lve
-- Phiên bản PHP: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `topcongt_sms`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_contacts`
--

CREATE TABLE `dong_contacts` (
  `contacts_id` int(11) NOT NULL,
  `contacts_phone` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `contacts_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `contacts_group` int(11) NOT NULL DEFAULT 0,
  `contacts_user` int(11) NOT NULL,
  `contacts_gender` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `contacts_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dong_contacts`
--

INSERT INTO `dong_contacts` (`contacts_id`, `contacts_phone`, `contacts_name`, `contacts_group`, `contacts_user`, `contacts_gender`, `contacts_create`) VALUES
(1, '0966624292', 'Đông', 0, 5, 'male', '2019-11-04 11:11:40'),
(3, '0384089803', 'Vk', 33, 1, 'female', '2019-11-09 11:04:27'),
(4, '0979908789', 'Viên', 33, 1, 'male', '2019-11-09 11:25:49'),
(5, '0988888889', 'Đại Gia', 33, 1, 'female', '2019-11-09 11:31:05'),
(6, '0966624292', 'Đông', 33, 1, 'male', '2020-06-04 20:02:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_device`
--

CREATE TABLE `dong_device` (
  `device_id` int(11) NOT NULL,
  `device_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `device_imei` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `device_token` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `device_phone_number` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `device_user` int(11) NOT NULL,
  `device_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1: Hoạt động 0: Không Hoạt Động',
  `device_network` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Các nhà mạng nhắn tin',
  `device_last_update` datetime DEFAULT NULL,
  `device_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `dong_device`
--

INSERT INTO `dong_device` (`device_id`, `device_name`, `device_imei`, `device_token`, `device_phone_number`, `device_user`, `device_status`, `device_network`, `device_last_update`, `device_time`) VALUES
(1, 'SIM800C', '862273048557193', 'MmJVb0ZVQVczUEhLVGl5T3pidkp4UT09', '0971686624', 1, 1, 'a:0:{}', '2021-03-09 15:57:03', '2019-10-25 15:45:01'),
(2, 'SIM800A', '868440032627019', 'WnE0Sk5NczFoTTN4WGpRTzRuMHQxdz09', '0971686625', 1, 0, '', '2019-12-18 17:30:39', '2019-12-16 10:28:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_metadata`
--

CREATE TABLE `dong_metadata` (
  `metadata_id` int(11) NOT NULL,
  `metadata_type` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `metadata_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `metadata_des` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `metadata_role` text COLLATE utf8_unicode_ci NOT NULL,
  `metadata_sub` int(11) NOT NULL,
  `metadata_user` int(11) NOT NULL,
  `metadata_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dong_metadata`
--

INSERT INTO `dong_metadata` (`metadata_id`, `metadata_type`, `metadata_name`, `metadata_des`, `metadata_role`, `metadata_sub`, `metadata_user`, `metadata_time`) VALUES
(2, 'user_role', 'Administraror', '', 'a:4:{s:4:\"user\";a:6:{s:12:\"user_manager\";s:1:\"1\";s:8:\"user_add\";s:1:\"1\";s:11:\"user_update\";s:1:\"1\";s:11:\"user_delete\";s:1:\"1\";s:17:\"user_view_profile\";s:1:\"1\";s:17:\"user_custom_price\";s:1:\"1\";}s:8:\"settings\";a:6:{s:13:\"settings_role\";s:1:\"1\";s:18:\"settings_user_role\";s:1:\"1\";s:20:\"settings_change_role\";s:1:\"1\";s:22:\"settings_phone_netwrok\";s:1:\"1\";s:23:\"settings_sms_prioritize\";s:1:\"1\";s:23:\"settings_payment_method\";s:1:\"1\";}s:6:\"device\";a:1:{s:14:\"device_manager\";s:1:\"1\";}s:8:\"controls\";a:4:{s:16:\"controls_payment\";s:1:\"1\";s:19:\"controls_add_notice\";s:1:\"1\";s:20:\"controls_sms_manager\";s:1:\"1\";s:23:\"controls_device_manager\";s:1:\"1\";}}', 0, 1, '2019-10-04 16:10:47'),
(6, 'role', 'user', 'Thành Viên, Khách Hàng, Nhân Viên Kinh Doanh ...', '', 0, 1, '2019-10-07 14:21:24'),
(8, 'role', 'user_manager', 'Quản Lý Thành Viên', '', 6, 1, '2019-10-07 14:25:50'),
(9, 'role', 'user_add', 'Thêm Mới Thành Viên', '', 6, 1, '2019-10-07 14:26:35'),
(11, 'user_role', 'Nhân Viên Kinh Doanh', '', 'a:2:{s:4:\"user\";a:4:{s:12:\"user_manager\";b:0;s:8:\"user_add\";s:1:\"0\";s:11:\"user_update\";b:0;s:11:\"user_delete\";b:0;}s:8:\"settings\";a:3:{s:13:\"settings_role\";b:0;s:18:\"settings_user_role\";b:0;s:20:\"settings_change_role\";s:1:\"0\";}}', 0, 1, '2019-10-07 16:08:56'),
(12, 'user_role', 'Khách Hàng', '', 'a:2:{s:4:\"user\";a:4:{s:12:\"user_manager\";b:0;s:8:\"user_add\";s:1:\"0\";s:11:\"user_update\";b:0;s:11:\"user_delete\";b:0;}s:8:\"settings\";a:3:{s:13:\"settings_role\";b:0;s:18:\"settings_user_role\";b:0;s:20:\"settings_change_role\";s:1:\"0\";}}', 0, 1, '2019-10-11 09:56:38'),
(13, 'role', 'user_update', 'Cập Nhật Thành Viên', '', 6, 1, '2019-10-24 09:11:28'),
(14, 'role', 'user_delete', 'Xóa Thành Viên', '', 6, 1, '2019-10-24 09:11:48'),
(15, 'role', 'settings', 'Cài Đặt', '', 0, 1, '2019-10-24 10:25:49'),
(16, 'role', 'settings_role', 'Quản Lý Mã Phân Quyền', '', 15, 1, '2019-10-24 10:26:38'),
(17, 'role', 'settings_user_role', 'Quản Lý Vai Trò Thành Viên', '', 15, 1, '2019-10-24 10:27:16'),
(18, 'role', 'settings_change_role', 'Phân Quyền Vai Trò', '', 15, 1, '2019-10-24 11:42:25'),
(23, 'role', 'device', 'Quản Lý Thiết Bị', '', 0, 1, '2019-10-24 20:49:07'),
(24, 'role', 'device_manager', 'Quản Lý, Thêm, Sửa, Xóa Thiết Bị', '', 23, 1, '2019-10-24 20:50:22'),
(25, 'phone_network', 'Viettel', '150', '', 0, 1, '2019-10-25 17:17:18'),
(26, 'phone_network', 'Mobifone', '160', '', 0, 1, '2019-10-25 17:17:49'),
(27, 'phone_network', 'Vinaphone', '160', '', 0, 1, '2019-10-25 17:17:57'),
(28, 'phone_network', 'Gmobile', '180', '', 0, 1, '2019-10-25 17:18:09'),
(29, 'phone_network', 'Vietnamobile', '160', '', 0, 1, '2019-10-25 17:18:19'),
(30, 'role', 'user_view_profile', 'Xem trang cá nhân thành viên', '', 6, 1, '2019-10-25 21:17:52'),
(31, 'role', 'user_custom_price', 'Điều Chỉnh Giá Theo Thành Viên', '', 6, 1, '2019-10-26 10:07:55'),
(32, 'role', 'settings_phone_netwrok', 'Quản Lý Nhà Mạng Và Gói Cước', '', 15, 1, '2019-10-26 10:30:55'),
(33, 'contacts_group', 'Cấp 3', '', '', 0, 1, '2019-11-01 14:02:08'),
(34, 'contacts_group', 'Gia Đình', '', '', 0, 5, '2019-11-01 14:20:00'),
(35, 'role', 'settings_sms_prioritize', 'Quản lý tin nhắn ưu tiên', '', 15, 1, '2019-11-12 15:15:32'),
(36, 'sms_prioritize', 'otp', '', '', 0, 1, '2019-11-12 15:22:50'),
(37, 'sms_prioritize', 'cskh', '', '', 0, 1, '2019-11-12 15:23:35'),
(38, 'role', 'settings_payment_method', 'Quản lý phương thức thanh toán', '', 15, 1, '2019-11-13 11:10:53'),
(39, 'payment_method', 'MOMO', 'Số tài khoản MOMO 0966624292 (Nguyen Van Dong)', '', 0, 1, '2019-11-13 11:15:09'),
(40, 'payment_method', 'Chuyển Khoản', 'Ngân hàng: Vietcombank\nSố TK: 0491000020649\nChủ Tài Khoàn: Nguyễn Văn Đông\nChi Nhánh: Thăng Long, Hà Nội', '', 0, 1, '2019-11-13 11:16:35'),
(41, 'payment_method', 'Tiền Mặt', '', '', 0, 1, '2019-11-13 11:16:51'),
(42, 'sms_prioritize', 'qc', '', '', 0, 1, '2019-11-13 13:57:03'),
(43, 'role', 'controls', 'Các Module dành cho Quản Trị Viên', '', 0, 1, '2019-11-18 09:43:47'),
(44, 'role', 'controls_payment', 'Thêm Hóa Đơn', '', 43, 1, '2019-11-18 09:44:08'),
(45, 'payment_method', 'Hệ Thống', 'Trừ hoặc cộng tiền trên hệ thống', '', 0, 1, '2019-11-18 15:50:27'),
(46, 'role', 'controls_add_notice', 'Gửi thông báo đến thành viên', '', 43, 1, '2019-11-25 10:41:27'),
(47, 'role', 'controls_sms_manager', 'Quản lý SMS toàn hệ thống', '', 43, 1, '2019-12-09 15:46:33'),
(48, 'role', 'controls_device_manager', 'Quản lý thiết bị', '', 43, 1, '2019-12-12 11:00:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_notice`
--

CREATE TABLE `dong_notice` (
  `notice_id` int(11) NOT NULL,
  `notice_user` int(11) NOT NULL,
  `notice_content` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `notice_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `notice_item_id` int(11) NOT NULL,
  `notice_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `notice_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dong_notice`
--

INSERT INTO `dong_notice` (`notice_id`, `notice_user`, `notice_content`, `notice_type`, `notice_item_id`, `notice_status`, `notice_time`) VALUES
(2, 1, '+100000 vnđ được cộng vào tài khoản của bạn. Click để xem chi tiết', 'transaction', 10, 'UNREAD', '2019-11-22 15:17:18'),
(3, 1, '<p>Good Morning</p>', 'notice', 0, 'UNREAD', '2019-11-25 11:13:12'),
(4, 5, '<p>Good Morning</p>', 'notice', 0, 'UNREAD', '2019-11-25 11:13:12'),
(5, 6, '<p>Good Morning</p>', 'notice', 0, 'UNREAD', '2019-11-25 11:13:12'),
(6, 7, '<p>Good Morning</p>', 'notice', 0, 'UNREAD', '2019-11-25 11:13:12'),
(7, 1, 'Hello Đông', 'notice', 0, 'UNREAD', '2019-11-25 11:31:10'),
(8, 5, 'Hello Đông', 'notice', 0, 'UNREAD', '2019-11-25 11:31:10'),
(9, 6, 'Hello Đông', 'notice', 0, 'UNREAD', '2019-11-25 11:31:10'),
(10, 7, 'Hello Đông', 'notice', 0, 'UNREAD', '2019-11-25 11:31:10'),
(11, 1, 'Hello Nguyễn Đông', 'notice', 0, 'UNREAD', '2019-11-25 11:33:53'),
(12, 5, 'Hello Nguyễn Văn Đông', 'notice', 0, 'UNREAD', '2019-11-25 11:33:53'),
(13, 6, 'Hello Đỗ Văn Thăng', 'notice', 0, 'UNREAD', '2019-11-25 11:33:53'),
(14, 7, 'Hello Hùng', 'notice', 0, 'UNREAD', '2019-11-25 11:33:53'),
(15, 1, '+1000 vnđ được cộng vào tài khoản của bạn. Click để xem chi tiết', 'transaction', 11, 'UNREAD', '2019-11-27 10:22:32'),
(16, 1, 'Hello', 'notice', 0, 'UNREAD', '2020-06-04 14:55:11'),
(17, 5, 'Hello', 'notice', 0, 'UNREAD', '2020-06-04 14:55:11'),
(18, 6, 'Hello', 'notice', 0, 'UNREAD', '2020-06-04 14:55:11'),
(19, 7, 'Hello', 'notice', 0, 'UNREAD', '2020-06-04 14:55:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_receive`
--

CREATE TABLE `dong_receive` (
  `receive_id` int(11) NOT NULL,
  `receive_imei` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `receive_phone_send` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `receive_phone_receive` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `receive_content` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `receive_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `dong_receive`
--

INSERT INTO `dong_receive` (`receive_id`, `receive_imei`, `receive_phone_send`, `receive_phone_receive`, `receive_content`, `receive_time`) VALUES
(2, '862273048557193', '84966624292', '', 'Kakakakak', '2020-06-04 11:19:08'),
(3, '862273048557193', '84966624292', '0971686624', 'Success', '2020-06-04 11:20:52'),
(4, '862273048557193', '84966624292', '0971686624', 'An trua thoi', '2020-06-04 11:55:46'),
(5, '862273048557193', '84966624292', '0971686624', 'Hello', '2020-06-05 13:41:24'),
(6, '862273048557193', '84966624292', '0971686624', '004E0067007500791EC5006E002000760103006E0020011100F4006E0067', '2020-06-05 13:41:45'),
(7, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] DOI 1 DUOC 10: Co ngay 100.000d su dung goi noi mang chi voi 10.000d/7 ngay. Dang ky, soan DT10 gui 109, gia han sau 7 ngay. CT a', '2020-06-06 14:49:33'),
(8, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] Uu dai goi noi mang chi voi 30.000d/30 ngay co 300 phut goi noi mang. Dang ky, soan MP30 gui 109. CT ap dung cho TB nhan duoc tin', '2020-06-06 15:12:59'),
(9, '862273048557193', 'VIETTEL', '0971686624', '[TB] Thong tin thue bao cua Quy khach co the chua chinh xac hoac vi pham Nghi dinh 49/2017/ND-CP. De khong bi tam ngung dich vu 1 chieu, Quy kh', '2020-06-09 08:16:02'),
(10, '862273048557193', 'NAPTHE?VT', '0971686624', '[QC] TANG 20% GIA TRI TAT CA THE NAP trong ngay 10/06. KM su dung noi, ngoai mang va co han dung den het 25/06/2020. Chi tiet goi 197', '2020-06-09 11:04:21'),
(11, '862273048557193', 'VIETTEL', '0971686624', '[TB] Thong tin thue bao cua Quy khach co the chua chinh xac hoac vi pham Nghi dinh 49/2017/ND-CP. De khong bi tam ngung dich vu 1 chieu, Quy kh', '2020-06-10 08:47:15'),
(12, '862273048557193', 'VIETTEL', '0971686624', 'long mang CMND/The can cuoc den cua hang Viettel xac nhan/dang ky lai thong tin truoc ngay 23/06/2020. Chi tiet LH 198 (0d). Tran trong!', '2020-06-10 08:47:28'),
(13, '862273048557193', 'VIETTEL', '0971686624', '[TB] Thong tin thue bao cua Quy khach co the chua chinh xac hoac vi pham Nghi dinh 49/2017/ND-CP. De khong bi tam ngung dich vu 1 chieu, Quy kh', '2020-06-11 09:37:35'),
(14, '862273048557193', 'VIETTEL', '0971686624', 'Viettel kinh chuc Quy khach mot ngay sinh nhat ngap tran niem vui va hanh phuc ben gia dinh cung nguoi than. Tran trong cam on Quy kha', '2020-06-15 10:27:14'),
(15, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] KHUYEN MAI DAC BIET\nUu dai goi noi mang tu Viettel:\n1. FT3S: 3.000d/ngay duoc mien phi 10p/cuoc goi noi mang\n2. DT3: 3.000d/ngay', '2020-06-15 20:23:52'),
(16, '862273048557193', 'NAPTHE?VT', '0971686624', '[QC] TANG 20% GIA TRI TAT CA THE NAP trong ngay 20/06. KM su dung noi, ngoai mang va co han dung den het 05/07/2020. Chi tiet goi 197', '2020-06-19 10:54:46'),
(17, '862273048557193', 'NAPTHE?VT', '0971686624', '[QC] DUNG QUEN NAP THE HOM NAY (20/06). Tang 20% gia tri tat ca the nap. Tien KM su dung goi/nhan tin noi/ngoai mang den het 05/07/202', '2020-06-20 19:39:52'),
(18, '862273048557193', 'NAPTHE?VT', '0971686624', '0. Chi tiet goi 197 (0d). Tu choi QC, soan TC1 gui 199.', '2020-06-20 19:40:07'),
(19, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] KHUYEN MAI DAC BIET\nUu dai goi noi mang tu Viettel:\n1. FT3S: 3.000d/ngay duoc mien phi 10p/cuoc goi noi mang\n2. DT3: 3.000d/ngay', '2020-06-21 15:02:50'),
(20, '862273048557193', 'VIETTEL?KM', '0971686624', 'co 30.000d de goi noi mang\nDang ky, soan FT3S hoac DT3 gui 109.\nCT danh cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, s', '2020-06-21 15:03:03'),
(21, '862273048557193', 'VIETTEL?KM', '0971686624', 'oan TC2 gui 199.', '2020-06-21 15:03:34'),
(22, '862273048557193', 'BO?TTTT', '0971686624', 'Bo TTTT khuyen cao nguoi dan nang cao canh giac, khong chuyen tien hoac cung cap thong tin ca nhan cho nguoi la qua dien thoai. Neu co', '2020-06-24 10:45:13'),
(23, '862273048557193', 'BoCT-XTTM', '0971686624', 'Bo Cong Thuong phat dong Thang khuyen mai tap trung quoc gia 2020 tu ngay 01/7-31/7/2020, doanh nghiep se khuyen mai len den 100%. Chi', '2020-06-26 10:36:12'),
(24, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] LEN MANG THA GA, GOI DIEN THAT DA!\n1. Soan V50K gui 191: 50.000d/7 ngay co 7GB, mien phi 20p/cuoc goi noi mang\n2. Soan V30X gui 1', '2020-06-27 15:42:02'),
(25, '862273048557193', 'VIETTEL?KM', '0971686624', '91: chi 30.000d/7 ngay co 3.4GB (500MB/ngay), mien phi 10p/cuoc goi noi mang\nChi tiet bam goi *098# (muc Sieu uu dai Data)\nLH 198 (0d)', '2020-06-27 15:42:15'),
(26, '862273048557193', 'VIETTEL?KM', '0971686624', '. Tu choi QC, soan TC2 gui 199.', '2020-06-27 15:42:46'),
(27, '862273048557193', 'NAPTHE?VT', '0971686624', '[QC] TANG 20% GIA TRI TAT CA THE NAP trong ngay 30/06. KM su dung noi, ngoai mang va co han dung den het 15/07/2020. Chi tiet goi 197', '2020-06-29 10:38:53'),
(28, '862273048557193', 'NAPTHE?VT', '0971686624', '[QC] DUNG QUEN NAP THE HOM NAY (30/06). Tang 20% gia tri tat ca the nap. Tien KM su dung noi, ngoai mang den het 15/07/2020. Chi tiet', '2020-06-30 18:54:41'),
(29, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] Uu dai goi noi mang chi voi 30.000d/30 ngay co 300 phut goi noi mang. Dang ky, soan MP30 gui 109. CT ap dung cho TB nhan duoc tin', '2020-07-03 16:38:02'),
(30, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] LEN MANG THA GA, GOI DIEN THAT DA!\n1. Soan V50K gui 191: 50.000d/7 ngay co 7GB, mien phi 20p/cuoc goi noi mang\n2. Soan V30X gui 1', '2020-07-04 16:55:42'),
(31, '862273048557193', 'VIETTEL?KM', '0971686624', '. Tu choi QC, soan TC2 gui 199.', '2020-07-04 16:55:53'),
(32, '862273048557193', 'CUC TRE EM', '0971686624', 'Hay nhac tre em hang ngay ve nguy co duoi nuoc. Cho tre em hoc boi de phong tranh duoi nuoc!', '2020-07-04 20:34:52'),
(33, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] DOI 1 DUOC 10: Co ngay 30.000d de goi noi mang den 24h chi voi 3.000d/ngay. Dang ky, soan DT3 gui 109, gia han theo ngay. CT ap d', '2020-07-06 09:44:53'),
(34, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] Uu dai goi noi mang chi voi 30.000d/30 ngay co 300 phut goi noi mang. Dang ky, soan MP30 gui 109. CT ap dung cho TB nhan duoc tin', '2020-07-06 10:45:14'),
(35, '862273048557193', 'VIETTEL', '0971686624', 'Quy khach duoc cong them 2 diem Viettel   boi giao dich Tieu dung vien thong thang 6. Thoi han su dung diem den 31/07/2021. Hay truy c', '2020-07-07 20:17:31'),
(36, '862273048557193', 'VIETTEL', '0971686624', 'iet truy cap cong.viettel.vn hoac LH 198. Tran trong.', '2020-07-07 20:17:42'),
(37, '862273048557193', 'NAPTHE?VT', '0971686624', '[QC] TANG 20% GIA TRI TAT CA THE NAP trong ngay 10/07. KM su dung noi, ngoai mang va co han dung den het 25/07/2020. Chi tiet goi 197', '2020-07-09 10:59:23'),
(38, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] Uu dai goi noi mang chi voi 30.000d/30 ngay co 300 phut goi noi mang. Dang ky, soan MP30 gui 109. CT ap dung cho TB nhan duoc tin', '2020-07-12 17:08:40'),
(39, '862273048557193', 'VIETTEL', '0971686624', '[TB] Nhan ky niem sinh nhat 1 nam, Viettel   to chuc quay so trung thuong tu 19/6-19/8/2020. Quy khach hay bam goi *098# hoac truy cap', '2020-07-13 15:19:46'),
(40, '862273048557193', 'VIETTEL', '0971686624', 'i vien Kim Cuong va them 20.000.000 diem Viettel  . Chi tiet LH 198 (0d). Tran trong.', '2020-07-13 15:19:57'),
(41, '862273048557193', 'VIETTEL', '0971686624', '[TB] Quy khach duoc huong uu dai giam cuoc goi noi mang con 550d/p theo CTKM dac biet. CT ap dung ke tu thoi diem TB nhan tin nhan den', '2020-07-13 18:44:15'),
(42, '862273048557193', 'CUC TRE EM', '0971686624', 'Phap luat nghiem cam moi hanh vi xam hai tre em. Hay goi ngay 111 de thong bao khi nghi van, phat hien dau hieu, vu viec xam hai tre em!', '2020-07-17 14:51:30'),
(43, '862273048557193', 'VTPOST', '0971686624', '661671 la ma xac minh ViettelPost cua ban. Ma xac minh co hieu luc trong vong 1800 giay.', '2020-07-17 16:36:05'),
(44, '862273048557193', 'NAPTHE?VT', '0971686624', '[QC] TANG 20% GIA TRI TAT CA THE NAP trong ngay 20/07. KM su dung noi, ngoai mang va co han dung den het 04/08/2020. Chi tiet goi 197', '2020-07-19 14:57:29'),
(45, '862273048557193', 'NAPTHE?VT', '0971686624', '[QC] DUNG QUEN NAP THE HOM NAY (20/07). Tang 20% gia tri tat ca the nap. Tien KM su dung noi, ngoai mang den het 04/08/2020. Chi tiet', '2020-07-20 14:08:33'),
(46, '862273048557193', 'IMUZIK', '0971686624', '(QC) Top nhac cho Hot cua ca si WANBI TUAN ANH: TIM THAY, KY UC NGAY HOM QUA, VUOT DOC... Nghe nhac hoan toan MIEN PHI DATA tai http:/', '2020-07-21 15:52:22'),
(47, '862273048557193', 'IMUZIK', '0971686624', '(QC) DV Imuzik gioi thieu voi TB 0971686624 ban nhac cho duoc yeu thich nhat: NAM. De tai bai hat lam nhac cho, soan BH NAM gui 1221.', '2020-07-23 11:04:26'),
(48, '862273048557193', 'IMUZIK', '0971686624', 'Phi DV Nhac cho 15.000d/thang, tai khong gioi han bai hat, gia han theo thang. Chi tiet LH 198 (0d) hoac truy cap http://imuzik.vn/ban', '2020-07-23 11:04:37'),
(49, '862273048557193', 'IMUZIK', '0971686624', 'g-xep-hang (MIEN CUOC DATA). Tu choi QC, soan TC4 gui 199.', '2020-07-23 11:05:09'),
(50, '862273048557193', 'BO?TTTT', '0971686624', 'Bo TTTT khuyen cao nguoi dan nang cao canh giac, khong chuyen tien hoac cung cap thong tin ca nhan cho nguoi la qua dien thoai. Neu co', '2020-07-24 15:32:45'),
(51, '862273048557193', 'BO?TTTT', '0971686624', 'hien tuong tren, de nghi trinh bao ngay cho co quan Cong an de xu ly hoac thong bao den so dien thoai truc ban hinh su 0692348560 cua', '2020-07-24 15:32:58'),
(52, '862273048557193', 'NAPTHE?VT', '0971686624', '[QC] TANG 20% GIA TRI TAT CA THE NAP trong ngay 30/07. Tien KM su dung noi, ngoai mang den het 14/08/2020. Chi tiet goi 197 bam phim 1', '2020-07-29 10:58:29'),
(53, '862273048557193', 'NAPTHE?VT', '0971686624', '9 (0d). Tu choi QC, soan TC1 gui 199.', '2020-07-29 10:59:13'),
(54, '862273048557193', 'NAPTHE?VT', '0971686624', '[QC] DUNG QUEN NAP THE HOM NAY (30/07). Tang 20% gia tri tat ca the nap. Tien KM su dung noi, ngoai mang den het 14/08/2020. Chi tiet', '2020-07-30 14:14:25'),
(55, '862273048557193', 'NAPTHE?VT', '0971686624', 'goi 197 bam phim 19 (0d). Tu choi QC, soan TC1 gui 199.', '2020-07-30 14:15:07'),
(56, '862273048557193', 'BO Y TE', '0971686624', 'Bo Y te de nghi cac ca nhan tung co mat o Thanh pho Da Nang trong khoang thoi gian tu ngay 01/7/2020 den ngay 29/7/2020 khan truong thuc hien:', '2020-07-30 19:58:29'),
(57, '862273048557193', 'BoCA?BoTTTT', '0971686624', 'Hay tich cuc tham gia phong, chong mua ban nguoi va dua nguoi di cu trai phep. Khi phat hien dau hieu lien quan hay thong bao ngay den Cong', '2020-07-31 11:59:08'),
(58, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] Uu dai goi noi mang chi voi 30.000d/30 ngay co 300 phut goi noi mang. Dang ky, soan MP30 gui 109. CT ap dung cho TB nhan duoc tin', '2020-08-03 19:39:38'),
(59, '862273048557193', 'VIETTEL?KM', '0971686624', 'nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-08-03 19:39:49'),
(60, '862273048557193', 'BO Y TE', '0971686624', 'KHUYEN CAO PHONG CHONG DICH COVID-19\nTruoc dien bien phuc tap cua dich COVID-19 tai Viet Nam, Bo Y te de nghi moi nguoi dan chu dong, tich cuc,', '2020-08-04 14:03:59'),
(61, '862273048557193', '84377839660', '0971686624', 'pUg Thue bao quy khach duoc tang 50k vao tk tu game doi thuong HU WIN.Truy cap  Https://huwin.vip nhap ma code  < A3M48F > bok5', '2020-08-04 15:00:06'),
(62, '862273048557193', 'IMUZIK', '0971686624', '(QC) Bang xep hang Nhac Cho IMuzik 2020: CHUYEN NGUOI CON GAI, ANH LA SINH VIEN, I WANT YOU NOW... Nghe nhac hoan toan MIEN PHI DATA t', '2020-08-04 18:15:08'),
(63, '862273048557193', 'IMUZIK', '0971686624', 'ac bai hat lam nhac cho voi gia 0d). DV gia han theo thang. Chi tiet LH 198 (0d). Tu choi QC, soan TC4 gui 199.', '2020-08-04 18:15:53'),
(64, '862273048557193', 'IMUZIK', '0971686624', 'ai http://imuzik.vn . Dang ky va tai bai hat lam nhac cho, soan BH CHUYEN NGUOI CON GAI gui 1221. Cuoc DV 15.000d/thang (tai toan bo c', '2020-08-04 18:16:34'),
(65, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] DOI 1 DUOC 10: Co ngay 30.000d de goi noi mang den 24h chi voi 3.000d/ngay. Dang ky, soan DT3 gui 109, gia han theo ngay. CT ap d', '2020-08-06 10:24:51'),
(66, '862273048557193', 'VIETTEL?KM', '0971686624', 'ung den 12/08/2020 23:59:59 cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-08-06 10:25:34'),
(67, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] Uu dai goi noi mang chi voi 30.000d/30 ngay co 300 phut goi noi mang. Dang ky, soan MP30 gui 109. CT ap dung cho TB nhan duoc tin', '2020-08-06 14:15:26'),
(68, '862273048557193', 'VIETTEL?KM', '0971686624', 'nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-08-06 14:16:08'),
(69, '862273048557193', 'NAPTHE?VT', '0971686624', '[QC] TANG 20% GIA TRI TAT CA THE NAP trong ngay 10/08. Tien KM su dung noi, ngoai mang den het 25/08/2020. Chi tiet goi 197 bam phim 1', '2020-08-10 10:15:14'),
(70, '862273048557193', 'NAPTHE?VT', '0971686624', '9 (0d). Tu choi QC, soan TC1 gui 199.', '2020-08-10 10:15:56'),
(71, '862273048557193', 'BO Y TE', '0971686624', 'Bo Y te de nghi Quy vi thuc hien tot cac diem sau day:\n1. Han che den noi cong cong, tap trung dong nguoi.\n2. Deo khau trang khi ra ngoai, giu', '2020-08-11 08:45:45'),
(72, '862273048557193', 'VIETTEL', '0971686624', 'Quy khach duoc cong them 4 diem Viettel   boi giao dich Tieu dung vien thong thang 7. Thoi han su dung diem den 31/08/2021. Hay truy c', '2020-08-11 19:54:45'),
(73, '862273048557193', 'VIETTEL', '0971686624', 'ap https://myvt.page.link/vtplus tren My Viettel hoac *098# de doi diem sang Data, SMS, Phut goi cung nhieu uu dai gia tri khac. Chi t', '2020-08-11 19:55:28'),
(74, '862273048557193', 'VIETTEL', '0971686624', 'iet truy cap cong.viettel.vn hoac LH 198. Tran trong.', '2020-08-11 19:55:39'),
(75, '862273048557193', 'VIETTEL', '0971686624', '[TB] Quy khach duoc huong uu dai giam cuoc goi noi mang con 550d/p theo CTKM dac biet. CT ap dung ke tu thoi diem TB nhan tin nhan den', '2020-08-13 14:41:44'),
(76, '862273048557193', 'VIETTEL', '0971686624', '2020-08-19 23:59:59. Tran trong.', '2020-08-13 14:42:56'),
(77, '862273048557193', 'BO Y TE', '0971686624', 'Bo Y te de nghi moi nguoi dan hay deo khau trang dung cach de phong lay nhiem COVID-19:\n- Khau trang phai che kin mui, mieng, dam bao khong co', '2020-09-04 11:28:43'),
(78, '862273048557193', 'BO Y TE', '0971686624', 'en cao cua nha san xuat.\n- Rua tay dung cach bang xa phong hoac dung dich rua tay sat khuan truoc va sau khi deo khau trang.', '2020-09-04 11:28:55'),
(79, '862273048557193', 'VIETTEL', '0971686624', '[QC] Quy khach co 1006 diem tieu dung Viettel   tinh den het ngay 03/09/2020. Bam goi *098# hoac truy cap ung dung MyViettel tai https', '2020-09-04 19:45:01'),
(80, '862273048557193', 'VIETTEL', '0971686624', '://viettel.vn/app (muc Viettel  ) de doi diem thanh Data, phut goi, SMS hoac cac uu dai gia tri khac. LH 198 (0d). Tu choi QC, soan HU', '2020-09-04 19:45:14'),
(81, '862273048557193', 'VIETTEL', '0971686624', 'Y gui 9000.', '2020-09-04 19:45:45'),
(82, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] DOI 1 DUOC 10: Co ngay 30.000d de goi noi mang den 24h chi voi 3.000d/ngay. Dang ky, soan DT3 gui 109, gia han theo ngay. CT ap d', '2020-09-06 09:56:49'),
(83, '862273048557193', 'VIETTEL?KM', '0971686624', 'ung den 12/09/2020 23:59:59 cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-09-06 09:57:00'),
(84, '862273048557193', 'BO Y TE', '0971686624', 'Hay cung nhau chong lai COVID-19 bang nhung hanh dong nho nhat:\nBo Y te de nghi moi nguoi dan hay deo khau trang khi ra ngoai va trong suot qua', '2020-09-07 14:02:25'),
(85, '862273048557193', 'BO Y TE', '0971686624', 'tay trong thoi gian it nhat 20 giay, giup bao ve ban truoc COVID-19.\nLien he voi duong day nong Bo Y te: 1900.9095 de duoc tu van khi can thie', '2020-09-07 14:02:38'),
(86, '862273048557193', 'VIETTEL', '0971686624', 'Quy khach duoc cong them 3 diem Viettel   boi giao dich Tieu dung vien thong thang 8. Thoi han su dung diem den 30/09/2021. Hay truy c', '2020-09-09 09:12:32'),
(87, '862273048557193', 'VIETTEL', '0971686624', 'iet truy cap cong.viettel.vn hoac LH 198. Tran trong.', '2020-09-09 09:13:14'),
(88, '862273048557193', 'VIETTEL', '0971686624', 'ap https://myvt.page.link/vtplus tren My Viettel hoac *098# de doi diem sang Data, SMS, Phut goi cung nhieu uu dai gia tri khac. Chi t', '2020-09-09 09:13:57'),
(89, '862273048557193', 'NAPTHE?VT', '0971686624', '[QC] TANG 20% GIA TRI TAT CA THE NAP trong ngay 10/09. Tien KM su dung noi, ngoai mang den het 25/09/2020. Chi tiet goi 197 bam phim 1', '2020-09-09 10:30:54'),
(90, '862273048557193', 'NAPTHE?VT', '0971686624', '9 (0d). Tu choi QC, soan TC1 gui 199.', '2020-09-09 10:31:36'),
(91, '862273048557193', 'NAPTHE?VT', '0971686624', '[QC] DUNG QUEN NAP THE HOM NAY (10/09). Tang 20% gia tri tat ca the nap. Tien KM su dung noi, ngoai mang den het 25/09/2020. Chi tiet', '2020-09-10 16:07:44'),
(92, '862273048557193', 'VIETTEL', '0971686624', '[TB] Quy khach duoc huong uu dai giam cuoc goi noi mang con 550d/p theo CTKM dac biet. CT ap dung ke tu thoi diem TB nhan tin nhan den', '2020-09-13 10:23:32'),
(93, '862273048557193', 'VIETTEL', '0971686624', '2020-09-19 23:59:59. Tran trong.', '2020-09-13 10:24:14'),
(94, '862273048557193', 'VIETTEL?QC', '0971686624', '[QC] SMARTPHONE 4G CHO MOI NGUOI - Giam den 35% so voi gia ban le, chi tu 1.290.000d khi mua dien thoai Vsmart Star 3 va chuyen doi TB', '2020-09-15 17:48:42'),
(95, '862273048557193', 'VIETTEL?QC', '0971686624', '198 (0d) hoac truy cap https://vt.viettelpay.vn/star3s1. Tu choi QC, soan TC3 gui 199.', '2020-09-15 17:49:26'),
(96, '862273048557193', 'VIETTEL?QC', '0971686624', 'tu tra truoc sang tra sau kem GOI CUOC SIEU UU DAI (V120S, V150S, V200S). CT ap dung tai cua hang Viettel tren toan quoc. Chi tiet LH', '2020-09-15 17:50:09'),
(97, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI RE HON - UU DAI HON: Chi 30.000d/30 ngay, mien phi 10 phut/cuoc goi noi mang (toi da 500 phut). Dang ky, soan MP30X gui 109.', '2020-09-16 09:23:49'),
(98, '862273048557193', 'VIETTEL?KM', '0971686624', 'DV gia han sau 30 ngay. CT ap dung cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-09-16 09:24:57'),
(99, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] TIET KIEM CHO GIA DINH LA UU TIEN NHAT! GIAM 10.000d khi mua goi MP30X: Chi 20.000d/30 ngay, mien phi 10 phut/cuoc goi noi mang (', '2020-09-18 10:23:52'),
(100, '862273048557193', 'VIETTEL?KM', '0971686624', 'toi da 500 phut). DV gia han sau 30 ngay voi phi 30.000d. Dang ky, soan MP30X gui 109. CT ap dung voi lan dang ky dau tien tu 18-22/9', '2020-09-18 10:24:04'),
(101, '862273048557193', 'VIETTEL?KM', '0971686624', 'cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-09-18 10:24:36'),
(102, '862273048557193', 'VIETTEL?QC', '0971686624', '[QC] SMARTPHONE 4G CHO MOI NGUOI - Dien thoai Samsung A01 Core chi tu 1.090.000d khi chuyen doi tu TB tra truoc sang tra sau kem GOI C', '2020-09-18 16:33:25'),
(103, '862273048557193', 'VIETTEL?QC', '0971686624', 's://viettel.vn/a01-core. Tu choi QC, soan TC3 gui 199.', '2020-09-18 16:34:07'),
(104, '862273048557193', 'VIETTEL?QC', '0971686624', 'UOC SIEU UU DAI V120S (120.000d/thang: 20p/ cuoc goi noi mang, 50p ngoai mang, 1GB data/ngay). Chi tiet LH 198 (0d) hoac truy cap http', '2020-09-18 16:34:51'),
(105, '862273048557193', 'VIETTEL', '0971686624', '[TB] Quy khach duoc mien phi 10 phut/cuoc goi noi mang dau tien moi ngay trong 7 NGAY (tu 21/09 den 2020-09-27 23:59:59) theo CT khuye', '2020-09-20 10:34:26'),
(106, '862273048557193', 'VIETTEL', '0971686624', 'n mai dac biet. Tran trong.', '2020-09-20 10:35:08'),
(107, '862273048557193', 'NAPTHE?VT', '0971686624', '[QC] TANG 20% GIA TRI TAT CA THE NAP trong ngay 21/09. Tien KM su dung noi, ngoai mang den het 06/10/2020. Chi tiet goi 197 bam phim 1', '2020-09-20 14:45:01'),
(108, '862273048557193', 'NAPTHE?VT', '0971686624', '9 (0d). Tu choi QC, soan TC1 gui 199.', '2020-09-20 14:45:43'),
(109, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] Goi noi mang chi 100d/phut: Voi 5.000d, co 50 phut goi noi mang su dung den 24h ngay dang ky. Tham gia, soan MP5X gui 109. Chi ti', '2020-09-23 17:26:56'),
(110, '862273048557193', 'VIETTEL?KM', '0971686624', 'et LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-09-23 17:27:37'),
(111, '862273048557193', 'BO?TTTT', '0971686624', 'Bo TTTT khuyen cao nguoi dan nang cao canh giac, khong chuyen tien hoac cung cap thong tin ca nhan cho nguoi la qua dien thoai. Neu co', '2020-09-24 14:44:23'),
(112, '862273048557193', 'BO?TTTT', '0971686624', 'hien tuong tren, de nghi trinh bao ngay cho co quan Cong an de xu ly hoac thong bao den so dien thoai truc ban hinh su 0692348560 cua', '2020-09-24 14:44:36'),
(113, '862273048557193', 'BO?TTTT', '0971686624', 'Cuc Canh sat hinh su de duoc huong dan kip thoi.', '2020-09-24 14:45:08'),
(114, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI RE HON - UU DAI HON: Chi 30.000d/30 ngay, mien phi 10 phut/cuoc goi noi mang (toi da 500 phut). Dang ky, soan MP30X gui 109.', '2020-09-25 19:13:01'),
(115, '862273048557193', 'VIETTEL?KM', '0971686624', 'DV gia han sau 30 ngay. CT ap dung cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-09-25 19:13:12'),
(116, '862273048557193', 'VIETTEL?QC', '0971686624', '[QC] SMARTPHONE 4G CHO MOI NGUOI - Dien thoai Samsung A01 Core chi tu 1.090.000d khi chuyen doi tu TB tra truoc sang tra sau kem GOI C', '2020-09-27 14:59:01'),
(117, '862273048557193', 'VIETTEL?QC', '0971686624', 's://viettel.vn/a01-core. Tu choi QC, soan TC3 gui 199.', '2020-09-27 14:59:43'),
(118, '862273048557193', 'VIETTEL?QC', '0971686624', 'UOC SIEU UU DAI V120S (120.000d/thang: 20p/ cuoc goi noi mang, 50p ngoai mang, 1GB data/ngay). Chi tiet LH 198 (0d) hoac truy cap http', '2020-09-27 15:00:27'),
(119, '862273048557193', 'NAPTHE?VT', '0971686624', '[QC] TANG 20% GIA TRI TAT CA THE NAP trong ngay 30/09. Tien KM su dung noi, ngoai mang den het 15/10/2020. Chi tiet goi 197 bam phim 1', '2020-09-30 09:16:40'),
(120, '862273048557193', 'NAPTHE?VT', '0971686624', '9 (0d). Tu choi QC, soan TC1 gui 199.', '2020-09-30 09:16:51'),
(121, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI RE HON - UU DAI HON: Voi 30.000d/30 ngay, mien phi 10 phut/cuoc goi noi mang (toi da 500 phut). Dang ky, soan MP30X gui 109.', '2020-10-02 15:33:53'),
(122, '862273048557193', 'VIETTEL?KM', '0971686624', 'CT ap dung cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-10-02 15:34:04'),
(123, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] DOI 1 DUOC 10: Co ngay 30.000d de goi noi mang den 24h chi voi 3.000d/ngay. Dang ky, soan DT3 gui 109, gia han theo ngay. CT ap d', '2020-10-06 15:59:41'),
(124, '862273048557193', 'VIETTEL?KM', '0971686624', 'ung den 12/10/2020 23:59:59 cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-10-06 16:00:54'),
(125, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI DIEN THA GA, TANG 20% GIA TRI THE NAP! \n1. TANG 20% GIA TRI TAT CA THE NAP trong ngay 08/10/2020, tien KM de goi va nhan tin', '2020-10-08 17:08:19'),
(126, '862273048557193', 'VIETTEL?KM', '0971686624', 'bile Internet dang su dung (neu co). \nCT ap dung tu thoi diem TB nhan duoc tin nhan. LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-10-08 17:08:30'),
(127, '862273048557193', 'MOCHA', '0971686624', 'Ban vua nhan duoc tin nhan do TB 0343516584 gui qua Ung dung nhan SMS Mien phi Mocha cua Viettel. Hay tiet kiem hang tram nghin moi th', '2020-10-10 16:51:52'),
(128, '862273048557193', '84343516584', '0971686624', '00350075006300660078002000430068006F00690020006E0068006F0020006700690061007500200074006F002000740061006900200038003800380062002C0020005300', '2020-10-10 16:52:06'),
(129, '862273048557193', '84343516584', '0971686624', '0061007000200031003500300025002000630068006F002000540041004E0020005400480055002E0020005400680061006D00200067006900610020006E00680061006E00', '2020-10-10 16:53:20'),
(130, '862273048557193', '84363015986', '0971686624', '0043006F006E0067002000670061006D006500200064006F00690020007400680075006F006E0067005C003A0020004D0041005800390039002E0020004F006E0065002000', '2020-10-10 19:27:28'),
(131, '862273048557193', '84363015986', '0971686624', '00740020007400690065006E0020003300700020002E00200043006F006400650020003200300030004B004D00430036004500360043004300450045003500350045002000', '2020-10-10 19:28:12'),
(132, '862273048557193', '84363015986', '0971686624', '01B01EE30063002000671EED0069002000741EEB0020004D006F006300680061', '2020-10-10 19:28:54'),
(133, '862273048557193', 'NAPTHE?VT', '0971686624', '[TB] Quy khach dung quen nap the hom nay (10/10), Viettel tang 20% gia tri the nap. Tien KM su dung noi, ngoai mang den het 25/10. Chi', '2020-10-10 19:44:14'),
(134, '862273048557193', 'NAPTHE?VT', '0971686624', 'tiet goi 197 bam phim 19 (0d). Tran trong.', '2020-10-10 19:44:25'),
(135, '862273048557193', '84393106307', '0971686624', '00360066006C007700630020004C0061006D00200067006900610075002000630068006F0069002000670061006D006500200069002000770069006E002000360030003200', '2020-10-11 12:23:59'),
(136, '862273048557193', '84393106307', '0971686624', '006300750061002C006E006F002000680075002E006B0068007500790065006E0020006D006100690020006B00680075006E006700200068006F0061006E00200074007200', '2020-10-11 12:24:43'),
(137, '862273048557193', '84393106307', '0971686624', '002000430079004D005800490057006C0071000D000A000D000A011001B01EE30063002000671EED0069002000741EEB0020004D006F006300680061', '2020-10-11 12:25:25'),
(138, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI RE HON - UU DAI HON: Voi 70.000d/30 ngay, mien phi 20 phut/cuoc goi noi mang (toi da 1.000 phut). Dang ky, soan MP70X gui 109', '2020-10-11 16:15:30'),
(139, '862273048557193', 'VIETTEL?KM', '0971686624', '. CT ap dung cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-10-11 16:16:42'),
(140, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI RE HON - UU DAI HON: Voi 30.000d/30 ngay, mien phi 10 phut/cuoc goi noi mang (toi da 500 phut). Dang ky, soan MP30X gui 109.', '2020-10-12 10:03:51'),
(141, '862273048557193', 'VIETTEL?KM', '0971686624', 'CT ap dung cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-10-12 10:04:33'),
(142, '862273048557193', 'NAPTHE?VT', '0971686624', '[QC] KHUYEN MAI 20% KHONG GIOI HAN THOI GIAN SU DUNG cho tat ca cac the nap. Tien KM su dung noi mang, ngoai mang. CT ap dung trong ng', '2020-10-27 08:56:19'),
(143, '862273048557193', 'NAPTHE?VT', '0971686624', 'ay 28/10/2020 cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC1 gui 199.', '2020-10-27 08:56:31'),
(144, '862273048557193', 'NAPTHE?VT', '0971686624', '[TB] TANG 20% GIA TRI TAT CA THE NAP trong ngay 30/10. Tien KM su dung noi, ngoai mang den het 14/11/2020. Chi tiet goi 197 bam phim 19 (0d).', '2020-10-29 09:54:42'),
(145, '862273048557193', 'NAPTHE?VT', '0971686624', '[TB] Quy khach dung quen nap the hom nay (30/10), Viettel tang 20% gia tri the nap. Tien KM su dung noi, ngoai mang den het 14/11. Chi', '2020-10-30 15:54:09'),
(146, '862273048557193', '84966624292', '0971686624', 'Hello', '2020-10-31 09:23:49'),
(147, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] Goi noi mang chi 100d/phut: Voi 5.000d, co 50 phut goi noi mang su dung den 24h ngay dang ky. Tham gia, soan MP5X gui 109. Chi ti', '2020-11-03 10:41:09'),
(148, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI RE HON - UU DAI HON: Chi 70.000d/30 ngay, mien phi 20 phut/cuoc goi noi mang (toi da 1.000 phut). Dang ky, soan MP70X gui 109', '2020-11-04 15:17:06'),
(149, '862273048557193', 'VIETTEL', '0971686624', 'Quy khach duoc cong them 3 diem Viettel   boi giao dich Tieu dung vien thong thang 10. Thoi han su dung diem den 30/11/2021. Hay truy', '2020-11-06 09:03:02'),
(150, '862273048557193', 'VIETTEL', '0971686624', 'tiet truy cap cong.viettel.vn hoac LH 198. Tran trong.', '2020-11-06 09:03:43'),
(151, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] DOI 1 DUOC 10: Co ngay 30.000d de goi noi mang den 24h chi voi 3.000d/ngay. Dang ky, soan DT3 gui 109, gia han theo ngay. CT ap d', '2020-11-06 14:45:11'),
(152, '862273048557193', 'VIETTEL?KM', '0971686624', 'ung den 12/11/2020 23:59:59 cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-11-06 14:45:53'),
(153, '862273048557193', 'BO?TU?PHAP', '0971686624', '[TB] Tich cuc huong ung Ngay Phap luat nuoc Cong hoa Xa hoi chu nghia Viet Nam 09/11, toan dan phat huy tinh than song, lam viec theo Hien p', '2020-11-09 08:39:04'),
(154, '862273048557193', '84528103907', '0971686624', 'Y Y P*_*Co.ng_gam_e doithuong so 1_VN .Gam.e tai T M X http://bit.ly/HEN88TANGCODE Y Y P. Ta.ng C0D.E co gia.tri den 5M. Ma c.0dE  cua ban', '2020-11-09 22:56:57'),
(155, '862273048557193', 'NAPTHE?VT', '0971686624', '[TB] TANG 20% GIA TRI TAT CA THE NAP trong ngay 10/11. Tien KM su dung noi, ngoai mang den het 25/11/2020. Chi tiet goi 197 bam phim 19 (0d).', '2020-11-10 08:39:21'),
(156, '862273048557193', '84369469756', '0971686624', 'HSEf Nap Rut Sieu toc Voi Bet888.vin Hay Su Dung phan Thuong Trai nghiem [V000SL1KSS] De Cung Kham Pha nao. ac9Hr', '2020-11-11 19:39:51'),
(157, '862273048557193', 'VIETTEL', '0971686624', '[TB] Quy khach duoc huong uu dai giam cuoc goi noi mang con 550d/p theo CTKM dac biet. CT ap dung ke tu thoi diem TB nhan tin nhan den', '2020-11-13 14:53:48'),
(158, '862273048557193', 'VIETTEL', '0971686624', '2020-11-19 23:59:59. Tran trong.', '2020-11-13 14:54:12'),
(159, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI RE HON - UU DAI HON: Chi 70.000d/30 ngay, mien phi 20 phut/cuoc goi noi mang (toi da 1.000 phut). Dang ky, soan MP70X gui 109', '2020-11-14 10:46:20'),
(160, '862273048557193', 'VIETTEL?KM', '0971686624', '. DV gia han sau 30 ngay. CT ap dung cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-11-14 10:46:31'),
(161, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI RE HON - UU DAI HON: Chi 30.000d/30 ngay, mien phi 10 phut/cuoc goi noi mang (toi da 500 phut). Dang ky, soan MP30X gui 109.', '2020-11-15 10:00:13'),
(162, '862273048557193', 'NAPTHE?VT', '0971686624', '[TB] Quy khach dung quen nap the hom nay (20/11), Viettel tang 20% gia tri the nap. Tien KM su dung noi, ngoai mang den het 05/12. Chi', '2020-11-20 18:03:28'),
(163, '862273048557193', 'NAPTHE?VT', '0971686624', 'tiet goi 197 bam phim 19 (0d). Tran trong.', '2020-11-20 18:03:39'),
(164, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI RE HON - UU DAI HON: Voi 70.000d/30 ngay, mien phi 20 phut/cuoc goi noi mang (toi da 1.000 phut). Dang ky, soan MP70X gui 109', '2020-11-21 16:34:33'),
(165, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI RE HON - UU DAI HON: Voi 30.000d/30 ngay, mien phi 10 phut/cuoc goi noi mang (toi da 500 phut). Dang ky, soan MP30X gui 109.', '2020-11-22 19:33:38'),
(166, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI RE HON - UU DAI HON: Chi 70.000d/30 ngay, mien phi 20 phut/cuoc goi noi mang (toi da 1.000 phut). Dang ky, soan MP70X gui 109', '2020-11-24 15:30:37'),
(167, '862273048557193', 'VIETTEL?KM', '0971686624', '. DV gia han sau 30 ngay. CT ap dung cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-11-24 15:31:19'),
(168, '862273048557193', 'BO?TTTT', '0971686624', 'Bo TTTT khuyen cao nguoi dan nang cao canh giac, khong chuyen tien hoac cung cap thong tin ca nhan cho nguoi la qua dien thoai. Neu co', '2020-11-24 20:37:52'),
(169, '862273048557193', 'BO?TTTT', '0971686624', 'Cuc Canh sat hinh su de duoc huong dan kip thoi.', '2020-11-24 20:38:34'),
(170, '862273048557193', 'BO?TTTT', '0971686624', 'hien tuong tren, de nghi trinh bao ngay cho co quan Cong an de xu ly hoac thong bao den so dien thoai truc ban hinh su 0692348560 cua', '2020-11-24 20:39:17'),
(171, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI RE HON - UU DAI HON: Chi 30.000d/30 ngay, mien phi 10 phut/cuoc goi noi mang (toi da 500 phut). Dang ky, soan MP30X gui 109.', '2020-11-25 09:15:04'),
(172, '862273048557193', 'VIETTEL?KM', '0971686624', 'DV gia han sau 30 ngay. CT ap dung cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-11-25 09:15:26'),
(173, '862273048557193', 'NAPTHE?VT', '0971686624', '[TB] TANG 20% GIA TRI TAT CA THE NAP trong ngay 30/11. Tien KM su dung noi, ngoai mang den het 15/12/2020. Chi tiet goi 197 bam phim 19 (0d).', '2020-11-29 10:23:26'),
(174, '862273048557193', 'NAPTHE?VT', '0971686624', '[TB] Quy khach dung quen nap the hom nay (30/11), Viettel tang 20% gia tri the nap. Tien KM su dung noi, ngoai mang den het 15/12. Chi', '2020-11-30 16:30:15'),
(175, '862273048557193', 'NAPTHE?VT', '0971686624', 'tiet goi 197 bam phim 19 (0d). Tran trong.', '2020-11-30 16:30:26'),
(176, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI RE HON - UU DAI HON: Voi 70.000d/30 ngay, mien phi 20 phut/cuoc goi noi mang (toi da 1.000 phut). Dang ky, soan MP70X gui 109', '2020-12-01 18:35:22'),
(177, '862273048557193', 'VIETTEL?KM', '0971686624', '. CT ap dung cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-12-01 18:35:44'),
(178, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI RE HON - UU DAI HON: Voi 30.000d/30 ngay, mien phi 10 phut/cuoc goi noi mang (toi da 500 phut). Dang ky, soan MP30X gui 109.', '2020-12-02 09:56:59'),
(179, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] Goi noi mang chi 100d/phut: Voi 5.000d, co 50 phut goi noi mang su dung den 24h ngay dang ky. Tham gia, soan MP5X gui 109. Chi ti', '2020-12-03 19:30:51'),
(180, '862273048557193', 'VIETTEL?KM', '0971686624', 'et LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-12-03 19:31:02'),
(181, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI RE HON - UU DAI HON: Chi 70.000d/30 ngay, mien phi 20 phut/cuoc goi noi mang (toi da 1.000 phut). Dang ky, soan MP70X gui 109', '2020-12-04 13:48:16'),
(182, '862273048557193', '84397415381', '0971686624', '00430048004F00490020004E0047004100590020002D002000680074007400700073003A002F002F006200690074002E006C0079002F004400410042004500540031003500', '2020-12-05 12:55:03'),
(183, '862273048557193', '84397415381', '0971686624', '004D006100740020002E00200048006F002000540072006F002000420061006E006B0020002C0020004D006F006D006F0020002C0020005400680065002000630061006F00', '2020-12-05 12:55:17'),
(184, '862273048557193', '84397415381', '0971686624', '002000440065002000780065006D00200076006100200074007200610020006C006F0069002C00200076007500690020006C006F006E006700200063006100690020006400', '2020-12-05 12:56:01'),
(185, '862273048557193', '84397415381', '0971686624', '0061007000700073002E000D000A000D000A011001B01EE30063002000671EED0069002000741EEB0020004D006F006300680061', '2020-12-05 12:56:46'),
(186, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI RE HON - UU DAI HON: Chi 30.000d/30 ngay, mien phi 10 phut/cuoc goi noi mang (toi da 500 phut). Dang ky, soan MP30X gui 109.', '2020-12-05 14:43:19'),
(187, '862273048557193', 'VIETTEL?KM', '0971686624', 'DV gia han sau 30 ngay. CT ap dung cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-12-05 14:44:01'),
(188, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] DOI 1 DUOC 10: Co ngay 30.000d de goi noi mang den 24h chi voi 3.000d/ngay. Dang ky, soan DT3 gui 109, gia han theo ngay. CT ap d', '2020-12-07 13:51:09'),
(189, '862273048557193', 'VIETTEL?KM', '0971686624', 'ung den 13/12/2020 23:59:59 cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-12-07 13:51:20'),
(190, '862273048557193', 'VIETTEL', '0971686624', 'Quy khach duoc cong them 1 diem Viettel   boi giao dich Tieu dung vien thong thang 11/2020. Thoi han su dung diem den 31/12/2021. Hay', '2020-12-08 17:05:54'),
(191, '862273048557193', 'VIETTEL', '0971686624', 'truy cap https://myvt.page.link/vtplus tren My Viettel hoac *098# de doi diem sang Data, SMS, Phut goi cung nhieu uu dai gia tri khac.', '2020-12-08 17:06:37'),
(192, '862273048557193', 'VIETTEL', '0971686624', 'Chi tiet LH 198. Tran trong.', '2020-12-08 17:07:19'),
(193, '862273048557193', 'NAPTHE?VT', '0971686624', '[TB] TANG 20% GIA TRI TAT CA THE NAP trong ngay 10/12. Tien KM su dung noi, ngoai mang den het 25/12/2020. Chi tiet goi 197 bam phim 19 (0d).', '2020-12-09 15:39:16'),
(194, '862273048557193', 'NAPTHE?VT', '0971686624', '[TB] Quy khach dung quen nap the hom nay (10/12), Viettel tang 20% gia tri the nap. Tien KM su dung noi, ngoai mang den het 25/12. Chi', '2020-12-10 18:00:01'),
(195, '862273048557193', 'NAPTHE?VT', '0971686624', 'tiet goi 197 bam phim 19 (0d). Tran trong.', '2020-12-10 18:00:42'),
(196, '862273048557193', 'BO Y TE', '0971686624', '[TB] De thuc hien phong, chong dich COVID-19 hieu qua, Bo Y te tran trong de nghi: \n- Nguoi dan thuc hien nghiem thong diep 5K cua Bo Y te, dac', '2020-12-11 08:36:37'),
(197, '862273048557193', 'BO Y TE', '0971686624', 'u trong viec deo khau trang tai noi cong cong va thuong xuyen khu khuan tay; cai dat/tai khoi dong ung dung Bluezone tren dien thoai di dong.\n-', '2020-12-11 08:36:50'),
(198, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] Goi noi mang chi 100d/phut: Voi 5.000d, co 50 phut goi noi mang su dung den 24h ngay dang ky. Tham gia, soan MP5X gui 109. Chi ti', '2020-12-13 17:31:31'),
(199, '862273048557193', 'VIETTEL?KM', '0971686624', 'et LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-12-13 17:32:15'),
(200, '862273048557193', 'VIETTEL', '0971686624', '[TB] Quy khach duoc huong uu dai giam cuoc goi noi mang con 550d/p theo CTKM dac biet. CT ap dung ke tu thoi diem TB nhan tin nhan den', '2020-12-14 12:03:06'),
(201, '862273048557193', 'VIETTEL', '0971686624', '2020-12-20 23:59:59. Tran trong.', '2020-12-14 12:03:19'),
(202, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI RE HON - UU DAI HON: Chi 70.000d/30 ngay, mien phi 20 phut/cuoc goi noi mang (toi da 1.000 phut). Dang ky, soan MP70X gui 109', '2020-12-14 14:05:34'),
(203, '862273048557193', 'VIETTEL?KM', '0971686624', '. DV gia han sau 30 ngay. CT ap dung cho TB nhan duoc tin nhan. Chi tiet LH 198 (0d). Tu choi QC, soan TC2 gui 199.', '2020-12-14 14:06:16'),
(204, '862273048557193', 'VIETTEL?KM', '0971686624', '[QC] GOI RE HON - UU DAI HON: Chi 30.000d/30 ngay, mien phi 10 phut/cuoc goi noi mang (toi da 500 phut). Dang ky, soan MP30X gui 109.', '2020-12-15 10:27:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_sms`
--

CREATE TABLE `dong_sms` (
  `sms_id` int(11) NOT NULL,
  `sms_transaction` int(11) NOT NULL,
  `sms_device` varchar(100) CHARACTER SET utf32 COLLATE utf32_unicode_ci DEFAULT NULL,
  `sms_phone_send` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sms_user` int(11) NOT NULL,
  `sms_phone_receive` varchar(10) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `sms_phone_network` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sms_content` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  `sms_price` int(11) NOT NULL DEFAULT 0,
  `sms_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'UNSENT',
  `sms_prioritize` int(11) DEFAULT NULL COMMENT 'Tin Nhắn Ưu Tiên',
  `sms_send` datetime DEFAULT NULL,
  `sms_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dong_sms`
--

INSERT INTO `dong_sms` (`sms_id`, `sms_transaction`, `sms_device`, `sms_phone_send`, `sms_user`, `sms_phone_receive`, `sms_phone_network`, `sms_content`, `sms_price`, `sms_status`, `sms_prioritize`, `sms_send`, `sms_create`) VALUES
(1, 4, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2019-11-20 15:40:38', '2019-11-20 11:00:47'),
(2, 5, NULL, NULL, 1, '0914888888', 'Vinaphone', 'Hello', 200, 'UNSEND', 42, NULL, '2019-11-20 15:08:05'),
(3, 6, '862273048557193', '0971686624', 1, '0384089803', 'Viettel', 'Nguyen Van Dong', 200, 'DONE', 42, '2019-11-20 15:43:07', '2019-11-20 15:11:18'),
(4, 7, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'gio la luc HLV Park Hang-seo va cac cong su phai nghien cuu that ky tran hoa trong the thua Thai Lan', 200, 'DONE', 42, '2019-12-13 20:30:54', '2019-11-21 15:53:41'),
(5, 8, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'ssss', 200, 'DONE', 42, '2019-12-13 20:31:05', '2019-11-21 15:55:58'),
(6, 12, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'lkjdslkjgndlsg', 200, 'DONE', 42, '2019-12-13 20:31:23', '2019-11-29 11:43:44'),
(7, 13, '862273048557193', '0971686624', 1, '0988876765', 'Viettel', 'Hello', 200, 'DONE', 42, '2019-12-13 20:31:37', '2019-11-29 15:09:11'),
(8, 14, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2019-12-13 20:31:54', '2019-11-30 10:12:59'),
(9, 15, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2019-12-13 20:32:12', '2019-12-05 14:32:36'),
(10, 15, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2019-12-13 20:32:24', '2019-12-05 14:32:36'),
(11, 16, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2019-12-13 20:32:37', '2019-12-06 15:15:35'),
(12, 17, '862273048557193', '0971686624', 7, '0966624292', 'Viettel', 'Hello', 150, 'DONE', 42, '2019-12-13 20:32:50', '2019-12-09 16:12:35'),
(13, 18, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Abc', 200, 'DONE', 42, '2019-12-14 13:03:27', '2019-12-14 13:03:13'),
(14, 19, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Nguyen van dong', 200, 'DONE', 42, '2019-12-14 15:36:45', '2019-12-14 15:36:36'),
(15, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(16, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(17, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(18, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(19, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(20, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(21, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(22, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(23, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(24, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(25, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(26, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(27, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(28, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(29, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(30, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(31, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(32, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(33, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(34, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(35, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(36, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(37, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(38, 20, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2019-12-17 15:59:58'),
(39, 21, NULL, NULL, 1, '0966624292', 'Viettel', 'Hekkdsgfdsg', 200, 'PENDING', 42, NULL, '2019-12-18 15:09:17'),
(40, 22, '868440032627019', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2019-12-18 17:18:51', '2019-12-18 17:18:32'),
(41, 23, '868440032627019', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2019-12-18 17:19:43', '2019-12-18 17:19:21'),
(42, 24, '868440032627019', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2019-12-18 17:20:29', '2019-12-18 17:20:12'),
(43, 25, '868440032627019', '0971686624', 1, '0966624292', 'Viettel', 'sfsdgfsedgsdg', 200, 'DONE', 42, '2019-12-18 17:21:43', '2019-12-18 17:21:24'),
(44, 26, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello Nguyen Van Dong', 200, 'PENDING', 42, NULL, '2020-06-04 10:00:43'),
(45, 27, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'New SMS', 200, 'DONE', 42, '2020-06-04 10:34:46', '2020-06-04 10:18:09'),
(46, 28, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Dong', 200, 'DONE', 42, '2020-06-04 10:42:22', '2020-06-04 10:41:54'),
(47, 29, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello Nguyen Van Dong', 200, 'PENDING', 42, NULL, '2020-06-04 10:43:46'),
(48, 30, NULL, NULL, 1, '0966624292', 'Viettel', 'kkkkkkkkkkkkkkkkkkkkkk', 200, 'PENDING', 42, NULL, '2020-06-04 10:49:29'),
(49, 31, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Test', 200, 'DONE', 42, '2020-06-04 10:56:10', '2020-06-04 10:52:44'),
(50, 32, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Nguyen Van Dong Dong', 200, 'DONE', 42, '2020-06-04 10:59:14', '2020-06-04 10:59:03'),
(51, 33, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'N_V_D :D', 200, 'DONE', 42, '2020-06-04 11:04:51', '2020-06-04 11:04:35'),
(52, 34, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2020-06-04 11:18:45', '2020-06-04 11:18:34'),
(53, 35, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'An trua thoi', 200, 'DONE', 42, '2020-06-04 11:55:09', '2020-06-04 11:54:57'),
(54, 36, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'An trua thoi', 200, 'DONE', 42, '2020-06-04 11:55:29', '2020-06-04 11:55:09'),
(55, 37, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2020-06-04 12:43:10', '2020-06-04 12:42:49'),
(56, 38, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Test', 200, 'DONE', 42, '2020-06-04 14:05:03', '2020-06-04 14:04:49'),
(57, 39, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Hello buoi toi', 200, 'DONE', 42, '2020-06-04 20:03:03', '2020-06-04 20:02:51'),
(58, 40, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Good Morning :)', 200, 'DONE', 42, '2020-06-05 09:19:16', '2020-06-05 09:19:02'),
(59, 41, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2020-06-05 15:42:24', '2020-06-05 15:42:11'),
(60, 42, '862273048557193', '0971686624', 1, '0979908789', 'Viettel', 'Hello', 200, 'DONE', 42, '2020-06-05 15:50:02', '2020-06-05 15:49:45'),
(61, 42, '862273048557193', '0971686624', 1, '0356251092', 'Viettel', 'Hello', 200, 'DONE', 42, '2020-06-05 15:50:12', '2020-06-05 15:49:45'),
(62, 43, '862273048557193', '0971686624', 1, '0979908789', 'Viettel', 'Dien Tu Hong Son', 200, 'DONE', 42, '2020-06-05 16:16:41', '2020-06-05 16:16:26'),
(63, 44, '862273048557193', '0971686624', 1, '0979908789', 'Viettel', 'Dien Tu Hong Son', 200, 'DONE', 42, '2020-06-05 16:16:51', '2020-06-05 16:16:27'),
(64, 45, '862273048557193', '0971686624', 1, '0979908789', 'Viettel', 'Dien Tu Hong Son', 200, 'DONE', 42, '2020-06-05 16:17:22', '2020-06-05 16:17:10'),
(65, 46, '862273048557193', '0971686624', 1, '0979908789', 'Viettel', 'Dien Tu Hong Son', 200, 'DONE', 42, '2020-06-06 08:20:18', '2020-06-06 08:20:05'),
(66, 47, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Good Morning', 200, 'DONE', 42, '2020-06-06 08:35:15', '2020-06-06 08:35:04'),
(67, 48, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2020-06-06 08:49:20', '2020-06-06 08:49:10'),
(68, 49, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Dong', 200, 'DONE', 42, '2020-06-06 22:01:56', '2020-06-06 22:01:41'),
(69, 50, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'HEllo', 200, 'DONE', 42, '2020-06-08 10:00:24', '2020-06-08 10:00:04'),
(70, 51, NULL, NULL, 1, '0966624292', 'Viettel', 'Hiii', 200, 'PENDING', 42, NULL, '2020-06-09 10:40:35'),
(71, 52, '862273048557193', '0971686624', 1, '0979908789', 'Viettel', 'Dien Tu Hong Son', 200, 'DONE', 42, '2020-06-13 11:19:56', '2020-06-13 11:19:43'),
(72, 53, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2020-06-13 11:25:26', '2020-06-13 11:25:09'),
(73, 54, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Nguyen Van Dong', 200, 'DONE', 42, '2020-06-22 09:36:53', '2020-06-22 09:36:39'),
(74, 55, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2020-07-03 10:22:45', '2020-07-03 10:22:32'),
(75, 56, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2020-07-18 10:10:20', '2020-07-18 10:10:03'),
(76, 57, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Test thiet bi', 200, 'DONE', 42, '2020-07-29 21:28:43', '2020-07-29 21:28:28'),
(77, 58, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', ':D', 200, 'DONE', 42, '2020-07-30 15:07:42', '2020-07-30 15:07:29'),
(78, 59, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2020-08-13 08:49:58', '2020-08-13 08:49:41'),
(79, 60, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2020-10-13 10:11:05', '2020-10-13 10:10:50'),
(80, 61, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2020-10-26 14:37:55', '2020-10-26 14:30:53'),
(81, 62, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Nguyen Van Dong', 200, 'DONE', 42, '2020-10-26 14:38:06', '2020-10-26 14:36:25'),
(82, 63, '862273048557193', '0971686624', 1, '0966624292', 'Viettel', 'Hello', 200, 'DONE', 42, '2020-11-20 10:16:57', '2020-11-20 10:16:43'),
(83, 64, NULL, NULL, 1, '0966624292', 'Viettel', 'Hello', 200, 'PENDING', 42, NULL, '2021-03-09 15:30:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_transaction`
--

CREATE TABLE `dong_transaction` (
  `transaction_id` int(11) NOT NULL,
  `transaction_user` int(11) NOT NULL COMMENT 'Người Thanh Toán',
  `transaction_items` int(11) NOT NULL COMMENT 'Số Lượng Item',
  `transaction_money` int(11) NOT NULL COMMENT 'Tổng Tiền',
  `transaction_money_before` int(11) NOT NULL COMMENT 'Tiền trước thay đổi',
  `transaction_money_after` int(11) NOT NULL COMMENT 'Tiền sau khi thay đổi',
  `transaction_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'IN / OUT',
  `transaction_user_proccess` int(11) NOT NULL COMMENT 'Người Xử Lý',
  `transaction_note` varchar(2000) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Ghi Chú',
  `transaction_method_payment` int(11) NOT NULL COMMENT 'Phương thức thanh toán',
  `transaction_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Trạng Thái',
  `transaction_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dong_transaction`
--

INSERT INTO `dong_transaction` (`transaction_id`, `transaction_user`, `transaction_items`, `transaction_money`, `transaction_money_before`, `transaction_money_after`, `transaction_type`, `transaction_user_proccess`, `transaction_note`, `transaction_method_payment`, `transaction_status`, `transaction_time`) VALUES
(1, 7, 1, 5000, 0, 5000, 'IN', 1, '<p>Tặng tiền tài khoản mới</p>', 45, 'DONE', '2019-11-20 10:14:50'),
(3, 1, 1, 10000, 0, 10000, 'IN', 1, '<p>Tiền thưởng</p>', 45, 'DONE', '2019-11-20 11:00:24'),
(4, 1, 1, 200, 10000, 9800, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2019-11-20 11:00:47'),
(5, 1, 1, 200, 9800, 9600, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2019-11-20 15:08:05'),
(6, 1, 1, 200, 9600, 9400, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2019-11-20 15:11:18'),
(7, 1, 1, 200, 9400, 9200, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2019-11-21 15:53:41'),
(8, 1, 1, 200, 9200, 9000, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2019-11-21 15:55:58'),
(9, 7, 1, 200000, 5000, 205000, 'IN', 1, '<p>Test</p>', 40, 'DONE', '2019-11-21 16:45:25'),
(10, 1, 1, 100000, 9000, 109000, 'IN', 1, '<p>Test</p>', 45, 'DONE', '2019-11-22 15:17:18'),
(11, 1, 1, 1000, 109000, 110000, 'IN', 1, '', 45, 'DONE', '2019-11-27 10:22:32'),
(12, 1, 1, 200, 110000, 109800, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2019-11-29 11:43:44'),
(13, 1, 1, 200, 109800, 109600, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2019-11-29 15:09:11'),
(14, 1, 1, 200, 109600, 109400, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2019-11-30 10:12:59'),
(15, 1, 2, 400, 109400, 109000, 'OUT', 0, 'Thanh toán phí nhắn tin đến 2 số điện thoại. Giá 400 vnđ', 45, 'DONE', '2019-12-05 14:32:36'),
(16, 1, 1, 200, 109000, 108800, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2019-12-06 15:15:35'),
(17, 7, 1, 150, 205000, 204850, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 150 vnđ', 45, 'DONE', '2019-12-09 16:12:35'),
(18, 1, 1, 200, 108800, 108600, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2019-12-14 13:03:13'),
(19, 1, 1, 200, 108600, 108400, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2019-12-14 15:36:36'),
(20, 1, 24, 4800, 108400, 103600, 'OUT', 0, 'Thanh toán phí nhắn tin đến 24 số điện thoại. Giá 4800 vnđ', 45, 'DONE', '2019-12-17 15:59:58'),
(21, 1, 1, 200, 103600, 103400, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2019-12-18 15:09:17'),
(22, 1, 1, 200, 103400, 103200, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2019-12-18 17:18:32'),
(23, 1, 1, 200, 103200, 103000, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2019-12-18 17:19:21'),
(24, 1, 1, 200, 103000, 102800, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2019-12-18 17:20:12'),
(25, 1, 1, 200, 102800, 102600, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2019-12-18 17:21:24'),
(26, 1, 1, 200, 102600, 102400, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-04 10:00:43'),
(27, 1, 1, 200, 102400, 102200, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-04 10:18:09'),
(28, 1, 1, 200, 102200, 102000, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-04 10:41:54'),
(29, 1, 1, 200, 102000, 101800, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-04 10:43:46'),
(30, 1, 1, 200, 101800, 101600, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-04 10:49:29'),
(31, 1, 1, 200, 101600, 101400, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-04 10:52:44'),
(32, 1, 1, 200, 101400, 101200, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-04 10:59:03'),
(33, 1, 1, 200, 101200, 101000, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-04 11:04:35'),
(34, 1, 1, 200, 101000, 100800, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-04 11:18:34'),
(35, 1, 1, 200, 100800, 100600, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-04 11:54:57'),
(36, 1, 1, 200, 100600, 100400, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-04 11:55:09'),
(37, 1, 1, 200, 100400, 100200, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-04 12:42:49'),
(38, 1, 1, 200, 100200, 100000, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-04 14:04:49'),
(39, 1, 1, 200, 100000, 99800, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-04 20:02:51'),
(40, 1, 1, 200, 99800, 99600, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-05 09:19:02'),
(41, 1, 1, 200, 99600, 99400, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-05 15:42:11'),
(42, 1, 2, 400, 99400, 99000, 'OUT', 0, 'Thanh toán phí nhắn tin đến 2 số điện thoại. Giá 400 vnđ', 45, 'DONE', '2020-06-05 15:49:45'),
(43, 1, 1, 200, 99000, 98800, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-05 16:16:26'),
(44, 1, 1, 200, 98800, 98600, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-05 16:16:27'),
(45, 1, 1, 200, 98600, 98400, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-05 16:17:10'),
(46, 1, 1, 200, 98400, 98200, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-06 08:20:05'),
(47, 1, 1, 200, 98200, 98000, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-06 08:35:04'),
(48, 1, 1, 200, 98000, 97800, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-06 08:49:10'),
(49, 1, 1, 200, 97800, 97600, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-06 22:01:41'),
(50, 1, 1, 200, 97600, 97400, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-08 10:00:04'),
(51, 1, 1, 200, 97400, 97200, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-09 10:40:35'),
(52, 1, 1, 200, 97200, 97000, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-13 11:19:43'),
(53, 1, 1, 200, 97000, 96800, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-13 11:25:09'),
(54, 1, 1, 200, 96800, 96600, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-06-22 09:36:39'),
(55, 1, 1, 200, 96600, 96400, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-07-03 10:22:32'),
(56, 1, 1, 200, 96400, 96200, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-07-18 10:10:03'),
(57, 1, 1, 200, 96200, 96000, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-07-29 21:28:28'),
(58, 1, 1, 200, 96000, 95800, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-07-30 15:07:29'),
(59, 1, 1, 200, 95800, 95600, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-08-13 08:49:41'),
(60, 1, 1, 200, 95600, 95400, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-10-13 10:10:50'),
(61, 1, 1, 200, 95400, 95200, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-10-26 14:30:53'),
(62, 1, 1, 200, 95200, 95000, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-10-26 14:36:25'),
(63, 1, 1, 200, 95000, 94800, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2020-11-20 10:16:43'),
(64, 1, 1, 200, 94800, 94600, 'OUT', 0, 'Thanh toán phí nhắn tin đến 1 số điện thoại. Giá 200 vnđ', 45, 'DONE', '2021-03-09 15:30:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_users`
--

CREATE TABLE `dong_users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_fullname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_address` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `user_phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_company` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `user_note` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `user_money` int(11) DEFAULT 0,
  `user_custom_price` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_role` int(11) NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT 0,
  `user_invite` int(11) DEFAULT NULL,
  `user_token` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `user_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dong_users`
--

INSERT INTO `dong_users` (`user_id`, `user_name`, `user_password`, `user_fullname`, `user_address`, `user_phone`, `user_company`, `user_note`, `user_money`, `user_custom_price`, `user_role`, `user_status`, `user_invite`, `user_token`, `user_time`) VALUES
(1, 'dongnv', 'T2tHMjIxenMxYTRYYlFnTURSaFJpZz09', 'Nguyễn Đông', 'Do Hạ, Tiền Phong, Mê Linh, Hà Nội', '0966624292', 'CITYPOST', '', 94600, 'a:5:{s:7:\"Viettel\";s:3:\"200\";s:8:\"Mobifone\";s:3:\"200\";s:9:\"Vinaphone\";s:3:\"200\";s:7:\"Gmobile\";s:3:\"200\";s:12:\"Vietnamobile\";s:3:\"200\";}', 2, 1, 1, 'L1NZMVRqaFVQY3Z5bzcvRUxOd3RFd09VZWxFNkdsU0ZxcmVCcDZ1TzgyMD0,', '2019-06-07 15:27:32'),
(5, 'dong', 'Nks2Vjl1NSsrRXFacVBWbXVocmV0Zz09', 'Nguyễn Văn Đông', 'Do Hạ, Tiền Phong, Mê Linh, Hà Nội', '0966624292', 'CITYPOST', 'Notes', 0, NULL, 11, 1, 1, 'd0wxVlBPTXdDQUN6MklUTlhSOU9uZz09', '2019-10-11 09:55:12'),
(6, 'thang', 'WGVMWXZOMHJ6eFNUdE1Oa2I5U1Jtdz09', 'Đỗ Văn Thăng', 'Hello', '0966624292', '', 'asdd', 0, NULL, 11, 1, 1, 'Y2M2YlJoaWIyWVBTSUJTNW9EbmdOQT09', '2019-10-17 15:11:04'),
(7, 'hung', 'Nks2Vjl1NSsrRXFacVBWbXVocmV0Zz09', 'Hùng', 'HN', '0988873636', '', '', 204850, NULL, 12, 1, 1, 'eC9ISFFFYjk0ZU9xam1jQ2E5SHZTUT09', '2019-11-20 09:57:24');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `dong_contacts`
--
ALTER TABLE `dong_contacts`
  ADD PRIMARY KEY (`contacts_id`);

--
-- Chỉ mục cho bảng `dong_device`
--
ALTER TABLE `dong_device`
  ADD PRIMARY KEY (`device_id`);

--
-- Chỉ mục cho bảng `dong_metadata`
--
ALTER TABLE `dong_metadata`
  ADD PRIMARY KEY (`metadata_id`);

--
-- Chỉ mục cho bảng `dong_notice`
--
ALTER TABLE `dong_notice`
  ADD PRIMARY KEY (`notice_id`);

--
-- Chỉ mục cho bảng `dong_receive`
--
ALTER TABLE `dong_receive`
  ADD PRIMARY KEY (`receive_id`);

--
-- Chỉ mục cho bảng `dong_sms`
--
ALTER TABLE `dong_sms`
  ADD PRIMARY KEY (`sms_id`);

--
-- Chỉ mục cho bảng `dong_transaction`
--
ALTER TABLE `dong_transaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Chỉ mục cho bảng `dong_users`
--
ALTER TABLE `dong_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `dong_contacts`
--
ALTER TABLE `dong_contacts`
  MODIFY `contacts_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `dong_device`
--
ALTER TABLE `dong_device`
  MODIFY `device_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `dong_metadata`
--
ALTER TABLE `dong_metadata`
  MODIFY `metadata_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `dong_notice`
--
ALTER TABLE `dong_notice`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `dong_receive`
--
ALTER TABLE `dong_receive`
  MODIFY `receive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT cho bảng `dong_sms`
--
ALTER TABLE `dong_sms`
  MODIFY `sms_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT cho bảng `dong_transaction`
--
ALTER TABLE `dong_transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT cho bảng `dong_users`
--
ALTER TABLE `dong_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
