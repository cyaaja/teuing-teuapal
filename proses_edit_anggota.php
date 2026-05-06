<?php
session_start();
if (!isset($_SESSION["status"])) {
    header("Location: ../login.php");
    exit();
}

// 1. Hubungkan ke database
require_once 'config/koneksi.php'; 

if (isset($_POST['update'])) {
    // 2. Ambil data dari form (harus sama dengan atribut 'name' di form edit)
    $id = $_POST['id'];
    $nis = $_POST['nis'];
    $nama_siswa = $_POST['nama_siswa'];
    $kelas = $_POST['kelas'];

    // 3. PERBAIKAN: Gunakan $conn dan tabel 'siswa'
    $query = "UPDATE siswa SET 
              nis = '$nis', 
              nama_siswa = '$nama_siswa', 
              kelas = '$kelas' 
              WHERE id = '$id'";

    $result = mysqli_query($conn, $query);

    // 4. Cek hasil query
    if ($result) {
        // Jika berhasil, kembali ke halaman anggota dengan pesan sukses
        header("Location: anggota.php?status=sukses");
    } else {
        // Jika gagal, tampilkan error
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Jika mencoba akses langsung tanpa tekan tombol simpan
    header("Location: anggota.php");
}
?>