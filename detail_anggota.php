<?php
session_start();
if (!isset($_SESSION["status"])) {
    header("Location: login.php");
    exit();
}

require_once '../koneksi.php';

// Ambil ID dari URL
if (!isset($_GET['id'])) {
    header("Location: anggota.php");
    exit();
}

$id = $_GET['id'];

// Query ambil data spesifik anggota
$query = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_anggota = '$id'");
$data  = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='anggota.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Anggota | E-Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
        .card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .detail-label { color: #6c757d; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; }
        .detail-value { font-size: 1.1rem; color: #2c2119; font-weight: 500; }
        .avatar-circle {
            width: 100px; height: 100px;
            background-color: #dcbfa6; color: #2c2119;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem; font-weight: bold; border-radius: 50%;
            margin: 0 auto 20px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <div class="text-center border-bottom pb-4 mb-4">
                    <div class="avatar-circle">
                        <?= strtoupper(substr($data['nama'], 0, 1)); ?>
                    </div>
                    <h4 class="fw-bold mb-0"><?= $data['nama']; ?></h4>
                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 mt-2">ID: <?= $data['id_anggota']; ?></span>
                </div>

                <div class="row g-4">
                    <div class="col-6">
                        <label class="detail-label">Jurusan / Kelas</label>
                        <div class="detail-value"><?= $data['kelas']; ?></div>
                    </div>
                    <div class="col-6">
                        <label class="detail-label">No. Telepon</label>
                        <div class="detail-value"><?= !empty($data['no_hp']) ? $data['no_hp'] : '-'; ?></div>
                    </div>
                    <div class="col-12">
                        <label class="detail-label">Alamat Lengkap</label>
                        <div class="detail-value"><?= $data['alamat']; ?></div>
                    </div>
                    <div class="col-12">
                        <label class="detail-label">Terdaftar Pada</label>
                        <div class="detail-value"><?= date('d F Y', strtotime($data['created_at'])); ?></div>
                    </div>
                </div>

                <div class="mt-5 d-flex gap-2">
                    <a href="anggota.php" class="btn btn-light rounded-pill px-4 flex-grow-1">Kembali</a>
                    <a href="edit_anggota.php?id=<?= $data['id_anggota']; ?>" class="btn btn-warning rounded-pill px-4 flex-grow-1">Edit Data</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>