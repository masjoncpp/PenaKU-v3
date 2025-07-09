<?php
// hubungkan ke database Anda
include 'config.php';

// --- DATA ADMIN BARU ---
$username_baru = 'ppko'; // Ganti dengan username yang Anda inginkan
$password_baru = 'kominfo12'; // Ganti dengan password yang kuat

// --- HASH PASSWORD ---
// Gunakan algoritma hashing default yang aman
$password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

// --- SIMPAN KE DATABASE ---
// Gunakan prepared statement untuk keamanan
$stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");

// Periksa apakah statement berhasil dibuat
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameter ke statement
$stmt->bind_param("ss", $username_baru, $password_hash);

// Eksekusi statement dan berikan pesan
if ($stmt->execute()) {
    echo "Admin baru berhasil dibuat!<br>";
    echo "Username: " . htmlspecialchars($username_baru) . "<br>";
    echo "Password yang dimasukkan: " . htmlspecialchars($password_baru) . "<br>";
    echo "Password HASH (disimpan di DB): " . htmlspecialchars($password_hash);
} else {
    echo "Error: " . $stmt->error;
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();
?>