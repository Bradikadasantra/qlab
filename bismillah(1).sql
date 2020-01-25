-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Jan 2020 pada 08.10
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bismillah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(2) UNSIGNED ZEROFILL NOT NULL,
  `id_auth` int(3) UNSIGNED ZEROFILL NOT NULL,
  `nama` varchar(128) NOT NULL,
  `alamat` varchar(128) NOT NULL,
  `no_telp` varchar(100) NOT NULL,
  `dibuat` date NOT NULL,
  `diubah` date NOT NULL,
  `foto` varchar(128) NOT NULL,
  `id_bidang` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `id_auth`, `nama`, `alamat`, `no_telp`, `dibuat`, `diubah`, `foto`, `id_bidang`) VALUES
(01, 007, 'Admin Sampel', 'Depok', '0219210031', '2019-07-08', '2020-01-10', 'cecep7.jpg', NULL),
(02, 008, 'Analis Mikrobiologi', 'Jakarta', '02102020', '2019-07-08', '2019-07-08', 'intro-15592514981.jpg', 'M'),
(03, 010, 'Manajer Mutu', 'Depok', '0210001', '2019-07-15', '2019-07-15', 'cantk1.jpg', NULL),
(04, 011, 'Manajer Teknik Mikrobiologi', 'Tangerang', '0213456', '2019-07-15', '2019-07-15', 'cecep.jpg', 'M'),
(05, 012, 'Manajer Teknik Kimia', 'Tangerang', '021020210', '2019-07-15', '2019-07-15', 'munaroh.jpg', 'K'),
(07, 015, 'Analis Kimia', 'Depok', '0212902010', '2019-11-27', '2019-11-27', 'naomi2.jpg', 'K'),
(08, 009, 'Analis Farmakologi', 'Depok', '09876543321', '2019-11-27', '2019-11-27', 'default.jpg', 'F'),
(09, 016, 'Manajer Teknik Farmakologi', 'Depok', '02199894', '2019-11-27', '2019-11-27', 'naomi3.jpg', 'F'),
(10, 021, 'Manajer Puncak udin', 'Tangerang', '02122223', '2019-12-21', '2019-12-21', 'cecep1.jpg', NULL),
(11, 022, 'Kepala Laboratorium', 'Depok', '0219392123', '2019-12-22', '2019-12-22', 'cantk3.jpg', NULL),
(12, 023, 'Koor Pengendali Dokumen', 'Depok', '02139303', '2019-12-28', '2019-12-28', 'cantk4.jpg', NULL),
(18, 029, 'Koor Kalibrasi', 'Depok', '081234567', '2020-01-03', '2020-01-03', 'cantk7.jpg', NULL),
(19, 030, 'Koor Audit Internal', 'Tangerang', '0812103209', '2020-01-03', '2020-01-03', 'cantk8.jpg', NULL),
(20, 031, 'Penyelia Saranan Dan Prasarana', 'Jakarta', '08314242', '2020-01-03', '2020-01-03', 'cecep5.jpg', NULL),
(21, 032, 'Manajer Operaional  Keuangan', 'Bekasi', '02198976', '2020-01-05', '2020-01-05', 'cecep6.jpg', NULL),
(22, 033, 'Penyelia Mikrobiologi', 'Bekasi', '0210099', '2020-01-05', '2020-01-05', 'siti.jpg', 'M'),
(23, 034, 'Penyelia Kimia', 'Depok', '0213494', '2020-01-05', '2020-01-05', 'intro-15592514982.jpg', 'K'),
(24, 035, 'Penyelia Farmakologi', 'Jakarta', '021982192', '2020-01-05', '2020-01-05', 'munaroh1.jpg', 'F');

-- --------------------------------------------------------

--
-- Struktur dari tabel `approve_dokumen`
--

CREATE TABLE `approve_dokumen` (
  `id_approve` int(3) UNSIGNED ZEROFILL NOT NULL,
  `no_dokumen` varchar(100) NOT NULL,
  `bidang` varchar(2) DEFAULT NULL,
  `id_pemeriksa` int(2) UNSIGNED ZEROFILL DEFAULT NULL,
  `id_pengesah` int(2) UNSIGNED ZEROFILL DEFAULT NULL,
  `tgl_diperiksa` date NOT NULL,
  `tgl_disahkan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `approve_dokumen`
--

INSERT INTO `approve_dokumen` (`id_approve`, `no_dokumen`, `bidang`, `id_pemeriksa`, `id_pengesah`, `tgl_diperiksa`, `tgl_disahkan`) VALUES
(016, 'IKL_001', 'M', 04, NULL, '2020-01-13', '2020-01-13'),
(021, 'IKL_002', 'M', 04, NULL, '2020-01-13', '2020-01-13'),
(023, 'IKL_003', 'K', 05, NULL, '0000-00-00', '2020-01-13'),
(024, 'IKL_004', 'K', 05, NULL, '0000-00-00', '2020-01-13'),
(037, 'IKL_006', 'M', NULL, NULL, '2020-01-14', '2020-01-14'),
(038, 'IKL_007', 'M', 04, NULL, '2020-01-14', '2020-01-14'),
(039, 'IKL_008', 'M', 04, NULL, '2020-01-15', '2020-01-15'),
(040, 'IKL_009', 'M', 04, NULL, '2020-01-21', '2020-01-21'),
(041, 'P_001', 'M', 11, 10, '2020-01-21', '0000-00-00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth`
--

CREATE TABLE `auth` (
  `id_auth` int(3) UNSIGNED ZEROFILL NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `hak_akses` int(2) UNSIGNED ZEROFILL NOT NULL,
  `aktif` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `auth`
--

INSERT INTO `auth` (`id_auth`, `email`, `password`, `hak_akses`, `aktif`) VALUES
(002, 'ajadika989@gmail.com', '$2y$10$N.p3.j.cN7y4F9lDQbDwsOOQEt5lX/Z2skL7lRLfqOd0hb.KGw/c6', 12, 1),
(007, 'admin_sampel@gmail.com', '$2y$10$yNiKaIBWcFIwykEINdzp8.tbKOZjtH0BQ4YjvI1QQzrfYGihPiE3W', 01, 1),
(008, 'analis_mikro@gmail.com', '$2y$10$5au3swPWH2timKQIVkpsceNdk6UR1yekYEmUc9Mp3UdyJSptRdabC', 07, 1),
(009, 'analis_farma@gmail.com', '$2y$10$jtN7KDZ6sChmrcsNgSgB7eteLlQH1xG4TNDs8nLP58WlaEsvD9WXi', 07, 1),
(010, 'manajer_mutu@gmail.com', '$2y$10$3OfCWRzBC.rR923qGQEGY.dXEd/CiOhvF7Wq9tAM3yp1egYsxE1Xi', 04, 1),
(011, 'manajer_mikro@gmail.com', '$2y$10$d64SBiemcCgnYqaWJtoZWeGXruB8o8Dqg6jFhuFsZX0f5lXH2YW6C', 06, 1),
(012, 'manajer_kimia@gmail.com', '$2y$10$rvNiV4FTXTA9rOcXqg1raeJ4xtYzegokDT6JBY1ZIqlp9pjPafkVK', 06, 1),
(013, 'sri@gmail.com', '$2y$10$GzDa065nG6cFtBcnR2bJbO/pGKA.wwimA47Kt/bIHacVteo/Wb4NS', 12, 1),
(015, 'analis_kimia@gmail.com', '$2y$10$i5ddp/HUjYPpFL6NDq8ZTexRxaS9nJxS97zhai0AYpsvRw7ReBsQS', 07, 1),
(016, 'manajer_farma@gmail.com', '$2y$10$ykAkhnJTkWPlTTy6dIJT7OUCfN/ps0ckz99Sjv02EAOAwXh.nIzgW', 06, 1),
(017, 'pelanggan03@gmail.com', '$2y$10$HMcHuywXc9z//ZSKjHolMeh5V./oWqGiCimMoj16PYsSBMDfvmbC.', 12, 1),
(018, 'pelanggan04@gmail.com', '$2y$10$.hlUytK/FZ4a2LL3ihp5a.SBHmE4Fcf1edLr5SNCyipHWkf/oSjb2', 12, 1),
(019, 'sari@gmail.com', '$2y$10$UUUwvP0r9ldJ9cJv9lpG9uv62PimFmfQw6nikurA5VeCM7dI1dJHK', 12, 1),
(020, 'budi@gmail.com', '$2y$10$NS4V079ce0He5OxVPIiy7umHIVIX5wbeZONphSPU4eAPv6vmX0F8W', 12, 1),
(021, 'manajer_puncak@gmail.com', '$2y$10$k1VphAfjtWc2wMhURoVHXuG8V73VL4zOh1KT6vqprpA7dWLZn0sSG', 02, 1),
(022, 'ka_laboratorium@gmail.com', '$2y$10$JHPLB/8ppUohPEU8Q8KNne47smC3uY.4U0wpOJZjQI4S1msa3TUd6', 03, 1),
(023, 'koor_dokumen@gmail.com', '$2y$10$zYWDyPK3Z.UJdAJrtqLkQOV/qjcRw9kTtlq5mcd8yyVJ.uqfabs8y', 11, 1),
(029, 'koor_kalibrasi@gmail.com', '$2y$10$dfA0HDQxAI0n7EVxveMKSe1yqLxJj4ugq1HDjc9Uz5b.T2hHrxUbq', 09, 1),
(030, 'koor_audit@gmail.com', '$2y$10$ZKIBUuUeb3bUDPMx.2JtKOijsUst3uS3s86fHTt59O528is064Zn6', 10, 1),
(031, 'penyelia_sarpras@gmail.com', '$2y$10$dCE/dUjcILWyPUYW6VWpFuoDB1vudSjvAbzsuJnSo55btyljY7mMy', 13, 1),
(032, 'manajer_operasional@gmail.com', '$2y$10$HrIEsP88bmNsVsscGQRzZuNQEGLP9w7EfjwDIDcQps4/WADboZEOG', 05, 1),
(033, 'penyelia_mikro@gmail.com', '$2y$10$vw/Ozcb5Hyiw3IPZfWlLle9n1lQkf7xgFKofXkwd0p.EPEhAvGbv.', 08, 1),
(034, 'penyelia_kimia@gmail.com', '$2y$10$OJT.nnKLs/Ahk4W1EhlJqui9/UO0eKSX/bv7Au/aHN7DI7QfiifSq', 08, 1),
(035, 'penyelia_farma@gmail.com', '$2y$10$ddixS4kHblUB4eMXZ08PGuGrfUqCNWCUjgz9yH27lXE/NME7XvbFO', 08, 1),
(036, 'riska@gmail.com', '$2y$10$DExIMvsR9VJiS5JPwKbXceezfyriNJX7J/XRoxwo5ZalCke0VmV.y', 12, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bank`
--

CREATE TABLE `bank` (
  `id_bank` int(3) UNSIGNED ZEROFILL NOT NULL,
  `bank` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `bank`
--

INSERT INTO `bank` (`id_bank`, `bank`) VALUES
(001, 'BNI'),
(002, 'BRI'),
(003, 'Mandiri');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bidang`
--

CREATE TABLE `bidang` (
  `id_bidang` varchar(2) NOT NULL,
  `nama_bidang` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `bidang`
--

INSERT INTO `bidang` (`id_bidang`, `nama_bidang`) VALUES
('F', 'Farmakologi'),
('K', 'Kimia'),
('M', 'Mikrobiologi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumen_akses`
--

CREATE TABLE `dokumen_akses` (
  `id_dok_akses` int(4) UNSIGNED ZEROFILL NOT NULL,
  `hak_akses` int(2) UNSIGNED ZEROFILL NOT NULL,
  `id_jenis_dokumen` int(2) UNSIGNED ZEROFILL NOT NULL,
  `aksi` enum('penyusun','pemeriksa','pengesah') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dokumen_akses`
--

INSERT INTO `dokumen_akses` (`id_dok_akses`, `hak_akses`, `id_jenis_dokumen`, `aksi`) VALUES
(0001, 07, 01, 'penyusun'),
(0002, 08, 01, 'penyusun'),
(0003, 06, 01, 'penyusun'),
(0004, 06, 01, 'pemeriksa'),
(0005, 03, 01, 'pemeriksa'),
(0006, 07, 04, 'penyusun'),
(0007, 08, 04, 'penyusun'),
(0008, 13, 04, 'penyusun'),
(0009, 06, 04, 'penyusun'),
(0010, 06, 04, 'pemeriksa'),
(0011, 03, 04, 'pemeriksa'),
(0012, 01, 08, 'penyusun'),
(0013, 05, 08, 'penyusun'),
(0014, 05, 08, 'pemeriksa'),
(0015, 03, 08, 'pemeriksa'),
(0016, 10, 12, 'penyusun'),
(0017, 11, 12, 'penyusun'),
(0018, 09, 12, 'penyusun'),
(0019, 04, 12, 'penyusun'),
(0020, 04, 12, 'pemeriksa'),
(0021, 03, 12, 'pemeriksa'),
(0022, 06, 09, 'penyusun'),
(0023, 05, 09, 'penyusun'),
(0024, 04, 09, 'penyusun'),
(0025, 03, 09, 'pemeriksa'),
(0026, 06, 10, 'penyusun'),
(0027, 05, 10, 'penyusun'),
(0028, 04, 10, 'penyusun'),
(0029, 03, 10, 'pemeriksa'),
(0030, 02, 11, 'penyusun'),
(0031, 02, 09, 'pengesah'),
(0032, 02, 10, 'pengesah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumen_induk`
--

CREATE TABLE `dokumen_induk` (
  `id_dokumen_induk` int(2) UNSIGNED ZEROFILL NOT NULL,
  `dokumen` varchar(128) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `background` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dokumen_induk`
--

INSERT INTO `dokumen_induk` (`id_dokumen_induk`, `dokumen`, `icon`, `background`, `url`) VALUES
(01, 'Dokumen Mutu', 'fas fa-file-pdf fa-sw fa-lg', 'bg-primary', 'c_dokumen/list_all_dokumen'),
(02, 'Dokumen Prosedur', 'fas fa-file-pdf fa-fw fa-lg', 'bg-success', 'c_dokumen/list_all_dokumen'),
(03, 'Dokumen Instruksi Kerja', 'fas fa-file-pdf fa-fw fa-lg', 'bg-info', 'c_dokumen/list_all_dokumen'),
(04, 'Dokumen Form', 'fas fa-file-pdf fa-fw fa-lg', 'bg-warning', 'c_dokumen/list_all_dokumen');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hak_akses`
--

CREATE TABLE `hak_akses` (
  `id_hak_akses` int(2) UNSIGNED ZEROFILL NOT NULL,
  `hak_akses` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `hak_akses`
--

INSERT INTO `hak_akses` (`id_hak_akses`, `hak_akses`) VALUES
(01, 'Admin Sampel'),
(02, 'Manajer Puncak'),
(03, 'Kepala Laboratorium'),
(04, 'Manajer Mutu'),
(05, 'Manajer Operasional'),
(06, 'Manajer Teknik'),
(07, 'Analis'),
(08, 'Penyelia'),
(09, 'Koor Kalibrasi'),
(10, 'Koor Audit Internal'),
(11, 'Koor Pengendali Dokumen'),
(12, 'Pelanggan'),
(13, 'Penyelia Sarana Prasarana');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_pemeriksaan`
--

CREATE TABLE `hasil_pemeriksaan` (
  `id_hasil_pemeriksaan` int(2) UNSIGNED ZEROFILL NOT NULL,
  `id_pemeriksaan` int(2) UNSIGNED ZEROFILL NOT NULL,
  `hasil_pemeriksaan` varchar(225) NOT NULL,
  `status` int(1) NOT NULL,
  `keterangan` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `hasil_pemeriksaan`
--

INSERT INTO `hasil_pemeriksaan` (`id_hasil_pemeriksaan`, `id_pemeriksaan`, `hasil_pemeriksaan`, `status`, `keterangan`) VALUES
(01, 01, 'Simplo 4 mm', 1, ''),
(02, 01, 'Duplo 3 mm', 1, ''),
(03, 02, 'Simplo 4 mm', 1, ''),
(04, 02, 'Duplo 3 mm', 1, ''),
(05, 12, 'Simplo 4 mm', 1, ''),
(06, 11, 'Duplo 2 mm', 1, ''),
(07, 11, 'Duplo 3 mm', 1, ''),
(08, 09, 'Duplo 2 mm', 1, ''),
(09, 10, 'Simplo 4 mm', 1, ''),
(10, 14, 'Duplo 2 mm', 1, ''),
(11, 21, 'Simplo 4 mm', 1, ''),
(12, 22, 'Duplo 3 mm', 1, ''),
(13, 19, 'Duplo 4 mm', 1, ''),
(14, 20, 'Simplo 2 mm', 1, ''),
(15, 15, 'Simplo 2 mm', 1, ''),
(16, 16, 'Duplo 4 mm', 1, ''),
(17, 23, 'Simplo 15 mm', 1, ''),
(18, 24, 'Duplo 4 mm', 1, ''),
(19, 27, 'Simplo 5 mm', 1, ''),
(20, 29, 'Simplo 7 mm', 1, ''),
(21, 30, 'Duplo 4 mm', 1, ''),
(22, 31, 'Simplo 5 mm', 1, ''),
(23, 32, 'Simplo 4 mm', 1, ''),
(24, 33, 'Duplo 3 mm', 1, ''),
(25, 34, 'Duplo 4 mm', 1, ''),
(26, 35, 'Duplo 8 mm', 1, ''),
(27, 48, 'Simplo 3 mm', 1, ''),
(28, 48, 'Duplo 8 mm', 1, ''),
(29, 47, 'Duplo 4 mm', 1, ''),
(30, 51, 'Simplo 6 mm', 1, ''),
(32, 52, 'Simplo 4 mm', 1, ''),
(35, 59, 'Duplo 7 mm', 1, ''),
(36, 60, 'Simplo 3 mm', 1, ''),
(37, 63, 'Simplo 3 mm', 1, ''),
(38, 64, 'Duplo 4 mm', 1, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_dokumen`
--

CREATE TABLE `jenis_dokumen` (
  `id_jenis_dokumen` int(2) UNSIGNED ZEROFILL NOT NULL,
  `nama_dokumen` varchar(125) NOT NULL,
  `id_dokumen_induk` int(2) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_dokumen`
--

INSERT INTO `jenis_dokumen` (`id_jenis_dokumen`, `nama_dokumen`, `id_dokumen_induk`) VALUES
(01, 'IKL Pengujian Terkait Bidang Teknis ', 03),
(04, 'IKL Pemeliharaan Alat / Pengunaan Alat', 03),
(08, 'IKL Terkait Administrasi Sampel & Keuangan', 03),
(09, 'Prosedur Terkait Sistem Manajemen Mutu', 02),
(10, 'Prosedur Terkait Operasional & Keuangan ', 02),
(11, 'Panduan Mutu', 01),
(12, 'IKL Terkait Sistem Manajemen Mutu', 03);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kemasan`
--

CREATE TABLE `kemasan` (
  `id_kemasan` int(2) UNSIGNED ZEROFILL NOT NULL,
  `kemasan` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kemasan`
--

INSERT INTO `kemasan` (`id_kemasan`, `kemasan`) VALUES
(01, 'Botol'),
(03, 'Mug');

-- --------------------------------------------------------

--
-- Struktur dari tabel `konfirmasi_byr`
--

CREATE TABLE `konfirmasi_byr` (
  `id_konfirm_byr` int(3) UNSIGNED ZEROFILL NOT NULL,
  `pemilik_rekening` varchar(125) NOT NULL,
  `no_tagihan` varchar(50) NOT NULL,
  `bank` int(3) UNSIGNED ZEROFILL NOT NULL,
  `jumlah` int(225) NOT NULL,
  `bukti_byr` varchar(125) NOT NULL,
  `tgl_byr` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `konfirmasi_byr`
--

INSERT INTO `konfirmasi_byr` (`id_konfirm_byr`, `pemilik_rekening`, `no_tagihan`, `bank`, `jumlah`, `bukti_byr`, `tgl_byr`) VALUES
(001, 'Bradika Dasantra R', 'INV_19.00001', 001, 1080000, 'struk.jpg', '2019-12-11'),
(004, 'Bradika Dasantra R', 'INV_19.00003', 001, 800000, '17.jpg', '2019-12-13'),
(005, 'pelanggan03', 'INV_19.00002', 001, 840000, '171.jpg', '2019-12-13'),
(006, 'Pelanggan04', 'INV_19.00004', 002, 600000, '172.jpg', '2019-12-13'),
(007, 'Pelanggan04', 'INV_19.00005', 002, 400000, '173.jpg', '2019-12-14'),
(008, 'Bradika', 'INV_19.00006', 002, 1480000, '174.jpg', '2019-12-14'),
(009, 'pelanggan03', 'INV_19.00007', 002, 29500000, 'struk1.jpg', '2019-12-14'),
(010, 'Pelanggan03', 'INV_19.00008', 002, 200000, 'struk2.jpg', '2019-12-14'),
(011, 'Budi', 'INV_19.00014', 002, 1200000, '175.jpg', '2019-12-17'),
(012, 'Pelanggan04', 'INV_20.00016', 001, 1080000, '176.jpg', '2020-01-01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order`
--

CREATE TABLE `order` (
  `no_order` varchar(50) NOT NULL,
  `id_pelanggan` int(2) UNSIGNED ZEROFILL NOT NULL,
  `tgl_order` date NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `order`
--

INSERT INTO `order` (`no_order`, `id_pelanggan`, `tgl_order`, `status`) VALUES
('OR-201912110001', 01, '2019-01-11', 10),
('OR-201912130001', 04, '2019-01-13', 10),
('OR-201912130002', 01, '2019-01-13', 10),
('OR-201912130003', 05, '2019-02-13', 10),
('OR-201912130004', 05, '2019-02-13', 10),
('OR-201912130005', 01, '2019-03-13', 10),
('OR-201912130006', 04, '2019-04-13', 10),
('OR-201912140001', 04, '2019-05-14', 10),
('OR-201912140002', 06, '2019-12-14', 10),
('OR-201912150001', 06, '2019-12-15', 10),
('OR-201912150002', 06, '2019-12-15', 2),
('OR-201912160001', 01, '2019-12-16', 10),
('OR-201912170001', 07, '2019-12-17', 10),
('OR-201912170002', 07, '2019-12-17', 10),
('OR-201912170003', 07, '2019-12-17', 3),
('OR-202001010001', 05, '2020-01-01', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_detail`
--

CREATE TABLE `order_detail` (
  `id_order_detail` int(5) UNSIGNED ZEROFILL NOT NULL,
  `no_order` varchar(50) NOT NULL,
  `nama_sampel` varchar(128) NOT NULL,
  `pemerian` int(2) UNSIGNED ZEROFILL NOT NULL,
  `kode_batch` varchar(128) NOT NULL,
  `jumlah` varchar(10) NOT NULL,
  `kemasan` int(2) UNSIGNED ZEROFILL NOT NULL,
  `transportasi_sampel` int(2) UNSIGNED ZEROFILL NOT NULL,
  `tempat_penyimpanan` varchar(128) NOT NULL,
  `hal_lain` text NOT NULL,
  `terima_sampel` date NOT NULL,
  `selesai_sampel` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `order_detail`
--

INSERT INTO `order_detail` (`id_order_detail`, `no_order`, `nama_sampel`, `pemerian`, `kode_batch`, `jumlah`, `kemasan`, `transportasi_sampel`, `tempat_penyimpanan`, `hal_lain`, `terima_sampel`, `selesai_sampel`) VALUES
(00001, 'OR-201912110001', 'Ekstrak Mengkudu', 01, 'BNJK00KL', '1', 01, 01, 'Botol', '<p>Tolong kerjakan cepet</p>', '2019-12-11', '2019-12-12'),
(00002, 'OR-201912110001', 'Ekstrak Leci', 01, 'BNJK00KL', '1', 01, 02, 'Botol', '<p>Kerjakan cepet !!</p>', '2019-12-11', '2019-12-12'),
(00005, 'OR-201912130001', 'Ekstrak Jahe', 01, 'BNJKLKJHG', '1', 01, 02, 'Botol', '<p>Kerjakan cepet ya !!!</p>', '2019-12-13', '2019-12-12'),
(00006, 'OR-201912130002', 'Ekstrak Mangga', 01, 'JKL1234', '1', 01, 02, 'Botol', '<p>Kerjakan !!!</p>', '2019-12-13', '2019-12-20'),
(00007, 'OR-201912130003', 'Ekstrak Jeruk', 01, 'BNJKLKJHG', '1', 01, 02, 'Botol', '<p>Kerjakan Cepat !!!</p>', '2019-12-13', '2019-12-20'),
(00008, 'OR-201912130004', 'Ekstrak Melon', 01, 'BNJKLKJHG', '1', 01, 02, 'Botol', '', '2019-12-13', '2019-12-14'),
(00009, 'OR-201912130004', 'Ekstrak Anggur', 01, 'BNJKLKJHG', '1', 01, 02, 'Botol', '<p>sssstttt</p>', '2019-12-13', '0000-00-00'),
(00010, 'OR-201912130005', 'Ekstrak Wortel', 01, 'BNJKLKJHG', '1', 01, 02, 'Botol', '<p>Kerjakan cepet !!!</p>', '2019-12-13', '2019-12-13'),
(00011, 'OR-201912130006', 'Ekstral Bayam', 01, 'BNJKLKJHG', '1', 01, 02, 'Botol', '<p>Kerjakan cepet !!!</p>', '2019-12-13', '2019-12-14'),
(00013, 'OR-201912140001', 'Ekstrak Mawar', 01, 'BNMKJHFRG', '1', 01, 02, 'Botol', '<p>Kerjakan cepet !!</p>', '2019-12-14', '2019-12-14'),
(00014, 'OR-201912140002', 'Ekstrak', 01, 'BJK', '1', 01, 01, 'Kulkas', '<p>fff</p>', '2019-12-15', '2019-12-15'),
(00015, 'OR-201912140002', 'Ekstrak', 01, 'BJKKLOLL', '1', 01, 02, 'Kulkas', '<p>kerjakan cepet</p>', '2019-12-15', '2019-12-15'),
(00016, 'OR-201912150001', 'Eksktrak Kemangi', 07, 'BNJKLKJHG', '1', 01, 03, '15 C', '<p>Kerjakan cepet</p>', '2019-12-15', '2019-12-15'),
(00017, 'OR-201912150001', 'Ekstrak Bengkoang', 07, 'BNJKLKJHG', '1', 03, 03, '15 C', '<p>Kerjakan cepet</p>', '2019-12-15', '2019-12-15'),
(00019, 'OR-201912150002', 'Ekstrak Timun', 07, 'BNJKLKJHG', '1', 01, 02, '15 C', '<p>Kerjakan cepet !!</p>', '2019-12-15', '2019-12-16'),
(00021, 'OR-201912160001', 'Ekstrak Kemangi', 07, 'BJKLKHGGR', '1', 01, 03, '15 C', '<p>Kerjakan cepet</p>', '2019-12-16', '2019-12-17'),
(00022, 'OR-201912160001', 'Ekstrak Bawang', 07, 'BJKKLOLL', '1', 01, 03, '15 C', '<p>kerjakan cepet</p>', '2019-12-16', '2019-12-19'),
(00023, 'OR-201912170001', 'Ekstrak Kunyit', 07, 'BNJKLKJHG', '1', 01, 03, '15 C', '<p>Kerjakan</p>', '2019-12-17', '2019-12-17'),
(00024, 'OR-201912170001', 'Ekstrak Tomat', 07, 'BNJKLKJHG', '1', 01, 03, '15 C', '<p>kerjakan cepet</p>', '2019-12-17', '2019-12-17'),
(00025, 'OR-201912170001', 'Ekstak Cabe', 07, 'BNJKLKJHG', '1', 01, 03, '15 C', '', '2019-12-17', '2019-12-22'),
(00031, 'OR-201912170002', 'Ekstrak Kunir', 07, 'JKL1234', '1', 03, 03, '15 C', '<p>Kerjakan&nbsp;</p>', '2019-12-17', '2019-12-17'),
(00032, 'OR-201912170002', 'Ektrak kangkung', 07, 'BNJKLKJHG', '1', 03, 03, '15 C', '<p>Kerjakan hi !!</p>', '2019-12-17', '2019-12-17'),
(00033, 'OR-201912170003', 'Ekstrak Kacang', 07, 'BNJKLKJHG', '1', 01, 02, '15 C', '<p>Kerjakan&nbsp; !!</p>', '2019-12-17', '2019-12-17'),
(00034, 'OR-202001010001', 'Ekstrak Wortel', 01, 'BKL00098', '1', 01, 01, '15 C', '<p>Kerjakan cepet yaa</p>', '2020-01-01', '2020-01-01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(2) UNSIGNED ZEROFILL NOT NULL,
  `id_auth` int(3) UNSIGNED ZEROFILL NOT NULL,
  `nama` varchar(128) NOT NULL,
  `no_telp` varchar(100) NOT NULL,
  `alamat` varchar(128) NOT NULL,
  `instansi` varchar(128) NOT NULL,
  `alamat_instansi` varchar(256) NOT NULL,
  `dibuat` date NOT NULL,
  `diubah` date NOT NULL,
  `foto` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `id_auth`, `nama`, `no_telp`, `alamat`, `instansi`, `alamat_instansi`, `dibuat`, `diubah`, `foto`) VALUES
(01, 002, 'Bradika Dasantra R', '0213345', 'Depok', 'PT. Accenture Indonesi', 'Wisma 46 Kota Bni-18th Floor, Jl. Jend. Sudirman No.Kav. 1, RT.10/RW.11, Karet Tengsin, Jakarta, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10220', '2019-07-08', '2020-01-10', 'nvSXWfIR1.jpg'),
(02, 009, 'Andi Bogel', ' 02145567', 'Tangerang', ' PT.XX!', 'jl. ampera raya', '2019-07-11', '2019-11-12', 'cantk2.jpg'),
(03, 013, 'sri', '021000', 'Jakarta', 'PT.indocement', 'jl.Bhakti', '2019-07-17', '2019-07-17', 'Default.jpg'),
(04, 017, 'pelanggan03', '021998', 'Jakarta', 'PT.Indolexo', 'TB.Simatupang', '2019-12-13', '2019-12-13', 'Default.jpg'),
(05, 018, 'pelanggan04', '021998', 'Jakarta', 'PT.Indocofee', 'TB.Simatupang', '2019-12-13', '2019-12-13', 'Default.jpg'),
(06, 019, 'Sari', '0219998', 'Jakarta', 'PT.Indonusa', 'Daan Mogot', '2019-12-14', '2019-12-14', 'Default.jpg'),
(07, 020, 'Budi Baskoro', '0987899', 'Tangerang', 'PT.Indolex', 'Lenteng Agung', '2019-12-17', '2019-12-17', 'Default.jpg'),
(08, 036, 'Riska Agustina', '021301', 'Depok', 'Pharos', 'Tb Simatupang', '2020-01-05', '2020-01-05', 'Default.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemerian`
--

CREATE TABLE `pemerian` (
  `id_pemerian` int(2) UNSIGNED ZEROFILL NOT NULL,
  `pemerian` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pemerian`
--

INSERT INTO `pemerian` (`id_pemerian`, `pemerian`) VALUES
(01, 'Cair'),
(02, 'Padat'),
(03, 'Gas'),
(07, 'Ekstrak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan`
--

CREATE TABLE `pemeriksaan` (
  `id_pemeriksaan` int(2) UNSIGNED ZEROFILL NOT NULL,
  `id_sampel` int(3) UNSIGNED ZEROFILL NOT NULL,
  `id_pengujian` int(2) UNSIGNED ZEROFILL NOT NULL,
  `status_pemeriksaan` int(1) NOT NULL,
  `biaya_pemeriksaan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pemeriksaan`
--

INSERT INTO `pemeriksaan` (`id_pemeriksaan`, `id_sampel`, `id_pengujian`, `status_pemeriksaan`, `biaya_pemeriksaan`) VALUES
(01, 001, 15, 0, 480000),
(02, 001, 16, 0, 600000),
(03, 002, 01, 0, 0),
(04, 003, 15, 0, 0),
(09, 006, 15, 0, 480000),
(10, 006, 18, 0, 360000),
(11, 007, 03, 0, 200000),
(12, 008, 16, 0, 600000),
(13, 009, 05, 0, 0),
(14, 010, 16, 0, 600000),
(15, 011, 02, 0, 200000),
(16, 011, 03, 0, 200000),
(17, 012, 16, 0, 0),
(18, 012, 17, 0, 0),
(19, 013, 02, 0, 200000),
(20, 013, 04, 0, 200000),
(21, 014, 15, 0, 480000),
(22, 014, 16, 0, 600000),
(23, 015, 20, 0, 19500000),
(24, 015, 21, 0, 10000000),
(27, 017, 02, 0, 200000),
(28, 018, 16, 0, 0),
(29, 019, 16, 0, 600000),
(30, 020, 15, 0, 480000),
(31, 020, 16, 0, 600000),
(32, 021, 15, 0, 480000),
(33, 021, 16, 0, 600000),
(34, 022, 02, 0, 200000),
(35, 022, 03, 0, 200000),
(40, 025, 04, 0, 200000),
(41, 025, 05, 0, 260000),
(42, 026, 17, 0, 0),
(43, 026, 18, 0, 0),
(47, 029, 15, 0, 480000),
(48, 029, 16, 0, 600000),
(49, 030, 16, 0, 0),
(50, 030, 17, 0, 0),
(51, 031, 15, 0, 480000),
(52, 032, 18, 0, 360000),
(53, 033, 02, 0, 0),
(59, 039, 16, 0, 600000),
(60, 040, 17, 0, 600000),
(61, 041, 15, 0, 0),
(62, 041, 16, 0, 0),
(63, 042, 15, 0, 480000),
(64, 042, 16, 0, 600000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengujian`
--

CREATE TABLE `pengujian` (
  `id_pengujian` int(2) UNSIGNED ZEROFILL NOT NULL,
  `id_bidang` varchar(2) NOT NULL,
  `nama_pengujian` varchar(128) NOT NULL,
  `biaya` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengujian`
--

INSERT INTO `pengujian` (`id_pengujian`, `id_bidang`, `nama_pengujian`, `biaya`) VALUES
(01, 'K', 'Identifikasi Logam (Reaksi Warna)', 200000),
(02, 'K', 'Spektrofotometer (F.T.I.R)', 200000),
(03, 'K', 'Spektrofotmetri UV-Vis', 200000),
(04, 'K', 'Kromatografi Kertas', 200000),
(05, 'K', 'Kromatografi Lapis Tipis (KLT)', 260000),
(06, 'K', 'Kromatografi Cair Kinerja Tinggi (KCKT)', 660000),
(07, 'K', 'Uji Makroskopis', 300000),
(08, 'K', 'Uji Makroskopis (per simplisia)', 300000),
(09, 'K', 'Uji Tetapan FIsiks - Suhu Lebur', 135000),
(10, 'K', 'Uji Tetapan Fisika - Bobot Jenis (Pikonometer)', 260000),
(11, 'K', 'Uji Tetapan Fisika - Rotasi Optik', 135000),
(12, 'K', 'Uji Tetapan Fisika - Viskositas (Viskometer)', 135000),
(13, 'K', 'Uji Tetapan Fisika - pH (pH meter)', 135000),
(14, 'K', 'Uji Tetapan Fisika - Indeks Bias (Refraktometer)', 135000),
(15, 'M', 'Uji Sterilitas - Media Sterilitas', 480000),
(16, 'M', 'Uji Sterilitas - Metode Filter', 600000),
(17, 'M', 'Uji Potensi Antibiotik', 600000),
(18, 'M', 'Uji Kapang Khamir', 360000),
(19, 'F', 'Uji Antidiabetes (Toleransi Glukosa)', 12500000),
(20, 'F', 'Uji Antidiabetes (Induksi Aloksan) & Histopatologi', 19500000),
(21, 'F', 'Uji Antiinflamasi', 10000000),
(22, 'F', 'Uji Analgetik', 10000000),
(23, 'F', 'Uji Hepatoprotektor', 19500000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penolakan`
--

CREATE TABLE `penolakan` (
  `id_penolakan` int(2) UNSIGNED ZEROFILL NOT NULL,
  `id_sampel` int(3) UNSIGNED ZEROFILL NOT NULL,
  `catatan_penolakan` text NOT NULL,
  `tgl_dibuat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penolakan`
--

INSERT INTO `penolakan` (`id_penolakan`, `id_sampel`, `catatan_penolakan`, `tgl_dibuat`) VALUES
(01, 001, '<p>uji ulang untuk medi sterilitasnya</p>', '2019-12-11'),
(02, 007, '<p>uji ulang ya mbaa !!!</p>', '2019-12-13'),
(03, 015, '<p>Untuk uji antidiabetesnya diuji ulang ya, soalnya hasilnya dibawah standar</p>', '2019-12-14'),
(04, 015, '<p>hasilny amasih kurang tinggi coba diuji kembali,&nbsp;</p>', '2019-12-14'),
(05, 017, '<p>Mohon diuji ulang, simplo tidak sesuai dengan standar</p>', '2019-12-14'),
(06, 019, '<p>standard untuk simplo kurang tinggi</p>', '2019-12-15'),
(07, 021, '<p>masih dibawah standar duji lagi ya mas...</p>', '2019-12-15'),
(08, 021, '<p>masih dibawah standar...</p>', '2019-12-15'),
(09, 031, '<p>dibwah standar uji ulang ya !!</p>', '2019-12-17'),
(10, 039, '<p>uji lagi ya mba&nbsp;</p>', '2019-12-17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sampel`
--

CREATE TABLE `sampel` (
  `id_sampel` int(3) UNSIGNED ZEROFILL NOT NULL,
  `id_order_detail` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_bidang` varchar(2) NOT NULL,
  `no_sampel` varchar(30) NOT NULL,
  `status_sampel` int(1) NOT NULL,
  `status_tinjauan_mt` int(1) NOT NULL,
  `status_sertifikat` int(1) NOT NULL,
  `status_tinjauan_anl` int(1) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sampel`
--

INSERT INTO `sampel` (`id_sampel`, `id_order_detail`, `id_bidang`, `no_sampel`, `status_sampel`, `status_tinjauan_mt`, `status_sertifikat`, `status_tinjauan_anl`, `tanggal`) VALUES
(001, 00001, 'M', 'M001', 2, 4, 2, 2, '2019-12-11'),
(002, 00002, 'K', 'K001', 3, 2, 0, 0, '2019-12-11'),
(003, 00002, 'M', 'M002', 3, 2, 0, 0, '2019-12-11'),
(006, 00005, 'M', 'M003', 2, 4, 2, 2, '2019-12-13'),
(007, 00006, 'K', 'K002', 2, 4, 2, 2, '2019-12-13'),
(008, 00006, 'M', 'M004', 2, 4, 2, 2, '2019-12-13'),
(009, 00007, 'K', 'K003', 3, 2, 0, 0, '2019-12-13'),
(010, 00007, 'M', 'M005', 2, 4, 2, 2, '2019-12-13'),
(011, 00008, 'K', 'K004', 5, 4, 2, 2, '2019-12-13'),
(012, 00009, 'M', 'M006', 3, 2, 0, 0, '2019-12-13'),
(013, 00010, 'K', 'K005', 2, 4, 2, 2, '2019-12-13'),
(014, 00010, 'M', 'M007', 2, 4, 2, 2, '2019-12-13'),
(015, 00011, 'F', 'F001', 2, 4, 2, 2, '2019-12-13'),
(017, 00013, 'K', 'K006', 2, 4, 2, 2, '2019-12-14'),
(018, 00013, 'M', 'M008', 3, 2, 0, 0, '2019-12-14'),
(019, 00014, 'M', 'M009', 2, 4, 2, 2, '2019-12-14'),
(020, 00015, 'M', 'M010', 2, 4, 2, 2, '2019-12-14'),
(021, 00016, 'M', 'M011', 2, 4, 2, 2, '2019-12-15'),
(022, 00017, 'K', 'K007', 2, 4, 2, 2, '2019-12-15'),
(025, 00019, 'K', 'K008', 2, 2, 0, 0, '2019-12-15'),
(026, 00019, 'M', 'M012', 3, 2, 0, 0, '2019-12-15'),
(029, 00021, 'M', 'M013', 2, 4, 2, 2, '2019-12-16'),
(030, 00022, 'M', 'M014', 3, 2, 0, 0, '2019-12-16'),
(031, 00023, 'M', 'M015', 2, 4, 2, 2, '2019-12-17'),
(032, 00024, 'M', 'M016', 2, 4, 2, 2, '2019-12-17'),
(033, 00025, 'K', 'K009', 3, 2, 0, 0, '2019-12-17'),
(039, 00031, 'M', 'M017', 2, 4, 2, 2, '2019-12-17'),
(040, 00032, 'M', 'M018', 2, 4, 2, 2, '2019-12-17'),
(041, 00033, 'M', 'M019', 3, 2, 0, 0, '2019-12-17'),
(042, 00034, 'M', 'M001', 2, 4, 2, 2, '2020-01-01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan`
--

CREATE TABLE `tagihan` (
  `no_tagihan` varchar(50) NOT NULL,
  `no_order` varchar(50) NOT NULL,
  `jumlah_tagihan` int(11) NOT NULL,
  `status_tagihan` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tagihan`
--

INSERT INTO `tagihan` (`no_tagihan`, `no_order`, `jumlah_tagihan`, `status_tagihan`) VALUES
('INV_19.00001', 'OR-201912110001', 1080000, 2),
('INV_19.00002', 'OR-201912130001', 840000, 2),
('INV_19.00003', 'OR-201912130002', 800000, 2),
('INV_19.00004', 'OR-201912130003', 600000, 2),
('INV_19.00005', 'OR-201912130004', 400000, 2),
('INV_19.00006', 'OR-201912130005', 1480000, 2),
('INV_19.00007', 'OR-201912130006', 29500000, 2),
('INV_19.00008', 'OR-201912140001', 200000, 2),
('INV_19.00009', 'OR-201912140002', 1680000, 0),
('INV_19.00010', 'OR-201912150001', 1480000, 0),
('INV_19.00011', 'OR-201912150002', 460000, 0),
('INV_19.00012', 'OR-201912160001', 1080000, 0),
('INV_19.00013', 'OR-201912170001', 840000, 0),
('INV_19.00014', 'OR-201912170002', 1200000, 1),
('INV_19.00015', 'OR-201912170003', 0, 0),
('INV_20.00016', 'OR-202001010001', 1080000, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tinjauan_mt`
--

CREATE TABLE `tinjauan_mt` (
  `id_tinjauan_mt` int(4) UNSIGNED ZEROFILL NOT NULL,
  `id_sampel` int(3) UNSIGNED ZEROFILL NOT NULL,
  `id_admin` int(2) UNSIGNED ZEROFILL NOT NULL,
  `kesiapan_teknik` varchar(255) NOT NULL,
  `kesimpulan` varchar(255) NOT NULL,
  `catatan` text,
  `status_tinjauan` enum('Belum validasi','Sudah Validasi') NOT NULL,
  `konfirmasi_pelanggan` text,
  `tgl_ditinjau` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tinjauan_mt`
--

INSERT INTO `tinjauan_mt` (`id_tinjauan_mt`, `id_sampel`, `id_admin`, `kesiapan_teknik`, `kesimpulan`, `catatan`, `status_tinjauan`, `konfirmasi_pelanggan`, `tgl_ditinjau`) VALUES
(0003, 001, 04, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-11'),
(0005, 003, 04, 'a:2:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";}', 'Tidak dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-11'),
(0006, 002, 05, 'a:4:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";}', 'Tidak dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-11'),
(0007, 008, 04, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-13'),
(0008, 006, 04, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-13'),
(0009, 007, 05, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-13'),
(0010, 010, 04, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-13'),
(0011, 009, 05, 'a:1:{i:0;s:8:\"Personel\";}', 'Tidak dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-13'),
(0012, 012, 04, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Tidak dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-13'),
(0013, 014, 04, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-13'),
(0014, 013, 05, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-13'),
(0016, 011, 05, 'a:4:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:5:\"Bahan\";}', 'Dapat dilaksanakan dengan', 'alat tidak sesuai dengan permintaan', 'Sudah Validasi', 'oke saya setuju', '2019-12-13'),
(0017, 015, 09, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-13'),
(0018, 017, 05, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-14'),
(0019, 018, 04, 'a:2:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";}', 'Tidak dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-14'),
(0020, 019, 04, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-15'),
(0021, 020, 04, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-15'),
(0022, 021, 04, 'a:4:{i:0;s:8:\"Personel\";i:1;s:16:\"Metode Pelanggan\";i:2;s:4:\"Alat\";i:3;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-15'),
(0023, 022, 05, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-15'),
(0024, 026, 04, 'a:3:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";}', 'Tidak dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-15'),
(0025, 025, 05, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-15'),
(0026, 029, 04, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-16'),
(0027, 031, 04, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-17'),
(0028, 032, 04, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-17'),
(0031, 033, 05, 'a:3:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";}', 'Tidak dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-17'),
(0036, 039, 04, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-17'),
(0037, 040, 04, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-17'),
(0038, 041, 04, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Tidak dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-17'),
(0039, 042, 04, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2020-01-01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_order_detail`
--

CREATE TABLE `tmp_order_detail` (
  `id_order_detail` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_pelanggan` int(2) UNSIGNED ZEROFILL NOT NULL,
  `nama_sampel` varchar(128) NOT NULL,
  `pemerian` int(2) UNSIGNED ZEROFILL NOT NULL,
  `kode_batch` varchar(128) NOT NULL,
  `jumlah` varchar(128) NOT NULL,
  `kemasan` int(2) UNSIGNED ZEROFILL NOT NULL,
  `transportasi_sampel` int(2) UNSIGNED ZEROFILL NOT NULL,
  `tempat_penyimpanan` varchar(128) NOT NULL,
  `hal_lain` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_pemeriksaan`
--

CREATE TABLE `tmp_pemeriksaan` (
  `id_pemeriksaan` int(2) UNSIGNED ZEROFILL NOT NULL,
  `id_sampel` int(3) UNSIGNED ZEROFILL NOT NULL,
  `id_pengujian` int(2) UNSIGNED ZEROFILL NOT NULL,
  `status_pemeriksaan` int(1) NOT NULL,
  `biaya_pemeriksaan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_sampel`
--

CREATE TABLE `tmp_sampel` (
  `id_sampel` int(3) UNSIGNED ZEROFILL NOT NULL,
  `id_order_detail` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_bidang` varchar(2) NOT NULL,
  `no_sampel` varchar(30) NOT NULL,
  `status_sampel` int(1) NOT NULL,
  `status_sertifikat` int(1) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_upload_dokumen`
--

CREATE TABLE `tmp_upload_dokumen` (
  `id_upload_dokumen` int(2) NOT NULL,
  `bidang` varchar(2) DEFAULT NULL,
  `nama_dokumen` varchar(125) NOT NULL,
  `penyusun` int(2) UNSIGNED ZEROFILL NOT NULL,
  `tgl_disusun` date NOT NULL,
  `file_dok` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tmp_upload_dokumen`
--

INSERT INTO `tmp_upload_dokumen` (`id_upload_dokumen`, `bidang`, `nama_dokumen`, `penyusun`, `tgl_disusun`, `file_dok`) VALUES
(18, NULL, 'IKL Pengujian Sampel', 01, '2020-01-21', 'HELLO_WORLD1.docx');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transportasi_sampel`
--

CREATE TABLE `transportasi_sampel` (
  `id_transportasi_sampel` int(2) UNSIGNED ZEROFILL NOT NULL,
  `transportasi_sampel` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transportasi_sampel`
--

INSERT INTO `transportasi_sampel` (`id_transportasi_sampel`, `transportasi_sampel`) VALUES
(01, 'JNE'),
(02, 'TIKI'),
(03, 'Gosend'),
(04, 'Lion Parcel'),
(05, 'Grab Express');

-- --------------------------------------------------------

--
-- Struktur dari tabel `upload_dokumen`
--

CREATE TABLE `upload_dokumen` (
  `no_dokumen` varchar(100) NOT NULL,
  `id_dokumen_induk` int(2) UNSIGNED ZEROFILL NOT NULL,
  `nama_dok` varchar(125) NOT NULL,
  `lokasi` varchar(125) NOT NULL,
  `id_jenis_dokumen` int(2) UNSIGNED ZEROFILL NOT NULL,
  `id_penyusun` int(2) UNSIGNED ZEROFILL NOT NULL,
  `status` int(1) NOT NULL,
  `tgl_buat` date NOT NULL,
  `dok` varchar(125) NOT NULL,
  `jml_hlm` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `upload_dokumen`
--

INSERT INTO `upload_dokumen` (`no_dokumen`, `id_dokumen_induk`, `nama_dok`, `lokasi`, `id_jenis_dokumen`, `id_penyusun`, `status`, `tgl_buat`, `dok`, `jml_hlm`) VALUES
('IKL_001', 03, 'IKL Pengujian Sampel', '11.22.33.331', 01, 02, 2, '2020-01-13', 'IKL_001.pdf', 42),
('IKL_002', 03, 'IKL Penggunaan Alat', '1111', 04, 02, 2, '2020-01-13', 'IKL_002.pdf', 4),
('IKL_003', 03, 'IKL Administrasi Sampel', '11.11.33', 08, 07, 2, '2020-01-13', 'Implementasi_Metode_Prototype_Dalam_Rancang_Bangun.pdf', 0),
('IKL_004', 03, 'IKL Pengujian Sampel', '1111', 08, 07, 2, '2020-01-13', '3860-Article_Text-6753-1-10-20170918.pdf', 0),
('IKL_006', 03, 'IKL_006', '11.11.33', 01, 04, 2, '2020-01-14', 'IKL_006.pdf', 2),
('IKL_007', 03, 'IKL Pengujian Sampel', '11.11.33', 04, 02, 2, '2020-01-14', 'IKL_007.pdf', 4),
('IKL_008', 03, 'IKL Penggunaan Alat', '11.22.33.331', 04, 02, 2, '2020-01-14', 'IKL_008.pdf', 3),
('IKL_009', 03, 'IKL Pengujian Sampel', '11.22.33.331', 01, 02, 2, '2020-01-15', 'IKL_009.pdf', 5),
('P_001', 02, 'Prosedur Sistem Manajemen Mutu', '11.22.33.331', 09, 04, 1, '2020-01-21', 'P_001.pdf', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `view_dokumen`
--

CREATE TABLE `view_dokumen` (
  `id` int(3) UNSIGNED ZEROFILL NOT NULL,
  `hak_akses` int(2) UNSIGNED ZEROFILL NOT NULL,
  `id_dokumen_induk` int(2) UNSIGNED ZEROFILL NOT NULL,
  `aktif` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `view_dokumen`
--

INSERT INTO `view_dokumen` (`id`, `hak_akses`, `id_dokumen_induk`, `aktif`) VALUES
(001, 04, 01, 1),
(002, 04, 02, 1),
(003, 04, 03, 1),
(004, 04, 04, 1),
(005, 03, 01, 1),
(006, 03, 02, 1),
(007, 03, 03, 1),
(008, 03, 04, 1),
(009, 02, 01, 1),
(010, 02, 02, 1),
(011, 02, 03, 1),
(012, 02, 04, 1),
(013, 05, 01, 1),
(014, 05, 02, 1),
(015, 05, 03, 1),
(016, 05, 04, 1),
(017, 06, 01, 1),
(018, 06, 02, 1),
(019, 06, 03, 1),
(020, 06, 04, 1),
(021, 08, 02, 1),
(022, 08, 04, 1),
(023, 07, 04, 1),
(024, 09, 04, 1),
(025, 10, 04, 1),
(026, 11, 04, 1),
(027, 13, 04, 1),
(028, 01, 01, 1),
(029, 01, 02, 1),
(030, 01, 03, 1),
(031, 01, 04, 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `admin_ibfk_1` (`id_auth`),
  ADD KEY `id_bidang` (`id_bidang`);

--
-- Indeks untuk tabel `approve_dokumen`
--
ALTER TABLE `approve_dokumen`
  ADD PRIMARY KEY (`id_approve`),
  ADD KEY `approve_dokumen_ibfk_1` (`bidang`),
  ADD KEY `approve_dokumen_ibfk_4` (`id_pemeriksa`),
  ADD KEY `approve_dokumen_ibfk_6` (`no_dokumen`),
  ADD KEY `id_pengesah` (`id_pengesah`);

--
-- Indeks untuk tabel `auth`
--
ALTER TABLE `auth`
  ADD PRIMARY KEY (`id_auth`),
  ADD KEY `hak_akses` (`hak_akses`);

--
-- Indeks untuk tabel `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id_bank`);

--
-- Indeks untuk tabel `bidang`
--
ALTER TABLE `bidang`
  ADD PRIMARY KEY (`id_bidang`);

--
-- Indeks untuk tabel `dokumen_akses`
--
ALTER TABLE `dokumen_akses`
  ADD PRIMARY KEY (`id_dok_akses`),
  ADD KEY `hak_akses` (`hak_akses`),
  ADD KEY `id_jenis_dokumen` (`id_jenis_dokumen`);

--
-- Indeks untuk tabel `dokumen_induk`
--
ALTER TABLE `dokumen_induk`
  ADD PRIMARY KEY (`id_dokumen_induk`);

--
-- Indeks untuk tabel `hak_akses`
--
ALTER TABLE `hak_akses`
  ADD PRIMARY KEY (`id_hak_akses`);

--
-- Indeks untuk tabel `hasil_pemeriksaan`
--
ALTER TABLE `hasil_pemeriksaan`
  ADD PRIMARY KEY (`id_hasil_pemeriksaan`),
  ADD KEY `hasil_pemeriksaan_ibfk_1` (`id_pemeriksaan`);

--
-- Indeks untuk tabel `jenis_dokumen`
--
ALTER TABLE `jenis_dokumen`
  ADD PRIMARY KEY (`id_jenis_dokumen`),
  ADD KEY `jenis_dokumen_ibfk_2` (`id_dokumen_induk`);

--
-- Indeks untuk tabel `kemasan`
--
ALTER TABLE `kemasan`
  ADD PRIMARY KEY (`id_kemasan`);

--
-- Indeks untuk tabel `konfirmasi_byr`
--
ALTER TABLE `konfirmasi_byr`
  ADD PRIMARY KEY (`id_konfirm_byr`),
  ADD KEY `konfirmasi_byr_ibfk_2` (`bank`),
  ADD KEY `konfirmasi_byr_ibfk_3` (`no_tagihan`);

--
-- Indeks untuk tabel `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`no_order`),
  ADD KEY `orders_ibfk_1` (`id_pelanggan`);

--
-- Indeks untuk tabel `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id_order_detail`),
  ADD KEY `order_detail_ibfk_1` (`no_order`),
  ADD KEY `order_detail_ibfk_2` (`pemerian`),
  ADD KEY `order_detail_ibfk_3` (`kemasan`),
  ADD KEY `order_detail_ibfk_4` (`transportasi_sampel`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD KEY `pelanggan_ibfk_1` (`id_auth`);

--
-- Indeks untuk tabel `pemerian`
--
ALTER TABLE `pemerian`
  ADD PRIMARY KEY (`id_pemerian`);

--
-- Indeks untuk tabel `pemeriksaan`
--
ALTER TABLE `pemeriksaan`
  ADD PRIMARY KEY (`id_pemeriksaan`),
  ADD KEY `pemeriksaan_ibfk_1` (`id_sampel`),
  ADD KEY `pemeriksaan_ibfk_2` (`id_pengujian`);

--
-- Indeks untuk tabel `pengujian`
--
ALTER TABLE `pengujian`
  ADD PRIMARY KEY (`id_pengujian`),
  ADD KEY `pengujian_ibfk_1` (`id_bidang`);

--
-- Indeks untuk tabel `penolakan`
--
ALTER TABLE `penolakan`
  ADD PRIMARY KEY (`id_penolakan`),
  ADD KEY `penolakan_ibfk_1` (`id_sampel`);

--
-- Indeks untuk tabel `sampel`
--
ALTER TABLE `sampel`
  ADD PRIMARY KEY (`id_sampel`),
  ADD KEY `sampel_ibfk_1` (`id_order_detail`);

--
-- Indeks untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`no_tagihan`),
  ADD KEY `tagihan_ibfk_1` (`no_order`);

--
-- Indeks untuk tabel `tinjauan_mt`
--
ALTER TABLE `tinjauan_mt`
  ADD PRIMARY KEY (`id_tinjauan_mt`),
  ADD KEY `tinjauan_mt_ibfk_1` (`id_sampel`),
  ADD KEY `tinjauan_mt_ibfk_2` (`id_admin`);

--
-- Indeks untuk tabel `tmp_order_detail`
--
ALTER TABLE `tmp_order_detail`
  ADD PRIMARY KEY (`id_order_detail`),
  ADD KEY `tmp_order_detail_ibfk_1` (`id_pelanggan`),
  ADD KEY `tmp_order_detail_ibfk_2` (`pemerian`),
  ADD KEY `tmp_order_detail_ibfk_3` (`kemasan`),
  ADD KEY `tmp_order_detail_ibfk_4` (`transportasi_sampel`);

--
-- Indeks untuk tabel `tmp_pemeriksaan`
--
ALTER TABLE `tmp_pemeriksaan`
  ADD PRIMARY KEY (`id_pemeriksaan`),
  ADD KEY `pemeriksaan_ibfk_1` (`id_sampel`),
  ADD KEY `pemeriksaan_ibfk_2` (`id_pengujian`);

--
-- Indeks untuk tabel `tmp_sampel`
--
ALTER TABLE `tmp_sampel`
  ADD PRIMARY KEY (`id_sampel`),
  ADD KEY `tmp_sampel_ibfk_1` (`id_order_detail`);

--
-- Indeks untuk tabel `tmp_upload_dokumen`
--
ALTER TABLE `tmp_upload_dokumen`
  ADD PRIMARY KEY (`id_upload_dokumen`),
  ADD KEY `tmp_upload_dokumen_ibfk_1` (`penyusun`),
  ADD KEY `bidang` (`bidang`);

--
-- Indeks untuk tabel `transportasi_sampel`
--
ALTER TABLE `transportasi_sampel`
  ADD PRIMARY KEY (`id_transportasi_sampel`);

--
-- Indeks untuk tabel `upload_dokumen`
--
ALTER TABLE `upload_dokumen`
  ADD PRIMARY KEY (`no_dokumen`),
  ADD KEY `upload_dokumen_ibfk_1` (`id_dokumen_induk`),
  ADD KEY `upload_dokumen_ibfk_2` (`id_jenis_dokumen`),
  ADD KEY `upload_dokumen_ibfk_4` (`id_penyusun`);

--
-- Indeks untuk tabel `view_dokumen`
--
ALTER TABLE `view_dokumen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hak_akses` (`hak_akses`),
  ADD KEY `id_dokumen_induk` (`id_dokumen_induk`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `approve_dokumen`
--
ALTER TABLE `approve_dokumen`
  MODIFY `id_approve` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `auth`
--
ALTER TABLE `auth`
  MODIFY `id_auth` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `bank`
--
ALTER TABLE `bank`
  MODIFY `id_bank` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `dokumen_akses`
--
ALTER TABLE `dokumen_akses`
  MODIFY `id_dok_akses` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `dokumen_induk`
--
ALTER TABLE `dokumen_induk`
  MODIFY `id_dokumen_induk` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `hak_akses`
--
ALTER TABLE `hak_akses`
  MODIFY `id_hak_akses` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `hasil_pemeriksaan`
--
ALTER TABLE `hasil_pemeriksaan`
  MODIFY `id_hasil_pemeriksaan` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `jenis_dokumen`
--
ALTER TABLE `jenis_dokumen`
  MODIFY `id_jenis_dokumen` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `kemasan`
--
ALTER TABLE `kemasan`
  MODIFY `id_kemasan` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `konfirmasi_byr`
--
ALTER TABLE `konfirmasi_byr`
  MODIFY `id_konfirm_byr` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id_order_detail` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pemerian`
--
ALTER TABLE `pemerian`
  MODIFY `id_pemerian` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan`
--
ALTER TABLE `pemeriksaan`
  MODIFY `id_pemeriksaan` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT untuk tabel `pengujian`
--
ALTER TABLE `pengujian`
  MODIFY `id_pengujian` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `penolakan`
--
ALTER TABLE `penolakan`
  MODIFY `id_penolakan` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `sampel`
--
ALTER TABLE `sampel`
  MODIFY `id_sampel` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `tinjauan_mt`
--
ALTER TABLE `tinjauan_mt`
  MODIFY `id_tinjauan_mt` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `tmp_order_detail`
--
ALTER TABLE `tmp_order_detail`
  MODIFY `id_order_detail` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tmp_pemeriksaan`
--
ALTER TABLE `tmp_pemeriksaan`
  MODIFY `id_pemeriksaan` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tmp_sampel`
--
ALTER TABLE `tmp_sampel`
  MODIFY `id_sampel` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tmp_upload_dokumen`
--
ALTER TABLE `tmp_upload_dokumen`
  MODIFY `id_upload_dokumen` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `transportasi_sampel`
--
ALTER TABLE `transportasi_sampel`
  MODIFY `id_transportasi_sampel` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `view_dokumen`
--
ALTER TABLE `view_dokumen`
  MODIFY `id` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_auth`) REFERENCES `auth` (`id_auth`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_ibfk_2` FOREIGN KEY (`id_bidang`) REFERENCES `bidang` (`id_bidang`);

--
-- Ketidakleluasaan untuk tabel `approve_dokumen`
--
ALTER TABLE `approve_dokumen`
  ADD CONSTRAINT `approve_dokumen_ibfk_1` FOREIGN KEY (`bidang`) REFERENCES `bidang` (`id_bidang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `approve_dokumen_ibfk_4` FOREIGN KEY (`id_pemeriksa`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `approve_dokumen_ibfk_6` FOREIGN KEY (`no_dokumen`) REFERENCES `upload_dokumen` (`no_dokumen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `approve_dokumen_ibfk_7` FOREIGN KEY (`id_pengesah`) REFERENCES `admin` (`id_admin`);

--
-- Ketidakleluasaan untuk tabel `auth`
--
ALTER TABLE `auth`
  ADD CONSTRAINT `auth_ibfk_1` FOREIGN KEY (`hak_akses`) REFERENCES `hak_akses` (`id_hak_akses`);

--
-- Ketidakleluasaan untuk tabel `dokumen_akses`
--
ALTER TABLE `dokumen_akses`
  ADD CONSTRAINT `dokumen_akses_ibfk_1` FOREIGN KEY (`hak_akses`) REFERENCES `hak_akses` (`id_hak_akses`),
  ADD CONSTRAINT `dokumen_akses_ibfk_2` FOREIGN KEY (`id_jenis_dokumen`) REFERENCES `jenis_dokumen` (`id_jenis_dokumen`);

--
-- Ketidakleluasaan untuk tabel `hasil_pemeriksaan`
--
ALTER TABLE `hasil_pemeriksaan`
  ADD CONSTRAINT `hasil_pemeriksaan_ibfk_1` FOREIGN KEY (`id_pemeriksaan`) REFERENCES `pemeriksaan` (`id_pemeriksaan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jenis_dokumen`
--
ALTER TABLE `jenis_dokumen`
  ADD CONSTRAINT `jenis_dokumen_ibfk_2` FOREIGN KEY (`id_dokumen_induk`) REFERENCES `dokumen_induk` (`id_dokumen_induk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `konfirmasi_byr`
--
ALTER TABLE `konfirmasi_byr`
  ADD CONSTRAINT `konfirmasi_byr_ibfk_2` FOREIGN KEY (`bank`) REFERENCES `bank` (`id_bank`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `konfirmasi_byr_ibfk_3` FOREIGN KEY (`no_tagihan`) REFERENCES `tagihan` (`no_tagihan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`no_order`) REFERENCES `order` (`no_order`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`pemerian`) REFERENCES `pemerian` (`id_pemerian`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_detail_ibfk_3` FOREIGN KEY (`kemasan`) REFERENCES `kemasan` (`id_kemasan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_detail_ibfk_4` FOREIGN KEY (`transportasi_sampel`) REFERENCES `transportasi_sampel` (`id_transportasi_sampel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD CONSTRAINT `pelanggan_ibfk_1` FOREIGN KEY (`id_auth`) REFERENCES `auth` (`id_auth`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pemeriksaan`
--
ALTER TABLE `pemeriksaan`
  ADD CONSTRAINT `pemeriksaan_ibfk_2` FOREIGN KEY (`id_pengujian`) REFERENCES `pengujian` (`id_pengujian`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pemeriksaan_ibfk_3` FOREIGN KEY (`id_sampel`) REFERENCES `sampel` (`id_sampel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengujian`
--
ALTER TABLE `pengujian`
  ADD CONSTRAINT `pengujian_ibfk_1` FOREIGN KEY (`id_bidang`) REFERENCES `bidang` (`id_bidang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penolakan`
--
ALTER TABLE `penolakan`
  ADD CONSTRAINT `penolakan_ibfk_1` FOREIGN KEY (`id_sampel`) REFERENCES `sampel` (`id_sampel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sampel`
--
ALTER TABLE `sampel`
  ADD CONSTRAINT `sampel_ibfk_1` FOREIGN KEY (`id_order_detail`) REFERENCES `order_detail` (`id_order_detail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `tagihan_ibfk_1` FOREIGN KEY (`no_order`) REFERENCES `order` (`no_order`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tinjauan_mt`
--
ALTER TABLE `tinjauan_mt`
  ADD CONSTRAINT `tinjauan_mt_ibfk_1` FOREIGN KEY (`id_sampel`) REFERENCES `sampel` (`id_sampel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tinjauan_mt_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tmp_order_detail`
--
ALTER TABLE `tmp_order_detail`
  ADD CONSTRAINT `tmp_order_detail_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tmp_order_detail_ibfk_2` FOREIGN KEY (`pemerian`) REFERENCES `pemerian` (`id_pemerian`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tmp_order_detail_ibfk_3` FOREIGN KEY (`kemasan`) REFERENCES `kemasan` (`id_kemasan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tmp_order_detail_ibfk_4` FOREIGN KEY (`transportasi_sampel`) REFERENCES `transportasi_sampel` (`id_transportasi_sampel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tmp_pemeriksaan`
--
ALTER TABLE `tmp_pemeriksaan`
  ADD CONSTRAINT `tmp_pemeriksaan_ibfk_1` FOREIGN KEY (`id_sampel`) REFERENCES `tmp_sampel` (`id_sampel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tmp_pemeriksaan_ibfk_2` FOREIGN KEY (`id_pengujian`) REFERENCES `pengujian` (`id_pengujian`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tmp_sampel`
--
ALTER TABLE `tmp_sampel`
  ADD CONSTRAINT `tmp_sampel_ibfk_1` FOREIGN KEY (`id_order_detail`) REFERENCES `tmp_order_detail` (`id_order_detail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tmp_upload_dokumen`
--
ALTER TABLE `tmp_upload_dokumen`
  ADD CONSTRAINT `tmp_upload_dokumen_ibfk_1` FOREIGN KEY (`penyusun`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tmp_upload_dokumen_ibfk_3` FOREIGN KEY (`bidang`) REFERENCES `bidang` (`id_bidang`);

--
-- Ketidakleluasaan untuk tabel `upload_dokumen`
--
ALTER TABLE `upload_dokumen`
  ADD CONSTRAINT `upload_dokumen_ibfk_1` FOREIGN KEY (`id_dokumen_induk`) REFERENCES `dokumen_induk` (`id_dokumen_induk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `upload_dokumen_ibfk_2` FOREIGN KEY (`id_jenis_dokumen`) REFERENCES `jenis_dokumen` (`id_jenis_dokumen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `upload_dokumen_ibfk_4` FOREIGN KEY (`id_penyusun`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `view_dokumen`
--
ALTER TABLE `view_dokumen`
  ADD CONSTRAINT `view_dokumen_ibfk_1` FOREIGN KEY (`hak_akses`) REFERENCES `hak_akses` (`id_hak_akses`),
  ADD CONSTRAINT `view_dokumen_ibfk_2` FOREIGN KEY (`id_dokumen_induk`) REFERENCES `dokumen_induk` (`id_dokumen_induk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
