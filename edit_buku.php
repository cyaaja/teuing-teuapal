<?php
session_start();
if (!isset($_SESSION["status"])) {
    header("Location: login.php");
    exit();
}

require_once 'config/koneksi.php';

// 1. Pastikan ID ada di URL dan amankan dari SQL Injection
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: buku.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// 2. Perbaikan Query: Menggunakan kolom 'id' sesuai screenshot phpMyAdmin
$query = mysqli_query($conn, "SELECT * FROM buku WHERE id = '$id'");

// 3. Jika data tidak ditemukan
if (mysqli_num_rows($query) < 1) {
    die("Data tidak ditemukan di database untuk ID: " . htmlspecialchars($id));
}

$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Buku | E-Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7f6; padding: 40px; }
        .form-card { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); max-width: 600px; margin: auto; }
        .btn-update { background-color: #6b4f3b; color: white; border: none; border-radius: 8px; padding: 10px 20px; transition: 0.3s; }
        .btn-update:hover { background-color: #4b3621; color: white; transform: translateY(-2px); }
        .form-control:focus { border-color: #6b4f3b; box-shadow: 0 0 0 0.25 cereal rgba(107, 79, 59, 0.25); }
    </style>
</head>
<body>

<div class="form-card">
    <h4 class="fw-bold mb-4 text-center">Edit Data Buku</h4>
    
    <form action="proses_edit.php" method="POST">
        <input type="hidden" name="id_buku" value="<?= $data['id']; ?>">

        <div class="mb-3">
            <label class="form-label">Judul Buku</label>
            <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($data['judul']); ?>" required>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Penulis</label>
                <input type="text" name="penulis" class="form-control" value="<?= htmlspecialchars($data['penulis']); ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Penerbit</label>
                <input type="text" name="penerbit" class="form-control" value="<?= htmlspecialchars($data['penerbit']); ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" class="form-control" value="<?= $data['tahun_terbit']; ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" value="<?= $data['stok']; ?>" required>
            </div>
        </div>
        
        <hr class="my-4">
        <div class="d-flex justify-content-between">
            <a href="buku.php" class="btn btn-outline-secondary px-4">Batal</a>
            <button type="submit" name="update" class="btn btn-update px-4">Simpan Perubahan</button>
        </div>
    </form>
</div>

</body>
</html>