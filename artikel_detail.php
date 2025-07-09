<?php
include 'config.php';

if (!isset($_GET['id'])) {
    echo "<p>Artikel tidak ditemukan.</p>";
    exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM artikel WHERE id_artikel = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>Artikel tidak ditemukan.</p>";
    exit;
}

$row = $result->fetch_assoc();
include 'header.php';
?>

<section class="py-16">
    <div class="container mx-auto px-6 max-w-3xl">
        <h1 class="text-3xl font-bold text-purple-800 mb-4"><?php echo htmlspecialchars($row['judul']); ?></h1>
        <p class="text-sm text-purple-500 mb-6"><?php echo htmlspecialchars($row['kategori']); ?> | <?php echo $row['tanggal']; ?></p>
        <?php if ($row['gambar']) : ?>
            <img src="<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>" class="w-full h-auto rounded-lg mb-6">
        <?php endif; ?>
        <div class="prose max-w-none text-gray-800">
            <?php echo nl2br($row['isi']); ?>
        </div>
        <div class="mt-8">
            <a href="index.php#pojok-literasi" class="text-purple-600 hover:underline">⬅️ Kembali ke Pojok Literasi</a>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
