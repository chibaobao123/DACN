-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2023 at 03:38 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quanlysanbong`
--

-- --------------------------------------------------------

--
-- Table structure for table `dat_san`
--

CREATE TABLE `dat_san` (
  `id` int(11) NOT NULL,
  `ma_kh` int(11) NOT NULL,
  `ma_san` int(11) NOT NULL,
  `bat_dau` datetime NOT NULL,
  `ket_thuc` datetime NOT NULL,
  `da_thanh_toan` tinyint(1) NOT NULL,
  `don_gia` int(11) NOT NULL,
  `note` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `dat_san`
--

INSERT INTO `dat_san` (`id`, `ma_kh`, `ma_san`, `bat_dau`, `ket_thuc`, `da_thanh_toan`, `don_gia`, `note`) VALUES
(1, 59, 20, '2022-11-04 18:00:00', '2022-11-04 20:15:00', 0, 4000, ''),
(2, 61, 21, '2022-11-04 14:00:00', '2022-11-04 16:30:00', 0, 3000, '');

-- --------------------------------------------------------

--
-- Table structure for table `khach_hang`
--

CREATE TABLE `khach_hang` (
  `id` int(11) NOT NULL,
  `ten` varchar(40) NOT NULL,
  `sdt` varchar(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(40) NOT NULL,
  `admin_number` int(1) NOT NULL,
  `soLanHuySan` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `khach_hang`
--

INSERT INTO `khach_hang` (`id`, `ten`, `sdt`, `email`, `username`, `admin_number`, `soLanHuySan`) VALUES
(37, 'Bao Bao Chi', '0703934369', 'baobaochi631999@gmail.com', 'baobaochi', 2, 0),
(58, 'Huỳnh Trịnh Thái Long', '0123456789', 'thailong2015py@gmail.com', 'thailong', 1, 0),
(59, 'baochi', '0909789237', 'huybao631999@gmail.com', 'baochi', 0, 0),
(61, 'Chí Huy Bảo', '0703934582', 'baobaochi123@gmail.com', 'baobaochi123', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kho_hang`
--

CREATE TABLE `kho_hang` (
  `id` int(11) NOT NULL,
  `san_pham` varchar(225) NOT NULL,
  `gia_tien` varchar(100) NOT NULL,
  `ton_kho` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `kho_hang`
--

INSERT INTO `kho_hang` (`id`, `san_pham`, `gia_tien`, `ton_kho`) VALUES
(1, 'Sting dâu', '10000', '200'),
(2, 'coca cola', '12000', '120'),
(3, 'Pepsi', '10000', '200'),
(4, 'Redbull', '15000', '150'),
(5, 'O long', '10000', '80'),
(6, 'Sting vàng', '15000', '130'),
(7, 'Nước suối', '8000', '500'),
(8, 'Revive', '15000', '200'),
(9, 'Chanh muối', '15000', '140'),
(10, 'Nước dừa', '20000', '20'),
(12, 'Trà Lipton', '15000', '40'),
(13, 'Sửa bắp', '10000', '30'),
(14, 'Sửa đậu nănh', '10000', '60'),
(15, 'Trà sửa thái', '15000', '25');

-- --------------------------------------------------------

--
-- Table structure for table `phieu_kiem_ke`
--

CREATE TABLE `phieu_kiem_ke` (
  `id` int(11) NOT NULL,
  `san_pham` varchar(225) NOT NULL,
  `ton_kho` varchar(225) NOT NULL,
  `kiem_ke` varchar(225) NOT NULL,
  `chenh_lech` varchar(225) NOT NULL,
  `ngay` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `san_bong`
--

CREATE TABLE `san_bong` (
  `id` int(11) NOT NULL,
  `ten` varchar(40) NOT NULL,
  `gia` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `san_bong`
--

INSERT INTO `san_bong` (`id`, `ten`, `gia`) VALUES
(20, 'San A', 4000),
(21, 'San B', 3000),
(22, 'San C', 2000),
(23, 'San D', 5000),
(24, 'San E', 3000),
(26, 'San F', 3000),
(27, 'San G', 5000),
(28, 'San H', 2000),
(29, 'San I', 4000);

-- --------------------------------------------------------

--
-- Table structure for table `tai_khoan`
--

CREATE TABLE `tai_khoan` (
  `id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password_id` varchar(40) NOT NULL,
  `admin_number` int(1) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sdt` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `tai_khoan`
--

INSERT INTO `tai_khoan` (`id`, `username`, `password_id`, `admin_number`, `email`, `sdt`) VALUES
(3, 'thailong', '123456', 1, 'thailong2015py@gmail.com', '0780548215'),
(5, 'baochi', '123456', 0, 'huybao631999@gmail.com', '0254875332'),
(513, 'baobaochi', '123456', 2, 'baobaochi631999@gmail.com', '0703934583'),
(515, 'baobaochi123', '123456', 0, 'baobaochi123@gmail.com', '0703934582');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dat_san`
--
ALTER TABLE `dat_san`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dat_san_ibfk_1` (`ma_kh`),
  ADD KEY `dat_san_ibfk_2` (`ma_san`);

--
-- Indexes for table `khach_hang`
--
ALTER TABLE `khach_hang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kho_hang`
--
ALTER TABLE `kho_hang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phieu_kiem_ke`
--
ALTER TABLE `phieu_kiem_ke`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `san_bong`
--
ALTER TABLE `san_bong`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tai_khoan`
--
ALTER TABLE `tai_khoan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dat_san`
--
ALTER TABLE `dat_san`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `khach_hang`
--
ALTER TABLE `khach_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `kho_hang`
--
ALTER TABLE `kho_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `phieu_kiem_ke`
--
ALTER TABLE `phieu_kiem_ke`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `san_bong`
--
ALTER TABLE `san_bong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tai_khoan`
--
ALTER TABLE `tai_khoan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=516;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dat_san`
--
ALTER TABLE `dat_san`
  ADD CONSTRAINT `dat_san_ibfk_1` FOREIGN KEY (`ma_kh`) REFERENCES `khach_hang` (`id`),
  ADD CONSTRAINT `dat_san_ibfk_2` FOREIGN KEY (`ma_san`) REFERENCES `san_bong` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
