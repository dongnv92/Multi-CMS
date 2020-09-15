-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 27, 2020 lúc 12:14 PM
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
-- Cấu trúc bảng cho bảng `dong_customer`
--

CREATE TABLE `dong_customer` (
  `customer_id` int(11) NOT NULL,
  `customer_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'customer',
  `customer_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `customer_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `customer_phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `customer_address` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `customer_email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `customer_user` int(11) NOT NULL,
  `customer_status` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'active',
  `customer_time` datetime NOT NULL,
  `customer_last_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dong_customer`
--

INSERT INTO `dong_customer` (`customer_id`, `customer_type`, `customer_code`, `customer_name`, `customer_phone`, `customer_address`, `customer_email`, `customer_user`, `customer_status`, `customer_time`, `customer_last_update`) VALUES
(1, 'customer', 'CUS1595820308', 'Nguyễn Hồng Viên', '0979908789', 'phố Yên, Tiền Phong, Mê Linh, Hà Nội', '', 1, 'active', '2020-07-27 10:25:08', '2020-07-29 14:50:14'),
(2, 'partner', 'CUS1595990091', 'Nguyễn Văn Đông', '0966624292', 'Do Hạ, Tiền Phong, Mê Linh, Hà Nội', 'nguyenvandong242@gmail.com', 1, 'active', '2020-07-29 09:34:51', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_files`
--

CREATE TABLE `dong_files` (
  `file_id` int(11) NOT NULL,
  `file_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Kiểu lưu trữ',
  `file_path` varchar(1000) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Đường Dẫn File',
  `file_name` varchar(1000) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tên File',
  `file_extension` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Kiểu File',
  `file_size` int(11) NOT NULL COMMENT 'Kích Thước File',
  `file_attackment` int(11) NOT NULL COMMENT 'Đính kèm ở đâu',
  `file_download` int(11) NOT NULL DEFAULT '0',
  `file_user` int(11) NOT NULL COMMENT 'người upload',
  `file_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dong_files`
--

INSERT INTO `dong_files` (`file_id`, `file_type`, `file_path`, `file_name`, `file_extension`, `file_size`, `file_attackment`, `file_download`, `file_user`, `file_time`) VALUES
(1, 'product', 'content/uploads/product/7IfByz2n3mvXGHe.jpg', '7IfByz2n3mvXGHe.jpg', 'jpg', 185511, 1, 0, 1, '2020-08-27 15:29:50'),
(2, 'product', 'content/uploads/product/_364CecSXipnaFy.jpg', '_364CecSXipnaFy.jpg', 'jpg', 186352, 1, 0, 1, '2020-08-27 15:29:50'),
(3, 'product', 'content/uploads/product/I6f0PevdwKBHMog.jpg', 'I6f0PevdwKBHMog.jpg', 'jpg', 146153, 1, 0, 1, '2020-08-27 15:29:50'),
(4, 'product', 'content/uploads/product/5fVRFYOUl2ruv_4.jpg', '5fVRFYOUl2ruv_4.jpg', 'jpg', 184562, 1, 0, 1, '2020-08-27 15:29:50');

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
  `meta_image` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_parent` int(11) NOT NULL DEFAULT '0',
  `meta_user` int(11) NOT NULL,
  `meta_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dong_meta`
--

INSERT INTO `dong_meta` (`meta_id`, `meta_type`, `meta_name`, `meta_des`, `meta_url`, `meta_info`, `meta_image`, `meta_parent`, `meta_user`, `meta_time`) VALUES
(1, 'role', 'Người sáng lập', 'Người quản trị, sáng lập và điều hành ứng dụng.', 'nguoi-sang-lap', 'a:6:{s:4:\"user\";a:5:{s:7:\"manager\";b:1;s:3:\"add\";b:1;s:6:\"update\";b:1;s:4:\"role\";b:1;s:6:\"delete\";b:1;}s:4:\"blog\";a:5:{s:7:\"manager\";b:1;s:3:\"add\";b:1;s:6:\"update\";b:1;s:6:\"delete\";b:1;s:8:\"category\";b:1;}s:6:\"plugin\";a:1:{s:7:\"manager\";b:1;}s:8:\"customer\";a:4:{s:7:\"manager\";b:1;s:3:\"add\";b:1;s:6:\"update\";b:1;s:6:\"delete\";b:1;}s:4:\"momo\";a:1:{s:7:\"manager\";b:1;}s:7:\"product\";a:6:{s:7:\"manager\";b:1;s:3:\"add\";b:1;s:6:\"update\";b:1;s:8:\"category\";b:1;s:5:\"brand\";b:1;s:6:\"delete\";b:1;}}', '', 0, 1, '2020-06-24 17:13:25'),
(2, 'role', 'Quản trị viên', 'Quản trị viên điều hành ứng dụng', '', 'a:3:{s:4:\"user\";a:5:{s:7:\"manager\";b:1;s:3:\"add\";b:1;s:6:\"update\";b:1;s:4:\"role\";b:0;s:6:\"delete\";b:1;}s:4:\"blog\";a:5:{s:7:\"manager\";b:1;s:3:\"add\";b:1;s:6:\"update\";b:1;s:6:\"delete\";b:1;s:8:\"category\";b:1;}s:8:\"customer\";a:4:{s:7:\"manager\";b:1;s:3:\"add\";b:1;s:6:\"update\";b:1;s:6:\"delete\";b:1;}}', '', 0, 1, '2020-06-24 17:14:52'),
(4, 'role', 'Thành viên', 'Thành viên bình thường', '', 'a:2:{s:4:\"user\";a:5:{s:7:\"manager\";b:0;s:3:\"add\";b:0;s:6:\"update\";b:0;s:4:\"role\";b:0;s:6:\"delete\";b:0;}s:4:\"blog\";a:5:{s:7:\"manager\";b:1;s:3:\"add\";b:0;s:6:\"update\";b:0;s:6:\"delete\";b:0;s:8:\"category\";b:0;}}', '', 0, 1, '2020-06-26 15:09:13'),
(5, 'blog_category', 'Khác', 'Chuyên mục mặc định', 'khac', '', '', 0, 1, '2020-07-03 14:00:31'),
(6, 'blog_category', 'Tin tức', '', 'tin-tuc', '', '', 0, 1, '2020-07-03 14:16:01'),
(10, 'blog_category', 'Công nghệ', 'Tin tức công nghệ', 'cong-nghe', '', '', 6, 1, '2020-07-08 10:05:45'),
(11, 'blog_category', 'Thời sự', 'Tin tức thời sự', 'thoi-su', '', '', 6, 1, '2020-07-08 10:30:43'),
(12, 'product_category', 'Điện tử', 'Chuyên đồ điện tử', 'dien-tu', '', '', 0, 1, '2020-07-30 17:39:06'),
(14, 'product_category', 'Camera IP', 'Chuyên Camera IP', 'camera-ip', '', '', 12, 1, '2020-07-30 20:48:11'),
(25, 'product_brand', 'SAMSUNG', 'SAMSUNG', 'samsung', '', 'content/uploads/brand/GVBr4p5SlR8cE92.png', 0, 1, '2020-07-30 23:08:06'),
(26, 'product_category', 'Điện Thoại', 'Điện Thoại', 'dien-thoai', '', 'content/assets/images/system/noimage.jpg', 0, 1, '2020-08-27 15:30:20'),
(27, 'product_category', 'Iphone', 'Điện thoại Iphone', 'iphone', '', 'content/assets/images/system/noimage.jpg', 26, 1, '2020-08-27 15:30:42'),
(28, 'product_brand', 'Apple', 'Apple', 'apple', '', 'content/uploads/brand/tWJKMi01IZgFRvO.png', 0, 1, '2020-08-27 15:31:49');

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
  `post_images` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `post_user` int(11) NOT NULL,
  `post_status` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `post_view` int(11) NOT NULL DEFAULT '0',
  `post_feature` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `post_time` datetime NOT NULL,
  `post_last_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dong_post`
--

INSERT INTO `dong_post` (`post_id`, `post_type`, `post_title`, `post_content`, `post_keyword`, `post_short_content`, `post_category`, `post_url`, `post_images`, `post_user`, `post_status`, `post_view`, `post_feature`, `post_time`, `post_last_update`) VALUES
(1, 'blog', 'Bài viết đầu tiên cx', '<p>Bài viết đầu tiên<br></p>', 'Bài viết đầu tiên', 'Bài viết đầu tiên', 5, 'bai-viet-dau-tien', 'content/uploads/post/2020/07/17/kCfR92W605SLvzb.png', 1, 'public', 0, 'true', '2020-07-17 15:52:33', NULL),
(2, 'blog', 'Bài viết thứ 2', '<p>Bài viết thứ 2 d<br></p>', 'Bài viết thứ 2', 'Bài viết thứ 2', 5, 'bai-viet-thu', 'content/uploads/post/2020/07/17/M196aB0LWzgqscQ.jpg', 1, 'public', 0, 'true', '2020-07-17 15:52:57', NULL),
(3, 'blog', 'Bài viết thứ 3', '<p>Bài viết thứ 3</p><p>Bài viết thứ 3</p><hr><p>Bài viết thứ 3<br></p><hr><p>Bài viết thứ 3</p><hr><p>Bài viết thứ 3</p><hr><p>Bài viết thứ 3</p><p><br></p>', 'fasgds', 'hdfhujdfjdfgj', 5, 'bai-viet-thu-3', 'content/uploads/post/2020/07/20/e0DUIyARm7XJ_iN.png', 1, 'public', 0, 'false', '2020-07-20 17:23:54', '2020-07-20 17:25:25'),
(4, 'blog', 'Thứ trưởng Y tế: Nhiều bệnh nhân Covid-19 nặng', '<p class=\"description\" style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-rendering: optimizelegibility; font-size: 18px; line-height: 28.8px; color: rgb(34, 34, 34); font-family: arial; background-color: rgb(252, 250, 246);\">Thứ trưởng Bộ Y tế Nguyễn Trường Sơn cho biết hiện ngành y tế vẫn kiểm soát được dịch bệnh, song có những bệnh nhân nặng cần tập trung điều trị.</p><article class=\"fck_detail \" style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility; width: 670px; float: left; position: relative; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 18px; line-height: 28.8px; font-family: arial; color: rgb(34, 34, 34); background-color: rgb(252, 250, 246);\"><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Bệnh nhân Covid-19 nặng, giai đoạn này, chủ yếu là người cao tuổi, có bệnh nền hoặc bệnh nhân chạy thận nhân tạo ở Bệnh viện Đà Nẵng.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Sáu bệnh nhân được ghi nhận trong tình trạng nặng là 416, 418, 436, 438, 437, 433. Trong đó, hai ca 416 và 437 đã phải can thiệp ECMO - hệ thống tuần hoàn oxy ngoài cơ thể, còn gọi là tim phổi nhân tạo. Một số bệnh nhân được chuyển đến Bệnh viện Trung ương Huế, giảm bớt gánh nặng cho Đà Nẵng.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">\"Họ hầu hết có những biến chứng về hô hấp, tim mạch, nhiễm trùng\", Thứ trưởng Sơn nói với&nbsp;<em style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility;\">VnExpress</em>, trưa 30/7.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Theo ông Sơn, toàn ngành y tế đang tập trung cả về nhân lực và trang thiết bị để hỗ trợ Đà Nẵng cũng như các địa phương có dịch, từ kiểm soát dịch bệnh cho đến điều trị bệnh nhân.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Bộ Y tế đã cử 6 đội công tác đặc biệt gồm các chuyên gia hàng đầu đến Đà Nẵng hỗ trợ chống Covid-19. Các đội gồm những chuyên gia có kinh nghiệm trong việc điều tra dịch tễ, cách ly, điều trị và xét nghiệm. Các nhóm bác sĩ của Bệnh viện Chợ Rẫy, Bệnh viện Bạch Mai cũng đã có mặt ở Đà Nẵng để điều trị bệnh nhân nặng.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Trước bối cảnh lây nhiễm nCoV cộng đồng nhanh chóng, cùng việc đón công dân nước ngoài về, có cả những người dương tính, khiến số lượng bệnh nhân nhiều, ông Sơn cho biết lúc này,<strong style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility;\">&nbsp;hệ thống y tế vẫn đủ năng lực chống đỡ</strong>. Khả năng thu dung cách ly và điều trị vẫn đáp ứng. Giai đoạn trước, Bộ Y tế đã xây dựng kịch bản tiếp nhận và điều trị hơn 3.000 bệnh nhân nhiễm nCoV. Tuy nhiên, tùy vào tình hình dịch bệnh cũng như số lượng bệnh nhân mà kế hoạch đón công dân về nước có thể thay đổi. Việc này quyết định bởi Ban chỉ đạo quốc gia, Thủ tướng.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Về trang thiết bị y tế, hiện ngành có khoảng 7.000 máy thở ở các bệnh viện. Các máy ECMO vẫn đủ để điều trị trong giai đoạn hiện tại. Ngành y tế đã có kế hoạch mua thêm máy ECMO, đặt ở các bệnh viện lớn để điều trị bệnh nhân nặng. Số lượng giường bệnh đảm bảo cho việc cách ly và điều trị bệnh nhân.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Việt Nam có 90.000 bác sĩ, 125.000 điều dưỡng. Hầu hết bác sĩ được đào tạo đa khoa, có thể huy động cho phòng dịch khi cần.</p><figure data-size=\"true\" itemprop=\"associatedMedia image\" itemscope=\"\" itemtype=\"http://schema.org/ImageObject\" class=\"tplCaption action_thumb_added\" style=\"margin-right: auto; margin-bottom: 15px; margin-left: auto; padding: 0px; text-rendering: optimizelegibility; max-width: 100%; clear: both; position: relative; text-align: center; width: 670px; float: left;\"><div class=\"fig-picture\" style=\"margin: 0px; padding: 0px 0px 443.375px; text-rendering: optimizelegibility; width: 670px; float: left; display: table; justify-content: center; background: rgb(240, 238, 234); position: relative;\"><picture style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility;\"><source data-srcset=\"https://i1-suckhoe.vnecdn.net/2020/07/30/1-8429-1596087003.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=ah2Dx7siPr1JOIYK521JJg 1x, https://i1-suckhoe.vnecdn.net/2020/07/30/1-8429-1596087003.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=nTQ-o5KulONxQaNS5Bos7Q 1.5x, https://i1-suckhoe.vnecdn.net/2020/07/30/1-8429-1596087003.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=P7_WI-OEu2STG2pNGdG54Q 2x\" srcset=\"https://i1-suckhoe.vnecdn.net/2020/07/30/1-8429-1596087003.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=ah2Dx7siPr1JOIYK521JJg 1x, https://i1-suckhoe.vnecdn.net/2020/07/30/1-8429-1596087003.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=nTQ-o5KulONxQaNS5Bos7Q 1.5x, https://i1-suckhoe.vnecdn.net/2020/07/30/1-8429-1596087003.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=P7_WI-OEu2STG2pNGdG54Q 2x\" style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility;\"><img itemprop=\"contentUrl\" loading=\"lazy\" intrinsicsize=\"680x0\" alt=\"hứ trưởng Y tế Nguyễn Trường Sơn. Ảnh:Ngọc Thành.\" class=\"lazy lazied\" src=\"https://i1-suckhoe.vnecdn.net/2020/07/30/1-8429-1596087003.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=ah2Dx7siPr1JOIYK521JJg\" data-src=\"https://i1-suckhoe.vnecdn.net/2020/07/30/1-8429-1596087003.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=ah2Dx7siPr1JOIYK521JJg\" data-ll-status=\"loaded\" style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility; border: 0px; font-size: 0px; line-height: 0; max-width: 100%; position: absolute; top: 0px; left: 0px; max-height: 700px; width: 670px;\"></picture></div><figcaption itemprop=\"description\" style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility; width: 670px; float: left; text-align: left;\"><p class=\"Image\" style=\"margin-right: 0px; margin-left: 0px; padding: 10px 0px 0px; text-rendering: optimizespeed; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 14px; line-height: 22.4px;\">Thứ trưởng Y tế Nguyễn Trường Sơn. Ảnh:&nbsp;<em style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility;\">Ngọc Thành.</em></p></figcaption></figure><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\"><strong style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility;\">Hiện nay, tình hình dịch bệnh phức tạp hơn,&nbsp;</strong>các ca lây nhiễm cộng đồng liên tục được ghi nhận. Phó giáo sư Lương Ngọc Khuê, Cục trưởng Quản lý Khám chữa bệnh, Bộ Y tế, đề nghị các bệnh viện tuyệt đối tuân thủ quy trình tiếp nhận, sàng lọc, phân luồng, cách ly người bệnh, điều trị, chống nhiễm khuẩn... Các bệnh viện phải có kế hoạch dự phòng tình huống đông bệnh nhân, thực hiện phân tuyến điều trị, giảm thiểu tử vong, hỗ trợ chuyên môn cho Đà Nẵng điều trị bệnh nhân nặng.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">\"Các bệnh viện tuyệt đối không được chủ quan, lơ là dù chỉ một phút trong điều trị Covid-19, bởi căn bệnh này rất nguy hiểm, lơ là một chút là bệnh nhân có thể diễn biến xấu rất nhanh. Chúng ta phải nỗ lực cao nhất, không để bệnh nhân tử vong\", ông Khuê nói.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Khi có các yếu tố dịch tễ nghi ngờ, nhân viên y tế phải trang bị ngay phương tiện phòng hộ cá nhân để phòng ngừa lây nhiễm.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">\"Cuộc chiến phòng chống Covid-19 còn dài, phía trước còn rất nhiều thách thức. Đầu tiên chúng ta phải bảo vệ các bác sĩ và nhân viên y tế, để còn có người điều trị cho bệnh nhân\", ông Khuê nhấn mạnh.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Bên cạnh đó, các bệnh viện, khoa phòng tiếp tục đảm bảo thông khí, bám sát hướng dẫn chẩn đoán và phác đồ điều trị của Bộ Y tế.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Tính đến trưa nay, Việt Nam ghi nhận 459 ca nhiễm, trong đó 369 người đã khỏi, còn 90 bệnh nhân đang điều trị.</p></article>', '', '', 11, 'thu-truong-y-te-nhieu-benh-nhan-covid-19-nang', 'content/uploads/post/2020/07/30/VxpL82W6CabyIGK.jpg', 1, 'public', 0, 'true', '2020-07-30 13:51:43', '2020-07-30 13:58:13'),
(5, 'blog', 'Hàng quán tính kế \'sinh tồn\' trong đợt dịch mới', '<p class=\"description\" style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-rendering: optimizelegibility; font-size: 18px; line-height: 28.8px; color: rgb(34, 34, 34); font-family: arial; background-color: rgb(252, 250, 246);\">Đợt cách ly xã hội tháng 4 đã cho các doanh nghiệp F&amp;B nhiều bài học nhưng lần này, họ thú thật \"chưa mong muốn sớm học lại chúng\".</p><article class=\"fck_detail \" style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility; width: 670px; float: left; position: relative; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 18px; line-height: 28.8px; font-family: arial; color: rgb(34, 34, 34); background-color: rgb(252, 250, 246);\"><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Hoàng Tiễn, Đồng sáng lập kiêm CEO chuỗi Coffee Bike, nói anh rất \"ngán\" nếu dịch thực sự quay lại. \"Những ngày giãn cách xã hội trước đây cho tôi rất nhiều bài học về sự khó khăn. Nhưng thật lòng tôi không muốn học lại bài ấy lần nữa\", Hoàng Tiễn chia sẻ.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Tâm trạng của Hoàng Tiễn không lạ trong giới kinh doanh F&amp;B, khi các ca dương tính Covid-19 mới xuất hiện trong cộng đồng những ngày gần đây... Nhiều khả năng, ngành này sẽ bước vào cuộc chiến \"sinh tồn\" mới. Ở đó, những người \"sống sót\" qua đợt bùng phát đầu năm cũng chỉ mới khôi phục hoạt động bình thường hơn 2 tháng, một số có doanh thu còn chưa về được mức trước dịch.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Tại chuỗi cửa hàng và điểm bán có chỗ ngồi lại của Coffee Bike, doanh thu giảm đều 15-20% sau dịch. Tuy nhiên, mô hình nhượng quyền cà phê pha máy mang đi thì tăng trưởng mạnh về điểm bán và đơn hàng. \"Có thể sau dịch mọi người đang thắt chặt chi tiêu và cũng hạn chế đến nơi đông người\", Tiễn nói.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">89’s Presso, một cửa hàng đồ uống và thức ăn nhẹ ở quận 1, TP HCM chỉ mới khôi phục được kinh doanh bằng một nửa trước khi có dịch. \"Chúng tôi khá lo lắng vì các hoạt động kinh doanh vừa được mở lại không lâu\", Người đại diện của 89’s Presso nói phải chuẩn bị tâm lý cho khả năng phải giãn cách xã hội trở lại và biết tình hình kinh doanh sẽ ảnh hưởng rất nhiều.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Nhà hàng Kin Đee - Thai Gastropub (quận 1, TP HCM) vừa khôi phục được phong độ hoàn toàn so với bình thường trước khi có dịch vào tháng này. Anh Nam Khuất, chủ nhà hàng nói khá lo ngại về những ca dương tính những ngày qua dù đã chuẩn bị tinh thần về khả năng có đợt dịch mới bùng phát.</p><figure data-size=\"true\" itemprop=\"associatedMedia image\" itemscope=\"\" itemtype=\"http://schema.org/ImageObject\" class=\"tplCaption action_thumb_added\" style=\"margin-right: auto; margin-bottom: 15px; margin-left: auto; padding: 0px; text-rendering: optimizelegibility; max-width: 100%; clear: both; position: relative; text-align: center; width: 670px; float: left;\"><div class=\"fig-picture\" style=\"margin: 0px; padding: 0px 0px 446.656px; text-rendering: optimizelegibility; width: 670px; float: left; display: table; justify-content: center; background: rgb(240, 238, 234); position: relative;\"><picture style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility;\"><source data-srcset=\"https://i1-kinhdoanh.vnecdn.net/2020/07/29/sai-gon-vang-ve-16-1596020658-9528-1596021262.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=HuYi4e93BvAIw5fIZpTXHg 1x, https://i1-kinhdoanh.vnecdn.net/2020/07/29/sai-gon-vang-ve-16-1596020658-9528-1596021262.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=2GAdm5WFDLJds1mGV0daTA 1.5x, https://i1-kinhdoanh.vnecdn.net/2020/07/29/sai-gon-vang-ve-16-1596020658-9528-1596021262.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=Z8qloskSHdhPp3Oe-2BtYw 2x\" srcset=\"https://i1-kinhdoanh.vnecdn.net/2020/07/29/sai-gon-vang-ve-16-1596020658-9528-1596021262.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=HuYi4e93BvAIw5fIZpTXHg 1x, https://i1-kinhdoanh.vnecdn.net/2020/07/29/sai-gon-vang-ve-16-1596020658-9528-1596021262.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=2GAdm5WFDLJds1mGV0daTA 1.5x, https://i1-kinhdoanh.vnecdn.net/2020/07/29/sai-gon-vang-ve-16-1596020658-9528-1596021262.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=Z8qloskSHdhPp3Oe-2BtYw 2x\" style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility;\"><img itemprop=\"contentUrl\" loading=\"lazy\" intrinsicsize=\"680x0\" alt=\"Một con phố với nhiều cửa hàng ăn uống vắng vẻ, thậm chí trả mặt bằng trong đợt cách ly xã hội trước tại TP HCM. Ảnh: Quỳnh Trần\" class=\"lazy lazied\" src=\"https://i1-kinhdoanh.vnecdn.net/2020/07/29/sai-gon-vang-ve-16-1596020658-9528-1596021262.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=HuYi4e93BvAIw5fIZpTXHg\" data-src=\"https://i1-kinhdoanh.vnecdn.net/2020/07/29/sai-gon-vang-ve-16-1596020658-9528-1596021262.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=HuYi4e93BvAIw5fIZpTXHg\" data-ll-status=\"loaded\" style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility; border: 0px; font-size: 0px; line-height: 0; max-width: 100%; position: absolute; top: 0px; left: 0px; max-height: 700px; width: 670px;\"></picture></div><figcaption itemprop=\"description\" style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility; width: 670px; float: left; text-align: left;\"><p class=\"Image\" style=\"margin-right: 0px; margin-left: 0px; padding: 10px 0px 0px; text-rendering: optimizespeed; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 14px; line-height: 22.4px;\">Một con phố với nhiều cửa hàng ăn uống vắng vẻ, thậm chí trả mặt bằng trong đợt cách ly xã hội trước tại TP HCM.&nbsp;<em style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility;\">Ảnh: Quỳnh Trần.</em></p></figcaption></figure><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Ông Hoàng Tùng, CEO chuỗi Pizza Home, một chuyên gia trong ngành F&amp;B nhận định, có khả năng ngành này phải đối mặt với đợt khủng hoảng tiếp theo do Covid-19.&nbsp;<span style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility; color: rgb(44, 62, 80);\"><strong style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility;\">Tuy nhiên, vẫn có 2 mặt tích cực.</strong></span></p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\"><em style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility;\">Thứ nhất</em>, sức mua của người dân vẫn mạnh và đặc biệt là công tác chống dịch được chính phủ thực hiện tốt, biểu hiện là ngay sau đợt cách ly xã hội lần trước, kinh tế phục hồi nhanh.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\"><em style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility;\">Thứ hai</em>, mỗi đợt khủng hoảng là một cuộc thanh lọc. \"Tôi nghĩ những doanh nghiệp đã trụ được đến hiện tại thì đều có sức mạnh và tích lũy tốt. Khó khăn trước đây ngành F&amp;B đã vượt qua được thì đợt tới tôi nghĩ doanh nghiệp sẽ vẫn tìm cách để có hướng đi và vượt bão thành công\", ông Tùng đánh giá.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\"><span style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility; color: rgb(44, 62, 80);\"><strong style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility;\">Thực tế, nhiều đơn vị đang tất bật lên kế hoạch \"sinh tồn\" lần hai, nếu cách ly xã hội diễn ra.</strong></span>&nbsp;Phần lớn biện pháp tương tự, được rút từ lần bùng phát dịch trước đó.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Ông Tùng vẫn trung thành với công thức 3 bước: Cắt - Giảm - Tăng, tức là cắt các điểm bán không hiệu quả; giảm chi phí trong sản xuất và giá thuê mặt bằng; tăng bán hàng qua ứng dụng và ra mắt sản phẩm mới, phù hợp nhu cầu.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">\"Lần này chúng tôi đã có kinh nghiệm ứng phó, những dịch chuyển cần thiết cũng đã làm xong và mô hình kinh doanh cũng đã tối ưu hơn\", ông nói đã cho bộ phận kho hàng chuẩn bị sẵn nguyên liệu để có thể đảm bảo giá thành sản phẩm.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Tương tự, 89’s Presso hay Kin Đee - Thai Gastropub nói đã có kinh nghiệm ứng phó hơn. Anh Nam Khuất cho biết nếu giãn cách xã hội trở lại, anh sẽ thương lượng lại tiền thuê mặt bằng, giảm giờ làm nhân viên toàn thời gian và giảm số lượng nhân viên bán thời gian và chuyển sang mô hình giao hàng với thực đơn mới phù hợp với nhu cầu và đảm bảo chất lượng mang đi.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">\"Nhân viên lẫn khách hàng đều đã quen với việc phòng chống dịch, nên cũng dễ dàng hơn, giờ có chỉ thị thì chúng tôi sẽ kích hoạt ngay các bước. Chỉ có điều về mặt kinh doanh chắc sẽ vẫn khó khăn nhiều\", phía 89’s Presso nói.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Hoàng Tiễn thì chọn phương pháp \"án binh bất động\", ưu tiên phòng thủ. \"Trong dịch bệnh, mình muốn xoay xở cho mọi việc tốt hơn nhưng dịch có nhiều yếu tố bất ngờ, nên tôi thấy cần nghỉ ngơi ngay từ đầu\", Tiễn nói. Anh từng thấy một bức ảnh con rắn quấn quanh lưỡi cưa, càng cựa quậy thì vết thương càng lớn. Nó giống những gì anh cảm nhận trong tình huống này.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Tuy nhiên, anh nói thêm rằng, nhiều bạn bè kinh doanh cũng thành công bằng việc bán hàng qua ứng dụng giao hàng, nên các đơn vị có thể cân nhắc quyết định nghỉ hẳn việc bán hàng trực tiếp và chuyển cửa hàng lên online hoàn toàn.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\"><span style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility; color: rgb(44, 62, 80);\"><strong style=\"margin: 0px; padding: 0px; text-rendering: optimizelegibility;\">Bên cạnh tự thân tìm hướng xoay xở, giới F&amp;B cho rằng họ cũng cần sự hỗ trợ từ cơ quan quản lý.</strong></span>&nbsp;Các chủ nhà hàng, quán ăn, tiệm đồ uống hiểu diễn biến phức tạp và yếu tố bất ngờ cao, nên đội ngũ điều hành chống dịch của nhà nước rất khó đưa ra hướng dẫn chi tiết cho từng ngành nghề. Nhưng nếu có thể, các văn bản hướng dẫn cần được chi tiết hơn.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">\"Dịp dịch bệnh vừa qua, khi nhận được các văn bản thông báo, tâm lý chung các cửa hàng là chưa hiểu nội dung cần phải thực hiện, dẫn đến lúng túng, đôi khi là thực hiện sai\", một đơn vị cho biết.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Thời gian công bố giãn cách xã hội cũng cần sớm hơn để các đơn vị kịp chuẩn bị, nêu rõ mô hình F&amp;B nào được hoạt động ra sao. \"Lần trước khi có thông báo các nhà hàng phải đóng cửa thì ngay 6h chiều hôm đó là có hiệu lực luôn rồi\", anh Nam Khuất chia sẻ.</p><p class=\"Normal\" style=\"margin-right: 0px; margin-bottom: 1em; margin-left: 0px; padding: 0px; text-rendering: optimizespeed; line-height: 28.8px;\">Còn theo Hoàng Tiễn, để triệt tiêu khả năng lây lan qua hành vi mua bán trực tiếp, có thể cho chuyển đổi ngay lập tức từ ăn uống tại chỗ sang bán mang đi hoặc giao hàng thay vì qui định ngồi 20 người, 10 người hay 2 người. \"Cửa hàng cố gắng hoạt động trong tình trạng như thế, không giúp tình hình kinh doanh tốt hơn. Mà nguy cơ lây lan dịch bệnh lại rất lớn\", anh góp ý.</p></article>', '', '', 11, 'hang-quan-tinh-ke-sinh-ton-trong-dot-dich-moi', 'content/uploads/post/2020/07/30/2C5oVzIs7bclthO.jpg', 1, 'public', 0, 'true', '2020-07-30 14:00:23', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_product`
--

CREATE TABLE `dong_product` (
  `product_id` int(11) NOT NULL,
  `product_barcode` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Mã Sản Phẩm',
  `product_sku` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_url` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(1000) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tên Sản Phẩm',
  `product_short_content` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Mô Tả Ngắn',
  `product_content` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nội dung sản phẩm',
  `product_hashtag` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_category` int(5) NOT NULL COMMENT 'Chuyên mục sản phẩm',
  `product_image` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_brand` int(5) DEFAULT NULL COMMENT 'Thương hiệu',
  `product_price` int(11) NOT NULL DEFAULT '0' COMMENT 'Giá sản phẩm',
  `product_price_sale` int(11) DEFAULT NULL COMMENT 'Giá khuyến mãi',
  `product_sale_percent` int(3) DEFAULT '0',
  `product_price_buy` int(11) DEFAULT NULL COMMENT 'Giá nhập vào',
  `product_price_vat` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_quantity` int(11) DEFAULT '0' COMMENT 'Số lượng',
  `product_user` int(11) NOT NULL COMMENT 'Người thêm sản phẩm',
  `product_featured` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '1: Nổi bật / 0: Không',
  `product_status` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '1: Hiện / 2: Ẩn',
  `product_instock` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'instock' COMMENT 'instock: Còn hàng / outofstock: Hết Hàng',
  `product_unit` int(5) DEFAULT NULL COMMENT 'Đơn vị',
  `product_time` datetime NOT NULL COMMENT 'Ngày thêm sản phẩm',
  `product_last_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dong_product`
--

INSERT INTO `dong_product` (`product_id`, `product_barcode`, `product_sku`, `product_url`, `product_name`, `product_short_content`, `product_content`, `product_hashtag`, `product_category`, `product_image`, `product_brand`, `product_price`, `product_price_sale`, `product_sale_percent`, `product_price_buy`, `product_price_vat`, `product_quantity`, `product_user`, `product_featured`, `product_status`, `product_instock`, `product_unit`, `product_time`, `product_last_update`) VALUES
(1, '8881598516741', 'APPLEIPHONEX64', 'dien-thoai-iphone-x-64gb', 'Điện thoại iPhone X 64GB', '<h2 style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 20px; line-height: 1.3em; font-family: Helvetica, Arial, \"DejaVu Sans\", \"Liberation Sans\", Freesans, sans-serif; color: rgb(51, 51, 51); outline: none; zoom: 1; overflow: hidden;\"><font color=\"#50a8e3\"><span style=\"font-stretch: normal; line-height: 18px;\">iPhone X 64 GB</span></font> là cụm từ được rất nhiều người mong chờ muốn biết và tìm kiếm trên Google bởi đây là chiếc điện thoại mà Apple kỉ niệm 10 năm <font color=\"#50a8e3\"><span style=\"font-stretch: normal; line-height: 18px;\">iPhone</span></font> đầu tiên được bán ra.</h2>', '<div class=\"characteristics\" style=\"margin: 0px; padding: 0px 0px 20px; overflow: hidden; position: relative; cursor: pointer; color: rgb(51, 51, 51); font-family: Helvetica, Arial, \"DejaVu Sans\", \"Liberation Sans\", Freesans, sans-serif;\"><h2 style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; font-variant-numeric: normal; font-variant-east-asian: normal; font-weight: normal; font-stretch: normal; font-size: 20px; line-height: 1.3em; outline: none; zoom: 1;\">Đặc điểm nổi bật của iPhone X 64GB</h2><div id=\"owl-detail\" class=\"owl-carousel owl-detail owl-theme\" style=\"margin: 0px; padding: 0px; position: relative; width: 780px; overflow: hidden; top: 1px; opacity: 1;\"><div class=\"owl-wrapper-outer autoHeight\" style=\"margin: 0px; padding: 0px; overflow: hidden; position: relative; width: 780px; transition: height 500ms ease-in-out 0s; height: 433px;\"><div class=\"owl-wrapper\" style=\"margin: 0px; padding: 0px; position: relative; transform: translate3d(0px, 0px, 0px); backface-visibility: hidden; width: 15600px; left: 0px;\"><div class=\"owl-item\" style=\"margin: 0px; padding: 0px; float: left; backface-visibility: hidden; transform: translate3d(0px, 0px, 0px); width: 780px;\"><div class=\"item\" style=\"margin: 0px; padding: 0px; position: relative;\"><img class=\"lazyOwl\" src=\"https://cdn.tgdd.vn/Products/Images/42/114115/Slider/-iphone-x-thumbvideo.jpg\" style=\"margin: 0px; padding: 0px; border: 0px; display: block; width: 780px; height: auto;\"><img class=\"iYt\" src=\"https://www.thegioididong.com/Content/desktop/images/V4/icon-yt.png\" data-vid=\"feci1bJrb5k\" data-time=\"0\" style=\"margin: auto; padding: 0px; border: 0px; display: block; width: auto; height: auto; position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px;\"></div></div><div class=\"owl-item loading\" style=\"margin: 0px; padding: 0px; float: left; backface-visibility: hidden; transform: translate3d(0px, 0px, 0px); width: 780px;\"><div class=\"item\" style=\"margin: 0px; padding: 0px; position: relative;\"></div></div><div class=\"owl-item loading\" style=\"margin: 0px; padding: 0px; float: left; backface-visibility: hidden; transform: translate3d(0px, 0px, 0px); width: 780px;\"><div class=\"item\" style=\"margin: 0px; padding: 0px; position: relative;\"><a class=\"slLnk\" target=\"_blank\" href=\"https://www.thegioididong.com/hoi-dap/man-hinh-retina-la-gi-905780\" style=\"margin: 0px; padding: 4px 8px; position: absolute; bottom: 5px; right: 5px; color: rgb(40, 138, 214); background: rgba(255, 255, 255, 0.9); border-radius: 3px;\">Tìm hiểu thêm</a></div></div><div class=\"owl-item loading\" style=\"margin: 0px; padding: 0px; float: left; backface-visibility: hidden; transform: translate3d(0px, 0px, 0px); width: 780px;\"><div class=\"item\" style=\"margin: 0px; padding: 0px; position: relative;\"></div></div><div class=\"owl-item loading\" style=\"margin: 0px; padding: 0px; float: left; backface-visibility: hidden; transform: translate3d(0px, 0px, 0px); width: 780px;\"><div class=\"item\" style=\"margin: 0px; padding: 0px; position: relative;\"><a class=\"slLnk\" target=\"_blank\" href=\"https://www.thegioididong.com/tin-tuc/face-id-la-gi-bao-mat-3d-quet-khuon-mat-3d-tren-iphone-x-1018816\" style=\"margin: 0px; padding: 4px 8px; position: absolute; bottom: 5px; right: 5px; color: rgb(40, 138, 214); background: rgba(255, 255, 255, 0.9); border-radius: 3px;\">Tìm hiểu thêm</a></div></div><div class=\"owl-item loading\" style=\"margin: 0px; padding: 0px; float: left; backface-visibility: hidden; transform: translate3d(0px, 0px, 0px); width: 780px;\"><div class=\"item\" style=\"margin: 0px; padding: 0px; position: relative;\"><a class=\"slLnk\" target=\"_blank\" href=\"https://www.thegioididong.com/tin-tuc/kinh-cuong-luc-la-gi--596319\" style=\"margin: 0px; padding: 4px 8px; position: absolute; bottom: 5px; right: 5px; color: rgb(40, 138, 214); background: rgba(255, 255, 255, 0.9); border-radius: 3px;\">Tìm hiểu thêm</a></div></div><div class=\"owl-item loading\" style=\"margin: 0px; padding: 0px; float: left; backface-visibility: hidden; transform: translate3d(0px, 0px, 0px); width: 780px;\"><div class=\"item\" style=\"margin: 0px; padding: 0px; position: relative;\"><a class=\"slLnk\" target=\"_blank\" href=\"https://www.thegioididong.com/tin-tuc/tim-hieu-xoa-phong-huong-dan-xoa-phong-tren-moi-smartphone-892585\" style=\"margin: 0px; padding: 4px 8px; position: absolute; bottom: 5px; right: 5px; color: rgb(40, 138, 214); background: rgba(255, 255, 255, 0.9); border-radius: 3px;\">Tìm hiểu thêm</a></div></div><div class=\"owl-item loading\" style=\"margin: 0px; padding: 0px; float: left; backface-visibility: hidden; transform: translate3d(0px, 0px, 0px); width: 780px;\"><div class=\"item\" style=\"margin: 0px; padding: 0px; position: relative;\"><a class=\"slLnk\" target=\"_blank\" href=\"https://www.thegioididong.com/hoi-dap/che-do-chong-rung-quang-hoc-ois-chup-anh-tren-smar-906416\" style=\"margin: 0px; padding: 4px 8px; position: absolute; bottom: 5px; right: 5px; color: rgb(40, 138, 214); background: rgba(255, 255, 255, 0.9); border-radius: 3px;\">Tìm hiểu thêm</a></div></div><div class=\"owl-item loading\" style=\"margin: 0px; padding: 0px; float: left; backface-visibility: hidden; transform: translate3d(0px, 0px, 0px); width: 780px;\"><div class=\"item\" style=\"margin: 0px; padding: 0px; position: relative;\"><a class=\"slLnk\" target=\"_blank\" href=\"https://www.thegioididong.com/tin-tuc/xuat-hien-thong-tin-ve-chip-a11-tren-iphone-x-va-iphone-8-sap-toi-1020645\" style=\"margin: 0px; padding: 4px 8px; position: absolute; bottom: 5px; right: 5px; color: rgb(40, 138, 214); background: rgba(255, 255, 255, 0.9); border-radius: 3px;\">Tìm hiểu thêm</a></div></div><div class=\"owl-item loading\" style=\"margin: 0px; padding: 0px; float: left; backface-visibility: hidden; transform: translate3d(0px, 0px, 0px); width: 780px;\"><div class=\"item\" style=\"margin: 0px; padding: 0px; position: relative;\"></div></div></div></div><div class=\"owl-controls clickable\" style=\"margin: 0px; padding: 0px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-align: center; z-index: 10;\"><div class=\"owl-pagination\" style=\"margin: 5px 0px 0px; padding: 0px;\"><div class=\"owl-page active\" style=\"margin: 0px; padding: 0px; cursor: pointer; display: inline-block; zoom: 1;\"><span class=\"\" style=\"margin: 0px 5px; padding: 0px; display: block; width: 8px; height: 8px; border-radius: 20px; background: rgb(242, 140, 49); border: 1px solid rgb(242, 140, 49);\"></span></div><div class=\"owl-page\" style=\"margin: 0px; padding: 0px; cursor: pointer; display: inline-block; zoom: 1;\"><span class=\"\" style=\"margin: 0px 5px; padding: 0px; display: block; width: 8px; height: 8px; border-radius: 20px; background: none; border: 1px solid rgb(191, 191, 191);\"></span></div><div class=\"owl-page\" style=\"margin: 0px; padding: 0px; cursor: pointer; display: inline-block; zoom: 1;\"><span class=\"\" style=\"margin: 0px 5px; padding: 0px; display: block; width: 8px; height: 8px; border-radius: 20px; background: none; border: 1px solid rgb(191, 191, 191);\"></span></div><div class=\"owl-page\" style=\"margin: 0px; padding: 0px; cursor: pointer; display: inline-block; zoom: 1;\"><span class=\"\" style=\"margin: 0px 5px; padding: 0px; display: block; width: 8px; height: 8px; border-radius: 20px; background: none; border: 1px solid rgb(191, 191, 191);\"></span></div><div class=\"owl-page\" style=\"margin: 0px; padding: 0px; cursor: pointer; display: inline-block; zoom: 1;\"><span class=\"\" style=\"margin: 0px 5px; padding: 0px; display: block; width: 8px; height: 8px; border-radius: 20px; background: none; border: 1px solid rgb(191, 191, 191);\"></span></div><div class=\"owl-page\" style=\"margin: 0px; padding: 0px; cursor: pointer; display: inline-block; zoom: 1;\"><span class=\"\" style=\"margin: 0px 5px; padding: 0px; display: block; width: 8px; height: 8px; border-radius: 20px; background: none; border: 1px solid rgb(191, 191, 191);\"></span></div><div class=\"owl-page\" style=\"margin: 0px; padding: 0px; cursor: pointer; display: inline-block; zoom: 1;\"><span class=\"\" style=\"margin: 0px 5px; padding: 0px; display: block; width: 8px; height: 8px; border-radius: 20px; background: none; border: 1px solid rgb(191, 191, 191);\"></span></div><div class=\"owl-page\" style=\"margin: 0px; padding: 0px; cursor: pointer; display: inline-block; zoom: 1;\"><span class=\"\" style=\"margin: 0px 5px; padding: 0px; display: block; width: 8px; height: 8px; border-radius: 20px; background: none; border: 1px solid rgb(191, 191, 191);\"></span></div><div class=\"owl-page\" style=\"margin: 0px; padding: 0px; cursor: pointer; display: inline-block; zoom: 1;\"><span class=\"\" style=\"margin: 0px 5px; padding: 0px; display: block; width: 8px; height: 8px; border-radius: 20px; background: none; border: 1px solid rgb(191, 191, 191);\"></span></div><div class=\"owl-page\" style=\"margin: 0px; padding: 0px; cursor: pointer; display: inline-block; zoom: 1;\"><span class=\"\" style=\"margin: 0px 5px; padding: 0px; display: block; width: 8px; height: 8px; border-radius: 20px; background: none; border: 1px solid rgb(191, 191, 191);\"></span></div></div><div class=\"owl-buttons\" style=\"margin: 0px; padding: 0px; opacity: 0;\"><div class=\"owl-prev\" style=\"margin: 0px 0px 0px 5px; padding: 0px; cursor: pointer; display: inline-block; zoom: 1; float: left; background: url(\"https://cdn.thegioididong.com/v2015/Content/desktop/images/V4/icondesktop@1x.png\") -130px -50px no-repeat; width: 22px; height: 40px; position: absolute; top: 205.188px; left: 0px;\"></div><div class=\"owl-next\" style=\"margin: 0px 5px 0px 0px; padding: 0px; cursor: pointer; display: inline-block; zoom: 1; float: right; background: url(\"https://cdn.thegioididong.com/v2015/Content/desktop/images/V4/icondesktop@1x.png\") -155px -50px no-repeat; width: 22px; height: 40px; position: absolute; top: 205.188px; right: 0px;\"></div></div></div></div></div><div class=\"boxArticle\" style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Helvetica, Arial, \"DejaVu Sans\", \"Liberation Sans\", Freesans, sans-serif;\"><article class=\"area_article  area_articleFull\" style=\"margin: 15px 0px 0px; padding: 0px; font-size: 16px; line-height: 1.5; max-width: 750px; overflow: visible;\"><h2 style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 20px; line-height: 1.3em; outline: none; zoom: 1; overflow: hidden;\"><font color=\"#50a8e3\"><span style=\"font-stretch: normal; line-height: 18px;\">iPhone X 64 GB</span></font> là cụm từ được rất nhiều người mong chờ muốn biết và tìm kiếm trên Google bởi đây là chiếc điện thoại mà Apple kỉ niệm 10 năm <font color=\"#50a8e3\"><span style=\"font-stretch: normal; line-height: 18px;\">iPhone</span></font> đầu tiên được bán ra.</h2><h3 style=\"margin: 30px 0px 0px; padding: 0px; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 20px; line-height: 1.3em; outline: none; zoom: 1; overflow: hidden;\">Thiết kế mang tính đột phá</h3><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Như các bạn cũng đã biết thì đã 4 năm kể từ chiếc <font color=\"#50a8e3\">điện thoại</font> iPhone 6 và iPhone 6 Plus thì Apple vẫn chưa có thay đổi nào đáng kể trong thiết kế của mình.</p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\"><a class=\"preventdefault\" href=\"https://www.thegioididong.com/images/42/114115/iphone-x-64gb1.jpg\" style=\"margin: 0px; padding: 0px; color: rgb(80, 168, 227);\"><img alt=\"Thiết kế đột phá của điện thoại iPhone X\" data-original=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb1.jpg\" class=\"lazy\" title=\"Thiết kế đột phá của điện thoại iPhone X\" src=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb1.jpg\" style=\"margin: 10px auto; padding: 0px; border: 0px; display: block; max-width: 100%; height: auto; max-height: 584px;\"></a></p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Nhưng với iPhone X thì đó lại là 1 câu chuyện hoàn toàn khác, máy chuyển qua sử dụng màn hình tỉ lệ 19.5:9 mới mẻ với phần diện tích hiển thị mặt trước cực lớn.</p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\"><a class=\"preventdefault\" href=\"https://www.thegioididong.com/images/42/114115/iphone-x-64gb2.jpg\" style=\"margin: 0px; padding: 0px; color: rgb(80, 168, 227);\"><img alt=\"Thiết kế đột phá của điện thoại iPhone X\" data-original=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb2.jpg\" class=\"lazy\" title=\"Thiết kế đột phá của điện thoại iPhone X\" src=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb2.jpg\" style=\"margin: 10px auto; padding: 0px; border: 0px; display: block; max-width: 100%; height: auto; max-height: 584px;\"></a></p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Mặt lưng kính hỗ trợ sạc nhanh không dây cũng như phần camera kép đặt dọc cũng là những thứ đầu tiên xuất hiện trên 1 chiếc iPhone.</p><h3 style=\"margin: 30px 0px 0px; padding: 0px; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 20px; line-height: 1.3em; outline: none; zoom: 1; overflow: hidden;\">Màn hình với tai thỏ</h3><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Điểm khiến iPhone X bị chê nhiều nhất đó chính là phần \"tai thỏ\" phía trên màn hình, Apple đã chấp nhận điều này để đặt cụm camera TrueDepth mới của hãng.</p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\"><a class=\"preventdefault\" href=\"https://www.thegioididong.com/images/42/114115/iphone-x-64gb15.jpg\" style=\"margin: 0px; padding: 0px; color: rgb(80, 168, 227);\"><img alt=\"Màn hình tai thỏ của điện thoại iPhone X\" data-original=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb15.jpg\" class=\"lazy\" title=\"Màn hình tai thỏ của điện thoại iPhone X\" src=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb15.jpg\" style=\"margin: 10px auto; padding: 0px; border: 0px; display: block; max-width: 100%; height: auto; max-height: 584px;\"></a></p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Màn hình kích thước 5.8 inch độ phân giải 1125 x 2436 pixels đem đến khả năng hiển thị xuất sắc.</p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\"><a class=\"preventdefault\" href=\"https://www.thegioididong.com/images/42/114115/iphone-x-64gb20.jpg\" style=\"margin: 0px; padding: 0px; color: rgb(80, 168, 227);\"><img alt=\"Màn hình tai thỏ của điện thoại iPhone X\" data-original=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb20.jpg\" class=\"lazy\" title=\"Màn hình tai thỏ của điện thoại iPhone X\" src=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb20.jpg\" style=\"margin: 10px auto; padding: 0px; border: 0px; display: block; max-width: 100%; height: auto; max-height: 584px;\"></a></p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">iPhone X sử dụng tấm nền <a href=\"https://www.thegioididong.com/hoi-dap/man-hinh-oled-la-gi-905762\" target=\"_blank\" title=\"Tìm hiểu màn hình OLED\" type=\"Tìm hiểu màn hình OLED\" style=\"margin: 0px; padding: 0px; color: rgb(80, 168, 227);\">OLED</a> (được tinh chỉnh bởi Apple) thay vì LCD như những chiếc iPhone trước đây và điều này đem lại cho máy 1 màu đen thể hiện rất sâu cùng khả năng tái tạo màu sắc không kém phần chính xác.</p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Xem thêm: <a href=\"https://www.thegioididong.com/tin-tuc/trai-nghiem-giao-dien-iphone-x-1041322\" target=\"_blank\" title=\"Trải nghiệm giao diện iPhone X\" type=\"Trải nghiệm giao diện iPhone X\" style=\"margin: 0px; padding: 0px; color: rgb(80, 168, 227);\">Trải nghiệm giao diện iPhone X: Xem phim, chơi game có sướng?</a></p><h3 style=\"margin: 30px 0px 0px; padding: 0px; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 20px; line-height: 1.3em; outline: none; zoom: 1; overflow: hidden;\">Face ID tạo nên đột phá</h3><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Touch ID trên iPhone X đã bị loại bỏ, thay vào đó là bạn sẽ chuyển qua sử dụng Face ID, một phương thức bảo mật sinh trắc học mới của Apple.</p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\"><a class=\"preventdefault\" href=\"https://www.thegioididong.com/images/42/114115/iphone-x-64gb7.jpg\" style=\"margin: 0px; padding: 0px; color: rgb(80, 168, 227);\"><img alt=\"Face ID tạo nên đột phá trên điện thoại iPhone X\" data-original=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb7.jpg\" class=\"lazy\" title=\"Face ID tạo nên đột phá trên điện thoại iPhone X\" src=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb7.jpg\" style=\"margin: 10px auto; padding: 0px; border: 0px; display: block; max-width: 100%; height: auto; max-height: 584px;\"></a></p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Với sự trợ giúp của cụm camera TrueDept thì iPhone X có khả năng nhận diện khuôn mặt 3D của người dùng từ đó mở khóa chiếc iPhone một cách nhanh chóng.</p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\"><a class=\"preventdefault\" href=\"https://www.thegioididong.com/images/42/114115/iphone-x-64gb11.jpg\" style=\"margin: 0px; padding: 0px; color: rgb(80, 168, 227);\"><img alt=\"Face ID tạo nên đột phá trên điện thoại iPhone X\" data-original=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb11.jpg\" class=\"lazy\" title=\"Face ID tạo nên đột phá trên điện thoại iPhone X\" src=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb11.jpg\" style=\"margin: 10px auto; padding: 0px; border: 0px; display: block; max-width: 100%; height: auto; max-height: 584px;\"></a></p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Tuy sẽ hơi hụt hẫng khi Touch ID đã quá quen thuộc trên những chiếc iPhone như tốc độ cũng như trải nghiệm \"khóa như không khóa\" của Face ID hoàn toàn có thể khiến bạn yên tâm sử dụng.</p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\"><a class=\"preventdefault\" href=\"https://www.thegioididong.com/images/42/114115/iphone-x-64gb10.jpg\" style=\"margin: 0px; padding: 0px; color: rgb(80, 168, 227);\"><img alt=\"Điện thoại iPhone X tích hợp Face ID\" data-original=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb10.jpg\" class=\"lazy\" title=\"Điện thoại iPhone X tích hợp Face ID\" src=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb10.jpg\" style=\"margin: 10px auto; padding: 0px; border: 0px; display: block; max-width: 100%; height: auto; max-height: 584px;\"></a></p><h3 style=\"margin: 30px 0px 0px; padding: 0px; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 20px; line-height: 1.3em; outline: none; zoom: 1; overflow: hidden;\">Thao tác vuốt và vuốt</h3><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Không còn phím Home cứng nên các thao tác trên iPhone X cũng hoàn toàn khác so với những đàn anh đi trước.</p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\"><a class=\"preventdefault\" href=\"https://www.thegioididong.com/images/42/114115/iphone-x-64gb3.jpg\" style=\"margin: 0px; padding: 0px; color: rgb(80, 168, 227);\"><img alt=\"Thao tác vuốt và vuốt trên điện thoại iPhone X\" data-original=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb3.jpg\" class=\"lazy\" title=\"Thao tác vuốt và vuốt trên điện thoại iPhone X\" src=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb3.jpg\" style=\"margin: 10px auto; padding: 0px; border: 0px; display: block; max-width: 100%; height: auto; max-height: 584px;\"></a></p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Giờ đây chỉ với thao tác vuốt và vuốt từ cạnh dưới là bạn đã có thể truy cập vào đa nhiệm, trở về màn hình Home một cách nhanh chóng.</p><h3 style=\"margin: 30px 0px 0px; padding: 0px; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 20px; line-height: 1.3em; outline: none; zoom: 1; overflow: hidden;\">Camera kép cải tiến tích hợp Animoji</h3><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">iPhone X vẫn sở hữu bộ đôi camera kép có cùng độ phân giải 12 MP nhưng camera tele thứ 2 với khẩu độ được nâng lên mức f/2.4 so với f/2.8 của iPhone 7 Plus.</p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\"><a class=\"preventdefault\" href=\"https://www.thegioididong.com/images/42/114115/iphone-x-64gb-12-5.jpg\" style=\"margin: 0px; padding: 0px; color: rgb(80, 168, 227);\"><img alt=\"Điện thoại iPhone X tích hợp camera kép\" data-original=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb-12-5.jpg\" class=\"lazy\" title=\"Điện thoại iPhone X tích hợp camera kép\" src=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb-12-5.jpg\" style=\"margin: 10px auto; padding: 0px; border: 0px; display: block; max-width: 100%; height: auto; max-height: 584px;\"></a></p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Ngoài ra thì cả 2 camera trên iPhone X đều sở hữu cho mình khả năng chống rung quang học giúp bạn dễ dàng bắt trọn mọi khoảnh khắc trong cuộc sống.</p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\"><a class=\"preventdefault\" href=\"https://www.thegioididong.com/images/42/114115/iphone-x-64gb-14-4.jpg\" style=\"margin: 0px; padding: 0px; color: rgb(80, 168, 227);\"><img alt=\"Ảnh chụp từ camera kép trên iPhone X\" data-original=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb-14-4.jpg\" class=\"lazy\" title=\"Ảnh chụp từ camera kép trên iPhone X\" src=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb-14-4.jpg\" style=\"margin: 10px auto; padding: 0px; border: 0px; display: block; max-width: 100%; height: auto; max-height: 584px;\"></a></p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Camera trước độ phân giải 7 MP với khả năng selfie xóa phông đáp ứng tốt mọi nhu cầu tự sướng của giới trẻ hiện nay.</p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\"><a class=\"preventdefault\" href=\"https://www.thegioididong.com/images/42/114115/iphone-x-64gb-13-5.jpg\" style=\"margin: 0px; padding: 0px; color: rgb(80, 168, 227);\"><img alt=\"Ảnh selfie trên iPhone X\" data-original=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb-13-5.jpg\" class=\"lazy\" title=\"Ảnh selfie trên iPhone X\" src=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb-13-5.jpg\" style=\"margin: 10px auto; padding: 0px; border: 0px; display: block; max-width: 100%; height: auto; max-height: 584px;\"></a></p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Bộ đôi camera trên iPhone X được đánh giá rất cao về chất lượng ảnh chụp và là một trong những chiếc camera phone chụp ảnh đẹp nhất trong năm 2017.</p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Xem thêm: <font color=\"#50a8e3\">Đánh giá chi tiết iPhone X: \"Khải huyền\" của Apple sau 10 năm</font></p><h3 style=\"margin: 30px 0px 0px; padding: 0px; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 20px; line-height: 1.3em; outline: none; zoom: 1; overflow: hidden;\">Hiệu năng mạnh mẽ với Apple A11</h3><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Hiệu năng của những chiếc iPhone chưa bao giờ là vấn đề và với iPhone X thì mọi thứ vẫn rất ấn tượng.</p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Con chip <font color=\"#50a8e3\">Apple A11 Bionic 6 nhân</font> kết hợp với 3 GB RAM thì iPhone X tự tin là chiếc smartphone mạnh mẽ nhất mà Apple từng sản xuất.</p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\"><a class=\"preventdefault\" href=\"https://www.thegioididong.com/images/42/114115/iphone-x-64gb-1-11.jpg\" style=\"margin: 0px; padding: 0px; color: rgb(80, 168, 227);\"><img alt=\"Điểm Antutu Benchmark trên iPhone X\" data-original=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb-1-11.jpg\" class=\"lazy\" title=\"Điểm Antutu Benchmark trên iPhone X\" src=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb-1-11.jpg\" style=\"margin: 10px auto; padding: 0px; border: 0px; display: block; max-width: 100%; height: auto; max-height: 584px;\"></a></p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Ngoài ra với iPhone X thì Apple cũng nhấn mạnh với trải nghiệm thực tế ảo tăng cường giúp bạn có những phút giây thư giãn thú vị.</p><p style=\"margin-top: 10px; margin-right: 0px; margin-left: 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\"><a class=\"preventdefault\" href=\"https://www.thegioididong.com/images/42/114115/iphone-x-64gb-8-13.jpg\" style=\"margin: 0px; padding: 0px; color: rgb(80, 168, 227);\"><img alt=\"Cổng sạc lightning và loa chính trên iPhone X\" data-original=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb-8-13.jpg\" class=\"lazy\" title=\"Cổng sạc lightning và loa chính trên iPhone X\" src=\"https://cdn.tgdd.vn/Products/Images/42/114115/iphone-x-64gb-8-13.jpg\" style=\"margin: 10px auto; padding: 0px; border: 0px; display: block; max-width: 100%; height: auto; max-height: 584px;\"></a></p><p style=\"margin: 10px 0px; padding: 0px; margin-block-start: 0px; margin-block-end: 0px; text-rendering: geometricprecision;\">Viên pin trên iPhone X có dung lượng 2716 mAh (lớn hơn cả trên <font color=\"#50a8e3\">iPhone 8 Plus</font>) cho bạn sử dụng khá ổn trong khoảng một ngày liên tục.</p></article></div>', 'iphone,Iphonex,Apple', 27, 'content/uploads/product/K6iReUlxtCaWEZ_.png', 28, 14990000, 13500000, 10, 13000000, 'true', 0, 1, 'true', 'public', 'instock', 1, '2020-08-27 15:29:50', '2020-08-27 15:32:14');

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
(5, 'blog_category_default', '5', 'ID chuyên mục bài viết đặc biệt, không thể xoá.', 1, '2020-07-09 11:37:00'),
(6, 'no_image', 'content/assets/images/system/noimage.jpg', 'Đường dẫn ảnh mặc định', 1, '2020-07-30 00:00:00');

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
-- Chỉ mục cho bảng `dong_customer`
--
ALTER TABLE `dong_customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Chỉ mục cho bảng `dong_files`
--
ALTER TABLE `dong_files`
  ADD PRIMARY KEY (`file_id`);

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
-- Chỉ mục cho bảng `dong_product`
--
ALTER TABLE `dong_product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_code` (`product_barcode`);

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
-- AUTO_INCREMENT cho bảng `dong_customer`
--
ALTER TABLE `dong_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `dong_files`
--
ALTER TABLE `dong_files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `dong_meta`
--
ALTER TABLE `dong_meta`
  MODIFY `meta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `dong_post`
--
ALTER TABLE `dong_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `dong_product`
--
ALTER TABLE `dong_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `dong_setting`
--
ALTER TABLE `dong_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `dong_user`
--
ALTER TABLE `dong_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
