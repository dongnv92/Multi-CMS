-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 12, 2020 lúc 12:26 PM
-- Phiên bản máy phục vụ: 10.1.35-MariaDB
-- Phiên bản PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `multicms`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_meta`
--

CREATE TABLE `dong_meta` (
  `meta_id` int(11) NOT NULL,
  `meta_type` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `meta_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `meta_des` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `meta_url` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `meta_info` text COLLATE utf8_unicode_ci,
  `meta_images` int(11) DEFAULT NULL,
  `meta_sub` int(11) NOT NULL,
  `meta_user` int(11) NOT NULL,
  `meta_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_setting`
--

CREATE TABLE `dong_setting` (
  `setting_id` int(11) NOT NULL,
  `setting_key` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8_unicode_ci NOT NULL,
  `setting_user` int(11) NOT NULL,
  `setting_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dong_setting`
--

INSERT INTO `dong_setting` (`setting_id`, `setting_key`, `setting_value`, `setting_user`, `setting_time`) VALUES
(1, 'logo', 'content/assets/images/system/logo.png', 1, '2020-06-11 10:35:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_user`
--

CREATE TABLE `dong_user` (
  `user_id` int(11) NOT NULL,
  `user_login` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_address` int(11) NOT NULL,
  `user_phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_birthday` date DEFAULT NULL,
  `user_married` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'not' COMMENT 'not/already',
  `user_note` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `user_avatar` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `user_role` int(11) NOT NULL,
  `user_status` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `user_block_time` datetime DEFAULT NULL,
  `user_block_message` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_invite` int(11) DEFAULT NULL,
  `user_token` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `user_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dong_user`
--

INSERT INTO `dong_user` (`user_id`, `user_login`, `user_password`, `user_name`, `user_address`, `user_phone`, `user_email`, `user_gender`, `user_birthday`, `user_married`, `user_note`, `user_avatar`, `user_role`, `user_status`, `user_block_time`, `user_block_message`, `user_invite`, `user_token`, `user_time`) VALUES
(1, 'dongnv', 'T2tHMjIxenMxYTRYYlFnTURSaFJpZz09', 'Nguyễn Văn Đông', 30, '0966624292', 'nguyenvandong242@gmail.com', 'male', '1992-02-24', 'not', '', 'src/uploads/images/2020/04/08/pf1Wn0DX5NVBLrE.jpg', 1, 'block', '2020-06-12 15:00:00', NULL, 1, 'MzNKeDNpTURwbnNDaVRkUnpjeUxaQT09', '2019-06-07 15:27:32');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `dong_meta`
--
ALTER TABLE `dong_meta`
  ADD PRIMARY KEY (`meta_id`);

--
-- Chỉ mục cho bảng `dong_setting`
--
ALTER TABLE `dong_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Chỉ mục cho bảng `dong_user`
--
ALTER TABLE `dong_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `dong_meta`
--
ALTER TABLE `dong_meta`
  MODIFY `meta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `dong_setting`
--
ALTER TABLE `dong_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `dong_user`
--
ALTER TABLE `dong_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
