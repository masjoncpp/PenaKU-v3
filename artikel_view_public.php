<?php
include 'config.php';
$artikel = $conn->query("SELECT * FROM artikel ORDER BY tanggal DESC");
?>

<section id="pojok-literasi" class="py-16 bg-purple-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold mb-12 text-center gradient-text">Pojok Literasi</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php while ($row = $artikel->fetch_assoc()) : ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <?php if ($row['gambar']) : ?>
                    <img src="<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>" class="w-full h-48 object-cover">
                <?php endif; ?>
                <div class="p-6">
                    <span class="text-xs text-purple-600 uppercase"><?php echo htmlspecialchars($row['kategori']); ?></span>
                    <h3 class="text-xl font-bold text-purple-800 mt-2 mb-3">
  <a href="artikel_detail.php?id=<?php echo $row['id_artikel']; ?>" class="hover:underline">
    <?php echo htmlspecialchars($row['judul']); ?>
  </a>
</h3>
                    <p class="text-gray-600 text-sm"><?php echo substr(strip_tags($row['isi']), 0, 100); ?>...</p>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>