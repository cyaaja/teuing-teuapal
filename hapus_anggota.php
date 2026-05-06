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
    $id = $_GET['id'];

    // 4. PERBAIKAN: Gunakan tabel 'siswa' dan variabel '$conn'
    // Nama tabel harus 'siswa' sesuai db_shika.sql kamu
    $query = "DELETE FROM siswa WHERE id = '$id'";
    $hapus = mysqli_query($conn, $query);

    if ($hapus) {
        // Jika berhasil, balik ke halaman anggota dengan pesan sukses
        echo "<script>
                alert('Data anggota berhasil dihapus!');
                window.location.href = 'anggota.php';
              </script>";
    } else {
        // Jika gagal (misal karena ID masih nyangkut di tabel peminjaman)
        echo "<script>
                alert('Gagal menghapus! Data ini mungkin masih terkait dengan transaksi peminjaman.');
                window.location.href = 'anggota.php';
              </script>";
    }
} else {
    // Jika tidak ada ID di URL, balikkan ke halaman anggota
    header("Location: anggota.php");
    exit();
}
?>