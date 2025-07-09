<?php // kontak.php ?>
<?php include 'config.php'; ?>
<section id="kontak" class="py-16 bg-purple-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold mb-12 text-center gradient-text">Hubungi Kami</h2>
        <div class="flex flex-col md:flex-row gap-10">
            <div class="md:w-1/2">
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nama = htmlspecialchars($_POST['name']);
                    $email = htmlspecialchars($_POST['email']);
                    $subject = htmlspecialchars($_POST['subject']);
                    $message = htmlspecialchars($_POST['message']);

                    $stmt = $conn->prepare("INSERT INTO saran_kritik (nama, email, subjek, pesan) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $nama, $email, $subject, $message);

                    if ($stmt->execute()) {
                        echo "<div class='bg-green-100 text-green-800 px-4 py-3 rounded mb-6'>Pesan berhasil dikirim!</div>";
                    } else {
                        echo "<div class='bg-red-100 text-red-800 px-4 py-3 rounded mb-6'>Gagal mengirim pesan.</div>";
                    }

                    $stmt->close();
                }
                ?>
                <form method="post" class="bg-white p-8 rounded-xl shadow-lg">
                    <div class="mb-6">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                        <input type="text" id="name" name="name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    </div>
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    </div>
                    <div class="mb-6">
                        <label for="subject" class="block text-gray-700 font-medium mb-2">Subjek</label>
                        <input type="text" id="subject" name="subject" required class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    </div>
                    <div class="mb-6">
                        <label for="message" class="block text-gray-700 font-medium mb-2">Pesan</label>
                        <textarea id="message" name="message" rows="5" required class="w-full px-4 py-3 border border-gray-300 rounded-lg"></textarea>
                    </div>
                    <button type="submit" class="w-full px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">Kirim Pesan</button>
                </form>
            </div>
            <div class="md:w-1/2">
                <div class="bg-white p-8 rounded-xl shadow-lg h-full">
                    <h3 class="text-2xl font-semibold mb-6 text-purple-800">Informasi Kontak</h3>
                    <ul class="space-y-4 text-gray-700">
                        <li><strong>Alamat:</strong> Desa Klepu, Kecamatan Pringapus, Kabupaten Semarang</li>
                        <li><strong>Telepon:</strong> +62 123 4567 890</li>
                        <li><strong>Email:</strong> ppkokamadiksi25@gmail.com</li>
                        <li><strong>Jam Operasional:</strong> Senin - Jumat: 08.00 - 16.00</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
