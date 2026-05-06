<?php
session_start();

// Pastikan path ini benar sesuai struktur folder kamu
require_once 'config/koneksi.php';

// Cek apakah form login sudah disubmit
if (isset($_POST['login'])) {
    
    // GANTI $koneksi MENJADI $conn agar sesuai dengan isi file config/koneksi.php
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query pencarian user
    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
    
    // Cek apakah query berhasil atau error
    if (!$query) {
        die("Query Error: " . mysqli_error($conn));
    }

    // Hitung jumlah baris yang ditemukan
    $cek = mysqli_num_rows($query);

    if ($cek > 0) {
        // Ambil data user
        $data = mysqli_fetch_assoc($query);

        // Set Session
        $_SESSION['username']     = $data['username'];
        $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
        $_SESSION['status']       = "login";

        // Alihkan ke halaman beranda admin
        header("location:beranda.php");
        exit();
    } else {
        // Jika login gagal
        echo "<script>
                alert('Username atau Password Salah!');
                window.location='login.php';
              </script>";
    }
} else {
    // Jika mencoba akses langsung file ini tanpa login
    header("location:login.php");
    exit();
}
?>