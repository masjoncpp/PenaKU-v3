<?php
session_start();
require_once 'config.php';

$notification = '';

// --- BAGIAN LOGIKA PEMROSESAN FORM (ACTION HANDLER) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    // Aksi untuk menyimpan (Tambah/Edit) data kelas
    if ($_POST['action'] === 'simpan_kelas') {
        $id = $_POST['id_kelas'];
        $nama_kelas = trim(htmlspecialchars($_POST['nama_kelas']));
        $deskripsi = trim(htmlspecialchars($_POST['deskripsi_singkat']));

        if (empty($id)) { // INSERT
            $stmt = $koneksi->prepare("INSERT INTO program_kelas (nama_kelas, deskripsi_singkat) VALUES (?, ?)");
            $stmt->bind_param("ss", $nama_kelas, $deskripsi);
            $_SESSION['notification'] = 'Kelas baru berhasil ditambahkan!';
        } else { // UPDATE
            $stmt = $koneksi->prepare("UPDATE program_kelas SET nama_kelas = ?, deskripsi_singkat = ? WHERE id = ?");
            $stmt->bind_param("ssi", $nama_kelas, $deskripsi, $id);
            $_SESSION['notification'] = 'Data kelas berhasil diperbarui!';
        }
        $stmt->execute();
        $stmt->close();
        header('Location: admin.php#kelas');
        exit;
    }

    // Aksi untuk menghapus data kelas
    if ($_POST['action'] === 'hapus_kelas') {
        $id = $_POST['id_kelas'];
        $stmt = $koneksi->prepare("DELETE FROM program_kelas WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $_SESSION['notification'] = 'Data kelas berhasil dihapus!';
        header('Location: admin.php#kelas');
        exit;
    }
}

if (isset($_SESSION['notification'])) {
    $notification = $_SESSION['notification'];
    unset($_SESSION['notification']);
}


// --- BAGIAN PENGAMBILAN DATA DARI DATABASE (PERBAIKAN NAMA TABEL) ---
$pendaftar_result = $koneksi->query("SELECT p.*, k.nama_kelas FROM pendaftar p JOIN program_kelas k ON p.kelas_id = k.id ORDER BY p.tanggal_pendaftaran DESC");
$kelas_result = $koneksi->query("SELECT * FROM program_kelas ORDER BY id ASC");
$artikel_result = $koneksi->query("SELECT * FROM artikel_literasi ORDER BY tanggal_publikasi DESC");
$testimoni_result = $koneksi->query("SELECT * FROM testimoni ORDER BY id DESC");

// Ambil data statistik untuk dashboard (PERBAIKAN NAMA TABEL)
$total_pendaftar = $koneksi->query("SELECT COUNT(id) as total FROM pendaftar")->fetch_assoc()['total'];
$total_kelas = $koneksi->query("SELECT COUNT(id) as total FROM program_kelas")->fetch_assoc()['total'];
$total_artikel = $koneksi->query("SELECT COUNT(id) as total FROM artikel_literasi")->fetch_assoc()['total'];
$total_testimoni = $koneksi->query("SELECT COUNT(id) as total FROM testimoni")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Sekolah Perempuan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f1f5f9; }
        .gradient-text { background: linear-gradient(135deg, #6d28d9 0%, #8b5cf6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .admin-section { display: none; }
        .admin-section.active { display: block; animation: fadeIn 0.5s; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .modal { transition: opacity 0.3s ease; }
        .nav-link.active { background-color: #4a5568; color: white; }
    </style>
</head>
<body class="flex h-screen">

    <aside class="w-64 bg-gray-800 text-white flex flex-col fixed h-full z-20">
        <div class="h-20 flex items-center justify-center border-b border-gray-700">
            <h1 class="text-xl font-bold">Admin Panel</h1>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="#dashboard" class="nav-link flex items-center px-4 py-2.5 text-gray-300 rounded-lg hover:bg-gray-700"><i class="ri-dashboard-line mr-3"></i> Dashboard</a>
            <a href="#pendaftar" class="nav-link flex items-center px-4 py-2.5 text-gray-300 rounded-lg hover:bg-gray-700"><i class="ri-team-line mr-3"></i> Data Pendaftar</a>
            <a href="#kelas" class="nav-link flex items-center px-4 py-2.5 text-gray-300 rounded-lg hover:bg-gray-700"><i class="ri-presentation-line mr-3"></i> Kelola Kelas</a>
            <a href="#artikel" class="nav-link flex items-center px-4 py-2.5 text-gray-300 rounded-lg hover:bg-gray-700"><i class="ri-book-open-line mr-3"></i> Kelola Artikel</a>
            <a href="#testimoni" class="nav-link flex items-center px-4 py-2.5 text-gray-300 rounded-lg hover:bg-gray-700"><i class="ri-chat-quote-line mr-3"></i> Kelola Testimoni</a>
        </nav>
    </aside>

    <main class="flex-1 ml-64 p-8 overflow-y-auto">

        <?php if ($notification): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo htmlspecialchars($notification); ?></span>
        </div>
        <?php endif; ?>

        <section id="dashboard" class="admin-section">
            <h2 class="text-3xl font-bold mb-8 gradient-text">Dashboard</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-md"><p class="text-gray-500">Total Pendaftar</p><p class="text-3xl font-bold text-gray-800"><?php echo $total_pendaftar; ?></p></div>
                <div class="bg-white p-6 rounded-xl shadow-md"><p class="text-gray-500">Total Kelas</p><p class="text-3xl font-bold text-gray-800"><?php echo $total_kelas; ?></p></div>
                <div class="bg-white p-6 rounded-xl shadow-md"><p class="text-gray-500">Total Artikel</p><p class="text-3xl font-bold text-gray-800"><?php echo $total_artikel; ?></p></div>
                <div class="bg-white p-6 rounded-xl shadow-md"><p class="text-gray-500">Total Testimoni</p><p class="text-3xl font-bold text-gray-800"><?php echo $total_testimoni; ?></p></div>
            </div>
        </section>

        <section id="pendaftar" class="admin-section">
            <h2 class="text-3xl font-bold mb-8 gradient-text">Data Pendaftar</h2>
            <div class="bg-white rounded-xl shadow-md overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4">Nama</th><th class="p-4">Kelas</th><th class="p-4">Telepon</th><th class="p-4">Tgl Daftar</th><th class="p-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <?php while($pendaftar = $pendaftar_result->fetch_assoc()): ?>
                        <tr>
                            <td class="p-4"><?php echo htmlspecialchars($pendaftar['nama_lengkap']); ?></td>
                            <td class="p-4"><?php echo htmlspecialchars($pendaftar['nama_kelas']); ?></td>
                            <td class="p-4"><?php echo htmlspecialchars($pendaftar['nomor_telepon']); ?></td>
                            <td class="p-4"><?php echo date('d M Y', strtotime($pendaftar['tanggal_pendaftaran'])); ?></td>
                            <td class="p-4"><span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700"><?php echo htmlspecialchars($pendaftar['status']); ?></span></td>
                        </tr>
                        <?php endwhile; ?>
                         <?php if($pendaftar_result->num_rows === 0): ?>
                        <tr><td colspan="5" class="p-4 text-center text-gray-500">Belum ada data pendaftar.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
        
        <section id="kelas" class="admin-section">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold gradient-text">Kelola Program Kelas</h2>
                <button onclick="openKelasModal()" class="px-5 py-2.5 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700"><i class="ri-add-line mr-2"></i> Tambah Kelas</button>
            </div>
            <div class="bg-white rounded-xl shadow-md overflow-x-auto">
                <table class="w-full text-left">
                    <thead><tr class="bg-gray-50"><th class="p-4">Nama Kelas</th><th class="p-4">Deskripsi</th><th class="p-4 text-center">Aksi</th></tr></thead>
                    <tbody class="divide-y">
                        <?php while($kelas = $kelas_result->fetch_assoc()): ?>
                        <tr>
                            <td class="p-4 font-medium"><?php echo htmlspecialchars($kelas['nama_kelas']); ?></td>
                            <td class="p-4 max-w-md"><?php echo htmlspecialchars($kelas['deskripsi_singkat']); ?></td>
                            <td class="p-4 text-center">
                                <button onclick="editKelas(this)" class="text-blue-500 hover:text-blue-700 mr-4"
                                    data-id="<?php echo $kelas['id']; ?>"
                                    data-nama="<?php echo htmlspecialchars($kelas['nama_kelas']); ?>"
                                    data-deskripsi="<?php echo htmlspecialchars($kelas['deskripsi_singkat']); ?>">Edit</button>
                                <form action="admin.php#kelas" method="POST" class="inline" onsubmit="return confirm('Anda yakin ingin menghapus kelas ini? Ini akan menghapus semua pendaftar di kelas ini juga!');">
                                    <input type="hidden" name="action" value="hapus_kelas">
                                    <input type="hidden" name="id_kelas" value="<?php echo $kelas['id']; ?>">
                                    <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                         <?php if($kelas_result->num_rows === 0): ?>
                        <tr><td colspan="3" class="p-4 text-center text-gray-500">Belum ada data kelas.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="artikel" class="admin-section">
             <h2 class="text-3xl font-bold mb-8 gradient-text">Kelola Artikel</h2>
             <p>Fitur untuk mengelola artikel akan ditambahkan di sini.</p>
        </section>

        <section id="testimoni" class="admin-section">
             <h2 class="text-3xl font-bold mb-8 gradient-text">Kelola Testimoni</h2>
             <p>Fitur untuk mengelola testimoni akan ditambahkan di sini.</p>
        </section>
    </main>

    <div id="kelas-modal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-30 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg">
            <form id="form-kelas" action="admin.php#kelas" method="POST">
                <div class="flex justify-between items-center p-5 border-b"><h3 id="kelas-modal-title" class="text-2xl font-semibold"></h3><button type="button" onclick="closeModal('kelas-modal')" class="text-gray-400 hover:text-gray-700 text-3xl">×</button></div>
                <div class="p-6 space-y-4">
                    <input type="hidden" name="action" value="simpan_kelas">
                    <input type="hidden" id="id_kelas" name="id_kelas">
                    <div>
                        <label for="nama_kelas" class="block font-medium">Nama Kelas</label>
                        <input type="text" id="nama_kelas" name="nama_kelas" class="w-full mt-1 px-4 py-2 border rounded-lg" required>
                    </div>
                    <div>
                        <label for="deskripsi_singkat" class="block font-medium">Deskripsi Singkat</label>
                        <textarea id="deskripsi_singkat" name="deskripsi_singkat" rows="4" class="w-full mt-1 px-4 py-2 border rounded-lg" required></textarea>
                    </div>
                </div>
                <div class="text-right p-5 border-t bg-gray-50 rounded-b-xl">
                    <button type="button" onclick="closeModal('kelas-modal')" class="px-6 py-2 mr-2 text-gray-700 border rounded-lg hover:bg-gray-100">Batal</button>
                    <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('.admin-section');
    function showSection(hash) {
        const targetId = (hash && document.querySelector(hash)) ? hash.substring(1) : 'dashboard';
        sections.forEach(s => s.classList.toggle('active', s.id === targetId));
        navLinks.forEach(l => l.classList.toggle('active', l.getAttribute('href') === `#${targetId}`));
    }
    navLinks.forEach(link => { link.addEventListener('click', (e) => { e.preventDefault(); window.location.hash = e.currentTarget.getAttribute('href'); }); });
    window.addEventListener('hashchange', () => showSection(window.location.hash));
    if (window.location.hash) { showSection(window.location.hash); } else { showSection('#dashboard'); }

    window.closeModal = function(modalId) { document.getElementById(modalId).classList.add('hidden'); }
    window.openKelasModal = function() {
        const modal = document.getElementById('kelas-modal');
        document.getElementById('kelas-modal-title').textContent = 'Tambah Kelas Baru';
        document.getElementById('form-kelas').reset();
        document.getElementById('id_kelas').value = '';
        modal.classList.remove('hidden');
    }
    window.editKelas = function(button) {
        const modal = document.getElementById('kelas-modal');
        document.getElementById('kelas-modal-title').textContent = 'Edit Kelas';
        document.getElementById('id_kelas').value = button.dataset.id;
        document.getElementById('nama_kelas').value = button.dataset.nama;
        document.getElementById('deskripsi_singkat').value = button.dataset.deskripsi;
        modal.classList.remove('hidden');
    }
});
</script>
</body>
</html>