<?php
session_start();
if (!isset($_SESSION["status"])) {
    header("Location: login.php");
    exit();
}
require_once 'config/koneksi.php';

$username = $_SESSION['username'] ?? 'Admin';
$role     = $_SESSION['role'] ?? 'Petugas';

// Ambil data foto dari database (asumsi kolom bernama 'foto')
$query_user = mysqli_query($conn, "SELECT foto FROM admin WHERE username = '$username'");
$data_user = mysqli_fetch_assoc($query_user);
$foto_profil = (!empty($data_user['foto'])) ? 'uploads/profile/' . $data_user['foto'] : "https://ui-avatars.com/api/?name=" . urlencode($username) . "&background=e2c7b0&color=1a1612&size=128";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun | E-Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-color: #fcfaf8;
            --primary-brown: #2c2119;
            --accent-tan: #e2c7b0;
            --glass-white: rgba(255, 255, 255, 0.9);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--primary-brown);
            overflow-x: hidden;
        }

        .main-content { margin-left: 280px; padding: 40px; }

        .page-header { margin-bottom: 40px; }
        .page-header h2 { font-weight: 800; letter-spacing: -1px; }

        .btn-back {
            background: white;
            color: var(--primary-brown);
            border: 1px solid rgba(0,0,0,0.05);
            border-radius: 12px;
            padding: 8px 16px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            margin-bottom: 15px;
        }
        .btn-back:hover {
            background: var(--primary-brown);
            color: white;
            transform: translateX(-5px);
        }

        .bento-card {
            background: var(--glass-white);
            border: 1px solid rgba(0,0,0,0.05);
            border-radius: 24px;
            padding: 30px;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            transition: 0.3s;
        }
        .bento-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.05); }

        .profile-pille {
            width: 120px;
            height: 120px;
            border-radius: 35px;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .form-label { font-weight: 700; font-size: 0.85rem; color: #888; text-transform: uppercase; margin-bottom: 10px; }
        .form-control {
            border-radius: 15px;
            padding: 12px 18px;
            border: 1px solid #eee;
            background: #fdfdfd;
            font-weight: 600;
            transition: 0.3s;
        }
        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(226, 199, 176, 0.2);
            border-color: var(--accent-tan);
        }

        .btn-save {
            background: var(--primary-brown);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 15px 30px;
            font-weight: 700;
            width: 100%;
            transition: 0.3s;
        }
        .btn-save:hover { background: #4a3a2d; box-shadow: 0 10px 20px rgba(44, 33, 25, 0.2); }

        .icon-circle {
            width: 40px;
            height: 40px;
            background: #f4eee9;
            color: #6b4f3b;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .toast-container { z-index: 1060; }
        .custom-toast {
            border-radius: 18px !important;
            backdrop-filter: blur(10px);
            border: none !important;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1) !important;
        }

        /* Hover effect untuk ikon kamera */
        .camera-btn {
            cursor: pointer;
            transition: 0.3s;
        }
        .camera-btn:hover {
            transform: scale(1.1);
            background-color: var(--accent-tan) !important;
            color: white !important;
        }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="page-header">
        <a href="beranda.php" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
        <h2 class="mb-1 text-dark">Pengaturan Sistem</h2>
        <p class="text-muted">Kelola profil admin dan konfigurasi aplikasi Anda.</p>
    </div>

    <form action="proses_update_profil.php" method="POST" enctype="multipart/form-data">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="bento-card text-center">
                    <div class="position-relative d-inline-block mb-4">
                        <img src="<?= $foto_profil ?>" id="previewFoto" class="profile-pille">
                        
                        <label for="uploadFoto" class="position-absolute bottom-0 end-0 bg-white p-2 rounded-circle shadow-sm camera-btn" title="Ganti Foto">
                            <i class="fas fa-camera text-muted"></i>
                            <input type="file" name="foto_profil" id="uploadFoto" hidden accept="image/*" onchange="readURL(this);">
                        </label>
                    </div>
                    <h4 class="fw-800 mb-1"><?= htmlspecialchars($username) ?></h4>
                    <p class="badge bg-light text-dark px-3 rounded-pill border"><?= htmlspecialchars($role) ?></p>
                    
                    <hr class="my-4 opacity-50">
                    
                    <div class="text-start px-2">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-circle mb-0 me-3"><i class="fas fa-shield-alt"></i></div>
                            <div>
                                <h6 class="mb-0 fw-700 small">Keamanan Akun</h6>
                                <p class="text-muted small mb-0">Aktif • Tingkat Tinggi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="bento-card">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-circle mb-0 me-3"><i class="fas fa-user-edit"></i></div>
                        <h5 class="fw-800 m-0">Informasi Personal</h5>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($username) ?>" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Role Akses</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($role) ?>" disabled>
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label">Kata Sandi Baru</label>
                            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>
                        <div class="col-12">
                            <button type="submit" name="submit" class="btn btn-save">
                                <i class="fas fa-check-circle me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>

<?php if (isset($_GET['status'])): ?>
    <div class="toast-container position-fixed bottom-0 start-50 translate-middle-x pb-4">
        <div id="liveToast" class="toast show custom-toast align-items-center text-white border-0 <?= $_GET['status'] == 'success' ? 'bg-success' : 'bg-danger' ?>" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex p-2">
                <div class="toast-body">
                    <?php if ($_GET['status'] == 'success'): ?>
                        <i class="fas fa-check-circle me-2"></i> Profil berhasil diperbarui!
                    <?php else: ?>
                        <i class="fas fa-exclamation-circle me-2"></i> Gagal: <?= htmlspecialchars($_GET['msg'] ?? 'Terjadi kesalahan') ?>
                    <?php endif; ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function() {
            var toastElement = document.getElementById('liveToast');
            if (toastElement) {
                toastElement.classList.remove('show');
                setTimeout(() => toastElement.remove(), 500);
            }
        }, 4000);
    </script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewFoto').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</body>
</html>