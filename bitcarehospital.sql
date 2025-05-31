-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Bulan Mei 2025 pada 18.25
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bitcarehospital`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL,
  `nama_dokter` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `jadwal_dokter` varchar(100) NOT NULL,
  `no_ruangan` int(11) NOT NULL,
  `no_antrian` int(11) NOT NULL,
  `jenis_dokter` varchar(50) DEFAULT NULL,
  `kodekhusus` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dokter`
--

INSERT INTO `dokter` (`id`, `nama_dokter`, `jabatan`, `no_telepon`, `jadwal_dokter`, `no_ruangan`, `no_antrian`, `jenis_dokter`, `kodekhusus`) VALUES
(1, 'Dr. Andi', 'Spesialis Jantung', '081234567891', 'Senin-Rabu 08:00-12:00', 101, 1, 'Spesialis', 'S12'),
(2, 'Dr. Budi', 'Kepala Departemen', '081234567892', 'Senin-Jumat 09:00-14:00', 102, 2, 'Spesialis', 'S10'),
(3, 'Dr. Clara', 'Spesialis Kulit', '081234567893', 'Selasa-Kamis 10:00-13:00', 103, 3, 'Spesialis', 'S15'),
(4, 'Dr. Dedi', 'Spesialis Anak', '081234567894', 'Rabu-Jumat 11:00-15:00', 104, 4, 'Spesialis', 'S17'),
(5, 'Dr. Eka', 'Spesialis Bedah', '081234567895', 'Senin-Jumat 08:00-11:00', 105, 5, 'Spesialis', 'S18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `kode_obat` varchar(10) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `dosis` varchar(50) NOT NULL,
  `stok` int(11) NOT NULL,
  `tanggal_kadaluarsa` date NOT NULL,
  `harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`kode_obat`, `nama_obat`, `dosis`, `stok`, `tanggal_kadaluarsa`, `harga`) VALUES
('OB001', 'Paracetamol', '500mg', 100, '2026-01-01', 5000.00),
('OB002', 'Amoxicillin', '250mg', 80, '2025-12-31', 8000.00),
('OB003', 'Ibuprofen', '400mg', 50, '2026-06-15', 7000.00),
('OB004', 'Cetirizine', '10mg', 60, '2025-11-30', 6000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) NOT NULL,
  `nama_pasien` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `gol_darah` varchar(3) NOT NULL,
  `no_antrian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id`, `nama_pasien`, `alamat`, `tanggal_lahir`, `no_telepon`, `jenis_kelamin`, `gol_darah`, `no_antrian`) VALUES
(1, 'Ahmad', 'jl.bandung', '2025-05-29', '0811111111', 'Laki-laki', 'A', 1),
(2, 'Siti', 'Jl. Kenanga 2', '1985-02-20', '0812222222', 'Perempuan', 'A', 2),
(3, 'Bayu', 'Jl. Melati 3', '2000-03-15', '0813333333', 'Laki-laki', 'B', 3),
(4, 'Rina', 'Jl. Anggrek 4', '1995-04-25', '0814444444', 'Perempuan', 'AB', 4),
(5, 'Dewi', 'Jl. Sakura 5', '1992-05-30', '0815555555', 'Perempuan', 'O', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelayanan`
--

CREATE TABLE `pelayanan` (
  `no_antrian` int(11) NOT NULL,
  `no_ruang` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_operasi` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelayanan`
--

INSERT INTO `pelayanan` (`no_antrian`, `no_ruang`, `id_dokter`, `id_pasien`, `tanggal`, `jam_operasi`) VALUES
(2, 102, 2, 2, '2025-04-02', '09:00:00'),
(3, 103, 3, 3, '2025-04-03', '10:00:00'),
(4, 104, 4, 4, '2025-04-04', '11:00:00'),
(5, 105, 5, 5, '2025-04-05', '08:30:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perawat`
--

CREATE TABLE `perawat` (
  `id_perawat` int(11) NOT NULL,
  `nama_perawat` varchar(100) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `spesialisasi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `perawat`
--

INSERT INTO `perawat` (`id_perawat`, `nama_perawat`, `id_pasien`, `no_telepon`, `spesialisasi`) VALUES
(1, 'Perawat Ani', 1, '0811112222', 'Anak'),
(2, 'Perawat Beni', 2, '0812223333', 'Bedah'),
(3, 'Perawat Cici', 3, '0813334444', 'Kulit'),
(4, 'Perawat Dodi', 4, '0814445555', 'Jantung'),
(5, 'Perawat Eni', 5, '0815556666', 'Umum');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekam_medis`
--

CREATE TABLE `rekam_medis` (
  `no_rekam_medis` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `riwayat` text NOT NULL,
  `tanggal_rekam` date NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `identitas_pasien` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rekam_medis`
--

INSERT INTO `rekam_medis` (`no_rekam_medis`, `id_pasien`, `riwayat`, `tanggal_rekam`, `id_dokter`, `identitas_pasien`) VALUES
(1, 1, 'Demam tinggi', '2025-04-01', 1, 'Ahmad - 0811111111'),
(2, 2, 'Alergi debu', '2025-04-02', 2, 'Siti - 0812222222'),
(3, 3, 'Infeksi kulit ringan', '2025-04-03', 3, 'Bayu - 0813333333'),
(4, 4, 'Batuk 3 minggu', '2025-04-04', 4, 'Rina - 0814444444'),
(5, 5, 'Nyeri perut bawah', '2025-04-05', 5, 'Dewi - 0815555555');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruangan`
--

CREATE TABLE `ruangan` (
  `no_ruangan` int(11) NOT NULL,
  `jenis_ruangan` varchar(50) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `alat` text NOT NULL,
  `lantai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ruangan`
--

INSERT INTO `ruangan` (`no_ruangan`, `jenis_ruangan`, `kapasitas`, `alat`, `lantai`) VALUES
(101, 'Rawat Jalan', 10, 'Tiang Infus', 1),
(102, 'Rawat Inap', 20, 'Tempat Tidur', 2),
(103, 'Khusus Anak', 15, 'Timbangan Anak', 2),
(104, 'Bedah', 5, 'Alat Operasi', 3),
(105, 'Umum', 12, 'Meja Periksa', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `staff`
--

CREATE TABLE `staff` (
  `id_staff` int(11) NOT NULL,
  `nama_staf` varchar(100) NOT NULL,
  `no_ruang` int(11) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `no_telepon` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `staff`
--

INSERT INTO `staff` (`id_staff`, `nama_staf`, `no_ruang`, `jabatan`, `no_telepon`) VALUES
(1, 'Staff A', 101, 'Administrasi', '0811000001'),
(2, 'Staff B', 102, 'Keamanan', '0811000002'),
(3, 'Staff C', 103, 'Kebersihan', '0811000003'),
(4, 'Staff D', 104, 'Administrasi', '0811000004'),
(5, 'Staff E', 105, 'Logistik', '0811000005');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tindakan_medis`
--

CREATE TABLE `tindakan_medis` (
  `no_tindakan` int(11) NOT NULL,
  `no_rekam_medis` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `tanggal_tindakan` date NOT NULL,
  `jenis_tindakan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tindakan_medis`
--

INSERT INTO `tindakan_medis` (`no_tindakan`, `no_rekam_medis`, `id_dokter`, `tanggal_tindakan`, `jenis_tindakan`) VALUES
(1, 1, 1, '2025-04-01', 'Pemeriksaan Umum'),
(2, 2, 2, '2025-04-02', 'Tes Alergi'),
(3, 3, 3, '2025-04-03', 'Salep Antibiotik'),
(4, 4, 4, '2025-04-04', 'Terapi Nebulizer'),
(5, 5, 5, '2025-04-05', 'USG Abdomen');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `no_transaksi` int(11) NOT NULL,
  `no_ruang` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `asuransi` varchar(50) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `jenis_transaksi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`no_transaksi`, `no_ruang`, `id_pasien`, `total_harga`, `asuransi`, `tanggal_transaksi`, `jenis_transaksi`) VALUES
(1, 101, 1, 500000.00, 'BPJS', '2025-04-01', 'Rawat Jalan'),
(2, 102, 2, 750000.00, 'Pribadi', '2025-04-02', 'Rawat Inap'),
(3, 103, 3, 300000.00, 'BPJS', '2025-04-03', 'Rawat Jalan'),
(4, 104, 4, 1000000.00, 'Asuransi Swasta', '2025-04-04', 'Operasi'),
(5, 105, 5, 450000.00, 'BPJS', '2025-04-05', 'Rawat Jalan');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`kode_obat`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pelayanan`
--
ALTER TABLE `pelayanan`
  ADD PRIMARY KEY (`no_antrian`),
  ADD KEY `no_ruang` (`no_ruang`),
  ADD KEY `id_dokter` (`id_dokter`),
  ADD KEY `id_pasien` (`id_pasien`);

--
-- Indeks untuk tabel `perawat`
--
ALTER TABLE `perawat`
  ADD PRIMARY KEY (`id_perawat`),
  ADD KEY `id_pasien` (`id_pasien`);

--
-- Indeks untuk tabel `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD PRIMARY KEY (`no_rekam_medis`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_dokter` (`id_dokter`);

--
-- Indeks untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`no_ruangan`);

--
-- Indeks untuk tabel `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id_staff`),
  ADD KEY `no_ruang` (`no_ruang`);

--
-- Indeks untuk tabel `tindakan_medis`
--
ALTER TABLE `tindakan_medis`
  ADD PRIMARY KEY (`no_tindakan`),
  ADD KEY `no_rekam_medis` (`no_rekam_medis`),
  ADD KEY `id_dokter` (`id_dokter`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`no_transaksi`),
  ADD KEY `no_ruang` (`no_ruang`),
  ADD KEY `id_pasien` (`id_pasien`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pelayanan`
--
ALTER TABLE `pelayanan`
  ADD CONSTRAINT `pelayanan_ibfk_1` FOREIGN KEY (`no_ruang`) REFERENCES `ruangan` (`no_ruangan`),
  ADD CONSTRAINT `pelayanan_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`),
  ADD CONSTRAINT `pelayanan_ibfk_3` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`);

--
-- Ketidakleluasaan untuk tabel `perawat`
--
ALTER TABLE `perawat`
  ADD CONSTRAINT `perawat_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`);

--
-- Ketidakleluasaan untuk tabel `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD CONSTRAINT `rekam_medis_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`),
  ADD CONSTRAINT `rekam_medis_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`);

--
-- Ketidakleluasaan untuk tabel `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`no_ruang`) REFERENCES `ruangan` (`no_ruangan`);

--
-- Ketidakleluasaan untuk tabel `tindakan_medis`
--
ALTER TABLE `tindakan_medis`
  ADD CONSTRAINT `tindakan_medis_ibfk_1` FOREIGN KEY (`no_rekam_medis`) REFERENCES `rekam_medis` (`no_rekam_medis`),
  ADD CONSTRAINT `tindakan_medis_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`);

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`no_ruang`) REFERENCES `ruangan` (`no_ruangan`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
