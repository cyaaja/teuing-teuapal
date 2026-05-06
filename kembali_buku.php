<?php
session_start();
require_once '../admin/config/koneksi.php';

// Cek ID Transaksi
if (isset($_GET['id_transaksi'])) {
    $id_transaksi = mysqli_real_escape_string($conn, $_GET['id_transaksi']);
    $tgl_sekarang = date('Y-m-d');

    $sql = "UPDATE transaksi SET status = 'kembali', tgl_kembali = '$tgl_sekarang' WHERE id = '$id_transaksi'";

    if (mysqli_query($conn, $sql)) {
        $status = "success";
        $pesan = "Buku berhasil dikembalikan pada $tgl_sekarang";
        $judul = "Berhasil!";
    } else {
        $status = "error";
        $pesan = "Gagal mengupdate data: " . mysqli_error($conn);
        $judul = "Gagal!";
    }
} else {
    $status = "warning";
    $pesan = "ID Transaksi tidak ditemukan!";
    $judul = "Oops!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Pengembalian...</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7f6; }
    </style>
</head>
<body>

    <script>
        Swal.fire({
            title: '<?php echo $judul; ?>',
            text: '<?php echo $pesan; ?>',
            icon: '<?php echo $status; ?>',
            timer: 2500, // Pop-up hilang otomatis dalam 2.5 detik
            showConfirmButton: true,
            confirmButtonColor: '#3085d6'
        }).then(() => {
            // Setelah pop-up hilang/diklik, langsung pindah halaman
            window.location.href = 'beranda_siswa.php';
        });
    </script>

</body>
</html>