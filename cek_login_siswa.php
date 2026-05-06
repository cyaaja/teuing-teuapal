<?php 
session_start();
include '../admin/config/koneksi.php';

// Ambil data dari form login
// Kita gunakan mysqli_real_escape_string untuk keamanan dari SQL Injection
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// PERBAIKAN: Di database kamu kolomnya adalah 'nis', bukan 'username'
// Kita cek apakah NIS dan Password cocok
$query_text = "SELECT * FROM siswa WHERE nis='$username' AND password='$password'";
$login = mysqli_query($conn, $query_text);

// Cek apakah data ditemukan
$cek = mysqli_num_rows($login);

if($cek > 0){
    $data = mysqli_fetch_assoc($login);
    
    // Simpan data ke session
    $_SESSION['id_siswa']   = $data['id']; // Mengambil 'id' dari tabel siswa
    $_SESSION['nama_siswa'] = $data['nama_siswa']; // Sesuai kolom di gambar: nama_siswa
    $_SESSION['nis']        = $data['nis'];
    $_SESSION['status']     = "login_siswa";
    
    // Alihkan ke halaman beranda
    header("location:beranda_siswa.php");
} else {
    // Jika gagal, balik ke login dengan pesan error
    header("location:login_siswa.php?pesan=gagal");
}
?>