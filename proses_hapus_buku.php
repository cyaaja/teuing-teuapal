<?php
session_start();

// 1. Cek login
if (!isset($_SESSION["status"])) {
    header("Location: login.php");
    exit();
}

// 2. Hubungkan ke database
require_once 'config/koneksi.php';

// 3. Ambil ID dari URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // 4. Gunakan Try-Catch atau cek manual untuk menangani Foreign Key Error
    try {
        $query = "DELETE FROM buku WHERE id = '$id'";
        $hapus = mysqli_query($conn, $query);

        if ($hapus) {
            echo "<script>
                    alert('Data buku berhasil dihapus!');
                    window.location.href = 'buku.php';
                  </script>";
        }
    } catch (mysqli_sql_exception $e) {
        // Jika error karena Foreign Key (kode error 1451)
        echo "<script>
                alert('GAGAL MENGHAPUS: Buku ini tidak bisa dihapus karena masih memiliki riwayat transaksi atau sedang dipinjam. Silakan hapus data transaksinya terlebih dahulu.');
                window.location.href = 'buku.php';
              </script>";
    }
} else {
    header("Location: buku.php");
    exit();
}
?>