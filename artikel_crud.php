<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

// Tambah artikel baru
if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $kategori = $_POST['kategori'];
    $isi = $_POST['isi'];

    $gambar = '';
    if ($_FILES['gambar']['name']) {
        $dir = 'uploads/';
        if (!is_dir($dir)) mkdir($dir);
        $filename = time() . "_" . basename($_FILES['gambar']['name']);
        $path = $dir . $filename;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $path)) {
            $gambar = $path;
        }
    }

    $stmt = $conn->prepare("INSERT INTO artikel (judul, kategori, isi, gambar) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $judul, $kategori, $isi, $gambar);
    $stmt->execute();
}

// Update artikel
if (isset($_POST['update'])) {
    $id = $_POST['id_artikel'];
    $judul = $_POST['judul'];
    $kategori = $_POST['kategori'];
    $isi = $_POST['isi'];

    $gambar = '';
    if ($_FILES['gambar']['name']) {
        $filename = time() . "_" . basename($_FILES['gambar']['name']);
        $path = "uploads/" . $filename;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $path)) {
            $gambar = $path;
        }
    }

    if ($gambar) {
        $stmt = $conn->prepare("UPDATE artikel SET judul=?, kategori=?, isi=?, gambar=? WHERE id_artikel=?");
        $stmt->bind_param("ssssi", $judul, $kategori, $isi, $gambar, $id);
    } else {
        $stmt = $conn->prepare("UPDATE artikel SET judul=?, kategori=?, isi=? WHERE id_artikel=?");
        $stmt->bind_param("sssi", $judul, $kategori, $isi, $id);
    }
    $stmt->execute();
    header("Location: artikel_crud.php");
    exit;
}

// Hapus artikel
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM artikel WHERE id_artikel = $id");
}

$result = $conn->query("SELECT * FROM artikel ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CRUD Artikel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold text-purple-700 mb-6">Manajemen Artikel</h1>

    <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-xl font-semibold mb-4">Tambah Artikel</h2>
        <input type="text" name="judul" placeholder="Judul" class="w-full p-2 mb-4 border rounded">
        <input type="text" name="kategori" placeholder="Kategori" class="w-full p-2 mb-4 border rounded">
        <textarea name="isi" placeholder="Isi artikel" rows="4" class="w-full p-2 mb-4 border rounded"></textarea>
        <input type="file" name="gambar" class="w-full mb-4">
        <button type="submit" name="submit" class="bg-purple-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4">Daftar Artikel</h2>
        <table class="w-full table-auto">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th class="p-2 text-left">Judul</th>
                    <th class="p-2 text-left">Kategori</th>
                    <th class="p-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr class="border-b">
                    <td class="p-2"><?php echo htmlspecialchars($row['judul']); ?></td>
                    <td class="p-2"><?php echo htmlspecialchars($row['kategori']); ?></td>
                    <td class="p-2">
                        <a href="?edit=<?php echo $row['id_artikel']; ?>" class="text-blue-600 hover:underline mr-3">Edit</a>
                        <a href="?hapus=<?php echo $row['id_artikel']; ?>" onclick="return confirm('Hapus artikel ini?')" class="text-red-600 hover:underline">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php if (isset($_GET['edit'])): 
        $edit = $conn->query("SELECT * FROM artikel WHERE id_artikel = " . intval($_GET['edit']));
        $e = $edit->fetch_assoc(); ?>
        <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow mt-8">
            <h2 class="text-xl font-semibold mb-4">Edit Artikel</h2>
            <input type="hidden" name="id_artikel" value="<?php echo $e['id_artikel']; ?>">
            <input type="text" name="judul" value="<?php echo htmlspecialchars($e['judul']); ?>" class="w-full p-2 mb-4 border rounded">
            <input type="text" name="kategori" value="<?php echo htmlspecialchars($e['kategori']); ?>" class="w-full p-2 mb-4 border rounded">
            <textarea name="isi" rows="4" class="w-full p-2 mb-4 border rounded"><?php echo htmlspecialchars($e['isi']); ?></textarea>
            <input type="file" name="gambar" class="w-full mb-2">
            <?php if ($e['gambar']) echo "<p class='text-sm text-gray-500'>Gambar saat ini: {$e['gambar']}</p>"; ?>
            <button type="submit" name="update" class="bg-green-600 text-white px-4 py-2 rounded">Perbarui</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
