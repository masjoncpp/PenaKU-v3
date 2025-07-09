<?php include 'header.php'; ?>

<!-- Hero Section dengan Background -->
<section id="beranda" class="relative py-20 hero-pattern">
    <div class="absolute inset-0 bg-white bg-opacity-10"></div>
    <div class="relative z-10 container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold mb-6 gradient-text">Pena-Ku</h1>
                <h1 class="text-2xl md:text-3xl font-bold mb-6 gradient-text">Perempuan Naik Kelas Desa Klepu</h1>
                <p class="text-gray-700 text-lg mb-8">Memberdayakan perempuan melalui pendidikan dan keterampilan di Desa Klepu, Kecamatan Pringapus, Kabupaten Semarang, Jawa Tengah.</p>
                <div class="flex space-x-4">
                    <a href="#kelas" class="px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition shadow-lg hover:shadow-xl">Jelajahi Kelas</a>
                    <a href="#profil-desa" class="px-6 py-3 border-2 border-purple-600 text-purple-600 font-medium rounded-lg hover:bg-purple-50 transition">Profil Desa</a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <img src="img/permata.png" alt="Sekolah Permata">
            </div>
        </div>
    </div>
</section>

<?php include 'profil_desa.php'; ?>
<?php include 'lokasi_desa.php'; ?>
<?php include 'kelas.php'; ?>
<?php include 'artikel_view_public.php'; ?>
<?php include 'testimoni.php'; ?>
<?php include 'kontak.php'; ?>

<?php include 'footer.php'; ?>

<script>
// Smooth scroll dan form demo handler
const anchors = document.querySelectorAll('a[href^="#"]');
anchors.forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) target.scrollIntoView({ behavior: 'smooth' });
    });
});
const contactForm = document.querySelector('form');
if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
        e.preventDefault();
        alert('Terima kasih! Pesan Anda telah dikirim. Kami akan segera menghubungi Anda.');
        contactForm.reset();
    });
}
</script>
