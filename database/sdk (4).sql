-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Okt 2019 pada 13.02
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sdk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `firstname`, `lastname`, `photo`, `created_on`) VALUES
(1, 'pupersa', '$2y$10$KQXonM6/etO36rLGcu57.uH5RgIkFVsQ1.TqI0wWGa0KGCx8PcStO', 'ris', 'davit', '', '2019-10-02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `pin` text NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_in` time NOT NULL,
  `status` int(1) NOT NULL,
  `time_out` time NOT NULL,
  `num_hr` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `attendance`
--

INSERT INTO `attendance` (`id`, `pin`, `employee_id`, `date`, `time_in`, `status`, `time_out`, `num_hr`) VALUES
(1, '1', 0, '2019-10-24', '10:48:13', 0, '10:57:32', 0),
(2, '2', 0, '2019-10-24', '10:48:17', 0, '10:57:38', 0),
(3, '3', 0, '2019-10-24', '10:48:21', 0, '10:57:46', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cashadvance`
--

CREATE TABLE `cashadvance` (
  `id` int(11) NOT NULL,
  `date_advance` date NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `deductions`
--

CREATE TABLE `deductions` (
  `id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `pin` int(10) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `birthdate` date NOT NULL,
  `contact_info` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `position_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `employees`
--

INSERT INTO `employees` (`id`, `pin`, `employee_id`, `firstname`, `lastname`, `address`, `birthdate`, `contact_info`, `gender`, `position_id`, `schedule_id`, `photo`, `created_on`) VALUES
(10, 1, '', 'dave', '', '', '0000-00-00', '', '', 0, 0, '', '2019-10-18'),
(11, 2, '', 'erl', '', '', '0000-00-00', '', '', 0, 0, '', '2019-10-18'),
(12, 3, '', 'yarn', '', '', '0000-00-00', '', '', 0, 0, '', '2019-10-18'),
(13, 1, '', 'dave', '', '', '0000-00-00', '', '', 0, 0, '', '2019-10-24'),
(14, 2, '', 'erl', '', '', '0000-00-00', '', '', 0, 0, '', '2019-10-24'),
(15, 3, '', 'yarn', '', '', '0000-00-00', '', '', 0, 0, '', '2019-10-24'),
(16, 4, '', 'ris', '', '', '0000-00-00', '', '', 0, 0, '', '2019-10-24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `overtime`
--

CREATE TABLE `overtime` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `hours` double NOT NULL,
  `rate` double NOT NULL,
  `date_overtime` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `description` varchar(150) NOT NULL,
  `rate` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `position`
--

INSERT INTO `position` (`id`, `description`, `rate`) VALUES
(1, 'Staff', 20000),
(2, 'Dosen', 15000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `schedules`
--

INSERT INTO `schedules` (`id`, `time_in`, `time_out`) VALUES
(1, '11:15:00', '23:15:00'),
(2, '00:15:00', '20:45:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_device`
--

CREATE TABLE `tb_device` (
  `No` int(11) NOT NULL,
  `server_IP` text NOT NULL,
  `server_port` text NOT NULL,
  `device_sn` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_device`
--

INSERT INTO `tb_device` (`No`, `server_IP`, `server_port`, `device_sn`) VALUES
(29, '192.168.1.200', '8081', '66595018220053');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_gelar`
--

CREATE TABLE `tb_gelar` (
  `id_gelar` int(5) NOT NULL,
  `pin_scan` text NOT NULL,
  `gelar_depan` varchar(20) NOT NULL,
  `gelar_belakang` varchar(20) NOT NULL,
  `lokasi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_gelar`
--

INSERT INTO `tb_gelar` (`id_gelar`, `pin_scan`, `gelar_depan`, `gelar_belakang`, `lokasi`) VALUES
(1, '1', '', '', ''),
(2, '2', '', '', ''),
(3, '3', '', '', ''),
(4, '4', '', '', ''),
(5, '5', '', '', ''),
(6, '6', '', '', ''),
(7, '7', '', '', ''),
(8, '8', '', '', ''),
(9, '9', '', '', ''),
(10, '10', '', '', ''),
(11, '11', '', '', ''),
(12, '12', '', '', ''),
(13, '13', '', '', ''),
(14, '14', '', '', ''),
(15, '15', '', '', ''),
(16, '16', '', '', ''),
(17, '17', '', '', ''),
(18, '18', '', '', ''),
(19, '19', '', '', ''),
(20, '20', '', '', ''),
(21, '21', '', '', ''),
(22, '22', '', '', ''),
(23, '23', '', '', ''),
(24, '24', '', '', ''),
(25, '25', '', '', ''),
(26, '26', '', '', ''),
(27, '27', '', '', ''),
(28, '28', '', '', ''),
(29, '29', '', '', ''),
(30, '30', '', '', ''),
(31, '31', '', '', ''),
(32, '32', '', '', ''),
(33, '33', '', '', ''),
(34, '34', '', '', ''),
(35, '35', '', '', ''),
(36, '36', '', '', ''),
(37, '37', '', '', ''),
(38, '38', '', '', ''),
(39, '39', '', '', ''),
(40, '40', '', '', ''),
(41, '41', '', '', ''),
(42, '42', '', '', ''),
(43, '43', '', '', ''),
(44, '44', '', '', ''),
(45, '45', '', '', ''),
(46, '46', '', '', ''),
(47, '47', '', '', ''),
(48, '48', '', '', ''),
(49, '49', '', '', ''),
(50, '50', '', '', ''),
(51, '51', '', '', ''),
(52, '52', '', '', ''),
(53, '53', '', '', ''),
(54, '54', '', '', ''),
(55, '55', '', '', ''),
(56, '56', '', '', ''),
(57, '57', '', '', ''),
(58, '58', '', '', ''),
(59, '59', '', '', ''),
(60, '60', '', '', ''),
(61, '61', '', '', ''),
(62, '62', '', '', ''),
(63, '63', '', '', ''),
(64, '64', '', '', ''),
(65, '65', '', '', ''),
(66, '66', '', '', ''),
(67, '67', '', '', ''),
(68, '68', '', '', ''),
(69, '69', '', '', ''),
(70, '70', '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_penampilan`
--

CREATE TABLE `tb_penampilan` (
  `no` int(11) NOT NULL,
  `pin` text NOT NULL,
  `nama` text NOT NULL,
  `status_penampilan` tinyint(1) NOT NULL,
  `gelar_depan` varchar(50) NOT NULL,
  `gelar_belakang` varchar(50) NOT NULL,
  `lokasi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_scanlog`
--

CREATE TABLE `tb_scanlog` (
  `sn` text NOT NULL,
  `scan_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pin` text NOT NULL,
  `verifymode` int(11) NOT NULL,
  `iomode` int(11) NOT NULL,
  `workcode` int(11) NOT NULL,
  `tanggal_absen` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_scanlog`
--

INSERT INTO `tb_scanlog` (`sn`, `scan_date`, `pin`, `verifymode`, `iomode`, `workcode`, `tanggal_absen`) VALUES
('66595018220053', '2019-10-24 03:48:13', '1', 1, 1, 0, '2019-10-24'),
('66595018220053', '2019-10-24 03:48:17', '2', 1, 1, 0, '2019-10-24'),
('66595018220053', '2019-10-24 03:48:21', '3', 1, 1, 0, '2019-10-24'),
('66595018220053', '2019-10-24 03:57:32', '1', 1, 2, 0, '2019-10-24'),
('66595018220053', '2019-10-24 03:57:38', '2', 1, 2, 0, '2019-10-24'),
('66595018220053', '2019-10-24 03:57:46', '3', 1, 2, 0, '2019-10-24');

--
-- Trigger `tb_scanlog`
--
DELIMITER $$
CREATE TRIGGER `absensi` BEFORE INSERT ON `tb_scanlog` FOR EACH ROW IF(new.iomode)=1 THEN

   INSERT INTO attendance SET pin=new.pin, date=new.scan_date, time_in=new.scan_date;
   
ELSE

UPDATE attendance SET time_out=new.scan_date where pin=new.pin AND date=new.tanggal_absen;
  
END IF
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `add_to_penampilan` AFTER INSERT ON `tb_scanlog` FOR EACH ROW insert into tb_penampilan (pin, nama, gelar_depan, gelar_belakang, lokasi) 
select tb_scanlog.pin, tb_user.nama, tb_gelar.gelar_depan, tb_gelar.gelar_belakang, tb_gelar.lokasi from tb_scanlog
inner join tb_user on tb_scanlog.pin=tb_user.pin
inner join tb_gelar on tb_scanlog.pin = tb_gelar.pin_scan
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_template`
--

CREATE TABLE `tb_template` (
  `pin` text NOT NULL,
  `finger_idx` int(11) NOT NULL,
  `alg_ver` int(11) NOT NULL,
  `template` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `pin` text NOT NULL,
  `nama` text NOT NULL,
  `pwd` text NOT NULL,
  `rfid` text NOT NULL,
  `privilege` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`pin`, `nama`, `pwd`, `rfid`, `privilege`) VALUES
('1', 'dave', '0', '', 0),
('2', 'erl', '0', '', 0),
('3', 'yarn', '0', '', 0),
('4', 'ris', '0', '', 0);

--
-- Trigger `tb_user`
--
DELIMITER $$
CREATE TRIGGER `add_employee` BEFORE INSERT ON `tb_user` FOR EACH ROW INSERT INTO employees SET pin=new.pin, firstname=new.nama, created_on=CURRENT_DATE
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cashadvance`
--
ALTER TABLE `cashadvance`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `overtime`
--
ALTER TABLE `overtime`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_device`
--
ALTER TABLE `tb_device`
  ADD PRIMARY KEY (`No`);

--
-- Indeks untuk tabel `tb_gelar`
--
ALTER TABLE `tb_gelar`
  ADD PRIMARY KEY (`id_gelar`);

--
-- Indeks untuk tabel `tb_penampilan`
--
ALTER TABLE `tb_penampilan`
  ADD PRIMARY KEY (`no`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `cashadvance`
--
ALTER TABLE `cashadvance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `overtime`
--
ALTER TABLE `overtime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_device`
--
ALTER TABLE `tb_device`
  MODIFY `No` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `tb_gelar`
--
ALTER TABLE `tb_gelar`
  MODIFY `id_gelar` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT untuk tabel `tb_penampilan`
--
ALTER TABLE `tb_penampilan`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
