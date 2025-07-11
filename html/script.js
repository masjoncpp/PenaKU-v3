// Smooth scrolling for anchor links (kode ini tetap ada)
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// --- MULAI KODE BARU UNTUK FORM ---
const contactForm = document.querySelector('#kontak form');
if (contactForm) {
  // GANTI URL DI BAWAH INI DENGAN URL WEB APP ANDA
  const scriptURL = 'https://script.google.com/macros/s/AKfycbydtersnTGQjoTDxxj_hL0iU5yfygGLj2Qt9SEYRsDZSA9ZEw1FKY6ekrT0dvkflxY2/exec';

  contactForm.addEventListener('submit', e => {
    e.preventDefault();
    const submitButton = contactForm.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.textContent = 'Mengirim...';

    fetch(scriptURL, { method: 'POST', body: new FormData(contactForm) })
      .then(response => {
        console.log('Success!', response);
        alert('Terima kasih! Pesan Anda telah berhasil dikirim.');
        submitButton.disabled = false;
        submitButton.textContent = 'Kirim Pesan';
        contactForm.reset();
      })
      .catch(error => {
        console.error('Error!', error.message);
        alert('Maaf, terjadi kesalahan. Silakan coba lagi.');
        submitButton.disabled = false;
        submitButton.textContent = 'Kirim Pesan';
      });
  });
}
// --- AKHIR KODE BARU UNTUK FORM ---