<?php
session_start();
require_once '../admin/config/koneksi.php';

// Proteksi Session
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login_siswa") {
    header("location:login_siswa.php?pesan=belum_login");
    exit();
}

$id_siswa_login = $_SESSION['id_siswa'];

// Query mengambil data terbaru
$query = mysqli_query($conn, "SELECT t.*, b.judul, b.penulis, b.cover 
                               FROM transaksi t
                               JOIN buku b ON t.buku_id = b.id 
                               WHERE t.siswa_id = '$id_siswa_login' 
                               ORDER BY t.id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pinjaman Saya | LibSpace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root { --primary: #6366f1; --bg: #f8fafc; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg); color: #1e293b; }
        .navbar { background: white !important; border-bottom: 1px solid rgba(0,0,0,0.05); }
        .navbar-brand { color: var(--primary) !important; font-weight: 700; font-size: 1.5rem; }
        .nav-link { color: #64748b !important; font-weight: 600; }
        .nav-link.active { color: var(--primary) !important; }
        .btn-primary:active {
    transform: scale(0.97);
    transition: 0.1s;
}
        .section-card { background: white; border-radius: 24px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); }
        .card-history { border: 1px solid #f1f5f9; border-radius: 20px; padding: 20px; transition: 0.3s; background: #fff; height: 100%; position: relative; overflow: hidden; }
        .status-badge { font-size: 0.75rem; padding: 6px 15px; border-radius: 50px; font-weight: 700; z-index: 2; }
        .cover-wrapper { width: 60px; height: 85px; border-radius: 8px; overflow: hidden; background: #eee; flex-shrink: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .cover-wrapper img { width: 100%; height: 100%; object-fit: cover; }
        .icon-box { width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="beranda_siswa.php"><i class="fas fa-book-reader me-2"></i>LibSpace</a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <a href="beranda_siswa.php" class="nav-link">Beranda</a>
            <a href="riwayat_pinjam.php" class="nav-link active">Pinjaman Saya</a>
            <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-4 ms-2">Keluar</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="mb-4">
        <h3 class="fw-bold m-0">Pinjaman Saya</h3>
        <p class="text-muted m-0">Kelola pengembalian buku Anda di sini.</p>
    </div>

    <div class="section-card">
        <div class="row g-4">
            <?php if(mysqli_num_rows($query) > 0): ?>
                <?php while($data = mysqli_fetch_array($query)): 
                    // FIX LOGIKA: Jika status NULL/Kosong dianggap 'pinjam' agar tombol muncul
                    $status_db = strtolower($data['status']);
                    $is_pinjam = (empty($status_db) || $status_db == 'pinjam' || $status_db == 'dipinjam');
                    
                    $tgl_pinjam_raw = $data['tgl_pinjam'];
                    $tgl_pinjam_view = date('d M Y', strtotime($tgl_pinjam_raw));
                    
                    if($is_pinjam) {
                        // Jika pinjam, tampilkan estimasi Batas Kembali (Tgl Pinjam + 3 hari)
                        $tgl_kembali_view = date('d M Y', strtotime('+3 days', strtotime($tgl_pinjam_raw)));
                        $label_kembali = "Batas Kembali";
                        $badge_status = "bg-warning-subtle text-warning";
                        $status_text = "Sedang Dipinjam";
                    } else {
                        // Jika sudah kembali, tampilkan tanggal asli dari database
                        $tgl_kembali_view = date('d M Y', strtotime($data['tgl_kembali']));
                        $label_kembali = "Dikembalikan";
                        $badge_status = "bg-success-subtle text-success";
                        $status_text = "Sudah Kembali";
                    }
                ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card-history d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex gap-3">
                                    <div class="cover-wrapper">
                                        <?php if(!empty($data['cover'])): ?>
                                            <img src="../admin/assets/img/cover/<?php echo $data['cover']; ?>" alt="Cover">
                                        <?php else: ?>
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-secondary-subtle">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="icon-box bg-primary-subtle text-primary">
                                        <i class="fas fa-book"></i>
                                    </div>
                                </div>
                                <span class="status-badge <?php echo $badge_status; ?>">
                                    <?php echo $status_text; ?>
                                </span>
                            </div>
                            
                            <h6 class="fw-bold mb-1 text-truncate"><?php echo $data['judul']; ?></h6>
                            <p class="text-muted small mb-3"><?php echo $data['penulis']; ?></p>
                            
                            <div class="bg-light rounded-4 p-3 mb-3 mt-auto">
                                <div class="d-flex justify-content-between mb-2">
                                    <small class="text-muted small">Pinjam</small>
                                    <span class="fw-bold small"><?php echo $tgl_pinjam_view; ?></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted small"><?php echo $label_kembali; ?></small>
                                    <span class="fw-bold small <?php echo $is_pinjam ? 'text-primary' : 'text-success'; ?>">
                                        <?php echo $tgl_kembali_view; ?>
                                    </span>
                                </div>
                            </div>

                            <?php if($is_pinjam): ?>
                            <button 
                             class="btn btn-primary w-100 rounded-pill btn-sm fw-bold py-2"
                             onclick="konfirmasiKembali(<?php echo $data['id']; ?>)">
                              Kembalikan Buku
                            </button>
                            <?php else: ?>
                                <button class="btn btn-light text-success w-100 rounded-pill btn-sm fw-bold py-2 disabled" style="opacity: 1;">
                                    <i class="fas fa-check-circle me-1"></i> Terimakasih!
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada data peminjaman.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
function konfirmasiKembali(id) {
    Swal.fire({
        title: 'Kembalikan Buku?',
        text: "Pastikan buku sudah siap dikembalikan 📚",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#6366f1',
        cancelButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Kembalikan!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        focusCancel: true,
        backdrop: `
            rgba(0,0,0,0.4)
            blur(4px)
        `,
        customClass: {
            popup: 'rounded-4 shadow-lg'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // redirect tetap sama → TIDAK MERUBAH LOGIC
            window.location.href = "kembali_buku.php?id_transaksi=" + id;
        }
    });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>