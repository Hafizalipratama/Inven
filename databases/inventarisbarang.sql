-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 05, 2023 at 06:21 PM
-- Server version: 8.0.30
-- PHP Version: 7.4.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventarisbarang`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `Id_Barang` int NOT NULL,
  `Id_Kategori` int NOT NULL,
  `Nama_Barang` varchar(45) NOT NULL,
  `Merek` varchar(45) NOT NULL,
  `Gambar_Barang` varchar(500) NOT NULL,
  `Jumlah_Aset` varchar(500) NOT NULL,
  `Nilai_Per_Aset` varchar(500) NOT NULL,
  `Id_Ruangan` int NOT NULL,
  `Id_Kondisi` int NOT NULL,
  `Asal_Perolehan` varchar(35) NOT NULL,
  `Tahun_Perolehan` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`Id_Barang`, `Id_Kategori`, `Nama_Barang`, `Merek`, `Gambar_Barang`, `Jumlah_Aset`, `Nilai_Per_Aset`, `Id_Ruangan`, `Id_Kondisi`, `Asal_Perolehan`, `Tahun_Perolehan`) VALUES
(1, 1, 'TV', 'LG-14', 'http://localhost/invetarisbarang/uploads/files/5ha2jd1tq7mwxkf.jpg', '7', '12000000', 1, 1, 'Dinas Pendidikan Prov', '2021'),
(2, 1, 'Laptop', 'ASUS', 'http://localhost/invetarisbarang/uploads/files/m25z0ft9l1axkj8.png', '15', '4500000', 1, 1, 'Tokopedia', '2022');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `Id_Kategori` int NOT NULL,
  `Kategori` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`Id_Kategori`, `Kategori`) VALUES
(1, 'Barang Elektronik'),
(2, 'Sarana'),
(3, 'ATK');

-- --------------------------------------------------------

--
-- Table structure for table `kondisi`
--

CREATE TABLE `kondisi` (
  `Id_Kondisi` int NOT NULL,
  `Kondisi` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kondisi`
--

INSERT INTO `kondisi` (`Id_Kondisi`, `Kondisi`) VALUES
(1, 'Baik'),
(2, 'Rusak Ringan'),
(3, 'Rusak Berat');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `Id_Peminjaman` int NOT NULL,
  `Id_Barang` int NOT NULL,
  `Id_User` int NOT NULL,
  `Qty` int NOT NULL,
  `Tgl_Pinjam` date NOT NULL,
  `Tgl_Kembali` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`Id_Peminjaman`, `Id_Barang`, `Id_User`, `Qty`, `Tgl_Pinjam`, `Tgl_Kembali`) VALUES
(13, 1, 1, 3, '2023-01-05', NULL),
(14, 1, 1, 2, '2023-01-05', '2023-01-05');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'Administrator'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `permission_id` int NOT NULL,
  `role_id` int NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `action_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`permission_id`, `role_id`, `page_name`, `action_name`) VALUES
(1, 1, 'barang', 'list'),
(2, 1, 'barang', 'view'),
(3, 1, 'barang', 'add'),
(4, 1, 'barang', 'edit'),
(5, 1, 'barang', 'editfield'),
(6, 1, 'barang', 'delete'),
(7, 1, 'barang', 'import_data'),
(8, 1, 'kategori', 'list'),
(9, 1, 'kategori', 'view'),
(10, 1, 'kategori', 'add'),
(11, 1, 'kategori', 'edit'),
(12, 1, 'kategori', 'editfield'),
(13, 1, 'kategori', 'delete'),
(14, 1, 'kategori', 'import_data'),
(15, 1, 'kondisi', 'list'),
(16, 1, 'kondisi', 'view'),
(17, 1, 'kondisi', 'add'),
(18, 1, 'kondisi', 'edit'),
(19, 1, 'kondisi', 'editfield'),
(20, 1, 'kondisi', 'delete'),
(21, 1, 'kondisi', 'import_data'),
(22, 1, 'ruang', 'list'),
(23, 1, 'ruang', 'view'),
(24, 1, 'ruang', 'add'),
(25, 1, 'ruang', 'edit'),
(26, 1, 'ruang', 'editfield'),
(27, 1, 'ruang', 'delete'),
(28, 1, 'ruang', 'import_data'),
(29, 1, 'user', 'list'),
(30, 1, 'user', 'view'),
(31, 1, 'user', 'add'),
(32, 1, 'user', 'edit'),
(33, 1, 'user', 'editfield'),
(34, 1, 'user', 'delete'),
(35, 1, 'user', 'import_data'),
(36, 1, 'user', 'userregister'),
(37, 1, 'user', 'accountedit'),
(38, 1, 'user', 'accountview'),
(39, 1, 'role_permissions', 'list'),
(40, 1, 'role_permissions', 'view'),
(41, 1, 'role_permissions', 'add'),
(42, 1, 'role_permissions', 'edit'),
(43, 1, 'role_permissions', 'editfield'),
(44, 1, 'role_permissions', 'delete'),
(45, 1, 'roles', 'list'),
(46, 1, 'roles', 'view'),
(47, 1, 'roles', 'add'),
(48, 1, 'roles', 'edit'),
(49, 1, 'roles', 'editfield'),
(50, 1, 'roles', 'delete'),
(51, 2, 'barang', 'list'),
(52, 2, 'barang', 'view'),
(53, 2, 'barang', 'add'),
(54, 2, 'barang', 'edit'),
(55, 2, 'barang', 'editfield'),
(56, 2, 'barang', 'delete'),
(57, 2, 'barang', 'import_data'),
(58, 2, 'kategori', 'list'),
(59, 2, 'kategori', 'view'),
(60, 2, 'kategori', 'add'),
(61, 2, 'kategori', 'edit'),
(62, 2, 'kategori', 'editfield'),
(63, 2, 'kategori', 'delete'),
(64, 2, 'kategori', 'import_data'),
(65, 2, 'kondisi', 'list'),
(66, 2, 'kondisi', 'view'),
(67, 2, 'kondisi', 'add'),
(68, 2, 'kondisi', 'edit'),
(69, 2, 'kondisi', 'editfield'),
(70, 2, 'kondisi', 'delete'),
(71, 2, 'kondisi', 'import_data'),
(72, 2, 'ruang', 'list'),
(73, 2, 'ruang', 'view'),
(74, 2, 'ruang', 'add'),
(75, 2, 'ruang', 'edit'),
(76, 2, 'ruang', 'editfield'),
(77, 2, 'ruang', 'delete'),
(78, 2, 'ruang', 'import_data'),
(79, 2, 'user', 'userregister'),
(80, 2, 'user', 'accountedit'),
(81, 2, 'user', 'accountview'),
(82, 1, 'peminjaman', 'list'),
(83, 1, 'peminjaman', 'view'),
(84, 1, 'peminjaman', 'add'),
(85, 1, 'peminjaman', 'edit'),
(86, 1, 'peminjaman', 'editfield'),
(87, 1, 'peminjaman', 'delete'),
(88, 1, 'peminjaman', 'import_data'),
(89, 1, 'peminjaman', 'kembalikan'),
(90, 2, 'peminjaman', 'list'),
(91, 2, 'peminjaman', 'view'),
(92, 2, 'peminjaman', 'add'),
(93, 1, 'peminjaman', 'scan'),
(94, 2, 'peminjaman', 'scan');

-- --------------------------------------------------------

--
-- Table structure for table `ruang`
--

CREATE TABLE `ruang` (
  `Id_Ruangan` int NOT NULL,
  `Ruangan` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruang`
--

INSERT INTO `ruang` (`Id_Ruangan`, `Ruangan`) VALUES
(1, 'Ruang Manager Umum'),
(2, 'Ruang Marketing');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `photo` varchar(500) NOT NULL,
  `login_session_key` varchar(255) DEFAULT NULL,
  `email_status` varchar(255) DEFAULT NULL,
  `password_expire_date` datetime DEFAULT '2021-10-11 00:00:00',
  `password_reset_key` varchar(255) DEFAULT NULL,
  `user_role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `email`, `photo`, `login_session_key`, `email_status`, `password_expire_date`, `password_reset_key`, `user_role_id`) VALUES
(1, 'admin', '$2y$10$nr7JRdebSHGBWAnAviWKo.vGmYTq6W65TTNFQLLLG6atAW/CmW/Sa', 'Administrator', 'Administrator@gmail.com', '', NULL, NULL, '2021-10-11 00:00:00', NULL, 1),
(2, 'user', '$2y$10$UTrhDCPiBRiIk3MwH4KlC.BdeQKUQPu0.Ehm9FO.AUiAeOL.wCH.m', 'user', 'user@gmail.com', 'http://localhost/invetarisbarang/uploads/files/g_fd34lna7pev29.jpg', NULL, NULL, '2021-10-11 00:00:00', NULL, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`Id_Barang`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`Id_Kategori`);

--
-- Indexes for table `kondisi`
--
ALTER TABLE `kondisi`
  ADD PRIMARY KEY (`Id_Kondisi`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`Id_Peminjaman`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `ruang`
--
ALTER TABLE `ruang`
  ADD PRIMARY KEY (`Id_Ruangan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `Id_Barang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `Id_Kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kondisi`
--
ALTER TABLE `kondisi`
  MODIFY `Id_Kondisi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `Id_Peminjaman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `permission_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `ruang`
--
ALTER TABLE `ruang`
  MODIFY `Id_Ruangan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
