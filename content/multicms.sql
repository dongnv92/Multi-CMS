-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 14, 2020 lúc 12:22 PM
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
  `meta_parent` int(11) NOT NULL DEFAULT '0',
  `meta_user` int(11) NOT NULL,
  `meta_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dong_meta`
--

INSERT INTO `dong_meta` (`meta_id`, `meta_type`, `meta_name`, `meta_des`, `meta_url`, `meta_info`, `meta_images`, `meta_parent`, `meta_user`, `meta_time`) VALUES
(1, 'role', 'Người sáng lập', 'Người quản trị, sáng lập và điều hành ứng dụng.', '', 'a:2:{s:4:\"user\";a:5:{s:7:\"manager\";b:1;s:3:\"add\";b:1;s:6:\"update\";b:1;s:4:\"role\";b:1;s:6:\"delete\";b:1;}s:4:\"blog\";a:5:{s:7:\"manager\";b:1;s:3:\"add\";b:1;s:6:\"update\";b:1;s:6:\"delete\";b:1;s:8:\"category\";b:1;}}', 0, 0, 1, '2020-06-24 17:13:25'),
(2, 'role', 'Quản trị viên', 'Quản trị viên điều hành ứng dụng', '', 'a:2:{s:4:\"user\";a:5:{s:7:\"manager\";b:1;s:3:\"add\";b:1;s:6:\"update\";b:1;s:4:\"role\";b:0;s:6:\"delete\";b:1;}s:4:\"blog\";a:5:{s:7:\"manager\";b:1;s:3:\"add\";b:1;s:6:\"update\";b:1;s:6:\"delete\";b:1;s:8:\"category\";b:1;}}', 0, 0, 1, '2020-06-24 17:14:52'),
(4, 'role', 'Thành viên', 'Thành viên bình thường', '', 'a:2:{s:4:\"user\";a:5:{s:7:\"manager\";b:0;s:3:\"add\";b:0;s:6:\"update\";b:0;s:4:\"role\";b:0;s:6:\"delete\";b:0;}s:4:\"blog\";a:5:{s:7:\"manager\";b:1;s:3:\"add\";b:0;s:6:\"update\";b:0;s:6:\"delete\";b:0;s:8:\"category\";b:0;}}', 0, 0, 1, '2020-06-26 15:09:13'),
(5, 'blog_category', 'Khác', 'Chuyên mục mặc định', 'khac', '', 0, 0, 1, '2020-07-03 14:00:31'),
(6, 'blog_category', 'Tin tức', '', 'tin-tuc', '', 0, 0, 1, '2020-07-03 14:16:01'),
(10, 'blog_category', 'Công nghệ', 'Tin tức công nghệ', 'cong-nghe', '', 0, 6, 1, '2020-07-08 10:05:45'),
(11, 'blog_category', 'Thời sự', 'Tin tức thời sự', 'thoi-su', '', 0, 6, 1, '2020-07-08 10:30:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_post`
--

CREATE TABLE `dong_post` (
  `post_id` int(11) NOT NULL,
  `post_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'blog',
  `post_title` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `post_content` text COLLATE utf8_unicode_ci NOT NULL,
  `post_keyword` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_short_content` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_category` int(11) NOT NULL,
  `post_url` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `post_user` int(11) NOT NULL,
  `post_status` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `post_view` int(11) NOT NULL DEFAULT '0',
  `post_feature` int(11) NOT NULL,
  `post_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_setting`
--

CREATE TABLE `dong_setting` (
  `setting_id` int(11) NOT NULL,
  `setting_key` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8_unicode_ci NOT NULL,
  `setting_des` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `setting_user` int(11) NOT NULL,
  `setting_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dong_setting`
--

INSERT INTO `dong_setting` (`setting_id`, `setting_key`, `setting_value`, `setting_des`, `setting_user`, `setting_time`) VALUES
(1, 'logo', 'content/assets/images/system/logo.png', 'Đường dẫn Logo Website', 1, '2020-06-11 10:35:00'),
(2, 'role_special', '1', 'ID phân quyền đặc biệt, không thể xoá', 1, '2020-06-26 15:12:00'),
(3, 'role_default', '4', 'ID Phân quyền mặc định, không thể xoá', 1, '2020-06-26 15:13:00'),
(4, 'user_special', '1', 'ID Người dùng đặc biệt, không thể xoá', 1, '2020-06-30 10:34:00'),
(5, 'blog_category_default', '5', 'ID chuyên mục bài viết đặc biệt, không thể xoá.', 1, '2020-07-09 11:37:00');

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
(1, 'dongnv', 'T2tHMjIxenMxYTRYYlFnTURSaFJpZz09', 'Đông Nguyễn', 30, '0966624292', 'nguyenvandong242@gmail.com', 'male', '1992-02-24', 'not', '', 'content/uploads/avatar/1/2020/07/01/GPuMmWAtIzQCVNn.jpg', 1, 'active', '2020-06-12 15:00:00', NULL, 1, 'MzNKeDNpTURwbnNDaVRkUnpjeUxaQT09', '2019-06-07 15:27:32'),
(2, 'admin', 'T2tHMjIxenMxYTRYYlFnTURSaFJpZz09', 'ADMIN', 0, '', '', '', '0000-00-00', '', '', '', 2, 'active', '0000-00-00 00:00:00', '', 0, 'blUzdmtoNUxzanBvQjJDNFhZWVVhQT09', '2020-06-29 14:56:41');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `dong_meta`
--
ALTER TABLE `dong_meta`
  ADD PRIMARY KEY (`meta_id`);

--
-- Chỉ mục cho bảng `dong_post`
--
ALTER TABLE `dong_post`
  ADD PRIMARY KEY (`post_id`);

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
  MODIFY `meta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `dong_post`
--
ALTER TABLE `dong_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `dong_setting`
--
ALTER TABLE `dong_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `dong_user`
--
ALTER TABLE `dong_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
