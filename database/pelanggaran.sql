-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 10 Des 2022 pada 16.47
-- Versi server: 8.0.18
-- Versi PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pelanggaran`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_kelas`
--

CREATE TABLE `db_kelas` (
  `id_kelas` int(99) NOT NULL,
  `nama_kelas` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `db_kelas`
--

INSERT INTO `db_kelas` (`id_kelas`, `nama_kelas`) VALUES
(1, 'X IPA 1'),
(2, 'XI IPS 2'),
(3, 'X IPA 2'),
(4, 'X IPS 1'),
(5, 'X IPS 3'),
(6, 'XI IPS 3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_pelanggaran`
--

CREATE TABLE `db_pelanggaran` (
  `id_pelanggaran` int(99) NOT NULL,
  `nama_pelanggaran` text COLLATE utf8mb4_general_ci NOT NULL,
  `point_pelanggaran` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `db_pelanggaran`
--

INSERT INTO `db_pelanggaran` (`id_pelanggaran`, `nama_pelanggaran`, `point_pelanggaran`) VALUES
(1, 'Telat datang sekolah', 5),
(2, 'Tidak mengerjakan PR', 3),
(5, 'Tidak Upacara bendera', 10),
(6, 'Rambut tidak rapi', 10),
(7, 'Bertato Khas', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_riwayat_pelanggaran`
--

CREATE TABLE `db_riwayat_pelanggaran` (
  `id_riwayat` int(11) NOT NULL,
  `id_siswa` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_input` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_pelanggaran` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_pelanggaran` date NOT NULL,
  `catatan` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `db_riwayat_pelanggaran`
--

INSERT INTO `db_riwayat_pelanggaran` (`id_riwayat`, `id_siswa`, `id_input`, `id_pelanggaran`, `tanggal_pelanggaran`, `catatan`) VALUES
(2, '2', '1', '2', '2022-12-09', 'aaa'),
(3, '2', '1', '2', '2022-12-09', ''),
(4, '1', '1', '2', '2022-12-09', ''),
(5, '2', '1', '2', '2022-12-09', 'aaa'),
(7, '1', '1', '5', '2022-12-10', ''),
(8, '33', '1', '6', '2022-12-10', ''),
(9, '11', '1', '5', '2022-12-10', ''),
(10, '39', '1', '5', '2022-12-10', ''),
(11, '37', '1', '6', '2022-12-10', ''),
(12, '1', '1', '2', '2022-12-10', ''),
(13, '1', '1', '6', '2022-12-10', ''),
(14, '2', '5', '6', '2022-12-10', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_siswa`
--

CREATE TABLE `db_siswa` (
  `id_siswa` int(99) NOT NULL,
  `nama_siswa` text COLLATE utf8mb4_general_ci NOT NULL,
  `nis` text COLLATE utf8mb4_general_ci NOT NULL,
  `tahun_masuk` text COLLATE utf8mb4_general_ci NOT NULL,
  `id_kelas` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_input` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `db_siswa`
--

INSERT INTO `db_siswa` (`id_siswa`, `nama_siswa`, `nis`, `tahun_masuk`, `id_kelas`, `id_input`, `status`) VALUES
(1, 'bahariz adillah', '322322332', '2022', '1', '1', '0'),
(2, 'Arulahiriya', '3434343', '2020', '1', '1', '0'),
(11, 'Bhartiyar Amin', '3232', '2022', '4', '1', '0'),
(12, 'Amin Rais', '322', '2022', '4', '1', '0'),
(33, 'rohaya', '24454', '2022', '1', '1', '0'),
(37, 'Miranda Oktavia', '259875', '2022', '1', '1', '0'),
(38, 'Miranda Oktavia', '3289723', '2022', '3', '1', '0'),
(39, 'Oktaviani Aryan', '229872', '2022', '3', '1', '0'),
(40, 'Waludin', '232', '2023', '6', '1', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_user`
--

CREATE TABLE `db_user` (
  `id_user` int(99) NOT NULL,
  `nama_user` text COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` text COLLATE utf8mb4_general_ci NOT NULL,
  `role_user` enum('guru','kepsek','superadmin') COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `db_user`
--

INSERT INTO `db_user` (`id_user`, `nama_user`, `username`, `password`, `role_user`, `status`) VALUES
(1, 'Aji Arian Nofa', 'admin', 'd1a568d6f7a5b1463fd266ff21a259f33e9412e3', 'superadmin', '0'),
(5, 'Nama Guru', 'guru', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 'guru', '0'),
(6, 'Nama Kepsek', 'kepsek', '82b7283910ac7cb508ea7ecc645e5c944d7fb612', 'kepsek', '0');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `db_kelas`
--
ALTER TABLE `db_kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indeks untuk tabel `db_pelanggaran`
--
ALTER TABLE `db_pelanggaran`
  ADD PRIMARY KEY (`id_pelanggaran`);

--
-- Indeks untuk tabel `db_riwayat_pelanggaran`
--
ALTER TABLE `db_riwayat_pelanggaran`
  ADD PRIMARY KEY (`id_riwayat`);

--
-- Indeks untuk tabel `db_siswa`
--
ALTER TABLE `db_siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indeks untuk tabel `db_user`
--
ALTER TABLE `db_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `db_kelas`
--
ALTER TABLE `db_kelas`
  MODIFY `id_kelas` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `db_pelanggaran`
--
ALTER TABLE `db_pelanggaran`
  MODIFY `id_pelanggaran` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `db_riwayat_pelanggaran`
--
ALTER TABLE `db_riwayat_pelanggaran`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `db_siswa`
--
ALTER TABLE `db_siswa`
  MODIFY `id_siswa` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `db_user`
--
ALTER TABLE `db_user`
  MODIFY `id_user` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
