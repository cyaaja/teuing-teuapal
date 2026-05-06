<?php
session_start();
require_once 'config/koneksi.php';

$id = $_GET['id'];
if (isset($_POST['update'])) {
    $status = $_POST['status'];
    mysqli_query($conn, "UPDATE transaksi SET status='$status' WHERE id='$id'");
    header("Location: peminjaman.php");
}

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transaksi WHERE id='$id'"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Status</title>
</head>
<body class="bg-light p-5">
    <div class="card mx-auto shadow-sm" style="max-width: 400px; border-radius: 20px;">
        <div class="card-body">
            <h5 class="fw-bold mb-4">Update Status Buku</h5>
            <form method="POST">
                <div class="mb-3">
                    <label class="small fw-bold">Status Transaksi</label>
                    <select name="status" class="form-select">
                        <option value="dipinjam" <?= $data['status'] == 'dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
                        <option value="kembali" <?= $data['status'] == 'kembali' ? 'selected' : '' ?>>Kembali</option>
                    </select>
                </div>
                <button type="submit" name="update" class="btn btn-primary w-100 rounded-pill">Simpan</button>
                <a href="peminjaman.php" class="btn btn-link w-100 mt-2 text-muted text-decoration-none">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>