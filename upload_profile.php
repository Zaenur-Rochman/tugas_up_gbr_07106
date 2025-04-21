<?php
session_start();
include 'koneksi.php';
$id_pengguna = $_SESSION['user_id'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gambar = $_FILES['gambar'];
    $ext = strtolower(pathinfo($gambar['name'], PATHINFO_EXTENSION));
    $mime = mime_content_type($gambar['tmp_name']);

    if ($gambar['size'] > 1048576) die("Ukuran max 1MB");
    if (!in_array($ext, ['jpg','jpeg','png']) || !in_array($mime, ['image/jpeg','image/png'])) {
        die("File tidak valid");
    }

    $nama_file = "{$id_pengguna}_" . time() . ".$ext";
    $lokasi = "profile_pics/" . $nama_file;
    move_uploaded_file($gambar['tmp_name'], $lokasi);

    $stmt = $conn->prepare("INSERT INTO profile_pictures (id_pengguna, nama_file, lokasi_file) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $id_pengguna, $nama_file, $lokasi);
    $stmt->execute();
    echo "Upload berhasil!";
}
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="gambar" required>
    <button type="submit">Upload Foto Profil</button>
</form>