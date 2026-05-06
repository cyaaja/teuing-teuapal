<?php
session_start();
require_once '../admin/config/koneksi.php';

// 1. Proteksi Session
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login_siswa") {
    header("location:login_siswa.php?pesan=belum_login");
    exit();
}

$id_siswa_login = $_SESSION['id_siswa'];

// 2. Query Ambil Data Buku
$query_buku = mysqli_query($conn, "SELECT * FROM buku ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku | LibSpace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root { --primary: #6366f1; --bg: #f8fafc; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg); color: #1e293b; }
        
        /* Navbar Sinkron */
        .navbar { background: rgba(255, 255, 255, 0.8) !important; backdrop-filter: blur(10px); border-bottom: 1px solid rgba(0,0,0,0.05); }
        .navbar-brand { color: var(--primary) !important; font-weight: 700; font-size: 1.5rem; }
        .nav-link { color: #64748b !important; font-weight: 600; }
        .nav-link.active { color: var(--primary) !important; }

        /* Card Buku Style */
        .book-card { 
            background: white; border-radius: 24px; border: none; padding: 25px; 
            transition: 0.3s; height: 100%; box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            display: flex; flex-direction: column; align-items: center; text-align: center;
        }
        .book-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(99, 102, 241, 0.1); }
        
        .book-icon-wrapper {
            width: 80px; height: 80px; background: #eeefff; border-radius: 20px;
            display: flex; align-items: center; justify-content: center; margin-bottom: 20px;
        }
        .book-icon-wrapper i { color: var(--primary); font-size: 2rem; }

        .badge-status { font-size: 0.7rem; padding: 5px 12px; border-radius: 50px; margin-bottom: 10px; }
        
        .btn-pinjam { 
            background: var(--primary); border: none; border-radius: 12px; 
            padding: 10px; font-weight: 600; transition: 0.3s;
        }
        .btn-pinjam:hover { background: #4f46e5; transform: scale(1.02); }
        .btn-detail { border-radius: 12px; font-weight: 600; color: var(--primary); border: 1px solid var(--primary); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="beranda_siswa.php"><i class="fas fa-book-reader me-2"></i>LibSpace</a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <a href="beranda_siswa.php" class="nav-link">Beranda</a>
            <a href="daftar_buku.php" class="nav-link active">Daftar Buku</a>
            <a href="riwayat_pinjam.php" class="nav-link">Pinjaman Saya</a>
            <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-4 ms-2">Keluar</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Koleksi Buku</h2>
        <p class="text-muted">Temukan berbagai literatur menarik untuk menambah wawasanmu.</p>
    </div>

    <div class="row g-4">
        <?php while($buku = mysqli_fetch_array($query_buku)): ?>
        <div class="col-md-4 col-sm-6">
            <div class="book-card">
                <span class="badge-status <?php echo ($buku['stok'] > 0) ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'; ?>">
                    <?php echo ($buku['stok'] > 0) ? 'Tersedia' : 'Habis'; ?>
                </span>

                <div class="book-icon-wrapper">
                    <i class="fas fa-book"></i>
                </div>

                <h5 class="fw-bold mb-1"><?php echo $buku['judul']; ?></h5>
                <p class="text-muted small mb-4">Penulis: <?php echo $buku['penulis']; ?></p>

                <div class="w-100 d-grid gap-2">
                    <button class="btn btn-detail w-100" data-bs-toggle="modal" data-bs-target="#detail<?php echo $buku['id']; ?>">Detail</button>
                    
                    <?php if($buku['stok'] > 0): ?>
                        <a href="proses_pinjam.php?id_buku=<?php echo $buku['id']; ?>" 
                           class="btn btn-pinjam btn-primary w-100" 
                           onclick="return confirm('Pinjam buku <?php echo $buku['judul']; ?>?')">
                           Pinjam
                        </a>
                    <?php else: ?>
                        <button class="btn btn-secondary w-100 disabled" style="border-radius: 12px;">Stok Habis</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="modal fade" id="detail<?php echo $buku['id']; ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0" style="border-radius: 25px;">
                    <div class="modal-body p-4 text-center">
                        <div class="book-icon-wrapper mx-auto">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h4 class="fw-bold"><?php echo $buku['judul']; ?></h4>
                        <p class="text-muted mb-4">Informasi lengkap mengenai buku ini.</p>
                        
                        <div class="text-start bg-light p-3 rounded-4 mb-4">
                            <div class="row mb-2">
                                <div class="col-5 text-muted small">Penulis</div>
                                <div class="col-7 fw-bold small"><?php echo $buku['penulis']; ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 text-muted small">Penerbit</div>
                                <div class="col-7 fw-bold small"><?php echo $buku['penerbit']; ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 text-muted small">Tahun Terbit</div>
                                <div class="col-7 fw-bold small"><?php echo $buku['tahun_terbit']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-5 text-muted small">Sisa Stok</div>
                                <div class="col-7 fw-bold small"><?php echo $buku['stok']; ?> unit</div>
                            </div>
                        </div>
                        <button class="btn btn-secondary w-100 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>