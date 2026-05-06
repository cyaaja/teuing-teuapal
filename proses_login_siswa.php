<?php
session_start();
require_once '../admin/config/koneksi.php';

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Cari siswa berdasarkan nis (sebagai username) atau nama_siswa
$query = mysqli_query($conn, "SELECT * FROM siswa WHERE (nis='$username' OR nama_siswa='$username') AND password='$password'");
$cek = mysqli_num_rows($query);

if($cek > 0){
    $data = mysqli_fetch_assoc($query);
    
    // SIMPAN DATA KE SESSION (Paling Penting!)
    $_SESSION['id_siswa']   = $data['id'];         // Mengambil ID (Primary Key)
    $_SESSION['nama_siswa'] = $data['nama_siswa']; // Mengambil Nama
    $_SESSION['nis']        = $data['nis'];        // Mengambil NIS
    $_SESSION['status']     = "login_siswa";
    
    header("location:beranda_siswa.php");
} else {
    header("location:login_siswa.php?pesan=gagal");
}
?>