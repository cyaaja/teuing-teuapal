<?php
require_once 'config/koneksi.php';

if (isset($_POST['update'])) {
    $id       = $_POST['id'];
    $judul    = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis  = mysqli_real_escape_string($conn, $_POST['penulis']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $stok     = $_POST['stok'];

    if (!empty($_FILES['cover']['name'])) {
        $filename = $_FILES['cover']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $new_filename = "cover_" . time() . "_" . $id . "." . $ext;
        $target = "assets/img/cover/" . $new_filename;

        if (move_uploaded_file($_FILES['cover']['tmp_name'], $target)) {
            // Update dengan Cover Baru
            $sql = "UPDATE buku SET judul='$judul', penulis='$penulis', kategori='$kategori', stok='$stok', cover='$new_filename' WHERE id='$id'";
        }
    } else {
        // Update Tanpa Ganti Cover
        $sql = "UPDATE buku SET judul='$judul', penulis='$penulis', kategori='$kategori', stok='$stok' WHERE id='$id'";
    }

    mysqli_query($conn, $sql);
    header("Location: buku.php");
}
?>