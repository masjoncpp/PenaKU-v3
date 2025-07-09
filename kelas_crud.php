<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

// Tambah kelas
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];

    $gambar = '';
    if ($_FILES['gambar']['name']) {
        $dir = 'uploads/';
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $filename = time() . "_" . basename($_FILES['gambar']['name']);
        $path = $dir . $filename;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $path)) {
            $gambar = $path;
        }
    }

    $stmt = $conn->prepare("INSERT INTO kelas (nama_kelas, deskripsi, gambar) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $deskripsi, $gambar);
    $stmt->execute();
}

// Edit kelas
if (isset($_POST['update'])) {
    $id_kelas = $_POST['id_kelas'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];

    $gambar = '';
    if ($_FILES['gambar']['name']) {
        $filename = time() . "_" . basename($_FILES['gambar']['name']);
        $path = "uploads/" . $filename;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $path)) {
            $gambar = $path;
        }
    }

    if ($gambar) {
        $stmt = $conn->prepare("UPDATE kelas SET nama_kelas=?, deskripsi=?, gambar=? WHERE id_kelas=?");
        $stmt->bind_param("sssi", $nama, $deskripsi, $gambar, $id_kelas);
    } else {
        $stmt = $conn->prepare("UPDATE kelas SET nama_kelas=?, deskripsi=? WHERE id_kelas=?");
        $stmt->bind_param("ssi", $nama, $deskripsi, $id_kelas);
    }

    $stmt->execute();
    header("Location: kelas_crud.php");
    exit;
}

// Hapus kelas
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM kelas WHERE id_kelas = $id");
}

$result = $conn->query("SELECT * FROM kelas ORDER BY id_kelas DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CRUD Kelas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold text-purple-700 mb-6">Manajemen Program Kelas</h1>

    <!-- Form Tambah -->
    <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-xl font-semibold mb-4">Tambah Kelas</h2>
        <input type="text" name="nama" placeholder="Nama Kelas" required class="w-full p-3 border rounded mb-4">
        <textarea name="deskripsi" rows="4" placeholder="Deskripsi" required class="w-full p-3 border rounded mb-4"></textarea>
        <input type="file" name="gambar" accept="image/*" class="w-full p-3 border rounded mb-4">
        <button type="submit" name="tambah" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Simpan</button>
    </form>

    <!-- Tabel Data -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Daftar Kelas</h2>
        <table class="w-full table-auto border-collapse">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th class="p-2 text-left">Nama</th>
                    <th class="p-2 text-left">Deskripsi</th>
                    <th class="p-2 text-left">Gambar</th>
                    <th class="p-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                <tr class="border-b">
                    <td class="p-2 font-medium text-purple-800"><?php echo htmlspecialchars($row['nama_kelas']); ?></td>
                    <td class="p-2 text-sm text-gray-700"><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                    <td class="p-2">
                        <?php if ($row['gambar']) : ?>
                            <img src="<?php echo $row['gambar']; ?>" class="h-16 rounded shadow">
                        <?php endif; ?>
                    </td>
                    <td class="p-2">
                        <a href="?edit=<?php echo $row['id_kelas']; ?>" class="text-blue-600 hover:underline mr-4">Edit</a>
                        <a href="?hapus=<?php echo $row['id_kelas']; ?>" onclick="return confirm('Hapus kelas ini?')" class="text-red-600 hover:underline">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Form Edit -->
    <?php if (isset($_GET['edit'])): 
        $id = $_GET['edit'];
        $edit = $conn->query("SELECT * FROM kelas WHERE id_kelas = $id");
        $e = $edit->fetch_assoc(); ?>
        <form method="POST" enctype="multipart/form-data" class="mt-8 bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Edit Kelas</h2>
            <input type="hidden" name="id_kelas" value="<?php echo $e['id_kelas']; ?>">
            <input type="text" name="nama" value="<?php echo htmlspecialchars($e['nama_kelas']); ?>" required class="w-full p-3 border rounded mb-4">
            <textarea name="deskripsi" rows="4" class="w-full p-3 border rounded mb-4"><?php echo htmlspecialchars($e['deskripsi']); ?></textarea>
            <input type="file" name="gambar" class="w-full p-3 border rounded mb-2">
            <?php if ($e['gambar']) echo "<p class='text-sm text-gray-500'>Gambar sekarang: {$e['gambar']}</p>"; ?>
            <button type="submit" name="update" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Perbarui</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
