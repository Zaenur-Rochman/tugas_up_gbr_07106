<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gambar = $_FILES['gambar'];
    $ext = strtolower(pathinfo($gambar['name'], PATHINFO_EXTENSION));
    $type = mime_content_type($gambar['tmp_name']);

    if ($gambar['size'] > 1048576 || !in_array($ext, ['jpg','jpeg','png'])) die("File tidak valid");

    list($width, $height) = getimagesize($gambar['tmp_name']);
    $filename = time() . ".$ext";
    $path_asli = "uploads/" . $filename;
    move_uploaded_file($gambar['tmp_name'], $path_asli);

    $src = imagecreatefromjpeg($path_asli);
    $resized = imagecreatetruecolor(1024, floor($height * (1024 / $width)));
    imagecopyresampled($resized, $src, 0, 0, 0, 0, 1024, floor($height * (1024 / $width)), $width, $height);
    imagejpeg($resized, $path_asli, 90);

    $thumb = imagecreatetruecolor(150, 150);
    imagecopyresampled($thumb, $src, 0, 0, 0, 0, 150, 150, $width, $height);
    $thumb_path = "uploads/thumbnails/thumb_" . $filename;
    imagejpeg($thumb, $thumb_path, 90);

    $crop = imagecreatetruecolor(300, 300);
    $start_x = ($width - 300) / 2;
    $start_y = ($height - 300) / 2;
    imagecopyresampled($crop, $src, 0, 0, $start_x, $start_y, 300, 300, 300, 300);
    $crop_path = "uploads/crops/crop_" . $filename;
    imagejpeg($crop, $crop_path, 90);

    $stmt = $conn->prepare("INSERT INTO gambar_produk (filename, filepath, thumbpath, croppath, width, height, size) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $size = filesize($path_asli);
    $stmt->bind_param("ssssiii", $filename, $path_asli, $thumb_path, $crop_path, $width, $height, $size);
    $stmt->execute();

    echo "Gambar berhasil di-upload dan diproses.";
}
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="gambar" required>
    <button type="submit">Upload Produk</button>
</form>
