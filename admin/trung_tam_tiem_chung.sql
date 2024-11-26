-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 27, 2024 at 04:37 AM
-- Server version: 5.7.17-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trung_tam_tiem_chung`
--

-- --------------------------------------------------------

--
-- Table structure for table `benh`
--

CREATE TABLE `benh` (
  `benh_id` int(11) NOT NULL,
  `ten_benh` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `danh_muc_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `benh`
--

INSERT INTO `benh` (`benh_id`, `ten_benh`, `danh_muc_id`) VALUES
(1, 'Khùng', 2),
(2, 'Điên', 2);

-- --------------------------------------------------------

--
-- Table structure for table `chuc_nang`
--

CREATE TABLE `chuc_nang` (
  `id` int(11) NOT NULL,
  `ten_chuc_nang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mo_ta` text COLLATE utf8_unicode_ci,
  `duong_dan` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `chuc_nang`
--

INSERT INTO `chuc_nang` (`id`, `ten_chuc_nang`, `mo_ta`, `duong_dan`) VALUES
(7, 'Xem vai trò', '', 'vai-tro-list'),
(8, 'Thêm vai trò', '', 'vai-tro-add'),
(9, 'Sửa vai trò', '', 'vai-tro-edit'),
(10, 'Xem chức năng', '', 'chuc-nang-list'),
(11, 'Thêm chức năng', '', 'chuc-nang-add'),
(12, 'Sửa chức năng', '', 'chuc-nang-edit'),
(13, 'Xem tài khoản', '', 'tai-khoan-list'),
(14, 'Thêm tài khoản', '', 'tai-khoan-add'),
(15, 'Sửa tài khoản', '', 'tai-khoan-edit'),
(16, 'Xem khách hàng', '', 'khach-hang-list'),
(17, 'Thêm khách hàng', '', 'khach-hang-add'),
(18, 'Sửa khách hàng', '', 'khach-hang-edit'),
(19, 'Xem danh mục bệnh', '', 'danh-muc-benh-list'),
(20, 'Thêm danh mục bệnh', '', 'danh-muc-benh-add'),
(21, 'Sửa danh mục bệnh', '', 'danh-muc-benh-edit'),
(22, 'Xem bệnh', '', 'benh-list'),
(23, 'Thêm bệnh', '', 'benh-add'),
(24, 'Sửa bệnh', '', 'benh-edit'),
(25, 'Xem đối tượng tiêm chủng', '', 'doi-tuong-tiem-chung-list'),
(26, 'Thêm đối tượng tiêm chủng', '', 'doi-tuong-tiem-chung-add'),
(27, 'Sửa đối tượng tiêm chủng', '', 'doi-tuong-tiem-chung-edit'),
(28, 'Xem phác đồ tiêm', '', 'phac-do-tiem-list'),
(29, 'Thêm phác đồ tiêm', '', 'phac-do-tiem-add'),
(30, 'Sửa phác đồ tiêm', '', 'phac-do-tiem-edit'),
(31, 'Xem điều kiện tiêm', '', 'dieu-kien-tiem-list'),
(32, 'Thêm điều kiện tiêm', '', 'dieu-kien-tiem-add'),
(33, 'Sửa điều kiện tiêm', '', 'dieu-kien-tiem-edit'),
(34, 'Xem vaccine', '', 'vaccine-list'),
(35, 'Thêm vaccine', '', 'vaccine-add'),
(36, 'Sửa vaccine', '', 'vaccine-edit'),
(37, 'Xem lịch hẹn', '', 'lich-hen-list'),
(38, 'Thêm lịch hẹn', '', 'lich-hen-add'),
(39, 'Sửa lịch hẹn', '', 'lich-hen-edit'),
(40, 'Xem lịch tiêm', '', 'lich-tiem-list'),
(41, 'Thêm lịch tiêm', '', 'lich-tiem-add'),
(42, 'Sửa lịch tiêm', '', 'lich-tiem-edit'),
(43, 'Xem thanh toán', '', 'thanh-toan-list'),
(44, 'Thêm thanh toán', '', 'thanh-toan-add'),
(45, 'Sửa thanh toán', '', 'thanh-toan-edit'),
(46, 'Xem lứa tuổi', '', 'lua-tuoi-list'),
(47, 'Thêm lứa tuổi', '', 'lua-tuoi-add'),
(48, 'Sửa lứa tuổi', '', 'lua-tuoi-edit'),
(49, 'Xem liều lượng', '', 'lieu-luong-tiem-list'),
(50, 'Thêm liều lượng', '', 'lieu-luong-tiem-add'),
(51, 'Sửa liều lượng', '', 'lieu-luong-tiem-edit'),
(52, 'Xem lịch sử khách hàng', '', 'khach-hang-history'),
(53, 'Thông tin cá nhân', '', 'profile'),
(54, 'Xem đăng ký', '', 'dang-ky-tiem-tai-nha-list'),
(55, 'Chi tiết đăng ký', '', 'dang-ky-tiem-tai-nha-detail'),
(56, 'Kiểm tra thông tin khách hàng', '', 'check_info'),
(57, 'Chi tiết vaccine', '', 'vaccine-detail'),
(58, 'Chi tiết phác đồ', '', 'phac-do-tiem-detail');

-- --------------------------------------------------------

--
-- Table structure for table `dang_ky_tiem_tai_nha`
--

CREATE TABLE `dang_ky_tiem_tai_nha` (
  `dang_ky_id` int(11) NOT NULL,
  `ho_ten` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ngay_sinh` date NOT NULL,
  `gioi_tinh` enum('nam','nu','khac') COLLATE utf8_unicode_ci NOT NULL,
  `tinh_thanh` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `quan_huyen` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phuong_xa` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `dia_chi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ho_ten_lien_he` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `quan_he` enum('vo','chong','con','bo','me','ong','ba','khac','ban_than') COLLATE utf8_unicode_ci NOT NULL,
  `dien_thoai_lien_he` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ngay_mong_muon` date NOT NULL,
  `trang_thai` enum('cho_xu_ly','da_xu_ly','huy') COLLATE utf8_unicode_ci DEFAULT 'cho_xu_ly',
  `ngay_tao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dang_ky_tiem_tai_nha`
--

INSERT INTO `dang_ky_tiem_tai_nha` (`dang_ky_id`, `ho_ten`, `ngay_sinh`, `gioi_tinh`, `tinh_thanh`, `quan_huyen`, `phuong_xa`, `dia_chi`, `ho_ten_lien_he`, `quan_he`, `dien_thoai_lien_he`, `ngay_mong_muon`, `trang_thai`, `ngay_tao`) VALUES
(1, 'Ngô Thanh Tân', '2024-10-28', '', '89', '886', '30361', '0900000000', 'Ngân Thanh Tô', '', '0586081594', '2024-11-29', 'cho_xu_ly', '2024-11-23 02:11:08'),
(2, 'Ngô Thanh Tân', '2024-10-28', '', '89', '886', '30361', '0900000000', 'Ngân Thanh Tô', '', '0586081594', '2024-11-29', 'huy', '2024-11-23 02:15:50'),
(3, 'Ngô Thanh Tân', '2024-11-21', 'nam', '75', '736', '26245', 'Khặc khặc', 'Ngân Thanh Tô', 'vo', '0586081594', '2024-11-13', 'cho_xu_ly', '2024-11-23 06:40:08'),
(4, 'codenguvl', '2024-11-23', 'nu', '96', '971', '32191', 'w', 'Ngân Thanh Tô', 'ban_than', '2222', '2024-11-30', 'cho_xu_ly', '2024-11-27 03:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `danh_muc_benh`
--

CREATE TABLE `danh_muc_benh` (
  `danh_muc_id` int(11) NOT NULL,
  `ten_danh_muc` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `danh_muc_benh`
--

INSERT INTO `danh_muc_benh` (`danh_muc_id`, `ten_danh_muc`) VALUES
(2, 'Thần kinh');

-- --------------------------------------------------------

--
-- Table structure for table `dat_coc`
--

CREATE TABLE `dat_coc` (
  `dat_coc_id` int(11) NOT NULL,
  `vaccine_id` int(11) NOT NULL,
  `phan_tram_dat_coc` int(11) NOT NULL,
  `so_tien_dat_coc` decimal(10,2) NOT NULL,
  `ngay_dat_coc` date NOT NULL,
  `trang_thai` enum('dat_coc','hoan_tien') COLLATE utf8_unicode_ci DEFAULT 'dat_coc',
  `ghi_chu` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dat_coc`
--

INSERT INTO `dat_coc` (`dat_coc_id`, `vaccine_id`, `phan_tram_dat_coc`, `so_tien_dat_coc`, `ngay_dat_coc`, `trang_thai`, `ghi_chu`) VALUES
(1, 1, 20, '2222.20', '2024-11-09', 'dat_coc', 'aa'),
(2, 1, 20, '2222.20', '2024-11-10', 'dat_coc', 'Xong xui nha\r\n'),
(3, 1, 20, '2222.20', '2024-11-10', 'dat_coc', 'hihi'),
(4, 1, 20, '2222.20', '2024-11-10', 'dat_coc', 'hhh'),
(5, 1, 20, '2222.20', '2024-11-10', 'dat_coc', ''),
(6, 1, 0, '0.00', '2024-11-10', 'dat_coc', NULL),
(7, 1, 0, '0.00', '2024-11-10', 'dat_coc', NULL),
(8, 1, 20, '2222.20', '2024-11-10', 'dat_coc', '222'),
(9, 1, 0, '0.00', '2024-11-10', 'dat_coc', NULL),
(10, 1, 20, '2222.20', '2024-11-16', 'dat_coc', 'aaa'),
(11, 1, 20, '2222.20', '2024-11-16', 'dat_coc', ''),
(12, 1, 20, '2222.20', '2024-11-16', 'dat_coc', '\r\n'),
(13, 1, 20, '2222.20', '2024-11-16', 'dat_coc', '222\r\n'),
(14, 1, 20, '2222.20', '2024-11-16', 'dat_coc', '\r\n'),
(15, 1, 20, '2222.20', '2024-11-16', 'dat_coc', ''),
(16, 1, 20, '2222.20', '2024-11-16', 'dat_coc', ''),
(17, 1, 20, '2222.20', '2024-11-16', 'dat_coc', ''),
(18, 1, 20, '2222.20', '2024-11-16', 'dat_coc', 'hihi'),
(19, 1, 20, '2222.20', '2024-11-16', 'dat_coc', ''),
(20, 1, 20, '2222.20', '2024-11-16', 'dat_coc', ''),
(21, 1, 20, '2222.20', '2024-11-16', 'dat_coc', '3h'),
(22, 1, 20, '2222.20', '2024-11-21', 'dat_coc', 'Khệc khẹc'),
(23, 1, 20, '2222.20', '2024-11-24', 'dat_coc', '<p>C&uacute;c cu</p>\r\n'),
(47, 1, 0, '0.00', '2024-11-26', 'dat_coc', NULL),
(48, 1, 0, '0.00', '2024-11-26', 'dat_coc', NULL),
(49, 2, 0, '0.00', '2024-11-26', 'dat_coc', NULL),
(50, 2, 20, '444.40', '2024-11-26', 'dat_coc', '<p>Ch&iacute;ch vắc lỏ</p>\r\n'),
(51, 2, 20, '444.40', '2024-11-26', 'dat_coc', '<p>22</p>\r\n'),
(52, 2, 20, '444.40', '2024-11-26', 'dat_coc', '<p><em>Xin ch&agrave;o T&acirc;n l&agrave; t&ocirc;i</em></p>\r\n'),
(53, 2, 0, '0.00', '2024-11-26', 'dat_coc', NULL),
(54, 2, 0, '0.00', '2024-11-27', 'dat_coc', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dieu_kien_tiem`
--

CREATE TABLE `dieu_kien_tiem` (
  `dieu_kien_id` int(11) NOT NULL,
  `ten_dieu_kien` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mo_ta_dieu_kien` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dieu_kien_tiem`
--

INSERT INTO `dieu_kien_tiem` (`dieu_kien_id`, `ten_dieu_kien`, `mo_ta_dieu_kien`) VALUES
(1, 'Test điều kiện 2', '<p>Hihihi cặp cặp</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `doi_tuong_tiem_chung`
--

CREATE TABLE `doi_tuong_tiem_chung` (
  `doi_tuong_id` int(11) NOT NULL,
  `ten_doi_tuong` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doi_tuong_tiem_chung`
--

INSERT INTO `doi_tuong_tiem_chung` (`doi_tuong_id`, `ten_doi_tuong`) VALUES
(1, 'Người lớn'),
(2, 'Trẻ em'),
(3, 'Cu');

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `khachhang_id` int(11) NOT NULL,
  `fullname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cccd` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ngaysinh` date DEFAULT NULL,
  `gioitinh` enum('nam','nu','khac') COLLATE utf8_unicode_ci DEFAULT NULL,
  `dienthoai` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `diachi` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tinh_thanh` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `huyen` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `xa_phuong` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`khachhang_id`, `fullname`, `cccd`, `ngaysinh`, `gioitinh`, `dienthoai`, `diachi`, `tinh_thanh`, `huyen`, `xa_phuong`, `email`) VALUES
(2, 'Tăng Truyền Tín', '3445435', '2024-10-22', 'nam', '0394051627', '22', '92', '925', '31222', NULL),
(8, 'Tăng Truyền Tín', '34454352223', '2024-10-17', 'nam', '0394051627', '22', '66', '271', '27190', NULL),
(9, 'Tăng Truyền Tín', '344543531345', '2024-10-23', 'nam', '0394051627', '22', '89', '886', '30341', NULL),
(11, 'Ngô Thanh Tân', '344543565433645345', '2024-11-22', 'nam', '0999999999', '22', '67', '664', '24703', 'nttantts@gmail.com'),
(12, 'Ngân Thanh Tô', '34454351233211', '2024-11-06', 'nu', '09933543', '22', '67', '662', '24640', 'nganthanhto@gmail.com'),
(14, 'Ngô Thanh Tân 2', '3445435111', '2024-11-30', 'nam', '0999991999', '22', '66', '647', '24247', 'nguyenphuocthanh1904@gmail.com'),
(15, 'Ngô Thanh Tân', '123', '2024-11-28', 'nam', '0999999965', '22', '77', '750', '26611', 'tripvang123@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `lich_hen`
--

CREATE TABLE `lich_hen` (
  `lich_hen_id` int(11) NOT NULL,
  `khachhang_id` int(11) NOT NULL,
  `ngay_hen` date NOT NULL,
  `trang_thai` enum('cho_xac_nhan','da_xac_nhan','da_huy','hoan_thanh') COLLATE utf8_unicode_ci DEFAULT 'cho_xac_nhan',
  `ghi_chu` text COLLATE utf8_unicode_ci,
  `ngay_tao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dat_coc_id` int(11) DEFAULT NULL,
  `gio_bat_dau` time NOT NULL,
  `gio_ket_thuc` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lich_hen`
--

INSERT INTO `lich_hen` (`lich_hen_id`, `khachhang_id`, `ngay_hen`, `trang_thai`, `ghi_chu`, `ngay_tao`, `dat_coc_id`, `gio_bat_dau`, `gio_ket_thuc`) VALUES
(3, 8, '2024-11-12', 'da_xac_nhan', '<p>kehch</p>', '2024-11-10 01:56:17', 3, '00:00:00', '00:00:00'),
(7, 8, '2024-11-11', 'hoan_thanh', '<p>kehch</p>', '2024-11-10 02:33:46', 4, '00:00:00', '00:00:00'),
(17, 2, '2024-11-05', 'cho_xac_nhan', '<p>kehch</p>', '2024-11-10 03:02:30', NULL, '00:00:00', '00:00:00'),
(27, 2, '2024-11-12', 'cho_xac_nhan', '<p>kehch</p>', '2024-11-10 04:28:48', 7, '00:00:00', '00:00:00'),
(28, 2, '2024-11-04', 'hoan_thanh', '<p>kehch</p>', '2024-11-10 04:29:40', 8, '00:00:00', '00:00:00'),
(29, 2, '2024-11-10', 'hoan_thanh', '<p>kehch</p>', '2024-11-10 04:32:42', 9, '00:00:00', '00:00:00'),
(31, 11, '2024-11-12', 'cho_xac_nhan', '<p>kehch</p>', '2024-11-16 13:58:37', 15, '00:00:00', '00:00:00'),
(32, 11, '2024-11-08', 'cho_xac_nhan', '<p><strong>đ&acirc;sdasdadsad&nbsp;</strong></p>\r\n', '2024-11-16 14:21:58', 19, '12:23:00', '13:53:00'),
(33, 11, '2024-11-14', 'cho_xac_nhan', '<p>kehch</p>\r\n', '2024-11-16 15:12:07', 20, '14:13:00', '16:43:00'),
(34, 2, '2024-11-30', 'cho_xac_nhan', '<p>3h &aacute;dadasd</p>\r\n', '2024-11-16 15:12:50', 21, '15:03:00', '15:33:00'),
(35, 11, '2024-11-14', 'cho_xac_nhan', '<p>kehch</p>', '2024-11-21 05:40:17', 22, '02:41:00', '03:11:00'),
(36, 11, '2024-11-20', 'da_xac_nhan', '<p>kehch</p>', '2024-11-24 01:53:38', NULL, '10:54:00', '11:24:00'),
(37, 2, '2024-11-03', 'cho_xac_nhan', '<p>C&uacute;c cu</p>\r\n', '2024-11-24 03:51:22', 23, '00:51:00', '01:21:00'),
(38, 8, '2024-11-08', 'cho_xac_nhan', '', '2024-11-24 03:52:27', NULL, '02:54:00', '03:24:00'),
(39, 8, '2024-11-12', 'da_xac_nhan', '', '2024-11-24 03:54:37', NULL, '10:59:00', '11:29:00'),
(40, 11, '2024-11-07', 'da_xac_nhan', '', '2024-11-24 04:06:06', NULL, '02:08:00', '02:38:00'),
(41, 2, '2024-11-26', 'hoan_thanh', '', '2024-11-26 12:38:14', 47, '13:38:14', '14:38:14'),
(42, 8, '2024-11-26', 'hoan_thanh', '', '2024-11-26 12:38:32', 48, '13:38:32', '14:38:32'),
(43, 12, '2024-11-26', 'hoan_thanh', '', '2024-11-26 12:39:31', 49, '13:39:31', '14:39:31'),
(46, 12, '2024-11-27', 'hoan_thanh', '<p><em>Xin ch&agrave;o T&acirc;n l&agrave; t&ocirc;i</em></p>\r\n', '2024-11-26 13:02:12', 52, '21:01:00', '21:31:00'),
(47, 2, '2024-11-28', 'cho_xac_nhan', '', '2024-11-26 13:08:15', 53, '22:08:00', '21:08:00'),
(48, 11, '2024-11-27', 'hoan_thanh', '', '2024-11-27 04:19:18', 54, '05:19:18', '06:19:18');

-- --------------------------------------------------------

--
-- Table structure for table `lich_tiem`
--

CREATE TABLE `lich_tiem` (
  `lich_tiem_id` int(11) NOT NULL,
  `khachhang_id` int(11) NOT NULL,
  `vaccin_id` int(11) NOT NULL,
  `ngay_tiem` date NOT NULL,
  `lan_tiem` int(11) DEFAULT '1',
  `trang_thai` enum('cho_tiem','da_tiem','huy') COLLATE utf8_unicode_ci DEFAULT 'cho_tiem',
  `ghi_chu` text COLLATE utf8_unicode_ci,
  `ngay_tao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lich_tiem`
--

INSERT INTO `lich_tiem` (`lich_tiem_id`, `khachhang_id`, `vaccin_id`, `ngay_tiem`, `lan_tiem`, `trang_thai`, `ghi_chu`, `ngay_tao`) VALUES
(1, 8, 1, '2024-11-23', 1, 'cho_tiem', '<p>xa qua ni khạp</p>\r\n', '2024-11-09 05:31:34'),
(2, 8, 1, '2024-11-10', 1, 'cho_tiem', NULL, '2024-11-10 01:57:31'),
(3, 8, 1, '2024-11-10', 1, 'cho_tiem', NULL, '2024-11-10 01:57:34'),
(4, 8, 1, '2024-11-10', 1, 'cho_tiem', NULL, '2024-11-10 02:39:45'),
(5, 8, 1, '2024-11-10', 1, 'cho_tiem', NULL, '2024-11-10 02:39:48'),
(6, 2, 1, '2024-11-10', 1, 'cho_tiem', NULL, '2024-11-10 03:02:54'),
(7, 8, 1, '2024-11-10', 1, 'da_tiem', NULL, '2024-11-10 04:28:18'),
(8, 2, 1, '2024-11-12', 1, 'cho_tiem', NULL, '2024-11-10 04:28:48'),
(9, 2, 1, '2024-11-10', 1, 'cho_tiem', NULL, '2024-11-10 04:32:25'),
(10, 2, 1, '2024-11-10', 1, 'cho_tiem', NULL, '2024-11-10 04:32:28'),
(11, 2, 1, '2024-11-10', 1, 'da_tiem', '<p><strong>KHẹc khẹc</strong></p>\r\n', '2024-11-10 04:32:42'),
(12, 2, 1, '2024-11-10', 1, 'da_tiem', '', '2024-11-10 04:36:51'),
(13, 2, 1, '2024-11-10', 1, 'da_tiem', '', '2024-11-10 04:36:53'),
(14, 11, 1, '2024-11-12', 1, 'da_tiem', '', '2024-11-16 14:05:48'),
(15, 11, 1, '2024-11-08', 1, 'da_tiem', '', '2024-11-16 14:28:09'),
(16, 2, 1, '2024-11-30', 1, 'da_tiem', '', '2024-11-24 03:15:38'),
(17, 2, 1, '2024-11-26', 1, 'da_tiem', NULL, '2024-11-26 12:38:14'),
(18, 2, 1, '2024-11-26', 1, 'cho_tiem', NULL, '2024-11-26 12:38:22'),
(19, 8, 1, '2024-11-26', 1, 'da_tiem', NULL, '2024-11-26 12:38:32'),
(20, 12, 2, '2024-11-26', 1, 'da_tiem', NULL, '2024-11-26 12:39:31'),
(21, 12, 2, '2024-11-26', 1, 'cho_tiem', NULL, '2024-11-26 12:52:03'),
(22, 12, 2, '2024-11-26', 1, 'cho_tiem', NULL, '2024-11-26 13:02:30'),
(23, 2, 2, '2024-11-28', 1, 'huy', '', '2024-11-26 13:08:15'),
(24, 11, 2, '2024-11-27', 1, 'da_tiem', NULL, '2024-11-27 04:19:18');

-- --------------------------------------------------------

--
-- Table structure for table `lieu_luong_tiem`
--

CREATE TABLE `lieu_luong_tiem` (
  `lieu_luong_id` int(11) NOT NULL,
  `mo_ta` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gia_tri` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lieu_luong_tiem`
--

INSERT INTO `lieu_luong_tiem` (`lieu_luong_id`, `mo_ta`, `gia_tri`) VALUES
(1, '10 lít', '0.10'),
(2, '100 lít', '0.02'),
(3, 'Khẹc khẹc', '0.20');

-- --------------------------------------------------------

--
-- Table structure for table `lua_tuoi`
--

CREATE TABLE `lua_tuoi` (
  `lua_tuoi_id` int(11) NOT NULL,
  `ten_lua_tuoi` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mo_ta` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lua_tuoi`
--

INSERT INTO `lua_tuoi` (`lua_tuoi_id`, `ten_lua_tuoi`, `mo_ta`) VALUES
(1, 'cạp cạp', '<p>Trẻ sơ sinh đến 19 tuổi e</p>\r\n'),
(2, 'Khẹc khẹc', 'Hehehehe'),
(3, 'Khẹc khẹc', '<p><strong>Fdfsdf</strong></p>\r\n\r\n<p><strong>dsadasd</strong></p>\r\n\r\n<p>dfafmskf&nbsp; fasdfafasf</p');

-- --------------------------------------------------------

--
-- Table structure for table `mat_khau_tam`
--

CREATE TABLE `mat_khau_tam` (
  `id` int(11) NOT NULL,
  `tai_khoan_id` int(11) NOT NULL,
  `mat_khau_tam` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ngay_het_han` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `da_su_dung` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mat_khau_tam`
--

INSERT INTO `mat_khau_tam` (`id`, `tai_khoan_id`, `mat_khau_tam`, `ngay_tao`, `ngay_het_han`, `da_su_dung`) VALUES
(1, 2, '$2y$10$7He7/LPlbEmlGN83Oh525uD3.CV4vF62tIxKzIMmiCYZiTBdIIE.m', '2024-11-20 01:18:11', '2024-11-20 19:18:11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nguoithan`
--

CREATE TABLE `nguoithan` (
  `nguoithan_id` int(11) NOT NULL,
  `khachhang_id` int(11) DEFAULT NULL,
  `fullname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `quanhe` enum('vo','chong','con','bo','me','ong','ba','khac') COLLATE utf8_unicode_ci DEFAULT NULL,
  `dienthoai` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `diachi` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tinh_thanh` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `huyen` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `xa_phuong` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nguoithan`
--

INSERT INTO `nguoithan` (`nguoithan_id`, `khachhang_id`, `fullname`, `quanhe`, `dienthoai`, `diachi`, `tinh_thanh`, `huyen`, `xa_phuong`) VALUES
(3, 2, 'Ngân Thanh Tô', 'vo', '090009090', '22222', '67', '661', '24620'),
(5, 8, 'Ngân Thanh Tô', 'vo', '0394051627', '22222', '67', '', NULL),
(6, 9, 'Ngân Thanh Tô', 'vo', '090009090', '22222', '4', '53', '1810'),
(7, 11, 'nttantts@gmail.com', 'vo', '090009090', '090009090', '67', '664', '24712'),
(8, 12, 'nttantts@gmail.com', 'vo', '090009094', 'ggdfg', '11', '98', '3244'),
(9, 14, 'Ngân Thanh Tô', 'vo', '090009040', '22222', '67', '662', '24655'),
(10, 15, 'Ngân Thanh Tô', 'khac', '090009090', '22222', '67', '664', '24703');

-- --------------------------------------------------------

--
-- Table structure for table `phan_quyen`
--

CREATE TABLE `phan_quyen` (
  `id` int(11) NOT NULL,
  `vai_tro_id` int(11) DEFAULT NULL,
  `chuc_nang_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `phan_quyen`
--

INSERT INTO `phan_quyen` (`id`, `vai_tro_id`, `chuc_nang_id`) VALUES
(342, 25, 7),
(343, 25, 8),
(344, 25, 9),
(345, 25, 10),
(346, 25, 11),
(347, 25, 12),
(348, 25, 13),
(349, 25, 14),
(350, 25, 15),
(351, 25, 16),
(352, 25, 17),
(353, 25, 18),
(354, 25, 53),
(553, 24, 58),
(554, 24, 57),
(555, 24, 56),
(556, 24, 55),
(557, 24, 54),
(558, 24, 53),
(559, 24, 52),
(560, 24, 51),
(561, 24, 50),
(562, 24, 49),
(563, 24, 48),
(564, 24, 47),
(565, 24, 46),
(566, 24, 45),
(567, 24, 44),
(568, 24, 43),
(569, 24, 42),
(570, 24, 41),
(571, 24, 40),
(572, 24, 39),
(573, 24, 38),
(574, 24, 37),
(575, 24, 36),
(576, 24, 35),
(577, 24, 34),
(578, 24, 33),
(579, 24, 32),
(580, 24, 31),
(581, 24, 30),
(582, 24, 29),
(583, 24, 28),
(584, 24, 27),
(585, 24, 26),
(586, 24, 25),
(587, 24, 24),
(588, 24, 23),
(589, 24, 22),
(590, 24, 21),
(591, 24, 20),
(592, 24, 19),
(593, 24, 18),
(594, 24, 17),
(595, 24, 16),
(596, 24, 15),
(597, 24, 14),
(598, 24, 13),
(599, 24, 12),
(600, 24, 11),
(601, 24, 10),
(602, 24, 9),
(603, 24, 8),
(604, 24, 7);

-- --------------------------------------------------------

--
-- Table structure for table `phan_ung_sau_tiem`
--

CREATE TABLE `phan_ung_sau_tiem` (
  `phan_ung_id` int(11) NOT NULL,
  `lich_tiem_id` int(11) NOT NULL,
  `phan_ung` text COLLATE utf8_unicode_ci NOT NULL,
  `muc_do` enum('nhe','trung_binh','nang') COLLATE utf8_unicode_ci DEFAULT 'nhe',
  `ngay_xu_ly` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ghi_chu` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `phan_ung_sau_tiem`
--

INSERT INTO `phan_ung_sau_tiem` (`phan_ung_id`, `lich_tiem_id`, `phan_ung`, `muc_do`, `ngay_xu_ly`, `ghi_chu`) VALUES
(1, 11, 'Không có phản ứng gì luôn', 'nhe', '2024-11-11 02:39:37', ''),
(2, 7, 'Sắp chết r 3', 'nang', '2024-11-11 02:39:57', '');

-- --------------------------------------------------------

--
-- Table structure for table `phat_do_tiem`
--

CREATE TABLE `phat_do_tiem` (
  `phac_do_id` int(11) NOT NULL,
  `ten_phac_do` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lua_tuoi_id` int(11) NOT NULL,
  `lieu_luong_id` int(11) NOT NULL,
  `lich_tiem` text COLLATE utf8_unicode_ci NOT NULL,
  `lieu_nhac` text COLLATE utf8_unicode_ci,
  `ghi_chu` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `phat_do_tiem`
--

INSERT INTO `phat_do_tiem` (`phac_do_id`, `ten_phac_do`, `lua_tuoi_id`, `lieu_luong_id`, `lich_tiem`, `lieu_nhac`, `ghi_chu`) VALUES
(1, 'Viêm Gan siêu vi B C D E F G H', 2, 1, '<p>HIHIH</p>\r\n', '<p>HIHIHI</p>\r\n', '<p>HIHIHIHI cạp</p>\r\n'),
(2, 'Viêm Gan siêu vi B', 2, 3, '<p>Ti&ecirc;m d&ocirc; lỗ đ&iacute;t</p>\r\n\r\n<p>Ti&ecirc;m kế lỗ đ&iacute;t</p>\r\n', '<p>Kh&ocirc;ng tim</p>\r\n', '<p>Cạp cạp cạp</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `tai_khoan`
--

CREATE TABLE `tai_khoan` (
  `id` int(11) NOT NULL,
  `ten_dang_nhap` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mat_khau` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ho_ten` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gioi_tinh` enum('nam','nu','khong_xac_dinh') COLLATE utf8_unicode_ci DEFAULT 'khong_xac_dinh',
  `dien_thoai` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vai_tro_id` int(11) DEFAULT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `trang_thai` enum('dang_hoat_dong','khoa','dong') COLLATE utf8_unicode_ci DEFAULT 'dang_hoat_dong',
  `anh_dai_dien` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tai_khoan`
--

INSERT INTO `tai_khoan` (`id`, `ten_dang_nhap`, `mat_khau`, `email`, `ho_ten`, `gioi_tinh`, `dien_thoai`, `vai_tro_id`, `ngay_tao`, `trang_thai`, `anh_dai_dien`) VALUES
(1, 'admin', '$2y$10$xc3i.3CLxhcLrL5l1oW/B.X7L5YtOmaDIASw8pVDTf4EDiftBS8oS', 'admin@gmail.com', 'Nguyễn Văn Admin', 'nam', '0999999999', 24, '2024-10-20 04:34:56', 'dang_hoat_dong', 'uploads/avatars/avatar_1732078680_673d6c58e52c3.png'),
(2, 'nhanvien', '$2y$10$kc.dqHDGIuKHffoo46q71O0AV/vjqYu951vso395YLZ6mvaocQKnK', 'nttan2001042@student.ctuet.edu.vn', 'Tăng Truyền Tínnnkf2', 'nam', '0999999999', 25, '2024-11-12 03:35:51', 'dang_hoat_dong', 'uploads/avatars/avatar_1732078721_673d6c817fd2d.png'),
(3, 'demo', '$2y$10$/1q/vFE06C4bBLcbOwFdy.GrRQUHl/EG0p/MmYXTi3RSK3JvGSoVy', 'nttantts@gmail.com', 'demo123', 'nam', '0999999999', 25, '2024-11-20 01:59:44', 'dang_hoat_dong', 'uploads/avatars/avatar_1732078700_673d6c6ca3465.png'),
(5, 'demouphinh', '$2y$10$moHkh7g4BJCwJRqEMJ6GfOji21Y7IJTyN9zol7nxKLZ8iIBEF6frG', 'nttantts222@gmail.com', 'demouphinh', 'nam', '0999999999', 24, '2024-11-20 03:10:56', 'dang_hoat_dong', 'uploads/avatars/avatar_1732078710_673d6c7647326.png'),
(6, 'admin123', '$2y$10$62wzJ5guwUFz9T4wz3SGm.qsvDq5WeSVdq2lVAIAdeEmzIcaQR16S', 'admin123@gmail.com', 'admin123', 'nam', '0999999999', 24, '2024-11-20 03:12:42', 'dang_hoat_dong', 'uploads/avatars/avatar_1732078691_673d6c6322177.png');

-- --------------------------------------------------------

--
-- Table structure for table `thanh_toan`
--

CREATE TABLE `thanh_toan` (
  `thanh_toan_id` int(11) NOT NULL,
  `lich_hen_id` int(11) NOT NULL,
  `dat_coc_id` int(11) NOT NULL,
  `so_tien_con_lai` decimal(10,2) DEFAULT '0.00',
  `ngay_thanh_toan` date DEFAULT NULL,
  `trang_thai` enum('chua_thanh_toan','da_thanh_toan') COLLATE utf8_unicode_ci DEFAULT 'chua_thanh_toan',
  `ghi_chu` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `thanh_toan`
--

INSERT INTO `thanh_toan` (`thanh_toan_id`, `lich_hen_id`, `dat_coc_id`, `so_tien_con_lai`, `ngay_thanh_toan`, `trang_thai`, `ghi_chu`) VALUES
(1, 3, 3, '8888.80', '2024-11-10', 'da_thanh_toan', 'Thanh toán hoàn tất'),
(2, 7, 4, '8888.80', '2024-11-10', 'da_thanh_toan', 'Thanh toán hoàn tất'),
(3, 17, 5, '8888.80', '2024-11-10', 'da_thanh_toan', 'Thanh toán hoàn tất'),
(7, 27, 7, '11111.00', '2024-11-10', 'da_thanh_toan', NULL),
(8, 28, 8, '8888.80', '2024-11-10', 'da_thanh_toan', 'Thanh toán hoàn tất'),
(9, 29, 9, '11111.00', '2024-11-10', 'da_thanh_toan', 'Thanh toán hoàn tất'),
(10, 41, 47, '11111.00', '2024-11-26', 'da_thanh_toan', 'Thanh toán hoàn tất'),
(11, 42, 48, '11111.00', '2024-11-26', 'chua_thanh_toan', NULL),
(12, 43, 49, '2222.00', '2024-11-26', 'da_thanh_toan', 'Thanh toán hoàn tất'),
(15, 46, 52, '1777.60', '2024-11-26', 'da_thanh_toan', 'Thanh toán hoàn tất'),
(16, 47, 53, '2222.00', '2024-11-26', 'chua_thanh_toan', NULL),
(17, 48, 54, '2222.00', '2024-11-27', 'chua_thanh_toan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vaccine`
--

CREATE TABLE `vaccine` (
  `vaccin_id` int(11) NOT NULL,
  `ten_vaccine` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nha_san_xuat` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `loai_vaccine` enum('tiem_mot_lan','tiem_nhac_lai') COLLATE utf8_unicode_ci NOT NULL,
  `so_lo_san_xuat` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ngay_san_xuat` date NOT NULL,
  `han_su_dung` date NOT NULL,
  `ngay_nhap` date NOT NULL,
  `mo_ta` text COLLATE utf8_unicode_ci,
  `gia_tien` decimal(10,2) NOT NULL,
  `so_luong` int(11) NOT NULL,
  `ghi_chu` text COLLATE utf8_unicode_ci,
  `benh_id` int(11) DEFAULT NULL,
  `doi_tuong_id` int(11) DEFAULT NULL,
  `phac_do_id` int(11) DEFAULT NULL,
  `dieu_kien_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vaccine`
--

INSERT INTO `vaccine` (`vaccin_id`, `ten_vaccine`, `nha_san_xuat`, `loai_vaccine`, `so_lo_san_xuat`, `ngay_san_xuat`, `han_su_dung`, `ngay_nhap`, `mo_ta`, `gia_tien`, `so_luong`, `ghi_chu`, `benh_id`, `doi_tuong_id`, `phac_do_id`, `dieu_kien_id`) VALUES
(1, 'Verorab 2', 'Sanofi Pasteur (Pháp)', 'tiem_mot_lan', '21221', '2024-11-21', '2024-11-23', '2024-11-07', '111', '11111.00', 106, '11', 1, 1, 1, 1),
(2, 'Vắc lỏ', 'Sanofi Pasteur (Pháp)', 'tiem_mot_lan', '21221', '2024-11-13', '2024-11-30', '2024-11-26', '22', '2222.00', 22, '22', 1, 3, 1, 1),
(4, '32', '32', 'tiem_mot_lan', '32', '2024-11-20', '2024-12-07', '2024-11-22', '2', '2.00', 2, '2', 1, 3, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vai_tro`
--

CREATE TABLE `vai_tro` (
  `id` int(11) NOT NULL,
  `ten_vai_tro` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mo_ta` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vai_tro`
--

INSERT INTO `vai_tro` (`id`, `ten_vai_tro`, `mo_ta`) VALUES
(24, 'Quản trị viên', ''),
(25, 'Nhân viên thực tập', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `benh`
--
ALTER TABLE `benh`
  ADD PRIMARY KEY (`benh_id`),
  ADD KEY `danh_muc_id` (`danh_muc_id`);

--
-- Indexes for table `chuc_nang`
--
ALTER TABLE `chuc_nang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dang_ky_tiem_tai_nha`
--
ALTER TABLE `dang_ky_tiem_tai_nha`
  ADD PRIMARY KEY (`dang_ky_id`);

--
-- Indexes for table `danh_muc_benh`
--
ALTER TABLE `danh_muc_benh`
  ADD PRIMARY KEY (`danh_muc_id`);

--
-- Indexes for table `dat_coc`
--
ALTER TABLE `dat_coc`
  ADD PRIMARY KEY (`dat_coc_id`),
  ADD KEY `vaccine_id` (`vaccine_id`);

--
-- Indexes for table `dieu_kien_tiem`
--
ALTER TABLE `dieu_kien_tiem`
  ADD PRIMARY KEY (`dieu_kien_id`);

--
-- Indexes for table `doi_tuong_tiem_chung`
--
ALTER TABLE `doi_tuong_tiem_chung`
  ADD PRIMARY KEY (`doi_tuong_id`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`khachhang_id`),
  ADD UNIQUE KEY `cccd` (`cccd`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `lich_hen`
--
ALTER TABLE `lich_hen`
  ADD PRIMARY KEY (`lich_hen_id`),
  ADD KEY `khachhang_id` (`khachhang_id`),
  ADD KEY `dat_coc_id` (`dat_coc_id`);

--
-- Indexes for table `lich_tiem`
--
ALTER TABLE `lich_tiem`
  ADD PRIMARY KEY (`lich_tiem_id`),
  ADD KEY `khachhang_id` (`khachhang_id`),
  ADD KEY `vaccin_id` (`vaccin_id`);

--
-- Indexes for table `lieu_luong_tiem`
--
ALTER TABLE `lieu_luong_tiem`
  ADD PRIMARY KEY (`lieu_luong_id`);

--
-- Indexes for table `lua_tuoi`
--
ALTER TABLE `lua_tuoi`
  ADD PRIMARY KEY (`lua_tuoi_id`);

--
-- Indexes for table `mat_khau_tam`
--
ALTER TABLE `mat_khau_tam`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tai_khoan_id` (`tai_khoan_id`);

--
-- Indexes for table `nguoithan`
--
ALTER TABLE `nguoithan`
  ADD PRIMARY KEY (`nguoithan_id`),
  ADD KEY `khachhang_id` (`khachhang_id`);

--
-- Indexes for table `phan_quyen`
--
ALTER TABLE `phan_quyen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vai_tro_id` (`vai_tro_id`),
  ADD KEY `chuc_nang_id` (`chuc_nang_id`);

--
-- Indexes for table `phan_ung_sau_tiem`
--
ALTER TABLE `phan_ung_sau_tiem`
  ADD PRIMARY KEY (`phan_ung_id`),
  ADD KEY `lich_tiem_id` (`lich_tiem_id`);

--
-- Indexes for table `phat_do_tiem`
--
ALTER TABLE `phat_do_tiem`
  ADD PRIMARY KEY (`phac_do_id`),
  ADD KEY `fk_lua_tuoi` (`lua_tuoi_id`),
  ADD KEY `fk_lieu_luong` (`lieu_luong_id`);

--
-- Indexes for table `tai_khoan`
--
ALTER TABLE `tai_khoan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten_dang_nhap` (`ten_dang_nhap`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `vai_tro_id` (`vai_tro_id`);

--
-- Indexes for table `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD PRIMARY KEY (`thanh_toan_id`),
  ADD KEY `lich_hen_id` (`lich_hen_id`),
  ADD KEY `dat_coc_id` (`dat_coc_id`);

--
-- Indexes for table `vaccine`
--
ALTER TABLE `vaccine`
  ADD PRIMARY KEY (`vaccin_id`),
  ADD KEY `benh_id` (`benh_id`),
  ADD KEY `doi_tuong_id` (`doi_tuong_id`),
  ADD KEY `phac_do_id` (`phac_do_id`),
  ADD KEY `dieu_kien_id` (`dieu_kien_id`);

--
-- Indexes for table `vai_tro`
--
ALTER TABLE `vai_tro`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `benh`
--
ALTER TABLE `benh`
  MODIFY `benh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `chuc_nang`
--
ALTER TABLE `chuc_nang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `dang_ky_tiem_tai_nha`
--
ALTER TABLE `dang_ky_tiem_tai_nha`
  MODIFY `dang_ky_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `danh_muc_benh`
--
ALTER TABLE `danh_muc_benh`
  MODIFY `danh_muc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `dat_coc`
--
ALTER TABLE `dat_coc`
  MODIFY `dat_coc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `dieu_kien_tiem`
--
ALTER TABLE `dieu_kien_tiem`
  MODIFY `dieu_kien_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `doi_tuong_tiem_chung`
--
ALTER TABLE `doi_tuong_tiem_chung`
  MODIFY `doi_tuong_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `khachhang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `lich_hen`
--
ALTER TABLE `lich_hen`
  MODIFY `lich_hen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `lich_tiem`
--
ALTER TABLE `lich_tiem`
  MODIFY `lich_tiem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `lieu_luong_tiem`
--
ALTER TABLE `lieu_luong_tiem`
  MODIFY `lieu_luong_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `lua_tuoi`
--
ALTER TABLE `lua_tuoi`
  MODIFY `lua_tuoi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mat_khau_tam`
--
ALTER TABLE `mat_khau_tam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `nguoithan`
--
ALTER TABLE `nguoithan`
  MODIFY `nguoithan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `phan_quyen`
--
ALTER TABLE `phan_quyen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=605;
--
-- AUTO_INCREMENT for table `phan_ung_sau_tiem`
--
ALTER TABLE `phan_ung_sau_tiem`
  MODIFY `phan_ung_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `phat_do_tiem`
--
ALTER TABLE `phat_do_tiem`
  MODIFY `phac_do_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tai_khoan`
--
ALTER TABLE `tai_khoan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `thanh_toan`
--
ALTER TABLE `thanh_toan`
  MODIFY `thanh_toan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `vaccine`
--
ALTER TABLE `vaccine`
  MODIFY `vaccin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `vai_tro`
--
ALTER TABLE `vai_tro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `benh`
--
ALTER TABLE `benh`
  ADD CONSTRAINT `benh_ibfk_1` FOREIGN KEY (`danh_muc_id`) REFERENCES `danh_muc_benh` (`danh_muc_id`);

--
-- Constraints for table `dat_coc`
--
ALTER TABLE `dat_coc`
  ADD CONSTRAINT `dat_coc_ibfk_1` FOREIGN KEY (`vaccine_id`) REFERENCES `vaccine` (`vaccin_id`) ON DELETE CASCADE;

--
-- Constraints for table `lich_hen`
--
ALTER TABLE `lich_hen`
  ADD CONSTRAINT `lich_hen_ibfk_1` FOREIGN KEY (`khachhang_id`) REFERENCES `khachhang` (`khachhang_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lich_hen_ibfk_2` FOREIGN KEY (`dat_coc_id`) REFERENCES `dat_coc` (`dat_coc_id`) ON DELETE SET NULL;

--
-- Constraints for table `lich_tiem`
--
ALTER TABLE `lich_tiem`
  ADD CONSTRAINT `lich_tiem_ibfk_1` FOREIGN KEY (`khachhang_id`) REFERENCES `khachhang` (`khachhang_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lich_tiem_ibfk_2` FOREIGN KEY (`vaccin_id`) REFERENCES `vaccine` (`vaccin_id`) ON DELETE CASCADE;

--
-- Constraints for table `mat_khau_tam`
--
ALTER TABLE `mat_khau_tam`
  ADD CONSTRAINT `mat_khau_tam_ibfk_1` FOREIGN KEY (`tai_khoan_id`) REFERENCES `tai_khoan` (`id`);

--
-- Constraints for table `nguoithan`
--
ALTER TABLE `nguoithan`
  ADD CONSTRAINT `nguoithan_ibfk_1` FOREIGN KEY (`khachhang_id`) REFERENCES `khachhang` (`khachhang_id`) ON DELETE CASCADE;

--
-- Constraints for table `phan_quyen`
--
ALTER TABLE `phan_quyen`
  ADD CONSTRAINT `phan_quyen_ibfk_1` FOREIGN KEY (`vai_tro_id`) REFERENCES `vai_tro` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `phan_quyen_ibfk_2` FOREIGN KEY (`chuc_nang_id`) REFERENCES `chuc_nang` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `phan_ung_sau_tiem`
--
ALTER TABLE `phan_ung_sau_tiem`
  ADD CONSTRAINT `phan_ung_sau_tiem_ibfk_1` FOREIGN KEY (`lich_tiem_id`) REFERENCES `lich_tiem` (`lich_tiem_id`) ON DELETE CASCADE;

--
-- Constraints for table `phat_do_tiem`
--
ALTER TABLE `phat_do_tiem`
  ADD CONSTRAINT `fk_lieu_luong` FOREIGN KEY (`lieu_luong_id`) REFERENCES `lieu_luong_tiem` (`lieu_luong_id`),
  ADD CONSTRAINT `fk_lua_tuoi` FOREIGN KEY (`lua_tuoi_id`) REFERENCES `lua_tuoi` (`lua_tuoi_id`);

--
-- Constraints for table `tai_khoan`
--
ALTER TABLE `tai_khoan`
  ADD CONSTRAINT `tai_khoan_ibfk_1` FOREIGN KEY (`vai_tro_id`) REFERENCES `vai_tro` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD CONSTRAINT `thanh_toan_ibfk_1` FOREIGN KEY (`lich_hen_id`) REFERENCES `lich_hen` (`lich_hen_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `thanh_toan_ibfk_2` FOREIGN KEY (`dat_coc_id`) REFERENCES `dat_coc` (`dat_coc_id`) ON DELETE CASCADE;

--
-- Constraints for table `vaccine`
--
ALTER TABLE `vaccine`
  ADD CONSTRAINT `vaccine_ibfk_1` FOREIGN KEY (`benh_id`) REFERENCES `benh` (`benh_id`),
  ADD CONSTRAINT `vaccine_ibfk_2` FOREIGN KEY (`doi_tuong_id`) REFERENCES `doi_tuong_tiem_chung` (`doi_tuong_id`),
  ADD CONSTRAINT `vaccine_ibfk_3` FOREIGN KEY (`phac_do_id`) REFERENCES `phat_do_tiem` (`phac_do_id`),
  ADD CONSTRAINT `vaccine_ibfk_4` FOREIGN KEY (`dieu_kien_id`) REFERENCES `dieu_kien_tiem` (`dieu_kien_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
