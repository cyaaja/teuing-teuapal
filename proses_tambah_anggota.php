<?php
session_start();
// Pastikeun config/koneksi.php geus bener variabelna $conn
require_once 'config/koneksi.php'; 

if (isset($_POST['tambah'])) {
    
    /* 1. AMBIL DATA TI FORM 
       Saluyukeun name="..." dina file tambah_anggota.php anjeun
    */
    $nis        = mysqli_real_escape_string($conn, $_POST['nis']); // Tambahkeun NIS sakalian
    $nama_siswa = mysqli_real_escape_string($conn, $_POST['nama_siswa']);
    $kelas      = mysqli_real_escape_string($conn, $_POST['kelas']);
    $status     = 'aktif'; // Sasuai enum di database anjeun

    /* 2. QUERY INSERT 
       Ngaran tabel: siswa
       Ngaran kolom: nis, nama_siswa, kelas, status
       (Dina gambar database anjeun, tabel siswa teu aya kolom 'alamat' jeung 'no_hp')
    */
    $query = "INSERT INTO siswa (nis, nama_siswa, kelas, status) 
              VALUES ('$nis', '$nama_siswa', '$kelas', '$status')";

    // 3. EKSEKUSI
    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Data Siswa (Anggota) hasil ditambahkan!');
                window.location='anggota.php';
              </script>";
    } else {
        // Ieu bakal méré nyaho mun ngaran kolom masih salah
        die("Kasalahan Query: " . mysqli_error($conn));
    }
} else {
    header("Location: anggota.php");
    exit();
}
?>