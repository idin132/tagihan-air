-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 26 Jan 2026 pada 07.03
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tagihan_air`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` bigint UNSIGNED NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_aksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_pengelola` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_01_13_062432_pelanggan', 1),
(6, '2026_01_13_062503_pengelola', 1),
(7, '2026_01_13_062510_pembayaran_air', 1),
(8, '2026_01_17_103028_log_aktivitas', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `no_pelanggan` bigint UNSIGNED NOT NULL,
  `nama_pelanggan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_pelanggan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`no_pelanggan`, `nama_pelanggan`, `alamat_pelanggan`, `created_at`, `updated_at`) VALUES
(1, 'Idin Naufal Hakim', 'RT 05', '2026-01-17 03:48:01', '2026-01-17 03:48:01'),
(2, 'Budi', 'RT 01', NULL, NULL),
(3, 'Siti', 'RT 02', NULL, NULL),
(4, 'Andi', 'RT 03', NULL, NULL),
(5, 'Rina', 'RT 04', NULL, NULL),
(6, 'Agus', 'RT 06', NULL, NULL),
(7, 'Dewi', 'RT 07', NULL, NULL),
(8, 'Rudi', 'RT 08', NULL, NULL),
(9, 'Lina', 'RT 09', NULL, NULL),
(10, 'Hendra', 'RT 10', NULL, NULL),
(11, 'Maya', 'RT 11', NULL, NULL),
(12, 'Fajar', 'RT 12', NULL, NULL),
(14, 'Arif', 'RT 14', NULL, NULL),
(15, 'Wati', 'RT 15', NULL, NULL),
(16, 'zaidan', 'RT 10', '2026-01-18 21:09:04', '2026-01-18 21:09:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran_air`
--

CREATE TABLE `pembayaran_air` (
  `id` bigint UNSIGNED NOT NULL,
  `bulan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_pelanggan` bigint UNSIGNED NOT NULL,
  `stand_meter_awal` int NOT NULL,
  `stand_meter_akhir` int NOT NULL,
  `stand_meter_total` int NOT NULL,
  `total_tagihan` decimal(15,2) NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `no_pengelola` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembayaran_air`
--

INSERT INTO `pembayaran_air` (`id`, `bulan`, `no_pelanggan`, `stand_meter_awal`, `stand_meter_akhir`, `stand_meter_total`, `total_tagihan`, `tanggal_pembayaran`, `no_pengelola`, `created_at`, `updated_at`) VALUES
(1, '2026-01', 1, 0, 1, 1, 23500.00, '2026-01-17', 1, '2026-01-17 03:48:16', '2026-01-17 03:48:16'),
(2, '2026-02', 1, 0, 0, 0, 20000.00, '2026-01-17', 1, '2026-01-17 03:48:28', '2026-01-17 03:48:28'),
(3, '2026-01', 1, 0, 2, 2, 27000.00, '2026-01-19', 1, '2026-01-18 21:07:29', '2026-01-18 21:07:29'),
(4, '2026-01', 16, 100, 105, 5, 37500.00, '2026-01-19', 1, '2026-01-18 21:09:50', '2026-01-18 21:09:50'),
(5, '2026-06', 10, 0, 4, 4, 34000.00, '2026-01-19', 1, '2026-01-18 21:13:28', '2026-01-18 21:13:28'),
(6, '2026-01', 1, 0, 3, 3, 30500.00, '2026-01-26', 1, '2026-01-25 23:15:55', '2026-01-25 23:15:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengelola`
--

CREATE TABLE `pengelola` (
  `no_pengelola` bigint UNSIGNED NOT NULL,
  `nama_pengelola` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengelola`
--

INSERT INTO `pengelola` (`no_pengelola`, `nama_pengelola`, `created_at`, `updated_at`) VALUES
(1, 'Bu Gentisya', '2026-01-17 03:48:07', '2026-01-17 03:48:07'),
(2, 'People', '2026-01-17 04:14:47', '2026-01-17 04:14:47'),
(3, 'People 2', '2026-01-17 04:14:54', '2026-01-17 04:14:54'),
(4, 'people 3', '2026-01-17 04:15:00', '2026-01-17 04:15:00'),
(5, 'people 4', '2026-01-17 04:15:06', '2026-01-17 04:15:06'),
(6, 'people 5', '2026-01-17 04:15:12', '2026-01-17 04:15:12'),
(7, 'IDIN', '2026-01-18 21:09:17', '2026-01-18 21:09:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'admin@gmail.com', NULL, '$2y$12$TynnERgawQPtmmx4bZAJseJbUoAh3juVHENQVGDmcZMJhVCttEKF.', NULL, '2026-01-17 03:47:32', '2026-01-17 03:47:32'),
(2, 'Bu Gentisya Tri Mardiani', 'gentisya', 'gentisya@gmail.com', NULL, '$2y$12$6JWD2Yu8DK4dZJZ86nstYORUE4VJ8jsFMTXrzQZ0NhwEMyjrCkmYe', NULL, '2026-01-17 03:47:33', '2026-01-17 03:47:33');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`no_pelanggan`);

--
-- Indeks untuk tabel `pembayaran_air`
--
ALTER TABLE `pembayaran_air`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengelola`
--
ALTER TABLE `pengelola`
  ADD PRIMARY KEY (`no_pengelola`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `no_pelanggan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `pembayaran_air`
--
ALTER TABLE `pembayaran_air`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pengelola`
--
ALTER TABLE `pengelola`
  MODIFY `no_pengelola` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
