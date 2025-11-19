document.addEventListener('DOMContentLoaded', () => {
  const endpoint = 'donasi.php';
  const donateBtn = document.getElementById('donateBtn');
  const donateBtn2 = document.getElementById('donateBtn2');
  const form = document.getElementById('formDonasi');

  const donasiModal = new bootstrap.Modal(document.getElementById('donasiModal'));
  const qrisModal = new bootstrap.Modal(document.getElementById('qrisModal'));

  donateBtn?.addEventListener('click', () => donasiModal.show());
  donateBtn2?.addEventListener('click', () => donasiModal.show());

  form.addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    fetch(endpoint, {
      method: 'POST',
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        console.log('Response server:', data);

        if (data.status === 'success') {
          donasiModal.hide(); // tutup form
          qrisModal.show(); // tampil QRIS

          // tampil QRIS selama 5 detik
          setTimeout(() => {
            // Update status pembayaran di server
            const updateData = new FormData();
            updateData.append('action', 'update_status');
            updateData.append('donasi_id', data.donasi_id); // pastikan server kirim ID donasi

            fetch(endpoint, {
              method: 'POST',
              body: updateData,
            })
              .then((res) => res.json())
              .then((resp) => {
                if (resp.status === 'success') {
                  qrisModal.hide();
                  alert('Pembayaran berhasil diverifikasi!');
                  location.reload();
                } else {
                  alert('Gagal update status pembayaran!');
                  console.error(resp);
                }
              });
          }, 5000); // 5 detik QRIS
        } else {
          alert('Gagal mengirim donasi! Lihat console');
          console.error(data);
        }
      })
      .catch((err) => {
        alert('Error server! Lihat console');
        console.error(err);
      });
  });
});
