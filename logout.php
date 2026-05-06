<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out... | E-Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fcfaf8; /* Warna krem halus sesuai tema bento */
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        /* Menyamakan gaya Pop-up dengan elemen Bento Card */
        .swal2-popup {
            border-radius: 24px !important;
            padding: 2.5rem !important;
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 60px rgba(44, 33, 25, 0.1) !important;
            border: 1px solid rgba(0,0,0,0.05) !important;
        }

        .swal2-title {
            font-weight: 800 !important;
            color: #2c2119 !important; /* Warna cokelat utama */
            letter-spacing: -1px;
            font-size: 1.8rem !important;
        }

        .swal2-html-container {
            color: #6c757d !important;
            font-weight: 500 !important;
        }

        .swal2-confirm {
            background-color: #2c2119 !important; /* Warna tombol Simpan Perubahan */
            border-radius: 15px !important;
            padding: 12px 35px !important;
            font-weight: 700 !important;
            font-size: 1rem !important;
            box-shadow: 0 10px 20px rgba(44, 33, 25, 0.2) !important;
        }

        /* Gaya Icon Success agar lebih estetik */
        .swal2-icon.swal2-success {
            border-color: #e2c7b0 !important;
        }
        .swal2-icon.swal2-success [class^=swal2-success-line] {
            background-color: #6b4f3b !important;
        }
        .swal2-icon.swal2-success .swal2-success-ring {
            border: 4px solid rgba(226, 199, 176, 0.3) !important;
        }
    </style>
</head>
<body>

    <script>
        // Menampilkan Pop-up modern sebelum redirect
        Swal.fire({
            title: 'Berhasil Keluar!',
            text: 'Sesi Anda telah berakhir. Sampai jumpa kembali!',
            icon: 'success',
            confirmButtonText: 'Kembali ke Login',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showClass: {
                popup: 'animate__animated animate__fadeInUp'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'login.php';
            }
        });
    </script>
</body>
</html>