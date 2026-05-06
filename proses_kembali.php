<?php
session_start();
require_once '../admin/config/koneksi.php';

// Pastikan parameter ID transaksi dan ID buku tersedia
if (isset($_GET['id']) && isset($_GET['buku_id'])) {
    $id_transaksi = $_GET['id'];
    $id_buku = $_GET['buku_id'];
    $tgl_sekarang = date('Y-m-d'); // Catat tanggal pengembalian hari ini

    // 1. Update status transaksi menjadi 'Dikembalikan'
    $query_update = "UPDATE transaksi SET 
                     status = 'Dikembalikan', 
                     tgl_kembali = '$tgl_sekarang' 
                     WHERE id = '$id_transaksi'";
    
    if (mysqli_query($conn, $query_update)) {
        // 2. Tambah stok buku kembali (+1) di database
        mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id = '$id_buku'");
        
        echo "<script>
                alert('Berhasil! Buku telah dikembalikan.');
                window.location='riwayat_pinjam.php';
              </script>";
    } else {
        echo "<script>alert('Gagal memproses data.'); window.location='riwayat_pinjam.php';</script>";
    }
} else {
    header("Location: riwayat_pinjam.php");
}
?>