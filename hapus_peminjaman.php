<?php
session_start();
require_once 'config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM transaksi WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        header("Location: peminjaman.php?pesan=hapus_berhasil");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>