<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Galeri Gambar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
  <h2 class="text-center mb-4">Galeri Gambar</h2>
  <div class="row g-4">
    <?php
    $result = $conn->query("SELECT * FROM gambar_produk ORDER BY uploaded_at DESC");
    while($row = $result->fetch_assoc()): ?>
      <div class="col-md-3">
        <div class="card">
          <img src="<?= $row['thumbpath'] ?>" class="card-img-top">
          <div class="card-body">
            <p><strong>Ukuran:</strong> <?= $row['width'] ?>x<?= $row['height'] ?></p>
            <a href="<?= $row['filepath'] ?>" target="_blank" class="btn btn-sm btn-primary">Lihat Asli</a>
            <form action="hapus.php" method="POST" class="mt-2" onsubmit="return confirm('Yakin?')">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <input type="hidden" name="filepath" value="<?= $row['filepath'] ?>">
              <input type="hidden" name="thumbpath" value="<?= $row['thumbpath'] ?>">
              <input type="hidden" name="croppath" value="<?= $row['croppath'] ?>">
              <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
            </form>
          </div>
        </div>
      </div>
    <?php endwhile; $conn->close(); ?>
  </div>
</div>
</body>
</html>
