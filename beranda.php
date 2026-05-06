<?php
session_start();

// 1. Proteksi Halaman
if (!isset($_SESSION["status"])) {
    header("Location: login.php"); 
    exit();
}

// 2. Koneksi Database
require_once 'config/koneksi.php'; 

// Ambil data session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin';
$role     = isset($_SESSION['role']) ? $_SESSION['role'] : 'Petugas';

// --- FIX: AMBIL DATA FOTO PROFIL DARI TABEL ADMIN ---
$q_profil = mysqli_query($conn, "SELECT foto FROM admin WHERE username = '$username'");
$d_profil = mysqli_fetch_assoc($q_profil);
$foto_db = $d_profil['foto'] ?? '';
$path_foto = 'uploads/profile/' . $foto_db;

// Logika penentuan foto yang tampil
if (!empty($foto_db) && file_exists($path_foto)) {
    $foto_tampil = $path_foto;
} else {
    $foto_tampil = "https://ui-avatars.com/api/?name=" . urlencode($username) . "&background=e2c7b0&color=1a1612";
}

// --- AMBIL STATISTIK REAL-TIME ---

// 1. Total Koleksi Buku
$q_buku = mysqli_query($conn, "SELECT COUNT(*) as total FROM buku");
$total_buku = ($q_buku) ? mysqli_fetch_assoc($q_buku)['total'] : 0;

// 2. Total Anggota
$q_anggota = mysqli_query($conn, "SELECT COUNT(*) as total FROM siswa");
$total_anggota = ($q_anggota) ? mysqli_fetch_assoc($q_anggota)['total'] : 0;

// 3. Pinjaman Hari Ini
$q_pinjam = mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi WHERE DATE(tgl_pinjam) = CURDATE()");
$total_pinjam = ($q_pinjam) ? mysqli_fetch_assoc($q_pinjam)['total'] : 0;

// 4. --- LOGIKA ESTIMASI KAS DENDA ---
$tarif_denda   = 1000; 
$durasi_pinjam = 3; 

$q_denda = mysqli_query($conn, "SELECT SUM((DATEDIFF(CURDATE(), tgl_pinjam) - $durasi_pinjam) * $tarif_denda) as total_estimasi 
                                FROM transaksi 
                                WHERE status = 'dipinjam' 
                                AND DATEDIFF(CURDATE(), tgl_pinjam) > $durasi_pinjam");

$res_denda = mysqli_fetch_assoc($q_denda);
$total_estimasi_denda = $res_denda['total_estimasi'] ?? 0;

// 5. Query Peminjaman Terbaru
$sql_terbaru = "SELECT t.*, s.nama_siswa, b.judul 
                FROM transaksi t 
                LEFT JOIN siswa s ON t.siswa_id = s.id 
                LEFT JOIN buku b ON t.buku_id = b.id 
                ORDER BY t.id DESC LIMIT 5";    

$q_terbaru = mysqli_query($conn, $sql_terbaru);

if (!$q_terbaru) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Premium Dashboard | E-Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #fcfaf8; 
            color: #2c2119;
        }
        .main-content { margin-left: 280px; padding: 40px; transition: 0.3s; }
        .fw-800 { font-weight: 800; }
        .fw-600 { font-weight: 600; }
        .fw-500 { font-weight: 500; }
        
        /* Glass Cards */
        .stat-card {
            border: none;
            border-radius: 24px;
            padding: 30px;
            background: #fff;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.02);
        }
        .stat-card:hover { transform: translateY(-10px); box-shadow: 0 20px 50px rgba(0,0,0,0.08); }
        
        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .bg-soft-brown { background: #f4eee9; color: #6b4f3b; }
        .bg-soft-blue { background: #eef2f7; color: #2c3e50; }
        .bg-soft-green { background: #e9f7ef; color: #11998e; }

        .top-navbar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 15px 30px;
            margin-bottom: 40px;
            border: 1px solid rgba(0,0,0,0.05);
        }

        /* Profile Interaction */
        .profile-dropdown {
            cursor: pointer;
            padding: 5px 15px;
            border-radius: 15px;
            transition: 0.3s;
        }
        .profile-dropdown:hover { background: #f4eee9; }
        .dropdown-toggle::after { display: none; }
        .dropdown-menu {
            border: none;
            border-radius: 18px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            padding: 10px;
            margin-top: 10px !important;
        }
        .dropdown-item {
            border-radius: 10px;
            padding: 10px 15px;
            font-weight: 600;
            font-size: 0.9rem;
            color: #2c2119;
        }
        .dropdown-item i { margin-right: 10px; width: 20px; text-align: center; }
        .dropdown-item:hover { background: #f4eee9; color: #6b4f3b; }

        /* Style agar foto profil tetap rapi di dashboard */
        .img-profile-nav {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border-radius: 50%;
        }

        .table-premium {
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
        }
        .table thead th {
            padding: 20px;
            background: #f8f9fa;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            color: #a0a0a0;
        }
        .btn-view-all {
            background: #2c2119;
            color: #fff;
            border-radius: 12px;
            padding: 8px 20px;
            font-weight: 600;
            border: none;
        }
        .btn-view-all:hover { background: #e2c7b0; color: #2c2119; }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="top-navbar d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-800">Sistem Informasi Perpustakaan</h5>
        </div>
        
        <div class="dropdown">
            <div class="profile-dropdown d-flex align-items-center gap-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="text-end d-none d-md-block">
                    <p class="mb-0 fw-bold"><?= $username ?></p>
                    <span class="badge bg-soft-brown"><?= $role ?></span>
                </div>
                <img src="<?= $foto_tampil ?>" class="img-profile-nav">
            </div>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                <li><h6 class="dropdown-header small text-muted">Akses: <?= $role ?></h6></li>
                <li><a class="dropdown-item" href="pengaturan.php"><i class="fas fa-user-cog"></i> Edit Profil</a></li>
                <li><a class="dropdown-item" href="bantuan.php"><i class="fas fa-question-circle"></i> Bantuan</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar?')"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
            </ul>
        </div>
    </div>

    <div class="mb-5">
        <h1 class="fw-800" style="letter-spacing: -1px;">Selamat Datang, <?= ucwords($username) ?>!</h1>
        <p class="text-muted">Berikut adalah ringkasan data perpustakaan Anda hari ini.</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon-box bg-soft-brown"><i class="fas fa-book"></i></div>
                <p class="text-muted mb-1 fw-600">Total Koleksi Buku</p>
                <h2 class="fw-800 mb-0"><?= number_format($total_buku) ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon-box bg-soft-blue"><i class="fas fa-users"></i></div>
                <p class="text-muted mb-1 fw-600">Anggota Terdaftar</p>
                <h2 class="fw-800 mb-0"><?= number_format($total_anggota) ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon-box bg-soft-green"><i class="fas fa-calendar-check"></i></div>
                <p class="text-muted mb-1 fw-600">Pinjaman Baru</p>
                <h2 class="fw-800 mb-0"><?= number_format($total_pinjam) ?></h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="table-premium">
                <div class="p-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-800 m-0">Aktivitas Terbaru</h5>
                    <a href="peminjaman.php" class="btn btn-view-all btn-sm">Semua Aktivitas</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Siswa</th>
                                <th>Judul Buku</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($q_terbaru)): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold"><?= $row['nama_siswa'] ?></div>
                                    <small class="text-muted"><?= date('d M Y', strtotime($row['tgl_pinjam'])) ?></small>
                                </td>
                                <td class="text-muted fw-500"><?= $row['judul'] ?></td>
                                <td>
                                    <?php if($row['status'] == 'kembali'): ?>
                                        <span class="badge rounded-pill bg-success-subtle text-success px-3">Dikembalikan</span>
                                    <?php else: ?>
                                        <span class="badge rounded-pill bg-warning-subtle text-warning px-3">Dipinjam</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="stat-card bg-dark text-white mb-4">
                <p class="text-muted mb-2 small fw-bold">ESTIMASI KAS DENDA</p>
                <h3 class="text-warning fw-800 mb-0">Rp <?= number_format($total_estimasi_denda, 0, ',', '.') ?></h3>
            </div>
            <div class="stat-card">
                <h6 class="fw-800 mb-3 text-uppercase small">Pusat Informasi</h6>
                <div class="d-flex gap-3 mb-3">
                    <i class="fas fa-info-circle text-primary"></i>
                    <small class="text-muted">Maksimal peminjaman 3 hari kerja.</small>
                </div>
                <div class="d-flex gap-3">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    <small class="text-muted">Denda keterlambatan Rp 1.000 per hari.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>