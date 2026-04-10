-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2026 at 12:04 PM
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
-- Database: `sipinjam`
--

-- --------------------------------------------------------

--
-- Table structure for table `alat`
--

CREATE TABLE `alat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_alat` varchar(255) NOT NULL,
  `nama_alat` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL DEFAULT 'Umum',
  `foto` varchar(255) DEFAULT NULL,
  `stok_total` int(10) UNSIGNED NOT NULL,
  `stok_tersedia` int(10) UNSIGNED NOT NULL,
  `kondisi` enum('baik','rusak_ringan','rusak') NOT NULL,
  `status_ketersediaan` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alat`
--

INSERT INTO `alat` (`id`, `kode_alat`, `nama_alat`, `kategori`, `foto`, `stok_total`, `stok_tersedia`, `kondisi`, `status_ketersediaan`, `created_at`, `updated_at`) VALUES
(1, 'AAA-001', 'Poco M7 Pro 5G', 'Elektronik', 'alat/2acTjmM95sUrFKAzJP7fWgfLUBp6nyOOHqHMPbMc.jpg', 5, 3, 'baik', 1, '2026-04-09 23:22:58', '2026-04-10 00:34:12'),
(2, 'AAA-002', 'Microphone Logitech', 'Audio', 'alat/kDLjUwBP00YKIgkvu4ea4CmuWgUlhpFVIAWqGYPl.jpg', 5, 2, 'rusak_ringan', 1, '2026-04-10 00:28:06', '2026-04-10 01:05:58'),
(3, 'AAA-003', 'Fujifilm X-M5', 'Multimedia', 'alat/XfL50B0Lz6rZRDwAZGbibq8e5Q8FtcOzE83uVGN4.jpg', 3, 3, 'baik', 1, '2026-04-10 00:35:11', '2026-04-10 00:35:11'),
(4, 'AAA-004', 'Obeng', 'Elektronik', 'alat/NmuVpjQqzpXYPlx7LXgqMDMYvyGQ0PSTr7baNzW1.jpg', 5, 0, 'baik', 1, '2026-04-10 02:33:25', '2026-04-10 02:36:15');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('sipinjam-cache-petugas@test.com678|127.0.0.1', 'i:1;', 1775813849),
('sipinjam-cache-petugas@test.com678|127.0.0.1:timer', 'i:1775813849;', 1775813849);

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
(4, '2026_04_10_031723_add_role_to_users_table', 2),
(5, '2026_04_10_031723_create_alat_table', 2),
(6, '2026_04_10_031723_create_peminjaman_table', 2),
(7, '2026_04_10_114500_add_foto_to_alat_table', 3),
(8, '2026_04_10_150000_add_kategori_to_alat_table', 4);

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
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `alat_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(10) UNSIGNED NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_rencana_kembali` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('pending','dipinjam','rejected','dikembalikan') NOT NULL DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `user_id`, `alat_id`, `qty`, `tanggal_pinjam`, `tanggal_rencana_kembali`, `tanggal_kembali`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 2, '2026-04-10', '2026-04-11', '2026-04-10', 'dikembalikan', 'test', '2026-04-09 23:39:34', '2026-04-09 23:43:08'),
(2, 4, 2, 1, '2026-04-10', '2026-04-30', '2026-04-10', 'dikembalikan', 'mau cover lagu', '2026-04-10 00:59:37', '2026-04-10 01:05:58'),
(3, 8, 4, 5, '2026-04-10', '2026-04-11', NULL, 'dipinjam', 'tekiro', '2026-04-10 02:34:41', '2026-04-10 02:36:15');

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

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('912q5fKQhmlr7bzePAHdRWGY5bfk57MPO0e6cz77', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidG1xYkhtQUtadEZlNzhlOENTQzhQdDBnUG9sTHNFRnRLR24zUFNTeCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW1pbmphbWFuIjtzOjU6InJvdXRlIjtzOjE2OiJwZW1pbmphbWFuLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6ODt9', 1775813681),
('Edh5yGkJ1e2hthKkOLPIHebTvs25yOchcMcPgB54', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibTM4ellqT2dLVEl4Q09mSE8yejFKeWpIaERxdTRyQWc2MEhsZHF6eCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW1pbmphbWFuLXBlbmdlbWJhbGlhbiI7czo1OiJyb3V0ZSI7czoyMzoicGVtaW5qYW1hbi5wZW5nZW1iYWxpYW4iO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1775813847);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'peminjam',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin123', 'admin@test.com', 'admin', NULL, '$2y$12$/FKB5B8xf3kdpuXZLdu0EuRilIDkDdAXWS6C3ycs54gHjj5cRikFa', NULL, '2026-04-09 23:07:13', '2026-04-10 02:30:58'),
(4, 'fatih', 'fatih12@biji', 'peminjam', NULL, '$2y$12$/cz6HaOFy4V8IHPLRRQxCOH6IrokAnjJgbuacFVR9pkrPLMyljx9a', NULL, '2026-04-09 23:10:42', '2026-04-09 23:10:42'),
(7, 'petugas', 'petugas@test.com', 'petugas', NULL, '$2y$12$WWyJk5uEBzvknpS1lTTSJubyrkwIO7YowyyjsjgxdOW0kwMrMiCEi', NULL, '2026-04-10 02:31:52', '2026-04-10 02:31:52'),
(8, 'peminjam', 'peminjam@test.com', 'peminjam', NULL, '$2y$12$R0T/XjPAocQ0TRCcyDyNb.sKmdCn64egVESMg5V08oEJnEOzqsLRC', NULL, '2026-04-10 02:32:20', '2026-04-10 02:32:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alat`
--
ALTER TABLE `alat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alat_kode_alat_unique` (`kode_alat`),
  ADD KEY `alat_nama_alat_index` (`nama_alat`),
  ADD KEY `alat_status_ketersediaan_index` (`status_ketersediaan`),
  ADD KEY `alat_kategori_index` (`kategori`);

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
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjaman_user_id_foreign` (`user_id`),
  ADD KEY `peminjaman_alat_id_foreign` (`alat_id`),
  ADD KEY `peminjaman_status_index` (`status`),
  ADD KEY `peminjaman_tanggal_pinjam_tanggal_rencana_kembali_index` (`tanggal_pinjam`,`tanggal_rencana_kembali`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `alat`
--
ALTER TABLE `alat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_alat_id_foreign` FOREIGN KEY (`alat_id`) REFERENCES `alat` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
