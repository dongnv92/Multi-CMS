-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 25, 2021 lúc 05:16 PM
-- Phiên bản máy phục vụ: 10.1.36-MariaDB
-- Phiên bản PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `cms`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_code`
--

CREATE TABLE `dong_code` (
  `code_id` int(11) NOT NULL COMMENT 'Id',
  `code_title` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tiêu đề',
  `code_category` int(10) NOT NULL COMMENT 'Chuyên mục',
  `code_content` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nội dung',
  `code_price` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Giá',
  `code_user` int(5) NOT NULL COMMENT 'Người đăng',
  `code_approval` int(5) NOT NULL COMMENT 'Người duyệt',
  `code_demo` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_status` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Trạng thái',
  `code_create` datetime NOT NULL COMMENT 'Thời gian dăng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `dong_code`
--
ALTER TABLE `dong_code`
  ADD PRIMARY KEY (`code_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `dong_code`
--
ALTER TABLE `dong_code`
  MODIFY `code_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
