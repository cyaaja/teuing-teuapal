<?php
session_start();
require_once 'config/koneksi.php';

if (isset($_POST['update'])) {
    // Ambil data dari form modal peminjaman
    $id     = mysqli_real_escape_string($conn, $_POST['id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Query UPDATE khusus untuk tabel transaksi/peminjaman
    $sql = "UPDATE transaksi SET status = '$status' WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        // Redirect kembali ke halaman peminjaman dengan pesan sukses
        header("Location: peminjaman.php?pesan=update-berhasil");
    } else {
        echo "Gagal mengupdate status: " . mysqli_error($conn);
    }
} else {
    header("Location: peminjaman.php");
}
?>