<?php 
// PERBAIKAN: Path disesuaikan untuk struktur file flat (semua file di satu folder)
require_once __DIR__ . '/config.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'PPKO KAMADIKSI UDINUS - Sekolah Perempuan'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #c084fc 0%, #a855f7 50%, #420fc1 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, #6d28d9 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: #8b5cf6;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }
    .hero-pattern {
    background-image: url('img/latar.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
</style>

</head>
<body class="bg-white">
    <header class="gradient-bg py-4 px-6 shadow-md">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center justify-center gap-6 mb-4 md:mb-0">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-md">
                        <img src="img\LogoUdinus.png" alt="Udinus" class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-md">
                    </div>
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-md">
                        <img src="img\kamadiksi.jpg" alt="Kamadiksi" class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-md">
                    </div>
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-md">
                        <img src="img\desa.jpg" alt="Desa" class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-md">
                    </div>
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-md">
                        <img src="img\permata.jpg" alt="sekolah permata" class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-md">
                    </div>
                </div>

                <nav class="flex items-center space-x-8">
                    <a href="#beranda" class="nav-link text-white font-medium hover:text-purple-100 transition">Beranda</a>
                    <a href="#kelas" class="nav-link text-white font-medium hover:text-purple-100 transition">Kelas</a>
                    <a href="#pojok-literasi" class="nav-link text-white font-medium hover:text-purple-100 transition">Pojok Literasi</a>
                    <a href="#lokasi-desa" class="nav-link text-white font-medium hover:text-purple-100 transition">Lokasi</a>
                    <a href="#kontak" class="nav-link text-white font-medium hover:text-purple-100 transition">Kontak</a>
                </nav>
            </div>
        </div>
    </header>