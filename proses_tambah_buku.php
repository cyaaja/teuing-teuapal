<?php
require_once 'config/koneksi.php';

if (isset($_POST['tambah'])) {
    // Ambil data dari form
    $kode_buku    = mysqli_real_escape_string($conn, $_POST['kode_buku']);
    $judul        = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis      = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit     = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun_terbit = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
    $stok         = mysqli_real_escape_string($conn, $_POST['stok']);

    // Inisialisasi variabel nama file gambar
    $nama_baru = "default.jpg"; // Default jika tidak ada upload

    // Cek apakah ada file yang diunggah
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == 0) {
        $nama_file = $_FILES['cover']['name'];
        $tmp_file  = $_FILES['cover']['tmp_name'];
        $ukuran    = $_FILES['cover']['size'];
        $ekstensi  = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        
        // Daftar ekstensi yang diperbolehkan
        $ekstensi_boleh = array("jpg", "jpeg", "png", "webp");

        // Validasi ekstensi dan ukuran (maks 2MB)
        if (in_array($ekstensi, $ekstensi_boleh) && $ukuran <= 2097152) {
            $nama_baru = time() . '_' . uniqid() . '.' . $ekstensi;
            $path      = "assets/img/cover/" . $nama_baru;

            // Pastikan folder tujuan ada
            if (!is_dir("assets/img/cover/")) {
                mkdir("assets/img/cover/", 0777, true);
            }

            if (!move_uploaded_file($tmp_file, $path)) {
                $nama_baru = "default.jpg"; // Balik ke default jika gagal move_upload
            }
        }
    }

    // Query INSERT (Pastikan kolom di database sesuai: kode_buku, judul, penulis, penerbit, tahun_terbit, stok, cover)
    $query = "INSERT INTO buku (kode_buku, judul, penulis, penerbit, tahun_terbit, stok, cover) 
              VALUES ('$kode_buku', '$judul', '$penulis', '$penerbit', '$tahun_terbit', '$stok', '$nama_baru')";

    if (mysqli_query($conn, $query)) {
        header("Location: buku.php?status=sukses");
    } else {
        // Jika error, tampilkan pesan error database
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: buku.php");
}
?>