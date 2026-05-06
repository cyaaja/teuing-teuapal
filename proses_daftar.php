<?php
// Sesuaikan path koneksi dengan folder kamu
require_once '../admin/config/koneksi.php'; 

// Ambil data dari form daftar.php
// Gunakan mysqli_real_escape_string untuk keamanan dari SQL Injection
$nama     = mysqli_real_escape_string($conn, $_POST['nama']);
$nis      = mysqli_real_escape_string($conn, $_POST['username']); // NIS digunakan sebagai username
$kelas    = mysqli_real_escape_string($conn, $_POST['kelas']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$status   = "aktif"; // Set default status saat mendaftar

// 1. PERBAIKAN: Cek apakah NIS sudah terdaftar di tabel 'siswa'
// Sebelumnya error karena kamu menulis 'SELECT * FROM nama_siswa'
$cek_user = mysqli_query($conn, "SELECT * FROM siswa WHERE nis = '$nis'");

if (mysqli_num_rows($cek_user) > 0) {
    // Jika NIS sudah ada di database
    header("Location: daftar.php?pesan=gagal");
} else {
    // 2. PERBAIKAN: Query INSERT disesuaikan dengan nama kolom di phpMyAdmin kamu
    // Kolom: nis, nama_siswa, kelas, status, password
    $query = mysqli_query($conn, "INSERT INTO siswa (nis, nama_siswa, kelas, status, password) 
                                  VALUES ('$nis', '$nama', '$kelas', '$status', '$password')");

    if ($query) {
        echo "<script>
                alert('Pendaftaran Berhasil! Silakan Login.');
                window.location='login_siswa.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal mendaftar: " . mysqli_error($conn) . "');
                window.location='daftar.php';
              </script>";
    }
}
?>