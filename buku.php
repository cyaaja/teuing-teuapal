<?php
session_start();
if (!isset($_SESSION["status"])) {
    header("Location: login.php");
    exit();
}
require_once 'config/koneksi.php';

// Fitur Pencarian
$keyword = "";
if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $query_text = "SELECT * FROM buku WHERE judul LIKE '%$keyword%' OR penulis LIKE '%$keyword%' ORDER BY id DESC";
} else {
    $query_text = "SELECT * FROM buku ORDER BY id DESC";
}
$query = mysqli_query($conn, $query_text);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Buku | E-Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #fcfaf8; 
            color: #2c2119;
        }
        .main-content { margin-left: 280px; padding: 40px; transition: 0.3s; }

        .search-box {
            background: #fff;
            border-radius: 16px;
            padding: 10px 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            border: 1px solid #eee;
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 400px;
        }
        .search-box input { border: none; outline: none; background: transparent; width: 100%; margin-left: 10px; }

        .book-card {
            background: #fff;
            border-radius: 24px;
            border: none;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            height: 100%;
        }
        .book-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(44, 33, 25, 0.12);
        }
        .cover-wrapper {
            height: 280px;
            overflow: hidden;
            position: relative;
            background: #f4eee9;
        }
        .book-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }
        .book-card:hover .book-cover { transform: scale(1.1); }

        .category-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(5px);
            padding: 6px 15px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            color: #2c2119;
        }

        .book-info { padding: 20px; }
        .book-title { font-weight: 800; font-size: 1.1rem; margin-bottom: 5px; line-height: 1.3; }
        .book-author { color: #a0a0a0; font-size: 0.85rem; margin-bottom: 15px; }

        .btn-action-group {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .btn-edit-trigger { background: #f4eee9; color: #6b4f3b; flex: 1; border-radius: 12px; padding: 8px; font-weight: 600; border: none; font-size: 0.8rem; transition: 0.3s; }
        .btn-delete { background: #ffeeee; color: #e74c3c; width: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.3s; border: none; }
        .btn-edit-trigger:hover { background: #e2c7b0; color: #fff; }
        .btn-delete:hover { background: #e74c3c; color: #fff; }

        .btn-premium {
            background: #2c2119;
            color: #fff;
            border-radius: 14px;
            padding: 12px 24px;
            font-weight: 600;
            border: none;
            box-shadow: 0 8px 20px rgba(44, 33, 25, 0.15);
        }
        .btn-premium:hover { background: #e2c7b0; color: #2c2119; }

        /* Customizing SweetAlert to match your theme */
        .swal2-popup {
            border-radius: 28px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
        .swal2-confirm {
            background-color: #2c2119 !important;
            border-radius: 12px !important;
        }

        @media (max-width: 992px) { .main-content { margin-left: 0; padding: 20px; } }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
        <div>
            <h2 class="fw-800 mb-1">Koleksi Perpustakaan</h2>
            <p class="text-muted m-0">Terdapat <?= mysqli_num_rows($query) ?> judul buku tersedia</p>
        </div>
        <div class="d-flex gap-3">
            <form action="" method="POST" class="search-box">
                <i class="fas fa-search text-muted"></i>
                <input type="text" name="keyword" placeholder="Cari judul atau penulis..." value="<?= $keyword ?>">
            </form>
            <button class="btn-premium" data-bs-toggle="modal" data-bs-target="#modalTambahBuku">
                <i class="fas fa-plus me-2"></i> Tambah Koleksi
            </button>
        </div>
    </div>

    <div class="row g-4">
        <?php while($row = mysqli_fetch_assoc($query)): ?>
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="book-card">
                <div class="cover-wrapper">
                    <span class="category-badge"><?= $row['kategori'] ?? 'Umum' ?></span>
                    <?php 
                    $path_cover = "assets/img/cover/" . $row['cover'];
                    if(!empty($row['cover']) && file_exists($path_cover)): 
                    ?>
                        <img src="<?= $path_cover ?>" class="book-cover" alt="Cover">
                    <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                            <i class="fas fa-image fa-3x opacity-25"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="book-info">
                    <div class="book-title text-truncate"><?= $row['judul'] ?></div>
                    <div class="book-author"><i class="fas fa-pen-nib me-1 small"></i> <?= $row['penulis'] ?></div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="badge bg-light text-dark fw-bold border" style="font-size: 0.7rem;">Stok: <?= $row['stok'] ?></span>
                        <span class="text-muted small">ID: #<?= $row['id'] ?></span>
                    </div>
                    <div class="btn-action-group">
                        <button class="btn-edit-trigger" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalEditBuku"
                                data-id="<?= $row['id'] ?>"
                                data-judul="<?= $row['judul'] ?>"
                                data-penulis="<?= $row['penulis'] ?>"
                                data-stok="<?= $row['stok'] ?>"
                                data-kategori="<?= $row['kategori'] ?>">
                            <i class="fas fa-edit me-1"></i> Edit Detail
                        </button>
                        
                        <button type="button" 
                                class="btn-delete" 
                                onclick="confirmDelete('hapus_buku.php?id=<?= $row['id'] ?>', '<?= addslashes($row['judul']) ?>')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<div class="modal fade" id="modalTambahBuku" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 28px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-800 m-0">Tambah Koleksi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="proses_tambah_buku.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="small fw-bold text-muted mb-2">JUDUL BUKU</label>
                        <input type="text" name="judul" class="form-control border-0 bg-light py-3 rounded-4" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold text-muted mb-2">KATEGORI</label>
                        <select name="kategori" class="form-select border-0 bg-light py-3 rounded-4" required>
                            <option value="Umum">Umum</option>
                            <option value="Sains">Sains</option>
                            <option value="Novel">Novel</option>
                            <option value="Sejarah">Sejarah</option>
                            <option value="Teknologi">Teknologi</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold text-muted mb-2">PENULIS</label>
                            <input type="text" name="penulis" class="form-control border-0 bg-light py-3 rounded-4" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold text-muted mb-2">STOK</label>
                            <input type="number" name="stok" class="form-control border-0 bg-light py-3 rounded-4" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="small fw-bold text-muted mb-2">UPLOAD COVER</label>
                        <input type="file" name="cover" class="form-control border-0 bg-light py-2 rounded-4">
                    </div>
                    <button type="submit" name="tambah" class="btn-premium w-100 py-3 rounded-4">Simpan ke Katalog</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditBuku" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 28px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-800 m-0">Edit Detail Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="proses_edit_buku.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label class="small fw-bold text-muted mb-2">JUDUL BUKU</label>
                        <input type="text" name="judul" id="edit-judul" class="form-control border-0 bg-light py-3 rounded-4" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold text-muted mb-2">KATEGORI</label>
                        <select name="kategori" id="edit-kategori" class="form-select border-0 bg-light py-3 rounded-4" required>
                            <option value="Umum">Umum</option>
                            <option value="Sains">Sains</option>
                            <option value="Novel">Novel</option>
                            <option value="Sejarah">Sejarah</option>
                            <option value="Teknologi">Teknologi</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold text-muted mb-2">PENULIS</label>
                            <input type="text" name="penulis" id="edit-penulis" class="form-control border-0 bg-light py-3 rounded-4" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold text-muted mb-2">STOK</label>
                            <input type="number" name="stok" id="edit-stok" class="form-control border-0 bg-light py-3 rounded-4" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="small fw-bold text-muted mb-2">GANTI COVER (OPSIONAL)</label>
                        <input type="file" name="cover" class="form-control border-0 bg-light py-2 rounded-4" accept="image/*">
                        <small class="text-muted" style="font-size: 0.7rem;">*Kosongkan jika tidak ingin mengubah cover.</small>
                    </div>
                    <button type="submit" name="update" class="btn-premium w-100 py-3 rounded-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Script untuk Modal Edit (Tetap Sama)
    const editModal = document.getElementById('modalEditBuku');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        document.getElementById('edit-id').value = button.getAttribute('data-id');
        document.getElementById('edit-judul').value = button.getAttribute('data-judul');
        document.getElementById('edit-penulis').value = button.getAttribute('data-penulis');
        document.getElementById('edit-stok').value = button.getAttribute('data-stok');
        document.getElementById('edit-kategori').value = button.getAttribute('data-kategori');
    });

    // Fungsi Pop Up Hapus Kece
    function confirmDelete(url, title) {
        Swal.fire({
            title: 'Hapus Buku?',
            text: `Apakah kamu yakin ingin menghapus buku "${title}"? Tindakan ini tidak bisa dibatalkan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2c2119',
            cancelButtonColor: '#e74c3c',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    }

    // Bonus: Pop up sukses jika ada status=sukses di URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') === 'sukses') {
        Swal.fire({
            title: 'Berhasil!',
            text: 'Data telah diperbarui.',
            icon: 'success',
            confirmButtonColor: '#2c2119',
            timer: 2000
        });
    }
</script>
</body>
</html>