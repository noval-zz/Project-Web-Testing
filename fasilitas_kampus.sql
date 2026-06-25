-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 22, 2026 at 06:36 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fasilitas_kampus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(10) UNSIGNED NOT NULL,
  `nip` bigint(20) NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `sandi` varchar(255) NOT NULL,
  `kontak` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nip`, `nama_admin`, `sandi`, `kontak`, `created_at`, `updated_at`) VALUES
(3, 123456, 'Arkan', '$2y$12$Eej.53w.jvkOZjgR5hdot.C0r7sn/Yd9G66JGtqCFWVrwyOIuVfV2', 8123456789, '2026-06-10 17:30:23', '2026-06-10 17:30:23'),
(4, 241011126, 'Akuadmin', '$2y$12$/yQoyNjGNGvf8202btqai.H1lDG4/q/a5KCHlJM9EFE4pPjbZxxAO', 8821821, '2026-06-10 17:34:27', '2026-06-10 17:34:27'),
(5, 1234567890, 'Admin Test', '$2y$12$Y9KYgpIPp6vsUu2As.v2rO2.3QORMyExDAdAakeMw89NlDJtRbCB2', 81234567890, '2026-06-11 07:35:18', '2026-06-11 07:35:18'),
(8, 241011124, 'Akmal Ahsan', '$2y$12$qNaQxbiiVbumAC.e5QoVpOruufUS.197ECy7Qzbts5juW/2ZAXqZ6', 828283821, '2026-06-20 02:00:51', '2026-06-20 02:00:51');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `aktivitas` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `aktivitas`, `keterangan`, `ip_address`, `created_at`) VALUES
(1, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-11 15:08:07'),
(2, 8, 'Hapus Pengguna', 'Menghapus pengguna: superadmin', '127.0.0.1', '2026-06-11 15:09:34'),
(3, 8, 'Tambah Pengguna', 'Menambahkan pengguna: Akmal (role: admin)', '127.0.0.1', '2026-06-11 15:13:29'),
(4, 8, 'Hapus Pengguna', 'Menghapus pengguna: 241011127', '127.0.0.1', '2026-06-11 15:13:46'),
(5, 8, 'Hapus Pengguna', 'Menghapus pengguna: 12345678', '127.0.0.1', '2026-06-11 15:13:50'),
(6, 8, 'Hapus Pengguna', 'Menghapus pengguna: 24101112602', '127.0.0.1', '2026-06-11 15:13:55'),
(7, 8, 'Hapus Pengguna', 'Menghapus pengguna: 2410111266', '127.0.0.1', '2026-06-11 15:13:57'),
(8, 8, 'Hapus Pengguna', 'Menghapus pengguna: 24101112367', '127.0.0.1', '2026-06-11 15:14:00'),
(9, 8, 'Nonaktifkan Akun', 'Mengubah status pengguna 123456 menjadi nonaktif', '127.0.0.1', '2026-06-11 15:14:41'),
(10, 8, 'Hapus Pengguna', 'Menghapus pengguna: 123456', '127.0.0.1', '2026-06-11 15:14:45'),
(11, 8, 'Hapus Pengguna', 'Menghapus pengguna: 241011120', '127.0.0.1', '2026-06-11 15:14:49'),
(12, 8, 'Hapus Pengguna', 'Menghapus pengguna: 241011129', '127.0.0.1', '2026-06-11 15:14:52'),
(13, 8, 'Hapus Pengguna', 'Menghapus pengguna: akuadmin', '127.0.0.1', '2026-06-11 15:14:56'),
(14, 8, 'Hapus Pengguna', 'Menghapus pengguna: 123321', '127.0.0.1', '2026-06-11 15:15:02'),
(15, 8, 'Hapus Pengguna', 'Menghapus pengguna: 12345', '127.0.0.1', '2026-06-11 15:15:06'),
(16, 8, 'Hapus Pengguna', 'Menghapus pengguna: 22222', '127.0.0.1', '2026-06-11 15:15:09'),
(17, 8, 'Hapus Pengguna', 'Menghapus pengguna: 241011123', '127.0.0.1', '2026-06-11 15:15:13'),
(18, 23, 'Login', 'Pengguna admin_test berhasil login.', '::1', '2026-06-11 15:35:32'),
(19, 8, 'Tambah Pengguna', 'Menambahkan pengguna: fatir (role: admin)', '127.0.0.1', '2026-06-11 15:37:29'),
(20, 8, 'Upload Foto Profil', 'Super Admin mengganti foto profil.', '127.0.0.1', '2026-06-11 15:38:10'),
(21, 8, 'Upload Foto Profil', 'Super Admin mengganti foto profil.', '127.0.0.1', '2026-06-11 15:38:18'),
(22, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-11 15:38:35'),
(23, 24, 'Login', 'Pengguna fatir berhasil login.', '127.0.0.1', '2026-06-11 15:38:45'),
(24, 24, 'Logout', 'Pengguna fatir logout.', '127.0.0.1', '2026-06-11 15:40:03'),
(25, 25, 'Login', 'Pengguna 241011122 berhasil login.', '127.0.0.1', '2026-06-11 15:41:11'),
(26, 25, 'Logout', 'Pengguna 241011122 logout.', '127.0.0.1', '2026-06-11 15:44:05'),
(27, 22, 'Login', 'Pengguna Akmal berhasil login.', '127.0.0.1', '2026-06-11 15:44:13'),
(28, 22, 'Logout', 'Pengguna Akmal logout.', '127.0.0.1', '2026-06-11 15:53:35'),
(29, 25, 'Login', 'Pengguna 241011122 berhasil login.', '127.0.0.1', '2026-06-11 15:53:57'),
(30, 25, 'Logout', 'Pengguna 241011122 logout.', '127.0.0.1', '2026-06-11 15:54:31'),
(31, 22, 'Login', 'Pengguna Akmal berhasil login.', '127.0.0.1', '2026-06-11 15:54:34'),
(32, 22, 'Logout', 'Pengguna Akmal logout.', '127.0.0.1', '2026-06-11 16:01:43'),
(33, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-11 16:02:01'),
(34, 8, 'Tambah Pengguna', 'Menambahkan pengguna: Fatih (role: admin)', '127.0.0.1', '2026-06-11 16:03:18'),
(35, 8, 'Hapus Pengguna', 'Menghapus pengguna: 241011126', '127.0.0.1', '2026-06-11 16:03:31'),
(36, 8, 'Tambah Gedung', 'Menambahkan gedung: Gedung Laboratorium', '127.0.0.1', '2026-06-11 16:04:06'),
(37, 8, 'Tambah Lantai', 'Menambahkan lantai: floor 1', '127.0.0.1', '2026-06-11 16:04:24'),
(38, 8, 'Tambah Ruangan', 'Menambahkan ruangan: Ruang kelas 101', '127.0.0.1', '2026-06-11 16:04:45'),
(39, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-11 16:05:07'),
(40, 26, 'Login', 'Pengguna Fatih berhasil login.', '127.0.0.1', '2026-06-11 16:05:16'),
(41, 26, 'Logout', 'Pengguna Fatih logout.', '127.0.0.1', '2026-06-11 16:13:36'),
(42, 25, 'Login', 'Pengguna 241011122 berhasil login.', '127.0.0.1', '2026-06-11 16:13:49'),
(43, 25, 'Logout', 'Pengguna 241011122 logout.', '127.0.0.1', '2026-06-11 16:15:32'),
(44, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-11 16:15:35'),
(45, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-11 16:15:51'),
(46, 22, 'Login', 'Pengguna Akmal berhasil login.', '127.0.0.1', '2026-06-11 16:15:59'),
(47, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-12 16:04:26'),
(48, 8, 'Tambah Pengguna', 'Menambahkan pengguna: Pablo (role: mahasiswa)', '127.0.0.1', '2026-06-12 16:05:27'),
(49, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-12 16:05:40'),
(50, 27, 'Login', 'Pengguna Pablo berhasil login.', '127.0.0.1', '2026-06-12 16:05:53'),
(51, 27, 'Logout', 'Pengguna Pablo logout.', '127.0.0.1', '2026-06-12 16:35:21'),
(52, 27, 'Login', 'Pengguna Pablo berhasil login.', '127.0.0.1', '2026-06-12 16:35:36'),
(53, 27, 'Logout', 'Pengguna Pablo logout.', '127.0.0.1', '2026-06-12 16:43:53'),
(54, 28, 'Login', 'Pengguna 123456789 berhasil login.', '127.0.0.1', '2026-06-12 16:44:32'),
(55, 27, 'Login', 'Pengguna Pablo berhasil login.', '127.0.0.1', '2026-06-12 16:54:33'),
(56, 28, 'Logout', 'Pengguna 123456789 logout.', '127.0.0.1', '2026-06-12 17:00:47'),
(57, 22, 'Login', 'Pengguna Akmal berhasil login.', '127.0.0.1', '2026-06-12 17:00:59'),
(58, 22, 'Login', 'Pengguna Akmal berhasil login.', '127.0.0.1', '2026-06-13 14:45:48'),
(59, 22, 'Logout', 'Pengguna Akmal logout.', '127.0.0.1', '2026-06-13 15:03:49'),
(60, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-13 15:03:59'),
(61, 8, 'Tambah Pengguna', 'Menambahkan pengguna: Zikry (role: teknisi)', '127.0.0.1', '2026-06-13 15:04:46'),
(62, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-13 15:04:52'),
(63, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-13 15:05:18'),
(64, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-13 15:05:31'),
(65, 29, 'Login', 'Pengguna Zikry berhasil login.', '127.0.0.1', '2026-06-13 15:05:39'),
(66, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-14 07:03:05'),
(67, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-14 07:03:16'),
(68, 29, 'Login', 'Pengguna Zikry berhasil login.', '127.0.0.1', '2026-06-14 07:03:26'),
(69, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-14 15:06:34'),
(70, 8, 'Hapus Pengguna', 'Menghapus pengguna: 123456789', '127.0.0.1', '2026-06-14 15:07:16'),
(71, 8, 'Hapus Pengguna', 'Menghapus pengguna: admin_test', '127.0.0.1', '2026-06-14 15:07:21'),
(72, 8, 'Tambah Pengguna', 'Menambahkan pengguna: imam (role: mahasiswa)', '127.0.0.1', '2026-06-14 15:08:13'),
(73, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-14 15:09:02'),
(74, 30, 'Login', 'Pengguna imam berhasil login.', '127.0.0.1', '2026-06-14 15:09:08'),
(75, 30, 'Logout', 'Pengguna imam logout.', '127.0.0.1', '2026-06-14 15:09:30'),
(76, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-14 15:09:34'),
(77, 8, 'Reset Password', 'Mereset password pengguna: Akmal', '127.0.0.1', '2026-06-14 15:10:21'),
(78, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-14 15:10:22'),
(79, 22, 'Login', 'Pengguna Akmal berhasil login.', '127.0.0.1', '2026-06-14 15:10:31'),
(80, 22, 'Logout', 'Pengguna Akmal logout.', '127.0.0.1', '2026-06-14 15:10:42'),
(81, 30, 'Login', 'Pengguna imam berhasil login.', '127.0.0.1', '2026-06-14 15:11:20'),
(82, 30, 'Logout', 'Pengguna imam logout.', '127.0.0.1', '2026-06-14 15:18:29'),
(83, 22, 'Login', 'Pengguna Akmal berhasil login.', '127.0.0.1', '2026-06-14 15:18:36'),
(84, 22, 'Logout', 'Pengguna Akmal logout.', '127.0.0.1', '2026-06-14 15:21:01'),
(85, 30, 'Login', 'Pengguna imam berhasil login.', '127.0.0.1', '2026-06-14 15:21:10'),
(86, 30, 'Logout', 'Pengguna imam logout.', '127.0.0.1', '2026-06-14 15:21:20'),
(87, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-14 15:22:54'),
(88, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-14 15:23:01'),
(89, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-20 07:11:32'),
(90, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-20 07:11:53'),
(91, 30, 'Login', 'Pengguna imam berhasil login.', '127.0.0.1', '2026-06-20 07:12:43'),
(92, 30, 'Logout', 'Pengguna imam logout.', '127.0.0.1', '2026-06-20 07:21:24'),
(93, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-20 07:21:27'),
(94, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-20 07:21:31'),
(95, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-20 07:21:35'),
(96, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-20 07:21:38'),
(97, 30, 'Login', 'Pengguna imam berhasil login.', '127.0.0.1', '2026-06-20 07:21:46'),
(98, 30, 'Logout', 'Pengguna imam logout.', '127.0.0.1', '2026-06-20 07:22:21'),
(99, 31, 'Login', 'Pengguna 24101101 berhasil login.', '127.0.0.1', '2026-06-20 07:22:56'),
(100, 31, 'Logout', 'Pengguna 24101101 logout.', '127.0.0.1', '2026-06-20 07:39:03'),
(101, 31, 'Login', 'Pengguna 24101101 berhasil login.', '127.0.0.1', '2026-06-20 07:39:49'),
(102, 31, 'Logout', 'Pengguna 24101101 logout.', '127.0.0.1', '2026-06-20 07:40:23'),
(103, 31, 'Login', 'Pengguna 24101101 berhasil login.', '127.0.0.1', '2026-06-20 07:41:22'),
(104, 31, 'Logout', 'Pengguna 24101101 logout.', '127.0.0.1', '2026-06-20 07:41:29'),
(105, 31, 'Login', 'Pengguna 24101101 berhasil login.', '127.0.0.1', '2026-06-20 07:42:25'),
(106, 31, 'Logout', 'Pengguna 24101101 logout.', '127.0.0.1', '2026-06-20 07:43:24'),
(107, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-20 07:43:28'),
(108, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-20 07:43:32'),
(109, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-20 07:46:48'),
(110, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-20 07:58:05'),
(111, 22, 'Login', 'Pengguna Akmal berhasil login.', '127.0.0.1', '2026-06-20 07:58:15'),
(112, 22, 'Logout', 'Pengguna Akmal logout.', '127.0.0.1', '2026-06-20 07:59:13'),
(113, 31, 'Login', 'Pengguna 24101101 berhasil login.', '127.0.0.1', '2026-06-20 07:59:34'),
(114, 31, 'Logout', 'Pengguna 24101101 logout.', '127.0.0.1', '2026-06-20 08:00:38'),
(115, 29, 'Login', 'Pengguna Zikry berhasil login.', '127.0.0.1', '2026-06-20 08:00:54'),
(116, 29, 'Logout', 'Pengguna Zikry logout.', '127.0.0.1', '2026-06-20 08:01:26'),
(117, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-20 08:01:30'),
(118, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-20 08:01:47'),
(119, 22, 'Login', 'Pengguna Akmal berhasil login.', '127.0.0.1', '2026-06-20 08:02:07'),
(120, 22, 'Logout', 'Pengguna Akmal logout.', '127.0.0.1', '2026-06-20 08:10:34'),
(121, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-20 08:27:25'),
(122, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-20 08:27:34'),
(123, 31, 'Login', 'Pengguna 24101101 berhasil login.', '127.0.0.1', '2026-06-20 08:27:52'),
(124, 31, 'Logout', 'Pengguna 24101101 logout.', '127.0.0.1', '2026-06-20 08:32:08'),
(125, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-20 08:32:11'),
(126, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-20 08:32:17'),
(127, 22, 'Login', 'Pengguna Akmal berhasil login.', '127.0.0.1', '2026-06-20 08:32:25'),
(128, 22, 'Logout', 'Pengguna Akmal logout.', '127.0.0.1', '2026-06-20 08:41:14'),
(129, 22, 'Login', 'Pengguna Akmal berhasil login.', '127.0.0.1', '2026-06-20 08:41:29'),
(130, 22, 'Logout', 'Pengguna Akmal logout.', '127.0.0.1', '2026-06-20 08:42:40'),
(131, 31, 'Login', 'Pengguna 24101101 berhasil login.', '127.0.0.1', '2026-06-20 08:42:47'),
(132, 31, 'Logout', 'Pengguna 24101101 logout.', '127.0.0.1', '2026-06-20 08:44:08'),
(133, 29, 'Login', 'Pengguna Zikry berhasil login.', '127.0.0.1', '2026-06-20 08:44:27'),
(134, 29, 'Logout', 'Pengguna Zikry logout.', '127.0.0.1', '2026-06-20 08:44:42'),
(135, 22, 'Login', 'Pengguna Akmal berhasil login.', '127.0.0.1', '2026-06-20 08:44:54'),
(136, 22, 'Logout', 'Pengguna Akmal logout.', '127.0.0.1', '2026-06-20 08:59:51'),
(137, 29, 'Login', 'Pengguna Zikry berhasil login.', '127.0.0.1', '2026-06-20 09:00:30'),
(138, 29, 'Logout', 'Pengguna Zikry logout.', '127.0.0.1', '2026-06-20 09:01:05'),
(139, 22, 'Login', 'Pengguna Akmal berhasil login.', '127.0.0.1', '2026-06-20 09:01:52'),
(140, 22, 'Logout', 'Pengguna Akmal logout.', '127.0.0.1', '2026-06-20 09:02:18'),
(141, 22, 'Login', 'Pengguna Akmal berhasil login.', '127.0.0.1', '2026-06-20 09:02:28'),
(142, 22, 'Logout', 'Pengguna Akmal logout.', '127.0.0.1', '2026-06-20 09:02:43'),
(143, 29, 'Login', 'Pengguna Zikry berhasil login.', '127.0.0.1', '2026-06-20 09:02:49'),
(144, 29, 'Logout', 'Pengguna Zikry logout.', '127.0.0.1', '2026-06-20 09:05:48'),
(145, 31, 'Login', 'Pengguna 24101101 berhasil login.', '127.0.0.1', '2026-06-20 09:05:56'),
(146, 31, 'Logout', 'Pengguna 24101101 logout.', '127.0.0.1', '2026-06-20 09:21:59'),
(147, 22, 'Login', 'Pengguna Akmal berhasil login.', '127.0.0.1', '2026-06-20 09:22:14'),
(148, 22, 'Logout', 'Pengguna Akmal logout.', '127.0.0.1', '2026-06-20 09:45:37'),
(149, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-20 09:45:41'),
(150, 8, 'Hapus Pengguna', 'Menghapus pengguna: 1234567', '127.0.0.1', '2026-06-20 09:45:53'),
(151, 8, 'Hapus Pengguna', 'Menghapus pengguna: imam', '127.0.0.1', '2026-06-20 09:45:57'),
(152, 8, 'Hapus Pengguna', 'Menghapus pengguna: Pablo', '127.0.0.1', '2026-06-20 09:46:02'),
(153, 8, 'Hapus Pengguna', 'Menghapus pengguna: 241011122', '127.0.0.1', '2026-06-20 09:46:10'),
(154, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-20 09:46:39'),
(155, 29, 'Login', 'Pengguna Zikry berhasil login.', '127.0.0.1', '2026-06-20 09:46:50'),
(156, 29, 'Logout', 'Pengguna Zikry logout.', '127.0.0.1', '2026-06-20 09:48:21'),
(157, 22, 'Logout', 'Pengguna Akmal logout.', '127.0.0.1', '2026-06-20 09:49:28'),
(158, 22, 'Login', 'Pengguna Akmal berhasil login.', '127.0.0.1', '2026-06-20 09:50:06'),
(159, 22, 'Logout', 'Pengguna Akmal logout.', '127.0.0.1', '2026-06-20 10:05:40'),
(160, 33, 'Login', 'Pengguna 241011129 berhasil login.', '127.0.0.1', '2026-06-20 10:06:22'),
(161, 33, 'Logout', 'Pengguna 241011129 logout.', '127.0.0.1', '2026-06-20 10:08:25'),
(162, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-20 16:20:11'),
(163, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-20 16:24:14'),
(164, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-20 16:24:16'),
(165, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-20 16:24:19'),
(166, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-20 16:24:38'),
(167, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-20 16:24:46'),
(168, 31, 'Login', 'Pengguna 24101101 berhasil login.', '127.0.0.1', '2026-06-20 16:25:09'),
(169, 31, 'Logout', 'Pengguna 24101101 logout.', '127.0.0.1', '2026-06-20 16:38:04'),
(170, 29, 'Login', 'Pengguna Zikry berhasil login.', '127.0.0.1', '2026-06-20 16:38:13'),
(171, 29, 'Logout', 'Pengguna Zikry logout.', '127.0.0.1', '2026-06-20 16:43:26'),
(172, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-20 16:43:28'),
(173, 8, 'Edit Profil', 'Super Admin memperbarui profil.', '127.0.0.1', '2026-06-20 16:44:45'),
(174, 8, 'Hapus Pengguna', 'Menghapus pengguna: fatir', '127.0.0.1', '2026-06-20 16:45:04'),
(175, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-20 16:45:16'),
(176, 8, 'Login', 'Pengguna arkan berhasil login.', '127.0.0.1', '2026-06-20 16:49:39'),
(177, 8, 'Tambah Pengguna', 'Menambahkan pengguna: imam (role: teknisi)', '127.0.0.1', '2026-06-20 16:50:21'),
(178, 8, 'Logout', 'Pengguna arkan logout.', '127.0.0.1', '2026-06-20 16:50:29'),
(179, 35, 'Login', 'Pengguna 241011126 berhasil login.', '127.0.0.1', '2026-06-20 16:54:49'),
(180, 35, 'Logout', 'Pengguna 241011126 logout.', '127.0.0.1', '2026-06-20 17:21:57'),
(181, 35, 'Login', 'Pengguna 241011126 berhasil login.', '127.0.0.1', '2026-06-20 17:22:19'),
(182, 35, 'Logout', 'Pengguna 241011126 logout.', '127.0.0.1', '2026-06-20 17:23:28'),
(183, 22, 'Login', 'Pengguna Akmal berhasil login.', '127.0.0.1', '2026-06-20 17:23:41'),
(184, 29, 'Login', 'Pengguna Zikry berhasil login.', '127.0.0.1', '2026-06-20 17:24:39'),
(185, 29, 'Logout', 'Pengguna Zikry logout.', '127.0.0.1', '2026-06-20 17:35:24'),
(186, 34, 'Login', 'Pengguna imam berhasil login.', '127.0.0.1', '2026-06-20 17:35:31'),
(187, 34, 'Logout', 'Pengguna imam logout.', '127.0.0.1', '2026-06-20 17:35:43'),
(188, 22, 'Logout', 'Pengguna Akmal logout.', '127.0.0.1', '2026-06-20 17:40:30'),
(189, 34, 'Login', 'Pengguna imam berhasil login.', '127.0.0.1', '2026-06-20 17:40:37'),
(190, 34, 'Logout', 'Pengguna imam logout.', '127.0.0.1', '2026-06-20 17:53:45'),
(191, 31, 'Login', 'Pengguna 24101101 berhasil login.', '127.0.0.1', '2026-06-20 17:53:53'),
(192, 22, 'Login', 'Pengguna Akmal berhasil login.', '127.0.0.1', '2026-06-20 17:55:36'),
(193, 22, 'Logout', 'Pengguna Akmal logout.', '127.0.0.1', '2026-06-20 17:55:39'),
(194, 35, 'Login', 'Pengguna 241011126 berhasil login.', '127.0.0.1', '2026-06-20 17:55:50');

-- --------------------------------------------------------

--
-- Table structure for table `backups`
--

CREATE TABLE `backups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `ukuran_file` bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'bytes',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gedungs`
--

CREATE TABLE `gedungs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_gedung` varchar(100) NOT NULL,
  `kode_gedung` varchar(20) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gedungs`
--

INSERT INTO `gedungs` (`id`, `nama_gedung`, `kode_gedung`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Gedung Laboratorium', '101', NULL, '2026-06-11 08:04:06', '2026-06-11 08:04:06');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_fasilitas`
--

CREATE TABLE `kategori_fasilitas` (
  `id_kategori` int(10) UNSIGNED NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_fasilitas`
--

INSERT INTO `kategori_fasilitas` (`id_kategori`, `nama_kategori`, `deskripsi`, `created_at`, `updated_at`) VALUES
(10, 'Elektronik', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(11, 'Kelistrikan', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(12, 'Furniture', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(13, 'Bangunan', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(14, 'Jaringan & Internet', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(15, 'Sanitasi', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(16, 'Keamanan', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(17, 'Lingkungan', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(18, 'Lainnya', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45');

-- --------------------------------------------------------

--
-- Table structure for table `lantais`
--

CREATE TABLE `lantais` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_gedung` bigint(20) UNSIGNED NOT NULL,
  `nama_lantai` varchar(100) NOT NULL,
  `nomor_lantai` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lantais`
--

INSERT INTO `lantais` (`id`, `id_gedung`, `nama_lantai`, `nomor_lantai`, `created_at`, `updated_at`) VALUES
(1, 1, 'floor 1', 1, '2026-06-11 08:04:24', '2026-06-11 08:04:24');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(10) UNSIGNED NOT NULL,
  `id_mahasiswa` int(10) UNSIGNED DEFAULT NULL,
  `id_kategori` int(10) UNSIGNED DEFAULT NULL,
  `id_sub_kategori` int(10) UNSIGNED DEFAULT NULL,
  `id_lokasi` int(10) UNSIGNED DEFAULT NULL,
  `id_teknisi` int(10) UNSIGNED DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `Tingkat_Kerusakan` enum('Rendah','Sedang','Parah') NOT NULL,
  `Status_terkini` enum('Menunggu Verifikasi','Sedang Diperbaiki','Dalam Pengerjaan','Selesai','Ditolak') NOT NULL DEFAULT 'Menunggu Verifikasi',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id_laporan`, `id_mahasiswa`, `id_kategori`, `id_sub_kategori`, `id_lokasi`, `id_teknisi`, `deskripsi`, `foto`, `Tingkat_Kerusakan`, `Status_terkini`, `created_at`, `updated_at`) VALUES
(17, 19, 18, NULL, 1, NULL, 'Akmal Galon', 'laporan_foto/i4uFvxfeQgnVCXnA2x3WhFMVogQQAI1GTDYURX1x.bmp', 'Sedang', 'Selesai', '2026-06-20 00:43:11', '2026-06-20 01:47:38'),
(18, 19, 18, NULL, 1, NULL, 'Fatih Sayang Naufal', 'laporan_foto/c6DAhxYwRdhFO6attNd076eIE1CkEQVVj9LrbRN3.webp', 'Parah', 'Selesai', '2026-06-20 00:43:58', '2026-06-20 01:05:36'),
(19, 22, 11, 6, 7, 29, 'Bagian lampu diruangan 302 tidak sengaja terjatuh dan pecah, menyebabkan cahaya jadi kurang saat proses pembelajaran', 'laporan_foto/Tr1CdsOqrAex2RQKskn9CSFuhjNBdBysJOkfGz0e.jpg', 'Parah', 'Dalam Pengerjaan', '2026-06-20 09:23:22', '2026-06-20 09:35:21');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi_fasilitas`
--

CREATE TABLE `lokasi_fasilitas` (
  `id_lokasi` int(10) UNSIGNED NOT NULL,
  `nama_ruangan` varchar(30) NOT NULL,
  `nama_gedung` enum('Gedung 1','Laboratorium','Gedung 2') NOT NULL,
  `Ruangan` varchar(15) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lokasi_fasilitas`
--

INSERT INTO `lokasi_fasilitas` (`id_lokasi`, `nama_ruangan`, `nama_gedung`, `Ruangan`, `created_at`, `updated_at`) VALUES
(1, 'Ruang Kelas 101', 'Gedung 1', '101', '2026-06-10 19:14:31', '2026-06-10 19:14:31'),
(2, 'Ruang Kelas 102', 'Gedung 1', '102', '2026-06-10 19:14:31', '2026-06-10 19:14:31'),
(3, 'Ruang Kelas 201', 'Gedung 1', '201', '2026-06-10 19:14:31', '2026-06-10 19:14:31'),
(4, 'Lab Komputer A', 'Laboratorium', 'A', '2026-06-10 19:14:31', '2026-06-10 19:14:31'),
(5, 'Lab Komputer B', 'Laboratorium', 'B', '2026-06-10 19:14:31', '2026-06-10 19:14:31'),
(6, 'Ruang Kelas 301', 'Gedung 2', '301', '2026-06-10 19:14:31', '2026-06-10 19:14:31'),
(7, 'Ruang Kelas 302', 'Gedung 2', '302', '2026-06-10 19:14:31', '2026-06-10 19:14:31'),
(8, 'Koridor Utama', 'Gedung 1', '-', '2026-06-10 19:14:31', '2026-06-10 19:14:31');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(10) UNSIGNED NOT NULL,
  `Nim` bigint(20) NOT NULL,
  `Nama_mahasiswa` varchar(50) NOT NULL,
  `Sandi` varchar(255) NOT NULL,
  `Kontak` bigint(20) NOT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `prodi` enum('Ilmu Komputer','Sistem Informasi','Matematika','Sains Data') DEFAULT NULL,
  `agama` enum('Islam','Kristen','Katolik','Hindu','Buddha') DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `ukm` varchar(100) DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `Nim`, `Nama_mahasiswa`, `Sandi`, `Kontak`, `jenis_kelamin`, `prodi`, `agama`, `tanggal_lahir`, `ukm`, `foto_profil`, `created_at`, `updated_at`) VALUES
(19, 24101101, 'Dzul', '$2y$12$XFyikqEJRD4t73YmvWNqu.jv0Vz235B9MwaK063ZkOQ.4uyZKo56W', 81111, 'L', 'Ilmu Komputer', 'Islam', NULL, 'Seni', 'foto_profil/fIjSxroJp5GNskdAmexahkhyK5zugzQ02rjdF3dA.webp', '2026-06-19 23:22:46', '2026-06-20 01:15:27'),
(21, 241011129, 'Brian', '$2y$12$nNiCCWLuBWUB2o/mKaz2he0azzdVOO3O1gVWBqWIR0/hQh02uIPY2', 89292911, 'P', 'Matematika', 'Islam', NULL, 'Seni', 'foto_profil/zb9CU70v5qF05l35BO4duCuxZbSNDp0H1Tb4rxqI.jpg', '2026-06-20 02:06:11', '2026-06-20 02:07:29'),
(22, 241011126, 'fatih', '$2y$12$8lrS.bvYtfTi6wd2UNy4T.4Li4LFmhzhjzNLXcweeHU/OK6qXuUaC', 85123, 'P', 'Sains Data', 'Islam', NULL, NULL, 'foto_profil/lH4EHNCDed6IDBQtuy1mvFvaQG5kpNzj7O2bq0wm.jpg', '2026-06-20 08:51:17', '2026-06-20 08:55:33'),
(23, 241011125, 'syahrul', '$2y$12$w34DOQXSNWBbigviKrBM8./wKd2.mi/Q.MpoMwtEngJfO5GaTIcBG', 85132, 'P', 'Sains Data', NULL, NULL, NULL, NULL, '2026-06-20 09:57:34', '2026-06-20 09:57:34');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_10_000001_create_user_table', 1),
(5, '2026_06_10_000002_create_app_tables', 1),
(6, '2026_06_11_000001_update_laporan_table', 2),
(7, '2026_06_11_100001_add_columns_to_user_table', 3),
(8, '2026_06_11_100002_update_kategori_fasilitas_table', 4),
(9, '2026_06_11_100003_create_superadmin_tables', 5),
(10, '2026_06_14_000001_create_pengumuman_table', 6),
(11, '2026_06_20_000001_add_dalam_pengerjaan_to_laporan_status', 7),
(12, '2026_06_20_000002_add_verification_statuses_to_laporan', 8),
(13, '2026_06_20_000003_add_id_teknisi_to_laporan', 9),
(14, '2026_06_21_000001_add_sub_kategori_fasilitas', 10);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id_pengumuman` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(200) NOT NULL,
  `isi` text NOT NULL,
  `tanggal_publish` date NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `dibuat_oleh` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`id_pengumuman`, `judul`, `isi`, `tanggal_publish`, `status`, `dibuat_oleh`, `created_at`, `updated_at`) VALUES
(1, 'Perbaikan listrik', 'Akan ada maintenance dibagian listrik kampus 2 pukul 16:00.', '2026-06-14', 'aktif', 22, '2026-06-14 07:20:56', '2026-06-14 07:20:56');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_status`
--

CREATE TABLE `riwayat_status` (
  `Id_riwayat` int(10) UNSIGNED NOT NULL,
  `waktu` datetime NOT NULL,
  `status_terbaru` enum('Selesai','Belum Selesai') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `riwayat_status`
--

INSERT INTO `riwayat_status` (`Id_riwayat`, `waktu`, `status_terbaru`, `created_at`, `updated_at`) VALUES
(1, '2026-06-11 04:46:17', 'Belum Selesai', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ruangans`
--

CREATE TABLE `ruangans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_lantai` bigint(20) UNSIGNED NOT NULL,
  `nama_ruangan` varchar(100) NOT NULL,
  `kode_ruangan` varchar(30) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ruangans`
--

INSERT INTO `ruangans` (`id`, `id_lantai`, `nama_ruangan`, `kode_ruangan`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ruang kelas 101', 'Ngr 101', NULL, '2026-06-11 08:04:45', '2026-06-11 08:04:45');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_kategori_fasilitas`
--

CREATE TABLE `sub_kategori_fasilitas` (
  `id_sub_kategori` int(10) UNSIGNED NOT NULL,
  `id_kategori` int(10) UNSIGNED NOT NULL,
  `nama_sub_kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_kategori_fasilitas`
--

INSERT INTO `sub_kategori_fasilitas` (`id_sub_kategori`, `id_kategori`, `nama_sub_kategori`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 10, 'Komputer', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(2, 10, 'Printer', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(3, 10, 'Proyektor', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(4, 10, 'AC', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(5, 10, 'Speaker', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(6, 11, 'Lampu', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(7, 11, 'Stop Kontak', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(8, 11, 'Saklar', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(9, 11, 'Kabel Listrik', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(10, 12, 'Meja', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(11, 12, 'Kursi', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(12, 12, 'Lemari', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(13, 12, 'Papan Tulis', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(14, 13, 'Dinding', NULL, '2026-06-20 09:05:45', '2026-06-20 09:05:45'),
(15, 13, 'Atap', NULL, '2026-06-20 09:05:46', '2026-06-20 09:05:46'),
(16, 13, 'Lantai', NULL, '2026-06-20 09:05:46', '2026-06-20 09:05:46'),
(17, 13, 'Jendela', NULL, '2026-06-20 09:05:46', '2026-06-20 09:05:46'),
(18, 13, 'Pintu', NULL, '2026-06-20 09:05:46', '2026-06-20 09:05:46'),
(19, 14, 'WiFi', NULL, '2026-06-20 09:05:46', '2026-06-20 09:05:46'),
(20, 14, 'Router', NULL, '2026-06-20 09:05:46', '2026-06-20 09:05:46'),
(21, 14, 'Switch', NULL, '2026-06-20 09:05:46', '2026-06-20 09:05:46'),
(22, 14, 'Kabel LAN', NULL, '2026-06-20 09:05:46', '2026-06-20 09:05:46'),
(23, 15, 'Toilet', NULL, '2026-06-20 09:05:46', '2026-06-20 09:05:46'),
(24, 15, 'Wastafel', NULL, '2026-06-20 09:05:46', '2026-06-20 09:05:46'),
(25, 15, 'Keran', NULL, '2026-06-20 09:05:46', '2026-06-20 09:05:46'),
(26, 15, 'Saluran Air', NULL, '2026-06-20 09:05:46', '2026-06-20 09:05:46'),
(27, 16, 'CCTV', NULL, '2026-06-20 09:05:46', '2026-06-20 09:05:46'),
(28, 16, 'Alarm', NULL, '2026-06-20 09:05:46', '2026-06-20 09:05:46'),
(29, 16, 'Pagar', NULL, '2026-06-20 09:05:46', '2026-06-20 09:05:46'),
(30, 17, 'Taman', NULL, '2026-06-20 09:05:46', '2026-06-20 09:05:46'),
(31, 17, 'Tempat Sampah', NULL, '2026-06-20 09:05:46', '2026-06-20 09:05:46'),
(32, 17, 'Area Parkir', NULL, '2026-06-20 09:05:46', '2026-06-20 09:05:46');

-- --------------------------------------------------------

--
-- Table structure for table `teknisi`
--

CREATE TABLE `teknisi` (
  `id_teknisi` int(10) UNSIGNED NOT NULL,
  `nama_teknisi` varchar(20) NOT NULL,
  `bidang_keahlian` varchar(20) NOT NULL,
  `kontak` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('super_admin','admin','teknisi','dosen','mahasiswa') NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `foto_profil` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `nama`, `email`, `password`, `role`, `status`, `foto_profil`, `created_at`, `updated_at`) VALUES
(8, 'arkan', 'Arkang', 'alya123@gmail.com', '$2y$12$A8MMp6MRoT4mPcRY5P8mqe1VDWNOS2Ql2Lcy01xFhVMdDPeyma/J.', 'super_admin', 'aktif', 'profil_8_1781192298.png', '2026-06-10 17:30:23', '2026-06-20 08:44:45'),
(22, 'Akmal', 'Akmal Ahsan', 'ahsano23@gmail.com', '$2y$12$qNaQxbiiVbumAC.e5QoVpOruufUS.197ECy7Qzbts5juW/2ZAXqZ6', 'admin', 'aktif', 'profil/TgL9YHPx5zYeQqVoGxoVLMFbTZCkFiKQem1kS2bz.png', '2026-06-11 07:13:29', '2026-06-20 02:00:51'),
(26, 'Fatih', 'Syahfatih', 'syahfathi23@hotmail.com', '$2y$12$gdglq87epEjqwuAVYV.19Oneg7dJEHDWKOZ4Vgtd8d.sjBcVg1fmq', 'admin', 'aktif', NULL, '2026-06-11 08:03:18', '2026-06-11 08:03:18'),
(29, 'Zikry', 'zikrib', 'zikri123@gmail.com', '$2y$12$Kpc9usZE2PZLv6X6Ns9sCOJhhDSqyVsn8LZy65SpaKZqLpl45/IB2', 'teknisi', 'aktif', NULL, '2026-06-13 07:04:46', '2026-06-13 07:04:46'),
(31, '24101101', NULL, NULL, '$2y$12$XFyikqEJRD4t73YmvWNqu.jv0Vz235B9MwaK063ZkOQ.4uyZKo56W', 'mahasiswa', 'aktif', NULL, '2026-06-19 23:22:46', '2026-06-19 23:22:46'),
(33, '241011129', NULL, NULL, '$2y$12$nNiCCWLuBWUB2o/mKaz2he0azzdVOO3O1gVWBqWIR0/hQh02uIPY2', 'mahasiswa', 'aktif', NULL, '2026-06-20 02:06:11', '2026-06-20 02:06:11'),
(34, 'imam', 'imam zackone', 'imamzackone@gmail.com', '$2y$12$reiYTQHdXru08jjvdT1LUu/XAZsKI73JZc4OLiFrv/1Xmy2CZcH3m', 'teknisi', 'aktif', 'profil/teknisi_34_1781977492.jpg', '2026-06-20 08:50:21', '2026-06-20 09:44:52'),
(35, '241011126', NULL, NULL, '$2y$12$8lrS.bvYtfTi6wd2UNy4T.4Li4LFmhzhjzNLXcweeHU/OK6qXuUaC', 'mahasiswa', 'aktif', NULL, '2026-06-20 08:51:17', '2026-06-20 08:54:36'),
(36, '241011125', NULL, NULL, '$2y$12$w34DOQXSNWBbigviKrBM8./wKd2.mi/Q.MpoMwtEngJfO5GaTIcBG', 'mahasiswa', 'aktif', NULL, '2026-06-20 09:57:34', '2026-06-20 09:57:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `admin_nip_unique` (`nip`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `backups`
--
ALTER TABLE `backups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gedungs`
--
ALTER TABLE `gedungs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_fasilitas`
--
ALTER TABLE `kategori_fasilitas`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `lantais`
--
ALTER TABLE `lantais`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lantais_id_gedung_foreign` (`id_gedung`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indexes for table `lokasi_fasilitas`
--
ALTER TABLE `lokasi_fasilitas`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `mahasiswa_nim_unique` (`Nim`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`);

--
-- Indexes for table `riwayat_status`
--
ALTER TABLE `riwayat_status`
  ADD PRIMARY KEY (`Id_riwayat`);

--
-- Indexes for table `ruangans`
--
ALTER TABLE `ruangans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ruangans_id_lantai_foreign` (`id_lantai`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sub_kategori_fasilitas`
--
ALTER TABLE `sub_kategori_fasilitas`
  ADD PRIMARY KEY (`id_sub_kategori`);

--
-- Indexes for table `teknisi`
--
ALTER TABLE `teknisi`
  ADD PRIMARY KEY (`id_teknisi`),
  ADD UNIQUE KEY `teknisi_kontak_unique` (`kontak`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `user_username_unique` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `backups`
--
ALTER TABLE `backups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gedungs`
--
ALTER TABLE `gedungs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_fasilitas`
--
ALTER TABLE `kategori_fasilitas`
  MODIFY `id_kategori` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `lantais`
--
ALTER TABLE `lantais`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `lokasi_fasilitas`
--
ALTER TABLE `lokasi_fasilitas`
  MODIFY `id_lokasi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id_pengumuman` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `riwayat_status`
--
ALTER TABLE `riwayat_status`
  MODIFY `Id_riwayat` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ruangans`
--
ALTER TABLE `ruangans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_kategori_fasilitas`
--
ALTER TABLE `sub_kategori_fasilitas`
  MODIFY `id_sub_kategori` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `teknisi`
--
ALTER TABLE `teknisi`
  MODIFY `id_teknisi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lantais`
--
ALTER TABLE `lantais`
  ADD CONSTRAINT `lantais_id_gedung_foreign` FOREIGN KEY (`id_gedung`) REFERENCES `gedungs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ruangans`
--
ALTER TABLE `ruangans`
  ADD CONSTRAINT `ruangans_id_lantai_foreign` FOREIGN KEY (`id_lantai`) REFERENCES `lantais` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
