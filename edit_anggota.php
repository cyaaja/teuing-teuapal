<?php
session_start();
if (!isset($_SESSION["status"])) {
    header("Location: login.php");
    exit();
}

// 1. Hubungkan ke database
require_once 'config/koneksi.php'; 

// 2. Ambil ID dari URL
$id = $_GET['id'];

// 3. PERBAIKAN: Gunakan $conn (sesuai koneksi.php) dan tabel siswa
$query = mysqli_query($conn, "SELECT * FROM siswa WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    header("Location: anggota.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id" data-bs-theme="light" id="htmlPage">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota | E-Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root { --sidebar-bg: #2c2119; --accent: #dcbfa6; }
        body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
        
        .sidebar { height: 100vh; width: 260px; position: fixed; background: var(--sidebar-bg); color: white; padding-top: 20px; z-index: 1000; }
        .sidebar .brand { padding: 10px 25px 30px; font-size: 1.5rem; font-weight: 700; color: var(--accent); }
        .nav-link { color: #bdc3c7 !important; padding: 12px 25px; margin: 4px 15px; border-radius: 12px; display: flex; align-items: center; }
        .nav-link.active { background-color: rgba(220, 191, 166, 0.15); border-left: 4px solid var(--accent); color: white !important; }
        
        .main-content { margin-left: 260px; padding: 30px; }
        .card-edit { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); max-width: 600px; margin: auto; }
        .btn-update { background: linear-gradient(135deg, #6b4f3b, #a67c52); color: white; border: none; font-weight: 600; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="brand"><i class="fas fa-book-open me-2"></i> E-LIBRARY</div>
    <nav class="nav flex-column">
        <a class="nav-link" href="beranda.php"><i class="fas fa-th-large me-2"></i> <span>Dashboard</span></a>
        <a class="nav-link" href="buku.php"><i class="fas fa-book me-2"></i> <span>Data Buku</span></a>
        <a class="nav-link active" href="anggota.php"><i class="fas fa-users me-2"></i> <span>Anggota</span></a>
        <a class="nav-link" href="peminjaman.php"><i class="fas fa-exchange-alt me-2"></i> <span>Peminjaman</span></a>
        <hr class="mx-3 my-4 opacity-25">
        <a class="nav-link text-danger" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i> <span>Keluar</span></a>
    </nav>
</div>

<div class="main-content">
    <div class="mb-4">
        <a href="anggota.php" class="text-decoration-none text-muted"><i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Anggota</a>
    </div>

    <div class="card card-edit">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h4 class="fw-bold m-0">Edit Data Anggota</h4>
            <p class="text-muted small">Perbarui informasi siswa di bawah ini.</p>
        </div>
        <div class="card-body p-4">
            <form action="proses_edit_anggota.php" method="POST">
                <input type="hidden" name="id" value="<?= $data['id']; ?>">

                <div class="mb-3">
                    <label class="form-label fw-semibold">NIS</label>
                    <input type="text" name="nis" class="form-control rounded-3" value="<?= $data['nis']; ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="nama_siswa" class="form-control rounded-3" value="<?= $data['nama_siswa']; ?>" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-semibold">Kelas</label>
                    <input type="text" name="kelas" class="form-control rounded-3" value="<?= $data['kelas']; ?>" required>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" name="update" class="btn btn-update py-3 rounded-3 shadow-sm">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>