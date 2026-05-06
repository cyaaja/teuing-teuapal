<?php
require_once 'config/koneksi.php';

if (isset($_POST['tambah'])) {
    $judul   = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    
    // Logika Upload Gambar
    $filename = $_FILES['cover']['name'];
    $tmp_name = $_FILES['cover']['tmp_name'];
    
    // Buat nama unik agar tidak tertimpa
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $new_filename = "cover_" . time() . "." . $ext;
    $path = "assets/img/cover/" . $new_filename;

    // Cek folder assets/img/cover/ ada atau tidak, jika tidak ada jangan lupa dibuat manual
    if (move_uploaded_file($tmp_name, $path)) {
        $sql = "INSERT INTO buku (judul, penulis, cover, stok) VALUES ('$judul', '$penulis', '$new_filename', '1')";
        
        if (mysqli_query($conn, $sql)) {
            header("Location: buku.php?status=success");
        } else {
            echo "Gagal input database: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal upload gambar. Pastikan folder assets/img/cover/ sudah dibuat.";
    }
}
?>