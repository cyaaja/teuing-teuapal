<?php
session_start();
require_once 'config/koneksi.php'; // Saluyukeun pathna

if (isset($_POST['simpan'])) {
    $siswa_id   = $_POST['siswa_id'];
    $buku_id    = $_POST['buku_id'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $status     = 'dipinjam';

    // Query INSERT
    $sql = "INSERT INTO transaksi (siswa_id, buku_id, tgl_pinjam, status) 
            VALUES ('$siswa_id', '$buku_id', '$tgl_pinjam', '$status')";
    
    if (mysqli_query($conn, $sql)) {
        // Balik deui ka halaman peminjaman
        echo "<script>
                alert('Data berhasil ditambahkan!');
                window.location.href = 'peminjaman.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: peminjaman.php");
}
?>