<?php
session_start();
require_once '../admin/config/koneksi.php';

// 1. Proteksi Session
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login_siswa") {
    header("location:login_siswa.php?pesan=belum_login");
    exit();
}

$id_siswa_login = $_SESSION['id_siswa'];

// 3. Query ambil data siswa
$query_user = mysqli_query($conn, "SELECT nama_siswa FROM siswa WHERE id = '$id_siswa_login'");
$data_user = mysqli_fetch_assoc($query_user);
$nama_siswa = $data_user['nama_siswa'] ?? 'Siswa'; 

// 4. Logika Pencarian
$search = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';

// 5. Query Koleksi Buku
if (!empty($search)) {
    $q_koleksi = mysqli_query($conn, "SELECT * FROM buku WHERE judul LIKE '%$search%' OR penulis LIKE '%$search%' ORDER BY id DESC");
} else {
    $q_koleksi = mysqli_query($conn, "SELECT * FROM buku ORDER BY id DESC");
}

// 6. Hitung Buku Aktif (FIX: Menggunakan status 'Dipinjam')
$q_aktif = mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi WHERE siswa_id = '$id_siswa_login' AND status = 'Dipinjam'");
$data_aktif = mysqli_fetch_assoc($q_aktif);
$jumlah_aktif = (int)($data_aktif['total'] ?? 0);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibSpace | Beranda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary-purple: #6366f1; --bg-soft: #f8f9fa; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-soft); }
        .hero-section { background: linear-gradient(135deg, #a29bfe, #6c5ce7); border-radius: 30px; padding: 40px; color: white; margin-bottom: 40px; position: relative; overflow: hidden; }
        .hero-section::after { content: '\f19d'; font-family: 'Font Awesome 6 Free'; font-weight: 900; position: absolute; right: 40px; bottom: -20px; font-size: 200px; opacity: 0.1; }
        .stat-badge { background: rgba(255, 255, 255, 0.2); border-radius: 15px; padding: 15px 25px; display: inline-flex; align-items: center; gap: 15px; backdrop-filter: blur(10px); }
        .card-buku { border: none; border-radius: 20px; transition: all 0.3s ease; box-shadow: 0 10px 20px rgba(0,0,0,0.05); background: white; overflow: hidden; }
        .card-buku:hover { transform: translateY(-10px); }
        .book-cover-wrapper { background-color: #f1f3ff; height: 250px; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 15px; }
        .book-cover-wrapper img { max-width: 100%; max-height: 100%; object-fit: contain; filter: drop-shadow(0 5px 15px rgba(0,0,0,0.1)); }
        .btn-pinjam { background-color: var(--primary-purple); border: none; color: white; border-radius: 12px; padding: 10px; font-weight: 600; transition: 0.2s; }
        .btn-pinjam:hover { background-color: #4f46e5; transform: scale(1.02); }
        .btn-pinjam:disabled { background-color: #e2e8f0; color: #94a3b8; cursor: not-allowed; }
        .status-tag { position: absolute; top: 15px; left: 15px; padding: 4px 12px; border-radius: 20px; font-size: 0.70rem; font-weight: 700; z-index: 10; }
        .tag-tersedia { background: #dcfce7; color: #166534; }
        .tag-habis { background: #fee2e2; color: #991b1b; }
        .search-container { position: relative; max-width: 300px; }
        .search-container input { border-radius: 20px; padding-left: 35px; border: 1px solid #eee; }
        .search-container i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #aaa; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg py-3 bg-white shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="beranda_siswa.php">LibSpace</a>
        <form action="" method="GET" class="search-container ms-lg-4 d-none d-md-block">
            <i class="fas fa-search"></i>
            <input type="text" name="query" class="form-control" placeholder="Cari judul..." value="<?= htmlspecialchars($search); ?>">
        </form>
        <div class="ms-auto d-flex align-items-center gap-3">
            <a href="beranda_siswa.php" class="text-decoration-none text-primary fw-bold">Beranda</a>
            <a href="riwayat_pinjam.php" class="text-decoration-none text-muted fw-medium">Pinjaman Saya</a>
            <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">Keluar</a>
        </div>
    </div>
</nav>

<div class="container pb-5">
    <div class="hero-section shadow-lg">
        <h1 class="fw-bold mb-2">Halo, <?= htmlspecialchars($nama_siswa); ?>! 👋</h1>
        <p class="mb-4 opacity-75">Temukan berbagai literatur menarik untuk menambah wawasanmu.</p>
        <div class="stat-badge">
            <div class="bg-white text-primary p-2 rounded-3"><i class="fas fa-bookmark"></i></div>
            <div>
                <small class="d-block opacity-75">Buku Dipinjam</small>
                <span class="fw-bold"><?= $jumlah_aktif; ?> Aktif</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <?php if(mysqli_num_rows($q_koleksi) > 0): ?>
            <?php while($buku = mysqli_fetch_assoc($q_koleksi)) : 
                $is_empty = ($buku['stok'] <= 0);
                $cover_path = "../admin/assets/img/cover/" . ($buku['cover'] ?? '');
                $display_img = (!empty($buku['cover']) && file_exists($cover_path)) ? $cover_path : "https://ui-avatars.com/api/?name=" . urlencode($buku['judul']) . "&background=f1f3ff&color=6366f1&size=500";
            ?>
            <div class="col-md-3">
                <div class="card card-buku h-100 position-relative">
                    <span class="status-tag <?= $is_empty ? 'tag-habis' : 'tag-tersedia'; ?>">
                        <?= $is_empty ? 'Habis' : 'Tersedia'; ?>
                    </span>
                    <div class="book-cover-wrapper">
                        <img src="<?= $display_img; ?>" alt="Cover">
                    </div>
                    <div class="p-3">
                        <h6 class="fw-bold mb-1 text-truncate"><?= htmlspecialchars($buku['judul']); ?></h6>
                        <p class="text-muted small mb-3"><?= htmlspecialchars($buku['penulis']); ?></p>
                        <div class="mt-auto text-center">
                            <a href="#" class="text-primary text-decoration-none small d-block mb-3 fw-bold" data-bs-toggle="modal" data-bs-target="#detailModal<?= $buku['id']; ?>">Lihat Detail</a>
                            <button onclick="confirmLoan('<?= addslashes($buku['judul']); ?>', 'proses_pinjam.php?id_buku=<?= $buku['id']; ?>')" class="btn btn-pinjam w-100" <?= $is_empty ? 'disabled' : ''; ?>>
                                <?= $is_empty ? 'Stok Habis' : 'Pinjam'; ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="detailModal<?= $buku['id']; ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 25px; border:none;">
                        <div class="modal-body p-4">
                            <div class="row align-items-center">
                                <div class="col-5">
                                    <img src="<?= $display_img; ?>" class="img-fluid rounded shadow-sm">
                                </div>
                                <div class="col-7">
                                    <h5 class="fw-bold text-primary mb-1"><?= htmlspecialchars($buku['judul']); ?></h5>
                                    <p class="text-muted small mb-1">Penulis: <?= htmlspecialchars($buku['penulis']); ?></p>
                                    <p class="text-muted small mb-1">Penerbit: <?= htmlspecialchars($buku['penerbit']); ?></p>
                                    <p class="text-muted small mb-3">Kategori: <?= htmlspecialchars($buku['kategori']); ?></p>
                                    <span class="badge bg-primary rounded-pill">Stok: <?= $buku['stok']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5 text-muted">Buku tidak ditemukan.</div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmLoan(judul, link) {
        Swal.fire({
            title: 'Pinjam Buku?',
            text: "Konfirmasi pinjam buku '" + judul + "'",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6366f1',
            confirmButtonText: 'Ya, Pinjam',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) window.location.href = link;
        });
    }

    // Alert Sukses
    const urlParams = new URLSearchParams(window.location.search);
    if(urlParams.get('pesan') === 'berhasil') {
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Buku telah dipinjam.', timer: 2000, showConfirmButton: false });
    }
</script>
</body>
</html>