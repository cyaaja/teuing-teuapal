<?php
// 1. Koneksi ke Database
$koneksi = mysqli_connect("localhost", "root", "", "db_shika");

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// 2. Cek apakah tombol register sudah diklik
if (isset($_POST['register'])) {
    
    // Ambil data dari form dan bersihkan (Security)
    $nama_lengkap     = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $username         = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 3. Validasi: Pastikan semua field terisi
    if (empty($nama_lengkap) || empty($username) || empty($password)) {
        echo "<script>alert('Semua data wajib diisi!'); window.history.back();</script>";
        exit();
    }

    // 4. Validasi: Cek apakah password dan konfirmasi password cocok
    if ($password !== $confirm_password) {
        echo "<script>alert('Konfirmasi password tidak cocok!'); window.history.back();</script>";
        exit();
    }

    // 5. Validasi: Cek apakah username sudah ada di database
    $check_user = mysqli_query($koneksi, "SELECT * FROM admin WHERE username = '$username'");
    if (mysqli_num_rows($check_user) > 0) {
        echo "<script>alert('Username sudah digunakan, cari yang lain!'); window.history.back();</script>";
        exit();
    }

    // 6. Proses Simpan ke Database
    // Catatan: Saya menggunakan plain text sesuai struktur database yang Anda kirim sebelumnya
    $query_input = "INSERT INTO admin (username, password, nama_lengkap) VALUES ('$username', '$password', '$nama_lengkap')";
    $simpan = mysqli_query($koneksi, $query_input);

    if ($simpan) {
        echo "<script>
                alert('Pendaftaran Berhasil! Silakan Login.');
                window.location='login.php';
              </script>";
    } else {
        echo "<script>alert('Gagal mendaftar, silakan coba lagi.'); window.history.back();</script>";
    }

} else {
    // Jika akses file ini tanpa submit form
    header("location:register.php");
    exit();
}
?>