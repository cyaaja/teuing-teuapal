<?php
session_start();
if (!isset($_SESSION["status"])) {
    header("Location: login.php"); 
    exit();
}

require_once 'config/koneksi.php'; 

$username = $_SESSION['username'] ?? 'Admin';
$role     = $_SESSION['role'] ?? 'Petugas';

// Fitur Pencarian
$keyword = "";
$condition = "";
if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $condition = " WHERE s.nama_siswa LIKE '%$keyword%' OR b.judul LIKE '%$keyword%' ";
}

// Query Ambil Data Tabel Peminjaman (JOIN)
$sql = "SELECT t.*, s.nama_siswa, b.judul, b.cover 
        FROM transaksi t
        JOIN siswa s ON t.siswa_id = s.id
        JOIN buku b ON t.buku_id = b.id
        $condition
        ORDER BY t.id DESC";
$query = mysqli_query($conn, $sql);

// Query untuk daftar pilihan di Modal
$data_siswa = mysqli_query($conn, "SELECT id, nama_siswa FROM siswa ORDER BY nama_siswa ASC");
$data_buku  = mysqli_query($conn, "SELECT id, judul FROM buku ORDER BY judul ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Peminjaman | E-Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-minimal/minimal.css" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfaf8; color: #2c2119; }
        .main-content { margin-left: 280px; padding: 40px; transition: 0.3s; }
        .page-header { margin-bottom: 40px; }
        .search-container {
            background: #fff; padding: 8px 20px; border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #eee;
            display: flex; align-items: center; width: 100%; max-width: 400px;
        }
        .search-container input { border: none; outline: none; background: transparent; padding: 8px 10px; width: 100%; }
        .btn-premium {
            background: #2c2119; color: #fff; border-radius: 14px; padding: 12px 24px;
            font-weight: 600; border: none; transition: all 0.3s;
            box-shadow: 0 8px 20px rgba(44, 33, 25, 0.15);
        }
        .btn-premium:hover { background: #e2c7b0; color: #2c2119; transform: translateY(-2px); }
        .table-card { background: #fff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.03); }
        .table thead th { background: #fdfcfb; padding: 20px; font-size: 0.75rem; text-transform: uppercase; color: #a0a0a0; border-bottom: 1px solid #f1f1f1; }
        .table tbody td { padding: 20px; vertical-align: middle; border-bottom: 1px solid #fafafa; }
        .badge-status { padding: 8px 16px; border-radius: 10px; font-weight: 600; font-size: 0.75rem; }
        .status-pinjam { background: rgba(255, 193, 7, 0.1); color: #d39e00; }
        .status-kembali { background: rgba(40, 167, 69, 0.1); color: #28a745; }
        .btn-delete-ui { width: 38px; height: 38px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; background: #ffeeee; color: #e74c3c; border: none; cursor: pointer; transition: 0.3s; }
        .btn-delete-ui:hover { background: #e74c3c; color: #fff; }

        /* Custom Styling SweetAlert2 */
        .swal2-popup { border-radius: 24px !important; font-family: 'Plus Jakarta Sans', sans-serif !important; }
        .swal2-confirm { border-radius: 12px !important; background-color: #2c2119 !important; }
        .swal2-cancel { border-radius: 12px !important; }

        @media (max-width: 992px) { .main-content { margin-left: 0; padding: 20px; } }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h2 class="fw-800 mb-1" style="letter-spacing: -1px;">Log Peminjaman</h2>
            <p class="text-muted m-0">Kelola alur keluar masuk buku perpustakaan</p>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <form action="" method="POST" class="search-container">
                <i class="fas fa-search text-muted"></i>
                <input type="text" name="keyword" placeholder="Cari buku..." value="<?= htmlspecialchars($keyword) ?>">
            </form>
        </div>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Cover</th>
                        <th>Peminjam</th>
                        <th>Judul Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td class="ps-4">
                            <?php if(!empty($row['cover'])): ?>
                                <img src="assets/img/cover/<?= $row['cover'] ?>" width="45" height="60" style="object-fit: cover; border-radius: 8px;">
                            <?php else: ?>
                                <div style="width: 45px; height: 60px; background: #eee; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #aaa;">No Cover</div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="fw-bold"><?= htmlspecialchars($row['nama_siswa']) ?></div>
                            <small class="text-muted">ID: #TRX-<?= $row['id'] ?></small>
                        </td>
                        <td class="fw-600 text-secondary"><?= htmlspecialchars($row['judul']) ?></td>
                        <td><span class="text-muted small fw-bold"><?= date('d/m/Y', strtotime($row['tgl_pinjam'])) ?></span></td>
                        <td>
                            <?php if($row['status'] == 'pinjam'): ?>
                                <span class="badge-status status-pinjam"><i class="fas fa-clock me-1"></i> Dipinjam</span>
                            <?php else: ?>
                                <span class="badge-status status-kembali"><i class="fas fa-check-circle me-1"></i> Kembali</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <button class="btn-delete-ui" onclick="confirmDelete(<?= $row['id'] ?>)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Data?',
        text: "Data peminjaman TRX-" + id + " akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2c2119',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        background: '#fff',
        backdrop: `rgba(44, 33, 25, 0.1)`
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "hapus_peminjaman.php?id=" + id;
        }
    })
}

// Cek jika ada parameter status dari proses hapus
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.has('status')) {
    const status = urlParams.get('status');
    if (status === 'success') {
        Swal.fire({
            title: 'Berhasil!',
            text: 'Data telah dihapus.',
            icon: 'success',
            confirmButtonColor: '#2c2119'
        });
    } else if (status === 'error') {
        Swal.fire({
            title: 'Gagal!',
            text: 'Terjadi kesalahan saat menghapus data.',
            icon: 'error',
            confirmButtonColor: '#2c2119'
        });
    }
}
</script>
</body>
</html>