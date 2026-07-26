-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 26, 2026 at 05:20 PM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shuka_highschool`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('shuka-highschool-cache-aaaaaaaaaaaaa@a.a|127.0.0.1', 'i:2;', 1785082244),
('shuka-highschool-cache-aaaaaaaaaaaaa@a.a|127.0.0.1:timer', 'i:1785082244;', 1785082244),
('shuka-highschool-cache-admin@miyamasuzaka.test|127.0.0.1', 'i:1;', 1785083834),
('shuka-highschool-cache-admin@miyamasuzaka.test|127.0.0.1:timer', 'i:1785083833;', 1785083833);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gurus`
--

DROP TABLE IF EXISTS `gurus`;
CREATE TABLE IF NOT EXISTS `gurus` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mata_pelajaran` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gurus_nip_unique` (`nip`),
  UNIQUE KEY `gurus_user_id_unique` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gurus`
--

INSERT INTO `gurus` (`id`, `user_id`, `nama`, `nip`, `mata_pelajaran`, `no_telepon`, `created_at`, `updated_at`) VALUES
(1, 2, 'Ryo Yamada', '19890101001', 'Musik', '081234567801', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(2, 3, 'Nijika Ijichi', '19890202002', 'Matematika', '081234567802', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(3, 4, 'Ikuyo Kita', '19890303003', 'Bahasa Inggris', '081234567803', '2026-07-26 09:07:03', '2026-07-26 09:07:03');

-- --------------------------------------------------------

--
-- Table structure for table `jadwals`
--

DROP TABLE IF EXISTS `jadwals`;
CREATE TABLE IF NOT EXISTS `jadwals` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `mapel_id` bigint UNSIGNED NOT NULL,
  `kelas` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hari` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jadwals_mapel_id_foreign` (`mapel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwals`
--

INSERT INTO `jadwals` (`id`, `mapel_id`, `kelas`, `hari`, `jam_mulai`, `jam_selesai`, `created_at`, `updated_at`) VALUES
(1, 1, 'X-1', 'Senin', '07:30:00', '09:00:00', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(2, 2, 'X-2', 'Senin', '09:15:00', '10:45:00', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(3, 2, 'X-2', 'Selasa', '09:15:00', '10:45:00', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(4, 3, 'XI-1', 'Selasa', '11:00:00', '12:30:00', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(5, 3, 'XI-1', 'Rabu', '11:00:00', '12:30:00', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(6, 4, 'XI-2', 'Rabu', '13:15:00', '14:45:00', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(7, 4, 'XI-2', 'Kamis', '13:15:00', '14:45:00', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(8, 5, 'XII-1', 'Kamis', '07:30:00', '09:00:00', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(9, 5, 'XII-1', 'Jumat', '07:30:00', '09:00:00', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(10, 6, 'X-1', 'Jumat', '09:15:00', '10:45:00', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(11, 6, 'X-1', 'Sabtu', '09:15:00', '10:45:00', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(12, 7, 'X-2', 'Sabtu', '11:00:00', '12:30:00', '2026-07-26 09:07:03', '2026-07-26 09:07:03');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajarans`
--

DROP TABLE IF EXISTS `mata_pelajarans`;
CREATE TABLE IF NOT EXISTS `mata_pelajarans` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guru_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mata_pelajarans_kode_unique` (`kode`),
  KEY `mata_pelajarans_guru_id_foreign` (`guru_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mata_pelajarans`
--

INSERT INTO `mata_pelajarans` (`id`, `nama`, `kode`, `guru_id`, `created_at`, `updated_at`) VALUES
(1, 'Matematika', 'MTK-01', 2, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(2, 'Bahasa Indonesia', 'BIN-01', 1, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(3, 'Bahasa Inggris', 'BIG-01', 3, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(4, 'Fisika', 'FIS-01', 2, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(5, 'Kimia', 'KIM-01', 2, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(6, 'Sejarah', 'SEJ-01', 3, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(7, 'Seni Musik', 'SMU-01', 1, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(8, 'Olahraga', 'ORJ-01', 3, '2026-07-26 09:07:03', '2026-07-26 09:07:03');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_26_145949_create_siswas_table', 1),
(5, '2026_07_26_145950_create_gurus_table', 1),
(6, '2026_07_26_145951_create_mata_pelajarans_table', 1),
(7, '2026_07_26_145952_create_jadwals_table', 1),
(8, '2026_07_26_145953_create_nilais_table', 1),
(9, '2026_07_26_151901_add_avatar_to_users_table', 1),
(10, '2026_07_26_160000_add_roles_and_user_links', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nilais`
--

DROP TABLE IF EXISTS `nilais`;
CREATE TABLE IF NOT EXISTS `nilais` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint UNSIGNED NOT NULL,
  `mapel_id` bigint UNSIGNED NOT NULL,
  `jenis_nilai` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nilais_siswa_id_foreign` (`siswa_id`),
  KEY `nilais_mapel_id_foreign` (`mapel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nilais`
--

INSERT INTO `nilais` (`id`, `siswa_id`, `mapel_id`, `jenis_nilai`, `nilai`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Tugas', 72.88, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(2, 1, 2, 'UAS', 86.01, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(3, 1, 3, 'UH', 76.62, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(4, 1, 4, 'UH', 71.73, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(5, 2, 1, 'UTS', 68.42, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(6, 2, 2, 'UTS', 84.16, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(7, 2, 3, 'UTS', 74.10, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(8, 2, 4, 'UTS', 94.88, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(9, 3, 1, 'UH', 80.57, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(10, 3, 2, 'Tugas', 91.24, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(11, 3, 3, 'Tugas', 96.33, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(12, 3, 4, 'UTS', 85.75, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(13, 4, 1, 'UAS', 88.70, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(14, 4, 2, 'UTS', 79.88, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(15, 4, 3, 'UTS', 75.56, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(16, 4, 4, 'Tugas', 85.32, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(17, 5, 1, 'UTS', 83.05, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(18, 5, 2, 'Tugas', 88.20, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(19, 5, 3, 'UTS', 77.58, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(20, 5, 4, 'UAS', 83.71, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(21, 6, 1, 'UAS', 82.94, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(22, 6, 2, 'UTS', 74.24, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(23, 6, 3, 'Tugas', 77.29, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(24, 6, 4, 'UTS', 69.59, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(25, 7, 1, 'UAS', 78.25, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(26, 7, 2, 'UTS', 92.57, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(27, 7, 3, 'UAS', 74.98, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(28, 7, 4, 'UAS', 83.68, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(29, 8, 1, 'UH', 95.91, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(30, 8, 2, 'UAS', 80.20, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(31, 8, 3, 'UTS', 97.73, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(32, 8, 4, 'UTS', 84.45, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(33, 9, 1, 'UAS', 72.54, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(34, 9, 2, 'UAS', 83.84, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(35, 9, 3, 'UH', 84.50, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(36, 9, 4, 'UH', 83.41, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(37, 10, 1, 'Tugas', 80.18, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(38, 10, 2, 'Tugas', 88.15, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(39, 10, 3, 'UTS', 90.03, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(40, 10, 4, 'UAS', 87.98, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(41, 11, 1, 'Tugas', 87.91, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(42, 11, 2, 'UAS', 95.00, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(43, 11, 3, 'UAS', 73.41, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(44, 11, 4, 'Tugas', 90.74, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(45, 12, 1, 'Tugas', 79.74, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(46, 12, 2, 'UAS', 69.70, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(47, 12, 3, 'Tugas', 81.39, '2026-07-26 09:07:04', '2026-07-26 09:07:04'),
(48, 12, 4, 'UH', 91.71, '2026-07-26 09:07:04', '2026-07-26 09:07:04');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3AZVno1LZC9kWq5gn9Sral5bABZAyS7UWLmWeMxG', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; id-ID) WindowsPowerShell/5.1.26100.7462', 'eyJfdG9rZW4iOiJQeVBtWjRqQUx3dWNwaDNabjZMN1p4WG5XV2xXYnNwSFlTUFJnTUpqIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1785083589),
('6MqymLXPiN916yHYUnEo9KSkgDs0Rzg8YfngLMkm', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; id-ID) WindowsPowerShell/5.1.26100.7462', 'eyJfdG9rZW4iOiJYR2hRVXJqMTZSOGFUZ3hBV1pWZDdNYlRrcTlyb1ltUkk5YlhrbG40IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sInVybCI6eyJpbnRlbmRlZCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9kYXNoYm9hcmQifX0=', 1785083774),
('C0pRA42F8jDXVZwo3KryC4nICHBpleTcR8bOGTCx', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; id-ID) WindowsPowerShell/5.1.26100.7462', 'eyJfdG9rZW4iOiJ2dlBQM2NNd0ZKSzhVaG4xazhIQVVDS2x5ZVI3Z0pkcXBZMm91QzlUIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1785083773),
('hK4ria5GIHzYPkv6hIWyWYSgdxUnaEzIeTxr0amR', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; id-ID) WindowsPowerShell/5.1.26100.7462', 'eyJfdG9rZW4iOiJ5aUYyVTBjMXBtdWtNdTRzS2xFdlgyVng5SWloek5Oakpta3Q1RVBYIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1785083788),
('ItSKfWXm299EDjRAiJ0hxAgRuwZ8WsIOMbQKWlEk', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; id-ID) WindowsPowerShell/5.1.26100.7462', 'eyJfdG9rZW4iOiJ4ckJmNW00eW0zYmdNMk41c0NpRk8zY1BWMXhCMHpqS1BKNmsxWlF6IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1785083590),
('lZbwc70iqVIYatnYr8XxMmKtbzj2Fb9YI8KFljeN', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:153.0) Gecko/20100101 Firefox/153.0', 'eyJfdG9rZW4iOiJqc2t2MnM0bXVBNGVoQWd5NEx5VWNQRTI2SWF5MER2MUNJMWFEekJxIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2Rhc2hib2FyZCIsInJvdXRlIjoiZGFzaGJvYXJkIn0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1785082875),
('stkMEomaVzOFW0T2EAoZyBqYv5BOmS6kTIVIyCK2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; id-ID) WindowsPowerShell/5.1.26100.7462', 'eyJfdG9rZW4iOiI0U3JTckdIdTQzOEdkYzBJS2ZOSVk4SUpDS01rUTdkY2R4bFhrS3ZPIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1785083747),
('uLLrjbB1kmfNH3FtvzGR3CLI0HrorneG3tPg70Vz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; id-ID) WindowsPowerShell/5.1.26100.7462', 'eyJfdG9rZW4iOiJ4YlZzUkxvWkxlcEc2SVAwTHZVOTNUYkdsOUNMNWx0NWdvQ0FpOHJ3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1785083589);

-- --------------------------------------------------------

--
-- Table structure for table `siswas`
--

DROP TABLE IF EXISTS `siswas`;
CREATE TABLE IF NOT EXISTS `siswas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nis` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `siswas_nis_unique` (`nis`),
  UNIQUE KEY `siswas_user_id_unique` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswas`
--

INSERT INTO `siswas` (`id`, `user_id`, `nama`, `nis`, `kelas`, `jenis_kelamin`, `alamat`, `tanggal_lahir`, `created_at`, `updated_at`) VALUES
(1, 5, 'Hitori Gotou', '2026001', 'X-1', 'L', 'Shimokitazawa', '2010-07-26', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(2, 6, 'Kikuri Hiroi', '2026002', 'X-2', 'P', 'Tokyo', '2009-07-15', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(3, 7, 'Seika Ijichi', '2026003', 'XI-1', 'P', 'Shibuya', '2008-07-04', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(4, 8, 'PA-san', '2026004', 'XI-2', 'P', 'Kichijoji', '2007-06-23', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(5, 9, 'Futari Gotou', '2026005', 'XII-1', 'P', 'Nakano', '2010-06-12', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(6, 10, 'Michiyo Gotou', '2026006', 'X-1', 'L', 'Shimokitazawa', '2009-06-01', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(7, 11, 'Naoki Gotou', '2026007', 'X-2', 'P', 'Tokyo', '2008-05-21', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(8, 12, 'Yoyoko', '2026008', 'XI-1', 'L', 'Shibuya', '2007-05-10', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(9, 13, 'Eliza', '2026009', 'XI-2', 'P', 'Kichijoji', '2010-04-29', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(10, 14, 'Subaru', '2026010', 'XII-1', 'P', 'Nakano', '2009-04-18', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(11, 15, 'Kita Ikuyo Jr', '2026011', 'X-1', 'L', 'Shimokitazawa', '2008-04-07', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(12, 16, 'Ryo Mini', '2026012', 'X-2', 'P', 'Tokyo', '2007-03-27', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(13, NULL, 'Nijika Jr', '2026013', 'XI-1', 'P', 'Shibuya', '2010-03-16', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(14, NULL, 'Sakura Amane', '2026014', 'XI-2', 'P', 'Kichijoji', '2009-03-05', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(15, NULL, 'Hiroto Ken', '2026015', 'XII-1', 'L', 'Nakano', '2008-02-23', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(16, NULL, 'Mei Amamiya', '2026016', 'X-1', 'L', 'Shimokitazawa', '2007-02-11', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(17, NULL, 'Sora Tanaka', '2026017', 'X-2', 'P', 'Tokyo', '2010-01-31', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(18, NULL, 'Yuki Nakamura', '2026018', 'XI-1', 'P', 'Shibuya', '2009-01-20', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(19, NULL, 'Aoi Fujita', '2026019', 'XI-2', 'P', 'Kichijoji', '2008-01-10', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(20, NULL, 'Ren Okada', '2026020', 'XII-1', 'P', 'Nakano', '2006-12-29', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(21, NULL, 'Hana Sato', '2026021', 'X-1', 'L', 'Shimokitazawa', '2009-12-18', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(22, NULL, 'Kai Watanabe', '2026022', 'X-2', 'L', 'Tokyo', '2008-12-07', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(23, NULL, 'Mio Takahashi', '2026023', 'XI-1', 'P', 'Shibuya', '2007-11-27', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(24, NULL, 'Leo Suzuki', '2026024', 'XI-2', 'P', 'Kichijoji', '2006-11-15', '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(25, NULL, 'Nana Ito', '2026025', 'XII-1', 'P', 'Nakano', '2009-11-04', '2026-07-26 09:07:03', '2026-07-26 09:07:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'murid',
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_index` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Hitori Admin', 'admin@shuka.test', 'admin', 'bocchi', '2026-07-26 09:07:03', '$2y$12$/ChwwFLciyo2rxDbL8aleOS58c6cxpcgEi3PcTue8bg225MD3aZom', NULL, '2026-07-26 09:07:03', '2026-07-26 09:11:48'),
(2, 'Ryo Yamada', 'ryo@shuka.test', 'guru', 'bocchi', '2026-07-26 09:07:03', '$2y$12$/ChwwFLciyo2rxDbL8aleOS58c6cxpcgEi3PcTue8bg225MD3aZom', NULL, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(3, 'Nijika Ijichi', 'nijika@shuka.test', 'guru', 'bocchi-shy', '2026-07-26 09:07:03', '$2y$12$/ChwwFLciyo2rxDbL8aleOS58c6cxpcgEi3PcTue8bg225MD3aZom', NULL, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(4, 'Ikuyo Kita', 'kita@shuka.test', 'guru', 'bocchi-maid', '2026-07-26 09:07:03', '$2y$12$/ChwwFLciyo2rxDbL8aleOS58c6cxpcgEi3PcTue8bg225MD3aZom', NULL, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(5, 'Hitori Gotou', 'hitori0@murid.shuka.test', 'murid', 'bocchi', '2026-07-26 09:07:03', '$2y$12$/ChwwFLciyo2rxDbL8aleOS58c6cxpcgEi3PcTue8bg225MD3aZom', NULL, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(6, 'Kikuri Hiroi', 'kikuri1@murid.shuka.test', 'murid', 'bocchi-shy', '2026-07-26 09:07:03', '$2y$12$/ChwwFLciyo2rxDbL8aleOS58c6cxpcgEi3PcTue8bg225MD3aZom', NULL, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(7, 'Seika Ijichi', 'seika2@murid.shuka.test', 'murid', 'bocchi-maid', '2026-07-26 09:07:03', '$2y$12$/ChwwFLciyo2rxDbL8aleOS58c6cxpcgEi3PcTue8bg225MD3aZom', NULL, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(8, 'PA-san', 'pasan3@murid.shuka.test', 'murid', 'bocchi', '2026-07-26 09:07:03', '$2y$12$/ChwwFLciyo2rxDbL8aleOS58c6cxpcgEi3PcTue8bg225MD3aZom', NULL, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(9, 'Futari Gotou', 'futari4@murid.shuka.test', 'murid', 'bocchi-shy', '2026-07-26 09:07:03', '$2y$12$/ChwwFLciyo2rxDbL8aleOS58c6cxpcgEi3PcTue8bg225MD3aZom', NULL, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(10, 'Michiyo Gotou', 'michiyo5@murid.shuka.test', 'murid', 'bocchi-maid', '2026-07-26 09:07:03', '$2y$12$/ChwwFLciyo2rxDbL8aleOS58c6cxpcgEi3PcTue8bg225MD3aZom', NULL, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(11, 'Naoki Gotou', 'naoki6@murid.shuka.test', 'murid', 'bocchi', '2026-07-26 09:07:03', '$2y$12$/ChwwFLciyo2rxDbL8aleOS58c6cxpcgEi3PcTue8bg225MD3aZom', NULL, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(12, 'Yoyoko', 'yoyoko7@murid.shuka.test', 'murid', 'bocchi-shy', '2026-07-26 09:07:03', '$2y$12$/ChwwFLciyo2rxDbL8aleOS58c6cxpcgEi3PcTue8bg225MD3aZom', NULL, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(13, 'Eliza', 'eliza8@murid.shuka.test', 'murid', 'bocchi-maid', '2026-07-26 09:07:03', '$2y$12$/ChwwFLciyo2rxDbL8aleOS58c6cxpcgEi3PcTue8bg225MD3aZom', NULL, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(14, 'Subaru', 'subaru9@murid.shuka.test', 'murid', 'bocchi', '2026-07-26 09:07:03', '$2y$12$/ChwwFLciyo2rxDbL8aleOS58c6cxpcgEi3PcTue8bg225MD3aZom', NULL, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(15, 'Kita Ikuyo Jr', 'kita10@murid.shuka.test', 'murid', 'bocchi-shy', '2026-07-26 09:07:03', '$2y$12$/ChwwFLciyo2rxDbL8aleOS58c6cxpcgEi3PcTue8bg225MD3aZom', NULL, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(16, 'Ryo Mini', 'ryo11@murid.shuka.test', 'murid', 'bocchi-maid', '2026-07-26 09:07:03', '$2y$12$/ChwwFLciyo2rxDbL8aleOS58c6cxpcgEi3PcTue8bg225MD3aZom', NULL, '2026-07-26 09:07:03', '2026-07-26 09:07:03'),
(17, 'mboh', 'aaaaaaaaaaaaa@a.a', 'murid', 'bocchi', NULL, '$2y$12$EXn3l/eu3WFDifvHuF9z7.ZtcXpjqqtN.iCocmZQp85pXLmXlvdW.', NULL, '2026-07-26 09:10:03', '2026-07-26 09:10:03');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gurus`
--
ALTER TABLE `gurus`
  ADD CONSTRAINT `gurus_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `jadwals`
--
ALTER TABLE `jadwals`
  ADD CONSTRAINT `jadwals_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajarans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mata_pelajarans`
--
ALTER TABLE `mata_pelajarans`
  ADD CONSTRAINT `mata_pelajarans_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nilais`
--
ALTER TABLE `nilais`
  ADD CONSTRAINT `nilais_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajarans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilais_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `siswas`
--
ALTER TABLE `siswas`
  ADD CONSTRAINT `siswas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
