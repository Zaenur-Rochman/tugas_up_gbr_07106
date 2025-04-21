<?php
include 'koneksi.php';
$id_pengguna = 1; // ganti sesuai session
$result = $conn->query("SELECT * FROM profile_pictures WHERE id_pengguna = $id_pengguna ORDER BY id DESC LIMIT 1");
$foto = $result->fetch_assoc();
?>
<h2>Dashboard</h2>
<?php if ($foto): ?>
    <p>Foto Profil:</p>
    <img src="<?= $foto['lokasi_file'] ?>" width="150">
<?php else: ?>
    <p>Belum ada foto profil diunggah.</p>
<?php endif; ?>
