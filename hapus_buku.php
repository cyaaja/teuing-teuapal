<?php
session_start();
// Proteksi halaman
if (!isset($_SESSION["status"])) {
    header("Location: login.php");
    exit();
}

require_once 'config/koneksi.php';

// Header standar untuk menyisipkan styling SweetAlert2 agar terlihat keren saat proses
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfaf8; }
        .swal2-popup { border-radius: 24px !important; }
        .swal2-confirm { background-color: #2c2119 !important; border-radius: 12px !important; padding: 12px 30px !important; }
    </style>
</head>
<body>

<?php
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Query Hapus
    $query = "DELETE FROM buku WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        // Pop up keren saat berhasil
        echo "<script>
            Swal.fire({
                title: 'Terhapus!',
                text: 'Data buku telah berhasil dihapus dari koleksi.',
                icon: 'success',
                confirmButtonText: 'Selesai',
                confirmButtonColor: '#2c2119'
            }).then((result) => {
                window.location.href = 'buku.php';
            });
        </script>";
    } else {
        // Pop up keren saat gagal
        $error_msg = mysqli_error($conn);
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Terjadi kesalahan: " . addslashes($error_msg) . "',
                icon: 'error',
                confirmButtonText: 'Kembali',
                confirmButtonColor: '#e74c3c'
            }).then((result) => {
                window.location.href = 'buku.php';
            });
        </script>";
    }
} else {
    header("Location: buku.php");
    exit();
}
?>
</body>
</html>