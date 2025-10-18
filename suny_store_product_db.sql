-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 18, 2025 lúc 10:47 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `suny_store_product_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `anh_san_pham`
--

CREATE TABLE `anh_san_pham` (
  `ma_anh` int(11) NOT NULL,
  `ma_san_pham` int(11) NOT NULL,
  `dia_chi_anh` varchar(255) NOT NULL,
  `anh_chinh` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `anh_san_pham`
--

INSERT INTO `anh_san_pham` (`ma_anh`, `ma_san_pham`, `dia_chi_anh`, `anh_chinh`) VALUES
(42, 14, 'uploads/68e37a9874a2b.jpg', 0),
(44, 14, 'uploads/68e37aaf90c7a.jpg', 1),
(45, 16, 'uploads/68e38e5a85bc0.jpg', 1),
(46, 15, 'uploads/68e38f15401f7.jpg', 1),
(47, 15, 'uploads/68e38f1540941.jpg', 0),
(48, 15, 'uploads/68e38f154105b.jpg', 0),
(49, 17, 'uploads/68eda78181176.png', 1),
(50, 18, 'uploads/68eda86f1540c.png', 1),
(51, 18, 'uploads/68eda8d22bc4e.png', 0),
(54, 19, 'uploads/68eda97bb8fa7.png', 1),
(56, 20, 'uploads/68edab63db7dd.png', 1),
(57, 21, 'uploads/68edabc6a678a.png', 1),
(58, 22, 'uploads/68edac76bcb04.png', 1),
(59, 23, 'uploads/68edadcd94e64.png', 1),
(60, 24, 'uploads/68edae42d4696.png', 1),
(61, 25, 'uploads/68edaf26ac5ed.png', 1),
(62, 26, 'uploads/68edafb5092a6.png', 1),
(63, 27, 'uploads/68edb03b9c85b.png', 1),
(64, 28, 'uploads/68edb1b32e0eb.png', 1),
(65, 29, 'uploads/68edb27a7ddbb.png', 1),
(66, 30, 'uploads/68f342338cec5.png', 1),
(67, 31, 'uploads/68f342830b415.png', 1),
(68, 32, 'uploads/68f342dbb5821.png', 1),
(69, 33, 'uploads/68f3434396dbb.png', 1),
(70, 34, 'uploads/68f34378a4194.png', 1),
(71, 35, 'uploads/68f343b7f32e9.png', 1),
(72, 36, 'uploads/68f343fd48b08.png', 1),
(73, 37, 'uploads/68f3443de5b4c.png', 1),
(74, 38, 'uploads/68f344dfe94d3.png', 1),
(75, 39, 'uploads/68f3451e67b7b.png', 1),
(76, 40, 'uploads/68f34554ce432.png', 1),
(77, 41, 'uploads/68f3458bcc458.png', 1),
(78, 42, 'uploads/68f34701e90be.png', 1),
(79, 43, 'uploads/68f34741d2698.png', 1),
(80, 44, 'uploads/68f34774f0d3b.png', 1),
(81, 45, 'uploads/68f347bd4c771.png', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_san_pham`
--

CREATE TABLE `chi_tiet_san_pham` (
  `ma_chi_tiet_sp` int(11) NOT NULL,
  `ma_san_pham` int(11) NOT NULL,
  `kich_thuoc` varchar(15) DEFAULT NULL,
  `mau_sac` text NOT NULL,
  `so_luong` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chi_tiet_san_pham`
--

INSERT INTO `chi_tiet_san_pham` (`ma_chi_tiet_sp`, `ma_san_pham`, `kich_thuoc`, `mau_sac`, `so_luong`) VALUES
(1, 1, 'S', 'Kem', 20),
(2, 1, 'M', 'Kem', 30),
(3, 1, 'L', 'Kem', 15),
(4, 1, 'XL', 'Kem', 25),
(5, 1, '2XL', 'Kem', 20),
(6, 2, 'L', 'Xanh đậm', 10),
(7, 3, 'Free size', 'Họa tiết hoa nhí', 15),
(8, 4, 'M', 'Xanh pastel', 12),
(9, 4, 'L', 'Xanh pastel', 18),
(10, 5, NULL, 'Đen', 10),
(11, 5, NULL, 'Nâu', 8),
(12, 6, 'S', 'Xanh Lá', 25),
(13, 6, 'M', 'Xanh Lá', 20),
(14, 7, 'L', 'Xanh Lá', 15),
(15, 7, 'XL', 'Xanh Lá', 20),
(16, 8, 'M', 'Đỏ', 10),
(17, 8, 'L', 'Đỏ', 5),
(18, 9, 'Free size', 'Họa tiết hoa', 30),
(19, 10, 'M', 'Đen', 15),
(20, 10, 'L', 'Xám', 20),
(21, 11, 'One Size', 'Kaki đậm', 20),
(22, 11, 'One Size', 'Kaki nhạt', 30),
(23, 12, 'One Size', 'Trắng', 20),
(24, 12, 'One Size', 'Xám', 30),
(25, 12, 'One Size', 'Đen', 30),
(26, 12, 'M', 'Xanh navy', 20),
(27, 12, 'L', 'Xanh navy', 20),
(28, 12, 'M', 'Trắng', 30),
(29, 12, 'L', 'Trắng', 30),
(215, 14, 'S', 'Kem', 24),
(216, 14, 'M', 'Kem', 24),
(217, 14, 'L', 'Kem', 24),
(218, 14, 'XL', 'Kem', 24),
(219, 14, '2XL', 'Kem', 24),
(220, 14, 'S', 'Kaki', 24),
(221, 14, 'M', 'Kaki', 24),
(222, 14, 'L', 'Kaki', 24),
(223, 14, 'XL', 'Kaki', 24),
(224, 14, '2XL', 'Kaki', 24),
(225, 14, 'S', 'Đen', 24),
(226, 14, 'M', 'Đen', 24),
(227, 14, 'L', 'Đen', 24),
(228, 14, 'XL', 'Đen', 24),
(229, 14, '2XL', 'Đen', 24),
(230, 14, 'S', 'Nâu', 24),
(231, 14, 'M', 'Nâu', 24),
(232, 14, 'L', 'Nâu', 24),
(233, 14, 'XL', 'Nâu', 24),
(234, 14, '2XL', 'Nâu', 24),
(235, 15, 'One Size', 'Đen', 20),
(236, 15, 'One Size', 'Be', 20),
(237, 15, 'One Size', 'Kaki', 30),
(238, 15, 'One Size', 'Nghệ', 30),
(239, 15, 'One Size', 'Nâu', 30),
(243, 17, 'M', 'Xanh', 20),
(260, 18, 'S', 'Đen', 10),
(261, 18, 'S', 'Trắng', 10),
(262, 18, 'M', 'Đen', 10),
(263, 18, 'M', 'Trắng', 10),
(264, 18, 'L', 'Đen', 10),
(266, 19, 'M', 'Trắng', 10),
(268, 20, 'M', 'Xanh', 10),
(269, 21, 'M', 'Be', 20),
(270, 22, 'L', 'Đen', 20),
(271, 23, 'M', 'Đen', 12),
(272, 24, 'M', 'Đen', 36),
(273, 25, 'M', 'Xanh', 23),
(274, 26, 'S', 'Đen', 30),
(275, 26, 'M', 'Đen', 34),
(276, 26, 'L', 'Đen', 76),
(277, 27, 'M', 'Be', 43),
(278, 28, 'M', 'Xanh', 2),
(279, 29, 'M', 'Hồng', 5),
(280, 30, 'M', 'Xanh', 89),
(281, 30, 'L', 'Xanh', 56),
(282, 31, 'M', 'Be', 67),
(283, 31, 'L', 'Be', 75),
(284, 31, 'S', 'Be', 86),
(285, 32, 'S', 'Trắng', 77),
(286, 32, 'M', 'Trắng', 97),
(287, 35, 'M', 'Xanh', 13),
(288, 36, 'S', 'Trắng', 65),
(289, 36, 'M', 'Trắng', 12),
(290, 37, 'M', 'Trắng-Kem', 23),
(291, 42, 'M', 'Trắng', 30),
(292, 43, 'M', 'Xanh', 8),
(293, 43, 'L', 'Xanh', 9),
(294, 44, 'M', 'Xám', 20),
(295, 45, 'M', 'Trắng', 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_muc`
--

CREATE TABLE `danh_muc` (
  `ma_danh_muc` int(11) NOT NULL,
  `ten_danh_muc` varchar(100) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danh_muc`
--

INSERT INTO `danh_muc` (`ma_danh_muc`, `ten_danh_muc`, `mo_ta`, `ngay_tao`) VALUES
(1, 'Áo', 'Áo nữ đa phong cách: áo thun, áo sơ mi, áo len, phù hợp mọi dịp.', '2025-09-28 05:33:22'),
(2, 'Quần', 'Quần nữ thời trang: jeans, quần tây, quần short, năng động và thanh lịch.', '2025-09-28 05:33:22'),
(3, 'Váy đầm', 'Váy và đầm nữ từ dạo phố, công sở đến dạ hội sang trọng.', '2025-09-28 05:33:22'),
(4, 'Đồ bộ', 'Đồ bộ nữ thoải mái, dễ phối, từ đồ mặc nhà đến đồ dạo chơi.', '2025-09-28 05:33:22'),
(5, 'Phụ kiện', 'Phụ kiện thời trang: túi xách, khăn, thắt lưng, mũ, và trang sức.', '2025-09-28 05:33:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `san_pham`
--

CREATE TABLE `san_pham` (
  `ma_san_pham` int(11) NOT NULL,
  `ten_san_pham` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `gia_nhap` decimal(10,2) NOT NULL,
  `gia_ban` decimal(10,2) NOT NULL,
  `ma_danh_muc` int(11) DEFAULT NULL,
  `nguoi_tao` int(11) DEFAULT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp(),
  `ngay_cap_nhat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `san_pham`
--

INSERT INTO `san_pham` (`ma_san_pham`, `ten_san_pham`, `mo_ta`, `gia_nhap`, `gia_ban`, `ma_danh_muc`, `nguoi_tao`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 'Áo sơ mi nữ lụa hoa dài tay', 'Áo thun nữ cotton mềm mại, màu trắng, phù hợp mặc hàng ngày.', 100000.00, 310000.00, 1, 1, '2025-09-28 05:33:23', '2025-09-28 05:36:53'),
(2, 'Quần jeans skinny xanh đậm', 'Quần jeans nữ dáng ôm, màu xanh đậm, thời thượng và dễ phối đồ.', 200000.00, 300000.00, 2, 2, '2025-09-28 05:33:23', '2025-09-28 05:33:23'),
(3, 'Váy maxi hoa nhí', 'Váy maxi nữ họa tiết hoa nhí, nhẹ nhàng, thích hợp đi biển hoặc dạo phố.', 250000.00, 400000.00, 3, 3, '2025-09-28 05:33:23', '2025-09-28 05:33:23'),
(4, 'Đồ bộ pijama lụa', 'Bộ pijama nữ lụa cao cấp, thoải mái, phù hợp mặc nhà.', 180000.00, 280000.00, 4, 1, '2025-09-28 05:33:23', '2025-09-28 05:33:23'),
(5, 'Túi xách tote da', 'Túi xách nữ da tổng hợp, kiểu dáng hiện đại, phù hợp công sở.', 300000.00, 450000.00, 5, 4, '2025-09-28 05:33:23', '2025-09-28 05:33:23'),
(6, 'Áo sơ mi in nữ dài tay', 'Áo sơ mi nữ trắng thanh lịch, chất liệu lụa, phù hợp môi trường công sở.', 150000.00, 285000.00, 1, 2, '2025-09-28 05:33:23', '2025-09-28 05:51:06'),
(7, 'Quần short cạp cao', 'Quần short nữ cạp cao, vải kaki, trẻ trung và năng động.', 120000.00, 200000.00, 2, 3, '2025-09-28 05:33:23', '2025-09-28 05:33:23'),
(8, 'Đầm dạ hội đỏ', 'Đầm dạ hội nữ màu đỏ, thiết kế sang trọng, phù hợp tiệc tối.', 500000.00, 800000.00, 3, 4, '2025-09-28 05:33:23', '2025-09-28 05:33:23'),
(9, 'Khăn choàng lụa họa tiết', 'Khăn choàng lụa nữ với họa tiết tinh tế, phụ kiện thời trang cao cấp.', 80000.00, 150000.00, 5, 1, '2025-09-28 05:33:23', '2025-09-28 05:33:23'),
(10, 'Bộ đồ thể thao nữ', 'Bộ đồ thể thao nữ năng động, chất liệu thấm hút mồ hôi, phù hợp tập gym.', 220000.00, 350000.00, 4, 2, '2025-09-28 05:33:23', '2025-09-28 05:33:23'),
(11, 'Áo nỉ nữ thêu hình chú mèo và cuộn dây', 'Áo thun nữ cotton mềm mại, màu trắng, phù hợp mặc hàng ngày.', 100000.00, 295000.00, 1, 1, '2025-09-28 09:42:52', '2025-09-28 09:42:52'),
(12, 'Áo nữ đính khăn choàng sọc caro', 'Áo thun nữ cotton mềm mại, màu trắng, phù hợp mặc hàng ngày.', 100000.00, 280000.00, 1, 1, '2025-09-28 10:09:07', '2025-09-28 10:09:07'),
(13, 'Áo nữ giả 2 cổ phối somi hình hộp sữa', 'Áo thun nữ cotton mềm mại, màu trắng, phù hợp mặc hàng ngày.', 100000.00, 340000.00, 1, 1, '2025-09-28 10:15:42', '2025-09-28 10:15:42'),
(14, 'Váy hoa nhí', 'Váy hoa nhí cổ vuông', 100000.00, 99999999.99, 3, 1, '2025-09-28 10:33:49', '2025-10-06 09:09:56'),
(15, 'Quần yếm nữ', 'Quần', 100000.00, 275000.00, 2, 1, '2025-09-28 10:33:49', '2025-10-06 09:42:45'),
(16, 'Túi xách nữ', 'Túi xách thanh lịch phù hợp với nhiều phong cách', 1000000.00, 16000000.00, 5, NULL, '2025-10-06 09:39:38', '2025-10-06 09:40:25'),
(17, 'Áo dài cách tân', 'Thiết kế thanh lịch với lụa tơ tằm. Cách tân nhưng không mất đi vẻ đẹp của áo dài truyền thống.', 320000.00, 320000.00, 1, NULL, '2025-10-14 01:25:32', '2025-10-14 01:30:05'),
(18, 'Áo thun dài tay', 'Sản phẩm thu đông ', 150000.00, 160000.00, 1, NULL, '2025-10-14 01:31:31', '2025-10-14 01:35:25'),
(19, 'Áo crop top ', '', 180000.00, 190000.00, 1, NULL, '2025-10-14 01:37:41', '2025-10-14 01:38:03'),
(20, 'Quần short nữ', '', 200000.00, 300000.00, 2, NULL, '2025-10-14 01:45:14', '2025-10-14 01:46:11'),
(21, 'Quần âu nữ', '', 400000.00, 500000.00, 2, NULL, '2025-10-14 01:47:50', '2025-10-14 01:47:50'),
(22, 'Quần kaki túi hộp', '', 300000.00, 500000.00, 2, NULL, '2025-10-14 01:50:46', '2025-10-14 01:50:46'),
(23, 'Quần legging nữ dài', '', 300000.00, 450000.00, 2, NULL, '2025-10-14 01:56:29', '2025-10-14 01:56:29'),
(24, 'Quần legging nữ ', '', 256456.00, 345790.00, 2, NULL, '2025-10-14 01:58:26', '2025-10-14 01:58:26'),
(25, 'Quần skinny jean nữ', '', 456787.00, 678997.00, 2, NULL, '2025-10-14 02:02:14', '2025-10-14 02:02:14'),
(26, 'Quần giả váy ngắn', '', 345687.00, 578547.00, 2, NULL, '2025-10-14 02:04:37', '2025-10-14 02:04:37'),
(27, 'Quần bảo hộ khi mặc váy cho nữ', '', 323456.00, 678654.00, 2, NULL, '2025-10-14 02:06:51', '2025-10-14 02:06:51'),
(28, 'Váy dự tiệc phong cách châu Âu', '', 29765466.00, 57464430.00, 3, NULL, '2025-10-14 02:13:07', '2025-10-14 02:13:07'),
(29, 'Váy nữ thanh lịch', '', 4586877.00, 6322468.00, 3, NULL, '2025-10-14 02:16:26', '2025-10-14 02:16:26'),
(30, 'Váy liền thân thanh lịch', '', 457986.00, 769644.00, 3, NULL, '2025-10-18 07:30:59', '2025-10-18 07:30:59'),
(31, 'Set đồ công sở năng động', '', 5678647.00, 8765428.00, 4, NULL, '2025-10-18 07:32:19', '2025-10-18 07:32:19'),
(32, 'Quần ống rộng', '', 765432.00, 986532.00, 2, NULL, '2025-10-18 07:33:47', '2025-10-18 07:33:47'),
(33, 'Set đồ công sở thanh lịch với Áo len cổ lọ và chân váy bút chì', '', 8975327.00, 10866532.00, 4, NULL, '2025-10-18 07:35:31', '2025-10-18 07:35:31'),
(34, 'Váy suông họa tiết', '', 2986454.00, 3875376.00, 3, NULL, '2025-10-18 07:36:24', '2025-10-18 07:36:24'),
(35, 'Set đồ denim trẻ trung', '', 1865532.00, 3864324.00, 4, NULL, '2025-10-18 07:37:27', '2025-10-18 07:37:27'),
(36, 'Váy maxi thướt tha', '', 1876432.00, 3456876.00, 3, NULL, '2025-10-18 07:38:37', '2025-10-18 07:38:37'),
(37, 'Set đồ thanh lịch Quần culottes và áo kiểu', '', 5422438.00, 7853456.00, 4, NULL, '2025-10-18 07:39:41', '2025-10-18 07:39:41'),
(38, 'Túi xách da sang trọng', '', 5897769.00, 7998655.00, 5, NULL, '2025-10-18 07:42:23', '2025-10-18 07:42:23'),
(39, 'Mắt kính thời trang sành điệu', '', 2876565.00, 4567876.00, 5, NULL, '2025-10-18 07:43:26', '2025-10-18 07:43:26'),
(40, 'Dây chuyền và bông tai ngọc trai', '', 6789876.00, 7898678.00, 5, NULL, '2025-10-18 07:44:20', '2025-10-18 07:44:20'),
(41, 'Đồng hồ đeo tay và vòng tay', '', 13678987.00, 25678987.00, 5, NULL, '2025-10-18 07:45:15', '2025-10-18 07:45:15'),
(42, 'Áo sơ mi trắng cổ điển', '', 567832.00, 898764.00, 1, NULL, '2025-10-18 07:51:29', '2025-10-18 07:51:29'),
(43, 'Áo blouse họa tiết nhẹ nhàng', '', 456782.00, 898789.00, 1, NULL, '2025-10-18 07:52:33', '2025-10-18 07:52:33'),
(44, 'Áo len cổ lọ ấm áp', '', 678978.00, 1789678.00, 1, NULL, '2025-10-18 07:53:24', '2025-10-18 07:53:24'),
(45, 'Áo kiểu tay bồng nữ tính', '', 398821.00, 678798.00, 1, NULL, '2025-10-18 07:54:37', '2025-10-18 07:54:37');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `anh_san_pham`
--
ALTER TABLE `anh_san_pham`
  ADD PRIMARY KEY (`ma_anh`),
  ADD KEY `ma_san_pham` (`ma_san_pham`);

--
-- Chỉ mục cho bảng `chi_tiet_san_pham`
--
ALTER TABLE `chi_tiet_san_pham`
  ADD PRIMARY KEY (`ma_chi_tiet_sp`),
  ADD KEY `ma_san_pham` (`ma_san_pham`);

--
-- Chỉ mục cho bảng `danh_muc`
--
ALTER TABLE `danh_muc`
  ADD PRIMARY KEY (`ma_danh_muc`);

--
-- Chỉ mục cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`ma_san_pham`),
  ADD KEY `ma_danh_muc` (`ma_danh_muc`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `anh_san_pham`
--
ALTER TABLE `anh_san_pham`
  MODIFY `ma_anh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT cho bảng `chi_tiet_san_pham`
--
ALTER TABLE `chi_tiet_san_pham`
  MODIFY `ma_chi_tiet_sp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=296;

--
-- AUTO_INCREMENT cho bảng `danh_muc`
--
ALTER TABLE `danh_muc`
  MODIFY `ma_danh_muc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `ma_san_pham` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `anh_san_pham`
--
ALTER TABLE `anh_san_pham`
  ADD CONSTRAINT `anh_san_pham_ibfk_1` FOREIGN KEY (`ma_san_pham`) REFERENCES `san_pham` (`ma_san_pham`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `chi_tiet_san_pham`
--
ALTER TABLE `chi_tiet_san_pham`
  ADD CONSTRAINT `chi_tiet_san_pham_ibfk_1` FOREIGN KEY (`ma_san_pham`) REFERENCES `san_pham` (`ma_san_pham`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  ADD CONSTRAINT `san_pham_ibfk_1` FOREIGN KEY (`ma_danh_muc`) REFERENCES `danh_muc` (`ma_danh_muc`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
