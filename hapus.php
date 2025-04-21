// hapus.php
<?php
include 'koneksi.php';

$id = $_POST['id'];
$filepath = $_POST['filepath'];
$thumbpath = $_POST['thumbpath'];
$croppath = $_POST['croppath'];

if (file_exists($filepath)) unlink($filepath);
if (file_exists($thumbpath)) unlink($thumbpath);
if (file_exists($croppath)) unlink($croppath);

$sql = "DELETE FROM gambar_produk WHERE id = $id";
$conn->query($sql);

$conn->close();
header("Location: galeri.php");
?>