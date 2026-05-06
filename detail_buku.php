<?php
session_start();
// Proteksi halaman: pastikan hanya siswa yang sudah login yang bisa akses
if (!isset($_SESSION["status"]) || $_SESSION['status'] != "login_siswa") {
    header("Location: login_siswa.php");
    exit();
}

require_once '../admin/config/koneksi.php';

// Ambil ID buku dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: beranda_siswa.php");
    exit();
}

$id_buku = mysqli_real_escape_string($conn, $_GET['id']);

// Query ambil data buku dan kategorinya (jika ada relasi ke tabel kategori)
$query = mysqli_query($conn, "SELECT buku.*, kategori.nama_kategori 
                              FROM buku 
                              LEFT JOIN kategori ON buku.kategori_id = kategori.id 
                              WHERE buku.id = '$id_buku'");
$data = mysqli_fetch_assoc($query);

// Jika buku tidak ditemukan di database
if (!$data) {
    echo "<script>alert('Data buku tidak ditemukan!'); window.location='beranda_siswa.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku | E-Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7f6; }
        .navbar { background-color: #5d4037 !important; }
        .detail-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-top: 30px;
            border: none;
        }
        .book-cover-section {
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px;
            border-right: 1px solid #eee;
        }
        .book-icon { font-size: 150px; color: #5d4037; }
        .info-label { color: #888; font-size: 0.9rem; margin-bottom: 2px; }
        .info-value { color: #333; font-weight: 600; margin-bottom: 20px; font-size: 1.1rem; }
        .badge-status { padding: 8px 20px; border-radius: 50px; font-weight: 500; }
        .btn-back { color: #5d4037; text-decoration: none; font-weight: 500; }
        .btn-back:hover { color: #3e2723; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="beranda_siswa.php"><i class="fas fa-book-reader me-2"></i>E-LIBRARY</a>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="mt-4">
            <a href="beranda_siswa.php" class="btn-back"><i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda</a>
        </div>

        <div class="card detail-card">
            <div class="row g-0">
                <div class="col-md-4 book-cover-section">
                    <div class="text-center">
                        <i class="fas fa-book book-icon"></i>
                        <div class="mt-4">
                            <?php if($data['stok'] > 0): ?>
                                <span class="badge bg-success badge-status">Tersedia: <?php echo $data['stok']; ?> Eks</span>
                            <?php else: ?>
                                <span class="badge bg-danger badge-status">Stok Habis</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 p-5">
                    <h6 class="text-uppercase text-muted fw-bold mb-1" style="letter-spacing: 1px;">Detail Informasi Buku</h6>
                    <h2 class="fw-bold mb-4" style="color: #5d4037;"><?php echo $data['judul']; ?></h2>
                    
                    <hr class="mb-4">

                    <div class="row">
                        <div class="col-md-6">
                            <p class="info-label">Penulis</p>
                            <p class="info-value"><?php echo $data['penulis']; ?></p>

                            <p class="info-label">Penerbit</p>
                            <p class="info-value"><?php echo $data['penerbit']; ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="info-label">Tahun Terbit</p>
                            <p class="info-value"><?php echo $data['tahun_terbit']; ?></p>

                            <p class="info-label">Kategori</p>
                            <p class="info-value"><?php echo ($data['nama_kategori']) ? $data['nama_kategori'] : '-'; ?></p>
                        </div>
                    </div>

                    <div class="mt-4 p-4 rounded-3" style="background-color: #fff9f4; border-left: 5px solid #5d4037;">
                        <h6 class="fw-bold"><i class="fas fa-info-circle me-2"></i>Catatan Peminjaman</h6>
                        <small class="text-muted d-block">Untuk meminjam buku ini, silakan hubungi petugas perpustakaan di meja layanan dengan membawa Kartu Siswa dan menyebutkan Judul Buku.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>