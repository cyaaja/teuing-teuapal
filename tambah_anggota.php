<?php
session_start();
if (!isset($_SESSION["status"])) { header("Location: login.php"); exit(); }
require_once 'config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <title>Tambah Anggota | E-Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .btn-dark { background-color: #2c2119; border: none; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <h3 class="fw-bold text-center mb-4">Tambah Anggota Baru</h3>
                    <form action="proses_tambah_anggota.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_anggota" class="form-control" required placeholder="Masukkan nama...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelas / Jurusan</label>
                            <input type="text" name="kelas" class="form-control" required placeholder="Contoh: XII RPL 1">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Telepon (WA)</label>
                            <input type="text" name="no_hp" class="form-control" required placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" required placeholder="Alamat lengkap..."></textarea>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" name="tambah" class="btn btn-dark btn-lg rounded-pill">Simpan Anggota</button>
                            <a href="anggota.php" class="btn btn-light btn-lg rounded-pill">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>