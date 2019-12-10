-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Des 2019 pada 08.43
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
(01, 007, 'Bradika Dasantra Renggawa', 'Depok', '02192100', '2019-07-08', '2019-07-08', 'cantk.jpg', NULL),
(02, 008, 'Fatiyah', 'Jakarta', '02102020', '2019-07-08', '2019-07-08', 'intro-15592514981.jpg', 'M'),
(03, 010, 'Asep', 'Depok', '0210001', '2019-07-15', '2019-07-15', 'cantk1.jpg', NULL),
(04, 011, 'Saefudinn Amrullah,S.Farm', 'Tangerang', '0213456', '2019-07-15', '2019-07-15', 'cecep.jpg', 'M'),
(05, 012, 'Munaroh', 'Tangerang', '021020210', '2019-07-15', '2019-07-15', 'munaroh.jpg', 'K'),
(07, 015, 'Reza Kusuma', 'Depok', '0212902010', '2019-11-27', '2019-11-27', 'naomi2.jpg', 'K'),
(08, 009, 'Andi Hermansyah', 'Depok', '09876543321', '2019-11-27', '2019-11-27', 'default.jpg', 'F'),
(09, 016, 'Muhammad Yusuf', 'Depok', '02199894', '2019-11-27', '2019-11-27', 'naomi3.jpg', 'F');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aset`
--

CREATE TABLE `aset` (
  `id_aset` int(2) UNSIGNED ZEROFILL NOT NULL,
  `jenis_barang` varchar(128) NOT NULL,
  `type` varchar(128) NOT NULL,
  `id_merk` int(2) UNSIGNED ZEROFILL NOT NULL,
  `jumlah` varchar(11) NOT NULL,
  `kodefikiasi` varchar(128) NOT NULL,
  `foto` varchar(128) NOT NULL,
  `dibuat` date NOT NULL,
  `diubah` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `aset`
--

INSERT INTO `aset` (`id_aset`, `jenis_barang`, `type`, `id_merk`, `jumlah`, `kodefikiasi`, `foto`, `dibuat`, `diubah`) VALUES
(04, 'Monitor', 'S1200', 02, '1', '', 'aset.png', '2019-07-09', '2019-07-09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth`
--

CREATE TABLE `auth` (
  `id_auth` int(3) UNSIGNED ZEROFILL NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `hak_akses` varchar(100) NOT NULL,
  `aktif` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `auth`
--

INSERT INTO `auth` (`id_auth`, `email`, `password`, `hak_akses`, `aktif`) VALUES
(002, 'ajadika989@gmail.com', '$2y$10$N.p3.j.cN7y4F9lDQbDwsOOQEt5lX/Z2skL7lRLfqOd0hb.KGw/c6', 'pelanggan', 1),
(007, 'wildanyuda999@gmail.com', '$2y$10$yNiKaIBWcFIwykEINdzp8.tbKOZjtH0BQ4YjvI1QQzrfYGihPiE3W', 'Super Admin', 1),
(008, 'fatiyah@gmail.com', '$2y$10$5au3swPWH2timKQIVkpsceNdk6UR1yekYEmUc9Mp3UdyJSptRdabC', 'analis', 1),
(009, 'andi@gmail.com', '$2y$10$jtN7KDZ6sChmrcsNgSgB7eteLlQH1xG4TNDs8nLP58WlaEsvD9WXi', 'analis', 1),
(010, 'asep@gmail.com', '$2y$10$3OfCWRzBC.rR923qGQEGY.dXEd/CiOhvF7Wq9tAM3yp1egYsxE1Xi', 'manajer_mutu', 1),
(011, 'udin@gmail.com', '$2y$10$d64SBiemcCgnYqaWJtoZWeGXruB8o8Dqg6jFhuFsZX0f5lXH2YW6C', 'manajer_teknik', 1),
(012, 'munaroh@gmail.com', '$2y$10$rvNiV4FTXTA9rOcXqg1raeJ4xtYzegokDT6JBY1ZIqlp9pjPafkVK', 'manajer_teknik', 1),
(013, 'sri@gmail.com', '$2y$10$GzDa065nG6cFtBcnR2bJbO/pGKA.wwimA47Kt/bIHacVteo/Wb4NS', 'pelanggan', 1),
(015, 'andin@gmail.com', '$2y$10$i5ddp/HUjYPpFL6NDq8ZTexRxaS9nJxS97zhai0AYpsvRw7ReBsQS', 'analis', 1),
(016, 'ucup@gmail.com', '$2y$10$ykAkhnJTkWPlTTy6dIJT7OUCfN/ps0ckz99Sjv02EAOAwXh.nIzgW', 'manajer_teknik', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bahan_uji`
--

CREATE TABLE `bahan_uji` (
  `id_bahan_uji` int(2) UNSIGNED ZEROFILL NOT NULL,
  `nama_bahan` varchar(100) NOT NULL,
  `pemasok` varchar(100) NOT NULL,
  `id_jenis_bahan` int(2) UNSIGNED ZEROFILL NOT NULL,
  `exp_date` date NOT NULL,
  `retest_date` date NOT NULL,
  `penyimpanan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `bahan_uji`
--

INSERT INTO `bahan_uji` (`id_bahan_uji`, `nama_bahan`, `pemasok`, `id_jenis_bahan`, `exp_date`, `retest_date`, `penyimpanan`) VALUES
(02, 'Media Sterilitas', 'PT SARAWANTI', 02, '2019-07-09', '2019-07-02', '11.22.33'),
(10, 'gga', 'gag', 02, '2009-01-12', '2019-07-09', 'gagag');

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
-- Struktur dari tabel `dokumen`
--

CREATE TABLE `dokumen` (
  `id_dokumen` int(2) UNSIGNED ZEROFILL NOT NULL,
  `dokumen` varchar(128) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `background` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dokumen`
--

INSERT INTO `dokumen` (`id_dokumen`, `dokumen`, `icon`, `background`, `url`) VALUES
(01, 'Dokumen Mutu', 'fas fa-file-pdf fa-sw fa-lg', 'bg-primary', 'c_dokumen/dokumen_mutu'),
(02, 'Dokumen Prosedur', 'fas fa-file-pdf fa-fw fa-lg', 'bg-success', 'c_dokumen/dokumen_prosedur'),
(03, 'Dokumen Instruksi Kerja', 'fas fa-file-pdf fa-fw fa-lg', 'bg-info', 'c_dokumen/dokumen_instruksi_kerja'),
(04, 'Dokumen Form', 'fas fa-file-pdf fa-fw fa-lg', 'bg-warning', 'c_dokumen/dokumen_form');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumen_form`
--

CREATE TABLE `dokumen_form` (
  `id_df` int(3) UNSIGNED ZEROFILL NOT NULL,
  `judul` varchar(100) NOT NULL,
  `kode` varchar(100) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `nama_dokumen` varchar(128) NOT NULL,
  `dibuat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dokumen_form`
--

INSERT INTO `dokumen_form` (`id_df`, `judul`, `kode`, `lokasi`, `nama_dokumen`, `dibuat`) VALUES
(001, 'Form Registrasi Sampel', '11.22.33.44', '11.111', 'BAB_III.pdf', '2019-07-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumen_instruksi_kerja`
--

CREATE TABLE `dokumen_instruksi_kerja` (
  `id_dik` int(3) UNSIGNED ZEROFILL NOT NULL,
  `judul` varchar(100) NOT NULL,
  `kode` varchar(100) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `nama_dokumen` varchar(128) NOT NULL,
  `dibuat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dokumen_instruksi_kerja`
--

INSERT INTO `dokumen_instruksi_kerja` (`id_dik`, `judul`, `kode`, `lokasi`, `nama_dokumen`, `dibuat`) VALUES
(001, 'Instruksi Manajer Teknik', '222.22.22.22', '', 'BAB_III.pdf', '2019-07-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumen_mutu`
--

CREATE TABLE `dokumen_mutu` (
  `id_dm` int(3) UNSIGNED ZEROFILL NOT NULL,
  `judul` varchar(100) NOT NULL,
  `kode` varchar(100) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `nama_dokumen` varchar(128) NOT NULL,
  `dibuat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dokumen_mutu`
--

INSERT INTO `dokumen_mutu` (`id_dm`, `judul`, `kode`, `lokasi`, `nama_dokumen`, `dibuat`) VALUES
(003, 'Mutu Pelayanan', '11.44.5.666', '2223.789', 'Zaelani-Backup-dan-Restore-Database.pdf', '2019-07-09'),
(004, 'Kepuasan Pelanggan mu', '11.44.5.666', '', 'jbptunikompp-gdl-harlimukti-26768-7-unikom_h-v.pdf', '2019-07-09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumen_prosedur`
--

CREATE TABLE `dokumen_prosedur` (
  `id_dp` int(3) UNSIGNED ZEROFILL NOT NULL,
  `judul` varchar(100) NOT NULL,
  `kode` varchar(100) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `nama_dokumen` varchar(128) NOT NULL,
  `dibuat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dokumen_prosedur`
--

INSERT INTO `dokumen_prosedur` (`id_dp`, `judul`, `kode`, `lokasi`, `nama_dokumen`, `dibuat`) VALUES
(001, 'Prosedur Kerja ku', '11.2.56788', '', 'BAB_III.pdf', '2019-07-15');

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
(02, 98, 'Simplo 4 mm', 1, ''),
(03, 99, 'Duplo 3 mm', 1, ''),
(09, 100, 'Simplo 3 mm', 1, ''),
(10, 101, 'Duplo 5 mm', 1, ''),
(11, 109, 'Simplo 4 mm', 1, ''),
(12, 106, 'Simplo 5 mm', 1, ''),
(13, 107, 'Simplo 3 mm', 1, ''),
(14, 108, 'Duplo 7 mm', 1, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_bahan`
--

CREATE TABLE `jenis_bahan` (
  `id` int(2) UNSIGNED ZEROFILL NOT NULL,
  `jenis_bahan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_bahan`
--

INSERT INTO `jenis_bahan` (`id`, `jenis_bahan`) VALUES
(01, 'Media Mikrobiologi'),
(02, 'Media Farmakologi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `konfirmasi_byr`
--

CREATE TABLE `konfirmasi_byr` (
  `id_konfirm_byr` int(3) UNSIGNED ZEROFILL NOT NULL,
  `pemilik_rekening` varchar(125) NOT NULL,
  `no_tagihan` varchar(50) NOT NULL,
  `bank` varchar(125) NOT NULL,
  `jumlah` int(225) NOT NULL,
  `bukti_byr` varchar(125) NOT NULL,
  `tgl_byr` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `merk`
--

CREATE TABLE `merk` (
  `id_merk` int(2) UNSIGNED ZEROFILL NOT NULL,
  `merk` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `merk`
--

INSERT INTO `merk` (`id_merk`, `merk`) VALUES
(01, 'Sidmazu'),
(02, 'Politron'),
(04, 'Panasonic'),
(05, 'Canon');

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
('OR-201908190003', 01, '2019-08-19', 10),
('OR-201908220001', 03, '2019-08-22', 10),
('OR-201911270001', 01, '2019-11-27', 1),
('OR-201912090001', 01, '2019-12-09', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_detail`
--

CREATE TABLE `order_detail` (
  `id_order_detail` int(5) UNSIGNED ZEROFILL NOT NULL,
  `no_order` varchar(50) NOT NULL,
  `nama_sampel` varchar(128) NOT NULL,
  `pemerian` varchar(128) NOT NULL,
  `kode_batch` varchar(128) NOT NULL,
  `jumlah` varchar(10) NOT NULL,
  `kemasan` varchar(128) NOT NULL,
  `transportasi_sampel` varchar(128) NOT NULL,
  `tempat_penyimpanan` varchar(128) NOT NULL,
  `hal_lain` text NOT NULL,
  `terima_sampel` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `order_detail`
--

INSERT INTO `order_detail` (`id_order_detail`, `no_order`, `nama_sampel`, `pemerian`, `kode_batch`, `jumlah`, `kemasan`, `transportasi_sampel`, `tempat_penyimpanan`, `hal_lain`, `terima_sampel`) VALUES
(00048, 'OR-201908190003', 'Ekstrak Mengkudu', '-', 'G8990JH', '1', '-', 'Gosend', '-', 'Kerjakan Cepet', '2019-12-04'),
(00049, 'OR-201908190003', 'Ekstrak Leci', '-', 'JKL0987', '1', '-', 'Gosend', '-', 'Kerjakan Cepet', '2019-08-19'),
(00052, 'OR-201908220001', 'Estrak Melati', '-', 'JKLJ321', '1', '-', 'Gosend', '-', '', '2019-12-01'),
(00053, 'OR-201908220001', 'Ekstrak Mawar', '-', 'JKL0982', '1', '-', 'Gosend', '-', '', '2019-08-22'),
(00058, 'OR-201911270001', 'Ekstrak Mangga', 'Cairan warna hijau', 'JKL1234', '1', 'Plastik', 'Gosend', 'Botol', 'Kerjakan  cepat ya ', '2019-12-01'),
(00059, 'OR-201912090001', 'Ekstrak Timun', 'Ekstraak', 'BNLKI000000', '1', 'Plastik', 'Gosend', 'Plastik', 'KERJAKAN CEPAT YA', '0000-00-00');

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
(01, 002, 'Bradika Dasantra Renggawa', '0213345', 'Depok', 'PT. Mekar abadi dan senantiasa jaya', 'MNC Tower, Lantai 1, Jl. Kebon Sirih No.17 - 19, RT.15/RW.7, Kb. Sirih, Kec. Menteng, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10340', '2019-07-08', '2019-07-08', 'naomi1.jpg'),
(02, 009, 'Andi Bogel', ' 02145567', 'Tangerang', ' PT.XX!', 'jl. ampera raya', '2019-07-11', '2019-11-12', 'cantk2.jpg'),
(03, 013, 'sri', '021000', 'Jakarta', 'PT.indocement', 'jl.Bhakti', '2019-07-17', '2019-07-17', 'Default.jpg');

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
(98, 074, 15, 2, 480000),
(99, 074, 16, 2, 600000),
(100, 075, 15, 2, 480000),
(101, 075, 16, 0, 600000),
(106, 079, 01, 2, 200000),
(107, 079, 02, 2, 200000),
(108, 080, 06, 2, 660000),
(109, 081, 15, 2, 480000),
(116, 088, 01, 0, 200000),
(117, 089, 15, 0, 480000),
(118, 090, 19, 0, 12500000),
(119, 091, 15, 0, 480000),
(120, 091, 16, 0, 600000);

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
(02, 'K', 'Spektrofotometer F.T.I.R', 200000),
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
(05, 075, '<p>simplo terlalu rendah</p>', '2019-12-03'),
(06, 075, '<p>tes</p>', '2019-12-04'),
(07, 074, '<p>heha5</p>', '2019-12-04'),
(08, 075, '<p>ohiohoi</p>', '2019-12-04'),
(09, 075, '<p>beebebbeeb</p>', '2019-12-04'),
(10, 075, '<p>fggg</p>', '2019-12-04'),
(11, 075, '<p>sdvbaba</p>', '2019-12-04'),
(12, 075, '<p>MAAF</p>', '2019-12-04'),
(13, 075, '<p>agagag</p>', '2019-12-04'),
(14, 075, '<p>agagag</p>', '2019-12-04'),
(15, 075, '<p>fwfG</p>', '2019-12-04'),
(16, 075, '<p>koeajgajgoa</p>', '2019-12-04'),
(17, 075, '<p>gagag</p>', '2019-12-04'),
(18, 075, '<p>agaga</p>', '2019-12-04'),
(19, 075, '<p>gakjgajg</p>', '2019-12-04'),
(20, 075, '<p>agaogoa</p>', '2019-12-04'),
(21, 075, '<p>gagagagag</p>', '2019-12-04'),
(22, 075, '<p>GAGAGAG</p>', '2019-12-04'),
(23, 081, '<p>sbshshshsh</p>', '2019-12-04'),
(24, 081, '<p>gagagag</p>', '2019-12-04'),
(25, 081, '<p>agagaga</p>', '2019-12-04'),
(26, 081, '<p>bssbsbs</p>', '2019-12-04');

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
(074, 00048, 'M', 'M001', 2, 4, 2, 2, '2019-08-19'),
(075, 00049, 'M', 'M002', 3, 1, 0, 0, '2019-08-19'),
(079, 00052, 'K', 'K001', 2, 4, 2, 2, '2019-08-22'),
(080, 00053, 'K', 'K002', 2, 4, 2, 2, '2019-08-22'),
(081, 00053, 'M', 'M003', 2, 4, 2, 2, '2019-08-22'),
(088, 00058, 'K', 'K003', 2, 2, 0, 0, '2019-11-27'),
(089, 00058, 'M', 'M006', 2, 2, 0, 0, '2019-11-27'),
(090, 00058, 'F', 'F002', 1, 0, 0, 0, '2019-11-27'),
(091, 00059, 'M', 'M007', 0, 0, 0, 0, '2019-12-09');

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
('000006', 'OR-201908190003', 2160000, 2),
('000007', 'OR-201908220001', 1200000, 0),
('000008', 'OR-201908220001', 1540000, 0),
('000012', 'OR-201911270001', 13180000, 2),
('INV_19.00013', 'OR-201912090001', 1080000, 0);

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
(0001, 074, 04, 'a:5:{i:0;s:8:\"Personel\";i:1;s:11:\"Metode Qlab\";i:2;s:16:\"Metode Pelanggan\";i:3;s:4:\"Alat\";i:4;s:5:\"Bahan\";}', 'Dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-04'),
(0002, 075, 04, 'a:2:{i:0;s:8:\"Personel\";i:1;s:5:\"Bahan\";}', 'Tidak dapat dilaksanakan', NULL, 'Sudah Validasi', '', '2019-12-04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_order_detail`
--

CREATE TABLE `tmp_order_detail` (
  `id_order_detail` int(5) UNSIGNED ZEROFILL NOT NULL,
  `id_pelanggan` int(2) UNSIGNED ZEROFILL NOT NULL,
  `nama_sampel` varchar(128) NOT NULL,
  `pemerian` varchar(128) NOT NULL,
  `kode_batch` varchar(128) NOT NULL,
  `jumlah` varchar(128) NOT NULL,
  `kemasan` varchar(128) NOT NULL,
  `transportasi_sampel` varchar(128) NOT NULL,
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
-- Struktur dari tabel `tr_dokumen_form`
--

CREATE TABLE `tr_dokumen_form` (
  `id_tr_df` int(2) UNSIGNED ZEROFILL NOT NULL,
  `id_df` int(3) UNSIGNED ZEROFILL NOT NULL,
  `revisi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_dokumen_form`
--

INSERT INTO `tr_dokumen_form` (`id_tr_df`, `id_df`, `revisi`) VALUES
(01, 001, '0000-00-00'),
(02, 001, '2019-07-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_dokumen_instruksi_kerja`
--

CREATE TABLE `tr_dokumen_instruksi_kerja` (
  `id_tr_dik` int(2) UNSIGNED ZEROFILL NOT NULL,
  `id_dik` int(3) UNSIGNED ZEROFILL NOT NULL,
  `revisi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_dokumen_instruksi_kerja`
--

INSERT INTO `tr_dokumen_instruksi_kerja` (`id_tr_dik`, `id_dik`, `revisi`) VALUES
(01, 001, '0000-00-00'),
(02, 001, '2019-07-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_dokumen_mutu`
--

CREATE TABLE `tr_dokumen_mutu` (
  `id_tr_dm` int(2) UNSIGNED ZEROFILL NOT NULL,
  `id_dm` int(3) UNSIGNED ZEROFILL NOT NULL,
  `revisi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_dokumen_mutu`
--

INSERT INTO `tr_dokumen_mutu` (`id_tr_dm`, `id_dm`, `revisi`) VALUES
(04, 003, '2019-07-09'),
(05, 003, '2019-07-24'),
(06, 003, '2019-07-09'),
(07, 003, '2019-07-09'),
(08, 004, '2019-07-09'),
(11, 004, '2019-07-09'),
(12, 004, '2019-07-15'),
(13, 004, '2019-07-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_dokumen_prosedur`
--

CREATE TABLE `tr_dokumen_prosedur` (
  `id_tr_dp` int(2) UNSIGNED ZEROFILL NOT NULL,
  `id_dp` int(3) UNSIGNED ZEROFILL NOT NULL,
  `revisi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_dokumen_prosedur`
--

INSERT INTO `tr_dokumen_prosedur` (`id_tr_dp`, `id_dp`, `revisi`) VALUES
(01, 001, '0000-00-00'),
(02, 001, '2019-07-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_dokumen`
--

CREATE TABLE `user_access_dokumen` (
  `id_user_access` int(2) UNSIGNED ZEROFILL NOT NULL,
  `hak_akses` varchar(100) NOT NULL,
  `id_dokumen` int(2) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_access_dokumen`
--

INSERT INTO `user_access_dokumen` (`id_user_access`, `hak_akses`, `id_dokumen`) VALUES
(05, 'ka_laboratorium', 01),
(06, 'ka_laboratorium', 02),
(07, 'ka_laboratorium', 03),
(08, 'ka_laboratorium', 04),
(09, 'manajer_puncak', 01),
(10, 'manajer_puncak', 02),
(11, 'manajer_puncak', 03),
(12, 'manajer_puncak', 04),
(17, 'manajer_mutu', 01),
(18, 'manajer_mutu', 02),
(19, 'manajer_mutu', 03),
(20, 'manajer_mutu', 04),
(26, 'admin_sampel', 02),
(27, 'admin_sampel', 03),
(28, 'admin_sampel', 04),
(29, 'admin_sampel', 01),
(30, 'penyelia', 02),
(31, 'penyelia', 03),
(32, 'penyelia', 04),
(33, 'analis', 03),
(34, 'analis', 04),
(35, 'manajer_operasional', 01),
(36, 'manajer_operasional', 02),
(37, 'manajer_operasional', 03),
(38, 'manajer_operasional', 04),
(39, 'manajer_teknik_mikro', 01),
(40, 'manajer_teknik_mikro', 02),
(41, 'manajer_teknik_mikro', 03),
(42, 'manajer_teknik_mikro', 04),
(43, 'manajer_teknik_kimia', 01),
(44, 'manajer_teknik_kimia', 02),
(45, 'manajer_teknik_kimia', 03),
(46, 'manajer_teknik_kimia', 04),
(47, 'manajer_teknik_farma', 01),
(48, 'manajer_teknik_farma', 02),
(49, 'manajer_teknik_farma', 03),
(50, 'manajer_teknik_farma', 04);

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
-- Indeks untuk tabel `aset`
--
ALTER TABLE `aset`
  ADD PRIMARY KEY (`id_aset`),
  ADD KEY `aset_ibfk_1` (`id_merk`);

--
-- Indeks untuk tabel `auth`
--
ALTER TABLE `auth`
  ADD PRIMARY KEY (`id_auth`);

--
-- Indeks untuk tabel `bahan_uji`
--
ALTER TABLE `bahan_uji`
  ADD PRIMARY KEY (`id_bahan_uji`),
  ADD KEY `id_jenis_bahan` (`id_jenis_bahan`);

--
-- Indeks untuk tabel `bidang`
--
ALTER TABLE `bidang`
  ADD PRIMARY KEY (`id_bidang`);

--
-- Indeks untuk tabel `dokumen`
--
ALTER TABLE `dokumen`
  ADD PRIMARY KEY (`id_dokumen`);

--
-- Indeks untuk tabel `dokumen_form`
--
ALTER TABLE `dokumen_form`
  ADD PRIMARY KEY (`id_df`);

--
-- Indeks untuk tabel `dokumen_instruksi_kerja`
--
ALTER TABLE `dokumen_instruksi_kerja`
  ADD PRIMARY KEY (`id_dik`);

--
-- Indeks untuk tabel `dokumen_mutu`
--
ALTER TABLE `dokumen_mutu`
  ADD PRIMARY KEY (`id_dm`);

--
-- Indeks untuk tabel `dokumen_prosedur`
--
ALTER TABLE `dokumen_prosedur`
  ADD PRIMARY KEY (`id_dp`);

--
-- Indeks untuk tabel `hasil_pemeriksaan`
--
ALTER TABLE `hasil_pemeriksaan`
  ADD PRIMARY KEY (`id_hasil_pemeriksaan`),
  ADD KEY `hasil_pemeriksaan_ibfk_1` (`id_pemeriksaan`);

--
-- Indeks untuk tabel `jenis_bahan`
--
ALTER TABLE `jenis_bahan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `konfirmasi_byr`
--
ALTER TABLE `konfirmasi_byr`
  ADD PRIMARY KEY (`id_konfirm_byr`),
  ADD KEY `konfirmasi_byr_ibfk_1` (`no_tagihan`);

--
-- Indeks untuk tabel `merk`
--
ALTER TABLE `merk`
  ADD PRIMARY KEY (`id_merk`);

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
  ADD KEY `order_detail_ibfk_1` (`no_order`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD KEY `pelanggan_ibfk_1` (`id_auth`);

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
  ADD KEY `tmp_order_detail_ibfk_1` (`id_pelanggan`);

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
-- Indeks untuk tabel `tr_dokumen_form`
--
ALTER TABLE `tr_dokumen_form`
  ADD PRIMARY KEY (`id_tr_df`),
  ADD KEY `tr_dokumen_form_ibfk_1` (`id_df`);

--
-- Indeks untuk tabel `tr_dokumen_instruksi_kerja`
--
ALTER TABLE `tr_dokumen_instruksi_kerja`
  ADD PRIMARY KEY (`id_tr_dik`),
  ADD KEY `tr_dokumen_instruksi_kerja_ibfk_1` (`id_dik`);

--
-- Indeks untuk tabel `tr_dokumen_mutu`
--
ALTER TABLE `tr_dokumen_mutu`
  ADD PRIMARY KEY (`id_tr_dm`),
  ADD KEY `tr_dokumen_mutu_ibfk_1` (`id_dm`);

--
-- Indeks untuk tabel `tr_dokumen_prosedur`
--
ALTER TABLE `tr_dokumen_prosedur`
  ADD PRIMARY KEY (`id_tr_dp`),
  ADD KEY `tr_dokumen_prosedur_ibfk_1` (`id_dp`);

--
-- Indeks untuk tabel `user_access_dokumen`
--
ALTER TABLE `user_access_dokumen`
  ADD PRIMARY KEY (`id_user_access`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `aset`
--
ALTER TABLE `aset`
  MODIFY `id_aset` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `auth`
--
ALTER TABLE `auth`
  MODIFY `id_auth` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `bahan_uji`
--
ALTER TABLE `bahan_uji`
  MODIFY `id_bahan_uji` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `dokumen`
--
ALTER TABLE `dokumen`
  MODIFY `id_dokumen` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `dokumen_form`
--
ALTER TABLE `dokumen_form`
  MODIFY `id_df` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `dokumen_instruksi_kerja`
--
ALTER TABLE `dokumen_instruksi_kerja`
  MODIFY `id_dik` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `dokumen_mutu`
--
ALTER TABLE `dokumen_mutu`
  MODIFY `id_dm` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `dokumen_prosedur`
--
ALTER TABLE `dokumen_prosedur`
  MODIFY `id_dp` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `hasil_pemeriksaan`
--
ALTER TABLE `hasil_pemeriksaan`
  MODIFY `id_hasil_pemeriksaan` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `jenis_bahan`
--
ALTER TABLE `jenis_bahan`
  MODIFY `id` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `konfirmasi_byr`
--
ALTER TABLE `konfirmasi_byr`
  MODIFY `id_konfirm_byr` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `merk`
--
ALTER TABLE `merk`
  MODIFY `id_merk` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id_order_detail` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan`
--
ALTER TABLE `pemeriksaan`
  MODIFY `id_pemeriksaan` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT untuk tabel `pengujian`
--
ALTER TABLE `pengujian`
  MODIFY `id_pengujian` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `penolakan`
--
ALTER TABLE `penolakan`
  MODIFY `id_penolakan` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `sampel`
--
ALTER TABLE `sampel`
  MODIFY `id_sampel` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT untuk tabel `tinjauan_mt`
--
ALTER TABLE `tinjauan_mt`
  MODIFY `id_tinjauan_mt` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT untuk tabel `tr_dokumen_form`
--
ALTER TABLE `tr_dokumen_form`
  MODIFY `id_tr_df` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tr_dokumen_instruksi_kerja`
--
ALTER TABLE `tr_dokumen_instruksi_kerja`
  MODIFY `id_tr_dik` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tr_dokumen_mutu`
--
ALTER TABLE `tr_dokumen_mutu`
  MODIFY `id_tr_dm` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tr_dokumen_prosedur`
--
ALTER TABLE `tr_dokumen_prosedur`
  MODIFY `id_tr_dp` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user_access_dokumen`
--
ALTER TABLE `user_access_dokumen`
  MODIFY `id_user_access` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
-- Ketidakleluasaan untuk tabel `aset`
--
ALTER TABLE `aset`
  ADD CONSTRAINT `aset_ibfk_1` FOREIGN KEY (`id_merk`) REFERENCES `merk` (`id_merk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `bahan_uji`
--
ALTER TABLE `bahan_uji`
  ADD CONSTRAINT `bahan_uji_ibfk_1` FOREIGN KEY (`id_jenis_bahan`) REFERENCES `jenis_bahan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hasil_pemeriksaan`
--
ALTER TABLE `hasil_pemeriksaan`
  ADD CONSTRAINT `hasil_pemeriksaan_ibfk_1` FOREIGN KEY (`id_pemeriksaan`) REFERENCES `pemeriksaan` (`id_pemeriksaan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `konfirmasi_byr`
--
ALTER TABLE `konfirmasi_byr`
  ADD CONSTRAINT `konfirmasi_byr_ibfk_1` FOREIGN KEY (`no_tagihan`) REFERENCES `tagihan` (`no_tagihan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`no_order`) REFERENCES `order` (`no_order`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `tmp_order_detail_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Ketidakleluasaan untuk tabel `tr_dokumen_form`
--
ALTER TABLE `tr_dokumen_form`
  ADD CONSTRAINT `tr_dokumen_form_ibfk_1` FOREIGN KEY (`id_df`) REFERENCES `dokumen_form` (`id_df`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tr_dokumen_instruksi_kerja`
--
ALTER TABLE `tr_dokumen_instruksi_kerja`
  ADD CONSTRAINT `tr_dokumen_instruksi_kerja_ibfk_1` FOREIGN KEY (`id_dik`) REFERENCES `dokumen_instruksi_kerja` (`id_dik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tr_dokumen_mutu`
--
ALTER TABLE `tr_dokumen_mutu`
  ADD CONSTRAINT `tr_dokumen_mutu_ibfk_1` FOREIGN KEY (`id_dm`) REFERENCES `dokumen_mutu` (`id_dm`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tr_dokumen_prosedur`
--
ALTER TABLE `tr_dokumen_prosedur`
  ADD CONSTRAINT `tr_dokumen_prosedur_ibfk_1` FOREIGN KEY (`id_dp`) REFERENCES `dokumen_prosedur` (`id_dp`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
