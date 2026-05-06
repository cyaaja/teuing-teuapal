<?php
session_start();
require_once '../admin/config/koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login_siswa") {
    header("location:login_siswa.php?pesan=belum_login");
    exit();
}

$id_siswa = $_SESSION['id_siswa'];
$id_buku  = mysqli_real_escape_string($conn, $_GET['id_buku']);
$tgl_pinjam = date('Y-m-d');
$tgl_kembali = date('Y-m-d', strtotime('+7 days'));

// Mulai Transaksi
mysqli_begin_transaction($conn);

try {
    // 1. Cek stok & Ambil ID Buku
    $q_buku = mysqli_query($conn, "SELECT stok FROM buku WHERE id = '$id_buku' FOR UPDATE");
    $data_buku = mysqli_fetch_assoc($q_buku);

    if ($data_buku && $data_buku['stok'] > 0) {
        // 2. Potong Stok
        $upd_stok = mysqli_query($conn, "UPDATE buku SET stok = stok - 1 WHERE id = '$id_buku'");

        // 3. Tambah Transaksi (Pastikan kolom sesuai: siswa_id, buku_id, tgl_pinjam, tgl_kembali, status)
        $ins_trans = mysqli_query($conn, "INSERT INTO transaksi (siswa_id, buku_id, tgl_pinjam, tgl_kembali, status) 
                                          VALUES ('$id_siswa', '$id_buku', '$tgl_pinjam', '$tgl_kembali', 'Dipinjam')");

        if ($upd_stok && $ins_trans) {
            mysqli_commit($conn);
            header("Location: beranda_siswa.php?pesan=berhasil");
            exit();
        } else {
            throw new Exception("Query Gagal");
        }
    } else {
        header("Location: beranda_siswa.php?pesan=stok_habis");
        exit();
    }
} catch (Exception $e) {
    mysqli_rollback($conn);
    header("Location: beranda_siswa.php?pesan=error");
    exit();
}