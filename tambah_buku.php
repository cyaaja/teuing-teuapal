<?php
session_start();
if (!isset($_SESSION["status"])) { header("Location: login.php"); exit(); }
require_once 'config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <title>Tambah Buku | E-Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0 rounded-4 p-4">
                    <h4 class="fw-bold mb-4">Tambah Koleksi Buku</h4>
                    
                    <form action="proses_tambah.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" name="judul" class="form-control" required placeholder="Contoh: Laskar Pelangi">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Penulis</label>
                            <input type="text" name="penulis" class="form-control" required placeholder="Nama Penulis">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Penerbit</label>
                            <input type="text" name="penerbit" class="form-control" required placeholder="Nama Penerbit">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stok Buku</label>
                            <input type="number" name="stok" class="form-control" required placeholder="0">
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" name="tambah" class="btn btn-dark w-100 rounded-pill">Simpan Data</button>
                            <a href="buku.php" class="btn btn-outline-secondary w-100 rounded-pill">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>
</html>