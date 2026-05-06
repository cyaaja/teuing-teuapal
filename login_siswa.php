<?php
session_start();
if (isset($_SESSION['status']) && $_SESSION['status'] == "login_siswa") {
    header("location:beranda_siswa.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | LibSpace Estetik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --glass-bg: rgba(255, 255, 255, 0.85);
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            margin: 0;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh;
            background: #f0f2f5;
            /* Background Estetik dengan Animasi Cahaya */
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(168, 85, 247, 0.15) 0px, transparent 50%);
            overflow: hidden;
        }

        /* Ornamen Dekoratif di Latar Belakang */
        .shape {
            position: absolute;
            z-index: -1;
            filter: blur(80px);
            border-radius: 50%;
        }
        .shape-1 { width: 300px; height: 300px; background: #6366f1; top: -100px; right: -50px; opacity: 0.3; }
        .shape-2 { width: 400px; height: 400px; background: #a855f7; bottom: -150px; left: -100px; opacity: 0.2; }

        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 35px;
            padding: 50px 40px;
            width: 100%;
            max-width: 440px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .brand-logo-wrapper {
            width: 85px;
            height: 85px;
            background: var(--primary-gradient);
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            box-shadow: 0 15px 30px rgba(99, 102, 241, 0.3);
            transform: rotate(-10deg);
        }

        .brand-logo-wrapper i {
            color: white;
            font-size: 2.2rem;
            transform: rotate(10deg);
        }

        h2 { color: #1e293b; font-weight: 800; letter-spacing: -1px; }
        .text-muted { font-size: 0.9rem; }

        .form-label {
            font-weight: 600;
            color: #475569;
            font-size: 0.85rem;
            margin-left: 5px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 25px;
        }

        .form-control {
            background: rgba(241, 245, 249, 0.7) !important;
            border: 2px solid transparent;
            padding: 15px 20px 15px 55px;
            border-radius: 18px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            background: #fff !important;
            border-color: #6366f1;
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.1);
            outline: none;
        }

        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.1rem;
            transition: 0.3s;
            z-index: 10;
        }

        .form-control:focus + .input-icon {
            color: #6366f1;
        }

        .btn-login {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 18px;
            font-weight: 700;
            width: 100%;
            font-size: 1rem;
            transition: 0.4s;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(99, 102, 241, 0.4);
            filter: brightness(1.1);
        }

        .alert {
            border-radius: 15px;
            font-size: 0.85rem;
            border: none;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
        }

        .footer-link {
            text-decoration: none;
            color: #64748b;
            font-weight: 600;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .footer-link:hover { color: #6366f1; }
        
        .divider {
            height: 1px;
            background: rgba(0,0,0,0.05);
            margin: 30px 0;
        }
    </style>
</head>
<body>

<div class="shape shape-1"></div>
<div class="shape shape-2"></div>

<div class="login-card">
    <div class="text-center mb-5">
        <div class="brand-logo-wrapper">
            <i class="fas fa-book-reader"></i>
        </div>
        <h2>LibSpace</h2>
        <p class="text-muted">Akses literasi digital dalam genggaman</p>
    </div>

    <?php 
    if(isset($_GET['pesan'])){
        if($_GET['pesan'] == "gagal"){
            echo "<div class='alert alert-danger text-center text-danger mb-4'><i class='fas fa-exclamation-circle me-2'></i>Akses ditolak. Periksa kembali data anda.</div>";
        } else if($_GET['pesan'] == "logout"){
            echo "<div class='alert alert-success text-center text-success mb-4'><i class='fas fa-check-circle me-2'></i>Sesi berakhir. Sampai jumpa kembali!</div>";
        }
    }
    ?>

    <form action="cek_login_siswa.php" method="post" autocomplete="off">
        <div class="mb-3">
            <label class="form-label">ID Siswa / NISN</label>
            <div class="input-group-custom">
                <i class="fas fa-fingerprint input-icon"></i>
                <input type="text" name="username" class="form-control" placeholder="Masukkan ID anda" required autocomplete="off">
            </div>
        </div>
        
        <div class="mb-4">
            <label class="form-label">Kata Sandi</label>
            <div class="input-group-custom">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="new-password">
            </div>
        </div>

        <button type="submit" class="btn-login">Masuk ke Perpustakaan</button>
    </form>

    <div class="divider"></div>

    <div class="text-center">
        <p class="small text-muted mb-3">Belum memiliki akun? <a href="daftar.php" class="text-decoration-none fw-bold text-primary">Daftar Akun</a></p>
    </div>
</div>

</body>
</html>