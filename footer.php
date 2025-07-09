<footer class="gradient-bg py-10">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-6 md:mb-0">
                <h3 class="text-2xl font-bold text-white mb-2">PPKO KAMADIKSI UDINUS</h3>
                <p class="text-purple-100">Sekolah Perempuan untuk Indonesia Lebih Baik</p>
            </div>
            <div class="flex flex-wrap justify-center gap-8">
                <div>
                    <h4 class="text-white font-semibold mb-3">Navigasi</h4>
                    <ul class="space-y-2">
                        <li><a href="#beranda" class="text-purple-100 hover:text-white transition">Beranda</a></li>
                        <li><a href="#profil-desa" class="text-purple-100 hover:text-white transition">Profil Desa</a></li>
                        <li><a href="#lokasi-desa" class="text-purple-100 hover:text-white transition">Lokasi</a></li>
                        <li><a href="#kelas" class="text-purple-100 hover:text-white transition">Kelas</a></li>
                        <li><a href="#pojok-literasi" class="text-purple-100 hover:text-white transition">Pojok Literasi</a></li>
                        <li><a href="#kontak" class="text-purple-100 hover:text-white transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3">Program</h4>
                    <ul class="space-y-2">
                        <li><a href="kelas-ibu-cakap-usaha.html" class="text-purple-100 hover:text-white transition">Ibu Cakap Usaha</a></li>
                        <li><a href="kelas-ibu-rawat-bumi.html" class="text-purple-100 hover:text-white transition">Ibu Rawat Bumi</a></li>
                        <li><a href="kelas-ibu-sejahtera.html" class="text-purple-100 hover:text-white transition">Ibu Sejahtera</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border-t border-purple-400 mt-8 pt-8 text-center">
            <p class="text-purple-100">© 2025 PPKO KAMADIKSI UDINUS. Hak Cipta Dilindungi.</p>
        </div>
    </div>
</footer>

<script>
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Form submission handling (demo only)
    const contactForm = document.querySelector('form');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();
            alert('Terima kasih! Pesan Anda telah dikirim. Kami akan segera menghubungi Anda.');
            contactForm.reset();
        });
    }
</script>
</body>
</html>