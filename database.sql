CREATE DATABASE IF NOT EXISTS sekolah_permata;
USE sekolah_permata;

-- Tabel admin (gunakan password_hash saat insert data)
CREATE TABLE IF NOT EXISTS admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Tabel saran dan kritik
CREATE TABLE IF NOT EXISTS saran_kritik (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    subjek VARCHAR(150),
    pesan TEXT NOT NULL,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel artikel pojok literasi
CREATE TABLE IF NOT EXISTS artikel (
    id_artikel INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    kategori VARCHAR(100),
    isi TEXT NOT NULL,
    gambar VARCHAR(255),
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel program kelas
CREATE TABLE IF NOT EXISTS kelas (
    id_kelas INT AUTO_INCREMENT PRIMARY KEY,
    nama_kelas VARCHAR(100) NOT NULL,
    deskripsi TEXT NOT NULL,
    gambar VARCHAR(255)
);