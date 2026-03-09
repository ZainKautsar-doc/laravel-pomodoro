-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Mar 2026 pada 07.30
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
-- Database: `pomodoro_app`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('todo','in_progress','done') DEFAULT 'todo',
  `deadline` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `status`, `deadline`, `created_at`, `updated_at`) VALUES
(1, 'Belajar dasar Laravel', 'Mempelajari konsep MVC, routing dan controller.', 'in_progress', '2026-03-10', '2026-03-09 06:24:30', '2026-03-09 06:24:30'),
(2, 'Mengerjakan praktikum framework', 'Membuat aplikasi Task Manager dengan Pomodoro Timer.', 'todo', '2026-03-08', '2026-03-09 06:24:30', '2026-03-09 06:24:30'),
(3, 'Mempelajari Blade Template', 'Belajar membuat tampilan menggunakan Blade di Laravel.', 'todo', '2026-03-12', '2026-03-09 06:24:30', '2026-03-09 06:24:30'),
(4, 'Membuat fitur Pomodoro Timer', 'Mengimplementasikan timer fokus belajar 25 menit.', 'in_progress', '2026-03-09', '2026-03-09 06:24:30', '2026-03-09 06:24:30'),
(5, 'Menambahkan fitur Short Break', 'Istirahat pendek setelah sesi Pomodoro.', 'todo', '2026-03-11', '2026-03-09 06:24:30', '2026-03-09 06:24:30'),
(6, 'Menambahkan fitur Long Break', 'Istirahat panjang setelah 4 sesi Pomodoro.', 'todo', '2026-03-13', '2026-03-09 06:24:30', '2026-03-09 06:24:30'),
(7, 'Refactor tampilan UI', 'Mengubah style menjadi Calm Blue + Glass UI.', 'done', '2026-03-05', '2026-03-09 06:24:30', '2026-03-09 06:24:30'),
(8, 'Testing fitur CRUD', 'Menguji fitur tambah, edit, hapus task.', 'todo', '2026-03-14', '2026-03-09 06:24:30', '2026-03-09 06:24:30'),
(9, 'Menyiapkan laporan praktikum', 'Menyusun laporan hasil praktikum Laravel.', 'todo', '2026-03-15', '2026-03-09 06:24:30', '2026-03-09 06:24:30'),
(10, 'Upload project ke GitHub', 'Mengupload source code ke repository GitHub.', 'todo', '2026-03-16', '2026-03-09 06:24:30', '2026-03-09 06:24:30');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
