<?php
session_start();
// 1. Proteksi Halaman
if (!isset($_SESSION["status"])) {
    header("Location: login.php");
    exit();
}
// 2. Koneksi Database
require_once 'config/koneksi.php';

// Fitur Pencarian
$keyword = "";
if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    // Mencari berdasarkan NIS atau Nama Siswa
    $query_text = "SELECT * FROM siswa WHERE nis LIKE '%$keyword%' OR nama_siswa LIKE '%$keyword%' ORDER BY id DESC";
} else {
    $query_text = "SELECT * FROM siswa ORDER BY id DESC";
}

$query = mysqli_query($conn, $query_text);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Anggota | E-Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fa; }
        .main-content { margin-left: 280px; padding: 40px; }
        
        .fw-800 { font-weight: 800; }
        .fw-600 { font-weight: 600; }

        .card-table {
            border: none;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            background: #fff;
        }

        .search-wrapper {
            background: #fff;
            padding: 10px 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.02);
            border: 1px solid #eee;
            width: 350px;
        }

        .search-wrapper input { border: none; outline: none; width: 90%; margin-left: 10px; font-weight: 500; }

        .btn-add {
            background: #2c2119;
            color: #fff;
            border-radius: 15px;
            padding: 12px 25px;
            border: none;
            font-weight: 600;
            box-shadow: 0 10px 20px rgba(44, 33, 25, 0.2);
        }
        .btn-add:hover { background: #e2c7b0; color: #2c2119; }

        .avatar-circle {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            object-fit: cover;
        }

        .action-btn {
            width: 35px;
            height: 35px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
            text-decoration: none;
            border: none;
        }
        .btn-edit-trigger { background: #fff8ee; color: #f39c12; }
        .btn-delete { background: #ffeeee; color: #e74c3c; }
        .btn-edit-trigger:hover { background: #f39c12; color: #fff; }
        .btn-delete:hover { background: #e74c3c; color: #fff; }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-800 mb-1">Database Anggota</h2>
            <p class="text-muted">Total <?= mysqli_num_rows($query) ?> Siswa Terverifikasi</p>
        </div>
        <div class="d-flex gap-3">
            <form action="" method="POST" class="search-wrapper d-flex align-items-center">
                <i class="fas fa-search text-muted"></i>
                <input type="text" name="keyword" placeholder="Cari NIS atau Nama..." value="<?= $keyword ?>">
                <button type="submit" name="cari" class="d-none"></button>
            </form>
            <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#modalTambahAnggota">
                <i class="fas fa-plus me-2"></i> Tambah Anggota
            </button>
        </div>
    </div>

    <div class="card card-table">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">Profil</th>
                        <th class="py-3">NIS</th>
                        <th class="py-3">Kelas</th>
                        <th class="py-3 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($row['nama_siswa']) ?>&background=random" class="avatar-circle">
                                <div>
                                    <div class="fw-bold"><?= $row['nama_siswa'] ?></div>
                                    <small class="text-muted">ID Anggota: #<?= $row['id'] ?></small>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark border px-3"><?= $row['nis'] ?></span></td>
                        <td class="fw-600"><?= $row['kelas'] ?></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" 
                                    class="action-btn btn-edit-trigger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEditAnggota"
                                    data-id="<?= $row['id'] ?>"
                                    data-nis="<?= $row['nis'] ?>"
                                    data-nama="<?= $row['nama_siswa'] ?>"
                                    data-kelas="<?= $row['kelas'] ?>">
                                    <i class="fas fa-pen-nib"></i>
                                </button>
                                <a href="hapus_anggota.php?id=<?= $row['id'] ?>" class="action-btn btn-delete" onclick="return confirm('Hapus anggota ini?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahAnggota" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
            <div class="modal-header border-0 p-4">
                <h5 class="fw-800 m-0">Registrasi Anggota Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="proses_tambah_anggota.php" method="POST">
                <div class="modal-body p-4 pt-0">
                    <div class="mb-3">
                        <label class="small fw-bold text-muted mb-2">NOMOR INDUK SISWA</label>
                        <input type="text" name="nis" class="form-control form-control-lg border-0 bg-light rounded-4" placeholder="Contoh: 2024001" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold text-muted mb-2">NAMA LENGKAP</label>
                        <input type="text" name="nama_siswa" class="form-control form-control-lg border-0 bg-light rounded-4" required>
                    </div>
                    <div class="mb-4">
                        <label class="small fw-bold text-muted mb-2">KELAS & JURUSAN</label>
                        <input type="text" name="kelas" class="form-control form-control-lg border-0 bg-light rounded-4" placeholder="Contoh: XII - RPL 1" required>
                    </div>
                    <button type="submit" name="tambah" class="btn btn-add w-100 py-3 rounded-4">Simpan Ke Database</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditAnggota" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
            <div class="modal-header border-0 p-4">
                <h5 class="fw-800 m-0">Edit Data Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="proses_edit_anggota.php" method="POST">
                <div class="modal-body p-4 pt-0">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label class="small fw-bold text-muted mb-2">NOMOR INDUK SISWA</label>
                        <input type="text" name="nis" id="edit-nis" class="form-control form-control-lg border-0 bg-light rounded-4" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold text-muted mb-2">NAMA LENGKAP</label>
                        <input type="text" name="nama_siswa" id="edit-nama" class="form-control form-control-lg border-0 bg-light rounded-4" required>
                    </div>
                    <div class="mb-4">
                        <label class="small fw-bold text-muted mb-2">KELAS & JURUSAN</label>
                        <input type="text" name="kelas" id="edit-kelas" class="form-control form-control-lg border-0 bg-light rounded-4" required>
                    </div>
                    <button type="submit" name="update" class="btn btn-add w-100 py-3 rounded-4" style="background: #f39c12 !important;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Script untuk memindahkan data dari baris tabel ke dalam Modal Edit
    const modalEdit = document.getElementById('modalEditAnggota');
    modalEdit.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Tombol yang diklik
        
        // Ambil data dari atribut data-*
        const id = button.getAttribute('data-id');
        const nis = button.getAttribute('data-nis');
        const nama = button.getAttribute('data-nama');
        const kelas = button.getAttribute('data-kelas');

        // Isi input di dalam modal
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-nis').value = nis;
        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-kelas').value = kelas;
    });
</script>
</body>
</html>