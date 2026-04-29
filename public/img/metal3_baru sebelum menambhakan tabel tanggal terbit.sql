-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 07, 2025 at 07:52 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `metal3_baru`
--

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_divisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id`, `nama_divisi`, `created_at`, `updated_at`) VALUES
(1, 'PRODUCTION CKR', NULL, '2024-11-04 23:36:46'),
(2, 'PRODUCTION SDG', NULL, NULL),
(3, 'MTC MEC DAN ELC CKR', NULL, '2025-03-20 19:53:41'),
(4, 'MTC MEC, ELC DAN UTL SDG', NULL, '2025-03-20 19:59:07'),
(7, 'MTC UTILIYY CKR', NULL, '2024-11-04 23:37:24'),
(8, 'HR GA CKR', NULL, '2025-03-20 19:59:51'),
(9, 'HR GA SDG', NULL, '2025-03-20 20:00:04'),
(10, 'SAFETY CKR', NULL, '2024-11-05 00:26:27'),
(11, 'QA CKR', NULL, '2024-11-04 23:37:48'),
(12, 'QA SDG', NULL, NULL),
(13, 'SUPPLY CHAIN DAN WAREHOUSE CKR', NULL, '2025-03-20 20:01:41'),
(14, 'SUPPLY CHAIN DAN WAREHOUSE SDG', NULL, '2025-03-20 20:01:57'),
(15, 'SALES DAN MARKETING', NULL, '2025-03-20 20:02:06'),
(17, 'ACCOUNTING', NULL, NULL),
(18, 'PROCUREMENT', NULL, NULL),
(19, 'PPIC DAN DELIVERY', NULL, '2025-03-20 20:01:18'),
(21, 'EKSPOR DAN IMPOR', NULL, '2025-03-20 19:59:30'),
(22, 'TREASURY', NULL, '2024-10-17 20:15:31'),
(23, 'INVOICING', NULL, NULL),
(25, 'MANUFACTURING', '2024-10-17 20:10:30', '2024-10-17 20:10:30'),
(26, 'LAB', '2024-11-01 20:57:21', '2024-11-01 20:57:21'),
(27, 'SAFETY SDG', '2024-11-05 00:26:52', '2024-11-05 00:26:52'),
(28, 'ENGINEERING', '2024-12-06 18:35:50', '2024-12-06 18:35:50'),
(29, 'BUSSINESS ANALYST', '2025-05-27 19:11:17', '2025-05-27 19:11:17'),
(30, 'IT', '2025-05-27 19:12:47', '2025-05-27 19:12:47'),
(32, 'COORPORATE', '2025-05-27 19:40:39', '2025-05-27 19:40:39'),
(33, 'ALL DEPARTEMEN', '2025-05-27 19:40:55', '2025-05-27 19:40:55'),
(34, 'MANAJEMEN', '2025-05-27 20:31:54', '2025-05-27 20:31:54');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen`
--

CREATE TABLE `dokumen` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_jenis` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `divisi_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dokumen`
--

INSERT INTO `dokumen` (`id`, `nama_jenis`, `divisi_id`, `created_at`, `updated_at`) VALUES
(1, 'MSP.IM.', 25, '2025-08-24 21:13:03', '2025-08-24 21:13:03'),
(2, 'GL.IM.', 25, '2025-08-24 21:13:24', '2025-08-24 21:13:24'),
(3, 'FM.IM.', 25, '2025-10-03 19:28:33', '2025-10-03 19:28:33');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_approvals`
--

CREATE TABLE `dokumen_approvals` (
  `id` bigint UNSIGNED NOT NULL,
  `dokumen_review_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `kind` enum('main','support','reviewer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` enum('approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL,
  `signature_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signature_source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `signed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dokumen_approvals`
--

INSERT INTO `dokumen_approvals` (`id`, `dokumen_review_id`, `user_id`, `kind`, `action`, `signature_path`, `signature_source`, `comment`, `signed_at`, `created_at`, `updated_at`) VALUES
(1, 2, 107, 'main', 'approved', 'approvals/signatures/sig_68e494ce9642e.png', 'canvas', NULL, '2025-10-06 21:19:26', '2025-10-06 21:19:26', '2025-10-06 21:19:26'),
(2, 2, 107, 'support', 'approved', 'approvals/signatures/sig_68e494de3ae55.png', 'canvas', NULL, '2025-10-06 21:19:42', '2025-10-06 21:19:42', '2025-10-06 21:19:42');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_files`
--

CREATE TABLE `dokumen_files` (
  `id` bigint UNSIGNED NOT NULL,
  `dokumen_review_id` bigint UNSIGNED NOT NULL,
  `type` enum('final','revisi_final') COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint UNSIGNED NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `uploaded_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dokumen_files`
--

INSERT INTO `dokumen_files` (`id`, `dokumen_review_id`, `type`, `path`, `original_name`, `mime`, `size`, `note`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(8, 5, 'final', 'dokumen_final/ejWdj8yT1GDwAuOsGDHYr7fXcrPwQyPxaFGYbKI1.pdf', 'IK.FCS.CE.22.00 FILLING MODE ACCUMULATOR ENTRY (1).pdf', 'application/pdf', 161384, NULL, 106, '2025-09-30 23:27:41', '2025-09-30 23:27:41');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_reviews`
--

CREATE TABLE `dokumen_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `dr_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dr_year` smallint UNSIGNED DEFAULT NULL,
  `dr_seq` smallint UNSIGNED DEFAULT NULL,
  `pembuat_id` bigint UNSIGNED NOT NULL,
  `pembuat2_id` bigint UNSIGNED DEFAULT NULL,
  `approver_main_id` bigint UNSIGNED NOT NULL,
  `divisi_id` bigint UNSIGNED NOT NULL,
  `jabatan` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_jenis` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_dokumen` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_dokumen` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alasan_revisi` text COLLATE utf8mb4_unicode_ci,
  `reviewer_ids` json DEFAULT NULL,
  `approver_support_ids` json DEFAULT NULL,
  `draft_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pdf_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dokumen_reviews`
--

INSERT INTO `dokumen_reviews` (`id`, `dr_no`, `dr_year`, `dr_seq`, `pembuat_id`, `pembuat2_id`, `approver_main_id`, `divisi_id`, `jabatan`, `nama_jenis`, `nama_dokumen`, `nomor_dokumen`, `keterangan`, `alasan_revisi`, `reviewer_ids`, `approver_support_ids`, `draft_path`, `pdf_path`, `created_at`, `updated_at`) VALUES
(1, '01/2025', 2025, 1, 105, 107, 106, 1, 'staff', 'MSP.IM.', 'TES NAMBAH TABEL APPROVAL', 'MSP.IM.01', 'BARU', 'UIQDQN', '[\"106\", \"14\"]', NULL, 'dokumen_draft/Xs2lFfn0P0YQh09IpRvXPatDgv8NX0nfoSjCDzhl.pdf', 'dokumen_draft/Xs2lFfn0P0YQh09IpRvXPatDgv8NX0nfoSjCDzhl.pdf', '2025-10-06 00:52:32', '2025-10-06 00:52:32'),
(2, '02/2025', 2025, 2, 106, 105, 107, 1, 'admin', 'GL.IM.', 'tes approval non reviewer', 'GL.IM.01', 'Baru', 'iownqdnjciuadd', '[\"14\"]', NULL, 'dokumen_draft/8BhDBBpPBGNDb8CeFEGvulVQnl9wJw6LR6UQOm2t.pdf', 'dokumen_draft/8BhDBBpPBGNDb8CeFEGvulVQnl9wJw6LR6UQOm2t.pdf', '2025-10-06 20:26:23', '2025-10-06 20:26:23');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_statuses`
--

CREATE TABLE `dokumen_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `dokumen_review_id` bigint UNSIGNED NOT NULL,
  `is_review` tinyint(1) NOT NULL DEFAULT '1',
  `is_revisi` tinyint(1) NOT NULL DEFAULT '0',
  `is_final` tinyint(1) NOT NULL DEFAULT '0',
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dokumen_statuses`
--

INSERT INTO `dokumen_statuses` (`id`, `dokumen_review_id`, `is_review`, `is_revisi`, `is_final`, `is_approved`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 0, 0, 1, 14, '2025-10-06 21:19:26', '2025-10-06 21:23:15');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `formppk`
--

CREATE TABLE `formppk` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenisketidaksesuaian` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pembuat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emailpembuat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `divisipembuat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penerima` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emailpenerima` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `divisipenerima` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cc_email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `evidence` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statusppk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emailverifikasi` json DEFAULT NULL,
  `signature` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nomor_surat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `formppk2`
--

CREATE TABLE `formppk2` (
  `id` bigint UNSIGNED NOT NULL,
  `id_formppk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identifikasi` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signaturepenerima` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `evidencekedua` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `penanggulangan` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pencegahan` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_penanggulangan` date DEFAULT NULL,
  `tgl_pencegahan` date DEFAULT NULL,
  `pic1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pic2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pic1_other` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pic2_other` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `formppk3`
--

CREATE TABLE `formppk3` (
  `id` bigint UNSIGNED NOT NULL,
  `id_formppk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penanggulangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pencegahan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_usulan` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `formppk4`
--

CREATE TABLE `formppk4` (
  `id` bigint UNSIGNED NOT NULL,
  `id_formppk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_verif` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `formppkkedua`
--

CREATE TABLE `formppkkedua` (
  `id` bigint UNSIGNED NOT NULL,
  `id_formppk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identifikasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signaturepenerima` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id` bigint UNSIGNED NOT NULL,
  `divisi_id` bigint UNSIGNED DEFAULT NULL,
  `id_resiko` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_kriteria` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc_kriteria` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `nilai_kriteria` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id`, `divisi_id`, `id_resiko`, `nama_kriteria`, `desc_kriteria`, `nilai_kriteria`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Unsur Keuangan / Kerugian', 'Gangguan kedalam kecil Tidak terlalu berpengaruh terhadap reputasi perusahaan., Gangguan kedalam sedang dan mendapatkan perhatian dari manajemen., Gangguan serius mendapatkan perhatian dari masyarakat dapat merugikan bisnis., Gangguan sangat serius berdampak pada operasional perusahaan menarik perhatian media., Bencana terhentinya operasional perusahaan mengakibatkan jatuhnya harga saham.', '1, 2, 3, 4, 5', '2024-11-06 19:36:03', '2024-12-18 00:35:35'),
(2, NULL, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera memerlukan P3K tetapi pekerja dapat bekerja., Cidera atau sakit sedang pekerja bisa kembali bekerja setelah beristirahat., Cidera mengakibatkan waktu hilang kerja., Cidera fatal memerlukan waktu pemulihan yang lama., Korban jiwa lebih dari satu atau cacat permanen.', '1, 2, 3, 4, 5', '2024-11-06 19:39:42', '2024-12-18 00:35:40'),
(3, NULL, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2024-11-06 19:41:07', '2024-12-18 00:35:44'),
(4, NULL, NULL, 'Reputasi', 'Kejadian atau Incident negatif hanya diketahui internal organisasi tidak ada dampak kepada stakehoder., Kejadian atau Incident negatif mulai diketahui berdampak kepada stakeholders., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders., Kemunduran atau hilang kepercayaan Stakeholders.', '1, 2, 3, 4', '2024-11-06 19:42:11', '2024-12-18 00:35:47'),
(5, NULL, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4', '2024-11-06 19:43:02', '2024-12-18 00:35:50'),
(6, NULL, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 25 - 50 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 50 - 75 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 75 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4', '2024-11-06 19:43:51', '2024-12-18 00:35:59'),
(7, NULL, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4', '2024-11-06 19:44:39', '2024-12-18 00:35:55'),
(11, 8, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 17.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.17.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-11 23:20:58', '2025-09-11 23:20:58'),
(12, 1, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 17.500.000., Kerugian atau biaya yang harus dikeluarkan Rp.17.500.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-11 23:22:01', '2025-09-11 23:22:01'),
(13, 7, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 18.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.18.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-11 23:23:10', '2025-09-11 23:23:10'),
(15, 17, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada`stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 18:32:48', '2025-09-14 18:50:24'),
(16, 17, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 18:51:35', '2025-09-14 18:51:35'),
(17, 17, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 18:52:54', '2025-09-14 18:52:54'),
(18, 17, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-14 18:55:32', '2025-09-14 18:55:32'),
(19, 17, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-14 18:57:47', '2025-09-14 18:57:47'),
(21, 29, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 19:03:01', '2025-09-14 19:03:01'),
(22, 29, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 19:05:18', '2025-09-14 19:05:18'),
(23, 29, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 19:06:56', '2025-09-14 19:06:56'),
(24, 29, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 19:08:03', '2025-09-14 19:08:03'),
(25, 29, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-14 19:10:43', '2025-09-14 19:13:21'),
(26, 29, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-14 19:15:22', '2025-09-14 19:15:22'),
(27, 32, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 19:16:34', '2025-09-14 19:16:34'),
(28, 21, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 19:20:31', '2025-09-14 19:20:31'),
(29, 28, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 19:20:59', '2025-09-14 19:20:59'),
(30, 9, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 19:21:35', '2025-09-14 19:21:35'),
(31, 23, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 19:22:06', '2025-09-14 19:22:06'),
(32, 30, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 19:22:29', '2025-09-14 19:22:29'),
(33, 26, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 19:23:07', '2025-09-14 19:23:07'),
(34, 34, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 19:26:11', '2025-09-14 19:26:11'),
(35, 25, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 19:26:46', '2025-09-14 19:26:46'),
(37, 3, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 19:28:04', '2025-09-14 19:28:04'),
(38, 4, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 19:28:41', '2025-09-14 19:28:41'),
(40, 19, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 19:30:09', '2025-09-14 19:30:09'),
(41, 18, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 20:17:35', '2025-09-14 20:17:35'),
(42, 2, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 20:18:56', '2025-09-14 20:18:56'),
(43, 11, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 20:19:24', '2025-09-14 20:19:24'),
(44, 12, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 20:32:32', '2025-09-14 20:32:32'),
(45, 10, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 20:32:59', '2025-09-14 20:32:59'),
(46, 27, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 20:33:28', '2025-09-14 20:33:28'),
(47, 15, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 20:33:56', '2025-09-14 20:33:56'),
(48, 13, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 20:34:22', '2025-09-14 20:34:22'),
(49, 14, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 20:34:49', '2025-09-14 20:34:49'),
(50, 17, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 20:35:11', '2025-09-14 20:35:11'),
(51, 22, NULL, 'Financial', 'Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 500.000, Kerugian atau biaya yang harus dikeluarkan ≤ Rp. 1.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.1.000.000 >x≥ Rp. 19.000.000., Kerugian atau biaya yang harus dikeluarkan Rp.19.000.000 >x≥ Rp. 70.000.000., Kerugian / biaya yang harus dikeluarkan x>Rp. 70.000.000.', '1, 2, 3, 4, 5', '2025-09-14 20:35:44', '2025-09-14 20:35:44'),
(52, 32, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 20:37:12', '2025-09-14 20:37:12'),
(53, 21, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 20:37:42', '2025-09-14 20:37:42'),
(54, 28, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 20:38:05', '2025-09-14 20:38:05'),
(55, 8, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 20:38:31', '2025-09-14 20:38:31'),
(56, 9, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 20:39:05', '2025-09-14 20:39:05'),
(57, 23, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 20:39:30', '2025-09-14 20:39:30'),
(58, 30, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 20:40:03', '2025-09-14 20:40:03'),
(59, 26, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 20:40:33', '2025-09-14 20:40:33'),
(60, 34, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 20:41:00', '2025-09-14 20:41:00'),
(61, 25, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 20:41:28', '2025-09-14 20:41:28'),
(62, 3, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 20:59:47', '2025-09-14 20:59:47'),
(63, 4, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 21:00:21', '2025-09-14 21:00:21'),
(64, 7, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 21:01:08', '2025-09-14 21:01:08'),
(65, 19, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 21:01:38', '2025-09-14 21:01:38'),
(66, 18, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 21:02:27', '2025-09-14 21:02:27'),
(67, 1, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 21:03:01', '2025-09-14 21:03:01'),
(68, 2, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 21:03:30', '2025-09-14 21:03:30'),
(69, 11, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 21:04:06', '2025-09-14 21:04:06'),
(70, 12, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 21:04:45', '2025-09-14 21:04:45'),
(71, 10, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 21:05:25', '2025-09-14 21:05:25'),
(72, 27, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 21:06:17', '2025-09-14 21:06:17'),
(73, 15, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 21:06:58', '2025-09-14 21:06:58'),
(74, 13, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 21:07:31', '2025-09-14 21:07:31'),
(75, 14, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 21:08:06', '2025-09-14 21:08:06'),
(76, 22, NULL, 'Reputasi', 'Kejadian / Incident negatif hanya diketahui internal departemen tidak ada dampak kepada Perusahaan., Kejadian / Incident negatif hanya diketahui internal Perusahaan tidak ada dampak kepada stakehoder., Kejadian / Incident negatif mulai diketahui / berdampak kepada stakeholder., Pemberitaan negatif yang menurunkan kepercayaan Stakeholders, Kemunduran/hilang kepercayaan Stakeholders', '1, 2, 3, 4, 5', '2025-09-14 21:08:36', '2025-09-14 21:08:36'),
(77, 32, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:10:16', '2025-09-14 21:10:16'),
(78, 21, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:11:29', '2025-09-14 21:11:29'),
(79, 28, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:12:00', '2025-09-14 21:12:00'),
(80, 8, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:12:34', '2025-09-14 21:12:34'),
(81, 9, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:13:06', '2025-09-14 21:13:06'),
(82, 23, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:13:36', '2025-09-14 21:13:36'),
(83, 30, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:13:59', '2025-09-14 21:13:59'),
(84, 26, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:15:43', '2025-09-14 21:15:43'),
(85, 34, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:16:13', '2025-09-14 21:16:13'),
(86, 25, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:16:39', '2025-09-14 21:16:39'),
(87, 3, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:17:05', '2025-09-14 21:17:05'),
(88, 4, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:17:34', '2025-09-14 21:17:34'),
(89, 7, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:18:34', '2025-09-14 21:18:34'),
(90, 19, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:19:02', '2025-09-14 21:19:02'),
(91, 18, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:19:30', '2025-09-14 21:19:30'),
(92, 1, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:19:56', '2025-09-14 21:19:56'),
(93, 2, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:20:35', '2025-09-14 21:20:35'),
(94, 11, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:21:02', '2025-09-14 21:21:02'),
(95, 12, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:21:24', '2025-09-14 21:21:24'),
(96, 10, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:22:08', '2025-09-14 21:22:08'),
(97, 27, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:22:42', '2025-09-14 21:22:42'),
(98, 15, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:23:08', '2025-09-14 21:23:08'),
(99, 13, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:23:34', '2025-09-14 21:23:34'),
(100, 14, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:24:00', '2025-09-14 21:24:00'),
(101, 22, NULL, 'Kinerja', 'Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 0.5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) ≤ 1 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 1< x≤ 3 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan) 3< x≤ 5 jam., Menimbulkan penundaan aktivitas (proses tidak dapat dijalankan)>5 Jam (Uraian kerja tidak efektif dan efisien).', '1, 2, 3, 4, 5', '2025-09-14 21:24:24', '2025-09-14 21:24:24'),
(102, 32, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:17:18', '2025-09-14 23:17:18'),
(103, 21, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:17:44', '2025-09-14 23:17:44'),
(104, 28, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:18:14', '2025-09-14 23:18:14'),
(105, 8, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:18:38', '2025-09-14 23:18:38'),
(106, 9, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:19:11', '2025-09-14 23:19:11'),
(107, 23, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:19:33', '2025-09-14 23:19:33'),
(108, 30, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:20:01', '2025-09-14 23:20:01'),
(109, 26, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:20:39', '2025-09-14 23:20:39'),
(110, 34, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:21:05', '2025-09-14 23:21:05');
INSERT INTO `kriteria` (`id`, `divisi_id`, `id_resiko`, `nama_kriteria`, `desc_kriteria`, `nilai_kriteria`, `created_at`, `updated_at`) VALUES
(111, 25, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:21:26', '2025-09-14 23:21:26'),
(112, 3, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:21:52', '2025-09-14 23:21:52'),
(113, 4, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:22:14', '2025-09-14 23:22:14'),
(114, 7, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:22:50', '2025-09-14 23:22:50'),
(115, 19, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:23:32', '2025-09-14 23:23:32'),
(116, 18, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:24:00', '2025-09-14 23:24:00'),
(117, 1, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:24:30', '2025-09-14 23:24:30'),
(118, 2, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:25:01', '2025-09-14 23:25:01'),
(119, 11, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:25:25', '2025-09-14 23:25:25'),
(120, 12, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:26:04', '2025-09-14 23:26:04'),
(121, 10, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:26:26', '2025-09-14 23:26:26'),
(122, 27, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:26:50', '2025-09-14 23:26:50'),
(123, 15, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:27:28', '2025-09-14 23:27:28'),
(124, 13, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:28:14', '2025-09-14 23:28:14'),
(125, 14, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:28:49', '2025-09-14 23:28:49'),
(126, 22, NULL, 'Operational', 'Menimbulkan gangguan kecil pada fungsi sistem terhadap proses bisnis namun tidak signifikan., Menimbulkan gangguan 20 - 40 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 41 - 60 % fungsi operasional atau hanya berdampak pada 1 unit bisnis., Menimbulkan gangguan 61 - 80 % fungsi operasional atau berdampak pada 2 unit bisnis terkait., Menimbulkan kegagalan > 80 % proses operasional atau berdampak pada sebagian besar unit bisnis.', '1, 2, 3, 4, 5', '2025-09-14 23:29:26', '2025-09-14 23:29:26'),
(127, 32, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-14 23:44:49', '2025-09-14 23:44:49'),
(128, 21, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-14 23:45:19', '2025-09-14 23:45:19'),
(129, 28, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-14 23:46:00', '2025-09-14 23:46:00'),
(130, 8, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-14 23:46:31', '2025-09-14 23:46:31'),
(131, 9, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-14 23:47:02', '2025-09-14 23:47:02'),
(132, 23, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-14 23:47:49', '2025-09-14 23:47:49'),
(133, 30, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-14 23:48:19', '2025-09-14 23:48:19'),
(134, 26, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-14 23:56:14', '2025-09-14 23:56:14'),
(135, 34, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-14 23:56:39', '2025-09-14 23:56:39'),
(136, 25, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-14 23:57:06', '2025-09-14 23:57:06'),
(137, 3, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-14 23:57:35', '2025-09-14 23:57:35'),
(138, 4, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-14 23:57:59', '2025-09-14 23:57:59'),
(139, 7, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-14 23:58:23', '2025-09-14 23:58:23'),
(140, 19, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-15 00:34:24', '2025-09-15 00:34:24'),
(141, 18, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-15 00:35:11', '2025-09-15 00:35:11'),
(142, 1, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-15 00:35:35', '2025-09-15 00:35:35'),
(143, 2, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-15 00:36:09', '2025-09-15 00:36:09'),
(144, 11, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-15 00:36:35', '2025-09-15 00:36:35'),
(145, 12, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-15 00:37:17', '2025-09-15 00:37:17'),
(146, 10, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-15 00:37:45', '2025-09-15 00:37:45'),
(147, 27, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-15 00:38:15', '2025-09-15 00:38:15'),
(148, 15, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-15 00:44:16', '2025-09-15 00:44:16'),
(149, 13, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-15 00:44:45', '2025-09-15 00:44:45'),
(150, 14, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-15 00:45:05', '2025-09-15 00:45:05'),
(151, 22, NULL, 'Safety & Health', 'Hampir tidak ada risiko cedera tidak membutuhkan atau penanganan P3K minimal tetapi pekerja dapat bekerja kembali., Cidera atau sakit ringan yang bisa diobati P3K atau klinik ditempat kerja tidak menyebabkan gangguan fungsi tubuh dan pekerja dapat bekerja kembali., Cidera atau sakit sedang yang harus memerlukan perawatan medis dan penanganan dokter lama perawatan 1-3 hari tidak menyebabkan gangguan fungsi tubuh terjadi disebagian kecil populasi pekerja., Cidera atau sakit berat yang mengakibatkan cacat / hilangnya fungsi tubuh jangka panjang  memerlukan waktu pemulihan 4-15 hari., Menyebabkan cacat permanen cidera multiple atau sakit membutuhkan perawatan > 15 hari ataupun korban jiwa efek kesehatan irreversible.', '1, 2, 3, 4, 5', '2025-09-15 00:45:28', '2025-09-15 00:45:28'),
(152, 32, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:01:22', '2025-09-15 01:01:22'),
(153, 21, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:01:46', '2025-09-15 01:01:46'),
(154, 28, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:02:09', '2025-09-15 01:02:09'),
(155, 8, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:02:38', '2025-09-15 01:02:38'),
(156, 9, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:03:02', '2025-09-15 01:03:02'),
(157, 23, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:03:20', '2025-09-15 01:03:20'),
(158, 30, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:03:39', '2025-09-15 01:03:39'),
(159, 26, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:04:00', '2025-09-15 01:04:00'),
(160, 34, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:04:21', '2025-09-15 01:04:21'),
(161, 25, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:04:42', '2025-09-15 01:04:42'),
(162, 3, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:05:08', '2025-09-15 01:05:08'),
(163, 4, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:05:42', '2025-09-15 01:05:42'),
(164, 7, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:06:09', '2025-09-15 01:06:09'),
(165, 19, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:06:33', '2025-09-15 01:06:33'),
(166, 18, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:07:09', '2025-09-15 01:07:09'),
(167, 1, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:07:31', '2025-09-15 01:07:31'),
(168, 2, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:08:00', '2025-09-15 01:08:00'),
(169, 11, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:08:19', '2025-09-15 01:08:19'),
(170, 12, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:08:46', '2025-09-15 01:08:46'),
(171, 10, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:09:09', '2025-09-15 01:09:09'),
(172, 27, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:09:37', '2025-09-15 01:09:37'),
(173, 15, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:10:15', '2025-09-15 01:10:15'),
(174, 13, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:10:36', '2025-09-15 01:10:36'),
(175, 14, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:10:58', '2025-09-15 01:10:58'),
(176, 22, NULL, 'Enviromental (lingkungan)', 'Polusi kecil tidak ada dampak terhadap lingkungan atau operasi perusahaan., Polusi yang terdeteksi tetapi tidak terlalu berpengaruh terhadap lingkungan., Polusi serius bisa berdampak pada komunitas sekitar., Polusi besar berdampak besar terhadap lingkungan atau kawasan., Polusi besar yang bisa merusak ekosistem dan mencemari lebih luas.', '1, 2, 3, 4, 5', '2025-09-15 01:11:19', '2025-09-15 01:11:19');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(18, '2014_10_12_100000_create_password_resets_table', 1),
(19, '2019_08_19_000000_create_failed_jobs_table', 1),
(20, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(21, '2024_09_02_035143_create_divisi_table', 1),
(23, '2024_09_03_075947_create_user_table', 2),
(31, '2024_09_24_033939_create_riskregister_table', 3),
(32, '2024_09_24_171436_create_tindakan_table', 4),
(33, '2024_09_25_055734_create_resiko_table', 5),
(34, '2024_09_26_144609_create_realisasi_table', 6),
(35, '2024_10_08_074916_update_enum_values_in_resikos_table', 7),
(36, '2024_10_24_015735_create_userppk_table', 8),
(37, '2024_10_24_024100_create_formppk_table', 9),
(38, '2024_10_29_015539_add_nomor_surat_to_formppk_table', 10),
(40, '2024_10_29_040523_create_formppkkedua_table', 11),
(41, '2024_11_13_020913_create_formppk3_table', 12),
(42, '2024_11_19_040259_create_formppk4_table', 12),
(43, '2025_05_22_015625_create_notifications_table', 12),
(45, '2025_08_25_040442_create_dokumens_table', 13),
(47, '2025_08_26_015742_create_pdf_annotations_table', 15),
(49, '2025_08_28_035632_create_dokumen_files_table', 16),
(54, '2025_09_04_025511_add_acuan_to_tindakan_table', 19),
(56, '2025_09_04_063604_add_aktifitas_kunci_to_riskregister_table', 20),
(57, '2025_09_08_024324_add_divisi_id_to_kriteria_table', 21),
(72, '2025_08_25_042725_create_dokumen_reviews_table', 22),
(73, '2025_08_28_041801_add_dr_fields_to_dokumen_reviews_table', 22),
(74, '2025_08_28_074938_create_dokumen_statuses_table', 22),
(75, '2025_08_28_081923_create_dokumen_approvals_table', 22);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pdf_annotations`
--

CREATE TABLE `pdf_annotations` (
  `id` bigint UNSIGNED NOT NULL,
  `dokumen_review_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `page` int UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rect` json DEFAULT NULL,
  `data` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pdf_annotations`
--

INSERT INTO `pdf_annotations` (`id`, `dokumen_review_id`, `user_id`, `page`, `type`, `rect`, `data`, `created_at`, `updated_at`) VALUES
(38, 5, 106, 1, 'point', '{\"x\": 183.33331298828125, \"y\": 449.6666679382324, \"width\": 0, \"height\": 0}', '{\"baseH\": 847.2451118726061, \"baseW\": 598.9999999999999, \"comment\": \"isi lebih banyak\", \"author_name\": \"usermagang\"}', '2025-09-30 23:29:39', '2025-09-30 23:29:39'),
(39, 5, 14, 1, 'point', '{\"x\": 229.33331298828125, \"y\": 698.6666870117188, \"width\": 0, \"height\": 0}', '{\"baseH\": 847.2451118726061, \"baseW\": 598.9999999999999, \"comment\": \"1. isi dengan bijak dengan keperluan yang matang dengan tambahan qwehsdcbudc\", \"author_name\": \"Agus Wicaksono\"}', '2025-09-30 23:33:07', '2025-09-30 23:33:07'),
(40, 2, 14, 1, 'point', '{\"x\": 235.33331298828125, \"y\": 312, \"width\": 0, \"height\": 0}', '{\"baseH\": 847.2451118726061, \"baseW\": 598.9999999999999, \"comment\": \"asindiquwdasd\", \"author_name\": \"Agus Wicaksono\"}', '2025-10-06 21:23:15', '2025-10-06 21:23:15');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `realisasi`
--

CREATE TABLE `realisasi` (
  `id` bigint UNSIGNED NOT NULL,
  `id_tindakan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_riskregister` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_realisasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_realisasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `evidencerealisasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `presentase` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilai_akhir` decimal(5,2) DEFAULT NULL,
  `nilai_actual` decimal(5,2) DEFAULT NULL,
  `status` enum('CLOSE','ON PROGRES') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `realisasi`
--

INSERT INTO `realisasi` (`id`, `id_tindakan`, `id_riskregister`, `nama_realisasi`, `target`, `desc`, `tgl_realisasi`, `evidencerealisasi`, `presentase`, `nilai_akhir`, `nilai_actual`, `status`, `created_at`, `updated_at`) VALUES
(7, '7', '3', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2024-11-01 00:42:40', '2024-11-01 00:42:40'),
(20, '19', '8', '\"Masih dicarikan vendor pembanding\"', '11', NULL, '2024-10-10', NULL, '40', 40.00, 88.00, 'ON PROGRES', '2024-11-01 21:03:00', '2024-12-15 20:58:02'),
(21, '20', '8', '\"Training external\"', '38', 'Sudah diberikan refresment dari supplier untuk penanganan kebocoran amonia', '2024-11-25', NULL, '100', 100.00, 88.00, 'CLOSE', '2024-11-01 21:03:00', '2024-12-15 20:58:02'),
(22, '21', '8', '\"Flow ERP kebocoran amoniak dibuat dalam MSP.SFT\"', 'Hizbul', NULL, '2024-09-17', NULL, '100', 100.00, 88.00, 'ON PROGRES', '2024-11-01 21:03:00', '2024-12-15 20:58:02'),
(23, '22', '8', '\"Tools emergency\"', '38', 'sudah ada, dan disimpan ditempat yg berjarak aman dgn amonia', '2024-11-25', NULL, '100', 100.00, 88.00, 'CLOSE', '2024-11-01 21:03:00', '2024-12-15 20:58:02'),
(24, '23', '8', '\"Secondary containment\"', '38', 'sudah disediakan secondary containment', '2024-11-25', NULL, '100', 100.00, 88.00, 'CLOSE', '2024-11-01 21:03:00', '2024-12-15 20:58:02'),
(25, '24', '9', '\"Diskusi pengiriman dari pelabuhan bertahap\"', '41', 'Jeff berkoordinasi dengan tim Puninar', '2024-12-31', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-11-01 21:49:42', '2025-03-07 00:18:31'),
(26, '25', '10', '\"Meeting Perbaikan Launder\"', 'Herlambang', NULL, '2024-09-20', NULL, '100', 75.00, 75.00, 'ON PROGRES', '2024-11-01 22:01:50', '2024-11-01 22:09:21'),
(27, '25', '10', '\"Perbaikan cast brick Laundr\"', 'Herlambang', NULL, '2024-09-27', NULL, '100', 75.00, 75.00, NULL, '2024-11-01 22:06:38', '2024-11-01 22:09:21'),
(28, '25', '10', '\"Meeting Modufikasi Burner Control\"', 'Herlambang', NULL, '2024-09-25', NULL, '100', 75.00, 75.00, NULL, '2024-11-01 22:08:17', '2024-11-01 22:09:21'),
(29, '25', '10', '\"Beli Burner Control\"', 'Agus w', NULL, '2024-12-27', NULL, '0', 75.00, 75.00, NULL, '2024-11-01 22:09:21', '2024-11-01 22:09:21'),
(45, '41', '19', '\"Trial Plan\"', '35', 'Dibuatkan trial plan untuk penggunaan material baru', '2024-11-04', NULL, '50', 50.00, 50.00, 'ON PROGRES', '2024-11-03 21:15:44', '2024-11-10 20:51:09'),
(46, '42', '20', '\"Melaksanakan technical meeting dengan supplier\"', '35', 'dilaksanakan per 3 bulan', '2025-12-31', NULL, '50', 50.00, 33.33, 'ON PROGRES', '2024-11-03 21:20:33', '2025-03-03 01:33:26'),
(47, '43', '20', '\"Mereview TDC dari permintaan yang masuk\"', '35', NULL, '2025-12-31', NULL, '50', 50.00, 33.33, 'ON PROGRES', '2024-11-03 21:20:33', '2025-03-03 01:33:26'),
(48, '44', '20', NULL, NULL, NULL, NULL, NULL, '0', NULL, 33.33, 'ON PROGRES', '2024-11-03 21:20:33', '2025-03-03 01:33:26'),
(49, '45', '21', NULL, NULL, NULL, NULL, NULL, '0', 0.00, 16.67, 'ON PROGRES', '2024-11-03 23:06:47', '2025-03-03 01:34:39'),
(50, '46', '21', '\"Melaksanakan technical meeting dengan supplier\"', '35', NULL, '2025-12-31', NULL, '50', 50.00, 16.67, 'ON PROGRES', '2024-11-03 23:06:47', '2025-03-03 01:34:39'),
(51, '47', '21', NULL, NULL, NULL, NULL, NULL, '0', NULL, 16.67, 'ON PROGRES', '2024-11-03 23:06:47', '2025-03-03 01:34:39'),
(52, '48', '22', '\"Labelling\"', '36', 'Labelling tempat sampah B3 dan bahan kimia sudah ada', '2024-11-04', NULL, '75', 75.00, 75.00, 'ON PROGRES', '2024-11-03 23:08:59', '2024-11-10 19:17:12'),
(53, '49', '23', '\"MSDS\"', '36', 'Bahan kimia yang digunakan di laboratorium sudah tersedia MSDS', '2024-11-04', NULL, '75', 75.00, 75.00, 'ON PROGRES', '2024-11-03 23:12:12', '2024-11-10 19:18:13'),
(54, '50', '24', '\"Chromate\"', '35', 'Menggunakan chromate merek Henkel', '2024-11-04', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-11-03 23:21:20', '2024-11-10 20:53:32'),
(56, '51', '25', '\"Menambah tester daily untuk pengujian\"', '55', 'sudah berjalan', '2024-12-31', NULL, '75', 62.50, 62.50, 'ON PROGRES', '2024-11-03 23:33:00', '2025-06-01 19:46:48'),
(57, '52', '26', '\"Training Safety Leadership\"', '39', 'sudah dilakukan training\r\ntrainer pak Abdullah Lubis', '2024-11-15', NULL, '95', 95.00, 67.50, 'CLOSE', '2024-11-04 18:20:49', '2025-02-25 19:40:26'),
(58, '53', '26', '\"Trainer External Investigation Report\"', '39', 'Desember visit & diskusi di TML', '2024-11-25', NULL, '40', 40.00, 67.50, 'ON PROGRES', '2024-11-04 18:20:49', '2025-02-25 19:40:26'),
(59, '54', '27', '\"Trainer external investigation\"', '39', 'Desember visit & diskusi di TML', '2024-11-25', NULL, '40', 40.00, 40.00, 'ON PROGRES', '2024-11-04 18:23:58', '2024-11-24 18:54:25'),
(60, '55', '28', '\"HIRADC\"', '38', 'Sudah terdapat identifikasi bahaya kesehatan didalam HIRADC, dimasing2 dept\r\nReview bersifat Continue', '2024-10-10', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-11-04 18:26:45', '2025-02-25 19:47:27'),
(61, '56', '28', '\"Priority MCU, sudah ada program MCU gratis saat berulang tahun di puskesmas\"', '39', 'Priority karyawan yg MCU sudah teridentifikasi dan sudah diinfokan saat meeting panitia keselamatan\r\nFollow up pelaksanaan nya ke dept terkait', '2025-02-26', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-11-04 18:26:45', '2025-02-25 19:47:27'),
(62, '57', '29', '\"Diskusi terkait kebutuhan data awal dll\"', '49', NULL, '2024-09-16', NULL, '100', 100.00, 66.67, 'ON PROGRES', '2024-11-04 18:36:33', '2025-03-11 03:03:38'),
(63, '58', '30', '\"Review gambar design dan luas bangunan TPS LB3\"', '49', NULL, '2025-04-30', NULL, '100', 100.00, 50.00, 'ON PROGRES', '2024-11-04 18:40:06', '2025-03-11 02:56:39'),
(64, '59', '31', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2024-11-04 18:45:58', '2024-11-04 18:45:58'),
(65, '60', '32', '\"Diskusi awal pada saat review aspect impact\"', '49', NULL, '2024-11-05', NULL, '30', 30.00, 10.00, 'ON PROGRES', '2024-11-04 18:49:17', '2025-03-11 02:49:25'),
(66, '61', '33', '\"SMS & FMS\"', '39', 'program digitalisasi safety masih on progress dibuat', '2024-12-31', NULL, '50', 50.00, 50.00, 'ON PROGRES', '2024-11-04 18:57:30', '2024-11-24 18:33:29'),
(78, '72', '37', '\"Moving coil ke area sisi kolom, suapaya area penempatan paint feed yg akan datang lebih tertata\"', '48', NULL, '2024-11-02', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-11-04 21:12:23', '2024-11-08 10:10:53'),
(79, '73', '37', '\"Proses dokumentasi dan pengecekan Paint feed di lakukan oleh storekeeper,\"', 'Bakhtarudin', 'Setiap personil fokus dg job nya masing\". untuk memaksimalkan proses unloading', '2024-11-02', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-11-04 21:12:23', '2024-11-08 10:10:53'),
(86, '72', '37', '\"Membuat layout per area beserta penomoran dan penamaan masing area\"', '48', NULL, '2024-11-02', NULL, '100', 100.00, 100.00, NULL, '2024-11-04 21:23:25', '2024-11-08 10:10:53'),
(93, '73', '37', '\"Maksimalkan personil dlm proses Unloading\"', 'Bakhtarudin', 'Meberdayakan Forklift untuk proses Unloading. dan penempatan sesuai layout menggunakan Crane', '2024-11-02', NULL, '100', 100.00, 100.00, NULL, '2024-11-04 21:42:38', '2024-11-08 10:10:53'),
(96, '86', '41', '\"Pembuangan waste rag dan waste solvent ke lembaga pengolahan limbah berizin\"', '1', NULL, '2025-04-30', NULL, '100', 100.00, 87.50, 'CLOSE', '2024-11-04 21:44:49', '2025-05-08 20:42:23'),
(98, '88', '42', '\"1. Penambahan Kapasitas Layout CRC, mengosongkan layout barang jadi di Blok F sedangkan barang jadi dipindahkan ke L8\"', '41', NULL, '2024-01-01', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-11-04 23:16:01', '2025-03-06 23:58:17'),
(99, '89', '43', '\"Memindahkan barang-barang slowmoving dan export ke Gudang Tata Sentosa\"', '49', NULL, '2024-03-30', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-11-04 23:40:12', '2025-03-07 00:29:48'),
(105, '93', '45', '\"1. Meminjam Forklift 10 ton di Sadang untuk support Packing dan penyimpanan di L8\"', '41', NULL, '2023-12-05', NULL, '100', 100.00, 95.00, 'ON PROGRES', '2024-11-05 00:16:15', '2025-03-07 00:48:29'),
(111, '97', '48', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2024-11-05 21:35:34', '2024-11-05 21:35:34'),
(112, '98', '49', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2024-11-05 21:44:58', '2024-11-05 21:44:58'),
(113, '99', '49', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2024-11-05 21:50:41', '2024-11-05 21:50:41'),
(114, '100', '48', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2024-11-05 21:53:33', '2024-11-05 21:53:33'),
(115, '101', '48', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2024-11-05 21:53:33', '2024-11-05 21:53:33'),
(116, '102', '50', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2024-11-05 22:02:05', '2024-11-05 22:02:05'),
(117, '103', '50', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2024-11-05 22:04:58', '2024-11-05 22:04:58'),
(118, '104', '50', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2024-11-05 22:04:58', '2024-11-05 22:04:58'),
(119, '105', '51', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2024-11-06 19:58:12', '2024-11-06 19:58:12'),
(120, '106', '51', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2024-11-06 19:58:12', '2024-11-06 19:58:12'),
(121, '107', '51', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2024-11-06 20:07:38', '2024-11-06 20:07:38'),
(123, '109', '53', '\"-\"', '24', '-', '2024-02-01', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-11-08 20:01:36', '2025-03-07 20:59:26'),
(124, '110', '54', NULL, NULL, NULL, NULL, NULL, '0', 0.00, 0.00, 'CLOSE', '2024-11-08 20:21:04', '2024-11-11 01:25:22'),
(125, '111', '54', NULL, NULL, NULL, NULL, NULL, '0', 0.00, 0.00, 'CLOSE', '2024-11-08 20:21:04', '2024-11-11 01:25:22'),
(126, '112', '54', NULL, NULL, NULL, NULL, NULL, '0', 0.00, 0.00, 'CLOSE', '2024-11-08 20:21:04', '2024-11-11 01:25:22'),
(127, '113', '55', NULL, NULL, NULL, NULL, NULL, '0', 0.00, 0.00, 'CLOSE', '2024-11-08 20:21:05', '2025-03-07 20:52:44'),
(128, '114', '56', NULL, NULL, NULL, NULL, NULL, '0', 50.00, 50.00, 'CLOSE', '2024-11-08 20:28:43', '2025-03-07 20:50:43'),
(130, '115', '57', '\"Meeting Perbaikan Launder\"', '22', 'menentukan time line pekerjaan', '2024-12-09', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-11-08 20:36:56', '2025-03-07 20:44:48'),
(131, '116', '58', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2024-11-08 21:17:52', '2024-11-08 21:17:52'),
(132, '117', '59', '\"Technical Aggrement\"', '55', 'Technical Aggrement dengan supplier (KBI)', '2024-09-02', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-11-08 21:38:03', '2024-11-08 21:46:13'),
(133, '118', '59', '\"Meeting Supplier\"', '35', 'Meeting dengan supplier (GRP)', '2024-10-18', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-11-08 21:38:03', '2024-11-08 21:46:13'),
(134, '119', '59', '\"Komplain Supplier\"', '34', 'Melakukan komplain ketidaksesuaian CRC dengan supplier (KBI)', '2024-11-01', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-11-08 21:38:03', '2024-11-08 21:46:13'),
(135, '120', '60', '\"Daftar Induk Kalibrasi\"', '36', 'Daftar Induk Kalibrasi sudah terupdate', '2024-11-09', NULL, '100', 100.00, 60.00, 'ON PROGRES', '2024-11-08 21:41:27', '2024-11-08 21:53:14'),
(136, '121', '60', NULL, NULL, NULL, NULL, NULL, '0', NULL, 50.00, 'ON PROGRES', '2024-11-08 21:41:27', '2024-11-08 21:51:51'),
(137, '122', '60', NULL, NULL, NULL, NULL, NULL, '0', NULL, 50.00, 'ON PROGRES', '2024-11-08 21:41:27', '2024-11-08 21:51:51'),
(138, '123', '60', '\"Reclass\"', '35', 'CI24-109612\r\nCI24-109613\r\nCI24-109615\r\nCI24-109616\r\nCI24-109620\r\nCI24-109814\r\nCI24-109815', '2024-10-31', NULL, '100', 100.00, 50.00, 'ON PROGRES', '2024-11-08 21:41:27', '2024-11-08 21:51:51'),
(139, '120', '60', '\"Desktop Reminder\"', '34', 'Mengupdate jadwal kalibrasi di program komputer', '2024-11-09', NULL, '100', 100.00, 60.00, NULL, '2024-11-08 21:53:14', '2024-11-08 21:53:14'),
(145, '126', '61', NULL, NULL, NULL, NULL, NULL, '0', 0.00, 25.00, 'CLOSE', '2024-11-09 21:19:19', '2025-03-04 15:01:04'),
(152, '133', '64', '\"IK handling limbah B3 (HCl)\"', '36', 'IK sudah tersedia', '2024-05-11', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-11-10 18:50:33', '2024-11-10 18:53:38'),
(157, '138', '66', '\"IK Drawdown\"', '36', 'Draft IK sedang di DR', '2024-05-11', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-11-10 18:58:29', '2024-11-10 19:00:16'),
(158, '139', '66', '\"Technical Aggrement\"', '35', 'Technical Aggrement dengan team sadang sudah di share di grup operatiron', '2024-11-04', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-11-10 18:58:29', '2024-11-10 19:00:16'),
(159, '140', '67', '\"Daftar Induk Kalibrasi\"', '36', 'Daftar Induk Kalibrasi sudah terupdate', '2024-11-09', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-11-10 19:02:57', '2024-11-10 19:06:20'),
(160, '141', '67', '\"IK Verifikasi Alat ukur\"', '36', 'Draft revisi IK.QA.03', '2024-10-05', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-11-10 19:02:57', '2024-11-10 19:06:20'),
(161, '140', '67', '\"Dekstop Reminder\"', '34', 'Mengupdate jadwal kalibrasi di program komputer', '2024-11-09', NULL, '100', 100.00, 100.00, NULL, '2024-11-10 19:04:16', '2024-11-10 19:06:20'),
(162, '141', '67', '\"IK Verifikasi Alat ukur\"', '36', 'IK.QA.03.01 sudah selesai DR', '2024-10-19', NULL, '100', 100.00, 100.00, NULL, '2024-11-10 19:05:35', '2024-11-10 19:06:20'),
(163, '141', '67', '\"Verifikasi Alat Ukur\"', '36', 'Alat ukur dilakukan verifikasi per shift', '2024-11-09', NULL, '100', 100.00, 100.00, NULL, '2024-11-10 19:06:01', '2024-11-10 19:06:20'),
(164, '142', '68', NULL, NULL, NULL, NULL, NULL, '0', NULL, 37.50, 'ON PROGRES', '2024-11-10 19:08:58', '2024-11-10 20:55:06'),
(165, '143', '68', '\"Trial Plan\"', '35', 'Setiap produk baru sudah tersedia Trial Plan', '2024-11-04', NULL, '75', 75.00, 37.50, 'ON PROGRES', '2024-11-10 19:08:58', '2024-11-10 20:55:06'),
(166, '144', '69', '\"Standar produk di TDC sesuai permintaan customer\"', '35', NULL, '2025-12-31', NULL, '50', 50.00, 25.00, 'ON PROGRES', '2024-11-10 19:11:45', '2025-03-03 01:36:42'),
(167, '145', '69', NULL, NULL, NULL, NULL, NULL, '0', NULL, 25.00, 'ON PROGRES', '2024-11-10 19:11:45', '2025-03-03 01:36:42'),
(169, '146', '70', '\"Update Prosedur\"', '36', 'GL.QA.01 sudah diupdate', '2024-11-04', NULL, '100', 100.00, 66.67, 'ON PROGRES', '2024-11-10 19:14:56', '2024-11-10 19:16:12'),
(170, '147', '70', NULL, NULL, NULL, NULL, NULL, '0', NULL, 66.67, 'ON PROGRES', '2024-11-10 19:14:56', '2024-11-10 19:16:12'),
(171, '146', '70', '\"Update Prosedur\"', '36', 'GL.QA.03 sudah diupdate', '2024-11-04', NULL, '100', 100.00, 66.67, NULL, '2024-11-10 19:16:11', '2024-11-10 19:16:12'),
(172, '148', '71', '\"Update Prosedur\"', '36', 'GL.QA.01 sudah diupdate', '2024-11-04', NULL, '100', 100.00, 33.33, 'ON PROGRES', '2024-11-10 19:19:15', '2024-11-10 19:20:16'),
(173, '149', '71', NULL, NULL, NULL, NULL, NULL, '0', NULL, 33.33, 'ON PROGRES', '2024-11-10 19:19:15', '2024-11-10 19:20:16'),
(174, '150', '71', NULL, NULL, NULL, NULL, NULL, '0', NULL, 33.33, 'ON PROGRES', '2024-11-10 19:19:15', '2024-11-10 19:20:16'),
(175, '151', '72', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2024-11-10 19:22:39', '2024-11-10 19:22:39'),
(176, '152', '73', '\"pembuatan interlock\"', '6', NULL, '2024-06-24', NULL, '60', 60.00, 78.00, 'ON PROGRES', '2024-11-10 19:28:34', '2025-05-08 23:32:14'),
(177, '153', '73', '\"LOTO prosedur\"', '60', NULL, '2024-12-16', NULL, '75', 75.00, 78.00, 'ON PROGRES', '2024-11-10 19:28:34', '2025-05-08 23:32:14'),
(178, '154', '73', '\"interlock saat cleaning mode\"', '6', NULL, '2024-12-23', NULL, '85', 85.00, 78.00, 'ON PROGRES', '2024-11-10 19:28:34', '2025-05-08 23:32:14'),
(179, '155', '73', '\"Menggunakan alat bantu saat bersentuhan dengan strip yang berjalan\"', '31', NULL, '2024-12-23', NULL, '100', 100.00, 78.00, 'CLOSE', '2024-11-10 19:28:34', '2025-05-08 23:32:14'),
(180, '156', '73', '\"Update HIRADC di setiap tahapan pekerjaan\"', '85', NULL, '2024-12-23', NULL, '70', 70.00, 78.00, 'ON PROGRES', '2024-11-10 19:28:34', '2025-05-08 23:32:14'),
(181, '157', '74', '\"Pemisahan tempat sampah B3\"', '1', 'penentuan titik limbah B3', '2024-11-30', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-11-10 19:35:41', '2025-05-08 01:26:39'),
(182, '158', '74', '\"pembuatan tempat khusus limbah B3\"', '1', NULL, '2025-04-21', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-11-10 19:35:41', '2025-05-08 01:26:39'),
(183, '157', '74', '\"Pembuatan tempat khusus limbah B3\"', '1', 'Khusus paint storage dan thinner dan majun bekas solvent', '2024-11-30', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-11-10 19:36:52', '2025-05-08 01:26:39'),
(184, '159', '75', '\"Membuat technical spesifikasi bahan baku yang akan digunakan\"', '47', NULL, '2024-11-25', NULL, '100', 100.00, 88.75, 'CLOSE', '2024-11-10 19:39:01', '2025-05-08 23:38:19'),
(185, '160', '75', '\"Meeting dengan calon supplier\"', '47', NULL, '2024-12-23', NULL, '100', 100.00, 88.75, 'CLOSE', '2024-11-10 19:41:12', '2025-05-08 23:38:19'),
(186, '161', '75', '\"Meningkatkan keterampilan operator dalam handling material\"', '85', NULL, '2025-02-17', NULL, '75', 75.00, 88.75, 'ON PROGRES', '2024-11-10 19:41:12', '2025-05-08 23:38:19'),
(187, '162', '75', '\"Optimalisasi parameter dan equipment\"', '59', NULL, '2024-12-23', NULL, '80', 80.00, 88.75, 'ON PROGRES', '2024-11-10 19:41:12', '2025-05-08 23:38:19'),
(188, '163', '76', NULL, NULL, NULL, NULL, NULL, '0', 0.00, 0.00, 'CLOSE', '2024-11-10 19:47:16', '2024-11-12 09:44:06'),
(189, '164', '76', NULL, NULL, NULL, NULL, NULL, '0', 0.00, 0.00, 'CLOSE', '2024-11-10 19:47:16', '2024-11-12 09:44:06'),
(191, '166', '77', NULL, NULL, NULL, NULL, NULL, '0', NULL, 0.00, 'ON PROGRES', '2024-11-10 19:52:17', '2024-11-12 09:47:15'),
(193, '168', '77', NULL, NULL, NULL, NULL, NULL, '0', NULL, 0.00, 'ON PROGRES', '2024-11-10 19:52:17', '2024-11-12 09:47:15'),
(195, '170', '78', '\"Aktivasi kembali proses WMS setelah data migration Bravo ke Extendo\"', '47', NULL, '2025-04-30', NULL, '100', 75.00, 75.00, 'ON PROGRES', '2024-11-10 19:55:10', '2025-05-09 22:32:07'),
(201, '176', '83', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2024-11-10 20:20:35', '2024-11-10 20:20:35'),
(209, '180', '86', '\"Install overflow di tanki WQ\"', '32', NULL, '2024-12-23', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-11-27 21:20:19', '2025-05-08 23:43:50'),
(213, '184', '88', '\"Guarding area Tangki Amonia (Tembok)\"', '66', 'Pembelian gembok baru untuk tangki amonia', '2023-01-01', NULL, '100', 100.00, 44.44, 'ON PROGRES', '2024-12-06 20:05:51', '2024-12-06 21:17:51'),
(214, '185', '88', '\"Wind direction untuk mengetahui arah angin jika yang akan digunakan untuk evakuasi\"', '66', 'Pembelin segara wind direction', '2023-02-01', NULL, '100', 100.00, 44.44, 'CLOSE', '2024-12-06 20:05:51', '2024-12-06 21:17:51'),
(215, '186', '88', NULL, NULL, NULL, NULL, NULL, '0', 0.00, 44.44, 'ON PROGRES', '2024-12-06 20:05:51', '2024-12-06 21:17:51'),
(216, '187', '88', NULL, NULL, NULL, NULL, NULL, '0', NULL, 44.44, 'ON PROGRES', '2024-12-06 20:05:51', '2024-12-06 21:17:51'),
(217, '188', '88', NULL, NULL, NULL, NULL, NULL, '0', NULL, 44.44, 'ON PROGRES', '2024-12-06 20:05:51', '2024-12-06 21:17:51'),
(218, '189', '88', NULL, NULL, NULL, NULL, NULL, '0', NULL, 44.44, 'ON PROGRES', '2024-12-06 20:05:51', '2024-12-06 21:17:51'),
(219, '190', '88', NULL, NULL, NULL, NULL, NULL, '0', NULL, 44.44, 'ON PROGRES', '2024-12-06 20:05:51', '2024-12-06 21:17:51'),
(221, '184', '88', '\"pemasangan gembok\"', '50', 'dilakukan pemasangan gembok segera mungkin', '2024-01-03', NULL, '100', 100.00, 44.44, NULL, '2024-12-06 20:22:04', '2024-12-06 21:17:51'),
(226, '195', '90', '\"Perbaikan Grounding office L8 lantai 1\"', '3', NULL, '2024-11-16', NULL, '100', 25.00, 50.00, 'ON PROGRES', '2024-12-06 20:38:03', '2025-05-08 19:37:14'),
(227, '196', '90', '\"Pembuatan Panel PD 6\"', '3', NULL, '2024-12-14', NULL, '100', 100.00, 50.00, 'CLOSE', '2024-12-06 20:40:46', '2025-05-08 19:37:14'),
(228, '197', '90', '\"pulling kabel grounding dari Panel PD 1ke PD2\"', '3', NULL, '2024-12-14', NULL, '100', 50.00, 50.00, 'ON PROGRES', '2024-12-06 20:40:46', '2025-05-08 19:37:14'),
(229, '198', '91', '\"1. Plan Commissioning\\r\\n2. Record data commissioning\\r\\n3. membuat troubleshooting\"', '21', NULL, '2025-04-16', NULL, '0', 0.00, 0.00, 'ON PROGRES', '2024-12-06 20:43:09', '2024-12-06 21:16:21'),
(230, '199', '91', '\"1. Training operator dalam menoperasikan robotic sleeve\\r\\n2. Training maintenance dalam proses Troubleshooting\"', '21', NULL, '2025-10-07', NULL, '0', 0.00, 0.00, 'ON PROGRES', '2024-12-06 20:43:09', '2024-12-06 21:16:21'),
(231, '185', '88', '\"Pemasangan wind direction\"', '66', 'Penempatan wind direction harus dapat terlihat dari sisi manapun.', '2023-02-02', NULL, '100', 100.00, 44.44, NULL, '2024-12-06 20:43:18', '2024-12-06 21:17:51'),
(232, '196', '90', '\"Penggantian Panel PD 6\"', '3', NULL, '2024-12-31', NULL, '100', 100.00, 50.00, 'CLOSE', '2024-12-06 20:43:38', '2025-05-08 19:37:14'),
(234, '195', '90', '\"Perbaikan Grounding Office L8 Lantai 2\"', '3', 'prepared job by Handhika', '2024-12-31', NULL, NULL, 25.00, 50.00, NULL, '2024-12-06 21:01:23', '2025-05-08 19:37:14'),
(235, '195', '90', '\"Perbaikan Grounding Office Proyek\"', '3', NULL, '2024-12-31', NULL, NULL, 25.00, 50.00, NULL, '2024-12-06 21:02:05', '2025-05-08 19:37:14'),
(236, '195', '90', '\"Perbaikan Grounding Gudanng Proyek\"', '4', 'prepared job by handika', '2024-12-31', NULL, NULL, 25.00, 50.00, NULL, '2024-12-06 21:03:04', '2025-05-08 19:37:14'),
(237, '200', '88', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2024-12-06 21:18:50', '2024-12-06 21:18:50'),
(238, '201', '92', '\"Membuat checklist 5S internal\"', '54', NULL, '2024-07-01', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-13 18:59:49', '2025-02-25 19:49:10'),
(239, '202', '92', '\"Memastikan setiap ruangan memakai pendingin ruangan R32\"', '11', NULL, '2024-03-21', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-13 18:59:49', '2025-02-25 19:49:10'),
(240, '203', '92', '\"Membuat sign2 hemat energi\"', '39', NULL, '2023-01-18', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-13 18:59:49', '2025-02-25 19:49:10'),
(241, '204', '92', '\"Membuat poster dan tumbler\"', '39', NULL, '2024-06-01', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-13 18:59:49', '2025-02-25 19:49:10'),
(242, '205', '92', '\"Migrasi beberapa program agar tidak menggunakan kertas\"', '39', NULL, '2024-11-30', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-13 18:59:49', '2025-02-25 19:49:10'),
(243, '206', '93', '\"Rambu sudah terpasang\"', '60', NULL, '2024-09-10', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-15 20:49:05', '2024-12-15 20:55:34'),
(244, '207', '93', '\"Sudah membuat dan dipasang poster\"', '60', NULL, '2024-09-10', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-15 20:49:05', '2024-12-15 20:55:34'),
(245, '208', '93', '\"Poster sudah dibuat dan dipasang di line\"', '60', NULL, '2024-09-10', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-15 20:49:05', '2024-12-15 20:55:34'),
(246, '209', '94', '\"Sosialisasi Quality Plan\"', '35', 'Sudah dilaksanakan', '2024-01-06', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-12-15 21:46:51', '2025-03-02 21:52:11'),
(247, '210', '94', '\"Pemisahan struktur organisasi\"', '55', 'Sudah dilaksanakan', '2024-01-31', NULL, '100', 75.00, 83.33, 'ON PROGRES', '2024-12-15 21:46:51', '2025-06-01 19:48:33'),
(248, '211', '95', '\"Penandatangan pakta integritas personel lab\"', '36', 'sudah dilakukan', '2024-12-31', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-12-15 21:51:53', '2025-06-01 19:54:44'),
(249, '212', '96', '\"Revisi form FM.LAB.09\"', '36', 'sudah dilakukan', '2024-12-31', NULL, '100', 75.00, 75.00, 'ON PROGRES', '2024-12-15 21:56:33', '2025-06-01 19:56:21'),
(250, '213', '97', '\"Sampel sudah diberi label\"', '34', 'sudah dilaksanakan', '2024-12-31', NULL, '50', 50.00, 50.00, 'ON PROGRES', '2024-12-15 22:00:41', '2025-03-02 21:56:11'),
(251, '214', '98', '\"Dibuatkan logbook peralatan\"', '35', 'sudah dilaksanakan', '2024-12-31', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-12-15 23:11:07', '2025-03-02 21:59:59'),
(252, '215', '99', '\"Melakukan refreshment secara berkala\"', '36', 'sudah dilakukan', '2025-12-31', NULL, '75', 75.00, 75.00, 'ON PROGRES', '2024-12-15 23:15:59', '2025-03-02 23:22:49'),
(253, '216', '100', '\"Jadwal kalibrasi\"', '34', 'sudah ada', '2025-12-31', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-12-15 23:20:28', '2025-03-02 23:26:08'),
(254, '217', '100', '\"Dilakukan maintenance\\/pembersihan standar block agar tidak karat\"', '36', 'sudah dilaksanakan setiap shutdown', '2025-12-31', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-12-15 23:20:28', '2025-03-02 23:26:08'),
(255, '218', '101', '\"Jadwal kalibrasi\"', '34', 'sudah ada', '2025-12-31', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-12-15 23:25:02', '2025-03-02 23:28:30'),
(256, '219', '101', '\"Dilakukan daily verification setiap shift\"', '36', 'sudah dilaksanakan (hasil verifikasi dicantumkan di test report)', '2025-12-31', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-12-15 23:25:02', '2025-03-02 23:28:30'),
(257, '220', '102', '\"Membuat logbook\"', '36', 'sudah dilakukan', '2024-12-31', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-12-15 23:29:05', '2025-03-02 23:31:20'),
(258, '221', '103', '\"Double check laporan oleh Spv Teknis sebelum diterbitkan\"', '34', 'sudah dilakukan', '2024-12-31', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2024-12-15 23:33:33', '2025-03-02 23:32:49'),
(259, '222', '104', '\"Membuat list digitalisasi (improvement)\"', '36', 'masih berupa draft', '2025-12-31', NULL, '100', 75.00, 75.00, 'ON PROGRES', '2024-12-15 23:43:58', '2025-06-01 19:43:29'),
(260, '223', '105', '\"Menambah tester daily untuk pengujian\"', '55', 'sudah tersedia tester daily', '2025-12-31', NULL, '100', 75.00, 75.00, 'ON PROGRES', '2024-12-15 23:46:11', '2025-06-01 19:45:11'),
(261, '224', '106', '\"1. pembuatan CSMS\\r\\n2. pembuatan penilaian pra kualifikasi\\r\\n3. pembuatan Dokumen Review\\r\\n4. Revisi Dokumen\\r\\n5. Distribusi dokumen\"', '60', 'dokumen sudah di distribusikan', '2024-11-08', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-16 18:11:44', '2024-12-20 21:06:01'),
(262, '225', '106', '\"1. Pembuatan Form ceklist kontraktor\\r\\n2. perhitungan penilaian angka agar sesuai kriteria\\r\\n3. buat Dokumen review\\r\\n4. revisi dokumen riview\\r\\n5. Distribusi dokumen\"', '60', 'Dokumen sudah di distribusikan', '2024-11-08', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-17 23:43:36', '2024-12-20 21:06:01'),
(263, '226', '106', '\"1. Buat format laporan kontraktor\\r\\n2. Diskusi dengan Safety\\/Leader kontraktor\\r\\n3. Implementasi\"', '60', 'Laporan kontraktor sudah di implementasikan', '2023-08-08', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-17 23:43:36', '2024-12-20 21:06:01'),
(264, '227', '107', '\"1. Cek area\\r\\n2. Buat Mapping traffic\\r\\n3. Diskusi dengan kabag\\r\\n4. Pengerjaan pembuatan jalur oleh tim proyek\"', '60', 'Sudah selesai', '2023-08-08', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-18 00:01:55', '2024-12-20 21:19:51'),
(265, '228', '107', '\"1. penentuan titip area pemasangan sign\\r\\n2. order sign \\r\\n3. pemasangan sign\"', '60', 'Sudah terpasang', '2023-08-08', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-18 00:01:55', '2024-12-20 21:19:51'),
(266, '229', '107', '\"1. Identifikasi area\\r\\n2. Buat mapping area\\r\\n3. Diskusi dengan kabar\\r\\n4. Pembuatan jalur oleh tim proyek\"', '60', 'Sudah selesai', '2023-08-08', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-18 00:01:55', '2024-12-20 21:19:51'),
(267, '230', '107', '\"1. Identifikasi area\\r\\n2. penentuan titik pemasangan\\r\\n3. Buat WR ke tim proyek\\r\\n4. Pengerjaan oleh tim proyek\"', '60', 'Done', '2023-08-08', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-18 00:01:55', '2024-12-20 21:19:51'),
(268, '231', '107', '\"1. Cek area\\r\\n2. menentukan titik lokasi pemasangan\\r\\n3. Eksekusi\"', '60', 'Done', '2023-08-08', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-18 00:01:55', '2024-12-20 21:19:51'),
(272, '235', '109', '\"1. Pembuatan prosedure\\r\\n2. Sosialisasi prosedure\"', '60', 'Done', '2023-09-09', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:08:23', '2024-12-22 18:20:11'),
(273, '236', '109', '\"- Membuat jadwal pelatihan\\r\\n- Implementasi pelatihan\"', '60', 'Done', '2023-09-09', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:08:23', '2024-12-22 18:20:11'),
(274, '237', '109', '\"- Buat Flow Kedatangan tamu\\r\\n- Sosisalisasi ke semua divisi\"', '1', 'Done', '2023-09-09', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:08:23', '2024-12-22 18:20:11'),
(275, '238', '110', '\"- Pembuatan tong sampah sesuai jenis\\r\\n- Penentuan titik pemasangan\\r\\n- distribusi tong sampah di titik yang sudah di tentukan\"', '1', 'done', '2023-09-01', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:10:58', '2024-12-22 18:33:12'),
(276, '239', '110', '\"- Pembuatan tong sampah sesuai jenis\\r\\n- pembuatan rangka  tempat sampah\"', '1', 'done', '2023-09-09', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:10:58', '2024-12-22 18:33:12'),
(277, '240', '110', '\"- Pembuatan banner\\r\\n- pembuatan Sign-sign\\/simbol bahaya  sampah B3\"', '60', 'Done', '2023-09-09', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:10:58', '2024-12-22 18:33:12'),
(278, '241', '111', '\"Pembuatan Flowchart saat terjadi keadaan darurat\"', '60', 'done', '2024-09-03', NULL, '100', 100.00, 64.00, 'CLOSE', '2024-12-20 01:13:55', '2025-02-25 20:08:46'),
(279, '242', '111', '\"Pemasangan Alarm untuk Emergency Respon Plan\"', '5', '-', '2024-12-30', NULL, '50', 50.00, 64.00, 'ON PROGRES', '2024-12-20 01:13:55', '2025-02-25 20:08:46'),
(280, '243', '111', '\"Membuat strukture organisasi ERP\"', '60', 'Done', '2024-09-04', NULL, '100', 100.00, 64.00, 'CLOSE', '2024-12-20 01:13:55', '2025-02-25 20:08:46'),
(281, '244', '111', '\"Mengumpulkan semua anggota ERP dan memaparkan tugas dan tanggung jawabnya\"', '60', 'Baru sebagian anggota', '2024-12-20', NULL, '50', 50.00, 64.00, 'ON PROGRES', '2024-12-20 01:13:55', '2025-02-25 20:08:46'),
(282, '245', '111', '\"Drill ERP\"', '60', '-', '2025-02-27', NULL, '20', 20.00, 64.00, 'ON PROGRES', '2024-12-20 01:13:55', '2025-02-25 20:08:46'),
(283, '246', '112', '\"1. Pengajuan Pelatihan\\/Perpanjang  SIO operator\\r\\n2. Pengajuan di setujui Management\\r\\n3. melakukan pelatihan\\/perpajangan SIO\"', '39', 'Done', '2023-03-28', NULL, '100', 100.00, 73.33, 'CLOSE', '2024-12-20 01:16:29', '2024-12-26 18:52:33'),
(284, '247', '112', '\"- Buat jadwal Refreshment  Pengoperasian alat berat\"', '48', 'Continue', '2025-02-06', NULL, '20', 20.00, 73.33, 'ON PROGRES', '2024-12-20 01:16:29', '2024-12-26 18:52:33'),
(285, '248', '112', '\"1. Di berikan arahan sebelum Operator baru mengoprasikan\\r\\n2. Praktek pengoprasian alat berat dengan di dampingi oleh operator senior\\/operator lisensi level 2\"', '48', 'Dilakukan secara continue', '2023-11-03', NULL, '100', 100.00, 73.33, 'CLOSE', '2024-12-20 01:16:29', '2024-12-26 18:52:33'),
(286, '249', '113', '\"sudah terdapat struktur MERP gabung ERP\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 80.00, 'CLOSE', '2024-12-20 01:19:26', '2025-02-25 20:14:00'),
(287, '250', '113', '\"sudah dibelikan dan diletakkan dilapangan\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 80.00, 'CLOSE', '2024-12-20 01:19:26', '2025-02-25 20:14:00'),
(288, '251', '113', '\"Sudah dilakukan pelatihan atau sosialisasi terkait MERP\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 80.00, 'CLOSE', '2024-12-20 01:19:26', '2025-02-25 20:14:00'),
(289, '252', '113', NULL, NULL, NULL, NULL, NULL, '0', NULL, 80.00, 'ON PROGRES', '2024-12-20 01:19:26', '2025-02-25 20:14:00'),
(290, '253', '113', '\"Sudah dibuatkan flow MERP\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 80.00, 'CLOSE', '2024-12-20 01:19:26', '2025-02-25 20:14:00'),
(291, '254', '114', '\"Masih ada karyawan baru yg belum mengikuti\"', '60', NULL, '2025-02-26', NULL, '90', 90.00, 78.00, 'ON PROGRES', '2024-12-20 01:22:02', '2025-02-25 20:21:59'),
(292, '255', '114', '\"Sudah berjalan 100% all karyawan\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 78.00, 'CLOSE', '2024-12-20 01:22:02', '2025-02-25 20:21:59'),
(293, '256', '114', '\"Sudah dibuatkan target KPI\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 78.00, 'CLOSE', '2024-12-20 01:22:02', '2025-02-25 20:21:59'),
(294, '257', '114', '\"Sudah membuat HSE Plan tahun 2025\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 78.00, 'CLOSE', '2024-12-20 01:22:02', '2025-02-25 20:21:59'),
(295, '258', '114', NULL, NULL, NULL, NULL, NULL, '0', NULL, 78.00, 'ON PROGRES', '2024-12-20 01:22:02', '2025-02-25 20:21:59'),
(296, '259', '115', '\"Sudah dibuatkan mapping kebisingan\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:24:32', '2025-02-25 20:26:50'),
(297, '260', '115', '\"Sudah dipasang sign di titik kebisingan\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:24:32', '2025-02-25 20:26:50'),
(298, '261', '115', '\"Sudah berjalan cek rutin tiap bulan\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:24:32', '2025-02-25 20:26:50'),
(299, '262', '116', NULL, NULL, NULL, NULL, NULL, '0', NULL, 50.00, 'ON PROGRES', '2024-12-20 01:25:59', '2025-02-25 20:35:06'),
(300, '263', '116', '\"Sudah mulai dari poster dan video share UKK\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 50.00, 'CLOSE', '2024-12-20 01:25:59', '2025-02-25 20:35:06'),
(301, '264', '117', NULL, NULL, NULL, NULL, NULL, '0', NULL, 20.00, 'ON PROGRES', '2024-12-20 01:28:28', '2025-02-27 20:44:20'),
(302, '265', '117', NULL, NULL, NULL, NULL, NULL, '0', 0.00, 20.00, 'ON PROGRES', '2024-12-20 01:28:28', '2025-02-27 20:44:20'),
(303, '266', '117', NULL, NULL, NULL, NULL, NULL, '0', NULL, 20.00, 'ON PROGRES', '2024-12-20 01:28:28', '2025-02-27 20:44:20'),
(304, '267', '117', '\"Sudah disediakan SCBA, dan APD pemadam kebakaran\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 20.00, 'ON PROGRES', '2024-12-20 01:28:28', '2025-02-27 20:44:20'),
(305, '268', '117', NULL, NULL, NULL, NULL, NULL, '0', NULL, 20.00, 'ON PROGRES', '2024-12-20 01:28:28', '2025-02-27 20:44:20'),
(306, '269', '118', '\"Sudah melakukan pelaporan triwulan ke disnaker provinsi setiap 3 bulan sekali\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:30:29', '2025-02-27 20:54:31'),
(307, '270', '118', '\"Sudah melaporan triwulan ke disnaker provinsi\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:30:29', '2025-02-27 20:54:31'),
(308, '271', '118', '\"Sudah melaporkan triwulan ke disnaker provinsi\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:30:29', '2025-02-27 20:54:31'),
(309, '272', '118', '\"Sudah melaporkan triwulan disnaker provinsi\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:30:29', '2025-02-27 20:54:31'),
(310, '273', '119', '\"Sudah diaction dilapangan\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:33:16', '2025-02-27 20:55:39'),
(311, '274', '120', '\"Sudah dibuat G-Form setiap expedisi mengisi\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:34:38', '2025-02-27 20:59:55'),
(312, '275', '121', '\"Sudah dibuatkan G-Form untuk pengisian monitoring\"', '60', NULL, '2025-02-26', NULL, '70', 70.00, 70.00, 'ON PROGRES', '2024-12-20 01:35:48', '2025-02-27 21:01:39'),
(313, '276', '122', '\"Sudah dibuatkan jalur khusus sepeda dilapangan\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:37:27', '2025-02-27 21:12:54'),
(314, '277', '122', '\"Sudah membuatkan area parkir khusus sepeda dibeberapa titik dilapangan\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:37:27', '2025-02-27 21:12:54'),
(315, '278', '123', '\"Sudah dibuatkan sign dan disosialisasikan saat meetop\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:39:36', '2025-02-27 23:16:38'),
(316, '279', '123', '\"Sudah dilakukan setiap hari oleh team security yg bertugas\"', '60', NULL, '2025-02-26', NULL, '100', 100.00, 100.00, 'CLOSE', '2024-12-20 01:39:36', '2025-02-27 23:16:38'),
(317, '280', '124', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2024-12-20 01:40:54', '2024-12-20 01:40:54'),
(321, '284', '126', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-02-04 00:04:54', '2025-02-04 00:04:54'),
(322, '285', '126', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-02-04 00:04:54', '2025-02-04 00:04:54'),
(323, '286', '127', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-02-04 00:20:08', '2025-02-04 00:20:08'),
(324, '287', '127', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-02-04 00:20:08', '2025-02-04 00:20:08'),
(325, '288', '128', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-02-04 00:24:42', '2025-02-04 00:24:42'),
(326, '289', '128', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-02-04 00:24:42', '2025-02-04 00:24:42'),
(327, '290', '129', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-02-25 20:06:10', '2025-02-25 20:06:10'),
(328, '291', '130', '\"Sudah dibuatkan program SMS dan sudah disosialisasikan\"', '60', NULL, '2025-02-28', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-02-27 23:59:54', '2025-02-28 00:00:45'),
(329, '292', '131', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-02-28 00:07:08', '2025-02-28 00:07:08'),
(330, '293', '132', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-02-28 00:10:01', '2025-02-28 00:10:01'),
(331, '294', '133', NULL, NULL, NULL, NULL, NULL, '0', 0.00, 0.00, 'ON PROGRES', '2025-02-28 18:37:30', '2025-03-03 01:37:23'),
(332, '295', '133', NULL, NULL, NULL, NULL, NULL, '0', NULL, 0.00, 'ON PROGRES', '2025-02-28 18:37:30', '2025-03-03 01:37:23'),
(333, '296', '134', '\"Pembuatan Technical Protocol untuk kebutuhan paintfeed dari masing vendor suplier\"', '57', 'done', '2024-12-02', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-02-28 19:54:57', '2025-05-14 01:16:13'),
(335, '298', '134', '\"Melakukan complaint ketika ditemukan ketidaksesuain pada product paintfeed\"', '57', 'done', '2025-05-09', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-02-28 19:54:57', '2025-05-15 19:25:38'),
(336, '299', '135', '\"melakukan pengujian kalibrasi sebelum masa kalibrasi habis\"', '89', 'done', '2025-01-22', NULL, '100', 100.00, 50.00, 'CLOSE', '2025-02-28 19:57:43', '2025-05-15 19:12:35'),
(337, '300', '135', '\"melakukan traning defect kepada operator\"', '90', 'done', '2025-04-21', NULL, '100', 100.00, 50.00, 'ON PROGRES', '2025-02-28 19:57:43', '2025-05-15 19:50:44'),
(340, '303', '136', '\"Membuat jadwal kalibrasi untuk alat alat yang di pakai untuk support produksi\"', '89', 'done', '2025-02-03', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-02-28 20:01:20', '2025-05-15 19:13:11'),
(341, '304', '136', '\"Melakukan verifikasi internal setiap awal shift\"', '90', 'done', '2025-01-06', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-02-28 20:01:20', '2025-05-15 19:25:20'),
(342, '305', '137', '\"Membuat prosedur untuk trial product baru\"', '58', 'done', '2025-01-06', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-02-28 20:25:58', '2025-05-15 19:15:52'),
(343, '306', '137', '\"Membuat trial plant dan melakukan trial untuk product yang akan di trial\"', '57', 'done', '2025-01-06', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-02-28 20:25:58', '2025-05-14 01:13:09'),
(344, '307', '138', '\"Membuat prosedur tentang type product CCL MSP.QAS.C02\"', '57', 'done', '2024-05-14', NULL, '100', 100.00, 66.67, 'CLOSE', '2025-02-28 20:45:52', '2025-05-15 19:24:35'),
(345, '308', '138', '\"Melakukan sosialisasi ke team terkait tentang product type nexcolor\"', '58', 'done', '2024-05-16', NULL, '100', 100.00, 66.67, 'CLOSE', '2025-02-28 20:45:52', '2025-05-15 19:24:48'),
(346, '309', '138', NULL, NULL, NULL, NULL, NULL, '0', NULL, 66.67, 'ON PROGRES', '2025-02-28 20:45:52', '2025-05-15 19:24:35'),
(347, '310', '139', '\"Membuat Guide line tentang status product GL.QAS.C01\"', '57', 'done', '2024-05-17', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-02-28 20:48:33', '2025-05-15 19:33:45'),
(349, '312', '139', '\"memberikan traning defect kepada operator\"', '89', 'done', '2025-04-21', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-02-28 20:48:33', '2025-05-15 19:33:49'),
(350, '313', '140', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-02-28 20:53:23', '2025-02-28 20:53:23'),
(351, '314', '140', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-02-28 20:53:23', '2025-02-28 20:53:23'),
(352, '315', '141', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-02-28 20:55:30', '2025-02-28 20:55:30'),
(353, '316', '141', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-02-28 20:55:30', '2025-02-28 20:55:30'),
(354, '317', '142', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-02-28 20:57:35', '2025-02-28 20:57:35'),
(356, '319', '144', '\"Meeting dengan customer membahas technical protocol untuk product yang akan di tooling\"', '58', 'done', '2025-05-01', NULL, '100', 100.00, 33.33, 'ON PROGRES', '2025-02-28 21:01:38', '2025-05-14 01:11:50'),
(357, '320', '144', NULL, NULL, NULL, NULL, NULL, '0', NULL, 33.33, 'ON PROGRES', '2025-02-28 21:01:38', '2025-05-14 01:11:50'),
(358, '321', '144', NULL, NULL, NULL, NULL, NULL, '0', NULL, 33.33, 'ON PROGRES', '2025-02-28 21:01:38', '2025-05-14 01:11:50'),
(359, '322', '145', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-02-28 21:05:11', '2025-02-28 21:05:11'),
(360, '323', '146', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-02-28 21:07:01', '2025-02-28 21:07:01'),
(361, '324', '147', '\"melakukan proses preshipment untuk product yang akan dijalankan\"', '89', 'done', '2025-01-06', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-02-28 21:11:29', '2025-05-14 01:07:40'),
(364, '327', '149', '\"Perbaikan Parsial dengan penggantian Brick bagian atas GL pot ( 7 layer)\"', '69', '1. Bersamaan dengan itu dilakukan Bottom Dross Removal (Zinc Enrichment). Dapat mengeluarkan 20 Ton.\r\n2. Penggantian 4 buat Inductor (metal Loop + Drivibe)', '2025-02-01', NULL, '100', 100.00, 50.00, 'CLOSE', '2025-02-28 22:42:12', '2025-05-26 23:43:22'),
(366, '329', '149', NULL, NULL, NULL, NULL, NULL, '0', NULL, 50.00, 'ON PROGRES', '2025-02-28 22:42:12', '2025-05-08 00:57:57'),
(368, '214', '98', '\"Pengisian logbook sesuai keterangan perbaikan\"', '36', 'sudah dilaksanakan', '2025-12-31', NULL, '100', 100.00, 100.00, NULL, '2025-03-02 21:58:10', '2025-03-02 21:59:59'),
(369, '214', '98', '\"Membuat daily checklist peralatan\"', '36', 'sudah dilakukan', '2025-12-31', NULL, '100', 100.00, 100.00, NULL, '2025-03-02 21:59:21', '2025-03-02 21:59:59'),
(370, '214', '98', '\"Membuat form checklist startup\"', '36', 'sudah dilakukan', '2025-12-31', NULL, '100', 100.00, 100.00, NULL, '2025-03-02 21:59:55', '2025-03-02 21:59:59'),
(371, '220', '102', '\"Membuat form daily checklist alat uji\\/ukur\"', '36', 'sudah dilakukan', '2024-12-31', NULL, '100', 100.00, 100.00, NULL, '2025-03-02 23:30:38', '2025-03-02 23:31:20'),
(372, '220', '102', '\"Membuat form checklist startup untuk alat ukur\\/uji\"', '36', 'sudah dilakukan', '2024-12-31', NULL, '100', 100.00, 100.00, NULL, '2025-03-02 23:31:18', '2025-03-02 23:31:20'),
(373, '331', '151', '\"Membuat dan menjalankan Auto Cycle. Setelah dijalankan tetap terjadi penurunan tetapi melandai. Tanggal 11\\/05\\/24 nilai di angka 0,72 >> 01\\/25 nilai di angka 0,58\"', '4', NULL, '2025-03-03', NULL, '100', 100.00, 26.67, 'CLOSE', '2025-03-03 01:34:09', '2025-05-08 00:23:08'),
(374, '332', '151', '\"Melakukan Proses Bubbling + menurunkan level molten metal sampai 1\\/2 lunang throat. Setelah dilakukan 4 hari (24H) bisa terjadi kenaikan Ratio menjadi 0,7. Selanjutnya perlu dilakukan regular bubbling setiap 2 bulan sampai dilakukan penggantian.\"', '22', 'Berlanjut', '2025-04-30', NULL, '50', 50.00, 26.67, 'ON PROGRES', '2025-03-03 01:34:09', '2025-05-08 00:23:08'),
(375, '333', '151', '\"Building Inductor PM POT\"', '69', NULL, '2025-07-31', NULL, '0', 2.50, 26.67, 'ON PROGRES', '2025-03-03 01:34:09', '2025-05-08 00:23:08'),
(376, '334', '152', '\"Mencari Vendor dan Penawaran\"', '13', 'Vendor :\r\n1. Demag/Kore  --> Sudah memeberi design dan penawaran.\r\n2. Giken --> Masih menunggu design', '2025-04-30', NULL, '30', 30.00, 30.00, 'ON PROGRES', '2025-03-04 15:23:30', '2025-05-09 22:20:34'),
(377, '335', '153', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-03-04 16:40:53', '2025-03-04 16:40:53'),
(378, '336', '154', '\"Seleksi Vendor Selfcleaning Nexguard\"', '57', 'Done', '2023-12-19', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-04 18:49:15', '2025-05-13 23:45:38'),
(379, '337', '154', '\"Trial Plant Aplikasi Nexguard\"', '58', 'done', '2024-06-06', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-04 18:49:15', '2025-05-13 23:45:38'),
(380, '338', '154', '\"Memabndingkan performence Nexguard milik inkote dengan milik PPG\"', '57', 'done', '2024-09-17', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-04 19:00:30', '2025-05-13 23:45:38'),
(381, '339', '155', '\"1. Memperhatikan standar penumpukan coil, dengan memperhatikan tonase, ketebalan coil dan lebar coil. Coil dengan tonase lebih besar dan lebar ditumpukan bagian bawah\"', '78', NULL, '2024-07-01', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-06 04:32:29', '2025-03-07 00:56:55'),
(382, '340', '156', '\"1. Mempersiapkan dan mengkoordinasikan proses packing dengan tim Sales dan Exim, untuk mendapatkan standar packing yang terbaik\"', '41', NULL, '2024-07-01', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-06 04:36:25', '2025-03-07 01:09:48'),
(383, '341', '157', '\"1. Koordinasi dengan Sales Support perihal ketentuan pengambilan barang oleh Customer sesuai GL WH\"', '73', NULL, '2021-07-20', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-06 04:43:39', '2025-03-07 01:14:42'),
(384, '342', '158', '\"Menambah tumpukan Alluminium, yang sebelumnya 4 tumpuk menjadi 5 tumpuk (Sebelumnya koordinasi dengan tim Exim, untuk menanyakan ke Supplier tumpukan yg sesuai standar supplier)\"', '72', NULL, '2022-12-01', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-06 05:17:41', '2025-03-07 01:17:47'),
(385, '343', '159', '\"1. Uji Emisi secara berkala\"', '39', NULL, '2024-03-22', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-06 05:22:12', '2025-03-07 01:52:08'),
(386, '344', '160', '\"1. Penyediaan spillkit\"', '39', NULL, '2023-03-01', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-06 05:24:45', '2025-03-07 21:50:20'),
(387, '345', '160', '\"2. Preventif mesin dan kendaraan secara berkala\"', '7', NULL, '2020-01-01', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-06 05:24:45', '2025-03-07 21:50:20'),
(388, '346', '161', '\"Limbah baterai, limbah kain majun eks bahan chemical dikumpulkan dan dikirim ke TPS limbah B3\"', '50', NULL, '2022-01-01', NULL, '95', 95.00, 95.00, 'ON PROGRES', '2025-03-06 05:45:38', '2025-03-07 21:52:03'),
(389, '347', '162', '\"1. Pembuatan Chemical storage sesuai standar beserta Spill kit didalamnya\"', '72', NULL, '2024-02-01', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-06 05:50:25', '2025-03-07 21:56:04'),
(390, '348', '162', '\"2. Diskusi dan komunikasi dengan supplier untuk di uji dan apakah bisa di rework. Jika hasil uji bisa dilakukan proses rework, maka akan di rework\"', '72', NULL, '2024-02-01', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-06 20:02:47', '2025-03-07 21:56:04'),
(391, '349', '162', '\"3. Dikembalikan ke supplier untuk dilakukan proses rework & yang tidak bisa dirework, dilimbahkan ke Supplier atau pihak Ke-3 dan simpan di TPS limbah B3\"', '72', NULL, '2024-02-01', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-06 20:02:47', '2025-03-07 21:56:04'),
(393, '350', '163', '\"1. Saat stopline, membagi beberapa kelompok tim WH untuk melakukan tugas SO dan proses packing \\/ stuffing\"', '78', NULL, '2025-02-18', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-06 21:07:24', '2025-03-07 21:59:10'),
(394, '351', '163', '\"2. SO dilakukan dengan menggunakan HP dengan memasukkan ke template yang sudah ditarik dari stock Bravo\"', '74', NULL, '2025-02-18', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-06 21:07:24', '2025-03-07 21:59:10'),
(395, '352', '163', '\"3. Scan coil berdasarkan blok untuk memperkecil area pencarian\"', '78', NULL, '2025-02-18', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-06 21:07:24', '2025-03-07 21:59:10'),
(396, '353', '164', '\"1. Melakukan SO harian sparepart untuk barang2 yg ada transaksi Supaya apabila terjadi selisih bisa terdeteksi lebih cepat\"', '44', NULL, '2024-11-12', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-06 21:27:43', '2025-03-07 22:00:53'),
(397, '354', '164', '\"2. Melakukan SO semester untuk seluruh stock sparepart\"', '44', NULL, '2024-11-12', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-06 21:27:43', '2025-03-07 22:00:53'),
(398, '355', '164', '\"3. Melakukan monitor ROP untuk menghindari stock tidak tersedia ketika dibutuhkan\"', '44', NULL, '2024-11-12', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-06 21:27:43', '2025-03-07 22:00:53'),
(399, '356', '165', '\"1. Membuat Identifikasi untuk mengetahui akar penyebabnya\"', '78', NULL, '2025-02-20', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-06 21:34:59', '2025-03-07 22:06:29'),
(400, '357', '165', '\"2. Menambahkan karet pada Crane Finish Goods untuk mengurangi dampak kerusakan apabila terkena Crane\"', '78', NULL, '2025-02-20', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-06 21:34:59', '2025-03-07 22:06:29');
INSERT INTO `realisasi` (`id`, `id_tindakan`, `id_riskregister`, `nama_realisasi`, `target`, `desc`, `tgl_realisasi`, `evidencerealisasi`, `presentase`, `nilai_akhir`, `nilai_actual`, `status`, `created_at`, `updated_at`) VALUES
(401, '358', '165', '\"3. Menambahkan Garis batas sesuai lebar coil pada Garpu Froklift, sebagai petunjuk batas aman operator forklift ketika mengangkat coil Slitting\"', '78', NULL, '2025-02-20', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-06 21:34:59', '2025-03-07 22:06:29'),
(402, '359', '165', '\"4. Menambahkan coil lifter pada garpu forklif untuk meminimalkan kerusakan pada inner coil\"', '78', NULL, '2025-02-20', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-06 21:34:59', '2025-03-07 22:06:29'),
(403, '360', '165', '\"5. Menambahkan inner protector untuk mengangkat coil-coil khusus\"', '78', NULL, '2025-02-20', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-06 21:34:59', '2025-03-07 22:06:29'),
(404, '361', '166', '\"1. Menghentikan kegiatan sementara untuk briefing seluruh tim\"', '41', NULL, '2020-01-01', NULL, '100', 100.00, 98.33, 'ON PROGRES', '2025-03-06 23:08:10', '2025-03-07 22:09:25'),
(405, '362', '166', '\"2. Membentuk tim dengan koordinasi tim HSE, untuk investigasi kejadian\"', '78', NULL, '2020-01-01', NULL, '100', 100.00, 98.33, 'ON PROGRES', '2025-03-06 23:08:10', '2025-03-07 22:09:25'),
(406, '363', '166', '\"3. Melakukan corrective action untuk pencegahan kejadian terulang\"', '78', NULL, '2020-01-01', NULL, '95', 95.00, 98.33, 'ON PROGRES', '2025-03-06 23:08:10', '2025-03-07 22:09:25'),
(407, '364', '167', '\"Balok-balok eks import Ingot dipilah , yang bagus digunakan lagi untuk stuffing dan packing dan yang jelek dikumpulkan dan dikirim ke TPS\"', '44', NULL, '2021-01-01', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-06 23:45:29', '2025-03-07 22:10:23'),
(408, '365', '42', '\"2. Pengambilan\\/unloading menggunakan Forklif 23 ton dan dipindahkan ke area CRC. Dengan metode tersebut proses bongkar menjadi lebih cepat.\"', '78', NULL, '2024-01-01', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-06 23:47:42', '2025-03-06 23:58:17'),
(409, '366', '9', '\"Mempersiapkan area Layout, mengosongkan sebagian area barang jadi apabila kapasitas tidak mencukupi dan memindahkan barang jadi ke L8\"', '78', NULL, '2024-08-31', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-07 00:12:16', '2025-03-07 00:18:31'),
(410, '367', '9', '\"3. Koordinasi dengan Kerani Expedisi, untuk bisa mengatur masuknya trailer ke kawasan\"', '78', NULL, '2024-08-31', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-07 00:12:16', '2025-03-07 00:18:31'),
(411, '368', '9', '\"4. Koordinasi dengan Divisi Exim, sebelum kedatangan CRC untuk disampaikan ke pihak Ekspedisi jika memungkinkan tralier diatur masuk kawasan diatas jam 16.00 sore. Untuk menghindari Traffic yang padat.\"', '41', NULL, '2024-08-31', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-07 00:12:16', '2025-03-07 00:18:31'),
(412, '369', '9', '\"5. Meningkatkan kecepatan Unloading dengan 2 lokasi unloading, menggunakan Forklift 23 ton dan Crane\"', '78', NULL, '2024-08-31', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-07 00:12:16', '2025-03-07 00:18:31'),
(413, '370', '43', '\"2. Koordinasi dengan Tatalogam untuk pengiriman stock2 coil Tatalogam yang masih ada di Tata Metal\"', '49', NULL, '2024-03-30', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-07 00:21:29', '2025-03-07 00:29:48'),
(414, '371', '43', '\"Menyewa trailer untuk proses langsiran ke Tatalogam\"', '49', NULL, '2024-03-30', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-07 00:21:29', '2025-03-07 00:29:48'),
(415, '372', '43', '\"Memindahkan barang jadi ke L8, agar layout barang jadi di L3 bisa diisi CRC jika layout penuh\"', '78', NULL, '2024-03-30', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-07 00:21:29', '2025-03-07 00:29:48'),
(416, '373', '43', '\"Melakukan penumpukan coil agar penyimpanan coil di layout bisa maksimal\"', '78', NULL, '2024-03-30', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-07 00:21:29', '2025-03-07 00:29:48'),
(417, '374', '45', '\"Pembangunan gudang dan gedung yang diperuntukan untuk WH sudah mulai menggunakan Crane berkapasitas 10T semuanya.\"', '41', NULL, '2025-01-01', NULL, '90', 90.00, 95.00, 'ON PROGRES', '2025-03-07 00:31:27', '2025-03-07 00:48:29'),
(418, '375', '155', '\"2. Mengganjal palet bagian ujung dengan choke, untuk mengurangi dampak palet pecah\"', '78', NULL, '2024-07-01', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-07 00:53:10', '2025-03-07 00:56:55'),
(419, '376', '155', '\"3. Mengikat tumpukan coil paling pinggir dengan menggunakan sling dan impraboard untuk menahan apabila ada coil yang menggelinding\"', '78', NULL, '2024-07-01', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-07 00:53:10', '2025-03-07 00:56:55'),
(420, '377', '155', '\"4. Mengatur jarak tumpukan baris pertama dan kedua, supaya forklift\\/crane ketika mengambil coil bisa manuver\\/moving dengan aman\"', '78', NULL, '2024-07-01', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-07 00:53:10', '2025-03-07 00:56:55'),
(421, '378', '155', '\"5. Membuat visual prosedur seperti Banner agar operator dilapangan bisa membaca dan mengingat selalu jika ada prosedur yang harus taati dan dijalankan\"', '72', NULL, '2024-07-01', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-07 00:53:10', '2025-03-07 00:56:55'),
(422, '379', '156', '\"2. Membuat Video dan foto2 tahapan packing yang sudah di accept pihak Sales dan Exim\"', '72', NULL, '2024-07-01', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-07 01:03:54', '2025-03-07 01:09:48'),
(423, '380', '156', '\"3. Koordinasi dengan Divisi QA, Produksi & Advisor, untuk pengaturan pengiriman sistem grouping tonase coil, supaya aman ketika dilakukan double stack dikapal\"', '41', NULL, '2024-07-01', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-07 01:03:54', '2025-03-07 01:09:48'),
(424, '381', '156', '\"4. Setting pengiriman sesuai urutan yang sudah ditentukan, dari berat coil. Yaitu Coil yg paling berat dimuat terlebih dahulu\"', '41', NULL, '2024-07-01', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-07 01:03:54', '2025-03-07 01:09:48'),
(425, '382', '156', '\"5. Koordinasi dengan Security, untuk pengaturan parkir semua trailer\"', '78', NULL, '2024-07-01', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-07 01:03:54', '2025-03-07 01:09:48'),
(426, '383', '157', '\"2. Mengecek dan memberi masukan ke ekspedisi terkait resiko apabila muat tidak sesuai standar\"', '73', NULL, '2021-07-20', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-07 01:12:48', '2025-03-07 01:14:42'),
(427, '384', '157', '\"3. Berkoordinasi dengan safety jika ada supir\\/anggota ekspedisi yang tidak menggunakan APD Level 1 sesuai standar\"', '73', NULL, '2021-07-20', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-07 01:12:48', '2025-03-07 01:14:42'),
(428, '385', '159', '\"2. Preventif kendaraan milik TML secara berkala\"', '7', NULL, '2020-01-01', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-07 01:26:06', '2025-03-07 01:52:08'),
(429, '386', '159', '\"3. Pengecekan KIR setiap kendaraan yang masuk\"', '73', NULL, '2020-01-01', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-07 01:26:06', '2025-03-07 01:52:08'),
(430, '114', '56', '\"melakukan trial dg bahan ss400\"', '14', NULL, '2024-12-16', NULL, '100', 50.00, 50.00, 'CLOSE', '2025-03-07 20:50:33', '2025-03-07 20:50:43'),
(431, '387', '32', NULL, NULL, NULL, NULL, NULL, '0', NULL, 10.00, 'ON PROGRES', '2025-03-11 02:47:18', '2025-03-11 02:49:25'),
(432, '388', '32', NULL, NULL, NULL, NULL, NULL, '0', NULL, 10.00, 'ON PROGRES', '2025-03-11 02:47:18', '2025-03-11 02:49:25'),
(433, '389', '30', NULL, NULL, NULL, NULL, NULL, '0', NULL, 50.00, 'ON PROGRES', '2025-03-11 02:54:17', '2025-03-11 02:56:39'),
(434, '390', '29', '\"Diskusi dengan konsultan RKL-RPL Rinci terkait update dan kebutuhan data\"', '49', 'sudah melakukan 3 kali meeting', '2025-02-25', NULL, '100', 100.00, 66.67, 'ON PROGRES', '2025-03-11 03:02:08', '2025-03-11 03:03:38'),
(435, '391', '29', NULL, NULL, NULL, NULL, NULL, '0', NULL, 66.67, 'ON PROGRES', '2025-03-11 03:02:08', '2025-03-11 03:03:38'),
(436, '392', '168', '\"Pengecekan emisi setiap 6 bulan sekali\"', '39', NULL, '2025-12-31', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-16 21:44:56', '2025-03-17 00:40:16'),
(437, '393', '169', '\"Limbah cair di tampung di wastepit untuk di olah di WWTP\"', '10', NULL, '2025-12-31', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-16 21:47:12', '2025-03-17 00:43:49'),
(442, '398', '175', '\"Pemanfaatan kembali Steel Sleave CRC untuk digunakan sebagai Inner Protection Produk\"', '23', NULL, '2025-12-31', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-16 23:18:42', '2025-03-17 00:46:10'),
(443, '399', '176', '\"-1. Pagar besi untuk mengurangi masuk keluar orang dan menjaga agar hanya petugas berwenang saja yang boleh masuk\"', '29', NULL, '2025-03-17', NULL, '100', 100.00, 25.00, 'CLOSE', '2025-03-16 23:21:27', '2025-03-17 00:14:52'),
(444, '400', '176', NULL, NULL, NULL, NULL, NULL, '0', 0.00, 25.00, 'CLOSE', '2025-03-16 23:21:27', '2025-03-17 00:14:52'),
(445, '401', '176', NULL, NULL, NULL, NULL, NULL, '0', 0.00, 25.00, 'CLOSE', '2025-03-16 23:21:27', '2025-03-17 00:14:52'),
(446, '402', '176', NULL, NULL, NULL, NULL, NULL, '0', 0.00, 25.00, 'CLOSE', '2025-03-16 23:21:27', '2025-03-17 00:14:52'),
(447, '403', '177', '\"GL pergantian Chemical Resin\"', '16', NULL, '2025-12-31', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-16 23:28:52', '2025-03-17 00:47:36'),
(448, '404', '178', '\"Penggunaan alat pelindung diri (APD), pemasangan peredam suara, dan pembatasan jam operasi\"', '14', NULL, '2025-12-31', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-17 00:16:29', '2025-03-17 00:49:50'),
(449, '405', '179', NULL, NULL, NULL, NULL, NULL, '0', 0.00, 50.00, 'ON PROGRES', '2025-03-17 00:19:24', '2025-03-17 01:37:44'),
(450, '406', '179', '\"2. Pemakaian AC yang menggunakan freon R22 di L3 di ganti dengan AC freon R32\"', '50', NULL, '2025-03-17', NULL, '100', 100.00, 50.00, 'ON PROGRES', '2025-03-17 00:19:24', '2025-03-17 01:37:44'),
(451, '407', '180', '\"Pengaturan Furnace dengan menggunakan TV Zone ( tidak semua zona NOF dipakai\"', '16', NULL, '2025-12-31', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-17 00:28:08', '2025-03-17 00:53:03'),
(452, '408', '181', '\"Pemindahan tempat khusus untuk cairan Chemical\"', '16', NULL, '2025-12-31', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-17 00:32:10', '2025-03-17 00:56:42'),
(453, '409', '182', '\"Sosialisasi aspek dampak lingkungan terhadap operator\"', '16', NULL, '2025-12-31', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-17 00:35:05', '2025-03-17 01:03:22'),
(454, '410', '183', '\"Membuat Esign Hemat energi jika tidak di gunakan\"', '39', NULL, '2025-12-31', NULL, '100', 65.00, 65.00, 'ON PROGRES', '2025-03-17 00:58:21', '2025-03-17 01:07:23'),
(455, '411', '184', '\"Penyimpanan Cat di Lemari berbahan Besi\"', '17', NULL, '2025-12-31', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-17 00:59:41', '2025-03-17 01:10:04'),
(456, '410', '183', '\"Reuse air SPM untuk Water Cleaning section\"', '16', NULL, '2025-12-17', NULL, '30', 65.00, 65.00, NULL, '2025-03-17 01:07:19', '2025-03-17 01:07:23'),
(457, '412', '185', '\"1. Menginngatkan terkait safety saat morning briefing\\r\\n2. Mengirim tim untuk ikut training safety\\r\\n3. Melaksakan safety walk trough\"', '7', 'activity bisa continue dilakukan', '2025-03-30', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-17 01:22:10', '2025-03-18 00:30:25'),
(458, '413', '185', '\"1. Menginngatkan terkait safety saat morning briefing\\r\\n2. Memberikan training safety\\r\\n3. Melaksakan safety walk trough\"', '39', NULL, '2025-03-30', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-17 01:22:10', '2025-03-18 00:30:25'),
(459, '414', '186', '\"penanaman pohon bambu\"', '50', NULL, '2025-03-17', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-17 01:44:48', '2025-03-17 18:32:14'),
(460, '415', '187', '\"penambahan 1 unit RO\"', '10', NULL, '2024-10-07', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-17 18:50:21', '2025-05-07 20:43:12'),
(461, '416', '133', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-03-17 19:37:54', '2025-03-17 19:37:54'),
(462, '417', '188', '\"Regular  review and update skill matrix\\r\\nRegular merotasi team Group shift\"', '7', NULL, '2025-03-28', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-18 00:19:24', '2025-03-18 00:20:45'),
(463, '418', '189', '\"1. Briefing Pagi dengan mengaplikasikan Social Distancing\\r\\ndan selalu menggunakan Masker.\\r\\n2. Selalu mengingatkan team untuk \\\"New Normal\\\"\"', '7', NULL, '2022-07-13', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-18 01:11:06', '2025-03-18 01:13:22'),
(464, '419', '190', '\"Repair pompa spare dengan tindakan cleaning dan ganti part yang sudah aus\"', '7', NULL, '2025-03-27', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-18 02:13:06', '2025-03-18 02:15:09'),
(465, '420', '191', '\"Perbaikan Parsial dengan penggantian brick bagian atas pot (7 layer) sudah dilakukan.\\r\\nBottom Dross juga sudh diambil 20 Ton dari dari dasar pot.\\r\\nInductor sudah di ganti dengan yang baru semua.\"', '7', NULL, '2025-03-27', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-18 02:19:49', '2025-03-18 02:27:19'),
(466, '421', '192', '\"PM dijalankan sesuai critical level equipment\"', '7', NULL, '2025-03-28', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-19 20:43:10', '2025-03-19 20:49:17'),
(467, '422', '192', '\"Perbaikan re allignment rair crane\"', '7', NULL, '2025-03-28', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-19 20:44:53', '2025-03-19 20:49:17'),
(468, '423', '193', '\"Diskusi terkait urgensi penggunaan crane dengan tim slitting\"', '7', NULL, '2025-03-24', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-19 21:12:02', '2025-03-19 21:12:48'),
(469, '424', '194', '\"Sosialisasi terkait pekerjaan yang berkaitan dengan oli dan grease saat morning briefing\"', '7', NULL, '2025-03-15', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-24 20:44:06', '2025-03-24 20:53:32'),
(470, '425', '194', '\"Pengadaan spill kit koordinasi dengan tim GA atau Safety\"', '9', NULL, '2025-03-19', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-24 20:44:06', '2025-03-24 20:53:32'),
(471, '426', '194', '\"Ganti oil seal dan hose hydraulic mesin CGL dan forklift\"', '9', 'masih ada kemungkinan adanya sumber kebocoran baru', '2025-03-14', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-24 20:44:06', '2025-03-24 20:53:32'),
(472, '427', '195', '\"select and trial Workshop hardchrome\"', '7', NULL, '2025-02-04', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-24 20:57:18', '2025-03-24 20:59:27'),
(473, '428', '196', '\"Membuat peraturan agar tidak melakuka pekerjaan crane diatas kantor\"', '7', NULL, '2025-02-06', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-24 21:04:02', '2025-03-24 21:10:08'),
(474, '429', '196', '\"Pasang sensor interlock travel Crane (Crane 10 T WH)\"', '4', NULL, '2025-02-13', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-24 21:04:02', '2025-03-24 21:10:08'),
(475, '430', '196', '\"Layout kantor dipindah\"', '8', NULL, '2025-01-17', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-24 21:04:02', '2025-03-24 21:10:08'),
(476, '431', '197', '\"Beli bearing dari agen resmi\"', '9', NULL, '2025-01-01', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-24 21:13:26', '2025-03-24 21:14:58'),
(477, '432', '198', '\"Sudah dilakukan diskusi dengan Pt. Giken\"', '7', NULL, '2025-01-16', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-26 00:19:58', '2025-05-08 00:13:09'),
(478, '433', '198', '\"Man power Giken sudah diberikan safety induction\"', '9', NULL, '2025-01-16', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-26 00:19:58', '2025-05-08 00:13:09'),
(479, '434', '198', '\"Pekerjaan disupervisi oleh Pa Nana dari giken\"', '7', NULL, '2025-01-16', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-03-26 00:19:58', '2025-05-08 00:13:09'),
(480, '435', '199', '\"Sudah dilakukan training saety riding\"', '39', NULL, '2025-02-28', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-26 01:02:34', '2025-05-08 00:33:47'),
(481, '436', '199', '\"Vaksinasi sudah dilakukan\"', '39', NULL, '2025-02-28', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-26 01:02:34', '2025-05-08 00:33:47'),
(482, '437', '200', '\"Diatur waktu pekerjaannya di waktu yang sudah berkurang panas lingkungannya. terutama apabila pekerjaan yang harus naik dan mendekati ketinggian atap (PM Crane)\"', '7', NULL, '2025-03-30', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-26 01:07:15', '2025-05-07 23:33:50'),
(483, '438', '200', '\"Menghindari terjadinya Dehidrasi, dengan membawa minuman di Tumbler untuk bekerja di ketinggian\"', '7', NULL, '2025-03-30', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-26 01:07:15', '2025-05-07 23:33:50'),
(484, '439', '201', '\"1. Pakta Integritas 2. Dilaksanakan sesuai SOP Vendor Selection (IK.PR.05.02) 3. Spesifikasi teknis yang Jelas 4. Proses Negosiasi Final diserahkan ke Pihak Procurement. 5. Dijalankan aturan untuk pelaporan sistem Whistle Blower\"', '7', NULL, '2025-06-30', NULL, '75', 75.00, 75.00, 'ON PROGRES', '2025-03-26 01:14:34', '2025-05-08 00:25:09'),
(485, '440', '206', '\"1. Area fabrikasi dipindah ke L8\\r\\n2. Penggunaan sink roll dia 600\\r\\n3. Penambahan blade scrapper dari 2 ke 3 pcs\"', '7', NULL, '2024-12-31', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-03-26 01:23:34', '2025-03-26 01:25:09'),
(487, '442', '208', '\"Pembuatan Cable tray dari Panel Pot menuju ke JB Panel GL POT\"', '3', NULL, '2024-08-31', NULL, '100', 66.25, 66.25, 'ON PROGRES', '2025-04-18 22:25:36', '2025-04-18 22:37:20'),
(488, '442', '208', '\"Pulling Cable Power 2x150mm dari panel POT ke Junction Box\"', '3', NULL, '2025-01-31', NULL, '100', 66.25, 66.25, NULL, '2025-04-18 22:31:14', '2025-04-18 22:37:20'),
(489, '442', '208', '\"Pembuatan Cable tray dari JB Panel Pot dan di Body GL POT\"', '3', NULL, '2025-02-28', NULL, '100', 66.25, 66.25, NULL, '2025-04-18 22:32:49', '2025-04-18 22:37:20'),
(490, '442', '208', '\"Install Cable Veyor\"', '3', NULL, '2025-02-28', NULL, '80', 66.25, 66.25, NULL, '2025-04-18 22:33:42', '2025-04-18 22:37:20'),
(491, '442', '208', '\"Pulling Cable Power 1x300mm dari JB panel POT ke Masing-masing inductor\"', '3', NULL, '2025-06-30', NULL, '50', 66.25, 66.25, NULL, '2025-04-18 22:34:29', '2025-04-18 22:37:20'),
(492, '442', '208', '\"Modifikasi busbar Panel POT untuk Penambahan Kabel\"', '3', NULL, '2025-02-28', NULL, '100', 66.25, 66.25, NULL, '2025-04-18 22:35:37', '2025-04-18 22:37:20'),
(493, '442', '208', '\"Connect Kabel Power 2x150mm (new) di panel GL POT\"', '3', NULL, '2025-06-30', NULL, '0', 66.25, 66.25, NULL, '2025-04-18 22:36:33', '2025-04-18 22:37:20'),
(494, '442', '208', '\"Connect Kabel Power 1x300mm (new) di Inductor GL POT\"', '3', NULL, '2025-06-30', NULL, '0', 66.25, 66.25, NULL, '2025-04-18 22:37:12', '2025-04-18 22:37:20'),
(495, '443', '209', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-04-20 00:36:32', '2025-04-20 00:36:32'),
(496, '444', '209', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-04-20 00:36:32', '2025-04-20 00:36:32'),
(497, '445', '209', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-04-20 00:36:32', '2025-04-20 00:36:32'),
(498, '446', '209', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-04-20 00:36:32', '2025-04-20 00:36:32'),
(499, '447', '210', '\"Trial mesin Markem Imaje 9450\"', '3', NULL, '2025-05-31', NULL, '0', 0.00, 0.00, 'ON PROGRES', '2025-04-20 00:48:46', '2025-04-20 00:55:55'),
(500, '447', '210', '\"Pembelian Mesin Markem Imaje 9450\"', '25', NULL, '2025-05-31', NULL, '0', 0.00, 0.00, NULL, '2025-04-20 00:54:59', '2025-04-20 00:55:55'),
(501, '447', '210', '\"Instalasi Mesin Markem Imaje 9450 2 unit di Line CGL\"', '3', NULL, '2025-07-31', NULL, '0', 0.00, 0.00, NULL, '2025-04-20 00:55:48', '2025-04-20 00:55:55'),
(502, '333', '151', '\"Building Inductor Pemasangan TC Ceraloop dan Coil Inductor\"', '4', NULL, '2025-07-31', NULL, '0', 2.50, 26.67, NULL, '2025-04-20 01:03:24', '2025-05-08 00:23:08'),
(504, '333', '151', '\"Prepare Air Heater untuk Pemanas Ceraloop PM POT\"', '83', 'RQ', '2025-05-22', NULL, '10', 2.50, 26.67, 'ON PROGRES', '2025-04-20 01:06:10', '2025-05-08 00:23:08'),
(505, '333', '151', '\"Heating Up and Charging PM POT\"', '4', NULL, '2025-07-31', NULL, '0', 2.50, 26.67, NULL, '2025-04-20 01:07:18', '2025-05-08 00:23:08'),
(506, '448', '211', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-04-20 02:13:25', '2025-04-20 02:13:25'),
(507, '449', '211', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-04-20 02:13:25', '2025-04-20 02:13:25'),
(508, '450', '211', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-04-20 02:13:25', '2025-04-20 02:13:25'),
(509, '451', '211', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-04-20 02:13:25', '2025-06-22 21:32:13'),
(510, '452', '211', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-04-20 02:13:25', '2025-04-20 02:13:25'),
(511, '453', '212', '\"Pembelian Motor 1LE0001\\u20102CC23\\u20103AG4\\u2010z F70+G04+N10+ X08 (37kW) Hot bridle #1\"', '3', 'motor sudah datang', '2025-04-30', NULL, '100', 16.67, 15.39, 'ON PROGRES', '2025-04-20 02:35:59', '2025-05-12 02:18:03'),
(512, '454', '212', NULL, NULL, NULL, NULL, NULL, '0', NULL, 16.67, 'ON PROGRES', '2025-04-20 02:35:59', '2025-05-12 02:17:27'),
(513, '455', '213', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-04-20 02:40:41', '2025-04-20 02:40:41'),
(517, '459', '217', '\"menjaga ketebalan resin 1- 1,5 mikron untuk menambah daya tahan terhadap kelembaban\"', '23', NULL, '2025-05-06', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-06 02:06:27', '2025-05-06 02:07:11'),
(518, '460', '218', '\"Install automatic fire system\"', '59', NULL, '2024-01-16', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-06 05:38:12', '2025-05-09 01:56:23'),
(519, '461', '218', '\"Penyiapan hydrant\"', '59', NULL, '2024-01-15', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-06 05:42:13', '2025-05-09 01:56:23'),
(520, '462', '218', '\"Training operator sebagai fire rescue\"', '60', NULL, '2024-07-22', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-06 05:42:13', '2025-05-09 01:56:23'),
(521, '463', '219', '\"Training on class (modul training)\"', '30', NULL, '2024-11-25', NULL, '100', 100.00, 93.33, 'CLOSE', '2025-05-06 19:38:00', '2025-05-09 02:00:31'),
(522, '464', '219', '\"Keterlibatan operator dalam pembuatan procedure\"', '85', NULL, '2025-02-17', NULL, '80', 80.00, 93.33, 'ON PROGRES', '2025-05-06 19:38:00', '2025-05-09 02:00:31'),
(523, '465', '219', '\"Operator dilibatkan dalam comissioning line\"', '30', NULL, '2024-01-22', NULL, '100', 100.00, 93.33, 'CLOSE', '2025-05-06 19:38:00', '2025-05-09 02:00:31'),
(524, '466', '220', '\"Training terkait defect Galvalume CCL feed\"', '30', NULL, '2023-11-20', NULL, '100', 100.00, 82.50, 'CLOSE', '2025-05-06 21:28:13', '2025-05-09 02:35:54'),
(525, '467', '220', '\"Membuat additional requirement technical spesifikasi bahan baku yang akan digunakan\"', '58', NULL, '2024-11-18', NULL, '100', 100.00, 82.50, 'CLOSE', '2025-05-06 21:28:13', '2025-05-09 02:35:54'),
(526, '468', '220', '\"Monitoring qualitas feed mulai dari unpacking hingga ke line\"', '26', NULL, '2024-11-25', NULL, '80', 80.00, 82.50, 'ON PROGRES', '2025-05-06 21:28:13', '2025-05-09 02:35:54'),
(527, '469', '220', '\"Penggunaan alat ukur yang sesuai, layak dan siap digunakan\"', '58', NULL, '2024-10-21', NULL, '50', 50.00, 82.50, 'ON PROGRES', '2025-05-06 21:28:13', '2025-05-09 02:35:54'),
(528, '470', '221', '\"Training terkait defect Galvalume CCL feed\"', '58', NULL, '2024-11-25', NULL, '85', 85.00, 86.25, 'ON PROGRES', '2025-05-07 00:06:47', '2025-05-09 02:38:44'),
(529, '471', '221', '\"Membuat additional requirement technical spesifikasi bahan baku yang akan digunakan\"', '58', NULL, '2024-10-28', NULL, '75', 75.00, 86.25, 'ON PROGRES', '2025-05-07 00:06:47', '2025-05-09 02:38:44'),
(530, '472', '221', '\"Monitoring qualitas feed mulai dari unpacking hingga ke line\"', '30', NULL, '2024-10-21', NULL, '100', 100.00, 86.25, 'CLOSE', '2025-05-07 00:06:47', '2025-05-09 02:38:44'),
(531, '473', '221', '\"Penggunaan alat ukur yang sesuai, layak dan siap digunakan\"', '58', NULL, '2024-11-26', NULL, '85', 85.00, 86.25, 'ON PROGRES', '2025-05-07 00:06:47', '2025-05-09 02:38:44'),
(532, '474', '222', '\"Penyiapan training modul\"', '30', NULL, '2024-11-19', NULL, '100', 100.00, 79.38, 'CLOSE', '2025-05-07 00:14:37', '2025-05-09 02:52:19'),
(533, '475', '222', '\"On Job training di pabrik yang similar\"', '30', NULL, '2024-07-29', NULL, '85', 85.00, 79.38, 'ON PROGRES', '2025-05-07 00:14:37', '2025-05-09 02:52:19'),
(534, '476', '222', '\"Training on class\"', '30', NULL, '2024-11-21', NULL, '100', 100.00, 79.38, 'CLOSE', '2025-05-07 00:14:37', '2025-05-09 02:52:19'),
(535, '477', '222', '\"Operator terlibat dalam commisioning\"', '30', NULL, '2024-09-24', NULL, '100', 100.00, 79.38, 'CLOSE', '2025-05-07 00:14:37', '2025-05-09 02:52:19'),
(536, '478', '222', '\"Operator terlibat dalam pembuatan procedure\"', '30', NULL, '2024-10-28', NULL, '85', 85.00, 79.38, 'ON PROGRES', '2025-05-07 00:14:37', '2025-05-09 02:52:19'),
(537, '479', '222', '\"Pembuatan Quizizz\"', '33', NULL, '2024-11-26', NULL, '50', 50.00, 79.38, 'ON PROGRES', '2025-05-07 00:14:37', '2025-05-09 02:52:19'),
(538, '480', '222', '\"Rekruit operator yang sudah berpengalaman\"', '30', NULL, '2024-10-25', NULL, '65', 65.00, 79.38, 'ON PROGRES', '2025-05-07 00:14:37', '2025-05-09 02:52:19'),
(539, '481', '222', '\"Create prosedur secara detail\"', '85', NULL, '2025-03-25', NULL, '50', 50.00, 79.38, 'ON PROGRES', '2025-05-07 00:14:37', '2025-05-09 02:52:19'),
(540, '482', '223', '\"Membuat alternative supplier Galvalume\"', '47', NULL, '2024-10-17', NULL, '70', 70.00, 70.00, 'ON PROGRES', '2025-05-07 03:07:52', '2025-05-11 23:56:35'),
(541, '483', '224', '\"Pembuatan sistem reporting konsumsi cat\"', '47', NULL, '2024-08-22', NULL, '85', 85.00, 80.00, 'ON PROGRES', '2025-05-07 03:10:07', '2025-05-11 23:57:41'),
(542, '484', '224', '\"Membuat BOM menjadi lebih akurat\"', '46', NULL, '2024-07-23', NULL, '75', 75.00, 80.00, 'ON PROGRES', '2025-05-07 03:10:07', '2025-05-11 23:57:41'),
(543, '485', '225', '\"Membuat system preventive maintenance\"', '59', NULL, '2025-02-17', NULL, '75', 75.00, 75.00, 'ON PROGRES', '2025-05-07 03:21:04', '2025-05-11 23:58:59'),
(544, '486', '225', '\"Penyiapan critical spare part\"', '59', NULL, '2024-11-18', NULL, '75', 75.00, 75.00, 'ON PROGRES', '2025-05-07 03:21:04', '2025-05-11 23:58:59'),
(545, '487', '226', '\"Pengecekan viscocity secara regular\"', '26', NULL, '2024-12-27', NULL, '85', 85.00, 80.00, 'ON PROGRES', '2025-05-07 19:38:07', '2025-05-12 00:00:18'),
(546, '488', '226', '\"Penggunaan cat ready for used\"', '26', NULL, '2024-12-17', NULL, '75', 75.00, 80.00, 'ON PROGRES', '2025-05-07 19:38:07', '2025-05-12 00:00:18'),
(547, '489', '227', '\"Schedulle menggunakan L3\"', '46', NULL, '2024-06-17', NULL, '100', 100.00, 80.83, 'CLOSE', '2025-05-07 19:45:20', '2025-05-12 00:03:03'),
(548, '490', '227', '\"IK document menggunakan PDCA platform\"', '33', NULL, '2024-10-23', NULL, '85', 85.00, 80.83, 'ON PROGRES', '2025-05-07 19:45:20', '2025-05-12 00:03:03'),
(549, '491', '227', '\"Approval Berita acara, IC, PI via MOXO\"', '33', NULL, '2024-12-30', NULL, '100', 100.00, 80.83, 'CLOSE', '2025-05-07 19:45:20', '2025-05-12 00:03:03'),
(550, '492', '227', NULL, NULL, NULL, NULL, NULL, '0', NULL, 80.83, 'ON PROGRES', '2025-05-07 19:45:20', '2025-05-12 00:03:03'),
(551, '493', '227', '\"Production report menggunakan system L3\"', '33', NULL, '2024-12-27', NULL, '100', 100.00, 80.83, 'CLOSE', '2025-05-07 19:45:20', '2025-05-12 00:03:03'),
(552, '494', '227', '\"Test report menggunakan system L3\"', '33', NULL, '2025-01-20', NULL, '100', 100.00, 80.83, 'CLOSE', '2025-05-07 19:45:20', '2025-05-12 00:03:03'),
(553, '495', '228', '\"Optimalisasi by pass RTO\"', '32', NULL, '2024-11-25', NULL, '75', 75.00, 75.00, 'ON PROGRES', '2025-05-07 19:56:28', '2025-05-12 00:05:17'),
(554, '496', '228', '\"Optimalisasi schedulle produksi secara continue\"', '32', NULL, '2024-09-24', NULL, '75', 75.00, 75.00, 'ON PROGRES', '2025-05-07 19:56:28', '2025-05-12 00:05:17'),
(555, '497', '229', '\"Pemilihan equipment melalui decision analysis\"', '30', NULL, '2024-11-18', NULL, '75', 75.00, 75.00, 'ON PROGRES', '2025-05-07 20:00:15', '2025-05-12 00:08:39'),
(556, '498', '230', '\"Monitoring saat heating up\"', '32', NULL, '2024-10-21', NULL, '75', 75.00, 75.00, 'ON PROGRES', '2025-05-07 20:05:46', '2025-05-12 00:07:39'),
(557, '499', '230', '\"Replace other brand\"', '5', NULL, '2024-10-23', NULL, '75', 75.00, 75.00, 'ON PROGRES', '2025-05-07 20:05:46', '2025-05-12 00:07:39'),
(558, '500', '230', '\"Reposisi thermocouple\"', '5', NULL, '2024-11-25', NULL, '75', 75.00, 75.00, 'ON PROGRES', '2025-05-07 20:05:46', '2025-05-12 00:07:39'),
(559, '501', '230', '\"Uncheck reference temperature selection di HMI\"', '32', NULL, '2024-08-27', NULL, '75', 75.00, 75.00, 'ON PROGRES', '2025-05-07 20:05:46', '2025-05-12 00:07:39'),
(560, '502', '231', '\"Cleaning EPC sensor\"', '5', NULL, '2024-08-27', NULL, '75', 75.00, 75.00, 'ON PROGRES', '2025-05-07 20:18:26', '2025-05-12 00:10:01'),
(561, '503', '231', '\"Cleaning camera EPC\"', '5', NULL, '2024-08-22', NULL, '75', 75.00, 75.00, 'ON PROGRES', '2025-05-07 20:18:26', '2025-05-12 00:10:01'),
(562, '504', '231', '\"Penambahan PM schedulle EPC (lampu)\"', '5', NULL, '2024-08-22', NULL, '75', 75.00, 75.00, 'ON PROGRES', '2025-05-07 20:18:26', '2025-05-12 00:10:01'),
(563, '505', '232', '\"1. APD menggunakan sarung tangan chemical , ear muff, safety glass, apron\"', '10', NULL, '2020-01-27', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-07 20:24:18', '2025-05-07 20:37:50'),
(564, '506', '233', '\"Monitoring paint feed di entry section\"', '26', NULL, '2024-10-21', NULL, '80', 80.00, 90.00, 'ON PROGRES', '2025-05-07 20:44:22', '2025-05-12 00:13:34'),
(565, '507', '233', '\"Create technical protocol dengan supplier\"', '58', NULL, '2024-12-23', NULL, '80', 80.00, 90.00, 'ON PROGRES', '2025-05-07 20:44:22', '2025-05-12 00:13:34'),
(566, '508', '233', '\"Cancel schedulle\"', '26', NULL, '2024-08-30', NULL, '100', 100.00, 90.00, 'CLOSE', '2025-05-07 20:44:22', '2025-05-12 00:13:34'),
(567, '509', '233', '\"Alokasikan untuk warna tertentu\"', '46', NULL, '2024-11-27', NULL, '100', 100.00, 90.00, 'CLOSE', '2025-05-07 20:44:22', '2025-05-12 00:13:34'),
(568, '510', '234', '\"1. APD sarung tangan , Chemical suit, masker, 2. Wind direction 3. Gas Detector 4. Unloading dilakukan saat ada manpower terlatih 5. unloading dilakukan disaat Produksi sedang berjalan\"', '10', NULL, '2025-01-27', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-07 20:50:19', '2025-05-07 20:51:30'),
(569, '511', '235', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-05-07 20:53:56', '2025-05-07 20:53:56'),
(570, '512', '235', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-05-07 20:53:56', '2025-05-07 20:53:56'),
(571, '513', '235', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-05-07 20:53:56', '2025-05-07 20:53:56'),
(572, '514', '235', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-05-07 20:53:56', '2025-05-07 20:53:56'),
(573, '515', '236', '\"Monitoring paint feed di entry section\"', '26', NULL, '2024-08-29', NULL, '85', 85.00, 91.25, 'ON PROGRES', '2025-05-07 20:58:55', '2025-05-12 00:15:34'),
(574, '516', '236', '\"Create technical protocol dengan supplier\"', '58', NULL, '2024-11-20', NULL, '80', 80.00, 91.25, 'ON PROGRES', '2025-05-07 20:58:55', '2025-05-12 00:15:34'),
(575, '517', '236', '\"Cancel schedulle\"', '26', NULL, '2024-11-20', NULL, '100', 100.00, 91.25, 'CLOSE', '2025-05-07 20:58:55', '2025-05-12 00:15:34'),
(576, '518', '236', '\"Alokasikan untuk warna tertentu\"', '46', NULL, '2024-11-19', NULL, '100', 100.00, 91.25, 'CLOSE', '2025-05-07 20:58:55', '2025-05-12 00:15:34'),
(577, '519', '237', '\"Trial minimum dan maximum set point\"', '26', NULL, '2024-10-30', NULL, '80', 80.00, 76.00, 'ON PROGRES', '2025-05-07 21:03:37', '2025-05-12 00:18:02'),
(578, '520', '237', '\"Catenary height Prime oven set 890mm\"', '6', NULL, '2024-10-23', NULL, '75', 75.00, 76.00, 'ON PROGRES', '2025-05-07 21:03:37', '2025-05-12 00:18:02'),
(579, '521', '237', '\"Catenary height Finish oven set 1185mm\"', '6', NULL, '2024-08-28', NULL, '75', 75.00, 76.00, 'ON PROGRES', '2025-05-07 21:03:37', '2025-05-12 00:18:02'),
(580, '522', '237', '\"Sensor di cover untuk menghindari terhalang oleh binatang atau kotoran\"', '6', NULL, '2025-05-27', NULL, '75', 75.00, 76.00, 'ON PROGRES', '2025-05-07 21:03:37', '2025-05-12 00:18:02'),
(581, '523', '237', '\"Setting IO PLC\"', '6', NULL, '2024-11-26', NULL, '75', 75.00, 76.00, 'ON PROGRES', '2025-05-07 21:03:37', '2025-05-12 00:18:02'),
(582, '524', '238', '\"Create guidance SP size vs line speed\"', '32', NULL, '2025-01-21', NULL, '75', 75.00, 61.67, 'ON PROGRES', '2025-05-07 21:09:02', '2025-05-12 00:20:47'),
(583, '525', '238', '\"Set oven otomatis by L3\"', '5', NULL, '2024-10-22', NULL, '50', 50.00, 61.67, 'ON PROGRES', '2025-05-07 21:09:02', '2025-05-12 00:20:47'),
(584, '526', '238', '\"Coater tidak bisa apply jika deviasi antara SP vs PV >30C\"', '5', NULL, '2024-12-27', NULL, '50', 50.00, 61.67, 'ON PROGRES', '2025-05-07 21:09:02', '2025-05-12 00:20:47'),
(585, '527', '238', '\"RC Fan fail maka coater disengage\"', '5', NULL, '2025-02-10', NULL, '50', 50.00, 61.67, 'ON PROGRES', '2025-05-07 21:09:02', '2025-05-12 00:20:47'),
(586, '528', '238', '\"Pengecekan thermax paper\"', '58', NULL, '2024-11-26', NULL, '100', 100.00, 61.67, 'CLOSE', '2025-05-07 21:09:02', '2025-05-12 00:20:47'),
(587, '529', '238', '\"Pengukuran menggunakan pyrometer\"', '5', NULL, '2024-11-15', NULL, '45', 45.00, 61.67, 'ON PROGRES', '2025-05-07 21:09:02', '2025-05-12 00:20:47'),
(588, '530', '239', '\"1. Mempersiapka APAR dan Hydrant 2. Spanduk peringatan agar tidak menyalakan api di sekitar area Tangki solar 3. Pemberian tembok dan pintu agar hanya petugas yang berwenang saja yang boleh masuk\"', '10', NULL, '2023-03-13', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-07 23:12:55', '2025-05-08 00:05:17'),
(589, '197', '90', '\"Connect cable grounding\"', '3', 'Belum dapat ijin dari WH', '2025-04-01', NULL, '0', 50.00, 50.00, 'ON PROGRES', '2025-05-07 23:44:11', '2025-05-08 19:37:14'),
(590, '531', '240', '\"Metode Pengisian menggunakan perhitungan untuk pengisian maximal 80% (16 m3)\"', '11', NULL, '2019-12-02', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-08 00:04:05', '2025-05-08 00:05:00'),
(591, '532', '241', '\"1. Equipment Electric di beri tagging , bukti bahwa equipment sudah di cek oleh electric , tagging akan di perbarui setiap 3 bulan sekali 2. Seluruh Panel di area utility akan di beri grounding di standart kan agar safe 3. Training basic electrical\"', '10', NULL, '2024-05-13', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-08 00:11:23', '2025-05-08 00:11:55'),
(592, '533', '41', '\"Improve WWTP\"', '59', NULL, '2025-03-31', NULL, '50', 50.00, 87.50, 'ON PROGRES', '2025-05-08 00:21:35', '2025-05-08 20:42:23'),
(593, '534', '41', '\"Pengecekan emisi lingkungan setiap 12 bulan\"', '60', NULL, '2024-12-31', NULL, '100', 100.00, 87.50, 'CLOSE', '2025-05-08 00:21:35', '2025-05-08 20:42:23'),
(594, '535', '41', '\"pengembalian drum kosong ke supplier\"', '47', NULL, '2024-03-04', NULL, '100', 100.00, 87.50, 'CLOSE', '2025-05-08 00:21:35', '2025-05-08 20:42:23'),
(595, '536', '242', '\"1. Menggunakan PAM di pabrik L8 , L1 , L10 dan L3\"', '11', NULL, '2021-05-03', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-08 00:40:24', '2025-05-08 00:41:26'),
(596, '537', '243', '\"Penggunaan VCI Paper dan pallet ex packing Sunsco\"', '48', NULL, '2025-01-31', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-05-09 19:34:11', '2025-05-09 22:34:11'),
(597, '170', '78', '\"Update \\/ Scan coil sesuai actual warehouse\\/storage\"', '48', NULL, '2025-05-31', NULL, '50', 75.00, 75.00, 'ON PROGRES', '2025-05-09 22:31:49', '2025-05-09 22:32:07'),
(598, '453', '212', '\"Pembelian Motor 1TL0003-2DB23-3AA4 (90kW)\"', '3', 'motor sudah datang', '2025-04-30', NULL, '100', 16.67, 15.39, NULL, '2025-05-12 01:59:50', '2025-05-12 02:18:03'),
(599, '453', '212', '\"Pembelian motor Main nozzle shift (0,12kW)\"', '3', NULL, '2025-06-30', NULL, '0', 16.67, 15.39, NULL, '2025-05-12 02:02:09', '2025-05-12 02:18:03'),
(600, '453', '212', '\"Pembelian motor No.1 & 2 pay Off Reel LUB pump motor (2,2kW)\"', '3', NULL, '2025-06-30', NULL, '0', 16.67, 15.39, 'ON PROGRES', '2025-05-12 02:03:47', '2025-05-12 02:18:03'),
(601, '453', '212', '\"Pembelian Motor Main nozzle lift (WS) (5,5kW)\"', '3', NULL, '2025-06-30', NULL, '0', 16.67, 15.39, NULL, '2025-05-12 02:05:07', '2025-05-12 02:18:03'),
(602, '453', '212', '\"Pembelian Motor CPC Unit hydraulic motor for No.1-3 Steering roll (5,5kW)\"', '3', NULL, '2025-07-31', NULL, '0', 16.67, 15.39, 'ON PROGRES', '2025-05-12 02:06:06', '2025-05-12 02:18:03'),
(603, '453', '212', '\"Pembelian Motor CPC Unit hydraulic motor for No.5 Steering roll (3kW)\"', '3', NULL, '2025-07-31', NULL, '0', 16.67, 15.39, NULL, '2025-05-12 02:08:18', '2025-05-12 02:18:03'),
(604, '453', '212', '\"Pembelian Motor Air Knife 1# & 2# Blower (132kW)\"', '3', NULL, '2025-09-30', NULL, '0', 16.67, 15.39, NULL, '2025-05-12 02:10:22', '2025-05-12 02:18:03'),
(605, '453', '212', '\"Pembelian Motor Winch Drum Entry\\/Exit, POR #1 #2 (75kW)\"', '3', NULL, '2025-10-31', NULL, '0', 16.67, 15.39, NULL, '2025-05-12 02:12:32', '2025-05-12 02:18:03'),
(606, '453', '212', '\"Pembelian Motor Entry\\/Exit hydarulic system No.1,2,3main pump motor (55kW)\"', '3', NULL, '2025-10-31', NULL, '0', 16.67, 15.39, NULL, '2025-05-12 02:14:03', '2025-05-12 02:18:03'),
(607, '453', '212', '\"Pembelian Motor No.2 Bridle roll 1 # rool (22kW)\"', '3', NULL, '2025-11-30', NULL, '0', 16.67, 15.39, NULL, '2025-05-12 02:15:32', '2025-05-12 02:18:03'),
(608, '453', '212', '\"pembelian motor bottom roll gear motor 2# Exit (15kW)\"', '3', NULL, '2025-11-30', NULL, '0', 16.67, 15.39, NULL, '2025-05-12 02:18:03', '2025-05-12 02:18:03'),
(609, '538', '244', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-05-12 19:18:53', '2025-05-12 19:18:53'),
(610, '539', '245', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-05-12 20:23:14', '2025-05-12 20:23:14'),
(611, '540', '61', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-05-12 22:04:09', '2025-05-12 22:04:09'),
(612, '541', '246', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-05-14 21:30:56', '2025-05-14 21:30:56'),
(613, '542', '247', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-05-14 22:20:22', '2025-05-14 22:20:22'),
(614, '543', '248', '\"Lakukan pengecekan kualitas lebih ketat saat barang datang, terutama saat musim ekstrem\"', '13', NULL, '2025-05-28', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-27 19:58:10', '2025-05-27 20:07:10'),
(615, '544', '248', '\"Buat Standar Penyimpanan Barang\"', '82', NULL, '2025-05-30', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-27 19:58:10', '2025-05-27 20:07:10'),
(616, '545', '248', '\"Audit atau visit ke supplier untuk memastikan kesiapan mereka menghadapi dampak cuaca\"', '13', NULL, '2025-05-28', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-27 19:58:10', '2025-05-27 20:07:10'),
(617, '546', '248', '\"Jika perlu, ganti supplier yang tidak punya sistem handling yang memadai\"', '13', NULL, '2025-05-28', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-27 19:58:10', '2025-05-27 20:07:15'),
(618, '547', '249', '\"Membuat Email untuk mengingatkan penginputan budgeting ke all departemen\"', '97', NULL, '2025-05-27', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-27 19:58:21', '2025-05-27 21:50:32'),
(619, '544', '248', '\"Melakukan Review Dokumen Standart\"', '13', NULL, '2025-06-05', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-27 20:00:36', '2025-05-27 20:07:10'),
(620, '544', '248', '\"Agenda Komunikasi ke Supplier\"', '13', NULL, '2025-06-06', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-27 20:01:06', '2025-05-27 20:07:10'),
(625, '550', '251', '\"Monthly Meeting dengan Customer & Vendor \\\\untuk menentukan kebutuhan M+1 dan prioritas kebutuhan dari Customer\"', '12', NULL, '2025-05-28', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-05-27 20:35:51', '2025-05-27 21:16:45'),
(626, '551', '251', '\"Membuat Buffer Stock untuk bahan baku CRC\"', '12', NULL, '2025-05-28', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-05-27 20:35:51', '2025-05-27 21:16:54'),
(627, '552', '252', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-05-27 20:47:31', '2025-05-27 20:47:31'),
(632, '555', '254', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-05-27 21:06:40', '2025-05-27 21:06:40'),
(633, '556', '255', '\"Membuat Kebijakan Evaluasi Supplier\"', '82', 'Kebijakan sudah dibuat sesuai MSP.PR.01 & Form FM.PR.03', '2025-05-28', NULL, '100', 100.00, 66.67, 'CLOSE', '2025-05-27 21:13:18', '2025-05-27 21:57:07'),
(634, '557', '255', NULL, NULL, NULL, NULL, NULL, '0', NULL, 66.67, 'ON PROGRES', '2025-05-27 21:13:18', '2025-05-27 21:56:53'),
(635, '558', '256', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-05-27 21:15:03', '2025-05-27 21:15:03'),
(636, '559', '256', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-05-27 21:15:03', '2025-05-27 21:15:03'),
(637, '560', '257', '\"Pembuatan rencana produks sesuai penGAJUAN STADARD PRODUCT\"', '12', NULL, '2020-05-30', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-27 21:24:29', '2025-05-27 21:32:19'),
(638, '560', '257', '\"Pengambilan Sample untuk Standard product\"', '35', NULL, '2020-05-30', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-27 21:27:53', '2025-05-27 21:32:19'),
(639, '560', '257', '\"Pengajuan Standard Product\"', '92', NULL, '2022-06-12', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-27 21:31:27', '2025-05-27 21:32:19'),
(640, '556', '255', '\"Melakukan Sosialisai Kebijakan Evaluasi Supplier kepada user\"', '82', 'Review MSP.PR.01 & FM.PR.03', '2025-06-05', NULL, '100', 100.00, 66.67, 'CLOSE', '2025-05-27 21:36:35', '2025-05-27 21:57:07'),
(641, '547', '249', '\"mereview inputan budgeting dari all departemen\"', '97', NULL, '2025-05-31', NULL, '100', 100.00, 100.00, 'CLOSE', '2025-05-27 21:49:43', '2025-05-27 21:50:32'),
(643, '222', '104', '\"Membuat digitalisasi\"', '36', 'Develop aplikasi', '2025-07-01', NULL, '50', 75.00, 75.00, 'ON PROGRES', '2025-06-01 19:43:24', '2025-06-01 19:43:29'),
(644, '223', '105', '\"Melemburkan tester shift berikutnya\"', '35', 'Jika pekerjaan di laboratorium overload', '2025-12-31', NULL, '50', 75.00, 75.00, 'ON PROGRES', '2025-06-01 19:45:04', '2025-06-01 19:45:11'),
(645, '51', '25', '\"Melemburkan tester shift berikutnya\"', '35', 'Jika pekerjaan di laboratorium overload', '2025-12-31', NULL, '50', 62.50, 62.50, 'ON PROGRES', '2025-06-01 19:46:44', '2025-06-01 19:46:48'),
(646, '210', '94', '\"Buat guide line terkait penentuan status produk\"', '35', 'supaya tidak ada intervensi terkait penentuan status produk dari hasil pengujian laboratorium', '2025-12-31', NULL, '50', 75.00, 83.33, 'ON PROGRES', '2025-06-01 19:48:30', '2025-06-01 19:48:33'),
(647, '211', '95', '\"Personel eksternal (seperti auditor, tamu, subkon) menandatangani perjanjian kerahasiaan\"', '55', 'setiap personel eksternal', '2025-12-31', NULL, '100', 100.00, 100.00, 'ON PROGRES', '2025-06-01 19:54:40', '2025-06-01 19:54:44'),
(648, '212', '96', '\"Dibuatkan digitalisasi kaji ulang permintaan\"', '36', 'sedang didevelop', '2025-12-31', NULL, '50', 75.00, 75.00, 'ON PROGRES', '2025-06-01 19:56:16', '2025-06-01 19:56:21'),
(652, '565', '261', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-09-04 01:49:33', '2025-09-04 01:49:33'),
(653, '566', '262', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-09-05 18:18:52', '2025-09-05 18:18:52'),
(654, '567', '263', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, 'ON PROGRES', '2025-09-15 19:16:29', '2025-09-15 19:16:29');

-- --------------------------------------------------------

--
-- Table structure for table `resiko`
--

CREATE TABLE `resiko` (
  `id` bigint UNSIGNED NOT NULL,
  `id_riskregister` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_resiko` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kriteria` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `probability` int UNSIGNED DEFAULT NULL,
  `severity` int UNSIGNED DEFAULT NULL,
  `tingkatan` enum('LOW','MEDIUM','HIGH','EXTREME') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('OPEN','ON PROGRES','CLOSE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `risk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `probabilityrisk` int UNSIGNED DEFAULT NULL,
  `severityrisk` int UNSIGNED DEFAULT NULL,
  `target` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `before` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `after` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resiko`
--

INSERT INTO `resiko` (`id`, `id_riskregister`, `nama_resiko`, `kriteria`, `probability`, `severity`, `tingkatan`, `status`, `risk`, `probabilityrisk`, `severityrisk`, `target`, `before`, `after`, `created_at`, `updated_at`) VALUES
(3, '3', 'pembangunan terhambat', 'Financial', 4, 4, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, 'Belum ada timeline', NULL, '2024-11-01 00:42:40', '2024-11-10 20:19:43'),
(8, '8', '1. Menyebabkan banyak pekerja yang keracunan amoniak\r\n2. Dampak lingkungan yang besar, mencemari lingkungan sekitar', 'Enviromental (lingkungan)', 1, 5, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, 'Belum ada sistem ERP kebocoran amoniak', NULL, '2024-11-01 21:03:00', '2024-11-08 10:17:25'),
(9, '9', '1. Antrian unloading berpotensi mengular \r\n2. Ditegur pihak Lippo terkait antrian Trailer yang sangat panjang, mengganggu lalu lintas kawasan', 'Operational', 4, 2, 'HIGH', 'CLOSE', 'LOW', 2, 1, NULL, 'Sebelumnya sering terjadi', NULL, '2024-11-01 21:49:42', '2025-03-07 00:18:31'),
(10, '10', 'jalur launder yang membeku mengurangi\r\nkapasitasnya sehingga ada potensi metal\r\ncair luber/penetrasi', 'Kinerja', 4, 2, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, '-', NULL, '2024-11-01 22:01:50', '2024-11-01 22:06:57'),
(19, '19', 'Produk tidak sesuai dengan spesifikasi yang dipersyaratkan', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Belum diketahui kualitas CRC dari supplier baru', 'Kualitas dari beberapa supplier CRC dapat diketahui', '2024-11-03 21:15:44', '2024-11-10 19:29:05'),
(20, '20', '1. Dihasilkan non prime pada produk\r\n2. Customer komplain akibat tidak sesuai harapan', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Tidak ada technical aggrement saat tooling sehingga dapat menyebabkan non prime', 'Tersedianya technical aggrement saat running', '2024-11-03 21:20:33', '2024-11-10 19:31:01'),
(21, '21', 'hasil produksi tidak sesuai spesifikasi di technical agreement produk', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Belum ada kecocokan dengan supplier terkait technical aggrement raw material', 'Dapat tooling raw material ke suppier', '2024-11-03 23:06:47', '2024-11-10 19:32:05'),
(22, '22', 'Lingkungan tercemar', 'Enviromental (lingkungan)', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Sampah masih tercampur antara B3 dengan anorganik', 'Sampah dapat dibedakan sesuai dengan jenisnya', '2024-11-03 23:08:59', '2024-11-10 19:33:04'),
(23, '23', 'Lingkungan tercemar dan berbahaya bagi operator', 'Safety & Health', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Bahan kimia yang terdapat di Laboratorium belum ada label tanda bahaya', 'MSDS tersedia sebelum bahan/material digunakan', '2024-11-03 23:12:12', '2024-11-10 19:33:57'),
(24, '24', 'Surface treatment tidak dapat dibersihkan di line CCL TML Sadang', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Adanya komplain dari TML Sadang terkait paintfeed yang tidak sesuai', 'Berkurangnya komplain dari TML Sadang', '2024-11-03 23:21:20', '2024-11-10 19:35:08'),
(25, '25', 'Mengganggu antrian pengujian', 'Kinerja', 3, 3, 'HIGH', 'ON PROGRES', 'MEDIUM', 2, 2, NULL, 'Banyaknya antrian pengujian di Laboratorium', 'Pengujian dapat ditangani', '2024-11-03 23:33:00', '2025-03-02 21:48:31'),
(26, '26', '1. Bisa meningkatkan angka LTI\r\n2. Penyelesaian investigasi report agak lama', 'Safety & Health', 1, 3, 'MEDIUM', 'CLOSE', NULL, NULL, NULL, NULL, 'Angka LTI masih ada', NULL, '2024-11-04 18:20:49', '2025-02-25 19:40:26'),
(27, '27', 'Belum kompeten untuk investigasi', 'Safety & Health', 2, 2, 'MEDIUM', 'ON PROGRES', NULL, NULL, NULL, NULL, 'Belum kompeten untuk investigasi', NULL, '2024-11-04 18:23:58', '2024-11-24 18:54:25'),
(28, '28', 'Tidak ada analisa PAK', 'Safety & Health', 3, 1, 'MEDIUM', 'CLOSE', NULL, NULL, NULL, NULL, 'Belum ada prioritas mengenau MCU', NULL, '2024-11-04 18:26:45', '2025-02-25 19:47:27'),
(29, '29', '1. Jika pengurusan terlambat maka berpotensi hambatan terhadap sertifikasi - sertifikasi seperti green label, ISO 14001 dan lain - lain \r\n2. Berpotensi pemberhentian operasi apabila ada sidak, baik pihak Lippo ataupun KLHK', 'Unsur keuangan / Kerugian', 2, 4, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, 'RKL - RPL Rinci yang berlaku belum melingkupi luasan area pabrik baru', 'RKL - RPL Rinci yang berlaku sudah melingkupi luasan area pabrik baru', '2024-11-04 18:36:33', '2025-03-11 03:02:54'),
(30, '30', 'Tidak bisa menyimpan sementara untuk limbah B3', 'Enviromental (lingkungan)', 3, 4, 'HIGH', 'ON PROGRES', 'MEDIUM', 2, 2, NULL, 'Izin TPS LB3 Expired', 'Izin TPS LB3 baru', '2024-11-04 18:40:06', '2025-03-11 02:54:17'),
(31, '31', 'Belum ada walkway, untuk memisahkan jalur pejalan kaki dan lalu lintas kendaraan', 'Safety & Health', 2, 3, 'HIGH', 'OPEN', NULL, NULL, NULL, NULL, 'Belum ada walkway, untuk memisahkan jalur pejalan kaki dan lalu lintas kendaraan', NULL, '2024-11-04 18:45:58', '2024-11-04 18:46:11'),
(32, '32', 'Chemical storage L3 yang over capacity sehingga berpotensi pengelolaan B3 yang tidak sesuai', 'Enviromental (lingkungan)', 2, 4, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, 'Chemical terlalu banyak pada line produksi', 'Chemical pada line produksi berkurang dan tersusun rapih pada chemical storage', '2024-11-04 18:49:17', '2025-03-11 02:49:20'),
(33, '33', 'Masih kekurangan tim atau individu yang berkompeten dalam mengintegrasikan sistem secara online', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 2, 1, NULL, NULL, NULL, '2024-11-04 18:57:30', '2024-11-24 18:36:00'),
(37, '37', '- Antrian bongkar menumpuk.\r\n- Mengganggu lalulintas di depan pabrik.\r\n- Terkena demurage / ongkos overnight.', 'Operational', 3, 3, 'HIGH', 'CLOSE', 'LOW', 2, 1, NULL, NULL, 'Tidak ada penumpukan proses bongkar', '2024-11-04 21:12:23', '2024-11-08 20:23:25'),
(41, '41', '1. Teguran dari masyarakat\r\n2. Sanksi dari pemerintah', 'Enviromental (lingkungan)', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 2, 1, NULL, NULL, NULL, '2024-11-04 21:44:49', '2025-05-08 20:42:15'),
(42, '42', '1. Stock disimpan diarea Barang Jadi, sehingga mengurangi kapasitas Layout Barang Jadi \r\n2. Pengambilan tidak dapat menggunakan Crane, karena Crane 30 ton tidak dapat menjangkau area Barang jadi', 'Operational', 4, 2, 'HIGH', 'CLOSE', 'LOW', 2, 1, NULL, 'Sebelumnya sering terjadi', NULL, '2024-11-04 23:16:01', '2025-03-06 23:58:17'),
(43, '43', '1. Stok disimpan diluar Layout, mengganggu aktifitas forklift dan Crane, tidak safety \r\n2. Manuver forklif terbatas, sehingga proses Handling Finish Goods lebih sulit dan beresiko coil damage terkena garpu forklif / Chook Crane\r\n3. Operator Kesulitan mencari coil karena posisi diarea transit\r\n4. Produksi terhambat, karena harus mengurangi speed supaya hasil produksi aman tersimpan di Layout\r\n5. Produk damage terkena sesama coil ketika coil yg baru selesai produksi akan dimasukkan ke Layout', 'Operational', 4, 2, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, 'Over kapasitas sering terjadi', NULL, '2024-11-04 23:40:12', '2025-03-07 00:29:48'),
(45, '45', '1. Packing coil terhambat karena forklif 10 ton harus bergantian dengan proses pengiriman ke Tatalogam, dan proses lain di L3\r\n2. Penyimpanan coil di layout L8 harus bergantian dengan forklif 10 ton\r\n3. Produck damage karena forklif tidak mampu mengangkat coil diatas 5 ton\r\n4. Property damage, forklif 5 ton dipaksa mengangkat coil diatas 5 ton', 'Operational', 4, 2, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, 'Packing coil tonase > 5 ton harus bergantian dengan forklif di L3', NULL, '2024-11-05 00:16:15', '2025-03-07 00:38:28'),
(48, '48', 'Increasing Safety Incident, Stop/Shift, High DownTime, Defected Product Quality [R]', 'Operational', 3, 3, 'HIGH', 'ON PROGRES', 'MEDIUM', 3, 1, NULL, 'Electrical equipment masin ada trend meningkat sedikit, trend machanical  flat', 'Elecrical masih perlu peningkatan kopetensi specific di kontrol dan automasi', '2024-11-05 21:35:34', '2025-05-14 23:28:22'),
(49, '49', 'Long Downtime lebih dari 2 minggu', 'Operational', 3, 2, 'HIGH', 'OPEN', NULL, NULL, NULL, NULL, 'Roll PU retak retak baru berumur kurang lebih satu tahun sejak komissioning', 're rubbering menggunakan suplier lokal dan menjaga temperatur operasi dalam spesifikasi', '2024-11-05 21:44:58', '2025-05-14 23:29:52'),
(50, '50', 'Kegagalan kinerja pemeliharaan', 'Operational', 4, 3, 'HIGH', 'ON PROGRES', 'LOW', 2, 1, NULL, 'Menggunakan system manual dibantu dengan excell untuk planning dan scheduling', 'Sudah menggunakan Computerize Mintenance Managment System Release 1.0', '2024-11-05 22:02:05', '2025-05-14 21:43:36'),
(51, '51', 'Factory Operation suspension, Corporate reputation degradation', 'Enviromental (lingkungan)', 4, 3, 'HIGH', 'ON PROGRES', 'MEDIUM', 2, 2, NULL, 'Baku mutu air buangan masih dalam spesifikasi dan bio indikator menunjukan baik', 'Penambahan proses biologi meningkatkan kwalitas air buang terutama COD dan BOD', '2024-11-06 19:58:12', '2025-05-14 23:33:44'),
(53, '53', 'Stop produksi dalam waktu lama\r\nkomplain customer, terkait Leadtime', 'Operational', 3, 2, 'HIGH', 'CLOSE', 'LOW', 1, 1, NULL, '-', '-', '2024-11-08 20:01:36', '2025-03-17 01:10:52'),
(54, '54', '- Stock disimpan diarea Barang Jadi, sehingga mengurangi kapasitas Layout Barang Jadi \r\n- Coil rusak karena space untuk manuver crane / forklift terbatas.', 'Operational', 2, 2, 'MEDIUM', 'CLOSE', 'LOW', 2, 1, NULL, 'Double Stacking Paint Feed belum dilakukan, coil yang datang langsung proses produksi', '- Space Paint Feed sudah memiliki layout sesuai status product.\r\n- Sampel double stacking dilakukan pada coil non prime sesuai GL.WHS.02', '2024-11-08 20:21:04', '2024-11-11 01:30:42'),
(55, '55', 'Tidak bisa pemenuhan Customer Export (8,5 - 10 Ton)\r\nKehilangan peluang order', 'Operational', 3, 1, 'MEDIUM', 'CLOSE', 'LOW', 1, 1, NULL, 'tidak bisa cut baby coil 8 - 10 MT', 'sudah bisa cut coil max 10 ton', '2024-11-08 20:21:05', '2025-03-07 20:52:44'),
(56, '56', 'Tidak bisa memenuhi order dengan TS > 450 Mpa', 'Kinerja', 3, 4, 'HIGH', 'CLOSE', 'LOW', 1, 1, NULL, NULL, 'Dengan menggunakan material ss400 Tensile strength yang didapat diatas 450 Mpa', '2024-11-08 20:28:43', '2025-03-07 20:50:43'),
(57, '57', 'jalur launder yang membeku mengurangi\r\nkapasitasnya sehingga ada potensi metal\r\ncair luber/penetrasi', 'Kinerja', 3, 4, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, 'terjadi pendangkalan/penyempitan jalur launder', 'jalur launder lebih bersih dan tidak ada metal block', '2024-11-08 20:35:15', '2025-03-07 20:47:32'),
(58, '58', 'mengurangi kapasitas PRD \r\nspeed blm mencapai TV', 'Kinerja', 3, 3, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-08 21:17:52', '2025-05-14 00:03:14'),
(59, '59', 'Line stop, batal proses, produk cacat, banyak scrap, terget produksi kurang', 'Operational', 2, 3, 'HIGH', 'ON PROGRES', 'MEDIUM', 2, 2, NULL, 'CRC bermasalah sehingga berpotensi hasil produksi Non Prime meningkat', 'CRC sesuai kriteria', '2024-11-08 21:38:03', '2024-11-10 19:36:17'),
(60, '60', 'Kualitas turun, complain tinggi, kepercayaan customer menurun, order turun', 'Operational', 2, 3, 'HIGH', 'ON PROGRES', 'MEDIUM', 2, 2, NULL, 'Beberapa produk yang dihasilkan masih belum sesuai standar yang diharapkan', 'Produk sesuai standar', '2024-11-08 21:41:27', '2024-11-10 19:37:14'),
(61, '61', 'Stok disimpan diluar Layout, menganggu aktifitas forklift dan Crane sehingga tdk safety \r\n\r\nManuver forklif terbatas, sehingga proses Handling Finish Goods lebih sulit \r\n\r\nOperator Kesulitan mencari coil karena posisi diarea transit\r\nProduksi terhambat, karena harus mengurangi speed supaya hasil produksi aman tersimpan di Layout\r\n\r\nProduk damage karena handling', 'Operational', 2, 2, 'MEDIUM', 'CLOSE', NULL, NULL, NULL, NULL, 'Tidak ada pengelompokan coil berdasarkan product catagory dan layout', 'Tempat slow moving dan non prime terpisah', '2024-11-09 21:19:19', '2025-05-09 22:38:53'),
(64, '64', 'Menurunkan kualitas udara lingkungan lab', 'Enviromental (lingkungan)', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Belum adanya instruksi kerja terkait handling limbah B3 di laboratorium', 'Handling limbah B3 di laboratorium ditangani dengan baik', '2024-11-10 18:50:33', '2025-02-28 18:10:05'),
(66, '66', '1. Produk jadi (paint) batal di proses 2. Menambah waktu tunggu/delay produksi sadang', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Paintfeed untuk Sadang masih belum sesuai spesifikasi', 'Paintfeed yang diproduksi sesuai technical aggrement', '2024-11-10 18:58:29', '2024-11-10 19:38:46'),
(67, '67', 'Hasil pengukuran tidak bisa dipertanggungjawabkan', 'Kinerja', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Beberapa alat ukur/uji terlewat waktu kalibrasinya', 'Alat ukur terkalibrasi', '2024-11-10 19:02:57', '2024-11-10 19:39:40'),
(68, '68', 'Peningkatan Non Prime', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Result trial produk baru berpotensi non prime', 'Trial produk baru berjalan baik', '2024-11-10 19:08:58', '2024-11-10 19:40:34'),
(69, '69', 'masing-masing standard AS, ASTM, JIS dan ISO ada perbedaan', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Banyaknya customer ekspor yang masuk dengan berbagai macam standard', 'dapat memproduksi type dengan berbagai macam', '2024-11-10 19:11:45', '2025-02-28 18:11:47'),
(70, '70', '1. Penentuan spesifikasi produk tidak sesuai 2. Tidak mengetahui standard untuk jenis produk baru', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Belum adanya penambahan pada type Galvanize product yang baru', 'Hasil produksi type Galvanize produk yang baru', '2024-11-10 19:14:56', '2025-03-03 01:37:44'),
(71, '71', 'Penentuan spesifikasi produk tidak sesuai', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Beberapa operator masih ragu menentukan status produk', 'Operator dapat menentukan status produk', '2024-11-10 19:19:15', '2025-03-03 01:38:07'),
(72, '72', 'Kualitas surface berbeda - beda, setting parameter berbeda - beda, peningkatan non prime karena parameter berubah', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Dari beberapa supplier masih belum diketahui kualitasnya', 'Tersedianya kualitas CRC dari masing-masing supplier', '2024-11-10 19:22:39', '2024-11-10 19:45:13'),
(73, '73', 'Interaksi pekerja dengan peralatan berputar', 'Safety & Health', 3, 4, 'HIGH', 'ON PROGRES', 'MEDIUM', 1, 3, NULL, 'Tidak ada guarding belt (bagian dalam) antara motor dengan gearbox', 'Pasangkan guarding', '2024-11-10 19:28:34', '2025-05-08 23:32:11'),
(74, '74', '1. Teguran dari masyarakat 2. Surat Izin Usaha dicabut', 'Safety & Health', 2, 2, 'MEDIUM', 'CLOSE', 'LOW', 2, 1, NULL, '-', '-', '2024-11-10 19:35:41', '2025-05-09 19:50:36'),
(75, '75', 'Non Prime', 'Enviromental (lingkungan)', 3, 2, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-10 19:39:01', '2025-05-08 23:37:14'),
(76, '76', '- Permintaan customer tidak bisa dipenuhi. \r\n- Coil yang tidak sesuai speck memenuhi gudang.', 'Operational', 3, 2, 'HIGH', 'CLOSE', 'LOW', 2, 1, NULL, '1. CGL Tidak mendapatkan tahu standard requirement untuk CCL.\r\n2. Tidak ada alternatif product', '1. Sudah ada standar requirement untuk spesifikasi paint feed \r\n2. Ada opsi apabila tidak masuk spesifikasi', '2024-11-10 19:47:16', '2024-11-12 14:45:44'),
(77, '77', '1. Stock tidak update antara fisik dan sistem 2. Barang yang selisih tidak segera terdeteksi, menyulitkan user apabila saat barang dibutuhkan, stock tidak tersedia', 'Operational', 3, 1, 'MEDIUM', 'CLOSE', 'LOW', 2, 1, NULL, 'Tidak ada SO Monthly', 'SO Monthly untuk coil \r\nSO Weekly & Adjustment untuk Cat & Chemical', '2024-11-10 19:52:17', '2025-03-04 15:13:33'),
(78, '78', '1. Stock tidak update antara fisik dan sistem 2. Barang yang selisih tidak segera terdeteksi, menyulitkan user apabila saat barang dibutuhkan, stock tidak tersedia', 'Operational', 3, 1, 'MEDIUM', 'ON PROGRES', 'LOW', 2, 1, NULL, 'Stock Accuracy 66%', 'Coil 100%\r\nPaint & Chemical 98%', '2024-11-10 19:55:10', '2025-05-09 02:25:35'),
(79, '83', 'SS', 'Safety & Health', 2, 2, 'MEDIUM', 'OPEN', NULL, NULL, NULL, NULL, 'SSS', NULL, '2024-11-10 20:20:35', '2024-11-10 20:20:35'),
(86, '86', 'Non Prime Product', 'Kinerja', 2, 2, 'MEDIUM', 'CLOSE', 'MEDIUM', 3, 1, NULL, NULL, NULL, '2024-11-27 21:20:19', '2025-05-08 23:43:50'),
(88, '88', '1. Kesehatan \r\n2. Proses Produksi Terhenti \r\n3. Komplain akan bau yang tidak sedap', 'Enviromental (lingkungan)', 3, 5, 'HIGH', 'ON PROGRES', 'MEDIUM', 2, 2, NULL, NULL, NULL, '2024-12-06 20:05:51', '2024-12-06 21:22:13'),
(90, '90', 'Safety tim electric kesetrum, mesin Packing dan office proyek listrik padam', 'Safety & Health', 3, 3, 'HIGH', 'ON PROGRES', 'HIGH', 3, 3, NULL, NULL, NULL, '2024-12-06 20:38:03', '2025-03-17 01:20:41'),
(91, '91', '1. Downtime meningkat\r\n2. Property damage\r\n3. kurang memahami troubleshooting\r\n4. Diameter Sleeve Expand', 'Operational', 3, 2, 'HIGH', 'ON PROGRES', 'LOW', NULL, NULL, NULL, NULL, NULL, '2024-12-06 20:43:09', '2024-12-06 21:28:17'),
(92, '92', '1. Kenaikan suhu global\r\n2. Perubahan iklim yang ekstrem', 'Enviromental (lingkungan)', 3, 5, 'HIGH', 'CLOSE', 'MEDIUM', 1, 4, NULL, NULL, NULL, '2024-12-13 18:59:49', '2025-02-25 19:49:10'),
(93, '93', '1. Kenaikan suhu global\r\n2. Perubahan iklim yang ekstrem', 'Enviromental (lingkungan)', 3, 4, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, 'Belum ada poster atau rambu-rambu', 'Sudah terdapat rambu ataupun poster', '2024-12-15 20:49:05', '2024-12-15 20:55:34'),
(94, '94', 'Adanya tekanan terhadap hasil uji produk yang tidak sesuai dengan quality plan', 'Operational', 3, 3, 'HIGH', 'ON PROGRES', 'MEDIUM', 2, 2, NULL, 'Struktur organisasi tester masih menjadi satu dengan produksi', 'Struktur organisasi sudah dipisah', '2024-12-15 21:46:51', '2025-03-02 21:53:00'),
(95, '95', '1. Ketidaksesuaian nilai uji yang diperoleh\r\n2. Ketidakpercayaan pelanggan terhadap hasil pengujian', 'Operational', 2, 4, 'HIGH', 'ON PROGRES', 'MEDIUM', 2, 2, NULL, 'Rawan terjadinya intervensi hasil pengujian yang dilakukan oleh Produksi TML', 'Personel berintegritas', '2024-12-15 21:51:53', '2025-03-02 21:53:39'),
(96, '96', 'Pelanggan tidak puas terhadap pelayanan lab', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 2, 1, NULL, 'Hasil kaji ulang tidak disampaikan ke customer', 'Hasil kaji ulang dikirimkan ke customer', '2024-12-15 21:56:33', '2025-06-01 20:01:15'),
(97, '97', 'Hasil pengujian tidak sesuai permintaan pelanggan', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 1, NULL, 'Belum adanya keterangan pada sampel yang diuji seperti apa', 'Sampel diberi identitas', '2024-12-15 22:00:41', '2025-06-01 20:01:33'),
(98, '98', 'Preparasi sampel tidak bisa dilakukan', 'Operational', 3, 3, 'HIGH', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Preparasi sampel terganggu akibat mesin rusak', 'Mesin selalu andal', '2024-12-15 23:11:07', '2025-06-01 20:02:16'),
(99, '99', '1. Kesalahan pengujian dikarenakan tidak sesuai dengan Instruksi Kerja\r\n2. Berpotensi menyebabkan risiko kecelakaan kerja pada petugas pengujian', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 2, 1, NULL, 'Terdapat perbedaan cara pengujian dari masing-masing operator', 'Pengujian dilakukan sesuai dengan IK', '2024-12-15 23:15:59', '2025-06-01 20:02:50'),
(100, '100', 'Hasil Verifikasi dan Kalibrasi Antara tidak standard akibat kalibrator yang kurang layak', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 1, NULL, 'Maintenance alat belum terjadwal', 'Maintenance terjadwal', '2024-12-15 23:20:28', '2025-06-01 20:11:20'),
(101, '101', 'Hasil pengukuran tidak bisa dipertanggungjawabkan', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 2, 1, NULL, 'Beberapa alat uji/ukur terlewat jadwal kalibrasinya', 'Alat ukur/uji selalu terkalibrasi update', '2024-12-15 23:25:02', '2025-06-01 20:26:44'),
(102, '102', '1. Hasil pengujian tidak sesuai\r\n2. Pengujian terhambat', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Maintenance peralatan tidak terdata dengan baik', 'Histori maintenance peralatan terekam dengan baik', '2024-12-15 23:29:05', '2025-06-01 20:27:12'),
(103, '103', 'Hasil pengujian pada Laporan Hasil Uji tidak sesuai', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Terdapat perbedaan di laporan hasil uji', 'Tidak ada perbedaan antara data hasil uji dengan laporan hasil uji', '2024-12-15 23:33:33', '2025-06-01 20:27:44'),
(104, '104', NULL, 'Operational', 4, 3, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, 'Masih manual saat memasukan hasil pengujian', 'Digitalisasi hasil pengujian', '2024-12-15 23:43:58', '2025-03-02 23:35:11'),
(105, '105', 'Pelanggan tidak puas terhadap pelayanan lab', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 1, NULL, 'Antrian pengujian banyak', 'Antrian pengujian bisa diatasi', '2024-12-15 23:46:11', '2025-06-01 20:53:06'),
(106, '106', '1. Kontraktor tidak mengikuti standart perusahaan\r\n2. Kontraktor tidak mengikuti standart keamanan perusahaan', 'Safety & Health', 3, 3, 'HIGH', 'CLOSE', 'HIGH', 3, 3, NULL, NULL, NULL, '2024-12-16 18:11:44', '2024-12-20 21:06:01'),
(107, '107', '1. Tertabrak kendaraan \r\n2. Kesenggol/terserempet body kendaraan', 'Safety & Health', 3, 4, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-18 00:01:55', '2024-12-20 21:19:51'),
(109, '109', '1. Karyawan baru/Tamu masuk tanpa induction\r\n2. Karyawan baru/Tamu tidak mengikuti standart keselamatan perusahaan.\r\n3. Terjadi Insident/Accident\r\n4. Tingkat kecelakaan tinggi', 'Safety & Health', 3, 3, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, 'Belum ada Sistem flow karyawan baru dan tamu terkait keselamatan', NULL, '2024-12-20 01:08:23', '2024-12-22 18:20:11'),
(110, '110', '1. Pencemaran Lingkungan\r\n2. Menyebabkan penyakit akibat kerja (PAK)', 'Enviromental (lingkungan)', 3, 4, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, 'Belum ada pemisahan tempat sampah', NULL, '2024-12-20 01:10:58', '2024-12-22 18:33:12'),
(111, '111', 'Tidak siap saat terjadi emergency, Penanganan korban terlambat, Terjadi kecelakaan kerja, Reputasi perusahaan jadi tidak baik', 'Safety & Health', 3, 3, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, 'Belum terbentuk sistem ERP', NULL, '2024-12-20 01:13:55', '2024-12-22 18:37:35'),
(112, '112', '1. Pemahaman terkait pengoperasian kurang\r\n2. Dapet Terjadi insident atau kegagalan saat pengoprasian/pengangkatan.', 'Safety & Health', 3, 3, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, 'Operator crane dan forklift  belum memperpanjang sio dan masih ada yang belum mengikuti sertifikasi ke ahlian', NULL, '2024-12-20 01:16:29', '2024-12-26 18:40:56'),
(113, '113', '1. Korban tidak cepat tertangani\r\n2. Luka Semakin parah', 'Safety & Health', 3, 3, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, 'Belum terbentuk sistem MERP', NULL, '2024-12-20 01:19:26', '2025-02-25 20:14:00'),
(114, '114', 'Performance safety 2024 menurun', 'Safety & Health', 3, 3, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, 'Performance safety tahun 2023 kurang baik', NULL, '2024-12-20 01:22:02', '2025-02-25 20:21:59'),
(115, '115', '1. Gangguan Pendengaran\r\n2. Komunikasi tidak berjalan dengan baik\r\n3. Bisa menyebabkan kecelakaan kerja', 'Safety & Health', 3, 3, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, 'Ada kebisingan di beberapa titik', NULL, '2024-12-20 01:24:32', '2025-02-25 20:26:50'),
(116, '116', '1. Penyakit akibat kerja tidak teridentifikasi \r\n2. Kesehatan karyawan terancam\r\n3. Gangguan kesehatan permanen', 'Safety & Health', 3, 2, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, 'Medical Check Up karyawan belum berjalan', NULL, '2024-12-20 01:25:59', '2025-02-25 20:35:06'),
(117, '117', '1. Kebakaran Panel dan api tidak cepat padam\r\n2. Kerusakan Panel', 'Safety & Health', 3, 3, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, 'Sistem Proteksi Kebakaran,detector heat/smoke  di panel room belum ada', NULL, '2024-12-20 01:28:28', '2025-02-27 20:43:08'),
(118, '118', '1. SKP tidak bisa di perpanjang ke Disnaker', 'Safety & Health', 1, 1, 'LOW', 'CLOSE', NULL, NULL, NULL, NULL, 'Dapat teguran dari Disnaker terkait dengan pelaporan Triwulan', NULL, '2024-12-20 01:30:29', '2025-02-27 20:54:31'),
(119, '119', '1. Menghambat orang yang akan menyelamatkan diri saat terjadi emergency\r\n2. Pintu emergency tidak sesuai standar karena ada objek yang menghalangi', 'Safety & Health', 2, 2, 'MEDIUM', 'CLOSE', NULL, NULL, NULL, NULL, 'Pintu Emergency terhalangi box Hydrant', NULL, '2024-12-20 01:33:16', '2025-02-27 20:55:39'),
(120, '120', '1. Driver tidak mengetahui potensi bahaya di area pabrik sehingga menyebabkan terjadinya kecelakaan kerja \r\n2. driver tidak mengetahui aturan perusahaan', 'Safety & Health', 3, 3, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, 'Driver tidak mendapatkan induction saat masuk ke area pabrik', NULL, '2024-12-20 01:34:38', '2025-02-27 20:59:55'),
(121, '121', '1. Proses monitoring lapangan tidak ter Report', 'Safety & Health', 2, 1, 'LOW', 'ON PROGRES', NULL, NULL, NULL, NULL, 'Belum ada evidence terkait monitoring lapangan', NULL, '2024-12-20 01:35:48', '2025-02-27 21:01:17'),
(122, '122', '1. Pengguna sepeda terserempet atau tertabrak kendaraan bermotor', 'Safety & Health', 3, 2, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, 'Belum ada jalur khusus sepeda dan area parkir sepeda', NULL, '2024-12-20 01:37:27', '2025-02-27 21:12:54'),
(123, '123', '1. Terjadi tabrakan kendaraan yang masuk dan keluar', 'Safety & Health', 3, 3, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, 'Belum ada  pengaturan dan jalur khusus keluar masuk kendaraan besar', NULL, '2024-12-20 01:39:36', '2025-02-27 23:16:38'),
(124, '124', '1. Terjadi kecelakaan kerja\r\n2. Pelanggaran aturan perusahaan', 'Safety & Health', 3, 3, 'HIGH', 'OPEN', NULL, NULL, NULL, NULL, 'Belum ada Orientasi untuk karyawan baru', NULL, '2024-12-20 01:40:54', '2024-12-20 01:40:54'),
(126, '126', 'Kolusi', 'Financial', 5, 4, 'HIGH', 'ON PROGRES', 'MEDIUM', 2, 2, NULL, 'Skema : Adanya titipan kontraktor dari pihak-pihak yang dianggap pemangku kepentingan', 'Pelaksanaan lelang yang dilaksanakan oleh konsultan independen atau sesuai SOP seleksi lelang proyek', '2025-02-04 00:04:54', '2025-02-04 00:14:19'),
(127, '127', '1. verifikasi dokumen yang berorientasi kepada titipan pemangku kepentingan', 'Financial', 5, 4, 'HIGH', 'ON PROGRES', 'MEDIUM', 2, 2, NULL, 'Skema :\r\n1. Adanya titipan kontraktor dari pihak-pihak yang dianggap pemangku kepentingan\r\n2. membocorkan data nilai penawaran kompetitor lain, Melakukan penyuapan agar dapat diberikan informasi quotation', 'Pelaksanaan lelang yang dilaksanakan oleh konsultan independen atau sesuai SOP seleksi lelang proyek', '2025-02-04 00:20:08', '2025-02-04 00:21:11'),
(128, '128', 'penilaian yang tidak objektif, gratifikasi', 'Financial', 5, 4, 'HIGH', 'ON PROGRES', 'MEDIUM', 2, 2, NULL, 'Skema : Adanya tekanan dan gratifikasi dari pemangku kepentingan', NULL, '2025-02-04 00:24:42', '2025-02-04 00:24:55'),
(129, '129', 'Adanya penyuapan atau gratifikasi terhadap kontraktor atau vendor', 'Unsur Keuangan / Kerugian', 3, 2, 'HIGH', 'OPEN', NULL, NULL, NULL, NULL, 'Belum ada sosialisasi anti penyuapan', NULL, '2025-02-25 20:06:10', '2025-02-25 20:06:10'),
(130, '130', 'Listrik dan kertas yang digunakan banyak (limbah dan energi)', 'Enviromental (lingkungan)', 3, 2, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, 'Membutuhkan waktu yg lama untuk mendata (G-Form to exel), share group dan terkadang personal', NULL, '2025-02-27 23:59:54', '2025-02-28 00:00:45'),
(131, '131', '1. Kenaikan suhu global 2. Perubahan iklim yang ekstrem', 'Enviromental (lingkungan)', 3, 3, 'HIGH', 'OPEN', NULL, NULL, NULL, NULL, 'Belum jadwal 5S', NULL, '2025-02-28 00:07:08', '2025-02-28 00:07:08'),
(132, '132', 'Adanya penyuapan atau gratifikasi terhadap kontraktor atau vendor', 'Reputasi', 3, 2, 'HIGH', 'OPEN', NULL, NULL, NULL, NULL, 'Belum ada sosialisasi anti penyuapan', NULL, '2025-02-28 00:10:01', '2025-02-28 00:10:01'),
(133, '133', 'Coil mengalami rust sehingga tidak bisa dikirim ke customer', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Coil terkena tampias air hujan', 'Coil aman dari tampias air hujan', '2025-02-28 18:37:30', '2025-03-03 01:38:33'),
(134, '134', 'Line stop, batal proses, produk cacat, banyak scrap, target produksi kurang', 'Operational', 2, 3, 'HIGH', 'CLOSE', 'MEDIUM', 2, 2, NULL, 'Menambah produk NC akibat paintfeed tidak sesuai standard', NULL, '2025-02-28 19:54:57', '2025-05-14 01:16:13'),
(135, '135', 'Kualitas turun, complain tinggi, kepercayaan customer menurun, order turun', 'Operational', 2, 3, 'HIGH', 'ON PROGRES', 'MEDIUM', 2, 2, NULL, 'Sebelum diadakan training, operator kebingunan apa yang harus dilakukan jika muncul defect', NULL, '2025-02-28 19:57:43', '2025-05-13 18:39:48'),
(136, '136', 'Hasil pengukuran tidak bisa dipertanggungjawabkan', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 1, NULL, 'Alat ukur tidak terkalibrasi sehingga hasil pengukuran tidak standard/dipertanyakan kebenarannya.', NULL, '2025-02-28 20:01:20', '2025-05-13 18:42:43'),
(137, '137', 'Peningkatan Non Prime', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 2, 1, NULL, 'Proses trial produk baru berpotensi menambah produk NC karena belum ada prosedurnya', NULL, '2025-02-28 20:25:58', '2025-05-13 18:44:15'),
(138, '138', 'Penentuan spesifikasi produk tidak sesuai, Tidak mengetahui standard untuk jenis produk baru', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 2, 1, NULL, 'Prosedur tidak standard sehingga belum ada check point pada saat proses penambahan warna / produk baru yang menyebabkan proses trial menimbulkan produk NC', NULL, '2025-02-28 20:45:52', '2025-05-13 18:45:27'),
(139, '139', 'Penentuan spesifikasi produk tidak sesuai', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 2, 1, NULL, 'Operator bingung menentukan produk yang dihold atau tidak', NULL, '2025-02-28 20:48:33', '2025-05-13 18:47:20'),
(140, '140', 'Muncul defect yang baru, peningkatan non prime karena parameter berubah', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 2, 1, NULL, 'Terdapat beberapa supplier saat running', NULL, '2025-02-28 20:53:23', '2025-05-13 18:50:14'),
(141, '141', 'Standard unit berbeda untuk JIS, AS, ASTM dan ISO', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 2, 1, NULL, 'Tidak ada standard acuan jika penggunaan standard berbeda', NULL, '2025-02-28 20:55:30', '2025-05-13 18:53:14'),
(142, '142', 'Produk tidak sesuai dengan spesifikasi yang dipersyaratkan', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 2, 1, NULL, 'Bahan baku terbatas karena supplier sedikit', NULL, '2025-02-28 20:57:35', '2025-05-13 19:00:12'),
(144, '144', 'Handling non prime pada produk, Perbedaan requirement specification', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 2, 1, NULL, 'Produksi terbatas hanya pada customer tertentu', NULL, '2025-02-28 21:01:38', '2025-05-13 19:16:23'),
(145, '145', 'Lingkungan tercemar', 'Enviromental (lingkungan)', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 1, NULL, 'Tempat sampah tidak ada labelnya sehingga tercampur antara limbah anorganik, organik, dan B3', NULL, '2025-02-28 21:05:11', '2025-05-13 19:27:14'),
(146, '146', 'Lingkungan tercemar dan berbahaya bagi operator', 'Enviromental (lingkungan)', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 1, NULL, 'Bahan kimia tidak ditempelkan sign bahaya', NULL, '2025-02-28 21:07:01', '2025-05-13 19:27:49'),
(147, '147', 'Color range dan properties tidak lolos pengujian di tata logam', 'Operational', 2, 3, 'HIGH', 'ON PROGRES', 'MEDIUM', 2, 2, NULL, 'Muncul pengelompokan warna baru di tatalogam karena ada pergeseran warna produk', NULL, '2025-02-28 21:11:29', '2025-05-13 19:31:57'),
(149, '149', '1. Leakage, brick roboh terdorong ke dalam >> Long shutdown\r\n2. Posisi apron terdorong ke atas menggangu proses moving Pot dr posisi ON line ke Off line dan sebaliknya', 'Operational', 3, 3, 'HIGH', 'ON PROGRES', 'HIGH', NULL, NULL, NULL, 'Permukaan brick yang bagian atas pot sudah tidak rata. Kadang sudah mengganggu proses moving pot', NULL, '2025-02-28 22:42:12', '2025-05-26 23:42:16'),
(151, '151', 'Kemampuan melelehkan ingot menurun, akibatnya speed line perlu diturunkan. Akibatnya nilai productivity Menurun', 'Operational', 4, 2, 'HIGH', 'ON PROGRES', 'HIGH', 2, 4, NULL, 'Ratio turun sampai menyentuh 0,58 saat Low Power', NULL, '2025-03-03 01:34:09', '2025-05-08 00:21:24'),
(152, '152', 'Berhenti produksi karena gudang penuh', 'Operational', 3, 2, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, 'Storage capacity max 2100mt', NULL, '2025-03-04 15:23:30', '2025-05-09 22:52:49'),
(153, '153', 'Penentuan product dan supplier menjadi tidak objective', 'Unsur Keuangan / Kerugian', 3, 1, 'MEDIUM', 'ON PROGRES', 'LOW', 2, 1, NULL, 'Belum ada SOP', NULL, '2025-03-04 16:40:53', '2025-05-09 19:38:42'),
(154, '154', 'Issue Discoloration', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 1, NULL, 'Coil warna yang diproduksi belum terlapisi \"Self Cleaning\"', NULL, '2025-03-04 18:49:15', '2025-05-13 19:42:59'),
(155, '155', '1. Coil damage karena ditumpuk\r\n2. Pengambilan coil yg dibawah lebih lama karena harus bongkar bagian atas\r\n3. Coil beresiko menggelinding, ketika palet tidak kuat menahan  dan pecah', 'Operational', 4, 1, 'MEDIUM', 'CLOSE', 'LOW', 2, 1, NULL, 'Melakukan penumpukan pada coil yang slow-moving dan ditempatkan pada barisan paling belakang agar tidak mengganggu proses penyimpanan dan movement coil', NULL, '2025-03-06 04:32:29', '2025-03-07 00:56:55'),
(156, '156', '1. Coil damage ketika proses muat di kapal, pengangkatan menggunakan webbing\r\n2. Penumpukan Coil tidak standar sesuai berat ketika dikapal\r\n3. Coil  karat  karena berembun / basah terkena air ketika dalam perjalanan\r\n4. Ketika stuffing, antrian trailer akan sangat panjang karena dimuat dalam waktu bersamaan, berapapun jumlah yg akan dimuat', 'Operational', 3, 1, 'MEDIUM', 'CLOSE', NULL, NULL, NULL, NULL, 'Meningkatkan standar bahan packing untuk coil breakbulk', NULL, '2025-03-06 04:36:25', '2025-03-07 01:09:48'),
(157, '157', '1. Terjadi kecelakaan dijalan yang mengakibatkan kerusakan produk dan Image produk dan perusahaan jelek \r\n2. Barang menumpuk di gudang, karena costumer kesulitan mendapatkan ekspedisi yang memenuhi standar perusahaan', 'Operational', 3, 1, 'MEDIUM', 'CLOSE', NULL, NULL, NULL, NULL, 'Menginformasikan ke Sales Support bahwa kendaraan dari Ekspedisi tidak sesuai GL WH dan untuk mengganti Ekspedisi ataupun kendaraan serta kelengkapan kendaraan yang tidak standard', NULL, '2025-03-06 04:43:39', '2025-03-07 01:14:42'),
(158, '158', '1. Stock ditempatkan diarea diluar Layout barang jadi, sehingga mengurangi kapasitas penyimpanan barang jadi\r\n2. Limbah kayu yang dihasilkan bertambah banyak', 'Operational', 2, 1, 'LOW', 'CLOSE', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-06 05:17:41', '2025-03-07 01:17:47'),
(159, '159', 'Pencemaran udara', 'Enviromental (lingkungan)', 3, 2, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, 'Pengadaan uji emisi dari tim Environment', NULL, '2025-03-06 05:22:12', '2025-03-07 01:52:08'),
(160, '160', 'Pencemaran tanah', 'Enviromental (lingkungan)', 3, 1, 'MEDIUM', 'CLOSE', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-06 05:24:45', '2025-03-07 21:50:20'),
(161, '161', 'Pencemaran tanah', 'Enviromental (lingkungan)', 3, 1, 'MEDIUM', 'ON PROGRES', NULL, NULL, NULL, NULL, 'Sosialisasi divisi WH  terkait limbah B3', NULL, '2025-03-06 05:45:38', '2025-03-07 21:51:39'),
(162, '162', '1. Resin tumpah, pencemaran tanah karena layout tidak ada saluran ceceran dan bak penampungan\r\n2. Kemasan menggembung, karena suhu udara yang panas (tidak pada suhu ruangan)\r\n3. Resin rusak/Expired, menginfokan ke Supplier melalui Purchasing', 'Enviromental (lingkungan)', 3, 1, 'MEDIUM', 'CLOSE', NULL, NULL, NULL, NULL, 'Menyediakan Spill kit di area penyimpanan Resin, sebelum adanya chemical storage', NULL, '2025-03-06 05:50:25', '2025-03-07 21:56:04'),
(163, '163', '1. Stock tidak update antara fisik dan sistem\r\n2. Barang yang selisih tidak segera terdeteksi, menyulitkan user apabila saat barang dibutuhkan, stock tidak tersedia\r\n3. Coil selisih sulit dicari karena kondisi Layout yang berpindah2', 'Operational', 3, 1, 'MEDIUM', 'CLOSE', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-06 21:07:24', '2025-03-07 21:59:10'),
(164, '164', '1. Stock tidak update antara fisik dan sistem\r\n2. Barang yang selisih tidak segera terdeteksi, menyulitkan ketika melakukan treacebility\r\n3. Stock tidak tersedia ketika diperlukan, sehingga bisa menyebabkan mesin tidak bisa/ terhambat beroperasi', 'Operational', 3, 1, 'MEDIUM', 'CLOSE', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-06 21:27:42', '2025-03-07 22:00:53'),
(165, '165', '1. Barang tidak bisa dikirim\r\n2. Kualiatas barang turun grade\r\n3. Menjadi barang slowmoving', 'Operational', 3, 1, 'MEDIUM', 'ON PROGRES', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-06 21:34:59', '2025-03-07 22:04:00'),
(166, '166', '1. Terjadi Fatality, LTI atau MTI\r\n2. Kehilangan jam kerja, produktifitas menurun\r\n3. Target hasil packing tidak tercapai, pengiriman ke customer terlambat', 'Operational', 3, 1, 'MEDIUM', 'ON PROGRES', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-06 23:08:10', '2025-03-07 22:07:00'),
(167, '167', 'Pencemaran lingkungan', 'Operational', 4, 1, 'MEDIUM', 'CLOSE', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-06 23:45:29', '2025-03-07 22:10:23'),
(168, '168', 'Kerusakan lingkungan, gangguan kesehatan pekerja, sanksi regulasi', 'Enviromental (lingkungan)', 3, 4, 'HIGH', 'CLOSE', 'LOW', 1, 2, NULL, 'Masih di bawah ambang batas', 'Emisi lebih terkontrol sesuai dengan standart', '2025-03-16 21:44:56', '2025-03-17 01:25:21'),
(169, '169', 'Pencemaran air, sanksi hukum, dampak kesehatan masyarakat', 'Enviromental (lingkungan)', 3, 4, 'HIGH', 'CLOSE', 'LOW', 1, 2, NULL, '-', '-', '2025-03-16 21:47:12', '2025-03-17 01:26:26'),
(175, '175', 'Peningkatan volume sampah, pencemaran tanah', 'Enviromental (lingkungan)', 3, 1, 'MEDIUM', 'CLOSE', 'LOW', 2, 1, NULL, '-', '-', '2025-03-16 23:18:42', '2025-03-17 01:35:41'),
(176, '176', '1. Ledakan dan Kebakaran (R)\r\n2. Produksi berhenti (R)', 'Safety & Health', 3, 4, 'HIGH', 'CLOSE', 'LOW', 2, 1, NULL, 'kondisi sekarang semua tindak lanjut sudah dilakukan semua', NULL, '2025-03-16 23:21:27', '2025-03-17 00:13:13'),
(177, '177', 'Bahaya kesehatan, pencemaran tanah dan air', 'Enviromental (lingkungan)', 3, 4, 'HIGH', 'CLOSE', 'LOW', 1, 2, NULL, 'Terjadi tumpahan / ceceran resin saat pergantian Bulky Resin', 'Tidak ada tumpahan setelah dibuatkan GL Pergantian Bulky', '2025-03-16 23:28:52', '2025-03-17 01:28:12'),
(178, '178', 'Gangguan kesehatan pekerja dan masyarakat sekitar', 'Enviromental (lingkungan)', 2, 2, 'MEDIUM', 'CLOSE', 'LOW', 1, 1, NULL, 'Sebelumnya dapat komplain dari tetangga sebelah karna bising', 'Tidak ada komplain', '2025-03-17 00:16:29', '2025-03-17 01:33:25'),
(179, '179', NULL, 'Enviromental (lingkungan)', 3, 2, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, 'Belum ada IK pembuangan Freon \r\nAC sudah tidak menggunakan freon R22', NULL, '2025-03-17 00:19:24', '2025-03-17 01:37:44'),
(180, '180', 'Meningkatnya jejak karbon, pemborosan biaya energi', 'Enviromental (lingkungan)', 2, 2, 'MEDIUM', 'CLOSE', 'LOW', 2, 1, NULL, 'Menggunakan 3 Zona NOF menggunakan Emisi yang lebih banyak', 'Jika running strip tipis 0.2 0.25 hanya menggunakan 1 zone NOF Furnace sehingga emisi bisa dikurangi', '2025-03-17 00:28:08', '2025-03-17 01:23:37'),
(181, '181', 'Kerusakan ekosistem, sanksi hukum', 'Enviromental (lingkungan)', 3, 4, 'HIGH', 'CLOSE', 'LOW', 1, 2, NULL, 'Tidak tempat khusus untuk chemical bercampur dengan barang jadi', 'Dibuatkan WH Storage Chemical', '2025-03-17 00:32:10', '2025-03-17 01:29:25'),
(182, '182', 'Denda, pencabutan izin operasi', 'Enviromental (lingkungan)', 3, 5, 'HIGH', 'CLOSE', 'LOW', 1, 1, NULL, '-', '-', '2025-03-17 00:35:05', '2025-03-17 01:36:06'),
(183, '183', 'Kekurangan air, peningkatan biaya operasional', 'Enviromental (lingkungan)', 2, 2, 'MEDIUM', 'ON PROGRES', NULL, NULL, NULL, NULL, '-', NULL, '2025-03-17 00:58:21', '2025-03-17 01:04:30'),
(184, '184', 'Kerusakan fasilitas, korban jiwa', 'Enviromental (lingkungan)', 3, 4, 'HIGH', 'CLOSE', 'LOW', 1, 1, NULL, 'Kaleng Cat & Thiner di letakan di lemari berbahan kayu potensi terbakar', 'sudah di sediakan lemari berbahan besi', '2025-03-17 00:59:41', '2025-03-17 01:31:08'),
(185, '185', 'Kecelakaan Kerja', 'Safety & Health', 2, 3, 'HIGH', 'CLOSE', 'MEDIUM', 2, 2, NULL, 'Beberapa kali temuan tim tidak memakai kacamata diarea wajib APD lv. 1\r\nBeberapa kali temuan pekerjaan tidak lengkap dokumen safetynya', 'Penggunaan kacamata safety sudah mulai konsisten.\r\nSaat inspeksi proses Isolation procedure saat shutdown sudah memenuhi persyaratan', '2025-03-17 01:22:10', '2025-03-18 00:30:25'),
(186, '186', NULL, 'Enviromental (lingkungan)', 3, 1, 'MEDIUM', 'CLOSE', 'LOW', 2, 1, NULL, NULL, NULL, '2025-03-17 01:44:48', '2025-03-17 18:32:14'),
(187, '187', 'Produksi dengan pemakaian SPM akan terhenti', 'Operational', 3, 2, 'HIGH', 'CLOSE', 'LOW', 2, 1, NULL, 'unit RO masih 1 unit', NULL, '2025-03-17 18:50:21', '2025-05-08 00:35:30'),
(188, '188', 'Line stop, delay dan atau quality problem', 'Operational', 2, 3, 'HIGH', 'CLOSE', 'LOW', 1, 1, NULL, 'Worker yang berpengalaman terbatas jumlahnya', 'Skill teknisi meningkat\r\nLebih fleksibel dalam menentukan worker untuk melakukan pekerjaan', '2025-03-18 00:19:24', '2025-03-18 00:25:53'),
(189, '189', '1. Tertular/OTG/ODP/PDP/Fatality\r\n2. Pabrik ditutup', 'Operational', 1, 4, 'MEDIUM', 'CLOSE', 'LOW', 1, 1, NULL, 'Pandemi covid masih berlangsung', 'Pandemi covid sudah selesai', '2025-03-18 01:11:06', '2025-03-18 01:15:56'),
(190, '190', 'No Emergency Tools if any leakage or repaired at Pot', 'Operational', 3, 3, 'HIGH', 'CLOSE', 'LOW', 1, 1, NULL, 'Pompa spare belum ready', 'Pompa spare sudah ready', '2025-03-18 02:13:06', '2025-03-18 02:15:56'),
(191, '191', 'Leakage, long delay', 'Operational', 2, 4, 'HIGH', 'CLOSE', 'LOW', 1, 1, NULL, 'Permukaan brick yang dibagian atas pot, sudah tidak rata. Kadang sudah mengganggu proses moving pot.', 'Brick dibagian atas pot sudah diganti ( 7 layer )\r\nBottom dross sudah diambil\r\nInductor sudah diganti dengan yang baru semua', '2025-03-18 02:19:49', '2025-03-18 02:27:19'),
(192, '192', 'Line stop', 'Operational', 2, 4, 'HIGH', 'CLOSE', 'MEDIUM', 1, 4, NULL, 'Flange roda sering kemakan rail. Sehingga perlu sering diganti', 'Flange roda sudah bertahan lebih lama', '2025-03-19 20:43:10', '2025-03-19 20:49:47'),
(193, '193', 'Waktu persiapan pot gear lebih lama', 'Kinerja', 2, 2, 'MEDIUM', 'CLOSE', 'LOW', 1, 1, NULL, 'Proses pinjam crane lama, kadang tidak bisa dipinjam', 'Peminjaman crane lebih fleksibel', '2025-03-19 21:12:02', '2025-03-19 21:14:54'),
(194, '194', 'Pencemarah tanah', 'Safety & Health', 3, 1, 'MEDIUM', 'ON PROGRES', 'LOW', 2, 1, NULL, 'Beberapa equipment mengalami kebocoran oli, limbah terkontaminasi oli / grease dibuang tempat sampah kuning', 'Equipment yang mengalami kebocoran berkurang, limbah terkontaminsai oli / grease sudah dibuang sesuai tempatnya', '2025-03-24 20:44:06', '2025-03-24 20:53:49'),
(195, '195', 'Stock ready to use habis, tidak bisa produksi paint feed', 'Operational', 3, 2, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, 'Ada 3 workshop untuk reharchrome', 'Sudah ditentukan workshop menggunakan jasa dari Horiguchi', '2025-03-24 20:57:18', '2025-03-24 20:59:27'),
(196, '196', 'Injury or Property Damage', 'Safety & Health', 2, 3, 'HIGH', 'CLOSE', 'LOW', 1, 2, NULL, 'Masih ada pekerjaan crane diatas kantor', 'Tidak ada pekerjaan crane diatas kantor', '2025-03-24 21:04:02', '2025-03-24 21:10:08'),
(197, '197', 'Long Breakdown', 'Operational', 3, 3, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, 'Pembelian bearing tidak dari suplier resmi', 'Pembelian bearing dari suplier resmi, beli lokalan di cikarang hanya untuk emergency case', '2025-03-24 21:13:26', '2025-03-24 21:14:58'),
(198, '198', 'Apabila ada kerusakan besar pada crane. Tidak bisa dilakukan dengan cepat oleh PT. Giken >> Long shutdown', 'Operational', 3, 4, 'HIGH', 'CLOSE', 'HIGH', 3, 2, NULL, 'All senior technision resigned from PT. Giken', 'Pekerjaan yang tidak disanggupi oleh PT. Giken menggunakan contractor lain', '2025-03-26 00:19:58', '2025-05-08 00:17:57'),
(199, '199', 'Menambah resiko kecelakaan di jalan dan beresiko menurunkan daya tahan tubuh (kesehatan).\r\nSaat banyak yang terdampak karena sakit, akan mengakibatkan berkurangnya Man Power yang untuk maintain Line', 'Kinerja', 1, 4, 'MEDIUM', 'CLOSE', 'LOW', 1, 2, NULL, 'Dari data statistik pengunjung UKK meningkat dan banyak yang ijin dokter karena sakit. Produktifitas turun.', '-', '2025-03-26 01:02:34', '2025-05-08 00:56:54'),
(200, '200', 'Pekerja berpotensi mengalami Dehidrasi ketika bekerja di area yang cukup panas (Dekat atap), Saat melakukan PM Crane.', 'Safety & Health', 3, 2, 'HIGH', 'CLOSE', 'MEDIUM', 2, 2, NULL, '-', '-', '2025-03-26 01:07:15', '2025-05-07 23:35:50'),
(201, '201', '1. kolusi , kesepakatan jahat.\r\n2. verifikasi penawaran yang berorientasi kepada titipan pemangku kepentingan\r\n3. penilaian yang tidak objektif karena adanya permintaan dari pihak-pihak tertentu untuk memaksakan vendor tertentu', 'Unsur Keuangan / Kerugian', 3, 2, 'HIGH', 'ON PROGRES', 'LOW', 2, 1, NULL, NULL, NULL, '2025-03-26 01:14:34', '2025-05-08 00:46:36'),
(202, '206', 'Pot Gear semakin banyak variasi sink roll ( 3 tipe) (dia. 600 mm, dia 800 ml (GL), dia.800 ml (GI))', 'Operational', 2, 2, 'MEDIUM', 'CLOSE', 'MEDIUM', 3, 1, NULL, 'Salah satu kontribusi membuat defect Ridgemark adalah roll sinkroll terlalu berat untuk running tipis.', 'Sudah digunakan rutin untuk running. (issue masih ada Jumpmark)', '2025-03-26 01:23:34', '2025-05-08 00:54:43'),
(204, '208', 'Long Breakdown (R)\r\nPembelian Kabel Indent 6-8minggu', 'Operational', 3, 2, 'HIGH', 'OPEN', NULL, NULL, NULL, NULL, 'Kabel yg rusak, sementara dibuatkan Cable tray dgn dibuat bertingkat (separate), sehingga panas dari kabel bisa menyebar dan tidak berkumpul menjadi 1, di 1 tempat', NULL, '2025-04-18 22:25:36', '2025-04-18 22:25:36'),
(205, '209', 'Long Breakdown (R) Karena Produk tidak bisa dicheck Ketebalan Coatingan nya', 'Operational', 3, 2, 'HIGH', 'OPEN', NULL, NULL, NULL, NULL, 'Tidak memilik Spare Parts Gauge Head CWG (untuk parts ini harus di order 1 set)', NULL, '2025-04-20 00:36:32', '2025-04-20 00:36:32'),
(206, '210', 'Saat ini ketika Running dengan Branding Sinusoidal tidak memiliki Spare mesin (baik menggunakan tinta hitam, maupun menggunakan Tinta UV)', 'Operational', 3, 1, 'MEDIUM', 'OPEN', NULL, NULL, NULL, NULL, 'Trial mesin Branding dengan printech (mesin Markem Imaje 9450)', NULL, '2025-04-20 00:48:46', '2025-04-20 00:48:46'),
(207, '211', 'Electrician belum semua memahami kondisi emergency respon Plan', 'Safety & Health', 3, 2, 'HIGH', 'OPEN', NULL, NULL, NULL, NULL, 'Electrician belum semua memahami Kondisi Emergency respon plan', NULL, '2025-04-20 02:13:25', '2025-04-20 02:13:25'),
(208, '212', 'Long Breakdown\r\nRepair Lilitan Motor untuk motor besar (>37kW) +/-10 hari kerja\r\nRepair Bearing Motor (bila Bearing dan Mech seal Ready) +/- 3 hari kerja', 'Operational', 2, 4, 'HIGH', 'OPEN', NULL, NULL, NULL, NULL, 'Condition Monitoring Continue berjalan setiap hari untuk memonitor kondisi Seluruh mesin (baik Vibrasi Monitoring, Maupun Temperature Monitoring)', NULL, '2025-04-20 02:35:59', '2025-04-20 02:35:59'),
(209, '213', NULL, 'Operational', 3, 1, 'MEDIUM', 'OPEN', NULL, NULL, NULL, NULL, 'Pemasangan Sensor Vibration Monitoring pada Motor POR 1, Hot Bridle #1, dan juga Motor Cleaning Dryer', NULL, '2025-04-20 02:40:41', '2025-04-20 02:40:41'),
(213, '217', 'Kelembaban tinggi akibat  cuaca hujan yang panjang\r\nmenyebabkan korosi lebih cepat pada produk galvalum', 'Enviromental (lingkungan)', 3, 5, 'HIGH', 'CLOSE', 'LOW', 1, 1, NULL, '-', '-', '2025-05-06 02:06:27', '2025-05-06 02:08:02'),
(214, '218', 'Stop Produksi\r\nTidak bisa kirim produk ke customer', 'Safety & Health', 3, 3, 'HIGH', 'CLOSE', 'MEDIUM', 3, 1, NULL, 'belum adanya automatic fire system', 'Install automatic fire system', '2025-05-06 05:38:12', '2025-05-09 19:48:15'),
(215, '219', 'Non Prime dan Delay produksi', 'Operational', 3, 1, 'MEDIUM', 'CLOSE', 'LOW', NULL, NULL, NULL, NULL, NULL, '2025-05-06 19:38:00', '2025-05-09 19:49:47'),
(216, '220', 'Non Prime dan customer complaint', 'Financial', 3, 1, 'MEDIUM', 'OPEN', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-06 21:28:13', '2025-05-06 21:28:13'),
(217, '221', 'Non Prime dan customer complaint', 'Financial', 3, 1, 'MEDIUM', 'OPEN', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-07 00:06:47', '2025-05-07 00:06:47'),
(218, '222', 'Non prime, Customer Complaint, Kerusakan equipment', 'Kinerja', 3, 2, 'HIGH', 'CLOSE', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-07 00:14:37', '2025-05-09 01:56:23'),
(219, '223', 'Order customer Tidak terpenuhi', 'Kinerja', 3, 4, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, '-', NULL, '2025-05-07 03:07:52', '2025-05-09 19:47:42'),
(220, '224', 'Order customer Tidak terpenuhi', 'Kinerja', 3, 3, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-07 03:10:07', '2025-05-09 02:35:16'),
(221, '225', 'Product tidak terkirim ke customer', 'Kinerja', 3, 2, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-07 03:21:04', '2025-05-09 02:38:44'),
(222, '226', 'Non prime, Customer Complaint', 'Kinerja', 3, 2, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-07 19:38:07', '2025-05-09 02:50:22'),
(223, '227', 'Peningkatan Efek rumah kaca', 'Operational', 3, 2, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-07 19:45:20', '2025-05-11 23:56:32'),
(224, '228', 'Peningkatan Efek rumah kaca', 'Operational', 3, 1, 'MEDIUM', 'ON PROGRES', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-07 19:56:28', '2025-05-11 23:57:06'),
(225, '229', 'Terjadi kerugian pada perusahaan', 'Kinerja', 3, 2, 'HIGH', 'ON PROGRES', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-07 20:00:15', '2025-05-11 23:58:17'),
(226, '230', 'Set point RTO tidak tercapai', 'Kinerja', 2, 2, 'MEDIUM', 'ON PROGRES', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-07 20:05:46', '2025-05-11 23:59:46');
INSERT INTO `resiko` (`id`, `id_riskregister`, `nama_resiko`, `kriteria`, `probability`, `severity`, `tingkatan`, `status`, `risk`, `probabilityrisk`, `severityrisk`, `target`, `before`, `after`, `created_at`, `updated_at`) VALUES
(227, '231', 'Product Telescoping', 'Financial', 3, 1, 'MEDIUM', 'CLOSE', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-07 20:18:26', '2025-05-12 00:03:03'),
(228, '232', '1. Ledakan dan Kebakaran (R)\r\n2. Produksi berhenti (R)', 'Operational', 3, 3, 'HIGH', 'CLOSE', 'LOW', 1, 1, NULL, NULL, NULL, '2025-05-07 20:24:18', '2025-05-12 19:14:22'),
(229, '233', 'Unpainted', 'Financial', 2, 1, 'LOW', 'ON PROGRES', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-07 20:44:22', '2025-05-12 00:08:39'),
(230, '234', 'Terpapar amonia (R),', 'Enviromental (lingkungan)', 3, 5, 'HIGH', 'CLOSE', 'MEDIUM', 3, 1, NULL, NULL, NULL, '2025-05-07 20:50:19', '2025-05-12 19:14:02'),
(231, '235', 'Unpainted edge', 'Financial', 2, 1, 'LOW', 'ON PROGRES', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-07 20:53:56', '2025-05-12 00:09:14'),
(232, '236', 'Unpainted edge', 'Financial', 2, 1, 'LOW', 'OPEN', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-07 20:58:55', '2025-05-07 20:58:55'),
(233, '237', 'Strip mengenai windbox menyebabkan Scratch bottom atau Top', 'Operational', 2, 2, 'MEDIUM', 'CLOSE', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-07 21:03:37', '2025-05-12 00:13:34'),
(234, '238', 'Hasil pengecekan product Physical properties fail', 'Operational', 2, 2, 'MEDIUM', 'OPEN', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-07 21:09:02', '2025-05-07 21:09:02'),
(235, '239', 'Kebakaran (R)', 'Safety & Health', 3, 2, 'HIGH', 'CLOSE', 'LOW', 1, 1, NULL, NULL, NULL, '2025-05-07 23:12:55', '2025-05-08 00:35:15'),
(236, '240', 'Uap Amoniak terhirup karyawan\r\nTerjadi stop line diatas 0.5 stop/shift\r\nHarus beli amoniak lagi', 'Enviromental (lingkungan)', 3, 2, 'HIGH', 'CLOSE', 'MEDIUM', 2, 2, NULL, NULL, NULL, '2025-05-08 00:04:05', '2025-05-12 00:15:34'),
(237, '241', 'terjadi insiden fatality di karena kan grounding yang rusak pada pompa summersible', 'Safety & Health', 3, 3, 'HIGH', 'CLOSE', 'LOW', 2, 1, NULL, NULL, NULL, '2025-05-08 00:11:23', '2025-05-12 19:13:40'),
(238, '242', 'supply air untuk cooling tower berkurang sehingga bisa menyebabkan stopline produksi', 'Operational', 3, 2, 'HIGH', 'CLOSE', 'LOW', 2, 1, NULL, NULL, NULL, '2025-05-08 00:40:24', '2025-05-12 19:13:07'),
(239, '243', 'Penggunaan material yang bersumber dari alam / kayu meningkat. Berdampak terhadap percepatan perubahan iklim.', 'Enviromental (lingkungan)', 3, 1, 'MEDIUM', 'ON PROGRES', 'LOW', 1, 1, NULL, 'Menggunakan VCI baru.', 'Untuk product Hitam Lorentz yang dikirim ke Tatalogam (Intercompany) digunakan kertas/pembungkus VCI ex. Import atau ex coil Piant Feed.\r\nPallet yang digunakan, pallet horizontal ex PF Import.', '2025-05-09 19:34:11', '2025-05-12 21:58:51'),
(240, '244', NULL, 'Enviromental (lingkungan)', 2, 2, 'MEDIUM', 'OPEN', NULL, NULL, NULL, NULL, 'belum ada jalur pemanfaatan air hujan', NULL, '2025-05-12 19:18:53', '2025-05-12 19:18:53'),
(241, '245', 'kerugian keuangan', 'Unsur Keuangan / Kerugian', 3, 3, 'HIGH', 'OPEN', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-12 20:23:14', '2025-05-12 20:23:14'),
(242, '246', 'Penyuapan saat pengadaan spare part', 'Operational', 2, 2, 'MEDIUM', 'ON PROGRES', NULL, NULL, NULL, NULL, 'Belum ada laporan pelanggaran kebijakan anti penyuapan, lebih kepada pencegahan', NULL, '2025-05-14 21:30:56', '2025-05-27 20:34:14'),
(243, '247', '- Kelelahan operator\r\n- Safety awareness menurun', 'Operational', 3, 2, 'HIGH', 'OPEN', NULL, NULL, NULL, NULL, 'Average OT Ratio 3 bulan terakhir 40%', NULL, '2025-05-14 22:20:22', '2025-05-14 22:20:22'),
(244, '248', 'Kualitas material menurun akibat dampak iklim (misal: material basah (lembap), rusak karena suhu ekstrem) sehingga meningkatkan potensi barang reject dan keterlambatan produksi.', 'Enviromental (lingkungan)', 2, 2, 'MEDIUM', 'CLOSE', 'LOW', 1, 1, NULL, '- Barang diterima dalam kondisi basah, karena supplier tidak menjaga handling saat cuaca ekstrem\r\n\r\n- Banyak komplain dari tim produksi, waktu terbuang untuk klaim atau penggantian', '- Barang datang lebih terjaga kualitasnya, karena supplier sudah paham standar packing saat cuaca ekstrem. (Supplier menutup barang dengan terpal tebal)\r\n\r\n- Waktu dan biaya rework menurun, hubungan kerja dengan supplier lebih baik', '2025-05-27 19:58:10', '2025-05-27 20:08:47'),
(245, '249', 'Dapat mengakibatkan kegiatan operasional perusahaan terganggu karena perencanaan keuangan belum dapat diaplikasikan sesuai dengan budget yang telah ditetapkan.', 'Unsur Keuangan / Kerugian', 3, 3, 'HIGH', 'CLOSE', 'LOW', 2, 1, NULL, 'Beberapa Departemen yang belum input budget di program Puskom', NULL, '2025-05-27 19:58:21', '2025-05-27 21:51:32'),
(247, '251', 'Akan menambah siklus product (naik-turun), hal ini berpotensi terjadinya Stop Line dan produksi menjadi tidak effisien', 'Operational', 4, 4, 'HIGH', 'ON PROGRES', 'LOW', 1, 2, NULL, 'Di Oktober 2021 terjadi Revisi Rencana Produksi sebanyak 14 kali', 'Terjadi penurunan Revisi Rencana Produksi  menjadi sebanyak 3 sampai dengan 4 kali dalam 1 bulan di tahun 2022', '2025-05-27 20:35:51', '2025-05-27 21:19:11'),
(248, '252', 'Banyak produk defect (Non Prime & down grade) sehingga Yield menjadi turun', 'Operational', 4, 4, 'HIGH', 'OPEN', NULL, NULL, NULL, NULL, 'Average FY23=98.55%, Target >98%', NULL, '2025-05-27 20:47:31', '2025-05-27 20:47:31'),
(250, '254', '- Start Up bisa mundur dan Stop Line\r\n - PPIC harus merubah Sequence Produksi dan akan menambah siklus product (naik-turun) beresiko in-effiensi yield menjadi turun estimasi 2% akibat defect\r\n - Operator tidak ada aktivitas', 'Operational', 4, 4, 'HIGH', 'OPEN', NULL, NULL, NULL, NULL, 'Sebelumnya terjadi delay kedatangan  sebanyak 2x', NULL, '2025-05-27 21:06:40', '2025-05-27 21:06:40'),
(251, '255', 'Reputasi perusahaan yang tercemar, serta keputusan pengadaan yang tidak objektif.', 'Reputasi', 2, 2, 'MEDIUM', 'ON PROGRES', NULL, NULL, NULL, NULL, 'Keputusan pemilihan supplier bisa dipengaruhi oleh kepentingan pribadi tanpa transparansi yang jelas', NULL, '2025-05-27 21:13:18', '2025-05-27 21:15:49'),
(252, '256', NULL, 'Reputasi', 2, 2, 'MEDIUM', 'OPEN', NULL, NULL, NULL, NULL, 'Keputusan pemilihan supplier bisa dipengaruhi oleh kepentingan pribadi tanpa transparansi yang jelas', NULL, '2025-05-27 21:15:03', '2025-05-27 21:15:03'),
(253, '257', 'Persaingan yang tidak sehat \r\nHak2 Konsumen tidak terpenuhi', 'Reputasi', 1, 4, 'MEDIUM', 'CLOSE', 'LOW', 1, 2, NULL, NULL, 'TML telah melakukan standarisasi sesuai SNI', '2025-05-27 21:24:29', '2025-05-27 21:49:34'),
(257, '261', 'nowincacsa', 'Financial', 2, 2, 'MEDIUM', 'OPEN', NULL, NULL, NULL, NULL, 'kjq ca scnaqx', 'idunqindksaniq', '2025-09-04 01:49:33', '2025-09-05 18:02:46'),
(258, '262', 'tezzzzz', 'Financial', 4, 3, 'HIGH', 'ON PROGRES', 'LOW', 2, 1, NULL, 'tezzzzzzzzzzzzzzzzzz', 'tezzzzzzzzzzzzz', '2025-09-05 18:18:52', '2025-09-05 18:19:41'),
(259, '263', 'tezzzzzz pdf', 'Enviromental (lingkungan)', 4, 4, 'HIGH', 'OPEN', NULL, NULL, NULL, NULL, 'tezzzzzzzzzzzz', NULL, '2025-09-15 19:16:29', '2025-09-15 19:16:29');

-- --------------------------------------------------------

--
-- Table structure for table `riskregister`
--

CREATE TABLE `riskregister` (
  `id` bigint UNSIGNED NOT NULL,
  `id_divisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `issue` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktifitas_kunci` text COLLATE utf8mb4_unicode_ci,
  `inex` enum('I','E') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pihak` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_penyelesaian` date DEFAULT NULL,
  `peluang` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `riskregister`
--

INSERT INTO `riskregister` (`id`, `id_divisi`, `issue`, `aktifitas_kunci`, `inex`, `pihak`, `keterangan`, `target_penyelesaian`, `peluang`, `created_at`, `updated_at`) VALUES
(3, '10', 'Pengurusan ijin bangunan all tray terkait lingkungan', NULL, 'I', 'SAFETY CKR', '', '2024-10-31', NULL, '2024-11-01 00:42:40', '2024-11-08 01:32:10'),
(8, '10', 'Emergency penanganan kebocoran amoniak belum ada', NULL, 'I', 'MTC UTILIYY CKR', '', '2024-09-18', NULL, '2024-11-01 21:03:00', '2024-11-08 01:34:11'),
(9, '13', 'Kedatangan Trailer Import CRC yang datang sekaligus, sehingga mengganggu lalu lintas kawasan', NULL, 'E', 'PPIC & DELIVERY,PRODUCTION CKR,SUPPLY CHAIN & WAREHOUSE CKR', '', '2024-04-05', NULL, '2024-11-01 21:49:42', '2025-03-06 23:58:32'),
(10, '10', 'Launder PM sering ngeblock', NULL, 'I', 'PRODUCTION', '', '2024-12-31', NULL, '2024-11-01 22:01:50', '2024-11-01 22:01:50'),
(19, '11', 'Supplier CRC Baru', NULL, 'E', 'PPIC & DELIVERY,PROCUREMENT,PRODUCTION CKR,QA CKR,SALES & MARKETING', '', '2025-12-31', 'Menambah referensi penggunaan supplier CRC baru, agar supply CRC tidak bergantung pada 1 supplier', '2024-11-03 21:15:44', '2025-02-28 18:38:17'),
(20, '11', 'Tooling produksi oleh customer', NULL, 'I', 'PPIC & DELIVERY,PROCUREMENT,PRODUCTION CKR,QA CKR', '', '2025-12-31', '1. Menaikkan kapasitas produksi\r\n2. Meningkatkan kepercayaan customer terhadap kualitas TML', '2024-11-03 21:20:33', '2025-02-28 18:38:45'),
(21, '11', 'Tooling produksi raw material ke supplier', NULL, 'E', 'PPIC & DELIVERY,PROCUREMENT,PRODUCTION CKR,QA CKR,SALES & MARKETING', '', '2025-12-31', 'Menambah peluang ketersediaan CRC ketika pasokan CRC terhambat', '2024-11-03 23:06:47', '2025-02-28 18:39:29'),
(22, '11', 'Limbah B3 tidak ditempatkan pada sampah B3', NULL, 'I', 'HR & GA CKR,QA CKR', '', '2025-12-31', 'Lingkungan kerja lebih sehat dan aman', '2024-11-03 23:08:59', '2025-02-28 18:39:46'),
(23, '11', 'Bahan-bahan kimia yang digunakan untuk pengujian tidak ada label dan MSDS/tanda bahaya', NULL, 'I', 'QA CKR', '', '2025-12-31', 'Lingkungan kerja lebih sehat dan aman', '2024-11-03 23:12:12', '2025-02-28 18:40:05'),
(24, '11', 'Raw Material yang dikirim tidak kompatible dengan line CCL TML Sadang', NULL, 'I', 'PPIC & DELIVERY,PRODUCTION CKR,QA CKR', '', '2025-12-31', 'Menambah hasil/jenis produksi', '2024-11-03 23:21:20', '2025-02-28 18:40:21'),
(25, '26', 'Adanya permintaan dari Pelanggan untuk pengujian dipercepat', NULL, 'E', 'LAB,PRODUCTION CKR', '', '2024-12-31', 'Meningkatnya permintaan pengujian yang masuk', '2024-11-03 23:33:00', '2025-03-02 21:47:52'),
(26, '10', 'Angka LTI masih ada', NULL, 'I', 'PRODUCTION CKR,PRODUCTION SDG,MTC MEC & ELC CKR,MTC MEC, ELC & UTL SDG,MTC UTILIYY CKR,HR & GA CKR,HR & GA SDG,SAFETY CKR,QA CKR,QA SDG,SUPPLY CHAIN & WAREHOUSE CKR,SUPPLY CHAIN & WAREHOUSE SDG,SALES & MARKETING,ACCOUNTING,PROCUREMENT,PPIC & DELIVERY,EKSPOR & IMPOR,TREASURY,INVOICING,MANUFACTURING,LAB,SAFETY SDG', '', '2024-11-30', NULL, '2024-11-04 18:20:49', '2024-11-08 01:36:51'),
(27, '10', 'Investigasi', NULL, 'I', 'PRODUCTION CKR,PRODUCTION SDG,MTC MEC & ELC CKR,MTC MEC, ELC & UTL SDG,MTC UTILIYY CKR,HR & GA CKR,HR & GA SDG,SAFETY CKR,QA CKR,QA SDG,SUPPLY CHAIN & WAREHOUSE CKR,SUPPLY CHAIN & WAREHOUSE SDG,SALES & MARKETING,ACCOUNTING,PROCUREMENT,PPIC & DELIVERY,EKSPOR & IMPOR,TREASURY,INVOICING,MANUFACTURING,LAB,SAFETY SDG', '', '2024-11-30', NULL, '2024-11-04 18:23:58', '2024-11-08 01:37:40'),
(28, '10', 'Belum ada prioritas mengenai MCU', NULL, 'I', 'HR & GA CKR,SAFETY CKR', '', '2024-11-30', 'Dapat membantu dalam mendeteksi dini masalah kesehatan yang mungkin mempengaruhi kinerja atau kesejahteraan karyawan', '2024-11-04 18:26:45', '2024-11-24 18:25:31'),
(29, '10', 'Pembangunan pabrik baru : \r\n1. Mengurus addendum perizinan baru terkait RKL RPL Rinci (UKL - UPL)', NULL, 'E', 'HR & GA CKR,SAFETY CKR', '', '2024-11-30', NULL, '2024-11-04 18:36:33', '2024-11-24 18:26:48'),
(30, '10', 'Pembangunan pabrik baru :\r\n2. Relokasi dan Perizinan TPS Limbah B3', NULL, 'E', 'HR & GA CKR,SAFETY CKR', '', '2024-11-30', 'TPS B3 bisa di desain lebih luas agar tidak over capacity', '2024-11-04 18:40:06', '2024-11-24 18:27:51'),
(31, '10', 'Pembangunan pabrik baru :\r\n3. Belum ada walkway, untuk memisahkan jalur pejalan kaki dan lalu lintas kendaraan', NULL, 'I', 'HR & GA CKR,SAFETY CKR', '', '2024-11-30', 'Pembangunan Walkway yang aman dapat meningkatkan keselematan dan kenyamanan pekerja serta pengunjung', '2024-11-04 18:45:58', '2024-11-24 18:28:41'),
(32, '10', 'Pembangunan pabrik baru :\r\n4. Over capacity chemicla storage', NULL, 'I', 'HR & GA CKR,SAFETY CKR', '', '2024-11-30', 'Membuat chemical storage baru di all tray', '2024-11-04 18:49:17', '2024-11-24 18:29:02'),
(33, '10', 'Industri 4.0 dan reduce kertas', NULL, 'E', 'SAFETY CKR', '', '2024-11-30', '1. Sistem terintegrasi untuk administrasi safety dan bisa diakses semua orang\r\n2. Hemat kertas karena semua sistem teringrasi online', '2024-11-04 18:57:30', '2025-03-11 03:13:55'),
(37, '14', 'Kedatangan Trailer Import Paint Feed yang datang sekaligus.', NULL, 'I', 'PRODUCTION SDG,HR & GA SDG,SUPPLY CHAIN & WAREHOUSE SDG,PPIC & DELIVERY,EKSPOR & IMPOR', '', '2024-03-31', NULL, '2024-11-04 21:12:23', '2024-11-08 10:09:53'),
(41, '2', 'Emisi yang dihasilkan melebihi ambang yang ditetapkan pemerintah', NULL, 'E', 'SAFETY SDG', '', '2024-11-30', 'Citra perusahaan yang selalu menjaga lingkungan dengan baik', '2024-11-04 21:44:49', '2025-05-08 00:24:59'),
(42, '13', 'Over kapasitas penyimpanan CRC', NULL, 'I', 'PPIC & DELIVERY,PRODUCTION CKR', '', '2024-11-05', NULL, '2024-11-04 23:16:01', '2025-03-06 23:47:42'),
(43, '13', 'Over Kapasitas Penyimpanan Finish Goods', NULL, 'I', 'PPIC & DELIVERY,PRODUCTION CKR,SALES & MARKETING', '', '2024-01-05', 'Penyimpanan coil bisa mencapai 2x lipat dibandingkan sebelum ditumpuk', '2024-11-04 23:40:12', '2025-03-07 00:21:29'),
(45, '13', 'Packing coil tonase diatas 5 ton kesulitan karena kapasitas Crane di L8 4.7 ton dan forklif 5 ton', NULL, 'I', 'SALES & MARKETING,SUPPLY CHAIN & WAREHOUSE CKR', '', '2024-08-10', NULL, '2024-11-05 00:16:15', '2025-03-07 00:31:27'),
(48, '4', 'Lack Of Automation, electrical Technician Skill', NULL, 'I', 'MTC UTILIYY CKR,PRODUCTION CKR', '', '2025-04-30', NULL, '2024-11-05 21:35:34', '2025-05-14 23:28:22'),
(49, '4', 'Roll rubber dari original country qualitas redah /life time pendek 1 tahun', NULL, 'E', 'PRODUCTION CKR', '', '2025-03-06', NULL, '2024-11-05 21:44:58', '2025-05-14 23:29:51'),
(50, '4', 'Perkembangan Industry 4.0', NULL, 'E', 'PRODUCTION CKR', '', '2025-01-31', 'Digitalisasi system pemeliharaan', '2024-11-05 22:02:05', '2025-05-14 21:37:26'),
(51, '4', 'Environmental issues regarding effluent disposal', NULL, 'E', NULL, '', '2025-02-01', 'Penanaman sayuran saat musim kemarau', '2024-11-06 19:58:12', '2024-11-08 09:34:43'),
(53, '1', 'Revamping Main POT GL', NULL, 'I', 'MTC MEC & ELC CKR,PPIC & DELIVERY,PRODUCTION CKR,SALES & MARKETING', '', '2024-02-01', NULL, '2024-11-08 20:01:36', '2025-03-17 01:10:52'),
(54, '14', 'Over kapasitas warehouse penyimpanan Paint Feed', NULL, 'I', 'PRODUCTION SDG,QA SDG,SUPPLY CHAIN & WAREHOUSE SDG,EKSPOR & IMPOR,SAFETY SDG', '', '2024-12-31', NULL, '2024-11-08 20:21:04', '2024-11-08 20:21:04'),
(55, '1', 'Kapasitas Tension Reel 10 ton tidak maksimal hanya 8.5ton', NULL, 'I', 'PRODUCTION CKR', '', '2024-02-01', NULL, '2024-11-08 20:21:05', '2024-11-08 20:21:05'),
(56, '1', 'Pemenuhan Order Eksport dengan spec YS = 450 Mpa dan  Ts min 450 Mpa', NULL, 'E', 'PRODUCTION CKR,QA CKR,SALES & MARKETING,PPIC & DELIVERY', '', '2024-06-01', NULL, '2024-11-08 20:28:43', '2024-11-08 20:28:43'),
(57, '1', 'Launder PM sering ngeblock', NULL, 'I', 'MTC MEC & ELC CKR,PPIC & DELIVERY,PRODUCTION CKR', '', '2024-12-31', NULL, '2024-11-08 20:35:15', '2025-03-07 20:47:32'),
(58, '1', 'Speed saat running tipis 0.2 mm\r\nmenggunakan steel sleaves masih speed 100 mpm\r\nkarena pemasangan steel sleaves manual', NULL, 'I', 'PRODUCTION CKR', '', '2025-08-01', NULL, '2024-11-08 21:17:52', '2025-09-02 00:53:10'),
(59, '11', 'CRC / coil yang dikirim tidak sesuai dengan spesifikasi teknis', NULL, 'E', 'PPIC & DELIVERY,PROCUREMENT,PRODUCTION CKR,QA CKR,SALES & MARKETING', '', '2025-12-31', 'Line produksi maksimal, pengoperasian line entry lebih mudah', '2024-11-08 21:38:03', '2025-02-28 18:40:45'),
(60, '11', 'Hasil produksi yang dikirim ke customer tidak sesuai dengan spesifikasi', NULL, 'I', 'PRODUCTION CKR,QA CKR,SALES & MARKETING', '', '2025-12-31', 'Meningkatkan nilai produk di pasar', '2024-11-08 21:41:27', '2025-02-28 18:41:14'),
(61, '14', 'Over Kapasitas Penyimpanan Finish Goods', NULL, 'I', 'PRODUCTION SDG', '', '2024-07-31', NULL, '2024-11-09 21:19:19', '2025-05-09 22:38:53'),
(64, '11', 'Handling limbah B3 laboratorium', NULL, 'I', 'MTC MEC & ELC CKR,PRODUCTION CKR,QA CKR', '', '2025-12-31', 'Netralizing limbah basa yang ada di WWTP', '2024-11-10 18:50:33', '2025-02-28 18:41:38'),
(66, '11', 'Product painfeed yang di supply untuk Sadang tidak sesuai dengan requirement', NULL, 'I', 'PPIC & DELIVERY,PRODUCTION CKR,QA CKR,SALES & MARKETING', '', '2025-12-31', 'Menambah hasil/jenis produksi', '2024-11-10 18:58:29', '2025-02-28 18:42:06'),
(67, '11', 'Alat Uji & Ukur tidak terkalibrasi', NULL, 'I', 'PRODUCTION CKR,QA CKR', '', '2025-12-31', 'Bisa dapat sertifikasi \"KAN\" dan sertifikat produk, seperti JIS, SNI, SIRIM, dll', '2024-11-10 19:02:57', '2025-02-28 18:43:04'),
(68, '11', 'Pembuatan Produk Baru', NULL, 'I', 'PRODUCTION CKR,QA CKR,SALES & MARKETING', '', '2025-12-31', '1. Menambah hasil/jenis produksi 2. Menambah metode inspeksi untuk produk painfeed', '2024-11-10 19:08:58', '2025-02-28 18:43:28'),
(69, '11', 'Perbedaan standard customer export', NULL, 'I', 'PROCUREMENT,PRODUCTION CKR,QA CKR,SALES & MARKETING', '', '2025-12-31', 'Menambah kemampuan line untuk memproduksi type yang berbeda', '2024-11-10 19:11:45', '2025-02-28 18:43:55'),
(70, '11', 'Produksi type baru Galvanize Product', NULL, 'I', 'PRODUCTION CKR,QA CKR', '', '2025-12-31', 'Menambah kemampuan line untuk memproduksi type yang berbeda', '2024-11-10 19:14:56', '2025-02-28 18:44:20'),
(71, '11', 'Operator masih belum bisa menentukan status produk', NULL, 'I', 'PRODUCTION CKR,QA CKR', '', '2025-12-31', 'Operator dapat menentukan kualitas dan mengurangi produk on hold yang belum diputuskan', '2024-11-10 19:19:15', '2025-02-28 18:49:38'),
(72, '11', 'Bahan Baku CRC dari berbagai macam supplier', NULL, 'I', 'PROCUREMENT,PRODUCTION CKR,QA CKR', '', '2025-12-31', 'Mempunyai database terkait kualitas coil dari masing - masing supplier, pilihan / option penggunaan coil yang beragam, kebutuhan bahan baku produksi terpenuhi', '2024-11-10 19:22:39', '2025-02-28 18:50:06'),
(73, '2', 'Safety Area Mesin Produksi belum terpasang', NULL, 'I', 'PRODUCTION SDG,MTC MEC, ELC & UTL SDG,HR & GA SDG,QA SDG,SUPPLY CHAIN & WAREHOUSE SDG,SAFETY SDG', '', '2024-11-30', 'Intalasi Safe Access', '2024-11-10 19:28:34', '2024-11-27 21:08:52'),
(74, '2', 'Terbentuknya Limbah B3', NULL, 'I', 'PRODUCTION SDG', '', '2024-11-30', 'Citra perusahaan yang selalu menjaga lingkungan dengan baik', '2024-11-10 19:35:41', '2025-05-08 01:29:34'),
(75, '2', 'Perbedaan supplier Galvalume', NULL, 'E', 'PRODUCTION SDG', '', '2024-11-30', 'Produk dikirim sesuai dengan spesifikasi dan on time', '2024-11-10 19:39:01', '2025-05-08 01:30:07'),
(76, '14', 'Paint Feed Quality tidak masuk spesifikasi product.', NULL, 'I', 'PRODUCTION SDG,QA SDG,SUPPLY CHAIN & WAREHOUSE SDG,SALES & MARKETING', '', '2024-09-30', NULL, '2024-11-10 19:47:16', '2024-11-10 19:47:43'),
(77, '14', 'Stock Opname Sparepart hanya bisa dilakukan saat stopline lama, karena keterbatasan personel WH', NULL, 'I', 'ACCOUNTING,PRODUCTION SDG,SUPPLY CHAIN & WAREHOUSE SDG', '', '2024-12-31', NULL, '2024-11-10 19:52:17', '2025-03-04 15:13:33'),
(78, '14', 'Stock Opname bulanan Raw Material dan Finish Goods tidak berjalan karena tidak ada tim yg SO', NULL, 'I', 'ACCOUNTING,PRODUCTION SDG', '', '2024-12-31', NULL, '2024-11-10 19:55:10', '2025-05-09 02:27:43'),
(86, '2', 'Unwringkle spot di product Hitam lorentz', NULL, 'I', 'PRODUCTION SDG', '', '2025-01-31', NULL, '2024-11-27 21:20:19', '2024-11-27 21:20:19'),
(88, '7', 'Kebocoran Besar pada Tanki Amonia', NULL, 'I', 'PRODUCTION CKR,MTC UTILIYY CKR,SAFETY CKR', '', '2024-01-05', NULL, '2024-12-06 20:05:51', '2024-12-06 21:23:50'),
(90, '3', 'Instalasi Listrik di L8 tidak standard', NULL, 'I', 'MTC MEC & ELC CKR', '', '2024-12-31', NULL, '2024-12-06 20:38:03', '2024-12-06 20:38:03'),
(91, '28', 'Robotic Steel Sleeve tidak optimal', NULL, 'I', 'PRODUCTION CKR,MTC MEC & ELC CKR,ENGINEERING', '', '2026-01-05', NULL, '2024-12-06 20:43:09', '2024-12-06 20:43:09'),
(92, '10', 'Climate Change', NULL, 'E', 'HR & GA CKR,MTC UTILIYY CKR,PRODUCTION CKR,SAFETY CKR,SUPPLY CHAIN & WAREHOUSE CKR', '', '2024-01-01', '1. Migrasi sistem atau program ke online (Industry 4.0)\r\n2. Penerapan program penyukses Net Zero Emission\r\n3. Penerapan konsep Circular Economy\r\n4. Reduce limbah B3 dan non B3\r\n5. Penerapan konsep 3R\r\n6. Pengurangan emisi yang dihasilkan karena efisiensi pembakaran dan bahan baku', '2024-12-13 18:59:49', '2025-03-11 03:42:35'),
(93, '27', 'Climate Change', NULL, 'E', 'SAFETY SDG', '', '2024-10-10', 'Hemat energi', '2024-12-15 20:49:05', '2024-12-15 20:51:08'),
(94, '26', 'Laboratorium Uji dibawah perusahaan yg memproduksi barang yang diuji sehingga hasil uji dapat dipengaruhi oleh Team Produksi', NULL, 'I', 'LAB,PRODUCTION CKR', '', '2024-12-31', 'Hasil pengujian sesuai dengan quality plan dan meningkatkan kualitas hasil pengujian', '2024-12-15 21:46:51', '2025-03-02 21:52:45'),
(95, '26', 'Adanya tindak kecurangan di laboratorium', NULL, 'I', 'LAB', '', '2024-12-31', '1. Nilai uji yang dihasilkan sesuai\r\n2. Kepercayaan pelanggan terhadap hasil pengujian', '2024-12-15 21:51:53', '2025-06-01 19:49:13'),
(96, '26', 'Kaji ulang permintaan tidak dilakukan', NULL, 'I', 'LAB', '', '2024-12-31', 'Pengujian terlaksana sesuai kesepakatan', '2024-12-15 21:56:33', '2024-12-15 21:56:49'),
(97, '26', 'Tidak adanya keterangan pengujian apa yang dilakukan pada sampel yang diterima', NULL, 'I', 'LAB', '', '2024-12-31', 'Meningkatnya kepercayaan pelanggan terhadap hasil pengujian', '2024-12-15 22:00:41', '2024-12-15 22:00:57'),
(98, '26', 'Mesin untuk preparasi uji rusak', NULL, 'I', 'LAB', '', '2024-12-31', 'Dapat mengurangi antrian saat preparasi sampel', '2024-12-15 23:11:07', '2024-12-15 23:11:41'),
(99, '26', 'Petugas Pengujian melakukan pengujian tidak sesuai dengan Instruksi Kerja', NULL, 'I', 'LAB', '', '2024-12-31', '1. Petugas Pengujian terhindar dari unsafe action\r\n2. Operator memahami dan bekerja sesuai instruksi kerja\r\n3. Hasil pengujian tepat', '2024-12-15 23:15:59', '2024-12-15 23:16:34'),
(100, '26', 'Kalibrator tidak layak digunakan dikarenakan ada kotoran dan karat', NULL, 'I', 'LAB', '', '2024-12-31', '1. Kalibrator sesuai standard\r\n2. Verifikasi dan kalibrasi antara tidak menjadi lebih baik', '2024-12-15 23:20:28', '2024-12-15 23:22:15'),
(101, '26', 'Alat Uji & Ukur tidak terkalibrasi', NULL, 'I', 'LAB', '', '2024-12-31', 'Bisa dapat sertifikasi \"KAN\"', '2024-12-15 23:25:02', '2024-12-15 23:25:22'),
(102, '26', 'Alat uji di Laboratorium bermasalah sehingga tidak dapat digunakan', NULL, 'I', 'LAB', '', '2024-12-31', '1. Meningkatnya kepercayaan terhadap hasil pengujian yang dikeluarkan\r\n2. Hasil pengujian sesuai waktu', '2024-12-15 23:29:05', '2024-12-15 23:29:22'),
(103, '26', 'Perbedaan laporan hasil uji dengan data hasil uji', NULL, 'I', 'LAB', '', '2024-12-31', 'Pelanggan puas, tidak ada komplain', '2024-12-15 23:33:33', '2024-12-15 23:33:52'),
(104, '26', 'Integrasi Data Hasil Uji dengan Laporan Hasil Uji agar tidak terjadi salah input nilai', NULL, 'I', 'LAB', '', '2024-12-31', 'Efisiensi waktu saat menginput', '2024-12-15 23:43:58', '2024-12-15 23:43:58'),
(105, '26', 'Pelanggan menunggu hasil pengujian laboratorium akibat banyaknya antrian pengujian', NULL, 'I', 'LAB', '', '2024-12-31', 'Pengujian terlaksana sesuai kesepakatan', '2024-12-15 23:46:11', '2024-12-15 23:46:25'),
(106, '27', 'Standart Keselamatan Safety Kontraktor tidak ada', NULL, 'E', 'SAFETY SDG', '', '2024-11-08', NULL, '2024-12-16 18:11:44', '2024-12-16 18:11:44'),
(107, '27', 'Akses karyawan dengan kendaraan besar masih bersinggungan', NULL, 'I', 'SAFETY SDG', '', '2023-08-08', NULL, '2024-12-18 00:01:55', '2024-12-18 00:01:55'),
(109, '27', 'Sistem flow karyawan baru dan tamu terkait keselamatan belum ada', NULL, 'I', 'HR & GA SDG', '', '2023-09-09', NULL, '2024-12-20 01:08:23', '2024-12-20 01:08:23'),
(110, '27', 'Tempat sampah belum di pisah', NULL, 'I', 'HR & GA SDG', '', '2023-09-05', NULL, '2024-12-20 01:10:58', '2024-12-20 01:10:58'),
(111, '27', 'Sistem ERP belum terbentuk', NULL, 'I', 'SAFETY SDG', '', '2023-10-21', NULL, '2024-12-20 01:13:55', '2024-12-20 01:13:55'),
(112, '27', 'Operator crane dan forklift  belum memperpanjang sio dan masih ada yang belum mengikuti sertifikasi ke ahlian', NULL, 'I', 'SUPPLY CHAIN & WAREHOUSE SDG', '', '2023-11-02', NULL, '2024-12-20 01:16:29', '2024-12-20 01:16:29'),
(113, '27', 'Sistem MERP belum terbentuk', NULL, 'I', 'SAFETY SDG', '', '2024-11-30', NULL, '2024-12-20 01:19:26', '2024-12-20 01:19:26'),
(114, '27', 'Performance safety tahun 2023 kurang baik', NULL, 'I', 'SAFETY SDG', '', '2024-12-27', NULL, '2024-12-20 01:22:02', '2024-12-20 01:22:02'),
(115, '27', 'Kebisingan di beberapa titik', NULL, 'I', 'SAFETY SDG', '', '2024-01-19', NULL, '2024-12-20 01:24:32', '2024-12-20 01:24:32'),
(116, '27', 'Medical Check Up karyawan belum berjalan', NULL, 'I', 'SAFETY SDG', '', '2024-03-04', NULL, '2024-12-20 01:25:59', '2024-12-20 01:25:59'),
(117, '27', 'Sistem Proteksi Kebakaran,detector heat/smoke  di panel room belum ada', NULL, 'I', 'MTC MEC, ELC & UTL SDG,SAFETY SDG', '', '2024-03-04', NULL, '2024-12-20 01:28:28', '2024-12-20 01:28:28'),
(118, '27', 'Dapat teguran dari Disnaker terkait dengan pelaporan Triwulan', NULL, 'E', 'SAFETY SDG', '', '2024-03-08', NULL, '2024-12-20 01:30:29', '2024-12-20 01:30:29'),
(119, '27', 'Pintu Emergency terhalangi box Hydrant', NULL, 'I', 'SAFETY SDG', '', '2024-04-21', NULL, '2024-12-20 01:33:16', '2024-12-20 01:33:16'),
(120, '27', 'Driver tidak mendapatkan induction saat masuk ke area pabrik', NULL, 'I', 'HR & GA SDG,SUPPLY CHAIN & WAREHOUSE SDG', '', '2024-04-21', NULL, '2024-12-20 01:34:38', '2024-12-20 01:34:38'),
(121, '27', 'Belum ada evidence terkait monitoring lapangan', NULL, 'I', 'SAFETY SDG', '', '2024-05-15', NULL, '2024-12-20 01:35:48', '2024-12-20 01:35:48'),
(122, '27', 'Penggunaan sepeda bersinggungan langsung dengan kendaraan bermotor', NULL, 'I', 'SAFETY SDG', '', '2024-05-15', NULL, '2024-12-20 01:37:27', '2024-12-20 01:37:27'),
(123, '27', 'Manuver kendaraan besar sulit saat melewati gate keluar sehingga harus keluar lewat gate masuk', NULL, 'I', 'SUPPLY CHAIN & WAREHOUSE SDG', '', '2024-10-04', NULL, '2024-12-20 01:39:36', '2024-12-20 01:39:36'),
(124, '27', 'Orientasi untuk karyawan baru', NULL, 'I', 'HR & GA SDG', '', '2025-01-30', NULL, '2024-12-20 01:40:54', '2024-12-20 01:40:54'),
(126, '25', 'Penentuan Kontraktor Proyek-Penerimaan Quotation', NULL, 'E', NULL, '', '2025-03-31', NULL, '2025-02-04 00:04:54', '2025-02-04 00:05:31'),
(127, '25', 'Penentuan Kontraktor Proyek-Seleksi calon kontraktor', NULL, 'E', NULL, '', '2025-03-31', NULL, '2025-02-04 00:20:08', '2025-02-04 00:20:56'),
(128, '25', 'Penentuan Kontraktor Proyek-Penilaian Hasil Seleksi Calon Kontraktor', NULL, 'E', NULL, '', '2025-03-31', NULL, '2025-02-04 00:24:42', '2025-02-04 00:59:32'),
(129, '10', 'Belum ada sosialisasi terkait anti penyuapan (ISO 37001)', NULL, 'I', 'SAFETY CKR', '', '2025-03-03', NULL, '2025-02-25 20:06:10', '2025-02-25 20:06:10'),
(130, '27', 'Penggunaan kertas atau sistem laporan yang membutuhkan waktu lama', NULL, 'I', 'SAFETY SDG', '', '2025-03-01', NULL, '2025-02-27 23:59:54', '2025-02-27 23:59:54'),
(131, '27', 'Climate Change', NULL, 'I', 'SAFETY SDG', '', '2025-03-28', NULL, '2025-02-28 00:07:08', '2025-02-28 00:07:08'),
(132, '27', 'Belum ada sosialisasi terkait anti penyuapan (ISO 37001)', NULL, 'I', 'SAFETY SDG', '', '2025-03-28', NULL, '2025-02-28 00:10:01', '2025-02-28 00:10:01'),
(133, '11', 'Coil terkena tampias air hujan akibat cuaca tidak menentu', NULL, 'I', 'QA CKR,SUPPLY CHAIN & WAREHOUSE CKR', '', '2025-12-31', 'Tidak terdapat rust pada coil', '2025-02-28 18:37:30', '2025-02-28 18:54:21'),
(134, '12', 'Paintfeed yang dikirim tidak sesuai dengan spesifikasi teknis', NULL, 'E', 'PROCUREMENT,PRODUCTION SDG,QA SDG', '', '2025-12-31', 'Bisa dilakukan utilisasi pada coil yang akan dirunning', '2025-02-28 19:54:57', '2025-05-13 18:38:21'),
(135, '12', 'Hasil produksi yang dikirim ke customer tidak sesuai dengan spesifikasi', NULL, 'I', 'PRODUCTION SDG,QA SDG', '', '2025-12-31', NULL, '2025-02-28 19:57:43', '2025-05-13 18:39:20'),
(136, '12', 'Alat Uji & Ukur tidak terkalibrasi eksternal', NULL, 'I', 'PRODUCTION SDG,QA SDG', '', '2025-12-31', 'Dilakukan verifikasi pada alat uji dan alat ukur', '2025-02-28 20:01:20', '2025-05-13 18:41:56'),
(137, '12', 'Pembuatan Produk Baru', NULL, 'I', 'PRODUCTION SDG,QA SDG', '', '2025-12-31', NULL, '2025-02-28 20:25:58', '2025-05-13 18:44:54'),
(138, '12', 'Produksi type cat dan warna baru', NULL, 'I', 'PRODUCTION SDG,QA SDG', '', '2025-12-31', NULL, '2025-02-28 20:45:52', '2025-05-13 18:46:15'),
(139, '12', 'Operator masih belum bisa menentukan status produk', NULL, 'I', 'PRODUCTION SDG,QA SDG', '', '2025-12-31', NULL, '2025-02-28 20:48:33', '2025-05-13 18:48:35'),
(140, '12', 'Bahan Baku dari berbagai macam supplier', NULL, 'E', 'PROCUREMENT,PRODUCTION SDG,QA SDG', '', '2025-12-31', 'Bisa memanfaatkan material dari supplier yang sudah ada', '2025-02-28 20:53:23', '2025-05-13 18:51:33'),
(141, '12', 'Perbedaan standard ekspor', NULL, 'I', 'PROCUREMENT,PRODUCTION SDG,QA SDG', '', '2025-12-31', 'Ekuivalen dengan standar existing, seperti SNI, JIS', '2025-02-28 20:55:30', '2025-05-13 18:52:50'),
(142, '12', 'Supplier paintfeed Baru', NULL, 'E', 'PROCUREMENT,PRODUCTION SDG,QA SDG', '', '2025-12-31', 'Bisa menggunakan paintfeed dari supplier yang sudah ada', '2025-02-28 20:57:35', '2025-05-13 19:05:39'),
(144, '12', 'Tooling produksi oleh customer', NULL, 'I', 'PROCUREMENT,PRODUCTION SDG,QA SDG', '', '2025-12-31', NULL, '2025-02-28 21:01:38', '2025-05-13 19:16:04'),
(145, '12', 'Limbah B3 tidak ditempatkan pada sampah B3', NULL, 'I', 'QA SDG', '', '2025-12-31', NULL, '2025-02-28 21:05:11', '2025-05-13 19:22:09'),
(146, '12', 'Bahan-bahan kimia yang digunakan untuk pengujian tidak ada label dan MSDS/tanda bahaya', NULL, 'I', 'QA SDG,SAFETY SDG', '', '2025-12-31', NULL, '2025-02-28 21:07:01', '2025-05-13 19:31:21'),
(147, '12', 'Hasil produksi yang dikirim tidak sesuai spesifikasi di tata logam', NULL, 'I', 'PRODUCTION SDG,QA SDG', '', '2025-12-31', NULL, '2025-02-28 21:11:29', '2025-05-13 19:30:51'),
(149, '3', 'Brick dan Castable GL pot kondisinya tidak cukup baik. Sudah terdorong kedalam dan steel casing juga bending', NULL, 'I', 'ENGINEERING,MTC MEC & ELC CKR,PRODUCTION CKR', '', '2025-03-03', NULL, '2025-02-28 22:42:12', '2025-03-02 23:53:32'),
(151, '3', 'Exit Inductor PM Pot tiba 2x di bulan Agustus 2023, terjadi penurunan nilai ratio sisi inductor Exit sampai ke 0,75 sedangkan waktu itu sisi Entry masih di angka 0,93.\r\nNote: Penggantian Inductor baru dilakukan bulan Juni 2022', NULL, 'I', 'ENGINEERING,MTC MEC & ELC CKR,PRODUCTION CKR', '', '2026-01-03', NULL, '2025-03-03 01:34:09', '2025-03-03 01:34:09'),
(152, '14', 'Over kapasitas paint feed storage dan finish product storage terdampak dari penambahan mesin slitting di area kolom B16 - B20', NULL, 'I', 'PRODUCTION SDG,QA SDG,SAFETY SDG', '', '2025-06-07', NULL, '2025-03-04 15:23:30', '2025-05-09 19:39:28'),
(153, '14', 'Penyuapan dan Gratifikasi pada proses pemilihan paint supplier', NULL, 'E', 'PROCUREMENT,PRODUCTION SDG,QA SDG,SUPPLY CHAIN DAN WAREHOUSE SDG', '[null,null,null,null]', '2025-03-31', NULL, '2025-03-04 16:40:53', '2025-07-31 00:40:24'),
(154, '12', 'Ketahanan coil warna terhadap lingkungan (Tropical Discoloration)', NULL, 'I', 'PRODUCTION SDG,QA SDG', '', '2025-12-31', NULL, '2025-03-04 18:49:15', '2025-05-13 19:42:41'),
(155, '13', 'Penyimpanan Coil dengan metode Double Stack (ditumpuk)', NULL, 'I', 'PRODUCTION CKR,SUPPLY CHAIN & WAREHOUSE CKR', '', '2025-04-01', 'Kapasitas penyimpanan barang menjadi 2x lipat lebih banyak', '2025-03-06 04:32:29', '2025-03-06 04:50:19'),
(156, '13', 'Proses packing dan stuffing untuk coil-coil dengan pengiriman secara break bulk', NULL, 'E', 'EKSPOR & IMPOR,SALES & MARKETING', '', '2025-03-31', NULL, '2025-03-06 04:36:25', '2025-03-06 04:36:25'),
(157, '13', 'Pengambilan Finish Goods Oleh Cust Lokal menggunakan ekspedisi yang tidak standar', NULL, 'E', 'SAFETY CKR,SALES & MARKETING,SUPPLY CHAIN & WAREHOUSE CKR', '', '2025-03-20', NULL, '2025-03-06 04:43:39', '2025-03-06 04:43:39'),
(158, '13', 'Import alluminium dan Zinc melebihi kapasitas Layout', NULL, 'E', 'EKSPOR & IMPOR,PPIC & DELIVERY,PRODUCTION CKR', '', '2025-03-13', NULL, '2025-03-06 05:17:41', '2025-03-06 05:17:41'),
(159, '13', 'Gas buang forklif, trailer dan ekspedisi luar', NULL, 'I', 'SAFETY CKR,SUPPLY CHAIN & WAREHOUSE CKR', '', '2024-03-22', NULL, '2025-03-06 05:22:12', '2025-03-07 01:26:06'),
(160, '13', 'Ceceran Olie dari forklif dan crane', NULL, 'I', 'MTC MEC & ELC CKR,SAFETY CKR,SUPPLY CHAIN & WAREHOUSE CKR', '', '2025-03-20', NULL, '2025-03-06 05:24:45', '2025-03-06 05:24:45'),
(161, '13', 'Limbah B3', NULL, 'I', 'SUPPLY CHAIN & WAREHOUSE CKR', '', '2025-03-20', NULL, '2025-03-06 05:45:38', '2025-03-07 21:51:06'),
(162, '13', 'Tempat penyimpanan resin menjadi satu dengan coil', NULL, 'I', 'SAFETY CKR,SUPPLY CHAIN & WAREHOUSE CKR', '', '2024-02-01', NULL, '2025-03-06 05:50:25', '2025-03-07 21:54:38'),
(163, '13', 'Stock Opname bulanan BB dan Finish Goods tidak berjalan karena tidak ada tim yg SO', NULL, 'I', 'SUPPLY CHAIN & WAREHOUSE CKR', '', '2025-02-18', NULL, '2025-03-06 21:07:24', '2025-03-06 21:07:24'),
(164, '13', 'Stock Opname seluruh Sparepart hanya bisa dilakukan saat stopline dalam jangka lama, karena keterbatasan personel WH (satu tahun 2x)', NULL, 'I', 'SUPPLY CHAIN & WAREHOUSE CKR', '', '2024-11-12', NULL, '2025-03-06 21:27:42', '2025-03-06 21:27:42'),
(165, '13', 'Produk damage akibat handling Crane maupun Forklift', NULL, 'I', 'SUPPLY CHAIN & WAREHOUSE CKR', '', '2025-02-21', NULL, '2025-03-06 21:34:59', '2025-03-06 21:34:59'),
(166, '13', 'Kecelakaan kerja', NULL, 'I', 'SUPPLY CHAIN & WAREHOUSE CKR', '', '2020-01-02', NULL, '2025-03-06 23:08:10', '2025-03-07 22:07:53'),
(167, '13', 'Limbah kayu bekas Unloading Impor Ingot', NULL, 'I', 'SUPPLY CHAIN & WAREHOUSE CKR', '', '2021-01-01', NULL, '2025-03-06 23:45:29', '2025-03-07 22:09:57'),
(168, '1', 'Pencemaran udara dari emisi produksi', NULL, 'I', 'PRODUCTION CKR,SAFETY CKR', '', '2025-12-31', NULL, '2025-03-16 21:44:56', '2025-03-17 00:38:18'),
(169, '1', 'Limbah cair yang tidak terkelola dengan baik', NULL, 'I', 'PRODUCTION CKR', '', '2025-12-31', NULL, '2025-03-16 21:47:12', '2025-03-16 21:48:07'),
(175, '1', 'Pengelolaan limbah padat yang buruk', NULL, 'I', 'PRODUCTION CKR', '', '2025-12-31', NULL, '2025-03-16 23:18:42', '2025-03-16 23:18:42'),
(176, '7', 'Potensi Kebocoran di Natural Gas', NULL, 'I', 'MTC UTILIYY CKR,PRODUCTION CKR', '', '2025-03-17', NULL, '2025-03-16 23:21:27', '2025-03-16 23:21:27'),
(177, '1', 'Kebocoran bahan kimia berbahaya', NULL, 'I', 'PRODUCTION CKR', '', '2025-12-31', NULL, '2025-03-16 23:28:52', '2025-03-16 23:28:52'),
(178, '1', 'Kebisingan berlebih dari mesin produksi', NULL, 'I', 'PRODUCTION CKR', '', '2025-12-31', NULL, '2025-03-17 00:16:29', '2025-03-17 00:16:29'),
(179, '7', 'Freon AC\r\nPembuangan freon dan Freon R22', NULL, 'I', 'MTC UTILIYY CKR', '', '2025-03-17', 'pengurangan polusi udara', '2025-03-17 00:19:24', '2025-03-17 00:19:24'),
(180, '1', 'Konsumsi energi berlebih', NULL, 'I', 'PRODUCTION CKR', '', '2025-12-31', NULL, '2025-03-17 00:28:08', '2025-03-17 00:28:08'),
(181, '1', 'Pencemaran akibat kebocoran minyak atau bahan bakar', NULL, 'I', 'PRODUCTION CKR', '', '2025-12-31', NULL, '2025-03-17 00:32:10', '2025-03-17 00:32:10'),
(182, '1', 'Ketidakpatuhan terhadap regulasi lingkungan', NULL, 'I', 'PRODUCTION CKR', '', '2025-12-31', NULL, '2025-03-17 00:35:05', '2025-03-17 00:35:05'),
(183, '1', 'Penggunaan air yang berlebihan', NULL, 'I', 'MTC UTILIYY CKR,PRODUCTION CKR', '', '2025-12-17', NULL, '2025-03-17 00:58:21', '2025-03-17 01:40:28'),
(184, '1', 'Risiko kebakaran akibat limbah atau bahan mudah terbakar', NULL, 'I', 'PRODUCTION CKR', '', '2025-12-17', NULL, '2025-03-17 00:59:41', '2025-03-17 00:59:41'),
(185, '3', 'Belum konsisten dalam pelaksanaan Safety Procedure', NULL, 'I', 'HR & GA CKR,MTC MEC & ELC CKR,SAFETY CKR', '', '2025-04-05', NULL, '2025-03-17 01:22:10', '2025-03-18 00:30:15'),
(186, '7', 'Air Sungai \r\nmenjaga kelestarian disekitaran sungai', NULL, 'E', 'MTC UTILIYY CKR,BBWS , Jasa tirta', '', '2025-03-17', 'pemanfaatan air sungai', '2025-03-17 01:44:48', '2025-03-17 01:44:48'),
(187, '7', 'Kapasitas RO tidak mencukupi jika full capacity pemakaian SPM (I)', NULL, 'I', 'MTC UTILIYY CKR,PRODUCTION CKR', '', '2025-03-17', NULL, '2025-03-17 18:50:21', '2025-03-17 18:50:21'),
(188, '3', 'Lack of skill teknisi', NULL, 'I', 'MTC MEC & ELC CKR,PRODUCTION CKR', '', '2025-04-05', NULL, '2025-03-18 00:19:24', '2025-03-18 00:19:24'),
(189, '3', 'Pandemi Covid 19', NULL, 'E', 'MTC MEC & ELC CKR,PRODUCTION CKR', '', '2022-07-18', NULL, '2025-03-18 01:11:06', '2025-03-18 01:11:06'),
(190, '3', 'Kesiapan Pompa Metal (Emergency tools)', NULL, 'I', 'MTC MEC & ELC CKR,PRODUCTION CKR', '', '2025-04-05', NULL, '2025-03-18 02:13:06', '2025-03-18 02:13:06'),
(191, '3', 'Kondisi Brick dan Castable GL pot yang tidak cukup sehat', NULL, 'I', 'MTC MEC & ELC CKR,PRODUCTION CKR', '', '2025-04-05', NULL, '2025-03-18 02:19:49', '2025-03-18 02:19:49'),
(192, '3', 'Performance KG Crane yang kurang Reliable', NULL, 'I', 'MTC MEC & ELC CKR,PRODUCTION CKR', '', '2025-04-05', NULL, '2025-03-19 20:43:10', '2025-03-19 20:46:37'),
(193, '3', 'Crane Slitting dan Crane Potgear Workshop digunakan bergantian', NULL, 'I', 'MTC MEC & ELC CKR,PRODUCTION CKR', '', '2025-04-05', NULL, '2025-03-19 21:12:02', '2025-03-19 21:12:02'),
(194, '3', 'Oil Leakage pada peralatan hydarulic', NULL, 'I', 'MTC MEC DAN ELC CKR,PRODUCTION CKR', '', '2025-12-31', NULL, '2025-03-24 20:44:06', '2025-03-24 20:44:06'),
(195, '3', 'Belum mendapatkan workshop Hardchromed yang berkualitas untuk roll TL', NULL, 'E', 'MTC MEC DAN ELC CKR,PRODUCTION CKR', '', '2025-03-15', 'develop unchrommed roll untuk di TL', '2025-03-24 20:57:18', '2025-03-24 20:59:12'),
(196, '3', 'Proses Preventive Maintenance crane berada di atas Kantor/ruangan dan Crane 10 T WH bisa bergerak sampai di atas Kantor', NULL, 'I', 'MTC MEC DAN ELC CKR,PRODUCTION CKR,SAFETY CKR', '', '2025-04-05', 'Pindahkan kantor ke area yg lebih aman (All tray)', '2025-03-24 21:04:02', '2025-03-24 21:06:23'),
(197, '3', 'Mendapatkan suplai bearing yang asli', NULL, 'I', 'MTC MEC DAN ELC CKR', '', '2025-01-01', 'Contract supplier bearing atas Nama TataLogam Group', '2025-03-24 21:13:26', '2025-03-24 21:14:48'),
(198, '3', 'Tidak ada Man Power yang berpengalaman dari PT. Giken', NULL, 'E', 'MTC MEC DAN ELC CKR,PRODUCTION CKR', '', '2025-06-30', '1.Replace with other qualified crane product\r\n2.Crane motor and Gearbox masuk dalam monitoring team CONMON', '2025-03-26 00:19:58', '2025-03-26 00:24:12'),
(199, '3', 'Dampak Climate Change, mengakibatkan sering terjadi Cuaca ekstrem (hujan deras, suhu tinggi) menambah resiko dalam perjalanan Pulang pergi ke Pabrik', NULL, 'E', 'MANUFACTURING', '', '2025-03-31', NULL, '2025-03-26 01:02:34', '2025-03-26 01:02:34'),
(200, '3', 'Kenaikan suhu lingkungan mempercepat Dehidrasi dan berkurangnya konsentrasi saat bekerja.', NULL, 'E', 'MANUFACTURING', '', '2025-03-01', NULL, '2025-03-26 01:07:15', '2025-03-26 01:07:15'),
(201, '3', 'Vendor Selection (Pengadaan barang dan Jasa Kontraktor)', NULL, 'E', 'MTC MEC DAN ELC CKR,PROCUREMENT', '', '2025-03-31', NULL, '2025-03-26 01:14:34', '2025-03-26 01:14:34'),
(206, '3', 'Running 0,2 mm dengan menggunakan new konfigurasi pot gear', NULL, 'I', 'MTC MEC DAN ELC CKR,PRODUCTION CKR', '', '2024-12-31', NULL, '2025-03-26 01:23:34', '2025-03-26 01:23:34'),
(208, '3', 'Kabel GL POT Broken di Cable tray underground POT', NULL, 'I', 'MANUFACTURING,MTC MEC DAN ELC CKR,PRODUCTION CKR', '', '2025-06-30', NULL, '2025-04-18 22:25:36', '2025-04-18 22:25:36'),
(209, '3', 'Spare Parts CWG Mahal dan harus Order ke Germany', NULL, 'I', 'MANUFACTURING,MTC MEC DAN ELC CKR,PRODUCTION CKR,QA CKR', '', '2026-06-30', NULL, '2025-04-20 00:36:32', '2025-04-20 00:36:32'),
(210, '3', 'Produk Export beberapa menggunakan Branding UV', NULL, 'I', 'MANUFACTURING,MTC MEC DAN ELC CKR,PRODUCTION CKR', '', '2025-05-31', NULL, '2025-04-20 00:48:46', '2025-04-20 00:48:46'),
(211, '3', 'System Proteksi Ruangan Panel Listrik dan tindakan mitigasi apabila terjadi kebakaran diruangan panel', NULL, 'I', 'MTC MEC DAN ELC CKR', '', '2025-12-31', NULL, '2025-04-20 02:13:25', '2025-04-20 02:13:25'),
(212, '3', 'Condition Monitoring (Bearing Motor macet/Lilitan Motor kebakar, atau Kabel/busbar Connection Panas)', NULL, 'I', 'MANUFACTURING,MTC MEC DAN ELC CKR,PRODUCTION CKR', '', '2025-12-31', NULL, '2025-04-20 02:35:58', '2025-04-20 02:35:58'),
(213, '3', 'Condition Monitoring (Bearing Motor macet/Lilitan Motor kebakar, atau Kabel/busbar Connection Panas)', NULL, 'I', 'MTC MEC DAN ELC CKR', '', '2025-02-28', 'Industry 4.0\r\nPenambahan Sensor Vibration Monitoring untuk membantu Monitor Equipment yang sudah menurun kondisi', '2025-04-20 02:40:41', '2025-04-20 02:40:41'),
(217, '1', 'Perubahan Iklim', NULL, 'E', 'PRODUCTION CKR', '', '2025-05-31', NULL, '2025-05-06 02:06:27', '2025-05-06 02:06:27'),
(218, '2', 'Kebakaran di ruangan coater', NULL, 'I', 'PRODUCTION SDG,SALES DAN MARKETING', '', '2024-11-18', 'Produk dikirim ke customer sesuai dengan rencana', '2025-05-06 05:38:12', '2025-05-08 01:31:27'),
(219, '2', 'Operator belum pengalaman dalam pengoperasian line', NULL, 'I', 'PRODUCTION SDG', '', '2023-12-28', 'Produk dikirim sesuai dengan spesifikasi dan on time', '2025-05-06 19:38:00', '2025-05-08 01:31:58'),
(220, '2', 'Terdapat defect di raw material Galvalume', NULL, 'I', 'QA SDG', '', '2024-12-23', 'Produk dikirim sesuai dengan spesifikasi dan tidak ada complaint', '2025-05-06 21:28:13', '2025-05-08 01:35:56'),
(221, '2', 'Quality defect di Product', NULL, 'I', 'QA SDG', '', '2024-11-25', 'Produk dikirim sesuai dengan spesifikasi dan on time', '2025-05-07 00:06:47', '2025-05-08 01:36:31'),
(222, '2', 'Kekurangan Operator yang kompetent dalam menjalankan equipment', NULL, 'I', 'PRODUCTION SDG,QA SDG', '', '2024-07-22', 'Produk dikirim sesuai dengan spesifikasi, tidak ada complaint, dan tidak ada kerusakan pada equipment', '2025-05-07 00:14:37', '2025-05-08 01:37:00'),
(223, '2', 'Kekurangan Material painted', NULL, 'E', 'SUPPLY CHAIN DAN WAREHOUSE SDG', '', '2025-05-31', 'Terpenuhi order customer sesuai dengan plannning', '2025-05-07 03:07:52', '2025-05-08 01:37:32'),
(224, '2', 'Stok cat tidak akurat', NULL, 'E', 'SUPPLY CHAIN DAN WAREHOUSE SDG', '', '2025-05-31', 'Terpenuhi order customer sesuai dengan plannning', '2025-05-07 03:10:07', '2025-05-08 01:40:26'),
(225, '2', 'Kerusakan pada Mesin', NULL, 'I', 'SALES DAN MARKETING,SUPPLY CHAIN DAN WAREHOUSE SDG', '', '2025-05-31', 'Product dikirim ke customer sesuai dengan planning', '2025-05-07 03:21:04', '2025-05-08 01:41:03'),
(226, '2', 'Perubahan suhu yang cukup ekstrim  di dalam ruangan coater menyebabkan viskositas cat berubah', NULL, 'I', 'QA SDG', '', '2024-09-30', 'Penggunaan automatic viscocity controller', '2025-05-07 19:38:07', '2025-05-08 01:41:37'),
(227, '2', 'Pemakaian kertas untuk document (IK, Reporting) dikarenakan penebangan pohon', NULL, 'I', 'PRODUCTION SDG', '', '2024-01-22', 'Digitalisasi', '2025-05-07 19:45:20', '2025-05-08 01:46:41'),
(228, '2', 'Pemakaian sumber energy Natural Gas', NULL, 'I', 'PRODUCTION SDG', '', '2024-10-28', 'Reduce Konsumsi Gas dengan optimalisasi by pass RTO', '2025-05-07 19:56:28', '2025-05-08 01:47:21'),
(229, '2', 'Praktek penyuapan dalam pengadaan equipment produksi', NULL, 'I', 'PRODUCTION SDG', '', '2024-11-18', NULL, '2025-05-07 20:00:15', '2025-05-07 20:00:15'),
(230, '2', 'Thermocouple RTO error reading', NULL, 'I', 'MTC MEC, ELC DAN UTL SDG,PRODUCTION SDG', '', '2024-10-28', NULL, '2025-05-07 20:05:46', '2025-05-07 20:05:46'),
(231, '2', 'EPC error', NULL, 'I', 'MTC MEC, ELC DAN UTL SDG,PRODUCTION SDG', '', '2024-11-30', NULL, '2025-05-07 20:18:26', '2025-05-07 20:18:26'),
(232, '7', 'Unloading N2 liquid (I)', NULL, 'I', 'MTC UTILIYY CKR', '', '2020-01-13', NULL, '2025-05-07 20:24:18', '2025-05-07 20:24:18'),
(233, '2', 'Paint feed center buckle', NULL, 'I', 'PRODUCTION SDG,QA SDG', '', '2024-10-21', 'Running di Head B', '2025-05-07 20:44:22', '2025-05-08 01:48:48'),
(234, '7', 'Unloading NH3 (i)', NULL, 'I', 'MTC UTILIYY CKR', '', '2025-01-27', NULL, '2025-05-07 20:50:19', '2025-05-07 20:50:19'),
(235, '2', 'Paint feed edge wave', NULL, 'I', 'PRODUCTION SDG,QA SDG', '', '2024-11-30', 'Running di Head B', '2025-05-07 20:53:56', '2025-05-08 01:57:02'),
(236, '2', 'Paint feed ripple', NULL, 'I', 'PRODUCTION SDG,QA SDG', '', '2024-11-30', 'Produce top only material', '2025-05-07 20:58:55', '2025-05-08 01:57:50'),
(237, '2', 'Catenary sensor error\r\n-Error reading sensor\r\n- SP actual HMI dengan pembacaan actual sensor berbeda karena perubahan program PLC', NULL, 'I', 'PRODUCTION SDG', '', '2024-12-30', 'Penggunaan brand lain (Keyence)', '2025-05-07 21:03:37', '2025-05-08 01:58:15'),
(238, '2', 'Product undercure karena SP tidak sesuai dengan size dan line speed', NULL, 'I', 'PRODUCTION SDG', '', '2024-12-30', 'Automation L3 system', '2025-05-07 21:09:02', '2025-05-08 01:58:44'),
(239, '7', 'Potensi Kebakaran di Ruangan Tangki solar (I)', NULL, 'I', 'MTC UTILIYY CKR', '', '2023-03-27', NULL, '2025-05-07 23:12:55', '2025-05-07 23:12:55'),
(240, '7', 'Pengisian Amoniak terlalu penuh Sehingga tidak bisa menghasilkan uap untuk proses produksi', NULL, 'I', 'MTC UTILIYY CKR,PRODUCTION CKR,SAFETY CKR', '', '2019-12-02', NULL, '2025-05-08 00:04:05', '2025-05-08 00:04:05'),
(241, '7', 'Kebocoran listrik pada Electrical Equipment area Utility (I)', NULL, 'I', 'MTC MEC DAN ELC CKR,MTC UTILIYY CKR,SAFETY CKR', '', '2024-05-13', NULL, '2025-05-08 00:11:23', '2025-05-08 00:11:23'),
(242, '7', 'Tidak di ijinkan mengambil air sungai untuk di bulan Agustus dan September (E)', NULL, 'E', 'HR GA CKR,MANUFACTURING,MTC UTILIYY CKR', '', '2021-05-10', NULL, '2025-05-08 00:40:24', '2025-05-08 00:40:24'),
(243, '14', 'Penggunaan dan Pembelian Material Packing yang tinggi.\r\n- Kertas VCI\r\n- Pallet', NULL, 'I', 'EKSPOR DAN IMPOR,PROCUREMENT,PRODUCTION SDG,SALES DAN MARKETING,SUPPLY CHAIN DAN WAREHOUSE SDG', '', '2025-01-31', 'Menggunakan alternatif pallet dari material lain', '2025-05-09 19:34:11', '2025-05-09 19:36:57'),
(244, '7', 'Climate Change\r\npemanfaatan air hujan', NULL, 'I', 'MTC MEC DAN ELC CKR,MTC UTILIYY CKR', '', '2025-06-15', 'pemanfaatan air hujan', '2025-05-12 19:18:53', '2025-05-12 19:18:53'),
(245, '7', 'Bribery', NULL, 'I', 'MTC UTILIYY CKR', '', '2025-06-14', NULL, '2025-05-12 20:23:14', '2025-05-12 20:23:14'),
(246, '4', 'Penyuapan dan gratifikasi', NULL, 'E', 'ACCOUNTING,EKSPOR DAN IMPOR,ENGINEERING,HR GA CKR,HR GA SDG,INVOICING,LAB,MANUFACTURING,MTC MEC DAN ELC CKR,MTC MEC, ELC DAN UTL SDG,MTC UTILIYY CKR,PPIC DAN DELIVERY,PROCUREMENT,PRODUCTION CKR,PRODUCTION SDG,QA CKR,QA SDG,SAFETY CKR,SAFETY SDG,SALES DAN MARKETING,SUPPLY CHAIN DAN WAREHOUSE CKR,SUPPLY CHAIN DAN WAREHOUSE SDG,TREASURY', '', '2026-01-01', NULL, '2025-05-14 21:30:56', '2025-05-14 21:30:56'),
(247, '14', 'Ratio Overtime >30% selama 3 bulan berturut-turut', NULL, 'I', 'HR GA SDG,PRODUCTION SDG,SAFETY SDG,SUPPLY CHAIN DAN WAREHOUSE SDG', '', '2025-07-31', NULL, '2025-05-14 22:20:22', '2025-05-14 22:20:22'),
(248, '18', 'Perubahan iklim memengaruhi kualitas bahan baku dari supplier (misalnya material CRC jadi basah karena hujan terus-menerus, rusak karena suhu ekstrem)', NULL, 'E', 'PRODUCTION CKR,PRODUCTION SDG,QA CKR,QA SDG', '', '2025-07-10', 'Peluang untuk membangun standar mutu bersama dengan supplier agar kualitas tetap terjaga meski dalam kondisi cuaca ekstrem', '2025-05-27 19:58:10', '2025-05-27 20:10:21'),
(249, '22', 'Program Budgeting belum berjalan', NULL, 'I', 'ACCOUNTING,BUSSINESS ANALYST,EKSPOR DAN IMPOR,ENGINEERING,HR GA CKR,HR GA SDG,INVOICING,IT,LAB,MANUFACTURING,MTC MEC DAN ELC CKR,MTC MEC, ELC DAN UTL SDG,MTC UTILIYY CKR,PPIC DAN DELIVERY,PROCUREMENT,PRODUCTION CKR,PRODUCTION SDG,QA CKR,QA SDG,SAFETY CKR,SAFETY SDG,SALES DAN MARKETING,SUPPLY CHAIN DAN WAREHOUSE CKR,SUPPLY CHAIN DAN WAREHOUSE SDG,TES DEPARTEMEN,TREASURY', '', '2025-06-30', NULL, '2025-05-27 19:58:21', '2025-05-27 19:58:21'),
(251, '19', 'Banyak Revisi Rencana Produksi :  - Keterlambatan Raw Material, Repriority dari Customer, PLN Trip', NULL, 'E', 'PPIC DAN DELIVERY,MANAJEMEN', '', '2025-05-28', NULL, '2025-05-27 20:35:51', '2025-05-27 21:25:21'),
(252, '19', 'Banyak Revisi Rencana Produksi :  -  Dipengaruhi oleh Mesin trouble', NULL, 'I', 'MANAJEMEN,PPIC DAN DELIVERY', '', '2025-05-28', NULL, '2025-05-27 20:47:31', '2025-05-27 20:47:31'),
(254, '19', 'Bahan Baku & Bahan pendukung < Kebutuhan termasuk impact dari issue Global (harga, politik, keamanan,dll)', NULL, 'E', 'MANAJEMEN', '', '2025-05-28', NULL, '2025-05-27 21:06:40', '2025-05-27 21:06:40'),
(255, '18', 'Potensi Suap atau Gratifikasi dalam Pemilihan Supplier', NULL, 'E', 'PPIC DAN DELIVERY,PROCUREMENT,QA CKR,QA SDG,SUPPLY CHAIN DAN WAREHOUSE CKR,SUPPLY CHAIN DAN WAREHOUSE SDG', '', '2025-06-02', NULL, '2025-05-27 21:13:18', '2025-05-27 21:13:18'),
(256, '18', 'Potensi Suap atau Gratifikasi dalam Pemilihan Supplier', NULL, 'E', 'PPIC DAN DELIVERY,PROCUREMENT,PRODUCTION CKR,PRODUCTION SDG,QA CKR,QA SDG,SUPPLY CHAIN DAN WAREHOUSE CKR,SUPPLY CHAIN DAN WAREHOUSE SDG', '', '2025-06-02', '- Implementasi Sistem Evaluasi Supplier yang Transparan\r\n\r\n- Meningkatkan kepercayaan stakeholder, memastikan pemilihan supplier yang lebih kompetitif dan objektif', '2025-05-27 21:15:03', '2025-05-27 21:15:03'),
(257, '15', 'Standarisasi produk baja lapis paduan seng dan aluminium ( E )', NULL, 'E', 'BUSSINESS ANALYST,EKSPOR DAN IMPOR,MANAJEMEN,PPIC DAN DELIVERY,PROCUREMENT,PRODUCTION CKR,PRODUCTION SDG,QA CKR,QA SDG,SALES DAN MARKETING,SUPPLY CHAIN DAN WAREHOUSE CKR,SUPPLY CHAIN DAN WAREHOUSE SDG', '', '2020-06-12', 'Compliance ( Kepatuhan ) \r\nKunci Utama untuk memasuki pasaran scr commercial', '2025-05-27 21:24:29', '2025-05-27 21:56:14'),
(261, '1', 'cinecwjd cd', NULL, 'I', 'PRODUCTION CKR', '[\"-\"]', '2025-09-04', 'ncwunck chjwnd c', '2025-09-04 01:49:33', '2025-09-05 18:03:39'),
(262, '1', 'tezzzzz', 'tezzzzz', 'I', 'PRODUCTION CKR', '[\"--------\"]', '2025-09-06', NULL, '2025-09-05 18:18:52', '2025-09-05 18:18:52'),
(263, '1', 'tezzz pdf', 'tezzzz pdf', 'I', 'PRODUCTION CKR', '[\"tezzzzzzz\"]', '2025-09-16', NULL, '2025-09-15 19:16:28', '2025-09-15 19:16:28');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_statusppk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `nama_statusppk`, `created_at`, `updated_at`) VALUES
(1, 'OPEN', '2024-12-10 21:56:19', '2024-12-10 21:56:19'),
(2, 'CLOSE', '2024-12-10 21:56:29', '2024-12-10 21:56:29'),
(3, 'CLOSE (Tidak Efektif)', '2024-12-10 21:56:59', '2024-12-10 21:56:59'),
(4, 'CANCEL', '2024-12-10 21:57:13', '2024-12-10 21:57:13'),
(5, 'OPEN (Lewat Tanggal)', '2024-12-10 21:57:39', '2024-12-10 21:57:39'),
(6, 'BELUM DIJAWAB', '2024-12-10 21:57:56', '2024-12-10 21:57:56'),
(7, 'IDENTIFIKASI ULANG', '2024-12-10 21:58:08', '2024-12-10 21:58:08');

-- --------------------------------------------------------

--
-- Table structure for table `tindakan`
--

CREATE TABLE `tindakan` (
  `id` bigint UNSIGNED NOT NULL,
  `id_riskregister` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_tindakan` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `acuan` text COLLATE utf8mb4_unicode_ci,
  `targetpic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_penyelesaian` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tindakan`
--

INSERT INTO `tindakan` (`id`, `id_riskregister`, `nama_tindakan`, `acuan`, `targetpic`, `tgl_penyelesaian`, `created_at`, `updated_at`) VALUES
(7, '3', 'Dibuatkan timeline dan list pekerjaan', NULL, '38', '2025-10-25', '2024-11-01 00:42:40', '2024-11-08 01:32:10'),
(19, '8', 'Pasang fix detector gas untuk kebocoran', NULL, '49', '2025-01-09', '2024-11-01 21:03:00', '2024-11-08 01:34:12'),
(20, '8', 'Personil dibekali dengan pelatihan emergency atau penanganan saat terjadi kebocoran disupplier', NULL, '49', '2024-07-10', '2024-11-01 21:03:00', '2024-11-08 01:34:12'),
(21, '8', 'Membuat flow emergency & disimulasikan', NULL, '49', '2024-07-11', '2024-11-01 21:03:00', '2024-11-08 01:34:12'),
(22, '8', 'Pengadaan APD khusus penanganan chemical & SCBA', NULL, '49', '2025-01-09', '2024-11-01 21:03:00', '2024-11-08 01:34:12'),
(23, '8', 'Menyediakan secondary container & aliran jika penuh', NULL, '49', '2024-10-16', '2024-11-01 21:03:00', '2024-11-08 01:34:12'),
(24, '9', '1.Koordinasi dengan tim Exim dan Purchasing terkait schedule kedatangan CRC Import dan Lokal supaya tdk dihari yang sama (buat group Moxo terkait proses kedatangan CRC)', NULL, '41', '2024-08-30', '2024-11-01 21:49:42', '2025-03-07 00:12:16'),
(25, '10', 'perbaikan launder\r\nModifikasi Burner Contrl', NULL, '49', '2024-09-12', '2024-11-01 22:01:50', '2024-11-01 22:01:50'),
(41, '19', 'Rilis technical specification sebagai acuan spesifikasi yang harus bisa dipenuhi', NULL, '35', '2025-12-31', '2024-11-03 21:15:44', '2025-02-28 18:38:17'),
(42, '20', 'Melakukan technical meeting dengan customer', NULL, '35', '2025-12-31', '2024-11-03 21:20:33', '2025-02-28 18:39:07'),
(43, '20', 'Membuat spesifikasi produk (TDC) untuk produk yang dihasilkan', NULL, '35', '2025-12-31', '2024-11-03 21:20:33', '2025-02-28 18:38:45'),
(44, '20', 'Memastikan CRC sesuai kemampuan LINE/Standard', NULL, '14', '2025-12-31', '2024-11-03 21:20:33', '2025-02-28 18:38:45'),
(45, '21', 'Membuat spesifikasi raw material yang dibutuhkan', NULL, '35', '2025-12-31', '2024-11-03 23:06:47', '2025-02-28 18:39:29'),
(46, '21', 'Melakukan technical meeting dengan supplier', NULL, '35', '2025-12-31', '2024-11-03 23:06:47', '2025-02-28 18:39:29'),
(47, '21', 'Membuat spesifikasi produk (Technical spec) untuk produk yang dihasilkan', NULL, '35', '2025-12-31', '2024-11-03 23:06:47', '2025-02-28 18:39:29'),
(48, '22', 'Labeling sampah/limbah sesuai dengan kegunaan masing-masing', NULL, '39', '2025-12-31', '2024-11-03 23:08:59', '2025-02-28 18:39:46'),
(49, '23', 'Labeling bahan kimia yang digunakan dan disertakan MSDS tanda bahaya', NULL, '39', '2025-12-31', '2024-11-03 23:12:12', '2025-02-28 18:40:05'),
(50, '24', 'Menggunakan type surface treatment (chromate) yang sudah digunakan di pabrikan sejenis', NULL, '55', '2025-12-31', '2024-11-03 23:21:20', '2025-02-28 18:40:21'),
(51, '25', 'Penambahan jumlah personil laboratorium uji dengan menambah personel', NULL, '55', '2024-12-31', '2024-11-03 23:33:00', '2024-12-15 21:48:08'),
(52, '26', '1. Mengadakan training safety leadership internal', NULL, '49', '2024-11-16', '2024-11-04 18:20:49', '2024-11-08 01:36:51'),
(53, '26', '2. Training Investigasi eksternal', NULL, '49', '2024-11-16', '2024-11-04 18:20:49', '2024-11-08 01:36:51'),
(54, '27', 'Training Investigasi Eksternal', NULL, '49', '2024-11-16', '2024-11-04 18:23:58', '2024-11-08 01:37:40'),
(55, '28', 'Proses membuat HRA', NULL, '49', '2024-11-16', '2024-11-04 18:26:45', '2024-11-08 01:43:09'),
(56, '28', 'Kerja sama dengan RS untuk mengadakan MCU', NULL, '49', '2024-11-16', '2024-11-04 18:26:45', '2024-11-08 01:43:09'),
(57, '29', 'Initial diskusi dengan tim HRGA', NULL, '49', '2024-09-16', '2024-11-04 18:36:33', '2025-03-11 03:02:08'),
(58, '30', 'Koordinasi dan diskusi dengan tim GA dan PRY terkait kapasitas dan design TPS B3', NULL, '49', '2024-11-16', '2024-11-04 18:40:06', '2025-03-11 02:54:17'),
(59, '31', 'Akan dibuatkan jalur walkway', NULL, '49', '2024-11-16', '2024-11-04 18:45:58', '2024-11-08 01:55:48'),
(60, '32', 'Koordinasi awal dengan tim WH terkait chemical storage', NULL, '49', '2024-11-16', '2024-11-04 18:49:17', '2025-03-11 02:47:18'),
(61, '33', 'Proses Pembuatan Sistem terintegrasi untuk administrasi safety dan bisa diakses semua orang', NULL, '39', '2024-11-16', '2024-11-04 18:57:30', '2024-11-24 18:29:43'),
(72, '37', 'Mempersiapkan area Layout, mengosongkan sebagian area barang jadi apabila kapasitas tidak mencukupi.', NULL, '48', '2024-02-29', '2024-11-04 21:12:23', '2024-11-08 10:09:53'),
(73, '37', 'Meningkatkan kecepatan Unloading dengan kombinasi forklift dan crane.', NULL, '48', '2024-03-31', '2024-11-04 21:12:23', '2024-11-08 10:09:53'),
(86, '41', 'Manifest limbah B3', NULL, '1', '2024-11-30', '2024-11-04 21:44:49', '2025-05-08 00:21:35'),
(88, '42', '1. Penambahan Kapasitas Layout CRC, mengosongkan layout barang jadi di Blok F sedangkan barang jadi dipindahkan ke L8', NULL, '41', '2023-12-31', '2024-11-04 23:16:01', '2025-03-06 23:47:42'),
(89, '43', '1. Penambahan gudang baru Tata Sentosa untuk penyimpanan barang jadi', NULL, '49', '2024-03-29', '2024-11-04 23:40:12', '2025-03-07 00:21:29'),
(93, '45', '1.Meminjam Forklift 10 ton di Sadang untuk support Packing dan penyimpanan di L8', NULL, '49', '2023-12-05', '2024-11-05 00:16:15', '2025-03-07 00:31:27'),
(97, '48', '1. Conducting Technical Skill training, \r\n2. Trouble shooting skill training', NULL, '59', '2025-01-03', '2024-11-05 21:35:34', '2024-11-08 09:28:36'),
(98, '49', 'Mencari suplier alternative untuk mendapatkan quality yang sesuai', NULL, '49', '2024-12-31', '2024-11-05 21:44:58', '2024-11-08 09:30:41'),
(99, '49', '- Get approval to rubber in Hammer King new zealand', NULL, '59', '2024-12-15', '2024-11-05 21:50:41', '2024-11-08 09:30:41'),
(100, '48', '-analiPraparing modul tical thinking process', NULL, '59', '2024-12-31', '2024-11-05 21:53:33', '2024-11-08 09:28:36'),
(101, '48', 'Preparing drive and vibration simulation unit', NULL, '59', '2025-06-30', '2024-11-05 21:53:33', '2024-11-08 09:28:36'),
(102, '50', 'Develop Computerize Maintenance Management System', NULL, '49', '2024-09-02', '2024-11-05 22:02:05', '2024-11-08 09:33:13'),
(103, '50', 'Automatic work order base on machines running hours', NULL, '49', '2024-12-31', '2024-11-05 22:04:58', '2024-11-08 09:33:13'),
(104, '50', 'Create Maintenance dashboard', NULL, '49', '2024-12-31', '2024-11-05 22:04:58', '2024-11-08 09:33:13'),
(105, '51', 'Pemanfaatan air limbah untuk taman dan kebun', NULL, '49', '2024-08-12', '2024-11-06 19:58:12', '2024-11-08 09:34:43'),
(106, '51', 'Pemasangan Bioligical process setelah process kimia dan fisika.', NULL, '49', '2025-02-01', '2024-11-06 19:58:12', '2024-11-08 09:34:43'),
(107, '51', 'Pengajuan effluent disalurkan melalui saluran industri tetangga', NULL, '1', '2025-05-30', '2024-11-06 20:07:38', '2024-11-08 09:34:43'),
(109, '53', '1. Buat Buffer stok, koordinasi dengan customer perioritas.\r\n2. menginformasikan customer terkait aktivitas yang memakan waktu lebih dari 1 bulan\r\n3. jadwal dimajukan akhir desember untuk cleaning POT\r\n4. Simulasi hasil produksi dan pengeluaran', NULL, '24', '2023-12-30', '2024-11-08 20:01:36', '2024-11-08 20:01:36'),
(110, '54', 'Penambahan Kapasitas Layout dengan double stacking.', NULL, '48', '2024-08-31', '2024-11-08 20:21:04', '2024-11-11 01:28:18'),
(111, '54', 'Mengurangi coil coil dengan status slow moving coil\r\n- Hold\r\n- Non Prime', NULL, '46', '2024-07-31', '2024-11-08 20:21:04', '2024-11-08 20:21:04'),
(112, '54', 'Pengeluaran barang-barang ex project dan penerapan 5S.', NULL, '48', '2024-04-30', '2024-11-08 20:21:04', '2024-11-08 20:21:04'),
(113, '55', '1. Analisa Kapasitas Equipment Tension Reel\r\n2. Pergantian Equipment Tension Reel yang baru\r\n3. Trial kapasitas maximal (10 Ton)', NULL, '17', '2023-12-01', '2024-11-08 20:21:05', '2024-11-08 20:21:05'),
(114, '56', 'melakukan trial dengan material ss400', NULL, '26', '2024-03-01', '2024-11-08 20:28:43', '2024-11-08 20:28:43'),
(115, '57', 'perbaikan launder\r\nModifikasi Burner Contrl', NULL, '22', '2024-09-01', '2024-11-08 20:35:15', '2024-11-08 20:35:15'),
(116, '58', 'Pemasangan Sleave Loader Robotic', NULL, '17', '2025-01-01', '2024-11-08 21:17:52', '2024-11-08 21:17:52'),
(117, '59', 'Membuat Technical Agreement yang disetujui oleh kedua belah pihak (Supplier - customer) agar produk yang dikirim sesuai dengan spesifikasi', NULL, '55', '2025-12-31', '2024-11-08 21:38:03', '2025-02-28 18:40:45'),
(118, '59', 'Meeting bulanan/sesuai dengan ketentuan dengan supplier', NULL, '35', '2025-12-31', '2024-11-08 21:38:03', '2025-02-28 18:40:45'),
(119, '59', 'Komplain jika ditemukan ketidaksesuaian', NULL, '34', '2025-12-31', '2024-11-08 21:38:03', '2025-02-28 18:40:45'),
(120, '60', 'Alat uji inspection selalu dikalibrasi', NULL, '36', '2025-12-31', '2024-11-08 21:41:27', '2025-02-28 18:41:14'),
(121, '60', 'Training pengetahuan defect kepada operator', NULL, '35', '2025-12-31', '2024-11-08 21:41:27', '2025-02-28 18:41:14'),
(122, '60', 'Training problem solving terhadap defect yang muncul kepada operator', NULL, '14', '2025-12-31', '2024-11-08 21:41:27', '2025-02-28 18:41:14'),
(123, '60', 'Mengalokasikan produk Non Comformance ke customer tertentu', NULL, '35', '2025-12-31', '2024-11-08 21:41:27', '2025-02-28 18:41:14'),
(126, '61', 'Percepatan pengeluaran slow moving product (non prime, aging stock)', NULL, '47', '2024-10-30', '2024-11-09 21:19:19', '2024-11-12 16:00:48'),
(133, '64', 'Dibuatkan intruksi kerja dan cara handling limbah', NULL, '36', '2025-12-31', '2024-11-10 18:50:33', '2025-02-28 18:41:38'),
(138, '66', 'Membuat standar pengujian untuk produk skinpass (Draw down)', NULL, '36', '2025-12-31', '2024-11-10 18:58:29', '2025-02-28 18:42:06'),
(139, '66', 'Membuat technical agreement dengan tim CCL Sadang', NULL, '35', '2025-12-31', '2024-11-10 18:58:29', '2025-02-28 18:42:06'),
(140, '67', 'Buat Jadwal kalibrasi dan kalibrator', NULL, '36', '2025-12-31', '2024-11-10 19:02:57', '2025-02-28 18:43:04'),
(141, '67', 'Verifikasi alat ukur setiap shift saat produksi berlangsung', NULL, '36', '2025-12-31', '2024-11-10 19:02:57', '2025-02-28 18:43:04'),
(142, '68', 'Prosedur assesment new product', NULL, '55', '2025-12-31', '2024-11-10 19:08:58', '2025-02-28 18:43:28'),
(143, '68', 'Trial plan & evaluation', NULL, '35', '2025-12-31', '2024-11-10 19:08:58', '2025-02-28 18:43:28'),
(144, '69', 'Melakukan Technical delivery condition dengan customer agar standard yang diinginkan terwakili', NULL, '35', '2025-12-31', '2024-11-10 19:11:45', '2025-02-28 18:43:55'),
(145, '69', 'Koordinasi terkait kebutuhan bahan baku CRC sesuai spesifikasi', NULL, '35', '2025-12-31', '2024-11-10 19:11:45', '2025-02-28 18:43:55'),
(146, '70', 'Update prosedur untuk penambahan type produk galvanize', NULL, '35', '2025-12-31', '2024-11-10 19:14:56', '2025-02-28 18:44:20'),
(147, '70', 'Training pemahaman produk', NULL, '35', '2025-12-31', '2024-11-10 19:14:56', '2025-02-28 18:44:20'),
(148, '71', 'Membuat guide untuk acceptable kriteria terkait status produk', NULL, '35', '2025-12-31', '2024-11-10 19:19:15', '2025-02-28 18:49:38'),
(149, '71', 'Memberikan training/wawasan terkait kualitas produk', NULL, '36', '2025-12-31', '2024-11-10 19:19:15', '2025-02-28 18:49:38'),
(150, '71', 'Mereview complain yang muncul terkait acceptable kriteria yang sudah dibuat', NULL, '35', '2025-12-31', '2024-11-10 19:19:15', '2025-02-28 18:49:38'),
(151, '72', 'Memberikan analisa perbedaan masing-masing supplier', NULL, '35', '2025-12-31', '2024-11-10 19:22:39', '2025-02-28 18:50:06'),
(152, '73', 'Safety Guarding diarea Mesin, strip berjalan', NULL, '6', '2024-11-30', '2024-11-10 19:28:34', '2024-11-10 19:28:34'),
(153, '73', 'LOTO prosedur', NULL, '6', '2024-11-30', '2024-11-10 19:28:34', '2024-11-10 19:28:34'),
(154, '73', 'Tidak ada Nip point saat cleaning mode', NULL, '6', '2024-11-30', '2024-11-10 19:28:34', '2024-11-10 19:28:34'),
(155, '73', 'Menggunakan alat bantu saat bersentuhan dengan strip yang berjalan', NULL, '31', '2024-11-30', '2024-11-10 19:28:34', '2024-11-10 19:28:34'),
(156, '73', 'Update HIRADC di setiap tahapan pekerjaan', NULL, '31', '2024-11-30', '2024-11-10 19:28:34', '2024-11-10 19:28:34'),
(157, '74', 'Pemisahan tempat sampah B3', NULL, '1', '2024-11-30', '2024-11-10 19:35:41', '2025-05-08 01:25:33'),
(158, '74', 'Pembuatan tempat khusus limbah B3', NULL, '1', '2024-11-30', '2024-11-10 19:35:41', '2025-05-08 01:25:33'),
(159, '75', 'Membuat technical spesifikasi bahan baku yang akan digunakan', NULL, '47', '2024-11-30', '2024-11-10 19:39:01', '2024-11-10 19:41:12'),
(160, '75', 'Meeting dengan calon supplier', NULL, '47', '2024-11-30', '2024-11-10 19:41:12', '2024-11-10 19:41:12'),
(161, '75', 'Meningkatkan keterampilan operator dalam handling material', NULL, '31', '2024-11-30', '2024-11-10 19:41:12', '2024-11-10 19:41:12'),
(162, '75', 'Optimalisasi parameter dan equipment', NULL, '59', '2024-11-30', '2024-11-10 19:41:12', '2024-11-10 19:41:12'),
(163, '76', 'Improvement Paint Feed quality baik dari CGL-Cikarang maupun import.', NULL, '47', '2024-07-31', '2024-11-10 19:47:16', '2024-11-10 19:48:14'),
(164, '76', 'Convert paint feed yang tidak memenuhi spesifikasi untuk produk atau warna lain.', NULL, '46', '2024-04-30', '2024-11-10 19:47:16', '2024-11-10 19:47:16'),
(166, '77', 'Melakukan SO weekly sparepart untuk barang yg ada transaksi\r\nSupaya apabila terjadi selisih bisa terdeteksi lebih cepat.', NULL, '48', '2024-05-31', '2024-11-10 19:52:17', '2024-11-10 19:52:17'),
(168, '77', 'Penerapan 5S. Target 3S', NULL, '48', '2024-07-31', '2024-11-10 19:52:17', '2024-11-10 19:52:17'),
(170, '78', 'SO dilakukan dengan menggunakan HP dengan memasukkan ke template yang sudah ditarik dari stock ERP System', NULL, '47', '2025-06-30', '2024-11-10 19:55:10', '2025-05-09 19:20:50'),
(176, '83', 'SS', NULL, '39', '2024-11-07', '2024-11-10 20:20:35', '2024-11-10 20:20:35'),
(180, '86', 'Install overflow di tanki WQ', NULL, '32', '2024-11-30', '2024-11-27 21:20:19', '2024-11-27 21:20:19'),
(184, '88', 'Fire wall di sekeliling Tangki Amonia (Tembok)', NULL, '10', '2023-01-01', '2024-12-06 20:05:51', '2024-12-06 21:28:22'),
(185, '88', 'Wind direction untuk mengetahui arah angin jika yang akan digunakan untuk evakuasi', NULL, '10', '2023-02-01', '2024-12-06 20:05:51', '2024-12-06 20:08:24'),
(186, '88', 'Sprinkle diatas tangki amonia untuk menetralisir Amonia', NULL, '10', '2024-03-01', '2024-12-06 20:05:51', '2024-12-06 20:08:24'),
(187, '88', 'sertifikasi pengecekkan tangki setiap 5 tahun sekali', NULL, '10', '2024-04-01', '2024-12-06 20:05:51', '2024-12-06 20:08:24'),
(188, '88', 'Pengecekkan kebocoran dengan gas detector amonia portable setiap 6 bulan sekali', NULL, '10', '2024-05-01', '2024-12-06 20:05:51', '2024-12-06 20:08:24'),
(189, '88', 'Automatic Sprinkle jika terdeteksi kebocoran Amonia', NULL, '10', '2024-06-01', '2024-12-06 20:05:51', '2024-12-06 20:08:24'),
(190, '88', 'Training dengan Pupuk Kujang', NULL, '10', '2024-07-01', '2024-12-06 20:05:51', '2024-12-06 20:08:24'),
(195, '90', 'Revamping instalasi listrik di L8 yang tidak standard', NULL, '3', '2024-12-31', '2024-12-06 20:38:03', '2024-12-06 20:38:03'),
(196, '90', 'Ganti Panel PD 6 \r\nPenambahan kabel grounding untuk seluruh PD area L8', NULL, '3', '2024-12-15', '2024-12-06 20:40:46', '2024-12-06 20:40:46'),
(197, '90', 'Penambahan kabel grounding untuk seluruh PD area L8', NULL, '3', '2024-12-31', '2024-12-06 20:40:46', '2024-12-06 20:40:46'),
(198, '91', 'Komunikasi dengan Vendor terkait MOU dan Commisioning data serta prosedur Troubleshooting', NULL, '22', '2025-08-16', '2024-12-06 20:43:09', '2024-12-06 21:14:20'),
(199, '91', 'Training operator dan simulasi dari vendor dan monitoring', NULL, '22', '2025-08-29', '2024-12-06 20:43:09', '2024-12-06 21:05:53'),
(200, '88', 'Test', NULL, '66', '2024-01-04', '2024-12-06 21:18:50', '2024-12-06 21:18:50'),
(201, '92', 'Program 5S dengan memastikan tidak ada alat elektronik yang terpasang ketika pulang', NULL, '39', '2024-07-01', '2024-12-13 18:59:49', '2024-12-13 18:59:49'),
(202, '92', 'Standar ISO14001 bahwa pendingin ruangan wajib menggunakan R32', NULL, '39', '2024-03-21', '2024-12-13 18:59:49', '2024-12-13 18:59:49'),
(203, '92', 'Membuat sign hemat energi dan air', NULL, '39', '2023-01-18', '2024-12-13 18:59:49', '2024-12-13 18:59:49'),
(204, '92', 'Membuat poster untuk membawa tumblr dari rumah', NULL, '39', '2024-06-03', '2024-12-13 18:59:49', '2024-12-13 18:59:49'),
(205, '92', 'Membuat sign hemat kertas dan migrasi program ke Industry 4.0', NULL, '39', '2025-03-21', '2024-12-13 18:59:49', '2024-12-13 19:38:18'),
(206, '93', 'Membuat sign hemat energi dan air', NULL, '60', '2024-01-10', '2024-12-15 20:49:05', '2024-12-15 20:49:05'),
(207, '93', 'Membuat poster untuk membawa tumbler dari rumah', NULL, '60', '2024-07-10', '2024-12-15 20:49:05', '2024-12-15 20:49:05'),
(208, '93', 'Membuat sign hemat kertas dan migrasi program ke industry 4.0', NULL, '60', '2024-07-10', '2024-12-15 20:49:05', '2024-12-15 20:49:05'),
(209, '94', 'Sosialisasi Quality Plan kepada Team Produksi', NULL, '35', '2024-12-31', '2024-12-15 21:46:51', '2024-12-15 21:46:51'),
(210, '94', 'Pemisahan personel pengelola Laboratorium dengan bagian QC produksi secara Struktur Organisasi', NULL, '55', '2024-12-31', '2024-12-15 21:46:51', '2024-12-15 21:46:51'),
(211, '95', 'Komitmen masing-masing personel yang dituangkan dalam pakta integritas', NULL, '36', '2024-12-31', '2024-12-15 21:51:53', '2024-12-15 21:51:53'),
(212, '96', 'Pada form FM.LAB.09 direvisi dengan menambahkan isian \"Permintaan Uji dapat dipenuhi\"', NULL, '36', '2024-12-31', '2024-12-15 21:56:33', '2024-12-15 21:56:33'),
(213, '97', 'Setiap sampel yang masuk diberi keterangan pengujian apa yang dilakukan', NULL, '34', '2024-12-31', '2024-12-15 22:00:41', '2024-12-15 22:00:41'),
(214, '98', 'Melakukan maintenace mesin secara berkala', NULL, '35', '2024-12-31', '2024-12-15 23:11:07', '2024-12-15 23:11:07'),
(215, '99', 'Refreshmen terkait metode pengujian sesuai Instruksi Kerja Laboratorium', NULL, '36', '2024-12-31', '2024-12-15 23:15:59', '2024-12-15 23:15:59'),
(216, '100', 'Buat Jadwal kalibrasi dan kalibrator', NULL, '36', '2024-12-31', '2024-12-15 23:20:28', '2024-12-15 23:20:28'),
(217, '100', 'Penyimpanan kalibrator ditempat yang terlindungi dari kotoran', NULL, '35', '2024-12-31', '2024-12-15 23:20:28', '2024-12-15 23:20:28'),
(218, '101', 'Buat Jadwal kalibrasi dan kalibrator', NULL, '36', '2024-12-31', '2024-12-15 23:25:02', '2024-12-15 23:25:02'),
(219, '101', 'Verifikasi alat ukur setiap shift saat produksi berlangsung', NULL, '36', '2024-12-31', '2024-12-15 23:25:02', '2024-12-15 23:25:02'),
(220, '102', 'Preventif alat uji', NULL, '36', '2024-12-31', '2024-12-15 23:29:05', '2024-12-15 23:29:05'),
(221, '103', 'Verifikasi laporan hasil uji sebelum disahkan', NULL, '35', '2024-12-31', '2024-12-15 23:33:33', '2024-12-15 23:33:33'),
(222, '104', 'Develop sistem integrasi Data Hasil Uji dengan Laporan Hasil Uji', NULL, '36', '2024-12-31', '2024-12-15 23:43:58', '2024-12-15 23:43:58'),
(223, '105', 'Menambah personel laboratorium', NULL, '35', '2024-12-31', '2024-12-15 23:46:11', '2024-12-15 23:46:11'),
(224, '106', '1. Pembuatan prosedur untuk kontraktor', NULL, '60', '2024-10-30', '2024-12-16 18:11:44', '2024-12-17 23:43:36'),
(225, '106', '2. Pembuatan Form ceklist screening kontraktor', NULL, '60', '2024-10-30', '2024-12-17 23:43:36', '2024-12-17 23:43:36'),
(226, '106', '3. Pembuatan Laporan Harian untuk kontraktor', NULL, '60', '2024-10-30', '2024-12-17 23:43:36', '2024-12-17 23:43:36'),
(227, '107', '1. Dibuatkan Jalur walkway', NULL, '60', '2023-08-08', '2024-12-18 00:01:55', '2024-12-18 00:01:55'),
(228, '107', '2. Dipasangkan sign petunjuk jalur kendaraan dan jalur Pejalan Kaki', NULL, '60', '2023-08-08', '2024-12-18 00:01:55', '2024-12-18 00:01:55'),
(229, '107', '3. Layout Walkway', NULL, '60', '2023-08-08', '2024-12-18 00:01:55', '2024-12-18 00:01:55'),
(230, '107', '4. Pembuatan pintu pembatas jalur kendaraan dan pejalan kaki', NULL, '60', '2023-08-08', '2024-12-18 00:01:55', '2024-12-18 00:01:55'),
(231, '107', '5. Pembuatan jalur Zebra Cross untuk penyebrangan', NULL, '60', '2023-08-08', '2024-12-18 00:01:55', '2024-12-18 00:01:55'),
(235, '109', '1. Membuatkan prosedur untuk karyawan baru dan tamu', NULL, '60', '2023-09-09', '2024-12-20 01:08:23', '2024-12-20 01:08:23'),
(236, '109', '2. Memberikan pelatihan untuk karyawan baru sebelum masuk line', NULL, '60', '2023-09-09', '2024-12-20 01:08:23', '2024-12-20 01:08:23'),
(237, '109', '3. Mendampingi karyawan baru saat pertama masuk ke line', NULL, '60', '2023-09-09', '2024-12-20 01:08:23', '2024-12-20 01:08:23'),
(238, '110', '1. Pengelompokan sampah (Organik,Anorganik, dan B3)', NULL, '60', '2023-09-05', '2024-12-20 01:10:58', '2024-12-20 01:10:58'),
(239, '110', '2. Menyedikan tong sampah sesuai kriteria', NULL, '60', '2023-09-05', '2024-12-20 01:10:58', '2024-12-20 01:10:58'),
(240, '110', '3. Mensosialisasikan Kriteria Jenis Sampah', NULL, '60', '2023-09-05', '2024-12-20 01:10:58', '2024-12-20 01:10:58'),
(241, '111', '1. Membuat flow ERP', NULL, '60', '2023-10-21', '2024-12-20 01:13:55', '2024-12-20 01:13:55'),
(242, '111', '2. Pengadaan tools yang diperlukan \r\n   a. Alarm, Push Bottom ( Electrik)\r\n   b.Tandu,Bidai , Toa, Center Penerangan, Bendera divisi, tas P3K+ Isi (Safety)', NULL, '60', '2023-10-21', '2024-12-20 01:13:55', '2024-12-20 01:13:55'),
(243, '111', '3. Membuat struktur ERP', NULL, '60', '2023-10-21', '2024-12-20 01:13:55', '2024-12-20 01:13:55'),
(244, '111', '4. Sosialisasi Penugasan tim ERP', NULL, '60', '2023-10-21', '2024-12-20 01:13:55', '2024-12-20 01:13:55'),
(245, '111', '5. Melakukan drill ERP', NULL, '60', '2023-10-21', '2024-12-20 01:13:55', '2024-12-20 01:13:55'),
(246, '112', '1. Sertifikasi SIO pada operator', NULL, '60', '2023-11-02', '2024-12-20 01:16:29', '2024-12-20 01:16:29'),
(247, '112', '2. Melakukan Refreshment cara pengoprasian kepada operator', NULL, '60', '2023-11-02', '2024-12-20 01:16:29', '2024-12-20 01:16:29'),
(248, '112', '3. Dilakukan pendampingan oleh operator level 2 kepada operator awal-awal pengoprasian Forklift dan Crane.', NULL, '60', '2024-11-02', '2024-12-20 01:16:29', '2024-12-20 01:16:29'),
(249, '113', '1. Membuat struktur MERP', NULL, '60', '2023-11-12', '2024-12-20 01:19:26', '2024-12-20 01:19:26'),
(250, '113', '2. Pengadaan tools yang diperlukan (Bidai, tas dan kotak P3K, tandu , dll)', NULL, '60', '2023-11-12', '2024-12-20 01:19:26', '2024-12-20 01:19:26'),
(251, '113', '3. Membuat pelatihan MERP', NULL, '60', '2024-11-30', '2024-12-20 01:19:26', '2024-12-20 01:19:26'),
(252, '113', '4. Melakukan drill MERP', NULL, '60', '2024-11-30', '2024-12-20 01:19:26', '2024-12-20 01:19:26'),
(253, '113', '5. Membuat Flow MERP', NULL, '60', '2024-11-30', '2024-12-20 01:19:26', '2024-12-20 01:19:26'),
(254, '114', '1. Training safety leadership', NULL, '60', '2024-01-21', '2024-12-20 01:22:02', '2024-12-20 01:22:02'),
(255, '114', '2. Peningkatan laporan safety report (all karyawan)', NULL, '60', '2024-01-21', '2024-12-20 01:22:02', '2024-12-20 01:22:02'),
(256, '114', '3. Membuat target KPI', NULL, '60', '2024-01-21', '2024-12-20 01:22:02', '2024-12-20 01:22:02'),
(257, '114', '4. Buat HSE Plan 2024 beserta target', NULL, '60', '2024-01-21', '2024-12-20 01:22:02', '2024-12-20 01:22:02'),
(258, '114', '5. Review HIRADC', NULL, '60', '2024-12-27', '2024-12-20 01:22:02', '2024-12-20 01:22:02'),
(259, '115', '1. Pembuatan mapping area kebisingan', NULL, '60', '2024-01-19', '2024-12-20 01:24:32', '2024-12-20 01:24:32'),
(260, '115', '2. Memasangkan sign di titik area bising', NULL, '60', '2024-01-19', '2024-12-20 01:24:32', '2024-12-20 01:24:32'),
(261, '115', '3. Dilakukan pengecekan kebisingan rutin tiap bulan', NULL, '60', '2024-01-19', '2024-12-20 01:24:32', '2024-12-20 01:24:32'),
(262, '116', '1. Membuat jadwal rutin medical check up karyawan', NULL, '60', '2024-03-04', '2024-12-20 01:25:59', '2024-12-20 01:25:59'),
(263, '116', '2. Mensosialisasikan pola hidup sehat', NULL, '60', '2024-03-04', '2024-12-20 01:25:59', '2024-12-20 01:25:59'),
(264, '117', '1. Pasang fix detector heat/smoke di panel room', NULL, '60', '2024-03-04', '2024-12-20 01:28:28', '2024-12-20 01:28:28'),
(265, '117', '2. Personil dibekali dengan pelatihan emergency', NULL, '60', '2024-03-04', '2024-12-20 01:28:28', '2024-12-20 01:28:28'),
(266, '117', '3. Membuat flow emergency', NULL, '60', '2024-05-10', '2024-12-20 01:28:28', '2024-12-20 01:28:28'),
(267, '117', '4. Pengadaan APD khusus penanganan kebakaran dan SCBA', NULL, '60', '2024-05-20', '2024-12-20 01:28:28', '2024-12-20 01:28:28'),
(268, '117', '5. Disimulasikan', NULL, '60', '2024-12-30', '2024-12-20 01:28:28', '2024-12-20 01:28:28'),
(269, '118', '1. Membuat jadwal pelaporan Triwulan', NULL, '60', '2024-03-08', '2024-12-20 01:30:29', '2024-12-20 01:30:29'),
(270, '118', '2. Membuat Template pelaporan Triwulan', NULL, '60', '2024-03-08', '2024-12-20 01:30:29', '2024-12-20 01:30:29'),
(271, '118', '3. Mencari sumber data dari beberapa department', NULL, '60', '2024-03-08', '2024-12-20 01:30:29', '2024-12-20 01:30:29'),
(272, '118', '4. Merekap semua kegiatan yang berkaitan dengan K3 setiap 3 bulan', NULL, '60', '2024-03-08', '2024-12-20 01:30:29', '2024-12-20 01:30:29'),
(273, '119', '1. Memindahkan atau menggeser box hydrant', NULL, '60', '2024-04-21', '2024-12-20 01:33:16', '2024-12-20 01:33:16'),
(274, '120', '1. Dibuatkan sistem induction khusus driver di pos 2 Security', NULL, '60', '2024-04-21', '2024-12-20 01:34:38', '2024-12-20 01:34:38'),
(275, '121', '1. Dibuatkan ceklis monitoring lapangan', NULL, '60', '2024-05-15', '2024-12-20 01:35:48', '2024-12-20 01:35:48'),
(276, '122', '1. Membuat jalur Khusus sepeda', NULL, '60', '2024-05-15', '2024-12-20 01:37:27', '2024-12-20 01:37:27'),
(277, '122', '2. Membuat area parkir sepeda', NULL, '60', '2024-05-15', '2024-12-20 01:37:27', '2024-12-20 01:37:27'),
(278, '123', '1. Membuat jalur khusus keluar masuk kendaraan besar', NULL, '60', '2024-12-20', '2024-12-20 01:39:36', '2024-12-20 01:39:36'),
(279, '123', '2. Pengaturan keluar masuk kendaraan oleh security', NULL, '60', '2024-10-04', '2024-12-20 01:39:36', '2024-12-20 01:39:36'),
(280, '124', '1. Dibuatkan skill matrik untuk karyawan baru per divisi', NULL, '60', '2025-01-30', '2024-12-20 01:40:54', '2024-12-20 01:40:54'),
(284, '126', '- Pakta Integritas', NULL, '56', '2025-02-28', '2025-02-04 00:04:54', '2025-02-04 00:04:54'),
(285, '126', '- Dilaksanakan sesuai SOP', NULL, '56', '2025-02-28', '2025-02-04 00:04:54', '2025-02-04 00:04:54'),
(286, '127', '- Pakta Integritas', NULL, '56', '2025-02-28', '2025-02-04 00:20:08', '2025-02-04 00:20:08'),
(287, '127', '- Dilaksanakan sesuai SOP', NULL, '56', '2025-02-28', '2025-02-04 00:20:08', '2025-02-04 00:20:08'),
(288, '128', '- Pakta Integritas', NULL, '56', '2025-02-28', '2025-02-04 00:24:42', '2025-02-04 00:24:42'),
(289, '128', '- Dilaksanakan sesuai SOP', NULL, '56', '2025-02-28', '2025-02-04 00:24:42', '2025-02-04 00:24:42'),
(290, '129', 'Mengadakan sosialisasi kepada team terkait anti penyuapan (ISO 37001)', NULL, '39', '2025-03-01', '2025-02-25 20:06:10', '2025-02-25 20:06:10'),
(291, '130', 'Sistem terintegrasi untuk administrasi safety dan bisa diakses semua orang\r\nSMS (Safety Management System)', NULL, '60', '2025-02-28', '2025-02-27 23:59:54', '2025-02-27 23:59:54'),
(292, '131', 'Program 5S dengan memastikan tidak ada alat elektronik yang terpasang ketika pulang', NULL, '60', '2025-04-30', '2025-02-28 00:07:08', '2025-02-28 00:07:08'),
(293, '132', 'Mengadakan sosialisasi kepada team terkait anti penyuapan (ISO 37001)', NULL, '39', '2025-04-30', '2025-02-28 00:10:01', '2025-02-28 00:10:01'),
(294, '133', 'Standarisasi metode packing penggunaan VCI paper dan plastic PE overlap hingga inner diameter coil', NULL, '36', '2025-12-31', '2025-02-28 18:37:30', '2025-03-17 19:37:54'),
(295, '133', 'Memperbaiki atap jika ditemukan kebocoran', NULL, '44', '2025-12-31', '2025-02-28 18:37:30', '2025-02-28 18:37:30'),
(296, '134', 'Membuat Technical Agreement yang disetujui oleh kedua belah pihak (Supplier - customer) agar produk yang dikirim sesuai dengan spesifikasi', NULL, '55', '2025-12-31', '2025-02-28 19:54:57', '2025-02-28 19:54:57'),
(298, '134', 'Komplain jika ditemukan ketidaksesuaian', NULL, '57', '2025-12-31', '2025-02-28 19:54:57', '2025-02-28 19:54:57'),
(299, '135', 'Alat uji inspection selalu dikalibrasi', NULL, '58', '2025-12-31', '2025-02-28 19:57:43', '2025-02-28 19:57:43'),
(300, '135', 'Training pengetahuan defect kepada operator', NULL, '30', '2025-12-31', '2025-02-28 19:57:43', '2025-02-28 19:57:43'),
(303, '136', 'Buat Jadwal kalibrasi dan kalibrator', NULL, '58', '2025-12-31', '2025-02-28 20:01:20', '2025-02-28 20:01:20'),
(304, '136', 'Verifikasi alat ukur setiap shift saat produksi berlangsung', NULL, '58', '2025-12-31', '2025-02-28 20:01:20', '2025-02-28 20:01:20'),
(305, '137', 'Prosedur assesment new product', NULL, '55', '2025-12-31', '2025-02-28 20:25:58', '2025-02-28 20:25:58'),
(306, '137', 'Trial plan & evaluation', NULL, '57', '2025-12-31', '2025-02-28 20:25:58', '2025-02-28 20:25:58'),
(307, '138', 'Update prosedur untuk penambahan type color produk', NULL, '57', '2025-12-31', '2025-02-28 20:45:52', '2025-02-28 20:45:52'),
(308, '138', 'Training pemahaman produk', NULL, '30', '2025-12-31', '2025-02-28 20:45:52', '2025-02-28 20:45:52'),
(309, '138', 'Spesifikasi detil dari supplier', NULL, '58', '2025-12-31', '2025-02-28 20:45:52', '2025-02-28 20:45:52'),
(310, '139', 'Membuat guide untuk acceptable kriteria terkait status produk', NULL, '57', '2025-12-31', '2025-02-28 20:48:33', '2025-02-28 20:48:33'),
(312, '139', 'Memberikan training/wawasan terkait kualitas produk', NULL, '30', '2025-12-31', '2025-02-28 20:48:33', '2025-02-28 20:48:33'),
(313, '140', 'Monitoring lebih ketat', NULL, '30', '2025-12-31', '2025-02-28 20:53:23', '2025-02-28 20:53:23'),
(314, '140', 'Menyeleksi agar saat running menggunakan satu supplier', NULL, '47', '2025-12-31', '2025-02-28 20:53:23', '2025-02-28 20:53:23'),
(315, '141', 'Melakukan Technical delivery condition dengan customer agar standard yang diinginkan terwakili.', NULL, '57', '2025-12-31', '2025-02-28 20:55:30', '2025-02-28 20:55:30'),
(316, '141', 'Koordinasi terkait kebutuhan bahan baku CRC sesuai spesifikasi', NULL, '58', '2025-12-31', '2025-02-28 20:55:30', '2025-02-28 20:55:30'),
(317, '142', 'rilis technical specification sebagai acuan spesifikasi yang harus bisa dipenuhi', NULL, '57', '2025-12-31', '2025-02-28 20:57:35', '2025-02-28 20:57:35'),
(319, '144', 'Melakukan technical meeting dengan customer', NULL, '57', '2025-12-31', '2025-02-28 21:01:38', '2025-02-28 21:01:38'),
(320, '144', 'Membuat spesifikasi produk (TDC) untuk produk yang dihasilkan', NULL, '58', '2025-12-31', '2025-02-28 21:01:38', '2025-02-28 21:01:38'),
(321, '144', 'Memastikan CRC sesuai kemampuan LINE/Standard', NULL, '13', '2025-12-31', '2025-02-28 21:01:38', '2025-02-28 21:01:38'),
(322, '145', 'Labeling sampah/limbah sesuai dengan kegunaan masing-masing', NULL, '39', '2025-12-31', '2025-02-28 21:05:11', '2025-02-28 21:05:11'),
(323, '146', 'Labeling bahan kimia yang digunakan dan disertakan MSDS tanda bahaya', NULL, '39', '2025-12-31', '2025-02-28 21:07:01', '2025-02-28 21:07:01'),
(324, '147', 'Memastikan hasil preshipment sudah sesuai dengan spesifikasi produk', NULL, '57', '2025-12-31', '2025-02-28 21:11:29', '2025-02-28 21:11:29'),
(327, '149', '1. Perbaikan Parsial dengan penggantian Brick bagian atas GL pot ( 7 layer) (DONE)', NULL, '69', '2024-02-12', '2025-02-28 22:42:12', '2025-03-03 00:08:49'),
(329, '149', '2. Perbaikan keseluruhan Brick dan Steel casing GL pot (Sudah bending). dilakukan pekerjaan Onsite, sehingga menunggu project CGL#2 selesai dan beroperasi normal terlebih dahulu.', NULL, '8', '2028-03-01', '2025-02-28 22:42:12', '2025-03-03 00:08:50'),
(331, '151', 'Membuat dan menjalankan Auto Cycle. Setelah dijalankan tetap terjadi penurunan tetapi melandai.\r\nTanggal 11/05/24 nilai di angka 0,72 >> 01/25 nilai di angka 0,58', NULL, '4', '2023-08-03', '2025-03-03 01:34:09', '2025-03-03 01:34:09'),
(332, '151', 'Melakukan Proses Bubbling + menurunkan level molten metal sampai 1/2 lunang throat. Setelah dilakukan 4 hari (24H) bisa terjadi kenaikan Ratio menjadi 0,7.\r\nSelanjutnya perlu dilakukan regular bubbling setiap 2 bulan sampai dilakukan penggantian.', NULL, '22', '2025-02-28', '2025-03-03 01:34:09', '2025-03-03 01:34:09'),
(333, '151', 'Persiapan Penggantian Inductor.\r\nPump out, Bongkar pasang Inductor, Heating up and charging, Level and check composition.', NULL, '7', '2026-01-03', '2025-03-03 01:34:09', '2025-03-03 01:34:09'),
(334, '152', 'Penambahan Lift Tong Horizontal untuk paint feed', NULL, '47', '2025-05-31', '2025-03-04 15:23:30', '2025-03-04 15:23:30'),
(335, '153', 'Proses penentuan cat yang dipakai melibatkan procurement, technial/quality', NULL, '47', '2025-03-31', '2025-03-04 16:40:53', '2025-03-04 16:40:53'),
(336, '154', 'Mencari vendor cat self cleaning', NULL, '58', '2025-12-31', '2025-03-04 18:49:15', '2025-03-04 18:49:15'),
(337, '154', 'Membuat trial plan untuk running \"Nexguard\"', NULL, '58', '2025-12-31', '2025-03-04 18:49:15', '2025-03-04 18:49:15'),
(338, '154', 'Membandingkan performa self cleaning vendor baru dengan existing', NULL, '58', '2025-12-31', '2025-03-04 19:00:30', '2025-03-04 19:00:30'),
(339, '155', '1. Memperhatikan standar penumpukan coil,  dengan memperhatikan tonase dan ketebalan coil. Coil dengan tonase lebih besar ditumpukan bagian bawah', NULL, '78', '2024-07-01', '2025-03-06 04:32:29', '2025-03-07 00:53:10'),
(340, '156', '1. Mempersiapkan dan mengkoordinasikan proses packing dengan tim Sales dan Exim, untuk mendapatkan standar packing yang terbaik', NULL, '41', '2024-07-01', '2025-03-06 04:36:25', '2025-03-07 01:03:54'),
(341, '157', '1. Koordinasi dengan Sales Support perihal ketentuan pengambilan barang oleh Customer sesuai GL WH', NULL, '73', '2021-07-20', '2025-03-06 04:43:39', '2025-03-07 01:12:48'),
(342, '158', '1. Menambah tumpukan Alluminium, yang sebelumnya 4 tumpuk menjadi 5 tumpuk ( Sebelumnya koordinasi dengan tim Exim, untuk menanyakan ke Supplier tumpukan yg sesuai standar supplier)', NULL, '72', '2022-12-01', '2025-03-06 05:17:41', '2025-03-07 01:17:05'),
(343, '159', '1. Uji Emisi secara berkala', NULL, '39', '2024-03-22', '2025-03-06 05:22:12', '2025-03-07 01:26:06'),
(344, '160', '1. Penyediaan spillkit', NULL, '39', '2023-03-01', '2025-03-06 05:24:45', '2025-03-07 21:48:19'),
(345, '160', '2. Preventif mesin secara berkala', NULL, '7', '2020-01-01', '2025-03-06 05:24:45', '2025-03-07 21:49:10'),
(346, '161', 'Limbah baterai, limbah kain majun eks bahan chemical dikumpulkan dan dikirim ke TPS limbah B3', NULL, '50', '2022-01-01', '2025-03-06 05:45:38', '2025-03-07 21:51:06'),
(347, '162', '1. Pembuatan Chemical storage sesuai standar beserta Spill kit didalamnya', NULL, '72', '2024-02-01', '2025-03-06 05:50:25', '2025-03-07 21:54:38'),
(348, '162', '2. Diskusi dan komunikasi dengan supplier untuk di uji dan apakah bisa di rework. Jika hasil uji bisa dilakukan proses rework, maka akan di rework', NULL, '72', '2024-02-01', '2025-03-06 20:02:47', '2025-03-07 21:54:38'),
(349, '162', '3. Dikembalikan ke supplier untuk dilakukan proses rework & yang tidak bisa dirework, dilimbahkan ke Supplier atau pihak Ke-3 dan simpan di TPS limbah B3', NULL, '72', '2024-02-01', '2025-03-06 20:02:47', '2025-03-07 21:54:38'),
(350, '163', '1. Saat stopline, membagi beberapa kelompok tim WH  untuk melakukan tugas SO dan proses packing / stuffing', NULL, '78', '2025-02-18', '2025-03-06 21:07:24', '2025-03-06 21:07:24'),
(351, '163', '2. SO dilakukan dengan menggunakan HP dengan memasukkan ke template yang sudah ditarik dari stock Bravo', NULL, '74', '2025-02-18', '2025-03-06 21:07:24', '2025-03-06 21:07:24'),
(352, '163', '3. Scan coil berdasarkan blok untuk memperkecil area pencarian', NULL, '78', '2025-02-18', '2025-03-06 21:07:24', '2025-03-06 21:07:24'),
(353, '164', '1. Melakukan SO harian sparepart untuk barang2 yg ada transaksi\r\nSupaya apabila terjadi selisih bisa terdeteksi lebih cepat', NULL, '44', '2024-11-12', '2025-03-06 21:27:42', '2025-03-06 21:27:42'),
(354, '164', '2. Melakukan SO semester untuk seluruh stock sparepart', NULL, '44', '2024-11-12', '2025-03-06 21:27:43', '2025-03-06 21:27:43'),
(355, '164', '3. Melakukan monitor ROP untuk menghindari stock tidak tersedia ketika dibutuhkan', NULL, '44', '2024-11-12', '2025-03-06 21:27:43', '2025-03-06 21:27:43'),
(356, '165', '1. Membuat Identifikasi untuk mengetahui akar penyebabnya', NULL, '78', '2025-02-20', '2025-03-06 21:34:59', '2025-03-06 21:34:59'),
(357, '165', '2. Menambahkan karet pada Crane Finish Goods untuk mengurangi dampak kerusakan apabila terkena Crane', NULL, '78', '2025-02-20', '2025-03-06 21:34:59', '2025-03-06 21:34:59'),
(358, '165', '3. Menambahkan Garis batas sesuai lebar coil pada Garpu Froklift, sebagai petunjuk batas aman operator forklift ketika mengangkat coil Slitting', NULL, '78', '2025-02-20', '2025-03-06 21:34:59', '2025-03-06 21:34:59'),
(359, '165', '4. Menambahkan coil lifter pada garpu forklif untuk meminimalkan kerusakan pada inner coil', NULL, '78', '2025-02-20', '2025-03-06 21:34:59', '2025-03-06 21:34:59'),
(360, '165', '5. Menambahkan inner protector untuk mengangkat coil-coil khusus', NULL, '78', '2025-02-20', '2025-03-06 21:34:59', '2025-03-06 21:34:59'),
(361, '166', '1. Menghentikan kegiatan sementara untuk briefing seluruh tim', NULL, '41', '2020-01-01', '2025-03-06 23:08:10', '2025-03-07 22:07:53'),
(362, '166', '2. Membentuk tim dengan koordinasi tim HSE, untuk investigasi kejadian', NULL, '78', '2020-01-01', '2025-03-06 23:08:10', '2025-03-07 22:07:53'),
(363, '166', '3. Melakukan corrective action untuk pencegahan kejadian terulang', NULL, '78', '2020-01-01', '2025-03-06 23:08:10', '2025-03-07 22:07:53'),
(364, '167', 'Balok-balok eks import Ingot dipilah , yang bagus digunakan lagi untuk stuffing dan packing dan yang jelek dikumpulkan dan dikirim ke TPS', NULL, '44', '2021-01-01', '2025-03-06 23:45:29', '2025-03-07 22:09:57'),
(365, '42', '2. Pengambilan menggunakan Forklif 23 ton, dipindahkan ke area CRC', NULL, '78', '2023-12-31', '2025-03-06 23:47:42', '2025-03-06 23:47:42'),
(366, '9', '2. Mempersiapkan area Layout, mengosongkan sebagian area barang jadi apabila kapasitas tidak mencukupi dan memindahkan barang jadi ke L8', NULL, '78', '2024-08-30', '2025-03-07 00:12:16', '2025-03-07 00:12:16'),
(367, '9', '3. Koordinasi dengan Kerani Expedisi, untuk bisa mengatur masuknya trailer ke kawasan', NULL, '78', '2024-08-30', '2025-03-07 00:12:16', '2025-03-07 00:12:16'),
(368, '9', '4. Koordinasi dengan Divisi Exim, untuk disampaikan ke pihak Ekspedisi jika memungkinkan tralier diatur masuk kawasan diatas jam 16.00 sore. Untuk menghindari Traffic yang padat.', NULL, '41', '2024-08-30', '2025-03-07 00:12:16', '2025-03-07 00:12:16'),
(369, '9', '5.Meningkatkan kecepatan Unloading dengan 2 lokasi unloading, menggunakan Forklift 23 ton dan Crane', NULL, '78', '2024-08-30', '2025-03-07 00:12:16', '2025-03-07 00:12:16'),
(370, '43', '2. Koordinasi dengan Tatalogam untuk pengiriman stock2 coil Tatalogam yang masih ada di Tata Metal', NULL, '49', '2024-03-29', '2025-03-07 00:21:29', '2025-03-07 00:21:29'),
(371, '43', '3. Memaksimalkan proses loading ke Tatalogam dan Sadang dengan menambah armada langsir (sewa trailer)', NULL, '49', '2024-03-29', '2025-03-07 00:21:29', '2025-03-07 00:21:29'),
(372, '43', '4. Memaksimalkan penyimpanan barang jadi ke L8', NULL, '49', '2024-03-29', '2025-03-07 00:21:29', '2025-03-07 00:21:29'),
(373, '43', '5. Penyimpanan coil ditumpuk (double stack) untuk memaksimalkan Layout penyimpanan', NULL, '49', '2024-03-29', '2025-03-07 00:21:29', '2025-03-07 00:21:29'),
(374, '45', '2. Mengusulkan ke management untuk menerapkan penggunaan Crane kapasitas minimum 10 ton disemua area Warehouse', NULL, '41', '2025-01-01', '2025-03-07 00:31:27', '2025-03-07 00:31:27'),
(375, '155', '2. Mengganjal palet bagian ujung dengan choke, untuk mengurangi dampak palet pecah', NULL, '78', '2024-07-01', '2025-03-07 00:53:10', '2025-03-07 00:53:10'),
(376, '155', '3. Mengikat tumpukan coil paling pinggir dengan menggunakan sling dan impraboard untuk menahan apabila ada coil yang menggelinding', NULL, '78', '2024-07-01', '2025-03-07 00:53:10', '2025-03-07 00:53:10'),
(377, '155', '4. Mengatur jarak tumpukan baris pertama dan kedua, supaya forklift/crane ketika mengambil coil bisa manuver/moving dengan aman', NULL, '78', '2024-07-01', '2025-03-07 00:53:10', '2025-03-07 00:53:10'),
(378, '155', '5. Membuat visual prosedur seperti Banner agar operator dilapangan bisa membaca dan mengingat selalu jika ada prosedur yang harus taati dan dijalankan', NULL, '72', '2024-07-01', '2025-03-07 00:53:10', '2025-03-07 00:53:10'),
(379, '156', '2. Membuat Video dan foto2 tahap packing sesuai yang sudah di accept pihak Sales dan Exim', NULL, '72', '2024-07-01', '2025-03-07 01:03:54', '2025-03-07 01:03:54'),
(380, '156', '3. Koordinasi dengan Divisi QA, Produksi & Advisor, untuk pengaturan pengiriman sistem grouping tonase coil, supaya aman ketika dilakukan double stack dikapal', NULL, '41', '2024-07-01', '2025-03-07 01:03:54', '2025-03-07 01:03:54'),
(381, '156', '4. Setting pengiriman sesuai urutan yang sudah ditentukan, dari berat coil. Yaitu Coil yg paling berat dimuat terlebih dahulu', NULL, '41', '2024-07-01', '2025-03-07 01:03:54', '2025-03-07 01:03:54'),
(382, '156', '5. Koordinasi dengan Security, untuk pengaturan parkir semua trailer', NULL, '78', '2024-07-01', '2025-03-07 01:03:54', '2025-03-07 01:03:54'),
(383, '157', '2. Mengecek dan memberi masukan ke ekspedisi terkait resiko apabila muat tidak sesuai standar', NULL, '73', '2021-07-20', '2025-03-07 01:12:48', '2025-03-07 01:12:48'),
(384, '157', '3. Berkoordinasi dengan safety jika ada supir/anggota ekspedisi yang tidak menggunakan APD Level 1 sesuai standar', NULL, '73', '2021-07-01', '2025-03-07 01:12:48', '2025-03-07 01:12:48'),
(385, '159', '2. Preventif kendaraan milik TML secara berkala', NULL, '7', '2020-01-01', '2025-03-07 01:26:06', '2025-03-07 01:26:06'),
(386, '159', '3. Pengecekan KIR setiap kendaraan yang masuk', NULL, '73', '2020-01-01', '2025-03-07 01:26:06', '2025-03-07 01:26:06'),
(387, '32', 'design & Review  chemical storage bersama tim WH', NULL, '49', '2025-07-31', '2025-03-11 02:47:18', '2025-03-11 02:47:18'),
(388, '32', 'review final bangunan chemical storage bersama tim WH', NULL, '49', '2025-12-31', '2025-03-11 02:47:18', '2025-03-11 02:47:18'),
(389, '30', 'Review bangunan TPS baru dan disesuaikan dengan praturan', NULL, '49', '2025-04-30', '2025-03-11 02:54:17', '2025-03-11 02:54:17'),
(390, '29', 'Diskusi dan penyerahan kebutuhan data dengan konsultan', NULL, '49', '2025-02-25', '2025-03-11 03:02:08', '2025-03-11 03:02:08'),
(391, '29', 'Finalisasi pengecekan RKL - RPL Rinci TML L03', NULL, '49', '2025-05-31', '2025-03-11 03:02:08', '2025-03-11 03:02:08'),
(392, '168', 'Pemeliharaan rutin mesin, penggunaan filter emisi, dan bahan bakar ramah lingkungan', NULL, '14', '2025-12-31', '2025-03-16 21:44:56', '2025-03-16 21:44:56'),
(393, '169', 'Instalasi sistem pengolahan limbah, pemantauan berkala, dan kepatuhan terhadap regulasi', NULL, '14', '2025-12-31', '2025-03-16 21:47:12', '2025-03-16 21:47:12'),
(398, '175', 'Implementasi sistem 3R (Reduce, Reuse, Recycle), kerja sama dengan pihak pengelola limbah', NULL, '14', '2025-12-31', '2025-03-16 23:18:42', '2025-03-16 23:18:42'),
(399, '176', '1. Pagar besi untuk mengurangi masuk keluar orang dan menjaga agar hanya petugas berwenang saja yang boleh masuk', NULL, '29', '2025-03-17', '2025-03-16 23:21:27', '2025-03-16 23:21:27'),
(400, '176', '2. Spanduk peringatan agar tidak menyalakan api di sekitar area Natural Gas', NULL, '50', '2025-03-17', '2025-03-16 23:21:27', '2025-03-16 23:21:27'),
(401, '176', '3.  Pengecekan pipa pipa natural gas dengan menggunakan gas detector tiap 6 bulan sekali', NULL, '50', '2025-03-17', '2025-03-16 23:21:27', '2025-03-16 23:21:27'),
(402, '176', '4. Disiapkan nya APAR dan Hydrant', NULL, '38', '2025-03-17', '2025-03-16 23:21:27', '2025-03-16 23:21:27'),
(403, '177', 'Pelatihan pekerja, inspeksi berkala, dan penggunaan wadah penyimpanan yang aman', NULL, '14', '2025-12-31', '2025-03-16 23:28:52', '2025-03-16 23:28:52'),
(404, '178', 'Penggunaan alat pelindung diri (APD), pemasangan peredam suara, dan pembatasan jam operasi', NULL, '14', '2025-12-31', '2025-03-17 00:16:29', '2025-03-17 00:16:29'),
(405, '179', '1. dibuatkan IK pembuangan freon dengan di masukan ke ember berisi air', NULL, '50', '2025-03-17', '2025-03-17 00:19:24', '2025-03-17 00:19:24'),
(406, '179', '2. Pemakaian AC yang menggunakan freon R22 di L3 di ganti dengan AC freon R32', NULL, '50', '2025-03-17', '2025-03-17 00:19:24', '2025-03-17 00:19:24'),
(407, '180', 'Penggunaan teknologi hemat energi, pemantauan konsumsi listrik, dan optimalisasi operasional', NULL, '14', '2025-12-31', '2025-03-17 00:28:08', '2025-03-17 00:28:08'),
(408, '181', 'Penggunaan sistem penyimpanan yang aman, pemantauan berkala, dan pelatihan keselamatan', NULL, '14', '2025-12-31', '2025-03-17 00:32:10', '2025-03-17 00:32:10'),
(409, '182', 'Pelatihan regulasi, audit lingkungan berkala, dan kerja sama dengan pihak berwenang', NULL, '14', '2025-12-31', '2025-03-17 00:35:05', '2025-03-17 00:35:05'),
(410, '183', 'Implementasi teknologi penghematan air, pemantauan konsumsi, dan daur ulang air', NULL, '10', '2025-12-31', '2025-03-17 00:58:21', '2025-03-17 00:58:21'),
(411, '184', 'Prosedur penyimpanan yang aman, pelatihan pemadam kebakaran, dan inspeksi reguler', NULL, '16', '2025-12-31', '2025-03-17 00:59:41', '2025-03-17 00:59:41'),
(412, '185', 'Refresh Safety Training, Audit / Safety walk through saat shutdown', NULL, '7', '2025-03-31', '2025-03-17 01:22:10', '2025-03-17 01:22:10'),
(413, '185', 'Refresh Safety Training, Audit / Safety walk through saat shutdown', NULL, '39', '2025-03-31', '2025-03-17 01:22:10', '2025-03-17 01:22:10'),
(414, '186', '1. Penanaman pohon bambu di area intake', NULL, '50', '2025-03-17', '2025-03-17 01:44:48', '2025-03-17 01:44:48'),
(415, '187', 'Penambahan Unit RO kapasitas sama dengan unit existing', NULL, '50', '2025-03-17', '2025-03-17 18:50:21', '2025-03-17 18:50:21'),
(416, '133', 'Sosialisasi standar packing', NULL, '44', '2025-12-31', '2025-03-17 19:37:54', '2025-03-17 19:37:54'),
(417, '188', 'Regular review and update skill matrix.\r\nRegular merotasi team group shift.', NULL, '7', '2025-03-31', '2025-03-18 00:19:24', '2025-03-18 00:19:24'),
(418, '189', '1. Briefing pagi dengan mengaplikasikan social distancing dan selalu menggunakan masker\r\n2. Selalu mengingatkan team untuk \'New Normal\"', NULL, '7', '2022-06-18', '2025-03-18 01:11:06', '2025-03-18 01:11:06'),
(419, '190', 'Repair pompa spare', NULL, '7', '2025-03-31', '2025-03-18 02:13:06', '2025-03-18 02:13:06'),
(420, '191', '1. Hot Spot Monitoring area dinding GL Pot, menggunakan camera thermal image\r\n2. Point Hot Spot akan dipasang TC untuk mendapatkan continue monitoring\r\n3. Dilakukan penjajagan untuk proses penggantian Brick dan Castable secara keseluruhan\r\n4. Penggantian brick dibagian atas pot)\r\n5. Pengambilan bottom dross\r\n6. Penggantian inductor', NULL, '7', '2025-03-31', '2025-03-18 02:19:49', '2025-03-18 02:27:02'),
(421, '192', 'MP dijalankan sesuai kritikalitas crane dan history kerusakan', NULL, '7', '2025-04-05', '2025-03-19 20:43:10', '2025-03-19 20:43:10'),
(422, '192', 'Perbaikan dan re Allignment Rail crane . Terutama sisi selatan', NULL, '7', '2025-04-05', '2025-03-19 20:44:53', '2025-03-19 20:44:53'),
(423, '193', 'Koordinasi dan pengaturan waktu istirahat bersama tim slitting', NULL, '7', '2025-04-05', '2025-03-19 21:12:02', '2025-03-19 21:12:02'),
(424, '194', 'Sosialisasi dan mengingatkan selalu, semua bahan (part, majun) yang terkontaminasi dengan B3 (Grease, Oli, chemical) dibuang pada tempat sampah Limbah B3', NULL, '7', '2025-03-22', '2025-03-24 20:44:06', '2025-03-24 20:44:06'),
(425, '194', 'Pemberian Spill kitt pada area yang berpotensi terjadi kebocoran', NULL, '9', '2025-03-22', '2025-03-24 20:44:06', '2025-03-24 20:44:06'),
(426, '194', 'Dilakukan pengecekan dan penggantian Hose, apabila ada indikasi retak atau bocor saat PM', NULL, '9', '2025-03-22', '2025-03-24 20:44:06', '2025-03-24 20:44:06'),
(427, '195', 'select and trial Workshop hardchrome', NULL, '7', '2025-02-28', '2025-03-24 20:57:18', '2025-03-24 20:57:18'),
(428, '196', 'Tidak ada pekerjaan crane di atas kantor, pengetesan di tentukan di area acces forklift depan PT tower dan area potgear apabila kosong', NULL, '7', '2025-01-31', '2025-03-24 21:04:02', '2025-03-24 21:04:02'),
(429, '196', 'Pasang sensor interlock travel Crane (Crane 10 T WH)', NULL, '4', '2025-02-28', '2025-03-24 21:04:02', '2025-03-24 21:04:02'),
(430, '196', 'Pindahkan kantor >> Proyek', NULL, '8', '2026-12-31', '2025-03-24 21:04:02', '2025-03-24 21:04:02'),
(431, '197', 'Pembelian hanya di Agen Resmi', NULL, '9', '2025-01-01', '2025-03-24 21:13:26', '2025-03-24 21:13:26'),
(432, '198', 'Diskusi tentang issue ini dengan pihak PT. Giken, untuk mencari solusi kedepan', NULL, '7', '2025-02-28', '2025-03-26 00:19:58', '2025-03-26 00:19:58'),
(433, '198', 'New worker from Giken already put Safety induction and Visit and look at condition crane at TML', NULL, '9', '2025-02-28', '2025-03-26 00:19:58', '2025-03-26 00:19:58'),
(434, '198', 'Request senior supervisor from Giken standby if any critical job', NULL, '7', '2025-02-28', '2025-03-26 00:19:58', '2025-03-26 00:19:58'),
(435, '199', 'Training Safety Driving', NULL, '39', '2025-03-31', '2025-03-26 01:02:34', '2025-03-26 01:02:34'),
(436, '199', 'Vaksin influenza', NULL, '39', '2025-03-31', '2025-03-26 01:02:34', '2025-03-26 01:02:34'),
(437, '200', 'Diatur waktu pekerjaannya di waktu yang sudah berkurang panas lingkungannya. terutama apabila pekerjaan yang harus naik dan mendekati ketinggian atap (PM Crane)', NULL, '7', '2025-02-28', '2025-03-26 01:07:15', '2025-03-26 01:07:15'),
(438, '200', 'Menghindari terjadinya Dehidrasi, dengan membawa minuman di Tumbler untuk bekerja di ketinggian', NULL, '7', '2025-02-28', '2025-03-26 01:07:15', '2025-03-26 01:07:15');
INSERT INTO `tindakan` (`id`, `id_riskregister`, `nama_tindakan`, `acuan`, `targetpic`, `tgl_penyelesaian`, `created_at`, `updated_at`) VALUES
(439, '201', '1. Pakta Integritas\r\n2. Dilaksanakan sesuai SOP Vendor Selection (IK.PR.05.02)\r\n3. Spesifikasi teknis yang Jelas\r\n4. Proses Negosiasi Final diserahkan ke Pihak Procurement.\r\n5. Dijalankan aturan untuk pelaporan sistem Whistle Blower', NULL, '7', '2025-03-31', '2025-03-26 01:14:34', '2025-03-26 01:14:34'),
(440, '206', '1. Pemindahan area Fabrikasi ke L8.\r\n2. Penggunaan Dia. Sink roll yang lebih kecil (600 mm) untuk menghilangkan defect \"ridgemark\" sehingga dapat supply Paint feed dengan tonase bear (8 ton) \r\n3. Karena saat trial #1, umur pakai sink roll hanya 11 hari dengan kondisi blade scrapper habis. Ditambahkan blade menjadi 3 buah yang sebelumnya 2 buah', NULL, '7', '2024-12-31', '2025-03-26 01:23:34', '2025-03-26 01:23:34'),
(442, '208', 'Penambahan Cable Power (1 Line per inductor)', NULL, '4', '2025-06-30', '2025-04-18 22:25:36', '2025-04-18 22:25:36'),
(443, '209', 'Order part Partial (PLC) agar tidak mengeluarkan biaya besar sekaligus', NULL, '4', '2026-06-30', '2025-04-20 00:36:32', '2025-04-20 00:36:32'),
(444, '209', 'Order Complete Gauge Head RS30i/45 Part No.841-000-100', NULL, '4', '2025-12-31', '2025-04-20 00:36:32', '2025-04-20 00:36:32'),
(445, '209', 'Order Part Process Electronics Cubicle O-Frame (panel CWG didalam pulpit)', NULL, '4', '2025-06-30', '2025-04-20 00:36:32', '2025-04-20 00:36:32'),
(446, '209', 'Order Part Local Cabinet O-Frame dan O-Frame Components (part di line)', NULL, '4', '2026-06-30', '2025-04-20 00:36:32', '2025-04-20 00:36:32'),
(447, '210', 'Pembelian Mesin Branding khusus UV (Markem 9450) Oleh produksi', NULL, '3', '2025-05-31', '2025-04-20 00:48:46', '2025-04-20 00:48:46'),
(448, '211', 'Training ERP', NULL, '4', '2025-12-31', '2025-04-20 02:13:25', '2025-04-20 02:13:25'),
(449, '211', 'Training APAR', NULL, '4', '2025-12-31', '2025-04-20 02:13:25', '2025-04-20 02:13:25'),
(450, '211', 'Training Hydrant', NULL, '4', '2025-12-31', '2025-04-20 02:13:25', '2025-04-20 02:13:25'),
(451, '211', 'Training SCBA', NULL, '4', '2025-12-31', '2025-04-20 02:13:25', '2025-04-20 02:13:25'),
(452, '211', 'Training Mitigasi ketika terjadi kebakaran', NULL, '4', '2025-12-20', '2025-04-20 02:13:25', '2025-04-20 02:13:25'),
(453, '212', 'Pembelian Unit Motor Listrik Spare (Order Berdasarkan Urgensi Motor tsb diline apabila terjadi Trouble)', NULL, '3', '2025-12-20', '2025-04-20 02:35:59', '2025-04-20 02:35:59'),
(454, '212', 'Pembelian Unit Bearing Motor (Insocote) untuk Bearing motor Drive (Indent 1 bulan)', NULL, '83', '2025-12-31', '2025-04-20 02:35:59', '2025-04-20 02:35:59'),
(455, '213', 'Pemasangan Sensor Vibration Monitoring pada Motor Exhaust Fan Cooling Tower', NULL, '83', '2025-12-31', '2025-04-20 02:40:41', '2025-04-20 02:40:41'),
(459, '217', 'menjaga ketebalan resin 1- 1,5 mikron\r\nuntuk menambah daya tahan terhadap \r\nkelembaban', NULL, '23', '2025-05-07', '2025-05-06 02:06:27', '2025-05-06 02:06:27'),
(460, '218', 'Install automatic fire system', NULL, '6', '2024-12-23', '2025-05-06 05:38:12', '2025-05-06 05:38:12'),
(461, '218', 'Penyiapan hydrant', NULL, '59', '2023-08-21', '2025-05-06 05:42:13', '2025-05-06 05:42:13'),
(462, '218', 'Training operator sebagai fire rescue', NULL, '60', '2024-08-19', '2025-05-06 05:42:13', '2025-05-06 05:42:13'),
(463, '219', 'Training on class (modul training)', NULL, '30', '2024-01-22', '2025-05-06 19:38:00', '2025-05-06 19:38:00'),
(464, '219', 'Keterlibatan operator dalam pembuatan procedure', NULL, '31', '2024-01-29', '2025-05-06 19:38:00', '2025-05-06 19:38:00'),
(465, '219', 'Dilibatkan dalam comissioning line', NULL, '30', '2024-01-08', '2025-05-06 19:38:00', '2025-05-06 19:38:00'),
(466, '220', 'Training terkait defect Galvalume CCL feed', NULL, '30', '2024-11-18', '2025-05-06 21:28:13', '2025-05-06 21:28:13'),
(467, '220', 'Membuat additional requirement technical spesifikasi bahan baku yang akan digunakan', NULL, '58', '2024-11-18', '2025-05-06 21:28:13', '2025-05-06 21:28:13'),
(468, '220', 'Monitoring qualitas feed mulai dari unpacking hingga ke line', NULL, '30', '2024-11-19', '2025-05-06 21:28:13', '2025-05-06 21:28:13'),
(469, '220', 'Penggunaan alat ukur yang sesuai, layak dan siap digunakan', NULL, '58', '2024-11-22', '2025-05-06 21:28:13', '2025-05-06 21:28:13'),
(470, '221', 'Training terkait defect Galvalume CCL feed', NULL, '58', '2024-08-09', '2025-05-07 00:06:47', '2025-05-07 00:06:47'),
(471, '221', 'Membuat additional requirement technical spesifikasi bahan baku yang akan digunakan', NULL, '58', '2024-09-16', '2025-05-07 00:06:47', '2025-05-07 00:06:47'),
(472, '221', 'Monitoring qualitas feed mulai dari unpacking hingga ke line', NULL, '30', '2024-10-14', '2025-05-07 00:06:47', '2025-05-07 00:06:47'),
(473, '221', 'Penggunaan alat ukur yang sesuai, layak dan siap digunakan', NULL, '30', '2024-11-11', '2025-05-07 00:06:47', '2025-05-07 00:06:47'),
(474, '222', 'Penyiapan training modul', NULL, '30', '2024-06-10', '2025-05-07 00:14:37', '2025-05-07 00:14:37'),
(475, '222', 'On Job training di pabrik yang similar', NULL, '30', '2024-06-17', '2025-05-07 00:14:37', '2025-05-07 00:14:37'),
(476, '222', 'Training on class', NULL, '30', '2024-06-24', '2025-05-07 00:14:37', '2025-05-07 00:14:37'),
(477, '222', 'Operator terlibat dalam commisioning', NULL, '30', '2025-07-07', '2025-05-07 00:14:37', '2025-05-07 00:14:37'),
(478, '222', 'Operator terlibat dalam pembuatan procedure', NULL, '30', '2024-07-15', '2025-05-07 00:14:37', '2025-05-07 00:14:37'),
(479, '222', 'Pemetaan skill matrix', NULL, '30', '2024-07-08', '2025-05-07 00:14:37', '2025-05-07 00:14:37'),
(480, '222', 'Rekruit operator yang sudah berpengalaman', NULL, '30', '2024-07-15', '2025-05-07 00:14:37', '2025-05-07 00:14:37'),
(481, '222', 'Create prosedur secara detail', NULL, '30', '2024-07-22', '2025-05-07 00:14:37', '2025-05-07 00:14:37'),
(482, '223', 'Membuat alternative supplier Galvalume', NULL, '47', '2025-05-31', '2025-05-07 03:07:52', '2025-05-07 03:07:52'),
(483, '224', 'Pembuatan sistem reporting konsumsi cat', NULL, '47', '2025-05-31', '2025-05-07 03:10:07', '2025-05-07 03:10:07'),
(484, '224', 'Membuat BOM menjadi lebih akurat', NULL, '47', '2025-05-31', '2025-05-07 03:10:07', '2025-05-07 03:10:07'),
(485, '225', 'Membuat system preventive maintenance', NULL, '59', '2025-05-31', '2025-05-07 03:21:04', '2025-05-07 03:21:04'),
(486, '225', 'Penyiapan critical spare part', NULL, '59', '2025-05-31', '2025-05-07 03:21:04', '2025-05-07 03:21:04'),
(487, '226', 'Pengecekan viscocity secara regular', NULL, '26', '2024-09-16', '2025-05-07 19:38:07', '2025-05-07 19:38:07'),
(488, '226', 'Penggunaan cat ready for used', NULL, '26', '2024-09-23', '2025-05-07 19:38:07', '2025-05-07 19:38:07'),
(489, '227', 'Schedulle menggunakan L3', NULL, '46', '2024-01-29', '2025-05-07 19:45:20', '2025-05-07 19:45:20'),
(490, '227', 'IK document menggunakan PDCA platform', NULL, '33', '2024-01-29', '2025-05-07 19:45:20', '2025-05-07 19:45:20'),
(491, '227', 'Approval Berita acara, IC, PI via MOXO', NULL, '33', '2024-01-29', '2025-05-07 19:45:20', '2025-05-07 19:45:20'),
(492, '227', 'Document review menggunakan MOXO', NULL, '33', '2024-01-29', '2025-05-07 19:45:20', '2025-05-07 19:45:20'),
(493, '227', 'Production report menggunakan system L3', NULL, '33', '2024-01-29', '2025-05-07 19:45:20', '2025-05-07 19:45:20'),
(494, '227', 'Test report menggunakan system L3', NULL, '33', '2024-01-29', '2025-05-07 19:45:20', '2025-05-07 19:45:20'),
(495, '228', 'Optimalisasi by pass RTO', NULL, '30', '2024-05-27', '2025-05-07 19:56:28', '2025-05-07 19:56:28'),
(496, '228', 'Optimalisasi schedulle produksi secara continue', NULL, '30', '2024-09-29', '2025-05-07 19:56:28', '2025-05-07 19:56:28'),
(497, '229', 'Pemilihan equipment melalui decision analysis', NULL, '30', '2024-09-22', '2025-05-07 20:00:15', '2025-05-07 20:00:15'),
(498, '230', 'Monitoring saat heating up', NULL, '26', '2024-09-23', '2025-05-07 20:05:46', '2025-05-07 20:05:46'),
(499, '230', 'Replace other brand', NULL, '26', '2024-09-23', '2025-05-07 20:05:46', '2025-05-07 20:05:46'),
(500, '230', 'Reposisi thermocouple', NULL, '26', '2024-09-23', '2025-05-07 20:05:46', '2025-05-07 20:05:46'),
(501, '230', 'Uncheck reference temperature selection di HMI', NULL, '26', '2024-09-23', '2025-05-07 20:05:46', '2025-05-07 20:05:46'),
(502, '231', 'Cleaning EPC sensor', NULL, '26', '2024-10-28', '2025-05-07 20:18:26', '2025-05-07 20:18:26'),
(503, '231', 'Cleaning camera EPC', NULL, '26', '2024-10-28', '2025-05-07 20:18:26', '2025-05-07 20:18:26'),
(504, '231', 'Penambahan PM schedulle EPC (lampu)', NULL, '26', '2024-10-28', '2025-05-07 20:18:26', '2025-05-07 20:18:26'),
(505, '232', '1. APD menggunakan sarung tangan chemical , ear muff, safety glass, apron', NULL, '10', '2020-01-08', '2025-05-07 20:24:18', '2025-05-07 20:24:18'),
(506, '233', 'Monitoring paint feed di entry section', NULL, '26', '2024-09-16', '2025-05-07 20:44:22', '2025-05-07 20:44:22'),
(507, '233', 'Create technical protocol dengan supplier', NULL, '58', '2024-09-16', '2025-05-07 20:44:22', '2025-05-08 01:49:34'),
(508, '233', 'Cancel schedulle', NULL, '26', '2024-09-16', '2025-05-07 20:44:22', '2025-05-07 20:44:22'),
(509, '233', 'Alokasikan untuk warna tertentu', NULL, '46', '2024-09-16', '2025-05-07 20:44:22', '2025-05-08 01:49:34'),
(510, '234', '1. APD sarung tangan , Chemical suit, masker, \r\n2. Wind direction \r\n3. Gas Detector\r\n4. Unloading dilakukan saat ada manpower terlatih\r\n5. unloading dilakukan disaat Produksi sedang berjalan', NULL, '10', '2025-01-01', '2025-05-07 20:50:19', '2025-05-07 20:50:19'),
(511, '235', 'Monitoring paint feed di entry section', NULL, '26', '2024-10-07', '2025-05-07 20:53:56', '2025-05-07 20:53:56'),
(512, '235', 'Create technical protocol dengan supplier', NULL, '58', '2024-10-07', '2025-05-07 20:53:56', '2025-05-07 20:53:56'),
(513, '235', 'Cancel schedulle', NULL, '26', '2024-10-07', '2025-05-07 20:53:56', '2025-05-07 20:53:56'),
(514, '235', 'Alokasikan untuk warna tertentu', NULL, '46', '2024-10-07', '2025-05-07 20:53:56', '2025-05-08 01:57:02'),
(515, '236', 'Monitoring paint feed di entry section', NULL, '26', '2024-10-14', '2025-05-07 20:58:55', '2025-05-07 20:58:55'),
(516, '236', 'Create technical protocol dengan supplier', NULL, '58', '2024-10-14', '2025-05-07 20:58:55', '2025-05-07 20:58:55'),
(517, '236', 'Cancel schedulle', NULL, '26', '2024-10-14', '2025-05-07 20:58:55', '2025-05-07 20:58:55'),
(518, '236', 'Alokasikan untuk warna tertentu', NULL, '46', '2024-10-14', '2025-05-07 20:58:55', '2025-05-07 20:58:55'),
(519, '237', 'Trial minimum dan maximum set point', NULL, '26', '2024-10-21', '2025-05-07 21:03:37', '2025-05-07 21:03:37'),
(520, '237', 'Catenary height Prime oven set 890mm', NULL, '26', '2024-10-21', '2025-05-07 21:03:37', '2025-05-07 21:03:37'),
(521, '237', 'Catenary height Finish oven set 1185mm', NULL, '26', '2024-10-21', '2025-05-07 21:03:37', '2025-05-07 21:03:37'),
(522, '237', 'Sensor di cover untuk menghindari terhalang oleh binatang atau kotoran', NULL, '26', '2024-10-21', '2025-05-07 21:03:37', '2025-05-07 21:03:37'),
(523, '237', 'Setting IO PLC', NULL, '26', '2024-10-21', '2025-05-07 21:03:37', '2025-05-07 21:03:37'),
(524, '238', 'Create guidance SP size vs line speed', NULL, '30', '2024-09-16', '2025-05-07 21:09:02', '2025-05-07 21:09:02'),
(525, '238', 'Set oven otomatis by L3', NULL, '5', '2024-09-16', '2025-05-07 21:09:02', '2025-05-07 21:09:02'),
(526, '238', 'Coater tidak bisa apply jika deviasi antara SP vs PV >30C', NULL, '5', '2024-09-16', '2025-05-07 21:09:02', '2025-05-07 21:09:02'),
(527, '238', 'RC Fan fail maka coater disengage', NULL, '5', '2024-09-16', '2025-05-07 21:09:02', '2025-05-07 21:09:02'),
(528, '238', 'Pengecekan thermax paper', NULL, '26', '2024-09-16', '2025-05-07 21:09:02', '2025-05-07 21:09:02'),
(529, '238', 'Pengukuran menggunakan pyrometer', NULL, '5', '2024-09-16', '2025-05-07 21:09:02', '2025-05-07 21:09:02'),
(530, '239', '1. Mempersiapka APAR dan Hydrant\r\n2. Spanduk peringatan agar tidak menyalakan api di sekitar area Tangki solar \r\n3. Pemberian tembok dan pintu agar hanya petugas yang berwenang saja yang boleh masuk', NULL, '10', '2023-03-06', '2025-05-07 23:12:55', '2025-05-07 23:12:55'),
(531, '240', 'Metode Pengisian menggunakan perhitungan untuk pengisian maximal 80% (16 m3)', NULL, '11', '2019-11-22', '2025-05-08 00:04:05', '2025-05-08 00:04:05'),
(532, '241', '1. Equipment Electric di beri tagging , bukti bahwa equipment sudah di cek oleh electric , tagging akan di perbarui setiap 3 bulan sekali\r\n2. Seluruh Panel di area utility akan di beri grounding di standart kan agar safe \r\n3. Training basic electrical', NULL, '10', '2023-05-08', '2025-05-08 00:11:23', '2025-05-08 00:11:23'),
(533, '41', 'Memperbaiki sistem pengolahan dan penanganan limbah', NULL, '1', '2024-11-30', '2025-05-08 00:21:35', '2025-05-08 00:21:35'),
(534, '41', 'Melakukan pengetesan emisi yang dihasilkan setiap 12 bulan', NULL, '60', '2024-11-30', '2025-05-08 00:21:35', '2025-05-08 00:21:35'),
(535, '41', 'Kemasan bekas alkali, passivation, cat, thinner dikembalikan ke supplier', NULL, '47', '2024-11-30', '2025-05-08 00:21:35', '2025-05-08 00:21:35'),
(536, '242', '1. Menggunakan PAM di pabrik L8 , L1 , L10 dan L3', NULL, '11', '2021-04-30', '2025-05-08 00:40:24', '2025-05-08 00:40:24'),
(537, '243', 'Penggunaan VCI dan pallet ex paint import untuk product Hitam Lorentz.', NULL, '48', '2025-01-31', '2025-05-09 19:34:11', '2025-05-09 19:34:11'),
(538, '244', 'penambahan pompa dan jalur pipa untuk pemanfaatan air hujan dari gedung sisi selatan', NULL, '10', '2025-06-15', '2025-05-12 19:18:53', '2025-05-12 19:18:53'),
(539, '245', 'pengenalan whistle blowing dan spanduk', NULL, '10', '2025-06-14', '2025-05-12 20:23:14', '2025-05-12 20:23:14'),
(540, '61', 'Pembuatan tempat khusus untuk material support (Steel Sleeve, Pallet, Material Stuffing)', NULL, '48', '2025-05-31', '2025-05-12 22:04:09', '2025-05-12 22:04:09'),
(541, '246', 'Implementasi kebijakan anti penyuapan', NULL, '59', '2025-09-30', '2025-05-14 21:30:56', '2025-05-14 21:30:56'),
(542, '247', 'Review beban kerja dan kebutuhan penambahan personil disesuaikan dengan business plan (penambahan mesin).', NULL, '47', '2025-03-31', '2025-05-14 22:20:22', '2025-05-14 22:20:22'),
(543, '248', 'Lakukan pengecekan kualitas lebih ketat saat barang datang, terutama saat musim ekstrem', NULL, '13', '2025-05-28', '2025-05-27 19:58:10', '2025-05-27 19:58:10'),
(544, '248', 'Komunikasikan standar penyimpanan ke supplier', NULL, '13', '2025-06-06', '2025-05-27 19:58:10', '2025-05-27 19:58:10'),
(545, '248', 'Audit atau visit ke supplier untuk memastikan kesiapan mereka menghadapi dampak cuaca', NULL, '13', '2025-06-06', '2025-05-27 19:58:10', '2025-05-27 19:58:10'),
(546, '248', 'Jika perlu, ganti supplier yang tidak punya sistem handling yang memadai', NULL, '13', '2025-06-06', '2025-05-27 19:58:10', '2025-05-27 19:58:10'),
(547, '249', 'Folow Up pihak berkepentingan untuk mencari solusi terhadap budget yang belum diinput diprogram Puskom', NULL, '97', '2025-06-30', '2025-05-27 19:58:21', '2025-05-27 21:45:38'),
(550, '251', 'Monthly Meeting dengan Customer & Vendor \\untuk menentukan kebutuhan M+1 dan prioritas kebutuhan dari Customer', NULL, '12', '2025-12-31', '2025-05-27 20:35:51', '2025-05-27 20:35:51'),
(551, '251', 'Membuat Buffer Stock untuk bahan baku CRC.', NULL, '12', '2025-06-30', '2025-05-27 20:35:51', '2025-05-27 20:35:51'),
(552, '252', 'Koordinasi dengan team Produksi, MTC, Utility dan Electric terkait Rencana Produksi saat Meeting S&OP', NULL, '12', '2025-06-30', '2025-05-27 20:47:31', '2025-05-27 20:47:31'),
(555, '254', '- Lakukan Monitoring ETA raw material (Lokal & Import) \r\n - Request VMI ke Supplier ?', NULL, '12', '2025-12-31', '2025-05-27 21:06:40', '2025-05-27 21:06:40'),
(556, '255', 'Menerapkan kebijakan evaluasi supplier dengan objektif dan transparan (Menggunakan kriteria Mutu, Harga, Pelayanan, dan Pengiriman)', NULL, '13', '2025-05-30', '2025-05-27 21:13:18', '2025-05-27 21:13:18'),
(557, '255', 'Mewajibkan supplier menandatangani pernyataan anti-suap.', NULL, '13', '2025-05-28', '2025-05-27 21:13:18', '2025-05-27 21:13:18'),
(558, '256', 'Menggunakan sistem scoring yang jelas dalam seleksi supplier.', NULL, '13', '2025-05-30', '2025-05-27 21:15:03', '2025-05-27 21:15:03'),
(559, '256', 'Melibatkan lebih dari satu pihak dalam keputusan pengadaan untuk menghindari konflik kepentingan.', NULL, '13', '2025-05-30', '2025-05-27 21:15:03', '2025-05-27 21:15:03'),
(560, '257', 'Menyesuaikan rencana produksi spy sesuai dgn standarisasi yang berlaku', NULL, '101', '2020-05-20', '2025-05-27 21:24:29', '2025-05-27 21:24:29'),
(565, '261', 'nqox aasc', 'jwqnxa xas', '105', '2025-09-10', '2025-09-04 01:49:33', '2025-09-04 01:49:33'),
(566, '262', 'tezzzzzzzzzzz', 'tezzzzzzzzzzzzzzz', '105', '2025-09-06', '2025-09-05 18:18:52', '2025-09-05 18:18:52'),
(567, '263', 'tezzzzzzzzzzzz', 'tezzzzzzzzzzzz', '106', '2025-09-16', '2025-09-15 19:16:29', '2025-09-15 19:16:29');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `divisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama_user`, `email`, `password`, `role`, `type`, `divisi`, `created_at`, `updated_at`) VALUES
(1, 'Taswono', 'taswono@tatalogam.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"9\"]', 'HR & GA SDG', NULL, '2024-11-13 18:51:29'),
(2, 'Group Moxo PPK MFG', '5fb5bc550559143ed97b76d562659a3ac@tatalogam.moxo.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"1\",\"2\",\"3\",\"4\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"17\",\"18\",\"19\",\"21\",\"22\",\"23\",\"25\",\"26\",\"27\"]', 'MANUFACTURING', NULL, '2024-11-13 18:53:19'),
(3, 'Ossa', 'ossa.adi@tatalogam.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'manager', '[\"3\"]', 'MTC MEC & ELC CKR', NULL, '2024-12-06 18:56:22'),
(4, 'Sugiyono', 'sugiyono@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'manager', '[\"1\"]', 'MTC MEC & ELC CKR', NULL, '2024-11-13 18:55:16'),
(5, 'Maskula', 'ahmad.maskula@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"4\"]', 'MTC MEC, ELC & UTL SDG', NULL, '2024-11-13 18:58:02'),
(6, 'Rama Hasan H', 'rama.hasan@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"2\"]', 'PRODUCTION SDG', NULL, '2024-11-13 18:55:28'),
(7, 'Tugiyanto', 'tugiyanto@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'manager', '[\"3\"]', 'MTC MEC & ELC CKR', NULL, '2025-02-28 22:50:15'),
(8, 'Roby Risanda', 'roby@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'manager', '[\"3\"]', 'MTC MEC & ELC CKR', NULL, '2024-11-13 18:55:04'),
(9, 'Ilham Jamaludin', 'ilham.jamaludin@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'manager', '[\"3\"]', 'MTC MEC & ELC CKR', NULL, '2024-12-06 20:29:51'),
(10, 'Dian Persada', 'dian.persada@tatametal.com', '$2y$10$tedMvJOPbrcRfgHeMyzzyekUQI7pRWWx8OguOsSrmCQ1HYvNJSphS', 'manager', '[\"7\"]', 'MTC UTILIYY CKR', NULL, '2025-03-16 21:27:04'),
(11, 'Ferdinandus Paulus Tirtadinata', 'ferdinandus@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'manager', '[\"7\"]', 'MTC UTILIYY CKR', NULL, '2024-11-13 19:00:15'),
(12, 'Lili Yusuf', 'lili.yusuf@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"19\"]', 'PPIC & DELIVERY', NULL, '2024-11-13 19:01:34'),
(13, 'Krismanto Susilo', 'krismanto.susilo@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'manager', '[\"18\"]', 'PROCUREMENT', NULL, '2024-11-13 19:04:23'),
(14, 'Agus Wicaksono', 'agus.wicaksono@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'manager', '[\"1\"]', 'PRODUCTION CKR', NULL, '2024-11-13 18:59:32'),
(15, 'Ahmed Nugroho', 'ahmed.nugroho@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"1\"]', 'PRODUCTION CKR', NULL, '2024-11-13 18:53:27'),
(16, 'Ari Octaviyan', 'ari.octaviyan@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"1\"]', 'PRODUCTION CKR', NULL, '2024-11-13 18:53:41'),
(17, 'Arsy Kusumagraha', 'arsy.kusumagraha@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"1\"]', 'PRODUCTION CKR', NULL, '2024-11-13 18:56:04'),
(18, 'Diska Bustanul Hadi', 'diska@tatalogam.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'manager', '[\"1\"]', 'PRODUCTION CKR', NULL, '2025-05-05 00:23:31'),
(19, 'Mohamad Ramdhani', 'mohamad.ramdhani@tatametal.com', '$2y$10$8R005a2DYSCUETkqEHF5oenW0WOrnlp77e3MN1QaByjR0xfcLyA96', 'admin', '[\"1\",\"2\",\"3\",\"4\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"17\",\"18\",\"19\",\"21\",\"22\",\"23\",\"25\",\"26\",\"27\"]', 'PRODUCTION CKR', NULL, '2024-11-13 18:53:49'),
(20, 'Satmoko', 'satmoko@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"1\"]', 'PRODUCTION CKR', NULL, '2024-11-13 18:55:43'),
(21, 'Izan', 'andika.bachtiar@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"1\"]', 'PRODUCTION CKR', NULL, '2024-11-13 18:55:51'),
(22, 'Ditta Pratama', 'ditta.pratama@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'manager', '[\"28\"]', 'ENGINEERING', NULL, '2024-12-06 18:36:51'),
(23, 'Imam Qoirudin', 'imam.qoirudin@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"1\"]', 'PRODUCTION CKR', NULL, '2024-11-13 18:56:33'),
(24, 'Ho alex marjoko', 'alex.ho@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"1\"]', 'PRODUCTION CKR', NULL, '2024-11-13 18:56:44'),
(25, 'Zulkifli', 'zulkifli@tatalogam.com', '$2y$10$bAfO1Psg86V8y0CDAR0EhO9Wm3kZ8ov3pGpwfdKbZMR7GUYmZfUWu', 'admin', '[\"1\",\"2\",\"3\",\"4\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"17\",\"18\",\"19\",\"21\",\"22\",\"23\",\"25\",\"26\",\"27\",\"28\"]', 'PRODUCTION CKR', NULL, '2024-12-06 18:53:13'),
(26, 'Shift Leader Produksi', 'leader.prd@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"1\"]', 'PRODUCTION CKR', NULL, '2024-11-13 18:57:07'),
(27, 'Rendra Fernanda', 'rendra.fernanda@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'manajemen', '[\"1\",\"2\",\"3\",\"4\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"17\",\"18\",\"19\",\"21\",\"22\",\"23\",\"25\",\"26\",\"27\"]', 'MANUFACTURING', NULL, '2024-11-13 19:01:09'),
(28, 'Ali Mahfut', 'ali.mahfut@tatalogam.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"1\"]', 'PRODUCTION CKR', NULL, '2024-11-13 18:58:27'),
(29, 'Tony Widy Utomo', 'toni.widi@tatalogam.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"1\"]', 'PRODUCTION CKR', NULL, '2024-11-13 18:56:54'),
(30, 'Ahmad Faozan', 'ahmad.faozan@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'manager', '[\"2\"]', 'PRODUCTION SDG', NULL, '2024-11-13 18:59:09'),
(31, 'Dami Arta', 'dami.arta@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"2\"]', 'PRODUCTION SDG', NULL, '2024-11-13 19:00:00'),
(32, 'Fauzan Dini Fadhillah', 'fauzan.fadhillah@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"2\"]', 'PRODUCTION SDG', NULL, '2024-11-13 19:02:20'),
(33, 'Guruh Sindu', 'guruh.putra@tatametal.com', '$2y$10$crQpQZV/oQz2s7SmAs5PouHGA.8OaObAlG5s16DwHC7tm5Betz4fm', 'manager', '[\"2\"]', 'PRODUCTION SDG', NULL, '2024-11-13 19:02:47'),
(34, 'Benny Saputro', 'benny.saputro@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"11\"]', 'QA CKR', NULL, '2024-11-13 19:02:01'),
(35, 'Muhammad Nanang', 'muhammad.nanang@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'manager', '[\"11\"]', 'QA CKR', NULL, '2025-07-30 00:44:44'),
(36, 'Wahyu Bagas', 'wahyu.laksana@tatametal.com', '$2y$10$gB/Y47fQE2Q8xa1czIyZ2.z0dbi3i5b3jCrMnSdOLHCnr8uBy4ef.', 'manager', '[\"11\",\"12\",\"26\"]', 'QA CKR', NULL, '2025-05-07 18:30:56'),
(37, 'Sigit Sejati', 'sigit.sejati@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'manager', '[\"12\"]', 'QA SDG', NULL, '2024-11-13 19:03:50'),
(38, 'Hizbul', 'hizbul.sabiilafurqon@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"10\"]', 'SAFETY CKR', NULL, '2024-11-13 19:02:10'),
(39, 'Ade Kurniawan', 'ade.kurniawan@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'manager', '[\"10\",\"27\"]', 'SAFETY CKR', NULL, '2024-11-13 19:02:58'),
(41, 'Brigitta Maria Suharwati', 'suharwati.brigitta@tatametal.com', '$2y$10$.DL9MTfh2VdE35dw9eH69.p2rSvnFW4pdGMokCwR.QJsOFjhDqs1W', 'manager', '[\"13\"]', 'SUPPLY CHAIN & WAREHOUSE CKR', NULL, '2025-03-05 18:25:10'),
(42, 'Freddy', 'freddy.tampubolon@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"13\"]', 'SUPPLY CHAIN & WAREHOUSE CKR', NULL, '2024-11-13 19:00:57'),
(43, 'Riyan Hidayat', 'riyan.hidayat@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"13\"]', 'SUPPLY CHAIN & WAREHOUSE CKR', NULL, '2024-11-13 19:04:46'),
(44, 'Panggah Sahistyo', 'panggah@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"13\"]', 'SUPPLY CHAIN & WAREHOUSE CKR', NULL, '2024-11-13 18:51:04'),
(45, 'Antonius Danu Kurniawan', 'antonius.danu@tatametal.com', '$2y$10$J9cw9kbCXawm/Y083r09X.3sAWwxGhCuBB4lp/4THUGOneXng5Qb6', 'staff', '[\"13\"]', 'SUPPLY CHAIN & WAREHOUSE CKR', NULL, '2024-11-13 19:03:21'),
(46, 'Andi Setiawan', 'andi.setiawan@tatametal.com', '$2y$10$fC6SMlz70RnQnFurL4ICx.RcGRH1sAmwmYTZ8SetEu2o5heBHBDVy', 'manager', '[\"14\"]', 'SUPPLY CHAIN & WAREHOUSE SDG', NULL, '2025-03-06 20:15:34'),
(47, 'Asep Hilman', 'asep.hilman@tatametal.com', '$2y$10$Nc7vbSZ5uncljpzXwU1N.uyeGtiRI164symob8QvOmS8H1c87Cv7e', 'manager', '[\"14\"]', 'SUPPLY CHAIN & WAREHOUSE SDG', NULL, '2024-11-13 19:05:14'),
(48, 'Bakhtarudin', 'bakhtarudin@tatametal.com', '$2y$10$7C7gbPqyWq4O6u53oJjxhOlzrZK3jz6wAVQ8KIta3YJpG.YeeotIm', 'staff', '[\"14\"]', 'SUPPLY CHAIN & WAREHOUSE SDG', NULL, '2024-11-13 19:04:07'),
(49, 'ADMIN', 'admin@admin.com', '$2y$10$li23JNz7pOctbL58gNMsJeqV2EMbSxuUQj.t3PIWf.3fLXi9HBCfm', 'admin', '[\"1\",\"2\",\"3\",\"4\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"17\",\"18\",\"19\",\"21\",\"22\",\"23\",\"25\",\"26\",\"27\",\"28\"]', 'MANUFACTURING', '2024-09-04 01:55:23', '2025-03-02 20:17:32'),
(50, 'USER', 'user@user.com', '$2y$10$V3dkixsBQhmuMoPSZzMwYusVT..a0wXNdemT02G0TSOk1uojFWb3e', 'manajemen', '[\"1\"]', 'PRODUCTION CKR', '2024-09-04 01:55:53', '2024-12-25 20:48:50'),
(54, 'Erlina Primastuty', 'erlina@tatametal.com', '$2y$10$XCvi7v1sqNM8T9RLSviD1eF8wigJcm4SkhnQMDa2quG5uavNbn1XW', 'manager', '[\"10\",\"27\"]', 'SAFETY CKR', '2024-11-03 18:57:29', '2024-12-20 20:20:21'),
(55, 'Yudhy Krisnadi', 'yudhi@tatametal.com', '$2y$10$PLuqKHgNgw9bhMZ870erre0gQKwPmEXuJFCFcSV20MD53IqrOcwuW', 'manager', '[\"11\",\"12\",\"26\"]', 'QA CKR', '2024-11-03 20:18:24', '2024-11-13 19:03:08'),
(56, 'Vian D Pratama', 'vian.pratama@tatametal.com', '$2y$10$qr2JUp5sYcQcka4jmMwyveXrBrqJSWqJIDynoVfxo4nf674l5fkfW', 'manajemen', '[\"1\",\"2\",\"3\",\"4\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"17\",\"18\",\"19\",\"21\",\"22\",\"23\",\"25\",\"26\"]', 'MANUFACTURING', '2024-11-04 18:43:39', '2024-11-13 19:05:26'),
(57, 'Luthfi Fathoni', 'luthfi.fathoni@tatametal.com', '$2y$10$ei.DPGW3YKQ3RixsA6OFgucQ8iHDsr3emDOfzO.xKKqtUsmFBSsgi', 'manager', '[\"12\"]', 'QA SDG', '2024-11-04 20:25:21', '2024-11-13 19:03:37'),
(58, 'Genby Ardinugraha', 'genby.ardinugraha@tatametal.com', '$2y$10$jG6rLWOHsdmDV..zh53Go.cN1.zry.lwUAVBmperikpyfpf7r7dsa', 'manager', '[\"12\"]', 'QA SDG', '2024-11-04 20:26:11', '2024-11-13 19:01:48'),
(59, 'Darmawan', 'darmawan@tatametal.com', '$2y$10$4FQ9PdU7s3IpgMUCqNamre8Sj5T601rTW.q2I6QgAn5ojQYJo.PNa', 'manager', '[\"4\"]', 'MTC MEC, ELC & UTL SDG', '2024-11-04 23:34:26', '2024-11-13 18:57:33'),
(60, 'Dede Hoerudin', 'dede.hoerudin@tatametal.com', '$2y$10$Cy/TgKYFUUATW0hTkL4bpeL82mjTnL8N5ubmesNtBRpb7EH5DJO5C', 'manager', '[\"10\",\"27\"]', 'SAFETY SDG', '2024-11-04 23:36:23', '2024-12-16 01:48:19'),
(61, 'Manajemen tes', 'manajemen@tes.com', '$2y$10$C8ogUYfalovMRt7CDsf4q.xrPL0RHvt6A8r8KXuxzpDMuFQM4TDOO', 'admin', '[\"1\",\"2\",\"3\",\"4\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"17\",\"18\",\"19\",\"21\",\"22\",\"23\",\"25\",\"26\",\"27\",\"28\"]', 'MANUFACTURING', '2024-11-08 20:28:50', '2025-05-06 00:47:53'),
(62, 'manager', 'manager@manager.com', '$2y$10$xC0WUC8jiEcULoYVzYNhrunmPqgXnfb4JHcEUtJrycqEF05vxlmvm', 'manager', '[\"1\"]', 'QA CKR', '2024-11-10 18:28:29', '2025-05-15 18:41:24'),
(64, 'Prayoga Dwi Darya', 'prayoga.prasanta@tatametal.com', '$2y$10$LX.aKKEpr9kMes/QU9mIrOCgwv2Mx/NqdgSxtrUtWLUWr3WUlYRlS', 'staff', '[\"1\"]', 'PRODUCTION CKR', '2024-11-20 19:08:16', '2024-11-20 19:08:16'),
(65, 'Anto Wijoyo', 'anto.wijoyo@tatametal.com', '$2y$10$KslaqdFM8D6YG/NIsrSU8OShJD5.nT0pxH0G843wRqdRU0pWvTPeq', 'manager', '[\"28\"]', 'ENGINEERING', '2024-12-06 18:54:27', '2024-12-06 18:54:27'),
(66, 'Khusnul Diah Pratiwi', 'khusnul.pratiwi@tatametal.com', '$2y$10$4/refCqyn0/8MBSugjF8MuClhcJCLwrJZRX7vObjZksfOcBy9rfQq', 'manager', '[\"7\"]', 'MTC UTILIYY CKR', '2024-12-06 19:05:51', '2024-12-06 19:05:51'),
(67, 'Nyoman Pujiani', 'nyoman.pujiani@tatametal.com', '$2y$10$bq4pvW9kirFAV6ztViDdi.bnMF85RI0LWaVii/eFOSihJWibJGItO', 'manajemen', '[\"17\",\"21\",\"28\",\"8\",\"9\",\"23\",\"26\",\"25\",\"3\",\"4\",\"7\",\"19\",\"18\",\"1\",\"2\",\"11\",\"12\",\"10\",\"27\",\"15\",\"13\",\"14\",\"22\"]', 'MANUFACTURING', '2025-02-25 19:57:26', '2025-02-25 19:57:26'),
(69, 'Herlambang', 'herlambang@tatametal.com', '$2y$10$jhNpZqd7FfIGHeApqhOag.XxhuG.wEHO8v97SEVpEsSztBJn7s74S', 'staff', '[\"3\"]', 'MTC MEC & ELC CKR', '2025-02-28 22:45:50', '2025-02-28 22:45:50'),
(70, 'Daris Farras', 'daris.farras@tatametal.com', '$2y$10$cCKxYdf2ST8I989mN4L1YuCWP6uCsMPhphG7Jw90M4xP2K2iBv/f6', 'staff', '[\"3\"]', 'MTC MEC & ELC CKR', '2025-02-28 22:48:52', '2025-02-28 22:48:52'),
(71, 'Ardiansa Nasution', 'ardiansa.nasution@tatametal.com', '$2y$10$zleg5sczthecVE.PUyOMFuVnHegsnKqVtMl6326Q0V/IY8dBrbDuC', 'staff', '[\"3\"]', 'MTC MEC & ELC CKR', '2025-02-28 22:53:05', '2025-02-28 22:54:14'),
(72, 'Michael Andreanus', 'michael.andreanus@tatametal.com', '$2y$10$WMAoC9s6tItTVebtFbPOe.pYW6DIEK69oPSPxP7O5sMvMEiT.xhUe', 'manager', '[\"13\"]', 'SUPPLY CHAIN & WAREHOUSE CKR', '2025-03-05 18:30:41', '2025-03-05 18:30:41'),
(73, 'Wahyu ricci', 'wahyu.ricci@tatametal.com', '$2y$10$6PL2SlNAylw39HR5LsHyb.VqYt8lOT/hX5qIY2SGUnFu2jv4EwXOO', 'staff', '[\"13\"]', 'SUPPLY CHAIN & WAREHOUSE CKR', '2025-03-06 20:09:21', '2025-03-06 20:09:21'),
(74, 'Lidwina Prista', 'lidwina.prista@tatalogam.com', '$2y$10$cQINV1VocytkZ653z9xPSO8UcLXAeZCaFzQi8X1HzxlAZmrRMdkOC', 'staff', '[\"13\"]', 'SUPPLY CHAIN & WAREHOUSE CKR', '2025-03-06 20:10:58', '2025-03-06 20:10:58'),
(75, 'Veronika Lia', 'veronika.lia@tatalogam.com', '$2y$10$VLKPW/QqiQvQbjdoFiXHfesNbWEz0OHcMuY5Mp8maRAnZTe.flLRm', 'staff', '[\"13\"]', 'SUPPLY CHAIN & WAREHOUSE CKR', '2025-03-06 20:11:50', '2025-03-06 20:11:50'),
(76, 'Andhika Prabowo Canandian', 'andhika.prabowo@tatametal.com', '$2y$10$CsbcyOcY52zYvY4GExheDORqXsiP79RffO6atvyidxZ0gvMpqKaBy', 'staff', '[\"13\"]', 'SUPPLY CHAIN & WAREHOUSE CKR', '2025-03-06 20:13:10', '2025-03-06 20:13:10'),
(77, 'Gerraldo Valentino', 'gerraldo.valentino@tatametal.com', '$2y$10$XNM2fDcLBSJeDvnHOB6ryuMmU7SD0eAoo9FWnGSuEYcEYjEsZ/Gpq', 'staff', '[\"13\"]', 'SUPPLY CHAIN & WAREHOUSE CKR', '2025-03-06 20:14:31', '2025-03-06 20:14:31'),
(78, 'Shift Leader WH CKR', 'ShiftLeaderWHCKR@tatametal.com', '$2y$10$aAhrRWGMMhitd7KRUux67uKT3l1z2s4WhzRRjUdpvFvpsOwU8UX.2', 'staff', '[\"13\"]', 'SUPPLY CHAIN & WAREHOUSE CKR', '2025-03-06 20:21:50', '2025-03-06 20:21:50'),
(79, 'Wahyu Agung Rifai', 'agung.rifai@tatametal.com', '$2y$10$I36DntczHu7TueAEn89Ql.Lu37lMDqvxRPYzYYkxVvGcDUPGguKW2', 'staff', '[\"13\"]', 'SUPPLY CHAIN & WAREHOUSE CKR', '2025-03-06 23:09:54', '2025-03-06 23:09:54'),
(80, 'Gladys Samantha', 'gladys.samantha@tatametal.com', '$2y$10$YM/Xopeej62HHJ40/nXDFe0QA8CmSyPunLq9NDnJKPdz4WDLBAA2W', 'staff', '[\"13\"]', 'SUPPLY CHAIN & WAREHOUSE CKR', '2025-03-06 23:11:39', '2025-03-06 23:11:39'),
(81, 'Ignas', 'ignas@tatametal.com', '$2y$10$4CB.df.O7SNqTb7FtSlpRecswxgyZGG.kpZs2vyQbASMWduwilDgu', 'staff', '[\"13\"]', 'SUPPLY CHAIN & WAREHOUSE CKR', '2025-03-06 23:12:29', '2025-03-06 23:12:29'),
(82, 'Lydia anastashia', 'lydia.anastashia@tatametal.com', '$2y$10$xP1q3BtA0cTLcv2RKyWx8eW5UORKBtPFhE80XkYGYBFdtPbLIFzQi', 'manager', '[\"18\"]', 'PROCUREMENT', '2025-03-19 20:39:04', '2025-03-19 20:39:04'),
(83, 'Zul Fahmi Idris', 'zul.fahmi@tatametal.com', '$2y$10$l6AVEFLe9mm40tZx/gImV.TOQZ4/y2BDvsDprnWwdIf9XUFI64FMe', 'staff', '[\"3\"]', 'MTC MEC DAN ELC CKR', '2025-04-18 22:47:13', '2025-04-18 22:47:13'),
(84, 'tes supervisor', 'test@test.com', '$2y$10$ges534hmqkEa/AbZTj9BWevxGFzjNEX9WGNZn99.w4hS0MdaI0kWy', 'manager', '[\"31\"]', 'TES DEPARTEMEN', '2025-05-07 19:01:40', '2025-05-27 19:25:54'),
(85, 'Damar Pietradagya Dewantara', 'damar.dewantara@tatametal.com', '$2y$10$u2AkEPjMUgzdJI/gKjIlbOd2E7vSXBUi.Ks5N0fBGp4UfwMLEJiFW', 'manager', '[\"1\"]', 'PRODUCTION SDG', '2025-05-08 20:52:41', '2025-05-08 20:52:41'),
(86, 'Ryan Aaron Aditya Geta', 'ryan.geta@tatametal.com', '$2y$10$cfuIQUw.gwN/vRaSJtkVWuVMz86TdedagZOWLKd5Jn/FE5HdaeW2.', 'manager', '[\"2\"]', 'PRODUCTION SDG', '2025-05-08 20:53:37', '2025-05-08 20:53:37'),
(87, 'Ilham Pandu Anggoro', 'ilham.anggoro@tatametal.com', '$2y$10$zX6dc4KHt2BpqB0WSx6yCuMystXyvlTW73y1iDlRC1g1tnOg3p42a', 'manager', '[\"2\"]', 'PRODUCTION SDG', '2025-05-08 20:54:27', '2025-05-08 20:54:27'),
(88, 'Teuku Rizki Reynaldy', 'teuku.reynaldy@tatametal.com', '$2y$10$6ibJ.DoPYMlvHz2D6SjiVur/aE42fANOml9IP8EWIarBtIkFMB3YG', 'staff', '[\"10\",\"27\"]', 'SAFETY CKR', '2025-05-08 20:56:46', '2025-05-08 20:56:46'),
(89, 'Nadya Permata Kamila', 'nadya.kamila@tatametal.com', '$2y$10$Grr3rRczrPm.JTyLlZ5omerefGH8VaAkhInT/ynZTT7P4.DMjkOdO', 'manager', '[\"12\"]', 'QA SDG', '2025-05-13 23:56:24', '2025-05-13 23:56:24'),
(90, 'Achmad Suyono', 'achmad.suyono@tatametal.com', '$2y$10$2s4MN0wTaYR6yvyy54E1hOyhZnkYtvFs6usFT9YBH/TNaX26/NFQa', 'manager', '[\"12\"]', 'QA SDG', '2025-05-14 00:09:53', '2025-05-14 00:09:53'),
(91, 'Henny', 'henny@sakuratruss.com', '$2y$10$JwmYxHLtk316UmSvhPUGZun/55yI/DzDQyHsiYY5W9l6tkI5lBwNC', 'manajemen', '[\"17\",\"21\",\"28\",\"8\",\"9\",\"23\",\"26\",\"25\",\"3\",\"4\",\"7\",\"19\",\"18\",\"1\",\"2\",\"11\",\"12\",\"10\",\"27\",\"15\",\"13\",\"14\",\"22\"]', 'MANUFACTURING', '2025-05-19 19:55:38', '2025-05-19 19:55:38'),
(92, 'Fallen', 'fallen@sakuratruss.com', '$2y$10$K1JyR/kKW/d2GJn/qRJw.up005/ZJF7rf4kur6gcBCkiyJFNHc2E2', 'manajemen', '[\"17\",\"21\",\"28\",\"8\",\"9\",\"23\",\"26\",\"25\",\"3\",\"4\",\"7\",\"19\",\"18\",\"1\",\"2\",\"11\",\"12\",\"10\",\"27\",\"15\",\"13\",\"14\",\"22\"]', 'MANUFACTURING', '2025-05-19 19:56:18', '2025-05-27 19:22:13'),
(93, 'Andry Ratman', 'andry.ratman@tatametal.com', '$2y$10$wpkgcaAJF0evRve1aA54S.eFhg11JKxt4zOBUw2qedWavYQUr7/UC', 'manager', '[\"19\"]', 'PPIC DAN DELIVERY', '2025-05-27 19:05:32', '2025-05-27 19:05:32'),
(94, 'Jeff Jehezkiel Mario', 'jeff.mario@tatametal.com', '$2y$10$vZu2nZAE5vJU22kbf4dLx.Hav/bSDSuCFQa4m375DCZn6urQz5b9.', 'manager', '[\"21\"]', 'EKSPOR DAN IMPOR', '2025-05-27 19:06:23', '2025-05-27 19:06:23'),
(95, 'Edrik', 'edrik@tatametal.com', '$2y$10$7AW7qARpaWLwlBveavV70.5rGMzeI8o6fsyCAiz0APlyACUM9gCs2', 'manager', '[\"15\"]', 'SALES DAN MARKETING', '2025-05-27 19:07:02', '2025-05-27 19:07:02'),
(96, 'Henry Mikael Purba', 'henry.mikael@tatametal.com', '$2y$10$1e4/5WYNQZayU7j7JFj.EuCzOvIYMfRBnmo/JlYDu2mokL3q90hBy', 'manager', '[\"15\"]', 'SALES DAN MARKETING', '2025-05-27 19:09:30', '2025-05-27 19:09:30'),
(97, 'Rinda Yang', 'rindayang@tatametal.com', '$2y$10$/x63uGujA62kdgHbdjEFDu83aKJSBiRTnIi3tw8EDNPjOYQLLSoru', 'manager', '[\"22\"]', 'TREASURY', '2025-05-27 19:10:08', '2025-05-27 19:10:08'),
(98, 'Aditya Yudhatama', 'aditya.yudhatama@tatametal.com', '$2y$10$H.TMo.9A9mcyPp6mjCAITe1ezvVfVf0U/FWJskhxKZe/wpvSR8Bh.', 'manager', '[\"29\"]', 'BUSSINESS ANALYST', '2025-05-27 19:11:39', '2025-05-27 19:11:39'),
(99, 'Dicky Priyatna', 'dicky.priyatna@tatalogam.com', '$2y$10$YRZNnexDFbi5s0NY.GUuEeElEuLrZmrEc6..z0M77R9um5Du.EMyC', 'manager', '[\"30\"]', 'IT', '2025-05-27 19:13:24', '2025-05-27 19:13:24'),
(100, 'Joseph Riswandi', 'joseph.riswandi@tatametal.com', '$2y$10$1F9etIi/BqE4IuKKh69EKukgEfdfmHzKvEwsVTj71nbCSl9XzApNi', 'manager', '[\"17\"]', 'ACCOUNTING', '2025-05-27 19:14:45', '2025-05-27 19:14:45'),
(101, 'Lian Hoa', 'lian.hoa@tatametal.com', '$2y$10$g5Qvo4D2tH.PrOnMCmk13OCaxktrWCxSJpdj6QIpod.zertFiKEAG', 'manager', '[\"17\",\"33\",\"29\",\"32\",\"21\",\"28\",\"8\",\"9\",\"23\",\"30\",\"26\",\"34\",\"25\",\"3\",\"4\",\"7\",\"19\",\"18\",\"1\",\"2\",\"11\",\"12\",\"10\",\"27\",\"15\",\"13\",\"14\",\"31\",\"22\"]', 'MANAJEMEN', '2025-05-27 21:06:03', '2025-05-27 21:06:03'),
(102, 'Stephanus Koeswandi', 'skoeswandi@tatalogam.com', '$2y$10$AqWYDWgEYaIjkvB2y14jUO3fKo0X2zPkgrcDreOO4OLeJqtovCfim', 'manager', '[\"17\",\"33\",\"29\",\"32\",\"21\",\"28\",\"8\",\"9\",\"23\",\"30\",\"26\",\"34\",\"25\",\"3\",\"4\",\"7\",\"19\",\"18\",\"1\",\"2\",\"11\",\"12\",\"10\",\"27\",\"15\",\"13\",\"14\",\"31\",\"22\"]', 'MANAJEMEN', '2025-05-27 21:06:59', '2025-05-27 21:06:59'),
(103, 'Liana Waty Rusli', 'nana@tatametal.com', '$2y$10$KN1q6G8OyE.rmVPinHLhNOoJhl0Qo2OQSotm0nFEo3dQHMSlDBqOG', 'manager', '[\"15\"]', 'SALES DAN MARKETING', '2025-05-27 21:11:48', '2025-05-27 21:43:50'),
(104, 'Manajemen', 'manajemen@tatametal.com', '$2y$10$z7zHmCtX4bOv/Ttqjgdtr.BaB3OM3H08X1KkCrQSykJLM572XpLGS', 'manager', '[\"17\",\"33\",\"29\",\"32\",\"21\",\"28\",\"8\",\"9\",\"23\",\"30\",\"26\",\"34\",\"25\",\"3\",\"4\",\"7\",\"19\",\"18\",\"1\",\"2\",\"11\",\"12\",\"10\",\"27\",\"15\",\"13\",\"14\",\"31\",\"22\"]', 'MANAJEMEN', '2025-05-27 21:55:02', '2025-05-27 21:55:02'),
(105, 'adminmagang', 'adminmagang@gmail.com', '$2a$12$Rfm2c/s/t1nOLiCMeA27HeCts9rdQEo6ft4ABVZJKgWMyKKp/A32G', 'admin', '[\"1\",\"2\",\"3\",\"4\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"17\",\"18\",\"19\",\"21\",\"22\",\"23\",\"25\",\"26\",\"27\",\"28\"]', 'PRODUCTION CKR', '2025-08-05 02:43:02', '2025-08-05 02:43:02'),
(106, 'usermagang', 'usermagang@gmail.com', '$2a$12$zjuApJNzbIbYfg6L7JsSF.KMO4mTxArPNHUJt.BpemUYD0JpL6fRu', 'staff', '[\"1\"]', 'PRODUCTION CKR', '2025-08-07 01:32:10', '2025-08-07 01:32:10'),
(107, 'arga tes surat', 'argatessurat@gmail.com', '$2y$10$sy/kL1ESb3f5VRuobR5BG..fbZmV7cyM2zhrEhsXNCUSkp61qnNe.', 'staff', '[\"1\"]', 'PRODUCTION CKR', '2025-09-21 23:13:23', '2025-09-21 23:13:23');

-- --------------------------------------------------------

--
-- Table structure for table `userppk`
--

CREATE TABLE `userppk` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `divisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `userppk`
--

INSERT INTO `userppk` (`id`, `nama`, `divisi`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Taswono', 'HR & GA SDG', 'taswono@tatalogam.com', NULL, NULL),
(2, 'Group Moxo PPK MFG', 'MANUFACTURING', '5fb5bc550559143ed97b76d562659a3ac@tatalogam.moxo.com', NULL, NULL),
(3, 'Ossa', 'MTC-ELECTRIC', 'ossa.adi@tatalogam.com', NULL, NULL),
(4, 'Sugiyono', 'MTC-ELECTRIC', 'sugiyono@tatametal.com', NULL, NULL),
(5, 'Maskula', 'MTC-ELECTRIC SDG', 'ahmad.maskula@tatametal.com', NULL, NULL),
(6, 'Rama Hasan H', 'MTC-ELECTRIC SDG', 'rama.hasan@tatametal.com', NULL, NULL),
(7, 'Tugiyanto', 'MTC-MECHANICAL', 'tugiyanto@tatametal.com', NULL, NULL),
(8, 'Roby Risanda', 'MTC-MECHANICAL', 'roby@tatametal.com', NULL, NULL),
(9, 'Ilham Jamaludin', 'MTC-MECHANICAL', 'ilham.jamaludin@tatametal.com', NULL, NULL),
(10, 'Dian Persada', 'MTC-UTILTY', 'dian.persada@tatametal.com', NULL, NULL),
(11, 'Ferdinandus Paulus Tirtadinata', 'MTC-UTILTY', 'ferdinandus@tatametal.com', NULL, NULL),
(12, 'Lili Yusuf', 'PPIC', 'lili.yusuf@tatametal.com', NULL, NULL),
(13, 'Krismanto Susilo', 'PROCUREMENT', 'krismanto.susilo@tatametal.com', NULL, NULL),
(14, 'Agus Wicaksono', 'PRODUCTION', 'agus.wicaksono@tatametal.com', NULL, NULL),
(15, 'Ahmed Nugroho', 'PRODUCTION', 'ahmed.nugroho@tatametal.com', NULL, NULL),
(16, 'Ari Octaviyan', 'PRODUCTION', 'ari.octaviyan@tatametal.com', NULL, NULL),
(17, 'Arsy Kusumagraha', 'PRODUCTION', 'arsy.kusumagraha@tatametal.com', NULL, NULL),
(18, 'Diska Bustanul Hadi', 'PRODUCTION', 'diska@tatalogam.com', NULL, NULL),
(19, 'Mohamad Ramdhani', 'PRODUCTION', 'mohamad.ramdhani@tatametal.com', NULL, NULL),
(20, 'Satmoko', 'PRODUCTION', 'satmoko@tatametal.com', NULL, NULL),
(21, 'Izan', 'PRODUCTION', 'andika.bachtiar@tatametal.com', NULL, NULL),
(22, 'Ditta Pratama', 'PRODUCTION', 'ditta.pratama@tatametal.com', NULL, NULL),
(23, 'Imam Qoirudin', 'PRODUCTION', 'imam.qoirudin@tatametal.com', NULL, NULL),
(24, 'Ho alex marjoko', 'PRODUCTION', 'alex.ho@tatametal.com', NULL, NULL),
(25, 'Zulkifli', 'PRODUCTION', 'zulkifli@tatalogam.com', NULL, NULL),
(26, 'Shift Leader Produksi', 'PRODUCTION', 'leader.prd@tatametal.com', NULL, NULL),
(27, 'Rendra Fernanda', 'PRODUCTION', 'rendra.fernanda@tatametal.com', NULL, NULL),
(28, 'Ali Mahfut', 'PRODUCTION', 'ali.mahfut@tatalogam.com', NULL, NULL),
(29, 'Tony Widy Utomo', 'PRODUCTION', 'toni.widi@tatalogam.com', NULL, NULL),
(30, 'Ahmad Faozan', 'PRODUCTION SDG', 'ahmad.faozan@tatametal.com', NULL, NULL),
(31, 'Dami Arta', 'PRODUCTION SDG', 'dami.arta@tatametal.com', NULL, NULL),
(32, 'Fauzan Dini Fadhillah', 'PRODUCTION SDG', 'fauzan.fadhillah@tatametal.com', NULL, NULL),
(33, 'Guruh Sindu', 'PRODUCTION SDG', 'guruh.putra@tatametal.com', NULL, NULL),
(34, 'Benny Saputro', 'QA', 'benny.saputro@tatametal.com', NULL, NULL),
(35, 'Muhammad Nanang', 'QA', 'muhammad.nanang@tatametal.com', NULL, NULL),
(36, 'Wahyu Bagas', 'QA', 'wahyu.laksana@tatametal.com', NULL, NULL),
(37, 'Sigit Sejati', 'QA SDG', 'sigit.sejati@tatametal.com', NULL, NULL),
(38, 'Hizbul', 'SAFETY', 'hizbul.sabiilafurqon@tatametal.com', NULL, NULL),
(39, 'Ade Kurniawan', 'SAFETY', 'ade.kurniawan@tatametal.com', NULL, NULL),
(40, 'Liana Waty Rusli', 'SALES', 'nana@tatametal.com', NULL, NULL),
(41, 'Brigitta Maria Suharwati', 'WAREHOUSE', 'brigitta.suharwati@tatalogam.com', NULL, NULL),
(42, 'Freddy', 'WAREHOUSE', 'freddy.tampubolon@tatametal.com', NULL, NULL),
(43, 'Riyan Hidayat', 'WAREHOUSE', 'riyan.hidayat@tatalogam.com', NULL, NULL),
(44, 'Panggah Sahistyo', 'WAREHOUSE', 'panggah@tatametal.com', NULL, NULL),
(45, 'Antonius Danu Kurniawan', 'WAREHOUSE', 'antonius.danu@tatametal.com', NULL, NULL),
(46, 'Andi Setiawan', 'WAREHOUSE / SC SDG', 'andi.setiawan@tatametal.com', NULL, NULL),
(47, 'Asep Hilman', 'WAREHOUSE / SC SDG', 'asep.hilman@tatametal.com', NULL, NULL),
(48, 'Bakhtarudin', 'WAREHOUSE / SC SDG', 'bakhtarudin@tatametal.com', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dokumen`
--
ALTER TABLE `dokumen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dokumen_nama_jenis_divisi_id_unique` (`nama_jenis`,`divisi_id`),
  ADD KEY `dokumen_divisi_id_foreign` (`divisi_id`);

--
-- Indexes for table `dokumen_approvals`
--
ALTER TABLE `dokumen_approvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dokumen_approvals_user_id_foreign` (`user_id`),
  ADD KEY `dokumen_approvals_dokumen_review_id_kind_index` (`dokumen_review_id`,`kind`);

--
-- Indexes for table `dokumen_files`
--
ALTER TABLE `dokumen_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dokumen_files_dokumen_review_id_type_index` (`dokumen_review_id`,`type`),
  ADD KEY `dokumen_files_uploaded_by_index` (`uploaded_by`);

--
-- Indexes for table `dokumen_reviews`
--
ALTER TABLE `dokumen_reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dokumen_reviews_dr_no_unique` (`dr_no`),
  ADD KEY `dokumen_reviews_pembuat_id_foreign` (`pembuat_id`),
  ADD KEY `dokumen_reviews_pembuat2_id_foreign` (`pembuat2_id`),
  ADD KEY `dokumen_reviews_approver_main_id_foreign` (`approver_main_id`),
  ADD KEY `dokumen_reviews_divisi_id_foreign` (`divisi_id`),
  ADD KEY `dokumen_reviews_dr_year_index` (`dr_year`),
  ADD KEY `dokumen_reviews_dr_seq_index` (`dr_seq`);

--
-- Indexes for table `dokumen_statuses`
--
ALTER TABLE `dokumen_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dokumen_statuses_dokumen_review_id_unique` (`dokumen_review_id`),
  ADD KEY `dokumen_statuses_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `formppk`
--
ALTER TABLE `formppk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `formppk_nomor_surat_unique` (`nomor_surat`);

--
-- Indexes for table `formppk2`
--
ALTER TABLE `formppk2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `formppk3`
--
ALTER TABLE `formppk3`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `formppk4`
--
ALTER TABLE `formppk4`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `formppkkedua`
--
ALTER TABLE `formppkkedua`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kriteria_divisi_id_nama_kriteria_index` (`divisi_id`,`nama_kriteria`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pdf_annotations`
--
ALTER TABLE `pdf_annotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pdf_annotations_user_id_foreign` (`user_id`),
  ADD KEY `pdf_annotations_dokumen_review_id_page_index` (`dokumen_review_id`,`page`),
  ADD KEY `pdf_annotations_page_index` (`page`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `realisasi`
--
ALTER TABLE `realisasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resiko`
--
ALTER TABLE `resiko`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riskregister`
--
ALTER TABLE `riskregister`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tindakan`
--
ALTER TABLE `tindakan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userppk`
--
ALTER TABLE `userppk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `dokumen`
--
ALTER TABLE `dokumen`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dokumen_approvals`
--
ALTER TABLE `dokumen_approvals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dokumen_files`
--
ALTER TABLE `dokumen_files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dokumen_reviews`
--
ALTER TABLE `dokumen_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dokumen_statuses`
--
ALTER TABLE `dokumen_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `formppk`
--
ALTER TABLE `formppk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `formppk2`
--
ALTER TABLE `formppk2`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `formppk3`
--
ALTER TABLE `formppk3`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `formppk4`
--
ALTER TABLE `formppk4`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `formppkkedua`
--
ALTER TABLE `formppkkedua`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `pdf_annotations`
--
ALTER TABLE `pdf_annotations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `realisasi`
--
ALTER TABLE `realisasi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=655;

--
-- AUTO_INCREMENT for table `resiko`
--
ALTER TABLE `resiko`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;

--
-- AUTO_INCREMENT for table `riskregister`
--
ALTER TABLE `riskregister`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=264;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tindakan`
--
ALTER TABLE `tindakan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=568;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `userppk`
--
ALTER TABLE `userppk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dokumen`
--
ALTER TABLE `dokumen`
  ADD CONSTRAINT `dokumen_divisi_id_foreign` FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `dokumen_approvals`
--
ALTER TABLE `dokumen_approvals`
  ADD CONSTRAINT `dokumen_approvals_dokumen_review_id_foreign` FOREIGN KEY (`dokumen_review_id`) REFERENCES `dokumen_reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dokumen_approvals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dokumen_files`
--
ALTER TABLE `dokumen_files`
  ADD CONSTRAINT `dokumen_files_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dokumen_reviews`
--
ALTER TABLE `dokumen_reviews`
  ADD CONSTRAINT `dokumen_reviews_approver_main_id_foreign` FOREIGN KEY (`approver_main_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `dokumen_reviews_divisi_id_foreign` FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `dokumen_reviews_pembuat2_id_foreign` FOREIGN KEY (`pembuat2_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `dokumen_reviews_pembuat_id_foreign` FOREIGN KEY (`pembuat_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `dokumen_statuses`
--
ALTER TABLE `dokumen_statuses`
  ADD CONSTRAINT `dokumen_statuses_dokumen_review_id_foreign` FOREIGN KEY (`dokumen_review_id`) REFERENCES `dokumen_reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dokumen_statuses_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD CONSTRAINT `kriteria_divisi_id_foreign` FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pdf_annotations`
--
ALTER TABLE `pdf_annotations`
  ADD CONSTRAINT `pdf_annotations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
